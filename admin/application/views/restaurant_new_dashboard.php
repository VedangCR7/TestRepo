<?php
	require_once('header.php');
	require_once('sidebar.php');

	if($_SESSION['language'] == 'Greek')
	{
		$translation = ['title'=>'Ταμπλό','home'=>'Αρχικη','tbl_mngment'=>'Διαχείρηση Τραπεζιών','all'=>'Όλα','available'=>'Διαθέσιμα','occupied'=>'Κατειλημμένα','total_sell'=>'Σύνολο Πωλήσεων','total_visitors'=>'Συνολικοί Επισκέπτες','new_users'=>'Νέοι Χρήστες','total_orders'=>'Συνολικές Παραγγελίες','monthly_earning'=>'Μηνιαία Κέρδη','monthly_cust'=>'Μηνιαίοι Πελάτες','trending_orders'=>'Δημοφιλείς Παραγγελίες','recent_orders'=>'Πρόσφατες Παραγγελίες','orders'=>'παραγγελίες','income'=>'Εισόδημα','view_all'=>'Δες τα όλα','order_no'=>'ΑΡΙΘΜΌΣ ΠΑΡΑΓΓΕΛΊΑΣ','customer_name'=>'ΌΝΟΜΑ ΠΕΛΆΤΗ','table_number'=>'ΑΡΙΘΜΌΣ ΤΡΑΠΕΖΙΟΎ','status'=>'ΚΑΤΆΣΤΑΣΗ ΠΑΡΑΓΓΕΛΊΑΣ','price'=>'ΤΙΜΉ','date'=>'ΗΜΕΡΟΜΗΝΊΑ','recently_added_menu'=>'Πρόσφατα μενού','top_five_menu'=>'Τα 5 Πιο Δημοφιλή Μενού'];
	}
	else
	{
		$translation = ['title'=>'Order Dashboard','home'=>'Home','tbl_mngment'=>'Table Management','all'=>'All','available'=>'Available','occupied'=>'Occupied','total_sell'=>'Total Sell','total_visitors'=>'Total Visitors','new_users'=>'New Users','total_orders'=>'Total Orders','monthly_earning'=>'Monthly Earning','monthly_cust'=>'Monthly Customer','trending_orders'=>'Trending Orders','recent_orders'=>'Recent Orders','orders'=>'Orders','income'=>'Income','view_all'=>'View All','order_no'=>'Order No','customer_name'=>'Customer Name','table_number'=>'Table Number','status'=>'status','price'=>'Price','date'=>'Date','recently_added_menu'=>'Recently added Menus','top_five_menu'=>'Top 5 Most Visited Menus'];
	}

	if(!empty($restaurantsidebarshow))
	{
		$restaurant_authority = explode(',',$restaurantsidebarshow[0]['menu_name']);
	}
?>
<div class=" app-content">
	<div class="side-app">
		<!--Page Header-->
		<div class="page-header">
			<h3 class="page-title"><i class="fe fe-home mr-1"></i> <?=$translation['title']?> </h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#"><?=$translation['home']?></a></li>
				<li class="breadcrumb-item active" aria-current="page"><?=$translation['title']?> </li>
			</ol>
		</div>
		<!--Page Header-->
		<div class="row">
			<div class="col-md-12 col-lg-12 col-xl-12">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title" ><?=$translation['tbl_mngment']?></h3>
					</div>
					<div class="card-body">
						<?php
						if (!in_array('Billing',$restaurant_authority)) 
						{
						?>
						<div class="row mb-0">
							<div class="col-md-3 col-sm-3 col-3 text-center">
								<p><?=$translation['all']?></p>
								<div class="dash3 mb-0">
									<div class="chart-circle  chart-circle-md mt-4 mt-sm-0 mb-0" data-value="1" data-thickness="6" data-color="green">
										<div class="chart-circle-value text-center "><?php print_r($total_table[0]['all_table']);?></div>
									</div>
								</div>
							</div>
							<div class="col-md-3 col-sm-3 col-3 text-center">
								<p><?=$translation['available']?></p>
								<div class="dash3 mb-0">
									<div class="chart-circle  chart-circle-md mt-4 mt-sm-0 mb-0" data-value="1" data-thickness="6" data-color="#1B949D">
										<div class="chart-circle-value text-center "><?php print_r($available_table[0]['available_table']);?></div>
									</div>
								</div>
							</div>
							<div class="col-md-3 col-sm-3 col-3 text-center">
								<p><?=$translation['occupied']?></p>
								<div class="dash3 mb-0">
									<div class="chart-circle  chart-circle-md mt-4 mt-sm-0 mb-0" data-value="1" data-thickness="6" data-color="gray">
										<div class="chart-circle-value text-center "><?php print_r($occupied_table['occupied_table']);?></div>
									</div>
								</div>
							</div>
							<div class="col-md-3 col-sm-3 col-3 text-center">
								<p>Table Order</p>
								<div class="dash3 mb-0">
									<div class="chart-circle  chart-circle-md mt-4 mt-sm-0 mb-0" data-value="1" data-thickness="6" data-color="orange">
										<div class="chart-circle-value text-center "><?php print_r($occupied_table1['occupied_table']);?></div>
									</div>
								</div>
							</div>
						</div>
						<?php
						}
						else
						{
						?>
						<div class="row mb-0">
							<div class="col-md-3 col-sm-3 col-3 text-center">
								<p><?=$translation['all']?></p>
								<div class="dash3 mb-0">
									<div class="chart-circle  chart-circle-md mt-4 mt-sm-0 mb-0" data-value="1" data-thickness="6" data-color="green" onclick="load_table_data('all');">
										<div class="chart-circle-value text-center "><?php print_r($total_table[0]['all_table']);?></div>
									</div>
								</div>
							</div>
							<div class="col-md-3 col-sm-3 col-3 text-center">
								<p><?=$translation['available']?></p>
								<div class="dash3 mb-0">
									<div class="chart-circle  chart-circle-md mt-4 mt-sm-0 mb-0" data-value="1" data-thickness="6" data-color="#1B949D" onclick="load_table_data('available');">
										<div class="chart-circle-value text-center "><?php print_r($available_table[0]['available_table']);?></div>
									</div>
								</div>
							</div>
							<div class="col-md-3 col-sm-3 col-3 text-center">
								<p><?=$translation['occupied']?></p>
								<div class="dash3 mb-0">
									<div class="chart-circle  chart-circle-md mt-4 mt-sm-0 mb-0" data-value="1" data-thickness="6" data-color="gray" onclick="load_table_data('occupied');">
										<div class="chart-circle-value text-center "><?php print_r($occupied_table['occupied_table']);?></div>
									</div>
								</div>
							</div>
							<div class="col-md-3 col-sm-3 col-3 text-center">
								<p>Table Order</p>
								<div class="dash3 mb-0">
									<div class="chart-circle  chart-circle-md mt-4 mt-sm-0 mb-0" data-value="1" data-thickness="6" data-color="orange" onclick="load_table_data('online');">
										<div class="chart-circle-value text-center "><?php print_r($occupied_table1['occupied_table']);?></div>
									</div>
								</div>
							</div>
						</div>
						<div class="row mb-0">
							<div class="col-lg-12 col-md-12 col-sm-12 col-12">
								<div class="row">
									<?php 
									if(!empty($show_table))
									{
									foreach ($show_table as $key => $value) 
									{
										if ($value['is_available'] == 1)
										{
										?>
											<div class="col-lg-1 table-billing-div col-md-2 col-sm-4 text-center bg-primary m-1">
												<a href="<?=base_url()?>restaurant/tablerecipe/<?=$value['id']?>" class="table-title  mt-3 mb-3 p-3"><?=$value['title']?></a>
											</div>
										<?php
										}
										else
										{
											if($value['table_order'])
											{
												$table_order=$value['table_order'];
												/* var_dump($table_order);exit; */
												$timeelapsed = $table_order['order']['in_time'];
												$timesplit = explode(':',$timeelapsed);
												
												/* if($timesplit[0] != 00)
												{
													$time_ago = $timesplit[0].' hours ago';
												}
												else if($timesplit[0] == 00 && $timesplit[1] != 00)
												{
													$time_ago = $timesplit[1].' Minuites ago';
												}
												else if($timesplit[0] == 00 && $timesplit[1] == 00)
												{
													$time_ago = $timesplit[2].' Seconds ago';
												} */
												
												$order_date = $value["table_order"]["order"]['created_at'];
												$current_date = date('Y-m-d H:i:s');

												$date = new DateTime($order_date);
												$date2 = new DateTime($current_date);

												$seconds = $date2->getTimestamp() - $date->getTimestamp();
												
												if($seconds < 60)
												{
													$time = $seconds % 60;
													$time_ago = $time.' seconds ago';
												}
												else if($seconds >= 60 && $seconds < 3600)
												{
													$time = floor(($seconds / 60) % 60);
													$time_ago = $time.' minutes ago';
												}
												else if($seconds >= 3600)
												{
													$time = floor($seconds / 3600);
													$time_ago = $time.' hours ago';
												}
												
												if($value['table_order']['order_type']=="Billing")
												{
												?>
													<div class="col-lg-1 table-billing-div col-md-2 col-sm-4 text-center bg-gray m-1" >
														<a href="<?=base_url()?>restaurant/tablerecipe/<?=$value['id']?>/<?=$table_order['id']?>" data-id="<?=$value['id']?>" class="table-title view_order mt-3 mb-3 p-3"><?=$value['title']?></a>
													</div>
												<?php
												}
												else
												{
													$sub_total = $value["table_order"]["order"]["sub_total"];
													$dis_total_percentage = $value["table_order"]["order"]['dis_total_percentage'];
													$disc_percentage_total = $value["table_order"]["order"]['disc_percentage_total'];
													
													if($disc_percentage_total >0)
													{
														$cgst_total = number_format(($value['table_order']['order']['sub_total']*$value['table_order']['order']['cgst_per'])/100,2);
														$sgst_total = number_format(($value['table_order']['order']['sub_total']*$value['table_order']['order']['sgst_per'])/100,2);
														$nettotal = number_format($value['table_order']['order']['net_total'],2);
													}
													else
													{
														$cgst_total = number_format(($value['table_order']['order']['sub_total']*$value['table_order']['order']['cgst_per'])/100,2);
														$sgst_total = number_format(($value['table_order']['order']['sub_total']*$value['table_order']['order']['sgst_per'])/100,2);
														$nettotal = number_format($value['table_order']['order']['sub_total']+$cgst_total+$sgst_total,2);
													}
												?>
													<div class="col-lg-1 table-billing-div col-md-2 col-sm-4 text-center bg-orange m-1" >
														<a data-id="<?=$value['id']?>" class="table-title view_order mt-1 mb-3"><?=$value['title']?><h6><?=$currency_symbol[0]['currency_symbol']?> <?=$nettotal;?></h6> <p><?=$time_ago?></p></a>
														<?php	
														if($table_order['order']['invoice_id']!="" && $table_order['order']['invoice_id']!=null)
														{
														?>
														<a href="<?=base_url()?>restaurant/onlineorder/<?=$value['id']?>/<?=$table_order['id']?>" table-order-id="<?=$table_order['id']?>" data-id="<?=$value['title']?>" class="btn btn-sm btn-primary mr-1 btn-view-tableorder"  style="position:absolute;left:8px;bottom:0px;color:white;border-radius:50%;padding: 1px 4px;"><i class="fas fa-eye"></i></a>
														<a href="<?=base_url()?>restaurant/printbill/<?=$table_order['order']['invoice_id']?>" table-order-id="<?=$table_order['id']?>" data-id="<?=$value['id']?>" class="btn btn-sm btn-info print_bill_for_table mr-1"  style="position:absolute;right:5px;bottom:0px;color:white;border-radius:50%;padding: 1px 5px;" target="_blank"><i class="fas fa-print"></i></a>
														<?php
														}
														else
														{
														?>
														<a href="<?=base_url()?>restaurant/onlineorder/<?=$value['id']?>/<?=$table_order['id']?>" table-order-id="<?=$value['id']?>" data-id="<?=$value['id']?>" class="btn btn-sm btn-outline-primary btn-view-tableorder mr-1"  style="position:absolute;left:35%;bottom:0px;color:white;border-radius:50%;padding: 1px 4px;"><i class="fas fa-eye"></i></a>
														<?php
														}
														?>
													</div>
												<?php
												}
											}
											else
											{
											?>
												<div class="col-lg-1 table-billing-div col-md-2 col-sm-4 text-center bg-gray m-1" >
													<a href="<?=base_url()?>restaurant/tablerecipe/<?=$value['id']?>/<?=$value['tableId']?>" data-id="<?=$value['id']?>" class="table-title view_order mt-3 mb-3 p-3"><?=$value['title']?></a>
												</div>
											<?php
											}
										}
									}
									}
									else
									{
										echo '<h1 style="padding: 20px;">Table are not available...!!</h1>';
									}
									?>
								</div>
							</div>
						</div>
						<?php
						}
						?>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
							<div class="col-xl-3 col-md-6 ">
								<div class="card">
									<div class="card-body">
										<div class="float-right">
											<span class="mini-stat-icon bg-totalsell-transparent"><i class="si si-cloud-upload text-totalsell"></i></span>
										</div>
										<div class="dash3">
											<h5 style="color:#FF5733;font-weight:bold;"><?=$translation['total_sell']?> <?=$currency_symbol[0]['currency_symbol']?></h5>
											<h4 class="counter font-weight-extrabold num-font"><?=$total_sell[0]['total_sell']?></h4>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-3 col-md-6">
								<div class="card">
									<div class="card-body">
										<div class="float-right">
											<span class="mini-stat-icon bg-totalvisitor-transparent"><i class="si si-share-alt text-totalvisitor"></i></span>
										</div>
										<div class="dash3">
											<h5 class="text-muted" style="font-weight:bold;"><?=$translation['total_visitors']?></h5>
											<?php if ($ttlvisited_users_count == '') { ?>
												<h4 class="counter num-font font-weight-extrabold">0</h4>
											<?php } else{?>
											<h4 class="counter num-font font-weight-extrabold"><?=$ttlvisited_users_count?></h4>
										<?php } ?>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-3 col-md-6">
								<div class="card">
									<div class="card-body">
										<div class="float-right">
											<span class="mini-stat-icon bg-newuser-transparent"><i class="si si-bubble text-newuser"></i></span>
										</div>
										<div class="dash3">
											<h5 class="text-muted" style="font-weight:bold;"><?=$translation['new_users']?></h5>
											<?php if ($visited_users_count == '') { ?>
												<h4 class="counter num-font font-weight-extrabold">0</h4>
											<?php } else{?>
											<h4 class="counter num-font font-weight-extrabold"><?=$visited_users_count?></h4>
										<?php } ?>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-3 col-md-6">
								<div class="card">
									<div class="card-body">
										<div class="float-right">
											<span class="mini-stat-icon bg-totalorder-transparent"><i class="si si-eye text-totalorder"></i></span>
										</div>
										<div class="dash3">
											<h5 class="text-muted" style="font-weight:bold;"><?=$translation['total_orders']?></h5>
											<h4 class="counter num-font font-weight-extrabold"><?=$total_orders[0]['total_orders']?></h4>
										</div>
									</div>
								</div>
							</div>
						</div>

			<!-- <div class="row">
				<div class="col-xl-6 col-lg-12">
								<div class="card">
									<div class="card-header">
										<h5 class="card-title m-b-0" style="width:50%">Recently added Menus</h5>
										<a href="<?=base_url('recipes/overview')?>" class="text-right" style="width:50%"><button class="btn btn-success btn-sm">View All</button></a>
									</div>
									<div class="list-group list-group-flush ">
										<?php foreach ($recipes as $key => $value) {?>
										<div class="list-group-item d-flex  align-items-center">
											<div class="mr-2">
												<?php if ($value['recipe_image'] == 'assets/images/users/menu.png') { ?>
													<span class="avatar avatar-md brround cover-image" data-image-src="<?=base_url('assets/images/users/menu.png')?>"></span>
												<?php } else { ?>
												<span class="avatar avatar-md brround cover-image" data-image-src="<?=$value['recipe_image']?>"></span>
											<?php } ?>
											</div>
											<div class="">
												<div class="font-weight-semibold"><?=$value['name']?></div>
												<small class="text-muted"><?= $value['recipe_type'] ?>
												</small>
											</div>
											<div class="ml-auto">
												<a href="#" class="" data-toggle="tooltip" title=""><?=date('Y-M-d',strtotime($value['recipe_date']))?></a>
											</div>
										</div><?php } ?>

									</div>
								</div>
							</div>
							<div class="col-md-6 col-xl-6 col-lg-6">
								<div class="card">
									<div class="card-header">
										<h4 class="card-title">Monthly Revenue</h4>
										<div class="card-options ">
											<span class="dropdown-toggle fs-16" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"><i class="fe fe-more-vertical " ></i></span>
											<ul class="dropdown-menu dropdown-menu-right" role="menu">
												<li><a href="#"><i class="si si-plus mr-2"></i>Add</a></li>
												<li><a href="#"><i class="si si-trash mr-2"></i>Remove</a></li>
												<li><a href="#"><i class="si si-eye mr-2"></i>View</a></li>
												<li><a href="#"><i class="si si-settings mr-2"></i>More</a></li>
											</ul>
										</div>
									</div>
									<div class="card-body">
										<div class="mb-4" style="margin-top:10px;">
											<p class="mb-3">Week1<span class="float-right text-muted">80%</span></p>
											<div class="progress h-1">
											    <div class="progress-bar bg-primary w-80 " role="progressbar"></div>
											</div>
										</div>
										<div class="mb-4" style="margin-top:10px;">
											<p class="mb-3">Week2<span class="float-right text-muted">70%</span></p>
											<div class="progress h-1">
											    <div class="progress-bar bg-secondary w-50" role="progressbar"></div>
											</div>
										</div>
										<div class="mb-4" style="margin-top:10px;">
											<p class="mb-3">Week3<span class="float-right text-muted">40%</span></p>
											<div class="progress h-1">
											    <div class="progress-bar bg-pink w-40" role="progressbar"></div>
											</div>
										</div>
										<div class="mb-4" style="margin-top:10px;">
											<p class="mb-3">Week4<span class="float-right text-muted">60%</span></p>
											<div class="progress h-1">
											    <div class="progress-bar bg-warning w-60" role="progressbar"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
			</div> -->
			<div class="row">
				<div class="col-md-12 col-xl-6 col-lg-6">
								<div class="card overflow-hidden">
									<div class="card-header">
										<h3 class="card-title" style="width:50%;"><?=$translation['monthly_earning']?></h3>
										<div class="text-right" style="width:50%">
											<?php $year = date("Y"); ?>
											<select id="select_year" class="form-control">
												<?php for ($i=$year; $i >=2020 ; $i--) { 
													?><option><?=$i?></option><?php
												} ?>
												
												<!-- <option>2021</option>
												<option>2020</option>
												<option>2019</option> -->
											</select>
										</div>
									</div>
									<div class="card-body">
										<div id="social" class="overflow-hidden chart-dropshadow"></div>
									</div>
								</div>
							</div>
							<div class="col-md-12 col-xl-6 col-lg-6">
								<div class="card overflow-hidden">
									<div class="card-header">
										<h3 class="card-title" style="width:50%;"><?=$translation['monthly_cust']?></h3>
										<div class="text-right" style="width:50%">
											<select id="select_year_cust" class="form-control">
												<?php for ($i=$year; $i >=2020 ; $i--) { 
													?><option><?=$i?></option><?php
												} ?>
											</select>
										</div>
									</div>
									<div class="card-body">
										<div id="social1" class="overflow-hidden chart-dropshadow"></div>
									</div>
								</div>
							</div>
			</div>

			<div class="row">
				<div class="col-xl-12 col-lg-12">
								<div class="card">
									<div class="card-header">
										<div class="col-lg-6 col-md-6 col-sm-12 col-12">
												<h5 class="card-title m-b-0"><?=$translation['trending_orders']?></h5>
											</div>
											<div class="col-lg-6 col-md-6 col-sm-12 col-12 text-right">
												<select class="form-control" id="trending_order_filter">
													<option value="Monthly">Monthly</option>
													<option value="Weekly">Weekly</option>
												</select>
											</div>
									</div>
									<div class="card-body">
										<div class="row" id="all_trending_order_shows">
											
											<?php if(!empty($trending_offers)){ foreach ($trending_offers as $key => $value) {?>
											<div class="col-lg-3 col-md-3 col-sm-12 col-12" style="padding:20px;">
												<div class="row">
												<div class="col-lg-12 col-md-12 col-sm-12 col-12 shadow-sm mb-4 bg-white" style="border-radius:10px;">
												<div class="row">
													<div class="col-lg-12 col-md-12 col-sm-12 col-12">
														<?php if ($value['recipe_image'] == 'assets/images/users/menu.png') {
															?>
															<img src="<?=base_url('assets/images/users/menu.png')?>" width="100%" height="150px">
															<?php
														} else{?>
															<img src="<?=$value['recipe_image']?>" width="100%" height="150px">
														<?php } ?>
													</div>
												</div>
												<div class="row">
													<div class="col-lg-6 col-md-6 col-sm-6 col-6" style="margin-top:10px;">
													<p style="font-weight:bold;font-size:10px;"><?=$value['name']?></p></div>
													<div class="col-lg-6 col-md-6 col-sm-6 col-6 text-right" style="margin-top:10px;">
													<p style="font-weight:bold;color:green;"><?=$currency_symbol[0]['currency_symbol']?><?=$value['price']?></p></div>
												</div>
												<div class="row">
													<div class="col-lg-6 col-md-6 col-sm-6 col-6">
														<p><?=$translation['orders']?> <span class="text-danger"><?=$value['recipe_count']?></span></p>
													</div>
													<div class="col-lg-6 col-md-6 col-sm-6 col-6 text-right">
														<p><?=$translation['income']?> <br><span class="text-danger"><?=$currency_symbol[0]['currency_symbol']?><?=$value['income']?></span></p>
													</div>
												</div>
											</div></div></div><?php } } ?>
										</div>
									</div>
								</div>
							</div>
			</div>

			<div class="row">
							<div class="col-xl-12 col-md-12 col-lg-12">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title" style="width:50%;"><?=$translation['recent_orders']?></h3>
										<div style="width:50%;text-align:right;"><a href="<?=base_url('restaurant/orders')?>"><button class="btn btn-success btn-sm"><?=$translation['view_all']?></button></a></div>
									</div>
									<div class="table-responsive" style="padding:10px;">
										<table class="table card-table table-vcenter text-nowrap">
											<thead style="background-color:#1B949D;color:white">
												<tr>
													<th>Order No</th>
													<th>Customer Name</th>
													<th>Order From</th>
													<th>Order By</th>
													<th>Status</th>
													<th>Price</th>
													<th>Date</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($five_order as $key => $value) {?>
												<tr>
													<td><?=$value['order_no']?></td>
													<td><?=$value['name']?></td>
													<td><?=$value['title']?></td>
													<td>
														<?php
														$orderby = $value['order_by'];
														
														if($orderby > 0)
														{
															if($value['order_type']=="Billing")
															{
																echo 'Counter';
															}
															else if($value['order_type']=="Takeaway")
															{
																echo 'Counter';
															}
															else
															{
																echo $value['order_by_name'];
															}
														}
														else
														{
															if($value['order_type']=="Billing")
															{
																echo 'Counter';
															}
															else if($value['order_type']=="Takeaway")
															{
																echo 'Counter';
															}
															else
															{
																echo 'Customer';
															}
														}
														?>
													</td>
													<td>
														<?php 
														$status_color="";
														
														if($value['status']=="New")
														{
															$status_color="badge-warning";
														}
														else if($value['status']=="Confirmed")
														{
															$status_color="badge-black";															
														}
														else if($value['status']=="Blocked")
														{
															$status_color="badge-orange";
														}
														else if($value['status']=="Food Served")
														{
															$status_color="badge-indigo";
														}
														else if($value['status']=="Assigned To Kitchen")
														{
															$status_color="badge-info";
														}
														else if($value['status']=="Canceled")
														{
														   $status_color="badge-danger";
														}
														else if($value['status']=="Completed")
														{
															$status_color="badge-success";
														}
														?>
														<?php  
														if($value['order_type']=="Billing")
														{
															if($value['is_invoiced']=='1')
															{
															?>
															<a href="<?=base_url()?>restaurant/tablerecipe/<?=$value['table_id']?>/<?=$value['id']?>/<?=$value['invoice_id']?>">
																<button class="btn btn-danger btn-sm <?=$status_color?>"><?=$value['status']?></button>
															</a>
															<?php
															}
															else
															{
															?>
																	<a href="<?=base_url()?>restaurant/tablerecipe/<?=$value['table_id']?>/<?=$value['id']?>">	
																		<button class="btn btn-danger btn-sm <?=$status_color?>"><?=$value['status']?></button>
																	</a>
															<?php
															}
														}
														else if($value['order_type']=="Online")
														{
															if($value['is_invoiced']=='1')
															{
															?>
															<!--<a href="<?=base_url()?>restaurant/onlineorder/<?=$value['table_id']?>/<?=$value['id']?>">	
																<button class="btn btn-danger btn-sm <?=$status_color?>"><?=$value['status']?></button>
															</a>-->															
															<a href="<?=base_url()?>restaurant/onlineorder/<?=$value['table_id']?>/<?=$value['id']?>/<?=$value['invoice_id']?>/tableorders">
																<button class="btn btn-danger btn-sm <?=$status_color?>"><?=$value['status']?></button>
															</a>
															<?php
															}
															else
															{?>
															<a href="<?=base_url()?>restaurant/onlineorder/<?=$value['table_id']?>/<?=$value['id']?>/tableorders">	
																<button class="btn btn-danger btn-sm <?=$status_color?>"><?=$value['status']?></button>
															</a>
															<?php 
															}
														} 
														else if($value['order_type']=="Website")
														{
															if($value['is_invoiced']=='1')
															{
															?>
															<a href="<?=base_url()?>restaurant/onlineorder/<?=$value['table_id']?>/<?=$value['id']?>/<?=$value['invoice_id']?>/tableorders">
																<button class="btn btn-danger btn-sm <?=$status_color?>"><?=$value['status']?></button>
															</a>
															<?php
															}
															else
															{
															?>
															<a href="<?=base_url()?>restaurant/onlineorder/<?=$value['table_id']?>/<?=$value['id']?>/tableorders">	
																<button class="btn btn-danger btn-sm <?=$status_color?>"><?=$value['status']?></button>
															</a>
															<?php 
															}
														}
														else if($value['order_type']=="Takeaway")
														{
															if($value['is_invoiced']=='1')
															{
															?>
															<a href="<?=base_url()?>restaurant/tablerecipe/<?=$value['table_id']?>/<?=$value['id']?>/<?=$value['invoice_id']?>">
																<button class="btn btn-danger btn-sm <?=$status_color?>"><?=$value['status']?></button>
															</a>
															<?php
															}
															else
															{
															?>
															<a href="<?=base_url()?>restaurant/tablerecipe/<?=$value['table_id']?>/<?=$value['id']?>">	
																<button class="btn btn-danger btn-sm <?=$status_color?>"><?=$value['status']?></button>
															</a>
															<?php 
															}
														}
														?>
													</td>
													
													<?php if($value['supply_option']=="Delivery")
														{ $price = $value['net_total'] + $delivery_fee[0]['delivery_fee'];
														}else {
															$price = $value['net_total'];
														}
														//echo "<pre>";
														//print_r($value);
														?>
													<td><?=number_format((float)$price, 2, '.', '');?></td>
													<td><?=date('d M Y h:i A',strtotime($value['created_at']))?></td>
												</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
				<div class="col-xl-6 col-lg-12">
								<div class="card">
									<div class="card-header">
										<h5 class="card-title m-b-0" style="width:50%"><?=$translation['recently_added_menu']?></h5>
										<a href="<?=base_url('recipes/overview')?>" class="text-right" style="width:50%"><button class="btn btn-success btn-sm"><?=$translation['view_all']?></button></a>
									</div>
									<div class="list-group list-group-flush ">
										<?php $i=1; foreach ($recently_added as $key => $value) {?>
										<div class="list-group-item d-flex  align-items-center">
											<div class="mr-2">
												<?php if ($value['recipe_image'] == 'assets/images/users/menu.png') { ?>
													<span class="avatar avatar-md brround cover-image" data-image-src="<?=base_url('assets/images/users/menu.png')?>"></span>
												<?php } else { ?>
												<span class="avatar avatar-md brround cover-image" data-image-src="<?=$value['recipe_image']?>"></span>
											<?php } ?>
											</div>
											<div class="">
												<div class="font-weight-semibold"><?=$value['name']?></div>
												<small class="text-muted"><?= $value['recipe_type'] ?>
												</small>
											</div>
											<div class="ml-auto">
												<a href="#" class="" data-toggle="tooltip" title=""><?=date('d M Y',strtotime($value['recipe_date']))?></a>
											</div>
										</div><?php if($i>=5)
									break;
								$i++; } ?>

									</div>
								</div>
							</div>
							<div class="col-md-6 col-xl-6 col-lg-6">
								<div class="card">
									<div class="card-header">
										<h5 class="card-title m-b-0"><?=$translation['top_five_menu']?></h5>
									</div>
									<div class="list-group list-group-flush ">
										<?php $i=1; foreach ($visited_recipes as $key => $value) {?>
										<div class="list-group-item d-flex  align-items-center">
											<div class="mr-2">
												<?php if ($value['recipe_image'] == 'assets/images/users/menu.png') { ?>
													<span class="avatar avatar-md brround cover-image" data-image-src="<?=base_url('assets/images/users/menu.png')?>"></span>
												<?php } else { ?>
												<span class="avatar avatar-md brround cover-image" data-image-src="<?=$value['recipe_image']?>"></span>
											<?php } ?>
											</div>
											<div class="">
												<div class="font-weight-semibold"><?=$value['name']?></div>
												<small class="text-muted"><?= $value['recipe_type'] ?>
												</small>
											</div>
											<div class="ml-auto">
												<a href="#" class="" data-toggle="tooltip" title=""><?=date('d M Y',strtotime($value['recipe_date']))?></a>
											</div>
										</div><?php if($i>=5)
									break;
								$i++; } ?>

									</div>
								</div>
							</div>
			</div>
		<script type="text/javascript">
			$(document).ready(function(){
				yearlyearning($('#select_year').val());
				yearlycust($('#select_year_cust').val());
				$('#select_year').change(function(){
					yearlyearning($('#select_year').val());
				});
				$('#select_year_cust').change(function(){
					yearlycust($('#select_year_cust').val());
				});
				function yearlyearning(year){
					$('#social').html('');
				$.ajax({
            		url: "<?=base_url()?>"+"Restaurant/monthly_erning",
            		type:'POST',
            		data:{year:year} ,
            		success: function(result){
            			//console.log(result);
						var len = result.length;
  						var max = -Infinity;
  						while (len--) {
    					if (result[len] > max) {
      						max = result[len];
    					}
  						}
						console.log(max);
            			var options = {
            chart: {
                height: 325,
                type: 'bar',
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '70%',
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            series: [{

                name: 'Earnings',

                data: result,
            }],
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug','sep','Oct','Nov','Dec'],
            },
            yaxis: {
                min: 0,
                max: max,
                title: {
                text: 'Earnings'
                }
            },
            fill: {
                opacity: 1

            },
			colors: ['#00B050'],
            tooltip: {
                y: {
                    formatter: function (val) {
                        return "<?=$currency_symbol[0]['currency_symbol']?>" + val
                    }
                }
            }
        }

        var chart = new ApexCharts(
            document.querySelector("#social"),
            options
        );

        chart.render();

            		}
        		});
			}


			function yearlycust(year){
				$('#social1').html('');
				$.ajax({
            		url: "<?=base_url()?>"+"Restaurant/monthly_cust",
            		type:'POST',
            		data:{year:year} ,
            		success: function(result){
            			console.log(result);
            			var options = {
            chart: {
                height: 325,
                type: 'bar',
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '70%',
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            series: [{

                name: 'Customers',

                data: result,
            }],
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug','sep','Oct','Nov','Dec'],
            },
            yaxis: {
                min: 0,
                max: 300,
            },
            fill: {
                opacity: 1

            },
			colors: ['#FFC000'],
            tooltip: {
                y: {
                    formatter: function (val) {
                        return  val
                    }
                }
            }
        }

        var chart = new ApexCharts(
            document.querySelector("#social1"),
            options
        );

        chart.render();

            		}
        		});
			}
			});
		</script>

		<!-- ApexChart -->
		<script src="<?=base_url()?>assets/js/apexcharts.js"></script>
		<script>
			function load_table_data(tableType)
			{
				location.href ="<?=base_url()?>restaurant/dashboard/"+tableType;
			}
		</script>
		
		<script>
			$('#trending_order_filter').change(function(){
				$.ajax({
            				url: "<?=base_url()?>Restaurant/trending_offer_show_dashboard",
            				type:'POST',
            				data:{filter_date:$('#trending_order_filter').val()} ,
					dataType:'JSON',
            				success: function(result){
						console.log(result);
						var html='';
						all_orders = result.trending_order;
						for(var i=0;i<all_orders.length;i++){
						html+='<div class="col-lg-3 col-md-3 col-sm-12 col-12" style="padding:20px;">\
												<div class="row">\
												<div class="col-lg-12 col-md-12 col-sm-12 col-12 shadow-sm mb-4 bg-white" style="border-radius:10px;">\
												<div class="row">\
													<div class="col-lg-12 col-md-12 col-sm-12 col-12">';
														if (all_orders[i]['recipe_image'] == 'assets/images/users/menu.png') {
														
															html+='<img src="<?=base_url('assets/images/users/menu.png')?>" width="100%" height="150px">';
															
														}else{
															html+='<img src="'+all_orders[i]['recipe_image']+'" width="100%" height="150px">';
														}
													html+='</div>\
												</div>\
												<div class="row">\
													<div class="col-lg-6 col-md-6 col-sm-6 col-6" style="margin-top:10px;">\
													<p style="font-weight:bold;font-size:10px;">'+all_orders[i]['name']+'</p></div>\
													<div class="col-lg-6 col-md-6 col-sm-6 col-6 text-right" style="margin-top:10px;">\
													<p style="font-weight:bold;color:green;">'+all_orders[i]['price']+'</p></div>\
												</div>\
												<div class="row">\
													<div class="col-lg-6 col-md-6 col-sm-6 col-6">\
														<p>Orders <span class="text-danger">'+all_orders[i]['recipe_count']+'</span></p>\
													</div>\
													<div class="col-lg-6 col-md-6 col-sm-6 col-6 text-right">\
														<p>Income <br><span class="text-danger">'+result.currency_symbol[0]['currency_symbol']+' '+all_orders[i]['income']+'</span></p>\
													</div>\
												</div>\
											</div></div></div>';
						}
						$('#all_trending_order_shows').html(html);
					}
						
				});
			});
		</script>
	
				   

		<!-- <script src="<?=base_url()?>assets/js/index5.js"></script> -->
<?php require_once('footer.php');?>