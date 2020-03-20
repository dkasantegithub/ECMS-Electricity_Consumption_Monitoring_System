<?php
include("../control/security.inc.php");
include("../control/control.inc.php");
include("../includes/header.php"); 
include("../includes/navbar.php"); 

        // Tips
        if(isset($_POST["tips"]) && empty($_SESSION["tip"])){
            $title = validate_data($_POST["title"]);
            $tips = validate_data($_POST["tip"]);

            if(character_len($tips, 10)){
                $_SESSION["error"] = "tip is too short";
            }else{
                try{

                    $user = $_SESSION["username"];
                    //fetch id from login table
                    $query = $connection->prepare("SELECT * FROM adminlogin WHERE user_email='$user' LIMIT 1");
                    $query->execute();
                    $fetch = $query->fetch(PDO::FETCH_ASSOC); 

                if($query->rowCount() >  0 ){
                    $login_id = $fetch["login_id"];

                    //insert data into db
                    $stmt = $connection->prepare("INSERT INTO conservationtips(title, tips, login_id)
                    VALUES('$title', '$tips', '$login_id')");
                    $stmt->execute();

                    $_SESSION["msg"] = '<div class="alert alert-success text-center" role="alert">Insertion of Tips SUCCESSFUL</div>';
                }
                }catch(PDOException $e){
                    header("Location:../error/error.php?show=dberror");
                    error_log("tips.php, SQL error=" .$e->getMessage());
                    return;
                }
            }
            $_SESSION["tip"] = 'true';
        }else{
            $_SESSION["tip"] = NULL;
        }
        
?>

<!--Admin Modal -->
<div class="modal fade" id="tips" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header modal-header-danger">
        <h5 class="modal-title font-weight-bold w-100 text-center" id="modalLabel">Add Tip</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="modal-body">        
            <!-- title-->
           <div class="form-group">
                    <label class="font-weight-bold">Title</label>
                    <select name="title" class="form-control">
                        <option value="general">General tips</option>
                        <option value="room gadgets">Room gadget tips</option>
                        <option value="kitchen gadgets">kitchen gadget tips</option>
                        <option value="cooling gadgets">cooling gadget tips</option>
                    </select>
                </div>

            <!-- tip-->
            <div class="form-group">
                <label class="font-weight-bold">Tip</label>
                <textarea name="tip" class="form-control" placeholder="enter tip" 
                cols="15" rows="4" required></textarea>
            </div>

            <!-- Button -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name="tips" class="btn btn-primary">add tip</button>
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
            <h6 class="m-0 font-weight-bold text-lg text-secondary">Conservation Tips
                 <!-- Button trigger modal -->
                <button type="button" class="btn btn-secondary float-right" data-toggle="modal" data-target="#tips">
                Add Tips
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
                    $stmt = $connection->prepare("SELECT * FROM conservationtips");
                    $stmt->execute();
                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                }catch(PDOException $e){
                    header("Location:../error/error.php?show=dberror");
                    error_log("tips.php, SQL error=" .$e->getMessage());
                    return;
                }
                ?>

                <table class="table table-striped table-bordered dt-responsive" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-success text-bold text-white">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Tips</th>
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
                            <td><?php echo htmlspecialchars($row["id"]); ?></td>
                             <td><?php echo htmlspecialchars($row["title"]); ?></td>
                            <td><?php echo htmlspecialchars($row["tips"]); ?></td>
                            <td><?php echo htmlspecialchars($row["date"] . " : " . $row["time"]); ?></td>
                            <td> 
                                <form action="tips_edit.php" method="post">
                                    <input type="hidden" name="edit_id" value="<?php echo htmlspecialchars($row["id"]); ?>">
                                    <button type="submit" name="edit_btn" class="btn btn-info">EDIT</button>
                                </form>
                            </td>
                            <td> 
                                <button class="btn btn-warning deletebtn">DELETE</button>
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
                                
                                 <form action="tips_edit.php" method="post">
                                    <input type="hidden" name="delete_id" id="delete_id" >
                                    <button type="submit" name="delete_btn" class="btn btn-warning">Yes, delete</button>
                                </form>
                                </div>
                            </div>
                            </div>
                        </div>

                        <?php
                         }
                    }else{
                        echo '<div class="alert alert-success text-center" role="alert">No data in Database</div>';
                        // unset($_SESSION["error"]);
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