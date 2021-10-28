<?php
require_once('web_header.php');
require_once('sidebar.php');
?>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<style type="text/css">
.footer{
    display:none;
  }
  #back-to-top{
    display:none;
  }
	body{
		background-color: #F3F3F3;
	}
  li{
    list-style-type:none;
  }
  .menuname{
    font-size:12px;
  }

  .sidenav {
  height: 100%;
  width: 0;
  position: fixed;
  z-index: 999999999999999999;
  top: 0;
  left: 0;
  background-color:white;
  overflow-x: hidden;
  transition: 0.5s;
  padding-top: 60px;
}

.sidenav a {
  padding: 8px 8px 8px 32px;
  text-decoration: none;
  font-size: 18px;
  color:black;
  display: block;
  transition: 0.3s;
}

.sidenav a:hover {
  color: #f1f1f1;
}

.sidenav .closebtn {
  position: absolute;
  top: 0;
  right: 25px;
  font-size: 36px;
  margin-left: 50px;
}

.resto-name {font-size:25px;}
@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}
@media screen and (max-width: 450px) {
  .resto-name {font-size:17px;}
}
</style>
<!-- Sidebar -->
<!-- <div class="w3-sidebar w3-bar-block" style="display:none;z-index:9999999" id="mySidebar">
  <button onclick="w3_close()" class="w3-bar-item w3-button w3-large" style="text-align:right;"><span style="background-color:red;color:white;padding:5px;">&times;</span></button>
  <a href="#" class="w3-bar-item w3-button">Take Order</a>
  <a href="#" class="w3-bar-item w3-button">New Order</a>
  <a href="#" class="w3-bar-item w3-button">Order History</a>
</div> -->
<div class="menu-navigation" style="background: linear-gradient( 89.1deg,rgb(8,158,96) 0.7%,rgb(19,150,204) 88.4% );">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 mb-2">
                <div class="row">
                    <div class="col-1 p-1 text-center" style="margin-top:10px;"><span style="font-size:25px;cursor:pointer;color:white;" onclick="openNav()">&#9776;</span>
                    </div>
                    <div class="col-7 pl-4">
                      <h2 class="resto-name ml-2 text-white" style="margin-top:20px;"><b>Change Password</b></h2>
                    </div>
					<div class="col-3 p-1" style="text-align: right;color:white;margin-top:10px;">
						<?=$_SESSION['name']?>
						<!-- <a href="<?=base_url()?>restaurant_managerorder/rest_manager_update_profile">
						  <?php if ($profile[0]['profile_photo'] != 'assets/images/users/user.png' && $profile[0]['profile_photo'] != null) {?>
							<img src="<?=$profile[0]['profile_photo']?>" class="shadow-sm" style="height:50px;width:50px;border-radius:50%">
						  <?php } else{?>
							<img src="<?=base_url();?>assets/images/users/user.png" class="shadow-sm" style="height:50px;width:50px;border-radius:50%"><?php } ?>
						</a>-->
                    </div>
					 <!--<div class="col-1">-->
						        <!--  <div class="google_lang_menu menu_details_translate">
            				    <div id="google_translate_element"></div>
        				      </div>-->
						        <!--</div>
                    <div class="col-2 p-1">-->
						<!-- <a href="<?=base_url()?>restaurant_managerorder/rest_manager_update_profile">
						  <?php if ($profile[0]['profile_photo'] != 'assets/images/users/user.png' && $profile[0]['profile_photo'] != null) {?>
							<img src="<?=$profile[0]['profile_photo']?>" class="shadow-sm" style="height:50px;width:50px;border-radius:50%">
						  <?php } else{?>
							<img src="<?=base_url();?>assets/images/users/user.png" class="shadow-sm" style="height:50px;width:50px;border-radius:50%"><?php } ?>
						</a> -->
                    <!--</div>-->
                </div>
               <!--  <div class="text-white">
                   <div class="title d-flex align-items-center">
                     
                   </div>
                </div> -->
             </div>
        </div>
    </div>
</div>
<div class="container-fluid" style="margin-top:90px !important;">
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
      	<form method="post" action="javascript:;" class="shadow-sm p-4 mb-4 bg-white">
			<input type="hidden" name="id" value="<?=$_SESSION['user_id'];?>" id="id">
			<div class="row">
				<div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:20px;">
					<label style="justify-content: space-between; display: flex; margin-bottom: .5rem; padding: 0px 5px;">Old Password <span id="showopass"><i class="fas fa-eye-slash text-success" id="showtestbox"></i></span></label>
					<input type="password" class="form-control password-input" id="opassword" placeholder="Old Password" name="opassword" required="" minlength="8" maxlength="30">
				</div>
				<div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:20px;">
					<label style="justify-content: space-between; display: flex; margin-bottom: .5rem; padding: 0px 5px;">New Password <span id="showopass1"><i class="fas fa-eye-slash text-success" id="showtestbox1"></i></span></label>
					<input type="password" class="form-control password-input" id="npassword" placeholder="Password" name="password" required="" minlength="8" maxlength="30" >
				</div>
				<div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:20px;">
					<label style="justify-content: space-between; display: flex; margin-bottom: .5rem; padding: 0px 5px;">Confirm Password <span id="showopass2"><i class="fas fa-eye-slash text-success" id="showtestbox2"></i></span></label>
					<input type="password" class="form-control password-input" id="cpassword" placeholder="Password" name="cpassword" required="" minlength="8" maxlength="30" >
				</div>
			</div>
			<div class="text-center mt-3 mb-2">
				<button type="button" id="passwordchange" class="btn btn-success">Save</button>
			</div>
		</form>
    </div>
</div>
<?php
require_once('web_footer.php');
require_once('footer.php');
?>
<script type="text/javascript">
	$('#showopass').on('click','#showtestbox',function(){
		$('#opassword').attr('type', 'text');
		$('#showopass').html(' <i class="fas fa-eye text-success" id="hidetextbox"></i>');
	});
	$('#showopass').on('click','#hidetextbox',function(){
		$('#opassword').attr('type', 'password');
		$('#showopass').html(' <i class="fas fa-eye-slash text-success" id="showtestbox"></i>');
	});

	$('#showopass1').on('click','#showtestbox1',function(){
		$('#npassword').attr('type', 'text');
		$('#showopass1').html(' <i class="fas fa-eye text-success" id="hidetextbox1"></i>');
	});
	$('#showopass1').on('click','#hidetextbox1',function(){
		$('#npassword').attr('type', 'password');
		$('#showopass1').html(' <i class="fas fa-eye-slash text-success" id="showtestbox1"></i>');
	});

	$('#showopass2').on('click','#showtestbox2',function(){
		$('#cpassword').attr('type', 'text');
		$('#showopass2').html(' <i class="fas fa-eye text-success" id="hidetextbox2"></i>');
	});
	$('#showopass2').on('click','#hidetextbox2',function(){
		$('#cpassword').attr('type', 'password');
		$('#showopass2').html(' <i class="fas fa-eye-slash text-success" id="showtestbox2"></i>');
	});

	$('#passwordchange').on('click',function(){
		if($('#npassword').val().length  < 8){ 
			displaywarning("Password Should be 8 to 30 Characters.");
				 return false;
		}
		if($('#cpassword').val().length  < 8){ 
			displaywarning("Confirm Password Should be 8 to 30 Characters.");
			return false;
		}
		if ($('#opassword').val() != '' && $('#npassword').val() != '' && $('#cpassword').val() != '') {
			if($('#npassword').val()!=$('#cpassword').val()){
				 displaywarning("New password and Confirm password not match please try again.");
				 return false;}
	        var $form_data = {
	        	'id':$('#id').val(),
	        	'opassword':$('#opassword').val(),
	        	'password':$('#npassword').val(),
	        	'cpassword':$('#cpassword').val()
	        }
	        //console.log($form_data);
	        $.ajax({
	            url: "<?=base_url();?>profile/update_password",
	            type:'POST',
	            data: $form_data,
	            success: function(result){
	                if (result.status) { 
	                	$('#opassword').val('');
	                	$('#npassword').val('');
	                	$('#cpassword').val('');
	                   	displaysucess(result.msg);
	                }
	                else{
	                    if(result.msg){

	                        displaywarning(result.msg);
	                    }
	                    else
	                        displaywarning("Something went wrong please try again");
	                }
	            }
	        });
	    }
	    else{
	    	displaywarning("All fields are required.");
			return false;
	    }
	});


	function displaysucess(msg)
    {
        swal("Success !",msg,"success");
    }

   	function displaywarning(msg)
    {
        swal("Error !",msg,"error");
    }
</script>
<script>
function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}
</script>