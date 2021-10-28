<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Company extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->is_loggedin();
	}
	
	public function index() {
		$this->load->view('home');
	}

	public  function dashboard()
	{
		$data=array();
		$this->load->view('rest_dashboard',$data);
	}
}
?>