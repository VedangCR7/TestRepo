<?php
	header("Access-Control-Allow-Origin: *");
	include('connection.php');
 
	if(isSet($_REQUEST['dish_id']) && isSet($_REQUEST['category_id']))	
	{
		$category_id = $_REQUEST['category_id'];				
		$dish_id = $_REQUEST['dish_id'];	
		if($_REQUEST['allerganid']!="")
		{
			$allerganid = explode(',',$_REQUEST['allerganid']);
		}
		else
		{
			$allerganid = array();
		}
		$big8=['Energ_Kcal','Energ_KJ','Protein','Lipid_Tot','FA_Sat','Carbohydrt','Sugar_Tot','Salt'];		
		$vitamins=['Vit_D_mcg','Vit_D_IU','Vit_E','Vit_B6','Vit_B12','Vit_C','Vit_A_IU','Vit_A_RAE','Vit_K','vitamins_nutrient_header','common_nutrient_header'];		
		$query0 = "SELECT * FROM menu_group WHERE id='$category_id'";	
		$result0 = mysqli_query($con,$query0);
		$count0 = mysqli_num_rows($result0); 
		
		if($count0 > 0)	
		{	
			$row0 = mysqli_fetch_assoc($result0);
			$cat_name = stripslashes(strtolower($row0['title']));			
			$main_menu_id = $row0['main_menu_id'];			
			
			$qry = "SELECT r.*, u.id as restoId, u.name as restoName FROM `recipes` r, user u WHERE r.logged_user_id=u.id AND r.`id`=$dish_id AND r.`group_id`=$category_id AND r.is_delete=0 AND r.is_active=1";
			$res = mysqli_query($con,$qry);
			$cnt = mysqli_num_rows($res); 
			if($cnt > 0){
				$rw = mysqli_fetch_assoc($res);
				$dish_name = stripslashes(strtolower($rw['name']));
				$dish_image = $restoImg.$rw['recipe_image'];
				$price = $rw['price'];
				$recipe_type = ucfirst($rw['recipe_type']);
				$alacal_recipe_id = $rw['alacal_recipe_id'];
				$restaurant_id = $rw['logged_user_id'];
				$restoName = stripslashes($rw['restoName']);
				
				$query1 = "SELECT a.id as aid, a.title, a.image_url, a.images_red, ra.* FROM `recipe_allergens` ra, allergens a WHERE ra.allergens_id=a.id AND ra.`recipe_id` =$dish_id";
				$result1 = mysqli_query($con,$query1);
				$count1 = mysqli_num_rows($result1);
				if($count1 > 0)
				{
					$AllergensList = array();
					while($row1=mysqli_fetch_assoc($result1))
					{
						if(in_array($row1['allergens_id'],$allerganid))
						{
							$allergen_image = $restoImg.$row1['images_red'];
						}
						else{
							$allergen_image = $restoImg.$row1['image_url'];
						}
						$allergen_id = $row1['aid'];
						$allergens_title = ucwords($row1['title']);
						
						$AllergensList[] = array('allergen_id'=>$allergen_id,'allergen'=>$allergens_title,'allergen_image'=>$allergen_image);
					}
				}
				else{
					/* $AllergensList = 'NONE'; */
					$AllergensList = array();
				}
				
				$query11 = "SELECT * FROM `recipe_nutritient` WHERE recipe_id=$dish_id";
				$result11 = mysqli_query($con,$query11);
				$count11 = mysqli_num_rows($result11);
				if($count11 > 0)
				{
					$NutritionList = array();
					while($row11=mysqli_fetch_assoc($result11))
					{
						$nutri_name = $row11['name'];
						$quantity = $row11['value'];
						$unit = $row11['unit'];
							
						$All_NutritionList[] = array('name'=>$nutri_name,'quantity'=>$quantity,'unit'=>$unit);
						
					    if(in_array($row11['name'],$big8)){
							$b8nutri_name = $row11['name'];
							$b8quantity = $row11['value'];
							$b8unit = $row11['unit'];
								
							$big8_NutritionList[] = array('name'=>$b8nutri_name,'quantity'=>$b8quantity,'unit'=>$b8unit);
						}
						
						if(in_array($row11['name'],$vitamins)){
							$vita_nutri_name = $row11['name'];
							$vita_quantity = $row11['value'];
							$vita_unit = $row11['unit'];
								
							$vita_NutritionList[] = array('name'=>$vita_nutri_name,'quantity'=>$vita_quantity,'unit'=>$vita_unit);
						}
					}
				}
				else{
					$All_NutritionList = array();
					$big8_NutritionList = array();
					$vita_NutritionList = array();
				}
				
				$query2 = "SELECT im.*,i.long_desc,i.declaration_name,i.data_source FROM `ingredient_items` im, ingredient i WHERE i.alacalc_id=im.ingredient_id AND `recipe_id`=$dish_id";
				$result2 = mysqli_query($con,$query2);
				$count2 = mysqli_num_rows($result2);
				if($count2 > 0)
				{
					$declaration_name = array();
					while($row1=mysqli_fetch_assoc($result2))
					{
						if($row1['declaration_name'] == '')
						{
							$declaration_name[] = ucwords(strtolower($row1['long_desc']));
						}else
							$declaration_name[] = ucwords(strtolower($row1['declaration_name']));
					}
					$ingredientsList = implode(', ', $declaration_name); 
				}
				else{
					$ingredientsList = '-';
				}
				
				$show = array('result'=>'success','msg'=>'Dish details found.','restaurant_id'=>$restaurant_id,'restoName'=>$restoName,'category_id'=>$category_id,'main_menu_id'=>$main_menu_id,'category_name'=>ucwords($cat_name),'dish_id'=>$dish_id,'dish_name'=>ucwords($dish_name),'dish_image'=>$dish_image,'dish_price'=>$price,'dish_veg_nonveg_type'=>$recipe_type,'allergens'=>$AllergensList,'all_nutrition'=>$All_NutritionList,'big8_nutrition'=>$big8_NutritionList,'vitamins_NutritionList'=>$vita_NutritionList,'ingredients'=>$ingredientsList);
				echo json_encode($show);
			}
			else{
				$show = array('result'=>'failed', 'msg'=>'Recipe not found.');	
				echo json_encode($show);
			}
		}
		else{
			$show = array('result'=>'failed', 'msg'=>'Category not found.');	
			echo json_encode($show);
		}
	}	
	else
	{		
		$show = array('result'=>'failed','msg'=>'Incomplete parameters');
		echo json_encode($show);
	}	
?>