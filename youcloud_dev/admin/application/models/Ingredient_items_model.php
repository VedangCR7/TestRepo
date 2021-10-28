<?php
class Ingredient_items_model extends My_Model {
	var $ingredient_id;
	var $recipe_id;
	var $quantity;
	var $quantity_unit_id;
    var $quantity_unit;
    var $alacalc_item_id;
    var $long_desc;
    var $declaration_name;
    var $shrt_desc;
    var $data_source;
    var $tablename="ingredient_items";
    var $fields=array('ingredient_id','recipe_id','quantity','quantity_unit_id','alacalc_item_id','long_desc','declaration_name','data_source','shrt_desc','quantity_unit');
    public function __construct()
    {
        $this->load->model('ingredient_weights_model');
    	$this->load->database();
    }

    public function list_items($recipe_id){
        $this->db->select("im.*,i.long_desc,i.declaration_name,i.data_source");
        $this->db->from('ingredient_items im');
        $this->db->join('ingredient i','i.alacalc_id=im.ingredient_id');
        $this->db->where('im.recipe_id',$recipe_id);
        $query = $this->db->get();
        $result = $query->result_array();
        $data=array();
        foreach ($result as $row) {
            $row['quantity_unit']=json_decode($row['quantity_unit']);
            $row['weights']=$this->ingredient_weights_model->list_weights($row['ingredient_id']);
            $data[]=$row;
        }
        return  $data; 
    }

    public function get_ingredients($recipe_id){
        $this->db->select("im.*,i.long_desc,i.declaration_name,i.data_source");
        $this->db->from('ingredient_items im');
        $this->db->join('ingredient i','i.alacalc_id=im.ingredient_id');
        $this->db->where('im.recipe_id',$recipe_id);
        $query = $this->db->get();
        $result = $query->result_array();
        return  $result; 
    }
   
    public function update_recipe_ingredient($recipe_id){
         $ingredients=$this->menu_group_model->get_ingredients($recipe_id);

         $this->db->where('id',$recipe_id);
         $this->db->update('recipes',array('ingredients_name'=>ucwords($ingredients)));
    }
}
?>