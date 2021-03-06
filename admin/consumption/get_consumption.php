<?php
    
    // //Creates new record as per request
    // //Connect to database
    // $servername = "127.0.0.1:3308";		//example = localhost or 192.168.0.0
    // $username = "root";		//example = root
    // $password = "";	
    // $dbname = "ecms";

    // // Create connection
    // $conn = new mysqli($servername, $username, $password, $dbname);
    // // Check connection
    // if ($conn->connect_error) {
    //     die("Database Connection failed: " . $conn->connect_error);
    // }

    // if(!empty($_POST['energyConsumed']))
    // {
	// 	$energy = $_POST['energyConsumed'];
	//     $sql = "INSERT INTO econsumed(energy_consumed) VALUES('".$energy."')"; //nodemcu_ldr_table = Youre_table_name

	// 	if ($conn->query($sql) === TRUE) {
	// 	    echo "OK";
	// 	} else {
	// 	    echo "Error: " . $sql . "<br>" . $conn->error;
	// 	}
	// }


	// $conn->close();
?>

<?php
    //get connection to db
    include("../control/security.inc.php");
    try{
        if(!empty($_POST['energyConsumed'])){
            $energy = $_POST['energyConsumed'];

            // get customer id from nodemcu or gsm[contact of sim which is unique for all gsm]
            $customer_id = 17;

            //check whether there is a consumption with today's date and customer_id
            $stmt = $connection->prepare("SELECT * FROM consumption WHERE date=CURDATE() && customer_id='$customer_id' LIMIT 1");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            //if yes, update the consumption value
            if($stmt->rowCount()>0){
                $cid = $row["customer_id"];
                $date = $row["date"];
                
                //update consumption value with value from meter
                $energy_consumed = $row["energy_consumed"];
                $energy_consumed += $energy;
                $update = $connection->prepare("UPDATE consumption SET energy_consumed='$energy_consumed' WHERE date='$date' && customer_id='$cid'");
                $update->execute();
            
            //else insert consumption into a new field
            }else{
                $insert = $connection->prepare("INSERT INTO consumption(energy_consumed, customer_id) VALUES('$energy', '$customer_id')");
                $insert->execute();
            }
    }
    }catch(PDOException $e){
        header("Location:../error/error.php?show=dberror");
        error_log("get_consumption.php, SQL error=" .$e->getMessage());
        return;
    }

    $connection->NULL;

?>