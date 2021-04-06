<?php
    session_start();
    echo "ID User -> " . $_SESSION['ID_USUARIO'];
    echo "User Token -> " . $_SESSION['token'];
?>