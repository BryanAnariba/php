<?php
    class Conexion {
        private $conexion;
        private $opcionesConexion;
        function __construct()
        {
            define('server', 'localhost');
            define('db_name', 'bd-usuarios-poo-mvc');
            define('user', 'root');
            define('password', '');
        }

        public function conectarme() {
            try {
                $this->opcionesConexion = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
                $this->conexion = new PDO('mysql:host=' . server . "; dbname= " . db_name, user, password, $this->opcionesConexion);
                return $this->conexion;
            } catch (Exception $ex) {
                die('Error en la conexion: ' . $ex->getMessage());
            }
        }
    }
?>