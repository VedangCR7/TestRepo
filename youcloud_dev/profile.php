<?php include 'header.php';



$login_id = $_SESSION['user_id'];

$query = "SELECT * from customer where id='$login_id'";

$mysql=mysqli_query($conn,$query);

$userdata=mysqli_fetch_assoc($mysql);

 ?>

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
                <div class="account_table mt-4">
                    <div style="background-color: floralwhite;text-align: center;margin-bottom: 10px;">
                        <?php if(isset($_GET['msg']) && $_GET['msg']=='scs'){ ?>

                            <span style="color:green;"><b>
                                Profile updated successfully.</b>
                            </span>

                        <?php } ?>

                        <?php if(isset($_GET['msg']) && $_GET['msg']=='failed'){ ?>

                            <span style="color:red;"><b>
                                Oops! Profile Not Updated...</b>
                            </span>

                        <?php } ?>

                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <h4 class="accounttable_heading mb-4"><i class="icon_profile"></i> My Profile <?php echo $successMessge; ?> </h4>
                        </div>
                        <div class="col-lg-6">
                            <a href="editprofile.php" class="goldenbtns float-right">Edit Profile</a>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-lg-4">
                            <ul class="d-flex account-username">
                                <li style="flex:1;">
                                    <img src="<?= $root_url; ?>/website_assets/uploads/<?php echo $userdata['profile_image']; ?>"/>
                                </li>
                                <li style="flex:3;">
                                    <h6><?php if(isset($userdata['name'])){ echo $userdata['name']; } ?></h6>
                                    <p>Username: <?php if(isset($userdata['name'])){ echo $userdata['name']; } ?></p>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-3">
                            <div class="user-membership">
                                <h6>Silver User</h6>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="user-orders">
                                <h6><?php                                 
                                $customer_id = $_SESSION['user_id'];
                               
                                $order_selectSQL = "SELECT * FROM orders WHERE customer_id='$customer_id'";
                                
                                $order_DataArr = mysqli_query($conn, $order_selectSQL);
                                
                                echo $order_DataArr->num_rows;
                                
                                ?></h6>
                                <p>All Orders</p>
                            </div>
                        </div>
                    </div>
                    <div class="row userdetailsintab mt-5">
                        <div class="col-lg-2">
                            <p>First Name</p>
                            <h6><?php if(isset($userdata['name'])){ echo $userdata['name']; } ?></h6>
                        </div>
                        <!--<div class="col-lg-2">-->
                        <!--    <p>Last Name</p>-->
                        <!--    <h6><?php if(isset($userdata['l_name'])){ echo $userdata['l_name']; } ?></h6>-->
                        <!--</div>-->
                        <div class="col-lg-3">
                            <p>Email</p>
                            <h6><?php if(isset($userdata['email'])){ echo $userdata['email']; } ?></h6>
                        </div>
                        <div class="col-lg-3">
                            <p>Phone</p>
                            <h6><?php if(isset($userdata['contact_no'])){ echo $userdata['contact_no']; } ?></h6>
                        </div>
                        <div class="col-lg-2">
                            <p>Birth Date</p>
                            <h6><?php if(isset($userdata['birth_date'])){ echo date('d, M-Y',strtotime($userdata['birth_date'])); } ?></h6>
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