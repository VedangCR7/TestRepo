<?php
require_once('header.php');
require_once('sidebar.php');
?>
<div class=" app-content">
	<div class="side-app">
		<!--Page Header-->
		<div class="page-header">
			<h3 class="page-title"><i class="fe fe-home mr-1"></i> Online Orders</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Online Orders</li>
			</ol>
		</div>
		<div class="row mb-3 row-filter">
			<div class="col-md-2">
				<input type="date" required class="form-control search-order-date" name="search_order_date" value="<?=date('Y-m-d')?>">
			</div>
			<div class="col-md-5 div-search-input">
				<div class="input-group">
					<input type="text" class="form-control" placeholder="Search order"  id="searchRecipeInput" style="font-size: 15px;">
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
						<li class=""><a data-per="all" class="a-recipe-perpage" data-preferences='{"per_page":"all"}' href="javascript:;">All (<span class="span-all-orders"></span>)</a></li>
					</ul>
				</div>
			</div>
			<div class="col-md-3 p-l-20">
				<div class="btn-group page_links page-no" role="group">
					<button class="btn btn-default btn-prev disabled prev" data-page="prev" type="button">
						<span class="fas fa-angle-left"></span>
					</button>
					<button class="btn btn-default btn-current-pageno" curr-page="1"><b class="span-page-html">0-0</b> of <b class="span-all-orders">0</b></button>
					<buton class="btn btn-default btn-next disabled next" data-page="next" type="button">
						<span class="fas fa-angle-right"></span>
					</buton>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12" style="min-height:450px;">
			<div class="card">
				<div class="card-body">
					<div class="table-responsive mt-2 table-tablewise-orders">
						<table class="table card-table table-vcenter text-nowrap table-head" id="table-tablewise-orders">
							<thead>
								<tr>
									<th>Order No</th>
									<th>Order Type</th>
									<th>Delivery Address</th>
									<th>Datetime</th>
									<th>Process Time</th>
									<th>Order Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody class="tbody-tablewiseorder-list">
							
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

<script src="<?=base_url();?>assets/js/custom/WebOrders.js?v=<?php echo uniqid();?>"></script>
<script type="text/javascript">
	WebOrders.base_url="<?=base_url();?>";
	WebOrders.init();
	/*$('.recipe-tabs').find('.receipes .card-body').addClass('active');*/
</script>

<script>
	setInterval(function() {
                $.ajax({
                    url: "<?=base_url();?>restaurant/set_authority_exist",
                    type:'POST',
                    dataType: 'json',
                    data: {name:'Order'},
                    success: function(result){
                        if(result.status){
                            window.location.href="<?=base_url();?>restaurant/dashboard";
                        }
                   	}
                });
            },5000);
</script>
