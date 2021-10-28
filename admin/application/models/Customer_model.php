<?php
class Customer_model extends My_Model {
	var $name;
	var $contact_no;
	var $email;
    var $restaurant_id;
    var $is_block;
    var $tablename="customer";
    var $fields=array('name','contact_no','email','restaurant_id','is_block');
    public function __construct()
    {
    	$this->load->database();
    }

    function insertRecord($record){
        
        if(count($record) > 0){
            
            // Check user
            $this->db->select('*');
            $this->db->where('name', $record[0]);
            $q = $this->db->get('customer');
            $response = $q->result_array();
            
            // Insert record
            if(count($response) == 0){
                $newuser = array(
                    "name" => trim($record[0]),
                    "contact_no" => trim($record[1]),
                    "email" => trim($record[2]),
                    "restaurant_id" => $_SESSION['user_id'],
                    "is_block"=>0
                );

                $this->db->insert('customer', $newuser);
            }
            
        }
        
    }

    public function check_user($contact_no){
        $this->db->select("*");
        $this->db->from('customer');
        $this->db->where('contact_no',$contact_no);
        $this->db->where('restaurant_id',$_SESSION['user_id']);
        $query = $this->db->get();
        $row = $query->row_array();
        return  $row; 
    }

    public function add_user($data){
        return $this->db->insert('customer',$data);
    }

    public function insert_query($table,$data){
        return $this->db->insert($table,$data);
    }

    public function select_where($table,$condition){
        return $this->db->where($condition)->get($table)->result_array();
    }

    public function updateactive_inactive($table,$condition,$data)
    {
        return $this->db->where($condition)->update($table, $data);
    }

    public function query($query)
    {
        return $this->db->query($query)->result_array();
    }

    public function get_customer($id){

        $this->db->select('*');
        $this->db->from('customer');
        $this->db->where('id',$id);  
        $query = $this->db->get();
        $result=$query->row_array();
        return $result;
    }


    public function do_login($post){
        $this->db->select('*');
        $this->db->from('customer');
        $this->db->where('contact_no',$post['contact_no']);  
        $query = $this->db->get();
        if($query->num_rows()){
            $result=$query->row_array();

            $this->db->where('id',$result['id']);
            $this->db->update('customer',array(
                'name'=>$post['name'],
                "contact_no"=>$post['contact_no'],
                'email'=>$post['email'],
                'restaurant_id'=>$post['restaurant_id']
            ));

            $customerdata = array(
               'customer_id'=>$result['id'],
               'name'=> $post['name'],
               'email'=> $post['email'],  
               'contact_no'=> $post['contact_no'],  
               'logged_in' => TRUE
            ); 
            $this->session->set_userdata('customer',$customerdata);
            return $result;
        }
        else{

        	$c=$this->customer_model;
        	$c->name=$post['name'];
        	$c->email=$post['email'];
        	$c->contact_no=$post['contact_no'];
            $c->restaurant_id=$post['restaurant_id'];
			$customer_id=$c->add();
            if($customer_id){
            	$customerdata = array(
	               'customer_id'=>$customer_id,
	               'name'=> $post['name'],
	               'email'=> $post['email'],  
	               'contact_no'=> $post['contact_no'],  
                   'restaurant_id'=>$post['restaurant_id'],
	               'logged_in' => TRUE
	            ); 
	            $this->session->set_userdata('customer',$customerdata);
	            return array(
	            	'id'=>$customer_id,
	                'name'=> $post['name'],
	                'email'=> $post['email'],  
	                'contact_no'=> $post['contact_no']  
	            );
            }else{
            	return false;
            }
        }
    }

    public function check_contact($post){

        $this->db->select('*');
        $this->db->from('customer');
        $this->db->where('contact_no',$post['contact_no']);
        $this->db->where('restaurant_id',$post['restaurant_id']);
        $query = $this->db->get();
        if($query->num_rows()){
            $result=$query->row_array();
            return $result;
        }else{
            return 'notexist';
        }
    }

    public function block_unblock_customer($id,$is_block){
        $this->db->where('id',$id);
        $this->db->update('customer',array(
            'is_block'=>$is_block
        ));
    }

    public function importData($data) {
 
        $res = $this->db->insert_batch('customer',$data);
        if($res){
            return TRUE;
        }else{
            return FALSE;
        }
 
    }
	
	public function list_customers($page_no,$records_per_page,$restaurant_id,$searchkey="")
	{
        if($records_per_page=="all")
		{
            $this->db->select("c.*");
            $this->db->from('customer c');
            $this->db->where('c.restaurant_id',$_SESSION['user_id']);
            
			if($searchkey!="")
                $this->db->like('lower(c.name)',strtolower($searchkey));
            
			$this->db->order_by('c.id desc');
            $query = $this->db->get();
            $result = $query->result_array();

            $customer_count=$this->db->select('count(*) as cnt')->from('customer')->where('restaurant_id',$_SESSION['user_id'])->get()->row_array();

            return  array(
                'customers'=>$result,
                'total_count'=>$customer_count['cnt'],
                'total_pages'=>1,
                'page_no'=>1,
                'page_total_text'=>"1 - ".$customer_count['cnt']
            ); 
        }
		else
		{
            if (!isset($page_no)) 
			{
                $page_no = 1;
            }

            if (!isset($records_per_page)) 
			{
                $records_per_page = 30;
            }

            $offset = ($page_no-1) * $records_per_page;
            
            $this->db->select("c.*");
            $this->db->from('customer c');
            $this->db->where('c.restaurant_id',$_SESSION['user_id']);
            $this->db->order_by('c.id desc');
            $this->db->limit($records_per_page,$offset);
            $query = $this->db->get();
            /*echo $this->db->last_query();
            die;*/
            $result = $query->result_array();
          /*  echo "<pre>";
            print_r($result);
            die;*/
            $group_count=$this->db->select('count(*) as cnt')->from('customer')->where('restaurant_id',$_SESSION['user_id'])->get()->row_array();
            $total_pages = ceil($group_count['cnt'] / $records_per_page);

            if($group_count['cnt']<$records_per_page*$page_no)
                $to_page=$group_count['cnt'];
            else
                $to_page=$records_per_page*$page_no;
            
			return  array(
                'customers'=>$result,
                'total_count'=>$group_count['cnt'],
                'total_pages'=>$total_pages,
                'page_no'=>$page_no,
                'page_total_text'=>($offset+1)." - ".$to_page
            ); 
        }
    }

}
?>