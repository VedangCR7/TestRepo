<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Reports extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->is_loggedin();
        $this->load->library('cart');
		$this->load->model('user_model');	
		$this->load->model('customer_model');	
		$this->load->model('order_model');	
		$this->load->model('invoice_model');
	}
	
	public function order_summary() 
	{
		if (!empty($_POST)) 
		{
			if($_POST['from_date'] > $_POST['to_date']){
				$this->session->set_flashdata('danger','From Date is greater than To Date');
            	redirect('reports/order_summary');
			}
			$from_date = $_POST['from_date'] ." 00:00:00";
  			$to_date = $_POST['to_date']." 23:59:59";
		}
		else
		{
			$from_date = date("Y-m-d")." 00:00:00";
			$to_date = date("Y-m-d")." 23:59:59";
		}
		
		$data=array(
			'order_summary'=>$this->order_model->order_summary_repot($from_date,$to_date)
		);

		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();

		$data['currency_symbol'] = $this->customer_model->select_where('user',['id'=>$_SESSION['user_id']]);

		$this->load->view('order_summary',$data);
	}
	
	public function takeaway_order_summary() 
	{
		if (!empty($_POST)) 
		{
			if($_POST['from_date'] > $_POST['to_date']){
				$this->session->set_flashdata('danger','From Date is greater than To Date');
            	redirect('reports/takeaway_order_summary');
			}
			$from_date = $_POST['from_date'] ." 00:00:00";
  			$to_date = $_POST['to_date']." 23:59:59";
  			$takeawaycategory = $_POST['takeawaycategory'];
		}
		else
		{
			$from_date = date("Y-m-d")." 00:00:00";
			$to_date = date("Y-m-d")." 23:59:59";
			$takeawaycategory = $_POST['takeawaycategory'];
		}
		
		$data=array(
			'order_summary'=>$this->order_model->takeaway_order_summary_repot($from_date,$to_date,$takeawaycategory)
		);
		
		$data['takeaway_category']=$this->order_model->takeaway_category();	
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();

		$data['currency_symbol'] = $this->customer_model->select_where('user',['id'=>$_SESSION['user_id']]);

		$this->load->view('takeaway_order_summary',$data);
	}
	
	public function payment_summary() 
	{
		if (!empty($_POST)) 
		{
			if($_POST['from_date'] > $_POST['to_date']){
				$this->session->set_flashdata('danger','From Date is greater than To Date');
            	redirect('reports/payment_summary');
			}
			$from_date = $_POST['from_date'] ." 00:00:00";
  			$to_date = $_POST['to_date']." 23:59:59";
  			$payment_type = $_POST['paymentType'];
		}
		else
		{
			$from_date = date("Y-m-d")." 00:00:00";
			$to_date = date("Y-m-d")." 23:59:59";
			$payment_type = $_POST['paymentType'];
		}
		
		$data=array(
			'order_summary'=>$this->order_model->payment_summary_repot($from_date,$to_date,$payment_type)
		);
		
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		$this->load->view('payment_summary',$data);
	}

	public function customer_report()
	{
		$customer_name='';
		$customer_contact='';
		
		if (!empty($_POST)) 
		{
			if($_POST['from_date'] > $_POST['to_date']){
				$this->session->set_flashdata('danger','From Date is greater than To Date');
            	redirect('reports/customer_report');
			}
			if ($_POST['customer_name']!='') 
			{
				$customer_name = "AND c.name ='".$_POST['customer_name']."'";
			}
			
			if ($_POST['customer_contact']!='') 
			{
				$customer_contact ="AND c.contact_no ='".$_POST['customer_contact']."'";
			}
			$from_date = $_POST['from_date']." 00:00:00";
  			$to_date = $_POST['to_date']." 23:59:59";
		}
		else
		{
			$from_date = date("Y-m-d")." 00:00:00";
			$to_date = date("Y-m-d")." 23:59:59";
		}
		
		$sql= "SELECT o.*,c.name,c.contact_no,c.email,COUNT(o.customer_id) as customer_id_count,SUM(o.net_total) as order_amount FROM `orders` as o LEFT JOIN customer as c on c.id=o.customer_id WHERE o.rest_id = ".$_SESSION['user_id']." AND o.created_at>='".$from_date."' AND o.created_at<='".$to_date."' ".$customer_name." ".$customer_contact." GROUP BY o.customer_id ORDER BY o.customer_id DESC";
		$data=array(
			'customer'=>$this->customer_model->query($sql)
		);
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();

		$data['currency_symbol'] = $this->customer_model->select_where('user',['id'=>$_SESSION['user_id']]);

		$this->load->view('customerreports',$data);
	}

	public function revenue_report()
	{
		if (!empty($_POST)) 
		{
			if($_POST['from_date'] > $_POST['to_date']){
				$this->session->set_flashdata('danger','From Date is greater than To Date');
            	redirect('reports/revenue_report');
			}
			$from_date = $_POST['from_date']." 00:00:00";
  			$to_date = $_POST['to_date']." 23:59:59";
		}
		else
		{
			$from_date = date("Y-m-d")." 00:00:00";
			$to_date = date("Y-m-d")." 23:59:59";
		}
		
  		$sql="SELECT o.order_no,o.customer_id,c.name,o.status,o.net_total,o.created_at FROM orders as o LEFT JOIN customer as c on c.id=o.customer_id WHERE o.rest_id=".$_SESSION['user_id']." AND o.status='Completed' AND o.created_at>='".$from_date."' AND o.created_at<='".$to_date."' ORDER BY o.id DESC";
  		$data=array(
			'revenue'=>$this->customer_model->query($sql)
		);
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();

		$data['currency_symbol'] = $this->customer_model->select_where('user',['id'=>$_SESSION['user_id']]);

		$this->load->view('revenue',$data);
	}

	public function selling_item_report()
	{
		if (!empty($_POST)) 
		{
			if($_POST['from_date'] > $_POST['to_date']){
				$this->session->set_flashdata('danger','From Date is greater than To Date');
            	redirect('reports/selling_item_report');
			}
			$from_date = $_POST['from_date']." 00:00:00";
  			$to_date = $_POST['to_date']." 23:59:59";
		}
		else
		{
			$from_date = date("Y-m-d")." 00:00:00";
			$to_date = date("Y-m-d")." 23:59:59";
		}
		
  		$sql="SELECT o.created_at,count(o.recipe_id) as recipe_count,sum(o.sub_total) as income,r.* FROM `order_items` as o left join recipes as r on r.id = o.recipe_id left join orders as ord on ord.id = o.order_id WHERE ord.rest_id = ".$_SESSION['user_id']." AND o.created_at>='".$from_date."' AND o.created_at<='".$to_date."' group by o.recipe_id order by count(o.recipe_id) DESC";
  		$data=array(
			'items'=>$this->customer_model->query($sql)
		);
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();

		$data['currency_symbol'] = $this->customer_model->select_where('user',['id'=>$_SESSION['user_id']]);

		$this->load->view('best_selling_report',$data);
	}
	
	public function group_wise_report()
	{
		if (!empty($_POST)) 
		{
			if($_POST['from_date'] > $_POST['to_date']){
				$this->session->set_flashdata('danger','From Date is greater than To Date');
            	redirect('reports/group_wise_report');
			}
			$from_date = $_POST['from_date']." 00:00:00";
  			$to_date = $_POST['to_date']." 23:59:59";
  			$groupId = $_POST['group_id'];
		}
		else
		{
			$from_date = date("Y-m-d")." 00:00:00";
			$to_date = date("Y-m-d")." 23:59:59";
			$groupId = $_POST['group_id'];
		}
		
		if($groupId > 0)
		{
			$sql="SELECT mg.title as group_name,o.created_at,count(o.recipe_id) as recipe_count,sum(o.sub_total) as income,r.* 
			FROM `order_items` as o left join recipes as r on r.id = o.recipe_id 
			left join orders as ord on ord.id = o.order_id 
			left join menu_group mg on mg.id = r.group_id
			WHERE mg.id = ".$groupId." AND ord.rest_id = ".$_SESSION['user_id']." AND o.created_at>='".$from_date."' AND o.created_at<='".$to_date."' group by o.recipe_id order by count(o.recipe_id) DESC";		
		}
		else
		{
			$sql="SELECT mg.title as group_name,o.created_at,count(o.recipe_id) as recipe_count,sum(o.sub_total) as income,r.* 
			FROM `order_items` as o left join recipes as r on r.id = o.recipe_id 
			left join orders as ord on ord.id = o.order_id 
			left join menu_group mg on mg.id = r.group_id
			WHERE ord.rest_id = ".$_SESSION['user_id']." AND o.created_at>='".$from_date."' AND o.created_at<='".$to_date."' group by o.recipe_id order by count(o.recipe_id) DESC";
		}
  		
  		$data=array(
			'items'=>$this->customer_model->query($sql)
		);
		
		$data['group_list']=$this->order_model->getGroupLists();

		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();

		$data['currency_symbol'] = $this->customer_model->select_where('user',['id'=>$_SESSION['user_id']]);
		
		$this->load->view('group_wise_report',$data);
	}

	public function invoice()
	{
		$sql = "SELECT i.*,c.name,c.contact_no,c.email,d.title from invoices as i
		left join customer as c on c.id=i.customer_id
		left join table_details as d on d.id=i.table_id
		where i.rest_id=".$_SESSION['user_id']." AND i.customer_id=".$_POST['customer_id'];
		$data= $this->customer_model->query($sql);
		$this->json_output($data);
	}

	public function invoice_details()
	{
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();

		$data['currency_symbol'] = $this->customer_model->select_where('user',['id'=>$_SESSION['user_id']]);
		
		$this->load->view('report_invoice_details',$data);
	}

	public function get_invoice()
	{
		$customer_id=$_POST['customer_id'];
		$status=$_POST['status'];
		if(isset($_POST['searchkey']))
			$manager=$this->invoice_model->list_report_invoice($_POST['page'],$_POST['per_page'],$customer_id,$status,$_POST['searchkey']);
		else
		$manager=$this->invoice_model->list_report_invoice($_POST['page'],$_POST['per_page'],$customer_id,$status);
		$this->json_output($manager);
	}

	public function get_invoice_items()
	{
		$invoice_details=$this->invoice_model->get_invoice_details($_POST['invoice_id']);
		$this->json_output($invoice_details);
	}
}
?>