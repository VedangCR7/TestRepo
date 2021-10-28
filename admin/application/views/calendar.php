<?php
require_once('header.php');
?>
<!-- Calendar Plugin -->
<link href="<?=base_url();?>assets/plugins/calendar/calendar.css" rel="stylesheet" />
<link href="<?=base_url();?>assets/plugins/calendar/stylesheet.css" rel="stylesheet" />
<?php
require_once('sidebar.php');

?>
<div class=" app-content">
	<div class="side-app">

		<!--Page Header-->
		<div class="page-header">
			<h3 class="page-title"><i class="side-menu__icon fas fa-utensils mr-1"></i> Calendar</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Calendar</li>
			</ol>
		</div>
		<!--Page Header-->
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-12">
			<div class="card">
				<div class="card-body">
					<div class="col-md-12">
						
						<div class="cal1"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
<div class="modal fade" id="modal-add-event" tabindex="-1" role="dialog"  aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header" style="border-bottom: 0px !important;">
				<h5 class="modal-title text-center" id="selected-date-text" style="width: 100%;">01 March 2020</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" style="padding-top: 0px;">
				<form method="post" id="form-add-event" action="javascript:;">
					<input type="hidden" name="recipe_count" id="input-recipe-count">
					<!-- <input type="hidden" name="selected_date" id="input-selected-date"> -->
					<div class="col-md-12" style="border: 1px solid #e4e6f9;">
						
							<div class="row mt-3">
								<div class="col-md-4">
									<div class="form-group">
										<input type="hidden" name="input_calendar_date" id="selected_calendar_date">
										<select class="form-control" name="menu_group" id="select-menu-group" required="">
											<option value="">Menu Group</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row div-recipes-list">
								<!-- 	<div class="col-md-4">
									<div class="form-group">
										<label class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input checkbox-recipe" name="check_recipe" value="option1" checked>
											<span class="custom-control-label">Coffee & walnut cake</span>
										</label>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input checkbox-recipe" name="check_recipe" value="option1" checked>
											<span class="custom-control-label">Carrot Cake</span>
										</label>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input checkbox-recipe" name="check_recipe" value="option1" checked>
											<span class="custom-control-label">Mac Balls</span>
										</label>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input checkbox-recipe" name="check_recipe" value="option1" checked>
											<span class="custom-control-label">Banana Bread Loaf</span>
										</label>
									</div>
								</div> -->
							</div>
							<div class="row mt-7">
								<div class="col-md-12" style="text-align: center;">
									<div class="form-group">
										<button type="submit" class="btn btn-primary">Add</button>
									</div>
								</div>
							</div>
						
					</div>
					<!-- <div class="modal-footer">
						<button type="submit" class="btn btn-secondary">Add</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
					</div> -->
				</form>
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
							<div class="col-md-9">
								<div class="form-group">
									<h2 class="event-name" style="    margin-top: 9%;
    margin-left: 20px;
    margin-bottom: 0px !important;
    font-size: 1.2rem;
    line-height: 30px;"></h2>
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
<!-- Default calendar -->
<script src="<?=base_url();?>assets/plugins/calendar/underscore-min.js"></script>
<script src="<?=base_url();?>assets/plugins/calendar/moment.js"></script>
<script src="<?=base_url();?>assets/plugins/calendar/calendar.js"></script>
<!-- <script src="<?=base_url();?>assets/plugins/calendar/demo.js"></script> -->
<script src="<?=base_url();?>assets/plugins/jquery.rating/jquery.rating-stars.js"></script>
<script src='<?=base_url();?>assets/plugins/calendar/calendar.min.js'></script>

<!--  -->
<script type="text/javascript">
	var base_url="<?=base_url();?>";
</script>
<script src='<?=base_url();?>assets/js/custom/calendar.js?v=1'></script>