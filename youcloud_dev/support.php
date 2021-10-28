<?php include 'header.php'; ?>


    <!-- SPECIFIC CSS -->
    <link href="<?= $root_url; ?>/website_assets/webAssets/css/listing.css" rel="stylesheet">

	<main>
		<div class="page_header element_to_stick">
		    <div class="container">
		    	<div class="row">
		    		<div class="col-xl-8 col-lg-7 col-md-7 d-none d-md-block">
		        		<h1>Top Restaurants Nearest You</h1>
		        		<a href="addnewaddress.html">Change address</a>
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
                    <div class="account_table mt-4">
                        <h4 class="accounttable_heading"><i class="icon_headphones"></i> Support Ticket</h4>
                        <table class="support_table table">
                            <tbody>
                              <tr>
                                <td>My product is broken. I need refund
                                    <span class="account_details">
                                        <span class="account_delivered">Open</span>
                                        &nbsp;
                                         <span class="account_canceled">Urgent</span>&nbsp;
                                         <date>Oct 12,2021</date>
                                    </span>
                                </td> 
                                <td><a href="supportticket.html" class="reorder">
                                    <i class="arrow_right"></i>
                                </a></td>
                              </tr>
                              <tr>
                                <td>My product is broken. I need refund
                                    <span class="account_details">
                                        <span class="account_delivered">Open</span>
                                        &nbsp;
                                         <span class="account_canceled">Urgent</span>&nbsp;
                                         <date>Oct 12,2021</date>
                                    </span>
                                </td>  
                                <td><a href="supportticket.html" class="reorder">
                                    <i class="arrow_right"></i>
                                </a></td>
                              </tr>
                              <tr>
                                <td>My product is broken. I need refund
                                    <span class="account_details">
                                        <span class="account_delivered">Open</span>
                                        &nbsp;
                                         <span class="account_canceled">Urgent</span>&nbsp;
                                         <date>Oct 12,2021</date>
                                    </span>
                                </td>   
                                <td><a href="supportticket.html" class="reorder">
                                    <i class="arrow_right"></i>
                                </a></td>
                              </tr>
                              <tr>
                                <td>My product is broken. I need refund
                                    <span class="account_details">
                                        <span class="account_delivered">Open</span>
                                        &nbsp;
                                         <span class="account_canceled">Urgent</span>&nbsp;
                                         <date>Oct 12,2021</date>
                                    </span>
                                </td>  
                                <td><a href="supportticket.html" class="reorder">
                                    <i class="arrow_right"></i>
                                </a></td>
                              </tr>
                            </tbody>
                          </table>
                    </div>
					
					<!-- /row -->
					<div class="pagination_fg greenpagination">
					  <a href="#" class="angleactive"><i class="arrow_carrot-left"></i></a>
					  <a href="#" class="active">1</a>
					  <a href="#">2</a>
					  <a href="#">3</a>
					  <a href="#">4</a>
					  <a href="#">5</a>
					  <a href="#"><i class="arrow_carrot-right"></i></a>
					</div>
				</div>
				<!-- /col -->
			</div>		
		</div>
		<!-- /container -->
		
	</main>


    <!-- SPECIFIC SCRIPTS -->
    <script src="<?= $root_url; ?>/website_assets/webAssets/js/sticky_sidebar.min.js"></script>
    <script src="<?= $root_url; ?>/website_assets/webAssets/js/specific_listing.js"></script>

<?php include 'footer.php'; ?>
