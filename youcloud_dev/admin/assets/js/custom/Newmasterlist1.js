var Newmasterlist1 ={
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
            var available_in=$(this).attr("available-in");
            var main_menu_id=$(this).attr('main-menu-id');
            $('#AddMenuGroup').val(group_name);
            $('#AddMenuGroupDName').val(available_in);
            $('#menu_group_id').val(group_id);
            $('#AddMenuGroupTime').val(main_menu_id);
           
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
            Newmasterlist1.listGroups(data);
        });
        $('.btn-prev').on('click',function(){
            var data={
                per_page:$('.dropdown-toggle').attr('selected-per-page'),
                page:$(this).attr('page-no')
            }
            Newmasterlist1.listGroups(data);
        });
        $('.btn-next').on('click',function(){
            var data={
                per_page:$('.dropdown-toggle').attr('selected-per-page'),
                page:$(this).attr('page-no')
            }
            Newmasterlist1.listGroups(data);
        });
        $('#searchInput').on('keyup',function(){
           
             if($(this).val()==""){
                var data={
                    per_page:$('.dropdown-toggle').attr('selected-per-page'),
                    page:1
                }
                Newmasterlist1.listGroups(data,'fromsearch');
            }else{
                if($(this).val().length>=3){
                    var data={
                        per_page:'all',
                        page:1,
                        searchkey:$('#searchInput').val()
                    }
                    Newmasterlist1.listGroups(data,'fromsearch');
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
              Newmasterlist1.onSaveSequence(data);
        });

        $('.tbody-group-list').on('click','.img-upload',function(){
            $(this).closest('tr').find('.imgupload').trigger('click');
        });
        $('.tbody-group-list').on('change','.imgupload',this.onImageUpload);

    },
    onImageUpload:function(event){
         /* var bind_input=$(this); */
        // if($(this).val()==""){
        //       /*  displaywarning('please select file to upload.');*/
        //         return false;
        //     }
        // var group_id=$(this).attr('group-id');
        // var ext = $(this).val().split('.').pop().toLowerCase();
        //     if($.inArray(ext, ['jpg','jpeg','png']) == -1) {
        //         Newmasterlist1.displaywarning('invalid extension!');
        //         return false;
        //     }

        //     var self=this;
        //     var $form_data = new FormData();
        //     var inputFile = $(this);   
        //     if(inputFile){   
        //         var fileToUpload = inputFile[0].files[0];
        //         if (fileToUpload != 'undefined') {
        //             $form_data.append('image', fileToUpload);
        //         }
        //     }
        //     const target = event.target
        //     /* if (target.files && target.files[0]) {
        //         //allow less than 1mb
        //         const maxAllowedSize = 1 * 1024 * 1024;
        //         if (target.files[0].size > maxAllowedSize) {
        //         // Here you can ask your users to load correct file
        //             $('#image-loader').hide();
        //             Newmasterlist1.displaywarning("File size is too big. please select the file less than 1MB.");
        //             return false;
        //         }
        //     } */
           
        //     var defaults = {  
        //         maxWidth: Number.MAX_VALUE,  
        //         maxHeigt: Number.MAX_VALUE,  
        //         onImageResized: null  
        //     }  
        //     var options={
        //         maxWidth: 960,
        //         maxHeigt:500
        //     }
        //     var settings = $.extend({}, defaults, options); 
            
        //     if (window.File && window.FileList && window.FileReader) { 
        //         var files = event.target.files;  
        //         var file = files[0];  
        //         /*if (!file.type.match('image')) continue;  */
        //         var picReader = new FileReader();  
        //         picReader.addEventListener("load", function (event) {

        //             var picFile = event.target;  
        //             var imageData = picFile.result;  
        //             var img = new Image();  
        //             img.src = imageData;  
        //             img.onload = function () {  
        //                 swal({
        //                     title: 'File requirement :',
        //                     text: "JPG, PNG up to 1MB. Minimum pixels required: 960 for width, 500 for height.",
        //                     type: 'warning',
        //                     showCancelButton: true,
        //                     confirmButtonColor: '#3085d6',
        //                     cancelButtonColor: '#d33',
        //                     confirmButtonText: 'Yes, upload it!',
        //                     cancelButtonText: 'No, cancel!',
        //                     confirmButtonClass: 'btn btn-success',
        //                     cancelButtonClass: 'btn btn-danger',
        //                     buttonsStyling: false
        //                 },function () { 
        //                     /* if(swalinput){ */
        //                         $('#image-loader').show();
        //                         var canvas = $("<canvas/>").get(0);  
        //                         canvas.width = 960;  
        //                         canvas.height = 500;  
        //                         var context = canvas.getContext('2d');  
        //                         context.fillStyle = "transparent";
        //                         context.drawImage(img, 0, 0, 960, 500); 
        //                         imageData = canvas.toDataURL('image/jpeg',0.8); 
                               
        //                         $form_data.append('image', imageData);
        //                        /* self.closest('td').find('.img-upload').attr('data-image-src',imageData);
        //                         self.closest('td').find('.img-upload').css("background", "url(" + imageData + ")");*/
        //                         $form_data.append('id',group_id);
        //                         $.ajax({
        //                             url: Newmasterlist1.base_url+"Newmaster1/update_recipe_image",
        //                             type:'POST',
        //                             data: $form_data,
        //                             processData:false,
        //                             contentType:false,
        //                             cache:false,
        //                             success: function(result){
        //                                 $('#image-loader').hide();
        //                                 if (result.status) { 
        //                                    /* self.closest('td').find('.img-upload').attr('data-image-src',Newmasterlist1.base_url+result.path);
        //                                     self.closest('td').find('.img-upload').css("background", "url(" + Newmasterlist1.base_url+result.path + ")");*/
        //                                 } 
        //                                 else{
        //                                     if(result.msg){
        //                                         Newmasterlist1.displaywarning(result.msg);
        //                                     }
        //                                     else
        //                                         Newmasterlist1.displaywarning("Something went wrong please try again");
        //                                 }
        //                                 $('#image-loader').hide();
        //                                 var data={
        //                                     per_page:$('.btn-per-page').attr('selected-per-page'),
        //                                     page:1
        //                                 }
        //                                 Newmasterlist1.listGroups(data);
        //                             }
        //                         });
        //                     /* }
        //                     else{
        //                         bind_input.val('');
        //                     } */
        //                 }, function (dismiss) {
        //                     if (dismiss === 'cancel') {
        //                        /* swal(
        //                           'Cancelled',
        //                           'Your record is safe :)',
        //                           'error'
        //                         )*/
        //                     }
        //                 });
        //             }  
        //             img.onerror = function () {  
        //                  $("#cropbox").attr('src','');
        //                 $('#image-loader').hide();
                       
        //             }  
        //         });  
        //         //Read the image  
        //         picReader.readAsDataURL(file);  
        //     } else {  
        //         Recipelist.displaywarning("Your browser does not support File API");  
        //         $("#cropbox").attr('src','');
        //         $('#image-loader').hide();
        //     }  

        var bind_input=$(this);
        if($(this).val()==""){
              /*  displaywarning('please select file to upload.');*/
                return false;
            }
        var group_id=$(this).attr('group-id');
        var ext = $(this).val().split('.').pop().toLowerCase();
            if($.inArray(ext, ['jpg','jpeg','png']) == -1) {
                Newmasterlist1.displaywarning('invalid extension!');
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
                //allow less than 1mb
                const maxAllowedSize = 1 * 1024 * 1024;
                if (target.files[0].size > maxAllowedSize) {
                // Here you can ask your users to load correct file
                    $('#image-loader').hide();
                    Newmasterlist1.displaywarning("File size is too big. please select the file less than 1MB.");
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
                        },function (swalstatus) { 
                            if(swalstatus){
                                $('#image-loader').show();
                                var canvas = $("<canvas/>").get(0);  
                                canvas.width = 200;  
                                canvas.height = 121;  
                                var context = canvas.getContext('2d');  
                                context.fillStyle = "transparent";
                                context.drawImage(img, 0, 0, 200, 121); 
                                imageData = canvas.toDataURL('image/jpeg',0.8); 
                               
                                $form_data.append('image', imageData);
                               /* self.closest('td').find('.img-upload').attr('data-image-src',imageData);
                                self.closest('td').find('.img-upload').css("background", "url(" + imageData + ")");*/
                                $form_data.append('id',group_id);
                                $.ajax({
                                    url: Newmasterlist1.base_url+"Newmaster1/update_recipe_image",
                                    type:'POST',
                                    data: $form_data,
                                    processData:false,
                                    contentType:false,
                                    cache:false,
                                    success: function(result){
                                        $('#image-loader').hide();
                                        if (result.status) { 
                                           /* self.closest('td').find('.img-upload').attr('data-image-src',Newmasterlist1.base_url+result.path);
                                            self.closest('td').find('.img-upload').css("background", "url(" + Newmasterlist1.base_url+result.path + ")");*/
                                        } 
                                        else{
                                            if(result.msg){
                                                Newmasterlist1.displaywarning(result.msg);
                                            }
                                            else
                                                Newmasterlist1.displaywarning("Something went wrong please try again");
                                        }
                                        $('#image-loader').hide();
                                        var data={
                                            per_page:$('.btn-per-page').attr('selected-per-page'),
                                            page:1
                                        }
                                        Newmasterlist1.listGroups(data);
                                    }
                                });
                            }
                            else{

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
                Newmasterlist1.displaywarning("Your browser does not support File API");  
                $("#cropbox").attr('src','');
                $('#image-loader').hide();
            } 
    },
    onSaveSequence:function(dataarr){
        console.log(dataarr);
        $.ajax({
            url: Newmasterlist1.base_url+"school/change_group_sequence",
            type:'POST',
            data: { data:JSON.stringify(dataarr) },
            success: function(result){
                if (result.status) { 
                    var data={
                        per_page:$('.btn-per-page').attr('selected-per-page'),
                        page:1
                    }
                    Newmasterlist1.listGroups(data);
                }else{
                    Newmasterlist1.displaywarning(result.msg);
                }
            }
        });

    },
    onSaveGroupname:function(){
        if($('#AddMenuGroup').val()!=""){
            /* if($('.select-main-menu').val()==""){
                Newmasterlist1.displaywarning("please select main menu");
                return false;
            } */
            $.ajax({
                url: Newmasterlist1.base_url+"Newmaster1/save_menu_group",
                type:'POST',
                dataType: 'json',
                data: {
                    group_name : $('#AddMenuGroup').val(),
                    available_in : $('#AddMenuGroupTime').val(),
                    available_in1 : $('#AddMenuGroupDName').val(),
                    group_id:$('#menu_group_id').val(),
                    is_edit_group:$('#is_edit_group').val()
                    /* main_menu_id:$('.select-main-menu').val() */
                },
                success: function(result){
                    if (result.status) { 
                        if(result.is_group_exist){
                            Newmasterlist1.displaywarning("Menu already exist.");
                        }else{
                            if($('#is_edit_group').val()=="edit")
                                Newmasterlist1.displaysucess("Menu updated successfully");
                            else
                                Newmasterlist1.displaysucess("Menu created successfully");
                            var data={
                                per_page:$('.btn-per-page').attr('selected-per-page'),
                                page:1
                            }
                            Newmasterlist1.listGroups(data);
                        }
                        $('#AddMenuGroup').val('');
                        $('#AddMenuGroupTime').val('');
                        $('#AddMenuGroupDName').val('');
                        $('#menu_group_id').val('');
                        $('#is_edit_group').val('');
                        /* $('.select-main-menu').val('1'); */
                        $('.btn-add-group').html('ADD');
                        
                    }else{
                        Newmasterlist1.displaywarning(result.msg);
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
        $('#image-loader').show();
        $.ajax({
            url: Newmasterlist1.base_url+"school/delete_group",
            type:'POST',
            data:formData ,
            success: function(result){
                $('#image-loader').hide();
                if (result.status) {
                    var data={
                        per_page:$('.btn-per-page').attr('selected-per-page'),
                        page:1
                    }
                   Newmasterlist1.listGroups(data);
                }
                else{
                    Newmasterlist1.displaywarning("Something went wrong please try again");
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
        /* var recipe_count=$(this).attr('recipe-count');
        if(recipe_count>0){
        console.log(recipe_count); 
            var title='Delete Menu';
            var text=" There are some recipes in this menu group. Are you sure ? you want to delete menu group and recipe";
        }else{ */
            var title='Are you sure ?';
            var text="Delete Menu";
        /* } */
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
            $('#image-loader').show();
            $.ajax({
                url: Newmasterlist1.base_url+"Newmaster1/delete_menu_group",
                type:'POST',
                data:formData ,
                success: function(result){
                    $('#image-loader').hide();
                    if (result.status) {
                        var data={
                            per_page:$('.btn-per-page').attr('selected-per-page'),
                            page:1
                        }
                       Newmasterlist1.listGroups(data);
                       
                    }
                    else{
                        Newmasterlist1.displaywarning("Something went wrong please try again");
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
            url: Newmasterlist1.base_url+"school/list_main_menu_group/",
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
    listGroups:function(data,fromevent)
	{
        $('#image-loader').show();
        $.ajax({
            url: Newmasterlist1.base_url+"Newmaster1/list_menu_group/",
            type:'POST',
            dataType: 'json',
            data: data,
            success: function(response){
                $('#image-loader').hide();
                var groups=response.recipes;
                var html="";
                for (i in groups) {
                    html+='<tr><td>'+groups[i].img_id+'</td>';
                            if((groups[i].recipe_image=="assets/images/users/menu.png") || (groups[i].recipe_image=="")){
                                html+='<td>\
                                    <input type="file" group-id="'+groups[i].id+'" class="imgupload" accept="image/jpeg, image/png" style="display:none"/>\
                                    <img class="img-upload"  src="'+Newmasterlist1.base_url+'assets/images/upload.png" style="height:50px;width:50px;">\
                                    </td>';
                            } 
                            else{
                                html+='<td>\
                                     <input type="file" group-id="'+groups[i].id+'" class="imgupload" accept="image/jpeg, image/png" style="display:none"/>\
                                    <img class="img-upload" src="'+groups[i].recipe_image+'" style="height:50px;width:50px;"></td>';
                            }
                            html+='<td><p style="max-width:190px!important;word-wrap:break-word!important;overflow-x: scroll!important;overflow-y: hidden;overflow-wrap: break-word; white-space: nowrap;">'+groups[i].name+'</a></td>';
                            html+='<td><p style="max-width:250px!important;word-wrap:break-word!important;overflow-x: scroll!important;overflow-y: hidden;overflow-wrap: break-word; white-space: nowrap;">'+groups[i].declaration_name+'</a></td>';
                            html+='<td><p style="max-width:250px!important;word-wrap:break-word!important;overflow-x: scroll!important;overflow-y: hidden;overflow-wrap: break-word; white-space: nowrap;">'+groups[i].long_desc+'</a></td>';
                            html+='<span class="custom-switch-indicator"></span></label>\
                            <td>\
                             <a class="a-edit-group" main-menu-id="'+groups[i].long_desc+'" group-name="'+groups[i].name+'" available-in="'+groups[i].declaration_name+'" data-id="'+groups[i].id+'" style="color:#089e60;margin-right:10px;cursor: pointer;"><i class="fa fa-edit"></i></a>\
                            <a class="a-delete-group" data-id="'+groups[i].id+'" style="color:#f19999;cursor: pointer;"><i class="fa fa-trash"></i></a>\
                            </td>\
                        </tr>';
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

               /* if(fromevent=="fromsearch"){
                    var input, filter, table, tr, td, i, txtValue;
                    input = document.getElementById("searchInput");
                    filter = input.value.toUpperCase();
                    table = document.getElementById("table-recipes");
                    tr = table.getElementsByTagName("tr");
                    for (i = 0; i < tr.length; i++) {
                        td = tr[i].getElementsByTagName("td")[1];
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