<?php
	header("Access-Control-Allow-Origin: *");
	include('connection.php');
	
	$account_id = $_REQUEST['account_id'];
	
	$query = "SELECT * FROM Offers WHERE CURDATE() >= valid_from_datetime AND CURDATE() <= valid_to_datetime";
	$result = $con->query($query);
	
	$count = mysqli_num_rows($result);
				
	if($count > 0)
	{
		while($row = mysqli_fetch_assoc($result))
		{			
			$offer_open_time = $row['opentime'];
			$offer_close_time = $row['closetime'];
			
			if($offer_close_time == '00:00')
			{
				$offer_close_time = '24:00';
			}			
				
			
			$merchant_id = $row['merchant_id'];
			$query1 = "SELECT * FROM Merchants where id =".$row['merchant_id'];
			$result1 = $con->query($query1);
			
			$row1 = mysqli_fetch_assoc($result1);
			$accountid = $row1['account_id'];
			$avgPreparationTime = $row1['avgPreparationTime'];
			
			$deliverycharg = $row1['delivery_charges'];
			$deliverytyp = $row1['delivery_type'];
			
			$now = new Datetime("now");
			$begintime = new DateTime($row1['opentime']);
			$endtime = new DateTime($row1['closetime']);
			
			if($now >= $begintime && $now <= $endtime)
			{
				$flag_shop = 'true';
			}
			else
			{
				$flag_shop = 'false';
			}
			
			$query9 = "SELECT * FROM MerchantEmployees WHERE merchant_id = '$merchant_id' And employee_type_id = 4";
			$result9 = $con->query($query9);
			$row9 = mysqli_fetch_assoc($result9);
			$count9 = mysqli_num_rows($result9);
			
			if ($count9>0 AND $row9['devicetoken']!="")
			{
				$status_flag = 'Active';
			}
			else
			{
				$status_flag = 'Inactive';
			}
			
					
			$query2 = "SELECT * FROM Accounts where id =".$accountid;
			$result2 = $con->query($query2);
			
			$count2 = mysqli_num_rows($result2);
									
			if($count2 > 0)	
			{	
				$row2 = mysqli_fetch_assoc($result2);
				$merchant_status_id = $row2['status_id'];
				
				$query7 = "SELECT * FROM l_Statuses WHERE id = '$merchant_status_id'";
				$result7 = $con->query($query7);
								
				$row7 = mysqli_fetch_assoc($result7);
				$merchant_status = $row7['status'];

				if ($merchant_status == "Active")
				{
					$query3 = "SELECT * FROM OfferMenuItems WHERE offer_id =".$row['id'];
					$result3 = $con->query($query3);
									
					$row3 = mysqli_fetch_assoc($result3);
					$menuitem_id = $row3['menu_item_id'];	
					
					
					$query4 = "SELECT * FROM Menus WHERE merchant_id =".$row['merchant_id'];
					$result4 = $con->query($query4);
									
					$row4 = mysqli_fetch_assoc($result4);
					$menu_id = $row4['id'];	
					
					$query5 = "SELECT * FROM MerchantMenuItems WHERE menu_id = $menu_id AND menu_item_id = $menuitem_id";
					$result5 = $con->query($query5);
									
					/*$row4 = mysqli_fetch_assoc($result4);
					$menu_id = $row4['id'];	*/
					$count5 = mysqli_num_rows($result5);
					
					if($count5 > 0)
					{
						$query8 = "SELECT id, merchant_id, latitude, longitude, postcode, shop_number, address from MerchantLocations where merchant_id=".$row['merchant_id'];
						$result8 = $con->query($query8);
						$count8 = mysqli_num_rows($result8);
		
						if($count8 > 0)
						{
							$row8 = mysqli_fetch_assoc($result8);
							$merchant_location_id = $row8['id'];
							$merchant_id = $row8['merchant_id'];
							$other_latitude = $row8['latitude'];
							$other_longitude = $row8['longitude'];
							
							
								if ($accountid!="")
								{
									$query100="select * from Favourite_merchant where merchant_id = $merchant_id AND account_id = $account_id";
									$result100 = $con->query($query100);
									
									$count100 = mysqli_num_rows($result100);
									
									if($count100 > 0)
									{
										$flag = "like";
									}
									else
									{
										$flag = "dislike";
									}
								}	
								else
								{
									$flag = "dislike";
								}
							
							
							
							$old_valid_to_datetime_timestamp = strtotime($row['valid_to_datetime']);
							$valid_to_datetime = date('d/m', $old_valid_to_datetime_timestamp);
							
							$old_valid_from_datetime_timestamp = strtotime($row['valid_from_datetime']);
							$valid_from_datetime = date('d/m', $old_valid_from_datetime_timestamp);
							//'distance'=>$km,
							
							$shop_number = $row8['shop_number'];
							$addres = $row8['address'];
							$postcode = $row8['postcode'];
							
							$address = "shop number:-".$shop_number.", ". $addres.", ".$postcode;
							
							$query40 = "SELECT * FROM MerchantContacts WHERE merchant_location_id = '$merchant_location_id'";
							$result40 = $con->query($query40);
							$count40 = mysqli_num_rows($result40);
							$row40 = mysqli_fetch_assoc($result40);
							$mobile_number = $row40['mobile'];
							$email_id = $row40['email'];
							
							$image_path = $live_image_path.'/'.$row1['merchant_image'];
							$offer_img = $live_image_path.'/'.$row['image'];
							
							$show[] = array('offerid'=>$row['id'],'merchant_account_id'=>$accountid,'merchant_id'=>$row['merchant_id'],'merchant_name'=>$row1['name'],'delivery_type'=>$row1['delivery_type'],'food_type' => $row1['food_type'],'latitude'=>$other_latitude,'longitude'=>$other_longitude,
											'merchant_tagline'=>$row1['merchant_tagline'],'merchant_image'=>$image_path,'opening_time'=>$row1['opentime'],'closing_time'=>$row1['closetime'],'address'=>$address,'mobile_number'=>$mobile_number,'email'=>$email_id,'home_number'=>'','delivery_type'=>$deliverytyp,'delivery_charges'=>$deliverycharg,'delivery_time'=>$row1['delivery_time'],'mininum_order'=>$row1['mininum_order'],'avgPreparationTime'=>$avgPreparationTime,'title'=>$row['title'],'description'=>$row['description'],'image'=>$offer_img,'valid_from_datetime'=>$valid_from_datetime,'valid_to_datetime'=>$valid_to_datetime,'offer_open_time'=>$offer_open_time,'offer_close_time'=>$offer_close_time,'percentage'=>$row['percentage'],'flag'=>$flag,'shop_open'=>$flag_shop,'login_status'=>$status_flag);
							//$show[] = 'merchant_id'=>,'merchant_name'=>,'open_time'=>$row1['opentime'],'close_time'=>$row1['closetime'],'minimum_order'=>$row1['mininum_order'],'delivery_charge'=>$deliverycharg,'delivery_time'=>$row1['delivery_time'],'avgPreparationTime'=>$avgPreparationTime);
						}
					}	
				}
			}
		}
	
		
		if(empty($show))
		{
			$show1 = array('result'=>'failed','msg'=>'Offers are not available.');
			echo json_encode($show1);
		}
		else
		{
			/*$show1 = array('result'=>'success','data'=>$show);*/
			$show1 = array('result'=>'failed','msg'=>'Offers are not available.');
			echo json_encode($show1);
		}	
	}
	else
	{
		$show = array('result'=>'failed','msg'=>'Currently no offers are available');
		echo json_encode($show);
	}	
				
?>