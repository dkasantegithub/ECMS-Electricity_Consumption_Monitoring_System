<?php
include("security.inc.php");
include("control.inc.php");
include("includes/header.php"); 
include("includes/navbar.php"); 



//meter validation
if(isset($_POST["customer_btn"])){

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

    if(!empty($fname) && !empty($lname) && !empty($contact) && !empty($email) && !empty($username) && 
    !empty($password) && !empty($region) && !empty($district) && !empty($gpscode)){

        //validate names
        if(!validate_name($fname) || !validate_name($lname) || !validate_name($username) || 
        !validate_name($district)){
            $_SESSION["error"] = "names should be only alphabets";

        //validate name-length
        }elseif(!character_len($fname) || !character_len($lname) || !character_len($username) || 
        !character_len($district)){
            $_SESSION["error"] = "names should be less than 20 characters";

        // validate email
        }elseif(!email($email)){
             $_SESSION["error"] = "email format is invalid";
        
        // validate password
        }elseif(!validate_pwd($password)){
            $_SESSION["error"] = "Password must be atleast 10 characters";

        }else{
            try{
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
                     password, contact, region, district, gpscode)
                     VALUES('$fname', '$name', '$username', '$email', '$password', '$contact', '$region', 
                            '$district', '$gpscode')");
                    $stmt->execute();
                    
                    }

            }catch(PDOException $e){
                $_SESSION["error"] = "Signup Error: " . $e->getMessage();
            }
        }

    }else{
        $_SESSION["error"] = "fields are required";
    }
}
?>


<!--Customer Modal -->
<div class="modal fade" id="meter" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Add Meter</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="modal-body">   
    
            <!-- meter number-->
            <div class="form-group">
                <input type="number" class="form-control" placeholder="meter number" name="meter_number" required>
            </div>
            
            <!-- district-->
            <div class="form-group">
                <input type="text" class="form-control" placeholder="district" name="district" required>
            </div>
            
            <!-- region-->
            <div class="form-group"> 
                <select class="form-control" name="region">
                <option value="">-regions-</option>
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
                <input type="text" class="form-control" placeholder="gps-code" name="gpscode" required>
            </div>

            <!--status-->
            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="unactive">Unactive</option>
                    <option value="active">Active</option>
                </select>
            </div>

            <!-- button -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name="meter_btn" class="btn btn-primary">Add Meter</button>
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
            <h6 class="m-0 font-weight-bold text-lg text-primary">Meter Info
                 <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#meter">
                Add Meter
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
                //     #fetch data from database
                try{
                    $stmt = $connection->prepare("SELECT * FROM meter");
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
                            <th>Meter Number</th>
                            <th>Region</th>
                            <th>District</th>
                            <th>Gpscode</th>
                            <th>Status</th>
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
                            <td><?php echo htmlspecialchars($row["meter_id"]); ?></td>
                            <td><?php echo htmlspecialchars($row["meter_number"]); ?></td>
                            <td><?php echo htmlspecialchars($row["region"]); ?></td>
                            <td><?php echo htmlspecialchars($row["district"]); ?></td>
                            <td><?php echo htmlspecialchars($row["gpscode"]); ?></td>
                            <td><?php echo htmlspecialchars($row["status"]); ?></td>
                            <td><?php echo htmlspecialchars($row["date"]); ?></td>
                            <td> 
                                <form action="meter_edit.php" method="post">
                                    <input type="hidden" name="edit_id" value="<?php echo htmlspecialchars($row["meter_id"]); ?>">
                                    <button type="submit" name="edit_btn" class="btn btn-success">EDIT</button>
                                </form>
                            </td>
                            <td> 
                                <form action="meter_edit.php" method="post">
                                    <input type="hidden" name="delete_id" value="<?php  echo htmlspecialchars($row["meter_id"]); ?>">
                                    <button type="submit" name="delete_btn" class="btn btn-danger">DELETE</button>
                                </form>
                            </td>
                        </tr>
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
include("includes/scripts.php");
include("includes/footer.php");
?>