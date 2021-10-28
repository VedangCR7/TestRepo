<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Forgot extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->library('phpmailer_lib');
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
			/*$from = "Foodnai<swapnil.machale@rwntrading.com>";*/
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			$headers .= "From:" . $from;
			$output=mail($to,$subject,$msg,$headers);

			$mail = new PHPMailer();
			//$mail->IsSMTP();
			$mail->setFrom('support@foodnai.com', 'Foodnai Tech');
			$mail->addReplyTo('support@foodnai.com', 'Foodnai Tech');
	        $mail->AddAddress($to);
			$mail->Subject= $subject;
			$mail->msgHTML($msg);
			$mail->AltBody = 'This is a plain-text message body';
	        if (!$mail->send()) 
			{
			    echo "Mailer Error: " . $mail->ErrorInfo;
	            return "fail";
			}
			else{
			    return "send";
			}
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