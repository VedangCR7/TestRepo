<?php
require 'School.php';

$s_id=$_POST["sid"];

$obj=new School;
if($obj->deleteSchool($s_id)){
	echo "ok";
}
else{
	echo "error";
}	
?>