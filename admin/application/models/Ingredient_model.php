<?php
class Ingredient_model extends My_Model {
	var $long_desc;
	var $declaration_name;
	var $created_at;
	var $data_source;
	var $alacalc_id;
    var $tablename="ingredient";
    var $fields=array('long_desc','declaration_name','created_at','data_source','alacalc_id');
    public function __construct()
    {
    	$this->load->database();
    }
}
?>