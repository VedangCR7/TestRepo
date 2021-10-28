var Masterrecipelist ={
    base_url:null,
    group_id:null,
    is_category_prices:null,
    table_categories:null,
    init:function() {
        this.bind_events();
        var data={
            per_page : 30,
            page:1,
            group_id:Masterrecipelist.group_id,
            main_menu_id:1
        }
        this.listRecipes(data);
        this.loadTableCategories();
    },

    bind_events :function() {
        var self=this;
        $('#searchRecipeInput').on('keyup',function(){
            if($(this).val()==""){
                var data={
                    per_page:$('.dropdown-toggle').attr('selected-per-page'),
                    page:1,
                    group_id:Masterrecipelist.group_id,
                    main_menu_id:1
                }
                Masterrecipelist.listRecipes(data,'fromsearch');
            }else{
                if($(this).val().length>=3){
                    var data={
                        per_page:'all',
                        page:1,
                        group_id:Masterrecipelist.group_id,
                        searchkey:$('#searchRecipeInput').val(),
                        main_menu_id:1
                    }
                    Masterrecipelist.listRecipes(data,'fromsearch');
                }
            }

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
                group_id:Masterrecipelist.group_id
            }
            Masterrecipelist.listRecipes(data);
        });
        $('.btn-prev').on('click',function(){
            var data={
                per_page:$('.dropdown-toggle').attr('selected-per-page'),
                page:$(this).attr('page-no'),
                group_id:Masterrecipelist.group_id,
                main_menu_id:1
            }
            Masterrecipelist.listRecipes(data);
        });
        $('.btn-next').on('click',function(){
            var data={
                per_page:$('.dropdown-toggle').attr('selected-per-page'),
                page:$(this).attr('page-no'),
                group_id:Masterrecipelist.group_id,
                main_menu_id:1

            }
            Masterrecipelist.listRecipes(data);
        });
        $('.tbody-recipes-list').on('click','.btn-delete-recipe',this.deleteRecipe);
        $('.tbody-recipes-list').on('click','.btn-edit-recipe',this.editRecipe);
        $('.tbody-recipes-list').on('click','.input-switch-box',this.activeInactiveRecipe);
        $('.tbody-recipes-list').on('click','.img-upload',function(){
            $(this).closest('tr').find('.imgupload').trigger('click');
        });
        $('.tbody-recipes-list').on('change','.imgupload',this.onImageUpload);
        $('.tbody-recipes-list').on('blur','.input-recipe-price',this.updateRecipes);
        $('.form-recipe-edit').on('submit',this.savePrice);
        $('.form-recipe-edit').on('click','.btn-remove-price',this.deleteRecipePrice);
        $('.tbody-recipes-list').on('keyup','.input-recipe-price',function (event) {
            var currentVal = $(this).val();
            if (currentVal.length == 1 && event.which == 48) {
                currentVal = currentVal.slice(0, -1);
                $(this).val(currentVal);
            }
            this.value = this.value.match(/^\d+\.?\d{0,2}/);
            $(this).val($(this).val().replace(/[^0-9\.]/g,''));
        });
        $('.tbody-recipes-list').on('click','.td-price-view',function (event) {
            $(this).toggle();
            $(this).closest('tr').find('.input-recipe-price').toggle();
            $(this).closest('tr').find('.input-recipe-price').focus();
        });
        $('.btn-add-tableprice').on('click',this.addTablePriceDiv);
        $('.btn-clear-priceedit').on('click',function(){
            $('.row-div-quantity').hide();
            $('.form-recipe-edit').trigger('reset');
            $('.div-price-append').html('');
        });
    },
    deleteRecipePrice:function(){
        var self=$(this);
        var seq=$(this).closest('.row').attr('sequence');
        var recipe_id=$('.form-recipe-edit [name=id]').val();
         $.ajax({
            url: Masterrecipelist.base_url+"Menumaster/delete_recipe_price/",
            type:'POST',
            dataType: 'json',
            data: {'sequence':seq,'recipe_id':recipe_id},
            success: function(result){
                var data=result.recipe;
                if (result.status) { 
                  self.closest('.row').remove();
                }else{
                    Masterrecipelist.displaywarning(result.msg);
                }
            }
        });
    },
    savePrice:function(){
        if($('#in-recipe-quantity').val()=="" || $('#in-recipe-price').val()==""){
            Masterrecipelist.displaywarning("Please add price and quantity both");
            $('#in-recipe-quantity').focus();
            return false;
        }
        if(Masterrecipelist.is_category_prices==1){
            var select_cat=new Array();
            var flag_price=0,cat_type=0;
            $('.form-recipe-edit .input-recipe-tablecat').each(function(i){
                console.log($(this).val());
                if($(this).val()==""){
                    cat_type=1;
                }
                var price=$(this).closest('.row').find('.input-recipe-price').val();
                if(price==""){
                    flag_price=1;
                }
                select_cat.push($(this).val());
            });
            console.log(cat_type);
            if(cat_type==1){
                Masterrecipelist.displaywarning("Table category should not be empty.");
                return false;
            }
            if(flag_price==1){
                Masterrecipelist.displaywarning("price should not be empty.");
                return false;
            }
            var cate_duplicate = [];
            for (var i = 0; i < select_cat.length - 1; i++) {
                if (select_cat[i + 1] == select_cat[i]) {
                    cate_duplicate.push(select_cat[i]);
                }
            }
            if(cate_duplicate.length!=0){
                Masterrecipelist.displaywarning("Can not add different prices for same category ");
                return false;
            }
        }
        $.ajax({
            url: Masterrecipelist.base_url+"Menumaster/update_recipe_price/",
            type:'POST',
            dataType: 'json',
            data: $('.form-recipe-edit').serialize(),
            success: function(result){
                var data=result.recipe;
                if (result.status) { 
                     var data={
                        per_page:$('.dropdown-toggle').attr('selected-per-page'),
                        page:$(this).attr('page-no'),
                        group_id:Masterrecipelist.group_id,
                        main_menu_id:1
                    }
                    Masterrecipelist.listRecipes(data);
                    $('.row-div-quantity').hide();
                    Masterrecipelist.displaysucess("Information saved successfully.");
                    $('.form-recipe-edit').trigger('reset');
                    $('.div-price-append').html('');
                }else{
                    Masterrecipelist.displaywarning(result.msg);
                }
            }
        });
    },
    addTablePriceDiv:function(){
        var count=$('.div-price-append .row').length;
        var cnt=parseInt(count)+1;
        var table_categories=Masterrecipelist.table_categories;
        var labelcnt=parseInt(count)+2;
        if(table_categories.length-1>count){
            if(count<3){
               
                var used_categories=new Array();
                $('.div-main-recipeheader .input-recipe-tablecat').each(function(){
                    used_categories.push($(this).val());
                });
                var html='<div class="row" sequence="'+cnt+'">\
                        <div class="col-md-2 text-left">\
                            <label class="form-label label-header"> Table Category '+labelcnt+'</label>\
                        </div>\
                        <div class="col-md-3">\
                            <select name="quantity'+cnt+'" class="text-white mt-2 mb-2 form-control input-reciepe-header input-recipe-tablecat" id="in-recipe-quantity1">';
                                html+='<option value="">Select Category</option>';
                                for(i in table_categories){
                                    /*if($.inArray(table_categories[i].id,used_categories)==-1)*/
                                        html+='<option value="'+table_categories[i].id+'">'+table_categories[i].title+'</option>';
                                }
                            html+='</select>\
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
                    </div>';
                $('.div-price-append').append(html);
            }else{
                 Masterrecipelist.displaywarning("Maximum four prices are allowed.");
            }
        }
        else{
             Masterrecipelist.displaywarning("Only "+table_categories.length+" categories available.");
        }
    },
    editRecipe:function(){
        $('.row-div-quantity').show();
        $('html, body').animate({
            scrollTop: $(".row-div-quantity").offset().top
        }, 500); 
        var self=this;
        var data_id=$(this).attr('data-id');
        var formData={
            id : data_id
        } 
        $.ajax({
            url: Masterrecipelist.base_url+"Menumaster/get_recipe_prices",
            type:'POST',
            data:formData ,
            success: function(result){
                var data=result.recipe;
               if (result.status) {
                    for (i in data) {
                        $('.form-recipe-edit [name="'+i+'"]').val(data[i]);
                    }
                    $('.div-price-append').html('');
                    var table_categories=Masterrecipelist.table_categories;
                    if((data['price1']!="" && data['price1']!=null) && (data['quantity1']!="" && data['quantity1']!=null)){
                        var html='<div class="row" sequence="1">\
                                <div class="col-md-2 text-left">\
                                    <label class="form-label label-header"> Table Category 2</label>\
                                </div>\
                                <div class="col-md-3">\
                                     <select name="quantity1" class="text-white mt-2 mb-2 form-control input-reciepe-header input-recipe-tablecat" id="in-recipe-quantity1">';
                                             html+='<option value="">Select Category</option>';
                                        for(i in table_categories){
                                            if(table_categories[i].id==data['quantity1'])
                                                html+='<option value="'+table_categories[i].id+'" selected>'+table_categories[i].title+'</option>';
                                            else
                                                html+='<option value="'+table_categories[i].id+'">'+table_categories[i].title+'</option>';
                                        }
                                    html+='</select>\
                                </div>\
                                 <div class="col-md-1 text-left">\
                                    <label class="form-label label-header"> Price 2</label>\
                                </div>\
                                <div class="col-md-2">\
                                    <input type="text" name="price1" value="'+data['price1']+'" class="text-white mt-2 mb-2 form-control input-reciepe-header input-recipe-price" onclick="this.select();" id="in-recipe-price1">\
                                </div>\
                                <div class="col-md-1 text-left">\
                                    <button class="btn btn-light btn-remove-price" type="button" style="border: 0px !important;margin-top:10px;margin-top: 1rem;" data-id="'+data_id+'"><i class="fas fa-trash"></i></button>\
                                </div>\
                                <div class="col-md-2">\
                                </div>\
                            </div>';
                        $('.div-price-append').append(html);
                    }

                    if((data['price2']!="" && data['price2']!=null) && (data['quantity2']!="" && data['quantity2']!=null)){

                        var html='<div class="row"  sequence="2">\
                                <div class="col-md-2 text-left">\
                                    <label class="form-label label-header"> Table Category 3</label>\
                                </div>\
                                <div class="col-md-3">\
                                     <select name="quantity2" class="text-white mt-2 mb-2 form-control input-reciepe-header input-recipe-tablecat" id="in-recipe-quantity1">';
                                             html+='<option value="">Select Category</option>';
                                        for(i in table_categories){
                                            if(table_categories[i].id==data['quantity2'])
                                                html+='<option value="'+table_categories[i].id+'" selected>'+table_categories[i].title+'</option>';
                                            else
                                                html+='<option value="'+table_categories[i].id+'">'+table_categories[i].title+'</option>';
                                        }
                                    html+='</select>\
                                </div>\
                                 <div class="col-md-1 text-left">\
                                    <label class="form-label label-header"> Price 3</label>\
                                </div>\
                                <div class="col-md-2">\
                                    <input type="text" name="price2" value="'+data['price2']+'" class="text-white mt-2 mb-2 form-control input-reciepe-header input-recipe-price" onclick="this.select();" id="in-recipe-price1">\
                                </div>\
                                <div class="col-md-1 text-left">\
                                    <button class="btn btn-light btn-remove-price" type="button" style="border: 0px !important;margin-top:10px;margin-top: 1rem;" data-id="'+data_id+'"><i class="fas fa-trash"></i></button>\
                                </div>\
                                <div class="col-md-2">\
                                </div>\
                            </div>';
                            $('.div-price-append').append(html);
                     }


                    if((data['price3']!="" && data['price3']!=null) && (data['quantity3']!="" && data['quantity3']!=null)){
                        var html='<div class="row" sequence="3">\
                                <div class="col-md-2 text-left">\
                                    <label class="form-label label-header"> Table Category 4</label>\
                                </div>\
                                <div class="col-md-3">\
                                   <select name="quantity3" class="text-white mt-2 mb-2 form-control input-reciepe-header input-recipe-tablecat" id="in-recipe-quantity1">';
                                            html+='<option value="">Select Category</option>';
                                        for(i in table_categories){
                                            if(table_categories[i].id==data['quantity3'])
                                                html+='<option value="'+table_categories[i].id+'" selected>'+table_categories[i].title+'</option>';
                                            else
                                                html+='<option value="'+table_categories[i].id+'">'+table_categories[i].title+'</option>';
                                        }
                                    html+='</select>\
                                </div>\
                                 <div class="col-md-1 text-left">\
                                    <label class="form-label label-header"> Price 4</label>\
                                </div>\
                                <div class="col-md-2">\
                                    <input type="text" name="price3" value="'+data['price3']+'" class="text-white mt-2 mb-2 form-control input-reciepe-header input-recipe-price" onclick="this.select();" id="in-recipe-price1">\
                                </div>\
                                <div class="col-md-1 text-left">\
                                    <button class="btn btn-light btn-remove-price" type="button" style="border: 0px !important;margin-top:10px;margin-top: 1rem;" data-id="'+data_id+'"><i class="fas fa-trash"></i></button>\
                                </div>\
                                <div class="col-md-2">\
                                </div>\
                            </div>';
                            $('.div-price-append').append(html);
                     }
               }
               else{
                    Masterrecipelist.displaywarning("Something went wrong please try again");
               }
            }
        });
    },
    updateRecipes:function(data){
        if($(this).val()==""){
            Masterrecipelist.displaywarning("please enter recipe correct price");
            $(this).focus();
            return false;
        }

        var data={
            id : $(this).attr('recipe-id'),
            price:$(this).val(),
        }
        $(this).toggle();
        $(this).closest('tr').find('.td-price-view').toggle();
        $.ajax({
            url: Masterrecipelist.base_url+"Menumaster/update_price/",
            type:'POST',
            dataType: 'json',
            data: data,
            success: function(result){
                var data=result.recipe;
                if (result.status) { 
                    var data={
                        per_page:$('.dropdown-toggle').attr('selected-per-page'),
                        page:$(this).attr('page-no'),
                        group_id:Masterrecipelist.group_id,
                        main_menu_id:1
                    }
                    Masterrecipelist.listRecipes(data);
                }else{
                    Masterrecipelist.displaywarning(result.msg);
                }
            }
        });
    },
    onImageUpload:function(event){
        if($(this).val()==""){
            /*displaywarning('please select file to upload.');*/
            return false;
        }
        var recipe_id=$(this).attr('recipe-id');
        var ext = $(this).val().split('.').pop().toLowerCase();
            if($.inArray(ext, ['jpg','jpeg','png']) == -1) {
                Masterrecipelist.displaywarning('invalid extension!');
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
                    Masterrecipelist.displaywarning("File size is too big. please select the file less than 1MB.");
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
                        },function () { 
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
                            $.ajax({
                                url: Masterrecipelist.base_url+"Menumaster/update_recipe_image",
                                type:'POST',
                                data: $form_data,
                                processData:false,
                                contentType:false,
                                cache:false,
                                success: function(result){
                                    $('#image-loader').hide();
                                    if (result.status) { 
                                        $('.recipe-image-upload').attr('data-image-src',Masterrecipelist.base_url+result.path);
                                        $(".recipe-image-upload").css("background", "url(" + Masterrecipelist.base_url+result.path + ")");
                                        
                                    } 
                                    else{
                                        if(result.msg){
                                            Masterrecipelist.displaywarning(result.msg);
                                        }
                                        else
                                            Masterrecipelist.displaywarning("Something went wrong please try again");
                                    }
                                    $('#image-loader').hide();
                                    var data={
                                        per_page : 30,
                                        page:1,
                                        group_id:Masterrecipelist.group_id,
                                        main_menu_id:1
                                    }
                                    Masterrecipelist.listRecipes(data);
                                }
                            });
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
                Masterrecipelist.displaywarning("Your browser does not support File API");  
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
            url: Masterrecipelist.base_url+"Menumaster/active_inactive_recipe",
            type:'POST',
            data:formData ,
            success: function(result){
               if (result.status) {
                var data={
                    per_page:$('.dropdown-toggle').attr('selected-per-page'),
                    page:1,
                    group_id:Masterrecipelist.group_id,
                    main_menu_id:1

                }
                   Masterrecipelist.listRecipes(data);
               }
               else{
                    Masterrecipelist.displaywarning("Something went wrong please try again");
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
                url: Masterrecipelist.base_url+"Menumaster/delete_recipe",
                type:'POST',
                data:formData ,
                success: function(result){
                   if (result.status) {
                    var data={
                        per_page:30,
                        page:1,
                        group_id:Masterrecipelist.group_id,
                        main_menu_id:1

                    }
                       Masterrecipelist.listRecipes(data);
                   }
                   else{
                        Masterrecipelist.displaywarning("Something went wrong please try again");
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
    loadTableCategories:function(){
        $.ajax({
            url: Masterrecipelist.base_url+"Menumaster/list_table_categories",
            type:'POST',
            dataType: 'json',
            data: {},
            success: function(result){
                Masterrecipelist.table_categories=result;
                $('.input-recipe-tablecat').html('');
                var html="<option value=''>Select Category</option>";
                for (i in result) {
                    html+='<option value="'+result[i].id+'">'+result[i].title+'</option>';
                }
                $('.input-recipe-tablecat').html(html);
            }
        });
    },
    listRecipes:function(data,fromevent){
        
        $.ajax({
            url: Masterrecipelist.base_url+"Menumaster/list_recipes/",
            type:'POST',
            dataType: 'json',
            data: data,
            success: function(response){
                /*$('#image-loader').hide();*/
                var recipe=response.recipes;
                var html="";
                for (i in recipe) {
                        html+='<tr>';
						if((recipe[i].img_id=="null") || (recipe[i].img_id=="") || (recipe[i].img_id=='NULL')){
							html+='<td></td>';
						}else{
							html+='<td>'+recipe[i].img_id+'</td>';
						}
                        if(recipe[i].recipe_image=="assets/images/users/menu.png"){
                            html+='<td>\
                            <input type="file" recipe-id="'+recipe[i].id+'" class="imgupload" accept="image/jpeg, image/png" style="display:none"/>\
                            <img class="img-upload"  src="'+Masterrecipelist.base_url+'assets/images/upload.png" style="height:50px;width:50px;">\
                            </td>';
                        }
                        else{
                            if(recipe[i].recipe_image==""){
                                html+='<td>\
                                <input type="file" recipe-id="'+recipe[i].id+'" class="imgupload" accept="image/jpeg, image/png" style="display:none"/>\
                                <img class="img-upload" src="'+Masterrecipelist.base_url+'assets/images/upload.png" style="height:50px;width:50px;"></td>';
                            }else{

                                html+='<td>\
                                <input type="file" recipe-id="'+recipe[i].id+'" class="imgupload" accept="image/jpeg, image/png" style="display:none"/>\
                                <img class="img-upload" src="'+recipe[i].recipe_image+'" style="height:50px;width:50px;"></td>';
                            }
                        }

                        html+='<td>\
                            <a href="'+Masterrecipelist.base_url+'Menumaster/create/'+recipe[i].id+'" data-id="'+recipe[i].id+'" alacalc-recipe-id="'+recipe[i].alacal_recipe_id+'" style="color:#000;">'+recipe[i].name+'</a>\
                        </td>\
                        <td>'+recipe[i].long_desc+'</td>';
                        html+='<td>'+recipe[i].declaration_name+'</td>';
                        html+='<td>\
                            <a href="'+Masterrecipelist.base_url+'Menumaster/create/'+recipe[i].id+'" data-id="'+recipe[i].id+'" alacalc-recipe-id="'+recipe[i].alacal_recipe_id+'" class="btn-edit-recipe" style="margin-right:10px;color:#089e60 !important;"><i class="fas fa-edit "></i></a>\
                            <a href="javascript:;" data-id="'+recipe[i].id+'" alacalc-recipe-id="'+recipe[i].alacal_recipe_id+'" class="btn-delete-recipe"><i class="fas fa-trash c-usda_sr28"></i></a></td>';
                        
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