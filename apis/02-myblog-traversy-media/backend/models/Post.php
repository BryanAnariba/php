<?php
    require_once('../database/Connection.php');
    class Post {
        // Parametros relacionados a la base de datos
        private $conn;
        private $query;
        private $table = 'posts';
        private $results;

        // Propiedades la clase Post
        private $id;
        private $category_id;
        private $category_name;
        private $title;
        private $body;
        private $author;
        private $created_at;

        // Constructor with DB
        public function __construct() {
            $this->conn = new Connection();   
            $this->query = $this->conn->connect();
        }

        public function getId() {
            return $this->id;
        }

        public function setId($id) {
            $this->id = $id;
            return $this;
        }

        public function find () {
            try {
                $stmt = $this->query->prepare(
                'SELECT 
                    name,
                    categories.id,
                    ' . $this->table . '.category_id,
                    title,
                    body,
                    author,
                    ' . $this->table . '.created_at
                FROM ' . $this->table . ' LEFT JOIN categories  
                ON(' . $this->table . '.category_id = categories.id) ORDER BY ' . $this->table . '.created_at DESC');
                $this->results = $stmt->execute();
                if ($this->results) {
                    return array(
                        'status'=> SUCCESS_REQUEST, 
                        'messages' => $stmt->fetchAll(PDO::FETCH_OBJ)
                    );
                } else {
                    return array(
                        'status'=> BAD_REQUEST,
                        'messages' => array('Ha ocurrido un error')
                    );
                }
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
            try {
                $stmt = $this->query->prepare(
                    'SELECT 
                        name,
                        categories.id,
                        ' . $this->table . '.category_id,
                        title,
                        body,
                        author,
                        ' . $this->table . '.created_at
                    FROM ' . $this->table . ' LEFT JOIN categories  
                    ON(' . $this->table . '.category_id = categories.id) WHERE ' . $this->table . '.id = :postId');
                    $stmt->bindValue(':postId', $this->id);
                    $this->results = $stmt->execute();
                    if ($this->results) {
                        return array(
                            'status'=> SUCCESS_REQUEST, 
                            'messages' => $stmt->fetchAll(PDO::FETCH_OBJ)
                        );
                    } else {
                        return array(
                            'status'=> BAD_REQUEST,
                            'messages' => array('Ha ocurrido un error')
                        );
                    }
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