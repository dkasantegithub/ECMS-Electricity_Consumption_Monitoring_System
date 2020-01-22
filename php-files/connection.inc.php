<?php
    //start session
    session_start();

    //Connection to database
    $server = "localhost";
    $username = "ddasante";
    $password = "da1vi2d345";
    $dbname = "ecms";
    try{
        $connection = new PDO("mysql:host=$server;dbname=$dbname", $username, $password);
        //set the PDO error mode to exception
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "";

    }catch(PDOException $e){
        echo "Connection failed: " . $e->getMessage();
    }

    //include user class 
    include_once("index.inc.php");
    $user = new User($connection);
?>