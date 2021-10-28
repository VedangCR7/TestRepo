<?php include 'header.php'; 



if(isset($_POST['name']) && isset($_POST['email'])){

     $id=$_POST['id'];
     $user_name=$_POST['name'];
     $user_email=$_POST['email'];
     $contact_number=$_POST['contact_number'];
     $city=$_POST['city'];
     $landmark=$_POST['landmark'];
     $postal_code=$_POST['postal_code'];
     $complete_address=$_POST['complete_address'];
     
   $sql="UPDATE `customer_address` SET `name`='$user_name',`email`='$user_email',`contact_number`='$contact_number',`city`='$city',`landmark`='$landmark',`postal_code`='$postal_code',`complete_address`='$complete_address' WHERE id=$id";


    $result = mysqli_query($conn, $sql);

    $error="Your Address has been Updated Successfully";

    echo '<script>window.location = "address.php?msg="+"updated"</script>';

 }




?>

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
				<aside class="col-lg-3 account-sidebarmain" id="sidebar_fixed">
                    <h6>Dashboard</h6>
                    <ul class="account-sidemenu mb-4"> 
                        <li>
                            <a href="account.php">
                                <i class="icon_bag_alt"></i>
                                Orders
                                <span>4</span>
                                
                            </a>
                        </li>
                        <li>
                            <a href="favourite.php">
                                <i class="icon_heart_alt"></i>
                                My Favourites
                                <span>4</span>
                                
                            </a>
                        </li>
                        <li>
                            <a href="support.php">
                                <i class="icon_headphones"></i>
                                Supports Tickets
                                <span>4</span>
                                
                            </a>
                        </li>
                    </ul>
                    <h6>Account Setting</h6>
                    <ul class="account-sidemenu"> 
                        <li>
                            <a href="profile.php">
                                <i class="icon_profile"></i>
                                Profile
                                <span>4</span>
                                
                            </a>
                        </li>
                        <li class="active">
                            <a href="address.php">
                                <i class="icon_pin_alt"></i>
                                Address
                                <span>4</span>
                                
                            </a>
                        </li>
                    </ul>
				</aside>
                 <?php 

              $address_id=$_GET['id'];

               $sql = "SELECT * FROM customer_address Where 
               id='$address_id'  ";

               $result = mysqli_query($conn, $sql);

               $userdata=mysqli_fetch_row($result);



                 ?>
				<div class="col-lg-9">
                    <div class="account_table mt-4">
                        <div class="row">
                            <div class="col-lg-6">
                                <h4 class="accounttable_heading mb-4"><i class="icon_pin_alt"></i> Edit address</h4>
                            </div>
                            <div class="col-lg-6">
                                <a href="address.php" class="goldenbtns float-right">Add new address</a>
                            </div>
                        </div>
                    </div>
                    <form utocomplete="off" action="<?php echo $_SERVER['PHP_SELF'] ?>"   method="POST">
                        
                    
                    <div class="main mt-5">
                        <div class="form-group">
                            <label>First Name and Last Name</label>
                            <input class="form-control" placeholder="" value="<?php echo  $userdata['2'] ?>" name="name" required="">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input class="form-control" placeholder="" value="<?php echo  $userdata['3'] ?>" name="email" required=""> 

                                    <input type="hidden" name="id" required="" value="<?php echo  $userdata['0'] ?>"> 
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input class="form-control" placeholder="" value="<?php echo  $userdata['4'] ?>" name="contact_number" required="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Full address</label>
                                    <input class="form-control" placeholder="" value="<?php echo  $userdata['9'] ?>" name="complete_address" required="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Landmark</label>
                                    <input class="form-control" placeholder="" value="<?php echo  $userdata['6'] ?>" name="landmark" required=""> 
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>City</label>
                                    <input class="form-control" placeholder="" value="<?php echo  $userdata['5'] ?>" name="city" required="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Postal Code</label>
                                    <input class="form-control" placeholder="" value="<?php echo  $userdata['7'] ?>" name=" postal_code" required=""> 
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="medium mt-4 btn_1 plus_icon">Save Changes</button>
                        </form>
                    </div>
				</div>
				<!-- /col -->
			</div>		
		</div>
		<!-- /container -->
		
	</main>


<?php include 'footer.php'; ?>
