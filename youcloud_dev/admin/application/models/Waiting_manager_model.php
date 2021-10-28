<?php
class Waiting_manager_model extends My_Model {
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
		$this->db->where('upline_id',$_SESSION['user_id']);
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

    public function updateactive_inactive($table,$condition,$data)
    {
        return $this->db->where($condition)->update($table, $data);
    }

    public function permanent_delete_manager($table,$condition){
        return $this->db->delete($table,$condition);
    }


    public function list_manager($page_no,$records_per_page,$searchkey=""){
        $waiting_count=$this->db->select('count(*) as cnt')->from('user')->where('usertype','Waitinglist manager')->where('upline_id',$_SESSION['user_id'])->get()->row_array();
      
        if($waiting_count['cnt']<=0){
             $this->db->select('*');
            $this->db->from('user');
            $this->db->where('usertype','Waitinglist manager');
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
            	$this->db->where('usertype','Waitinglist manager');
                $this->db->where('upline_id',$_SESSION['user_id']);
            	$this->db->order_by("id DESC");
                if($searchkey!="")
                    $this->db->like('lower(name)',strtolower($searchkey));
                $this->db->where('usertype','Waitinglist manager');
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
            	$this->db->where('usertype','Waitinglist manager');
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

    public function insert_waiting_cus($table,$data){
        return $this->db->insert($table,$data);
    }

    public function query($query)
    {
        $res=$this->db->query($query);
        if($res){
            return $res->result_array();
        }
        else{
            return false;
        }
    }


    public function todaywaitinglist($page_no,$records_per_page,$searchkey=""){
        $todays_date = date('Y-m-d');
        $upline_id = $this->select_where('user',['id'=>$_SESSION['user_id']])[0];
        $get_upline=$upline_id['upline_id'];
        $waiting_count=$this->db->select('count(*) as cnt')->from('waitinglist_details')->where('calendar_date',$todays_date)->where('is_assign',0)->where('restaurant_id',$get_upline)->where('is_decline',0)->get()->row_array();
      
        if($waiting_count['cnt']<=0){
             $this->db->select('*');
            $this->db->from('waitinglist_details');
            $this->db->where('calendar_date',$todays_date);
            $this->db->where('is_assign',0);
            $this->db->where('is_decline',0);
            $this->db->where('restaurant_id',$get_upline);
            $this->db->order_by("id ASC");
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
                $this->db->from('waitinglist_details');
                $this->db->where('calendar_date',$todays_date);
                $this->db->where('is_assign',0);
                $this->db->where('is_decline',0);
                $this->db->where('restaurant_id',$get_upline);
                $this->db->order_by("id ASC");
                if($searchkey!="")
                    $this->db->like('lower(name)',strtolower($searchkey));
                $this->db->where('calendar_date',$todays_date);
                $this->db->order_by("id ASC");
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
                $this->db->from('waitinglist_details');
                $this->db->where('calendar_date',$todays_date);
                $this->db->where('is_assign',0);
                $this->db->where('is_decline',0);
                $this->db->where('restaurant_id',$get_upline);
                $this->db->order_by("id ASC");
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


    public function assign_list($page_no,$records_per_page,$searchkey=""){
        $assign_count=$this->db->select('count(*) as cnt')->from('waitinglist_details')->where('is_assign',1)->where('restaurant_id',$_SESSION['user_id'])->get()->row_array();
      
        if($assign_count['cnt']<=0){
             $this->db->select('w.*,u.name as action_by');
            $this->db->from('waitinglist_details as w');
            $this->db->join('user as u', 'u.id = w.action_taken','left');
            $this->db->where('w.is_assign',1);
            $this->db->where('w.restaurant_id',$_SESSION['user_id']);
            $this->db->order_by("w.id DESC");
            $query = $this->db->get();
            $result = $query->result_array();

            return  array(
                'manager'=>$result,
                'total_count'=>$assign_count['cnt'],
                'total_pages'=>1,
                'page_no'=>1,
                'page_total_text'=>"0 - ".$assign_count['cnt']
            ); 
        }else{
            if($records_per_page=="all"){
                $this->db->select('w.*,u.name as action_by');
                $this->db->from('waitinglist_details as w');
                $this->db->join('user as u', 'u.id = w.action_taken','left');
                $this->db->where('w.is_assign',1);
                $this->db->where('w.restaurant_id',$_SESSION['user_id']);
                $this->db->order_by("w.id DESC");
                if($searchkey!="")
                    $this->db->like('lower(w.name)',strtolower($searchkey));
                $this->db->where('w.is_assign',1);
                $this->db->where('w.restaurant_id',$_SESSION['user_id']);
                $this->db->order_by("w.id DESC");
                $query = $this->db->get();

                $result = $query->result_array();
 
                return  array(
                    'manager'=>$result,
                    'total_count'=>$assign_count['cnt'],
                    'total_pages'=>1,
                    'page_no'=>1,
                    'page_total_text'=>"1 - ".$assign_count['cnt']
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
                $this->db->select('w.*,u.name as action_by');
                $this->db->from('waitinglist_details as w');
                $this->db->join('user as u', 'u.id = w.action_taken','left');
                $this->db->where('w.is_assign',1);
                $this->db->where('w.restaurant_id',$_SESSION['user_id']);
                $this->db->order_by("w.id DESC");
                $this->db->limit($records_per_page,$offset);
                $query = $this->db->get();
               /*  echo $this->db->last_query();
                die;*/
                $result = $query->result_array();
                $total_pages = ceil($assign_count['cnt'] / $records_per_page);

                if($assign_count['cnt']<$records_per_page)
                    $to_page=$assign_count['cnt'];
                else
                    $to_page=$records_per_page;
                return  array(
                    'manager'=>$result,
                    'total_count'=>$assign_count['cnt'],
                    'total_pages'=>$total_pages,
                    'page_no'=>$page_no,
                    'page_total_text'=>($offset+1)." - ".$to_page
                ); 
            }
        }

    }


    public function decline_list($page_no,$records_per_page,$searchkey=""){
        $decline_count=$this->db->select('count(*) as cnt')->from('waitinglist_details')->where('is_decline',1)->where('restaurant_id',$_SESSION['user_id'])->get()->row_array();
      
        if($decline_count['cnt']<=0){
            $this->db->select('*');
            $this->db->from('waitinglist_details');
            $this->db->where('is_decline',1);
            $this->db->where('restaurant_id',$_SESSION['user_id']);
            $this->db->order_by("id DESC");
            $query = $this->db->get();
            $result = $query->result_array();

            return  array(
                'manager'=>$result,
                'total_count'=>$decline_count['cnt'],
                'total_pages'=>1,
                'page_no'=>1,
                'page_total_text'=>"0 - ".$decline_count['cnt']
            ); 
        }else{
            if($records_per_page=="all"){
                $this->db->select('*');
                $this->db->from('waitinglist_details');
                $this->db->where('is_decline',1);
                $this->db->where('restaurant_id',$_SESSION['user_id']);
                $this->db->order_by("id DESC");
                if($searchkey!="")
                $this->db->like('lower(name)',strtolower($searchkey));
                $this->db->where('is_decline',1);
                $this->db->where('restaurant_id',$_SESSION['user_id']);
                $this->db->order_by("id DESC");
                $query = $this->db->get();

                $result = $query->result_array();
 
                return  array(
                    'manager'=>$result,
                    'total_count'=>$decline_count['cnt'],
                    'total_pages'=>1,
                    'page_no'=>1,
                    'page_total_text'=>"1 - ".$decline_count['cnt']
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
                $this->db->from('waitinglist_details');
                $this->db->where('is_decline',1);
                $this->db->where('restaurant_id',$_SESSION['user_id']);
                $this->db->order_by("id DESC");
                $this->db->limit($records_per_page,$offset);
                $query = $this->db->get();
               /*  echo $this->db->last_query();
                die;*/
                $result = $query->result_array();
                $total_pages = ceil($decline_count['cnt'] / $records_per_page);

                if($decline_count['cnt']<$records_per_page)
                    $to_page=$decline_count['cnt'];
                else
                    $to_page=$records_per_page;
                return  array(
                    'manager'=>$result,
                    'total_count'=>$decline_count['cnt'],
                    'total_pages'=>$total_pages,
                    'page_no'=>$page_no,
                    'page_total_text'=>($offset+1)." - ".$to_page
                ); 
            }
        }

    }


    public function all_declineassign_list($page_no,$records_per_page,$searchkey=""){
        $decline_count=$this->db->select('count(*) as cnt')->from('waitinglist_details')->where('restaurant_id',$_SESSION['user_id'])->get()->row_array();
      
        if($decline_count['cnt']<=0){
            $this->db->select('*');
            $this->db->from('waitinglist_details');
            $this->db->where('restaurant_id',$_SESSION['user_id']);
            $this->db->order_by("id DESC");
            $query = $this->db->get();
            $result = $query->result_array();

            return  array(
                'manager'=>$result,
                'total_count'=>$decline_count['cnt'],
                'total_pages'=>1,
                'page_no'=>1,
                'page_total_text'=>"0 - ".$decline_count['cnt']
            ); 
        }else{
            if($records_per_page=="all"){
                $this->db->select('*');
                $this->db->from('waitinglist_details');
                $this->db->where('restaurant_id',$_SESSION['user_id']);
                $this->db->order_by("id DESC");
                if($searchkey!="")
                $this->db->like('lower(name)',strtolower($searchkey));
                $this->db->where('restaurant_id',$_SESSION['user_id']);
                $this->db->order_by("id DESC");
                $query = $this->db->get();

                $result = $query->result_array();
 
                return  array(
                    'manager'=>$result,
                    'total_count'=>$decline_count['cnt'],
                    'total_pages'=>1,
                    'page_no'=>1,
                    'page_total_text'=>"1 - ".$decline_count['cnt']
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
                $this->db->from('waitinglist_details');
                $this->db->where('restaurant_id',$_SESSION['user_id']);
                $this->db->order_by("id DESC");
                $this->db->limit($records_per_page,$offset);
                $query = $this->db->get();
               /*  echo $this->db->last_query();
                die;*/
                $result = $query->result_array();
                $total_pages = ceil($decline_count['cnt'] / $records_per_page);

                if($decline_count['cnt']<$records_per_page)
                    $to_page=$decline_count['cnt'];
                else
                    $to_page=$records_per_page;
                return  array(
                    'manager'=>$result,
                    'total_count'=>$decline_count['cnt'],
                    'total_pages'=>$total_pages,
                    'page_no'=>$page_no,
                    'page_total_text'=>($offset+1)." - ".$to_page
                ); 
            }
        }

    }

    public function list_restaurants($page_no,$records_per_page,$restaurant_status,$searchkey=""){
        $restaurant_count=$this->db->select('count(*) as cnt')->from('user')->where('usertype','Restaurant')->get()->row_array();
      
        if($restaurant_count['cnt']<=0){
             $this->db->select('*');
            $this->db->from('user');
            $this->db->where('usertype','Restaurant');
            if($restaurant_status!="")
                $this->db->where('is_active',$restaurant_status);
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
                $this->db->where('usertype','Restaurant');
                if($restaurant_status!="")
                $this->db->where('is_active',$restaurant_status);
                $this->db->order_by("id DESC");
                if($searchkey!="")
                $this->db->like('lower(business_name)',strtolower($searchkey));
                $this->db->where('usertype','Restaurant');
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
                $this->db->where('usertype','Restaurant');
                if($restaurant_status!="")
                $this->db->where('is_active',$restaurant_status);
                $this->db->order_by("id DESC");
                $this->db->limit($records_per_page,$offset);
                $query = $this->db->get();
               /*  echo $this->db->last_query();
                die;*/
                $result = $query->result_array();
                $total_pages = ceil($restaurant_count['cnt'] / $records_per_page);

                if($restaurant_count['cnt']<$records_per_page*$page_no)
                    $to_page=$restaurant_count['cnt'];
                else
                    $to_page=$records_per_page*$page_no;
					
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