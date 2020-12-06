<?php
    require_once('../classes/Connection.php');
    require_once('../config/config.php');
    require_once('../helpers/ResponseStatus.php');

    class Gender {
        protected $genderId;
        protected $gender;
        protected $abrev;

        private $myConnection;
        private $sql;
        private $query;
        private $records;
        
        public function __construct($genderId = null) {
            $this->genderId = $genderId;
        }
        
        function getGenderId() {
            return $this->genderId;
        }

        public function setGenderId($genderId) {
            $this->genderId = $genderId;
            return $this;
        }
        

        public function getGender() {
            return $this->gender;
        }

        public function setGender($gender)  {
            $this->gender = $gender;
            return $this;
        }

        public function getAbrev() {
            return $this->abrev;
        }

        public function setAbrev($abrev) {
            $this->abrev = $abrev;
            return $this;
        }

        public function getGenders () {
            $this->myConnection = new Connection();
            $this->sql = $this->myConnection->connectMe();
            try {
                $this->query = $this->sql->prepare('SELECT * FROM GENDERS');
                $this->query->execute();
                $this->records = $this->query->fetchAll(PDO::FETCH_OBJ);
                $_ResponseStatus = new ResponseStatus(SUCCESS_REQUEST, $this->records);
                $_ResponseStatus->responseData();
            } catch (PDOException $ex) {
                $_ResponseStatus = new ResponseStatus(INTERNAL_SERVER_ERROR, array('error' => $ex->getMessage()));
                return $_ResponseStatus->responseData();
            } finally {
                $this->myConnection->closeConnection();
            }
        }

        public function getGenderById () {
            $this->myConnection = new Connection();
            $this->sql = $this->myConnection->connectMe();
            try {
                $this->query = $this->sql->prepare('SELECT * FROM GENDERS WHERE ID = :genderId');
                $this->query->bindValue(':genderId', $this->genderId);
                $this->query->execute();
                $this->records = $this->query->fetchAll(PDO::FETCH_OBJ);
                $_ResponseStatus = new ResponseStatus(SUCCESS_REQUEST, $this->records);
                $_ResponseStatus->responseData();
            } catch (PDOException $ex) {
                $_ResponseStatus = new ResponseStatus(INTERNAL_SERVER_ERROR, array('error' => $ex->getMessage()));
                return $_ResponseStatus->responseData();
            } finally {
                $this->myConnection->closeConnection();
            }
        }

        public function saveGender () {
            $this->myConnection = new Connection();
            $this->sql = $this->myConnection->connectMe();
            try {
                $this->query = $this->sql->prepare('INSERT INTO GENDERS (gender, abrev) VALUES (:gender, :abrev)');
                $this->query->bindValue(':gender', $this->gender);
                $this->query->bindValue(':abrev', $this->abrev);
                $this->records = $this->query->execute();
                if ($this->records) {
                    $_ResponseStatus = new ResponseStatus(RESOURCE_CREATED, array(
                        'message' => 'Genero ' . $this->gender . ' insertado con exito',
                        'filasInsertadas' => $this->query->rowCount()
                    ));
                    $_ResponseStatus->responseData();
                } else {
                    $_ResponseStatus = new ResponseStatus(INTERNAL_SERVER_ERROR, array('error' => 'El registro no fue insertado'));
                    return $_ResponseStatus->responseData();
                }
            } catch (PDOException $ex) {
                $_ResponseStatus = new ResponseStatus(INTERNAL_SERVER_ERROR, array('error' => $ex->getMessage()));
                return $_ResponseStatus->responseData();
            } finally {
                $this->myConnection->closeConnection();
            }
        }

        public function editGenderById () {
            $this->myConnection = new Connection();
            $this->sql = $this->myConnection->connectMe();
            try {
                $this->query = $this->sql->prepare('UPDATE GENDERS SET gender = :gender , abrev = :abrev WHERE id = :genderId');
                $this->query->bindValue(':gender', $this->gender);
                $this->query->bindValue(':abrev', $this->abrev);
                $this->query->bindValue(':genderId', $this->genderId);
                $this->records = $this->query->execute();
                if ($this->records) {
                    $_ResponseStatus = new ResponseStatus(SUCCESS_REQUEST, array(
                        'message' => 'Genero ' . $this->gender . ' actualizado con exito',
                        'filasActualizadas' => $this->query->rowCount()
                    ));
                    $_ResponseStatus->responseData();
                } else {
                    $_ResponseStatus = new ResponseStatus(INTERNAL_SERVER_ERROR, array('error' => 'El registro no fue actualizado'));
                    return $_ResponseStatus->responseData();
                }
            } catch (PDOException $ex) {
                $_ResponseStatus = new ResponseStatus(INTERNAL_SERVER_ERROR, array('error' => $ex->getMessage()));
                return $_ResponseStatus->responseData();
            } finally {
                $this->myConnection->closeConnection();
            }
        }

        public function deleteGenderById () {
            $this->myConnection = new Connection();
            $this->sql = $this->myConnection->connectMe();
            try {
                $this->query = $this->sql->prepare('DELETE FROM GENDERS WHERE id = :genderId');
                $this->query->bindValue(':genderId', $this->genderId);
                $this->records = $this->query->execute();
                if ($this->records) {
                    $_ResponseStatus = new ResponseStatus(SUCCESS_REQUEST, array(
                        'message' => 'Genero ' . $this->gender . ' eliminado con exito',
                        'filasEliminadas' => $this->query->rowCount()
                    ));
                    $_ResponseStatus->responseData();
                } else {
                    $_ResponseStatus = new ResponseStatus(INTERNAL_SERVER_ERROR, array('error' => 'El registro no fue eliminado'));
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