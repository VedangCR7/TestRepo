<?php
class Inventory_purchase_model extends My_Model {
    var $purchase_order_no;
    var $supplier_id;
    var $grand_total;
    var $date;
    var $restaurant_id;
    var $tablename="inventory_purchase";
    var $fields=array('purchase_order_no','supplier_id','grand_total','date','restaurant_id');
}
?>