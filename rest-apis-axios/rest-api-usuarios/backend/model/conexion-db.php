<?php
    $host = 'localhost:3307';
    $dbName = 'rest-api-usuarios';
    $user = 'root';
    $passUser = 'root';

    $conexion = mysqli_connect($host , $user , $passUser);

    //si ocurre un error al seleccionar la base de datos
    mysqli_select_db($conexion , $dbName) or die ("<center><h2 style='color:red'>Error -> Data Base Not Found.</h2></center>");

    //si se produce un error al conectar que notifique y cierre la conexion
    if(mysqli_connect_errno()) {
        echo "<center><h2><strong>Error in Data Base No Connected.</strong></h2><enter>";
        exit();
    }

    mysqli_set_charset($conexion,"UTF8");
?>
