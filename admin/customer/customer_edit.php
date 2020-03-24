<?php 
include("../control/security.inc.php");
include("../control/control.inc.php");
include("../includes/header.php"); 
include("../includes/navbar.php"); 
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

                    try{
                    $stmt = $connection->prepare("UPDATE customer SET fname='$fname', lname='$lname',
                            username='$username', email='$email', password='$password',
                            contact='$contact', region='$region', district='$district',
                            gpscode='$gpscode', meter_id='$meter_id' WHERE customer_id='$id'");
                    $success = $stmt->execute();
                    }catch(PDOException $e){
                    header("Location:../error/error.php?show=dberror");
                    error_log("customer_edit.php, SQL error=" .$e->getMessage());
                    return;
                }

                    if($success){
                        $_SESSION["msg"] = '<div class="alert alert-success text-center" role="alert">Update was SUCCESSFUL</div>';
                        header("location: customer.php");
                    }else{
                        $_SESSION["msg"] = '<div class="alert alert-danger text-center" role="alert">Update FAILED</div>';
                        header("location: customer.php");
                    }
                }
            
            
            //delete customer info from DB
            if(isset($_POST["delete_btn"])){
                $id = trim(htmlspecialchars($_POST["delete_id"]));

                $stmt = $connection->prepare("DELETE FROM customer WHERE customer_id='$id'");
                 $success = $stmt->execute();

                if($success){
                    $_SESSION["msg"] = '<div class="alert alert-success text-center" role="alert">Deletion was SUCCESSFUL</div>';
                    header("location: customer.php");
                }else{
                    $_SESSION["msg"] = '<div class="alert alert-danger text-center" role="alert">Deletion FAILED</div>';
                    header("location: customer.php");
                }
            }

            //edit function
            if(isset($_POST["edit_btn"])){
                $id = $_POST["edit_id"];

                try{
                //retrieve data from table using id
                $stmt = $connection->prepare("SELECT * FROM customer WHERE customer_id=:id");
                $stmt->execute(array(":id"=>$id));
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                }catch(PDOException $e){
                    header("Location:../error/error.php?show=dberror");
                    error_log("customer_edit.php, SQL error=" .$e->getMessage());
                    return;
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
                        <div class="form-inline">
                            <input type="password" class="form-control pr-5" id="pswd" placeholder="password" value="<?php echo $row['password'] ?? ""; ?>" name="password"
                            required>
                            <button type="button" id="btn" class="bg-info btn btn-2x rounded border-0 ">
                                <i class="fas fa-eye fa-lg text-white"></i>
                            </button>
                        </div>
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
                        <label class="font-weight-bold" for="fname" >Region</label>
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
                    try{
                        $mid =$row['meter_id'];
                        $cont = $connection->prepare("SELECT * FROM meter  WHERE meter_id NOT IN (SELECT meter_id FROM customer WHERE meter_id != '$mid')");
                        $cont->execute();
                        if($cont->rowCount() > 0){
                    ?>
                    <div class="col-6 form-group">
                        <label class="font-weight-bold" for="fname">Meter Number</label>
                        <select name="meter_id" class="form-control" required> 
                        <?php  foreach($cont as $collect){
                             ?>
                            <option value="<?php echo htmlspecialchars($collect["meter_id"]); ?>"  <?php if($collect['meter_id']== $row['meter_id']) echo "selected"; ?> ><?php echo htmlspecialchars($collect["meter_number"]); ?></option>
                        <?php }?>
                        </select>
                    </div>
                    <?php }
                    }catch(PDOException $e){
                        header("Location:../error/error.php?show=dberror");
                        error_log("customer_edit.php, SQL error=" .$e->getMessage());
                        return;
                    }
                     ?>
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
    }
include("../includes/scripts.php");
include("../includes/footer.php");
?>