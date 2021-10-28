<?php include "connection.php"; ?>

<?php 


if(isset($_POST['full_name']) && isset($_POST['phone'])){

    $full_name=$_POST['full_name'];
    $mobile_number=$_POST['phone'];
    $country=$_POST['country'];
    $email=$_POST['email'];
    
    $is_accepted_terms_condition = $_POST['terms_condition'];
   
    
    // //checking already exits or not 
    
    // $sql="SELECT * FROM `customer` WHERE email ='$email'";
    
    // $result = mysqli_query($conn, $sql);
    
    // if(mysqli_num_rows($result) == 0) {   
    
    $sql="INSERT INTO `customer`(`name`, `contact_no`, `email`,`country`,  `cust_type`,`is_accepted_terms_condition`) VALUES ('$full_name','$mobile_number','$email','$country','2','$is_accepted_terms_condition')";

    $result = mysqli_query($conn, $sql);
    
    $last_id = mysqli_insert_id($conn);

      if ($result){   
    
        session_start();
    
        $_SESSION['user_id']=$last_id;
        // $_SESSION['userr_profile_image']="https://www.kindpng.com/picc/m/78-785827_user-profile-avatar-login-account-male-user-icon.png";
        $_SESSION['user_name']=$full_name;
        $_SESSION['user_type']="guest";
        

        if(!empty($_POST['restoname'])){
           
           $restoname = $_POST['restoname'];
           
           header("Location:restaurant_detail.php?restaurant_name=$restoname"); 
            
        }else{
            
            header("Location:index.php");
            
        }

      }else{
    
        $error="Something Went Wrong";
        
      }

    // }
    
    // else{

    //      $sql="UPDATE `customer` SET `name`='$full_name',`updated_at`=NOW() WHERE `email`='$email'";
      
    //     $result = mysqli_query($conn, $sql);
        
    //     session_start();
        
    //     $customer_selectSQL = "SELECT id,profile_image,name FROM `customer` WHERE email='$email'";
        
    //     $customer_DataArr = mysqli_query($conn, $customer_selectSQL);
        
    //     while($customer_Data = mysqli_fetch_assoc($customer_DataArr))
    //     {
    //         $customer_id = $customer_Data['id'];
        
    //         $_SESSION['user_id']=$customer_id;
    //         $_SESSION['userr_profile_image']=$customer_Data['profile_image'];
    //         $_SESSION['user_name']=$customer_Data['name'];
        
    //     }
    //     header("Location:account.php");


    // }
    
  

 
   

}




 ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Ansonika">
    <title>YouCloud</title>

    <!-- Favicons-->
    <link rel="shortcut icon" href="<?php echo $base_url; ?>/website_assets/webAssets/img/youcloud_faviccon.jpg" type="image/x-icon">
    <link rel="apple-touch-icon" type="image/x-icon" href="<?php echo $base_url; ?>/website_assets/webAssets/img/apple-touch-icon-57x57-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="<?php echo $base_url; ?>/website_assets/webAssets/img/apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="<?php echo $base_url; ?>/website_assets/webAssets/img/apple-touch-icon-114x114-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="<?php echo $base_url; ?>/website_assets/webAssets/img/apple-touch-icon-144x144-precomposed.png">

    <!-- GOOGLE WEB FONT -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- BASE CSS -->
    <link href="<?php echo $base_url; ?>/website_assets/webAssets/css/bootstrap_customized.min.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>/website_assets/webAssets/css/style.css" rel="stylesheet">

    <!-- SPECIFIC CSS -->
    <link href="<?php echo $base_url; ?>/website_assets/webAssets/css/order-sign_up.css" rel="stylesheet">

    <!-- YOUR CUSTOM CSS -->
    <link href="<?php echo $base_url; ?>/website_assets/webAssets/css/custom.css" rel="stylesheet">
    
    <!-- TELEPHONE CSS -->
    <!--<link href="<?php echo $base_url; ?>/website_assets/css/intlTelInput.css" rel="stylesheet">-->
    
    <link
     rel="stylesheet"
     href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"
   />
   
      <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
<style>
    .country-phone > div{width:100%;}
</style>
    
</head>

<body id="register_bg">
    
    <div id="register">
        <aside>
            <figure>
                <a href="index.php"><img src="<?php echo $base_url; ?>/website_assets/webAssets/img/logo_sticky.png" width="140" height="35" alt=""></a>
            </figure>
            <p class="text-center mt-4"><b><i>Customer Portal</i></b></p>
              <p>
                  <?php
             if(isset($error)){
                echo $error;
                $error="";
             }

             ?>
              </p>
                
            <form autocomplete="off" action="<?php echo $_SERVER['PHP_SELF'] ?>"  id="login_as_guest_form" method="POST">
                
                <input type="hidden" value='<?php echo $_GET["restoname"]; ?>' name="restoname">
                
                <div class="form-group">
                    <input class="form-control" type="text" placeholder="Enter your full name" required="" name="full_name" id="full_name">
                    <i class="icon_mail_alt"></i>
                    <p style="color:red;" id ="full_name_error"></p>
                </div>
                
                <div class="form-group country-phone">
                    <input id="phone" type="tel" class="form-control mobile_number" name="phone" />
                    <p style="color:red;" id ="phone_error"></p>
                </div>
     
                <!--<div class="form-group">-->
                <!--    <input class="form-control mobile_number" id="phonenew" type="tel" placeholder="Mobile No. Ex70000" required="" name="mobile_number">-->
                <!--    <i class="icon_pencil-edit"></i>-->
                <!--</div>-->
                <div class="form-group">
                    <input class="form-control" type="email" placeholder="Enter Email Id" name="email" required=""  id="email">
                    <i class="icon_mail_alt"></i>
                    <p style="color:red;" id ="email_error"></p>
                </div>
                <div class="clearfix add_bottom_15">
                    <div class="checkboxes float-left">
                        <label class="container_check">I Agree the terms and condition
                          <input type="checkbox" name="terms_condition"  id="terms_condition" value="1">
                          <span class="checkmark"></span>
                        </label>
                        <p style="color:red;" id ="terms_condition_error"></p>
                    </div>
                </div>
                <!--<a href="#0" class="btn_1 gradient full-width">Submit</a>-->
                <button class="btn_1 gradient full-width" id="submit_btn" >Submit</button>
                <!--Remove<div class="text-center mt-2"><small>New to YouCloud
                     <strong><a href="register.html">Create account</a></strong></small></div>-->
            </form>
            <!-- <div class="copy">© 2021 FooYes</div> -->
        </aside>
    </div>
    <!-- /login -->
    
    <!-- COMMON SCRIPTS -->
    <script src="<?php echo $base_url; ?>/website_assets/webAssets/js/common_scripts.min.js"></script>
    <script src="<?php echo $base_url; ?>/website_assets/webAssets/js/common_func.js"></script>
    <script src="<?php echo $base_url; ?>/website_assets/webAssets/assets/validate.js"></script>
    <!--<script src="<?php echo $base_url; ?>/website_assets/js/intlTelInput.js"></script>-->
    <script>
   const phoneInputField = document.querySelector("#phone");
   const phoneInput = window.intlTelInput(phoneInputField, {
    separateDialCode: true,
    preferredCountries:["in"],
    hiddenInput: "full",
     utilsScript:
       "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
   });
   
   
 </script>
  
  
  

<script type="text/javascript">

   	function isEmail(emailid) {
		var pattern = new RegExp(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);
		return pattern.test(emailid);
	}
   


 $('#full_name').focusout(function() {
    var full_nameValue = $(this).val();
    if (full_nameValue == '') {
        $(' #full_name').addClass('has-error');
        $(' #full_name_error').show().text("Enter full name*");
       
    }  else if (full_nameValue != '') {
        $(' #full_name').removeClass('has-error');
        $(' #full_name_error').hide().text('');
       
    }
});


 $('#phone').focusout(function() {
    var phoneValue = $(this).val();
    if (phoneValue == '') {
        $(' #phone').addClass('has-error');
        $(' #phone_error').show().text("Enter phone*");
       
    }  else if (phoneValue != '') {
        $(' #phone').removeClass('has-error');
        $(' #phone_error').hide().text('');
       
    }
});


$('#email').focusout(function() {
var mailValue = $(this).val();            
if ((mailValue == '') || (!isEmail($('#email').val()))) {
    $('#email').addClass('has-error');
    $('#email_error').show().text("Invalid Email Address*");
    } 
    else if ((mailValue != '') && (isEmail($('#email').val()))) {
    $('#email').removeClass('has-error');
    $('#email_error').hide().text('');
   

}
});


$('#submit_btn').click(function() {

    if(!$('#terms_condition').is(":checked")){
    
        $('#terms_condition_error').show().text("Please accept terms and conditions*");
    
    }else{
    
        $('#terms_condition_error').hide().text("");
        
    }

});

  $("#submit_btn").click(function(e){
  	e.preventDefault();
  	var full_name=$("#full_name").val();
  	var phone=$("#phone").val();
  	var email=$("#email").val();
  	var terms_condition = $('input[name="terms_condition"]:checked').val();
  	
  	
	$("#full_name").trigger('focusout');
	$("#phone").trigger('focusout');
	$("#email").trigger('focusout');
	

	if((full_name != '') && (isEmail(email)) && (phone!='') && terms_condition!==undefined){

        console.log("submit_btn");
        
        $("#login_as_guest_form").submit();

    }else{

      	console.log(full_name);console.log(phone);console.log(email);
      	console.log("Something went wrong")
    }
  })
	
</script>
  
  

  
  
</body>
</html>