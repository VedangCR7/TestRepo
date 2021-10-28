<?php
class Inventory_product_model extends My_Model {
    // var $profile_photo;
    // var $name;
    // var $email;
    // var $contact_number;
    // var $password;
    // var $is_active;
    // var $usertype;
    // var $upline_id;
    // var $tablename="user";
    // var $fields=array('profile_photo','name','email','contact_number','password','is_active','usertype','upline_id');

    public function importData($data) {
 
        $res = $this->db->insert_batch('inventory_product',$data);
        if($res){
            return TRUE;
        }else{
            return FALSE;
        }
 
    }

    public function list_product_typahead(){
        $this->db->select("id,product_name as name");
        $this->db->from('inventory_product');
        $this->db->where('restaurant_id',$_SESSION['user_id']);
        $query = $this->db->get();
        $row = $query->result_array();
        return  $row; 
    }

    public function insert_any_query($table,$data){
        return $this->db->insert($table,$data);
    }

    public function updateactive_inactive($table,$condition,$data)
    {
        return $this->db->where($condition)->update($table, $data);
    }

    public function permanent_delete($table,$condition){
        return $this->db->delete($table,$condition);
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

    public function get_cart_menu_details()
	{
        /*$this->cart->destroy();*/
        $carts=$this->cart->contents();
       /* $data=array();
        foreach ($carts as $cart) {
            $menu_id=$cart['menu_id'];
            $this->db->select("r.*");
            $this->db->from('recipes r');
            $this->db->where('r.id',$menu_id);
            $query = $this->db->get();
            $row = $query->row_array();
            $data[]=$cart;
        }*/
        return $carts;
        
    }

    public function get_cart_assign_kitchen_details(){
        /*$this->cart->destroy();*/
        $carts=$this->cart->contents();
       /* $data=array();
        foreach ($carts as $cart) {
            $menu_id=$cart['menu_id'];
            $this->db->select("r.*");
            $this->db->from('recipes r');
            $this->db->where('r.id',$menu_id);
            $query = $this->db->get();
            $row = $query->row_array();
            $data[]=$cart;
        }*/
        return $carts;
    }


    
}


    ?>