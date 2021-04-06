<?php
    header('Content-Type: application/json');
    require_once('myCredentials.php');
    if ($_SERVER["REQUEST_METHOD"] == 'POST') {
        $ldapConnection = ldap_connect('https://mail.unah.edu.hn') or die("Could not connect to LDAP server");
        if ($ldapConnection) {
            $ldapBind = ldap_bind($ldapConnection, EMAIL, PASSWORD);
            if ($ldapBind) {
                echo json_encode(array('msm' => 'Las credenciales existen en el sistema'));
            } else {
                echo json_encode(array('msm' => 'Las credenciales no existen en el sistema'));
            }
            // echo json_encode(array(
            //     'message' => 'Success connection'
            // ));
        }
    }