<?php
	header("Access-Control-Allow-Origin: *");
	include('connection.php');
	
	$query0 = "SELECT * FROM offers WHERE is_valid='valid'";	
	$result0 = $con->query($query0);
	$count0 = mysqli_num_rows($result0); 
	
	if($count0 > 0)	
	{		
		$restaurants_offers = array();
		while($row0 = mysqli_fetch_assoc($result0))
		{
			$offer_img = $restoImg.$row0['offer_image'];
			
			$restaurants_offers[] = array('restaurantOffer_image'=>$offer_img);
		}
		$show = array('result'=>'success','msg'=>'Restaurant offers found.','restaurants_offers'=>$restaurants_offers);
		echo json_encode($show);
	}
	else{
		$show = array('result'=>'failed', 'msg'=>'Restaurant offers not found.');	
		echo json_encode($show);
	}
?>