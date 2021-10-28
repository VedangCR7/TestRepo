<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Company extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->is_loggedin();
		$this->load->model('user_model');	
		$this->load->model('recipes_model');	
		$this->load->model('subscription_model');
		$this->load->model('aalcalc_model');
	}
	
	public function index() {
		$data=array(
			'active_users'=>$this->user_model->get_company_usercount($_SESSION['user_id'],1),
			'inactive_users'=>$this->user_model->get_company_usercount($_SESSION['user_id'],0),
			'recipes_count'=>$this->recipes_model->count_foodcompany_recipes(),
			'user_registration'=>$this->user_model->get_company_registration_count()
		);
		$this->load->view('foodcmp_dashboard',$data);
	}

	public  function dashboard()
	{
		$data=array(
			'active_users'=>$this->user_model->get_company_usercount($_SESSION['user_id'],1),
			'inactive_users'=>$this->user_model->get_company_usercount($_SESSION['user_id'],0),
			'recipes_count'=>$this->recipes_model->count_foodcompany_recipes()
		);
		if(isset($_GET['year'])){
			$data['user_registration']=$this->user_model->get_company_registration_count($_GET['year']);
			$data['curr_year']=$_GET['year'];
		}
		else{
			$data['user_registration']=$this->user_model->get_company_registration_count();
			$data['curr_year']=date('Y');
		}

		$this->load->view('foodcmp_dashboard',$data);
	}

	public  function users()
	{
		$data=array();
		if(isset($_GET['status']))
			$data['users']=$this->user_model->list_company_restaurant($_SESSION['user_id'],$_GET['status']);
		else
			$data['users']=$this->user_model->list_company_restaurant($_SESSION['user_id']);

		$this->load->view('user_list',$data);
	}

	public function list_company_users()
	{
		if(isset($_POST['user_status']))
			$users=$this->user_model->list_company_users($_POST['page'],$_POST['per_page'],$_SESSION['user_id'],$_POST['user_status']);
		else
			$users=$this->user_model->list_company_users($_POST['page'],$_POST['per_page'],$_SESSION['user_id']);
		$this->json_output($users);
		//$this->load->view('user_list',$data);
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

	public function create_restaurant_user(){
		
		$u = $this->user_model;
		$u->set_values($_POST);
		$arr=$u->get_restaurant_api_key("Restaurant",$_SESSION['user_id']);
		$u->api_key=$arr['api_key'];
		$u->group_seq=$arr['group_seq'];
		$u->food_company_id=$_SESSION['user_id'];
		$u->usertype="Restaurant";
		$u->is_individual_reg=0;
		$u->profile_photo="assets/images/users/user.png";
		$status=$u->isexist(array('email'=>$u->email));

		$data=$_POST;
		$data['api_key']=$arr['api_key'];
		$data['group_seq']=$arr['group_seq'];
		$data['food_company_id']=$_SESSION['user_id'];
		$data['usertype']="Restaurant";
		$data['is_individual_reg']=0;
		$data['profile_photo']="assets/images/users/user.png";

		$data_id=$this->user_model->insert_user_data(json_encode($data));
		if($status=="exist"){
			$this->json_output(array('status'=>false,'msg'=>"Already have an account with us"));
			return;
		}
		//$user_id=$u->add();

		if($data_id){
		    $this->json_output(array('status'=>true,'msg'=>"User Added Successfully.",'data_id'=>$data_id));
		}
		else{
			$this->json_output(array('status'=>false,'msg'=>"Something went wrong please try again !"));
		}
	}

	public function register_companyuser(){

		$s=$this->subscription_model;
		$s->id=$_POST['subscription_id'];
		$subscription=$s->get();

		if($_POST['register_user_id']!=""){
			$user_id=$_POST['register_user_id'];
		}else{
			
			$user_data=$this->user_model->get_userdata($_POST['user_data_id']);
			$data=json_decode($user_data['user_data']);
			$u = $this->user_model;
			$u->set_values($data);
			$u->subscription_id=$_POST['subscription_id'];
			/*$u->payment_end_date=$subscription['to_date'];*/
			/*$arr=$u->get_restaurant_api_key("Restaurant",$_SESSION['user_id']);
			$u->api_key=$arr['api_key'];
			$u->group_seq=$arr['group_seq'];
			$u->food_company_id=$_SESSION['user_id'];
			$u->usertype="Restaurant";
			$u->is_individual_reg=0;
			$u->profile_photo="assets/images/users/user.png";*/
			$user_id=$u->add();
		}


		$this->user_model->update_user_paymenydate($user_id,$subscription['to_date'],$_POST['subscription_id'],$subscription['period']);

		redirect('company/users');
		//$status=$u->isexist(array('email'=>$u->email));

		/*$data=$_POST;
		$data['api_key']=$arr['api_key'];
		$data['group_seq']=$arr['group_seq'];
		$data['food_company_id']=$_SESSION['user_id'];
		$data['usertype']="Restaurant";
		$data['is_individual_reg']=0;
		$data['profile_photo']="assets/images/users/user.png";

		$data_id=$this->user_model->insert_user_data($data);*/
		/*if($status=="exist"){
			$this->json_output(array('status'=>false,'msg'=>"Already have an account with us"));
			return;
		}

		if($user_id){
		    $this->json_output(array('status'=>true,'msg'=>"User Added Successfully.",'data_id'=>$data_id));
		}
		else{
			$this->json_output(array('status'=>false,'msg'=>"Something went wrong please try again !"));
		}*/
	}

	public  function menu_group()
	{
		$data=array();
		$this->load->view('menu_group_list',$data);
	}

	public  function viewuser($user_id)
	{
		$data=array();
		$user_data=$this->user_model->get_user($user_id);
		if($user_data['img_url']==""){
			$this->load->library('ciqrcode');
			$qr_image=rand().'.png';
			/*$params['data'] = $user_data['email']."_".$user_data['id'];
			$params['data'] = "FOODNAI-".$user_data['id'];
			$params['data'] = "https://www.foodnai.com/qrcode?id=".$user_data['id']."&name=".$user_data['name'];*/
			$newparams = $user_data['id']."/".urlencode($user_data['name']);
			$params['data'] = "https://www.foodnai.com/qrcode/".$newparams;
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
		$data['user_id']=$user_id;
		/*$data['recipes']=$this->recipes_model->list_recipes_userwise($user_id);*/
		/*echo "<pre>";
		print_r($data['recipes']);
		die;*/
		$this->load->view('viewuser',$data);
	}

	public function list_user_recipes(){
		$recipe=$this->recipes_model->list_recipes_userwise($_POST['user_id'],$_POST['page'],$_POST['per_page']);
		$this->json_output($recipe);
	}

	public function get_recipe($recipe_id){

		//$event=$this->calendar_events_model->get_calendar_event($event_id);

		$recipe=$this->recipes_model->get_recipe($recipe_id);

		/*$result = $this->aalcalc_model->get_recipe($recipe['alacal_recipe_id']);*/

		if($recipe){
		    $this->json_output(array('status'=>true,'recipe'=>$recipe));
		}
		else{
			$this->json_output(array('status'=>false,'msg'=>$result));
		}
	}
}
?>