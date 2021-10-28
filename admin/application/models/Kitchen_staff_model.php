<?php
class Kitchen_staff_model extends My_Model {
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

    public function updateactive_inactive($table,$condition,$data)
    {
        return $this->db->where($condition)->update($table, $data);
    }

    public function permanent_delete_manager($table,$condition){
        return $this->db->delete($table,$condition);
    }

    public function query($query)
    {
        return $this->db->query($query)->result_array();
    }

    public function select_where($table,$condition){
        return $this->db->where($condition)->get($table)->result_array();
    }

    public function select_order($table,$column,$order)
    {
        return $this->db->order_by($column,'DESC')->get($table)->result_array();
    }


    public function list_manager($page_no,$records_per_page,$searchkey=""){
        $restaurant_count=$this->db->select('count(*) as cnt')->from('user')->where('usertype','Kitchen staff')->where('upline_id',$_SESSION['user_id'])->get()->row_array();
      
        if($restaurant_count['cnt']<=0){
             $this->db->select('*');
            $this->db->from('user');
            $this->db->where('usertype','Kitchen staff');
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
            	$this->db->where('usertype','Kitchen staff');
                $this->db->where('upline_id',$_SESSION['user_id']);
            	$this->db->order_by("id DESC");
                if($searchkey!="")
                    $this->db->like('lower(name)',strtolower($searchkey));
                $this->db->where('usertype','Kitchen staff');
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
            	$this->db->where('usertype','Kitchen staff');
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

    public function manager_table($page_no,$records_per_page,$searchkey=""){
        $restaurant_table_count=$this->db->select('count(manager_id) as cnt')->from('assign_table_for_manager')->where('restaurant_id',$_SESSION['user_id'])->group_by('manager_id')->get()->row_array();
        //print_r($restaurant_table_count);exit();
        if($restaurant_table_count['cnt']<=0){
            $this->db->select('at.*,u.name,u.id as user_id');
            $this->db->from('assign_table_for_manager as at');
            $this->db->join('user as u', 'u.id = at.manager_id');
            $this->db->where('at.restaurant_id',$_SESSION['user_id']);
            $this->db->group_by('at.manager_id');
            $query = $this->db->get();
            $result = $query->result_array();
            
            return  array(
                'manager'=>$result,
                'total_count'=>$restaurant_table_count['cnt'],
                'total_pages'=>1,
                'page_no'=>1,
                'page_total_text'=>"0 - ".$restaurant_table_count['cnt']
            ); 
        }else{
            if($records_per_page=="all"){
                $this->db->select('at.*,u.name,u.id as user_id');
                $this->db->from('assign_table_for_manager as at');
                $this->db->join('user as u', 'u.id = at.manager_id');
                $this->db->where('at.restaurant_id',$_SESSION['user_id']);
                $this->db->group_by('at.manager_id');
                if($searchkey!="")
                    $this->db->like('lower(u.name)',strtolower($searchkey));
                    $this->db->where('at.restaurant_id',$_SESSION['user_id']);
                $query = $this->db->get();

                $result = $query->result_array();
 
                return  array(
                    'manager'=>$result,
                    'total_count'=>$restaurant_table_count['cnt'],
                    'total_pages'=>1,
                    'page_no'=>1,
                    'page_total_text'=>"1 - ".$restaurant_table_count['cnt']
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
                $this->db->select('at.*,u.name,u.id as user_id');
                $this->db->from('assign_table_for_manager as at');
                $this->db->join('user as u', 'u.id = at.manager_id');
                $this->db->where('at.restaurant_id',$_SESSION['user_id']);
                $this->db->group_by('at.manager_id');
                $query = $this->db->get();
               /*  echo $this->db->last_query();
                die;*/
                $result = $query->result_array();
                
                $total_pages = ceil($restaurant_table_count['cnt'] / $records_per_page);

                if($restaurant_table_count['cnt']<$records_per_page)
                    $to_page=$restaurant_table_count['cnt'];
                else
                    $to_page=$records_per_page;
                return  array(
                    'manager'=>$result,
                    'total_count'=>$restaurant_table_count['cnt'],
                    'total_pages'=>$total_pages,
                    'page_no'=>$page_no,
                    'page_total_text'=>($offset+1)." - ".$to_page
                );
            }
        }

    }
}


    ?>