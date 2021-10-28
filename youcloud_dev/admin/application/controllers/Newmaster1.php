<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'third_party/aws/aws-autoloader.php';
use Aws\Common\Exception\MultipartUploadException;
use Aws\S3\MultipartUploader;
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
class Newmaster1 extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->is_loggedin();
		$this->load->model('Newmaster_model1');
		$this->load->model('recipes_model');
		$this->load->model('order_model');
		$this->load->model('customer_model');
	}
	
	public function index() {
		$data=array();
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		$this->load->view('newmaster_list1',$data);
	}

	public function list_menu_group()
	{
		if(isset($_POST['searchkey']))
			$recipe=$this->Newmaster_model1->list_menu_group($_POST['page'],$_POST['per_page'],$_POST['searchkey']);
		else
			$recipe=$this->Newmaster_model1->list_menu_group($_POST['page'],$_POST['per_page']);

		$this->json_output($recipe);
	}
	
	public function delete_menu_group(){
		$this->Newmaster_model1->delete_group_recipes($_POST['id']);
		$m=$this->Newmaster_model1;
		$m->id=$_POST['id'];
		$group_id=$m->delete();
		$this->json_output(array('status'=>true));

	}
	
	public function save_menu_group(){
		/*echo ucfirst(strtolower($_POST['group_name']));
		die;*/
		if($_POST['is_edit_group']=='edit'){
			/* $main_menu_id=ucfirst(strtolower($_POST['main_menu_id'])); */
			$m=$this->Newmaster_model1;
			$m->name=ucfirst(strtolower($_POST['group_name']));
			$m->long_desc=ucfirst(strtolower($_POST['available_in']));
			$m->declaration_name=ucfirst(strtolower($_POST['available_in1']));
			/* $m->logged_user_id=$_SESSION['user_id'];
			$m->main_menu_id=$main_menu_id; */
			$group_details=$m->check_group_name($_POST['group_name'],$_POST['group_id']);
			if(!empty($group_details)){
				$menu_group_id=$group_details['id'];
				$this->json_output(array('status'=>true,'is_group_exist'=>true,'msg'=>"Menu already exists."));
				return;
			}
			else{
				$m->id=$_POST['group_id'];
				$m->update();
				$menu_group_id=$_POST['group_id'];
				/* $this->recipes_model->update_mainmenuid($main_menu_id,$_POST['group_id']); */
			}
		}else{
			$m=$this->Newmaster_model1;
			$m->name=ucfirst(strtolower($_POST['group_name']));
			$m->long_desc=ucfirst(strtolower($_POST['available_in']));
			$m->declaration_name=ucfirst(strtolower($_POST['available_in1']));
			/* $m->logged_user_id=$_SESSION['user_id'];
			$m->main_menu_id=ucfirst(strtolower($_POST['main_menu_id'])); */
			$group_details=$m->check_group_name($_POST['group_name']);
			if(!empty($group_details)){
				$menu_group_id=$group_details['id'];
				$this->json_output(array('status'=>true,'is_group_exist'=>true,'msg'=>"Menu already exists."));
				return;
			}
			else{
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
	
	public function update_recipe_image()
	{	
		$r=$this->Newmaster_model1;
	 	
		if(!empty($_POST))
		{
	        if(isset($_POST['image']))
			{
	        	$rand_no=rand(1111111,9999999);
	        	
				if(SERVER=="testing")
					$image_url='test/recipes/'.$rand_no.'.jpg';
				else
					$image_url='recipes/'.$rand_no.'.jpg';
	        	
				$file_path='uploads/recipes/'.$rand_no.'.jpg';
                $img_r = imagecreatefromjpeg($_POST['image']);
				$output=imagejpeg($img_r,$file_path);
				$aws_result=$this->uploadAWSS3($image_url,$file_path);
				
				$sourceProperties = getimagesize($file_path);
				$thumb_path='uploads/recipes/thumb/'.$rand_no.'.jpg';
				
				if(SERVER=="testing")
					$thumb_url='test/recipes/thumb/'.$rand_no.'.jpg';
				else
					$thumb_url='recipes/thumb/'.$rand_no.'.jpg';
				
                $tmp = $this->imageResizeRecipe($img_r,$sourceProperties[0],$sourceProperties[1]);

                $output1=imagejpeg($tmp,$thumb_path);
                $aws_result=$this->uploadAWSS3($thumb_url,$thumb_path);
                unlink($thumb_path);
                unlink($file_path);

				if($file_path!="")
				{					
					$r=$this->Newmaster_model1;
				
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

		            $this->json_output(array('path'=>CLOUDFRONTURL.$image_url,'status'=>true,'msg'=>'Menu Photo Updated'));
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




	public  function dashboard()
	{
		
		$data=array(
			'recently_added'=>$this->recipes_model->list_recently_added_recipes(),
			'visited_recipes'=>$this->recipes_model->list_most_visited_recipes(),
			'recipes_count'=>$this->recipes_model->recipes_count(),
			'ttlvisited_users_count'=>$this->recipes_model->ttlvisited_users_count(),
			'visited_users_count'=>$this->recipes_model->visited_users_count(),
			'ttlvisited_recipes_count'=>$this->recipes_model->ttlvisited_recipes_count(),
			'visited_recipes_count'=>$this->recipes_model->visited_recipes_count(),
			'recipes_views_count'=>$this->recipes_model->recipes_views_count()
		);
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		$this->load->view('rest_dashboard',$data);
	}

	public  function menu_group()
	{
		$data=array();
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		$this->load->view('menu_group_list',$data);
	}

	public  function orders()
	{
		$data=array(
			'total_orders'=>$this->order_model->total_order_count($_SESSION['user_id']),
			'pending'=>$this->order_model->total_order_count($_SESSION['user_id'],'New'),
			'assigned'=>$this->order_model->total_order_count($_SESSION['user_id'],'Assigned To Kitchen'),
			'cancel'=>$this->order_model->total_order_count($_SESSION['user_id'],'Canceled')
		);
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		
		$this->load->view('orders_dashaboard',$data);
	}

	public function list_recipes(){
		$recipes=$this->recipes_model->list_recipes_typahead();
		echo json_encode($recipes);
	}

	public  function edit_order($order_id)
	{
		$data=array(
			'order_id'=>$order_id
		);
		$this->load->view('edit_order',$data);
	}

	public function list_restaurant_orders(){
		if(isset($_POST['searchkey']))
			$orders=$this->order_model->all_orders($_POST['page'],$_POST['per_page'],$_POST['status'],$_POST['searchkey']);
		else
			$orders=$this->order_model->all_orders($_POST['page'],$_POST['per_page'],$_POST['status']);

		$this->json_output($orders);		
	}


	public function get_order_details(){
		$orders=$this->order_model->get_order_details($_POST['order_id']);
		$this->json_output($orders);
	}

	public function change_order_status(){
		$o=$this->order_model;
        $o->id=$_POST['order_id'];
        $o->status=$_POST['status'];
        $o->update();
        
       $this->json_output(array('status'=>true,'msg'=>"Status Change Successfully."));
	}

	public function menufor_restaurant(){
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		$this->load->view('menu_for_rest');
	}


	public function update_menugroup_image(){
	
		$r=$this->Newmaster_model1;
	 	if(!empty($_POST)){
	        if(isset($_POST['image'])){
	        	$rand_no=rand(1111111,9999999);
	        	if(SERVER=="testing")
					$image_url='test/menugroup/'.$rand_no.'.jpg';
				else
					$image_url='menugroup/'.$rand_no.'.jpg';
	        	$file_path='uploads/'.$rand_no.'.jpg';
                $img_r = imagecreatefromjpeg($_POST['image']);
				$output=imagejpeg($img_r,$file_path);
				$aws_result=$this->uploadAWSS3($image_url,$file_path);
				unlink($file_path);

				if($image_url!=""){
					
					$m=$this->Newmaster_model1;
	                $m->image_path=CLOUDFRONTURL.$image_url;
		            if($_POST['id']!=""){
		                $m->id=$_POST['id'];
		                $m->update();
		                $menu_group_id=$_POST['id'];
		            }

		            $this->json_output(array('path'=>CLOUDFRONTURL.$image_url,'status'=>true,'msg'=>'Group Photo Updated'));
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
	public function menu_for_restaurants(){
		if(isset($_POST['searchkey']))
			$recipes=$this->recipes_model->menu_from_restaurants($_POST['page'],$_POST['per_page'],"",$_POST['searchkey']);
		else
			$recipes=$this->recipes_model->menu_from_restaurants($_POST['page'],$_POST['per_page']);

		$this->json_output($recipes);		
	}

	public function save_menu_for_restaurant(){
		
		$r=$this->recipes_model;
		foreach ($_POST['ids'] as $id) {

			$recipe=$this->recipes_model->copyrecipe_forrestaurant($id);
			
		}
		$this->json_output(array('status'=>true,"msg"=>"Successfully added."));		

	}

	public function update_order(){

		$c=$this->customer_model;
		$c->id=$_POST['customer_id'];
		$c->name=$_POST['name'];
		$c->contact_no=$_POST['contact_no'];
		$c->update();
		
		$o=$this->order_model;
		$o->set_values($_POST);
		$o->update();
		$order_id=$_POST['id'];
			
		if($order_id!=0){
			$this->json_output(array('status'=>true,'msg'=>"You order place Successfully"));
		}
		else{
			$this->json_output(array('status'=>false,'msg'=>"Something went wrong please try again"));
		}
	}

	public function save_order_item(){
		$oi=$this->order_item_model;
		$oi->set_values($_POST);
		if($_POST['id']!=""){
			$oi->id=$_POST['id'];
			$oi->update();
		}
		else
			$oi->add();
		$this->json_output(array('status'=>true,'result'=>$this->order_item_model->list_order_items($_POST['order_id'])));
	}

	public function delete_order_item(){
		$oi=$this->order_item_model;
		$oi->id=$_POST['id'];
		$oi->delete();

		$this->json_output(array('status'=>true,'result'=>$this->order_item_model->list_order_items($_POST['order_id'])));
	}
}
?>