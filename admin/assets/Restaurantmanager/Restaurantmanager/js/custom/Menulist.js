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
        var input=$(this).closest('.count-number').find('.count-number-input');
        var qty=input.val();
        if(qty<1000){
            var inc=parseInt(qty)+1;
            input.val(inc);
        }
        var select_menu=$(this).closest('li').find('.count-number');
        Menulist.updateCart(select_menu,input);
    },

    onMinusQty:function(){
        var input=$(this).closest('.count-number').find('.count-number-input');
        var qty=input.val();
        if(qty>0){
            var inc=parseInt(qty)-1;
            input.val(inc);
        }
        var select_menu=$(this).closest('li').find('.count-number');
        Menulist.updateCart(select_menu,input);
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

    load_menu:function(table_no = '',search = ''){
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
                $('#image-loader').hide();
                var html = '';
                for (var i = 0; i < response.length; i++) {
                    html += '<div class="gold-members d-flex align-items-center justify-content-between px-3 py-2 border-bottom">\
                  <div class="media align-items-center" style="width:50%">\
                     <div class="mr-2 text-danger">';
                    if (response[i].recipe_type == 'nonveg') {
                    html +='<img src="'+Menulist.base_url+'assets/web/images/nv.png" height="10px" width="10px">';
                    }
                    if (response[i].recipe_type == 'veg'){
                    html +='<img src="'+Menulist.base_url+'assets/web/images/vg.png" height="10px" width="10px">';
                    }
                    html +='</div>\
                     <div class="media-body">\
                        <p class="m-0 menuname">'+Menulist.capitalize_Words(response[i].name)+'</p>\
                     </div>\
                  </div>\
                  <div class="d-flex align-items-center">\
                  <p class="text-gray mb-0 float-right text-muted small">&#8377; '+response[i].price+'</p>\
                  <li class="view-recipe float-right mb-2"><span class="count-number float-right ml-2" data-id="'+response[i].id+'" price="'+response[i].price+'" name="'+response[i].name+'" recipe-type="'+response[i].recipe_type+'"><button type="button" class="btn-sm left dec btn btn-outline-success btn-minus-qty"> <i class="feather-minus"></i> </button><input class="count-number-input" type="text" readonly="" value="0" min="1" max="999999"><button type="button" class="btn-sm right inc btn btn-outline-success btn-plus-qty"> <i class="feather-plus"></i> </button></span></li>\
                  </div>\
               </div>';
                }

                $('#show_all_recipes').html(html);
                Menulist.updateRowid();
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
