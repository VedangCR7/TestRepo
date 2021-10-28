<?php
class Allergens_model extends My_Model {
    var $title;
    var $image_url;
    var $tablename="allergens";
    var $fields=array('title','image_url');
    public function __construct()
    {
    	$this->load->database();
    }
}
?>