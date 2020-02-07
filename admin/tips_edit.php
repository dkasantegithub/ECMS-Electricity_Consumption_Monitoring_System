<?php
include("security.inc.php");
include("control.inc.php");
include("includes/header.php"); 
// include("includes/navbar.php"); 

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

<div class="container-fluid">
    <!-- data table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Tip</h6>
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
        
    ?>


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
                cols="15" rows="4"  required></textarea>
            </div>

            <!-- Button -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name="tips" class="btn btn-primary">add tip</button>
            </div>
        </div>
      </form>






<?php
include("includes/scripts.php");
include("includes/footer.php");
?>