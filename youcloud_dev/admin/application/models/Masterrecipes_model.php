<?php
class Masterrecipes_model extends My_Model {
    var $name;
    var $img_id;
    var $recipe_image;
	var $long_desc;
	var $declaration_name;
	var $thumb_path;
	var $is_delete;
    var $tablename="tbl_recipes_master";
        
    var $fields=array('name','img_id','recipe_image','long_desc','declaration_name','thumb_path','is_delete');
    public function __construct()
    {
        $this->load->model('ingredient_items_model');
        $this->load->model('recipe_nutritient_model');
        $this->load->model('recipe_allergens_model');
        $this->load->model('allergens_model');
        $this->load->model('aalcalc_model');
        $this->load->model('ingredient_items_model');
        $this->load->model('menu_group_model');
        $this->load->library('image_lib');

    	$this->load->database();
    }

    public function get_recipe($id){
        $this->db->select("r.*");
        $this->db->from('tbl_recipes_master r');
        $this->db->where('r.id',$id);
        $query = $this->db->get();
        $row = $query->row_array();
        return  $row; 
    }

    public function get_recipe_withoutingredients($id,$tablecat_id=""){
        if($tablecat_id!=""){
            $this->db->select("r.*,ifnull(im.img_path,r.recipe_image) as recipe_image,CASE WHEN r.quantity1=".$tablecat_id." THEN r.price1
                 WHEN r.quantity2=".$tablecat_id." THEN r.price2
                 WHEN r.quantity3=".$tablecat_id." THEN r.price3
                else price END as price",FALSE);
            $this->db->from('recipes r');
            $this->db->join('recipe_images_master im','im.id=r.recipe_image_id','left');
            $this->db->where('r.id',$id);
            $query = $this->db->get();
            $row = $query->row_array();
        }else{
            $this->db->select("r.*,ifnull(im.img_path,r.recipe_image) as recipe_image");
            $this->db->from('recipes r');
            $this->db->join('recipe_images_master im','im.id=r.recipe_image_id','left');
            $this->db->where('r.id',$id);
            $query = $this->db->get();
            $row = $query->row_array();
        }
        return  $row; 
    }

    public function get_recipe_with_ingredients($id){
        $this->db->select("r.*,m.title as group_name,ifnull(im.img_path,r.recipe_image) as recipe_image1");
        $this->db->from('recipes r');
        $this->db->join('menu_group m','m.id=r.group_id','left');
        $this->db->join('recipe_images_master im','im.id=r.recipe_image_id','left');
        $this->db->where('r.id',$id);
        $query = $this->db->get();
        $row = $query->row_array();
        $row['ingedient_items']=$this->ingredient_items_model->list_items($id);
        $row['allergens']=$this->recipe_allergens_model->list_allergens($id);
        return  $row; 
    }

    public function get_recipe_linked($id){
        $this->db->select("r.*,m.title as group_name,ifnull(im.img_path,r.recipe_image) as recipe_image");
        $this->db->from('recipes r');
        $this->db->join('menu_group m','m.id=r.group_id','left');
        $this->db->join('recipe_images_master im','im.id=r.recipe_image_id','left');
        $this->db->where('r.id',$id);
        $query = $this->db->get();
        $row = $query->row_array();
        $row['ingedient_items']=$this->ingredient_items_model->list_items($id);
        $row['linked']=array();
        $row['linked']['ingedient_items']=$this->ingredient_items_model->list_items($id);
        $row['linked']['allergens']=$this->recipe_allergens_model->list_allergens($id);
        $row['linked']['nutrition']=$this->recipe_nutritient_model->list_nutrients($id);
        return  $row; 
    }

    public function get_recipe_nutrientsinfo($id){
        $this->db->select("r.*,m.title as group_name,ifnull(im.img_path,r.recipe_image) as recipe_image");
        $this->db->from('recipes r');
        $this->db->join('menu_group m','m.id=r.group_id','left');
        $this->db->join('recipe_images_master im','im.id=r.recipe_image_id','left');
        $this->db->where('r.id',$id);
        $query = $this->db->get();
        $row = $query->row_array();
        $row['linked']=array();
        $row['linked']['allergens']=$this->recipe_allergens_model->list_allergens($id);
        $row['linked']['nutrition']=$this->recipe_nutritient_model->list_nutrients($id);
        return  $row; 
    }



    public function copyrecipe_foradmin($recipe_id){
     
        $id=$this->duplicateMySQLRecord("recipes","id",$recipe_id);


        $r=$this->recipes_model;
        $r->id=$id;
        $recipe_details=$r->get();

        $this->db->select("*");
        $this->db->from('menu_group');
        $this->db->where('id',$recipe_details['group_id']);
        $query = $this->db->get();
        $old_group_data = $query->row_array();
        
        if(!empty($old_group_data)){
            $m=$this->menu_group_model;
            $m->title=$old_group_data['title'];
            $m->logged_user_id=$_SESSION['user_id'];
            $m->main_menu_id=1;
            $group_details=$m->check_group_name($old_group_data['title'],$_SESSION['user_id']);
            if(!empty($group_details)){
                $group_id=$group_details['id'];
            }
            else
                $group_id=$m->add();
        }else{
            $group_id='';
        }

        $m=$this->recipes_model;
        $m->id=$id;
        $m->group_id=$group_id;
        $m->ref_recipe_id=$recipe_id;
        $m->update();

       
        $this->db->select("*");
        $this->db->from('ingredient_items');
        $this->db->where('recipe_id',$recipe_id);
        $query = $this->db->get();
        $ingedient_items = $query->result_array();
        foreach ($ingedient_items as $item) {
            $this->duplicateMySQLRecord("ingredient_items","id",$item['id'],$id);
        }

        $this->db->select("im.*");
        $this->db->from('recipe_allergens im');
        $this->db->where('im.recipe_id',$recipe_id);
        $query = $this->db->get();
        $allergens = $query->result_array();
        foreach ($allergens as $item) {
            $this->duplicateMySQLRecord("recipe_allergens","id",$item['id'],$id);
        }

        $this->db->select("rn.*");
        $this->db->from('recipe_nutritient rn');
        $this->db->where('rn.recipe_id',$recipe_id);
        $query = $this->db->get();
        $nutrition = $query->result_array();
        foreach ($nutrition as $item) {
            $this->duplicateMySQLRecord("recipe_nutritient","id",$item['id'],$id);
        }


        $this->db->where('id',$recipe_id);
        $this->db->update('recipes',array('isadded_for_restaurant'=>1,'is_for_restaurant'=>0));

        /*echo $this->db->last_query();*/
    }
    
    public function duplicateMySQLRecord($table, $primary_key_field, $primary_key_val,$recipe_id="") 
    {
       /* generate the select query */
       $this->db->where($primary_key_field, $primary_key_val); 
       $query = $this->db->get($table);

        foreach ($query->result() as $row){   
           foreach($row as $key=>$val){        
              if($key != $primary_key_field){ 
                  /* $this->db->set can be used instead of passing a data array directly to the insert or update functions */
                  $this->db->set($key, $val);               
              }//endif              
           }//endforeach
        }//endforeach
       
        if($recipe_id!=""){
            $this->db->set("recipe_id", $recipe_id);  
        }

        if($table=="recipes"){
            $this->db->set("is_for_restaurant", 1);  
            $this->db->set("isadded_for_restaurant", 0);  
            $this->db->set("is_active", 1);  
            $this->db->set("logged_user_id", $_SESSION['user_id']);  
        }

        if($table=="menu_group"){
            $this->db->set("logged_user_id", $_SESSION['user_id']);  
        }

        /* insert the new record into table*/
        $res=$this->db->insert($table); 
       /* echo $this->db->last_query();*/
        return  $this->db->insert_id();

    }

    public function update_ref_recipeid($recipe_id,$data){
        $this->db->where('id',$recipe_id);
        $this->db->update('recipes',$data);
        /*echo $this->db->last_query();
        die;*/
    }

    public function copyrecipe_forrestaurant($recipe_id){
     
        $id=$this->duplicateMySQLRecordrest("recipes","id",$recipe_id);

        $r=$this->recipes_model;
        $r->id=$id;
        $recipe_details=$r->get();

        /*$this->db->select("*");
        $this->db->from('menu_group');
        $this->db->where('id',$recipe_details['group_id']);
        $query = $this->db->get();
        $old_group_data = $query->row_array();
        
        if(!empty($old_group_data)){
            $m=$this->menu_group_model;
            $m->title=$old_group_data['title'];
            $m->logged_user_id=$_SESSION['user_id'];
            $group_details=$m->check_group_name($old_group_data['title'],$_SESSION['user_id']);
            if(!empty($group_details)){
                $group_id=$group_details['id'];
            }
            else
                $group_id=$m->add();
        }else{
            $group_id='';
        }*/
        $this->update_ref_recipeid($id,array(
            'group_id'=>null,
            'main_menu_id'=>1,
            'is_bar_menu'=>0,
            'ref_recipe_id'=>$recipe_id
        ));
       /* $m=$this->recipes_model;
        $m->id=$id;
        $m->group_id="";
        $m->main_menu_id=1;
        $m->ref_recipe_id=$recipe_id;
        $m->update();*/

/*
        $result=$this->db->insert($this->tablename,$fields);
        $id = $this->db->insert_id();*/
       
        $this->db->select("*");
        $this->db->from('ingredient_items');
        $this->db->where('recipe_id',$recipe_id);
        $query = $this->db->get();
        $ingedient_items = $query->result_array();
        foreach ($ingedient_items as $item) {
            $this->duplicateMySQLRecordrest("ingredient_items","id",$item['id'],$id);
        }

        $this->db->select("im.*");
        $this->db->from('recipe_allergens im');
        $this->db->where('im.recipe_id',$recipe_id);
        $query = $this->db->get();
        $allergens = $query->result_array();
        foreach ($allergens as $item) {
            $this->duplicateMySQLRecordrest("recipe_allergens","id",$item['id'],$id);
        }

        $this->db->select("rn.*");
        $this->db->from('recipe_nutritient rn');
        $this->db->where('rn.recipe_id',$recipe_id);
        $query = $this->db->get();
        $nutrition = $query->result_array();
        foreach ($nutrition as $item) {
            $this->duplicateMySQLRecordrest("recipe_nutritient","id",$item['id'],$id);
        }

    }

    public function duplicateMySQLRecordrest($table, $primary_key_field, $primary_key_val,$recipe_id="") 
    {
       /* generate the select query */
       $this->db->where($primary_key_field, $primary_key_val); 
       $query = $this->db->get($table);

        foreach ($query->result() as $row){   
           foreach($row as $key=>$val){        
              if($key != $primary_key_field){ 
                  /* $this->db->set can be used instead of passing a data array directly to the insert or update functions */
                  $this->db->set($key, $val);               
              }//endif              
           }//endforeach
        }//endforeach
       
        if($recipe_id!=""){
            $this->db->set("recipe_id", $recipe_id);  
        }

        if($table=="recipes"){
            $this->db->set("is_for_restaurant", 0);  
            $this->db->set("is_menu_fromrestaurant", 1);  
            $this->db->set("is_active", 1);  
            $this->db->set("logged_user_id", $_SESSION['user_id']);  
        }

        if($table=="menu_group"){
            $this->db->set("logged_user_id", $_SESSION['user_id']);  
        }

        /* insert the new record into table*/
        $res=$this->db->insert($table); 
      /*  echo $this->db->last_query();
        die;*/
        return  $this->db->insert_id();

    }

    

    public function restaurant_recipes($page_no,$records_per_page,$searchkey=""){
         //$this->db->where('r.logged_user_id',$user_id);
        $recipes_count=$this->db->select('count(*) as cnt')->from('recipes')->where('is_delete',0)->where('is_active',1)->where('is_for_restaurant',1)->get()->row_array();
        if($records_per_page=="all"){
            $this->db->select("r.*,m.title as group_name,DATE_FORMAT(recipe_date,'%d %M %Y') as recipe_date,ifnull((SELECT r1.id FROM recipes r1 WHERE r1.ref_recipe_id=r.id AND r1.logged_user_id=".$_SESSION['user_id']." limit 0,1),0) as is_created");
            $this->db->from('recipes r');
            $this->db->join('menu_group m','m.id=r.group_id','left');
            $this->db->where('r.is_delete',0);
            $this->db->where('r.is_active',1);
            $this->db->where('r.is_for_restaurant',1);
            if($searchkey!="")
                $this->db->like('lower(r.name)',strtolower($searchkey));
            $this->db->order_by('r.id','desc');
            $query = $this->db->get();
            $result = $query->result_array();
            /*echo $this->db->last_query();
            die;*/
            return  array(
                'recipes'=>$result,
                'total_count'=>$recipes_count['cnt'],
                'total_pages'=>1,
                'page_no'=>1,
                'page_total_text'=>"1 - ".$recipes_count['cnt']
            ); 
        }else{

            if (!isset($page_no)) {
                $page_no = 1;
            }

            if (!isset($records_per_page)) {
                $records_per_page = 30;
            }

            $offset = ($page_no-1) * $records_per_page;
           /* echo $offset;
            die;*/
            $this->db->select("r.*,m.title as group_name,DATE_FORMAT(recipe_date,'%d %M %Y') as recipe_date,ifnull((SELECT r1.id FROM recipes r1 WHERE r1.ref_recipe_id=r.id AND r1.logged_user_id=".$_SESSION['user_id']." limit 0,1),0) as is_created");
            $this->db->from('recipes r');
            $this->db->join('menu_group m','m.id=r.group_id','left');
            $this->db->where('r.is_delete',0);
            $this->db->where('r.is_active',1);
            $this->db->where('r.is_for_restaurant',1);
            $this->db->order_by('r.id','desc');
            $this->db->limit($records_per_page,$offset);
            $query = $this->db->get();
            $result = $query->result_array();
            /*echo $this->db->last_query();
            die;*/
            $total_pages = ceil($recipes_count['cnt'] / $records_per_page);

            if($recipes_count['cnt']<$records_per_page)
                $to_page=$recipes_count['cnt'];
            else
                $to_page=$records_per_page;
            return  array(
                'recipes'=>$result,
                'total_count'=>$recipes_count['cnt'],
                'total_pages'=>$total_pages,
                'page_no'=>$page_no,
                'page_total_text'=>($offset+1)." - ".$to_page
            ); 
        }
    }

    public function menu_from_restaurants($page_no,$records_per_page,$group_id="",$searchkey=""){
         //$this->db->where('r.logged_user_id',$user_id);
        $this->db->select('count(*) as cnt')->from('recipes');
        $this->db->where('is_delete',0);
        $this->db->where('is_active',1);
        $this->db->where('is_for_restaurant',1);
         if($searchkey!="")
                $this->db->like('lower(name)',strtolower($searchkey));
        $query = $this->db->get();
        $recipes_count=$query->row_array();

        if($records_per_page=="all"){
            $this->db->select("r.*,m.title as group_name,DATE_FORMAT(recipe_date,'%d %M %Y') as recipe_date,ifnull((SELECT r1.id FROM recipes r1 WHERE r1.ref_recipe_id=r.id AND r1.logged_user_id=".$_SESSION['user_id']." AND r1.is_menu_fromrestaurant=1 AND r1.is_delete=0 limit 0,1),0) as is_created");
            $this->db->from('recipes r');
            $this->db->join('menu_group m','m.id=r.group_id','left');
            $this->db->where('r.is_delete',0);
            $this->db->where('r.is_active',1);
            $this->db->where('r.is_for_restaurant',1);
            if($searchkey!="")
                $this->db->like('lower(r.name)',strtolower($searchkey));

            $this->db->order_by('r.id','desc');
            $query = $this->db->get();
            $result = $query->result_array();
            /*echo $this->db->last_query();
            die;*/
            return  array(
                'recipes'=>$result,
                'total_count'=>$recipes_count['cnt'],
                'total_pages'=>1,
                'page_no'=>1,
                'page_total_text'=>"1 - ".$recipes_count['cnt']
            ); 
        }else{

            if (!isset($page_no)) {
                $page_no = 1;
            }

            if (!isset($records_per_page)) {
                $records_per_page = 30;
            }

            $offset = ($page_no-1) * $records_per_page;
           /* echo $offset;
            die;*/
            $this->db->select("r.*,m.title as group_name,DATE_FORMAT(recipe_date,'%d %M %Y') as recipe_date,ifnull((SELECT r1.id FROM recipes r1 WHERE r1.ref_recipe_id=r.id AND r1.logged_user_id=".$_SESSION['user_id']." AND r1.is_menu_fromrestaurant=1 AND r1.is_delete=0 limit 0,1),0) as is_created");
            $this->db->from('recipes r');
            $this->db->join('menu_group m','m.id=r.group_id','left');
            $this->db->where('r.is_delete',0);
            $this->db->where('r.is_active',1);
            $this->db->where('r.is_for_restaurant',1);
            if($searchkey!="")
                $this->db->like('lower(r.name)',strtolower($searchkey));
            $this->db->order_by('r.id','desc');
            $this->db->limit($records_per_page,$offset);
            $query = $this->db->get();
            $result = $query->result_array();
            /*echo $this->db->last_query();
            die;*/
            $total_pages = ceil($recipes_count['cnt'] / $records_per_page);

            if($recipes_count['cnt']<$records_per_page)
                $to_page=$recipes_count['cnt'];
            else
                $to_page=$records_per_page;
            return  array(
                'recipes'=>$result,
                'total_count'=>$recipes_count['cnt'],
                'total_pages'=>$total_pages,
                'page_no'=>$page_no,
                'page_total_text'=>($offset+1)." - ".$to_page
            ); 
        }
    }


    public function list_todays_special_userwise($user_id,$main_menu_id,$tablecat_id=""){
        if($tablecat_id!=""){
             $this->db->select("r.*,DATE_FORMAT(recipe_date,'%d %M %Y') as recipe_date,ifnull(rp.price,r.price) as price",FALSE);
            $this->db->from('recipes r');
            $this->db->join('recipe_prices rp','rp.recipe_id=r.id AND rp.table_category_id='.$tablecat_id,'left');
            $this->db->where('r.is_delete',0);
            $this->db->where('r.is_active',1);
            $this->db->where('r.is_recipe_active',1);
            $this->db->where('r.is_todays_special',1);
            $this->db->where('r.logged_user_id',$user_id);
            $this->db->where('r.main_menu_id',$main_menu_id);
            $this->db->order_by('r.is_todays_special','desc');
            $query = $this->db->get();
            $result = $query->result_array();
        }else{
            $this->db->select("r.*,DATE_FORMAT(recipe_date,'%d %M %Y') as recipe_date");
            $this->db->from('recipes r');
            $this->db->where('r.is_delete',0);
            $this->db->where('r.is_active',1);
            $this->db->where('r.is_recipe_active',1);
            $this->db->where('r.is_todays_special',1);
            $this->db->where('r.logged_user_id',$user_id);
            $this->db->where('r.main_menu_id',$main_menu_id);
            $this->db->order_by('r.is_todays_special','desc');
            $query = $this->db->get();
            $result = $query->result_array();
        }
        return $result;
    }

    public function todays_special_menus($user_id,$page_no,$records_per_page,$group_id=""){
        $recipes_count=$this->db->select('count(*) as cnt')->from('recipes')->where('is_delete',0)->where('is_active',1)->where('is_recipe_active',1)->where('logged_user_id',$user_id)->get()->row_array();
        if($records_per_page=="all"){
            $this->db->select("r.*,m.title as group_name,DATE_FORMAT(recipe_date,'%d %M %Y') as recipe_date,ifnull((SELECT r1.id FROM recipes r1 WHERE r1.ref_recipe_id=r.id AND r1.logged_user_id=".$_SESSION['user_id']." AND r1.is_menu_fromrestaurant=1 limit 0,1),0) as is_created");
            $this->db->from('recipes r');
            $this->db->join('menu_group m','m.id=r.group_id','left');
            $this->db->where('r.is_delete',0);
            $this->db->where('r.is_active',1);
            $this->db->where('r.is_recipe_active',1);
            $this->db->where('r.logged_user_id',$user_id);
            $this->db->order_by('r.is_todays_special','desc');
            $query = $this->db->get();
            $result = $query->result_array();
            /*echo $this->db->last_query();
            die;*/
            return  array(
                'recipes'=>$result,
                'total_count'=>$recipes_count['cnt'],
                'total_pages'=>1,
                'page_no'=>1,
                'page_total_text'=>"1 - ".$recipes_count['cnt']
            ); 
        }else{

            if (!isset($page_no)) {
                $page_no = 1;
            }

            if (!isset($records_per_page)) {
                $records_per_page = 30;
            }

            $offset = ($page_no-1) * $records_per_page;
           /* echo $offset;
            die;*/
            $this->db->select("r.*,m.title as group_name,DATE_FORMAT(recipe_date,'%d %M %Y') as recipe_date,ifnull((SELECT r1.id FROM recipes r1 WHERE r1.ref_recipe_id=r.id AND r1.logged_user_id=".$_SESSION['user_id']." AND r1.is_menu_fromrestaurant=1 limit 0,1),0) as is_created");
            $this->db->from('recipes r');
            $this->db->join('menu_group m','m.id=r.group_id','left');
            $this->db->where('r.is_delete',0);
            $this->db->where('r.is_active',1);
            $this->db->where('r.is_recipe_active',1);
            
            /*$this->db->where('r.is_todays_special',1);*/
            $this->db->where('r.logged_user_id',$user_id);
            $this->db->order_by('r.is_todays_special','desc');
            $this->db->limit($records_per_page,$offset);
            $query = $this->db->get();
            $result = $query->result_array();
            /*echo $this->db->last_query();
            die;*/
            $total_pages = ceil($recipes_count['cnt'] / $records_per_page);

            if($recipes_count['cnt']<$records_per_page)
                $to_page=$recipes_count['cnt'];
            else
                $to_page=$records_per_page;
            return  array(
                'recipes'=>$result,
                'total_count'=>$recipes_count['cnt'],
                'total_pages'=>$total_pages,
                'page_no'=>$page_no,
                'page_total_text'=>($offset+1)." - ".$to_page
            ); 
        }
    }


    public function all_recipes($page_no,$records_per_page,$search_name="",$group_id=""){
        //$this->db->where('r.logged_user_id',$user_id);
            
        $recipes_count=$this->db->select('count(*) as cnt')->from('recipes')->where('is_delete',0)->where('is_active',1)->where('is_for_restaurant',0)->where('ref_recipe_id',0)->get()->row_array();
        if($records_per_page=="all"){
            $this->db->select("r.*,m.title as group_name,DATE_FORMAT(recipe_date,'%d %M %Y') as recipe_date");
            $this->db->from('recipes r');
            $this->db->join('menu_group m','m.id=r.group_id','left');
            $this->db->where('r.is_delete',0);
            $this->db->where('r.is_active',1);
            $this->db->where('r.is_for_restaurant',0);
            $this->db->where('r.ref_recipe_id',0);
            if($search_name!="")
                $this->db->like('LOWER(r.name)',strtolower($search_name));
            $this->db->order_by('r.id','desc');
            $query = $this->db->get();
            $result = $query->result_array();
            /*echo $this->db->last_query();
            die;*/
            return  array(
                'recipes'=>$result,
                'total_count'=>$recipes_count['cnt'],
                'total_pages'=>1,
                'page_no'=>1,
                'page_total_text'=>"1 - ".$recipes_count['cnt']
            );

        }else{

            if (!isset($page_no)) {
                $page_no = 1;
            }

            if (!isset($records_per_page)) {
                $records_per_page = 30;
            }

            $offset = ($page_no-1) * $records_per_page;
           /* echo $offset;
            die;*/
            $this->db->select("r.*,m.title as group_name,DATE_FORMAT(recipe_date,'%d %M %Y') as recipe_date");
            $this->db->from('recipes r');
            $this->db->join('menu_group m','m.id=r.group_id','left');
            $this->db->where('r.is_delete',0);
            $this->db->where('r.is_active',1);
            $this->db->where('r.is_for_restaurant',0);
            $this->db->where('r.ref_recipe_id',0);
            $this->db->order_by('r.id','desc');
            if($search_name!="")
                $this->db->like('LOWER(r.name)',strtolower($search_name));
            $this->db->limit($records_per_page,$offset);
            $query = $this->db->get();
            $result = $query->result_array();

            $total_pages = ceil($recipes_count['cnt'] / $records_per_page);

            if($recipes_count['cnt']<$records_per_page)
                $to_page=$recipes_count['cnt'];
            else
                $to_page=$records_per_page;
            return  array(
                'recipes'=>$result,
                'total_count'=>$recipes_count['cnt'],
                'total_pages'=>$total_pages,
                'page_no'=>$page_no,
                'page_total_text'=>($offset+1)." - ".$to_page
            ); 
        }
    }

    public function upload_image($key,$filename=""){

        $upload_path = './uploads/recipes/';
        $config = array(
            'upload_path' => $upload_path,
            'allowed_types' => 'jpg|jpeg|JPEG|JPG',
            'encrypt_name'=>TRUE
        );

        $config['image_library'] = 'gd2';
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['width']     = 300;
        $config['height']   = 300;

        if($filename!=""){
            $config['file_name']=$filename;
            $config['encrypt_name']=false;
        }

        $this->upload->initialize($config);
        if(!$this->upload->do_upload($key)){
            $error = $this->upload->display_errors();
            return array('status'=>false,'msg'=>strip_tags($error));

        }
        else{
            $file_data = $this->upload->data();
            $image_name = $file_data['file_name'];
            $cover_imgpath = 'uploads/recipes/'. $image_name;
            return array('status'=>true,'path'=>$cover_imgpath);

        }

    }

   public function make_active($id){    
        $this->db->select("r.id,r.name"); 
        $this->db->from('recipes r');   
        $this->db->where('r.id',$id);   
        $this->db->where('r.name!=','');    
        $this->db->where('r.group_id!=','');    
        $query = $this->db->get();  
        $row = $query->row_array(); 
      
        if(!empty($row)){   
            if($row['name']!="Untitled Recipe"){    
                $this->db->where('id',$id); 
                $this->db->update('recipes',array('is_active'=>1)); 

                $this->db->select('*'); 
                $this->db->from('user u');  
                $this->db->join('subscriptions s','s.id=u.subscription_id');    
                $this->db->where('u.id',$_SESSION['user_id']);  
                $this->db->where('s.is_used',0);    
                $query = $this->db->get();  
                $row = $query->row_array();

                if($row['period']=="perrecipe"){    
                    $s=$this->subscription_model;   
                    $s->id=$row['subscription_id']; 
                    $s->is_used=1;  
                    $s->update();   
                }   
            }   
        }   
    }

    public function recipes_count(){
        $this->db->select("count(*) as cnt");
        $this->db->from('recipes r');
        $this->db->where('r.is_delete',0);
        $this->db->where('r.is_active',1);
        $this->db->where('r.logged_user_id',$_SESSION['user_id']);
        $query = $this->db->get();
        $result = $query->row_array();
        return $result['cnt'];
    }

    public function count_foodcompany_recipes(){
        $this->db->select("GROUP_CONCAT(u.id) as user_concat");
        $this->db->from('user u');
        $this->db->where('(u.food_company_id='.$_SESSION['user_id'].' OR u.id='.$_SESSION['user_id'].')');
        $query = $this->db->get();
        $row = $query->row_array();

      /* echo "<pre>";
       print_r($row);
       die;*/
        $ids=explode(',', $row['user_concat']);

        $this->db->select("count(*) as cnt");
        $this->db->from('recipes r');
        $this->db->join('user u','u.id=r.logged_user_id');
        $this->db->where_in('r.logged_user_id',$ids);
        $this->db->where('r.is_delete',0);
        $this->db->where('r.is_active',1);

        $query = $this->db->get();
        $result = $query->row_array();
        return $result['cnt']; 
    }

    public function recipes_uertypewise_count(){
        $array=array('Restaurant','Burger and Sandwich','Restaurant chain','School','Individual User');
        $data=array();
        foreach ($array as $arr) {
            if($arr=="Restaurant chain"){
                $this->db->select("count(*) as recipe_count");
                $this->db->from('recipes r');
                $this->db->join('user u','u.id=r.logged_user_id');
                $this->db->where('r.is_delete',0);
                $this->db->where('r.is_active',1);
                $this->db->where("((u.usertype='Restaurant chain') OR (u.usertype='Restaurant' AND u.food_company_id!='') OR (u.usertype='Burger and Sandwich' AND u.food_company_id!=''))");
                $query = $this->db->get();
                $result = $query->row_array();
            }else{
                $this->db->select("count(*) as recipe_count");
                $this->db->from('recipes r');
                $this->db->join('user u','u.id=r.logged_user_id');
                $this->db->where('r.is_delete',0);
                $this->db->where('r.is_active',1);
                $this->db->where('u.usertype',$arr);
                if($arr=="Restaurant"){
                    $this->db->where("u.food_company_id",null);
                }
                $this->db->group_by('u.usertype');
                $query = $this->db->get();
                $result = $query->row_array();
            }
            /*echo $this->db->last_query();
            die;*/
            if(empty($result)){
                $data[$arr]=0;
            }
            else
                $data[$arr]=$result['recipe_count'];
        }
        return $data;
    }

    
    public function recipes_views_count(){
        $this->db->select("ifnull(SUM(r.views),0) as cnt");
        $this->db->from('recipes r');
        $this->db->where('r.is_delete',0);
        $this->db->where('r.is_active',1);

        $this->db->where('r.logged_user_id',$_SESSION['user_id']);
        $query = $this->db->get();
        $result = $query->row_array();
        return $result['cnt'];
    }

    public function ttlvisited_users_count(){
        $this->db->select_sum("no_of_visits");
        $this->db->from('get_restaurant_count r');
        $this->db->where('r.restaurant_id',$_SESSION['user_id']);
        $query = $this->db->get();
        $result = $query->row_array();
        return $result['no_of_visits'];
    }

    public function visited_users_count(){
        $this->db->select_sum("no_of_visits");
        $this->db->from('get_restaurant_count r');
        $this->db->where('r.visited_at',date('Y-m-d'));
        $this->db->where('r.restaurant_id',$_SESSION['user_id']);
        $query = $this->db->get();
        $result = $query->row_array();
        return $result['no_of_visits'];
    }
    public function ttlvisited_recipes_count(){
        $this->db->select_sum("no_of_visits");
        $this->db->from('get_recipe_count r');
        $this->db->where('r.restaurant_id',$_SESSION['user_id']);
        $query = $this->db->get();
        $result = $query->row_array();
        return $result['no_of_visits'];
    }

    public function visited_recipes_count(){
        $this->db->select_sum("no_of_visits");
        $this->db->from('get_recipe_count r');
        $this->db->where('r.visited_at',date('Y-m-d'));
        $this->db->where('r.restaurant_id',$_SESSION['user_id']);
        $query = $this->db->get();
        $result = $query->row_array();
        return $result['no_of_visits'];
    }
    
    public function list_recipes_groupwise($group_id){   
        if($group_id!=""){  
            $this->db->select("r.*,m.title as group_name,DATE_FORMAT(recipe_date,'%d %M %Y') as recipe_date,r.recipe_date as added_date,ifnull(im.img_path,r.recipe_image) as recipe_image");  
            $this->db->from('recipes r');  
            $this->db->join('recipe_images_master im','im.id=r.recipe_image_id','left');
            $this->db->join('menu_group m','m.id=r.group_id','left');   
            $this->db->where('r.group_id',$group_id);   
            $this->db->where('r.is_delete',0);  
            $this->db->where('r.is_active',1);  
            $query = $this->db->get();  
            $result = $query->result_array();   
            return $result;     
        }else{  
            return array(); 
        }   
    }



    public function list_most_visited_recipes(){
        $this->db->select("r.*,m.title as group_name,DATE_FORMAT(recipe_date,'%d %M %Y') as recipe_date,r.recipe_date as added_date");
        $this->db->from('recipes r');
        $this->db->join('menu_group m','m.id=r.group_id','left');
        $this->db->where('r.is_delete',0);
        $this->db->where('r.is_active',1);

        $this->db->where('r.logged_user_id',$_SESSION['user_id']);
        $this->db->order_by('views','desc');
        $this->db->limit(5);
        $query = $this->db->get();
        $result = $query->result_array();
        $data=array();
        foreach ($result as $res) {
            $res['time_ago']=$this->get_time_ago(strtotime($res['added_date']));
            $data[]=$res;
        }
        return $data; 
    }

    public function list_recipes_userwise($user_id,$page_no,$records_per_page){
        //$this->db->where('r.logged_user_id',$user_id);
        $recipes_count=$this->db->select('count(*) as cnt')->from('recipes')->where('logged_user_id',$user_id)->where('is_delete',0)->where('is_active',1)->get()->row_array();
        if($records_per_page=="all"){
            $this->db->select("r.*,m.title as group_name,DATE_FORMAT(recipe_date,'%d %M %Y') as recipe_date");
            $this->db->from('recipes r');
            $this->db->join('menu_group m','m.id=r.group_id','left');
            $this->db->where('r.is_delete',0);
            $this->db->where('r.is_active',1);
            $this->db->where('r.logged_user_id',$user_id);
            $this->db->order_by('r.id','desc');
            $query = $this->db->get();
            $result = $query->result_array();

            return  array(
                'recipes'=>$result,
                'total_count'=>$recipes_count['cnt'],
                'total_pages'=>1,
                'page_no'=>1,
                'page_total_text'=>"1 - ".$recipes_count['cnt']
            ); 
        }else{

            if (!isset($page_no)) {
                $page_no = 1;
            }

            if (!isset($records_per_page)) {
                $records_per_page = 30;
            }

            $offset = ($page_no-1) * $records_per_page;
           /* echo $offset;
            die;*/
            $this->db->select("r.*,m.title as group_name,DATE_FORMAT(recipe_date,'%d %M %Y') as recipe_date");
            $this->db->from('recipes r');
            $this->db->join('menu_group m','m.id=r.group_id','left');
            $this->db->where('r.is_delete',0);
            $this->db->where('r.is_active',1);
            $this->db->where('r.logged_user_id',$user_id);
            $this->db->order_by('r.id','desc');
            $this->db->limit($records_per_page,$offset);
            $query = $this->db->get();
            $result = $query->result_array();

            $total_pages = ceil($recipes_count['cnt'] / $records_per_page);

            if($recipes_count['cnt']<$records_per_page)
                $to_page=$recipes_count['cnt'];
            else
                $to_page=$records_per_page;
            return  array(
                'recipes'=>$result,
                'total_count'=>$recipes_count['cnt'],
                'total_pages'=>$total_pages,
                'page_no'=>$page_no,
                'page_total_text'=>($offset+1)." - ".$to_page
            ); 
        }
    }


    public function list_recently_added_recipes(){
        $this->db->select("r.*,m.title as group_name,DATE_FORMAT(recipe_date,'%d %M %Y') as recipe_date,r.recipe_date as added_date");
        $this->db->from('recipes r');
        $this->db->join('menu_group m','m.id=r.group_id','left');
        $this->db->where('r.is_delete',0);
        $this->db->where('r.is_active',1);
        $this->db->where('r.logged_user_id',$_SESSION['user_id']);
         $this->db->order_by('r.id','desc');
        $this->db->limit(10);
        $query = $this->db->get();
        $result = $query->result_array();
            // echo "<pre>";
            //                 print_r($result);
            //                 die;
        $data=array();
        foreach ($result as $res) {
            $res['time_ago']=$this->get_time_ago(strtotime($res['added_date']));
            $data[]=$res;
        }
        return $data; 
    }

    public function list_recipes($page_no,$records_per_page,$searchkey=""){

        $recipes_count=$this->db->select('count(*) as cnt')->from('tbl_recipes_master')->where('is_delete',0)->get()->row_array();
      
        if($recipes_count['cnt']<=0){
             $this->db->select("*");
            $this->db->from('tbl_recipes_master');
            $this->db->where('is_delete',0);
            $this->db->order_by("id","DESC");
            $query = $this->db->get();
            $result = $query->result_array();

            return  array(
                'recipes'=>$result,
                'total_count'=>$recipes_count['cnt'],
                'total_pages'=>1,
                'page_no'=>1,
                'page_total_text'=>"0 - ".$recipes_count['cnt']
            ); 
        }else{
            if($records_per_page=="all"){
                $this->db->select("r.*");
                $this->db->from('tbl_recipes_master r');
                $this->db->where('r.is_delete',0);
                if($searchkey!="")
                    $this->db->like('lower(r.name)',strtolower($searchkey));
                $this->db->order_by("r.id","DESC");
                $query = $this->db->get();

                $result = $query->result_array();
 
                return  array(
                    'recipes'=>$result,
                    'total_count'=>$recipes_count['cnt'],
                    'total_pages'=>1,
                    'page_no'=>1,
                    'page_total_text'=>"1 - ".$recipes_count['cnt']
                ); 
            }else{

                if (!isset($page_no)) {
                    $page_no = 1;
                }

                if (!isset($records_per_page)) {
                    $records_per_page = 30;
                }

                $offset = ($page_no-1) * $records_per_page;
               /* echo $offset;
                die;*/
                $this->db->select("r.*");
                $this->db->from('tbl_recipes_master r');
                $this->db->where('r.is_delete',0);
                $this->db->order_by("r.id","DESC");
                $this->db->limit($records_per_page,$offset);
                $query = $this->db->get();
               /*  echo $this->db->last_query();
                die;*/
                $result = $query->result_array();
                $total_pages = ceil($recipes_count['cnt'] / $records_per_page);

                if($recipes_count['cnt']<$records_per_page)
                    $to_page=$recipes_count['cnt'];
                else
                    $to_page=$records_per_page;
                return  array(
                    'recipes'=>$result,
                    'total_count'=>$recipes_count['cnt'],
                    'total_pages'=>$total_pages,
                    'page_no'=>$page_no,
                    'page_total_text'=>($offset+1)." - ".$to_page
                ); 
            }
        }

    }

    public function groupnot_recipe_count(){
        $recipes_count=$this->db->select('count(*) as cnt')->from('recipes')->where('logged_user_id',$_SESSION['user_id'])->where('is_delete',0)->where('is_active',1)->where("(group_id='' OR group_id IS NULL)")->get()->row_array();

         return $recipes_count['cnt'];
    }

    public function list_groupnot_recipes($page_no,$records_per_page){
        $recipes_count=$this->db->select('count(*) as cnt')->from('recipes')->where('logged_user_id',$_SESSION['user_id'])->where('is_delete',0)->where('is_active',1)->where("(group_id='' OR group_id IS NULL)")->get()->row_array();

        if($recipes_count['cnt']<=0){
             $this->db->select("r.*,m.title as group_name,DATE_FORMAT(recipe_date,'%d %M %Y') as recipe_date");
            $this->db->from('recipes r');
            $this->db->join('menu_group m','m.id=r.group_id','left');
            $this->db->where('r.is_delete',0);
            $this->db->where('r.is_active',1);
            $this->db->where('(r.group_id="" OR r.group_id IS NULL)');
            $this->db->where('r.logged_user_id',$_SESSION['user_id']);
            $this->db->order_by("recipe_date desc,r.id desc");
            $query = $this->db->get();
            $result = $query->result_array();

            return  array(
                'recipes'=>$result,
                'total_count'=>1,
                'total_pages'=>1,
                'page_no'=>1,
                'page_total_text'=>"1 - 1"
            ); 
        }else{
            if($records_per_page=="all"){
                $this->db->select("r.*,m.title as group_name,DATE_FORMAT(recipe_date,'%d %M %Y') as recipe_date");
                $this->db->from('recipes r');
                $this->db->join('menu_group m','m.id=r.group_id','left');
                $this->db->where('r.is_delete',0);
                $this->db->where('r.is_active',1);
                $this->db->where('(r.group_id="" OR r.group_id IS NULL)');
                $this->db->where('r.logged_user_id',$_SESSION['user_id']);
                $this->db->order_by("recipe_date desc,r.id desc");
                $query = $this->db->get();
                $result = $query->result_array();

                return  array(
                    'recipes'=>$result,
                    'total_count'=>$recipes_count['cnt'],
                    'total_pages'=>1,
                    'page_no'=>1,
                    'page_total_text'=>"1 - ".$recipes_count['cnt']
                ); 
            }else{

                if (!isset($page_no)) {
                    $page_no = 1;
                }

                if (!isset($records_per_page)) {
                    $records_per_page = 30;
                }

                $offset = ($page_no-1) * $records_per_page;
               /* echo $offset;
                die;*/
                $this->db->select("r.*,m.title as group_name,DATE_FORMAT(recipe_date,'%d %M %Y') as recipe_date");
                $this->db->from('recipes r');
                $this->db->join('menu_group m','m.id=r.group_id','left');
                $this->db->where('r.is_delete',0);
                $this->db->where('r.is_active',1);
                $this->db->where('r.logged_user_id',$_SESSION['user_id']);
                $this->db->where('(r.group_id="" OR r.group_id IS NULL)');
                $this->db->order_by("recipe_date desc,r.id desc");
                $this->db->limit($records_per_page,$offset);
                $query = $this->db->get();
                $result = $query->result_array();

                $total_pages = ceil($recipes_count['cnt'] / $records_per_page);

                if($recipes_count['cnt']<$records_per_page)
                    $to_page=$recipes_count['cnt'];
                else
                    $to_page=$records_per_page;
                return  array(
                    'recipes'=>$result,
                    'total_count'=>$recipes_count['cnt'],
                    'total_pages'=>$total_pages,
                    'page_no'=>$page_no,
                    'page_total_text'=>($offset+1)." - ".$to_page
                ); 
            }
        }

    }

    public function list_api_recipes($page_no,$records_per_page,$user_id){

        $recipes_count=$this->db->select('count(*) as cnt')->from('recipes')->where('logged_user_id',$user_id)->where('is_delete',0)->where('is_active',1)->get()->row_array();
      
         if($records_per_page=="all"){
                $this->db->select("r.*,m.title as group_name,DATE_FORMAT(recipe_date,'%d %M %Y') as recipe_date");
                $this->db->from('recipes r');
                $this->db->join('menu_group m','m.id=r.group_id','left');
                $this->db->where('r.is_delete',0);
                $this->db->where('r.is_active',1);
                $this->db->where('r.logged_user_id',$user_id);
                $this->db->where('r.is_for_restaurant',0);
                $this->db->order_by('r.id','desc');
                $query = $this->db->get();
                $result = $query->result_array();

                return  array(
                    'recipes'=>$result,
                    'total_count'=>$recipes_count['cnt'],
                    'total_pages'=>1,
                    'page_no'=>1,
                    'page_total_text'=>"1 - ".$recipes_count['cnt']
                ); 
        }else{

            if (!isset($page_no)) {
                $page_no = 1;
            }

            if (!isset($records_per_page)) {
                $records_per_page = 30;
            }

            $offset = ($page_no-1) * $records_per_page;
           
            $this->db->select("r.*,m.title as group_name,DATE_FORMAT(recipe_date,'%d %M %Y') as recipe_date");
            $this->db->from('recipes r');
            $this->db->join('menu_group m','m.id=r.group_id','left');
            $this->db->where('r.is_delete',0);
            $this->db->where('r.is_active',1);
            $this->db->where('r.logged_user_id',$user_id);
            $this->db->order_by('r.id','desc');
            $this->db->where('r.is_for_restaurant',0);
            $this->db->limit($records_per_page,$offset);
            $query = $this->db->get();
            $result = $query->result_array();

            $total_pages = ceil($recipes_count['cnt'] / $records_per_page);

            if($recipes_count['cnt']<$records_per_page)
                $to_page=$recipes_count['cnt'];
            else
                $to_page=$records_per_page;
            return  array(
                'recipes'=>$result,
                'total_count'=>$recipes_count['cnt'],
                'total_pages'=>$total_pages,
                'page_no'=>$page_no,
                'page_total_text'=>($offset+1)." - ".$to_page
            ); 
        }

    }

    public function list_recipes_all(){

        $this->db->select("r.*,DATE_FORMAT(recipe_date,'%d %M %Y') as recipe_date");
        $this->db->from('recipes r');
        $this->db->where('r.is_delete',0);
        $this->db->where('r.is_active',1);
        $this->db->where('r.id>=',450);
        $this->db->order_by('r.id','asc');
        $query = $this->db->get();
        $result = $query->result_array();
        return  $result; 
    }


    public function update_todays_special($user_id){
        $this->db->where('logged_user_id',$user_id);
        $this->db->update('recipes',array('is_todays_special'=>0));
    }


    public function update_ref_recipe($recipe_id){
        $this->db->where('id',$recipe_id);
        $this->db->update('recipes',array('isadded_for_restaurant'=>0,'is_for_restaurant'=>0));
    }


    public function update_recipe_visit_count($recipe_id,$group_id,$restaurant_id){
        $today=date('Y-m-d');
        $this->db->select('*');
        $this->db->from('get_recipe_count');
        $this->db->where('recipe_id', $recipe_id);
        $this->db->where('visited_at',$today);
        $this->db->where('group_id',$group_id);
        $query = $this->db->get();
        $row = $query->row_array();
      
        if(!empty($row)){
            $no_of_visits=intval($row['no_of_visits'])+1;

            $this->db->where('recipe_id', $recipe_id);
            $this->db->where('visited_at',$today);
            $this->db->where('group_id',$group_id);
            $this->db->where('restaurant_id',$restaurant_id);
            $this->db->update('get_recipe_count', array('no_of_visits' => $no_of_visits));
        }else{

            $this->db->insert('get_recipe_count',array(
                'no_of_visits' => 1,
                'recipe_id'=>$recipe_id,
                'group_id'=>$group_id,
                'restaurant_id'=>$restaurant_id,
                'visited_at'=>$today
            ));
        }
        return  $row;       
    }

    public function update_mainmenuid($main_menu_id,$group_id){

        $this->db->where('group_id',$group_id);
        $this->db->where('logged_user_id',$_SESSION['user_id']);
        $this->db->update('recipes', array('main_menu_id' => $main_menu_id));
        return  $row;       
    }

    public function update_recipe_price($recipe_id,$array){

        $this->db->where('id',$recipe_id);
        $this->db->update('recipes', $array);

        return;       
    }

    public function get_cart_menu_details(){
        $carts=$this->cart->contents();
       
        return $carts;
    }

}
?>