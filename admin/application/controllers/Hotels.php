<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Hotels extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function index($restid,$tableid) {
		$data=array(
			'restid'=>$restid,
			'tableid'=>$tableid
		);
		$this->load->view('web_hodel',$data);
	}

}
?>