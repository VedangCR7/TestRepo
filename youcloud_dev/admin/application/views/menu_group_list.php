<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('header.php');
require_once('sidebar.php');

?>

<div class=" app-content">
	<div class="side-app">

		<!--Page Header-->
		<div class="page-header">
			<h3 class="page-title"><i class="side-menu__icon fas fa-utensils mr-1"></i> Menu Groups</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Menu Groups</li>
			</ol>
		</div>
		<!--Page Header-->
	</div>
	<div class="row">
		<div class="col-md-1 text-center">
			<input type="file" class="uploadfile" name="uploadFile" value="" style="display: none;" />
			<button class="btn btn-info addcsv" title="Upload excel file" style="padding:5px 10px;width:45%"><i class="far fa-file-excel" style="font-size:15px;"></i></button>

			<a href="<?=base_url_path.'assets/menuGroupExcel.xlsx'?>" download>
				<kbd class="btn btn-warning" title="Download Sample Excel File" style="padding:5px 10px;width:45%"><i class="fas fa-file-download" style="font-size:15px;"></i></kbd>
			</a>
		</div>
		<div class="col-md-8 mb-3">
			<div class="input-group">
				<input type="text" class="form-control" placeholder="Create menu group" id="AddMenuGroup" style="font-size: 15px;text-transform: capitalize;">&nbsp;
				<input type="hidden" id="menu_group_id">
				<input type="hidden" id="is_edit_group">
				<select name="main_menu_id" class="form-control select-main-menu" placeholder="Select main menu">
					
				</select>&nbsp;
				<input type="text" class="form-control" placeholder="Time" id="AddMenuGroupTime" style="font-size: 15px;">&nbsp;
				<span class="input-group-append">
					<button class="btn btn-secondary btn-add-group" type="button" style="border-radius: 4px;border: 0px !important;">ADD</button>
				</span>
			</div>
		</div>		
	</div>
	<div class="row mb-3 row-filter">
		<div class="col-md-7">
			<div class="input-group">
				<input type="text" class="form-control" placeholder="Search menu group"  id="searchInput" style="font-size: 17px;">
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
				<button class="btn btn-default btn-next disabled next" data-page="next" type="button">
					<span class="fas fa-angle-right"></span>
				</button>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12" style="min-height:400px;">
			<div class="card">
				<div class="card-body">
					<div class="table-responsive">
						<table class="table card-table table-vcenter text-nowrap table-head" id="table-recipes">
							<thead >
								<tr>
									<th></th>
									<th>Image</th>
									<th>Menu Group ID</th>
									<th style="width: 30%;">Menu Group</th>
									<th>Time</th>
									<th>Master menu</th>
									<th>Date</th>
									<th>Active/Inactive</th>
									<th></th>
								</tr>
							</thead>
							<tbody class="tbody-group-list">
					<!-- 			<tr>
									<td>
										Menu Group 12
									</td>
									<td>24 Mar 2020</td>
									<td class="text-center">
										<label class="custom-switch pl-0">
											<input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" checked>
											<span class="custom-switch-indicator"></span>
										</label>
									</td>
								</tr>
								<tr>
									<td>
										Menu Group 13
									</td>
									<td>24 Mar 2020</td>
									<td class="text-center">
										<label class="custom-switch pl-0">
											<input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
											<span class="custom-switch-indicator"></span>
										</label>
									</td>
								</tr>
								<tr>
									<td>
										Menu Group 14
									</td>
									<td>24 Mar 2020</td>
									<td class="text-center">
										<label class="custom-switch pl-0">
											<input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
											<span class="custom-switch-indicator"></span>
										</label>
									</td>
								</tr>
								<tr>
									<td>
										Menu Group 15
									</td>
									<td>24 Mar 2020</td>
									<td class="text-center">
										<label class="custom-switch pl-0">
											<input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" checked>
											<span class="custom-switch-indicator"></span>
										</label>
									</td>
								</tr>
								<tr>
									<td>
										Menu Group 16
									</td>
									<td>24 Mar 2020</td>
									<td class="text-center">
										<label class="custom-switch pl-0">
											<input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" checked>
											<span class="custom-switch-indicator"></span>
										</label>
									</td>
								</tr> -->
								
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
<script src="<?=base_url();?>assets/js/custom/Menugrouplist.js?v=<?php echo uniqid();?>"></script>

<script type="text/javascript">
	Menugrouplist.base_url="<?=base_url();?>";
	Menugrouplist.init();
	/*$('.recipe-tabs').find('.receipes .card-body').addClass('active');*/
</script>
<script>
	setInterval(function() {
                $.ajax({
                    url: "<?=base_url();?>restaurant/set_authority_exist",
                    type:'POST',
                    dataType: 'json',
                    data: {name:'Menu'},
                    success: function(result){
                        if(result.status){
                            window.location.href="<?=base_url();?>restaurant/dashboard";
                        }
                   	}
                });
            },5000);
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

