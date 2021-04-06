<?php
    header("Content-Type: application/json");
    include("../controllers/login-controller.php");

    /*
        Que servicios web necesito

        1 - Registrar un usuario
        2 - Loguear a un usuario
    */

    switch ($_SERVER["REQUEST_METHOD"]) {
        case 'POST':
            $_POST = json_decode(file_get_contents('php://input') , true);

            // SI al leer los parametros de envio solo viene esto
            if (isset($_POST['emailUsuario']) && isset($_POST['passwordUsuario'])) {

                // Instancia o ejemplar de clase
                $loginUser = new Usuario (null , null ,null , $_POST['emailUsuario'] , $_POST['passwordUsuario'] , null);

                // LLmamos al metodo que verifica credenciales
                $loginUser->verifyCredentials ();
            }

            // O tambien si al leer los parametros de envio solo viene esto
            if (isset($_POST['nombreUsuario']) && isset($_POST['apellidoUsuario']) && isset($_POST['fechaNacimiento']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['cargoUsuario'])) {

                // Instancia o ejemplar de clase
                $registerUser = new Usuario ($_POST['nombreUsuario'] , $_POST['apellidoUsuario'] , $_POST['fechaNacimiento'] , $_POST['email'] , $_POST['password'] , $_POST['cargoUsuario']);
                
                // Metodo que inserta el usuario
                $registerUser->userRegistered ();
            }
        break;
        default: 
            $toJson = array("mensaje" => "opcion no valida");
            $jsonToString = json_encode($toJson);
            echo $jsonToString;
        break;
    }
?>