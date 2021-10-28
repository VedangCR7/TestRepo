<?php
require_once('header.php');
require_once('sidebar.php');

?>
<style type="text/css">
	@media (max-width: 767px){
		label .error{
			display: contents;
    		margin-bottom: .5rem;
		}
		.form-group .error:not([style*="display: none;"])+.field-icon {
    		margin-top: -70px!important;
		}
	}
</style>
<div class=" app-content">
	<div class="side-app">

		<!--Page Header-->
		<div class="page-header">
			<h3 class="page-title"><i class="side-menu__icon fas fa-utensils mr-1"></i> Change Password</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Change Password</li>
			</ol>
		</div>
		<!--Page Header-->
	</div>
	<div class="row justify-content-md-center" style="min-height: 400px;">
		<div class="col-md-6">
			<div class="card">
				<div class="pri-header">
					<h3 class="mr-1 mb-0">Change Your Password
					</h3>
					
				</div>
				<div class="card-body">
					<form method="post" action="javascript:;" id="form-change-password">
						<input type="hidden" name="id" value="<?=$_SESSION['user_id'];?>">
						<div class="">
							<div class="form-group">
								<label for="opassword">Old Password</label>
								<input type="password" class="form-control password-input" id="opassword" placeholder="Old Password" name="opassword" required="" minlength="8" maxlength="30">
								<span toggle="#opassword" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>
								<p id="opassword1"></p>
							</div>
							<div class="form-group">
								<label for="npassword">New Password</label>
								<input type="password" class="form-control password-input" id="npassword" placeholder="Password" name="password" required="" minlength="8" maxlength="30" >
								<span toggle="#npassword" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>
							</div>
							<div class="form-group">
								<label for="cpassword">Confirm New Password</label>
								<input type="password" class="form-control password-input" id="cpassword" placeholder="Password" name="cpassword" required="" minlength="8" maxlength="30" >
								<span toggle="#cpassword" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>
							</div>
						</div>
						<div class="text-center mt-5 mb-2">
							<button type="submit" class="btn btn-primary">Save</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
<?php
require_once('footer.php');
?>
<script type="text/javascript">
		$(".toggle-password").click(function(e) {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
	 	$('.password-input').on('keypress',function(e){
            if(e.which === 32) 
        		return false;
        });
	$('#form-change-password').on('submit',function(){
		if ($(this).valid()) {
			if($('#npassword').val()!=$('#cpassword').val()){
				 displaywarning("New password and Confirm password not match please try again.");
				 return false;
			}
			var self=this;
	        var $form_data = new FormData();
	        $('#form-change-password').serializeArray().forEach(function(field){
	            $form_data.append(field.name, field.value);
	        });
	        $.ajax({
	            url: "<?=base_url();?>profile/update_password",
	            type:'POST',
	            data: $form_data,
	            processData:false,
	            contentType:false,
	            cache:false,
	            success: function(result){
	                if (result.status) { 
	                   	displaysucess(result.msg);
	                   	$('#form-change-password [type="password"]').val('');
	                   	$('#form-change-password').trigger('reset');
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
	});

	$("#form-change-password").validate({
		    rules: {
			    password: {
			        required: true,
			        minlength: 8,
			        maxlength: 30
		      	},
		      	cpassword: {
			        required: true,
			        minlength: 8,
			        maxlength: 30
		      	},
		      	opassword: {
			        required: true,
			        minlength: 8,
			        maxlength: 30
		      	}
		    },
		    messages: {
				opassword: {
					required: "Please provide a old password. this field is required.",
					minlength: "Passwords must be at least 8 and maximum 30 characters in length",
					maxlength:"Passwords must be at least 8 and maximum 30 characters in length"
				},
				password: {
					required: "Please provide a password. this field is required",
					minlength: "Passwords must be at least 8 and maximum 30 characters in length",
					maxlength:"Passwords must be at least 8 and maximum 30 characters in length"
				},
				cpassword: {
					required: "Please provide a confirm password. this field is required",
					minlength: "Passwords must be at least 8 and maximum 30 characters in length",
					maxlength:"Passwords must be at least 8 and maximum 30 characters in length"
				}
		    },

		    submitHandler: function(form) {
		      form.submit();

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