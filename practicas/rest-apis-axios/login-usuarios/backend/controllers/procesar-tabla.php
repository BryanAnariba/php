<?php
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
                "<tr style='color:black; font-weight:bold;'>
                    <td>" . $row['ID_USUARIO'] . "</td>
                    <td>" . $row['NOMBRE_USUARIO'] . "</td>
                    <td>" . $row['APELLIDO_USUARIO'] . "</td>
                    <td>" . $row['EMAIL_USUARIO'] . "</td>
                </tr>";
            }
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
?>