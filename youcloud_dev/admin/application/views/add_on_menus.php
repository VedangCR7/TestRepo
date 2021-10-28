<?php
require_once('header.php');
require_once('sidebar.php');

?>
<div class=" app-content">
	<div class="side-app">

		<!--Page Header-->
		<div class="page-header">
			<h3 class="page-title"><i class="side-menu__icon fas fa-utensils mr-1"></i>Add-On Categories</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Add-On Categories</li>
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
								<div class="row">
									<div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;">
										<label style="font-weight:bold;">Select Menu Group</label>
										<select class="form-control select2-show-search" name="menu_group" id="menu_group_id" style="width:100%;">
											<option value="">Select Menu Group</option>
											<?php foreach($menu_group as $key => $value){ ?>
											<option value="<?=$value['id']?>"><?=$value['title']?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;">
										<label style="font-weight:bold;">Select Menu</label>
										<select class="form-control select2-show-search" name="menu_id" id="menu_id" style="width:100%;">
											
										</select>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;">
										<label style="font-weight:bold;">Name</label>
										<input type="text" name="addon_name" class="form-control input-item-name typeahead" onclick="this.select();" placeholder="Enter addon menu" autocomplete="off" id="addon_name" style="text-transform: capitalize;">
									</div>
									<div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;">
										<label style="font-weight:bold;">Select Multiple Options</label><br>
										<input type="radio" name="select_multiple_option" class="select_multiple_option" value="No" checked> No &nbsp;&nbsp;
										<input type="radio" name="select_multiple_option" class="select_multiple_option" value="Yes"> Yes
									</div>
									<!-- <div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;">
										<label style="font-weight:bold;">Quantity</label>
										<input type="text" name="quantity" id="quantity" class="form-control" placeholder="Enter Quantity">
									</div> -->
									<!-- <div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:10px;">
										<label style="font-weight:bold;">Price</label>
										<input type="text" name="price" id="price" class="form-control" placeholder="Enter Price">
									</div> -->
								</div>
								<div class="row">
									<div class="col-lg-12 col-md-12 col-sm-12 col-12" style="margin-top:10px;">
										<label style="font-weight:bold;">Options</label>
										<div class="row">
										<div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;">
											<input type="text" name="option_name[]" value="" placeholder="Enter Name" class="form-control" style="text-transform: capitalize;">
										</div>
										<div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;">
											<input type="text" name="option_price[]" value="" placeholder="Enter Price" class="form-control">
										</div>
										<div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;"><kbd class="btn btn-primary" onclick="addspecifications()">Add More</kbd></div>
										</div>
										<div class="displaymore">
										
										</div>
										
									</div>
								</div>
								<div class="row">
									<div class="col-md-12 text-right">
										<hr>
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
				<input type="text" class="form-control" placeholder="Search Add On Menus"  id="searchInput" style="font-size: 17px;">
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
									<th>Add-on ID</th>
									<th>Add-on Categories</th>
									<th>Menu Group</th>
									<th>Options</th>
									<th>Multiple</th>
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
	<script type="text/javascript">
    function addspecifications(){
      $(".displaymore").append('<div class="row"><div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;"><input type="text" name="option_name[]" placeholder="Enter Name" class="form-control" style="text-transform: capitalize;"></div><div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;"><input type="text" name="option_price[]" placeholder="Enter Price" class="form-control"></div><div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;"><i class="fa fa-trash remove_this" style="color:red"></i></div></div>');
    }

	function addspecifications1(){
      $(".displaymore1").append('<div class="row"><div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;"><input type="text" name="edit_option_name[]" placeholder="Enter Name" class="form-control" style="text-transform: capitalize;"></div><div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;"><input type="text" name="edit_option_price[]" placeholder="Enter Price" class="form-control"></div><div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;"><i class="fa fa-trash remove_this" style="color:red"></i></div></div>');
    }
  </script>

  <script type="text/javascript">
    jQuery(document).on('click', '.remove_this', function() {
        jQuery(this).parent().parent().remove();
        //return false;
        });
  </script>	
<script src="<?=base_url();?>assets/js/custom/Addonmenu.js?v=<?php echo uniqid(); ?>"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
$(document).ready(function(){
	$('.select2-show-search').select2({
	  	minimumResultsForSearch: ''
    });
	$('.select2-show-search').val($(".select2-show-search").attr('selected-value')).trigger('change');
})
</script>
<script>
function chkNameVal(){
	var nm = document.getElementById('name').value;
	if(nm != ''){
		if(nm.length < 2 || nm.length > 30){
			swal("Error!","Customer name should be 2 to 30 characters", "error");
			/*alert('Customer name should be 2 to 30 characters');*/
			$('#name').val('');
			return false;
		}
		else if(!nm.match(/^[a-zA-Z]+(\s{0,1}[a-zA-Z])*$/)){
			swal("Error!","Please enter proper name", "error");
			/*alert('Please enter proper name');*/
			$('#name').val('');
			return false;
		}
	}
}
</script>
<script type="text/javascript">
	Addonmenu.base_url="<?=base_url();?>";
	Addonmenu.init();
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

<?php
require_once('footer.php');
?>