<?php
    include_once('./PersonaController.php');
    class Usuario extends Persona {
        private $email;
        private $password;

        public function __construct($idUsuario, $nombreUsuario, $apellidoUsuario, $fechaNacimiento, $genero, $email, $password) {
            parent::__construct($idUsuario, $nombreUsuario, $apellidoUsuario, $fechaNacimiento, $genero);
            $this->email = $email;
            $this->password = $password;
        }

        public function getEmail() {
            return $this->email;
        }

        public function setEmail($email) {
            $this->email = $email;
            return $this;
        }

        public function getPassword() {
            return $this->password;
        }

        public function setPassword($password) {
            $this->password = $password;
            return $this;
        }


        // ---> CRUD OPERATIONS
        
        public function registrarUsuario () {

        }

        public function loginUsuario () {

        }

        public function verTareasUsuario () {

        }

        public function verTareaUsuario () {

        }

        public function editarTareaUsuario () {

        }

        public function eliminarTareaUsuario () {

        }
    }
?>