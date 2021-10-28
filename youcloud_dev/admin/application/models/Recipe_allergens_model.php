<?php
class Recipe_allergens_model extends My_Model {
	var $allergens_id;
    var $recipe_id;
    var $tablename="recipe_allergens";
    var $fields=array('allergens_id','recipe_id');
    public function __construct()
    {
    	$this->load->database();
    }

    public function list_allergens($recipe_id){
        $this->db->select("im.*,a.title,a.image_url");
        $this->db->from('recipe_allergens im');
        $this->db->join('allergens a','a.id=im.allergens_id');
        $this->db->where('im.recipe_id',$recipe_id);
        $query = $this->db->get();
        $result = $query->result_array();
        return  $result; 
    }
}
?>