<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin1 extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->is_loggedin();
		$this->load->model('user_model');
		$this->load->model('recipes_model');

	}
	
	public function index() {
		$this->load->view('home');
	}

	public function restaurants()
	{
		$data=array();
		$data['user_list']=$this->user_model->get_resto_list();
		$this->load->view('restaurant_details',$data);
	}
		
	public  function dashboard()
	{
		/*echo "<pre>";
		print_r($_SESSION);
		die;*/
		$data=array();

		$userwise_count=$this->user_model->get_user_countbytype();
		$data['userwise_count']=$userwise_count;
		
		/* Code by Ashwini on 19 Feb 2021 */
		$data['ttlrestocount']=$this->user_model->get_ttlresto_count();
		$data['ttlrevenueocount']=$this->user_model->ttlrevenueocount();
		$data['ttlorderscount']=$this->user_model->ttlorderscount();
		/* End code by Ashwini on 19 Feb 2021 */
				
		$data['recipes_count']=$this->recipes_model->recipes_uertypewise_count();
		
		if(isset($_GET['year']) && isset($_GET['month']))
		{
			$data['user_registrations']=$this->user_model->userregistration_typewise($_GET['year'],$_GET['month']);
			$data['year']=$_GET['year'];
			$data['month']=$_GET['month'];
		}
		else
		{
			$data['user_registrations']=$this->user_model->userregistration_typewise(date('Y'),date('m'));
		}
		
		/*echo "<pre>";
		print_r($data['user_registrations']);
		die;*/
		
		/* $sql6 = "SELECT sum(o.sub_total) as income,r.* FROM `order_items` as o left join recipes as r on r.id = o.recipe_id left join orders as ord on ord.id = o.order_id WHERE ord.rest_id = ".$_SESSION['user_id']." group by o.recipe_id order by count(o.recipe_id) DESC limit 4";
		$data['trending_offers'] = $this->waiting_manager_model->query($sql6); */
		
		$this->load->view('admin_dashboard',$data);
	}

	public function users(){
		$data=array();
		if (!empty($_POST)) {
			$u=$this->user_model;
			$u->usertype=$_POST['usertype'];
			$u->restauranttype=$_POST['restauranttype'];
			$u->name=$_POST['name'];
			$u->business_name=$_POST['business_name'];
			$u->email=$_POST['email'];
			$u->password=$_POST['password'];
			$user_id=$u->add();
			if($user_id){
				$this->session->set_flashdata('success','User Registered Successfully');
                redirect(base_url().'admin/users');
			}
		}
		$data['user_list']=$this->user_model->userlist_usertypewise();
		$data['companies']=$this->user_model->get_user_bytypes("Restaurant chain");
		/*echo "<pre>";
		print_r($data['user_list']);
		die;*/
		$this->load->view('users_overview',$data);
	}

	public function recipes(){
		
		$this->load->view('recipes_overview');
	}

	public function menufor_restaurant(){
		$this->load->view('recipes_for_rest');
	}

	public function company_users($company_id){
		$user_list=$this->user_model->list_users_bycompanyids($company_id);
		$this->json_output($user_list);		
	}

	public function all_recipes(){
		if(isset($_POST['search_name']))
			$recipes=$this->recipes_model->all_recipes($_POST['page'],$_POST['per_page'],$_POST['search_name']);
		else
			$recipes=$this->recipes_model->all_recipes($_POST['page'],$_POST['per_page']);

		$this->json_output($recipes);		
	}

	public function restaurant_recipes(){
		if(isset($_POST['searchkey']))
			$recipes=$this->recipes_model->restaurant_recipes($_POST['page'],$_POST['per_page'],$_POST['searchkey']);
		else
			$recipes=$this->recipes_model->restaurant_recipes($_POST['page'],$_POST['per_page']);
		$this->json_output($recipes);		
	}

	public function save_menu_for_restaurant(){
		
		$r=$this->recipes_model;
		foreach ($_POST['ids'] as $id) {

			$recipe=$this->recipes_model->copyrecipe_foradmin($id);
			
		}
		$this->json_output(array('status'=>true,"msg"=>"Successfully added."));		

	}

	public function change_user_status(){

		$u=$this->user_model;
		$u->id=$_POST['id'];
		if($_POST['is_active']=="on")
			$u->is_active=1;
		else
			$u->is_active=0;
		$user_id=$u->update();
		$this->json_output(array('status'=>true));
	}


	public function change_alacalc_status(){

		$u=$this->user_model;
		$u->id=$_POST['id'];
		if($_POST['is_alacalc_recipe']=="on")
			$u->is_alacalc_recipe=1;
		else
			$u->is_alacalc_recipe=0;
		$user_id=$u->update();

		$this->json_output(array('status'=>true));
	}

	public function change_iscategory_status(){

		$u=$this->user_model;
		$u->id=$_POST['id'];
		if($_POST['is_active']=="on")
			$u->is_category_prices=1;
		else
			$u->is_category_prices=0;
		$user_id=$u->update();
		$this->json_output(array('status'=>true));
	}

	public function menu_authority(){
		$menu = implode(',', $_POST['menu']);
		$restaurant_id = $_POST['restaurant_id'];
		if($this->user_model->update_authority('restaurant_menu_authority',['restaurant_id'=>$restaurant_id],['menu_name'=>$menu])){
			$this->json_output(array('status'=>true));
		}
	}

	public function show_authority_restaurant(){
		$menu=$this->user_model->select_where('restaurant_menu_authority',['restaurant_id'=>$_POST['restaurant_id']]);
		$this->json_output($menu);
	}
	/*public  function rest_users()
	{
		$data=array();
		$this->load->view('restaurant_list',$data);
	}

	public function list_restaurnts_pagination()
	{
		if(isset($_POST['user_status']))
			$users=$this->user_model->list_restaurnts_pagination($_POST['page'],$_POST['per_page']);
		else
			$users=$this->user_model->list_restaurnts_pagination($_POST['page'],$_POST['per_page']);
		$this->json_output($users);
	}*/
	
	public function monthly_erning()
	{
		$data['chartdata'] = [];
		
		for ($k=0; $k < 11; $k++) 
		{ 
			$from_date= $_POST['year']."-".($k+1)."-01";
			$last_date=date("Y-m-t", strtotime($a_date));

			$sql = "SELECT ifnull(SUM(net_total),0) as earning FROM orders WHERE created_at >= '".$from_date." 00:00:00' AND created_at <= '".$last_date." 23:59:59' AND status = 'Completed'";
			$chartdata = $this->waiting_manager_model->query($sql);
			$data['chartdata'][$k] = round($chartdata[0]['earning']);
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
			$last_date=date("Y-m-t", strtotime($a_date));

			$sql = "SELECT ifnull(count(id),0) as custcount FROM get_restaurant_count WHERE visited_at >= '".$from_date."' AND visited_at <= '".$last_date."'";
			$chartdata = $this->waiting_manager_model->query($sql);
			$data['chartdata'][$k] = round($chartdata[0]['custcount']);
			array_push($data['chartdata'],$data['chartdata'][$k]);
		}
		$this->json_output($data['chartdata']);
	}
}
?>