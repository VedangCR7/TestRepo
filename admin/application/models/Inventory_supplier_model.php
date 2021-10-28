<?php
class Inventory_supplier_model extends My_Model {
    var $company_name;
    var $company_address;
    var $email;
    var $gst_no;
    var $contact_person_name;
    var $mobile;
    var $owner_name;
    var $company_logo;
    var $restaurant_id;
    var $tablename="inventory_suppliers";
    var $fields=array('company_name','company_address','email','gst_no','contact_person_name','mobile','owner_name','company_logo','restaurant_id');

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


    
}


    ?>