<?php
	header("Content-Type: text/html;charset=ISO-8859-1");
	//ini_set("display_errors",1);
	//ini_set(ERROR_REPORTING,E_ALL);

	require_once 'School.php';

	$name=base64_encode($_POST['name']);
	$email=$_POST['email'];
	$webname=$_POST['webname'];
	$cntc=$_POST['cntc'];
	$city_id=$_POST['city_id'];
	$address=$_POST['address'];
	$fblink=$_POST['fblink'];
	$country=$_POST['coun'];
	$type=$_POST['stype'];
	/* echo $name." ".$email." ".$webname." ".$cntc." ".$fblink." ".$country." ".$city_id;
	exit; */
	/* $comm=$_POST['comm'];
	$c_id=$_POST['coun']; */
	$rec_status="Inactive";

	$obj=new School;
	if($obj->insert($name,$email,$webname,$type,$cntc,$city_id,$address,$fblink,$rec_status,$country)){
	  echo "ok";
	}
	else
	{
	  echo "error";
	}
?>