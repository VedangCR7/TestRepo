<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->is_loggedin();
		$this->load->model('user_model');
		$this->load->model('recipes_model');
		$this->load->model('waiting_manager_model');
	}
	
	public function index() {
		$this->load->view('home');
	}

	/* public  function restaurants()
	{
		$data=array();
		$data['user_list']=$this->user_model->userlist_usertypewise();
		$this->load->view('restaurant_details',$data);
	} */
	
	public function restaurants()
	{
		$data=array();
		$data['user_list']=$this->user_model->get_resto_list();
		$this->load->view('restaurantDetails',$data);
	}
	
	public function view_restaurant_details(){
		//print_r($_POST);
		$restaurant = $this->waiting_manager_model->select_where('user',['id'=>$_POST['id']]);
		echo json_encode($restaurant);
	}
	
	public function revenue()
	{
		$data=array();
		$data['revenuedata']=$this->user_model->get_revenuedata();
		$this->load->view('revenue_details',$data);
	}
	
	public function ordersummary()
	{
		$data=array();
		$data['user_list']=$this->user_model->get_resto_list();
		$this->load->view('order_details',$data);
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
		
		$sql6 = "SELECT COUNT(o.id) as total_order, sum(o.sub_total) as sub_total, u.name, u.profile_photo FROM orders o, user u where o.rest_id = u.id AND o.status='Completed' GROUP by o.rest_id ORDER BY total_order DESC";
		$data['trending_offers'] = $this->db->query($sql6)->result_array();
		$data['user_list']=$this->user_model->get_dresto_list();
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
		
		if($_POST['section']=="restaurant")
		{
			if($_POST['is_active']=="on")
				$isactive=1;
			else
				$isactive=0;
			
			$sql6 = "UPDATE `user` SET `is_active` = ".$isactive." WHERE `upline_id` = '".$_POST['id']."'";
			$data = $this->db->query($sql6);
		}
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
		if($_POST['is_active']=="on")
			$is_category_prices=1;
		else
			$is_category_prices=0;
		$this->user_model->update_authority('user',['id'=>$_POST['id']],['is_category_prices'=>$is_category_prices]);
		// print_r($_POST);
		// $u=$this->user_model;
		// $u->id=$_POST['id'];
		// if($_POST['is_active']=="on")
		// 	$u->is_category_prices=1;
		// else
		// 	$u->is_category_prices=0;
		// echo $user_id=$u->update();exit();
		$this->json_output(array('status'=>true));
	}

	public function menu_authority(){
		//echo count($_POST['menu']);
		for($i=0;$i<count($_POST['menu']);$i++){
			//echo $_POST['menu'][$i];
			if($_POST['menu'][$i] == 'Online order'){
				$checktable = $this->waiting_manager_model->select_where('table_category',['title'=>'Website','logged_user_id'=>$_POST['restaurant_id']]);
				if(empty($checktable)){
					$this->waiting_manager_model->insert_waiting_cus('table_category',['title'=>'Website','flag'=>1,'logged_user_id'=>$_POST['restaurant_id']]);
					$last_id = $this->db->insert_id();
					$this->waiting_manager_model->insert_waiting_cus('table_details',['title'=>'Website','table_category_id'=>$last_id,'logged_user_id'=>$_POST['restaurant_id']]);
				}
			}
		}
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
			$chartdata = $this->db->query($sql)->result_array();
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
			$chartdata = $this->db->query($sql)->result_array();
			$data['chartdata'][$k] = round($chartdata[0]['custcount']);
			array_push($data['chartdata'],$data['chartdata'][$k]);
		}
		$this->json_output($data['chartdata']);
	}
	
	public function open_resto_dashboard()
	{
		$restid = $this->input->post('restid');
		
		$this->db->select('*');
        $this->db->from('user');
        $this->db->where('id',$restid);
       
        $query = $this->db->get();
        /* echo $this->db->last_query();exit; */
		if($query->num_rows())
		{
            $result=$query->row_array();
            
			if($result['is_active']==1)
			{
                $userdata = array(
                   'name'=> $result['name'],
                   'email'=> $result['email'],  
                   'business_name'=> $result['business_name'],   
                   'contact_number'=> $result['contact_number'],   
                   'user_id'   => $result['id'],
                   'logged_in' => TRUE,
                   'profile_photo'=>$result['profile_photo'],
                   'usertype'=>$result['usertype'],
                   'restauranttype'=>$result['restauranttype'],
                   'sess_rand_id'=>rand(111111,999999),
                   'is_active'=>$result['is_active'],
                   'is_alacalc_recipe'=>$result['is_alacalc_recipe'],
                   'is_category_prices'=>$result['is_category_prices']
                ); 
                $this->session->set_userdata($userdata);
                				
				return "true";
            }
			else
			{
                return "false";
            }
        }
		else
		{
			return "false";
		}
	}

	public function all_restaurants(){
		$sql="SELECT count(id) as total_restaurant FROM user WHERE usertype='Restaurant'";
		$data['total_restaurants']= $this->Waiting_manager_model->query($sql)[0];
		$sql1="SELECT count(id) as active_restaurant FROM user WHERE usertype='Restaurant' AND is_active =1";
		$data['active_restaurants']= $this->Waiting_manager_model->query($sql1)[0];
		$sql2="SELECT count(id) as inactive_restaurant FROM user WHERE usertype='Restaurant' AND is_active =0";
		$data['inactive_restaurants']= $this->Waiting_manager_model->query($sql2)[0];
		$this->load->view('admin_all_restaurants',$data);
	}

	public function list_restaurants(){
		if(isset($_POST['searchkey']))
			$manager=$this->Waiting_manager_model->list_restaurants($_POST['page'],$_POST['per_page'],$_POST['restaurant_status'],$_POST['searchkey']);
		else
		$manager=$this->Waiting_manager_model->list_restaurants($_POST['page'],$_POST['per_page'],$_POST['restaurant_status']);
		$this->json_output($manager);
	}

	public function delete_restaurant(){
		if($_POST['is_active']=="on")
			$this->Waiting_manager_model->updateactive_inactive('user',['id'=>$_POST['id']],['is_active'=>1,'is_new'=>0]);		
		else
			$this->Waiting_manager_model->updateactive_inactive('user',['id'=>$_POST['id']],['is_active'=>0]);
		$this->json_output(array('status'=>true));
	}

	public function delete_perticular_restaurant(){
		$this->Waiting_manager_model->permanent_delete_manager('user',['id'=>$_POST['id']]);
		$this->json_output(array('status'=>true));
	}

	public function view_restaurant(){
		$manager = $this->Waiting_manager_model->select_where('user',['id'=>$_POST['id']]);
		$this->json_output($manager);
	}


	public function new_registration(){
		$this->load->view('new_registrations');
	}

	public function list_new_registrations(){
		$manager = $this->Waiting_manager_model->select_where_order('user','id','DESC',['is_new'=>1]);
		//print_r($manager);
		$this->json_output($manager);
	}


	public function delete_perticular_registration(){
		$this->Waiting_manager_model->permanent_delete_manager('user',['id'=>$_POST['id']]);
		$this->json_output(array('status'=>true));
	}

	public function view_register_user(){
		$manager = $this->Waiting_manager_model->select_where('user',['id'=>$_POST['id']]);
		$this->json_output($manager);
	}

	public function verify_registration(){
		$user_data=$this->user_model->get_userdata($_POST['data_id']);
		if($user_data['link_used']==0){
			$data=json_decode($user_data['user_data']);
			$u = $this->user_model;
			$u->set_values($data);
			$user_id=$u->add();
			if($data->usertype=="Restaurant"){
				$menuarray = array(0 => 'Profile',1=>'Dashboard', 2=>'Menu',3=>'Table Management',4=>'Order',5=>'Billing',6=>'invoice',7=>'Offers',8=>'User Management',9=>'Restaurant Manager',10=>'Waitinglist Manager',10=>'Whatsapp Manager',11=>'Customers',12=>'Waitinglist',13>'Reports',14=>'Help',1=>'Online order');
				$authority['menu_name'] = implode(',', $menuarray);
				$authority['restaurant_id'] = $user_id;
				$this->user_model->insert_authority_data($authority);
				// for($i=0;$i<count($menuarray);$i++){
				// 	//echo $_POST['menu'][$i];
				// 	if($menuarray[$i] == 'Online order'){
				// 		$checktable = $this->waiting_manager_model->select_where('table_category',['title'=>'Website','logged_user_id'=>$_POST['restaurant_id']]);
				// 		if(empty($checktable)){
				// 			$this->waiting_manager_model->insert_waiting_cus('table_category',['title'=>'Website','flag'=>1,'logged_user_id'=>$_POST['restaurant_id']]);
				// 			$last_id = $this->db->insert_id();
				// 			$this->waiting_manager_model->insert_waiting_cus('table_details',['title'=>'Website','table_category_id'=>$last_id,'logged_user_id'=>$_POST['restaurant_id']]);
				// 		}
				// 	}
				// }
			}
			$this->user_model->update_link_used($user_data['id']);
			if($user_id){
				$verify="email";
			}
			else
				$verify="not";
		}else{
			$verify="invalidlink";
		}
		$this->json_output(array('verify'=>$verify));
	}
}
?>