<?php
    class Connection {
        private $connect;

        public function __construct()
        {
            define('server', 'localhost');
            define('db_name', '00-articles-register-api-php');
            define('user', 'root');
            define('password', '');
        }

        public function connectMe () {
            $this->connect = new mysqli(server, user, password, db_name);
            if ($this->connect->connect_errno) {
                die("Failed connection with MariaDB/MYSQL, " . $this->connect->connect_error);
            }
            return $this->connect;
        }

        public function closeConnection ($connection) {
            $this->connect = mysqli_close($connection);
        }
    }


    // Prueba de conexion para verificar si esta correcta
    //$testConnection = new Connection();
    //$testConnection->connectMe();
?>