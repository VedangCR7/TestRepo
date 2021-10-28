<?php
	header("Access-Control-Allow-Origin: *");
	error_reporting(1);
	ini_set('display_errors',1);
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
		 
		/* $query0 = "SELECT * FROM user WHERE id IN ('52','53','58','59','60','61','63','66')";	 */
		$query0 = "SELECT m.id, m.name, m.usertype, m.business_name, m.address, m.city, m.country, m.contact_number, m.profile_photo, m.restauranttype, m.latitude, m.longitude, m.postcode, m.address, IFNULL(( 3963.191 * acos( cos( radians($latitude) ) * cos( radians( m.latitude ) ) * cos( radians( m.longitude ) - radians( $longitude ) ) + sin( radians($latitude) ) * sin( radians( m.latitude ) ) ) ),0) AS distance FROM user m WHERE `usertype` in ('Restaurant','Restaurant chain') having distance> 0 ORDER BY distance ASC";	
		$result0 = mysqli_query($con,$query0);
		$count0 = mysqli_num_rows($result0); 
		
		if($count0 > 0)	
		{		
			$restaurants_list = array();
			while($row0 = mysqli_fetch_assoc($result0))
			{
				$resto_id = $row0['id'];
				$resto_name = stripslashes($row0['name']);
				$business_name = stripslashes($row0['business_name']);
				$resto_address = stripslashes($row0['address']);
				$resto_city = $row0['city'];
				$resto_country = $row0['country'];
				$contact_numbar = $row0['contact_number'];
				$restolat = $row0['latitude'];
				$restolong = $row0['longitude'];
				$resto_img = $restoImg.$row0['profile_photo'];
				$restauranttype = $row0['restauranttype'];
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
			$show = array('result'=>'success','msg'=>'Restaurants found.','restaurants_list'=>$restaurants_list);
			echo json_encode($show);
		}
		else{
			$show = array('result'=>'failed', 'msg'=>'Restaurant not found.');	
			echo json_encode($show);
		}
	}	
	else
	{		
		$show = array('result'=>'failed','msg'=>'Incomplete parameters');
		echo json_encode($show);
	}	
?>