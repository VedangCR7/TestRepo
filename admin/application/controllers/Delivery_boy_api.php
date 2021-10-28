<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
// Load Composer's autoloader
require 'vendor/autoload.php';
	class Delivery_boy_api extends MY_Controller{
		public function __construct() {
			parent::__construct();

			$this->load->model('Delivery_boy_api_model');
			$this->load->model('User_model');
			$this->load->model('Waiting_manager_model');
			
			$this->load->model('menu_group_model');
			$this->load->model('recipes_model');
			$this->load->model('order_model');
			$this->load->model('customer_model');
			$this->load->model('invoice_model');
			$this->load->model('table_order_model');
			$this->load->model('restaurant_manager_order_model');
			$this->load->model('table_model');
			$this->load->model('order_item_model');
			$this->load->model('main_menu_model');
			$this->load->model('invoice_payment_model');
			$this->load->model('Restaurant_manager_model');
		}

		public function deliveryboyLogin() {
			//print_r($_POST);exit();
			$rawData = file_get_contents("php://input");
			$rawData=json_decode($rawData,true);

			$query = $this->Delivery_boy_api_model->login($_POST);
			$this->json_output($query);
		}

		public function deliveryboyMyOrder(){
			$id=$_POST['deliveryboy_id'];
			$status = $_POST['filter_type'];
			$query = $this->Delivery_boy_api_model->getAllOrders($id,$status);
			$this->json_output($query);
		}
		
		public function rejected_order(){
			$id=$_POST['deliveryboy_id'];
			$query = $this->Delivery_boy_api_model->getAllOrdersrejected($id);
			$this->json_output($query);
		}

		public function updatedeliveryboylocation(){
			$deliveryboy_id = $_POST['deliveryboy_id'];
			$latitude = $_POST['latitude'];
			$longitude = $_POST['longitude'];
			if($this->Waiting_manager_model->updateactive_inactive('user',['id'=>$deliveryboy_id],['latitude'=>$latitude,'longitude'=>$longitude])){
				$data = ['metadata'=>["status"=> "1",
				"authrized_status"=> "1",
				"popuptext"=> "",
				"sql_error"=> null,
				"store_image"=> null,
				"updatelocation"=> null]];
				return $this->json_output($data);
			}else{
				$data = ['metadata'=>["status"=> "1",
				"authrized_status"=> "1",
				"popuptext"=> "",
				"sql_error"=> null,
				"store_image"=> null,
				"updatelocation"=> null]];
				return $this->json_output($data);
			}
		}

		public function DeliveryboyOrderProductList(){
			$delivetboy_id = $_POST['deliveryboy_id'];
			$order_id = $_POST['order_id'];
			$query = $this->Delivery_boy_api_model->getOrder($delivetboy_id, $order_id);
			return $this->json_output($query);
		}

		public function deliveryboyCompleteOrder(){
			$order_id = $_POST['order_id'];
			if($this->Waiting_manager_model->updateactive_inactive('orders',['id'=>$order_id],['status'=>'Completed','completed_at'=>date('Y-m-d H:i:s')])){
				$data = ['metadata'=>["status"=> "1",
    "authrized_status"=> "1",
    "popuptext"=> "Order Completed",
    "sql_error"=> null,
    "store_image"=> null]];
				$from='';
				$this->create_invoice($from,$order_id);
				return $this->json_output($data);
				
				
			}else{
				$data = ['metadata'=>["status"=> "1",
    "authrized_status"=> "1",
    "popuptext"=> "Something went wrong",
    "sql_error"=> null,
    "store_image"=> null]];
	return $this->json_output($data);
			}
			//$query = $this->Delivery_boy_api_model->completeOrder($order_id);	
			
		}
		
		public function create_invoice($from="",$order_id)
	{
		/*if(isset($_POST['order_id']))
		{
			$dis_total = $_POST['dis_total'];
			$discount_percentage = $_POST['dis_total_percentage'];
			$sub_total=$_POST['sub_total'];
			
			if($discount_percentage >0)
			{
				$discount_percentage_price = $sub_total*$discount_percentage/100;
			}
			else
			{
				$discount_percentage_price=0;
				$discount_percentage=0;
			}
            /* $discount_percentage_price=$discount_percentage_calculation; 
			/* $sub_total=$sub_total-$discount_percentage_price-$_POST['dis_total']; 
			$cgst = $_POST['sub_total']*$_POST['cgst_per']/100;
			$sgst = $_POST['sub_total']*$_POST['sgst_per']/100;
			$dis_total_percentage = $_POST['dis_total_percentage'];
			$nettotal = $_POST['sub_total']+$cgst+$sgst-$_POST['dis_total']-$discount_percentage_price;
			/* $net_total = $_POST['net_total']; 
			$net_total = $nettotal;
			
			$o=$this->order_model;
			$o->id=$_POST['order_id'];
			$o->sub_total=$_POST['sub_total'];
			$o->disc_total=$_POST['dis_total'];
			$o->net_total=$net_total;
			$o->cgst_per=$_POST['cgst_per'];
			$o->sgst_per=$_POST['sgst_per'];			
			$o->disc_percentage_total=$discount_percentage_price;
			if(isset($_POST['discount_note'])){
			$o->discount_note=$_POST['discount_note'];}
			$o->dis_total_percentage=$discount_percentage;
			$o->update();
		}
		*/
		$order=$this->table_order_model->get_tableorder_for_invoice($order_id);
		
		$i=$this->invoice_model;
		$i->invoice_no='';
		$i->status="Paid";
		$i->customer_id=$order['customer_id'];
		$i->table_id=$order['table_id'];
		$i->rest_id=$order['rest_id'];
		$i->loyalty_points=$order['loyalty_points'];
		$i->sub_total=$order['sub_total'];
		$i->disc_total=$order['disc_total'];
		$i->cgst_total=$order['cgst_per'];
		$i->sgst_total=$order['sgst_per'];
		$i->net_total=$order['net_total'];
		$i->suggetion=$order['suggetion'];
		$i->created_at=date('Y-m-d H:i:s');
		$i->table_order_id=$order['table_orders_id'];
		$i->disc_percentage_total=$order['disc_percentage_total'];
		$i->dis_total_percentage=$order['dis_total_percentage'];
		
		$invoice_id=$i->add();
		
		foreach ($order['items'] as $item) {

			$oi=$this->invoice_item_model;
			$oi->invoice_id=$invoice_id;
			$oi->recipe_id=$item['recipe_id'];
			$oi->qty=$item['qty'];
			$oi->price=$item['price'];
			$oi->sub_total=$item['total'];
			$oi->disc=$item['disc'];
			$oi->disc_amt=$item['disc_amt'];
			$oi->total=$item['total'];
			$oi->add();
		}

		$restaurant_name=$order['restaurant_name'];
		$intial=substr($restaurant_name, 0, 2);
		$formated_id=str_pad($invoice_id, 8, '0', STR_PAD_LEFT);

		$inv=$this->invoice_model;
		$inv->id=$invoice_id;
		$inv->invoice_no="IN".strtoupper($intial).$formated_id;
		$inv->update();

		
			$o=$this->order_model;
			$o->id=$order_id;
			$o->is_invoiced=1;
			$o->invoice_id=$invoice_id;
			$o->update();
		

		// $check_order_count = $this->Waiting_manager_model->select_where('orders',['table_orders_id'=>$order['table_orders_id']]);
		
		// $x=0;
		// foreach($check_order_count as $key => $value)
		// {
		// 	if(($value['status'] == 'Blocked' AND $value['is_invoiced'] == 0) || ($value['status'] == 'Canceled' AND $value['is_invoiced'] == 0) || $value['status'] == 'Completed' || ($value['status'] == 'Assigned To Kitchen' AND $value['is_invoiced'] == 1))
		// 	{
		// 		$x++;	
		// 	}
		// }
		// if(count($check_order_count) == $x){
		// 	$this->Waiting_manager_model->updateactive_inactive('table_details',['id'=>$check_order_count[0]['table_id']],['is_available'=>1]);
		// 	$this->Waiting_manager_model->updateactive_inactive('table_orders',['id'=>$check_order_count[0]['table_orders_id']],['flag'=>'Y']);
		// }

				
		$this->table_order_model->update_invoice_ids($order['table_orders_id'],$invoice_id);
		if($from=="")
			return $invoice_id;
			//$this->json_output(array('status'=>true,"msg"=>"Successfully saved.",'invoice_id'=>$invoice_id));
		else
			return $invoice_id;
	}
		
		public function deliveryboyAcceptOrder(){
			$order_id = $_POST['order_id'];
			$deliveryboy_id = $_POST['deliveryboy_id'];
			$status = $_POST['status'];
			if($status == 'To be picked up'){
				//$this->Waiting_manager_model->updateactive_inactive('assign_delivery_for_order',['order_id'=>$order_id,'delieverer_id'=>$deliveryboy_id],['is_accept'=>1]);
				$this->Waiting_manager_model->updateactive_inactive('orders',['id'=>$order_id],['status'=>$status]);
			}
			else if($status == 'Order transit'){
				$this->Waiting_manager_model->updateactive_inactive('orders',['id'=>$order_id],['status'=>$status,'picked_at'=>date('Y-m-d H:i:s')]);
			}
			else if($status == 'Reassign Delivery'){
				$this->Waiting_manager_model->updateactive_inactive('assign_delivery_for_order',['order_id'=>$order_id,'delieverer_id'=>$deliveryboy_id],['is_accept'=>1]);
				
				$this->Waiting_manager_model->updateactive_inactive('orders',['id'=>$order_id],['status'=>$status]);
			}
			else{
				$this->Waiting_manager_model->updateactive_inactive('orders',['id'=>$order_id],['status'=>$status]);
			}
			return $this->json_output(['status'=>1]);
			
		}

		public function resetPassword(){
			$rawData = file_get_contents("php://input");
			$rawData=json_decode($rawData,true);

			$query = $this->Delivery_boy_api_model->forgotPassword($rawData);

			if ($query) {
				return $this->json_output([
					"status" => "success",
					"message" => "Password changed successfully"
				]);
			}
			return $this->json_output([
				"statis" => "failed",
				"message" => "Password rest not successfull"
			]);
		}
		
		public function deliveryboyLogout(){
			$deliveryboy_id = $_POST['deliveryboy_id'];
			if($this->Waiting_manager_model->updateactive_inactive('users_devicetoken',['userid'=>$deliveryboy_id],['devicetoken'=>''])){
				$data = ['metadata'=>["status"=> "1",
				"authrized_status"=> "1",
				"popuptext"=> "",
				"sql_error"=> null,
				"store_image"=> null]];
				return $this->json_output($data);
			}else{
				$data = ['metadata'=>["status"=> "1",
				"authrized_status"=> "1",
				"popuptext"=> "",
				"sql_error"=> null,
				"store_image"=> null]];
				return $this->json_output($data);
			}
		}
		
		public function deliveryboyforgotPassword(){
			//ob_start();
				$data['user']= $this->Waiting_manager_model->select_where('user',['email'=>$_POST['email']]);
				//print_r($data);exit();
				if(!empty($data)){
					$msg = $this->load->view('email_template/password_send',$data, true);
					$msg=$this->convert_to_utf8($msg);
				
					$to=$_POST['email'];
					$subject="Youcloud Driver App Password";
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
					
					$data = ['metadata'=>["status"=> "1",
				"authrized_status"=> "1",
				"popuptext"=> "Send notification successfully",
				"sql_error"=> null,
				"store_image"=> null],
				'message'=>["title"=>"","message"=>"Password has been sent to your email."]];
				return $this->json_output($data);
				}
		}
		
		public function buyerNotification(){
			$sql = "SELECT o.*,c.*
			FROM orders as o 
			LEFT JOIN customer as c on c.id=o.customer_id
			WHERE o.id=".$_POST['order_id'];
			$data['notification']= $this->Waiting_manager_model->query($sql);
			$data['notification'][0]['notification_type'] = $_POST['notification_type'];
				//print_r($data);exit();
				$data['notification'][0]['email'];
				if(!empty($data)){
					$msg = $this->load->view('email_template/buyer_notification_mail',$data, true);
					$msg=$this->convert_to_utf8($msg);
				
					$to=$data['notification'][0]['email'];
					$subject="Youcloud Delivery";
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
					
					$data = ['metadata'=>["status"=> "1",
				"authrized_status"=> "1",
				"popuptext"=> "Send notification successfully",
				"sql_error"=> null,
				"store_image"=> null]];
				return $this->json_output($data);
					
				}
		}
	}


?>
