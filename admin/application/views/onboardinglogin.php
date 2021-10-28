<!DOCTYPE html>
<html>
<head>
        <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="Spaner - Simple light Bootstrap Nice Admin Panel Dashboard Design Responsive HTML5 Template" name="description">
        <meta content="Spruko Technologies Private Limited" name="author">
        <meta name="keywords" content="bootstrap panel, bootstrap admin template, dashboard template, bootstrap dashboard, dashboard design, best dashboard, html css admin template, html admin template, admin panel template, admin dashbaord template, bootstrap dashbaord template, it dashbaord, hr dashbaord, marketing dashbaord, sales dashbaord, dashboard ui, admin portal, bootstrap 4 admin template, bootstrap 4 admin"/>
    <title>test</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="<?=base_url();?>assets/plugins/select2/select2.min.css" rel="stylesheet" />

        <link rel="stylesheet" href="<?=base_url();?>assets/plugins/multipleselect/multiple-select.css">
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="row">
					<div class="col-lg-4 col-md-4 col-sm-12 col-12">
						<div class="container">
							<div class="row" style="margin-top:50px;">
								<div class="col-lg-12 col-md-12 col-sm-12 col-12 text-center">
									<img alt="logo" class="main-logo" src="<?=base_url('assets/images/brand/FoodNAILoginLogo.png')?>" style="height: 50px;width: 150px;">
								</div>
								<div class="col-lg-12 col-md-12 col-sm-12 col-12" style="margin-top:20px;text-align:center;">
									<p><b>Login Your Youresto Account</b></p>
								</div>
								<div class="col-lg-12 col-md-12 col-sm-12 col-12" style="margin-top:20px;">
									<input type="text" class="form-control" placeholder="Enter Email ID" id="email">
								</div>
								<div class="col-lg-12 col-md-12 col-sm-12 col-12" style="margin-top:20px;">
									<input type="password" class="form-control" placeholder="Enter Password" id="password">
								</div>
								<div class="col-lg-12 col-md-12 col-sm-12 col-12" style="margin-top:20px;">
									<button class="btn btn-primary form-control" style="background-color:#1B949D;" id="register">Login Now!</button>
								</div>
								<div class="col-lg-12 col-md-12 col-sm-12 col-12" style="margin-top:20px;text-align:center;">
									<p>Not Have Account <a href="<?=base_url('onboarding/onboardingone')?>">Signup</a>?Copyright © YouResto 2021</p>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-8 col-md-8 col-sm-12 col-12">
						<img src="<?=base_url('assets/img/onboardingregister.png')?>" width="100%" height="950px;">
					</div>
				</div>
			</div>
		</div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script src="<?=base_url();?>assets/plugins/select2/select2.full.min.js"></script>
    <script type="text/javascript">
      function check() 
      {
         if ($('#myCheckbox').is(':checked')==1) 
         {
            $('#myCheckbox').css("color", "yellow");
         }
      }
    </script>
	<script>
		$('.select2-show-search').select2({
	  	minimumResultsForSearch: ''
    });
	$('.select2-show-search').val($(".select2-show-search").attr('selected-value')).trigger('change');
	</script>
	<script>
		$('#register').click(function(){
			if($('#email').val()==''){
				swal("Error!", "email is required!", "error");
				return false;
			}
			if($('#password').val()==''){
				swal("Error!", "Password is required!", "error");
				return false;
			}
			
			$.ajax({
				url: "<?=base_url()?>onboarding/get_completed_step",
				type:'POST',
				data:{email:$('#email').val(),password:$('#password').val()},
				success: function(result){
					if(result.status){
						swal('Proceed to next step')
						.then((value) => {
							//alert(result.step);
							//alert(result.restaurant_id);
							if(parseInt(result.step) == 0){
								window.location.href="<?=base_url()?>onboarding/onboardingstepone/"+result.restaurant_id;
							}
							
							if(parseInt(result.step) == 1){
								window.location.href="<?=base_url()?>onboarding/onboardingstepthree/"+result.restaurant_id;
							}
						});
					}else{
						swal("Error!",result.msg, "error");
					}
				   
				}
			});
		});
	</script>
</body>
</html>