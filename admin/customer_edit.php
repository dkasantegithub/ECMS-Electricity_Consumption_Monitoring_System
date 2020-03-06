<?php 
include("security.inc.php");
include("control.inc.php");
include("includes/header.php"); 
//include("includes/navbar.php"); 
?>


<div class="container-fluid">
    <!-- data table -->
    <div class="row mt-3">
    <div class="col-9 mx-auto">
    <div class="card shadow">
        <div class="card-header bg-secondary py-3">
            <h5 class="m-0 font-weight-bold text-white w-100 text-center">Edit Customer Info </h5>
        </div>
        <div class="card-body">

        <?php
            //edit function
            if(isset($_POST["edit_btn"])){
                $id = $_POST["edit_id"];

                //retrieve data from table using id
                $stmt = $connection->prepare("SELECT * FROM customer WHERE customer_id=:id");
                $stmt->execute(array(":id"=>$id));
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
            }

            //update customer info
            if(isset($_POST["update_btn"])){
                    $id =  validate_data($_POST["edit_id"]);
                    $fname = validate_data($_POST["fname"]);
                    $lname = validate_data($_POST["lname"]);
                    $contact =validate_data($_POST["contact"]);
                    $email = validate_data($_POST["email"]);
                    $username = validate_data($_POST["username"]);
                    $password = validate_data($_POST["password"]);
                    $region = validate_data($_POST["region"]);
                    $district = validate_data($_POST["district"]);
                    $gpscode = validate_data($_POST["gpscode"]);
                    $meter_id = validate_data($_POST["meter_id"]);

                    $stmt = $connection->prepare("UPDATE customer SET fname='$fname', lname='$lname',
                            username='$username', email='$email', password='$password',
                            contact='$contact', region='$region', district='$district',
                            gpscode='$gpscode', meter_id='$meter_id' WHERE customer_id='$id'");
                    $success = $stmt->execute();

                    if($success){
                        $_SESSION["msg"] = "<script>alert('Update successfull.');</script>";
                        header("location: customer.php");
                    }else{
                        $_SESSION["msg"] = "<script>alert('Update NOT successfull.');</script>";
                        header("location: customer.php");
                    }
                }
            
            
            //delete customer info from DB
            if(isset($_POST["delete_btn"])){
                $id = trim(htmlspecialchars($_POST["delete_id"]));

                $stmt = $connection->prepare("DELETE FROM customer WHERE customer_id='$id'");
                 $success = $stmt->execute();

                if($success){
                    $_SESSION["msg"] = "<script>alert('Data is successfully DELETED.');</script>";
                    header("location: register.php");
                }else{
                    $_SESSION["msg"] = "<script>alert('Data NOT DELETED.');</script>";
                    header("location: register.php");
                }
            }


        ?>


            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <input type="hidden" name="edit_id" value="<?php echo $row['customer_id']; ?>">

                <div class="row">
                    <!-- firstname-->
                    <div class="col-6 form-group">
                        <label class="font-weight-bold" for="fname">First Name</label>
                        <input type="text" class="form-control" placeholder="first name" value="<?php echo $row['fname'] ?? ""; ?>" name="fname" required>
                    </div>

                    <!-- last Name -->
                    <div class="col-6 form-group">
                        <label class="font-weight-bold" for="fname">Last Name</label>
                        <input type="text" class="form-control" placeholder="last name" value="<?php echo $row['lname'] ?? ""; ?>" name="lname" required>
                    </div>
                </div>

                <div class="row">
                    <!-- contact-->
                    <div class="col-6 form-group">
                        <label class="font-weight-bold" for="fname">Phone Number</label>
                        <input type="tel" class="form-control" placeholder="contact" value="<?php echo $row['contact'] ?? ""; ?>" name="contact"
                            required>
                    </div>

                    <!-- email-->
                    <div class="col-6 form-group">
                        <label class="font-weight-bold" for="fname">Email</label>
                        <input type="email" class="form-control" placeholder="email" value="<?php echo $row['email'] ?? ""; ?>"  name="email" required>
                    </div>
                </div>

                <div class="row">
                    <!-- username -->
                    <div class="col-6 form-group">
                        <label class="font-weight-bold" for="fname">Username</label>
                        <input type="text" class="form-control" placeholder="username" value="<?php echo $row['username'] ?? ""; ?>" name="username"
                            required>
                    </div>

                    <!-- password -->
                    <div class="col-6 form-group">
                        <label class="font-weight-bold" for="fname">Password</label>
                        <input type="password" class="form-control" placeholder="password" value="<?php echo $row['password'] ?? ""; ?>" name="password"
                            required>
                    </div>
                </div>

                <div class="row">
                    <!-- district-->
                    <div class="col-6 form-group">
                        <label class="font-weight-bold" for="fname">District</label>
                        <input type="text" class="form-control" placeholder="district" value="<?php echo $row['district'] ?? ""; ?>" name="district"
                            required>
                    </div>

                    <!-- region-->
                    <div class="col-6 form-group">
                        <label class="font-weight-bold" for="fname">Region</label>
                        <select class="form-control" name="region" required>
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
                </div>

                <div class="row">
                    <!-- gpscode-->
                    <div class="col-6 form-group">
                        <label class="font-weight-bold" for="fname">Gpscode</label>
                        <input type="text" class="form-control" placeholder="gpscode" value="<?php echo $row['gpscode'] ?? ""; ?>" name="gpscode"
                            required>
                    </div>

                    <!-- meter number -->
                    <?php 
                        $cont = $connection->prepare("SELECT * FROM meter");
                        $cont->execute();
                        if($cont->rowCount() > 0){
                    ?>
                    <div class="col-6 form-group">
                        <label class="font-weight-bold" for="fname">Meter Number</label>
                        <select name="meter_id" class="form-control" required> 
                        <?php  foreach($cont as $collect){ ?>
                            <option value="<?php echo htmlspecialchars($collect["meter_id"]); ?>"><?php echo htmlspecialchars($collect["meter_number"]); ?></option>
                        <?php } ?>
                        </select>
                    </div>
                    <?php } ?>
                </div>

                <!-- button -->
                <div class="modal-footer">
                    <a href="customer.php" class="btn btn-danger">Cancel</a>
                    <button type="submit" name="update_btn" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
</div>

<?php
include("includes/scripts.php");
include("includes/footer.php");
?>