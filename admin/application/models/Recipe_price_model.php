<?php
class Recipe_price_model extends My_Model {
    var $recipe_id;
    var $price;
    var $is_default;
    var $table_category_id;
    var $tablename="recipe_prices";
    var $fields=array('recipe_id','price','is_default','table_category_id');
    public function __construct()
    {
    	$this->load->database();
    }

    public function list_recipe_prices($recipe_id){
        $this->db->select("*");
        $this->db->from('recipe_prices');
        $this->db->where('recipe_id',$recipe_id);
        $this->db->order_by('id','asc');
        $query = $this->db->get();
        $row = $query->result_array();
        return  $row;       
    }


}
?>