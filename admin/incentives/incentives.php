<?php 
include("../control/security.inc.php");
include("../control/control.inc.php");
include("../includes/header.php"); 
include("../includes/navbar.php"); 
?>

<?php

    try{
        $tmt = $connection->prepare("SELECT customer_id, AVG(energy_consumed) AS avg_credit, COUNT(*) AS num
        FROM (SELECT customer_id, IF(@uid = (@uid := customer_id), @auto:=@auto + 1, @auto := 1) autoNo, energy_consumed
            FROM consumption, (SELECT @uid := 0, @auto:= 1) A 
            ORDER BY customer_id, id ASC
            ) AS A 
        WHERE autoNo <= 3
        GROUP BY customer_id");
        $tmt->execute();


        //fetch each row in the database
        while($row = $tmt->fetch()){
            $id = $_SESSION["id"];
            $c_id = $row["customer_id"];
            $avg_credit =  $row["avg_credit"];
            $e_percent = $avg_credit*(0.7);
            $avg_percent = $avg_credit*(0.02);


            //Check whether a customer has earned a bonus for each day at 11:59pm
            $stmmt = $connection->prepare("SELECT * FROM consumption WHERE customer_id=$c_id 
            AND (energy_consumed>$e_percent AND energy_consumed<$avg_credit) AND 
            (date=CURDATE() AND TIME_FORMAT(time, '%H:%i')> '23:59') LIMIT 1");
            $stmmt->execute();

            //Insert bonus into database for a customer with a bonus
            while($record = $stmmt->fetch()){
                $query = $connection->prepare("INSERT INTO reward(bonus, date, time, login_id, customer_id)
                                                VALUES('$avg_percent', '$id', '$c_id')");
                $query->execute();
            }

        }
            
    }catch(PDOException $e){
        header("Location:../error/error.php?show=dberror");
        error_log("incentives.php, SQL error=" .$e->getMessage());
        return;
    }

?>

<div class="container-fluid">
    <div class="row">

    <?php

        try{
            $sms = $connection->prepare("SELECT reward.bonus, reward.date, customer.fname, customer.lname
            FROM reward JOIN customer ON reward.customer_id=customer.customer_id ORDER BY date DESC");
            $sms->execute();
            $num = $sms->rowCount();

            if($num > 0){
            while($loop = $sms->fetch()){

        
    ?>
        <div class="col-sm-9 col-md-9 col-lg-9 mx-auto">

            <div class="card bg-light border-success mt-4 mb-2 shadow">
                <div class="card-body">
                    <div class="card-title text-center ml-5 text-primary">
                        <span class="card-text">
                            <i class="fa fa-gift fa-2x" aria-hidden="true"></i>
                        </span>
                        <small class="card-text float-right"><?php echo $loop["date"]; ?></small>
                    </div>
                    <div class="h4 card-text text-center font-weight-bold text-uppercase">bonus package</div>
                    <div class="h5 card-text">Our valued customer <span class="text-primary"><?php echo $loop["fname"]. " " .$loop["lname"]; ?></span>
                    has earned a bonus of <span class="text-primary"><?php echo $loop["bonus"]. " GHC"; ?></span>
                     <span class=" float-right pl-5 pr-5 text-info">
                    <i class="fa fa-trophy fa-1.5x" aria-hidden="true"></i></span>
                    </div>
                    
                </div>
            </div>
        </div>
        <?php
                } 
            } else {
            
            ?>
            <div class="col-sm-9 col-md-9 col-lg-9 mx-auto mt-5">

            <div class="card bg-light border-info mt-5 mb-2 shadow">
                <div class="card-body">
                    <div class="card-title text-center">
                        <span class="card-text text-primary">
                            <i class="fa fa-gift fa-2x" aria-hidden="true"></i>
                        </span>
                    </div>
                    <div class="h4 card-text font-weight-bold text-center text-uppercase">Bonus Package</div>
                    <div class="h5 card-text text-center"> No one has earned a bonus yet.
                    </div>
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