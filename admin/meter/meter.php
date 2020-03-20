<?php
include("../control/security.inc.php");
include("../control/control.inc.php");
include("../includes/header.php"); 
include("../includes/navbar.php"); 


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

                    $_SESSION["msg"] = '<div class="alert alert-success text-center" role="alert">meter registration SUCCESSFUL</div>';
                    }
                    
                    }

            }catch(PDOException $e){
                header("Location:../error/error.php?show=dberror");
                error_log("meter.php, SQL error=" .$e->getMessage());
                return;
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
      <div class="modal-header modal-header-danger">
        <h5 class="modal-title font-weight-bold w-100 text-center" id="modalLabel">Add Meter</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="modal-body">   
    
            <!-- meter number-->
            <div class="form-group">
                <label class="font-weight-bold">Meter Number</label>
                <input type="number" class="form-control" placeholder="Enter meter number" name="meter_number" required>
            </div>
            
            <!-- district-->
            <div class="form-group">
                <label class="font-weight-bold">District</label>
                <input type="text" class="form-control" placeholder="Enter district" name="district" required>
            </div>
            
            <!-- region-->
            <div class="form-group"> 
                <label class="font-weight-bold">Regions</label>
                <select class="form-control" name="region" required>
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
            
            <!-- gpscode-->
            <div class="form-group">
                <label class="font-weight-bold">Gpscode</label>
                <input type="text" class="form-control" placeholder="Enter gps-code" name="gpscode" required>
            </div>

            <!--status-->
            <div class="form-group">
                <label class="font-weight-bold">Status</label>
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
            <h6 class="m-0 font-weight-bold text-lg text-secondary">Meter Info
                 <!-- Button trigger modal -->
                <button type="button" class="btn btn-secondary float-right" data-toggle="modal" data-target="#meter">
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
                    $stmtt = $connection->prepare("SELECT * FROM meter");
                    $stmtt->execute();
                    $stmtt->setFetchMode(PDO::FETCH_ASSOC);
                }catch(PDOException $e){
                    header("Location:../error/error.php?show=dberror");
                    error_log("meter.php, SQL error=" .$e->getMessage());
                    return;
                }
                ?>

                <table class="table table-striped table-bordered dt-responsive" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-success text-bold text-white">
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
                    if($stmtt->rowCount() > 0){
                        while($row = $stmtt->fetch()){
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
                                
                                <form action="meter_edit.php" method="post">
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