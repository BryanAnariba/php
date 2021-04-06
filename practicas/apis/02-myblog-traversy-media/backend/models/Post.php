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
        private $title;
        private $body;
        private $author;
        private $created_at;

        // Constructor with DB
        public function __construct() {
            
        }

        public function getId() {
            return $this->id;
        }

        public function setId($id) {
            $this->id = $id;
            return $this;
        }

        public function getTitle() {
            return $this->title;
        }

        public function setTitle($title) {
            $this->title = $title;
            return $this;
        }

        public function getBody() {
            return $this->body;
        }

        public function setBody($body) {
            $this->body = $body;
            return $this;
        }

        public function getAuthor() {
            return $this->author;
        }

        public function setAuthor($author) {
            $this->author = $author;
            return $this;
        }

        public function getCategory_id() {
            return $this->category_id;
        }

        public function setCategory_id($category_id) {
            $this->category_id = $category_id;
            return $this;
        }
        public function find () {
            $this->conn = new Connection();   
            $this->query = $this->conn->connect();
            try {
                $stmt = $this->query->prepare(
                'SELECT 
                    name,
                    ' . $this->table . '.id,
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
            $this->conn = new Connection();   
            $this->query = $this->conn->connect();
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
        
        public function save () {
            $this->conn = new Connection();   
            $this->query = $this->conn->connect();
            try {
                $stmt = $this->query->prepare('INSERT INTO ' . 
                $this->table . '(title, body, author, category_id) VALUES (:title, :body, :author, :category_id)');

                // Binding params in stmt prepare
                $stmt->bindValue(':title', $this->title);
                $stmt->bindValue(':body', $this->body);
                $stmt->bindValue(':author', $this->author);
                $stmt->bindValue(':category_id', $this->category_id);

                // Execute
                $this->results = $stmt->execute();
                if (($this->results ==true) && ($stmt->rowCount() >=1 )) {
                    return array(
                        'status' => RESOURCE_CREATED,
                        'messages' => 'Post ' . $this->title . ' insertado con exito'
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

        public function updateOne () {
            $this->conn = new Connection();   
            $this->query = $this->conn->connect();
            try {
                $stmt = $this->query->prepare('UPDATE ' . $this->table . ' SET 
                    title = :title, 
                    body = :body, 
                    author = :author, 
                    category_id = :category_id
                    WHERE id = :postId
                ');
                $stmt->bindValue(':title', $this->title);
                $stmt->bindValue(':body', $this->body);
                $stmt->bindValue(':author', $this->author);
                $stmt->bindValue(':category_id', $this->category_id);
                $stmt->bindValue(':postId', $this->id);

                $this->results = $stmt->execute();
                if (($this->results ==true) && ($stmt->rowCount() >=1 )) {
                    return array(
                        'status' => SUCCESS_REQUEST,
                        'messages' => 'Post ' . $this->title . ' actualizado con exito'
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

        public function deleteOne () {
            $this->conn = new Connection();   
            $this->query = $this->conn->connect();
            try {
                $stmt = $this->query->prepare('DELETE FROM ' . $this->table . ' WHERE id = :postId');
                $stmt->bindValue(':postId', $this->id);
                $this->results = $stmt->execute();
                if (($this->results == true) && ($stmt->rowCount() >=1)) {
                    return array(
                        'status' => SUCCESS_REQUEST,
                        'messages' => 'Post eliminado con exito'
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