<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Manage_Incentive_master_controller extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('Manage_incentive_model');
		$this->load->model('Waiting_manager_model');
	}

	public function get_non_captain_incentive(){
		$get_incentive = $this->Waiting_manager_model->select_where('incentive_master',['category_name'=>$_POST['category_name']])[0];

		$this->json_output($get_incentive);
	}

	public function update_non_captain_incentive(){
		if($this->Waiting_manager_model->updateactive_inactive('incentive_master',['category_name'=>$_POST['category_name']],['incentives_price'=>$_POST['incentives_price']])){
			$this->json_output(['status'=>true]);
		}else{
			$this->json_output(['status'=>false]);
		}
	}

	public function index() {	
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		if(!isset($_POST)){
			$sql="SELECT r.id,r.name,mg.title,r.price,i.incentives_price from recipes as r
		LEFT JOIN menu_master as mm on mm.id = r.main_menu_id
		LEFT JOIN menu_group as mg on mg.id = r.group_id
		LEFT JOIN incentive_master as i on i.menu_id = r.id
		WHERE r.logged_user_id =".$_SESSION['user_id']." and r.is_active=1 and r.is_delete=0 and r.is_recipe_active=1 and mg.is_active=1 and mm.is_active=1 ORDER BY r.name ASC";
		}else{
			$sql="SELECT r.id,r.name,mg.title,r.price,i.incentives_price from recipes as r
		LEFT JOIN menu_master as mm on mm.id = r.main_menu_id
		LEFT JOIN menu_group as mg on mg.id = r.group_id
		LEFT JOIN incentive_master as i on i.menu_id = r.id
		WHERE r.logged_user_id =".$_SESSION['user_id']." and r.is_active=1 and r.is_delete=0 and r.is_recipe_active=1 and mg.is_active=1 and mm.is_active=1 and r.name like '%".$_POST['recipe_search']."%' ORDER BY r.name ASC";
		
		}
		$data['items']=$this->Waiting_manager_model->query($sql);	
		$this->load->view('manage_incentive_master',$data);
	}

	public function save_captain_incentive(){
		//print_r($_POST);
		$this->db->trans_start();
		foreach($_POST['incentives_price'] as $key=>$value){
			if($value!= ''){
				$check = $this->Waiting_manager_model->select_where('incentive_master',['menu_id'=>$_POST['menu_id'][$key],'category_name'=>'Restaurant manager']);
				if(empty($check)){
					$this->Waiting_manager_model->insert_any_query('incentive_master',['category_name'=>'Restaurant manager','menu_id'=>$_POST['menu_id'][$key],'incentives_price'=>$value]);
				}else{
					$this->Waiting_manager_model->updateactive_inactive('incentive_master',['category_name'=>'Restaurant manager','menu_id'=>$_POST['menu_id'][$key]],['incentives_price'=>$value]);
				}
			}
		}

		if($this->db->trans_complete()){
			$this->json_output(['status'=>true]);
		}else{
			$this->json_output(['status'=>false]);
		}
	}
	
    // Show Menu list in Dropdown
    public function show_category_list(){	
		$category_list=$this->Manage_incentive_model->select_category();
		$this->json_output($category_list);
	}

	// Add & Update Incentive
	public function addIncentive(){	

			$check_categ_id = $this->input->post('master_category_id');
			$this->db->select('maincategory_id');
			$this->db->from('empcategory_master');  
			$this->db->where('id', $check_categ_id);  
			$query=$this->db->get();
			$category_id_result=$query->result_array();
			$category_id = $category_id_result[0]['maincategory_id'];

			$incentive_count=$this->db->select('count(incentive_id) as cnt')->from('incentive_master')->where('category_id',$_POST['master_category_id'])->get()->row_array(); 
			
			if($category_id =='2'){
			for($i=0;$i<count($_POST['incentive_array_value']);$i++){			
				if($incentive_count['cnt']>0){
					$menuid = $_POST['menu_id_array_value'][$i];
					$incentive_id = $_POST['incentive_id'][$i];
					$categ_id = $this->input->post('master_category_id');
					$incentiveData = array(
						'incentives_price' => $_POST['incentive_array_value'][$i]						
					);   
					$response = $this->Manage_incentive_model->updateIncentiveDetails($incentiveData,$menuid,$incentive_id,$categ_id);  
				}else{
					// echo "insert query";
					$incentiveData = array(
						'incentives_price' => $_POST['incentive_array_value'][$i],
						'menu_id' => $_POST['menu_id_array_value'][$i],
						'category_id' => $this->input->post('master_category_id')
					);          
					$response = $this->Manage_incentive_model->addIncentiveDetails($incentiveData); 
				}				           
			}	

			}else if($category_id =='8'){				
					$waiter_details=$this->Manage_incentive_model->verify_range_incentives($_POST['from_range'],$_POST['to_range']);
					if (!empty($waiter_details)) {
						$this->json_output(array('status'=>false,'is_incentives_exist'=>true,'msg'=>"Incentives range already exists."));
							return;
					}else{
						$incentiveData = array(
							'from_range_value' => $_POST['from_range'],
							'to_range_value' => $_POST['to_range'],
							'incentives_price' => $this->input->post('waiter_incentives'),
							'category_id' => $this->input->post('master_category_id')
						);          
						$response = $this->Manage_incentive_model->addIncentiveDetails($incentiveData);
					}					
						
			}else if($category_id =='6'){		
				// print_r($_POST);
				// die("Die here");	
				$kitchen_staff_details=$this->Manage_incentive_model->verify_kitchen_staff_incentives($_POST['kitchen_staff_name']);
				if (!empty($kitchen_staff_details)) {
					$this->json_output(array('status'=>false,'is_incentives_exist'=>true,'msg'=>"Kitchen Staff category already exists."));
						return;
				}else{
					$incentiveData = array(
						'kitchen_staff_name' => $_POST['kitchen_staff_name'],
						'kitchen_staff_incentives' => $_POST['staff_percentage'],
						'kitchen_category_id' => $this->input->post('master_category_id')
					);          
					$response = $this->Manage_incentive_model->saveKitchenIncentiveDetails($incentiveData);
				}
			}  
			       
			if($response==true) {
				echo json_encode(array('status' =>true));
			}
			else{
				echo json_encode(array('status' =>false));
			}
	}
	
	// Display records in table
	public function list_menu(){		
		$menu_details=$this->Manage_incentive_model->list_all_menu($_POST['page'],$_POST['per_page'],$_POST['category_id'],$_POST['searchkey']);      
		$this->json_output($menu_details);
	}

	// update waiter Incentive
	public function editIncentives(){
		$incentive_price=$this->Manage_incentive_model->check_for_range_incentives($_POST['from_range'],$_POST['to_range'],$_POST['incentive_price']);
		
		 if(!empty($incentive_price)) {			
			$incentive_id = $this->input->post('incentive_id');
			$editincentivesData = array(
				'incentives_price' => $this->input->post('incentive_price')
			);
			if($this->Manage_incentive_model->editIncentivesDetails($editincentivesData,$incentive_id)) {
				echo json_encode(array('status' =>true));
			}
			else{
				echo json_encode(array('status' =>false));
			}
		}else{
			$incentive_id = $this->input->post('incentive_id');
			$editincentivesData = array(
				'incentives_price' => $this->input->post('incentive_price')
			);
			if($this->Manage_incentive_model->editIncentivesDetails($editincentivesData,$incentive_id)) {
				echo json_encode(array('status' =>true));
			}
			else{
				echo json_encode(array('status' =>false));
			}
		}
	}

	// update Kitchen Staff Incentive
	public function editKitchenStafIncentives(){
		$incentive_price=$this->Manage_incentive_model->check_kitchen_staff_incentives($_POST['staff_mode'],$_POST['staff_percentage']);
		
		 if(!empty($incentive_price)) {			
			$incentive_id = $this->input->post('incentive_id');
			$editincentivesData = array(
				'kitchen_staff_incentives' => $this->input->post('staff_percentage')
			);
			if($this->Manage_incentive_model->editKitchenStafIncentives_Details($editincentivesData,$incentive_id)) {
				echo json_encode(array('status' =>true));
			}
			else{
				echo json_encode(array('status' =>false));
			}
		}else{
			$incentive_id = $this->input->post('incentive_id');
			$editincentivesData = array(
				'kitchen_staff_incentives' => $this->input->post('staff_percentage')
			);
			if($this->Manage_incentive_model->editKitchenStafIncentives_Details($editincentivesData,$incentive_id)) {
				echo json_encode(array('status' =>true));
			}
			else{
				echo json_encode(array('status' =>false));
			}
		}

	}

	// Delete Incentives
	public function delete_incentives(){
		// print_r($_POST); exit();
		$m=$this->Manage_incentive_model;
		$m->id=$_POST['id'];
		$group_id=$m->delete();
		$this->json_output(array('status'=>true));
		$this->Manage_incentive_model->delete_incentives_details($_POST['id']);
	}
	

	// Delete kitchen Incentives
	public function delete_kitchen_staff_incentives(){
		$m=$this->Manage_incentive_model;
		$m->id=$_POST['id'];
		$group_id=$m->delete();
		$this->json_output(array('status'=>true));
		$this->Manage_incentive_model->delete_kitchen_staff_incentives_details($_POST['id']);

	}

	// get only Category ID from master
	public function get_category_id(){		
			
			$check_categ_id = $_POST['master_category_id'];
			$this->db->select('maincategory_id');
			$this->db->from('empcategory_master');  
			$this->db->where('id', $check_categ_id);  
			$query=$this->db->get();		
			$category_id_result=$query->row_array();	
		
			$category_id_value = $category_id_result['maincategory_id'];
			echo $category_id_value;
			// die();
			// return $category_id_value;
	}
}
?>