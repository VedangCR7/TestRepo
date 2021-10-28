<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_model extends My_Model
{
    // Check record already present or not while insert
    public function check_employee_insert($emp_aadhaar_no){
        $this->db->select("*");
        $this->db->from('employee_master');
        $this->db->where('emp_aadhaar_no',$emp_aadhaar_no);
        $query = $this->db->get();
        $row = $query->row_array();
        return  $row;
    }

    // Check record already present or not while update
    public function check_employee_update($emp_name,$emp_aadhaar_no){
        $this->db->select("*");
        $this->db->from('employee_master');
        // $this->db->where('emp_name',$emp_name); 
        $this->db->where('emp_aadhaar_no',$emp_aadhaar_no);        
        $query = $this->db->get();
        $row = $query->row_array();
        return  $row;
    }


    // Add category details
    public function addEmployeeDetails($employeeData){        
        $this->db->insert('employee_master',$employeeData);
        return $this->db->insert_id();
        // echo $this->db->last_query();
    }  

    // Display list
    public function list_all_Employees($page_no,$records_per_page,$searchkey=""){
        $waiting_count=$this->db->select('count(*) as cnt')->from('employee_master')->get()->row_array();
      
        if($waiting_count['cnt']<=0){
            $this->db->select("employee_master.*,DATE_FORMAT(employee_master.updated_at,'%d %M %Y') as upd_date,category_name,kitchen_staff_name,kitchen_staff_incentives");
            $this->db->from('employee_master');  
            $this->db->join('empcategory_master', 'empcategory_master.id = employee_master.category', 'left'); 
            $this->db->join('kitchen_staff_incentives', 'kitchen_staff_incentives.kitchen_staff_id = employee_master.emp_sub_category', 'left');         
            $this->db->order_by("emp_id DESC");
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
                $this->db->select("employee_master.*,DATE_FORMAT(employee_master.updated_at,'%d %M %Y') as upd_date,category_name,kitchen_staff_name,kitchen_staff_incentives");
            	$this->db->from('employee_master');  
                $this->db->join('empcategory_master', 'empcategory_master.id = employee_master.category', 'left');
            	$this->db->join('kitchen_staff_incentives', 'kitchen_staff_incentives.kitchen_staff_id = employee_master.emp_sub_category', 'left');         
                $this->db->order_by("emp_id DESC");
                if($searchkey!="")
                    $this->db->like('lower(emp_name)',strtolower($searchkey));               
                $this->db->order_by("emp_id DESC");
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
                $this->db->select("employee_master.*,DATE_FORMAT(employee_master.updated_at,'%d %M %Y') as upd_date,category_name,kitchen_staff_name,kitchen_staff_incentives");
            	$this->db->from('employee_master');  
                $this->db->join('empcategory_master', 'empcategory_master.id = employee_master.category', 'left');
            	$this->db->join('kitchen_staff_incentives', 'kitchen_staff_incentives.kitchen_staff_id = employee_master.emp_sub_category', 'left'); 
                $this->db->order_by("emp_id DESC");
                // $this->db->limit($records_per_page,$offset);
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
    public function delete_employee_details($employee_id){        
        $this->db->where('emp_id',$employee_id);
        $this->db->delete('employee_master');
    }

    // Update employee details
    public function editEmployeeDetails($editemployeeData,$empid){  
        // print_r($empid); die();
        $this->db->where('emp_id',$empid);
        $this->db->update('employee_master',$editemployeeData);
        // echo $this->db->last_query();        
        return true;       
    }

    // Individual employee Details
    public function select_employee($id){
        $this->db->select("employee_master.*,DATE_FORMAT(employee_master.updated_at,'%d %M %Y') as upd_date,category_name,kitchen_staff_id");
        $this->db->from('employee_master');  
        $this->db->join('empcategory_master', 'empcategory_master.id = employee_master.category', 'left');
        $this->db->join('kitchen_staff_incentives', 'kitchen_staff_incentives.kitchen_staff_id = employee_master.emp_sub_category', 'left');
        $this->db->where('emp_id',$id);
        $query = $this->db->get();        
        $row = $query->row_array();       
        return  $row;
    }

    // Show Category list in Dropdown
    public function select_category(){
        $this->db->select("*");
        $this->db->from('empcategory_master');          
        $query = $this->db->get();
        return $query->result();
        
    }

    // Show sub category list
    public function select_sub_category($master_category_id){
        $this->db->select("kitchen_staff_id,kitchen_staff_name,kitchen_staff_incentives");
        $this->db->from('kitchen_staff_incentives');
        $this->db->where('kitchen_staff_incentives.kitchen_category_id', $master_category_id);
        $this->db->order_by("kitchen_staff_incentives.kitchen_staff_name ASC");
        $query = $this->db->get();
        $result = $query->result_array();
        return  $result;      
    }
}
?>