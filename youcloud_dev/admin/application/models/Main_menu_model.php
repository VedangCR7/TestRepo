<?php
class Main_menu_model extends My_Model {
    var $name;
    var $is_active;
    var $restaurant_id;
    var $tablename="menu_master";
    var $fields=array('name','is_active','restaurant_id');
    public function __construct()
    {
    	$this->load->database();
    }

    public function list_all(){
        $this->db->select("*,name");
        $this->db->from('menu_master');
        $this->db->where('is_active',1);
        $this->db->where('restaurant_id',$_SESSION['user_id']);
        $query = $this->db->get();
        $row = $query->result_array();
        return  $row;       
    }

}
?>