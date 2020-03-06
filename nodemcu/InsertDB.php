<?php
//Creates new record as per request
    //Connect to database
    $servername = "127.0.0.1:3308";		//example = localhost or 192.168.0.0
    $username = "root";		//example = root
    $password = "";	
    $dbname = "ecms";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Database Connection failed: " . $conn->connect_error);
    }

    // //Get current date and time
    // date_default_timezone_set('Asia/Jakarta');
    // $d = date("Y-m-d");
    // $t = date("H:i:s");

    if(!empty($_POST['energyConsumed']))
    {
		$energy = $_POST['energyConsumed'];
	    $sql = "INSERT INTO econsumed(energy_consumed) VALUES('".$energy."')"; //nodemcu_ldr_table = Youre_table_name

		if ($conn->query($sql) === TRUE) {
		    echo "OK";
		} else {
		    echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}


	$conn->close();
?>