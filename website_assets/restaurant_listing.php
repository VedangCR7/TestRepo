<?php
    error_reporting(0);	
	include "connection.php";
	$pincode = $_REQUEST['pin_code'];
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
    <!--<div class="tp-page-head">
        <div class="container">
            <div class="row">
                <div class="col-md-offset-2 col-md-8">
                    <div class="page-header text-center">
                        <div class="icon-circle">
                            <i class="icon icon-size-60 icon-menu icon-white"></i>
                        </div>
                        <h1>4 Column Listing</h1>
                        <p>Listing alos come with 4 column.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>-->
    <!--<div class="row">
		<div class="col-md-12">
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane fade in active" id="photo" style="background: black;">
					<div id="sync2" class="owl-carousel">
						<?php
							$offer = "SELECT * FROM `admin_offer` WHERE `status`= 1 AND `offer_image` != ''";
							$offerResult = mysqli_query($conn, $offer);
							$offerCnt = mysqli_num_rows($offerResult);
							if($offerCnt > 0) {
								while($offerRow = mysqli_fetch_assoc($offerResult))
								{
									$offerPhoto = $offerRow['offer_image'];
						?>
						<div class="item"> <img src="<?=$offerPhoto?>" alt="" class="img-responsive"> </div>
						
						<?php } } ?>
					</div>
				</div>
			</div>
		</div>
	</div>-->
	
	<?php
		$showRecordPerPage = 8;
		if(isset($_GET['page']) && !empty($_GET['page'])){
			$currentPage = $_GET['page'];
		}else{
			$currentPage = 1;
		}
		$startFrom = ($currentPage * $showRecordPerPage) - $showRecordPerPage;
		$totalvenSQL = "SELECT * FROM user WHERE is_active = '1' AND usertype='Restaurant' AND postcode='$pincode'";
		$allvenResult = mysqli_query($conn, $totalvenSQL);
		$totalvendor = mysqli_num_rows($allvenResult);
		$lastPage = ceil($totalvendor/$showRecordPerPage);
		$firstPage = 1;
		$nextPage = $currentPage + 1;
		$previousPage = $currentPage - 1; 
	?>
	
    <div class="main-container" style="padding-top: 7px;">
        <div class="container">
			<div class="row">
                <div class="col-md-3 logo">
                    <div class="navbar-brand">
                        <h4><b><?=$totalvendor?> restaurants</b></h4>
                    </div>
                </div>
                <!--<div class="col-md-9">
                    <div class="navigation" id="navigation">
                        <ul>
                            <li class="active"><a href="login()" target="_blank">Distance</a></li>
                            <li class="active"><a href="index.html" target="_blank">Delivery Time</a></li>
                            <li class="active"><a href="index.html" target="_blank">Rating</a></li>
                            <li class="active"><a href="index.html" target="_blank">Filters</a></li>
                        </ul>
                    </div>
                </div>-->
            </div>
			<hr style="margin-top:0px!important;">
            <div class="row">
			
			
				<?php
					$sql = "SELECT * FROM user WHERE is_active = '1' AND usertype='Restaurant' AND postcode='$pincode' LIMIT $startFrom, $showRecordPerPage";
					
					$get_vendor_query=mysqli_query($conn,$sql);
					
                    $count_get_vendor_query=mysqli_num_rows($get_vendor_query);
                    if($count_get_vendor_query > 0)
                    {
						while($row_get_vendor_query = mysqli_fetch_assoc($get_vendor_query))
						{
							$vendorId = $row_get_vendor_query['id'];
							$vendorEmail = $row_get_vendor_query['email'];
							$vendorPhoto = $row_get_vendor_query['profile_photo'];
							$vendoraddress = $row_get_vendor_query['address'];
							$businessName = stripslashes($row_get_vendor_query['business_name']);
							$vendorName = $row_get_vendor_query['name'];
							$vendorCity = $row_get_vendor_query['city'];
                    
							
				?>
			
			
                <div class="col-md-3 vendor-box" style="min-height:245px!important;">
                    <div class="vendor-image">
                        <a href="restaurant_page.php?restaurant_id=<?=$vendorId?>">
							<?php if($vendorPhoto == 'assets/images/users/user.png'){ ?>
							<img src="<?='https://d24h2kiavvgpl8.cloudfront.net/profile/default_restaurant.png'?>" alt="wedding venue" class="img-responsive" style="height: 147px; width: 263px;">
							<?php }else { ?>
							<img src="<?=$vendorPhoto?>" alt="wedding venue" class="img-responsive" style="height: 147px; width: 263px;">
							<?php } ?>
						</a>
                    </div>
                    <div class="vendor-detail">
                        <div class="caption" style="padding: 11px;">
                            <h2><a href="restaurant_page.php?restaurant_id=<?=$vendorId?>" class="title"><?=$businessName?></a></h2>
                            <p class="location"><i class="fa fa-map-marker"></i> <?=$vendorCity?></p>
                        </div>
                    </div>
                </div>
				
				<?php } } ?>
                
            </div>
            <div class="row">
                <div class="col-md-12 tp-pagination">
                <ul class="pagination">
                    <li>
                        <a href="#" aria-label="Previous"> <span aria-hidden="true">Previous</span> </a>
                    </li>
                    <?php if($currentPage != $firstPage) { ?>
					<li class="page-item">
					  <a class="page-link" href="?page=<?php echo $firstPage ?>" tabindex="-1" aria-label="Previous">
						<span aria-hidden="true">First</span>           
					  </a>
					</li>
					<?php } ?>
					<?php if($currentPage >= 2) { ?>
						<li class="page-item"><a class="page-link" href="?page=<?php echo $previousPage ?>"><?php echo $previousPage ?></a></li>
					<?php } ?>
					<li class="page-item active"><a class="page-link" href="?page=<?php echo $currentPage ?>"><?php echo $currentPage ?></a></li>
					<?php if($currentPage != $lastPage) { ?>
						<li class="page-item"><a class="page-link" href="?page=<?php echo $nextPage ?>"><?php echo $nextPage ?></a></li>
						<li class="page-item">
						  <a class="page-link" href="?page=<?php echo $lastPage ?>" aria-label="Next">
							<span aria-hidden="true">Last</span>
						  </a>
						</li>
					<?php } ?>
								
					</ul>
				</div>
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
                <div class="col-md-12">Copyright © 2021. All Rights Reserved</div>
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
    <script src="js/jquery.sticky.js"></script>
    <script src="js/header-sticky.js"></script>
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
    <script type="text/javascript" src="js/price-slider.js"></script>
	
	
    <script type="text/javascript" src="js/thumbnail-slider.js"></script>
    <script src="http://maps.googleapis.com/maps/api/js"></script>
	
	<script src="../controller.js"></script>
</body>

</html>
