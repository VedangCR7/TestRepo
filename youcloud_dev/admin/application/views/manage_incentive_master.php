<?php
require_once('header.php');
require_once('sidebar.php');

?>
<style type="text/css">
	.input-price-edit{
		line-height: 60px;
	    border-bottom: 1px solid #fff;
	    border-radius: 0;
	}
</style>
<div class=" app-content">
	<div class="side-app">

		<!--Page Header-->
		<div class="page-header">
			<h3 class="page-title"><i class="side-menu__icon fas fa-utensils mr-1"></i> <span class="span-master-menuname">Manage Incentive</span></h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page"><span class="span-master-menuname">Manage Incentive</span></li>
			</ol>
		</div>
		<!--Page Header-->
	</div>
	<!-- <div class="row">		
	</div> -->
	<div class="row edit_manager"></div>
	<div class="row mb-3 row-filter" style="margin-top:10px;" id="captain_form">
		<div class="col-md-3">
			<select class="form-control" id="master_menu"></select>
		</div>	
		<!-- waiters -->
			<div class="col-md-2 wtr_incentive" style="display: none;">
				<input type="text" class="form-control" placeholder="From &#8377;" id="from_range" onkeypress="return onlyNumberKey(event)" required>
			</div>

			<div class="col-md-2 wtr_incentive" style="display: none;">
				<input type="text" class="form-control" placeholder="To &#8377;" id="to_range" onkeypress="return onlyNumberKey(event)" required>
			</div>		
			<div class="col-md-2 wtr_incentive" style="display: none;">
				<input type="text" class="form-control" placeholder="Incentives %" id="waiter_incentives" onkeypress="return onlyNumberKey(event)" required>
			</div>
		<!-- Assistant chef -->
			<div class="col-md-2 kitchenStaff_incentive" style="display: none;"> 
				<input type="text" class="form-control " placeholder="Kitchen staff category" id="staff_mode" required>
			</div>
			<div class="col-md-2 kitchenStaff_incentive" style="display: none;">
				<input type="text" class="form-control " placeholder="Staff percentag %" id="staff_percentage" onkeypress="return onlyNumberKey(event)" required>
			</div>	
		<!-- Save button -->
		<div class="col-md-1">
			<span class="input-group-append updclass">
				<a href="javascript:;" class="btn btn-secondary pl-1 pr-1 text-center new-recipe-a btn-save-details" style="width: 100%;" id="add_incentive">				
					 Save
				</a>
			</span>
		</div>
	</div>	
	<!-- Waiter form -->
	<div class="row mb-3 row-filter" style="margin-top:10px;">
		<div class="col-md-5">
			<div class="input-group">
				<input type="text" class="form-control" placeholder="Search"  id="searchRecipeInput" style="font-size: 15px;">
				<span class="input-group-append">
					<button class="btn btn-primary" type="button" style="border-radius: 4px;"><i class="fas fa-search"></i></button>
				</span>
			</div>
		</div>

		<div class="col-md-2">
			<div class="btn-group per_page m-r-5">
				<button class="btn btn-default dropdown-toggle" data-toggle="dropdown" type="button" aria-expanded="false" selected-per-page="30">
					30 items per page
					<i class="md md-arrow-drop-down"></i>
				</button>
				<ul class="dropdown-menu pull-right" role="menu">
					<li class=""><a data-per="15" class="a-recipe-perpage" data-preferences='{"per_page":"15"}' href="javascript:;">15</a></li>
					<li class=""><a data-per="30" class="a-recipe-perpage" data-preferences='{"per_page":"30"}' href="javascript:;">30</a></li>
					<li class=""><a data-per="60" class="a-recipe-perpage" data-preferences='{"per_page":"60"}' href="javascript:;">60</a></li>
					<li class=""><a data-per="all" class="a-recipe-perpage" data-preferences='{"per_page":"all"}' href="javascript:;">All (<span class="span-all-recipes"></span>)</a></li>
				</ul>
			</div>
		</div>

		<div class="col-md-3 p-l-20">
			<div class="btn-group page_links page-no" role="group">
				<button class="btn btn-default btn-prev disabled prev" data-page="prev" type="button">
					<span class="fas fa-angle-left"></span>
				</button>
				<button class="btn btn-default btn-current-pageno" curr-page="1"><b class="span-page-html">0-0</b> of <b class="span-all-recipes">0</b></button>
				<button class="btn btn-default btn-next disabled next" data-page="next" type="button">
					<span class="fas fa-angle-right"></span>
				</button>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="card">
			<!-- Table for Captain incentives -->
				<div class="card-body" style="display: none;" id="captain">					
					<div class="table-responsive">
						<table class="table card-table table-vcenter text-nowrap table-head">
							<thead >
								<tr>									
									<th>Menu</th>
									<th>Menu Group</th>
									<th>Price ( &#8377; )</th>									
									<th>Incentives ( &#8377; )</th>									
									<th></th>
								</tr>
							</thead>
							<tbody class="tbody-recipes-list">
								
							</tbody>
						</table>
					</div>					
				</div>
				<!-- Table for waiters incentives -->
				<div class="card-body" style="display: none;" id="waiter">	
						<div class="table-responsive">
							<table class="table card-table table-vcenter text-nowrap table-head">
								<thead>
									<tr>									
										<th>From</th>
										<th>To</th>					
										<th style="width: 30%;">Waiter Incentives ( &#8377; )</th>									
										<th></th>
									</tr>
								</thead>
								<tbody class="tbody-waiters-list">									
								</tbody>
							</table>
						</div>
					</div>
					<!-- Table for assistance_chef incentives -->
				<div class="card-body" style="display: none;" id="kitchenStaff">	
						<div class="table-responsive">
							<table class="table card-table table-vcenter text-nowrap table-head">
								<thead>
									<tr>									
										<th>Staff Name</th>			
										<th style="width: 30%;">Staff Incentives ( &#8377; )</th>									
										<th></th>
									</tr>
								</thead>
								<tbody class="tbody-kitchen-staff-list">									
								</tbody>
							</table>
						</div>
					</div>
				</div>
				
				</div>
			</div>		
		</div>
<?php
require_once('footer.php');
?>
<script src="<?=base_url();?>assets/js/custom/Manage_Incentiv_list.js?v=10"></script>

<script type="text/javascript">
	IncentiveList.base_url="<?=base_url();?>";
	// IncentiveList.group_id="<?php if(isset($_GET['group_id'])) echo $_GET['group_id']; else echo '';?>";
	// IncentiveList.main_menu_id="<?php if(isset($_GET['main_menu_id'])) echo $_GET['main_menu_id']; else echo '';?>";
	// IncentiveList.is_category_prices="<?=$_SESSION['is_category_prices'];?>";
	IncentiveList.init();
	/*$('.recipe-tabs').find('.receipes .card-body').addClass('active');*/
</script>

<script> 
    function onlyNumberKey(evt) { 
         
        // Only ASCII charactar in that range allowed 
        var ASCIICode = (evt.which) ? evt.which : evt.keyCode 
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57)) 
            return false; 
        return true; 
    } 
</script> 

<script>
	setInterval(function() {
                $.ajax({
                    url: "<?=base_url();?>restaurant/set_authority_exist",
                    type:'POST',
                    dataType: 'Incentive',
                    data: {name:'Menu'},
                    success: function(result){
                        if(result.status){
                            window.location.href="<?=base_url();?>restaurant/dashboard";
                        }
                   	}
                });
            },5000);
</script>