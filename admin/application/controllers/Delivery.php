<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'third_party/aws/aws-autoloader.php';
use Aws\Common\Exception\MultipartUploadException;
use Aws\S3\MultipartUploader;
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
class Delivery extends MY_Controller{
	public function __construct() {
		parent::__construct();
		
		$this->is_loggedin();
		$this->load->model('Delivery_model');
		$this->load->model('Waiter_model');
		$this->load->model('Restaurant_manager_model');	
		$this->load->library("session");
       	$this->load->helper('url');
       	$this->is_manager_delete();
	}

	public function index(){
		$data['restaurantsidebarshow'] = $this->get_menu_of_restaurant();
		$this->load->view('delivery_list', $data);
	}

	// working
	public function list_deliverers(){
		if(isset($_POST['searchkey']))
			$manager=$this->Delivery_model->list_manager($_POST['page'],$_POST['per_page'],$_POST['searchkey']);
		else
		$manager=$this->Delivery_model->list_manager($_POST['page'],$_POST['per_page']);
		//echo $this->db->last_query();exit();
		$this->json_output($manager);
	}

	public function add_profile_photo(){
    	if(!empty($_POST)){
    		$user_details=$this->Waiter_model->check_user($_POST['email']);
			if (!empty($user_details)) {
				$this->json_output(array('status'=>true,'is_email_exist'=>true,'msg'=>"Email already exists."));
					return;
			}
			else{
	        	if(isset($_POST['image'])){
	        		$rand_no=rand(1111111,9999999);
	        		if(SERVER=="testing")
						$image_url='test/profile/'.$rand_no.'.jpg';
					else
						$image_url='profile/'.$rand_no.'.jpg';
	        		$file_path=APPPATH.'../uploads/profile/'.$rand_no.'.jpg';
                	$img_r = imagecreatefromjpeg($_POST['image']);
					$output=imagejpeg($img_r,$file_path);
					$aws_result=$this->uploadAWSS3($image_url,$file_path);
					//gc_collect_cycles();
					//unlink($file_path);

					if($image_url!=""){
						$m=$this->Delivery_model;
						$m->name = $_POST['name'];
						$m->email = $_POST['email'];
						$m->password = $this->randomPassword();
						$m->is_active = 1;
						$m->usertype = 'Delivery man';
						$m->contact_number = $_POST['contact_number'];
	                	$m->profile_photo=CLOUDFRONTURL.$image_url;
						$m->upline_id= $_SESSION['user_id'];
		            	$m->add();
						//echo $this->db->last_query();exit();
		            	$this->json_output(array('path'=>CLOUDFRONTURL.$image_url,'status'=>true,'msg'=>'Profile Photo Updated'));
						return;
					}else{
						$this->json_output(array('status'=>false,'msg'=>'Something went wrong please try again.'));
						return;
					}
				}
    		}
		}
	}

	// working
	public function add_new_currier(){
		$user_details=$this->Waiter_model->check_user($_POST['email']);
		if (!empty($user_details)) {
			$this->json_output([
				"status" => true,
				'is_email_exist' => true,
				'msg' => 'EMail already exists.'
			]);
			return;
		}
		$_POST['password'] = $this->randomPassword();
		$_POST['is_active'] = 1;
		$_POST['usertype'] = "Delivery man";
		$_POST['upline_id'] = $_SESSION['user_id'];
		if ($this->Waiter_model->add_user($_POST)) {
			$this->json_output(array('status'=>true,'msg'=>"Your Login Details send to your given mail id."));
			return;
		}else{
			$this->json_output([
				"status" => false,
				"message" => "something went wrong"
			]);
		}
	}

	public function delete_currier(){
		$checkCurrierAssingdOrder = $this->waiting_manager_model->select_where('assigne_order_to_deliverer', ['deliverer_id' => $_POST['id']]);

		if (count($checkCurrierAssingdOrder) > 0) {
			foreach ($checkCurrierAssingdOrder as $value) {
				$this->waiting_manager_model->permanent_delete_manager('', ['id' => $value['id']]);
			}
		}

		$this->waiting_manager_model->permanent_delete_manager('', ['id' => $_POST['id']]);

		$this->json_output([
			"status" => true
		]);
	}

	public function randomPassword() {
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass); //turn the array into a string
	}
	   
	public function assign_order_to_deliverer(){
		$check_manager_record=$this->waiting_manager_model->select_where('assigne_order_to_deliverer',['deliverer_id'=>$_POST['id']]);
		if(!empty($check_manager_record)){
			$this->waiting_manager_model->permanent_delete_manager('assigne_order_to_deliverer',['deliverer_id'=>$_POST['id']]);
		}
		
		if(!empty($_POST['table'])){
		foreach($_POST['table'] as $key=>$value){
			$check_table_assign = $this->waiting_manager_model->select_where('assign_table_for_waiter',['restaurant_id'=>$_SESSION['user_id'],'waiter_id'=>$_POST['restaurant_waiter_id'],'table_id'=>$value]);
			if(empty($check_table_assign)){
				$this->waiting_manager_model->insert_waiting_cus('assigne_order_to_deliverer',['waiter_id'=>$_POST['id'],'order_id'=>$value,'restaurant_id'=>$_SESSION['user_id']]);
			}
		} }
		$this->json_output(['status'=>true]);
	}

	// public function controlCurrierStatus(){
	// 	if($_POST['is_active']=="on")
	// 		$this->Waiter_model->updateactive_inactive('user',['id'=>$_POST['id']],['is_active'=>1]);		
	// 	else
	// 		$this->Waiter_model->updateactive_inactive('user',['id'=>$_POST['id']],['is_active'=>0]);
	// 	$this->json_output(array('status'=>true));
	// }

}
?>