<?php
    include_once('PersonController.php');
    include_once('../models/MasterModel.php');
    class Master extends Person {
        private $role;
        private $salary;
        private $masterModel;

        public function __construct($id, $gender, $softDeleteOptionsId, $firstName, $lastName, $email, $password, $role, $salary) {
            parent::__construct($id, $gender, $softDeleteOptionsId, $firstName, $lastName, $email, $password);
            $this->role = $role;
            $this->salary = $salary;
            $this->masterModel = new MasterModel();
        }

        
        public function getRole() {
            return $this->role;
        }

        public function setRole($role) {
            $this->role = $role;
            return $this;
        }

        public function getSalary() {
            return $this->salary;
        }
        
        public function setSalary($salary) {
            $this->salary = $salary;
            return $this;
        }

        // ---------------------------------------> CRUD Operations
        public function signUpMaster () {
            return $this->masterModel->upsertMaster(
                $this->getGender(),
                $this->getSoftDeleteOptionsId(),
                $this->getFirstName(),
                $this->getLastName(),
                $this->getEmail(),
                $this->getPassword(),
                $this->getRole(),
                $this->getSalary()
            );
        }

        public function getMasters () {

        }
        
        public function getMaster () {

        }

        // This method is valid only when the master is logged
        public function editMaster () {

        }


        // This method is valid only when the student is logged
        public function deleteMaster () {
            
        }

    }
?>