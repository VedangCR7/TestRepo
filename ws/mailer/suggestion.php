<?php
	include('connection.php');
	

	
		//$news_id=$_REQUEST['news_id'];
	if(isSet($_REQUEST['type']))
	{
		$type=$_REQUEST['type'];
		$result = mysql_query("SET NAMES utf8");
		 $query="select * from suggestion where type = '$type' order by suggestion_id DESC";
		$result=mysql_query($query);
		 $count=mysql_num_rows($result);
		if($count > 0)
		{
			
			while($row=mysql_fetch_array($result))
			{
				
				$suggestion_id=$row['suggestion_id'];
				
				$name=$row['name'];
				$contact_number=$row['contact_number'];
				$location_name=$row['location_name'];
				$latitude=$row['latitude'];
				$longitude=$row['longitude'];
				$landmark=$row['landmark'];
				$website_name=$row['website_name'];
				$ratings=$row['ratings'];
				
				$query1="select * from suggestion_images where suggestion_id=".$suggestion_id;
				$result1=mysql_query($query1);
				$count1=mysql_num_rows($result1);
				$image = array();
				if($count1 > 0)
				{
					while($row1=mysql_fetch_array($result1))
					{
						
						$images=$row1['image'];

						$image[] = array('suggestion_image'=>$images);
					}
				}
				
				if(is_array($image))
				{
					
						$show1[] = array('suggestion_id'=>$suggestion_id,'name'=>$name,'contact_number'=>$contact_number,'location_name'=>$location_name,'latitude'=>$latitude,'longitude'=>$longitude,'landmark'=>$landmark,'website_name'=>$website_name,'ratings'=>$ratings,'image'=>$image);
					
				}
				else
				{
					$image=array();
					
					$show1[] = array('suggestion_id'=>$suggestion_id,'name'=>$name,'contact_number'=>$contact_number,'location_name'=>$location_name,'latitude'=>$latitude,'longitude'=>$longitude,'landmark'=>$landmark,'website_name'=>$website_name,'ratings'=>$ratings,'image'=>$image);
				}
			}
			if(is_array($show1))
			{
				$show = array('result'=>'success','data'=>$show1); 
				echo json_encode($show);
			}
			else
			{
				$show = array('result'=>'failed','msg'=>'information not found ');
				echo json_encode($show);
			}
			
		}
		else
		{
			$show = array('result'=>'failed','msg'=>'information not found');
			echo json_encode($show);
		}
	
	}
	else
	{
		$show = array('result'=>'failed','msg'=>'incomplete parameter');
				echo json_encode($show);
	}	
?>