<?php
class Inventory_purchase_items_model extends My_Model {
    var $purchase_id;
    var $product_id;
    var $qty;
    var $price;
    var $sub_total;
    var $restaurant_id;
    var $tablename="inventory_purchase_item";
    var $fields=array('purchase_id','product_id','qty','price','sub_total','restaurant_id');
}
?>