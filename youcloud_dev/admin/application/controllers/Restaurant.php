<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'third_party/aws/aws-autoloader.php';
use Aws\Common\Exception\MultipartUploadException;
use Aws\S3\MultipartUploader;
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
class Restaurant extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->is_loggedin();
		$this->load->model('menu_group_model');
		$this->load->model('recipes_model');
		$this->load->model('order_model');
		$this->load->model('customer_model');
		$this->load->model('invoice_model');
		$this->load->model('table_order_model');
		$this->load->model('waiting_manager_model');
		$this->load->model('restaurant_manager_order_model');
		$this->load->model('table_model');
		$this->load->model('order_item_model');
		$this->load->model('main_menu_model');
		$this->load->model('invoice_payment_model');
		$this->load->model('user_model');
		$this->load->model('Restaurant_manager_model');
        $this->load->library('cart');
		
	}

	public function inactiveoffers(){

		$all_offer = $this->customer_model->select_where('admin_offer',['restaurant_id'=>$_SESSION['user_id']]);
		foreach($all_offer as $key=>$value){
			if($value['end_date']<date('Y-m-d')){
				$this->customer_model->updateactive_inactive('admin_offer',['id'=>$value['id']],['status'=>0]);
			}
		}
	}

	public function downloadpdfinvoice(){
		$this->load->library('pdf');
		$data['invoice_details']=$this->invoice_model->get_invoice_details($this->uri->segment(3));
		//print_r($data['invoice_details']);exit();
		$html = $this->load->view('GeneratePdfView',$data, true);
        	$this->pdf->createPDF($html, 'mypdf');
	}

	public function alltakeorders(){
		$table_id = $this->uri->segment(3);
		$sql = "SELECT * FROM orders WHERE table_id=".$table_id." ORDER BY id DESC";
		$data['all_orders'] = $this->waiting_manager_model->query($sql);
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		$this->load->view('alltakeawayorders',$data);
	}
	public function deleteuser()
	{
		$check = $this->Waiting_manager_model->select_where('user',['id'=>$_SESSION['user_id']]);
		if (empty($check)) {
			$this->json_output(['status'=>true]);
		}
		else{
			$this->json_output(['status'=>false]);
		}
	}
	
	public function get_menu_id_for_addon(){
		//print_r($_POST);
		$recipes= $this->Waiting_manager_model->select_where('recipes',['is_delete'=>0,'group_id'=>$_POST['group_id'],'is_active'=>1,'is_recipe_active'=>1]);
		$this->json_output($recipes);
		
	}
	
	public function index() {
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		$this->load->view('home',$data);
	}
	public function updatevieworder(){
		if(isset($_POST['order_id']) && $_POST['order_id']!=''){
			$this->restaurant_manager_order_model->updateactive_inactive('orders',['id'=>$_POST['order_id']],['viewed'=>'1']);
			echo json_encode(array("success"=>true,"data"=>"success"));
			
		}else{
			echo json_encode(array("success"=>false,"data"=>""));
		}
		exit;
	}
	public function managetaxes(){
		$sql7 = "SELECT * FROM resto_tax_details WHERE resto_id = ".$_SESSION['user_id'];
		$res= $this->restaurant_manager_order_model->query($sql7);
		$this->load->view('managetaxes',$res);
	
	}
	public function getneworder(){
		$sql7 = "SELECT o.id, o.order_no,o.net_total,o.status,o.created_at,c.name,o.table_id,o.table_orders_id,td.title,tblo.order_type FROM `orders` as o 
		LEFT JOIN customer as c on c.id = o.customer_id
		LEFT JOIN table_details as td on td.id = o.table_id
		INNER JOIN table_orders as tblo on tblo.id = o.table_orders_id
		WHERE o.rest_id = ".$_SESSION['user_id']." and o.status='New' and o.viewed=0 ORDER BY o.id desc ";
		$res= $this->waiting_manager_model->query($sql7);
		if($res){
			echo json_encode(array("success"=>true,"data"=>$res));
		}else{
			echo json_encode(array("success"=>false,"data"=>""));
		}
		
		exit;
	}
	
	public  function dashboardnew()
	{
		$sql= "SELECT COUNT(id) as all_table FROM `table_details` WHERE logged_user_id =".$_SESSION['user_id']." AND is_active=1 AND is_delete = 0";
		$data['total_table'] = $this->waiting_manager_model->query($sql);
		
		$sql1= "SELECT COUNT(id) as available_table FROM `table_details` WHERE logged_user_id =".$_SESSION['user_id']." AND is_active=1 AND is_delete = 0 AND is_available = 1";
		$data['available_table'] = $this->waiting_manager_model->query($sql1);
		
		$sql2= "SELECT COUNT(id) as occupied_table FROM `table_details` WHERE logged_user_id =".$_SESSION['user_id']." AND is_active=1 AND is_delete = 0 AND is_available = 0";
		$data['occupied_table'] = $this->waiting_manager_model->query($sql2);
		
		$data['show_table'] = $this->waiting_manager_model->select_where('table_details',['logged_user_id'=>$_SESSION['user_id'],'is_active'=>1,'is_delete'=>0]);
		
		$sql3= "SELECT SUM(sub_total) as total_sell FROM `orders` WHERE status ='Completed' AND rest_id =".$_SESSION['user_id'];
		$data['total_sell'] = $this->waiting_manager_model->query($sql3);
		
		$data['ttlvisited_users_count'] = $this->recipes_model->ttlvisited_users_count();
		
		$data['visited_users_count'] = $this->recipes_model->visited_users_count();
		
		$sql4 = "SELECT count(id) as total_orders FROM `orders` WHERE rest_id = ".$_SESSION['user_id'];
		$data['total_orders'] = $this->waiting_manager_model->query($sql4);
		
		$sql6 = "SELECT count(o.recipe_id) as recipe_count,sum(o.sub_total) as income,r.* 
			FROM `order_items` as o 
			left join recipes as r on r.id = o.recipe_id 
			left join orders as ord on ord.id = o.order_id 
			WHERE ord.rest_id = ".$_SESSION['user_id']." 
			group by o.recipe_id order by count(o.recipe_id) DESC limit 4";
		$data['trending_offers'] = $this->waiting_manager_model->query($sql6);
		
		/*$sql7 = "SELECT o.order_no,o.net_total,o.status,o.created_at,c.name,td.title,tor.order_type,tor.table_id, tor.id FROM `orders` as o 
		LEFT JOIN table_orders as tor on tor.id=o.table_orders_id 
		LEFT JOIN customer as c on c.id = o.customer_id 
		LEFT JOIN table_details as td on td.id = o.table_id 
		WHERE o.rest_id = ".$_SESSION['user_id']." ORDER BY o.id DESC LIMIT 6";*/
		$sql7 = "SELECT o.order_no,o.net_total,o.status,o.created_at,c.name,td.title,tor.order_type,tor.table_id, tor.id FROM `orders` as o 
		LEFT JOIN table_orders as tor on tor.id=o.table_orders_id 
		LEFT JOIN customer as c on c.id = o.customer_id 
		LEFT JOIN table_details as td on td.id = o.table_id 
		WHERE o.rest_id = ".$_SESSION['user_id']." ORDER BY o.id DESC LIMIT 6";
		$data['five_order'] = $this->waiting_manager_model->query($sql7);
		$data['recently_added']=$this->recipes_model->list_recently_added_recipes();
		$data['visited_recipes']=$this->recipes_model->list_most_visited_recipes();
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		$this->load->view('restaurant_new_dashboard_new',$data);
	}
	
	public  function dashboard($tblType="")
	{
		$data['currency_symbol'] = $this->customer_model->select_where('user',['id'=>$_SESSION['user_id']]);

		$current_date = date('Y-m-d');
		
		$sql= "SELECT COUNT(table_details.id) as all_table FROM `table_details`,table_category WHERE table_category.id=table_details.table_category_id AND table_details.logged_user_id =".$_SESSION['user_id']." AND table_details.is_active=1 AND table_details.is_delete = 0 AND table_category.flag = 0 AND table_category.is_active=1";
		$data['total_table'] = $this->waiting_manager_model->query($sql);
		
		$sql1= "SELECT COUNT(table_details.id) as available_table FROM `table_details` ,table_category WHERE table_category.id=table_details.table_category_id AND table_details.logged_user_id =".$_SESSION['user_id']." AND table_details.is_active=1 AND table_details.is_delete = 0 AND table_details.is_available = 1 AND table_category.flag=0 AND table_category.is_active=1";
		$data['available_table'] = $this->waiting_manager_model->query($sql1);
		
		/* $sql2= "SELECT COUNT(td.id) as occupied_table  FROM table_details WHERE logged_user_id =".$_SESSION['user_id']." AND is_active=1 AND is_delete = 0 AND is_available = 0"; */
		$sql2= "SELECT * FROM table_details td, table_orders tos, table_category tc WHERE td.id = tos.table_id AND tc.id=td.table_category_id AND td.logged_user_id =".$_SESSION['user_id']." AND td.is_active=1 AND td.is_delete = 0 AND td.is_available = 0 AND tos.order_type='Billing' AND tos.flag='N' AND tc.flag=0 AND tc.is_active=1 AND tos.insert_date='$current_date' group by tos.table_id";
		$occupied_cnt = $this->waiting_manager_model->query($sql2);
		/* $data['occupied_table'] = $this->waiting_manager_model->query($sql2); */
		$data['occupied_table'] = array("occupied_table"=>count($occupied_cnt));
		
		$sql5= "SELECT * FROM table_details td, table_orders tos, table_category tc WHERE td.id = tos.table_id AND tc.id=td.table_category_id AND td.logged_user_id =".$_SESSION['user_id']." AND td.is_active=1 AND td.is_delete = 0 AND td.is_available = 0 AND tos.order_type='Online' AND tos.flag='N' AND tc.flag=0 AND tc.is_active=1 AND tos.insert_date='$current_date' group by tos.table_id";
		$occupied_cnt1 = $this->waiting_manager_model->query($sql5);
		
		/* $data['occupied_table1'] = $this->waiting_manager_model->query($sql5); */
		$data['occupied_table1'] = array("occupied_table"=>count($occupied_cnt1));
		//echo $tblType;exit();
		if($tblType!="")
		{
			if($tblType=="available")
			{
				/* $sql8= "SELECT table_details.id, table_details.title, table_details.table_category_id, table_details.is_available, table_orders.order_type,table_orders.id as tableId FROM table_details
					LEFT JOIN table_orders on table_details.id = table_orders.table_id AND table_orders.flag='N' AND insert_date='$current_date'
					INNER JOIN table_category on table_details.table_category_id = table_category.id AND table_category.flag=0 AND table_category.is_active=1 AND table_category.is_delete=0
					WHERE table_details.logged_user_id =".$_SESSION['user_id']." AND table_details.is_active=1 AND table_details.is_delete = 0 AND table_details.is_available = 1"; */
				
				$sql8="SELECT td.id,td.title,td.table_category_id,td.is_available,td.id as tableId
					FROM table_details AS td LEFT JOIN table_category as tc on tc.id = td.table_category_id
					WHERE td.is_active=1 AND td.is_delete=0 AND tc.is_active=1 AND tc.is_delete=0 AND tc.flag=0 AND td.is_available=1 AND td.logged_user_id =".$_SESSION['user_id'];
			}
			else if($tblType=="occupied")
			{
				/* $sql8= "SELECT table_details.id, table_details.title, table_details.table_category_id, table_details.is_available, table_orders.order_type,table_orders.id as tableId FROM table_details
					LEFT JOIN table_orders on table_details.id = table_orders.table_id AND table_orders.flag='N' AND insert_date='$current_date'
					INNER JOIN table_category on table_details.table_category_id = table_category.id AND table_category.flag=0 AND table_category.is_active=1 AND table_category.is_delete=0
					WHERE table_details.logged_user_id =".$_SESSION['user_id']." AND table_details.is_active=1 AND table_details.is_delete = 0 AND table_details.is_available = 0 AND table_orders.order_type='Billing'"; */
					
				$sql8="SELECT td.id,td.title,td.table_category_id,td.is_available,td.id as tableId
					FROM table_details AS td LEFT JOIN table_category as tc on tc.id = td.table_category_id
					WHERE td.is_active=1 AND td.is_delete=0 AND tc.is_active=1 AND tc.is_delete=0 AND tc.flag=0 AND td.logged_user_id =".$_SESSION['user_id'];
			}
			else if($tblType=="online")
			{
				/* $sql8= "SELECT table_details.id, table_details.title, table_details.table_category_id, table_details.is_available, table_orders.order_type,table_orders.id as tableId FROM table_details
					LEFT JOIN table_orders on table_details.id = table_orders.table_id AND table_orders.flag='N' AND insert_date='$current_date'
					INNER JOIN table_category on table_details.table_category_id = table_category.id AND table_category.flag=0 AND table_category.is_active=1 AND table_category.is_delete=0
					WHERE table_details.logged_user_id =".$_SESSION['user_id']." AND table_details.is_active=1 AND table_details.is_delete = 0 AND table_details.is_available = 0 AND table_orders.order_type='Online'"; */
			
				$sql8="SELECT td.id,td.title,td.table_category_id,td.is_available,td.id as tableId
					FROM table_details AS td LEFT JOIN table_category as tc on tc.id = td.table_category_id
					WHERE td.is_active=1 AND td.is_delete=0 AND tc.is_active=1 AND tc.is_delete=0 AND tc.flag=0 AND td.logged_user_id =".$_SESSION['user_id'];
			}
			else
			{
				/* $sql8= "SELECT table_details.id, table_details.title, table_details.table_category_id, table_details.is_available, table_orders.order_type,table_orders.id as tableId FROM table_details
				LEFT JOIN table_orders on table_details.id = table_orders.table_id AND table_orders.flag='N' AND insert_date='$current_date'
				INNER JOIN table_category on table_details.table_category_id = table_category.id AND table_category.flag=0 AND table_category.is_active=1 AND table_category.is_delete=0
				WHERE table_details.logged_user_id =".$_SESSION['user_id']." AND table_details.is_active=1 AND table_details.is_delete = 0"; */
				$sql8="SELECT td.id,td.title,td.table_category_id,td.is_available,td.id as tableId
					FROM table_details AS td LEFT JOIN table_category as tc on tc.id = td.table_category_id
					WHERE td.is_active=1 AND td.is_delete=0 AND tc.is_active=1 AND tc.is_delete=0 AND tc.flag=0 AND td.logged_user_id =".$_SESSION['user_id'];
			}
		}
		else
		{
			/* $sql8= "SELECT table_details.id, table_details.title, table_details.table_category_id, table_details.is_available, table_orders.order_type,table_orders.id as tableId FROM table_details
				LEFT JOIN table_orders on table_details.id = table_orders.table_id AND table_orders.flag='N' AND insert_date='$current_date'
				INNER JOIN table_category on table_details.table_category_id = table_category.id AND table_category.flag=0 AND table_category.is_active=1 AND table_category.is_delete=0
				WHERE table_details.logged_user_id =".$_SESSION['user_id']." AND table_details.is_active=1 AND table_details.is_delete = 0"; */
			$sql8="SELECT td.id,td.title,td.table_category_id,td.is_available,td.id as tableId
				FROM table_details AS td LEFT JOIN table_category as tc on tc.id = td.table_category_id
				WHERE td.is_active=1 AND td.is_delete=0 AND tc.is_active=1 AND tc.is_delete=0 AND tc.flag=0 AND td.logged_user_id =".$_SESSION['user_id'];
		}
		
		$occupied_cnt18 = $this->waiting_manager_model->query($sql8);
				
		/* $data['show_table'] = $this->waiting_manager_model->select_where('table_details',['logged_user_id'=>$_SESSION['user_id'],'is_active'=>1,'is_delete'=>0]); */
		$table_details = $this->waiting_manager_model->query($sql8);
		
		if(!empty($occupied_cnt18))
		{
			foreach ($table_details as $table) 
			{
				if($tblType=="occupied")
				{
					$quyer="SELECT * FROM table_orders WHERE order_type='Billing' AND flag='N' AND insert_date='$current_date' AND table_id =".$table['id'];
					$result = $this->waiting_manager_model->query($quyer);
					/* var_dump($result);echo '<br>'; */
					if(count($result)>0)
					{
						$table_order_details=$this->table_order_model->get_current_tableorder('N',$table['id'],date('Y-m-d'));
						$table['table_order']=$table_order_details;

						$data['show_table'][]=$table;
					}
				}
				else if($tblType=="online")
				{
					$quyer="SELECT * FROM table_orders WHERE order_type='Online' AND flag='N' AND insert_date='$current_date' AND table_id =".$table['id'];
					$result = $this->waiting_manager_model->query($quyer);
					
					if(count($result)>0)
					{
						$table_order_details=$this->table_order_model->get_current_tableorder('N',$table['id'],date('Y-m-d'));
						$table['table_order']=$table_order_details;

						$data['show_table'][]=$table;
					}
				}
				else
				{
					$table_order_details=$this->table_order_model->get_current_tableorder('N',$table['id'],date('Y-m-d'));
					$table['table_order']=$table_order_details;

					$data['show_table'][]=$table;
				}
			}
		}
		else
		{
			$data['show_table']="";
		}
		//echo json_encode($data['show_table']);exit;
		//var_dump($data['show_table']);exit;

		$sql3= "SELECT ifnull(SUM(net_total),0) as total_sell FROM `orders` WHERE status ='Completed' AND rest_id =".$_SESSION['user_id'];
		$data['total_sell'] = $this->waiting_manager_model->query($sql3);
		
		$data['ttlvisited_users_count'] = $this->recipes_model->ttlvisited_users_count();
		
		$data['visited_users_count'] = $this->recipes_model->visited_users_count();
		
		$sql4 = "SELECT count(id) as total_orders FROM `orders` WHERE rest_id = ".$_SESSION['user_id'];
		$data['total_orders'] = $this->waiting_manager_model->query($sql4);
		$from_date = date('Y-m')."-01 00:00:00";
		$to_date = date('Y-m')."-30 00:00:00";
		$trending_offers_condition = " AND (o.created_at>='".$from_date."' AND o.created_at<='".$to_date."')";
		$sql6 = "SELECT count(o.recipe_id) as recipe_count,sum(o.sub_total) as income,r.* 
		FROM `order_items` as o 
		left join recipes as r on r.id = o.recipe_id 
		left join orders as ord on ord.id = o.order_id 
		WHERE ord.rest_id = ".$_SESSION['user_id'].$trending_offers_condition." group by o.recipe_id order by count(o.recipe_id) DESC limit 4";
		$data['trending_offers'] = $this->waiting_manager_model->query($sql6);
		//print_r($data['trending_offers']);exit();
		$sql7 = "SELECT o.id as order_id_for_new_order,o.order_no,o.net_total,o.status,o.created_at,c.name,td.title,tor.order_type,tor.table_id, tor.id,o.invoice_id,o.is_invoiced,o.order_by,u.name as order_by_name FROM `orders` as o 
		LEFT JOIN table_orders as tor on tor.id=o.table_orders_id 
		LEFT JOIN customer as c on c.id = o.customer_id 
		LEFT JOIN table_details as td on td.id = o.table_id
		LEFT JOIN user as u on o.order_by = u.id
		WHERE o.rest_id = ".$_SESSION['user_id']." ORDER BY o.id DESC LIMIT 6";
		$data['five_order'] = $this->waiting_manager_model->query($sql7);
		$data['recently_added']=$this->recipes_model->list_recently_added_recipes();
		$data['visited_recipes']=$this->recipes_model->list_most_visited_recipes();
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		
		$this->load->view('restaurant_new_dashboard',$data);
	}

	public function monthly_erning()
	{
		$data['chartdata'] = [];
		
		for ($k=0; $k < 11; $k++) 
		{ 
			$from_date= $_POST['year']."-".($k+1)."-01";
			$lastday = date('t',strtotime($from_date));
			
			$last_date= $_POST['year']."-".($k+1)."-".$lastday;
			
			$sql = "SELECT ifnull(SUM(net_total),0) as earning FROM orders WHERE rest_id = ".$_SESSION['user_id']." AND created_at >= '".$from_date." 00:00:00' AND created_at <= '".$last_date." 23:59:59' AND status = 'Completed'";
			$chartdata = $this->waiting_manager_model->query($sql);
			
			if($chartdata)
			{
				$data['chartdata'][$k] = round($chartdata[0]['earning']);
			}
			else
			{
				$data['chartdata'][$k] = 0;
			}			
			array_push($data['chartdata'],$data['chartdata'][$k]);
		}
		$this->json_output($data['chartdata']);
	}

	public function monthly_cust()
	{
		$data['chartdata'] = [];
		
		for ($k=0; $k < 11; $k++) 
		{ 
			$from_date= $_POST['year']."-".($k+1)."-01";
			$lastday = date('t',strtotime($from_date));
			
			$last_date= $_POST['year']."-".($k+1)."-".$lastday;

			$sql = "SELECT ifnull(count(id),0) as custcount FROM get_restaurant_count WHERE restaurant_id = ".$_SESSION['user_id']." AND visited_at >= '".$from_date."' AND visited_at <= '".$last_date."'";
			$chartdata = $this->waiting_manager_model->query($sql);
			$data['chartdata'][$k] = round($chartdata[0]['custcount']);
			array_push($data['chartdata'],$data['chartdata'][$k]);
		}
		$this->json_output($data['chartdata']);
	}

	public function printbill($invoice_id)
	{
		$data=array();
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		$data['invoice']=$this->invoice_model->get_invoice_details($invoice_id);
		if($_SESSION['usertype'] == 'Restaurant manager'){
			$user = $this->customer_model->select_where('user',['id'=>$_SESSION['user_id']]);
			$data['currency_symbol'] = $this->customer_model->select_where('user',['id'=>$user[0]['upline_id']]);
			// print_r($data['currency_symbol']);exit();
		}else{
			$data['currency_symbol'] = $this->customer_model->select_where('user',['id'=>$_SESSION['user_id']]);
		}
		
		$this->load->view('print_bill',$data);
	}

	public function printbillkot($orderid)
	{
		$order_id = $this->uri->segment(3);
		$data=array();
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		$data['invoice']=$this->invoice_model->get_kot_print($order_id);
		//echo "<pre>";
		//print_r($data['invoice']);exit();
		$data['currency_symbol'] = $this->customer_model->select_where('user',['id'=>$_SESSION['user_id']]);
		$this->load->view('print_bill_kot',$data);
	}

	public  function menu_group()
	{
		$data=array();
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		$this->load->view('menu_group_list',$data);
	}

	public function customers(){
		$data=array();
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		$this->load->view('customer_list',$data);
	}

	public function list_customers()
	{
		$restaurant_id = $_SESSION['user_id'];
		//print_r($restaurnat_id);
		if(isset($_POST['searchkey']))
			$customers=$this->customer_model->list_customers($_POST['page'],$_POST['per_page'],$restaurant_id,$_POST['searchkey']);
		else
			$customers=$this->customer_model->list_customers($_POST['page'],$_POST['per_page'],$restaurant_id);

		$this->json_output($customers);
	}

	public function save_customers()
	{
		$user_details=$this->customer_model->check_user($_POST['contact_no']);
		
		if (!empty($user_details)) 
		{
			$this->json_output(array('status'=>true,'is_email_exist'=>true));
			return;
		}
		else
		{
			foreach($_POST as $x => $val) {
				$_POST[$x]=filter_var($_POST[$x], FILTER_SANITIZE_STRING);
			}
			$_POST['is_block'] = 0;
			$_POST['restaurant_id'] = $_SESSION['user_id'];
			
			if($this->customer_model->add_user($_POST))
			{
				$this->json_output(array('status'=>true));
				return;
			}
			else
			{
				$this->json_output(array('status'=>false));
			}
		}
	}

	public function show_perticular_customer()
	{
		$individual_manager = $this->customer_model->select_where('customer',['id'=>$_POST['id']])[0];
		$this->json_output($individual_manager);
	}

	public function edit_perticular_customer()
	{
		$sql = "SELECT * FROM customer WHERE id !=".$_POST['id']." AND contact_no =".$_POST['contact_number']." AND restaurant_id=".$_SESSION['user_id'];
		$check = $this->customer_model->query($sql);
		
		if (empty($check)) 
		{
			foreach($_POST as $x => $val) {
				$_POST[$x]=filter_var($_POST[$x], FILTER_SANITIZE_STRING);
			}
			if($this->customer_model->updateactive_inactive('customer',['id'=>$_POST['id']],['name'=>$_POST['name'],'contact_no'=>$_POST['contact_number']]))
			{
				$this->json_output(array('status'=>true));
			}
			else
			{
				$this->json_output(array('status'=>false));
			}
		}
		else 
		{
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

	public  function onlineorders()
	{
		$data=array('order_type'=>'online');
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();

		$data['currency_symbol'] = $this->customer_model->select_where('user',['id'=>$_SESSION['user_id']]);

		$this->load->view('neworder',$data);
	}

	public  function orders()
	{
		$data=array(
			'total_orders'=>$this->order_model->total_order_count($_SESSION['user_id']),
			'pending'=>$this->order_model->total_order_count($_SESSION['user_id'],'New'),
			'assigned'=>$this->order_model->total_order_count($_SESSION['user_id'],'Assigned To Kitchen'),
			'Completed'=>$this->order_model->total_order_count($_SESSION['user_id'],'Completed'),
			'food_serve'=>$this->order_model->total_order_count($_SESSION['user_id'],'Food Served')
		);
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		
		$this->load->view('orders_dashaboard',$data);
	}

	public function weborders(){
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		
		$this->load->view('web_orders',$data);
	}

	public function list_recipes($tablecategory="")
	{
		if($tablecategory=="")
			$recipes=$this->recipes_model->list_recipes_typahead();
		else
			$recipes=$this->recipes_model->list_recipes_typahead($tablecategory);

		echo json_encode($recipes);
	}

	public  function edit_order($order_id)
	{
		$data=array(
			'order_id'=>$order_id
		);
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		$this->load->view('edit_order',$data);
	}

	public function list_restaurant_orders()
	{
		if(isset($_POST['searchkey']))
			$orders=$this->order_model->all_orders($_POST['page'],$_POST['per_page'],$_POST['status'],$_POST['order_date'],$_POST['searchkey']);
		else
			$orders=$this->order_model->all_orders($_POST['page'],$_POST['per_page'],$_POST['status'],$_POST['order_date']);
		
		$this->json_output($orders);	
	}

	public function list_restaurant_orders1()
	{
		if(isset($_POST['searchkey']))
			$orders=$this->order_model->all_orders1($_POST['page'],$_POST['per_page'],$_POST['status'],$_POST['order_date']="",$_POST['searchkey']);
		else
			$orders=$this->order_model->all_orders1($_POST['page'],$_POST['per_page'],$_POST['status'],$_POST['order_date']="");
		
		$this->json_output($orders);	
	}

	public function list_tablwise_orders()
	{
		if(isset($_POST['searchkey']))
			$orders=$this->order_model->list_tablwise_orders($_POST['page'],$_POST['per_page'],$_POST['status'],$_POST['order_date'],$_POST['searchkey']);
		else
			$orders=$this->order_model->list_tablwise_orders($_POST['page'],$_POST['per_page'],$_POST['status'],$_POST['order_date']);

		$this->json_output($orders);		
	}
	
	public function list_tablwise_orders1()
	{
		if(isset($_POST['searchkey']))
			$orders=$this->order_model->list_tablwise_orders1($_POST['page'],$_POST['per_page'],$_POST['status'],$_POST['order_date']='',$_POST['searchkey']);
		else
			$orders=$this->order_model->list_tablwise_orders1($_POST['page'],$_POST['per_page'],$_POST['status'],$_POST['order_date']='');

		$this->json_output($orders);		
	}

	// public function list_tablwise_orders1()
	// {
	// 	if(isset($_POST['searchkey']))
	// 		$orders=$this->order_model->list_tablwise_orders1($_POST['page'],$_POST['per_page'],$_POST['status'],$_POST['order_date']='',$_POST['searchkey']);
	// 	else
	// 		$orders=$this->order_model->list_tablwise_orders1($_POST['page'],$_POST['per_page'],$_POST['status'],$_POST['order_date']='');

	// 	$this->json_output($orders);		
	// }

	public function list_tablwise_orders_website()
	{
		if(isset($_POST['searchkey']))
			$orders=$this->order_model->list_tablwise_orders_website($_POST['page'],$_POST['per_page'],$_POST['order_date'],$_POST['searchkey']);
		else
			$orders=$this->order_model->list_tablwise_orders_website($_POST['page'],$_POST['per_page'],$_POST['order_date']);

		$this->json_output($orders);		
	}

	public function get_tableorder_details()
	{
		if(isset($_POST['searchkey']))
			$orders=$this->order_model->get_table_orderdetails($_POST['table_order_id']);
		else
			$orders=$this->order_model->get_table_orderdetails($_POST['table_order_id']);
		
		$this->json_output($orders);		
	}

	public function create_invoice($from="")
	{
		if(isset($_POST['order_id']))
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
            /* $discount_percentage_price=$discount_percentage_calculation; */
			/* $sub_total=$sub_total-$discount_percentage_price-$_POST['dis_total']; */
			$cgst = $_POST['sub_total']*$_POST['cgst_per']/100;
			$sgst = $_POST['sub_total']*$_POST['sgst_per']/100;
			$dis_total_percentage = $_POST['dis_total_percentage'];
			$nettotal = $_POST['sub_total']+$cgst+$sgst-$_POST['dis_total']-$discount_percentage_price;
			/* $net_total = $_POST['net_total']; */
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
		
		$order=$this->table_order_model->get_tableorder_for_invoice($_POST['ids']);

		$i=$this->invoice_model;
		$i->invoice_no='';
		$i->status="Unpaid";
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
		$i->table_order_id=$_POST['table_order_id'];
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

		foreach ($_POST['ids'] as $id){
			$o=$this->order_model;
			$o->id=$id;
			$o->is_invoiced=1;
			$o->invoice_id=$invoice_id;
			$o->update();
		}

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

				
		$this->table_order_model->update_invoice_ids($_POST['table_order_id'],$invoice_id);
		if($from=="")
			$this->json_output(array('status'=>true,"msg"=>"Successfully saved.",'invoice_id'=>$invoice_id));
		else
			return $invoice_id;
	}

	public function update_order_total($order_id,$dis_total,$cgst_per,$sgst_per,$dis_total_percentage)
	{
		$getdata=$this->restaurant_manager_order_model->select_where('order_items',['order_id'=>$order_id]);
		$ordertablesubtotal=0;
		
		foreach ($getdata as $key => $value) 
		{
			$ordertablesubtotal = $ordertablesubtotal + $value['sub_total'];
		}
		
		if($dis_total_percentage=="")
		{
            $discount_percentage_price=0;
		}
		else
		{
			$discount_percentage = $dis_total_percentage;
			$discount_percentage_calculation = $ordertablesubtotal*$discount_percentage/100;
            $discount_percentage_price=number_format($discount_percentage_calculation,2);
		}
		
		$subTotal = $ordertablesubtotal-$dis_total-$discount_percentage_price;
		$net_total1=$ordertablesubtotal-$dis_total-$discount_percentage_price;
		
		$cgst_per_price = ($subTotal*$cgst_per)/100;
		$sgst_per_price = ($subTotal*$sgst_per)/100;
		$net_total = $subTotal + $cgst_per_price + $sgst_per_price;
		
		/* if($cgst_per!="")
			$cgst_per_price=$net_total*$cgst_per/100;
			
		if($sgst_per!="")
			$sgst_per_price=$net_total*$sgst_per/100;
			
		$net_total = $net_total + $cgst_per_price + $sgst_per_price; */
		
		/* if($dis_total!="")
		{
			$net_total=$net_total-$dis_total;
		} */	
		
		/* if($cgst_per!="")
			$net_total=$net_total+$cgst_per;
		if($sgst_per!="")
			$net_total=$net_total+$sgst_per;
		if($dis_total!=""){
			$net_total=$net_total-$dis_total;
		} */	
			
		$data=array(
			'sub_total'=>$ordertablesubtotal,
			'net_total'=>$net_total
		);
		/* print_r($data);exit; */
		if($dis_total!=""){
			$data['disc_total']=$dis_total;
		}
		
		$data['dis_total_percentage']=$dis_total_percentage;
		$data['disc_percentage_total']=$discount_percentage_price;
		
		if($cgst_per!="")
			$data['cgst_per']=$cgst_per;
		if($sgst_per!="")
			$data['sgst_per']=$sgst_per;

		$this->restaurant_manager_order_model->updateactive_inactive('orders',[
			'id'=>$order_id
		],$data);
	}

	public function save_new_order()
	{
			//print_r($_POST);exit();
			$addon_id = $_POST['addon_ids'];
			$addon_names = $_POST['addon_data'];
			if(isset($_POST['addon_data'])){
				foreach($_POST['addon_data'] as $key => $value){
					$_POST['price'] = $_POST['price'] + $_POST['addonprice_data'][$key];
				}
			}
		foreach($_POST as $x => $val) 
		{
			$_POST[$x]=filter_var($_POST[$x], FILTER_SANITIZE_STRING);
		}
		
		$this->db->trans_start();
		$total=$_POST['qty']*$_POST['price'];
		$this->restaurant_manager_order_model->insert_any_query('order_items',['order_id'=>$_POST['order_id'],'recipe_id'=>$_POST['recipe_id'],'qty'=>$_POST['qty'],'price'=>$_POST['price'],'total'=>$total,'disc'=>0,'disc_amt'=>0,'sub_total'=>$total,'special_notes'=>$_POST['special_notes']]);
		$insert_id = $this->db->insert_id();
		
		if(isset($_POST['addon_ids'])){
		foreach($addon_id as $addon_id){
			//echo $addon_id;
			$this->waiting_manager_model->insert_waiting_cus('order_addon_menu',['order_item_id'=>$insert_id,'option_id'=>$addon_id]);
		}
		}

		$this->update_order_total($_POST['order_id'],$_POST['dis_total'],$_POST['cgst_per'],$_POST['sgst_per'],$_POST['dis_total_percentage']);

		$this->db->trans_complete();
		$this->json_output(['status'=>true]);
	}

	public function update_order_item()
	{		
		$this->db->trans_start();
		$total = $_POST['quantity'] * $_POST['price'];
		$this->restaurant_manager_order_model->updateactive_inactive('order_items',['id'=>$_POST['order_item_id']],['qty'=>$_POST['quantity'],'price'=>$_POST['price'],'total'=>$total,'sub_total'=>$total]);
			
		$this->update_order_total($_POST['order_id'],$_POST['dis_total'],$_POST['cgst_per'],$_POST['sgst_per'],$_POST['dis_total_percentage']);

		$this->db->trans_complete();
		$this->json_output(['status'=>true]);
		// $getdata = $this->restaurant_manager_order_model->select_where('order_items',['order_id'=>$_POST['order_id']]);
		// print_r($getdata);
	}

	public function delete_orderitem(){
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
		$get_order_data = $this->restaurant_manager_order_model->select_where('orders',['id'=>$_POST['order_id']]);
		if (count($get_order_data) > 0) {
			$dis_per = $get_order_data[0]['dis_total_percentage'];
		}
		else{
			$dis_per = 0;
		}
		//print_r($getdata)
		$ordertablesubtotal=0;
		if(!empty($getdata)){
			$this->update_order_total($_POST['order_id'],$_POST['dis_total'],$_POST['cgst_per'],$_POST['sgst_per'],$dis_per);
		}
		else{
			$this->update_order_total($_POST['order_id'],$_POST['dis_total'],$_POST['cgst_per'],$_POST['sgst_per'],$dis_per);
		}

		$this->db->trans_complete();
		$this->json_output(['status'=>true]);
	}

	public function invoice_payment()
	{
		//print_r($_POST);exit();
		$invoice_id=$_POST['invoice_id'];
		
		if($_POST['cash_payment']=="")
		{
			$_POST['cash_payment']=0;
		}
		
		if($_POST['card_payment']=="")
		{
			$_POST['card_payment']=0;
		}
		
		if($_POST['upi_payment']=="")
		{
			$_POST['upi_payment']=0;
		}
		
		if($_POST['net_banking']=="")
		{
			$_POST['net_banking']=0;
		}
		
		if($invoice_id!="")
		{
			$i=$this->invoice_model;
			$i->id=$_POST['invoice_id'];
			$i->status="Paid";			
			$i->cash_payment=$_POST['cash_payment'];
			$i->card_payment=$_POST['card_payment'];
			$i->upi_payment=$_POST['upi_payment'];
			$i->net_banking=$_POST['net_banking'];
			$i->update();

			if($_POST['cash_payment']!="")
			{
				$ip=$this->invoice_payment_model;
				$ip->invoice_id=$_POST['invoice_id'];
				$ip->payment_type="CASH";
				$ip->payment_amount=$_POST['cash_payment'];
				$ip->add();
			}
			
			if($_POST['card_payment']!="")
			{
				$ip=$this->invoice_payment_model;
				$ip->invoice_id=$_POST['invoice_id'];
				$ip->payment_type="CARD";
				$ip->payment_amount=$_POST['card_payment'];
				$ip->add();
			}
			
			if($_POST['upi_payment']!="")
			{
				$ip=$this->invoice_payment_model;
				$ip->invoice_id=$_POST['invoice_id'];
				$ip->payment_type="UPI";
				$ip->payment_amount=$_POST['upi_payment'];
				$ip->add();
			}
			
			if($_POST['net_banking']!="")
			{
				$ip=$this->invoice_payment_model;
				$ip->invoice_id=$_POST['invoice_id'];
				$ip->payment_type="NET BANKING";
				$ip->payment_amount=$_POST['net_banking'];
				$ip->add();
			}

			$t=$this->table_order_model;
			$t->id=$_POST['table_order_id'];
			$table_order=$t->get();
			
			$restaurant = $this->restaurant_manager_order_model->select_where('user',['id'=>$_SESSION['user_id']])[0];
			$timezone = $this->get_time_zone($restaurant['country']);
			
			if ($timezone)
			{
				date_default_timezone_set("'".$timezone."'");
			}
			else
			{
				date_default_timezone_set("Asia/Kolkata");
			}
			
			$updated_at = date('Y-m-d H:i:s');
			if(isset($_POST['discount_note'])){
				$discount_note = $_POST['discount_note'];
			}else{
				$discount_note = '';
			}
			$this->restaurant_manager_order_model->updateactive_inactive('orders',['invoice_id'=>$_POST['invoice_id']],['status'=>'Completed','completed_at'=>$updated_at]);
			//echo $this->db->last_query();exit();
			$this->table_order_model->update_table_available($_POST['table_order_id'],$table_order['table_id']);
			$this->json_output(array('status'=>true,"msg"=>"Successfully paid.",'invoice_id'=>$invoice_id));
		}
		else
		{
			$this->json_output(array('status'=>false,"msg"=>"Something went wrong."));
		}
	}

	public function get_order_details(){
		$orders=$this->order_model->get_order_details($_POST['order_id']);
		$this->json_output($orders);
	}

	public function change_order_status()
	{
		//print_r($_POST);
		$o=$this->order_model;
        $o->id=$_POST['order_id'];
        $o->status=$_POST['status'];
		if($_POST['status'] == "Canceled"){
			$o->cancel_note=$_POST['cancel_note'];	
		}
        $o->update();

        if($_POST['status']=="Blocked")
		{
			$gettableid= $this->Waiting_manager_model->select_where('orders',['id'=>$_POST['order_id']]);
			$table_id = $gettableid[0]['table_orders_id'];
			$check_order_count = $this->Waiting_manager_model->select_where('orders',['table_orders_id'=>$table_id]);
			$count_orders = count($check_order_count);
        	$o=$this->order_model;
        	$o->id=$_POST['order_id'];
        	$order=$o->get();
			
			if ($count_orders == 1) 
			{
				$this->Waiting_manager_model->updateactive_inactive('table_details',['id'=>$check_order_count[0]['table_id']],['is_available'=>1]);
			}
			else
			{
				$x=0;
				foreach($check_order_count as $key => $value)
				{
					if($value['status'] == 'Blocked' || $value['status'] == 'Completed' || $value['status'] == 'Canceled')
					{
						$x++;
					}
				}
				
				if($count_orders == $x)
				{
					$this->Waiting_manager_model->updateactive_inactive('table_details',['id'=>$check_order_count[0]['table_id']],['is_available'=>1]);
				}
			}
        	$this->customer_model->block_unblock_customer($order['customer_id'],1);
		}
	    
		if($_POST['status']=="Canceled")
		{
			// echo $_POST['status'];
			$gettableid= $this->Waiting_manager_model->select_where('orders',['id'=>$_POST['order_id']]);
			
			$table_id = $gettableid[0]['table_orders_id'];
			$check_order_count = $this->Waiting_manager_model->select_where('orders',['table_orders_id'=>$table_id]);
			$count_orders = count($check_order_count);
        	$o=$this->order_model;
        	$o->id=$_POST['order_id'];
        	$order=$o->get();
			
			if ($count_orders == 1) 
			{
				$this->Waiting_manager_model->updateactive_inactive('table_details',['id'=>$check_order_count[0]['table_id']],['is_available'=>1]);
				$this->Waiting_manager_model->updateactive_inactive('table_orders',['id'=>$check_order_count[0]['table_orders_id']],['flag'=>'Y']);
			}
			else
			{
				$x=0;
				foreach($check_order_count as $key => $value)
				{
					if($value['status'] == 'Blocked' || $value['status'] == 'Completed' || $value['status'] == 'Canceled')
					{
						$x++;
					}
				}

				//echo $x;exit();
				
				if($count_orders == $x)
				{
					$this->Waiting_manager_model->updateactive_inactive('table_details',['id'=>$check_order_count[0]['table_id']],['is_available'=>1]);
					$this->Waiting_manager_model->updateactive_inactive('table_orders',['id'=>$check_order_count[0]['table_orders_id']],['flag'=>'Y']);
				}
			}
        	//$this->customer_model->block_unblock_customer($order['customer_id'],1);
		}
	    

        if($_POST['status']=="Completed")
		{
        	$o=$this->order_model;
        	$o->id=$_POST['order_id'];
        	$order=$o->get();
        	$check = $this->waiting_manager_model->select_where('orders',['table_orders_id'=>$order['table_orders_id'],'status!='=>'Completed']);
        	if(empty($check)){
        		$this->waiting_manager_model->updateactive_inactive('table_details',['id'=>$order['table_id']],['is_available'=>1]);
        	}
        	//print_r($order);

	        /*$this->customer_model->block_unblock_customer($order['customer_id'],0);*/
			/*$this->order_model->block_unblock_table($order['table_id'],1);*/
        }
       $this->json_output(array('status'=>true,'msg'=>"Status Change Successfully."));
	}

	public function menufor_restaurant()
	{
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		$this->load->view('menu_for_rest');
	}

	public function update_menugroup_image(){
	
		$r=$this->menu_group_model;
	 	if(!empty($_POST)){
	        if(isset($_POST['image'])){
	        	$rand_no=rand(1111111,9999999);
	        	/*if(SERVER=="testing")
					$image_url='test/menugroup/'.$rand_no.'.jpg';
				else
					$image_url='menugroup/'.$rand_no.'.jpg';*/
				$image_url='Liveresto/menugroup/'.$rand_no.'.jpg';
	        	$file_path='uploads/'.$rand_no.'.jpg';
                $img_r = imagecreatefromjpeg($_POST['image']);
				$output=imagejpeg($img_r,$file_path);
				$aws_result=$this->uploadAWSS3($image_url,$file_path);
				unlink($file_path);

				if($image_url!=""){
					
					$m=$this->menu_group_model;
	                $m->image_path=CLOUDFRONTURL.$image_url;
		            if($_POST['id']!=""){
		                $m->id=$_POST['id'];
		                $m->update();
		                $menu_group_id=$_POST['id'];
		            }

		            $this->json_output(array('path'=>CLOUDFRONTURL.$image_url,'status'=>true,'msg'=>'Group Photo Updated'));
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
	public function menu_for_restaurants(){
		if(isset($_POST['searchkey']))
			$recipes=$this->recipes_model->menu_from_restaurants($_POST['page'],$_POST['per_page'],"",$_POST['searchkey']);
		else
			$recipes=$this->recipes_model->menu_from_restaurants($_POST['page'],$_POST['per_page']);

		$this->json_output($recipes);		
	}

	public function save_menu_for_restaurant(){
		
		$r=$this->recipes_model;
		foreach ($_POST['ids'] as $id) {

			$recipe=$this->recipes_model->copyrecipe_forrestaurant($id);
			
		}
		$this->json_output(array('status'=>true,"msg"=>"Successfully added."));		

	}

	
	public function uploadData(){
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
                  $check = $this->customer_model->select_where('customer',['contact_no'=>$value['C'],'restaurant_id'=>$_SESSION['user_id']]);
                  //print_r($check);
                  	if(empty($check)){
                  		if ($value['A'] != '' && $value['C'] != '') {
                  			$inserdata[$i]['name'] = $value['A'];
                  			$inserdata[$i]['email'] = $value['B'];
                  			$inserdata[$i]['contact_no'] = $value['C'];
                  			$inserdata[$i]['restaurant_id'] = $_SESSION['user_id'];
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

	public function importData($data) {
 
        $res = $this->db->insert_batch('customer',$data);
        if($res){
            return TRUE;
        }else{
            return FALSE;
        }
 
    }

	public function update_order(){

		$c=$this->customer_model;
		$c->id=$_POST['customer_id'];
		$c->name=$_POST['name'];
		$c->contact_no=$_POST['contact_no'];
		$c->update();
		
		$o=$this->order_model;
		$o->set_values($_POST);
		$o->update();
		$order_id=$_POST['id'];
			
		if($order_id!=0){
			$this->json_output(array('status'=>true,'msg'=>"You order place Successfully"));
		}
		else{
			$this->json_output(array('status'=>false,'msg'=>"Something went wrong please try again"));
		}
	}

	public function save_order_item(){
		
		$oi=$this->order_item_model;
		$oi->set_values($_POST);
		if($_POST['id']!=""){
			$oi->id=$_POST['id'];
			$oi->update();
		}
		else
			$oi->add();
		$order_items=$this->order_item_model->list_order_items($_POST['order_id']);
		if($_POST['order_id']){
			$gross_amount=array_sum(array_column($order_items, 'total'));
			$disc=array_sum(array_column($order_items, 'disc_total'));
			$sub_total=array_sum(array_column($order_items, 'sub_total'));			
			
			$o=$this->order_model;
			$o->id=$_POST['order_id'];
			$o->sub_total=$gross_amount;
			$o->disc_total=$disc;
			$o->net_total=$sub_total;
			$o->update();
		}
		$this->json_output(array('status'=>true,'result'=>$order_items));
	}

	public function delete_order_item(){
		$oi=$this->order_item_model;
		$oi->id=$_POST['id'];
		$oi->delete();

		$order_items=$this->order_item_model->list_order_items($_POST['order_id']);
		if($_POST['order_id']){
			$gross_amount=array_sum(array_column($order_items, 'total'));
			$disc=array_sum(array_column($order_items, 'disc_total'));
			$sub_total=array_sum(array_column($order_items, 'sub_total'));			
			
			$o=$this->order_model;
			$o->id=$_POST['order_id'];
			$o->sub_total=$gross_amount;
			$o->disc_total=$disc;
			$o->net_total=$sub_total;
			$o->update();
		}
		
		$this->json_output(array('status'=>true,'result'=>$this->order_item_model->list_order_items($_POST['order_id'])));
	}

	public function new_order()
	{
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();

		$data['currency_symbol'] = $this->customer_model->select_where('user',['id'=>$_SESSION['user_id']]);
		
		$this->load->view('neworder',$data);
	}

	public function gettable()
	{
		$upline_id = $_SESSION['user_id'];
		$sql="SELECT td.id AS table_detail_id,td.title,td.table_category_id,td.is_available
		FROM table_details AS td
		LEFT JOIN table_category as tc on tc.id = td.table_category_id
		WHERE td.is_active=1 AND td.is_delete=0 AND tc.is_active=1 AND tc.is_delete=0 AND tc.flag=0 AND td.logged_user_id =".$upline_id;
		$table_details= $this->waiting_manager_model->query($sql);

		$sql1 = "SELECT id,title FROM table_category WHERE is_active=1 AND is_delete=0 AND flag=0 AND logged_user_id=".$upline_id;
		$data1= $this->waiting_manager_model->query($sql1);

		$data=[];
		foreach ($table_details as $table) 
		{
			$table_order_details=$this->table_order_model->get_current_tableorder('N',$table['table_detail_id'],date('Y-m-d'));
			$table['table_order']=$table_order_details;

			$data[]=$table;
			// print_r($data[13]['table_order']['order']);
		}
		//print_r($data[13]['table_order']['order']);
		
		//exit();
		/* update takeaway tables */
			
		$sql10="SELECT td.id AS table_detail_id,td.title,td.table_category_id,td.is_available
		FROM table_details AS td
		LEFT JOIN table_category as tc on tc.id = td.table_category_id
		WHERE td.is_active=1 AND td.is_delete=0 AND tc.is_active=1 AND tc.is_delete=0 AND tc.flag=1 AND td.logged_user_id =".$upline_id;
		$table_details10= $this->waiting_manager_model->query($sql10);
		
		foreach ($table_details10 as $table10) 
		{
			$tableDetailId = $table10['table_detail_id'];
			
			$updatedata = array(
				'is_available' => '1'
			);

			$this->db->update('table_details',$updatedata,'id='.$tableDetailId);
		}
		/* update takeaway tables */
			
		/* Other tables data */
		
		$sql0="SELECT td.id AS table_detail_id,td.title,td.table_category_id,td.is_available
		FROM table_details AS td
		LEFT JOIN table_category as tc on tc.id = td.table_category_id
		WHERE td.is_active=1 AND td.is_delete=0 AND tc.is_active=1 AND tc.is_delete=0 AND tc.flag=1 AND td.logged_user_id =".$upline_id;
		$table_details0= $this->waiting_manager_model->query($sql0);

		$sql2 = "SELECT id,title FROM table_category WHERE is_active=1 AND is_delete=0 AND flag=1 AND logged_user_id=".$upline_id;
		$data2= $this->waiting_manager_model->query($sql2);

		$other_data=[];
		
		foreach ($table_details0 as $table1) 
		{
			/* remove cart session value */
			
			$contents = $this->cart->contents();
			$lastid = array_keys($contents)[0];
			
			$data_list = array(
				'rowid'   => $lastid,
				'qty'     => 0
			);
			$this->cart->update($data_list);
			/* remove cart session value */			
			
			$table_order_details1=$this->table_order_model->get_current_tableorder('N',$table1['table_detail_id'],date('Y-m-d'));
			$table1['table_order']=$table_order_details1;

			$other_data[]=$table1;
		}
		
		/* Other tables data */
		
		$this->json_output(['table_details'=>$data,'table_category'=>$data1,'table_other_category'=>$data2,'table_other_details'=>$other_data]);
	}

	public function tablerecipe($table_id,$order_id="",$invoice_id="")
	{
		/*	$data['main_menu']=$this->waiting_manager_model->select_where('menu_master',['is_active'=>1,'restaurant_id'=>$_SESSION['user_id']]);*/
		$t=$this->table_model;
		$t->id=$table_id;
		$data['table_details']=$t->get();
		$data['table_id']=$table_id;
		$data['order_id']=$order_id;
		$data['invoice_id']=$invoice_id;
		$cart_details=$this->cart->contents();
		
		if(!empty($cart_details))
		{
			$i=0;
			foreach($cart_details as $cart)
			{
				if($i==0)
				{
					$before_tableid=$cart['options']['table_id'];
					
					if($before_tableid!=$table_id)
					{
						$this->session->unset_userdata('cart_contents');
					}
				}
				else
				{
					break;
				}
				$i++;
			}
		}
		
		if($order_id!="")
		{
			$this->session->unset_userdata('cart_contents');
			$data['order_date'] = $this->waiting_manager_model->select_where('table_orders',['id'=>$order_id]);
		}
		
		$sql0="SELECT tc.flag,td.id AS table_detail_id,td.title,td.table_category_id,td.is_available
		FROM table_details AS td
		LEFT JOIN table_category as tc on tc.id = td.table_category_id
		WHERE td.is_active=1 AND td.is_delete=0 AND tc.is_active=1 AND tc.is_delete=0 AND td.id =".$table_id;
		$table_details0= $this->waiting_manager_model->query($sql0);		
		
		$data['takeaway_flag']=$table_details0[0]['flag'];
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		// echo $this->uri->segment(3);exit();
		$data['show_table_title'] = $this->waiting_manager_model->select_where('table_details',['id'=>$this->uri->segment(3)]);
		
		$data['currency_symbol'] = $this->waiting_manager_model->select_where('user',['id'=>$_SESSION['user_id']]);
		//print_r($data);exit();	
		$this->load->view('tablerecipe',$data);
	}

	public function onlineorder($table_id,$order_id="",$invoice_id="",$from_page="")
	{
		$t=$this->table_model;
		$t->id=$table_id;
		$data['table_details']=$t->get();
		$data['table_id']=$table_id;
		$data['order_id']=$order_id;
		$data['invoice_id']=$invoice_id;
		$data['from_page']=$from_page;
		$cart_details=$this->cart->contents();
		
		if(!empty($cart_details))
		{
			$i=0;
			
			foreach($cart_details as $cart)
			{
				if($i==0)
				{
					$before_tableid=$cart['options']['table_id'];
					
					if($before_tableid!=$table_id)
					{
						$this->session->unset_userdata('cart_contents');
					}
				}
				else
				{
					break;
				}
				$i++;
			}
		}
		
		if($order_id!="")
		{
			$this->session->unset_userdata('cart_contents');
		}
		
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		$xyz = "SELECT td.*,tc.flag FROM table_details AS td
		LEFT JOIN table_category as tc on tc.id=td.table_category_id
		WHERE td.id=".$this->uri->segment(3);
		$data['show_table_title'] = $this->waiting_manager_model->query($xyz);
		$data['currency_symbol'] = $this->customer_model->select_where('user',['id'=>$_SESSION['user_id']]);
		$this->load->view('onlineorder',$data);
	}

	// code added by victor for assignning delivery
	public function assignDeliveryOrder($order_id, $user_id="", $table_id=""){
		
		$upline_id = $_SESSION['user_id'];
		$res = $this->restaurant_manager_order_model->getOrderDeliverer($order_id);
		if ($res == null) {
			if ($user_id && $table_id) {
				$result = $this->restaurant_manager_order_model->insert_any_query('assign_delivery_for_order', [
					"delieverer_id" => $user_id,
					"order_id" => $order_id,
					"table_id" => $table_id,
					"rest_id" => $_SESSION['user_id']
				]);

				// new change here 
				// update order status after adding deliverer
				$this->restaurant_manager_order_model->updateactive_inactive('orders',["id"=>$order_id], ["status" => "Assigned To Deliver",'assigned_at'=>date('Y-m-d H:i:s')]);
				//echo $this->db->last_query();
				return $this->json_output([
					"data" => $result ? "order assigned sucessfully" : "error"
				]);
			}
			return $this->json_output([
				"error" => "error assigning delivery"
			]);
		}
		return $this->json_output([
			"res" => $res
		]);
	}

	public function getmenugrouprecipes()
	{
		//print_r($_POST);exit();
		$upline_id = $_SESSION['user_id'];
		$menu = $this->restaurant_manager_order_model->all_recipes_show_rest1($_SESSION['user_id'],$_POST['main_menu_id'],$_POST['search'],$_POST['tablecategory']);
		$this->json_output(['data'=>array(),'menu'=>$menu]);
	}

	public function getcustomerid()
	{
		$check = $this->waiting_manager_model->select_where('customer',['contact_no'=>$_POST['contact_number'],'is_block'=>0]);
		
		if (empty($check)) 
		{
			$this->json_output(['id'=>'','name'=>'']);
		}
		else
		{
			$this->json_output(['id'=>$check[0]['id'],'name'=>$check[0]['name']]);
		}
	}

	public function getorderhistory(){
		$sql = "SELECT o.*,td.insert_date,td.insert_time FROM orders as o
		LEFT JOIN table_orders AS td on td.id = o.table_orders_id
		WHERE o.customer_id=".$_POST['customer_id']." AND rest_id=".$_SESSION['user_id'];
		$data= $this->waiting_manager_model->query($sql);
		$this->json_output($data);
	}

	public function recipeadd_cart(){
		//$this->session->unset_userdata('cart');
		$cartitem = [];
		if ($_POST['data_type'] =='') {
			if (empty($_SESSION['cart'])) {
				$cartitem = [$_POST];
				$this->session->set_userdata('cart',$cartitem);
			}else{
				for ($i=0; $i < count($_SESSION['cart']); $i++) {
					if ($_SESSION['cart'][$i]['recipe_id'] == $_POST['recipe_id']) {
						$recipe_id = $_SESSION['cart'][$i]['recipe_id'];
						$_SESSION['cart'][$i]['qty'] = $_SESSION['cart'][$i]['qty']+1;
					}
				}
				if ($recipe_id =='') {
					$cartitem = $_SESSION['cart'];
					array_push($cartitem,$_POST);
					$this->session->set_userdata('cart',$cartitem);
				}
			}
		}
		else{
			$cartitem = $_SESSION['cart'];
			if ($_POST['data_type'] == 'plus') {
				for ($i=0; $i < count($_SESSION['cart']); $i++) {
					if ($_SESSION['cart'][$i]['recipe_id'] == $_POST['recipe_id']) {
						$recipe_id = $_SESSION['cart'][$i]['recipe_id'];
						$_SESSION['cart'][$i]['qty'] = $_SESSION['cart'][$i]['qty']+1;
					}
				}
			}
			if ($_POST['data_type'] == 'minus') {
				for ($i=0; $i < count($_SESSION['cart']); $i++) {
					if ($_SESSION['cart'][$i]['recipe_id'] == $_POST['recipe_id']) {
						$recipe_id = $_SESSION['cart'][$i]['recipe_id'];
						$_SESSION['cart'][$i]['qty'] = $_SESSION['cart'][$i]['qty']-1;
						if ($_SESSION['cart'][$i]['qty'] == 0) {
								unset($_SESSION['cart'][$i]);
						}
					}
				}
			}
			$this->session->set_userdata('cart',$_SESSION['cart']);
		}
		//print_r($_SESSION['cart']);
		$this->json_output(['sessionarray'=>$_SESSION['cart']]);
		//print_r($_POST);

	}

	public function placeorder()
	{
		//$cart_details=$this->recipes_model->get_cart_menu_details();print_r($cart_details);exit();
		$rest_id = $_SESSION['user_id'];
		$restaurant = $this->restaurant_manager_order_model->select_where('user',['id'=>$rest_id])[0];
		$check_customer = $this->customer_model->select_where('customer',['contact_no'=>$_POST['customer_contact'],'restaurant_id'=>$rest_id]);
		
		$timezone = $this->get_time_zone($restaurant['country']);
		
		if ($timezone)
		{
			date_default_timezone_set("'".$timezone."'");
		}
		else
		{
			date_default_timezone_set("Asia/Kolkata");
		}
		
		$table_id = $_POST['tableid'];
		
		$sql = "SELECT * FROM table_details, table_category WHERE table_details.table_category_id=table_category.id AND table_details.id =$table_id";
		$data = $this->waiting_manager_model->query($sql);
		$flag = $data[0]['flag'];
		
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
			
			if($flag==1)
			{
				$to->order_type="Takeaway";
			}
			else
			{
				$to->order_type="Billing";
			}
			
			$table_orders_id=$to->add();
			
			$restaurant_name=$restaurant['name'];
			/* $intial=substr($restaurant_name, 0, 2);
			$formated_id=str_pad($table_orders_id, 6, '0', STR_PAD_LEFT); */
			
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
		$o->sub_total=$_POST['sub_total'];
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
			$oi->special_notes=$cart['options']['special_notes'];
			$oi->disc=0;
			$oi->disc_amt=0;
			$oi->sub_total=$cart['subtotal'];
			$oi->add();

			$item_inserted_id = $this->db->insert_id();
			
			foreach($cart['addon'] as $key => $cart_addon){
				$this->customer_model->insert_query('order_addon_menu',['order_item_id'=>$item_inserted_id,'option_id'=>$cart_addon['addon_id']]);
			}

		}

		$restaurant_name=$restaurant['name'];
		$intial=substr($restaurant_name, 0, 2);
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
			$this->json_output(array('status'=>true,'msg'=>'Order Placed Successfully.','order_id'=>$order_id,'table_orders_id'=>$table_orders_id));
		}
		else
		{
			$this->json_output(array('status'=>false,'msg'=>'Something went wrong please try again.'));
		}
	}

	public function kot_status()
	{
		/* print_r($_POST);exit(); */
		if(isset($_POST['order_id']))
		{
			$o=$this->order_model;
			$o->id=$_POST['order_id'];
			$o->sub_total=$_POST['sub_total'];
			$o->disc_total=$_POST['dis_total'];
			$o->net_total=$_POST['net_total'];
			$o->cgst_per=$_POST['cgst_per'];
			$o->sgst_per=$_POST['sgst_per'];
			$o->status='Assigned To Kitchen';
			$o->suggetion=$_POST['suggetion'];
			$o->dis_total_percentage=$_POST['dis_total_percentage'];
			$o->disc_percentage_total=$_POST['disc_percentage_total'];
			$o->update();
		}
		$this->json_output(['status'=>true]);
	}

	public function cancel_status()
	{
		/* print_r($_POST);exit(); */
		if(isset($_POST['order_id']))
		{
			$o=$this->order_model;
			$o->id=$_POST['order_id'];
			$o->cancel_note=$_POST['cancel_note'];
			$o->status='Canceled';
			$o->update();
		}
		$this->json_output(['status'=>true]);
	}

	public function getorderdetails(){
		$sql = "SELECT * FROM table_orders WHERE restaurant_id =".$_SESSION['user_id']." AND table_id=".$_POST['table_no']." ORDER BY id DESC LIMIT 1";
		$data = $this->waiting_manager_model->query($sql);
		$this->json_output($data);
	}

	public function get_order()
	{
		$orders=$this->order_model->get_tableorder($_POST['order_id'],$_POST['invoice_id']);
		if($orders)
			$this->json_output($orders);
		else
			$this->json_output(false);
	}

	
	public function get_tableorder_invoices(){

		$check_orders = $this->waiting_manager_model->select_where('orders',['table_orders_id'=>$_POST['order_id']]);
		$sql ="SELECT ifnull(count(id),0) as order_count FROM `orders` WHERE table_orders_id = ".$_POST['order_id']." GROUP BY invoice_id";
		$invoice_count=$this->waiting_manager_model->query($sql);
		//$orders['delivery_charges'] =$this->Waiting_manager_model->select_where('user',['id'=>$_SESSION['user_id']]);
		if(count($check_orders) == $invoice_count[0]['order_count']){
			$orders=$this->order_model->get_tableorder_invoices($_POST['order_id'],$_POST['invoice_id']='');
		}else{
			$orders=$this->order_model->get_tableorder_invoices($_POST['order_id'],$_POST['invoice_id']);
		}

		

		
		if($orders)
			$this->json_output($orders);
		else
			$this->json_output(false);
	}


	public function getorderinvoice(){
		$sql = "SELECT id FROM table_orders WHERE restaurant_id=".$_SESSION['user_id']." AND table_id= ".$_POST['table_no']." ORDER BY id DESC limit 1";
		$data = $this->waiting_manager_model->query($sql);
		$sql1 = "SELECT * FROM orders WHERE table_orders_id= ".$data[0]['id'];
		$data1 = $this->waiting_manager_model->query($sql1);
		$this->json_output($data1);
	}


	public function invoice(){
		//echo $currency_symbol;exit();
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		$data['currency_symbol'] = $this->customer_model->select_where('user',['id'=>$_SESSION['user_id']]);
		$this->load->view('invoice_details',$data);
	}


	public function get_invoice()
	{
		$from_date=$_POST['from_date']. ' 00:00:00';
		$to_date=$_POST['to_date']. ' 23:59:59';
		
		if(isset($_POST['searchkey']))
			$manager=$this->invoice_model->list_invoice($_POST['page'],$_POST['per_page'],$from_date,$to_date,$_POST['searchkey']);
		else
			$manager=$this->invoice_model->list_invoice($_POST['page'],$_POST['per_page'],$from_date,$to_date);
		
		$this->json_output($manager);
	}

	public function get_invoice_items(){
		$invoice_details=$this->invoice_model->get_invoice_details($_POST['invoice_id']);
		$this->json_output($invoice_details);
	}

	public function deleteinvoice(){
		$this->waiting_manager_model->permanent_delete_manager('invoices',['id'=>$_POST['invoice_id']]);
		$this->waiting_manager_model->permanent_delete_manager('invoice_items',['invoice_id'=>$_POST['invoice_id']]);
		$table_order=$this->waiting_manager_model->select_where('table_orders',['restaurant_id'=>$_SESSION['user_id']]);
		//print_r($_POST);
		foreach ($table_order as $key => $value) {
			$table_order_id = $value['id'];
			$invoice_id = explode(',', $value['invoice_ids']);
			if (in_array($_POST['invoice_id'], $invoice_id)) {
				if(count($invoice_id) == 1){
					$this->waiting_manager_model->permanent_delete_manager('table_orders',['id'=>$table_order_id]);
					$order_no = $this->waiting_manager_model->select_where('orders',['table_orders_id'=>$table_order_id]);
					foreach ($order_no as $key => $value) {
						$this->waiting_manager_model->permanent_delete_manager('order_items',['order_id'=>$value['id']]);;
					}
					$this->waiting_manager_model->permanent_delete_manager('orders',['table_orders_id'=>$table_order_id]);
					$this->json_output(['status'=>true]);
				}
				else{
					$new_array = [];
					$new_array = $invoice_id;
					$arraykey=array_search($_POST['invoice_id'],$new_array);
					unset($new_array[$arraykey]);
					$update_invoice_ids=implode(',', $new_array);
					$this->waiting_manager_model->updateactive_inactive('table_orders',['id'=>$table_order_id],['invoice_ids'=>$update_invoice_ids]);
					$this->json_output(['status'=>true]);
				}
			}
			//print_r($invoice_id);
		}
	}

	public function privious_set_authority(){
		$menus= ['Profile','Dashboard','Menu','Table Management','Order','Billing','invoice','Offers','User Management','Restaurant Manager','Waitinglist Manager','Whatsapp Manager','Customer','Waitinglist','Reports','Help','Online Order'];
		$menu_name=implode(',', $menus);
		$data = $this->waiting_manager_model->select_where('user',['usertype'=>'Restaurant']);
		foreach ($data as $key => $value) {
			$this->waiting_manager_model->insert_any_query('restaurant_menu_authority',['menu_name'=>$menu_name,'restaurant_id'=>$value['id']]);
		}
		echo "Done";

	}

	public function set_authority_exist()
	{
		$check = $this->Waiting_manager_model->select_where('restaurant_menu_authority',['restaurant_id'=>$_SESSION['user_id']]);
		$menu_name = explode(',',$check[0]['menu_name']);
		//print_r($menu_name);
		
		if(in_array($_POST['name'],$menu_name))
		{
			$this->json_output(['status'=>false]);
		}
		else
		{
			$this->json_output(['status'=>true]);
		}
	}
	
	public function setdevicetoken() 
	{
		$userid = $_SESSION['user_id'];
		$user_type = $_SESSION['user_type'];
		$devicetoken = $_POST['token'];
		
		$data=array();
		
		$this->session->set_userdata('devicetoken_'.$userid,$devicetoken);
		
		$sql7 = "SELECT * from users_devicetoken WHERE userid = ".$userid." AND devicetoken = '$devicetoken'";
		$check = $this->Waiting_manager_model->query($sql7);
		
		if(count($check)<=0)
		{
			$data = array(
				'userid' => $userid,
				'devicetoken' => $devicetoken
			);
			$this->db->insert('users_devicetoken',$data);
		}
		$this->json_output($_SESSION);
	}
	
	public function send_notifiation()
	{
		$devicetoken = $_SESSION['devicetoken_'.$_SESSION['user_id']];
		$data = array();
		$data['data']['notification']['title'] = "FCM Message";
		$data['data']['notification']['body'] = "This is an FCM Message";
		$data['data']['notification']['icon'] = "/itwonders-web-logo.png";
		$data['data']['webpush']['headers']['Urgency'] = "high";
		$data['to'] = $devicetoken;
		// print_r(json_encode($data));
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_POST, 1);
		$headers = array();
		$headers[] = "Authorization: key = AAAAzOOokBU:APA91bEzMANbDNo4zlOBvFgBBuDKXeIpwAIWT9ke6eEWW2i1Ybt-lemfRNasf2eCbLZb91nkCbXoEHlaOy-mvgxej-zADHvPdUSU3kjo_QtHGSFRLPorxj64LC7OGUZDCFNAJdIXjpnJ";
		$headers[] = "Content-Type: application/json";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		curl_setopt($ch, CURLOPT_URL , "https://fcm.googleapis.com/fcm/send");
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch,CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch,CURLOPT_POSTFIELDS, json_encode($data));
		// curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, false);
		// curl_setopt($ch,CURLOPT_SSL_VERIFYPEER , false);

		$result = curl_exec($ch);
		/* if (curl_errno($ch))
		echo 'Error:' . curl_error($ch);

		curl_close($ch);

		echo "<pre>Result : ";
		print_r(json_decode($result,1));
		echo '<br>sent through</pre>'; */
	}

	public function show_table_rest_manager(){

		$manager_id = $_POST['restaurant_manager_id'];

		$sql = "SELECT td.* 
		FROM `table_details` as td 
		LEFT JOIN table_category as tc on tc.id = td.table_category_id
		WHERE td.id NOT IN(select table_id from assign_table_for_manager where restaurant_id = ".$_SESSION['user_id'].") AND td.logged_user_id=".$_SESSION['user_id']." AND td.is_active=1 AND td.is_delete=0 AND tc.is_active=1 AND tc.is_delete=0 AND tc.flag=0";
		$all_table = $this->waiting_manager_model->query($sql);
		$table_data = array();

		foreach($all_table as $key => $value){
			$table_data[] = $value;
		}

		
		$sql2 = "SELECT table_details.* FROM assign_table_for_manager,table_details WHERE assign_table_for_manager.table_id=table_details.id AND assign_table_for_manager.manager_id=".$manager_id." AND assign_table_for_manager.restaurant_id=".$_SESSION['user_id'];
		$assign_tables2 = $this->waiting_manager_model->query($sql2);

		foreach($assign_tables2 as $key => $value1){
			$table_data[] = $value1;
		}

		$sql1 = "SELECT table_id FROM assign_table_for_manager WHERE manager_id=".$manager_id." AND restaurant_id=".$_SESSION['user_id'];
		$assign_tables = $this->waiting_manager_model->query($sql1);

		$this->json_output(['table'=>$table_data,'assign_table'=>$assign_tables]);
	}

	public function assign_table_to_manager(){
		$this->waiting_manager_model->permanent_delete_manager('assign_table_for_manager',['manager_id'=>$_POST['restaurant_manager_id']]);
		if(!empty($_POST['table'])){
		foreach($_POST['table'] as $key=>$value){
			$check_table_assign = $this->waiting_manager_model->select_where('assign_table_for_manager',['restaurant_id'=>$_SESSION['user_id'],'manager_id'=>$_POST['restaurant_manager_id'],'table_id'=>$value]);
			if(empty($check_table_assign)){
				$this->waiting_manager_model->insert_waiting_cus('assign_table_for_manager',['manager_id'=>$_POST['restaurant_manager_id'],'table_id'=>$value,'restaurant_id'=>$_SESSION['user_id']]);
			}
		} }
		$this->json_output(['status'=>true]);
	}

	public function show_assign_table(){
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		$this->load->view('show_assign_table',$data);
	}

	public function manager_table(){
		if(isset($_POST['searchkey']))
			$manager=$this->Restaurant_manager_model->manager_table($_POST['page'],$_POST['per_page'],$_POST['searchkey']);
		else
		$manager=$this->Restaurant_manager_model->manager_table($_POST['page'],$_POST['per_page']);

		foreach($manager['manager'] as $key => $value){
			$value['manager_id'];
			$sql = "SELECT td.title FROM assign_table_for_manager AS at
			LEFT JOIN table_details AS td on td.id = at.table_id
			WHERE at.manager_id=".$value['manager_id'];
			$get_tables = $this->Restaurant_manager_model->query($sql);
			$manager['manager'][$key]['table_details'] = $get_tables;
		}
		$this->json_output($manager);
	}	
	
	public function language_session(){
		$_SESSION['language'] = $_POST['language'];
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

	public function add_on(){
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		$sql = "SELECT mg.*
		FROM menu_group AS mg
		LEFT JOIN menu_master AS mm ON mm.id = mg.main_menu_id
		WHERE mm.is_active = 1 AND mg.is_active = 1 AND mg.logged_user_id =".$_SESSION['user_id'];
		$data['menu_group'] = $this->waiting_manager_model->query($sql);
		$this->load->view('add_on_menus',$data);
	}

	public function choose_addon_menu(){
		$recipes=$this->recipes_model->list_addon_typahead();

		echo json_encode($recipes);
	}

	public function list_addon_menu(){
		if(isset($_POST['searchkey']))
			$manager=$this->recipes_model->list_addon_rcipes($_POST['page'],$_POST['per_page'],$_POST['searchkey']);
		else
		$manager=$this->recipes_model->list_addon_rcipes($_POST['page'],$_POST['per_page']);
		$this->json_output($manager);
	}

	public function save_addon_menu(){
		//print_r($_POST);exit();
		$this->db->trans_start();
		if($this->waiting_manager_model->insert_any_query('addon_menu',['menu_group_id'=>$_POST['menu_group_id'],'menu_id'=>$_POST['menu_id'],'addon_name'=>$_POST['addon_name'],'is_multiple_menu'=>$_POST['is_multiple_menu'],'restaurant_id'=>$_SESSION['user_id']])){
			//echo $this->db->last_query();
			
			$addon_menu_id = $this->db->insert_id();
			for($i=0;$i<count($_POST['option_name']);$i++){
				$this->waiting_manager_model->insert_any_query('addon_menu_option',['addon_menu_id'=>$addon_menu_id,'option_name'=>$_POST['option_name'][$i],'price'=>$_POST['option_price'][$i]]);
			}
			//echo $this->db->last_query();
			if($this->db->trans_complete()){
				//exit();
				$this->json_output(['status'=>true]);
			}
		}else{
			//exit();
			$this->json_output(['status'=>false]);
		}
	}

	public function recipe_status(){
		if($_POST['is_active']=="on")
			$this->Waiting_manager_model->updateactive_inactive('recipes',['id'=>$_POST['id']],['is_active'=>1,'is_recipe_active'=>1]);		
		else
			$this->Waiting_manager_model->updateactive_inactive('recipes',['id'=>$_POST['id']],['is_active'=>0,'is_recipe_active'=>0]);
		$this->json_output(array('status'=>true));
	}

	public function delete_perticular_addon_menu(){
		$this->Waiting_manager_model->updateactive_inactive('addon_menu_option',['addon_menu_id'=>$_POST['id']],['is_delete'=>1]);
		$this->Waiting_manager_model->updateactive_inactive('addon_menu',['id'=>$_POST['id']],['is_delete'=>1]);
		
		$this->json_output(array('status'=>true));
	}

	public function show_perticular_addon_menu(){
		$individual_manager = $this->Waiting_manager_model->select_where('addon_menu',['id'=>$_POST['id']])[0];

		$menu_group = $this->waiting_manager_model->select_where('menu_group',['is_active'=>1,'logged_user_id'=>$_SESSION['user_id']]);
		
		$menu = $this->waiting_manager_model->select_where('recipes',['is_active'=>1,'group_id'=>$individual_manager['menu_group_id']]);
		
		$option = $this->waiting_manager_model->select_where('addon_menu_option',['addon_menu_id'=>$_POST['id'],'is_delete'=>0]);

		$this->json_output(['addon_details'=>$individual_manager,'menu_group'=>$menu_group,'menu'=>$menu,'option'=>$option]);
	}

	public function edit_perticular_addon_menu(){
		$option_name_array = $_POST['option_name'];
		$option_price_array = $_POST['option_price'];

		foreach($_POST as $x => $val) {
			$_POST[$x]=filter_var($_POST[$x], FILTER_SANITIZE_STRING);
		}

		if($this->Waiting_manager_model->updateactive_inactive('addon_menu',['id'=>$_POST['id']],['menu_group_id'=>$_POST['menu_group_id'],'menu_id'=>$_POST['menu_id'],'addon_name'=>$_POST['addon_name'],'is_multiple_menu'=>$_POST['is_multiple_menu']])){
			
			if($this->Waiting_manager_model->updateactive_inactive('addon_menu_option',['addon_menu_id'=>$_POST['id']],['is_delete'=>1])){
				
				for($i=0;$i<count($option_name_array);$i++){
					$this->Waiting_manager_model->insert_any_query('addon_menu_option',['addon_menu_id'=>$_POST['id'],'option_name'=>$option_name_array[$i],'price'=>$option_price_array[$i]]);
					
				}
				$this->json_output(array('status'=>true));

			}

		}
		else{
			$this->json_output(array('status'=>false));
		}
	}

	public function delete_addon_option(){
		$this->waiting_manager_model->updateactive_inactive('addon_menu_option',['id'=>$_POST['id']],['is_delete'=>1]);
		
		$option = $this->waiting_manager_model->select_where('addon_menu_option',['addon_menu_id'=>$_POST['addon_menu_id'],'is_delete'=>0]);
		//echo $this->db->last_query();exit();
		$this->json_output(array('status'=>true,'option'=>$option));
	}

	public function check_recipe_addon()
	{
		/* $check_add_on = $this->waiting_manager_model->select_where('recipe_addon',['recipe_id'=>$_POST['recipe_id']]); */
		
		$check_menu_id_available = $this->waiting_manager_model->select_where('addon_menu',['menu_id'=>$_POST['recipe_id'],'is_delete'=>0]);
		$check_menu_group = $this->waiting_manager_model->select_where('addon_menu',['menu_group_id'=>$_POST['group_id'],'is_delete'=>0]);
		
		/* var_dump($check_menu_id_available);echo '<br>';echo '<br>';
		var_dump($check_menu_group);echo '<br>';echo '<br>'; */
		
		if(empty($check_menu_id_available) && empty($check_menu_group))
		{
			$sql="SELECT r.id as recipe_id,r.name as recipe_name,r.price as recipe_price,r.recipe_type,ifnull(d.discount,0),d.id as offer_id
			FROM recipes AS r
			LEFT JOIN admin_offer AS d on d.recipe_id = r.id
			WHERE r.id =".$_POST['recipe_id'];
		}
		else
		{
			if(!empty($check_menu_id_available) && !empty($check_menu_group))
			{
				$this->json_output(array('status'=>true));
			}
			else if(empty($check_menu_id_available) && !empty($check_menu_group))
			{
				$sql1="SELECT * FROM addon_menu WHERE menu_group_id =".$_POST['group_id']." AND (menu_id IS NULL || menu_id=0)";
				$addon_menu1=$this->customer_model->query($sql1);
				
				if($addon_menu1)
				{
					$this->json_output(array('status'=>true));
				}
				else
				{
					$this->json_output(array('status'=>false));
				}
			}
			else
			{
				$this->json_output(array('status'=>false));
			}			
		}
		
		/* if(count($check_add_on) > 0){
			$this->json_output(array('status'=>true));
		}
		else{
			$this->json_output(array('status'=>false));
		} */
	}

	public function show_recipe_addon()
	{
		/* $sql="SELECT ra.recipe_id,am.*
		FROM recipe_addon AS ra
		LEFT JOIN addon_menu AS am on ra.addon_id = am.id
		WHERE ra.recipe_id =".$_POST['recipe_id']; */
		$check_menu_id_available = $this->customer_model->select_where('addon_menu',['menu_id'=>$_POST['recipe_id'],'is_delete'=>0]);
		
		$check_menu_group = $this->customer_model->select_where('addon_menu',['menu_group_id'=>$_POST['group_id'],'is_delete'=>0]);
		
		
		/* var_dump($check_menu_id_available);echo '<br>';echo '<br>';
		var_dump($check_menu_group);echo '<br>';echo '<br>'; */
		
		if(empty($check_menu_id_available) && empty($check_menu_group))
		{
			$sql="SELECT r.id as recipe_id,r.name as recipe_name,r.price as recipe_price,r.recipe_type,ifnull(d.discount,0) as discount,d.id as offer_id
			FROM recipes AS r
			LEFT JOIN admin_offer AS d on d.recipe_id = r.id
			WHERE r.id =".$_POST['recipe_id'];
		}
		else
		{
			if(!empty($check_menu_id_available) && !empty($check_menu_group))
			{
				$sql="SELECT r.id as recipe_id,am.*,r.name as recipe_name,r.price as recipe_price,r.recipe_type,ifnull(d.discount,0) as discount,d.id as offer_id
				FROM addon_menu AS am
				LEFT JOIN menu_group as mg on mg.id = am.menu_group_id
				LEFT JOIN recipes AS r on r.group_id = mg.id
				LEFT JOIN admin_offer AS d on d.recipe_id = r.id
				WHERE am.is_delete=0 AND am.menu_group_id =".$_POST['group_id']." AND am.menu_id=".$_POST['recipe_id']." AND r.id=".$_POST['recipe_id'];
			}
			else if(empty($check_menu_id_available) && !empty($check_menu_group))
			{
				$sql1="SELECT * FROM addon_menu WHERE menu_group_id =".$_POST['group_id']." AND (menu_id IS NULL || menu_id=0)";
				
				$addon_menu1=$this->customer_model->query($sql1);
				
				if($addon_menu1)
				{
					$sql="SELECT r.id as recipe_id,am.*,r.name as recipe_name,r.price as recipe_price,r.recipe_type,ifnull(d.discount,0) as discount,d.id as offer_id
					FROM addon_menu AS am
					LEFT JOIN menu_group as mg on mg.id = am.menu_group_id
					LEFT JOIN recipes AS r on r.group_id = mg.id
					LEFT JOIN admin_offer AS d on d.recipe_id = r.id
					WHERE am.is_delete=0 AND am.menu_group_id =".$_POST['group_id']." AND (am.menu_id IS NULL || am.menu_id=0) AND r.id=".$_POST['recipe_id'];
				}
				else
				{
					$sql="SELECT r.id as recipe_id,r.name as recipe_name,r.price as recipe_price,r.recipe_type,ifnull(d.discount,0) as discount,d.id as offer_id
					FROM recipes AS r
					LEFT JOIN admin_offer AS d on d.recipe_id = r.id
					WHERE r.id =".$_POST['recipe_id'];
				}
			}
			else if(!empty($check_menu_id_available) && empty($check_menu_group)){
				$sql1="SELECT * FROM addon_menu WHERE menu_id =".$_POST['recipe_id'];
				
				$addon_menu1=$this->customer_model->query($sql1);
				
				if($addon_menu1)
				{
					$sql="SELECT r.id as recipe_id,am.*,r.name as recipe_name,r.price as recipe_price,r.recipe_type,ifnull(d.discount,0) as discount,d.id as offer_id
					FROM addon_menu AS am
					LEFT JOIN menu_group as mg on mg.id = am.menu_group_id
					LEFT JOIN recipes AS r on r.group_id = mg.id
					LEFT JOIN admin_offer AS d on d.recipe_id = r.id
					WHERE am.is_delete=0 AND  r.id=".$_POST['recipe_id'];
				}
				else
				{
					$sql="SELECT r.id as recipe_id,r.name as recipe_name,r.price as recipe_price,r.recipe_type,ifnull(d.discount,0) as discount,d.id as offer_id
					FROM recipes AS r
					LEFT JOIN admin_offer AS d on d.recipe_id = r.id
					WHERE r.id =".$_POST['recipe_id'];
				}
			}
			else
			{
				$sql="SELECT r.id as recipe_id,r.name as recipe_name,r.price as recipe_price,r.recipe_type,ifnull(d.discount,0) as discount,d.id as offer_id
				FROM recipes AS r
				LEFT JOIN admin_offer AS d on d.recipe_id = r.id
				WHERE r.id =".$_POST['recipe_id'];
			}			
		}
		
		$addon_menu=$this->customer_model->query($sql);
		//print_r($addon_menu);
		$addon_data=array();

		foreach($addon_menu as $key=>$value)
		{
			$addon_menu_option=$this->customer_model->select_where('addon_menu_option',['addon_menu_id'=>$value['id'],'is_delete'=>0]);
			$addon_options=array();

			foreach($addon_menu_option as $key => $rows)
			{
				$addon_options[] = array('option_id'=>$rows['id'],'option_name'=>$rows['option_name'],'option_price'=>$rows['price']);
			}

			$addon_data[] = array('addon_id'=>$value['id'],'addon_name'=>$value['addon_name'],'is_multiple_menu'=>$value['is_multiple_menu'],'options'=>$addon_options);

		}
		$this->json_output($addon_data);
	}
	
	public function uploadMenuGroupData()
	{
		$path = 'assets/';
		require_once APPPATH . "/third_party/PHPExcel.php";
		$config['upload_path'] = $path;
		$config['allowed_types'] = 'xlsx|xls';
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
					
					/* $check = $this->menu_group_model->select_where('menu_group',['title'=>$value['A'],'main_menu_id'=>$value['B'],'restaurant_id'=>$_SESSION['user_id']]);					 */
					$check = $this->menu_group_model->is_exits($value['A'],$value['B']);					
					
					if(empty($check))
					{
						if ($value['A'] != '') 
						{
							$inserdata[$i]['title'] = $value['A'];
							$inserdata[$i]['is_active'] = 1;
							$inserdata[$i]['datetime'] = date('Y-m-d h:i:s');
							$inserdata[$i]['main_menu_id'] = $value['B'];;
							$inserdata[$i]['logged_user_id'] = $_SESSION['user_id'];
							$i++;
						}
					}
				}

				if (empty($inserdata)) 
				{
					$this->json_output(array('status'=>false,'msg'=>'File records are exist.Information updated successfully'));
					exit();
				}

				$result = $this->menu_group_model->importdata($inserdata);   
				
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
	public function trending_offer_show_dashboard()
	{
		$trending_offers_condition='';
		if($_POST['filter_date'] == 'Monthly'){
			$from_date = date('Y-m')."-01 00:00:00";
			$to_date = date('Y-m')."-30 00:00:00";
		}else{
			$ddate = date('Y-m-d');
			$date = new DateTime($ddate);
			$week = $date->format("W");
			$result = $this->Start_End_Date_of_a_week($week,date('Y'));
			$from_date = $result[0].' 00:00:00';
			$to_date = $result[1].' 23:59:59';
		}

		$trending_offers_condition = " AND (o.created_at>='".$from_date."' AND o.created_at<='".$to_date."')";
		$sql6 = "SELECT count(o.recipe_id) as recipe_count,sum(o.sub_total) as income,r.* 
		FROM `order_items` as o 
		left join recipes as r on r.id = o.recipe_id
		left join orders as ord on ord.id = o.order_id
		WHERE ord.rest_id = ".$_SESSION['user_id'].$trending_offers_condition." group by o.recipe_id order by count(o.recipe_id) DESC limit 4";
		$trending_offers = $this->waiting_manager_model->query($sql6);

		$currency_symbol = $this->customer_model->select_where('user',['id'=>$_SESSION['user_id']]);

		echo json_encode(['trending_order'=>$trending_offers,'currency_symbol'=>$currency_symbol]);
		
	}

	public function Start_End_Date_of_a_week($week, $year)
	{
    		$time = strtotime("1 January $year", time());
		$day = date('w', $time);
		$time += ((7*$week)+1-$day)*24*3600;
		$dates[0] = date('Y-n-j', $time);
		$time += 6*24*3600;
		$dates[1] = date('Y-n-j', $time);
		return $dates;
	}											
}
?>