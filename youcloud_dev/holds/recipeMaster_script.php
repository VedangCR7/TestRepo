<?php
	$con = mysqli_connect('localhost','foodnai_test','leomessi10@argentina','FOODNAI_TEST');
	/* $con = mysqli_connect('localhost','foodnai_live','Agriezmann','FOODNAI_LIVE'); */ 
 
	/* Check connection */
	if (mysqli_connect_errno()) {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	  exit();
	}else{
		echo "Connection established. <br>";
	}

	$query4 = "SELECT `short_name`,`image_path` FROM `newmenuimagemaster`";
	$result4 = mysqli_query($con,$query4);
	$count4 = mysqli_num_rows($result4);
	if($count4 > 0){
		while($row4 = mysqli_fetch_assoc($result4))
		{
			$snm = $row4['short_name'];
			$newimgpath = $row4['image_path'];
			
			echo $query11 = "SELECT id,`name`,img_path FROM `recipe_images_master1` WHERE `name` like '%$snm%'";
			$result11 = mysqli_query($con,$query11);
			echo $count11 = mysqli_num_rows($result11);
			if($count11 > 0){
				while($row11 = mysqli_fetch_assoc($result11))
				{
					$rId = $row11['id'];
					$rName = ucwords(strtolower($row11['name']));
					
					$query31 = "DELETE FROM `recipe_images_master1` WHERE id = $rId";
					$result31 = mysqli_query($con,$query31);
				}
			}				
			$query2 = "INSERT INTO `recipe_images_master1`(`name`, `img_path`, `is_new`) VALUES('$snm','$newimgpath','1')";
			$result2 = mysqli_query($con,$query2);
			$insertId1 = mysqli_insert_id($con);
			if($insertId1 > 0){ 
				/* $query3 = "UPDATE `recipes` SET `recipe_image_id`=$insertId1 WHERE id = $rId AND name = '$rName'"; */
				echo $query3 = "UPDATE `recipes1` SET `recipe_image_id`=$insertId1, `recipe_image`='$newimgpath' WHERE name like '$snm'";
				$result3 = mysqli_query($con,$query3);
				echo "success <br>";
			}
				
		}
	}
?>