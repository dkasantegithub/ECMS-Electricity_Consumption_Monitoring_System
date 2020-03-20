<?php
include("../control/security.inc.php");
include("../control/control.inc.php");
include("../includes/header.php"); 
include("../includes/navbar.php"); 


//customer validation
if(isset($_POST["customer_btn"])){

    try{
    // remove unecessary characters
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
    }catch(PDOException $e){
        header("Location: ../error/error.php?show=dberror");
        error_log("customer.php, SQL error=" .$e->getMessage());
        return;
    }

    if(!empty($fname) && !empty($lname) && !empty($contact) && !empty($email) && !empty($username) && 
    !empty($password) && !empty($region) && !empty($district) && !empty($gpscode)){

        //validate names
        if(!validate_name($fname) || !validate_name($lname) || !validate_name($username) || 
        !validate_name($district)){
            $_SESSION["error"] = "names should be only alphabets";

        //validate name-length
        }elseif(!character_len($fname, 20) || !character_len($lname, 20) || !character_len($username, 20) || 
        !character_len($district, 20)){
            $_SESSION["error"] = "names should be less than 20 characters";

        // validate email
        }elseif(!email($email)){
             $_SESSION["error"] = "email format is invalid";
        
        // validate password
        }elseif(!validate_pwd($password)){
            $_SESSION["error"] = "Password must be atleast 10 characters";

        }else{
            try{
                    $user = $_SESSION["username"];
                 //fetch id from login table
                    $query = $connection->prepare("SELECT * FROM adminlogin WHERE user_email='$user' LIMIT 1");
                    $query->execute();
                    $fetch = $query->fetch(PDO::FETCH_ASSOC);  

                if($query->rowCount() >  0 ){
                    $login_id = $fetch["login_id"];
                
                 //check whether username or email exist
                    $check = $connection->prepare("SELECT username, email FROM customer 
                    WHERE username=:uname OR email=:umail");
                    $check->execute(array(':uname'=>$username, ':umail'=>$email));
                    $row = $check->fetch(PDO::FETCH_ASSOC);

                    if($row['username']==$username){
                        $_SESSION["error"] = "username already exist!";

                    }elseif($row['email']==$email){
                        $_SESSION["error"] = "email already exist!";

                    }else{
                    //hash password
                    $pwd = password_hash($password, PASSWORD_DEFAULT);
                    
                    //insert data into db
                    $stmt = $connection->prepare("INSERT INTO customer(fname, lname, username, email,
                     password, contact, region, district, gpscode, login_id, meter_id)
                     VALUES('$fname', '$lname', '$username', '$email', '$password', '$contact', '$region', 
                            '$district', '$gpscode', '$login_id', '$meter_id')");
                    $stmt->execute();
                    $_SESSION["msg"] = '<div class="alert alert-success text-center" role="alert">customer registration SUCCESSFUL</div>';
                    }
                }

            }catch(PDOException $e){
                header("Location: ../error/error.php?show=dberror");
                error_log("customer.php, SQL error=" .$e->getMessage());
                return;
            }
        }

    }else{
        $_SESSION["error"] = "fields are required";
    }
}
?>


<!--Customer Modal -->
<div class="modal fade" id="customer" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header modal-header-danger">
                <h5 class="modal-title font-weight-bold w-100 text-center" id="modalLabel">Add Consumer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="modal-body">

                <div class="row mb-2">
                      <!-- firstname-->
                    <div class="col-6 form-group">
                        <label class="font-weight-bold" for="fname">First Name</label>
                        <input type="text" class="form-control" placeholder="Enter first name" name="fname" required>
                    </div>

                    <!-- last Name -->
                    <div class="col-6 form-group">
                        <label class="font-weight-bold" for="fname">Last Name</label>
                        <input type="text" class="form-control" placeholder="Enter last name" name="lname" required>
                    </div>
                </div>
                  
                <div class="row mb-2">
                  <!-- contact-->
                    <div class="col-6 form-group">
                        <label class="font-weight-bold" for="fname">Contact</label>
                        <input type="tel" class="form-control" placeholder="Enter phone number" name="contact" required>
                    </div>

                    <!-- email-->
                    <div class="col-6 form-group">
                        <label class="font-weight-bold" for="fname">Email</label>
                        <input type="email" class="form-control" placeholder="Enter email" name="email" required>
                    </div>
                </div>


                <div class="row mb-2">
                     <!-- username -->
                    <div class="col-6 form-group">
                        <label class="font-weight-bold" for="fname">Username</label>
                        <input type="text" class="form-control" placeholder="Enter username" name="username" required>
                    </div>

                    <!-- password -->
                    <div class="col-6 form-group">
                        <label class="font-weight-bold" for="fname">Password</label>
                        <input type="password" class="form-control" placeholder="Enter password" name="password" required>
                    </div>
                </div>

                <div class="row mb-2">
                    <!-- district-->
                    <div class="col-6 form-group">
                        <label class="font-weight-bold" for="fname">District</label>
                        <input type="text" class="form-control" placeholder="Enter district" name="district" required>
                    </div>

                    <!-- region-->
                    <div class="col-6 form-group">
                        <label class="font-weight-bold" for="fname">Region</label>
                        <select class="form-control" name="region">
                            <option value="">-Select region-</option>
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

                <div class="row mb-2">
                     <!-- gpscode-->
                    <div class="col-6 form-group">
                        <label class="font-weight-bold" for="fname">Gpscode</label>
                        <input type="text" class="form-control" placeholder="Enter gps-code" name="gpscode" required>
                    </div>

                    <!-- meter number -->
                    <?php 
                try{
                    $cont = $connection->prepare("SELECT * FROM meter WHERE meter_id NOT IN (SELECT meter_id FROM customer)");
                    $cont->execute();
                
                }catch(PDOException $e){
                    header("Location: ../error/error.php?show=dberror");
                    error_log("customer.php, SQL error=" .$e->getMessage());
                    return;
            }
                if($cont->rowCount() > 0){
            ?>
                    <div class="col-6 form-group">
                        <label class="font-weight-bold" for="fname">Meter Number</label>
                        <select name="meter_id" class="form-control" required>
                            <?php  foreach($cont as $collect){
                                 ?>
                            <option value="<?php echo htmlspecialchars($collect["meter_id"]); ?>">
                                <?php echo htmlspecialchars($collect["meter_number"]); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <?php } ?>

                </div>
                   
                    <!-- button -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="customer_btn" class="btn btn-primary">Register</button>
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
            <h6 class="m-0 font-weight-bold text-lg text-secondary">Consumers
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-secondary float-right" data-toggle="modal" data-target="#customer">
                    Add Consumer
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
                // fetch data from database
                try{
                    $stmt = $connection->prepare("SELECT customer.customer_id, customer.fname, customer.lname,
                    customer.email, customer.region, customer.district, customer.gpscode, meter.meter_number,customer.date
                    FROM customer JOIN meter ON customer.meter_id=meter.meter_id");
                    $stmt->execute();
                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                }catch(PDOException $e){
                    header("Location:../error/error.php?show=dberror");
                    error_log("customer.php, SQL error=" .$e->getMessage());
                    return;
                }
                ?>

                <table class="table table-striped table-bordered dt-responsive" id="dataTable" style="width:100%">
                    <thead class="bg-success text-bold text-white">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Region</th>
                            <th>District</th>
                            <th>Gpscode</th>
                            <th>Meter Number</th>
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
                            <td>
                                <form action="customer_detail.php" method="post">
                                    <input type="hidden" name="id"
                                        value="<?php echo htmlspecialchars($row["customer_id"]); ?>">
                                    <button type="submit" name="send" class="btn btn-secondary">
                                        <?php echo htmlspecialchars($row["customer_id"]); ?>
                                    </button>
                                </form>
                            </td>
                            <td><?php echo htmlspecialchars($row["fname"] . " " . $row["lname"]);?></td>
                            <td><?php echo htmlspecialchars($row["region"]); ?></td>
                            <td><?php echo htmlspecialchars($row["district"]); ?></td>
                            <td><?php echo htmlspecialchars($row["gpscode"]); ?></td>
                            <td><?php echo htmlspecialchars($row["meter_number"]); ?></td>
                            <td><?php echo htmlspecialchars($row["date"]); ?></td>
                            <td>
                                <form action="customer_edit.php" method="post">
                                    <input type="hidden" name="edit_id"
                                        value="<?php echo htmlspecialchars($row["customer_id"]); ?>">
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
                                
                                    <form action="customer_edit.php" method="post">
                                        <input type="hidden" name="delete_id" id="delete_id">
                                        <button type="submit" name="delete_btn" class="btn btn-warning">Yes, delete</button>
                                    </form>
                                </div>
                            </div>
                            </div>
                        </div>

                        <?php 
                        }
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