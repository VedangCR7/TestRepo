<?php
class Inventory_product_assign_items_model extends My_Model {
    var $assign_id;
    var $product_id;
    var $purchase_quantity;
    var $assign_quantity;
    var $remaining_quantity;
    var $supplier_id;
    var $restaurant_id;
    var $tablename="inventory_product_assign_kitchen_items";
    var $fields=array('assign_id','product_id','purchase_quantity','assign_quantity','remaining_quantity','supplier_id','restaurant_id');
}
?>