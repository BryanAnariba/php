<?php
    include_once('../config/connection.php');
    class Article {

        // Propiedades o atributos de la clase articulo
        private $id;
        private $marca;
        private $modelo;
        private $stock;
        private $sql;

        // Metodo constructor -> damos valores iniciales de los atributos
        public function __construct ($id , $marca , $modelo , $stock) {
            $this->id = $id;
            $this->marca = $marca;
            $this->modelo = $modelo;
            $this->stock = $stock;
            $connection = new Connection();
            $this->sql = $connection->connectMe();
        }

        // Metodos de acceso o en este caso modificadores de acceso
        public function getId() {
            return $this->id;
        }

        public function setId($id) {
            $this->id = $id;
            return $this;
        }

        public function getMarca() {
            return $this->marca;
        }

        public function setMarca($marca) {
            $this->marca = $marca;
            return $this;
        }

        public function getModelo() {
            return $this->modelo;
        }

        public function setModelo($modelo) {
            $this->modelo = $modelo;
            return $this;
        }

        function getStock() {
            return $this->stock;
        }


        public function setStock($stock) {
            $this->stock = $stock;
            return $this;
        }

        public function getSql() {
            return $this->sql;
        }

        public function setSql($sql) {
            $this->sql = $sql;
            return $this;
        }

        // Funciones rest api
        
        // Insertar un nuevo articulo
        public function addArticle () {

            // Preparamos la consulta para evitar inyecciones sql , hacemos binding o cruce de parametros con "bindParam"
            $insertArticle = $this->sql->prepare("INSERT INTO TBL_MOVILES(MARCA, MODELO, STOCK) VALUES (:marca , :modelo , :stock);");
            $insertArticle->bindParam(":marca" , $this->marca);
            $insertArticle->bindParam(":modelo" , $this->modelo);
            $insertArticle->bindParam(":stock" , $this->stock);
            $resToJson = array();

            // Controlamos posibles parametros como llegada de parametros vacios
            if ($insertArticle->execute()) {
                $resToJson = array(
                    "status" => true ,
                    "message" => "El articulo " . $this->marca . " fue insertado con exito"
                );
                $resToString = json_encode($resToJson);
                echo $resToString;
            } else {
                $resToJson = array(
                    "status" => false ,
                    "message" => "El articulo " . $this->marca . " no se guardo"
                );
                $resToString = json_encode($resToJson);
                echo $resToString;
            }

            // Cerramos la conexion para evitar el consumo de recursos innecesario
            $this->setSql(null);
        }

        // Obtener los articulos
        public function getArticle () {

            // Preparamos la consulta para evitar una posible inyeccion sql
            $selectArticle = $this->sql->prepare("SELECT ID , MARCA , MODELO , STOCK FROM TBL_MOVILES WHERE ID = :idArticle");
            $selectArticle->bindParam(":idArticle" , $this->id);
            $selectArticle->execute();

            // Declaramos un arreglo asociativo para mandar una posible respuesta al usuario
            $resToJson = array();   

            // Recorremos la data con un ciclo par asi de esa manera llenar el arreglo y mandarlo al frontend con vue con la data
            while($row = $selectArticle->fetch(PDO::FETCH_ASSOC)) {
                $resToJson[] = array(
                    "id" => $row["ID"] ,
                    "marca" => $row["MARCA"] ,
                    "modelo" => $row["MODELO"] ,
                    "stock" => $row["STOCK"]
                );
            }

            // Mandamos la respuesta
            $resToString = json_encode($resToJson);
            echo $resToString;

            // Cerramos conexion para evitar el consumo de recursos del sistema
            $this->setSql(null);
        }

        // Obtener un solo articulo
        public function getArticles () {

            // Preparamos la consulta
            $selectArticles = $this->sql->prepare("SELECT ID , MARCA , MODELO ,STOCK FROM TBL_MOVILES;");
            $selectArticles->execute();

            // Declaramos un arreglo asociativo para mandar una posible respuesta al usuario
            $resToJson = array();

            // Recorremos la data con un ciclo par asi de esa manera llenar el arreglo y mandarlo al frontend con vue con la data
            while($row = $selectArticles->fetch(PDO::FETCH_ASSOC)) {
                $resToJson[] = array(
                    "id" => $row["ID"] ,
                    "marca" => $row["MARCA"] ,
                    "modelo" => $row["MODELO"] ,
                    "stock" => $row["STOCK"]
                );
            }

            // Transormamos la respuesta en un formato legible
            $resToString = json_encode($resToJson);

            // Mandamos la respuesta
            echo $resToString;

            // Cerramos la conexion para evitar el consumo de recursos innecesario
            $this->setSql(null);
        }

        // Editar un articulo del stock
        public function editArticle () {
            // Primero buscamos el registro y si existe lo modificamos, si no retornamos al usuario la inexistencia del articulo

            // Preparamos la consulta de busqueda
            $selectArt = $this->sql->prepare("SELECT ID , MARCA FROM TBL_MOVILES WHERE ID = :idArticle");
            $selectArt->bindParam(":idArticle" , $this->id);

            // Ejecutamos la consulta
            $selectArt->execute();

            // El resultado de la ejecucion la transformamos a array asociativo y la almacenamos en una var llamada data
            $data = $selectArt->fetch(PDO::FETCH_ASSOC);

            // Si no hay registros retornados o en defecto es vacio
            if (empty($data)) {
                $resToJson =array(
                    "status" => false ,
                    "message" => "No existen registros con el identificador del articulo " . $this->id
                );
                $resToString = json_encode($resToJson);
                echo $resToString;
            } else { // Caso contrario
                $editArticle = $this->sql->prepare("UPDATE TBL_MOVILES SET MARCA = :marca , MODELO = :modelo , STOCK = :stock WHERE ID = :idArticle");
                $editArticle->bindParam(":marca" , $this->marca);
                $editArticle->bindParam(":modelo" , $this->modelo);
                $editArticle->bindParam(":stock" , $this->stock);
                $editArticle->bindParam(":idArticle" , $this->id);

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

            // Cerramos la conexion para evitar el consumo de recursos innecesario
            $this->setSql(null);
        }

        // Eliminar un articulo -> para un mejor manejo primero buscamos por id y si esta eliminamos
        public function deleteArticle () {
            if (!empty($this->getId()) && ($this->getId()!= null)) {
                $select = $this->sql->prepare("SELECT ID , MARCA FROM TBL_MOVILES WHERE ID = :idArticle");
                $select->bindParam(":idArticle" , $this->id);
                $select->execute();
                $rowStatus = array(null);
                while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                    $rowStatus = array(
                        "id" => $row["ID"] ,
                        "marca" => $row["MARCA"]
                    );
                }

                $rowStatus = json_encode($rowStatus);
                if ($rowStatus != "[null]") {
                    // Preparamos la consulta
                    $deleteArticle = $this->sql->prepare("DELETE FROM TBL_MOVILES WHERE ID = :idArticle");
                    $deleteArticle->bindParam(":idArticle" , $this->id);

                    // Declaramos un arreglo asociativo para mandar una posible respuesta al usuario
                    $resToJson = array();

                    // Si la consulta tuvo exito y elimino
                    if ($deleteArticle->execute()) {
                        $resToJson = array(
                            "status" => true ,
                            "message" => "El articulo con el identificador " . $this->id . " fue eliminado con exito"
                        );
                        $resToString = json_encode($resToJson);
                        echo $resToString;
                    } else {
                        $resToJson = array(
                            "status" => false ,
                            "message" => "El articulo con el identificador " . $this->id . " no fue eliminado de la base de datos"
                        );
                        $resToString = json_encode($resToJson);
                        echo $resToString;
                    }
                } else {
                    $resToJson = array(
                        "status" => false ,
                        "message" => "El articulo con el identificador " . $this->id . " no fue encontrado en la base de datos"
                    );
                    $resToString = json_encode($resToJson);
                    echo $resToString;
                }
                // Cerramos la conexion para evitar el consumo de recursos innecesario
                $this->setSql(null);
            } else {
                $resToJson = array(
                    "status" => false ,
                    "message" => "Parametro o identificador " . $this->id . "no encontrado"
                );
                $resToString = json_encode($resToJson);
                echo $resToString;
            }
        }
    }
?>