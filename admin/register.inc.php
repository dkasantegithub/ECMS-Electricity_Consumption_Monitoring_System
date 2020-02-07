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









    //variables defined and set empty
$customerfName=$customerlName=$customerContact=$customerEmail=$customerRegion=$customerDistrict=$customerGPSCode = "";
$customerfNameErr=$customerlNameErr=$customerContactErr=$customerEmailErr=$customerRegionErr=$customerDistrictErr=$customerGPSCodeErr="";

//validating input data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['customerfName'])){
        $customerfNameErr = "First Name is required";
    }else{
        $customerfName= Validate_input($_POST['customerfName']);

        if (!preg_match("/^[a-zA-Z ]*$/",$customerfName)) {
            $customerfNameErr = "Only letters and white space allowed";
          }
    }
    
    if (empty($_POST['customerlName'])){
        $customerlNameErr = "Last Name is required";
    } else{
        $customerlName= Validate_input($_POST['customerlName']);

        if (!preg_match("/^[a-zA-Z ]*$/",$customerlName)) {
            $customerlNameErr = "Only letters and white space allowed";
          }
    }

    if (empty($_POST['customerContact'])){
        $customerContactErr = "Contact is required";
    }else{
        $customerContact = Validate_input($_POST['customerContact']);
    }
    if (empty($_POST['customerEmail'])){
        $customerEmailErr = "Email is required";
    }else{
        $customerEmail = Validate_input($_POST['customerEmail']);

        if (!filter_var($customerEmail, FILTER_VALIDATE_EMAIL)) {
            $customerEmailErr = "Invalid email format";
          }
    }
    if(empty($_POST['customerRegion'])){
        $customerRegionErr = "Region is required";
    }else{
        $customerRegion = Validate_input($_POST['customerRegion']);
    }
    if (empty($_POST['customerDistrict'])){
        $customerDistrictErr = "District is required";
    }else{
        $customerDistrict = Validate_input($_POST['customerDistrict']);
    }
    if (empty($_POST['customerGPSCode'])){
        $customerGPSCodeErr = "GPS Code is required";
    }else{
        $customerGPSCode = Validate_input($_POST['customerGPSCode']);
    }
}

//function validates input data
function Validate_input($inputdata) {
    $inputdata = trim($inputdata);
    $inputdata = stripslashes($inputdata);
    $inputdata = htmlspecialchars($inputdata);

    return $inputdata;
}



?>