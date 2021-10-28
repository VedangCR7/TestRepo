<?php
require_once('header.php');
require_once('sidebar.php');

?>
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
	
	<div class="row mb-3 row-filter" style="margin-top:10px;">
		<div class="col-md-3">
			<select class="form-control" id="master_menu">
				<option value="Restaurant manager">Captain</option>
				<option value="Waiter">Waiter</option>
				<option value="Head Chef">Head Chef</option>
				<option value="Assistant Chef">Assistant Chef</option>
				<option value="Kitchen staff">Kitchen Staff</option>
				<option value="Helper">Helper</option>
				<option value="Utility">Utility</option>
			</select>
		</div>	
		
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="card">
			<!-- Table for Captain incentives -->
				<div class="card-body" id="captain">			
					<div class="table-responsive">
					<div class="row">	
						<div class="col-lg-6 col-md-6 col-sm-12 col-12"> 
							<form action="<?=base_url('Manage_Incentive_master_controller/index')?>" method="post">
								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-12 col-12">
										<input type="text" name="recipe_search" class="form-control"> 
									</div>
									<div class="col-lg-6 col-md-6 col-sm-12 col-12">
										<input type="submit" value="Search" class="btn btn-primary">
									</div>
								</div>
							</form>
						</div>	
						<div class="col-lg-6 col-md-6 col-sm-12 col-12 text-right"><button class="btn btn-primary" id="save_recipe_incentive">Save</button></div>
					</div>
						<table class="table card-table table-vcenter text-nowrap table-head">
							<thead >
								<tr>									
									<th>Menu</th>
									<th>Menu Group</th>
									<th>Price</th>									
									<th>Incentives</th>
								</tr>
							</thead>
							<tbody class="tbody-recipes-list">

								<?php foreach($items as $key=> $value){ ?>
								<tr>
									<td><?=$value['name']?></td>
									<td><?=$value['title']?></td>
									<td><?=$value['price']?></td>
									<td>
										<input type="number" class="form-control" name="recipe_incentive[]" value="<?=$value['incentives_price']?>" placeholder="Incentive in amount">
										<input type="hidden" class="form-control" name="recipe_id[]" value="<?=$value['id']?>" placeholder="Incentive in amount">
									</td>
								<tr>
								<?php } ?>
							</tbody>
						</table>
					</div>					
				</div>
				<!-- Table for waiters incentives -->
				<div class="card-body" style="display: none;" id="non_captain">	
					<h6 id="usertypeincentive"></h6>
					<div class="col-lg-6 col-md-6 col-sm-12 col-12">
						<input type="number" class="form-control" min="0" max="100" id="incentive_per" placeholder="Incentive in percentage">
					</div>
					<div class="col-lg-6 col-md-6 col-sm-12 col-12">
						<button class="btn btn-primary" id="update_non_captain_incentive">Save</button>
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