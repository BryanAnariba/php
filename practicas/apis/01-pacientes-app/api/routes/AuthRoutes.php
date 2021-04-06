<?php
    require_once('../classes/User.php');
    require_once('../classes/Auth.php');
    require_once('../helpers/ResponseStatus.php');
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST': 
            $_POST = json_decode(file_get_contents('php://input'), true);
            if (isset($_POST['emailUser']) && isset($_POST['passUser']) && !empty($_POST['emailUser']) && !empty($_POST['passUser'])) {
                $user = new User();
                $auth = new Auth($_POST['emailUser'],$_POST['passUser']);
                $auth->signIn();
            } else {
                $responseStatus = new ResponseStatus(BAD_REQUEST, array('message' => 'Los campos son obligatorios'));
                return json_encode($responseStatus->responseData());
            }
        break;
        default: 
            $responseStatus = new ResponseStatus(BAD_REQUEST, array('message' => 'El metodo no existe'));
            return json_encode($responseStatus->responseData());
        break;
    }