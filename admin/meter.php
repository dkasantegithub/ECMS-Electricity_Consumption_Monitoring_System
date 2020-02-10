<?php
include("security.inc.php");
include("control.inc.php");
include("includes/header.php"); 
include("includes/navbar.php"); 


//meter validation
if(isset($_POST["meter_btn"])){

    // remove unecessary characters
    $m_number = validate_data($_POST["meter_number"]);
    $region = validate_data($_POST["region"]);
    $district = validate_data($_POST["district"]);
    $gpscode = validate_data($_POST["gpscode"]);
    $status = validate_data($_POST["status"]);

    if(!empty($m_number) && !empty($region) && !empty($district) && !empty($gpscode) && !empty($status)){

        //validate name
        if(!validate_name($district)){
            $_SESSION["error"] = "name should be only alphabets";

        }else{
            try{
                 //check whether meter number exist
                    $check = $connection->prepare("SELECT meter_number FROM meter
                    WHERE meter_number=:m_number");
                    $check->execute(array(':m_number'=>$m_number));
                    $row = $check->fetch(PDO::FETCH_ASSOC);

                    if($row['meter_number']==$m_number){
                        $_SESSION["error"] = "meter number already exist!";

                    }else{
                    $user = $_SESSION["username"];
                    //fetch id from login table
                    $query = $connection->prepare("SELECT * FROM adminlogin WHERE user_email='$user' LIMIT 1");
                    $query->execute();
                    $fetch = $query->fetch(PDO::FETCH_ASSOC);

                    //fetch last id from admin login table
                    if($query->rowCount() >  0){
                    $login_id = $fetch["login_id"];

                    //insert data into meter table in db
                    $stmt = $connection->prepare("INSERT INTO meter(meter_number, region, district, 
                    gpscode, status, login_id) 
                    VALUES('$m_number', '$region', '$district', '$gpscode', '$status', '$login_id')");
                    $stmt->execute();

                    $_SESSION["msg"] = "<script>alert('Registration successfull.');</script>";
                    }
                    
                    }

            }catch(PDOException $e){
                $_SESSION["error"] = "Meter Registration Error: " . $e->getMessage();
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
                <select class="form-control" name="region" required>
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