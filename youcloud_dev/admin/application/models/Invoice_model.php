<?php
class Invoice_model extends My_Model {
    var $invoice_no;
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
    var $table_order_id;
    var $cash_payment;
    var $card_payment;
    var $upi_payment;
    var $net_banking;
    var $sgst_total;
    var $cgst_total;
    var $tablename="invoices";
    var $fields=array('invoice_no','customer_id','table_id','rest_id','loyalty_points','sub_total','disc_total','net_total','suggetion','status','created_at','table_order_id','cash_payment','card_payment','upi_payment','net_banking','sgst_total','cgst_total','disc_percentage_total','dis_total_percentage');
    public function __construct()
    {
    	$this->load->database();
        $this->load->model('invoice_item_model');
    }

    public function get_invoice_details($invoice_id)
	{
        $this->db->select("i.*,DATE_FORMAT(i.created_at,'%d/%m/%Y') as invoic_date,t.title as table_no,c.name as customer_name,c.contact_no,u.business_name as rest_name,u.address,u.city,u.country,u.postcode,o.no_of_person,o.supply_option");
        $this->db->from('invoices as i');
        $this->db->join('customer c','c.id=i.customer_id');
        $this->db->join('table_details t','t.id=i.table_id','left');
        $this->db->join('user u','u.id=i.rest_id','left');
        $this->db->join('orders o','o.table_orders_id=i.table_order_id','left');
        $this->db->where('i.id',$invoice_id);
        $query = $this->db->get();
        $result = $query->row_array();
        $result['items']=$this->invoice_item_model->list_invoice_items($invoice_id);
        return $result;
    }
	
    /* kot print */
    public function get_kot_print($order_id)
	{
        $this->db->select("o.*,DATE_FORMAT(o.created_at,'%d/%m/%Y') as invoic_date,t.title as table_no,c.name as customer_name,c.contact_no,u.business_name as rest_name,u.address,u.city,u.country,u.postcode");
        $this->db->from('orders as o');
        $this->db->join('customer c','c.id=o.customer_id');
        $this->db->join('table_details t','t.id=o.table_id','left');
        $this->db->join('user u','u.id=o.rest_id','left');
        $this->db->where('o.id',$order_id);
        $query = $this->db->get();

        $result = $query->row_array();
        $result['items']=$this->invoice_item_model->list_recipe_items($order_id);
        return $result;
    }

    public function list_invoice($page_no,$records_per_page,$from_date,$to_date,$searchkey="")
	{
        $invoice_count=$this->db->select('count(*) as cnt')->from('invoices')->where('rest_id',$_SESSION['user_id'])->get()->row_array();
      
        if($invoice_count['cnt']<=0)
		{
            $this->db->select('i.*,c.name,c.contact_no,t.title,to.order_type');
            $this->db->from('invoices as i');
            $this->db->join('customer AS c', 'c.id = i.customer_id', 'LEFT');
            $this->db->join('table_details AS t', 't.id=i.table_id', 'LEFT');
            $this->db->join('table_orders AS to', 'to.id=i.table_order_id', 'LEFT');
            $this->db->where('i.rest_id',$_SESSION['user_id']);
            $this->db->where('i.created_at>=',$from_date);
            $this->db->where('i.created_at<=',$to_date);
            $this->db->order_by("i.id DESC");
            $query = $this->db->get();
            $result = $query->result_array();

            return  array(
                'manager'=>$result,
                'total_count'=>$invoice_count['cnt'],
                'total_pages'=>1,
                'page_no'=>1,
                'page_total_text'=>"0 - ".$invoice_count['cnt']
            ); 
        }
		else
		{
            if($records_per_page=="all")
			{
                $this->db->select('i.*,c.name,c.contact_no,t.title,to.order_type');
                $this->db->from('invoices as i');
                $this->db->join('customer AS c', 'c.id = i.customer_id', 'LEFT');
                $this->db->join('table_details AS t', 't.id=i.table_id', 'LEFT');
                $this->db->join('table_orders AS to', 'to.id=i.table_order_id', 'LEFT');
                $this->db->where('i.rest_id',$_SESSION['user_id']);
                $this->db->where('i.created_at>=',$from_date);
                $this->db->where('i.created_at<=',$to_date);
                $this->db->order_by("i.id DESC");
                if($searchkey!="")
                    $this->db->like('lower(i.invoice_no)',strtolower($searchkey));
                $this->db->where('i.rest_id',$_SESSION['user_id']);
                $this->db->order_by("i.id DESC");
                $query = $this->db->get();

                $result = $query->result_array();
 
                return  array(
                    'manager'=>$result,
                    'total_count'=>$invoice_count['cnt'],
                    'total_pages'=>1,
                    'page_no'=>1,
                    'page_total_text'=>"1 - ".$invoice_count['cnt']
                ); 
            }
			else
			{
                if (!isset($page_no)) 
				{
                    $page_no = 1;
                }

                if (!isset($records_per_page)) 
				{
                    $records_per_page = 30;
                }

                $offset = ($page_no-1) * $records_per_page;
               /* echo $offset;
                die;*/
                $this->db->select('i.*,c.name,c.contact_no,t.title,to.order_type');
                $this->db->from('invoices as i');
                $this->db->join('customer AS c', 'c.id = i.customer_id', 'LEFT');
                $this->db->join('table_details AS t', 't.id=i.table_id', 'LEFT');
                $this->db->join('table_orders AS to', 'to.id=i.table_order_id', 'LEFT');
                $this->db->where('i.rest_id',$_SESSION['user_id']);
                $this->db->where('i.created_at>=',$from_date);
                $this->db->where('i.created_at<=',$to_date);
                $this->db->order_by("i.id DESC");
                $this->db->limit($records_per_page,$offset);
                $query = $this->db->get();
               /*  echo $this->db->last_query();
                die;*/
                $result = $query->result_array();
                $total_pages = ceil($invoice_count['cnt'] / $records_per_page);

                if($invoice_count['cnt']<$records_per_page*$page_no)
                    $to_page=$invoice_count['cnt'];
                else
                    $to_page=$records_per_page*$page_no;
					
                return  array(
                    'manager'=>$result,
                    'total_count'=>$invoice_count['cnt'],
                    'total_pages'=>$total_pages,
                    'page_no'=>$page_no,
                    'page_total_text'=>($offset+1)." - ".$to_page
                ); 
            }
        }
    }


    public function list_report_invoice($page_no,$records_per_page,$customer_id,$status,$searchkey=""){
        $invoice_count=$this->db->select('count(*) as cnt')->from('invoices')->where('rest_id',$_SESSION['user_id'])->where('customer_id',$customer_id)->get()->row_array();
      
        if($invoice_count['cnt']<=0){
             $this->db->select('i.*,c.name,c.contact_no,t.title');
            $this->db->from('invoices as i');
            $this->db->join('customer AS c', 'c.id = i.customer_id', 'LEFT');
            $this->db->join('table_details AS t', 't.id=i.table_id', 'LEFT');
            $this->db->where('i.rest_id',$_SESSION['user_id']);
            $this->db->where('i.customer_id',$customer_id);
            if($status!="")
                $this->db->where('i.status',$status);
            $this->db->order_by("i.id DESC");
            
            $query = $this->db->get();
            
            $result = $query->result_array();

            return  array(
                'manager'=>$result,
                'total_count'=>$invoice_count['cnt'],
                'total_pages'=>1,
                'page_no'=>1,
                'page_total_text'=>"0 - ".$invoice_count['cnt']
            ); 
        }else{
            if($records_per_page=="all"){
                $this->db->select('i.*,c.name,c.contact_no,t.title');
                $this->db->from('invoices as i');
                $this->db->join('customer AS c', 'c.id = i.customer_id', 'LEFT');
                $this->db->join('table_details AS t', 't.id=i.table_id', 'LEFT');
                $this->db->where('i.rest_id',$_SESSION['user_id']);
                $this->db->where('i.customer_id',$customer_id);
                if($status!="")
                    $this->db->where('i.status',$status);
                $this->db->order_by("i.id DESC");
                if($searchkey!="")
                    $this->db->like('lower(i.invoice_no)',strtolower($searchkey));
                $this->db->where('i.rest_id',$_SESSION['user_id']);
                $this->db->where('i.customer_id',$customer_id);
                if($status!="")
                     $this->db->where('i.status',$status);
                $this->db->order_by("i.id DESC");
                $query = $this->db->get();

                $result = $query->result_array();
 
                return  array(
                    'manager'=>$result,
                    'total_count'=>$invoice_count['cnt'],
                    'total_pages'=>1,
                    'page_no'=>1,
                    'page_total_text'=>"1 - ".$invoice_count['cnt']
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
                $this->db->select('i.*,c.name,c.contact_no,t.title');
                $this->db->from('invoices as i');
                $this->db->join('customer AS c', 'c.id = i.customer_id', 'LEFT');
                $this->db->join('table_details AS t', 't.id=i.table_id', 'LEFT');
                $this->db->where('i.rest_id',$_SESSION['user_id']);
                $this->db->where('i.customer_id',$customer_id);
                if($status!="")
                    $this->db->where('i.status',$status);
                $this->db->order_by("i.id DESC");
                $this->db->limit($records_per_page,$offset);
                $query = $this->db->get();
               /*  echo $this->db->last_query();
                die;*/
                $result = $query->result_array();
                $total_pages = ceil($invoice_count['cnt'] / $records_per_page);

                if($invoice_count['cnt']<$records_per_page)
                    $to_page=$invoice_count['cnt'];
                else
                    $to_page=$records_per_page;
                return  array(
                    'manager'=>$result,
                    'total_count'=>$invoice_count['cnt'],
                    'total_pages'=>$total_pages,
                    'page_no'=>$page_no,
                    'page_total_text'=>($offset+1)." - ".$to_page
                ); 
            }
        }

    }






}
?>