<?php
require 'Template.php';

$t_id=$_POST["tid"];

$obj=new Template;
if($obj->deleteTemplate($t_id)){
	echo "ok";
}
else{
	echo "error";
}	
?>