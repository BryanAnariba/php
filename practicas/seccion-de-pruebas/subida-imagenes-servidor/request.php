<?php
    header('Content-Type: application/json');
    require_once('Imagen.php');
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $imagen = new Imagen('usuarios');
        $imagen->setImagen($_FILES);
        subirImagen();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $imagen = new Imagen('usuarios');
        $ruta = $_POST['ruta'];
        $imagen->removerImagen($ruta);
    }