<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
// Load Composer's autoloader
require 'vendor/autoload.php';
class Help extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->is_loggedin();
	}
	
	public function index() {
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		$this->load->view('help',$data);
	}              

	public function send_email(){

		ob_start();
		$data=array(
			'name'=>$_POST['name'],
			'email'=>$_POST['email'],
			'message'=>filter_var($_POST['message'], FILTER_SANITIZE_STRING)
		);
		$msg = $this->load->view('email_template/help_email',$data, true);
		/*echo $msg;
		die;*/
        /*$msg="Hello admin<br>
        You got help request from ".$_POST['name']."
        <br>
		Users Email is :- ".$_POST['email']."
		<br>
		".$_POST['message'];*/

		$to = "info@rslsolution.com"; // <– replace with your address here CHANGE CODE
		$subject="Help Email";
		$from = "Foodnai<help@foodnai.com>";
		/*$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= "From:" . $from;
		$output=mail($to,$subject,$msg,$headers);*/
		
		$mail = new PHPMailer(true);
        $mail->SMTPDebug = 0;
        $mail->isSMTP();                         
        $mail->Host = EMAIL_Host;
        $mail->SMTPAuth = EMAIL_SMTPAuth;                          
        $mail->Username = EMAIL_USERNAME;                 
        $mail->Password = EMAIL_PASSWORD;                           
        $mail->SMTPSecure = EMAIL_SMTPSecure;                          
        $mail->Port = EMAIL_Port;                             
        
		// $mail->From = $_POST['email'];
		// $mail->FromName = $_POST['name'];
		// $mail->setFrom($_POST['email'],$_POST['name']);

		$mail->From = EMAIL_FROMMAIL;
		$mail->FromName = EMAIL_FROMNAME;
		$mail->setFrom(EMAIL_FROMMAIL, EMAIL_FROMNAME);


        $mail->addAddress($to);
        $mail->addBcc('munotrupesh@gmail.com');
		
        $mail->isHTML(true);
            
        $mail->Subject = $subject;
		$mail->Body = $msg;
	 	if(!$mail->Send()) {
	 		$this->json_output(array('status'=>false,'msg'=>"Mailer Error: " . $mail->ErrorInfo));
	    	return;
		}


		redirect('help?msg=mailsend');
	}
}
?>