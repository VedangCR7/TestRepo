var Takeorders ={
	base_url:null,
    table_id:null,
    table_category_id:null,
    uncheck_ids:new Array(),
    table_order_id:null,
	init:function() 
	{
		this.bind_events();
        if (this.table_order_id) 
		{
            /*this.getrecipesforview();*/
            this.getorderdetails();
        }
        else
		{
    		/*this.getrecipes();*/
            this.getCart();
        }
        this.loadMenuItems();
    },

	bind_events :function() {
		var self=this;
		$('#main_menu').on('change',this.onmainmenuchange);
        $('#searchMenuInput').on('keyup',this.onmainmenuchange);
		$('#tab_list').on('click','.changegroup',this.onchangegroup);
        $('#tab_list').on('click','.changegroupforview',this.onchangegroupforview);

		$('.tab-content').on('change','.mobile_no',this.getcustomer);
		$('.tab-content').on('change','.customer_name',this.customername);
		$('.tab-content').on('click',".open_order_history",this.getorderhistory);

		/*$('#submenu').on('click','.addrecipes',this.addneworder);*/
        $('.tab-content').on('click','.btn-add-item',this.addneworder);
        /*$('#submenu').on('click','.addrecipesforview',this.addneworderforview);*/

        $('.tab-content').on('click','.qty_minus',this.onMinusQty);
        $('.tab-content').on('click','.qty_plus',this.onPlusQty);
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

        $('.tab-content').on('click','.btn-qty-plus',this.editorder);
        $('.tab-content').on('click','.btn-qty-minus',this.editorder);

        $('.tab-content').on('click',".placeorder_kitchen",this.placeorder);
        $('.tab-content').on('click',".placeorder_kitchen_for_view",this.kotorder);
        $('.tab-content').on('click',".placeorder_kitchen_print",this.printkotorder);
        $('.tab-content').on('click',".placeorder_sendon_whatsapp",this.printkotorder);
        $('.tab-content').on('click',".submit_order",this.onSubmitOrder);
        $('.tab-content').on('change',".dis_total",this.onChangeCGST);
        $('.tab-content').on('change',".dis_total_percentage",this.onChangeCGST);
        $('.tab-content').on('change',".cgst_per",this.onChangeCGST);
        $('.tab-content').on('change',".sgst_per",this.onChangeCGST);
        $('#new-bill-a').on('click',this.newBill);
       
	},
    onChangeCGST:function()
	{
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
		
        var cgst_total=parseFloat((net_total*cgst_per)/100).toFixed('2');
        var sgst_total=parseFloat((net_total*sgst_per)/100).toFixed('2');
         console.log(cgst_total,sgst_total);
        net_total=net_total+parseFloat(cgst_total)+parseFloat(sgst_total);
        tab_pane.find('.nettotal_html').html('Net Total ₹'+net_total.toFixed('2'));
        tab_pane.find('.net_total').val(net_total.toFixed('2'));
    },
   
    newBill:function()
	{
		debugger;
        var last_bill=$('.tab-content .tab-pane:last');
		
        if(last_bill.find('.input-order-id').val()=="")
		{
            Takeorders.displaywarning('Please save current bill details');
            return false;
        }
		
        var bill_count=$('.nav-panel-tabs').attr('bill-count');
        bill_count=parseInt(bill_count)+1;
        var li=$('.nav-panel-tabs li:last');
        li.prev().after('<li class=""><a href="#invoice-'+bill_count+'" class="active" data-toggle="tab">Order '+bill_count+'</a></li>');
        var html='<div class="tab-pane active " id="invoice-'+bill_count+'">\
            <div class="row">\
            <div class="col-lg-12 col-md-12 col-sm-12 col-12 show_date"></div>\
                <div class="col-lg-12 col-md-12 col-sm-12 col-12" style="margin-top:10px;">\
                    <div class="row pb-2 mb-2" style="border-bottom: 1px solid #ddd;">\
                        <div class="col-lg-5 col-md-12   col-sm-12 col-12">\
                            <label>Contact Number</label>\
                            <input type="hidden" class="customer_id" name="customer_id" id="customer_id'+bill_count+'">\
                            <input type="text" minlength="8" maxlength="14" name="mobile_no" class="mobile_no form-control" placeholder="Customer Contact number" id="mobile_no'+bill_count+'" oninput="this.value = this.value.replace(/[^0-9.]/g, "").replace(/(\..*)\./g, "$1");" onkeypress="return Takeorders.isNumber(event)">\
                        </div>\
                        <div class="col-lg-6 col-md-12 col-sm-12 col-12">\
                            <label>Name</label>\
                            <input type="text" name="customer_name" class="form-control customer_name" placeholder="Customer Name" id="customer_name'+bill_count+'">\
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
                                    <input type="hidden" name="invoice_id" class="input-invoice-id" id="input-invoice-id'+bill_count+'" value="">\
                              </div>\
                            </div>\
                            <div class="col-md-2">\
                                <div class="form-group">\
                                  <label for="">Qty</label>\
                                  <input type="number" class="form-control input-qty" min="0" id="input-qty'+bill_count+'" name="qty">\
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
                                <button type="button" class="btn btn-success btn-add-item" id="btn-add-item'+bill_count+'"> Add</button>\
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
                                        <th style="width:35%">Item</th>\
                                        <th style="width:30%">Notes</th>\
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
                                                <span id="subtotal_html'+bill_count+'" class="subtotal_html">Sub Total : &#8377;</span>\
                                                <input type="hidden" name="" id="sub_total'+bill_count+'"  class="sub_total">\
                                            </td>\
                                        </tr>\
                                        <tr>\
                                            <td class="text-right">\
                                                <span id="distotal_html'+bill_count+'" class="distotal_html">Discount:  &#8377; 0</span>\
                                                <input type="hidden" name="" id="dis_totaldetail'+bill_count+'"  class="dis_totaldetail" >\
                                            </td>\
                                        </tr>\
                                        <tr>\
                                            <td class="text-right">\
                                                <span id="nettotal_html'+bill_count+'" class="nettotal_html">Net Total &#8377;</span>\
                                                <input type="hidden" class="net_total" name="" id="net_total'+bill_count+'">\
                                            </td>\
                                        </tr>\
                                </tbody>\
                                <tbody class="payment-section" style="display: none;">\
                                    <tr>\
                                        <td class="text-right td-totaldetails">\
                                            <span id="subtotal_html'+bill_count+'" class="subtotal_html">Sub Total : &#8377;</span>\
                                            <input type="hidden" name="" id="sub_total'+bill_count+'"  class="sub_total">\
                                        </td>\
                                        <td class="text-right td-payment">\
                                            <span id="payment_html'+bill_count+'" class="payment_html">Payment Type : </span>\
                                        </td>\
                                    </tr>\
                                    <tr>\
                                        <td class="text-right td-totaldetails">\
                                            <span id="bill_discount'+bill_count+'" class="bill_discount">Discount (Rs.):</span>\
                                            <input type="text" name="" id="dis_total'+bill_count+'"  class="dis_total">\
                                        </td>\
                                        <td class="text-right td-payment">\
                                            <span id="cash_html'+bill_count+'" class="cash_html">Cash : </span>\
                                            <input type="text" name="" id="cash_payment'+bill_count+'"  class="cash_payment">\
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
                                            <span id="nettotal_html'+bill_count+'" class="nettotal_html">Grant Total &#8377;</span>\
                                            <input type="hidden" class="net_total" name="" id="net_total'+bill_count+'">\
                                        </td>\
                                        <td class="text-right td-payment">\
                                            <span id="net_banking_html'+bill_count+'" class="net_banking_html">Net Banking : </span>\
                                            <input type="text" name="" id="net_banking'+bill_count+'"  class="net_banking">\
                                        </td>\
                                    </tr>\
                                </tbody>\
                            </table>\
                        </div>\
                    </div>\
                    <div class="col-lg-12 pb-2 col-md-12 col-sm-12 col-12 text-right">\
                        <button class="btn btn-primary placeorder_kitchen_for_view" id="placeorder_kitchen_for_view'+bill_count+'" style="display: none;" >KOT</button>\
                            <button class="btn btn-warning placeorder_kitchen_print" id="placeorder_kitchen_print'+bill_count+'"  style="display: none;">PRINT BILL</button>\
                            <button class="btn btn-info placeorder_sendon_whatsapp" id="placeorder_sendon_whatsapp'+bill_count+'"  style="display: none;">Bill Send On Whatsapp</button>\
                            <button class="btn btn-primary submit_order" id="submit_order'+bill_count+'" style="display: none;">Pay</button>\
                            <button class="btn btn-primary placeorder_kitchen" id="placeorder_kitchen'+bill_count+'">Assign To Kitchen</button>\
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
        var tablecategory=Takeorders.table_category_id;
        $('body').delegate('.input-item-name','focus',function(){
            var $input = $(this);
            $.get(Takeorders.base_url+"restaurant/list_recipes/"+tablecategory, function(data){
                $input.typeahead({ 
                    source:data,autoSelect: true,
                    afterSelect:function(item){
                        var tab_pane=$input.closest('.tab-pane');
                        tab_pane.find('.input-item-id').val(item.id);
                        tab_pane.find('.input-item-id').attr('recipe-type',item.recipe_type);
                        tab_pane.find('.input-price').val(item.price);
                        tab_pane.find('.input-qty').val('1');
                        tab_pane.find('#input-discount').val('0');
                        tab_pane.find('#categoryFlag').val('0');
                    },
                });
            },'json');
        });
    },
    getCart:function()
	{
		debugger;
        $.ajax({
            url: Takeorders.base_url+"cart/get_cart",
            type:'POST',
            data:{},
            success: function(result)
			{
                var cnt=result.count;
                var tab_pane=$('.tab-content .tab-pane');
				
                if(cnt>0)
				{
                    var cart_details=result.cart_detials;
                    Takeorders.showCartData(cart_details,tab_pane);
					
                    for(i in cart_details)
					{
                        $('#mobile_no').val(cart_details[i].options.contact_number);
                        $('#customer_name').val(cart_details[i].options.customer_name);
                        $('#mobile_no').attr("readonly", true) ;
                        $('#customer_name').attr("readonly", true) ;
                        break;
                    }
                }
				else
				{
                    tab_pane.find('.subtotal_html').html('Sub Total : &#8377;'+ 0);
                    tab_pane.find('.nettotal_html').html('Net Total : &#8377;'+ 0);
                    tab_pane.find('.net_total').val('0');
                    tab_pane.find('.sub_total').val('0');
                    tab_pane.find('.distotal_html').html('Discount Total : &#8377;'+ 0);
                    tab_pane.find('.dis_total').val('0');
                    tab_pane.find('.dis_totaldetail').val('0');

                    tab_pane.find('.showaddeditems').html('<tr>\
                        <td colspan="3" class="text-danger text-center" style="padding: 20px 10px;font-size: 15px;">No Item Added</td>\
                        </tr>');
                }
            }
        });
    },
    kotorder:function(){
        var tab_pane=$(this).closest('.tab-pane');
        table_order_id = Takeorders.table_order_id;
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
            $.ajax({
                url: Takeorders.base_url+"restaurant/kot_status/",
                type:'POST',
                dataType: 'json',
                data: data,
                success: function(response){
                    swal({
                        title: '',
                        text: 'Order Assigned to kitchen.',
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
                                window.open(Takeorders.base_url+"restaurant/printbillkot/"+tab_pane.find('.input-order-id').val(),'_blank');
                                tab_pane.find('#placeorder_kitchen_for_view').hide();
                            }
                            else{
                                tab_pane.find('#placeorder_kitchen_for_view').hide();
                            }

                        
                        });
                    $('#image-loader').hide();
                    //Takeorders.displaysucess('Order is assign to kitchen');
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
        
		if(total_payment!=parseFloat(net_total))
		{
            Takeorders.displaywarning("Please check the amount.");
            return false;
        }
		
        table_order_id = Takeorders.table_order_id;
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
            url: Takeorders.base_url+"restaurant/invoice_payment/",
            type:'POST',
            dataType: 'json',
            data: data,
            success: function(response){
                $('#image-loader').hide();
               /* window.open(Takeorders.base_url+"restaurant/printbill/"+response.invoice_id,'_blank');*/
                Takeorders.getorderdetails();
                Takeorders.displaysucessconfrim('Payment saved Successfully.');
            }
        });
           
    },
    sendonwhatsapp:function(){
        var tab_pane=$(this).closest('.tab-pane');
        table_order_id = Takeorders.table_order_id;
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
            confirmButtonText: 'Yes, send on whatsapp!',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false
        },function () {
            if(invoice_id==""){
                $('#image-loader').show();
                $.ajax({
                    url: Takeorders.base_url+"restaurant/create_invoice/",
                    type:'POST',
                    dataType: 'json',
                    data: data,
                    success: function(response){
                        $('#image-loader').hide();
                        tab_pane.find('.input-invoice-id').val(response.invoice_id);
                        Takeorders.getorder(tab_pane);
                        window.open(Takeorders.base_url+"restaurant/printbill/"+response.invoice_id,'_blank');
                        /*
                        Takeorders.displaysucessconfrim('Order is assign to kitchen and print');*/
                    }
                });
            }else{
                window.open(Takeorders.base_url+"restaurant/printbill/"+invoice_id,'_blank');
            }
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
    printkotorder:function()
	{
		debugger;
        var tab_pane=$(this).closest('.tab-pane');
        table_order_id = Takeorders.table_order_id;
        var invoice_id=tab_pane.find('.input-invoice-id').val();
        
		if(invoice_id!="")
		{
            window.open(Takeorders.base_url+"restaurant/printbill/"+invoice_id,'_blank');
        }
		else
		{
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
                        url: Takeorders.base_url+"restaurant/create_invoice/",
                        type:'POST',
                        dataType: 'json',
                        data: data,
                        success: function(response)
						{
							console.log(response);
                            $('#image-loader').hide();
                            tab_pane.find('.input-invoice-id').val(response.invoice_id);
                            Takeorders.getorder(tab_pane);
                            window.open(Takeorders.base_url+"restaurant/printbill/"+response.invoice_id,'_blank');
                            /*
                            Takeorders.displaysucessconfrim('Order is assign to kitchen and print');*/
                        }
                    });
                }
				else
				{
                    window.open(Takeorders.base_url+"restaurant/printbill/"+invoice_id,'_blank');
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
        }       
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
            Takeorders.UpdateProduct(item_id,order_id,recipe_id,recipe_price,qty,input);
        }
        
		if (qty <= 0) 
		{
            Takeorders.deleteProduct(item_id,order_id,recipe_id,recipe_price,qty,input);
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
			dis_total_percentage:tab_pan.find('.dis_total_percentage').val(),
            cgst_per:tab_pan.find('.cgst_per').val(),
            sgst_per:tab_pan.find('.sgst_per').val(),
            net_total:tab_pan.find('.net_total').val()
        }
        $('#image-loader').show();
        $.ajax({
            url: Takeorders.base_url+"restaurant/delete_orderitem/",
            type:'POST',
            dataType: 'json',
            data: data,
            success: function(response){
                $('#image-loader').show();
                if(response.status){
                    $('#image-loader').hide();
                    Takeorders.getorder(tab_pan);
                }
                else{
                    if (response.msg) {
                        $('#image-loader').hide();
                        Takeorders.displaywarning(response.msg);
                        Takeorders.getorder(tab_pan);
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
            url: Takeorders.base_url+"restaurant/update_order_item/",
            type:'POST',
            dataType: 'json',
            data:data,
            success: function(response){
                $('#image-loader').show();
                if(response.status){
                    $('#image-loader').hide();
                    Takeorders.getorder(tab_pan);
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
    onPlusQty:function(){
        var input=$(this).closest('.input-group').find('.quantity');
        var qty=input.val();
        if(qty<1000){
            var inc=parseInt(qty)+1;
            input.val(inc);
        }
        Takeorders.updateCart(input);
    },

    onMinusQty:function(){
        var input=$(this).closest('.input-group').find('.quantity');
        var qty=input.val();
        if(qty>0){
            var inc=parseInt(qty)-1;
            input.val(inc);
        }
        Takeorders.updateCart(input);
    },
    updateCart:function(input){
        $('#image-loader').show();
        //console.log(select_menu);
        var data={
            id:input.attr('data-id'),
            rowid:input.attr('rowid'),
            qty:input.val(),
        };
        //console.log(data);
        if(input.val()==0){
            input.removeAttr('rowid');
        }
        $.ajax({
            url: Takeorders.base_url+"cart/addCart",
            type:'POST',
            data:data,
            success: function(result){
                $('#image-loader').hide();
                 var cart_details=result['cart_detials'];
                 var tab_pan=input.closest('.tab-pane');
                Takeorders.showCartData(cart_details,tab_pan);
            }
        });
    },
	addneworder:function()
	{
        var tab_pan=$(this).closest('.tab-pane');
        var phoneno = /^\d{8,14}$/;
		
        if (!(tab_pan.find('.mobile_no').val().match(phoneno))) 
		{
			$('#image-loader').hide();
			Takeorders.displaywarning('Mobile Number should be 8 to 14 digit');
            /*$('#mobile_no').val('');*/
            document.getElementById('mobile_no').value = '';
			return false;
		}
		
        if(tab_pan.find('.customer_name').val().length < 2 || tab_pan.find('.customer_name').val().length > 30){
            $('#image-loader').hide();
            Takeorders.displaywarning('Customer name should be 2 to 30 characters');
			return false;
        }
		
        if (tab_pan.find('.mobile_no').val() =='' || tab_pan.find('.customer_name').val()=='') 
		{ 
            Takeorders.displaywarning('Customer details should not be empty');
            return false; 
		}
		
        if(tab_pan.find(".input-item-name").val()=="")
		{
            Takeorders.displaywarning("Please Add Item");
            tab_pan.find(".input-item-name").focus();
            return false;
        }
        
		if(tab_pan.find(".input-qty").val()=="")
		{
            Takeorders.displaywarning("Please Add Qty");
            tab_pan.find(".input-qty").focus();
            return false;
        }
		
        if(tab_pan.find(".input-qty").val()==0)
		{
            Takeorders.displaywarning("Please add quantity greater than zero");
            tab_pan.find(".input-qty").focus();
            return false;
        }
		
        if(tab_pan.find(".input-price").val()=="")
		{
            Takeorders.displaywarning("Please Add Price");
            tab_pan.find(".input-price").focus();
            return false;
        }
		
        $('#image-loader').show();
		var recipe_id = tab_pan.find('.input-item-id').val();
		var recipe_price =tab_pan.find('.input-price').val();
        var recipe_type = tab_pan.find('.input-item-id').attr('recipe-type');
        var recipe_name = tab_pan.find('.input-item-name').val();
        var order_id=tab_pan.find('.input-order-id').val();
        
		if(order_id)
		{
            $.ajax({
                url: Takeorders.base_url+"restaurant/save_new_order/",
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
                },
                success: function(response){
                    $('#image-loader').show();
                    if(response.status){
                        $('#image-loader').hide();
                        
                        tab_pan.find('.input-item-id').val('');
                        tab_pan.find('.input-item-name').val('');
                        Takeorders.getorder(tab_pan);
                        Takeorders.clearItemForm(tab_pan);
                    }
                    else{
                        if (response.msg) {
                            $('#image-loader').hide();
                            Takeorders.displaywarning(response.msg);
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
                name:Takeorders.capitalize_Words(recipe_name),
                price:recipe_price,
                recipe_type:recipe_type,
                contact_number:tab_pan.find('.mobile_no').val(),
                customer_name:tab_pan.find('.customer_name').val(),
                table_id:Takeorders.table_id,
                table_category_id:Takeorders.table_category_id,
                special_notes:tab_pan.find('.input-special-notes').val()
            }
    		$.ajax({
                url: Takeorders.base_url+"cart/addCart_forrest",
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
                    Takeorders.showCartData(cart_details,tab_pan);
                	tab_pan.find('.mobile_no').attr("readonly", true) ;
                    tab_pan.find('.customer_name').attr("readonly", true) ;
                    Takeorders.clearItemForm(tab_pan);
                }
            });
        }
	},
    showCartData:function(cart_details,tab_pan){
        var html = '';
        var sub_total = 0;
        for (i in cart_details) {
            html+='<tr>\
                    <td style="width:35%">';
                    if (cart_details[i].options.recipe_type == 'nonveg') {
                            html +='<img src="'+Takeorders.base_url+'assets/web/images/nv.png" height="10px" width="10px" style="margin-right:10px;">';
                        }
                        else if (cart_details[i].options.recipe_type == 'veg'){
                            html +='<img src="'+Takeorders.base_url+'assets/web/images/vg.png" height="10px" width="10px" style="margin-right:10px;">';
                        }
                        else{
                            html +='';
                        }
                        html +=cart_details[i].name+'</td>\
                    <td style="width:30%">'+cart_details[i].options.special_notes+'</td>\
                    <td style="width:15%">\
                        <div class="input-group input-indec">\
                            <span class="input-group-btn">\
                                <button type="button" class="quantity-left-minus btn btn-light btn-number qty_minus" data-id="'+cart_details[i].options.menu_id+'" data-price="'+cart_details[i].price+'" recipe-type="'+cart_details[i].options.recipe_type+'" recipe-name="'+cart_details[i].name+'" data-type="minus" data-field="">\
                                    <i class="fas fa-minus"></i>\
                                </button>\
                            </span>\
                            <input type="text" name="quantity" min="0" class="form-control input-number text-center quantity" data-id="'+cart_details[i].options.menu_id+'" rowid="'+cart_details[i].rowid+'" value="'+cart_details[i].qty+'" style="width:1px;">\
                            <span class="input-group-btn">\
                                <button type="button" class="quantity-right-plus btn btn-light btn-number qty_plus" data-id="'+cart_details[i].options.menu_id+'" data-price="'+cart_details[i].price+'" recipe-type="'+cart_details[i].options.recipe_type+'" recipe-name="'+cart_details[i].name+'" data-type="plus" data-field="">\
                                    <i class="fas fa-plus"></i>\
                                </button>\
                            </span>\
                        </div>\
                    </td>\
                    <td style="width:10%" class="text-right">&#8377; '+cart_details[i].price+'</td>\
                    <td style="width:10%" class="font-weight-bold num-font text-right">&#8377; '+cart_details[i].subtotal+'</td>\
                   </tr>';
                sub_total = parseFloat(sub_total) + parseFloat(cart_details[i].subtotal); 
        }
        tab_pan.find('.subtotal_html').html('Sub Total : &#8377;'+ sub_total);
        tab_pan.find('.nettotal_html').html('Net Total : &#8377;'+ sub_total);
        tab_pan.find('.net_total').val(sub_total);
        tab_pan.find('.sub_total').val(sub_total);
        tab_pan.find('.showaddeditems').html(html);
        tab_pan.find('.distotal_html').html('Discount Total : &#8377;'+ 0);
        tab_pan.find('.dis_total').val('0');
        tab_pan.find('.dis_totaldetail').val('0');

        var $table = tab_pan.find('table.billing_table'),
        $bodyCells = $table.find('tbody tr:first').children(),
        colWidth;

        // Adjust the width of thead cells when window resizes
        $(window).resize(function() {
            // Get the tbody columns width array
            colWidth = $bodyCells.map(function() {
                return $(this).width();
            }).get();
            
            // Set the width of thead columns
            $table.find('thead tr').children().each(function(i, v) {
                $(v).width(colWidth[i]);
            });    
        }).resize(); // Trigger resize handler
    },
    capitalize_Words:function(str)
    {
        return str.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
    },
    placeorder:function()
	{
		debugger;
		var tab_pane=$(this).closest('.tab-pane');
        var sub_total_for_order = tab_pane.find('.sub_total').val();
        var net_total_for_order = tab_pane.find('.net_total').val()
		
		if(!sub_total_for_order || !net_total_for_order || sub_total_for_order=="0" || net_total_for_order=="0")
		{
			Takeorders.displaywarning("Please enter at least one item to place order");
            return false;
        }
		
		if(tab_pane.find('.customer_name').val()!="" && tab_pane.find('.mobile_no').val()!="")
		{
            if (tab_pane.find('.customer_name').val().length < 2 || tab_pane.find('.customer_name').val().length > 30) 
			{ 
				Takeorders.displaywarning("Name field should min 2 to max 30 characters"); 
			}
            else
			{
				if (tab_pane.find('.mobile_no').val().length < 8 || tab_pane.find('.mobile_no').val().length > 14) { Takeorders.displaywarning("Contact Number Should be 8 to 14 digit"); $('#mobile_no').val()='';}
							
				$.ajax({
					url: Takeorders.base_url+"restaurant/placeorder",
					type:'POST',
					data:{
						sub_total:tab_pane.find('.sub_total').val(),
						net_total:tab_pane.find('.net_total').val(),
						customer_contact:tab_pane.find('.mobile_no').val(),
						customer_name:tab_pane.find('.customer_name').val(),
						tableid:Takeorders.table_id
					},
					success: function(result)
					{
                        console.log(result);
						if(result.status)
						{	
                            swal({
                                title: '',
                                text: 'Order placed successfully',
                                type: 'success',
                                showCancelButton: true,
                                confirmButtonColor: '#05C76B',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Print Bill',
                                cancelButtonText: 'No, cancel!',
                                confirmButtonClass: 'btn btn-success',
                                cancelButtonClass: 'btn btn-danger',
                                buttonsStyling: false
                            },
							function (isConfirm) 
							{
								if(isConfirm)
								{
									window.open(Takeorders.base_url+"restaurant/printbillkot/"+result.order_id,'_blank');
									//window.location.href=Takeorders.base_url+'restaurant/new_order';
									/*window.location.href=Orders.base_url+"restaurant/printbill/"+invoice_id;*/
									tab_pane.find('.input-order-id').val(result.order_id);
									//Takeorders.displaysucessconfirm(Takeorders.table_id,result.order_id);
									window.location.href=Takeorders.base_url+"restaurant/tablerecipe/"+Takeorders.table_id+"/"+result.table_orders_id;
									Takeorders.getorder(tab_pane);
									//hide kot btn change by shweta
									tab_pane.find('#placeorder_kitchen_for_view').hide();
                                }
                                else
								{
									tab_pane.find('.input-order-id').val(result.order_id);
									//Takeorders.displaysucessconfirm(Takeorders.table_id,result.order_id);
									window.location.href=Takeorders.base_url+"restaurant/tablerecipe/"+Takeorders.table_id+"/"+result.table_orders_id;
									Takeorders.getorder(tab_pane);
									//hide kot btn change by shweta
									tab_pane.find('#placeorder_kitchen_for_view').hide();
								}
							});
							//Takeorders.displaysucess(result.msg);
                            
							// var b = Takeorders.displaysucessconfirm(result.msg,result.order_id);
							// alert(b);
						}
						else
						{
							// Takeorders.displaysucessconfirm(result.msg,result.order_id);
							Takeorders.displaywarning(result.msg);
						}
					}
				});							
			}
		}
		else
		{
			Takeorders.displaywarning("Please Fill all the fields");
		}
    },

	getorderhistory:function(){
        var tab_pane=$(this).closest('.tab-pane');
		if (tab_pane.find('.mobile_no').val() =='' || tab_pane.find('.customer_name').val() == '') {
			Takeorders.displaywarning('Fill customer details');
			return false;
		}
		if (tab_pane.find('.customer_id').val() =='') {
			Takeorders.displaywarning('No Orders Yet');
			return false;
		}
		$('#orderModal').modal('show');
		$.ajax({
            url: Takeorders.base_url+"restaurant/getorderhistory",
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

	onmainmenuchange:function(){
        if ($('#orderid').val() == '') {
		  Takeorders.getrecipes();
        }else{
            Takeorders.getrecipesforview();
        }
	},

	onchangegroup:function(){
		var group_id = $(this).attr('data-id');
		Takeorders.getrecipes(group_id);
	},

    onchangegroupforview :function(){
        var group_id = $(this).attr('data-id');
        Takeorders.getrecipesforview(group_id);
    },

	getcustomer:function()
	{
        var tab_pane=$(this).closest('.tab-pane');
		$('#image-loader').show();
        var phoneno = /^\d{8,14}$/;
		
		if (!($(this).val().match(phoneno))) 
		{
			$('#image-loader').hide();
			Takeorders.displaywarning('Mobile Number should be 8 to 14 digit');
            /*$('#mobile_no').val('');*/
            document.getElementById('mobile_no').value = '';
			return false;
		}
		else if($(this).val() <= 0)
		{
			$('#image-loader').hide();
			Takeorders.displaywarning('Mobile Number cannot be zero.');
            document.getElementById('mobile_no').value = '';
            $('#mobile_no').val('');
			return false;
		}
		
		$.ajax({
            url: Takeorders.base_url+"restaurant/getcustomerid",
            type:'POST',
            data:{contact_number:$(this).val()},
            success: function(result){
            	$('#image-loader').hide();
            	tab_pane.find('.customer_name').val(result.name);
            	tab_pane.find('.customer_id').val(result.id);
            }
        });
	},
	
	customername:function()
	{
        var tab_pane=$(this).closest('.tab-pane');
        $('#image-loader').show();
        if($(this).val().length < 2 || $(this).val().length > 30){
            $('#image-loader').hide();
            Takeorders.displaywarning('Customer name should be 2 to 30 characters');
			return false;
        }
		$('#image-loader').show();
        /*var phoneno = /^a-zA-Z {2,30}$/;*/
        var phoneno = /^[a-zA-Z]+(\s{0,1}[a-zA-Z])*$/
		
		if (!($(this).val().match(phoneno))) 
		{
			$('#image-loader').hide();
			Takeorders.displaywarning('Please enter proper name');
			return false;
		}
        $('#image-loader').hide();
	},

	getrecipes:function(group_id=''){
		$('#image-loader').show();
		$.ajax({
            url: Takeorders.base_url+"restaurant/getmenugrouprecipes",
            type:'POST',
            data:{main_menu_id:$('#main_menu').val(),group_id:group_id,tablecategory:$('#tablecategory').val(),search:$('#searchMenuInput').val()},
            success: function(result){
            	$('#image-loader').hide();
            	//alert(result.data.length)
            	var html ='';
            	var html1 ='';
            	for (var i = 0; i < result.data.length; i++) {
            		if (group_id != '') {
            		if (result.data[i].id == group_id) {
            			var classactive = 'active';
            		}
            		else{
            			var classactive = '';
            		}
            	}
            	else{
            		if (i == 0) {
            			var classactive = 'active';
            		}
            		else{
            			var classactive = '';
            		}
            	}
            		html += '<li class="'+classactive+' changegroup" data-id="'+result.data[i].id+'">'+Takeorders.capitalize_Words(result.data[i].title)+'</li>';
            	}
            	$('#tab_list').html(html);
            	for (var i = 0; i < result.menu.length; i++) {
            			html1 +='<div class="col-md-2 addrecipes m-1 p-2 recipewidth" title="add menu in order" data-id="'+result.menu[i].id+'" recipe-name="'+result.menu[i].name+'" data-price="'+result.menu[i].price+'" recipe-type="'+result.menu[i].recipe_type+'">';
            			if (result.menu[i].recipe_type == 'veg') {
            				html1+='<img src="'+Takeorders.base_url+'assets/images/Veg.png">';
            			}if (result.menu[i].recipe_type == 'nonveg'){
            				html1+='<img src="'+Takeorders.base_url+'assets/images/NonVeg.png">';
            			}
						html1+='<a class="" title="add menu in order" style="font-size:10px;margin-left:10px;" data-id="'+result.menu[i].id+'" recipe-name="'+result.menu[i].name+'" data-price="'+result.menu[i].price+'" recipe-type="'+result.menu[i].recipe_type+'">'+ Takeorders.capitalize_Words(result.menu[i].name)+'</a>\
					</div>';
            	}
            	$('#submenu').html(html1);
            }
        });
	},

    getrecipesforview:function(group_id=''){
        $('#image-loader').show();
        $.ajax({
            url: Takeorders.base_url+"restaurant/getmenugrouprecipes",
            type:'POST',
            data:{main_menu_id:$('#main_menu').val(),group_id:group_id,tablecategory:$('#tablecategory').val(),search:$('#searchMenuInput').val()},
            success: function(result){
                $('#image-loader').hide();
                //alert(result.data.length)
                var html ='';
                var html1 ='';
                for (var i = 0; i < result.data.length; i++) {
                    if (group_id != '') {
                    if (result.data[i].id == group_id) {
                        var classactive = 'active';
                    }
                    else{
                        var classactive = '';
                    }
                }
                else{
                    if (i == 0) {
                        var classactive = 'active';
                    }
                    else{
                        var classactive = '';
                    }
                }
                    html += '<li class="'+classactive+' changegroupforview" data-id="'+result.data[i].id+'">'+Takeorders.capitalize_Words(result.data[i].title)+'</li>';
                }
                $('#tab_list').html(html);
                for (var i = 0; i < result.menu.length; i++) {
                        html1 +='<div class="bg-white m-1 p-2 recipewidth" style="text-align:center;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">';
                        if (result.menu[i].recipe_type == 'veg') {
                            html1+='<img src="'+Takeorders.base_url+'assets/images/Veg.png" style="position:absoulte;width:10px;height:10px;">';
                        }if (result.menu[i].recipe_type == 'nonveg'){
                            html1+='<img src="'+Takeorders.base_url+'assets/images/NonVeg.png" style="width:10px;height:10px;">';
                        }
                                    html1+='<a class="addrecipesforview" title="add menu in order" style="font-size:10px;margin-left:10px;" data-id="'+result.menu[i].id+'" recipe-name="'+result.menu[i].name+'" data-price="'+result.menu[i].price+'" recipe-type="'+result.menu[i].recipe_type+'">'+ Takeorders.capitalize_Words(result.menu[i].name)+'</a>\
                                </div>';
                }
                $('#submenu').html(html1);
            }
        });
    },
    getorder:function(tab_pan){
        var order_id =tab_pan.find('.input-order-id').val();
        $.ajax({
            url: Takeorders.base_url+"restaurant/get_order_details/",
            type:'POST',
            data:{order_id:order_id},
            success: function(result){
                Takeorders.loadItemTable(result['items'],tab_pan);
                tab_pan.find('.input-order-id').val(result['id']);
                tab_pan.find('.input-invoice-id').val(result['invoice_id']);

                tab_pan.find('.input-order-id').val(result['id']);
                tab_pan.find('.subtotal_html').html('Sub Total : &#8377; '+ result['sub_total']);
                tab_pan.find('.distotal_html').html('Discount Total : &#8377; '+ result['disc_total']);
                tab_pan.find('.nettotal_html').html('Net Total &#8377; '+ result['net_total']);
                tab_pan.find('.total_html').html('Total &#8377; '+ result['sub_total']);
                tab_pan.find('.sub_total').val(result['sub_total']);
                tab_pan.find('.dis_total').val(result['disc_total']);
                tab_pan.find('.dis_totaldetail').val(result['disc_total']);

                tab_pan.find('.net_total').val(result['net_total']);

                tab_pan.find('.cgst_per').val(result['cgst_per']);
                tab_pan.find('.sgst_per').val(result['sgst_per']);
                tab_pan.find('.cash_payment').val(result['cash_payment']);
                tab_pan.find('.card_payment').val(result['card_payment']);
                tab_pan.find('.upi_payment').val(result['upi_payment']);
                tab_pan.find('.net_banking').val(result['net_banking']);

                tab_pan.find('.customer_id').val(result.customer_id);
                tab_pan.find('.customer_name').val(result.customer_name);
                tab_pan.find('.mobile_no').val(result.contact_no);
                tab_pan.find('.mobile_no').attr("readonly", true);
                tab_pan.find('.customer_name').attr("readonly", true);
                tab_pan.find('.placeorder_kitchen_print').attr('invoice-id',result['invoice_id']);
                tab_pan.find('.placeorder_sendon_whatsapp').attr('invoice-id',result['invoice_id']);
                
                tab_pan.find('.total-section').hide();
                tab_pan.find('.payment-section').show();
                if(result['is_invoiced']==0){
                    tab_pan.find('.td-payment').hide();
                    tab_pan.find('.td-totaldetails').show();

                    tab_pan.find('.placeorder_kitchen_for_view').show();
                    tab_pan.find('.placeorder_kitchen_print').show();
                    tab_pan.find('.placeorder_sendon_whatsapp').show();
                    tab_pan.find('.submit_order').hide();
                }else{
                    tab_pan.find('.td-payment').show();
                    tab_pan.find('.td-totaldetails').show();
                    tab_pan.find('.submit_order').show();
                    tab_pan.find('.placeorder_kitchen_for_view').hide();

                    tab_pan.find('.placeorder_kitchen_print').show();
                    tab_pan.find('.placeorder_sendon_whatsapp').show();

                    tab_pan.find('.btn-qty-minus').hide();
                    tab_pan.find('.btn-qty-plus').hide();
                    tab_pan.find('.quantity').attr('disabled','');
                    tab_pan.find('.select-item-row').hide();

                    tab_pan.find('.dis_total').attr("readonly", true);
                    tab_pan.find('.cgst_per').attr("readonly", true);
                    tab_pan.find('.sgst_per').attr("readonly", true);
                }

                if(result['invoice'].length!=0){
                    var invoice_details=result['invoice'];
                    var invoice_status=invoice_details['status'];
                    if(invoice_status=="Paid"){
                        tab_pan.find('.submit_order').attr('disabled','');
                        tab_pan.find('.cash_payment').val(invoice_details['cash_payment']).attr('readonly',true);
                        tab_pan.find('.card_payment').val(invoice_details['card_payment']).attr('readonly',true);
                        tab_pan.find('.upi_payment').val(invoice_details['upi_payment']).attr('readonly',true);
                        tab_pan.find('.net_banking').val(invoice_details['net_banking']).attr('readonly',true);
                    }
                }

            }
        });
    },
    getorderdetails:function()
	{
		debugger;
        $('.nav-panel-tabs').attr('bill-count','1');
        $('.tab-content .tab-pane:not(:first-child):not(:last-child)').remove();
        $('.nav-panel-tabs li:not(:first-child):not(:last-child)').remove();
        var order_id = Takeorders.table_order_id;
        var invoice_id = Takeorders.invoice_id;
        //alert(order_id);
        $.ajax({
            url: Takeorders.base_url+"restaurant/get_order/",
            type:'POST',
            data:{order_id:order_id,invoice_id:invoice_id},
            success: function(response)
			{
                var orders=response['orders'];
                
				for(i in orders)
				{
                    if(i==0)
					{
                        var tab_pane=$('.tab-content .tab-pane');
                        var result=orders[i];
                        //alert(result['suggetion']);
                        Takeorders.loadItemTable(result['items'],tab_pane);
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
                        tab_pane.find('.show_date').html('Order DateTime : '+created_date_format+' '+timeString12hr);
                        if(result['suggetion'] != null)
						{
                            tab_pane.find('#showsuggetion').html('<span style="font-weight:bold;">Customer Suggetion : '+result['suggetion']+'</span>');
                            tab_pane.find('#showsuggetion').show();
                        }
                        
						tab_pane.find('.input-order-id').val(result['id']);
                        tab_pane.find('.input-invoice-id').val(result['invoice_id']);

                        tab_pane.find('.subtotal_html').html('Sub Total : &#8377; '+ result['sub_total']);
                        tab_pane.find('.distotal_html').html('Discount Total : &#8377; '+ result['disc_total']);
                        
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
							var nettotal = parseFloat(result['sub_total'])+parseFloat(cgst_total)+parseFloat(sgst_total);
						}	
						/* var nettotal = parseFloat(result['net_total']).toFixed('2'); */
						
						console.log('cgst_total : '+cgst_total);
						console.log('sgst_total : '+sgst_total);
						console.log('nettotal : '+nettotal);
						tab_pane.find('.nettotal_html').html('Net Total &#8377; '+ parseFloat(nettotal).toFixed('2'));
                        
						tab_pane.find('.total_html').html('Total &#8377; '+ result['sub_total']);
                        tab_pane.find('.sub_total').val(result['sub_total']);
                        tab_pane.find('.dis_total').val(result['disc_total']);
                        tab_pane.find('.dis_total_percentage').val(result['dis_total_percentage']);
                        tab_pane.find('.dis_totaldetail').val(result['disc_total']);

                        /* tab_pane.find('.net_total').val(result['net_total']); */
                        tab_pane.find('.net_total').val(parseFloat(nettotal).toFixed('2'));

                        tab_pane.find('.cgst_per').val(result['cgst_per']);
                        tab_pane.find('.sgst_per').val(result['sgst_per']);
                        tab_pane.find('.cash_payment').val(result['cash_payment']);
                        tab_pane.find('.card_payment').val(result['card_payment']);
                        tab_pane.find('.upi_payment').val(result['upi_payment']);
                        tab_pane.find('.net_banking').val(result['net_banking']);

                        tab_pane.find('.customer_id').val(result.customer_id);
                        tab_pane.find('.customer_name').val(result.customer_name);
                        tab_pane.find('.mobile_no').val(result.contact_no);
                        tab_pane.find('.mobile_no').attr("readonly", true);
                        tab_pane.find('.customer_name').attr("readonly", true);
                        tab_pane.find('.placeorder_kitchen').hide();
                        tab_pane.find('.submit_order').hide();
                        
                        tab_pane.find('.total-section').hide();
                        tab_pane.find('.payment-section').show();
                        
						if(result['is_invoiced']==0)
						{
                            tab_pane.find('.td-payment').hide();
                            tab_pane.find('.td-totaldetails').show();

                            tab_pane.find('.placeorder_kitchen_for_view').hide();
                            tab_pane.find('.placeorder_kitchen_print').show();
                            tab_pane.find('.placeorder_sendon_whatsapp').show();
                            tab_pane.find('.submit_order').hide();
							
							tab_pane.find('.cgst_per').attr("readonly", true);
                            tab_pane.find('.sgst_per').attr("readonly", true);
                        }
						else
						{
                            tab_pane.find('.td-payment').show();
                            tab_pane.find('.td-totaldetails').show();
                            tab_pane.find('.submit_order').show();
                            tab_pane.find('.placeorder_kitchen_for_view').hide();

                            tab_pane.find('.placeorder_kitchen_print').show();
                            tab_pane.find('.placeorder_sendon_whatsapp').show();

                            tab_pane.find('.btn-qty-minus').hide();
                            tab_pane.find('.btn-qty-plus').hide();
                            tab_pane.find('.quantity').attr('disabled','');
                            tab_pane.find('.select-item-row').hide();

                            tab_pane.find('.dis_total_percentage').attr("readonly", true);
                            tab_pane.find('.dis_total').attr("readonly", true);
                            tab_pane.find('.cgst_per').attr("readonly", true);
                            tab_pane.find('.sgst_per').attr("readonly", true);
                        }
						
                        if(result['invoice'])
						{
                            if(result['invoice'].length!=0)
							{
                                var invoice_details=result['invoice'];
                                var invoice_status=invoice_details['status'];
                                
								if(invoice_status=="Paid")
								{
                                    tab_pane.find('.submit_order').attr('disabled','');
                                    tab_pane.find('.cash_payment').val(invoice_details['cash_payment']).attr('readonly',true);
                                    tab_pane.find('.card_payment').val(invoice_details['card_payment']).attr('readonly',true);
                                    tab_pane.find('.upi_payment').val(invoice_details['upi_payment']).attr('readonly',true);
                                    tab_pane.find('.net_banking').val(invoice_details['net_banking']).attr('readonly',true);
                                }
                            }
                        }
                    }
					else
					{
                        Takeorders.newBill();
                        var tab_pane=$('.tab-content .tab-pane:last');
                        var result=orders[i];
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
                        tab_pane.find('.show_date').html('Order DateTime : '+created_date_format+' '+timeString12hr);
                        Takeorders.loadItemTable(result['items'],tab_pane);

                        tab_pane.find('.input-order-id').val(result['id']);
                        tab_pane.find('.input-invoice-id').val(result['invoice_id']);

                        if(result['suggetion'] != null)
						{
                            tab_pane.find('#showsuggetion').html('<span style="font-weight:bold;">Customer Suggetion : '+result['suggetion']+'</span>');
                            tab_pane.find('#showsuggetion').show();
                        }

                        tab_pane.find('.subtotal_html').html('Sub Total : &#8377; '+ result['sub_total']);
                        tab_pane.find('.distotal_html').html('Discount Total : &#8377; '+ result['disc_total']);
                        tab_pane.find('.nettotal_html').html('Net Total &#8377; '+ result['net_total']);
                        tab_pane.find('.total_html').html('Total &#8377; '+ result['sub_total']);
                        tab_pane.find('.sub_total').val(result['sub_total']);
                        tab_pane.find('.dis_total').val(result['disc_total']);
                        tab_pane.find('.dis_totaldetail').val(result['disc_total']);

                        tab_pane.find('.net_total').val(result['net_total']);

                        tab_pane.find('.cgst_per').val(result['cgst_per']);
                        tab_pane.find('.sgst_per').val(result['sgst_per']);
                        tab_pane.find('.cash_payment').val(result['cash_payment']);
                        tab_pane.find('.card_payment').val(result['card_payment']);
                        tab_pane.find('.upi_payment').val(result['upi_payment']);
                        tab_pane.find('.net_banking').val(result['net_banking']);

                        tab_pane.find('.customer_id').val(result.customer_id);
                        tab_pane.find('.customer_name').val(result.customer_name);
                        tab_pane.find('.mobile_no').val(result.contact_no);
                        tab_pane.find('.mobile_no').attr("readonly", true);
                        tab_pane.find('.customer_name').attr("readonly", true);
                        tab_pane.find('.placeorder_kitchen').hide();
                        tab_pane.find('.submit_order').hide();
                        
                        tab_pane.find('.total-section').hide();
                        tab_pane.find('.payment-section').show();
                        
						if(result['is_invoiced']==0)
						{
                            tab_pane.find('.td-payment').hide();
                            tab_pane.find('.td-totaldetails').show();

                            tab_pane.find('.placeorder_kitchen_for_view').show();
                            tab_pane.find('.placeorder_kitchen_print').show();
                            tab_pane.find('.placeorder_sendon_whatsapp').show();
                            tab_pane.find('.submit_order').hide();
                        }
						else
						{
                            tab_pane.find('.td-payment').show();
                            tab_pane.find('.td-totaldetails').show();
                            tab_pane.find('.submit_order').show();
                            tab_pane.find('.placeorder_kitchen_for_view').hide();

                            tab_pane.find('.placeorder_kitchen_print').show();
                            tab_pane.find('.placeorder_sendon_whatsapp').show();

                            tab_pane.find('.btn-qty-minus').hide();
                            tab_pane.find('.btn-qty-plus').hide();
                            tab_pane.find('.quantity').attr('disabled','');
                            tab_pane.find('.select-item-row').hide();

                            tab_pane.find('.dis_total_percentage').attr("readonly", true);
                            tab_pane.find('.dis_total').attr("readonly", true);
                            tab_pane.find('.cgst_per').attr("readonly", true);
                            tab_pane.find('.sgst_per').attr("readonly", true);
                        }
						
                        if(result['invoice'])
						{
                            if(result['invoice'].length!=0)
							{
                                var invoice_details=result['invoice'];
                                var invoice_status=invoice_details['status'];
								
                                if(invoice_status=="Paid")
								{
                                    tab_pane.find('.submit_order').attr('disabled','');
                                    tab_pane.find('.cash_payment').val(invoice_details['cash_payment']).attr('readonly',true);
                                    tab_pane.find('.card_payment').val(invoice_details['card_payment']).attr('readonly',true);
                                    tab_pane.find('.upi_payment').val(invoice_details['upi_payment']).attr('readonly',true);
                                    tab_pane.find('.net_banking').val(invoice_details['net_banking']).attr('readonly',true);
                                }
                            }
                        }

                        setTimeout(function(){
                            $('.tab-content .tab-pane').removeClass('active');
                            $('.nav-panel-tabs li').find('a').removeClass('active');
                            $('.nav-panel-tabs li:first').find('a').trigger('click');
                        }, 100);
                    }
                }

            }
        });
    },

    loadItemTable:function(response,tab_pan)
	{
		debugger;
        //console.log(response);
        tab_pan.find('.showaddeditems').show();
        tab_pan.find('.showaddeditems').html("");
		
        if(response)
		{
            var html ='';
			
            for (i in response) 
			{
                html += '<tr>\
                    <td style="width:35%">';
                    if (response[i].recipe_type == 'nonveg') 
					{
                        html +='<img src="'+Takeorders.base_url+'assets/web/images/nv.png" height="10px" width="10px" style="margin-right:10px;">';
                    }
                    else if (response[i].recipe_type == 'veg')
					{
                        html +='<img src="'+Takeorders.base_url+'assets/web/images/vg.png" height="10px" width="10px" style="margin-right:10px;">';
					}
					else
					{
                        html +='';
                    }
                    html +=response[i].recipe_name+'</td>\
                    <td style="width:30%">'+response[i].special_notes+'</td>\
                    <td style="width:15%">\
                        <div class="input-group input-indec">\
                            <span class="input-group-btn">\
                                <button type="button" class="quantity-left-minus btn btn-light btn-number btn-qty-minus" data-order_item-id="'+response[i].id+'" data-order-id="'+response[i].order_id+'" data-id="'+response[i].recipe_id+'" data-price="'+response[i].price+'" recipe-type="'+response[i].recipe_type+'" recipe-name="'+response[i].recipe_name+'" data-type="minus" data-field="">\
                                    <i class="fas fa-minus"></i>\
                                </button>\
                            </span>\
                            <input type="text" name="quantity" min="0" class="form-control input-number text-center quantity" data-order_item-id="'+response[i].id+'" data-order-id="'+response[i].order_id+'" data-id="'+response[i].recipe_id+'"  value="'+response[i].qty+'" style="width:1px;">\
                            <span class="input-group-btn">\
                                <button type="button" class="quantity-right-plus btn btn-light btn-number btn-qty-plus" data-order_item-id="'+response[i].id+'" data-order-id="'+response[i].order_id+'" data-id="'+response[i].recipe_id+'" data-price="'+response[i].price+'" recipe-type="'+response[i].recipe_type+'" recipe-name="'+response[i].recipe_name+'" data-type="plus" data-field="">\
                                    <i class="fas fa-plus"></i>\
                                </button>\
                            </span>\
                        </div>\
                    </td>\
                    <td style="width:10%">&#8377; '+response[i].price+'</td>\
                    <td style="width:10%" class="font-weight-bold num-font text-right">&#8377; '+response[i].sub_total+'</td>\
                </tr>';
            }
           tab_pan.find('.showaddeditems').html(html);
        }
       
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
                    window.location.href=Takeorders.base_url+'restaurant/new_order';
                    /*window.location.href=Orders.base_url+"restaurant/printbill/"+invoice_id;*/
                }
            });
    },

    displaysucessconfirm:function(msg,orderid)
    {
        //alert(orderid);
        var a = false;
        
        return swal({
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
                // if(isconfirm){

                //     window.location.href=Orders.base_url+"restaurant/printbillkot/"+orderid;
                //     //window.location.href=Takeorders.base_url+'restaurant/new_order';
                //     /*window.location.href=Orders.base_url+"restaurant/printbill/"+invoice_id;*/
                // }
                a = isconfirm;
                return a;
            });
            
    },


	isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
},
};
