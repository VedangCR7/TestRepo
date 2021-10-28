<?php
	class Delivery_model extends My_Model{
		var $profile_photo;
		var $name;
		var $email;
		var $contact_number;
		var $password;
		var $is_active;
		var $usertype;
		var $upline_id;
		var $tablename="user";
		var $fields=array('profile_photo','name','email','contact_number','password','is_active','usertype','upline_id');

		public function list_manager($page_no,$records_per_page,$searchkey=""){
			$restaurant_count=$this->db->select('count(*) as cnt')->from('user')->where('usertype','Delivery man')->where('upline_id',$_SESSION['user_id'])->get()->row_array();
		  
			if($restaurant_count['cnt']<=0){
				 $this->db->select('*');
				$this->db->from('user');
				$this->db->where('usertype','Delivery man');
				$this->db->where('upline_id',$_SESSION['user_id']);
				$this->db->order_by("id DESC");
				$query = $this->db->get();
				$result = $query->result_array();
	
				return  array(
					'manager'=>$result,
					'total_count'=>$restaurant_count['cnt'],
					'total_pages'=>1,
					'page_no'=>1,
					'page_total_text'=>"0 - ".$restaurant_count['cnt']
				); 
			}else{
				if($records_per_page=="all"){
					$this->db->select('*');
					$this->db->from('user');
					$this->db->where('usertype','Delivery man');
					$this->db->where('upline_id',$_SESSION['user_id']);
					$this->db->order_by("id DESC");
					if($searchkey!="")
						$this->db->like('lower(name)',strtolower($searchkey));
					$this->db->where('usertype','Delivery man');
					$this->db->where('upline_id',$_SESSION['user_id']);
					$this->db->order_by("id DESC");
					$query = $this->db->get();
	
					$result = $query->result_array();
	 
					return  array(
						'manager'=>$result,
						'total_count'=>$restaurant_count['cnt'],
						'total_pages'=>1,
						'page_no'=>1,
						'page_total_text'=>"1 - ".$restaurant_count['cnt']
					); 
				}else{
	
					if (!isset($page_no)) {
						$page_no = 1;
					}
	
					if (!isset($records_per_page)) {
						$records_per_page = 30;
					}
	
					$offset = ($page_no-1) * $records_per_page;
				   /* echo $offset;
					die;*/
					$this->db->select('*');
					$this->db->from('user');
					$this->db->where('usertype','Delivery man');
					$this->db->where('upline_id',$_SESSION['user_id']);
					$this->db->order_by("id DESC");
					$this->db->limit($records_per_page,$offset);
					$query = $this->db->get();
				   /*  echo $this->db->last_query();
					die;*/
					$result = $query->result_array();
					$total_pages = ceil($restaurant_count['cnt'] / $records_per_page);
	
					if($restaurant_count['cnt']<$records_per_page)
						$to_page=$restaurant_count['cnt'];
					else
						$to_page=$records_per_page;
					return  array(
						'manager'=>$result,
						'total_count'=>$restaurant_count['cnt'],
						'total_pages'=>$total_pages,
						'page_no'=>$page_no,
						'page_total_text'=>($offset+1)." - ".$to_page
					); 
				}
			}
	
		}
	}
?>