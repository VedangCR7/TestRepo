<?php
class Inventory_product_assign_model extends My_Model {
    var $assign_no;
    var $supplier_id;
    var $total_purchase_quantity;
    var $total_assign_quantity;
    var $total_remaining_quantity;
    var $date;
    var $restaurant_id;
    var $tablename="inventory_product_assign_kitchen";
    var $fields=array('assign_no','supplier_id','total_purchase_quantity','total_assign_quantity','total_remaining_quantity','date','restaurant_id');
}
?>