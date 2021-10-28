<?php
include "connection.php";
$query="DELETE FROM add_to_cart WHERE id=".$_POST['cart_id'];
mysqli_query($conn,$query);

echo json_encode(['status'=>true]);

?>