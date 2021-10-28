var done_group=new Array();
            $(document).ready(function(){
                $(window).scroll(function(){
                    var target=$('.menu-section-onlyrecipes');
                    target.each(function(e){
                        var self=$(this);
                        var $main_menu_id="<?=$main_menu_id;?>";
                        var $restid=self.attr('restid');
                        var group_id=self.attr('group-id');
                        if(!self.find('.append-group-recipes').html() && $(window).scrollTop()!=0 ){
                            if($.inArray(group_id,done_group)==-1){

                                var scrollTop = $(window).scrollTop(),
                                top_offset=$(this).offset().top-$(this).prev().height(),
                                diff=top_offset-scrollTop;
                                if(Math.ceil(diff)<200){
                                    self.show();
                                    done_group.push(group_id);
                                    self.find('.loader-div').show();
                                    if(is_category_prices==1){
                                        var data={
                                            group_id :group_id,
                                            user_id:$restid,
                                            tablecategory_id:"<?=$tablecategory_id;?>"
                                        }
                                    }else{
                                        var data={
                                             group_id :group_id,
                                             user_id:$restid
                                        }
                                    }
                                    $.ajax({
                                        url: "<?=base_url();?>menus/list_recipes_ofgroup",
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
                                                        html+=get_recipe_html(recipes[i],group_id,$restid,$main_menu_id);
                                                    }
                                                    self.find('.append-group-recipes').html(html);
                                                    self.find('.loader-div').hide();

                                                }
                                            }
                                        }
                                    });
                                    return false;
                                }
                            }
                        }
                    });
                     
                });

                var todays_special_count="<?=count($todays_special);?>";
                if(todays_special_count<=0){
                    var selected_div=$('.menu-section-onlyrecipes').first();
                    load_menu(selected_div);
                }else{
                    if($('.section-todays-special').height()<$(window).height()){
                        var selected_div=$('.menu-section-onlyrecipes').first();
                        var next_group_id=selected_div.attr('group-id');
                        if(next_group_id){
                            load_menu(selected_div);
                        }
                    }
                }

               
            });
            function load_menu(selected_div){
                var $main_menu_id="<?=$main_menu_id;?>";
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
                    if(is_category_prices==1){
                        var data={group_id :group_id,user_id:$restid,tablecategory_id:"<?=$tablecategory_id;?>"}
                    }
                    else{
                        var data={group_id :group_id,user_id:$restid}
                    }
                    $.ajax({
                        url: "<?=base_url();?>menus/list_recipes_ofgroup",
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
                                        html+=get_recipe_html(recipes[i],group_id,$restid,$main_menu_id);
                                    }
                                    selected_div.find('.append-group-recipes').html(html);
                                    var height=$('.menu-navigation').height()+selected_div.height();
                                    selected_div.find('.loader-div').hide();
                                    if(height<$(window).height()){
                                        var second_div=selected_div.next();
                                        var next_group_id=second_div.attr('group-id');
                                        if(next_group_id){
                                            load_menu(second_div);
                                        }
                                    }
                                }
                            }
                        }
                    });
                }
            }
            function capitalize_Words(str)
            {
             return str.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
            }
            function get_recipe_html(recipe,group_id,$restid,$main_menu_id){
                var tableid="<?=$tableid;?>";
                var html='';
                html+='<div class="col-lg-6 col-sm-12 col6-food-menu">\
                    <div class="food-menu">\
                        <div class="row">\
                            <div class="col-3 pr-0">\
                                <div class="col-12 p-0 justify-content-center">';
                                    if(recipe['recipe_image']=="" || recipe['recipe_image']=="assets/images/users/menu.png")
                                        var recipe_image="<?=base_url();?>assets/images/users/menu.png";
                                    else{
                                        var recipe_image=recipe['recipe_image'];
                                    }
                                    if(recipe['recipe_type']=="veg") 
                                        var recipe_type='veg-recipe'; 
                                    else if(recipe['recipe_type']=="nonveg") var recipe_type='nonveg-recipe';
                                    html+='<div class="menu-img '+recipe_type+'" style="background-image:url('+recipe_image+');background-repeat: no-repeat;background-size: cover;background-position: center;">\
                                    </div>\
                                </div>';
                                if($main_menu_id==1){
                                html+='<div class="clearfix"></div>\
                                <div class="col-12 p-0 col-price-12 mt-2">\
                                    <p class="price-meta mb-0">';
                                        if(recipe['price']=='Recipe Price' || recipe['price']==''){
                                            if($restid == 103){ 
                                                $price1 = 'MZN 0.00/-'; }
                                            else if($restid == 134){
                                                $price1 = '$ 0.00/-'; }
                                            else{ $price1='&#8377; 0.00/-'; }
                                        }else{
                                            if($restid == 103){ 
                                                $price1='MZN '+recipe['price']+'/-'; }
                                            else if($restid == 134){
                                                $price1='$ '+recipe['price']+'/-'; }
                                            else { 
                                                $price1='&#8377; '+recipe['price']+'/-'; }
                                        }
                                        
                                    html+=$price1+'</p>\
                                </div>';
                                    }
                            html+='</div>\
                            <div class="col-9 pr-0">\
                                <div class="menu-txt">\
                                    <h3>';
                                    if(tableid!=""){
                                        html+='<a href="<?=base_url();?>menus/view/'+group_id+'/'+recipe['id']+'/'+$restid+'/'+tableid+'" class="food-recipe-name">'+capitalize_Words(recipe['name'])+'</a>';
                                    }else{
                                        html+='<a href="<?=base_url();?>menus/view/'+group_id+'/'+recipe['id']+'/'+$restid+'" class="food-recipe-name">'+capitalize_Words(recipe['name'])+'</a>';
                                    }
                                    html+='</h3>\
                                     \
                                    <ul class="menu-ingredients" recipe-id="'+recipe['id']+'">\
                                        <li class="li-ingredients">';
                                        if(recipe['ingredients_name']!="" || recipe['ingredients_name']!=null)
                                            html+=capitalize_Words(recipe['ingredients_name']);
                                        else
                                            html+=recipe['description'];
                                        html+='</li>';
                                        if($main_menu_id==2){
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
                                        }else{
                                            $best_time_to_eat= recipe['best_time_to_eat'];
                                            if($best_time_to_eat == 'none'){
                                                $best_time_to_eat = '';
                                            }
                                            $best_time_to_eat=$best_time_to_eat.replace('all,', '');
                                            if($best_time_to_eat != ''){ 
                                                html+='<li>\
                                                <span class="badge badge-danger">Best Time To Eat : </span> \
                                                  <small>'+$best_time_to_eat+'</small>\
                                              </li>';
                                            }
                                            if($best_time_to_eat == '' && recipe['ingredients_name']==""){ 
                                                html+='<li class="not-besttime-toeat" style="height: 50px;"></li>';
                                            }
                                            else if(($best_time_to_eat != '' && recipe['ingredients_name']=="")||($best_time_to_eat == '' && recipe['ingredients_name']!="")){ 
                                                html+='<li class="not-besttime-toeat" style="height: 28px;"></li>';
                                            }
                                        }
                                        if(tableid==""){
                                            var mrclass="mr-3";
                                        }else{
                                            var mrclass="";
                                        }
                                        html+='<li class="view-recipe float-right mb-2 '+mrclass+'">';
                                             if(tableid!=""){
                                                html+='<a  class="btn btn-sm btn-success" href="<?=base_url();?>menus/view/'+group_id+'/'+recipe['id']+'/'+$restid+'/'+tableid+'">View</a>';
                                            }else{
                                                 html+='<a class="btn btn-sm btn-success"  href="<?=base_url();?>menus/view/'+group_id+'/'+recipe['id']+'/'+$restid+'">View</a>';
                                            }
                                            if(tableid!=""){
                                            html+='\
                                              <span class="count-number">\
                                                <button type="button" class="btn-sm left dec btn btn-outline-success btn-minus-qty"> \
                                                <i class="feather-minus"></i> \
                                                </button>\
                                                <input class="count-number-input" type="text" readonly="" value="1"  min="1" max="999999">\
                                                <button type="button" class="btn-sm right inc btn btn-outline-success btn-plus-qty"> <i class="feather-plus"></i> </button>\
                                            </span>\
                                            <span class="text-dark mr-3">\
                                                <button href="checkout.html" class="btn btn-outline-success btn-sm btn-add-cart"  data-id="'+recipe['id']+'" price="'+recipe['price']+'" name="'+recipe['name']+'" recipe-type="'+recipe['recipe_type']+'"> ADD</button>\
                                            </span>';
                                        }
                                        html+='</li>\
                                    </ul>\
                                </div> \
                            </div>\
                        </div>\
                    </div>\
                </div>'; 
                return html;
            }