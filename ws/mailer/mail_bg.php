<?php
require("mailer.php");
//require("class.phpmailer_bg.php");
$mail = new PHPMailer();

$mail->From = "info@rohini-marriageworld.com";
$mail->FromName = "rohini-marriageworld";
$mail->AddAddress("yogesh.a.kane@gmail.com");   //Optional
$mail->AddReplyTo("info@rohini-marriageworld.com", "Information");

$mail->WordWrap = 50;                                 // set word wrap to 50 characters
$mail->IsHTML(true);                                  // set email format to HTML

$mail->Subject = "Subject";
$mail->Body    = "This is getting correct authetication from class.phpmailer_bg.php";
$mail->AltBody = "This is the body in plain text for non-HTML mail clients";

if(!$mail->Send())
{
   echo "Message could not be sent. <p>";
   echo "Mailer Error: " . $mail->ErrorInfo;
   exit;
}

echo "Message has been sent";
?>

