<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class School extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->is_loggedin();
		$this->load->model('menu_group_model');
		$this->load->model('aalcalc_model');
		$this->load->model('recipes_model');
		$this->load->model('calendar_events_model');
		$this->load->model('main_menu_model');
	}
	
	public function index() {
		$this->load->view('home');
	}

	public  function dashboard()
	{
		/*echo "<pre>";
		print_r($_SESSION);
		die;*/
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

	public function delete_group(){

		$m=$this->menu_group_model;
		$m->id=$_POST['id'];
		if($_POST['is_active']=="on")
			$m->is_active=1;
		else
			$m->is_active=0;
		$group_id=$m->update();
		$this->json_output(array('status'=>true));
	}

	public function check_group_recipes(){

		$count=$this->menu_group_model->get_grouprecipes_count($_POST['id']);
		$this->json_output(array('status'=>true,'count'=>$count));
	}

	public function delete_menu_group(){

		$m=$this->menu_group_model;
		$m->id=$_POST['id'];
		$group_id=$m->delete();
		$this->json_output(array('status'=>true));


		$this->menu_group_model->delete_group_recipes($_POST['id']);
	}

	public function save_menu_group(){
		/*echo ucfirst(strtolower($_POST['group_name']));
		die;*/ 
		$_POST['group_name']=filter_var($_POST['group_name'], FILTER_SANITIZE_STRING);
		if($_POST['is_edit_group']=='edit')
		{
			$main_menu_id=ucfirst(strtolower($_POST['main_menu_id']));
			$m=$this->menu_group_model;
			$m->title=ucfirst(strtolower($_POST['group_name']));
			$m->available_in=ucfirst(strtolower($_POST['available_in']));
			$m->logged_user_id=$_SESSION['user_id'];
			$m->main_menu_id=$main_menu_id;
			$group_details=$m->check_group_name($_POST['group_name'],$_SESSION['user_id'],$_POST['group_id'],$main_menu_id);
			
			if(!empty($group_details))
			{
				$menu_group_id=$group_details['id'];
				$this->json_output(array('status'=>true,'is_group_exist'=>true,'msg'=>"Group already exists."));
				return;
			}
			else
			{
				$m->id=$_POST['group_id'];
				$m->update();
				$menu_group_id=$_POST['group_id'];
				$this->recipes_model->update_mainmenuid($main_menu_id,$_POST['group_id']);
			}
		}
		else
		{
			$m=$this->menu_group_model;
			$m->title=ucwords(strtolower($_POST['group_name']));
			$m->available_in=ucfirst(strtolower($_POST['available_in']));
			$m->logged_user_id=$_SESSION['user_id'];
			$m->main_menu_id=ucfirst(strtolower($_POST['main_menu_id']));
			$group_details=$m->check_group_name($_POST['group_name'],$_SESSION['user_id'],'',$_POST['main_menu_id']);
			
			if(!empty($group_details))
			{
				$menu_group_id=$group_details['id'];
				$this->json_output(array('status'=>true,'is_group_exist'=>true,'msg'=>"Group already exists."));
				return;
			}
			else
			{
				$menu_group_id=$m->add();
			}
		}
		//$menu_group_id=$m->add();

		if($menu_group_id){
		    $this->json_output(array('status'=>true,'is_group_exist'=>false,'menu_group_id'=>$menu_group_id));
		}
		else{
			$this->json_output(array('status'=>false,'msg'=>"something went wrong"));
		}
	}

	public function change_group_sequence(){
		$post=json_decode($_POST['data']);
		
		foreach ($post as $row) {
            $this->db->where('id',$row->id);
            $this->db->update('menu_group',array('sequence'=>$row->seq));
            
        }

		$this->json_output(array('status'=>true,'message'=>"Updated"));
		
	}

	public function list_main_menu_group(){
		$group=$this->main_menu_model->list_all();
		$this->json_output($group);
	}

	public function list_menu_group(){
		if(isset($_POST['searchkey']))
			$recipe=$this->menu_group_model->list_menu_group($_POST['page'],$_POST['per_page'],$_POST['searchkey']);
		else
			$recipe=$this->menu_group_model->list_menu_group($_POST['page'],$_POST['per_page']);

		$this->json_output($recipe);
	}

	public function list_menugroup_ajax(){
		$groups=$this->menu_group_model->list_all_groups();
		$this->json_output($groups);
	}


	public function list_recipe_groupwise(){
		$groups=$this->recipes_model->list_recipes_groupwise($_POST['group_id']);
		$this->json_output($groups);
	}

	public function save_calendar_events(){
		
		$c=$this->calendar_events_model;
		$c->calendar_date=$_POST['input_calendar_date'];
		$c->group_id=$_POST['menu_group'];
		$c->logged_user_id=$_SESSION['user_id'];
		$c->is_delete=0;
		$ids=array();
		for($i=0;$i<$_POST['recipe_count'];$i++) {
			if(isset($_POST['recipe_chk'.$i]))
				$ids[]=$_POST['recipe_chk'.$i];
		}
		/*print_r($ids);
		die;*/
		$arr=$c->check_calendar_event($ids);
		if($arr["status"]=="recipeexist"){
			$this->json_output(array('status'=>false,'msg'=>"Already Selected"));
			return;
		}
		else if($arr["status"]=="exist"){
			foreach ($arr['exist_recipe_ids'] as $exist_id) {
				if(!in_array($exist_id, $ids)){
                    $ids[]=$exist_id;
                }
			}
			$c->recipes_id=json_encode($ids);
			$c->id=$arr['id'];
			$c->update();
			$event_id=$arr['id'];
		}
		else{
			$c->recipes_id=json_encode($ids);
			$event_id=$c->add();
		}
		$event=$this->calendar_events_model->get_calendar_events($event_id);
		$this->json_output(array('status'=>true,'event'=>$event));
		//$this->json_output($event);
	}


	public function list_calendar_events(){
		$events=$this->calendar_events_model->list_calendar_events();
		$this->json_output($events);
	}

	public function delete_calendar_item(){

		$c=$this->calendar_events_model;
		$c->id=$_POST['event_id'];
		$event=$c->get();

		$recipes=json_decode($event['recipes_id'],true);
		/*echo "<pre>";
		print_r($recipes);
		die;*/
		foreach ($recipes as $key=>$value) {
			if($_POST['item_id']==$value)
				unset($recipes[$key]);
		}

		if(!empty($recipes)){
			$c1=$this->calendar_events_model;
			$c1->id=$_POST['event_id'];
			$c1->recipes_id=json_encode($recipes);
			$c1->update();
			$delete="recipe";
		}else{
			$c1=$this->calendar_events_model;
			$c1->id=$_POST['event_id'];
			$c1->is_delete=1;
			$c1->update();
			$delete="event";

		}

		$this->json_output(array('is_delete'=>$delete));
	}

	public function get_recipe($recipe_id,$event_id){

		$event=$this->calendar_events_model->get_calendar_event($event_id);

		$recipe=$this->recipes_model->get_recipe($recipe_id);
		/*$r->id=$recipe_id;
		$recipe=$r->get();
*/
		/*$result = $this->aalcalc_model->get_recipe($recipe['alacal_recipe_id']);*/

		if($recipe){
		    $this->json_output(array('status'=>true,'recipe'=>$recipe,'event'=>$event));
		}
		else{
			$this->json_output(array('status'=>false,'msg'=>$result));
		}
	}

	public  function calendar()
	{
		$data=array();
		$this->load->view('calendar',$data);
	}
}
?>