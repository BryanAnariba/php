<?php   
    header("Content-Type: aplication/json");
    
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
            $res = array();
            $res = array(
                'exito' => "Usuario Guardado con exito" ,
                'nombreUsuario' => $_POST['nombreUsuario']
            );
            echo json_encode($res);
        break;
        case "GET":
            if (isset($_GET['id'])) {
                $res = array();
                $res = array(
                    'identificador' => $_GET['id'] , 
                    'usuario'=> 'Nombre Usuario'
                );
                echo json_encode($res);
            } else {
                $res = array();
                $res = array(
                    'usuarios' => 'Obteniendo Usuarios'
                );
                echo json_encode($res);
            }
            
        break;
        case "PUT":
            $_PUT = json_decode(file_get_contents('php://input') , true);
            $res = array();
            $res = array(
                'identificador Usuario' => $_GET['id'] ,
                'informacion usuario' => $_PUT
            );
            echo json_encode($res);
        break;
        case "DELETE":
            $res = array();
            $res = array(
                'Eliminado' => $_GET['id']
            );
            echo json_encode($res);
        break;
        default: 
            echo "Opcion de peticion no valida de momento";
    break;
    }
?>