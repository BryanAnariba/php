<?php
    include_once('../config/DataBaseConnection.php');

    class StudenModel {
        private $db;
        private $connect;
        private $students;
        private $hashedPassword;

        public function __construct() {
            $this->db = new Connection();
            $this->connect = $this->db->connectMe();
        }

        public function upsertStudent($gender, $softDeleteOptionsId, $firstName, $lastName, $email, $password, $career, $average) {
            // Hashing password
            $this->hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $insertTblUsers = $this->connect->prepare('CALL sp_add_user(?,?,?,?,?,?)');
            $insertTblUsers->bind_param('iissss', $gender, $softDeleteOptionsId, $firstName, $lastName, $email, $this->hashedPassword);
            $statusQueryOne = $insertTblUsers->execute();

            // Si la ejecucion de la consulta uno tuvo exito
            if ($statusQueryOne) {
                $insertTblStudents = $this->connect->prepare('CALL sp_add_student(?, ?)');
                $insertTblStudents->bind_param('sd', $career, $average);
                $statusQueryTwo = $insertTblStudents->execute();

                if ($statusQueryTwo) { // Si la ejecucion de la consulta dos tuvo exito retorna true
                    return $statusQueryTwo;
                } else { // Si la ejecucion de la consulta dos no tuvo exito retorna false
                    return $statusQueryTwo;
                }
            } else { //  Caso contrario retorna false
                return $statusQueryOne;
            }
        }

        public function getStudents() {

        }

        public function getStudentById() {

        }
    }
?>