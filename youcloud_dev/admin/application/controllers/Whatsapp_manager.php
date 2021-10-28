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
class Whatsapp_manager extends MY_Controller {
	public function __construct() {
		parent::__construct();
		$this->is_loggedin();
		$this->load->model('Whatsapp_manager_model');
		$this->load->model('Admin_offer_model');
		$this->load->model('customer_model');
		$this->load->library("session");
       	$this->load->helper('url');
	}

	public  function dashboard()
	{	
		$this->load->view('whatsapp_dashboard');
	}

	public  function whatsapp_message()
	{	
		$this->load->view('offer');
	}

	public function show_cust(){
		$restaurant_id = $this->get_restaurant_id();
		$events = $this->Whatsapp_manager_model->select_where('customer',['restaurant_id'=>$restaurant_id]);
		$this->json_output($events);
	}

	public function whatsapp_manager() {
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		$this->load->view('whatsapp_manager',$data);
	}

	public function list_manager(){
		if(isset($_POST['searchkey']))
			$manager=$this->Whatsapp_manager_model->list_manager($_POST['page'],$_POST['per_page'],$_POST['searchkey']);
		else
		$manager=$this->Whatsapp_manager_model->list_manager($_POST['page'],$_POST['per_page']);
		$this->json_output($manager);
	}

	public function list_message(){
		if(isset($_POST['searchkey']))
			$manager=$this->Whatsapp_manager_model->list_offer($_POST['page'],$_POST['per_page'],$_POST['searchkey']);
		else
		$manager=$this->Whatsapp_manager_model->list_offer($_POST['page'],$_POST['per_page']);
		$this->json_output($manager);
	}

	public function save_waiting_manager(){
		$user_details=$this->Whatsapp_manager_model->check_user($_POST['email']);
		if (!empty($user_details)) {
			$this->json_output(array('status'=>true,'is_email_exist'=>true,'msg'=>"Email already exists."));
				return;
		}
		else{
			$_POST['password'] = $this->randomPassword();
			$_POST['is_active'] = 1;
			$_POST['usertype'] = 'Whatsapp manager';
			$_POST['upline_id'] = $_SESSION['user_id'];
			if($this->Whatsapp_manager_model->add_user($_POST)){
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
		if($_POST['is_active']=="on")
			$this->Whatsapp_manager_model->updateactive_inactive('user',['id'=>$_POST['id']],['is_active'=>1]);		
		else
			$this->Whatsapp_manager_model->updateactive_inactive('user',['id'=>$_POST['id']],['is_active'=>0]);
		$this->json_output(array('status'=>true));
	}

	public function delete_perticular_waitinglist_manager(){
		$this->Whatsapp_manager_model->permanent_delete_manager('user',['id'=>$_POST['id']]);
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
					
					$m=$this->Whatsapp_manager_model;
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
    	if(!empty($_POST)){
    		$user_details=$this->Whatsapp_manager_model->check_user($_POST['email']);
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
						$m=$this->Whatsapp_manager_model;
						$m->name = $_POST['name'];
						$m->email = $_POST['email'];
						$m->password = $this->randomPassword();
						$m->is_active = 1;
						$m->usertype = 'Whatsapp manager';
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
		}
	}


	public function add_message(){
		if($_POST['image'] != ''){
	       	$rand_no=rand(1111111,9999999);
	        if(SERVER=="testing")
				$image_url='test/adminoffer/'.$rand_no.'.jpg';
			else
				$image_url='adminoffer/'.$rand_no.'.jpg';
	        	$file_path=APPPATH.'../uploads/adminoffer/'.$rand_no.'.jpg';
                $img_r = imagecreatefromjpeg($_POST['image']);
				$output=imagejpeg($img_r,$file_path);
				$aws_result=$this->uploadAWSS3($image_url,$file_path);
				//gc_collect_cycles();
				//unlink($file_path);
				if($image_url!=""){
					$m=$this->Admin_offer_model;
					$m->restaurant_id = $this->get_restaurant_id();
					$m->is_active = 1;
					$m->message_date = date('Y-m-d');
	                $m->message_photo=CLOUDFRONTURL.$image_url;
	                $m->message_text = $_POST['message_text'];
		            $this->json_output(array('path'=>CLOUDFRONTURL.$image_url,'status'=>true,'msg'=>'Offer created successfully','offer_text'=>$_POST['message_text'],'photo'=>CLOUDFRONTURL.$image_url,'id'=>$m->add()));
					return;
				}else{
					$this->json_output(array('status'=>false,'msg'=>'Something went wrong please try again.'));
					return;

				}
		}
		else{
			//echo "not image";
			$m=$this->Admin_offer_model;
			$m->restaurant_id = $this->get_restaurant_id();
			$m->is_active = 1;
			$m->message_date = date('Y-m-d');
			$m->message_text = $_POST['message_text'];
			$this->json_output(array('status'=>true,'msg'=>'Offer created successfully','offer_text'=>$_POST['message_text'],'id'=>$m->add()));
		}
	}

	public function change_offer_status(){
		if($_POST['is_active']=="on")
			$this->Whatsapp_manager_model->updateactive_inactive('whatsapp_message',['id'=>$_POST['id']],['is_active'=>1]);		
		else
			$this->Whatsapp_manager_model->updateactive_inactive('whatsapp_message',['id'=>$_POST['id']],['is_active'=>0]);
		$this->json_output(array('status'=>true));
	}

	public function delete_perticular_offer(){
		$this->Whatsapp_manager_model->permanent_delete_manager('whatsapp_message',['id'=>$_POST['id']]);
		$this->json_output(array('status'=>true));
	}

	public function show_perticular_offer(){
		$individual_manager = $this->Whatsapp_manager_model->select_where('whatsapp_message',['id'=>$_POST['id']])[0];
		$this->json_output($individual_manager);
	}

	public function edit_perticular_Offer(){
		// if ($_POST['offer_photo'] != '') {
		// 	if($this->Whatsapp_manager_model->updateactive_inactive('admin_offer',['id'=>$_POST['id']],['offer_photo'=>$_POST['offer_photo']])){
		// 		$this->json_output(array('status'=>true));
		// 	}
		// 	else{
		// 		$this->json_output(array('status'=>false));
		// 	}
		// }
		// if ($_POST['offer_text'] != '') {
			if($this->Whatsapp_manager_model->updateactive_inactive('whatsapp_message',['id'=>$_POST['id']],['message_text'=>$_POST['message_text']])){
				$this->json_output(array('status'=>true));
			}
			else{
				$this->json_output(array('status'=>false));
			}
		//}
	}

	public function showoffer_forsend(){
		$individual_offer = $this->Whatsapp_manager_model->select_where('admin_offer',['id'=>$_POST['id']])[0];
		$this->json_output($individual_offer);
	}

	public function update_offer_photo(){
		if(!empty($_POST)){
	        if(isset($_POST['image'])){
	        	$rand_no=rand(1111111,9999999);
	        	if(SERVER=="testing")
					$image_url='test/adminoffer/'.$rand_no.'.jpg';
				else
					$image_url='adminoffer/'.$rand_no.'.jpg';
	        	$file_path=APPPATH.'../uploads/adminoffer/'.$rand_no.'.jpg';
                $img_r = imagecreatefromjpeg($_POST['image']);
				$output=imagejpeg($img_r,$file_path);
				$aws_result=$this->uploadAWSS3($image_url,$file_path);
				gc_collect_cycles();
				unlink($file_path);

				if($image_url!=""){
					
					$m=$this->Admin_offer_model;
	                $m->message_photo=CLOUDFRONTURL.$image_url;
		            if($_POST['id']!=""){
		                $m->id=$_POST['id'];
		                $m->update();
		            }

		            $this->json_output(array('path'=>CLOUDFRONTURL.$image_url,'status'=>true,'msg'=>'Offer Photo Updated'));
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

	public function show_perticular_waitinglist_manager(){
		$individual_manager = $this->Whatsapp_manager_model->select_where('user',['id'=>$_POST['id']])[0];
		$this->json_output($individual_manager);
	}

	public function edit_perticular_waitinglist_manager(){
		if($this->Whatsapp_manager_model->updateactive_inactive('user',['id'=>$_POST['id']],['name'=>$_POST['name'],'password'=>$_POST['password'],'contact_number'=>$_POST['contact_number']])){
			$this->json_output(array('status'=>true));
		}
		else{
			$this->json_output(array('status'=>false));
		}
	}

	public function restaurant_msg_details(){
		$restaurant_id = $this->get_restaurant_id();
		$events = $this->Whatsapp_manager_model->select_where_order('restaurant_setting','id','DESC',['restaurant_id'=>$restaurant_id]);
		$this->json_output($events);
	}

	public function add_restaurant_msg(){
		if ($_POST['id'] == '') {
			$_POST['restaurant_id'] = $this->get_restaurant_id();
			$_POST['u_id'] = $_SESSION['user_id'];
			if($this->Whatsapp_manager_model->insert_any_query('restaurant_setting',$_POST)){
				$this->json_output(array('status'=>true));
			}
			else{
				$this->json_output(array('status'=>false));
			}
		}
		else{
			$_POST['u_id'] = $_SESSION['user_id'];
			if($this->Whatsapp_manager_model->updateactive_inactive('restaurant_setting',['id'=>$_POST['id']],$_POST)){
				$this->json_output(array('status'=>true));
			}
			else{
				$this->json_output(array('status'=>false));
			}
		}	
	}


	public function get_restaurant_id(){
		$get_id = $this->Whatsapp_manager_model->select_where('user',['id'=>$_SESSION['user_id']])[0];
		return $get_id['upline_id'];
	}

	public function send_offer_to_cust(){
		print_r($_POST);
	}

	public function customers(){
		$this->load->view('whatsapp_customer');
	}

	public function list_customers(){
		$restaurant_id = $this->get_restaurant_id();
		if(isset($_POST['searchkey']))
			$customers=$this->customer_model->list_customers($_POST['page'],$_POST['per_page'],$restaurant_id,$_POST['searchkey']);
		else
			$customers=$this->customer_model->list_customers($_POST['page'],$_POST['per_page'],$restaurant_id);

		$this->json_output($customers);
	}

	public function save_customers(){
		$restaurant_id = $this->get_restaurant_id();
		$user_details=$this->customer_model->check_user($_POST['contact_no']);
		if (!empty($user_details)) {
			$this->json_output(array('status'=>true,'is_email_exist'=>true));
				return;
		}
		else{
			$_POST['is_block'] = 0;
			$_POST['restaurant_id'] = $restaurant_id;
			if($this->customer_model->add_user($_POST)){
			$this->json_output(array('status'=>true));
			return;
			}
			else{
				$this->json_output(array('status'=>false));
			}
		}
	}

	public function show_perticular_customer(){
		$individual_manager = $this->customer_model->select_where('customer',['id'=>$_POST['id']])[0];
		$this->json_output($individual_manager);
	}

	public function edit_perticular_customer(){
		$sql = "SELECT * FROM customer WHERE id !=".$_POST['id']." AND contact_no =".$_POST['contact_number']." AND restaurant_id=".$restaurant_id;
		$check = $this->customer_model->query($sql);
		if (empty($check)) {
			if($this->customer_model->updateactive_inactive('customer',['id'=>$_POST['id']],['name'=>$_POST['name'],'contact_no'=>$_POST['contact_number']])){
				$this->json_output(array('status'=>true));
			}
			else{
				$this->json_output(array('status'=>false));
			}
		}
		else {
			$this->json_output(array('status'=>false,'msg'=>'Contact number already exist'));
		}
	}

	public  function block_unblock_customer()
	{
		if($_POST['is_block']=="off")
			$is_block=1;
		else
			$is_block=0;
		$this->customer_model->block_unblock_customer($_POST['id'],$is_block);
		$this->json_output(array('status'=>true));
	}


	public function uploadData(){
			$restaurant_id = $this->get_restaurant_id();
            $path = 'assets/';
            require_once APPPATH . "/third_party/PHPExcel.php";
            $config['upload_path'] = $path;
            $config['allowed_types'] = 'xlsx|xls';
            $config['remove_spaces'] = TRUE;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);            
            if (!$this->upload->do_upload('uploadFile')) {
                $error = array('error' => $this->upload->display_errors());
                //print_r($error);
                //print_r($error);
            } else {
                $data = array('upload_data' => $this->upload->data());
            }
            if(empty($error)){
              if (!empty($data['upload_data']['file_name'])) {
                $import_xls_file = $data['upload_data']['file_name'];
            } else {
                $import_xls_file = 0;
            }
            $inputFileName = $path . $import_xls_file;
            
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
                $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true, true, true);
                $flag = true;
                $i=0;
                // print_r($allDataInSheet);
                // echo "<br><br>";
                foreach ($allDataInSheet as $value) {
                  if($flag){
                    $flag =false;
                    continue;
                  }
                  $check = $this->customer_model->select_where('customer',['contact_no'=>$value['C'],'restaurant_id'=>$restaurant_id]);
                  //print_r($check);
                  	if(empty($check)){
                  		if ($value['A'] != '' && $value['C'] != '') {
                  			$inserdata[$i]['name'] = $value['A'];
                  			$inserdata[$i]['email'] = $value['B'];
                  			$inserdata[$i]['contact_no'] = $value['C'];
                  			$inserdata[$i]['restaurant_id'] = $restaurant_id;
                  			$inserdata[$i]['is_block'] = 0;
                  			$i++;
                  		}
                  	}
                  	else{
                  		$this->customer_model->updateactive_inactive('customer',['id'=>$check[0]['id']],['name'=>$value['A'],'contact_no'=>$value['C'],'email'=>$value['B']]);
                  	}
                }

                if (empty($inserdata)) {
                	$this->json_output(array('status'=>false,'msg'=>'File records are exist.Information updated successfully'));
                	exit();
                }

                $result = $this->customer_model->importdata($inserdata);   
                if($result){
                	unlink($inputFileName);
                	$this->json_output(array('status'=>true));
                  //echo "Imported successfully";
                }else{
                	$this->json_output(array('status'=>false,'msg'=>'Something went wrong'));
                  //echo "ERROR !";
                }             
 
          } catch (Exception $e) {
               die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
                        . '": ' .$e->getMessage());
            }
          }else{
          	$this->json_output(array('status'=>false,'msg'=>strip_tags($error['error'])));
              //echo $error['error'];
            }
	}




}