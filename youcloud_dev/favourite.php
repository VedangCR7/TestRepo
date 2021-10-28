<?php include 'header.php'; ?>

<!-- SPECIFIC CSS -->
<link href="<?= $root_url; ?>/website_assets/webAssets/css/listing.css" rel="stylesheet">

	<main>
		<div class="page_header element_to_stick">
		    <div class="container">
		    	<div class="row">
		    		<div class="col-xl-8 col-lg-7 col-md-7 d-none d-md-block">
		        		<h1>Top Restaurant Nearest You</h1>
		        		<a href="addnewaddress.php">Change address</a>
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
				
				<?php include 'ac_sidebar.php'; ?>

				<div class="col-lg-9">
                    <div class="account_table myaddress mt-4">
                        <h4 class="accounttable_heading mb-4"><i class="icon_heart"></i> My favorite</h4>
                        <div class="row mt-5">
                            <div class="col-lg-4">
                                <div class="favorite_wrapper">
                                    <span class="vegetarian_tag">
                                        Vegetarian
                                    </span>
                                    <img src="<?= $root_url; ?>/website_assets/webAssets/img/blog-4.jpg"/>
                                    <h6>Hotel Cafe</h6>
                                    <p>27 Old glouster</p>
                                    
                                    <span class="favourite_rating">
                                        <i class="icon_star_alt"></i>
                                        <i class="icon_star_alt"></i>
                                        <i class="icon_star_alt"></i>
                                        <i class="icon_star_alt"></i>
                                        <i class="icon_star_alt"></i>
                                    </span>
                                    <h5>350 Review</h5>
                                    <div class="fs1" aria-hidden="true" data-icon="M"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="favorite_wrapper">
                                    <span class="vegetarian_tag">
                                        Vegetarian
                                    </span>
                                    <img src="<?= $root_url; ?>/website_assets/webAssets/img/blog-4.jpg"/>
                                    <h6>Hotel Cafe</h6>
                                    <p>27 Old glouster</p>
                                    
                                    <span class="favourite_rating">
                                        <i class="icon_star_alt"></i>
                                        <i class="icon_star_alt"></i>
                                        <i class="icon_star_alt"></i>
                                        <i class="icon_star_alt"></i>
                                        <i class="icon_star_alt"></i>
                                    </span>
                                    <h5>350 Review</h5>
                                    <div class="fs1" aria-hidden="true" data-icon="M"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="favorite_wrapper">
                                    <span class="vegetarian_tag">
                                        Vegetarian
                                    </span>
                                    <img src="<?= $root_url; ?>/website_assets/webAssets/img/blog-4.jpg"/>
                                    <h6>Hotel Cafe</h6>
                                    <p>27 Old glouster</p>
                                    
                                    <span class="favourite_rating">
                                        <i class="icon_star_alt"></i>
                                        <i class="icon_star_alt"></i>
                                        <i class="icon_star_alt"></i>
                                        <i class="icon_star_alt"></i>
                                        <i class="icon_star_alt"></i>
                                    </span>
                                    <h5>350 Review</h5>
                                    <div class="fs1" aria-hidden="true" data-icon="M"></div>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
				<!-- /col -->
			</div>		
		</div>
		<!-- /container -->
		
	</main>

<?php include 'footer.php'; ?>

<!-- SPECIFIC SCRIPTS -->
<script src="<?= $root_url; ?>/website_assets/webAssets/js/sticky_sidebar.min.js"></script>
<script src="<?= $root_url; ?>/website_assets/webAssets/js/specific_listing.js"></script>