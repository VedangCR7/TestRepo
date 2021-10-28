<?php
	include 'connection.php';
	$qry = "SELECT DISTINCT(`main_menu_id`),logged_user_id FROM `menu_group`";
	$row = mysqli_query($conn,$qry);
	while($res =mysqli_fetch_assoc($row))
	{
		$logid = $res['logged_user_id'];
		$menutype= '';
		if($res['main_menu_id']=='1'){
			$menutype = 'Restaurant Menu';
		}else if($res['main_menu_id']=='2'){
			$menutype = 'Bar Menu';
		}
		
		if($menutype != ''){
			$qryinfo = "INSERT INTO `menu_master`(`name`, `is_active`, `restaurant_id`) VALUES ('$menutype','1','$logid')";
			$inqry =mysqli_query($conn,$qryinfo);
			
			/* $last_id = mysqli_insert_id($conn);
			
			$updateQry = "UPDATE `menu_group` SET main_menu_id=$last_id WHERE logged_user_id=$logid GROUP BY main_menu_id";
			$updateRes = mysqli_query($conn,$updateQry); */
		}
		
	}
?>