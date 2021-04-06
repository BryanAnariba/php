<?php   
    header('Content-Type: application/json');
    require_once('Email.php');
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $newEmail = new Email();
        if (isset($_POST['name']) && isset($_POST['emailDestino'])) {
            $newEmail->sendEmail($_POST);
        } else {
            echo json_encode('ups');
        }
        
    }