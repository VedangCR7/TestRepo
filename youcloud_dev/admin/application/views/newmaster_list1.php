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
		<div class="col-md-12 mb-4">
			<div class="input-group">
				<input type="text" class="form-control" placeholder="Create menu" id="AddMenuGroup" style="font-size: 15px;">
				<input type="hidden" id="menu_group_id">
				<input type="hidden" id="is_edit_group">
				<!--<select name="main_menu_id" class="form-control select-main-menu" placeholder="Select main menu">
					
				</select>-->
				<input type="text" class="form-control" placeholder="Declaration Name" id="AddMenuGroupDName" style="font-size: 15px;">
				<input type="text" class="form-control" placeholder="Long Description" id="AddMenuGroupTime" style="font-size: 15px;">
				<span class="input-group-append">
					<button class="btn btn-secondary btn-add-group" type="button" style="border-radius: 4px;border: 0px !important;">ADD</button>
				</span>
			</div>
		</div>
	</div>
	<div class="row mb-3 row-filter">
		<div class="col-md-7">
			<div class="input-group">
				<input type="text" class="form-control" placeholder="Search menu"  id="searchInput" style="font-size: 17px;">
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
									<th>Image ID</th>
									<th>Image</th>
									<th style="width: 30%;">Menu Name</th>
									<th>Ingredients</th>
									<th>Long Description</th>
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

<?php
require_once('footer.php');
?>
<script src="<?=base_url();?>assets/js/custom/Newmasterlist1.js?v=4"></script>

<script type="text/javascript">
	Newmasterlist1.base_url="<?=base_url();?>";
	Newmasterlist1.init();
</script>