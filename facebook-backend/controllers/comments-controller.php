<?php
    function insertComment ($idUsuario , $comentario) {
        require_once("../models/db-connection.php");
        $insertQuery = "INSERT INTO TB_COMENTARIOS (ID_USUARIO , COMENTARIO , FECHA_HORA_COMENTARIO) VALUES (?,?, NOW());";
        $prepareQuery = mysqli_prepare($conexion , $insertQuery);
        $exitoQuery = mysqli_stmt_bind_param($prepareQuery , "is" , $idUsuario , $comentario);
        $exitoQuery = mysqli_stmt_execute($prepareQuery);

        if ($exitoQuery) { 
            $arrayAssoc = array("codigoRes"=> 1 , "mensaje" => "Publicado con exito");
            $arrayToJson = json_encode($arrayAssoc);
            echo $arrayToJson;
        } else {
            $arrayAssoc = array("codigoRes"=> 0 , "mensaje" => "Ha Ocurrido un Error");
            $arrayToJson = json_encode($arrayAssoc);
            echo $arrayToJson;
        }
        mysqli_close($conexion);
    }

    function viewComments ($idUsuario) { 
        require_once("../models/db-connection.php");
        $viewQuery = "SELECT B.ID_USUARIO , B.NOMBRE_USUARIO , B.APELLIDO_USUARIO , A.ID_COMENTARIOS , A.COMENTARIO , A.FECHA_HORA_COMENTARIO FROM TB_COMENTARIOS A LEFT JOIN TBL_USUARIOS B ON (A.ID_USUARIO = B.ID_USUARIO) WHERE A.ID_USUARIO = ?;";
        $prepareQuery = mysqli_prepare($conexion , $viewQuery);
        $exitoQuery = mysqli_stmt_bind_param($prepareQuery , "i" , $idUsuario);
        $exitoQuery = mysqli_stmt_execute($prepareQuery);

        if ($exitoQuery) {
            $exitoQuery = mysqli_stmt_bind_result($prepareQuery , $idUsuario , $nombreUsuario , $apellidoUsuario , $idComentario , $comentario , $fechaHoraComentario);

            while ($row = mysqli_stmt_fetch($prepareQuery)) {
                $arrayAssoc[] = array(
                    "idUsuario" => $idUsuario ,
                    "nombreUsuario" => $nombreUsuario ,
                    "apellidoUsuario" => $apellidoUsuario ,
                    "idComentario" => $idComentario ,
                    "comentario" => $comentario ,
                    "fechaHoraComentario" => $fechaHoraComentario
                ); 
            }

            $arrayToJson = json_encode($arrayAssoc);
            echo $arrayToJson;
            mysqli_close($conexion);
        }
    }

    function deleteComment ($idUsuario , $idComentario) {
        require_once("../models/db-connection.php");
        $deleteQuery = "DELETE FROM TB_COMENTARIOS WHERE ID_USUARIO = ? AND ID_COMENTARIOS = ?;";
        $prepareQuery = mysqli_prepare($conexion , $deleteQuery);
        $exitoQuery = mysqli_stmt_bind_param($prepareQuery, "ii" , $idUsuario , $idComentario);
        $exitoQuery = mysqli_stmt_execute($prepareQuery);

        if ($exitoQuery) {
            $arrayAssoc = array("codigoRes" => 1 , "mensaje" => "Comentario eliminado con exito");
            $arrayToJson = json_encode($arrayAssoc);
            echo $arrayToJson;
        } else {
            $arrayAssoc = array("codigoRes" => 0 , "mensahe" => "No se pudo eliminar el comentario");
            $arrayToJson = json_encode($arrayAssoc);
            echo $arrayToJson;
        }
        mysqli_close($conexion);
    }
?>