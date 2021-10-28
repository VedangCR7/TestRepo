<?php
require_once('header.php');
require_once('sidebar.php');

?>
<div class=" app-content">
	<div class="side-app">

		<!--Page Header-->
		<div class="page-header">
			<h3 class="page-title"><i class="side-menu__icon fe fe-box mr-1"></i>Create Product</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Create Product</li>
			</ol>
		</div>
		<!--Page Header-->
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
                <div class="card-header">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12 text-right">
                    <input type="file" class="uploadfile" name="uploadFile" value="" style="display: none;" />
			        <button class="btn btn-secondary addcsv" title="Upload CSV file"><i class="fas fa-plus"></i> Add Product With CSV</button>

                    <a href="<?=base_url('assets/ProductCSV.csv')?>" download><button class="btn btn-warning"><i class="fas fa-file-download"></i> Sample CSV</button></a>
                    <a href="<?=base_url('inventory/product_list')?>"><button class="btn btn-info"><i class="fas fa-list-ol"></i> Product List</button></a>
                    </div>
                </div>
				<div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-12 col-12">
                            <input type="text" class="form-control" placeholder="Product Name" id="product_name" style="text-transform: capitalize;">
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-12">
                            <button class="btn btn-primary btn-add-group">Add</button>
                        </div>
                    </div>
				</div>
			</div>
		</div>
		
	</div>
	
<script src="<?=base_url();?>assets/js/custom/Inventoryproduct.js?v=10"></script>

<script type="text/javascript">
	Inventoryproduct.base_url="<?=base_url();?>";
	Inventoryproduct.init();
	/*$('.recipe-tabs').find('.receipes .card-body').addClass('active');*/
</script>
<script>
	setInterval(function() {
                $.ajax({
                    url: "<?=base_url();?>restaurant/set_authority_exist",
                    type:'POST',
                    dataType: 'json',
                    data: {name:'Inventory Management'},
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