<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Emp_category_master extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('Emp_Category_model');
	}
	
	public function index() {	
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();	
		$this->load->view('emp_category_master',$data);
	}

	// Add category details --save details
	
	public function addCategory(){		
		$category_name=$this->Emp_Category_model->check_category($_POST['MainCategoryid'],$_POST['Categoryname']);
		if (!empty($category_name)) {
			$this->json_output(array('status'=>false,'is_category_exist'=>true,'msg'=>"Category already exists."));
				return;
		}
		else{
			$categoryData = array(
				'category_name' => $this->input->post('Categoryname'),
				'maincategory_id' => $this->input->post('MainCategoryid'),					
				'is_active'	=> 1
			);
			if($this->Emp_Category_model->addCategoryDetails($categoryData)) {
				echo json_encode(array('status' =>true));
			}
			else{
				echo json_encode(array('status' =>false));
			}
		}		
		
	}

	// Display records in table
	public function list_Category(){
		if(isset($_POST['searchkey']))
			$category_details=$this->Emp_Category_model->list_all_category($_POST['page'],$_POST['per_page'],$_POST['searchkey']);
		else
		$category_details=$this->Emp_Category_model->list_all_category($_POST['page'],$_POST['per_page']);
		$this->json_output($category_details);
	}

	// Make status active / Inactive
	public function make_active_inactive(){
		// print_r($_POST); exit();
		if($_POST['is_active']=="on")
			$is_active=1;
		else
			$is_active = 0;
			$catId = $this->input->post('id');
			$this->db->where('id',$catId);
			$this->db->update('empCategory_Master',array('is_active'=>$is_active));
			$this->json_output(['status'=>true]);
	}
	
	// Delete Category
	public function delete_category(){
		$m=$this->Emp_Category_model;
		$m->id=$_POST['id'];
		$group_id=$m->delete();
		$this->json_output(array('status'=>true));
		$this->Emp_Category_model->delete_category($_POST['id']);
	}

	// Update category
	public function editCategory(){
		// print_r($_POST); exit();
		$maincategory_name=$this->Emp_Category_model->check_maincategory_update($_POST['main_category_id']);
		$subcategory_name=$this->Emp_Category_model->check_subcategory_update($_POST['category_name']);

		if(!empty($maincategory_name)){
			$this->json_output(array('status'=>false,'is_category_exist'=>true,'msg'=>"Main-category already exists."));
			return;
		}else if(!empty($subcategory_name)){
			$this->json_output(array('status'=>false,'is_category_exist'=>true,'msg'=>"category already exists."));
			return;
		}
		else{
			$catid = $this->input->post('category_id');
			$editcategoryData = array(			
				'category_name' => $this->input->post('category_name'),
				'maincategory_id' => $this->input->post('main_category')
			);
			if($this->Emp_Category_model->editCategoryDetails($editcategoryData,$catid)) {
				echo json_encode(array('status' =>true));
			}
			else{
				echo json_encode(array('status' =>false));
			}
		}
		
	}

	// category dropdown
	public function show_category_list(){
		$category_list=$this->Emp_Category_model->select_category();
		$this->json_output($category_list);
	}
	
}
?>