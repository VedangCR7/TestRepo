var Inventoryproductassign ={
    base_url:null,
    init:function() {
        this.bind_events();
        //this.loadMenuItems();
        this.getCart();
    },

    bind_events :function() {
        var self=this; 
        $('.add_product_cart').on('click',this.add_product_cart);
        $('#supplier_id').on('change',this.changesupplier);
        $('#show_product').on('change',this.changeproduct);
        $('#showaddeditems').on('click','.qty_minus',this.onMinusQty);
        $('#showaddeditems').on('click','.qty_plus',this.onPlusQty);
        $('#showaddeditems').on('blur','.updated_price',this.onPriceChange);
        $('.btn-add-purchase').on('click',this.add_purchase_product);
        //$('.btn-add-group').on('click',this.onSaveGroupname);
    },

    changeproduct:function(){
        //alert($(this).val());
        $('.product_qty').val($(this).find(':selected').attr('qty'));
        $('.product_name').val($(this).find(':selected').attr('name'));
    },

    changesupplier:function(){
        debugger;
        $('.product_qty').val('');
        $('.product_id').val('');
        $('.product_name').val('');
        $.ajax({
            url: Inventoryproductassign.base_url+"inventory/list_product_for_assign_kitchen?supplier_id="+$('#supplier_id').val(),
            success: function(result)
			{
                var html ='<option value="">Choose Product</option>';
                for(var i=0;i<result.length;i++){
                    var qty = parseInt(result[i].qty);
                    if(qty> 0){
                        html+='<option value="'+result[i].id+'" qty="'+qty+'" name="'+result[i].name+'">'+result[i].name+'</option>';
                    }
                }
                $('#show_product').html(html);
            }
        });
        // var $input = $('input#product_name.form-control.product_name.typeahead');
        //     console.log($input);
        //     $.get(Inventoryproductassign.base_url+"inventory/list_product_for_assign_kitchen?supplier_id="+$('#supplier_id').val(), function(data){
        //         console.log(data);
        //         $input.typeahead({ 
        //             source:data,autoSelect: true,
        //             afterSelect:function(item){
        //                 $('.product_id').val(item.id);
        //                 $('.product_qty').val(item.qty);
        //             },
        //         });
        //     },'json');
        //Inventoryproductassign.loadMenuItems();
    },

    getCart:function()
	{
		//debugger;
        $.ajax({
            url: Inventoryproductassign.base_url+"inventory/get_purchase_cart",
            type:'POST',
            data:{},
            success: function(result)
			{
                var cnt=result.count;
                if(cnt>0)
				{
                    var cart_details=result.cart_detials;
                    Inventoryproductassign.showCartData(cart_details);
                    Inventoryproductassign.clearItemForm()
                }
				else
				{

                    $('#showaddeditems').html('<tr>\
                        <td colspan="4" class="text-danger text-center" style="padding: 20px 10px;font-size: 15px;">No Item Added</td>\
                        </tr>');
                }
            }
        });
    },

    clearItemForm:function(){
        $('.input-row').val("");
    },
    onPlusQty:function(){
		//debugger;
        var input=$(this).closest('.input-group').find('.quantity');
        var qty=input.val();
		
		var purchase_qty = input.attr('data-purchase_qty');
		var recipe_name = input.attr('recipe-name');
		;
        if(parseInt(purchase_qty) > parseInt(qty))
		{
			if(qty<1000){
				var inc=parseInt(qty)+1;
				input.val(inc);
			}
			Inventoryproductassign.updateCart(input);
		}
		else
		{
			Inventoryproductassign.displaywarning("Please select assign quantity less than available quantity.");
            return false;
		}
    },

    onMinusQty:function(){
        var input=$(this).closest('.input-group').find('.quantity');
        var qty=input.val();
        if(qty>0){
            var inc=parseInt(qty)-1;
            input.val(inc);
        }
        Inventoryproductassign.updateCart(input);
    },
    onPriceChange:function(){
        var input = $(this).closest('.input-price').find('.updated_price');
        var price=$(this).val();
        if(price>0){
        Inventoryproductassign.updateCart1(input);
        }
    },
    updateCart:function(input){
        $('#image-loader').show();
        //console.log(select_menu);
        var data={
            id:input.attr('data-id'),
            rowid:input.attr('rowid'),
            purchase_qty:input.attr('data-purchase_qty'),
            assign_qty:input.val(),
        };
        console.log(data);
        if(input.val()==0){
            input.removeAttr('rowid');
        }
        $.ajax({
            url: Inventoryproductassign.base_url+"inventory/assign_kitchen_product_cart",
            type:'POST',
            data:data,
            success: function(result){
                $('#image-loader').hide();
                //console.log(result.cart_detials);
                 var cart_details=result['cart_details'];
                 Inventoryproductassign.showCartData(cart_details);
            }
        });
    },

    // updateCart1:function(input){
    //     $('#image-loader').show();
    //     //console.log(select_menu);
    //     var data={
    //         id:input.attr('data-id'),
    //         rowid:input.attr('rowid'),
    //         qty:input.attr('qty'),
    //     };
    //     //console.log(data);
    //     if(input.val()==0){
    //         input.removeAttr('rowid');
    //     }
    //     $.ajax({
    //         url: Inventoryproductassign.base_url+"inventory/purchase_product_cart",
    //         type:'POST',
    //         data:data,
    //         success: function(result){
    //             $('#image-loader').hide();
    //             //console.log(result.cart_detials);
    //              var cart_details=result['cart_details'];
    //              Inventoryproductassign.showCartData(cart_details);
    //         }
    //     });
    // },

    add_product_cart:function(){
        if($('.product_id').val() == '' || $('.product_name').val()=='' || $('.product_qty').val()==''){
            Inventoryproductassign.displaywarning('Please select product');
            return false;
        }
        var data={
            id:$('#show_product').val(),
            product_name:$('#product_name').val(),
            purchase_qty:$('#product_qty').val(),
            assign_qty:1,
            is_purchase:0,
            supplier_id:$('#supplier_id').val(),
        }
        $.ajax({
            url: Inventoryproductassign.base_url+"inventory/assign_kitchen_product_cart",
            type:'POST',
            data:data,
            success: function(result){
                $('#supplier_id').css('disabled',true);
				//$('#show_product').val('');
				//$('#select2-show_product-container').removeAttr('title');
                $('#image-loader').hide();
                //console.log(result);
                var cart_details=result['cart_details'];
                console.log(cart_details);
                Inventoryproductassign.showCartData(cart_details);
                // tab_pan.find('.mobile_no').attr("readonly", true) ;
                // tab_pan.find('.customer_name').attr("readonly", true) ;
                // Takeorders.clearItemForm(tab_pan);
            }
        });
    },

    showCartData:function(cart_details){
        var html = '';
        var assignqty=0;
        var availableqty=0;
        var remainingqty=0;
        for (i in cart_details) {
            if(cart_details[i].is_purchase == 0){
            html+='<tr>\
                    <td>';html +=cart_details[i].name+'</td>\
                    <td>';html +=cart_details[i].purchase_qty+'</td>\
                    <td style="width:20%">\
                        <div class="input-group input-indec">\
                            <span class="input-group-btn">\
                                <button type="button" class="quantity-left-minus btn btn-light btn-number qty_minus" data-id="'+cart_details[i].id+'" data-purchase_qty="'+cart_details[i].purchase_qty+'" data-qty="'+cart_details[i].qty+'" recipe-name="'+cart_details[i].name+'" data-type="minus" data-field="">\
                                    <i class="fas fa-minus"></i>\
                                </button>\
                            </span>\
                            <input type="text" name="quantity" min="0" max="'+cart_details[i].purchase_qty+'" class="form-control input-number text-center quantity" data-id="'+cart_details[i].id+'" rowid="'+cart_details[i].rowid+'" recipe-name="'+cart_details[i].name+'" data-purchase_qty="'+cart_details[i].purchase_qty+'" value="'+cart_details[i].qty+'" style="width:1px;">\
                            <span class="input-group-btn">\
                                <button type="button" class="quantity-right-plus btn btn-light btn-number qty_plus" data-id="'+cart_details[i].id+'" data-purchase_qty="'+cart_details[i].purchase_qty+'" data-qty="'+cart_details[i].qty+'" recipe-name="'+cart_details[i].name+'" data-type="plus" data-field="">\
                                    <i class="fas fa-plus"></i>\
                                </button>\
                            </span>\
                        </div>\
                    </td>\
                    <td>';html +=cart_details[i].available_qty+'</td>\
                   </tr>'; 
        }
        availableqty=parseInt(availableqty)+parseInt(cart_details[i].purchase_qty);
        assignqty=parseInt(assignqty)+parseInt(cart_details[i].qty);
        remainingqty=parseInt(remainingqty)+parseInt(cart_details[i].available_qty);
        }

        $('#showaddeditems').html(html);
        $('#available_qty_sum').val(availableqty);
        $('#assign_qty_sum').val(assignqty);
        $('#remaining_qty_sum').val(remainingqty);
        $('#avq').html(availableqty);
        $('#asq').html(assignqty);
        $('#req').html(remainingqty);
    },
    
    add_purchase_product : function(){
        if($('#grand_total').val() == 0){
            Inventoryproductassign.displaywarning("Please select product or product price should be greater than 0");
            return false;
        }
        if($('#supplier_id').val() == ''){
            Inventoryproductassign.displaywarning("Please select supplier");
            return false;
        }
        if($('#date').val() == ''){
            Inventoryproductassign.displaywarning("Date should not be empty");
            return false;
        }
        // $(".updated_price").each(function() {
        //     //alert($(this).val());
        //     if ($(this).val() == 0) {
        //         Inventoryproductassign.displaywarning("Price should be greater than 0");
        //         return false
        //     }
        // });

        $.ajax({
            url: Inventoryproductassign.base_url+"inventory/product_assign_to_kitchen_entry",
            type:'POST',
            data:{
                total_purchase_quantity : $('#available_qty_sum').val(),
                total_assign_quantity : $('#assign_qty_sum').val(),
                total_remaining_quantity : $('#remaining_qty_sum').val(),
                supplier_id : $('#supplier_id').val(),
                date : $('#date').val()
            },
            success: function(result)
            {
                if(result.status)
                {
                    Inventoryproductassign.displaysucess("Product Assigned to kitchen");
                    location.reload();
                }
                else
                {
                    // Takeorders.displaysucessconfirm(result.msg,result.order_id);
                    Inventoryproductassign.displaywarning(result.msg);
                }
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