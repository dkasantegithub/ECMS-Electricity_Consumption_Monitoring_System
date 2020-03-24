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
    <div class="row mt-5">
        <div class="col-7 mx-auto">
            <div class="card shadow mb-4">
                <div class="card-header bg-secondary py-3">
                    <h6 class="m-0 font-weight-bold text-white text-center">Edit Admin Profile </h6>
                </div>
                <div class="card-body">
            <?php
            //update admin info
            if(isset($_POST["update_btn"])){
                    $id = trim(htmlspecialchars($_POST["edit_id"]));
                    $fname = trim(htmlspecialchars($_POST["fname"]));
                    $lname = trim(htmlspecialchars($_POST["lname"]));
                    $username = trim(htmlspecialchars($_POST["username"]));
                    $email = trim(htmlspecialchars($_POST["email"]));
                    $password = trim(htmlspecialchars($_POST["password"]));
                    $role = trim(htmlspecialchars($_POST["role"]));

                    //hash password
                    $pwd = password_hash($password, PASSWORD_DEFAULT);

                    $stmt = $connection->prepare("UPDATE adminregister SET fname='$fname', lname='$lname',
                            username='$username', email='$email', password='$pwd', admin_role='$role' WHERE admin_id='$id'");
                    $success = $stmt->execute();

                    if($success){
                        $_SESSION["msg"] = '<div class="alert alert-success text-center" role="alert">Update was SUCCESSFUL</div>';
                        header("location: register.php");
                    }else{
                        $_SESSION["msg"] = '<div class="alert alert-danger text-center" role="alert">Update FAILED</div>';
                        header("location: register.php");
                    }
                }
            
            
            //delete admin info from DB
            if(isset($_POST["delete_btn"])){
                $id = trim(htmlspecialchars($_POST["delete_id"]));

                $stmt = $connection->prepare("DELETE FROM adminregister WHERE admin_id='$id'");
                 $success = $stmt->execute();

                if($success){
                    $_SESSION["msg"] = '<div class="alert alert-success text-center" role="alert">Deletion was SUCCESSFUL</div>';
                    header("location: register.php");
                }else{
                    $_SESSION["msg"] = '<div class="alert alert-danger text-center" role="alert">Deletion FAILED</div>';
                    header("location: register.php");
                }
            }

             //edit function
            if(isset($_POST["edit_btn"])){
                $id = $_POST["edit_id"];

                try{
                //retrieve data from table using id
                $stmt = $connection->prepare("SELECT * FROM adminregister WHERE admin_id=:id");
                $stmt->execute(array(":id"=>$id));
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                }catch(PDOException $e){
                    header("Location:../error/error.php?show=dberror");
                    error_log("customer_edit.php, SQL error=" .$e->getMessage());
                    return;
                }
            

        ?>

                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <input type="hidden" name="edit_id" value="<?php echo $row['admin_id']; ?>">
                        
                        <div class="row">
                            <!-- firstname-->
                            <div class="col-6 form-group">
                                <label class="font-weight-bold">First Name</label>
                                <input type="text" name="fname" value="<?php echo $row['fname'] ?? "first name"; ?>"
                                    class="form-control" required>
                            </div>

                            <!-- lastname-->
                            <div class="col-6 form-group">
                                <label class="font-weight-bold">Last Name</label>
                                <input type="text" name="lname" value="<?php echo $row['lname'] ?? "last name"; ?>"
                                    class="form-control" required>
                            </div>
                        </div>

                        
                        <div class="row">
                            <!-- username-->
                            <div class="col-6 form-group">
                                <label class="font-weight-bold">Username</label>
                                <input type="text" name="username" value="<?php echo $row['username'] ?? "username"; ?>"
                                    class="form-control" required>
                            </div>


                            <!-- email-->
                            <div class="col-6 form-group">
                                <label class="font-weight-bold">Email</label>
                                <input type="email" name="email" value="<?php echo $row['email'] ?? "email"; ?>"
                                    class="form-control" required>
                            </div>
                        </div>

                        <div class="row">
                            <!--password-->
                            <div class="col-6 form-group">
                                <label class="font-weight-bold">Password</label>
                                <div class="form-inline">
                                    <input type="password" id="pswd" name="password" placeholder="update password"
                                        class="form-control pr-5" required>
                                    <button type="button" id="btn" class="bg-info btn btn-2x rounded border-0">
                                        <i class="fas fa-eye fa-lg text-white"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- admin role-->
                            <div class="col-6 form-group">
                                <label class="font-weight-bold">Role</label>
                                <select name="role" class="form-control">
                                    <option value="admin" <?php if($row['admin_role']=='admin') echo "selected"; ?>>Admin</option>
                                    <option value="superadmin" <?php if($row['admin_role']=='superadmin') echo "selected"; ?>>Super-admin</option>
                                </select>
                            </div>
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
    }
include("../includes/scripts.php");
include("../includes/footer.php");
?>