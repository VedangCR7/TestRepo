<?php
	require_once('./mailer/class.phpmailer_bg.php');	
	
	$email = $_REQUEST['email'];
    $name = $_REQUEST['name'];
    $companyName = $_REQUEST['company'];
    $phone  = $_REQUEST['phone'];
    $subject = $_REQUEST['subject'];
    $description = $_REQUEST['description'];	

	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->SMTPDebug = 1;
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = "ssl";
	$mail->Host = "mail.foodnai.com";
	$mail->Port = 465;
	$mail->IsHTML(true);		
	$mail->Username = "contact@foodnai.com";
	$mail->Password = "MessiArgentina";
	$mail->SetFrom($email);
	$mail->Subject = "Account information";
	$mail->Body = "Please contact Foodnai Support Team for further assistance";
	$mail->AddAddress("contact@foodnai.com");
	
	if($mail->Send())
	{
		echo 'success';
	}
	else
	{
		echo 'failed';
	}	
?>