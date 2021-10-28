<?php
	header("Access-Control-Allow-Origin: *");
	include('connection.php');

	if(isSet($_REQUEST['keyword']) && isSet($_REQUEST['flag']))	
	{
		$keyword = $_REQUEST['keyword'];				
		$flag = $_REQUEST['flag'];		
		$user_id = $_REQUEST['user_id'];		
		$latitude = $_REQUEST['latitude'];				
		$longitude = $_REQUEST['longitude'];
		$restaurant_id = $_POST['restaurant_id'];
		if($_REQUEST['allerganid']!="")
		{
			$allerganid = explode(',',$_REQUEST['allerganid']);
		}
		else
		{
			$allerganid = array();
		}	
		
		function distanceinkm($lat1, $lon1, $lat2, $lon2) 
		{
			if (($lat1 == $lat2) && ($lon1 == $lon2)) {
				return 0;
			}
			else {
				$theta = $lon1 - $lon2;
				$dist = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta))); 
				$dist = acos($dist);
				$dist = rad2deg($dist);
				$distance = $dist * 60 * 1.1515; 
				$distance = $distance * 1.609344; 

				return (round($distance,2));
			}
		}		
		
		if($flag == 'all'){
			/* $getFavRecQry = "SELECT * FROM user WHERE name like '%$keyword%' ORDER BY id DESC"; */
			$getFavRecQry = "SELECT * FROM user WHERE name like '%$keyword%' AND `usertype` IN ('Restaurant','Restaurant chain') ORDER BY id DESC";
			$getFavRecRes = mysqli_query($con,$getFavRecQry);
			$getFavRecCnt = mysqli_num_rows($getFavRecRes);
			if($getFavRecCnt > 0)
			{
				$restaurants_list = array();
				while($getFavRecRw = mysqli_fetch_assoc($getFavRecRes))
				{
					$resto_id = $getFavRecRw['id'];
					$resto_name = stripslashes($getFavRecRw['name']);
					$resto_img = $restoImg.$getFavRecRw['profile_photo'];
					
					$restaurants_list[] = array('type'=>'restaurant','restaurant_id'=>$resto_id,'restaurant_name'=>$resto_name,'restaurant_image'=>$resto_img,'dish_id'=>$dish_id,'category_id'=>$category_id,'dish_name'=>ucfirst($dish_name),'dish_image'=>$dish_img);
				}
				
				$qry = "SELECT * FROM `recipes` WHERE `name` like '%$keyword%' ORDER BY id DESC";
				$res = mysqli_query($con,$qry);
				$cnt = mysqli_num_rows($res); 
				if($cnt > 0){
					$dish_list = array();
					while($rw = mysqli_fetch_assoc($res))
					{
						$dish_id = $rw['id'];
						$category_id = $rw['group_id'];
						$dish_name = stripslashes($rw['name']);
						$dish_image = $restoImg.$rw['recipe_image'];
						$resto_id = '';
						$resto_name = '';
						$resto_img = ''; 
						
						$dish_list[] = array('type'=>'dish','dish_id'=>$dish_id,'category_id'=>$category_id,'dish_name'=>$dish_name,'dish_image'=>$dish_image,'restaurant_id'=>$resto_id,'restaurant_name'=>$resto_name,'restaurant_image'=>$resto_img);
					}
				}
				else{
					$show = array('result'=>'failed', 'msg'=>'Dish details not found.');	
					echo json_encode($show);
				}
				$result_list = array_merge($restaurants_list,$dish_list);
				$show = array('result'=>'success','msg'=>'Restaurants found.','result_list'=>$result_list);
				echo json_encode($show);
			}
			else
			{
				$qry = "SELECT * FROM `recipes` WHERE `name` like '%$keyword%' ORDER BY id DESC";
				$res = mysqli_query($con,$qry);
				$cnt = mysqli_num_rows($res); 
				if($cnt > 0){
					$dish_list = array();
					while($rw = mysqli_fetch_assoc($res))
					{
						$dish_id = $rw['id'];
						$category_id = $rw['group_id'];
						$dish_name = stripslashes($rw['name']);
						$dish_image = $restoImg.$rw['recipe_image'];
						
						$dish_list[] = array('type'=>'dish','dish_id'=>$dish_id,'category_id'=>$category_id,'dish_name'=>$dish_name,'dish_image'=>$dish_image,'restaurant_id'=>$resto_id,'restaurant_name'=>$resto_name,'restaurant_image'=>$resto_img);
					}
					$show = array('result'=>'success','msg'=>'Dish details found.','result_list'=>$dish_list);
					echo json_encode($show);
				}
				else{
					$show = array('result'=>'failed', 'msg'=>'Dish details not found1.');	
					echo json_encode($show);
				}
			}
		}
		else if($flag == 'dish'){
			/* $qry = "SELECT * FROM `recipes` WHERE `logged_user_id` = '$restaurant_id' AND `name` like '%$keyword%' ORDER BY id DESC"; 
			$qry = "SELECT r.*, re.id as restoid, re.name, f.*, m.title, m.is_active, m.logged_user_id FROM `recipes` r, user re, Favourites f, menu_group m WHERE r.logged_user_id=re.id AND r.logged_user_id=f.restaurant_id AND r.group_id=m.id AND f.account_id = '$user_id' AND r.`logged_user_id` = '$restaurant_id' AND r.`name` like '%$keyword%' ORDER BY r.id DESC";*/
			
			$getRestoQry = "SELECT id, name FROM user WHERE id = '$restaurant_id'";
			$getRestoRes = mysqli_query($con,$getRestoQry);
			$getRestoCnt = mysqli_num_rows($getRestoRes);
			if($getRestoCnt > 0)
			{
				$getRestoRw = mysqli_fetch_assoc($getRestoRes);
				$resto_name = stripslashes($getRestoRw['name']);
				
				$getFavRecQry1 = "SELECT * FROM Favourites WHERE restaurant_id='$restaurant_id' AND account_id='$user_id'";
				$getFavRecRes1 = mysqli_query($con,$getFavRecQry1);
				$getFavRecCnt1 = mysqli_num_rows($getFavRecRes1);
				if($getFavRecCnt1 > 0)
					$flag = 'Favourite';
				else
					$flag = 'Unfavourite';
								
				$qry1 = "SELECT r.id, r.name, r.price, r.recipe_type, r.declaration_name, r.group_id, r.alacal_recipe_id, r.logged_user_id,  m.title, m.is_active, m.logged_user_id FROM `recipes` r, menu_group m WHERE r.group_id=m.id AND r.`logged_user_id` = '$restaurant_id' AND m.is_active=1 AND r.`name` like '%$keyword%' GROUP BY m.title ORDER BY r.id ASC";
				$res1 = mysqli_query($con,$qry1);
				$cnt1 = mysqli_num_rows($res1); 
				if($cnt1 > 0){
					$cat_list = array();
					while($rw1 = mysqli_fetch_assoc($res1))
					{
						$dish_id = $rw1['id'];
						$cat_id = $rw1['group_id'];
						$cat_name = stripslashes($rw1['title']);
						
						$qry = "SELECT * FROM `recipes` WHERE group_id=$cat_id AND `logged_user_id` = '$restaurant_id' AND `name` like '%$keyword%' ORDER BY id ASC";
						$res = mysqli_query($con,$qry);
						$cnt = mysqli_num_rows($res); 
						if($cnt > 0){
							$dish_list = array();
							while($rw = mysqli_fetch_assoc($res))
							{
								$dish_id = $rw['id'];
								$dish_nm = stripslashes($rw['name']);
								$dish_name = strtolower($dish_nm);
								$dish_image = $restoImg.$rw['recipe_image'];
								$best_time_to_eat = $rw['best_time_to_eat'];
								$besttime_arr = explode(",",$best_time_to_eat);
								if(array_search('all', $besttime_arr) == 'TRUE')
								{
									$pos = array_search('all', $besttime_arr);/* echo 'Linus Trovalds found at: ' . $pos; */
									unset($besttime_arr[$pos]);
								}
								
								$best_time_to_eat = implode(", ",$besttime_arr);
								$alacal_recipe_id = $rw['alacal_recipe_id'];
								$price = $rw['price'];
								$recipe_type = ucfirst($rw['recipe_type']);
								
								$query1 = "SELECT a.id as aid, a.title, a.image_url, a.images_red, ra.* FROM `recipe_allergens` ra, allergens a WHERE ra.allergens_id=a.id AND ra.`recipe_id` = $dish_id";
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
										$allergens_title = $row1['title'];
										
										$AllergensList[] = array('allergen_id'=>$allergen_id,'allergen'=>ucwords($allergens_title),'allergen_image'=>$allergen_image);
									}
								}
								else{
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
									
										$NutritionList[] = array('name'=>$nutri_name,'quantity'=>$quantity,'unit'=>$unit);
									}
								}
								else{
									$NutritionList = array();
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
								
								/* $dish_list[] = array('dish_id'=>$dish_id,'dish_name'=>$dish_name,'dish_image'=>$dish_image,'price'=>$price,'recipe_type'=>$recipe_type,'allergens'=>$AllergensList,'nutrition'=>$NutritionList,'ingredients'=>$ingredientsList); */
								$dish_list[] = array('dish_id'=>$dish_id,'dish_name'=>ucwords($dish_name),'dish_image'=>$dish_image,'price'=>$price,'recipe_type'=>$recipe_type,'best_time_to_eat'=>ucwords($best_time_to_eat),'allergens'=>$AllergensList,'ingredients'=>$ingredientsList);
							}
							$cat_list[] = array('category_id'=>$cat_id,'category_name'=>$cat_name,'dish_details'=>$dish_list);
						}
						else{
							$show = array('result'=>'failed', 'msg'=>'Dish details not found.');	
							echo json_encode($show);
						}
						
					}
				
					$show = array('result'=>'success','msg'=>'Dish details found.','flag'=>$flag,'restaurants_id'=>$restaurant_id,'restaurants_name'=>$resto_name,'menuGroup_details'=>$cat_list);
					echo json_encode($show);
				}
				else{
					$show = array('result'=>'failed', 'msg'=>'Menu not found.');	
					echo json_encode($show);
				}
			}
			else{
				$show = array('result'=>'failed', 'msg'=>'Restaurant not found.');	
				echo json_encode($show);
			}
		}
		else if($flag == 'restaurant'){
			/* $getFavRecQry = "SELECT * FROM user WHERE name like '%$keyword%' ORDER BY id DESC"; */
			$getFavRecQry = "SELECT m.id, m.name, m.usertype, m.business_name, m.address, m.city, m.country, m.contact_number, m.profile_photo, m.restauranttype, m.latitude, m.longitude, m.postcode, m.address, IFNULL(( 3963.191 * acos( cos( radians($latitude) ) * cos( radians( m.latitude ) ) * cos( radians( m.longitude ) - radians( $longitude ) ) + sin( radians($latitude) ) * sin( radians( m.latitude ) ) ) ),0) AS distance FROM user m WHERE name like '%$keyword%' AND `usertype` in ('Restaurant','Restaurant chain') having distance> 0 ORDER BY distance ASC";
			$getFavRecRes = mysqli_query($con,$getFavRecQry);
			$getFavRecCnt = mysqli_num_rows($getFavRecRes);
			if($getFavRecCnt > 0)
			{
				$restaurants_list = array();
				while($getFavRecRw = mysqli_fetch_assoc($getFavRecRes))
				{
					$resto_id = $getFavRecRw['id'];
					$resto_name = stripslashes($getFavRecRw['name']);
					$business_name = stripslashes($getFavRecRw['business_name']);
					$resto_address = stripslashes($getFavRecRw['address']);
					$resto_city = $getFavRecRw['city'];
					$resto_country = $getFavRecRw['country'];
					$contact_numbar = $getFavRecRw['contact_number'];
					$restauranttype = $getFavRecRw['restauranttype'];
					$resto_img = $restoImg.$getFavRecRw['profile_photo'];
					$restolat = $getFavRecRw['latitude'];
					$restolong = $getFavRecRw['longitude'];
					if($restauranttype=='both')
						$restauranttype = 'Veg-Nonveg';
					if($resto_city !='' && $resto_country !='')
						$restoCity = $resto_city.', '.$resto_country;
					else if($resto_city !='' && $resto_country =='')
						$restoCity = $resto_city;
					else if($resto_city =='' && $resto_country !='')
						$restoCity = $resto_country;
					else if($resto_city =='' && $resto_country =='')
						$restoCity = '-';
					$distinkm = distanceinkm($latitude,$longitude,$restolat,$restolong)."KM";
					
					$restaurants_list[] = array('type'=>'restaurant','restaurant_id'=>$resto_id,'restaurant_name'=>$resto_name,'business_name'=>$business_name,'restaurant_address'=>$resto_address,'restaurant_city'=>$restoCity,'distance_from_postal_code'=>$distinkm,'ratings'=>'4.5','contact_numbar'=>$contact_numbar,'restaurant_image'=>$resto_img,'restaurant_type'=>ucfirst($restauranttype),'offers'=>'Upto 50% off','food_type'=>'Continental food');
				}
				$show = array('result'=>'success','msg'=>'Restaurant details found.','restaurants_list'=>$restaurants_list);
				echo json_encode($show);
			}
			else
			{
				$show = array('result'=>'failed', 'msg'=>'Restaurant details not found.');	
				echo json_encode($show);
			}
		}
	}	
	else
	{		
		$show = array('result'=>'failed','msg'=>'Incomplete parameters');
		echo json_encode($show);
	}	
?>