    <?php
	//ini_set("display_errors",1);
require_once 'Connection.php';

class Email extends Connection
{

	public function __construct(){
		parent::__construct();
	}
	
	public function selectSchool($cid,$tid){
		$q="select stpt from country where c_id=".$cid;
		
		$m=mysqli_query($this->con,$q);
		while($row = $m->fetch_assoc()) {
			$stpt = $row['stpt'];
         }
		 $enpt=$stpt+50;
		$p="select s_name,email,s_id from schoolinfo,country where schoolinfo.c_id=country.c_id  and ".$tid." not in (t_id) and schoolinfo.c_id=".$cid."  limit ".$stpt.",".$enpt."";
	
		$m=mysqli_query($this->con,$p);
		$rowcount=mysqli_num_rows($m);
		if($rowcount > 0){
			$school_name=array();
		while ($row = $m->fetch_assoc()) {
  $school_name[] = $row;
}
return $school_name;
		}
		else{
			return false;
		}
	}
	
	public function updateTid($tid,$idsForEdit){
		$q="update schoolinfo set t_id=concat(t_id,',','".$tid."') where s_id in (".$idsForEdit.")";
		if(mysqli_query($this->con,$q)){
			return true;
		}
		else {
			return false;
		}
	}
}
?>