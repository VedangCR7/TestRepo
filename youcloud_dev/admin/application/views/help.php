<?php
require_once('header.php');
require_once('sidebar.php');

?>
<div class=" app-content">
	<div class="side-app">

		<!--Page Header-->
		<div class="page-header">
			<h3 class="page-title"><i class="side-menu__icon fe fe-alert-circle mr-1"></i> Help</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Help</li>
			</ol>
		</div>
		<!--Page Header-->
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="card">
				<div class="pri-header">
					<h3 class="mr-1 mb-0">Online Form
					</h3>
				</div>
				<div class="card-body">
					<form method="post" action="<?php echo base_url();?>help/send_email">
						<div class="">
							<div class="form-group">
								<label for="Name">Name (*)</label>
								<input type="text" class="form-control" id="Name" placeholder="Name" name="name" required="" onkeydown="return alphaOnly(event);">
							</div>
							<div class="form-group">
								<label for="Email">Email (*)</label>
								<input type="email" class="form-control" id="Email" placeholder="Email" name="email" required="">
							</div>
							<div class="form-group">
								<label for="Message">Message (*)</label>
								<textarea class="form-control" id="Message" placeholder="Message" name="message" required=""></textarea>
							</div>
						</div>
						<div class=" mt-2 mb-0" style="text-align: center;">
							<button type="submit" class="btn btn-pink" >Send</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="card">
				<div class="pri-header">
					<h3 class="mr-1 mb-0">Office Details
					</h3>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-sm-3">
							<p class="pull-right"><b style="font-weight: bolder;">Address</b></p>
						</div>
						<div class="col-sm-8">
							RSL Solution Pvt Ltd.
							<br>
							Near, Sayli Complex Road,
							<br>
							Walhekarwadi, Sector No 32,
							<br>
							Nigdi, Pimpri Chinchwad,
							<br>
							Maharashtra 411044
							<br>
							<br>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-3">
							<p class="pull-right"><b style="font-weight: bolder;">Email</b></p>
						</div>
						<div class="col-sm-8">
							<p>info@rslsolution.com</p>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-3">
							<div class="pull-right"><b style="font-weight: bolder;">Mobile</b></div>
						</div>
						<div class="col-sm-8">
							<p>+91 788 787 1415</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
	setInterval(function() {
                $.ajax({
                    url: "<?=base_url();?>restaurant/set_authority_exist",
                    type:'POST',
                    dataType: 'json',
                    data: {name:'Help'},
                    success: function(result){
                        if(result.status){
                            window.location.href="<?=base_url();?>restaurant/dashboard";
                        }
                   	}
                });
            },5000);
</script>
<?php
require_once('footer.php');
?>
<script type="text/javascript">
	var msg="<?php if(isset($_GET['msg'])) echo $_GET['msg']; else echo '';?>";
	if(msg!="")
	 	swal("Success !","Mail send successfully.","success");
</script>
<script>
function alphaOnly(event) {
  var key = event.keyCode;`enter code here`
  return ((key >= 65 && key <= 90) || key == 8 || key == 32);
};
</script>