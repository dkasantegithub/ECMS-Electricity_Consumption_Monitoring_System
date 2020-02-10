<?php
    require_once("../php-files/connection.inc.php");

    //logout
    if(isset($_POST["logout_btn"])){
        $user->logout();
        session_destroy();
        unset($_SESSION["username"]);
        unset($_SESSION["admin"]);
        unset($_SESSION["superadmin"]);
        unset($_SESSION["id"]);
        header("Location: login.php");
    }

    //remove unnecessary characters from input
    function validate_data($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
    

    //validate text input
    function validate_name($name){
        return preg_match("/^[a-zA-Z]+$/", $name);
    }

        //validate name length
    function character_len($char, $max){
        return strlen($char) < $max;
    }

    //validate email
    function email($email){
        return filter_var($email,FILTER_VALIDATE_EMAIL);
    }

        //validate password
    function validate_pwd($pwd){
        return preg_match("/^[a-zA-Z0-9-@#'$]{10,}+$/", $pwd);
    }
      
    //Redirect
    function redirect($page){
        return header("Location: $page");
    }

?>