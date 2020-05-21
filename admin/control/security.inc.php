<?php
    require_once("connection.inc.php");
    //redirect user to login if not loggedin
    if(!$_SESSION["username"]){
        $user->redirect('../../index.php');
    }
?>