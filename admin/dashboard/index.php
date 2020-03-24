<?php
include("../control/security.inc.php");
if(!empty($_SESSION["username"])  && !$_SESSION["admin"]){
        $user->redirect('../admin-register/register.php');
      }
include("../includes/header.php"); 
include("../includes/navbar.php"); 
?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Content Row -->
  <div class="row">

    <!-- Administrators -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Administrators</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">

                <?php
                    try{
                      //display number of admins
                      $stmt = $connection->prepare("SELECT admin_id FROM adminregister ORDER BY admin_id");
                      $stmt->execute();
                      $row = $stmt->rowCount();
                      echo "<div class='h5 mb-0 font-weight-bold text-gray-800' > $row </div>";
                     }catch(PDOException $e){
                        header("Location:../error/error.php?show=dberror");
                        error_log("index.php, SQL error=" .$e->getMessage());
                        return;
                    }
                    ?>

              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-user-circle fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Customers -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Customers</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">

              <?php
                  try{
                      //display total number of customers
                      $stmt = $connection->prepare("SELECT customer_id FROM customer ORDER BY customer_id");
                      $stmt->execute();
                      $row = $stmt->rowCount();
                      echo "<div class='h5 mb-0 font-weight-bold text-gray-800' > $row </div>";
                    }catch(PDOException $e){
                      header("Location:../error/error.php?show=dberror");
                      error_log("index.php, SQL error=" .$e->getMessage());
                      return;
                    }
                    ?>

              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-users fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Total Meters -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Meters</div>
              <div class="row no-gutters align-items-center">
                <div class="col-auto">
                  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                  
                   <?php
                  try{
                      //display total number of meter
                      $stmt = $connection->prepare("SELECT meter_id FROM meter ORDER BY meter_id");
                      $stmt->execute();
                      $row = $stmt->rowCount();
                      echo "<div class='h5 mb-0 font-weight-bold text-gray-800' > $row </div>";
                    }catch(PDOException $e){
                      header("Location:../error/error.php?show=dberror");
                      error_log("index.php, SQL error=" .$e->getMessage());
                      return;
                    }
                    ?>

                  </div>
                </div>
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-tachometer-alt fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Total Consumption -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Consumption</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">
              
               <?php
                  try{
                      //display total consumption
                      $stmt = $connection->prepare("SELECT SUM(energy_consumed) AS total FROM consumption");
                      $stmt->execute();
                      $row = $stmt->fetch();
                      $total = $row["total"];
                      echo "<div class='h5 mb-0 font-weight-bold text-gray-800' > $total
                       <small class='text-success font-weight-bold'> kWh </small></div>";
                    }catch(PDOException $e){
                      header("Location:../error/error.php?show=dberror");
                      error_log("index.php, SQL error=" .$e->getMessage());
                      return;
                    }
                    ?>

              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-lightbulb fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Content Row -->


  <!-- Content Row -->
  <div class="row">

    <div class="col-xl-8 col-lg-7">

      <!--Total Consumption Given Specific Date Bar Chart -->
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary text-center">Total Energy Consumption In kWh</h6>
        </div>
        <div class="card-body">
          <div class="chart-bar">
            <canvas id="totalConsumptionChart"></canvas>
          </div>
          <hr>
          <div class="text-primary text-center"> Energy Consumption Given Specific Dates In Ghana...</div>
        </div>
      </div>

    </div>

    <!-- Regional Consumption Chart -->
    <div class="col-xl-4 col-lg-5">
      <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary text-center">Energy Consumption In kWh</h6>
        </div>
        
        <!-- Card Body -->
        <div class="card-body">
          <div class="chart-pie mt-2 mb-4 pt-4 pb-4">
            <canvas id="regionalChart"></canvas>
          </div>
          <hr>
          <div class="text-primary text-center"> Energy Consumption Of All Regions In Ghana...</div>
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