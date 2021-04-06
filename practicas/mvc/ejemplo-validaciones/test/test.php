<?php
    header('Content-Type: application/json');
    require("../vendor/autoload.php");
    require_once('../vendor/autoload.php');
    use Valitron\Validator as V;
    V::langDir("../vendor/vlucas/valitron/lang");
    V::lang('es');

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET': 
        break;
        case 'POST': 
            $_POST = json_decode(file_get_contents('php://input'), true);
            $isValid = new \Valitron\Validator($_POST);

            $isValid->rule("required", ["nombre","apellido","edad","correo","sueldo"]);
            $isValid->rule("lengthMin","nombre",6);
            $isValid->rule("lengthMax","nombre",45);
            $isValid->rule("lengthMin","apellido",6);
            $isValid->rule("lengthMax","apellido",45);
            $isValid->rule("email", "correo");
            $isValid->rule("integer","edad");
            $isValid->rule("min","edad",17);
            $isValid->rule("max","edad", 100);
            $isValid->rule("numeric","sueldo");

            if ($isValid->validate()) {
                echo "Validation passed";
            } else {
                $errors = $isValid->errors();
                echo json_encode($errors);
            }
        break;
        default: 
            
        break;
    }