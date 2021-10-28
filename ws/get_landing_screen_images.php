<?php
	include('connection.php');
	
	$query0 = "SELECT * FROM landing_screen";	
	$result0 = $con->query($query0);
	$count0 = mysqli_num_rows($result0); 
	
	if($count0 > 0)	
	{		
		$landing_screen = array();
		while($row0 = mysqli_fetch_assoc($result0))
		{
			$landingScreen_img = $restoImg.$row0['landing_screen_image'];
			
			$landing_screen[] = array('landingScreen_img'=>$landingScreen_img);
		}
		$show = array('result'=>'success','msg'=>'Landing screen images are found.','landing_screen_images'=>$landing_screen);
		echo json_encode($show);
	}
	else{
		$show = array('result'=>'failed', 'msg'=>'Landing screen images not found.');	
		echo json_encode($show);
	}
?>