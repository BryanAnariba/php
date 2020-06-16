<?php
    header("Content-Type: application/json");
    require_once("../controllers/comments-controller.php");
    require_once("./cors.php");

    /*
        Que servicios de comentarios necesito
        1 - Insertar un comentario con el id de un usuario
        2 - Mostrar comentarios de un usuario seleccionado
        3 - Borrar Comentarios
    */

    switch ($_SERVER["REQUEST_METHOD"]) {
        case "POST":
            // idUsuario , comentario , fechaHoraComentario
            $_POST = json_decode(file_get_contents("php://input") , true);
            insertComment($_GET["idUsuario"] , $_POST["comentario"]);
        break;
        case "GET":
            if (isset($_GET["idUser"])) {
                viewComments ($_GET["idUser"]);
            } else {
                $arrayAssoc = array("codigoRes" => 0 , "mensaje" => "No se pueden ver comentarios");
            }
        break;
        case "DELETE":
            if (isset($_GET["idUsuario"]) && isset($_GET["idComentario"])) {
                deleteComment ($_GET["idUsuario"] , $_GET["idComentario"]);
            } else {
                $arrayAssoc = array("codigoRes" => 0 , "mensaje" => "No se pueden eliminar los comentarios");
            }
        break;
        default:
            $arrayAssoc = array("codigoRes"=> 0 , "mensaje" => "Opcion invalida");
            $arrayToJson = json_encode($arrayToJson);
            echo $arrayToJson;
        break;
    }
?>