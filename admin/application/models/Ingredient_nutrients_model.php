<?php
class Ingredient_nutrients_model extends My_Model {
	var $ingredient_id;
	var $nutritient_id;
    var $tablename="ingredient_nutrients";
    var $fields=array('ingredient_id','nutritient_id');
    public function __construct()
    {
    	$this->load->database();
    }
}
?>