<?php 

include 'header.php';

include "connection.php";

$pincode = $_REQUEST['pin_code'];

?>

<?php
		$showRecordPerPage = 8;
		if(isset($_GET['page']) && !empty($_GET['page'])){
			$currentPage = $_GET['page'];
		}else{
			$currentPage = 1;
		}
		$startFrom = ($currentPage * $showRecordPerPage) - $showRecordPerPage;
		if($pincode != '') 
			$totalvenSQL = "SELECT * FROM user WHERE is_active = '1' AND usertype='Restaurant' AND postcode='$pincode' AND id NOT IN(85,101,153,154)";
		else
			$totalvenSQL = "SELECT * FROM user WHERE is_active = '1' AND usertype='Restaurant' AND id NOT IN(85,101,153,154)";
		$allvenResult = mysqli_query($conn, $totalvenSQL);
		$totalvendor = mysqli_num_rows($allvenResult);
		$lastPage = ceil($totalvendor/$showRecordPerPage);
		$firstPage = 1;
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
	
	
	
    <!-- SPECIFIC CSS -->
    <link href="<?= $root_url; ?>/website_assets/webAssets/css/listing.css" rel="stylesheet">


	<main>
		<div class="page_header element_to_stick">
		    <div class="container">
		    	<div class="row">
		    		<div class="col-xl-8 col-lg-7 col-md-7 d-none d-md-block">
		        		<h1>Top Restaurant Nearest You</h1>
		        		<a href="#0">Change</a>
		    		</div>
		    		<div class="col-xl-4 col-lg-5 col-md-5">
		    			<div class="search_bar_list">
							<input type="text" class="form-control" placeholder="Dishes, restaurants or cuisines">
							<button type="submit"><i class="icon_search"></i></button>
						</div>
		    		</div>
		    	</div>
		    	<!-- /row -->		       
		    </div>
		</div>
		<!-- /page_header -->

		<div class="container margin_30_20">			
			<div class="row">
				<aside class="col-lg-3" id="sidebar_fixed">
					<div class="type_delivery">
						<ul class="clearfix">
						    <li>
						        <label class="container_radio">Delivery
						            <input type="radio" name="type_d" checked="checked">
						            <span class="checkmark"></span>
						        </label>
						    </li>
						    <li>
						        <label class="container_radio">Take away
						            <input type="radio" name="type_d">
						            <span class="checkmark"></span>
						        </label>
						    </li>
						</ul>
					</div>
					<!-- /type_delivery -->
				
					<a href="#0" class="open_filters btn_filters"><i class="icon_adjust-vert"></i><span>Filters</span></a>
				
					<div class="filter_col">
						<div class="inner_bt clearfix">Filters<a href="#" class="open_filters"><i class="icon_close"></i></a></div>
						<div class="filter_type">
							<h4><a href="#filter_1" data-toggle="collapse" class="opened">Sort</a></h4>
							<div class="collapse show" id="filter_1">
								<ul>
								    <!--<li>-->
								    <!--    <label class="container_radio">Top Rated-->
								    <!--        <input type="radio" name="filter_sort" checked="">-->
								    <!--        <span class="checkmark"></span>-->
								    <!--    </label>-->
								    <!--</li>-->
								    <li>
								        <label class="container_radio">Price: low to high
								            <input type="radio" name="filter_sort">
								            <span class="checkmark"></span>
								        </label>
								    </li>
									<li>
								        <label class="container_radio">Price: high to low 
								            <input type="radio" name="filter_sort">
								            <span class="checkmark"></span>
								        </label>
								    </li>
								</ul>
							</div>
						</div>
						<!-- /filter_type -->
						<div class="filter_type">
							<h4><a href="#filter_2" data-toggle="collapse" class="closed">Cuisine</a></h4>
							<div class="collapse" id="filter_2">
								<ul>
								    
                                    <?php 
                                    
                                    $sql = "SELECT * FROM cuisines WHERE is_active=1";
                                    $result = mysqli_query($conn, $sql);
                                    
                                    if (mysqli_num_rows($result) > 0) {
                                        
                                    while($row = mysqli_fetch_assoc($result)) {
                                        
                                    ?>
								    
								    <li>
								        <label class="container_check"><?php echo $row['cuisines']; ?><small></small>
								            <input type="checkbox">
								            <span class="checkmark"></span>
								        </label>
								    </li>
								    
								    <?php } } ?>
								    
								    <!--<li>-->
								    <!--    <label class="container_check">Asian<small>24</small>-->
								    <!--        <input type="checkbox">-->
								    <!--        <span class="checkmark"></span>-->
								    <!--    </label>-->
								    <!--</li>-->
								    <!--<li>-->
								    <!--    <label class="container_check">International <small>23</small>-->
								    <!--        <input type="checkbox">-->
								    <!--        <span class="checkmark"></span>-->
								    <!--    </label>-->
								    <!--</li>-->
								</ul>
							</div>
						</div>
						<div class="filter_type">
							<h4><a href="#filter_9" data-toggle="collapse" class="closed">Dietary </a></h4>
							<div class="collapse" id="filter_9">
								<ul>
								    <li>
								        <label class="container_check">Veg<small>12</small>
								            <input type="checkbox" value="veg" name="dietary[]">
								            <span class="checkmark"></span>
								        </label>
								    </li>
								    <li>
								        <label class="container_check">Non-Veg<small>24</small>
								            <input type="checkbox" value="nonveg" name="dietary[]">
								            <span class="checkmark"></span>
								        </label>
								    </li>
								    <li>
								        <label class="container_check">Veg/Non-Veg<small>23</small>
								            <input type="checkbox" value="both" name="dietary[]">
								            <span class="checkmark"></span>
								        </label>
								    </li>
								    <li>
								        <label class="container_check">Vegan<small>23</small>
								            <input type="checkbox" value="vegan" name="dietary[]">
								            <span class="checkmark"></span>
								        </label>
								    </li>
								    <li>
								        <label class="container_check">Keto diet <small>11</small>
								            <input type="checkbox" value="ketodiet" name="dietary[]">
								            <span class="checkmark"></span>
								        </label>
								    </li>
								</ul>
							</div>
						</div>
						<!-- /filter_type -->
						<div class="filter_type">
							<h4><a href="#filter_3" data-toggle="collapse" class="closed">Distance</a></h4>
							<div class="collapse" id="filter_3">
								<div class="distance">Radius around selected destination <span></span> km</div>
								<div class="add_bottom_25"><input type="range" min="10" max="50" step="5" value="20" data-orientation="horizontal"></div>
							</div>
						</div>
						<!-- /filter_type -->
						<div class="filter_type last">
							<h4><a href="#filter_4" data-toggle="collapse" class="closed">Rating</a></h4>
							<div class="collapse" id="filter_4">
								<ul>
								    <li>
								        <label class="container_check">5 Star <small>06</small>
								            <input type="checkbox">
								            <span class="checkmark"></span>
								        </label>
								    </li>
								    <li>
								        <label class="container_check">4 Star<small>12</small>
								            <input type="checkbox">
								            <span class="checkmark"></span>
								        </label>
								    </li>
								    <li>
								        <label class="container_check">3 Star <small>17</small>
								            <input type="checkbox">
								            <span class="checkmark"></span>
								        </label>
								    </li>
								    <li>
								        <label class="container_check">2 Star<small>43</small>
								            <input type="checkbox">
								            <span class="checkmark"></span>
								        </label>
								    </li>
								</ul>
							</div>
						</div>
						<!-- /filter_type -->
						<p><a href="#0" class="btn_1 outline full-width">Filter</a></p>
					</div>
				</aside>

				<div class="col-lg-9">
					<!--<div class="row">
						<div class="col-12">
							<h2 class="title_small">Top Categories</h2>
							<div class="owl-carousel owl-theme categories_carousel_in listing">
								<div class="item">
									<figure>
										<img src="<?= $root_url; ?>/website_assets/webAssets/img/cat_listing_placeholder.png" data-src="<?= $root_url; ?>/website_assets/webAssets/img/cat_listing_1.jpg" alt="" class="owl-lazy"></a>
										<a href="#0"><h3>Pizza</h3></a>
									</figure>
								</div>
								<div class="item">
									<figure>
										<img src="<?= $root_url; ?>/website_assets/webAssets/img/cat_listing_placeholder.png" data-src="<?= $root_url; ?>/website_assets/webAssets/img/cat_listing_2.jpg" alt="" class="owl-lazy"></a>
										<a href="#0"><h3>Sushi</h3></a>
									</figure>
								</div>
								<div class="item">
									<figure>
										<img src="<?= $root_url; ?>/website_assets/webAssets/img/cat_listing_placeholder.png" data-src="<?= $root_url; ?>/website_assets/webAssets/img/cat_listing_3.jpg" alt="" class="owl-lazy"></a>
										<a href="#0"><h3>Dessert</h3></a>
									</figure>
								</div>
								<div class="item">
									<figure>
										<img src="<?= $root_url; ?>/website_assets/webAssets/img/cat_listing_placeholder.png" data-src="<?= $root_url; ?>/website_assets/webAssets/img/cat_listing_4.jpg" alt="" class="owl-lazy"></a>
										<a href="#0"><h3>Hamburgher</h3></a>
									</figure>
								</div>
								<div class="item">
									<figure>
										<img src="<?= $root_url; ?>/website_assets/webAssets/img/cat_listing_placeholder.png" data-src="<?= $root_url; ?>/website_assets/webAssets/img/cat_listing_5.jpg" alt="" class="owl-lazy"></a>
										<a href="#0"><h3>Ice Cream</h3></a>
									</figure>
								</div>
								<div class="item">
									<figure>
										<img src="<?= $root_url; ?>/website_assets/webAssets/img/cat_listing_placeholder.png" data-src="<?= $root_url; ?>/website_assets/webAssets/img/cat_listing_6.jpg" alt="" class="owl-lazy"></a>
										<a href="#0"><h3>Kebab</h3></a>
									</figure>
								</div>
								<div class="item">
									<figure>
										<img src="<?= $root_url; ?>/website_assets/webAssets/img/cat_listing_placeholder.png" data-src="<?= $root_url; ?>/website_assets/webAssets/img/cat_listing_7.jpg" alt="" class="owl-lazy"></a>
										<a href="#0"><h3>Italian</h3></a>
									</figure>
								</div>
								<div class="item">
									<figure>
										<img src="<?= $root_url; ?>/website_assets/webAssets/img/cat_listing_placeholder.png" data-src="<?= $root_url; ?>/website_assets/webAssets/img/cat_listing_8.jpg" alt="" class="owl-lazy"></a>
										<a href="#0"><h3>Chinese</h3></a>
									</figure>
								</div>	
							</div>
							
						</div>
					</div>-->
					<!-- /row -->

					<!--<div class="promo offerbanner">
						<div class="row">
							<div class="col-lg-8">
								<h3>Offers and Promotion banner
								</h3>
								<p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip.</p>
								
							</div>
							<div class="col-lg-4 text-right">
								<a href="#0" class="btn_1 outline youcloudwhite_btn mt-3">Explore Now</a>
							</div>
						</div>
					</div>-->
					<!-- /promo -->
					
					<div class="row">
						<div class="col-12"><h2 class="title_small">Best offers in town</h2></div>
					<?php
					if($pincode != '')
						$sql = "SELECT * FROM user WHERE is_active = '1' AND usertype='Restaurant' AND postcode='$pincode' AND id NOT IN(85,101,153,154) LIMIT $startFrom, $showRecordPerPage";
					else
						$sql = "SELECT * FROM user WHERE is_active = '1' AND usertype='Restaurant' AND id NOT IN(85,101,153,154) LIMIT $startFrom, $showRecordPerPage";
					
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
							$businessName = stripslashes(ucwords($row_get_vendor_query['business_name']));
							$vendorName = $row_get_vendor_query['name'];
							$vendorCity = $row_get_vendor_query['city'];
                            if($vendorCity != '')
                                $fulladdress = $vendorCity ;
                            else
                                $fulladdress = '';
				    ?>
						<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
							<div class="strip">
							    <figure>
							    	<span class="ribbon off">15% off</span>
							        <!--<img src="<?= $root_url; ?>/website_assets/webAssets/img/lazy-placeholder.png" data-src="<?= $root_url; ?>/website_assets/webAssets/img/location_1.jpg" class="img-fluid lazy" alt="">-->
							       
                                    <?php if($vendorPhoto == 'assets/images/users/user.png'){ ?>
                                    <img src="<?='https://d24h2kiavvgpl8.cloudfront.net/profile/default_restaurant.png'?>" alt="wedding venue" class="img-responsive" style="height: 147px; width: 263px;">
                                    <?php }else { ?>
                                    <img src="<?=$vendorPhoto?>" alt="wedding venue" class="img-responsive" style="height: 147px; width: 263px;">
                                    <?php } ?>
							       
							       <?php if(empty($_SESSION) && isset($_SESSION['user_id'])){  }?>
							       
							       
							       <a <?php if(empty($_SESSION) && !isset($_SESSION['user_id'])){?> href="login.php?restoname=<?php echo $businessName; ?>"  <?php }else{?> href="restaurant_detail.php?vid=<?php echo $vendorId; ?>"  <?php }  ?>   class="sign-in1 strip_info login1">
							            <small>Pizza</small>
							            <div class="item_title">
							                <h3><?=$businessName?></h3>
							                <small><?php if(($fulladdress != '') || ($vendoraddress !='')){ ?><?php echo ucwords(strtolower($vendoraddress)); ?><br>
                                            <?php echo ucwords(strtolower($fulladdress)); ?>
                                            <?php } ?></small>
							            </div>
							        </a>
							    </figure>
							    <ul>
							        <li><span class="take yes">Takeaway</span> <span class="deliv yes">Delivery</span></li>
							        <li>
							        	<div class="score"><strong>8.9</strong></div>
							        </li>
							    </ul>
							</div>
						</div>
						
					<?php } }else {echo "<h3 style='color:red;'><center>Restaurant not found.</center></h3>";} ?>
					
						<!-- /strip grid -->
						<!--<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">-->
						<!--	<div class="strip">-->
						<!--	    <figure>-->
						<!--	        <img src="<?= $root_url; ?>/website_assets/webAssets/img/lazy-placeholder.png" data-src="<?= $root_url; ?>/website_assets/webAssets/img/location_2.jpg" class="img-fluid lazy" alt="">-->
						<!--	       <a href="#sign-in-dialog" class="sign-in strip_info login">-->
						<!--	            <small>Burghers</small>-->
						<!--	            <div class="item_title">-->
						<!--	                <h3>Best Burghers</h3>-->
						<!--	                <small>27 Old Gloucester St</small>-->
						<!--	            </div>-->
						<!--	        </a>-->
						<!--	    </figure>-->
						<!--	    <ul>-->
						<!--	        <li><span class="take no">Takeaway</span> <span class="deliv yes">Delivery</span></li>-->
						<!--	        <li>-->
						<!--	        	<div class="score"><strong>9.5</strong></div>-->
						<!--	        </li>-->
						<!--	    </ul>-->
						<!--	</div>-->
						<!--</div>-->
						<!-- /strip grid -->
						<!--<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">-->
						<!--	<div class="strip">-->
						<!--	    <figure>-->
						<!--	    	<span class="ribbon off">15% off</span>-->
						<!--	        <img src="<?= $root_url; ?>/website_assets/webAssets/img/lazy-placeholder.png" data-src="<?= $root_url; ?>/website_assets/webAssets/img/location_3.jpg" class="img-fluid lazy" alt="">-->
						<!--			<a href="#sign-in-dialog" id="sign-in" class="strip_info login">-->
						<!--	            <small>Vegetarian</small>-->
						<!--	            <div class="item_title">-->
						<!--	                <h3>Vego Life</h3>-->
						<!--	                <small>27 Old Gloucester St</small>-->
						<!--	            </div>-->
						<!--	        </a>-->
						<!--	    </figure>-->
						<!--	    <ul>-->
						<!--	       <li><span class="take yes">Takeaway</span> <span class="deliv no">Delivery</span></li>-->
						<!--	        <li>-->
						<!--	        	<div class="score"><strong>7.5</strong></div>-->
						<!--	        </li>-->
						<!--	    </ul>-->
						<!--	</div>-->
						<!--</div>-->
						<!-- /strip grid -->
						<!--<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">-->
						<!--	<div class="strip">-->
						<!--	    <figure>-->
						<!--	        <img src="<?= $root_url; ?>/website_assets/webAssets/img/lazy-placeholder.png" data-src="<?= $root_url; ?>/website_assets/webAssets/img/location_4.jpg" class="img-fluid lazy" alt="">-->
						<!--	       <a href="#sign-in-dialog" class="sign-in strip_info login">-->
						<!--	            <small>Japanese</small>-->
						<!--	            <div class="item_title">-->
						<!--	                <h3>Sushi Temple</h3>-->
						<!--	                <small>27 Old Gloucester St</small>-->
						<!--	            </div>-->
						<!--	        </a>-->
						<!--	    </figure>-->
						<!--	    <ul>-->
						<!--	         <li><span class="take no">Takeaway</span> <span class="deliv no">Delivery</span></li>-->
						<!--	        <li>-->
						<!--	        	<div class="score"><strong>9.5</strong></div>-->
						<!--	        </li>-->
						<!--	    </ul>-->
						<!--	</div>-->
						<!--</div>-->
						<!-- /strip grid -->
						<!--<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">-->
						<!--	<div class="strip">-->
						<!--	    <figure>-->
						<!--	        <img src="<?= $root_url; ?>/website_assets/webAssets/img/lazy-placeholder.png" data-src="<?= $root_url; ?>/website_assets/webAssets/img/location_5.jpg" class="img-fluid lazy" alt="">-->
						<!--	       <a href="#sign-in-dialog" class="sign-in strip_info login">-->
						<!--	            <small>Pizza</small>-->
						<!--	            <div class="item_title">-->
						<!--	                <h3>Auto Pizza</h3>-->
						<!--	                <small>27 Old Gloucester St</small>-->
						<!--	            </div>-->
						<!--	        </a>-->
						<!--	    </figure>-->
						<!--	    <ul>-->
						<!--	         <li><span class="take yes">Takeaway</span> <span class="deliv no">Delivery</span></li>-->
						<!--	        <li>-->
						<!--	        	<div class="score"><strong>7.0</strong></div>-->
						<!--	        </li>-->
						<!--	    </ul>-->
						<!--	</div>-->
						<!--</div>-->
						<!-- /strip grid -->
						<!--<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">-->
						<!--	<div class="strip">-->
						<!--	    <figure>-->
						<!--	        <img src="<?= $root_url; ?>/website_assets/webAssets/img/lazy-placeholder.png" data-src="<?= $root_url; ?>/website_assets/webAssets/img/location_6.jpg" class="img-fluid lazy" alt="">-->
						<!--	       <a href="#sign-in-dialog" class="sign-in strip_info login">-->
						<!--	            <small>Burghers</small>-->
						<!--	            <div class="item_title">-->
						<!--	                <h3>Alliance</h3>-->
						<!--	                <small>27 Old Gloucester St</small>-->
						<!--	            </div>-->
						<!--	        </a>-->
						<!--	    </figure>-->
						<!--	    <ul>-->
						<!--	         <li><span class="take no">Takeaway</span> <span class="deliv yes">Delivery</span></li>-->
						<!--	        <li>-->
						<!--	        	<div class="score"><strong>8.9</strong></div>-->
						<!--	        </li>-->
						<!--	    </ul>-->
						<!--	</div>-->
						<!--</div>-->
						<!-- /strip grid -->
						<!--<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">-->
						<!--	<div class="strip">-->
						<!--	    <figure>-->
						<!--	        <img src="<?= $root_url; ?>/website_assets/webAssets/img/lazy-placeholder.png" data-src="<?= $root_url; ?>/website_assets/webAssets/img/location_7.jpg" class="img-fluid lazy" alt="">-->
						<!--	       <a href="#sign-in-dialog" class="sign-in strip_info login">-->
						<!--	            <small>Chinese</small>-->
						<!--	            <div class="item_title">-->
						<!--	                <h3>Alliance</h3>-->
						<!--	                <small>27 Old Gloucester St</small>-->
						<!--	            </div>-->
						<!--	        </a>-->
						<!--	    </figure>-->
						<!--	    <ul>-->
						<!--	        <li><span class="take no">Takeaway</span> <span class="deliv yes">Delivery</span></li>-->
						<!--	        <li>-->
						<!--	        	<div class="score"><strong>8.9</strong></div>-->
						<!--	        </li>-->
						<!--	    </ul>-->
						<!--	</div>-->
						<!--</div>-->
						<!-- /strip grid -->
						<!--<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">-->
						<!--	<div class="strip">-->
						<!--	    <figure>-->
						<!--	        <img src="<?= $root_url; ?>/website_assets/webAssets/img/lazy-placeholder.png" data-src="<?= $root_url; ?>/website_assets/webAssets/img/location_8.jpg" class="img-fluid lazy" alt="">-->
						<!--	       <a href="#sign-in-dialog" class="sign-in strip_info login">-->
						<!--	            <small>Sushi</small>-->
						<!--	            <div class="item_title">-->
						<!--	                <h3>Dragon Tower</h3>-->
						<!--	                <small>27 Old Gloucester St</small>-->
						<!--	            </div>-->
						<!--	        </a>-->
						<!--	    </figure>-->
						<!--	    <ul>-->
						<!--	        <li><span class="take yes">Takeaway</span> <span class="deliv no">Delivery</span></li>-->
						<!--	        <li>-->
						<!--	        	<div class="score"><strong>8.9</strong></div>-->
						<!--	        </li>-->
						<!--	    </ul>-->
						<!--	</div>-->
						<!--</div>-->
						<!-- /strip grid -->
						<!--<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">-->
						<!--	<div class="strip">-->
						<!--	    <figure>-->
						<!--	        <img src="<?= $root_url; ?>/website_assets/webAssets/img/lazy-placeholder.png" data-src="<?= $root_url; ?>/website_assets/webAssets/img/location_9.jpg" class="img-fluid lazy" alt="">-->
						<!--	       <a href="#sign-in-dialog" class="sign-in strip_info login">-->
						<!--	            <small>Mexican</small>-->
						<!--	            <div class="item_title">-->
						<!--	                <h3>El Paso Tacos</h3>-->
						<!--	                <small>27 Old Gloucester St</small>-->
						<!--	            </div>-->
						<!--	        </a>-->
						<!--	    </figure>-->
						<!--	    <ul>-->
						<!--	        <li><span class="take yes">Takeaway</span> <span class="deliv yes">Delivery</span></li>-->
						<!--	        <li>-->
						<!--	        	<div class="score"><strong>8.9</strong></div>-->
						<!--	        </li>-->
						<!--	    </ul>-->
						<!--	</div>-->
						<!--</div>-->
						<!-- /strip grid -->
						<!--<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">-->
						<!--	<div class="strip">-->
						<!--	    <figure>-->
						<!--	        <img src="<?= $root_url; ?>/website_assets/webAssets/img/lazy-placeholder.png" data-src="<?= $root_url; ?>/website_assets/webAssets/img/location_10.jpg" class="img-fluid lazy" alt="">-->
						<!--	       <a href="#sign-in-dialog" class="sign-in strip_info login">-->
						<!--	            <small>Bakery</small>-->
						<!--	            <div class="item_title">-->
						<!--	                <h3>Monnalisa</h3>-->
						<!--	                <small>27 Old Gloucester St</small>-->
						<!--	            </div>-->
						<!--	        </a>-->
						<!--	    </figure>-->
						<!--	    <ul>-->
						<!--	        <li><span class="take yes">Takeaway</span> <span class="deliv yes">Delivery</span></li>-->
						<!--	        <li>-->
						<!--	        	<div class="score"><strong>8.9</strong></div>-->
						<!--	        </li>-->
						<!--	    </ul>-->
						<!--	</div>-->
						<!--</div>-->
						<!-- /strip grid -->
						<!--<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">-->
						<!--	<div class="strip">-->
						<!--	    <figure>-->
						<!--	        <img src="<?= $root_url; ?>/website_assets/webAssets/img/lazy-placeholder.png" data-src="<?= $root_url; ?>/website_assets/webAssets/img/location_11.jpg" class="img-fluid lazy" alt="">-->
						<!--	        <a href="#sign-in-dialog" class="sign-in strip_info login">-->
						<!--	            <small>Mexican</small>-->
						<!--	            <div class="item_title">-->
						<!--	                <h3>Guachamole</h3>-->
						<!--	                <small>135 Newtownards Road</small>-->
						<!--	            </div>-->
						<!--	        </a>-->
						<!--	    </figure>-->
						<!--	    <ul>-->
						<!--	        <li><span class="take yes">Takeaway</span> <span class="deliv yes">Delivery</span></li>-->
						<!--	        <li>-->
						<!--	        	<div class="score"><strong>8.9</strong></div>-->
						<!--	        </li>-->
						<!--	    </ul>-->
						<!--	</div>-->
						<!--</div>-->
						<!-- /strip grid -->
						<!--<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">-->
						<!--	<div class="strip">-->
						<!--	    <figure>-->
						<!--	        <img src="<?= $root_url; ?>/website_assets/webAssets/img/lazy-placeholder.png" data-src="<?= $root_url; ?>/website_assets/webAssets/img/location_12.jpg" class="img-fluid lazy" alt="">-->
						<!--	        <a href="#sign-in-dialog" class="sign-in strip_info login">-->
						<!--	            <small>Chinese</small>-->
						<!--	            <div class="item_title">-->
						<!--	                <h3>Pechino Express</h3>-->
						<!--	                <small>27 Old Gloucester St</small>-->
						<!--	            </div>-->
						<!--	        </a>-->
						<!--	    </figure>-->
						<!--	    <ul>-->
						<!--	        <li><span class="take no">Takeaway</span> <span class="deliv yes">Delivery</span></li>-->
						<!--	        <li>-->
						<!--	        	<div class="score"><strong>8.9</strong></div>-->
						<!--	        </li>-->
						<!--	    </ul>-->
						<!--	</div>-->
						<!--</div>-->
						<!-- /strip grid -->
					</div>
					<!-- /row -->
					<div class="pagination_fg">
					  <a href="#">&laquo;</a>
					  <a href="#" class="active">1</a>
					  <a href="#">2</a>
					  <a href="#">3</a>
					  <a href="#">4</a>
					  <a href="#">5</a>
					  <a href="#">&raquo;</a>
					</div>
				</div>
				<!-- /col -->
			</div>		
		</div>
		<!-- /container -->
		
	</main>
	<!-- /main -->


<script src="<?= $root_url; ?>/website_assets/webAssets/js/sticky_sidebar.min.js"></script>
<script src="<?= $root_url; ?>/website_assets/webAssets/js/specific_listing.js"></script>
    
<?php include 'footer.php'; ?>
    <!-- SPECIFIC SCRIPTS -->