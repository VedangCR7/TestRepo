<?php
class Ingredient_allergens_model extends My_Model {
	var $ingredient_id;
	var $allergens_id;
    var $tablename="ingredient_allergens";
    var $fields=array('ingredient_id','allergens_id');
    public function __construct()
    {
    	$this->load->database();
    }
}
?>