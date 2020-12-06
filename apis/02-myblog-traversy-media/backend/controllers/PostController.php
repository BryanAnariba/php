<?php
    require_once('../helpers/Response.php');
    require_once('../models/Post.php');
    class PostController {
        private $data;
        private $PostModel;
        public function __construct() {
            $this->PostModel = new Post();
        }
        public function getPosts () {
            $this->data = $this->PostModel->find();
            $_Response = new Response($this->data);
            $_Response->responseData();
        }

        public function getPostById ($postId) {
            $this->PostModel->setId($postId);
            $this->data = $this->PostModel->findOne();
            $_Response = new Response($this->data);
            $_Response->responseData();
        }
        public function notValidRequest () {
            $_Response = new Response(array('message' => 'El tipo de peticion no esta permitida'));
            $_Response->responseData();
        }
    }