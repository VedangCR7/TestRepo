<?php
require_once('header.php');
require_once('sidebar.php');
?>
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/plugins/timepickerplugin/tpicker.css">
<style type="text/css">

@media only screen and (max-width: 600px) {
	.notshow{
		display: none;
	}
	#widthname{
		width: 17%;
	}
	#widthaction{
		width: 78%;
	}
	#widthperson{
		width:10px;
	}
	}
</style>
<div class=" app-content">
	<div class="side-app">

		<!--Page Header-->
		<div class="page-header">
			<h3 class="page-title"><i class="fe fe-user mr-1"></i> Today's Customer</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?=base_url();?>admin">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Today's Customer</li>
			</ol>
		</div>
		<!--Page Header-->


		<div class="row row-div-quantity addnewmanager" style="display: none;">
		<div class="col-md-12">
			<div class="card welcome-image">
				<div class="card-body">
					<div class="row">
						<div class="col-md-11">
							<form class="form-recipe-edit" method="post" action="javascript:;">
								<div class="row">
									<div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:10px;">
										<label style="font-weight:bold;">Name</label>
										<input type="hidden" name="calendar_date" id="calendar_date" value="<?=date('Y-m-d')?>">
										<input type="text" name="name" id="name" class="form-control" placeholder="Enter Name">
									</div>
									<div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:10px;">
										<label style="font-weight:bold;">Mobile Number</label>
										<input type="text" name="mobile_number" id="mobile_number" class="form-control contact" placeholder="Enter Mobile Number" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
									</div>
									<div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:10px;">
										<label style="font-weight:bold;">No. Of Person</label>
										<input type="number" name="no_of_person" id="no_of_person" class="form-control" placeholder="Enter No. of persons" min="1">
									</div>
									<div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:10px;">
										<label style="font-weight:bold;">In Time</label>
										<input type="time" name="arrive_time" id="arrive_time" class="form-control">
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

	<div class="row mb-3 row-filter">
		<div class="col-md-2">
			<a href="#" class="btn btn-secondary"  id="addwaitingmanager" style="width: 100%;"><i class="fa fa-plus"></i> Create New</a>
		</div>
		<div class="col-md-5">
			<div class="input-group">
				<input type="text" class="form-control" placeholder="Search Today's waitinglist Cust"  id="searchInput" style="font-size: 17px;">
				<span class="input-group-append">
					<button class="btn btn-primary" type="button" style="border-radius: 4px;border: 0px !important;"><i class="fas fa-search"></i></button>
				</span>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered card-table table-vcenter text-nowrap table-head" cellpadding="3" id="table-recipes">
							<thead>
								<tr>
									<th>Sr.No</th>
									<th id="widthname">Name</th>
									<th id="widthmobile">Mobile Number</th>
									<th id="widthperson">NOS</th>
									<th id="intime">In Time</th>
									<th id="widthaction">Action</th>
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
  <div class="modal fade" id="showwaitingdetails">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Details for <span id="showname"></span></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body detailwaitingcust">
        	
        </div>
        
      </div>
    </div>
  </div>




<!-- <script type="text/javascript">
	$(document).ready( function () {
    $('#example').DataTable();
} );
</script> -->
<script src="<?=base_url();?>assets/js/custom/Todaywaitinglist.js"></script>

<script type="text/javascript">
	Todaywaitinglist.base_url="<?=base_url();?>";
	Todaywaitinglist.init();
	/*$('.recipe-tabs').find('.receipes .card-body').addClass('active');*/
</script>

<script>
$(document).ready(function(){
  $("#addwaitingmanager").click(function(){
    $(".addnewmanager").show();
    $(".addnewmanager").fadeIn("slow");
  });

  $("#closetoggle").click(function(){
  	$(".addnewmanager").hide();
  });
});
</script>

<script>
  $('.contact').on('keypress',function(e){
            var regex = new RegExp("^[0-9]+$");
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
            if (regex.test(str)) {
                return true;
            }
            e.preventDefault();
            return false;
        });
</script>
<script src="<?=base_url();?>assets/plugins/timepickerplugin/tpicker.js"></script>
	
	<?php
require_once('footer.php');
?>