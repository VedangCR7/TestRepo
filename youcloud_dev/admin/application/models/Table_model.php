<?php
class Table_model extends My_Model {
	var $title;
	var $table_category_id;
	var $qrcode;
	var $is_active;
	var $logged_user_id;
	var $is_delete;
	var $is_available;
    var $tablename="table_details";
    var $fields=array('title','table_category_id','qrcode','is_active','logged_user_id','is_delete','is_available');
    public function __construct()
    {
    	$this->load->database();
    }

    public function get_tblCat($resto_id) 
	{
		$condition='is_delete=0 AND is_active=1 AND flag=0 AND logged_user_id='.$resto_id;
		
		$this->db->select('*');
		$this->db->from('table_category');

		if($condition!='')
		{
			$this->db->where($condition);
		}
		$this->db->order_by("id", "desc");
		$query = $this->db->get();
		/* echo $this->db->last_query(); exit; */
		if ($query->num_rows()>0) 
		{
			return $query->result();
		}
		else 
		{
			return false;
		}
	}
	
	public function getTableCatName($tcatId) 
	{
		$condition='is_delete=0 AND id='.$tcatId;
		
		$this->db->select('title');
		$this->db->from('table_category');

		if($condition!='')
		{
			$this->db->where($condition);
		}
		$query = $this->db->get();
		/* echo $this->db->last_query(); exit; */
		if ($query->num_rows()>0) 
		{
			$row = $query->row_array();
			return $row['title'];
		}
		else 
		{
			return false;
		}
	}
	
	public function get_tblCount($resto_id,$catId='') 
	{
		$condition='is_active=1 AND logged_user_id='.$resto_id." AND id=".$catId;
		
		$this->db->select('tbl_count');
		$this->db->from('table_category');

		if($condition!='')
		{
			$this->db->where($condition);
		}

		$query = $this->db->get();
		/* echo $this->db->last_query(); exit; */
		if ($query->num_rows()>0) 
		{
			$row = $query->row_array();
			return $row['tbl_count'];
		}
		else 
		{
			return false;
		}
	}
	
	public function add_tableDetails($data)
	{
		$this->db->insert('table_details', $data);
		$insert_id = $this->db->insert_id();
		/* echo $this->db->last_query(); exit; */
		if ($this->db->affected_rows() > 0) 
		{
			return $insert_id;
		}
		else 
		{
			return false;
		}
	}
	
	public function get_tableDetails($resto_id='') 
	{
		$condition='';
		
		if($resto_id!='')
		{
			$condition = "td.is_delete=0 AND tc.is_delete=0 AND tc.is_active=1 AND tc.flag=0 AND tc.id=td.table_category_id AND td.logged_user_id =" .$resto_id;
		}

		$this->db->select('td.*, tc.id as tcid, tc.title as ttl, tc.is_active as tactive, tc.is_delete');
		$this->db->from('table_details td, table_category tc');

		if($condition!='')
		{
			$this->db->where($condition);
		}
		$this->db->order_by("id", "desc");
		$query = $this->db->get();
		/* echo $this->db->last_query(); exit; */
		if ($query->num_rows()>0) 
		{
			return $query->result();
		}
		else 
		{
			return false;
		}
	}
	
	public function get_tableCatDetails($resto_id='') 
	{
		$condition='';
		
		if($resto_id!='')
		{
			$condition = "is_delete=0 AND logged_user_id =" .$resto_id;
		}

		$this->db->select('*');
		$this->db->from('table_category');

		if($condition!='')
		{
			$this->db->where($condition);
		}
		$this->db->order_by("id", "DESC");

		$query = $this->db->get();
		/* echo $this->db->last_query(); exit; */
		if ($query->num_rows()>0) 
		{
			return $query->result();
		}
		else 
		{
			return false;
		}
	}
	
	public function add_tableCategory($data)
	{
		$this->db->insert('table_category', $data);
		$insert_id = $this->db->insert_id();
		/* echo $this->db->last_query(); exit; */
		if ($this->db->affected_rows() > 0) 
		{
			return $insert_id;
		}
		else 
		{
			return false;
		}
	}
	
	public function check_createdTblNm($newtblname,$restoId) 
	{
		$condition = "title = '$newtblname' AND logged_user_id = $restoId";
		$this->db->select('*');
		$this->db->from('table_details');
		$this->db->where($condition);	
		$query = $this->db->get();
		
		if ($query->num_rows()>0) 
		{
			return $query->num_rows();
		} 
		else 
		{
			return false;
		}
	}
	
	public function check_createdTblCatNm($newtblname,$restoId) 
	{
		$condition = "title = '$newtblname' AND logged_user_id = $restoId";
		$this->db->select('*');
		$this->db->from('table_category');
		$this->db->where($condition);	
		$query = $this->db->get();
		
		if ($query->num_rows()>0) 
		{
			return $query->num_rows();
		} 
		else 
		{
			return false;
		}
	}
	
	public function delete_tbl($clientId) 
	{
		$this->db->where('id', $clientId);
		$this->db->delete('table_details');
		$this->db->last_query();
		if ($this->db->affected_rows() > 0) 
		{
			return true;
		} 
		else 
		{
			return false;
		}
	}
	
	public function delete_tblCat($clientId) 
	{
		$this->db->where('table_category_id', $clientId);
		$this->db->delete('table_details');
		$this->db->last_query();
		
		$this->db->where('id', $clientId);
		$this->db->delete('table_category');
		$this->db->last_query();
		if ($this->db->affected_rows() > 0) 
		{
			return true;
		} 
		else 
		{
			return false;
		}
	}
}
?>