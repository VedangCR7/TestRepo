var Onlineorders ={
	base_url:null,
    table_id:null,
    table_category_id:null,
    uncheck_ids:new Array(),

    table_order_id:null,
	
    orders_count:null,
	init:function() {
		this.bind_events();
        if (this.table_order_id) 
		{
            this.getorderdetails();
        }
        this.loadMenuItems();
    },
		
	bind_events :function() {
		var self=this;

		$('.tab-content').on('change','.mobile_no',this.getcustomer);
		$('.tab-content').on('click',".open_order_history",this.getorderhistory);
		$('.tab-content').on('click','.quantity-right-plus',this.quantity_plus);
        $('.tab-content').on('click','.btn-add-item',this.addneworder);
        $('.tab-content').on('keypress','.quantity',function (e) {
             //if the letter is not digit then display error and don't type anything
             if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }
        });
        $('.tab-content').on('keypress','.input-qty',function (e) {
             //if the letter is not digit then display error and don't type anything
             if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }
        });
        $('.tab-content').on('click','.btn-qty-plus',this.editorder);
        $('.tab-content').on('click','.btn-qty-minus',this.editorder);

        $('.tab-content').on('click',".placeorder_kitchen",this.placeorder);
        $('.tab-content').on('click',".placeorder_kitchen_for_view",this.kotorder);
        $('.tab-content').on('click',".placeorder_kitchen_print",this.printkotorder);
        $('.tab-content').on('click',".placeorder_sendon_whatsapp",this.printkotorder);
        $('.tab-content').on('click',".submit_order",this.onSubmitOrder);
        $('.tab-content').on('click',".submit_order1",this.onSubmitOrder1);
        $('.tab-content').on('change',".dis_total",this.onChangeCGST);
		$('.tab-content').on('change',".dis_total_percentage",this.onChangeCGST);
        $('.tab-content').on('change',".cgst_per",this.onChangeCGST);
        $('.tab-content').on('change',".sgst_per",this.onChangeCGST);
        $('.tab-content').on('click','.btn-change-status',this.OnChangeStatus);

        $('.tab-content').on('click',".btn-addon-item",this.addonpopup);

        $('.tbody-tableorder-list').on('click','.input-checksingle-orders',this.onClickInput);
        /*  $('#new-bill-a').on('click',this.newBill);*/
        $('.tab-content').on('click','.cancel_order',this.cancelOrder);
        $('.add-cancel-note').on('click',function(){
            $.ajax({
                url: Onlineorders.base_url+"restaurant/change_order_status/",
                type:'POST',
                dataType: 'json',
                data: {order_id:$('#order_id_cancel_note').val(),cancel_note:$('#cancel_note').val(),status:'Canceled'},
                success: function(response){
                    // swal({
                    //     title: '',
                    //     text: 'Order Assigned to kitchen.',
                    //     type: 'success',
                    //     showCancelButton: true,
                    //     confirmButtonColor: '#05C76B',
                    //     cancelButtonColor: '#d33',
                    //     confirmButtonText: 'Print KOT',
                    //     cancelButtonText: 'No, cancel!',
                    //     confirmButtonClass: 'btn btn-success',
                    //     cancelButtonClass: 'btn btn-danger',
                    //     buttonsStyling: false
                    //     },function (isConfirm) {
                    //         if(isConfirm){
                    //             window.open(Onlineorders.base_url+"restaurant/printbillkot/"+tab_pane.find('.input-order-id').val(),'_blank');
                    //             /* tab_pane.find('#placeorder_kitchen_for_view').hide(); */
                    //         }
                    //         else{
                    //             /* tab_pane.find('#placeorder_kitchen_for_view').hide(); */
                    //         }

                        
                    //     });
                    $('#image-loader').hide();
                    location.reload();
                    //Onlineorders.displaysucess('Order is assign to kitchen');
                }
            });
        })

        $('.input-checkall-orders').on('click',function(){
            if($(this).is(':checked')){
                $('.input-checksingle-orders:not(:disabled)').prop('checked',true);
            }else{
                $('.input-checksingle-orders:not(:disabled)').prop('checked',false);
                $('.input-checksingle-orders:not(:disabled)').each(function(){
                    if(!$(this).is(':checked')){
                        var id=$(this).val();
                        Onlineorders.uncheck_ids.push(id);
                    }
                });
            }

        });

        $('.btn-create-invoice').on('click',this.onCreateInvoice);

        $('.tab-content').on('keypress','.quantity',function (e) {
             //if the letter is not digit then display error and don't type anything
             if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }
        });
        $('.tab-content').on('keypress','.input-qty',function (e) {
             //if the letter is not digit then display error and don't type anything
             if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }
        });
        $('.tab-content').on('keyup','.input-qty',function (e) {
              if ($(this).val() > 1000){
                $(this).val('1000');
              }
        });

        $('.tab-content').on('keyup','.quantity',function (e) {
              if ($(this).val() > 1000){
                $(this).val('1000');
              }
        });
       
	},
    onClickInput:function()
	{
		debugger;
        
		if(!$(this).is(':checked'))
		{
            var id=$(this).val();
            Onlineorders.uncheck_ids.push(id);
        }
        
		/*$('.input-checkall-orders').prop('checked',false);*/
        var allchecked=true;
		
        $('.input-checksingle-orders').each(function()
		{
            if(!$(this).is(':checked'))
			{
                allchecked=false; 
            }
        })
		
        if(allchecked)
		{
            $('.input-checkall-orders').prop('checked',true);
        }
		else
		{
            $('.input-checkall-orders').prop('checked',false);
        }
    },
    cancelOrder:function(){
        var tab_pane=$(this).closest('.tab-pane');
        table_order_id = Onlineorders.table_order_id;
        ids =[];
        ids.push(tab_pane.find('.input-order-id').val());
        var data={
            sub_total:tab_pane.find('.sub_total').val(),
            dis_total:tab_pane.find('.dis_total').val(),
            cgst_per:tab_pane.find('.cgst_per').val(),
            sgst_per:tab_pane.find('.sgst_per').val(),
            net_total:tab_pane.find('.net_total').val(),
            table_order_id:table_order_id,
            order_id:tab_pane.find('.input-order-id').val(),
            dis_total_percentage:tab_pane.find('.dis_total_percentage').val(),
            disc_percentage_total:tab_pane.find('.dis_percentage_totaldetail').val()
        }

        swal({
            title: 'Are you sure ?',
            text: "Cancel Order",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Canceled!',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false
        },function () {
            $('#image-loader').show();
            $('#order_id').html('<input type="hidden" id="order_id_cancel_note" value="'+tab_pane.find('.input-order-id').val()+'">');
            $('#cancel_model').modal('show');
            $('#image-loader').hide();
            
             
        }, function (dismiss) {
            if (dismiss === 'cancel') {
                swal(
                  'Cancelled',
                  'Your record is safe :)',
                  'error'
                )
            }
        });
},

    OnChangeStatus:function()
	{
		debugger;
        var tab_pan=$(this).closest('.tab-pane');
        var self=this;
        var status=$(this).attr('order-status');
        var order_id=tab_pan.find('.input-order-id').val();
        var data={
            order_id:order_id,
            status:status
        }
       
		var table_order_id=Onlineorders.table_order_id;
        
		if(status=="Completed")
            display_text="Complete";
        else if(status=="Food Served")
            display_text="Served";
        else
            display_text=status.replace("ed", "");


        if(status=="Assigned To Kitchen")
		{
            var textmsg="You want to Assign this order To Kitchen";
        }
        
		if(status=="Food Served")
		{
            var textmsg="You want to Serve the Food for this order";
        }
        else if(status=="Blocked")
		{
            var textmsg="You want to Block this order";
        }
        else
		{
            var textmsg='You want to '+display_text+' this Order';
        }
        
		swal({
            title: 'Are you sure ?',
            text: textmsg,
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, '+display_text+' it!',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false
        },
		function () 
		{
            $('#image-loader').show();
            $.ajax({
                url: Onlineorders.base_url+"restaurant/change_order_status",
                type:'POST',
                data:data,
                success: function(result){
                   if (result.status) {
                    if(status=="Assigned To Kitchen"){
                        swal({
                            title: '',
                            text: 'Order Assigned to kitchen',
                            type: 'success',
                            showCancelButton: true,
                            confirmButtonColor: '#05C76B',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Print Bill',
                            cancelButtonText: 'No, cancel!',
                            confirmButtonClass: 'btn btn-success',
                            cancelButtonClass: 'btn btn-danger',
                            buttonsStyling: false
                            },function (isConfirm) {
                                if(isConfirm){
                                    window.open(Onlineorders.base_url+"restaurant/printbillkot/"+order_id,'_blank');
                                }
                            });
                    }
                       Onlineorders.getorder(tab_pan);
                   }
                   else{
                        Onlineorders.displaywarning("Something went wrong please try again");
                   }
                   $('#image-loader').hide();
                }
            });
             
        }, function (dismiss) {
            if (dismiss === 'cancel') {
                swal(
                  'Cancelled',
                  'Your record is safe :)',
                  'error'
                )
            }
        });
    },
    onChangeCGST:function()
	{
		debugger;
        var tab_pane=$(this).closest('.tab-pane');
        var sub_total=parseFloat(tab_pane.find('.sub_total').val());
        console.log(sub_total);
        
		if(tab_pane.find('.dis_total').val()=="")
            var discount=0;
        else
            var discount=parseFloat(tab_pane.find('.dis_total').val());
         console.log(discount);
		
		if(tab_pane.find('.dis_total_percentage').val()=="")
		{
            var discount_percentage_price=0;
            var discount_percentage=0;
		}
		else
		{
			var discount_percentage = tab_pane.find('.dis_total_percentage').val();
			var discount_percentage_calculation = sub_total*discount_percentage/100;
            var discount_percentage_price=parseFloat(discount_percentage_calculation);
		}
		
		if(sub_total < discount)
		{
			alert("Please add discount amount less than sub total.");
			$('.dis_total').val('0.00');
			return false;
		}
		
		if(discount_percentage > 100)
		{
			alert("Please add discount percentage less than 100.");
			$('.dis_total_percentage').val('0');
			return false;
		}
		
		//if(discount_percentage > 39)
		//{
			
		//	$('#discountnotemodal').modal('show');
		//	return false;
		//}
		
        if(tab_pane.find('.cgst_per').val()=="")
            var cgst_per=0;
        else
            var cgst_per=parseFloat(tab_pane.find('.cgst_per').val());
        if(tab_pane.find('.sgst_per').val()=="")
            var sgst_per=0;
        else
            var sgst_per=parseFloat(tab_pane.find('.sgst_per').val());

		if(discount_percentage_price>0 && discount>0)
		{
			var net_total=parseFloat(sub_total-discount-discount_percentage_price);
		}
		else if(discount_percentage_price>0 && discount<=0)
		{
			var net_total=parseFloat(sub_total-discount_percentage_price);
		}
		else if(discount_percentage_price<=0 && discount>0)
		{
			var net_total=parseFloat(sub_total-discount);
		}
		else if(discount_percentage_price<=0 && discount<=0)
		{
			var net_total=parseFloat(sub_total);
		}
		
        /* var cgst_total=parseFloat((sub_total*cgst_per)/100).toFixed('2');
        var sgst_total=parseFloat((sub_total*sgst_per)/100).toFixed('2');
        console.log(cgst_total,sgst_total);
        var net_total=parseFloat(sub_total)-parseFloat(discount);
        net_total=net_total+parseFloat(cgst_total)+parseFloat(sgst_total);
        tab_pane.find('.nettotal_html').html('Net Total ₹'+net_total.toFixed('2'));
        tab_pane.find('.net_total').val(net_total.toFixed('2')); */
		
		var cgst_total=parseFloat((sub_total*cgst_per)/100).toFixed('2');
        var sgst_total=parseFloat((sub_total*sgst_per)/100).toFixed('2');
         console.log(cgst_total,sgst_total);
        net_total=net_total+parseFloat(cgst_total)+parseFloat(sgst_total);
        tab_pane.find('.nettotal_html').html('Net Total ₹'+net_total.toFixed('2'));
        tab_pane.find('.net_total').val(net_total.toFixed('2'));

        table_order_id = Onlineorders.table_order_id;
        ids =[];
        ids.push(tab_pane.find('.input-order-id').val());
        var data={
            sub_total:tab_pane.find('.sub_total').val(),
            dis_total:tab_pane.find('.dis_total').val(),
            cgst_per:tab_pane.find('.cgst_per').val(),
            sgst_per:tab_pane.find('.sgst_per').val(),
            net_total:tab_pane.find('.net_total').val(),
            table_order_id:table_order_id,
            order_id:tab_pane.find('.input-order-id').val(),
			dis_total_percentage:discount_percentage,
			disc_percentage_total:discount_percentage_price
        }
            
        $.ajax({
            url: Onlineorders.base_url+"restaurant/kot_status/",
            type:'POST',
            dataType: 'json',
            data: data,
            success: function(response){
                $('#image-loader').hide();
            }
        });
    },
   
    newBill:function(from)
	{
		debugger;
        var last_bill=$('.tab-content .tab-pane:last');
        
		if(from=="")
		{
            if(last_bill.find('.input-order-id').val()=="")
			{
                Onlineorders.displaywarning('Please save current bill details');
                return false;
            }
        }
		
        var bill_count=$('.nav-panel-tabs').attr('bill-count');
        bill_count=parseInt(bill_count)+1;
        var li=$('.nav-panel-tabs li:last');
        li.prev().after('<li class=""><a href="#invoice-'+bill_count+'" class="active" data-toggle="tab">Order '+bill_count+'</a></li>');
        var html='<div class="tab-pane active " id="invoice-'+bill_count+'">\
            <div class="row">\
				<div class="modal" id="addonmodal">\
					<div class="modal-dialog modal-lg">\
						<div class="modal-content">\
							<div class="modal-header">\
								<h4 class="modal-title">Addon Menu</h4>\
								<button type="button" class="close" data-dismiss="modal">&times;</button>\
							</div>\
							<div class="modal-body" id="show_addon_menu">\
							\
							</div>\
							<div class="modal-footer">\
								<button type="button" class="btn btn-success btn-add-item" id="btn-add-item" style="margin-top:22px;"> Add</button>\
							</div>\
						</div>\
					</div>\
				</div>\
			\
			<div class="modal" id="discountnotemodal">\
				<div class="modal-dialog">\
					<div class="modal-content">\
						<div class="modal-header">\
							<h4 class="modal-title">Discount Note</h4>\
							<button type="button" class="close" data-dismiss="modal">&times;</button>\
						</div>\
						<div class="modal-body" id="show_addon_menu">\
							<textarea class="form-control discount_note_add" rows="4" placeholder="Discount Note" id="discount_note_add"></textarea>\
						</div>\
						<div class="modal-footer">\
							<button type="button" class="btn btn-success submit_order" style="margin-top:22px;"> Save</button>\
							<button type="button" class="btn btn-secondary" style="margin-top:22px;"> Cancel</button>\
						</div>\
					</div>\
				</div>\
			</div>\
			\
                <div class="col-lg-12 col-md-12 col-sm-12 col-12 show_date"></div>\
                <br>\
                <div class="col-lg-12 col-md-12 col-sm-12 col-12" style="margin-top:10px;">\
                    <div class="row pb-2 mb-2" style="border-bottom: 1px solid #ddd;">\
                        <div class="col-lg-4 col-md-12   col-sm-12 col-12">\
                            <label>Contact Number</label>\
                            <input type="hidden" class="customer_id" name="customer_id" id="customer_id'+bill_count+'">\
                            <input type="text" name="mobile_no" class="mobile_no form-control" placeholder="Customer Contact number" id="mobile_no'+bill_count+'">\
                        </div>\
                        <div class="col-lg-5 col-md-12 col-sm-12 col-12">\
                            <label>Name</label>\
                            <input type="text" name="customer_name" class="form-control customer_name" placeholder="Customer Name" id="customer_name'+bill_count+'">\
                        </div>\
						<div class="col-lg-2 col-md-12 col-sm-12 col-12">\
							<label>No Of Person</label>\
							<input type="text" name="number_of_person" class="form-control number_of_person" placeholder="No Of Person" id="number_of_person'+bill_count+'">\
						</div>\
                        <div class="col-lg-1 col-md-1 col-sm-12 col-12 text-right">\
                            <button class="btn btn-primary btn-sm mr-1 open_order_history" id="open_order_history'+bill_count+'" style="margin-top:30px;"><i class="fa fa-history" aria-hidden="true"></i></button>\
                        </div>\
                    </div>\
                    <div class="row select-item-row">\
                        <div class="col-md-12">\
                            <div class="col-md-4">\
                                <input type="hidden" name="row_id" class="input-row" value="">\
                               <div class="form-group">\
                                  <label for="">Select Item</label>\
                                    <input type="text" name="recipe_name" class="form-control input-item-name typeahead" onclick="this.select();" placeholder="Enter Item Name" autocomplete="off" id="input-item-name'+bill_count+'">\
                                    <input type="hidden" name="recipe_id" class="input-item-id" id="input-item-id'+bill_count+'" value="">\
									<input type="hidden" name="group_id" class="input-item-group-id" id="input-item-group-id'+bill_count+'" value="">\
                                    <input type="hidden" name="invoice_id" class="input-invoice-id" id="input-invoice-id'+bill_count+'" value="">\
                              </div>\
                            </div>\
                            <div class="col-md-2">\
                                <div class="form-group">\
                                  <label for="">Qty</label>\
                                  <input type="number" class="form-control input-qty" id="input-qty'+bill_count+'" name="qty">\
                               </div>\
                            </div>\
                            <div class="col-md-2">\
                                <div class="form-group">\
                                  <label for="">Price</label>\
                                  <input type="text" class="form-control input-price" id="input-price'+bill_count+'" name="price" readonly="">\
                               </div>\
                            </div>\
                            <div class="col-md-3">\
                                <div class="form-group">\
                                  <label for="">Notes</label>\
                                  <input type="text" class="form-control input-special-notes" id="input-special-notes'+bill_count+'" name="special_notes">\
                                </div>\
                            </div>\
                            <div class="col-md-1">\
                                 <label style="color:#fff;">Discount</label>\
                                 <button type="button" class="btn btn-success btn-addon-item" id="btn-addon-item" style="margin-top:22px;"> Add</button>\
                            </div>\
                        </div>\
                    </div>\
                    <div class="row">\
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12 table-responsive">\
                            <input type="hidden" name="order_id" class="input-invoice-id" id="input-invoice-id'+bill_count+'" value="">\
                            <input type="hidden" name="order_id" class="input-order-id" id="input-order-id'+bill_count+'" value="">\
                            <table class="table table-bordered billing_table border-top" width="100%">\
                                <thead>\
                                    <tr>\
                                        <th style="width:30%">Item</th>\
                                        <th style="width:15%">Addon</th>\
                                        <th style="width:20%">Notes</th>\
                                        <th style="width:15%">Quantity</th>\
                                        <th style="width:10%">Price</th>\
                                        <th style="width:10%">Total</th>\
                                    </tr>\
                                </thead>\
                                \
                                <tbody class="showaddeditems" id="showaddeditems'+bill_count+'">\
                                \
                                </tbody>\
                                <tfoot style="font-weight:bold;" id="show_total'+bill_count+'">\
                            </table>\
                        </div>\
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12 table-responsive">\
                            <table class="table table-bordered border-top billing_total" width="100%" style="font-weight:bold;">\
                                <tbody class="total-section">\
                                        <tr>\
                                            <td class="text-right">\
                                                <span id="subtotal_html'+bill_count+'" class="subtotal_html">Sub Total : '+Onlineorders.currency_symbol+'</span>\
                                                <input type="hidden" name="" id="sub_total'+bill_count+'"  class="sub_total">\
                                            </td>\
                                        </tr>\
                                        <tr>\
                                            <td class="text-right">\
                                                <span id="distotal_html'+bill_count+'" class="distotal_html">Discount:  '+Onlineorders.currency_symbol+' 0</span>\
                                                <input type="hidden" name="" id="dis_totaldetail'+bill_count+'"  class="dis_totaldetail" >\
                                            </td>\
                                        </tr>\
                                        <tr>\
                                            <td class="text-right">\
                                                <span id="nettotal_html'+bill_count+'" class="nettotal_html">Net Total '+Onlineorders.currency_symbol+'</span>\
                                                <input type="hidden" class="net_total" name="" id="net_total'+bill_count+'">\
                                            </td>\
                                        </tr>\
                                </tbody>\
                                <tbody class="payment-section" style="display: none;">\
                                    <tr>\
                                        <td class="text-right td-totaldetails">\
                                            <span id="subtotal_html'+bill_count+'" class="subtotal_html">Sub Total : '+Onlineorders.currency_symbol+'</span>\
                                            <input type="hidden" name="" id="sub_total'+bill_count+'"  class="sub_total">\
                                        </td>\
                                        <td class="text-right td-payment">\
                                            <span id="payment_html'+bill_count+'" class="payment_html">Payment Type : </span>\
                                        </td>\
                                    </tr>\
                                    <tr>\
                                        <td class="text-right td-totaldetails">\
                                            <span id="bill_discount'+bill_count+'" class="bill_discount">Discount ('+Onlineorders.currency_symbol+'):</span>\
                                            <input type="text" name="" id="dis_total'+bill_count+'"  class="dis_total">\
                                        </td>\
                                        <td class="text-right td-payment">\
                                            <span id="cash_html'+bill_count+'" class="cash_html">Cash : </span>\
                                            <input type="text" name="" id="cash_payment'+bill_count+'"  class="cash_payment">\
                                        </td>\
                                    </tr>\
				<tr>\
                                        <td class="text-right td-totaldetails">\
											<span id="bill_discount'+bill_count+'" class="bill_discount">Discount (%):</span>\
											<input type="text" name="" id="dis_total_percentage'+bill_count+'"  class="dis_total_percentage" onchange="check_discount_percentage()">\
                                        </td>\
                                        <td class="text-right td-payment">\
                                            <span id="card_html'+bill_count+'" class="card_html">Credit/Debit Card : </span>\
                                            <input type="text" name="" id="card_payment'+bill_count+'"  class="card_payment">\
                                        </td>\
                                    </tr>\
                                    <tr>\
                                        <td class="text-right td-totaldetails">\
                                            <span id="gst_html'+bill_count+'" class="gst_html">CGST %</span>\
                                            <input class="cgst_per" type="text" name="" id="cgst_per'+bill_count+'">\
                                        </td>\
                                        <td class="text-right td-payment">\
                                            <span id="card_html'+bill_count+'" class="card_html">Credit/Debit Card : </span>\
                                            <input type="text" name="" id="card_payment'+bill_count+'"  class="card_payment">\
                                        </td>\
                                    </tr>\
                                    <tr>\
                                        <td class="text-right td-totaldetails">\
                                            <span id="gst_html'+bill_count+'" class="gst_html">SGST %</span>\
                                            <input class="sgst_per" type="text" name="" id="sgst_per'+bill_count+'">\
                                        </td>\
                                        <td class="text-right td-payment">\
                                            <span id="upi_app_html'+bill_count+'" class="upi_app_html">UPI App : </span>\
                                            <input type="text" name="" id="upi_payment'+bill_count+'"  class="upi_payment">\
                                        </td>\
                                    </tr>\
                                    <tr>\
                                        <td class="text-right td-totaldetails">\
                                            <span id="nettotal_html'+bill_count+'" class="nettotal_html">Grant Total '+Onlineorders.currency_symbol+'</span>\
                                            <input type="hidden" class="net_total" name="" id="net_total'+bill_count+'">\
                                        </td>\
                                        <td class="text-right td-payment">\
                                            <span id="net_banking_html'+bill_count+'" class="net_banking_html">Net Banking : </span>\
                                            <input type="text" name="" id="net_banking'+bill_count+'"  class="net_banking">\
                                        </td>\
                                    </tr>\
									<tr>\
										<td class="text-right td-totaldetails show_discount_note">\
											<span style="float:left;">Discount Note : </span>\
										</td>\
									</tr>\
									<tr>\
                                        <td class="text-right td-totaldetails add_suggetion">\
                                            <span id="suggetion_html'+bill_count+'" class="suggetion_html" style="float:left;">Suggestion </span>\
										</td>\
                                    </tr>\
                                </tbody>\
                            </table>\
                        </div>\
                    </div>\
                    <div class="col-lg-12 pb-2 col-md-12 col-sm-12 col-12 text-right">\
                        <button type="button" class="btn btn-orange btn-block-customer btn-change-status" order-status="Blocked" style="display: none;">Block</button>\
                        <button type="button" class="btn btn-success btn-accept btn-change-status" order-status="Confirmed" style="display: none;">Confirm</button>\
                        <button type="button" class="btn btn-success btn-complete btn-change-status" order-status="Completed" style="display: none;">Complete</button>\
                        <button class="btn btn-danger btn-cancel cancel_order" id="cancel_order" style="display: none;" >Cancel</button>\
                        <button class="btn btn-primary placeorder_kitchen_for_view" id="placeorder_kitchen_for_view'+bill_count+'" style="display: none;" >Assign To Kitchen</button>\
                        <button class="btn btn-warning placeorder_kitchen_print" id="placeorder_kitchen_print'+bill_count+'"  style="display: none;">PRINT BILL</button>\
                        <button class="btn btn-info placeorder_sendon_whatsapp" id="placeorder_sendon_whatsapp'+bill_count+'"  style="display: none;">Bill Send On Whatsapp</button>\
                        <button class="btn btn-primary submit_order" id="submit_order'+bill_count+'" style="display: none;">Pay</button>\
                    </div>\
                </div>\
            </div>\
        </div>';

        $('.tab-content').append(html);
        
        $('.nav-panel-tabs').attr('bill-count',bill_count);
        setTimeout(function(){
            $('.tab-content .tab-pane').removeClass('active');
            $('.nav-panel-tabs li').find('a').removeClass('active');
            li.prev().find('a').trigger('click');
        }, 100);
    },
    loadMenuItems:function(){
		debugger;
        var tablecategory=Onlineorders.table_category_id;
        $('body').delegate('.input-item-name','focus',function(){
            var $input = $(this);
            $.get(Onlineorders.base_url+"restaurant/list_recipes/"+tablecategory, function(data){
                $input.typeahead({ 
                    source:data,autoSelect: true,
                    afterSelect:function(item){
                        if(item.discount != null && item.offer_status == 1){
							if(item.discount_type == 'Flat'){
								$discount_price = parseInt(item.price)-parseInt(item.discount);
							}else{
								$discount_price = parseInt(item.price)-(parseInt(item.price)*parseInt(item.discount)/100);
							}
						}
                        else{
                            $discount_price = item.price
                        }
                        var tab_pane=$input.closest('.tab-pane');
                        tab_pane.find('.input-item-id').val(item.id);
						tab_pane.find('.input-item-group-id').val(item.group_id);
						tab_pane.find('.input-item-id').attr('group_id',item.group_id);
                        tab_pane.find('.input-item-id').attr('recipe-type',item.recipe_type);
                        tab_pane.find('.input-price').val($discount_price);
                        tab_pane.find('.input-qty').val('1');
                        tab_pane.find('#input-discount').val('0');
                    },
                });
            },'json');
        });
    },
    kotorder:function()
	{
		debugger;
        var tab_pane=$(this).closest('.tab-pane');
		var ktid = this.id;
        table_order_id = Onlineorders.table_order_id;
        ids =[];
        ids.push(tab_pane.find('.input-order-id').val());
        var data={
            sub_total:tab_pane.find('.sub_total').val(),
            dis_total:tab_pane.find('.dis_total').val(),
            cgst_per:tab_pane.find('.cgst_per').val(),
            sgst_per:tab_pane.find('.sgst_per').val(),
            net_total:tab_pane.find('.net_total').val(),
            suggetion:tab_pane.find('.suggetion').val(),
            table_order_id:table_order_id,
            order_id:tab_pane.find('.input-order-id').val(),
			dis_total_percentage:tab_pane.find('.dis_total_percentage').val(),
			disc_percentage_total:tab_pane.find('.dis_percentage_totaldetail').val()
        }

        swal({
            title: 'Are you sure ?',
            text: "Order Assign To Kitchen",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Assign To Kitchen!',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false
        },function () {
            $('#image-loader').show();
			/* $('.placeorder_kitchen_for_view').attr('id'); */
			/* $('#'+ktid).attr('disabled', true); */
			
            $.ajax({
                url: Onlineorders.base_url+"restaurant/kot_status/",
                type:'POST',
                dataType: 'json',
                data: data,
                success: function(response){
                    swal({
                        title: '',
                        text: 'Order Assigned to kitchen',
                        type: 'success',
                        showCancelButton: true,
                        confirmButtonColor: '#05C76B',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Print KOT',
                        cancelButtonText: 'No, cancel!',
                        confirmButtonClass: 'btn btn-success',
                        cancelButtonClass: 'btn btn-danger',
                        buttonsStyling: false
                        },function (isConfirm) {
                            if(isConfirm){
                                window.open(Onlineorders.base_url+"restaurant/printbillkot/"+tab_pane.find('.input-order-id').val(),'_blank');
                            }
							location.reload();
                        });
                    $('#image-loader').hide();
                    //Onlineorders.displaysucess('Order is assign to kitchen');
					
                    Onlineorders.getorder(tab_pane);
                }
            });
             
        }, function (dismiss) {
            if (dismiss === 'cancel') {
                swal(
                  'Cancelled',
                  'Your record is safe :)',
                  'error'
                )
            }
        });
    },
    onSubmitOrder:function()
	{
			
            debugger;
            var tab_pane=$(this).closest('.tab-pane');
        var sub_total=parseFloat(tab_pane.find('.sub_total').val());
        console.log(sub_total);
        
		if(tab_pane.find('.dis_total').val()=="")
            var discount=0;
        else
            var discount=parseFloat(tab_pane.find('.dis_total').val());
         console.log(discount);
		
		if(tab_pane.find('.dis_total_percentage').val()=="")
		{
            var discount_percentage_price=0;
            var discount_percentage=0;
		}
		else
		{
			var discount_percentage = tab_pane.find('.dis_total_percentage').val();
			var discount_percentage_calculation = sub_total*discount_percentage/100;
            var discount_percentage_price=parseFloat(discount_percentage_calculation);
		}
		
		if(sub_total < discount)
		{
			alert("Please add discount amount less than sub total.");
			$('.dis_total').val('0.00');
			return false;
		}
		
		if(discount_percentage > 100)
		{
			alert("Please add discount percentage less than 100.");
			$('.dis_total_percentage').val('0');
			return false;
		}
		
		if(discount_percentage > 39)
		{
			if(tab_pane.find('.discount_note_add').val() == ''){
				tab_pane.find('#discountnotemodal').modal('show');
				//$('#discountnotemodal').modal('show');
				return false;
			}
				
		}
		
        
            table_order_id = Onlineorders.table_order_id;
            var invoice_id=tab_pane.find('.input-invoice-id').val();
            ids =[];
            ids.push(tab_pane.find('.input-order-id').val());
            var data={
                sub_total:tab_pane.find('.sub_total').val(),
                dis_total:tab_pane.find('.dis_total').val(),
                cgst_per:tab_pane.find('.cgst_per').val(),
                sgst_per:tab_pane.find('.sgst_per').val(),
                cash_payment:tab_pane.find('.cash_payment').val(),
                card_payment:tab_pane.find('.card_payment').val(),
                upi_payment:tab_pane.find('.upi_payment').val(),
                net_banking:tab_pane.find('.net_banking').val(),
                net_total:tab_pane.find('.net_total').val(),
                table_order_id:table_order_id,
                ids:ids,
                order_id:tab_pane.find('.input-order-id').val(),
                invoice_id:invoice_id,
				discount_note:tab_pane.find('.discount_note_add').val()
            }
        
                if(invoice_id=="")
                {
                    $('#image-loader').show();
                    $.ajax({
                        url: Onlineorders.base_url+"restaurant/create_invoice/",
                        type:'POST',
                        dataType: 'json',
                        data: data,
                        success: function(response)
                        {
                            $('#image-loader').hide();

                            tab_pane.find('.input-invoice-id').val(response.invoice_id);
                            var cash_payment=tab_pane.find('.cash_payment').val();
            var card_payment=tab_pane.find('.card_payment').val();
            var upi_payment=tab_pane.find('.upi_payment').val();
            var net_banking=tab_pane.find('.net_banking').val();
            var net_total=tab_pane.find('.net_total').val();
            if(cash_payment=="")
                cash_payment=0;
            if(card_payment=="")
                card_payment=0;
            if(upi_payment=="")
                upi_payment=0;
            if(net_banking=="")
                net_banking=0;
            var total_payment=parseFloat(cash_payment)+parseFloat(card_payment)+parseFloat(upi_payment)+parseFloat(net_banking)
            if(total_payment!=parseFloat(net_total)){
                Onlineorders.displaywarning("Please check the amount.");
                return false;
            }
            table_order_id = Onlineorders.table_order_id;
            ids =[];
            ids.push(tab_pane.find('.input-order-id').val());
            var data={
                sub_total:tab_pane.find('.sub_total').val(),
                dis_total:tab_pane.find('.dis_total').val(),
                dis_total_percentage:tab_pane.find('.dis_total_percentage').val(),
                cgst_per:tab_pane.find('.cgst_per').val(),
                sgst_per:tab_pane.find('.sgst_per').val(),
                cash_payment:tab_pane.find('.cash_payment').val(),
                card_payment:tab_pane.find('.card_payment').val(),
                upi_payment:tab_pane.find('.upi_payment').val(),
                net_banking:tab_pane.find('.net_banking').val(),
                net_total:tab_pane.find('.net_total').val(),
                table_order_id:table_order_id,
                ids:ids,
                order_id:tab_pane.find('.input-order-id').val(),
                invoice_id:tab_pane.find('.input-invoice-id').val(),
				discount_note:tab_pane.find('.discount_note_add').val()
            }
            
            $('#image-loader').show();
            $.ajax({
                url: Onlineorders.base_url+"restaurant/invoice_payment/",
                type:'POST',
                dataType: 'json',
                data: data,
                success: function(response){
                    $('#image-loader').hide();
                /* window.open(Onlineorders.base_url+"restaurant/printbill/"+response.invoice_id,'_blank');*/
                    Onlineorders.getorderdetails();
                    /*window.location.href=Onlineorders.base_url+"restaurant/new_order";*/
                    Onlineorders.displaysucessconfrim('Payment saved Successfully.');
                }
            });
            
                            Onlineorders.getorderdetails();
                            // window.open(Onlineorders.base_url+"restaurant/printbill/"+response.invoice_id,'_blank');
                            //location.reload();
                            /*Onlineorders.displaysucessconfrim('Order is assign to kitchen and print');*/
                        }
                    });
                }else{
                    var cash_payment=tab_pane.find('.cash_payment').val();
            var card_payment=tab_pane.find('.card_payment').val();
            var upi_payment=tab_pane.find('.upi_payment').val();
            var net_banking=tab_pane.find('.net_banking').val();
            var net_total=tab_pane.find('.net_total').val();
            if(cash_payment=="")
                cash_payment=0;
            if(card_payment=="")
                card_payment=0;
            if(upi_payment=="")
                upi_payment=0;
            if(net_banking=="")
                net_banking=0;
            var total_payment=parseFloat(cash_payment)+parseFloat(card_payment)+parseFloat(upi_payment)+parseFloat(net_banking)
            if(total_payment!=parseFloat(net_total)){
                Onlineorders.displaywarning("Please check the amount.");
                return false;
            }
            table_order_id = Onlineorders.table_order_id;
            ids =[];
            ids.push(tab_pane.find('.input-order-id').val());
            var data={
                sub_total:tab_pane.find('.sub_total').val(),
                dis_total:tab_pane.find('.dis_total').val(),
                dis_total_percentage:tab_pane.find('.dis_total_percentage').val(),
                cgst_per:tab_pane.find('.cgst_per').val(),
                sgst_per:tab_pane.find('.sgst_per').val(),
                cash_payment:tab_pane.find('.cash_payment').val(),
                card_payment:tab_pane.find('.card_payment').val(),
                upi_payment:tab_pane.find('.upi_payment').val(),
                net_banking:tab_pane.find('.net_banking').val(),
                net_total:tab_pane.find('.net_total').val(),
                table_order_id:table_order_id,
                ids:ids,
                order_id:tab_pane.find('.input-order-id').val(),
                invoice_id:tab_pane.find('.input-invoice-id').val(),
				discount_note:tab_pane.find('.discount_note_add').val()
            }
            
            $('#image-loader').show();
            $.ajax({
                url: Onlineorders.base_url+"restaurant/invoice_payment/",
                type:'POST',
                dataType: 'json',
                data: data,
                success: function(response){
                    $('#image-loader').hide();
                /* window.open(Onlineorders.base_url+"restaurant/printbill/"+response.invoice_id,'_blank');*/
                    Onlineorders.getorderdetails();
                    /*window.location.href=Onlineorders.base_url+"restaurant/new_order";*/
                    Onlineorders.displaysucessconfrim('Payment saved Successfully.');
                }
            });
            
        }
           
    }, 
	onSubmitOrder1:function()
	{
		debugger;
        var tab_pane=$(this).closest('.tab-pane');
        var cash_payment=tab_pane.find('.cash_payment').val();
        var card_payment=tab_pane.find('.card_payment').val();
        var upi_payment=tab_pane.find('.upi_payment').val();
        var net_banking=tab_pane.find('.net_banking').val();
        var net_total=tab_pane.find('.net_total').val();
        if(cash_payment=="")
            cash_payment=0;
        if(card_payment=="")
            card_payment=0;
        if(upi_payment=="")
            upi_payment=0;
        if(net_banking=="")
            net_banking=0;
        var total_payment=parseFloat(net_total)+parseFloat(card_payment)+parseFloat(upi_payment)+parseFloat(net_banking)
        if(total_payment!=parseFloat(net_total)){
            Onlineorders.displaywarning("Please check the amount.");
            return false;
        }
        table_order_id = Onlineorders.table_order_id;
        ids =[];
        ids.push(tab_pane.find('.input-order-id').val());
        var data={
            sub_total:tab_pane.find('.sub_total').val(),
            dis_total:tab_pane.find('.dis_total').val(),
			dis_total_percentage:tab_pane.find('.dis_total_percentage').val(),
            cgst_per:tab_pane.find('.cgst_per').val(),
            sgst_per:tab_pane.find('.sgst_per').val(),
            cash_payment:tab_pane.find('.cash_payment').val(),
            card_payment:tab_pane.find('.card_payment').val(),
            upi_payment:tab_pane.find('.upi_payment').val(),
            net_banking:tab_pane.find('.net_banking').val(),
            net_total:tab_pane.find('.net_total').val(),
            table_order_id:table_order_id,
            ids:ids,
            order_id:tab_pane.find('.input-order-id').val(),
            invoice_id:tab_pane.find('.input-invoice-id').val()
        }
		
        $('#image-loader').show();
        $.ajax({
            url: Onlineorders.base_url+"restaurant/invoice_payment/",
            type:'POST',
            dataType: 'json',
            data: data,
            success: function(response){
                $('#image-loader').hide();
               /* window.open(Onlineorders.base_url+"restaurant/printbill/"+response.invoice_id,'_blank');*/
                Onlineorders.getorderdetails();
                /*window.location.href=Onlineorders.base_url+"restaurant/new_order";*/
                Onlineorders.displaysucessconfrim('Order is completed Successfully.');
            }
        });
           
    },
    onCreateInvoice:function()
	{
		debugger;
        var self=this;
        var ids=new Array();
		
        $('.input-checksingle-orders').each(function(){
            if($(this).is(':checked')){
                var id=$(this).val();
                ids.push(id);
            }
        });
		
        if(ids.length==0 && Onlineorders.uncheck_ids.length==0)
		{
            Onlineorders.displaywarning("Please select at least one item.");
            return false;
        }
		
        if(ids.length==0)
		{
            var not_all_ids="";
        }
		else
		{
            var not_all_ids="yes";
        }
		
        var table_order_id=Onlineorders.table_order_id;
		
        swal({
            title: 'Are you sure ?',
            text: " you want create invoice",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, create it!',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false
        },
		function () 
		{
            $('#image-loader').show();
            var formData = 
			{
                ids:ids,
                uncheck_ids:Onlineorders.uncheck_ids,
                not_all_ids:not_all_ids,
                table_order_id:table_order_id
            };
            $.ajax({
                url: Onlineorders.base_url+"restaurant/create_invoice",
                type:'POST',
                data:formData ,
                success: function(result)
				{
					console.log(result);
                    $('#image-loader').hide();
					
					if (result.status) 
					{
                        Onlineorders.getorderdetails();
                        $('#table-order-modal').modal('hide');
                        swal({
                            title: 'Are you sure ?',
                            text: " you want print invoice",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, print it!',
                            cancelButtonText: 'No, cancel!',
                            confirmButtonClass: 'btn btn-success',
                            cancelButtonClass: 'btn btn-danger',
                            buttonsStyling: false
                        },
						function (isconfirm) 
						{
                            if(isconfirm)
							{
								window.open(Onlineorders.base_url+"restaurant/printbill/"+result.invoice_id,'_blank');
								location.reload();
                                
                            }
							else
							{
                                location.reload();
                            }
                        });
                   }
                   else
				   {
                        Orders.displaywarning("Something went wrong please try again");
                   }

                }
            });
             
        });
    },
    onViewTableOrder:function()
	{
		debugger;
        var table_order_id=Onlineorders.table_order_id;
        $('#table-order-modal').modal('show');
        $('.input-checkall-orders').prop('checked',false);
        $('.input-checksingle-orders').prop('checked',false);
       /* var table_order_id=$(this).attr('data-id');*/
        var data={
            table_order_id:Onlineorders.table_order_id
        }
        $('#image-loader').show();
        $('.input-tableorder-id').val(table_order_id);
        $.ajax({
            url: Onlineorders.base_url+"restaurant/get_tableorder_details/",
            type:'POST',
            dataType: 'json',
            data: data,
            success: function(response)
			{
                $('#table-order-modal').find('.span_tableorder_no').html(response.table_orderno);
                $('#table-order-modal').find('.span_table_orderdate').html(response.order_date);
                $('#table-order-modal').find('.span_tableno').html(response.table_no);
                var orders=response.orders;
                var html="";
				
                for (i in orders) 
				{
                    var status_color="";
					
                    if(orders[i].status=="New")
					{
                        status_color="badge-warning";
                    }
                    else if(orders[i].status=="Confirmed")
					{
                        status_color="badge-black";
                        
                    }
                    else if(orders[i].status=="Blocked")
					{
                        status_color="badge-orange";
                    }
                    else if(orders[i].status=="Food Served")
					{
                        status_color="badge-indigo";
                    }
                    else if(orders[i].status=="Assigned To Kitchen")
					{
                        status_color="badge-info";
                    }
                    else if(orders[i].status=="Canceled")
					{
                        status_color="badge-danger";
                    }
                    else if(orders[i].status=="Completed")
					{
                        status_color="badge-success";
                    }
					
                    var arr = ["Food Served","Assigned To Kitchen"];
                    var in_array=jQuery.inArray(orders[i].status, arr);
                    
					html+='<tr>\
                        <td>';
                        if(in_array!=-1 && orders[i].is_invoiced==0){
                            html+='<input type="checkbox" class="input-checksingle-orders" name="is_order_check'+i+'" value="'+orders[i].id+'"></td>';
                        }else{
                            html+='<input type="checkbox" class="input-checksingle-orders" name="is_order_check'+i+'" value="'+orders[i].id+'" disabled=""></td>';
                        }
                        html+='<td>'+orders[i].order_no+'</td>\
                        <td>'+orders[i].customer_name+'</td>\
                        <td><span class="badge '+status_color+'">'+orders[i].status+'</span></td>\
                        <td>'+orders[i].order_by_name+'</td>\
                        <td>'+orders[i].net_total+'</td>';
                        if(orders[i].is_invoiced==1)
                            html+='<td>Yes</td>';
                        else
                            html+='<td>No</td>';
                    html+='</tr>';
                }
                $('.tbody-tableorder-list').html(html);
                $('#image-loader').hide();
            }
        });
    },
    printkotorder:function()
	{
		debugger;
        var total_order_count=Onlineorders.orders_count;
        var tab_pane=$(this).closest('.tab-pane');
        var invoice_id=tab_pane.find('.input-invoice-id').val();
        
		if(invoice_id!="")
		{
            window.open(Onlineorders.base_url+"restaurant/printbill/"+invoice_id,'_blank');
        }
		else
		{
            if(parseInt(total_order_count)>1)
			{
                Onlineorders.onViewTableOrder();
            }
			else
			{
                Onlineorders.create_invoice(tab_pane);
            }
        }       
    },
    create_invoice:function(tab_pane)
	{
		debugger;
        table_order_id = Onlineorders.table_order_id;
        var invoice_id=tab_pane.find('.input-invoice-id').val();
        ids =[];
        ids.push(tab_pane.find('.input-order-id').val());
        var data={
            sub_total:tab_pane.find('.sub_total').val(),
            dis_total:tab_pane.find('.dis_total').val(),
            cgst_per:tab_pane.find('.cgst_per').val(),
            sgst_per:tab_pane.find('.sgst_per').val(),
            cash_payment:tab_pane.find('.cash_payment').val(),
            card_payment:tab_pane.find('.card_payment').val(),
            upi_payment:tab_pane.find('.upi_payment').val(),
            net_banking:tab_pane.find('.net_banking').val(),
            net_total:tab_pane.find('.net_total').val(),
            table_order_id:table_order_id,
            ids:ids,
            order_id:tab_pane.find('.input-order-id').val(),
            invoice_id:invoice_id
        }
       
        swal({
            title: 'Are you sure ?',
            text: "you want print bill",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, print it!',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false
        },
		function () 
		{
            if(invoice_id=="")
			{
                $('#image-loader').show();
                $.ajax({
                    url: Onlineorders.base_url+"restaurant/create_invoice/",
                    type:'POST',
                    dataType: 'json',
                    data: data,
                    success: function(response)
					{
                        $('#image-loader').hide();
                        tab_pane.find('.input-invoice-id').val(response.invoice_id);
                        Onlineorders.getorderdetails();
						window.open(Onlineorders.base_url+"restaurant/printbill/"+response.invoice_id,'_blank');
						location.reload();
                        /*Onlineorders.displaysucessconfrim('Order is assign to kitchen and print');*/
                    }
                });
            }
			else
			{
                window.open(Onlineorders.base_url+"restaurant/printbill/"+invoice_id,'_blank');
            }
        }, 
		function (dismiss) 
		{
            if (dismiss === 'cancel') 
			{
                swal(
                  'Cancelled',
                  'Your record is safe :)',
                  'error'
                )
            }
        });
    },
    editorder:function()
	{
		debugger;
        var input=$(this).closest('.input-group').find('.quantity'); 
        var recipe_id = $(this).attr('data-id');
        var qty =  input.val();
        var recipe_price = $(this).attr('data-price');
        var item_id = $(this).attr('data-order_item-id');
        var order_id = $(this).attr('data-order-id');
        var data_type = $(this).attr('data-type');
        console.log(data_type);
		
        if (data_type == 'plus') 
		{
            qty =  parseInt(qty) + 1;  
        }
        if (data_type == 'minus') 
		{
            qty =  parseInt(qty) - 1;
        }
		
        if (qty > 0) 
		{
            Onlineorders.UpdateProduct(item_id,order_id,recipe_id,recipe_price,qty,input);
        }
		
        if (qty <= 0) 
		{
            Onlineorders.deleteProduct(item_id,order_id,recipe_id,recipe_price,qty,input);
        }
    },

    deleteProduct:function(order_item_id,order_id,recipe_id,price,quantity,input)
	{
		debugger;
        var tab_pan=input.closest('.tab-pane');
        var data={
            order_item_id:order_item_id,
            order_id:order_id,
            recipe_id:recipe_id,
            price:price,
            quantity:quantity,
            sub_total:tab_pan.find('.sub_total').val(),
            dis_total:tab_pan.find('.dis_total').val(),
            cgst_per:tab_pan.find('.cgst_per').val(),
            sgst_per:tab_pan.find('.sgst_per').val(),
            net_total:tab_pan.find('.net_total').val()
        }
        $('#image-loader').show();
        $.ajax({
            url: Onlineorders.base_url+"restaurant/delete_orderitem/",
            type:'POST',
            dataType: 'json',
            data: data,
            success: function(response){
                $('#image-loader').show();
                if(response.status){
                    $('#image-loader').hide();
                    Onlineorders.getorder(tab_pan);
                }
                else{
                    if (response.msg) {
                        $('#image-loader').hide();
                        Onlineorders.displaywarning(response.msg);
                        Onlineorders.getorder(tab_pan);
                    }
                }
                //Orderedit.calculateTotal();
            }
        });
    },

    UpdateProduct:function(order_item_id,order_id,recipe_id,price,quantity,input)
	{
		debugger;
        var tab_pan=input.closest('.tab-pane');
        var data={
            order_item_id:order_item_id,
            order_id:order_id,
            recipe_id:recipe_id,
            price:price,
            quantity:quantity,
            sub_total:tab_pan.find('.sub_total').val(),
            dis_total:tab_pan.find('.dis_total').val(),
            dis_total_percentage:tab_pan.find('.dis_total_percentage').val(),
            cgst_per:tab_pan.find('.cgst_per').val(),
            sgst_per:tab_pan.find('.sgst_per').val(),
            net_total:tab_pan.find('.net_total').val()
        }
        $('#image-loader').show();
        $.ajax({
            url: Onlineorders.base_url+"restaurant/update_order_item/",
            type:'POST',
            dataType: 'json',
            data:data,
            success: function(response){
                $('#image-loader').show();
                if(response.status){
                    $('#image-loader').hide();
                    Onlineorders.getorder(tab_pan);
                }
                //Orderedit.calculateTotal();
            }
        });
    },
    clearItemForm:function(tab_pan){
        tab_pan.find(".input-price").val("");
        tab_pan.find(".input-qty").val("");
        tab_pan.find(".input-item-name").val("");
        tab_pan.find(".input-item-id").val("");
        tab_pan.find('.input-row').val("");
        tab_pan.find('.input-discount').val("");
        tab_pan.find('.input-special-notes').val('');
    },
	addneworder:function(){
        var tab_pan=$(this).closest('.tab-pane');
        if (tab_pan.find('.mobile_no').val() =='' || tab_pan.find('.customer_name').val()=='') { 
            Onlineorders.displaywarning('Customer details should not be empty');
            return false; }
        if(tab_pan.find(".input-item-name").val()==""){
            Onlineorders.displaywarning("Please Add Item");
            tab_pan.find(".input-item-name").focus();
            return false;
        }
        if(tab_pan.find(".input-qty").val()==""){
            Onlineorders.displaywarning("Please Add Qty");
            tab_pan.find(".input-qty").focus();
            return false;
        }
        if(tab_pan.find(".input-qty").val()==0){
            Onlineorders.displaywarning("Please add quantity greater than zero");
            tab_pan.find(".input-qty").focus();
            return false;
        }
        if(tab_pan.find(".input-price").val()==""){
            Onlineorders.displaywarning("Please Add Price");
            tab_pan.find(".input-price").focus();
            return false;
        }
        $('#image-loader').show();
		var recipe_id = tab_pan.find('.input-item-id').val();
		var recipe_price =tab_pan.find('.input-price').val();
        var recipe_type = tab_pan.find('.input-item-id').attr('recipe-type');
        var recipe_name = tab_pan.find('.input-item-name').val();
        var order_id=tab_pan.find('.input-order-id').val();
		var addon_data = [];
        var addonprice_data =[];
        var addon_main_categorys =[];
		var addon_ids =[];
		tab_pan.find('input[class="option_name"]:checked').each(function() {
                var val1=this.value;
                var val2=$(this).attr('optionprice');
                var val3=$(this).attr('optionid');
                var val4=$(this).attr('optionmaincategory');

                addon_data.push(val1);
                addonprice_data.push(val2);
                addon_ids.push(val3);
                addon_main_categorys.push(val4);
                //addon_main_category_id.push($(this).attr('optionmaincategoryid'));
            });
        
		if(order_id)
		{
            $.ajax({
                url: Onlineorders.base_url+"restaurant/save_new_order/",
                type:'POST',
                dataType: 'json',
                data: {
                    order_id:order_id,
                    recipe_id:recipe_id,
                    price:recipe_price,
                    qty:tab_pan.find('.input-qty').val(),
                    discount_per:0,
                    special_notes:$('#input-special-notes').val(),
                    sub_total:tab_pan.find('.sub_total').val(),
                    dis_total:tab_pan.find('.dis_total').val(),
                    cgst_per:tab_pan.find('.cgst_per').val(),
                    sgst_per:tab_pan.find('.sgst_per').val(),
                    net_total:tab_pan.find('.net_total').val(),
                    dis_total_percentage:tab_pan.find('.dis_total_percentage').val(),
					addon_data:addon_data,
                    addonprice_data:addonprice_data,
                    addon_ids:addon_ids,
                    addon_main_categorys:addon_main_categorys
					
                },
                success: function(response)
				{
                    $('#image-loader').show();
					$('.placeorder_kitchen_for_view').attr('disabled', false);
					
                    if(response.status)
					{
                        $('#image-loader').hide();
                        tab_pan.find('.input-item-id').val('');
                        tab_pan.find('.input-item-name').val('');
                        Onlineorders.getorder(tab_pan);
                        Onlineorders.clearItemForm(tab_pan);
                    }
                    else
					{
                        if (response.msg) 
						{
                            $('#image-loader').hide();
                            Onlineorders.displaywarning(response.msg);
                        }
                    }
                    //Orderedit.calculateTotal();
                }
            });
        }
		else
		{
            var data={
                id:recipe_id,
                qty:tab_pan.find('.input-qty').val(),
                name:Onlineorders.capitalize_Words(recipe_name),
                price:recipe_price,
                recipe_type:recipe_type,
                contact_number:tab_pan.find('.mobile_no').val(),
                customer_name:tab_pan.find('.customer_name').val(),
                table_id:Onlineorders.table_id,
                table_category_id:Onlineorders.table_category_id,
                special_notes:tab_pan.find('.input-special-notes').val()
            }
    		$.ajax({
                url: Onlineorders.base_url+"cart/addCart_forrest",
                type:'POST',
                data:data,
                success: function(result){
                    $('#image-loader').hide();
                   
                   /* if (result['sessionarray'].length <=0) {
                        $('#placeorder_kitchen').hide();
                        $('#placeorder_kitchen_print').hide();
                    }
                    else{
                        $('#placeorder_kitchen').show();
                        $('#placeorder_kitchen_print').show();
                    }*/
                    var cart_details=result['cart_details'];
                    Onlineorders.showCartData(cart_details,tab_pan);
                	tab_pan.find('.mobile_no').attr("readonly", true) ;
                    tab_pan.find('.customer_name').attr("readonly", true) ;
                    Onlineorders.clearItemForm(tab_pan);
                }
            });
        }
	},
    capitalize_Words:function(str)
    {
        return str.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
    },
    placeorder:function()
	{
		debugger;
        var tab_pane=$(this).closest('.tab-pane');
        
		$.ajax({
            url: Onlineorders.base_url+"restaurant/placeorder",
            type:'POST',
            data:{
                sub_total:tab_pane.find('.sub_total').val(),
                net_total:tab_pane.find('.net_total').val(),
                customer_contact:tab_pane.find('.mobile_no').val(),
                customer_name:tab_pane.find('.customer_name').val(),
                tableid:Onlineorders.table_id
            },
            success: function(result)
			{
                if(result.status)
				{
                    tab_pane.find('.input-order-id').val(result.order_id);
                    window.location.href=Onlineorders.base_url+"restaurant/tablerecipe/"+Onlineorders.table_id+"/"+result.table_orders_id;
                    Onlineorders.getorder(tab_pane);
                    Onlineorders.displaysucess(result.msg);
                }
				else
				{
                    Onlineorders.displaysucess(result.msg);
                }
            }
        });
    },

	getorderhistory:function(){
        var tab_pane=$(this).closest('.tab-pane');
		if (tab_pane.find('.mobile_no').val() =='' || tab_pane.find('.customer_name').val() == '') {
			Onlineorders.displaywarning('Fill customer details');
			return false;
		}
		if (tab_pane.find('.customer_id').val() =='') {
			Onlineorders.displaywarning('No Orders Yet');
			return false;
		}
		$('#orderModal').modal('show');
		$.ajax({
            url: Onlineorders.base_url+"restaurant/getorderhistory",
            type:'POST',
            data:{customer_id:tab_pane.find('.customer_id').val()},
            success: function(result){
            	$('#image-loader').hide();
            	var html ='';
            	var j=1;
            	for (var i = 0; i < result.length; i++) {
            		html+='<tr><td>'+j+'</td>\
            		<td>'+result[i].order_no+'</td>';
            		var status_color="";
                    if(result[i].status=="New"){
                        status_color="badge-warning";
                    }
                    else if(result[i].status=="Confirmed"){
                        status_color="badge-black";
                        
                    }
                    else if(result[i].status=="Blocked"){
                        status_color="badge-orange";
                    }
                    else if(result[i].status=="Food Served"){
                        status_color="badge-indigo";
                    }
                    else if(result[i].status=="Assigned To Kitchen"){
                        status_color="badge-info";
                    }
                    else if(result[i].status=="Canceled"){
                        status_color="badge-danger";
                    }
                    else if(result[i].status=="Completed"){
                        status_color="badge-success";
                    }
            		html+='<td><span class="badge '+status_color+'">'+result[i].status+'</span></td>\
            		<td>'+result[i].disc_total+'</td>\
            		<td>'+result[i].net_total+'</td>\
            		<td>'+result[i].insert_date+'</td><tr>';

            		j=j+1;
            	}
            	$('#order_body').html(html);
            }
        });
	},

	getcustomer:function(){
        var tab_pane=$(this).closest('.tab-pane');
		$('#image-loader').show();
		if ($(this).val().length<8 || $(this).val().length>14) {
			$('#image-loader').hide();
			Onlineorders.displaywarning('Mobile Number should be 8 to 14 digit');
			return false;
		}
		$.ajax({
            url: Onlineorders.base_url+"restaurant/getcustomerid",
            type:'POST',
            data:{contact_number:$(this).val()},
            success: function(result){
            	$('#image-loader').hide();
            	tab_pane.find('.customer_name').val(result.name);
            	tab_pane.find('.customer_id').val(result.id);
            }
        });
	},

    getorder:function(tab_pan){
        var order_id =tab_pan.find('.input-order-id').val();
        $.ajax({
            url: Onlineorders.base_url+"restaurant/get_order_details/",
            type:'POST',
            data:{order_id:order_id},
            success: function(result){
				/* $('#placeorder_kitchen_for_view').attr('disabled', true); */
                Onlineorders.loadItemTable(result['items'],tab_pan,result['order_type']);
                Onlineorders.showOrderDetails(result,tab_pan,result['order_type']);
            }
        });
    },
    showOrderviewMode:function(tab_pane){
        tab_pane.find('.btn-qty-minus').hide();
        tab_pane.find('.btn-qty-plus').hide();
        tab_pane.find('.quantity').attr('disabled','');
        tab_pane.find('.select-item-row').hide();

        tab_pane.find('.dis_total').attr("readonly", true);
		tab_pane.find('.dis_total_percentage').attr("readonly", true);
        tab_pane.find('.cgst_per').attr("readonly", true);
        tab_pane.find('.sgst_per').attr("readonly", true);
    },
    showOrderDetails:function(result,tab_pane,order_type="")
	{
		debugger;
        tab_pane.find('.input-order-id').val(result['id']);
        tab_pane.find('.input-invoice-id').val(result['invoice_id']);
        tab_pane.find('.subtotal_html').html('Sub Total : '+Onlineorders.currency_symbol+" "+ result['sub_total']);
        tab_pane.find('.distotal_html').html('Discount Total : '+Onlineorders.currency_symbol+" "+ result['disc_total']);
        tab_pane.find('.distotal_percentage_html').html('Discount Total : '+Onlineorders.currency_symbol+" "+ result['dis_total_percentage']);
        
		var dis_total = result['disc_total'];
		var dis_total_percentage = result['dis_total_percentage'];
		var disc_percentage_total = result['disc_percentage_total'];
		
		if(disc_percentage_total >0)
		{
			var cgst_total = parseFloat((result['sub_total']*result['cgst_per'])/100).toFixed('2');
			var sgst_total = parseFloat((result['sub_total']*result['sgst_per'])/100).toFixed('2');
			var nettotal = parseFloat(result['net_total']).toFixed('2');
		}
		else
		{
			var cgst_total = parseFloat((result['sub_total']*result['cgst_per'])/100).toFixed('2');
			var sgst_total = parseFloat((result['sub_total']*result['sgst_per'])/100).toFixed('2');
			var nettotal = parseFloat(parseFloat(result['sub_total'])+parseFloat(cgst_total)+parseFloat(sgst_total)-parseFloat(dis_total)).toFixed(2);
		}
		/* var cgst_total = parseFloat((result['net_total']*result['cgst_per'])/100).toFixed('2');
		var sgst_total = parseFloat((result['net_total']*result['sgst_per'])/100).toFixed('2');
		var nettotal = parseFloat(result['net_total'])+parseFloat(cgst_total)+parseFloat(sgst_total); */
		
		tab_pane.find('.nettotal_html').html('Net Total '+Onlineorders.currency_symbol+" "+ nettotal);
        tab_pane.find('.total_html').html('Total '+Onlineorders.currency_symbol+" "+ result['sub_total']);
        tab_pane.find('.sub_total').val(result['sub_total']);
        tab_pane.find('.dis_total').val(result['disc_total']);
        tab_pane.find('.dis_total_percentage').val(result['dis_total_percentage']);
        tab_pane.find('.dis_percentage_totaldetail').val(result['disc_percentage_total']);
        tab_pane.find('.dis_totaldetail').val(result['disc_total']);
        if(result['suggetion']!= null){
        tab_pane.find('.suggetion').val(result['suggetion']);}
		if(result['discount_note']!= null){
        tab_pane.find('.show_discount_note').html('<span style="float:left;">Discount Note : '+result['discount_note']+'</span>');}
        var splitdate = result['created_at'].split(' ');
        const timeString = splitdate[1];
        const timeString12hr = new Date('1970-01-01T' + timeString + 'Z')
        .toLocaleTimeString({},
            {timeZone:'UTC',hour12:true,hour:'numeric',minute:'numeric'}
        );
        var date = new Date(result['created_at']);
        const month = date.toLocaleString('default', { month: 'short' });
        console.log(month);
        var created_date_format = ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) +' '+ month +' ' + date.getFullYear();
        tab_pane.find('.show_date').html('Order DateTime: '+created_date_format+' '+timeString12hr);

        /* tab_pane.find('.net_total').val(result['net_total']); */
        tab_pane.find('.net_total').val(nettotal);

        tab_pane.find('.cgst_per').val(result['cgst_per']);
        tab_pane.find('.sgst_per').val(result['sgst_per']);
        tab_pane.find('.cash_payment').val(result['cash_payment']);
        tab_pane.find('.card_payment').val(result['card_payment']);
        tab_pane.find('.upi_payment').val(result['upi_payment']);
        tab_pane.find('.net_banking').val(result['net_banking']);
        
		if(!result['suggetion'])
		{
			tab_pane.find('.suggetion_html').html('Suggetion - ');
		}
		else
		{
			tab_pane.find('.suggetion_html').html('Suggetion - '+result['suggetion']);
		}

        tab_pane.find('.placeorder_kitchen_print').attr('invoice-id','');
        tab_pane.find('.placeorder_sendon_whatsapp').attr('invoice-id','');

        tab_pane.find('.customer_id').val(result.customer_id);
        tab_pane.find('.customer_name').val(result.customer_name);
        tab_pane.find('.mobile_no').val(result.contact_no);
        tab_pane.find('.number_of_person').val(result.no_of_person);
        tab_pane.find('.mobile_no').attr("readonly", true);
        tab_pane.find('.customer_name').attr("readonly", true);
        tab_pane.find('.number_of_person').attr("readonly", true);
	
        tab_pane.find('.total-section').hide();
        
		if(order_type=='Website')
		{
			tab_pane.find('.number_of_person').hide();
			tab_pane.find('.number_of_person_label').hide();
			tab_pane.find('.item_group').hide();
			tab_pane.find('.payment-section1').show();
			tab_pane.find('.dis_total').attr('disabled',true);
			tab_pane.find('.dis_total_percentage').attr('disabled',true);
			tab_pane.find('.payment-section').hide();
			
		}
		else
		{
			tab_pane.find('.item_group').show();			
			tab_pane.find('.payment-section').show();		
			tab_pane.find('.payment-section1').hide();		
		}
        
        tab_pane.find('.btn-change-status').hide();
        tab_pane.find('.placeorder_kitchen_for_view').hide();
        tab_pane.find('.placeorder_kitchen_print').hide();
        tab_pane.find('.placeorder_sendon_whatsapp').hide();
        tab_pane.find('.submit_order').hide();
        
		if(result['status']=="New")
		{
            status_color="badge-warning";
            console.log('in new');

            tab_pane.find('.btn-accept').show();
            tab_pane.find('.btn-cancel').show();
            tab_pane.find('.btn-block-customer').show();
        }
        else if(result['status']=="Confirmed")
		{
            console.log('in Confirmed');
            tab_pane.find('.placeorder_kitchen_for_view').show();
        }
        else if(result['status']=="Blocked")
		{
           Onlineorders.showOrderviewMode(tab_pane);
            tab_pane.find('.btn-block-customer').attr('disabled','');
            tab_pane.find('.btn-block-customer').html('Blocked');
            tab_pane.find('.btn-block-customer').show();
        }
        else if(result['status']=="Canceled")
		{
           Onlineorders.showOrderviewMode(tab_pane);
            tab_pane.find('.btn-cancel').attr('disabled','');
            tab_pane.find('.btn-cancel').html('Canceled');
            tab_pane.find('.btn-cancel').show();
        }
        else if(result['status']=="Assigned To Kitchen")
		{
            status_color="badge-info";
            /*tab_pane.find('.btn-served').show();*/
            
            tab_pane.find('.placeorder_kitchen_for_view').show();
            tab_pane.find('.placeorder_kitchen_print').show();
            tab_pane.find('.placeorder_sendon_whatsapp').show();
            tab_pane.find('.btn-cancel').show();

            tab_pane.find('.td-payment').show();
            tab_pane.find('.td-totaldetails').show();
		if(order_type!='Website')
		{
            		tab_pane.find('.submit_order').show();
		}
        } 
		else if(result['status']=="Food Served")
		{
            status_color="badge-info";
            /*tab_pane.find('.btn-served').show();*/
            /* $('#placeorder_kitchen_for_view').attr('disabled', true); */
            tab_pane.find('.placeorder_kitchen_for_view').show();
            tab_pane.find('.placeorder_kitchen_print').show();
            tab_pane.find('.placeorder_sendon_whatsapp').show();
        }

        if(result['is_invoiced']==0)
		{
            if(result['status'] =="New" || result['status'] =="Confirmed" || result['status'] =="Blocked" || result['status'] =="Canceled" || result['status'] =="Food Served")
		    {
                tab_pane.find('.td-payment').hide();
            }else{
                tab_pane.find('.td-payment').show();
            }
            
            tab_pane.find('.td-totaldetails').show();
            tab_pane.find('.btn-cancel').show();
			tab_pane.find('.cgst_per').attr("readonly", true);
            tab_pane.find('.sgst_per').attr("readonly", true);
        }
		else
		{
		
            tab_pane.find('.btn-cancel').hide();
            tab_pane.find('.td-payment').show();
            tab_pane.find('.td-totaldetails').show();
		if(order_type=='Website'){
            tab_pane.find('.submit_order1').show();}else{
		tab_pane.find('.submit_order').show();
		}
            tab_pane.find('.placeorder_kitchen_for_view').show();

            tab_pane.find('.placeorder_kitchen_print').show();
            tab_pane.find('.placeorder_sendon_whatsapp').show();

            tab_pane.find('.btn-qty-minus').hide();
            tab_pane.find('.btn-qty-plus').hide();
            tab_pane.find('.quantity').attr('disabled','');
            tab_pane.find('.select-item-row').hide();

            tab_pane.find('.dis_total').attr("readonly", true);
            tab_pane.find('.dis_total_percentage').attr("readonly", true);
            tab_pane.find('.cgst_per').attr("readonly", true);
            tab_pane.find('.sgst_per').attr("readonly", true);
        }
		

        if(result['invoice'])
		{
            if(result['invoice'].length!=0)
			{
                var invoice_details=result['invoice'];
                tab_pane.find('.placeorder_kitchen_print').attr('invoice-id',invoice_details['id']);
                tab_pane.find('.placeorder_sendon_whatsapp').attr('invoice-id',invoice_details['id']);

                var invoice_status=invoice_details['status'];
                
				if(invoice_status=="Paid")
				{
		tab_pane.find('.btn-cancel').hide();
                    tab_pane.find('.submit_order').attr('disabled','');
                    tab_pane.find('.submit_order1').attr('disabled','');
                    tab_pane.find('.cash_payment').val(invoice_details['cash_payment']).attr('readonly',true);
                    tab_pane.find('.card_payment').val(invoice_details['card_payment']).attr('readonly',true);
                    tab_pane.find('.upi_payment').val(invoice_details['upi_payment']).attr('readonly',true);
                    tab_pane.find('.net_banking').val(invoice_details['net_banking']).attr('readonly',true);
                }
            }
        }
    },


    showInvoiceDetails:function(result,tab_pane,order_type)
	{
		console.log(result);
		debugger;
        tab_pane.find('.input-order-id').val('');
        tab_pane.find('.input-invoice-id').val(result['id']);
        tab_pane.find('.subtotal_html').html('Sub Total : '+Onlineorders.currency_symbol+" "+ result['sub_total']);
        tab_pane.find('.distotal_html').html('Discount Total : '+Onlineorders.currency_symbol+" "+ result['disc_total']);
        tab_pane.find('.nettotal_html').html('Net Total '+Onlineorders.currency_symbol+" "+ result['net_total']);
        tab_pane.find('.total_html').html('Total '+Onlineorders.currency_symbol+" "+ result['sub_total']);
        tab_pane.find('.suggetion').html('suggetion '+ result['suggetion']);
        tab_pane.find('.sub_total').val(result['sub_total']);
        tab_pane.find('.dis_total').val(result['disc_total']);
        tab_pane.find('.dis_total_percentage').val(result['dis_total_percentage']);
        tab_pane.find('.dis_totaldetail').val(result['disc_total']);
        tab_pane.find('.net_total').val(result['net_total']);
       
        tab_pane.find('.cgst_per').val(result['cgst_total']);
        tab_pane.find('.sgst_per').val(result['sgst_total']);
        tab_pane.find('.cash_payment').val(result['cash_payment']);
        tab_pane.find('.card_payment').val(result['card_payment']);
        tab_pane.find('.upi_payment').val(result['upi_payment']);
        tab_pane.find('.net_banking').val(result['net_banking']);
        tab_pane.find('.customer_id').val(result.customer_id);
        tab_pane.find('.customer_name').val(result.customer_name);
        tab_pane.find('.number_of_person').val(result.no_of_person);
        tab_pane.find('.mobile_no').val(result.contact_no);
        tab_pane.find('.mobile_no').attr("readonly", true);
        tab_pane.find('.customer_name').attr("readonly", true);
        tab_pane.find('.number_of_person').attr("readonly", true);

        tab_pane.find('.total-section').hide();
        tab_pane.find('.payment-section').show();
		tab_pane.find('.item_group').show();
			
		if(order_type=='Website')
		{
			tab_pane.find('.item_group').hide();
			tab_pane.find('.payment-section1').show();
			tab_pane.find('.payment-section').hide();
			tab_pane.find('.submit_order').hide();
			tab_pane.find('.submit_order1').show();
		}
		else
		{
			tab_pane.find('.item_group').show();
			tab_pane.find('.payment-section').show();		
			tab_pane.find('.payment-section1').hide();
			tab_pane.find('.submit_order').show();
			tab_pane.find('.submit_order1').hide();
			tab_pane.find('.show_discount_note').html('<span style="float:left;">Discount Note : '+result['discount_note']+'</span>');
		}
        
        tab_pane.find('.btn-change-status').hide();
        tab_pane.find('.placeorder_kitchen_for_view').show();
        tab_pane.find('.placeorder_kitchen_print').hide();
        tab_pane.find('.placeorder_sendon_whatsapp').hide();
        /* tab_pane.find('.submit_order').hide(); */
        
      
        tab_pane.find('.td-payment').show();
        tab_pane.find('.td-totaldetails').show();
        /* tab_pane.find('.submit_order').show(); */
        tab_pane.find('.placeorder_kitchen_for_view').show();

        tab_pane.find('.placeorder_kitchen_print').show();
        tab_pane.find('.placeorder_sendon_whatsapp').show();

        tab_pane.find('.btn-qty-minus').hide();
        tab_pane.find('.btn-qty-plus').hide();
        tab_pane.find('.quantity').attr('disabled','');
        tab_pane.find('.select-item-row').hide();

        tab_pane.find('.dis_total').attr("readonly", true);
        tab_pane.find('.dis_total_percentage').attr("readonly", true);
        tab_pane.find('.cgst_per').attr("readonly", true);
        tab_pane.find('.sgst_per').attr("readonly", true);

        tab_pane.find('.placeorder_kitchen_print').attr('invoice-id',result['id']);
        tab_pane.find('.placeorder_sendon_whatsapp').attr('invoice-id',result['id']);

        var invoice_status=result['status'];
        
		if(invoice_status=="Paid")
		{
            tab_pane.find('.submit_order').attr('disabled','');
            tab_pane.find('.submit_order1').attr('disabled','');
			tab_pane.find('.placeorder_kitchen_for_view').attr('disabled','');
            tab_pane.find('.cash_payment').val(result['cash_payment']).attr('readonly',true);
            tab_pane.find('.card_payment').val(result['card_payment']).attr('readonly',true);
            tab_pane.find('.upi_payment').val(result['upi_payment']).attr('readonly',true);
            tab_pane.find('.net_banking').val(result['net_banking']).attr('readonly',true);
        }
    },
    getorderdetails:function()
	{
		debugger;
        $('.nav-panel-tabs').attr('bill-count','1');
        $('.tab-content .tab-pane:not(:first-child):not(:last-child)').remove();
        $('.nav-panel-tabs li:not(:first-child):not(:last-child)').remove();
        var order_id = Onlineorders.table_order_id;
		var invoice_id = Onlineorders.invoice_id;
		var from_page = Onlineorders.from_page;
        //alert(order_id);
        $.ajax({
            url: Onlineorders.base_url+"restaurant/get_tableorder_invoices/",
            type:'POST',
            data:{order_id:order_id,invoice_id:invoice_id},
            success: function(response)
			{
				console.log(response);

                var orders=response['orders'];
                Onlineorders.orders_count=orders.length;

                if(orders.length <=0 && from_page!="invoice" && from_page!="tableorders"){
                    window.location.href=Onlineorders.base_url+'restaurant/weborders';
                    return false
                }

				for(i in orders)
				{
                    if(i==0)
					{
                        var tab_pane=$('.tab-content .tab-pane');
                        var result=orders[i];
                        var order_type=orders[i].order_type;
						
                        Onlineorders.loadItemTable(result['items'],tab_pane,order_type);
                        Onlineorders.showOrderDetails(result,tab_pane,order_type);
                    }
					else
					{
                        Onlineorders.newBill();
                        var tab_pane=$('.tab-content .tab-pane:last');
                        var result=orders[i];
						var order_type=orders[i].order_type;
						
                        Onlineorders.loadItemTable(result['items'],tab_pane,order_type);
                        Onlineorders.showOrderDetails(result,tab_pane,order_type);
                        setTimeout(function(){
                            $('.tab-content .tab-pane').removeClass('active');
                            $('.nav-panel-tabs li').find('a').removeClass('active');
                            $('.nav-panel-tabs li:first').find('a').trigger('click');
                        }, 100);
                    }
                }
				console.log(response['invoices']);
				var invoices=response['invoices'];
				var order_type1=response['order_type'];
				
				if(from_page=="invoice" || from_page=="tableorders")
				{
					if(orders.length==0)
					{
						for(i in invoices)
						{
							if(i==0)
							{
								var tab_pane=$('.tab-content .tab-pane');
								var invoice=invoices[i];
								Onlineorders.loadItemTable(invoice['items'],tab_pane,order_type1);
								Onlineorders.showInvoiceDetails(invoice,tab_pane,order_type1);
							}
							else
							{
								Onlineorders.newBill('invoices');
								var tab_pane=$('.tab-content .tab-pane:last');
								var invoice=invoices[i];
								Onlineorders.loadItemTable(invoice['items'],tab_pane,order_type1);
								Onlineorders.showInvoiceDetails(invoice,tab_pane,order_type1);
								setTimeout(function(){
									$('.tab-content .tab-pane').removeClass('active');
									$('.nav-panel-tabs li').find('a').removeClass('active');
									$('.nav-panel-tabs li:first').find('a').trigger('click');
								}, 100);
							}
						}
					}
					else
					{
						for(i in invoices)
						{
							Onlineorders.newBill('invoices');
							var tab_pane=$('.tab-content .tab-pane:last');
							var invoice=invoices[i];
							Onlineorders.loadItemTable(invoice['items'],tab_pane);
							Onlineorders.showInvoiceDetails(invoice,tab_pane);
							setTimeout(function(){
									$('.tab-content .tab-pane').removeClass('active');
									$('.nav-panel-tabs li').find('a').removeClass('active');
									$('.nav-panel-tabs li:first').find('a').trigger('click');
							}, 100);
						}
					}
				}
            }
        });
    },

    loadItemTable:function(response,tab_pan,orderType="")
	{
		debugger;
        tab_pan.find('.showaddeditems').show();
        tab_pan.find('.showaddeditems').html("");
        
		if(response)
		{
            var html ='';
            console.log(response);
			for (i in response) 
			{
                html += '<tr>\
                    <td style="width:30%">';
                    if (response[i].recipe_type == 'nonveg') 
					{
                        html +='<img src="'+Onlineorders.base_url+'assets/web/images/nv.png" height="10px" width="10px" style="margin-right:10px;">';
                    }
                    else if (response[i].recipe_type == 'veg')
					{
                        html +='<img src="'+Onlineorders.base_url+'assets/web/images/vg.png" height="10px" width="10px" style="margin-right:10px;">';
                    }
                    else
					{
                        html +='';
                    }
                    html +=response[i].recipe_name+'</td><td style="width:15%"><ul>';
					var addondata= response[i].addon_data;
					
                    for (k in addondata){
                    html+='<li>'+addondata[k].option_name+' - '+addondata[k].option_price+'</li>';
                    }
                    html+='</ul></td>'
                    
					if(response[i].special_notes!="" && response[i].special_notes!=undefined)
                        html+='<td style="width:20%" class="td-special-notes">'+response[i].special_notes+'</td>';
                    else
                        html+='<td style="width:20%" class="td-special-notes"></td>';

                    html+='<td style="width:15%">\
                        <div class="input-group input-indec">';
							if (orderType == 'Website')
							{
								html+='<input type="text" readonly name="quantity" min="0" class="form-control input-number text-center quantity" data-order_item-id="'+response[i].id+'" data-order-id="'+response[i].order_id+'" data-id="'+response[i].recipe_id+'"  value="'+response[i].qty+'" style="width:1px;">';	
							}
							else
							{
                            html+='<span class="input-group-btn">\
                                <button type="button" class="quantity-left-minus btn btn-light btn-number btn-qty-minus" data-order_item-id="'+response[i].id+'" data-order-id="'+response[i].order_id+'" data-id="'+response[i].recipe_id+'" data-price="'+response[i].price+'" recipe-type="'+response[i].recipe_type+'" recipe-name="'+response[i].recipe_name+'" data-type="minus" data-field="">\
                                    <i class="fas fa-minus"></i>\
                                </button>\
                            </span>\
                            <input type="text" name="quantity" min="0" class="form-control input-number text-center quantity" data-order_item-id="'+response[i].id+'" data-order-id="'+response[i].order_id+'" data-id="'+response[i].recipe_id+'"  value="'+response[i].qty+'" style="width:1px;">\
                            <span class="input-group-btn">\
                                <button type="button" class="quantity-right-plus btn btn-light btn-number btn-qty-plus" data-order_item-id="'+response[i].id+'" data-order-id="'+response[i].order_id+'" data-id="'+response[i].recipe_id+'" data-price="'+response[i].price+'" recipe-type="'+response[i].recipe_type+'" recipe-name="'+response[i].recipe_name+'" data-type="plus" data-field="">\
                                    <i class="fas fa-plus"></i>\
                                </button>\
                            </span>';
							}
                        html+='</div>\
                    </td>\
                    <td style="width:10%">'+Onlineorders.currency_symbol+" "+response[i].price+'</td>\
                    <td style="width:10%" class="font-weight-bold num-font text-right">'+Onlineorders.currency_symbol+" "+response[i].sub_total+'</td>\
                </tr>';
            }
           tab_pan.find('.showaddeditems').html(html);
        }
       
    },

    addonpopup:function(){
        var tab_pane=$(this).closest('.tab-pane');
		
        var recipe_id = tab_pane.find('.input-item-id').val();
		var group_id = tab_pane.find('.input-item-id').attr('group_id');
		//alert(recipe_id);
        $.ajax({
            url: Onlineorders.base_url+"restaurant/show_recipe_addon/",
            type:'POST',
            dataType: 'json',
            data: {
                recipe_id : recipe_id,
				group_id:group_id
            },
            success: function(result){
				console.log(result);
                tab_pane.find('#show_addon_menu').html('');
                var html = '';
                for(var i=0;i<result.length;i++){
                    var html = '';
                for (var i = 0; i < result.length; i++) {
                    html+='<div class="row">\
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">\
                            <label style="color:black;font-weight:bold;">'+result[i].addon_name+'</label>\
                        </div>\
                    </div>\
                    <div class="row">';
                    for (var j = 0; j < result[i].options.length; j++) {
                        if(result[i].is_multiple_menu == 'Yes'){
                        html+='<div class="col-lg-3 col-md-3 col-sm-6 col-6">\
                        <input type="hidden" class="option_id" value="'+result[i].options[j].option_id+'">\
                        <input type="checkbox" style="width:auto" class="option_name" optionmaincategory="'+result[i].addon_name+'" optionid="'+result[i].options[j].option_id+'" optionprice="'+result[i].options[j].option_price+'" value="'+result[i].options[j].option_name+'"> '+result[i].options[j].option_name+' - '+result[i].options[j].option_price+'\
                        </div>';
                        }
                        else{
                            html+='<div class="col-lg-3 col-md-3 col-sm-6 col-6">\
                            <input type="hidden" class="option_id" value="'+result[i].options[j].option_id+'">\
                            <input type="radio" style="width:auto" name="option_name" class="option_name" optionmaincategory="'+result[i].addon_name+'" optionmaincategoryid="'+result[i].id+'" optionid="'+result[i].options[j].option_id+'" optionprice="'+result[i].options[j].option_price+'" value="'+result[i].options[j].option_name+'"> '+result[i].options[j].option_name+' - '+result[i].options[j].option_price+'\
                            </div>';
                        }
                    }
                    html +='</div>';
                }
                
                }
                tab_pane.find('#show_addon_menu').html(html);
                tab_pane.find('#addonmodal').modal('show');
            }
        });
    },
    

    capitalize_Words:function(str)
    {
        return str.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
    },

    displaysucess:function(msg)
    {
        swal("Success !",msg,"success");
    },

   displaywarning:function(msg)
    {
        swal("Error !",msg,"error");
    },

    displaysucessconfrim:function(msg)
    {
        swal({
            title: '',
            text: msg,
            type: 'success',
            showCancelButton: false,
            confirmButtonColor: '#05C76B',
            cancelButtonColor: '#d33',
            confirmButtonText: 'OK',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false
            },function (isconfirm) {
                if(isconfirm){
                    window.location.href=Onlineorders.base_url+'restaurant/weborders';
                    /*window.location.href=Orders.base_url+"restaurant/printbill/"+invoice_id;*/
                }
                
            });
    },
	
	quantity_plus:function()
	{
        var ordid = $('.input-order-id').val();
		
		if(ordid >0)
		{
			/* if ($("#placeorder_kitchen_for_view").is(":disabled"))
			{ */				
				$('.placeorder_kitchen_for_view').attr('disabled', false);
			/* } */
		}	
	},
};