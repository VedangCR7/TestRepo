<?php
class Quantity_unit_model extends My_Model {
	var $description;
	var $amount;
	var $gm_wgt;
    var $tablename="quantity_unit";
    var $fields=array('description','amount','gm_wgt');
    public function __construct()
    {
    	$this->load->database();
    }
}
?>