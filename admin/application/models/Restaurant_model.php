<?php
class Restaurant_model extends My_Model {
    
    var $tablename="user";
    var $fields=array('name','email');
    public function __construct()
    {
    	$this->load->database();
    }
public function getAllMenuItems($groupid,$restId){
    $this->db->select("*");
    $this->db->from('recipes');
    $this->db->where("group_id",$groupid);
    $this->db->where("logged_user_id",$restId);
    $query = $this->db->get();
    return $query->num_rows();
    
}
public function getMenuItemsByPage($groupid,$restId,$limitStart,$limitEnd){
    $query="SELECT * FROM `recipes` WHERE `group_id` = $groupid AND `logged_user_id`='$restId' limit ".$limitStart." , ".$limitEnd;
    $queryResult= $this->db->query($query);
    return $queryResult->result_array();
    
   }
    public function getRestaurantDetail($name){
        
        $this->db->select("*");
        $this->db->from('user');
        $this->db->where("name like '".$name."'");
        $query = $this->db->get();
       
        $result = $query->result_array();
 
        return  $result;       
    }
    public function getRestaurantMenuGroups($id){
        $this->db->select("*");
        $this->db->from('menu_group');
        $this->db->where('logged_user_id',$id);
        $this->db->where('is_active',1);
        $query = $this->db->get();
        
        $result = $query->result_array();
        return  $result;    
           
    }
    public function getRestaurantMenuIngredients($reciepeId){
        $query="select im.*,i.long_desc,i.declaration_name,i.data_source from ingredient_items im inner JOIN ingredient i on i.alacalc_id=im.ingredient_id WHERE im.recipe_id='$reciepeId'";
        $r= $this->db->query($query);
        return $r->result_array();
          
           
    }

}
?>