var Addonmenu ={
    base_url:null,
    init:function() {
        this.bind_events();
        var data={
            per_page : $('.btn-per-page').attr('selected-per-page'),
            page:1
        }
        this.listmanager(data);

        this.loadMenuItems();
    },

    bind_events :function() {
        var self=this;
		$('body').on('change','#menu_group_id',this.get_all_menu_id);
		$('body').on('change','#edit_menu_group_id',this.edit_get_all_menu_id);
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
            Addonmenu.listmanager(data);
        });
        $('.btn-prev').on('click',function(){
            var data={
                per_page:$('.dropdown-toggle').attr('selected-per-page'),
                page:$(this).attr('page-no')
            }
            Addonmenu.listmanager(data);
        });
        $('.btn-next').on('click',function(){
            var data={
                per_page:$('.dropdown-toggle').attr('selected-per-page'),
                page:$(this).attr('page-no')
            }
            Addonmenu.listmanager(data);
        });
        $('#searchInput').on('keyup',function(){
           
             if($(this).val()==""){
                var data={
                    per_page:$('.dropdown-toggle').attr('selected-per-page'),
                    page:1
                }
                Addonmenu.listmanager(data,'fromsearch');
            }else{
                if($(this).val().length>=3){
                    var data={
                        per_page:'all',
                        page:1,
                        searchkey:$('#searchInput').val()
                    }
                    Addonmenu.listmanager(data,'fromsearch');
                }
            }
        });

        $('.tbody-group-list').on('click','.input-switch-box',this.changeStatusManager);
        $('.tbody-group-list').on('click','.a-delete-group',this.onDeleteManager);

        $('.tbody-group-list').on('click','.a-edit-group',this.onEditManager);
        $('.edit_manager').on('click','.closeedit',this.oncancelEditManager);
        $('.edit_manager').on('click','.editperticular_manager',this.onEditPerticularManager);
        $('.edit_manager').on('click','.delete_option',this.ondeleteoption);
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

    },
	
	get_all_menu_id:function(){
		var group_id = $('#menu_group_id').val();
		//$('#image-loader').show();
		if(group_id!=''){
		$.ajax({
            url: Addonmenu.base_url+"Restaurant/get_menu_id_for_addon",
            type:'POST',
            data:{group_id:group_id},
            success: function(result){
				//$('#image-loader').hide();
               var html='<option value="">Select Menu</option>';
			   for(var i=0;i<result.length;i++){
				   html+='<option value="'+result[i].id+'">'+result[i].name+'</option>';
			   }
			   $('#menu_id').html(html);
            }
        });
		}
	},
	
	edit_get_all_menu_id:function(){
		var group_id = $('#edit_menu_group_id').val();
		$.ajax({
            url: Addonmenu.base_url+"Restaurant/get_menu_id_for_addon",
            type:'POST',
            data:{group_id:group_id},
            success: function(result){
				//$('#image-loader').hide();
               var html='<option>Select Menu</option>';
			   for(var i=0;i<result.length;i++){
				   html+='<option value="'+result[i].id+'">'+result[i].name+'</option>';
			   }
			   $('#edit_menu_id').html(html);
            }
        });
	},


    loadMenuItems:function(){
        $('body').delegate('.input-item-name','focus',function(){
            debugger;
            var $input = $(this);
            $.get(Addonmenu.base_url+"restaurant/choose_addon_menu/", function(data){
                $input.typeahead({ 
                    source:data,autoSelect: true,
                    afterSelect:function(item){
                        
                    },
                });
            },'json');
        });
    },



    changeStatusManager:function(){
        if($(this).is(':checked')){
            $(this).val("on");
            Addonmenu.displaysucess("Add on menu is Active now");}
        else{
            $(this).val("off");
            Addonmenu.displaysucess("Add on menu is Inactive now");
        }

        var self=this;
        var data_id=$(this).attr('data-id');
        var formData={
            id : data_id,
            is_active:$(this).val()
        }
        $.ajax({
            url: Addonmenu.base_url+"Restaurant/recipe_status",
            type:'POST',
            data:formData ,
            success: function(result){
               if (result.status) {
                //Addonmenu.displaysucess("Status Changed successfully");
                    var data={
                        per_page:$('.btn-per-page').attr('selected-per-page'),
                        page:1
                    }
                   Addonmenu.listmanager(data);
               }
               else{
                    Addonmenu.displaywarning("Something went wrong please try again");
               }
            }
        });
    },

    oncancelEditManager:function(){
        $('.edit_manager').hide();
    },

    onEditManager:function(){
		debugger;
        //console.log(Addonmenu.allrecipes);
        $("html").animate({ scrollTop: 0 }, "slow");
        var self=this;
        var data_id=$(this).attr('data-id');
        var html = '';
        var formData={
                id : data_id
            } 
            $.ajax({
                url: Addonmenu.base_url+"Restaurant/show_perticular_addon_menu",
                type:'POST',
                data:formData ,
                success: function(result){
                        var data={
                            per_page:$('.btn-per-page').attr('selected-per-page'),
                            page:1
                        }
						//alert(result.addon_details.menu_id);
                       Addonmenu.listmanager(data);
                       var html = "";
                       html += '<div class="col-md-12">\
                       <div class="card welcome-image">\
                           <div class="card-body">\
                               <div class="row">\
                                   <div class="col-md-11">\
                                       <form class="form-recipe-edit" method="post" action="javascript:;">\
                                           <div class="row">\
                                               <div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;">\
                                                   <label style="font-weight:bold;">Select Menu Group</label>\
                                                   <select class="form-control" name="menu_group" id="edit_menu_group_id" style="width:100%;">\
                                                       <option value="">Select Menu Group</option>';
                                                       for(var i=0 ; i < result.menu_group.length;i++){
                                                        if(result.addon_details.menu_group_id == result.menu_group[i].id){
                                                        html +='<option value="'+result.menu_group[i].id+'" selected>'+result.menu_group[i].title+'</option>';
                                                        }else{
                                                            html +='<option value="'+result.menu_group[i].id+'">'+result.menu_group[i].title+'</option>';
                                                        }
                                                       }
                                                   html +='</select>\
                                               </div>\
											   <div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;">\
                                                   <label style="font-weight:bold;">Select Menu</label>\
                                                   <select class="form-control" name="menu_id" id="edit_menu_id" style="width:100%;">\
                                                       <option value="">Select Menu</option>';
                                                       for(var i=0 ; i < result.menu.length;i++){
                                                        if(result.addon_details.menu_id == result.menu[i].id){
                                                        html +='<option value="'+result.menu[i].id+'" selected>'+result.menu[i].name+'</option>';
                                                        }else{
                                                            html +='<option value="'+result.menu[i].id+'">'+result.menu[i].name+'</option>';
                                                        }
                                                       }
                                                   html +='</select>\
                                               </div>\
                                               <div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;">\
                                                   <label style="font-weight:bold;">Name</label>\
                                                   <input type="text" name="addon_name" class="form-control input-item-name typeahead" onclick="this.select();" placeholder="Enter addon menu" autocomplete="off" id="edit_addon_name" value="'+result.addon_details.addon_name+'" style="text-transform: capitalize;">\
                                               </div>\
                                               <div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;">\
                                                   <label style="font-weight:bold;">Select Multiple Options</label><br>';
                                                   if(result.addon_details.is_multiple_menu == 'Yes'){
                                                   html +='<input type="radio" name="select_multiple_option" class="edit_select_multiple_option" value="No"> No &nbsp;&nbsp;\
                                                   <input type="radio" name="select_multiple_option" class="edit_select_multiple_option" value="Yes" checked> Yes';
                                                   }else{
                                                    html +='<input type="radio" name="select_multiple_option" class="edit_select_multiple_option" checked value="No"> No &nbsp;&nbsp;\
                                                    <input type="radio" name="select_multiple_option" class="edit_select_multiple_option" value="Yes"> Yes';  
                                                   }
                                               html +='</div>\
                                           </div>\
                                           <div class="row">\
                                               <div class="col-lg-12 col-md-12 col-sm-12 col-12" style="margin-top:10px;">\
                                                   <label style="font-weight:bold;">Options</label>\
                                                   <div class="row" id="option_data_load">';
                                                   for(var k=0 ; k< result.option.length;k++){
                                                   html +='<div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;">\
                                                       <input type="text" name="edit_option_name[]" value="'+result.option[k].option_name+'" placeholder="Enter Name" class="form-control" style="text-transform: capitalize;">\
                                                   </div>\
                                                   <div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;">\
                                                       <input type="text" name="edit_option_price[]" value="'+result.option[k].price+'" placeholder="Enter Price" class="form-control">\
                                                   </div>\
                                                   <div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;"><i class="fa fa-trash delete_option" addon-id="'+result.addon_details.id+'" delete-option-id="'+result.option[k].id+'" style="color:red"></i></div>';
                                                    }
                                                   html +='\
                                               </div>\
                                               <div class="row">\
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12 displaymore1"></div>\
                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;"><kbd class="btn btn-primary" onclick="addspecifications1()">Add More</kbd></div>\
                                               </div>\
                                               </div>\
                                           </div>\
                                           <div class="row">\
                                               <div class="col-md-12 text-right">\
                                                   <hr>\
                                               </div>\
                                           </div>\
                                           <div class="row">\
                                               <div class="col-md-12 text-right">\
                                                   <button type="submit" class="btn btn-secondary btn-save-details editperticular_manager" addon-id="'+result.addon_details.id+'" type="button" style="background-color: #ED3573;border: 0px !important;float:right;margin-top:10px;margin-top: 1rem;">Save</button>\
                                               </div>\
                                           </div>\
                                       </form>\
                                   </div>\
                               </div>\
                           </div>\
                       </div>\
                   </div>';
                       $('.edit_manager').html(html);
                       $('.edit_manager').show();
                       $(".addnewmanager").hide();
                }
            });
    },

    ondeleteoption:function(){
        var data_id=$(this).attr('delete-option-id');
        var addon_id=$(this).attr('addon-id');
                var formData={
                id : data_id,
                addon_menu_id : addon_id
            } 
            $.ajax({
                url: Addonmenu.base_url+"Restaurant/delete_addon_option",
                type:'POST',
                data:formData ,
                success: function(result){
                   if (result.status) {
                        var data={
                            per_page:$('.btn-per-page').attr('selected-per-page'),
                            page:1
                        }
                       Addonmenu.listmanager(data);
                       var html = '';
                       for(var k=0 ; k< result.option.length;k++){
                        html +='<div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;">\
                            <input type="text" name="edit_option_name[]" value="'+result.option[k].option_name+'" placeholder="Enter Name" class="form-control">\
                        </div>\
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;">\
                            <input type="text" name="edit_option_price[]" value="'+result.option[k].price+'" placeholder="Enter Price" class="form-control">\
                        </div>\
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;"><i class="fa fa-trash" addon-id="'+result.option[k].addon_menu_id+'" delete-option-id="'+result.option[k].id+'" style="color:red"></i></div>';
                         }
                       $('#option_data_load').html(html);

                   }
                   else{
                        Addonmenu.displaywarning("Something went wrong please try again");
                   }
                }
            });
    },

    onEditPerticularManager:function(){
        var addon_id=$(this).attr('addon-id');
        var option_name = $("input[name='edit_option_name[]']")
              .map(function(){return $(this).val();}).get();
        
        var option_price = $("input[name='edit_option_price[]']")
              .map(function(){return $(this).val();}).get();
        
        if($('#edit_addon_name').val()!="" && $('#edit_menu_group_id').val()!="" && $('input[class=edit_select_multiple_option]:checked').val()!=""){
                //$('#image-loader').show();
                $.ajax({
                    url: Addonmenu.base_url+"Restaurant/edit_perticular_addon_menu",
                    type:'POST',
                    dataType: 'json',
                    data: {
                        id : addon_id,
                        menu_group_id : $('#edit_menu_group_id').val(),
						menu_id : $('#edit_menu_id').val(),
                        addon_name : $('#edit_addon_name').val(),
                        is_multiple_menu : $('input[class=edit_select_multiple_option]:checked').val(),
                        option_name: option_name,
                        option_price: option_price
                    },
                    success: function(result){
                        $('#image-loader').hide();
                        if (result.status) {
                                Addonmenu.displaysucess("Information Saved successfully");
                                $('.edit_manager').hide();
                                var data={
                                    per_page:$('.btn-per-page').attr('selected-per-page'),
                                    page:1
                                }
                                Addonmenu.listmanager(data);
                        
                        }else{
                        Addonmenu.displaywarning(result.msg);
                        }
                    }
                });
        }
        else{
            Addonmenu.displaywarning("Please Fill all the fields");
        }

    },

    onDeleteManager:function(){
        var self=this;
        var data_id=$(this).attr('data-id');
        var title='Are you sure ?';
        var text="Delete Add on menu";
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
                url: Addonmenu.base_url+"Restaurant/delete_perticular_addon_menu",
                type:'POST',
                data:formData ,
                success: function(result){
                   if (result.status) {
                        Addonmenu.displaysucess("Delete successfully");
                        var data={
                            per_page:$('.btn-per-page').attr('selected-per-page'),
                            page:1
                        }
                       Addonmenu.listmanager(data);
                   }
                   else{
                        Addonmenu.displaywarning("Something went wrong please try again");
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
        var option_name = $("input[name='option_name[]']")
              .map(function(){return $(this).val();}).get();
        
        var option_price = $("input[name='option_price[]']")
              .map(function(){return $(this).val();}).get();
        
        if($('#addon_name').val()!="" && $('#menu_group_id').val()!="" && $('input[class=select_multiple_option]:checked').val()!=""){
                //$('#image-loader').show();
                $.ajax({
                    url: Addonmenu.base_url+"Restaurant/save_addon_menu",
                    type:'POST',
                    dataType: 'json',
                    data: {
                        menu_group_id : $('#menu_group_id').val(),
						menu_id : $('#menu_id').val(),
                        addon_name : $('#addon_name').val(),
                        is_multiple_menu : $('input[class=select_multiple_option]:checked').val(),
                        option_name: option_name,
                        option_price: option_price
                    },
                    success: function(result){
                        $('#image-loader').hide();
                        if (result.status) {
                                Addonmenu.displaysucess("Add On Menu created successfully");
                                var data={
                                    per_page:$('.btn-per-page').attr('selected-per-page'),
                                    page:1
                                }
                                Addonmenu.listmanager(data);
                            $('#name').val('');
                            $('#quantity').val('');
                            $('#price').val('');
                            $('.btn-add-group').html('Save');
							/* $(".addnewmanager").hide(); */
							location.reload();
                        
                        }else{
                        Addonmenu.displaywarning(result.msg);
                        }
                    }
                });
        }
        else{
            Addonmenu.displaywarning("Please Fill all the fields");
        }

    },
    
    listmanager:function(data,fromevent){
		debugger;
        $.ajax({
            url: Addonmenu.base_url+"Restaurant/list_addon_menu/",
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
							<td>'+managers[i].addon_name+'</td>\
                            <td>'+managers[i].title+'</td>\
                            <td>'+managers[i].option_count+'</td>\
                            <td>'+managers[i].is_multiple_menu+'</td>\
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