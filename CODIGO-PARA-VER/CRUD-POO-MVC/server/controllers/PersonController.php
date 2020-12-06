<?php
    class Person {
        private $id;
        private $gender;
        private $softDeleteOptionsId;
        private $firstName;
        private $lastName;
        private $email;
        private $password;

        public function __construct ($id, $gender, $softDeleteOptionsId, $firstName, $lastName, $email, $password) {
            $this->id = $id;
            $this->gender = $gender;
            $this->softDeleteOptionsId = $softDeleteOptionsId;
            $this->firstName = $firstName;
            $this->lastName = $lastName;
            $this->email = $email;
            $this->password = $password;
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

        public function setLastName($lastName) {
            $this->lastName = $lastName;
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

        
        public function getGender() {
            return $this->gender;
        }

        public function setGender($gender) {
            $this->gender = $gender;
            return $this;
        }

        public function getSoftDeleteOptionsId() {
            return $this->softDeleteOptionsId;
        }

        public function setSoftDeleteOptionsId($softDeleteOptionsId) {
            $this->softDeleteOptionsId = $softDeleteOptionsId;
            return $this;
        }
    }
?>
