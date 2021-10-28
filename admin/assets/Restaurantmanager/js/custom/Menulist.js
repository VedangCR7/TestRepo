var Menulist ={
    base_url:null,
    cart_arr:new Array(),
    init:function() {
        this.bind_events();
        this.getCartCount();
        this.load_menu($('#table_number').val());
        //this.load_details($('#table_number').val());

    },

    bind_events :function() {

        var self=this;
       
        $(window).on('load', function(){ 
            $(".spinner1").fadeOut("fast");
        });
        $('body').on('click','.btn-plus-qty',this.onPlusQty);
        $('body').on('click','.btn-minus-qty',this.onMinusQty);
        //$('body').on('click','.btn-add-cart',this.onAddCart);
        $('.a-group-item').on('click',this.listgroupItems);
        $('body').on('click','.show_addon_popup',this.showaddonpopup);
        $('body').on('click','#add_to_cart',this.add_addon_menu);
        $('#input-search').on('keyup',this.onSearchmenu);
        $('.contact_no').on('change',this.onSearchcustomer);
        //$('#cust_name').on('change','.name',this.onupdatecustomer);
        $('#table_number').on('change',this.selectedtable);
        $('#changelink').on('click',this.changecartlink); 
        $(window).scroll(function(){
            Menulist.onScrollload();
        }); 
    },

    changecartlink:function(){
        var customer_name = $('.name').val();
        var customer_contact = $('.contact_no').val();
        var table = $('#table_number').val();
        if ($('.name').val()!= '' && $('.contact_no').val()!= '') {
            if (table !='') {
                window.location.replace(Menulist.base_url+"restaurant_managerorder/viewcart/"+customer_name+"/"+table+"/"+customer_contact);
            }
            else{
                Menulist.displaywarning("Select Table");
            }
        }
        else{
            Menulist.displaywarning("Fill customer details");
        }
    },

    getCartCount:function(){
        $.ajax({
            url: Menulist.base_url+"cart/get_cart",
            type:'POST',
            data:{},
            success: function(result){
                var cnt=0;
                var items=result.cart_detials;
                Menulist.cart_arr=result;
                for(i in items){
                    var data_id=items[i].options.menu_id;
                    var rowid=items[i].rowid;
                    var customer_name=items[i].options.customer_name;
                    var customer_contact=items[i].options.customer_contact;
                    var table_number=items[i].options.table_no;
                    $('.count-number').each(function(){
                        if($(this).attr('data-id')==data_id){
                            $(this).attr('rowid',rowid);
                            $(this).closest('li').find('.count-number-input').val(items[i].qty);
                        }
                    });
                    cnt=cnt+parseInt(items[i].qty);
                }
                $('.cart-total-count').html(cnt);
                //console.log(customer_name);
                if (result.count>0) {
                $('.contact_no').attr('readonly','readonly');
                $('.contact_no').val(customer_contact);
                $('.name').attr('readonly','readonly');
                $('.name').val(customer_name);
                }
                //alert(table_number);
                Menulist.gettable(table_number);
            }
        });
    },

    gettable:function(table){
        //alert($('.not_all_table').val());
        $.ajax({
            url: Menulist.base_url+"restaurant_managerorder/gettable",
            type:'POST',
            success: function(result){
                var html = '';
                if ($('.not_all_table').val() == undefined) {
                    html +='<option value="">Select Table Number</option>';
                for(i=0;i<result.length;i++){
                    if (result[i].table_detail_id == table) {
                        html+='<option value="'+result[i].table_detail_id+'" selected>'+result[i].title+'</option>'
                    }
                    else{
                        html += '<option value="'+result[i].table_detail_id+'">'+result[i].title+'</option>'
                    }
                }
                $('#table_number').html(html);
                }else{
                //alert($('.not_all_table').val());
                for(i=0;i<result.length;i++){
                    if (result[i].table_detail_id == table) {
                        html+='Table Number : <input type="hidden" name="" value="'+result[i].table_detail_id+'" readonly="" id="table_number" class="shadow-sm p-2 mb-2 bg-white not_all_table" style="border:none"><input type="text" name="" value="'+result[i].title+'" readonly="" class="shadow-sm p-2 mb-2 bg-white" style="border:none">'
                    }
                }
                $('#show_table_no').html(html);
        //alert(table);
        }
                Menulist.load_menu($('#table_number').val());
            }
        });
    },

    updateRowid:function(){
        
        var items=Menulist.cart_arr.cart_detials;
        for(i in items){
            var data_id=items[i].options.menu_id;
            var rowid=items[i].rowid;
            $('.count-number').each(function(){
                if($(this).attr('data-id')==data_id){
                    $(this).attr('rowid',rowid);
                    $(this).closest('li').find('.count-number-input').val(items[i].qty);
                }
            });
        }
    },

    onPlusQty:function(){
        var customer_name = $('.name').val();
        var customer_contact = $('.contact_no').val();
        if (customer_name!='' && customer_contact!='') {
        var input=$(this).closest('.count-number').find('.count-number-input');
        var qty=input.val();
        if(qty<1000){
            var inc=parseInt(qty)+1;
            input.val(inc);
        }
        // var select_menu=$(this).closest('li').find('.count-number');
        // Menulist.updateCart(select_menu,input);
        }else{
            Menulist.displaywarning("Fill customer details");
        }
    },

    onMinusQty:function(){
        var input=$(this).closest('.count-number').find('.count-number-input');
        var qty=input.val();
        if(qty>0){
            var inc=parseInt(qty)-1;
            input.val(inc);
        }
        // var select_menu=$(this).closest('li').find('.count-number');
        // Menulist.updateCart(select_menu,input);
    },

    updateCart:function(select_menu,input){
        $('#image-loader').show();
        //console.log(select_menu);
        var data={
            id:select_menu.attr('data-id'),
            rowid:select_menu.attr('rowid'),
            price:select_menu.attr('price'),
            name:select_menu.attr('name'),
            customer_name:$('.name').val(),
            table_number:$('#table_number').val(),
            customer_contact:$('.contact_no').val(),
            recipe_type:select_menu.attr('recipe-type'),
            qty:input.val(),
        };
        //console.log(data);
        if(input.val()==0){
            select_menu.removeAttr('rowid');
        }
        $.ajax({
            url: Menulist.base_url+"cart/addCart",
            type:'POST',
            data:data,
            success: function(result){
                $('#image-loader').hide();
                if(result.rowid)
                    select_menu.attr('rowid',result.rowid);
                var cart_detials=result.cart_detials;
                var cnt=0;
                for(j in cart_detials){
                    cnt=cnt+parseInt(cart_detials[j].qty);
                }
                $('.cart-total-count').html(cnt);
            }
        });
    },

    onSearchcustomer:function(){
        if ($('.contact_no').val().length<8 || $('.contact_no').val().length>14) {
            Menulist.displaywarning('Mobile number should accept 8 to 14 digits');
            return false;
        }
        $('#image-loader').show();
        $.ajax({
            url: Menulist.base_url+"restaurant_managerorder/customer",
            type:'POST',
            data:{'contact_no':$('.contact_no').val()},
            success: function(result){
                //console.log(result);
                $('#image-loader').hide();
                if (result.name == "") {
                    $('#cust_name').html('<input type="text" name="name" id="name" class="form-control name shadow-sm p-2 mb-2 bg-white" placeholder="Customer Name" style="border:none">');
                }
                else{
                    $('#cust_name').html('<input type="text" value="'+result.name+'" name="name" id="name" class="name form-control shadow-sm p-2 mb-2 bg-white" placeholder="Customer Name" style="border:none">');
                }
            }
        });
    },

    onupdatecustomer:function(){
        $('#image-loader').show();
        $.ajax({
            url: Menulist.base_url+"restaurant_managerorder/customer_update",
            type:'POST',
            data:{'name':$('.name').val(),'id':$('.customer_id').val()},
            success: function(result){
                $('#image-loader').hide();
                if(result.status){
                    Menulist.onSearchcustomer();
                }
            }
        });
    },

    onSearchmenu:function(){
        var table_no =$('#table_number').val();
        var search=$('#input-search').val();
      
        Menulist.load_menu(table_no,search);
        
    },

    selectedtable:function(){
        //var unsetdata= '<?php $this->session->unset_userdata("cart_contents") ?>'
        $.ajax({
            url: Menulist.base_url+"restaurant_managerorder/unsetcartcontents",
            type:'POST',
            success: function(result){
                var table_no =$('#table_number').val();
                Menulist.load_menu(table_no);
                $('.cart-total-count').html(0);
                //Menulist.getCartCount();
            }
        });
    },

    onScrollload:function(search = ''){
        
    },

    load_menu:function(table_no = '',search = '')
	{
		debugger;
        var table_no =$('#table_number').val();
        //alert(table_no);
        if (table_no != '') {
        $('#image-loader').show();
        $.ajax({
            url: Menulist.base_url+"restaurant_managerorder/all_recipes",
            type:'POST',
            dataType: 'json',
            data :{tablecat_id : table_no,search_recipe : search},
            success: function(response){
				console.log(response);
                $('#image-loader').hide();
                var html = '';
                for (var i = 0; i < response.length; i++) {
                    if(response[i].discount != null && response[i].offer_status == 1){
						if(response[i].discount_type == 'Flat'){
							$discount_price = parseInt(response[i].price)-parseInt(response[i].discount);
						}else{
							$discount_price = parseInt(response[i].price)-((parseInt(response[i].price) * parseInt(response[i].discount))/100);
						}
					}
                    else{
                        $discount_price = response[i].price;
                    }
                    html += '<div class="list-card gold-members d-flex align-items-center justify-content-between px-3 py-2 border-bottom">\
                  <div class="media align-items-center" style="width:50%">\
                     <div class="mr-2 text-danger">';
                    if (response[i].recipe_type == 'nonveg') {
                    html +='<img src="'+Menulist.base_url+'assets/web/images/nv.png" height="10px" width="10px" style="width:30px;height:30px;">';
                    }
                    if (response[i].recipe_type == 'veg'){
                    html +='<img src="'+Menulist.base_url+'assets/web/images/vg.png" height="10px" width="10px" style="width:30px;height:30px;">';
                    }
                    html +='</div>\
                     <div class="media-body">\
                        <p class="m-0 menuname">'+Menulist.capitalize_Words(response[i].name)+'</p>\
                     </div>\
                  </div>\
                  <div class="d-flex align-items-center">\
                  <p class="text-gray mb-0 float-right text-muted small" style="margin-right:15px;">'+Menulist.currency_symbol+' '+$discount_price+'</p>\
                  <span class="btn btn-sm btn-success show_addon_popup" recipe-id="'+response[i].id+'" group-id="'+response[i].group_id+'">Add</span>\
                  </div>\
               </div>';
                }

                $('#show_all_recipes').html(html);
                $.ajax({
                    url: Menulist.base_url+"cart/get_cart",
                    type:'POST',
                    data:{},
                    success: function(result){
                        var cnt=0;
                        var items=result.cart_detials;
                        Menulist.cart_arr=result;
                        for(i in items){
                            var data_id=items[i].options.menu_id;
                            var rowid=items[i].rowid;
                            var customer_name=items[i].options.customer_name;
                            var customer_contact=items[i].options.customer_contact;
                            var table_number=items[i].options.table_no;
                            $('.count-number').each(function(){
                                if($(this).attr('data-id')==data_id){
                                    $(this).attr('rowid',rowid);
                                    $(this).closest('li').find('.count-number-input').val(items[i].qty);
                                }
                            });
                            cnt=cnt+parseInt(items[i].qty);
                        }
                        $('.cart-total-count').html(cnt);
                        //console.log(customer_name);
                        if (result.count>0) {
                        $('.contact_no').attr('readonly','readonly');
                        $('.contact_no').val(customer_contact);
                        $('.name').attr('readonly','readonly');
                        $('.name').val(customer_name);
                        }
                        //alert(table_number);
                        Menulist.updateRowid();
                    }
                });
               
                //Menulist.getCartCount()
                $('.osahan-checkout').css('display','block');
                $('.showsearch').css('display','block');              
            }
        });
    }
    else{
        $('.osahan-checkout').css('display','none');
        $('.showsearch').css('display','none');
    }
    },

    showaddonpopup:function()
	{
        recipe_id = $(this).attr('recipe-id');
		group_id = $(this).attr('group-id');
        var input=$('#show_addcart_button').find('.count-number-input');
        var qty=input.val();
        
		var contact_no = $('#contact_no').val();
		var contact_name = $('#name').val();
		
		if(contact_no=="" || contact_name=="")
		{
			Menulist.displaywarning("Please insert cusmter name and mobile number");
			return false;
		}
		
        //var row_id = $(this).closest('.food-menu').find('.count-number').attr('rowid');
        //var main_item_price = $(this).closest('.food-menu').find('.count-number').attr('price');
        //recipe_id = $(this).attr('recipe-id');
        $.ajax({
            url: Menulist.base_url+"menus/get_addon_details",
            type:'POST',
            dataType: 'json',
            data: {recipe_id:recipe_id,group_id:group_id},
            success: function(result){
                $('#addon_menu_items').html('');
                var html = '';
                if(result[0].discount != null){
					if(result[0].discount_type == 'Flat'){
						$discount_price = parseInt(result[0].recipe_price) - parseInt(result[0].discount);
					}else{
						$discount_price = parseInt(result[0].recipe_price)-((parseInt(result[0].recipe_price) * parseInt(result[0].discount))/100);
					}
                    //$discount_price = parseInt(result[0].discount)+parseInt(result[0].recipe_price);
                }else{
                    $discount_price = result[0].recipe_price;
                }
                console.log(result);
                for (var i = 0; i < result.length; i++) {
                    html+='<div class="row">\
                            <input type="hidden" value="'+result[i].recipe_id+'" id="recipe_id" name="recipe_id">\
                            <input type="hidden" value="'+result[i].recipe_name+'" id="recipe_name" name="recipe_id">\
                            <input type="hidden" value="'+$discount_price+'" id="main_item_price" name="">\
                            <input type="hidden" value="'+result[i].recipe_type+'" id="recipe_type" name="">\
                            <input type="hidden" value="'+result[i].discount+'" id="discount_price" name="">\
                            <input type="hidden" value="'+result[i].offer_id+'" id="offer_id" name="">\
                    </div>';

                    if(result[i].addon_id >0 )
                    {
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
                html +='<div class="row">\
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12"><label style="color:black;font-weight:bold;">Comment</label></div>\
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12"><textarea rows="3" id="comment" placeholder="Enter Comment"></textarea></div>\
                </div>';
                var html1='';
                html1+='<span class="count-number mr-3 cart-items-number d-flex" style="float:left" data-id="'+result[0].recipe_id+'" price="'+$discount_price+'" name="'+result[0].recipe_name+'" recipe-type="'+result[0].recipe_type+'">\
                <input type="button" value="-" class="btn btn-success btn-sm btn-minus-qty" field="quantity" />\
                <input type="text" name="quantity" value="1" class="qty form-control count-number-input" readonly="" value="0" min="0" max="999999"/>\
                <input type="button" value="+" class="btn btn-success btn-sm btn-plus-qty" field="quantity" style="margin-left: 10px;" />\
            </span>\
                <span style="float:right"><button class="btn btn-success " id="add_to_cart">Add to cart</button></span>\
            '
                $('#addon_menu_items').html(html);
				$('#receipe_name').html(result[0].recipe_name);
                $('#show_addcart_button').html(html1);
                $('#addonmodel').modal('show');
            }
        });
    },
	
    add_addon_menu:function(){
        var input=$('#show_addcart_button').find('.count-number-input');
        var qty=input.val();
        var addon = [];
        var addonprice =[];
        var addon_main_category =[];
        var addon_id =[];
        $('input[class="option_name"]:checked').each(function() {
            addon.push(this.value);
            addonprice.push($(this).attr('optionprice'));
            addon_id.push($(this).attr('optionid'));
            addon_main_category.push($(this).attr('optionmaincategory'));
        });

        // if(addon.length<=0){
        //     Menulist.displaywarning("Please select atleast one addon item");
        //     return false;
        // }

        debugger;
        $('#image-loader').show();
        
		var data={
            id:$('#recipe_id').val(),
            rowid:'',
            price:$('#main_item_price').val(),
            offer_id:$('#offer_id').val(),
            discount_price:$('#discount_price').val(),
            name:Menulist.capitalize_Words($('#recipe_name').val()),
            recipe_type:$('#recipe_type').val(),
            qty:input.val(),
            //table_id:Menulist.tableid,
            addon:addon,
            addonprice:addonprice,
            addon_id:addon_id,
            addon_main_category:addon_main_category,
            comment:$('#comment').val(),
            customer_name:$('.name').val(),
            table_number:$('#table_number').val(),
            customer_contact:$('.contact_no').val(),
        };
		
        $.ajax({
            url: Menulist.base_url+"cart/addCart",
            type:'POST',
            data:data,
            success: function(result){
                console.log(result);
                $('#image-loader').hide();
				
                if(result.rowid)
				{
                    //$.attr('rowid',result.rowid);
                }
				
                var cart_detials=result.cart_detials;
                var cnt=0;
                
				for(j in cart_detials)
				{
                    cnt=cnt+parseInt(cart_detials[j].qty);
                }
                $('.cart-total-count').html(cnt);
                $('#addonmodel').modal('hide');
            }
        });


    },
    

    

    load_details:function(table_no){
        //var unsetdata= '<?php $this->session->unset_userdata("cart_contents") ?>'
        $.ajax({
            url: Menulist.base_url+"restaurant_managerorder/check_table_available",
            type:'POST',
            data:{table_no:table_no},
            success: function(result){
                console.log(result);
                if (result.available) {
                    Menulist.load_menu($('#table_number').val());
                }
                else{
                    Menulist.availableorder($('#table_number').val());
                }
            }
        });
    },

    availableorder:function(table_no){
        
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
    }
};
