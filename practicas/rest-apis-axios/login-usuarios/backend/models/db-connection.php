<?php
    $server = 'localhost:3307';
    $userName = 'root';
    $passWord = 'root';
    $dataBase = 'rest-api-usuarios';

    try {
        $connection = new PDO("mysql:host=$server;dbname=$dataBase;" , $userName , $passWord);
    } catch (PDOException $e) {
        die ('Failed data base connection -> ' . $e->$getMessage());
    }
?>