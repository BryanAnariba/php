<?php
    //                                           REST-API-USUARIOS -> EQUIVALENTE A CRUD

    // 1 - Guardar usuarios
    function guardarUsuario ($cargo , $nombreUsuario , $apellidoUsuario , $fechaNacimiento , $email , $password) {
        require_once("../model/conexion-db.php");

        // Primero hash al password
        $hashingPass = password_hash($password,PASSWORD_DEFAULT);

        // Creamos consulta
        $insert = "INSERT INTO TBL_USUARIOS(ID_CARGO , NOMBRE_USUARIO , APELLIDO_USUARIO , FECHA_NACIMIENTO , EMAIL_USUARIO , PASSWORD_USUARIO) VALUES (?,?,?,?,?,?);";

        // Preparamos para evitar posible inyeccion sql
        $result = mysqli_prepare($conexion , $insert);
        // Mandamos los parametros correctos para despues ejecutar y guardar
        $exito = mysqli_stmt_bind_param($result , "isssss" , $cargo , $nombreUsuario , $apellidoUsuario , 
        $fechaNacimiento , $email , $hashingPass);

        // Ejecutamos consulta preparada
        $exito = mysqli_stmt_execute($result);

        // Si tuvo exito que perare el json con mensaje de exito
        if ($exito) {
            $toJson = array(
                "mensaje" => "Usuario Insertado con exito" ,
                "Usuario" => $_POST["email"]
            ); 

            $jsonToString = json_encode($toJson);
            echo $jsonToString;
        } else { // Caso contrario
            $toJson = array(
                "Mensaje" => "Ocurrio un error en la insercion"
            );
            $jsonToString = json_encode($toJson);
            echo $jsonToString;
        }
        mysqli_close($conexion);
    }
    
    // 2 - Ver datos del usuario seleccionad
    function verUsuario ($id) {
        require_once("../model/conexion-db.php");
        $verUsuario = "SELECT A.ID_USUARIO , A.NOMBRE_USUARIO , A.APELLIDO_USUARIO , A.EMAIL_USUARIO , A.ID_CARGO , B.CARGO FROM TBL_USUARIOS A INNER JOIN TBL_CARGOS B ON (A.ID_CARGO = B.ID_CARGO) WHERE A.ID_USUARIO=?";

        //APLICANDO PROTECCION DE INYECCION SQL
        $resultado = mysqli_prepare($conexion , $verUsuario);

        // Parametro a filtrar $id -> ID_USUARIO
        $exito = mysqli_stmt_bind_param($resultado , "i" , $id);

        // Ejecutamos la consulta preparada
        $exito = mysqli_stmt_execute($resultado);

        // Si tuvo exito
        if ($exito) {
            $exito = mysqli_stmt_bind_result($resultado , $idUsuario , $nombreUsuario , $apellidoUsuario , $email , $idCargo , $cargo);
            while(($fila = mysqli_stmt_fetch($resultado))) {
                $toJson = array(
                    "IdUsuario" => $idUsuario ,
                    "nombreUsuario" => $nombreUsuario ,
                    "apellidoUsuario" => $apellidoUsuario ,
                    "emailUsuario" => $email ,
                    "IdCargo" => $idCargo ,
                    "cargo" => $cargo
                );
            }
            $jsonToString = json_encode($toJson);
            echo $jsonToString;
        } else {
            $toJson = array(
                "mensaje" => "Ocurrio un error en la consulta"
            );
            $jsonToString = json_encode($toJson);
            echo $jsonToString;
        }
        mysqli_stmt_close($resultado);
        mysqli_close($conexion);
    }

    // 3 - Ver usuarios
    function verUsuarios () {
        require_once("../model/conexion-db.php");
        $verUsuarios = "SELECT A.ID_USUARIO , A.NOMBRE_USUARIO , A.APELLIDO_USUARIO , A.EMAIL_USUARIO , A.ID_CARGO , B.CARGO FROM TBL_USUARIOS A INNER JOIN TBL_CARGOS B ON (A.ID_CARGO = B.ID_CARGO);";
        $exito = mysqli_query($conexion , $verUsuarios);
        if ($exito) {
            $toJson = array();
            while ($row = mysqli_fetch_array($exito , MYSQLI_ASSOC)) {
                $toJson[] = array(
                    "IdUsuario" => $row["ID_USUARIO"],
                    "nombreUsuario" => $row["NOMBRE_USUARIO"],
                    "apellidoUsuario" => $row["APELLIDO_USUARIO"],
                    "emailUsuario" => $row["EMAIL_USUARIO"],
                    "IdCargo" => $row["ID_CARGO"],
                    "cargo" => $row["CARGO"]
                );
            }
            $jsonToString = json_encode($toJson);
            echo $jsonToString;
        } else {
            $json = array(
                "mensaje" => "No hay resultados"
            );
            
            $jsonToString = json_encode($json);
            echo $jsonToString;
        }
        mysqli_close($conexion);
    }

     // 4 - Editar usuario
    function actualizarUsuario ($cargo , $nombreUsuario , $apellidoUsuario , $fechaNacimiento , $email , $id) {
        require_once("../model/conexion-db.php");
        $updateSQL = "UPDATE TBL_USUARIOS SET NOMBRE_USUARIO = ? , APELLIDO_USUARIO = ? , FECHA_NACIMIENTO = ? , EMAIL_USUARIO = ? , ID_CARGO = ? WHERE ID_USUARIO = ?";
        
        //APLICANDO PROTECCION DE INYECCION SQL
        $stmt = mysqli_prepare($conexion , $updateSQL);

        // Parametro a filtrar $id -> ID_USUARIO
        $binParam = mysqli_stmt_bind_param($stmt , "ssssii" , $nombreUsuario , $apellidoUsuario , $fechaNacimiento , $email , $cargo , $id);

        // Ejecutamos la consulta preparada
        $exito = mysqli_stmt_execute($stmt);

        if ($exito) {
            $toJson = array(
                "mensaje" => "Usuario Actualizado con exito" ,
                "Usuario" => $email
            ); 

            $jsonToString = json_encode($toJson);
            echo $jsonToString;
        } else { // Caso contrario
            $toJson = array(
                "Mensaje" => "Ocurrio un error en la actualizacion de la informacion"
            );
            $jsonToString = json_encode($toJson);
            echo $jsonToString;
        }
    }

    // 5 - Eliminar usuario
    function eliminarUsuario ($id) {
        require_once("../model/conexion-db.php");
        $deleteSQL = "DELETE FROM TBL_USUARIOS WHERE ID_USUARIO = ?";
        $stmt = mysqli_prepare($conexion , $deleteSQL);
        $exito = mysqli_stmt_bind_param($stmt , "i" , $id);
        $exito = mysqli_stmt_execute($stmt);

        if ($exito) {
            $toJson = array(
                "mensaje" => "Usuario Eliminado con exito"
            );
            $jsonToString = json_encode($toJson);
            echo $jsonToString;
        } else {
            $toJson = array(
                "mensaje" => "Ocurrio un error en la peticion de eliminacion"
            );
            $jsonToString = json_encode($toJson);
            echo $jsonToString;
        }
        mysqli_close($conexion);
    }   
?>