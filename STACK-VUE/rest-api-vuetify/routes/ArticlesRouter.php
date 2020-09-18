<?php
    // Para jalar la informacion hacia el frontend , para que se puedan solicitar recursos al backend por medio del frontend
    include("../config/cors.php");

    // Para permitir formato json en la api
    header("Content-Type: application/json");

    // Clase o arhivo articles
    include_once('../controllers/ArticlesController.php');

    // CASE CON LAS OPERACIONES BASICAS DE LA REST API Y CAPTURANDO DICHA PETIDION CON $_SERVER["REQUEST_METHOD"];
    switch ($_SERVER["REQUEST_METHOD"]) {
        case "GET": 
            if (isset($_GET["articleId"])) { // Si existe un campo id en la peticion, el usuario solo quiere un articulo

            } else { // Caso contrario quiere todos los articulos

            }
        break;
        case "POST":
            // Capturamos la data json y la decodificamos como string para poder manipularla
            $_POST = json_decode(file_get_contents("php://input") , true);
        break;
        case "PUT":
            // Capturamos la data json y la decodificamos como string para poder manipularla
            $_PUT = json_decode(file_get_contents("php://input") , true); 
        break;
        case "DELETE": 
        break;
        default:
            $response = array(
                "status" => false ,
                "message" => "Request Method is not valid"
            );
            $responseToString = json_encode($response);
        break;
    }
?>