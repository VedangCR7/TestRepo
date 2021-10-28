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
			<h3 class="page-title"><i class="side-menu__icon fe fe-zap mr-1"></i> <span class="span-master-menuname">Restaurant menu</span></h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page"><span class="span-master-menuname">Restaurant menu</span></li>
			</ol>
		</div>
		<!--Page Header-->
	</div>
	<div class="row">
		<div class="col-md-1 text-center">
			<input type="file" class="uploadfile" name="uploadFile" value="" style="display: none;" />
			<button class="btn btn-info addcsv" title="Upload excel file" style="padding:5px 10px;width:45%"><i class="far fa-file-excel" style="font-size:15px;"></i></button>

			<a href="<?=base_url_path.'assets/menuExcelfinal.xlsx'?>" download>
				<kbd class="btn btn-warning" title="Download Sample Excel File" style="padding:5px 10px;width:45%"><i class="fas fa-file-download" style="font-size:15px;"></i></kbd>
			</a>
		</div>
	</div>
	<div class="row mb-3 row-filter" style="margin-top:10px;">
		<div class="col-md-2">
			<select class="form-control" id="master_menu">
				<?php foreach ($mainmenu as $key => $value) { ?>
					<option value="<?=$value['id']?>"><?=$value['name']?></option>
				<?php } ?>
				<option value="New">New</option>				
			</select>
		</div>
		<div class="col-md-1 hide_add_new_recipe">
			<a href="javascript:;" class="btn btn-secondary pl-1 pr-1 text-center new-recipe-a" style="width: 100%;">
				<!-- <a href="<?=base_url()?>recipes/addrecipe/1" class="btn btn-secondary" style="width: 100%;"> -->
				<i class="fa fa-plus"></i> New
			</a>
		</div>
		<div class="col-md-4">
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
				<button class="btn btn-default btn-next disabled next" data-page="next" type="button">
					<span class="fas fa-angle-right"></span>
				</button>
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
								<input type="hidden" name="recipe_price_count" value="0" class="inupt-recipe-pricecount">
								<div class="row">
									<div class="col-md-2 text-left">
										<label class="form-label label-header">Table Category 1</label>
                        				<input type="hidden" name="recipe_price_id" value="" class="input-reciperpice-id1">
									</div>
									<div class="col-md-3">
										<select name="quantity" value="<?=$recipe['quantity'];?>" class="text-white mt-2 mb-2 form-control input-reciepe-header input-recipe-tablecat" id="in-recipe-quantity1">
											
										</select>
									</div>
									<div class="col-md-1 text-left">
										<label class="form-label label-header"> Price 1</label>
									</div>
									<div class="col-md-2">
										<input type="text" name="price" value="<?=$recipe['price'];?>" class="text-white mt-2 mb-2 form-control input-reciepe-header input-recipe-price" onclick="this.select();" id="in-recipe-price1">
									</div>
									<div class="col-md-1 text-left">
										<button type="button" class="btn btn-success btn-add-tableprice" type="button" style="border: 0px !important;margin-top:10px;margin-top: 1rem;"><i class="fas fa-plus"></i></button>
									</div>
									<div class="col-md-2">
									</div>
								</div>
								<div class="div-price-append">
									
								</div>
								
								<div class="row">
									<div class="col-md-9">
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
	<div class="row" style="min-height:400px;">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<?php
					if($group_not_recipescnt>0){
					?>
					<div class="alert alert-warning">
						Group not added for for all menus <a href="<?=base_url();?>recipes/group_not_selected">click here</a> to see list.
					</div>
					<?php
					}
					?>
					<div class="table-responsive">
						<table class="table card-table table-vcenter text-nowrap table-head" id="table-recipes">
							<thead >
								<tr>
									<th>Product Code</th>
									<th>Image</th>
									<th>Menu</th>
									<th>Menu Group</th>
									<th>Price</th>
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

	<!-- The Modal -->
<!-- <div class="modal" id="choosemastermenu">
  <div class="modal-dialog">
    <div class="modal-content">

     
      <div class="modal-header">
        <h4 class="modal-title">Create New Recipes</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

     
      <div class="modal-body">
      	<div class="col-lg-12 col-md-12 col-sm-12 col-12">
      		<label style="font-weight:bold;">Choose Master Menu</label>
      		<select class="form-control" id="recipe_master_menu">
				<?php foreach ($master_menu as $key => $value) { ?>
					<option value="<?=$value['id']?>"><?=$value['name']?></option>
				<?php } ?>
			</select>
      	</div>
      	<div class="col-lg-12 col-md-12 col-sm-12 col-12 text-center">
		<a href="" id="changelink"><button class="btn btn-primary" style="margin-top:10px;">Create</button></a>
		</div>
      </div>

    </div>
  </div>
</div> -->
	
<?php
require_once('footer.php');
?>
<script src="<?=base_url();?>assets/js/custom/Recipelist.js?v=<?php uniqid();?>"></script>

<script type="text/javascript">
	Recipelist.base_url="<?=base_url();?>";
	Recipelist.group_id="<?php if(isset($_GET['group_id'])) echo $_GET['group_id']; else echo '';?>";
	Recipelist.main_menu_id="<?php if(isset($_GET['main_menu_id'])) echo $_GET['main_menu_id']; else echo '';?>";
	Recipelist.is_category_prices="<?=$_SESSION['is_category_prices'];?>";
	Recipelist.init();
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
