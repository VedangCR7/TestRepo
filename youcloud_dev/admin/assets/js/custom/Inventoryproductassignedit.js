var Inventoryproductassign ={
    base_url:null,
    init:function() {
        this.bind_events();
        //this.loadMenuItems();
        this.getCart();
        this.changesupplier();
    },

    bind_events :function() {
        var self=this; 
        $('.add_product_cart').on('click',this.add_product_cart);
        $('#supplier_id').on('change',this.changesupplier);
        $('#show_product').on('change',this.changeproduct);
        $('#showaddeditems').on('click','.qty_minus',this.onMinusQty);
        $('#showaddeditems').on('click','.qty_plus',this.onPlusQty);
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
                    var qty = parseInt(result[i].qty)-parseInt(result[i].assign_qty);
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
            url: Inventoryproductassign.base_url+"inventory/get_all_assign_kitchen_details",
            type:'POST',
            data:{assign_id:$('#assign_id').val(),supplier_id:$('#supplier_id').val()},
            success: function(result)
			{
                console.log(result);
                var cart_details=result[0].assign_item;
                Inventoryproductassign.showCartData(cart_details);
                $('#avq').html(result[0].total_purchase_quantity);
                $('#asq').html(result[0].total_assign_quantity);
                $('#req').html(result[0].total_remaining_quantity);
            }
        });
    },

    clearItemForm:function(){
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
        Inventoryproductassign.updateCart(input);
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
    
    updateCart:function(input){
        $('#image-loader').show();
        //console.log(select_menu);
        var data={
            id:input.attr('data-id'),
            purchase_quantity:input.attr('data-purchase_qty'),
            assign_quantity:input.val(),
            assign_id:$('#assign_id').val(),
            supplier_id:$('#supplier_id').val()
        };
        console.log(data);
        $.ajax({
            url: Inventoryproductassign.base_url+"inventory/assign_kitchen_product_quatity_edit",
            type:'POST',
            data:data,
            success: function(result){
                $('#image-loader').hide();
                Inventoryproductassign.getCart();
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
            purchase_quantity:$('#product_qty').val(),
            assign_quantity:1,
            supplier_id:$('#supplier_id').val(),
            assign_id:$('#assign_id').val(),
        }
        $.ajax({
            url: Inventoryproductassign.base_url+"inventory/assign_kitchen_product_edit",
            type:'POST',
            data:data,
            success: function(result){
                if(result.status){
                    $('#supplier_id').css('disabled',true);
                    $('#image-loader').hide();
                    Inventoryproductassign.getCart();
                }
                else{
                    Inventoryproductassign.displaywarning(result.msg);
                    return false;
                }
            }
        });
    },

    showCartData:function(cart_details){
        var html = '';
        var assignqty=0;
        var availableqty=0;
        var remainingqty=0;
        for (i in cart_details) {
            html+='<tr>\
                    <td>';html +=cart_details[i].product_name+'</td>\
                    <td>';html +=cart_details[i].purchase_quantity+'</td>\
                    <td style="width:20%">\
                        <div class="input-group input-indec">\
                            <span class="input-group-btn">\
                                <button type="button" class="quantity-left-minus btn btn-light btn-number qty_minus" data-id="'+cart_details[i].product_id+'" data-purchase_qty="'+cart_details[i].purchase_quantity+'" data-qty="'+cart_details[i].assign_quantity+'" recipe-name="'+cart_details[i].product_name+'" data-type="minus" data-field="">\
                                    <i class="fas fa-minus"></i>\
                                </button>\
                            </span>\
                            <input type="text" name="quantity" min="0" max="'+cart_details[i].purchase_quantity+'" class="form-control input-number text-center quantity" data-id="'+cart_details[i].product_id+'" data-purchase_qty="'+cart_details[i].purchase_quantity+'" value="'+cart_details[i].assign_quantity+'" style="width:1px;">\
                            <span class="input-group-btn">\
                                <button type="button" class="quantity-right-plus btn btn-light btn-number qty_plus" data-id="'+cart_details[i].id+'" data-purchase_qty="'+cart_details[i].purchase_quantity+'" data-qty="'+cart_details[i].assign_quantity+'" recipe-name="'+cart_details[i].product_name+'" data-type="plus" data-field="">\
                                    <i class="fas fa-plus"></i>\
                                </button>\
                            </span>\
                        </div>\
                    </td>\
                    <td>';html +=cart_details[i].remaining_quantity+'</td>\
                   </tr>';
        // availableqty=parseInt(cart_details[i].remaining_quantity)+parseInt(cart_details[i].purchase_qty);
        // assignqty=parseInt(assignqty)+parseInt(cart_details[i].qty);
        // remainingqty=parseInt(remainingqty)+parseInt(cart_details[i].available_qty);
        }

        $('#showaddeditems').html(html);
        
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