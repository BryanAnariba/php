<?php
    class View {
        protected $data;
        public function __construct() {
            
        }

        // Para renderizado o mostrado de la vista
        public function render($nombre, $data = []) { // Recibe el nombre de la vista y la data a enviar
            $this->data = $data;
            require 'views/' . $nombre . '.php';
        }
    }
