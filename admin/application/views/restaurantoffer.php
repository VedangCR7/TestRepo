<?php
require_once('header.php');
require_once('sidebar.php');

?>
<!-- select2 Plugin -->
<link href="<?=base_url()?>assets/plugins/select2/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="<?=base_url()?>assets/plugins/multipleselect/multiple-select.css">																						   


<div class=" app-content">
	<div class="side-app">

		<!--Page Header-->
		<div class="page-header">
			<h3 class="page-title"><i class="side-menu__icon fe fe-zap mr-1"></i>Offer</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a><input type="hidden" value="<?=date('Y-m-d')?>" id="current_date_filter"></li>
				<li class="breadcrumb-item active" aria-current="page">Offer</li>
			</ol>
		</div>
		<!--Page Header-->
	</div>

	<div class="row row-div-quantity addnewoffer" style="display: none;">
		<div class="col-md-12">
			<div class="card welcome-image">
				<div class="card-body">
					<div class="row">
						<div class="col-md-11">
							<form class="form-recipe-edit" method="post" action="javascript:;">
								<div class="row">
									<div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;">
										<label style="font-weight:bold;">Title</label>
										<input type="text" name="title" id="title" class="form-control" placeholder="Offer Title" style="text-transform: capitalize;">
									</div>
									<div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;">
										<label style="font-weight:bold;">Discount Type</label><br>
										<input type="radio" name="discount_type" value="Flat" checked>&nbsp;Flat
										<input type="radio" name="discount_type" value="Percentage">&nbsp;Percentage
									</div>
									<div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;">
										<label style="font-weight:bold;">Discount</label>
										<input type="text" name="discount" oninput="validateNumber(this);" id="discount" class="form-control" placeholder="Enter Discount">
									</div>
									
									<p id="is_image_upload"><input type="hidden" name="" id="offer_photo"></p>
									<div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;text-align:center;">
										<input type="file" class="imgupload" id="imgvalue" value="" accept="image/jpeg, image/png" style="display:none">
                                    	<img class="img-upload1 rounded-circle" id="my_image" src="<?=base_url()?>assets/images/offer.png" style="height:50px;width:50px;"><br>
                                    	<button class="btn btn-secondary btn-sm img-upload1" type="button" style="background-color: #ED3573;border: 0px !important;margin-top:10px;">Browse</button>
									</div>
									<div class="col-lg-8 col-md-8 col-sm-12 col-12" style="margin-top:10px;">
										<label style="font-weight:bold;">Description</label>
										<textarea class="form-control" id="description" placeholder="Description"></textarea>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;">
										<label style="font-weight:bold;">Add Product</label><br>
										<!-- <select class="select2-show-search" id="item" data-placeholder="Choose Product" style="width:100%;">
											<option value="">Select Product</option>
											<?php foreach ($items as $key => $value) {?>
												<option value="<?=$value['id']?>"><?=$value['name']?></option>
											<?php } ?>
										</select> -->

										<select multiple="multiple" class="multi-select" id="item">
											<?php foreach ($items as $key => $value) {?>
												<option value="<?=$value['id']?>"><?=$value['name']?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-12 col-12">
										<label style="font-weight:bold;margin-top:10px;">Start Date</label>
										<input type="date" id="start_date" class="form-control" min="<?=date('Y-m-d')?>">
									</div>
									<div class="col-lg-4 col-md-4 col-sm-12 col-12">
										<label style="font-weight:bold;margin-top:10px;">End Date</label>
										
										<input type="date" id="end_date" class="form-control" min="<?=date('Y-m-d')?>">
									</div>
								</div>
								<div class="row">						   
									<div class="col-md-12 text-right">
										<button type="button" class="btn btn-default" id="closetoggle" style="background-color: #ede3e7;;border: 0px !important;float:right;margin-left:10px;margin-top: 1rem;">Cancel</button>
										<button type="submit" class="btn btn-secondary btn-save-details btn-add-group" type="button" style="background-color: #ED3573;border: 0px !important;float:right;margin-top:10px;margin-top: 1rem;">Save</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row edit_manager"></div>
	<div class="row mb-3 row-filter">
		<div class="col-md-2">
			<a href="#" class="btn btn-secondary"  id="addwaitingmanager" style="width: 100%;"><i class="fa fa-plus"></i> Create New</a>
		</div>
		<div class="col-md-2 col-8">
			<select class="form-control" id="bulkaction">
				<option value="">Bulk Actions</option>
				<option value="Active">Active</option>
				<option value="Inactive">Inactive</option>
				<option value="Delete">Delete</option>
			</select>
		</div>
		<div class="col-md-1 col-4">
			<a href="#" class="btn btn-warning" id="applybulkaction" style="margin-left:-14px;">Apply</a>
		</div>
		<div class="col-md-2">
			<select class="form-control" id="status">
				<option value="">Select Status</option>
				<option value="1">Active</option>
				<option value="0">Inactive</option>
			</select>
		</div>
		<div class="col-md-5">
			<div class="input-group">
				<input type="text" class="form-control" placeholder="Search Offer Title"  id="searchInput" style="font-size: 17px;">
				<span class="input-group-append">
					<button class="btn btn-primary" type="button" style="border-radius: 4px;border: 0px !important;"><i class="fas fa-search"></i></button>
				</span>
			</div>
		</div>
		<!-- <div class="col-md-2 p-l-5 p-r-5">
			<div class="btn-group per_page m-r-5">
				<button class="btn btn-default dropdown-toggle btn-per-page" data-toggle="dropdown" type="button" aria-expanded="false" selected-per-page="30">
					30 items per page
					<i class="md md-arrow-drop-down"></i>
				</button>
				<ul class="dropdown-menu pull-right" role="menu">
					<li class=""><a data-per="15" class="a-recipe-perpage" data-preferences='{"per_page":"15"}' href="javascript:;">15</a></li>
					<li class=""><a data-per="30" class="a-recipe-perpage" data-preferences='{"per_page":"30"}' href="javascript:;">30</a></li>
					<li class=""><a data-per="60" class="a-recipe-perpage" data-preferences='{"per_page":"60"}' href="javascript:;">60</a></li>
					<li class=""><a data-per="all" class="a-recipe-perpage" data-preferences='{"per_page":"all"}' href="javascript:;">All (<span class="span-all-groups"></span>)</a></li>
				</ul>
			</div>
		</div>
		<div class="col-md-3 p-l-10">
			<div class="btn-group page_links page-no" role="group">
				<button class="btn btn-default btn-prev disabled prev" data-page="prev" type="button">
					<span class="fas fa-angle-left"></span>
				</button>
				<button class="btn btn-default"><b class="span-page-html">0-0</b> of <b class="span-all-groups">0</b></button>
				<buton class="btn btn-default btn-next disabled next" data-page="next" type="button">
					<span class="fas fa-angle-right"></span>
				</buton>
			</div>
		</div> -->
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<div class="table-responsive">
						<table class="table card-table table-vcenter table-head" id="table-recipes">
							<thead >
								<tr>
									<th width="5%"><input type="checkbox" name="offers" id="offers"></th>
									<th width="5%">Sr.No</th>
									<th width="10%">Offer Image</th>
									<th width="20%">Title</th>
									<th width="10%">Recipe</th>
									<th width="20%">Description</th>
									<th width="10%">Start Date</th>
									<th width="10%">End Date</th>
									<th width="5%">Active/Inactive</th>
									<th width="5%"></th>
								</tr>
							</thead>
							<tbody class="tbody-group-list">
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		
	</div>

		<!-- Inline js -->
		<script src="<?=base_url()?>assets/js/select2.js"></script>	
<script src="<?=base_url();?>assets/js/custom/Restoffer.js?v=<?php echo uniqid(); ?>"></script>

<script type="text/javascript">
	Restoffer.base_url="<?=base_url();?>";
	Restoffer.init();
	/*$('.recipe-tabs').find('.receipes .card-body').addClass('active');*/
</script>
<script>
$(document).ready(function(){
  $("#addwaitingmanager").click(function(){
    $(".addnewoffer").show();
    $(".addnewoffer").fadeIn("slow");
    $('.edit_manager').hide();
  });

  $("#closetoggle").click(function(){
  	$(".addnewoffer").hide();
  	$('#title').val('');
  	$('#description').val('');
  	$('#discount').val('');
  	$('#my_image').attr('src','<?=base_url()?>assets/images/offer.png');
  });
});


var validNumber = new RegExp(/^\d*\.?\d*$/);
var lastValid = document.getElementById("discount").value;
function validateNumber(elem) {
  if (validNumber.test(elem.value)) {
    lastValid = elem.value;
  } else {
    elem.value = lastValid;
  }
}
</script>
<script>
	setInterval(function() {
                $.ajax({
                    url: "<?=base_url();?>restaurant/set_authority_exist",
                    type:'POST',
                    dataType: 'json',
                    data: {name:'Offers'},
                    success: function(result){
                        if(result.status){
                            window.location.href="<?=base_url();?>restaurant/dashboard";
                        }
                   	}
                });
            },5000);
	
	setInterval(function() {
                $.ajax({
                    url: "<?=base_url();?>restaurant/inactiveoffers",
                    type:'POST',
                    dataType: 'json',
                    success: function(result){
                   	}
                });
            },5000);				 
</script>
<script src="<?=base_url()?>assets/plugins/multipleselect/multiple-select.js"></script>
<script src="<?=base_url()?>assets/plugins/multipleselect/multi-select.js"></script>
<?php
require_once('footer.php');
?>