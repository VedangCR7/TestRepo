<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
	require_once('mailer/class.phpmailer_bg.php');	
	
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
	$mail->Host = "smtp.zoho.com";
	$mail->Port = 465;
	$mail->IsHTML(true);		
	$mail->Username = "support@foodnai.com";
	$mail->Password = "Foodnai#RSLSolution";
	$mail->SetFrom($email);
	$mail->Subject = "Account information";
	$mail->Body = "Please contact Foodnai Support Team for further assistance";
	$mail->AddAddress("shindeashwini257@gmail.com");
	 
	$mail->Send();
	echo "success";
	/*print_r(error_get_last());
	{
		echo 'success';
	}
	else
	{
		echo 'failed';
	}	*/
?>