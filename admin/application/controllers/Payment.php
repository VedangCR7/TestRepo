<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Payment extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->is_loggedin();
		$this->load->model('user_model');
	}
	
	public function index() {

		$data=array();
		$u=$this->user_model;
		$u->id=$_SESSION['user_id'];
		$data['user']=$u->get();

		$data['sub_result']=$this->user_model->check_subscription($_SESSION['user_id']);
		$data['is_subscribe']=$this->user_model->is_subscribe($_SESSION['user_id']);
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		/*echo "<pre>";
		print_r($data['sub_result']);
		die;*/
		$this->load->view('payment',$data);
	}

}
?>