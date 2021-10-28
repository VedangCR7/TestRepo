<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Incentive_report_model extends My_Model
{    
    // Show Category list in Dropdown
    public function select_category(){
        $this->db->select("*");
        $this->db->from('empcategory_master');          
        $query = $this->db->get();
        return $query->result();        
    }

    // Get employee details
    public function list_all_Employees($page_no,$records_per_page,$master_category_id,$searchkey){ 
        //   please declare parameters $from_date and $to_date in function
        $waiting_count=$this->db->select('count(*) as cnt')->from('employee_master')->where('category',$master_category_id)->get()->row_array();     
        if($waiting_count['cnt']<=0){           
            $this->db->select("emp_name,emp_id");
            $this->db->from('employee_master');              
            $this->db->where('category',$master_category_id);
            // $this->db->where('i.created_at>=',$from_date);
            // $this->db->where('i.created_at<=',$to_date);
            $this->db->order_by("emp_name DESC");
            $query = $this->db->get();
            $result = $query->result_array();

            return  array(
                'employee'=>$result,
                'total_count'=>$waiting_count['cnt'],
                'total_pages'=>1,
                'page_no'=>1,
                'page_total_text'=>"0 - ".$waiting_count['cnt']
            ); 
        }else{
            
            if($records_per_page=="all"){               
                $this->db->select("emp_name,emp_id");
            	$this->db->from('employee_master'); 
                $this->db->where('category',$master_category_id);
                // $this->db->where('i.created_at>=',$from_date);
            // $this->db->where('i.created_at<=',$to_date);
                if($searchkey!="")
                    $this->db->like('lower(emp_name)',strtolower($searchkey));               
                $this->db->order_by("emp_name DESC");
                $query = $this->db->get();                
                $result = $query->result_array(); 
                return  array(
                    'employee'=>$result,
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
                $this->db->select("emp_name,emp_id");
            	$this->db->from('employee_master');                  
                $this->db->where('category',$master_category_id);
                // $this->db->where('i.created_at>=',$from_date);
            // $this->db->where('i.created_at<=',$to_date);
                $this->db->order_by("emp_name DESC");             
                $query = $this->db->get();               
                $result = $query->result_array();
                $total_pages = ceil($waiting_count['cnt'] / $records_per_page);

                if($waiting_count['cnt']<$records_per_page)
                    $to_page=$waiting_count['cnt'];
                else
                    $to_page=$records_per_page;
                return  array(
                    'employee'=>$result,
                    'total_count'=>$waiting_count['cnt'],
                    'total_pages'=>$total_pages,
                    'page_no'=>$page_no,
                    'page_total_text'=>($offset+1)." - ".$to_page
                ); 
            }
        }

    }  
}
?>