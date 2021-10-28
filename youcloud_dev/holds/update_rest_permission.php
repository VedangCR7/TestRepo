<?php
	include 'connection.php';
	
	$qry = "SELECT * FROM `user`";
	$row = mysqli_query($conn,$qry);
	
	while($res =mysqli_fetch_assoc($row))
	{
		$user_id = $res['id'];
		
		$qry1 = "SELECT * FROM restaurant_menu_authority_copy where restaurant_id=".$user_id;
		$res1 = mysqli_query($conn,$qry1);
		$count1 = mysqli_num_rows($res1);
		
		$authority="Profile,Dashboard,Menu,Table Management,Offers";
		
		if($count1==0)
		{
			$insertQry = "Insert into `restaurant_menu_authority_copy` (menu_name, restaurant_id) value ('$authority','$user_id')";
			$insertRes = mysqli_query($conn,$insertQry);
			$last_id = mysqli_insert_id($conn);
		}
	}
	
	if($last_id>0)
	{
		echo 'success';
	}
	else
	{
		echo 'failed';
	}
	
?>