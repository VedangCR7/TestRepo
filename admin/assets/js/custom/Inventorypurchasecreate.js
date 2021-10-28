var Inventorypurchasecreate ={
    base_url:null,
    init:function() {
        this.bind_events();
        this.loadMenuItems();
        this.getCart();
    },

    bind_events :function() {
        var self=this; 
        $('.add_product_cart').on('click',this.add_product_cart);
        $('#showaddeditems').on('click','.qty_minus',this.onMinusQty);
        $('#showaddeditems').on('click','.qty_plus',this.onPlusQty);
        $('#showaddeditems').on('blur','.updated_price',this.onPriceChange);
        $('.btn-add-purchase').on('click',this.add_purchase_product);
        //$('.btn-add-group').on('click',this.onSaveGroupname);
		$('body').on('change','#supplier_id',function(){
			$.ajax({
            url: Inventorypurchasecreate.base_url+"inventory/empty_cart",
            type:'POST',
            data:{},
            success: function(result)
			{
                $('#showaddeditems').html('');
            }
        });
		});
    },

    getCart:function()
	{
		//debugger;
        $.ajax({
            url: Inventorypurchasecreate.base_url+"inventory/get_purchase_cart",
            type:'POST',
            data:{},
            success: function(result)
			{
                var cnt=result.count;
                if(cnt>0)
				{
                    var cart_details=result.cart_detials;
                    Inventorypurchasecreate.showCartData(cart_details);
                }
				else
				{

                    $('#showaddeditems').html('<tr>\
                        <td colspan="3" class="text-danger text-center" style="padding: 20px 10px;font-size: 15px;">No Item Added</td>\
                        </tr>');
                }
            }
        });
    },

    clearItemForm:function(tab_pan){
        $("#product_name").val("");
        $("#product_id").val("");
        $('.input-row').val("");
    },
    onPlusQty:function(){
        var input=$(this).closest('.input-group').find('.quantity');
        var qty=input.val();
        //alert(qty);
        if(qty<1000){
            var inc=parseInt(qty)+1;
            input.val(inc);
        }
        Inventorypurchasecreate.updateCart(input);
    },

    onMinusQty:function(){
        var input=$(this).closest('.input-group').find('.quantity');
        var qty=input.val();
        if(qty>0){
            var inc=parseInt(qty)-1;
            input.val(inc);
        }
        Inventorypurchasecreate.updateCart(input);
    },
    onPriceChange:function(){
        var input = $(this).closest('.input-price').find('.updated_price');
        var price=$(this).val();
        if(price>0){
        Inventorypurchasecreate.updateCart1(input);
        }
    },
    updateCart:function(input){
        $('#image-loader').show();
        //console.log(select_menu);
        var data={
            id:input.attr('data-id'),
            rowid:input.attr('rowid'),
            qty:input.val(),
            price:input.attr('data-price'),
        };
        //console.log(data);
        if(input.val()==0){
            input.removeAttr('rowid');
        }
        $.ajax({
            url: Inventorypurchasecreate.base_url+"inventory/purchase_product_cart",
            type:'POST',
            data:data,
            success: function(result){
                $('#image-loader').hide();
                //console.log(result.cart_detials);
                 var cart_details=result['cart_details'];
                 Inventorypurchasecreate.showCartData(cart_details);
            }
        });
    },

    updateCart1:function(input){
        $('#image-loader').show();
        //console.log(select_menu);
        var data={
            id:input.attr('data-id'),
            rowid:input.attr('rowid'),
            qty:input.attr('qty'),
            price:input.val(),
        };
        //console.log(data);
        if(input.val()==0){
            input.removeAttr('rowid');
        }
        $.ajax({
            url: Inventorypurchasecreate.base_url+"inventory/purchase_product_cart",
            type:'POST',
            data:data,
            success: function(result){
                $('#image-loader').hide();
                //console.log(result.cart_detials);
                 var cart_details=result['cart_details'];
                 Inventorypurchasecreate.showCartData(cart_details);
            }
        });
    },

    add_product_cart:function(){
        if($('#product_id').val() == '' || $('#product_name').val()==''){
            Inventorypurchasecreate.displaywarning('Please select product');
            return false;
        }
        var data={
            id:$('#product_id').val(),
            product_name:$('#product_name').val(),
            qty:1,
            price:0,
            is_purchase:1
        }
        $.ajax({
            url: Inventorypurchasecreate.base_url+"inventory/purchase_product_cart",
            type:'POST',
            data:data,
            success: function(result){
                $('#image-loader').hide();
				$('#product_name').val('');
                console.log(result);
                var cart_details=result['cart_details'];
                Inventorypurchasecreate.showCartData(cart_details);
                // tab_pan.find('.mobile_no').attr("readonly", true) ;
                // tab_pan.find('.customer_name').attr("readonly", true) ;
                // Takeorders.clearItemForm(tab_pan);
            }
        });
    },

    showCartData:function(cart_details){
        var html = '';
        var sub_total = 0;
        for (i in cart_details) {
            if(cart_details[i].is_purchase == 1){
            html+='<tr>\
                    <td>';html +=cart_details[i].name+'</td>\
                    <td style="width:20%">\
                        <div class="input-group input-indec">\
                            <span class="input-group-btn">\
                                <button type="button" class="quantity-left-minus btn btn-light btn-number qty_minus" data-id="'+cart_details[i].id+'" data-price="'+cart_details[i].price+'" recipe-name="'+cart_details[i].name+'" data-type="minus" data-field="">\
                                    <i class="fas fa-minus"></i>\
                                </button>\
                            </span>\
                            <input type="text" name="quantity" min="0" class="form-control input-number text-center quantity" data-id="'+cart_details[i].id+'" rowid="'+cart_details[i].rowid+'" data-price="'+cart_details[i].price+'" value="'+cart_details[i].qty+'" style="width:1px;">\
                            <span class="input-group-btn">\
                                <button type="button" class="quantity-right-plus btn btn-light btn-number qty_plus" data-id="'+cart_details[i].id+'" data-price="'+cart_details[i].price+'" recipe-name="'+cart_details[i].name+'" data-type="plus" data-field="">\
                                    <i class="fas fa-plus"></i>\
                                </button>\
                            </span>\
                        </div>\
                    </td>\
                    <td style="width:20%" class="text-right"><div class="input-price"><input type="text" class="form-control updated_price" name="updated_price" data-id="'+cart_details[i].id+'" rowid="'+cart_details[i].rowid+'" qty="'+cart_details[i].qty+'" value="'+cart_details[i].price+'"></div></td>\
                   </tr>';
                sub_total = parseFloat(sub_total)+(parseFloat(cart_details[i].price) * parseFloat(cart_details[i].qty)); 
        }
        }

        $('#showaddeditems').html(html);
        $('#grand_total').val(sub_total);
        $('#show_grand_total').html('&#8377; '+sub_total);
    },
    

    loadMenuItems:function(){
        // var tablecategory=Takeorders.table_category_id;
        $('body').delegate('.product_name','focus',function(){
            var $input = $(this);
            $.get(Inventorypurchasecreate.base_url+"inventory/list_product_for_purchase/", function(data){
                console.log(data);
                $input.typeahead({ 
                    source:data,autoSelect: true,
                    afterSelect:function(item){
                        $('.product_id').val(item.id);
                    },
                });
            },'json');
        });
    },



    // onSaveGroupname:function(){
    //     alert($('input[type=radio]:checked').val());
    //     if($('#payment_date').val() ==''){ Inventorypaymentcreate.displaywarning("Payment date is required"); return false; }
    //     if($('#supplier_id').val() ==''){ Inventorypaymentcreate.displaywarning("Please select supplier"); return false; }
    //     if($('.payment_type').val() ==''){ Inventorypaymentcreate.displaywarning("Please Select Payment type"); return false; }
    //     if($('#payable_amount').val() ==''){ Inventorypaymentcreate.displaywarning("Please enter payable amount"); return false; }
    //     $('#image-loader').show();
    //     $.ajax({
    //         url: Inventorypaymentcreate.base_url+"inventory/save_product_name",
    //         type:'POST',
    //         dataType: 'json',
    //         data: {
    //             payment_date : $('#payment_date').val(),
    //             supplier_id : $('#supplier_id').val(),
    //             payment_type : $('.payment_type').val(),
    //             payable_amount : $('#payable_amount').val()
    //         },
    //         success: function(result){
    //             $('#image-loader').hide();
    //             if (result.status) {
    //                 Inventorypaymentcreate.displaysucess("Product created successfully");
    //                 $('#product_name').val('');
    //             }else{
    //                 Inventorypaymentcreate.displaywarning(result.msg);
    //             }
    //         }
    //     });

    // },
    add_purchase_product : function(){
        if($('#grand_total').val() == 0){
            Inventorypurchasecreate.displaywarning("Please select product or product price should be greater than 0");
            return false;
        }
        if($('#supplier_id').val() == ''){
            Inventorypurchasecreate.displaywarning("Please select supplier");
            return false;
        }
        if($('#date').val() == ''){
            Inventorypurchasecreate.displaywarning("Date should not be empty");
            return false;
        }
        $(".updated_price").each(function() {
            //alert($(this).val());
            if ($(this).val() == 0) {
                Inventorypurchasecreate.displaywarning("Price should be greater than 0");
                return false
            }
        });

        $.ajax({
            url: Inventorypurchasecreate.base_url+"inventory/purchase_order_placeorder",
            type:'POST',
            data:{
                grand_total : $('#grand_total').val(),
                supplier_id : $('#supplier_id').val(),
                date : $('#date').val()
            },
            success: function(result)
            {
                if(result.status)
                {
                    Inventorypurchasecreate.displaysucess("Purchase Order created");
                    location.reload();
                }
                else
                {
                    // Takeorders.displaysucessconfirm(result.msg,result.order_id);
                    Inventorypurchasecreate.displaywarning(result.msg);
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