<?php
	header("Access-Control-Allow-Origin: *");
	include('connection.php');
	
	$query = "SELECT * FROM allergens";
	$result = mysqli_query($con,$query);
	$count = mysqli_num_rows($result);
				
	if($count > 0)
	{
		$allergens = array();
		while($row = mysqli_fetch_assoc($result))
		{			
			$id = $row['id'];
			$title = $row['title'];
			$allergen_image = $restoImg.$row['image_url'];
			/* list($part1, $part2, $part3) = explode('_', $title); */
			$arr = explode('_', $title);
			$allergen = ucfirst(implode(" ",$arr));
			
			$allergens[] = array('id'=>$id,'allergen'=>$allergen,'allergen_image'=>$allergen_image);
		}
		$show = array('result'=>'success','msg'=>'Allergens found.','allergens'=>$allergens);
		echo json_encode($show);
	}
	else{
		$show = array('result'=>'failed', 'msg'=>'Allergens not found.');	
		echo json_encode($show);
	}	
?>