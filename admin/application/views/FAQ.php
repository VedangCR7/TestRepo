<?php
if($user['upline_id'] == ''){
	$retoencodestr = base64_encode($user['id']);}
else{
	$retoencodestr = base64_encode($user['upline_id']);
}
require_once('header.php');
require_once('sidebar.php');
?>
<div class=" app-content">
	<div class="side-app">

		<!--Page Header-->
		<div class="page-header">
			<h4 class="page-title"><i class="fe fe-life-buoy mr-1"></i> Faqs</h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Faqs</li>
			</ol>
		</div>
		<!--Page Header-->
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">1.How to Create Menu?</h3>
					<!--<div class="card-options">
						<a href="#" class="btn btn-primary btn-sm"><i class="fe fe-edit-2 mr-1"></i> Edit</a>
					</div>-->
				</div>
				<div class="card-body">
					<h3 class="card-title">Step 1</h3>
						<p class="mb-0" style="padding-left: 40px;">Add data in Menu Master. Please check below video link. </p>
						<p class="mb-0" style="padding-left: 40px;">
							<a href="https://youtu.be/E_KO4ALyZWQ" target="_blank">Add records one by one</a>
						</p>
						<p class="mb-0" style="padding-left: 40px;">
							<a href="https://youtu.be/vt5BRGuWeeg" target="_blank">Add multiple records</a>
						</p>
						<br>
					<h3 class="card-title">Step 2</h3>	
						<p class="mb-0" style="padding-left: 40px;">Add data in Menu Group. Please check below video link. </p>
						<p class="mb-0" style="padding-left: 40px;">
							<a href="https://youtu.be/Po0pZCMHj6Y" target="_blank">Add records one by one</a>
						</p>
						<p class="mb-0" style="padding-left: 40px;">
							<a href="https://youtu.be/JvXLv8jE6Og" target="_blank">Add multiple records</a>
						</p>
						<br>
					<h3 class="card-title">Step 3</h3>	
						<p class="mb-0" style="padding-left: 40px;">Add data in Menus. Please check below video link. </p>
						<p class="mb-0" style="padding-left: 40px;">
							<a href="https://youtu.be/qpK90UneWwM" target="_blank">Add records one by one</a>
						</p>
						<p class="mb-0" style="padding-left: 40px;">
							<a href="https://youtu.be/9CZaE899BTE" target="_blank">Add multiple records</a>
						</p>
						<br>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">2.How to Create Add On Category?</h3>
				</div>
				<div class="card-body">
					<p class="mb-0">
						Add data in Add on category. Please check below video link.
					</p>
					<p class="mb-0" style="padding-left: 40px;">
						<a href="https://youtu.be/i0pEG7ooa2A" target="_blank">Add records one by one</a>
					</p>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">3.How to create special offers?</h3>
				</div>
				<div class="card-body">
					<p class="mb-0" style="padding-left: 40px;">
						<a href="https://youtu.be/elDBEntE724" target="_blank">Please check this video link.</a>
					</p>					
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">4.How to create waiting list Manager and how it works ?</h3>
				</div>
				<div class="card-body">
					<p class="mb-0">Please check below video link.. </p>
					<p class="mb-0" style="padding-left: 40px;">
						<a href="https://youtu.be/PPhzgbHBh0A" target="_blank">Link 1.</a>
					</p>
					<p class="mb-0" style="padding-left: 40px;">
						<a href="https://youtu.be/wlqPsUw_1m8" target="_blank">Link 2.</a>
					</p>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">5.How to add products to inventory?</h3>
				</div>
				<div class="card-body">
					<p class="mb-0">Please check below video link.</p>
					<p class="mb-0" style="padding-left: 40px;">
						<a href="https://youtu.be/awfKXlC-yXw" target="_blank">Add records one by one</a>
					</p>
					<p class="mb-0" style="padding-left: 40px;">
						<a href="https://youtu.be/lo3O62NXgy4" target="_blank">Add multiple records</a>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal-imagepreview" tabindex="-1" role="dialog"  aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form method="post" action="javascript:;">
				<img src="<?=base_url();?>assets/plugins/resize/original-image.jpeg" id="cropbox" class="img" style="width: 100% !important;"/><br />
				<button type="button" class="btn btn-success" id="crop" value='CROP' style="float: right;margin-bottom: 10px;margin-right: 10px;">Crop</button>
			</form>
		</div>
	</div>
</div>
<script src="<?=base_url();?>assets/plugins/timepickerplugin/tpicker.js"></script>
<?php
require_once('footer.php');
?>