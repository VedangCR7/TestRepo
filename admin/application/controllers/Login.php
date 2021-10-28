<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
// Load Composer's autoloader
require 'vendor/autoload.php';
class Login extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('user_model');		
	}
	
	public function index() {
		$this->load->view('login');
	}


	public function terms_condition(){
		$this->load->view('commingsoon');
		//commingsoon.php
	}
	public function checklogin(){

		$email =$_POST['email'];
        $pass = $_POST['password'];
		$result = $this->user_model->do_login($email, $pass);
	
		if(is_array($result)){
		    $this->json_output(array('status'=>true,'msg'=>$result['name']." you are successfully logged in.",'usertype'=>$result['usertype']));
		}
		else if($result=="notactivated"){
			$this->json_output(array('status'=>false,'msg'=>'Your account is deactivate, please contact Youcloud Support.'));
		}
		else{
			$this->json_output(array('status'=>false,'msg'=>"The username or password you entered is incorrect"));
		}
	}

	public function checkloginuser(){

		$email =$_POST['email'];
        $pass = $_POST['password'];
		$result = $this->user_model->do_login($email, $pass);
	
		if(is_array($result)){
		    $this->json_output(array('status'=>true,'msg'=>$result['name']." you are successfully logged in.",'usertype'=>$result['usertype']));
		}
		else if($result=="notactivated"){
			$this->json_output(array('status'=>false,'msg'=>'Your account is deactivate, please contact Youcloud Support.'));
		}
		else{
			$this->json_output(array('status'=>false,'msg'=>"The username or password you entered is incorrect"));
		}
	}

	public function register_user()
	{
		/* ini_set("error_reporting", E_ALL); */
		
		foreach($_POST as $x => $val) 
		{
			$_POST[$x]=filter_var($_POST[$x], FILTER_SANITIZE_STRING);
		}
		$_POST['date'] = date('Y-m-d');
		$data=$_POST;

		$u = $this->user_model;
		$u->set_values($_POST);
		
		if($_POST['usertype']!="Individual User")
		{
			$arr=$u->get_api_key($_POST['usertype']);
			$u->api_key=$arr['api_key'];
			$u->group_seq=$arr['group_seq'];

			$data['api_key']=$arr['api_key'];
			$data['group_seq']=$arr['group_seq'];
		}
		
		if($_POST['usertype']=="Restaurant")
		{
			$u->is_individual_reg=1;
			$data['is_individual_reg']=1;
		}
		
		$u->profile_photo="assets/images/users/user.png";
		$data['profile_photo']="assets/images/users/user.png";
		$status=$u->isexist(array('email'=>$u->email));
		
		if($status=="exist")
		{
			$this->json_output(array('status'=>false,'msg'=>"Already have an account with us"));
			return;
		}
		else
		{
			$a=[];

			$manager = $this->Waiting_manager_model->select_where('user_data',['link_used'=>'0']);
			
			foreach($manager as $key=>$val)
			{
				$data1=json_decode($val['user_data']);
				$getemail = $data1->email;
				/* array_push($a,$getemail); */
			}
			
			if(in_array($_POST['email'], $a))
			{
				/* $this->json_output(array('status'=>false,'msg'=>"Your account is not verified yet, we already have sent verification link on your registered email please check your email and verify account.")); */
				
				/* send email */
				
				ob_start();
				$data=array(
					'data_id'=>$data_id,
					'email'=>$_POST['email'],
					'name'=>$_POST['name']
				);

				$msg = $this->load->view('email_template/verify_signup',$data, true);
				$msg=$this->convert_to_utf8($msg);
			
				$to=$_POST['email'];
				$subject="Registration Verification email";
				$from = "Foodnai<help@foodnai.com>";
				
				$mail = new PHPMailer(true);
				$mail->SMTPDebug = 0;
				$mail->isSMTP();                         
				$mail->Host = EMAIL_Host;
				$mail->SMTPAuth = EMAIL_SMTPAuth;                          
				$mail->Username = EMAIL_USERNAME;                 
				$mail->Password = EMAIL_PASSWORD;                           
				$mail->SMTPSecure = EMAIL_SMTPSecure;                           
				$mail->Port = EMAIL_Port;                                   
				
				$mail->From = EMAIL_FROMMAIL;
				$mail->FromName = EMAIL_FROMNAME;
				$mail->setFrom(EMAIL_FROMMAIL, EMAIL_FROMNAME);

				$mail->addAddress($to);					
				$mail->isHTML(true);					
				$mail->Subject = $subject;
				$mail->Body = $msg;
				
				$mail->Send();
				
				$this->json_output(array('status'=>false,'msg'=>"Your account is not verified yet, we have sent verification link now again on your registered email please check your email and verify account."));
			}
			else
			{
				$data_id=$this->user_model->insert_user_data(json_encode($data));
				
				//send email
				ob_start();
				$data=array(
					'data_id'=>$data_id,
					'email'=>$_POST['email'],
					'name'=>$_POST['name']
				);
				
				$data1=array(
					'data_id'=>$data_id,
					'email'=>$_POST['email'],
					'name'=>$_POST['name']
				);

				$msg = $this->load->view('email_template/signup_success',$data, true);
				$msg=$this->convert_to_utf8($msg);
			
				$to=$_POST['email'];
				$subject="Registration email";
				$from = "Foodnai<help@foodnai.com>";
			
				$mail = new PHPMailer(true);
				$mail->SMTPDebug = 0;
				$mail->isSMTP();                         
				$mail->Host = EMAIL_Host;
				$mail->SMTPAuth = EMAIL_SMTPAuth;                          
				$mail->Username = EMAIL_USERNAME;                 
				$mail->Password = EMAIL_PASSWORD;                           
				$mail->SMTPSecure = EMAIL_SMTPSecure;                           
				$mail->Port = EMAIL_Port;                                   
				
				$mail->From = EMAIL_FROMMAIL;
				$mail->FromName = EMAIL_FROMNAME;
				$mail->setFrom(EMAIL_FROMMAIL, EMAIL_FROMNAME);

				$mail->addAddress($to);
				$mail->addBcc('munotrupesh@gmail.com');
				$mail->addBcc('rupeshm@foodnai.com');
				$mail->addBcc('rahulwaghole14@gmail.com');
					
				$mail->isHTML(true);
					
				$mail->Subject = $subject;
				$mail->Body = $msg;
				
				if(!$mail->Send()) 
				{
					$this->json_output(array('status'=>false,'msg'=>"Mailer Error: " . $mail->ErrorInfo));
					return;
				}

				if($data_id)
				{
					$user_data=$this->user_model->get_userdata($data_id);

					if($user_data['link_used']==0)
					{
						$data=json_decode($user_data['user_data']);
						
						$u = $this->user_model;
						$u->set_values($data);
						$user_id=$u->add();
						$url ="https://mshastra.com/sendurlcomma.aspx?user=20100556&pwd=rbip6u&senderid=MOBSMS&CountryCode=91&mobileno=".$_POST['contact_number']."&msgtext=Thank you for registering your Restaurant on YouCloudResto.For more details please check https://www.youcloudresto.com";
						$ch = curl_init($url);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						$curl_scraped_page = curl_exec($ch);
						curl_close($ch);
						if($data->usertype=="Restaurant")
						{
							/* $menuarray = array(0 => 'Profile',1=>'Dashboard', 2=>'Menu',3=>'Table Management',4=>'Order',5=>'Billing',6=>'invoice',7=>'Offers',8=>'User Management',9=>'Restaurant Manager',10=>'Waitinglist Manager',10=>'Whatsapp Manager',11=>'Customers',12=>'Waitinglist',13>'Reports',14=>'Help',15=>'Online order'); */
							$menuarray = array(0 => 'Profile',1=>'Dashboard', 2=>'Menu',3=>'Table Management',4=>'Offers',5=>'Help');
							$authority['menu_name'] = implode(',', $menuarray);
							$authority['restaurant_id'] = $user_id;
							$this->user_model->insert_authority_data($authority);
						}else{
							$menuarray = array(0 => 'Profile',1=>'Dashboard', 2=>'Menu',3=>'Table Management',4=>'Offers',5=>'Help');
							$authority['menu_name'] = implode(',', $menuarray);
							$authority['restaurant_id'] = $user_id;
							$this->user_model->insert_authority_data($authority);
						}
						
						$this->user_model->update_link_used($user_data['id']);
						
						if($user_id)
						{
							$verify="email";
						}
						else
						{
							$verify="not";
						}
					}
					
					/* $msg1 = $this->load->view('email_template/user_details',$data1, true);
					$msg1=$this->convert_to_utf8($msg1);
				
					$subject="Registration details email";
					$from = "Foodnai<help@foodnai.com>";
				
					$mail1 = new PHPMailer(true);
					$mail1->SMTPDebug = 0;
					$mail1->isSMTP();                         
					$mail1->Host = EMAIL_Host;
					$mail1->SMTPAuth = EMAIL_SMTPAuth;                          
					$mail1->Username = EMAIL_USERNAME;                 
					$mail1->Password = EMAIL_PASSWORD;                           
					$mail1->SMTPSecure = EMAIL_SMTPSecure;                           
					$mail1->Port = EMAIL_Port;                                   
					
					$mail1->From = EMAIL_FROMMAIL;
					$mail1->FromName = EMAIL_FROMNAME;
					$mail1->setFrom(EMAIL_FROMMAIL, EMAIL_FROMNAME);

					$mail1->addAddress('munotrupesh@gmail.com');
					$mail1->addAddress('rupeshm@foodnai.com');
					$mail1->addAddress('sushildeokar12@gmail.com');
						
					$mail1->isHTML(true);
						
					$mail1->Subject = $subject;
					$mail1->Body = $msg1;
					
					$mail1->Send(); */
					
					$this->json_output(array('status'=>true,'msg'=>"Thanks for Signing Up ! You will receive an email on your registered email id for account confirmation, Please confirm your account !!!"));
				}
				else
				{
					$this->json_output(array('status'=>false,'msg'=>"Something went wrong please try again !"));
				}
			}
		}		
	}


	public function verify_registration()
	{
		if(isset($_GET['ref']))
		{
			$user_data=$this->user_model->get_userdata($_GET['ref']);
		}
		else
		{
			$user_data=$this->user_model->get_userdata($_POST['data_id']);
		}
		
		if($user_data['link_used']==0)
		{
			$data=json_decode($user_data['user_data']);
			
			$u = $this->user_model;
			$u->set_values($data);
			$user_id=$u->add();
			
			if($data->usertype=="Restaurant")
			{
				$menuarray = array(0 => 'Profile',1=>'Dashboard', 2=>'Menu',3=>'Table Management',4=>'Order',5=>'Billing',6=>'invoice',7=>'Offers',8=>'User Management',9=>'Restaurant Manager',10=>'Waitinglist Manager',10=>'Whatsapp Manager',11=>'Customers',12=>'Waitinglist',13>'Reports',14=>'Help',15=>'Online order');
				$authority['menu_name'] = implode(',', $menuarray);
				$authority['restaurant_id'] = $user_id;
				$this->user_model->insert_authority_data($authority);
			}
			
			$this->user_model->update_link_used($user_data['id']);
			
			if($user_id)
			{
				$verify="email";
			}
			else
			{
				$verify="not";
			}
		}
		else
		{
			$verify="invalidlink";
		}
		$this->load->view('verify_registration',array('verify'=>$verify));
	}

	public function logout()
	{		
		$usertype=$_SESSION['usertype'];
		$this->session->unset_userdata('logged_in');
	  
		session_destroy();
		
		/* var_dump($_SESSION);
		
		exit; */
		if(in_array($usertype,array('Admin','Restaurant','Burger and Sandwich','Restaurant chain','School','Individual User','Restaurant manager','Waitinglist manager','Whatsapp manager')))
		{
	   		if(isset($_GET['status']))
	   			redirect('login?status='.$_GET['status'], 'refresh');
	   		else
	   			redirect('login', 'refresh');
		}
		/*else{
	   		redirect('web/login', 'refresh');
		}*/
	}

	public function get_session_id()
	{
		if(isset($_SESSION['user_id']))
		{
			$u=$this->user_model;
			$u->id=$_SESSION['user_id'];
			$user=$u->get();
			$this->json_output(array('status'=>true,'id'=>$_SESSION['sess_rand_id'],'usertype'=>$_SESSION['usertype'],'logged_in'=>$_SESSION['logged_in'],'is_active'=>$user['is_active'],'user'=>$user));
		}
		else
		{
			$this->json_output(array('status'=>false));
		}
	}

	public function make_table_available()
	{
		$this->db->trans_start();

		$restaurant_lists = $this->Waiting_manager_model->select_where('user',['usertype'=>'Restaurant']);
		
		foreach($restaurant_lists as $key=>$restaurant_data)
		{

			$timezone = $this->get_time_zone($restaurant_data['country']);
		
			if ($timezone)
			{
				date_default_timezone_set("'".$timezone."'");
			}
			else
			{
				date_default_timezone_set("Asia/Kolkata");
			}

			$restaurant_data['id'];
			$date = date('Y-m-d');
			$time = strtotime(date('H:i'));
			$close_time = strtotime($restaurant_data['close_time']);
			
			if($time > $close_time)
			{
				$occupied_orders = $this->Waiting_manager_model->select_where('table_orders',['flag'=>'N','restaurant_id'=>$restaurant_data['id'],'insert_date<='=>$date]);
				// echo $this->db->last_query();
				// echo "<pre>";print_r($occupied_orders);echo "<br><br>";
				foreach($occupied_orders as $key=>$value)
				{
					$orders = $this->Waiting_manager_model->select_where('orders',['table_id'=>$value['table_id']]);
					//echo "<pre>";print_r($orders);
					$flag = 0;
					foreach($orders as $key=>$row)
					{
						if($row['status'] == 'New' || $row['status'] == 'Confirmed' || $row['status'] == 'Assigned To Kitchen')
						{
							$flag = 1;
							if($row['is_invoice'] == 1)
							{
								$this->Waiting_manager_model->updateactive_inactive('orders',['table_id'=>$row['table_id'],'table_orders_id'=>$row['table_orders_id']],['status'=>'Completed']);
							}
							else
							{
								$this->Waiting_manager_model->updateactive_inactive('orders',['table_id'=>$row['table_id'],'table_orders_id'=>$row['table_orders_id']],['status'=>'Canceled','cancel_note'=>'Timeout']);
							}
						}
					}

					if($flag == 1){
						$this->Waiting_manager_model->updateactive_inactive('table_details',['id'=>$value['table_id']],['is_available'=>1]);
						$this->Waiting_manager_model->updateactive_inactive('table_orders',['id'=>$value['table_id']],['flag'=>'Y']);
					}

					if($this->db->trans_complete())
					{
						echo "Successfully done";
					}
				}
			}
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
	
	public function show_success_page()
	{
		$data=array(
			'data_id'=>'193',
			'email'=>'sushildeokar12@gmail.com',
			'name'=>'sushil deokar'
		);
		
		$msg = $this->load->view('email_template/signup_success',$data, true);
		$msg=$this->convert_to_utf8($msg);
	
		$to='sushildeokar12@gmail.com';
		$subject="Registration Verification email";
		$from = "Foodnai<help@foodnai.com>";
		
		$mail = new PHPMailer(true);
		$mail->SMTPDebug = 0;
		$mail->isSMTP();                         
		$mail->Host = EMAIL_Host;
		$mail->SMTPAuth = EMAIL_SMTPAuth;                          
		$mail->Username = EMAIL_USERNAME;                 
		$mail->Password = EMAIL_PASSWORD;                           
		$mail->SMTPSecure = EMAIL_SMTPSecure;                           
		$mail->Port = EMAIL_Port;                                   
		
		$mail->From = EMAIL_FROMMAIL;
		$mail->FromName = EMAIL_FROMNAME;
		$mail->setFrom(EMAIL_FROMMAIL, EMAIL_FROMNAME);

		$mail->addAddress($to);					
		$mail->isHTML(true);					
		$mail->Subject = $subject;
		$mail->Body = $msg;
		
		if($mail->Send())
		{
			echo 'successful';
		}
		else
		{
			echo 'failed';
		}
	}
}
?>