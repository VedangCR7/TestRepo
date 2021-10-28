<?php
	header("Access-Control-Allow-Origin: *");
	include('connection.php');

	if(isSet($_REQUEST['user_id']) && isSet($_REQUEST['restaurant_id']))	
	{
		$user_id = $_REQUEST['user_id'];				
		$resto_id = $_REQUEST['restaurant_id'];				
		
		$query0 = "SELECT r.*, m.id as mid, m.title, m.is_active, m.logged_user_id FROM user r, menu_group m WHERE r.id='$resto_id' AND m.logged_user_id=r.id";	
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
				$cat_name = stripslashes($row0['title']);
				$is_active = $row0['is_active'];
				if($is_active=='1')
					$active_status = 'Active';
				else
					$active_status = 'Inactive';
				
				$getRecipeQry = "SELECT * FROM `recipes` WHERE `group_id`='$cat_id' AND `logged_user_id`='$resto_id'";
				$getRecipeRes = mysqli_query($con,$getRecipeQry);
				$getRecipeCnt = mysqli_num_rows($getRecipeRes);
				if($getRecipeCnt > 0){
					$recipe_list = array();
					while($getRecipeRw = mysqli_fetch_assoc($getRecipeRes))
					{
						$dish_id = $getRecipeRw['id'];
						$price = $getRecipeRw['price'];
						/* $recipe_type = $getRecipeRw['recipe_type']; */
						$recipe_type = 'Veg';
						$dish_name = stripslashes($getRecipeRw['name']);
						
						$recipe_list[] = array('dish_id'=>$dish_id,'dish_name'=>$dish_name,'price'=>$price,'recipe_type'=>$recipe_type);
					}
					$menuGroup_list[] = array('category_id'=>$cat_id,'category_name'=>$cat_name,'dish_details'=>$recipe_list);
				}
				else{
					$menuGroup_list[] = array('category_id'=>$cat_id,'category_name'=>$cat_name,'dish_details'=>$recipe_list);
				}
			}
			$show = array('result'=>'success','msg'=>'Restaurant details found.','flag'=>$flag,'restaurants_id'=>$resto_id,'restaurants_name'=>$resto_name,'menuGroup_details'=>$menuGroup_list);
			echo json_encode($show);
		}
		else{
			$show = array('result'=>'failed', 'msg'=>'Menu Category not found.');	
			echo json_encode($show);
		}
	}	
	else
	{		
		$show = array('result'=>'failed','msg'=>'Incomplete parameters');
		echo json_encode($show);
	}	
?>