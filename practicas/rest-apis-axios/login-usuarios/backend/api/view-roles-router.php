<?php
    header("Content-Type: application/json");
    include("../controllers/view-roles-controller.php");
    // 1 - Solo obtener los cargos de la tabla tbl cargos

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            viewRoles ();
        break;
        default:
            $toJson = array("mensaje" => "opcion no valida");
            $jsonToString = json_encode($toJson);
            echo $jsonToString;
        break;
    }
?>