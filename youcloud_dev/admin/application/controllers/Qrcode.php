<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Qrcode extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('user_model');	
		$this->load->model('main_menu_model');	
		$this->load->model('customer_model');	
		$this->load->library('cart');
	}
	
	public function index($restid,$tableid="",$is_website="") 
	{
		if($tableid == 'yes')
		{
			$tableid="";
			$is_website = 'yes';
		}
		
		/* if($tableid=="")
		{
	        redirect("mainmenu/mainmenu/".$restid);
		}
	    else
		{ */
			/*$m=$this->main_menu_model;
			$main_menu_details=$m->list_all();*/
			
			if (base64_encode(base64_decode($restid, true)) === $restid)
			{
				$restid = base64_decode($restid);
			}
			
			if($tableid!="")
			{
				if (base64_encode(base64_decode($tableid, true)) === $tableid)
					$tableid=base64_decode($tableid);
			}

			$user=$this->user_model->get_active_user($restid);
			
			$data=array(
				'restid'=>$restid,
				'user'=>$user
			);
			
			if($tableid!="")
			{
				$data['table']=$this->user_model->get_table_details($tableid);
				
				if(empty($data['table']))
				{
					die('Invalid table.');
				}
				
				$cart_details=$this->cart->contents();

				if(!empty($cart_details))
				{
					$i=0;
					
					foreach($cart_details as $cart)
					{
						if($i==0)
						{
							$before_tableid=$cart['options']['table_id'];
							
							if($before_tableid!=$table_id)
							{
								$this->session->unset_userdata('cart_contents');
							}
						}
						else
						{
							break;
						}
						$i++;
					}
					/*$before_tableid=$cart_details['options']['table_id'];
					if($before_tableid!=$tableid){
						$this->session->unset_userdata('cart_contents');
					}*/
				}
			}
			else
			{
				$data['table']=array();
			}
			
			$data['tableid']=$tableid;
			
			/* if (base64_encode(base64_decode($restid, true)) === $restid)
			{
				$restid = base64_decode($restid);
			} */

			
			$data['restaurantsidebarshow'] =$this->customer_model->select_where('restaurant_menu_authority',['restaurant_id'=>$restid]);
			/* echo $this->db->last_query();exit; */
			$data['is_website'] =$is_website;
			$authority = explode(',',$data['restaurantsidebarshow'][0]['menu_name']);
			
			if($is_website == 'yes')
			{
				/* if(in_array('Online order',$authority))
				{ */
					$this->load->view('web/signup',$data);
				/* }
				else
				{
					redirect(base_url().'mainmenu/mainmenu/'.$restid.'/'.$tableid.'/'.$is_website);
				} */
			}
			else
			{
				/* if(in_array('Order',$authority))
				{ */
					$this->load->view('web/signup',$data);
				/* }
				else
				{
					redirect(base_url().'mainmenu/mainmenu/'.$restid.'/'.$tableid.'/'.$is_website);
				} */
			}
	    /* } */
	}
/*	
	public function mainmenu($restid,$tableid="") {
		$customer=$_SESSION['customer'];
		if (base64_encode(base64_decode($restid, true)) === $restid){
			$restid = base64_decode($restid);
		}
		if($tableid!=""){
			if (base64_encode(base64_decode($tableid, true)) === $tableid)
				$tableid=base64_decode($tableid);
		}

		$user=$this->user_model->get_active_user($restid);
		if($user!="notactivated")
			$this->user_model->update_restaurant_visit_count($restid);
		$data=array(
			'restid'=>$restid,
			'user'=>$user,
			'menu_groups'=>$this->user_model->get_main_menugroup_byuser($restid),
			'customer'=>$customer
		);
		if($tableid!=""){
			$data['table']=$this->user_model->get_table_details($tableid);
		}else{
			$data['table']=array();
		}
		$data['tableid']=$tableid;
		$this->load->view('web/web_hotel',$data);
	}*/

}
?>