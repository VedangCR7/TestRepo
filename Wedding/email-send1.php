<?php
//ini_set("display_errors",1);
//ini_set(ERROR_REPORTING,E_ALL); 
require_once('mailer/class.phpmailer_bg.php');
//require_once 'Email.php';
require_once 'Template.php';
require_once 'School.php';
require_once 'Email.php';


$sch=$_POST['sch'];
$tid=$_POST['imgid'];
//echo $tid;
//print_r($sch);
//exit;
$sname=array();
$s=new School;
for($i=0;$i<count($sch);$i++){
	$sname[$i]=$s->getEmail($sch[$i],$tid);
}
//print_r($sname);
//exit;

$schid=array();

$b=new Template;
$file=$b->getFile($tid);
if($file){
include_once("Templates/".$file.".php");
$data=$mailData;
//echo $data;
//exit;

 //$obj=new Email;
 //$slist=$obj->selectSchool($cid,$tid);

 if($sname){
	for($i=0;$i<count($sname);$i++){
	
		if($sname[$i]['email']!=''){
		//	$to = $slist[$i]['email'];
			
			/*$to = "atul27salunkhe@gmail.com";*/
			$email_id = "admin@rslinfotech.in";         
			$mail = new PHPMailer();
			$mail->IsSMTP();
			$mail->SMTPDebug = 1;
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = '';
			$mail->Host = "mail.rslinfotech.in";
			$mail->Port = 587;
			$mail->IsHTML(true);
			$mail->Username = "admin@rslinfotech.in";
			$mail->Password = "rsladmin@123";
			$mail->SetFrom($email_id,$email_id);
			$mail->Subject = "Sending Template";
			$mail->Body = $data;
			$addresses = explode(',', $sname[$i]['email']);
			foreach ($addresses as $address) {
				$mail->AddAddress($address);
			}
			//$mail->AddAddress($to);
			//$mail->Timeout = 600;
			 $mail->Send();
			array_push($schid,$sname[$i]['s_id']);
		
		
		}else{
			echo "no";
		}
		
	}

	$idsForEdit=implode(",",$schid);
	$obj=new Email;
	if($obj->updateTid($tid,$idsForEdit))
		echo "ok";
 }else{
	 echo "error";
 }
}else{
	 echo "erro2";
 }
//exit;
?>