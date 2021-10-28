<?php
require_once('header.php');
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
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-6  col-xl-3 features">
						<div class="card feature">
							<div class="card-body text-center pad-1rem" >
								<div class="col-md-7">
									<h5 class="mt-2 lh-one"><a href="<?=base_url();?>company/users?status=active">Active Restaurants</a></h5>
								</div>
								<div class="col-md-5">
									<p class="gray">Count</p>
									<h2 class="counter num-font"><?=$active_users;?></h2>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6  col-xl-3 features">
						<div class="card feature">
							<div class="card-body text-center pad-1rem" >
								<div class="col-md-7">
									<h5 class="mt-2 lh-one"><a href="<?=base_url();?>company/users?status=inactive">Inactive Restaurants</a></h5>
								</div>
								<div class="col-md-5">
									<p class="gray">Count</p>
									<h2 class="counter num-font"><?=$inactive_users;?></h2>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6  col-xl-3 features">
						<div class="card feature">
							<div class="card-body text-center pad-1rem" >
								<div class="col-md-7">
									<h5 class="mt-2 lh-one">Total Number of Recipes</h5>
								</div>
								<div class="col-md-5">
									<p class="gray">Count</p>
									<h2 class="counter num-font"><?=$recipes_count;?></h2>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-12 col-md-12 col-lg-12">
				<div class="card">
					<div class="card-header">
						<div class="col-md-12">
							<div class="col-md-9 mt-2">
								<!-- <h3 class="card-title">Restaurants Registrations</h3> -->
							</div>
							<div class="col-md-3" style="float: right;">
								<select class="form-control" name="registration" id="select-year">
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
						</div>
					</div>
					<div class="card-body">
						<div id="highchart7"></div>
					</div>
				</div>
			</div>
		</div>
	</div>

	
<?php
	require_once('footer.php');
?>
<script src="<?=base_url();?>assets/plugins/highcharts/highcharts.js"></script>
<script src="<?=base_url();?>assets/plugins/highcharts/highcharts-3d.js"></script>
<script src="<?=base_url();?>assets/plugins/highcharts/exporting.js"></script>
<script src="<?=base_url();?>assets/plugins/highcharts/export-data.js"></script>
<script src="<?=base_url();?>assets/plugins/highcharts/histogram-bellcurve.js"></script>
<script type="text/javascript">
    var year_d="<?=$curr_year;?>";
    console.log(year_d);
    $('#select-year').val(year_d);
	(function($) {
	    "use strict";
	    $('#select-year').on('change',function(e){
	    	window.location.href="<?=base_url();?>company?year="+$(this).val();
	    });
		var chart = Highcharts.chart('highchart7', {

	    title: {
	        text: ''
	    },

	    subtitle: {
	        text: ' '
	    },
		exporting: { enabled: false },
		credits: {
			enabled: false
		},
	    xAxis: {
	        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
	    },
	    yAxis: [{
	    	lineColor: '#ccd6eb',
            lineWidth: 1,
	    	allowDecimals: false,
			title: { text: 'Restaurants' }
		}],
		colors: [ '#089e60', '#1396cc','#ff9933', '#00bcd4', '#5e5baa', '#FF9655', '#f1c40f', '#6AF9C4'],
	    series: [{
	        type: 'column',
	        name: 'Registrations',
	        colorByPoint: false,
	        title: {
				text: 'Restaurants'
			},
	        data: [<?=$user_registration['01'];?>, <?=$user_registration['02'];?>, <?=$user_registration['03'];?>, <?=$user_registration['04'];?>, <?=$user_registration['05'];?>, <?=$user_registration['06'];?>, <?=$user_registration['07'];?>, <?=$user_registration['08'];?>, <?=$user_registration['09'];?>, <?=$user_registration['10'];?>, <?=$user_registration['11'];?>, <?=$user_registration['12'];?>],
	        showInLegend: false
	    }]

	});


})(jQuery);
</script>