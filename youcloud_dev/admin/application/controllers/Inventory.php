<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'third_party/aws/aws-autoloader.php';
use Aws\Common\Exception\MultipartUploadException;
use Aws\S3\MultipartUploader;
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

class Inventory extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->is_loggedin();
		$this->load->library('session');
        $this->load->library('cart');
		$this->load->model('inventory_product_model');
		$this->load->model('inventory_supplier_model');
		$this->load->model('inventory_purchase_model');
		$this->load->model('inventory_purchase_items_model');
		$this->load->model('inventory_product_assign_model');
		$this->load->model('inventory_product_assign_items_model');
	}

	public function add_product(){
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		$this->load->view('inventory_add_product',$data);
	}

	public function uploadData(){
		$path = 'assets/';
		require_once APPPATH . "/third_party/PHPExcel.php";
		$config['upload_path'] = $path;
		$config['allowed_types'] = 'csv';
		$config['remove_spaces'] = TRUE;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);            
		if (!$this->upload->do_upload('uploadFile')) {
			$error = array('error' => $this->upload->display_errors());
			//print_r($error);
		} else {
			$data = array('upload_data' => $this->upload->data());
		}
		if(empty($error)){
		  if (!empty($data['upload_data']['file_name'])) {
			$import_xls_file = $data['upload_data']['file_name'];
		} else {
			$import_xls_file = 0;
		}
		$inputFileName = $path . $import_xls_file;
		
		try {
			$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
			$objReader = PHPExcel_IOFactory::createReader($inputFileType);
			$objPHPExcel = $objReader->load($inputFileName);
			$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true, true, true);
			$flag = true;
			$i=0;
			// print_r($allDataInSheet);
			// echo "<br><br>";
			foreach ($allDataInSheet as $value) {
			  if($flag){
				$flag =false;
				continue;
			  }
			  $check = $this->inventory_product_model->select_where('inventory_product',['product_name'=>$value['A'],'restaurant_id'=>$_SESSION['user_id']]);
				  if(empty($check)){
					  if ($value['A'] != '') {
						  $inserdata[$i]['product_name'] = $value['A'];
						  $inserdata[$i]['restaurant_id'] = $_SESSION['user_id'];
						  $i++;
					  }
				  }
				  else{
					  $this->inventory_product_model->updateactive_inactive('inventory_product',['id'=>$check[0]['id']],['product_name'=>$value['A']]);
				  }
			}

			if (empty($inserdata)) {
				$this->json_output(array('status'=>false,'msg'=>'File records are exist.Information updated successfully'));
				exit();
			}

			$result = $this->inventory_product_model->importdata($inserdata);   
			if($result){
				unlink($inputFileName);
				$this->json_output(array('status'=>true));
			  //echo "Imported successfully";
			}else{
				$this->json_output(array('status'=>false,'msg'=>'Something went wrong'));
			  //echo "ERROR !";
			}             

	  } catch (Exception $e) {
		   die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
					. '": ' .$e->getMessage());
		}
	  }else{
		  $this->json_output(array('status'=>false,'msg'=>strip_tags($error['error'])));
		  //echo $error['error'];
		}
	}

	public function save_product_name(){
		$check_product_available = $this->inventory_product_model->select_where('inventory_product',['product_name'=>$_POST['product_name'],'restaurant_id'=>$_SESSION['user_id']]);
		if(empty($check_product_available)){
			$_POST['restaurant_id']= $_SESSION['user_id'];
			if($this->inventory_product_model->insert_any_query('inventory_product',$_POST)){
				$this->json_output(array('status'=>true,'msg'=>'Product Created Successfully'));
			}
			else{
				$this->json_output(array('status'=>false,'msg'=>'Something went wrong'));
			}
			
		}
		else{
			$this->json_output(array('status'=>false,'msg'=>'Product Already Added'));
		}
	}

	public function product_list(){
		$data['product'] = $this->inventory_product_model->select_where('inventory_product',['restaurant_id'=>$_SESSION['user_id']]);
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		$this->load->view('inventory_product_list',$data);	
	}

	public function get_edit_product(){
		//print_r($_POST);
		$product = $this->inventory_product_model->select_where('inventory_product',['id'=>$_POST['id']]);
		$this->json_output($product);
	}

	public function edit_product_information(){
		//print_r($_POST);
		$check_available_product= $this->inventory_product_model->select_where('inventory_product',['id!='=>$_POST['id'],'product_name'=>$_POST['product_name'],'restaurant_id'=>$_SESSION['user_id']]);
		//print_r($check_available_product);exit();
		if(empty($check_available_product)){
		if($this->inventory_product_model->updateactive_inactive('inventory_product',['id'=>$_POST['id']],['product_name'=>$_POST['product_name']])){
			$this->session->set_flashdata('success','Product Updated Successfully');
            redirect('inventory/product_list');
		}
		else{
			$this->session->set_flashdata('danger','Something Went Wrong!please try again!');
            redirect('inventory/product_list');
		}}
		else{
			$this->session->set_flashdata('danger','Product Already Exist!');
            redirect('inventory/product_list');
		}
	}

	public function delete_product(){
		if($this->inventory_product_model->permanent_delete('inventory_product',['id'=>$_POST['id']])){
			$this->json_output(['status'=>true]);
		}
		else{
			$this->json_output(['status'=>false]);
		}
	}

	public function create_supplier(){
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		$this->load->view('inventory_create_supplier',$data);
	}

	public function save_supplier()
	{
		/* print_r($_POST);exit; */
		
		if(!empty($_POST))
		{
    		//$user_details=$this->Waiting_manager_model->check_user($_POST['email']);
			// if (!empty($user_details)) {
			// 	$this->json_output(array('status'=>true,'is_email_exist'=>true,'msg'=>"Email already exists."));
			// 		return;
			// }
			// else{
				$check_supplier_exist = $this->inventory_supplier_model->select_where('inventory_suppliers',['mobile'=>$_POST['mobile'],'restaurant_id'=>$_SESSION['user_id']]);
	        	
				if(!empty($check_supplier_exist)){
					$this->json_output(array('status'=>false,'msg'=>'Mobile Number Already Exist for previous supplier'));
					return;
				}
				
				if(isset($_POST['company_logo']))
				{
	        		$rand_no=rand(1111111,9999999);
	        		
					if(SERVER=="testing")
						$image_url='test/supplier_company_logo/'.$rand_no.'.jpg';
					else
						$image_url='supplier_company_logo/'.$rand_no.'.jpg';
	        		
					$file_path=APPPATH.'../uploads/supplier_company_logo/'.$rand_no.'.jpg';
                	$img_r = imagecreatefromjpeg($_POST['company_logo']);
					$output=imagejpeg($img_r,$file_path);
					$aws_result=$this->uploadAWSS3($image_url,$file_path);
					
					//gc_collect_cycles();
					//unlink($file_path);

					if($image_url!="")
					{
						$m=$this->inventory_supplier_model;
						$m->company_name = $_POST['company_name'];
						$m->company_address = $_POST['company_address'];
						$m->email = $_POST['email'];
						$m->gst_no = $_POST['gst_no'];
						$m->contact_person_name = $_POST['contact_person_name'];
						$m->mobile = $_POST['mobile'];
						$m->owner_name = $_POST['owner_name'];
	                	$m->company_logo=CLOUDFRONTURL.$image_url;
						$m->restaurant_id = $_SESSION['user_id'];
		            	$m->add();
						/* echo $this->db->last_query(); */
		            	$this->json_output(array('path'=>CLOUDFRONTURL.$image_url,'status'=>true,'msg'=>'Supplier Added Successfully'));
						return;
					}
					else
					{
						$this->json_output(array('status'=>false,'msg'=>'Something went wrong please try again.'));
						return;
					}
				}
				else
				{
					$m=$this->inventory_supplier_model;
					$m->company_name = $_POST['company_name'];
					$m->company_address = $_POST['company_address'];
					$m->email = $_POST['email'];
					$m->gst_no = $_POST['gst_no'];
					$m->contact_person_name = $_POST['contact_person_name'];
					$m->mobile = $_POST['mobile'];
					$m->owner_name = $_POST['owner_name'];
					$m->restaurant_id = $_SESSION['user_id'];
					$m->add();
					/* echo $this->db->last_query();exit; */
					$this->json_output(array('status'=>true,'msg'=>'Supplier Added Successfully'));
					return;
				}
			//}
		}
	}

	public function supplier_list(){
		$sql = "SELECT s.*,ifnull(sum(p.paid),0) as total_paid,ifnull(sum(p.balance),0) as due_amount
		FROM inventory_suppliers as s
		LEFT JOIN inventory_create_payment as p on p.supplier_id=s.id
		WHERE s.restaurant_id = ".$_SESSION['user_id']." GROUP BY s.id ORDER BY s.id DESC";
		$data['supplier'] = $this->inventory_product_model->query($sql);
		//print_r($data['supplier']);exit();							  
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		$this->load->view('inventory_supplier_list',$data);
	}

	public function get_edit_supplier(){
		$supplier = $this->inventory_product_model->select_where('inventory_suppliers',['id'=>$_POST['id']]);
		$this->json_output($supplier);
	}

	public function edit_supplier_information(){
		$check_supplier_exist = $this->inventory_supplier_model->select_where('inventory_suppliers',['id!='=>$_POST['id'],'mobile'=>$_POST['mobile'],'restaurant_id'=>$_SESSION['user_id']]);
	    // print_r($check_supplier_exist);exit();
		if(!empty($check_supplier_exist)){
			$this->session->set_flashdata('danger','Mobile number already exist');
            redirect('inventory/supplier_list');
			return false;
		}
		if(isset($_POST['company_logo'])){
			$rand_no=rand(1111111,9999999);
			if(SERVER=="testing")
				$image_url='test/supplier_company_logo/'.$rand_no.'.jpg';
			else
				$image_url='supplier_company_logo/'.$rand_no.'.jpg';
			$file_path=APPPATH.'../uploads/supplier_company_logo/'.$rand_no.'.jpg';
			$img_r = imagecreatefromjpeg($_POST['company_logo']);
			$output=imagejpeg($img_r,$file_path);
			$aws_result=$this->uploadAWSS3($image_url,$file_path);
			gc_collect_cycles();
			unlink($file_path);

			if($image_url!=""){
				
				$m=$this->inventory_supplier_model;
				$m->company_name = $_POST['company_name'];
				$m->company_address = $_POST['company_address'];
				$m->email = $_POST['email'];
				$m->gst_no = $_POST['gst_no'];
				$m->contact_person_name = $_POST['contact_person_name'];
				$m->mobile = $_POST['mobile'];
				$m->owner_name = $_POST['owner_name'];
				$m->company_logo=CLOUDFRONTURL.$image_url;
				if($_POST['id']!=""){
					$m->id=$_POST['id'];
					$m->update();
				}
				$this->session->set_flashdata('success','Supplier Information Updated Successfully');
            	redirect('inventory/supplier_list');
			}else{
				$this->session->set_flashdata('danger','Something went wrong!try again!');
            	redirect('inventory/supplier_list');

			}	

		}
		else{
			$m=$this->inventory_supplier_model;
			$m->company_name = $_POST['company_name'];
			$m->company_address = $_POST['company_address'];
			$m->email = $_POST['email'];
			$m->gst_no = $_POST['gst_no'];
			$m->contact_person_name = $_POST['contact_person_name'];
			$m->mobile = $_POST['mobile'];
			$m->owner_name = $_POST['owner_name'];
			if($_POST['id']!=""){
				$m->id=$_POST['id'];
				$m->update();
			}
			$this->session->set_flashdata('success','Supplier Information Updated Successfully');
            redirect('inventory/supplier_list');
		}
	}

	public function delete_supplier(){
		if($this->inventory_product_model->permanent_delete('inventory_suppliers',['id'=>$_POST['id']])){
			$this->json_output(['status'=>true]);
		}
		else{
			$this->json_output(['status'=>false]);
		}
	}

	public function payment_create(){
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		$data['supplier'] = $this->inventory_product_model->select_where('inventory_suppliers',['restaurant_id'=>$_SESSION['user_id']]);
		$this->load->view('inventory_payment_create',$data);
	}

	public function save_created_payment(){
		//print_r($_POST);
		$_POST['restaurant_id'] = $_SESSION['user_id'];
		if($_POST['discount'] == ''){
				$_POST['discount']=null;
		}
		if($this->inventory_product_model->insert_any_query('inventory_create_payment',$_POST)){
			$this->json_output(['status'=>true]);
		}else{
			$this->json_output(['status'=>false]);
		}
	}

	public function purchase_create(){
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		$data['supplier'] = $this->inventory_product_model->select_where('inventory_suppliers',['restaurant_id'=>$_SESSION['user_id']]);
		$this->load->view('inventory_purchase_create',$data);
	}

	public function list_product_for_purchase(){

		$products=$this->inventory_product_model->list_product_typahead();

		echo json_encode($products);
	}

	public function purchase_list(){
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		$sql = "SELECT p.id,p.purchase_order_no,p.supplier_id,p.grand_total,COUNT(pi.purchase_id) as no_of_product,SUM(pi.qty) as no_of_qty,s.company_name FROM inventory_purchase AS p LEFT JOIN inventory_purchase_item as pi on p.id = pi.purchase_id LEFT JOIN inventory_suppliers as s on p.supplier_id = s.id WHERE p.restaurant_id=53 GROUP BY pi.purchase_id ORDER BY p.id desc";
		$data['purchase_details'] = $this->inventory_product_model->query($sql);
		$this->load->view('inventory_purchase_list',$data);
	}

	public function purchase_invoice_details(){
		$purchase_id = $this->uri->segment(3);
		$purchase_details = $this->inventory_product_model->select_where('inventory_purchase',['id'=>$purchase_id]);
		$purchase_items = $this->inventory_product_model->select_where('inventory_purchase_item',['purchase_id'=>$purchase_id]);
		// echo "<pre>"; print_r($purchase_details);print_r($purchase_items);exit();
		$invoice_details = $this->inventory_product_model->select_where('inventory_purchase_invoice',['purchase_id'=>$purchase_id]);
		if(empty($invoice_details)){
			$sql="SELECT * FROM inventory_purchase ORDER BY id DESC LIMIT 1";
			$check_last_id =$this->inventory_product_model->query($sql);
			if(empty($check_last_id)){
				$last_id = 1;
				$formated_id=str_pad($last_id, 7, '0', STR_PAD_LEFT);
			}else{
				$last_id = $check_last_id[0]['id']+1;
				$formated_id=str_pad($last_id, 7, '0', STR_PAD_LEFT);
			}
			date_default_timezone_set('Asia/Kolkata');								 
			$data = array('invoice_no'=>$formated_id,'purchase_id'=>$purchase_id,'supplier_id'=>$purchase_details[0]['supplier_id'],'grand_total'=>$purchase_details[0]['grand_total']);
			$this->inventory_product_model->insert_any_query('inventory_purchase_invoice',$data);
			$last_id = $this->db->insert_id();
			foreach($purchase_items as $key => $value){
				$data1=array('invoice_id'=>$last_id,'product_id'=>$value['product_id'],'qty'=>$value['qty'],'price'=>$value['price']);
				$this->inventory_product_model->insert_any_query('inventory_purchase_invoice_item',$data1);
			}
		}
		$sql = "SELECT i.*,ii.*,p.product_name,s.company_name
		FROM inventory_purchase_invoice as i
		LEFT JOIN inventory_purchase_invoice_item as ii on ii.invoice_id = i.id
		LEFT JOIN inventory_product as p on p.id = ii.product_id
		LEFT JOIN inventory_suppliers as s on s.id = i.supplier_id
		WHERE i.purchase_id =".$purchase_id;
		//echo $sql;
		$data['invoice_details'] = $this->inventory_product_model->query($sql);
		//print_r($data['invoice_details']);exit();
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		$this->load->view('inventory_purchase_invoice_details',$data);
	}



	public function purchase_product_cart(){
		//print_r($_POST);exit();
		foreach($_POST as $x => $val) {
			$_POST[$x]=filter_var($_POST[$x], FILTER_SANITIZE_STRING);
		}
		if($_POST['rowid']!="" && $_POST['rowid']!=false){
			$data=$this->cart->update(array(
			        'rowid'=>$_POST['rowid'],
			        'qty'=>  $_POST['qty'],
					'price'=>  $_POST['price']
			));
			$res=$this->cart->update($data);
		}else{

			$data = array(
		        'id'      => 'product_'.$_POST['id'],
				'product_id'      => $_POST['id'],
		        'qty'     => $_POST['qty'],
		        'price'   => $_POST['price'],
		        'name'    => $_POST['product_name'],
				'is_purchase'=>$_POST['is_purchase']
			);
		}
		$this->cart->product_name_rules = '\d\D';
		$cart_item_id=$this->cart->insert($data);
		$this->json_output(array('cart_details'=>$this->inventory_product_model->get_cart_menu_details(),'count'=>count($this->cart->contents()),'rowid'=>$cart_item_id));
	}

	public function get_purchase_cart(){
		$cart_detials=$this->inventory_product_model->get_cart_menu_details();
		$this->json_output(array('cart_detials'=>$cart_detials,'count'=>count($this->cart->contents())));
	}

	public function purchase_order_placeorder(){
		date_default_timezone_set("Asia/Kolkata");
		$rest_id = $_SESSION['user_id'];
		$restaurant = $this->inventory_product_model->select_where('user',['id'=>$rest_id])[0];
		$cart_details=$this->inventory_product_model->get_cart_menu_details();
		// print_r($cart_details);exit();
		$o=$this->inventory_purchase_model;
		$o->grand_total=$_POST['grand_total'];
		$o->restaurant_id=$rest_id;
		$o->supplier_id=$_POST['supplier_id'];
		$o->date=$_POST['date'];
		$purchase_id=$o->add();
		foreach ($cart_details as $cart) 
		{
			$oi=$this->inventory_purchase_items_model;
			$oi->purchase_id=$purchase_id;
			$oi->product_id=$cart['product_id'];
			$oi->qty=$cart['qty'];
			$oi->price=$cart['price'];
			// $oi->total=$cart['subtotal'];
			$oi->restaurant_id=$rest_id;
			$oi->add();
		}

		$restaurant_name=$restaurant['name'];
		$intial=substr($restaurant_name, 0, 2);
		$formated_id=str_pad($purchase_id, 8, '0', STR_PAD_LEFT);

		$o=$this->inventory_purchase_model;
		$o->id=$purchase_id;
		$o->purchase_order_no=$intial.$formated_id;
		$order=$o->update();

		if($purchase_id)
		{
			$this->session->unset_userdata('cart_contents');
			$this->json_output(array('status'=>true,'msg'=>'Order Placed Successfully.'));
		}
		else
		{
			$this->json_output(array('status'=>false,'msg'=>'Something went wrong please try again.'));
		}
	}

	public function get_payable_amount(){
		$sql = "SELECT IFNULL(SUM(grand_total),0) as grand_total FROM `inventory_purchase` where supplier_id = ".$_POST['supplier_id'];
		$grand_total = $this->inventory_product_model->query($sql)[0];
		$sql1 = "SELECT IFNULL(SUM(paid),0) as paid_total FROM `inventory_create_payment` where supplier_id = ".$_POST['supplier_id'];
		$paid_total = $this->inventory_product_model->query($sql1)[0];
		$sql2 = "SELECT IFNULL(SUM(discount),0) as discount_total FROM `inventory_create_payment` where supplier_id = ".$_POST['supplier_id'];
		$discount_total = $this->inventory_product_model->query($sql2)[0];
		$payable_amount = ($grand_total['grand_total'] - $paid_total['paid_total']) - $discount_total['discount_total'];
		$this->json_output(['payable_amount'=>$payable_amount,'total_amount'=>$grand_total['grand_total']]);
	}

	public function payment_list(){
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		$sql = "SELECT ip.*,s.*
		FROM inventory_create_payment AS ip
		LEFT JOIN inventory_suppliers AS s ON s.id = ip.supplier_id
		WHERE ip.restaurant_id =".$_SESSION['user_id']." order by ip.id desc";
		$data['payment_details'] = $this->inventory_product_model->query($sql);
		$this->load->view('inventory_payment_list',$data);
	}

	public function product_assign_kitchen(){
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		$data['supplier'] = $this->inventory_product_model->select_where('inventory_suppliers',['restaurant_id'=>$_SESSION['user_id']]);
		$this->load->view('inventory_product_assign',$data);
	}

	public function list_product_for_assign_kitchen(){
		$sql = "SELECT pi.product_id as id , pro.product_name as name,SUM(pi.qty) as qty,ifnull(SUM(ipa.assign_quantity),0) as assign_qty FROM inventory_purchase_item AS pi LEFT JOIN inventory_product AS pro on pro.id = pi.product_id LEFT JOIN inventory_purchase AS p on p.id = pi.purchase_id LEFT JOIN inventory_suppliers AS s on s.id = p.supplier_id LEFT JOIN inventory_product_assign_kitchen_items AS ipa on ipa.product_id = pi.product_id WHERE p.supplier_id =".$_GET['supplier_id']." GROUP BY pi.product_id";
		
		$products=$this->inventory_product_model->query($sql);
	
		$this->json_output($products);
	}

	public function assign_kitchen_product_cart(){
		foreach($_POST as $x => $val) {
			$_POST[$x]=filter_var($_POST[$x], FILTER_SANITIZE_STRING);
		}
		$available_qty = $_POST['purchase_qty'] - $_POST['assign_qty'];
		//print_r($_POST);
		if($_POST['rowid']!="" && $_POST['rowid']!=false){
			$data=$this->cart->update(array(
			        'rowid'=>$_POST['rowid'],
					'purchase_qty'=>  $_POST['purchase_qty'],
			        'qty'=>  $_POST['assign_qty'],
					'available_qty'=> $available_qty
			));
			$res=$this->cart->update($data);
		}else{
			$data = array(
				'id'  => 'Product'.$_POST['id'],
				'product_id'  => $_POST['id'],
		        'purchase_qty' => $_POST['purchase_qty'],
				'qty' => $_POST['assign_qty'],
				'available_qty'     => $available_qty,
		        'name'    => $_POST['product_name'],
				'is_purchase' =>$_POST['is_purchase'],
				'supplier_id' => $_POST['supplier_id'],
				'price'=>0
			);
		
		}
		$this->cart->product_name_rules = '\d\D';
		$cart_item_id=$this->cart->insert($data);
		$this->json_output(array('cart_details'=>$this->inventory_product_model->get_cart_menu_details(),'count'=>count($this->cart->contents()),'rowid'=>$cart_item_id));
	}

	public function product_assign_to_kitchen_entry(){
		date_default_timezone_set("Asia/Kolkata");
		$rest_id = $_SESSION['user_id'];
		$restaurant = $this->inventory_product_model->select_where('user',['id'=>$rest_id])[0];
		$cart_details=$this->inventory_product_model->get_cart_menu_details();
		//print_r($cart_details);exit();
		$o=$this->inventory_product_assign_model;
		$o->total_purchase_quantity=$_POST['total_purchase_quantity'];
		$o->total_assign_quantity=$_POST['total_assign_quantity'];
		$o->total_remaining_quantity=$_POST['total_remaining_quantity'];
		$o->restaurant_id=$rest_id;
		$o->supplier_id=$_POST['supplier_id'];
		$o->date=$_POST['date'];
		$o->created_at=date('Y-m-d h:i:s');
		$assign_id=$o->add();
		foreach ($cart_details as $cart) 
		{
			$oi=$this->inventory_product_assign_items_model;
			$oi->assign_id=$assign_id;
			$oi->product_id=$cart['product_id'];
			$oi->purchase_quantity=$cart['purchase_qty'];
			$oi->assign_quantity=$cart['qty'];
			$oi->remaining_quantity=$cart['available_qty'];
			$oi->supplier_id=$cart['supplier_id'];
			$oi->restaurant_id=$rest_id;
			$oi->add();
		}

		//echo $this->db->last_query();

		$restaurant_name=$restaurant['name'];
		$intial=substr($restaurant_name, 0, 2);
		$formated_id=str_pad($assign_id, 8, '0', STR_PAD_LEFT);

		$o=$this->inventory_product_assign_model;
		$o->id=$assign_id;
		$o->assign_no=$intial.$formated_id;
		$order=$o->update();

		if($assign_id)
		{
			$this->session->unset_userdata('cart_contents');
			$this->json_output(array('status'=>true,'msg'=>'Product Assigned to kitchen.'));
		}
		else
		{
			$this->json_output(array('status'=>false,'msg'=>'Something went wrong please try again.'));
		}
	}

	public function product_assign_kitchen_list(){
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		$sql = "SELECT ak.*,s.company_name,ifnull(count(aki.assign_id),0) as no_of_product,ifnull(sum(aki.assign_quantity),0) as no_of_quantity FROM inventory_product_assign_kitchen AS ak LEFT join inventory_product_assign_kitchen_items as aki on aki.assign_id=ak.id LEFT join inventory_suppliers as s on ak.supplier_id=s.id WHERE ak.restaurant_id = ".$_SESSION['user_id']." group by aki.assign_id ORDER BY aki.assign_id DESC";
		$data['assign_kitchen_details'] = $this->inventory_product_model->query($sql);
		$this->load->view('inventory_product_assign_kitchen_list',$data);
	}


	public function assign_kitchen_invoice_details(){
		$assign_id = $this->uri->segment(3);
		$purchase_details = $this->inventory_product_model->select_where('inventory_product_assign_kitchen',['id'=>$assign_id]);
		$purchase_items = $this->inventory_product_model->select_where('inventory_product_assign_kitchen_items',['assign_id'=>$assign_id]);
		// echo "<pre>"; print_r($purchase_details);print_r($purchase_items);exit();
		$invoice_details = $this->inventory_product_model->select_where('inventory_assign_product_invoice',['assign_id'=>$assign_id]);
		if(empty($invoice_details)){
			$data = array('invoice_no'=>$purchase_details[0]['assign_no'],'assign_id'=>$assign_id,'supplier_id'=>$purchase_details[0]['supplier_id'],'total_purchase_quantity'=>$purchase_details[0]['total_purchase_quantity'],'total_assign_quantity'=>$purchase_details[0]['total_assign_quantity'],'total_remaining_quantity'=>$purchase_details[0]['total_remaining_quantity'],'restaurant_id'=>$_SESSION['user_id']);
			$this->inventory_product_model->insert_any_query('inventory_assign_product_invoice',$data);
			$last_id = $this->db->insert_id();
			foreach($purchase_items as $key => $value){
				$data1=array('invoice_id'=>$last_id,'product_id'=>$value['product_id'],'purchase_quantity'=>$value['purchase_quantity'],'assign_quantity'=>$value['assign_quantity'],'remaining_quantity'=>$value['remaining_quantity'],'supplier_id'=>$value['supplier_id'],'restaurant_id'=>$value['restaurant_id']);
				$this->inventory_product_model->insert_any_query('inventory_assign_product_invoice_item',$data1);
			}
		}
		$sql = "SELECT i.*,ii.*,p.product_name,s.company_name
		FROM inventory_assign_product_invoice as i
		LEFT JOIN inventory_assign_product_invoice_item as ii on ii.invoice_id = i.id
		LEFT JOIN inventory_product as p on p.id = ii.product_id
		LEFT JOIN inventory_suppliers as s on s.id = i.supplier_id
		WHERE i.assign_id =".$assign_id;
		//echo $sql;
		$data['assign_kitchen_details'] = $this->inventory_product_model->query($sql);
		//print_r($data['invoice_details']);exit();
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		$this->load->view('inventory_assign_kitchen_invoice',$data);
	}

	public function product_report(){
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		
		if(!empty($_POST)){
			$from_date = $_POST['from_date'].' 00:00:00';
			$to_date = $_POST['to_date'].' 23:59:59';
			$sql = "SELECT p.id,p.product_name,ifnull(SUM(ipi.qty),0) as pur_qty,ifnull(SUM(ipi.price),0) as pur_price,ifnull(SUM(pai.assign_quantity),0) as assign_quantity,ifnull(SUM(pai.remaining_quantity),0) as remaining_quantity
			from inventory_product as p 
			LEFT JOIN inventory_purchase_item AS ipi on ipi.product_id=p.id
			LEFT JOIN inventory_product_assign_kitchen_items AS pai on pai.product_id=p.id
			WHERE p.restaurant_id=".$_SESSION['user_id']." AND p.created_at>='".$from_date."' AND p.created_at<='".$to_date."' group by ipi.product_id ,pai.product_id";
			$data['product'] = $this->inventory_product_model->query($sql);
		}
		else{
			$from_date = date('Y-m-d').' 00:00:00';
			$to_date = date('Y-m-d').' 23:59:59';
			$sql = "SELECT p.id,p.product_name,ifnull(SUM(ipi.qty),0) as pur_qty,ifnull(SUM(ipi.price),0) as pur_price,ifnull(SUM(pai.assign_quantity),0) as assign_quantity,ifnull(SUM(pai.remaining_quantity),0) as remaining_quantity
			from inventory_product as p 
			LEFT JOIN inventory_purchase_item AS ipi on ipi.product_id=p.id
			LEFT JOIN inventory_product_assign_kitchen_items AS pai on pai.product_id=p.id
			WHERE p.restaurant_id=".$_SESSION['user_id']." AND p.created_at>='".$from_date."' AND p.created_at<='".$to_date."' group by ipi.product_id ,pai.product_id";
			$data['product'] = $this->inventory_product_model->query($sql);
		}
		
		
		$this->load->view('inventory_product_report',$data);
	}

	public function stock_list_report(){

	$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		
		if(!empty($_POST)){
			$from_date = $_POST['from_date'].' 00:00:00';
			$to_date = $_POST['to_date'].' 23:59:59';
			$sql = "SELECT p.id,p.product_name,ifnull(SUM(ipi.qty),0) as pur_qty,ifnull(SUM(ipi.price),0) as pur_price,ifnull(SUM(pai.assign_quantity),0) as assign_quantity,ifnull(SUM(pai.remaining_quantity),0) as remaining_quantity
			from inventory_product as p 
			LEFT JOIN inventory_purchase_item AS ipi on ipi.product_id=p.id
			LEFT JOIN inventory_product_assign_kitchen_items AS pai on pai.product_id=p.id
			WHERE p.restaurant_id=".$_SESSION['user_id']." AND p.created_at>='".$from_date."' AND p.created_at<='".$to_date."' group by ipi.product_id ,pai.product_id";
			$data['product'] = $this->inventory_product_model->query($sql);
		}
		else{
			$from_date = date('Y-m-d').' 00:00:00';
			$to_date = date('Y-m-d').' 23:59:59';
			$sql = "SELECT p.id,p.product_name,ifnull(SUM(ipi.qty),0) as pur_qty,ifnull(SUM(ipi.price),0) as pur_price,ifnull(SUM(pai.assign_quantity),0) as assign_quantity,ifnull(SUM(pai.remaining_quantity),0) as remaining_quantity
			from inventory_product as p 
			LEFT JOIN inventory_purchase_item AS ipi on ipi.product_id=p.id
			LEFT JOIN inventory_product_assign_kitchen_items AS pai on pai.product_id=p.id
			WHERE p.restaurant_id=".$_SESSION['user_id']." AND p.created_at>='".$from_date."' AND p.created_at<='".$to_date."' group by ipi.product_id ,pai.product_id";
			$data['product'] = $this->inventory_product_model->query($sql);
		}
		
		
		$this->load->view('inventory_stock_report',$data);
	}

	public function purchase_report(){
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		$data['supplier'] = $this->inventory_product_model->select_where('inventory_suppliers',['restaurant_id'=>$_SESSION['user_id']]);
		if($_POST['from_date'] !='' && $_POST['to_date']){
			$date_condition = " AND p.created_at >='".$_POST['from_date']." 00:00:00' AND p.created_at<='".$_POST['to_date']." 23:59:59'";
		}
		else{
			$from_date = date('Y-m-d')." 00:00:00";
			$to_date = date('Y-m-d')." 23:59:59";
			$date_condition = " AND p.created_at >='".$from_date."' AND p.created_at<='".$to_date."'";
		}
		if($_POST['supplier_id'] !=''){
			$supplier_condition = ' AND p.supplier_id='.$_POST['supplier_id'];
		}else{
			$supplier_condition =' ';
		}
		$sql = "select p.*,ifnull(count(pi.purchase_id),0) as no_of_product,ifnull(count(pi.qty),0) as no_of_quantity,s.company_name FROM inventory_purchase as p LEFT JOIN inventory_purchase_item AS pi on pi.purchase_id=p.id LEFT JOIN inventory_suppliers AS s on s.id=p.supplier_id WHERE p.restaurant_id = ".$_SESSION['user_id']. $date_condition.$supplier_condition." GROUP BY pi.purchase_id order by p.id desc";
		//exit();
		$data['purchase_details'] = $this->inventory_product_model->query($sql);
		$this->load->view('inventory_purchase_report',$data);
	}

	public function supplier_report(){
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		if($_POST['supplier_id'] != ''){
			$supplier = $this->inventory_product_model->select_where('inventory_suppliers',['id'=>$_POST['supplier_id']]);
		}
		else{
			$supplier = $this->inventory_product_model->select_where('inventory_suppliers',['restaurant_id'=>$_SESSION['user_id']]);
		}
		$supplier_data=array();
		foreach($supplier as $key=>$value){
			$sql = "select ifnull(SUM(grand_total),0) as total_purchase FROM inventory_purchase WHERE supplier_id = ".$value['id'];
			$purchase_total= $this->inventory_product_model->query($sql);
			$total_purchase = $purchase_total[0]['total_purchase'];

			$sql1 = "select ifnull(SUM(paid),0) as payment,ifnull(SUM(discount),0) as discount,ifnull(SUM(balance),0) as balance FROM inventory_create_payment WHERE supplier_id = ".$value['id'];
			$payment_data= $this->inventory_product_model->query($sql1);
			$payment = $payment_data[0]['payment'];
			$discount= $payment_data[0]['discount'];
			$balance= $payment_data[0]['balance'];

			$supplier_data[]=array('supplier_name'=>$value['owner_name'],'organization_name'=>$value['company_name'],'total_purchase'=>$total_purchase,'payment'=>$payment,'discount'=>$discount,'balance'=>$balance);
		}
		$data['supplier_details'] = $supplier_data;
		$data['supplier'] = $this->inventory_product_model->select_where('inventory_suppliers',['restaurant_id'=>$_SESSION['user_id']]);
		$this->load->view('inventory_supplier_report',$data);
	}
	
	public function edit_purchase_list(){
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		$data['supplier'] = $this->inventory_product_model->select_where('inventory_suppliers',['restaurant_id'=>$_SESSION['user_id']]);
		$data['purchase_supplier_id'] = $this->inventory_product_model->select_where('inventory_purchase',['id'=>$this->uri->segment(3)]);
		$this->load->view('inventory_edit_purchase_invoice',$data);
	}

	public function get_edit_purchase_details(){
		$details = array();
		$invoice_details = $this->inventory_product_model->select_where('inventory_purchase_invoice',['purchase_id'=>$_POST['purchase_id']]);
		
		$sql="SELECT ip.*,p.product_name
		FROM inventory_purchase_invoice_item AS ip
		LEFT JOIN inventory_product AS p ON p.id=ip.product_id
		WHERE ip.invoice_id=".$invoice_details[0]['id'];
		$purchase_items = $this->inventory_product_model->query($sql);
		$details = ['invoice_id'=>$invoice_details[0]['id'],'purchase_id'=>$invoice_details[0]['purchase_id'],'supplier_id'=>$invoice_details[0]['supplier_id'],'grand_total'=>$invoice_details[0]['grand_total'],'created_at'=>$invoice_details[0]['created_at'],'purchase_item'=>$purchase_items]; 
		//print_r($details);
		$this->json_output(array($details));
	}

	public function purchase_product_edit_invoice(){
		$invoice_id = $this->inventory_product_model->select_where('inventory_purchase_invoice',['purchase_id'=>$_POST['purchase_id']]);
		$check_product_added=$this->inventory_product_model->select_where('inventory_purchase_item',['purchase_id'=>$_POST['purchase_id'],'product_id'=>$_POST['id']]);

		if(empty($check_product_added)){
			$this->inventory_product_model->updateactive_inactive('inventory_purchase_invoice',['purchase_id'=>$_POST['purchase_id']],['supplier_id'=>$_POST['supplier_id']]);
			$this->inventory_product_model->updateactive_inactive('inventory_purchase',['id'=>$_POST['purchase_id']],['supplier_id'=>$_POST['supplier_id']]);
			$this->inventory_product_model->insert_any_query('inventory_purchase_item',['purchase_id'=>$_POST['purchase_id'],'product_id'=>$_POST['id'],'qty'=>$_POST['qty'],'price'=>$_POST['price'],'restaurant_id'=>$_SESSION['user_id']]);
			$this->inventory_product_model->insert_any_query('inventory_purchase_invoice_item',['invoice_id'=>$invoice_id[0]['id'],'product_id'=>$_POST['id'],'qty'=>$_POST['qty'],'price'=>$_POST['price']]);
			$this->json_output(array('status'=>true));
		}else{
			$this->json_output(array('status'=>false,'msg'=>'Product Already added.'));
		}
	}

	/* public function edit_purchase_list(){
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		$data['supplier'] = $this->inventory_product_model->select_where('inventory_suppliers',['restaurant_id'=>$_SESSION['user_id']]);
		$data['purchase_supplier_id'] = $this->inventory_product_model->select_where('inventory_purchase',['id'=>$this->uri->segment(3)]);
		$this->load->view('inventory_edit_purchase_invoice',$data);
	}

	public function get_edit_purchase_details(){
		$details = array();
		$invoice_details = $this->inventory_product_model->select_where('inventory_purchase_invoice',['purchase_id'=>$_POST['purchase_id']]);
		
		$sql="SELECT ip.*,p.product_name
		FROM inventory_purchase_invoice_item AS ip
		LEFT JOIN inventory_product AS p ON p.id=ip.product_id
		WHERE ip.invoice_id=".$invoice_details[0]['id'];
		$purchase_items = $this->inventory_product_model->query($sql);
		$details = ['invoice_id'=>$invoice_details[0]['id'],'purchase_id'=>$invoice_details[0]['purchase_id'],'supplier_id'=>$invoice_details[0]['supplier_id'],'grand_total'=>$invoice_details[0]['grand_total'],'created_at'=>$invoice_details[0]['created_at'],'purchase_item'=>$purchase_items]; 
		//print_r($details);
		$this->json_output(array($details));
	}

	public function purchase_product_edit_invoice(){
		$invoice_id = $this->inventory_product_model->select_where('inventory_purchase_invoice',['purchase_id'=>$_POST['purchase_id']]);
		$check_product_added=$this->inventory_product_model->select_where('inventory_purchase_item',['purchase_id'=>$_POST['purchase_id'],'product_id'=>$_POST['id']]);

		if(empty($check_product_added)){
			$this->inventory_product_model->updateactive_inactive('inventory_purchase_invoice',['purchase_id'=>$_POST['purchase_id']],['supplier_id'=>$_POST['supplier_id']]);
			$this->inventory_product_model->updateactive_inactive('inventory_purchase',['id'=>$_POST['purchase_id']],['supplier_id'=>$_POST['supplier_id']]);
			$this->inventory_product_model->insert_any_query('inventory_purchase_item',['purchase_id'=>$_POST['purchase_id'],'product_id'=>$_POST['id'],'qty'=>$_POST['qty'],'price'=>$_POST['price'],'restaurant_id'=>$_SESSION['user_id']]);
			$this->inventory_product_model->insert_any_query('inventory_purchase_invoice_item',['invoice_id'=>$invoice_id[0]['id'],'product_id'=>$_POST['id'],'qty'=>$_POST['qty'],'price'=>$_POST['price']]);
			$this->json_output(array('status'=>true));
		}else{
			$this->json_output(array('status'=>false,'msg'=>'Product Already added.'));
		}
	} */

	public function purchase_product_edit_invoice_quantity(){
		//print_r($_POST);exit();
		$invoice_id = $this->inventory_product_model->select_where('inventory_purchase_invoice',['purchase_id'=>$_POST['purchase_id']]);
		
		if($_POST['qty']>0){
			$this->inventory_product_model->updateactive_inactive('inventory_purchase_item',['purchase_id'=>$_POST['purchase_id'],'product_id'=>$_POST['id']],['qty'=>$_POST['qty'],'price'=>$_POST['price']]);
			$this->inventory_product_model->updateactive_inactive('inventory_purchase_invoice_item',['invoice_id'=>$invoice_id[0]['id'],'product_id'=>$_POST['id']],['qty'=>$_POST['qty'],'price'=>$_POST['price']]);
		}else{
			$this->inventory_product_model->permanent_delete('inventory_purchase_item',['purchase_id'=>$_POST['purchase_id'],'product_id'=>$_POST['id']]);
			$this->inventory_product_model->permanent_delete('inventory_purchase_invoice_item',['invoice_id'=>$invoice_id[0]['id'],'product_id'=>$_POST['id']]);
		}
		$all_invoice_item = $this->inventory_product_model->select_where('inventory_purchase_invoice_item',['invoice_id'=>$invoice_id[0]['id']]);
		
		$sum = 0;
		foreach($all_invoice_item as $key => $value){
			$sum = $sum+($value['price']*$value['qty']);
		}

		$this->inventory_product_model->updateactive_inactive('inventory_purchase_invoice',['purchase_id'=>$_POST['purchase_id']],['supplier_id'=>$_POST['supplier_id'],'grand_total'=>$sum]);
		$this->inventory_product_model->updateactive_inactive('inventory_purchase',['id'=>$_POST['purchase_id']],['supplier_id'=>$_POST['supplier_id'],'grand_total'=>$sum]);
		
		$this->json_output(array('status'=>true));
	}

	public function edit_assign_kitchen_invoice(){
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
		$data['supplier'] = $this->inventory_product_model->select_where('inventory_suppliers',['restaurant_id'=>$_SESSION['user_id']]);
		
		$sql1 = "SELECT i.*,ii.*,p.product_name,s.company_name
		FROM inventory_assign_product_invoice as i
		LEFT JOIN inventory_assign_product_invoice_item as ii on ii.invoice_id = i.id
		LEFT JOIN inventory_product as p on p.id = ii.product_id
		LEFT JOIN inventory_suppliers as s on s.id = i.supplier_id
		WHERE i.assign_id =".$this->uri->segment(3);
		
		$data['assign_kitchen_details'] = $this->inventory_product_model->query($sql1);
		

		$this->load->view('inventory_product_assign_edit',$data);
	}

	public function get_all_assign_kitchen_details(){
		$details = array();
		$invoice_details = $this->inventory_product_model->select_where('inventory_assign_product_invoice',['assign_id'=>$_POST['assign_id']]);
		
		$sql="SELECT ip.*,p.product_name
		FROM inventory_assign_product_invoice_item AS ip
		LEFT JOIN inventory_product AS p ON p.id=ip.product_id
		WHERE ip.invoice_id=".$invoice_details[0]['id'];
		$assign_items = $this->inventory_product_model->query($sql);
		$details = ['invoice_id'=>$invoice_details[0]['id'],'assign_id'=>$invoice_details[0]['assign_id'],'supplier_id'=>$invoice_details[0]['supplier_id'],'total_purchase_quantity'=>$invoice_details[0]['total_purchase_quantity'],'total_assign_quantity'=>$invoice_details[0]['total_assign_quantity'],'total_remaining_quantity'=>$invoice_details[0]['total_remaining_quantity'],'assign_item'=>$assign_items]; 
		//print_r($details);
		$this->json_output(array($details));
	}

	public function assign_kitchen_product_edit(){
		//print_r($_POST);exit();
		$_POST['remaining_quantity'] = $_POST['purchase_quantity']-$_POST['assign_quantity'];
		$invoice_id = $this->inventory_product_model->select_where('inventory_assign_product_invoice',['assign_id'=>$_POST['assign_id']]);
		$check_product_added=$this->inventory_product_model->select_where('inventory_product_assign_kitchen_items',['assign_id'=>$_POST['assign_id'],'product_id'=>$_POST['id']]);
		//echo $invoice_id[0]['id'];print_r($check_product_added);exit();
		if(empty($check_product_added)){
			$this->inventory_product_model->insert_any_query('inventory_product_assign_kitchen_items',['assign_id'=>$_POST['assign_id'],'product_id'=>$_POST['id'],'purchase_quantity'=>$_POST['purchase_quantity'],'assign_quantity'=>$_POST['assign_quantity'],'remaining_quantity'=>$_POST['remaining_quantity'],'restaurant_id'=>$_SESSION['user_id'],'supplier_id'=>$_POST['supplier_id']]);
			$this->inventory_product_model->insert_any_query('inventory_assign_product_invoice_item',['invoice_id'=>$invoice_id[0]['id'],'product_id'=>$_POST['id'],'purchase_quantity'=>$_POST['purchase_quantity'],'assign_quantity'=>$_POST['assign_quantity'],'remaining_quantity'=>$_POST['remaining_quantity'],'restaurant_id'=>$_SESSION['user_id'],'supplier_id'=>$_POST['supplier_id']]);
			
			$all_items = $this->inventory_product_model->select_where('inventory_product_assign_kitchen_items',['assign_id'=>$_POST['assign_id']]);
			$purchase_quantity =0;
			$assign_quantity =0;
			$remaining_quantity =0;
			foreach($all_items as $key=>$value){
				$purchase_quantity = $purchase_quantity + $value['purchase_quantity'];
				$assign_quantity = $assign_quantity + $value['assign_quantity'];
				$remaining_quantity = $remaining_quantity + $value['remaining_quantity'];
			
			}
			$this->inventory_product_model->updateactive_inactive('inventory_assign_product_invoice',['assign_id'=>$_POST['assign_id']],['supplier_id'=>$_POST['supplier_id'],'total_purchase_quantity'=>$purchase_quantity,'total_assign_quantity'=>$assign_quantity,'total_remaining_quantity'=>$remaining_quantity]);
			$this->inventory_product_model->updateactive_inactive('inventory_product_assign_kitchen',['id'=>$_POST['assign_id']],['supplier_id'=>$_POST['supplier_id'],'total_purchase_quantity'=>$purchase_quantity,'total_assign_quantity'=>$assign_quantity,'total_remaining_quantity'=>$remaining_quantity]);
			$this->json_output(array('status'=>true));
		}else{
			$this->json_output(array('status'=>false,'msg'=>'Product Already added.'));
		}		
	}

	public function assign_kitchen_product_quatity_edit(){
			//print_r($_POST);
			$invoice_id = $this->inventory_product_model->select_where('inventory_assign_product_invoice',['assign_id'=>$_POST['assign_id']]);
			$_POST['remaining_quantity'] = $_POST['purchase_quantity']-$_POST['assign_quantity'];
			if($_POST['assign_quantity']>0){
				$this->inventory_product_model->updateactive_inactive('inventory_product_assign_kitchen_items',['assign_id'=>$_POST['assign_id'],'product_id'=>$_POST['id']],['purchase_quantity'=>$_POST['purchase_quantity'],'assign_quantity'=>$_POST['assign_quantity'],'remaining_quantity'=>$_POST['remaining_quantity'],'supplier_id'=>$_POST['supplier_id']]);
				$this->inventory_product_model->updateactive_inactive('inventory_assign_product_invoice_item',['invoice_id'=>$invoice_id[0]['id'],'product_id'=>$_POST['id']],['purchase_quantity'=>$_POST['purchase_quantity'],'assign_quantity'=>$_POST['assign_quantity'],'remaining_quantity'=>$_POST['remaining_quantity'],'supplier_id'=>$_POST['supplier_id']]);
			}else{
				$this->inventory_product_model->permanent_delete('inventory_product_assign_kitchen_items',['assign_id'=>$_POST['assign_id'],'product_id'=>$_POST['id']]);
				$this->inventory_product_model->permanent_delete('inventory_assign_product_invoice_item',['invoice_id'=>$invoice_id[0]['id'],'product_id'=>$_POST['id']]);
			}

			$all_items = $this->inventory_product_model->select_where('inventory_product_assign_kitchen_items',['assign_id'=>$_POST['assign_id']]);
			$purchase_quantity =0;
			$assign_quantity =0;
			$remaining_quantity =0;
			foreach($all_items as $key=>$value){
				$purchase_quantity = $purchase_quantity + $value['purchase_quantity'];
				$assign_quantity = $assign_quantity + $value['assign_quantity'];
				$remaining_quantity = $remaining_quantity + $value['remaining_quantity'];
			
			}
			$this->inventory_product_model->updateactive_inactive('inventory_assign_product_invoice',['assign_id'=>$_POST['assign_id']],['supplier_id'=>$_POST['supplier_id'],'total_purchase_quantity'=>$purchase_quantity,'total_assign_quantity'=>$assign_quantity,'total_remaining_quantity'=>$remaining_quantity]);
			$this->inventory_product_model->updateactive_inactive('inventory_product_assign_kitchen',['id'=>$_POST['assign_id']],['supplier_id'=>$_POST['supplier_id'],'total_purchase_quantity'=>$purchase_quantity,'total_assign_quantity'=>$assign_quantity,'total_remaining_quantity'=>$remaining_quantity]);
			$this->json_output(array('status'=>true));
	}

	// public function assign_kitchen_invoice_details(){
	// 	$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();
	// 	$sql = "SELECT ak.assign_no,ak.date,ak.created_at,p.product_name,aki.assign_quantity,s.company_name FROM inventory_product_assign_kitchen AS ak LEFT JOIN inventory_product_assign_kitchen_items AS aki ON aki.assign_id = ak.id LEFT JOIN inventory_product as p ON p.id = aki.product_id LEFT JOIN inventory_suppliers as s ON s.id = aki.supplier_id WHERE ak.restaurant_id = ".$_SESSION['user_id']." AND ak.id = ".$this->uri->segment(3);
	// 	$data['assign_kitchen_details'] = $this->inventory_product_model->query($sql);
	// 	//print_r($data['assign_kitchen_details']);exit();
	// 	$this->load->view('inventory_assign_kitchen_invoice',$data);
	// }

}
?>