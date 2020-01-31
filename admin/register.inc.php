<?php
    require_once("../php-files/connection.inc.php");

    if(isset($_POST["signup"])){
        $fname = $_POST["fname"];
        $lname = $_POST["lname"];
        $username = $_POST["username"];
        $email = $_POST["email"];
        $pwd = $_POST["password"];
        $cpwd = $_POST["cpwd"];

        if($user->signup($fname, $lname, $username, $email, $pwd, $cpwd)){
            $user->redirect("register.php");
        }else{
            $error = $user->sError;
        }

    }


?>