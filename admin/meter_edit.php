<?php 
include("security.inc.php");
include("control.inc.php");
include("includes/header.php"); 
//include("includes/navbar.php"); 
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
            //edit function
            if(isset($_POST["edit_btn"])){
                $id = $_POST["edit_id"];

                //retrieve data from table using id
                $stmt = $connection->prepare("SELECT * FROM meter WHERE meter_id=:id");
                $stmt->execute(array(":id"=>$id));
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
            }

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
                        $_SESSION["msg"] = "<script>alert('Update successfull.');</script>";
                        header("location: meter.php");
                    }else{
                        $_SESSION["msg"] = "<script>alert('Update NOT successfull.');</script>";
                        header("location: meter.php");
                    }
                }
            
            
            //delete meter info from DB
            if(isset($_POST["delete_btn"])){
                $id = trim(htmlspecialchars($_POST["delete_id"]));

                $stmt = $connection->prepare("DELETE FROM meter WHERE meter_id='$id'");
                 $success = $stmt->execute();                                                              
                 
                 if($success){
                    $_SESSION["msg"] = "<script>alert('Data is successfully DELETED.');</script>";
                    header("location: meter.php");
                }else{
                    $_SESSION["msg"] = "<script>alert('Data NOT DELETED.');</script>";
                    header("location: meter.php");
                }
            }
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
                    <select class="form-control" name="region">
                        <option value="">-Region-</option>
                        <option value="accra">Greater Accra</option>
                        <option value="ashanti">Ashanti</option>
                        <option value="eastern">Eastern</option>
                        <option value="central">Central</option>
                        <option value="volta">Volta</option>
                        <option value="uwest">Upper West</option>
                        <option value="ueast">Upper East</option>
                        <option value="neast">North East</option>
                        <option value="northern">Northern</option>
                        <option value="savannah">Savannah</option>
                        <option value="oti">Oti</option>
                        <option value="bonoeast">Bono East</option>
                        <option value="brongahafo">Brong Ahafo</option>
                        <option value="ahafo">Ahafo</option>
                        <option value="westernnorth">Western North</option>
                        <option value="western">Western</option>
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
                        <option value="unactive">Unactive</option>
                        <option value="active">Active</option>
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
include("includes/scripts.php");
include("includes/footer.php");
?>