<?php
    // Para conectar el server con cualquier framework javascript
    $HOST = "http://localhost";
    $PORT = 3000;
    header("Access-Control-Allow-Origin: $HOST:$PORT");
    header("Access-Control-Allow-Headers: content-type");
    header("Access-Control-Allow-Methods: OPTIONS,GET,PUT,POST,DELETE");
?>