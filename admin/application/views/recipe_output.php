<?php
require_once('header.php');
require_once('sidebar.php');
require_once('recipe_header.php');

?>
<style>
  .warning {display:none;}
  @media all {
    #graphic_display {text-align: center;}
    #graphic_display_image_container svg {
      width:100%;
      height:100%;
    }
    #graphic_display_image_container .ver svg {
      width:50%;
      height:50%;
    }
  }
</style>
<style>
  /*  Custom Nutrient lines  */
  @media all {
  #Sugar_Tot .nutrient_name, #FA_Sat .nutrient_name {
      text-indent: 10px;
  }
  }
</style>

	<div class="row recipe-overview">
		<div class="col-md-12">
			<div class="card">
				<div class="pri-header">
					<h3 class="mr-1 mb-0">Welcome to Reports
					</h3>
				</div>
				<div class="card-body">
					<ul class="list-unstyled mt-3 mb-4">
					  	<li class="border-bottom-0 p-1"><label>1. Select an output layout (note: Preset layouts are less customisable).
						<li class="border-bottom-0 p-1"><label>2. Check the Preview is accurate to </<li>your needs.
						<li class="border-bottom-0 p-1"><label>3. Select required customisations.</label><li>
						<li class="border-bottom-0 p-1"><label>4. Click the download button in the </<li>Preview card to download as PDF.</label></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3">
			<div class="card">
				<div class="pri-header">
					<h3 class="mr-1 mb-0">Layout
					</h3>
				</div>
				<div class="card-body">
					<div class="list-group">
						<a href="#" class="list-group-item list-group-item-action flex-column align-items-start active">
							<div class="d-flex w-100 justify-content-between">
								<h5 class="mb-1">Standard</h5>
							</div>
						</a>
						<a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
							<div class="d-flex w-100 justify-content-between">
								<h5 class="mb-1">Preset</h5>
							</div>
						</a>
						<a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
							<div class="d-flex w-100 justify-content-between">
								<h5 class="mb-1">Graphics</h5>
							</div>
						</a>
					</div>
				</div>
			</div>
			<div class="card">
				<div class="pri-header">
					<h3 class="mr-1 mb-0">Customise
					</h3>
				</div>
				<div class="card-body">
					<div class="card">
						<div class="card-header card-header-customize">
							<h4 class="mr-1 mb-0">Picture
							</h4>
						</div>
						<div class="card-body">
							<div class="custom-controls-stacked">
								<label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1" checked="">
									<span class="custom-control-label">Picture</span>
								</label>
							</div>
						</div>
					</div>
					<div class="card">
						<div class="card-header card-header-customize">
							<h4 class="mr-1 mb-0">Serving Size
							</h4>
						</div>
						<div class="card-body">
							<div class="custom-controls-stacked">
								<label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1" checked="">
									<span class="custom-control-label">Gross weight</span>
								</label>
								<label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1" checked="">
									<span class="custom-control-label">Nett weight after cooking</span>
								</label>
								<label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1" checked="">
									<span class="custom-control-label">Serving size</span>
								</label>
								<label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1" checked="">
									<span class="custom-control-label">Number of servings</span>
								</label>
							</div>
						</div>
					</div>
					<div class="card">
						<div class="card-header card-header-customize">
							<h4 class="mr-1 mb-0">Pack Size
							</h4>
						</div>
						<div class="card-body">
							<div class="custom-controls-stacked">
								<label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1" checked="">
									<span class="custom-control-label">Pack Size</span>
								</label>
								<label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1" checked="">
									<span class="custom-control-label"> Servings per Pack</span>
								</label>
							</div>
						</div>
					</div>
					<div class="card">
						<div class="card-header card-header-customize">
							<h4 class="mr-1 mb-0">Ingredients and Allergens
							</h4>
						</div>
						<div class="card-body">
							<div class="custom-controls-stacked">
								<label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1" checked="">
									<span class="custom-control-label">Declaration</span>
								</label>
								<label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1" checked="">
									<span class="custom-control-label">Breakdown</span>
								</label>
							</div>
						</div>
					</div>
					<div class="card">
						<div class="card-header card-header-customize">
							<h4 class="mr-1 mb-0">Notes
							</h4>
						</div>
						<div class="card-body">
							<div class="custom-controls-stacked">
								<label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1" checked="">
									<span class="custom-control-label">Notes</span>
								</label>
							</div>
						</div>
					</div>
					<div class="card">
						<div class="card-header card-header-customize">
							<h4 class="mr-1 mb-0">Graphics
							</h4>
						</div>
						<div class="card-body">
							<div class="custom-controls-stacked">
								<label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1" checked="">
									<span class="custom-control-label">UK/EU 1</span>
								</label>
								<label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1" checked="">
									<span class="custom-control-label">UK/EU 2</span>
								</label>
								<label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1" checked="">
									<span class="custom-control-label">UK/EU 2 (vertical)</span>
								</label>
								<label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1" checked="">
									<span class="custom-control-label">UK/EU Drinks 1</span>
								</label>
								<label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1" checked="">
									<span class="custom-control-label">UK/EU Drinks 2</span>
								</label>
								<label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1" checked="">
									<span class="custom-control-label">UK/EU Drinks 2 (vertical)</span>
								</label>
								<label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1" checked="">
									<span class="custom-control-label">Typical Values</span>
								</label>
								<label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1" checked="">
									<span class="custom-control-label">Nutrition Facts</span>
								</label>
								<label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1" checked="">
									<span class="custom-control-label">Nutrition Facts Compact</span>
								</label>
								<label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1" checked="">
									<span class="custom-control-label">Nutrition Facts (horizontal)</span>
								</label>
								<label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1" checked="">
									<span class="custom-control-label">Nutrition Facts Compact (horizontal)
									</span>
								</label>
								<label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1" checked="">
									<span class="custom-control-label">Facts Up Front (horizontal)
									</span>
								</label>
								<label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1" checked="">
									<span class="custom-control-label">Facts Up Front, tiny</span>
								</label>
								<label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1" checked="">
									<span class="custom-control-label">Nutri Score</span>
								</label>
								<label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1" checked="">
									<span class="custom-control-label">Nutri Score Drinks</span>
								</label>
								<label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1" checked="">
									<span class="custom-control-label">Nutri Score Breakdown</span>
								</label>
								<label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1" checked="">
									<span class="custom-control-label">Nutri Score Drinks Breakdown</span>
								</label>
							</div>
						</div>
					</div>
					<div class="card">
						<div class="card-header card-header-customize">
							<h4 class="mr-1 mb-0">Nutrients
							</h4>
						</div>
						<div class="card-body">
							<div class="custom-controls-stacked">
								<label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1" checked="">
									<span class="custom-control-label">Nutrients</span>
								</label>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-9">
			<div class="card">
				<div class="pri-header">
					<h3 class="mr-1 mb-0">Preview
					</h3>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-12">
							<h3 class="text-center">Thai Green Curry (Sample recipe)</h3>
						</div>
						<div class="col-md-6">
							<div class="" id="share_general_picture">
								<div class="image_container mb-7">
									<img width="100%" src="<?=base_url();?>assets/images/food.jpg">
								</div>
							</div>
							<div class="card">
								<div class="card-header">
									<h4 class="mr-1 mb-0">Serving Size
									</h4>
								</div>
								<div class="card-body">
									<div class="row" id="share_general_gross_weight">
										<div class="col-md-9">Gross weight</div>
										<div class="col-md-3 p-r-1 text-right">170.5g</div>
									</div>
									<div class="row" id="share_general_nett_weight">
										<div class="col-md-9">Nett weight after cooking</div>
										<div class="col-md-3 p-r-1 text-right">100g</div>
									</div>
									<div class="row" id="share_general_serving_size">
										<div class="col-md-9">Serving size</div>
										<div class="col-md-3 p-r-1 text-right">150g</div>
									</div>
									<div class="row" id="share_general_servings">
										<div class="col-md-9">Number of servings</div>
										<div class="col-md-3 p-r-1 text-right">0.67</div>
									</div>
								</div>
							</div>
							<div class="card">
								<div class="card-header">
									<h4 class="mr-1 mb-0">Pack Size
									</h4>
								</div>
								<div class="card-body">
									<div class="row" id="share_general_pack_size">
										<div class="col-md-9">Pack size</div>
										<div class="col-md-3 text-right">100.0g</div>
									</div>
									<div class="hidden row" id="share_general_servings_per_pack">
										<div class="col-md-9">Number of servings</div>
										<div class="col-md-3 text-right">0.67</div>
									</div>
								</div>
							</div>
							<div class="card">
								<div class="card-header">
									<h4 class="mr-1 mb-0">Nutrients
									</h4>
								</div>
								<div class="card-body">
									<div class="nutritionals_table">
										<div id="header_row">
											<div class="col-md-5 nutrient_name"></div>
											<div class="col-md-3 text-center trace">per 100g</div>
											<div class="col-md-4 text-center trace">
												per
												<span class="serving_size">150</span>g serving
											</div>
										</div>
										<div class="common nutrient row" data-energ_kj="true" data-category="common" id="Energ_KJ">
											<div class="col-md-5 nutrient_name">Energy</div>
											<div class="col-md-3 trace per_100 p-0">
												<div class="col-md-6 p-0 text-right nutrient_value per_100">569.1</div>
												<div class="col-md-6 p-0 nutrient_measure">kJ</div>
											</div>
											<div class="col-md-4 trace per_portion">
												<div class="col-md-6 p-0 text-right nutrient_value per_portion">853.7</div>
												<div class="col-md-6 p-0 nutrient_measure">kJ</div>
											</div>
										</div>
										<div class="common nutrient row" data-energ_kcal="true" data-category="common" id="Energ_Kcal">
											<div class="col-md-5 nutrient_name">Energy</div>
											<div class="col-md-3 trace per_100 p-0">
												<div class="col-md-6 p-0 text-right nutrient_value per_100">136.9</div>
												<div class="col-md-6 p-0 nutrient_measure">kcal</div>
											</div>
											<div class="col-md-4 trace per_portion">
												<div class="col-md-6 p-0 text-right nutrient_value per_portion">205.4</div>
												<div class="col-md-6 p-0 nutrient_measure">kcal</div>
											</div>
										</div>
										<div class="common nutrient row" data-lipid_tot="true" data-category="common" id="Lipid_Tot">
											<div class="col-md-5 nutrient_name">Fat</div>
											<div class="col-md-3 trace per_100 p-0"><div class="col-md-6 p-0 text-right nutrient_value per_100">10.4</div><div class="col-md-6 p-0 nutrient_measure">g</div></div>
											<div class="col-md-4 trace per_portion"><div class="col-md-6 p-0 text-right nutrient_value per_portion">15.6</div><div class="col-md-6 p-0 nutrient_measure">g</div></div>
										</div>
										<div class="common nutrient row" data-fa_sat="true" data-category="common" id="FA_Sat">
											<div class="col-md-5 nutrient_name">  of which saturates</div>
											<div class="col-md-3 trace per_100 p-0"><div class="col-md-6 p-0 text-right nutrient_value per_100">8.8</div><div class="col-md-6 p-0 nutrient_measure">g</div></div>
											<div class="col-md-4 trace per_portion"><div class="col-md-6 p-0 text-right nutrient_value per_portion">13.2</div><div class="col-md-6 p-0 nutrient_measure">g</div></div>
										</div>
										<div class="common nutrient row" data-fa_mono="true" data-category="common" id="FA_Mono">
											<div class="col-md-5 nutrient_name">Fatty Acids Monounsaturated</div>
											<div class="col-md-3 trace per_100 p-0"><div class="col-md-6 p-0 text-right nutrient_value per_100">0.6</div><div class="col-md-6 p-0 nutrient_measure">g</div></div>
											<div class="col-md-4 trace per_portion"><div class="col-md-6 p-0 text-right nutrient_value per_portion">0.9</div><div class="col-md-6 p-0 nutrient_measure">g</div></div>
										</div>
										<div class="common nutrient row" data-fa_poly="true" data-category="common" id="FA_Poly">
											<div class="col-md-5 nutrient_name">Fatty Acids Polyunsaturated</div>
											<div class="col-md-3 trace per_100 p-0">
												<div class="col-md-6 p-0 text-right nutrient_value per_100">0.3</div>
												<div class="col-md-6 p-0 nutrient_measure">g</div>
											</div>
											<div class="col-md-4 trace per_portion">
												<div class="col-md-6 p-0 text-right nutrient_value per_portion">0.5</div>
												<div class="col-md-6 p-0 nutrient_measure">g</div>
											</div>
										</div>
										<div class="common nutrient row" data-fa_trans="true" data-category="common" id="FA_Trans">
											<div class="col-md-5 nutrient_name">Trans Fatty Acids</div>
											<div class="col-md-3 trace per_100 p-0">trace</div>
											<div class="col-md-4 trace per_portion">trace</div>
										</div>
										<div class="common nutrient row" data-carbohydrt="true" data-category="common" id="Carbohydrt">
											<div class="col-md-5 nutrient_name">Carbohydrate</div>
											<div class="col-md-3 trace per_100 p-0"><div class="col-md-6 p-0 text-right nutrient_value per_100">9.6</div><div class="col-md-6 p-0 nutrient_measure">g</div></div>
											<div class="col-md-4 trace per_portion"><div class="col-md-6 p-0 text-right nutrient_value per_portion">14.3</div><div class="col-md-6 p-0 nutrient_measure">g</div></div>
										</div>
										<div class="common nutrient row" data-sugar_tot="true" data-category="common" id="Sugar_Tot">
											<div class="col-md-5 nutrient_name">of which sugars</div>
											<div class="col-md-3 trace per_100 p-0"><div class="col-md-6 p-0 text-right nutrient_value per_100">2.9</div><div class="col-md-6 p-0 nutrient_measure">g</div></div>
											<div class="col-md-4 trace per_portion"><div class="col-md-6 p-0 text-right nutrient_value per_portion">4.3</div><div class="col-md-6 p-0 nutrient_measure">g</div></div>
										</div>
										<div class="common nutrient row" data-sugar_added="true" data-category="common" id="Sugar_Added">
											<div class="col-md-5 nutrient_name">Added Sugar</div>
											<div class="col-md-3 trace per_100 p-0"><div class="col-md-6 p-0 text-right nutrient_value per_100">0.0</div><div class="col-md-6 p-0 nutrient_measure">g</div></div>
											<div class="col-md-4 trace per_portion"><div class="col-md-6 p-0 text-right nutrient_value per_portion">0.0</div><div class="col-md-6 p-0 nutrient_measure">g</div></div>
										</div>
										<div class="common nutrient row" data-fiber_td="true" data-category="common" id="Fiber_TD">
											<div class="col-md-5 nutrient_name">Fibre</div>
											<div class="col-md-3 trace per_100 p-0"><div class="col-md-6 p-0 text-right nutrient_value per_100">2.0</div><div class="col-md-6 p-0 nutrient_measure">g</div></div>
											<div class="col-md-4 trace per_portion"><div class="col-md-6 p-0 text-right nutrient_value per_portion">3.1</div><div class="col-md-6 p-0 nutrient_measure">g</div></div>
										</div>
										<div class="common nutrient row" data-protein="true" data-category="common" id="Protein">
											<div class="col-md-5 nutrient_name">Protein</div>
											<div class="col-md-3 trace per_100 p-0"><div class="col-md-6 p-0 text-right nutrient_value per_100">1.7</div><div class="col-md-6 p-0 nutrient_measure">g</div></div>
											<div class="col-md-4 trace per_portion"><div class="col-md-6 p-0 text-right nutrient_value per_portion">2.5</div><div class="col-md-6 p-0 nutrient_measure">g</div></div>
										</div>
										<div class="common nutrient row" data-salt="true" data-category="common" id="Salt">
										<div class="col-md-5 nutrient_name">Salt</div>
										<div class="col-md-3 trace per_100 p-0"><div class="col-md-6 p-0 text-right nutrient_value per_100">0.59</div><div class="col-md-6 p-0 nutrient_measure">g</div></div>
										<div class="col-md-4 trace per_portion"><div class="col-md-6 p-0 text-right nutrient_value per_portion">0.89</div><div class="col-md-6 p-0 nutrient_measure">g</div></div>
										</div>
										<div class="common nutrient row" data-sodium="true" data-category="common" id="Sodium">
										<div class="col-md-5 nutrient_name">Sodium</div>
										<div class="col-md-3 trace per_100 p-0"><div class="col-md-6 p-0 text-right nutrient_value per_100">233.5</div><div class="col-md-6 p-0 nutrient_measure">mg</div></div>
										<div class="col-md-4 trace per_portion"><div class="col-md-6 p-0 text-right nutrient_value per_portion">350.3</div><div class="col-md-6 p-0 nutrient_measure">mg</div></div>
										</div>
										<div class="nutrient row vitamins" data-vit_a_iu="true" data-category="vitamins" id="Vit_A_IU">
										<div class="col-md-5 nutrient_name">Vitamin A IU</div>
										<div class="col-md-3 trace per_100 p-0"><div class="col-md-6 p-0 text-right nutrient_value per_100">71.3</div><div class="col-md-6 p-0 nutrient_measure">IU</div></div>
										<div class="col-md-4 trace per_portion"><div class="col-md-6 p-0 text-right nutrient_value per_portion">106.9</div><div class="col-md-6 p-0 nutrient_measure">IU</div></div>
										</div>
										<div class="nutrient row vitamins" data-vit_a_rae="true" data-category="vitamins" id="Vit_A_RAE">
										<div class="col-md-5 nutrient_name">Vitamin A RAE</div>
										<div class="col-md-3 trace per_100 p-0"><div class="col-md-6 p-0 text-right nutrient_value per_100">21.2</div><div class="col-md-6 p-0 nutrient_measure">μg</div></div>
										<div class="col-md-4 trace per_portion"><div class="col-md-6 p-0 text-right nutrient_value per_portion">31.8</div><div class="col-md-6 p-0 nutrient_measure">μg</div></div>
										</div>
										<div class="nutrient row vitamins" data-carotene="true" data-category="vitamins" id="Carotene">
										<div class="col-md-5 nutrient_name">Carotene</div>
										<div class="col-md-3 trace per_100 p-0"><div class="col-md-6 p-0 text-right nutrient_value per_100">127.0</div><div class="col-md-6 p-0 nutrient_measure">μg</div></div>
										<div class="col-md-4 trace per_portion"><div class="col-md-6 p-0 text-right nutrient_value per_portion">190.5</div><div class="col-md-6 p-0 nutrient_measure">μg</div></div>
										</div>
										<div class="nutrient row vitamins" data-alpha_carot="true" data-category="vitamins" id="Alpha_Carot">
										<div class="col-md-5 nutrient_name">Alpha Carotene</div>
										<div class="col-md-3 trace per_100 p-0"><div class="col-md-6 p-0 text-right nutrient_value per_100">21.6</div><div class="col-md-6 p-0 nutrient_measure">μg</div></div>
										<div class="col-md-4 trace per_portion"><div class="col-md-6 p-0 text-right nutrient_value per_portion">32.4</div><div class="col-md-6 p-0 nutrient_measure">μg</div></div>
										</div>
										<div class="nutrient row vitamins" data-beta_carot="true" data-category="vitamins" id="Beta_Carot">
										<div class="col-md-5 nutrient_name">Beta Carotene</div>
										<div class="col-md-3 trace per_100 p-0"><div class="col-md-6 p-0 text-right nutrient_value per_100">116.3</div><div class="col-md-6 p-0 nutrient_measure">μg</div></div>
										<div class="col-md-4 trace per_portion"><div class="col-md-6 p-0 text-right nutrient_value per_portion">174.5</div><div class="col-md-6 p-0 nutrient_measure">μg</div></div>
										</div>
										<div class="nutrient row vitamins" data-retinol="true" data-category="vitamins" id="Retinol">
										<div class="col-md-5 nutrient_name">Retinol</div>
										<div class="col-md-3 trace per_100 p-0"><div class="col-md-6 p-0 text-right nutrient_value per_100">0.0</div><div class="col-md-6 p-0 nutrient_measure">μg</div></div>
										<div class="col-md-4 trace per_portion"><div class="col-md-6 p-0 text-right nutrient_value per_portion">0.0</div><div class="col-md-6 p-0 nutrient_measure">μg</div></div>
										</div>
										<div class="nutrient row vitamins" data-beta_crypt="true" data-category="vitamins" id="Beta_Crypt">
										<div class="col-md-5 nutrient_name">Beta Cryptoxanthin</div>
										<div class="col-md-3 trace per_100 p-0"><div class="col-md-6 p-0 text-right nutrient_value per_100">0.0</div><div class="col-md-6 p-0 nutrient_measure">μg</div></div>
										<div class="col-md-4 trace per_portion"><div class="col-md-6 p-0 text-right nutrient_value per_portion">0.0</div><div class="col-md-6 p-0 nutrient_measure">μg</div></div>
										</div>
										<div class="nutrient row vitamins" data-thiamin="true" data-category="vitamins" id="Thiamin">
										<div class="col-md-5 nutrient_name">Thiamin</div>
										<div class="col-md-3 trace per_100 p-0"><div class="col-md-6 p-0 text-right nutrient_value per_100">0.0</div><div class="col-md-6 p-0 nutrient_measure">mg</div></div>
										<div class="col-md-4 trace per_portion"><div class="col-md-6 p-0 text-right nutrient_value per_portion">0.0</div><div class="col-md-6 p-0 nutrient_measure">mg</div></div>
										</div>
										<div class="nutrient row vitamins" data-riboflavin="true" data-category="vitamins" id="Riboflavin">
										<div class="col-md-5 nutrient_name">Riboflavin</div>
										<div class="col-md-3 trace per_100 p-0"><div class="col-md-6 p-0 text-right nutrient_value per_100">0.0</div><div class="col-md-6 p-0 nutrient_measure">mg</div></div>
										<div class="col-md-4 trace per_portion"><div class="col-md-6 p-0 text-right nutrient_value per_portion">0.1</div><div class="col-md-6 p-0 nutrient_measure">mg</div></div>
										</div>
										<div class="nutrient row vitamins" data-niacin="true" data-category="vitamins" id="Niacin">
										<div class="col-md-5 nutrient_name">Niacin</div>
										<div class="col-md-3 trace per_100 p-0"><div class="col-md-6 p-0 text-right nutrient_value per_100">0.3</div><div class="col-md-6 p-0 nutrient_measure">mg</div></div>
										<div class="col-md-4 trace per_portion"><div class="col-md-6 p-0 text-right nutrient_value per_portion">0.5</div><div class="col-md-6 p-0 nutrient_measure">mg</div></div>
										</div>
									</div>
								</div>
							</div>
							<div class="card">
								<div class="pri-header">
									<h3 class="mr-1 mb-0">Ingredients and Allergens
									</h3>
								</div>
								<div class="card-body">
									<div class="col-md-12" id="share_general_ingredients_declaration">
										<div id="declaration_list_div">
											Green Peppers, Aubergine, Coconut Milk, Water, Thai Green Curry Paste (<b>Fish, Molluscs</b>), Lemon Grass, Coconut Oil, Salt, Sample Recipe (Red Chilli), Shepherd's Pie, Cooked Basmati Rice.
										</div>
										<div class="notice">
											Allergen advice. For allergens, including cereals containing gluten, see ingredients in <b>bold</b>.
										</div>
									</div>
									<div class="col-md-12">
										<hr>
									</div>
									<div class="col-md-12" id="share_general_ingredients_breakdown">
										<div class="ingredients_table">
												<div id="ingredient_list_0" class="row">
													<div class="ingredient_list_percentage col-md-2 text-right">23.5%</div>
													<div class="ingredient_list_weight col-md-2 text-right">35.2g</div>
													<div class="ingredient_list_name col-md-8">Peppers, capsicum, green, raw</div>
												</div>
												<div id="ingredient_list_1" class="row">
													<div class="ingredient_list_percentage col-md-2 text-right">17.6%</div>
													<div class="ingredient_list_weight col-md-2 text-right">26.4g</div>
													<div class="ingredient_list_name col-md-8">Aubergine, raw</div>
												</div>
												<div id="ingredient_list_2" class="row">
													<div class="ingredient_list_percentage col-md-2 text-right">17.6%</div>
													<div class="ingredient_list_weight col-md-2 text-right">26.4g</div>
													<div class="ingredient_list_name col-md-8">Coconut milk</div>
												</div>
												<div id="ingredient_list_3" class="row">
													<div class="ingredient_list_percentage col-md-2 text-right">17.6%</div>
													<div class="ingredient_list_weight col-md-2 text-right">26.4g</div>
													<div class="ingredient_list_name col-md-8">Water, tap, drinking</div>
												</div>
												<div id="ingredient_list_4" class="row">
													<div class="ingredient_list_percentage col-md-2 text-right">11.7%</div>
													<div class="ingredient_list_weight col-md-2 text-right">17.6g</div>
													<div class="ingredient_list_name col-md-8">Thai Green Curry Paste</div>
												</div>
												<div id="ingredient_list_5" class="row">
													<div class="ingredient_list_percentage col-md-2 text-right">5.87%</div>
													<div class="ingredient_list_weight col-md-2 text-right">8.8g</div>
													<div class="ingredient_list_name col-md-8">Lemon grass (citronella), raw</div>
												</div>
										</div>
									</div>
								</div>
							</div>
							<div class="card">
								<div class="pri-header">
									<h3 class="mr-1 mb-0">Notes
									</h3>
								</div>
								<div class="card-body">
									<div class="col-md-12">
										Allergen advice. For allergens, including cereals containing gluten, see ingredients in bold.
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="card">
								<div class="card-header">
									<h4 class="mr-1 mb-0">Graphics
									</h4>
								</div>
								<div class="card-body">
									<?php include('output_graphic.php');?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

	
<?php
require_once('footer.php');
?>
<script src="<?=base_url();?>assets/js/custom/Reciepe.js"></script>

<script type="text/javascript">
	Reciepe.init();
	$('.recipe-tabs').find('.output .card-body').addClass('active');
</script>