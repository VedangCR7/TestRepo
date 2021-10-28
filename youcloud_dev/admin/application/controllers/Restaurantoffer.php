<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'third_party/aws/aws-autoloader.php';
use Aws\Common\Exception\MultipartUploadException;
use Aws\S3\MultipartUploader;
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
class Restaurantoffer extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->is_loggedin();
		$this->load->model('Restaurant_offer');
		$this->load->library("session");
       	$this->load->helper('url');

	}

	public function offer(){
		$sql="SELECT r.id,r.name from 
		recipes as r
		LEFT JOIN menu_master as mm on mm.id = r.main_menu_id
		LEFT JOIN menu_group as mg on mg.id = r.group_id
		WHERE r.logged_user_id =".$_SESSION['user_id']." and r.is_active=1 and r.is_delete=0 and r.is_recipe_active=1 and mg.is_active=1 and mm.is_active=1 ORDER BY r.name ASC";
		$data['items']=$this->Restaurant_offer->query($sql);
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		$this->load->view('restaurantoffer',$data);
	}

	public function list_offer(){
		if(isset($_POST['searchkey']))
			$offer=$this->Restaurant_offer->list_offer($_POST['page'],$_POST['per_page'],$_POST['searchkey']);
		elseif (isset($_POST['status'])) {
			$offer=$this->Restaurant_offer->list_offer($_POST['page'],$_POST['per_page'],'',$_POST['status']);
		}
		else
			$offer=$this->Restaurant_offer->list_offer($_POST['page'],$_POST['per_page']);
		$this->json_output($offer);
	}

	public function save_offer()
	{
		$this->db->trans_start();
		$_POST['date'] = date('Y-m-d');
		$_POST['status'] = 1;
		$_POST['restaurant_id'] = $_SESSION['user_id'];
		unset($_POST['image']);
		
		$_POST['title']=filter_var($_POST['title'], FILTER_SANITIZE_STRING);
		$_POST['description']=filter_var($_POST['description'], FILTER_SANITIZE_STRING);
		$discount = $_POST['discount'];
		//$recipe_id = explode(',',$_POST['recipe_id']);
		$title = $_POST['title'];
		$discount_type = $_POST['discount_type'];
		
		foreach($_POST['recipe_id'] as $key=>$value){
			$check_recipe_added = $this->Restaurant_offer->select_where('admin_offer',['recipe_id'=>$value]);
			if(empty($check_recipe_added)){
				if($_POST['discount_type'] == 'Flat'){
					$query="SELECT * from admin_offer WHERE title='".$title."' and recipe_id='".$value."' and discount='".$discount."'";
					$data=$this->db->query($query)->result_array();
					$count= count($data);
					if($count<=0)
					{
						$query1="SELECT * from recipes WHERE id='".$value."' AND price < $discount";
						$data1=$this->db->query($query1)->result_array();
						$count1= count($data1);
						if($count1 <= 0){
							$this->Restaurant_offer->insert_any_query('admin_offer',['title'=>$_POST['title'],'discount'=>$discount,'recipe_id'=>$value,'status'=>$_POST['status'],'description'=>$_POST['description'],'date'=>$_POST['date'],'restaurant_id'=>$_POST['restaurant_id'],'start_date'=>$_POST['start_date'],'end_date'=>$_POST['end_date'],'discount_type'=>$_POST['discount_type']]);
						}
					}
				}else{
					$query="SELECT * from admin_offer WHERE title='".$title."' and recipe_id='".$value."' and discount='".$discount."'";
					$data=$this->db->query($query)->result_array();
					$count= count($data);
					if($count<=0)
					{
						$this->Restaurant_offer->insert_any_query('admin_offer',['title'=>$_POST['title'],'discount'=>$discount,'recipe_id'=>$value,'status'=>$_POST['status'],'description'=>$_POST['description'],'date'=>$_POST['date'],'restaurant_id'=>$_POST['restaurant_id'],'start_date'=>$_POST['start_date'],'end_date'=>$_POST['end_date'],'discount_type'=>$_POST['discount_type']]);
					}
					
				}
			}
		}
		
		
		if($this->db->trans_complete()){
			$this->json_output(array('status'=>true,'msg'=>"Offer created successfully"));
			return;
		}
		else{
			$this->json_output(array('status'=>false,'msg'=>"something went wrong"));
		}
	}

	public function add_offer_photo()
	{
		$this->db->trans_start();
    	if(!empty($_POST))
		{
			if(isset($_POST['image']))
			{
				$_POST['title']=filter_var($_POST['title'], FILTER_SANITIZE_STRING);
				$discount = $_POST['discount'];
				//$recipe_id = $_POST['recipe_id'];
				$title = $_POST['title'];
				
				$rand_no=rand(1111111,9999999);
					
					/*if(SERVER=="testing")
						$image_url='test/restaurantoffers/'.$rand_no.'.jpg';
					else
						$image_url='restaurantoffers/'.$rand_no.'.jpg';*/
						$image_url='Liveresto/restaurantoffers/'.$rand_no.'.jpg';
					
					$file_path=APPPATH.'../uploads/restaurantoffers/'.$rand_no.'.jpg';
					$img_r = imagecreatefromjpeg($_POST['image']);
					$output=imagejpeg($img_r,$file_path);
					$aws_result=$this->uploadAWSS3($image_url,$file_path);
					//gc_collect_cycles();
					//unlink($file_path);
					
					if($image_url!="")
					{
						$_POST['offer_image']=CLOUDFRONTURL.$image_url;
						unset($_POST['image']);
						$_POST['status'] = 1;
						$_POST['date'] = date('Y-m-d');
						$_POST['restaurant_id'] = $_SESSION['user_id'];
						
					}
				
				foreach($_POST['recipe_id'] as $key=>$value){
					$check_recipe_added = $this->Restaurant_offer->select_where('admin_offer',['recipe_id'=>$value]);
						if(empty($check_recipe_added)){
							$_POST['recipe_id'] = $value;
							if($_POST['discount_type'] == 'Flat'){
								$query="SELECT * from admin_offer WHERE title='".$title."' and recipe_id='".$value."' and discount='".$discount."'";
								$data=$this->db->query($query)->result_array();
								$count= count($data);
								if($count<=0)
								{
									$query1="SELECT * from recipes WHERE id='".$value."' AND price < $discount";
									$data1=$this->db->query($query1)->result_array();
									$count1= count($data1);
									if($count1 <= 0){
										$this->Restaurant_offer->insert_any_query('admin_offer',$_POST);
									}
								}
							}else{
								$query="SELECT * from admin_offer WHERE title='".$title."' and recipe_id='".$value."' and discount='".$discount."'";
								$data=$this->db->query($query)->result_array();
								$count= count($data);
								if($count<=0)
								{
									$this->Restaurant_offer->insert_any_query('admin_offer',$_POST);
								}
									
							}
						}
				}
		
		
				if($this->db->trans_complete()){
					$this->json_output(array('status'=>true,'msg'=>"Offer created successfully"));
					return;
				}
				else{
					$this->json_output(array('status'=>false,'msg'=>"something went wrong"));
				}
				
			}
		}
	}

	public function delete_offer(){
		if($_POST['status']=="on")
			$this->Restaurant_offer->updateactive_inactive('admin_offer',['id'=>$_POST['id']],['status'=>1]);		
		else
			$this->Restaurant_offer->updateactive_inactive('admin_offer',['id'=>$_POST['id']],['status'=>0]);
		$this->json_output(array('status'=>true));
	}

	public function show_perticular_order(){
		$individual_manager = $this->Restaurant_offer->select_where('admin_offer',['id'=>$_POST['id']])[0];
		$sql="SELECT r.id,r.name from recipes as r
		LEFT JOIN menu_master as mm on mm.id = r.main_menu_id
		LEFT JOIN menu_group as mg on mg.id = r.group_id
		WHERE r.logged_user_id =".$_SESSION['user_id']." and r.is_active=1 and r.is_delete=0 and r.is_recipe_active=1 and mg.is_active=1 and mm.is_active=1 Order BY r.name ASC";
		$items=$this->Restaurant_offer->query($sql);
		$this->json_output(['offer'=>$individual_manager,'items'=>$items]);
	}

	public function edit_perticular_offer(){
		$_POST['title']=filter_var($_POST['title'], FILTER_SANITIZE_STRING);
		$_POST['description']=filter_var($_POST['description'], FILTER_SANITIZE_STRING);
		$sql = "SELECT * FROM admin_offer WHERE id=".$_POST['id'];
		$get_privious_id = $this->Restaurant_offer->query($sql);
		$previous_recipe_id = $get_privious_id[0]['recipe_id'];
		// echo $_POST['recipe_id'];
		if($previous_recipe_id == $_POST['recipe_id']){
			if($this->Restaurant_offer->updateactive_inactive('admin_offer',['id'=>$_POST['id']],['title'=>$_POST['title'],'discount'=>$_POST['discount'],'recipe_id'=>$_POST['recipe_id'],'description'=>$_POST['description'],'start_date'=>$_POST['start_date'],'end_date'=>$_POST['end_date'],'discount_type'=>$_POST['discount_type']])){
				$this->json_output(array('status'=>true));
			}
			else{
				$this->json_output(array('status'=>false));
			}
		}
		else{
			$check_recipe_added = $this->Restaurant_offer->select_where('admin_offer',['recipe_id'=>$_POST['recipe_id']]);
			if(!empty($check_recipe_added)){
				$this->json_output(array('status'=>false,'msg'=>"Recipe Already Added in previous offer."));
			}
			else{
				if($this->Restaurant_offer->updateactive_inactive('admin_offer',['id'=>$_POST['id']],['title'=>$_POST['title'],'discount'=>$_POST['discount'],'recipe_id'=>$_POST['recipe_id'],'description'=>$_POST['description'],'start_date'=>$_POST['start_date'],'end_date'=>$_POST['end_date'],'discount_type'=>$_POST['discount_type']])){
					$this->json_output(array('status'=>true));
				}
				else{
					$this->json_output(array('status'=>false));
				}

			}
		}
		
	}

	public function update_offer_photo(){
	 	if(!empty($_POST)){
	        if(isset($_POST['image'])){
	        	$rand_no=rand(1111111,9999999);
	        	/*if(SERVER=="testing")
					$image_url='test/restaurantoffers/'.$rand_no.'.jpg';
				else
					$image_url='restaurantoffers/'.$rand_no.'.jpg';*/
					$image_url='Liveresto/restaurantoffers/'.$rand_no.'.jpg';
	        	$file_path=APPPATH.'../uploads/restaurantoffers/'.$rand_no.'.jpg';
                $img_r = imagecreatefromjpeg($_POST['image']);
				$output=imagejpeg($img_r,$file_path);
				$aws_result=$this->uploadAWSS3($image_url,$file_path);
				gc_collect_cycles();
				unlink($file_path);

				if($image_url!=""){
					
					$m=$this->Restaurant_offer;
	                $m->offer_image=CLOUDFRONTURL.$image_url;
		            if($_POST['id']!=""){
		                $m->id=$_POST['id'];
		                $m->update();
		            }

		            $this->json_output(array('path'=>CLOUDFRONTURL.$image_url,'status'=>true,'msg'=>'Offer image Updated'));
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

    public function bulkaction(){
    	//print_r($_POST);
    	if ($_POST['bulkaction'] == 'Active') {
    		foreach ($_POST['offer_id'] as $key => $value) {
    			//echo $value;
    			$this->Restaurant_offer->updateactive_inactive('admin_offer',['id'=>$value],['status'=>1]);
    		}
    		$this->json_output(array('status'=>true,'msg'=>'Offers Active successfully'));
    	}

    	if ($_POST['bulkaction'] == 'Inactive') {
    		foreach ($_POST['offer_id'] as $key => $value) {
    			$this->Restaurant_offer->updateactive_inactive('admin_offer',['id'=>$value],['status'=>0]);
    		}
    		$this->json_output(array('status'=>true,'msg'=>'Offers Inactive successfully'));
    	}

    	if ($_POST['bulkaction'] == 'Delete') {
    		foreach ($_POST['offer_id'] as $key => $value) {
    			$this->Restaurant_offer->permanent_delete_manager('admin_offer',['id'=>$value]);
    		}
    		$this->json_output(array('status'=>true,'msg'=>'Offers Delected successfully'));
    	}
    }
}