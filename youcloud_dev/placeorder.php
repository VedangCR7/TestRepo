<?php
include "connection.php";
//print_r($_POST);
$query = "SELECT * FROM user
WHERE id=".$_POST['restaurant_id'];
$restaurant=mysqli_query($conn,$query);

$restaurants=mysqli_fetch_assoc($restaurant);
$delivery_area=$_POST['delivery_area'];
$complete_address=$_POST['complete_address']." ".$_POST['post_code'];
$nickname="Home";
$customer_id = $_POST['customer_id'];
$name=$_POST['full_name'];
$cust_contact_number=$_POST['contact_number'];
$sql = "INSERT INTO `customer_address`( `delivery_area`, `complete_address`, `nickname`, `customer_id`, `name`, `contact_number`) VALUES ('$delivery_area','$complete_address','$nickname','$customer_id','$name','$cust_contact_number')";

        if (mysqli_query($conn, $sql)) {
            $lastid = mysqli_insert_id($conn); 
            $customer_address_id = $lastid;

        }


$query = "SELECT * FROM table_details
WHERE title='Website' AND is_active=1 AND is_delete=0 AND logged_user_id=".$_POST['restaurant_id'];
$table=mysqli_query($conn,$query);

$tables=mysqli_fetch_assoc($table);


$date=date('Y-m-d');
$time=date('H:i:s');
$restaurant_id = $_POST['restaurant_id'];
$customer_id = $_POST['customer_id'];
$sub_total=$_POST['sub_total'];
$table_id=$tables['id'];
$sql = "INSERT INTO `table_orders`( `table_id`, `flag`, `restaurant_id`, `insert_date`, `insert_time`, `order_type`) VALUES ('$table_id','N','$restaurant_id','$date','$time','Online')";

        if (mysqli_query($conn, $sql)) {
            $lastid = mysqli_insert_id($conn); 
            $table_orders_id = $lastid;

        }

$restaurant_name=$restaurants['name'];
$intial=strtoupper(substr($restaurant_name, 0, 2));
$formated_id=str_pad($table_orders_id, 6, '0', STR_PAD_LEFT);
$created_id=$intial.$formated_id;
$query ="UPDATE `table_orders` SET `table_orderno`='$created_id' WHERE id=".$table_orders_id;

$table=mysqli_query($conn,$query);
$created_at_date = date('Y-m-d H:i:s');
$supply_option=$_POST['supply_option'];
if($supply_option == 'Delivery'){
    $paid='Paid';
}else{
    $paid='Unpaid';
}

$sql = "INSERT INTO `orders`( `customer_id`, `sub_total`, `disc_total`, `net_total`, `table_id`, `status`, `created_at`, `rest_id`, `table_orders_id`,`supply_option`,`delivery_payment`,`customer_address_id`) VALUES ('$customer_id','$sub_total','0','$sub_total','$table_id','New','$created_at_date','$restaurant_id','$table_orders_id','$supply_option','$paid','$customer_address_id')";

        if (mysqli_query($conn, $sql)) {
            $lastid = mysqli_insert_id($conn); 
            $order_id = $lastid;

        }
        
$intial=strtoupper(substr($restaurant_name, 0, 2));
$formated_id=str_pad($order_id, 6, '0', STR_PAD_LEFT);
$created_id=$intial.$formated_id;
$query ="UPDATE `orders` SET `order_no`='$created_id' WHERE id=".$order_id;
$upate_order_no=mysqli_query($conn,$query);
$query = "SELECT r.*,atc.qty FROM add_to_cart as atc
LEFT JOIN recipes as r on r.id=atc.recipe_id
WHERE atc.customer_id=".$_POST['customer_id']." AND atc.restaurant_id=".$_POST['restaurant_id'];
$recipe=mysqli_query($conn,$query);
$recipe_array=array();
while($recipes=mysqli_fetch_assoc($recipe))
{
    $total = $recipes['price']*$recipes['qty'];
    $recipeid =$recipes['id'];
    $recipeqty =$recipes['qty'];
    $recipeprice =$recipes['price'];
	$sql = "INSERT INTO `order_items`(`order_id`, `recipe_id`, `qty`, `price`, `total`, `disc`, `disc_amt`, `sub_total`) VALUES ('$order_id','$recipeid','$recipeqty','$recipeprice','$total','0','0','$total')";

    mysqli_query($conn, $sql);
}

$query="DELETE FROM `add_to_cart` WHERE restaurant_id=".$restaurant_id." AND customer_id=".$customer_id;
$deleteadd_to_cart=mysqli_query($conn,$query);
echo json_encode(['status'=>true,'order_no'=>$created_id]);
?>