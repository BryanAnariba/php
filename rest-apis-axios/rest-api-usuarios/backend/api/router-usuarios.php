<?php   
    header("Content-Type: aplication/json");
    include("../controllers/usuarios-controller.php");
    
    // Que servicios web necesito
    /* 
        1 - Guardar usuarios
        2 - Ver datos del usuario seleccionado
        3 - Ver usuarios
        4 - Editar usuario
        5 - Eliminar usuario
        6 - logueo de un usuario
    */

    // Para ver el tipo de peticion que hace un usuario
    //echo "Metodo Http -> " . $_SERVER['REQUEST_METHOD'];

    //echo 'Data del frontend json pasado a texto normal -> ' . file_get_contents('php://input');

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            $_POST = json_decode(file_get_contents('php://input') , true);
            guardarUsuario ($_POST["cargo"] , $_POST["nombreUsuario"] , $_POST["apellidoUsuario"] , $_POST["fechaNacimiento"] , $_POST["email"] , $_POST["password"]);
        break;
        case 'GET':
            if (isset($_GET['id'])) {
                verUsuario ($_GET['id']);
            } else {
                verUsuarios ();
            }
            
            
        break;
        case "PUT":
            $_PUT = json_decode(file_get_contents('php://input') , true);
            actualizarUsuario ($_PUT["cargo"] , $_PUT["nombreUsuario"] , $_PUT["apellidoUsuario"] , $_PUT["fechaNacimiento"] , $_PUT["email"] , $_GET['id']);
        break;
        case "DELETE":
            eliminarUsuario ($_GET['id']);
        break;
        default: 
            echo "Opcion de peticion no valida de momento";
    break;
    }
?>