<?php include "connection.php"; ?>

<?php 
// $query = "SELECT id,business_name as name from user where usertype='Restaurant' AND business_name != ''";
$query = "SELECT postcode as id , address as name FROM `user` WHERE address LIKE '%".$_GET['search']."%' OR city like '%".$_GET['search']."%' OR postcode like '%".$_GET['search']."%' GROUP BY address";
$restaurant=mysqli_query($conn,$query);
$restaurant_array=array();
while($restaurants=mysqli_fetch_assoc($restaurant))
{
	if(is_null($restaurants['id'])!=1 && is_null($restaurants['name'])!=1)
	{
		$restaurant_array[]= $restaurants;
	}
}
echo json_encode($restaurant_array);
?>