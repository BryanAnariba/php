<?php
    class Connection {
        public static function connectMe() {
            define('server','localhost');
            define('db_name', 'articulos-php-mas-vue');
            define('user','root');
            define('password','');
            $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

            try {
                $connection = new PDO("mysql:host=".server."; dbname=".db_name, user , password , $options);
                return $connection;
            } catch(Exception $error) {
                die("Error en la conexion: " . $error->getMessage());
            }
        }
    }
?>