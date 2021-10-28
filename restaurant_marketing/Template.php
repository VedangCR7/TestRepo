<?php
require_once 'Connection.php';
class Template extends Connection
{
	public function __construct(){
	parent::__construct();
	}
	
	public function insert($t_name,$t_img,$t_file){
     $q="insert into template(t_name,t_img,t_file) values('$t_name','$t_img','$t_file');";
     //echo $q;
	 if(mysqli_query($this->con,$q)){
		 return true;
	 }
	 else{
		 return false;
	 }
}

public function displayTemplate(){
		$q="select t_id,t_name,t_img,t_file from template";
		//echo q;
		
		$m=mysqli_query($this->con,$q);
		//print_r($m);
		while ($row = $m->fetch_assoc()) {
  $template_array[] = $row;
}
return $template_array;
	}
	
	public function deleteTemplate($t_id){
     $q="delete from template where t_id=".$t_id;

	 if(mysqli_query($this->con,$q)){
		 return true;
	 }
	 else{
		 return false;
	 }
}

public function getFile($tid){
		$q="select t_file from template where t_id=".$tid;
		
		
		$m=mysqli_query($this->con,$q);
		//print_r($m);
		$temp='';
		while ($row = $m->fetch_assoc()) {
  $temp = $row['t_file'];
}
return $temp;
	}
	
}
?>