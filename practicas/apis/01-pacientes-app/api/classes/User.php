<?php
    require_once('Person.php');
    require_once('../classes/Connection.php');
    require_once('../config/config.php');
    require_once('../helpers/ResponseStatus.php');

    class User extends Person {
        private $emailUser;
        private $passUser;
        private $roleId;
        private $avatar;

        private $myConnection;
        private $sql;
        private $query;
        private $records;

        public function __construct() {
            
        }

        public function getEmailUser() {
            return $this->emailUser;
        }

        public function setEmailUser($emailUser) {
            $this->emailUser = $emailUser;
            return $this;
        }

        public function getPassUser() {
            return $this->passUser;
        }

        public function setPassUser($passUser) {
            $this->passUser = $passUser;
            return $this;
        }

        public function getRoleId() {
            return $this->roleId;
        }

        public function setRoleId($roleId) {
            $this->roleId = $roleId;
            return $this;
        }

        public function getAvatar() {
            return $this->avatar;
        }

        public function setAvatar($avatar) {
            $this->avatar = $avatar;
            return $this;
        }
        
        private function genHashPassword () {
            return password_hash($this->passUser, PASSWORD_DEFAULT);
        }
        public function saveUser () {
            $this->myConnection = new Connection();
            $this->sql = $this->myConnection->connectMe();
            parent::__construct($this->getFirstName(), $this->getLastName(), $this->getGenderId());
            try {
                $this->query = $this->sql->prepare('SELECT * FROM USERS WHERE email_user = :emailUser');
                $this->query->bindValue(':emailUser', $this->emailUser);
                $this->records = $this->query->execute();
                if ($this->records && ($this->query->rowCount() == 0)) {
                    $results = parent::savePerson();
                    if ($results != null) {
                        $this->query = $this->sql->prepare('INSERT INTO USERS (user_id, email_user, pass_user, role_id, avatar) VALUES (:userId, :emailUser, :passUser, :roleUser, :avatar)');
                        $this->query->bindValue(':userId', $results);
                        $this->query->bindValue(':emailUser', $this->emailUser);
                        $this->query->bindValue(':passUser', $this->genHashPassword());
                        $this->query->bindValue(':roleUser', $this->roleId);
                        $this->query->bindValue(':avatar', $this->avatar);
                        $this->records = $this->query->execute();
                        if ($this->records) {
                            $_ResponseStatus = new ResponseStatus(RESOURCE_CREATED, array('message' => 'El usuario con correo ' . $this->emailUser .' fue insertado con exito'));
                            return $_ResponseStatus->responseData();
                        } else {
                            $_ResponseStatus = new ResponseStatus(INTERNAL_SERVER_ERROR, array('error' => 'El registro no fue insertado'));
                            return $_ResponseStatus->responseData();
                        }
                    } else {
                        $_ResponseStatus = new ResponseStatus(INTERNAL_SERVER_ERROR, array('error' => 'El registro no fue insertado'));
                        return $_ResponseStatus->responseData();
                    }
                } else {
                    $_ResponseStatus = new ResponseStatus(SUCCESS_REQUEST, array('error' => 'El email ' . $this->emailUser . ' ya se encuentra en uso'));
                    return $_ResponseStatus->responseData();
                }
                
            } catch (PDOException $ex) {
                $_ResponseStatus = new ResponseStatus(INTERNAL_SERVER_ERROR, array('error' => $ex->getMessage()));
                return $_ResponseStatus->responseData();
            } finally {
                $this->myConnection->closeConnection();
            }
        }
    }