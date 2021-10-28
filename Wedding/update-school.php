<?php 
//ini_set("display_errors",1);
//ini_set(ERROR_REPORTING,E_ALL);
require_once 'School.php';
$id=$_POST['sid'];
$name=$_POST['sname'];
$email=$_POST['semail'];
$webname=$_POST['swebname'];
$cntc=$_POST['scntc'];
$fblink=$_POST['sfblink'];
$country=$_POST['scoun'];
$type=$_POST['s_type'];
//$comm=$_POST['comm'];
//$c_id=$_POST['coun'];
//$rec_status="Inactive";


$obj=new School;

if($obj->update($id,$name,$email,$webname,$cntc,$fblink,$country,$type)){
  echo "ok";
}
else{
  echo "error";
}
?>