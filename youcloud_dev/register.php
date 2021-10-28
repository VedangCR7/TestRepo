<?php include "connection.php";

if (isset($_POST['name'])) {

	$name = $_POST['name'];
	$phone = $_POST['phone'];
	$email = $_POST['email'];
	$password = $_POST['password'];


	$sql1="SELECT * FROM `customer` WHERE email='$email' AND password ='$password'";

	$result = mysqli_query($conn, $sql1);

	/*if account already exist*/
	if (mysqli_num_rows($result) > 0) {	

		$errorMessge="Oops !!! Account Already Exist...";

	}else{


		$sql = "INSERT INTO customer (name, contact_no, email, password)
		VALUES ('$name', '$phone', '$email', '$password')";

		if (mysqli_query($conn, $sql)) {
			
			$successMessge="Registration Success";
			header("location:login.php");

		}else{

			echo "fail";
			echo mysqli_query($conn, $sql);
		}


	}


}







 ?>






<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Ansonika">
    <title>YouCloud</title>

    <!-- Favicons-->
    <link rel="shortcut icon" href="<?php echo $base_url; ?>/website_assets/webAssets/img/youcloud_faviccon.jpg" type="image/x-icon">
    <link rel="apple-touch-icon" type="image/x-icon" href="<?php echo $base_url; ?>/website_assets/webAssets/img/apple-touch-icon-57x57-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="<?php echo $base_url; ?>/website_assets/webAssets/img/apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="<?php echo $base_url; ?>/website_assets/webAssets/img/apple-touch-icon-114x114-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="<?php echo $base_url; ?>/website_assets/webAssets/img/apple-touch-icon-144x144-precomposed.png">

    <!-- GOOGLE WEB FONT -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- BASE CSS -->
    <link href="<?php echo $base_url; ?>/website_assets/webAssets/css/bootstrap_customized.min.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>/website_assets/webAssets/css/style.css" rel="stylesheet">

    <!-- SPECIFIC CSS -->
    <link href="<?php echo $base_url; ?>/website_assets/webAssets/css/order-sign_up.css" rel="stylesheet">

    <!-- YOUR CUSTOM CSS -->
    <link href="<?php echo $base_url; ?>/website_assets/webAssets/css/custom.css" rel="stylesheet">
    
</head>

<body id="register_bg">
	
	<div id="register">
		<aside>
			<figure>
				<a href="index.php"><img src="<?php echo $base_url; ?>/website_assets/webAssets/img/logo_sticky.png" width="140" height="35" alt=""></a>
			</figure>
			
			<div class="access_social">
					<a href="#0" class="social_bt facebook">Register with Facebook</a>
					<a href="#0" class="social_bt google">Register with Google</a>
				</div>
            <div class="divider"><span>Or</span></div>

            <span style="color:red;"><b>

			<?php

			if(isset($errorMessge)){
				echo $errorMessge;
				$errorMessge="";
			} ?></b>

			</span>

			<span style="color:green;"><b>
				<?php
				if(isset($successMessge)){
					echo $successMessge;
					$successMessge="";
				}
				?></b>
		    </span>

			<form autocomplete="" action="<?php echo $_SERVER['PHP_SELF'] ?>" id="register_form" method='post'>
				<div class="form-group">
					<input class="form-control" type="text" name="name" placeholder="Name" id="name">
					<i class="icon_pencil-edit"></i>
					<p style="color:red;" id ="name_error"></p>
				</div>
				<div class="form-group">
					<input class="form-control" name="phone" id="phone" type="text" placeholder="Mobile Number">
					<i class="icon_pencil-edit"></i>
					<p style="color:red;" id ="phone_error"></p>
				</div>
				<div class="form-group">
					<input class="form-control" type="email" id="email" name="email" placeholder="Email">
					<i class="icon_mail_alt"></i>
					<p style="color:red;" id ="email_error"></p>
				</div>
				<div class="form-group">
					<input class="form-control" type="password" name="password" id="password1" placeholder="Password">
					<i class="icon_lock_alt"></i>
					<p style="color:red;" id ="password1_error"></p>
				</div>
				<div class="form-group">
					<input class="form-control" type="password" id="password2" placeholder="Confirm Password">
					<i class="icon_lock_alt"></i>
				</div>
				<div id="pass-info" class="clearfix"></div>
				<!--<a href="#0" class="btn_1 gradient full-width">Submit</a>-->
                <button class="btn_1 gradient full-width" id="register_btn">Register Now!</button>
				<div class="text-center mt-2"><small>Already have an acccount? <strong><a href="login.php">Sign In</a></strong></small></div>
			</form>
			<!-- <div class="copy">© 2021  YouCloud</div> -->
		</aside>
	</div>
	<!-- /login -->
	
	<!-- COMMON SCRIPTS -->
    <script src="<?php echo $base_url; ?>/website_assets/webAssets/js/common_scripts.min.js"></script>
    <script src="<?php echo $base_url; ?>/website_assets/webAssets/js/common_func.js"></script>
    <script src="assets/validate.js"></script>
	
	<!-- SPECIFIC SCRIPTS -->
	<script src="<?php echo $base_url; ?>/website_assets/webAssets/js/pw_strenght.js"></script>	
  
</body>
</html>




<script type="text/javascript">

   	function isEmail(emailid) {
		var pattern = new RegExp(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);
		return pattern.test(emailid);
	}
   


 $('#name').focusout(function() {
    var nameValue = $(this).val();
    if (nameValue == '') {
        $(' #name').addClass('has-error');
        $(' #name_error').show().text("Enter Name*");
       
    }  else if (nameValue != '') {
        $(' #name').removeClass('has-error');
        $(' #name_error').hide().text('');
       
    }
});


 $('#phone').focusout(function() {
    var phoneValue = $(this).val();
    if (phoneValue == '') {
        $(' #phone').addClass('has-error');
        $(' #phone_error').show().text("Enter phone*");
       
    }  else if (phoneValue != '') {
        $(' #phone').removeClass('has-error');
        $(' #phone_error').hide().text('');
       
    }
});


 $('#password1').focusout(function() {
    var passwordValue = $(this).val();
    if (passwordValue == '') {
        $(' #password1').addClass('has-error');
        $(' #password1_error').show().text("Enter password*");
       
    }  else if (passwordValue != '') {
        $(' #password1').removeClass('has-error');
        $(' #password1_error').hide().text('');
       
    }
});


$('#email').focusout(function() {
var mailValue = $(this).val();            
if ((mailValue == '') || (!isEmail($('#email').val()))) {
    $('#email').addClass('has-error');
    $('#email_error').show().text("Invalid Email Address*");
    } 
    else if ((mailValue != '') && (isEmail($('#email').val()))) {
    $('#email').removeClass('has-error');
    $('#email_error').hide().text('');
   

}
});


  $("#register_btn").click(function(e){
  	e.preventDefault();
  	var name=$("#name").val();
  	var phone=$("#phone").val();
  	var email=$("#email").val();
  	var password=$("#password1").val();

	$("#name").trigger('focusout');
	$("#phone").trigger('focusout');
	$("#email").trigger('focusout');
	$("#password1").trigger('focusout');

		if((name != '') && (isEmail(email))  && (password!='')  && (phone!='')){
            console.log("register_btn")
            $("#register_form").submit();
          }else{
          	console.log(name);console.log(phone);console.log(email);console.log(password);
          	console.log("Something went wrong")
        }
  })
	
</script>