<?php 
include("../control/security.inc.php");
include("../control/control.inc.php");
include("../includes/header.php"); 
include("../includes/navbar.php"); 
?>

<div class="container-fluid">
    <div class="row">

    <?php
        try{
            $sstmt = $connection->prepare("SELECT * FROM notifications WHERE status=0 ORDER BY date DESC LIMIT 5");
            $sstmt->execute();
            $num = $sstmt->rowCount();

            if($num > 0){
            while($list = $sstmt->fetch()){

    ?>
        <div class="col-sm-9 col-md-9 col-lg-9 mx-auto">
            
            <div class="card bg-light border-success mt-4 mb-2 shadow">
                <div class="card-body">
                    <div class="card-title">
                        <span class="card-text">
                            <i class="fa fa-paper-plane fa-2x" aria-hidden="true"></i>
                        </span>
                        <small class="card-text float-right"><?php echo $list["date"]; ?></small>
                    </div>
                    <div class="card-text h5 font-weight-bold">meter notification</div>
                    <div class="card-text"><?php echo $list["comment"]; ?></div>
                    <a href="../notification/npage.php" class="btn btn-success float-right pl-5 pr-5"
                     role="button" onclick="nfunction()">fix problem</a>
                </div>
            </div>
        </div>
        <?php
                } 
            } else {
            
            ?>

            <div class="col-sm-9 col-md-9 col-lg-9 mx-auto">
            
            <div class="card bg-light border-success mt-4 mb-2 shadow">
                <div class="card-body">
                    <div class="card-title">
                        <span class="card-text">
                            <i class="fa fa-paper-plane fa-2x" aria-hidden="true"></i>
                        </span>
                    </div>
                    <div class="card-text h4 font-weight-bold text-center text-uppercase">meter notification</div>
                    <div class="card-text h5 text-center">No New Notification</div>
                </div>
            </div>
        </div>

         <?php
                }
            }catch(PDOException $e){
            header("Location:../error/error.php?show=dberror");
            error_log("incentives.php, SQL error=" .$e->getMessage());
            return;
            }
        ?>

    </div>
</div>

<?php
include("../includes/scripts.php");
include("../includes/footer.php");
?>