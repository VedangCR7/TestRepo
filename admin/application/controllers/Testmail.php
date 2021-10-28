<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
// Load Composer's autoloader
require 'vendor/autoload.php';
class Testmail extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('user_model');		
	}
	
	public function index() {
		$this->load->view('login');
	}
	
	public function show_success_page()
	{echo 'hi';exit;
		$data=array(
			'data_id'=>'193',
			'email'=>'sushildeokar12@gmail.com',
			'name'=>'sushil deokar'
		);
		
		$msg = $this->load->view('email_template/signup_success',$data, true);
		$msg=$this->convert_to_utf8($msg);
	
		$to='sushildeokar12@gmail.com';
		$subject="Registration Verification email";
		$from = "Foodnai<help@foodnai.com>";
		
		$mail = new PHPMailer(true);
		$mail->SMTPDebug = 0;
		$mail->isSMTP();                         
		$mail->Host = EMAIL_Host;
		$mail->SMTPAuth = EMAIL_SMTPAuth;                          
		$mail->Username = EMAIL_USERNAME;                 
		$mail->Password = EMAIL_PASSWORD;                           
		$mail->SMTPSecure = EMAIL_SMTPSecure;                           
		$mail->Port = EMAIL_Port;                                   
		
		$mail->From = EMAIL_FROMMAIL;
		$mail->FromName = EMAIL_FROMNAME;
		$mail->setFrom(EMAIL_FROMMAIL, EMAIL_FROMNAME);

		$mail->addAddress($to);					
		$mail->isHTML(true);					
		$mail->Subject = $subject;
		$mail->Body = $msg;
		
		if($mail->Send())
		{
			echo 'successful';
		}
		else
		{
			echo 'failed';
		}
	}
}
?>