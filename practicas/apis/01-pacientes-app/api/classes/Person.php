<?php
    require_once('Gender.php');
    require_once('../classes/Connection.php');

    class Person extends Gender {
        private $id;
        private $firstName;
        private $lastName;

        private $myConnection;
        private $sql;
        private $query;
        private $records;

        public function __construct() {
        }

        public function getId() {
            return $this->id;
        }

        public function setId($id) {
            $this->id = $id;
            return $this;
        }

        public function getFirstName() {
            return $this->firstName;
        }

        public function setFirstName($firstName) {
            $this->firstName = $firstName;
            return $this;
        }

        public function getLastName() {
                return $this->lastName;
        }

        public function setLastName($lastName)  {
            $this->lastName = $lastName;
            return $this;
        }

        public function savePerson () {
            $this->myConnection = new Connection();
            $this->sql = $this->myConnection->connectMe();
            try {
                $this->query = $this->sql->prepare('INSERT INTO PERSONS (first_name, last_name, gender_id) VALUES (:firstName, :lastName, :genderId)');
                $this->query->bindValue(':firstName', $this->getFirstName());
                $this->query->bindValue(':lastName', $this->getLastName());
                $this->query->bindValue(':genderId', parent::getGenderId());
                $this->records = $this->query->execute();

                if ($this->records) {
                    return $this->sql->lastInsertId(); // Retorno del id de la insercion de la persona para insertar el usuario
                } else {
                    return null;
                }
            } catch (PDOException $ex) {
                $_ResponseStatus = new ResponseStatus(INTERNAL_SERVER_ERROR, array('error' => $ex->getMessage()));
                return $_ResponseStatus->responseData();
            } finally {
                $this->myConnection->closeConnection();
            }
        }
    }