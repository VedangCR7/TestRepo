<?php
class Whatsapp_manager_model extends My_Model {
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
    public function check_user($email){
        $this->db->select("*");
        $this->db->from('user');
        $this->db->where('email',$email);
        $query = $this->db->get();
        $row = $query->row_array();
        return  $row;
    }

    public function add_user($data){
    	return $this->db->insert('user',$data);
    }

    public function insert_any_query($table,$data){
        return $this->db->insert($table,$data);
    }

    public function updateactive_inactive($table,$condition,$data){
        return $this->db->where($condition)->update($table, $data);
    }

    public function permanent_delete_manager($table,$condition){
        return $this->db->delete($table,$condition);
    }


    public function list_manager($page_no,$records_per_page,$searchkey=""){
        $waiting_count=$this->db->select('count(*) as cnt')->from('user')->where('usertype','Whatsapp manager')->where('upline_id',$_SESSION['user_id'])->get()->row_array();
      
        if($waiting_count['cnt']<=0){
             $this->db->select('*');
            $this->db->from('user');
            $this->db->where('usertype','Whatsapp manager');
            $this->db->where('upline_id',$_SESSION['user_id']);
            $this->db->order_by("id DESC");
            $query = $this->db->get();
            $result = $query->result_array();

            return  array(
                'manager'=>$result,
                'total_count'=>$waiting_count['cnt'],
                'total_pages'=>1,
                'page_no'=>1,
                'page_total_text'=>"0 - ".$waiting_count['cnt']
            ); 
        }else{
            if($records_per_page=="all"){
                $this->db->select('*');
            	$this->db->from('user');
            	$this->db->where('usertype','Whatsapp manager');
                $this->db->where('upline_id',$_SESSION['user_id']);
            	$this->db->order_by("id DESC");
                if($searchkey!="")
                    $this->db->like('lower(name)',strtolower($searchkey));
                $this->db->where('usertype','Whatsapp manager');
                $this->db->where('upline_id',$_SESSION['user_id']);
                $this->db->order_by("id DESC");
                $query = $this->db->get();

                $result = $query->result_array();
 
                return  array(
                    'manager'=>$result,
                    'total_count'=>$waiting_count['cnt'],
                    'total_pages'=>1,
                    'page_no'=>1,
                    'page_total_text'=>"1 - ".$waiting_count['cnt']
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
            	$this->db->where('usertype','Whatsapp manager');
                $this->db->where('upline_id',$_SESSION['user_id']);
            	$this->db->order_by("id DESC");
                $this->db->limit($records_per_page,$offset);
                $query = $this->db->get();
               /*  echo $this->db->last_query();
                die;*/
                $result = $query->result_array();
                $total_pages = ceil($waiting_count['cnt'] / $records_per_page);

                if($waiting_count['cnt']<$records_per_page)
                    $to_page=$waiting_count['cnt'];
                else
                    $to_page=$records_per_page;
                return  array(
                    'manager'=>$result,
                    'total_count'=>$waiting_count['cnt'],
                    'total_pages'=>$total_pages,
                    'page_no'=>$page_no,
                    'page_total_text'=>($offset+1)." - ".$to_page
                ); 
            }
        }

    }


    public function list_offer($page_no,$records_per_page,$searchkey=""){
        $upline_id=$this->db->select('upline_id')->from('user')->where('id',$_SESSION['user_id'])->get()->result_array();
        //print_r($upline_id);
        $offer_count=$this->db->select('count(*) as cnt')->from('whatsapp_message')->where('restaurant_id',$upline_id[0]['upline_id'])->get()->row_array();
      
        if($offer_count['cnt']<=0){
            $this->db->select('*');
            $this->db->from('whatsapp_message');
            $this->db->where('restaurant_id',$upline_id[0]['upline_id']);
            $this->db->order_by("id DESC");
            $query = $this->db->get();
            $result = $query->result_array();

            return  array(
                'manager'=>$result,
                'total_count'=>$offer_count['cnt'],
                'total_pages'=>1,
                'page_no'=>1,
                'page_total_text'=>"0 - ".$offer_count['cnt']
            ); 
        }else{
            if($records_per_page=="all"){
                $this->db->select('*');
                $this->db->from('whatsapp_message');
                $this->db->where('restaurant_id',$upline_id[0]['upline_id']);
                $this->db->order_by("id DESC");
                if($searchkey!="")
                $this->db->like('lower(offer_text)',strtolower($searchkey));
                $this->db->where('restaurant_id',$upline_id[0]['upline_id']);
                $this->db->order_by("id DESC");
                $query = $this->db->get();

                $result = $query->result_array();
 
                return  array(
                    'manager'=>$result,
                    'total_count'=>$offer_count['cnt'],
                    'total_pages'=>1,
                    'page_no'=>1,
                    'page_total_text'=>"1 - ".$offer_count['cnt']
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
                $this->db->from('whatsapp_message');
                $this->db->where('restaurant_id',$upline_id[0]['upline_id']);
                $this->db->order_by("id DESC");
                $this->db->limit($records_per_page,$offset);
                $query = $this->db->get();
               /*  echo $this->db->last_query();
                die;*/
                $result = $query->result_array();
                $total_pages = ceil($offer_count['cnt'] / $records_per_page);

                if($offer_count['cnt']<$records_per_page)
                    $to_page=$offer_count['cnt'];
                else
                    $to_page=$records_per_page;
                return  array(
                    'manager'=>$result,
                    'total_count'=>$offer_count['cnt'],
                    'total_pages'=>$total_pages,
                    'page_no'=>$page_no,
                    'page_total_text'=>($offset+1)." - ".$to_page
                ); 
            }
        }

    }

    public function select_where($table,$condition){
        return $this->db->where($condition)->get($table)->result_array();
    }

    public function select_order($table,$column,$order)
    {
        return $this->db->order_by($column,'DESC')->get($table)->result_array();
    }

    public function select_where_order($table,$column,$order,$condition)
    {
        return $this->db->where($condition)->order_by($column,$order)->get($table)->result_array();
    }
}
?>