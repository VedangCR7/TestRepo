<?php
require_once('header.php');
require_once('sidebar.php');
?>
<div class=" app-content">
	<div class="side-app">

		<!--Page Header-->
		<div class="page-header">
			<h3 class="page-title"><i class="side-menu__icon fas fa-utensils mr-1"></i> Whatsapp Message</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Home</li>
				<li class="breadcrumb-item active" aria-current="page"> Whatsapp Message</li>
			</ol>
		</div>
		<!--Page Header-->
	</div>
	<div class="row edit_manager"></div>
	<div class="row mb-3 row-filter">
		<div class="col-md-2">
			<button class="btn btn-primary" data-toggle="modal" data-target="#newoffer"><i class="fas fa-plus"></i> Create Message</button>
		</div>
		<div class="col-md-5">
			<div class="input-group">
				<input type="text" class="form-control" placeholder="Search Message Text"  id="searchInput" style="font-size: 17px;">
				<span class="input-group-append">
					<button class="btn btn-primary" type="button" style="border-radius: 4px;border: 0px !important;"><i class="fas fa-search"></i></button>
				</span>
			</div>
		</div>
		<div class="col-md-2 p-l-5 p-r-5">
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
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<div class="table-responsive">
						<table class="table card-table table-vcenter text-nowrap table-head" id="table-recipes">
							<thead >
								<tr>
									<th>Sr.No</th>
									<th>Message Image</th>
									<th>Message Text</th>
									<th>Active/Inactive</th>
									<th></th>
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


	<!-- The Modal -->
<div class="modal" id="newoffer">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Create New Message</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
			<div class="row addnewwaitinglist">
				<p id="is_image_upload"><input type="hidden" name="" id="offer_photo"></p>
          		<div class="col-lg-4 col-md-4 col-sm-12 col-12" style="text-align: center;">
            		<input type="file" class="imgupload" id="imgvalue" value="" accept="image/jpeg, image/png" style="display:none">
                    <img class="img-upload1 rounded-circle" id="my_image" src="<?=base_url()?>assets/images/users/offer2.png" style="height:50px;width:50px;"><br>
                    <button class="btn btn-secondary btn-sm img-upload1" type="button" style="background-color: #ED3573;border: 0px !important;margin-top:10px;">Browse</button>
          		</div>
          		<div class="col-lg-8 col-md-8 col-sm-12 col-12">
            		<label style="font-weight:bold;">Message Text</label>
            		<textarea name="offer_text" id="offer_text" placeholder="Offer Text" class="form-control"></textarea>
          		</div>
          		<div class="col-lg-12 col-md-12 col-sm-12 col-12 text-center" style="margin-top:10px;">
            		<button type="button" class="btn btn-default" id="closetoggle" style="background-color: #ede3e7;;border: 0px !important;float:right;margin-left:10px;">Cancel</button>
					<button type="submit" class="btn btn-secondary btn-save-details btn-add-offer" type="button" style="background-color: #ED3573;border: 0px !important;float:right;">Save</button>
          		</div>
          		<div class="col-lg-12 col-md-12 col-sm-12 col-12"><hr></div>
        	</div>
        	<div class="row showaddedoffer"></div>
        	<div class="row" style="margin-top:10px;display: none" id="show_all_customer">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered cust-table" id="cust-table">
							<thead>
								<tr>
									<th><input type="checkbox" name="all_cust" class="all_cust" id="all_cust"></th>
									<th>Name</th>
									<th>Mobile Number</th>
									<th>Email</th>
								</tr>
							</thead>
							<tbody id="tbody-customer">
							</tbody>
							<tfoot>
								<tr>
									<td colspan="4" class="text-right"><button class="btn btn-primary send_offer">Send</button></td>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>	
	</div>
      </div>

    </div>
  </div>
</div>

<!-- The Modal -->
<div class="modal" id="editoffersend">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Send Offer</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
      	<div class="row" style="margin-top:10px;" id="offershowforsend"></div>
        <div class="row" style="margin-top:10px;" id="show_all_customer1">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered cust-table1" id="cust-table1">
							<thead>
								<tr>
									<th><input type="checkbox" name="all_cust" class="all_cust" id="all_cust"></th>
									<th>Name</th>
									<th>Mobile Number</th>
									<th>Email</th>
								</tr>
							</thead>
							<tbody id="tbody-customer1">
							</tbody>
							<tfoot>
								<tr>
									<td colspan="4" class="text-right"><button class="btn btn-primary send_offer">Send</button></td>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>	
	</div>
      </div>

    </div>
  </div>
</div>

</div>
	
<?php
require_once('footer.php');
?>
<script>
$(document).ready(function(){
// 	var d = new Date();
// var n = d.getTime();
// alert(n);

  $("#closetoggle").click(function(){
  	$('#newoffer').modal('hide');
  	$('#offer_text').val('');
  });

  $('.close').click(function(){
  	$('.addnewwaitinglist').show();
  	$('.showaddedoffer').hide();
  	$('#show_all_customer').hide();
  	$('#my_image').attr('src','<?=base_url()?>assets/images/users/offer2.png');
  	$('#imgvalue').val('');
  	$('#offer_text').val('');
  })
});
</script>
<script src="<?=base_url();?>assets/js/custom/Offer.js?v=10"></script>
<script type="text/javascript">
	Offer.base_url="<?=base_url();?>";
	Offer.group_id="<?php if(isset($_GET['group_id'])) echo $_GET['group_id']; else echo '';?>";
	Offer.init();
	/*$('.recipe-tabs').find('.receipes .card-body').addClass('active');*/
</script>
