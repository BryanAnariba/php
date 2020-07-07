<?php
    $hostname = "127.0.0.1:3306";
    $dbName = "tienda-virtual";
    $user = "root";
    $password = "root";

    $conexion = mysqli_connect($hostname , $user , $password);

    mysqli_select_db($conexion , $dbName) or die ("<center><h2 style='color:red'>Error -> Base de datos no encontrada.</h2></center>");

    if (mysqli_connect_errno()) {
        echo "<center><h2><strong>Error en la conexion de la base de datos.</strong></h2><enter>";
        exit();
    }

    mysqli_set_charset($conexion , "UTF8");
?>