<?php
class Ingredient_weights_model extends My_Model {
	var $description;
    var $amount;
    var $gm_wgt;
    var $alacalc_id;
    var $ingredient_id;
    var $tablename="ingredient_weights";
    var $fields=array('description','amount','gm_wgt','alacalc_id','ingredient_id');
    public function __construct()
    {
    	$this->load->database();
    }
    
    public function list_weights($ingredient_id){
        $this->db->select("i.*");
        $this->db->from('ingredient_weights i');
        $this->db->where('i.ingredient_id',$ingredient_id);
        $query = $this->db->get();
        $result = $query->result_array();
        
        return  $result; 
    }
}
?>