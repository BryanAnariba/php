<?php
    require_once('DataBase/Connection.php');
    class CrudService {
        protected $connection;
        protected $query = null;
        private $table = '';
        
        public function __construct() {
            $this->connection = (new Connection())->connectMe();
        }

        
        public function getQuery() {
            return $this->query;
        }

        public function setQuery($query) {
            $this->query = $query;
            return $this;
        }

        public function getTable() {
            return $this->table;
        }

        public function setTable($table){
            $this->table = $table;
            return $this;
        }

        // SELECT OPTIONS
        public function getByQuery() {
            try {
                // Preparamos consulta para evitar inyeccion sql
                $stmt = $this->connection->prepare($this->query);

                // Ejecutamos consulta
                $stmt->execute();

                // Obtenemos los registros en formato objecto basicamente agarra el nombre de los campos
                return $stmt->fetchAll(PDO::FETCH_OBJ);

            } catch (Exception $ex) {
                echo $ex->getTraceAsString();
            }
        }

        // INSERT DATA
        public function save($object) {
            try {
                // $object -> ["gender"=>"masculino", "abrev":"M"];
                $fields = implode("`, `", array_keys($object)); // -> `gender`, `abrev`
                $valuesOfFields = implode(":", array_keys($object)); // -> :gender, :abrev
                $this->query = "INSERT INTO {$this->table} (`{$fields}`) VALUES ({$valuesOfFields})"; //pegamos las dos vars de arriba
                $this->run($object);

                // Ultimo id insertado
                $id = $this->connection->lastInsertId();
                return $id;

            } catch (Exception $ex) {
                echo $ex->getTraceAsString();
            }
        }

        private function run($object = null) {
            $stmt = $this->connection->prepare($this->query); // valor de la $this->query que esta en save la preparamos
            if ($object !== null) {
                foreach($object as $key => $value) {
                    if (empty($value)) { // ej si el campo genero esta vacio le asigne nullo para guardar a la consulta
                        $value = NULL;
                    }
                    $stmt->bindValue(":$key", "$value"); // prepara los campos a almacenar en la consulta
                }
            }
            $stmt->execute(); //Guardamos una ves haga todo el recorrigo de los campos en el foreach
            return $stmt->rowCount();
            $this->cleanProps();
        }

        private function cleanProps () {
            $this->query = null;
            $this->table = '';
        }
    }