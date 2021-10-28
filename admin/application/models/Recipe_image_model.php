<?php
class Recipe_image_model extends My_Model {
    var $name;
    var $img_path;
    var $thumb_path;
    var $tablename="recipe_images_master";
    var $fields=array('name','img_path','thumb_path');
    public function __construct()
    {
    	$this->load->database();
    }
}
?>