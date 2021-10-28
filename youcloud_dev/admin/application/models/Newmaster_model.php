<?php
class Newmaster_model extends My_Model {
    var $name;
    var $declaration_name;
    var $img_id;
    var $recipe_image;
    var $long_desc;
    var $image_path;
    var $thumb_path;
    var $is_delete;
    var $tablename="tbl_recipes_master";
    var $fields=array('name','img_id','recipe_image','long_desc','declaration_name','thumb_path','image_path','is_delete');
    public function __construct()
    {
    	$this->load->database();
        $this->load->model('ingredient_items_model');

    }

    public function select_where($table,$condition){
        return $this->db->where($condition)->get($table)->result_array();
    }

    public function list_all(){
        $this->db->select("*, title as name");
        $this->db->from('menu_group');
        $this->db->where('is_active',1);
        $this->db->where('logged_user_id',$_SESSION['user_id']);
        $query = $this->db->get();
        $row = $query->result_array();
        return  $row;       
    }

     public function list_groups($main_menu_id=""){
        $this->db->select("*, title as name");
        $this->db->from('menu_group');
        $this->db->where('logged_user_id',$_SESSION['user_id']);
        if($main_menu_id!="")
            $this->db->where('main_menu_id',$main_menu_id);
        $query = $this->db->get();
        $row = $query->result_array();
        return  $row;       
    }

    public function check_group_name($group_name){
        $this->db->select("*");
        $this->db->from('tbl_recipes_master');
        $this->db->where('UCASE(name)=',ucfirst(strtolower($group_name)));
        if($group_id!="")
            $this->db->where('id!=',$group_id);
        $query = $this->db->get();
        $row = $query->row_array();
        return  $row;       
    }
	
	public function update_recipesthumb($main_menu_id,$group_id){
        $this->db->where('group_id',$group_id);
        $this->db->where('logged_user_id',$_SESSION['user_id']);
        $this->db->update('recipes', array('main_menu_id' => $main_menu_id));
        return  $row;       
    }

    public function list_all_groups(){
        $this->db->select("*, title as name,DATE_FORMAT(datetime,'%d %M %Y') as menu_date");
        $this->db->from('menu_group');
        $this->db->where('logged_user_id',$_SESSION['user_id']);
        $this->db->where('is_active',1);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }


    
    public function get_user_menugroups($user_id,$main_menu_id){
        $this->db->select("m.*,COUNT(r.id) AS recipe_count");
        $this->db->from('menu_group m');
        $this->db->join('recipes r','r.group_id=m.id AND r.is_delete=0 AND r.is_active=1 AND r.is_recipe_active=1','left');
        $this->db->where('m.logged_user_id',$user_id);
        $this->db->where('m.main_menu_id',$main_menu_id);
        $this->db->where('m.is_active',1);
        $this->db->order_by('m.sequence','asc');
        $this->db->group_by('m.id');
        $this->db->having('recipe_count>0');  
        $query = $this->db->get();
/*echo $this->db->last_query();
die;*/
        $groups=$query->result_array();
        /*$data=array();
       foreach ($groups as $group) {
           
        }*/
      
        return $groups;
    }

    public function loadgroup_recipes_formob($user_id,$group_id,$tablecat_id=""){
        if($tablecat_id!=""){
            $this->db->select("r.*,ifnull(im.img_path,r.recipe_image) as recipe_image,CASE WHEN r.quantity1=".$tablecat_id." THEN r.price1
                 WHEN r.quantity2=".$tablecat_id." THEN r.price2
                 WHEN r.quantity3=".$tablecat_id." THEN r.price3
                else price END as price",FALSE);
            $this->db->from('recipes r');
            $this->db->join('recipe_images_master im','im.id=r.recipe_image_id','left');
            $this->db->where('r.is_delete',0);
            $this->db->where('r.is_active',1);
            $this->db->where('r.is_recipe_active',1);
            $this->db->where('r.logged_user_id',$user_id);
            $this->db->where('r.group_id',$group_id);
            $query = $this->db->get();
            $result = $query->result_array();
        }else{
            $this->db->select('r.*,ifnull(im.img_path,r.recipe_image) as recipe_image');
            $this->db->from('recipes r');
            $this->db->join('recipe_images_master im','im.id=r.recipe_image_id','left');
            $this->db->where('r.is_delete',0);
            $this->db->where('r.is_active',1);
            $this->db->where('r.is_recipe_active',1);
            $this->db->where('r.logged_user_id',$user_id);
            $this->db->where('r.group_id',$group_id);
            $query = $this->db->get();
            $result = $query->result_array();
        }
        return $result;
    }

    public function search_recipes_formob($user_id,$main_menu_id,$searchkey="",$tablecat_id=""){
         if($tablecat_id!=""){
            $this->db->select("r.*,ifnull(im.img_path,r.recipe_image) as recipe_image,
                CASE WHEN r.quantity1=".$tablecat_id." THEN r.price1
                 WHEN r.quantity2=".$tablecat_id." THEN r.price2
                 WHEN r.quantity3=".$tablecat_id." THEN r.price3
                else price END as price",FALSE);
            $this->db->from('recipes r');
            $this->db->join('menu_group m','m.id=r.group_id');
            $this->db->join('recipe_images_master im','im.id=r.recipe_image_id','left');
            $this->db->where('r.main_menu_id',$main_menu_id);
            $this->db->where('r.is_delete',0);
            $this->db->where('r.is_active',1);
            $this->db->where('r.is_recipe_active',1);
            $this->db->where('m.is_active',1);
            $this->db->where('r.logged_user_id',$user_id);
            if($searchkey!="")
                $this->db->like('lower(r.name)',strtolower($searchkey));
            $query = $this->db->get();
            $result = $query->result_array();
        }else{
            $this->db->select('r.*,ifnull(im.img_path,r.recipe_image) as recipe_image');
            $this->db->from('recipes r');
            $this->db->join('recipe_images_master im','im.id=r.recipe_image_id','left');
            $this->db->join('menu_group m','m.id=r.group_id');
            $this->db->where('r.main_menu_id',$main_menu_id);
            $this->db->where('r.is_delete',0);
            $this->db->where('r.is_active',1);
            $this->db->where('r.is_recipe_active',1);
            $this->db->where('m.is_active',1);
            $this->db->where('r.logged_user_id',$user_id);
            if($searchkey!="")
                $this->db->like('lower(r.name)',strtolower($searchkey));
            $query = $this->db->get();
            $result = $query->result_array();
        }
        return $result;
    }

    public function get_ingredients($recipe_id){
        $this->db->select('GROUP_CONCAT(CASE WHEN `i`.`declaration_name`="" THEN  `i`.`long_desc` ELSE `i`.`declaration_name` END) as ingredients');
        $this->db->from('ingredient_items im');
        $this->db->join('ingredient i','i.alacalc_id=im.ingredient_id');
        $this->db->where('im.recipe_id',$recipe_id);
        $query = $this->db->get();
        $result = $query->row_array();
        return $result['ingredients'];

    }
    public function list_menu_group($page_no,$records_per_page,$searchkey=""){
        if($records_per_page=="all"){
             $this->db->select("m.*, m.title as name,DATE_FORMAT(m.datetime,'%d %M %Y') as menu_date,m1.name as main_group,(SELECT count(id) FROM recipes WHERE m.id=recipes.group_id) as recipe_count");
            $this->db->from('menu_group m');
            $this->db->join('menu_master m1','m1.id=m.main_menu_id','left');
            $this->db->where('m.logged_user_id',$_SESSION['user_id']);
            if($searchkey!="")
                $this->db->like('lower(m.title)',strtolower($searchkey));
            $this->db->order_by('m.sequence asc,m.datetime desc');
            $query = $this->db->get();
            $result = $query->result_array();

            $group_count=$this->db->select('count(*) as cnt')->from('menu_group')->where('logged_user_id',$_SESSION['user_id'])->get()->row_array();

            return  array(
                'groups'=>$result,
                'total_count'=>$group_count['cnt'],
                'total_pages'=>1,
                'page_no'=>1,
                'page_total_text'=>"1 - ".$group_count['cnt']
            ); 
        }else{

            if (!isset($page_no)) {
                $page_no = 1;
            }

            if (!isset($records_per_page)) {
                $records_per_page = 30;
            }

            $offset = ($page_no-1) * $records_per_page;
            
            $this->db->select("m.*, m.title as name,DATE_FORMAT(m.datetime,'%d %M %Y') as menu_date,m1.name as main_group,(SELECT count(id) FROM recipes WHERE m.id=recipes.group_id) as recipe_count");
            $this->db->from('menu_group m');
            $this->db->join('menu_master m1','m1.id=m.main_menu_id','left');
            $this->db->where('m.logged_user_id',$_SESSION['user_id']);
            $this->db->order_by('m.sequence asc,m.datetime desc');
            $this->db->limit($records_per_page,$offset);
            $query = $this->db->get();
            /*echo $this->db->last_query();
            die;*/
            $result = $query->result_array();
          /*  echo "<pre>";
            print_r($result);
            die;*/
            $group_count=$this->db->select('count(*) as cnt')->from('menu_group')->where('logged_user_id',$_SESSION['user_id'])->get()->row_array();
            $total_pages = ceil($group_count['cnt'] / $records_per_page);

            if($group_count['cnt']<$records_per_page)
                $to_page=$group_count['cnt'];
            else
                $to_page=$records_per_page;
            return  array(
                'groups'=>$result,
                'total_count'=>$group_count['cnt'],
                'total_pages'=>$total_pages,
                'page_no'=>$page_no,
                'page_total_text'=>($offset+1)." - ".$to_page
            ); 
        }
    }


    public function update_allgroup_sequence(){

        $this->db->select("logged_user_id");
        $this->db->from('menu_group');
        $this->db->order_by('id','desc');
        $this->db->group_by('logged_user_id');
        $query = $this->db->get();
        $users = $query->result_array();
        foreach ($users as $user) {
            $this->db->select("*, title as name");
            $this->db->from('menu_group');
            $this->db->where('logged_user_id',$user['logged_user_id']);
            $this->db->order_by('id','desc');
            $query = $this->db->get();
            $groups = $query->result_array();
            
            $seq=1;
            foreach ($groups as $group) {
                $this->db->where('id',$group['id']);
                $this->db->update('menu_group',array('sequence'=>$seq));
                $seq++;
            }

        }

       
    }

    public function get_grouprecipes_count($group_id){
        $this->db->select("count(id) as cnt");
        $this->db->from('recipes');
        $this->db->where('group_id',$group_id);
        $query = $this->db->get();
        $row = $query->row_array();
        if($query->num_rows()==0)
            return 0;
        else
            return $row['cnt'];
    }

    public function delete_group_recipes($group_id){

        $this->db->where('group_id',$group_id);
        $this->db->delete('recipes');
    }
}
?>