<!doctype html>
<html lang="en" dir="ltr">
  <head>
		<!-- Meta data -->
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<!-- Favicon -->
		<link rel="shortcut icon" type="image/x-icon" href="<?=base_url();?>assets/images/brand/favicon.ico" />

		<!-- Title -->
		<title>FoodNAI - food allergen nutrition information</title>

		<!--Bootstrap.min css-->
		<link rel="stylesheet" href="<?=base_url();?>assets/plugins/bootstrap/css/bootstrap.min.css">

		<!-- Custom scroll bar css-->
		<link href="<?=base_url();?>assets/plugins/jquery.mCustomScrollbar/jquery.mCustomScrollbar.css" rel="stylesheet" />
		<link href="<?=base_url();?>assets/css/color-styles.css" rel="stylesheet" />

		<!-- Dashboard css -->
		<link href="<?=base_url();?>assets/css/style.css" rel="stylesheet" />

		<!--Font Awesome css-->
		<link href="<?=base_url();?>assets/plugins/fontawesome-free/css/all.css" rel="stylesheet">

		<!---Font icons css-->
		<link href="<?=base_url();?>assets/plugins/iconfonts/plugin.css" rel="stylesheet" />
		<link href="<?=base_url();?>assets/plugins/sweet-alert/sweetalert.css" rel="stylesheet" />
	</head>
	<body>
		<!-- Dashboard js -->
		<script src="<?=base_url();?>assets/js/vendors/jquery-3.2.1.min.js"></script>
		<script src="<?=base_url();?>assets/js/vendors/jquery.sparkline.min.js"></script>
		<script src="<?=base_url();?>assets/js/vendors/selectize.min.js"></script>
		<script src="<?=base_url();?>assets/js/vendors/jquery.tablesorter.min.js"></script>
		<script src="<?=base_url();?>assets/js/vendors/circle-progress.min.js"></script>
		<script src="<?=base_url();?>assets/plugins/jquery.rating/jquery.rating-stars.js"></script>

		<!--Bootstrap.min js-->
		<script src="<?=base_url();?>assets/plugins/bootstrap/popper.min.js"></script>
		<script src="<?=base_url();?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>

		<!-- Custom scroll bar js-->
		<script src="<?=base_url();?>assets/plugins/jquery.mCustomScrollbar/jquery.mCustomScrollbar.concat.min.js"></script>

		<!--Peitychart js-->
		<script src="<?=base_url();?>assets/plugins/peitychart/jquery.peity.min.js"></script>

		<!--Counters js-->
		<script src="<?=base_url();?>assets/plugins/counters/counterup.min.js"></script>
		<script src="<?=base_url();?>assets/plugins/counters/waypoints.min.js"></script>
		<script src="<?=base_url();?>assets/plugins/sweet-alert/sweetalert.min.js"></script>
		<script src="<?=base_url();?>assets/js/sweet-alert.js"></script>

		<!-- Custom js -->
		<script src="<?=base_url();?>assets/js/custom.js"></script>
		<script type="text/javascript">
		    $(document).ready(function() {
		    	var verify="<?=$verify;?>";
		    	if(verify=="email"){
		      		swal("Success !","Your email id verified successfully","success");
		      		window.location.href="<?=base_url();?>login";
		    	}
		    	else if(verify=="invalidlink"){
		    		swal("Error !","Invalid Link","error");
		    	}
		    });
		</script>
	</body>
</html>
