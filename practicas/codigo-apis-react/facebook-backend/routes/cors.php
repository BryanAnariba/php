<?php
    // Para realizar la conexion con angular o puede ser con react js tambien no importa solo cambias el puerto
    $authorizedServer = "http://localhost:4200";
    header("Access-Control-Allow-Origin: $authorizedServer");
    header("Access-Control-Allow-Headers: content-type");
    header("Access-Control-Allow-Methods: OPTIONS,GET,PUT,POST,DELETE");
?>