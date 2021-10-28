<?php 

include "connection.php";


if(!empty($_POST) && isset($_POST['reciepie_id'])){

    $reciepie_id = $_POST['reciepie_id'];
    
    $reciepie_selectSQL = "SELECT * FROM recipes WHERE id='$reciepie_id'";
    
    $reciepie_getDataArr = mysqli_query($conn, $reciepie_selectSQL);
    
    $response_array = array();
    
    while($reciepie_data = mysqli_fetch_assoc($reciepie_getDataArr))
    {
        
        $reciepie_id = $reciepie_data['id'];
        
        $addon_menu_selectSQL = "SELECT * FROM addon_menu WHERE menu_id='$reciepie_id'";
        
        $addon_menu_getDataArr = mysqli_query($conn, $addon_menu_selectSQL);
        
        $addonData = array();
        $addonMenuOptionsData = array();
        while($addon_menu_Data = mysqli_fetch_assoc($addon_menu_getDataArr))
        {
            
            $addon_menu__id = $addon_menu_Data['id'];
            
            $addon_menu_opt_selectSQL = "SELECT * FROM addon_menu_option WHERE addon_menu_id='$addon_menu__id'";
            
            $addon_menu_opt_getDataArr = mysqli_query($conn, $addon_menu_opt_selectSQL);
            
            
            while($addon_menu_opt_Data = mysqli_fetch_assoc($addon_menu_opt_getDataArr))
            {
            
                array_push($addonMenuOptionsData,$addon_menu_opt_Data);
            
            }
            
            
            
          array_push($addonData,$addon_menu_Data);
          
        }
        
        
        $response_array['addons_data'] = $addonData;
        $response_array['addonMenuOptions_data'] = $addonMenuOptionsData;
        $response_array['reciepie_data'] = $reciepie_data;
        

        
    }
    
    /*request response data*/
    echo json_encode($response_array);
    // die();  

    
}

/*marked as default action*/

if(!empty($_POST) && isset($_POST['action']) && $_POST['action']=="markedAddressAsDefault"){

    $updateId = $_POST['updateId'];
    
    
    $selectSQL = "SELECT * FROM customer_address WHERE id='$updateId'";
    
    $getDataArr = mysqli_query($conn, $selectSQL);
    
    $response_array = array();
    
    while($address_data = mysqli_fetch_assoc($getDataArr))
    {
        
        $is_marked_as_default = $address_data['marked_as_default'];
        $lastRecordId = $address_data['id'];
        
        
        $query2 ="UPDATE `customer_address` SET `marked_as_default`=0 WHERE customer_id=".$_SESSION['user_id'];
        
        $query_Response2=mysqli_query($conn,$query2);
        
        /*if already not marked*/
        if($query_Response2){
            
            $query ="UPDATE `customer_address` SET `marked_as_default`=1 WHERE id=".$updateId;
            $query_Response=mysqli_query($conn,$query);
            
        }
      
        
        if($query_Response){

            /*request response data*/
            echo json_encode(['status'=>true,'message'=>'Address Marked As Default Successfully']);
            die();  

        }else{
            
            /*request response data*/
            echo json_encode(['status'=>false,'message'=>'Address Not Marked As Default']);
            die();  
            
        }
        



    }
    
  
    
}

  


?>