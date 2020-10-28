<?php
    include_once('PersonController.php');
    include_once('../models/StudentModel.php');

    class Student extends Person {
        private $career;
        private $average;
        private $studentModel;
        public function __construct($id, $gender, $softDeleteOptionsId, $firstName, $lastName, $email, $password, $career, $average) {
            parent::__construct($id, $gender, $softDeleteOptionsId, $firstName, $lastName, $email, $password);
            $this->career = $career;
            $this->average = $average;
            $this->studentModel = new StudenModel();
        }

        public function getCareer() {
            return $this->career;
        }

        public function setCareer($career) {
            $this->career = $career;
            return $this;
        }
        
        public function getAverage() {
            return $this->average;
        }

        public function setAverage($average) {
            $this->average = $average;
            return $this;
        }

        // ---------------------------------------> CRUD Operations
        public function signUpStudent () {
            return $this->studentModel->upsertStudent(
                $this->getGender(),
                $this->getSoftDeleteOptionsId(),
                $this->getFirstName(),
                $this->getLastName(),
                $this->getEmail(),
                $this->getPassword(),
                $this->getCareer(),
                $this->getAverage()
            );
        }

        public function getStudents () {

        }

        public function getStudent () {

        }

        // This method is valid only when the student is logged
        public function editStudent () {

        }
        
        // This method is valid only when the master is logged
        public function deleteStudent () {

        }
    }
?>