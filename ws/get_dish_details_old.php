<?php
	header("Access-Control-Allow-Origin: *");
	include('connection.php');

	if(isSet($_REQUEST['dish_id']) && isSet($_REQUEST['category_id']))	
	{
		$category_id = $_REQUEST['category_id'];				
		$dish_id = $_REQUEST['dish_id'];				
		
		$query0 = "SELECT * FROM menu_group WHERE id='$category_id'";	
		$result0 = mysqli_query($con,$query0);
		$count0 = mysqli_num_rows($result0); 
		
		if($count0 > 0)	
		{	
			$row0 = mysqli_fetch_assoc($result0);
			$cat_name = stripslashes($row0['title']);			
			
			$qry = "SELECT * FROM `recipes` WHERE `id`=$dish_id AND `group_id`=$category_id";
			$res = mysqli_query($con,$qry);
			$cnt = mysqli_num_rows($res); 
			if($cnt > 0){
				$rw = mysqli_fetch_assoc($res);
				$dish_name = stripslashes($rw['name']);
				$dish_image = $restoImg.$rw['recipe_image'];
				$alacal_recipe_id = $rw['alacal_recipe_id'];
				
				$data=array("recipe_id"=>$dish_id,"alacal_recipe_id"=>$alacal_recipe_id,"dish_image"=>$dish_image);
				$handle = curl_init();
				$url = "https://www.foodnai.com/admin/aalcalc/get_recipe/".$alacal_recipe_id;
				curl_setopt($handle, CURLOPT_URL, $url);
				curl_setopt($handle, CURLOPT_POST, true);
				curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
				curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
				$output = curl_exec($handle);			 
				 var_dump($output);exit;  
				curl_close($handle);	
			
				/* echo $output['sub_recipe']['ingredient_items']['ingredient']['declaration_name']; */
				$list = json_decode($output, TRUE);
				/* print_r($list); 
				echo $list['sub_recipe']['ingredient_items']['ingredient']['declaration_name'];*/
				$arr1 = array();
				$arr2 = array();
				$nutri1 = array();
				$arr1 = $list['result']['linked']['nutrition'];
				$arr2 = $list['result']['linked']['ingredient_items'];
				/* print_R($arr2[1]['ingredient']['declaration_name']); */
				print_r($list['result']['linked']);
				foreach($arr1 as $key){
					foreach($key as $nutri=>$value){
						/* $nutri1["'".$nutri."'"]=$value; */
						$nutri1[]=$value;
					}
				}
				 /* print_r($nutri1); */
				 
				 print_r( $list['result']['linked']['ingredient_items']['allergens']);
				 exit; 
				
				$show = array('result'=>'success','msg'=>'Dish details found.','category_id'=>$category_id,'category_name'=>$cat_name,'dish_id'=>$dish_id,'dish_name'=>$dish_name,'dish_image'=>$dish_image,'allergens'=>'-','nutrition'=>'-','ingredients'=>'-');
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