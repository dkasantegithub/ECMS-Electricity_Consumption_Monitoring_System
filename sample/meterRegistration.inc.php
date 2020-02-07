<?php 

$host = "localhost";
$user = "root";
$pwd = "";
$dbName = "";

//connecting
$connect = new mysqli($host,$user,$pwd,$dbName);

//variables defined and set empty
$meterSNumber=$meterDistrict=$meterGPSCode=$meterRegion="";
$meterSNumberErr=$meterDistrictErr=$meterGPSCodeErr=$meterRegionErr="";

//validating input data

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['meterSNumber'])){
        $meterSNumberErr = "First Name is required";
    }else{
        $meterSNumber= Validate_input($_POST['customerfName']);

        /* if (!preg_match("/^[a-zA-Z ]*$/",$customerfName)) {
            $customerfNameErr = "Only letters and white space allowed";
          } */
    }
    
   
    if(empty($_POST['region'])){
        $meterRegionErr = "Region is required";
    }else{
        $meterRegion = Validate_input($_POST['region']);
    }
    if (empty($_POST['District'])){
        $meterDistrictErr = "District is required";
    }else{
        $meterDistrict = Validate_input($_POST['meterDistrict']);
    }
    if (empty($_POST['meterGPSCode'])){
        $meterGPSCodeErr = "GPS Code is required";
    }else{
        $meterGPSCode = Validate_input($_POST['meterGPSCode']);
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