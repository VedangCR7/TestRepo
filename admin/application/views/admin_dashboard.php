<?php
require_once('header.php');
require_once('sidebar.php');
  ?>
  <link rel="stylesheet" href="<?=base_url('assets/carousel/')?>style.css" />
  <script src="<?=base_url('assets/carousel/')?>jquery.flickgal.js"></script>
  <style>
    body { background: #fafafa; font-family: 'Roboto Condensed'; }
  </style>
  <script>
    $(function() {
      var $message = $('.message');

      $('.yourFlickgalWrap').flickGal({
        'infinitCarousel': true
      })
        .on('fg_flickstart', function(e, index) {
          $message.html('The event <b>fg_flickstart</b> is dispatched.');
        })
        .on('fg_flickend', function(e, index) {
          $message.html('The event <b>fg_flickend</b> is dispatched.');
        })
        .on('fg_change', function(e, index) {
          $message.html('The event <b>fg_change</b> is dispatched.');
        });
    });
  </script>
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
			<div class="col-xl-4 col-lg-4 col-md-12">
				<div class="card">
					<div class="card-body">
						<div class="row mb-3">
							<div class="col">
								<h6 class="text-muted mb-0 mt-1">Total Restaurants</h6>
							</div>
							<div class="col col-auto">
								<a class="btn btn-sm btn-white border" href="<?=base_url()?>admin/restaurants">View Details</a>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<div class="dash-2">
									<h2 class="mb-2"><span class="counter font-weight-extrabold num-font">
										<?php echo $ttlrestocount; ?>
									</span></h2>
								</div>
							</div>
							<div class="col col-auto">
								<span class="sparkline_bar1"></span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-4 col-lg-4 col-md-12">
				<div class="card">
					<div class="card-body">
						<div class="row mb-3">
							<div class="col">
								<h6 class="text-muted mb-0 mt-1">Total Revenue</h6>
							</div>
							<div class="col col-auto">
								<a class="btn btn-sm btn-white border" href="<?=base_url()?>admin/revenue">View Details</a>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<div class="dash-2">
									<h2 class="mb-2"><span class="counter font-weight-extrabold num-font">
										<?php echo $ttlrevenueocount[0]->net_total; ?>
									</span></h2>
								</div>
							</div>
							<div class="col col-auto">
								<span class="sparkline_bar2"></span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-4 col-lg-4 col-md-12">
				<div class="card">
					<div class="card-body">
						<div class="row mb-3">
							<div class="col">
								<h6 class="text-muted mb-0 mt-1">Total Orders</h6>
							</div>
							<div class="col col-auto">
								<a class="btn btn-sm btn-white border" href="<?=base_url()?>admin/ordersummary">View Details</a>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<div class="dash-2">
									<h2 class="mb-2"><span class="counter font-weight-extrabold num-font">
										<?php echo $ttlorderscount; ?>
									</span></h2>
								</div>
							</div>
							<div class="col col-auto">
								<span class="sparkline_bar3"></span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		
		<!--<div class="row">
			<?php
				/* foreach ($userwise_count as $userwise) { */
			?>
			
			<div class="col-xl-3 col-lg-3 col-md-6 div-dashboard-cnt">
				<div class="card">
					<div class="card-header pl-1 pr-1">
						<h3 class="card-title text-center card-countitle" style="width:100%;"><?=$userwise['usertype'];?>  &nbsp;<?=$userwise['cnt'];?></h3>
					</div>
					<div class="card-body">
						
						<div class="row mb-3">
							<div class="col-md-8">
								<h5><i class=" fa fa-circle text-primary"></i> Active</h5>
							</div>
							<div class="col-md-4">
								<h5><?=$userwise['active_count'];?></h5>
							</div>
						</div>
						
						<div class="row mb-3">
							<div class="col-md-8">
								<h5><i class=" fa fa-circle text-danger"></i> Inactive</h5>
							</div>
							<div class="col-md-4">
								<h5><?=$userwise['inactive_count'];?></h5>
							</div>
							
						</div>
					</div>
				</div>
			</div>
			<?php
				/* } */
			?>			
		</div>-->
		
		<div class="row">
			<div class="col-md-12 col-xl-6 col-lg-6">
				<div class="card overflow-hidden">
					<div class="card-header">
						<h3 class="card-title" style="width:50%;">Monthly Revenue</h3>
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
				<div class="col-md-12 col-xl-6 col-lg-6">
								<div class="card overflow-hidden">
									<div class="card-header">
										<h3 class="card-title" style="width:50%;">Monthly Orders</h3>
										<div class="text-right" style="width:50%">
											<?php $year = date("Y"); ?>
											<select id="select_year_order" class="form-control">
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
										<div id="social2" class="overflow-hidden chart-dropshadow"></div>
									</div>
								</div>
							</div>
							<div class="col-md-12 col-xl-6 col-lg-6">
								<div class="card overflow-hidden">
									<div class="card-header">
										<h3 class="card-title" style="width:50%;">Monthly Restaurant</h3>
										<div class="text-right" style="width:50%">
											<select id="select_year_restaurant" class="form-control">
												<?php for ($i=$year; $i >=2020 ; $i--) { 
													?><option><?=$i?></option><?php
												} ?>
											</select>
										</div>
									</div>
									<div class="card-body">
										<div id="social3" class="overflow-hidden chart-dropshadow"></div>
									</div>
								</div>
							</div>
			</div>
		
		
		<div class="row">
			<div class="col-md-12 col-lg-12">
				<div class="card">
					<div class="card-header">
						<div class="card-title">Restaurant Details</div>
					</div>
					<div class="card-body">
						<div class="table-responsive ">
							<table id="example-2" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th class="wd-15p border-bottom-0">No.</th>
										<th class="wd-15p border-bottom-0">Restaurant Name</th>
										<th class="wd-15p border-bottom-0" data-orderable="false">City</th>
										<th class="wd-20p border-bottom-0">Today's Order</th>
										<th class="wd-15p border-bottom-0">Total Orders</th>
										<th class="wd-10p border-bottom-0">Total Revenue</th>
										<!-- <th class="wd-25p border-bottom-0" data-orderable="false"></th> -->
									</tr>
								</thead>
								<tbody>
									<?php $i =1; foreach ($user_list as $user){?>
									<tr>
										<td><?php echo $i;?></td>
										<td><?php echo ucwords($user->name);?></td>
										<td><?php echo $user->city;?></td>
										<td><?php echo $user->tdcnt;?></td>
										<td><?php echo $user->tlcnt;?></td>
										<td><?php echo $user->earning;?></td>
										<!-- <td>	
											<button class="btn btn-sm btn-success btn-view-tableorder mr-1" onclick="view(<?php echo $user->id; ?>)"><i class="fas fa-eye"></i></button>
										</td> -->
									</tr>
									<?php $i=$i+1; }?>
								</tbody>
							</table>
							
						</div>
					</div>
					<!-- table-wrapper -->
				</div>
				<!-- section-wrapper -->
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
							<script>
try {
  fetch(new Request("https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js", { method: 'HEAD', mode: 'no-cors' })).then(function(response) {
    return true;
  }).catch(function(e) {
    var carbonScript = document.createElement("script");
    carbonScript.src = "//cdn.carbonads.com/carbon.js?serve=CK7DKKQU&placement=wwwjqueryscriptnet";
    carbonScript.id = "_carbonads_js";
    document.getElementById("carbon-block").appendChild(carbonScript);
  });
} catch (error) {
  console.log(error);
}
</script>
  <div class="container-fluid">
    

    <div class="yourFlickgalWrap">

      <div class="container" style="height:300px !important;">
        <div class="containerInner" style="height:300px !important;">
		<?php foreach ($trending_offers as $key => $value){?>
          <div id="sea<?=$key?>" class="item">
								<div class="col-lg-12 col-md-12 col-sm-12 col-12 shadow-sm mb-4 bg-white" style="border-radius:10px;">
								<div class="row">
									<div class="col-lg-12 col-md-12 col-sm-12 col-12">
										<?php if ($value['profile_photo'] == 'assets/images/users/menu.png') {
											?>
											<img src="<?=base_url('assets/images/users/menu.png')?>" width="100%" height="150px">
											<?php
										} else{?>
											<img src="<?=$value['profile_photo']?>" width="100%" height="150px">
										<?php } ?>
									</div>
									<div class="col-lg-12 col-md-12 col-sm-12 col-12">
									<p style="font-weight:bold;font-size:15px;"><?=$value['name']?></p></div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-6">
										<p>Orders <span class="text-danger"><?=$value['total_order']?></span></p>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-6 text-right">
										<p>Income <span class="text-danger">&#8377;<?=$value['sub_total']?></span></p>
									</div>
								</div>
							</div>
		</div><?php } ?>
        </div>
      </div>

      <div class="arrows">
        <a href="javascript:void(0);" class="prev">&lt;&lt;&nbsp;</a>
        <a href="javascript:void(0);" class="next">&nbsp;&gt;&gt;</a>
      </div>

      <div class="nav">
        <ul>
		<?php foreach ($trending_offers as $key => $value){?>
          <li class="sea<?=$key?>"><a href="#sea<?=$key?>">・</a></li>
		<?php } ?>
        </ul>
      </div>

    </div>

    <div class="message"></div>

						
							</div>
					</div>
				</div>
			</div>
		</div>
			
		<!--<div class="row">
			<div class="col-lg-12 col-md-12">
				<div class="card">
					<div class="card-header">
						<div class="col-md-12">
							<div class="col-md-8 mt-2">
								<h3 class="card-title">User Registrations (<span class="change-month-year"><?=date('F Y');?></span>)</h3>
							</div>
						
							<div class="col-md-2" style="float: right;">
								<select class="form-control"  id="select-year">
									<option value="">Select Year</option>
									<?php
										$year=date('Y');
										for ($i=1; $i < 10; $i++) { 
									?>
									<option value="<?=$year;?>"><?=$year;?></option>
									<?php
										$year=date('Y',strtotime('-'.$i.' year'));
										}
									?>
								</select>
							</div>
							<div class="col-md-2" style="float: right;">
								<select class="form-control"  id="select-month">
								    <option value="">Select Month</option>
								    <option value="01">Jan</option>
								    <option value="02">Feb</option>
								    <option value="03">Mar</option>
								    <option value="04">Apr</option>
								    <option value="05">May</option>
								    <option value="06">Jun</option>
								    <option value="07">Jul</option>
								    <option value="08">Aug</option>
								    <option value="09">Sep</option>
								    <option value="10">Oct</option>
								    <option value="11">Nov</option>
								    <option value="12">Dec</option>
								</select>
							</div>
						</div>
						
					</div>
					<div class="card-body">
						<canvas id="singelBarChart" ></canvas>
						<div class="row mt-3">
							<div class="col-lg-12 ml-1 mr-1">
								<div class="col-md-6  col-xl-3 features div-dashboard-cnt">
									<div class="card feature">
										<div class="card-body text-center">
											<p style="color:gray;">Total Recipes</p>
											<h6 class="mt-2">Restaurant</h6>
											<h2 class="counter num-font"><?=$recipes_count['Restaurant'];?></h2>
										</div>
									</div>
								</div>
								<div class="col-md-6  col-xl-3 features div-dashboard-cnt">
									<div class="card feature">
										<div class="card-body text-center">
											<p style="color:gray;">Total Recipes</p>
											<h6 class="mt-2">Burger and Sandwich</h6>
											<h2 class="counter num-font"><?=$recipes_count['Burger and Sandwich'];?></h2>
										</div>
									</div>
								</div>
								<div class="col-md-6  col-xl-3 features div-dashboard-cnt">
									<div class="card feature">
										<div class="card-body text-center">
											<p style="color:gray;">Total Recipes</p>
											<h6 class="mt-2">Restaurant chain</h6>
											<h2 class="counter num-font"><?=$recipes_count['Restaurant chain'];?></h2>
										</div>
									</div>
								</div>
								<div class="col-md-6  col-xl-3 features div-dashboard-cnt">
									<div class="card feature">
										<div class="card-body text-center">
											<p style="color:gray;">Total Recipes</p>
											<h6 class="mt-2">School</h6>
											<h2 class="counter num-font"><?=$recipes_count['School'];?></h2>
										</div>
									</div>
								</div>
								<div class="col-md-6  col-xl-3 features div-dashboard-cnt">
									<div class="card feature">
										<div class="card-body text-center">
											<p style="color:gray;">Total Recipes</p>
											<h6 class="mt-2">Individual User</h6>
											<h2 class="counter num-font"><?=$recipes_count['Individual User'];?></h2>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>	-->	
	</div>
	</div>
	
	<script type="text/javascript">
			$(document).ready(function(){
				yearlyearning($('#select_year_order').val());
				yearlycust($('#select_year_restaurant').val());
				$('#select_year_order').change(function(){
					yearlyearning($('#select_year_order').val());
				});
				$('#select_year_restaurant').change(function(){
					yearlycust($('#select_year_restaurant').val());
				});
				function yearlyearning(year){
					$('#social2').html('');
				$.ajax({
            		url: "<?=base_url()?>"+"Restaurant/monthly_order",
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

                name: 'Orders',

                data: result,
            }],
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug','sep','Oct','Nov','Dec'],
            },
            yaxis: {
                min: 0,
                max: max,
                title: {
                text: 'Orders'
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
            document.querySelector("#social2"),
            options
        );

        chart.render();

            		}
        		});
			}


			function yearlycust(year){
				$('#social3').html('');
				$.ajax({
            		url: "<?=base_url()?>"+"Restaurant/monthly_restaurant",
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
            document.querySelector("#social3"),
            options
        );

        chart.render();

            		}
        		});
			}
			});
		</script>

	<script type="text/javascript">
	$(document).ready(function() {
          $('#example-2').DataTable();
        } );
		$(document).ready(function()
		{
			yearlyearning($('#select_year').val());
			yearlycust($('#select_year_cust').val());
		
			$('#select_year').change(function(){
				yearlyearning($('#select_year').val());
			});
			
			$('#select_year_cust').change(function(){
				yearlycust($('#select_year_cust').val());
			});

			function yearlyearning(year)
			{
				$('#social').html('');
				$.ajax({
            		url: "<?=base_url()?>"+"Admin/monthly_erning",
            		type:'POST',
            		data:{year:year} ,
            		success: function(result)
					{
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

			function yearlycust(year)
			{
				$('#social1').html('');
				
				$.ajax({
            		url: "<?=base_url()?>"+"Admin/monthly_cust",
            		type:'POST',
            		data:{year:year} ,
            		success: function(result)
					{
            			console.log(result);
            			var options = 
						{
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
							tooltip: 
							{
								y: 
								{
									formatter: function (val) 
									{
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
	<?php require_once('footer.php');?>
	<!-- Chart js -->
	<script src="<?=base_url();?>assets/plugins/chart.js/chart.min.js"></script>
	<script src="<?=base_url();?>assets/plugins/chart.js/chart.extension.js"></script>
	<script type="text/javascript">
		(function($) 
		{
			"use strict";
			var year_selected="<?php if(isset($_GET['year'])) echo $_GET['year']; else '';?>";
			var month_selected="<?php if(isset($_GET['month'])) echo $_GET['month']; else '';?>";
			if(year_selected!="")
				$('#select-year').val(year_selected);
			else
				$('#select-year').val("<?=date('Y');?>");

			if(month_selected!="")	
				$('#select-month').val(month_selected);
			else
				$('#select-month').val("<?=date('m');?>");

			$('.change-month-year').html($('#select-month option:selected').html()+' '+$('#select-year').val());

			$('#select-year').on('change',function(e){
				window.location.href="<?=base_url();?>admin?year="+$(this).val()+'&month='+$('#select-month').val();
			});

			$('#select-month').on('change',function(e){
				window.location.href="<?=base_url();?>admin?year="+$('#select-year').val()+'&month='+$(this).val();
			});
			
			var ctx = document.getElementById( "singelBarChart" );
			ctx.height = 100;
			
			var myChart = new Chart( ctx, 
			{
				type: 'bar',
				data: 
				{
					labels: [ "Restaurant","Burger and Sandwich","Restaurant chain","School","Individual User"],
					datasets: 
					[{
						label: "User Registrations",
						data: [<?=$user_registrations['Restaurant']?>,<?=$user_registrations['Burger and Sandwich']?>,<?=$user_registrations['Restaurant chain']?>,<?=$user_registrations['School']?>,<?=$user_registrations['Individual User']?>],
						borderColor: "rgba(19, 150, 204, 0.9)",
						borderWidth: "0",
						backgroundColor: "rgba(19, 150, 204, 0.8)"
					}]
				},
				options: 
				{
					responsive: true,
					maintainAspectRatio: true,
					scales: 
					{
						yAxes: 
						[{
							ticks: {
								beginAtZero: true,
								callback: function(value) {if (value % 1 === 0) {return value;}}
							}
						}]
					}
				}
			});
		})(jQuery);
	</script>
	<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36251023-1']);
  _gaq.push(['_setDomainName', 'jqueryscript.net']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
	<script>
	
		function view(restid)
		{
			$.ajax({
				method:"POST",
				url:"<?php echo base_url('admin/open_resto_dashboard'); ?>",
				data:{"restid":restid},
				success:function(data)
				{
					/* window.location.href("<?php echo base_url();?>restaurant/dashboard/"); */
					window.open("<?php echo base_url();?>restaurant/dashboard/", "_blank");
				}
			});
			/* window.location = "<?php echo base_url();?>Admin/open_resto_dashboard/"+restid; */
		}
	</script>
	