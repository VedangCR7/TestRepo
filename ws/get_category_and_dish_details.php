<?php
	header("Access-Control-Allow-Origin: *");
	include('connection.php');

	if(isSet($_REQUEST['user_id']) && isSet($_REQUEST['restaurant_id']))	
	{
		$user_id = $_REQUEST['user_id'];				
		$resto_id = $_REQUEST['restaurant_id'];	
		if($_REQUEST['allerganid']!="")
		{
			$allerganid = explode(',',$_REQUEST['allerganid']);
		}
		else
		{
			$allerganid = array();
		}
		
		$query0 = "SELECT r.*, m.id as mid, m.title, m.is_active, m.logged_user_id FROM user r, menu_group m WHERE r.id='$resto_id' AND m.logged_user_id=r.id AND m.is_active=1";	
		$result0 = $con->query($query0);
		$count0 = mysqli_num_rows($result0); 
		
		if($count0 > 0)	
		{		
			$menuGroup_list = array();
			
			$getFavRecQry = "SELECT * FROM Favourites WHERE restaurant_id='$resto_id' AND account_id='$user_id'";
			$getFavRecRes = mysqli_query($con,$getFavRecQry);
			$getFavRecCnt = mysqli_num_rows($getFavRecRes);
			if($getFavRecCnt > 0)
				$flag = 'Favourite';
			else
				$flag = 'Unfavourite';
			
			$addToRecentQry2 = "INSERT INTO `recent`(`account_id`, `resto_id`) VALUES ('$user_id','$resto_id')";
			$addToRecentRes2 = mysqli_query($con,$addToRecentQry2);
			
			while($row0 = mysqli_fetch_assoc($result0))
			{
				$cat_id = $row0['mid'];
				$resto_name = stripslashes($row0['name']);
				$catname = stripslashes($row0['title']);
				$cat_name = ucwords(strtolower($catname));
				$is_active = $row0['is_active'];
				if($is_active=='1')
					$active_status = 'Active';
				else
					$active_status = 'Inactive';
				
				$getRecipeQry = "SELECT * FROM `recipes` WHERE `group_id`='$cat_id' AND `logged_user_id`='$resto_id' AND is_delete=0 AND is_active=1";
				$getRecipeRes = mysqli_query($con,$getRecipeQry);
				$getRecipeCnt = mysqli_num_rows($getRecipeRes);
				if($getRecipeCnt > 0){
					$recipe_list = array();
					while($getRecipeRw = mysqli_fetch_assoc($getRecipeRes))
					{
						$dish_id = $getRecipeRw['id'];
						$price = $getRecipeRw['price'];
						$main_menu_id = $getRecipeRw['main_menu_id'];
						$recipe_image = $restoImg.$getRecipeRw['recipe_image'];
						$best_time_to_eat = $getRecipeRw['best_time_to_eat'];
						
						if($best_time_to_eat == 'none'){
							$best_time_to_eat = '';
						}
						
						$besttime_arr = explode(",",$best_time_to_eat);
						if(array_search('all', $besttime_arr) == 'TRUE')
						{
							$pos = array_search('all', $besttime_arr);
							unset($besttime_arr[$pos]);
						}
						
						$best_time_to_eat = implode(", ",$besttime_arr);
						
						$recipe_type = ucfirst($getRecipeRw['recipe_type']);
						$dish_name = stripslashes(strtolower($getRecipeRw['name']));
						
						$query1 = "SELECT a.id as aid, a.title, a.image_url, a.images_red, ra.* FROM `recipe_allergens` ra, allergens a WHERE ra.allergens_id=a.id AND ra.`recipe_id` =$dish_id";
						$result1 = mysqli_query($con,$query1);
						$count1 = mysqli_num_rows($result1);
						if($count1 > 0)
						{
							$AllergensList = array();
							while($row1=mysqli_fetch_assoc($result1))
							{/* echo $row1['id']."==".$row1['aid']."**<br>**"; */
								if(in_array($row1['allergens_id'],$allerganid))
								{
									$allergen_image = $restoImg.$row1['images_red'];
								}
								else{
									$allergen_image = $restoImg.$row1['image_url'];
								}
								$allergen_id = $row1['aid'];
								$allergens_title = $row1['title'];
								
								$AllergensList[] = array('allergen_id'=>$allergen_id,'allergen'=>$allergens_title,'allergen_image'=>$allergen_image);
							}
						}
						else{
							$AllergensList = array();
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
						
						$recipe_list[] = array('dish_id'=>$dish_id,'dish_name'=>ucwords($dish_name),'main_menu_id'=>$main_menu_id,'price'=>$price,'recipe_image'=>$recipe_image,'recipe_type'=>$recipe_type,'best_time_to_eat'=>ucwords($best_time_to_eat),'allergens'=>$AllergensList,'ingredients'=>$ingredientsList);
					}
					$menuGroup_list[] = array('category_id'=>$cat_id,'category_name'=>$cat_name,'dish_details'=>$recipe_list);
				}
				else{
					$recipe_list = array();
					$menuGroup_list[] = array('category_id'=>$cat_id,'category_name'=>$cat_name,'dish_details'=>$recipe_list);
				}
			}
			$show = array('result'=>'success','msg'=>'Restaurant details found.','flag'=>$flag,'restaurants_id'=>$resto_id,'restaurants_name'=>$resto_name,'menuGroup_details'=>$menuGroup_list);
			echo json_encode($show);
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