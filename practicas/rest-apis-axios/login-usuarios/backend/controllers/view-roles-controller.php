<?php
    function viewRoles () {
        include_once("../models/db-connection.php");
        $viewRoles = $connection->prepare("SELECT ID_CARGO , CARGO FROM TBL_CARGOS");
        $viewRoles->execute();
        
        $toJson = array();
        while ($row = $viewRoles->fetch(PDO::FETCH_ASSOC)) {
            $toJson[] = array(
                "id" => $row["ID_CARGO"] ,
                "cargo" => $row["CARGO"]
            );
        }
        $jsonToString = json_encode($toJson);
        echo $jsonToString;
        $connection = null;
    }
?>