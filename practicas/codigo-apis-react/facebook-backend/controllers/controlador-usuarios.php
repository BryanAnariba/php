<?php

    // 1 - Insertar un nuevo usuario
    function insertUser ($nombreUsuario , $apellidoUsuario) {
        require_once("../models/db-connection.php");
        $insertQuery = "INSERT INTO TBL_USUARIOS (NOMBRE_USUARIO , APELLIDO_USUARIO) VALUES (?,?);";
        $preparaQuery = mysqli_prepare($conexion , $insertQuery);

        $exitoQuery = mysqli_stmt_bind_param($preparaQuery , "ss" , $nombreUsuario , $apellidoUsuario);
            
        $exitoQuery = mysqli_stmt_execute($preparaQuery);

        if ($exitoQuery) {
            $arrayAssoc = array(
                "codigoRes" => 1 , 
                "mensaje" => "El usuario " . $_POST["nombreUsuario"] . " fue insertado con exito."
            );

            $arrayToJson = json_encode($arrayAssoc);
            echo $arrayToJson;
        } else {
            $arrayAssoc = array(
                "codigoRes" => 0 ,
                "mensaje" => "Ha ocurrido un error en la insercion"
            );
            $arrayToJson = json_encode($arrayAssoc);
            echo $arrayToJson;
        }
        mysqli_close($conexion);
    }

    // 3 - Informacion del usuario selecionado
    function getUser ($idUsuario) {
        require_once("../models/db-connection.php");
        $getUser = "SELECT ID_USUARIO , NOMBRE_USUARIO , APELLIDO_USUARIO FROM TBL_USUARIOS WHERE ID_USUARIO = ?";
        $preparaQuery = mysqli_prepare($conexion , $getUser);

        $exitoQuery = mysqli_stmt_bind_param($preparaQuery , "i" , $idUsuario);
        $exitoQuery = mysqli_stmt_execute($preparaQuery);

        if ($exitoQuery) {
            $exitoQuery = mysqli_stmt_bind_result($preparaQuery , $idUsuario , $nombreUsuario , $apellidoUsuario);
            while ($row = mysqli_stmt_fetch($preparaQuery)) {
                $arrayAssoc = array(
                    "idUsuario" => $idUsuario ,
                    "nombreUsuario" => $nombreUsuario ,
                    "apellidoUsuario" => $apellidoUsuario
                );
            }
            $arrayToJson = json_encode($arrayAssoc);
            echo $arrayToJson;
        } else {
            $arrayAssoc = array(
                "mensaje" => "Usuario no encontrado"
            );
            $arrayToJson = json_encode($arrayAssoc);
            echo $arrayToJson;
        }
        mysqli_close($conexion);
    }

    // 2 - Mostrar los usuarios
    function getUsers () {
        require_once("../models/db-connection.php");
        $getUsers = "SELECT ID_USUARIO ,  NOMBRE_USUARIO , APELLIDO_USUARIO FROM TBL_USUARIOS;";
        $preparaQuery = mysqli_prepare($conexion , $getUsers);
        $exitoQuery = mysqli_stmt_execute($preparaQuery);
        $exitoQuery =  mysqli_stmt_bind_result($preparaQuery , $idUsuario , $nombreUsuario , $apellidoUsuario);

        if ($exitoQuery) {
            while (mysqli_stmt_fetch($preparaQuery)) {
                $arrayAssoc[] = array(
                    "idUsuario" => $idUsuario ,
                    "nombreUsuario" => $nombreUsuario ,
                    "apellidoUsuario" => $apellidoUsuario
                );
            }
            $arrayToJson = json_encode($arrayAssoc);
            echo $arrayToJson;
        }
        mysqli_close($conexion);
    }

?>