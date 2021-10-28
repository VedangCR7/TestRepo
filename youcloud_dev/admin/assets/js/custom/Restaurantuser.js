var Restaurantuser ={
    base_url:null,
    user_status:null,
    init:function() {
        this.bind_events();
        var data={
            per_page : 30,
            page:1,
            user_status:Restaurantuser.user_status
        }
        this.listUsers(data);
    },

    bind_events :function() {

        var self=this;
        $('#searchUserInput').on('keyup',function(){
            if($(this).val()==""){
                var data={
                    per_page:$('.dropdown-toggle').attr('selected-per-page'),
                    page:1,
                    user_status:Restaurantuser.user_status
                }
            }else{
                var data={
                    per_page:'all',
                    page:1,
                    user_status:Restaurantuser.user_status
                }
            }
          
            Restaurantuser.listUsers(data,'fromsearch');

        });
        $('.btn-add-user').on('click',function(){
            $('#modal-new-user').modal({
                backdrop: 'static',
                keyboard: false
            });
            $('#form-user input').val('');
            $(".toggle-password").each(function(){
               var input = $($(this).attr("toggle"));
                if (input.attr("type") == "text") {
                    $(this).trigger('click');
                }
            });

        });
        $('.a-user-perpage').on('click',function(){
            $(this).closest('.btn-group').find('button').attr('selected-per-page',$(this).attr('data-per'));
            if($(this).attr('data-per')=="all")
                $(this).closest('.btn-group').find('button').html($(this).html()+' items');
            else
                $(this).closest('.btn-group').find('button').html($(this).html()+' items per page');
            var data={
                per_page:$(this).attr('data-per'),
                page:1,
                user_status:Restaurantuser.user_status
            }
            Restaurantuser.listUsers(data);
        });
        $('.btn-prev').on('click',function(){
            var data={
                per_page:$('.dropdown-toggle').attr('selected-per-page'),
                page:$(this).attr('page-no'),
                 user_status:Restaurantuser.user_status
            }
            Restaurantuser.listUsers(data);
        });
        $('.btn-next').on('click',function(){
            var attr = $(this).attr('disabled');
            if (!(typeof attr !== typeof undefined && attr !== false)) {
                var data={
                    per_page:$('.dropdown-toggle').attr('selected-per-page'),
                    page:$(this).attr('page-no'),
                     user_status:Restaurantuser.user_status
                }
                Restaurantuser.listUsers(data);
            }
        });
        $('.tbody-user-list').on('click','.input-switch-box',this.onChangeStatus);
        $(".toggle-password").click(function() {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
    },

    onChangeStatus:function(){
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
            url: Restaurantuser.base_url+"company/change_user_status",
            type:'POST',
            data:formData ,
            success: function(result){
               if (result.status) {
                    var data={
                        per_page:$('.dropdown-toggle').attr('selected-per-page'),
                        page:1,
                        user_status:Restaurantuser.user_status
                    }
                   Restaurantuser.listUsers(data);
               }
               else{
                    Restaurantuser.displaywarning("Something went wrong please try again");
               }
            }
        });
    },
    listUsers:function(data,fromevent){
        $.ajax({
            url: Restaurantuser.base_url+"admin/list_restaurnts_pagination/",
            type:'POST',
            dataType: 'json',
            data: data,
            success: function(response){
                var users=response.users;
                var html="";
                for (i in users) {

                    html+='<tr style="';
                    if(users[i].is_active==1 && users[i].subscription_status=='inactive')
                        html+='background-color: lightpink;';
                     html+='">\
                            <td><a href="'+Restaurantuser.base_url+'company/viewuser/'+users[i].id+'" class="a-view-user" user-id="'+users[i].id+'">'+users[i].name+'</a></td>\
                            <td>'+users[i].email+'</td>\
                            <td>'+users[i].register_date+'</td>';
                             html+='<td>\
                             <label class="custom-switch pl-0">';
                                if(users[i].is_active==1)
                                    html+='<input type="checkbox" name="custom-switch-checkbox" data-id="'+users[i].id+'" class="custom-switch-input input-switch-box" checked>';
                                else
                                    html+='<input type="checkbox" name="custom-switch-checkbox" data-id="'+users[i].id+'" class="custom-switch-input input-switch-box">';
                                    html+='<span class="custom-switch-indicator"></span>\
                                </label>\
                             </td>\
                        </tr>';
                }
                $('.tbody-user-list').html(html);
                $('.span-all-users').html(response.total_count);
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
                    // $('.btn-next').prop('disabled', true);
                }

                if(fromevent=="fromsearch"){
                      var input, filter, table, tr, td, i, txtValue;
                      input = document.getElementById("searchUserInput");
                      filter = input.value.toUpperCase();
                      table = document.getElementById("table-users");
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

    displaysucessconfrim:function(msg)
    {
        swal({
            title:"Success !", 
            text:msg, 
            type:"success",
            confirmButtonClass: "btn-primary",
            confirmButtonText: "Ok",
            closeOnConfirm: false
        }).then(function(){
            window.location.href=Login.base_url+"users/dashboard";
        })
    },
    displaywarningconfrim:function(msg)
    {
         swal({
                title:"Error !", 
                text:msg, 
                type:"error",
                confirmButtonClass: "btn-primary",
                confirmButtonText: "Ok",
                closeOnConfirm: false
            }).then(function(){
                window.location.href="";
        })  
    }
};