<?php
include("security.inc.php");
include("control.inc.php");
include("includes/header.php"); 
include("includes/navbar.php"); 

        // Tips
        if(isset($_POST["tips"])){
            $title = validate_data($_POST["title"]);
            $tip = validate_data($_POST["tip"]);
            // $customer_id = validate_data($_POST["tip"]);
            // $login_id = validate_data($_POST["tip"]);

            if(character_len($tip, 10)){
                $_SESSION["error"] = "tip is too short";
            }else{
                try{
                    //insert data into db
                    $stmt = $connection->prepare("INSERT INTO conservationtips(title,tips,customer_id,login_id)
                    VALUES('$title', '$tips', '$customer_id', '$login_id')");
                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $_SESSION["msg"] = "<script>alert('Insertion of tips was successfull.');</script>";

                }catch(PDOException $e){
                    $_SESSION["error"] = "Error: " .$e->getMessage();
                }
            }

        }
        
?>

<!--Admin Modal -->
<div class="modal fade" id="tips" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Add Tip</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="modal-body">        
            <!-- title-->
           <div class="form-group">
                    <label>Title</label>
                    <select name="title" class="form-control">
                        <option value="general">General tips</option>
                        <option value="room gadgets">Room gadget tips</option>
                        <option value="kitchen gadgets">kitchen gadget tips</option>
                        <option value="cooling gadgets">cooling gadget tips</option>
                    </select>
                </div>

            <!-- tip-->
            <div class="form-group">
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
            <h6 class="m-0 font-weight-bold text-lg text-primary">Conservation Tips
                 <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#tips">
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
                     $_SESSION["error"] = "Fetching Error: " . $e->getMessage();
                }
                ?>

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
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
                                    <button type="submit" name="edit_btn" class="btn btn-success">EDIT</button>
                                </form>
                            </td>
                            <td> 
                                <form action="tips_edit.php" method="post">
                                    <input type="hidden" name="delete_id" value="<?php  echo htmlspecialchars($row["id"]); ?>">
                                    <button type="submit" name="delete_btn" class="btn btn-danger">DELETE</button>
                                </form>
                            </td>
                        </tr>
                        <?php
                         }
                    }else{
                        $_SESSION["error"] = "No data found in Database";
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
include("includes/scripts.php");
include("includes/footer.php");
?>