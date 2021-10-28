
<div class=" app-content">
	<div class="side-app">

		<!--Page Header-->
		<div class="page-header">
			<h3 class="page-title"><i class="side-menu__icon fas fa-utensils mr-1"></i> Bar menu</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Bar menu</li>
			</ol>
		</div>
		<!--Page Header-->
		
		
		<!-- code by Ashwini for Barmenu -->
		<!-- <div class="row recipe-tabs">
			<div class="col-xl-3 col-md-4 col-md-3-custom mainmenu">
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
			<div class="col-xl-3 col-md-4 col-md-3-custom barmenu">
				<a href="<?=base_url();?>recipes/createbarmenu/<?=$recipe_id;?>">
					<div class="card">
						<div class="card-body active">
							<div class="float-right">
								<span class="mini-stat-icon1 bg-secondary-transparent"><i class="fas fa-glass-martini text-secondary"></i></span>
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
			<div class="col-md-12">
				<div class="card welcome-image">
					<div class="card-body">
						<div class="row">
						<!-- 	<?php
								if(isset($_GET['recipe_id'])){
							?>
							<div class="col-md-1" style="margin-top: 5px;">
								<span class="avatar avatar-xl brround cover-image mb-3" data-image-src="<?=base_url();?>assets/images/users/menu.png"></span>
							</div>
							<div class="col-md-8" >
								<h3 class="text-white mb-1" style="line-height: 40px;">Enter Recipe Name</h3>
								<button class="btn btn-danger">Edit</button>
							</div>
							<?php
								}else{
							?> -->
							<div class="col-md-1 text-center">
								<span class="avatar avatar-xl brround cover-image mb-3 recipe-image-upload" data-image-src="<?=base_url();?>assets/images/users/menu.png" style="cursor: pointer;"></span>
								<input type="file" id="imgupload" accept="image/png, image/jpeg" style="display:none"/> 
								<a href="javascript:;" class="btn btn-secondary btn-sm" id="OpenImgUpload" style="background-color: #ED3573;border: 0px !important;">Browse</a>
							</div>
							<div class="col-md-11">
								<form class="form-recipe-header" method="post" action="javascript:;">
									<input type="hidden" name="recipe_id" value="<?=$recipe_id;?>">
									<input type="hidden" name="main_menu_id" value="2">
									<div class="row">
										<div class="col-md-4">
											<input type="text" name="recipe_title" value="<?=$recipe['name'];?>" class="text-white mt-2 mb-2 form-control input-reciepe-header input-recipe-name" onclick="this.select();" id="in-recipe-name">
										</div>
										<div class="col-md-3">
											<input type="text" name="group_name"  class="text-white mt-2 mb-2 form-control input-reciepe-header input-group-name typeahead" onclick="this.select();" value="<?=$recipe['group_name'];?>" placeholder="Enter Group Name" autocomplete="off">
											<input type="hidden" name="group_id" class="input-group-id" value="<?=$recipe['group_id'];?>">
											<!-- <button class="btn btn-secondary btn-add-group" type="button" style="background-color: #ED3573;border: 0px !important;float:right;margin-top:10px;margin-top: 1rem;">Save</button> -->
										</div>
									
										<div class="col-md-1">
											<!-- <?php
											if(isset($_GET['from']) && $_GET['from']=="addrecipe"){
											?>
											<?php
												}else{
											?>
											<div class="input-group-append">
												<button type="button" class="btn btn-danger btn-select-input" style="background-color: #ED3573;border: 0px !important;height: 85%;">Edit</button>
											</div>
											<?php
												}
											?> -->
										</div>
									</div>
									<div class="row">
										<div class="col-md-2 text-left">
											<label class="form-label label-header">Description</label>
										</div>
										<div class="col-md-5">
											<input type="text" name="description" value="<?=$recipe['description'];?>" class="text-white mt-2 mb-2 form-control input-reciepe-header input-recipe-desc" onclick="this.select();" id="in-recipe-desc">
										</div>
									</div>
									<div class="row">
										<div class="col-md-1 text-left">
											<label class="form-label label-header"> Qty 1</label>
										</div>
										<div class="col-md-2">
											<input type="text" name="quantity" value="<?=$recipe['quantity'];?>" class="text-white mt-2 mb-2 form-control input-reciepe-header input-recipe-quantity" onclick="this.select();" id="in-recipe-quantity" placeholder="Ex:10 ml" >
										</div>
										<div class="col-md-1 text-left">
											<label class="form-label label-header"> Price 1</label>
										</div>
										<div class="col-md-2">
											<input type="text" name="price" value="<?=$recipe['price'];?>" class="text-white mt-2 mb-2 form-control input-reciepe-header input-recipe-price" onclick="this.select();" id="in-recipe-price">
										</div>
										<div class="col-md-1 text-left">
											<button type="button" class="btn btn-success btn-add-price" type="button" style="border: 0px !important;margin-top:10px;margin-top: 1rem;"><i class="fas fa-plus"></i></button>
										</div>
										<div class="col-md-2">
										</div>
									</div>
									<div class="div-price-append">
										
									</div>
									
									<div class="row">
										<div class="col-md-7">
											<a href="<?=base_url();?>recipes/addrecipe/2" class="btn btn-default" style="background-color: #ede3e7;;border: 0px !important;float:right;margin-left:10px;margin-top: 1rem;"><i class="fa fa-plus"></i> Create New</a>
											<button type="submit" class="btn btn-secondary btn-save-details" type="button" style="background-color: #ED3573;border: 0px !important;float:right;margin-top:10px;margin-top: 1rem;">Save</button>
										</div>
										<div class="col-md-2">
										</div>
									</div>
								</form>
							</div>
							<!-- <div class="col-md-4" >
								<button type="button" class="btn btn-success" style="float: right;">Save</button>
							</div> -->
							<!-- <?php
								}
							?> -->
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
			if($_SESSION['is_alacalc_recipe']==1){
		?>
		<div class="row recipe-tabs">
			<div class="col-xl-3 col-md-4 col-md-3-custom receipes">
				<a href="<?=base_url();?>recipes/createbarmenu/<?=$recipe_id;?>">
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
				<a href="<?=base_url();?>recipes/barnutrition/<?=$recipe_id;?>">
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
		</div>

		<?php
			}
		?>
