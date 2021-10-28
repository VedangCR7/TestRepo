<?php
require_once('header.php');
require_once('sidebar.php');

?>
<div class=" app-content">
	<div class="side-app">

		<!--Page Header-->
		<div class="page-header">
			<h3 class="page-title"><i class="side-menu__icon fas fa-utensils mr-1"></i>Employee Master</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Employee Master</li>
			</ol>
		</div>
		<!--Page Header-->
	</div>

	<div class="row row-div-quantity addEmployeeDetails" style="display: none;">
		<div class="col-md-12">
			<div class="card welcome-image">
				<div class="card-body">
					<div class="row">
						<div class="col-md-11">
							<form class="form-recipe-edit" method="post" action="javascript:;">
								<div class="row" style="justify-content: center;">								
                                    <div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:10px;">
										<label style="font-weight:bold;">Category *</label>										
                                        <select class="form-control" id="emp_category" required></select>
									</div>
									<div class="col-lg-3 col-md-3 col-sm-12 col-12 clssubCategory" style="margin-top:10px;">
										<label style="font-weight:bold;">Sub-Category</label>										
                                        <select class="form-control" id="emp_sub_category"></select>
									</div>
									<div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:10px;">
										<label style="font-weight:bold;">Name *</label>
										<input type="text" name="emp_name" id="emp_name" required class="form-control" placeholder="Enter Name">
									</div>
									<div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:10px;">
										<label style="font-weight:bold;">Email</label>
										<input type="email" name="emp_email" id="emp_email" class="form-control" placeholder="Enter Email">
									</div>									
								</div>
                                <div class="row" style="justify-content: center;">	
                                    <div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:10px;">
										<label style="font-weight:bold;">Contact Number *</label>
										<input type="text" name="emp_contact" id="emp_contact" minlength="5" maxlength="14" required class="form-control" placeholder="Enter Contact Number" onkeypress="return onlyNumberKey(event)">
									</div>								
									<div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:10px;">
										<label style="font-weight:bold;">Address</label>
										<input type="text" name="name" id="emp_address" class="form-control" placeholder="Enter Address">
									</div>
									<div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:10px;">
										<label style="font-weight:bold;">Aadhaar Card *</label>
										<input type="text" name="emp_aadhaar_no" id="emp_aadhaar_no" minlength="4" maxlength="12" required class="form-control" placeholder="Enter Aadhaar no" onkeypress="return onlyNumberKey(event)">
									</div>									
								</div>
								<div class="row m-5" style="justify-content: center;">									
                                         <button type="submit" class="btn btn-secondary btn-save-details btn-add-group" type="button" style="background-color: #ED3573;border: 0px !important;float:right;margin-top:10px;margin-top: 1rem;">Save</button>
										<button type="button" class="btn btn-default" id="closetoggle" style="background-color: #ede3e7;;border: 0px !important;float:right;margin-left:10px;margin-top: 1rem;">Cancel</button>																		
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
			<a href="#" class="btn btn-secondary"  id="addEmployemodel" style="width: 100%;"><i class="fa fa-plus"></i> Create New</a>
		</div>
		<div class="col-md-5">
			<div class="input-group">
				<input type="text" class="form-control" placeholder="Search Employee"  id="searchInput" style="font-size: 17px;">
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
									<!-- <th>Sr.No</th> -->
									<th>Employee Name</th>
									<th>Category</th>
									<th>Sub Category</th>
									<th>Incentives</th>
									<th>Email</th>
									<th>Contact No.</th>
									<th>Address</th>
                                    <!-- <th>Date</th> -->
                                    <th>Aadhaar No.</th>
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
	
<script src="<?=base_url();?>assets/js/custom/EmployeeDetails.js?v=<?php echo uniqid();?>"></script>

<script type="text/javascript">
	EmployeeDetails.base_url="<?=base_url();?>";
	EmployeeDetails.init();
</script>
<script>
$(document).ready(function(){
  $("#addEmployemodel").click(function(){
    $('.edit_manager').hide();
    $(".addEmployeeDetails").show();
    $(".addEmployeeDetails").fadeIn("slow");
    
  });

  $("#closetoggle").click(function(){
  	$(".addEmployeeDetails").hide();	  
      $('#emp_name').val('');
      $('#emp_email').val('');
      $('#emp_contact').val('');
      $('#emp_address').val('');
      $('#emp_aadhaar_no').val('');
  });
});
</script>

<script> 
    function onlyNumberKey(evt) { 
         
        // Only ASCII charactar in that range allowed 
        var ASCIICode = (evt.which) ? evt.which : evt.keyCode 
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57)) 
            return false; 
        return true; 
    } 
</script> 
<script>
	setInterval(function() {
                $.ajax({
                    url: "<?=base_url();?>restaurant/set_authority_exist",
                    type:'POST',
                    dataType: 'json',
                    data: {name:'Incentive'},
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