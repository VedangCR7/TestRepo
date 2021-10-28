<?php
require_once('header.php');
require_once('sidebar.php');

?>
<div class=" app-content">
	<div class="side-app">

		<!--Page Header-->
		<div class="page-header">
			<h3 class="page-title"><i class="side-menu__icon fas fa-utensils mr-1"></i> Bar menu</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Bar menu</li>
			</ol>
		</div>
		<!--Page Header-->
	</div>
	<div class="row mb-3 row-filter">
		<div class="col-md-2">
			<a href="<?=base_url()?>recipes/addrecipe/2" class="btn btn-secondary" style="width: 100%;"><i class="fa fa-plus"></i> Create New</a>
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
				<button class="btn btn-default btn-current-pageno" curr-page="1"><b class="span-page-html">0-0</b> of <b class="span-all-recipes">0</b></button>
				<buton class="btn btn-default btn-next disabled next" data-page="next" type="button">
					<span class="fas fa-angle-right"></span>
				</buton>
			</div>
		</div>
	</div>
	<div class="row row-div-quantity" style="display: none;">
		<div class="col-md-12">
			<div class="card welcome-image">
				<div class="card-body">
					<div class="row">
						<div class="col-md-11">
							<form class="form-recipe-edit" method="post" action="javascript:;">
								<input type="hidden" name="id" class="input-recipe-id">
								<div class="row">
									<div class="col-md-1 text-left">
										<label class="form-label label-header"> Qty 1</label>
									</div>
									<div class="col-md-2">
										<input type="text" name="quantity" value="<?=$recipe['quantity'];?>" class="text-white mt-2 mb-2 form-control input-reciepe-header input-recipe-quantity" onclick="this.select();" id="in-recipe-quantity" placeholder="Ex:10 ml" >
									</div>
									<div class="col-md-1 text-left">
										<label class="form-label label-header"> Price 1</label>
									</div>
									<div class="col-md-2">
										<input type="text" name="price" value="<?=$recipe['price'];?>" class="text-white mt-2 mb-2 form-control input-reciepe-header input-recipe-price" onclick="this.select();" id="in-recipe-price">
									</div>
									<div class="col-md-1 text-left">
										<button type="button" class="btn btn-success btn-add-price" type="button" style="border: 0px !important;margin-top:10px;margin-top: 1rem;"><i class="fas fa-plus"></i></button>
									</div>
									<div class="col-md-2">
									</div>
								</div>
								<div class="div-price-append">
									
								</div>
								
								<div class="row">
									<div class="col-md-7">
										<button type="button" class="btn btn-default btn-clear-priceedit" style="background-color: #ede3e7;;border: 0px !important;float:right;margin-left:10px;margin-top: 1rem;">Cancel</button>
										<button type="submit" class="btn btn-secondary btn-save-details" type="button" style="background-color: #ED3573;border: 0px !important;float:right;margin-top:10px;margin-top: 1rem;">Save</button>
									</div>
									<div class="col-md-2">
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
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
									<th>Image</th>
									<th>Menu</th>
									<th>Menu Group</th>
									<th>Date</th>
									<th>Active/Inactive</th>
									<th></th>
								</tr>
							</thead>
							<tbody class="tbody-recipes-list">
								<!-- <?php
								foreach ($recipes as $recipe) {
								?>
									<tr>
										<td>
											<a href="<?=base_url();?>recipes/create/<?=$recipe['id'];?>" data-id="<?=$recipe['id'];?>" alacala-recipe-id="<?=$recipe['alacal_recipe_id'];?>" style="color:#000;"><?=$recipe['name'];?></a>
										</td>
										<td><?=$recipe['recipe_date'];?></td>
										<td><a href="javascript:;" data-id="<?=$recipe['id'];?>" alacala-recipe-id="<?=$recipe['alacal_recipe_id'];?>"><i class="fas fa-trash c-usda_sr28"></i></a></td>
									</tr>
								<?php
								}
								?> -->
								
								
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
<script src="<?=base_url();?>assets/js/custom/Recipebarlist.js?v=7"></script>

<script type="text/javascript">
	Recipebarlist.base_url="<?=base_url();?>";
	Recipebarlist.group_id="<?php if(isset($_GET['group_id'])) echo $_GET['group_id']; else echo '';?>";
	Recipebarlist.init();
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