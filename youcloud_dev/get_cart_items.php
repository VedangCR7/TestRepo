<?php include "connection.php";
//print_r($_POST);

$query = "SELECT r.*,atc.qty,atc.id as cart_id FROM add_to_cart as atc
LEFT JOIN recipes as r on r.id=atc.recipe_id
WHERE atc.customer_id=".$_POST['customer_id']." AND atc.restaurant_id=".$_POST['restaurant_id'];
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