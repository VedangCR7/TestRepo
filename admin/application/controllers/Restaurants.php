<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: *");
defined('BASEPATH') OR exit('No direct script access allowed');

class Restaurants extends MY_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('menu_group_model');
		$this->load->model('restaurant_model');
		$this->load->model('recipes_model');
	}
	
	public function getmenuitems(){
		$image_path=base_url();
		$recordsPerPage=10;
		$groupid=$_POST['mid'];
		$restId=$_POST['rid'];
		$page=$_POST['page'];
		if(isset($groupid) && $groupid!='')
		{
			$totalRecords=$this->restaurant_model->getAllMenuItems($groupid,$restId);
			$start=($page-1)*$recordsPerPage;
			$menuitems=$this->restaurant_model->getMenuItemsByPage($groupid,$restId,$start,$recordsPerPage);
			$newdata = "<div class='all-menu-details menu-with-2grid thumb'>
					
						<div class='row' id='menu-content'>";
						$i=0;
						$r=count($menuitems);
						if($r>0){
						foreach($menuitems as $row){
							if($i==0){
								$newdata .= "<div class='col-md-6'>";
							}
							if($i==$r/2){
								$newdata .= "</div><div class='col-md-6'>";
							}
							if($i==$r){
								$newdata .= "</div>";
							}
							$recipe_id = $row['id'];
							$ingredientsResult=$this->restaurant_model->getRestaurantMenuIngredients($recipe_id);
							if(isset($ingredientsResult) && count($ingredientsResult)>0){
								$ingredients = array();
								foreach($ingredientsResult as $ing){
									$ingredients[] = $ing['declaration_name'];
								}
								$ingredientsList = implode(', ', $ingredients);
							}
							else{ $ingredientsList = 'Ingredients not found.'; }
							$newdata .= "<div class='row' >
				<div class='col-md-12'>
					<div class='item-list'>
						<div class='all-details'>
							<div class='visible-option'>
								<div class='details'>
									<h6>".$row['name']."</h6>
									<p class='for-list'>".$ingredientsList."</p>
								</div>
								<div class='price-option fl'>
									<h4>";
									$menuPrice = $row['price'];
									if(($menuPrice == 'Recipe Price') || ($menuPrice == '')) 
									{ $newdata .= "0.00"; }
									else{ $newdata .= $menuPrice; }
									$newdata .= "</h4>
									<button class='toggle' onclick='toggleNutrition(this,".$row['id'].",".$row['alacal_recipe_id'].");'>Nutrition</button>
								</div>
								<div class='qty-cart text-center clearfix'>
									<div style='margin-top: 3em;'>";
										$menuType = $row['recipe_type'];
										if($menuType == '') { 
											$newdata .= "<img src='".base_url()."assets/images/NonVeg.png' alt=''>";
										}else if($menuType == 'veg'){ 
											$newdata .= "<img src='".base_url()."assets/images/Veg.png' alt='Veg menu'>";
										}else if($menuType == 'nonveg'){
											$newdata .= "<img src='".base_url()."assets/images/NonVeg.png' alt='Nonveg menu'>";
										} 
						$newdata .=	"</div>
								</div>
							</div>
							<div class='dropdown-option clearfix'>
								<div class='dropdown-details'>
									<div class='row mt30'>
										<div class='col-md-5'>
											<img class='' src='".$image_path.$row['recipe_image']."' alt='' style='height:145px;width:157px;'>
											<input id='gross_weight' type='hidden' name='gross_weight' class='form-control input-border-bottom text-right gross-weight ".$row['alacal_recipe_id']."' style='width: 80%;float: left;padding-right: 5px;border: none;color: #fff;background-color: #fff;'>
										</div>
										
										<div class='col-md-7'>
											<h5 style='color:#37A445;'>Allergens</h5>
											<hr>
											<ul class='list-unstyled mt-3 mb-4 ul-allgerens ".$row['alacal_recipe_id']."'>
												<li class='border-bottom-0 p-2 p-allergens-li ".$row['alacal_recipe_id']."' style='text-transform:capitalize;'>
												<span class='foodnai-info-loader'>'Loading Information...</span>
												</li>
											
											</ul>
											<span class='foodnai-info-loader'>'Loading Information...</span>
											
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
											<div class='card-body card-padding div-nutrition ".$row['alacal_recipe_id']."'>
											<div class='hidden-pdf' id='nutritional_selections_recommended'>
												<div class='row'>
													<div class='col-md-6'><h5 style='color:#37A445;'>Nutrition Information</h5></div>
														<div class='col-md-6'>
															<div class='col-xs-10'>
															<a class='btn btn-xs select-recommendation selector waves-effect waves-button waves-float btn-secondary bgm-blue show-all' data-elements='' data-set='groups' id='allr-recommendation' style='position:relative;float:left;'>All</a>
																<a class='btn btn-xs select-recommendation selector waves-effect waves-button waves-float btn-secondary show-big8' data-elements='' data-set='groups' id='big8-recommendation' style='position:relative;float:left;'>'Big 8'</a>
																<a class='btn btn-xs select-recommendation selector waves-effect waves-button waves-float btn-secondary show-vitamins' data-elements=='' data-set='groups' id='vitamins-recommendation' style='position:relative;float:left;'>Vitamins</a>
																<!-- <a class='btn btn-xs select-recommendation selector waves-effect waves-button waves-float btn-default btn-select-custom' data-elements={'nutritional_selections_nutrients':'toggle'} data-set='groups' id='custom-recommendation'>Custom</a> -->
															</div>
														</div>
													</div>
													<hr>
													<span class='foodnai-info-loader'>'Loading Information...</span>
													<div id='nutritional_selections_nutrients' style='display:none;'>
														<div class='row'>
															<div class='col-md-2'>
																<div class='nutrient-selector-header' id='common-selector'>
																	Main
																</div>
															</div>
															<div class='col-md-10'>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'Energ_KJ':'toggle'}' id='Energ_KJ-selector'>Energy</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'Energ_Kcal':'toggle'}' id='Energ_Kcal-selector'>Energy</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'Lipid_Tot':'toggle'}' id='Lipid_Tot-selector'>Fat</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'FA_Sat':'toggle'}' id='FA_Sat-selector'>  of which saturates</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'FA_Mono':'toggle'}' id='FA_Mono-selector'>Fatty Acids Monounsaturated</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'FA_Poly':'toggle'}' id='FA_Poly-selector'>Fatty Acids Polyunsaturated</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'FA_Trans':'toggle'}' id='FA_Trans-selector'>Trans Fatty Acids</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'Carbohydrt':'toggle'}' id='Carbohydrt-selector'>Carbohydrate</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'Sugar_Tot':'toggle'}' id='Sugar_Tot-selector'>of which sugars</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'Sugar_Added':'toggle'}' id='Sugar_Added-selector'>Added Sugar</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'Fiber_TD':'toggle'}' id='Fiber_TD-selector'>Fibre</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'Protein':'toggle'}' id='Protein-selector'>Protein</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'Salt':'toggle'}' id='Salt-selector'>Salt</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'Sodium':'toggle'}' id='Sodium-selector'>Sodium</div>
															</div>
														</div>
														<div class='row'>
															<div class='col-md-2'>
																<div class='nutrient-selector-header' id='vitamins-selector'>
																	Vitamins
																</div>
															</div>
															<div class='col-md-10'>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'Vit_A_IU':'toggle'}' id='Vit_A_IU-selector'>Vitamin A IU</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'Vit_A_RAE':'toggle'}' id='Vit_A_RAE-selector'>Vitamin A RAE</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'Carotene':'toggle'}' id='Carotene-selector'>Carotene</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'Alpha_Carot':'toggle'}' id='Alpha_Carot-selector'>Alpha Carotene</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'Beta_Carot':'toggle'}' id='Beta_Carot-selector'>Beta Carotene</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'Retinol':'toggle'}' id='Retinol-selector'>Retinol</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'Beta_Crypt':'toggle'}' id='Beta_Crypt-selector'>Beta Cryptoxanthin</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'Thiamin':'toggle'}' id='Thiamin-selector'>Thiamin</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'Riboflavin':'toggle'}' id='Riboflavin-selector'>Riboflavin</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'Niacin':'toggle'}' id='Niacin-selector'>Niacin</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'Panto_Acid':'toggle'}' id='Panto_Acid-selector'>Pantothenic Acid</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'Vit_B6':'toggle'}' id='Vit_B6-selector'>Vitamin B6</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'Folic_Acid':'toggle'}' id='Folic_Acid-selector'>Folic Acid</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'Folate_DFE':'toggle'}' id='Folate_DFE-selector'>Dietary Folate Equivalents</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'Food_Folate':'toggle'}' id='Food_Folate-selector'>Food Folate</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'Folate_Tot':'toggle'}' id='Folate_Tot-selector'>Folate</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'Vit_B12':'toggle'}' id='Vit_B12-selector'>Vitamin B12</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'Vit_C':'toggle'}' id='Vit_C-selector'>Vitamin C</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'Vit_D_IU':'toggle'}' id='Vit_D_IU-selector'>Vitamin D IU</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'Vit_D_mcg':'toggle'}' id='Vit_D_mcg-selector'>Vitamin D MCG</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'Vit_E':'toggle'}' id='Vit_E-selector'>Vitamin E</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'Biotin':'toggle'}' id='Biotin-selector'>Biotin</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'Vit_K':'toggle'}' id='Vit_K-selector'>Vitamin K</div>
															</div>
														</div>
														<div class='row'>
															<div class='col-md-2'>
																<div class='nutrient-selector-header' id='minerals-selector'>
																	Minerals
																</div>
															</div>
															<div class='col-md-10'>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'Calcium':'toggle'}' id='Calcium-selector'>Calcium</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'Chloride':'toggle'}' id='Chloride-selector'>Chloride</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'Choline_Tot':'toggle'}' id='Choline_Tot-selector'>Choline</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'Copper':'toggle'}' id='Copper-selector'>Copper</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'Iodine':'toggle'}' id='Iodine-selector'>Iodine</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'Iron':'toggle'}' id='Iron-selector'>Iron</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'Magnesium':'toggle'}' id='Magnesium-selector'>Magnesium</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'Manganese':'toggle'}' id='Manganese-selector'>Manganese</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'Nitrogen':'toggle'}' id='Nitrogen-selector'>Nitrogen</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'Phosphorus':'toggle'}' id='Phosphorus-selector'>Phosphorus</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'Potassium':'toggle'}' id='Potassium-selector'>Potassium</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'Selenium':'toggle'}' id='Selenium-selector'>Selenium</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'Tryptophan60':'toggle'}' id='Tryptophan60-selector'> Tryptophan/60</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'Zinc':'toggle'}' id='Zinc-selector'>Zinc</div>
															</div>
														</div>
														<div class='row'>
															<div class='col-md-2'>
																<div class='nutrient-selector-header' id='other-selector'>
																	Other
																</div>
															</div>
															<div class='col-md-10'>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{Ash:toggle}' id='Ash-selector'>Ash</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'Cholestrl':'toggle'}' id='Cholestrl-selector'>Cholesterol</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'Lut_Zea':'toggle'}' id='Lut_Zea-selector'>Lutein Zeaxanthin</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'Lycopene':'toggle'}' id='Lycopene-selector'>Lycopene</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'Star':'toggle'}' id='Star-selector'>Starch</div>
																<div class='nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float' data-elements='{'Water':'toggle'}' id='Water-selector'>Water</div>
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
				</div>";
									



					$i++;	}
					$newdata .= "<div class='pagination'>
		<ul class='list-inline  text-right'>";
		
		 $totalPages=$totalRecords/$recordsPerPage;
		for($p=0;$p<$totalPages;$p++){
			$active="";
			if($page==$p+1){
				$active='active';
			}
			$nextR=$p+1;
			$newdata .= "<li class='".$active."'><a href='javascript:nextRecord(".$nextR.")'>".$nextR."</a></li>";
		}
			
		$newdata .= "</ul></div>";
						echo $newdata ;	
	}else{
		echo '<div class="col-md-12" id="tab-2">
		<p>
			<strong>Menu item not found</strong>
		</p>
	</div>';
	}
		}else{
			echo '<div class="col-md-12" id="tab-2">
			<p>
				<strong>Menu item not found</strong>
			</p>
		</div>';
		}		
			
	}
	
	public function index($restname="") {
		
		if (method_exists($this,$restname)) {
			$this->$restname();
		} else {
			if(isset($restname) && $restname!=''){
				$restname=urldecode($restname);
				$restDetails=$this->restaurant_model->getRestaurantDetail($restname);
				
				$menuGroups=$this->restaurant_model->getRestaurantMenuGroups($restDetails[0]['id']);
	
				$data['restDetails']=$restDetails[0];
				$data['menuGroups']=$menuGroups;
				//get restmanugroups
				$this->load->view('rest_home',$data);
			}
		}
	
	}

	public  function dashboard()
	{
		$this->is_loggedin();
		$data=array(

			'recently_added'=>$this->recipes_model->list_recently_added_recipes(),

			'visited_recipes'=>$this->recipes_model->list_most_visited_recipes(),

			'recipes_count'=>$this->recipes_model->recipes_count(),

			'recipes_views_count'=>$this->recipes_model->recipes_views_count()
		);
		$this->load->view('rest_dashboard',$data);
	}

	public  function menu_group()
	{
		$this->is_loggedin();
		$data=array();
		$this->load->view('menu_group_list',$data);
	}
	
	public function restaurants()
	{
		$data=array();
		$data['user_list']=$this->user_model->get_resto_list();
		$this->load->view('restaurant_details',$data);
	}
}
?>