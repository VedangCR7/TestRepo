var Checkout ={
    base_url:null,
    tableid:null,
    //restid:null,
    //main_menu_id:null,
    //tablecategory_id:null,
    //is_category_prices:null,
    customer_id:null,
    init:function() {
        this.bind_events();
        this.getCart();
        //this.getcustomer();
    },

    bind_events :function() {
        var self=this;
        $('body').on('click','.btn-plus-qty',this.onPlusQty);
        $('body').on('click','.btn-minus-qty',this.onMinusQty);
        $('.btn-place-order').on('click',this.onPlaceOrder);
        
    },
    onPlaceOrder:function(){
        var data={
          //customer_id:Checkout.customer_id,
          tableid:Checkout.tableid,
          customer_name:$('#customer_name').val(),
          customer_contact:$('#customer_contact').val(),
          suggetion:$('.input-suggestion').val(),
          sub_total:$('.item-total').attr('sub_total'),
          discount:$('.total-discount').attr('discount'),
          net_total:$('.net-amount').attr('net_total'),
	no_of_person:$('#no_of_person').val()
        };
        $('#image-loader').show();
        $.ajax({
            url: Checkout.base_url+"restaurant_managerorder/place_order",
            type:'POST',
            data:data,
            success: function(result){
                $('#image-loader').hide();
                if(result.status){
                    $('.osahan-checkout').hide();
                    $('#addmenuhide').hide();
                    $('.div-order-success').show();
                   /* Checkout.getCart();*/
                }else{
                    Checkout.displaywarning(result.msg);
                }
            }
        });
    },
    onPlusQty:function(){
        var input=$(this).closest('.count-number').find('.count-number-input');
        var qty=input.val();
        if(qty<1000){
            var inc=parseInt(qty)+1;
            input.val(inc);
        }
        var select_menu=$(this).closest('.cart-item');
        Checkout.updateCart(select_menu,input);
        
    },
    onMinusQty:function(){
        var input=$(this).closest('.count-number').find('.count-number-input');
        var qty=input.val();
        console.log(qty);
        if(qty>0){
            var inc=parseInt(qty)-1;
            input.val(inc);
        }
        var select_menu=$(this).closest('.cart-item');
        Checkout.updateCart(select_menu,input);
    },
    updateCart:function(select_menu,input){
        $('#image-loader').show();
        var data={
          rowid:select_menu.attr('rowid-id'),
          //customer_id:Checkout.customer_id,
          qty:input.val()
        };
        $.ajax({
            url: Checkout.base_url+"cart/updateCart",
            type:'POST',
            data:data,
            success: function(result){
                $('#image-loader').hide();

                Checkout.getCart();
            }
        });
    },
    getCart:function(){
         $.ajax({
            url: Checkout.base_url+"cart/get_cart",
            type:'POST',
            data:{},
            success: function(result){
                var cart=result.cart_detials;
                if(result.count==0){
                    $('.div-no-item').show();
                    $('.div-order-success').hide();
                    $('.osahan-checkout').hide();
                    $('#addmenuhide').hide();
                }else{
                    $('.osahan-checkout').show();
                    $('.div-no-item').hide();
                    $('.div-order-success').hide();
                }
                Checkout.loadCartHtml(cart);
            }
        });
    },
    loadCartHtml:function(cart){
        var html='';
        if(Checkout.restid == 103){
            var $currency = 'MZN';
        }
        else{ 
            var $currency = '&#8377;'; 
        }
        var sub_total=0;
        for(i in cart){
            sub_total+=(parseFloat(cart[i].qty)*parseFloat(cart[i].price));
            html+='<div class="gold-members d-flex align-items-center justify-content-between px-3 py-2 border-bottom cart-item" data-id="'+cart[i].options.menu_id+'" rowid-id="'+cart[i].rowid+'" recipe-type="'+cart[i].options.recipe_type+'">\
              <div class="media align-items-center">\
                    <div class="mr-2 text-danger"> \
                        <a href="#">';
                        if(cart[i].options.recipe_type=="nonveg")
                            html+='<img src="'+Checkout.base_url+'assets/web/images/nv.png" alt="" class="cart-details-vegimg">';
                        else if(cart[i].options.recipe_type=="veg")
                            html+='<img src="'+Checkout.base_url+'assets/web/images/vg.png" alt="" class="cart-details-vegimg">';
                        else{
                            html +='';
                        }
                        html+='</a>\
                    </div>\
                 <div class="media-body media-menu-name">\
                    <p class="m-0 cart-menu-name" name="'+cart[i].name+'">'+cart[i].name+'</p>\
                 </div>\
              </div>\
              <div class="d-flex align-items-center">\
                <span class="count-number float-right"><button type="button" class="btn-sm left dec btn btn-minus-qty btn-outline-success"><i class="feather-minus"></i></button><input class="count-number-input" type="text" readonly="" value="'+cart[i].qty+'"><button type="button" class="btn-sm right inc btn-plus-qty btn btn-outline-success"> <i class="feather-plus"></i> </button></span>\
                <p class="text-gray mb-0 float-right ml-2 text-muted small cart-price" price="'+cart[i].price+'">'+$currency+cart[i].price+'</p>\
              </div>\
           </div>';
        }
        $('.cart-item-list').html(html);
        $('.item-total').html($currency+sub_total.toFixed(2));
        $('.item-total').attr('sub_total',sub_total.toFixed(2));
        $('.total-discount').html($currency+'0');
        $('.total-discount').attr('discount','0');
        $('.net-amount').html($currency+sub_total.toFixed(2));
        $('.net-amount').attr('net_total',sub_total.toFixed(2));

    },

    displaysucess:function(msg)
    {
        swal("Success !",msg,"success");
    },

   displaywarning:function(msg)
    {
        swal("Error !",msg,"error");
    }
};
