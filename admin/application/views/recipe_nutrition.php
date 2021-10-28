<?php
require_once('header.php');
require_once('sidebar.php');
if($create_type=="barmenu")
	require_once('bar_menu.php'); 
else
	require_once('recipe_header.php');

?>

	<div class="row recipe-overview">
		<div class="col-md-12">
			<div class="card">
				<div class="pri-header">
					<h3 class="mr-1 mb-0">Recipe Size
					
					</h3>
				</div>
				<div class="card-body">
					<ul class="list-unstyled">
					  	<li class="border-bottom-0 p-1">
					  		<div class="row font-13">
					  			<div class="col-md-7">
						  			<p style="font-weight: bolder;">Gross Weight</p>
					  			</div>
					  			<div class="col-md-3 fg-line">
						  			<input id="gross_weight" type="text" name="gross_weight" class="form-control input-border-bottom text-right" style="width: 80%;float: left;padding-right: 5px;">
						  			<input type="text" name="gross_weight_unit" class="form-control input-border-bottom" value="g" style="width: 20%;" disabled="">
					  			</div>
					  			<div class="col-md-1">
					  				<!-- <i class="fas fa-pen"></i> -->
					  			</div>
					  		</div>
						</li>
						<li class="border-bottom-0 p-1"  style="display: none;">
					  		<div class="row font-13">
					  			<div class="col-md-7">
						  			<p style="font-weight: bolder;">Net Weight After Cooking</p>
					  			</div>
					  			<div class="col-md-3 fg-line">
						  			<input id="net_weight" type="text" name="net_weight" class="form-control input-border-bottom text-right" value="0.00" style="width: 80%;float: left;padding-right: 5px;">
						  			<input type="text" name="net_weight_unit" class="form-control input-border-bottom" value="g" style="width: 20%;" disabled="">
						  			<input id="weight_loss" type="hidden" name="weight_loss" class="form-control input-border-bottom text-right" value="0">
					  			</div>
					  			<div class="col-md-1">
					  			<!-- 	<i class="fas fa-pen"></i> -->
					  			</div>
					  		</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
		
	</div>
	<div class="row recipe-overview">
		<div class="col-md-6">
			<div class="card">
				<div class="pri-header">
					<h3 class="mr-1 mb-0">Ingredients and Allergens
					</h3>
				</div>
				<div class="card-body">
					<ul class="list-unstyled mt-3 mb-4 ul-allgerens">
						<!-- <li><h4>Allergens</h4></li> -->
						<li class="border-bottom-0 p-2 p-allergens-li" style="text-transform:capitalize;">
						</li>
					  	<li class="border-bottom-0 p-2">
					  		Allergen advice. For allergens, see ingredients in <b style="font-weight: 800;">bold</b>.
					  	</li>
					  	<li class="border-bottom-1 p-2">
					  		Allergens given are indicative only.
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="card">
				<div class="pri-header">
					<h3 class="mr-1 mb-0">Nutrients
					</h3>
				</div>
				<div class="card-body card-padding div-nutrition">
					<div class="hidden-pdf" id="nutritional_selections_recommended">
						<div class="row">
							<div class="col-md-2">Nutrients</div>
							<div class="col-md-10">
								<div class="col-xs-10">
									<a class="btn btn-xs select-recommendation selector waves-effect waves-button waves-float btn-default bgm-blue" data-elements='{"Energ_Kcal":"show", "Energ_Kcal_from_Fat":"show", "Energ_KJ":"show", "Protein":"show", "Lipid_Tot":"show", "FA_Sat":"show", "FA_Mono":"show", "FA_Poly":"show", "FA_Trans":"show", "Carbohydrt":"show", "Sugar_Tot":"show", "Star":"show", "Fiber_TD":"show", "Sodium":"show", "Salt":"show", "Water":"show", "Nitrogen":"show", "Cholestrl":"show", "Potassium":"show", "Calcium":"show", "Magnesium":"show", "Phosphorus":"show", "Iron":"show", "Copper":"show", "Zinc":"show", "Chloride":"show", "Manganese":"show", "Selenium":"show", "Iodine":"show", "Retinol":"show", "Carotene":"show", "Alpha_Carot":"show", "Beta_Carot":"show", "Vit_D_mcg":"show", "Vit_D_IU":"show", "Vit_E":"show", "Thiamin":"show", "Riboflavin":"show", "Niacin":"show", "Tryptophan60":"show", "Vit_B6":"show", "Vit_B12":"show", "Folate_Tot":"show", "Panto_Acid":"show", "Biotin":"show", "Vit_C":"show", "Ash":"show", "Folic_Acid":"show", "Food_Folate":"show", "Folate_DFE":"show", "Choline_Tot":"show", "Vit_A_IU":"show", "Vit_A_RAE":"show", "Beta_Crypt":"show", "Lycopene":"show", "Lut_Zea":"show", "Vit_K":"show", "nutritional_selections_nutrients":"hide","other_nutrient_header":"show","minerals_nutrient_header":"show","vitamins_nutrient_header":"show","common_nutrient_header":"show"}' data-set="groups" id="allr-recommendation">All</a>
									<a class="btn btn-xs select-recommendation selector waves-effect waves-button waves-float btn-default" data-elements='{"Energ_Kcal":"show", "Energ_Kcal_from_Fat":"hide", "Energ_KJ":"show", "Protein":"show", "Lipid_Tot":"show", "FA_Sat":"show", "FA_Mono":"hide", "FA_Poly":"hide", "FA_Trans":"hide", "Carbohydrt":"show", "Sugar_Tot":"show", "Star":"hide", "Fiber_TD":"hide", "Sodium":"hide", "Salt":"show", "Water":"hide", "Nitrogen":"hide", "Cholestrl":"hide", "Potassium":"hide", "Calcium":"hide", "Magnesium":"hide", "Phosphorus":"hide", "Iron":"hide", "Copper":"hide", "Zinc":"hide", "Chloride":"hide", "Manganese":"hide", "Selenium":"hide", "Iodine":"hide", "Retinol":"hide", "Carotene":"hide", "Alpha_Carot":"hide", "Beta_Carot":"hide", "Vit_D_mcg":"hide", "Vit_D_IU":"hide", "Vit_E":"hide", "Thiamin":"hide", "Riboflavin":"hide", "Niacin":"hide", "Tryptophan60":"hide", "Vit_B6":"hide", "Vit_B12":"hide", "Folate_Tot":"hide", "Panto_Acid":"hide", "Biotin":"hide", "Vit_C":"hide", "Ash":"hide", "Folic_Acid":"hide", "Food_Folate":"hide", "Folate_DFE":"hide", "Choline_Tot":"hide", "Vit_A_IU":"hide", "Vit_A_RAE":"hide", "Beta_Crypt":"hide", "Lycopene":"hide", "Lut_Zea":"hide", "Vit_K":"hide", "nutritional_selections_nutrients":"hide","other_nutrient_header":"hide","minerals_nutrient_header":"hide","vitamins_nutrient_header":"hide","common_nutrient_header":"show"}' data-set="groups" id="big8-recommendation">"Big 8"</a>
									<a class="btn btn-xs select-recommendation selector waves-effect waves-button waves-float" data-elements='{"Energ_Kcal":"hide", "Energ_Kcal_from_Fat":"hide","Energ_KJ":"hide", "Protein":"hide", "Lipid_Tot":"hide", "FA_Sat":"hide", "FA_Mono":"hide", "FA_Poly":"hide", "FA_Trans":"hide", "Carbohydrt":"hide", "Sugar_Tot":"hide", "Star":"hide", "Fiber_TD":"hide", "Sodium":"hide", "Salt":"hide", "Water":"hide", "Nitrogen":"hide", "Cholestrl":"hide", "Potassium":"hide", "Calcium":"hide", "Magnesium":"hide", "Phosphorus":"hide", "Iron":"hide", "Copper":"hide", "Zinc":"hide", "Chloride":"hide", "Manganese":"hide", "Selenium":"hide", "Iodine":"hide", "Retinol":"hide", "Carotene":"hide", "Alpha_Carot":"hide", "Beta_Carot":"hide", "Vit_D_mcg":"show", "Vit_D_IU":"show", "Vit_E":"show", "Thiamin":"hide", "Riboflavin":"hide", "Niacin":"hide", "Tryptophan60":"hide", "Vit_B6":"show", "Vit_B12":"show", "Folate_Tot":"hide", "Panto_Acid":"hide", "Biotin":"hide", "Vit_C":"show", "Ash":"hide", "Folic_Acid":"hide", "Food_Folate":"hide", "Folate_DFE":"hide", "Choline_Tot":"hide", "Vit_A_IU":"show", "Vit_A_RAE":"show", "Beta_Crypt":"hide", "Lycopene":"hide", "Lut_Zea":"hide", "Vit_K":"show", "nutritional_selections_nutrients":"hide","other_nutrient_header":"hide","minerals_nutrient_header":"hide","vitamins_nutrient_header":"show","common_nutrient_header":"show"}' data-set="groups" id="vitamins-recommendation">Vitamins</a>
									<!-- <a class="btn btn-xs select-recommendation selector waves-effect waves-button waves-float btn-default btn-select-custom" data-elements='{"nutritional_selections_nutrients":"toggle"}' data-set="groups" id="custom-recommendation">Custom</a> -->
								</div>
							</div>
						</div>
						<hr>
						<div id="nutritional_selections_nutrients" style="display:none;">
							<div class="row">
								<div class="col-md-2">
									<div class="nutrient-selector-header" id="common-selector">
										Main
									</div>
								</div>
								<div class="col-md-10">
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Energ_KJ":"toggle"}' id="Energ_KJ-selector">Energy</div>
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Energ_Kcal":"toggle"}' id="Energ_Kcal-selector">Energy</div>
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Lipid_Tot":"toggle"}' id="Lipid_Tot-selector">Fat</div>
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"FA_Sat":"toggle"}' id="FA_Sat-selector">  of which saturates</div>
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"FA_Mono":"toggle"}' id="FA_Mono-selector">Fatty Acids Monounsaturated</div>
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"FA_Poly":"toggle"}' id="FA_Poly-selector">Fatty Acids Polyunsaturated</div>
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"FA_Trans":"toggle"}' id="FA_Trans-selector">Trans Fatty Acids</div>
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Carbohydrt":"toggle"}' id="Carbohydrt-selector">Carbohydrate</div>
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Sugar_Tot":"toggle"}' id="Sugar_Tot-selector">of which sugars</div>
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Sugar_Added":"toggle"}' id="Sugar_Added-selector">Added Sugar</div>
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Fiber_TD":"toggle"}' id="Fiber_TD-selector">Fibre</div>
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Protein":"toggle"}' id="Protein-selector">Protein</div>
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Salt":"toggle"}' id="Salt-selector">Salt</div>
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Sodium":"toggle"}' id="Sodium-selector">Sodium</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-2">
									<div class="nutrient-selector-header" id="vitamins-selector">
										Vitamins
									</div>
								</div>
								<div class="col-md-10">
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Vit_A_IU":"toggle"}' id="Vit_A_IU-selector">Vitamin A IU</div>
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Vit_A_RAE":"toggle"}' id="Vit_A_RAE-selector">Vitamin A RAE</div>
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Carotene":"toggle"}' id="Carotene-selector">Carotene</div>
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Alpha_Carot":"toggle"}' id="Alpha_Carot-selector">Alpha Carotene</div>
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Beta_Carot":"toggle"}' id="Beta_Carot-selector">Beta Carotene</div>
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Retinol":"toggle"}' id="Retinol-selector">Retinol</div>
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Beta_Crypt":"toggle"}' id="Beta_Crypt-selector">Beta Cryptoxanthin</div>
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Thiamin":"toggle"}' id="Thiamin-selector">Thiamin</div>
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Riboflavin":"toggle"}' id="Riboflavin-selector">Riboflavin</div>
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Niacin":"toggle"}' id="Niacin-selector">Niacin</div>
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Panto_Acid":"toggle"}' id="Panto_Acid-selector">Pantothenic Acid</div>
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Vit_B6":"toggle"}' id="Vit_B6-selector">Vitamin B6</div>
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Folic_Acid":"toggle"}' id="Folic_Acid-selector">Folic Acid</div>
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Folate_DFE":"toggle"}' id="Folate_DFE-selector">Dietary Folate Equivalents</div>
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Food_Folate":"toggle"}' id="Food_Folate-selector">Food Folate</div>
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Folate_Tot":"toggle"}' id="Folate_Tot-selector">Folate</div>
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Vit_B12":"toggle"}' id="Vit_B12-selector">Vitamin B12</div>
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Vit_C":"toggle"}' id="Vit_C-selector">Vitamin C</div>
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Vit_D_IU":"toggle"}' id="Vit_D_IU-selector">Vitamin D IU</div>
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Vit_D_mcg":"toggle"}' id="Vit_D_mcg-selector">Vitamin D MCG</div>
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Vit_E":"toggle"}' id="Vit_E-selector">Vitamin E</div>
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Biotin":"toggle"}' id="Biotin-selector">Biotin</div>
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Vit_K":"toggle"}' id="Vit_K-selector">Vitamin K</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-2">
									<div class="nutrient-selector-header" id="minerals-selector">
										Minerals
									</div>
								</div>
								<div class="col-md-10">
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Calcium":"toggle"}' id="Calcium-selector">Calcium</div>
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Chloride":"toggle"}' id="Chloride-selector">Chloride</div>
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Choline_Tot":"toggle"}' id="Choline_Tot-selector">Choline</div>
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Copper":"toggle"}' id="Copper-selector">Copper</div>
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Iodine":"toggle"}' id="Iodine-selector">Iodine</div>
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Iron":"toggle"}' id="Iron-selector">Iron</div>
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Magnesium":"toggle"}' id="Magnesium-selector">Magnesium</div>
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Manganese":"toggle"}' id="Manganese-selector">Manganese</div>
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Nitrogen":"toggle"}' id="Nitrogen-selector">Nitrogen</div>
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Phosphorus":"toggle"}' id="Phosphorus-selector">Phosphorus</div>
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Potassium":"toggle"}' id="Potassium-selector">Potassium</div>
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Selenium":"toggle"}' id="Selenium-selector">Selenium</div>
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Tryptophan60":"toggle"}' id="Tryptophan60-selector">Tryptophan/60</div>
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Zinc":"toggle"}' id="Zinc-selector">Zinc</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-2">
									<div class="nutrient-selector-header" id="other-selector">
										Other
									</div>
								</div>
								<div class="col-md-10">
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Ash":"toggle"}' id="Ash-selector">Ash</div>
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Cholestrl":"toggle"}' id="Cholestrl-selector">Cholesterol</div>
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Lut_Zea":"toggle"}' id="Lut_Zea-selector">Lutein Zeaxanthin</div>
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Lycopene":"toggle"}' id="Lycopene-selector">Lycopene</div>
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Star":"toggle"}' id="Star-selector">Starch</div>
									<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Water":"toggle"}' id="Water-selector">Water</div>
								</div>
							</div>
							<hr class="hidden-pdf">
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
<script src="<?=base_url();?>assets/js/custom/Reciepe.js?v=5"></script>

<script type="text/javascript">
	Reciepe.base_url="<?=base_url();?>";
	Reciepe.recipe_id="<?=$recipe_id;?>";
	Reciepe.alacalc_recipe_id="<?=$recipe['alacal_recipe_id'];?>";
	Reciepe.is_nutrition=1;
	Reciepe.create_type="<?=$create_type;?>";
	Reciepe.is_category_prices="<?=$_SESSION['is_category_prices'];?>";
	Reciepe.is_alacalc_recipe="<?=$_SESSION['is_alacalc_recipe'];?>";
	Reciepe.init();
	$('.recipe-tabs').find('.nutrition .card-body').addClass('active');
</script>