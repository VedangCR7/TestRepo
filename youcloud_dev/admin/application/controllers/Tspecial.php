<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tspecial extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->is_loggedin();
		$this->load->model('todays_special_model');
		$this->load->model('recipes_model');
	}
	
	public function index() {
		$this->load->view('home');
	}

	public  function dashboard()
	{
		$data=array(
			'recently_added'=>$this->recipes_model->list_recently_added_recipes(),
			'visited_recipes'=>$this->recipes_model->list_most_visited_recipes(),
			'recipes_count'=>$this->recipes_model->recipes_count(),
			'recipes_views_count'=>$this->recipes_model->recipes_views_count()
		);
		$this->load->view('rest_dashboard',$data);
	}

	public  function menu_group()
	{
		$data=array();
		$this->load->view('menu_group_list',$data);
	}

	public function menufor_restaurant(){
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		$this->load->view('todays_special_menu',$data);
	}

	public function todays_special_menus(){

		$recipes=$this->recipes_model->todays_special_menus($_SESSION['user_id'],$_POST['page'],$_POST['per_page']);
		$this->json_output($recipes);		
	}

	public function save_todaysspecial_menus(){
		
		if($_POST['not_all_ids']=="yes"){
			$r1=$this->recipes_model->update_todays_special($_SESSION['user_id']);

			foreach ($_POST['ids'] as $id) {
				$r=$this->recipes_model;
				$r->id=$id;
				$r->is_todays_special=1;
				$r->update();
			}
			$this->json_output(array('status'=>true,"msg"=>"Successfully added."));		
		}else{


			/*$r1=$this->recipes_model->update_todays_special($_SESSION['user_id']);*/

			foreach ($_POST['uncheck_ids'] as $id) {
				$r=$this->recipes_model;
				$r->id=$id;
				$r->is_todays_special=0;
				$r->update();
			}
			$this->json_output(array('status'=>true,"msg"=>"Successfully added."));
		}

	}
}
?>