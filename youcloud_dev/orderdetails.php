<?php include 'header.php'; ?>

<?php 

if(isset($_GET['orderno']) && isset($_GET['orderid'])){
    
    $orderno =  $_GET['orderno'];
    $orderid =  $_GET['orderid'];
    
    $sql = "SELECT * FROM order_items WHERE order_id='$orderid' ORDER BY id desc";
    $order_items_data = mysqli_query($conn,$sql);
    
    while($order_items_arr = mysqli_fetch_array($order_items_data)){
        
        
        $recipe_id = $order_items_arr['recipe_id'];
        
        if($recipe_id!==''){
            
            $recipes_sql = "SELECT * FROM recipes WHERE id='$recipe_id' ORDER BY id desc";
            $recipes_data = mysqli_query($conn,$recipes_sql);
            
            while($recipes_data_arr = mysqli_fetch_array($recipes_data)){  
             
       
            }
            
        }
        
        
  
    }
    
}


?>







<!-- SPECIFIC CSS -->
<link href="<?= $root_url; ?>/website_assets/webAssets/css/listing.css" rel="stylesheet">
	
 <!-- YOUR CUSTOM CSS -->
    <link href="css/custom.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/brands.min.css" integrity="sha512-lCU0XyQA8yobR7ychVxEOU5rcxs0+aYh/9gNDLaybsgW9hdrtqczjfKVNIS5doY0Y5627/+3UVuoGv7p8QsUFw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/fontawesome.min.css" integrity="sha512-Rcr1oG0XvqZI1yv1HIg9LgZVDEhf2AHjv+9AuD1JXWGLzlkoKDVvE925qySLcEywpMAYA/rkg296MkvqBF07Yw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/regular.min.css" integrity="sha512-lQP1BiSutAy+g9L+bDr1v9758SFLCJ1fK+6tXzu5M22G7/pigzb+01L31Cu1TUlWYr3lnQ4XQVmQfnpTZVW1Og==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/solid.min.css" integrity="sha512-WTx8wN/JUnDrE4DodmdFBCsy3fTGbjs8aYW9VDbW8Irldl56eMj8qUvI3qoZZs9o3o8qFxfGcyQocUY0LYZqzQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />


	
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
					<h4 class="accounttable_heading mb-5"><i class="icon_bag"></i>Orders Details</h4>
                    <ul class="account_order_process mt-5">
                        <li class="active">
                            <span>
                                <i class="icon_check"></i>
                                <i class="fas fa-box main_icon"></i>
                            </span>
                        </li>   
                        <li class="text-center">
                            <span>
                                <i class="fas fa-truck main_icon"></i>
                            </span>
                        </li>
                        <li class="text-right">
                            <span>
                                <i class="fas fa-clipboard-check main_icon"></i>
                            </span>
                        </li>
                    </ul>
                    <h6 class="transmitbnt mt-4 float-right mb-5">Your order status: <b>Transmit</b></h6>
                    
                    <?php 
                    if(isset($_GET['orderid'])){
                    
                        $orderid =  $_GET['orderid'];
                        $orderno =  $_GET['orderno'];


                        $sql = "SELECT * FROM order_items WHERE order_id='$orderid' ORDER BY id desc";
                        $order_items_data = mysqli_query($conn,$sql);
                        
                        $order_item_arr = mysqli_fetch_array($order_items_data);
                     
                    }    
                    
                    ?>
                    
                    <table class="orderdetails_table mt-5">
                        <thead>
                          <tr>
                            <th colspan="3" style="
                            width: 37%;
                        ">Order Id <span><?php if(!empty($orderno)){ echo $orderno; } ?></span></th>
                            <th colspan="3">Placed On <span><?php if(!empty($order_item_arr['created_at'])){ echo date("d M,Y", strtotime($order_item_arr['created_at'])); } ?></span></th>
                            <th colspan="3">Delivered On <span>8 Sep,2021</span></th>
                            <th>&nbsp</th>
                          </tr>
                        </thead>
                        <tbody>
                           
                    <?php 
                    
                    if(isset($_GET['orderno']) && isset($_GET['orderid'])){
                        
                        $orderno =  $_GET['orderno'];
                        $orderid =  $_GET['orderid'];
                        
                        $sql = "SELECT * FROM order_items WHERE order_id='$orderid' ORDER BY id desc";
                        $order_items_data = mysqli_query($conn,$sql);
                        
                        $customer_address_id = $order_items_arr['customer_address_id'];
                        
                        while($order_items_arr = mysqli_fetch_array($order_items_data)){
                            
                            
                            $recipe_id = $order_items_arr['recipe_id'];
                            
                            $customer_address_id = $order_items_arr['customer_address_id'];
                            
                            
                            if($recipe_id!==''){
                                
                                $recipes_sql = "SELECT * FROM recipes WHERE id='$recipe_id' ORDER BY id desc";
                                $recipes_data = mysqli_query($conn,$recipes_sql);
                                
                                while($recipes_data_arr = mysqli_fetch_array($recipes_data)){   ?>
                            
                          <tr>
                            <th scope="row"colspan="3">
                                <span class="d-flex accoun_orderlist">
                                    <span style="flex:1;">
                                        <img src="<?= $root_url; ?>/website_assets/webAssets/img/pizza_cat_listing.jpg"/>
                                    </span>
                                    <span style="flex:3;">
                                        <h6><?php if(isset($recipes_data_arr['name'])){ echo $recipes_data_arr['name']; }else{ echo "-"; } ?></h6>
                                        <p><?php if(isset($recipes_data_arr['price'])){ echo $recipes_data_arr['price']; }else{ echo "-"; } ?> x <?php if(isset($order_items_arr['qty'])){ echo $order_items_arr['qty']; }else{ echo "-"; } ?></p>
                                    </span>
                                </span>
                            </th>
                            <td colspan="3"><span class="accont_grey"><?php if(isset($recipes_data_arr['declaration_name'])){ echo $recipes_data_arr['declaration_name']; }else{ echo "-"; } ?></span></td>
                            <!--<td colspan="3"><a href="reviewforrestro.php" class="account_review">Write Review</a></td>-->
                            <td><a href="supportticket.php" class="account_support">Suport</a></td>
                          </tr>
                          
                        <?php }
                                    
                                }
                                
                                
                          
                            }
                            
                        }
                        
                        
                        ?>
                        </tbody>
                      </table>
                      <div class="row accont_address mt-5">
                        <div class="col-lg-7">
                            <div class="accont_addressinner">
                                <h6 class="accont_addresshead">Shipping Address</h6>
                                
                                <?php 
                                
                                if(isset($_GET['orderno']) && isset($_GET['orderid'])){
                                
                                    $orderno =  $_GET['orderno'];
                                    $orderid =  $_GET['orderid'];
                                    
                                    $sql = "SELECT * FROM `orders` WHERE id='$orderid'";
                                    $order_arr_query = mysqli_query($conn,$sql);
                                    
                                    $order_arr = mysqli_fetch_array($order_arr_query);

                                    $customer_address_id = $order_arr['customer_address_id'];
                                    
                                    
                                    $sql1 = "SELECT * FROM customer_address WHERE id='$customer_address_id'";
                                    
                                    $address_data = mysqli_query($conn,$sql1);
                                    
                                    $address_data_arr = mysqli_fetch_array($address_data);
                                    
                                    ?>
                                    
                                    <p><?php if(isset($address_data_arr['complete_address'])){ echo $address_data_arr['complete_address']; } ?></p>
                                
                                <?php  } ?>
                           
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="accont_addressinner">
                                <h6 class="accont_addresshead">Total Summary</h6>
                                <p class="mb-0 account_grey">Subtotal<span class="float-right"><?php if(!empty($order_item_arr['sub_total'])){ echo $order_item_arr['sub_total']; } ?></span></p>
                                <p class="mb-0 account_grey">Delivery fee<span class="float-right"><?php if(!empty($order_item_arr['delivery_fee'])){ echo $order_item_arr['delivery_fee']; } ?></span></p>
                                <p class="mb-3 account_grey">Discount<span class="float-right"><?php if(!empty($order_item_arr['disc_total'])){ echo $order_item_arr['disc_total']; } ?></span></p>
                                <h6 class="mb-3">Total <span class="float-right"><?php if(!empty($order_item_arr['sub_total'])){ echo $order_item_arr['sub_total']; } ?></span></h6>
                                <h5>Pay By Credit/Debit Card</h5>
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
