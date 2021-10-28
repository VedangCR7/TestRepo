<?php
ini_set('display_errors', 1);
defined('BASEPATH') OR exit('No direct script access allowed');
	class MY_Controller extends CI_Controller {
		public function __construct()
	    {
	        parent::__construct();
	        $this->load->library('session');
            $this->load->helper('cookie');
            $this->load->model('Sidebar_model');
            $this->load->model('Waiting_manager_model');

	    }
		function has_permission(){
			return true;
		}
	
		public function file_get_contents_utf8($fn)
		 { 
	       $content = file_get_contents($fn); 
	        return mb_convert_encoding($content, 'UTF-8', 
	          mb_detect_encoding($content, 'UTF-8, ISO-8859-1', true)); 
	      
	    } 

	    function convert_to_utf8($content){ 
	         return mb_convert_encoding($content, 'UTF-8'); 
	    }
	    
		public function is_loggedin($status=null){
			if(!$this->session->userdata('logged_in')){
                 redirect('login');
             }
        }

        public function is_manager_delete(){
        	$is_waiting_manager_delete=$this->Waiting_manager_model->select_where('user',['id'=>$_SESSION['user_id']]);
       		//print_r($is_waiting_manager_delete);
       		if (empty($is_waiting_manager_delete)) {
       			redirect('login');
       		}
        }

        public function is_customer_loggedin($status=null){
        	
			if(!$this->session->userdata('customer')){
                 die('Unauthorized');
             }
        }
        
        public function get_menu_of_restaurant(){
			$menudata = $this->Sidebar_model->select_sidebar_menu('restaurant_menu_authority',['restaurant_id'=>$_SESSION['user_id']]);
			return $menudata;
			//$this->load->view('sidebar',$menudata);
		}

        
        public function json_output($data){
			header('Access-Control-Allow-Origin: *');
			header('Content-Type: application/json');
			echo json_encode($data);
		}


		function uploadAWSS3($key, $filePath){
			$s3 = new Aws\S3\S3Client([
				'region'  => 'ap-south-1',
				'version' => 'latest',
				'credentials' => [
					'key'    => " AKIAJLHO2HBVRKCEFIZQ",
					'secret' => "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",
				],
			]);
			
			$result = $s3->putObject([
				'Bucket' => 'foodnai',
				'Key'    =>$key,
				'SourceFile'   => $filePath,
		        'ACL'    => 'public-read',
		        'ContentType' => 'image/jpeg'
			]);

			if(!$result['ObjectURL']){
				return "error";
			}
			return $result;
		}
 

       
	}

?>