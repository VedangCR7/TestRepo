<?php
require_once('header.php');
require_once('sidebar.php');

?>
<div class=" app-content">
	<div class="side-app">

		<!--Page Header-->
		<div class="page-header">
			<h3 class="page-title"><i class="side-menu__icon fe fe-dollar-sign mr-1"></i>Edit Purchase Create</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Edit Purchase Create</li>
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
                            <input type="hidden" id="purchase_id" value="<?=$this->uri->segment(3)?>">
                            <select class="form-control" id="supplier_id">
                                <option value="">Select Supplier</option>
                                <?php foreach($supplier as $key=>$value){
                                    if($purchase_supplier_id[0]['supplier_id'] == $value['id']){
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
                            <input type="text" name="product_name" class="form-control product_name typeahead" onclick="this.select();" placeholder="Enter Product Name" autocomplete="off" id="product_name">
                            <input type="hidden" name="product_id" class="product_id" id="product_id" value="">
                        </div>
                        <input type="hidden" name="row_id" class="input-row" value="">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-4" style="margin-top:10px;">
                            <div style="margin-top:25px;"><button class="btn btn-primary add_product_cart"><i class="fas fa-plus"></i></button></div>
                        </div>
                        <div class="col-lg-12 col-sm-12 col-sm-12 col-12 table-responsive tab-content" style="margin-top:20px;">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th style="width:15%">Qty</th>
                                        <th>Purchase Price</th>
                                    </tr>
                                </thead>
                                <tbody id="showaddeditems">
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2" class="text-right">Grand Total</td>
                                        <td><span id="show_grand_total">&#8377; 0</span><input type="hidden" class="grand_total" id="grand_total" value="0"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12"><hr></div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12 text-right">
                            <!-- <button class="btn btn-primary btn-add-purchase">Save</button> -->
                        </div>
                    </div>
				</div>
			</div>
		</div>	
	</div>
	
<script src="<?=base_url();?>assets/js/custom/Inventorypurchasecreateedit.js?v=10"></script>

<script type="text/javascript">
	Inventorypurchasecreateedit.base_url="<?=base_url();?>";
	Inventorypurchasecreateedit.init();
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