<?php 
	require_once('mailer/class.phpmailer_bg.php');
	
	if(isset($_REQUEST['email']) && isset($_REQUEST['message']) && isset($_REQUEST['name']) && isset($_REQUEST['phone']) && isset($_REQUEST['subject']))
	{ 
		$email = $_POST['email'];
		$message = $_POST['message'];
		$subject = $_POST['subject'];
		$name = $_POST['name'];
		$phone = $_POST['phone'];
		
		$txt = 'Hi RSL,<br/> <br/> '.$message.'<br /><br/>Regards, <br/>'.$name.'<br/>'.$phone;
		
		//$to = "shindeashwini257@gmail.com";
		$fromEmail = $email;
		$mail = new PHPMailer();
		$mail->IsSMTP(); 
		$mail->SMTPDebug = 1; 
		$mail->SMTPAuth = true; 
		$mail->SMTPSecure = ''; 
		$mail->Host = "mail.rslinfotech.in";
		$mail->Port = 587; 
		$mail->IsHTML(true);
		$mail->Username = "admin@rslinfotech.in";
		$mail->Password = "rsladmin@123";
		$mail->SetFrom($fromEmail);
		$mail->Subject = "Wedding App - " . $subject;
		$mail->Body = $txt;
		$mail->AddAddress("munotrupesh@gmail.com");
		$mail->AddAddress("contactus@rslsolution.com");
		$mail->Timeout = 3600;    
		//$mail->Send();
		  
	}
	if($mail->Send())
		{
			header('Location:http://mywedding-app.com/contact.php');
			exit;
		}
		else
		{
			$show = array('result'=>'failed','msg'=>'Mail not send');
			echo json_encode($show);
			header('Location:http://mywedding-app.com/contact.php?id=0');
			exit;
		}
?>