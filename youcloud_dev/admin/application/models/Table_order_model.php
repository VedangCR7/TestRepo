<?php
class Table_order_model extends My_Model {
    var $table_orderno;
    var $table_id;
    var $flag;
    var $insert_date;
    var $insert_time;
    var $restaurant_id;
    var $invoice_ids;
    var $order_type;
    var $tablename="table_orders";
    var $fields=array('table_orderno','table_id','flag','insert_date','insert_time','restaurant_id','invoice_ids','order_type');
    public function __construct()
    {
    	$this->load->database();
    }

    public function get_table_order($flag,$table_id,$date){
        $this->db->select('*');
        $this->db->from('table_orders');
        $this->db->where('flag',$flag);
        $this->db->where('table_id',$table_id);
        $this->db->where('insert_date',$date);
        $query = $this->db->get();
        $row = $query->row_array();
        return $row; 
    }

    public function get_current_tableorder($flag,$table_id,$date)
	{
        $this->db->select('*');
        $this->db->from('table_orders');
        $this->db->where('flag',$flag);
        $this->db->where('table_id',$table_id);
        $this->db->where('insert_date',$date);
        $query = $this->db->get();
        $table_order = $query->row_array();

        if(!empty($table_order))
		{
            $this->db->select("o.*,DATE_FORMAT(created_at,'%d/%m/%Y %h:%i %p') as order_date,t.title as table_no,TIMEDIFF(DATE_FORMAT(CURRENT_TIMESTAMP, '%H:%I:%S'), DATE_FORMAT(o.created_at, '%H:%I:%S')) as in_time,DATE_FORMAT(CURRENT_TIMESTAMP, '%H:%I:%S') as currenttime,DATE_FORMAT(o.created_at, '%H:%I:%S') as created_at_time");
            $this->db->from('orders as o');
            $this->db->join('table_details t','t.id=o.table_id','left');
            $this->db->where('o.table_orders_id',$table_order['id']);
            $this->db->group_by('o.table_orders_id');
            $this->db->order_by('o.id','desc');
            $this->db->limit(1);
            $query = $this->db->get();
            //echo $this->db->last_query();
            $result = $query->row_array();

            $table_order['order']=$result;
        }

        return $table_order;
    }

    public function get_tableorder_for_invoice($ids){
        $this->db->select("o.*,DATE_FORMAT(created_at,'%d/%m/%Y %h:%i %p') as order_date,t.title as table_no,c.name as customer_name,c.contact_no,SUM(o.sub_total) as sub_total,SUM(o.disc_total) as disc_total,SUM(o.net_total) as net_total,SUM(o.cgst_per) as cgst_per,SUM(o.sgst_per) as sgst_per,u.name as restaurant_name,SUM(o.disc_percentage_total) as disc_percentage_total,o.dis_total_percentage,SUM(o.no_of_person) as no_of_person_sum");
        $this->db->from('orders as o');
        $this->db->join('customer c','c.id=o.customer_id');
        $this->db->join('table_details t','t.id=o.table_id','left');
        $this->db->join('user u','u.id=o.rest_id','left');
        $this->db->where_in('o.id',$ids);
        $this->db->group_by('o.table_orders_id');
        $query = $this->db->get();
        $result = $query->row_array();

        $this->db->select("oi.*,r.name as recipe_name
            ,SUM(oi.sub_total) as sub_total,SUM(oi.disc) as disc,SUM(oi.disc_amt) as disc_amt,SUM(oi.total) as total,SUM(oi.qty) as qty");
        $this->db->from('order_items as oi');
        $this->db->join('recipes r','r.id=oi.recipe_id');
        $this->db->where_in('oi.order_id',$ids);
        $this->db->group_by('oi.recipe_id');
        $query = $this->db->get();
        $result['items']= $query->result_array();
        return $result;
    }


    public function get_tableorder_details($id){
        $this->db->select('o.*,t.title as table_no');
        $this->db->from('table_orders o');
        $this->db->join('table_details t','t.id=o.table_id');
        $this->db->where('o.id',$id);
        $query = $this->db->get();
        $row = $query->row_array();
        return $row; 
    }

    public function get_tableorder($ids){
        $this->db->select("o.*,DATE_FORMAT(created_at,'%d/%m/%Y %h:%i %p') as order_date,t.title as table_no,c.name as customer_name,c.contact_no,SUM(o.sub_total) as sub_total,SUM(o.disc_total) as disc_total,SUM(o.net_total) as net_total,u.name as restaurant_name");
        $this->db->from('orders as o');
        $this->db->join('customer c','c.id=o.customer_id');
        $this->db->join('table_details t','t.id=o.table_id','left');
        $this->db->join('user u','u.id=o.rest_id','left');
        $this->db->where_in('o.id',$ids);
        $this->db->group_by('o.table_orders_id');
        $query = $this->db->get();
        $result = $query->row_array();

        $this->db->select("oi.*,r.name as recipe_name");
        $this->db->from('order_items as oi');
        $this->db->join('recipes r','r.id=oi.recipe_id');
        $this->db->where_in('oi.order_id',$ids);
        $query = $this->db->get();
        $result['items']= $query->result_array();
        return $result;
    }

    public function update_invoice_ids($id,$invoice_id){
        $this->db->select('o.*');
        $this->db->from('table_orders o');
        $this->db->where('o.id',$id);
        $query = $this->db->get();
        $row = $query->row_array();

        $invoice_ids=$row['invoice_ids'];
        if($invoice_ids!=""){
            $invoice_ids= $invoice_ids.",".$invoice_id;
        }else{
            $invoice_ids=$invoice_id;
        }
        $this->db->where('id',$id);
        $this->db->update('table_orders',array('invoice_ids'=>$invoice_ids));

        $this->update_table_available($id,$row['table_id']);
      
    }

    public function update_table_available($id,$table_id){

        $this->db->select("o.*");
        $this->db->from('orders as o');
        $this->db->where('o.table_orders_id',$id);
        $this->db->where('o.is_invoiced',0);
        $this->db->where('o.status!=','Canceled');
        
        $query = $this->db->get();
        $orders = $query->result_array();

        if(empty($orders))
		{
            $this->db->select("i.*");
            $this->db->from('invoices as i');
            $this->db->where('i.table_order_id',$id);
            $this->db->where('i.status','Unpaid');
            $query = $this->db->get();
            $invoices = $query->result_array();
            
			if(empty($invoices))
			{
				$this->db->trans_start();
                $this->db->where('id',$table_id);
                $this->db->update('table_details',array('is_available'=>1));
				/* echo $this->db->last_query();echo '<br>'; */
                
				//$this->db->where('table_orders_id',$id);
                // $this->db->update('orders',array('status'=>'Completed'));
				/* echo $this->db->last_query();echo '<br>'; */
               
				$this->db->where('id',$id);
                $this->db->update('table_orders',array('flag'=>'Y'));
                /* echo $this->db->last_query();echo '<br>';exit; */
				$this->db->trans_complete();
            }
        }
    }

    public function update_invoice_ids1($id,$invoice_id){
        $this->db->select('o.*');
        $this->db->from('table_orders o');
        $this->db->where('o.id',$id);
        $query = $this->db->get();
        $row = $query->row_array();

        $invoice_ids=$row['invoice_ids'];
        if($invoice_ids!=""){
            $invoice_ids= $invoice_ids.",".$invoice_id;
        }else{
            $invoice_ids=$invoice_id;
        }
        $this->db->where('id',$id);
        $this->db->update('table_orders',array('invoice_ids'=>$invoice_ids));


        $this->db->select("o.*");
        $this->db->from('orders as o');
        $this->db->where('o.table_orders_id',$id);
        $this->db->where('o.is_invoiced',0);
        $query = $this->db->get();
        $orders = $query->result_array();
    }
}
?>
