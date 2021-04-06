<?php
    header("Content-Type: aplication/json");
    require_once('../helpers/ResponseStatus.php');
    require_once('Connection.php');
    require_once('User.php');
    require_once('../config/config.php');
    class Auth extends User {
        
        private $myConnection;
        private $sql;
        private $query;
        private $records;
        private $hashPassword;

        public function __construct($emailUser, $passUser) {
            $this->setEmailUser($emailUser);
            $this->setPassUser($passUser);
        }

        public function signIn () {
            $this->myConnection = new Connection();
            $this->sql = $this->myConnection->connectMe();
            try {
                $this->query = $this->sql->prepare('SELECT a.email_user, a.pass_user, b.first_name, b.last_name, b.gender_id, c.gender, a.role_id, d.role FROM USERS a INNER JOIN PERSONS b ON(a.user_id = b.id) INNER JOIN GENDERS c ON(b.gender_id = c.id) INNER JOIN USER_ROLES d ON (a.role_id = d.id) WHERE email_user = :emailUser');
                $this->query->bindValue(':emailUser', $this->getEmailUser());
                $this->records = $this->query->execute();
                if ($this->records) {
                    if ($this->query->rowCount() == 0) {
                        $_ResponseStatus = new ResponseStatus(SUCCESS_REQUEST, array('message' => 'El correo ' . $this->getEmailUser() . ' no fue encontrado'));
                        return $_ResponseStatus->responseData();
                    } else {
                        $data = $this->query->fetchObject();
                        $this->hashPassword = $data->pass_user;
                        $iskeyValid = $this->verifyPassword();
                        if ($iskeyValid) {
                            // Crear token
                            $_ResponseStatus = new ResponseStatus(SUCCESS_REQUEST, $data);
                            return $_ResponseStatus->responseData();
                        } else {
                            $_ResponseStatus = new ResponseStatus(SUCCESS_REQUEST, array('message' => 'La clave digitada es incorrecta'));
                            return $_ResponseStatus->responseData();
                        }
                    }
                }
            } catch (PDOException $ex) {
                $_ResponseStatus = new ResponseStatus(INTERNAL_SERVER_ERROR, array('error' => $ex->getMessage()));
                return $_ResponseStatus->responseData();
            } finally {
                $this->myConnection->closeConnection();
            }
        }

        public function logOut () {

        }

        private function verifyPassword () {
            $verifyPassword = password_verify($this->getPassUser(), $this->hashPassword);
            $results = ($verifyPassword) ? $verifyPassword : false;
            return $results;  
        }

        private function genToken () {
            $val = true;
            $token = bin2hex(openssl_random_pseudo_bytes(16, $val));
            $date = date('Y-m-d H:i');
            $estado = "Activo";
        }
    }