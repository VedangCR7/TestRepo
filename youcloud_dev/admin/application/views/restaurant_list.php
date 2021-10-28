<?php
require_once('header.php');
require_once('sidebar.php');

?>
<style type="text/css">
	
	
</style>
<div class=" app-content">
	<div class="side-app">

		<!--Page Header-->
		<div class="page-header">
			<h3 class="page-title"><i class="side-menu__icon fas fa-utensils mr-1"></i> Restaurants</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Restaurants</li>
			</ol>
		</div>
		<!--Page Header-->
	</div>
	<div class="row mb-3 row-filter">
		<div class="col-md-7">
			<div class="input-group">
				<input type="text" class="form-control" placeholder="Search user"  id="searchUserInput" style="">
				<span class="input-group-append">
					<button class="btn btn-primary" type="button" style="border-radius: 0px;"><i class="fas fa-search"></i></button>
				</span>
			</div>
		</div>
		<div class="col-md-2 p-l-5 p-r-5">
			<div class="btn-group per_page m-r-5">
				<button class="btn btn-default dropdown-toggle" data-toggle="dropdown" type="button" aria-expanded="false" selected-per-page="30">
					30 items per page
					<i class="md md-arrow-drop-down"></i>
				</button>
				<ul class="dropdown-menu pull-right" role="menu">
					<li class=""><a data-per="15" class="a-user-perpage" data-preferences='{"per_page":"15"}' href="javascript:;">15</a></li>
					<li class=""><a data-per="30" class="a-user-perpage" data-preferences='{"per_page":"30"}' href="javascript:;">30</a></li>
					<li class=""><a data-per="60" class="a-user-perpage" data-preferences='{"per_page":"60"}' href="javascript:;">60</a></li>
					<li class=""><a data-per="all" class="a-user-perpage" data-preferences='{"per_page":"all"}' href="javascript:;">All (<span class="span-all-users"></span>)</a></li>
				</ul>
			</div>
		</div>
		<div class="col-md-3 p-l-15">
			<div class="btn-group page_links page-no" role="group" style="width: 100%;">
				<button class="btn btn-default btn-prev disabled prev" data-page="prev" type="button">
					<span class="fas fa-angle-left"></span>
				</button>
				<button class="btn btn-default" style="width: 55%;"><b class="span-page-html">0-0</b> of <b class="span-all-users">0</b></button>
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
						<table class="table card-table table-vcenter text-nowrap table-head" id="table-users">
							<thead >
								<tr>
									<th>Name</th>
									<th>Email</th>
									<th>Date</th>
									<th></th>
									<th></th>
								</tr>
							</thead>
							<tbody class="tbody-user-list">
								
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
<script type="text/javascript" src="<?=base_url();?>assets/js/custom/Restaurantuser.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        Restaurantuser.base_url="<?=base_url();?>";
        Restaurantuser.user_status="<?php if(isset($_GET['status'])) echo $_GET['status']; else echo '';?>";
        Restaurantuser.init();
    });
</script>
<script type="text/javascript">
	
	function searchFunction() {
	  var input, filter, table, tr, td, i, txtValue;
	  input = document.getElementById("searchInput");
	  filter = input.value.toUpperCase();
	  table = document.getElementById("table-users");
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
	}
</script>