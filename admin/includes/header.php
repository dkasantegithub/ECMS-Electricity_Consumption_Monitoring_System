<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>ecms-admin-application-knust-kumasi-ghana</title>

  <!-- Custom fonts for this template-->
  <link href="../styles/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="../styles/css/sb-admin-2.min.css" rel="stylesheet">
  <!-- Custom styles for this page -->
  <link href="../styles/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <!-- css styles -->
  <link rel="stylesheet" href="../styles/static/style.css">

  <script type="text/javascript">

	function nfunction() {
		$.ajax({
			url: "../notification/notification.php",
			type: "POST",
			processData:false,
			success: function(data){
				$("#notification-count").remove();					
				// $("#notification-latest").show();$("#notification-latest").html(data);
			},
			error: function(){}           
		});
	 }
	 
	//  $(document).ready(function() {
	// 	$('body').click(function(e){
	// 		if ( e.target.id != 'notification-icon'){
	// 			$("#notification-latest").hide();
	// 		}
	// 	});
	// });
		 
	</script>
  </head>
  <body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">