<?php 
include("../control/security.inc.php");
include("../control/control.inc.php");
include("../includes/header.php"); 
// include("../includes/navbar.php"); 
?>

<!-- Retrieve notification messages and counts from meter table -->
<?php 

    if(isset($_POST["notify_btn"])){

        try{
            $sub = validate_data($_POST["subject"]);
            $m_number = validate_data($_POST["m_number"]);

            $stmt = $connection->prepare("SELECT * FROM meter WHERE meter_number='$m_number' LIMIT 1");
            $stmt->execute();

            if($stmt->rowCount() > 0){
                while($row = $stmt->fetch()){
                    $mid =  $row["meter_id"];
                    $mnumber = $row["meter_number"];
                    $region = $row["region"];
                    $district = $row["district"];

                    //Insertion of notification into database
                    try{
                    $subject = $sub ." ". $mid;
                    $comment = "Meter with an id of $mnumber, located at $district in $region is currently inactive";
                    $nstatus = 0;
                    
                    $nstmt = $connection->prepare("INSERT INTO notifications(subject, comment, status)
                            VALUES('$subject', '$comment', '$nstatus')");
                    $nstmt->execute();

                    }catch(PDOException $e){
                    header("Location:../error/error.php?show=dberror");
                    error_log("meter.php, SQL error=" .$e->getMessage());
                    return;
                    }
                }

                // update meter table 
                //fetch id from login table
                    $status = "unactive";
                    $user = $_SESSION["username"];
                    $query = $connection->prepare("SELECT * FROM adminlogin WHERE user_email='$user' LIMIT 1");
                    $query->execute();
                    $fetch = $query->fetch(PDO::FETCH_ASSOC);

                    //fetch last id from admin login table
                    if($query->rowCount() >  0){
                    $login_id = $fetch["login_id"];

                    $state = $connection->prepare("UPDATE meter SET status='$status' WHERE meter_number='$m_number'");
                    $state->execute();
                    }
                }else{
                    $error = '<div class="alert alert-danger text-center font-weight-bold" role="alert">No such meter exist</div>';
                }

            }catch(PDOException $e){
                header("Location:../error/error.php?show=dberror");
                error_log("send_alert.php, SQL error=" .$e->getMessage());
                return;
            }
        }

?>

<div class="container-fluid">
    <div class="col-5 mx-auto mt-5 mb-3">
        <div class="card bg-light border-success">
            <div class="card-body">
            
                <?php   if(isset($error)){ echo $error;}    ?>

                <form name="notify" id="notify" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" >
                    <div id="" class="font-weight-bold label text-center bg-primary text-white p-2 h4 rounded">Send Notification</div>
                    <div class="form-group mt-3">
                            <label for="">Subject:</label>
                            <input type="text"  name="subject" class="form-control" required>
                    </div>

                    <div class="form-group">
                            <label for="">Meter number:</label>
                            <input type="number"  name="m_number" class="form-control" required>

                    </div>

                    <button type="submit" name="notify_btn" id="notify_btn" class="btn btn-success float-right">Send Notification</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>


<?php
include("../includes/scripts.php");
include("../includes/footer.php");
?>