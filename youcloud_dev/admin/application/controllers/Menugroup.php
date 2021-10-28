<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
defined('BASEPATH') OR exit('No direct script access allowed');
class Menugroup extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		//$this->is_loggedin();
		$this->load->model('Restomenugroup_model');
		$this->load->model('user_model');
		$this->load->library("session");
       	$this->load->helper('url');
	}
	
	public function index() {
		$this->load->view('view_menugroups');
	}
	
	public  function create_category1()
	{
		$this->load->view('create_tableCategory',$data);
	}
	
	public  function create_tbl1()
	{
		$this->load->view('create_table',$data);
	}
	
	public  function view()
	{
		$data['result'] = $this->Restomenugroup_model->get_menuGroupDetails($_SESSION['user_id']);
		$this->load->view('view_menugroups',$data);
	}
	
	public  function create_tbl()
	{
		$data['allTblCat'] = $this->Restomenugroup_model->get_tblCat($_SESSION['user_id']);
		
		$data['result'] = $this->Restomenugroup_model->get_tableDetails($_SESSION['user_id']);
		
		$this->load->view('create_tableBK',$data);
	}
	
	public function Add()
	{
		$tblCatId = $this->input->post('select_id'); 
		$new_tblNm = $this->input->post('new_tblNm'); 
		$restoId = $_SESSION['user_id']; 
			
		$data1 = array(	
			'table_category_id' => $tblCatId,
			'title' => $new_tblNm,
			'logged_user_id' => $restoId
		);
		
		$insert_id = $this->Restomenugroup_model->add_tableDetails($data1);
		
		if($insert_id > 0)
		{
			/* Generate qrcode */
			$this->load->library('ciqrcode');
			$qr_image=rand().$insert_id.'.png';
			$newparams = base64_encode($_SESSION['user_id'])."/".base64_encode($insert_id);
			/*$url=base_url();
			$new_url=str_replace('/admin', '', $url);*/
			$params['data'] = base_url()."qrcode/".$newparams;
			$params['level'] = 'H';
			$params['size'] = 8;
			$params['savename'] =FCPATH."uploads/table_qrCode/".$qr_image;
			if($this->ciqrcode->generate($params))
			{
				$img_name=$qr_image;	
				$tbl_qrCode="uploads/table_qrCode/".$qr_image;
			}
			/* End generate qrcode */
		
			$this->db->where('id',$insert_id);
			$this->db->update('table_details',array('qrcode'=>$tbl_qrCode));
		
			$tblCnt = $this->Restomenugroup_model->get_tblCount($_SESSION['user_id'],$tblCatId);
			$newTblCnt = ($tblCnt) + 1;
			
			$this->db->where('id',$tblCatId);
			$this->db->update('table_category',array('tbl_count'=>$newTblCnt));
		
			$this->session->set_flashdata('msg', "Table created successfully.");
			redirect('Menugroup/create_tbl');
		}
		else
		{
			$data['error_message']="Table not created, please try again";
			$this->load->view('create_tableBK', $data);
		}
		redirect('Menugroup/create_tbl');
	}
	
	public function getTblCnt()
	{
		$tblCatId = $this->input->post('tblCatId');
			
		$result = $this->Restomenugroup_model->get_tblCount($tblCatId); 
		echo $newCount = $result + 1;
	}
	
	/* for category */
	public function AddCategory()
	{
		$tblCatTtl = $this->input->post('tblCatTtl'); 
		$restoId = $_SESSION['user_id']; 
			
		$data1 = array(	
			'title' => $tblCatTtl,
			'logged_user_id' => $restoId
		);
		
		$insert_id = $this->Restomenugroup_model->add_tableCategory($data1);
		
		if($insert_id > 0)
		{
			$this->session->set_flashdata('msg', "Table category created successfully.");
			redirect('Menugroup/create_category');
		}
		else
		{
			$data['error_message']="Table category not created, please try again";
			$this->load->view('create_tableCategoryBK', $data);
		}
		redirect('Menugroup/create_category');
	}
	/* end for category */
	
	public function make_inactive()
	{
		$tcatId = $this->input->post('tcatId');
		$this->db->where('id',$tcatId);
		$this->db->update('table_category',array('is_active'=>'0'));/* echo $this->db->last_query();exit; */
		/* redirect('Menugroup/create_tbl'); */
	}
	
	public function make_active()
	{
		$tcatId = $this->input->post('tcatId');
		$this->db->where('id',$tcatId);
		$this->db->update('table_category',array('is_active'=>'1'));
		/* echo $this->db->last_query();exit; 
		redirect('Menugroup/create_tbl'); */
	}
	
	public function make_tblInactive()
	{
		$tcatId = $this->input->post('tId');
		$this->db->where('id',$tcatId);
		$this->db->update('table_details',array('is_active'=>'0'));echo $this->db->last_query();exit;
	}
	
	public function make_tblActive()
	{
		$tcatId = $this->input->post('tId');
		$this->db->where('id',$tcatId);
		$this->db->update('table_details',array('is_active'=>'1'));echo $this->db->last_query();exit;
	}
	
	public function CheckTblName()
	{
		$newtblname = $this->input->post('newtblname');
		$restoId = $_SESSION['user_id']; 
		
		$result = $this->Restomenugroup_model->check_createdTblNm($newtblname,$restoId);
		if($result!=0)
		{
			echo 'failed';
		}
	}
	
	public function DeleteTable($tPriId)
	{
		/* $this->Restomenugroup_model->delete_tbl($clientId); 
		$this->session->set_flashdata('msg', "Table deleted successfully.");
		redirect('Menugroup/create_tbl', 'refresh'); */
		
		$this->db->where('id',$tPriId);
		$this->db->update('table_details',array('is_delete'=>'1'));
		redirect('Menugroup/create_tbl', 'refresh');
	}
	
	public function DeleteTblCat($tCPriId)
	{
		/* $this->Restomenugroup_model->delete_tblCat($clientId); 
		$this->session->set_flashdata('msg', "Table Category deleted successfully.");
		redirect('Menugroup/create_category', 'refresh'); */
		$this->db->where('table_category_id',$tCPriId);
		$this->db->update('table_details',array('is_delete'=>'1'));
		$this->db->where('id',$tCPriId);
		$this->db->update('table_category',array('is_delete'=>'1'));
		redirect('Menugroup/create_category', 'refresh');
	}
	
	public function editTblCat()
	{
		$tcatId = $this->input->post('tcatId');
		$title = $this->input->post('title');
		$this->db->where('id',$tcatId);
		$this->db->update('table_category',array('title'=>"$title"));
		/* echo $this->db->last_query();exit;  */
		redirect('Menugroup/create_category');
	}
	
	public function getTableCategoryName($tcatId)
	{
		$result = $this->Restomenugroup_model->getTableCatName($tcatId);
		echo $result; exit;
	}
	
	
	
	
	
	
	public  function createbarmenu($recipe_id)
	{
		if(!isset($recipe_id))
			redirect('recipes/overview');

		$data=array(
			'recipe'=>$this->recipes_model->get_recipe($recipe_id),
			'recipe_id'=>$recipe_id,
			'create_type'=>'barmenu'
		);
		$this->load->view('recipes_create',$data);
	}

	public function addrecipe($main_menu_id){
		$sub_result=$this->user_model->check_subscription($_SESSION['user_id']);

		if(!empty($sub_result)){
			if($_SESSION['is_alacalc_recipe']==1){
				$reciep_name="Untitled Recipe";
				$data=array(
					"recipes"=>array(
						"name"=>$reciep_name,
						"quantity_per_serving"=>100,
						"weight_loss"=>0
					)
				);
				$result = $this->aalcalc_model->create_recipe(json_encode($data));
				
				$aalcalc_recipe_id=$result['recipes']['id'];
				if($aalcalc_recipe_id){

					$user=$this->user_model->get_user($_SESSION['user_id']);
					$usertype=$user['usertype'];
					$restauranttype=$user['restauranttype'];
					if($restauranttype=='both')
						$restauranttype="";
					
					$r=$this->recipes_model;
					$r->alacal_recipe_id=$aalcalc_recipe_id;
					if(isset($_GET['subscription_id']))
						$r->subscription_id=$_GET['subscription_id'];
					$r->name=$reciep_name;
					$r->logged_user_id=$_SESSION['user_id'];
					$r->recipe_type=$restauranttype;
					$r->main_menu_id=$main_menu_id;
					$r->is_active=0;
					$recipe_id=$r->add();

					if(isset($recipe_id)){
						$new_recipe_name=$reciep_name."-".$recipe_id;
						/*$a=$this->recipes_model;
						$a->id=$recipe_id;
						$s->name=$new_recipe_name;
						$s->update();*/

						$data=array(
							"recipes"=>array(
								"name"=>$new_recipe_name,
								"quantity_per_serving"=>100,
								"weight_loss"=>0
							)
						);
						$recipe_details = $this->recipes_model->update_alacalc_recipe($aalcalc_recipe_id,$recipe_id);
					
						$result = $this->aalcalc_model->update_recipe($aalcalc_recipe_id,json_encode($data));
					}

					if($main_menu_id==1)
						redirect('recipes/create/'.$recipe_id.'?from=addrecipe');
					else
						redirect('recipes/createbarmenu/'.$recipe_id.'?from=addrecipe');
						
				}	
			}
			else{
				$reciep_name="Untitled Recipe";
				$data=array(
					"recipes"=>array(
						"name"=>$reciep_name,
						"quantity_per_serving"=>100,
						"weight_loss"=>0
					)
				);
				
				$user=$this->user_model->get_user($_SESSION['user_id']);
				$usertype=$user['usertype'];
				$restauranttype=$user['restauranttype'];
				if($restauranttype=='both')
					$restauranttype="";
				
				$r=$this->recipes_model;
				$r->alacal_recipe_id="";
				if(isset($_GET['subscription_id']))
					$r->subscription_id=$_GET['subscription_id'];
				$r->name=$reciep_name;
				$r->logged_user_id=$_SESSION['user_id'];
				$r->recipe_type=$restauranttype;
				$r->main_menu_id=$main_menu_id;
				$r->is_active=0;
				$recipe_id=$r->add();

				if(isset($recipe_id)){
					$new_recipe_name=$reciep_name."-".$recipe_id;
					
					$r=$this->recipes_model;
			        $r->declaration_name=$declaration_names;
			        $r->id=$recipe_id;
			        $r->update();
				}

				if($main_menu_id==1)
					redirect('recipes/create/'.$recipe_id.'?from=addrecipe');
				else
					redirect('recipes/createbarmenu/'.$recipe_id.'?from=addrecipe');	
			}
		}else{
			redirect('payment?redirect=createrecipe&main_menu_id='.$main_menu_id);
		}

	}

	public function create_payment_intent(){

		$rawData = file_get_contents("php://input");
		$rawData=json_decode($rawData,true);

        require_once('application/libraries/stripe-php/init.php');

        \Stripe\Stripe::setApiKey($this->config->item('stripe_secret'));

        $pub_key = $this->config->item('stripe_key');

        // Create or use a preexisting Customer to associate with the payment
        $customer = \Stripe\Customer::create([
        	'name'=>$rawData['name'],
        	'email'=>$rawData['email'],
		  	'description' => 'My First Test Customer',
		  	'address' => [
			    'line1' => $rawData['line1'],
			    'postal_code' => $rawData['postal'],
			    'city' => $rawData['city'],
			    'state' =>$rawData['state'],
			    'country' => $rawData['country']
			]
		]);

        // Create a PaymentIntent with the order amount and currency and the customer id
        $payment_intent = \Stripe\PaymentIntent::create([
          	'description' => $rawData['msg'],
			'shipping' => [
				'name' => $rawData['name'],
				'address' => [	
					'line1' => $rawData['line1'],
				    'postal_code' => $rawData['postal'],
				    'city' => $rawData['city'],
				    'state' =>$rawData['state'],
				    'country' => $rawData['country']
				],
			],
          	"amount" => $rawData['amount'],
          	"currency" => 'usd',
          	"customer" => $customer->id,
          	'payment_method_types' => ['card'],
        ]);
        
        // Send publishable key and PaymentIntent details to client
        echo json_encode(array('publicKey' => $pub_key, 'clientSecret' => $payment_intent->client_secret, 'id' => $payment_intent->id));
    }

    public function save_payment_object(){
    	$response=file_get_contents("php://input");
		$rawData=json_decode($response,true);
		
		$to_date=date('Y-m-d', strtotime("+".$rawData['period']." months"));
		$s=$this->subscription_model;
		$s->user_id=$_SESSION['user_id'];
		$s->from_date=date('Y-m-d');
		if($rawData['period']!="perrecipe")
			$s->to_date=$to_date;
		$s->amount=$rawData['amount'];
		$s->payment_status=$rawData['status'];
		$s->payment_id=$rawData['id'];
		$s->period=$rawData['period'];
		$s->payment_response=$response;
		$subscription_id=$s->add();
		
		if($rawData['is_new_user']==0 && $rawData['period']!="perrecipe")
		{
			$this->user_model->update_user_paymenydate($_SESSION['user_id'],$to_date,$subscription_id,$rawData['period']);
		}else{
			$this->user_model->update_user_subscrition_id($_SESSION['user_id'],$subscription_id);
		}
		

		echo json_encode(array('id' => $subscription_id,'period'=>$rawData['period']));
    }

    public function active_inactive_recipe(){
		
		
		$r=$this->recipes_model;
		$r->id=$_POST['id'];
		if($_POST['is_recipe_active']=="on")
			$r->is_recipe_active=1;
		else
			$r->is_recipe_active=0;
		$recipe_id=$r->update();
		$this->json_output(array('status'=>true));
	}

	public function delete_recipe(){
		
		$r1=$this->recipes_model;
		$r1->id=$_POST['id'];
		$recipe_details=$r1->get();
		/*echo "<pre>";
		print_r($recipe_details);
		die;*/
		if(isset($_POST['isadded_for_restaurant']) && $_POST['isadded_for_restaurant']==1){
			
			$this->recipes_model->update_ref_recipe($recipe_details['ref_recipe_id']);

			$r=$this->recipes_model;
			$r->id=$_POST['id'];
			$r->is_delete=1;
			$recipe_id=$r->update();
		}
		else if($recipe_details['is_menu_fromrestaurant']==1){
		    /*$r2=$this->recipes_model;
			$r2->id=$recipe_details['ref_recipe_id'];
			$r2->is_menu_fromrestaurant=0;
			$recipe_id=$r2->update();*/

			$r=$this->recipes_model;
			$r->id=$_POST['id'];
			$r->is_delete=1;
			$recipe_id=$r->update();

		}else{

			$r=$this->recipes_model;
			$r->id=$_POST['id'];
			$r->is_delete=1;
			$recipe_id=$r->update();
		}
		$this->json_output(array('status'=>true));
	}

	public function get_recipe($recipe_id){
		$recipe=$this->recipes_model->get_recipe($recipe_id);
		$user=$this->user_model->get_user($_SESSION['user_id']);
		$usertype=$user['usertype'];
		$restauranttype=$user['restauranttype'];

		$this->json_output(array('status'=>true,'recipe'=>$recipe,'usertype'=>$usertype,'restauranttype'=>$restauranttype));
		
	}

	public function list_recipes(){
		if(isset($_POST['group_id']) && isset($_POST['main_menu_id']))
			$recipe=$this->recipes_model->list_recipes($_POST['page'],$_POST['per_page'],$_POST['group_id'],$_POST['main_menu_id']);
		else if(isset($_POST['group_id']))
			$recipe=$this->recipes_model->list_recipes($_POST['page'],$_POST['per_page'],$_POST['group_id']);
		else
			$recipe=$this->recipes_model->list_recipes($_POST['page'],$_POST['per_page']);

		$this->json_output($recipe);
	}

	public function list_groupnot_recipes(){
		$recipe=$this->recipes_model->list_groupnot_recipes($_POST['page'],$_POST['per_page']);
		$this->json_output($recipe);
	}


	public function delete_recipe_price(){
		
		$r=$this->recipes_model;
		$r->id=$_POST['recipe_id'];
		if($_POST['sequence']==1){
			$r->price1="";
			$r->quantity1="";
		}
		if($_POST['sequence']==2){
			$r->price2="";
			$r->quantity2="";
		}
		if($_POST['sequence']==3){
			$r->price3="";
			$r->quantity3="";
		}
		$r->update();

		if($_POST['recipe_id']){
		    $this->json_output(array('status'=>true,'recipe_id'=>$_POST['recipe_id']));
		}
		else{
			$this->json_output(array('status'=>false,'msg'=>"something went wrong"));
		}
	}

	public function save_recipe_header(){
		
		if(!isset($_POST['group_id']) || $_POST['group_id']==""){
			$m=$this->menu_group_model;
			$m->title=ucfirst(strtolower($_POST['group_name']));
			$m->logged_user_id=$_SESSION['user_id'];
			$m->main_menu_id=$_POST['main_menu_id'];
			$group_details=$m->check_group_name($_POST['group_name'],$_SESSION['user_id']);

			if(!empty($group_details)){
				$menu_group_id=$group_details['id'];
			}
			else
				$menu_group_id=$m->add();
		}else{
			$menu_group_id=$_POST['group_id'];
		}

		$r=$this->recipes_model;
		$r->id=$_POST['recipe_id'];
		$r->group_id=$menu_group_id;
		$r->main_menu_id=$_POST['main_menu_id'];
		if(isset($_POST['price']))
			$r->price=number_format((float)$_POST['price'], 2, '.', '');
		if(isset($_POST['quantity']))
			$r->quantity=$_POST['quantity'];
		if(isset($_POST['price1']))
			$r->price1=$_POST['price1'];
		if(isset($_POST['quantity1']))
			$r->quantity1=$_POST['quantity1'];
		if(isset($_POST['price2']))
			$r->price2=$_POST['price2'];
		if(isset($_POST['quantity2']))
			$r->quantity2=$_POST['quantity2'];
		if(isset($_POST['price3']))
			$r->price3=$_POST['price3'];
		if(isset($_POST['quantity3']))
			$r->quantity3=$_POST['quantity3'];
		$r->is_bar_menu=1;
		$r->update();
		
		$this->recipes_model->make_active($_POST['recipe_id']);

		if($menu_group_id){
		    $this->json_output(array('status'=>true,'menu_group_id'=>$menu_group_id));
		}
		else{
			$this->json_output(array('status'=>false,'msg'=>"something went wrong"));
		}
	}

	public function save_menu_group(){
		
		if(!isset($_POST['group_id'])){
			$m=$this->menu_group_model;
			$m->title=ucfirst(strtolower($_POST['group_name']));
			$m->logged_user_id=$_SESSION['user_id'];
			$m->main_menu_id=$_POST['main_menu_id'];
			$group_details=$m->check_group_name($_POST['group_name'],$_SESSION['user_id']);
			if(!empty($group_details)){
				$menu_group_id=$group_details['id'];
			}
			else
				$menu_group_id=$m->add();
		}else{
			$menu_group_id=$_POST['group_id'];
		}
	
		if($menu_group_id){
			$r=$this->recipes_model;
			$r->id=$_POST['recipe_id'];
			$r->group_id=$menu_group_id;
			$r->main_menu_id=$_POST['main_menu_id'];
			if(isset($_POST['best_time_to_eat'])){
				$r->best_time_to_eat=implode(',', $_POST['best_time_to_eat']);
			}
			$r->update();
		}
		$this->recipes_model->make_active($_POST['recipe_id']);

		if($menu_group_id){
		    $this->json_output(array('status'=>true,'menu_group_id'=>$menu_group_id));
		}
		else{
			$this->json_output(array('status'=>false,'msg'=>"something went wrong"));
		}
	}

	public function update_recipe(){
		
		if($_SESSION['is_alacalc_recipe']==1){
			$data=array(
				"id"=>$_POST['alacalc_recipe_id'],
				"recipes"=>array(
					"name"=>$_POST['name']."-".$_POST['id'],
					"quantity_per_serving"=>$_POST['quantity_per_serving'],
					"weight_loss"=>$_POST['weight_loss']
				)
			);
			$result = $this->aalcalc_model->update_recipe($_POST['alacalc_recipe_id'],json_encode($data));
			if($result['recipes']){
				$r=$this->recipes_model;
				$r->set_values($_POST);
				$r->update();
				$recipe_id=$_POST['id'];
			}
		}
		else{
			$r=$this->recipes_model;
				$r->set_values($_POST);
				$r->update();
				$recipe_id=$_POST['id'];
		}

		$this->recipes_model->make_active($recipe_id);

		if($_SESSION['is_alacalc_recipe']==1){
			$this->recipes_model->update_alacalc_recipe($_POST['alacalc_recipe_id'],$recipe_id);
		}
		if($recipe_id){
		    $this->json_output(array('status'=>true,'id'=>$_POST['id']));
		}
		else{
			$this->json_output(array('status'=>false,'msg'=>"something went wrong"));
		}
	}

	public function list_groups($main_menu_id=""){
		$menu_groups=$this->menu_group_model->list_groups($main_menu_id);
		echo json_encode($menu_groups);
	}

	public  function nutrition($recipe_id)
	{
		$data=array(
			'recipe'=>$this->recipes_model->get_recipe($recipe_id),
			'recipe_id'=>$recipe_id,
			'create_type'=>'restmenu'
		);
		$this->load->view('recipe_nutrition',$data);
	}

	public  function output()
	{
		$data=array();
		$this->load->view('recipe_output',$data);
	}
}
?>