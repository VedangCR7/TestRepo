<!doctype html>
<html lang="en" dir="ltr">
  <head>
		<!-- Meta data -->
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta content="<?php echo APPMETADATA;?>" name="description">
		<meta name="keywords" content="nutrition analysis platform, allergen analysis platform, restaurant food nutrition analysis, school meal nutrition analysis, food nutrition analysis, nutrition food, recipe nutrition calculator, daily nutrition calculator, analyzed my food, nutrition tools, food analysis report."/>

		<!-- Favicon -->
		<link rel="shortcut icon" type="image/x-icon" href="<?php echo APP_LOGO ?>" />
		<!-- Title -->
		<title><?php echo APP_NAME ?> - food allergen nutrition information</title>

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
							<div class="col-md-5">
								<div class="card-group mb-0">
									<div class="card">
										<form method="post" action="javascript:;" id="forgot-form">
											<div class="card-body text-center">
												<div class="text-center mb-6">
													<!--<img src="<?=base_url();?>assets/images/brand/newlogo.png" class="" alt=""  width="30%;">-->
													<img src="<?php echo APP_LOGO ?>" class="" alt=""  width="100%;">
												</div>
												<!-- <p>Please Enter the Email address and password login on your account</p> -->
												<div class="form-group">
													<label class="form-label text-left" for="exampleInputEmail1">Email </label>
													<input type="email" class="form-control"  name="email" placeholder="Enter email" id="input-email" required="">
												</div>
												<div class="text-center">
													<a href="<?=base_url();?>login">	
														<button type="button" class="btn btn-primary">Back</button>
													</a>
													<button type="submit" class="btn btn-primary">Send</button>
													
												</div>
												
											</div>
										</form>
									</div>
								
								</div>
							</div>
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
		<script async src="https://www.googletagmanager.com/gtag/js?id=G-8ZJNB18KS2"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());
		  gtag('config', 'G-8ZJNB18KS2');
		</script>
		<script type="text/javascript" src="<?=base_url();?>assets/js/custom/Login.js"></script>
		<!-- <script type="text/javascript">
			  var user_id="<?php if(isset($_SESSION['user_id'])) echo $_SESSION['user_id']; else echo "";?>";
			  if(user_id!=""){
			    swal({
			            title:"Warning !", 
			            text:"You are already logged in. Do you wana log out ?", 
			            type:"warning",
			            showCancelButton: true,
			            confirmButtonText: 'Yes',
			            cancelButtonText: 'No',
			            confirmButtonClass: 'btn btn-primary',
			            cancelButtonClass: 'btn btn-danger',
			            buttonsStyling: false
			        }).then(function(){
			            window.location.href=Login.base_url+"users/logout";
			        })
			  }
			</script> -->
	</body>
</html>
