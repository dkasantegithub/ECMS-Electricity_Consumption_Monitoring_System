<?php 
include("../control/security.inc.php");
if(!$_SESSION["superadmin"]){
    $user->redirect('../dashboard/index.php');
    }
include("../includes/header.php"); 
//include("includes/s_navbar.php"); 
?>

<div class="container-fluid">
    <!-- data table -->
    <div class="row">
        <div class="col-7 mx-auto">
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

            //update admin info
            if(isset($_POST["update_btn"])){
                    $id = trim(htmlspecialchars($_POST["edit_id"]));
                    $fname = trim(htmlspecialchars($_POST["fname"]));
                    $lname = trim(htmlspecialchars($_POST["lname"]));
                    $username = trim(htmlspecialchars($_POST["username"]));
                    $email = trim(htmlspecialchars($_POST["email"]));
                    $password = trim(htmlspecialchars($_POST["password"]));
                    $role = trim(htmlspecialchars($_POST["role"]));

                    $stmt = $connection->prepare("UPDATE adminregister SET fname='$fname', lname='$lname',
                            username='$username', email='$email', password='$password', admin_role='$role' WHERE admin_id='$id'");
                    $success = $stmt->execute();

                    if($success){
                        $_SESSION["msg"] = "<script>alert('Update successfull.');</script>";
                        header("location: register.php");
                    }else{
                        $_SESSION["msg"] = "<script>alert('Update NOT successfull.');</script>";
                        header("location: register.php");
                    }
                }
            
            
            //delete admin info from DB
            if(isset($_POST["delete_btn"])){
                $id = trim(htmlspecialchars($_POST["delete_id"]));

                $stmt = $connection->prepare("DELETE FROM adminregister WHERE admin_id='$id'");
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
                        <input type="hidden" name="edit_id" value="<?php echo $row['admin_id']; ?>">

                        <!-- firstname-->
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="fname" value="<?php echo $row['fname'] ?? "first name"; ?>"
                                class="form-control" required>
                        </div>

                        <!-- lastname-->
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" name="lname" value="<?php echo $row['lname'] ?? "last name"; ?>"
                                class="form-control" required>
                        </div>


                        <!-- username-->
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" value="<?php echo $row['username'] ?? "username"; ?>"
                                class="form-control" required>
                        </div>


                        <!-- email-->
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" value="<?php echo $row['email'] ?? "email"; ?>"
                                class="form-control" required>
                        </div>


                        <!--password-->
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" value="<?php echo $row['password'] ?? "password"; ?>"
                                class="form-control" required>
                        </div>

                        <!--role-->
                        <div class="form-group">
                            <label>Role</label>
                            <select name="role" class="form-control">
                                <option value="admin">Admin</option>
                                <option value="superadmin">Super-admin</option>
                            </select>
                        </div>

                        <!-- Button -->
                        <div class="text-right">
                            <a href="register.php" class="btn btn-danger">Cancel</a>
                            <button type="submit" name="update_btn" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<?php
include("../includes/scripts.php");
include("../includes/footer.php");
?>