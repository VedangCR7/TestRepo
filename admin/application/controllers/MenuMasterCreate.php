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
class MenuMasterCreate extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->is_loggedin();
		$this->load->model('MenuMasterModelCreate');
		$this->load->library("session");
       	$this->load->helper('url');
	}

	public function menuMaster(){
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		$this->load->view('Menu_master_create',$data);
	}

	public function list_master_menu(){
		if(isset($_POST['searchkey']))
			$manager=$this->MenuMasterModelCreate->list_master_menu($_POST['page'],$_POST['per_page'],$_POST['searchkey']);
		else
		$manager=$this->MenuMasterModelCreate->list_master_menu($_POST['page'],$_POST['per_page']);
		$this->json_output($manager);
	}

	public function delete_master_menu(){
		if($_POST['is_active']=="on")
			$this->MenuMasterModelCreate->updateactive_inactive('menu_master',['id'=>$_POST['id']],['is_active'=>1]);		
		else
			$this->MenuMasterModelCreate->updateactive_inactive('menu_master',['id'=>$_POST['id']],['is_active'=>0]);
		$this->json_output(array('status'=>true));
	}

	public function show_perticular_master_menu(){
		$individual_menu = $this->MenuMasterModelCreate->select_where('menu_master',['id'=>$_POST['id']])[0];
		$this->json_output($individual_menu);
	}

	public function edit_perticular_master_menu(){
		$check = $this->MenuMasterModelCreate->select_where('menu_master',['id !='=>$_POST['id'],'name'=>$_POST['name'],'restaurant_id'=>$_SESSION['user_id']]);
		if(empty($check)){
			if($this->MenuMasterModelCreate->updateactive_inactive('menu_master',['id'=>$_POST['id']],['name'=>$_POST['name']])){
				$this->json_output(array('status'=>true));
			}
			else{
				$this->json_output(array('status'=>false));
			}
		}
		else{
			$this->json_output(array('status'=>true,'is_name_exist'=>true,'msg'=>"Master Menu Name already exists."));
				return;
		}
	}

	public function save_menu_master(){
		if (!empty($_POST)) {
			$check = $this->MenuMasterModelCreate->select_where('menu_master',['name'=>$_POST['name'],'restaurant_id'=>$_SESSION['user_id']]);
			
			if (empty($check)) {
				$_POST['is_active'] = 1;
				$_POST['restaurant_id'] = $_SESSION['user_id'];
				if ($this->MenuMasterModelCreate->insert_any_query('menu_master',$_POST)) {
					$this->json_output(array('status'=>true,'msg'=>"Master Menu Created Successfully"));
					return;
				}
				else{
					$this->json_output(array('status'=>false,'msg'=>"something went wrong"));
				}
			}
			else{
				$this->json_output(array('status'=>true,'is_name_exist'=>true,'msg'=>"Master Menu Name already exists."));
				return;
			}
		}
	}
}