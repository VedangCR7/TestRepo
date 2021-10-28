<?php include 'header.php'; ?>
	
<?php include "connection.php";

if (isset($_POST['f_name'])) {

    $f_name = $_POST['f_name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $full_address = $_POST['full_address'];
    $landmark = $_POST['landmark'];
    $city = $_POST['city'];
    $postal_code = $_POST['postal_code'];
    $customer_id = $_SESSION['user_id'];


    $sql1="SELECT * FROM `customer_address` WHERE email='$email' AND contact_number ='$phone'";


    $result = mysqli_query($conn, $sql1);


    /*if account already exist*/
    if (mysqli_num_rows($result) > 0) { 

        $errorMessge="Oops !!! Address Already Exist...";

    }else{

        $sql = "INSERT INTO customer_address (customer_id, name, email, contact_number, city, landmark, postal_code, complete_address)
        VALUES ('$customer_id','$f_name', '$email', '$phone', '$city', '$landmark','$postal_code', '$full_address')";

        if (mysqli_query($conn, $sql)) {
            
            echo '<script>window.location = "address.php?msg="+"scs"</script>';

        }else{

            echo '<script>window.location = "address.php?msg="+"fail"</script>';
            echo mysqli_query($conn, $sql);
        }


    }


}

?>  



	<main>
		<div class="page_header element_to_stick">
		    <div class="container">
		    	<div class="row">
		    		<div class="col-xl-8 col-lg-7 col-md-7 d-none d-md-block">
		        		<h1>Top Restaurant Nearest You</h1>
		        		<a href="addnewaddress.php">Change address</a>
		    		</div>
		    		<div class="col-xl-4 col-lg-5 col-md-5">
		    			<div class="search_bar_list">
							<input type="text" class="form-control" placeholder="Dishes, restaurants or cuisines">
							<button type="submit"><i class="icon_search"></i></button>
						</div>
		    		</div>
		    	</div>
		    	<!-- /row -->		       
		    </div>
		</div>
		<!-- /page_header -->

		<div class="container margin_30_20">			
			<div class="row">
			
			<?php include 'ac_sidebar.php'; ?>
				

				<div class="col-lg-9">
                    <div class="account_table mt-4">

                        <div style="text-align: center">
                    <span style="color:red;"><b>

                    <?php

                    if(isset($errorMessge)){
                    echo $errorMessge;
                    $errorMessge="";
                    } ?></b>

                    </span>
                    </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <h4 class="accounttable_heading mb-4"><i class="icon_pin_alt"></i> Add new address</h4>
                            </div>
                            <div class="col-lg-6">
                                <a href="address.php" class="goldenbtns float-right">Add new address</a>
                            </div>
                        </div>
                    </div>
                                      <form id="address_form" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                    <div class="main mt-5">
                        <div class="form-group">
                            <label>First Name and Last Name</label>
                            <input class="form-control" name="f_name" id="f_name"  placeholder="FirstName" autocomplete="off">
                            <p style="color:red;" id ="f_name_error"></p>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input class="form-control" name="email" id="email"  placeholder="Email Address" autocomplete="off">
                                    <p style="color:red;" id ="email_error"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input class="form-control" name="phone" id="phone" type="number"  placeholder="Phone" autocomplete="off">
                                    <p style="color:red;" id ="phone_error"></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Full address</label>
                                    <input class="form-control" name="full_address" id="full_address"  placeholder="Full Address" autocomplete="off">
                                    <p style="color:red;" id ="full_address_error"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Landmark</label>
                                    <input class="form-control" name="landmark" id="landmark"  placeholder="Enter Landmark Address" autocomplete="off">
                                    <p style="color:red;" id ="landmark_error"></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>City</label>
                                    <input class="form-control txtOnly" name="city" id="city" placeholder="City Address" required autocomplete="off">
                                    <p style="color:red;" id ="city_error"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Postal Code</label>
                                    <input class="form-control" name="postal_code" type="number" id="postal_code"  placeholder="Postal Code" required >
                                    <p style="color:red;" id="postal_code_error"></p>
                                </div>
                            </div>
                        </div>
                        <button class="medium mt-4 btn_1 plus_icon" id="save_btn">Save Changes</button>
                    </div>
                    </form>
				</div>
				<!-- /col -->
			</div>		
		</div>
		<!-- /container -->
		
	</main>

<?php include 'footer.php'; ?>



<script type="text/javascript">

function isEmail(emailid) {
    var pattern = new RegExp(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);
    return pattern.test(emailid);
}



 $('#f_name').focusout(function() {
    var f_nameValue = $(this).val();
    if (f_nameValue == '') {
        $(' #f_name').addClass('has-error');
        $(' #f_name_error').show().text("Enter Full Name*");
         return false;
       
    }  else if (f_nameValue != '') {
        $(' #f_name').removeClass('has-error');
        $(' #f_name_error').hide().text('');
        return true;
       
    }
});


 $('#email').focusout(function() {
var mailValue = $(this).val();            
if ((mailValue == '') || (!isEmail($('#email').val()))) {
    $('#email').addClass('has-error');
    $('#email_error').show().text("Invalid Email Address*");
     return true;
    } 
    else if ((mailValue != '') && (isEmail($('#email').val()))) {
    $('#email').removeClass('has-error');
    $('#email_error').hide().text('');
    return false;
   

}
});

 $('#phone').focusout(function() {
    var phoneValue = $(this).val();
    
    if (phoneValue == '') {
        $(' #phone').addClass('has-error');
        $(' #phone_error').show().text("Enter phone*");
        return false;
       
    }else if(phoneValue.length < 10 || phoneValue.length > 11){
       
        $(' #phone').addClass('has-error');
        $(' #phone_error').show().text("Enter Valid phone number should be between 10 Charactars*");
        return false;
        
    }
    else if (phoneValue != '') {
        $(' #phone').removeClass('has-error');
        $(' #phone_error').hide().text('');
         return true;
       
    }
});


$('#full_address').focusout(function() {
    var full_addressValue = $(this).val();
    if (full_addressValue == '') {
        $(' #full_address').addClass('has-error');
        $(' #full_address_error').show().text("Enter Full Address*");
        return false;
       
    }  else if (full_addressValue != '') {
        $(' #full_address').removeClass('has-error');
        $(' #full_address_error').hide().text('');
        return true;
       
    }
});


 $('#landmark').focusout(function() {
    var landmarkValue = $(this).val();
    if (landmarkValue == '') {
        $(' #landmark').addClass('has-error');
        $(' #landmark_error').show().text("Enter Landmark*");
        return false;
       
    }  else if (landmarkValue != '') {
        $(' #landmark').removeClass('has-error');
        $(' #landmark_error').hide().text('');
         return true;
       
    }
});

 $('#city').focusout(function() {
    var cityValue = $(this).val();
    if (cityValue == '') {
        $(' #city').addClass('has-error');
        $(' #city_error').show().text("Enter city*");
        return false;
       
    }else if (cityValue != '') {
        $(' #city').removeClass('has-error');
        $(' #city_error').hide().text('');
        return true;
    }
});


 $('#postal_code').focusout(function() {
    var postal_codeValue = $(this).val();
    if (postal_codeValue == '') {
        $(' #postal_code').addClass('has-error');
        $(' #postal_code_error').show().text("Enter Postal code*");
        return false;
       
    }else if (postal_codeValue != '') {
        $(' #postal_code').removeClass('has-error');
        $(' #postal_code_error').hide().text('');
        return true;
    }
});


  $("#save_btn").click(function(e){
    e.preventDefault();
    var f_name=$("#f_name").val();
    var email=$("#email").val();
    var phone=$("#phone").val();
    var full_address=$("#full_address").val();
    var landmark=$("#landmark").val();
    var city=$("#city").val();
    var postal_code=$("#postal_code").val();

    $("#f_name").trigger('focusout');
    $("#email").trigger('focusout');
    $("#phone").trigger('focusout');
    $("#full_address").trigger('focusout');
    $("#landmark").trigger('focusout');
    $("#city").trigger('focusout');
    $("#postal_code").trigger('focusout');

        if((f_name != '') && (isEmail(email))  && (full_address!='')  && (phone!='')  && (landmark!='')  && (city!='')  && (postal_code!='')){
            console.log("register_btn")
            $("#address_form").submit();
            return true;
        }else{
            console.log(name);console.log(phone);console.log(email);console.log(password);
            console.log("Something went wrong");
            return false;
        }
  })
    
    
    
    $('.txtOnly').keypress(function (e) {
        var regex = new RegExp("^[a-zA-Z]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        
        if (regex.test(str)) {
            return true;
        }
        else
        {
            e.preventDefault();
            $('#city_error').show();
            $('#city_error').text('Please Enter Alphabate');
            return false;
        }
    });
    
    
    
    
    
    
    
    
    
</script>
