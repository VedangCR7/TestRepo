<?Php
require_once('mailer/class.phpmailer_bg.php');
require_once 'School.php';

$sub=$_POST['sub'];
$msg=$_POST['msg'];
$id=$_POST['id'];
//echo $sub." ".$msg." ".$id;
$obj=new School;
$list=$obj->getEmail($id);
//print_r($list);

$email_id = "admin@rslinfotech.in";         
			$mail = new PHPMailer();
			$mail->IsSMTP();
			$mail->SMTPDebug = 1;
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = 'tls';
			$mail->Host = "mail.rslinfotech.in";
			$mail->Port = 587;
			$mail->IsHTML(true);
			$mail->Username = "admin@rslinfotech.in";
			$mail->Password = "rsladmin@123";
			$mail->SetFrom($email_id,$email_id);
			$mail->Subject = $sub;
			$mail->Body = $msg;
			$addresses = explode(',', $list);
			foreach ($addresses as $address) {
				$mail->AddAddress($address);
			}
			//$mail->AddAddress($to);
			//$mail->Timeout = 600;
			if($mail->Send()){
			echo "ok";
			}
			

?>