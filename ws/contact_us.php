<?php
	header("Access-Control-Allow-Origin: *");
	include('connection.php');
	require_once('mailer/class.phpmailer_bg.php');

	if(isSet($_REQUEST['user_id']) && isSet($_REQUEST['category']) && isSet($_REQUEST['message']))	
	{
		$user_id = $_REQUEST['user_id'];				
		$category = $_REQUEST['category'];
		$message = addslashes($_REQUEST['message']);
		
		$query0 = "SELECT * FROM accounts WHERE ac_id='$user_id'";	
		$result0 = $con->query($query0);
		$count0 = mysqli_num_rows($result0); 
		
		if($count0 > 0)	
		{			
			$row0 = mysqli_fetch_assoc($result0);
			$email_id = $row0['email'];
			$usernm = $row0['name'];
	
			$query1 = "INSERT INTO `contact_us`(`account_id`, `category`, `message`) VALUES ('$user_id','$category','$message')";	
			$result1 = mysqli_query($con,$query1);
			$ac_id = mysqli_insert_id($con);
			
			$fromEmail = 'support@foodnai.com';
			$fromEmail1 = 'munotrupesh@gmail.com';
			
			$subject = ucfirst($category);
			$body = "Hello Admin, <br><br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".stripslashes($message)."<br><br>Yours,<br>".$usernm;
                    
			$mail = new PHPMailer();
			$mail->IsSMTP(); 
			$mail->SMTPDebug = 0; 
			$mail->SMTPAuth = false; 
			$mail->SMTPSecure = 'tls'; 
			$mail->Host = "mail.foodnai.com";
			$mail->Port = 25; 
			$mail->IsHTML(true);
			$mail->Username = "support@foodnai.com";
			$mail->Password = "XqxDvWue5{0+";
			$mail->SetFrom($email_id);
			$mail->Subject = $subject;
			$mail->Body = $body;
			$mail->AddAddress($fromEmail);
			$mail->AddAddress($fromEmail1);

			if($mail->Send())
			{
				$show = array('result'=>'success','msg'=>'Message sent successfully.','user_id'=>$user_id,'category'=>$category,'message'=>stripslashes($message));
				echo json_encode($show);
			}
			else{
				$show = array('result'=>'success', 'msg'=>'Message sent successfully without email.');	
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