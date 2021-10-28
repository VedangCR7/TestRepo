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
class Waiting_manager extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->is_loggedin();
		$this->load->model('restaurant_manager_order_model');
		$this->load->model('Waiting_manager_model');		
		$this->load->library("session");
       	$this->load->helper('url');
       	$this->is_manager_delete();
	}

	public  function dashboard()
	{	
		$data['waiting_list_manager'] = $this->Waiting_manager_model->select_where('waitinglist_details',['is_decline'=>0,'is_assign'=>0]);
		$sql1="SELECT profile_photo FROM user WHERE id =".$_SESSION['user_id'];
		$data['profile'] = $this->restaurant_manager_order_model->query($sql1);
		$this->load->view('waitinglist_dashboard',$data);
	}
	
	public function waiting_list_manager() {
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		$this->load->view('waiting_manager',$data);
	}

	public function list_manager(){
		if(isset($_POST['searchkey']))
			$manager=$this->Waiting_manager_model->list_manager($_POST['page'],$_POST['per_page'],$_POST['searchkey']);
		else
		$manager=$this->Waiting_manager_model->list_manager($_POST['page'],$_POST['per_page']);
		$this->json_output($manager);
	}

	public function save_waiting_manager(){
		$user_details=$this->Waiting_manager_model->check_user($_POST['email']);
		if (!empty($user_details)) {
			$this->json_output(array('status'=>true,'is_email_exist'=>true,'msg'=>"Email already exists."));
				return;
		}
		else{
			$_POST['password'] = $this->randomPassword();
			$_POST['is_active'] = 1;
			$_POST['usertype'] = 'Waitinglist manager';
			$_POST['upline_id'] = $_SESSION['user_id'];
			if($this->Waiting_manager_model->add_user($_POST)){
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
			$this->Waiting_manager_model->updateactive_inactive('user',['id'=>$_POST['id']],['is_active'=>1]);		
		else
			$this->Waiting_manager_model->updateactive_inactive('user',['id'=>$_POST['id']],['is_active'=>0]);
		$this->json_output(array('status'=>true));
	}

	public function delete_perticular_waitinglist_manager(){
		$this->Waiting_manager_model->permanent_delete_manager('user',['id'=>$_POST['id']]);
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
					
					$m=$this->Waiting_manager_model;
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
    		$user_details=$this->Waiting_manager_model->check_user($_POST['email']);
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
						$m=$this->Waiting_manager_model;
						$m->name = $_POST['name'];
						$m->email = $_POST['email'];
						$m->password = $this->randomPassword();
						$m->is_active = 1;
						$m->usertype = 'Waitinglist manager';
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

	public function list_waiting_details(){
		$get_upline_id = $this->get_upline_id();
		$events=$this->Waiting_manager_model->select_where_order('waitinglist_details','id','ASC',['is_decline'=>0,'is_assign'=>0,'restaurant_id'=>$get_upline_id]);
		$this->json_output($events);
	}

	public function add_waiting_cust()
	{
		$_POST['is_assign'] = 0;
		$_POST['is_decline'] = 0;
		$_POST['restaurant_id'] = $this->get_upline_id();
		$_POST['u_id'] = $_SESSION['user_id'];
		$arrive_time = $_POST['arrive_time'];
		$calendar_date = $_POST['calendar_date'];
		
		
		foreach($_POST as $x => $val) 
		{	
			$_POST[$x]=filter_var($_POST[$x], FILTER_SANITIZE_STRING);
		}
		
		//check same entries
		$check_same_entries = $this->Waiting_manager_model->select_where('waitinglist_details',['mobile_number'=>$_POST['mobile_number'],'arrive_time'=>$_POST['arrive_time'],'calendar_date'=>$_POST['calendar_date']]);
		//print_r($check_same_entries);exit();
		
		if(empty($check_same_entries))
		{
			if($this->Waiting_manager_model->insert_waiting_cus('waitinglist_details',$_POST))
			{
				$get_upline_id = $this->get_upline_id();
				$rest_name = $this->Waiting_manager_model->select_where('user',['id'=>$get_upline_id])[0];
				$content = $this->Waiting_manager_model->select_where('restaurant_setting',['restaurant_id'=>$get_upline_id]);
				$from = str_replace(' ', '%20', $rest_name['business_name']);
				$url ="https://mshastra.com/sendurlcomma.aspx?user=20100556&pwd=rbip6u&senderid=MOBSMS&CountryCode=91&mobileno=".$_POST['mobile_number']."&msgtext=Hello ".$_POST['name'].", Thank you for visiting Hotel ".$from.". Your table booking time is ".$_POST['arrive_time'].", waiting period is minimum ".$_POST['estimated_time'].".YouCloudResto";
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$curl_scraped_page = curl_exec($ch);
				curl_close($ch);
				$this->json_output(array('status'=>true,'response'=>$response,'err'=>$err));
			}
		}
		else
		{
			$this->json_output(array('status'=>false,'msg'=>'Same Entry for same time is not allowed'));
		}
	}

	public function add_rest_waiting_cust()
	{
		$_POST['is_assign'] = 0;
		$_POST['is_decline'] = 0;
		$_POST['restaurant_id'] = $_SESSION['user_id'];
		$_POST['u_id'] = $_SESSION['user_id'];			
		$arrive_time = $_POST['arrive_time'];
		$calendar_date = $_POST['calendar_date'];
		
		foreach($_POST as $x => $val) 
		{		
			$_POST[$x]=filter_var($_POST[$x], FILTER_SANITIZE_STRING);
		}
		
		$check_same_entries = $this->Waiting_manager_model->select_where('waitinglist_details',['mobile_number'=>$_POST['mobile_number'],'arrive_time'=>$_POST['arrive_time'],'calendar_date'=>$_POST['calendar_date']]);
		
		if(empty($check_same_entries))
		{
			if($this->Waiting_manager_model->insert_waiting_cus('waitinglist_details',$_POST))
			{ 
				$get_upline_id = $this->get_upline_id();
				$rest_name = $this->Waiting_manager_model->select_where('user',['id'=>$_SESSION['user_id']])[0];
				//$content = $this->Waiting_manager_model->select_where('restaurant_setting',['restaurant_id'=>$get_upline_id]);
				$from = str_replace(' ', '%20', $rest_name['business_name']);
				$url ="https://mshastra.com/sendurlcomma.aspx?user=20100556&pwd=rbip6u&senderid=MOBSMS&CountryCode=91&mobileno=".$_POST['mobile_number']."&msgtext=Hello ".$_POST['name'].", Thank you for visiting Hotel ".$from.". Your table booking time is ".$_POST['arrive_time'].", waiting period is minimum ".$_POST['estimated_time'].".YouCloudResto";
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$curl_scraped_page = curl_exec($ch);
				curl_close($ch);
				$this->json_output(array('status'=>true));
			}
		}
		else{
			$this->json_output(array('status'=>false,'msg'=>'Same Entry for same time is not allowed'));
		}
	}

	public function assign_waiting_manager()
	{
		if ($this->get_upline_id() != '') 
		{
			$action_taken = $_SESSION['name'];
		}
		else
		{
			$action_taken = $_SESSION['business_name'];
		}
		
		if($this->Waiting_manager_model->updateactive_inactive('waitinglist_details',['id'=>$_POST['id']],['is_assign'=>1,'action_taken'=>$action_taken]))
		{
			$this->json_output(array('status'=>true));
		}
		else
		{
			$this->json_output(array('status'=>false));
		}
	}

	public function decline_waiting_manager()
	{
		if ($this->get_upline_id() != '') 
		{
			$action_taken = $_SESSION['name'];
		}
		else
		{
			$action_taken = $_SESSION['business_name'];
		}
		
		if($this->Waiting_manager_model->updateactive_inactive('waitinglist_details',['id'=>$_POST['id']],['is_decline'=>1,'action_taken'=>$action_taken]))
		{
			$this->json_output(array('status'=>true));
		}
		else
		{
			$this->json_output(array('status'=>false));
		}
	}

	public function todays_customer()
	{
		$this->load->view('today_waiting_customer');
	}

	public function todays_waiting_list()
	{
		if(isset($_POST['searchkey']))
			$manager=$this->Waiting_manager_model->todaywaitinglist($_POST['page'],$_POST['per_page'],$_POST['searchkey']);
		else
		$manager=$this->Waiting_manager_model->todaywaitinglist($_POST['page'],$_POST['per_page']);
		$this->json_output($manager);
	}

	public function show_perticular_waitinglist_manager()
	{
		$individual_manager = $this->Waiting_manager_model->select_where('user',['id'=>$_POST['id']])[0];
		$this->json_output($individual_manager);
	}

	public function edit_perticular_waitinglist_manager()
	{
		foreach($_POST as $x => $val) 
		{
			$_POST[$x]=filter_var($_POST[$x], FILTER_SANITIZE_STRING);
		}
		
		if($this->Waiting_manager_model->updateactive_inactive('user',['id'=>$_POST['id']],['name'=>$_POST['name'],'password'=>$_POST['password'],'contact_number'=>$_POST['contact_number']])){
			$this->json_output(array('status'=>true));
		}
		else
		{
			$this->json_output(array('status'=>false));
		}
	}

	public function show_perticular_waitinglist_cust()
	{
		$individual_manager = $this->Waiting_manager_model->select_where('waitinglist_details',['id'=>$_POST['id']])[0];
		$this->json_output($individual_manager);
	}

	public function show_assign_cust()
	{
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		$this->load->view('waiting_assign_cust',$data);
	}

	public function show_decline_cust()
	{
		$this->load->view('waiting_decline_cust');
	}

	public function assign_list()
	{
		if(isset($_POST['searchkey']))
			$manager=$this->Waiting_manager_model->assign_list($_POST['page'],$_POST['per_page'],$_POST['searchkey']);
		else
		$manager=$this->Waiting_manager_model->assign_list($_POST['page'],$_POST['per_page']);
		$this->json_output($manager);	
	}

	public function all_declineassign_list()
	{
		if(isset($_POST['searchkey'])){
			$manager=$this->Waiting_manager_model->all_declineassign_list($_POST['page'],$_POST['per_page'],$_POST['searchkey']);}
		else
		$manager=$this->Waiting_manager_model->all_declineassign_list($_POST['page'],$_POST['per_page']);
		$this->json_output($manager);
	}

	public function decline_list()
	{
		if(isset($_POST['searchkey']))
			$manager=$this->Waiting_manager_model->decline_list($_POST['page'],$_POST['per_page'],$_POST['searchkey']);
		else
		$manager=$this->Waiting_manager_model->decline_list($_POST['page'],$_POST['per_page']);
		$this->json_output($manager);	
	}

	public function get_upline_id()
	{
		$upline_id = $this->Waiting_manager_model->select_where('user',['id'=>$_SESSION['user_id']])[0];
		return $upline_id['upline_id'];
	}

	public function restaurant_waiting_dashboard()
	{
		$restaurant_data = $this->Waiting_manager_model->select_where('user',['id'=>$_SESSION['user_id']]);
		$timezone = $this->get_time_zone($restaurant_data[0]['country']);
		
		if ($timezone)
		{
			$data['defaulttimezone']=$timezone;
		}
		else
		{
			$data['defaulttimezone']="Asia/Kolkata";
		}
		
		$data['waiting_manager'] = $this->Waiting_manager_model->select_where('user',['upline_id'=>$_SESSION['user_id'],'usertype'=>'Waitinglist manager','is_active'=>1]);
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		//$this->load->view('sidebar',$menudata);
		$this->load->view('restaurantwaitinglistdashboard',$data);
	}

	public function restaurant_waiting_list_details(){
		$get_upline_id = $_SESSION['user_id'];
		$events=$this->Waiting_manager_model->select_where_order('waitinglist_details','id','ASC',['is_decline'=>0,'is_assign'=>0,'restaurant_id'=>$get_upline_id]);
		$this->json_output($events);
	}

	public function show_waiting_manager_customer(){
		$events = $this->Waiting_manager_model->select_where_order('waitinglist_details','id','ASC',['u_id'=>$_POST['u_id'],'calendar_date'=>$_POST['calendar_date'],'is_assign'=>0,'is_decline'=>0]);
		$this->json_output($events);
	}

	public function restaurant_msg_details(){
		$events = $this->Waiting_manager_model->select_where_order('restaurant_setting','id','DESC',['restaurant_id'=>$_SESSION['user_id']]);
		$this->json_output($events);
	}

	public function add_restaurant_msg(){
		if ($_POST['id'] == '') {
			$_POST['restaurant_id'] = $_SESSION['user_id'];
			$_POST['u_id'] = $_SESSION['user_id'];
			if($this->Waiting_manager_model->insert_any_query('restaurant_setting',$_POST)){
				$this->json_output(array('status'=>true));
			}
			else{
				$this->json_output(array('status'=>false));
			}
		}
		else{
			if($this->Waiting_manager_model->updateactive_inactive('restaurant_setting',['id'=>$_POST['id']],$_POST)){
				$this->json_output(array('status'=>true));
			}
			else{
				$this->json_output(array('status'=>false));
			}
		}	
	}
	
	public function send_sms()
	{
		$from = '9850383609';
		$to = '90921900488';
		$sms_content = '';
		$arrive_time = '13:00:00';
		$calendar_date = '2021-06-24';
		
		$this->addwatinglistcustsms($from,$to,$sms_content,$arrive_time,$calendar_date);
	}

	public function addwatinglistcustsms($from,$to,$sms_content,$arrive_time="",$calendar_date="",$name="",$estimated_time="")
	{
		$from = str_replace('%20', ' ', $from);
		
		if($from=='Hotel Green Signal')
		{
			/* $name = "RndFoods"; */
			$period = "minimum ".$estimated_time;
			
			$parampro['uname'] = "rndfoods";
			$parampro['password'] = "123456";
			$parampro['sender'] = 'GRNSIG';
			$parampro['receiver'] = $to;
			$parampro['route'] = "TA";
			$parampro['msgtype'] = "1";
			$parampro['tempid'] = "1207162427706660825";
			$parampro['sms'] = "Hello ".$name." Thank you for visiting ".$from.". Your table booking time is ".$arrive_time.", waiting period is ".$period.", RNDFoods";
			$sendsmspro = http_build_query($parampro);
			
			$urlpro="http://sendsms.designhost.in/index.php/smsapi/httpapi/?".$sendsmspro;
			
			$ch=curl_init();
			curl_setopt($ch, CURLOPT_URL, $urlpro);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$resultpro = curl_exec($ch);
			/* var_dump($resultpro);exit; */
			curl_close($ch);
		}
	}
	
	
	function get_time_zone($country)
	{
		$timezone = null;
		switch ($country) {
			case "India":
				$timezone = "Asia/Kolkata";
				break;
			case "INDIA":
				$timezone = "Asia/Kolkata";
				break;
			case "Dubai":
				$timezone = "Asia/Dubai";
				break;  
			case "USA":
				$timezone = "America/New_York";
				break; 
			case "USA":
				$timezone = "America/New_York";
				break; 
			case "Greece":
				$timezone = "Europe/Athens";
				break;			
			case "GREECE":
				$timezone = "Europe/Athens";
				break; 
			case "United Kingdom":
				$timezone = "Europe/London";
				break;  
			case "UK":
				$timezone = "Europe/London";
				break;        
		}
		return $timezone;
	}
	
	public function show_customer()
	{	
		$data['waiting_list_manager'] = $this->Waiting_manager_model->select_where('waitinglist_details',['is_decline'=>0,'is_assign'=>0]);
		$sql1="SELECT profile_photo FROM user WHERE id =".$_SESSION['user_id'];
		$data['profile'] = $this->restaurant_manager_order_model->query($sql1);
		$this->load->view('waitinglist_customer',$data);
	}
}
?>