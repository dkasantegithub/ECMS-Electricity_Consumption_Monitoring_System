<?php
include("../control/security.inc.php");
include("../control/control.inc.php");
include("../includes/header.php"); 
// include("includes/navbar.php");       
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-7 mx-auto">
            
            <!-- data table -->
            <div class="card shadow mt-4">
                <div class="card-header bg-secondary py-3">
                    <h5 class="m-0 font-weight-bold text-white w-100 text-center">Edit Tip</h5>
                </div>
                <div class="card-body">
            
            <?php

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
                            $_SESSION["msg"] = '<div class="alert alert-success text-center" role="alert">Update SUCCESSFUL</div>';
                            header("location: tips.php");
                        }else{
                            $_SESSION["msg"] = '<div class="alert alert-danger text-center" role="alert">Update FAILED</div>';
                            header("location: tips.php");
                        }
                    }
                
                
                //delete tip info from DB
                if(isset($_POST["delete_btn"])){
                    $id = trim(htmlspecialchars($_POST["delete_id"]));

                    $stmt = $connection->prepare("DELETE FROM conservationtips WHERE id='$id'");
                        $success = $stmt->execute();                                                              
                        
                        if($success){
                        $_SESSION["msg"] = '<div class="alert alert-success text-center" role="alert"> data successfully deleted</div>';
                        header("location: tips.php");
                    }else{
                        $_SESSION["msg"] = '<div class="alert alert-danger text-center" role="alert"> data NOT deleted</div>';
                        header("location: tips.php");
                    }
                }


                   //edit function
                if(isset($_POST["edit_btn"])){
                    $id = $_POST["edit_id"];
                    
                    //retrieve data from table using id
                    $stmt = $connection->prepare("SELECT * FROM conservationtips WHERE id=:id");
                    $stmt->execute(array(":id"=>$id));
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
            ?>


            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">  
                <input type="hidden" name="edit_id" value="<?php echo htmlspecialchars($row["id"]); ?>">

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
                    cols="15" rows="4" value="<?php echo htmlspecialchars($row["tips"] ?? ""); ?>"  required><?php echo htmlspecialchars($row["tips"] ?? ""); ?></textarea>
                    </div>

                <!-- Button -->
                <div class="modal-footer">
                <a href="tips.php" class="btn btn-danger">Cancel</a>
                <button type="submit" name="update_btn" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>

<?php
    }
include("../includes/scripts.php");
include("../includes/footer.php");
?>