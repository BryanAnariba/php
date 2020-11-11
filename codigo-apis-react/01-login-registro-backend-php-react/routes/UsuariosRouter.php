<?php
    header('Content-Type: application/json');

    // echo "<h2>Metodo http que pide el cliente " . $_SERVER['REQUEST_METHOD'] . "</h2>";
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET': 
            if (isset($_GET['idUsuario']) && !empty($_GET['idUsuario'])) {
                $res = array("status" => true);
                echo json_encode($res);
            } else {
                $res = array(
                    "status" => true,
                    "message" => "retornando todos los usuarios"
                );
                echo json_encode($res);
            }
        break;
        case 'POST':
            $_POST = json_decode(file_get_contents('php://input'), true);
        break;
        case 'PUT': 
            $_PUT = json_decode(file_get_contents('php://input'), true);
        break;
        case 'DELETE':
            if (isset($_GET['idUsuario']) && !empty($_GET['idUsuario'])) {
                $res = array("status" => true);
                echo json_encode($res);
            } else {
                $res = array(
                    "status" => false,
                    "message" => "Para realizar esta peticion debe incluir el parametro idUsuario"
                );
                echo json_encode($res);
            }
        break;
        default: 
            $res = array("status" => false, "message" => "El metodo de peticion no es valido");
            echo json_encode($res);
        break;
    }
?>