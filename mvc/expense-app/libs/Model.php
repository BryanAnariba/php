<?php
    require_once('database/database.php');
    include_once('libs/InterfaceModel.php');
    
    class Model {
        private $db;

        // Constructor que inicializa la instancia a la base de datos
        public function __construct() {
            $this->db = new Database();
        }

        // Para hacer las consultas
        public function query($query) {
            return $this->db->connectMe()->query($query);
        }

        // Funcion para preparar la funcion query y evitar la inyecion sql
        public function prepare($query) {
            return $this->db->connectMe()->prepare($query);
        }
    }
