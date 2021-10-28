<?php
	header("Access-Control-Allow-Origin: *");
	include('connection.php');

	if(isSet($_REQUEST['email_id']) && isSet($_REQUEST['name']) && isSet($_REQUEST['device_type']) && isSet($_REQUEST['device_token']))	
	{
		$email_id = $_REQUEST['email_id'];				
		$name = $_REQUEST['name'];
		$device_token=$_REQUEST['device_token'];
		$device_type=$_REQUEST['device_type'];
		
		$query0 = "SELECT * FROM accounts WHERE email='$email_id'";	
		$result0 = $con->query($query0);
		$count0 = mysqli_num_rows($result0); 
		
		if($count0 > 0)	
		{			
			$row0 = mysqli_fetch_assoc($result0);
			$ac_id = $row0['ac_id'];
			
			$query1 = "UPDATE accounts SET email='$email_id', name ='$name', device_type='$device_type', device_token='$device_token' WHERE ac_id='$ac_id'";	
			$result1 = $con->query($query1);
		}
		else{
			$query1 = "INSERT INTO `accounts`(`email`, `name`, `device_type`, `device_token`) VALUES ('$email_id','$name','$device_type','$device_token')";	
			$result1 = $con->query($query1);
			$ac_id = mysqli_insert_id($con);
		}
			
		if($ac_id > 0)	
		{
			$show = array('result'=>'success','msg'=>'Login successful.','user_id'=>$ac_id,'email'=>$email_id,'name'=>$name);
			echo json_encode($show);
		}
		else
		{	
			$show = array('result'=>'failed', 'msg'=>'Unable to login.');	
			echo json_encode($show);			
		}
	}	
	else
	{		
		$show = array('result'=>'failed','msg'=>'Incomplete parameters');
		echo json_encode($show);
	}	
?>