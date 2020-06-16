<?php
    header("Content-Type: application/json");
    require_once("../controllers/controlador-usuarios.php");
    require_once("./cors.php");
    // Que servicios web necesito de usuarios
    /*
        1 - Insertar un nuevo usuario
        2 - Mostrar los usuarios
        3 - Informacion del usuario selecionado
    */

    switch ($_SERVER["REQUEST_METHOD"]) {
        case "POST":
            $_POST = json_decode(file_get_contents('php://input') , true);
            
            insertUser ($_POST["nombreUsuario"] , $_POST["apellidoUsuario"]);            
        break;
        case "GET":
            if (isset($_GET["idUsuario"])) {
                getUser ($_GET["idUsuario"]);
            } else {
                getUsers ();
            }
        break;
        default: 
            $arrayAssoc = array(
                "mensaje" => "Opcion invalida"
            );
            $arrayToJson = json_encode($arrayAssoc);
            echo $arrayToJson;
        break;
    }
?>