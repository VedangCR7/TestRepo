<?php
	include('connection.php');

	if((isSet($_REQUEST['email_id']) && $_REQUEST['email_id']!="") && (isSet($_REQUEST['password']) && $_REQUEST['password']!="") && isSet($_REQUEST['devicetoken']) && isSet($_REQUEST['device_type']))	
	{
		$email_id = $_REQUEST['email_id'];				
		$password = $_REQUEST['password'];
		$devicetoken=$_REQUEST['devicetoken'];
		$device_type=$_REQUEST['device_type'];
		
		
		$query0 = "SELECT * FROM Accounts WHERE email='$email_id'";	
		$result0 = $con->query($query0);
		$count0 = mysqli_num_rows($result0); 
		
		if($count0 > 0)	
		{			
			$query1 = "SELECT * FROM Accounts WHERE email='$email_id' AND Binary password ='$password'";	
			$result1 = $con->query($query1);
			$count1 = mysqli_num_rows($result1); 
			
			if($count1 > 0)	
			{
				$row1 = mysqli_fetch_assoc($result1);
				$status_id = $row1['status_id'];
				$account_id = $row1['id'];
				
				$query2 = "SELECT * FROM l_Statuses WHERE id = '$status_id'";
				$result2 = $con->query($query2);
				$count2 = mysqli_num_rows($result2);

				if($count2 > 0)	
				{ 
					$row2 = mysqli_fetch_assoc($result2);
					$status = $row2['status'];
					
					if ($status == "New")
					{
						$show = array('result'=>'failed','account_id'=>$account_id,'msg'=>'Email verification not done please verify your account and try again.');
						echo json_encode($show);
					}
					else if ($status == "Active")
					{
							$query3 = "update Accounts set devicetoken='$devicetoken',device_type='$device_type' where email='$email_id'";
							$result3 = $con->query($query3);
							
							if($con -> query($query3) === TRUE)
							{
								$query4 = "SELECT * FROM Consumers WHERE account_id = '$account_id'";	
								$result4 = $con->query($query4);
								$count4 = mysqli_num_rows($result4);
								
								if($count4 > 0)	
								{ 
									$row4 = mysqli_fetch_assoc($result4);
									$gender_id = $row4['gender_id'];
									
									$login_type = $row4['login_type'];
									$profile_image = $row4['profile_image'];
									
									if(strlen($profile_image) > 5)
									{
										$image_path = $profile_image_path."/".$row4['profile_image'];
									}
									else
									{
										$image_path = "";
									}
									
									if($gender_id == '')
									{
										$gender = "";
									}
									else
									{
										$query5 = "SELECT gender FROM l_Gender WHERE id = '$gender_id'";
										$result5 = $con->query($query5);
										$count5 = mysqli_num_rows($result5);
										if($count5 > 0)	
										{
											$row5 = mysqli_fetch_assoc($result5);
											$gender = $row5['gender'];
										}
									}
									
									$consumer_id = $row4['id'];
										
									$query20 = "SELECT * FROM ConsumerContacts WHERE contact_type_id = '1' AND consumer_id = '$consumer_id'";	
									$result20 = $con->query($query20);
									$count20 = mysqli_num_rows($result20);
									$row20 = mysqli_fetch_assoc($result20);
												
									$query21 = "SELECT * FROM ConsumerContacts WHERE contact_type_id = '2' AND consumer_id = '$consumer_id'";	
									$result21 = $con->query($query21);
									$count21 = mysqli_num_rows($result21);
									$row21 = mysqli_fetch_assoc($result21);
										
									$query6 = "SELECT * FROM ConsumerLogins WHERE consumer_id = '$consumer_id'";
									$result6 = $con->query($query6);
									$count6 = mysqli_num_rows($result6);
									
									if($count6 > 0)	
									{
										/* update */
										
										$row6 = mysqli_fetch_assoc($result6);
										$date = date('Y-m-d H:i:s');
										$last_contact_datetime = $row6['login_datetime'];
										
										$query7 = "update ConsumerLogins set login_datetime='$date', last_contact_datetime='$last_contact_datetime' where consumer_id='$consumer_id'";
										$result7 = $con->query($query7);
										
										if($con -> query($query7) === TRUE)
										{
											$show = array('result'=>'success','account_id'=>$row1['id'],'first_name'=>$row4['firstname'],'last_name'=>$row4['lastname'],'gender'=>$gender,'date_of_birth'=>$row1['dob'],'email_id'=>$row1['email'],'role'=>'Consumer','profile_image'=>$image_path,'login_type'=>$login_type,'mobile_number'=>$row20['contact_details'],'home_number'=>$row21['contact_details']);
											echo json_encode($show);
										}
										else
										{
											$show = array('result'=>'failed','msg'=>'Server not responding');
											echo json_encode($show);		
										}
									}
									else
									{
										/* insert */
										
										$date = date('Y-m-d H:i:s');
										$query7 = "INSERT INTO ConsumerLogins(consumer_id,login_datetime) VALUES('$consumer_id','$date')";
										$result7 = $con->query($query7);
										if($result7 > 0)
										{
											$show = array('result'=>'success','account_id'=>$row1['id'],'first_name'=>$row4['firstname'],'last_name'=>$row4['lastname'],'gender'=>$gender,'date_of_birth'=>$row1['dob'],'email_id'=>$row1['email'],'role'=>'Consumer','profile_image'=>$image_path,'login_type'=>$login_type,'mobile_number'=>$row20['contact_details'],'home_number'=>$row21['contact_details']);
											echo json_encode($show);
										}
										else
										{
											$show = array('result'=>'failed','msg'=>'Server not responding');
											echo json_encode($show);		
										}
									}
								}
								else
								{
									/* check another user */
									$show = array('result'=>'success','role'=>'OtherUser');
									echo json_encode($show);
								}
							}
							else
							{
								$show = array('result'=>'failed','msg'=>'Update not successfully');
								echo json_encode($show);
							}
					}
					else
					{
						/*$msg = "Your account is $status";*/
						$msg = "Your account has been deactivated, please contact iWasHereUK support";
						$show = array('result'=>'failed','msg'=>$msg);
						echo json_encode($show);
					}
				}
				else
				{	
					$show = array('result'=>'failed','msg'=>'User status not found');
					echo json_encode($show);
				}		
			}
			else
			{	
				$show = array('result'=>'failed', 'msg'=>'The email or password you entered doesn’t match.');	
				echo json_encode($show);			
			}
		}
		else
		{	
			$show = array('result'=>'failed', 'msg'=>'This email is not registered with iWasHereUK.');
			echo json_encode($show);			
		}
	}	
	else
	{		
		$show = array('result'=>'failed','msg'=>'Incomplete parameters');
		echo json_encode($show);
	}	
?>