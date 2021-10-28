<?php
require_once('header.php');
require_once('sidebar.php');
?>

<div class=" app-content">
	<div class="side-app">

		<!--Page Header-->
		<div class="page-header">
			<h3 class="page-title"><i class="side-menu__icon fas fa-utensils mr-1"></i> Customers</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Customers</li>
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
										<label style="font-weight:bold;">Name</label>
										<input type="text" name="name" id="name" class="form-control" placeholder="Enter Name" onChange="chkNameVal()">
									</div>
									<div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;">
										<label style="font-weight:bold;">Email</label>
										<input type="text" name="email" id="email" class="form-control" placeholder="Enter Email">
									</div>
									<div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;">
										<label style="font-weight:bold;">Contact Number</label>
										<input type="text" name="contact_number" id="contact_number" class="form-control" placeholder="Enter Contact Number" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"/>
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
	<!-- <form action="<?php echo base_url();?>restaurant/uploadData" method="post" enctype="multipart/form-data">
    Upload excel file : 
    <input type="file" id="uploadfile" name="uploadFile" value="" /><br><br>
    <input type="submit" name="submit" value="Upload" />
</form> -->
	<div class="row mb-3 row-filter">
		<div class="col-md-1 text-center">
			<input type="file" class="uploadfile" name="uploadFile" value="" style="display: none;" />
			<button class="btn btn-info addcsv" title="Upload excel file" style="padding:5px 10px;width:40%"><i class="far fa-file-excel" style="font-size:15px;"></i></button>

			<a href="<?=base_url('assets/sampleexcel.xlsx')?>" download><button class="btn btn-warning" title="Download Sample Excel File" style="padding:5px 10px;width:40%"><i class="fas fa-file-download" style="font-size:15px;"></i></button></a>
		</div>
		<div class="col-md-2">
			<a href="#" class="btn btn-primary"  id="addwaitingmanager" style="width: 100%;"><i class="fa fa-plus"></i> Create New</a>
		</div>
		<div class="col-md-4">
			<div class="input-group">
				<input type="text" class="form-control" placeholder="Search Customers"  id="searchInput" style="font-size: 17px;">
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
				<button class="btn btn-default btn-current-pageno" curr-page="1"><b class="span-page-html">0-0</b> of <b class="span-all-groups">0</b></button>
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
									<th style="width: 30%;">Name</th>
									<th>Email</th>
									<th>Contact No.</th>
									<th>Block/Unblock</th>
									<th></th>
								</tr>
							</thead>
							<tbody class="tbody-customer-list">
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		
	</div>

<?php
require_once('footer.php');
?>
<script src="<?=base_url();?>assets/js/custom/Whatsappcust.js?v=5"></script>

<script type="text/javascript">
	Whatsappcust.base_url="<?=base_url();?>";
	Whatsappcust.init();
	/*$('.recipe-tabs').find('.receipes .card-body').addClass('active');*/
</script>
<script type="text/javascript">
	/*function searchFunction() {
	  var input, filter, table, tr, td, i, txtValue;
	  input = document.getElementById("searchInput");
	  filter = input.value.toUpperCase();
	  table = document.getElementById("table-recipes");
	  tr = table.getElementsByTagName("tr");
	  for (i = 0; i < tr.length; i++) {
	    td = tr[i].getElementsByTagName("td")[0];
	    if (td) {
	      txtValue = td.textContent || td.innerText;
	      if (txtValue.toUpperCase().indexOf(filter) > -1) {
	        tr[i].style.display = "";
	      } else {
	        tr[i].style.display = "none";
	      }
	    }       
	  }
	}*/
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

