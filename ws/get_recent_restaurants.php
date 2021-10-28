<?php
	header("Access-Control-Allow-Origin: *");
	include('connection.php');

	if(isSet($_REQUEST['user_id']) && isSet($_REQUEST['latitude']) && isSet($_REQUEST['longitude']))	
	{
		$user_id = $_REQUEST['user_id'];	
		$latitude = $_REQUEST['latitude'];				
		$longitude = $_REQUEST['longitude'];				
		
		function distanceinkm($lat1, $lon1, $lat2, $lon2) 
		{
			if (($lat1 == $lat2) && ($lon1 == $lon2)) {
				return 0;
			}
			else {
				$theta = $lon1 - $lon2;
				$dist = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta))); 
				$dist = acos($dist);
				$dist = rad2deg($dist);
				$distance = $dist * 60 * 1.1515; 
				$distance = $distance * 1.609344; 

				return (round($distance,2));
			}
		}		
		
		$query0 = "SELECT * FROM accounts WHERE ac_id='$user_id'";	
		$result0 = $con->query($query0);
		$count0 = mysqli_num_rows($result0); 
		
		if($count0 > 0)	
		{		
			/* $getFavRecQry = "SELECT f.*, r.* FROM recent f, user r WHERE f.account_id='$user_id' AND f.resto_id=r.id ORDER BY f.rec_id DESC"; */
			$getFavRecQry = "SELECT MAX(rec_id) as rid, `resto_id`, u.* FROM recent r, user u WHERE r.`resto_id`= u.id AND r.`account_id`='$user_id' group by r.`resto_id` order by rid DESC";
			$getFavRecRes = mysqli_query($con,$getFavRecQry);
			$getFavRecCnt = mysqli_num_rows($getFavRecRes);
			if($getFavRecCnt > 0)
			{
				$restaurants_list = array();
				while($getFavRecRw = mysqli_fetch_assoc($getFavRecRes))
				{
					$resto_id = $getFavRecRw['id'];
					$resto_name = stripslashes($getFavRecRw['name']);
					$business_name = stripslashes($getFavRecRw['business_name']);
					$resto_address = stripslashes($getFavRecRw['address']);
					$resto_city = $getFavRecRw['city'];
					$country = $getFavRecRw['country'];
					$contact_numbar = $getFavRecRw['contact_number'];
					$restolat = $getFavRecRw['latitude'];
					$restolong = $getFavRecRw['longitude'];
					$restauranttype = $getFavRecRw['restauranttype'];
					$resto_img = $restoImg.$getFavRecRw['profile_photo'];
					if($restauranttype=='both')
						$restauranttype = 'Veg-Nonveg';
					if($resto_city !='' && $resto_country !='')
						$restoCity = $resto_city.', '.$resto_country;
					else if($resto_city !='' && $resto_country =='')
						$restoCity = $resto_city;
					else if($resto_city =='' && $resto_country !='')
						$restoCity = $resto_country;
					else if($resto_city =='' && $resto_country =='')
						$restoCity = '-';
					$distinkm = distanceinkm($latitude,$longitude,$restolat,$restolong)."KM";
					
					$restaurants_list[] = array('restaurant_id'=>$resto_id,'restaurant_name'=>$resto_name,'business_name'=>$business_name,'restaurant_address'=>$resto_address,'restaurant_city'=>$restoCity,'distance_from_postal_code'=>$distinkm,'ratings'=>'4.5','contact_numbar'=>$contact_numbar,'restaurant_image'=>$resto_img,'restaurant_type'=>ucfirst($restauranttype),'offers'=>'Upto 50% off','food_type'=>'Continental food');
				}
				$show = array('result'=>'success','msg'=>'Recent Restaurant found.','restaurants_list'=>$restaurants_list);
				echo json_encode($show);
			}
			else
			{
				$show = array('result'=>'failed', 'msg'=>'Recent Restaurant not found.');	
				echo json_encode($show);
			}
		}
		else{
			$show = array('result'=>'failed', 'msg'=>'User not found.');	
			echo json_encode($show);
		}
	}	
	else
	{		
		$show = array('result'=>'failed','msg'=>'Incomplete parameters');
		echo json_encode($show);
	}	
?>