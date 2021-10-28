<?php include 'header.php';

if($_SESSION['user_type']=="guest"){
    
    echo "<script>window.location.href = '$root_url';</script>";

}

?>

    <!-- SPECIFIC CSS -->
    <link href="<?= $root_url; ?>/website_assets/webAssets/css/listing.css" rel="stylesheet">

	<main>
		<div class="page_header element_to_stick">
		    <div class="container">
		    	<div class="row">
		    		<div class="col-xl-8 col-lg-7 col-md-7 d-none d-md-block">
		        		<h1>Top Restaurants Nearest You</h1>
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
					<!--<div class="row">
						<div class="col-12">
							<h2 class="title_small">Top Categories</h2>
							<div class="owl-carousel owl-theme categories_carousel_in listing">
								<div class="item">
									<figure>
										<img src="img/cat_listing_placeholder.png" data-src="img/cat_listing_1.jpg" alt="" class="owl-lazy"></a>
										<a href="#0"><h3>Pizza</h3></a>
									</figure>
								</div>
								<div class="item">
									<figure>
										<img src="img/cat_listing_placeholder.png" data-src="img/cat_listing_2.jpg" alt="" class="owl-lazy"></a>
										<a href="#0"><h3>Sushi</h3></a>
									</figure>
								</div>
								<div class="item">
									<figure>
										<img src="img/cat_listing_placeholder.png" data-src="img/cat_listing_3.jpg" alt="" class="owl-lazy"></a>
										<a href="#0"><h3>Dessert</h3></a>
									</figure>
								</div>
								<div class="item">
									<figure>
										<img src="img/cat_listing_placeholder.png" data-src="img/cat_listing_4.jpg" alt="" class="owl-lazy"></a>
										<a href="#0"><h3>Hamburgher</h3></a>
									</figure>
								</div>
								<div class="item">
									<figure>
										<img src="img/cat_listing_placeholder.png" data-src="img/cat_listing_5.jpg" alt="" class="owl-lazy"></a>
										<a href="#0"><h3>Ice Cream</h3></a>
									</figure>
								</div>
								<div class="item">
									<figure>
										<img src="img/cat_listing_placeholder.png" data-src="img/cat_listing_6.jpg" alt="" class="owl-lazy"></a>
										<a href="#0"><h3>Kebab</h3></a>
									</figure>
								</div>
								<div class="item">
									<figure>
										<img src="img/cat_listing_placeholder.png" data-src="img/cat_listing_7.jpg" alt="" class="owl-lazy"></a>
										<a href="#0"><h3>Italian</h3></a>
									</figure>
								</div>
								<div class="item">
									<figure>
										<img src="img/cat_listing_placeholder.png" data-src="img/cat_listing_8.jpg" alt="" class="owl-lazy"></a>
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

                    <div class="account_table mt-4">
                        <h4 class="accounttable_heading"><i class="icon_bag"></i> My Orders</h4>
                        <table class="table">
                            <thead>
                              <tr>
                                <th scope="col">Order #</th>
                                <th scope="col">Status</th>
                                <th scope="col">Date Purchased</th>
                                <th scope="col">Total</th>
                                <th scope="col"></th>
                              </tr>
                            </thead>
                            <tbody>
                            
                            <!--pagination code start-->
                            
                            <?php
                            
                            if (isset($_GET['pageno'])) {
                                $pageno = $_GET['pageno'];
                            } else {
                                $pageno = 1;
                            }
                            $no_of_records_per_page = 4;
                            $offset = ($pageno-1) * $no_of_records_per_page;
                            
                            // $conn=mysqli_connect("localhost","my_user","my_password","my_db");
                            // Check connection
                            if (mysqli_connect_errno()){
                                echo "Failed to connect to MySQL: " . mysqli_connect_error();
                                die();
                            }
                            
                            $customer_id = $_SESSION['user_id'];
                            
                            $total_pages_sql = "SELECT COUNT(*) FROM orders WHERE customer_id='$customer_id' ORDER BY id desc ";
                            $result = mysqli_query($conn,$total_pages_sql);
                            $total_rows = mysqli_fetch_array($result)[0];
                            $total_pages = ceil($total_rows / $no_of_records_per_page);
                            
                            $sql = "SELECT * FROM orders WHERE customer_id='$customer_id' ORDER BY id desc LIMIT $offset, $no_of_records_per_page";
                            $res_data = mysqli_query($conn,$sql);
                            while($order_Data = mysqli_fetch_array($res_data)){ ?>
                                <!--//here goes the data-->
                                <tr>
                                     <th scope="row"><a href="orderdetails.php?orderno=<?php echo $order_Data['order_no']; ?>&orderid=<?php echo $order_Data['id']; ?>"><?php echo $order_Data['order_no']; ?></a></th>
                                     <td><span class="account_pending"><?php echo $order_Data['status']; ?></span></td>
                                     <td><?php echo date("M d,Y", strtotime($order_Data['created_at'])); ?></td>
                                     <td><?php echo $order_Data['net_total']; ?></td>
                                     <td><a href="orderdetails.php" class="reorder">
                                         ReOrder <i class="arrow_right"></i>
                                     </a></td>
                                </tr>
                              
                            <?php } ?>
                            
                              
                            </tbody>
                          </table>
                    </div>
					
					<!-- /row -->
					<div class="pagination_fg greenpagination">
					  <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>" class="angleactive"><i class="arrow_carrot-left"></i></a>
					  <!--<a href="?pageno=1" class="active">1</a>-->
					  <?php 
					  
					  for($i=1;$i<=$total_pages;$i++){ ?>
					  
					    <a class="<?php if($_GET['pageno'] == $i){ echo 'active'; } ?>" href="?pageno=<?php echo $i; ?>"><?php echo $i; ?></a>
					  
					  <?php  } ?>
					  
					  <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>"><i class="arrow_carrot-right"></i></a>
					</div>
				</div>
				<!-- /col -->
			</div>		
		</div>
		<!-- /container -->
		
	</main>
	<!-- /main -->





<?php include 'footer.php'; ?>


<!-- SPECIFIC SCRIPTS -->
<script src="<?= $root_url; ?>/website_assets/webAssets/js/sticky_sidebar.min.js"></script>
<script src="<?= $root_url; ?>/website_assets/webAssets/js/specific_listing.js"></script>