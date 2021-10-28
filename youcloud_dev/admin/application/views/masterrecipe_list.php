<?php
require_once('header.php');
require_once('sidebar.php');

?>
<style type="text/css">
	.input-price-edit{
		line-height: 60px;
	    border-bottom: 1px solid #fff;
	    border-radius: 0;
	}
</style>
<div class=" app-content">
	<div class="side-app">

		<!--Page Header-->
		<div class="page-header">
			<h3 class="page-title"><i class="side-menu__icon fas fa-utensils mr-1"></i> Menu Management</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Menu Management</li>
			</ol>
		</div>
		<!--Page Header-->
	</div>
	<div class="row mb-3 row-filter">
		<div class="col-md-2">
			<a href="<?=base_url()?>Menumaster/addrecipe/1" class="btn btn-secondary" style="width: 100%;"><i class="fa fa-plus"></i> Create New </a>
		</div>
		<div class="col-md-5">
			<div class="input-group">
				<input type="text" class="form-control" placeholder="Search recipes"  id="searchRecipeInput" style="font-size: 15px;">
				<span class="input-group-append">
					<button class="btn btn-primary" type="button" style="border-radius: 4px;"><i class="fas fa-search"></i></button>
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
					<li class=""><a data-per="15" class="a-recipe-perpage" data-preferences='{"per_page":"15"}' href="javascript:;">15</a></li>
					<li class=""><a data-per="30" class="a-recipe-perpage" data-preferences='{"per_page":"30"}' href="javascript:;">30</a></li>
					<li class=""><a data-per="60" class="a-recipe-perpage" data-preferences='{"per_page":"60"}' href="javascript:;">60</a></li>
					<li class=""><a data-per="all" class="a-recipe-perpage" data-preferences='{"per_page":"all"}' href="javascript:;">All (<span class="span-all-recipes"></span>)</a></li>
				</ul>
			</div>
		</div>
		<div class="col-md-3 p-l-20">
			<div class="btn-group page_links page-no" role="group">
				<button class="btn btn-default btn-prev disabled prev" data-page="prev" type="button">
					<span class="fas fa-angle-left"></span>
				</button>
				<button class="btn btn-default"><b class="span-page-html">0-0</b> of <b class="span-all-recipes">0</b></button>
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
									<th style="width: 30%!important;">Menu</th>
									<th style="width: 30%!important;">Long Description</th>
									<th>Declaration Name</th>
									<th></th>
								</tr>
							</thead>
							<tbody class="tbody-recipes-list">
								
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
<script src="<?=base_url();?>assets/js/custom/Masterrecipelist.js?v=1"></script>

<script type="text/javascript">
	Masterrecipelist.base_url="<?=base_url();?>";
	Masterrecipelist.group_id="<?php if(isset($_GET['group_id'])) echo $_GET['group_id']; else echo '';?>";
	Masterrecipelist.is_category_prices="<?=$_SESSION['is_category_prices'];?>";
	Masterrecipelist.init();
</script>