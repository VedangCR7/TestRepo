var Recipelist ={
    base_url:null,
    group_id:null,
    is_category_prices:null,
    table_categories:null,
    main_menu_id:null,
    init:function() {
        this.bind_events();
        if(Recipelist.main_menu_id!=""){
            $('#master_menu').val(Recipelist.main_menu_id);
            $('.span-master-menuname').html($('#master_menu option:selected').html());
        }
        var data={
            per_page : 30,
            page:1,
            group_id:Recipelist.group_id,
            main_menu_id:$('#master_menu').val()
        }
        this.listRecipes(data);
        this.loadTableCategories();
    },

    bind_events :function() {
        var self=this;
        $('.span-master-menuname').html($('#master_menu option:selected').html());
        $('#searchRecipeInput').on('keyup',function(){
            if($(this).val()==""){
                var data={
                    per_page:$('.dropdown-toggle').attr('selected-per-page'),
                    page: $('.btn-current-pageno').attr('curr-page'),
                    group_id:Recipelist.group_id,
                    main_menu_id:$('#master_menu').val()
                }
                Recipelist.listRecipes(data,'fromsearch');
            }else{
                if($(this).val().length>=3){
                    var data={
                        per_page:'all',
                        page:$('.btn-current-pageno').attr('curr-page'),
                        group_id:Recipelist.group_id,
                        searchkey:$('#searchRecipeInput').val(),
                        main_menu_id:$('#master_menu').val()
                    }
                    Recipelist.listRecipes(data,'fromsearch');
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
                page:$('.btn-current-pageno').attr('curr-page'),
                group_id:Recipelist.group_id,
                main_menu_id:$('#master_menu').val()
            }
            Recipelist.listRecipes(data);
        });
        $('.btn-prev').on('click',function(){
            var data={
                per_page:$('.dropdown-toggle').attr('selected-per-page'),
                page:$(this).attr('page-no'),
                group_id:Recipelist.group_id,
                main_menu_id:$('#master_menu').val()
            }
            Recipelist.listRecipes(data);
        });
        $('.btn-next').on('click',function(){
            var data={
                per_page:$('.dropdown-toggle').attr('selected-per-page'),
                page:$(this).attr('page-no'),
                group_id:Recipelist.group_id,
                main_menu_id:$('#master_menu').val()

            }
            Recipelist.listRecipes(data);
        });
        $('.tbody-recipes-list').on('click','.btn-delete-recipe',this.deleteRecipe);
        $('.tbody-recipes-list').on('click','.btn-edit-recipe',this.editRecipe);
        $('.tbody-recipes-list').on('click','.input-switch-box',this.activeInactiveRecipe);
        $('.tbody-recipes-list').on('click','.img-upload',function(){
            $(this).closest('tr').find('.imgupload').off().trigger('click');
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

        $('.new-recipe-a').on('click',function(){
			debugger;
            var link=Recipelist.base_url+"recipes/addrecipe/"+$('#master_menu').val();
            window.location.href=link;
        });

        $('#master_menu').on('change',function(){
			//alert($(this).val());
			if($(this).val() == 'New'){
				var data={
					per_page:$('.dropdown-toggle').attr('selected-per-page'),
					page: $('.btn-current-pageno').attr('curr-page'),
					group_id:Recipelist.group_id,
					main_menu_id:$(this).val()
				}
				$('.hide_add_new_recipe').hide();
			}else{				
				var data={
					per_page:$('.dropdown-toggle').attr('selected-per-page'),
					page: $('.btn-current-pageno').attr('curr-page'),
					group_id:Recipelist.group_id,
					main_menu_id:$(this).val()
				}
				$('.hide_add_new_recipe').show();

			}
            Recipelist.listRecipes(data);

            $('.span-master-menuname').html($('#master_menu option:selected').html());
        });
						
		$('.addcsv').on('click',function(){
			$(this).closest('div').find('.uploadfile').trigger('click');
		});
				
        $('.uploadfile').on('change',this.uploadexlfile);		
    },
    deleteRecipePrice:function(){
        var self=$(this);
        var seq=$(this).closest('.row').attr('sequence');
        var recipe_id=$('.form-recipe-edit [name=id]').val();
        var recipe_price_id=$(this).attr('data-id');
        if(recipe_price_id){
            $.ajax({
                url: Recipelist.base_url+"recipes/delete_recipe_price/",
                type:'POST',
                dataType: 'json',
                data: {'sequence':seq,'recipe_id':recipe_id,'recipe_price_id':recipe_price_id},
                success: function(result){
                    var data=result.recipe;
                    if (result.status) { 
                        self.closest('.row').remove();
                         price_count=$('.inupt-recipe-pricecount').val()-1;
                        $('.inupt-recipe-pricecount').val(price_count);
                        $('.div-price-append .row').each(function(i){
                            var cnt=parseInt(i)+1;
                            var lblcnt=cnt+1;
                            $(this).find('.label-tablecategory').html('Table Category '+lblcnt);
                            $(this).find('.input-recipe-tablecat').attr('name','quantity'+cnt).attr('id','in-recipe-quantity'+cnt);
                            $(this).find('.label-price').html('Price '+lblcnt);
                            $(this).find('.input-recipe-price').attr('name','price'+cnt).attr('id','in-recipe-price'+cnt);
                        });
                    }else{
                        Recipelist.displaywarning(result.msg);
                    }
                }
            });
        }else{
            self.closest('.row').remove();
            price_count=$('.inupt-recipe-pricecount').val()-1;
            $('.inupt-recipe-pricecount').val(price_count);
            $('.div-price-append .row').each(function(i){
                var cnt=parseInt(i)+1;
                var lblcnt=cnt+1;
                $(this).find('.label-tablecategory').html('Table Category '+lblcnt);
                $(this).find('.input-recipe-tablecat').attr('name','quantity'+cnt).attr('id','in-recipe-quantity'+cnt);
                $(this).find('.label-price').html('Price '+lblcnt);
                $(this).find('.input-recipe-price').attr('name','price'+cnt).attr('id','in-recipe-price'+cnt);
            });
        }
    },
    savePrice:function()
	{
        if($('#in-recipe-quantity').val()=="" || $('#in-recipe-price').val()=="")
		{
            Recipelist.displaywarning("Please add price and quantity both");
            $('#in-recipe-quantity').focus();
            return false;
        }
		
        if(Recipelist.is_category_prices==1)
		{
            var select_cat=new Array();
            var flag_price=0,cat_type=0;
			
            $('.form-recipe-edit .input-recipe-tablecat').each(function(i)
			{
                console.log($(this).val());
                if($(this).val()=="")
				{
                    cat_type=1;
                }
                
				var price=$(this).closest('.row').find('.input-recipe-price').val();
               
				if(price=="")
				{
                    flag_price=1;
                }
                select_cat.push($(this).val());
            });
			
            console.log(cat_type);
            
			if(cat_type==1)
			{
                Recipelist.displaywarning("Table category should not be empty.");
                return false;
            }
			
            if(flag_price==1)
			{
                Recipelist.displaywarning("price should not be empty.");
                return false;
            }
			else if($('.input-recipe-price').val()<=0)
			{
				Recipelist.displaywarning("price should not be zero or minus.");
                return false;
			}
			
            var cate_duplicate = [];
            
			for (var i = 0; i < select_cat.length - 1; i++) 
			{
                if (select_cat[i + 1] == select_cat[i])
				{
                    cate_duplicate.push(select_cat[i]);
                }
            }
			
            if(cate_duplicate.length!=0)
			{
                Recipelist.displaywarning("Can not add different prices for same category ");
                return false;
            }
        }
		
        $.ajax({
            url: Recipelist.base_url+"recipes/update_recipe_price/",
            type:'POST',
            dataType: 'json',
            data: $('.form-recipe-edit').serialize(),
            success: function(result){
                var data=result.recipe;
                if (result.status) { 
                     var data={
                        per_page:$('.dropdown-toggle').attr('selected-per-page'),
                        page:$('.btn-current-pageno').attr('curr-page'),
                        group_id:Recipelist.group_id,
                        main_menu_id:$('#master_menu').val()
                    }
                    Recipelist.listRecipes(data);
                    $('.row-div-quantity').hide();
                    Recipelist.displaysucess("Information saved successfully.");
                    $('.form-recipe-edit').trigger('reset');
                    $('.div-price-append').html('');
                }else{
                    Recipelist.displaywarning(result.msg);
                }
            }
        });
    },
    addTablePriceDiv:function()
	{
        var count=$('.div-price-append .row').length;
        var cnt=parseInt(count)+1;
        var table_categories=Recipelist.table_categories;
        var labelcnt=parseInt(count)+2;
		
        if(table_categories.length-1>count)
		{
           /* if(count<3){*/
                var used_categories=new Array();
                $('.div-main-recipeheader .input-recipe-tablecat').each(function(){
                    used_categories.push($(this).val());
                });
                var html='<div class="row" sequence="'+cnt+'">\
                        <div class="col-md-2 text-left">\
                            <label class="form-label label-header label-tablecategory"> Table Category '+labelcnt+'</label>\
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
                            <label class="form-label label-header label-price"> Price '+labelcnt+'</label>\
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
                $('.inupt-recipe-pricecount').val(cnt);
            /*}else{
                 Recipelist.displaywarning("Maximum four prices are allowed.");
            }*/
        }
        else
		{
             Recipelist.displaywarning("Only "+table_categories.length+" categories available.");
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
            url: Recipelist.base_url+"recipes/get_recipe_prices",
            type:'POST',
            data:formData ,
            success: function(result){
                var recipe_prices=result.recipe;
                if (result.status) {
                    $('.input-recipe-id').val(data_id);
                    $('.div-price-append').html('');
                    var table_categories=Recipelist.table_categories;
                    for(k in recipe_prices){
                        var cnt=parseInt(k)+1;
                        if(k==0){
                            $('.input-reciperpice-id1').val(recipe_prices[k].id);
                            if(recipe_prices[k].table_category_id==0)
                                $('#in-recipe-quantity1').val('');
                            else
                                $('#in-recipe-quantity1').val(recipe_prices[k].table_category_id);
                            $('#in-recipe-price1').val(recipe_prices[k].price);
                        }
                        else{
                            var html='<div class="row" sequence="1" data-id="'+recipe_prices[k].id+'">\
                                <div class="col-md-2 text-left">\
                                    <label class="form-label label-header label-tablecategory"> Table Category '+cnt+'</label>\
                                    <input type="hidden" name="recipe_price_id'+k+'" value="'+recipe_prices[k].id+'">\
                                </div>\
                                <div class="col-md-3">\
                                     <select name="quantity'+k+'" class="text-white mt-2 mb-2 form-control input-reciepe-header input-recipe-tablecat" id="in-recipe-quantity'+k+'">';
                                          html+='<option value="">Select Category</option>';
                                        for(i in table_categories){
                                            if(table_categories[i].id==recipe_prices[k].table_category_id)
                                                html+='<option value="'+table_categories[i].id+'" selected>'+table_categories[i].title+'</option>';
                                            else
                                                html+='<option value="'+table_categories[i].id+'">'+table_categories[i].title+'</option>';
                                        }
                                    html+='</select>\
                                </div>\
                                 <div class="col-md-1 text-left">\
                                    <label class="form-label label-header label-price"> Price '+cnt+'</label>\
                                </div>\
                                <div class="col-md-2">\
                                    <input type="text" name="price'+k+'" value="'+recipe_prices[k].price+'" class="text-white mt-2 mb-2 form-control input-reciepe-header input-recipe-price" onclick="this.select();" id="in-recipe-price'+cnt+'">\
                                </div>\
                                <div class="col-md-1 text-left">\
                                    <button class="btn btn-light btn-remove-price" data-id="'+recipe_prices[k].id+'" type="button" style="border: 0px !important;margin-top:10px;margin-top: 1rem;"><i class="fas fa-trash"></i></button>\
                                </div>\
                                <div class="col-md-2">\
                                </div>\
                            </div>';
                            $('.div-price-append').append(html);
                            $('.inupt-recipe-pricecount').val(cnt)
                        }
                    }
                    $('.inupt-recipe-pricecount').val(k);    
               }
               else{
                    Recipelist.displaywarning("Something went wrong please try again");
               }
            }
        });
    },
    updateRecipes:function(data){
        if($(this).val()==""){
            Recipelist.displaywarning("please enter recipe correct price");
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
            url: Recipelist.base_url+"recipes/update_price/",
            type:'POST',
            dataType: 'json',
            data: data,
            success: function(result){
                var data=result.recipe;
                if (result.status) { 
                    var data={
                        per_page:$('.dropdown-toggle').attr('selected-per-page'),
                        page:$('.btn-current-pageno').attr('curr-page'),
                        group_id:Recipelist.group_id,
                        main_menu_id:$('#master_menu').val()
                    }
                    Recipelist.listRecipes(data);
                }else{
                    Recipelist.displaywarning(result.msg);
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
                Recipelist.displaywarning('invalid extension!');
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
                    Recipelist.displaywarning("File size is too big. please select the file less than 1MB.");
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
                        },function (swalstatus) { 
                            if(swalstatus){
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
                                    url: Recipelist.base_url+"recipes/update_recipe_image",
                                    type:'POST',
                                    data: $form_data,
                                    processData:false,
                                    contentType:false,
                                    cache:false,
                                    success: function(result){
                                        $('#image-loader').hide();
                                        if (result.status) { 
                                            $('.recipe-image-upload').attr('data-image-src',Recipelist.base_url+result.path);
                                            $(".recipe-image-upload").css("background", "url(" + Recipelist.base_url+result.path + ")");
                                            
                                        } 
                                        else{
                                            if(result.msg){
                                                Recipelist.displaywarning(result.msg);
                                            }
                                            else
                                                Recipelist.displaywarning("Something went wrong please try again");
                                        }
                                        $('#image-loader').hide();
                                        var data={
                                            per_page:$('.dropdown-toggle').attr('selected-per-page'),
                                            page:$('.btn-current-pageno').attr('curr-page'),
                                            group_id:Recipelist.group_id,
                                            main_menu_id:$('#master_menu').val()
                                        }
                                        Recipelist.listRecipes(data);
                                    }
                                });
                            }else{
                              bind_input.val('');
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
                Recipelist.displaywarning("Your browser does not support File API");  
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
            url: Recipelist.base_url+"recipes/active_inactive_recipe",
            type:'POST',
            data:formData ,
            success: function(result){
               if (result.status) {
                var data={
                    per_page:$('.dropdown-toggle').attr('selected-per-page'),
                    page:$('.btn-current-pageno').attr('curr-page'),
                    group_id:Recipelist.group_id,
                    main_menu_id:$('#master_menu').val()

                }
                   Recipelist.listRecipes(data);
               }
               else{
                    Recipelist.displaywarning("Something went wrong please try again");
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
                url: Recipelist.base_url+"recipes/delete_recipe",
                type:'POST',
                data:formData ,
                success: function(result){
                   if (result.status) {
                    var data={
                        per_page:$('.dropdown-toggle').attr('selected-per-page'),
                        page:$('.btn-current-pageno').attr('curr-page'),
                        group_id:Recipelist.group_id,
                        main_menu_id:$('#master_menu').val()

                    }
                       Recipelist.listRecipes(data);
                   }
                   else{
                        Recipelist.displaywarning("Something went wrong please try again");
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
            url: Recipelist.base_url+"recipes/list_table_categories",
            type:'POST',
            dataType: 'json',
            data: {},
            success: function(result){
                Recipelist.table_categories=result;
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
        /* $('#image-loader').show();
         $('.tbody-recipes-list').html('');*/
        $.ajax({
            url: Recipelist.base_url+"recipes/list_recipes/",
            type:'POST',
            dataType: 'json',
            data: data,
            success: function(response){
                /*$('#image-loader').hide();*/
                var recipe=response.recipes;
                var html="";
				
                for (i in recipe) 
				{
					html+='<tr>';
					if(recipe[i].product_code==null)
					{
						html+='<td></td>';
					}
					else
					{
						html+='<td>'+recipe[i].product_code+'</td>';	
					}
                    
					if(recipe[i].recipe_image=="assets/images/users/menu.png")
					{
                           html+='<td>\
                           <input type="file" recipe-id="'+recipe[i].id+'" class="imgupload" accept="image/jpeg, image/png" style="display:none"/>\
                            <img class="img-upload"  src="'+Recipelist.base_url+'assets/images/upload.png" style="height:50px;width:50px;">\
                            </td>';
                    }
                    else
					{
						if(recipe[i].recipe_image=="")
						{
							html+='<td>\
                            <input type="file" recipe-id="'+recipe[i].id+'" class="imgupload" accept="image/jpeg, image/png" style="display:none"/>\
                            <img class="img-upload" src="'+Recipelist.base_url+'assets/images/upload.png" style="height:50px;width:50px;"></td>';
                        }
						else
						{
                                html+='<td>\
                                <input type="file" recipe-id="'+recipe[i].id+'" class="imgupload" accept="image/jpeg, image/png" style="display:none"/>\
                                <img class="img-upload" src="'+recipe[i].recipe_image+'" style="height:50px;width:50px;"></td>';
						}
					}

					html+='<td>\
						<a href="'+Recipelist.base_url+'recipes/create/'+recipe[i].id+'" data-id="'+recipe[i].id+'" alacalc-recipe-id="'+recipe[i].alacal_recipe_id+'" style="color:#000;">'+recipe[i].name+'</a>\
					</td>\
					<td>'+recipe[i].group_name+'</td>';
					if(Recipelist.is_category_prices==0)
					{
						html+='<td>\
							<span class="td-price-view" style="cursor:pointer;width:100%;">'+recipe[i].price+'</span>\
							<input type="text" recipe-id="'+recipe[i].id+'" name="price" value="'+recipe[i].price+'" class="mt-2 mb-2 form-control input-price-edit input-recipe-price" onclick="this.select();" id="in-recipe-price" maxlength="9" style="display:none;">\
						</td>';
					}
					else
					{
						html+='<td>\
							<span style="cursor:pointer;width:100%;">'+recipe[i].price+'</span>\
						</td>';
					}
					html+='<td>'+recipe[i].recipe_date+'</td>';
                    
					if(recipe[i].is_sample==0)
					{
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
					{
						if(Recipelist.is_category_prices==0)
						{
							html+='<td><a href="javascript:;" data-id="'+recipe[i].id+'" alacalc-recipe-id="'+recipe[i].alacal_recipe_id+'" class="btn-delete-recipe"><i class="fas fa-trash c-usda_sr28"></i></a></td>';
						}
						else
						{
							html+='<td>\
                            <a href="javascript:;" data-id="'+recipe[i].id+'" alacalc-recipe-id="'+recipe[i].alacal_recipe_id+'" class="btn-edit-recipe" style="margin-right:10px;color:#089e60 !important;"><i class="fas fa-edit "></i></a>\
                            <a href="javascript:;" data-id="'+recipe[i].id+'" alacalc-recipe-id="'+recipe[i].alacal_recipe_id+'" class="btn-delete-recipe"><i class="fas fa-trash c-usda_sr28"></i></a></td>';
						}
					}
                    html+='</tr>';
                }
                $('.tbody-recipes-list').html(html);
                $('.span-all-recipes').html(response.total_count);
                $('.span-page-html').html(response.page_total_text);
                console.log(response.page_no);
                $('.btn-current-pageno').attr('curr-page',response.page_no);
                
				if(parseInt(response.page_no)>1)
				{
                    var prev_page=parseInt(response.page_no)-1;
                    $('.btn-prev').attr('page-no',prev_page);
                    $('.btn-prev').removeAttr('disabled');
                }
				else
				{
                    $('.btn-prev').attr('disabled',true);
					$('.btn-prev').prop('disabled', true);
				}

                if(parseInt(response.page_no)<parseInt(response.total_pages))
				{
                    var next_page=parseInt(response.page_no)+1;
                    $('.btn-next').attr('page-no',next_page);
                    $('.btn-next').removeAttr('disabled');
                }
				else
				{
                     $('.btn-next').attr('disabled',true);
                     $('.btn-next').prop('disabled', true);
                }

             /*   if(fromevent=="fromsearch"){
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
	
	uploadexlfile:function()
	{
        debugger;
        var $form_data = new FormData();
        $form_data.append('uploadFile',$('.uploadfile')[0].files[0]);
        //console.log($form_data);
        $.ajax({
            url: Recipelist.base_url+"recipes/uploadmenuData",
            type:'POST',
            data: $form_data,
            processData:false,
            contentType:false,
            cache:false,
            success: function(result)
			{
                console.log(result);
                $('#image-loader').show();
                
				if (result.status) 
				{
                    Recipelist.displaysucess("upload successfully");
                } 
                else
				{
                    Recipelist.displaywarning(result.msg);
                }
				
                $('#image-loader').hide();
                
				var data={
                    per_page:$('.btn-per-page').attr('selected-per-page'),
                    page:1
                }
                Recipelist.listRecipes(data);
            }
        });
    },
};