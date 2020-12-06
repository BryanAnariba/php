<?php
    header("Content-Type: aplication/json");
    require_once('../classes/User.php');
    require_once('../helpers/ResponseStatus.php');
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET': 
        break;
        case 'POST': 
            $_POST = json_decode(file_get_contents('php://input'), true);
            $user = new User();
            $user->setFirstName($_POST['firstName']);
            $user->setLastName($_POST['lastName']);
            $user->setGenderId($_POST['genderId']);
            $user->setRoleId($_POST['roleId']);
            $user->setEmailUser($_POST['emailUser']);
            $user->setPassUser($_POST['passUser']);
            $user->setAvatar((!empty($_POST['avatar']) ? $_POST['avatar'] : null));
            $user->saveUser();
        break;
        case 'PUT': 
        break;
        case 'DELETE': 
        break;
        default: 
            $responseStatus = new ResponseStatus(BAD_REQUEST, array('message'=> 'Tipo de peticion no valida'));
            return $responseStatus->responseData();
        break;
    }