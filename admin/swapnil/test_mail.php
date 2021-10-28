<?php
	
	ini_set("display_errors", "1");
	error_reporting(E_ALL);
	include('connection.php');
       
        #$mail = new PHPMailer(); 
        require_once('../../ws/mailer/class.phpmailer_bg.php');
	# require_once('.:/usr/share/php/libphp-phpmailer/class.phpmailer_bg.php');
        require_once('email_config.php');

	$mail = new PHPMailer(true);
        $mail->SMTPDebug = 1;
        $mail->isSMTP();                         
        $mail->Host = $Host;
        $mail->SMTPAuth = "$SMTPAuth";                          
        $mail->Username = "$email_username";                 
        $mail->Password = "$email_password";                           
        $mail->SMTPSecure = "$SMTPSecure";                           
        $mail->Port = $Port;                                   
            
        $mail->From = "$email_frommail";
        $mail->FromName = "$email_username";
            #$mail->FromName = "$email_username";
        $mail->addAddress("malladaish03@gmail.com");
            
        $mail->isHTML(true);
            
        $mail->Subject = "email confirmation";
	$mail->Body = "Hello";
 	if(!$mail->Send()) {
    	echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
    		echo "Message has been sent";
 	}
?>