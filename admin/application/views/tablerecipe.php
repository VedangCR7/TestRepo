<?php
require_once('header.php');
require_once('sidebar.php');
?>
<style type="text/css">
	.nav-panel-tabs li{
		margin-top:15px;
	}
	.recipewidth{
		width:30%;
	}
	@media screen and (max-width: 600px) {
  .recipewidth{
    width:45%;
  }
}
</style>
		<!-- Tabs Style -->
<link href="<?=base_url()?>assets/plugins/tabs/tabs.css" rel="stylesheet" />
<!--Sidemenu-responsive-tabs  css -->
<link href="<?=base_url()?>assets/plugins/sidemenu-responsive-tabs/css/sidemenu-responsive-tabs.css" rel="stylesheet">

<div class=" app-content">
	<div class="side-app">
		<!--Page Header-->
	<!-- 	<div class="page-header">
			<?php if ($this->uri->segment(4)!='') {
				?>
				<h3 class="page-title"><a href="<?=base_url();?>restaurant/new_order"><i class="fe fe-arrow-left"></i></a>View Order</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">View Order</li>
			</ol>
				<?php 
			} else{?>
			<h3 class="page-title"><a href="<?=base_url();?>restaurant/new_order"><i class="fe fe-arrow-left"></i></a>Take Order</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Take Order</li>
			</ol><?php } ?>
		</div> -->
		<div class="row">
			<div class="col-md-12 col-xl-12 mt-3">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-lg-4 col-md-4 col-sm-12 col-12">
								<?php
									if($takeaway_flag!='1')
									{
								?>
								<p style="font-weight:bold;" class="text-primary">Table No : <?=$show_table_title[0]['title']?></p>
								<?php } ?>
							</div>
							<!-- <?php if(isset($order_date)){?>
							<div class="col-lg-4 col-md-4 col-sm-12 col-12"><p style="font-weight:bold;">Order Date : <?=date('Y-m-d',strtotime($order_date[0]['insert_date']))?></p></div>
							<div class="col-lg-4 col-md-4 col-sm-12 col-12"><p style="font-weight:bold;">Order Time : <?=date('H:i A',strtotime($order_date[0]['insert_time']))?></p></div>
							<?php } ?> -->

						</div>
						<div class="panel panel-primary">
							<div class=" tab-menu-heading">
								<div class="tabs-menu1 ">
									<!-- Tabs -->
									<ul class="nav panel-tabs nav-panel-tabs" bill-count="1">
										<?php
										if($takeaway_flag=='1')
										{
										?>
										<li class=""><a href="#invoice-1" class="active" data-toggle="tab">Order</a></li>
										<?php
										}
										else
										{
											if($invoice_id!="")
											{?>
											<li class=""><a href="#invoice-1" class="active" data-toggle="tab">Order 1</a></li>	
											<?php
											}
											else
											{
											?>
											<li class=""><a href="#invoice-1" class="active" data-toggle="tab">Order 1</a></li>
											<li><a id="new-bill-a" href="#new-bill" data-toggle="tab"><i class="fa fa-plus"></i> New Order</a></li>
											<?php
											}
										}
										?>
									</ul>
								</div>
							</div>
							<div class="panel-body tabs-menu-body">
								<div class="tab-content">
									<div class="tab-pane active " id="invoice-1">
										<div class="row">
											<!-- The Modal -->
											<div class="modal" id="addonmodal">
											<div class="modal-dialog modal-lg">
												<div class="modal-content">

												<!-- Modal Header -->
												<div class="modal-header">
													<h4 class="modal-title">Addon Menu</h4>
													<button type="button" class="close" data-dismiss="modal">&times;</button>
												</div>

												<!-- Modal body -->
												<div class="modal-body" id="show_addon_menu">

												</div>

												<!-- Modal footer -->
												<div class="modal-footer">
												<button type="button" class="btn btn-success btn-add-item" id="btn-add-item" style="margin-top:22px;"> Add</button>
												</div>

												</div>
											</div>
											</div>
											<div class="modal" id="discountnotemodal">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<h4 class="modal-title">Discount Note</h4>
															<button type="button" class="close cancel_discount_note" data-dismiss="modal">&times;</button>
														</div>
														<div class="modal-body" id="show_addon_menu">
															<textarea class="form-control discount_note_add" rows="4" placeholder="Discount Note" id="discount_note_add"></textarea>
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-success submit_order" style="margin-top:22px;"> Save</button>
															<button type="button" class="btn btn-secondary cancel_discount_note" style="margin-top:22px;"> Cancel</button>
														</div>
													</div>
												</div>
											</div>
											<div class="col-lg-12 col-md-12 col-sm-12 col-12 show_date" id="show_date"></div>
											<div class="col-lg-12 col-md-12 col-sm-12 col-12" style="margin-top:10px;">
												<div class="row pb-2 mb-2" style="border-bottom: 1px solid #ddd;">
													<div class="col-lg-4 col-md-12	 col-sm-12 col-12">
														<label>Contact Number</label>
														<input type="hidden" class="customer_id" name="customer_id" id="customer_id">
														<input type="text" minlength="8" maxlength="14" name="mobile_no" class="mobile_no form-control" placeholder="Customer Contact number" id="mobile_no" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" onkeypress="return Takeorders.isNumber(event)">
													</div>
													<div class="col-lg-5 col-md-12 col-sm-12 col-12">
														<label>Name</label>
														<input type="text" maxlength="30" name="customer_name" class="form-control customer_name" placeholder="Customer Name" id="customer_name" style="text-transform: capitalize;">
													</div>
													<div class="col-lg-2 col-md-12 col-sm-12 col-12">
														<label>No Of Person</label>
														<input type="text" name="number_of_person" class="form-control number_of_person" placeholder="No Of Person" id="number_of_person" maxlength="2" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" onkeypress="return Takeorders.isNumber(event)">
													</div>
													<div class="col-lg-1 col-md-1 col-sm-12 col-12 text-right">
														<button class="btn btn-primary btn-sm mr-1 open_order_history" id="open_order_history" style="margin-top:30px;"><i class="fa fa-history" aria-hidden="true"></i></button>
													</div>
												</div>
												<div class="row select-item-row">
													<div class="col-md-12">
							                        	<div class="col-md-3">
							                        		<input type="hidden" name="row_id" class="input-row" value="">
								                           <div class="form-group">
								                              <label for="">Select Item</label>
								                              	<input type="text" name="recipe_name" class="form-control input-item-name typeahead" onclick="this.select();" placeholder="Enter Item Name" autocomplete="off" id="input-item-name">
																<input type="hidden" name="recipe_id" class="input-item-id" id="input-item-id" value="">
																<input type="hidden" name="recipe_grp_id" class="input-item-grp-id" id="input-item-grp-id" value="">
																<input type="hidden" name="prd_id" class="input-item-product-code" id="input-item-product-code" value="">
																<input type="hidden" name="invoice_id" class="input-invoice-id" id="input-invoice-id" value="">
								                          </div>
							                        	</div>
							                        	<div class="col-md-2">
										                    <div class="form-group">
								                              <label for="">Qty</label>
								                              <input type="number" min="0" class="form-control input-qty" id="input-qty" name="qty" maxlength="3">
								                           </div>
							                       		</div>
							                        	<div class="col-md-2">
										                    <div class="form-group">
								                              <label for="">Price</label>
								                              <input type="text" class="form-control input-price" id="input-price" name="price" readonly="">
								                           </div>
							                       		</div>
							                       		<div class="col-md-2">
										                    <div class="form-group">
								                              <label for="">Notes</label>
								                              <input type="text" class="form-control input-special-notes" id="input-special-notes" name="special_notes">
								                            </div>
							                       		</div>
							                       		<div class="col-md-3">
							                       			 <!--<label style="color:#fff;">Discount</label>-->
																<button type="button" class="btn btn-secondary btn-addon-item" id="btn-addon-item" style="margin-top:22px;display:none;"> Addon Menu</button>
							                       				<button type="button" class="btn btn-success btn-add-item" id="btn-add-item" style="margin-top:22px;"> Add</button>
							                       		</div>
								                    </div>
												</div>
												<div class="row">
													<div class="col-lg-12 col-md-12 col-sm-12 col-12 table-responsive">
														<input type="hidden" name="order_id" class="input-invoice-id" id="input-invoice-id" value="">
														<input type="hidden" name="order_id" class="input-order-id" id="input-order-id" value="">
														<table class="table table-bordered billing_table border-top" width="100%">
															<thead>
																<tr>
																	<th style="width:25%">Item</th>
																	<th style="width:15%">Product Code</th>
																	<th style="width:10%">Addon Menu</th>
																	<th style="width:25%">Notes</th>
																	<th style="width:15%">Quantity</th>
																	<th style="width:10%">Price</th>
																	<th style="width:10%">Total</th>
																</tr>
															</thead>
															
															<tbody class="showaddeditems" id="showaddeditems">
															
															</tbody>
															<tfoot style="font-weight:bold;" id="show_total">
														</table>
													</div>
													<div class="col-lg-12 col-md-12 col-sm-12 col-12 text-right" id="showsuggetion" style="display:none">
													</div>
													<div class="col-lg-12 col-md-12 col-sm-12 col-12 table-responsive">
														<table class="table table-bordered border-top billing_total" width="100%" style="font-weight:bold;">
															<tbody class="total-section">
																	<tr>
																		<td class="text-right">
																			<span id="subtotal_html" class="subtotal_html">Sub Total : &#8377;</span>
																			<input type="hidden" name="" id="sub_total"  class="sub_total">
																		</td>
																	</tr>
																	<tr>											
																		<td class="text-right">
																			<span id="distotal_html" class="distotal_html">Discount:  &#8377; 0</span>
																			<input type="hidden" name="" id="dis_totaldetail"  class="dis_totaldetail" >
																		</td>
																	</tr>
																	<tr>											
																		<td class="text-right">
																			<span id="distotal_percentage_html" class="distotal_percentage_html">Discount (%): 0</span>
																			<input type="hidden" name="" id="dis_percentage_totaldetail"  class="dis_percentage_totaldetail" >
																		</td>
																	</tr>
																	<tr>
																		<td class="text-right">
																			<span id="nettotal_html" class="nettotal_html">Net Total &#8377;</span>
																			<input type="hidden" class="net_total" name="" id="net_total">
																		</td>
																	</tr>
															</tbody>
															<tbody class="payment-section" style="display: none;">
																
																<tr>
																	<td class="text-right td-totaldetails">
																		<span id="subtotal_html" class="subtotal_html">Sub Total : &#8377;</span>
																		<input type="hidden" name="" id="sub_total"  class="sub_total">
																	</td>
																	<td class="text-right td-payment">
																		<span id="payment_html" class="payment_html">Payment Type : </span>
																	</td>
																</tr>
																<tr>
																	<td class="text-right td-totaldetails">
																		<span id="bill_discount" class="bill_discount">Discount (<?=$currency_symbol[0]['currency_symbol']?>):</span>
																		<input type="text" name="" id="dis_total"  class="dis_total" onchange="check_discount()">
																	</td>
																	<td class="text-right td-payment">
																		<span id="cash_html" class="cash_html">Cash : </span>
																		<input type="text" name="" id="cash_payment"  class="cash_payment enter_payment">
																	</td>
																</tr>
																<tr>
																	<td class="text-right td-totaldetails">
																		<span id="bill_discount" class="bill_discount">Discount (%):</span>
																		<input type="text" name="" id="dis_total_percentage"  class="dis_total_percentage" onchange="check_discount_percentage()">
																	</td>
																	<td class="text-right td-payment">
																		<span id="card_html" class="card_html">Credit/Debit Card : </span>
																		<input type="text" name="" id="card_payment"  class="card_payment enter_payment">
																	</td>
																</tr>
																<tr>
																	<td class="text-right td-totaldetails">
																		<span id="gst_html" class="gst_html">CGST %</span>
																		<input class="cgst_per" type="text" name="" id="cgst_per">
																	</td>
																	<td class="text-right td-payment">
																		<span id="upi_app_html" class="upi_app_html">UPI App : </span>
																		<input type="text" name="" id="upi_payment"  class="upi_payment enter_payment">
																	</td>
																</tr>
																<tr>
																	<td class="text-right td-totaldetails">
																		<span id="gst_html" class="gst_html">SGST %</span>
																		<input class="sgst_per" type="text" name="" id="sgst_per">
																	</td>																	
																	<td class="text-right td-payment">
																		<span id="net_banking_html" class="net_banking_html">Net Banking : </span>
																		<input type="text" name="" id="net_banking"  class="net_banking enter_payment">
																	</td>
																</tr>
																<tr>
																	<td class="text-right td-totaldetails">
																		<span id="nettotal_html" class="nettotal_html">Grant Total &#8377;</span>
																		<input type="hidden" class="net_total" name="" id="net_total">
																	</td>
																	<td class="text-right discount_note" style="display:none;">
																		<span>Discount Note</span>
																		<input type="text" class="discount_note_enter form-control" name="">
																	</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
												<div class="col-lg-12 pb-2 col-md-12 col-sm-12 col-12 text-left show_discount_comment" style="display:none"></div>
												<div class="col-lg-12 pb-2 col-md-12 col-sm-12 col-12 text-right">
													<button class="btn btn-orange block_view" id="block_view" style="display: none;" style="display: none;">Block</button>
													<button class="btn btn-primary placeorder_kitchen_for_view" id="placeorder_kitchen_for_view" style="display: none;" >KOT</button>
													<button class="btn btn-warning placeorder_kitchen_print" id="placeorder_kitchen_print"  style="display: none;">PRINT BILL</button>
													<!--<button class="btn btn-info placeorder_sendon_whatsapp" id="placeorder_sendon_whatsapp"  style="display: none;">Bill Send On Whatsapp</button>-->
													<button class="btn btn-primary submit_order" id="submit_order" style="display: none;">Pay</button>
													<button class="btn btn-danger cancel_order" id="cancel_order" style="display: none;" >Cancel</button>
													<button class="btn btn-primary placeorder_kitchen" id="placeorder_kitchen">Assign To Kitchen</button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>






<div class="modal" id="orderModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Order History</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
        	<table class="table table-bordered table-striped">
        		<thead>
        			<th>SR.NO</th>
        			<th>Order Noumber</th>
        			<th>Status</th>
        			<th>Discount</th>
        			<th>Net Total</th>
        			<th>Date</th>
        		</thead>
        		<tbody id="order_body">
        			
        		</tbody>
        	</table>
        </div>
      </div>

      <!-- Modal footer -->
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div> -->

    </div>
  </div>
</div>

<!-- The Modal -->
<div class="modal" id="cancel_model">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Cancel Note</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
		<span id="order_id"></span>
        <textarea class="form-control" rows="5" id="cancel_note"></textarea>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-primary add-cancel-note" data-dismiss="modal">Add Note</button>
      </div>

    </div>
  </div>
</div>


<?php
require_once('footer.php');
?>

<!---Tabs JS 1-->
<script src="<?=base_url()?>assets/plugins/tabs/tabs.js"></script>

<!---Tabs scripts-->
<script src="<?=base_url()?>assets/js/tabs.js"></script>
<script src="<?=base_url();?>assets/js/custom/Takeorders.js?v=<?php echo uniqid(); ?>"></script>
<script type="text/javascript">
	Takeorders.base_url="<?=base_url();?>";
	Takeorders.table_id="<?=$table_id;?>";
	Takeorders.table_category_id="<?=$table_details['table_category_id'];?>";
	Takeorders.table_order_id="<?=$order_id;?>";
	Takeorders.invoice_id="<?=$invoice_id;?>";
	Takeorders.currency_symbol = "<?=$currency_symbol[0]['currency_symbol'];?>";
	Takeorders.init();
	/*if(!Takeorders.table_order_id){
		$(window).on('beforeunload', function(){
			if(parseInt($('#net_total').val())>0){
				var c=confirm();
				if(c){
				  return true;
				}
				else
				 return false;
			}
		});
	}*/
	/*$('.recipe-tabs').find('.receipes .card-body').addClass('active');*/
</script>
<script>
	setInterval(function() {
                $.ajax({
                    url: "<?=base_url();?>restaurant/set_authority_exist",
                    type:'POST',
                    dataType: 'json',
                    data: {name:'Billing'},
                    success: function(result){
                        if(result.status){
                            window.location.href="<?=base_url();?>restaurant/dashboard";
                        }
                   	}
                });
            },5000);
</script>
<script>

	function check_discount_percentage()
	{
		var dis_total_percentage = parseInt($('#dis_total_percentage').val());
		
		if(dis_total_percentage > 100)
		{
			alert("Please add discount percentage less than 100.");
			$('#dis_total_percentage').val('0');
		}
	}
	
	/* function check_discount()
	{
		var total = parseInt($('#sub_total').val());
		var dis_total = parseInt($('#dis_total').val());
		
		if(total < dis_total)
		{
			alert("Please add discount amount less than sub total.");
			$('#dis_total').val('0.00');
		}
	} */
	
	/* window.onbeforeunload = confirmExit;
	function confirmExit()
	{
		debugger;
		return "You have attempted to leave this page.  If you have made any changes to the fields without clicking the Save button, your changes will be lost.  Are you sure you want to exit this page?";
	} */
</script>
<script>
	$(document).ready(function () 
	{
		$(".number_of_person").keypress(function (e) 
		{
			if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) 
			{
				return false;
			}
		});
	});
</script>