<?php
    require_once('controllers/ErrorsController.php');
    // clase que funciona como las routes en nodejs
    class App {
        public function __construct() {
            // Ternario = existe la url que la tome si no por defecto pon null, url SALE DE .htaccess
            $url = isset($_GET['url']) ? $_GET['url'] : null;

            // url -> http://localhost/expense/user/
            $url = rtrim($url, '/'); // rtrim elimina el / en caso que haya un / al final como en la url 
            $url = explode('/', $url); // explode parte la cadena por cada / que encuentres ej -> localhost, expense, user

            // si no viene el primer elemento ejemplo http://localhost redirija al login
            if (empty($url[0])) { 
                //error_log('APP::construct-> El controlador no ha sido especificado');
                $loginController = 'controllers/LoginController.php';
                require_once($loginController);
                $controller = new LoginController();
                $controller->loadModel('Login');
                $controller->render();
                return false;
            }

            // si vienen parametros en la url por ejemplo /user/listadoFotos ojo aqui solo hay tres niveles pero pueden haber mas
            $fileController = 'controllers/' . $url[0] . 'Controller.php';
            if (file_exists($fileController)) { // Si existe el archivo controller que tecleaste en la url
                require_once($fileController);
                $controllerName = $url[0] . 'Controller()';
                $controller = new $controllerName;
                $controller->loadModel($url[0]); // -> /controlador

                if (isset($url[1])) { // -> /controlador/metodo
                    if (method_exists($controller, $url[1])) {
                        if (isset($url[2])) { // -> /controlador/metodo/parametros

                            // Numero de parametros que vienen en la url
                            $numberParams = count($url) - 2;

                            // Arreglo de parametros
                            $params = [];

                            // Agregamos los parametros en params
                            for ($i =0; $i < $numberParams; $i++ ) {
                                array_push($params, $url[$i] + 2);
                            }

                            // Pasamos los parametros encontrados al controlador como id por ejemplo
                            $controller->{$url[1]}($params);
                        } else {
                            $controller->{$url[1]}(); // si no hay parametros que retorne metodo del controlador -> /controlador/metodo
                        }
                    } else {
                        // Error no existe el metodo que buscas 404 not foun
                        $controller = new ErrorsController();
                        $controller->loadModel('Errors');
                        $controller->render();
                    }
                } else { // Si no viene un parametro url[1] renderise el controlador normal -> /controlador
                    $controller->render();
                }
            } else {
                // Controlador no existe pagina 404 
                $controller = new ErrorsController();  
                $controller->loadModel('Errors');
                $controller->render();    
                     
            }
        }

        
