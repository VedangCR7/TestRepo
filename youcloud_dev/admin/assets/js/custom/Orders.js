var Orders ={
	base_url:null,
    uncheck_ids:new Array(),
    order_status:null,
	init:function() {
		this.bind_events();
		var data={
			per_page : 15,
			page:$('.btn-current-pageno').attr('curr-page'),
			status:$('.select-order-status').val(),
            order_date:$('.search-order-date').val()
		}
		this.listTableOrders(data);
		this.loadMenus();
	},

	bind_events :function() 
	{
		var self=this;
        
		$('.tbody-tablewiseorder-list').on('click','.btn-view-tableorder',function(e)
		{
			var table_order_id=$(this).attr('data-id');
            Orders.onViewTableOrder(table_order_id);
        });
        
		$('.a-filter-order').on('click',function(){
            $('.table-responsive').hide();
            $('.table-single-orders').show();
            $('.btn-tablewise-orders').show();
			$('.select-order-status').val($(this).attr('status'))
           /* $('.order-status-div').show();*/
            $('.div-search-input').removeClass('col-md-7').addClass('col-md-3');
            Orders.order_status=$(this).attr('status');
            $('#image-loader').show();
            var data={
                per_page:$(this).attr('data-per'),
                page:$('.btn-current-pageno').attr('curr-page'),
                status:$('.select-order-status').val(),
                order_date:$('.search-order-date').val()
			}
			if($('.search-order-date').val() != '')
			{
				Orders.listOrders(data);
			}
			else
			{
				Orders.listOrders1(data);
			}
        });

         $('.btn-tablewise-orders').on('click',function(){
            $(this).hide();
            $('.table-responsive').hide();
            $('.table-tablewise-orders').show();
            $('.btn-single-orders').show();
            
            $('.order-status-div').hide();
            $('.div-search-input').addClass('col-md-7').removeClass('col-md-3');

            var data={
                per_page : 15,
                page:$('.btn-current-pageno').attr('curr-page'),
                status:$('.select-order-status').val(),
                order_date:$('.search-order-date').val()
            }
			if($('.search-order-date').val() != "")
			{
            	Orders.listTableOrders(data);
			}
			else{
				Orders.listTableOrders1(data);
			}
        });
		
		$('.select-order-status').on('change',function()
		{
			debugger;
			var data={
				per_page:$('.dropdown-toggle').attr('selected-per-page'),
				page:$('.btn-current-pageno').attr('curr-page'),
				status:$('.select-order-status').val(),
				order_date:$('.search-order-date').val()
			}
			if($('.search-order-date').val() != '')
			{
				Orders.listOrders(data);
			}
			else
			{
				Orders.listOrders1(data);
			}
		});
		
        $('.search-order-date').on('change',function()
		{
			debugger;
            if($('.table-single-orders').is(':visible'))
			{
                var data={
                    per_page:$('.dropdown-toggle').attr('selected-per-page'),
                    page:$('.btn-current-pageno').attr('curr-page'),
                    status:Orders.order_status,
                    order_date:$('.search-order-date').val()
                }
                if($('.search-order-date').val() != '')
			{
				Orders.listOrders(data);
			}
			else
			{
				Orders.listOrders1(data);
			}
            }
			else
			{
                var data={
                    per_page:$('.dropdown-toggle').attr('selected-per-page'),
                    page:$('.btn-current-pageno').attr('curr-page'),
                    status:$('.select-order-status').val(),
                    order_date:$('.search-order-date').val()
                }
                if($('.search-order-date').val() != "")
			{
            	Orders.listTableOrders(data);
			}
			else{
				Orders.listTableOrders1(data);
			}
            }
        });
		
		$('#searchRecipeInput').on('keyup',function()
		{
			if($(this).val()=="")
			{
                if($('.table-single-orders').is(':visible'))
				{
                    var data={
                        per_page:$('.dropdown-toggle').attr('selected-per-page'),
                        page:$('.btn-current-pageno').attr('curr-page'),
                        status:Orders.order_status,
                        order_date:$('.search-order-date').val()
                    }
					if($('.search-order-date').val() != ''){
                    Orders.listOrders(data,'fromsearch');}else{
						Orders.listOrders1(data,'fromsearch');
					}
                }
				else
				{
    				var data={
    					per_page:$('.dropdown-toggle').attr('selected-per-page'),
    					page:$('.btn-current-pageno').attr('curr-page'),
                        order_date:$('.search-order-date').val(),
    					status:$('.select-order-status').val(),
    				}
    				/*Orders.listOrders(data,'fromsearch');*/
					if($('.search-order-date').val() != ''){
                    Orders.listTableOrders(data,'fromsearch');}else{
						Orders.listTableOrders1(data,'fromsearch');	
					}
                }
			}
			else
			{
				if($(this).val().length>=3)
				{
					var dt = $('.search-order-date').val();
					
                    if($('.table-single-orders').is(':visible'))
					{
                        var data={
                            per_page:$('.dropdown-toggle').attr('selected-per-page'),
                            page:$('.btn-current-pageno').attr('curr-page'),
                            status:Orders.order_status,
                            searchkey:$('#searchRecipeInput').val(),
                            order_date:dt
                        }
                        if($('.search-order-date').val() != '')
			{
				Orders.listOrders(data);
			}
			else
			{
				Orders.listOrders1(data);
			}
                    }
					else
					{
    					var data={
    						per_page:'all',
    						page:$('.btn-current-pageno').attr('curr-page'),
    						status:$('.select-order-status').val(),
    						searchkey:$('#searchRecipeInput').val(),
                            order_date:dt
    					}
    					/*Orders.listOrders(data,'fromsearch');*/
						if($('.search-order-date').val() != ''){
                        Orders.listTableOrders(data,'fromsearch');}else{
							Orders.listTableOrders1(data,'fromsearch');	
						}
                    }
				}
			}
		});
		
		$('.a-recipe-perpage').on('click',function(){
			$(this).closest('.btn-group').find('button').attr('selected-per-page',$(this).attr('data-per'));
			if($(this).attr('data-per')=="all")
				$(this).closest('.btn-group').find('button').html($(this).html()+' items');
			else
				$(this).closest('.btn-group').find('button').html($(this).html()+' items per page');
			var data={
				per_page:$(this).attr('data-per'),
				page:$('.btn-current-pageno').attr('curr-page'),
				status:$('.select-order-status').val(),
                order_date:$('.search-order-date').val()
			}
			if($('.search-order-date').val() != '')
			{
				Orders.listOrders(data);
			}
			else
			{
				Orders.listOrders1(data);
			}
		});
		$('.btn-prev').on('click',function(){
			var data={
				per_page:$('.dropdown-toggle').attr('selected-per-page'),
				page:$(this).attr('page-no'),
				status:$('.select-order-status').val(),
                order_date:$('.search-order-date').val()
			}
			if($('.search-order-date').val() != '')
			{
				Orders.listOrders(data);
			}
			else
			{
				Orders.listOrders1(data);
			}
		});
		
		$('.btn-next').on('click',function(){
			var data={
				per_page:$('.dropdown-toggle').attr('selected-per-page'),
				page:$(this).attr('page-no'),
				status:$('.select-order-status').val(),
                order_date:$('.search-order-date').val()
			}
			/* if($('.search-order-date').val() != '')
			{
				Orders.listOrders(data);
			}
			else
			{
				Orders.listOrders1(data);
			} */
			if($('.search-order-date').val() != "")
			{
            	Orders.listTableOrders(data);
			}
			else{
				Orders.listTableOrders1(data);
			}
		});
		
		$('table').on('click','.btn-view-order',function()
		{
			debugger;
			//$('#order-modal').modal('show');
			var order_id=$(this).attr('data-id');
            var table_order_id=$(this).attr('table-order-id');
			var table_id=$(this).attr('table-id');
            window.location.href = Orders.base_url+"restaurant/onlineorder/"+table_id+"/"+table_order_id+"/tableorders";
			//Orders.onViewOrder(order_id,table_order_id);
		});	
		
		$('table').on('click','.btn_view_order',function()
		{
			debugger
			//$('#order-modal').modal('show');
			var order_id=$(this).attr('data-id');
            var table_order_id=$(this).attr('table-order-id');
            var is_invoiced=$(this).attr('is-invoiced');
            var invoice_id=$(this).attr('invoice-id');
            var order_type=$(this).attr('order-type');
			var table_id = $(this).attr('table-id');		
			if(order_type=='Billing')
			{
				if(is_invoiced=='1')
				{
					window.location.href = Orders.base_url+"restaurant/tablerecipe/"+table_id+"/"+table_order_id+"/"+invoice_id;
				}
				else
				{
					window.location.href = Orders.base_url+"restaurant/tablerecipe/"+table_id+"/"+table_order_id;
				}
			}
			else
			{
				if(is_invoiced=='1')
				{
					window.location.href = Orders.base_url+"restaurant/onlineorder/"+table_id+"/"+table_order_id+"/"+invoice_id+'/tableorders';
				}
				else
				{
					window.location.href = Orders.base_url+"restaurant/onlineorder/"+table_id+"/"+table_order_id;
				}
			}
			
			//Orders.onViewOrder(order_id,table_order_id);
		});
		
		$('table').on('click','.btn-edit-order',this.onEditOrder);
		/*$('.btn-change-status').on('click',this.OnChangeStatus);xyz*/

		$('#edit-order-modal').on('click','#btn-add-item',this.onAddProduct);
        $('.tbody-items-table').on('click','.delete-product',this.deleteProduct);
        $('.tbody-items-table').on('click','.edit-product',this.editProduct);
        $('#form-edit-order').on('submit',this.onSubmitOrder);

        $('.input-checkall-orders').on('click',function(){
            if($(this).is(':checked')){
                $('.input-checksingle-orders:not(:disabled)').prop('checked',true);
            }else{
                $('.input-checksingle-orders:not(:disabled)').prop('checked',false);
                $('.input-checksingle-orders:not(:disabled)').each(function(){
                    if(!$(this).is(':checked')){
                        var id=$(this).val();
                        Orders.uncheck_ids.push(id);
                    }
                });
            }

        });
        $('.tbody-tableorder-list').on('click','.input-checksingle-orders',this.onClickInput);
	    $('.btn-create-invoice').on('click',this.onCreateInvoice);
    },
    onCreateInvoice:function(){
        var self=this;
        var ids=new Array();
        $('.input-checksingle-orders').each(function(){
            if($(this).is(':checked')){
                var id=$(this).val();
                ids.push(id);
            }
        });
        if(ids.length==0 && Orders.uncheck_ids.length==0){
            Orders.displaywarning("Please select at least one item.");
            return false;
        }
        if(ids.length==0){
            var not_all_ids="";
        }else{
            var not_all_ids="yes";
        }
        var table_order_id=$('.input-tableorder-id').val();
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
        },function () {
             $('#image-loader').show();
            var formData = {
                ids:ids,
                uncheck_ids:Orders.uncheck_ids,
                not_all_ids:not_all_ids,
                table_order_id:table_order_id
            };
            $.ajax({
                url: Orders.base_url+"restaurant/create_invoice",
                type:'POST',
                data:formData ,
                success: function(result){
                    $('#image-loader').hide();
                   if (result.status) {
                        Orders.onViewTableOrder(table_order_id);
                        var data={
                            per_page : $('.dropdown-toggle').attr('selected-per-page'),
                            page:$('.btn-current-pageno').attr('curr-page'),
                            status:$('.select-order-status').val(),
                            order_date:$('.search-order-date').val()
                        }
                        if($('.search-order-date').val() != "")
			{
            	Orders.listTableOrders(data);
			}
			else{
				Orders.listTableOrders1(data);
			}
                        var invoice_id=result.invoice_id;
                       
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
                        },function (isconfirm) {
                            if(isconfirm){
                                window.open(Orders.base_url+"restaurant/printbill/"+invoice_id,'_blank');
                                /*window.location.href=Orders.base_url+"restaurant/printbill/"+invoice_id;*/
                            }
                        });
                        /* $('.input-checkall-orders').prop('checked',false);*/
                       /* Orders.displaysucess("Successfully Saved.");*/
                   }
                   else{
                        Orders.displaywarning("Something went wrong please try again");
                   }
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
    onClickInput:function(){
        if(!$(this).is(':checked')){
            var id=$(this).val();
            Orders.uncheck_ids.push(id);
        }
    },
    onViewTableOrder:function(table_order_id){
        $('#table-order-modal').modal('show');
        $('.input-checkall-orders').prop('checked',false);
        $('.input-checksingle-orders').prop('checked',false);
       /* var table_order_id=$(this).attr('data-id');*/
        var data={
            table_order_id:table_order_id
        }
        $('#image-loader').show();
        $('.input-tableorder-id').val(table_order_id);
        $.ajax({
            url: Orders.base_url+"restaurant/get_tableorder_details/",
            type:'POST',
            dataType: 'json',
            data: data,
            success: function(response){
                $('#table-order-modal').find('.span_tableorder_no').html(response.table_orderno);
                $('#table-order-modal').find('.span_table_orderdate').html(response.order_date);
                $('#table-order-modal').find('.span_tableno').html(response.table_no);
                var orders=response.orders;
                var html="";
                for (i in orders) {
                    var status_color="";
                    if(orders[i].status=="New"){
                        status_color="badge-warning";
                    }
                    else if(orders[i].status=="Confirmed"){
                        status_color="badge-black";
                        
                    }
                    else if(orders[i].status=="Blocked"){
                        status_color="badge-orange";
                    }
                    else if(orders[i].status=="Food Served"){
                        status_color="badge-indigo";
                    }
                    else if(orders[i].status=="Assigned To Kitchen"){
                        status_color="badge-info";
                    }
                    else if(orders[i].status=="Canceled"){
                        status_color="badge-danger";
                    }
                    else if(orders[i].status=="Completed"){
                        status_color="badge-success";
                    }
                    var arr = ["Food Served","Completed"];
                    var in_array=jQuery.inArray(orders[i].status, arr);
                    html+='<tr>';
                        html+='<td>'+orders[i].order_no+'</td>\
                        <td>'+orders[i].customer_name+'</td>\
                        <td><span class="badge '+status_color+'">'+orders[i].status+'</span></td>\
                        <td>'+orders[i].order_by_name+'</td>\
                        <td>'+orders[i].net_total+'</td>';
                        if(orders[i].is_invoiced==1)
                            html+='<td>Yes</td>';
                        else
                            html+='<td>No</td>';
                        html+='<td>';
                            html+='<a href="javascript:;" data-id="'+orders[i].id+'" table-order-id="'+table_order_id+'" table-id="'+orders[i].table_id+'" class="btn btn-sm btn-success btn-view-order mr-1"><i class="fas fa-eye"></i></a>';
                           /* if(orders[i].status=="New" || orders[i].status=="Confirmed"){
                                html+='<a href="javascript:;" data-id="'+orders[i].id+'" table-order-id="'+table_order_id+'" class="btn btn-sm btn-info btn-edit-order"><i class="fas fa-edit"></i></a>';
                            }*/
                        html+='</td>';
                    html+='</tr>';
                }
                $('.tbody-tableorder-list').html(html);
                $('#image-loader').hide();
            }
        });
    },
	loadMenus:function(){
        var $input = $(".input-item-name");
        $.get(Orders.base_url+"restaurant/list_recipes", function(data){
            $input.typeahead({ 
                source:data,autoSelect: true,
                afterSelect:function(item){
                    $('.input-item-id').val(item.id);
                    $('#input-price').val(item.price);
                    $('#input-qty').val('1');
                    /*$('#input-discount').val('0');*/

                }
            });
        },'json');
    },
    onSubmitOrder:function(){

        if($('.tbody-items-table tr').length==0){
            Orders.displaywarning("Please add at least one item");
            return false;
        }
        if($('.input-customer-name').val()=="")
        {
        	Orders.displaywarning("Please fill the customer name.");
            return false;
        }
		if($('.input-customer-id').val()=="")
		{
			Orders.displaywarning("Please fill the customer name.");
            return false;
		}
		if($('.input-customer-contact').val()=="")
		{
			Orders.displaywarning("Please fill the customer contact.");
            return false;

		}
        $('#submit-order').attr('disabled','');
        var self=this;
        var $form_data = new FormData();
        $('#form-edit-order').serializeArray().forEach(function(field){
            $form_data.append(field.name, field.value);
        });

        var items=[];
        $('.tbody-items-table tr').each(function(){
            var product={
                recipe_id:$(this).find('.tdproduct').attr('product-id'),
                qty:$(this).find('.tdqty').html(),
                price:$(this).find('.tdprice').attr('price'),
                total:parseFloat($(this).find('.tdqty').html()*$(this).find('.tdprice').attr('price')).toFixed(2),
                disc:$(this).find('.tddiscountper').html(),
                disc_amt:$(this).find('.tddiscountper').attr('discount-amt'),
                sub_total:$(this).find('.tdamount').html()
            }
            items.push(product);
        });
        $form_data.append('name',$('#form-edit-order [name="customer_name"]').val());

        $form_data.append('items',JSON.stringify(items));
        $('#image-loader').show();
        $.ajax({
            url: Orders.base_url+"restaurant/update_order",
            type:'POST',
            data: $form_data,
            processData:false,
            contentType:false,
            cache:false,
            success: function(result){
                if (result.status) { 
                    var data={
						per_page:$(this).attr('data-per'),
						page:$('.btn-current-pageno').attr('curr-page'),
						status:$('.select-order-status').val(),
                        order_date:$('.search-order-date').val()
					}
					if($('.search-order-date').val() != '')
			{
				Orders.listOrders(data);
			}
			else
			{
				Orders.listOrders1(data);
			}
                    Orders.displaysucess("Record Saved Successfully");
                    $('#edit-order-modal').modal("hide");
                } 
                else {
                     if(result.msg){
                        Orders.displaywarning(result.msg);

                    }
                    else
                        Orders.displaywarning("Something went wrong please try again");

                }
                $('#image-loader').hide();
                $('#submit-order').removeAttr('disabled');
            }
        });

        return false;

    },
	onAddProduct:function(){
        if($("#input-item-name").val()==""){
            Orders.displaywarning("Please Add Item");
            $("#input-item-name").focus();
            return false;
        }
        if($("#input-qty").val()==""){
            Orders.displaywarning("Please Add Qty");
            $("#input-qty").focus();
            return false;
        }
        if($("#input-qty").val()==0){
            Orders.displaywarning("Please add quantity greater than zero");
            $("#input-qty").focus();
            return false;
        }
        if($("#input-price").val()==""){
            Orders.displaywarning("Please Add Price");
            $("#input-price").focus();
            return false;
        }

        var sub_total=parseFloat($("#input-qty").val() * $("#input-price").val());
        var discount_amount=sub_total*parseFloat($('#input-discount').val())/100;
        amount=sub_total-discount_amount;

     	var save_data={
        	'id':$('.input-orderitemid').val(),
        	'order_id':$('#form-edit-order [name="id"]').val(),
			'recipe_id':$("#input-item-id").val(),
			'qty':$("#input-qty").val(),
			'price':$("#input-price").val(),
			'total':sub_total,
			'disc':$("#input-discount").val(),
			'disc_amt':discount_amount,
			'sub_total':amount
        }
        Orders.saveItem(save_data);
    },
    saveItem:function(data){
    	$('#image-loader').show();
    	$.ajax({
			url: Orders.base_url+"restaurant/save_order_item",
			type:'POST',
			dataType: 'json',
			data: data,
			success: function(response){
				Orders.loadItemTable(response.result,$('#table-order-id').val());
				Orders.calculateTotal();
				Orders.clearItemForm();
                var data={
                    per_page:$(this).attr('data-per'),
                    page:$('.btn-current-pageno').attr('curr-page'),
                    status:$('.select-order-status').val(),
                    order_date:$('.search-order-date').val()
                }
                if($('.search-order-date').val() != '')
			{
				Orders.listOrders(data);
			}
			else
			{
				Orders.listOrders1(data);
			}
                Orders.onViewTableOrder($('#table-order-id').val());
				$('#image-loader').hide();
			}
		});
    },
    calculateTotal:function(){
    	var gross_amount=0;
        var tax_amount=0;
        var net_amount=0;
        var discount_amt=0;
        var shipping=0;
        $('.tbody-items-table tr').each(function(i){
             gross_amount=gross_amount+parseFloat($(this).find('.tdqty').html()*$(this).find('.tdprice').attr('price'));
             net_amount=net_amount+parseFloat($(this).find('.tdamount').html());
             discount_amt=discount_amt+parseFloat($(this).find('.tddiscountper').attr('discount-amt'));

        });
        $('.span_gross_amount').html(gross_amount.toFixed(2));
        $('.span_discount_amount').html(discount_amt.toFixed(2));
        $('.span_net_amount').html(net_amount.toFixed(2));

        $('.input_gross_amount').val(gross_amount.toFixed(2));
		$('.input_discount_amount').val(discount_amt.toFixed(2));
        $('.input_net_amount').val(net_amount.toFixed(2));
    },
    editProduct:function(){

        var curr_row=$(this).closest('.tbody-items-table tr');
        var sr_no=curr_row.find('.tdsr').html();
        $('.input-row').val(sr_no);
        $('.input-orderitemid').val(curr_row.find('.tdsr').attr('data-id'));
        $("#input-item-id").val(curr_row.find('.td-product'+sr_no).attr('product-id'));
        $("#input-item-name").val(curr_row.find('.td-product'+sr_no).html());
        $("#input-qty").val(curr_row.find('.td-qty'+sr_no).html());
        $("#input-price").val(curr_row.find('.td-price'+sr_no).html());
        $("#input-discount").val(curr_row.find('.td-discount-per'+sr_no).html());
        $('#btn-add-item i').removeClass('fa-plus').addClass('fa-pen');
   },
   deleteProduct:function(){
        if($('.tbody-items-table tr').length==1){
            Orders.displaywarning("At least one item required for order.");
            return false;
        }
   		$('#image-loader').show();
   		$.ajax({
			url: Orders.base_url+"restaurant/delete_order_item",
			type:'POST',
			dataType: 'json',
			data: {id:$(this).attr('data-id'),order_id:$(this).attr('order-id')},
			success: function(response){
				$('#image-loader').hide();
				Orders.loadItemTable(response.result,$('#table-order-id').val());
				Orders.calculateTotal();
                Orders.onViewTableOrder($('#table-order-id').val());
			}
		});
   },

   clearItemForm:function(){
        $("#input-price").val("");
        $("#input-qty").val("");
        $('.input-orderitemid').val("");
        $("#input-item-name").val("");
        $("#input-item-id").val("");
        $('.input-row').val("");
        $('#input-discount').val("");
        $('#btn-add-item i').removeClass('fa-pen').addClass('fa-plus');
   },
	onEditOrder:function(){
		$('#edit-order-modal').modal('show');
        Orders.clearItemForm();
		var order_id=$(this).attr('data-id');
        var table_order_id=$(this).attr('table-order-id');
		var data={
			order_id:order_id
		}
		$('#image-loader').show();
		$.ajax({
			url: Orders.base_url+"restaurant/get_order_details/",
			type:'POST',
			dataType: 'json',
			data: data,
			success: function(result){
				for (var i  in result) {
                   $('#form-edit-order [name='+i+']').val(result[i]);
                }
                Orders.loadItemTable(result['items'],table_order_id);

                $('.span_gross_amount').html(result['sub_total']);
                $('.span_discount_amount').html(result['disc_total']);
                $('.span_net_amount').html(result['net_total']);

                $('.input_gross_amount').val(result['sub_total']);
				$('.input_discount_amount').val(result['disc_total']);
        		$('.input_net_amount').val(result['net_total']);


        		$('#image-loader').hide();
			}
		});
	},
	loadItemTable:function(items,table_order_id){
        if(items){
            $('#table-items').show();
            $('.tbody-items-table').html("");
            for (i in items) {
                var j=parseInt(i)+1;
                $('.tbody-items-table').append('<tr>\
                    <td class="tdsr" data-id="'+items[i].id+'">'+j+'</td>\
                    <td class="tdproduct td-product'+j+'" product-id="'+items[i].recipe_id+'">'+items[i].recipe_name+'</td>\
                    <td class="tdqty td-qty'+j+'">'+items[i].qty+'</td>\
                    <td class="tdprice td-price'+j+'" price='+items[i].price+'>'+items[i].price+'</td>\
                    <td class="tddiscountper td-discount-per'+j+'" discount-amt="'+items[i].disc_amt+'">'+items[i].disc+'</td>\
                    <td class="tdamount td-amount'+j+'">'+items[i].sub_total+'</td>\
                    <td width="60">\
                        <a class="delete-product" data-id="'+items[i].id+'" order-id="'+items[i].order_id+'" table-order-id="'+table_order_id+'" style="color: #ac2925;padding: 6px;font-size: 16px;" href="javascript:;" role="button"> <i class="fa fa-trash"></i></a>\
                        <a class="edit-product" data-id="'+items[i].id+'"  order-id="'+items[i].order_id+'" table-order-id="'+table_order_id+'" style="color: #5cb85c;padding: 0px;font-size: 16px;" href="javascript:;" role="button"> <i class="fa fa-edit"></i></a>\
                    </td>\
                </tr>\
                ');
            }
        }
    },
	onViewOrder:function(order_id,table_order_id){
		var data={
			order_id:order_id
		}
        if(table_order_id!=""){
            $('.btn-change-status').attr('table-order-id',table_order_id);
        }
		$('.btn-change-status').hide();
		$('#image-loader').show();
		$.ajax({
			url: Orders.base_url+"restaurant/get_order_details/",
			type:'POST',
			dataType: 'json',
			data: data,
			success: function(response){
				for(i in response){
					$('.row-order-details .span_'+i).html(response[i]);
				}
				$('.btn-change-status').hide();
				$('.span_status').removeClass('badge-black');
				$('.span_status').removeClass('badge-info');
				$('.span_status').removeClass('badge-danger');
				$('.span_status').removeClass('badge-warning');
				$('.span_status').removeClass('badge-success');
                $('.span_status').removeClass('badge-orange');
                $('.span_status').removeClass('badge-indigo');
				if(response['status']=="New"){
					status_color="badge-warning";

					$('.btn-accept').show();
					$('.btn-cancel').show();
                    $('.btn-block-customer').show();
				}
				else if(response['status']=="Confirmed"){
					status_color="badge-black";
					$('.btn-assign').show();
				}
                else if(response['status']=="Blocked"){
                    status_color="badge-orange";
                }
				else if(response['status']=="Assigned To Kitchen"){
					status_color="badge-info";
					$('.btn-served').show();
				}
                else if(response['status']=="Food Served"){
                    status_color="badge-indigo";
                    $('.btn-complete').show();
                }
				else if(response['status']=="Canceled"){
					status_color="badge-danger";
				}
				else if(response['status']=="Completed"){
					status_color="badge-success";
				}
				$('.input-order-id').val(response['id']);
				$('.span_status').addClass(status_color);
				var items=response['items'];
				var html="";
				var j=1;
				for (i in items) {
					html+='<tr>\
						<td>'+j+'</td>\
						<td>'+items[i].recipe_name+'</td>\
						<td class="text-right">'+items[i].price+'</td>\
						<td class="text-right">'+items[i].qty+'</td>\
						<td  class="text-right">'+items[i].total+'</td>\
						<td  class="text-right">'+items[i].disc_amt+'</td>\
						<td  class="text-right">'+items[i].sub_total+'</td>';
					html+='</tr>';
					j=j+1;
				}
				$('.tbody-order-items').html(html);
				$('#image-loader').hide();
			}
		});
	},
	OnChangeStatus:function(){
        var self=this;
        var status=$(this).attr('order-status');
        var order_id=$('.input-order-id').val();
        var data={
        	order_id:order_id,
        	status:status
        }
        var table_order_id=$(this).attr('table-order-id');
        if(status=="Completed")
        	display_text="Complete";
        else if(status=="Food Served")
            display_text="Served";
        else
        	display_text=status.replace("ed", "");


        if(status=="Assigned To Kitchen"){
        	var textmsg="You want to Assign this order To Kitchen";
        }
        if(status=="Food Served"){
            var textmsg="You want to Serve the Food for this order";
        }
        else if(status=="Blocked"){
            var textmsg="You want to Block this order";
        }
        else{
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
        },function () {
        	$('#image-loader').show();
            $.ajax({
                url: Orders.base_url+"restaurant/change_order_status",
                type:'POST',
                data:data,
                success: function(result){
                   if (result.status) {
                    	Orders.onViewOrder(order_id);
                    	var data={
							per_page:$('.dropdown-toggle').attr('selected-per-page'),
							page:$('.btn-current-pageno').attr('curr-page'),
							status:$('.select-order-status').val(),
                            order_date:$('.search-order-date').val()
						}
						if($('.search-order-date').val() != '')
			{
				Orders.listOrders(data);
			}
			else
			{
				Orders.listOrders1(data);
			}
                        if(table_order_id!="")
                            Orders.onViewTableOrder(table_order_id);
                   }
                   else{
                        Orders.displaywarning("Something went wrong please try again");
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
    listTableOrders:function(data,fromevent)
	{
		debugger;
        $('#image-loader').show();
        $.ajax({
            url: Orders.base_url+"restaurant/list_tablwise_orders/",
            type:'POST',
            dataType: 'json',
            data: data,
            success: function(response)
			{
                var orders=response.orders;
				console.log(orders);
                let html="";
				
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
                    else if(orders[i].status=="Food Served"){
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
					
					var orderby = orders[i].order_by;
					var order_by="";
													
					if(orderby > 0)
					{
						if(orders[i].order_type=="Billing")
						{
							order_by='Counter';
						}
						else if(orders[i].order_type=="Takeaway")
						{
							order_by='Counter';
						}
						else
						{
							order_by= orders[i].order_by_name;
						}
					}
					else
					{
						if(orders[i].order_type=="Billing")
						{
							order_by='Counter';
						}
						else
						{
							order_by='Customer';
						}
					}
					
					var order_date = orders[i].created_at;
					var completed_date = orders[i].completed_at;
					
					if(completed_date!="")
					{
						var startDate = new Date(order_date);
						var endDate   = new Date(completed_date);
						var seconds = (endDate.getTime() - startDate.getTime()) / 1000;
						
						var d = Number(seconds);
						
						if(seconds < 60)
						{
							var s = Math.floor(d % 3600 % 60);
							var time_ago = s > 0 ? s + (s == 1 ? " second" : " seconds") : "";
						}
						else if(seconds >= 60 && seconds < 3600)
						{
							var m = Math.floor(d % 3600 / 60);
							var time_ago = m > 0 ? m + (m == 1 ? " minute " : " minutes ") : "";											
						}
						else if(seconds >= 3600)
						{
							var h = Math.floor(d / 3600);
							var time_ago = h > 0 ? h + (h == 1 ? " hour " : " hours ") : "";
						}
					}
					else
					{
						var time_ago = '';
					}
					
                    html+='<tr>\
                        <td>'+orders[i].order_no+'</td>\
                        <td>'+orders[i].table_no+'</td>\
                        <td>'+orders[i].order_date+'</td>\
                        <td>'+orders[i].insert_time+'</td>\
                        <td>'+time_ago+'</td>\
                        <td><span class="badge '+status_color+'">'+orders[i].status+'</span></td>\
						<td>'+order_by+'</td>\
						<td>';
                        /* html+='<a href="javascript:;" data-id="'+orders[i].id+'" table-order-id="'+orders[i].ordID+'" class="btn btn-sm btn-success btn-view-tableorder mr-1 btn_view_order1"><i class="fas fa-eye"></i></a>'; */
						html+='<a href="javascript:;" order-type="'+orders[i].order_type+'" is-invoiced="'+orders[i].is_invoiced+'" invoice-id="'+orders[i].invoice_id+'" table-order-id="'+orders[i].id+'" data-id="'+orders[i].ordID+'" table-id="'+orders[i].table_id+'" class="btn btn-sm btn-success btn-view-tableorder1 mr-1 btn_view_order"><i class="fas fa-eye"></i></a>';
                        
						if(orders[i].invoice_ids!="" && orders[i].invoice_ids!=null && orders[i].invoice_ids!='null')
						{
                            var invoice_arr=orders[i].invoice_ids.split(",");
                            
							for(k in invoice_arr)
							{
                                html+='<a target="_blank" href="'+Orders.base_url+'restaurant/printbill/'+invoice_arr[k]+'" class="btn btn-sm mr-1 btn-info" style="color:#fff;"><i class="fa fa-print"></i></a>';
                            }
                        }
                        html+='</td>';
                    html+='</tr>';
                }
				console.log(html);
                $('.tbody-tablewiseorder-list').html(html);
                $('.span-all-orders').html(response.total_count);
                $('.span-page-html').html(response.page_total_text);
                $('.btn-current-pageno').attr('curr-page',response.page_no);
                
				if(parseInt(response.page_no)>1)
				{
                    var prev_page=parseInt(response.page_no)-1;
                    $('.btn-prev').attr('page-no',prev_page);
                    $('.btn-prev').removeAttr('disabled');
                }
				else
				{
                    $('.btn-prev').attr('disabled',true);
					$('.btn-prev').prop('disabled', true);                    
                }

                if(parseInt(response.page_no)<parseInt(response.total_pages))
				{
                    var next_page=parseInt(response.page_no)+1;
                    $('.btn-next').attr('page-no',next_page);
                    $('.btn-next').removeAttr('disabled');
                }
				else
				{
                    $('.btn-next').attr('disabled',true);
					$('.btn-next').prop('disabled', true);
                }
                $('#image-loader').hide();
            }
        });
    },

	listTableOrders1:function(data,fromevent)
	{
		debugger;
        $('#image-loader').show();
        $.ajax({
            url: Orders.base_url+"restaurant/list_tablwise_orders1/",
            type:'POST',
            dataType: 'json',
            data: data,
            success: function(response)
			{
				
                var orders=response.orders;
				console.log(orders);
                let html="";
				
                for (i in orders) 
				{
					//alert(orders[i].order_by_name);
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
                    else if(orders[i].status=="Food Served"){
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
					
					var orderby = orders[i].order_by;
					var order_by="";
													
					if(orderby > 0)
					{
						if(orders[i].order_type=="Billing")
						{
							order_by='Counter';
						}
						else if(orders[i].order_type=="Takeaway")
						{
							order_by='Counter';
						}
						else
						{
							order_by= orders[i].order_by_name;
						}
					}
					else
					{
						if(orders[i].order_type=="Billing")
						{
							order_by='Counter';
						}
						else
						{
							order_by='Customer';
						}
					}
					
					var order_date = orders[i].created_at;
					var completed_date = orders[i].completed_at;
					
					if(completed_date!="")
					{
						var startDate = new Date(order_date);
						var endDate   = new Date(completed_date);
						var seconds = (endDate.getTime() - startDate.getTime()) / 1000;
						
						var d = Number(seconds);
						
						if(seconds < 60)
						{
							var s = Math.floor(d % 3600 % 60);
							var time_ago = s > 0 ? s + (s == 1 ? " second" : " seconds") : "";
						}
						else if(seconds >= 60 && seconds < 3600)
						{
							var m = Math.floor(d % 3600 / 60);
							var time_ago = m > 0 ? m + (m == 1 ? " minute " : " minutes ") : "";											
						}
						else if(seconds >= 3600)
						{
							var h = Math.floor(d / 3600);
							var time_ago = h > 0 ? h + (h == 1 ? " hour " : " hours ") : "";
						}
					}
					else
					{
						var time_ago = '';
					}
					
                    html+='<tr>\
                        <td>'+orders[i].order_no+'</td>\
                        <td>'+orders[i].table_no+'</td>\
                        <td>'+orders[i].order_date+'</td>\
                        <td>'+orders[i].insert_time+'</td>\
                        <td>'+time_ago+'</td>\
                        <td><span class="badge '+status_color+'">'+orders[i].status+'</span></td>\
						<td>'+order_by+'</td>\
						<td>';
                        /* html+='<a href="javascript:;" data-id="'+orders[i].id+'" table-order-id="'+orders[i].ordID+'" class="btn btn-sm btn-success btn-view-tableorder mr-1 btn_view_order1"><i class="fas fa-eye"></i></a>'; */
						html+='<a href="javascript:;" order-type="'+orders[i].order_type+'" is-invoiced="'+orders[i].is_invoiced+'" invoice-id="'+orders[i].invoice_id+'" table-order-id="'+orders[i].id+'" data-id="'+orders[i].ordID+'" table-id="'+orders[i].table_id+'" class="btn btn-sm btn-success btn-view-tableorder1 mr-1 btn_view_order"><i class="fas fa-eye"></i></a>';
                        
						if(orders[i].invoice_ids!="" && orders[i].invoice_ids!=null && orders[i].invoice_ids!='null')
						{
                            var invoice_arr=orders[i].invoice_ids.split(",");
                            
							for(k in invoice_arr)
							{
                                html+='<a target="_blank" href="'+Orders.base_url+'restaurant/printbill/'+invoice_arr[k]+'" class="btn btn-sm mr-1 btn-info" style="color:#fff;"><i class="fa fa-print"></i></a>';
                            }
                        }
                        html+='</td>';
                    html+='</tr>';
                }
				console.log(html);
                $('.tbody-tablewiseorder-list').html(html);
                $('.span-all-orders').html(response.total_count);
                $('.span-page-html').html(response.page_total_text);
                $('.btn-current-pageno').attr('curr-page',response.page_no);
                
				if(parseInt(response.page_no)>1)
				{
                    var prev_page=parseInt(response.page_no)-1;
                    $('.btn-prev').attr('page-no',prev_page);
                    $('.btn-prev').removeAttr('disabled');
                }
				else
				{
                    $('.btn-prev').attr('disabled',true);
					$('.btn-prev').prop('disabled', true);                    
                }

                if(parseInt(response.page_no)<parseInt(response.total_pages))
				{
                    var next_page=parseInt(response.page_no)+1;
                    $('.btn-next').attr('page-no',next_page);
                    $('.btn-next').removeAttr('disabled');
                }
				else
				{
                    $('.btn-next').attr('disabled',true);
					$('.btn-next').prop('disabled', true);
                }
                $('#image-loader').hide();
            }
        });
    },

	listOrders:function(data,fromevent)
	{
		debugger;
		$.ajax({
			url: Orders.base_url+"restaurant/list_restaurant_orders/",
			type:'POST',
			dataType: 'json',
			data: data,
			success: function(response)
			{
				var orders=response.orders;
				console.log(orders);
				let html="";
				
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
                    else if(orders[i].status=="Food Served"){
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
					
					var orderby = orders[i].order_by;
					var order_by="";
													
					if(orderby > 0)
					{
						if(orders[i].order_type=="Billing")
						{
							order_by='Counter';
						}
						else if(orders[i].order_type=="Takeaway")
						{
							order_by='Counter';
						}
						else
						{
							order_by= orders[i].order_by_name;
						}
					}
					else
					{
						if(orders[i].order_type=="Billing")
						{
							order_by='Counter';
						}
						else
						{
							order_by='Customer';
						}
					}
					var order_date = orders[i].created_at;
					var completed_date = orders[i].completed_at;
					
					if(completed_date!="")
					{
						var startDate = new Date(order_date);
						var endDate   = new Date(completed_date);
						var seconds = (endDate.getTime() - startDate.getTime()) / 1000;
						
						var d = Number(seconds);
						
						if(seconds < 60)
						{
							var s = Math.floor(d % 3600 % 60);
							var time_ago = s > 0 ? s + (s == 1 ? " second" : " seconds") : "";
						}
						else if(seconds >= 60 && seconds < 3600)
						{
							var m = Math.floor(d % 3600 / 60);
							var time_ago = m > 0 ? m + (m == 1 ? " minute " : " minutes ") : "";											
						}
						else if(seconds >= 3600)
						{
							var h = Math.floor(d / 3600);
							var time_ago = h > 0 ? h + (h == 1 ? " hour " : " hours ") : "";
						}
					}
					else
					{
						var time_ago = '';
					}
					console.log(orders[i].id);
					html+='<tr>\
						<td>'+orders[i].order_no+'</td>\
						<td>'+orders[i].table_no+'</td>\
						<td><span class="badge '+status_color+'">'+orders[i].status+'</span></td>\
                        <td>'+order_by+'</td>\
						<td>'+orders[i].order_date+'</td>\
						<td>'+time_ago+'</td>\
						<td>'+orders[i].net_total+'</td>\
						<td>';
                        /* html+='<a href="javascript:;" data-id="'+orders[i].id+'" table-order-id="'+orders[i].ordID+'" class="btn btn-sm btn-success btn-view-tableorder mr-1 btn_view_order1"><i class="fas fa-eye"></i></a>'; */
						html+='<a href="javascript:;" order-type="'+orders[i].order_type+'" is-invoiced="'+orders[i].is_invoiced+'" invoice-id="'+orders[i].invoice_id+'" table-order-id="'+orders[i].table_orders_id+'" data-id="'+orders[i].ordID+'" table-id="'+orders[i].table_id+'" class="btn btn-sm btn-success btn-view-tableorder1 mr-1 btn_view_order"><i class="fas fa-eye"></i></a>';
                        
						if(orders[i].invoice_ids!="" && orders[i].invoice_ids!=null && orders[i].invoice_ids!='null')
						{
                            var invoice_arr=orders[i].invoice_ids.split(",");
                            
							for(k in invoice_arr)
							{
                                html+='<a target="_blank" href="'+Orders.base_url+'restaurant/printbill/'+invoice_arr[k]+'" class="btn btn-sm mr-1 btn-info" style="color:#fff;"><i class="fa fa-print"></i></a>';
                            }
                        }
                        html+='</td>';
					html+='</tr>';
				}
				//console.log(html);
				$('.tbody-order-list').html(html);
				$('.table-single-orders').show();
				$('#table-tablewise-orders').hide();
				$('.span-all-orders').html(response.total_count);
				$('.span-page-html').html(response.page_total_text);
                $('.btn-current-pageno').attr('curr-page',response.page_no);
				
				if(parseInt(response.page_no)>1)
				{
					var prev_page=parseInt(response.page_no)-1;
					$('.btn-prev').attr('page-no',prev_page);
					$('.btn-prev').removeAttr('disabled');
				}
				else
				{
					$('.btn-prev').attr('disabled',true);
					$('.btn-prev').prop('disabled', true);					
				}

				if(parseInt(response.page_no)<parseInt(response.total_pages))
				{
					var next_page=parseInt(response.page_no)+1;
					$('.btn-next').attr('page-no',next_page);
					$('.btn-next').removeAttr('disabled');
				}
				else
				{
					 $('.btn-next').attr('disabled',true);
					 $('.btn-next').prop('disabled', true);
				}

                 $('#image-loader').hide();
				/*if(fromevent=="fromsearch"){
					  var input, filter, table, tr, td, i, txtValue;
					  input = document.getElementById("searchRecipeInput");
					  filter = input.value.toUpperCase();
					  table = document.getElementById("table-recipes");
					  tr = table.getElementsByTagName("tr");
					  for (i = 0; i < tr.length; i++) {
						td = tr[i].getElementsByTagName("td")[0];
						if (td) {
						  txtValue = td.textContent || td.innerText;
						  if (txtValue.toUpperCase().indexOf(filter) > -1) {
							tr[i].style.display = "";
						  } else {
							tr[i].style.display = "none";
						  }
						}       
					  }
				}*/
			}
		});
	},

    listOrders1:function(data,fromevent)
	{
		$('.search-order-date').val('');
		debugger;
		$.ajax({
			url: Orders.base_url+"restaurant/list_restaurant_orders1/",
			type:'POST',
			dataType: 'json',
			data: data,
			success: function(response)
			{
				var orders=response.orders;
				let html="";
				
				
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
                    else if(orders[i].status=="Food Served"){
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
					
					var orderby = orders[i].order_by;
					var order_by="";
													
					if(orderby > 0)
					{
						if(orders[i].order_type=="Billing")
						{
							order_by='Counter';
						}
						else
						{
							order_by=orders[i].order_by_name;
						}
					}
					else
					{
						if(orders[i].order_type=="Billing")
						{
							order_by='Counter';
						}
						else
						{
							order_by='Customer';
						}
					}
					console.log(orders[i].id);
					html+='<tr>\
						<td>'+orders[i].order_no+'</td>\
						<td>'+orders[i].table_no+'</td>\
						<td><span class="badge '+status_color+'">'+orders[i].status+'</span></td>\
                        <td>'+order_by+'</td>\
						<td>'+orders[i].order_date+'</td>\
						<td>'+orders[i].net_total+'</td>\
						<td>';
                        /* html+='<a href="javascript:;" data-id="'+orders[i].id+'" table-order-id="'+orders[i].ordID+'" class="btn btn-sm btn-success btn-view-tableorder mr-1 btn_view_order1"><i class="fas fa-eye"></i></a>'; */
						html+='<a href="javascript:;" order-type="'+orders[i].order_type+'" is-invoiced="'+orders[i].is_invoiced+'" invoice-id="'+orders[i].invoice_id+'" table-order-id="'+orders[i].table_orders_id+'" data-id="'+orders[i].ordID+'" table-id="'+orders[i].table_id+'" class="btn btn-sm btn-success btn-view-tableorder1 mr-1 btn_view_order"><i class="fas fa-eye"></i></a>';
                        
						if(orders[i].invoice_ids!="" && orders[i].invoice_ids!=null && orders[i].invoice_ids!='null')
						{
                            var invoice_arr=orders[i].invoice_ids.split(",");
                            
							for(k in invoice_arr)
							{
                                html+='<a target="_blank" href="'+Orders.base_url+'restaurant/printbill/'+invoice_arr[k]+'" class="btn btn-sm mr-1 btn-info" style="color:#fff;"><i class="fa fa-print"></i></a>';
                            }
                        }
                        html+='</td>';
					html+='</tr>';
				}
				console.log(html);
				$('.tbody-order-list').html(html);
				$('.table-single-orders').show();
				$('#table-tablewise-orders').hide();
				$('.span-all-orders').html(response.total_count);
				$('.span-page-html').html(response.page_total_text);
                $('.btn-current-pageno').attr('curr-page',response.page_no);
				
				if(parseInt(response.page_no)>1)
				{
					var prev_page=parseInt(response.page_no)-1;
					$('.btn-prev').attr('page-no',prev_page);
					$('.btn-prev').removeAttr('disabled');
				}
				else
				{
					$('.btn-prev').attr('disabled',true);
					$('.btn-prev').prop('disabled', true);					
				}

				if(parseInt(response.page_no)<parseInt(response.total_pages))
				{
					var next_page=parseInt(response.page_no)+1;
					$('.btn-next').attr('page-no',next_page);
					$('.btn-next').removeAttr('disabled');
				}
				else
				{
					 $('.btn-next').attr('disabled',true);
					 $('.btn-next').prop('disabled', true);
				}

                 $('#image-loader').hide();
				/*if(fromevent=="fromsearch"){
					  var input, filter, table, tr, td, i, txtValue;
					  input = document.getElementById("searchRecipeInput");
					  filter = input.value.toUpperCase();
					  table = document.getElementById("table-recipes");
					  tr = table.getElementsByTagName("tr");
					  for (i = 0; i < tr.length; i++) {
						td = tr[i].getElementsByTagName("td")[0];
						if (td) {
						  txtValue = td.textContent || td.innerText;
						  if (txtValue.toUpperCase().indexOf(filter) > -1) {
							tr[i].style.display = "";
						  } else {
							tr[i].style.display = "none";
						  }
						}       
					  }
				}*/
			}
		});
	},
	displaysucess:function(msg)
	{
		swal("Success !",msg,"success");
	},

	displaywarning:function(msg)
	{
		swal("Error !",msg,"error");
	},

};