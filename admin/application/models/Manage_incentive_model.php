<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manage_incentive_model extends My_Model
{
    // Show Category list in Dropdown
    public function select_category(){
        $this->db->select("id,category_name");
        $this->db->from('empcategory_master');  
        $this->db->where('empcategory_master.is_active', 1); 
        $this->db->order_by("empcategory_master.category_name ASC");        
        $query = $this->db->get();
        return $query->result();        
    }
    
    // Add Incentive details
    public function addIncentiveDetails($incentiveData){    
        // echo "In Insert method"; 
        $this->db->insert('incentive_master',$incentiveData);
        return $this->db->insert_id();
            
    } 

    // Save & Update incentive details
    public function updateIncentiveDetails($incentiveData,$menuid,$incentive_id,$categ_id){ 
        $this->db->where('incentive_id',$incentive_id);
        $this->db->where('menu_id',$menuid);
        $this->db->where('category_id',$categ_id);
        $this->db->update('incentive_master',$incentiveData);
        // echo $this->db->last_query();
        // die();
        return true;
    }

    // Display Menu list in Table
    public function list_all_menu($page_no,$records_per_page,$user_category_id=NULL,$searchkey=NULL){    
        $this->db->select('maincategory_id');
        $this->db->from('empcategory_master');  
        $this->db->where('id', $user_category_id);  
        $query=$this->db->get();
        $category_id_result=$query->result_array();
        $category_id = $category_id_result[0]['maincategory_id'];
       
        $this->db->select('user_category_name,cat_id');
        $this->db->from('category_master');  
        $this->db->where('cat_id', $category_id);  
        $query=$this->db->get();
        $category_master_category_name = $query->result_array();        
        $master_category_name = $category_master_category_name[0]['user_category_name'];      
        $master_category_id = $category_master_category_name[0]['cat_id'];        
   
        if(strtolower($master_category_name) == strtolower('Captain')){
            $waiting_count=$this->db->select('count(*) as cnt')->from('recipes')->JOIN('menu_group','menu_group.id = recipes.group_id','left')->where('recipes.is_delete', 1)->where('recipes.is_active', 1)->get()->row_array();
            // If record not availablle in Database-Table
            if($waiting_count['cnt']<=0){
                $this->db->select('incentive_master.incentive_id,recipes.id,name,price,menu_group.title,incentive_master.incentives_price,incentive_master.from_range_value,incentive_master.to_range_value');
                $this->db->from('recipes');    
                $this->db->join('menu_group','menu_group.id = recipes.group_id','left');   
                $this->db->join('incentive_master','incentive_master.menu_id = recipes.id','left');
                $this->db->where('recipes.is_delete', 1);
                $this->db->where('recipes.is_active', 1); 
                if($category_id){
                    $this->db->where('incentive_master.category_id', $category_id);
                }          
                $this->db->order_by("recipes.group_id DESC");
                $query = $this->db->get();           
                $result = $query->result_array();
                if(empty($result)){
                    $this->db->select('recipes.id,name,price,menu_group.title');
                    $this->db->from('recipes');    
                    $this->db->join('menu_group','menu_group.id = recipes.group_id','left');
                    $this->db->where('recipes.is_delete', 1);
                    $this->db->where('recipes.is_active', 1);
                    $this->db->order_by("recipes.is_delete DESC");
                    $query = $this->db->get();  
                    $result = $query->result_array();
                }
                return  array(
                    'manager'=>$result,
                    'master_category_name'=>$master_category_name,
                    'total_count'=>$waiting_count['cnt'],
                    'total_pages'=>1,
                    'page_no'=>1,
                    'page_total_text'=>"0 - ".$waiting_count['cnt']
                ); 
            }
            else{
                // If pagination is 'All'
                if($records_per_page=="all"){ 
                    $this->db->select('incentive_master.incentive_id,recipes.id,name,price,menu_group.title,incentive_master.incentives_price,incentive_master.from_range_value,incentive_master.to_range_value');
                    $this->db->from('recipes');    
                    $this->db->join('menu_group','menu_group.id = recipes.group_id','left');   
                    $this->db->join('incentive_master','incentive_master.menu_id = recipes.id','left');
                    $this->db->where('recipes.is_delete', 1);
                    $this->db->where('recipes.is_active', 1);
                    if($category_id){
                        $this->db->where('incentive_master.category_id', $category_id);
                    }
                    if($searchkey!="")                   
                         $this->db->like('lower(name)',strtolower($searchkey));               
                    $this->db->order_by("recipes.group_id DESC");
                    $query = $this->db->get(); 
                    //  echo $this->db->last_query();
                    // die();
                    $result = $query->result_array(); 
                    return  array(
                        'manager'=>$result,
                        'master_category_name'=>$master_category_name,
                        'total_count'=>$waiting_count['cnt'],
                        'total_pages'=>1,
                        'page_no'=>1,
                        'page_total_text'=>"1 - ".$waiting_count['cnt']
                    ); 
                }
            else{                
                // If pagination not set 
                if (!isset($page_no)) {
                    $page_no = 1;
                }
                if (!isset($records_per_page)) {
                    $records_per_page = 30;
                }
                $offset = ($page_no-1) * $records_per_page;              
                $this->db->select('incentive_master.incentive_id,recipes.id,name,price,menu_group.title,incentive_master.incentives_price,incentive_master.from_range_value,incentive_master.to_range_value');
                $this->db->from('recipes');    
                $this->db->join('menu_group','menu_group.id = recipes.group_id','left'); 
                $this->db->join('incentive_master','incentive_master.menu_id = recipes.id','left');                 
                $this->db->where('recipes.is_delete', 1);
                $this->db->where('recipes.is_active', 1); 
                if($category_id){
                    $this->db->where('incentive_master.category_id', $category_id);
                }  
                $this->db->order_by("recipes.is_delete DESC");
                $this->db->limit($records_per_page,$offset);
                $query = $this->db->get();
                $result = $query->result_array();
                if(empty($result)){
                        $this->db->select('recipes.id,name,price,menu_group.title');
                        $this->db->from('recipes');    
                        $this->db->join('menu_group','menu_group.id = recipes.group_id','left');
                        $this->db->where('recipes.is_delete', 1);
                        $this->db->where('recipes.is_active', 1);
                        $this->db->order_by("recipes.is_delete DESC");
                        $this->db->limit($records_per_page,$offset);
                        $query = $this->db->get();  
                        $result = $query->result_array();
                    }
                $total_pages = ceil($waiting_count['cnt'] / $records_per_page);

                if($waiting_count['cnt']<$records_per_page)
                    $to_page=$waiting_count['cnt'];
                else
                    $to_page=$records_per_page;
                return  array(
                    'manager'=>$result,
                    'master_category_name'=>$master_category_name,
                    'total_count'=>$waiting_count['cnt'],
                    'total_pages'=>$total_pages,
                    'page_no'=>$page_no,
                    'page_total_text'=>($offset+1)." - ".$to_page
                ); 
            } 
        }
        
        }else if(strtolower($master_category_name) == strtolower('Waiters')){ 
           $waiter_response = $this->list_all_waiter_incentives($page_no,$records_per_page,$user_category_id,$searchkey); 
           return $waiter_response;
        }else if(strtolower($master_category_name) == strtolower('Kitchen Staff')){ 
            $kitchen_response = $this->list_all_kitchen_incentives($page_no,$records_per_page,$user_category_id,$searchkey);
            return $kitchen_response;
         }
    }
    
    // waiter Table listing
    public function list_all_waiter_incentives($page_no,$records_per_page,$user_category_id,$searchkey){

        $this->db->select('maincategory_id');
        $this->db->from('empcategory_master');  
        $this->db->where('id', $user_category_id);  
        $query=$this->db->get();
        $category_id_result=$query->result_array();
        $category_id = $category_id_result[0]['maincategory_id'];

        $this->db->select('user_category_name,cat_id');
        $this->db->from('category_master');  
        $this->db->where('cat_id', $category_id);  
        $query=$this->db->get();
        $category_master_category_name = $query->result_array();
        // $category_master_category_id=$query->row();
        
        $master_category_name = $category_master_category_name[0]['user_category_name'];      
        $master_category_id = $category_master_category_name[0]['cat_id'];
        // ---------------------------------

            $this->db->select('id');
            $this->db->from('empcategory_master');  
            $this->db->where('maincategory_id', $master_category_id);  
            $query=$this->db->get();
            $emp_catg_id = $query->result_array();            
            $employee_category_id =  $emp_catg_id[0]['id'];
            
            $this->db->select('count(*) as cnt');
            $this->db->from('incentive_master');
            $this->db->where('incentive_master.category_id ', $employee_category_id);
            $query=$this->db->get();
            $waiter_count = $query->row_array(); 
            
            if($waiter_count['cnt']<=0){
                $this->db->select('incentive_master.incentive_id,incentive_master.incentives_price,incentive_master.from_range_value,incentive_master.to_range_value');
                $this->db->from('incentive_master');                 
                if($user_category_id){
                    $this->db->where('incentive_master.category_id', $user_category_id);
                }  
                $query = $this->db->get();           
                $result = $query->result_array();
                // echo "die 1"; 
                return  array(
                    'waiter'=>$result,
                    'master_category_name'=>$master_category_name,
                    'total_count'=>$waiter_count['cnt'],
                    'total_pages'=>1,
                    'page_no'=>1,
                    'page_total_text'=>"0 - ".$waiter_count['cnt']
                ); 
            }
            else{
                // If pagination is 'All'
                if($records_per_page=="all"){ 
                
                    $this->db->select('incentive_master.incentive_id,incentive_master.incentives_price,incentive_master.from_range_value,incentive_master.to_range_value');
                    $this->db->from('incentive_master');                     
                    if($user_category_id){
                        $this->db->where('incentive_master.category_id', $user_category_id);
                    } 
                    if($searchkey!="")
                        $this->db->like('incentive_master.from_range_value',$searchkey);               
                    
                    $query = $this->db->get(); 
                    //  echo $this->db->last_query();
                    // die();  
                    $result = $query->result_array();                              
                    return  array(
                        'waiter'=>$result,
                        'master_category_name'=>$master_category_name,
                        'total_count'=>$waiter_count['cnt'],
                        'total_pages'=>1,
                        'page_no'=>1,
                        'page_total_text'=>"1 - ".$waiter_count['cnt']
                    ); 
                }
                else{
                    // If pagination not set 
                    if (!isset($page_no)) {
                        $page_no = 1;
                    }
                    if (!isset($records_per_page)) {
                        $records_per_page = 30;
                    }
                    $offset = ($page_no-1) * $records_per_page;              
                    $this->db->select('incentive_master.incentive_id,incentive_master.incentives_price,incentive_master.from_range_value,incentive_master.to_range_value');
                    $this->db->from('incentive_master');                         
                    if($user_category_id){
                        $this->db->where('incentive_master.category_id', $user_category_id);
                    }                      
                    $this->db->limit($records_per_page,$offset);
                    $query = $this->db->get(); 
                    $result = $query->result_array();
                    $total_pages = ceil($waiter_count['cnt'] / $records_per_page);
                    if($waiter_count['cnt']<$records_per_page)
                        $to_page=$waiter_count['cnt'];
                    else
                        $to_page=$records_per_page;
                    return  array(
                        'waiter'=>$result,
                        'master_category_name'=>$master_category_name,
                        'total_count'=>$waiter_count['cnt'],
                        'total_pages'=>$total_pages,
                        'page_no'=>$page_no,
                        'page_total_text'=>($offset+1)." - ".$to_page
                    ); 
                } 
            }
    }

    // kitchen Staff table listing
    public function list_all_kitchen_incentives($page_no,$records_per_page,$user_category_id,$searchkey){
        
        $this->db->select('maincategory_id');
        $this->db->from('empcategory_master');  
        $this->db->where('id', $user_category_id);  
        $query=$this->db->get();
        $category_id_result=$query->result_array();
        $category_id = $category_id_result[0]['maincategory_id'];
       
        $this->db->select('user_category_name,cat_id');
        $this->db->from('category_master');  
        $this->db->where('cat_id', $category_id);  
        $query=$this->db->get();
        $category_master_category_name = $query->result_array();
        
        $master_category_name = $category_master_category_name[0]['user_category_name'];      
        $master_category_id = $category_master_category_name[0]['cat_id'];
        // ---------------------------------

            $this->db->select('id');
            $this->db->from('empcategory_master');  
            $this->db->where('maincategory_id', $master_category_id);  
            $query=$this->db->get();
            $emp_catg_id = $query->result_array();            
            $employee_category_id =  $emp_catg_id[0]['id'];
         
            $this->db->select('count(*) as cnt');
            $this->db->from('kitchen_staff_incentives');
            $this->db->where('kitchen_staff_incentives.kitchen_category_id ', $employee_category_id);
            $query=$this->db->get();
            $kitchen_count = $query->row_array();
           
       
        if($kitchen_count['cnt']<=0){
            $this->db->select("kitchen_staff_id,kitchen_staff_name,kitchen_staff_incentives");
            $this->db->from('kitchen_staff_incentives');      
            if($user_category_id){
                $this->db->where('kitchen_staff_incentives.kitchen_category_id', $user_category_id);
            }                
            $this->db->order_by("kitchen_staff_incentives.kitchen_staff_name ASC");          
            $query = $this->db->get();
            $result = $query->result_array();
            // print_r($result);
            // die();
            return  array(
                'kitchen_staff'=>$result,
                'master_category_name'=>$master_category_name,
                'total_count'=>$kitchen_count['cnt'],
                'total_pages'=>1,
                'page_no'=>1,
                'page_total_text'=>"0 - ".$kitchen_count['cnt']
            ); 
        }else{
            if($records_per_page=="all"){
                $this->db->select("kitchen_staff_id,kitchen_staff_name,kitchen_staff_incentives");
                $this->db->from('kitchen_staff_incentives');      
                if($user_category_id){
                    $this->db->where('kitchen_staff_incentives.kitchen_category_id', $user_category_id);
                }         	            	 
                if($searchkey!="")
                $this->db->like('lower(kitchen_staff_name)',strtolower($searchkey));               
                $this->db->order_by("kitchen_staff_incentives.kitchen_staff_name ASC");
                $query = $this->db->get();
                $result = $query->result_array();
 
                return  array(
                    'kitchen_staff'=>$result,
                    'master_category_name'=>$master_category_name,
                    'total_count'=>$kitchen_count['cnt'],
                    'total_pages'=>1,
                    'page_no'=>1,
                    'page_total_text'=>"1 - ".$kitchen_count['cnt']
                ); 
            }else{

                if (!isset($page_no)) {
                    $page_no = 1;
                }

                if (!isset($records_per_page)) {
                    $records_per_page = 30;
                }

                $offset = ($page_no-1) * $records_per_page;

                $this->db->select("kitchen_staff_id,kitchen_staff_name,kitchen_staff_incentives");
                $this->db->from('kitchen_staff_incentives');      
                if($user_category_id){
                    $this->db->where('kitchen_staff_incentives.kitchen_category_id', $user_category_id);
                }                
                $this->db->order_by("kitchen_staff_incentives.kitchen_staff_name ASC");
                $this->db->limit($records_per_page,$offset);
                $query = $this->db->get();    
                // echo $this->db->last_query();
                // die();         
                $result = $query->result_array();
                $total_pages = ceil($kitchen_count['cnt'] / $records_per_page);

                if($kitchen_count['cnt']<$records_per_page)
                    $to_page=$kitchen_count['cnt'];
                else
                    $to_page=$records_per_page;
                return  array(
                    'kitchen_staff'=>$result,
                    'master_category_name'=>$master_category_name,
                    'total_count'=>$kitchen_count['cnt'],
                    'total_pages'=>$total_pages,
                    'page_no'=>$page_no,
                    'page_total_text'=>($offset+1)." - ".$to_page
                ); 
            }
        }        
    }

    public function check_add_range_incentives($from_range,$to_range,$waiter_incentives){
        $this->db->select("*");
        $this->db->from('incentive_master');
        $this->db->where('from_range_value',$from_range);  
        $this->db->where('to_range_value',$to_range);       
        $this->db->where('incentives_price',$waiter_incentives);       
        $query = $this->db->get();
        $row = $query->row_array();
        return  $row;
    }

    public function check_for_range_incentives($from_range,$to_range,$incentive_price){
        $this->db->select("*");
        $this->db->from('incentive_master');
        $this->db->where('from_range_value',$from_range);  
        $this->db->where('to_range_value',$to_range);       
        $this->db->where('incentives_price !=',$incentive_price);       
        $query = $this->db->get();
        $row = $query->row_array();
        return  $row;
    }

    public function editIncentivesDetails($editincentivesData,$incentive_id){
        $this->db->where('incentive_id',$incentive_id);
        $this->db->update('incentive_master',$editincentivesData);
        return true;
    }
    
    // Add kitchen Incentive details
    public function saveKitchenIncentiveDetails($incentiveData){   
        $this->db->insert('kitchen_staff_incentives',$incentiveData);
        return $this->db->insert_id();
    } 

    // For update Kitchen Staff check incentives
    public function check_kitchen_staff_incentives($staff_mode,$staff_percentage){
        $this->db->select("*");
        $this->db->from('kitchen_staff_incentives');
        $this->db->where('kitchen_staff_name',$staff_mode);   
        $this->db->where('kitchen_staff_incentives !=',$staff_percentage);       
        $query = $this->db->get();
        $row = $query->row_array();
        return  $row;
    }
    
    // for insert waiter check range
    public function verify_range_incentives($from_range,$to_range){
        $this->db->select("*");
        $this->db->from('incentive_master');
        $this->db->where('from_range_value',$from_range);  
        $this->db->where('to_range_value',$to_range);       
        $query = $this->db->get();
        $row = $query->row_array();
        return  $row;
    }

    // Check Kitchen staff incentives already present or not 
    public function verify_kitchen_staff_incentives($kitchen_staff_name){
        $this->db->select("*");
        $this->db->from('kitchen_staff_incentives');
        $this->db->where('kitchen_staff_name',$kitchen_staff_name);      
        $query = $this->db->get();
        $row = $query->row_array();
        return  $row;
    }

    // Update kitchen details
    public function editKitchenStafIncentives_Details($editincentivesData,$incentive_id){
        $this->db->where('kitchen_staff_id',$incentive_id);
        $this->db->update('kitchen_staff_incentives',$editincentivesData);
        return true;
    }

    // Delete Incentives
    public function delete_incentives_details($incentives_id){
        $this->db->where('incentive_id',$incentives_id);
        $this->db->delete('incentive_master');
    }

    // Delete kitchen staff Incentives
    public function delete_kitchen_staff_incentives_details($incentives_id){
        $this->db->where('kitchen_staff_id',$incentives_id);
        $this->db->delete('kitchen_staff_incentives');
    }
    
}
?>