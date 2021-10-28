<?php
	
	/* ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL); */
	
	include('connection.php');
	
	/* $restaurant_lists = $this->Waiting_manager_model->select_where('user',['usertype'=>'Restaurant']); */
	
	$query = "SELECT * from user where usertype='Restaurant'";
	$restaurant_lists=mysqli_query($conn,$query);

	while($restaurant_data=mysqli_fetch_assoc($restaurant_lists))
	{
		$timezone = get_time_zone($restaurant_data['country']);
	
		if ($timezone)
		{
			date_default_timezone_set("'".$timezone."'");
		}
		else
		{
			date_default_timezone_set("Asia/Kolkata");
		}

		$restaurant_data['id'];
		$date = date('Y-m-d');
		$time = strtotime(date('H:i'));
		$close_time = strtotime($restaurant_data['close_time']);
		
		if($time > $close_time)
		{
			$occupied_query = "select * from table_orders where flag='N' AND restaurant_id = '".$restaurant_data['id']."' AND insert_date<='".$date."'";
			$occupied_orders=mysqli_query($conn,$occupied_query);
			
			while($value=mysqli_fetch_assoc($occupied_orders))
			{
				/* $orders = $this->Waiting_manager_model->select_where('orders',['table_id'=>$value['table_id']]); */
				
				$orders_query = "select * from orders where table_id = ".$value['table_id'];
				$orders=mysqli_query($conn,$orders_query);
				
				$flag = 0;
				
				while($row=mysqli_fetch_assoc($orders))
				{				
					if($row['status'] == 'New' || $row['status'] == 'Confirmed' || $row['status'] == 'Assigned To Kitchen')
					{
						$flag = 1;
						if($row['is_invoice'] == 1)
						{
							/* $this->Waiting_manager_model->updateactive_inactive('orders',['table_id'=>$row['table_id'],'table_orders_id'=>$row['table_orders_id']],['status'=>'Completed']); */
				
							$update_query="update orders set status='Completed' where table_id = '".$value['table_id']."' AND table_orders_id='".$row['table_orders_id']."'";
							$update_result=mysqli_query($conn,$update_query);
						}
						else
						{
							/* $this->Waiting_manager_model->updateactive_inactive('orders',['table_id'=>$row['table_id'],'table_orders_id'=>$row['table_orders_id']],['status'=>'Canceled','cancel_note'=>'Timeout']); */
							$update_query="update orders set status='Canceled',cancel_note='Timeout' where table_id = '".$value['table_id']."' AND table_orders_id='".$row['table_orders_id']."'";
							$update_result=mysqli_query($conn,$update_query);
						}
					}
				}

				if($flag == 1)
				{
					$update_query1="update table_details set is_available='1' where id = '".$value['table_id']."'";
					$update_result1=mysqli_query($conn,$update_query1);
					
					$update_query2="update table_orders set flag='Y' where id = '".$value['table_id']."'";
					$update_result2=mysqli_query($conn,$update_query2);
					
					/* $this->Waiting_manager_model->updateactive_inactive('table_details',['id'=>$value['table_id']],['is_available'=>1]);
					$this->Waiting_manager_model->updateactive_inactive('table_orders',['id'=>$value['table_id']],['flag'=>'Y']); */
				}
				echo 'Cron call sucessfully.';
			}
		}
		echo 'Cron call.';
	}
	
	function get_time_zone($country)
	{
		$timezone = null;
		switch ($country) {
			case "India":
				$timezone = "Asia/Kolkata";
				break;
			case "INDIA":
				$timezone = "Asia/Kolkata";
				break;
			case "Dubai":
				$timezone = "Asia/Dubai";
				break;  
			case "USA":
				$timezone = "America/New_York";
				break; 
			case "USA":
				$timezone = "America/New_York";
				break; 
			case "Greece":
				$timezone = "Europe/Athens";
				break;			
			case "GREECE":
				$timezone = "Europe/Athens";
				break; 
			case "United Kingdom":
				$timezone = "Europe/London";
				break;  
			case "UK":
				$timezone = "Europe/London";
				break;        
		}
		return $timezone;
	}