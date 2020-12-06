<?php
    class Persona {
        private $idUsuario;
        private $nombreUsuario;
        private $apellidoUsuario;
        private $fechaNacimiento;
        private $genero;

        public function __construct($idUsuario, $nombreUsuario, $apellidoUsuario, $fechaNacimiento, $genero) {
            $this->idUsuario = $idUsuario;
            $this->$nombreUsuario = $nombreUsuario;
            $this->apellidoUsuario = $apellidoUsuario;
            $this->fechaNacimiento = $fechaNacimiento;
            $this->genero = $genero;
        }
        public function getIdUsuario() {
            return $this->idUsuario;
        }

        public function setIdUsuario($idUsuario) {
            $this->idUsuario = $idUsuario;
            return $this;
        }
        

        public function getNombreUsuario() {
            return $this->nombreUsuario;
        }

        public function setNombreUsuario($nombreUsuario) {
            $this->nombreUsuario = $nombreUsuario;
            return $this;
        }

        public function getApellidoUsuario() {
            return $this->apellidoUsuario;
        }

        public function setApellidoUsuario($apellidoUsuario) {
            $this->apellidoUsuario = $apellidoUsuario;
            return $this;
        }

        public function getFechaNacimiento() {
            return $this->fechaNacimiento;
        }


        public function setFechaNacimiento($fechaNacimiento) {
            $this->fechaNacimiento = $fechaNacimiento;
            return $this;
        }

        public function getGenero() {
            return $this->genero;
        }

        public function setGenero($genero) {
            $this->genero = $genero;
            return $this;
        }
    }
?>