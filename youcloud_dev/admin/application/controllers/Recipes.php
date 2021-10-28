<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'third_party/aws/aws-autoloader.php';
use Aws\Common\Exception\MultipartUploadException;
use Aws\S3\MultipartUploader;
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

class Recipes extends MY_Controller 
{	
	public function __construct() 
	{
		parent::__construct();
		//$this->is_loggedin();
		$this->load->model('recipes_model');
		$this->load->model('aalcalc_model');
		$this->load->model('ingredient_items_model');
		$this->load->model('ingredient_model');
		$this->load->model('ingredient_weights_model');
		$this->load->model('menu_group_model');
		$this->load->model('subscription_model');
		$this->load->model('mainmenu_model');
		$this->load->model('user_model');
		$this->load->model('recipe_image_model');
		$this->load->model('recipe_price_model');
		$this->load->model('waiting_manager_model');
		$this->load->library("session");
       	$this->load->helper('url');
	}	

	// added by victor 
	public function save_price(){
		$rawData = file_get_contents("php://input");
		$rawData=json_decode($rawData,true);
		$rawData['date_created'] = date('Y-m-d H:i:s');
		
		$query =  $this->recipes_model->saveOldPrice($rawData);

		if ($query !== "error") {
			$this->json_output(array('status'=>true, 'data' => $rawData));
		}else{
			$this->json_output(array('status'=>false, 'message' => $query));
		}
	}

	public function get_price_purchase_count($from, $to, $id){
		$results = $this->recipes_model->getPriceSalesCount($id, $from, $to);

		if ($results) {
			$this->json_output([ 
				"status" => true,
				"data" => $results,
			]);
		}else{
			$this->json_output([
				"status" => false,
				"data" => null,
				"message" => "no result found"
			]);
		}
	}

	// edit ended here 

	public function checkloginuser()
	{	
		$email =$_POST['email'];
        $pass = $_POST['password'];
		$result = $this->user_model->do_login($email, $pass);
	
		if(is_array($result))
		{
		    $this->json_output(array('status'=>true,'msg'=>$result['name']." you are successfully logged in.",'usertype'=>$result['usertype']));
		}
		else if($result=="notactivated")
		{
			$this->json_output(array('status'=>false,'msg'=>'Your account is deactivate, please contact Youcloud Support.'));
		}
		else
		{
			$this->json_output(array('status'=>false,'msg'=>"The username or password you entered is incorrect"));
		}
	}
	
	public function index() 
	{
		$this->load->view('home');
	}

	public  function overview()
	{
		$data=array(
			'group_not_recipescnt'=>$this->recipes_model->groupnot_recipe_count(),
			'mainmenu'=>$this->mainmenu_model->listmain_menu()
		);
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		$this->load->view('recipe_list',$data);
	}
	
	public  function barmenus()
	{
		$data=array(
			/*'recipes'=>$this->recipes_model->list_recipes()*/
		);
		
		$this->load->view('recipe_bar_list',$data);
	}

	public  function group_not_selected()
	{
		$data=array(
			/*'recipes'=>$this->recipes_model->list_recipes()*/
		);
		
		$this->load->view('group_not_selected',$data);
	}
	
	public function getmainmenu(){
		$menu = $this->waiting_manager_model->select_where('menu_master',['restaurant_id'=>$_SESSION['user_id'],'is_active'=>1]);
		$this->json_output($menu);
	}
	
	public function save_main_menu_id(){
		if($this->waiting_manager_model->updateactive_inactive('recipes',['id'=>$_POST['recipe_id']],['main_menu_id'=>$_POST['main_menu_id'],'group_id'=>NULL])){
			$this->json_output(['status'=>true]);
		}else{
			$this->json_output(['status'=>false]);
		}
	}

	public  function create($recipe_id)
	{
		if(!isset($recipe_id))
			redirect('recipes/overview');
		
		$data=array(
			'recipe'=>$this->recipes_model->get_recipe($recipe_id),
			'table_cats'=>$this->user_model->list_rest_tblcategories($_SESSION['user_id']),
			'recipe_id'=>$recipe_id,
			'create_type'=>'restmenu'
		);
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		$sql = "SELECT ra.*,am.menu_group_id,am.addon_name
		FROM recipe_addon AS ra
		LEFT JOIN addon_menu AS am on am.id = ra.addon_id
		WHERE ra.recipe_id =".$recipe_id.' AND am.is_delete = 0';
		$data['addon_menu'] = $this->waiting_manager_model->query($sql);
		
		$data['all_addon_menus'] = $this->waiting_manager_model->select_where('addon_menu',['menu_group_id'=>$data['recipe']['group_id'],'is_delete'=>0]);
		//echo "<pre>";
		//print_r($data);exit();
		$this->load->view('recipes_create',$data);
	}

	public function delete_previous_recipe_addon(){
		$this->waiting_manager_model->permanent_delete_manager('recipe_addon',['id'=>$_POST['id']]);
		echo json_encode(['status'=>true]);
	}

	public function list_table_categories()
	{
		$table_categories=$this->user_model->list_rest_tblcategories($_SESSION['user_id']);
		echo json_encode($table_categories);
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

	public function addrecipe($main_menu_id)
	{
		/* $sub_result=$this->user_model->check_subscription($_SESSION['user_id']);

		if(!empty($sub_result))
		{ */
			if($_SESSION['is_alacalc_recipe']==1)
			{
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
				
				if($aalcalc_recipe_id)
				{
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

					if(isset($recipe_id))
					{
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

					/*if($main_menu_id==1)*/
						redirect('recipes/create/'.$recipe_id.'?from=addrecipe');
					/*else
						redirect('recipes/createbarmenu/'.$recipe_id.'?from=addrecipe');*/
				}	
			}
			else
			{
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
				$r->alacal_recipe_id=0;
				$r->is_active=0;
				$recipe_id=$r->add();
				
				if(isset($recipe_id))
				{
					$new_recipe_name=$reciep_name."-".$recipe_id;
					
					$r=$this->recipes_model;
			        $r->declaration_name=$declaration_names;
			        $r->id=$recipe_id;
			        $r->update();
				}

				/*if($main_menu_id==1)*/
					redirect('recipes/create/'.$recipe_id.'?from=addrecipe');
				/*else
					redirect('recipes/createbarmenu/'.$recipe_id.'?from=addrecipe');*/	
			}
		/* }
		else
		{
			redirect('payment?redirect=createrecipe&main_menu_id='.$main_menu_id);
		} */
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
		$table_categories=$this->user_model->list_rest_tblcategories($_SESSION['user_id']);
		$usertype=$user['usertype'];
		$restauranttype=$user['restauranttype'];

		$this->json_output(array('status'=>true,'recipe'=>$recipe,'usertype'=>$usertype,'restauranttype'=>$restauranttype,'table_categories'=>$table_categories));
		
	}

	public function get_recipe_prices(){
		$recipe_id=$_POST['id'];
		$recipe_data=$this->recipe_price_model->list_recipe_prices($recipe_id);

		$this->json_output(array('status'=>true,'recipe'=>$recipe_data));
		
	}

	public function list_recipes(){
		if($_POST['main_menu_id'] != 'New'){
			if(isset($_POST['group_id']) && isset($_POST['main_menu_id']) && isset($_POST['searchkey'])){
				$recipe=$this->recipes_model->list_recipes($_POST['page'],$_POST['per_page'],$_POST['group_id'],$_POST['main_menu_id'],$_POST['searchkey']);
			}
			else if(isset($_POST['group_id']) && isset($_POST['main_menu_id']) && !isset($_POST['searchkey']))
				$recipe=$this->recipes_model->list_recipes($_POST['page'],$_POST['per_page'],$_POST['group_id'],$_POST['main_menu_id']);
			else if(isset($_POST['group_id']) && !isset($_POST['main_menu_id']) && !isset($_POST['searchkey']))
				$recipe=$this->recipes_model->list_recipes($_POST['page'],$_POST['per_page'],$_POST['group_id']);
			else{
				$recipe=$this->recipes_model->list_recipes($_POST['page'],$_POST['per_page']);
			}
		}else{
			if(isset($_POST['searchkey'])){
				$recipe=$this->recipes_model->list_recipes_for_new($_POST['page'],$_POST['per_page'],$_POST['searchkey']);
			}
			else{
				$recipe=$this->recipes_model->list_recipes_for_new($_POST['page'],$_POST['per_page']);
			}
		}

		$this->json_output($recipe);
	}

	public function list_groupnot_recipes(){
		$recipe=$this->recipes_model->list_groupnot_recipes($_POST['page'],$_POST['per_page']);
		$this->json_output($recipe);
	}


	public function delete_recipe_price(){
		
		/*$r=$this->recipes_model;
		$r->id=$_POST['recipe_id'];*/
/*echo "<pre>";
print_r($_POST);
die;*/
		if(isset($_POST['recipe_price_id'])){
			$rp=$this->recipe_price_model;
			$rp->id=$_POST['recipe_price_id'];
			$rp->delete();
		}
		/*if($_POST['sequence']==1){
			$array=array('price1'=>null,'quantity1'=>'');
		}
		if($_POST['sequence']==2){
			$array=array('price2'=>null,'quantity2'=>'');
		}
		if($_POST['sequence']==3){
			$array=array('price3'=>null,'quantity3'=>'');

		}*/
		/*$r->update();*/

		$prices=$this->recipe_price_model->list_recipe_prices($_POST['recipe_id']);
		/*$this->recipes_model->update_recipe_price($_POST['recipe_id'],$array);*/

		if($_POST['recipe_id']){
		    $this->json_output(array('status'=>true,'recipe_id'=>$_POST['recipe_id'],'prices'=>$prices,'price_count'=>count($prices)));
		}
		else{
			$this->json_output(array('status'=>false,'msg'=>"something went wrong"));
		}
	}

	public function save_recipe_header()
	{
		foreach($_POST as $x => $val) 
		{
			$_POST[$x]=filter_var($_POST[$x], FILTER_SANITIZE_STRING);
		}
		
		if(!isset($_POST['group_id']) || $_POST['group_id']=="")
		{
			$m=$this->menu_group_model;
			$m->title=ucwords(strtolower($_POST['group_name']));
			$m->logged_user_id=$_SESSION['user_id'];
			$m->main_menu_id=$_POST['main_menu_id'];
			$group_details=$m->check_group_name($_POST['group_name'],$_SESSION['user_id']);

			if(!empty($group_details))
			{
				$menu_group_id=$group_details['id'];
			}
			else
			{
				$menu_group_id=$m->add();
			}
		}
		else
		{
			$menu_group_id=$_POST['group_id'];
		}

		$r=$this->recipes_model;
		$r->id=$_POST['recipe_id'];
		$r->group_id=$menu_group_id;
		$r->main_menu_id=$_POST['main_menu_id'];
		
		if(isset($_POST['description']))
			$r->description=$_POST['description'];
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
		$r->product_code=$_POST['pcode'];
		$r->is_addon_menu=$_POST['is_addon'];

		$r->update();
		
		$this->recipes_model->make_active($_POST['recipe_id']);

		if($menu_group_id){
		    $this->json_output(array('status'=>true,'menu_group_id'=>$menu_group_id));
		}
		else{
			$this->json_output(array('status'=>false,'msg'=>"something went wrong"));
		}
	}

	public function update_recipe_price(){
		
		
		$r=$this->recipes_model;
		$r->id=$_POST['id'];
		if(isset($_POST['price']))
			$r->price=number_format((float)$_POST['price'], 2, '.', '');
		if(isset($_POST['quantity']))
			$r->quantity=$_POST['quantity'];
		/*if(isset($_POST['price1']))
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
			$r->quantity3=$_POST['quantity3'];*/
		for($i=0;$i<=$_POST['recipe_price_count'];$i++){
			if($i==0){
				$rp=$this->recipe_price_model;
				$rp->recipe_id=$_POST['id'];
				$rp->price=$_POST['price'];
				$rp->table_category_id=$_POST['quantity'];
				$rp->is_default=1;
				if($_POST['recipe_price_id']!=""){
					$rp->id=$_POST['recipe_price_id'];
					$rp->update();
				}else{
					$rp->add();
				}
			}else{
				$rp=$this->recipe_price_model;
				$rp->recipe_id=$_POST['id'];
				$rp->price=$_POST['price'.$i];
				$rp->table_category_id=$_POST['quantity'.$i];
				if($_POST['recipe_price_id'.$i]!=""){
					$rp->id=$_POST['recipe_price_id'.$i];
					$rp->update();
				}else{
					$rp->add();
				}
			}
		}
		$r->update();
		
		if($_POST['id']){
		    $this->json_output(array('status'=>true,'id'=>$_POST['id']));
		}
		else{
			$this->json_output(array('status'=>false,'msg'=>"something went wrong"));
		}
	}


	public function save_menu_group()
	{
		foreach($_POST as $x => $val) 
		{
			$_POST[$x]=filter_var($_POST[$x], FILTER_SANITIZE_STRING);
		}
		
		if(!isset($_POST['group_id']) || $_POST['group_id']=="")
		{
			$m=$this->menu_group_model;
			$m->title=ucfirst(strtolower($_POST['group_name']));
			$m->logged_user_id=$_SESSION['user_id'];
			$m->main_menu_id=$_POST['main_menu_id'];
			$group_details=$m->check_group_name($_POST['group_name'],$_SESSION['user_id']);
			
			if(!empty($group_details))
			{
				$menu_group_id=$group_details['id'];
			}
			else
			{
				$menu_group_id=$m->add();
			}
		}
		else
		{
			$menu_group_id=$_POST['group_id'];
		}
		
		if($menu_group_id)
		{
			$r=$this->recipes_model;
			$r->id=$_POST['recipe_id'];
			$r->group_id=$menu_group_id;
			$r->main_menu_id=$_POST['main_menu_id'];
			
			if(isset($_POST['best_time_to_eat']) && $_POST['best_time_to_eat']!="")
			{
				if(is_array($_POST['best_time_to_eat']))
					$r->best_time_to_eat=implode(',',$_POST['best_time_to_eat']);
				else
					$r->best_time_to_eat=$_POST['best_time_to_eat'];
			}
			
			if(isset($_POST['description']))
				$r->description=$_POST['description'];
			$r->update();
		}
		
		$this->recipes_model->make_active($_POST['recipe_id']);

		if($menu_group_id)
		{
			$get_addon_list = $this->waiting_manager_model->select_where('addon_menu',['menu_group_id'=>$menu_group_id]);
		    $this->json_output(array('status'=>true,'menu_group_id'=>$menu_group_id,'get_addon_list'=>$get_addon_list));
		}
		else
		{
			$this->json_output(array('status'=>false,'msg'=>"something went wrong"));
		}
	}

	public function save_recipe_prices()
	{
		//print_r($_POST);exit();
		foreach($_POST as $x => $val) 
		{
			$_POST[$x]=filter_var($_POST[$x], FILTER_SANITIZE_STRING);
		}
		
		if(!isset($_POST['group_id']) || $_POST['group_id']=="")
		{
			$m=$this->menu_group_model;
			$m->title=ucwords(strtolower($_POST['group_name']));
			$m->logged_user_id=$_SESSION['user_id'];
			$m->main_menu_id=$_POST['main_menu_id'];
			$group_details=$m->check_group_name($_POST['group_name'],$_SESSION['user_id']);
			
			if(!empty($group_details))
			{
				$menu_group_id=$group_details['id'];
			}
			else
			{
				$menu_group_id=$m->add();
			}
		}
		else
		{
			$menu_group_id=$_POST['group_id'];
		}
		
		if($menu_group_id)
		{
			$r=$this->recipes_model;
			$r->id=$_POST['recipe_id'];
			$r->group_id=$menu_group_id;
			$r->main_menu_id=$_POST['main_menu_id'];
			
			if(isset($_POST['best_time_to_eat']) && $_POST['best_time_to_eat']!="")
			{
				if(is_array($_POST['best_time_to_eat']))
					$r->best_time_to_eat=implode(',',$_POST['best_time_to_eat']);
				else
					$r->best_time_to_eat=$_POST['best_time_to_eat'];

			}
			
			if(isset($_POST['description']))
				$r->description=$_POST['description'];
			
			if(isset($_POST['price']))
				$r->price=number_format((float)$_POST['price'], 2, '.', '');
			
			if(isset($_POST['quantity']))
				$r->quantity=$_POST['quantity'];
			
			if(isset($_POST['pcode']))
				$r->product_code=$_POST['pcode'];
			if(isset($_POST['is_addon']))
				$r->is_addon_menu=$_POST['is_addon'];
			$r->update();

			for($i=0;$i<=$_POST['recipe_price_count'];$i++)
			{
				if($i==0)
				{
					$rp=$this->recipe_price_model;
					$rp->recipe_id=$_POST['recipe_id'];
					$rp->price=$_POST['price'];
					$rp->table_category_id=$_POST['quantity'];
					$rp->is_default=1;
					$r->product_code=$_POST['pcode'];
					$r->is_addon_menu=$_POST['is_addon'];
					
					if($_POST['recipe_price_id']!="")
					{
						$rp->id=$_POST['recipe_price_id'];
						$rp->update();
					}
					else
					{
						$rp->add();
					}
				}
				else
				{
					$rp=$this->recipe_price_model;
					$rp->recipe_id=$_POST['recipe_id'];
					$rp->price=$_POST['price'.$i];
					$rp->table_category_id=$_POST['quantity'.$i];
					
					if($_POST['recipe_price_id'.$i]!="")
					{
						$rp->id=$_POST['recipe_price_id'.$i];
						$rp->update();
					}
					else
					{
						$rp->add();
					}
				}
			}
		}
		// echo $this->db->last_query();exit();
		$this->recipes_model->make_active($_POST['recipe_id']);

		if($menu_group_id)
		{
			/* $addon_id_array = $_POST['recipe_addon_id']; */
			$addon_id_array = explode(',',$_POST['addon_array_data']);
			
			if(!empty($addon_id_array))
			{
				if($_POST['add_addon'] == 'Add')
				{
					for ($i=0; $i < count($addon_id_array); $i++) 
					{
						$this->waiting_manager_model->insert_any_query('recipe_addon',['recipe_id'=>$_POST['recipe_id'],'addon_id'=>$addon_id_array[$i]]);
					}
				}
				else
				{
					$this->waiting_manager_model->permanent_delete_manager('recipe_addon',['recipe_id'=>$_POST['recipe_id']]);
					
					for ($i=0; $i < count($addon_id_array); $i++) 
					{
						$this->waiting_manager_model->insert_any_query('recipe_addon',['recipe_id'=>$_POST['recipe_id'],'addon_id'=>$addon_id_array[$i]]);
					}
				}
			}
		    $this->json_output(array('status'=>true,'menu_group_id'=>$menu_group_id));
		}
		else
		{
			$this->json_output(array('status'=>false,'msg'=>"something went wrong"));
		}
	}

	public function save_recipe_items()
	{
		foreach($_POST as $x => $val) 
		{
			$_POST[$x]=filter_var($_POST[$x], FILTER_SANITIZE_STRING);
		}
		
		$arr=explode('-', $_POST['long_desc']);
		$_POST['long_desc']=$arr[0];

		$in=$this->ingredient_model;
		$status=$in->isexist(array('alacalc_id'=>$_POST['ingredientId']));
		
		if($status!="exist")
		{
			$in->long_desc=$_POST['long_desc'];
			$in->declaration_name=$_POST['declaration_name'];
			$in->created_at=date('Y-m-d H:i:s');
			$in->data_source=$_POST['data_source'];
			$in->alacalc_id=$_POST['alacalc_recipe_id'];
			$in->add();
		}

		/* $arr=explode('-', $_POST['ingredient_data']['long_desc']);
		$_POST['ingredient_data']['long_desc']=$arr[0];

		$in=$this->ingredient_model;
		$status=$in->isexist(array('alacalc_id'=>$_POST['ingredient_data']['id']));
		
		if($status!="exist")
		{
			$in->long_desc=$_POST['ingredient_data']['long_desc'];
			$in->declaration_name=$_POST['ingredient_data']['declaration_name'];
			$in->created_at=date('Y-m-d H:i:s');
			$in->data_source=$_POST['ingredient_data']['data_source'];
			$in->alacalc_id=$_POST['ingredient_data']['id'];
			$in->add();
		} */

		/*$i=$this->ingredient_items_model;
		$i->ingredient_id=$_POST['ingredient_id'];
		$i->recipe_id=$_POST['recipe_id'];
		$status=$i->isexist(array('ingredient_id'=>$_POST['ingredient_id'],'recipe_id'=>$_POST['recipe_id']));
		if($status!="exist"){*/
		
		if($_SESSION['is_alacalc_recipe']==1)
		{
			$data=array(
				'recipe_id'=>$_POST['alacalc_recipe_id'],
				'ingredient_items'=>array(
					'ingredient_id'=>$_POST['ingredient_id'],
					'quantity'=>$_POST['quantity'],
					'quantity_unit_id'=>$_POST['quantity_unit_id']
				)
			);
			
			$result = $this->aalcalc_model->add_ingredient_items($_POST['alacalc_recipe_id'],json_encode($data));
			
			if(isset($result['ingredient_items']))
			{
				$alacalc_item_id=$result['ingredient_items']['id'];
				$i=$this->ingredient_items_model;
				$i->alacalc_item_id=$alacalc_item_id;
				$i->ingredient_id=$_POST['ingredient_id'];
				$i->recipe_id=$_POST['recipe_id'];
				$i->quantity=$_POST['quantity'];
				$i->quantity_unit_id=$_POST['quantity_unit_id'];
				$i->long_desc=$_POST['ingredient_data']['long_desc'];
				$i->declaration_name=$_POST['ingredient_data']['declaration_name'];
				$i->data_source=$_POST['ingredient_data']['data_source'];
				$i->quantity_unit=json_encode($_POST['quantity_unit']);
							
				/*if(isset($_POST['id'])){
					$i->id=$_POST['id'];
					$i->update();
					$id=$_POST['id'];
				}else{*/
					$id=$i->add();
				//}
			}
		}
		else
		{
			$alacalc_item_id="0";
			$i=$this->ingredient_items_model;
			$i->alacalc_item_id=$alacalc_item_id;
			$i->ingredient_id=$_POST['ingredient_id'];
			$i->recipe_id=$_POST['recipe_id'];
			$i->quantity=$_POST['quantity'];
			$i->quantity_unit_id=$_POST['quantity_unit_id'];
			$i->long_desc=$_POST['ingredient_data']['long_desc'];
			$i->declaration_name=$_POST['ingredient_data']['declaration_name'];
			$i->data_source=$_POST['ingredient_data']['data_source'];
			$i->quantity_unit=json_encode($_POST['quantity_unit']);

			/*if(isset($_POST['id'])){
				$i->id=$_POST['id'];
				$i->update();
				$id=$_POST['id'];
			}else{*/
				$id=$i->add();
			//}
		}
		
		$this->ingredient_items_model->update_recipe_ingredient($_POST['recipe_id']);

		$weights=$_POST['ingredient_data']['weights'];
		
		if($weights)
		{
			foreach ($weights as $weight) 
			{
				$w=$this->ingredient_weights_model;
				$status=$w->isexist(array('description'=>$weight['desc'],'ingredient_id'=>$_POST['ingredient_id']));
				
				if($status!="exist")
				{
					$w->description=$weight['desc'];
					$w->ingredient_id=$_POST['ingredient_id'];
					$w->amount=$weight['amount'];
					$w->gm_wgt=$weight['gm_wgt'];
					$w->alacalc_id=$weight['id'];
					$w->add();
				}
			}
		}
		
		if($_SESSION['is_alacalc_recipe']==1)
		{
			$this->recipes_model->update_alacalc_recipe($_POST['alacalc_recipe_id'],$_POST['recipe_id']);
		}
		
		if($id)
		{
		    $this->json_output(array('status'=>true,'id'=>$id,'alacalc_item_id'=>$alacalc_item_id));
		}
		else
		{
			$this->json_output(array('status'=>false,'msg'=>"something went wrong"));
		}
		/*}else{
			$this->json_output(array('status'=>false,'msg'=>"Ingredient Already Exist"));
		}*/
	}

	public function delete_ingredient_item()
	{
		if($_SESSION['is_alacalc_recipe']==1)
		{
			$result = $this->aalcalc_model->delete_ingredient_items($_POST['alacalc_item_id'],$_POST['alacalc_recipe_id']);
		}
		
		/*echo "<pre>";
		print_r($result);
		die;*/
		
		$i=$this->ingredient_items_model;
		$i->id=$_POST['id'];
		$status=$i->delete();
		$ingredient_items=$this->ingredient_items_model->list_items($_POST['recipe_id']);
		
		if($status)
		{
		    $this->json_output(array('status'=>true,'ingredient_items'=>$ingredient_items));
		}
		else
		{
			$this->json_output(array('status'=>false,'msg'=>"something went wrong"));
		}			
	}

	public function update_ingredient_items()
	{
		foreach($_POST as $x => $val) 
		{
			$_POST[$x]=filter_var($_POST[$x], FILTER_SANITIZE_STRING);
		}
		
		if($_SESSION['is_alacalc_recipe']==1)
		{
			$data=array(
				'recipe_id'=>$_POST['alacalc_recipe_id'],
				'id'=>$_POST['alacalc_item_id'],
				'ingredient_items'=>array(
					'ingredient_id'=>$_POST['ingredient_id'],
					'quantity'=>$_POST['quantity'],
					'quantity_unit_id'=>$_POST['quantity_unit_id']
				)
			);

			$result = $this->aalcalc_model->update_ingredient_items($_POST['alacalc_recipe_id'],$_POST['alacalc_item_id'],json_encode($data));
			
			if(isset($result['ingredient_items']))
			{
				$i=$this->ingredient_items_model;
				$i->set_values($_POST);
				$item_id=$i->update();
			}
		}
		else
		{
			$i=$this->ingredient_items_model;
			$i->set_values($_POST);
			$item_id=$i->update();
		}

		$this->ingredient_items_model->update_recipe_ingredient($_POST['recipe_id']);
		
		if($item_id)
		{
		    $this->json_output(array('status'=>true,'item_id'=>$item_id));
		}
		else
		{
			$this->json_output(array('status'=>false,'msg'=>"something went wrong"));
		}
	}

	public function update_recipe_image()
	{
		$r=$this->recipes_model;
	 	
		if(!empty($_POST))
		{
	        if(isset($_POST['image']))
			{
	        	$rand_no=rand(1111111,9999999);
	        	/*if(SERVER=="testing")
					$image_url='test/recipes/'.$rand_no.'.jpg';
				else
					$image_url='recipes/'.$rand_no.'.jpg';*/
				$image_url='Liveresto/recipes/'.$rand_no.'.jpg';
	        	$file_path='uploads/recipes/'.$rand_no.'.jpg';
                $img_r = imagecreatefromjpeg($_POST['image']);
				$output=imagejpeg($img_r,$file_path);
				$aws_result=$this->uploadAWSS3($image_url,$file_path);
				
				$sourceProperties = getimagesize($file_path);
				$thumb_path='uploads/recipes/thumb/'.$rand_no.'.jpg';
				/*if(SERVER=="testing")
					$thumb_url='test/recipes/thumb/'.$rand_no.'.jpg';
				else
					$thumb_url='recipes/thumb/'.$rand_no.'.jpg';*/
				$thumb_url='Liveresto/recipes/thumb/'.$rand_no.'.jpg';
                $tmp = $this->imageResizeRecipe($img_r,$sourceProperties[0],$sourceProperties[1]);
                $output1=imagejpeg($tmp,$thumb_path);
				/*echo "<pre>";
				print_r($output1);
				die;*/
                $aws_result=$this->uploadAWSS3($thumb_url,$thumb_path);
                unlink($thumb_path);
                unlink($file_path);

				if($file_path!="")
				{					
					/*$recipe=$this->recipes_model->get_recipe_withoutingredients($_POST['id']);
					$im=$this->recipe_image_model;
					$im->name=$recipe['name'];
                    $im->img_path=CLOUDFRONTURL.$image_url;
					if($thumb_path!=""){
                    	$im->thumb_path=CLOUDFRONTURL.$thumb_url;
					}
                    $image_id=$im->add();*/
					
					$r=$this->recipes_model;
				/*	$r->recipe_image_id=$image_id;*/
		            
					if($file_path!="")
	                    $r->recipe_image=CLOUDFRONTURL.$image_url;
	                
					if($thumb_path!="")
					{
                    	$r->thumb_path=CLOUDFRONTURL.$thumb_url;
					}
		            
					if($_POST['id']!="")
					{
		                $r->id=$_POST['id'];
		                $r->update();
		                $recipe_id=$_POST['id'];
		            }

		            $this->json_output(array('path'=>CLOUDFRONTURL.$image_url,'status'=>true,'msg'=>'Recipe Photo Updated'));
					return;
				}
				else
				{
					$this->json_output(array('status'=>false,'msg'=>'Something went wrong please try again.'));
					return;
				}
	        }
			
           /* if($_FILES['image']['name']!=""){
                $result = $r->upload_image('image');
                if($result['status']==false){
                    $this->json_output($result);
                    return false;
                }else{
	                if($result['path']!="")
	                    $r->recipe_image=$result['path'];
		            if($_POST['id']!=""){
		                $r->id=$_POST['id'];
		                $r->update();
		                $recipe_id=$_POST['id'];
		            }
        			$this->json_output(array('path'=>$result['path'],'status'=>true,'msg'=>'Recipe Photo Updated'));
        			return;
                }
            }*/
        }
		else
		{
        	$this->json_output(array('status'=>false,'msg'=>'Please select file to upload'));
        }
	}

	public function imageResizeRecipe($imageSrc,$imageWidth,$imageHeight) 
	{
	    $newImageWidth =200;
	    $newImageHeight =200;

	    $newImageLayer=imagecreatetruecolor($newImageWidth,$newImageHeight);
	    imagecopyresampled($newImageLayer,$imageSrc,0,0,0,0,$newImageWidth,$newImageHeight,$imageWidth,$imageHeight);

	    return $newImageLayer;
	}

	public function imageResize($imageSrc,$imageWidth,$imageHeight) 
	{
	    $newImageWidth =200;
	    $newImageHeight =121;

	    $newImageLayer=imagecreatetruecolor($newImageWidth,$newImageHeight);
	    imagecopyresampled($newImageLayer,$imageSrc,0,0,0,0,$newImageWidth,$newImageHeight,$imageWidth,$imageHeight);

	    return $newImageLayer;
	}

	public function upload_file($encoded_string)
	{
	    $target_dir = ''; // add the specific path to save the file
	    $decoded_file = base64_decode($encoded_string); // decode the file
	    $mime_type = finfo_buffer(finfo_open(), $decoded_file, FILEINFO_MIME_TYPE); // extract mime type
	    $extension = mime2ext($mime_type); // extract extension from mime type
	    $file = uniqid() .'.'. $extension; // rename file as a unique name
	    $file_dir = $target_dir . uniqid() .'.'. $extension;
	    
		try 
		{
	        file_put_contents($file_dir, $decoded_file); // save
	        database_saving($file);
	        header('Content-Type: application/json');
	        echo json_encode("File Uploaded Successfully");
	    } 
		catch (Exception $e) 
		{
	        header('Content-Type: application/json');
	        echo json_encode($e->getMessage());
	    }
	}

	public function update_price()
	{
		$r=$this->recipes_model;
		$r->id=$_POST['id'];
		$r->price=$_POST['price'];
		$r->update();
		$recipe_id=$_POST['id'];

		if($recipe_id)
		{
		    $this->json_output(array('status'=>true,'id'=>$_POST['id']));
		}
		else
		{
			$this->json_output(array('status'=>false,'msg'=>"something went wrong"));
		}
	}

	public function update_recipe()
	{
		foreach($_POST as $x => $val) 
		{
			$_POST[$x]=filter_var($_POST[$x], FILTER_SANITIZE_STRING);
		}
		
		/*echo "<pre>";
		print_r($_POST);
		die;*/
		
		$_POST['name']=ucwords($_POST['name']);
		
		if($_SESSION['is_alacalc_recipe']==1)
		{
			$data=array(
				"id"=>$_POST['alacalc_recipe_id'],
				"recipes"=>array(
					"name"=>$_POST['name']."-".$_POST['id'],
					"quantity_per_serving"=>$_POST['quantity_per_serving'],
					"weight_loss"=>$_POST['weight_loss']
				)
			);
			
			$result = $this->aalcalc_model->update_recipe($_POST['alacalc_recipe_id'],json_encode($data));
			
			if($result['recipes'])
			{
				$r=$this->recipes_model;
				$r->set_values($_POST);
				
				if($_POST['group_id']=="")
					$r->group_id=null;
				
				$r->price=number_format((float)$_POST['price'], 2, '.', '');
				$r->update();

				$recipe_id=$_POST['id'];
			}
		}
		else
		{
			$r=$this->recipes_model;
			$r->set_values($_POST);
			
			if($_POST['group_id']=="")
				$r->group_id=null;

			$r->price=number_format((float)$_POST['price'], 2, '.', '');
			$r->update();				
			$recipe_id=$_POST['id'];
		}

		$this->recipes_model->make_active($recipe_id);

		if($_SESSION['is_alacalc_recipe']==1)
		{
			$this->recipes_model->update_alacalc_recipe($_POST['alacalc_recipe_id'],$recipe_id);
		}
		
		if($recipe_id)
		{
		    $this->json_output(array('status'=>true,'id'=>$_POST['id']));
		}
		else
		{
			$this->json_output(array('status'=>false,'msg'=>"something went wrong"));
		}
	}

	public function menu_group()
	{
		$menu_groups=$this->menu_group_model->list_all();
		echo json_encode($menu_groups);
	}

	public function list_groups($main_menu_id="")
	{
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

	public  function barnutrition($recipe_id)
	{
		$data=array(
			'recipe'=>$this->recipes_model->get_recipe($recipe_id),
			'recipe_id'=>$recipe_id,
			'create_type'=>'barmenu'
		);
		$this->load->view('recipe_nutrition',$data);
	}

	public  function costing()
	{
		$data=array();
		$this->load->view('recipe_costing',$data);
	}

	public  function optimization()
	{
		$data=array();
		$this->load->view('recipe_optimization',$data);
	}

	public  function output()
	{
		$data=array();
		$this->load->view('recipe_output',$data);
	}
	
	public function product_code_isexists()
	{
		foreach($_POST as $x => $val) 
		{
			$_POST[$x]=filter_var($_POST[$x], FILTER_SANITIZE_STRING);
		}
		
		$product_code = $_POST['product_code'];
		
		$product_code_data=$this->recipes_model->is_productcode_exists($product_code);
		
		if(!empty($product_code_data))
		{
			$this->json_output(array('status'=>false,'msg'=>"Product code already used please try another","product_code_data"=>$product_code_data));
		}
		else
		{
			$this->json_output(array('status'=>true,'product_code_data'=>$product_code_data));
		}
	}

	public function get_addon_menu(){
		$addon_details=$this->waiting_manager_model->select_where('addon_menu',['id'=>$_POST['id']])[0];
		$this->json_output(array('status'=>true,'addon_details'=>$addon_details));
	}
	
	public function uploadmenuData()
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
					
					/* $check = $this->recipes_model->select_where('recipes',['name'=>$value['A'],'main_menu_id'=>$value['B'],'restaurant_id'=>$_SESSION['user_id']]); */
					$check = $this->recipes_model->is_exits($value['A'],$value['B'],$value['E']);
					
					if(empty($check))
					{
						if ($value['A'] != '') 
						{
							/* [A] => recipe_title
							[B] => main_menu_id
							[C] => recipe_type
							[D] => best_time_to_eat
							[E] => group_id
							[F] => description
							[G] => pcode
							[H] => is_addon
							[I] => recipe_addon_id
							[J] => table_category
							[K] => price */
							
							$check1 = $this->recipes_model->is_productcod_exits($value['E']);
							
							if(empty($check1))
							{
								$inserdata[$i]['title'] = $value['A'];
								$inserdata[$i]['is_active'] = $value['T'];
								$inserdata[$i]['recipe_image'] = $value['U'];
								$inserdata[$i]['recipe_date'] = date('Y-m-d h:i:s');
								//$inserdata[$i]['main_menu_id'] = $value['B'];
								$inserdata[$i]['recipe_type'] = $value['B'];
								$inserdata[$i]['best_time_to_eat'] = $value['C'];
								//$inserdata[$i]['group_id'] = $value['E'];
								$inserdata[$i]['description'] = $value['D'];
								$inserdata[$i]['product_code'] = $value['E'];
								//$inserdata[$i]['is_addon'] = $value['H'];
								//$inserdata[$i]['recipe_addon_id'] = $value['I'];
								$inserdata[$i]['table_category'] = $value['F'];
								$inserdata[$i]['price'] = $value['G'];
								$inserdata[$i]['table_category1'] = $value['H'];
								$inserdata[$i]['price1'] = $value['I'];
								$inserdata[$i]['table_category2'] = $value['J'];
								$inserdata[$i]['price2'] = $value['K'];
								$inserdata[$i]['table_category3'] = $value['L'];
								$inserdata[$i]['price3'] = $value['M'];
								$inserdata[$i]['table_category4'] = $value['N'];
								$inserdata[$i]['price4'] = $value['O'];
								$inserdata[$i]['table_category5'] = $value['P'];
								$inserdata[$i]['price5'] = $value['Q'];
								$inserdata[$i]['table_category6'] = $value['R'];
								$inserdata[$i]['price6'] = $value['S'];
															
								$inserdata[$i]['logged_user_id'] = $_SESSION['user_id'];
								$i++;
							}
						}
					}
				}

				if (empty($inserdata)) 
				{
					$this->json_output(array('status'=>false,'msg'=>'File records are exist.Information updated successfully'));
					exit();
				}

				$result = $this->recipes_model->importdata($inserdata);
	
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
}
?>