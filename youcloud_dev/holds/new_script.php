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

	$query1 = "SELECT `id`,`name`,`recipe_type`,`group_id`,`logged_user_id`,`recipe_image` FROM `recipes` WHERE `is_delete`=0 AND main_menu_id=1 AND `is_active`=1 AND `logged_user_id`> 99 AND `recipe_image` != 'assets/images/users/menu.png' Group by `name` ORDER BY id ASC";
	$result1 = mysqli_query($con,$query1);
	$count1 = mysqli_num_rows($result1);
	if($count1 > 0){
		while($row1 = mysqli_fetch_assoc($result1))
		{
			$rId = $row1['id'];
			$rName = ucwords(strtolower($row1['name']));
			$rImage = $row1['recipe_image'];
			
			$query2 = "INSERT INTO `recipe_images_master`(`name`, `img_path`) VALUES('$rName','$rImage')";
			$result2 = mysqli_query($con,$query2);
			$insertId1 = mysqli_insert_id($con);
			if($insertId1 > 0){ 
				/* $query3 = "UPDATE `recipes` SET `recipe_image_id`=$insertId1 WHERE id = $rId AND name = '$rName'"; */
				$query3 = "UPDATE `recipes` SET `recipe_image_id`=$insertId1 WHERE name = '$rName'";
				$result3 = mysqli_query($con,$query3);
				echo "success <br>";
			}
		}
	}
?>