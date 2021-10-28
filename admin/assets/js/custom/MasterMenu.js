var MasterMenu ={
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
            MasterMenu.listmanager(data);
        });
		
		$('.addcsv').on('click',function(){
			$(this).closest('div').find('.uploadfile').trigger('click');
		});
				
        $('.uploadfile').on('change',this.uploadexlfile);
		
        $('.btn-prev').on('click',function(){
            var data={
                per_page:$('.dropdown-toggle').attr('selected-per-page'),
                page:$(this).attr('page-no')
            }
            MasterMenu.listmanager(data);
        });
        $('.btn-next').on('click',function(){
            var data={
                per_page:$('.dropdown-toggle').attr('selected-per-page'),
                page:$(this).attr('page-no')
            }
            MasterMenu.listmanager(data);
        });
        $('#searchInput').on('keyup',function(){
           
             if($(this).val()==""){
                var data={
                    per_page:$('.dropdown-toggle').attr('selected-per-page'),
                    page:1
                }
                MasterMenu.listmanager(data,'fromsearch');
            }else{
                if($(this).val().length>=3){
                    var data={
                        per_page:'all',
                        page:1,
                        searchkey:$('#searchInput').val()
                    }
                    MasterMenu.listmanager(data,'fromsearch');
                }
            }
        });

        $('.tbody-group-list').on('click','.input-switch-box',this.changeStatusManager);
        //$('.btn-add-group').on('click',this.onSaveGroupname);
        $('.tbody-group-list').on('click','.a-edit-group',this.onEditManager);
        $('#giveeditbutton').on('click','.editperticular_mastermenu',this.onEditPerticularManager);
        $('#giveeditbutton').on('click','.btn-add-group',this.onSaveGroupname);


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
	
	uploadexlfile:function()
	{
        debugger;
        var $form_data = new FormData();
        $form_data.append('uploadFile',$('.uploadfile')[0].files[0]);
        //console.log($form_data);
        $.ajax({
            url: MasterMenu.base_url+"mainmenumaster/uploadData",
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
                    MasterMenu.displaysucess("upload successfully");
                } 
                else
				{
                    MasterMenu.displaywarning(result.msg);
                }
				
                $('#image-loader').hide();
                
				var data={
                    per_page:$('.btn-per-page').attr('selected-per-page'),
                    page:1
                }
                MasterMenu.listmanager(data);
            }
        });
    },

    changeStatusManager:function(){
        if($(this).is(':checked')){
            $(this).val("on");
            MasterMenu.displaysucess("Master Menu is Active now");}
        else{
            $(this).val("off");
            MasterMenu.displaysucess("Master Menu is Inactive now");
        }

        var self=this;
        var data_id=$(this).attr('data-id');
        var formData={
            id : data_id,
            is_active:$(this).val()
        }
        $.ajax({
            url: MasterMenu.base_url+"mainmenumaster/delete_master_menu",
            type:'POST',
            data:formData ,
            success: function(result){
               if (result.status) {
                    //MasterMenu.displaysucess("Status Changed successfully");
                    var data={
                        per_page:$('.btn-per-page').attr('selected-per-page'),
                        page:1
                    }
                   MasterMenu.listmanager(data);
               }
               else{
                    MasterMenu.displaywarning("Something went wrong please try again");
               }
            }
        });
    },

    onSaveGroupname:function(){
        if($('#name').val() != ''){
            if ($('#name').val().length >=2 && $('#name').val().length <= 50) {
                $('#image-loader').show();
                $.ajax({
                    url: MasterMenu.base_url+"mainmenumaster/save_menu_master",
                    type:'POST',
                    dataType: 'json',
                    data: {
                        /*name : filter_var($('#name').val(), FILTER_SANITIZE_STRING)*/
                        name: $('#name').val(),
                    },
                    success: function(result){
                        $('#image-loader').hide();
                        if (result.status) {
                            if(result.is_name_exist){
                                MasterMenu.displaywarning("Master Menu Name already exists");
                            }else{
                                MasterMenu.displaysucess("Master Menu created successfully");
                                var data={
                                    per_page:$('.btn-per-page').attr('selected-per-page'),
                                    page:1
                                }
                                MasterMenu.listmanager(data);
                            }
                            $('#name').val('');
                            $('.btn-add-group').html('Add');
                        
                        }else{
                        MasterMenu.displaywarning(result.msg);
                        }
                    }
                });
            }
            else{
                MasterMenu.displaywarning("Master Menu name should be 2 to 50 characters");
            }
        }
        else{
            MasterMenu.displaywarning("Master Menu name should not be empty");
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
                url: MasterMenu.base_url+"mainmenumaster/show_perticular_master_menu",
                type:'POST',
                data:formData ,
                success: function(result){
                        var data={
                            per_page:$('.btn-per-page').attr('selected-per-page'),
                            page:1
                        }
                        $('#name').val(result.name);
                        $('#giveeditbutton').html('<button type="submit" data-id="'+result.id+'" class="btn btn-secondary btn-save-details editperticular_mastermenu" type="button" style="background-color: #ED3573;border: 0px !important;">Save</button>');
                       MasterMenu.listmanager(data);
                }
            });
    },

    onEditPerticularManager:function(){
        if ($('#name').val() != '') {
            if($('#name').val().length >=2 && $('#name').val().length <= 50){
                $('#image-loader').show();
                var self=this;
                var data_id=$(this).attr('data-id');
                var formData={
                    id : data_id,
                    name : $('#name').val()
                } 
                $.ajax({
                    url: MasterMenu.base_url+"mainmenumaster/edit_perticular_master_menu",
                    type:'POST',
                    data:formData ,
                    success: function(result){
                        $('#image-loader').hide();
                        if (result.status) {
                            if(result.is_name_exist){
                                MasterMenu.displaywarning("Master Menu Name already exists");
                            }else{
                                MasterMenu.displaysucess("Master Menu save successfully");
                                var data={
                                    per_page:$('.btn-per-page').attr('selected-per-page'),
                                    page:1
                                }
                                $('#name').val('');
                                $('#giveeditbutton').html('<button type="submit" class="btn btn-secondary btn-save-details btn-add-group" type="button" style="background-color: #ED3573;border: 0px !important;">Add</button>');
                                MasterMenu.listmanager(data);
                                MasterMenu.listmanager(data);
                            }
                        
                        }else{
                            MasterMenu.displaywarning("Something went wrong please try again");
                        }
                    }
                });
            }
            else{
                MasterMenu.displaywarning("Master Menu name should be 2 to 50 characters");
            }
        }
        else{
            MasterMenu.displaywarning("Master Menu name should not be empty");
        }
    },
    
    listmanager:function(data,fromevent){
        $.ajax({
            url: MasterMenu.base_url+"mainmenumaster/list_master_menu/",
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
                            html+='<td>'+managers[i].id+'</td>\
							<td>'+managers[i].name+'</td>\
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
                            <a class="a-edit-group" data-id="'+managers[i].id+'" style="color:green;cursor: pointer;"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\
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