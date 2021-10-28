<?php
class Recipe_nutritient_model extends My_Model {
	var $name;
	var $value;
	var $unit;
	var $warning;
	var $recipe_id;
    var $tablename="recipe_nutritient";
    var $fields=array('name','value','unit','warning','recipe_id');
    public function __construct()
    {
    	$this->load->database();
    }

    public function list_nutrients($recipe_id){

        $this->db->select("rn.*");
        $this->db->from('recipe_nutritient rn');
        $this->db->where('rn.recipe_id',$recipe_id);
        $query = $this->db->get();
        $result = $query->result_array();
        $nutrition=array();
        foreach ($result as $row) {
           $nutrition[$row['name']]=$row;
        }
        return  $nutrition; 
    }
}
?>