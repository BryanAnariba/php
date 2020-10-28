<?php
    include_once('../config/DataBaseConnection.php');
    class MasterModel {
        private $db;
        private $connect;
        private $masters;
        private $hashedPassword;
        public function __construct() {
            $this->db = new Connection();
            $this->connect = $this->db->connectMe();
        }

        public function upsertMaster ($gender, $softDeleteOptionsId, $firstName, $lastName, $email, $password, $role, $salary) {
            // Hashing de contrasenia
            $this->hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $insertTblUsers = $this->connect->prepare('CALL sp_add_user(?,?,?,?,?,?)');
            $insertTblUsers->bind_param('iissss', $gender, $softDeleteOptionsId, $firstName, $lastName, $email, $this->hashedPassword);
            $statusQueryOne = $insertTblUsers->execute();
            
            // Si la ejecucion de la consulta uno tuvo exito
            if ($statusQueryOne) {
                $insertTblMasters = $this->connect->prepare('CALL sp_add_master(?,?)');
                $insertTblMasters->bind_param('sd', $role, $salary);
                $statusQueryTwo = $insertTblMasters->execute();

                if ($statusQueryTwo) { // Si la ejecucion de la consulta dos tuvo exito retorna true
                    return $statusQueryTwo;
                } else { // Si la ejecucion de la consulta dos no tuvo exito retorna false
                    return $statusQueryTwo;
                }
            } else { //  Caso contrario retorna false
                return $statusQueryOne;
            }

            // Siempre cerrar conexion para evitar consumo innesesario de recurso y asegurar rendimiento
            $this->db->closeConnection($this->connect);
        }

        public function getMasters() {

        }

        public function getMasterById() {
            
        }
    }
?>