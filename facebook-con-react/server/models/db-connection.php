<?php
    class Connection {

        // Atributos privados para que no tengan acceso afuera de la clase
        private $USER = "root";
        private $PASSWORD = "";
        private $HOST = "localhost";
        private $DB = "facebook";

        // Aqui inicializamos la conexion gracias al constructor
        function __construct () {
            $this->connectMe();
        }

        // Metodo o funcion que intenta realizar la conexion
        function connectMe () {
            try {
                $connection = new PDO("mysql:host=$this->HOST;dbname=$this->DB", $this->USER ,$this->PASSWORD);
                echo "Mysql Connected SuccessFully";

            } catch (PDOException $error) {
                echo "Error en la conexion " . $error->getMessage();
            }
        }
    }

    // Declaramos una instancia
    $newConnection = new Connection();
?>