<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//header('Access-Control-Allow-Origin: *');
/*header('Access-Control-Allow-Origin: http://172.105.47.14', false);*/
header('Access-Control-Allow-Origin: https://healthyrecipe.co', false);
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
class Api extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('recipes_model');
		$this->load->model('aalcalc_model');
		$this->load->model('ingredient_items_model');
		$this->load->model('ingredient_model');
		$this->load->model('ingredient_weights_model');
		$this->load->model('menu_group_model');
		$this->load->model('subscription_model');
		$this->load->model('user_model');
		$this->load->library("session");
       	$this->load->helper('url');

      /* 	$headers=getallheaders();
		echo "<pre>";
		print_r(getallheaders());
		die;*/
	}

	public function get_ingredient()
	{
		$input =file_get_contents("php://input");
	    $post_data = json_decode($input,true);
		$user_data=$this->user_model->get_user($post_data['user_id']);
	  
		if(!empty($user_data)){
			$ingredient_data = $this->aalcalc_model->get_ingredient($post_data['id']);

			/*check header in constructor and then set user id in construnctor*/
			$this->json_output($ingredient_data);
		}else{
			$this->json_output(array('status'=>404,"msg"=>"Invalid User"));
		}
	}
	

	public function search_ingredients($query,$page_no){
		$input =file_get_contents("php://input");
	    $post_data = json_decode($input,true);
	    $query=str_replace(' ', '%20', $query);
	    $post_data["nai_stand"]="on";
		$post_data["uk_standard"]="on";
		$post_data["us_standard"]="on";
		$post_data["custom"]="off";
		$result = $this->aalcalc_model->search_ingredients($query,$page_no,$post_data);

		if(!empty($result['ingredients'])){
			$ingredients=$result['ingredients'];
		}else{
			$ingredients=[];
		}
		return $ingredients;
	}

	public function create_recipe(){

		$input =file_get_contents("php://input");
	    $event_data = json_decode($input,true);

    	//Add group 


	    foreach ($event_data as $post_data) {
			$m=$this->menu_group_model;
			$m->title=ucfirst(strtolower("Healthy Recipes"));
			$m->logged_user_id=$post_data['user_id'];
			$group_details=$m->check_group_name("Healthy Recipes",$post_data['user_id']);
			if(!empty($group_details)){
				$menu_group_id=$group_details['id'];
			}
			else
				$menu_group_id=$m->add();
			
			$data=array(
				"recipes"=>array(
					"name"=>$post_data['name'],
					"quantity_per_serving"=>$post_data['quantity_per_serving'],
					"weight_loss"=>$post_data['weight_loss']
				)
			);
			$result = $this->aalcalc_model->create_recipe(json_encode($data));
			
			$aalcalc_recipe_id=$result['recipes']['id'];
			if($aalcalc_recipe_id){

				$r=$this->recipes_model;
				$r->alacal_recipe_id=$aalcalc_recipe_id;
				$r->name=$post_data['name'];
				$r->logged_user_id=$post_data['user_id'];
				if(isset($post_data['image64'])){
					$thum = $post_data['image64'];
					$data = base64_decode($thum);
					
					$percent = 0.4;
					$im = imagecreatefromstring($data);
					$width = imagesx($im);
					$height = imagesy($im);
					$newwidth = $width * $percent;
					$newheight = $height * $percent;

					$thumb = imagecreatetruecolor($newwidth, $newheight);
					// Resize
					imagecopyresized($thumb, $im, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
						//imagejpeg($thumb,$newfilename);
					ob_start();
				    imagejpeg($thumb);
				    $contents = ob_get_contents();
					ob_end_clean();

					$fileName=rand()."_".rand();
					$new_filename = 'uploads/recipes/'.$fileName.'.png';
					file_put_contents('./'.$new_filename, $contents);
					$r->recipe_image=$new_filename;
				}
				$r->is_active=1;
				$r->quantity_per_serving=$post_data['quantity_per_serving'];
				$r->weight_loss=$post_data['weight_loss'];
				$r->total_weight=$post_data['total_weight'];
				$r->group_id=$menu_group_id;
				$r->recipe_type=$post_data['recipe_type'];
				$recipe_id=$r->add();


				$ingredients=$post_data['ingredients'];

				foreach ($ingredients as $ingredient) {
					$aalcalc_ingredients=$this->search_ingredients($ingredient['declaration_name'],1);
				
					//result.data.ingredients
					if(!empty($aalcalc_ingredients)){
						$ingredient_data = $this->aalcalc_model->get_ingredient($aalcalc_ingredients[0]['id']);
						/*echo "<pre>";
					print_r($ingredient_data);
					die;*/
						if($ingredient_data['ingredients']['weights']){
							$ingredient['quantity_unit_id']=$ingredient_data['ingredients']['weights'][0]['id'];
						}else{
							$ingredient['quantity_unit_id']="";
						}
						$ingredient['ingredient_id']=$aalcalc_ingredients[0]['id'];
						$ingredient['data_source']=$aalcalc_ingredients[0]['data_source'];
						$ingredient['quantity_unit']=$aalcalc_ingredients[0]['weights'][0];

						$in=$this->ingredient_model;
							$status=$in->isexist(array('alacalc_id'=>$ingredient['ingredient_id']));
							if($status!="exist"){
								$in->long_desc=$ingredient['long_desc'];
								$in->declaration_name=$ingredient['declaration_name'];
								$in->created_at=date('Y-m-d H:i:s');
								$in->data_source=$ingredient['data_source'];
								$in->ingredient_id=$ingredient['ingredient_id'];
								$in->add();
							}

						$data=array(
							'recipe_id'=>$aalcalc_recipe_id,
							'ingredient_items'=>array(
								'ingredient_id'=>$ingredient['ingredient_id'],
								'quantity'=>$ingredient['quantity'],
								'quantity_unit_id'=>$ingredient['quantity_unit_id']
							)
						);

						$result = $this->aalcalc_model->add_ingredient_items($aalcalc_recipe_id,json_encode($data));

						if(isset($result['ingredient_items'])){
							$alacalc_item_id=$result['ingredient_items']['id'];
							$i=$this->ingredient_items_model;
							$i->alacalc_item_id=$alacalc_item_id;
							$i->ingredient_id=$ingredient['ingredient_id'];
							$i->recipe_id=$recipe_id;
							$i->quantity=$ingredient['quantity'];
							$i->quantity_unit_id=$ingredient['quantity_unit_id'];
							$i->long_desc=$ingredient['long_desc'];
							$i->declaration_name=$ingredient['declaration_name'];
							$i->data_source=$ingredient['data_source'];
							$i->quantity_unit=json_encode($ingredient['quantity_unit']);
				
							$id=$i->add();
						}
					}
				}
				$recipe_details = $this->recipes_model->update_alacalc_recipe($aalcalc_recipe_id,$recipe_id);
			}
	    }
		if($aalcalc_recipe_id){
		    $this->json_output(array('status'=>true,'msg'=>"Successfully Added.",'recipe_id'=>$recipe_id));
		}
		else{
			$this->json_output(array('status'=>false,'msg'=>"something went wrong"));
		}
	}

	public function addrecipe(){
		$input =file_get_contents("php://input");
    	$post_data = json_decode($input,true);
		//$sub_result=$this->user_model->check_subscription($_SESSION['user_id']);
		if(!empty($post_data)){
			$m=$this->menu_group_model;
			$m->title=ucfirst(strtolower("API Recipes"));
			$m->logged_user_id=$post_data['user_id'];
			$group_details=$m->check_group_name("API Recipes",$post_data['user_id']);
			if(!empty($group_details)){
				$menu_group_id=$group_details['id'];
			}
			else
				$menu_group_id=$m->add();

			$data=array(
				"recipes"=>array(
					"name"=>$post_data['name'],
					"quantity_per_serving"=>$post_data['quantity_per_serving'],
					"weight_loss"=>$post_data['weight_loss']
				)
			);
			$result = $this->aalcalc_model->create_recipe(json_encode($data));
			
			$aalcalc_recipe_id=$result['recipes']['id'];
			if($aalcalc_recipe_id){
				
				$r=$this->recipes_model;
				$r->alacal_recipe_id=$aalcalc_recipe_id;
				$r->name=$post_data['name'];
				$r->logged_user_id=$post_data['user_id'];
				if(isset($post_data['image64'])){
					$thum = $post_data['image64'];
					$data = base64_decode($thum);
					
					$percent = 0.4;
					$im = imagecreatefromstring($data);
					$width = imagesx($im);
					$height = imagesy($im);
					$newwidth = $width * $percent;
					$newheight = $height * $percent;

					$thumb = imagecreatetruecolor($newwidth, $newheight);
					// Resize
					imagecopyresized($thumb, $im, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
						//imagejpeg($thumb,$newfilename);
					ob_start();
				    imagejpeg($thumb);
				    $contents = ob_get_contents();
					ob_end_clean();

					$fileName=rand()."_".rand();
					$new_filename = 'uploads/recipes/'.$fileName.'.png';
					file_put_contents('./'.$new_filename, $contents);
					$r->recipe_image=$new_filename;
				}
				$r->is_active=1;
				$r->quantity_per_serving=$post_data['quantity_per_serving'];
				$r->weight_loss=$post_data['weight_loss'];
				$r->total_weight=$post_data['total_weight'];
				$r->group_id=$menu_group_id;
				$recipe_id=$r->add();

				$recipe_details = $this->recipes_model->update_alacalc_recipe($aalcalc_recipe_id,$recipe_id);

		    	$this->json_output(array('status'=>true,'msg'=>"Successfully Added.",'id'=>$recipe_id,'aalcalc_recipe_id'=>$aalcalc_recipe_id));
			}
		}
		else{
			$this->json_output(array('status'=>false,'msg'=>"something went wrong"));
		}

	}

	public function get_recipe(){
		$input =file_get_contents("php://input");
	    $_POST = json_decode($input,true);
		$recipe=$this->recipes_model->get_recipe_linked($_POST['id']);
		/*echo "<pre>";
		print_r($recipe);
		die;*/
		/*$result = $this->aalcalc_model->get_recipe($recipe['alacal_recipe_id']);*/
		/*$recipe['linked']=$result['linked'];*/
		
		$this->json_output(array('status'=>true,'recipe'=>$recipe));
		
	}

/*	public function get_recipe(){
		$input =file_get_contents("php://input");
	    $_POST = json_decode($input,true);
		$recipe=$this->recipes_model->get_recipe($_POST['id']);
		$result = $this->aalcalc_model->get_recipe($recipe['alacal_recipe_id']);
		$recipe['linked']=$result['linked'];
		$this->json_output(array('status'=>true,'recipe'=>$recipe));
		
	}
*/
	public function get_recipe_nutritionalinfo(){
		$input =file_get_contents("php://input");
	    $_POST = json_decode($input,true);
		$recipe=$this->recipes_model->get_recipe($_POST['id']);
		$data=array(
			'id'=>$recipe['id'],
			"name"=>$recipe['name'],
          	"recipe_type"=>$recipe['recipe_type'],
        	"quantity_per_serving"=>$recipe['quantity_per_serving'],
        	"weight_loss"=>$recipe['weight_loss'],
        	"serving_size"=>$recipe['serving_size'],
        	"total_weight"=>$recipe['total_weight']
		);
		/*$result = $this->aalcalc_model->get_recipe($recipe['alacal_recipe_id']);
		if($result){
			if($result['linked']['nutrition'])
				$data['nutrition']=$result['linked']['nutrition'];
			/*if($result['linked']['allergens'])*/
			/*	$data['allergens']=$result['linked']['allergens'];
		}*/
		$this->json_output(array('status'=>true,'recipe'=>$recipe));
		
	}

	public function list_recipes(){
		$input =file_get_contents("php://input");
	    $_POST = json_decode($input,true);
		$recipe=$this->recipes_model->list_api_recipes($_POST['page'],$_POST['per_page'],$_POST['user_id']);
		$this->json_output($recipe);
	}

	public function save_recipe_items(){
		$input =file_get_contents("php://input");
	    $_POST = json_decode($input,true);

		$in=$this->ingredient_model;
		$status=$in->isexist(array('alacalc_id'=>$_POST['ingredient_data']['id']));
		if($status!="exist"){
			$in->long_desc=$_POST['ingredient_data']['long_desc'];
			$in->declaration_name=$_POST['ingredient_data']['declaration_name'];
			$in->created_at=date('Y-m-d H:i:s');
			$in->data_source=$_POST['ingredient_data']['data_source'];
			$in->alacalc_id=$_POST['ingredient_data']['id'];
			$in->add();
		}

		/*$i=$this->ingredient_items_model;
		$i->ingredient_id=$_POST['ingredient_id'];
		$i->recipe_id=$_POST['recipe_id'];
		$status=$i->isexist(array('ingredient_id'=>$_POST['ingredient_id'],'recipe_id'=>$_POST['recipe_id']));
		if($status!="exist"){*/
			$data=array(
				'recipe_id'=>$_POST['alacalc_recipe_id'],
				'ingredient_items'=>array(
					'ingredient_id'=>$_POST['ingredient_id'],
					'quantity'=>$_POST['quantity'],
					'quantity_unit_id'=>$_POST['quantity_unit_id']
				)
			);

			$result = $this->aalcalc_model->add_ingredient_items($_POST['alacalc_recipe_id'],json_encode($data));

			if(isset($result['ingredient_items'])){
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
				$i->quantity_unit=json_encode($_POST['ingredient_data']['weights'][0]);
				/*if(isset($_POST['id'])){
					$i->id=$_POST['id'];
					$i->update();
					$id=$_POST['id'];
				}else{*/
					$id=$i->add();
				//}
			}

			$weights=$_POST['ingredient_data']['weights'];
			foreach ($weights as $weight) {
				$w=$this->ingredient_weights_model;
				$status=$w->isexist(array('description'=>$weight['desc'],'ingredient_id'=>$_POST['ingredient_id']));
				if($status!="exist"){
					$w->description=$weight['desc'];
					$w->ingredient_id=$_POST['ingredient_id'];
					$w->amount=$weight['amount'];
					$w->gm_wgt=$weight['gm_wgt'];
					$w->alacalc_id=$weight['id'];
					$w->add();
				}
			}

			$recipe_details = $this->recipes_model->update_alacalc_recipe($_POST['alacalc_recipe_id'],$_POST['recipe_id']);
			if($id){
			    $this->json_output(array('status'=>true,'id'=>$id,'alacalc_item_id'=>$alacalc_item_id));
			}
			else{
				$this->json_output(array('status'=>false,'msg'=>"something went wrong"));
			}
		/*}else{
			$this->json_output(array('status'=>false,'msg'=>"Ingredient Already Exist"));
		}*/
	}

	public function update_ingredient_items(){

		$input =file_get_contents("php://input");
	    $_POST = json_decode($input,true);

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

		if(isset($result['ingredient_items'])){
			$i=$this->ingredient_items_model;
			$i->set_values($_POST);
			$item_id=$i->update();
		}

		$recipe_details = $this->recipes_model->update_alacalc_recipe($_POST['alacalc_recipe_id'],$_POST['recipe_id']);

		if($item_id){
		    $this->json_output(array('status'=>true,'item_id'=>$item_id));
		}
		else{
			$this->json_output(array('status'=>false,'msg'=>"something went wrong"));
		}
	}


	public function update_recipe(){
		$input =file_get_contents("php://input");
	    $_POST = json_decode($input,true);
		$data=array(
			"id"=>$_POST['alacalc_recipe_id'],
			"recipes"=>array(
				"name"=>$_POST['name'],
				"quantity_per_serving"=>$_POST['quantity_per_serving'],
				"weight_loss"=>$_POST['weight_loss']
			)
		);
		$result = $this->aalcalc_model->update_recipe($_POST['alacalc_recipe_id'],json_encode($data));
		/*echo "<pre>";
		print_r($result);
		die;*/
		if($result['recipes']){
			$r=$this->recipes_model;
			$r->set_values($_POST);
			if(isset($_POST['image64'])){
				$thum = $_POST['image64'];
				$data = base64_decode($thum);
				
				$percent = 0.4;
				$im = imagecreatefromstring($data);
				$width = imagesx($im);
				$height = imagesy($im);
				$newwidth = $width * $percent;
				$newheight = $height * $percent;

				$thumb = imagecreatetruecolor($newwidth, $newheight);
				// Resize
				imagecopyresized($thumb, $im, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
					//imagejpeg($thumb,$newfilename);
				ob_start();
			    imagejpeg($thumb);
			    $contents = ob_get_contents();
				ob_end_clean();

				$fileName=rand()."_".rand();
				$new_filename = 'uploads/recipes/'.$fileName.'.png';
				file_put_contents('./'.$new_filename, $contents);
				$r->recipe_image=$new_filename;
			}
			$r->update();
			$recipe_id=$_POST['id'];
		}

		$this->recipes_model->make_active($recipe_id);

		$recipe_details = $this->recipes_model->update_alacalc_recipe($_POST['alacalc_recipe_id'],$_POST['id']);

		if($recipe_id){
		    $this->json_output(array('status'=>true,'id'=>$_POST['id']));
		}
		else{
			$this->json_output(array('status'=>false,'msg'=>"something went wrong"));
		}
	}



	public function search_ingredient(){

		$input =file_get_contents("php://input");
	    $post_data = json_decode($input,true);
		$user_data=$this->user_model->get_user($post_data['user_id']);
	  
		if(!empty($user_data)){
		    $query=str_replace(' ', '%20', $post_data['query']);
		    $post_data["nai_stand"]="on";
			$post_data["uk_standard"]="on";
			$post_data["us_standard"]="on";
			$post_data["custom"]="off";
			$result = $this->aalcalc_model->search_ingredients($post_data['query'],$post_data['page_no'],$post_data);

			if(!empty($result['ingredients'])){
				$ingredients=$result['ingredients'];
			}else{
				$ingredients=[];
			}
			$this->json_output($ingredients);
		}else{
			$this->json_output(array('status'=>404,"msg"=>"Invalid User"));
		}
		//return $ingredients;
	}

	public function update_nutrient_information_recipes(){
	
		$recipes=$this->recipes_model->list_recipes_all();
		$count=count($recipes);
		$i=0;
		foreach ($recipes as $recipe) {
			if($recipe['alacal_recipe_id']){
				$this->recipes_model->update_alacalc_recipe($recipe['alacal_recipe_id'],$recipe['id']);
			}
			if($i==20){
				sleep(20);
				$i=0;
			}
			$i++;
		}
		
	}

	public function getpostalCode(){

		$users=$this->user_model->list_user_post();

		foreach ($users as $user) {
			$zip=$user['postcode'];
			if($zip!=""){
				$url = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($zip)."&key=AIzaSyC9_tv_aYqB4F7APEllLHg1afnZbTrYP1k";
				
				$result_string = file_get_contents($url);
				$result = json_decode($result_string, true);
				$result1[]=$result['results'][0];
				$result2[]=$result1[0]['geometry'];
				$result3[]=$result2[0]['location'];
				
				$latlng=$result3[0];
				
				$u=$this->user_model;
				$u->latitude=$latlng['lat'];
				$u->longitude=$latlng['lng'];
				$u->id=$user['id'];
				$u->update();
			}
			
		}
	}

	public function update_group_seq(){

		$users=$this->menu_group_model->update_allgroup_sequence();
		
	}

}
?>