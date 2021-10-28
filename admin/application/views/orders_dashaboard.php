<?php
require_once('header.php');
require_once('sidebar.php');
?>
<div class=" app-content">
	<div class="side-app">
		<!--Page Header-->
		<div class="page-header">
			<h3 class="page-title"><i class="fe fe-home mr-1"></i> Orders</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Orders</li>
			</ol>
		</div>
		<div class="row">
			<div class="col-xl-3 col-lg-6 col-md-12 col-sm-6">
				<a href="javascript:;" class="a-filter-order" status="New">
					<div class="card">
						<div class="card-body">
							<div class="d-flex mb-4">
								<span class="avatar align-self-center avatar-lg br-7 cover-image bg-warning-transparent">
									<i class="fe fe-plus text-warning"></i>
								</span>
								<div class="svg-icons text-right ml-auto">
									<h5 class="text-muted">New Orders</h5>
									<h2 class="mb-0 font-weight-extrabold num-font">
										<?=$pending;?>
									</h2>
								</div>
							</div>
							<div class="progress progress-md h-2">
								<div class="progress-bar progress-bar-striped progress-bar-animated bg-warning w-100"></div>
							</div>
						</div>
					</div>
				</a>
			</div>
			<div class="col-xl-3 col-lg-6 col-md-12 col-sm-6">
				<a href="javascript:;" class="a-filter-order" status="Assigned To Kitchen">
					<div class="card">
						<div class="card-body">
							<div class="d-flex mb-4">
								<span class="avatar align-self-center avatar-lg br-7 cover-image bg-secondary-transparent">
									<i class="fas fa-utensils text-secondary"></i>
								</span>
								<div class="svg-icons text-right ml-auto">
									<h5 class="text-muted">Assign To Kitchen</h5>
									<h2 class="mb-0 font-weight-extrabold num-font">
										<?=$assigned;?>
									</h2>
								</div>
							</div>
							<div class="progress progress-md h-2">
								<div class="progress-bar progress-bar-striped progress-bar-animated bg-secondary w-100"></div>
							</div>
						</div>
					</div>
				</a>
			</div>
			<div class="col-xl-3 col-lg-6 col-md-12 col-sm-6">
				<a href="javascript:;" class="a-filter-order" status="Completed">									
					<div class="card">
						<div class="card-body">
							<div class="d-flex mb-4">
								<span class="avatar align-self-center avatar-lg br-7 cover-image bg-primary-transparent">
									<i class="fas fa-ban text-primary"></i>
								</span>
								<div class="svg-icons text-right ml-auto">
									<h5 class="text-muted">Completed</h5>
									<h2 class="mb-0 font-weight-extrabold num-font">
										<?=$Completed;?>
									</h2>
								</div>
							</div>
							<div class="progress progress-md h-2">
								<div class="progress-bar progress-bar-striped progress-bar-animated bg-primary w-100"></div>
							</div>
						</div>
					</div>
				</a>
			</div>
			<div class="col-xl-3 col-lg-6 col-md-12 col-sm-6">
				<a href="javascript:;" class="a-filter-order" status="">
					<div class="card">
						<div class="card-body">
							<div class="d-flex mb-4">
								<span class="avatar align-self-center avatar-lg br-7 cover-image bg-pink-transparent">
									<i class="fe fe-layers text-pink"></i>
								</span>
								<div class="svg-icons text-right ml-auto">
									<h5 class="text-muted">Total Orders</h5>
									<h2 class="mb-0 font-weight-extrabold num-font">										
										<?=$total_orders;?>				
									</h2>
								</div>
							</div>
							<div class="progress progress-md h-2">
								<div class="progress-bar progress-bar-striped progress-bar-animated bg-pink w-100"></div>
							</div>
						</div>
					</div>
				</a>
			</div>
		</div>
		<div class="row mb-3 row-filter">
			<div class="col-md-2">
				<input type="date" required class="form-control search-order-date" name="search_order_date" value="<?=date('Y-m-d')?>">
			</div>
			<div class="col-md-2 order-status-div">
				<select class="form-control select-order-status" style="height: 2.25rem;">
					<option value="">Select Status</option>
					<option value="New">New</option>
					<option value="Confirmed">Confirmed</option>
					<option value="Assigned To Kitchen">Assigned To Kitchen</option>
					<option value="Food Served">Food Served</option>
					<option value="Canceled">Cancel</option>
					<option value="Blocked">Blocked</option>
					<option value="Completed">Completed</option>
				</select>
			</div>
			<div class="col-md-3 div-search-input">
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
					<button class="btn btn-default btn-next disabled next" data-page="next" type="button">
						<span class="fas fa-angle-right"></span>
					</button>
				</div>
			</div>
		</div>
	</div>
	<!-- <div class="row">
		<div class="col-md-12 mb-2">
			<a href="#" class="btn btn-link btn-single-orders" style="font-size: 16px;">Single Orders</a>
			<a href="#" class="btn btn-link btn-tablewise-orders" style="font-size: 16px;display: none;">Tablewise Orders</a>
		</div>
	</div> -->
	<div class="row">
		<div class="col-md-12" style="min-height: 325px;">
			<div class="card">
				<div class="card-body">
					<div class="table-responsive mt-2 table-single-orders" style="display: none;">
						<table class="table card-table table-vcenter text-nowrap table-head" id="table-orders">
							<thead >
								<tr>
									<th>Order No.</th>
									<!--<th>Cust. Name</th>
									<th>Cust. Mob.</th> -->
									<th>Table No.</th>
									<th>Order Status</th>
									<th>Order By</th>
									<th>Date</th>
									<th>Process Time</th>
									<th>Total</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody class="tbody-order-list">
							
							</tbody>
						</table>
					</div>
					<div class="table-responsive mt-2 table-tablewise-orders">
						<table class="table card-table table-vcenter text-nowrap table-head" id="table-tablewise-orders">
							<thead >
								<tr>
									<th>Order No</th>
									<th>Table No.</th>
									<th>Date</th>
									<th>Time</th>
									<th>Process Time</th>
									<th>Order Status</th>
									<th>Order By</th>
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
<div id="table-order-modal" class="modal fade">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content ">
			<div class="modal-header pd-x-20">
				<h4 class="modal-title">Table Order Details</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body pd-20 row-tableorder-details">
				<input type="hidden" name="table_order_id" class="input-tableorder-id">
				<div class="row">
	               	<div class="col-md-4 mb-3">
		       			<div class="order-details" style="margin-top: 0px;">
		       				Order No : <span class="span_tableorder_no"></span>
		       			</div>
		       		</div>
	           		<div class="col-md-4 mb-3">
	           			<div class="order-details">
	           				 Date : <span class="span_table_orderdate"></span>
	           			</div>
	           		</div>
	           		<div class="col-md-4 mb-3">
	           			<div class="order-details">
	           				 Table No : <span class="span_tableno">IN-04</span>
	           			</div>
	           		</div>
	           	</div>
	           	<div class="row" style="border-top: 1px solid #ddd;">
	           		<div class="clearfix">
	           		</div>
	           	</div>
	           <!-- 	<div class="row mt-3 mb-3">
	           		<button type="button" class="btn mr-2 btn-primary btn-create-invoice">Create Invoice</button>
	           	</div> -->
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive mt-2">
							<table class="table card-table table-vcenter text-nowrap table-head" id="table-modalorders">
								<thead >
									<tr>
										<!-- <th><input type="checkbox" class="input-checkall-orders" name="is_order_checkall" ></th> -->
										<th>Order No</th>
										<th>Cust. Name</th>
										<th>Order Status</th>
										<th>Order By</th>
										<th>Total</th>
										<th>Is Invoiced</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody class="tbody-tableorder-list">
								
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div><!-- modal-body -->
		</div>
	</div><!-- modal-dialog -->
</div><!-- modal -->
<!-- <div id="order-modal" class="modal fade">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content ">
			<div class="modal-header pd-x-20">
				<h4 class="modal-title">Order Details</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body pd-20 row-order-details">
				<input type="hidden" name="order_id" class="input-order-id">
				<input type="hidden" name="table_order_id" class="tableinput-order-id">
				<div class="row">
	               	<div class="col-md-6 mb-3">
		       			<div class="order-details" style="margin-top: 0px;">
		       				Order No : <span class="span_order_no"></span>
		       			</div>
		       		</div>
	           		<div class="col-md-6 mb-3">
	           			<div class="order-details">
	           				 Date : <span class="span_order_date"></span>
	           			</div>
	           		</div>
	           		<div class="col-md-6 mb-3">
	           			<div class="order-details">
	           				 Cust Name : <span class="span_customer_name"></span>
	           			</div>
	           		</div>

	           		<div class="col-md-6 mb-3">
	           			<div class="order-details">
	           				 Cust Mob. : <span class="span_contact_no"></span>
	           			</div>
	           		</div>
	           		<div class="col-md-6 mb-3">
	           			<div class="order-details">
	           				 Table No : <span class="span_table_no"></span>
	           			</div>
	           		</div>
	           		<div class="col-md-6 mb-3">
	           			<div class="order-details">
	           				 Orders Status : <span class="span_status badge"></span>
	           			</div>
	           		</div>
	           	</div>
	           	<div class="row" style="border-top: 1px solid #ddd;">
	           		<div class="clearfix">
	           		</div>
	           	</div>
	           	<div class="row mt-2">
	           		<div class="col-md-12">
	           			<table id="table1" class="table table-border">
							<thead class="bg-success">
							  <tr>
								<th width="10">Sr.No.</th>
								<th>Item</th>
								<th class="text-right" width="50">Price</th>
								<th class="text-right" width="50">Quantity</th>
								<th class="text-right" width="50">Amount</th>
								<th class="text-right" width="50">Discount</th>
								<th class="text-right" width="110" style="text-align: right;">Total</th>
							  </tr>
							</thead>
							<tbody class="tbody-order-items">
							</tbody>
							<tfoot>
								<tr class="order-details">
									<td colspan="6" class="text-right">Sub Total</td>
									<td class="text-right span_sub_total"></td>
								</tr>
								<tr class="order-details">
									<td colspan="6" class="text-right">Disc. Total</td>
									<td class="text-right span_disc_total"></td>
								</tr>
								<tr class="order-details">
									<td colspan="6" class="text-right">Net Total</td>
									<td class="text-right span_net_total"></td>
								</tr>
							</tfoot>
						</table>
	           		</div>
               </div>
			</div> -->

			<!-- <div class="modal-footer">
				<button type="button" class="btn btn-orange btn-block-customer btn-change-status" order-status="Blocked">Block</button>
				<button type="button" class="btn btn-success btn-accept btn-change-status" order-status="Confirmed">Confirm</button>
				<button type="button" class="btn btn-success btn-assign btn-info btn-change-status" order-status="Assigned To Kitchen">Assign To Kitchen</button>
				<button type="button" class="btn btn-indigo btn-served  btn-change-status" order-status="Food Served">Food Serve</button>
				<button type="button" class="btn btn-success btn-complete btn-change-status" order-status="Completed">Complete</button>
				<button type="button" class="btn btn-danger btn-cancel btn-change-status" data-dismiss="modal" order-status="Canceled">Cancel</button>
			</div> xyz-->
			
		<!-- </div>
	</div>
</div> -->
<div id="edit-order-modal" class="modal fade">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content ">
			<form role="form" class="form form-horizontal" id="form-edit-order" action="javascript:;" method="post" enctype="multipart/form-data">
				<div class="modal-header pd-x-20">
					<h4 class="modal-title">Edit Order</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body pd-20 ">
					<div class="row">
		               <div class="col-lg-12">
		              		<div class="panel panel-default">
						        <div class="panel-body">
							        <input type='hidden' class="form-control" name='id' id="id">
							         <input type='hidden' class="form-control" name='table_orders_id' id="table-order-id">
							        <div class="col-md-4">
							        	<div class="form-group">
				                            <label for="">Order No </label>
				                            <input type="text"  class="form-control" name="order_no" disabled="">
				                        </div>
				                    </div>
				                    <div class="col-md-4">
				                        <div class="form-group">
											<label for="">Table No.</label>
											<input type="text" class="form-control"  name="table_no" disabled="">
			                            </div>
			                        </div>
				                    <div class="col-md-4">
			                            <div class="form-group">
											<label for="">Order Status.</label>
											<input type="text" class="form-control"  name="status" disabled="">
			                            </div>
			                        </div>
			                        <div class="col-md-4">
			                            <div class="form-group">
				                            <label for="">Customer name</label>
				                           	<input type="text" class="form-control input-customer-name"  name="customer_name">
				                           	<input type="hidden" name="customer_id" class="input-customer-id">
				                        </div>
				                    </div>
				                    <div class="col-md-4">
				                        <div class="form-group">
											<label for="">Customer Contact.</label>
											<input type="text" class="form-control input-customer-contact"  name="contact_no" >
			                            </div>
			                        </div>
				                    <div class="col-md-4">
			                        	<div class="form-group">
											<label for="">Date.</label>
											<input type="datetime" class="form-control"  name="order_date" disabled="">
			                            </div>
			                        </div>
			                        <div class="col-md-8">
			                            <div class="form-group">
											<label for="">Suggestions.</label>
											<textarea class="form-control"  name="suggetion" rows="1"></textarea>
			                            </div>
										<div class="clearfix"></div>
			                        </div>
			                     </div>
			                 </div>
							<div class="panel panel-default">
						        <div class="panel-body">	               
			                        <div class="col-md-12">
			                        	<div class="col-md-5">
			                        		<input type="hidden" name="row_id" class="input-row">
			                        		<input type="hidden" name="order_item_id" class="input-orderitemid">
				                           <div class="form-group">
				                              <label for="">Select Item</label>
				                              	<input type="text" name="recipe_name"  class="form-control input-item-name typeahead" onclick="this.select();" placeholder="Enter Item Name" autocomplete="off" id="input-item-name">
												<input type="hidden" name="recipe_id" class="input-item-id" id="input-item-id">
				                          </div>
			                        	</div>
			                        	<div class="col-md-2" >
						                    <div class="form-group">
				                              <label for="">Qty</label>
				                              <input type='number' class="form-control" id="input-qty" name="qty"/>
				                           </div>
			                       		</div>
			                        	<div class="col-md-2">
						                    <div class="form-group">
				                              <label for="">Price</label>
				                              <input type='text' class="form-control" id="input-price" name="price" readonly="" />
				                           </div>
			                       		</div>
			                       		<div class="col-md-2">
						                    <div class="form-group">
				                              <label for="">Discount(%)</label>
				                              <input type='text' class="form-control" id="input-discount" name="discount_per"/>
				                            </div>
			                       		</div>
			                       		<div class="col-md-1">
			                       			 <label style="color:#fff;">Discount</label>
			                       			<button type="button" class="btn btn-success" id="btn-add-item"><i class="fa fa-plus"></i></button>
			                       		</div>
				                    </div>

				                    <div class="col-md-12">

				                    	<table class="table table-border" id="table-items" style="display:none;font-size: 15px;">
				                    		<thead>
											  <tr>
											  	<th width="20">Sr.</th>
												<th width="200">Item</th>
												<th width="30">Qty</th>
												<th width="60">Price</th>
												<th width="50">Disc(%)</th>
												<th width="50">Amount</th>
												<th width="50">Action</th>
											  </tr>
											</thead>
											<tbody class="tbody-items-table">
											</tbody>
				                    	</table>
				                	</div>
				                	 <div class="col-lg-12">
						               	<div class="col-md-12 mb-1" style="text-align: right;">
							       			<div class="order-details">
							       				 Gross Amount: <span class="span_gross_amount">0</span>
							       				 <input type="hidden" class="input_gross_amount" name="sub_total">
							       			</div>
							       		</div>
							       		<div class="col-md-12 mb-1" style="text-align: right;">
						           			<div class="order-details">
						           				 Discount Amount : <span class="span_discount_amount">0</span>
						           				 <input type="hidden" class="input_discount_amount" name="disc_total">
						           			</div>
						           		</div>
						           		<div class="col-md-12 mb-1" style="text-align: right;">
						           			<div class="order-details">
						           				 Net Bill Amount : <span class="span_net_amount">0</span>
						           				 <input type="hidden" class="input_net_amount" name="net_total">
						           			</div>
						           		</div>
						           	</div>
			           			</div>
				            </div>
		                </div><!-- /.col-->
		            </div><!-- /.row -->
				</div><!-- modal-body -->
				<div class="modal-footer">
					<button type="submit" class="btn btn-success" id="submit-order">Submit</button>
				</div>
		    </form>
		</div>
	</div><!-- modal-dialog -->
</div><!-- modal -->
<?php
require_once('footer.php');
?>

<script src="<?=base_url();?>assets/js/custom/Orders.js?v=<?php echo uniqid();?>"></script>
<script type="text/javascript">
	Orders.base_url="<?=base_url();?>";
	Orders.init();
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
