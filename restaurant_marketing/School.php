<?php
require_once 'Connection.php';
class School extends Connection
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function is_base64($s)
	{
		// Check if there are valid base64 characters
		if (!preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $s)) return false;

		// Decode the string in strict mode and check the results
		$decoded = base64_decode($s, true);
		if(false === $decoded) return false;

		// Encode the string again
		if(base64_encode($decoded) != $s) return false;

		return true;
	}

	public function insert($name,$email,$webname,$type,$cntc,$city_id,$address,$fblink,$rec_status,$country)
	{
		$f="insert into schoolinfo(s_name,email,type,website,contact,city_id,address,fb_link,rec_status,c_id) values('".$name."','".$email."','".$type."','".$webname."','".$cntc."','".$city_id."','".$address."','".$fblink."','".$rec_status."',".$country.");";
		
		if(mysqli_query($this->con,$f))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function displaySchoolType()
	{
		$q="select * from schooltype";
		
		$m=mysqli_query($this->con,$q);
		while ($row = $m->fetch_assoc()) 
		{
			$school_array[] = $row;
		}

		return $school_array;
	}
	
	public function displaySchool()
	{
		$q="select s_id,s_name,email,type,contact from schoolinfo WHERE c_id IN ('157','260') ORDER BY s_id DESC";	
		$m=mysqli_query($this->con,$q);

		while ($row = $m->fetch_assoc()) 
		{
			$school_array[] = $row;
		}
		return $school_array;
	}

	public function deleteSchool($s_id)
	{
		$q="delete from schoolinfo where s_id=".$s_id;	

		if(mysqli_query($this->con,$q))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function fetchSchool($s_id)
	{
		$q ="select s_id,s_name,email,contact,schoolinfo.city_id,address,website,fb_link,c_name,schoolinfo.c_id,city_name from schoolinfo,country,city where schoolinfo.c_id=country.c_id and schoolinfo.city_id=city.city_id AND s_id=".$s_id;
		/* $q="select s_id,s_name,email,contact,city_id,address,website,fb_link,c_name,schoolinfo.c_id from schoolinfo,country where schoolinfo.c_id=country.c_id and s_id=".$s_id; */
		$m=mysqli_query($this->con,$q);
		
		while ($row = $m->fetch_assoc()) 
		{	
			$school_array = $row;
		}	
		return $school_array;
	}

	public function update($id,$name,$email,$webname,$cntc,$city_id,$address,$fblink,$country,$type)
	{
		$c_id='';
		$q="select * from country where c_name='".$country."'";

		$m=mysqli_query($this->con,$q);
		while ($row = $m->fetch_assoc()) 
		{
			$c_id = $row['c_id'];
		}

		$ename="update schoolinfo";
		$vars="";
		
		if($name!="")
		{
			if($vars=="")
			{
				$vars.=" set s_name='".$name."'";
			}
			else
			{
				$vars.=",s_name='".$name."'";
			}
		}
		
		if($email!="")
		{
			if($vars=="")
			{
				$vars.=" set email='".$email."'";
			}
			else
			{
				$vars.=",email='".$email."'";
			}
		}
		
		if($webname!="")
		{
			if($vars=="")
			{
				$vars.=" set website='".$webname."'";
			}
			else
			{
				$vars.=",website='".$webname."'";
			}
		}
		
		if($cntc!="")
		{
			if($vars=="")
			{
				$vars.=" set contact='".$cntc."'";
			}
			else
			{
				$vars.=",contact='".$cntc."'";
			}
		}
		
		if($city_id!="")
		{ $city_id = '1';
			if($vars=="")
			{
				$vars.=" set city_id='".$city_id."'";
			}
			else
			{
				$vars.=",city_id='".$city_id."'";
			}
		}
		
		if($address!="")
		{
			if($vars=="")
			{
				$vars.=" set address='".$address."'";
			}
			else
			{
				$vars.=",address='".$address."'";
			}
		}
		
		if($fblink!="")
		{
			if($vars=="")
			{
				$vars.=" set fb_link='".$fblink."'";
			}
			else
			{
				$vars.=",fb_link='".$fblink."'";
			}
		}
		
		if($type!="")
		{
			if($vars=="")
			{
				$vars.=" set type='".$type."'";
			}
			else
			{
				$vars.=",type='".$type."'";
			}
		}
		
		if($country!="")
		{ $c_id = '157';
			if($vars=="")
			{
				$vars.=" set c_id=".$c_id;
			}
			else
			{
				$vars.=",c_id=".$c_id;
			}
		}
		
		$ename.=$vars;
		$ename.=" where s_id=".$id;
		/* echo $ename; exit;  */
		if(mysqli_query($this->con, $ename))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function getschlist($cid,$sel)
	{
		$q="select s_name,s_id from schoolinfo where ";
		
		switch($sel)
		{
			case 'all':
			$q.="";
			break;
			case 'wb' :
			$q.="website<>'' and ";
			break;
			case 'wbn' :
			$q.="website='' and ";
			break;
		}
		$q.="c_id=$cid";

		$m=mysqli_query($this->con, $q);

		//$school_list = array();	

		while ($row = $m->fetch_assoc()) 
		{
			$school_list[] = $row;
		}	
		return $school_list;
	}

	public function getEmail($id,$tid)
	{
		$q="select stpt from country,schoolinfo where schoolinfo.c_id=country.c_id and s_id=".$id;
		$m=mysqli_query($this->con,$q);
		
		while($row = $m->fetch_assoc()) 
		{
			$stpt = $row['stpt'];
		}
		
		$enpt=$stpt+50;
		
		$p="select email,s_id from schoolinfo where ".$tid." not in (t_id) and s_id=".$id."  limit ".$stpt.",".$enpt."";
		$m=mysqli_query($this->con,$p);
		$rowcount=mysqli_num_rows($m);
		
		if($rowcount > 0)
		{
			$school_name=array();
			
			while ($row = $m->fetch_assoc()) 
			{
				$school_name = $row;
			}
			return $school_name;
		}
		else
		{
			return false;
		}
	}
}
?>