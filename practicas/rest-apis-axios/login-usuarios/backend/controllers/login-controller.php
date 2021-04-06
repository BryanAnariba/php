<?php
    session_start();
    class Usuario {
        private $nombreUsuario; 
        private $apellidoUsuario;
        private $fechaNacimiento;
        private $emailUsuario;
        private $passwordUsuario;
        private $cargoUsuario;

        public function __construct($nombreUsuario , $apellidoUsuario , $fechaNacimiento , $emailUsuario , $passwordUsuario , $cargoUsuario) {
            $this->nombreUsuario = $nombreUsuario; 
            $this->apellidoUsuario = $apellidoUsuario;
            $this->fechaNacimiento = $fechaNacimiento;
            $this->emailUsuario = $emailUsuario;
            $this->passwordUsuario = $passwordUsuario;
            $this->cargoUsuario = $cargoUsuario;  
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

        public function getEmailUsuario() {
            return $this->emailUsuario;
        }

        public function setEmailUsuario($emailUsuario) {
            $this->emailUsuario = $emailUsuario;
            return $this;
        }

        public function getPasswordUsuario() {
            return $this->passwordUsuario;
        }

        public function setPasswordUsuario($passwordUsuario) {
            $this->passwordUsuario = $passwordUsuario;
            return $this;
        }

        public function getCargoUsuario() {
            return $this->cargoUsuario;
        }

        public function setCargoUsuario($cargoUsuario) {
            $this->cargoUsuario = $cargoUsuario;
            return $this;
        }


        //--------------------------------------------> Consumiendo la REST API
        function verifyCredentials () {
            require_once("../models/db-connection.php");
            $verifySQL = $connection->prepare("SELECT ID_USUARIO , NOMBRE_USUARIO  ,EMAIL_USUARIO , PASSWORD_USUARIO FROM TBL_USUARIOS WHERE EMAIL_USUARIO = :email");
            $verifySQL->bindParam(':email' , $this->emailUsuario);
            $verifySQL->execute();
            $results = $verifySQL->fetch(PDO::FETCH_ASSOC);
            $toJson = array();

            if ($results) {
                if (password_verify($this->passwordUsuario , $results["PASSWORD_USUARIO"])) {
                    $_SESSION["token"] = sha1(uniqid(rand() , true));
                    $_SESSION["ID_USUARIO"] = $results["ID_USUARIO"];
                    $_SESSION["NOMBRE_USUARIO"] = $results["NOMBRE_USUARIO"];
                    $_SESSION["EMAIL_USUARIO"] = $results["EMAIL_USUARIO"];
                    $toJson = array(
                        "statusCode" => 1 ,
                        "UserId" => $_SESSION["ID_USUARIO"] ,
                        "token" => $_SESSION["token"]
                    );
                    setcookie("token",$toJson["token"],time()+(60*60*24*31),"/");
                    $jsonToString = json_encode($toJson);
                    echo $jsonToString;
                } else {
                    setcookie("token","",time()-1,"/");
                    $toJson = array(
                        "statusCode" => 2 ,
                        "mensaje" => "Clave Incorrecta",
                        "email" => $this->emailUsuario
                    );
                    $jsonToString = json_encode($toJson);
                    echo $jsonToString;
                }
            } else {
                $toJson = array(
                    "statusCode" => 3 ,
                    "mensaje" => "Email Incorrecto",
                    "email" => $this->emailUsuario
                );
                $jsonToString = json_encode($toJson);
                echo $jsonToString;
            }
            $connection = null;
        }

        function userRegistered () {
            require_once("../models/db-connection.php");
            $InserUser = $connection->prepare("INSERT INTO TBL_USUARIOS(ID_CARGO , NOMBRE_USUARIO, APELLIDO_USUARIO , FECHA_NACIMIENTO , EMAIL_USUARIO , PASSWORD_USUARIO) VALUES (:idCargo , :nombre , :apellido , :fecha , :email , :password)");
            $hashingPassword = password_hash($this->passwordUsuario , PASSWORD_DEFAULT);
            $InserUser->bindParam(':idCargo' , $this->cargoUsuario);
            $InserUser->bindParam(':nombre' , $this->nombreUsuario);
            $InserUser->bindParam(':apellido' , $this->apellidoUsuario);
            $InserUser->bindParam(':fecha' , $this->fechaNacimiento);
            $InserUser->bindParam(':email' , $this->emailUsuario);
            $InserUser->bindParam(':password' , $hashingPassword);
            $toJson = array();
            if ($InserUser->execute()) {
                $toJson = array(
                    "mensaje" => "Usuario " . $this->emailUsuario . " Creado con exito"
                );
                $jsonToString = json_encode($toJson);
                echo $jsonToString;
            } else {
                $toJson = Array(
                    "mensaje" => "Ha ocurrido un error en la insercion del usuario"
                );
                $jsonToString = json_encode($toJson);
                echo $jsonToString;
            }
            $connection = null;
        }

        function listUser () {

        }

        function listUsers () {

        }

        function updateUser () {

        }

    }
?>