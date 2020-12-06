<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    require_once('../controllers/PostController.php');

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            if (isset($_GET['id']) && !empty($_GET['id'])) {
                $postCTRL = new PostController();
                $postCTRL->getPostById($_GET['id']);
            } else {
                $postCTRL = new PostController();
                $postCTRL->getPosts();
            }
        break;
        case 'POST': 
        break;
        case 'PUT': 
        break;
        case 'DELETE': 
        break;
        default: 
            $postCTRL = new PostController();
            $postCTRL->notValidRequest();
        break;
    }