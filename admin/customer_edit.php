<?php 
include("security.inc.php");
include("control.inc.php");
include("includes/header.php"); 
//include("includes/navbar.php"); 
?>


<div class="container-fluid">
    <!-- data table -->
    <div class="row">
    <div class="col-7 mx-auto">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="m-0 font-weight-bold text-primary text-center">Edit Customer Info </div>
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
                    $fname = validate_data($_POST["fname"]);
                    $lname = validate_data($_POST["lname"]);
                    $contact =validate_data($_POST["contact"]);
                    $email = validate_data($_POST["email"]);
                    $username = validate_data($_POST["username"]);
                    $password = validate_data($_POST["password"]);
                    $region = validate_data($_POST["region"]);
                    $district = validate_data($_POST["district"]);
                    $gpscode = validate_data($_POST["gpscode"]);

                    $stmt = $connection->prepare("UPDATE customer SET fname='$fname', lname='$lname',
                            username='$username', email='$email', password='$password',
                            contact='$contact', region='$region', district='$district',
                            gpscode='$gpscode' WHERE customer_id='$id'");
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

                <!-- firstname-->
                <div class="form-group">
                    <input type="text" class="form-control" value="<?php echo $row['fname'] ?? "First Name"; ?>" name="fname" required>
                </div>

                <!-- last Name -->
                <div class="form-group">
                    <input type="text" class="form-control" value="<?php echo $row['lname'] ?? "Last Name"; ?>" name="lname" required>
                </div>

                <!-- contact-->
                <div class="form-group">
                    <input type="tel" class="form-control" value="<?php echo $row['contact'] ?? "Contact"; ?>" name="contact"
                        required>
                </div>

                <!-- email-->
                <div class="form-group">
                    <input type="email" class="form-control" value="<?php echo $row['email'] ?? "Email"; ?>" required>
                </div>

                <!-- username -->
                <div class="form-group">
                    <input type="text" class="form-control" value="<?php echo $row['username'] ?? "Username"; ?>" name="username"
                        required>
                </div>

                <!-- password -->
                <div class="form-group">
                    <input type="password" class="form-control" value="<?php echo $row['password'] ?? "Password"; ?>" name="password"
                        required>
                </div>

                <!-- district-->
                <div class="form-group">
                    <input type="text" class="form-control" value="<?php echo $row['district'] ?? "District"; ?>" name="district"
                        required>
                </div>

                <!-- region-->
                <div class="form-group">
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
                <div class="form-group">
                    <input type="text" class="form-control" value="<?php echo $row['gpscode'] ?? "Gps-code"; ?>" name="gpscode"
                        required>
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