<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mainmenu extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('user_model');	
		$this->load->model('main_menu_model');	
		$this->load->model('customer_model');	

	}
	
	public function mainmenu($restid,$tableid="",$is_website="") 
	{
		$customer=$_SESSION['customer'];
		$table_ID = $tableid;
		

		if(is_numeric($restid))
		{
			$restID = $restid;		
		}
		else
		{
			if (base64_encode(base64_decode($restid, true)) === $restid)
			{
				$restid = base64_decode($restid);
			}
			$restID = $restid;
		}
		
		if($tableid!="")
		{
			if (base64_encode(base64_decode($tableid, true)) === $tableid)
				$tableid=base64_decode($tableid);
		}

		$user=$this->user_model->get_active_user($restID);
		
		if($user!="notactivated")
			$this->user_model->update_restaurant_visit_count($restID);
		$data=array(
			'restid'=>$restID,
			'user'=>$user,
			'menu_groups'=>$this->user_model->get_main_menugroup_byuser($restID),
			'customer'=>$customer
		);
		//echo $this->db->last_query();
		//echo "<pre>";
		//print_r($data);exit();
		
		if($tableid!="")
		{
			$data['table']=$this->user_model->get_table_details($table_ID);
		}
		else
		{
			$data['table']=array();
		}
		
		$data['tableid']=$table_ID;
		$data['is_website']=$is_website;
		$data['restaurant_type'] = $this->customer_model->select_where('user',['id'=>$restid]);
		$this->load->view('web/web_hotel',$data);
	}
}
?>