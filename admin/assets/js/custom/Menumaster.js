var Menumaster ={
    base_url:null,
    init:function() {
        this.bind_events();
        var data={
            per_page : $('.btn-per-page').attr('selected-per-page'),
            page:1
        }
        /* this.listGroups(data); */
    },

    bind_events :function() {
        $('.tbody-group-list').on('click','.img-upload',function(){
            $(this).closest('tr').find('.imgupload').trigger('click');
        });
        $('.tbody-group-list').on('change','.imgupload',this.onImageUpload);

    },
	onImageUpload:function(event){
        if($(this).val()==""){
            
            return false;
        }
        var recipe_id=$(this).attr('recipe-id');
        var ext = $(this).val().split('.').pop().toLowerCase();
            if($.inArray(ext, ['jpg','jpeg','png']) == -1) {
                Menumaster.displaywarning('invalid extension!');
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
                            imageData = canvas.toDataURL('image/jpeg',0.8); 
                           
                            $form_data.append('image', imageData);
                            $('.recipe-image-upload').attr('data-image-src',imageData);
                            $(".recipe-image-upload").css("background", "url(" + imageData + ")");
                            $form_data.append('id',recipe_id);
                            $.ajax({
                                url: Menumaster.base_url+"admin/update_menugroup_image",
                                type:'POST',
                                data: $form_data,
                                processData:false,
                                contentType:false,
                                cache:false,
                                success: function(result){
                                    $('#image-loader').hide();
                                    if (result.status) { 
                                        $('.recipe-image-upload').attr('data-image-src',Menumaster.base_url+result.path);
                                        $(".recipe-image-upload").css("background", "url(" + Menumaster.base_url+result.path + ")");
                                        
                                    } 
                                    else{
                                        if(result.msg){
                                            Menumaster.displaywarning(result.msg);
                                        }
                                        else
                                            Menumaster.displaywarning("Something went wrong please try again");
                                    }
                                    $('#image-loader').hide();
                                    var data={
                                        per_page : 30,
                                        page:1,
                                        group_id:Menumaster.group_id,
                                        main_menu_id:1
                                    }
                                    Menumaster.listRecipes(data);
                                }
                            });
                        }, function (dismiss) {
                            if (dismiss === 'cancel') {
                               
                            }
                        });
                    }  
                    img.onerror = function () {  
                         $("#cropbox").attr('src','');
                        $('#image-loader').hide();
                       
                    }  
                });  
                /* Read the image   */
                picReader.readAsDataURL(file);  
            } else {  
                Menumaster.displaywarning("Your browser does not support File API");  
                $("#cropbox").attr('src','');
                $('#image-loader').hide();
            }  
    },
	
    onImageUpload:function(event){
        if($(this).val()==""){
              return false;
            }
        var group_id=$(this).attr('group-id');
        var ext = $(this).val().split('.').pop().toLowerCase();
            if($.inArray(ext, ['jpg','jpeg','png']) == -1) {
                Menumaster.displaywarning('invalid extension!');
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
            if (target.files && target.files[0]) {
                /* allow less than 1mb */
                const maxAllowedSize = 1 * 1024 * 1024;
                if (target.files[0].size > maxAllowedSize) {
                 /* Here you can ask your users to load correct file */
                    $('#image-loader').hide();
                    Menumaster.displaywarning("File size is too big. please select the file less than 1MB.");
                    return false;
                }
            }
           
            var defaults = {  
                maxWidth: Number.MAX_VALUE,  
                maxHeigt: Number.MAX_VALUE,  
                onImageResized: null  
            }  
            var options={
                maxWidth: 200,
                maxHeigt:121
            }
            var settings = $.extend({}, defaults, options); 
            
            if (window.File && window.FileList && window.FileReader) { 
                var files = event.target.files;  
                var file = files[0];  
                
                var picReader = new FileReader();  
                picReader.addEventListener("load", function (event) {

                    var picFile = event.target;  
                    var imageData = picFile.result;  
                    var img = new Image();  
                    img.src = imageData;  
                    img.onload = function () {  
                        swal({
                            title: 'File requirement :',
                            text: "JPG, PNG up to 1MB. Minimum pixels required: 200 for width, 200 for height.",
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
                            canvas.width = 200;  
                            canvas.height = 121;  
                            var context = canvas.getContext('2d');  
                            context.fillStyle = "transparent";
                            context.drawImage(img, 0, 0, 200, 121); 
                            imageData = canvas.toDataURL('image/jpeg',0.8); 
                           
                            $form_data.append('image', imageData);
                           
                            $form_data.append('id',group_id);
                            $.ajax({
                                url: Menumaster.base_url+"admin/update_menugroup_image",
                                type:'POST',
                                data: $form_data,
                                processData:false,
                                contentType:false,
                                cache:false,
                                success: function(result){
                                    $('#image-loader').hide();
                                    if (result.status) { 
                                       
                                    } 
                                    else{
                                        if(result.msg){
                                            Menumaster.displaywarning(result.msg);
                                        }
                                        else
                                            Menumaster.displaywarning("Something went wrong please try again");
                                    }
                                    $('#image-loader').hide();
                                    var data={
                                        per_page:$('.btn-per-page').attr('selected-per-page'),
                                        page:1
                                    }
                                    /* Menumaster.listGroups(data); */
                                }
                            });
                        }, function (dismiss) {
                            if (dismiss === 'cancel') {
                               
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
                Menumaster.displaywarning("Your browser does not support File API");  
                $("#cropbox").attr('src','');
                $('#image-loader').hide();
            }  
    },
    
    onSaveGroupname:function(){
        if($('#AddMenuGroup').val()!=""){
            if($('.select-main-menu').val()==""){
                Menumaster.displaywarning("please select main menu");
                return false;
            }
            $.ajax({
                url: Menumaster.base_url+"school/save_menu_group",
                type:'POST',
                dataType: 'json',
                data: {
                    group_name : $('#AddMenuGroup').val(),
                    available_in : $('#AddMenuGroupTime').val(),
                    group_id:$('#menu_group_id').val(),
                    is_edit_group:$('#is_edit_group').val(),
                    main_menu_id:$('.select-main-menu').val()
                },
                success: function(result){
                    if (result.status) { 
                        if(result.is_group_exist){
                            Menumaster.displaywarning("Menu group already exist.");
                        }else{
                            if($('#is_edit_group').val()=="edit")
                                Menumaster.displaysucess("Menu group updated successfully");
                            else
                                Menumaster.displaysucess("Menu group created successfully");
                            var data={
                                per_page:$('.btn-per-page').attr('selected-per-page'),
                                page:1
                            }
                            /* Menumaster.listGroups(data); */
                        }
                        $('#AddMenuGroup').val('');
                        $('#AddMenuGroupTime').val('');
                        $('#menu_group_id').val('');
                        $('#is_edit_group').val('');
                        $('.select-main-menu').val('1');
                        $('.btn-add-group').html('ADD');
                        
                    }else{
                        Menumaster.displaywarning(result.msg);
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
            url: Menumaster.base_url+"school/delete_group",
            type:'POST',
            data:formData ,
            success: function(result){
               if (result.status) {
                    var data={
                        per_page:$('.btn-per-page').attr('selected-per-page'),
                        page:1
                    }
                   /* Menumaster.listGroups(data); */
               }
               else{
                    Menumaster.displaywarning("Something went wrong please try again");
               }
            }
        });
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
                url: Menumaster.base_url+"school/delete_menu_group",
                type:'POST',
                data:formData ,
                success: function(result){
                   if (result.status) {
                        var data={
                            per_page:$('.btn-per-page').attr('selected-per-page'),
                            page:1
                        }
                       /* Menumaster.listGroups(data); */
                   }
                   else{
                        Menumaster.displaywarning("Something went wrong please try again");
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
    displaysucess:function(msg)
    {
        swal("Success !",msg,"success");
    },

    displaywarning:function(msg)
    {
        swal("Error !",msg,"error");
    },

};