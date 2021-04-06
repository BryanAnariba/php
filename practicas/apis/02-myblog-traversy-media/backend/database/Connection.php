<?php
    require_once('../config/config.php');
    class Connection {
        private $host;
        private $dataBase;
        private $user;
        private $password;
        private $charset;
        private $connection;

        public function __construct() {
            $this->host = constant('HOST');
            $this->dataBase = constant('DB');
            $this->user = constant('USER');
            $this->password = constant('PASSWORD');
            $this->charset = constant('CHARSET');
        }

        public function connect () {
            try{
                $this->connection = "mysql:host=" . $this->host . ";dbname=" . $this->dataBase . ";charset=" . $this->charset;
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ];
                
                $this->connection = new PDO($this->connection, $this->user, $this->password, $options);
                //echo('Conexión a MYSQL BD exitosa');
                return $this->connection;
            }catch(PDOException $e){
                echo('Error connection: ' . $e->getMessage());
                die();
            }
        }

        public function closeConnection () {
            $this->connection = null;
        }
    }
    // Testeo de la conexion
    $miConexion = new Connection();
    $miConexion->connect();