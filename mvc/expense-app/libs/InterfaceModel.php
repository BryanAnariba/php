<?php
    interface InterfaceModel {
        public function save ();
        public function find ();
        public function findOne($id);
        public function updateOne($id);
        public function deleteOne($id);
        public function from($array);
    }
