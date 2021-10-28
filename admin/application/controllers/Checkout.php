<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
// Load Composer's autoloader
require 'vendor/autoload.php';
class Checkout extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->is_customer_loggedin();
        $this->load->library('cart');
		$this->load->model('user_model');	
		$this->load->model('customer_model');	
		$this->load->model('main_menu_model');	
		$this->load->model('order_model');	
		$this->load->model('order_item_model');	
		$this->load->model('recipes_model');
		$this->load->model('table_order_model');	
		$this->load->model('table_model');	

	}
	
	public function viewcart($restid,$main_menu_id,$tableid="") 
	{
		$m=$this->main_menu_model;
		$m->id=$main_menu_id;
		$main_menu_details=$m->get();
		$user=$this->user_model->get_active_user($restid);
		$data=array(
			'restid'=>$restid,
			'user'=>$user,
			'main_menu_id'=>$main_menu_id,
			'main_menu'=>$main_menu_details,
			'tableid'=>$tableid,
			'customer'=>$_SESSION['customer']
		);
		$data['restaurant_type'] = $this->customer_model->select_where('user',['id'=>$restid]);
		
		if($this->uri->segment(6) == 'yes')
		{
			$this->load->view('web/web_cart_details',$data);
		}
		else
		{
			$this->load->view('web/cart_details',$data);
		}
	}

	public function place_order()
	{
		// $cart_details=$this->recipes_model->get_cart_menu_details();
		// print_r($cart_details);exit();
		$u=$this->user_model;
		$u->id=$_POST['rest_id'];
		$restaurant=$u->get();

		$timezone = $this->get_time_zone($restaurant['country']);
		
		if ($timezone)
		{
			date_default_timezone_set("'".$timezone."'");
		}
		else
		{
			date_default_timezone_set("Asia/Kolkata");
		}
		
		$t=$this->table_model;
		$t->id=$_POST['tableid'];
		$table_details=$t->get();
		$cart_details=$this->recipes_model->get_cart_menu_details();
		
		if($table_details['is_available']==0)
		{
			$table_order_details=$this->table_order_model->get_table_order('N',$_POST['tableid'],date('Y-m-d'));
			
			if(empty($table_order_details))
			{
				$to=$this->table_order_model;
				$to->table_orderno='';
				$to->table_id=$_POST['tableid'];
				$to->flag='N';
				$to->insert_date=date('Y-m-d');
				$to->insert_time=date('H:i:s');
				$to->restaurant_id=$_POST['rest_id'];
				$table_orders_id=$to->add();

				$restaurant_name=$restaurant['name'];
				$intial=strtoupper(substr($restaurant_name, 0, 2));
				$formated_id=str_pad($table_orders_id, 6, '0', STR_PAD_LEFT);

				$too=$this->table_order_model;
				$too->id=$table_orders_id;
				$too->table_orderno=$intial."T".$formated_id;
				$too->update();
			}
			else
				$table_orders_id=$table_order_details['id'];
		}
		else
		{
			$to=$this->table_order_model;
			$to->table_orderno='';
			$to->table_id=$_POST['tableid'];
			$to->flag='N';
			$to->insert_date=date('Y-m-d');
			$to->insert_time=date('H:i:s');
			$to->restaurant_id=$_POST['rest_id'];
			$table_orders_id=$to->add();

			
			$restaurant_name=$restaurant['name'];
			$intial=strtoupper(substr($restaurant_name, 0, 2));
			$formated_id=str_pad($table_orders_id, 6, '0', STR_PAD_LEFT);

			$too=$this->table_order_model;
			$too->id=$table_orders_id;
			$too->table_orderno=$intial."T".$formated_id;
			$too->update();
		}
		
		$o=$this->order_model;
		$o->customer_id=$_POST['customer_id'];
		$o->loyalty_points=$_POST['loyalty_points'];
		$o->sub_total=array_sum(array_column($cart_details,'subtotal'));
		$o->disc_total=0;
		$o->net_total=$_POST['net_total'];
		$o->suggetion=$_POST['suggetion'];
		$o->table_id=$_POST['tableid'];
		$o->status="New";
		$o->created_at=date('Y-m-d H:i:s');
		$o->rest_id=$_POST['rest_id'];
		$o->table_orders_id=$table_orders_id;
		$o->no_of_person=$_POST['no_of_person'];
		$order_id=$o->add();
		
		foreach ($cart_details as $cart) 
		{
			$oi=$this->order_item_model;
			$oi->order_id=$order_id;
			$oi->recipe_id=$cart['options']['menu_id'];
			$oi->qty=$cart['qty'];
			$oi->price=$cart['price'];
			$oi->total=$cart['subtotal'];
			$oi->disc=0;
			$oi->disc_amt=0;
			$oi->special_notes = $cart['comment'];
			$oi->sub_total=$cart['subtotal'];
			$oi->add();
			$last_order_item_id = $this->db->insert_id();
			
			foreach($cart['addon'] as $key => $cart_addon){
				$this->customer_model->insert_query('order_addon_menu',['order_item_id'=>$last_order_item_id,'option_id'=>$cart_addon['addon_id']]);
			}
		}

		$restaurant_name=$restaurant['name'];
		$intial=strtoupper(substr($restaurant_name, 0, 2));
		$formated_id=str_pad($order_id, 8, '0', STR_PAD_LEFT);

		$o=$this->order_model;
		$o->id=$order_id;
		$o->order_no=$intial.$formated_id;
		$order=$o->update();
		
		/*$this->customer_model->block_unblock_customer($_POST['customer_id'],1);*/
		
		if($table_details['is_available']!=0)
		{
			$this->order_model->block_unblock_table($_POST['tableid'],0);
		}

		$this->session->unset_userdata('cart_contents');

		if($order_id)
		{
			$sql7 = "SELECT o.id, o.order_no,o.net_total,o.status,o.created_at,c.name,o.table_id,o.table_orders_id,td.title,tblo.order_type FROM `orders` as o 
			LEFT JOIN customer as c on c.id = o.customer_id
			LEFT JOIN table_details as td on td.id = o.table_id
			INNER JOIN table_orders as tblo on tblo.id = o.table_orders_id
			WHERE o.id = ".$order_id." and o.status='New' and o.viewed=0 ORDER BY o.id desc ";
			$res= $this->order_model->query($sql7);
				
			$orderType = $res[0]['order_type'];
			$created_at = $res[0]['created_at'];
			$order_no = $res[0]['order_no'];
			$title = $res[0]['title'];
			$name = $res[0]['name'];
			$table_id = $_POST['tableid'];			
			$usertype=$restaurant['usertype'];
			$upline_id=$restaurant['upline_id'];
			
			if($usertype=="Restaurant")
			{
				/* Restaurant manager */
				/* $token=array();					 */
					
				$sql_devicetoken = "SELECT * from users_devicetoken where userid = ".$_POST['rest_id'];
				$res_devicetoken= $this->order_model->query($sql_devicetoken);
				
				if(count($res_devicetoken)>1)
				{
					foreach ($res_devicetoken as $resdevicetoken) 
					{
						$this->order_model->send_notifiation($order_id,$table_id,$table_orders_id,$orderType,$title,$name,$order_no,$created_at,$resdevicetoken['devicetoken']);
					}
				}
				else
				{
					$token = $resdevicetoken[0]['devicetoken'];
					$this->order_model->send_notifiation($order_id,$table_id,$table_orders_id,$orderType,$title,$name,$order_no,$created_at,$token);
				}
			}
			else
			{
				$sql_devicetoken = "SELECT * from users_devicetoken where userid = ".$upline_id;
				$res_devicetoken= $this->order_model->query($sql_devicetoken);
				
				if(count($res_devicetoken)>1)
				{
					foreach ($res_devicetoken as $resdevicetoken) 
					{
						/* array_push($token,$resdevicetoken['devicetoken']); */
						$this->order_model->send_notifiation($order_id,$table_id,$table_orders_id,$orderType,$title,$name,$order_no,$created_at,$resdevicetoken['devicetoken']);						
					}
				}
				else
				{
					$token = $resdevicetoken[0]['devicetoken'];
					$this->order_model->send_notifiation($order_id,$table_id,$table_orders_id,$orderType,$title,$name,$order_no,$created_at,$token);
				}
			}
			
			$this->order_model->send_notifiation($order_id,$table_id,$table_orders_id,$orderType,$title,$name,$order_no,$created_at,$token);
			$this->session->unset_userdata('cart_contents');
			$this->json_output(array('status'=>true,'msg'=>'Order Placed Successfully.'));
		}
		else
		{
			$this->json_output(array('status'=>false,'msg'=>'Something went wrong please try again.'));
		}
	}

	public function place_order1()
	{
		if($_POST['delivery_payment']!= 'COD'){
			require_once('application/libraries/stripe-php/init.php');
		 
			$stripeSecret = $this->input->post('SECRET_KEY');
	 
			\Stripe\Stripe::setApiKey($stripeSecret);
		  
			$stripe = \Stripe\Charge::create ([
					"amount" => $this->input->post('net_total')*100,
					"currency" => "INR",
					"source" => $this->input->post('token'),
					"description" => "foodnai web order"
			]);
						  
			$data = array('success' => true, 'data'=> $stripe);
			$txn_id = $data['data']['balance_transaction'];
			$currency = $data['data']['currency'];
			$customer_id=$_POST['customer_id'];
			$payment_date=date('Y-m-d H:i:s');
			$paid_amount=$_POST['net_total'];
			
			$insertdata = array(
				'customer_id'=>$customer_id,
				'txn_id'=>$txn_id,
				'currency'=>$currency,
				'paid_amount'=>$paid_amount,
				'payment_date'=>$payment_date
			);
		
		}
	
        /* echo json_encode($data);exit; */
		
		$u=$this->user_model;
		$u->id=$_POST['rest_id'];
		$restaurant=$u->get();
				
		$timezone = $this->get_time_zone($restaurant['country']);
		
		if ($timezone)
		{
			date_default_timezone_set("'".$timezone."'");
		}
		else
		{
			date_default_timezone_set("Asia/Kolkata");
		}
		
		$t=$this->table_model;
		$t->id=$_POST['tableid'];
		$table_details=$t->get();
		$cart_details=$this->recipes_model->get_cart_menu_details();
		
		if($table_details['is_available']==0)
		{
			$table_order_details=$this->table_order_model->get_table_order('N',$_POST['tableid'],date('Y-m-d'));
			
			if(empty($table_order_details))
			{
				$to=$this->table_order_model;
				$to->table_orderno='';
				$to->table_id=$_POST['tableid'];
				$to->flag='N';
				$to->insert_date=date('Y-m-d');
				$to->insert_time=date('H:i:s');
				$to->restaurant_id=$_POST['rest_id'];
				$table_orders_id=$to->add();

				$restaurant_name=$restaurant['name'];
				$intial=strtoupper(substr($restaurant_name, 0, 2));
				$formated_id=str_pad($table_orders_id, 6, '0', STR_PAD_LEFT);

				$too=$this->table_order_model;
				$too->id=$table_orders_id;
				$too->table_orderno=$intial."T".$formated_id;
				$too->update();
			}
			else
			{
				$table_orders_id=$table_order_details['id'];
			}
		}
		else
		{
			$to=$this->table_order_model;
			$to->table_orderno='';
			$to->table_id=$_POST['tableid'];
			$to->flag='N';
			$to->insert_date=date('Y-m-d');
			$to->insert_time=date('H:i:s');
			$to->order_type='Website';
			$to->restaurant_id=$_POST['rest_id'];
			$table_orders_id=$to->add();
			
			$restaurant_name=$restaurant['name'];
			$intial=strtoupper(substr($restaurant_name, 0, 2));
			$formated_id=str_pad($table_orders_id, 6, '0', STR_PAD_LEFT);

			$too=$this->table_order_model;
			$too->id=$table_orders_id;
			$too->table_orderno=$intial."T".$formated_id;
			$too->update();
		}
		
		if($_POST['supply_option'] == 'Delivery'){
			$delivery_address = $_POST['delivery_address'];
			
			if($_POST['delivery_payment'] == 'COD'){
				$delivery_payment = 'Unpaid';
			}else{
				$delivery_payment = 'Paid';
			}
		}else{
			$delivery_address = 0;
			$delivery_payment = NULL;
		}
		
		if($_POST['customer_id']=="")
		{
			$_POST['customer_id']=0;
		}

		$o=$this->order_model;
		$o->customer_id=$_POST['customer_id'];
		$o->loyalty_points=$_POST['loyalty_points'];
		$o->sub_total=array_sum(array_column($cart_details,'subtotal'));
		$o->disc_total=0;
		$o->net_total=$_POST['net_total'];
		$o->suggetion=$_POST['suggetion'];
		$o->table_id=$_POST['tableid'];
		$o->status="New";
		$o->created_at=date('Y-m-d H:i:s');
		$o->rest_id=$_POST['rest_id'];
		$o->supply_option=$_POST['supply_option'];
		$o->delivery_payment=$delivery_payment;
		$o->customer_address_id=$delivery_address;
		$o->table_orders_id=$table_orders_id;
		$order_id=$o->add();
		
		foreach ($cart_details as $cart) 
		{
			$oi=$this->order_item_model;
			$oi->order_id=$order_id;
			$oi->recipe_id=$cart['options']['menu_id'];
			$oi->qty=$cart['qty'];
			$oi->price=$cart['price'];
			$oi->total=$cart['subtotal'];
			$oi->disc=0;
			$oi->disc_amt=0;
			$oi->special_notes = $cart['comment'];
			$oi->sub_total=$cart['subtotal'];
			$oi->add();

			$last_order_item_id = $this->db->insert_id();
			
			foreach($cart['addon'] as $key => $cart_addon){
				$this->customer_model->insert_query('order_addon_menu',['order_item_id'=>$last_order_item_id,'option_id'=>$cart_addon['addon_id']]);
			}
		}

		$restaurant_name=$restaurant['name'];
		$intial=strtoupper(substr($restaurant_name, 0, 2));
		$formated_id=str_pad($order_id, 8, '0', STR_PAD_LEFT);

		$o=$this->order_model;
		$o->id=$order_id;
		$o->order_no=$intial.$formated_id;
		$order=$o->update();
		
		
		/*$this->customer_model->block_unblock_customer($_POST['customer_id'],1);*/
		
		if($table_details['is_available']!=0)
		{
			$this->order_model->block_unblock_table($_POST['tableid'],0);
		}

		$this->session->unset_userdata('cart_contents');

		if($order_id)
		{
			$get_customer_details = $this->customer_model->select_where('customer',['id'=>$_POST['customer_id']]);
			$finalmail['final_mail'] = ['order_no'=>$intial."T".$formated_id,'restaurant_name'=>$restaurant_name,'cust_name'=>$get_customer_details[0]['name']];
			if($get_customer_details[0]['email'] != ''){
			$msg = $this->load->view('email_template/order_mail',$finalmail, true);
					$msg=$this->convert_to_utf8($msg);
				
					$to=$get_customer_details[0]['email'];
					$subject="Youcloud Order details";
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
			}
					
			
			
			$sql7 = "SELECT o.id, o.order_no,o.net_total,o.status,o.created_at,c.name,c.contact_no,o.table_id,o.table_orders_id,td.title,tblo.order_type,r.business_name FROM `orders` as o 
			LEFT JOIN customer as c on c.id = o.customer_id
			LEFT JOIN table_details as td on td.id = o.table_id
			INNER JOIN table_orders as tblo on tblo.id = o.table_orders_id
			LEFT JOIN user as r on r.id = o.rest_id
			WHERE o.id = ".$order_id." and o.status='New' and o.viewed=0 ORDER BY o.id desc ";
			$res= $this->order_model->query($sql7);
			
			$orderType = $res[0]['order_type'];
			$created_at = $res[0]['created_at'];
			$order_no = $res[0]['order_no'];
			$title = $res[0]['title'];
			$name = $res[0]['name'];
			$table_id = $_POST['tableid'];			
			$usertype=$restaurant['usertype'];
			$upline_id=$restaurant['upline_id'];
			
			$url ="https://mshastra.com/sendurlcomma.aspx?user=20100556&pwd=rbip6u&senderid=MOBSMS&CountryCode=91&mobileno=".$res[0]['contact_no']."&msgtext=Thank you for your order on ".$res[0]['business_name'].". Your order number is ".$intial.$formated_id." \nYouCloudResto";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$curl_scraped_page = curl_exec($ch);
			curl_close($ch);
			
			if($usertype=="Restaurant")
			{
				/* Restaurant manager */
				/* $token=array();					 */
					
				$sql_devicetoken = "SELECT * from users_devicetoken where userid = ".$_POST['rest_id'];
				$res_devicetoken= $this->order_model->query($sql_devicetoken);
				
				if(count($res_devicetoken)>1)
				{
					foreach ($res_devicetoken as $resdevicetoken) 
					{
						$this->order_model->send_notifiation($order_id,$table_id,$table_orders_id,$orderType,$title,$name,$order_no,$created_at,$resdevicetoken['devicetoken']);
					}
				}
				else
				{
					$token = $resdevicetoken[0]['devicetoken'];
					$this->order_model->send_notifiation($order_id,$table_id,$table_orders_id,$orderType,$title,$name,$order_no,$created_at,$token);
				}
			}
			else
			{
				$sql_devicetoken = "SELECT * from users_devicetoken where userid = ".$upline_id;
				$res_devicetoken= $this->order_model->query($sql_devicetoken);
				
				if(count($res_devicetoken)>1)
				{
					foreach ($res_devicetoken as $resdevicetoken) 
					{
						/* array_push($token,$resdevicetoken['devicetoken']); */
						$this->order_model->send_notifiation($order_id,$table_id,$table_orders_id,$orderType,$title,$name,$order_no,$created_at,$resdevicetoken['devicetoken']);						
					}
				}
				else
				{
					$token = $resdevicetoken[0]['devicetoken'];
					$this->order_model->send_notifiation($order_id,$table_id,$table_orders_id,$orderType,$title,$name,$order_no,$created_at,$token);
				}
			}
			
			/* save payment details */
			
			$this->db->insert('payment_details',$insertdata);
			
			$updatedata = [
				'is_available' => '1',
			];
			$this->db->where('id', $table_id);
			$this->db->update('table_details', $updatedata);
			
			$this->order_model->send_notifiation($order_id,$table_id,$table_orders_id,$orderType,$title,$name,$order_no,$created_at,$token);
			
			$this->session->unset_userdata('cart_contents');
			$this->json_output(array('status'=>true,'msg'=>'Order Placed Successfully.'));
		}
		else
		{
			$this->json_output(array('status'=>false,'msg'=>'Something went wrong please try again.'));
		}
	}

	public function add_delivery_address(){
		foreach($_POST as $x => $val) {
			$_POST[$x]=filter_var($_POST[$x], FILTER_SANITIZE_STRING);
		}
		
		$delivery_data=array('customer_id'=>$_POST['customer_id'],'delivery_area'=>$_POST['delivery_area'],'complete_address'=>$_POST['complete_address'],'delivery_instruction'=>$_POST['delivery_instruction'],'nickname'=>$_POST['nickname'],'name'=>$_POST['name'],'contact_number'=>$_POST['number']);
		$this->customer_model->insert_query('customer_address',$delivery_data);
		$this->json_output(array('status'=>true));
	}

	public function get_delivery_address(){
		$get_address=$this->customer_model->select_where('customer_address',['customer_id'=>$_POST['customer_id']]);
		$this->json_output($get_address);
	}

	public function show_perticular_address(){
		$get_address=$this->customer_model->select_where('customer_address',['id'=>$_POST['id']]);
		$this->json_output($get_address);
	}

	public function edit_perticular_delivery_address(){
		foreach($_POST as $x => $val) {
			$_POST[$x]=filter_var($_POST[$x], FILTER_SANITIZE_STRING);
		}
		$delivery_data=array('customer_id'=>$_POST['customer_id'],'delivery_area'=>$_POST['delivery_area'],'complete_address'=>$_POST['complete_address'],'delivery_instruction'=>$_POST['delivery_instruction'],'nickname'=>$_POST['nickname'],'name'=>$_POST['name'],'contact_number'=>$_POST['number']);
		
		$this->customer_model->updateactive_inactive('customer_address',['id'=>$_POST['edit_id']],$delivery_data);
		$this->json_output(array('status'=>true));
	}
	
	function get_time_zone($country)
	{
		$timezone1 = null;
		switch ($country) {
			case "India":
				$timezone1 = "Asia/Kolkata";
				break;
			case "INDIA":
				$timezone1 = "Asia/Kolkata";
				break;
			case "Dubai":
				$timezone1 = "Asia/Dubai";
				break;  
			case "USA":
				$timezone1 = "America/New_York";
				break; 
			case "USA":
				$timezone1 = "America/New_York";
				break; 
			case "Greece":
				$timezone1 = "Europe/Athens";
				break;			
			case "GREECE":
				$timezone1 = "Europe/Athens";
				break; 
			case "United Kingdom":
				$timezone1 = "Europe/London";
				break;  
			case "UK":
				$timezone1 = "Europe/London";
				break;        
		}
		return $timezone1;
	}
}
?>