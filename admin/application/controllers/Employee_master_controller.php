<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Employee_master_controller extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('Employee_model');
	}
	
	public function index() {	
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();	
		$this->load->view('employee_master',$data);
	}

    public function show_individual_details(){
        $category_list=$this->Employee_model->select_category();
		$individual_employee = $this->Employee_model->select_employee($_POST['id']);
		$this->json_output(['individual_emp'=>$individual_employee,'category'=>$category_list]);
	}


	// Add category details
	public function addEmployee(){		
		$employee_details=$this->Employee_model->check_employee_insert($_POST['emp_aadhaar_no']);
		if (!empty($employee_details)) {
			$this->json_output(array('status'=>false,'is_employee_exist'=>true,'msg'=>"Employee already exists."));
				return;
		}
		else{
			$employeeData = array(
				'category' => $this->input->post('emp_category'),
				'emp_sub_category' => $this->input->post('emp_sub_category'), 
				'emp_name' => $this->input->post('emp_name'),
                'emp_email' => $this->input->post('emp_email'),
				'emp_contact' => $this->input->post('emp_contact'),
                'emp_address' => $this->input->post('emp_address'),
				'emp_aadhaar_no' => $this->input->post('emp_aadhaar_no'),	
				'is_active'	=> 1
			);
			if($this->Employee_model->addEmployeeDetails($employeeData)) {
				echo json_encode(array('status' =>true));
			}
			else{
				echo json_encode(array('status' =>false));
			}
		}		
		
	}

	// Display records in table
	public function list_Employee(){
		if(isset($_POST['searchkey']))
			$Employee_details=$this->Employee_model->list_all_Employees($_POST['page'],$_POST['per_page'],$_POST['searchkey']);
		else
		$Employee_details=$this->Employee_model->list_all_Employees($_POST['page'],$_POST['per_page']);
		$this->json_output($Employee_details);
	}

	// Make status active / Inactive
	public function make_active_inactive(){
		// print_r($_POST); exit();
		if($_POST['is_active']=="on")
			$is_active=1;
		else
			$is_active = 0;
			$empId = $this->input->post('id');
			$this->db->where('emp_id',$empId);
			$this->db->update('employee_master',array('is_active'=>$is_active));            
			$this->json_output(['status'=>true]);
	}
	
	// Delete Employee
	public function delete_employee(){
        // print_r($_POST); exit();
		$m=$this->Employee_model;
		$m->id=$_POST['id'];
		$group_id=$m->delete();
		$this->json_output(array('status'=>true));

		$this->Employee_model->delete_employee_details($_POST['id']);
	}

	// Update employee details
	public function editEmployee(){			
		// $category_name=$this->Employee_model->check_employee_update($_POST['emp_name'],$_POST['emp_aadhaar_no']);
		// if (!empty($category_name)) {
		// 	$this->json_output(array('status'=>false,'is_employee_exist'=>true,'msg'=>"Employee already exists."));
		// 		return;
		// }
		// else{
			$empid = $this->input->post('id');
			$editemployeeData = array(			
				'category' => $this->input->post('emp_category'),
				'emp_sub_category'=>$this->input->post('emp_sub_category'),
				'emp_name' => $this->input->post('emp_name'),
				'emp_email' => $this->input->post('emp_email'),
				'emp_contact' => $this->input->post('emp_contact'),
				'emp_address' => $this->input->post('emp_address'),
				'emp_aadhaar_no' => $this->input->post('emp_aadhaar_no')			
				// 'created_at' => date('Y-m-d H:i:s')
			);
			$result=$this->Employee_model->editEmployeeDetails($editemployeeData,$empid);            
			if($result == 1){
				$this->json_output(array('status' =>true));
			}
			else{
				$this->json_output(array('status' =>false));
			}
		// }
		
	}
	
    // Show Category list in Dropdown
    public function show_category_details(){       
		$category_list=$this->Employee_model->select_category();
		$this->json_output($category_list);
	}

	// Show Sub category details in dropdown
	public function get_sub_category(){
		$sub_category_list=$this->Employee_model->select_sub_category($_POST['master_category_id']);
		$this->json_output($sub_category_list);
	}
	
}
?>