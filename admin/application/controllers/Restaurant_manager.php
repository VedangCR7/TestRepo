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
class Restaurant_manager extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->is_loggedin();
		$this->load->model('Restaurant_manager_model');
		$this->load->library("session");
       	$this->load->helper('url');
	}

	public  function dashboard()
	{	
		$this->load->view('restaurantmanager_dashboard');
	}
	
	public function restaurant_list_manager() {
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		$this->load->view('restaurant_manager',$data);
	}

	public function list_manager(){
		if(isset($_POST['searchkey']))
			$manager=$this->Restaurant_manager_model->list_manager($_POST['page'],$_POST['per_page'],$_POST['searchkey']);
		else
		$manager=$this->Restaurant_manager_model->list_manager($_POST['page'],$_POST['per_page']);
		//echo $this->db->last_query();
		$this->json_output($manager);
	}

	public function save_restaurant_manager(){
		$user_details=$this->Restaurant_manager_model->check_user($_POST['email']);
		if (!empty($user_details)) {
			$this->json_output(array('status'=>true,'is_email_exist'=>true,'msg'=>"Email already exists."));
				return;
		}
		else{
			$_POST['password'] = $this->randomPassword();
			$_POST['is_active'] = 1;
			$_POST['usertype'] = 'Restaurant manager';
			$_POST['upline_id'] = $_SESSION['user_id'];
			if($this->Restaurant_manager_model->add_user($_POST)){
			// 	ob_start();
		
			// $data['mail']=array(
			// 	'email'=>$_POST['email'],
			// 	'password'=>$_POST['password'],
			// 	'name'=>$_POST['name'],
			// 	'contact_number'=>$_POST['contact_number']
			// );

			// $msg = $this->load->view('email_template/new_user_email',$data, true);
			// $msg=$this->convert_to_utf8($msg);

			// $to=$_POST['email']; // <– replace with your address here
			// $subject="New user registration email";
			// $from = "Foodnai<support@foodnai.com>";
			// /*$headers = "MIME-Version: 1.0" . "\r\n";
			// $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			// $headers .= "From:" . $from;
			// $output=mail($to,$subject,$msg,$headers);*/

			// $mail = new PHPMailer(true);
	  //       $mail->SMTPDebug = 0;
	  //       $mail->isSMTP();                         
	  //       $mail->Host = EMAIL_Host;
	  //       $mail->SMTPAuth = EMAIL_SMTPAuth;                          
	  //       $mail->Username = EMAIL_USERNAME;                 
	  //       $mail->Password = EMAIL_PASSWORD;                           
	  //       $mail->SMTPSecure = EMAIL_SMTPSecure;                           
	  //       $mail->Port = EMAIL_Port;                                   
	        
	  //       $mail->From = EMAIL_FROMMAIL;
	  //       $mail->FromName = EMAIL_FROMNAME;
	  //       $mail->setFrom(EMAIL_FROMMAIL, EMAIL_FROMNAME);

	  //       $mail->addAddress($to);
	            
	  //       $mail->isHTML(true);
	            
	  //       $mail->Subject = $subject;
			// $mail->Body = $msg;
		 // 	if(!$mail->Send()) {
		 // 		$this->json_output(array('status'=>false,'msg'=>"Mailer Error: " . $mail->ErrorInfo));
		 //    	return;
			// }
			$this->json_output(array('status'=>true,'msg'=>"Your Login Details send to your given mail id."));
			return;
			}
			else{
				$this->json_output(array('status'=>false,'msg'=>"something went wrong"));
			}

		}
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

	public function delete_manager(){
		if($_POST['is_active']=="on"){
			$this->Restaurant_manager_model->updateactive_inactive('user',['id'=>$_POST['id']],['is_active'=>1]);	
			
		}
		else{
			$check_assign_tables = $this->Restaurant_manager_model->select_where('assign_table_for_manager',['manager_id'=>$_POST['id']]);

			if(!empty($check_assign_tables)){
				foreach($check_assign_tables as $key => $value){
					$this->Restaurant_manager_model->permanent_delete_manager('assign_table_for_manager',['id'=>$value['id']]);
				}
			}
			$this->Restaurant_manager_model->updateactive_inactive('user',['id'=>$_POST['id']],['is_active'=>0]);
		}
		$this->json_output(array('status'=>true));
	}

	public function delete_perticular_restaurant_manager(){

		$check_assign_tables = $this->Restaurant_manager_model->select_where('assign_table_for_manager',['manager_id'=>$_POST['id']]);

		if(!empty($check_assign_tables)){
			foreach($check_assign_tables as $key => $value){
				$this->Restaurant_manager_model->permanent_delete_manager('assign_table_for_manager',['manager_id'=>$value['id']]);
			}
		}

		$this->Restaurant_manager_model->permanent_delete_manager('user',['id'=>$_POST['id']]);
		$this->json_output(array('status'=>true));
	}


	public function update_profile_photo(){
	 	if(!empty($_POST)){
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
				gc_collect_cycles();
				unlink($file_path);

				if($image_url!=""){
					
					$m=$this->Restaurant_manager_model;
	                $m->profile_photo=CLOUDFRONTURL.$image_url;
		            if($_POST['id']!=""){
		                $m->id=$_POST['id'];
		                $m->update();
		            }

		            $this->json_output(array('path'=>CLOUDFRONTURL.$image_url,'status'=>true,'msg'=>'Profile Photo Updated'));
					return;
				}else{
					$this->json_output(array('status'=>false,'msg'=>'Something went wrong please try again.'));
					return;

				}	

	        }
        }else{
        	$this->json_output(array('status'=>false,'msg'=>'Please select file to upload'));
        }
    }

    public function add_profile_photo(){
		//print_r($_POST);exit();
    	if(!empty($_POST)){
    		$user_details=$this->Restaurant_manager_model->check_user($_POST['email']);
			//print_r($user_details);exit();
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
						$m=$this->Restaurant_manager_model;
						$m->name = $_POST['name'];
						$m->email = $_POST['email'];
						$m->password = $this->randomPassword();
						$m->is_active = 1;
						$m->usertype = 'Restaurant manager';
						$m->contact_number = $_POST['contact_number'];
						$m->upline_id = $_SESSION['user_id'];
	                	$m->profile_photo=CLOUDFRONTURL.$image_url;
		            	$m->add();
		            	$this->json_output(array('path'=>CLOUDFRONTURL.$image_url,'status'=>true,'msg'=>'Profile Photo Updated'));
						return;
					}else{
						$this->json_output(array('status'=>false,'msg'=>'Something went wrong please try again.'));
						return;

					}
				}
    		}
		}else{
			echo "not found";
		}
	}


	public function show_perticular_waitinglist_manager(){
		$individual_manager = $this->Restaurant_manager_model->select_where('user',['id'=>$_POST['id']])[0];
		$this->json_output($individual_manager);
	}

	public function edit_perticular_waitinglist_manager(){
		if($this->Restaurant_manager_model->updateactive_inactive('user',['id'=>$_POST['id']],['name'=>$_POST['name'],'password'=>$_POST['password'],'contact_number'=>$_POST['contact_number']])){
			$this->json_output(array('status'=>true));
		}
		else{
			$this->json_output(array('status'=>false));
		}
	}


}