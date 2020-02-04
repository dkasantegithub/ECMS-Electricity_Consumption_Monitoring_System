<?php
    require_once("../php-files/connection.inc.php");
    //redirect user to login if not loggedin
    if(!$_SESSION["username"]){
        $user->redirect('login.php');
    }
    
    // elseif(isset($_SESSION["username"]) && !$_SESSION["superadmin"]){
    //     $user->redirect('index.php');
    // }elseif(isset($_SESSION["username"]) && !$_SESSION["admin"]){
    //     $user->redirect('register.php');
    // }else{

    // }
    
?>