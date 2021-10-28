<div class='all-menu-details menu-with-2grid thumb'>
		<h5 id='menu-title'><?php echo ucfirst($rw1['title']); ?></h5>
		<div class='row' id='menu-content'>
		<?php	
			
			
			$i=0;
			while($row = mysqli_fetch_assoc($m))
			{
				if($i==0){
					echo "<div class='col-md-6'>";
				}
				if($i==$r/2){
					echo "</div><div class='col-md-6'>";
				}
				if($i==$r){
					echo "</div>";
				}
				$recipe_id = $row['id'];
				$qry1 = "select im.*,i.long_desc,i.declaration_name,i.data_source from ingredient_items im inner JOIN ingredient i on i.alacalc_id=im.ingredient_id WHERE im.recipe_id='$recipe_id'";
				$res1 = mysqli_query($con,$qry1);
				if(mysqli_num_rows($res1) > 0)
				{
					$ingredients = array();
					while($rw1 = mysqli_fetch_assoc($res1))
					{
						$ingredients[] = $rw1['declaration_name'];
					}
					$ingredientsList = implode(', ', $ingredients);
				}
				else{ $ingredientsList = 'Ingredients not found.'; }
?>
<div class='row' >
				<div class='col-md-12'>
					<div class='item-list'>
						<div class='all-details'>
							<div class='visible-option'>
								<div class='details'>
									<h6><?php echo $row['name']; ?></h6>
									<p class='for-list'><?php echo $ingredientsList; ?></p>
								</div>

								<div class='price-option fl'>
									<h4>
										<?php 
											$menuPrice = $row['price'];
											if(($menuPrice == 'Recipe Price') || ($menuPrice == '')) 
											{ echo '0.00'; }
											else{ echo $menuPrice; }
										?>
									</h4>
									<button class='toggle' onclick='toggleNutrition(this,'<?php echo $row['id'];?>','<?php echo $row['alacal_recipe_id'];?>');'>Nutrition</button>
								</div>
								<div class='qty-cart text-center clearfix'>
									<div style='margin-top: 3em;'>
										<?php 
											$menuType = $row['recipe_type'];
											if($menuType == '') { ?> 
										<img src='img/NonVeg.png' alt=''>
										<?php	}else if($menuType == 'veg'){ ?>
										<img src='img/Veg.png' alt='Veg menu'>
										<?php	}else if($menuType == 'nonveg'){ ?>
										<img src='img/NonVeg.png' alt='Nonveg menu'>
										<?php } ?>
									</div>
								</div>
							</div>
							<!-- end .qty-cart -->

							<div class='dropdown-option clearfix'>
								<div class='dropdown-details'>
									<div class='row mt30'>
										<div class='col-md-5'>
											<img class='' src='<?php echo $image_path.$row['recipe_image']; ?>' alt='' style='height:145px;width:157px;'>
											<input id='gross_weight' type='hidden' name='gross_weight' class='form-control input-border-bottom text-right gross-weight <?php echo $row['alacal_recipe_id'];?>' style='width: 80%;float: left;padding-right: 5px;border: none;color: #fff;background-color: #fff;'>
										</div>
										
										<div class='col-md-7'>
											<h5 style='color:#37A445;'>Allergens</h5>
											<hr>
											<ul class='list-unstyled mt-3 mb-4 ul-allgerens <?php echo $row['alacal_recipe_id'];?>'>
												<!-- <li><h4>Allergens</h4></li> -->
												<li class='border-bottom-0 p-2 p-allergens-li <?php echo $row['alacal_recipe_id'];?>' style='text-transform:capitalize;'>
												<span class='foodnai-info-loader'>Loading Information...</span>
												</li>
											</ul>
											<span class='foodnai-info-loader'>Loading Information...</span>
											
										</div>
									</div>
									<div class='row mt30'>
										<div class='col-md-3'>
											<div style='padding:0px;'>2,854<br>Reviews</div>
										</div>
										<div class='col-md-4'>
											<i class='glyphicon glyphicon-star review'></i>	
											<i class='glyphicon glyphicon-star review'></i>	
											<i class='glyphicon glyphicon-star review'></i>	
											<i class='glyphicon glyphicon-star review'></i>	
											<i class='glyphicon glyphicon-star-empty review'></i>
											<br>4 star average
										</div>
										<div class='col-md-5'>
											<h5 style='color:#37A445; text-transform: capitalize; margin-bottom: 7px; margin-left: 7px;'>Rate this menuitem</h5>
											<i class='glyphicon glyphicon-star bigstar' onclick='enterEmail();'></i>
											<i class='glyphicon glyphicon-star bigstar'></i>
											<i class='glyphicon glyphicon-star bigstar'></i>
											<i class='glyphicon glyphicon-star bigstar'></i>
											<i class='glyphicon glyphicon-star bigstar'></i>
										</div>
									</div>
									<div class='row mt30'>
										<div class='col-md-12'>
											<div class='card-body card-padding div-nutrition <?php echo $row['alacal_recipe_id'];?>'>
											<div class='hidden-pdf' id='nutritional_selections_recommended'>
												<div class='row'>
													<div class='col-md-6'><h5 style='color:#37A445;'>Nutrition Information</h5></div>
														<div class='col-md-6'>
															<div class='col-xs-10'>
																<a class='btn btn-xs select-recommendation selector waves-effect waves-button waves-float btn-secondary bgm-blue' data-elements="{'Energ_Kcal':'show', 'Energ_Kcal_from_Fat':'show', 'Energ_KJ':'show', 'Protein':'show', 'Lipid_Tot':'show', 'FA_Sat':'show', 'FA_Mono':'show', 'FA_Poly':'show', 'FA_Trans':'show', 'Carbohydrt':'show', 'Sugar_Tot':'show', 'Star':'show', 'Fiber_TD':'show', 'Sodium':'show', 'Salt':'show', 'Water':'show', 'Nitrogen':'show', 'Cholestrl':'show', 'Potassium':'show', 'Calcium':'show', 'Magnesium':'show', 'Phosphorus':'show', 'Iron':'show', 'Copper':'show', 'Zinc':'show', 'Chloride':'show', 'Manganese':'show', 'Selenium':'show', 'Iodine':'show', 'Retinol':'show', 'Carotene':'show', 'Alpha_Carot':'show', 'Beta_Carot':'show', 'Vit_D_mcg':'show', 'Vit_D_IU':'show', 'Vit_E':'show', 'Thiamin':'show', 'Riboflavin':'show', 'Niacin':'show', 'Tryptophan60':'show', 'Vit_B6':'show', 'Vit_B12':'show', 'Folate_Tot':'show', 'Panto_Acid':'show', 'Biotin':'show', 'Vit_C':'show', 'Ash':'show', 'Folic_Acid':'show', 'Food_Folate':'show', 'Folate_DFE':'show', 'Choline_Tot':'show', 'Vit_A_IU':'show', 'Vit_A_RAE':'show', 'Beta_Crypt':'show', 'Lycopene':'show', 'Lut_Zea':'show', 'Vit_K':'show', 'nutritional_selections_nutrients':'hide','other_nutrient_header':'show','minerals_nutrient_header':'show','vitamins_nutrient_header':'show','common_nutrient_header':'show'}" data-set='groups' id='allr-recommendation' style='position:relative;float:left;'>All</a>
																<a class='btn btn-xs select-recommendation selector waves-effect waves-button waves-float btn-secondary' data-elements="{'Energ_Kcal':'show', 'Energ_Kcal_from_Fat':'hide', 'Energ_KJ':'show', 'Protein':'show', 'Lipid_Tot':'show', 'FA_Sat':'show', 'FA_Mono':'hide', 'FA_Poly':'hide', 'FA_Trans':'hide', 'Carbohydrt':'show', 'Sugar_Tot':'show', 'Star':'hide', 'Fiber_TD':'hide', 'Sodium':'hide', 'Salt':'show', 'Water':'hide', 'Nitrogen':'hide', 'Cholestrl':'hide', 'Potassium':'hide', 'Calcium':'hide', 'Magnesium':'hide', 'Phosphorus':'hide', 'Iron':'hide', 'Copper':'hide', 'Zinc':'hide', 'Chloride':'hide', 'Manganese':'hide', 'Selenium':'hide', 'Iodine':'hide', 'Retinol':'hide', 'Carotene':'hide', 'Alpha_Carot':'hide', 'Beta_Carot':'hide', 'Vit_D_mcg':'hide', 'Vit_D_IU':'hide', 'Vit_E':'hide', 'Thiamin':'hide', 'Riboflavin':'hide', 'Niacin':'hide', 'Tryptophan60':'hide', 'Vit_B6':'hide', 'Vit_B12':'hide', 'Folate_Tot':'hide', 'Panto_Acid':'hide', 'Biotin':'hide', 'Vit_C':'hide', 'Ash':'hide', 'Folic_Acid':'hide', 'Food_Folate':'hide', 'Folate_DFE':'hide', 'Choline_Tot':'hide', 'Vit_A_IU':'hide', 'Vit_A_RAE':'hide', 'Beta_Crypt':'hide', 'Lycopene':'hide', 'Lut_Zea':'hide', 'Vit_K':'hide', 'nutritional_selections_nutrients':'hide','other_nutrient_header':'hide','minerals_nutrient_header':'hide','vitamins_nutrient_header':'hide','common_nutrient_header':'show'}" data-set='groups' id='big8-recommendation' style='position:relative;float:left;'>Big 8</a>
																<a class='btn btn-xs select-recommendation selector waves-effect waves-button waves-float btn-secondary' data-elements="{'Energ_Kcal':'hide', 'Energ_Kcal_from_Fat':'hide','Energ_KJ':'hide', 'Protein':'hide', 'Lipid_Tot':'hide', 'FA_Sat':'hide', 'FA_Mono':'hide', 'FA_Poly':'hide', 'FA_Trans':'hide', 'Carbohydrt':'hide', 'Sugar_Tot':'hide', 'Star':'hide', 'Fiber_TD':'hide', 'Sodium':'hide', 'Salt':'hide', 'Water':'hide', 'Nitrogen':'hide', 'Cholestrl':'hide', 'Potassium':'hide', 'Calcium':'hide', 'Magnesium':'hide', 'Phosphorus':'hide', 'Iron':'hide', 'Copper':'hide', 'Zinc':'hide', 'Chloride':'hide', 'Manganese':'hide', 'Selenium':'hide', 'Iodine':'hide', 'Retinol':'hide', 'Carotene':'hide', 'Alpha_Carot':'hide', 'Beta_Carot':'hide', 'Vit_D_mcg':'show', 'Vit_D_IU':'show', 'Vit_E':'show', 'Thiamin':'hide', 'Riboflavin':'hide', 'Niacin':'hide', 'Tryptophan60':'hide', 'Vit_B6':'show', 'Vit_B12':'show', 'Folate_Tot':'hide', 'Panto_Acid':'hide', 'Biotin':'hide', 'Vit_C':'show', 'Ash':'hide', 'Folic_Acid':'hide', 'Food_Folate':'hide', 'Folate_DFE':'hide', 'Choline_Tot':'hide', 'Vit_A_IU':'show', 'Vit_A_RAE':'show', 'Beta_Crypt':'hide', 'Lycopene':'hide', 'Lut_Zea':'hide', 'Vit_K':'show', 'nutritional_selections_nutrients':'hide','other_nutrient_header':'hide','minerals_nutrient_header':'hide','vitamins_nutrient_header':'show','common_nutrient_header':'show'}" data-set='groups' id='vitamins-recommendation' style='position:relative;float:left;'>Vitamins</a>
																<!-- <a class="btn btn-xs select-recommendation selector waves-effect waves-button waves-float btn-default btn-select-custom" data-elements='{"nutritional_selections_nutrients":"toggle"}' data-set="groups" id="custom-recommendation">Custom</a> -->
															</div>
														</div>
													</div>
													<hr>
													<span class='foodnai-info-loader'>Loading Information...</span>
													<div id='nutritional_selections_nutrients' style='display:none;'>
														<div class='row'>
															<div class='col-md-2'>
																<div class='nutrient-selector-header' id='common-selector'>
																	Main
																</div>
															</div>
															<div class='col-md-10'>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements="{'Energ_KJ':'toggle'}" id='Energ_KJ-selector'>Energy</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements="{'Energ_Kcal':'toggle'}" id='Energ_Kcal-selector'>Energy</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements="{'Lipid_Tot':'toggle'}" id='Lipid_Tot-selector'>Fat</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements="{'FA_Sat':'toggle'}" id='FA_Sat-selector'>  of which saturates</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements="{'FA_Mono':'toggle'}" id='FA_Mono-selector'>Fatty Acids Monounsaturated</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements="{'FA_Poly':'toggle'}" id='FA_Poly-selector'>Fatty Acids Polyunsaturated</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements="{'FA_Trans':'toggle'}" id='FA_Trans-selector'>Trans Fatty Acids</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements="{'Carbohydrt':'toggle'}" id='Carbohydrt-selector'>Carbohydrate</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements="{'Sugar_Tot':'toggle'}" id='Sugar_Tot-selector'>of which sugars</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements="{'Sugar_Added':'toggle'}" id='Sugar_Added-selector'>Added Sugar</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements="{'Fiber_TD':'toggle'}" id='Fiber_TD-selector'>Fibre</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements="{'Protein':'toggle'}" id='Protein-selector'>Protein</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements="{'Salt':'toggle'}" id='Salt-selector'>Salt</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements="{'Sodium':'toggle'}" id='Sodium-selector'>Sodium</div>
															</div>
														</div>
														<div class='row'>
															<div class='col-md-2'>
																<div class='nutrient-selector-header' id='vitamins-selector'>
																	Vitamins
																</div>
															</div>
															<div class='col-md-10'>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements="{'Vit_A_IU':'toggle'}" id='Vit_A_IU-selector'>Vitamin A IU</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements="{'Vit_A_RAE':'toggle'}" id='Vit_A_RAE-selector'>Vitamin A RAE</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{"Carotene":"toggle"}' id='Carotene-selector'>Carotene</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{"Alpha_Carot":"toggle"}' id='Alpha_Carot-selector'>Alpha Carotene</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{"Beta_Carot":"toggle"}' id='Beta_Carot-selector'>Beta Carotene</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{"Retinol":"toggle"}' id='Retinol-selector'>Retinol</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{"Beta_Crypt":"toggle"}' id='Beta_Crypt-selector'>Beta Cryptoxanthin</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{"Thiamin":"toggle"}' id='Thiamin-selector'>Thiamin</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{"Riboflavin":"toggle"}' id='Riboflavin-selector'>Riboflavin</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{"Niacin":"toggle"}' id='Niacin-selector'>Niacin</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{"Panto_Acid":"toggle"}' id='Panto_Acid-selector'>Pantothenic Acid</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{"Vit_B6":"toggle"}' id='Vit_B6-selector'>Vitamin B6</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{"Folic_Acid":"toggle"}' id='Folic_Acid-selector'>Folic Acid</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{"Folate_DFE":"toggle"}' id='Folate_DFE-selector'>Dietary Folate Equivalents</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{"Food_Folate":"toggle"}' id='Food_Folate-selector'>Food Folate</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{"Folate_Tot":"toggle"}' id='Folate_Tot-selector'>Folate</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{"Vit_B12":"toggle"}' id='Vit_B12-selector'>Vitamin B12</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{"Vit_C":"toggle"}' id='Vit_C-selector'>Vitamin C</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{"Vit_D_IU":"toggle"}' id='Vit_D_IU-selector'>Vitamin D IU</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{"Vit_D_mcg":"toggle"}' id='Vit_D_mcg-selector'>Vitamin D MCG</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{"Vit_E":"toggle"}' id='Vit_E-selector'>Vitamin E</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{"Biotin":"toggle"}' id='Biotin-selector'>Biotin</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{"Vit_K":"toggle"}' id='Vit_K-selector'>Vitamin K</div>
															</div>
														</div>
														<div class='row'>
															<div class='col-md-2'>
																<div class='nutrient-selector-header' id='minerals-selector'>
																	Minerals
																</div>
															</div>
															<div class='col-md-10'>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{"Calcium":"toggle"}' id='Calcium-selector'>Calcium</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{"Chloride":"toggle"}' id='Chloride-selector'>Chloride</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{"Choline_Tot":"toggle"}' id='Choline_Tot-selector'>Choline</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{"Copper":"toggle"}' id='Copper-selector'>Copper</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{"Iodine":"toggle"}' id='Iodine-selector'>Iodine</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{"Iron":"toggle"}' id='Iron-selector'>Iron</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{"Magnesium":"toggle"}' id='Magnesium-selector'>Magnesium</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{"Manganese":"toggle"}' id='Manganese-selector'>Manganese</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{"Nitrogen":"toggle"}' id='Nitrogen-selector'>Nitrogen</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{"Phosphorus":"toggle"}' id='Phosphorus-selector'>Phosphorus</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{"Potassium":"toggle"}' id='Potassium-selector'>Potassium</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{"Selenium":"toggle"}' id='Selenium-selector'>Selenium</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{"Tryptophan60":"toggle"}' id='Tryptophan60-selector'> Tryptophan/60</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{"Zinc":"toggle"}' id='Zinc-selector'>Zinc</div>
															</div>
														</div>
														<div class='row'>
															<div class='col-md-2'>
																<div class='nutrient-selector-header' id='other-selector'>
																	Other
																</div>
															</div>
															<div class='col-md-10'>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{"Ash":"toggle"}' id='Ash-selector'>Ash</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{"Cholestrl":"toggle"}' id='Cholestrl-selector'>Cholesterol</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{"Lut_Zea":"toggle"}' id='Lut_Zea-selector'>Lutein Zeaxanthin</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{"Lycopene":"toggle"}' id='Lycopene-selector'>Lycopene</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{"Star":"toggle"}' id='Star-selector'>Starch</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{"Water":"toggle"}' id='Water-selector'>Water</div>
															</div>
														</div>
														<hr class='hidden-pdf'>
													</div>
												</div>
											</div> 
										</div>
									</div>
								</div>
							</div>
							<!--end .dropdown-option-->
						</div>
						<!-- end .all-details -->
					</div>
					<!-- end .item-list -->

					<!-- end .item-list -->
				</div>
				</div>
	<?php $i++;}?>
	</div> 
	</div> 

	<!--end all-menu-details-->
	<div class='pagination'>
		<ul class='list-inline  text-right'>
		<?php 
		 $totalPages=$totalRecords/$recordsPerPage;
		for($p=0;$p<$totalPages;$p++){?>
			<li class='<?php if($page==$p+1) echo 'active';?> '><a href='javascript:nextRecord('<?php echo $p+1;?>');'><?php echo $p+1;?></a>
			</li>
		<?php }?>
			
		</ul>
	</div>