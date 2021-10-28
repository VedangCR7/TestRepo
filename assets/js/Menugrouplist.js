var Menugrouplist ={
    base_url:null,
    init:function() {
        this.bind_events();
        var data={
            per_page : $('.btn-per-page').attr('selected-per-page'),
            page:1
        }
        this.listGroups(data);
    },

    bind_events :function() {
        var self=this;
        $('.tbody-group-list').on('click','.a-edit-group',function(){
            var group_id=$(this).attr("data-id");
            var group_name=$(this).attr("group-name");
            $('#AddMenuGroup').val(group_name);
            $('#menu_group_id').val(group_id);
            $('#is_edit_group').val('edit');
            $('.btn-add-group').html('UPDATE');
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
            }else{
                var data={
                    per_page:'all',
                    page:1
                }
            }
            /*var data={
                per_page:'all',
                page:1
            }*/
            Menugrouplist.listGroups(data,'fromsearch');
        });
        $('.tbody-group-list').on('click','.input-switch-box',this.deleteGroup);
        $('.btn-add-group').on('click',this.onSaveGroupname);
        $('#AddMenuGroup').on('keypress',function(e){
            //var string = string.replace(/\s\s+/g, ' ');
            var singleSpacesString=$(this).val().replace(/  +/g, ' ');
            $(this).val(singleSpacesString);
            /*var regex = new RegExp("^[a-zA-Z ]+$");
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
            if (regex.test(str)) {
                return true;
            }
            e.preventDefault();
            return false;*/
        });

    },
    onSaveGroupname:function(){
        if($('#AddMenuGroup').val()!=""){
            $.ajax({
                url: Menugrouplist.base_url+"school/save_menu_group",
                type:'POST',
                dataType: 'json',
                data: {
                    group_name : $('#AddMenuGroup').val(),
                    group_id:$('#menu_group_id').val(),
                    is_edit_group:$('#is_edit_group').val()
                },
                success: function(result){
                    if (result.status) { 
                        if(result.is_group_exist){
                            Menugrouplist.displaywarning("Menu group already exist.");
                        }else{
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
                        $('#menu_group_id').val('');
                        $('#is_edit_group').val('');
                        $('.btn-add-group').html('ADD');
                        
                    }else{
                        Menugrouplist.displaywarning(result.msg);
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
            url: Menugrouplist.base_url+"school/delete_group",
            type:'POST',
            data:formData ,
            success: function(result){
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
    listGroups:function(data,fromevent){
        $.ajax({
            url: Menugrouplist.base_url+"school/list_menu_group/",
            type:'POST',
            dataType: 'json',
            data: data,
            success: function(response){
                var groups=response.groups;
                var html="";
                for (i in groups) {

                    html+='<tr>\
                            <td>\
                              <a href="javascript:;" class="a-edit-group" group-name="'+groups[i].name+'" data-id="'+groups[i].id+'" style="color:#000;">'+groups[i].name+'</a>\
                            </td>\
                            <td>'+groups[i].menu_date+'</td>\
                            <td class="text-center">\
                                <label class="custom-switch pl-0">';
                                if(groups[i].is_active==1)
                                    html+='<input type="checkbox" name="custom-switch-checkbox" data-id="'+groups[i].id+'" class="custom-switch-input input-switch-box" checked>';
                                else
                                    html+='<input type="checkbox" name="custom-switch-checkbox" data-id="'+groups[i].id+'" class="custom-switch-input input-switch-box">';
                                    html+='<span class="custom-switch-indicator"></span>\
                                </label>\
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

                if(fromevent=="fromsearch"){
                    var input, filter, table, tr, td, i, txtValue;
                    input = document.getElementById("searchInput");
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