
<div class=" app-content">
	<div class="side-app">

		<!--Page Header-->
		<div class="page-header">
			<h3 class="page-title"><i class="side-menu__icon fas fa-utensils mr-1"></i> Menu Management</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Menu Management</li>
			</ol>
		</div>
		<!--Page Header-->
			
		<div class="row">
			<div class="col-md-12 div-main-recipeheader">
				<div class="card welcome-image">
					<div class="card-body">
						<form class="form-recipe-restaurant" method="post" action="javascript:;">
							<input type="hidden" name="recipe_id" value="<?=$recipe_id;?>">
							<input type="hidden" name="main_menu_id" value="1">
							<div class="row">
								<div class="col-md-1 text-center">
									<?php 
										/* if(($recipe['recipe_image'] != '') || ($recipe['recipe_image'] != 'assets/images/users/menu.png')){ */
									?>
									<!--<br><img src="<?=$recipe['recipe_image'];?>" style="height:70px; width:70px; border-radius:50%;"><br>-->
									<?php /* }else{ */ ?>
									<span class="avatar avatar-xl brround cover-image mb-3 recipe-image-upload" data-image-src="<?=base_url();?>assets/images/users/menu.png" style="cursor: pointer;"></span>
									<?php /* } */ ?>
									
									<input type="file" id="imgupload" accept="image/jpeg" style="display:none"/> 
									<a href="javascript:;" class="btn btn-secondary btn-sm" id="OpenImgUpload" style="background-color: #ED3573;border: 0px !important;">Browse</a>
								</div>
								
									<div class="col-md-11">
										<div class="row">
											<div class="col-md-2 text-right">
												<label class="form-label label-header">Recipe Name</label>
											</div>
											<div class="col-md-6">
												<input type="text" name="recipe_title" value="<?=$recipe['name'];?>" class="text-white mt-2 mb-2 form-control input-reciepe-header input-recipe-name" onclick="this.select();" id="in-recipe-name">
											</div>
											<div class="col-md-2">
											</div>
										</div>
										<div class="row">
											<div class="col-md-2 text-right">
												<label class="form-label label-header">Long Description</label>
											</div>
											<div class="col-md-6">
												<input type="text" name="description" value="<?=$recipe['long_desc'];?>" class="text-white mt-2 mb-2 form-control input-reciepe-header input-recipe-desc" onclick="this.select();" id="in-recipe-desc">
											</div>
											<div class="col-md-2">
											</div>
										</div>
										<div class="row">
											<div class="col-md-2 text-right">
												<label class="form-label label-header">Declaration Name</label>
											</div>
											<div class="col-md-6">
												<input type="text" name="description" value="<?=$recipe['declaration_name'];?>" class="text-white mt-2 mb-2 form-control input-reciepe-header input-recipe-decnm" onclick="this.select();" id="in-recipe-decnm">
											</div>
											<div class="col-md-2">
											</div>
										</div>
										<div class="row">
											<div class="offset-md-5 col-md-7">
											
												<a href="<?=base_url();?>Menumaster/addrecipe/1" class="btn btn-default" style="background-color: #ede3e7;;border: 0px !important;float:right;margin-left:10px;margin-top: 1rem;"><i class="fa fa-plus"></i> Create New</a>
												<button type="submit" class="btn btn-secondary btn-add-group" type="button" style="background-color: #ED3573;border: 0px !important;float:right;margin-top:10px;margin-top: 1rem;">Save</button>
											</div>
										</div>
									</div>
								
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		