<?php
	require_once('./mailer/class.phpmailer_bg.php');	
	
	$email=$_REQUEST['email'];	

	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->SMTPDebug = 1;
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = "ssl";
	$mail->Host = "mail.foodnai.com";
	$mail->Port = 465;
	$mail->IsHTML(true);		
	$mail->Username = "support@foodnai.com";
	$mail->Password = "Foodnai#RSLSolution";
	$mail->SetFrom($email);
	$mail->Subject = "Account information";
	$mail->Body = "Please contact Foodnai Support Team for further assistance";
	$mail->AddAddress("support@foodnai.com");
	
	if($mail->Send())
	{
		echo 'success';
	}
	else
	{
		echo 'failed';
	}	
?>