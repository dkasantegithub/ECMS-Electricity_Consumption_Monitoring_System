<?php 
require_once("../php-files/connection.inc.php");

include("includes/header.php"); 
include("includes/navbar.php"); 
?>



<div class="container-fluid">
    <!-- data table -->

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Admin Profile </h6>
        </div>

        <div class="card-body">

        <?php
            //edit function
            if(isset($_POST["edit_btn"])){
                $id = $_POST["edit_id"];

                //retrieve data from table using id
                $stmt = $connection->prepare("SELECT * FROM adminregister WHERE admin_id=:id");
                $stmt->execute(array(":id"=>$id));
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
    }

        ?>
        
         <!-- firstname-->
            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="fname" value="<?php echo $row['fname']; ?>" class="form-control" required>
            </div>

            <!-- lastname-->
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="lname" value="<?php echo $row['lname']; ?>" class="form-control" required>
            </div>


            <!-- username-->
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" value="<?php echo $row['username']; ?>" class="form-control" required>
            </div>


            <!-- email-->
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="<?php echo $row['email']; ?>" class="form-control" required>
            </div>


            <!--password-->
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" value="<?php echo $row['password']; ?>" class="form-control" required>
            </div>

            <!-- Button -->
            <div class="text-right">
                <a href="register.php" class="btn btn-danger">Cancel</a>
                <button type="submit" name="signup" class="btn btn-primary">Update</button>
            </div>

        </div>
    </div>
</div>
</div>


<?php
include("includes/scripts.php");
include("includes/footer.php");
?>