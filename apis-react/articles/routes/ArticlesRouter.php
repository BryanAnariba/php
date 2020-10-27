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
                $article = new Article($_GET["articleId"] , null , null , null , null);
                $article->listArticle();
            } else { // Caso contrario quiere todos los articulos
                $article = new Article(null , null , null , null , null);
                $article->listArticles();
            }
        break;
        case "POST":
            // Capturamos la data json y la decodificamos como string para poder manipularla
            $_POST = json_decode(file_get_contents("php://input") , true);
            if ((!isset($_POST["articleName"]) && !empty($_POST["articleName"])) || !isset($_POST["articleDescription"]) || !isset($_POST["price"]) || !isset($_POST["stock"])) {
                $response = array("status"=>false , "message" => "Los parametros estan vacios, debe llenarlos");
                echo json_encode($response);
            } else {
                $article = new Article(null , $_POST["articleName"] , $_POST["articleDescription"] , $_POST["price"] , $_POST["stock"]);
                $article->addArticle();
            }
        break;
        case "PUT":
            // Capturamos la data json y la decodificamos como string para poder manipularla
            $_PUT = json_decode(file_get_contents("php://input") , true); 
            if ((!isset($_PUT["articleName"])) || !isset($_PUT["articleDescription"]) || !isset($_PUT["price"]) || !isset($_PUT["stock"])) {
                $response = array("status"=>false , "message" => "Los parametros estan vacios, debe llenarlos");
                echo json_encode($response);
            } else {
                $article = new Article($_GET["articleId"] , $_PUT["articleName"] , $_PUT["articleDescription"] , $_PUT["price"] , $_PUT["stock"]);
                $article->editArticle();
            }
        break;
        case "DELETE": 
            if (isset($_GET["articleId"]) && !empty($_GET["articleId"])) {
                $article = new Article($_GET["articleId"] , null , null , null , null);
                $article->deleteArticle();
            } else {
                $response = array("status" => false , "message" => "No hay identificador de busqueda de un articulo");
                echo json_encode($response);
            }
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