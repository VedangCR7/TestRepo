<?php
require_once('header.php');
require_once('sidebar.php');

?>
<script src="<?=base_url()?>assets/plugins/browserButton/javascripts/scale.fix.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/plugins/browserButton/jquery.backDetect.js"></script>
<div class=" app-content">
	<div class="side-app">

		<!--Page Header-->
		<div class="page-header">
			<h3 class="page-title"><a href="<?=base_url('reports/customer_report')?>"><i class="fe fe-arrow-left"></i></a> Invoice</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Invoice</li>
			</ol>
		</div>
		<!--Page Header-->
	</div>
	<div class="row mb-3 row-filter">
		<div class="col-md-2">
			<select class="form-control" id="payment_status">
				<option value="">Select Payment Status</option>
				<option value="Paid">Paid</option>
				<option value="Unpaid">Unpaid</option>
			</select>
		</div>
		<div class="col-md-5">
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
					<input type="hidden" name="customer_id" value="<?=$this->uri->segment(3)?>" id="customer_id">
					<div class="table-responsive">
						<table class="table card-table table-vcenter text-nowrap table-head" id="table-recipes">
							<thead >
								<tr>
									<th>Sr.No</th>
									<th>Invoice Number</th>
									<th>Customer Name</th>
									<th>Table Number</th>
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
        					<th>Recipe Name</th>
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
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>
	</div>
	
<script src="<?=base_url();?>assets/js/custom/Reportinvoicedetails.js?v=2"></script>
<script type="text/javascript">
	Reportinvoicedetails.base_url="<?=base_url();?>";
	Reportinvoicedetails.init();
	Reportinvoicedetails.currency_symbol = "<?=$currency_symbol[0]['currency_symbol']?>";
	/*$('.recipe-tabs').find('.receipes .card-body').addClass('active');*/
</script>
<script>
	setInterval(function() {
                $.ajax({
                    url: "<?=base_url();?>restaurant/set_authority_exist",
                    type:'POST',
                    dataType: 'json',
                    data: {name:'Reports'},
                    success: function(result){
                        if(result.status){
                            window.location.href="<?=base_url();?>restaurant/dashboard";
                        }
                   	}
                });
            },5000);
</script>
<script>
        $(window).load(function(){
          $('body').backDetect(function(){
          });
        });
    </script>
<?php
require_once('footer.php');
?>