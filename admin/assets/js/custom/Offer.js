var Offer ={
    base_url:null,
    uncheck_ids:new Array(),
    init:function() {
        this.bind_events();
        var data={
            per_page : $('.btn-per-page').attr('selected-per-page'),
            page:1
        }
        this.listoffers(data);
        this.showcust();
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
            Offer.listoffers(data);
        });
        $('.btn-prev').on('click',function(){
            var data={
                per_page:$('.dropdown-toggle').attr('selected-per-page'),
                page:$(this).attr('page-no')
            }
            Offer.listoffers(data);
        });
        $('.btn-next').on('click',function(){
            var data={
                per_page:$('.dropdown-toggle').attr('selected-per-page'),
                page:$(this).attr('page-no')
            }
            Offer.listoffers(data);
        });
        $('#searchInput').on('keyup',function(){
           
             if($(this).val()==""){
                var data={
                    per_page:$('.dropdown-toggle').attr('selected-per-page'),
                    page:1
                }
                Offer.listoffers(data,'fromsearch');
            }else{
                if($(this).val().length>=3){
                    var data={
                        per_page:'all',
                        page:1,
                        searchkey:$('#searchInput').val()
                    }
                    Offer.listoffers(data,'fromsearch');
                }
            }
        });

        $('.addnewwaitinglist').on('click','.img-upload1',function(){
            $(this).closest('div').find('.imgupload').trigger('click');
        });
        $('.addnewwaitinglist').on('change','.imgupload',this.onImageload);
        $('.btn-add-offer').on('click',this.onSaveoffer);

        $('.tbody-group-list').on('click','.input-switch-box',this.changeStatusOffer);
        $('.tbody-group-list').on('click','.a-delete-group',this.onDeleteOffer);
        $('.tbody-group-list').on('click','.a-edit-group',this.onEditOffer);
        $('.edit_manager').on('click','.editperticular_offer',this.onEditPerticularOffer);

        $('.tbody-group-list').on('click','.img-upload',function(){
            $(this).closest('tr').find('.imgupload').trigger('click');
        });
        $('.tbody-group-list').on('change','.imgupload',this.onImageUpload);

        $('.send_offer').on('click',this.sendOffertoCust);

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

        $('#all_cust').on('change',function(){
            if (this.checked) {
            $(".customer").each(function() {
                this.checked=true;
            });
        } else {
            $(".customer").each(function() {
                this.checked=false;
            });
        }

        });
        $('.cust-table').on('click','.customer',this.onClickInput);

        $('.tbody-group-list').on('click','.a-send-offer',this.onclicksendoffer);
    },

    onclicksendoffer:function(){
        $('#editoffersend').modal('show');
        var offer_id = $(this).attr('data-id');
        Offer.showcust1();
        var html = '';
        $.ajax({
            url: Offer.base_url+"Whatsapp_manager/showoffer_forsend",
            type:'POST',
            data:{id:offer_id},
            success: function(result){
                if (result.offer_photo != null) {
                                    html+='<div class="col-lg-6 col-md-6 col-sm-6 col-6">\
                                    <h5>Offer Image</h5>\
                                    <img class="img-upload rounded-circle"  src="'+result.offer_photo+'" style="height:50px;width:50px;">\
                                    </div>';
                                }
                                if (result.offer_text != '') {
                                    html+='<div class="col-lg-6 col-md-6 col-sm-6 col-6">\
                                    <h5>Offer Text : '+result.offer_text+'</h5></div>';
                                }
                $('#offershowforsend').html(html);
            }
        });
    },

    onClickInput:function(){
        if ($(this).is(":checked")) {
            var isAllChecked = 0;

            $(".customer").each(function() {
                if (!this.checked)
                    isAllChecked = 1;
            });

            if (isAllChecked == 0) {
                $("#all_cust").prop("checked", true);
            }     
        }
        else {
            $("#all_cust").prop("checked", false);
        }
    },

    sendOffertoCust:function(){
        var self=this;
        var ids=new Array();
        $('.customer').each(function(){
            if($(this).is(':checked')){
                var id=$(this).val();
                ids.push(id);
            }
        });
        if(ids.length==0 && Offer.uncheck_ids.length==0){
            Offer.displaywarning("Please select at least one customer.");
            return false;
        }
        if(ids.length==0){
            var not_all_ids="";
        }else{
            var not_all_ids="yes";
        }
        swal({
            title: 'Are you sure ?',
            text: " Send this message to selected customers",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, save it!',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false
        },function () {
            var formData = {
                ids:ids,
                uncheck_ids:Offer.uncheck_ids,
                not_all_ids:not_all_ids
            };
            //alert(ids);
            // $.ajax({
            //     url: Offer.base_url+"Whatsapp_manager/send_offer_to_cust",
            //     type:'POST',
            //     data:formData ,
            //     success: function(result){
            //        if (result.status) {
            //             var data={
            //                 per_page:15,
            //                 page:1

            //             }
            //             Offer.displaysucess("Successfully Send offer.");
            //             window.location.href="";
            //        }
            //        else{
            //             Offer.displaywarning("Something went wrong please try again");
            //        }
            //     }
            // });
             
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



    changeStatusOffer:function(){
        if($(this).is(':checked')){
            $(this).val("on");
            Offer.displaysucess("Message is Active now");}
        else{
            $(this).val("off");
            Offer.displaysucess("Message is Inactive now");
        }

        var self=this;
        var data_id=$(this).attr('data-id');
        var formData={
            id : data_id,
            is_active:$(this).val()
        }
        $.ajax({
            url: Offer.base_url+"Whatsapp_manager/change_offer_status",
            type:'POST',
            data:formData ,
            success: function(result){
               if (result.status) {
                //Offer.displaysucess("Status Changed successfully");
                    var data={
                        per_page:$('.btn-per-page').attr('selected-per-page'),
                        page:1
                    }
                   Offer.listoffers(data);
               }
               else{
                    Offer.displaywarning("Something went wrong please try again");
               }
            }
        });
    },

    onDeleteOffer:function(){
        var self=this;
        var data_id=$(this).attr('data-id');
        var title='Are you sure ?';
        var text="Delete this Message";
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
                url: Offer.base_url+"Whatsapp_manager/delete_perticular_offer",
                type:'POST',
                data:formData ,
                success: function(result){
                   if (result.status) {
                        Offer.displaysucess("Delete successfully");
                        var data={
                            per_page:$('.btn-per-page').attr('selected-per-page'),
                            page:1
                        }
                       Offer.listoffers(data);
                   }
                   else{
                        Offer.displaywarning("Something went wrong please try again");
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

    onEditOffer:function(){
        $("html").animate({ scrollTop: 0 }, "slow");
        var self=this;
        var data_id=$(this).attr('data-id');
        var html = '';
        var formData={
                id : data_id
            } 
            $.ajax({
                url: Offer.base_url+"Whatsapp_manager/show_perticular_offer",
                type:'POST',
                data:formData ,
                success: function(result){
                        var data={
                            per_page:$('.btn-per-page').attr('selected-per-page'),
                            page:1
                        }
                       Offer.listoffers(data);
                       if (result.message_text != null) {
                       var message_text = result.message_text;}
                       else{
                        var message_text = '';
                       }
                       $('.edit_manager').html('<div class="card welcome-image">\
                            <div class="card-body">\
                                <div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-12">\
                                    <input type="hidden" name="id" id="edit_id" value="'+result.id+'">\
                                    <label style="font-weight:bold;">Offer Text</label>\
                                    <textarea name="offer_text" id="edit_offer_text" placeholder="Offer Text" class="form-control">'+message_text+'</textarea>\
                                </div>\
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12 text-center">\
                                    <button type="submit" data-id="'+result.id+'" class="btn btn-secondary btn-save-details editperticular_offer" type="button" style="background-color: #ED3573;border: 0px !important;float:right;margin-top:10px;margin-top: 1rem;">Save Changes</button>\
                                </div>\
                            </div></div>');
                       $('.edit_manager').show();
                }
            });
    },

    onEditPerticularOffer:function(){
        var self=this;
        var data_id=$(this).attr('data-id');
                var formData={
                id : data_id,
                message_text : $('#edit_offer_text').val()
            } 
            $.ajax({
                url: Offer.base_url+"Whatsapp_manager/edit_perticular_Offer",
                type:'POST',
                data:formData ,
                success: function(result){
                   if (result.status) {
                        var data={
                            per_page:$('.btn-per-page').attr('selected-per-page'),
                            page:1
                        }
                        $('.edit_manager').hide();
                        Offer.displaysucess("Information Save successfully");
                        $(".addnewwaitinglist").show();
                       Offer.listoffers(data);
                   }
                   else{
                        Offer.displaywarning("Something went wrong please try again");
                   }
                }
            });
    },

    onSaveoffer:function(){
            if ($('#offer_photo').val() =='' && $('#offer_text').val() == '') {
                Offer.displaywarning("Atleast One field is required");
                return false;
            }
            $('#image-loader').show();
            $.ajax({
                    url: Offer.base_url+"Whatsapp_manager/add_message",
                    type:'POST',
                    dataType: 'json',
                    data: {
                        message_text : $('#offer_text').val(),
                        image: $('#offer_photo').val()
                    },
                    success: function(result){
                        if (result.status) {
                            $('#image-loader').hide();
                                $('.addnewwaitinglist').hide();
                                var html = '';
                                if (result.photo != undefined) {
                                    html+='<div class="col-lg-6 col-md-6 col-sm-6 col-6">\
                                    <h5> Image</h5>\
                                    <img class="img-upload rounded-circle"  src="'+result.photo+'" style="height:50px;width:50px;">\
                                    </div>';
                                }
                                if (result.offer_text != '') {
                                    html+='<div class="col-lg-6 col-md-6 col-sm-6 col-6">\
                                    <h5>Message Text : '+result.offer_text+'</h5></div>';
                                }
                                $('.showaddedoffer').html(html);
                                $('.showaddedoffer').show();
                                Offer.displaysucess("Message created successfully");
                                var data={
                                    per_page:$('.btn-per-page').attr('selected-per-page'),
                                    page:1
                                }
                                Offer.listoffers(data);
                            $('#offer_photo').val('');
                            $('.btn-add-offer').html('Save');
                            $('#show_all_customer').show();
                            Offer.showcust();
                        
                        }else{
                            Offer.displaywarning(result.msg);
                        }
                    }
                });

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
                Waitingmanager.displaywarning('invalid extension!');
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
                    Waitingmanager.displaywarning("File size is too big. please select the file less than 1MB.");
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
                                console.log(imageData);
                                $('#my_image').attr('src',imageData);
                                $('#is_image_upload').html('<input type="hidden" name="offer_photo" value="'+imageData+'" id="offer_photo">');
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
                Waitingmanager.displaywarning("Your browser does not support File API");  
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
                Offer.displaywarning('invalid extension!');
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
                    Offer.displaywarning("File size is too big. please select the file less than 1MB.");
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
                                    url: Offer.base_url+"Whatsapp_manager/update_offer_photo",
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
                                                Offer.displaywarning(result.msg);
                                            }
                                            else
                                                Offer.displaywarning("Something went wrong please try again");
                                        }
                                        $('#image-loader').hide();
                                        var data={
                                            per_page:$('.btn-per-page').attr('selected-per-page'),
                                            page:1
                                        }
                                        Offer.listoffers(data);
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
                Offer.displaywarning("Your browser does not support File API");  
                $("#cropbox").attr('src','');
                $('#image-loader').hide();
            } 
    },


    showcust:function(){
        $.ajax({
            url: Offer.base_url+"Whatsapp_manager/show_cust/",
            type:'POST',
            dataType: 'json',
            success: function(result){
                $('#cust-table').dataTable().fnClearTable();
                $('#cust-table').dataTable().fnDestroy();
                var j = 1;
                var html ='';
                for(var i=0;i<result.length;i++){
                    html = '<tr>\
                    <td><input type="checkbox" name="customers[]" class="customer" value="'+result[i].id+'"></td>';
                    if (result[i].name != null && result[i].name != '') {
                    html +='<td style="text-align:justify;">'+result[i].name+'</td>';}
                    else{
                        html +='<td></td>';
                    }
                    html +='<td style="text-align:justify;">'+result[i].contact_no+'</td>';
                    if (result[i].email != null && result[i].email != '') {
                    html +='<td style="text-align:justify;">'+result[i].email+'</td></tr>';}
                    else{
                        html +='<td></td>';
                    }
                    $('#tbody-customer').append(html);
                    var j=j+1;
                }
                //$('#show_all_customer').show();
                $('#cust-table').DataTable();
            }
        });
    },

    showcust1:function(){
        $.ajax({
            url: Offer.base_url+"Whatsapp_manager/show_cust/",
            type:'POST',
            dataType: 'json',
            success: function(result){
                $('#cust-table1').dataTable().fnClearTable();
                $('#cust-table1').dataTable().fnDestroy();
                var j = 1;
                var html ='';
                for(var i=0;i<result.length;i++){
                    html = '<tr>\
                    <td><input type="checkbox" name="customers[]" class="customer" value="'+result[i].id+'"></td>';
                    if (result[i].name != null && result[i].name != '') {
                    html +='<td style="text-align:justify;">'+result[i].name+'</td>';}
                    else{
                        html +='<td></td>';
                    }
                    html +='<td style="text-align:justify;">'+result[i].contact_no+'</td>';
                    if (result[i].email != null && result[i].email != '') {
                    html +='<td style="text-align:justify;">'+result[i].email+'</td></tr>';}
                    else{
                        html +='<td></td>';
                    }
                    $('#tbody-customer1').append(html);
                    var j=j+1;
                }
                //$('#show_all_customer').show();
                $('#cust-table1').DataTable();
            }
        });
    },

    listoffers:function(data,fromevent){
        $.ajax({
            url: Offer.base_url+"Whatsapp_manager/list_message/",
            type:'POST',
            dataType: 'json',
            data: data,
            success: function(response){
                var managers=response.manager;
                var html="";
                var j=1;
                for (i in managers) {

                    html+='<tr menu-id="'+managers[i].id+'">\
                            <td>'+ j +'</td>';
                            if(managers[i].message_photo==null || managers[i].message_photo == ''){
                                html+='<td title="Browse">\
                                    <input type="file" group-id="'+managers[i].id+'" class="imgupload" accept="image/jpeg, image/png" style="display:none"/>\
                                    <img class="img-upload rounded-circle"  src="'+Offer.base_url+'assets/images/users/offer2.png" style="height:50px;width:50px;">\
                                    </td>';
                            }
                            else{
                                 html+='<td title="Browse">\
                                     <input type="file" group-id="'+managers[i].id+'" class="imgupload" accept="image/jpeg, image/png" style="display:none"/>';
                                    if(managers[i].message_photo=="assets/images/users/offer2.png")
                                        html+='<img class="img-upload rounded-circle" src="'+Offer.base_url+managers[i].message_photo+'" style="height:50px;width:50px;"></td>';
                                    else
                                        html+='<img class="img-upload rounded-circle" src="'+managers[i].message_photo+'" style="height:50px;width:50px;"></td>';
                            }
                            html+='<td>';
                                if (managers[i].message_text != null) {
                                    html +=managers[i].message_text;
                                }
                            html +='</td>\
                            <td class="text-center">\
                                <label class="custom-switch pl-0">';
                                if(managers[i].is_active==1)
                                    html+='<input type="checkbox" name="custom-switch-checkbox" data-id="'+managers[i].id+'" class="custom-switch-input input-switch-box" checked>';
                                else
                                    html+='<input type="checkbox" name="custom-switch-checkbox" data-id="'+managers[i].id+'" class="custom-switch-input input-switch-box">';
                                    html+='<span class="custom-switch-indicator"></span>\
                                </label>\
                            </td>\
                            <td>\
                            <a class="a-edit-group" title="Edit Message Text" data-id="'+managers[i].id+'" style="color:green;cursor: pointer;"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\
                             <a class="a-delete-group" title="Delete Message" data-id="'+managers[i].id+'" style="color:#f19999;cursor: pointer;"><i class="fa fa-trash"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';                             
                             if(managers[i].is_active==1){
                             html +='<a class="a-send-offer text-info" title="Send Message" data-id="'+managers[i].id+'" style="cursor: pointer;"><i class="far fa-share-square"></i></a>';
                            }
                            html +='</td>\
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