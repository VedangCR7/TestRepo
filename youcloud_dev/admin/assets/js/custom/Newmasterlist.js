var Newmasterlist ={
    base_url:null,
    init:function() {
        this.bind_events();
        var data={
            per_page : $('.btn-per-page').attr('selected-per-page'),
            page:1
        }
        this.listGroups(data);
         this.listMainGroup();
    },

    bind_events :function() {
        var self=this;
        $('.tbody-group-list').on('click','.a-edit-group',function(){
            var group_id=$(this).attr("data-id");
            var group_name=$(this).attr("group-name");
            var available_in=$(this).attr("long-desc");
            var main_menu_id=$(this).attr('declaration-name');
            $('#AddMenuGroup').val(group_name);
            $('#AddMenuGroupTime').val(available_in);
            $('#menu_group_id').val(group_id);
            $('#decname').val(main_menu_id);
            $('#is_edit_group').val('edit');
            $('.btn-add-group').html('UPDATE');
            $('#AddMenuGroup').focus();
            $('html, body').animate({
                scrollTop: $(".app-content").offset().top
            }, 500);
        });
        $('.a-recipe-perpage').on('click',function(){
            $(this).closest('.btn-group').find('button').attr('selected-per-page',$(this).attr('data-per'));
            if($(this).attr('data-per')=="all")
                $(this).closest('.btn-group').find('button').html($(this).html()+' items');
            else
                $(this).closest('.btn-group').find('button').html($(this).html()+' items per page');
            var data={
                per_page:$(this).attr('data-per'),
                page:1
            }
            Newmasterlist.listGroups(data);
        });
        $('.btn-prev').on('click',function(){
            var data={
                per_page:$('.dropdown-toggle').attr('selected-per-page'),
                page:$(this).attr('page-no')
            }
            Newmasterlist.listGroups(data);
        });
        $('.btn-next').on('click',function(){
            var data={
                per_page:$('.dropdown-toggle').attr('selected-per-page'),
                page:$(this).attr('page-no')
            }
            Newmasterlist.listGroups(data);
        });
        $('#searchInput').on('keyup',function(){
           
             if($(this).val()==""){
                var data={
                    per_page:$('.dropdown-toggle').attr('selected-per-page'),
                    page:1
                }
                Newmasterlist.listGroups(data,'fromsearch');
            }else{
                if($(this).val().length>=3){
                    var data={
                        per_page:'all',
                        page:1,
                        searchkey:$('#searchInput').val()
                    }
                    Newmasterlist.listGroups(data,'fromsearch');
                }
            }
        });
        $('.tbody-group-list').on('click','.input-switch-box',this.deleteGroup);
         $('.tbody-group-list').on('click','.a-delete-group',this.onDeleteGroup);

        $('.btn-add-group').on('click',this.onSaveGroupname);
        $('#AddMenuGroup').on('keypress',function(e){
            //var string = string.replace(/\s\s+/g, ' ');
           /* var singleSpacesString=$(this).val().replace(/  +/g, ' ');
            $(this).val(singleSpacesString);*/
            var regex = new RegExp("^[a-zA-Z0-9_~!@#$%&*^()`~':.?,;{}|<> ]+$");
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
            if (regex.test(str)) {
                return true;
            }
            e.preventDefault();
            return false;
        });

        $('.tbody-group-list').on('click','.up,.down',function () {
              var row = $(this).parents('tr:first'), $reindex_start;
              console.log($reindex_start);
              if ($(this).is('.up')) {
                    row.insertBefore(row.prev());
                    $reindex_start=row;
              }
              else {
                    $reindex_start=row.next()
                    row.insertAfter($reindex_start);
              }
              row.focus();
              var data=[];
              var seq=1;
              $('.tbody-group-list tr').each(function(){
                    var row={
                        id:$(this).attr('menu-id'),
                        seq:seq
                    }
                    data.push(row);
                    seq++;
              });
              console.log(data);
              Newmasterlist.onSaveSequence(data);
        });

        $('.tbody-group-list').on('click','.img-upload',function(){
            $(this).closest('tr').find('.imgupload').trigger('click');
        });
        $('.tbody-group-list').on('change','.imgupload',this.onImageUpload);
		
	},
    onImageUpload:function(event){
        if($(this).val()==""){
            /*displaywarning('please select file to upload.');*/
            return false;
        }
        var recipe_id=$(this).attr('group-id');
        var ext = $(this).val().split('.').pop().toLowerCase();
            if($.inArray(ext, ['jpg','jpeg','png']) == -1) {
                Newmasterlist.displaywarning('invalid extension!');
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
                    Newmasterlist.displaywarning("File size is too big. please select the file less than 1MB.");
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
                            /* $('.recipe-image-upload').attr('data-image-src',imageData);
                            $(".recipe-image-upload").css("background", "url(" + imageData + ")"); */
                            $form_data.append('id',recipe_id);
                            $.ajax({
                                url: Newmasterlist.base_url+"Newmaster/update_recipe_image",
                                type:'POST',
                                data: $form_data,
                                processData:false,
                                contentType:false,
                                cache:false,
                                success: function(result){
                                    $('#image-loader').hide();
                                    if (result.status) { 
                                        /* $('.recipe-image-upload').attr('data-image-src',Newmasterlist.base_url+result.path);
                                        $(".recipe-image-upload").css("background", "url(" + Newmasterlist.base_url+result.path + ")"); */
                                        
                                    } 
                                    else{
                                        if(result.msg){
                                            Newmasterlist.displaywarning(result.msg);
                                        }
                                        else
                                            Newmasterlist.displaywarning("Something went wrong please try again");
                                    }
                                    $('#image-loader').hide();
                                    var data={
                                        per_page : 30,
                                        page:1,
                                        group_id:Newmasterlist.group_id,
                                        main_menu_id:1
                                    }
                                    Newmasterlist.listGroups(data);
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
                Newmasterlist.displaywarning("Your browser does not support File API");  
                $("#cropbox").attr('src','');
                $('#image-loader').hide();
            }  
    },
    onSaveSequence:function(dataarr){
        console.log(dataarr);
        $.ajax({
            url: Newmasterlist.base_url+"school/change_group_sequence",
            type:'POST',
            data: { data:JSON.stringify(dataarr) },
            success: function(result){
                if (result.status) { 
                    var data={
                        per_page:$('.btn-per-page').attr('selected-per-page'),
                        page:1
                    }
                    Newmasterlist.listGroups(data);
                }else{
                    Newmasterlist.displaywarning(result.msg);
                }
            }
        });

    },
    onSaveGroupname:function(){
        if($('#AddMenuGroup').val()!=""){
            /* if($('.select-main-menu').val()==""){
                Newmasterlist.displaywarning("please select main menu");
                return false;
            } */
            $.ajax({
                url: Newmasterlist.base_url+"Newmaster/save_menu",
                type:'POST',
                dataType: 'json',
                data: {
                    group_name : $('#AddMenuGroup').val(),
                    available_in : $('#AddMenuGroupTime').val(),
                    /* group_id:$('#menu_group_id').val(),
                    is_edit_group:$('#is_edit_group').val(),*/ 
                    main_menu_id:$('#decname').val()
                },
                success: function(result){
                    if (result.status) { 
                        if(result.is_group_exist){
                            Newmasterlist.displaywarning("Menu group already exist.");
                        }else{
                            if($('#is_edit_group').val()=="edit")
                                Newmasterlist.displaysucess("Menu group updated successfully");
                            else
                                Newmasterlist.displaysucess("Menu group created successfully");
                            var data={
                                per_page:$('.btn-per-page').attr('selected-per-page'),
                                page:1
                            }
                            Newmasterlist.listGroups(data);
                        }
                        $('#AddMenuGroup').val('');
                        $('#AddMenuGroupTime').val('');
                        $('#menu_group_id').val('');
                        $('#is_edit_group').val('');
                        $('.select-main-menu').val('1');
                        $('.btn-add-group').html('ADD');
                        
                    }else{
                        Newmasterlist.displaywarning(result.msg);
                    }
                }
            });
        }

    },
    deleteGroup:function(){
        if($(this).is(':checked'))
            $(this).val("on");
        else
            $(this).val("off");

        var self=this;
        var data_id=$(this).attr('data-id');
        var formData={
            id : data_id,
            is_active:$(this).val()
        } 
        $.ajax({
            url: Newmasterlist.base_url+"school/delete_group",
            type:'POST',
            data:formData ,
            success: function(result){
               if (result.status) {
                    var data={
                        per_page:$('.btn-per-page').attr('selected-per-page'),
                        page:1
                    }
                   Newmasterlist.listGroups(data);
               }
               else{
                    Newmasterlist.displaywarning("Something went wrong please try again");
               }
            }
        });
        /*swal({
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
           
             
        }, function (dismiss) {
            if (dismiss === 'cancel') {
                swal(
                  'Cancelled',
                  'Your record is safe :)',
                  'error'
                )
            }
        });*/
    },
    onDeleteGroup:function(){
        var self=this;
        var data_id=$(this).attr('data-id');
        var recipe_count=$(this).attr('recipe-count');
        if(recipe_count>0){
        console.log(recipe_count);
            var title='Delete Group';
            var text=" There are some recipes in this menu group. Are you sure ? you want to delete menu group and recipe";
        }else{
            var title='Are you sure ?';
            var text="Delete Group";
        }
        swal({
            title: title,
            text: text,
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33 !important',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false
        },function () {
            var formData={
                id : data_id
            } 
            $.ajax({
                url: Newmasterlist.base_url+"school/delete_menu_group",
                type:'POST',
                data:formData ,
                success: function(result){
                   if (result.status) {
                        var data={
                            per_page:$('.btn-per-page').attr('selected-per-page'),
                            page:1
                        }
                       Newmasterlist.listGroups(data);
                   }
                   else{
                        Newmasterlist.displaywarning("Something went wrong please try again");
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
    listMainGroup:function(){
        $.ajax({
            url: Newmasterlist.base_url+"school/list_main_menu_group/",
            type:'POST',
            dataType: 'json',
            data: {},
            success: function(response){
                var groups=response;
                var html="";
                for (i in groups) {

                    html+='<option value="'+groups[i].id+'">'+groups[i].name+'</option>';
                }
                $('.select-main-menu').html(html);
            }
        });
    },
    listGroups:function(data,fromevent){
        $.ajax({
            url: Newmasterlist.base_url+"Newmaster/list_recipes/",
            type:'POST',
            dataType: 'json',
            data: data,
            success: function(response){
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
                            <img class="img-upload"  src="'+Newmasterlist.base_url+'assets/images/upload.png" style="height:50px;width:50px;">\
                            </td>';
                        }
                        else{
                            if(recipe[i].recipe_image==""){
                                html+='<td>\
                                <input type="file" recipe-id="'+recipe[i].id+'" class="imgupload" accept="image/jpeg, image/png" style="display:none"/>\
                                <img class="img-upload" src="'+Newmasterlist.base_url+'assets/images/upload.png" style="height:50px;width:50px;"></td>';
                            }else{

                                html+='<td>\
                                <input type="file" recipe-id="'+recipe[i].id+'" class="imgupload" accept="image/jpeg, image/png" style="display:none"/>\
                                <img class="img-upload" src="'+recipe[i].recipe_image+'" style="height:50px;width:50px;"></td>';
                            }
                        }

                        html+='<td>\
                            <p style="max-width:310px!important;word-wrap:break-word!important;overflow-x: scroll!important;overflow-y: hidden;overflow-wrap: break-word; white-space: nowrap;"><a href="'+Newmasterlist.base_url+'Menumaster/create/'+recipe[i].id+'" data-id="'+recipe[i].id+'" alacalc-recipe-id="'+recipe[i].alacal_recipe_id+'" style="color:#000;">'+recipe[i].name+'</a>\
                        </p></td>';
                        html+='<td><p style="max-width:370px!important;word-wrap:break-word!important;overflow-x: scroll!important;overflow-y: hidden;overflow-wrap: break-word; white-space: nowrap;">'+recipe[i].declaration_name+'</p></td>';
                        html+='<td>\
                            <a class="a-edit-group" declaration-name="'+recipe[i].declaration_name+'" group-name="'+recipe[i].name+'" long-desc="'+recipe[i].long_desc+'" data-id="'+recipe[i].id+'" style="color:#089e60;margin-right:10px;cursor: pointer;"><i class="fa fa-edit"></i></a>\
                            <a href="javascript:;" data-id="'+recipe[i].id+'" alacalc-recipe-id="'+recipe[i].alacal_recipe_id+'" class="btn-delete-recipe"><i class="fas fa-trash c-usda_sr28"></i></a></td>';
                        
                    html+='</tr>';
                }
                $('.tbody-group-list').html(html);
                $('.span-all-groups').html(response.total_count);
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