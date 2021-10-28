<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Onboarding extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		//$this->is_loggedin();
		$this->load->model('waiting_manager_model');
		$this->load->model('user_model');
	}
	
	public function onboardingone(){
		$this->load->view('onboardingone');
	}
	
	public function onboardingstepone(){
		$this->load->view('onboardingtwo');
	}
	
	public function get_completed_step(){
		//print_r($_POST);
		$check = $this->waiting_manager_model->select_where('user',['email'=>$_POST['email'],'password'=>$_POST['password']]);
		if(!empty($check)){
			$step = $check[0]['step_completed'];
			
			if($step == 0 || $step == 1){
				$this->json_output(['status'=>true,'step'=>$step,'restaurant_id'=>$check[0]['id']]);
			}
			
			if($step == 2){
				$this->json_output(['status'=>false,'msg'=>'All steps completed']);
			}
		}else{
			$this->json_output(['status'=>false,'msg'=>'Account not found']);
		}
	}
	
	public function login(){
		$this->load->view('onboardinglogin');
	}
	
	public function register(){
		$check = $this->waiting_manager_model->select_where('user',['email'=>$_POST['email']]);
		
		if(empty($check)){
			$_POST['usertype']='Restaurant';
			
			if($this->waiting_manager_model->insert_any_query('user',$_POST)){
				//echo $this->db->last_query();exit();
				$user_id=$this->db->insert_id();
				$menuarray = array(0 => 'Profile',1=>'Dashboard', 2=>'Menu',3=>'Table Management',4=>'Offers',5=>'Help');
				$authority['menu_name'] = implode(',', $menuarray);
				$authority['restaurant_id'] = $user_id;
				$this->user_model->insert_authority_data($authority);
				$this->json_output(['status'=>true,'msg'=>'Register Successfully','last_id'=>$this->db->insert_id()]);
			}else{
				$this->json_output(['status'=>false,'msg'=>'something went wrong']);
			}
		}else{
			$this->json_output(['status'=>false,'msg'=>'Email already exist']);
		}
	}
	
	public function add_step_one(){
		//print_r($_FILES);
		
		
		$this->db->trans_start();
		
		$this->waiting_manager_model->updateactive_inactive('user',['id'=>$_POST['id']],['business_name'=>$_POST['business_name'],'address'=>$_POST['registered_address'],'latitude'=>$_POST['latitude'],'longitude'=>$_POST['longitude']]);
		
		if(!empty($_FILES['trd_document']['name'])){
			$img=$this->insert_trd_document('trd_document');
			if($img['upload'])
			{
				$_POST['trd_document']= 'uploads/trd_document/'.$img['upload_data']['file_name'];
			}
			else
			{
                echo json_encode(['msg'=>'Trd Document - '.strip_tags($img['error'])]);
				exit();
			}
		
		}
		
		
		$data = [];  
     
		$count = count($_FILES['restaurant_photo']['name']);  
		$all_restaurant=[];
		//unset($config);
		$config['upload_path'] = 'uploads/trd_document';   
		$config['allowed_types'] = 'jpg|jpeg|png|gif';
		  for($i=0;$i<$count;$i++){  
		  
			if(!empty($_FILES['restaurant_photo']['name'][$i])){  
		  
				  $_FILES['file']['name'] = $_FILES['restaurant_photo']['name'][$i];  
				  $_FILES['file']['type'] = $_FILES['restaurant_photo']['type'][$i];  
				  $_FILES['file']['tmp_name'] = $_FILES['restaurant_photo']['tmp_name'][$i];  
				  $_FILES['file']['error'] = $_FILES['restaurant_photo']['error'][$i];  
				  $_FILES['file']['size'] = $_FILES['restaurant_photo']['size'][$i];  
			
				  
				  $config['file_name'] = rand(100000, 999999); 
			 
				  $this->load->library('upload');
				  if($this->upload->do_upload('file')){  
					$uploadData = $this->upload->data();
					//print_r($uploadData);
					$filename = $uploadData['file_name'];
			 
					$data['totalFiles'][] = $filename; 
					array_push($all_restaurant,$filename);
				  }else{
					  print_r($this->upload->display_errors());
				  }
			}  
		 
		  }
			
			$all_restaurant_photos = implode('&',$all_restaurant);
		
			$service_option = implode(',',$_POST['service_option']);
			
			$this->waiting_manager_model->insert_any_query('restaurant_details',['user_id'=>$_POST['id'],'trade_license_number'=>$_POST['trade_license_number'],'trade_license_place'=>$_POST['trade_license_place'],'trade_license_date'=>$_POST['trade_licence_date'],'trade_license_date'=>$_POST['trade_licence_date'],'type_of_establishment'=>$_POST['type_of_establishment'],'registered_address'=>$_POST['registered_address'],'establishment_date'=>$_POST['establishment_date'],'mobile_number'=>$_POST['mobile_number'],'landline_number'=>$_POST['landline'],'email'=>$_POST['email'],'fax'=>$_POST['fax'],'country'=>$_POST['country'],'website'=>$_POST['website'],'tax_no'=>$_POST['tax_no'],'service_option'=>$service_option,'trd_document'=>$_POST['trd_document'],'upload_restaurant_photo'=>$all_restaurant_photos]);
			
			foreach($_POST['opening_time'] as $key=>$value){
				$this->waiting_manager_model->insert_any_query('restaurant_opening_closing_time',['user_id'=>$_POST['id'],'day'=>$_POST['days'][$key],'opening_time'=>$value,'closing_time'=>$_POST['closing_time'][$key]]);
			}
			
			$countidfront = count($_FILES['id_front']['name']);  
		  $_POST['in_front'] = [];
		  for($i=0;$i<$countidfront;$i++){
		  
			if(!empty($_FILES['id_front']['name'][$i])){
		  
			  $_FILES['files']['name'] = $_FILES['id_front']['name'][$i];  
			  $_FILES['files']['type'] = $_FILES['id_front']['type'][$i];  
			  $_FILES['files']['tmp_name'] = $_FILES['id_front']['tmp_name'][$i];  
			  $_FILES['files']['error'] = $_FILES['id_front']['error'][$i];  
			  $_FILES['files']['size'] = $_FILES['id_front']['size'][$i];  
		
			  $config['upload_path'] = 'uploads/trd_document';   
			  $config['allowed_types'] = 'jpg|jpeg|png|gif';
			  $config['file_name'] = rand(100000, 999999);;  
		 
			  $this->load->library('upload');
		$this->upload->initialize($config);
		  
			  if($this->upload->do_upload('files')){  
				$uploadData = $this->upload->data();  
				$filename = $uploadData['file_name'];
		 
				$data['id_front'][] = $filename; 
				array_push($_POST['in_front'],$filename);
			  }else{
				  //print_r($this->upload->display_errors());
				  $data['id_front'][] = ''; 
			  }
			  
			}else{
				$filename='';
				array_push($_POST['in_front'],$filename);
			}
		  }
		  
			
			$countidback = count($_FILES['id_back']['name']);  
			  $_POST['in_back'] = [];
			  for($i=0;$i<$countidfront;$i++){  
			  
				if(!empty($_FILES['id_back']['name'][$i])){  
			  
				  $_FILES['files1']['name'] = $_FILES['id_back']['name'][$i];  
				  $_FILES['files1']['type'] = $_FILES['id_back']['type'][$i];  
				  $_FILES['files1']['tmp_name'] = $_FILES['id_back']['tmp_name'][$i];  
				  $_FILES['files1']['error'] = $_FILES['id_back']['error'][$i];  
				  $_FILES['files1']['size'] = $_FILES['id_back']['size'][$i];  
			
				  $config['upload_path'] = 'uploads/trd_document';   
				  $config['allowed_types'] = 'jpg|jpeg|png|gif';
				  $config['file_name'] = rand(100000, 999999);;  
			 
				  $this->load->library('upload');
					$this->upload->initialize($config);  
				
				  if($this->upload->do_upload('files1')){  
					$uploadData = $this->upload->data();  
					$filename = $uploadData['file_name'];
			 
					$data['id_back'][] = $filename; 
					array_push($_POST['in_back'],$filename);
				  }else{
					  //print_r($this->upload->display_errors());
					  $data['id_back'][] = ''; 
				  }
				  
				}else{
					$filename='';
					array_push($_POST['in_back'],$filename);
				}
			  }
			  
			  $countupload_image = count($_FILES['upload_image']['name']);  
			  $_POST['upload_image'] = [];
			  for($i=0;$i<$countupload_image;$i++){  
			  
				if(!empty($_FILES['upload_image']['name'][$i])){  
			  
				  $_FILES['files2']['name'] = $_FILES['upload_image']['name'][$i];  
				  $_FILES['files2']['type'] = $_FILES['upload_image']['type'][$i];  
				  $_FILES['files2']['tmp_name'] = $_FILES['upload_image']['tmp_name'][$i];  
				  $_FILES['files2']['error'] = $_FILES['upload_image']['error'][$i];  
				  $_FILES['files2']['size'] = $_FILES['upload_image']['size'][$i];  
			
				  $config['upload_path'] = 'uploads/trd_document';   
				  $config['allowed_types'] = 'jpg|jpeg|png|gif';
				  $config['file_name'] = rand(100000, 999999);;  
			 
				  $this->load->library('upload');
		$this->upload->initialize($config);  
				
				  if($this->upload->do_upload('files2')){  
					$uploadData = $this->upload->data();  
					$filename = $uploadData['file_name'];
			 
					$data['upload_image'][] = $filename; 
					array_push($_POST['upload_image'],$filename);
				  }else{
				  }
				  
				}else{
					$filename='';
					array_push($_POST['upload_image'],$filename);
				}
			  }
			  
			  foreach($_POST['authorized_person_name'] as $key=>$value){
				  $this->waiting_manager_model->insert_any_query('restaurant_authorized_person',['user_id'=>$_POST['id'],'id_front'=>$_POST['in_front'][$key],'id_back'=>$_POST['in_back'][$key],'upload_img'=>$_POST['upload_image'][$key],'full_name'=>$value,'id_number'=>$_POST['authorized_person_id'][$key],'id_expiry_date'=>$_POST['authorized_person_id_expiry_date'][$key],'gender'=>$_POST['authorized_person_gender'][$key],'nationality'=>$_POST['authorized_person_nationality'][$key],'dob'=>$_POST['authorized_person_dob'][$key],'mobile_number'=>$_POST['authorized_person_mob'][$key],'landline_number'=>$_POST['authorized_person_landline'][$key],'fax'=>$_POST['authorized_person_fax'][$key],'email_id'=>$_POST['authorized_person_email'][$key],'designation'=>$_POST['authorized_person_designation'][$key],'country_of_birth'=>$_POST['authorized_person_country_of_birth'][$key]]);
			  }
			  
			  if($this->db->trans_complete()){
				  $this->waiting_manager_model->updateactive_inactive('user',['id'=>$_POST['id']],['step_completed'=>1]);
				 $this->json_output(['status'=>true,'msg'=>'Step one save successfully']); 
			  }
	}
	
	public function add_step_second(){
		//print_r($_POST);exit();
		$this->db->trans_start();
		$countidfront = count($_FILES['id_front']['name']);  
		  $_POST['in_front'] = [];
		  for($i=0;$i<$countidfront;$i++){
		  
			if(!empty($_FILES['id_front']['name'][$i])){
		  
			  $_FILES['files']['name'] = $_FILES['id_front']['name'][$i];  
			  $_FILES['files']['type'] = $_FILES['id_front']['type'][$i];  
			  $_FILES['files']['tmp_name'] = $_FILES['id_front']['tmp_name'][$i];  
			  $_FILES['files']['error'] = $_FILES['id_front']['error'][$i];  
			  $_FILES['files']['size'] = $_FILES['id_front']['size'][$i];  
		
			  $config['upload_path'] = 'uploads/trd_document';   
			  $config['allowed_types'] = 'jpg|jpeg|png|gif';
			  $config['file_name'] = rand(100000, 999999);
		 
			  $this->load->library('upload');
		$this->upload->initialize($config);
		  
			  if($this->upload->do_upload('files')){  
				$uploadData = $this->upload->data();  
				$filename = $uploadData['file_name'];
		 
				$data['id_front'][] = $filename; 
				array_push($_POST['in_front'],$filename);
			  }else{
				  //print_r($this->upload->display_errors());
				  $data['id_front'][] = ''; 
			  }
			  
			}else{
				$filename='';
				array_push($_POST['in_front'],$filename);
			}
		  }
		  
			
			$countidback = count($_FILES['id_back']['name']);  
			  $_POST['in_back'] = [];
			  for($i=0;$i<$countidfront;$i++){  
			  
				if(!empty($_FILES['id_back']['name'][$i])){  
			  
				  $_FILES['files1']['name'] = $_FILES['id_back']['name'][$i];  
				  $_FILES['files1']['type'] = $_FILES['id_back']['type'][$i];  
				  $_FILES['files1']['tmp_name'] = $_FILES['id_back']['tmp_name'][$i];  
				  $_FILES['files1']['error'] = $_FILES['id_back']['error'][$i];  
				  $_FILES['files1']['size'] = $_FILES['id_back']['size'][$i];  
			
				  $config['upload_path'] = 'uploads/trd_document';   
				  $config['allowed_types'] = 'jpg|jpeg|png|gif';
				  $config['file_name'] = rand(100000, 999999);;  
			 
				  $this->load->library('upload');
					$this->upload->initialize($config);   
				
				  if($this->upload->do_upload('files1')){  
					$uploadData = $this->upload->data();  
					$filename = $uploadData['file_name'];
			 
					$data['id_back'][] = $filename; 
					array_push($_POST['in_back'],$filename);
				  }else{
					  //print_r($this->upload->display_errors());
					  $data['id_back'][] = ''; 
				  }
				  
				}else{
					$filename='';
					array_push($_POST['in_back'],$filename);
				}
			  }
			  
			  $countupload_image = count($_FILES['upload_images']['name']);  
			  $_POST['upload_image'] = [];
			  for($i=0;$i<$countupload_image;$i++){  
			  
				if(!empty($_FILES['upload_image']['name'][$i])){  
			  
				  $_FILES['files2']['name'] = $_FILES['upload_images']['name'][$i];  
				  $_FILES['files2']['type'] = $_FILES['upload_images']['type'][$i];  
				  $_FILES['files2']['tmp_name'] = $_FILES['upload_images']['tmp_name'][$i];  
				  $_FILES['files2']['error'] = $_FILES['upload_images']['error'][$i];  
				  $_FILES['files2']['size'] = $_FILES['upload_images']['size'][$i];  
			
				  $config['upload_path'] = 'uploads/trd_document';   
				  $config['allowed_types'] = 'jpg|jpeg|png|gif';
				  $config['file_name'] = rand(100000, 999999);;  
			 
					$this->load->library('upload');
					$this->upload->initialize($config);
				  if($this->upload->do_upload('files2')){  
					$uploadData = $this->upload->data();  
					$filename = $uploadData['file_name'];
			 
					$data['upload_image'][] = $filename; 
					array_push($_POST['upload_image'],$filename);
				  }else{
				  }
				  
				}else{
					$filename='';
					array_push($_POST['upload_image'],$filename);
				}
			  }
			  
			  foreach($_POST['authorized_person_name'] as $key=>$value){
				  if($value!=''){
					$this->waiting_manager_model->insert_any_query('restaurant_propritor_details',['user_id'=>$_POST['id'],'id_front'=>$_POST['in_front'][$key],'id_back'=>$_POST['in_back'][$key],'upload_img'=>$_POST['upload_image'][$key],'full_name'=>$value,'id_number'=>$_POST['authorized_person_id'][$key],'id_expiry_date'=>$_POST['authorized_person_id_expiry_date'][$key],'gender'=>$_POST['authorized_person_gender'][$key],'nationality'=>$_POST['authorized_person_nationality'][$key],'dob'=>$_POST['authorized_person_dob'][$key],'mobile_number'=>$_POST['authorized_person_mob'][$key],'landline_number'=>$_POST['authorized_person_landline'][$key],'fax'=>$_POST['authorized_person_fax'][$key],'email_id'=>$_POST['authorized_person_email'][$key],'designation'=>$_POST['authorized_person_designation'][$key],'country_of_birth'=>$_POST['authorized_person_country_of_birth'][$key]]);
				  }
			  }
			  
			  if($this->db->trans_complete()){
				  $this->waiting_manager_model->updateactive_inactive('user',['id'=>$_POST['id']],['step_completed'=>2]);
				 $this->json_output(['status'=>true,'msg'=>'Step one save successfully']); 
			  }
	}
	
	
	public function onboardingstepthree(){
		$this->load->view('onboardingthree');
	}
	
	public function get_previous_details(){
		$get_details = $this->waiting_manager_model->select_where('restaurant_authorized_person',['user_id'=>$_POST['id']]);
		//echo $this->db->last_query();
		$this->json_output($get_details);
	}
	
	
	public function insert_trd_document($img){
		$config['upload_path']         	= 'uploads/trd_document';
		$config['allowed_types']        = 'gif|jpg|png|jpeg|pdf|xls|csv';
        $config['file_name'] = rand(100000, 999999);
        $this->load->library('upload');
		$this->upload->initialize($config);
        if ( ! $this->upload->do_upload($img))
        {
            return $error = array('upload'=>false,'error' => $this->upload->display_errors());
        }
        else
        {
            return $data = array('upload'=>true,'upload_data' => $this->upload->data());
        }
	}
	
	public function onboardingupdate(){
		$this->load->view('onboardingoverview');
	}
	
	public function get_company_name(){
		$get_company_details=$this->waiting_manager_model->select_where('user',['id'=>$_POST['id']]);
		$this->json_output($get_company_details);
	}
	
	public function get_company_details(){
		$get_company_details=$this->waiting_manager_model->select_where('restaurant_details',['user_id'=>$_POST['id']]);
		$this->json_output($get_company_details);
	}
	
	public function get_company_open_close_time(){
		$get_company_details=$this->waiting_manager_model->select_where('restaurant_opening_closing_time',['user_id'=>$_POST['id']]);
		$this->json_output($get_company_details);
	}
	
	public function update_final_step(){
		$this->db->trans_start();
		
		$this->waiting_manager_model->updateactive_inactive('user',['id'=>$_POST['id']],['business_name'=>$_POST['business_name'],'latitude'=>$_POST['latitude'],'longitude'=>$_POST['longitude']]);
		
		if(!empty($_FILES['trd_document']['name'])){
			$img=$this->insert_trd_document('trd_document');
			if($img['upload'])
			{
				$_POST['trd_document']= 'uploads/trd_document/'.$img['upload_data']['file_name'];
			}
			else
			{
                echo json_encode(['msg'=>'Trd Document - '.strip_tags($img['error'])]);
			}
		
		}
			
		
		
		$data = [];  
     
		$count = count($_FILES['restaurant_photo']['name']);  
		$all_restaurant=[];
		//unset($config);
		$config['upload_path'] = 'uploads/trd_document';   
		$config['allowed_types'] = 'jpg|jpeg|png|gif';
		  for($i=0;$i<$count;$i++){  
		  
			if(!empty($_FILES['restaurant_photo']['name'][$i])){  
		  
				  $_FILES['file']['name'] = $_FILES['restaurant_photo']['name'][$i];  
				  $_FILES['file']['type'] = $_FILES['restaurant_photo']['type'][$i];  
				  $_FILES['file']['tmp_name'] = $_FILES['restaurant_photo']['tmp_name'][$i];  
				  $_FILES['file']['error'] = $_FILES['restaurant_photo']['error'][$i];  
				  $_FILES['file']['size'] = $_FILES['restaurant_photo']['size'][$i];  
			
				  
				  $config['file_name'] = rand(100000, 999999); 
			 
				  //$this->load->library('upload',$config);
				  $this->load->library('upload');
				$this->upload->initialize($config);
				  if($this->upload->do_upload('file')){  
					$uploadData = $this->upload->data();
					//print_r($uploadData);
					$filename = $uploadData['file_name'];
			 
					$data['totalFiles'][] = $filename; 
					array_push($all_restaurant,$filename);
				  }
			}  
		 
		  }
			
			$all_restaurant_photos = implode('&',$all_restaurant);
		
			$service_option = implode(',',$_POST['service_option']);
			
			if($all_restaurant_photos!='' && $_POST['trd_document'] !=''){
				$this->waiting_manager_model->updateactive_inactive('restaurant_details',['user_id'=>$_POST['id']],['trade_license_number'=>$_POST['trade_license_number'],'trade_license_place'=>$_POST['trade_license_place'],'trade_license_date'=>$_POST['trade_licence_date'],'trade_license_date'=>$_POST['trade_licence_date'],'type_of_establishment'=>$_POST['type_of_establishment'],'registered_address'=>$_POST['registered_address'],'establishment_date'=>$_POST['establishment_date'],'mobile_number'=>$_POST['mobile_number'],'landline_number'=>$_POST['landline'],'email'=>$_POST['email'],'fax'=>$_POST['fax'],'country'=>$_POST['country'],'website'=>$_POST['website'],'tax_no'=>$_POST['tax_no'],'service_option'=>$service_option,'trd_document'=>$_POST['trd_document'],'upload_restaurant_photo'=>$all_restaurant_photos]);
			}
			
			if($all_restaurant_photos!='' && $_POST['trd_document'] ==''){
				$this->waiting_manager_model->updateactive_inactive('restaurant_details',['user_id'=>$_POST['id']],['trade_license_number'=>$_POST['trade_license_number'],'trade_license_place'=>$_POST['trade_license_place'],'trade_license_date'=>$_POST['trade_licence_date'],'trade_license_date'=>$_POST['trade_licence_date'],'type_of_establishment'=>$_POST['type_of_establishment'],'registered_address'=>$_POST['registered_address'],'establishment_date'=>$_POST['establishment_date'],'mobile_number'=>$_POST['mobile_number'],'landline_number'=>$_POST['landline'],'email'=>$_POST['email'],'fax'=>$_POST['fax'],'country'=>$_POST['country'],'website'=>$_POST['website'],'tax_no'=>$_POST['tax_no'],'service_option'=>$service_option,'upload_restaurant_photo'=>$all_restaurant_photos]);
			}
			
			if($all_restaurant_photos=='' && $_POST['trd_document'] !=''){
				$this->waiting_manager_model->updateactive_inactive('restaurant_details',['user_id'=>$_POST['id']],['trade_license_number'=>$_POST['trade_license_number'],'trade_license_place'=>$_POST['trade_license_place'],'trade_license_date'=>$_POST['trade_licence_date'],'trade_license_date'=>$_POST['trade_licence_date'],'type_of_establishment'=>$_POST['type_of_establishment'],'registered_address'=>$_POST['registered_address'],'establishment_date'=>$_POST['establishment_date'],'mobile_number'=>$_POST['mobile_number'],'landline_number'=>$_POST['landline'],'email'=>$_POST['email'],'fax'=>$_POST['fax'],'country'=>$_POST['country'],'website'=>$_POST['website'],'tax_no'=>$_POST['tax_no'],'service_option'=>$service_option,'trd_document'=>$_POST['trd_document']]);
			}
			
			if($all_restaurant_photos=='' && $_POST['trd_document'] ==''){
				$this->waiting_manager_model->updateactive_inactive('restaurant_details',['user_id'=>$_POST['id']],['trade_license_number'=>$_POST['trade_license_number'],'trade_license_place'=>$_POST['trade_license_place'],'trade_license_date'=>$_POST['trade_licence_date'],'trade_license_date'=>$_POST['trade_licence_date'],'type_of_establishment'=>$_POST['type_of_establishment'],'registered_address'=>$_POST['registered_address'],'establishment_date'=>$_POST['establishment_date'],'mobile_number'=>$_POST['mobile_number'],'landline_number'=>$_POST['landline'],'email'=>$_POST['email'],'fax'=>$_POST['fax'],'country'=>$_POST['country'],'website'=>$_POST['website'],'tax_no'=>$_POST['tax_no'],'service_option'=>$service_option]);
			}
			
			foreach($_POST['opening_time'] as $key=>$value){
				$this->waiting_manager_model->updateactive_inactive('restaurant_opening_closing_time',['user_id'=>$_POST['id'],'day'=>$_POST['days'][$key]],['opening_time'=>$value,'closing_time'=>$_POST['closing_time'][$key]]);
			}
			
			if($this->db->trans_complete()){
				$this->json_output(['status'=>true,'msg'=>'Information updated_successfully']);
			}
	}
	
	public function add_authorized_person(){
		$this->db->trans_start();
		$countidfront = count($_FILES['id_front']['name']);  
		  $_POST['in_front'] = [];
		  for($i=0;$i<$countidfront;$i++){
		  
			if(!empty($_FILES['id_front']['name'][$i])){
		  
			  $_FILES['files']['name'] = $_FILES['id_front']['name'][$i];  
			  $_FILES['files']['type'] = $_FILES['id_front']['type'][$i];  
			  $_FILES['files']['tmp_name'] = $_FILES['id_front']['tmp_name'][$i];  
			  $_FILES['files']['error'] = $_FILES['id_front']['error'][$i];  
			  $_FILES['files']['size'] = $_FILES['id_front']['size'][$i];  
		
			  $config['upload_path'] = 'uploads/trd_document';   
			  $config['allowed_types'] = 'jpg|jpeg|png|gif';
			  $config['file_name'] = rand(100000, 999999);;  
		 
			  $this->load->library('upload');
		$this->upload->initialize($config);
		  
			  if($this->upload->do_upload('files')){  
				$uploadData = $this->upload->data();  
				$filename = $uploadData['file_name'];
		 
				$data['id_front'][] = $filename; 
				array_push($_POST['in_front'],$filename);
			  }else{
				  //print_r($this->upload->display_errors());
				  $data['id_front'][] = ''; 
			  }
			  
			}else{
				$filename='';
				array_push($_POST['in_front'],$filename);
			}
		  }
		  
			
			$countidback = count($_FILES['id_back']['name']);  
			  $_POST['in_back'] = [];
			  for($i=0;$i<$countidfront;$i++){  
			  
				if(!empty($_FILES['id_back']['name'][$i])){  
			  
				  $_FILES['files1']['name'] = $_FILES['id_back']['name'][$i];  
				  $_FILES['files1']['type'] = $_FILES['id_back']['type'][$i];  
				  $_FILES['files1']['tmp_name'] = $_FILES['id_back']['tmp_name'][$i];  
				  $_FILES['files1']['error'] = $_FILES['id_back']['error'][$i];  
				  $_FILES['files1']['size'] = $_FILES['id_back']['size'][$i];  
			
				  $config['upload_path'] = 'uploads/trd_document';   
				  $config['allowed_types'] = 'jpg|jpeg|png|gif';
				  $config['file_name'] = rand(100000, 999999);;  
			 
				  $this->load->library('upload');
		$this->upload->initialize($config);
				
				  if($this->upload->do_upload('files1')){  
					$uploadData = $this->upload->data();  
					$filename = $uploadData['file_name'];
			 
					$data['id_back'][] = $filename; 
					array_push($_POST['in_back'],$filename);
				  }else{
					  //print_r($this->upload->display_errors());
					  $data['id_back'][] = ''; 
				  }
				  
				}else{
					$filename='';
					array_push($_POST['in_back'],$filename);
				}
			  }
			  
			  $countupload_image = count($_FILES['upload_image']['name']);  
			  $_POST['upload_image'] = [];
			  for($i=0;$i<$countupload_image;$i++){  
			  
				if(!empty($_FILES['upload_image']['name'][$i])){  
			  
				  $_FILES['files2']['name'] = $_FILES['upload_image']['name'][$i];  
				  $_FILES['files2']['type'] = $_FILES['upload_image']['type'][$i];  
				  $_FILES['files2']['tmp_name'] = $_FILES['upload_image']['tmp_name'][$i];  
				  $_FILES['files2']['error'] = $_FILES['upload_image']['error'][$i];  
				  $_FILES['files2']['size'] = $_FILES['upload_image']['size'][$i];  
			
				  $config['upload_path'] = 'uploads/trd_document';   
				  $config['allowed_types'] = 'jpg|jpeg|png|gif';
				  $config['file_name'] = rand(100000, 999999);;  
			 
				  $this->load->library('upload');
		$this->upload->initialize($config);  
				
				  if($this->upload->do_upload('files2')){  
					$uploadData = $this->upload->data();  
					$filename = $uploadData['file_name'];
			 
					$data['upload_image'][] = $filename; 
					array_push($_POST['upload_image'],$filename);
				  }else{
				  }
				  
				}else{
					$filename='';
					array_push($_POST['upload_image'],$filename);
				}
			  }
			  
			  foreach($_POST['authorized_person_name'] as $key=>$value){
				  $this->waiting_manager_model->insert_any_query('restaurant_authorized_person',['user_id'=>$_POST['id'],'id_front'=>$_POST['in_front'][$key],'id_back'=>$_POST['in_back'][$key],'upload_img'=>$_POST['upload_image'][$key],'full_name'=>$value,'id_number'=>$_POST['authorized_person_id'][$key],'id_expiry_date'=>$_POST['authorized_person_id_expiry_date'][$key],'gender'=>$_POST['authorized_person_gender'][$key],'nationality'=>$_POST['authorized_person_nationality'][$key],'dob'=>$_POST['authorized_person_dob'][$key],'mobile_number'=>$_POST['authorized_person_mob'][$key],'landline_number'=>$_POST['authorized_person_landline'][$key],'fax'=>$_POST['authorized_person_fax'][$key],'email_id'=>$_POST['authorized_person_email'][$key],'designation'=>$_POST['authorized_person_designation'][$key],'country_of_birth'=>$_POST['authorized_person_country_of_birth'][$key]]);
			  }
			  
			  if($this->db->trans_complete()){
				 $this->json_output(['status'=>true,'msg'=>'Authorized person added successfully']); 
			  }
	}
	
	
	public function get_perticular_authorize_person(){
		$get_person = $this->waiting_manager_model->select_where('restaurant_authorized_person',['id'=>$_POST['id']]);
		$this->json_output($get_person);
	}
	
	public function edit_authorized_person_details(){
		$this->db->trans_start();
		$countidfront = count($_FILES['id_front']['name']);  
		  $_POST['in_front'] = [];
		  for($i=0;$i<$countidfront;$i++){
		  
			if(!empty($_FILES['id_front']['name'][$i])){
		  
			  $_FILES['files']['name'] = $_FILES['id_front']['name'][$i];  
			  $_FILES['files']['type'] = $_FILES['id_front']['type'][$i];  
			  $_FILES['files']['tmp_name'] = $_FILES['id_front']['tmp_name'][$i];  
			  $_FILES['files']['error'] = $_FILES['id_front']['error'][$i];  
			  $_FILES['files']['size'] = $_FILES['id_front']['size'][$i];  
		
			  $config['upload_path'] = 'uploads/trd_document';   
			  $config['allowed_types'] = 'jpg|jpeg|png|gif';
			  $config['file_name'] = rand(100000, 999999); 
		 
			  $this->load->library('upload');
		$this->upload->initialize($config);
		  
			  if($this->upload->do_upload('files')){  
				$uploadData = $this->upload->data();  
				$filename = $uploadData['file_name'];
		 
				$data['id_front'][] = $filename; 
				array_push($_POST['in_front'],$filename);
			  }else{
				  //print_r($this->upload->display_errors());
				  $data['id_front'][] = ''; 
			  }
			  
			}
		  }
		  
			
			$countidback = count($_FILES['id_back']['name']);  
			  $_POST['in_back'] = [];
			  for($i=0;$i<$countidfront;$i++){  
			  
				if(!empty($_FILES['id_back']['name'][$i])){  
			  
				  $_FILES['files1']['name'] = $_FILES['id_back']['name'][$i];  
				  $_FILES['files1']['type'] = $_FILES['id_back']['type'][$i];  
				  $_FILES['files1']['tmp_name'] = $_FILES['id_back']['tmp_name'][$i];  
				  $_FILES['files1']['error'] = $_FILES['id_back']['error'][$i];  
				  $_FILES['files1']['size'] = $_FILES['id_back']['size'][$i];  
			
				  $config['upload_path'] = 'uploads/trd_document';   
				  $config['allowed_types'] = 'jpg|jpeg|png|gif';
				  $config['file_name'] = rand(100000, 999999);;  
			 
				  $this->load->library('upload');
		$this->upload->initialize($config);  
				
				  if($this->upload->do_upload('files1')){  
					$uploadData = $this->upload->data();  
					$filename = $uploadData['file_name'];
			 
					$data['id_back'][] = $filename; 
					array_push($_POST['in_back'],$filename);
				  }else{
					  //print_r($this->upload->display_errors());
					  $data['id_back'][] = ''; 
				  }
				  
				}
			  }
			  
			  $countupload_image = count($_FILES['upload_image']['name']);  
			  $_POST['upload_image'] = [];
			  for($i=0;$i<$countupload_image;$i++){  
			  
				if(!empty($_FILES['upload_image']['name'][$i])){  
			  
				  $_FILES['files2']['name'] = $_FILES['upload_image']['name'][$i];  
				  $_FILES['files2']['type'] = $_FILES['upload_image']['type'][$i];  
				  $_FILES['files2']['tmp_name'] = $_FILES['upload_image']['tmp_name'][$i];  
				  $_FILES['files2']['error'] = $_FILES['upload_image']['error'][$i];  
				  $_FILES['files2']['size'] = $_FILES['upload_image']['size'][$i];  
			
				  $config['upload_path'] = 'uploads/trd_document';   
				  $config['allowed_types'] = 'jpg|jpeg|png|gif';
				  $config['file_name'] = rand(100000, 999999);;  
			 
				  $this->load->library('upload');
		$this->upload->initialize($config);   
				
				  if($this->upload->do_upload('files2')){  
					$uploadData = $this->upload->data();  
					$filename = $uploadData['file_name'];
			 
					$data['upload_image'][] = $filename; 
					array_push($_POST['upload_image'],$filename);
				  }else{
				  }
				  
				}
			  }
			  
			  foreach($_POST['authorized_person_name'] as $key=>$value){
				  $this->waiting_manager_model->updateactive_inactive('restaurant_authorized_person',['id'=>$_POST['id']],['full_name'=>$value,'id_number'=>$_POST['authorized_person_id'][$key],'id_expiry_date'=>$_POST['authorized_person_id_expiry_date'][$key],'gender'=>$_POST['authorized_person_gender'][$key],'nationality'=>$_POST['authorized_person_nationality'][$key],'dob'=>$_POST['authorized_person_dob'][$key],'mobile_number'=>$_POST['authorized_person_mob'][$key],'landline_number'=>$_POST['authorized_person_landline'][$key],'fax'=>$_POST['authorized_person_fax'][$key],'email_id'=>$_POST['authorized_person_email'][$key],'designation'=>$_POST['authorized_person_designation'][$key],'country_of_birth'=>$_POST['authorized_person_country_of_birth'][$key]]);
					
					if($_POST['in_front'][$key]!=''){
						$this->waiting_manager_model->updateactive_inactive('restaurant_authorized_person',['id'=>$_POST['id']],['id_front'=>$_POST['in_front'][$key]]);
			  
					}
					
					if($_POST['in_back'][$key]!=''){
						$this->waiting_manager_model->updateactive_inactive('restaurant_authorized_person',['id'=>$_POST['id']],['id_back'=>$_POST['in_back'][$key]]);
			  
					}
					
					if($_POST['upload_image'][$key]!=''){
						$this->waiting_manager_model->updateactive_inactive('restaurant_authorized_person',['id'=>$_POST['id']],['upload_img'=>$_POST['upload_image'][$key]]);
			  
					}
			  }
			  
			  if($this->db->trans_complete()){
				 $this->json_output(['status'=>true,'msg'=>'Authorized person details save successfully']); 
			  }
	}
	
	public function delete_authorized_person(){
		$this->waiting_manager_model->permanent_delete_manager('restaurant_authorized_person',['id'=>$_POST['id']]);
		$this->json_output(['status'=>true]);
	}
	
	public function delete_proprietor_person(){
		$this->waiting_manager_model->permanent_delete_manager('restaurant_propritor_details',['id'=>$_POST['id']]);
		$this->json_output(['status'=>true]);
	}
	
	public function get_previous_proprietor_details(){
		$get_person = $this->waiting_manager_model->select_where('restaurant_propritor_details',['user_id'=>$_POST['id']]);
		$this->json_output($get_person);
	}
	
	public function add_proprietor_person(){
		$this->db->trans_start();
		$countidfront = count($_FILES['id_front']['name']);  
		  $_POST['in_front'] = [];
		  for($i=0;$i<$countidfront;$i++){
		  
			if(!empty($_FILES['id_front']['name'][$i])){
		  
			  $_FILES['files']['name'] = $_FILES['id_front']['name'][$i];  
			  $_FILES['files']['type'] = $_FILES['id_front']['type'][$i];  
			  $_FILES['files']['tmp_name'] = $_FILES['id_front']['tmp_name'][$i];  
			  $_FILES['files']['error'] = $_FILES['id_front']['error'][$i];  
			  $_FILES['files']['size'] = $_FILES['id_front']['size'][$i];  
		
			  $config['upload_path'] = 'uploads/trd_document';   
			  $config['allowed_types'] = 'jpg|jpeg|png|gif';
			  $config['file_name'] = rand(100000, 999999);;  
		 
			  $this->load->library('upload');
		$this->upload->initialize($config);
		  
			  if($this->upload->do_upload('files')){  
				$uploadData = $this->upload->data();  
				$filename = $uploadData['file_name'];
		 
				$data['id_front'][] = $filename; 
				array_push($_POST['in_front'],$filename);
			  }else{
				  //print_r($this->upload->display_errors());
				  $data['id_front'][] = ''; 
			  }
			  
			}else{
				$filename='';
				array_push($_POST['in_front'],$filename);
			}
		  }
		  
			
			$countidback = count($_FILES['id_back']['name']);  
			  $_POST['in_back'] = [];
			  for($i=0;$i<$countidfront;$i++){  
			  
				if(!empty($_FILES['id_back']['name'][$i])){  
			  
				  $_FILES['files1']['name'] = $_FILES['id_back']['name'][$i];  
				  $_FILES['files1']['type'] = $_FILES['id_back']['type'][$i];  
				  $_FILES['files1']['tmp_name'] = $_FILES['id_back']['tmp_name'][$i];  
				  $_FILES['files1']['error'] = $_FILES['id_back']['error'][$i];  
				  $_FILES['files1']['size'] = $_FILES['id_back']['size'][$i];  
			
				  $config['upload_path'] = 'uploads/trd_document';   
				  $config['allowed_types'] = 'jpg|jpeg|png|gif';
				  $config['file_name'] = rand(100000, 999999);;  
			 
				 $this->load->library('upload');
		$this->upload->initialize($config);  
				
				  if($this->upload->do_upload('files1')){  
					$uploadData = $this->upload->data();  
					$filename = $uploadData['file_name'];
			 
					$data['id_back'][] = $filename; 
					array_push($_POST['in_back'],$filename);
				  }else{
					  //print_r($this->upload->display_errors());
					  $data['id_back'][] = ''; 
				  }
				  
				}else{
					$filename='';
					array_push($_POST['in_back'],$filename);
				}
			  }
			  
			  $countupload_image = count($_FILES['upload_image']['name']);  
			  $_POST['upload_image'] = [];
			  for($i=0;$i<$countupload_image;$i++){  
			  
				if(!empty($_FILES['upload_image']['name'][$i])){  
			  
				  $_FILES['files2']['name'] = $_FILES['upload_image']['name'][$i];  
				  $_FILES['files2']['type'] = $_FILES['upload_image']['type'][$i];  
				  $_FILES['files2']['tmp_name'] = $_FILES['upload_image']['tmp_name'][$i];  
				  $_FILES['files2']['error'] = $_FILES['upload_image']['error'][$i];  
				  $_FILES['files2']['size'] = $_FILES['upload_image']['size'][$i];  
			
				  $config['upload_path'] = 'uploads/trd_document';   
				  $config['allowed_types'] = 'jpg|jpeg|png|gif';
				  $config['file_name'] = rand(100000, 999999);;  
			 
				  $this->load->library('upload');
		$this->upload->initialize($config);   
				
				  if($this->upload->do_upload('files2')){  
					$uploadData = $this->upload->data();  
					$filename = $uploadData['file_name'];
			 
					$data['upload_image'][] = $filename; 
					array_push($_POST['upload_image'],$filename);
				  }else{
				  }
				  
				}else{
					$filename='';
					array_push($_POST['upload_image'],$filename);
				}
			  }
			  
			  foreach($_POST['authorized_person_name'] as $key=>$value){
				  $this->waiting_manager_model->insert_any_query('restaurant_propritor_details',['user_id'=>$_POST['id'],'id_front'=>$_POST['in_front'][$key],'id_back'=>$_POST['in_back'][$key],'upload_img'=>$_POST['upload_image'][$key],'full_name'=>$value,'id_number'=>$_POST['authorized_person_id'][$key],'id_expiry_date'=>$_POST['authorized_person_id_expiry_date'][$key],'gender'=>$_POST['authorized_person_gender'][$key],'nationality'=>$_POST['authorized_person_nationality'][$key],'dob'=>$_POST['authorized_person_dob'][$key],'mobile_number'=>$_POST['authorized_person_mob'][$key],'landline_number'=>$_POST['authorized_person_landline'][$key],'fax'=>$_POST['authorized_person_fax'][$key],'email_id'=>$_POST['authorized_person_email'][$key],'designation'=>$_POST['authorized_person_designation'][$key],'country_of_birth'=>$_POST['authorized_person_country_of_birth'][$key]]);
			  }
			  
			  if($this->db->trans_complete()){
				 $this->json_output(['status'=>true,'msg'=>'Authorized person added successfully']);
			  }
	}
	
	
	public function edit_proprietor_person_details(){
		$this->db->trans_start();
		$countidfront = count($_FILES['id_front']['name']);  
		  $_POST['in_front'] = [];
		  for($i=0;$i<$countidfront;$i++){
		  
			if(!empty($_FILES['id_front']['name'][$i])){
		  
			  $_FILES['files']['name'] = $_FILES['id_front']['name'][$i];  
			  $_FILES['files']['type'] = $_FILES['id_front']['type'][$i];  
			  $_FILES['files']['tmp_name'] = $_FILES['id_front']['tmp_name'][$i];  
			  $_FILES['files']['error'] = $_FILES['id_front']['error'][$i];  
			  $_FILES['files']['size'] = $_FILES['id_front']['size'][$i];  
		
			  $config['upload_path'] = 'uploads/trd_document';   
			  $config['allowed_types'] = 'jpg|jpeg|png|gif';
			  $config['file_name'] = rand(100000, 999999); 
		 
			  $this->load->library('upload');
		$this->upload->initialize($config);
		  
			  if($this->upload->do_upload('files')){  
				$uploadData = $this->upload->data();  
				$filename = $uploadData['file_name'];
		 
				$data['id_front'][] = $filename; 
				array_push($_POST['in_front'],$filename);
			  }else{
				  //print_r($this->upload->display_errors());
				  $data['id_front'][] = ''; 
			  }
			  
			}
		  }
		  
			
			$countidback = count($_FILES['id_back']['name']);  
			  $_POST['in_back'] = [];
			  for($i=0;$i<$countidfront;$i++){  
			  
				if(!empty($_FILES['id_back']['name'][$i])){  
			  
				  $_FILES['files1']['name'] = $_FILES['id_back']['name'][$i];  
				  $_FILES['files1']['type'] = $_FILES['id_back']['type'][$i];  
				  $_FILES['files1']['tmp_name'] = $_FILES['id_back']['tmp_name'][$i];  
				  $_FILES['files1']['error'] = $_FILES['id_back']['error'][$i];  
				  $_FILES['files1']['size'] = $_FILES['id_back']['size'][$i];  
			
				  $config['upload_path'] = 'uploads/trd_document';   
				  $config['allowed_types'] = 'jpg|jpeg|png|gif';
				  $config['file_name'] = rand(100000, 999999);;  
			 
				  $this->load->library('upload');
		$this->upload->initialize($config);  
				
				  if($this->upload->do_upload('files1')){  
					$uploadData = $this->upload->data();  
					$filename = $uploadData['file_name'];
			 
					$data['id_back'][] = $filename; 
					array_push($_POST['in_back'],$filename);
				  }else{
					  //print_r($this->upload->display_errors());
					  $data['id_back'][] = ''; 
				  }
				  
				}
			  }
			  
			  $countupload_image = count($_FILES['upload_image']['name']);  
			  $_POST['upload_image'] = [];
			  for($i=0;$i<$countupload_image;$i++){  
			  
				if(!empty($_FILES['upload_image']['name'][$i])){  
			  
				  $_FILES['files2']['name'] = $_FILES['upload_image']['name'][$i];  
				  $_FILES['files2']['type'] = $_FILES['upload_image']['type'][$i];  
				  $_FILES['files2']['tmp_name'] = $_FILES['upload_image']['tmp_name'][$i];  
				  $_FILES['files2']['error'] = $_FILES['upload_image']['error'][$i];  
				  $_FILES['files2']['size'] = $_FILES['upload_image']['size'][$i];  
			
				  $config['upload_path'] = 'uploads/trd_document';   
				  $config['allowed_types'] = 'jpg|jpeg|png|gif';
				  $config['file_name'] = rand(100000, 999999);;  
			 
				  $this->load->library('upload');   
				
				  if($this->upload->do_upload('files2')){  
					$uploadData = $this->upload->data();  
					$filename = $uploadData['file_name'];
			 
					$data['upload_image'][] = $filename; 
					array_push($_POST['upload_image'],$filename);
				  }else{
				  }
				  
				}
			  }
			  
			  foreach($_POST['authorized_person_name'] as $key=>$value){
				  $this->waiting_manager_model->updateactive_inactive('restaurant_propritor_details',['id'=>$_POST['id']],['full_name'=>$value,'id_number'=>$_POST['authorized_person_id'][$key],'id_expiry_date'=>$_POST['authorized_person_id_expiry_date'][$key],'gender'=>$_POST['authorized_person_gender'][$key],'nationality'=>$_POST['authorized_person_nationality'][$key],'dob'=>$_POST['authorized_person_dob'][$key],'mobile_number'=>$_POST['authorized_person_mob'][$key],'landline_number'=>$_POST['authorized_person_landline'][$key],'fax'=>$_POST['authorized_person_fax'][$key],'email_id'=>$_POST['authorized_person_email'][$key],'designation'=>$_POST['authorized_person_designation'][$key],'country_of_birth'=>$_POST['authorized_person_country_of_birth'][$key]]);
					
					if($_POST['in_front'][$key]!=''){
						$this->waiting_manager_model->updateactive_inactive('restaurant_propritor_details',['id'=>$_POST['id']],['id_front'=>$_POST['in_front'][$key]]);
			  
					}
					
					if($_POST['in_back'][$key]!=''){
						$this->waiting_manager_model->updateactive_inactive('restaurant_propritor_details',['id'=>$_POST['id']],['id_back'=>$_POST['in_back'][$key]]);
			  
					}
					
					if($_POST['upload_image'][$key]!=''){
						$this->waiting_manager_model->updateactive_inactive('restaurant_propritor_details',['id'=>$_POST['id']],['upload_img'=>$_POST['upload_image'][$key]]);
			  
					}
			  }
			  
			  if($this->db->trans_complete()){
				 $this->json_output(['status'=>true,'msg'=>'proprietor details save successfully']); 
			  }
	}
	
	public function get_perticular_proprietor_person(){
		$get_person = $this->waiting_manager_model->select_where('restaurant_propritor_details',['id'=>$_POST['id']]);
		$this->json_output($get_person);
	}
	
	public function get_step_two_status(){
		$get_status = $this->waiting_manager_model->select_where('user',['id'=>$_POST['id']]);
		$this->json_output($get_status);
	}
	
	public function change_status_step_two(){
		if($_POST['status'] == 'Rejected'){
			
		}
		
		$this->waiting_manager_model->updateactive_inactive('user',['id'=>$_POST['id']],['step_two_status'=>$_POST['status']]);
		$this->json_output(['status'=>true]);
		
	}
	
	public function get_step_one_status(){
		$get_status = $this->waiting_manager_model->select_where('user',['id'=>$_POST['id']]);
		$this->json_output($get_status);
	}
	
	public function change_status_step_one(){
		if($_POST['status'] == 'Rejected'){
			
		}
		$this->waiting_manager_model->updateactive_inactive('user',['id'=>$_POST['id']],['step_one_status'=>$_POST['status']]);
		$this->json_output(['status'=>true]);
		
	}
	
}