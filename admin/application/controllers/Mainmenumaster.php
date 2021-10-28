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
class Mainmenumaster extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->is_loggedin();
		$this->load->model('mainmenu_model');
		$this->load->library("session");
       	$this->load->helper('url');
	}

	public function index(){
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		$this->load->view('menu_master_create',$data);
	}

	public function list_master_menu(){
		if(isset($_POST['searchkey']))
			$manager=$this->mainmenu_model->list_master_menu($_POST['page'],$_POST['per_page'],$_POST['searchkey']);
		else
		$manager=$this->mainmenu_model->list_master_menu($_POST['page'],$_POST['per_page']);
		$this->json_output($manager);
	}

	public function delete_master_menu(){
		if($_POST['is_active']=="on")
			$this->mainmenu_model->updateactive_inactive('menu_master',['id'=>$_POST['id']],['is_active'=>1]);		
		else
			$this->mainmenu_model->updateactive_inactive('menu_master',['id'=>$_POST['id']],['is_active'=>0]);
		$this->json_output(array('status'=>true));
	}

	public function show_perticular_master_menu(){
		$individual_menu = $this->mainmenu_model->select_where('menu_master',['id'=>$_POST['id']])[0];
		$this->json_output($individual_menu);
	}

	public function edit_perticular_master_menu(){
		$_POST['name']=filter_var($_POST['name'], FILTER_SANITIZE_STRING);
		$check = $this->mainmenu_model->select_where('menu_master',['id !='=>$_POST['id'],'name'=>$_POST['name'],'restaurant_id'=>$_SESSION['user_id']]);
		if(empty($check)){
			if($this->mainmenu_model->updateactive_inactive('menu_master',['id'=>$_POST['id']],['name'=>$_POST['name']])){
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
			$_POST['name']=filter_var($_POST['name'], FILTER_SANITIZE_STRING);
			$check = $this->mainmenu_model->select_where('menu_master',['name'=>$_POST['name'],'restaurant_id'=>$_SESSION['user_id']]);
			if (empty($check)) {
				$_POST['is_active'] = 1;
				$_POST['restaurant_id'] = $_SESSION['user_id'];
				if ($this->mainmenu_model->insert_any_query('menu_master',$_POST)) {
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
	
	public function uploadData()
	{
		$path = 'assets/';
		require_once APPPATH . "/third_party/PHPExcel.php";
		$config['upload_path'] = $path;
		$config['allowed_types'] = 'xlsx|xls|csv';
		$config['remove_spaces'] = TRUE;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);            
			
		if (!$this->upload->do_upload('uploadFile')) 
		{
			$error = array('error' => $this->upload->display_errors());
			//print_r($error);
			//print_r($error);
		} 
		else 
		{
			$data = array('upload_data' => $this->upload->data());
		}
		
		if(empty($error))
		{
			if (!empty($data['upload_data']['file_name'])) 
			{
				$import_xls_file = $data['upload_data']['file_name'];
			} 
			else 
			{
				$import_xls_file = 0;
			}
			$inputFileName = $path . $import_xls_file;
	
			try 
			{
				$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
				$objReader = PHPExcel_IOFactory::createReader($inputFileType);
				$objPHPExcel = $objReader->load($inputFileName);
				$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true, true, true);
				$flag = true;
				$i=0;
				
				/* print_r($allDataInSheet);
				echo "<br><br>"; */
				
				foreach ($allDataInSheet as $value) 
				{
					if($flag)
					{
						$flag =false;
						continue;
					}
					
					$check = $this->mainmenu_model->select_where('menu_master',['name'=>$value['A'],'restaurant_id'=>$_SESSION['user_id']]);
					
					if(empty($check))
					{
						if ($value['A'] != '') 
						{
							$inserdata[$i]['name'] = $value['A'];
							$inserdata[$i]['is_active'] = 1;
							$inserdata[$i]['restaurant_id'] = $_SESSION['user_id'];
							$i++;
						}
					}
				}

				if (empty($inserdata)) 
				{
					$this->json_output(array('status'=>false,'msg'=>'File records are exist.Information updated successfully'));
					exit();
				}

				$result = $this->mainmenu_model->importdata($inserdata);   
				
				if($result)
				{
					unlink($inputFileName);
					$this->json_output(array('status'=>true));
				  //echo "Imported successfully";
				}
				else
				{
					$this->json_output(array('status'=>false,'msg'=>'Something went wrong'));
					//echo "ERROR !";
				}
			}
			catch (Exception $e) 
			{
				die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME). '": ' .$e->getMessage());
			}
		}
		else
		{
			$this->json_output(array('status'=>false,'msg'=>strip_tags($error['error'])));
		  //echo $error['error'];
		}
	}
}