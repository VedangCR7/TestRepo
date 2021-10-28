<?php
	error_reporting(0);
	include "connection.php";
	$restaurant_id = $_REQUEST['restaurant_id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Foodnai | Find restaurants</title>
    <!-- Bootstrap -->
	<link rel="canonical" href="https://www.foodnai.com/">
	<meta property="og:title" content="Digital Menu | Zero Touch Menu Card | Restaurant Digital Menu Generator">
	<meta property="og:type" content="website">
	<meta property="og:description" content="Zero Touch Menu
	Zero Touch Menu Card– Digital QR Menu Card
	Zero Touch Menu help Restaurants to ceate digital QR Menu card. Zero touch menu card useful for Restaurants,Hotels, Resorts,food outlets etc.
	Try Zero touch menu card for 1 month free, with no fee!">
	<meta property="og:url" content="https://www.foodnai.com/">
	<meta property="og:site_name" content="https://www.foodnai.com/">
	<meta content="Zero Touch Menu Card, QR Code Menu Card For Restaurant, Get QR Code for Restaurant, Digital Menu Card for Restaurant, Contact Less Menu Card For Restaurant" name="keyword">
		
	<meta property="og:image" content="https://www.foodnai.com/assets/img/foodnai_shareimg2.jpg" />
	<meta property="og:image:secure_url" itemprop="image" content="https://www.foodnai.com/assets/img/foodnai_shareimg2.jpg" />
	
	<meta property="og:image:type" content="image/jpg" />  
	<meta property="og:image:alt" content="Foodnai" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Template style.css -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/owl.carousel.css">
    <link rel="stylesheet" type="text/css" href="css/fontello.css">
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
	
    <link rel="stylesheet" type="text/css" href="css/owl.theme.css">
    <link rel="stylesheet" type="text/css" href="css/owl.transitions.css">
    
    <!-- Font used in template -->
    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,400italic,500,500italic,700,700italic,300italic,300' rel='stylesheet' type='text/css'>
    <!--font awesome icon -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- favicon icon -->
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	<style>
	.label-danger {
		background-color: #e91e63;
		color: #fff;
		text-transform: uppercase;
		font-size: 10px;
		padding: 4px 8px;
		border-radius: 2px;
		font-weight: 700;
	}
	.label-default {
		background-color: #ffffff;
		border: 1px solid black;
		color: #000000;
		text-transform: uppercase;
		font-size: 10px;
		padding: 4px 8px;
		border-radius: 2px;
		font-weight: 700;
	}
	#navigation > ul > li > a {
		color: black!important;
	}
	</style>
</head>

<body>
    <div class="collapse" id="searcharea">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Search for...">
            <span class="input-group-btn">
    <button class="btn tp-btn-primary" type="button">Search</button>
    </span> </div>
    </div>
    <div class="header" style="background: #ffffff;">
        <div class="container">
            <div class="row">
                <div class="col-md-3 logo">
                    <div class="navbar-brand">
                        <a href="landing_page.php"><img src="../assets/images/brand/FoodNAILoginLogo.png" alt="Wedding Vendors" class="img-responsive" style="height:45px"></a>
                        <!--<a href="landing_page.php"><img src="../assets/img/FoodNAI Logo.png" alt="Wedding Vendors" class="img-responsive" style="height:45px"></a>-->
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="navigation" id="navigation">
                        <ul>
                            <li class="active"><a href="login()" target="_blank" style="color:#ffffff;">Login</a></li>
                            <li class="active"><a href="index.html" target="_blank" style="color:#ffffff;">Signup</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tp-page-head">
        <!-- page header -->
        <div class="container">
            <div class="row">
                <div class="col-md-offset-2 col-md-8">
                    <div class="page-header text-center">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="main-container">
        <div class="container tabbed-page st-tabs">
            <div class="row tab-page-header">
				<?php
					$sql = "SELECT * FROM user WHERE id = '$restaurant_id'";
					
					$get_vendor_query=mysqli_query($conn,$sql);
					
                    $count_get_vendor_query=mysqli_num_rows($get_vendor_query);
                    if($count_get_vendor_query > 0)
                    {
						$row_get_vendor_query = mysqli_fetch_assoc($get_vendor_query);
						
						$vendorId = $row_get_vendor_query['id'];
						$vendorEmail = $row_get_vendor_query['email'];
						$vendorPhoto = $row_get_vendor_query['profile_photo'];
						$vendoraddress = $row_get_vendor_query['address'];
						$businessName = stripslashes($row_get_vendor_query['business_name']);
						$about_restaurant = stripslashes($row_get_vendor_query['about_restaurant']);
						$vendorName = $row_get_vendor_query['name'];
						$vendorCity = $row_get_vendor_query['city'];
						$postcode = $row_get_vendor_query['postcode'];
						$rest_img_1 = $row_get_vendor_query['rest_img_1'];
						$rest_img_2 = $row_get_vendor_query['rest_img_2'];
						$rest_img_3 = $row_get_vendor_query['rest_img_3'];
						$rest_img_4 = $row_get_vendor_query['rest_img_4'];
						$rest_img_5 = $row_get_vendor_query['rest_img_5'];
                 ?>
                <div class="col-md-8 title"> 
                    <h1><?=$businessName?></h1>
                    <p class="location"><i class="fa fa-map-marker"></i><?=$vendoraddress?>, <?=$vendorCity?>, <?=$postcode?></p>
					<a href="#" class="label-danger">About Review</a>
					<a href="#" class="label-default">Direction</a>
					<a href="#" class="label-default">Bookmark</a>
					<a href="#" class="label-default">Share</a>
					<a href="#" class="label-danger">Order Now</a>
                    <hr>
					<h2>About this place</h2>
					<p><?=$about_restaurant?> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
					
					<?php
						if(($rest_img_1 != '') || ($rest_img_2 != '') || ($rest_img_3 != '') || ($rest_img_4 != '') || ($rest_img_5 != '')) {
					?>
					<div class="row">
						<div class="col-md-12">
							<!-- Nav tabs -->
							<div class="tab-content">
								<!-- tab content start-->
								<div role="tabpanel" class="tab-pane fade in active" id="photo">
									<div id="sync2" class="owl-carousel">
										<?php if($rest_img_1 != '') ?>
										<div class="item"> <img src="<?=$rest_img_1?>" alt="" class="img-responsive"> </div>
										<?php if($rest_img_2 != '') ?>
										<div class="item"> <img src="<?=$rest_img_2?>" alt="" class="img-responsive"> </div>
										<?php if($rest_img_3 != '') ?>
										<div class="item"> <img src="<?=$rest_img_3?>" alt="" class="img-responsive"> </div>
										<?php if($rest_img_4 != '') ?>
										<div class="item"> <img src="<?=$rest_img_4?>" alt="" class="img-responsive"> </div>
										<?php if($rest_img_5 != '') ?>
										<div class="item"> <img src="<?=$rest_img_5?>" alt="" class="img-responsive"> </div>
									</div>
								</div>
							</div>
							<!-- /.tab content start-->
						</div>
					</div>
					<?php } ?>
                </div>
                <div class="col-md-4 venue-data">
                    <div class="venue-info">
                        <!-- venue-info-->
                        <div class="capacity">
                            <div>
								<i class="fa fa-star" aria-hidden="true"></i>
								<i class="fa fa-star" aria-hidden="true"></i>
								<i class="fa fa-star" aria-hidden="true"></i>
								<i class="fa fa-star" aria-hidden="true"></i>
								<i class="fa fa-star-half-o" aria-hidden="true"></i>&nbsp;4.5<br>
								<small>824 Dining Reviews</small><br>
							</div>
						</div>
                        <div class="pricebox">
                            <div>
								<i class="fa fa-star" aria-hidden="true"></i>
								<i class="fa fa-star" aria-hidden="true"></i>
								<i class="fa fa-star" aria-hidden="true"></i>
								<i class="fa fa-star-o" aria-hidden="true"></i>
								<i class="fa fa-star-o" aria-hidden="true"></i>&nbsp;3<br>
								<small>67 Delivery Reviews</small><br>
							</div>
                        </div>
                    </div>
                     
				</div>
					<?php } ?>
            </div>
            
            
        </div>
    </div>
    <div class="footer">
        <!-- Footer -->
        <div class="container">
            <div class="row">
                <div class="col-md-5 ft-aboutus">
                    <h2>Wedding.Vendor</h2>
                    <p>At Wedding Vendor our purpose is to help people find great online network connecting wedding suppliers and wedding couples who use those suppliers. <a href="#">Start Find Vendor!</a></p>
                    <a href="#" class="btn btn-default">Find a Vendor</a> </div>
                <div class="col-md-3 ft-link">
                    <h2>Useful links</h2>
                    <ul>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Contact us</a></li>
                        <li><a href="#">News</a></li>
                        <li><a href="#">Career</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Use</a></li>
                    </ul>
                </div>
                <div class="col-md-4 newsletter">
                    <h2>Subscribe for Newsletter</h2>
                    <form>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Enter E-Mail Address" required>
                            <span class="input-group-btn">
            <button class="btn btn-default" type="button">Submit</button>
            </span> </div>
                        <!-- /input-group -->
                        <!-- /.col-lg-6 -->
                    </form>
                    <div class="social-icon">
                        <h2>Be Social &amp; Stay Connected</h2>
                        <ul>
                            <li><a href="#"><i class="fa fa-facebook-square"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter-square"></i></a></li>
                            <li><a href="#"><i class="fa fa-google-plus-square"></i></a></li>
                            <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                            <li><a href="#"><i class="fa fa-flickr"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.Footer -->
    <div class="tiny-footer">
        <!-- Tiny footer -->
        <div class="container">
            <div class="row">
                <div class="col-md-12">Copyright © 2014. All Rights Reserved</div>
            </div>
        </div>
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Flex Nav Script -->
    <script src="js/jquery.flexnav.js" type="text/javascript"></script>
    <script src="js/navigation.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script type="text/javascript" src="js/thumbnail-slider.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/header-sticky.js"></script>
    <script src="http://maps.googleapis.com/maps/api/js"></script>
    <script>
    var myCenter = new google.maps.LatLng(23.0203458, 72.5797426);

    function initialize() {
        var mapProp = {
            center: myCenter,
            zoom: 9,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);

        var marker = new google.maps.Marker({
            position: myCenter,

            icon: 'images/pinkball.png'
        });

        marker.setMap(map);
        var infowindow = new google.maps.InfoWindow({
            content: "Hello Address"
        });
    }

    google.maps.event.addDomListener(window, 'load', initialize);
    </script>
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
    <script type="text/javascript" src="js/price-slider.js"></script>
    <script>
    $(function() {
        $("#weddingdate").datepicker();
    });
    </script>
</body>

</html>