<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->is_loggedin();
	}
	
	public function index() {
		$data=array();
		$this->load->view('vendor_dashboard',$data);
	}

	public  function dashboard()
	{
		$data=array();
		$this->load->view('vendor_dashboard',$data);
	}

	public  function menu_group()
	{
		$data=array();
		$this->load->view('menu_group_list',$data);
	}

	
}
?>