<?php 
require_once("../php-files/connection.inc.php");

include("includes/header.php"); 
include("includes/navbar.php"); 

    //signup function
    if(isset($_POST["signup"])){
        $fname = $_POST["fname"];
        $lname = $_POST["lname"];
        $username = $_POST["username"];
        $email = $_POST["email"];
        $pwd = $_POST["password"];
        $cpwd = $_POST["cpwd"];

        if($user->signup($fname, $lname, $username, $email, $pwd, $cpwd)){
            echo "<script>alert('Registration successfull.');</script>";
        }else{
            $error = $user->sError;
        }
    }

?>


<!-- Modal -->
<div class="modal fade" id="addadminprofile" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Add Admin Info</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="modal-body">
        <!-- display error -->
        <?php if(isset($error)) {  ?>
            <div class="alert alert-danger text-danger text-center mb-3">
              <?php echo $error; ?>
            </div>
        <?php } ?> 
            
            <!-- firstname-->
            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="fname" class="form-control" placeholder="enter firstname" required>
            </div>

            <!-- lastname-->
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="lname" class="form-control" placeholder="enter lastname" required>
            </div>


            <!-- username-->
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" placeholder="enter username" required>
            </div>


            <!-- email-->
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" placeholder="enter email" required>
            </div>


            <!--password-->
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="enter password" required>
            </div>
            <!--confirm password -->
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="cpwd" class="form-control" placeholder="confirm password" required>
            </div>

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
            <h6 class="m-0 font-weight-bold text-primary">Admin Profile
                 <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addadminprofile">
                Add Admin Profile
                </button>
            </h6>
        </div>

        
    <!-- display error -->
    <?php if(isset($error)) {  ?>
        <div class="alert alert-danger text-danger text-center mb-3">
            <?php echo $error; ?>*
        </div>
    <?php } ?> 


        <div class="card-body">
            <div class="table-responsive">
                <?php
                    #fetch data from database
                try{
                    $stmt = $connection->prepare("SELECT * FROM adminregister");
                    $stmt->execute();
                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                }catch(PDOException $e){
                    echo "Connection Error: " . $e->getMessage();
                }
                ?>

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Date : Time Created</th>
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
                            <td><?php echo htmlspecialchars($row["date"] . " : " . $row["time"]); ?></td>
                            <td> 
                                <form action="register_edit.php" method="post">
                                    <input type="hidden" name="edit_id" value="<?php echo htmlspecialchars($row["admin_id"]); ?>">
                                    <button type="submit" name="edit_btn" class="btn btn-success">EDIT</button>
                                </form>
                            </td>
                            <td> 
                                <button type="submit" class="btn btn-danger">DELETE</button>
                            </td>
                        </tr>
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
include("includes/scripts.php");
include("includes/footer.php");
?>