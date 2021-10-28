<div class=" app-content">
	<div class="side-app">

		<!--Page Header-->
		<div class="page-header">
			<h3 class="page-title"><i class="side-menu__icon fas fa-utensils mr-1"></i> <?=$recipe['menu_master_name'];?></h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page"><?=$recipe['menu_master_name'];?></li>
			</ol>
		</div>
		<!--Page Header-->
		
		
		<!-- code by Ashwini for Barmenu -->
		<!-- <div class="row recipe-tabs">
			<div class="col-xl-3 col-md-4 col-md-3-custom receipes">
				<a href="<?=base_url();?>recipes/create/<?=$recipe_id;?>">
					<div class="card">
						<div class="card-body">
							<div class="float-right">
								<span class="mini-stat-icon1 bg-primary-transparent"><i class="fas fa-utensils text-primary"></i></span>
							</div>
							<div class="dash3">
								<h5 class="text-muted">Restaurant Menu</h5>
							</div>
						</div>
					</div>
				</a>
			</div>
			<div class="col-xl-3 col-md-4 col-md-3-custom nutrition">
				<a href="<?=base_url();?>recipes/createbarmenu/<?=$recipe_id;?>">
					<div class="card">
						<div class="card-body">
							<div class="float-right">
								<span class="mini-stat-icon1 bg-secondary-transparent"><i class="fab fa-glass-martini text-secondary"></i></span>
							</div>
							<div class="dash3">
								<h5 class="text-muted">Bar Menu</h5>
							</div>
						</div>
					</div>
				</a>
			</div>
		</div> -->
		<!-- end code by Ashwini -->
		
		
		<div class="row">
			<div class="col-md-12 div-main-recipeheader">
				<div class="card welcome-image">
					<div class="card-body">
						
						<form class="form-recipe-restaurant" method="post" action="javascript:;">
							<input type="hidden" name="recipe_id" value="<?=$recipe_id;?>">

							<input type="hidden" name="recipe_price_count" value="0" class="inupt-recipe-pricecount">

							<input type="hidden" name="main_menu_id" id="main_menu_id" value="<?=$recipe['main_menu_id'];?>">
							<div class="row">
								<div class="col-md-1 text-center">
									<span class="avatar avatar-xl brround cover-image mb-3 recipe-image-upload" data-image-src="<?=base_url();?>assets/images/users/menu.png" style="cursor: pointer;"></span>
									<input type="file" id="imgupload" accept="image/jpeg" style="display:none"/> 
									<a href="javascript:;" class="btn btn-secondary btn-sm" id="OpenImgUpload" style="background-color: #ED3573;border: 0px !important;">Browse</a>
								</div>
								<?php
								if($_SESSION['is_category_prices']==0)
								{
								?>
									<div class="col-md-11">
										<div class="row">
											<div class="col-md-5">
												<input type="text" name="recipe_title" value="<?=$recipe['name'];?>" class="text-white mt-2 mb-2 form-control input-reciepe-header input-recipe-name" onclick="this.select();" id="in-recipe-name" style="text-transform: capitalize;">
											</div>
											<div class="col-md-2 text-right">
												<label class="form-label label-header"> Price</label>
											</div>
											<div class="col-md-3">
												<input type="text" name="price" value="<?=$recipe['price'];?>" class="text-white mt-2 mb-2 form-control input-reciepe-header input-recipe-price" onclick="this.select();" id="in-recipe-price" maxlength="9">
											</div>
											<div class="col-md-1">
											</div>
										</div>
										<div class="row">
										<?php if($recipe['main_menu_id'] == ''){ ?>
											<div class="col-md-5">
												<input type="text" name="main_menu_name"  class="text-white mt-2 mb-2 form-control input-menu-name typeahead" onclick="this.select();" value="" placeholder="Enter Main Menu Name" autocomplete="off">
												
											</div>
										<?php } ?>
											<div class="col-md-5">
												<input type="text" name="group_name"  class="text-white mt-2 mb-2 form-control input-reciepe-header input-group-name typeahead" onclick="this.select();" value="<?=$recipe['group_name'];?>" placeholder="Enter Group Name" autocomplete="off">
												<input type="hidden" name="group_id" class="input-group-id" value="<?=$recipe['group_id'];?>">
											</div>
											<div class="col-md-2 text-right">
												<label class="form-label label-header">Menu Type</label>
											</div>
											<div class="col-md-3">
												<select type="text" name="recipe_type" value="<?=$recipe['recipe_type'];?>" class="text-white mt-2 mb-2 form-control input-reciepe-header input-recipe-type" onclick="this.select();" id="in-recipe-type">
													<option value="">Select menu type</option>
													<option value="veg" selected="">Veg</option>
													<option value="nonveg">Non-veg</option>
													<option value="none">None</option>
												</select>
											</div>
											<div class="col-md-2">
											</div>
										</div>
										<div class="row">
											<div class="col-md-2 left-right">
												<label class="form-label label-header">Best Time To Eat</label>
											</div>
											<div class="col-md-3">
												<select multiple="multiple" class="hide-select multi-select input-timeto-eat"   id="in-timeto-eat">
													<option value="none">none</option>
													<option value="all">All</option>
													<option value="morning">Morning</option>
													<option value="afternoon">Afternoon</option>
													<option value="evening">Evening</option>
													<option value="night">Night</option>
												</select>
												<script type="text/javascript">
													var time_to_eat="<?php if(isset($recipe['best_time_to_eat'])) echo $recipe['best_time_to_eat']; else echo 'none';?>";
													var dataarray=time_to_eat.split(",");

													$('.input-timeto-eat').val(dataarray);
													
												</script>
											</div>
											<div class="col-md-2 text-right">
												<label class="form-label label-header">Description</label>
											</div>
											<div class="col-md-5">
												<input type="text" name="description" value="<?=$recipe['description'];?>" class="text-white mt-2 mb-2 form-control input-reciepe-header input-recipe-desc" onclick="this.select();" id="in-recipe-desc">
											</div>
										</div>
										<div class="row">
											<div class="offset-md-7 col-md-5">
											
												<a href="<?=base_url();?>recipes/addrecipe/<?=$recipe['main_menu_id'];?>" class="btn btn-default" style="background-color: #ede3e7;;border: 0px !important;float:right;margin-left:10px;margin-top: 1rem;"><i class="fa fa-plus"></i> Create New</a>
												<button type="submit" class="btn btn-secondary btn-add-group" type="button" style="background-color: #ED3573;border: 0px !important;float:right;margin-top:10px;margin-top: 1rem;">Save</button>
											</div>
										</div>

									</div>
								<?php
								}
								else
								{
								?>
									<div class="col-md-11">
										<div class="row">
											<div class="col-md-4">
												<input type="text" name="recipe_title" value="<?=$recipe['name'];?>" class="text-white mt-2 mb-2 form-control input-reciepe-header input-recipe-name" onclick="this.select();" id="in-recipe-name" style="text-transform: capitalize;">
											</div>
											<div class="col-md-2 text-right">
												<label class="form-label label-header">Menu Type</label>
											</div>
											<div class="col-md-2 pr-0">
												<select type="text" name="recipe_type" value="<?=$recipe['recipe_type'];?>" class="text-white mt-2 mb-2 form-control input-reciepe-header input-recipe-type" id="in-recipe-type">
													<option value="">Menu type</option>
													<option value="veg" selected="">Veg</option>
													<option value="nonveg">Non-veg</option>
													<option value="none">None</option>
												</select>
											</div>
											<div class="col-md-2 text-right">
												<label class="form-label label-header">Best Time To Eat</label>
											</div>
											<div class="col-md-2">
												<select multiple="multiple" class="hide-select multi-select input-timeto-eat"  name="best_time_to_eat" id="in-timeto-eat">
													<option value="none">none</option>
													<option value="all">All</option>
													<option value="morning">Morning</option>
													<option value="afternoon">Afternoon</option>
													<option value="evening">Evening</option>
													<option value="night">Night</option>
												</select>
												<script type="text/javascript">
													var time_to_eat="<?php if(isset($recipe['best_time_to_eat'])) echo $recipe['best_time_to_eat']; else echo 'none';?>";
													var dataarray=time_to_eat.split(",");

													$('.input-timeto-eat').val(dataarray);
													
												</script>
											</div>
										</div>
										<div class="row">
											<div class="col-md-3">
												<input type="text"  class="text-white mt-2 mb-2 form-control input-reciepe-header input-menu-name typeahead" onclick="this.select();" placeholder="Enter Main Menu Name" autocomplete="off" value="<?=$recipe['menu_master_name'];?>">
											</div>
											<div class="col-md-3">
												<input type="text" name="group_name"  class="text-white mt-2 mb-2 form-control input-reciepe-header input-group-name typeahead" onclick="this.select();" value="<?=$recipe['group_name'];?>" placeholder="Enter Group Name" autocomplete="off">
												<input type="hidden" name="group_id" class="input-group-id" id="group_id" value="<?=$recipe['group_id'];?>">
										</div>
											<div class="col-md-2 text-right">
												<label class="form-label label-header">Description</label>
											</div>
											<div class="col-md-3">
												<input type="text" name="description" value="<?=$recipe['description'];?>" class="text-white mt-2 mb-2 form-control input-reciepe-header input-recipe-desc" onclick="this.select();" id="in-recipe-desc">
											</div>
											<div class="col-md-2 text-right">
												<label class="form-label label-header">Product Code</label>
											</div>
											<div class="col-md-2">
												<input type="text" name="pcode" id="pcode" value="<?=$recipe['product_code'];?>" maxlength="4" class="text-white mt-2 mb-2 form-control input-reciepe-header input-recipe-pcode" onclick="this.select();">
											</div>
										</div>
										<div class="row">
											<div class="col-md-2">
											</div>
											<div class="col-md-2 pr-0 text-white">
											</div>
										</div>
										<div class="row">
												<div class="col-md-5" id="show_extra_div"></div>
											<div class="col-md-2 text-left">
												<label class="form-label label-header">Table Category 1</label>
												<input type="hidden" name="recipe_price_id" value="" class="input-reciperpice-id1">
											</div>
											<div class="col-md-2">
												<select name="quantity" value="<?=$recipe['quantity'];?>" class="text-white mt-2 mb-2 form-control input-reciepe-header input-recipe-tablecat" id="in-recipe-quantity1">
													
												</select>
											</div>
											<div class="col-md-1 text-left">
												<label class="form-label label-header"> Price 1</label>
											</div>
											<div class="col-md-1">
												<input type="text" name="price" value="<?=$recipe['price'];?>" class="text-white mt-2 mb-2 form-control input-reciepe-header input-recipe-price" onclick="this.select();" id="in-recipe-price">
											</div>
											<!-- <div class="col-md-2">
												<label class="form-label" style="color: #7CBDD9;"> Price 1</label>
												<div class="custom-controls-stacked">
													<label class="custom-control custom-radio" style="color: #fff;font-weight: bold;">
														<input type="radio" class="custom-control-input" name="is_default" value="option1" checked="">
														<span class="custom-control-label">Is Default</span>
													</label>
												</div>
											</div> -->
											<div class="col-md-1 text-left">
												<button type="button" class="btn btn-success btn-add-tableprice" type="button" style="border: 0px !important;margin-top:10px;margin-top: 1rem;"><i class="fas fa-plus"></i></button>
											</div>
											
										</div>
										<div class="div-price-append">
											
										</div>
										<div class="row">
											<div class="offset-md-5 col-md-7">
											
												<a href="<?=base_url();?>recipes/addrecipe/<?=$recipe['main_menu_id'];?>" class="btn btn-default" style="background-color: #ede3e7;;border: 0px !important;float:right;margin-left:10px;margin-top: 1rem;"><i class="fa fa-plus"></i> Create New</a>
												<button type="submit" class="btn btn-secondary btn-add-group" type="button" style="background-color: #ED3573;border: 0px !important;float:right;margin-top:10px;margin-top: 1rem;">Save</button>
											</div>
										</div>
									</div>
								<?php
								}
								?>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<?php
			if($_SESSION['is_alacalc_recipe']==1){
		?>
		<div class="row recipe-tabs">
			<div class="col-xl-3 col-md-4 col-md-3-custom receipes">
				<a href="<?=base_url();?>recipes/create/<?=$recipe_id;?>">
					<div class="card">
						<div class="card-body">
							<div class="float-right">
								<span class="mini-stat-icon1 bg-primary-transparent"><i class="fas fa-utensils text-primary"></i></span>
							</div>
							<div class="dash3">
								<h5 class="text-muted">Receipes</h5>
							</div>
						</div>
					</div>
				</a>
			</div>
			<div class="col-xl-3 col-md-4 col-md-3-custom nutrition">
				<a href="<?=base_url();?>recipes/nutrition/<?=$recipe_id;?>">
					<div class="card">
						<div class="card-body">
							<div class="float-right">
								<span class="mini-stat-icon1 bg-secondary-transparent"><i class="fab fa-nutritionix text-secondary"></i></span>
							</div>
							<div class="dash3">
								<h5 class="text-muted">Nutrition</h5>
							</div>
						</div>
					</div>
				</a>
			</div>
			<!-- <div class="col-xl-3 col-md-4 col-md-3-custom costing">
				<a href="<?=base_url();?>recipes/costing">
					<div class="card">
						<div class="card-body">
							<div class="float-right">
								<span class="mini-stat-icon1 bg-pink-transparent"><i class="fas fa-hand-holding-usd text-pink"></i></span>
							</div>
							<div class="dash3">
								<h5 class="text-muted">Costing</h5>
							</div>
						</div>
					</div>
				</a>
			</div>
			<div class="col-xl-3 col-md-4 col-md-3-custom optimization">
				<a href="<?=base_url();?>recipes/optimization">
					<div class="card">
						<div class="card-body">
							<div class="float-right">
								<span class="mini-stat-icon1 bg-warning-transparent"><i class="fas fa-assistive-listening-systems text-red"></i></span>
							</div>
							<div class="dash3">
								<h5 class="text-muted">Optimization</h5>
							</div>
						</div>
					</div>
				</a>
			</div>
			<div class="col-xl-3 col-md-4 col-md-3-custom output">
				<a href="<?=base_url();?>recipes/output">
					<div class="card">
						<div class="card-body">
							<div class="float-right">
								<span class="mini-stat-icon1 bg-warning-transparent"><i class="fas fa-external-link-alt text-warning"></i></span>
							</div>
							<div class="dash3">
								<h5 class="text-muted">Output</h5>
							</div>
						</div>
					</div>
				</a>
			</div> -->
		</div>
		<?php
			}
		?>

	<!-- 	<style type="text/css">
			body{
				font-size: 14px !important;
			}
		</style> -->