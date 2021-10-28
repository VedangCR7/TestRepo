<?php
require_once('header.php');
require_once('sidebar.php');

?>
<!-- select2 Plugin -->
<link href="<?=base_url()?>assets/plugins/select2/select2.min.css" rel="stylesheet" />
<div class=" app-content">
	<div class="side-app">

		<!--Page Header-->
		<div class="page-header">
			<h3 class="page-title"><i class="side-menu__icon fas fa-utensils mr-1"></i>Edit Product Assign to kitchen</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Edit Product Assign to kitchen</li>
			</ol>
		</div>
		<!--Page Header-->
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">
                        
                            <label>Supplier</label>
                            <input type="hidden" id="assign_id" value="<?=$this->uri->segment(3)?>">
                            <select class="form-control" id="supplier_id">
                                <option value="">Select Supplier</option>
                                <?php foreach($supplier as $key=>$value){
                                    if($value['id'] == $assign_kitchen_details[0]['supplier_id']){
                                    ?>
                                    <option value="<?=$value['id']?>" selected><?=$value['company_name']?></option>
                                    <?php
                                    }
                                    else{
                                        ?>
                                        <option value="<?=$value['id']?>"><?=$value['company_name']?></option>
                                        <?php
                                    }
                                } ?>
                            </select>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">
                            <label>Date</label>
                            <input type="date" id="date" class="form-control" value="<?=date('Y-m-d')?>">
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-8 col-8" style="margin-top:10px;">
                            <label>Product</label>
                            <select class="select2-show-search product_id" id="show_product" data-placeholder="Choose Product" style="width:100%;">
                                
                            </select>
                            <!-- <input type="text" name="product_name" class="form-control product_name typeahead" onclick="this.select();" placeholder="Enter Product Name" autocomplete="off" id="product_name"> -->
                            <input type="hidden" name="product_name" class="product_name" id="product_name" value="">
                            <input type="hidden" name="product_qty" class="product_qty" id="product_qty" value="">
                            <!-- <input type="text" name="product_name" class="form-control product_name typeahead" onclick="this.select();" placeholder="Enter Product Name" autocomplete="off" id="product_name">
                            <input type="text" name="product_id" class="product_id" id="product_id" value="">
                            <input type="text" name="product_qty" class="product_qty" id="purchase_qty" value=""> -->
                        </div>

                        <input type="hidden" name="row_id" class="input-row" value="">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-4" style="margin-top:10px;">
                            <div style="margin-top:25px;"><button class="btn btn-primary add_product_cart"><i class="fas fa-plus"></i></button></div>
                        </div>
                        <div class="col-lg-12 col-sm-12 col-sm-12 col-12 table-responsive" style="margin-top:20px;">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Available Qty</th>
                                        <th>Assign Qty</th>
                                        <th>Remaining Qty</th>
                                    </tr>
                                </thead>
                                <tbody id="showaddeditems">
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>Total</td>
                                        <td><input type="hidden" id="available_qty_sum"><span id="avq">0</span></td>
                                        <td><input type="hidden" id="assign_qty_sum"><span id="asq">0</span></td>
                                        <td><input type="hidden" id="remaining_qty_sum"><span id="req">0</span></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12"><hr></div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12 text-right">
                            <!-- <button class="btn btn-primary btn-add-purchase">Assign to kitchen</button> -->
                        </div>
                    </div>
				</div>
			</div>
		</div>
		
	</div>
<!-- Inline js -->
<script src="<?=base_url()?>assets/js/select2.js"></script>	
<script src="<?=base_url();?>assets/js/custom/Inventoryproductassignedit.js?v=<?=uniqid()?>"></script>

<script type="text/javascript">
	Inventoryproductassign.base_url="<?=base_url();?>";
	Inventoryproductassign.init();
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