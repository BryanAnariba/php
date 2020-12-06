<?php

    class Controller { // Clase base para dar herencia a los demas controllers
        protected $view;
        protected $model;
        public function __construct() {
            // Para usar en el render de vistas
            $this->view = new View();
        }

        // Cargar el modelo correspondiente al controlador
        public function loadModel($model) {
            $url = 'models/' . $model . 'Model.php'; //  Armamos el nombre del archivo por medio de la url

            if (file_exists($url)) { // Si la $url existe como archivo
                require_once($url); // Importalo
                $modelName = $model . 'Model'; // anexale model ej -> user + Model = userModel
                $this->model = new $modelName(); // Instancialo para usarlo
            }
        }

        // Para recoger los parametros via post
        public function existsPostParams($params) {
            foreach ($params as $param) {
                if (!isset($_POST[$param])) {
                    echo "No existen parametros post";
                    return false;
                }
            }
            return true;
        }

        
        // Para recoger los parametros via get
        public function existsGetParams($params) {
            foreach ($params as $param) {
                if (!isset($_GET[$param])) {
                    echo "No existen parametros get";
                    return false;
                }
            }
            return true;
        }

        public function getGetRequest ($name) {
            return $_GET[$name];
        }

        public function getPostRequest ($name) {
            return $_POST[$name];
        }


        // Para x accion del usuario lo rediriga a x pagina por ejemplo guardar con exito con los datos que pidio sea error o data
        public function redirectTo ($route, $messages) {
            $data = [];
            $params = '';
            foreach ($messages as $key => $message) {
                array_push($data, $key . ':' . $message);
            }
            $params = join(',', $data);
            if ($params != '') {
                $params = '{' . $params . '}';
            }

            header('Location: ' . constant('URL') . $route . $params);
        }
    }
