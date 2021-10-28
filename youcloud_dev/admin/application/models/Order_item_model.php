<?php
class Order_item_model extends My_Model {
    var $order_id;
    var $recipe_id;
    var $qty;
    var $price;
    var $total;
    var $disc;
    var $disc_amt;
    var $sub_total;
    var $special_notes;
    var $tablename="order_items";
    var $fields=array('order_id','recipe_id','qty','price','total','disc','disc_amt','sub_total','special_notes');
    public function __construct()
    {
    	$this->load->database();
    }

    public function list_order_items($order_id){
        $this->db->select("oi.*,r.name as recipe_name,r.recipe_type,r.product_code");
        $this->db->from('order_items as oi');
        $this->db->join('recipes r','r.id=oi.recipe_id');
        $this->db->where('oi.order_id',$order_id);
        $query1 = $this->db->get();
        $result1 = $query1->result_array();

        $result = array();
        foreach($result1 as $key => $value){
            $this->db->select("amo.option_name,amo.price as option_price,amo.id");
            $this->db->from('order_addon_menu as oam');
            $this->db->join('addon_menu_option amo','amo.id=oam.option_id');
            $this->db->where('oam.order_item_id',$value['id']);
            $query = $this->db->get();
            $addon_result = $query->result_array();
            $result[]= array('id' => $value['id'], 'order_id' => $value['order_id'], 'recipe_id' => $value['recipe_id'], 'qty' => $value['qty'],'price' => $value['price'],'total' => $value['total'], 'disc' => $value['disc'], 'disc_amt' => $value['disc_amt'], 'sub_total' =>$value['sub_total'], 'special_notes' => $value['special_notes'], 'created_at' => $value['created_at'], 'updated_at' => $value['updated_at'],'recipe_name' => $value['recipe_name'], 'recipe_type' => $value['recipe_type'], 'product_code' => $value['product_code'],'addon_data'=>$addon_result);
        }

        return $result;
    }
   
}
?>