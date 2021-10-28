<?php
//ini_set("display_errors",1);
//ini_set(ERROR_REPORTING,E_ALL); 
error_reporting(0);
require_once 'School.php';

$cid=$_POST['cid'];
$sel=$_POST['sel'];
 //.echo $cid." ".$sel;
$obj=new School;
$list=$obj->getschlist($cid,$sel);
//print_r($list);
//exit;
echo json_encode($list);

?>