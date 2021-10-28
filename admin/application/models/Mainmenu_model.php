<?php
class Mainmenu_model extends My_Model {
    var $id;
    var $name;
    var $is_active;
    var $restaurant_id;
    var $tablename="menu_master";
    var $fields=array('id','name','is_active','restaurant_id');

    public function listmain_menu(){
        $this->db->select('*');
        $this->db->from('menu_master');
        $this->db->where('is_active',1);
        $this->db->where('restaurant_id',$_SESSION['user_id']);
        $this->db->order_by("id ASC");
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function list_master_menu($page_no,$records_per_page,$searchkey=""){
        $master_menu_count=$this->db->select('count(*) as cnt')->from('menu_master')->where('restaurant_id',$_SESSION['user_id'])->get()->row_array();
      
        if($master_menu_count['cnt']<=0){
            $this->db->select('*');
            $this->db->from('menu_master');
            $this->db->where('restaurant_id',$_SESSION['user_id']);
            $this->db->order_by("id DESC");
            $query = $this->db->get();
            $result = $query->result_array();

            return  array(
                'manager'=>$result,
                'total_count'=>$master_menu_count['cnt'],
                'total_pages'=>1,
                'page_no'=>1,
                'page_total_text'=>"0 - ".$master_menu_count['cnt']
            ); 
        }else{
            if($records_per_page=="all"){
                $this->db->select('*');
                $this->db->from('menu_master');
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
                    'total_count'=>$master_menu_count['cnt'],
                    'total_pages'=>1,
                    'page_no'=>1,
                    'page_total_text'=>"1 - ".$master_menu_count['cnt']
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
                $this->db->from('menu_master');
                $this->db->where('restaurant_id',$_SESSION['user_id']);
                $this->db->order_by("id DESC");
                $this->db->limit($records_per_page,$offset);
                $query = $this->db->get();
               /*  echo $this->db->last_query();
                die;*/
                $result = $query->result_array();
                $total_pages = ceil($master_menu_count['cnt'] / $records_per_page);

                if($master_menu_count['cnt']<$records_per_page)
                    $to_page=$master_menu_count['cnt'];
                else
                    $to_page=$records_per_page;
                return  array(
                    'manager'=>$result,
                    'total_count'=>$master_menu_count['cnt'],
                    'total_pages'=>$total_pages,
                    'page_no'=>$page_no,
                    'page_total_text'=>($offset+1)." - ".$to_page
                ); 
            }
        }
    }

    public function insert_any_query($table,$data){
        return $this->db->insert($table,$data);
    }

    public function updateactive_inactive($table,$condition,$data){
        return $this->db->where($condition)->update($table, $data);
    }

    public function select_where($table,$condition){
        return $this->db->where($condition)->get($table)->result_array();
    }
	
	public function importdata($data) 
	{ 
        $res = $this->db->insert_batch('menu_master',$data);
        
		if($res)
		{
            return TRUE;
        }
		else
		{
            return FALSE;
        } 
    }
}
?>