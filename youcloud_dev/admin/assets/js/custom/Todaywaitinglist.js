var Todaywaitinglist ={
    base_url:null,
    init:function() {
        this.bind_events();
        var data={
            per_page :'all',
            page:1
        }
        this.listmanager(data);
    },

    bind_events :function() {
        var self=this;
        $('#searchInput').on('keyup',function(){
           
             if($(this).val()==""){
                var data={
                    per_page:'all',
                    page:1
                }
                Todaywaitinglist.listmanager(data,'fromsearch');
            }else{
                if($(this).val().length>=3){
                    var data={
                        per_page:'all',
                        page:1,
                        searchkey:$('#searchInput').val()
                    }
                    Todaywaitinglist.listmanager(data,'fromsearch');
                }
            }
        });

        $('.tbody-group-list').on('click','.assign_cust',this.onassigned);
        $('.tbody-group-list').on('click','.decline_cust',this.ondecline);
        $('.tbody-group-list').on('click','.view_cust',this.viewwaitinglistcust);
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

        //$('#calendar1').on('click','.receivedate',this.onSelectDate);


    },

    // onSelectDate:function(){
    //     alert("hi");
    // },
    viewwaitinglistcust:function(){
        var id = $(this).attr('data-id');
            var date = $(this).attr('data-date');
            var formData={
                id : id
            } 
            $.ajax({
                url: Todaywaitinglist.base_url+"Waiting_manager/show_perticular_waitinglist_cust",
                type:'POST',
                data:formData ,
                success: function(result){

                   if (result) {
                    $('#showname').html(result.name);
                        $('.detailwaitingcust').html('<div class="col-lg-12 col-md-12 col-sm-12 col-12">\
                <div class="row">\
                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">\
                    <p>Mobile Number</p>\
                    </div>\
                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">\
                    <p>'+result.mobile_number+'&nbsp;<a href="tel:'+result.mobile_number+'"><button class="btn btn-primary btn-sm text-right"><i class="si si-phone text-white" aria-hidden="true"></i></button></a></p>\
                    </div>\
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">\
                        <hr>\
                    </div>\
                </div>\
                <div class="row">\
                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">\
                    <p>No. of person</p>\
                    </div>\
                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">\
                    <p>'+result.no_of_person+'</p>\
                    </div>\
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">\
                        <hr>\
                    </div>\
                </div>\
                <div class="row">\
                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">\
                    <p>In Time</p>\
                    </div>\
                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">\
                    <p>'+Todaywaitinglist.tConvert (result.arrive_time)+'</p>\
                    </div>\
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">\
                        <hr>\
                    </div>\
                </div>\
                <div class="row">\
                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">\
                    <p>Date</p>\
                    </div>\
                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">\
                    <p>'+Todaywaitinglist.convertDateStringToDate(result.calendar_date)+'</p>\
                    </div>\
                </div>\
            </div>')
                       $('#showwaitingdetails').modal('show');
                       var data={
                        per_page:'all',
                        page:1
                    }
                       Todaywaitinglist.listmanager(data);
                   }
                   else{
                        Todaywaitinglist.displaywarning("Something Went Wrong");
                   }
                }
            });
    },

    ondecline:function(){
        var id = $(this).attr('data-id');
            var title='Are you sure ?';
        var text="You Want to Decline this Customer";
        swal({
            title: title,
            text: text,
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33 !important',
            confirmButtonText: 'Yes, Decline it!',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false
        },function () {
            var formData={
                id : id
            } 
            $.ajax({
                url: Todaywaitinglist.base_url+"Waiting_manager/decline_waiting_manager",
                type:'POST',
                data:formData ,
                success: function(result){
                   if (result.status) {
                       var data={
                        per_page:'all',
                        page:1
                    }
                    Todaywaitinglist.listmanager(data);
                   }
                   else{
                    displaywarning("Something Went Wrong");
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


    onassigned:function(){
        var id = $(this).attr('data-id');
        //alert(id);
        var title='Are you sure ?';
        var text="You Want to Assign this Customer";
        swal({
            title: title,
            text: text,
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33 !important',
            confirmButtonText: 'Yes, Assign it!',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false
        },function () {
            var formData={
                id : id
            } 
            $.ajax({
                url: Todaywaitinglist.base_url+"Waiting_manager/assign_waiting_manager",
                type:'POST',
                data:formData ,
                success: function(result){
                   if (result.status) {
                    var data={
                        per_page:'all',
                        page:1
                    }
                   Todaywaitinglist.listmanager(data);
                    Todaywaitinglist.displaysucess("Assign successfully");
                   }
                   else{
                    Todaywaitinglist.displaywarning("Something Went Wrong");
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
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();
        today = yyyy + '-' + mm + '-' + dd;
        var hour = new Date().getHours();
        var minuites = new Date().getMinutes();
        var string = $('#arrive_time').val();
        var timearray= string.split(":");
        if($('#name').val()!="" && $('#mobile_number').val()!="" && $('#no_of_person').val()!="" && $('#arrive_time').val()!=""){
            if ((hour < timearray[0]) || (hour == timearray[0] && minuites < timearray[1])) {
                    if ($('#mobile_number').val().length < 8 || $('#mobile_number').val().length > 14) { Todaywaitinglist.displaywarning("Mobile Number should be 8 to 14 digit"); }
                    else{
                        if ($('#name').val().length < 2 || $('#name').val().length > 50) { Todaywaitinglist.displaywarning("Name field should accept 2 to 50 characters."); }
                        else{
                            $('#image-loader').show();
                            $.ajax({
                            url: Todaywaitinglist.base_url+"Waiting_manager/add_waiting_cust",
                            type:'POST',
                            dataType: 'json',
                            data: {
                                name : $('#name').val(),
                                mobile_number :$('#mobile_number').val(),
                                no_of_person :$('#no_of_person').val(),
                                arrive_time :$('#arrive_time').val(),
                                calendar_date : $('#calendar_date').val()
                            },
                            success: function(result){
                                $('#image-loader').hide();
                                if (result.status) {
                                    if(result.is_exist){
                                        Todaywaitinglist.displaywarning("This date and time already exist.");
                                        var data={
                                            per_page:'all',
                                            page:1
                                        }
                                        Todaywaitinglist.listmanager(data);

                                    }else{
                                        Todaywaitinglist.displaysucess("Created successfully");
                                        var data={
                                            per_page:'all',
                                            page:1
                                        }
                                        Todaywaitinglist.listmanager(data);

                                //Todaywaitinglist.listmanager(data);
                                    }
                                    $('#name').val('');
                                    $('#mobile_number').val('');
                                    $('#no_of_person').val('');
                                    $('#arrive_time').val('');
                                    $('.btn-add-group').html('Save');
                        
                                }else{
                                    Todaywaitinglist.displaywarning(result.msg);
                                }
                            }
                        });
                    }
                }
            }
            else{
                Todaywaitinglist.displaywarning("Please select valid time");
            }
        }
        else{
            Todaywaitinglist.displaywarning("Please Fill all the fields");
        }

    },
    
    listmanager:function(data,fromevent){
        $.ajax({
            url: Todaywaitinglist.base_url+"Waiting_manager/todays_waiting_list/",
            type:'POST',
            dataType: 'json',
            data: data,
            success: function(response){
                var managers=response.manager;
                var html="";
                var j=1;
                for (i in managers) {

                    html+='<tr>\
                            <td>'+ j +'</td>';
                            html+='<td>'+managers[i].name+'</td>\
                            <td><a href="tel:'+managers[i].mobile_number+'" style="color:black;">'+managers[i].mobile_number+'</a>&nbsp;<a href="tel:'+managers[i].mobile_number+'"><button class="btn btn-primary btn-sm text-right"><i class="si si-phone text-white" aria-hidden="true"></i></button></a></td>\
                            <td>'+managers[i].no_of_person+'</td>\
                            <td>'+Todaywaitinglist.tConvert(managers[i].arrive_time)+'</td>\
                            <td>\
                                <button title="View" class="btn btn-info btn-sm view_cust" data-id="'+managers[i].id+'" data-date="'+managers[i].calendar_date+'"><i class="fas fa-eye" style="color:white"></i></button> ';
                                if (managers[i].is_assign == 0 && managers[i].is_decline == 0) 
                                                {
                                                    html +='<button title="Assign" class="btn btn-primary btn-sm assign_cust" data-id="'+managers[i].id+'" style="background-color:green;"><i class="fas fa-check-square" style="color:white"></i></button>\
                                                            <button title="Decline" class="btn btn-primary btn-sm decline_cust" data-id="'+managers[i].id+'" style="background-color:red;"><i class="fas fa-window-close" style="color:white"></i></button>';
                                                }

                                                if (managers[i].is_assign == 1 && managers[i].is_decline == 0) 
                                                {
                                                    html +='<button title="Assigned" class="btn btn-primary btn-sm" disabled style="background-color:green;"><i class="fas fa-check-square" style="color:white"></i></button>'
                                                }

                                                if (managers[i].is_assign == 0 && managers[i].is_decline == 1) 
                                                {
                                                    html +='<button title="Declined" class="btn btn-primary btn-sm" disabled style="background-color:#FF524D;"><i class="fas fa-window-close" style="color:white"></i></button>'
                                                }
                            html +='</td>\
                        </tr>';
                        j=j+1;
                }
                $('.tbody-group-list').html(html);
            }
        });
    },

    convertDateStringToDate(dateStr) {
        //  Convert a string like '2020-10-04T00:00:00' into '4/Oct/2020'
        let months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        let date = new Date(dateStr);
        let str = date.getDate()
        + ' ' + months[date.getMonth()]
        + ' ' + date.getFullYear()
        return str;
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
}

};