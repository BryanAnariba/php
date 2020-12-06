<?php
    // Manejo de errores por medio de un arghivo
    // error_reporting(E_ALL);
    // ini_set('ignore_repeated_errors', TRUE);
    // ini_set('display_errors', FALSE);
    // ini_set('log_errors', TRUE);
    // ini_set('error_log', '/xampp/htdocs/php/PHP-MVC/expense-app/php-error.log');
    //error_log('INICIO DE APLICACION WEB');


    //Archivos base para el funcionamiento de la aplicacion de php
    require_once('config/config.php');
    require_once('database/database.php');
    require_once('routes/app.php');
    require_once('libs/Model.php');
    require_once('libs/View.php');
    require_once('libs/Controller.php');

    // Instancia de los routers o al menos asi lo llamo en nodejs
    $app = new App();
