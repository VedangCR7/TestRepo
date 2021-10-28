var Orderedit ={
    base_url:null,
    init:function() {
        this.bind_events();
        this.loadMenus();
        this.ordermenu();
    },

    bind_events :function() {
        var self=this;
        $('.tbody-items-table').on('click','.delete-product',this.deleteProduct);
        $('body').on('click','.btn-plus-qty',this.onPlusQty);
        $('body').on('click','.btn-minus-qty',this.onMinusQty);
        $('#btn-add-item').on('click',this.addproduct);
        $('.save_product').on('click',this.saveproduct);
        //$('#input-item-name').on('keyup',this.loadMenus);
    },

    saveproduct:function(){
        $.ajax({
            url: Orderedit.base_url+"restaurant_managerorder/save_product/",
            type:'POST',
            dataType: 'json',
            data: {suggetion:$('#suggetion').val(),order_id:$('#order_id').val()},
            success: function(result){
                Orderedit.displaysucessconfrim('Order Save successfully',result.date);
                //window.location.href=Orderedit.base_url+'restaurant_managerorder/order_history/'+result.date;
            }
        });
    },

    loadMenus:function(){
        var $input = $(".input-item-name");
        $.get(Orderedit.base_url+"restaurant_managerorder/list_edit_recipes", function(data){
            $input.typeahead({
                source:data,autoSelect: true,
                afterSelect:function(item){
                    console.log(item);
                    $('.input-item-id').val(item.id);
                    $('#input-price').val(item.price);
                    $('#input-qty').val('1');
                    $('#input-discount').val('0');
                }
            });
        },'json');
    },

    ordermenu:function(){
        var order_id=$('#order_id').val();
            var data={
            order_id:order_id
        }
        $('#image-loader').show();
        $.ajax({
            url: Orderedit.base_url+"restaurant/get_order_details/",
            type:'POST',
            dataType: 'json',
            data: data,
            success: function(result){
                //console.log(result['items']);
                Orderedit.loadItemTable(result['items']);
                $('#suggetion').val(result['suggetion']);
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

    loadItemTable:function(response){
        if(response){
            $('.cart-item-list').show();
            $('.cart-item-list').html("");
            var html ='';
            for (var i = 0; i < response.length; i++) {
            html += '<div class="gold-members d-flex align-items-center justify-content-between px-3 py-2 border-bottom">\
                  <div class="media align-items-center" style="width:50%">\
                     <div class="mr-2 text-danger">';
                    if (response[i].recipe_type == 'nonveg') {
                    html +='<img src="'+Orderedit.base_url+'assets/web/images/nv.png" height="10px" width="10px">';
                    }
                    else if (response[i].recipe_type == 'veg'){
                    html +='<img src="'+Orderedit.base_url+'assets/web/images/vg.png" height="10px" width="10px">';
                    }
                    else{
                        html +='';
                    }
                    html +='</div>\
                     <div class="media-body">\
                        <p class="m-0 menuname">'+response[i].recipe_name+'</p>\
                     </div>\
                  </div>\
                  <div class="d-flex align-items-center">\
                  <div class="order_details">\
                  <input type="hidden" id="recipe_id" class="recipe_id" value="'+response[i].recipe_id+'">\
                  <input type="hidden" id="order_item_id" class="order_item_id" value="'+response[i].id+'">\
                  <input type="hidden" id="ord_id" class="ord_id" value="'+response[i].order_id+'">\
                  <input type="hidden" id="price" class="price" value="'+response[i].price+'"></div>\
                  <p class="text-gray mb-0 float-right text-muted small">&#8377; '+response[i].price+'</p>\
                  <li class="view-recipe float-right mb-2"><span class="count-number float-right ml-2" data-id="'+response[i].id+'" price="'+response[i].price+'" name="'+response[i].name+'" recipe-type="'+response[i].recipe_type+'"><button type="button" class="btn-sm left dec btn btn-outline-success btn-minus-qty"> <i class="feather-minus"></i> </button><input class="count-number-input" type="text" readonly="" value="'+response[i].qty+'" min="1" max="999999"><button type="button" class="btn-sm right inc btn btn-outline-success btn-plus-qty"> <i class="feather-plus"></i> </button></span></li>\
                  </div>\
               </div>';
           }
           $('.cart-item-list').html(html);
        }
    },

    onPlusQty:function(){
        var input=$(this).closest('.count-number').find('.count-number-input');
        var qty=input.val();
        //alert(qty);
        var quantity =parseInt(qty)+1;
        //alert(quantity);
        input.val(quantity);
        var order_item_id =$(this).closest('div').find('.order_item_id').val();
        var order_id =$(this).closest('div').find('.ord_id').val();
        var recipe_id =$(this).closest('div').find('.recipe_id').val();
        var price =$(this).closest('div').find('.price').val();
        Orderedit.UpdateProduct(order_item_id,order_id,recipe_id,price,quantity);
        
    },
    onMinusQty:function(){
        var input=$(this).closest('.count-number').find('.count-number-input');
        var qty=input.val();
        //alert(qty);
        var quantity =parseInt(qty)-1;
        //alert(quantity);
        input.val(quantity);
        var order_item_id =$(this).closest('div').find('.order_item_id').val();
        var order_id =$(this).closest('div').find('.ord_id').val();
        var recipe_id =$(this).closest('div').find('.recipe_id').val();
        var price =$(this).closest('div').find('.price').val();
        if(quantity == 0){
            Orderedit.deleteProduct(order_item_id,order_id,recipe_id,price,quantity);
        }
        else{
            Orderedit.UpdateProduct(order_item_id,order_id,recipe_id,price,quantity);
        }
    },

    UpdateProduct:function(order_item_id,order_id,recipe_id,price,quantity){
        $('#image-loader').show();
        $.ajax({
            url: Orderedit.base_url+"restaurant_managerorder/update_order/",
            type:'POST',
            dataType: 'json',
            data: {order_item_id:order_item_id,order_id:order_id,recipe_id:recipe_id,price:price,quantity:quantity},
            success: function(response){
                $('#image-loader').show();
                if(response.status){
                    $('#image-loader').hide();
                    Orderedit.ordermenu();
                }
                //Orderedit.calculateTotal();
            }
        });
    },

    addproduct:function(){
        var recipe_id=$('#input-item-id').val();
        var price=$('#input-price').val();
        var qty = $('#input-qty').val();
        var discount_per = $('#input-discount').val();
        var order_id = $('#order_id').val();
        if (recipe_id =='') {
            Orderedit.displaywarning('Please select item');
            return false;
        }
        $('#image-loader').show();
        $.ajax({
            url: Orderedit.base_url+"restaurant_managerorder/save_new_order/",
            type:'POST',
            dataType: 'json',
            data: {order_id:order_id,recipe_id:recipe_id,price:price,qty:qty,discount_per:discount_per},
            success: function(response){
                $('#image-loader').show();
                if(response.status){
                    $('#image-loader').hide();
                    $('#input-item-id').val('');
                    $('#input-item-name').val('');
                    Orderedit.ordermenu();
                }
                else{
                    if (response.msg) {
                        $('#image-loader').hide();
                        Orderedit.displaywarning(response.msg);
                    }
                }
                //Orderedit.calculateTotal();
            }
        });
    },


    deleteProduct:function(order_item_id,order_id,recipe_id,price,quantity){
        $('#image-loader').show();
        $.ajax({
            url: Orderedit.base_url+"restaurant_managerorder/delete_order_item/",
            type:'POST',
            dataType: 'json',
            data: {order_item_id:order_item_id,order_id:order_id,recipe_id:recipe_id,price:price,quantity:quantity},
            success: function(response){
                $('#image-loader').show();
                if(response.status){
                    $('#image-loader').hide();
                    Orderedit.ordermenu();
                }
                else{
                    if (response.msg) {
                        $('#image-loader').hide();
                        Orderedit.displaywarning(response.msg);
                        Orderedit.ordermenu();
                    }
                }
                //Orderedit.calculateTotal();
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

    displaysucessconfrim:function(msg,orderdate)
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
                    window.location.href=Orderedit.base_url+'restaurant_managerorder/order_history/'+orderdate;
                    /*window.location.href=Orders.base_url+"restaurant/printbill/"+invoice_id;*/
                }
            });
        // swal({
        //     title:"Success !", 
        //     text:msg, 
        //     type:"success",
        //     confirmButtonClass: "btn-primary",
        //     confirmButtonText: "Ok",
        //     closeOnConfirm: false
        // }).then(function(){
        //     window.location.href=Orderedit.base_url+'restaurant_managerorder/order_history/'+orderdate;
        // })
    },

};