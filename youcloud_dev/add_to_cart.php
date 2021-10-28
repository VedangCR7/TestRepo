<?php include "connection.php";
        $restaurant_id = $_POST['restaurant_id'];
        $customer_id = $_POST['customer_id'];
        $recipe_id = $_POST['recipe_id'];
        $qty = $_POST['qty'];
        
        if(!empty($_POST['optionsArray'])){
          
          $extra_options = implode(',',$_POST['optionsArray']);
            
        }else{
            
          $extra_options = '';
          
        }
        
        $sql = "INSERT INTO add_to_cart (restaurant_id, customer_id, recipe_id, qty,extra_options)
        VALUES ('$restaurant_id','$customer_id', '$recipe_id', '$qty','$extra_options')";

        if (mysqli_query($conn, $sql)) {
            
            echo json_encode(['status'=>true]);

        }
        
?>