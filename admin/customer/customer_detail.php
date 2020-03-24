<?php
// setting header to json
include("../control/security.inc.php");
include("../control/control.inc.php");
include("../includes/header.php"); 
include("../includes/navbar.php"); 
?>
 
<?php
    // fetch data from database
    try{

        if(isset($_POST["send"])){
            $id = trim(htmlspecialchars($_POST["id"]));
            $_SESSION["cid"] = $id;
        $stmt = $connection->prepare("SELECT CURDATE(), customer.customer_id, customer.fname, customer.lname,
        customer.email, customer.region, customer.district, customer.gpscode, meter.meter_number,customer.date
        FROM customer JOIN meter ON customer.meter_id=meter.meter_id WHERE customer_id='$id'");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
    ?>



<!-- Content Row -->
<div class="row">
    <div class="col-sm-10 col-md-10 col-lg-10 mx-auto">
        <div class="mb-3 mr-3">
                <a href="customer.php" class="btn btn-info"> <i class="fa fa-arrow-circle-left"></i> back to main page</a>
        </div>
            <!-- Consumer Chart -->
        <div class="">
            <div class="card shadow mb-4 mr-3 mt-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary text-left">Energy Consumption In kWh</h6>
                </div>
                <div class="card-body">
                    <div class="chart-bar">
                        <canvas id="consumerChart"></canvas>
                    </div>
                    <hr>
                    <div class="text-primary text-center"> Electricity Consumption Of All Regions In Ghana...</div>
                </div>
            </div>
        </div>


        <div class="">

            <!-- Customer Details -->
            <div class="card shadow mb-4 mr-3 mt-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Info</h6>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
        

                        <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                            <?php 
                    if($stmt->rowCount() > 0){
                        while($row = $stmt->fetch()){
                    ?>

                            <tr>
                                <th>ID</th>
                                <td><?php echo htmlspecialchars($row["customer_id"]); ?></td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td><?php echo htmlspecialchars($row["fname"] . " " . $row["lname"]);?></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><?php echo htmlspecialchars($row["email"]); ?></td>
                            </tr>
                            <tr>
                                <th>Region</th>
                                <td><?php echo htmlspecialchars($row["region"]); ?></td>
                            </tr>
                            <tr>
                                <th>District</th>
                                <td><?php echo htmlspecialchars($row["district"]); ?></td>
                            </tr>
                            <tr>
                                <th>Gpscode</th>
                                <td><?php echo htmlspecialchars($row["gpscode"]); ?></td>
                            </tr>
                            <tr>
                                <th>Meter Number</th>
                                <td><?php echo htmlspecialchars($row["meter_number"]); ?></td>
                            </tr>
                            <tr>
                                <th>Date Created</th>
                                <td><?php echo htmlspecialchars($row["date"]); ?></td>
                            </tr>
                            <?php 
                            }
                        }
                         }}catch(PDOException $e){
                        header("Location: ../error/error.php?show=dberror");
                        error_log("customer_detail.php, SQL error=" .$e->getMessage());
                        return;
                    }
                        ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- /.container-fluid -->


<?php
include("../includes/scripts.php");
include("../includes/footer.php");
?>