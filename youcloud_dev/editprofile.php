<?php include 'header.php';

$login_id = $_SESSION['user_id'];

$query = "SELECT * from customer where id='$login_id'";

$mysql=mysqli_query($conn,$query);

$userdata=mysqli_fetch_assoc($mysql);



if(isset($_POST['f_name'])) {





    /*profile upload code*/

    if (!empty($_FILES["fileToUpload"]["tmp_name"])) {

        $target_dir = "website_assets/uploads/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);

        if($check !== false) {

            // echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;

        } else {

            $errorMessge = "File is not an image.";
            $uploadOk = 0;

        }

        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            $errorMessge = "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"&& $imageFileType != "gif" ) {

            $errorMessge = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;

        }


        // Check if file already exists
        if (file_exists($target_file)) {

            unlink($target_file);
            
            $uploadOk = 1;
        }


        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {

          $errorMessge = "Sorry, your file was not uploaded.";

        // if everything is ok, try to upload file
        } else {

           $uploaded_file_name = $_FILES["fileToUpload"]["name"]; 

          if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
          } else {
            $errorMessge = "Sorry, there was an error uploading your file.";
          }
        }

    }else{
        /*if file not uploaded*/

        if ($userdata['profile_image']!=='') {

           $uploaded_file_name = $userdata['profile_image'];

        }else{

           $uploaded_file_name = '';

        }

    }

    /*profile_uplaod_codeEnds*/

    $successMessge='';
    $errorMessge='';

    $name = $_POST['f_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];
    $profile_img = $uploaded_file_name;

   $updateResponse = mysqli_query($conn,"UPDATE customer SET name = '$name', email = '$email', contact_no = '$phone', birth_date='$dob',profile_image='$profile_img' WHERE id = $login_id");

   if($updateResponse){

        echo '<script>window.location = "profile.php?msg="+"scs"</script>';

   }else{

        echo '<script>window.location = "profile.php?msg="+"failed"</script>';

   }

}







?>

    <!-- SPECIFIC CSS -->
    <link href="<?= $root_url; ?>/website_assets/webAssets/css/listing.css" rel="stylesheet">

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

				<?php include'ac_sidebar.php'; ?>

				<div class="col-lg-9">
                    <div class="account_table mt-4">
                        <div class="row">
                            <div class="col-lg-6">
                                <h4 class="accounttable_heading mb-4"><i class="icon_profile"></i> Edit Profile</h4>
                            </div>
                            <div class="col-lg-6">
                                <a href="profile.php" class="goldenbtns float-right">Back To Profile</a>
                            </div>
                        </div>
                    </div>

                    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" id="profile_form"  enctype="multipart/form-data">

                    <div class="main mt-5">



                        <label class="youcloud-profileimg mb-5">
                            <input type="file" name="fileToUpload" onchange="readURL(this);">
                            <div class="youcloud-profilecontent">
                                <img src="<?= $root_url; ?>/website_assets/uploads/<?php echo $userdata['profile_image']; ?>" id="blah">
                                <span>
                                    <i class="icon_camera"></i>
                                </span>
                            </div>
                        </label>

                        <div style="background-color: floralwhite;text-align: center;">
                            <span style="color:green;"><b>
                                <?php
                                    if(isset($successMessge)){
                                        echo $successMessge;
                                        $successMessge="";
                                    }
                                ?></b>
                            </span>
                        </div>

                        <div style="background-color: floralwhite;text-align: center;">
                                <span style="color:red;"><b>

                                <?php 

                                    if(isset($errorMessge)){
                                        echo $errorMessge;
                                        $errorMessge="";
                                    } ?>
                                </b>

                                </span>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Full Name</label>
                                    <input class="form-control" name="f_name" placeholder="" id="f_name" value="<?php if(isset($userdata['name'])){ echo $userdata['name']; } ?>" >

                                    <p id="f_name_error" style="color:red;"></p>    
                                </div>
                            </div>
                            <!--<div class="col-md-6">-->
                            <!--    <div class="form-group">-->
                            <!--        <label>Last Name</label>-->
                            <!--        <input class="form-control" name="l_name" placeholder="" id="l_name" value="<?php if(isset($userdata['l_name'])){ echo $userdata['l_name']; } ?>" >-->
                            <!--        <p id="l_name_error" style="color:red;"></p>-->
                            <!--    </div>-->
                            <!--</div>-->
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input class="form-control" name="email" placeholder="" id="email" value="<?php if(isset($userdata['email'])){ echo $userdata['email']; } ?>"  id="email">
                                    <p id="email_error" style="color:red;"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input class="form-control" id="phone" name="phone" placeholder="" value="<?php if(isset($userdata['contact_no'])){ echo $userdata['contact_no']; } ?>" >
                                    <p id="phone_error" style="color:red;"></p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Birth Date</label>
                            <input class="form-control" name="dob" id="dob" placeholder="Birth Date" type="date" value="<?php if(isset($userdata['birth_date'])){ echo  $userdata['birth_date']; } ?>"  >
                            <p id="dob_error" style="color:red;"></p>

                        </div>
                        <button class="medium mt-4 btn_1 plus_icon" id="update_btn">Save Changes</button>
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
        $('#f_name').addClass('has-error');
        $('#f_name_error').show().text("Enter First Name*");
       
    }  else if (f_nameValue != '') {
        $('#f_name').removeClass('has-error');
        $('#f_name_error').hide().text('');
       
    }
});


$('#l_name').focusout(function() {

    var l_nameValue = $(this).val();
    if (l_nameValue == '') {
        $('#l_name').addClass('has-error');
        $('#l_name_error').show().text("Enter Last Name*");
       
    }  else if (l_nameValue != '') {
        $('#l_name').removeClass('has-error');
        $('#l_name_error').hide().text('');
       
    }
});



$('#email').focusout(function() {

    var mailValue = $(this).val();

    if ((mailValue == '') || (!isEmail($('#email').val()))) {

        $('#email').addClass('has-error');
        $('#email_error').show().text("Invalid Email Address*");

        }else if ((mailValue != '') && (isEmail($('#email').val()))) {

        $('#email').removeClass('has-error');
        $('#email_error').hide().text('');

        }

});


 $('#phone').focusout(function() {
    var phoneValue = $(this).val();
    if (phoneValue == '') {
        $('#phone').addClass('has-error');
        $('#phone_error').show().text("Enter phone*");
       
    }  else if (phoneValue != '') {
        $('#phone').removeClass('has-error');
        $('#phone_error').hide().text('');
       
    }
});

 $('#dob').focusout(function() {

    var dobValue = $(this).val();

    console.log(dobValue);

    if (dobValue == '') {
        $('#dob').addClass('has-error');
        $('#dob_error').show().text("Select dob*");
       
    }  else if (dobValue != '') {
        $('#dob').removeClass('has-error');
        $('#dob_error').hide().text('');
       
    }

});


 $('#password1').focusout(function() {
    var passwordValue = $(this).val();
    if (passwordValue == '') {
        $('#password1').addClass('has-error');
        $('#password1_error').show().text("Enter password*");
       
    }  else if (passwordValue != '') {
        $('#password1').removeClass('has-error');
        $('#password1_error').hide().text('');
       
    }
});



  $("#update_btn").click(function(e){
    e.preventDefault();
    var f_name=$("#f_name").val();
    var l_name=$("#l_name").val();
    var email=$("#email").val();
    var phone=$("#phone").val();
    var dob=$("#dob").val();

    $("#f_name").trigger('focusout');
    $("#l_name").trigger('focusout');
    $("#email").trigger('focusout');
    $("#phone").trigger('focusout');
    $("#dob").trigger('focusout');



    if((f_name != '') && (l_name!='')  && (isEmail(email))  && (phone!='')  && (dob!='')){
        console.log("update_btn")
        $("#profile_form").submit();
      }else{
        console.log("Something went wrong")
      }
  })
    
</script>