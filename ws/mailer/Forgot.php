<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once(APPPATH.'third_party/phpmailer/src/PHPMailer.php');
require_once(APPPATH.'third_party/phpmailer/src/SMTP.php');
require_once(APPPATH.'third_party/phpmailer/src/Exception.php');
class Forgot extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('user_model');
	}
	
	public function index() {
		$this->load->view('forgot');
	}

	public function test() {
		$this->load->view('email_template/forgot_email');
	}

	public function forgot_password(){
		$u = $this->user_model;
		$status=$u->isexist(array('email'=>$_POST['email']));
		if($status=="exist"){
			ob_start();
			/*error_reporting(E_ALL);
			ini_set('display_errors', 1);*/
			$user_details=$u->get_userdata_byemail($_POST['email']);
		
			$data=array(
				'email'=>$_POST['email'],
				'user'=>$user_details
			);
			$u1=$this->user_model;
			$u1->id=$user_details['id'];
			$u1->forgot_link_used=0;
			$u1->update();

			$msg = $this->load->view('email_template/forgot_email',$data, true);
			$msg=$this->convert_to_utf8($msg);

			$to=$_POST['email']; // <– replace with your address here
			$subject="Forgot Password email";
			/*$from = "Foodnai<support@foodnai.com>";
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			$headers .= "From:" . $from;
			$output=mail($to,$subject,$msg,$headers);*/
			$mail = new PHPMailer(true);
			try {
			    //Server settings
			    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
			    $mail->isSMTP();                                            // Send using SMTP
			    $mail->Host       = 'smtp.zoho.eu';                    // Set the SMTP server to send through
			    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
			    $mail->Username   = 'support@foodnai.com';                     // SMTP username
			    $mail->Password   = 'Foodnai#RSLSolution';                               // SMTP password
			    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
			    $mail->Port       = 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

			    //Recipients
			    $mail->setFrom(EMAIL_FROMMAIL, EMAIL_USERNAME);
			    $mail->addAddress($to, 'Supriya Deshmukh');     // Add a recipient

			    // Content
			    $mail->isHTML(true);                                  // Set email format to HTML
			    $mail->Subject = $subject;
			    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
			    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

			    $mail->send();
			    echo 'Message has been sent';
			} catch (Exception $e) {
			    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
			}

			/*$mail = new PHPMailer(true);
	        $mail->SMTPDebug = 1;
	        $mail->isSMTP();                         
	        $mail->Host = EMAIL_Host;
	        $mail->SMTPAuth = EMAIL_SMTPAuth;                          
	        $mail->Username = EMAIL_USERNAME;                 
	        $mail->Password = EMAIL_PASSWORD;                           
	        $mail->SMTPSecure = EMAIL_SMTPSecure;                           
	        $mail->Port = $Port;                                   
	        
	        $mail->From = EMAIL_FROMMAIL;
	        $mail->FromName = "Foodnai";
	            
	        $mail->addAddress($to);
	            
	        $mail->isHTML(true);
	            
	        $mail->Subject = $subject;
			$mail->Body = $msg;
		 	if(!$mail->Send()) {
		 		$this->json_output(array('status'=>false,'msg'=>"Mailer Error: " . $mail->ErrorInfo));
		    	return;
			}*/

			$this->json_output(array('status'=>true,'msg'=>"Password reset link sent on your mail id, please follow instructions given in mail to reset password"));
			return;
		}else{
		    $this->json_output(array('status'=>false,'msg'=>"Email address not register with us."));
		}
	}


	public function reset_password(){
		$id=str_replace('iandoof', '', $_GET['ref']);
		$id=str_replace('doofina', '', $id);
		$id=intval($id);
		if($id==0){
			$data=array(
					'id'=>'',
					'email'=>'',
					'isvalid'=>"notvalid"
				);
		}else{
			$u = $this->user_model;
			$u->id=$id;
			$user=$u->get();
			if(!empty($user)){
				if($user['forgot_link_used']==0){
					$data=array(
						'id'=>$id,
						'email'=>$user['email'],
						'isvalid'=>"valid"
					);
				}else{
					$data=array(
						'id'=>'',
						'email'=>'',
						'isvalid'=>"notvalid"
					);
				}
			}else{
				$data=array(
					'id'=>'',
					'email'=>'',
					'isvalid'=>"notvalid"
				);
			}
		}
		$this->load->view('reset_password',$data);
	}

	public function reset_user_password(){
		$u = $this->user_model;
		$u->id=$_POST['id'];
		$u->password=$_POST['password'];
		$u->forgot_link_used=1;
		$update=$u->update();
		if($update){
			$this->json_output(array('status'=>true,'msg'=>"Password updated successfully."));
		}else{
		    $this->json_output(array('status'=>false,'msg'=>"Something went wrong please try again."));
		}
	}
}
?>