<?php
    session_start();
    session_unset();
    setcookie("token","",time()-1,"/");
    session_destroy();
    header('Location: ../../frontend/index.html');

    
?>