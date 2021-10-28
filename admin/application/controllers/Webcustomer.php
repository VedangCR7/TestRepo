<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Webcustomer extends MY_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('user_model');	
		$this->load->model('main_menu_model');	
		$this->load->model('customer_model');	

	}

	public function customer_login(){
		
		foreach($_POST as $x => $val) {
			$_POST[$x]=filter_var($_POST[$x], FILTER_SANITIZE_STRING);
		}
		$this->session->unset_userdata('customer');
		$result = $this->customer_model->do_login($_POST);
		if(is_array($result)){
		    $this->json_output(array('status'=>true,'msg'=>"Welcome to foodnai."));
		}
		else{
			$this->json_output(array('status'=>false,'msg'=>"Something went wrong please try again."));
		}
	}

	public function check_contact(){
		$result = $this->customer_model->check_contact($_POST);
		$this->json_output(array('status'=>true,'result'=>$result));
	}


}
?>