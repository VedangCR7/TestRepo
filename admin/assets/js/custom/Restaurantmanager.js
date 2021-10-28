var Restaurantmanager ={
    base_url:null,
    init:function() {
        this.bind_events();
        var data={
            per_page : $('.btn-per-page').attr('selected-per-page'),
            page:1
        }
        this.listmanager(data);
    },

    bind_events :function() {
        var self=this;
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
            Restaurantmanager.listmanager(data);
        });
        $('.btn-prev').on('click',function(){
            var data={
                per_page:$('.dropdown-toggle').attr('selected-per-page'),
                page:$(this).attr('page-no')
            }
            Restaurantmanager.listmanager(data);
        });
        $('.btn-next').on('click',function(){
            var data={
                per_page:$('.dropdown-toggle').attr('selected-per-page'),
                page:$(this).attr('page-no')
            }
            Restaurantmanager.listmanager(data);
        });
        $('#searchInput').on('keyup',function(){
           
             if($(this).val()==""){
                var data={
                    per_page:$('.dropdown-toggle').attr('selected-per-page'),
                    page:1
                }
                Restaurantmanager.listmanager(data,'fromsearch');
            }else{
                if($(this).val().length>=3){
                    var data={
                        per_page:'all',
                        page:1,
                        searchkey:$('#searchInput').val()
                    }
                    Restaurantmanager.listmanager(data,'fromsearch');
                }
            }
        });

        $('.tbody-group-list').on('click','.input-switch-box',this.changeStatusManager);
        $('.tbody-group-list').on('click','.a-delete-group',this.onDeleteManager);
        $('.tbody-group-list').on('click','.a-assign-table',this.onassigntable);
        $('#assign_table').on('click',this.assign_table_to_manager)
        $('.btn-add-group').on('click',this.onSaveGroupname);

        $('.tbody-group-list').on('click','.a-edit-group',this.onEditManager);
        $('.edit_manager').on('click','.closeedit',this.oncancelEditManager);
        $('.edit_manager').on('click','.editperticular_manager',this.onEditPerticularManager);

        $('.tbody-group-list').on('click','.img-upload',function(){
            $(this).closest('tr').find('.imgupload').trigger('click');
        });
        $('.tbody-group-list').on('change','.imgupload',this.onImageUpload);

        $('.addnewmanager').on('click','.img-upload1',function(){
            $(this).closest('div').find('.imgupload').trigger('click');
        });

        $('.addnewmanager').on('change','.imgupload',this.onImageload);

        $('.edit_manager').on('click','.toggle-password',this.onshowpassword);

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

    },

    assign_table_to_manager:function(){
        restaurant_manager_id = $('#manager_id').val();
        var array = [];
        $("input:checkbox[name=table_title]:checked").each(function() {
            array.push($(this).val());
        });
        console.log(array);
        $.ajax({
            url: Restaurantmanager.base_url+"Restaurant/assign_table_to_manager",
            type:'POST',
            data:{restaurant_manager_id:restaurant_manager_id,table:array},
            success: function(result){
                if(result.status){
                    $('#assigntablemodal').modal('hide');
                    Restaurantmanager.displaysucess("Assigned table to manager");
                }else{
                    Restaurantmanager.displaywarning(result.msg);
                    return false;
                }
                var data={
                    per_page:$('.btn-per-page').attr('selected-per-page'),
                    page:1
                }
                Restaurantmanager.listmanager(data);
                
            }
        });
    },

    onassigntable:function(){
        var restaurant_manager_id=$(this).attr('data-id');
        $.ajax({
            url: Restaurantmanager.base_url+"Restaurant/show_table_rest_manager",
            type:'POST',
            data:{restaurant_manager_id:restaurant_manager_id},
            success: function(result){
                debugger;
                console.log(result.assign_table);
                //console.log(result.assign_table[i].table_id);
                
                html ='';
                html += '<input type="hidden" id="manager_id" value="'+restaurant_manager_id+'">';
                // if(result.assign_table.length <=0){
                // for(var i = 0;i<result.table.length;i++){
                // html +='<div class="col-lg-3 col-md-3 col-sm-12 col-12">';
                //     html +='<input type="text" class="table_title" name="table_title" value="'+result.table[i].id+'"> &nbsp;'+result.table[i].title; 
                // html +='</div>';
                // }
                // }else{
                if(result.table.length>0){
                    var table_array=[];
                    for(var j = 0;j<result.assign_table.length;j++){
                        table_array.push(result.assign_table[j].table_id);
                    }
                    console.log(table_array);
                    for(var i = 0;i<result.table.length;i++){
                        html +='<div class="col-lg-3 col-md-3 col-sm-12 col-12">';
                            
                            if(table_array.includes(result.table[i].id)){
                                console.log("checked "+result.table[i].id);
                                html +='<input type="checkbox" class="table_title" name="table_title" value="'+result.table[i].id+'" checked> &nbsp;'+result.table[i].title; 
                            }else{
                                html +='<input type="checkbox" class="table_title" name="table_title" value="'+result.table[i].id+'"> &nbsp;'+result.table[i].title;
                            }

                            html +='</div>';
                    }
                }
                else{
                    html +='<div class="col-lg-12 col-md-12 col-sm-12 col-12">';
                                
                        html +='<span class="text-danger">All tables are assigned already</span>';
                        html +='</div>';
                        $('#assign_table').attr('disabled',true);
                }
                // }
                $('#showtables').html(html);
                $('#assigntablemodal').modal('show');
            //    if (result.status) {
            //         var data={
            //             per_page:$('.btn-per-page').attr('selected-per-page'),
            //             page:1
            //         }
            //        Restaurantmanager.listmanager(data);
            //    }
            //    else{
            //         Restaurantmanager.displaywarning("Something went wrong please try again");
            //    }
            }
        });
    },

    onshowpassword:function(){
        //  alert("hi");
        $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        // $('#hide_show_passwod').html('<i class="fas fa-eye" id="hide_password"></i>');
        // $('#password').attr('type', 'text');
    },

    onImageload:function(event){
        var bind_input=$(this);
        if($(this).val()==""){
              /*  displaywarning('please select file to upload.');*/
                return false;
            }
        var group_id=$(this).attr('group-id');
        var ext = $(this).val().split('.').pop().toLowerCase();
            if($.inArray(ext, ['jpg','jpeg','png']) == -1) {
                Restaurantmanager.displaywarning('invalid extension!');
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
                    Restaurantmanager.displaywarning("File size is too big. please select the file less than 1MB.");
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
                                console.log(imageData);
                                $('#my_image').attr('src',imageData);
                                $('#is_image_upload').html('<input type="hidden" name="profile_photo" value="'+imageData+'" id="profile_photo">');
                                $('#image-loader').hide();
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
                Restaurantmanager.displaywarning("Your browser does not support File API");  
                $("#cropbox").attr('src','');
                $('#image-loader').hide();
            }  
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
                Restaurantmanager.displaywarning('invalid extension!');
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
                    Restaurantmanager.displaywarning("File size is too big. please select the file less than 1MB.");
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
                    img.onload = function (swalinput) {  

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
                                    url: Restaurantmanager.base_url+"Restaurant_manager/update_profile_photo",
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
                                                Restaurantmanager.displaywarning(result.msg);
                                            }
                                            else
                                                Restaurantmanager.displaywarning("Something went wrong please try again");
                                        }
                                        $('#image-loader').hide();
                                        var data={
                                            per_page:$('.btn-per-page').attr('selected-per-page'),
                                            page:1
                                        }
                                        Restaurantmanager.listmanager(data);
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
                Restaurantmanager.displaywarning("Your browser does not support File API");  
                $("#cropbox").attr('src','');
                $('#image-loader').hide();
            }  
    },



    changeStatusManager:function(){
        if($(this).is(':checked')){
            $(this).val("on");
            Restaurantmanager.displaysucess("Restaurant manager is Active now");}
        else{
            $(this).val("off");
            Restaurantmanager.displaysucess("Restaurant manager is Inactive now");}

        var self=this;
        var data_id=$(this).attr('data-id');
        var formData={
            id : data_id,
            is_active:$(this).val()
        }
        $.ajax({
            url: Restaurantmanager.base_url+"Restaurant_manager/delete_manager",
            type:'POST',
            data:formData ,
            success: function(result){
               if (result.status) {
                    var data={
                        per_page:$('.btn-per-page').attr('selected-per-page'),
                        page:1
                    }
                   Restaurantmanager.listmanager(data);
               }
               else{
                    Restaurantmanager.displaywarning("Something went wrong please try again");
               }
            }
        });
    },

    oncancelEditManager:function(){
        //alert("hi");
        $('.edit_manager').hide();
    },

    onEditManager:function(){
        $("html").animate({ scrollTop: 0 }, "slow");
        var self=this;
        var data_id=$(this).attr('data-id');
        //alert(data_id);
        var html = '';
        var formData={
                id : data_id
            } 
            $.ajax({
                url: Restaurantmanager.base_url+"Waiting_manager/show_perticular_waitinglist_manager",
                type:'POST',
                data:formData ,
                success: function(result){
                        var data={
                            per_page:$('.btn-per-page').attr('selected-per-page'),
                            page:1
                        }
                       Restaurantmanager.listmanager(data);
                       $('.edit_manager').html('<div class="col-md-12">\
            <div class="card welcome-image">\
                <div class="card-body">\
                    <div class="row">\
                        <div class="col-md-11">\
                            <form class="form-recipe-edit" method="post" action="javascript:;">\
                                <div class="row">\
                                    <div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:10px;">\
                                        <label style="font-weight:bold;">Name</label>\
                                        <input type="hidden" name="id" id="" value="'+result.id+'">\
                                        <input type="text" name="personname" id="personname" value="'+result.name+'" class="form-control" placeholder="Enter Name" style="text-transform: capitalize;">\
                                    </div>\
                                    <div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:10px;">\
                                        <label style="font-weight:bold;">Email</label>\
                                        <input type="email" name="email" id="email" value="'+result.email+'" disabled class="form-control" placeholder="Enter Email">\
                                    </div>\
                                    <div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:10px;">\
                                        <label style="font-weight:bold;">Password </label>\
                                        <input type="password" name="password" id="password" value="'+result.password+'" class="form-control" placeholder="Enter Password">\
                                        <span toggle="#password" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>\
                                    </div>\
                                    <div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:10px;">\
                                        <label style="font-weight:bold;">Contact Number</label>\
                                        <input type="text" name="personcontact_number" onkeypress="return isNumber(event)" id="personcontact_number" value="'+result.contact_number+'" class="form-control" placeholder="Enter Contact Number">\
                                    </div>\
                                </div>\
                                <div class="row">\
                                    <div class="col-md-12 text-right">\
                                        <button type="button" class="btn btn-default closeedit" id="closeedit" style="background-color: #ede3e7;;border: 0px !important;float:right;margin-left:10px;margin-top: 1rem;">Cancel</button>\
                                        <button type="submit" data-id="'+result.id+'" class="btn btn-secondary btn-save-details editperticular_manager" type="button" style="background-color: #ED3573;border: 0px !important;float:right;margin-top:10px;margin-top: 1rem;">Save Changes</button>\
                                    </div>\
                                </div>\
                            </form>\
                        </div>\
                    </div>\
                </div>\
            </div>\
        </div>');
                       $('.edit_manager').show();
                       $(".addnewmanager").hide();
                }
            });
    },

    onEditPerticularManager:function(){
        var regex = /^[A-Za-z0-9 ]+$/
        var isValid = regex.test($('#personname').val());
        if (!isValid) {
            Restaurantmanager.displaywarning("Enter Valid Name");
            return false;
        }
        if ($('#personname').val() != '' && $('#personcontact_number').val() != '' && $('#password').val() != '') { 
        if ($('#personname').val().length < 2 || $('#personname').val().length > 30) { Restaurantmanager.displaywarning("Name field should min 2 to max 30 characters"); }
        else{if ($('#password').val().length < 8 || $('#password').val().length > 30) { Restaurantmanager.displaywarning("Password Should be 8 to 30 Characters"); }
        else{
        if ($('#personcontact_number').val().length < 8 || $('#personcontact_number').val().length > 14) { Restaurantmanager.displaywarning("Contact Number Should be 8 to 14 digit"); $('.edit_manager').show(); }
        else{
        var self=this;
        var data_id=$(this).attr('data-id');
        //alert(data_id);
        var formData={
                id : data_id,
                name : $('#personname').val(),
                contact_number : $('#personcontact_number').val(),
                password : $('#password').val()
            } 
            $.ajax({
                url: Restaurantmanager.base_url+"Waiting_manager/edit_perticular_waitinglist_manager",
                type:'POST',
                data:formData,
                success: function(result){
                   if (result.status) {
                    Restaurantmanager.displaysucess("Information Save successfully");
                        var data={
                            per_page:$('.btn-per-page').attr('selected-per-page'),
                            page:1
                        }
                        $('.edit_manager').hide();
                        Restaurantmanager.displaysucess("Information Save successfully");
                       Restaurantmanager.listmanager(data);
                   }
                   else{
                        Restaurantmanager.displaywarning("Something went wrong please try again");
                   }
                }
            });
        }
    }
}
}
        else{
            Restaurantmanager.displaywarning("Please Fill all the fields");
        }
    
    },

    onDeleteManager:function(){
        var self=this;
        var data_id=$(this).attr('data-id');
        var title='Are you sure ?';
        var text="Delete Waitinglist Manager";
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
                url: Restaurantmanager.base_url+"Restaurant_manager/delete_perticular_restaurant_manager",
                type:'POST',
                data:formData ,
                success: function(result){
                   if (result.status) {
                    Restaurantmanager.displaysucess("Delete successfully");
                        var data={
                            per_page:$('.btn-per-page').attr('selected-per-page'),
                            page:1
                        }
                       Restaurantmanager.listmanager(data);
                   }
                   else{
                        Restaurantmanager.displaywarning("Something went wrong please try again");
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

    onSaveGroupname:function(){
        var regex = /^[A-Za-z0-9 ]+$/
 
        //Validate TextBox value against the Regex.
        var isValid = regex.test($('#name').val());
        if (!isValid) {
            Restaurantmanager.displaywarning("Enter Valid Name");
            return false;
        }
        if($('#name').val()!="" && $('#email').val()!="" && $('#contact_number').val()!=""){
            if (/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test($('#email').val()))
            {
            }else{
                Restaurantmanager.displaywarning("Please Enter Valid Email");
                return false;
            }
            if ($('#name').val().length < 2 || $('#name').val().length > 30) { Restaurantmanager.displaywarning("Name field should min 2 to max 30 characters"); }
            else{
            if ($('#contact_number').val().length < 8 || $('#contact_number').val().length > 14) { Restaurantmanager.displaywarning("Contact Number Should be 8 to 14 digit"); }
            else{ var regexEmail = /\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
            var email = document.getElementById("email");

            if (regexEmail.test(email.value)) {
            if ($('#profile_photo').val() != '') {
                $('#image-loader').show();
                $.ajax({
                    url: Restaurantmanager.base_url+"Restaurant_manager/add_profile_photo",
                    type:'POST',
                    dataType: 'json',
                    data: {
                        name : $('#name').val(),
                        email: $('#email').val(),
                        contact_number: $('#contact_number').val(),
                        image: $('#profile_photo').val()
                    },
                    success: function(result){
                        $('#image-loader').hide();
                        if (result.status) {
                            if(result.is_email_exist){
                                Restaurantmanager.displaywarning("Email already exist.");
                            }else{
                                Restaurantmanager.displaysucess("Restaurant manager created successfully");
                                var data={
                                    per_page:$('.btn-per-page').attr('selected-per-page'),
                                    page:1
                                }
                                Restaurantmanager.listmanager(data);
                            }
                            $('#name').val('');
                            $('#email').val('');
                            $('#contact_number').val('');
                            $('#profile_photo').val('');
							$('#my_image').attr('src',Restaurantmanager.base_url+"assets/images/users/user.png");
                            $('.btn-add-group').html('Save');
                        
                        }else{
                        Restaurantmanager.displaywarning(result.msg);
                        }
                    }
                });
            }

            else{
                $('#image-loader').show();
                $.ajax({
                    url: Restaurantmanager.base_url+"Restaurant_manager/save_restaurant_manager",
                    type:'POST',
                    dataType: 'json',
                    data: {
                        name : $('#name').val(),
                        email:$('#email').val(),
                        contact_number:$('#contact_number').val()
                    },
                    success: function(result){
                        $('#image-loader').hide();
                        if (result.status) {
                            if(result.is_email_exist){
                                Restaurantmanager.displaywarning("Email already exist.");
                            }else{
                                Restaurantmanager.displaysucess("Restaurant manager created successfully");
                                var data={
                                    per_page:$('.btn-per-page').attr('selected-per-page'),
                                    page:1
                                }
                                Restaurantmanager.listmanager(data);
                            }
                            $('#name').val('');
                            $('#email').val('');
                            $('#contact_number').val('');
                            $('.btn-add-group').html('Save');
                        
                        }else{
                        Restaurantmanager.displaywarning(result.msg);
                        }
                    }
                });
            }
            }
        else{
            Restaurantmanager.displaywarning("Invalid Email");
        }
        }
        }
        }
        else{
            Restaurantmanager.displaywarning("Please Fill all the fields");
        }

    },
    
    listmanager:function(data,fromevent){
        $.ajax({
            url: Restaurantmanager.base_url+"Restaurant_manager/list_manager/",
            type:'POST',
            dataType: 'json',
            data: data,
            success: function(response){
                var managers=response.manager;
				console.log(managers);
                var html="";
                var j=1;
                for (i in managers) {
					
                    html+='<tr menu-id="'+managers[i].id+'">\
                            <td>'+ j +'</td>';
                            if(managers[i].profile_photo=="assets/images/users/user.png"){
                                html+='<td title="Browse">\
                                    <input type="file" group-id="'+managers[i].id+'" class="imgupload" accept="image/jpeg, image/png" style="display:none"/>\
                                    <img class="img-upload rounded-circle"  src="'+Restaurantmanager.base_url+'assets/images/users/user.png" style="height:50px;width:50px;">\
                                    </td>';
                            }
                            else{
								//alert(managers[i].profile_photo);
                                  html+='<td title="Browse">\
                                     <input type="file" group-id="'+managers[i].id+'" class="imgupload" accept="image/jpeg, image/png" style="display:none"/>';
                                    
                                        html+='<img class="img-upload rounded-circle" src="'+managers[i].profile_photo+'" style="height:50px;width:50px;"></td>';
                            }
                            html+='<td>'+managers[i].name+'</td>\
                            <td>'+managers[i].contact_number+'</td>\
                            <td>'+managers[i].email+'</td>\
                            <td>'+managers[i].password+'</td>\
                            <td class="text-center">\
                                <label class="custom-switch pl-0">';
                                if(managers[i].is_active==1)
                                    html+='<input type="checkbox" name="custom-switch-checkbox" data-id="'+managers[i].id+'" class="custom-switch-input input-switch-box" checked>';
                                else
                                    html+='<input type="checkbox" name="custom-switch-checkbox" data-id="'+managers[i].id+'" class="custom-switch-input input-switch-box">';
                                    html+='<span class="custom-switch-indicator"></span>\
                                </label>\
                            </td>\
                            <td style="text-align:center">\
                            <a class="a-assign-table text-secondary" data-id="'+managers[i].id+'" style="cursor: pointer;"><i class="fas fa-table"></i></a>\
                            </td>\
                            <td>\
                            <a class="a-edit-group" data-id="'+managers[i].id+'" style="color:green;cursor: pointer;"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\
                             <a class="a-delete-group" data-id="'+managers[i].id+'" style="color:#f19999;cursor: pointer;"><i class="fa fa-trash"></i></a>\
                            </td>\
                        </tr>';
                        j=j+1;
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