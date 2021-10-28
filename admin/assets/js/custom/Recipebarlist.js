var Recipebarlist ={
    base_url:null,
    group_id:null,
    init:function() {
        this.bind_events();
        var data={
            per_page : 30,
            page:1,
            group_id:Recipebarlist.group_id,
            main_menu_id:2
        }
        this.listRecipes(data);
    },

    bind_events :function() {
        var self=this;
        $('#searchRecipeInput').on('keyup',function(){
            if($(this).val()==""){
                var data={
                    per_page:$('.dropdown-toggle').attr('selected-per-page'),
                    page: $('.btn-current-pageno').attr('curr-page'),
                    group_id:Recipebarlist.group_id,
                    main_menu_id:2
                }
                Recipebarlist.listRecipes(data,'fromsearch');
            }else{
                if($(this).val().length>=3){
                    var data={
                        per_page:'all',
                        page:$('.btn-current-pageno').attr('curr-page'),
                        group_id:Recipebarlist.group_id,
                        searchkey:$('#searchRecipeInput').val(),
                        main_menu_id:2
                    }
                    Recipebarlist.listRecipes(data,'fromsearch');
                }
            }
            Recipebarlist.listRecipes(data,'fromsearch');

        });
        $('.a-recipe-perpage').on('click',function(){
            $(this).closest('.btn-group').find('button').attr('selected-per-page',$(this).attr('data-per'));
            if($(this).attr('data-per')=="all")
                $(this).closest('.btn-group').find('button').html($(this).html()+' items');
            else
                $(this).closest('.btn-group').find('button').html($(this).html()+' items per page');
            var data={
                per_page:$(this).attr('data-per'),
                page:$('.btn-current-pageno').attr('curr-page'),
                group_id:Recipebarlist.group_id,
                main_menu_id:2
            }
            Recipebarlist.listRecipes(data);
        });
        $('.btn-prev').on('click',function(){
            var data={
                per_page:$('.dropdown-toggle').attr('selected-per-page'),
                page:$(this).attr('page-no'),
                group_id:Recipebarlist.group_id,
                main_menu_id:2
            }
            Recipebarlist.listRecipes(data);
        });
        $('.btn-next').on('click',function(){
            var data={
                per_page:$('.dropdown-toggle').attr('selected-per-page'),
                page:$(this).attr('page-no'),
                group_id:Recipebarlist.group_id,
                main_menu_id:2

            }
            Recipebarlist.listRecipes(data);
        });
        $('.tbody-recipes-list').on('click','.btn-delete-recipe',this.deleteRecipe);
        $('.tbody-recipes-list').on('click','.input-switch-box',this.activeInactiveRecipe);
         $('.tbody-recipes-list').on('click','.img-upload',function(){
            $(this).closest('tr').find('.imgupload').trigger('click');
        });
        $('.tbody-recipes-list').on('change','.imgupload',this.onImageUpload);

        $('.tbody-recipes-list').on('click','.btn-edit-recipe',this.editRecipe);

        $('.btn-add-price').on('click',this.addPriceDiv);
        $('.form-recipe-edit').on('submit',this.savePrice);
        $('.form-recipe-edit').on('click','.btn-remove-price',this.deleteRecipePrice);
        $('.div-price-append').on('keyup','.input-recipe-price',function (event) {
            var currentVal = $(this).val();
            if (currentVal.length == 1 && event.which == 48) {
                currentVal = currentVal.slice(0, -1);
                $(this).val(currentVal);
            }
            
            this.value = this.value.match(/^\d+\.?\d{0,2}/);
                $(this).val($(this).val().replace(/[^0-9\.]/g,''));
        });
        $('.btn-clear-priceedit').on('click',function(){
            $('.row-div-quantity').hide();
            $('.form-recipe-edit').trigger('reset');
            $('.div-price-append').html('');
        });
    },
    deleteRecipePrice:function(){
        var self=$(this);
        var seq=$(this).closest('.row').attr('sequence');
        var recipe_id=$(this).attr('data-id');
         $.ajax({
            url: Recipebarlist.base_url+"recipes/delete_recipe_price/",
            type:'POST',
            dataType: 'json',
            data: {'sequence':seq,'recipe_id':recipe_id},
            success: function(result){
                var data=result.recipe;
                if (result.status) { 
                  self.closest('.row').remove();
                }else{
                    Recipebarlist.displaywarning(result.msg);
                }
            }
        });
    },
    savePrice:function(){
      
        if($('#in-recipe-quantity').val()=="" || $('#in-recipe-price').val()==""){
            Recipebarlist.displaywarning("Please add price and quantity both");
            $('#in-recipe-quantity').focus();
            return false;
        }
        $.ajax({
            url: Recipebarlist.base_url+"recipes/update_recipe_price/",
            type:'POST',
            dataType: 'json',
            data: $('.form-recipe-edit').serialize(),
            success: function(result){
                var data=result.recipe;
                if (result.status) { 
                     var data={
                        per_page:$('.dropdown-toggle').attr('selected-per-page'),
                        page:$('.btn-current-pageno').attr('curr-page'),
                        group_id:Recipebarlist.group_id,
                        main_menu_id:2
                    }
                    Recipebarlist.listRecipes(data);
                    $('.row-div-quantity').hide();
                    Recipebarlist.displaysucess("Information saved successfully.");
                    $('.form-recipe-edit').trigger('reset');
                    $('.div-price-append').html('');
                }else{
                    Recipebarlist.displaywarning(result.msg);
                }
            }
        });
    },
    addPriceDiv:function(){
        var count=$('.div-price-append .row').length;
        var cnt=parseInt(count)+1;
        var labelcnt=parseInt(count)+2;

        if(count<3){
            $('.div-price-append').append('<div class="row" sequence="'+cnt+'">\
                                        <div class="col-md-1 text-left">\
                                            <label class="form-label label-header"> Qty '+labelcnt+'</label>\
                                        </div>\
                                        <div class="col-md-2">\
                                            <input type="text" name="quantity'+cnt+'" value="" class="text-white mt-2 mb-2 form-control input-reciepe-header input-recipe-quantity" onclick="this.select();" id="in-recipe-quantity'+cnt+'" placeholder="Ex:10 ml" >\
                                        </div>\
                                         <div class="col-md-1 text-left">\
                                            <label class="form-label label-header"> Price '+labelcnt+'</label>\
                                        </div>\
                                        <div class="col-md-2">\
                                            <input type="text" name="price'+cnt+'" value="" class="text-white mt-2 mb-2 form-control input-reciepe-header input-recipe-price" onclick="this.select();" id="in-recipe-price'+cnt+'">\
                                        </div>\
                                        <div class="col-md-1 text-left">\
                                            <button class="btn btn-light btn-remove-price" type="button" style="border: 0px !important;margin-top:10px;margin-top: 1rem;"><i class="fas fa-trash"></i></button>\
                                        </div>\
                                        <div class="col-md-2">\
                                        </div>\
                                    </div>');
        }else{
             Recipebarlist.displaywarning("Maximum four prices are allowed.");
        }
    },
    editRecipe:function(){
        $('.row-div-quantity').show();
        $('html, body').animate({
            scrollTop: $(".row-div-quantity").offset().top-100
        }, 500); 
        var self=this;
        var data_id=$(this).attr('data-id');
        var formData={
            id : data_id
        } 
        $.ajax({
            url: Recipebarlist.base_url+"recipes/get_recipe_prices",
            type:'POST',
            data:formData ,
            success: function(result){
                var data=result.recipe;
               if (result.status) {
                    for (i in data) {
                        $('.form-recipe-edit [name="'+i+'"]').val(data[i]);
                    }
                    $('.div-price-append').html('');
                    if(data['price1']!="" && data['quantity1']!=""){

                        $('.div-price-append').append('<div class="row" sequence="1">\
                                <div class="col-md-1 text-left">\
                                    <label class="form-label label-header"> Qty 2</label>\
                                </div>\
                                <div class="col-md-2">\
                                    <input type="text" name="quantity1" value="'+data['quantity1']+'" class="text-white mt-2 mb-2 form-control input-reciepe-header input-recipe-quantity" onclick="this.select();" id="in-recipe-quantity1" placeholder="Ex:10 ml" >\
                                </div>\
                                 <div class="col-md-1 text-left">\
                                    <label class="form-label label-header"> Price 2</label>\
                                </div>\
                                <div class="col-md-2">\
                                    <input type="text" name="price1" value="'+data['price1']+'" class="text-white mt-2 mb-2 form-control input-reciepe-header input-recipe-price" onclick="this.select();" id="in-recipe-price1">\
                                </div>\
                                <div class="col-md-1 text-left">\
                                    <button class="btn btn-light btn-remove-price" data-id="'+data['id']+'" type="button" style="border: 0px !important;margin-top:10px;margin-top: 1rem;"><i class="fas fa-trash"></i></button>\
                                </div>\
                                <div class="col-md-2">\
                                </div>\
                            </div>');
                     }

                      if(data['price2']!="" && data['quantity2']!=""){

                        $('.div-price-append').append('<div class="row"  sequence="2">\
                                <div class="col-md-1 text-left">\
                                    <label class="form-label label-header"> Qty 3</label>\
                                </div>\
                                <div class="col-md-2">\
                                    <input type="text" name="quantity2" value="'+data['quantity2']+'" class="text-white mt-2 mb-2 form-control input-reciepe-header input-recipe-quantity" onclick="this.select();" id="in-recipe-quantity1" placeholder="Ex:10 ml" >\
                                </div>\
                                 <div class="col-md-1 text-left">\
                                    <label class="form-label label-header"> Price 3</label>\
                                </div>\
                                <div class="col-md-2">\
                                    <input type="text" name="price2" value="'+data['price2']+'" class="text-white mt-2 mb-2 form-control input-reciepe-header input-recipe-price" onclick="this.select();" id="in-recipe-price1">\
                                </div>\
                                <div class="col-md-1 text-left">\
                                    <button class="btn btn-light btn-remove-price" data-id="'+data['id']+'" type="button" style="border: 0px !important;margin-top:10px;margin-top: 1rem;"><i class="fas fa-trash"></i></button>\
                                </div>\
                                <div class="col-md-2">\
                                </div>\
                            </div>');
                     }


                      if(data['price3']!="" && data['quantity3']!=""){

                        $('.div-price-append').append('<div class="row" sequence="3">\
                                <div class="col-md-1 text-left">\
                                    <label class="form-label label-header"> Qty 4</label>\
                                </div>\
                                <div class="col-md-2">\
                                    <input type="text" name="quantity3" value="'+data['quantity3']+'" class="text-white mt-2 mb-2 form-control input-reciepe-header input-recipe-quantity" onclick="this.select();" id="in-recipe-quantity1" placeholder="Ex:10 ml" >\
                                </div>\
                                 <div class="col-md-1 text-left">\
                                    <label class="form-label label-header"> Price 4</label>\
                                </div>\
                                <div class="col-md-2">\
                                    <input type="text" name="price3" value="'+data['price3']+'" class="text-white mt-2 mb-2 form-control input-reciepe-header input-recipe-price" onclick="this.select();" id="in-recipe-price1">\
                                </div>\
                                <div class="col-md-1 text-left">\
                                    <button class="btn btn-light btn-remove-price" data-id="'+data['id']+'" type="button" style="border: 0px !important;margin-top:10px;margin-top: 1rem;"><i class="fas fa-trash"></i></button>\
                                </div>\
                                <div class="col-md-2">\
                                </div>\
                            </div>');
                     }
               }
               else{
                    Recipebarlist.displaywarning("Something went wrong please try again");
               }
            }
        });
    },
    onImageUpload:function(event){
        var bind_input=$(this);
        if($(this).val()==""){
            /*displaywarning('please select file to upload.');*/
            return false;
        }
        var recipe_id=$(this).attr('recipe-id');
        var ext = $(this).val().split('.').pop().toLowerCase();
            if($.inArray(ext, ['jpg','jpeg','png']) == -1) {
                Recipebarlist.displaywarning('invalid extension!');
                return false;
            }

            var self=this;
            var $form_data = new FormData();
            var inputFile = $(this);   
            if(inputFile){   
                var fileToUpload = inputFile[0].files[0];
                if (fileToUpload != 'undefined') {
                    $form_data.append('image', fileToUpload);
                }
            }
            const target = event.target
            /*if (target.files && target.files[0]) {
                //allow less than 1mb
                const maxAllowedSize = 1 * 1024 * 1024;
                if (target.files[0].size > maxAllowedSize) {
                // Here you can ask your users to load correct file
                    $('#image-loader').hide();
                    Recipebarlist.displaywarning("File size is too big. please select the file less than 1MB.");
                    return false;
                }
            }*/
           
            var defaults = {  
                maxWidth: Number.MAX_VALUE,  
                maxHeigt: Number.MAX_VALUE,  
                onImageResized: null  
            }  
            var options={
                maxWidth: 960,
                maxHeigt:500
            }
            var settings = $.extend({}, defaults, options); 
            
            if (window.File && window.FileList && window.FileReader) { 
                var files = event.target.files;  
                var file = files[0];  
                /*if (!file.type.match('image')) continue;  */
                var picReader = new FileReader();  
                picReader.addEventListener("load", function (event) {

                    var picFile = event.target;  
                    var imageData = picFile.result;  
                    var img = new Image();  
                    img.src = imageData;  
                    img.onload = function () { 
                        swal({
                            title: 'File requirement :',
                            text: "JPG, PNG Minimum pixels required: 960 for width, 500 for height.",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, upload it!',
                            cancelButtonText: 'No, cancel!',
                            confirmButtonClass: 'btn btn-success',
                            cancelButtonClass: 'btn btn-danger',
                            buttonsStyling: false
                        },function (swalinput) { 
                            if(swalinput){
                                $('#image-loader').show();
                                var canvas = $("<canvas/>").get(0);  
                                canvas.width = 960;  
                                canvas.height = 500;   
                                var context = canvas.getContext('2d');  
                                context.fillStyle = "transparent";
                                context.drawImage(img, 0, 0, 960, 500);
                                /*context.drawImage(img, xOffset, yOffset, newWidth, newHeight,0,0,500,300);  */ 
                                imageData = canvas.toDataURL('image/jpeg',0.8); 
                               
                                $form_data.append('image', imageData);
                                $('.recipe-image-upload').attr('data-image-src',imageData);
                                $(".recipe-image-upload").css("background", "url(" + imageData + ")");
                                $form_data.append('id',recipe_id);
                                $('#image-loader').show();
                                $.ajax({
                                    url: Recipebarlist.base_url+"recipes/update_recipe_image",
                                    type:'POST',
                                    data: $form_data,
                                    processData:false,
                                    contentType:false,
                                    cache:false,
                                    success: function(result){
                                        $('#image-loader').hide();
                                        if (result.status) { 
                                            $('.recipe-image-upload').attr('data-image-src',result.path);
                                            $(".recipe-image-upload").css("background", "url(" + result.path + ")");
                                            
                                        } 
                                        else{
                                            if(result.msg){
                                                Recipebarlist.displaywarning(result.msg);
                                            }
                                            else
                                                Recipebarlist.displaywarning("Something went wrong please try again");
                                        }
                                        $('#image-loader').hide();
                                        var data={
                                            per_page:$('.dropdown-toggle').attr('selected-per-page'),
                                            page:$('.btn-current-pageno').attr('curr-page'),
                                            group_id:Recipebarlist.group_id,
                                            main_menu_id:2

                                        }
                                        Recipebarlist.listRecipes(data);
                                    }
                                });
                            }else{
                                bind_input.val('');
                            }
                        }, function (dismiss) {
                            if (dismiss === 'cancel') {
                               /* swal(
                                  'Cancelled',
                                  'Your record is safe :)',
                                  'error'
                                )*/

                            }
                        });
                    }  
                    img.onerror = function () {  
                         $("#cropbox").attr('src','');
                        $('#image-loader').hide();
                       
                    }  
                });  
                //Read the image  
                picReader.readAsDataURL(file);  
            } else {  
                Recipebarlist.displaywarning("Your browser does not support File API");  
                $("#cropbox").attr('src','');
                $('#image-loader').hide();
            }  
    },
     activeInactiveRecipe:function(){
        if($(this).is(':checked'))
            $(this).val("on");
        else
            $(this).val("off");

        var self=this;
        var data_id=$(this).attr('data-id');
        var formData={
            id : data_id,
            is_recipe_active:$(this).val()
        } 
        $.ajax({
            url: Recipebarlist.base_url+"recipes/active_inactive_recipe",
            type:'POST',
            data:formData ,
            success: function(result){
               if (result.status) {
                var data={
                    per_page:$('.dropdown-toggle').attr('selected-per-page'),
                    page:$('.btn-current-pageno').attr('curr-page'),
                    group_id:Recipebarlist.group_id,
                    main_menu_id:2

                }
                   Recipebarlist.listRecipes(data);
               }
               else{
                    Recipebarlist.displaywarning("Something went wrong please try again");
               }
            }
        });
    },
    deleteRecipe:function(){
        var self=this;
        var data_id=$(this).attr('data-id');
        var alacalc_recipe_id=$(this).attr('alacalc-recipe-id');
        swal({
            title: 'Are you sure ?',
            text: "Delete Recipe",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false
        },function () {
            var formData = {
                id: data_id,
                alacalc_recipe_id:alacalc_recipe_id
            };
            $.ajax({
                url: Recipebarlist.base_url+"recipes/delete_recipe",
                type:'POST',
                data:formData ,
                success: function(result){
                   if (result.status) {
                    var data={
                        per_page:30,
                        page:1,
                        group_id:Recipebarlist.group_id,
                        main_menu_id:2

                    }
                       Recipebarlist.listRecipes(data);
                   }
                   else{
                        Recipebarlist.displaywarning("Something went wrong please try again");
                   }
                }
            });
             
        }, function (dismiss) {
            if (dismiss === 'cancel') {
                swal(
                  'Cancelled',
                  'Your record is safe :)',
                  'error'
                )
            }
        });
    },
    listRecipes:function(data,fromevent){
       /* $('#image-loader').show();*/
        $('.tbody-recipes-list').html('');
        $.ajax({
            url: Recipebarlist.base_url+"recipes/list_recipes/",
            type:'POST',
            dataType: 'json',
            data: data,
            success: function(response){
               /* $('#image-loader').hide();*/
                var recipe=response.recipes;
                var html="";
                for (i in recipe) {
                        html+='<tr>';
                        if(recipe[i].recipe_image=="assets/images/users/menu.png"){
                            html+='<td>\
                            <input type="file" recipe-id="'+recipe[i].id+'" class="imgupload" accept="image/jpeg, image/png" style="display:none"/>\
                            <img class="img-upload"  src="'+Recipebarlist.base_url+'assets/images/upload.png" style="height:50px;width:50px;">\
                            </td>';
                        }
                        else{
                            if(recipe[i].recipe_image==""){
                                html+='<td>\
                                <input type="file" recipe-id="'+recipe[i].id+'" class="imgupload" accept="image/jpeg, image/png" style="display:none"/>\
                                <img class="img-upload"  src="'+Recipebarlist.base_url+'assets/images/upload.png" style="height:50px;width:50px;">\
                                </td>';
                            }else{

                                html+='<td>\
                                 <input type="file" recipe-id="'+recipe[i].id+'" class="imgupload" accept="image/jpeg, image/png" style="display:none"/>\
                                <img class="img-upload" src="'+recipe[i].recipe_image+'" style="height:50px;width:50px;"></td>';
                            }
                        }

                        html+='<td>\
                            <a href="'+Recipebarlist.base_url+'recipes/createbarmenu/'+recipe[i].id+'" data-id="'+recipe[i].id+'" alacalc-recipe-id="'+recipe[i].alacal_recipe_id+'" style="color:#000;">'+recipe[i].name+'</a>\
                        </td>\
                        <td>'+recipe[i].group_name+'</td>\
                        <td>'+recipe[i].recipe_date+'</td>';
                        if(recipe[i].is_sample==0){
                            html+='<td class="text-center">\
                                    <label class="custom-switch pl-0">';
                                    if(recipe[i].is_recipe_active==1)
                                        html+='<input type="checkbox" name="custom-switch-checkbox" data-id="'+recipe[i].id+'" class="custom-switch-input input-switch-box" checked>';
                                    else
                                        html+='<input type="checkbox" name="custom-switch-checkbox" data-id="'+recipe[i].id+'" class="custom-switch-input input-switch-box">';
                                        html+='<span class="custom-switch-indicator"></span>\
                                    </label>\
                                </td>';
                        }
                        if(recipe[i].is_sample==0)
                            html+='<td>\
                                <a href="javascript:;" data-id="'+recipe[i].id+'" alacalc-recipe-id="'+recipe[i].alacal_recipe_id+'" class="btn-edit-recipe" style="margin-right:10px;color:#089e60 !important;"><i class="fas fa-edit "></i></a>\
                                <a href="javascript:;" data-id="'+recipe[i].id+'" alacalc-recipe-id="'+recipe[i].alacal_recipe_id+'" class="btn-delete-recipe"><i class="fas fa-trash c-usda_sr28"></i></a>\
                            </td>';
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
                $('.btn-current-pageno').attr('curr-page',response.page_no);
                if(parseInt(response.page_no)<parseInt(response.total_pages)){
                    var next_page=parseInt(response.page_no)+1;
                    $('.btn-next').attr('page-no',next_page);
                    $('.btn-next').removeAttr('disabled');
                }else{
                     $('.btn-next').attr('disabled',true);
                     $('.btn-next').prop('disabled', true);
                }

               /* if(fromevent=="fromsearch"){
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
                }*/
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

};