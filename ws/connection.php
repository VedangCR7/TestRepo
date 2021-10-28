<?php		
	$con = mysqli_connect('localhost','foodnai_test','leomessi10@argentina','FOODNAI_TEST');
	
	/* Check connection */
	  $restoImg = 'https://testing.foodnai.com/admin/';
        # $restoImg = 'https://foodnai.com/admin';
		mysqli_set_charset( $con, 'utf8');
	if (!$con)
	{
		die("Connection error: " . mysqli_connect_errno());
	}	
	/* else{
		echo "Connection done";
	} */
?>