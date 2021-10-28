<?php
	include 'connection.php';
	
	$qry = "SELECT * FROM `user` where id > '5183'";
	$row = mysqli_query($conn,$qry);
	
	while($res =mysqli_fetch_assoc($row))
	{
		$user_id = $res['id'];
		
		$qry1 = "SELECT cloudpath FROM copy_user_images ORDER BY RAND() LIMIT 5";
		$row1 = mysqli_query($conn,$qry1);
		
		$rest_img1="";
		$rest_img2="";
		$rest_img3="";
		$rest_img4="";
		$rest_img5="";
		
		while($res1=mysqli_fetch_assoc($row1))
		{
			if($rest_img1=="")
			{
				$rest_img1 = $res1['cloudpath'];
			}
			else if($rest_img2=="")
			{
				$rest_img2 = $res1['cloudpath'];
			}
			else if($rest_img3=="")
			{
				$rest_img3 = $res1['cloudpath'];
			}
			else if($rest_img4=="")
			{
				$rest_img4 = $res1['cloudpath'];
			}
			else if($rest_img5=="")
			{
				$rest_img5 = $res1['cloudpath'];
			}
		}
		
		$qry2 = "SELECT profilepath FROM copy_user_images ORDER BY RAND() LIMIT 1";
		$row2 = mysqli_query($conn,$qry2);
		$res2=mysqli_fetch_assoc($row2);
		
		$profile_img=$res2['profilepath'];		
		
		$updateQry = "UPDATE `user` SET profile_photo='$profile_img', rest_img_1='$rest_img1', rest_img_2='$rest_img2', rest_img_3='$rest_img3', rest_img_4='$rest_img4', rest_img_5='$rest_img5' WHERE id='$user_id'";
		$updateRes = mysqli_query($conn,$updateQry);
	}
?>