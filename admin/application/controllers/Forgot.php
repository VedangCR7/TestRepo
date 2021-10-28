<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
// Load Composer's autoloader
require 'vendor/autoload.php';
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
			$from = "Foodnai<support@foodnai.com>";
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
	        
	        $mail->From = EMAIL_FROMMAIL;
	        $mail->FromName = EMAIL_FROMNAME;
	        $mail->setFrom(EMAIL_FROMMAIL, EMAIL_FROMNAME);

	        $mail->addAddress($to);
	            
	        $mail->isHTML(true);
	            
	        $mail->Subject = $subject;
			$mail->Body = $msg;
		 	if(!$mail->Send()) {
		 		$this->json_output(array('status'=>false,'msg'=>"Mailer Error: " . $mail->ErrorInfo));
		    	return;
			}

			$this->json_output(array('status'=>true,'msg'=>"Password reset link sent on your mail id, please follow instructions given in mail to reset password"));
			return;
		}else{
			$a=[]; 

			$manager = $this->Waiting_manager_model->select_where('user_data',['link_used'=>'0']);
			foreach($manager as $key=>$val){
				$data=json_decode($val['user_data']);
				$getemail = $data->email;
				array_push($a,$getemail);
			}
			if(in_array($_POST['email'], $a)){
				$this->json_output(array('status'=>false,'msg'=>"Your account is not verified yet, we have sent verification link on your registered email please check your email and verify account."));
			}
			else{
				$this->json_output(array('status'=>false,'msg'=>"Email address not register with us."));
			}
			
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