<?php
    include_once("../config/Connection.php");
    class Article {
        // Propiedades o atributos de un articulo
        protected $id;
        protected $articleName;
        protected $articleDescription;
        protected $price;
        protected $stock;
        protected $connection;

        // Constructor de la clase para inicializar los datos
        public function __construct($id , $articleName , $articleDescription , $price , $stock) {
            $this->id = $id;
            $this->articleName = $articleName;
            $this->articleDescription = $articleDescription;
            $this->price = $price;
            $this->stock = $stock;
            $this->connection = connectMe();
        }
    
        // Metodos Setter y Getter
        public function getId() {
            return $this->id;
        }

        public function setId($id) {
            $this->id = $id;

            return $this;
        }

        function getArticleName() {
            return $this->articleName;
        }

        public function setArticleName($articleName) {
            $this->articleName = $articleName;
            return $this;
        }

        public function getArticleDescription() {
            return $this->articleDescription;
        }

        public function setArticleDescription($articleDescription) {
            $this->articleDescription = $articleDescription;
            return $this;
        }

        public function getPrice() {
            return $this->price;
        }

        public function setPrice($price) {
            $this->price = $price;
            return $this;
        }

        public function getStock() {
            return $this->stock;
        }

        public function setStock($stock) {
            $this->stock = $stock;
            return $this;
        }

        // Metodos REST API
        public function listArticle () {
            $article = $this->connection->prepare("SELECT * FROM articles WHERE ID = :articleId");
            $article->bindParam(':articleId' , $this->id);
            $article->execute();
            $response = array();

            while($row = $article->fetch(PDO::FETCH_ASSOC)) {
                $response = array(
                    "articleId" => $row["id"] ,
                    "articleName" => $row["articleName"] ,
                    "articleDescription" => $row["articleDescription"] ,
                    "price" => $row["price"] ,
                    "stock" => $row["stock"]
                );
            }

            $responseToJson = json_encode($response);
            if ($responseToJson == "[]") {
                $alert = array(
                    "status" => false , 
                    "message" => "No hay datos para mostrar"
                );
                echo json_encode($alert);
            } else {
                echo $responseToJson;
            }
            $this->connection = null;
        }

        public function listArticles () {
            $articles = $this->connection->prepare("SELECT * FROM articles;");
            $articles->execute();

            $response = array();
            while ($row = $articles->fetch(PDO::FETCH_ASSOC)) {
                $response[] = array(
                    "articleId" => $row["id"] ,
                    "articleName" => $row["articleName"] ,
                    "articleDescription" => $row["articleDescription"] ,
                    "price" => $row["price"] ,
                    "stock" => $row["stock"]
                );
            }

            echo json_encode($response);
            $this->connection = null;
        }

        public function addArticle () {
            $saveArticle = $this->connection->prepare("INSERT INTO articles (articleName , articleDescription , price , stock) VALUES (:articleName , :articleDescription , :price , :stock);");
            $saveArticle->bindParam(":articleName" , $this->articleName);
            $saveArticle->bindParam(":articleDescription" , $this->articleDescription);
            $saveArticle->bindParam(":price" , $this->price);
            $saveArticle->bindParam(":stock" , $this->stock);
            if ($saveArticle->execute()) {
                $response = array("status" => true , "message" => "El articulo " . $this->articleName . " fue guardado con exito");
                echo json_encode($response);
            } else {
                $response = array("status" => false , "message" => "El articulo " . $this->articleName . " no se pudo guardar");
                echo json_encode($response);
            }   

            
            
            $this->connection = null;
        }

        public function editArticle () {

            // Preparamos consulta para ver si el articulo existe primero
            $select = $this->connection->prepare("SELECT id FROM articles WHERE id = :articleId");
            $select->bindParam(":articleId" , $this->id);
            
            // Ejecutamos consulta
            $select->execute();

            // Almacenamos lo que retorno la ejecucion de la consulta en este caso el id
            $data = $select->fetch(PDO::FETCH_ASSOC);

            // Si lo que retorna la caonsulta esta vacio
            if (empty($data)) {
                $resToJson =array(
                    "status" => false ,
                    "message" => "No existen registros con el identificador del articulo " . $this->id
                );
                $resToString = json_encode($resToJson);
                echo $resToString;
            } else { // Si el articulo existe preparamos y ejecutamos la consulta de actualizacion de datos
                $editArticle = $this->connection->prepare("UPDATE articles SET articleName = :articleName , articleDescription = :articleDescription , price = :price , stock = :stock WHERE id = :articleId");
                $editArticle->bindParam(":articleId" , $this->id);
                $editArticle->bindParam(":articleName" , $this->articleName);
                $editArticle->bindParam(":articleDescription" , $this->articleDescription);
                $editArticle->bindParam(":price" , $this->price);
                $editArticle->bindParam(":stock" , $this->stock);

                if ($editArticle->execute()) {
                    $resToJson = array(
                        "status" => true ,
                        "message" => "EL articulo fue actualizado con exito"
                    );
                    $resToString = json_encode($resToJson);
                    echo $resToString;
                } else {
                    $resToJson =array(
                        "status" => false ,
                        "message" => "Ha ocurrido un error en la insercion"
                    );
                    $resToString = json_encode($resToJson);
                    echo $resToString;
                }
            }
            $this->connection = null;
        }

        public function deleteArticle () {
            $delete = $this->connection->prepare("DELETE FROM articles WHERE id = :articleId");
            $delete->bindParam(":articleId" , $this->id);
            if ($delete->execute()) {
                $response = array("status" => true , "message" => "Articulo con id " . $this->id . " eliminado con exito");
                echo json_encode($response);
            } else {
                $response = array("status" => false , "message" => "Ocurrio un error en la eliminacion del articulo");
                json_encode($response);
            }

            $this->connection = null;
        }
    }
?>