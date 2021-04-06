<?php
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
    require_once('../controllers/PostController.php');

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            if (isset($_GET['postId']) && !empty($_GET['postId'])) {
                $postCTRL = new PostController();
                $postCTRL->getPostById($_GET['postId']);
            } else {
                $postCTRL = new PostController();
                $postCTRL->getPosts();
            }
        break;
        case 'POST': 
            $_POST = json_decode(file_get_contents('php://input'), true);
            $postCTRL = new PostController();
            $postCTRL->savePost($_POST);
        break;
        case 'PUT': 
            if (isset($_GET['postId']) && !empty($_GET['postId'])) {
                $_PUT = json_decode(file_get_contents('php://input'), true);
                $postCTRL = new PostController();
                $postCTRL->updatePost($_PUT, $_GET['postId']);
            } else {
                $postCTRL = new PostController();
                $postCTRL->notValidRequest();
            }
        break;
        case 'DELETE': 
            if (isset($_GET['postId']) && !empty($_GET['postId'])) {
                $_PUT = json_decode(file_get_contents('php://input'), true);
                $postCTRL = new PostController();
                $postCTRL->deletePost($_GET['postId']);
            } else {
                $postCTRL = new PostController();
                $postCTRL->notValidRequest();
            }
        break;
        default: 
            $postCTRL = new PostController();
            $postCTRL->notValidRequest();
        break;
    }