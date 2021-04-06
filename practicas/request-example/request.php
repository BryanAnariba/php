<?php
    $headers = apache_request_headers();

    foreach ($headers as $header => $value) {
        echo "$header: $value <br />\n";
    }

    echo "Token Acceso -> " . $headers['access-token'];
    echo "\n";
    echo "Id -> " .$_GET["id"]; 
?>