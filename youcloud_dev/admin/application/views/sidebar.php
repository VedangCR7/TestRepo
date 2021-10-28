<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
	<aside class="app-sidebar">
		<div class="app-sidebar__user">
			<!-- <div class="user-body">
				<span class="avatar avatar-lg brround text-center cover-image" data-image-src="<?=base_url();?>assets/images/users/5.jpg"></span>
			</div>
			<div class="user-info">
				<a href="#" class="ml-2"><span class="text-dark app-sidebar__user-name font-weight-semibold"><?=$_SESSION['name'];?></span><br>
					<span class="text-muted app-sidebar__user-name text-sm"><?=$_SESSION['usertype'];?></span>
				</a>
			</div> -->
		</div>
		<ul class="side-menu">
			<?php
				switch ($_SESSION['usertype']) {
					case 'Admin':
				?>
				<li>
					<a class="side-menu__item" href="<?=base_url()?>admin/"><i class="side-menu__icon si si-screen-desktop"></i><span class="side-menu__label">Dashboard</span></a>
				</li>
				<!--<li>
					<a class="side-menu__item" href="<?=base_url()?>admin/users"><i class="side-menu__icon si si-user"></i><span class="side-menu__label">Users</span></a>
				</li>-->
				<li class="slide">
						<a class="side-menu__item" data-toggle="slide" href="#"><i class="side-menu__icon si si-bag"></i><span class="side-menu__label">Accounts<i class="angle fas fa-angle-right"></i></a>
						<ul class="slide-menu">
							<li>
								<a class="slide-item" href="<?=base_url()?>admin/new_registration">New Registration</a>
							</li>
							<li>
								<a class="slide-item" href="<?=base_url()?>admin/all_restaurants">Restaurant</a>
							</li>
						</ul>
					</li>
				<!--<li>
					<a class="side-menu__item" href="<?=base_url()?>admin/recipes"><i class="side-menu__icon fas fa-utensils"></i><span class="side-menu__label">Menu</span></a>
				</li>-->
				<!-- <li>
					<a class="side-menu__item" href="<?=base_url()?>Newmaster1/"><i class="side-menu__icon fas fa-table"></i><span class="side-menu__label">Menu Management</span></a>
				</li> -->
				<!--<li>
					<a class="side-menu__item" href="<?=base_url()?>admin/menufor_restaurant"><i class="side-menu__icon fas fa-utensils"></i><span class="side-menu__label">Menu for Restaurant's</span></a>
				</li>-->
				
				<?php
					break;
					case 'Restaurant':
					if(!empty($restaurantsidebarshow)){
					$restaurant_sidebar = explode(',',$restaurantsidebarshow[0]['menu_name']);
					//print_r($menus);
					//if (in_array('Profile',$restaurant_sidebar)) {
				?>
					<!-- <li>
						<a class="side-menu__item" href="<?=base_url();?>profile"><i class="side-menu__icon fe fe-user"></i><span class="side-menu__label">Profile</span></a>
					</li> -->
				<?php //} 
				if (in_array('Dashboard',$restaurant_sidebar)) {?>
					<li>
						<a class="side-menu__item" href="<?=base_url()?>restaurant/dashboard/all"><i class="side-menu__icon si si-screen-desktop"></i><span class="side-menu__label">Dashboard</span></a>
					</li>
					<!-- <li>
						<a class="side-menu__item" href="<?=base_url()?>restaurant/newdashboard"><i class="side-menu__icon si si-screen-desktop"></i><span class="side-menu__label">New Dashboard</span></a>
					</li> -->
				<?php } if (in_array('Menu',$restaurant_sidebar)) { ?>
					<li class="slide">
						<a class="side-menu__item" data-toggle="slide" href="#"><i class="side-menu__icon fas fa-utensils"></i><span class="side-menu__label">Menu<i class="angle fas fa-angle-right"></i></a>
						<ul class="slide-menu">
							<li><a class="slide-item" href="<?=base_url()?>MenuMasterCreate/menuMaster">Menu Master</a></li>
						<!-- 	<li><a class="slide-item" href="<?=base_url()?>recipes/addrecipe/1">Create New</a></li> -->
							<li>
								<a class="slide-item" href="<?=base_url()?>restaurant/menu_group"><!-- <i class="side-menu__icon fas fa-receipt"></i><span class="side-menu__label"> --> Menu Group<!-- </span> --></a>
							</li>
							<li><a class="slide-item" href="<?=base_url()?>recipes/overview">Menus</a></li>
							<li><a class="slide-item" href="<?=base_url()?>restaurant/add_on">Add-On Categories</a></li>
							<!-- <li><a class="slide-item" href="<?=base_url()?>recipes/barmenus">Bar menu</a></li> -->
							<li>
								<a class="slide-item" href="<?=base_url()?>tspecial/menufor_restaurant"><!-- <i class="side-menu__icon fas fa-heart"></i><span class="side-menu__label"> -->Today's Special<!-- </span> --></a>
							</li>
							<!-- <li><a class="slide-item" href="<?=base_url()?>restaurant/menufor_restaurant">Menu From FoodNAI</a></li> -->
						</ul>
					</li>
				<?php } if (in_array('Table Management',$restaurant_sidebar)) { ?>
					<li class="slide">
						<a class="side-menu__item" data-toggle="slide" href="#"><i class="side-menu__icon fas fa-table"></i><span class="side-menu__label">Table Management<i class="angle fas fa-angle-right"></i></a>
						<ul class="slide-menu">
						 	<li><a class="slide-item" href="<?=base_url()?>Table/create_category">Table Category</a></li>
							<li><a class="slide-item" href="<?=base_url()?>Table/create_tbl">Table Creation</a></li>
							<li><a class="slide-item" href="<?=base_url()?>restaurant/show_assign_table">User Assign tables</a></li>
						</ul>
					</li>
				<?php } if (in_array('Order',$restaurant_sidebar)) { ?>
					<li class="slide">
						<a class="side-menu__item" href="<?=base_url()?>restaurant/orders"><i class="side-menu__icon si si-bag"></i><span class="side-menu__label">Table Orders <span class=" badge badge-warning  badge-pill new-order new-order-count1">0</span></a>
						<!--<ul class="slide-menu">
							<li>
								<a class="slide-item" href="<?=base_url()?>restaurant/onlineorders">Order</a>
								
							</li>
							<li>
								<a class="slide-item" href="<?=base_url()?>restaurant/orders">Dashboard</a>
							</li>
						</ul>-->
					</li>
				<?php }
				if (in_array('Online order',$restaurant_sidebar)) { ?>
					<li>
					<a class="side-menu__item" href="<?=base_url()?>restaurant/weborders"><i class="side-menu__icon si si-bag"></i><span class="side-menu__label">Online Orders <span class=" badge badge-warning  badge-pill new-order new-order-count2">0</span></a>
				
					</li>
				<?php }		
				 if (in_array('Billing',$restaurant_sidebar)) { ?>
					<li>
						<a class="side-menu__item" href="<?=base_url()?>restaurant/new_order"><i class="side-menu__icon si si-calculator"></i><span class="side-menu__label">Counter</span></a>
					</li>
				<?php } if (in_array('invoice',$restaurant_sidebar)) { ?>
					<li>
						<a class="side-menu__item" href="<?=base_url()?>restaurant/invoice"><i class="side-menu__icon si si-printer"></i><span class="side-menu__label">Invoice</span></a>
					</li>
				<?php } if (in_array('Offers',$restaurant_sidebar)) { ?>
					<li>
						<a class="side-menu__item" href="<?=base_url()?>restaurantoffer/offer"><i class="side-menu__icon si si-energy"></i><span class="side-menu__label">Offer</span></a>
					</li>
					<?php } if (in_array('User Management',$restaurant_sidebar)) {  ?>

					<li class="slide">
						<a class="side-menu__item" data-toggle="slide" href="#"><i class="side-menu__icon fas fa-user-friends"></i><span class="side-menu__label">User Management<i class="angle fas fa-angle-right"></i></a>
						<ul class="slide-menu">
							<?php if (in_array('Restaurant Manager',$restaurant_sidebar)) {  ?>
						 	<li><a class="slide-item" href="<?=base_url()?>Restaurant_manager/restaurant_list_manager">Restaurant Manager</a></li>
						 	<?php } if (in_array('Waitinglist Manager',$restaurant_sidebar)) {  ?>
							<li><a class="slide-item" href="<?=base_url()?>Waiting_manager/waiting_list_manager">Waitinglist Manager</a></li>
							<?php } if (in_array('Whatsapp Manager',$restaurant_sidebar)) {  ?>
							<li><a class="slide-item" href="<?=base_url()?>whatsapp_manager/whatsapp_manager">Whatsapp Manager</a></li><?php } ?>
							<li><a class="slide-item" href="<?=base_url()?>waiter/waiter_list">Waiter</a></li>
							<!-- added by victor for delivery maangement -->
							<li><a class="slide-item" href="<?=base_url()?>delivery/">Delivery</a></li>
							<!-- code ends here -->
						</ul>
					</li>
				<?php } if (in_array('Customer',$restaurant_sidebar)) {  ?>
					<li>
						<a class="side-menu__item" href="<?=base_url()?>restaurant/customers"><i class="side-menu__icon si si-people"></i><span class="side-menu__label">Customers</span></a>
					</li>
				<?php } if (in_array('Waitinglist',$restaurant_sidebar)) { ?>

					<li class="slide">
						<a class="side-menu__item" data-toggle="slide" href="#"><i class="side-menu__icon fas fa-user-clock"></i><span class="side-menu__label">Waitinglist<i class="angle fas fa-angle-right"></i></a>
						<ul class="slide-menu">
							<li><a class="slide-item" href="<?=base_url()?>Waiting_manager/restaurant_waiting_dashboard">Dashboard</a></li>
						 	<li><a class="slide-item" href="<?=base_url()?>Waiting_manager/show_assign_cust">Waitinglist customer</a></li>
							<!-- <li><a class="slide-item" href="<?=base_url()?>Waiting_manager/show_decline_cust">Decline</a></li> -->
						</ul>
					</li>

				<?php }if (in_array('Reports',$restaurant_sidebar)) { ?>
					<li class="slide">
						<a class="side-menu__item" data-toggle="slide" href="#"><i class="side-menu__icon fas fa-file"></i><span class="side-menu__label">Reports<i class="angle fas fa-angle-right"></i></a>
						<ul class="slide-menu">
							<li><a class="slide-item" href="<?=base_url()?>reports/order_summary">Order Summary</a></li>
							<li><a class="slide-item" href="<?=base_url()?>reports/customer_report">Customer</a></li>
							<li><a class="slide-item" href="<?=base_url()?>reports/revenue_report">Revenue</a></li>
							<li><a class="slide-item" href="<?=base_url()?>reports/selling_item_report">Most Selling Menu Items</a></li>
							<li><a class="slide-item" href="<?=base_url()?>reports/takeaway_order_summary">Takeaway Order Summary</a></li>
							<li><a class="slide-item" href="<?=base_url()?>reports/payment_summary">Payment Summary</a></li>
							<li><a class="slide-item" href="<?=base_url()?>reports/group_wise_report">Menu Group Wise Report</a></li>
							<li><a class="slide-item" href="<?=base_url()?>reports/price_change_sales_report">Price Sales Report</a></li>
						</ul>
					</li>
				<?php } if (in_array('Incentive',$restaurant_sidebar)) { ?>
					<li class="slide">
						<a class="side-menu__item" data-toggle="slide" href="#"><i class="side-menu__icon fas fa-table"></i><span class="side-menu__label">Incentive Management<i class="angle fas fa-angle-right"></i></a>
						<ul class="slide-menu">
						 	<li><a class="slide-item" href="<?=base_url()?>Emp_category_master/index">Category Master</a></li>
							 <li><a class="slide-item" href="<?=base_url()?>Employee_master_controller/index">Employee Master</a></li>
							 <li><a class="slide-item" href="<?=base_url()?>Manage_Incentive_master_controller/index">Manage Incentive Master</a></li>
							 <li><a class="slide-item" href="<?=base_url()?>Incentive_report_controller/index">Employee Incentive Report</a></li>
							<!-- <li><a class="slide-item" href="<?=base_url()?>Table/create_tbl">Table Creation</a></li> -->
						</ul>
					</li>
				<?php } if (in_array('Payment',$restaurant_sidebar)) { ?>
					<!-- <li>
						<a class="side-menu__item" href="<?=base_url()?>recipes/overview"><i class="side-menu__icon fas fa-utensils"></i><span class="side-menu__label">Menu</span></a>
					</li> -->
					<li>
						<a class="side-menu__item" href="<?=base_url()?>payment"><i class="side-menu__icon fas fa-receipt"></i><span class="side-menu__label">Payment</span></a>
					</li>
					
				<?php }  if (in_array('Inventory Management',$restaurant_sidebar)) { ?>

					<li class="slide">
						<a class="side-menu__item" data-toggle="slide" href="#"><i class="side-menu__icon fas fa-user-clock"></i><span class="side-menu__label">Inventory Management<i class="angle fas fa-angle-right"></i></a>
						<ul class="slide-menu">
							<li><a class="slide-item" href="<?=base_url()?>inventory/add_product">Add Product</a></li>
		 					<li><a class="slide-item" href="<?=base_url()?>inventory/product_list">Product List</a></li>
							<li><a class="slide-item" href="<?=base_url()?>inventory/create_supplier">Create Supplier</a></li>
							<li><a class="slide-item" href="<?=base_url()?>inventory/supplier_list">Supplier List</a></li>
							<li><a class="slide-item" href="<?=base_url()?>inventory/purchase_create">Purchase Create</a></li>
							<li><a class="slide-item" href="<?=base_url()?>inventory/purchase_list">Purchase List</a></li>
							<li><a class="slide-item" href="<?=base_url()?>inventory/payment_create">Payment Create</a></li>
							<li><a class="slide-item" href="<?=base_url()?>inventory/payment_list">Payment List</a></li>
							<li><a class="slide-item" href="<?=base_url()?>inventory/product_assign_kitchen">Assign Products</a></li>
							<li><a class="slide-item" href="<?=base_url()?>inventory/product_assign_kitchen_list">Product Assign to Kitchen</a></li>
							<!-- <li><a class="slide-item" href="<?=base_url()?>Waiting_manager/show_decline_cust">Decline</a></li> -->
						</ul>
					</li>
					<?php }
					if (in_array('Help',$restaurant_sidebar)) { ?>
					<li>
						<a class="side-menu__item" href="<?=base_url()?>help"><i class="side-menu__icon fas fa-info-circle"></i><span class="side-menu__label">Help</span></a>
					</li>

					<?php }
					if (in_array('Inventory Report',$restaurant_sidebar)) { ?>
					<li class="slide">
						<a class="side-menu__item" data-toggle="slide" href="#"><i class="side-menu__icon fas fa-user-clock"></i><span class="side-menu__label">Inventory Report<i class="angle fas fa-angle-right"></i></a>
						<ul class="slide-menu">
							<li><a class="slide-item" href="<?=base_url()?>inventory/product_report">Product Report</a></li>
							<li><a class="slide-item" href="<?=base_url()?>inventory/purchase_report">Purchase Report</a></li>
							<li><a class="slide-item" href="<?=base_url()?>inventory/supplier_report">Supplier Report</a></li>
							<li><a class="slide-item" href="<?=base_url()?>inventory/stock_list_report">Stock List</a></li>
						</ul>
					</li>
					<?php }
					}
					break;
					case 'Whatsapp manager':
                    ?>
                    <li>
                        <a class="side-menu__item" href="<?=base_url();?>profile"><i class="side-menu__icon fe fe-user"></i><span class="side-menu__label">Profile</span></a>
                    </li>
                    <!-- <li>
                        <a class="side-menu__item" href="<?=base_url()?>Whatsapp_manager/dashboard"><i class="side-menu__icon si si-screen-desktop"></i><span class="side-menu__label">Message</span></a>
                    </li> -->

                    <li>
                        <a class="side-menu__item" href="<?=base_url('Whatsapp_manager/whatsapp_message/')?>"><i class="side-menu__icon si si-speech"></i><span class="side-menu__label">Message</span></a>
                    </li>

                    <li>
						<a class="side-menu__item" href="<?=base_url()?>whatsapp_manager/customers"><i class="side-menu__icon si si-people"></i><span class="side-menu__label">Customers</span></a>
					</li>
                    <?php 
                    break;
					case 'Burger and Sandwich':
				?>
					<li>
						<a class="side-menu__item" href="<?=base_url();?>profile"><i class="side-menu__icon fe fe-user"></i><span class="side-menu__label">Profile</span></a>
					</li>
					<li>
						<a class="side-menu__item" href="<?=base_url()?>restaurant/dashboard"><i class="side-menu__icon si si-screen-desktop"></i><span class="side-menu__label">Dashboard</span></a>
					</li>
					<li>
						<a class="side-menu__item" href="<?=base_url()?>restaurant/menu_group"><i class="side-menu__icon fas fa-receipt"></i><span class="side-menu__label">View Menu Group</span></a>
					</li>
					<li class="slide">
						<a class="side-menu__item" data-toggle="slide" href="#"><i class="side-menu__icon fas fa-utensils"></i><span class="side-menu__label">Menu<i class="angle fas fa-angle-right"></i></a>
						<ul class="slide-menu">
							<li><a class="slide-item" href="<?=base_url()?>recipes/addrecipe/1">Create New</a></li>
							<li><a class="slide-item" href="<?=base_url()?>recipes/overview">All Recipe</a></li>
						</ul>
					</li>
					<!-- <li>
						<a class="side-menu__item" href="<?=base_url()?>recipes/overview"><i class="side-menu__icon fas fa-utensils"></i><span class="side-menu__label">Menu</span></a>
					</li> -->
					<li>
						<a class="side-menu__item" href="<?=base_url()?>payment"><i class="side-menu__icon fas fa-receipt"></i><span class="side-menu__label">Payment</span></a>
					</li>
					<li>
						<a class="side-menu__item" href="<?=base_url()?>help"><i class="side-menu__icon fas fa-info-circle"></i><span class="side-menu__label">Help</span></a>
					</li>
					
					
				<?php
					break;
					case 'Individual User':
				?>
					<li>
						<a class="side-menu__item" href="<?=base_url();?>profile"><i class="side-menu__icon fe fe-user"></i><span class="side-menu__label">Profile</span></a>
					</li>
					<!-- <li>
						<a class="side-menu__item" href="<?=base_url()?>user/dashboard"><i class="side-menu__icon si si-screen-desktop"></i><span class="side-menu__label">Dashboard</span></a>
					</li> -->
					<li>
						<a class="side-menu__item" href="<?=base_url()?>user/menu_group"><i class="side-menu__icon fas fa-receipt"></i><span class="side-menu__label">View Menu Group</span></a>
					</li>
					<li class="slide">
						<a class="side-menu__item" data-toggle="slide" href="#"><i class="side-menu__icon fas fa-utensils"></i><span class="side-menu__label">Menu<i class="angle fas fa-angle-right"></i></a>
						<ul class="slide-menu">
							<li><a class="slide-item" href="<?=base_url()?>recipes/addrecipe/1">Create New</a></li>
							<li><a class="slide-item" href="<?=base_url()?>recipes/overview">All Recipe</a></li>
						</ul>
					</li>
					<!-- <li>
						<a class="side-menu__item" href="<?=base_url()?>recipes/overview"><i class="side-menu__icon fas fa-utensils"></i><span class="side-menu__label">Menu</span></a>
					</li> -->
					<li>
						<a class="side-menu__item" href="<?=base_url()?>payment"><i class="side-menu__icon fas fa-receipt"></i><span class="side-menu__label">Payment</span></a>
					</li>
					<li>
						<a class="side-menu__item" href="<?=base_url()?>help"><i class="side-menu__icon fas fa-info-circle"></i><span class="side-menu__label">Help</span></a>
					</li>
				<?php
					break;
					case 'Restaurant chain':
				?>
					<li>
						<a class="side-menu__item" href="<?=base_url();?>profile"><i class="side-menu__icon fe fe-user"></i><span class="side-menu__label">Profile</span></a>
					</li>
					<li>
						<a class="side-menu__item" href="<?=base_url()?>company/dashboard"><i class="side-menu__icon si si-screen-desktop"></i><span class="side-menu__label">Dashboard</span></a>
					</li>
					<li>
						<a class="side-menu__item" href="<?=base_url()?>company/menu_group"><i class="side-menu__icon fas fa-receipt"></i><span class="side-menu__label">View Menu Group</span></a>
					</li>
					<li class="slide">
						<a class="side-menu__item" data-toggle="slide" href="#"><i class="side-menu__icon fas fa-utensils"></i><span class="side-menu__label">Menu<i class="angle fas fa-angle-right"></i></a>
						<ul class="slide-menu">
							<li><a class="slide-item" href="<?=base_url()?>recipes/addrecipe/1">Create New</a></li>
							<li><a class="slide-item" href="<?=base_url()?>recipes/overview">All Recipe</a></li>
						</ul>
					</li>
					<!-- <li>
						<a class="side-menu__item" href="<?=base_url()?>recipes/overview"><i class="side-menu__icon fas fa-utensils"></i><span class="side-menu__label">Menu</span></a>
					</li> -->
					<li>
						<a class="side-menu__item" href="<?=base_url()?>company/users"><i class="side-menu__icon fas fa-user"></i><span class="side-menu__label">Users</span></a>
					</li>
					<li>
						<a class="side-menu__item" href="<?=base_url()?>payment"><i class="side-menu__icon fas fa-receipt"></i><span class="side-menu__label">Payment</span></a>
					</li>
					<li>
						<a class="side-menu__item" href="<?=base_url()?>help"><i class="side-menu__icon fas fa-info-circle"></i><span class="side-menu__label">Help</span></a>
					</li>
				<?php
					break;
					case 'School':
				?>
					<li>
						<a class="side-menu__item" href="<?=base_url();?>profile"><i class="side-menu__icon fe fe-user"></i><span class="side-menu__label">Profile</span></a>
					</li>
					<li>
						<a class="side-menu__item" href="<?=base_url()?>school/dashboard"><i class="side-menu__icon si si-screen-desktop"></i><span class="side-menu__label">Dashboard</span></a>
					</li>
					<li>
						<a class="side-menu__item" href="<?=base_url()?>school/menu_group"><i class="side-menu__icon fas fa-receipt"></i><span class="side-menu__label">View Menu Group</span></a>
					</li>
					<li class="slide">
						<a class="side-menu__item" data-toggle="slide" href="#"><i class="side-menu__icon fas fa-utensils"></i><span class="side-menu__label">Menu<i class="angle fas fa-angle-right"></i></a>
						<ul class="slide-menu">
							<li><a class="slide-item" href="<?=base_url()?>recipes/addrecipe/1">Create New</a></li>
							<li><a class="slide-item" href="<?=base_url()?>recipes/overview">All Recipe</a></li>
						</ul>
					</li>
					<!-- <li>
						<a class="side-menu__item" href="<?=base_url()?>recipes/overview"><i class="side-menu__icon fas fa-utensils"></i><span class="side-menu__label">Menu</span></a>
					</li> -->
					<li>
						<a class="side-menu__item" href="<?=base_url()?>school/calendar"><i class="side-menu__icon fas fa-calendar"></i><span class="side-menu__label">Calendar</span></a>
					</li>
					<li>
						<a class="side-menu__item" href="<?=base_url()?>payment"><i class="side-menu__icon fas fa-receipt"></i><span class="side-menu__label">Payment</span></a>
					</li>
					<li>
						<a class="side-menu__item" href="<?=base_url()?>help"><i class="side-menu__icon fas fa-info-circle"></i><span class="side-menu__label">Help</span></a>
					</li>
				<?php
					break;
					case 'Waitinglist manager':
					?>
					<li>
						<a class="side-menu__item" href="<?=base_url();?>profile"><i class="side-menu__icon fe fe-user"></i><span class="side-menu__label">Profile</span></a>
					</li>
					<li>
						<a class="side-menu__item" href="<?=base_url()?>Waiting_manager/dashboard"><i class="side-menu__icon si si-screen-desktop"></i><span class="side-menu__label">Dashboard</span></a>
					</li>

					<li>
						<a class="side-menu__item" href="<?=base_url('Waiting_manager/todays_customer/')?>"><i class="side-menu__icon si si-user"></i><span class="side-menu__label">Today's Waitinglist</span></a>
					</li>

					<?php 
					break;
					case 'Restaurant manager':

					?>


					<li>
						<a class="side-menu__item" href="<?=base_url();?>profile"><i class="side-menu__icon fe fe-user"></i><span class="side-menu__label">Profile</span></a>
					</li>
					<li>
						<a class="side-menu__item" href="<?=base_url()?>Restaurant_manager/dashboard"><i class="side-menu__icon si si-screen-desktop"></i><span class="side-menu__label">Dashboard</span></a>
					</li>
					<li>
						<a class="side-menu__item" href="<?=base_url()?>Waiting_manager/menu_group"><i class="side-menu__icon fas fa-receipt"></i><span class="side-menu__label">View Menu Group</span></a>
					</li>
					<li class="slide">
						<a class="side-menu__item" data-toggle="slide" href="#"><i class="side-menu__icon fas fa-utensils"></i><span class="side-menu__label">Menu<i class="angle fas fa-angle-right"></i></a>
						<ul class="slide-menu">
							<li><a class="slide-item" href="<?=base_url()?>recipes/addrecipe/1">Create New</a></li>
							<li><a class="slide-item" href="<?=base_url()?>recipes/overview">All Recipe</a></li>
						</ul>
					</li>
					<!-- <li>
						<a class="side-menu__item" href="<?=base_url()?>recipes/overview"><i class="side-menu__icon fas fa-utensils"></i><span class="side-menu__label">Menu</span></a>
					</li> -->
					<li>
						<a class="side-menu__item" href="<?=base_url()?>school/calendar"><i class="side-menu__icon fas fa-calendar"></i><span class="side-menu__label">Calendar</span></a>
					</li>
					<li>
						<a class="side-menu__item" href="<?=base_url()?>payment"><i class="side-menu__icon fas fa-receipt"></i><span class="side-menu__label">Payment</span></a>
					</li>
					<li>
						<a class="side-menu__item" href="<?=base_url()?>help"><i class="side-menu__icon fas fa-info-circle"></i><span class="side-menu__label">Help</span></a>
					</li>
					<?php
					break;
					default:
						# code...d
					break;
				}
			?>
			
			
		</ul>
	</aside>