<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Incentive_report_controller extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('Incentive_report_model');
	}
	
	public function index() {	
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();	
		$this->load->view('employee_incentive_report',$data);
	}
	
    // Show Category list in Dropdown
    public function show_category_details(){       
		$category_list=$this->Incentive_report_model->select_category();
		$this->json_output($category_list);
	}

	// Get employee details
	public function get_employee(){	
		// $from_date=$_POST['from_date']. ' 00:00:00';
		// $to_date=$_POST['to_date']. ' 23:59:59';		
		$Employee_details=$this->Incentive_report_model->list_all_Employees($_POST['page'],$_POST['per_page'],$_POST['master_category_id'],$_POST['searchkey']);		
		$this->json_output($Employee_details);
	}


}
?>