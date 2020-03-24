<?php 
include("../control/security.inc.php");
 if(!empty($_SESSION["username"])  && !$_SESSION["superadmin"]){
        $user->redirect('../dashboard/index.php');
    }
include("../includes/header.php"); 
include("../includes/s_navbar.php"); 

    //signup function
    if(isset($_POST["signup"])){
        $fname = $_POST["fname"];
        $lname = $_POST["lname"];
        $username = $_POST["username"];
        $email = $_POST["email"];
        $pwd = $_POST["password"];
        $cpwd = $_POST["cpwd"];
        $role = $_POST["role"];

        if($user->signup($fname, $lname, $username, $email, $pwd, $cpwd,$role)){
            $_SESSION["msg"] = '<div class="alert alert-success text-center" role="alert">customer registration SUCCESSFUL</div>';

        }else{
            $_SESSION["error"] = $user->sError;
        }
            
    }
?>


<!--Admin Modal -->
<div class="modal fade" id="addadminprofile" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header modal-header-danger">
                <h5 class="modal-title font-weight-bolder w-100 text-center" id="modalLabel">Add Admin Info</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="modal-body">
                
                <div class="row mb-3">
                    <!-- firstname-->
                    <div class="col-6 form-group">
                    <label class="font-weight-bold" for="fname">First Name</label>
                        <input type="text" class="form-control" id="fname" placeholder="enter first name" name="fname" required>
                    </div>

                    <!-- lastname-->
                    <div class="col-6 form-group">
                        <label class="font-weight-bold" for="lname">Last Name</label>
                        <input type="text" class="form-control" id="lname" placeholder="enter last name" name="lname" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <!-- username-->
                    <div class="col-6 form-group">
                        <label class="font-weight-bold" for="username">Username</label>
                        <input type="text" class="form-control" id="username" placeholder="enter username" name="username" required>
                    </div>

                    <!-- email-->
                    <div class="col-6 form-group">
                        <label class="font-weight-bold" for="email">Email Address</label>
                        <input type="text" class="form-control" id="email" placeholder="enter email address" name="email" required>
                    </div>
                </div>


                <div class="row mb-3 ">
                    <!--password-->
                    <div class="col-6 form-group">
                        <label class="font-weight-bold" for="password">Password</label>
                        <input type="text" class="form-control" id="password" placeholder="enter password" name="password" required>
                    </div>
                    
                    <!--confirm password -->
                    <div class="col-6 form-group">
                        <label class="font-weight-bold" for="cpwd">Confirm Password</label>
                        <input type="text" class="form-control" id="cpwd" placeholder="confirm password" name="cpwd" required>
                    </div>
                </div>

                    <!-- Role -->
                    <input type="hidden" name="role" value="admin">

                    <!-- Button -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="signup" class="btn btn-primary">Sign up</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>



<div class="container-fluid">
    <!-- data table -->

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-lg text-secondary">Admin Info
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-secondary float-right" data-toggle="modal"
                    data-target="#addadminprofile">
                    Add Admin
                </button>
            </h6>
        </div>

        <!-- display error -->
        <?php
            if(isset($_SESSION["msg"]) && !empty($_SESSION["msg"])){
                echo $_SESSION["msg"];
                unset($_SESSION["msg"]);
            }
            if(isset($_SESSION["error"]) && !empty($_SESSION["error"])){
                echo "<div class='alert alert-danger text-center text-danger'>". $_SESSION["error"] . "</div>";
                unset($_SESSION["error"]);
            }
      ?>
        <div class="card-body">
            <div class="table-responsive">
                <?php
                    #fetch data from database
                try{
                    $stmt = $connection->prepare("SELECT * FROM adminregister");
                    $stmt->execute();
                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                }catch(PDOException $e){
                    header("Location:../error/error.php?show=dberror");
                    error_log("register.php, SQL error=" .$e->getMessage());
                    return;
                }
                ?>

                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-success text-bold text-white">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Date Created</th>
                            <th>EDIT</th>
                            <th>DELETE</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php 
                    if($stmt->rowCount() > 0){
                        while($row = $stmt->fetch()){
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row["admin_id"]); ?></td>
                            <td><?php echo htmlspecialchars($row["fname"] . " " . $row["lname"]);?></td>
                            <td><?php echo htmlspecialchars($row["username"]); ?></td>
                            <td><?php echo htmlspecialchars($row["email"]); ?></td>
                            <td><?php echo htmlspecialchars($row["admin_role"]); ?></td>
                            <td><?php echo htmlspecialchars($row["date"]); ?></td>
                            <td>
                                <form action="register_edit.php" method="post">
                                    <input type="hidden" name="edit_id"
                                        value="<?php echo htmlspecialchars($row["admin_id"]); ?>">
                                    <button type="submit" name="edit_btn" class="btn btn-info">EDIT</button>
                                </form>
                            </td>
                            <td>
                                <button type="button" class="btn btn-warning deletebtn">DELETE</button>
                            </td>
                        </tr>

                         <!-- delete Modal-->
                        <div class="modal modal-danger fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header modal-header-danger">
                                <h5 class="modal-title font-weight-bold w-100 text-center" id="exampleModalLabel">Delete Confirmation</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                </div>
                                <div class="modal-body w-100 text-center">Are you sure you want to delete this?</div>
                                
                                <div class="modal-footer">
                                    <button class="btn btn-success" type="button" data-dismiss="modal">No, cancel</button>
                                
                                    <form action="register_edit.php" method="post">
                                        <input type="hidden" name="delete_id" id="delete_id">
                                        <button type="submit" name="delete_btn" class="btn btn-warning">Yes, delete</button>
                                    </form>
                                </div>
                            </div>
                            </div>
                        </div>

                        <?php }
                    }
                    ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>

<?php
include("../includes/scripts.php");
include("../includes/footer.php");
?>

<!-- delete modal script -->
<script>
    $(document).ready( function() {
        $('.deletebtn').on('click', function(){
            $('#delete').modal('show');

            $tr = $(this).closest('tr');
            var data = $tr.children("td").map(function(){
                return $(this).text();
            }).get();

            $('#delete_id').val(data[0]);
        });
    });
</script>