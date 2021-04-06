<?php
    include_once('../database/connection.php');
    class ArticleModel {
        private $db;
        private $query;
        private $articlesData;

        public function __construct () {
            $this->db = new Connection();
            $this->query = $this->db->connectMe();
        }

        public function selectArticlesQuery () {

        }

        public function selectArticleQuery () {

        }

        public function updateArticleQuery () {

        }

        public function deleteArticleQuery () {

        }
    }
?>