<?php
    require_once("../php-files/connection.inc.php");
    //redirect user to login if not loggedin
    if(!$_SESSION["username"]){
        $user->redirect('login.php');
    }
    
?>