<!doctype html>
<html lang="en" dir="ltr">
  <head>
		<!-- Meta data -->
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta content="Powerful FoodNAI platform provide users nutrition and allergen information of their favorite food. Restaurants, Schools, Nutritionist will be able to provide a detailed analysis of each ingredient on the menu making and experience everyone can enjoy food safely." name="description">
		<meta name="keywords" content="nutrition analysis platform, allergen analysis platform, restaurant food nutrition analysis, school meal nutrition analysis, food nutrition analysis, nutrition food, recipe nutrition calculator, daily nutrition calculator, analyzed my food, nutrition tools, food analysis report."/>
		<!-- Favicon -->
		<link rel="shortcut icon" type="image/x-icon" href="<?=base_url();?>assets/images/brand/FoodNAI_favicon.png" />
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
		<div class="page">
			<div class="container">
				<div class="row">
					<div class="col  mx-auto">
						<div class="row justify-content-center">
							<div class="col-md-5">
								<div class="card-group mb-0">
									<div class="card">
										<form method="post" action="javascript:;" id="login-form">
											<div class="card-body text-center">
												<div class="text-center mb-6">
													<img src="<?=base_url();?>assets/images/brand/FoodNAILoginLogo.png" class="" alt=""  width="30%;">
												</div>
												<!-- <p>Please Enter the Email address and password login on your account</p> -->
												<div class="form-group">
													<label class="form-label text-left" for="email">Email Address</label>
													<input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="bluestarresto@gmail.com" readonly="">
												</div>
												<div class="form-group">
													<label for="password" class="text-left form-label">Password</label>
													<input type="password" class="form-control password-input" id="password" name="password" placeholder="Password" value="12345678" readonly="">
													<span toggle="#password" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>
												</div>
												<!--<div class="checkbox text-center mb-2">
													<div class="custom-checkbox custom-control">
														<input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" name="chec" id="checkbox-2">
														<label for="checkbox-2" class="custom-control-label">Check me Out</label>
													</div>
												</div> -->
												<div class="text-center">
													<button type="submit" class="btn btn-primary">Sign in</button>
												</div>
												<!-- <div class="text-center text-muted mt-3 mb-3 p-10">
													<span style="float: left;">
														<a href="<?=base_url();?>forgot">Forgot password?</a>
													</span>
													<span style="float: right;">
														Don't have account yet? <a href="<?=base_url();?>register">Sign up</a>
													</span>
												</div> -->
											</div>
										</form>
									</div>
									<!-- <div class="card  py-5 d-md-down-none">
										<div class="card-body align-items-center">
											<div>
												<h2 class="text-center">Login to your Account</h2>
												<p class="text-muted text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam eu sem tempor, varius quam at, consectetur adipiscing elit consectetur adipiscing elit luctus dui. Mauris magna metus.</p>
												<div class="social-icons text-white">
													<ul class="mb-0">
														<li><a class="btn  btn-social btn-block facebook-bg"><i class="fab fa-facebook"></i> Sign up with Facebook</a></li>
														<li class="mt-3"><a class="btn  btn-social btn-block google-bg"><i class="fab fa-google"></i> Sign up with Google</a></li>
														<li class="mt-3"><a class="btn  btn-social btn-block twitter-bg"><i class="fab fa-twitter"></i> Sign up with Twitter</a></li>
														<li class="mt-3"><a class="btn  btn-social btn-block dribbble-bg"><i class="fab fa-dribbble"></i> Sign up with Dribble</a></li>
													</ul>
												</div>
											</div>
										</div>
									</div> -->
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
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
		<!-- Custom js -->
		<script src="<?=base_url();?>assets/js/custom.js"></script>
		<script type="text/javascript">
		    $(document).ready(function() {
		    	
		        Login.base_url="<?=base_url();?>";
		        Login.init();
		        var status="<?php if(isset($_GET['status'])) echo $_GET['status']; else echo '';?>";
		        if(status=="inactive"){
		        	swal("Error !","Your account is inactive now, for support please contact to FoodNAI","error");
		        }
		        $("#login-form").validate({
				    rules: {
				        email: {
					        required: true,
					        email: true
					    },
				      	password: {
					        required: true
				      	}
				    },
				    messages: {
						email: "Please enter a valid email address",
						password: {
							required: "Please provide a password",
							minlength: "Passwords must be at least 8 and maximum 30 characters in length",
							maxlength:"Passwords must be at least 8 and maximum 30 characters in length"
						}
				    },
				    submitHandler: function(form) {
				      form.submit();
				    }
				});
		    });
		</script>
		<script type="text/javascript" src="<?=base_url();?>assets/js/custom/Login.js"></script>
		<script type="text/javascript">
			  /*var user_id="<?php if(isset($_SESSION['user_id'])) echo $_SESSION['user_id']; else echo "";?>";
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
			  }*/
			  
		       /* $(".toggle-password").click(function(e) {
		        	alert('here');
		            $(this).toggleClass("fa-eye fa-eye-slash");
		            var input = $($(this).attr("toggle"));
		            if (input.attr("type") == "password") {
		                input.attr("type", "text");
		            } else {
		                input.attr("type", "password");
		            }
		        });*/
			</script>
	</body>
</html>