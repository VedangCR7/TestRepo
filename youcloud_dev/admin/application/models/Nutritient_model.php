<?php
class Nutritient_model extends My_Model {
    var $name;
    var $value;
    var $unit;
    var $warning;
    var $tablename="nutritient";
    var $fields=array('name','value','unit','warning');
    public function __construct()
    {
    	$this->load->database();
    }
}
?>