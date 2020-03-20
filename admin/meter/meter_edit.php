<?php 
include("../control/security.inc.php");
include("../control/control.inc.php");
include("../includes/header.php"); 
// include("../includes/navbar.php"); 
?>


<div class="container-fluid">
    <!-- data table -->
    <div class="row mt-5">
        <div class="col-7 mx-auto">
            <div class="card shadow">
                <div class="card-header bg-secondary py-3">
                    <h5 class="m-0 font-weight-bold text-white w-100 text-center">Edit Meter Info </h5>
                </div>
                <div class="card-body">

            <?php

            try{

            //update meter info
            if(isset($_POST["update_btn"])){
                    $id = $_POST["edit_id"];
                    $meter_number = $_POST["meter_number"];
                    $region = $_POST["region"];
                    $district = $_POST["district"];
                    $gpscode = $_POST["gpscode"];
                    $status = $_POST["status"];

                    $user = $_SESSION["username"];

                    
                    //fetch id from login table
                    $query = $connection->prepare("SELECT * FROM adminlogin WHERE user_email='$user' LIMIT 1");
                    $query->execute();
                    $fetch = $query->fetch(PDO::FETCH_ASSOC);

                    //fetch last id from admin login table
                    if($query->rowCount() >  0){
                    $login_id = $fetch["login_id"];

                    $state = $connection->prepare("UPDATE meter SET meter_number='$meter_number',
                            region='$region', district='$district', gpscode='$gpscode', 
                            status='$status' WHERE meter_id='$id'");
                    $success = $state->execute();

                    }

                    if($success){
                        $_SESSION["msg"] = '<div class="alert alert-success text-center" role="alert">meter Update SUCCESSFUL</div>';
                        header("location: meter.php");
                    }else{
                        $_SESSION["msg"] = '<div class="alert alert-danger text-center" role="alert">meter Update FAILED</div>';
                        header("location: meter.php");
                    }
                }
            
            
            //delete meter info from DB
            if(isset($_POST["delete_btn"])){
                $id = trim(htmlspecialchars($_POST["delete_id"]));

                $stmt = $connection->prepare("DELETE FROM meter WHERE meter_id='$id'");
                 $success = $stmt->execute();                                                              
                 
                 if($success){
                    $_SESSION["msg"] = '<div class="alert alert-success text-center" role="alert"> data successfully deleted</div>';
                    header("location: meter.php");
                }else{
                    $_SESSION["msg"] = '<div class="alert alert-success text-center" role="alert"> data NOT deleted</div>';
                    header("location: meter.php");
                }
            }
        }catch(PDOException $e){
                header("Location:../error/error.php?show=dberror");
                error_log("meter_edit.php, SQL error=" .$e->getMessage());
                return;
                }


            //edit function
            if(isset($_POST["edit_btn"])){
                $id = $_POST["edit_id"];

                //retrieve data from table using id
                $stmt = $connection->prepare("SELECT * FROM meter WHERE meter_id=:id");
                $stmt->execute(array(":id"=>$id));
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
        ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <input type="hidden" name="edit_id" value="<?php echo $row['meter_id']; ?>">

            <div class="row">
                <!-- meter number-->
                <div class="col-6 form-group">
                     <label class="font-weight-bold">Meter Number</label>
                    <input type="text" class="form-control" value="<?php echo $row['meter_number'] ?? ""; ?>"
                        placeholder="Meter Number" name="meter_number" required>
                </div>

                <!-- district-->
                <div class="col-6 form-group">
                    <label class="font-weight-bold">District</label>
                    <input type="text" class="form-control" value="<?php echo $row['district'] ?? ""; ?>"
                        placeholder="District" name="district" required>
                </div>
            </div>

            <div class="row">
                <!-- region-->
                <div class="col-6 form-group">
                    <label class="font-weight-bold">Region</label>
                    <select class="form-control" name="region" required>
                        <option value="accra" <?php if($row['region']=='accra') echo "selected"; ?> >Greater Accra</option>
                            <option value="ashanti" <?php if($row['region']=='ashanti') echo "selected"; ?>>Ashanti</option>
                            <option value="eastern" <?php if($row['region']=='eastern') echo "selected"; ?>>Eastern</option>
                            <option value="central" <?php if($row['region']=='central') echo "selected"; ?>>Central</option>
                            <option value="volta" <?php if($row['region']=='volta') echo "selected"; ?>>Volta</option>
                            <option value="uwest" <?php if($row['region']=='uwest') echo "selected"; ?>>Upper West</option>
                            <option value="ueast" <?php if($row['region']=='ueast') echo "selected"; ?>>Upper East</option>
                            <option value="neast" <?php if($row['region']=='neast') echo "selected"; ?>>North East</option>
                            <option value="northern" <?php if($row['region']=='northern') echo "selected"; ?>>Northern</option>
                            <option value="savannah" <?php if($row['region']=='savannah') echo "selected"; ?>>Savannah</option>
                            <option value="oti" <?php if($row['region']=='oti') echo "selected"; ?>>Oti</option>
                            <option value="bonoeast" <?php if($row['region']=='bonoeast') echo "selected"; ?>>Bono East</option>
                            <option value="brongahafo" <?php if($row['region']=='brongahafo') echo "selected"; ?>>Brong Ahafo</option>
                            <option value="ahafo" <?php if($row['region']=='ahafo') echo "selected"; ?>>Ahafo</option>
                            <option value="westernnorth" <?php if($row['region']=='westernnorth') echo "selected"; ?>>Western North</option>
                            <option value="western" <?php if($row['region']=='western') echo "selected"; ?>>Western</option>
                    </select>
                </div>

                <!-- gpscode-->
                <div class="col-6 form-group">
                    <label class="font-weight-bold">Gpscode</label>
                    <input type="text" class="form-control" value="<?php echo $row['gpscode'] ?? ""; ?>"
                        name="gpscode" placeholder="gpscode" required>
                </div>
            </div>

            <div class="row">

          
                <!--status-->
                <div class="col-6 form-group">
                    <label class="font-weight-bold">Status</label>
                    <select name="status" class="form-control">
                        <option value="unactive" <?php if($row['status']=='unactive') echo "selected"; ?>>Unactive</option>
                        <option value="active" <?php if($row['status']=='active') echo "selected"; ?>>Active</option>
                    </select>
                </div>
            </div>

                <!-- button -->
                <div class="modal-footer">
                    <a href="meter.php" class="btn btn-danger">Cancel</a>
                    <button type="submit" name="update_btn" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>

<?php
            }
include("../includes/scripts.php");
include("../includes/footer.php");
?>