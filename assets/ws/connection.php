<?php		
	$con=mysqli_connect('localhost','foodnaic_test','leomessi10@argentina',' FOODNAI_TEST');
	
	/* Check connection */
	if ($con)
	{
		echo "Connection Done";
	}	
	else if(!$con){
		die("Connection error: " . mysqli_connect_errno());
	}
?>