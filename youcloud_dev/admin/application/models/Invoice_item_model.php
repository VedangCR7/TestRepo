<?php
class Invoice_item_model extends My_Model {
    var $invoice_id;
    var $recipe_id;
    var $qty;
    var $price;
    var $sub_total;
    var $disc;
    var $disc_amt;
    var $total;
    var $tablename="invoice_items";
    var $fields=array('invoice_id','recipe_id','qty','price','total','disc','disc_amt','sub_total');
    public function __construct()
    {
    	$this->load->database();
    }

    public function list_invoice_items($invoice_id){
        $this->db->select("oi.*,r.name as recipe_name");
        $this->db->from('invoice_items as oi');
        $this->db->join('recipes r','r.id=oi.recipe_id');
        $this->db->where('oi.invoice_id',$invoice_id);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function list_recipe_items($order_id){
        $this->db->select("oi.*,r.name as recipe_name");
        $this->db->from('order_items as oi');
        $this->db->join('recipes r','r.id=oi.recipe_id');
        $this->db->where('oi.order_id',$order_id);
        $query1 = $this->db->get();
        $result1 = $query1->result_array();

        $result = array();
        foreach($result1 as $key => $value){
            $this->db->select("amo.option_name");
            $this->db->from('order_addon_menu as oam');
            $this->db->join('addon_menu_option amo','amo.id=oam.option_id');
            $this->db->where('oam.order_item_id',$value['id']);
            $query = $this->db->get();
            $addon_result = $query->result_array();
            $result[]= array('id' => $value['id'], 'order_id' => $value['order_id'], 'recipe_id' => $value['recipe_id'], 'qty' => $value['qty'],'price' => $value['price'],'total' => $value['total'], 'disc' => $value['disc'], 'disc_amt' => $value['disc_amt'], 'sub_total' =>$value['sub_total'], 'special_notes' => $value['special_notes'], 'created_at' => $value['created_at'], 'updated_at' => $value['updated_at'],'recipe_name' => $value['recipe_name'],'addon_data'=>$addon_result);
        }

        return $result;
    }
   
}
?>