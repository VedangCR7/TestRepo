<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'third_party/aws/aws-autoloader.php';
use Aws\Common\Exception\MultipartUploadException;
use Aws\S3\MultipartUploader;
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
class Profile extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->is_loggedin();
		$this->load->model('user_model');		
	}
	
	public function index() {
		$data=array();
		$user_data=$this->user_model->get_user($_SESSION['user_id']);

		/*if($user_data['img_url']==""){*/
			$this->load->library('ciqrcode');
			$qr_image=rand().'.png';
			/*$params['data'] = $user_data['email']."_".$user_data['id'];
			$params['data'] = $user_data['name']."_".$user_data['id'];*/
			/* qr code name change by Ashwini */
			/* $params['data'] = "FOODNAI-".$user_data['id']; */
			$url=base_url();
			$new_url=str_replace('/admin', '', $url);
			echo $new_url;
			die;
			$newparams = base64_encode($user_data['id']);
			$params['data'] = $new_url."qrcode/".$newparams;
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
		/*}*/

		$data['user']=$user_data;
		/*echo "<pre>";
		print_r($user_data);
		die;
*/		$data['usertype']=$_SESSION['usertype'];
		$this->load->view('profile',$data);
	}

	public function change_password(){
		$this->load->view('change_password');

	}

	public function update_profile(){
		$u = $this->user_model;
		$u->set_values($_POST);
		$status=$u->isexist(array('email'=>$u->email),array('id'=>$u->id));
		if($status=="exist"){
			$this->json_output(array('status'=>false,'msg'=>"Email Already have with us"));
			return;
		}
		$u->update();
		
		$user_id=$u->id;
		$zip=$_POST['postcode'];
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
			$u->id=$user_id;
			$u->update();
		}
		if($user_id){
		    $this->json_output(array('data'=>$this->user_model->get_user($_POST['id']),'status'=>true,'msg'=>"Profile updated successfully."));
		}
		else{
			$this->json_output(array('status'=>false,'msg'=>"Something went wrong please try again !"));
		}
	}

	public function update_password(){
		$u = $this->user_model;
		$status=$u->is_passwordexist($_POST['id'],$_POST['opassword']);
		
		if($status=="not"){
			$this->json_output(array('status'=>false,'msg'=>"You have entered wrong old password."));
			return;
		}
		$u->set_values($_POST);
		$user_id=$u->update();

		if($user_id){
		    $this->json_output(array('id'=>$_POST['id'],'status'=>true,'msg'=>"Password updated successfully."));
		}
		else{
			$this->json_output(array('status'=>false,'msg'=>"Something went wrong please try again !"));
		}
	}

	 public function update_profile_photo(){
	/* echo "<pre>";
	 print_r($_FILES);
	 die;*/
        if(isset($_POST)){

        	if(isset($_POST['image'])){
	        	
	        	$rand_no=rand(1111111,9999999);
        		if(SERVER=="testing")
					$image_url='test/profile/'.$rand_no.'.jpg';
				else
					$image_url='profile/'.$rand_no.'.jpg';
	        	$file_path='uploads/'.$rand_no.'.jpg';
                $img_r = imagecreatefromjpeg($_POST['image']);
				$output=imagejpeg($img_r,$file_path);
				$aws_result=$this->uploadAWSS3($image_url,$file_path);
				unlink($file_path);

				if($image_url!=""){
					$u=$this->user_model;
		        	if($image_url!="")
		                $u->profile_photo=CLOUDFRONTURL.$image_url;
		            if($_POST['id']!=""){
		                $u->id=$_POST['id'];
		                $u->update();
		                $user_id=$_POST['id'];
		            }

		            $_SESSION['profile_photo']=CLOUDFRONTURL.$image_url;
					
		           $this->json_output(array('path'=>CLOUDFRONTURL.$image_url,'status'=>true,'msg'=>'Profile Photo Upated'));
					return;
				}else{
					$this->json_output(array('status'=>false,'msg'=>'Something went wrong please try again.'));
					return;

				}	

	        }
        	/*switch(strtolower($_FILES['image']['type']))
	        {
	            case 'image/png':
        			$file_path='uploads/profile/'.rand(11111,99999).'.png';
	                $img_r = imagecreatefrompng($_POST['img']);
					$dst_r = ImageCreateTrueColor( $_POST['w'], $_POST['h'] );

					imagecopyresampled($dst_r, $img_r, 0, 0, $_POST['x'], $_POST['y'], $_POST['w'], $_POST['h'], $_POST['w'],$_POST['h']);

		  			header('Content-type: image/png');
					$output=imagepng($dst_r,$file_path);

					$u=$this->user_model;
		        	if($file_path!="")
		                $u->profile_photo=$file_path;
		            if($_POST['id']!=""){
		                $u->id=$_POST['id'];
		                $u->update();
		                $user_id=$_POST['id'];
		            }

		            $_SESSION['profile_photo']=$file_path;
					$this->json_output(array('path'=>$file_path,'status'=>true,'msg'=>'Profile Photo Upated'));
					return;
	            break;
	            case 'image/jpeg':
        			$file_path='uploads/profile/'.rand(11111,99999).'.jpg';

	                $img_r = imagecreatefromjpeg($_POST['img']);
					$dst_r = ImageCreateTrueColor( $_POST['w'], $_POST['h'] );

					imagecopyresampled($dst_r, $img_r, 0, 0, $_POST['x'], $_POST['y'], $_POST['w'], $_POST['h'], $_POST['w'],$_POST['h']);

		  			header('Content-type: image/jpeg');
					$output=imagejpeg($dst_r,$file_path);

					$u=$this->user_model;
		        	if($file_path!="")
		                $u->profile_photo=$file_path;
		            if($_POST['id']!=""){
		                $u->id=$_POST['id'];
		                $u->update();
		                $user_id=$_POST['id'];
		            }

		            $_SESSION['profile_photo']=$file_path;
					$this->json_output(array('path'=>$file_path,'status'=>true,'msg'=>'Profile Photo Upated'));
					return;
	            break;
	            default:
	               $this->json_output(array('path'=>$file_path,'status'=>true,'msg'=>'Image file format not supported.'));
					return;
	        }
        	*/
            /*$u=$this->user_model;
            if(!empty($_FILES)){

                if($_FILES['image']['name']!=""){
                    $result = $u->upload_image('image');
                    if($result['status']==false){
                        $this->json_output($result);
                        return false;
                    }else{
		                if($result['path']!="")
		                    $u->profile_photo=$result['path'];
			            if($_POST['id']!=""){
			                $u->id=$_POST['id'];
			                $u->update();
			                $user_id=$_POST['id'];
			            }

			            $_SESSION['profile_photo']=$result['path'];
            			$this->json_output(array('path'=>$result['path'],'status'=>true,'msg'=>'Profile Photo Upated'));
            			return;
                    }

                   
                }
            }else{
            	$this->json_output(array('status'=>false,'msg'=>'Please select file to upload'));
            }*/
        }else
            $this->json_output(array('status'=>false,'msg'=>'Something went wrong please try again.'));
    }

}
?>