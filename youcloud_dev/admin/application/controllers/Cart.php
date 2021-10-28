<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Cart extends MY_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('cart');
        $this->load->model('recipes_model');

    }

    public function addCart(){
		//print_r($_POST);exit();
		if($_POST['rowid']!="" && $_POST['rowid']!=false){
			if(isset($_POST['addon'])){
			$addon = []; 
			$price= $_POST['price'];
			foreach($_POST['addon'] as $key => $value){
				$addon[] = array('addon_id'=>$_POST['addon_id'][$key],'addon_name'=>$value,'addon_price'=>$_POST['addonprice'][$key],'addon_main_category'=>$_POST['addon_main_category'][$key],'addon_main_category_id'=>$_POST['addon_main_category_id'][$key]);
				$price = $price + $_POST['addonprice'][$key];
			}
			}
			if(isset($_POST['addon'])){
				$update_array = array('rowid'=>$_POST['rowid'],'addon' => $addon,'price' => $price);
			}else{
				$update_array = array('rowid'=>$_POST['rowid'],'qty'=>  $_POST['qty']);
			}
			$data=$this->cart->update($update_array);
			$res=$this->cart->update($data);
		}else{
			if (isset($_POST['customer_name']) && isset($_POST['customer_contact'])){
				$options =array(
		        	'menu_id' => $_POST['id'],
		        	'customer_name'=>$_POST['customer_name'],
		        	'customer_contact'=>$_POST['customer_contact'],
		        	'table_no'=>$_POST['table_number'],
		        	'table_name'=>$_POST['table_name'],
		        	'recipe_type'=>$_POST['recipe_type'],
		        	'table_id'=>$_POST['table_id'],
		        );
			}
			else{
				$options =array(
		        	'menu_id' => $_POST['id'], 
		        	'customer_id'=>$_POST['customer_id'],
		        	'recipe_type'=>$_POST['recipe_type'],
		        	'table_id'=>$_POST['table_id'],
		        );
			}
			$price= $_POST['price'];
			$addon = [];
			if(!empty($_POST['addon'])){ 
				foreach($_POST['addon'] as $key => $value){
					$addon[] = array('addon_id'=>$_POST['addon_id'][$key],'addon_name'=>$value,'addon_price'=>$_POST['addonprice'][$key],'addon_main_category'=>$_POST['addon_main_category'][$key],'addon_main_category_id'=>$_POST['addon_main_category_id'][$key]);
					$price = $price + $_POST['addonprice'][$key];
				}
			}

			$data = array(
		        'id'      => 'menu_'.$_POST['id'].rand(1,9999),
		        'qty'     => $_POST['qty'],
		        'price'   => $price,
		        'name'    => $_POST['name'],
				'addon'    => $addon,
				'comment' => $_POST['comment'],
		        'options' => $options
			);

			if(isset($_POST['offer_id']) && $_POST['offer_id']!=""){
				$data['options']['offer_id']=$_POST['offer_id'];
			}

			if(isset($_POST['discount_price']) && $_POST['discount_price']!=""){
				$data['options']['discount_price']=$_POST['discount_price'];
			}
		}
		
		$this->cart->product_name_rules = '\d\D';
		$cart_item_id=$this->cart->insert($data);
		$this->json_output(array('cart_detials'=>$this->recipes_model->get_cart_menu_details(),'count'=>count($this->cart->contents()),'rowid'=>$cart_item_id));
	}


	public function get_cart()
	{
		$cart_detials=$this->recipes_model->get_cart_menu_details();
		/*if(!empty($cart_detials)){
			$before_tableid=$cart_detials['options']['table_id']
		}*/
		$this->json_output(array('cart_detials'=>$cart_detials,'count'=>count($this->cart->contents())));

		/*$this->session->unset_userdata('cart_contents');*/
	}

	public function removeCartItem() {   
        $data = array(
            'rowid'   => $_POST['rowid'],
            'qty'     => 0
        );
        $this->cart->update($data);
        $this->json_output(array('cart_detials'=>$this->recipes_model->get_cart_menu_details(),'count'=>count($this->cart->contents())));
	}

	public function updateCart(){

		$data=$this->cart->update(array(
	        'rowid'=>$_POST['rowid'],
	        'qty'=>  $_POST['qty']
	    ));
		$res=$this->cart->update($data);

		$this->json_output($this->recipes_model->get_cart_menu_details());
	}

	public function list_carts(){
		$this->json_output($this->recipes_model->get_cart_menu_details());
	}

	public function addCart_forrest(){
    	foreach($_POST as $x => $val) {
			$_POST[$x]=filter_var($_POST[$x], FILTER_SANITIZE_STRING);
		}
		//print_r($_POST);

		if($_POST['rowid']!="" && $_POST['rowid']!=false){
			$addon_data = explode(',',$_POST['addondata']);
			$addon_price = explode(',',$_POST['addonprice']);
			$addon_id = explode(',',$_POST['addon_id']);
			$addon_main_category = explode(',',$_POST['addon_main_category']);
			if(!empty($addon_data)){
				$addon = []; 
				$price= $_POST['price'];
				foreach($addon_data as $key => $value){
					$addon[] = array('addon_id'=>$addon_id[$key],'addon_name'=>$value,'addon_main_category'=>$addon_main_category[$key]);
					$price = $price + $addon_price[$key];
				}
			}
			if(!empty($addon_data)){
				$update_array = array('rowid'=>$_POST['rowid'],'addon' => $addon,'price' => $price);
			}else{
				$update_array = array('rowid'=>$_POST['rowid'],'qty'=>  $_POST['qty']);
			}
			// $data=$this->cart->update(array(
			//         'rowid'=>$_POST['rowid'],
			//         'qty'=>  $_POST['qty']
			// ));
			$res=$this->cart->update($update_array);
		}else{
			$price= $_POST['price'];
			$addon = array();
			if(!empty($_POST['addondata'])){
			$addon_data = explode(',',$_POST['addondata']);
			$addon_price = explode(',',$_POST['addonprice']);
			$addon_id = explode(',',$_POST['addon_id']);
			$addon_main_category = explode(',',$_POST['addon_main_category']); 
			if(!empty($addon_data)){
				foreach($addon_data as $key => $value){
					$addon[] = array('addon_id'=>$addon_id[$key],'addon_name'=>$value,'addon_main_category'=>$addon_main_category[$key]);
					$price = $price + $addon_price[$key];
				}
			}
			}
			$data = array(
		        'id'      => 'menu_'.$_POST['id'],
		        'qty'     => $_POST['qty'],
		        'price'   => $price,
		        'name'    => $_POST['name'],
		        'productcode'=>$_POST['product_code'],
				'addon'	  => $addon,
		        'options' => array(
		        	'menu_id' => $_POST['id'], 
		        	'recipe_type'=>$_POST['recipe_type'],
		        	'table_id'=>$_POST['table_id'],
					'contact_number'=>$_POST['contact_number'],
					'customer_name'=>$_POST['customer_name'],
					'table_category_id'=>$_POST['table_category_id'],
					'special_notes'=>$_POST['special_notes']
		        )
			);

			if(isset($_POST['offer_id']) && $_POST['offer_id']!=""){
				$data['options']['offer_id']=$_POST['offer_id'];
			}

			if(isset($_POST['discount_price']) && $_POST['discount_price']!=""){
				$data['options']['discount_price']=$_POST['discount_price'];
			}
		}
		
		$this->cart->product_name_rules = '\d\D';
		$cart_item_id=$this->cart->insert($data);
		
		$this->json_output(array('cart_details'=>$this->recipes_model->get_cart_menu_details(),'count'=>count($this->cart->contents()),'rowid'=>$cart_item_id));
	}
}