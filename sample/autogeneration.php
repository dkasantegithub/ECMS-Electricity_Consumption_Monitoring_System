<?php

    //if (isset($_POST['generate'])){

        /* select first Name and last last from the database
        select the first letter from the first name
        follow the steps below */

        //Generate a unique username using Database
     /*    function generate_unique_username($string_name="Mike Tyson", $rand_no = 200){
            while(true){
                $username_parts = array_filter(explode(" ", strtolower($string_name))); //explode and lowercase name
                $username_parts = array_slice($username_parts, 0, 2); //return only first two arry part
            
                $part1 = (!empty($username_parts[0]))?substr($username_parts[0], 0,8):""; //cut first name to 8 letters
                $part2 = (!empty($username_parts[1]))?substr($username_parts[1], 0,5):""; //cut second name to 5 letters
                $part3 = ($rand_no)?rand(0, $rand_no):"";
                
                $username = $part1. str_shuffle($part2). $part3; //str_shuffle to randomly shuffle all characters 
                
                return $username; */
                /* $username_exist_in_db = username_exist_in_database($username); //check username in database
                if(!$username_exist_in_db){
                    return $username;
                } */
        /*     }
        } */
/* 
        $query = "SELECT fname, lName FROM Customer";
        $result = $connection->query($query); //where connection is the connection to the database

        $row = $result->FETCH_ASSOC() {
             $row["fName"].
             $row["lName"];

             generate_unique_username()
                }
*/
    

    if (isset($_POST['register']))
    {
        //Generation of Username
        $fName = Validate_input($_POST['customerfName']);
        $lName = Validate_input($_POST['customerlName']);

        $genUsername= strtolower($fName[0]).strtolower($lName);

        //echo $genUsername;

        //Generation of Password
        $upperCase = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $lowerCase = "abcdefghijklmnopqrstuvwxyz";
        $numbers = "0123456789";
        $specialChar = "@$%&";

        $genUpperCase = substr(str_shuffle($upperCase),0,2);
        $genLowerCase = substr(str_shuffle($lowerCase),0,2);
        $genNumbers = substr(str_shuffle($numbers),0,2);
        $genSpecialChar = substr(str_shuffle($specialChar),0,2);

        $mixedPwd = "$genUpperCase$genLowerCase$genNumbers$genSpecialChar";

        $generatedMixedPass = substr(str_shuffle($mixedPwd),0,6);

    }
 


?>
