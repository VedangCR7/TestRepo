<?php include "connection.php"; ?>

<?php 
$query = "SELECT id,business_name as name,city from user where is_active = 1 AND usertype='Restaurant' AND business_name != '' AND id NOT IN(85,101,153,154) LIMIT 1000";
$restaurant=mysqli_query($conn,$query);
$restaurant_array=array();
while($restaurants=mysqli_fetch_assoc($restaurant)){
    $restaurant_array[]= $restaurants;
}

echo json_encode($restaurant_array);

?>