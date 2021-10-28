<?php
class Todays_special_model extends My_Model {
    var $title;
    var $is_active;
    var $logged_user_id;
    var $tablename="menu_group";
    var $fields=array('title','is_active','logged_user_id');
    public function __construct()
    {
    	$this->load->database();
    }

    public function list_all(){
        $this->db->select("*, title as name");
        $this->db->from('menu_group');
        $this->db->where('is_active',1);
        $this->db->where('logged_user_id',$_SESSION['user_id']);
        $query = $this->db->get();
        $row = $query->result_array();
        return  $row;       
    }

    public function check_group_name($group_name,$user_id,$group_id=""){
        $this->db->select("*");
        $this->db->from('menu_group');
        $this->db->where('CONCAT(UCASE(LEFT(title, 1)),SUBSTRING(title, 2))=',ucfirst(strtolower($group_name)));
        $this->db->where('logged_user_id',$user_id);
        if($group_id!="")
            $this->db->where('id!=',$group_id);
        $query = $this->db->get();
        $row = $query->row_array();
        return  $row;       
    }

    public function list_all_groups(){
        $this->db->select("*, title as name,DATE_FORMAT(datetime,'%d %M %Y') as menu_date");
        $this->db->from('menu_group');
        $this->db->where('logged_user_id',$_SESSION['user_id']);
        $this->db->where('is_active',1);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
    
    public function list_menu_group($page_no,$records_per_page){
        if($records_per_page=="all"){
            $this->db->select("*, title as name,DATE_FORMAT(datetime,'%d %M %Y') as menu_date");
            $this->db->from('menu_group');
            $this->db->where('logged_user_id',$_SESSION['user_id']);
            $this->db->order_by('id','desc');
            $query = $this->db->get();
            $result = $query->result_array();

            $group_count=$this->db->select('count(*) as cnt')->from('menu_group')->where('logged_user_id',$_SESSION['user_id'])->get()->row_array();

            return  array(
                'groups'=>$result,
                'total_count'=>$group_count['cnt'],
                'total_pages'=>1,
                'page_no'=>1,
                'page_total_text'=>"1 - ".$group_count['cnt']
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
            $this->db->select("*, title as name,DATE_FORMAT(datetime,'%d %M %Y') as menu_date");
            $this->db->from('menu_group');
            $this->db->where('logged_user_id',$_SESSION['user_id']);
            $this->db->order_by('id','desc');
            $this->db->limit($records_per_page,$offset);
            $query = $this->db->get();
            $result = $query->result_array();

            $group_count=$this->db->select('count(*) as cnt')->from('menu_group')->where('logged_user_id',$_SESSION['user_id'])->get()->row_array();
            $total_pages = ceil($group_count['cnt'] / $records_per_page);

            if($group_count['cnt']<$records_per_page)
                $to_page=$group_count['cnt'];
            else
                $to_page=$records_per_page;
            return  array(
                'groups'=>$result,
                'total_count'=>$group_count['cnt'],
                'total_pages'=>$total_pages,
                'page_no'=>$page_no,
                'page_total_text'=>($offset+1)." - ".$to_page
            ); 
        }
    }
}
?>