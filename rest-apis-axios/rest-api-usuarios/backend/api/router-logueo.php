<?php
    header("Content-Type: aplication/json");
    
    //6 - logueo de un usuario
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            $_POST = json_decode(file_get_contents('php://input') , true);
            echo json_encode($_POST);
        break;
    }
?>