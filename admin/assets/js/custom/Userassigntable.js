var Userassigntable ={
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
            if($('#user_type').val() == 'Captain'){
            Userassigntable.listmanager(data);}
            if($('#user_type').val() == 'Waiter'){
                Userassigntable.listmanager1(data);}
        });
        $('.btn-prev').on('click',function(){
            var data={
                per_page:$('.dropdown-toggle').attr('selected-per-page'),
                page:$(this).attr('page-no')
            }
            if($('#user_type').val() == 'Captain'){
            Userassigntable.listmanager(data);}
            if($('#user_type').val() == 'Waiter'){
                Userassigntable.listmanager1(data);
            }
        });
        $('.btn-next').on('click',function(){
            if($('#user_type').val() == 'Captain'){
            var data={
                per_page:$('.dropdown-toggle').attr('selected-per-page'),
                page:$(this).attr('page-no')
            }
            Userassigntable.listmanager(data);}
            if($('#user_type').val() == 'Waiter'){
                var data={
                    per_page:$('.dropdown-toggle').attr('selected-per-page'),
                    page:$(this).attr('page-no')
                }
                Userassigntable.listmanager1(data);
            }
        });
        $('#searchInput').on('keyup',function(){
           
             if($(this).val()==""){
                var data={
                    per_page:$('.dropdown-toggle').attr('selected-per-page'),
                    page:1
                }
                if($('#user_type').val() == 'Captain'){
                    Userassigntable.listmanager(data,'fromsearch');}
                if($('#user_type').val() == 'Waiter'){
                    Userassigntable.listmanager1(data,'fromsearch');
                }
            }else{
                if($(this).val().length>=3){
                    var data={
                        per_page:'all',
                        page:1,
                        searchkey:$('#searchInput').val()
                    }
                    if($('#user_type').val() == 'Captain'){
                        Userassigntable.listmanager(data,'fromsearch');}
                    if($('#user_type').val() == 'Waiter'){
                        Userassigntable.listmanager1(data,'fromsearch');
                    }
                }
            }
        });

        
        $('.tbody-group-list').on('click','.a-assign-table',this.onassigntable);
        $('#assign_table').on('click',this.assign_table_to_manager);

        $('.tbody-group-list').on('click','.a-assign-table1',this.onassigntable1);
        $('#assign_table1').on('click',this.assign_table_to_waiter);

        $('#user_type').on('change',this.change_user_type);

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

    change_user_type:function(){
        if($('#user_type').val() == 'Captain'){
            var data={
                per_page:$('.btn-per-page').attr('selected-per-page'),
                page:1
            }
            Userassigntable.listmanager(data);
        }
        if($('#user_type').val() == 'Waiter'){
            var data={
                per_page:$('.btn-per-page').attr('selected-per-page'),
                page:1
            }
            Userassigntable.listmanager1(data);
        }
    },

    assign_table_to_manager:function(){
        restaurant_manager_id = $('#manager_id').val();
        var array = [];
        $("input:checkbox[name=table_title]:checked").each(function() {
            array.push($(this).val());
        });
        console.log(array);
        $.ajax({
            url: Userassigntable.base_url+"Restaurant/assign_table_to_manager",
            type:'POST',
            data:{restaurant_manager_id:restaurant_manager_id,table:array},
            success: function(result){
                if(result.status){
                    $('#assigntablemodal').modal('hide');
                    Userassigntable.displaysucess("Saved Successfully");
                }else{
                    Userassigntable.displaywarning('Something went wrong');
                    return false;
                }
                var data={
                    per_page:$('.btn-per-page').attr('selected-per-page'),
                    page:1
                }
                Userassigntable.listmanager(data);
                
            }
        });
    },

    onassigntable:function(){
        var restaurant_manager_id=$(this).attr('data-id');
        $.ajax({
            url: Userassigntable.base_url+"Restaurant/show_table_rest_manager",
            type:'POST',
            data:{restaurant_manager_id:restaurant_manager_id},
            success: function(result){
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
                    var table_array=[];
                    for(var j = 0;j<result.assign_table.length;j++){
                        table_array.push(result.assign_table[j].table_id);
                    }
                    console.log(table_array);
                    for(var i = 0;i<result.table.length;i++){
                            if(table_array.includes(result.table[i].id)){
                                html +='<div class="col-lg-3 col-md-3 col-sm-6 col-6">';
                                html +='<input type="checkbox" class="table_title" name="table_title" value="'+result.table[i].id+'" checked> &nbsp;'+result.table[i].title; 
                                html +='</div>';
                            }
                    }
                // }
                $('#showtables').html(html);
                $("#assign_table1").hide();
                $("#assign_table").show();
                $('#assigntablemodal').modal('show');
            //    if (result.status) {
                    var data={
                        per_page:$('.btn-per-page').attr('selected-per-page'),
                        page:1
                    }
                   Userassigntable.listmanager(data);
            //    }
            //    else{
            //         Userassigntable.displaywarning("Something went wrong please try again");
            //    }
            }
        });
    },

    onassigntable1:function(){
	debugger;
        var restaurant_waiter_id=$(this).attr('data-id');
        $.ajax({
            url: Userassigntable.base_url+"waiter/show_table_rest_manager",
            type:'POST',
            data:{restaurant_waiter_id:restaurant_waiter_id},
            success: function(result){
                //console.log(result.assign_table[i].table_id);
                
                html ='';
                html += '<input type="hidden" id="waiter_id" value="'+restaurant_waiter_id+'">';
                // if(result.assign_table.length <=0){
                // for(var i = 0;i<result.table.length;i++){
                // html +='<div class="col-lg-3 col-md-3 col-sm-12 col-12">';
                //     html +='<input type="text" class="table_title" name="table_title" value="'+result.table[i].id+'"> &nbsp;'+result.table[i].title; 
                // html +='</div>';
                // }
                // }else{
                    var table_array=[];
                    for(var j = 0;j<result.assign_table.length;j++){
                        table_array.push(result.assign_table[j].table_id);
                    }
                    console.log(table_array);
                    for(var i = 0;i<result.table.length;i++){
                            if(table_array.includes(result.table[i].id)){
                                html +='<div class="col-lg-3 col-md-3 col-sm-6 col-6">';
                                html +='<input type="checkbox" class="table_title" name="table_title" value="'+result.table[i].id+'" checked> &nbsp;'+result.table[i].title; 
                                html +='</div>';
                            }
                    }
                // }
                $('#showtables').html(html);
                $("#assign_table").hide();
                $("#assign_table1").show();
                $('#assigntablemodal').modal('show');
            //    if (result.status) {
                    var data={
                        per_page:$('.btn-per-page').attr('selected-per-page'),
                        page:1
                    }
                   Userassigntable.listmanager1(data);
            //    }
            //    else{
            //         Userassigntable.displaywarning("Something went wrong please try again");
            //    }
            }
        });
    },


    assign_table_to_waiter:function(){
        restaurant_waiter_id = $('#waiter_id').val();
        //alert(restaurant_waiter_id);
        var array = [];
        $("input:checkbox[name=table_title]:checked").each(function() {
            array.push($(this).val());
        });
        console.log(array);
        $.ajax({
            url: Userassigntable.base_url+"waiter/assign_table_to_manager",
            type:'POST',
            data:{restaurant_waiter_id:restaurant_waiter_id,table:array},
            success: function(result){
                if(result.status){
                    $('#assigntablemodal').modal('hide');
                    Userassigntable.displaysucess("Saved Successfully");
                }else{
                    Userassigntable.displaywarning('Something went wrong');
                    return false;
                }
                var data={
                    per_page:$('.btn-per-page').attr('selected-per-page'),
                    page:1
                }
                Userassigntable.listmanager1(data);
                
            }
        });
    },


    
    listmanager:function(data,fromevent){
        debugger;
        $.ajax({
            url: Userassigntable.base_url+"restaurant/manager_table/",
            type:'POST',
            dataType: 'json',
            data: data,
            success: function(response){
                var managers=response.manager;
                var html="";
                var K=1;
                for (i in managers) {
                    var table =[];
                    for(j=0;j<managers[i].table_details.length;j++){
                        table.push(managers[i].table_details[j].title);
                    }
                    var x = table.toString();
                    html+='<tr menu-id="'+managers[i].id+'">\
                            <td>'+ K +'</td>';
                            html+='<td>'+managers[i].name+'</td>';
                            html+='<td>'+managers[i].contact_number+'</td>';
                            html+='<td>'+x+'</td>\
                            <td style="text-align:center">\
                            <a class="a-assign-table text-secondary" data-id="'+managers[i].manager_id+'" style="cursor: pointer;"><i class="fas fa-table"></i></a>\
                            </td>\
                        </tr>';
                        K=K+1;
                }
                $('#tbody-group-list').html(html);
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

    listmanager1:function(data,fromevent){
        $.ajax({
            url: Userassigntable.base_url+"waiter/waiter_table/",
            type:'POST',
            dataType: 'json',
            data: data,
            success: function(response){
                var managers=response.manager;
                //console.log(managers);
                var html="";
                var K=1;
                for (i in managers) {
                    var table =[];
                    for(j=0;j<managers[i].table_details.length;j++){
                        table.push(managers[i].table_details[j].title);
                    }
                    var x = table.toString();
                    html+='<tr menu-id="'+managers[i].id+'">\
                            <td>'+ K +'</td>';
                            html+='<td>'+managers[i].name+'</td>';
                            html+='<td>'+managers[i].contact_number+'</td>';
                            html+='<td>'+x+'</td>\
                            <td style="text-align:center">\
                            <a class="a-assign-table1 text-secondary" data-id="'+managers[i].waiter_id+'" style="cursor: pointer;"><i class="fas fa-table"></i></a>\
                            </td>\
                        </tr>';
                        K=K+1;
                }
                $('#tbody-group-list').html(html);
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