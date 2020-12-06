<?php
    require_once('config/config.php');
    class Connection {

        private $host;
        private $db;
        private $user;
        private $password;
        private $charset;
        public $connect;

        public function __construct() {
            $this->host = constant('HOST');
            $this->db = constant('DB');
            $this->user = constant('USER');
            $this->password = constant('PASSWORD');
            $this->charset = constant('CHARSET');
        }

        // MYSQLI MODE
        // public function connectMe() {
        //     try{
        //         $this->connect = new mysqli($this->host, $this->user,$this->password, $this->db);
        //         $this->connect->set_charset($this->charset);
        //         //echo 'Connected Successfully';
        //         return $this->connect;
        //     }catch(Exception $ex){
        //         echo('Connection error: ' . $ex->getMessage());
        //     }
        // }

        // public function closeConnection () {
        //     mysqli_close($this->connect);
        // }


        // PDO MODE
        function connectMe(){
            try{
                $connection = "mysql:host=" . $this->host . ";dbname=" . $this->db . ";charset=" . $this->charset;
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ];
                
                $pdo = new PDO($connection, $this->user, $this->password, $options);
                error_log('Conexión a BD exitosa');
                return $pdo;
            }catch(PDOException $e){
                error_log('Error connection: ' . $e->getMessage());
            }
        }
    }

    //$myConnection = new Connection();
    //$myConnection->connectMe();