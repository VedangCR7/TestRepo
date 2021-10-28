<?php
	header("Access-Control-Allow-Origin: *");
	include('connection.php');

	if(isSet($_REQUEST['user_id']) && isSet($_REQUEST['restaurant_id']))	
	{
		$user_id = $_REQUEST['user_id'];				
		$restaurant_id = $_REQUEST['restaurant_id'];
		
		$query0 = "SELECT * FROM Favourites WHERE restaurant_id='$restaurant_id' AND account_id='$user_id'";	
		$result0 = $con->query($query0);
		$count0 = mysqli_num_rows($result0); 
		
		if($count0 > 0)	
		{	
			$row0 = mysqli_fetch_assoc($result0);
			$fav_id = $row0['fav_id'];
			
			$query2 = "DELETE FROM `Favourites` WHERE fav_id='$fav_id'";
			$result2 = mysqli_query($con,$query2);
		
			$show = array('result'=>'success','msg'=>'Restaurant removed from Favourite.','user_id'=>$user_id,'restaurant_id'=>$restaurant_id);
			echo json_encode($show);
		}
		else{
			$query1 = "INSERT INTO `Favourites`(`account_id`, `restaurant_id`) VALUES ('$user_id','$restaurant_id')";	
			$result1 = mysqli_query($con,$query1);
			$ac_id = mysqli_insert_id($con);
			if($ac_id > 0)
			{
				$show = array('result'=>'success','msg'=>'Restaurant added to Favourite.','user_id'=>$user_id,'restaurant_id'=>$restaurant_id);
				echo json_encode($show);
			}else{
				$show = array('result'=>'failed','msg'=>'Restaurant is not added to Favourite.','user_id'=>$user_id,'restaurant_id'=>$restaurant_id);
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