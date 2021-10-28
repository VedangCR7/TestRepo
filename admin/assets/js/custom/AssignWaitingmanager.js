var AssignWaitingmanager ={
    base_url:null,
    init:function() {
        this.bind_events();
        var data={
            per_page : $('.btn-per-page').attr('selected-per-page'),
            page:1
        }
        if ($('#assigndeclinechange').val() == 'Decline') {
                this.declinelistmanager(data);
        }
        if($('#assigndeclinechange').val() == 'Assign'){
            this.listmanager(data);
        }
        if($('#assigndeclinechange').val() == ''){
        this.alllistmanager(data);}
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
            if ($('#assigndeclinechange').val() == 'Decline') {
                AssignWaitingmanager.declinelistmanager(data);
        }
        if($('#assigndeclinechange').val() == 'Assign'){
            AssignWaitingmanager.listmanager(data);
        }
        if($('#assigndeclinechange').val() == ''){
        AssignWaitingmanager.alllistmanager(data);}
        });
        $('.btn-prev').on('click',function(){
            var data={
                per_page:$('.dropdown-toggle').attr('selected-per-page'),
                page:$(this).attr('page-no')
            }
            if ($('#assigndeclinechange').val() == 'Decline') {
                AssignWaitingmanager.declinelistmanager(data);
        }
        if($('#assigndeclinechange').val() == 'Assign'){
            AssignWaitingmanager.listmanager(data);
        }
        if($('#assigndeclinechange').val() == ''){
        AssignWaitingmanager.alllistmanager(data);}
        });
        $('.btn-next').on('click',function(){
            var data={
                per_page:$('.dropdown-toggle').attr('selected-per-page'),
                page:$(this).attr('page-no')
            }
            if ($('#assigndeclinechange').val() == 'Decline') {
                AssignWaitingmanager.declinelistmanager(data);
        }
        if($('#assigndeclinechange').val() == 'Assign'){
            AssignWaitingmanager.listmanager(data);
        }
        if($('#assigndeclinechange').val() == ''){
        AssignWaitingmanager.alllistmanager(data);}
        });
        $('#searchInput').on('keyup',function(){
           
             if($(this).val()==""){
                var data={
                    per_page:$('.dropdown-toggle').attr('selected-per-page'),
                    page:1
                }
                if ($('#assigndeclinechange').val() == 'Decline') {
                    AssignWaitingmanager.declinelistmanager(data,'fromsearch');
                }if($('#assigndeclinechange').val() == 'Assign'){
                AssignWaitingmanager.listmanager(data,'fromsearch');}
                if($('#assigndeclinechange').val() == ''){
                    AssignWaitingmanager.alllistmanager(data,'fromsearch');}
            }else{
                if($(this).val().length>=3){
                    var data={
                        per_page:'all',
                        page:1,
                        searchkey:$('#searchInput').val()
                    }
                    if ($('#assigndeclinechange').val() == 'Decline') {
                        AssignWaitingmanager.declinelistmanager(data,'fromsearch');
                    }if($('#assigndeclinechange').val() == 'Assign'){
                    AssignWaitingmanager.listmanager(data,'fromsearch');}
                    if($('#assigndeclinechange').val() == ''){
                        AssignWaitingmanager.alllistmanager(data,'fromsearch');}
                }
            }
        });

        $('#assigndeclinechange').on('change',this.declinelist);



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

    declinelist:function(){
        var show = $('#assigndeclinechange').val();
        if (show == 'Assign') 
        {
            var data={
            per_page:$('.btn-per-page').attr('selected-per-page'),
            page:1
            }
            AssignWaitingmanager.listmanager(data);
        }
        if (show == 'Decline'){
            //alert('Decline');
            var data={
            per_page:$('.btn-per-page').attr('selected-per-page'),
            page:1
            }
            AssignWaitingmanager.declinelistmanager(data);
        }

        if(show == ''){
            var data={
                per_page:$('.btn-per-page').attr('selected-per-page'),
                page:1
                }
                AssignWaitingmanager.alllistmanager(data);
        }
    },

    declinelistmanager:function(data,fromevent){
        $.ajax({
            url: AssignWaitingmanager.base_url+"Waiting_manager/decline_list/",
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
                            html+='<td>'+managers[i].name+'</td>\
                            <td>'+managers[i].mobile_number+'</td>\
                            <td>'+managers[i].no_of_person+'</td><td>';
                            if(managers[i].is_decline == 1){
                                html+='<span style="color:red;font-weight:bold;">Declined</span>';
                            }
                            html+='</td><td>'+AssignWaitingmanager.tConvert(managers[i].arrive_time)+'</td>\
                            <td>';
                            if(managers[i].action_taken != null){
                                html +=managers[i].action_taken;
                            }
                            html +='</td>\
                            <td>'+AssignWaitingmanager.convertDateStringToDate(managers[i].calendar_date)+'</td>\
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
    
    listmanager:function(data,fromevent){
        $.ajax({
            url: AssignWaitingmanager.base_url+"Waiting_manager/assign_list/",
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
                            html+='<td>'+managers[i].name+'</td>\
                            <td>'+managers[i].mobile_number+'</td>\
                            <td>'+managers[i].no_of_person+'</td>\
                            <td>';
                            if(managers[i].is_assign == 1){
                                html+='<span style="color:green;font-weight:bold;">Assigned</span>';
                            }
                            html+='</td>\
                            <td>'+AssignWaitingmanager.tConvert(managers[i].arrive_time)+'</td>\
                            <td>';
                            if(managers[i].action_taken != null){
                                html +=managers[i].action_taken;
                            }
                            html +='</td>\
                            <td>'+AssignWaitingmanager.convertDateStringToDate(managers[i].calendar_date)+'</td>\
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

    alllistmanager:function(data,fromevent){
        $.ajax({
            url: AssignWaitingmanager.base_url+"Waiting_manager/all_declineassign_list/",
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
                            html+='<td>'+managers[i].name+'</td>\
                            <td>'+managers[i].mobile_number+'</td>\
                            <td>'+managers[i].no_of_person+'</td>\
                            <td>';
                            if(managers[i].is_assign == 1){
                                html+='<span style="color:green;font-weight:bold;">Assigned</span>';
                            }
                            if(managers[i].is_decline == 1){
                                html+='<span style="color:red;font-weight:bold;">Declined</span>';
                            }
                            html+='</td>\
                            <td>'+AssignWaitingmanager.tConvert(managers[i].arrive_time)+'</td>\
                            <td>';
                            if(managers[i].action_taken != null){
                                html +=managers[i].action_taken;
                            }
                            html +='</td>\
                            <td>'+AssignWaitingmanager.convertDateStringToDate(managers[i].calendar_date)+'</td>\
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

    tConvert (time) {
  // Check correct time format and split into components
  time = time.toString ().match (/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];

  if (time.length > 1) { // If time format correct
    time = time.slice (1);  // Remove full string match value
    time[5] = +time[0] < 12 ? 'AM' : 'PM'; // Set AM/PM
    time[0] = +time[0] % 12 || 12; // Adjust hours
  }
  return time.join (''); // return adjusted time or original string
},  

    convertDateStringToDate(dateStr) {
        //  Convert a string like '2020-10-04T00:00:00' into '4/Oct/2020'
        let months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        let date = new Date(dateStr);
        let str = date.getDate()
        + ' ' + months[date.getMonth()]
        + ' ' + date.getFullYear()
        return str;
    }

};