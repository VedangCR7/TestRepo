<?php
//ini_set("display_errors",1);
//ini_set(ERROR_REPORTING,E_ALL);
session_start();


$uname=$_POST['uname'];
$pwd=$_POST['pwd'];
//echo $uname." ".$pwd;
//exit;

if($uname == 'admin' && $pwd == 'password'){
	$_SESSION["login"] = 'true';
	//echo $_SESSION["login"];
	echo "ok";
}
//echo $_SESSION['login'];
//exit;
else{
	echo "error";
}
//echo $uname." ".$pwd;



?>