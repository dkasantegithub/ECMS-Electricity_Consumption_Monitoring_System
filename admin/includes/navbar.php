<?php 
  ob_start();
?>
<ul class="navbar-nav bg-gradient-secondary sidebar sidebar-dark accordion" id="accordionSidebar">
      <!-- Sidebar - Brand -->
      <div class="sidebar-brand d-flex align-items-center justify-content-center">
        <div class="sidebar-brand-icon">
          <i class="far fa-fw fa-lightbulb"></i>
        </div>
        <div class="sidebar-brand-text mt-2"><sup></sup></div>
      </div>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <div id="myitem">
        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
          <a class="nav-link" href="../dashboard/index.php">
            <i class="fas fa-fw fa-home"></i>
            <span>Dashboard</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
          View panels
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
          <a class="nav-link" href="../customer/customer.php">
            <i class="fas fa-fw fa-user"></i>
            <span>Consumers</span>
          </a>
        </li>

        <!-- Nav Item - meter -->
        <li class="nav-item">
          <a class="nav-link" href="../meter/meter.php">
            <i class="fas fa-fw fa-atom"></i>
            <span>Meters</span>
          </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
          Others
        </div>

        <!-- Nav Item - Conservation tips -->
        <li class="nav-item">
          <a class="nav-link" href="../tips/tips.php">
            <i class="fas fa-fw fa-lightbulb"></i>
            <span>Conservation tips</span></a>
        </li>

        <!-- Nav Item - Notifications -->
        <li class="nav-item">
          <a class="nav-link" href="../notification/npage.php">
            <i class="fas fa-bell fa-fw"></i>
            <span>Notifications</span></a>
        </li>

        <!-- Nav Item - Incentives -->
        <li class="nav-item">
          <a class="nav-link" href="#">
            <i class="fas fa-fw fa-gift"></i>
            <span>Incentives</span></a>
        </li>

        <!-- Nav Item - Settings -->
        <li class="nav-item">
          <a class="nav-link" href="#">
            <i class="fas fa-fw fa-cog"></i>
            <span>Settings</span></a>
        </li>

        <!-- Nav Item - Logout -->
        <li class="nav-item">
            <a class="nav-link" href="../control/control.inc.php" data-toggle="modal" data-target="#logoutModal">
                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                <span>Logout</span>
            </a>
        </li>
      </div>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->


  <!-- Content Wrapper -->
  <div id="content-wrapper" class="d-flex flex-column">

  <!-- Main Content -->
  <div id="content">

    <!-- Topbar -->
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

      <!-- Sidebar Toggle (Topbar) -->
      <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
      </button>

      <!-- Topbar Search -->
      <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
        <div class="input-group">
          <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
            aria-label="Search" aria-describedby="basic-addon2">
          <div class="input-group-append">
            <button class="btn btn-secondary" type="button">
              <i class="fas fa-search fa-sm"></i>
            </button>
          </div>
        </div>
      </form>

      <!-- Topbar Navbar -->
      <ul class="navbar-nav ml-auto">

        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
        <li class="nav-item dropdown no-arrow d-sm-none">
          <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-search fa-fw"></i>
          </a>
          <!-- Dropdown - Messages -->
          <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
            <form class="form-inline mr-auto w-100 navbar-search">
              <div class="input-group">
                <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                  aria-label="Search" aria-describedby="basic-addon2">
                <div class="input-group-append">
                  <button class="btn btn-secondary" type="button">
                    <i class="fas fa-search fa-sm"></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </li>

        <?php
         
          try{
                $sstmt = $connection->prepare("SELECT * FROM notifications WHERE status=0");
                $sstmt->execute();
                $num = $sstmt->rowCount();

                $count = 0;
        ?>

        <!-- Nav Item - Notification tab -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" onclick="nfunction()"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw" ></i>

                <?php  if($num > 0) { ?>
                <!-- Counter - Alerts -->
                <span class="badge badge-danger badge-counter" id="notification-count">
                  <?php  echo $num . "+"; ?>
                </span>

                <?php } ?>
            </a>

             
            <!-- Dropdown - Alerts -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                    ecms Alert Center
                </h6>

                <?php while(($list = $sstmt->fetch()) &&  ($count < 5)){
                  $count++;

                   ?>
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="mr-3">
                        <div class="icon-circle bg-primary">
                            <i class="fas fa-file-alt text-white"></i>
                        </div>
                    </div>

                    <div>
                        <div class="small text-gray-500"><?php echo $list["date"]; ?></div>
                        <span class="font-weight-bold"><?php echo $list["subject"]; ?></span>
                    </div>
                </a>                  
                <?php    }
                  }catch(PDOException $e){
                        header("Location:../error/error.php?show=dberror");
                          error_log("meter.php, SQL error=" .$e->getMessage());
                          return;
                    } if($num > 0){
                  ?>
                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                    
                    <?php }else{ ?>
                  <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="mr-3">
                        <div class="icon-circle bg-warning">
                            <i class="fas fa-exclamation-triangle text-white"></i>
                        </div>
                    </div>

                    <div>
                        <span class="font-weight-bold">No new notification</span>
                    </div>
                </a>                                 
                    <?php }?>
            </div>

        </li>
            

        
        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <span class="mr-2 d-none d-lg-inline text-gray-600 small">
              
              <?php echo $_SESSION["username"]; ?> 
            
            </span>
            <img class="img-profile rounded-circle" src="https://source.unsplash.com/QAB-WJcbgJk/60x60">
          </a>
          <!-- Dropdown - User Information -->
          <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="#">
              <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
              Profile
            </a>
            <a class="dropdown-item" href="#">
              <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
              Settings
            </a>
            <a class="dropdown-item" href="#">
              <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
              Activity Log
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
              <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
              Logout
            </a>
          </div>
        </li>
      </ul>

    </nav>
    <!-- End of Topbar -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header modal-header-info">
          <h5 class="modal-title font-weight-bold w-100 text-center" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body w-100 text-center">Thank you for using our services</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          
          <form action="../control/control.inc.php" method="post">
            <button type="submit" name="logout_btn" class="btn btn-primary">Logout</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <?php