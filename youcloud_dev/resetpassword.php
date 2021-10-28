<?php include "connection.php"; ?>


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
			
			<form autocomplete="off" class="emailform">
                <p class="text-center mt-3">Reset Your Password</p>
				<div class="form-group">
					<input class="form-control" type="email" placeholder="Enter you email address">
					<i class="icon_mail_alt"></i>
                    
				</div>
                <button class="btn_1 full-width showotp greenolive">Reset</button>
			</form>
            <form autocomplete="off" style="display: none;" class="showotpform">
                <p class="text-center mt-3">Enter Otp</p>
				<div class="form-group">
					<input class="form-control" type="password" id="password" placeholder="Enter OTP number">
                    <i class="icon_phone"></i>
                </div>
                <button class="btn_1 gradient full-width resetpassbtn greenolive">Submit</button>
			</form>
            <form autocomplete="off" style="display: none;" class="resetpass">
                <p class="text-center mt-3">Set your new password</p>
				<div class="form-group">
					<input class="form-control" type="password" id="password" placeholder="Password">
                    <i class="icon_lock_alt"></i>
                </div>
                <div class="form-group">
					<input class="form-control" type="password" id="password" placeholder="Confirm Password">
                    <i class="icon_lock_alt"></i>
                </div>
                <button class="btn_1 gradient full-width greenolive">Submit</button>
			</form>
            <div class="text-center mt-2"><small>Already have an account?
                 <strong><a href="register.php">Sign in</a></strong></small></div>
			<!--<div class="copy">© 2021 YouCloud</div>-->
		</aside>
	</div>
	<!-- /login -->
	
	<!-- COMMON SCRIPTS -->
    <script src="<?php echo $base_url; ?>/website_assets/webAssets/js/common_scripts.min.js"></script>
    <script src="<?php echo $base_url; ?>/website_assets/webAssets/js/common_func.js"></script>
    <script src="<?php echo $base_url; ?>/website_assets/webAssets/assets/validate.js"></script>
  
</body>
</html>