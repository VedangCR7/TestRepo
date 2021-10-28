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
class Restaurant_managerorder extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->is_loggedin();
		$this->is_manager_delete();
		$this->load->library('cart');
		$this->load->model('restaurant_manager_order_model');
		$this->load->library("session");
       	$this->load->helper('url');
       	$this->load->model('user_model');	
		$this->load->model('main_menu_model');	
		$this->load->model('order_model');	
		$this->load->model('order_item_model');	
		$this->load->model('recipes_model');
		$this->load->model('customer_model');
		$this->load->model('table_order_model');
		$this->load->model('table_model');
	}

	public function list_edit_recipes(){
		$restaurant_id= $this->get_upline_id();
        $recipes=$this->restaurant_manager_order_model->list_recipes_typahead($restaurant_id);
        echo json_encode($recipes);
    }

	public function list_new_order(){
		if(isset($_POST['searchkey']))
			$manager=$this->restaurant_manager_order_model->list_manager($_POST['page'],$_POST['per_page'],$_POST['searchkey']);
		else
		$manager=$this->restaurant_manager_order_model->list_manager($_POST['page'],$_POST['per_page']);
		$this->json_output($manager);
	}

	public function take_order()
	{
		$upline_id = $this->get_upline_id();
		$data['restaurantsidebarshow'] =$this->restaurant_manager_order_model->select_where('restaurant_menu_authority',['restaurant_id'=>$upline_id]);
		$authority = explode(',',$data['restaurantsidebarshow'][0]['menu_name']);
		
		if(in_array('Table Management',$authority) && in_array('Order',$authority))
		{

			$query = "SELECT am.table_id AS table_detail_id,td.title
				FROM assign_table_for_manager AS am
				LEFT JOIN table_details as td on am.table_id = td.id
				LEFT JOIN table_category as tc on tc.id = td.table_category_id
				WHERE am.manager_id = ".$_SESSION['user_id']." AND  td.is_active=1 AND td.is_delete=0 AND tc.is_active=1 AND tc.is_delete=0 AND tc.flag=0 AND td.logged_user_id =".$upline_id;

			$check_restaurant_assign_table = $this->restaurant_manager_order_model->query($query);
			//print_r($check_restaurant_assign_table);exit();
			$data['table_number'] = [];
			if(!empty($check_restaurant_assign_table)){
				$sql = "SELECT am.table_id AS table_detail_id,td.title
				FROM assign_table_for_manager AS am
				LEFT JOIN table_details as td on am.table_id = td.id
				LEFT JOIN table_category as tc on tc.id = td.table_category_id
				WHERE am.manager_id = ".$_SESSION['user_id']." AND td.is_active=1 AND td.is_delete=0 AND tc.is_active=1 AND tc.is_delete=0 AND tc.flag=0 AND td.logged_user_id =".$upline_id;
				$data['table_number'] = $this->restaurant_manager_order_model->query($sql);
			}
			
			
			$sql1="SELECT profile_photo FROM user WHERE id =".$_SESSION['user_id'];
			$data['profile'] = $this->restaurant_manager_order_model->query($sql1);
			
			if ($this->uri->segment(3)) 
			{
				$data['customer_details'] = $this->restaurant_manager_order_model->select_where('customer',['id'=>$this->uri->segment(3)]);
			}
		}
		else
		{
			redirect(base_url('restaurant_managerorder/rest_manager_update_profile'));
		}
		

		$data['currency_symbol'] = $this->restaurant_manager_order_model->select_where('user',['id'=>$upline_id]);
		$this->load->view('Restaurantmanager/restaurant_take_order',$data);
	}

	public function gettable(){
		$upline_id = $this->get_upline_id();
		$query = "SELECT am.table_id AS table_detail_id,td.title
				FROM assign_table_for_manager AS am
				LEFT JOIN table_details as td on am.table_id = td.id
				LEFT JOIN table_category as tc on tc.id = td.table_category_id
				WHERE am.manager_id = ".$_SESSION['user_id']." AND  td.is_active=1 AND td.is_delete=0 AND tc.is_active=1 AND tc.is_delete=0 AND tc.flag=0 AND td.logged_user_id =".$upline_id;

			$check_restaurant_assign_table = $this->restaurant_manager_order_model->query($query);
			//print_r($check_restaurant_assign_table);exit();
			if(empty($check_restaurant_assign_table)){
				$data = [];
			}else{
				$sql = "SELECT am.table_id AS table_detail_id,td.title
				FROM assign_table_for_manager AS am
				LEFT JOIN table_details as td on am.table_id = td.id
				LEFT JOIN table_category as tc on tc.id = td.table_category_id
				WHERE am.manager_id = ".$_SESSION['user_id']." AND td.is_active=1 AND td.is_delete=0 AND tc.is_active=1 AND tc.is_delete=0 AND tc.flag=0 AND td.logged_user_id =".$upline_id;
				$data= $this->restaurant_manager_order_model->query($sql);
			}
			
		
		$this->json_output($data);
	}

	public function all_recipes(){
		//print_r($_POST);
		$upline_id = $this->get_upline_id();
		if ($_POST['tablecat_id'] != '') {
			$tbl_cat_id = $this->restaurant_manager_order_model->select_where('table_details',['id'=>$_POST['tablecat_id']])[0];
			$recipeall = $this->restaurant_manager_order_model->all_recipes_show_rest($upline_id,$tbl_cat_id['table_category_id']);
		}
		if ($_POST['tablecat_id'] != '' && $_POST['search_recipe'] != '') {
			$tbl_cat_id = $this->restaurant_manager_order_model->select_where('table_details',['id'=>$_POST['tablecat_id']])[0];
			$recipeall = $this->restaurant_manager_order_model->all_recipes_show_rest($upline_id,$tbl_cat_id['table_category_id'],$_POST['search_recipe']);
		}
		//print_r($recipe);
		$this->json_output($recipeall);
	}

	public function customer(){
		$upline_id = $this->get_upline_id();
		$check = $this->restaurant_manager_order_model->select_where('customer',['contact_no'=>$_POST['contact_no'],'restaurant_id'=>$upline_id]);
		if (empty($check)) {
			$this->json_output(['id'=>'','name'=>'']);
		}
		else{
			$this->json_output(['id'=>$check[0]['id'],'name' =>$check[0]['name']]);
		}
	}

	public function customer_update(){
		$this->restaurant_manager_order_model->updateactive_inactive('customer',['id'=>$_POST['id']],['name'=>$_POST['name']]);
		$this->json_output(['status'=>true]);
	}

	public function viewcart() 
	{
		$upline_id = $this->get_upline_id();
		$cust_id = $this->uri->segment(3);
		$data['get_cust'] = $this->restaurant_manager_order_model->select_where('customer',['id'=>$cust_id])[0];
		$sql1="SELECT profile_photo FROM user WHERE id =".$_SESSION['user_id'];
		$data['profile'] = $this->restaurant_manager_order_model->query($sql1);

		$data['currency_symbol'] = $this->restaurant_manager_order_model->select_where('user',['id'=>$upline_id]);

		$this->load->view('Restaurantmanager/cart_details',$data);
	}

	public function place_order()
	{
		$rest_id = $this->get_upline_id();
		$restaurant = $this->restaurant_manager_order_model->select_where('user',['id'=>$rest_id])[0];
		$check_customer = $this->customer_model->select_where('customer',['contact_no'=>$_POST['customer_contact'],'restaurant_id'=>$rest_id]);
		//print_r($check_customer);
		
		if (empty($check_customer)) 
		{
			$this->customer_model->add_user(['name'=>$_POST['customer_name'],'contact_no'=>$_POST['customer_contact'],'restaurant_id'=>$rest_id,'is_block'=>0]);
			$_POST['customer_id'] = $this->db->insert_id();
		}
		else
		{
			$_POST['customer_id'] = $check_customer[0]['id'];
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
			$to->restaurant_id=$rest_id;
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
		$o->status="Assigned To Kitchen";
		$o->order_by=$_SESSION['user_id'];
		$o->created_at=date('Y-m-d H:i:s');
		$o->rest_id=$rest_id;
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
			$this->session->unset_userdata('cart_contents');
			$visit_date =date('Y-m-d');
			$no_of_visits = 0;
			$no_of_visits=$this->restaurant_manager_order_model->select_where('get_restaurant_count',['restaurant_id'=>$rest_id,'visited_at'=>$visit_date]);
			$this->restaurant_manager_order_model->updateactive_inactive('customer',['id'=>$_POST['customer_id']],['name'=>$_POST['customer_name']]);
			
			if ($no_of_visits[0]['no_of_visits'] == '') 
			{
				$no_of_visits = 0;
				$no_of_visits = $no_of_visits+1;
				$this->restaurant_manager_order_model->insert_any_query('get_restaurant_count',['no_of_visits'=>$no_of_visits,'restaurant_id'=>$rest_id,'visited_at'=>$visit_date]);
			}
			else
			{
				$no_of_visits = $no_of_visits[0]['no_of_visits']+1;
				$this->restaurant_manager_order_model->updateactive_inactive('get_restaurant_count',['restaurant_id'=>$rest_id,'visited_at'=>$visit_date],['no_of_visits'=>$no_of_visits]);
			}
			
			$sql7 = "SELECT o.id, o.order_no,o.net_total,o.status,o.created_at,c.name,o.table_id,o.table_orders_id,td.title,tblo.order_type FROM `orders` as o 
			LEFT JOIN customer as c on c.id = o.customer_id
			LEFT JOIN table_details as td on td.id = o.table_id
			INNER JOIN table_orders as tblo on tblo.id = o.table_orders_id
			WHERE o.rest_id = ".$_SESSION['user_id']." AND o.id = ".$order_id." and o.status='New' and o.viewed=0 ORDER BY o.id desc ";
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
				
				$sql_devicetoken = "SELECT * from users_devicetoken where userid = ".$rest_id;
				$res_devicetoken= $this->order_model->query($sql_devicetoken);
				
				$token = "";
				
				if(!empty($res_devicetoken))
				{
					if(count($res_devicetoken[0])>1)
					{
						$token = $res_devicetoken[0]['devicetoken'];
					}
					else
					{
						$token = implode(",",$res_devicetoken[0]['devicetoken']);
					}
				}
			}
			else
			{
				$sql_devicetoken = "SELECT * from users_devicetoken where userid = ".$upline_id;
				$res_devicetoken= $this->order_model->query($sql_devicetoken);
				
				$token = "";
				
				if(!empty($res_devicetoken))
				{
					if(count($res_devicetoken)>1)
					{
						$token = $res_devicetoken;
					}
					else
					{
						$token = implode(",",$res_devicetoken);
					}
				}
			}
			
			/* $this->order_model->send_notifiation($order_id,$table_id,$table_orders_id,$orderType,$title,$name,$order_no,$created_at,$token); */
			$this->json_output(array('status'=>true,'msg'=>'Order Placed Successfully.','order_id'=>$order_id));
		}
		else
		{
			$this->json_output(array('status'=>false,'msg'=>'Something went wrong please try again.'));
		}
	}

	public function get_upline_id()
	{
		$upline_id = $this->restaurant_manager_order_model->select_where('user',['id'=>$_SESSION['user_id']])[0];
		return $upline_id['upline_id'];
	}

	public function order_history(){
		$upline_id = $this->get_upline_id();
		$data['restaurantsidebarshow'] =$this->restaurant_manager_order_model->select_where('restaurant_menu_authority',['restaurant_id'=>$upline_id]);
		$authority = explode(',',$data['restaurantsidebarshow'][0]['menu_name']);
		if(in_array('Table Management',$authority) && in_array('Order',$authority)){
		$sql1="SELECT profile_photo FROM user WHERE id =".$_SESSION['user_id'];
		$data['profile'] = $this->restaurant_manager_order_model->query($sql1);
		}
		else{
			redirect(base_url('restaurant_managerorder/rest_manager_update_profile'));
		}

		$data['currency_symbol'] = $this->restaurant_manager_order_model->select_where('user',['id'=>$upline_id]);
		
		$this->load->view('Restaurantmanager/order_history',$data);
	}

	public function daywise_order(){
		$upline_id = $this->get_upline_id();
		$from = $_POST['order_date'].' 00:00:00';
		$to = $_POST['order_date'].' 23:59:59';
		if ($_POST['table_no']!='' && $_POST['order_date']!='') {
			$sql= "SELECT o.*,c.name,c.contact_no,td.title
			FROM orders AS o
			LEFT JOIN customer AS c on c.id = o.customer_id
			LEFT JOIN table_details AS td on td.id = o.table_id
			WHERE o.rest_id = ".$upline_id." AND o.table_id=".$_POST['table_no']." AND  o.created_at >='".$from."' AND o.created_at <='".$to."' ORDER BY o.id DESC";
		}

		if ($_POST['order_status']!='' && $_POST['order_date']!='') {
			$sql= "SELECT o.*,c.name,c.contact_no,td.title
			FROM orders AS o
			LEFT JOIN customer AS c on c.id = o.customer_id
			LEFT JOIN table_details AS td on td.id = o.table_id
			WHERE o.rest_id = ".$upline_id." AND o.status='".$_POST['order_status']."' AND  o.created_at >='".$from."' AND o.created_at <='".$to."' ORDER BY o.id DESC";
		}

		if ($_POST['order_status']!='' && $_POST['order_date']!='' && $_POST['table_no']!='') {
			$sql= "SELECT o.*,c.name,c.contact_no,td.title
			FROM orders AS o
			LEFT JOIN customer AS c on c.id = o.customer_id
			LEFT JOIN table_details AS td on td.id = o.table_id
			WHERE o.rest_id = ".$upline_id." AND o.status='".$_POST['order_status']."' AND o.table_id=".$_POST['table_no']." AND  o.created_at >='".$from."' AND o.created_at <='".$to."' ORDER BY o.id DESC";
		}

		if ($_POST['order_date']!='' && $_POST['table_no'] == '' && $_POST['order_status'] == '') {
			$sql= "SELECT o.*,c.name,c.contact_no,td.title
			FROM orders AS o
			LEFT JOIN customer AS c on c.id = o.customer_id
			LEFT JOIN table_details AS td on td.id = o.table_id
			WHERE o.rest_id = ".$upline_id." AND o.created_at >='".$from."' AND o.created_at <='".$to."' ORDER BY o.id DESC";
		}
		$order = $this->restaurant_manager_order_model->query($sql);
		$this->json_output($order);
	}

	public function get_table_number(){
		$upline_id = $this->get_upline_id();
		$sql="SELECT td.id AS table_detail_id,td.title
		FROM table_details AS td
		LEFT JOIN table_category as tc on tc.id = td.table_category_id
		WHERE td.is_active=1 AND td.is_delete=0 AND tc.is_active=1 AND tc.is_delete=0 AND td.logged_user_id =".$upline_id;
		$table_number = $this->restaurant_manager_order_model->query($sql);
		$this->json_output($table_number);
	}

	public function get_view_orderdetails(){
		$order=$this->order_model->get_order_details($_POST['order_id']);
		$this->json_output($order);
	}

	public function edit_order(){
		$upline_id = $this->get_upline_id();
		$sql1="SELECT profile_photo FROM user WHERE id =".$_SESSION['user_id'];
		$data['profile'] = $this->restaurant_manager_order_model->query($sql1);
		$this->load->view('Restaurantmanager/edit_order',$data);
	}

	public function update_order(){
		//print_r($_POST);
		$this->db->trans_start();
		$total = $_POST['quantity'] * $_POST['price'];
		$this->restaurant_manager_order_model->updateactive_inactive('order_items',['id'=>$_POST['order_item_id']],['qty'=>$_POST['quantity'],'price'=>$_POST['price'],'total'=>$total,'sub_total'=>$total]);
		$getdata=$this->restaurant_manager_order_model->select_where('order_items',['order_id'=>$_POST['order_id']]);
		$ordertablesubtotal=0;
		foreach ($getdata as $key => $value) {
			$ordertablesubtotal = $ordertablesubtotal + $value['sub_total'];
		}
		$this->restaurant_manager_order_model->updateactive_inactive('orders',['id'=>$_POST['order_id']],['sub_total'=>$ordertablesubtotal,'net_total'=>$ordertablesubtotal]);
		//echo $ordertablesubtotal;

		$this->db->trans_complete();
		$this->json_output(['status'=>true]);
		// $getdata = $this->restaurant_manager_order_model->select_where('order_items',['order_id'=>$_POST['order_id']]);
		// print_r($getdata);
	}

	public function delete_order_item(){
		$this->db->trans_start();
		$countdata=$this->restaurant_manager_order_model->select_where('order_items',['order_id'=>$_POST['order_id']]);
		if (count($countdata) >1) {
			$this->restaurant_manager_order_model->permanent_delete_manager('order_items',['id'=>$_POST['order_item_id']]);
		}
		else{
			$this->json_output(['status'=>false,'msg'=>'At least one item required for order']);
			return false;
		}
		$getdata=$this->restaurant_manager_order_model->select_where('order_items',['order_id'=>$_POST['order_id']]);
		//print_r($getdata)
		$ordertablesubtotal=0;
		if(!empty($getdata)){
		foreach ($getdata as $key => $value) {
			$ordertablesubtotal = $ordertablesubtotal + $value['sub_total'];
		}
		$this->restaurant_manager_order_model->updateactive_inactive('orders',['id'=>$_POST['order_id']],['sub_total'=>$ordertablesubtotal,'net_total'=>$ordertablesubtotal]);
		}
		else{
			$this->restaurant_manager_order_model->updateactive_inactive('orders',['id'=>$_POST['order_id']],['sub_total'=>$ordertablesubtotal,'net_total'=>$ordertablesubtotal]);
		}

		$this->db->trans_complete();
		$this->json_output(['status'=>true]);
	}

	public function save_new_order(){
		$this->db->trans_start();
		$total=$_POST['qty']*$_POST['price'];
		$check_already_add = $this->restaurant_manager_order_model->select_where('order_items',['order_id'=>$_POST['order_id'],'recipe_id'=>$_POST['recipe_id']]);
		if (!empty($check_already_add)) {
			$this->db->trans_complete();
			$this->json_output(['status'=>false,'msg'=>'Menu already added']);
		}
		else{
			$this->restaurant_manager_order_model->insert_any_query('order_items',['order_id'=>$_POST['order_id'],'recipe_id'=>$_POST['recipe_id'],'qty'=>$_POST['qty'],'price'=>$_POST['price'],'total'=>$total,'disc'=>0,'disc_amt'=>0,'sub_total'=>$total]);
			$getdata=$this->restaurant_manager_order_model->select_where('order_items',['order_id'=>$_POST['order_id']]);
			$ordertablesubtotal=0;
			foreach ($getdata as $key => $value) {
				$ordertablesubtotal = $ordertablesubtotal + $value['sub_total'];
			}
			$this->restaurant_manager_order_model->updateactive_inactive('orders',['id'=>$_POST['order_id']],['sub_total'=>$ordertablesubtotal,'net_total'=>$ordertablesubtotal]);
			$this->db->trans_complete();
			$this->json_output(['status'=>true]);
		}
	}

	public function rest_manager_change_password(){
		$upline_id = $this->get_upline_id();
		$sql1="SELECT profile_photo FROM user WHERE id =".$_SESSION['user_id'];
		$data['profile'] = $this->restaurant_manager_order_model->query($sql1);
		$this->load->view('Restaurantmanager/changepassword',$data);
	}

	public function rest_manager_update_profile(){
		$data=array();
		$user_data=$this->user_model->get_user($_SESSION['user_id']);

		if($user_data['img_url']==""){
			$this->load->library('ciqrcode');
			$qr_image=rand().'.png';
			/*$params['data'] = $user_data['email']."_".$user_data['id'];
			$params['data'] = $user_data['name']."_".$user_data['id'];*/
			/* qr code name change by Ashwini */
			/* $params['data'] = "FOODNAI-".$user_data['id']; */
			$url=base_url();
			$new_url=str_replace('/admin', '', $url);
			
			$newparams = base64_encode($user_data['id']);
			$params['data'] = base_url()."qrcode/".$newparams;
			$params['level'] = 'H';
			$params['size'] = 8;
			$params['savename'] =FCPATH."uploads/qr_image/".$qr_image;
			if($this->ciqrcode->generate($params))
			{
				$img_name=$qr_image;	
				$user_data['img_url']="uploads/qr_image/".$qr_image;
			}

			$this->db->where('id',$_SESSION['user_id']);
        	$this->db->update('user',array('img_url'=>$user_data['img_url']));
		}

		$data['user']=$user_data;
		/*echo "<pre>";
		print_r($user_data);
		die;
*/		$data['usertype']=$_SESSION['usertype'];
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		$upline_id = $this->get_upline_id();
		$sql1="SELECT profile_photo FROM user WHERE id =".$_SESSION['user_id'];
		$data['profile'] = $this->restaurant_manager_order_model->query($sql1);
		$this->load->view('Restaurantmanager/changeprofile',$data);
	}

	public function save_product(){
		//print_r($_POST);
		$this->restaurant_manager_order_model->updateactive_inactive('orders',['id'=>$_POST['order_id']],['suggetion'=>$_POST['suggetion']]);
		$setdate = $this->restaurant_manager_order_model->select_where('orders',['id'=>$_POST['order_id']]);
		$orderdate = date('Y-m-d',strtotime($setdate[0]['created_at']));
		$orderstatus = $setdate[0]['status'];
		$this->json_output(['status'=>true,'date'=>$orderdate,'status'=>$orderstatus]);
		//base_url().'Restaurant_manager_order/order_history/'.$orderdate;
		//redirect('http://localhost/foodnai/Restaurant_manager_order/order_history/');
	}

	public function list_tablwise_orders(){
		//print_r($_POST);
		$upline_id = $this->get_upline_id();
		if($_POST['searchkey'] !='')
			$orders=$this->restaurant_manager_order_model->list_tablwise_orders($_POST['date'],$upline_id,$_POST['searchkey']);
		else
			$orders=$this->restaurant_manager_order_model->list_tablwise_orders($_POST['date'],$upline_id);
		$this->json_output($orders);
	}

	public function get_tableorder_details(){
		$upline_id = $this->get_upline_id();
		$orders=$this->restaurant_manager_order_model->get_table_orderdetails($_POST['table_order_id'],$upline_id);
		
		$this->json_output($orders);		
	}

	public function check_table_available(){
		$upline_id = $this->get_upline_id();
		$orders = $this->restaurant_manager_order_model->select_where('table_details',['is_available'=>1,'logged_user_id'=>$upline_id,'id'=>$_POST['table_no']]);
		if (!empty($orders)) {
			$this->json_output(['status'=>true,'available'=>true]);
		}
		else{
			$this->json_output(['status'=>true,'available'=>false]);
		}
	}

	public function unsetcartcontents(){
		$this->session->unset_userdata('cart_contents');
	}

	public function kot_status(){
		
		$this->restaurant_manager_order_model->updateactive_inactive('orders',['table_orders_id'=>$_POST['table_order_id']],['status'=>'Assigned To Kitchen']);
		$this->json_output(['status'=>true]);
	}

	
}
?>