<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Emp_Category_model extends My_Model
{
    // Check record already present or not while insert
    public function check_category($MainCategoryid,$Categoryname){      
        $this->db->select("*");
        $this->db->from('empcategory_master');
        $this->db->where('maincategory_id	',$MainCategoryid);
        $query = $this->db->get();
        $row = $query->row_array();
        return  $row;
    }

    // Check record already present or not while update
    public function check_category_update($Categoryname,$main_category){
        $this->db->select("*");
        $this->db->from('empcategory_master');
        $this->db->where('category_name	',$Categoryname);
        $this->db->where('maincategory_id	',$main_category);       
        $query = $this->db->get();
        $row = $query->row_array();
        return  $row;
    }
    public function check_maincategory_update($main_category_id){
        $this->db->select("*");
        $this->db->from('empcategory_master');
        $this->db->where('maincategory_id	',$main_category_id);       
        $query = $this->db->get();
        $row = $query->row_array();
        return  $row;
    } 
    public function check_subcategory_update($Categoryname){
        $this->db->select("*");
        $this->db->from('empcategory_master');
        $this->db->where('category_name	',$Categoryname);       
        $query = $this->db->get();
        $row = $query->row_array();
        return  $row;
    }

    // Add category details
    public function addCategoryDetails($categoryData){        
        $this->db->insert('empcategory_master',$categoryData);
        return $this->db->insert_id();
        // echo $this->db->last_query();
    }  

    // Display list --new changes
    public function list_all_category($page_no,$records_per_page,$searchkey=""){
        $waiting_count=$this->db->select('count(*) as cnt')->from('empcategory_master')->get()->row_array();
      
       
        if($waiting_count['cnt']<=0){
            $this->db->select("empcategory_master.*,DATE_FORMAT(updated_at,'%d %M %Y') as upd_date,category_master.cat_id,category_master.user_category_name");
            $this->db->from('empcategory_master'); 
            $this->db->join('category_master','category_master.cat_id = empcategory_master.maincategory_id','left');         
            $this->db->order_by("empcategory_master.category_name DESC");
            $query = $this->db->get();
            $result = $query->result_array();

            return  array(
                'manager'=>$result,
                'total_count'=>$waiting_count['cnt'],
                'total_pages'=>1,
                'page_no'=>1,
                'page_total_text'=>"0 - ".$waiting_count['cnt']
            ); 
        }else{
            if($records_per_page=="all"){
                $this->db->select("empcategory_master.*,DATE_FORMAT(updated_at,'%d %M %Y') as upd_date,category_master.cat_id,category_master.user_category_name");
            	$this->db->from('empcategory_master');            	
            	$this->db->join('category_master','category_master.cat_id = empcategory_master.maincategory_id','left'); 
                if($searchkey!="")
                    $this->db->like('lower(category_name)',strtolower($searchkey));               
                $this->db->order_by("empcategory_master.category_name DESC");
                $query = $this->db->get();
                $result = $query->result_array();
 
                return  array(
                    'manager'=>$result,
                    'total_count'=>$waiting_count['cnt'],
                    'total_pages'=>1,
                    'page_no'=>1,
                    'page_total_text'=>"1 - ".$waiting_count['cnt']
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
                $this->db->select("empcategory_master.*,DATE_FORMAT(updated_at,'%d %M %Y') as upd_date,category_master.cat_id,category_master.user_category_name");
            	$this->db->from('empcategory_master');  
                $this->db->join('category_master','category_master.cat_id = empcategory_master.maincategory_id','left');           	
            	$this->db->order_by("empcategory_master.category_name DESC");
                $this->db->limit($records_per_page,$offset);
                $query = $this->db->get();
                // echo $this->db->last_query();
                // die;
                $result = $query->result_array();
                $total_pages = ceil($waiting_count['cnt'] / $records_per_page);

                if($waiting_count['cnt']<$records_per_page)
                    $to_page=$waiting_count['cnt'];
                else
                    $to_page=$records_per_page;
                return  array(
                    'manager'=>$result,
                    'total_count'=>$waiting_count['cnt'],
                    'total_pages'=>$total_pages,
                    'page_no'=>$page_no,
                    'page_total_text'=>($offset+1)." - ".$to_page
                ); 
            }
        }

    }

    // Delete Details
    public function delete_category($category_id){

        $this->db->where('id',$category_id);
        $this->db->delete('empcategory_master');
    }

    // Update details
    public function editCategoryDetails($categoryData,$catid){  
        $this->db->where('id',$catid);
        $this->db->update('empcategory_master',$categoryData);
        return true;       
    }

    public function select_category(){
        $this->db->select("*");
        $this->db->from('category_master'); 
        $this->db->order_by("category_master.user_category_name ASC");        
        $query = $this->db->get();
        return $query->result();    
    }

}
?>