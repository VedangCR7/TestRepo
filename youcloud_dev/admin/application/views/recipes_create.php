<?php
/* var_dump($_SESSION);exit; */
require_once('header.php');
require_once('sidebar.php');
if($create_type=="barmenu")
	require_once('bar_menu.php'); 
else
	require_once('recipe_header.php');

?>
<link rel="stylesheet" href="<?=base_url();?>assets/plugins/resize/jquery.Jcrop.min.css" type="text/css" />
<script src="<?=base_url();?>assets/plugins/resize/jquery.min.js"></script>
<script src="<?=base_url();?>assets/plugins/resize/jquery.Jcrop.min.js"></script>
<style type="text/css">
.widget-user-image canvas{
	max-width: 100%;
	border: 3px solid #fff;
	border-radius: 50% !important;
	background: #fff;
}
.jcrop-holder{
	max-width: 100% !important;
}

.jcrop-holder img:last-child{
	max-width: 100% !important;
}
</style>
	<div class="row recipe-overview">
		<div class="col-md-12">
			<div class="card">
				<div class="images"></div>  
				<div class="pri-header">
					<h3 class="mr-1 mb-0">Ingredients
						<a href="javascript:;" class="btn rounded-button a-add-ingredient"><i class="fas fa-plus"></i></a>
					</h3>
				</div>
				<div class="card-body">
					<ul class="list-unstyled mt-3 mb-4">
						<li class="border-bottom-0 p-1 curr-ingredient-list" style="display: none;">
							<div id="current_ingredients_list">
								
							</div>
						</li>
					  	<li class="border-bottom-0 p-1 li-no-ingredients"><label>There is recipe has no ingredient yet.</label></li>
					  	<li class="border-bottom-1 p-1 li-no-ingredients"><label>To add ingredient click plus button.</label></li>
					  	<li class="border-bottom-0 p-10">
					  		<div class="row">
					  			<div class="col-md-11 border-bottom-1">
					  			</div>
					  		</div>
					  	</li>
					  	<li class="border-bottom-0 p-1 mt-3">
					  		<div class="row">
					  			<div class="col-md-9">
						  			<h6 class="h6-font">Gross Weight</h6>
					  			</div>
					  			<div class="col-md-2 fg-line">
						  			<input id="gross_weight" type="text" name="gross_weight" class="form-control input-border-bottom text-right" value="0.00" disabled="" style="width: 80%;float: left;padding-right: 5px;">
						  			<input type="text" name="gross_weight_unit" class="form-control input-border-bottom" value="g" style="width: 20%;" disabled="">
					  			</div>
					  			<!-- <div class="col-md-1">
					  				<i class="fas fa-pen"></i>
					  			</div> -->
					  		</div>
						</li>
						<li class="border-bottom-0 p-1" style="display: none;">
					  		<div class="row">
					  			<div class="col-md-9">
						  			<h6 class="h6-font">Net Weight After Cooking</h6>
					  			</div>
					  			<div class="col-md-2 fg-line">
						  			<input id="net_weight" type="text" name="net_weight" class="form-control input-border-bottom text-right" value="0.00"style="width: 80%;float: left;padding-right: 5px;">
						  			<input type="text" name="net_weight_unit" class="form-control input-border-bottom" value="g" style="width: 20%;" disabled="">
					  			</div>
					  			<div class="col-md-1">
					  				<i class="fas fa-pen"></i>
					  			</div>
					  		</div>
						</li>
						<li class="border-bottom-0 p-1">
					  		<div class="row">
					  			<div class="col-md-9">
						  			<h6 class="h6-font">Weight Loss</h6>
					  			</div>
					  			<div class="col-md-2 fg-line" >
						  			<input id="weight_loss" type="text" name="weight_loss" class="form-control input-border-bottom  text-right" value="0" style="width: 80%;float: left;padding-right: 5px;">
						  			<input id="weight_loss_per" type="text" name="weight_loss_per" class="form-control input-border-bottom" value="%" style="width: 20%;" disabled="">
					  			</div>
					  			<div class="col-md-1">
					  				<i class="fas fa-pen"></i>
					  			</div>
					  		</div>
						</li>
					 
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="row recipe-add-ingredient" style="display: none;">
		<div class="col-md-12">
			<div class="card">
				<div class="pri-header">
					<h3 class="mr-1 mb-0"> Add Ingredient
						<a href="#" class="btn rounded-button btn-back-ingredient"><i class="fas fa-arrow-left"></i></a>
					</h3>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-4">
							<div class="input-group w-100 p-2">
								<input type="search" class="form-control input-search-ingredient" autocomplete="off" placeholder="Search ingredients" name="q">
								<div class="input-group-append ">
									<button type="button" class="btn btn-primary ">
										<i class="fas fa-search" aria-hidden="true"></i>
									</button>
								</div>

							</div>
						</div>
						<div class="col-md-3">
							<label class="custom-switch pl-0" data-ts-color="custom" style="margin-top: 5px;line-height: 40px;">
								<input type="checkbox" name="custom_recipe" class="custom-switch-input input-custom-recipes">
								<span class="custom-switch-indicator ts-helper"></span>
								<span class="custom-switch-description">Recipes & Ingredients</span>
							</label>
						</div>
						<div class="col-md-5">
							<label class="custom-switch pl-0" data-ts-color="alacalc" style="margin-top: 5px;line-height: 40px;">
								<input type="checkbox" name="nai_standard" class="input-nai-standard custom-switch-input">
								<span class="custom-switch-indicator ts-helper"></span>
								<span class="custom-switch-description">NAI Standard</span>
							</label>
							<label class="custom-switch pl-0" data-ts-color="cofids" style="margin-top: 5px;line-height: 40px;">
								<input type="checkbox" name="uk_standard" class="input-uk-standard custom-switch-input">
								<span class="custom-switch-indicator ts-helper"></span>
								<span class="custom-switch-description">UK Standard</span>
							</label>
							<label class="custom-switch pl-0" data-ts-color="usda" style="margin-top: 5px;line-height: 40px;">
								<input type="checkbox" name="us_standard" class="input-us-standard custom-switch-input" data-toggle="switch">
								<span class="custom-switch-indicator ts-helper"></span>
								<span class="custom-switch-description">US Standard</span>
							</label>
						</div>
					</div>
					<div class="row row-msg-enter">
						<div class="col-md-6">
							<p>Please enter the ingredient you are looking for in search box above.</p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 div-ingredient-result">
						</div>
						<div class="col-sm-6 hidden-xs" id="nutrition_breakdown">
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
</div>
<div class="modal fade" id="modal-imagepreview" tabindex="-1" role="dialog"  aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="float: right;position: absolute;right: 3px;font-size: 22px;top: -7px;">
				<span aria-hidden="true">&times;</span>
			</button>
			<form method="post" action="javascript:;">
				<img id="cropbox" class="img" style="width: 100% !important;"/><br />
				<button type="button" class="btn btn-success" id="crop" value='CROP' style="float: right;margin-bottom: 10px;margin-right: 10px;">Crop</button>
			</form>
		</div>
	</div>
</div>
<?php
require_once('footer.php');
?>
<script src="<?=base_url();?>assets/js/custom/Reciepe.js?v=<?php echo uniqid();?>"></script>
<script type="text/javascript">
	 $(document).ready(function($) {
 		function randomStr(len, arr) { 
            var ans = ''; 
            for (var i = len; i > 0; i--) { 
                ans +=  
                  arr[Math.floor(Math.random() * arr.length)]; 
            } 
            return ans; 
        } 
	});

</script>
<script type="text/javascript">
	
	var table_cats=<?=json_encode($table_cats);?>;
	var is_category_prices="<?=$_SESSION['is_category_prices'];?>";
	Reciepe.base_url="<?=base_url();?>";
	Reciepe.recipe_id="<?=$recipe_id;?>";
	Reciepe.alacalc_recipe_id="<?=$recipe['alacal_recipe_id'];?>";
	Reciepe.is_alacalc_recipe="<?=$_SESSION['is_alacalc_recipe'];?>";
	Reciepe.is_category_prices="<?=$_SESSION['is_category_prices'];?>";
	Reciepe.create_type="<?=$create_type;?>";
	Reciepe.is_nutrition=0;
	Reciepe.main_menu_id="<?=$recipe['main_menu_id'];?>";
	Reciepe.init();
	if(table_cats.length<=0 && is_category_prices==1){
		swal("Error !","Please add table categories unless you can not add prices for recipes","error");
	}
	$('.recipe-tabs').find('.receipes .card-body').addClass('active');
	var from_page="<?php if(isset($_GET['from'])) echo $_GET['from']; else echo '';?>";
	if(from_page=="addrecipe"){
		$('#in-recipe-name').trigger('click');
	}

</script>

<script>
	setInterval(function() {
                $.ajax({
                    url: "<?=base_url();?>restaurant/set_authority_exist",
                    type:'POST',
                    dataType: 'json',
                    data: {name:'Menu'},
                    success: function(result){
                        if(result.status){
                            window.location.href="<?=base_url();?>restaurant/dashboard";
                        }
                   	}
                });
            },5000);
</script>
