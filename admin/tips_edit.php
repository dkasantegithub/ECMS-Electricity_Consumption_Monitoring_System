<?php
include("security.inc.php");
include("control.inc.php");
include("includes/header.php"); 
// include("includes/navbar.php");       
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
            $stmt = $connection->prepare("SELECT * FROM conservationtips WHERE id=:id");
            $stmt->execute(array(":id"=>$id));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        }


        //update meter info
        if(isset($_POST["update_btn"])){
                $id = $_POST["edit_id"];
                $title = validate_data($_POST["title"]);
                $tips = validate_data($_POST["tip"]);


                $user = $_SESSION["username"];
                //fetch id from login table
                $query = $connection->prepare("SELECT * FROM adminlogin WHERE user_email='$user' LIMIT 1");
                $query->execute();
                $fetch = $query->fetch(PDO::FETCH_ASSOC);

                //fetch last id from admin login table
                if($query->rowCount() >  0){
                $login_id = $fetch["login_id"];

                $state = $connection->prepare("UPDATE conservationtips SET title='$title', 
                tips='$tips', login_id='$login_id' WHERE id='$id'");
                $success = $state->execute();

                }

                if($success){
                    $_SESSION["msg"] = "<script>alert('Update successfull.');</script>";
                    header("location: tips.php");
                }else{
                    $_SESSION["msg"] = "<script>alert('Update NOT successfull.');</script>";
                    header("location: tips.php");
                }
            }
        
        
        //delete meter info from DB
        if(isset($_POST["delete_btn"])){
            $id = trim(htmlspecialchars($_POST["delete_id"]));

            $stmt = $connection->prepare("DELETE FROM conservationtips WHERE id='$id'");
                $success = $stmt->execute();                                                              
                
                if($success){
                $_SESSION["msg"] = "<script>alert('Data is successfully DELETED.');</script>";
                header("location: tips.php");
            }else{
                $_SESSION["msg"] = "<script>alert('Data NOT DELETED.');</script>";
                header("location: tips.php");
            }
        }
        
    ?>


    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">  
        <input type="hidden" name="edit_id" value="<?php echo htmlspecialchars($row["id"]); ?>">

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
        cols="15" rows="4" value="<?php echo htmlspecialchars($row["tips"] ?? ""); ?>"  required><?php echo htmlspecialchars($row["tips"] ?? ""); ?></textarea>
        </div>

        <!-- Button -->
        <div class="modal-footer">
        <a href="tips.php" class="btn btn-danger">Cancel</a>
        <button type="submit" name="update_btn" class="btn btn-primary">Update</button>
        </div>
      </form>

<?php
include("includes/scripts.php");
include("includes/footer.php");
?>