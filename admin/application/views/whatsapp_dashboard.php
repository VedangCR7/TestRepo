<?php
require_once('header.php');
require_once('sidebar.php');
?>
<div class=" app-content">
	<div class="side-app">

		<!--Page Header-->
		<div class="page-header">
			<h3 class="page-title"><i class="side-menu__icon fas fa-utensils mr-1"></i>Waitinglist Message</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Waitinglist Message</li>
			</ol>
		</div>
		<!--Page Header-->
	</div>

	<div class="row row-div-quantity">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<div class="row" id="showmessagefields">
          				<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">
            				<label style="font-weight:bold;">Text Message</label>
            				<span id="getid"><input type="hidden" id="message_id" name="id" value=""></span>
            				<textarea name="text_message" id="text_message" placeholder="Enter Message" class="form-control" rows="6"></textarea>
          				</div>
          				<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">
            				<label style="font-weight:bold;">Whatsapp Message</label>
            				<textarea name="whatsapp_message" id="whatsapp_message" placeholder="Enter Message" class="form-control" rows="6"></textarea>
          				</div>
          				<div class="col-lg-12 col-md-12 col-sm-12 col-12 text-center">
            				<button class="btn btn-primary" id="savemessage" type="button" style="background-color: #ED3573;border: 0px !important;float:right;margin-top:10px;margin-top: 1rem;">Save Message</button>
          				</div>
        			</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src='<?=base_url();?>assets/js/custom/Whatsappmessage.js'></script>
<script type="text/javascript">
	Whatsappmessage.base_url="<?=base_url();?>";
	Whatsappmessage.init();
	/*$('.recipe-tabs').find('.receipes .card-body').addClass('active');*/
</script>
<?php
require_once('footer.php');
?>