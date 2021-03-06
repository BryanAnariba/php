<?php
    class Connection {
        private $connect;
        function __construct()
        {
            define('server','localhost');
            define('db_name','crud-poo-mvc');
            define('user','root');
            define('password', '');
        }

        public function connectMe () {
            $this->connect = new mysqli(server, user, password, db_name);
            if ($this->connect->connect_errno) {
                die("Conexion a la base de datos fallida, " . $this->connect->connect_error);
            }
            return $this->connect;
        }

        public function closeConnection ($connection) {
            $this->connect = mysqli_close($connection);
        }
    }
