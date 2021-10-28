<?php
class Restaurant_offer extends My_Model {
    var $title;
    var $offer_image;
    var $discount;
    var $recipe_id;
    var $status;
    var $description;
    var $date;
    var $restaurant_id;
    var $tablename="admin_offer";
    var $fields=array('title','offer_image','discount','recipe_id','status','description','date','restaurant_id');

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


    public function list_offer($page_no,$records_per_page,$searchkey="",$status=""){
        $offer_count=$this->db->select('count(*) as cnt')->from('admin_offer')->where('restaurant_id',$_SESSION['user_id'])->get()->row_array();
      
        if($offer_count['cnt']<=0){
            $this->db->select('o.*,r.name');
            $this->db->from('admin_offer o');
            $this->db->join('recipes r','r.id=o.recipe_id');
            $this->db->where('o.restaurant_id',$_SESSION['user_id']);
            $this->db->order_by("o.id DESC");
            $query = $this->db->get();
            $result = $query->result_array();

            return  array(
                'offer'=>$result,
                'total_count'=>$offer_count['cnt'],
                'total_pages'=>1,
                'page_no'=>1,
                'page_total_text'=>"0 - ".$offer_count['cnt']
            ); 
        }else{
            if($records_per_page=="all"){
                $this->db->select('o.*,r.name');
                $this->db->from('admin_offer o');
                $this->db->join('recipes r','r.id=o.recipe_id');
                $this->db->where('o.restaurant_id',$_SESSION['user_id']);
                $this->db->order_by("o.id DESC");
                if($searchkey!="")
                    $this->db->like('lower(o.title)',strtolower($searchkey));
                $this->db->where('o.restaurant_id',$_SESSION['user_id']);
                $this->db->order_by("o.id DESC");
                if ($status!='') {
                    $this->db->like('o.status',$status);
                $this->db->where('o.restaurant_id',$_SESSION['user_id']);
                $this->db->order_by("o.id DESC");
                }
                $query = $this->db->get();

                $result = $query->result_array();
 
                return  array(
                    'offer'=>$result,
                    'total_count'=>$offer_count['cnt'],
                    'total_pages'=>1,
                    'page_no'=>1,
                    'page_total_text'=>"1 - ".$offer_count['cnt']
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
                $this->db->select('o.*,r.name');
                $this->db->from('admin_offer o');
                $this->db->join('recipes r','r.id=o.recipe_id');
                $this->db->where('o.restaurant_id',$_SESSION['user_id']);
                $this->db->order_by("o.id DESC");
                $this->db->limit($records_per_page,$offset);
                $query = $this->db->get();
               /*  echo $this->db->last_query();
                die;*/
                $result = $query->result_array();
                $total_pages = ceil($offer_count['cnt'] / $records_per_page);

                if($offer_count['cnt']<$records_per_page)
                    $to_page=$offer_count['cnt'];
                else
                    $to_page=$records_per_page;
                return  array(
                    'offer'=>$result,
                    'total_count'=>$offer_count['cnt'],
                    'total_pages'=>$total_pages,
                    'page_no'=>$page_no,
                    'page_total_text'=>($offset+1)." - ".$to_page
                ); 
            }
        }

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

    public function insert_waiting_cus($table,$data){
        return $this->db->insert($table,$data);
    }

    public function query($query)
    {
        return $this->db->query($query)->result_array();
    }
}


    ?>