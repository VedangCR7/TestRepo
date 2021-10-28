<?php
//ini_set("display_errors",1);
//ini_set(ERROR_REPORTING,E_ALL);
//ini_set("display_errors",0);
require('spreadsheet-reader-master/php-excel-reader/excel_reader2.php');
require('spreadsheet-reader-master/SpreadsheetReader.php');


//$obj=new Country;
$con=mysqli_connect("localhost","mywedreb_priya","priyanka@1234","mywedreb_Priyanka");

$Reader = new SpreadsheetReader('/home/mywedreb/public_html/rslschoolapp.com/School/Schoolss.xls');
	$Sheets = $Reader -> Sheets();

	foreach ($Sheets as $Index => $name)
	{
		
		echo 'Sheet #'.$Index.': '.$name;
	
	$Reader -> ChangeSheet($Index);

		
		$cnt=0;	
		if($name == "Cook Island"){
		foreach ($Reader as $row)
		{
			print_r($row);
			if($cnt>0 && $row[0]!="s_name" && !empty($row[0]) && $row[0]!="" ){
				$q="insert into schoolinfo(s_name,email,website,contact,fb_link,rec_status,c_id,t_id) values('".$row[0]."','".$row[1]."','".$row[2]."','".$row[3]."','".$row[4]."','".$row[5]."',119,'".$row[7]."');";
				echo $q.'<br>';
				
				
				if(mysqli_query($con,$q)){
					echo "imported";
				}
				else{
					echo "error";
				}
			}
			$cnt++;
		
			/*if($row[0]!="s_name" && !empty($row[0]) && $row[0]!=""){
				$q="insert into schoolinfo(s_name,email,website,contact,facebook_link,status,comments,rec_status,c_id) values('".$row[0]."','".$row[1]."','".$row[2]."','".$row[3]."','".$row[4]."','".$row[5]."','".$row[6]."','".$row[7]."','".$row[8]."');";
				if(mysqli_query($con,$q)){
					echo "imported";
				}
				
			}
			else{
					echo "error";
				}	*/			
		}
		
		}
		else{
			echo "stop importing";
		}
	 
	}

?>