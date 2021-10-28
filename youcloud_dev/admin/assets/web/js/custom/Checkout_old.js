var Checkout ={
    base_url:null,
    tableid:null,
    restid:null,
    main_menu_id:null,
    tablecategory_id:null,
    is_category_prices:null,
    customer_id:null,
    init:function() {
        this.bind_events();
        this.getCart();
        this.getcustomeraddress();
    },

    bind_events :function() {
        var self=this;
        $('body').on('click','.btn-plus-qty',this.onPlusQty);
        $('body').on('click','.btn-minus-qty',this.onMinusQty);
        $('.btn-place-order1').on('click',this.onPlaceOrder1);
        $('.btn-place-order').on('click',this.onPlaceOrder);
        $('.supply_option').on('change',this.onchagesupplieroption);
        $('#save_delivery_address').on('click',this.savedeliveryaddress);
        $('.show_address').on('click','.edit_address',this.edit_address);
        $('#new_address').on('click',this.remove_field_value);
		$('.number').on('keyup',function(e){
           this.value = this.value.replace(/[^0-9\.]/g,'');
        });
        
    },

    remove_field_value:function(){
        $('.delivery_area').val('');
        $('.complete_address').val('');
        $('.delivery_instruction').val('');
        $('#save_delivery_address').text('Save Changes');
        $('#save_delivery_address').attr('data-edit-id','');
    },

    savedeliveryaddress:function(){
		debugger;
        var edit_id = $(this).attr('data-edit-id');
        //alert($('input[name=nickname]:checked').val());
        if($('.delivery_area').val() == ''){
            Checkout.displaywarning("Please Enter delivery area");
            return false;
        }
        if($('.complete_address').val() == ''){
            Checkout.displaywarning("Please Enter complete address");
            return false;
        }
        if(edit_id == ''){
            var data={
                customer_id:Checkout.customer_id,
                delivery_area:$('.delivery_area').val(),
                complete_address:$('.complete_address').val(),
                delivery_instruction:$('.delivery_instruction').val(),
                nickname:$('input[name=nickname]:checked').val(),
                name:$('.name').val(),
                number:$('.number').val()
            };
            $('#image-loader').show();
            $.ajax({
              url: Checkout.base_url+"checkout/add_delivery_address",
              type:'POST',
              data:data,
              success: function(result){
                  $('#image-loader').hide();
                    Checkout.displaysucess('Address Added successfully');
                    $('.delivery_area').val('');
                    $('.complete_address').val('');
                    $('.delivery_instruction').val('');
                    $('.name').val('');
                    $('.number').val('');
                    //$('#exampleModal').modal('hide');
                    $('#exampleModal').modal('hide');
                    Checkout.getcustomeraddress();
              }
            });
        }else{
                var data={
                    customer_id:Checkout.customer_id,
                    delivery_area:$('.delivery_area').val(),
                    complete_address:$('.complete_address').val(),
                    delivery_instruction:$('.delivery_instruction').val(),
                    nickname:$('input[name=nickname]:checked').val(),
                    edit_id :edit_id,
					name:$('.name').val(),
					number:$('.number').val()
                };
                $('#image-loader').show();
                $.ajax({
                  url: Checkout.base_url+"checkout/edit_perticular_delivery_address",
                  type:'POST',
                  data:data,
                  success: function(result){
                      $('#image-loader').hide();
                        Checkout.displaysucess('Address update successfully');
                        //$('#exampleModal').modal('hide');
                        $('#exampleModal').modal('hide');
                        Checkout.getcustomeraddress();
                  }
                });
        }
        
    },

    getcustomeraddress:function(){
        var data={
            customer_id:Checkout.customer_id
          };
          $.ajax({
              url: Checkout.base_url+"checkout/get_delivery_address",
              type:'POST',
              data:data,
              success: function(result){
                console.log(result);
                var html='';
                var setradiochecked='';
                var setdefault = '';
                if(result.length >0){
                for(var i=0;i<result.length;i++){
                    if(i==0){
                        setradiochecked = "checked";
                        setdefault = '<p class="mb-0 badge badge-success ml-auto"><i class="icofont-check-circled"></i>Default</p>';

                    }else{
                        setradiochecked = "";
                        setdefault ='<p class="mb-0 badge badge-light ml-auto"><i class="icofont-check-circled"></i> Select</p>';
                    }
                    html+='<div class="custom-control col-lg-6 custom-radio mb-3 position-relative border-custom-radio">\
                    <input type="radio" id="customRadioInline'+i+'" value="'+result[i].id+'" name="customRadioInline1" class="custom-control-input" '+setradiochecked+'>\
                    <label class="custom-control-label w-100" for="customRadioInline'+i+'">\
                       <div>\
                          <div class="p-3 bg-white rounded shadow-sm w-100">\
                             <div class="d-flex align-items-center mb-2">\
                                <p class="mb-0 h6">'+result[i].nickname+'</p>\
                                '+setdefault+'\
                             </div>\
                             <p class="small text-muted m-0">'+result[i].delivery_area+'</p>\
                             <p class="small text-muted m-0">'+result[i].complete_address+'</p>\
                             <p class="pt-2 m-0 text-right"><span class="small"><a href="#"  data-toggle="modal" data-target="#exampleModal" class="text-decoration-none text-info edit_address" data-id="'+result[i].id+'">Edit</a></span></p>\
                          </div>\
                          <span class="btn btn-light border-top btn-lg btn-block">\
                          Deliver Here\
                          </span>\
                       </div>\
                    </label></div>';
                }
                }else{
                    html = "<p>Address not found</p>";
                }
                $('.show_address').html(html);
              }
          });
    },

    edit_address:function(){
        var address_id = $(this).attr('data-id');
        //alert(address_id);
        $.ajax({
            url: Checkout.base_url+"checkout/show_perticular_address",
            type:'POST',
            data:{id:address_id},
            success: function(result){
                $('#image-loader').hide();
                  //Checkout.displaysucess('Address Added successfully');
                  $('.name').val(result[0].name);
                  $('.number').val(result[0].contact_number);
                  $('.delivery_area').val(result[0].delivery_area);
                  $('.complete_address').val(result[0].complete_address);
                  $('.delivery_instruction').val(result[0].delivery_instruction);
                  $('input[value='+result[0].nickname+']').prop('checked', true);
                  $('#save_delivery_address').text('Update');
                  $('#save_delivery_address').attr('data-edit-id',result[0].id);
                  //$('#exampleModal').modal('hide');
                  //$('#exampleModal').modal('hide');
                  //Checkout.getcustomeraddress();
            }
        });
    },

    onchagesupplieroption:function(){
        if($('input[type=radio]:checked').val() == 'Delivery'){
            $('#show_address_box').show();
        }else{
            $('#show_address_box').hide();
        }
    },

    onPlaceOrder:function()
	{
		debugger;
		$( ".btn-place-order" ).prop( "disabled", true );
		
        var data={
          customer_id:Checkout.customer_id,
          tableid:Checkout.tableid,
          rest_id:Checkout.restid,
          suggetion:$('.input-suggestion').val(),
          sub_total:$('.item-total').attr('sub_total'),
          discount:$('.total-discount').attr('discount'),
          net_total:$('.net-amount').attr('net_total'),
          no_of_person:$('#no_of_person').val()
        };
        $('#image-loader').show();
        $.ajax({
            url: Checkout.base_url+"checkout/place_order",
            type:'POST',
            data:data,
            success: function(result){
                $('#image-loader').hide();
                if(result.status){
                    $('.osahan-checkout').hide();
                    $('.div-no-item').hide();
                    $('.div-order-success').show();
					$( ".btn-place-order" ).hide();
                   /* Checkout.getCart();*/
                }else{
                    Checkout.displaywarning(result.msg);
                }
            }
        });
    },

    onPlaceOrder1:function()
	{
        //alert($('input[name=customRadioInline1]:checked').val());
        if($('input[name=supply_option]:checked').val()!='')
		{
			var supplier_option = $('input[name=supply_option]:checked').val();
        }
		else
		{
            var supplier_option = '';
        }
        
		if(supplier_option == 'Delivery')
		{
            if($('input[name=customRadioInline1]:checked').val() ==undefined)
			{
                Checkout.displaywarning("Please add delivery address");$('#collapsetwo').collapse('show');return false;
            }
            var delivery_address = $('input[name=customRadioInline1]:checked').val();
        }
        else
		{
            var delivery_address = 0;
        }

        if($('#card_number').val()=='' || $('#valid_through').val()=='' || $('#cvv').val() == '' || $('#name_on_card').val() == '')
		{
            
            Checkout.displaywarning("Please enter payment details");
            $('#collapsefour').collapse('show');
            return false;
        }

        if($('#card_number').val().length < 16 || $('#card_number').val().length > 16){
            Checkout.displaywarning("Please enter valid Card number.card number should be 16 digit in length");return false;
        }

        if($('#cvv').val().length < 3 || $('#cvv').val().length > 3)
		{
            Checkout.displaywarning("Please enter valid CVV");return false;
        }

        re = /^(0[1-9]|1[0-2])\/?([0-9]{4}|[0-9]{2})$/;
        
		if (!($('#valid_through').val().match(re))) 
		{
			Checkout.displaywarning('Please enter card Valid through details in mm/yyyy format');
			return false;
		}
		
		var valid_through = $('#valid_through').val().split("/");
		var month = valid_through[0];
		var year = valid_through[1];
		
		var PUBLISHABLE_KEY = $('#PUBLISHABLE_KEY').val();
		var SECRET_KEY = $('#SECRET_KEY').val();
				
		Stripe.setPublishableKey(PUBLISHABLE_KEY);
		
		Stripe.createToken({
			number: $('#card_number').val(),
			cvc: $('#cvv').val(),
			exp_month: month,
			exp_year: year
			}, stripeResponseHandler);
		
		function stripeResponseHandler(status, response) 
		{
			if (response.error) 
			{
				/* $('.error')
					.removeClass('hide')
					.find('.alert')
					.text(response.error.message); */
				alert(response.error.message);
				return false;
			} 
			else 
			{
				var token = response['id'];				
	
				$( ".btn-place-order1" ).prop("disabled", true );
				
				var data={
					customer_id:Checkout.customer_id,
					tableid:Checkout.tableid,
					rest_id:Checkout.restid,
					suggetion:$('.input-suggestion').val(),
					sub_total:$('.item-total').attr('sub_total'),
					discount:$('.total-discount').attr('discount'),
					net_total:$('.net-amount').attr('net_total'),
					supply_option:supplier_option,
					delivery_address:delivery_address,
					card_number : $('#card_number').val(),
					valid_through : $('#valid_through').val(),
					cvv : $('#cvv').val(),
					name_on_card : $('#name_on_card').val(),
					PUBLISHABLE_KEY : $('#PUBLISHABLE_KEY').val(),
					SECRET_KEY : $('#SECRET_KEY').val(),
					token : token,
				};
				/* console.log(data);return false; */
				$('#image-loader').show();
				
				$.ajax({
					url: Checkout.base_url+"checkout/place_order1",
					type:'POST',
					data:data,
					success: function(result)
					{
						$('#image-loader').hide();
						
						if(result.status)
						{
							$('.osahan-checkout').hide();
							$('.div-no-item').hide();
							$('.div-order-success').show();
							$( ".btn-place-order" ).hide();
						   /* Checkout.getCart();*/
						}
						else
						{
							Checkout.displaywarning(result.msg);
						}
					}
				});
			}
		}
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
          customer_id:Checkout.customer_id,
          qty:input.val()
        };
        $.ajax({
            url: Checkout.base_url+"cart/updateCart",
            type:'POST',
            data:data,
            success: function(result){
                $('#image-loader').hide();
                Checkout.loadCartHtml(result);
            }
        });
    },
    getCart:function(){
		debugger;
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
		debugger;
        var html='';
		var html1='<p class="font-weight-bold small mb-2">Addon Details</p>';
        if(Checkout.restid == 103){
            var $currency = 'MZN';
        }
        else{ 
            var $currency = Checkout.currency_symbol; 
        }
        var sub_total=0;
        if(cart.length!=0){
			var k =1; 
            for(i in cart){
               /* if(cart[i].options.offer_id!="" && cart[i].options.offer_id!=undefined cart[i].options.offer_id!=null){

                }else{}*/
                sub_total+=(parseFloat(cart[i].qty)*parseFloat(cart[i].price));
                html+='<div class="list-card gold-members d-flex align-items-center justify-content-between px-3 py-2 border-bottom cart-item" data-id="'+cart[i].options.menu_id+'" rowid-id="'+cart[i].rowid+'" recipe-type="'+cart[i].options.recipe_type+'">\
                  <div class="media align-items-center">\
                        <div class="mr-2 text-danger"> \
                            <a href="#">';
                            var mar_left="";
                            if(cart[i].options.recipe_type=="nonveg"){
                                html+='<img src="'+Checkout.base_url+'assets/web/images/nv.png" alt="" class="cart-details-vegimg">';
                            }
                            else if(cart[i].options.recipe_type=="veg"){
                                html+='<img src="'+Checkout.base_url+'assets/web/images/vg.png" alt="" class="cart-details-vegimg">';
                            }else{
                                mar_left="ml-2 pl-1";
                            }

                            html+='</a>\
                        </div>\
                     <div class="media-body media-menu-name">\
                        <p class="m-0 '+mar_left+' cart-menu-name" name="'+cart[i].name+'">'+cart[i].name+'</p>';
						
					html+='</div>';
					
                  html+='</div>\
                  <div class="d-flex align-items-center">\
                    <span class="count-number float-right cart-items-number d-flex">\
                        <input type="button" value="-" class="btn btn-success btn-sm btn-minus-qty" field="quantity" />\
                        <input type="text" name="quantity" value="'+cart[i].qty+'" class="qty form-control count-number-input" readonly="" value="0" min="0" max="999999"/>\
                        <input type="button" value="+" class="btn btn-success btn-sm btn-plus-qty" field="quantity" style="margin-left: 10px;" />\
                    </span>\
                    <p class="text-gray mb-0 float-right ml-2 text-muted small cart-price" price="'+cart[i].price+'">'+$currency+cart[i].price+'</p>\
                  </div>\
               </div>';
			   if(cart[i].addon.length>0){
			   html1+='<p class="font-weight-bold small mb-2">'+cart[i].name+'</p>';
			   for(j=0;j<cart[i].addon.length;j++){
					html1+='<span>'+cart[i].addon[j].addon_name+'<span class="small text-muted"></span> <span class="float-right text-dark">'+$currency+cart[i].addon[j].addon_price+'</span></span><br>';
				
				}
			   }
            }
			$('#addon_details_show_cart').html(html1);
            $('.cart-item-list').html(html);
            $('.item-total').html($currency+sub_total);
            $('.item-total').attr('sub_total',sub_total);
            $('.total-discount').html($currency+'0');
            $('.total-discount').attr('discount','0');
            /* var cgst = (parseFloat(sub_total)*parseFloat(2.5))/100; */
            var cgst = 0.00;
			
            $('.cgst').attr('cgst_total',cgst.toFixed(2));
            $('.cgst').html($currency+cgst.toFixed(2));
            $('.sgst').attr('sgst_total',cgst.toFixed(2));
            $('.sgst').html($currency+cgst.toFixed(2));
			
            var net_amount = parseFloat(sub_total)+parseFloat(cgst)+parseFloat(cgst);
            $('.net-amount').attr('net_total',net_amount.toFixed(2));
            $('.net-amount').html($currency+net_amount.toFixed(2));
            $('.total_net_amount').val(net_amount.toFixed(2));
        }else{
            $('.osahan-checkout').hide();
            $('.div-no-item').show();
            $('.div-order-success').hide();
        }

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
