<?php
    require_once("../php-files/connection.inc.php");
    
    //logout
    if(isset($_POST["logout_btn"])){
        $user->logout();
        session_destroy();
        unset($_SESSION["username"]);
        unset($_SESSION["admin"]);
        unset($_SESSION["superadmin"]);
        header("Location: login.php");
    }
?>