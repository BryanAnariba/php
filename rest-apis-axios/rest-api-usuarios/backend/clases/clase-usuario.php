<?php
    // Haber pero no malinterprete yo me referia a la conexion.
    class usuario {
        private $nombreUsuario;
        private $apellidoUsuario;
        private $fechaNacimiento;
        private $email;
        private $password;
        private $cargo;

        public function __construct($nombreUsuario , $apellidoUsuario , $fechaNacimiento , $email , $role) {
            $this->nombreUsuario = $nombreUsuario;
            $this->apellidoUsuario = $apellidoUsuario;
            $this->fechaNacimiento = $fechaNacimiento;
            $this->email = $email;
            $this->password = $password;
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

        public function getCargo() {
            return $this->cargo;
        }

        public function setCargo($cargo) {
            $this->cargo = $cargo;
            return $this;
        }

        public function __toString () {
            return $this->nombreUsuario . '  ' . $this->apellidoUsuario . ' ' . $this->fechaNacimiento . ' ' . $this->email . ' ' . $this->password . ' ' . $this->cargo;
        }

        // 1 - Guardar usuarios
        public function guardarUsuario () {

        }

        // 2 - Ver datos del usuario seleccionad
        public function verUsuario () {

        }

        // 3 - Ver usuarios
        public function verUsuarios () {

        }

        // 4 - Editar usuario
        public function actualizarUsuario () {

        }

        // 5 - Eliminar usuario
        public function eliminarUsuario () {

        }

        // 6 - logueo de un usuario
        public function logueoUsuario () {

        }
    }
?>