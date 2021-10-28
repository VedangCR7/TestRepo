var Inventorypurchasecreateedit ={
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
    },

    getCart:function()
	{
		debugger;
        $.ajax({
            url: Inventorypurchasecreateedit.base_url+"inventory/get_edit_purchase_details",
            type:'POST',
            data:{purchase_id:$('#purchase_id').val()},
            success: function(result)
			{
                var cart_details=result[0].purchase_item;
                Inventorypurchasecreateedit.showCartData(cart_details);
                $('#show_grand_total').html('&#8377; '+result[0].grand_total);
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
        Inventorypurchasecreateedit.updatequantity(input);
    },

    onMinusQty:function(){
        var input=$(this).closest('.input-group').find('.quantity');
        var qty=input.val();
        $.ajax({
            url: Inventorypurchasecreateedit.base_url+"inventory/",
            type:'POST',
            data:data,
            success: function(result){
                
            }
        });
        if(qty>0){
            var inc=parseInt(qty)-1;
            input.val(inc);
        }
        Inventorypurchasecreateedit.updatequantity(input);
    },

    onPriceChange:function(){
        var input = $(this).closest('.input-price').find('.updated_price');
        var price=$(this).val();
        if(price>0){
            Inventorypurchasecreateedit.updatequantity1(input);
        }
    },

    updatequantity:function(input){
        debugger;
        var data={
            id:input.attr('data-id'),
            qty:input.val(),
            price:input.attr('data-price'),
            purchase_id:$('#purchase_id').val(),
            supplier_id:$('#supplier_id').val(),
        };
        $.ajax({
            url: Inventorypurchasecreateedit.base_url+"inventory/purchase_product_edit_invoice_quantity",
            type:'POST',
            data:data,
            success: function(result){
                if(result.status){
                    Inventorypurchasecreateedit.getCart();
                }
                // tab_pan.find('.mobile_no').attr("readonly", true) ;
                // tab_pan.find('.customer_name').attr("readonly", true) ;
                // Takeorders.clearItemForm(tab_pan);
            }
        });
    },
    
    updatequantity1:function(input){
        debugger;
        var data={
            id:input.attr('data-id'),
            qty:input.attr('qty'),
            price:input.val(),
            purchase_id:$('#purchase_id').val(),
            supplier_id:$('#supplier_id').val(),
        };
        $.ajax({
            url: Inventorypurchasecreateedit.base_url+"inventory/purchase_product_edit_invoice_quantity",
            type:'POST',
            data:data,
            success: function(result){
                if(result.status){
                    Inventorypurchasecreateedit.getCart();
                }
                // tab_pan.find('.mobile_no').attr("readonly", true) ;
                // tab_pan.find('.customer_name').attr("readonly", true) ;
                // Takeorders.clearItemForm(tab_pan);
            }
        });
    },
    
    
    add_product_cart:function(){
        if($('#product_id').val() == '' || $('#product_name').val()==''){
            Inventorypurchasecreateedit.displaywarning('Please select product');
            return false;
        }
        var data={
            id:$('#product_id').val(),
            product_name:$('#product_name').val(),
            supplier_id:$('#supplier_id').val(),
            purchase_id:$('#purchase_id').val(),
            qty:1,
            price:0,
        }
        $.ajax({
            url: Inventorypurchasecreateedit.base_url+"inventory/purchase_product_edit_invoice",
            type:'POST',
            data:data,
            success: function(result){
                if(result.status){
                    Inventorypurchasecreateedit.getCart();
                }
                else{
                    Inventorypurchasecreateedit.displaywarning(result.msg);
                    return false;
                }
                // tab_pan.find('.mobile_no').attr("readonly", true) ;
                // tab_pan.find('.customer_name').attr("readonly", true) ;
                // Takeorders.clearItemForm(tab_pan);
            }
        });
    },

    showCartData:function(cart_details){
        var html = '';
        for (i in cart_details) {
            html+='<tr>\
                    <td>';html +=cart_details[i].product_name+'</td>\
                    <td style="width:20%">\
                        <div class="input-group input-indec">\
                            <span class="input-group-btn">\
                                <button type="button" class="quantity-left-minus btn btn-light btn-number qty_minus" data-id="'+cart_details[i].product_id+'" data-price="'+cart_details[i].price+'" recipe-name="'+cart_details[i].product_name+'" data-type="minus" data-field="">\
                                    <i class="fas fa-minus"></i>\
                                </button>\
                            </span>\
                            <input type="text" name="quantity" min="0" class="form-control input-number text-center quantity" id="'+cart_details[i].product_id+'" data-id="'+cart_details[i].product_id+'" data-price="'+cart_details[i].price+'" value="'+cart_details[i].qty+'" style="width:1px;">\
                            <span class="input-group-btn">\
                                <button type="button" class="quantity-right-plus btn btn-light btn-number qty_plus" data-id="'+cart_details[i].product_id+'" data-price="'+cart_details[i].price+'" recipe-name="'+cart_details[i].product_name+'" data-type="plus" data-field="">\
                                    <i class="fas fa-plus"></i>\
                                </button>\
                            </span>\
                        </div>\
                    </td>\
                    <td style="width:20%" class="text-right"><div class="input-price"><input type="text" class="form-control updated_price" data-id="'+cart_details[i].product_id+'" qty="'+cart_details[i].qty+'" value="'+cart_details[i].price+'"></div></td>\
                   </tr>';
        }

        $('#showaddeditems').html(html);
    },
    

    loadMenuItems:function(){
        // var tablecategory=Takeorders.table_category_id;
        $('body').delegate('.product_name','focus',function(){
            var $input = $(this);
            $.get(Inventorypurchasecreateedit.base_url+"inventory/list_product_for_purchase/", function(data){
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
    
    
    displaysucess:function(msg)
    {
        swal("Success !",msg,"success");
    },

    displaywarning:function(msg)
    {
        swal("Error !",msg,"error");
    },

};