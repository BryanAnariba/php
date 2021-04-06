<?php
    // Este archivo maneja el control de las rutas en la aplicacion osea nombreControlador/nombreMetodo/parametros
    class App { 
        public function __construct() {
            $url = isset($_GET['url'])  ? $_GET['url'] : null; // Si existe una url, $url = su valor si no, valor de $url = null
            $url = rtrim($url, '/'); // Para quitar el ultimo / en la url ej -> users/insert/ => users/insert
            $url = explode('/', $url); // Divide la url en cada / que encuentre, ej => users/insert -> users , insert
            
            if (empty($url[0])) { // Si no existe el nombre del controlador en la url ej -> /[0], redirigimos a login
                $archivoController = 'controllers/login.php'; // ruta archivo login
                require_once($archivoController); // Requerimos archivo
                $controller = new Login(); // Instanciamos login
                $controller->loadModel('Login'); // Cargamos modelos de dicho controlador
                $controller->render();// Renderizamos o cargamos la vista de login
                return false;
            }

            // Si no entra en el if de $url[0] entonces que muestre el controlador
            // Ejemplo -> /usuarios => usuariosController.php
            $archivoController = 'controllers' . $url[0] . '.php';
            if (file_exists($archivoController)) { // Si ese archivo existe
                require_once($archivoController); // Requerimos
                $controller = new $url[0]; // Intanciamos
                $controller->loadModel($url[0]); // Cargamos su modelo correspondiente

                if (isset($url[1])) { // Si existe o viene un metodo en la url despues del controlador ej -> usuarios/registro ejecute el metodo
                    if (method_exists($controller, $url[1])) { // Si el metodo existe en el controlador
                        if (isset($url[2])) { // Si en la url despues del metodo vienen parametros ej -> usuarios/registro/12
                            $cantidadDeParametros = count($url) - 2; // -2 para restar el primero que es el controller y el segundo el metodo ej -> usuarios/registro
                            $parametros = [];

                            for ($i=0;$i<$cantidadDeParametros;$i++) { // llenamos el arreglo con parametros
                                array_push($parametros, $url[$i] + 2);
                            }

                            $controller->{$url[1]}($parametros); // Mandamos los parametros al metodo
                        } else {
                            // Si la url no tiene parametros
                            // llamar el metodo asi tal cual, dinamicamente
                            $controller->{$url[1]}(); 
                        }
                    } else {    
                        // Notificar el metodo o funcion no existe
                    }
                } else { // Si no existe cargar un metodo por default
                    $controller->render();
                }
            } else {
                // si no existe el archivo, notificar not found
            }
        }
    }