<?php
    require_once('../config/config.php');
    class Connection {
        // Props
        private $host;
        private $db;
        private $user;
        private $password;
        private $charset;
        public $connect;

        // Initial State
        public function __construct() {
            $this->host = constant('HOST');
            $this->db = constant('DB');
            $this->user = constant('USER');
            $this->password = constant('PASSWORD');
            $this->charset = constant('CHARSET');
        }

        // MYSQLI MODE
        // public function conectarMe() {
        //     try{
        //         $this->connect = new mysqli($this->host, $this->user,$this->password, $this->db);
        //         if ($this->connect->connect_errno) {
        //             die();
        //         } else {
        //             $this->connect->set_charset($this->charset);
        //             // echo 'MYSQL Connection with PHP successfully';
        //             return $this->connect;
        //         }
        //     }catch(Exception $ex){
        //         echo('Connection error: ' . $ex->getMessage());
        //     }
        // }

        // public function closeConnection () {
        //     mysqli_close($this->connect);
        // }

        // PDO MODE
        public function connectMe(){
            try{
                $connection = "mysql:host=" . $this->host . ";dbname=" . $this->db . ";charset=" . $this->charset;
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ];
                
                $pdo = new PDO($connection, $this->user, $this->password, $options);
                //echo('Conexión a BD exitosa');
                return $pdo;
            }catch(PDOException $e){
                echo('Error connection: ' . $e->getMessage());
            }
        }

        public function closeConnection() {
            $this->connect = null;
        }
    }

    //Instance
    // $myConnection = new Conexion();
    // $myConnection->conectarMe();