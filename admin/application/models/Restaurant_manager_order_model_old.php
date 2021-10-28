<?php
class Restaurant_manager_order_model extends My_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function list_recipes_typahead($rest_id){
        $this->db->select("r.id,r.name,r.price");
        $this->db->from('recipes r');
        $this->db->join('menu_group m','m.id=r.group_id');
        $this->db->join('menu_master mm','mm.id=r.main_menu_id');
        $this->db->where('r.logged_user_id',$rest_id);
        $this->db->where('r.is_delete',0);
        $this->db->where('r.is_active',1);
        $this->db->where('r.is_recipe_active',1);
        $this->db->where('m.is_active',1);
        $this->db->where('mm.is_active',1);
        $query = $this->db->get();
        $row = $query->result_array();
        return  $row;       
    }

    public function all_recipes_show_rest($id,$tblcategory,$searchkey=""){
        $this->db->select("r.id,r.group_id,r.name,r.recipe_type,ifnull(rp.price,r.price) as price,ao.discount,ao.status as offer_status,ao.discount_type");
        $this->db->from('recipes as r');
        $this->db->join('menu_group mg', 'mg.id = r.group_id','left');
        $this->db->join('menu_master mm', 'mm.id = r.main_menu_id','left');
        $this->db->join('admin_offer ao','ao.recipe_id=r.id','left');
        $this->db->join('recipe_prices rp','rp.recipe_id=r.id AND rp.table_category_id='.$tblcategory,'left');
        $this->db->where('r.logged_user_id',$id);
        $this->db->where('r.is_delete',0);
        $this->db->where('r.is_active',1);
        //$this->db->where('mg.is_active',1);
        $this->db->where('r.is_recipe_active',1);
        $this->db->where('mm.is_active',1);
        if($searchkey!="")
                $this->db->like('lower(r.name)',strtolower($searchkey));
        $query = $this->db->get();
        $row = $query->result_array();
        return  $row;
    }

    public function all_recipes_show_rest1($rest_id,$main_menu_id="",$searchkey="",$tablecat_id=""){
        if($tablecat_id!=""){
             $this->db->select("r.*,ifnull(rp.price,r.price) as price,ifnull(best_time_to_eat,'') as best_time_to_eat,rp.price as rp_price",FALSE);
            $this->db->from('recipes r');
            $this->db->join('recipe_prices rp','rp.recipe_id=r.id AND rp.table_category_id='.$tablecat_id,'left');
            $this->db->join('menu_group m','m.id=r.group_id');
            $this->db->join('menu_master mm', 'mm.id = r.main_menu_id');
            $this->db->where('r.is_delete',0);
            $this->db->where('r.is_active',1);
            $this->db->where('r.is_recipe_active',1);
            $this->db->where('m.is_active',1);
            $this->db->where('mm.is_active',1);
            $this->db->where('r.logged_user_id',$rest_id);
            if($main_menu_id!="")
                $this->db->where('r.main_menu_id',$main_menu_id);
            /*if($group_id!="")
                $this->db->where('m.id',$group_id);*/
            if($searchkey!=""){
                $this->db->like('lower(r.name)',strtolower($searchkey));
            }else{
                $this->db->limit(20);
            }
            $query = $this->db->get();
            $result = $query->result_array();
        }else{
            $this->db->select('r.*,ifnull(best_time_to_eat,"") as best_time_to_eat');
            $this->db->from('recipes r');
            /*$this->db->join('recipe_images_master im','im.id=r.recipe_image_id','left');*/
            $this->db->join('menu_group m','m.id=r.group_id');
            $this->db->join('menu_master mm', 'mm.id = r.main_menu_id');
            $this->db->where('r.is_delete',0);
            $this->db->where('r.is_active',1);
            $this->db->where('r.is_recipe_active',1);
            $this->db->where('m.is_active',1);
            $this->db->where('mm.is_active',1);
            $this->db->where('r.logged_user_id',$rest_id);
            if($main_menu_id!="")
                $this->db->where('r.main_menu_id',$main_menu_id);
            /*if($group_id!="")
                $this->db->where('m.id',$group_id);*/
            if($searchkey!=""){
                $this->db->like('lower(r.name)',strtolower($searchkey));
            }else{
                $this->db->limit(20);
            }
            $query = $this->db->get();
            $result = $query->result_array();
        }
       
        return  $result;
    }


    public function insert_any_query($table,$data){
        return $this->db->insert($table,$data);
    }

    public function updateactive_inactive($table,$condition,$data)
    {
        return $this->db->where($condition)->update($table, $data);
    }

    public function permanent_delete_manager($table,$condition){
        return $this->db->delete($table,$condition);
    }

    public function select_where($table,$condition){
        return $this->db->where($condition)->get($table)->result_array();
    }

    public function select_order($table,$column,$order)
    {
        return $this->db->order_by($column,'DESC')->get($table)->result_array();
    }

    public function select_where_order($table,$column,$order,$condition)
    {
        return $this->db->where($condition)->order_by($column,$order)->get($table)->result_array();
    }

    public function query($query)
    {
        return $this->db->query($query)->result_array();
    }

    public function list_manager($page_no,$records_per_page,$searchkey=""){
        $restaurant_id=$this->db->select('upline_id')->from('user')->where('id',$_SESSION['user_id'])->get()->result_array();
        //print_r($restaurant_id[0]['upline_id']);
        $restaurant_count=$this->db->select('count(*) as cnt')->from('orders')->where('rest_id',$restaurant_id[0]['upline_id'])->where('status','New')->get()->row_array();
      
        if($restaurant_count['cnt']<=0){
             $this->db->select('o.*,t.title');
            $this->db->from('orders as o');
            $this->db->join('table_details as t', 't.id = o.id');
            $this->db->where('o.status','New');
            $this->db->where('o.rest_id',$restaurant_id[0]['upline_id']);
            $this->db->order_by("o.id DESC");
            $query = $this->db->get();
            $result = $query->result_array();

            return  array(
                'manager'=>$result,
                'total_count'=>$restaurant_count['cnt'],
                'total_pages'=>1,
                'page_no'=>1,
                'page_total_text'=>"0 - ".$restaurant_count['cnt']
            ); 
        }else{
            if($records_per_page=="all"){
                $this->db->select('o.*,t.title');
                $this->db->from('orders as o');
                $this->db->join('table_details as t', 't.id = o.id');
                $this->db->where('o.status','New');
                $this->db->where('o.rest_id',$restaurant_id[0]['upline_id']);
                $this->db->order_by("o.id DESC");
                if($searchkey!="")
                    $this->db->like('lower(o.order_no)',strtolower($searchkey));
                $this->db->where('o.status','New');
                $this->db->where('o.rest_id',$restaurant_id[0]['upline_id']);
                $this->db->order_by("o.id DESC");
                $query = $this->db->get();

                $result = $query->result_array();
 
                return  array(
                    'manager'=>$result,
                    'total_count'=>$restaurant_count['cnt'],
                    'total_pages'=>1,
                    'page_no'=>1,
                    'page_total_text'=>"1 - ".$restaurant_count['cnt']
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
                $this->db->select('o.*,t.title');
                $this->db->from('orders as o');
                $this->db->join('table_details as t', 't.id = o.id');
                $this->db->where('o.status','New');
                $this->db->where('o.rest_id',$restaurant_id[0]['upline_id']);
                $this->db->order_by("o.id DESC");
                $this->db->limit($records_per_page,$offset);
                $query = $this->db->get();
               /*  echo $this->db->last_query();
                die;*/
                $result = $query->result_array();
                $total_pages = ceil($restaurant_count['cnt'] / $records_per_page);

                if($restaurant_count['cnt']<$records_per_page)
                    $to_page=$restaurant_count['cnt'];
                else
                    $to_page=$records_per_page;
                return  array(
                    'manager'=>$result,
                    'total_count'=>$restaurant_count['cnt'],
                    'total_pages'=>$total_pages,
                    'page_no'=>$page_no,
                    'page_total_text'=>($offset+1)." - ".$to_page
                ); 
            }
        }

    }


    public function list_tablwise_orders($date,$restaurant_id,$search_key="")
	{
        $this->db->select("o.*,DATE_FORMAT(insert_date,'%d %b %Y') as order_date,DATE_FORMAT(insert_time,'%h:%i %p') as insert_time,t.title as table_no");
		$this->db->from('table_orders o');
		$this->db->join('table_details t','t.id=o.table_id');
		
		if($search_key!="")
		{
			$this->db->like('LOWER(o.table_orderno)',strtolower($search_key));
			$this->db->where('o.restaurant_id',$restaurant_id);
			$this->db->where('o.insert_date',$date);
			$this->db->or_like('LOWER(t.title)',strtolower($search_key));
			$this->db->where('o.restaurant_id',$restaurant_id);
			$this->db->where('o.insert_date',$date);
		}
		
		$this->db->where('o.restaurant_id',$restaurant_id);
		$this->db->where('o.insert_date',$date);
		$this->db->order_by('o.id','desc');
		$query = $this->db->get();
		$result = $query->result_array();
		/*echo $this->db->last_query();
		die;*/
		return  array(
			'orders'=>$result
		);
    }

    public function get_table_orderdetails($table_order_id,$restaurant_id){
        $this->db->select("o.*,t.title as table_no,DATE_FORMAT(insert_date,'%d %b %Y') as order_date");
        $this->db->from('table_orders o');
        $this->db->join('table_details t','t.id=o.table_id');
        $this->db->where('o.id',$table_order_id);
        $query = $this->db->get();
        $row = $query->row_array();

        $this->db->select("o.*,DATE_FORMAT(created_at,'%d %b %Y %h:%i %p') as order_date,t.title as table_no,c.name as customer_name,c.contact_no,ifnull(u.name,'customer') as order_by_name");
        $this->db->from('orders as o');
        $this->db->join('customer c','c.id=o.customer_id');
        $this->db->join('user u','u.id=o.order_by','left');
        $this->db->join('table_details t','t.id=o.table_id','left');
        $this->db->where('o.table_orders_id',$table_order_id);
        $this->db->where('o.rest_id',$restaurant_id);
        $this->db->order_by('o.id','desc');
        $query = $this->db->get();
        $row['orders'] = $query->result_array();
        return $row;
    }
}
?>