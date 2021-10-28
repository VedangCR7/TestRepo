<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'third_party/aws/aws-autoloader.php';
use Aws\Common\Exception\MultipartUploadException;
use Aws\S3\MultipartUploader;
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
class Menumaster extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		//$this->is_loggedin();
		$this->load->model('Masterrecipes_model');
		$this->load->model('aalcalc_model');
		$this->load->model('ingredient_items_model');
		$this->load->model('ingredient_model');
		$this->load->model('ingredient_weights_model');
		$this->load->model('menu_group_model');
		$this->load->model('subscription_model');
		$this->load->model('user_model');
		$this->load->model('recipe_image_model');
		$this->load->library("session");
       	$this->load->helper('url');
	}
	
	public function index() {
		$this->load->view('home');
	}

	public  function overview()
	{
		$data=array(
			'group_not_recipescnt'=>$this->Masterrecipes_model->groupnot_recipe_count()
		);
		
		$this->load->view('masterrecipe_list',$data);
	}

	public  function barmenus()
	{
		$data=array(
		);
		
		$this->load->view('recipe_bar_list',$data);
	}

	public  function group_not_selected()
	{
		$data=array();
		
		$this->load->view('group_not_selected',$data);
	}

	public  function create($recipe_id)
	{
		if(!isset($recipe_id))
			redirect('Menumaster/overview');

		$data=array(
			'recipe'=>$this->Masterrecipes_model->get_recipe($recipe_id),
			'table_cats'=>$this->user_model->list_rest_tablecategories($_SESSION['user_id']),
			'recipe_id'=>$recipe_id,
			'create_type'=>'restmenu'
		);
		$this->load->view('masterrecipes_create',$data);
	}

	public function list_table_categories(){
		$table_categories=$this->user_model->list_rest_tablecategories($_SESSION['user_id']);
		echo json_encode($table_categories);
	}
	
	public  function createbarmenu($recipe_id)
	{
		if(!isset($recipe_id))
			redirect('Menumaster/overview');

		$data=array(
			'recipe'=>$this->Masterrecipes_model->get_recipe($recipe_id),
			'recipe_id'=>$recipe_id,
			'create_type'=>'barmenu'
		);
		$this->load->view('recipes_create',$data);
	}

	public function addrecipe($main_menu_id){
					
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
		
		$r=$this->Masterrecipes_model;
		$r->alacal_recipe_id="";
		if(isset($_GET['subscription_id']))
			$r->subscription_id=$_GET['subscription_id'];
		$r->name=$reciep_name;
		$r->recipe_image='assets/images/users/menu.png';
		$r->long_desc='add long description of ingredients';
		$r->declaration_name='add declaration name of ingredients';
		$r->is_delete=0;
		$recipe_id=$r->add();
		
		if(isset($recipe_id)){
			$new_recipe_name=$reciep_name."-".$recipe_id;
			
			$r=$this->Masterrecipes_model;
			$r->declaration_name=$declaration_names;
			$r->id=$recipe_id;
			$r->update();
		}

		if($main_menu_id==1)
			redirect('Menumaster/create/'.$recipe_id.'?from=addrecipe');
		
	}

	
    public function active_inactive_recipe(){
		
		
		$r=$this->Masterrecipes_model;
		$r->id=$_POST['id'];
		if($_POST['is_recipe_active']=="on")
			$r->is_recipe_active=1;
		else
			$r->is_recipe_active=0;
		$recipe_id=$r->update();
		$this->json_output(array('status'=>true));
	}

	public function delete_recipe(){
		
		$r1=$this->Masterrecipes_model;
		$r1->id=$_POST['id'];
		$recipe_details=$r1->get();
		
			$r=$this->Masterrecipes_model;
			$r->id=$_POST['id'];
			$r->is_delete=1;
			$recipe_id=$r->update();
		
		$this->json_output(array('status'=>true));
	}

	public function get_recipe($recipe_id){
		$recipe=$this->Masterrecipes_model->get_recipe($recipe_id);
		$user=$this->user_model->get_user($_SESSION['user_id']);
		$usertype=$user['usertype'];
		$restauranttype=$user['restauranttype'];

		$this->json_output(array('status'=>true,'recipe'=>$recipe,'usertype'=>$usertype,'restauranttype'=>$restauranttype));
		
	}

	public function get_recipe_prices(){
		$recipe_id=$_POST['id'];
		$recipe=$this->Masterrecipes_model;
		$recipe->id=$recipe_id;
		$recipe_data=$recipe->get();

		$this->json_output(array('status'=>true,'recipe'=>$recipe_data));
		
	}

	public function list_recipes(){
		
		if(isset($_POST['searchkey'])){
			$recipe=$this->Masterrecipes_model->list_recipes($_POST['page'],$_POST['per_page'],$_POST['searchkey']);
		}
		else{
			$recipe=$this->Masterrecipes_model->list_recipes($_POST['page'],$_POST['per_page']);
		}

		$this->json_output($recipe);
	}

	public function list_groupnot_recipes(){
		$recipe=$this->Masterrecipes_model->list_groupnot_recipes($_POST['page'],$_POST['per_page']);
		$this->json_output($recipe);
	}


	public function delete_recipe_price(){
		
		if($_POST['sequence']==1){
			$array=array('price1'=>null,'quantity1'=>'');
		}
		if($_POST['sequence']==2){
			$array=array('price2'=>null,'quantity2'=>'');
		}
		if($_POST['sequence']==3){
			$array=array('price3'=>null,'quantity3'=>'');

		}
		
		$this->Masterrecipes_model->update_recipe_price($_POST['recipe_id'],$array);

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

		$r=$this->Masterrecipes_model;
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
		$r->update();
		
		$this->Masterrecipes_model->make_active($_POST['recipe_id']);

		if($menu_group_id){
		    $this->json_output(array('status'=>true,'menu_group_id'=>$menu_group_id));
		}
		else{
			$this->json_output(array('status'=>false,'msg'=>"something went wrong"));
		}
	}

	public function save_recipe_items(){
		
		$arr=explode('-', $_POST['ingredient_data']['long_desc']);
		$_POST['ingredient_data']['long_desc']=$arr[0];

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

		if($_SESSION['is_alacalc_recipe']==1){
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
				$i->quantity_unit=json_encode($_POST['quantity_unit']);
					$id=$i->add();
				//}
			}
		}else{
			$alacalc_item_id="";
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
		if($_SESSION['is_alacalc_recipe']==1){
			$this->Masterrecipes_model->update_alacalc_recipe($_POST['alacalc_recipe_id'],$_POST['recipe_id']);
		}
		if($id){
		    $this->json_output(array('status'=>true,'id'=>$id,'alacalc_item_id'=>$alacalc_item_id));
		}
		else{
			$this->json_output(array('status'=>false,'msg'=>"something went wrong"));
		}
	}

	public function delete_ingredient_item(){
		if($_SESSION['is_alacalc_recipe']==1){
			$result = $this->aalcalc_model->delete_ingredient_items($_POST['alacalc_item_id'],$_POST['alacalc_recipe_id']);
		}
		
		$i=$this->ingredient_items_model;
		$i->id=$_POST['id'];
		$status=$i->delete();
		$ingredient_items=$this->ingredient_items_model->list_items($_POST['recipe_id']);
		if($status){
		    $this->json_output(array('status'=>true,'ingredient_items'=>$ingredient_items));
		}
		else{
			$this->json_output(array('status'=>false,'msg'=>"something went wrong"));
		}
			
	}

	public function update_ingredient_items(){
	
		if($_SESSION['is_alacalc_recipe']==1){
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
		}
		else{
				$i=$this->ingredient_items_model;
				$i->set_values($_POST);
				$item_id=$i->update();
		}

		$this->ingredient_items_model->update_recipe_ingredient($_POST['recipe_id']);
		if($item_id){
		    $this->json_output(array('status'=>true,'item_id'=>$item_id));
		}
		else{
			$this->json_output(array('status'=>false,'msg'=>"something went wrong"));
		}
	}

	public function update_recipe_image(){
	
		$r=$this->Masterrecipes_model;
	 	if(!empty($_POST)){
	        if(isset($_POST['image'])){
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
                $aws_result=$this->uploadAWSS3($thumb_url,$thumb_path);
                unlink($thumb_path);
                unlink($file_path);

				if($file_path!=""){
					
					$r=$this->Masterrecipes_model;
				
		            if($file_path!=""){
	                    $r->recipe_image=CLOUDFRONTURL.$image_url;
						$r->img_id='FN'.$_POST['id'];
						
					}
	                if($thumb_path!=""){
                    	$r->thumb_path=CLOUDFRONTURL.$thumb_url;
					}
		            if($_POST['id']!=""){
		                $r->id=$_POST['id'];
		                $r->update();
		                $recipe_id=$_POST['id'];
		            }

		            $this->json_output(array('path'=>CLOUDFRONTURL.$image_url,'status'=>true,'msg'=>'Recipe Photo Updated'));
					return;
				}else{
					$this->json_output(array('status'=>false,'msg'=>'Something went wrong please try again.'));
					return;

				}	

	        }
           
        }else{
        	$this->json_output(array('status'=>false,'msg'=>'Please select file to upload'));
        }
	}

	public function imageResizeRecipe($imageSrc,$imageWidth,$imageHeight) {

	    $newImageWidth =200;
	    $newImageHeight =200;

	    $newImageLayer=imagecreatetruecolor($newImageWidth,$newImageHeight);
	    imagecopyresampled($newImageLayer,$imageSrc,0,0,0,0,$newImageWidth,$newImageHeight,$imageWidth,$imageHeight);

	    return $newImageLayer;
	}

	public function imageResize($imageSrc,$imageWidth,$imageHeight) {

	    $newImageWidth =200;
	    $newImageHeight =121;

	    $newImageLayer=imagecreatetruecolor($newImageWidth,$newImageHeight);
	    imagecopyresampled($newImageLayer,$imageSrc,0,0,0,0,$newImageWidth,$newImageHeight,$imageWidth,$imageHeight);

	    return $newImageLayer;
	}

	public function upload_file($encoded_string){
	    $target_dir = ''; // add the specific path to save the file
	    $decoded_file = base64_decode($encoded_string); // decode the file
	    $mime_type = finfo_buffer(finfo_open(), $decoded_file, FILEINFO_MIME_TYPE); // extract mime type
	    $extension = mime2ext($mime_type); // extract extension from mime type
	    $file = uniqid() .'.'. $extension; // rename file as a unique name
	    $file_dir = $target_dir . uniqid() .'.'. $extension;
	    try {
	        file_put_contents($file_dir, $decoded_file); // save
	        database_saving($file);
	        header('Content-Type: application/json');
	        echo json_encode("File Uploaded Successfully");
	    } catch (Exception $e) {
	        header('Content-Type: application/json');
	        echo json_encode($e->getMessage());
	    }

	}

	public function update_price(){

		$r=$this->Masterrecipes_model;
		$r->id=$_POST['id'];
		$r->price=$_POST['price'];
		$r->update();
		$recipe_id=$_POST['id'];


		if($recipe_id){
		    $this->json_output(array('status'=>true,'id'=>$_POST['id']));
		}
		else{
			$this->json_output(array('status'=>false,'msg'=>"something went wrong"));
		}
	}

	public function update_recipe(){
		
		$r=$this->Masterrecipes_model;
		$r->set_values($_POST);
		$r->name=$_POST['name'];
		$r->long_desc=$_POST['long_desc'];
		$r->declaration_name=$_POST['declaration_name'];
		$r->update();
		
		$recipe_id=$_POST['id'];
		
		if($recipe_id){
		    $this->json_output(array('status'=>true,'id'=>$_POST['id']));
			redirect('Menumaster/overview');
		}
		else{
			$this->json_output(array('status'=>false,'msg'=>"something went wrong"));
		}
	}

	public function menu_group(){
		$menu_groups=$this->menu_group_model->list_all();
		echo json_encode($menu_groups);
	}

	public function list_groups($main_menu_id=""){
		$menu_groups=$this->menu_group_model->list_groups($main_menu_id);
		echo json_encode($menu_groups);
	}

	public  function nutrition($recipe_id)
	{
		$data=array(
			'recipe'=>$this->Masterrecipes_model->get_recipe($recipe_id),
			'recipe_id'=>$recipe_id,
			'create_type'=>'restmenu'
		);
		$this->load->view('recipe_nutrition',$data);
	}

	public  function barnutrition($recipe_id)
	{
		$data=array(
			'recipe'=>$this->Masterrecipes_model->get_recipe($recipe_id),
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
}
?>