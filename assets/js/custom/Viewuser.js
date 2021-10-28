var Viewuser ={
    base_url:null,
    user_id:null,
    init:function() {
        this.bind_events();
        var data={
            per_page : 30,
            page:1,
            user_id:Viewuser.user_id
        }
        this.listRecipes(data);
    },

    bind_events :function() {
        var self=this;
        $('#searchRecipeInput').on('keyup',function(){
            if($(this).val()==""){
                var data={
                    per_page:$('.dropdown-toggle').attr('selected-per-page'),
                    page:1,
                    user_id:Viewuser.user_id
                }
            }else{
                var data={
                    per_page:'all',
                    page:1,
                    user_id:Viewuser.user_id
                }
            }
          
            Viewuser.listRecipes(data,'fromsearch');

        });
        $('.a-recipe-perpage').on('click',function(){
            $(this).closest('.btn-group').find('button').attr('selected-per-page',$(this).attr('data-per'));
            if($(this).attr('data-per')=="all")
                $(this).closest('.btn-group').find('button').html($(this).html()+' items');
            else
                $(this).closest('.btn-group').find('button').html($(this).html()+' items per page');
            var data={
                per_page:$(this).attr('data-per'),
                page:1,
                user_id:Viewuser.user_id
            }
            Viewuser.listRecipes(data);
        });
        $('.btn-prev').on('click',function(){
            var data={
                per_page:$('.dropdown-toggle').attr('selected-per-page'),
                page:$(this).attr('page-no'),
                user_id:Viewuser.user_id
            }
            Viewuser.listRecipes(data);
        });
        $('.btn-next').on('click',function(){
            var attr = $(this).attr('disabled');
            if (!(typeof attr !== typeof undefined && attr !== false)) {
                var data={
                    per_page:$('.dropdown-toggle').attr('selected-per-page'),
                    page:$(this).attr('page-no'),
                    user_id:Viewuser.user_id
                }
                Viewuser.listRecipes(data);
            }
        });
        
        $('#table-recipes').on('click','.a-view-item',function(e){
            $('#modal-view-event').modal('show');
            var item_id=$(this).attr('data-id');
            $('#image-loader').show();
            $('.event-name').html('');
            $('.div-row-allergens').html('');
            $('.nutrient-html').html('');
            $('.recipe-image').attr('src',Viewuser.base_url+"assets/images/products/2.png");
            var data={
                item_id:item_id
            }
            var self=$(this);
            $.ajax({
                url: Viewuser.base_url+"company/get_recipe/"+item_id,
                type:'POST',
                dataType: 'json',
                data: data,
                success: function(response){
                    var event=response.event;
                    $('.event-name').html(response.recipe.name);
                   /* var allergens=response.result.linked.allergens;*/
                    var nutrients=response.result.linked.nutrition;
                    $('.recipe-image').attr('src',Viewuser.base_url+response.recipe.recipe_image);
                    $('#image-loader').hide();
                    
                    var image="";
                    var html='';
                    if(response.result.linked.allergens){
                        var allergens=response.result.linked.allergens;
                        for(var i in allergens){
                            switch (allergens[i]) {
                                case 'sulphites':
                                    image = "sulphites.png";
                                break;
                                case 'corn':
                                    image = "corn.png";
                                break;
                                case 'egg':
                                    image = "egg.png";
                                break;
                                case 'fish':
                                    image = "fish.png";
                                break;
                                case 'gluten':
                                    image = "gluten.png";
                                break;
                                case 'gluten_from_wheat':
                                    image = "wheat.png";
                                break;
                                case 'milk':
                                    image = "milk.png";
                                break;
                                case 'msg':
                                    image = "msg.png";
                                break;
                                case 'peanuts':
                                    image = "peanuts.png";
                                    break;
                                case 'nuts':
                                     image = "nuts.png";
                                    break;
                                case 'vegan':
                                     image = "vegan.png";
                                    break;
                                case 'mustard':
                                     image = "mustard.png";
                                    break;
                                case 'celery':
                                     image = "celery.png";
                                    break;
                                case 'soy':
                                    image = "soy.png";
                                     break;
                                case 'transfats':
                                    image = "transfats.png";
                                     break;
                                case 'wheat':
                                    image = "wheat.png";
                                    break;
                                case 'contraversal':
                                    image = "contraversal.png";
                                    break;
                            }
                            html+='<div class="col-md-2 text-center">\
                                <img src="'+Viewuser.base_url+'assets/images/allergens/'+image+'">\
                                <p class="mt-2 text-center">'+allergens[i]+'</p>\
                            </div>';
                        }
                    }
                    if(html=="")
                        $('.div-row-allergens').closest('.expanel').hide();
                    else{
                        $('.div-row-allergens').closest('.expanel').show();
                    }
                    $('.div-row-allergens').html(html);

                    for(var i in nutrients){
                        var serving_qty=response.recipe.quantity_per_serving;

                        var per_serving_value=(parseFloat(nutrients[i].value)/100)*parseFloat(serving_qty);
                        nutrients[i].per_serving=per_serving_value.toFixed('2');
                        $('#'+i).html(nutrients[i].per_serving+''+nutrients[i].unit);
                    }
                    $('#servingsize').html(response.recipe.quantity_per_serving+'g');
                }
            });
            
        });
    },

    listRecipes:function(data,fromevent){
        $.ajax({
            url: Viewuser.base_url+"company/list_user_recipes/",
            type:'POST',
            dataType: 'json',
            data: data,
            success: function(response){
                var recipe=response.recipes;
                var html="";
                for (i in recipe) {

                    html+='<tr>\
                        <td>\
                            <a href="javascript:;" data-id="'+recipe[i].id+'" alacalc-recipe-id="'+recipe[i].alacal_recipe_id+'" style="color:#000;" class="a-view-item">'+recipe[i].name+'</a>\
                        </td>\
                        <td>'+recipe[i].recipe_date+'</td>';
                    html+='</tr>';
                }
                $('.tbody-recipes-list').html(html);
                $('.span-all-recipes').html(response.total_count);
                $('.span-page-html').html(response.page_total_text);
                if(parseInt(response.page_no)>1){
                    var prev_page=parseInt(response.page_no)-1;
                    $('.btn-prev').attr('page-no',prev_page);
                    $('.btn-prev').removeAttr('disabled');
                }else{
                    $('.btn-prev').attr('disabled',true);
                     $('.btn-prev').prop('disabled', true);
                    
                }

                if(parseInt(response.page_no)<parseInt(response.total_pages)){
                    var next_page=parseInt(response.page_no)+1;
                    $('.btn-next').attr('page-no',next_page);
                    $('.btn-next').removeAttr('disabled');
                }else{
                     $('.btn-next').attr('disabled',true);
                     $('.btn-next').prop('disabled', true);
                }

                if(fromevent=="fromsearch"){
                    var input, filter, table, tr, td, i, txtValue;
                    input = document.getElementById("searchRecipeInput");
                    filter = input.value.toUpperCase();
                    table = document.getElementById("table-recipes");
                    tr = table.getElementsByTagName("tr");
                    for (i = 0; i < tr.length; i++) {
                        td = tr[i].getElementsByTagName("td")[0];
                        if (td) {
                            txtValue = td.textContent || td.innerText;
                            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                tr[i].style.display = "";
                            } else {
                                tr[i].style.display = "none";
                            }
                        }       
                    }
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

    displaysucessconfrim:function(msg)
    {
        swal({
            title:"Success !", 
            text:msg, 
            type:"success",
            confirmButtonClass: "btn-primary",
            confirmButtonText: "Ok",
            closeOnConfirm: false
        },function(){
            window.location.href=Viewuser.base_url+"users/dashboard";
        })
    },
    displaywarningconfrim:function(msg)
    {
         swal({
                title:"Error !", 
                text:msg, 
                type:"error",
                confirmButtonClass: "btn-primary",
                confirmButtonText: "Ok",
                closeOnConfirm: false
            },function(){
            window.location.href=Viewuser.base_url+"users/dashboard";
        })  
    }
};