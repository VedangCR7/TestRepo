var Customerlist ={
    base_url:null,
    init:function() {
        this.bind_events();
        var data={
            per_page : $('.btn-per-page').attr('selected-per-page'),
            page:1
        }
        this.listCustomers(data);
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
                page:$('.btn-current-pageno').attr('curr-page')
            }
            Customerlist.listCustomers(data);
        });
        $('.btn-prev').on('click',function(){
            var data={
                per_page:$('.dropdown-toggle').attr('selected-per-page'),
                page:$(this).attr('page-no')
            }
            Customerlist.listCustomers(data);
        });
        $('.btn-next').on('click',function(){
            var data={
                per_page:$('.dropdown-toggle').attr('selected-per-page'),
                page:$(this).attr('page-no')
            }
            Customerlist.listCustomers(data);
        });
        $('#searchInput').on('keyup',function(){
           
             if($(this).val()==""){
                var data={
                    per_page:$('.dropdown-toggle').attr('selected-per-page'),
                    page:$('.btn-current-pageno').attr('curr-page')
                }
                Customerlist.listCustomers(data,'fromsearch');
            }else{
                if($(this).val().length>=3){
                    var data={
                        per_page:'all',
                        page:$('.btn-current-pageno').attr('curr-page'),
                        searchkey:$('#searchInput').val()
                    }
                    Customerlist.listCustomers(data,'fromsearch');
                }
            }
        });

        $('.addcsv').on('click',function(){
            $(this).closest('div').find('.uploadfile').trigger('click');
        });

        $('.uploadfile').on('change',this.uploadexlfile);


        $('.tbody-customer-list').on('click','.input-switch-box',this.deleteGroup);
        $('.btn-add-group').on('click',this.onSaveGroupname);
        $('.tbody-customer-list').on('click','.a-edit-customer',this.onEditManager);
        $('.edit_manager').on('click','.editperticular_manager',this.onEditPerticularManager);
        $('.edit_manager').on('click','#closeedit',this.closeeditdiv);

    },

    uploadexlfile:function(){
        //alert("change");
        var $form_data = new FormData();
        $form_data.append('uploadFile',$('.uploadfile')[0].files[0]);
        //console.log($form_data);
        $.ajax({
            url: Customerlist.base_url+"restaurant/uploadData",
            type:'POST',
            data: $form_data,
            processData:false,
            contentType:false,
            cache:false,
            success: function(result){
                console.log(result);
                $('#image-loader').show();
                if (result.status) {
                    Customerlist.displaysucess("upload successfully");
                } 
                else{
                    Customerlist.displaywarning(result.msg);
                }
                $('#image-loader').hide();
                var data={
                    per_page:$('.btn-per-page').attr('selected-per-page'),
                    page:1
                }
                Customerlist.listCustomers(data);
            }
        });
    },

    closeeditdiv:function(){
        $('.edit_manager').hide();
    },

    onEditPerticularManager:function(){
        if ($('#personname').val() != '' && $('#personcontact_number').val() != '') { 
        if ($.trim($('#personname').val()).length < 2 || $.trim($('#personname').val()).length > 30) { 
            Customerlist.displaywarning("Name field should min 2 to max 30 characters"); return false; }
        if ($('#personcontact_number').val().length < 8 || $('#personcontact_number').val().length > 14) { 
            Customerlist.displaywarning("Contact Number Should be 8 to 14 digit"); $('.edit_manager').show(); return false; }
        var self=this;
        var data_id=$(this).attr('data-id');
                var formData={
                id : data_id,
                name : $('#personname').val(),
                contact_number : $('#personcontact_number').val()
            } 
            $.ajax({
                url: Customerlist.base_url+"restaurant/edit_perticular_customer",
                type:'POST',
                data:formData ,
                success: function(result){
                   if (result.status) {
                        var data={
                            per_page:$('.btn-per-page').attr('selected-per-page'),
                            page:$('.btn-current-pageno').attr('curr-page')
                        }
                        $('.edit_manager').hide();
                        Customerlist.displaysucess("Information Save successfully");
                        Customerlist.listCustomers(data);
                   }
                   else{
                        if (result.msg) {
                        Customerlist.displaywarning("Contact Number already exist");}
                        else{
                            Customerlist.displaywarning("Something went wrong");
                        }
                   }
                }
            });
    }
        else{
            Customerlist.displaywarning("Please Fill all the fields");
        }
    },

    onEditManager:function(){
        $("html").animate({ scrollTop: 0 }, "slow");
        var self=this;
        var data_id=$(this).attr('data-id');
        var html = '';
        var formData={
                id : data_id
            } 
            $.ajax({
                url: Customerlist.base_url+"restaurant/show_perticular_customer",
                type:'POST',
                data:formData ,
                success: function(result){
                        var data={
                            per_page:$('.btn-per-page').attr('selected-per-page'),
                            page:$('.btn-current-pageno').attr('curr-page')
                        }
                       Customerlist.listCustomers(data);
                       html = '<div class="col-md-12">\
            <div class="card welcome-image">\
                <div class="card-body">\
                    <div class="row">\
                        <div class="col-md-11">\
                            <form class="form-recipe-edit" method="post" action="javascript:;">\
                                <div class="row">\
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;">\
                                        <label style="font-weight:bold;">Name</label>\
                                        <input type="hidden" name="id" id="" value="'+result.id+'">\
                                        <input type="text" name="personname" id="personname" value="'+result.name+'" class="form-control" placeholder="Enter Name" style="text-transform: capitalize;">\
                                    </div>\
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;">\
                                        <label style="font-weight:bold;">Email</label>';
                                        if (result.email == null) {
                                            html +='<input type="email" name="email" id="email" value="" disabled class="form-control">';
                                        }else{
                                        html +='<input type="email" name="email" id="email" value="'+result.email+'" disabled class="form-control" placeholder="Enter Email">';}
                                    html +='</div>\
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;">\
                                        <label style="font-weight:bold;">Contact Number</label>\
                                        <input type="text" name="personcontact_number" id="personcontact_number" value="'+result.contact_no+'" class="form-control" placeholder="Enter Contact Number" onkeypress="return Customerlist.isNumber(event)">\
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
        </div>'
                       $('.edit_manager').html(html);
                       $('.edit_manager').show();
                       $(".addnewmanager").hide();
                }
            });
    },


    onSaveGroupname:function(){
        if($('#name').val()!="" && $('#contact_number').val()!=""){
            if ($('#contact_number').val().length < 8 || $('#contact_number').val().length > 14) { 
                Customerlist.displaywarning("Contact Number Should be 8 to 14 digit"); return false; }
                if ($('#name').val().length < 2 || $('#name').val().length > 30) { 
                    Customerlist.displaywarning("Name field should min 2 to max 30 characters"); return false; }
                var regexEmail = /\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
            var email = document.getElementById("email");
            if($('#email').val() != ''){
            if (regexEmail.test(email.value) == false) { 
                Customerlist.displaywarning("Invalid Email");
                return false;
            }
            }
                    $('#image-loader').show();
                    $.ajax({
                        url: Customerlist.base_url+"Restaurant/save_customers",
                        type:'POST',
                        dataType: 'json',
                        data: {
                            name : $('#name').val(),
                            email:$('#email').val(),
                            contact_no:$('#contact_number').val()
                        },
                        success: function(result){
                            $('#image-loader').hide();
                            if (result.status) {
                                if(result.is_email_exist){
                                    Customerlist.displaywarning("Contact Number already exist.");
                                }else{
                                    Customerlist.displaysucess("Customer added successfully");
                                    var data={
                                        per_page:$('.btn-per-page').attr('selected-per-page'),
                                        page:$('.btn-current-pageno').attr('curr-page')
                                    }
                                    Customerlist.listCustomers(data);
                                }
                                $('#name').val('');
                                $('#email').val('');
                                $('#contact_number').val('');
                                $('.btn-add-group').html('Save');
                        
                            }else{
                                Customerlist.displaywarning(result.msg);
                            }
                        }
                    });
    }
    else{
        Customerlist.displaywarning("Customer name and mobile number should not be empty");
    }

    },


    deleteGroup:function(){
        if($(this).is(':checked')){
            $(this).val("on");
            Customerlist.displaysucess("Customer is Unblock now");
        }

        else{
            $(this).val("off");
            Customerlist.displaysucess("Customer is Block now");
        }

        var self=this;
        var data_id=$(this).attr('data-id');
        var formData={
            id : data_id,
            is_block:$(this).val()
        } 
        $('#image-loader').show();
        $.ajax({
            url: Customerlist.base_url+"restaurant/block_unblock_customer",
            type:'POST',
            data:formData,
            success: function(result){
                $('#image-loader').hide();
                if (result.status) {
                    var data={
                        per_page:$('.btn-per-page').attr('selected-per-page'),
                        page:$('.btn-current-pageno').attr('curr-page')
                    }
                    Customerlist.listCustomers(data);
                }
                else{
                    Customerlist.displaywarning("Something went wrong please try again");
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
    listCustomers:function(data,fromevent){
        $('#image-loader').show();
        $.ajax({
            url: Customerlist.base_url+"restaurant/list_customers/",
            type:'POST',
            dataType: 'json',
            data: data,
            success: function(response){
                $('#image-loader').hide();
                var customers=response.customers;
                var html="";
                var j = 1;
                for (i in customers) {
                        html+='<tr>\
                        <td>'+j+'</td>\
                        <td>'+customers[i].name+'</td>\
                        <td>';if(customers[i].email == null){
                            html+='';
                        }
                        else{
                            html+=customers[i].email;
                        }
                        html +='</td>';
                        html+='<td>'+customers[i].contact_no+'</td>';
                        html+='</td>\
                         <td class="text-center">\
                            <label class="custom-switch pl-0">';
                            if(customers[i].is_block==0)
                                html+='<input type="checkbox" name="custom-switch-checkbox" data-id="'+customers[i].id+'" class="custom-switch-input input-switch-box" checked>';
                            else{
                                html+='<input type="checkbox" name="custom-switch-checkbox" data-id="'+customers[i].id+'" class="custom-switch-input input-switch-box">';
                            }
                        html+='<span class="custom-switch-indicator"></span></label>\
                        </td>\
                        <td>\
                            <a class="a-edit-customer" data-id="'+customers[i].id+'" style="color:#089e60;margin-right:10px;cursor: pointer;"><i class="fa fa-edit"></i></a>\
                        </td>\
                    </tr>';
                    j=j+1;
                }
                $('.tbody-customer-list').html(html);
                $('.span-all-groups').html(response.total_count);
                $('.span-page-html').html(response.page_total_text);
                $('.btn-current-pageno').attr('curr-page',response.page_no);
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

    isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
},

};