<?php
class Admin_offer_model extends My_Model {
    var $message_photo;
    var $is_active;
    var $restaurant_id;
    var $message_text;
    var $message_date;
    var $tablename="whatsapp_message";
    var $fields=array('message_photo','is_active','restaurant_id','message_text','message_date');
}
?>