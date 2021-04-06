<?php
    header("Content-Type: aplication/json");
    require_once('../classes/Gender.php');
    require_once('../helpers/ResponseStatus.php');
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET': 
            $genderId = 'genderId';
            $sanitizedId = filter_input(INPUT_GET, $genderId , FILTER_SANITIZE_NUMBER_INT);
            if (isset($_GET) && !empty($_GET) && ($_GET != $sanitizedId)) {
                if ($sanitizedId != null) {
                    $gender = new Gender($sanitizedId);
                    $gender->getGenderById();
                    //echo json_encode($_GET);
                } else {
                    if ($sanitizedId == null) {
                        $responseStatus = new ResponseStatus(BAD_REQUEST, array('message'=> 'Tipo de peticion no valida'));
                        return $responseStatus->responseData();
                    }
                }
            } else {
                $gender = new Gender();
                $gender->getGenders();
            }
        break;
        case 'POST': 
            $_POST = json_decode(file_get_contents('php://input'), true);
            $gender = new Gender();
            $gender->setGender($_POST['gender']);
            $gender->setAbrev($_POST['abrev']);
            $gender->saveGender();
        break;
        case 'PUT': 
            $_PUT = json_decode(file_get_contents('php://input'), true);
            $genderId = 'genderId';
            $sanitizedId = filter_input(INPUT_GET, $genderId , FILTER_SANITIZE_NUMBER_INT);
            if (isset($_GET) && !empty($_GET) && ($_GET != $sanitizedId)) {
                if ($sanitizedId != null) {
                    $gender = new Gender($sanitizedId);
                    $gender->setGender($_PUT['gender']);
                    $gender->setAbrev($_PUT['abrev']);
                    $gender->editGenderById();
                } else {
                    if ($sanitizedId == null) {
                        $responseStatus = new ResponseStatus(BAD_REQUEST, array('message'=> 'Tipo de peticion no valida'));
                        return $responseStatus->responseData();
                    }
                }
            } else {
                $gender = new Gender();
                $gender->getGenders();
            }
        break;
        case 'DELETE':
            $genderId = 'genderId';
            $sanitizedId = filter_input(INPUT_GET, $genderId , FILTER_SANITIZE_NUMBER_INT);
            if (isset($_GET) && !empty($_GET) && ($_GET != $sanitizedId)) {
                if ($sanitizedId != null) {
                    $gender = new Gender($sanitizedId);
                    $gender->deleteGenderById();
                    //echo json_encode($_GET);
                } else {
                    if ($sanitizedId == null) {
                        $responseStatus = new ResponseStatus(BAD_REQUEST, array('message'=> 'Tipo de peticion no valida'));
                        return $responseStatus->responseData();
                    }
                }
            } else {
                $gender = new Gender();
                $gender->getGenders();
            }
        break;
        default: 
            $responseStatus = new ResponseStatus(BAD_REQUEST, array('message'=> 'Tipo de peticion no valida'));
            return $responseStatus->responseData();
        break;
    }