<?php
    // Permite entrada de contenido en formato json
    header('Content-Type: application/json');
    include_once('../controllers/StudentController.php');

    // Segun el tipo de peticion ejecuta
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            if (isset($_GET['studentId']) && !empty($_GET['studentId'])) {

            } else {

            }
        break;
        case 'POST':
            $_POST = json_decode(file_get_contents('php://input'), true);
            $gender = $_POST['gender'];
            $softDeleteOptionsId = $_POST['softDeleteOptionsId'];
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $career = $_POST['career'];
            $average = $_POST['average'];
            if (empty($gender) || empty($softDeleteOptionsId) || empty($firstName) || empty($lastName) || empty($email) || empty($password)|| empty($career) || empty($average)) {
                $resToJson = array(
                    'status' => false,
                    'message' => 'Los Campos Son obligatorios'
                );
                echo json_encode($resToJson);
            } else {
                $student = new Student(null, $gender, $softDeleteOptionsId, $firstName, $lastName, $email, $password, $career, $average);
                $success = $student->signUpStudent();
                $resToJson;
                if ($success) {    
                    $resToJson = array(
                        'status' => $success, 
                        'message' => 'Felicidades ' . $email . ', fue registrado con exito.'
                    );
                } else {
                    $resToJson = array(
                        'status' => $success, 
                        'message' => 'Ha ocurrido un error el usuario ' . $email . ', no fue registrado con exito.'
                    );
                }
                echo json_encode($resToJson);
            }
        break;
        case 'PUT': 
            $_PUT = json_decode(file_get_contents('php://input'), true);
        break;
        case 'DELETE':
            if (isset($_GET['studentId']) && !empty($_GET['studentId'])) {

            } else {
                
            }
        break; 
        default: 
            $resToJson = array(
                'status' => false,
                'messate' => 'Tipo de peticion no soportada'
            );
            return json_encode($resToJson);
        break;

    }
?>