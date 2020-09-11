<?php

    // Para permitir la entrada de datos en formato json
    header("Content-Type: application/json");

    // Incluimos la clase Articulo para consumir los metodos del controlador
    include_once('../controllers/articles-controller.php');

    // Con request method -> verificamos que tipo de peticion se hizo al servidor existen -> put post delete patch get etc 
    switch ($_SERVER["REQUEST_METHOD"]) {
        case 'POST':
            $_POST = json_decode(file_get_contents('php://input') , true);

            if (!isset($_POST['marca']) || !isset($_POST['modelo']) || !isset($_POST['stock'])) {
                $res = array(
                    "status" => false ,
                    "message" => "Los Campos estan vacios"
                );
                $resToString = json_encode($res);
                echo $resToString;
            } else {

                // Instanciamos la clase y llamamos al metodo correspondiente
                $article = new Article(null , $_POST['marca'] , $_POST['modelo'] , $_POST['stock']);
                $article->addArticle();
            }
        break;
        case 'GET':
            if (isset($_GET['idArticle'])) {// Si existe un id de un articulo en la peticion es que solo quiere un articulo 

                // Instanciamos la clase y llamamos al metodo correspondiente
                $article = new Article($_GET['idArticle'] , null , null , null);
                $article->getArticle();
                
            } else { // Sino es que los necesita todos los articulos

                // Instanciamos la clase y llamamos al metodo correspondiente
                $article = new Article(null , null , null , null);
                $article->getArticles();
            }
        break;
        case 'PUT':
            // Recogemos la data proveniente del cliente
            $_PUT = json_decode(file_get_contents('php://input') , true);

            // Si existe un id de articulo en la peticion y ademas ese id del articulo no esta vacio 
            if (isset($_GET['idArticle']) && !empty($_GET['idArticle'])) {

                // Instanciamos la clase y llamamos al metodo correspondiente
                $article = new Article($_GET['idArticle'] , $_PUT['marca'] , $_PUT['modelo'] , $_PUT['stock']);
                $article->editArticle();

            } else {
                $res = array(
                    "status" => false ,
                    "message" => "Los campos no se actualizaron, debe colocar un Id articulo"
                );
                $resToString = json_encode($res);
                echo $resToString;
            }
        break;
        case 'DELETE':
            if (isset($_GET['idArticle']) && !empty($_GET['idArticle'])) {
                $article = new Article($_GET['idArticle'] , null , null , null);
                $article->deleteArticle();
            } else {
                $res = array(
                    "status" => false ,
                    "message" => "El registro no se elimino, debe colocar un Id articulo"
                );
                $resToString = json_encode($res);
                echo $resToString;
            }
        break;
        default: 
            $res = array("mensaje" => "Opcion no valida");
            $resToString = json_encode($res);
            echo $resToString;
        break;
    }
?>