<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
// Load Composer's autoloader
require 'vendor/autoload.php';
class Userlogin extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('user_model');		
	}
	
	public function index() {
		$this->load->view('login');
	}

	public function checklogin(){

		$email =$_POST['email'];
        $pass = $_POST['password'];
		$result = $this->user_model->do_login($email, $pass);
	
		if(is_array($result)){
		    $this->json_output(array('status'=>true,'msg'=>$result['name']." you are successfully logged in.",'usertype'=>$result['usertype']));
		}
		else if($result=="notactivated"){
			$this->json_output(array('status'=>false,'msg'=>'Your account is deactivate, please contact FoodNAI Support.'));
		}
		else{
			$this->json_output(array('status'=>false,'msg'=>"The username or password you entered is incorrect"));
		}
	}


}
?>