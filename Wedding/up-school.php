<?php
//ini_set("display_errors",1);
//ini_set(ERROR_REPORTING,E_ALL);
require_once 'School.php';
//require_once 'Country.php';

$s_id=$_POST['s'];
//$c=new Country;
$s=new School;	
$list=$s->fetchSchool($s_id);

$list["success"]="success";
		 echo json_encode($list);
	
	
//	$list1=array();
	//$list1=$s->fetchSchool($s_id);
	
?>