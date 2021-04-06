<?php
    require_once('../database/Connection.php');
    class Category {
        // Parametros relacionados a la base de datos
        private $conn;
        private $query;
        private $table = 'categories';
        private $results;

        private $id;
        private $name;

        public function getId()
        {
            return $this->id;
        }

        public function setId($id)
        {
            $this->id = $id;
            return $this;
        }

        public function getName()
        {
            return $this->name;
        }

        public function setName($name) {
            $this->name = $name;
            return $this;
        }

        public function find () {
            $this->conn = new Connection();   
            $this->query = $this->conn->connect();
            try {
                
            } catch (PDOException $ex) {
                return array(
                    'status'=> INTERNAL_SERVER_ERROR,
                    'messages' => array($ex->getMessage())
                );
            } finally {
                $this->conn->closeConnection();
            }
        }

        public function findOne () {
            $this->conn = new Connection();   
            $this->query = $this->conn->connect();
            try {

            } catch (PDOException $ex) {
                return array(
                    'status'=> INTERNAL_SERVER_ERROR,
                    'messages' => array($ex->getMessage())
                );
            } finally {
                $this->conn->closeConnection();
            }
        }

        public function save () {
            $this->conn = new Connection();   
            $this->query = $this->conn->connect();
            try {
                
            } catch (PDOException $ex) {
                return array(
                    'status'=> INTERNAL_SERVER_ERROR,
                    'messages' => array($ex->getMessage())
                );
            } finally {
                $this->conn->closeConnection();
            }
        }

        public function updateOne () {
            $this->conn = new Connection();   
            $this->query = $this->conn->connect();
            try {

            } catch (PDOException $ex) {
                return array(
                    'status'=> INTERNAL_SERVER_ERROR,
                    'messages' => array($ex->getMessage())
                );
            } finally {
                $this->conn->closeConnection();
            }
        }

        public function deleteOne () {
            $this->conn = new Connection();   
            $this->query = $this->conn->connect();
            try {

            } catch (PDOException $ex) {
                return array(
                    'status'=> INTERNAL_SERVER_ERROR,
                    'messages' => array($ex->getMessage())
                );
            } finally {
                $this->conn->closeConnection();
            }
        }
    }