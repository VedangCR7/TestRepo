<?php
require_once('header.php');
require_once('sidebar.php');

?>
<div class=" app-content">
	<div class="side-app">

		<!--Page Header-->
		<div class="page-header">
			<h3 class="page-title"><i class="side-menu__icon fe fe-user mr-1"></i>Captain</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Captain</li>
			</ol>
		</div>
		<!--Page Header-->
	</div>

	<div class="row row-div-quantity addnewmanager" style="display: none;">
		<div class="col-md-12">
			<div class="card welcome-image">
				<div class="card-body">
					<div class="row">
						<div class="col-md-11">
							<form class="form-recipe-edit" method="post" action="javascript:;">
								<input type="hidden" name="id" class="input-recipe-id">
								<div class="row">
									<p id="is_image_upload"><input type="hidden" name="" id="profile_photo"></p>
									<div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:10px;text-align:center;">
										<input type="file" class="imgupload" id="imgvalue" value="" accept="image/jpeg, image/png" style="display:none">
                                    	<img class="img-upload1 rounded-circle" id="my_image" src="<?=base_url()?>assets/images/users/user.png" style="height:50px;width:50px;"><br>
                                    	<button class="btn btn-secondary btn-sm img-upload1" type="button" style="background-color: #ED3573;border: 0px !important;margin-top:10px;">Browse</button>
									</div>
									<div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:10px;">
										<label style="font-weight:bold;">Name</label>
										<input type="text" name="name" id="name"  class="form-control" placeholder="Enter Name" style="text-transform: capitalize;">
									</div>
									<div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:10px;">
										<label style="font-weight:bold;">Email</label>
										<input type="text" name="email" id="email"  class="form-control" placeholder="Enter Email" >
									</div>
									<div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:10px;">
										<label style="font-weight:bold;">Contact Number</label>
										<input type="text" name="contact_number"  id="contact_number" class="form-control" placeholder="Enter Contact Number" onkeypress="return isNumber(event)">
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
		<div class="col-md-5">
			<div class="input-group">
				<input type="text" class="form-control" placeholder="Search Restaurant Manager"  id="searchInput" style="font-size: 17px;">
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
									<th>Profile Image</th>
									<th>Name</th>
									<th>Contact</th>
									<th>Email</th>
									<th>Password</th>
									<th>Active/Inactive</th>
									<th>Assign Table</th>
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
<div class="modal" id="assigntablemodal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Assign table</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body" id="showtables">
        
      </div>

	  <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="assign_table">Assign Table</button>
      </div>

    </div>
  </div>
</div>

<script src="<?=base_url();?>assets/js/custom/Restaurantmanager.js?v=<?php echo uniqid();?>"></script>

<script type="text/javascript">
	Restaurantmanager.base_url="<?=base_url();?>";
	Restaurantmanager.init();
	/*$('.recipe-tabs').find('.receipes .card-body').addClass('active');*/
</script>
<script>
$(document).ready(function(){
  $("#addwaitingmanager").click(function(){
    $(".addnewmanager").show();
    $(".addnewmanager").fadeIn("slow");
    $('.edit_manager').hide();
  });

  $("#closetoggle").click(function(){
  	$(".addnewmanager").hide();
  	$("#name").val('');
  	$("#email").val('');
  	$("#contact_number").val('');
  });
});
</script>
<script>
	function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
</script>
<script>
	setInterval(function() {
                $.ajax({
                    url: "<?=base_url();?>restaurant/set_authority_exist",
                    type:'POST',
                    dataType: 'json',
                    data: {name:'Restaurant Manager'},
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