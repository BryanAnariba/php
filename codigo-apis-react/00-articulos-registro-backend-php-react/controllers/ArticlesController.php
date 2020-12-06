<?php
    include_once('../models/ArticlesModel.php');
    class ArticleController {
        private $articleModel;
        
        public function __construct() {
            $this->articleModel = new ArticleModel();
        }

        // Crud Operations

        public function getArticles () {

        }

        public function getArticleById () {

        }

        public function editArticleById () {

        }

        public function deleteArticleById () {

        }
    }
?>