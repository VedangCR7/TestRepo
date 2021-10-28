<?php
require_once('header_new.php');
require_once('sidebar.php');
?>
<div class=" app-content">
	<div class="side-app">

		<!--Page Header-->
		<div class="page-header">
			<h3 class="page-title"><i class="fe fe-home mr-1"></i> Dashboard </h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Dashboard </li>
			</ol>
		</div>
		<!--Page Header-->
		<div class="row">
			<div class="col-md-12 col-lg-12 col-xl-12">
				<div class="card">
					<div class="card-header">
						<h3>Table Management</h3>
					</div>
					<div class="card-body">
						<div class="row mb-0">
							<div class="col-md-4 col-sm-4 col-4 text-center">
								<p>All</p>
								<div class="dash3 mb-0">
									<div class="chart-circle  chart-circle-md mt-4 mt-sm-0 mb-0" data-value="0.63" data-thickness="6" data-color="green">
										<div class="chart-circle-value text-center "><?php print_r($total_table[0]['all_table']);?></div>
									</div>
								</div>
							</div>
							<div class="col-md-4 col-sm-4 col-4 text-center">
								<p>Available</p>
								<div class="dash3 mb-0">
									<div class="chart-circle  chart-circle-md mt-4 mt-sm-0 mb-0" data-value="0.63" data-thickness="6" data-color="#1B949D">
										<div class="chart-circle-value text-center "><?php print_r($available_table[0]['available_table']);?></div>
									</div>
								</div>
							</div>
							<div class="col-md-4 col-sm-4 col-4 text-center">
								<p>Occupied</p>
								<div class="dash3 mb-0">
									<div class="chart-circle  chart-circle-md mt-4 mt-sm-0 mb-0" data-value="0.63" data-thickness="6" data-color="Orange">
										<div class="chart-circle-value text-center "><?php print_r($occupied_table[0]['occupied_table']);?></div>
									</div>
								</div>
							</div>
						</div>
						<div class="row mb-0">
							<div class="col-lg-12 col-md-12 col-sm-12 col-12">
								<div class="row">
									<?php foreach ($show_table as $key => $value) {?>
									<div class="col-lg-1 col-md-1 col-sm-4 col-4 text-center" style="margin-top:10px;">
										<?php if ($value['is_available'] == 1) {
											?>
											<button class="btn btn-danger" style="background-image: linear-gradient(#10B653,#5FC387,#10B653);background-color:green;font-size:12px;width:100%;padding:15px;"><?=$value['title']?></button>
											<?php 
										} else{?>
											<button class="btn btn-danger" style="background-image: linear-gradient(#FF4F29,#FF6E4F,#FF4F29);background-color:#FF5733;font-size:12px;width:100%;padding:15px;"><?=$value['title']?></button>
										<?php } ?>
									</div>
								<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
							<div class="col-xl-3 col-md-6 ">
								<div class="card">
									<div class="card-body">
										<div class="float-right">
											<span class="mini-stat-icon bg-primary-transparent"><i class="si si-cloud-upload text-primary"></i></span>
										</div>
										<div class="dash3">
											<h5 style="color:#FF5733;font-weight:bold;">Total Sell &#8377;</h5>
											<h4 class="counter font-weight-extrabold num-font"><?=$total_sell[0]['total_sell']?></h4>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-3 col-md-6">
								<div class="card">
									<div class="card-body">
										<div class="float-right">
											<span class="mini-stat-icon bg-secondary-transparent"><i class="si si-share-alt text-secondary"></i></span>
										</div>
										<div class="dash3">
											<h5 class="text-muted" style="font-weight:bold;">Total Visitors</h5>
											<h4 class="counter num-font font-weight-extrabold"><?=$ttlvisited_users_count?></h4>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-3 col-md-6">
								<div class="card">
									<div class="card-body">
										<div class="float-right">
											<span class="mini-stat-icon bg-pink-transparent"><i class="si si-bubble text-pink"></i></span>
										</div>
										<div class="dash3">
											<h5 class="text-muted" style="font-weight:bold;">New Users</h5>
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
											<span class="mini-stat-icon bg-warning-transparent"><i class="si si-eye text-warning"></i></span>
										</div>
										<div class="dash3">
											<h5 class="text-muted" style="font-weight:bold;">Total Orders</h5>
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
										<h3 class="card-title" style="width:50%;">Monthly Earning</h3>
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
										<h3 class="card-title" style="width:50%;">Monthly Customer</h3>
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
										<h5 class="card-title m-b-0">Trending Orders</h5>
									</div>
									<div class="card-body">
										<div class="row">
											
											<?php foreach ($trending_offers as $key => $value) {?>
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
													<p style="font-weight:bold;color:green;">&#8377;<?=$value['price']?></p></div>
												</div>
												<div class="row">
													<div class="col-lg-6 col-md-6 col-sm-6 col-6">
														<p>Orders <span class="text-danger"><?=$value['recipe_count']?></span></p>
													</div>
													<div class="col-lg-6 col-md-6 col-sm-6 col-6 text-right">
														<p>Income <span class="text-danger">&#8377;<?=$value['income']?></span></p>
													</div>
												</div>
											</div></div></div><?php } ?>
										</div>
									</div>
								</div>
							</div>
			</div>

			<div class="row">
							<div class="col-xl-12 col-md-12 col-lg-12">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title" style="width:50%;">Recently Placed Orders</h3>
										<div style="width:50%;text-align:right;"><a href="<?=base_url('restaurant/orders')?>"><button class="btn btn-success btn-sm">View All</button></a></div>
									</div>
									<div class="table-responsive" style="padding:10px;">
										<table class="table card-table table-vcenter text-nowrap">
											<thead style="background-color:#FF4F29;color:white">
												<tr>
													<th>Order No</th>
													<th>Customer Name</th>
													<th>Table Number</th>
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
															$status_color="";
                    if($value['status']=="New"){
                        $status_color="badge-warning";
                    }
                    else if($value['status']=="Confirmed"){
                        $status_color="badge-black";
                        
                    }
                    else if($value['status']=="Blocked"){
                        $status_color="badge-orange";
                    }
                    else if($value['status']=="Food Served"){
                        $status_color="badge-indigo";
                    }
                    else if($value['status']=="Assigned To Kitchen"){
                        $status_color="badge-info";
                    }
                    else if($value['status']=="Canceled"){
                       $status_color="badge-danger";
                    }
                    else if($value['status']=="Completed"){
                        $status_color="badge-success";
                    }
														?>	
														<button class="btn btn-danger btn-sm <?=$status_color?>"><?=$value['status']?></button>
													</td>
													<td><?=$value['net_total']?></td>
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
										<h5 class="card-title m-b-0" style="width:50%">Recently added Menus</h5>
										<a href="<?=base_url('recipes/overview')?>" class="text-right" style="width:50%"><button class="btn btn-success btn-sm">View All</button></a>
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
										<h5 class="card-title m-b-0">Top 5 Most Visited Menus</h5>
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

                name: 'Earnings',

                data: result,
            }],
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug','sep','Oct','Nov','Dec'],
            },
            yaxis: {
                min: 0,
                max: 3000,
                title: {
                text: 'Earning in Rupess'
                }
            },
            fill: {
                opacity: 1

            },
			colors: ['#089e60'],
            tooltip: {
                y: {
                    formatter: function (val) {
                        return "&#8377;" + val
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
			colors: ['#1396cc'],
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

		

		<!-- <script src="<?=base_url()?>assets/js/index5.js"></script> -->
<?php require_once('footer.php');?>