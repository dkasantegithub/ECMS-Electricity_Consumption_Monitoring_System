<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>ecms-dashboard</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <!-- Custom styles for this template-->
  <link href="../styles/css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <div class="container-fluid mt-5">
      <div class="row">
        <div class="col-md-4 mx-auto text-center mt-5">
            <div class="h2 text-info rounded">ECMS 404 ERROR PAGE</div>
            <div class="mx-auto">
                
                <?php 
                    if(!isset($_GET["show"])){
                        exit();

                    }else{
                        $msg = $_GET["show"];

                        if($msg == "dberror"){
                             echo "<div class='text-lg text-success'>Connection to Database Failed,
                              please contact support on <a href='#' class=''>ecms-kumasi-knust-ghana</a></div>";
                            exit();
                        }
                    }
                 ?>

            </div>
          </div>
        </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="sticky-footer bg-white">
    <div class="container my-auto">
      <div class="copyright text-center my-auto">
        <span>Copyright &copy; Your Website 2019</span>
      </div>
    </div>
  </footer>
  <!-- End of Footer -->
  </div>
  <!-- End of Content Wrapper -->

  <!-- Bootstrap core JavaScript-->
  <script src="../styles/vendor/jquery/jquery.min.js"></script>
  <script src="../styles/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="../styles/vendor/jquery-easing/jquery.easing.min.js"></script>
  <!-- Custom scripts for all pages-->
  <script src="../styles/js/sb-admin-2.min.js"></script>
</body>
</html>