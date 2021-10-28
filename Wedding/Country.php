    <?php
require_once 'Connection.php';

class Country extends Connection
{

	public function __construct(){
		parent::__construct();
	}
	
	public function displayCountry(){
		$q="select c_name,c_id from country";
		//echo q;
		
		$m=mysqli_query($this->con,$q);
		print_r($m);
		while ($row = $m->fetch_assoc()) {
  $country_array[] = $row;
}
return $country_array;
	}
	
	public function displayTemplate(){
		$q="select t_id,t_img,t_file from template";
		//echo $q;
		$m=mysqli_query($this->con,$q);
		//print_r($m);
		while ($row = $m->fetch_assoc()) {
  $results_array[] = $row;
}
return $results_array;
	}
	
	public function getcnamebcid($c_id){
		$q="select c_name from country where c_id=".$c_id.";";
		//echo $q;
		$m=mysqli_query($this->con,$q);
		//print_r($m);
		if ($row=mysqli_fetch_array($m)) {
  $cname= $row;
}
return $cname;
	}
}
?>