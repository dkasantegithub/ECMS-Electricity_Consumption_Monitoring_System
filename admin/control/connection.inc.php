<?php
    //start session
    session_start();

    //Connection to database
    $server = "127.0.0.1:3308";
    $username = "root";
    $password = "";
    $dbname = "ecms";
    try{
        $connection = new PDO("mysql:host=$server;dbname=$dbname", $username, $password);
        //set the PDO error mode to exception
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }catch(PDOException $e){
        // echo "Connection failed:" . $e->getMessage();
            header("Location:../error/error.php?show=dberror");
            error_log("connection.inc.php, SQL error=" .$e->getMessage());
            return;
    }

    //include user class 
    include_once("index.inc.php");
    $user = new User($connection);
?>