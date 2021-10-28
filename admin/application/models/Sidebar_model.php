<?php
class Sidebar_model extends My_Model {
    var $menu_name;
    var $restaurant_id;
    var $tablename="restaurant_menu_authority";
    var $fields=array('restaurant_id','menu_name');
    public function __construct()
    {
        $this->load->database();
    }
}