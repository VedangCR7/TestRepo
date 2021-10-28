<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Demo extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('user_model');	
		$this->load->model('recipes_model');
		$this->load->model('menu_group_model');
		$this->load->model('ingredient_items_model');
		$this->load->model('mainmenu_model');
	}
	
	public function index() {
		$this->load->view('demologin');
	}


	public function terms_condition(){
		$this->load->view('commingsoon');
		//commingsoon.php
	}
	public function checklogin(){
		$email =$_POST['email'];
        $pass = $_POST['password'];
		$result = $this->user_model->do_login($email, $pass);
		if(is_array($result)){
		    $this->json_output(array('status'=>true,'msg'=>$result['name']." you are successfully logged in.",'usertype'=>$result['usertype']));
		}
		else if($result=="notactivated"){
			$this->json_output(array('status'=>false,'msg'=>'Your account is inactive now, for support contact to FoodNAI'));
		}
		else{
			$this->json_output(array('status'=>false,'msg'=>"The username or password you entered is incorrect"));
		}
	}

	
	public function logout()
	{
		$usertype=$_SESSION['usertype'];
	   $this->session->unset_userdata('logged_in');
	   session_destroy();
	   if(in_array($usertype,array('Admin','Restaurant','Burger and Sandwich','Restaurant chain','School','Individual User'))){
	   		if(isset($_GET['status']))
	   			redirect('login?status='.$_GET['status'], 'refresh');
	   		else
	   			redirect('login', 'refresh');

	   }
	   /*else{
	   		redirect('web/login', 'refresh');
	   }*/
	}

	public function get_session_id(){
		if(isset($_SESSION['user_id'])){
			$u=$this->user_model;
			$u->id=$_SESSION['user_id'];
			$user=$u->get();
			$this->json_output(array('status'=>true,'id'=>$_SESSION['sess_rand_id'],'usertype'=>$_SESSION['usertype'],'logged_in'=>$_SESSION['logged_in'],'is_active'=>$user['is_active'],'user'=>$user));
		}else{
			$this->json_output(array('status'=>false));

		}
	}

	public function add_ingredients($id){
		$this->db->select('r.*,ifnull(im.img_path,r.recipe_image) as recipe_image');
        $this->db->from('recipes r');
        $this->db->join('recipe_images_master im','im.id=r.recipe_image_id','left');
        $this->db->where('r.logged_user_id',$id);
        $query = $this->db->get();
        $recipes = $query->result_array();
        foreach ($recipes as $recipe) {
        	 $ingredients=$this->menu_group_model->get_ingredients($recipe['id']);

        	 $this->db->where('id',$recipe['id']);
        	 $this->db->update('recipes',array('ingredients_name'=>ucwords($ingredients)));
        }
	}

	public function list_ingredients(){
		$ingredients=$this->menu_group_model->get_ingredients(1900);
		echo $ingredients;

		$ingredients=$this->ingredient_items_model->get_ingredients(1900);
		echo "<pre>";
		print_r($ingredients);
		die;
	}

	public function update_mainmenu(){
		$this->db->select('u.*');
        $this->db->from('user u');
        $this->db->where('u.usertype','Restaurant');
        $query = $this->db->get();
        $users = $query->result_array();

        foreach ($users as $user) {
			$this->db->insert('menu_master',array('name'=>"Restaurant Menu",
			 	'is_active'=>1,
			 	'restaurant_id'=>$user['id']
			));
			$rest_menu_id = $this->db->insert_id();

	        $this->db->where('main_menu_id',1);
	        $this->db->where('logged_user_id',$user['id']);
	        $this->db->update('recipes',array('main_menu_id'=>$rest_menu_id));


	        $this->db->where('main_menu_id',1);
	        $this->db->where('logged_user_id',$user['id']);
	        $this->db->update('menu_group',array('main_menu_id'=>$rest_menu_id));



			$this->db->insert('menu_master',array('name'=>"Bar Menu",
			 	'is_active'=>1,
			 	'restaurant_id'=>$user['id']
			));
			$bar_menu_id = $this->db->insert_id();

			$this->db->where('main_menu_id',2);
	        $this->db->where('logged_user_id',$user['id']);
	        $this->db->update('recipes',array('main_menu_id'=>$bar_menu_id));


	        $this->db->where('main_menu_id',2);
	        $this->db->where('logged_user_id',$user['id']);
	        $this->db->update('menu_group',array('main_menu_id'=>$rest_menu_id));
        }
	}

	public function update_restaurantrecipe_prices(){
		$this->db->select('*');
        $this->db->from('recipes');
        $this->db->where('is_bar_menu',0);
        $query = $this->db->get();
        $recipes = $query->result_array();
        foreach ($recipes as $recipe) {
        	if(isset($recipe['price'])  && $recipe['price']!=""){
        		$this->db->insert('recipe_prices',array(
	        		'recipe_id'=>$recipe['id'],
					'price'=>$recipe['price'],
					'is_default'=>1,
					'table_category_id'=>$recipe['quantity']
	        	));
        	}
			if(isset($recipe['price1']) && $recipe['price1']!=""){
				$this->db->insert('recipe_prices',array(
	        		'recipe_id'=>$recipe['id'],
					'price'=>$recipe['price1'],
					'is_default'=>0,
					'table_category_id'=>$recipe['quantity1']
	        	));
			}
			if(isset($recipe['price2'])  && $recipe['price2']!=""){
				$this->db->insert('recipe_prices',array(
	        		'recipe_id'=>$recipe['id'],
					'price'=>$recipe['price2'],
					'is_default'=>0,
					'table_category_id'=>$recipe['quantity2']
	        	));
			}
			if(isset($recipe['price3'])  && $recipe['price3']!=""){
				$this->db->insert('recipe_prices',array(
	        		'recipe_id'=>$recipe['id'],
					'price'=>$recipe['price3'],
					'is_default'=>0,
					'table_category_id'=>$recipe['quantity3']
	        	));
			}
        }
	}

	public function update_barrecipe_prices(){
		$this->db->select('*');
        $this->db->from('recipes');
        $this->db->where('is_bar_menu',1);
        $query = $this->db->get();
        $recipes = $query->result_array();
        foreach ($recipes as $recipe) {
        	if(isset($recipe['price'])  && $recipe['price']!=""){
        		$this->db->insert('recipe_prices',array(
	        		'recipe_id'=>$recipe['id'],
					'price'=>$recipe['price'],
					'is_default'=>1,
					'table_category_id'=>$recipe['quantity']
	        	));
        	}
			if(isset($recipe['price1']) && $recipe['price1']!=""){
				$this->db->insert('recipe_prices',array(
	        		'recipe_id'=>$recipe['id'],
					'price'=>$recipe['price1'],
					'is_default'=>0,
					'table_category_id'=>$recipe['quantity1']
	        	));
			}
			if(isset($recipe['price2'])  && $recipe['price2']!=""){
				$this->db->insert('recipe_prices',array(
	        		'recipe_id'=>$recipe['id'],
					'price'=>$recipe['price2'],
					'is_default'=>0,
					'table_category_id'=>$recipe['quantity2']
	        	));
			}
			if(isset($recipe['price3'])  && $recipe['price3']!=""){
				$this->db->insert('recipe_prices',array(
	        		'recipe_id'=>$recipe['id'],
					'price'=>$recipe['price3'],
					'is_default'=>0,
					'table_category_id'=>$recipe['quantity3']
	        	));
			}
        }
	}

}
?>