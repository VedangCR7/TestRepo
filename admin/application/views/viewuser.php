<?php
require_once('header.php');
require_once('sidebar.php');

?>
<style type="text/css">
	.print-section{
	display:none;
}
	 @media print {
		.print-section {display:block}
		.btn-print {display:none;}
		.side-app {display:none;}
		.noPrint-section {display:none;}
		.app-content {display:none;}
	}
</style>
<div class="print-section"><br><br><center>
	<div class="widget-user-image"><img alt="FoodNAI Restaurant" class="rounded-circle span-profile-photo" width="16%" src="<?=base_url().$user['profile_photo'];?>"></div><br>
	<h3 class="pro-user-username text-dark span-name">Zero Touch Menu</h3>
	<div class="media mt-1 pb-2" style="justify-content: center;">
		<img src="<?=base_url().$user['img_url'];?>" style="width: 115px;height: 115px;">
	</div>
	<h3 class="pro-user-desc text-muted input-editname span-business_name" style="margin-bottom:3px;"><?=$user['business_name'];?></h3>
	<h6 class="pro-user-username text-dark span-name">By FoodNAI.com</h6></center>
</div>
<div class=" app-content">
	<div class="side-app">

		<!--Page Header-->
		<div class="page-header">
			<h3 class="page-title"><i class="side-menu__icon fas fa-utensils mr-1"></i> Profile</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?=base_url();?>company/users">Users</a></li>
				<li class="breadcrumb-item active" aria-current="page">User Details</li>
			</ol>
		</div>
		<!--Page Header-->
	</div>
	<div class="row div-view-user">
		<div class="col-xl-3  col-md-6 pofilelogo-section">
			<div class="card box-widget widget-user">
				<div class="widget-user-header bg-gradient-primary"></div>
				<div class="widget-user-image"><img alt="User Avatar" class="rounded-circle span-profile-photo" src="<?=base_url().$user['profile_photo'];?>"></div>
				<div class="card-body text-center">
					<div class="pro-user">
						<h3 class="pro-user-username text-dark span-name">
							<?=$user['name'];?></h3>

						<h6 class="pro-user-desc text-muted input-editname span-business_name"><?=$user['business_name'];?></h6>
						<input type="text" name="designation" class="form-control text-center input-edit-designation input-editname" value="Web Developer" style="display: none;">
						<hr>
						<h3 class="pro-user-username text-dark span-name">Zero Touch Menu</h3>
						<div class="media mt-1 pb-2" style="justify-content: center;">
							<img src="<?=base_url().$user['img_url'];?>" style="width: 115px;height: 115px;">
						</div>
						<h3 class="pro-user-desc text-muted input-editname span-business_name" style="margin-bottom:3px;"><?=$user['business_name'];?></h3>
						<h6 class="pro-user-username text-dark span-name">By FoodNAI.com</h6>
						<button  onclick="javascript:window.print()" class="btn-print btn btn-primary btn-sm a-edit-name input-editname" id="printBtn">Print </button>
					</div>

				</div>
				<!-- <div class="card-footer p-0">
					<div class="row">
						<div class="col-sm-12 text-center pro-user mb-5">
							<div class="pro-user-icons">
							<a href="#" class="facebook-bg mt-0"><i class="fab fa-facebook"></i></a>
							<a href="#" class="twitter-bg"><i class="fab fa-twitter"></i></a>
							<a href="#" class="linkedin-bg"><i class="fab fa-linkedin"></i></a>
						</div>
						</div>
						
					</div>
				</div> -->
			</div>
		</div>
		<div class="col-xl-9  col-md-6 noPrint-section">
			<div class="card">
				<div class="pri-header">
					<h3 class="mr-1 mb-0">Personal Info
						<!-- <a href="javascript:;" class="btn btn-primary btn-sm a-edit-profile" style="float: right;">
							<span class="a-text"><i class="si si-pencil mr-1"></i>Edit</span>
						</a>
						<a href="javascript:;" class="btn btn-primary btn-sm a-save-profile" style="float: right;display: none;">
							<span class="a-text" ></i>Save</span>
						</a> -->
					</h3>
					
				</div>
				<div class="card-body">
					<div class="row mt-6 mb-6 row-view-profile">
						<div class="col-md-6 pr-5">
							<div class="media-list">
								<div class="media mt-1 pb-2">
									<div class="mediaicon">
										<i class="si si-user" aria-hidden="true"></i>
									</div>
									<div class="media-body ml-5 mt-1">
										<h6 class="mediafont text-dark mb-1">Business Name
											
										</h6><span class="d-block span-name"><?=$user['name'];?></span>

									</div>
								</div>
								<div class="media mt-1 pb-2">
									<div class="mediaicon">
										<i class="si si-envelope" aria-hidden="true"></i>
									</div>
									<div class="media-body ml-5 mt-1">
										<h6 class="mediafont text-dark mb-1">Email Address
											
										</h6><span class="d-block span-email"><?=$user['email'];?></span>
									</div>
								</div>
								<div class="media mt-1 pb-2">
									<div class="mediaicon">
										<i class="si si-location-pin" aria-hidden="true"></i>
									</div>
									<div class="media-body ml-5 mt-1">
										<h6 class="mediafont text-dark mb-1">Business Name
											
										</h6><span class="d-block span-business_name"><?=$user['business_name'];?></span>
									</div>
								</div>
								<div class="media mt-1 pb-2">
									<div class="mediaicon">
										<i class="si si-phone" aria-hidden="true"></i>
									</div>
									<div class="media-body ml-5 mt-1">
										<h6 class="mediafont text-dark mb-1">Contact Number
										
									</h6><span class="d-block span-countrycode" style="float: left;margin-right: 3px;">+<?=$user['countrycode'];?></span><span class="d-block span-contact_number"><?=$user['contact_number'];?></span>
									</div>
								</div>
								<div class="media mt-1 pb-2">
									<div class="mediaicon">
										<i class="si si-link" aria-hidden="true"></i>
									</div>
									<div class="media-body ml-5 mt-1">
										<h6 class="mediafont text-dark mb-1">Link To Menu Details</h6>
										<span class="d-block span-profile-link"><a href="http://foodnai.com/restaurants/<?=$user['name'];?>" target="_blank" style="color:#000;">http://foodnai.com/restaurants/<?=$user['name'];?></a></span>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6 pl-3">
							<div class="media-list">
								<div class="media mt-1 pb-2">
									<div class="mediaicon">
										<i class="si si-book-open" aria-hidden="true"></i>
									</div>
									<div class="media-body ml-5 mt-1">
										<h6 class="mediafont text-dark mb-1">Address
										
									</h6><span class="d-block span-address"><?=$user['address'];?></span>
									</div>
								</div>
								<div class="media mt-1 pb-2">
									<div class="mediaicon">
										<i class="si si-book-open" aria-hidden="true"></i>
									</div>
									<div class="media-body ml-5 mt-1">
										<h6 class="mediafont text-dark mb-1">City
										
									</h6><span class="d-block span-city"><?=$user['city'];?></span>
									</div>
								</div>
								<div class="media mt-1 pb-2">
									<div class="mediaicon">
										<i class="si si-book-open" aria-hidden="true"></i>
									</div>
									<div class="media-body ml-5 mt-1">
										<h6 class="mediafont text-dark mb-1">Country
										
									</h6><span class="d-block span-country"><?=$user['country'];?></span>
									</div>
								</div>
								<div class="media mt-1 pb-2">
									<div class="mediaicon">
										<i class="si si-graduation" aria-hidden="true"></i>
									</div>
									<div class="media-body ml-5 mt-1">
										<h6 class="mediafont text-dark mb-1">Postal Code
										
									</h6><span class="d-block span-postcode"><?=$user['postcode'];?></span>
									</div>
								</div>
								<div class="admSelectCheck media mt-1 pb-2">
									<div class="mediaicon">
										<i class="si si-graduation" aria-hidden="true"></i>
									</div>
									<div class="media-body ml-5 mt-1">
										<h6 class="mediafont text-dark mb-1">Restaurant Type
										
									</h6><span class="d-block span-restauranttype">
										<?php
											$restaurant_type=$user['restauranttype'];
											if($restaurant_type=="veg")
												echo "Veg";
											else if($restaurant_type=="nonveg")
												echo "Non-veg";
											else if($restaurant_type=="both")
												echo "Veg / Non-veg";
										?>
											
										</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xl-12  col-md-12">
			<div class="card">
				<div class="pri-header">
					<div class="row mb-0 row-filter">
						<div class="col-md-2">
							<h3 class="mr-1 mb-0">Recipes</h3>
						</div>
						<div class="col-md-5">
							<div class="input-group">
								<input type="text" class="form-control" placeholder="Search Recipes"  id="searchRecipeInput" style="line-height: 2;">
								<span class="input-group-append">
									<button class="btn btn-primary" type="button" style="border-radius: 0px;border: 0px !important;"><i class="fas fa-search"></i></button>
								</span>
							</div>
						</div>
						<div class="col-md-2 p-l-5 p-r-5">
							<div class="btn-group per_page m-r-5">
								<button class="btn btn-default dropdown-toggle" data-toggle="dropdown" type="button" aria-expanded="false" selected-per-page="30" style="background: #fff;">
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
						<div class="col-md-3 p-l-15">
							<div class="btn-group page_links page-no" role="group" style="width: 100%;">
								<button class="btn btn-default btn-prev disabled prev" data-page="prev" type="button">
									<span class="fas fa-angle-left"></span>
								</button>
								<button class="btn btn-default" style="width: 55%;"><b class="span-page-html">0-0</b> of <b class="span-all-recipes">0</b></button>
								<buton class="btn btn-default btn-next disabled next" data-page="next" type="button">
									<span class="fas fa-angle-right"></span>
								</buton>
							</div>
						</div>
					</div>
					<!-- <h3 class="mr-1 mb-0">Recipes
					</h3> -->
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table card-table table-vcenter text-nowrap table-head" id="table-recipes">
							<thead >
								<tr>
									<th style="width: 80%;">Name</th>
									<th>Date</th>
									<th></th>
								</tr>
							</thead>
							<tbody class="tbody-recipes-list">
								<!-- <?php
								foreach ($recipes as $recipe) {
								?>
									<tr>
										<td>
											<a href="javascript:;" data-id="<?=$recipe['id'];?>" alacala-recipe-id="<?=$recipe['alacal_recipe_id'];?>" style="color:#000;" class="a-view-item"><?=$recipe['name'];?></a>
										</td>
										<td><?=$recipe['recipe_date'];?></td>
									</tr>
								<?php
								}
								?> -->
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
<div class="modal fade" id="modal-view-event" tabindex="-1" role="dialog"  aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="col-md-12">
				<div class="modal-header">
					<h3 class="modal-title text-center" style="width: 100%;">Recipe Details</h3>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form method="post" id="form-view-event" action="javascript:;">
					<div class="modal-body">
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<img class="recipe-image" src="<?=base_url();?>assets/images/products/2.png" style="width: 100%;">
								</div>
							</div>
							<div class="col-md-5">
								<div class="form-group">
									<h2 class="event-name" style="line-height: 150px;margin-left: 20px;margin-bottom: 0px !important;"></h2>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 pr-5">
								<div class="expanel expanel-default mt-0 mb-2">
									<div class="expanel-body" style="border-left: 10px solid #089D5F;padding: 10px !important;">
										<div class="row div-row-allergens">
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6 div-nutrient-details">
								<div class="row">
									<div class="col-md-6">
										<strong>Serving Size</strong>
									</div>
									<div class="col-md-5 text-center nutrient-html" id="servingsize"></div>
								</div>
								<div class="row">
									<div class="col-md-6"><strong>Calories</strong></div>
									<div class="col-md-5 text-center nutrient-html" id="Energ_Kcal"></div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<p><strong>Total Fat</strong></p>
										<p>Saturated Fat</p>
										<p>Trans Fat</p>
									</div>
									<div class="col-md-5 text-center">
										<p class="nutrient-html" id="Lipid_Tot"></p>
										<p class="nutrient-html" id="FA_Sat"></p>
										<p class="nutrient-html" id="FA_Trans"></p>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6"><strong>Cholesterol</strong></div>
									<div class="col-md-5 text-center nutrient-html" id="Cholestrl"></div>
								</div>
								<div class="row">
									<div class="col-md-6"><strong>Sodium</strong></div>
									<div class="col-md-5 text-center nutrient-html" id="Sodium"></div>
								</div>
							</div>
							<div class="col-md-6 div-nutrient-details">
								<div class="row">
									<div class="col-md-6">
										<p><strong>Total Carbs</strong></p>
										<p>Dietary Fiber</p>
										<p>Sugar</p>
									</div>
									<div class="col-md-5 text-center">
										<p class="nutrient-html" id="Carbohydrt"></p>
										<p class="nutrient-html" id="Fiber_TD"></p>
										<p class="nutrient-html" id="Sugar_Tot"></p>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<strong>Protein</strong>
									</div>
									<div class="col-md-5 text-center nutrient-html" id="Protein"></div>
								</div>
								<div class="row">
									<div class="col-md-6"><strong>Vitamin A</strong></div>
									<div class="col-md-5 text-center nutrient-html" id="Vit_A_IU"></div>
								</div>
								
								<div class="row">
									<div class="col-md-6"><strong>Calcium</strong></div>
									<div class="col-md-5 text-center nutrient-html"  id="Calcium"></div>
								</div>
								<div class="row">
									<div class="col-md-6"><strong>Iron</strong></div>
									<div class="col-md-5 text-center nutrient-html" id="Iron"></div>
								</div>
								<div class="row">
									<div class="col-md-6"><strong>Vitamin C</strong></div>
									<div class="col-md-5 text-center nutrient-html" id="Vit_C"></div>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php
require_once('footer.php');
?>
<script src="<?=base_url();?>assets/js/custom/Viewuser.js"></script>

<script type="text/javascript">
	Viewuser.base_url="<?=base_url();?>";
	Viewuser.user_id="<?=$user_id;?>";
	Viewuser.init();
	var h=$('.pofilelogo-section').height();
	console.log(h);
	$('.noPrint-section .card').height(h-20);

	var usertype="<?=$user['usertype'];?>";
	if(usertype=="Restaurant" || usertype=="Burger and Sandwich"){
		$('.admSelectCheck').show();
	}
	else{
		$('.admSelectCheck').hide();
	}

	/*$('.recipe-tabs').find('.receipes .card-body').addClass('active');*/
</script>
