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
    var $invoice_id;
    var $cgst_per;
    var $sgst_per;
    var $supply_option;
	var $delivery_payment;
    var $customer_address_id;
    var $cancel_note;
    var $no_of_person;
	var $discount_note;
    var $tablename="orders";
    var $fields=array('order_no','customer_id','table_id','rest_id','loyalty_points','sub_total','disc_total','net_total','suggetion','status','created_at','table_orders_id','is_invoiced','order_by','invoice_id','cgst_per','sgst_per','dis_total_percentage','disc_percentage_total','supply_option','delivery_payment','customer_address_id','no_of_person','cancel_note','discount_note');
    public function __construct()
    {
    	$this->load->database();
        $this->load->model('order_item_model');
    }

    public function total_order_count($rest_id,$status="")
    {
        $this->db->select('COUNT(o.id) as recipe_count');
        $this->db->from('orders as o');
        $this->db->join('table_orders to','to.id=o.table_orders_id');
        $this->db->where('o.rest_id',$rest_id);
        $this->db->where('to.order_type!=','Website');
        if($status!="")
            $this->db->where('status',$status);
        $query = $this->db->get();
        $row = $query->row_array();

        return $row['recipe_count']; 
    }

    public function get_order_details($order_id)
	{
        $this->db->select("o.*,DATE_FORMAT(created_at,'%d/%m/%Y %h:%i %p') as order_date,t.title as table_no,c.name as customer_name,c.contact_no,ot.order_type");
        $this->db->from('orders as o');
        $this->db->join('customer c','c.id=o.customer_id');
        $this->db->join('table_details t','t.id=o.table_id','left');
		$this->db->join('table_orders ot','ot.id=o.table_orders_id','left');
        $this->db->where('o.id',$order_id);
        $query = $this->db->get();
        $result = $query->row_array();
        $result['items']=$this->order_item_model->list_order_items($order_id);
		$invoice_id = $result['invoice_id'];
		
        if($result['invoice_id']!="")
		{
            $this->db->select("i.*,DATE_FORMAT(i.created_at,'%d/%m/%Y') as invoic_date");
            $this->db->from('invoices as i');
            $this->db->where_in('i.id',$invoice_id);
            $query = $this->db->get();
            $invoice = $query->row_array();

            $result['invoice']=$invoice;
        }
		else
		{
            $result['invoice']=array();
        }
            
        return $result;
    }


    public function all_orders($page_no,$records_per_page,$status,$order_date="",$search_name="")
	{
        //$this->db->where('r.logged_user_id',$user_id);
            
        $this->db->select('count(o.id) as cnt');
        $this->db->from('orders o');
        $this->db->join('customer c','c.id=o.customer_id');
        $this->db->join('table_orders to','to.id=o.table_orders_id');
        
		if($search_name!="")
		{
            $this->db->like('LOWER(o.order_no)',strtolower($search_name));
            $this->db->or_like('LOWER(c.name)',strtolower($search_name));
        }
        
		if($status!="")
                $this->db->where('o.status',$status);
        
		if($order_date!="")
            $this->db->where('DATE_FORMAT(created_at,"%Y-%m-%d")',$order_date);
        
		$this->db->where('o.rest_id',$_SESSION['user_id']);
        $this->db->where('to.order_type!=','Website');
        $query=$this->db->get();
        $recipes_count=$query->row_array();

        if($records_per_page=="all")
		{
            $this->db->select("o.id as ordID,o.order_no,o.*,DATE_FORMAT(created_at,'%d %b %Y %h:%i %p') as order_date,t.title as table_no,c.name as customer_name,c.contact_no,ifnull(u.name,'customer') as order_by_name,o.order_by,to.order_type,o.created_at,o.completed_at");
            $this->db->from('orders as o');
            $this->db->join('customer c','c.id=o.customer_id');
            $this->db->join('user u','u.id=o.order_by','left');
            $this->db->join('table_details t','t.id=o.table_id','left');
            $this->db->join('table_orders to','to.id=o.table_orders_id');
            
			if($search_name!="")
			{
                $this->db->like('LOWER(c.name)',strtolower($search_name));
                $this->db->or_like('LOWER(o.order_no)',strtolower($search_name));
            }
			
            if($status!="")
                $this->db->where('o.status',$status);
            if($order_date!="")
                $this->db->where('DATE_FORMAT(created_at,"%Y-%m-%d")',$order_date);
            
			$this->db->where('o.rest_id',$_SESSION['user_id']);
            $this->db->where('to.order_type!=','Website');
            $this->db->order_by('o.id','desc');
            $query = $this->db->get();
            $result = $query->result_array();
            /* echo $this->db->last_query();
            die; */
            return  array(
                'orders'=>$result,
                'total_count'=>$recipes_count['cnt'],
                'total_pages'=>1,
                'page_no'=>1,
                'page_total_text'=>"1 - ".$recipes_count['cnt']
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
            die; */
			
            $this->db->select("o.id as ordID,o.order_no,o.*,DATE_FORMAT(created_at,'%d %b %Y %h:%i %p') as order_date,t.title as table_no,c.name as customer_name,c.contact_no,ifnull(u.name,'customer') as order_by_name,o.order_by,to.order_type,o.created_at,o.completed_at");
            $this->db->from('orders as o');
            $this->db->join('customer c','c.id=o.customer_id');
            $this->db->join('user u','u.id=o.order_by','left');
            $this->db->join('table_details t','t.id=o.table_id','left');
            $this->db->join('table_orders to','to.id=o.table_orders_id');
            
			if($search_name!="")
			{
                $this->db->like('LOWER(c.name)',strtolower($search_name));
                $this->db->or_like('LOWER(o.order_no)',strtolower($search_name));
            }
			
            if($status!="")
                $this->db->where('o.status',$status);
            
			if($order_date!="")
                $this->db->where('DATE_FORMAT(created_at,"%Y-%m-%d")',$order_date);
            $this->db->where('o.rest_id',$_SESSION['user_id']);
            $this->db->where('to.order_type!=','Website');
            $this->db->order_by('o.id','desc');
			
			if($records_per_page == $offset)
			{
				$this->db->limit($offset,0);
			}	
			else
			{
				$this->db->limit($records_per_page,$offset);
			}

            $query = $this->db->get();
			/* echo $this->db->last_query();exit; */
            $result = $query->result_array();
            $total_pages = ceil($recipes_count['cnt'] / $records_per_page);

            if($recipes_count['cnt']<$records_per_page*$page_no)
                $to_page=$recipes_count['cnt'];
            else
                $to_page=$records_per_page*$page_no;
            
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

    public function all_orders1($page_no,$records_per_page,$status,$order_date="",$search_name="")
	{
        //$this->db->where('r.logged_user_id',$user_id);
            
        $this->db->select('count(o.id) as cnt');
        $this->db->from('orders o');
        $this->db->join('customer c','c.id=o.customer_id');
        $this->db->join('table_orders to','to.id=o.table_orders_id');
        
		if($search_name!="")
		{
            $this->db->like('LOWER(o.order_no)',strtolower($search_name));
            $this->db->or_like('LOWER(c.name)',strtolower($search_name));
        }
        
		if($status!="")
                $this->db->where('o.status',$status);
        
		if($order_date!="")
            $this->db->where('DATE_FORMAT(created_at,"%Y-%m-%d")',$order_date);
        
		$this->db->where('o.rest_id',$_SESSION['user_id']);
        $this->db->where('to.order_type!=','Website');
        $query=$this->db->get();
        $recipes_count=$query->row_array();

        if($records_per_page=="all")
		{
            $this->db->select("o.id as ordID,o.order_no,o.*,DATE_FORMAT(created_at,'%d %b %Y %h:%i %p') as order_date,t.title as table_no,c.name as customer_name,c.contact_no,ifnull(u.name,'customer') as order_by_name,o.order_by,to.order_type,o.created_at,o.completed_at");
            $this->db->from('orders as o');
            $this->db->join('customer c','c.id=o.customer_id');
            $this->db->join('user u','u.id=o.order_by','left');
            $this->db->join('table_details t','t.id=o.table_id','left');
            $this->db->join('table_orders to','to.id=o.table_orders_id');
            
			if($search_name!="")
			{
                $this->db->like('LOWER(c.name)',strtolower($search_name));
                $this->db->or_like('LOWER(o.order_no)',strtolower($search_name));
            }
			
            if($status!="")
                $this->db->where('o.status',$status);
            if($order_date!="")
                $this->db->where('DATE_FORMAT(created_at,"%Y-%m-%d")',$order_date);
            
			$this->db->where('o.rest_id',$_SESSION['user_id']);
            $this->db->where('to.order_type!=','Website');
            $this->db->order_by('o.id','desc');
            $query = $this->db->get();
            $result = $query->result_array();
            return  array(
                'orders'=>$result,
                'total_count'=>$recipes_count['cnt'],
                'total_pages'=>1,
                'page_no'=>1,
                'page_total_text'=>"1 - ".$recipes_count['cnt']
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
            die; */
			
            $this->db->select("o.id as ordID,o.order_no,o.*,DATE_FORMAT(created_at,'%d %b %Y %h:%i %p') as order_date,t.title as table_no,c.name as customer_name,c.contact_no,ifnull(u.name,'customer') as order_by_name,o.order_by,to.order_type,o.created_at,o.completed_at");
            $this->db->from('orders as o');
            $this->db->join('customer c','c.id=o.customer_id');
            $this->db->join('user u','u.id=o.order_by','left');
            $this->db->join('table_details t','t.id=o.table_id','left');
            $this->db->join('table_orders to','to.id=o.table_orders_id');
            
			if($search_name!="")
			{
                $this->db->like('LOWER(c.name)',strtolower($search_name));
                $this->db->or_like('LOWER(o.order_no)',strtolower($search_name));
            }
			
            if($status!="")
                $this->db->where('o.status',$status);
            
			if($order_date!="")
                $this->db->where('DATE_FORMAT(created_at,"%Y-%m-%d")',$order_date);
            $this->db->where('o.rest_id',$_SESSION['user_id']);
            $this->db->where('to.order_type!=','Website');
            $this->db->order_by('o.id','desc');
			
			if($records_per_page == $offset)
			{
				$this->db->limit($offset,0);
			}	
			else
			{
				$this->db->limit($records_per_page,$offset);
			}

            $query = $this->db->get();
			/* echo $this->db->last_query();exit; */
            $result = $query->result_array();
            $total_pages = ceil($recipes_count['cnt'] / $records_per_page);

            if($recipes_count['cnt']<$records_per_page*$page_no)
                $to_page=$recipes_count['cnt'];
            else
                $to_page=$records_per_page*$page_no;
            
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

    public function get_table_orderdetails($table_order_id)
	{
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

    public function get_tableorder($table_order_id,$invoiceId)
	{
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
		
		if($invoiceId!="")
		{
			$this->db->where('o.table_orders_id',$table_order_id);
			$this->db->where('o.invoice_id',$invoiceId);
		}
        else
		{
			$this->db->where('o.table_orders_id',$table_order_id);
            $this->db->where('o.is_invoiced',0);
        }		
		
		$this->db->where('o.rest_id',$_SESSION['user_id']);
        $this->db->order_by('o.id','asc');
        $query = $this->db->get();
        $row['orders']=[];
        $orders = $query->result_array();

        foreach ($orders as $order) 
		{
            $order['items']=$this->order_item_model->list_order_items($order['id']);
            
            if($order['invoice_id']!="")
			{
                $this->db->select("i.*,DATE_FORMAT(i.created_at,'%d/%m/%Y') as invoic_date,o.discount_note as final_note");
                $this->db->from('invoices as i');
				$this->db->join('orders o','o.table_orders_id=i.table_order_id','left');
                $this->db->where_in('i.id',$order['invoice_id']);
                $query = $this->db->get();
                $invoice = $query->row_array();

                $order['invoice']=$invoice;
            }
			else
			{
                $order['invoices']=array();
            }
            $row['orders'][]=$order;
        }
        return $row;
    }

	public function get_tableorder_invoices($table_order_id,$invoiceId)
	{
		$this->db->select("o.*,o.order_type,t.title as table_noo,DATE_FORMAT(insert_date,'%d %b %Y') as order_date");
		$this->db->from('table_orders o');
		$this->db->join('table_details t','t.id=o.table_id');
		$this->db->where('o.id',$table_order_id);
		$query = $this->db->get();
		
		$row = $query->row_array();
		$order_type=$row['order_type'];
		
		$this->db->select("*");
		$this->db->from('user o');
		$this->db->where('id',$_SESSION['user_id']);
        $q = $this->db->get()->row_array();
        $row['restaurant'] = $q;
		
		$this->db->select("o.*,o.id as order_id_for_deliverer,DATE_FORMAT(created_at,'%d %b %Y %h:%i %p') as order_date,t.title as table_no,c.name as customer_name,c.contact_no,ifnull(u.name,'customer') as order_by_name,ot.order_type");
		$this->db->from('orders as o');
		$this->db->join('customer c','c.id=o.customer_id');
		$this->db->join('user u','u.id=o.order_by','left');
		$this->db->join('table_details t','t.id=o.table_id','left');
		$this->db->join('table_orders ot','ot.id=o.table_orders_id','left');
		
		if($invoiceId!="")
		{
			$this->db->where('o.table_orders_id',$table_order_id);
			$this->db->where('o.invoice_id',$invoiceId);
		}
        else
		{
			$this->db->where('o.table_orders_id',$table_order_id);
			//$this->db->where('o.is_invoiced',0);
		}
		
		$this->db->where('o.rest_id',$_SESSION['user_id']);
		//$this->db->where('o.status !=','Blocked');
		//$this->db->where('o.status !=','Canceled');
		$this->db->where('o.status !=','Completed');
		$this->db->order_by('o.id','ASC');
		$query = $this->db->get();
		// echo $this->db->last_query();exit; 
		$orders = $query->result_array();
		$row['orders']=[];

		foreach ($orders as $order) 
		{
			$order['items']=$this->order_item_model->list_order_items($order['id']);
			$row['orders'][]=$order;
		}

		$invoices=explode(',',$row['invoice_ids']);
		
		$this->db->select("i.*,DATE_FORMAT(i.created_at,'%d/%m/%Y') as invoic_date,t.title as table_no,c.name as customer_name,c.contact_no,u.business_name as rest_name,u.address,u.city,u.country,u.postcode,u.delivery_fee,sum(o.no_of_person) as no_of_person,o.supply_option,o.delivery_payment,o.discount_note as final_note");
		$this->db->from('invoices as i');
		$this->db->join('customer c','c.id=i.customer_id');
		$this->db->join('table_details t','t.id=i.table_id','left');
		$this->db->join('user u','u.id=i.rest_id','left');
		$this->db->join('orders o','o.table_orders_id=i.table_order_id','left');
		
		if($invoiceId=="")
		{
			$this->db->where_in('i.id',$invoices);
		}
		else
		{
			$this->db->where('i.id',$invoiceId);
		}
		
		$query = $this->db->get();
		$invoices = $query->result_array();
		$row['invoices']=[];
		//echo $this->db->last_query();
		foreach ($invoices as $invoice) 
		{
			$invoice['items']=$this->invoice_item_model->list_invoice_items($invoice['id']);
			$row['invoices'][]=$invoice;
		}
		return $row;
	}

    public function list_tablwise_orders($page_no,$records_per_page,$status,$order_date,$search_name="")
	{
        $this->db->select('count(o.id) as cnt');
        $this->db->from('table_orders o');
        $this->db->join('table_details t','t.id=o.table_id');
        $this->db->join('orders ord','o.id=ord.table_orders_id', 'left');
		
		if($search_name!="")
		{
            $where='(UPPER(o.table_orderno) LIKE "%'.strtoupper($search_name).'%" OR UPPER(t.title) LIKE "%'.strtoupper($search_name).'%")';
            $this->db->where($where);
        }
        
		if($order_date!="")
            $this->db->where('o.insert_date',$order_date);
        $this->db->where('o.restaurant_id',$_SESSION['user_id']);
        $this->db->where('o.order_type!=','Website');
        $query=$this->db->get();
        $recipes_count=$query->row_array();
       /* echo $this->db->last_query();
        die;*/

        if($records_per_page=="all")
		{
            $this->db->select("ord.id as ordID,ord.order_no,o.*,DATE_FORMAT(insert_date,'%d %b %Y') as order_date,DATE_FORMAT(insert_time,'%h:%i %p') as insert_time,t.title as table_no, ord.status, ord.order_by, ord.created_at, ord.completed_at,u.name as order_by_name");
            $this->db->from('table_orders o');
            $this->db->join('table_details t','t.id=o.table_id', 'left');
			$this->db->join('orders ord','o.id=ord.table_orders_id', 'left');
			$this->db->join('user u','u.id=ord.order_by', 'left');
			
            if($order_date!="")
                $this->db->where('o.insert_date',$order_date);
            if($search_name!=""){
                $where='(UPPER(ord.order_no) LIKE "%'.strtoupper($search_name).'%" OR UPPER(o.table_orderno) LIKE "%'.strtoupper($search_name).'%" OR UPPER(t.title) LIKE "%'.strtoupper($search_name).'%")';
                $this->db->where($where);
            }
            $this->db->where('o.restaurant_id',$_SESSION['user_id']);
            $this->db->where('o.order_type!=','Website');
            $this->db->order_by('o.id','desc');
            $query = $this->db->get();
            $result = $query->result_array();
            /* echo $this->db->last_query();
            die; */
            return  array(
                'orders'=>$result,
                'total_count'=>$recipes_count['cnt'],
                'total_pages'=>1,
                'page_no'=>1,
                'page_total_text'=>"1 - ".$recipes_count['cnt']
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
          
            $this->db->select("ord.id as ordID,ord.order_no,o.*,DATE_FORMAT(insert_date,'%d %b %Y') as order_date,DATE_FORMAT(insert_time,'%h:%i %p') as insert_time,t.title as table_no, ord.status, ord.is_invoiced, ord.invoice_id, ord.order_by, ord.created_at, ord.completed_at,u.name as order_by_name");
            $this->db->from('table_orders o');
            $this->db->join('table_details t','t.id=o.table_id', 'left');
            $this->db->join('orders ord','o.id=ord.table_orders_id', 'left');
			$this->db->join('user u','u.id=ord.order_by', 'left');
			
            if($order_date!="")
                $this->db->where('o.insert_date',$order_date);
            
			if($search_name!="")
			{
                $where='(UPPER(ord.order_no) LIKE "%'.strtoupper($search_name).'%" OR UPPER(o.table_orderno) LIKE "%'.strtoupper($search_name).'%" OR UPPER(t.title) LIKE "%'.strtoupper($search_name).'%")';
                $this->db->where($where);
            }
            $this->db->where('o.restaurant_id',$_SESSION['user_id']);
            $this->db->where('o.order_type!=','Website');
            $this->db->order_by('o.id','desc');
            
			if($records_per_page == $offset)
			{
				$default=0;
				$this->db->limit($offset,0);
			}
			else
			{
				$this->db->limit($records_per_page,$offset);
			}
			
            $query = $this->db->get();
            $result = $query->result_array();
			/* echo $this->db->last_query();die; */

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

    public function list_tablwise_orders1($page_no,$records_per_page,$status,$order_date='',$search_name="")
	{
        $this->db->select('count(o.id) as cnt');
        $this->db->from('table_orders o');
        $this->db->join('table_details t','t.id=o.table_id');
        $this->db->join('orders ord','o.id=ord.table_orders_id', 'left');
		
		if($search_name!="")
		{
            $where='(UPPER(o.table_orderno) LIKE "%'.strtoupper($search_name).'%" OR UPPER(t.title) LIKE "%'.strtoupper($search_name).'%")';
            $this->db->where($where);
        }
        
		if($order_date!="")
            $this->db->where('o.insert_date',$order_date);
        $this->db->where('o.restaurant_id',$_SESSION['user_id']);
        $this->db->where('o.order_type!=','Website');
        $query=$this->db->get();
        $recipes_count=$query->row_array();
       /* echo $this->db->last_query();
        die;*/

        if($records_per_page=="all")
		{
            $this->db->select("ord.id as ordID,ord.order_no,o.*,DATE_FORMAT(insert_date,'%d %b %Y') as order_date,DATE_FORMAT(insert_time,'%h:%i %p') as insert_time,t.title as table_no, ord.status, ord.order_by, ord.created_at, ord.completed_at,u.name as order_by_name");
            $this->db->from('table_orders o');
            $this->db->join('table_details t','t.id=o.table_id', 'left');
			$this->db->join('orders ord','o.id=ord.table_orders_id', 'left');
			$this->db->join('user u','u.id=ord.order_by', 'left');
			
            if($order_date!="")
                $this->db->where('o.insert_date',$order_date);
            if($search_name!=""){
                $where='(UPPER(ord.order_no) LIKE "%'.strtoupper($search_name).'%" OR UPPER(o.table_orderno) LIKE "%'.strtoupper($search_name).'%" OR UPPER(t.title) LIKE "%'.strtoupper($search_name).'%")';
                $this->db->where($where);
            }
            $this->db->where('o.restaurant_id',$_SESSION['user_id']);
            $this->db->where('o.order_type!=','Website');
            $this->db->order_by('o.id','desc');
            $query = $this->db->get();
            $result = $query->result_array();
            /* echo $this->db->last_query();
            die; */
            return  array(
                'orders'=>$result,
                'total_count'=>$recipes_count['cnt'],
                'total_pages'=>1,
                'page_no'=>1,
                'page_total_text'=>"1 - ".$recipes_count['cnt']
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
          
            $this->db->select("ord.id as ordID,ord.order_no,o.*,DATE_FORMAT(insert_date,'%d %b %Y') as order_date,DATE_FORMAT(insert_time,'%h:%i %p') as insert_time,t.title as table_no, ord.status, ord.is_invoiced, ord.invoice_id, ord.order_by, ord.created_at, ord.completed_at,u.name as order_by_name");
            $this->db->from('table_orders o');
            $this->db->join('table_details t','t.id=o.table_id', 'left');
            $this->db->join('orders ord','o.id=ord.table_orders_id', 'left');
			$this->db->join('user u','u.id=ord.order_by', 'left');
			
            if($order_date!="")
                $this->db->where('o.insert_date',$order_date);
            
			if($search_name!="")
			{
                $where='(UPPER(ord.order_no) LIKE "%'.strtoupper($search_name).'%" OR UPPER(o.table_orderno) LIKE "%'.strtoupper($search_name).'%" OR UPPER(t.title) LIKE "%'.strtoupper($search_name).'%")';
                $this->db->where($where);
            }
            $this->db->where('o.restaurant_id',$_SESSION['user_id']);
            $this->db->where('o.order_type!=','Website');
            $this->db->order_by('o.id','desc');
            
			if($records_per_page == $offset)
			{
				$default=0;
				$this->db->limit($offset,0);
			}
			else
			{
				$this->db->limit($records_per_page,$offset);
			}
			
            $query = $this->db->get();
            $result = $query->result_array();
			/* echo $this->db->last_query();die; */

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

    public function list_tablwise_orders_website($page_no,$records_per_page,$order_date,$status,$search_name="")
	{
        $this->db->select('count(o.id) as cnt');
        $this->db->from('table_orders o');
        $this->db->join('table_details t','t.id=o.table_id');
        $this->db->join('orders ord','o.id=ord.table_orders_id', 'left');
		
		if($search_name!="")
		{
            $where='(UPPER(o.table_orderno) LIKE "%'.strtoupper($search_name).'%" OR UPPER(t.title) LIKE "%'.strtoupper($search_name).'%")';
            $this->db->where($where);
        }
        
		if($order_date!="")
            $this->db->where('o.insert_date',$order_date);
		if($status!="")
            $this->db->where('ord.status',$status);
        $this->db->where('o.restaurant_id',$_SESSION['user_id']);
        $this->db->where('o.order_type','Website');
        $query=$this->db->get();
        $recipes_count=$query->row_array();
       /* echo $this->db->last_query();
        die;*/

        if($records_per_page=="all")
		{
            $this->db->select("ord.id as ordID,ord.order_no,o.*,DATE_FORMAT(insert_date,'%d %b %Y') as order_date,DATE_FORMAT(insert_time,'%h:%i %p') as insert_time,t.title as table_no, ord.status, ord.created_at, ord.completed_at, ord.supply_option, cust_add.complete_address, cust_add.name, cust_add.contact_number");
            $this->db->from('table_orders o');
            $this->db->join('table_details t','t.id=o.table_id', 'left');
			$this->db->join('orders ord','o.id=ord.table_orders_id', 'left');
			$this->db->join('customer_address cust_add','cust_add.id=ord.customer_address_id', 'left');
			
            if($order_date!="")
                $this->db->where('o.insert_date',$order_date);
			if($status!="")
            $this->db->where('ord.status',$status);
            if($search_name!=""){
                $where='(UPPER(ord.order_no) LIKE "%'.strtoupper($search_name).'%" OR UPPER(o.table_orderno) LIKE "%'.strtoupper($search_name).'%" OR UPPER(t.title) LIKE "%'.strtoupper($search_name).'%")';
                $this->db->where($where);
            }
            $this->db->where('o.restaurant_id',$_SESSION['user_id']);
            $this->db->where('o.order_type','Website');
            $this->db->order_by('o.id','desc');
            $query = $this->db->get();
            $result = $query->result_array();
            /* echo $this->db->last_query();
            die; */
            return  array(
                'orders'=>$result,
                'total_count'=>$recipes_count['cnt'],
                'total_pages'=>1,
                'page_no'=>1,
                'page_total_text'=>"1 - ".$recipes_count['cnt']
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
          
            $this->db->select("ord.id as ordID,ord.order_no,o.*,DATE_FORMAT(insert_date,'%d %b %Y') as order_date,DATE_FORMAT(insert_time,'%h:%i %p') as insert_time,t.title as table_no, ord.status, ord.is_invoiced, ord.invoice_id, ord.created_at, ord.completed_at, ord.supply_option, cust_add.complete_address, cust_add.name, cust_add.contact_number");
            $this->db->from('table_orders o');
            $this->db->join('table_details t','t.id=o.table_id', 'left');
            $this->db->join('orders ord','o.id=ord.table_orders_id', 'left');
            $this->db->join('customer_address cust_add','cust_add.id=ord.customer_address_id', 'left');
			
            if($order_date!="")
                $this->db->where('o.insert_date',$order_date);
            if($status!="")
            $this->db->where('ord.status',$status);
			if($search_name!="")
			{
                $where='(UPPER(ord.order_no) LIKE "%'.strtoupper($search_name).'%" OR UPPER(o.table_orderno) LIKE "%'.strtoupper($search_name).'%" OR UPPER(t.title) LIKE "%'.strtoupper($search_name).'%")';
                $this->db->where($where);
            }
            $this->db->where('o.restaurant_id',$_SESSION['user_id']);
            $this->db->where('o.order_type','Website');
            $this->db->order_by('o.id','desc');
            
			if($records_per_page == $offset)
			{
				$default=0;
				$this->db->limit($offset,0);
			}
			else
			{
				$this->db->limit($records_per_page,$offset);
			}
			
            $query = $this->db->get();
            $result = $query->result_array();
			/* echo $this->db->last_query();die; */

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
	
    public function block_unblock_table($id,$is_available)
	{
        $this->db->where('id',$id);
        $this->db->update('table_details',array(
            'is_available'=>$is_available
        ));
		/* echo $this->db->last_query();exit; */
    }

    public function order_summary_repot($from_date,$to_date)
	{
        $this->db->select("o.*,DATE_FORMAT(created_at,'%d %b %Y %h:%i %p') as order_date,t.title as table_no,c.name as customer_name,c.contact_no,ifnull(u.name,'customer') as order_by_name,o.order_by,to.order_type");
        $this->db->from('orders as o');
        $this->db->join('customer c','c.id=o.customer_id');
        $this->db->join('user u','u.id=o.order_by','left');
        $this->db->join('table_details t','t.id=o.table_id','left');
        $this->db->join('table_orders to','t.id=to.table_id','left');
        $this->db->where('o.rest_id',$_SESSION['user_id']);
        $this->db->where('o.created_at>=',$from_date);
        $this->db->where('o.created_at<=',$to_date);
        $this->db->group_by('o.id');
        $this->db->order_by('o.id','desc');
        $query = $this->db->get();
		/* echo $this->db->last_query();exit; */
        $result = $query->result_array();

        return $result;
    }
	
    public function takeaway_order_summary_repot($from_date,$to_date,$takeawaycategory)
	{
        $this->db->select("o.*,DATE_FORMAT(created_at,'%d %b %Y %h:%i %p') as order_date,t.title as table_no,c.name as customer_name,c.contact_no,ifnull(u.name,'customer') as order_by_name");
        $this->db->from('orders as o');
        $this->db->join('customer c','c.id=o.customer_id');
        $this->db->join('user u','u.id=o.order_by','left');
        $this->db->join('table_details t','t.id=o.table_id','left');
        $this->db->join('table_category tc','tc.id=t.table_category_id');
        $this->db->where('o.rest_id',$_SESSION['user_id']);
        $this->db->where('o.created_at>=',$from_date);
        $this->db->where('o.created_at<=',$to_date);
        $this->db->where('tc.flag=1');
		if($takeawaycategory>0)
		{
			$this->db->where('tc.id=',$takeawaycategory);
		}
        $this->db->order_by('o.id','desc');
        $query = $this->db->get();
		/* echo $this->db->last_query();exit; */
        $result = $query->result_array();
				
		/* $sql7 = "SELECT o.*,DATE_FORMAT(created_at,'%d %b %Y %h:%i %p') as order_date,t.title as table_no,c.name as customer_name,c.contact_no,ifnull(u.name,'customer') as order_by_name 
				FROM orders o, customer c, user u, table_details t, table_category tc 
				WHERE 
				c.id=o.customer_id AND 
				u.id=o.order_by AND 
				t.id=o.table_id AND 
				tc.id=t.table_category_id AND 				
				o.rest_id=".$_SESSION['user_id']." AND 
				o.created_at>='".$from_date."' AND 
				o.created_at<='".$to_date."' AND 
				tc.flag = 1 ORDER BY o.id desc ";
        $result= $this->query($sql7); */
		return $result;
    } 
	
	public function takeaway_category()
	{
        $this->db->select("*");
        $this->db->from('table_category');
        $this->db->where('flag=1');
        $this->db->order_by('id','desc');
        $query = $this->db->get();
		/* echo $this->db->last_query();exit; */
        $result = $query->result_array();		
		return $result;
    }
	
	public function send_notifiation($order_id,$table_id,$table_orders_id,$orderType,$title,$name,$order_no,$created_at,$devicetoken)
	{
		$data1 = array('id'=>$order_id,'table_id'=>$table_id,'table_orders_id'=>$table_orders_id,'orderType'=>$orderType,'title'=>$title,'name'=>$name,'order_no'=>$order_no,'created_at'=>$created_at);
		$jsondata = json_encode($data1);
				
		$sql7 = "SELECT o.id, o.order_no,o.net_total,o.status,o.created_at,c.name,o.table_id,o.table_orders_id,td.title,tblo.order_type FROM `orders` as o 
		LEFT JOIN customer as c on c.id = o.customer_id
		LEFT JOIN table_details as td on td.id = o.table_id
		INNER JOIN table_orders as tblo on tblo.id = o.table_orders_id
		WHERE o.rest_id = ".$_SESSION['user_id']." AND o.id = ".$order_id." and o.status='New' and o.viewed=0 ORDER BY o.id desc ";
		$res= $this->query($sql7);
		
		/* $devicetoken = $_SESSION['devicetoken_'.$_SESSION['user_id']]; */
		$data = array();
		$data['data']['notification']['title'] = "New order";
		$data['data']['notification']['body'] = "New order received.";
		$data['data']['notification']['icon'] = "/itwonders-web-logo.png";
		$data['data']['notification']['sound'] = "default";
		$data['data']['webpush']['headers']['Urgency'] = "high";
		$data['to'] = $devicetoken;
		// print_r(json_encode($data));
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_POST, 1);
		$headers = array();
		/* $headers[] = "Authorization: key = AAAAzOOokBU:APA91bEzMANbDNo4zlOBvFgBBuDKXeIpwAIWT9ke6eEWW2i1Ybt-lemfRNasf2eCbLZb91nkCbXoEHlaOy-mvgxej-zADHvPdUSU3kjo_QtHGSFRLPorxj64LC7OGUZDCFNAJdIXjpnJ"; */
		$headers[] = "Authorization: key = AAAA1dBk1Xo:APA91bFGIcPp1GXoE1W62qChf1Z_L-dMSOqIK7aBgCWZL4v5bR6ysIMM_Ep6tmA_RMw6vt-lumJKeVKzDEcBiNEs_ju8XoA3nS8g6izIoGSXFjfTq_ZCIPxYqpgJqT07ggQxVXLgBABt";
		$headers[] = "Content-Type: application/json";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		curl_setopt($ch, CURLOPT_URL , "https://fcm.googleapis.com/fcm/send");
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch,CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch,CURLOPT_POSTFIELDS, json_encode($data));
		// curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, false);
		// curl_setopt($ch,CURLOPT_SSL_VERIFYPEER , false);

		$result = curl_exec($ch);
		/* if (curl_errno($ch))
		echo 'Error:' . curl_error($ch); */

		curl_close($ch);

		/* echo "<pre>Result : ";
		print_r(json_decode($result,1));
		echo '<br>sent through</pre>'; */
	}
	
	public function query($query)
    {
        $res=$this->db->query($query);
        
		if($res)
		{
            return $res->result_array();
        }
        else
		{
            return false;
        }
    }
	
	public function payment_summary_repot($from_date,$to_date,$payment_type)
	{
        $this->db->select("*");
        $this->db->from('orders as o');
        $this->db->join('invoice_payment iv','iv.invoice_id=o.invoice_id');
        $this->db->where('o.rest_id',$_SESSION['user_id']);
        $this->db->where('o.created_at>=',$from_date);
        $this->db->where('o.created_at<=',$to_date);
        $this->db->where('iv.payment_amount>0');
		if($payment_type!="")
		{
			$this->db->where('iv.payment_type=',$payment_type);
		}
        $this->db->order_by('o.id','desc');
        $query = $this->db->get();
		/* echo $this->db->last_query();exit; */
        $result = $query->result_array();
		
		return $result;
    }
	
	public function getGroupLists()
	{
        $this->db->select("*");
        $this->db->from('menu_group');
		$this->db->where('logged_user_id',$_SESSION['user_id']);
        $this->db->order_by('title','ASC');
        $query = $this->db->get();
		/* echo $this->db->last_query();exit; */
        $result = $query->result_array();		
		return $result;
    }
}
?>