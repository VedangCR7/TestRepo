<?php
	include('connection.php');

	if(isSet($_REQUEST['email_id']) && isSet($_REQUEST['password']))	
	{
		$email_id = $_REQUEST['email_id'];				
		$password = $_REQUEST['password'];
		$devicetoken=$_REQUEST['devicetoken'];
		$device_type=$_REQUEST['device_type'];
		
		
		$query0 = "SELECT * FROM user WHERE email='$email_id'";	
		$result0 = $con->query($query0);
		$count0 = mysqli_num_rows($result0); 
		
		if($count0 > 0)	
		{			
			$query1 = "SELECT * FROM user WHERE email='$email_id' AND Binary password ='$password'";	
			$result1 = $con->query($query1);
			$count1 = mysqli_num_rows($result1); 
			
			if($count1 > 0)	
			{
				$row1 = mysqli_fetch_assoc($result1);
				$resto_id = $row1['id'];
				$name = $row1['name'];
				
				$show = array('result'=>'success','msg'=>'Login successful.','resto_id'=>$resto_id,'restaarant_name'=>$name);
				echo json_encode($show);
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