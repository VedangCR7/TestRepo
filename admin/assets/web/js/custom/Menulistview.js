var Menulistview ={
    base_url:null,
    c:null,
    restid:null,
    main_menu_id:null,
    tablecategory_id:null,
    is_category_prices:null,
    customer_id:null,
    todays_special_count:null,
    is_customer_block:null,
    is_table_available:null,
    cart_arr:new Array(),
    //authority:null,
    tableid:null,
    init:function() {
        this.bind_events();
        this.getCartCount();
    },

    bind_events :function() {

        var self=this;
        $(".owl-carousel").owlCarousel({
              autoPlay: 1000,
              loop:true,
              smartSpeed: 650,
              items : 3, // THIS IS IMPORTANT
              responsive : {
                    480 : { items : 3  }
                },
        });
       
        $(window).on('load', function(){ 
            $(".spinner1").fadeOut("fast");
        });
        $('body').on('click','.btn-plus-qty',this.onPlusQty);
        $('body').on('click','.btn-minus-qty',this.onMinusQty);
        $('body').on('click','.btn-add-cart',this.onAddCart);
        $('#input-search').on('keyup',this.onSearchmenu);
        $('#choose_recipetype').on('change',this.onChangerecipetype);
        $('.show_view').on('click',this.onChangelistview);
        $('.a-group-item').on('click',this.listgroupItems);
        $('body').on('click','.show_addon_popup',this.showaddonpopup);
        $('body').on('click','#add_to_cart',this.add_addon_menu);
       
        $(window).scroll(function(){
            var target=$('.menu-section-onlyrecipes');
            Menulistview.onScrollload(target);
        });

        var todays_special_count=Menulistview.todays_special_count;
        if(todays_special_count<=0){
            var selected_div=$('.menu-section-onlyrecipes').first();
            Menulistview.load_menu(selected_div);
        }else{
            if($('.section-todays-special').height()<$(window).height()){
                var selected_div=$('.menu-section-onlyrecipes').first();
                var next_group_id=selected_div.attr('group-id');
                if(next_group_id){
                    Menulistview.load_menu(selected_div);

                }
            }
        }

       
    },
    updateCart:function(select_menu,input)
	{
		debugger;
        $('#image-loader').show();
		
        var data={
            id:select_menu.attr('data-id'),
            rowid:select_menu.attr('rowid'),
            price:select_menu.attr('price'),
            offer_id:select_menu.attr('offer-id'),
            discount_price:select_menu.attr('discount'),
            name:Menulistview.capitalize_Words(select_menu.attr('name')),
            customer_id:Menulistview.customer_id,
            recipe_type:select_menu.attr('recipe-type'),
            qty:input.val(),
            table_id:Menulistview.tableid
        };
		
        if(input.val()==0)
		{
            select_menu.removeAttr('rowid');
        }
		
        $.ajax({
            url: Menulistview.base_url+"cart/addCart",
            type:'POST',
            data:data,
            success: function(result)
			{
                $('#image-loader').hide();
				
                if(result.rowid)
				{
                    select_menu.attr('rowid',result.rowid);

                }
				
                var cart_detials=result.cart_detials;
                var cnt=0;
				
                for(j in cart_detials)
				{
                    cnt=cnt+parseInt(cart_detials[j].qty);
                }
                $('.cart-total-count').html(cnt);
            }
        });
    },
    onAddCart:function(){
        $('#image-loader').show();
        var self=$(this);
        var data={
          id:$(this).attr('data-id'),
          rowid:$(this).attr('rowid'),
          price:$(this).attr('price'),
          name:Menulistview.capitalize_Words($(this).attr('name')),
          customer_id:Menulistview.customer_id,
          qty:$(this).closest('li').find('.count-number-input').val(),
          recipe_type:$(this).attr('recipe-type'),
          table_id:Menulistview.tableid
        };
       
        $.ajax({
            url: Menulistview.base_url+"cart/addCart",
            type:'POST',
            data:data,
            success: function(result){
                $('#image-loader').hide();
                if(result.rowid)
                    self.attr('rowid',result.rowid);
                var cart_detials=result.cart_detials;
                var cnt=0;
                for(j in cart_detials){
                    cnt=cnt+parseInt(cart_detials[j].qty);
                }
                $('.cart-total-count').html(cnt);
               /* $('.cart-total-count').html(result.count);*/
            }
        });
    },
    onPlusQty:function()
	{
		debugger;
        var input=$(this).closest('.count-number').find('.count-number-input');
        var qty=input.val();
        if(qty<1000){
            var inc=parseInt(qty)+1;
            input.val(inc);
        }
        // var select_menu=$(this).closest('li').find('.count-number');
        // Menulistview.updateCart(select_menu,input);
    },
    getCartCount:function(){
        $.ajax({
            url: Menulistview.base_url+"cart/get_cart",
            type:'POST',
            data:{},
            success: function(result){
                var items=result.cart_detials;
                Menulistview.cart_arr=result;
                var cnt=0;
                for(i in items){
                    var data_id=items[i].options.menu_id;
                    var data_offer_id=items[i].options.offer_id;
                    var rowid=items[i].rowid;

                    if(data_offer_id!="" && data_offer_id!=undefined && data_offer_id!=false){
                        $('.offer-section .count-number').each(function(){
                            var attr = $(this).attr('offer-id');
                            if (typeof attr !== typeof undefined && attr !== false) {
                                var offer_id=$(this).attr('offer-id');
                                if(offer_id==data_offer_id){
                                    console.log($(this).attr('discount'),data_offer_id,offer_id);
                                    $(this).attr('rowid',rowid);
                                    $(this).closest('li').find('.count-number-input').val(items[i].qty);
                                }
                            }
                        });
                    }else{
                        $('.all-menus .count-number').each(function(){
                            if($(this).attr('data-id')==data_id){
                                var attr = $(this).attr('offer-id');
                                $(this).attr('rowid',rowid);
                                $(this).closest('li').find('.count-number-input').val(items[i].qty);
                            }
                        });
                    }
                    cnt=cnt+parseInt(items[i].qty);
                }
                $('.cart-total-count').html(cnt);
                /*$('.cart-total-count').html(result.count);*/
            }
        });
    },
    onMinusQty:function(){
        var input=$(this).closest('.count-number').find('.count-number-input');
        var qty=input.val();
        var inc='';
        if(qty>0){
            var inc=parseInt(qty)-1;
            input.val(inc);
        }
        // var select_menu=$(this).closest('li').find('.count-number');
        // Menulistview.updateCart(select_menu,input);
            
             
    },
    capitalize_Words:function(str)
    {
        return str.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
    },
    onScrollload:function(target){
        var done_group=new Array();
        target.each(function(e){
            var self=$(this);
            var $main_menu_id=Menulistview.main_menu_id;
            var $restid=self.attr('restid');
            var group_id=self.attr('group-id');
            if(!self.find('.append-group-recipes').html() && $(window).scrollTop()!=0 ){
                if($.inArray(group_id,done_group)==-1){

                    var scrollTop = $(window).scrollTop(),
                    top_offset=$(this).offset().top-$(this).prev().height(),
                    diff=top_offset-scrollTop;
                    if(Math.ceil(diff)<100){
                        self.show();
                        done_group.push(group_id);
                        self.find('.loader-div').show();
                        if(Menulistview.is_category_prices==1){
                            var data={
                                group_id :group_id,
                                user_id:$restid,
                                tablecategory_id:Menulistview.tablecategory_id,
                                recipetype:$('#choose_recipetype').val()
                            }
                        }else{
                            var data={
                                 group_id :group_id,
                                 user_id:$restid,
                                 recipetype:$('#choose_recipetype').val()
                            }
                        }
                        $.ajax({
                            url: Menulistview.base_url+"menus/list_recipes_ofgroup",
                            type:'POST',
                            dataType: 'json',
                            data: data,
                            success: function(result){
                                if (result.status) { 
                                    if(result.recipes){
                                        var recipes=result.recipes;
                                        self.find('.append-group-recipes').html('');
                                        var html="";
                                        for(i in recipes){
                                            html+=Menulistview.get_recipe_html(recipes[i],group_id,$restid,$main_menu_id);
                                        }
                                        self.find('.append-group-recipes').html(html);
                                        self.find('.loader-div').hide();
                                         Menulistview.updateRowid();

                                    }
                                }
                            }
                        });
                        return false;
                    }
                }
            }
        });
    },
    listgroupItems:function(){
        var self=$(this);
        var href=$(this).attr('href');
        var $main_menu_id=Menulistview.main_menu_id;
        var $restid=$(this).attr('restid');
        var group_id=$(this).attr('group-id');
        var selected_div=$(''+href);
        $('.div-search-list').html('');
        $('#search-list-menu').hide();
        $('#input-search').val('');
        $('.menu-section-recipes').show();
        if(!selected_div.find('.append-group-recipes').html()){
            selected_div.find('.loader-div').show();
            if(Menulistview.is_category_prices==1){
                var data={group_id :group_id,user_id:$restid,recipetype:$('#choose_recipetype').val(),tablecategory_id:Menulistview.tablecategory_id}
            }
            else{
                 var data={group_id :group_id,user_id:$restid,recipetype:$('#choose_recipetype').val()}
            }
            $.ajax({
                url: Menulistview.base_url+"menus/list_recipes_ofgroup",
                type:'POST',
                dataType: 'json',
                data: data,
                success: function(result){
                    if (result.status) { 
                        if(result.recipes){
                            var recipes=result.recipes;
                            selected_div.find('.append-group-recipes').html('');
                            var html="";
                            for(i in recipes){
                                html+=Menulistview.get_recipe_html(recipes[i],group_id,$restid,$main_menu_id);
                            }
                            selected_div.find('.append-group-recipes').html(html);
                            selected_div.find('.loader-div').hide();
                             Menulistview.updateRowid();
                        }
                    }
                }
            });
        }
        $('html, body').animate({
            scrollTop: $(''+href).offset().top -210 
        }, 'fast');
        setTimeout(function () {

        }, 100);
    },
    updateRowid:function(){
        var items=Menulistview.cart_arr.cart_detials;
        for(i in items){
            var data_id=items[i].options.menu_id;
            var data_offer_id=items[i].options.offer_id;
            var rowid=items[i].rowid;

            if(data_offer_id!="" && data_offer_id!=undefined && data_offer_id!=false){
                $('.offer-section .count-number').each(function(){
                    var attr = $(this).attr('offer-id');
                    if (typeof attr !== typeof undefined && attr !== false) {
                        var offer_id=$(this).attr('offer-id');
                        if(offer_id==data_offer_id){
                            console.log($(this).attr('discount'),data_offer_id,offer_id);
                            $(this).attr('rowid',rowid);
                            $(this).closest('li').find('.count-number-input').val(items[i].qty);
                        }
                    }
                });
            }else{
                $('.all-menus .count-number').each(function(){
                    if($(this).attr('data-id')==data_id){
                        var attr = $(this).attr('offer-id');
                        $(this).attr('rowid',rowid);
                        $(this).closest('li').find('.count-number-input').val(items[i].qty);
                    }
                });
            }
            
        }
    },
    onSearchmenu:function(){
        var recipetype=$('#choose_recipetype').val();
        var search=$(this).val();
        if(search=="" && recipetype==""){
            $('.div-search-list').html('');
            $('#search-list-menu').hide();
            $('.menu-section-recipes').show();
        }else{
            var restid=Menulistview.restid;
            var $main_menu_id=Menulistview.main_menu_id;
            if(Menulistview.is_category_prices==1){
                var data={
                    search:search,
                    restid:restid,
                    recipetype:recipetype,
                    main_menu_id:Menulistview.main_menu_id,
                    tablecategory_id:Menulistview.tablecategory_id

                }
            }
            else{
                  var data={
                    search:search,
                    restid:restid,
                    recipetype:recipetype,
                    main_menu_id:Menulistview.main_menu_id
                }
            }
            var self=$(this);
            $('.div-search-list').html('');
            $('.menu-section-recipes').hide();
            $('.section-search-padding').find('.loader-div').show();
            $.ajax({
                url: Menulistview.base_url+"menus/search_recipes_formob",
                type:'POST',
                dataType: 'json',
                data: data,
                success: function(result){
                    if (result.status) { 
                        var recipes=result.recipes;
                        var html="";
                        for(i in recipes){
                            html+=Menulistview.get_recipe_html(recipes[i],recipes[i].group_id,restid,$main_menu_id);
                        }

                        $('.div-search-list').html(html);
                        $('.section-search-padding').find('.loader-div').hide();
                        Menulistview.updateRowid();
                    }
                }
            });
           /* $('.food-recipe-name').each(function(e){
                var name=$(this).html();
                if(name){
                    if (name.toUpperCase().indexOf(search.toUpperCase())>-1){
                        var closest_div=$(this).closest('.col6-food-menu');
                        $('.div-search-list').append(closest_div.clone()).html();
                    }
                }
            });*/
            $('#search-list-menu').show();
        }
        $('html, body').animate({
            scrollTop: $('#search-list-menu').offset().top 
        }, 'fast');
    },

    onChangelistview:function(){
        var main_menu = $(this).attr('main-menu-id');
        var rest_id = $(this).attr('rest-id');
        var is_website = $('#is_website').val();
        var table_id = $(this).attr('table-id');
        var list_view_change = $(this).attr('data-value');
        window.location.href= Menulistview.base_url+'menus/'+main_menu+'/'+rest_id+'/'+table_id+'?recipetype='+$('#choose_recipetype').val()+'&list_view='+list_view_change+'&is_website='+is_website;
    },

    onChangerecipetype:function(){
        //alert($('#show_view').val());
        var main_menu = $(this).attr('main-menu-id');
        var rest_id = $(this).attr('rest-id');
        var table_id = $(this).attr('table-id');
        var is_website = $('#is_website').val();
        window.location.href= Menulistview.base_url+'menus/'+main_menu+'/'+rest_id+'/'+table_id+'?recipetype='+$('#choose_recipetype').val()+'&list_view='+$('#show_view').val()+'&is_website='+is_website;
            // var selected_div=$('.menu-section-onlyrecipes').first();
            //     var next_group_id=selected_div.attr('group-id');
            //     if(next_group_id){
            //         $('.append-group-recipes').html('');
            //         Menulistview.load_menu(selected_div);
            //     }
        // var recipetype=$('#choose_recipetype').val();
        // if(recipetype==""){
        //     $('.div-search-list').html('');
        //     $('#search-list-menu').hide();
        //     $('.menu-section-recipes').show();
        // }else{
        //     var restid=Menulistview.restid;
        //     var $main_menu_id=Menulistview.main_menu_id;
        //     if(Menulistview.is_category_prices==1){
        //         var data={
        //             recipetype:recipetype,
        //             restid:restid,
        //             main_menu_id:Menulistview.main_menu_id,
        //             tablecategory_id:Menulistview.tablecategory_id,
        //         }
        //     }
        //     else{
        //           var data={
        //             recipetype:recipetype,
        //             restid:restid,
        //             main_menu_id:Menulistview.main_menu_id
        //         }
        //     }
        //     var self=$(this);
        //     $('.div-search-list').html('');
        //     $('.menu-section-recipes').hide();
        //     $('.section-search-padding').find('.loader-div').show();
        //     $.ajax({
        //         url: Menulistview.base_url+"menus/search_recipetype_formob",
        //         type:'POST',
        //         dataType: 'json',
        //         data: data,
        //         success: function(result){
        //             if (result.status) { 
        //                 var recipes=result.recipes;
        //                 var html="";
        //                 for(i in recipes){
        //                     html+=Menulistview.get_recipe_html(recipes[i],recipes[i].group_id,restid,$main_menu_id);
        //                 }

        //                 $('.div-search-list').html(html);
        //                 $('.section-search-padding').find('.loader-div').hide();
        //                 Menulistview.updateRowid();
        //             }
        //         }
        //     });
           /* $('.food-recipe-name').each(function(e){
                var name=$(this).html();
                if(name){
                    if (name.toUpperCase().indexOf(search.toUpperCase())>-1){
                        var closest_div=$(this).closest('.col6-food-menu');
                        $('.div-search-list').append(closest_div.clone()).html();
                    }
                }
            });*/
        //     $('#search-list-menu').show();
        // }
        // $('html, body').animate({
        //     scrollTop: $('#search-list-menu').offset().top 
        // }, 'fast');
    },

    get_recipe_html:function(recipe,group_id,$restid,$main_menu_id){
		console.log(recipe);
        //console.log($('.show_view').val());
        var is_website = $('#is_website').val();
        var tableid=Menulistview.tableid;
        //console.log("<?php echo $authority?>");
        var a = $('#authority').val();
        var autho_data =a.split(',');
        
        var html='';
        html+='<div class="list-card col-lg-6 col-sm-12 col6-food-menu">\
            <div class="food-menu food-menu1" style="min-height:20px !important;">\
                <div class="row">';
                    //<div class="col-3 pr-0">';
                        // <div class="col-12 p-0 justify-content-center">';
                        //     if(recipe['recipe_image']=="" || recipe['recipe_image']=="assets/images/users/menu.png")
                        //         var recipe_image=Menulistview.base_url+"assets/images/users/menu.png";
                        //     else{
                        //         var recipe_image=recipe['recipe_image'];
                        //     }
                        //     if(recipe['recipe_type']=="veg") 
                        //         var recipe_type='veg-recipe'; 
                        //     else if(recipe['recipe_type']=="nonveg") var recipe_type='nonveg-recipe';
                        //      if(tableid!=""){
                        //                 html+='<a href="'+Menulistview.base_url+'menus/view/'+group_id+'/'+recipe['id']+'/'+$restid+'/'+tableid+'"><div class="menu-img '+recipe_type+'" style="background-image:url('+recipe_image+');background-repeat: no-repeat;background-size: cover;background-position: center;">\
                        //     </div></a>';
                        //             }else{
                        //                  html+='<a href="'+Menulistview.base_url+'menus/view/'+group_id+'/'+recipe['id']+'/'+$restid+'"><div class="menu-img '+recipe_type+'" style="background-image:url('+recipe_image+');background-repeat: no-repeat;background-size: cover;background-position: center;">\
                        //     </div></a>';
                        //             }
                        //     html+='</div>';
                       /* if($main_menu_id==1){*/
                        // html+='<div class="clearfix"></div>\
                        // <div class="col-12 p-0 col-price-12 mt-4">\
                        //     <p class="price-meta mb-0">';
                        //         if(recipe['price']=='Recipe Price' || recipe['price']==''){
                        //             if($restid == 103){ 
                        //                 $price1 = 'MZN 0.00/-'; }
                        //             else if($restid == 134){
                        //                 $price1 = '$ 0.00/-'; }
                        //             else{ $price1='&#8377; 0.00/-'; }
                        //         }else{
                        //             if($restid == 103){ 
                        //                 $price1='MZN '+recipe['price']+'/-'; }
                        //             else if($restid == 134){
                        //                 $price1='$ '+recipe['price']+'/-'; }
                        //             else { 
                        //                 $price1='&#8377; '+recipe['price']+'/-'; }
                        //         }
                                
                        //     html+=$price1+'</p>\
                        // </div>';
                          /*  }*/
                    //html+='</div>\
                    html+='<div class="col-12 pr-0">\
                        <div class="menu-txt">\
                            <h3>';
                            if(tableid!=""){
                                if(recipe['recipe_type']=="veg"){
                                    html+='<img src="'+Menulistview.base_url+'assets/images/Veg.png" style="width:10px;height:10px;">&nbsp;';
                                }
                                if(recipe['recipe_type']=="nonveg"){
                                    html+='<img src="'+Menulistview.base_url+'assets/images/NonVeg.png" style="width:10px;height:10px;">&nbsp;';
                                }
                                html+='<a href="'+Menulistview.base_url+'menus/view/'+group_id+'/'+recipe['id']+'/'+$restid+'/'+tableid+'?is_website='+is_website+'" class="food-recipe-name">'+Menulistview.capitalize_Words(recipe['name'])+'</a>';
                            }else{
                                html+='<a href="'+Menulistview.base_url+'menus/view/'+group_id+'/'+recipe['id']+'/'+$restid+'/0" class="food-recipe-name">'+Menulistview.capitalize_Words(recipe['name'])+'</a>';
                            }
                            html+='</h3>\
                             \
                            <ul class="menu-ingredients" recipe-id="'+recipe['id']+'" style="min-height:3px !important;padding:0px !important;margin-top:-20px;">';
                                //<li class="li-ingredients">';
                                // if(recipe['ingredients_name']!="" && recipe['ingredients_name']!=null)
                                //     html+=Menulistview.capitalize_Words(recipe['ingredients_name']);
                                // else if(recipe['description']!=null)
                                //     html+=recipe['description'];
                                // html+='</li>';
                                /*if($main_menu_id==2){
                                    var $multi_prices=new Array();
                                    if(recipe['price'] !='' && recipe['quantity'] != ''){
                                        $multi_prices[recipe['quantity']]= recipe['price']; 
                                    }
                                    
                                    if(recipe['price1'] !='' && recipe['quantity1'] !=''){
                                        $multi_prices[recipe['quantity1']] = recipe['price1'];
                                    }
                                        
                                    if(recipe['price2'] !='' && recipe['quantity2'] !=''){
                                        $multi_prices[recipe['quantity2']] = recipe['price2'];
                                    }
                                        
                                    if(recipe['price3'] !='' && recipe['quantity3'] !=''){
                                        $multi_prices[recipe['quantity3']] = recipe['price3'];
                                    }
                                       
                                    if($restid == 103){
                                        var $currency = 'MZN';
                                    }
                                    else if($restid == 134){
                                        var $currency = '$';
                                    } 
                                    else{ 
                                        var $currency = '&#8377;'; 
                                    }
                                    $bar_prices="";
                                    for($k in $multi_prices) { 
                                        $bar_prices = "<b>"+$k+" :</b>  "+$currency+$multi_prices[$k]+"/-"; 
                                        html+='<li class="bar-price">'+$bar_prices+'</li>';
                                    } 
                                }else{*/
                                    $best_time_to_eat= recipe['best_time_to_eat'];
                                    if($best_time_to_eat == 'none'){
                                        $best_time_to_eat = '';
                                    }
                                    if($best_time_to_eat == "null"){
                                        $best_time_to_eat = '';
                                    }
                                    if($best_time_to_eat == null){
                                        $best_time_to_eat = '';
                                    }
                                    $best_time_to_eat=$best_time_to_eat.replace('all,', '');
                                    if($best_time_to_eat != ''){ 
                                      //   html+='<li>\
                                      //   <span class="badge badge-danger">Best Time To Eat : </span> \
                                      //     <small>'+$best_time_to_eat+'</small>\
                                      // </li>';
                                    }
                                    if($best_time_to_eat == '' && recipe['ingredients_name']==""){ 
                                        // html+='<li class="not-besttime-toeat" style="height: 50px;"></li>';
                                    }
                                    else if(($best_time_to_eat != '' && recipe['ingredients_name']=="")||($best_time_to_eat == '' && recipe['ingredients_name']!="")){ 
                                        // html+='<li class="not-besttime-toeat" style="height: 28px;"></li>';
                                    }
                                /*}*/
                                if(tableid==""){
                                    var mrclass="mr-3";
                                }else{
                                    var mrclass="";
                                }
                                html+='<li class="view-recipe float-right'+mrclass+'" style="width:100%;">';
                                    html+='<span class="price-meta mb-0 float-left pricecss" style="color:#C70039;margin-top:15px;width:80%">';
                                if(recipe['price']=='Recipe Price' || recipe['price']==''){
                                    if($restid == 103){ 
                                        $price1 = 'MZN 0.00/-'; }
                                    else if($restid == 134){
                                        $price1 = '$ 0.00/-'; }
                                    else{ $price1= Menulistview.currency_symbol+' 0.00/-'; }
                                }else{
                                    if(recipe['discount']!= null && recipe['offer_status'] == 1){
                                        if(recipe['discount_type'] == 'Flat'){
											$discount_price = parseInt(recipe['price']) - parseInt(recipe['discount']);
										}else{
											$discount_price = parseInt(recipe['price'])-((parseInt(recipe['price']) * parseInt(recipe['discount']))/100);
										}
                                        if($restid == 103){ 
                                            $price1='MZN '+$discount_price+'/-'; }
                                        else if($restid == 134){
                                            $price1='$ '+$discount_price+'/-'; }
                                        else { 
                                            $price1= Menulistview.currency_symbol+' '+$discount_price+'/-'; }
                                    }
                                    else{
                                        $discount_price = recipe['price'];
                                        if($restid == 103){ 
                                            $price1='MZN '+recipe['price']+'/-'; }
                                        else if($restid == 134){
                                            $price1='$ '+recipe['price']+'/-'; }
                                        else { 
                                            $price1= Menulistview.currency_symbol+' '+recipe['price']+'/-'; }
                                    }
                                }
                                
                            html+=$price1+'</span>';
                                    //  if(tableid!=""){
                                    //     html+='<a  class="btn btn-sm btn-success" href="'+Menulistview.base_url+'menus/view/'+group_id+'/'+recipe['id']+'/'+$restid+'/'+tableid+'">View</a>';
                                    // }else{
                                    //      html+='<a class="btn btn-sm btn-success"  href="'+Menulistview.base_url+'menus/view/'+group_id+'/'+recipe['id']+'/'+$restid+'">View</a>';
                                    // }
                                    if(tableid!=""){
                                        if(is_website == ''){
                                        if(Menulistview.is_customer_block==0 && autho_data.indexOf("Online order") !== -1 && autho_data.indexOf("Table Management") !== -1){
                                            html+=' <span class="btn btn-sm btn-success show_addon_popup text-white" recipe-id="'+recipe['id']+'" group-id="'+group_id+'" restaurant_id="'+$restid+'">Add</span>';


                                        }else{
                                             $('.view-recipe').addClass('mr-3');
                                        }
                                    }
                                    else{
                                        if(Menulistview.is_customer_block==0 && autho_data.indexOf("Online order") !== -1 && autho_data.indexOf("Table Management") !== -1){
                                            
                                            html+=' <span class="btn btn-sm btn-success show_addon_popup text-white" recipe-id="'+recipe['id']+'" group-id="'+group_id+'" restaurant_id="'+$restid+'">Add</span>';

                                        }else{
                                             $('.view-recipe').addClass('mr-3');
                                        }
                                    }
                                    /* <span class="text-dark mr-3">\
                                        <button href="checkout.html" class="btn btn-outline-success btn-sm btn-add-cart"  data-id="'+recipe['id']+'" price="'+recipe['price']+'" name="'+recipe['name']+'" recipe-type="'+recipe['recipe_type']+'"> ADD</button>\
                                    </span>*/
                                }
                                html+='</li>\
                            </ul>\
                        </div> \
                    </div>\
                </div>\
            </div>\
        </div>'; 
        return html;

    },
    showaddonpopup:function()
	{
		debugger;
        var recipe_id = $(this).attr('recipe-id');
		var group_id = $(this).attr('group-id');
        var input=$('#show_addcart_button').find('.count-number-input');
        var qty=input.val();
        
        //var row_id = $(this).closest('.food-menu').find('.count-number').attr('rowid');
        //var main_item_price = $(this).closest('.food-menu').find('.count-number').attr('price');
        //recipe_id = $(this).attr('recipe-id');
        $.ajax({
            url: Menulistview.base_url+"menus/get_addon_details",
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
                <span style="float:right;"><button class="btn btn-success " id="add_to_cart">Add to cart</button></span>\
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
        //     Menulistview.displaywarning("Please select atleast one addon item");
        //     return false;
        // }

	if(qty<=0){
             Menulist.displaywarning("Please select Quantity");
             return false;
        }

        debugger;
        $('#image-loader').show();
        
		var data={
            id:$('#recipe_id').val(),
            rowid:'',
            price:$('#main_item_price').val(),
            offer_id:$('#offer_id').val(),
            discount_price:$('#discount_price').val(),
            name:Menulistview.capitalize_Words($('#recipe_name').val()),
            customer_id:Menulistview.customer_id,
            recipe_type:$('#recipe_type').val(),
            qty:input.val(),
            table_id:Menulistview.tableid,
            addon:addon,
            addonprice:addonprice,
            addon_id:addon_id,
            addon_main_category:addon_main_category,
            comment:$('#comment').val()
        };
		
        $.ajax({
            url: Menulistview.base_url+"cart/addCart",
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
    
    load_menu:function(selected_div){
        var $main_menu_id=Menulistview.main_menu_id;
        var $restid=selected_div.attr('restid');
        var group_id=selected_div.attr('group-id');
        $('.div-search-list').html('');
        $('#search-list-menu').hide();
        $('#input-search').val('');
        if($(selected_div).is(':first-child'))
            $(selected_div).addClass('section-padding');
        $(selected_div).show();
        if(!selected_div.find('.append-group-recipes').html()){
            selected_div.find('.loader-div').show();
            if(Menulistview.is_category_prices==1){
                var data={group_id :group_id,user_id:$restid,recipetype:$('#choose_recipetype').val(),tablecategory_id:Menulistview.tablecategory_id}
            }
            else{
                var data={group_id :group_id,user_id:$restid,recipetype:$('#choose_recipetype').val()}
            }
            $.ajax({
                url: Menulistview.base_url+"menus/list_recipes_ofgroup",
                type:'POST',
                dataType: 'json',
                data: data,
                success: function(result){
                    if (result.status) { 
                        if(result.recipes){
                            // $('.append-group-recipes').html('');
                            var recipes=result.recipes;
                            selected_div.find('.append-group-recipes').html('');
                            var html="";
                            for(i in recipes){
                                html+=Menulistview.get_recipe_html(recipes[i],group_id,$restid,$main_menu_id);
                            }
                            selected_div.find('.append-group-recipes').html(html);
                            var height=$('.menu-navigation').height()+selected_div.height();
                            selected_div.find('.loader-div').hide();
                            if(height<($(window).height()+200)){
                                var second_div=selected_div.next();
                                var next_group_id=second_div.attr('group-id');
                                if(next_group_id){
                                    Menulistview.load_menu(second_div);
                                }
                            }
                            Menulistview.updateRowid();
                        }
                    }
                }
            });
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
