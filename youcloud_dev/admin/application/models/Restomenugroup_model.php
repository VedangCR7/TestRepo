<?php
class Restomenugroup_model extends My_Model {
	var $name;
	var $value;
	var $unit;
	var $warning;
	var $recipe_id;
    var $tablename="menu_group";
    var $fields=array('title','available_in','is_active','datetime','main_menu_id','logged_user_id','sequence','image_path');
    public function __construct()
    {
    	$this->load->database();
    }

    public function get_menuGroupDetails($resto_id) 
	{
		$condition='g.main_menu_id=m.id AND g.is_active=1 AND g.logged_user_id='.$resto_id;
		
		$this->db->select('g.*, m.id as mid, m.name as mmname');
		$this->db->from('menu_group g, menu_master m');

		if($condition!='')
		{
			$this->db->where($condition);
		}
		$this->db->order_by("g.id", "asc");
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
			$condition = "td.is_delete=0 AND tc.is_delete=0 AND tc.is_active=1 AND tc.id=td.table_category_id AND td.logged_user_id =" .$resto_id;
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