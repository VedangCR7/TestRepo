<?php 
//ini_set("display_errors",1);
//ini_set(ERROR_REPORTING,E_ALL);
require_once 'School.php';

$id=(int)$_POST['sid'];
$name=base64_encode($_POST['name']);
$email=$_POST['email'];
$webname=$_POST['webname'];
$cntc=$_POST['cntc'];
$city_id=$_POST['city_id'];
$address=$_POST['address'];
$fblink=$_POST['fblink'];
$country=$_POST['coun'];
$type=$_POST['s_type'];

echo "ID : ".$id." Name : ".$name." Email : ".$email." Webname : ".$webname." Contact : ".$cntc." City : ".$city_id." Address : ".$address." FB : ".$fblink." Country : ".$country." Type : ".$type;

$obj=new School; 

if($obj->update($id,$name,$email,$webname,$cntc,$city_id,$address,$fblink,$country,$type)){
  echo "ok";
}
else{
  echo "error";
} 
?>