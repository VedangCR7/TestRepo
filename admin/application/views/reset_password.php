<!doctype html>
<html lang="en" dir="ltr">
  <head>
		<!-- Meta data -->
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta content="Spaner - Simple light Bootstrap Nice Admin Panel Dashboard Design Responsive HTML5 Template" name="description">
		<meta content="Spruko Technologies Private Limited" name="author">
		<meta name="keywords" content="bootstrap panel, bootstrap admin template, dashboard template, bootstrap dashboard, dashboard design, best dashboard, html css admin template, html admin template, admin panel template, admin dashbaord template, bootstrap dashbaord template, it dashbaord, hr dashbaord, marketing dashbaord, sales dashbaord, dashboard ui, admin portal, bootstrap 4 admin template, bootstrap 4 admin"/>

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

		<!-- Global Loader-->
		<div id="global-loader"><img src="<?=base_url();?>assets/images/svgs/loader.svg" alt="loader"></div>
		  <div id="image-loader"><img src="<?=base_url();?>assets/images/svgs/loader.svg" alt="loader"></div>
		<div class="page">
			<div class="container">
				<div class="row">
					<div class="col  mx-auto">
						<div class="row justify-content-center">
							<?php
							if($isvalid=="valid"){
							?>
							<div class="col-md-5">
								<div class="card-group mb-0">
									<div class="card">
										<form method="post" action="javascript:;" id="reset-form">
											<input type="hidden" name="id" value="<?=$id;?>">
									    	<input type="hidden" name="email" value="<?=$email;?>">
											<div class="card-body text-center">
												<div class="text-center mb-6">
													<img src="<?=base_url();?>assets/images/brand/newlogo.png" class="" alt=""  width="30%;">
												</div>
												<div class="form-group">
													<label class="form-label text-left" for="password">Password <span >(*)</span></label>
													<input type="password" class="form-control password-input" id="password" name="password" placeholder="Password" required="" minlength="8" maxlength="30" >
													<span toggle="#password" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>
												</div>
												<div class="form-group">
													<label class="form-label text-left" for="cpassword">Confirm Password <span >(*)</span></label>
													<input type="password" class="form-control password-input" id="cpassword" name="cpassword" placeholder="Confirm Password" required="" minlength="8" maxlength="30" >
													<span toggle="#cpassword" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>
												</div>
												<div class="text-center">
													<button type="submit" class="btn btn-primary">Reset</button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
							<?php
								}
								else{
							?>
							<h3>Invalid Link !</h3>
							<?php
								}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>

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
		      Login.base_url="<?=base_url();?>";
		      Login.init();
		    });
		</script>
		<script type="text/javascript" src="<?=base_url();?>assets/js/custom/Login.js?v=3"></script>
	</body>
</html>
