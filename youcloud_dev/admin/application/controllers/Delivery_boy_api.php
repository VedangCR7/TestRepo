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
