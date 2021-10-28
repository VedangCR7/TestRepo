var Menugrouplist ={
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
            $('#AddMenuGroupTime').val(available_in);
            $('#menu_group_id').val(group_id);
            if(main_menu_id!="")
                $('.select-main-menu').val(main_menu_id);
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
            Menugrouplist.listGroups(data);
        });
        $('.btn-prev').on('click',function(){
            var data={
                per_page:$('.dropdown-toggle').attr('selected-per-page'),
                page:$(this).attr('page-no')
            }
            Menugrouplist.listGroups(data);
        });
        $('.btn-next').on('click',function(){
            var data={
                per_page:$('.dropdown-toggle').attr('selected-per-page'),
                page:$(this).attr('page-no')
            }
            Menugrouplist.listGroups(data);
        });
        $('#searchInput').on('keyup',function(){
           
             if($(this).val()==""){
                var data={
                    per_page:$('.dropdown-toggle').attr('selected-per-page'),
                    page:1
                }
                Menugrouplist.listGroups(data,'fromsearch');
            }else{
                if($(this).val().length>=3){
                    var data={
                        per_page:'all',
                        page:1,
                        searchkey:$('#searchInput').val()
                    }
                    Menugrouplist.listGroups(data,'fromsearch');
                }
            }
        });
				
		$('.addcsv').on('click',function(){
			$(this).closest('div').find('.uploadfile').trigger('click');
		});
				
        $('.uploadfile').on('change',this.uploadexlfile);
		
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
              Menugrouplist.onSaveSequence(data);
        });

        $('.tbody-group-list').on('click','.img-upload',function(){
            $(this).closest('tr').find('.imgupload').trigger('click');
        });
        $('.tbody-group-list').on('change','.imgupload',this.onImageUpload);

    },
    onImageUpload:function(event){
         var bind_input=$(this);
        if($(this).val()==""){
              /*  displaywarning('please select file to upload.');*/
                return false;
            }
        var group_id=$(this).attr('group-id');
        var ext = $(this).val().split('.').pop().toLowerCase();
            if($.inArray(ext, ['jpg','jpeg','png']) == -1) {
                Menugrouplist.displaywarning('invalid extension!');
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
                    Menugrouplist.displaywarning("File size is too big. please select the file less than 1MB.");
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
                        },function (swalinput) { 
                            if(swalinput){
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
                                    url: Menugrouplist.base_url+"restaurant/update_menugroup_image",
                                    type:'POST',
                                    data: $form_data,
                                    processData:false,
                                    contentType:false,
                                    cache:false,
                                    success: function(result){
                                        $('#image-loader').hide();
                                        if (result.status) { 
                                           /* self.closest('td').find('.img-upload').attr('data-image-src',Menugrouplist.base_url+result.path);
                                            self.closest('td').find('.img-upload').css("background", "url(" + Menugrouplist.base_url+result.path + ")");*/
                                        } 
                                        else{
                                            if(result.msg){
                                                Menugrouplist.displaywarning(result.msg);
                                            }
                                            else
                                                Menugrouplist.displaywarning("Something went wrong please try again");
                                        }
                                        $('#image-loader').hide();
                                        var data={
                                            per_page:$('.btn-per-page').attr('selected-per-page'),
                                            page:1
                                        }
                                        Menugrouplist.listGroups(data);
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
                Recipelist.displaywarning("Your browser does not support File API");  
                $("#cropbox").attr('src','');
                $('#image-loader').hide();
            }  
    },
    onSaveSequence:function(dataarr){
        console.log(dataarr);
        $.ajax({
            url: Menugrouplist.base_url+"school/change_group_sequence",
            type:'POST',
            data: { data:JSON.stringify(dataarr) },
            success: function(result){
                if (result.status) { 
                    var data={
                        per_page:$('.btn-per-page').attr('selected-per-page'),
                        page:1
                    }
                    Menugrouplist.listGroups(data);
                }else{
                    Menugrouplist.displaywarning(result.msg);
                }
            }
        });

    },
    onSaveGroupname:function()
	{
		debugger;
        if($('#AddMenuGroup').val()!="")
		{
            if($('.select-main-menu').val()=="" || $('.select-main-menu').val()==undefined || $('.select-main-menu').val()==null)
			{
                Menugrouplist.displaywarning("please select main menu");
                return false;
            }
			
            $.ajax({
                url: Menugrouplist.base_url+"school/save_menu_group",
                type:'POST',
                dataType: 'json',
                data: {
                    group_name : $('#AddMenuGroup').val(),
                    available_in : $('#AddMenuGroupTime').val(),
                    group_id:$('#menu_group_id').val(),
                    is_edit_group:$('#is_edit_group').val(),
                    main_menu_id:$('.select-main-menu').val()
                },
                success: function(result)
				{
                    if (result.status) 
					{ 
                        if(result.is_group_exist)
						{
                            Menugrouplist.displaywarning("Menu group already exist.");
                        }
						else
						{
                            if($('#is_edit_group').val()=="edit")
                                Menugrouplist.displaysucess("Menu group updated successfully");
                            else
                                Menugrouplist.displaysucess("Menu group created successfully");
                            var data={
                                per_page:$('.btn-per-page').attr('selected-per-page'),
                                page:1
                            }
                            Menugrouplist.listGroups(data);
                        }
						
                        $('#AddMenuGroup').val('');
                        $('#AddMenuGroupTime').val('');
                        $('#menu_group_id').val('');
                        $('#is_edit_group').val('');
                        $('.select-main-menu').val('1');
                        $('.btn-add-group').html('ADD');                        
                    }
					else
					{
                        Menugrouplist.displaywarning(result.msg);
                    }
                }
            });
        }
		else
		{
            Menugrouplist.displaywarning("Please enter menu group name");
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
            url: Menugrouplist.base_url+"school/delete_group",
            type:'POST',
            data:formData ,
            success: function(result){
                $('#image-loader').hide();
                if (result.status) {
                    var data={
                        per_page:$('.btn-per-page').attr('selected-per-page'),
                        page:1
                    }
                   Menugrouplist.listGroups(data);
                }
                else{
                    Menugrouplist.displaywarning("Something went wrong please try again");
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
            $('#image-loader').show();
            $.ajax({
                url: Menugrouplist.base_url+"school/delete_menu_group",
                type:'POST',
                data:formData ,
                success: function(result){
                    $('#image-loader').hide();
                    if (result.status) {
                        var data={
                            per_page:$('.btn-per-page').attr('selected-per-page'),
                            page:1
                        }
                       Menugrouplist.listGroups(data);
                       
                    }
                    else{
                        Menugrouplist.displaywarning("Something went wrong please try again");
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
            url: Menugrouplist.base_url+"school/list_main_menu_group/",
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
        $('#image-loader').show();
        $.ajax({
            url: Menugrouplist.base_url+"school/list_menu_group/",
            type:'POST',
            dataType: 'json',
            data: data,
            success: function(response){
                $('#image-loader').hide();
                var groups=response.groups;
                var html="";
                for (i in groups) {
                    var available_in=groups[i].available_in;
                    if(available_in==null)
                        available_in='';
                    html+='<tr menu-id="'+groups[i].id+'" curr-seq="'+groups[i].sequence+'">\
                            <td>\
                                <a href="#" curr-seq="'+groups[i].sequence+'" class="btn btn-link btn-seq-up up" style="padding: 2px 2px;"><i class="fas fa-arrow-up"></i></a>\
                                <a href="#" curr-seq="'+groups[i].sequence+'" class="btn btn-link btn-seq-down down" style="padding: 2px 2px;"><i class="fas fa-arrow-down"></i></a>\
                            </td>';
                            if(groups[i].image_path==""){
                                html+='<td>\
                                    <input type="file" group-id="'+groups[i].id+'" class="imgupload" accept="image/jpeg, image/png" style="display:none"/>\
                                    <img class="img-upload"  src="'+Menugrouplist.base_url+'assets/images/upload_new.png" style="height:50px;width:50px;">\
                                    </td>';
                            } 
                            else{
                                html+='<td>\
                                     <input type="file" group-id="'+groups[i].id+'" class="imgupload" accept="image/jpeg, image/png" style="display:none"/>\
                                    <img class="img-upload" src="'+groups[i].image_path+'" style="height:50px;width:50px;"></td>';
                            }
							html+='<td>'+groups[i].id+'</td>';
							
                            html+='<td>';
                           /* if(groups[i].main_menu_id==2)
                                html+='<a href="'+Menugrouplist.base_url+'recipes/barmenus?group_id='+groups[i].id+'&main_menu_id='+groups[i].main_menu_id+'" group-name="'+groups[i].name+'" data-id="'+groups[i].id+'" style="color:#000;">'+groups[i].name+'</a>';
                            else*/
							html+='<a href="'+Menugrouplist.base_url+'recipes/overview?group_id='+groups[i].id+'&main_menu_id='+groups[i].main_menu_id+'" group-name="'+groups[i].name+'" data-id="'+groups[i].id+'" style="color:#000;">'+groups[i].name+'</a>';

                            html+='</td>';
                            html+='<td>'+available_in+'</td>';
                            html+='<td>'+groups[i].main_group+'</td>\
                            <td>'+groups[i].menu_date+'</td>\
                            <td class="text-center">\
                                <label class="custom-switch pl-0">';
                                if(groups[i].is_active==1)
                                    html+='<input type="checkbox" name="custom-switch-checkbox" data-id="'+groups[i].id+'" class="custom-switch-input input-switch-box" checked>';
                                else{
                                    html+='<input type="checkbox" name="custom-switch-checkbox" data-id="'+groups[i].id+'" class="custom-switch-input input-switch-box">';
                                }
                            html+='<span class="custom-switch-indicator"></span></label>\
                            </td>\
                            <td>\
                             <a class="a-edit-group" main-menu-id="'+groups[i].main_menu_id+'" group-name="'+groups[i].name+'" available-in="'+available_in+'" data-id="'+groups[i].id+'" style="color:#089e60;margin-right:10px;cursor: pointer;"><i class="fa fa-edit"></i></a>\
                            <a class="a-delete-group" data-id="'+groups[i].id+'" recipe-count="'+groups[i].recipe_count+'" style="color:#f19999;cursor: pointer;"><i class="fa fa-trash"></i></a>\
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
	
	uploadexlfile:function()
	{
        debugger;
        var $form_data = new FormData();
        $form_data.append('uploadFile',$('.uploadfile')[0].files[0]);
        //console.log($form_data);
        $.ajax({
            url: Menugrouplist.base_url+"restaurant/uploadMenuGroupData",
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
                    Menugrouplist.displaysucess("upload successfully");
                } 
                else
				{
                    Menugrouplist.displaywarning(result.msg);
                }
				
                $('#image-loader').hide();
                
				var data={
                    per_page:$('.btn-per-page').attr('selected-per-page'),
                    page:1
                }
                Menugrouplist.listGroups(data);
            }
        });
    },
};