<?php
class Order_model extends My_Model {
    var $order_no;
    var $customer_id;
    var $table_id;
    var $rest_id;
    var $loyalty_points;
    var $sub_total;
    var $disc_total;
    var $net_total;
    var $suggetion;
    var $status;
    var $created_at;
    var $table_orders_id;
    var $is_invoiced;
    var $order_by;
    var $tablename="orders";
    var $fields=array('order_no','customer_id','table_id','rest_id','loyalty_points','sub_total','disc_total','net_total','suggetion','status','created_at','table_orders_id','is_invoiced','order_by');
    public function __construct()
    {
    	$this->load->database();
        $this->load->model('order_item_model');
    }

    public function total_order_count($rest_id,$status=""){
        $this->db->select('COUNT(id) as recipe_count');
        $this->db->from('orders');
        $this->db->where('rest_id',$rest_id);
        if($status!="")
            $this->db->where('status',$status);
        $query = $this->db->get();
        $row = $query->row_array();

        return $row['recipe_count']; 
    }

    public function get_order_details($order_id){
        $this->db->select("o.*,DATE_FORMAT(created_at,'%d/%m/%Y %h:%i %p') as order_date,t.title as table_no,c.name as customer_name,c.contact_no");
        $this->db->from('orders as o');
        $this->db->join('customer c','c.id=o.customer_id');
        $this->db->join('table_details t','t.id=o.table_id','left');
        $this->db->where('o.id',$order_id);
        $query = $this->db->get();
        $result = $query->row_array();
        $result['items']=$this->order_item_model->list_order_items($order_id);
        return $result;
    }


    public function all_orders($page_no,$records_per_page,$status,$search_name=""){
        //$this->db->where('r.logged_user_id',$user_id);
            
        $this->db->select('count(o.id) as cnt');
        $this->db->from('orders o');
        $this->db->join('customer c','c.id=o.customer_id');
        if($search_name!=""){
            $this->db->like('LOWER(o.order_no)',strtolower($search_name));
            $this->db->or_like('LOWER(c.name)',strtolower($search_name));
        }
        if($status!="")
                $this->db->where('o.status',$status);
        $this->db->where('o.rest_id',$_SESSION['user_id']);
        $query=$this->db->get();
        $recipes_count=$query->row_array();

        if($records_per_page=="all"){
            $this->db->select("o.*,DATE_FORMAT(created_at,'%d %b %Y %h:%i %p') as order_date,t.title as table_no,c.name as customer_name,c.contact_no,ifnull(u.name,'customer') as order_by_name");
            $this->db->from('orders as o');
            $this->db->join('customer c','c.id=o.customer_id');
            $this->db->join('user u','u.id=o.order_by','left');
            $this->db->join('table_details t','t.id=o.table_id','left');
            if($search_name!=""){
                $this->db->like('LOWER(c.name)',strtolower($search_name));
                $this->db->or_like('LOWER(o.order_no)',strtolower($search_name));
            }
            if($status!="")
                $this->db->where('o.status',$status);
            $this->db->where('o.rest_id',$_SESSION['user_id']);
            $this->db->order_by('o.id','desc');
            $query = $this->db->get();
            $result = $query->result_array();
            /*echo $this->db->last_query();
            die;*/
            return  array(
                'orders'=>$result,
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
            $this->db->select("o.*,DATE_FORMAT(created_at,'%d %b %Y %h:%i %p') as order_date,t.title as table_no,c.name as customer_name,c.contact_no,ifnull(u.name,'customer') as order_by_name");
            $this->db->from('orders as o');
            $this->db->join('customer c','c.id=o.customer_id');
            $this->db->join('user u','u.id=o.order_by','left');
            $this->db->join('table_details t','t.id=o.table_id','left');
            if($search_name!=""){
                $this->db->like('LOWER(c.name)',strtolower($search_name));
                $this->db->or_like('LOWER(o.order_no)',strtolower($search_name));
            }
            if($status!="")
                $this->db->where('o.status',$status);
            $this->db->where('o.rest_id',$_SESSION['user_id']);
            $this->db->order_by('o.id','desc');
            $this->db->limit($records_per_page,$offset);
            $query = $this->db->get();
            $result = $query->result_array();

            $total_pages = ceil($recipes_count['cnt'] / $records_per_page);

            if($recipes_count['cnt']<$records_per_page)
                $to_page=$recipes_count['cnt'];
            else
                $to_page=$records_per_page;
            if($to_page==0)
                $offset=$offset;
            else
                $offset=$offset+1;
            return  array(
                'orders'=>$result,
                'total_count'=>$recipes_count['cnt'],
                'total_pages'=>$total_pages,
                'page_no'=>$page_no,
                'page_total_text'=>($offset)." - ".$to_page
            ); 
        }
    }

    public function get_table_orderdetails($table_order_id){
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
        $this->db->where('o.rest_id',$_SESSION['user_id']);
        $this->db->order_by('o.id','desc');
        $query = $this->db->get();
        $row['orders'] = $query->result_array();
        return $row;
    }

    public function list_tablwise_orders($page_no,$records_per_page,$status,$order_date,$search_name=""){

        $this->db->select('count(o.id) as cnt');
        $this->db->from('table_orders o');
        $this->db->join('table_details t','t.id=o.table_id');
        if($search_name!=""){
            $where='(UPPER(o.table_orderno) LIKE "%'.strtoupper($search_name).'%" OR UPPER(t.title) LIKE "%'.strtoupper($search_name).'%")';
            $this->db->where($where);
        }
        $this->db->where('o.insert_date',$order_date);
        $this->db->where('o.restaurant_id',$_SESSION['user_id']);
        $query=$this->db->get();
        $recipes_count=$query->row_array();
       /* echo $this->db->last_query();
        die;*/

        if($records_per_page=="all"){
            $this->db->select("o.*,DATE_FORMAT(insert_date,'%d %b %Y') as order_date,DATE_FORMAT(insert_time,'%h:%i %p') as insert_time,t.title as table_no");
            $this->db->from('table_orders o');
            $this->db->join('table_details t','t.id=o.table_id');
            $this->db->where('o.insert_date',$order_date);
            if($search_name!=""){
                $where='(UPPER(o.table_orderno) LIKE "%'.strtoupper($search_name).'%" OR UPPER(t.title) LIKE "%'.strtoupper($search_name).'%")';
                $this->db->where($where);
            }
            $this->db->where('o.restaurant_id',$_SESSION['user_id']);
            $this->db->order_by('o.id','desc');
            $query = $this->db->get();
            $result = $query->result_array();
            /*echo $this->db->last_query();
            die;*/
            return  array(
                'orders'=>$result,
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
          
            $this->db->select("o.*,DATE_FORMAT(insert_date,'%d %b %Y') as order_date,DATE_FORMAT(insert_time,'%h:%i %p') as insert_time,t.title as table_no");
            $this->db->from('table_orders o');
            $this->db->join('table_details t','t.id=o.table_id');
            $this->db->where('o.insert_date',$order_date);
            if($search_name!=""){
                $where='(UPPER(o.table_orderno) LIKE "%'.strtoupper($search_name).'%" OR UPPER(t.title) LIKE "%'.strtoupper($search_name).'%")';
                $this->db->where($where);
            }
            $this->db->where('o.restaurant_id',$_SESSION['user_id']);
            $this->db->order_by('o.id','desc');
            $this->db->limit($records_per_page,$offset);
            $query = $this->db->get();
            $result = $query->result_array();

            $total_pages = ceil($recipes_count['cnt'] / $records_per_page);

            if($recipes_count['cnt']<$records_per_page)
                $to_page=$recipes_count['cnt'];
            else
                $to_page=$records_per_page;
            if($to_page==0)
                $offset=$offset;
            else
                $offset=$offset+1;
            return  array(
                'orders'=>$result,
                'total_count'=>$recipes_count['cnt'],
                'total_pages'=>$total_pages,
                'page_no'=>$page_no,
                'page_total_text'=>($offset)." - ".$to_page
            ); 
        }
    }
    public function block_unblock_table($id,$is_available){
        $this->db->where('id',$id);
        $this->db->update('table_details',array(
            'is_available'=>$is_available
        ));

    }
}
?>