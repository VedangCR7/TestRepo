<?php
require_once('header.php');
require_once('sidebar.php');

?>
<div class=" app-content">
	<div class="side-app">

		<!--Page Header-->
		<div class="page-header">
			<h3 class="page-title"><i class="side-menu__icon fe fe-printer mr-1"></i>Invoice</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Invoice</li>
			</ol>
		</div>
		<!--Page Header-->
	</div>
	<div class="row mb-3 row-filter">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-md-3">
							<label>From Date</label>
							<input type="date" required name="" id="from_date" value="<?=date('Y-m-d')?>" class="form-control">
						</div>
						<div class="col-md-3">
							<label>To Date</label>
							<input type="date" required name="" id="to_date" value="<?=date('Y-m-d')?>" class="form-control">
						</div>
						<div class="col-md-3">
							<button class="btn btn-primary searchdate" style="margin-top:25px;"><i class="fas fa-search"></i> Search</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row mb-3 row-filter">
		<div class="col-md-6">
			<div class="input-group">
				<input type="text" class="form-control" placeholder="Search Invoice Number"  id="searchInput" style="font-size: 17px;">
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
		<div class="col-md-4 p-l-10">
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
		<div class="col-md-12" style="min-height:320px;">
			<div class="card">
				<div class="card-body">
					<div class="table-responsive">
						<table class="table card-table table-vcenter text-nowrap table-head" id="table-recipes">
							<thead >
								<tr>
									<th>Sr.No</th>
									<th>Invoice Number</th>
									<th>Customer Name</th>
									<th>Order From</th>
									<th>Net Total</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody class="tbody-group-list">
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		

		<!-- The Modal -->
<div class="modal" id="showinvoicedetails">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Invoice Details</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body" id="showdetails">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-12"><a href="<?=base_url('restaurant/downloadpdfinvoice')?>" id="redirect_page"><button class="btn btn-primary">Download PDF</button></a></div>
		</div>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-12 text-right">
				<img src="<?=base_url('assets/images/brand/FoodNAILoginLogo.png')?>" height="50px" weight="100px;">
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-12">
				<p>Thank You for choosing Youcloud , <span class="custname"> </span> ! Here are your order details : </p>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">
				<p>Invoice No. : <b><span id="invoiceno" style="font-weight:bold"></span></b></p>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">
				<p>Delivery To : </p>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">
				<p>Order Placed at. : <b><span id="invoicedate" style="font-weight:bold"></span></b></p>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">
				<b class="custname" style="font-weight:bold"></b>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">
				<p>Status : <b><span id="invoicestatus" style="font-weight:bold"></span></b></p>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">
				<p>Customer Contact : <b><span id="custcontact" style="font-weight:bold"></span></b></p>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:20px;">
				<p>Ordered from :</p>
				<p style="font-weight:bold"><?=$_SESSION['business_name']?></p>
			</div>
		</div>

		<div class="row">
        	<div class="col-lg-12 col-md-12 col-sm-12 col-12 table-responsive">
        		<table class="table table-striped" style="margin-top:20px;">
        			<thead>
        				<tr>
        					<th>Menu Name</th>
        					<th>Qty</th>
        					<th  class="text-right">Price</th>
        					<th  class="text-right">Total</th>
        				</tr>
        			</thead>
        			<tbody id="showrecipes">
        				
        			</tbody>
        			<tfoot>
        				<tr style="font-weight: bold;">
        					<td colspan="3" style="text-align: right;">Sub Total</td>
        					<td id="sub_total" style="text-align: right;"></td>
        				</tr>
        				<tr style="font-weight: bold;">
        					<td colspan="3" style="text-align: right;">Discount Total</td>
        					<td id="dis_total" style="text-align: right;"></td>
        				</tr>
						<tr style="font-weight: bold;">
        					<td colspan="3" style="text-align: right;">CGST Total</td>
        					<td style="text-align: right;">0.00</td>
        				</tr>
						<tr style="font-weight: bold;">
        					<td colspan="3" style="text-align: right;">SGST Total</td>
        					<td style="text-align: right;">0.00</td>
        				</tr>
        				<tr style="font-weight: bold;">
        					<td colspan="3" style="text-align: right;">Net Total</td>
        					<td id="net_total" style="text-align: right;"></td>
        				</tr>
        			</tfoot>
        		</table>
        	</div>

        <!--<div class="row">
        	<div class="col-lg-6 col-md-6 col-sm-6 col-6">
        		<span id="invoiceno">Invoice No. : </span>
        	</div>
        	<div class="col-lg-6 col-md-6 col-sm-6 col-6">
        		<span id="tableno">Table No. : </span>
        	</div>
        </div>
        <div class="row" style="margin-top:10px">
        	<div class="col-lg-6 col-md-6 col-sm-6 col-6">
        		<span id="custname">Customer Name : </span>
        	</div>
        	<div class="col-lg-6 col-md-6 col-sm-6 col-6">
        		<span id="custcontact">Customer Contact : </span>
        	</div>
        </div>
        <div class="row">
        	<div class="col-lg-12 col-md-12 col-sm-12 col-12 table-responsive">
        		<table class="table table-bordered table-striped" style="margin-top:10px;">
        			<thead>
        				<tr>
        					<th>Menu Name</th>
        					<th>Qty</th>
        					<th>Price</th>
        					<th>Total</th>
        				</tr>
        			</thead>
        			<tbody id="showrecipes">
        				
        			</tbody>
        			<tfoot>
        				<tr style="font-weight: bold;">
        					<td colspan="3" style="text-align: right;">Sub Total</td>
        					<td id="sub_total" style="text-align: right;"></td>
        				</tr>
        				<tr style="font-weight: bold;">
        					<td colspan="3" style="text-align: right;">Discount Total</td>
        					<td id="dis_total" style="text-align: right;"></td>
        				</tr>
        				<tr style="font-weight: bold;">
        					<td colspan="3" style="text-align: right;">Net Total</td>
        					<td id="net_total" style="text-align: right;"></td>
        				</tr>
        			</tfoot>
        		</table>
        	</div>
        </div>-->
			

						   
								
																						
      </div>

    </div>
  </div>
</div>

	</div>
	
<script src="<?=base_url();?>assets/js/custom/Invoicedetails.js?v=<?php echo uniqid();?>"></script>

<script type="text/javascript">
	Invoicedetails.base_url="<?=base_url();?>";
	Invoicedetails.init();
	Invoicedetails.currency_symbol="<?=$currency_symbol[0]['currency_symbol']?>";
	/*$('.recipe-tabs').find('.receipes .card-body').addClass('active');*/
</script>
<script>
	setInterval(function() {
                $.ajax({
                    url: "<?=base_url();?>restaurant/set_authority_exist",
                    type:'POST',
                    dataType: 'json',
                    data: {name:'invoice'},
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