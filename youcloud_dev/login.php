<?php include "connection.php";

if(isset($_POST['login_user_email']) && isset($_POST['login_user_password'])){
    
	$user_email = $_POST['login_user_email'];

	$user_password = $_POST['login_user_password'];

   
   $sql="SELECT * FROM `customer` WHERE email='$user_email' AND password ='$user_password' ";

   $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {	

  	$userdata=mysqli_fetch_row($result);

  	session_start();

  	$user_id=$userdata['0'];
  	$_SESSION['user_id']=$user_id;
  	$_SESSION['userr_profile_image']=$userdata['4'];
  	$_SESSION['user_name']=$userdata['1'];

    if(!empty($_POST['restoname'])){

      $restoname = $_POST['restoname'];
        
      header("Location:restaurant_detail.php?restaurant_name=$restoname");  

    }else{
        
        header("Location:account.php");
    }


  }else{

  	$error="Invalid Login Details";

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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />


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
    
    
    <style>
        i#togglePassword {
            margin-top: -5px;
            cursor: pointer;
        }
    </style>
    
    
</head>

<body id="register_bg">
	
	<div id="register">
		<aside>
			<figure>
				<a href="index.php"><img src="<?php echo $base_url; ?>/website_assets/webAssets/img/logo_sticky.png" width="140" height="35" alt=""></a>
			</figure>
			<div class="access_social">
				<a href="loginasguest.php?restoname=<?php echo $_GET['restoname'];  ?>" class="social_bt guest">Continue as Guest</a>
			</div>
		<div class="divider"><span>Or</span></div>
			<div class="access_social">
					<a href="#0" class="social_bt facebook">Login with Facebook</a>
					<a href="#0" class="social_bt google">Login with Google</a>
				</div>
            <div class="divider"><span>Or</span></div>
            <?php
             if(isset($error)){
             	echo $error;
             	$error="";
             }

             ?>
			<form autocomplete="" action="<?php echo $_SERVER['PHP_SELF'] ?>"  id="login_form" method="POST">
			    
			    <input type="hidden" value='<?php echo $_GET["restoname"]; ?>' name="restoname">
			    
				<div class="form-group">
					<input class="form-control" type="email" placeholder="Email" id="login_user_email" name="login_user_email">
					<i class="icon_mail_alt"></i>
				</div>
				<p id ="login_user_email_error"></p>
				<div class="form-group">
					<input class="form-control" type="password" id="login_user_password" placeholder="Password" name="login_user_password">
					<!--<i class="icon_lock_alt"></i>-->
					<i class="bi bi-eye-slash" id="togglePassword"></i>
				</div>
				<p id ="login_user_password_error"></p>
				<div class="clearfix add_bottom_15">
					<div class="checkboxes float-left">
						<label class="container_check">Remember me
						  <input type="checkbox">
						  <span class="checkmark"></span>
						</label>
					</div>
					<div class="float-right"><a id="forgot" href="resetpassword.php">Forgot Password?</a></div>
				</div>
				<!--<a href="#0" class="btn_1 gradient full-width greenolive">Login Now!</a>-->
				<button id="submit_btn" type="button" class="btn_1 gradient full-width greenolive">Login Now!</button>
				<div class="text-center mt-2"><small>New to YouCloud
					 <strong><a href="register.php">Create account</a></strong></small></div>
			</form>
			<!--<div class="copy">© 2021 FooYes</div>-->
		</aside>
	</div>
	<!-- /login -->
	
	<!-- COMMON SCRIPTS -->
    <script src="<?php echo $base_url; ?>/website_assets/webAssets/js/common_scripts.min.js"></script>
    <script src="<?php echo $base_url; ?>/website_assets/webAssets/js/common_func.js"></script>
    <script src="<?php echo $base_url; ?>/website_assets/webAssets/assets/validate.js"></script>

    <script type="text/javascript">

       	function isEmail(emailid) {
			var pattern = new RegExp(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);
			return pattern.test(emailid);
		}
       
        
         $('#login_user_email').focusout(function() {
        var mailValue = $(this).val();            
        if ((mailValue == '') || (!isEmail($('#login_user_email').val()))) {
            $('#login_user_email').addClass('has-error');
            $('#login_user_email_error').show().text("Invalid Email Address");
            } 
            else if ((mailValue != '') && (isEmail($('#login_user_email').val()))) {
            $('#email').removeClass('has-error');
            $('#login_user_email_error').hide().text('');
           

        }
    });
   


     $(' #login_user_password').focusout(function() {
        var passwordValue = $(this).val();
        if (passwordValue == '') {
            $(' #login_user_password').addClass('has-error');
            $(' #login_user_password_error').show().text("Invalid Password");
           
        }  else if (passwordValue != '') {
            $(' #login_user_password').removeClass('has-error');
            $(' #login_user_password_error').hide().text('');
           
        }
    });

      $("#submit_btn").click(function(e){
      	e.preventDefault();
      	var user_email=$("#login_user_email").val();
            var user_password=$("#login_user_password").val();
           
             $("#login_user_email").trigger('focusout');
             $("#login_user_password").trigger('focusout');
    		if((user_email != '') && (isEmail(user_email))  && (user_password!='')){
                console.log("submit_btn")
                $("#login_form").submit();
              }else{
              	console.log(user_email);console.log(user_password);
              	console.log("Something went wrong")
              }
      })
      
      
const togglePassword = document.querySelector('#togglePassword');
const password = document.querySelector('#login_user_password');

togglePassword.addEventListener('click', function (e) {
// toggle the type attribute
const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
password.setAttribute('type', type);
// toggle the eye / eye slash icon
this.classList.toggle('bi-eye');
});
      
      
      
      
    	
    </script>
  
</body>
</html>