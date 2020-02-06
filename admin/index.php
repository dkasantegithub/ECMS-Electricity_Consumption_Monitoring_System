<?php
include("security.inc.php");
if(!empty($_SESSION["username"])  && !$_SESSION["admin"]){
        $user->redirect('register.php');
    }
include("includes/header.php"); 
include("includes/navbar.php"); 
?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
        class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
  </div>

  <!-- Content Row -->
  <div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Number of Admin</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">

                <?php
                      //display number of admins
                      $stmt = $connection->prepare("SELECT admin_id FROM adminregister ORDER BY admin_id");
                      $stmt->execute();
                      $row = $stmt->rowCount();
                      echo "<div class='h5 mb-0 font-weight-bold text-gray-800' > $row </div>";
                    ?>

              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-calendar fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Meters</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"> Yet To</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Consumption</div>
              <div class="row no-gutters align-items-center">
                <div class="col-auto">
                  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"> Yet To</div>
                </div>
                <div class="col">
                  <div class="progress progress-sm mr-2">
                    <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50"
                      aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Power</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">Yet To</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-comments fa-2x text-gray-300"></i>
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

      <!-- Bar Chart -->
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary text-center">Energy Consumption In kWh</h6>
        </div>
        <div class="card-body">
          <div class="chart-bar">
            <canvas id="myBarChart"></canvas>
          </div>
          <hr>
          <div class="text-primary text-center"> Electricity Consumption Of All Regions In Ghana...</div>
        </div>
      </div>

    </div>

    <!-- Donut Chart -->
    <div class="col-xl-4 col-lg-5">
      <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary text-center">Energy Consumption In kWh</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
          <div class="chart-pie mt-2 mb-4 pt-4 pb-4">
            <canvas id="myPieChart"></canvas>
          </div>
          <hr>
          <div class="text-primary text-center"> Electricity Consumption Of All Regions In Ghana...</div>
        </div>
      </div>
    </div>
  </div>

</div>
<!-- /.container-fluid -->

<?php
include("includes/scripts.php");
include("includes/footer.php");
?>