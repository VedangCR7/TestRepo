<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>

<form enctype="multipart/form-data" name='mailform1' id='mailform1' action="mailer.php" method="post">
	<table>
	
		<tr>
			<td>To.</td>
			<td><input type='text' name='toMail' id='toMail' maxlength='64' /></td>
		</tr>
		
		<tr>
			<td>From.</td>
			<td><input type='text' name='fromMail' id='fromMail' maxlength='64' /></td>
		</tr>	
		
		<tr>
			<td>Subject.</td>
			<td><input type='text' name='subject' id='subject' maxlength='64' /></td>
		</tr>	
		
		<tr>
			<td>Attachement.</td>
			<td><input type='file' name='attach' id='attach' maxlength='64' /></td>
		</tr>
		
		<tr>
			<td>Message.</td>
			<td><textarea name='messageBody' id='messageBody' cols="50" rows="10" ></textarea></td>
		</tr>
		
		<tr>
			<td>&nbsp;</td>
			<td><input type='submit' name='sendMail' id='sendMail' value='Send' /></td>
		</tr>
		
	</table>
</form>


</body>
</html>