
<?php //$conn = mysqli_connect('localhost','root','','foodnai_dev');
include "connection.php";
$q=mysqli_query($conn,"SELECT * from user where usertype='Restaurant' AND is_active=1 AND address != '' AND id NOT IN(85,101,153,154) ORDER BY id DESC limit 8");
$cnt = mysqli_num_rows($q);

$q1=mysqli_query($conn,"SELECT * from user where usertype='Restaurant' AND is_active=1 AND id NOT IN(85,101,153,154) ORDER BY id DESC");
$cnt1 = mysqli_num_rows($q1);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<script async src="https://www.googletagmanager.com/gtag/js?id=G-8ZJNB18KS2"></script>
		<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
		gtag('config', 'G-8ZJNB18KS2');
		</script>
		<meta charset='utf-8'>
		<meta http-equiv='X-UA-Compatible' content='IE=edge'>
		<title>YouCloud</title>
		<meta name='viewport' content='width=device-width, initial-scale=1'>
	  
		<meta name="description" content="Zero Touch Menu
		Zero Touch Menu Card– Digital QR Menu Card
		Zero Touch Menu help Restaurants to ceate digital QR Menu card. Zero touch menu card useful for Restaurants,Hotels, Resorts,food outlets etc.
		Try Zero touch menu card for 1 month free, with no fee!">
		<link rel="canonical" href="https://www.youcloud.com/">
		<meta property="og:title" content="Digital Menu | Zero Touch Menu Card | Restaurant Digital Menu Generator">
		<meta property="og:type" content="website">
		<meta property="og:description" content="Zero Touch Menu
		Zero Touch Menu Card– Digital QR Menu Card
		Zero Touch Menu help Restaurants to ceate digital QR Menu card. Zero touch menu card useful for Restaurants,Hotels, Resorts,food outlets etc.
		Try Zero touch menu card for 1 month free, with no fee!">
		<meta property="og:url" content="https://www.youcloud.com/">
		<meta property="og:site_name" content="https://www.youcloud.com/">
		<meta content="Zero Touch Menu Card, QR Code Menu Card For Restaurant, Get QR Code for Restaurant, Digital Menu Card for Restaurant, Contact Less Menu Card For Restaurant" name="keyword">

		<meta property="og:image" content="https://www.youcloud.com/assets/img/foodnai_shareimg2.jpg" />
		<meta property="og:image:secure_url" itemprop="image" content="https://www.youcloud.com/assets/img/foodnai_shareimg2.jpg" />

		<meta property="og:image:type" content="image/jpg" />  
		<meta property="og:image:alt" content="YouCloud" />
		<!-- Bootstrap -->
		<link href="website_assets/css/bootstrap.min.css" rel="stylesheet">
		<!-- Template style.css -->
		<link rel="stylesheet" type="text/css" href="website_assets/css/style.css">
		<link rel="stylesheet" type="text/css" href="website_assets/css/owl.carousel.css">
		<link rel="stylesheet" type="text/css" href="website_assets/css/owl.theme.css">
		<link rel="stylesheet" type="text/css" href="website_assets/css/owl.transitions.css">
		<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
		<!-- Font used in template -->
		<link href='https://fonts.googleapis.com/css?family=Montserrat:400,700|Roboto:400,400italic,500,500italic,700,700italic,300italic,300' rel='stylesheet' type='text/css'>
		<!--font awesome icon -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
		<!-- favicon icon -->
		<link rel="shortcut icon" href="admin/assets/images/brand/FoodNAI_favicon.png" type="image/x-icon">
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="controller.js?v=<?php echo uniqid();?>"></script>
		
		<style>
		.goog-te-banner-frame.skiptranslate {
    display: none !important;
    } 
body {
    top: 0px !important; 
    }
			ul li .active .dropdown-item{
				background-color:#0FA683;
			}
			.active {
				background-color :#0FA683!important;
			}

			.active:hover {
				background-color :#0FA683!important;
			}

			.dropdown-menu>.active>a, .dropdown-menu>.active>a:focus, .dropdown-menu>.active>a:hover {
				color: #fff;
				text-decoration: none;
				background-color:#0FA683;
				outline: 0;
			}
			/* a{
			background-color :green!important;
			} */
			.navli {
				font-size: 12px;
				color: #ffffff;
				text-transform: uppercase;
				font-weight: 500;
				cursor: pointer;
				/* padding-right: 7px;
				padding-top: 3px; */
				padding: 29px 10px!important;
			}
		</style>
	</head>

<body style="background-color:white;">
    <div class="collapse" id="searcharea">
        <!-- top search -->
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Search for...">
            <span class="input-group-btn">
				<button class="btn btn-primary" type="button">Search</button>
			</span>
        </div>
    </div>
    <!-- /.top search -->
    <div class="top-bar" style="background-color:#0FA683;">
        <div class="container">
            <div class="row">
                <div class="col-md-3 logo">
                    <div class="navbar-brand">
                        <!--<a href="index.php"><img src="./assets/images/brand/FoodNAILoginLogo.png" alt="Wedding Vendors" class="img-responsive" style="height:45px"></a>-->
                        <a href="index.php"><img src="./assets/images/brand/FoodNAIHeaderLogo.png" alt="Wedding Vendors" class="img-responsive" style="height:45px"></a>
                    </div>
                </div>
                <!--<div class="col-md-7">
                    <div class="row" style="margin-top: 11px;">
                        <div class="form-group col-md-5">
                        <input type="hidden" id="send_post_code">
                        <input type="hidden" id="send_restaurant_id">
                            <input type="text" class="form-control pincode typehead"  placeholder="Search by address/pincode" id="pincode" autocomplete="off">
                        </div>
                        <div class="form-group col-md-5">
                            <input type="text" name="restaurant_id" class="form-control restaurant_id typeahead" data-provide="typeahead" placeholder="Search by restaurant" autocomplete="off" id="restaurant_id">
                        </div>
                        <div class="form-group col-md-2">
                            <button class="submit_search btn btn-default btn-sm btn-block">Search</button>
                        </div>
                    </div>
                </div>-->
                <div class="col-md-9">
                    <div class="navigation" id="navigation">
                        <ul class="navul">
                            <li><a href="<?php echo $root_url;?>/index.php"> Home </a></li>
                            <li><a href="<?php echo $root_url;?>/about_us.php"> About </a></li>
                            <li><a href="<?php echo $root_url;?>/contact-us.php">Contact Us</a></li>
                            <li class="navli" onclick="login()" style="padding-right: 16px;">Login</li>
                            <li class="navli" onclick="signup()">Signup</li>
							<li>
								<div class="google_lang_menu menu_details_translate" style="margin-top:20px;">
            						<div id="google_translate_element"></div>
        						</div>
							</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="slider-bg">
        <!-- slider start-->
        <div id="slider" class="owl-carousel owl-theme slider">
            <div class="item"><img src="website_assets/images/sliderimg.jfif" alt="Wedding couple just married"></div>
            <div class="item"><img src="website_assets/images/sliderimg.jfif" alt="Wedding couple just married"></div>
            <div class="item"><img src="website_assets/images/sliderimg.jfif" alt="Wedding couple just married"></div>
        </div>
        <div class="find-section">
            <!-- Find search section-->
            <div class="container">
                <div class="row">
                    <div class="col-md-offset-1 col-md-10 finder-block">
                        <div class="finder-caption">
                            <h1>Find your Restaurant</h1>
                        </div>
                        <div class="finderform">
                                <div class="row">
                                    <div class="form-group col-md-4">
                                    <input type="hidden" id="send_post_code">
                                    <input type="hidden" id="send_restaurant_id">
                                    <input type="hidden" id="send_restaurant_city">
                                        <input type="text" class="form-control pincode typehead"  placeholder="Search by address/pincode" id="pincode" autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <input type="text" name="restaurant_id" class="form-control restaurant_id typeahead" data-provide="typeahead" placeholder="Search by restaurant" autocomplete="off" id="restaurant_id">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <button class="submit_search btn btn-default btn-lg btn-block">Find Restaurant</button>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.Find search section-->
    </div>
    <!-- slider end-->
    <div class="section list_some_restaurants">
		<div class="main-container">
			<div class="container">
				<div class="row">
					<div class="col-md-8 col-sm-8 col-md-12 col-12">
						<h3 style="font-weight:bold;">Newly listed restaurants (<?php echo $cnt1;?>)</h3>
					</div>
					<div class="col-md-4 col-sm-4 col-md-12 col-12">
						<button class="btn btn-default show_all_rest" style="float:right;margin-bottom: 10px;">View All</button>
					</div>
				</div> 
				<?php 
				if(empty($_GET['page']))
				{ 
				?>
				<!-- <div class="row"> -->
					<!-- <div class="col-md-12 col-sm-12 col-md-12 col-12">
						<button class="btn btn-default show_all_rest" style="float:right;margin-bottom: 10px;">View All</button>
					</div> -->
				<!-- </div> -->
				<div class="row">
				<?php 
				while ($row=mysqli_fetch_assoc($q))
				{ 
					$rcity = ucwords(strtolower($row['city']));
					$raddress = ucwords(strtolower($row['address']));
					$rbusiness_name = trim(ucwords(strtolower($row['business_name'])));
					?>
					<div class="col-md-3 vendor-box">
						<!-- venue box start-->
						<div class="vendor-image" style="border: 1px solid #e9e6e0;">
							<!-- venue pic -->
							<?php 
							if($row['profile_photo'] == 'assets/images/users/user.png'){
							$image_src= 'https://d24h2kiavvgpl8.cloudfront.net/profile/default_restaurant.png';}
							else{
							  $image_src= $row['profile_photo'];
							}?>
							<a href="restaurants/<?php echo $rcity?str_replace(" ","-",$rcity):'';?>/<?=$rbusiness_name?str_replace(" ","-",urlencode($rbusiness_name)):''?>"><img src="<?=$image_src?>" alt="youcloud restaurant" class="img-responsive" style="height: 147px; width: 263px;"></a>
						</div>
						<!-- /.venue pic -->
						<div class="vendor-detail" style="min-height:160px;">
							<!-- venue details -->
							<div style="padding:7px;">
								<!-- caption -->
								<h2><a href="restaurants/<?php echo $rcity?str_replace(" ","-",$rcity):'';?>/<?=$rbusiness_name?str_replace(" ","-",urlencode($rbusiness_name)):''?>" class="title"><?=$rbusiness_name?></a></h2>
								<p class="location" data-toggle="tooltip" title="<?php echo $raddress;?>" rel="tooltip">
									<i class="fa fa-map-marker"></i>
									<?php
									if(strlen($raddress)>100)
									{
										echo substr($raddress,0,100)."...";
										echo '<br>';
										echo $rcity;
									}
									else
									{
										echo $raddress;
										echo '<br>';
										echo $rcity;
									}
									?>
								</p>
							</div>
						</div>
						<!-- venue details -->
					</div>
				<?php 
				}
				}
				?>                
				<!-- venue details -->
				</div>                
            </div>
        </div>
    </div>
	<?php
	if(isset($_GET['page']))
	{
		$showRecordPerPage = 8;
		
		if(isset($_GET['page']) && !empty($_GET['page']))
		{
			$currentPage = $_GET['page'];
		}
		else
		{
			$currentPage = 1;
		}
		
		$startFrom = ($currentPage * $showRecordPerPage) - $showRecordPerPage;
		$totalvenSQL = "SELECT * FROM user WHERE is_active = '1' AND usertype='Restaurant' AND id NOT IN(85,101,153,154)  ORDER BY id DESC";
		$allvenResult = mysqli_query($conn, $totalvenSQL);
		$totalvendor = mysqli_num_rows($allvenResult);
		$lastPage = ceil($totalvendor/$showRecordPerPage);
		$firstPage = 1;
		$frstPage = 0;
		/* $frstPage1 = 1; */
		
		/* if($firstPage < $lastPage)
		{
			if($frstPage==0)
			{
				$nextPage = $currentPage + $firstPage;
				$firstPage++;
			}
			else
			{
				$frstPage++;				
				$nextPage.''.$frstPage = $currentPage + $firstPage;
				$firstPage++;
			}
		} */
		
		/* $nextPage = $currentPage + 1;
		$nextPage1 = $currentPage + 2;
		$nextPage2 = $currentPage + 3;
		$nextPage3 = $currentPage + 4;
		$nextPage4 = $currentPage + 5;
		$nextPage5 = $currentPage + 6;
		$nextPage6 = $currentPage + 7;
		$nextPage7 = $currentPage + 8;
		$nextPage8= $currentPage + 9;
		$nextPage9= $currentPage + 10; */
		$previousPage = $currentPage - 1;
	?>	
    <div class="main-container show_pagination_all_restaurant" style="padding-top: 7px;">
        <div class="container">
			<hr style="margin-top:0px!important;">
            <div class="row">
			<?php
			$sql = "SELECT * FROM user WHERE is_active = '1' AND usertype='Restaurant' AND id NOT IN(85,101,153,154) ORDER BY id DESC LIMIT $startFrom, $showRecordPerPage";
			$get_vendor_query=mysqli_query($conn,$sql);					
			$count_get_vendor_query=mysqli_num_rows($get_vendor_query);
			
			if($count_get_vendor_query > 0)
			{
				while($row_get_vendor_query = mysqli_fetch_assoc($get_vendor_query))
				{
					$vendorId = $row_get_vendor_query['id'];
					$vendorEmail = $row_get_vendor_query['email'];
					$vendorPhoto = $row_get_vendor_query['profile_photo'];
					$vendoraddress = stripslashes($row_get_vendor_query['address']);
					$businessName = trim(stripslashes(ucwords($row_get_vendor_query['business_name'])));
					$vendorName = $row_get_vendor_query['name'];
					$vendorCity = $row_get_vendor_query['city'];
					if($vendorCity != '')
						$fulladdress = $vendorCity ;
					else
						$fulladdress = '';
				?>
                <div class="col-md-3 vendor-box">
                    <div class="vendor-image" style="border: 1px solid #e9e6e0;">
                        <a href="restaurants/<?php echo $vendorCity?str_replace(" ","_",$vendorCity):'';?>/<?=$businessName?str_replace(" ","-",$businessName):''?>">
							<?php if($vendorPhoto == 'assets/images/users/user.png'){ ?>
							<img src="<?='https://d24h2kiavvgpl8.cloudfront.net/profile/default_restaurant.png'?>" alt="youcloud restaurant" class="img-responsive" style="height: 147px; width: 263px;">
							<?php }else { ?>
							<img src="<?=$vendorPhoto?>" alt="youcloud restaurant" class="img-responsive" style="height: 147px; width: 263px;">
							<?php } ?>
						</a>
                    </div>
                    <div class="vendor-detail" style="height:160px;">
                        <div class="caption" style="padding: 11px;">
                            <h2><a href="restaurants/<?php echo $vendorCity?str_replace(" ","_",$vendorCity):'';?>/<?=$businessName?str_replace(" ","-",$businessName):''?>" class="title"><?=$businessName?></a></h2>
                            <p class="location" style="margin-bottom: 0px!important;max-height:80px;overflow:hidden;" title="<?php echo ucwords(strtolower($vendoraddress)); ?>">
                                <?php if(($fulladdress != '') || ($vendoraddress !=''))
								{
								?>
									<i class="fa fa-map-marker"></i>
									<?php 
									if(strlen($vendoraddress)>22)
									{
										echo substr(strtolower($vendoraddress),0,22)."...";
									}
									else
									{
										echo ucwords(strtolower($vendoraddress));
									}
								}
								?>
                            </p>
                            <p class="location"><?php echo ucwords(strtolower($fulladdress)); ?></p>
                        </div>
                    </div>
                </div>
				<?php 
				}
			}
			else 
			{
				echo "<h3 style='color:red;'><center>Restaurant not found.</center></h3>";
			}
			?>                
            </div>
            <div class="row">
                <div class="col-md-12 tp-pagination">
					<ul class="pagination">
						<li>
							<!--<a href="#" aria-label="Previous"> <span aria-hidden="true">Previous</span> </a>-->
							<a href="?page=<?php echo $previousPage ?>" aria-label="Previous"> <span aria-hidden="true">Previous</span> </a>
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
						<?php 
						if($currentPage != $lastPage) 
						{
							$i = 1;
							$frstPage0 = 0;
							$frstPage1 = $currentPage;

							for($frstPage1=$currentPage; $frstPage1<$lastPage-1;$frstPage1++)
							{
								if($i<10)
								{
									if($frstPage0==0)
									{
										$nextPage = $currentPage+1;
										$i++;
										$frstPage0++;
										?>
										<li class="page-item"><a class="page-link" href="?page=<?php echo $nextPage ?>"><?php echo $nextPage ?></a></li>
										<?php
									}
									else
									{
										$nextPage = $currentPage + $i;
										$i++;
										$frstPage0++;
										?>
										<li class="page-item"><a class="page-link" href="?page=<?php echo $nextPage ?>"><?php echo $nextPage ?></a></li>
										<?php
									}
								}
							}
							?>
							<!--<li class="page-item"><a class="page-link" href="?page=<?php echo $nextPage ?>"><?php echo $nextPage ?></a></li>
							<li class="page-item"><a class="page-link" href="?page=<?php echo $nextPage1?>"><?php echo $nextPage1 ?></a></li>
							<li class="page-item"><a class="page-link" href="?page=<?php echo $nextPage2 ?>"><?php echo $nextPage2 ?></a></li>
							<li class="page-item"><a class="page-link" href="?page=<?php echo $nextPage3 ?>"><?php echo $nextPage3 ?></a></li>
							<li class="page-item"><a class="page-link" href="?page=<?php echo $nextPage4 ?>"><?php echo $nextPage4 ?></a></li>
							<li class="page-item"><a class="page-link" href="?page=<?php echo $nextPage5 ?>"><?php echo $nextPage5 ?></a></li>
							<li class="page-item"><a class="page-link" href="?page=<?php echo $nextPage6 ?>"><?php echo $nextPage6 ?></a></li>
							<li class="page-item"><a class="page-link" href="?page=<?php echo $nextPage7 ?>"><?php echo $nextPage7 ?></a></li>
							<li class="page-item"><a class="page-link" href="?page=<?php echo $nextPage8 ?>"><?php echo $nextPage8 ?></a></li>-->
							<li class="page-item">
								<span aria-hidden="true" area-disabled = "true">...</span>
							</li>
							<li class="page-item">
								<a class="page-link" href="?page=<?php echo $lastPage ?>" aria-label="Next">
								<span aria-hidden="true"><?php echo $lastPage ?></span>
								</a>
							</li>
							<li class="page-item">
								<a class="page-link" href="?page=<?php echo $lastPage ?>" aria-label="Next">
								<span aria-hidden="true">Last</span>
								</a>
							</li>
						<?php 
						}
						?>								
					</ul>
				</div>
            </div>
        </div>
    </div>
	<?php 
	}
	?>
    <!-- <div class="section-space80 bg-light">
      <div class="container">
          <div class="row">
            <div class="col-md-6">

            </div>
              <div class="col-md-6">
                  <div class="section-title mb60">
                      <h1 style="font-weight:bold;font-size:40px">Get the youcloud App</h1>
                      <p style="font-size:22px;">We will send you a link, Open it on your phone to download the app</p>
                  </div>
                  <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                      <input type="radio" checked>&nbsp;Email &nbsp;&nbsp;
                      <input type="radio">&nbsp;Phone
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                      <input type="text" placeholder="Email" class="form-control">
                    </div>
                    <div class="col-lg-5 col-md-5 col-sm-5 col-5">
                      <button class="form-control btn btn-default">Share APP Link</button>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12" style="margin-top:20px;">
                      <p>Download app from</p>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-4" style="margin-top:10px;">
                      <img src="website_assets/images/button-app-store.png" style="height:50px;width:100%;">
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-4" style="margin-top:10px;">
                      <img src="website_assets/images/button-google-play.png" style="height:50px;width:100%;">
                    </div>
                  </div>
              </div>
          </div>
      </div>
  </div> -->
    <!-- /.Real Weddings -->
    <section class="module parallax parallax-2">
      <div style="background-color:rgba(0,0,0,0.5);background-size:100% 100%;height:400px;">
      <div class="container">
          <div class="row">
              <div class="col-md-offset-2 col-md-8 parallax-caption">
                  <h4 style="color: white;">Grow your restaurant Business</h4>
                  <h2>Add your restaurant now! It's FREE!</h2>
                  <a href="<?php echo $base_url.'register'; ?>" target="_blank" class="btn btn-default" style="margin-top:20px;background-color:white;color:black;line-height:50px;">Get Started <i class="fa fa-play-circle"></i></a> </div>
          </div>
      </div>
      </div>
  </section>
    <!-- /.top location -->
    <div class="section-space80">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
              <div class="section-title mb60 text-center">
                <h1 style="font-weight:bold;">Why YouCloud ?</h1>
              </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6" style="margin-top:10px;">
              <div class="row">
                <div class="col-lg-1 col-md-1 col-sm-4 col-4">
                <i class="fa fa-qrcode" aria-hidden="true" style="color: #0EC89C;font-size:25px;"></i>
                </div>
                <div class="col-lg-11 col-md-11 col-sm-8 col-8">
                  <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                      <h4 style="font-weight:bold;">Scan, Order & Pay</h4>
                      <p>QR Menu ensure Reducing Physical contact and helps your business to apply physical distancing rules.
QR Menu comes with features  such as Increase efficiency, Cost reduction, Time saving and Customer experience enhancement.</p>
                    </div>
                  </div>
                </div>
              </div>
          </div>
          <div class="col-md-6" style="margin-top:10px;">
            <div class="row">
              <div class="col-lg-1 col-md-1 col-sm-4 col-4">
              <i class="fa fa-bank" aria-hidden="true" style="color: #0EC89C;font-size:25px;"></i>
              </div>
              <div class="col-lg-11 col-md-11 col-sm-8 col-8">
                <div class="row">
                  <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <h4 style="font-weight:bold;">Restaurant Management</h4>
                    <p>Running a restaurant is no easy management. You have a never-ending list of tasks, 
from managing menus pricing, table managment and checking in on the kitchen. 
Whether you own a fast food restaurant, fine dining establishment,  restaurant management system to get the most out of your restaurant business.</p>
                  </div>
                </div>
              </div>
            </div>
        </div>
        <div class="col-md-6" style="margin-top:10px;">
          <div class="row">
            <div class="col-lg-1 col-md-1 col-sm-4 col-4">
            <i class="fa fa-list-alt" aria-hidden="true" style="color: #0EC89C;font-size:25px;"></i>
            </div>
            <div class="col-lg-11 col-md-11 col-sm-8 col-8">
              <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                  <h4 style="font-weight:bold;">Waiting List Management</h4>
                  <p>Improve how your restaurant manages your waitlist, while enhancing your table management and optimizing your customers reservation process.
Real-time view, SMS alerts, Call from phone. Capture reservation data through your web panel on your phone.</p>
                </div>
              </div>
            </div>
          </div>
      </div>
      <div class="col-md-6" style="margin-top:10px;">
        <div class="row">
          <div class="col-lg-1 col-md-1 col-sm-4 col-4">
          <i class="fa fa-file-text-o" aria-hidden="true" style="color: #0EC89C;font-size:25px;"></i>
          </div>
          <div class="col-lg-11 col-md-11 col-sm-8 col-8">
            <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <h4 style="font-weight:bold;">Captain Pad</h4>
                <p>Take orders on mobile and send to kitchen by simply creating captain pad logins.
Optionally use the Captain pad to accept orders from table, block or cancel table ordering.
Assign all tables or limited tables to each captain pad for more efficiency.</p>
              </div>
            </div>
          </div>
        </div>
    </div>
        </div>
    </div>
    </div>
    <?php include "footer.php"; ?>
    <!-- /. Testimonial Section -->
    <script>
    // $('body').delegate('.restaurant_id','focus',function(){

    //         var $input = $('.restaurant_id');
    //         //console.log($input);
    //         $.get("getrestaurants.php", function(data){
    //             $input.typeahead({
    //                 source:data,autoSelect: true,
    //                 afterSelect:function(business_name){
    //                   consolde.log(business_name);
    //                 },
    //             });
    //         },'json');
    //     });
    </script>
    <script>
    $(document).ready(function(){
      $('.pincode').click(function(){
        $('.pincode').val('');
        $('#send_post_code').val('');
      });
      $(".restaurant_id").click(function(){
        $('.restaurant_id').val('');
        $('#send_restaurant_id').val('');
        $('#send_restaurant_city').val('');
        
      });
      $('.submit_search').click(function(){
        if($('#send_post_code').val() !='' && $('#send_restaurant_id').val() ==''){
          window.location.href ='restaurant_listing.php?pin_code='+$('#send_post_code').val();
        }
        if($('#send_restaurant_id').val() !=''){
          //window.location.href ='restaurant_page.php?restaurant_id='+$('#send_restaurant_id').val();
          let selectedrestcity = $('#send_restaurant_city').val()?$('#send_restaurant_city').val().split(' ').join('-'):'';
          let selectedrestid = $('#send_restaurant_id').val().split(' ').join('-');
          
          window.location.href ='restaurants/'+selectedrestcity+'/'+selectedrestid;
        }
        // if($('#send_post_code').val() !='' && $('#send_restaurant_id').val() !=''){
        //   window.location.href ='restaurant_page.php?restaurant_id='+$('#send_restaurant_id').val()+'&pin_code='+$('#send_post_code').val();
        // }
      });

      $('.pincode').keyup(function(){
        var $inputaddress = $(".pincode");
        var search_content = $inputaddress.val();
        if(search_content.length > 2){
          $.get("getaddress.php?search="+search_content, function(data){
																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																													   
										
										
          $inputaddress.typeahead({
                source:data,autoSelect: true,
                afterSelect:function(item){
                    console.log(item);
                    $('#send_post_code').val(item.id);
                    // $('.input-item-id').val(item.id);
                    // $('#input-price').val(item.price);
                    // $('#input-qty').val('1');
                    // $('#input-discount').val('0');
                }
            });
        },'json');
      }
        //console.log($inputaddress.val());
      })
      var $input = $(".restaurant_id");
        $.get("getrestaurants.php", function(data){
																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																													   
										
										
          $input.typeahead({
                source:data,autoSelect: true,
                afterSelect:function(item){
                  console.log(item);
                    $('#send_restaurant_id').val(item.name);
                    $('#send_restaurant_city').val(item.city);
                    // $('.input-item-id').val(item.id);
                    // $('#input-price').val(item.price);
                    // $('#input-qty').val('1');
                    // $('#input-discount').val('0');
                }
            });
        },'json');
    });
    </script>

    <script>
    $('.show_all_rest').click(function(){
      window.location.href="index.php?page=1";
    });
    </script>
</body>
</html>