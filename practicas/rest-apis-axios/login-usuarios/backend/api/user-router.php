<?php
    session_start();
    header("Content-Type: application/json");

    if (!isset($_SESSION['ID_USUARIO']) && !isset($_SESSION["NOMBRE_USUARIO"]) && !isset($_SESSION["EMAIL_USUARIO"]) && !isset($_SESSION['token'])) {
        $toJson = array("mensaje" => "acceso no autorizado");
        $jsonToString = json_encode($toJson);
        echo $jsonToString;
        exit();
    }
    if (!isset($_COOKIE['token'])) {
        $toJson = array("mensaje" => "acceso no autorizado");
        $jsonToString = json_encode($toJson);
        echo $jsonToString;
        exit();
    }
    if ($_SESSION['token'] != $_COOKIE['token']) {
        $toJson = array("mensaje" => "acceso no autorizado");
        $jsonToString = json_encode($toJson);
        echo $jsonToString;
        exit();
    }


    switch ($_SERVER["REQUEST_METHOD"]) {
    case 'GET':
        require_once("../models/db-connection.php");
        $viewRoleUser = $connection->prepare("SELECT ID_USUARIO , ID_CARGO FROM TBL_USUARIOS WHERE ID_USUARIO = :idUsuario");
        $viewRoleUser->bindParam(':idUsuario' , $_SESSION['ID_USUARIO']);
        $viewRoleUser->execute();
        $res = $viewRoleUser->fetch(PDO::FETCH_ASSOC);
        $toJson = array();
        if ($res['ID_CARGO'] == 1) {
            $viewUsers = $connection->prepare("SELECT ID_USUARIO , NOMBRE_USUARIO , APELLIDO_USUARIO , EMAIL_USUARIO FROM TBL_USUARIOS");
            $viewUsers->execute();
            $toJson = array();
            $data = $viewUsers->fetchAll(PDO::FETCH_ASSOC);
            foreach ($data as $row) { // OJO AQUI AL ARRAY SI NO SOLO ACEPTA EL ULTIMO REGISTRO SI NO SE PONE $toJson[]
                $toJson[] = array(
                    "codigoUser" => 1 ,
                    "idUsuario" => $row['ID_USUARIO'] , 
                    "nombreUsuario" => $row['NOMBRE_USUARIO'] , 
                    "apellidoUsuario" => $row['APELLIDO_USUARIO'] , 
                    "emailUsuario" => $row['EMAIL_USUARIO'] 
                );
            }
            
            $jsonToString = json_encode($toJson);
            echo $jsonToString;
        } else {
            $toJson[] = array(
                "codigoUser" => 0,
                "mensaje" => "Usted no esta autorizado para ver esta informacion" ,
                "cargo" => "Empleado normal"
            );
            $jsonToString = json_encode($toJson);
            echo $jsonToString;
        }
        $connection = null;
        break;
        case 'DELETE':

        break;
        default: 
            $toJson = array("mensaje" => "opcion no valida");
            $jsonToString = json_encode($toJson);
            echo $jsonToString;
        break;
    }
?>