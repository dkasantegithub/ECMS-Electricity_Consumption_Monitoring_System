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
        echo "";

    }catch(PDOException $e){
        echo "Connection failed:" . $e->getMessage();
    }

    //include user class 
    include_once("index.inc.php");
    $user = new User($connection);
?>