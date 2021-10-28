// Call this from the developer console and you can control both instances
var calendars = {};

(function($) {
    "use strict"; 
    init();
    function init(){
        setEventListener();
        initializeCalendar();
        //bind_events();
    }

    function setEventListener() {

        $('#form-add-event').on('submit',function(){
            if($('#name').val()==""){
               displaywarning("Name field is required");
               return false;
            }
            if($('#number').val()==""){
               displaywarning("Number field is required");
               return false;
            }
            if($('#no_of_person').val()==""){
               displaywarning("Number of person field is required");
               return false;
            }
            if($('#arrive_time').val()==""){
               displaywarning("Time field is required");
               return false;
            }
            $.ajax({
                url: base_url+"Waiting_manager/add_waiting_cust/",
                type:'POST',
                dataType: 'json',
                data: $(this).serialize(),
                success: function(response){
                    if(response.status){
                        window.location.href="";
                       /* var items=[];
                        for(var i in result['items']){
                            var data={
                                id:result['items'][i].id,
                                title:result['items'][i].name
                            }
                            items.push(data);
                        }*/
                       /* calendars.clndr1.addEvents([{
                            id:result.id,
                            date: $('#selected_calendar_date').val(),
                            title: result.name,
                            items:items
                        }]);*/
                        //initializeCalendar();
                        $('#modal-add-event1').modal('hide');
                        $('#select-menu-group').val('');
                    }else{
                            displaywarning("This record already Added for "+$('#selected-date-text').html() +" Time"+$('#arrive_time').val());
                    }
                }
            });
        });


        $('#show_table').on('click','.assign_cust',function(){
            var id = $(this).attr('data-id');
            var title='Are you sure ?';
        var text="You Want to assign this record";
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
                url:base_url+"Waiting_manager/assign_waiting_manager",
                type:'POST',
                data:formData ,
                success: function(result){
                   if (result.status) {
                        window.location.reload();
                        //$('#showsuccessalert').show();
                   }
                   else{
                    displaywarning("Something Went Wrong");
                    //('#showwarningalert').show();
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
        });


        $('#show_table').on('click','.decline_cust',function(){
            var id = $(this).attr('data-id');
            var title='Are you sure ?';
        var text="You Want to decline this record";
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
                url:base_url+"Waiting_manager/decline_waiting_manager",
                type:'POST',
                data:formData ,
                success: function(result){
                   if (result.status) {
                       window.location.reload();
                       //$('#showsuccessdeclinealert').show();
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
        });



    }

    function initializeCalendar(){
        var thisMonth = moment().format('YYYY-MM');
        $.ajax({
            url: base_url+"Waiting_manager/list_waiting_details/",
            type:'POST',
            dataType: 'json',
            data: $(this).serialize(),
            success: function(result){
                /*if(calendars.clndr1)
                    calendars.clndr1.render();*/
                calendars.clndr1 = $('.cal1').clndr({
                    events: result,
                    clickEvents: {
                        click: function (target) {
                            console.log('Cal-1 clicked: ', target);
                            $('#selected-value-text').html(target.date.format("MMMM Do YYYY"));
                        },
                        onAddDayEvent: function (target) {
                            var curr_date=moment().format("YYYY-MM-DD");
                            var selected_date=target.date.format("YYYY-MM-DD");
                            if(curr_date>selected_date){
                                displaywarning("Please select valid date");
                                return false;
                            }
                            $('#show_table').html('');
                            var j = 0;
                            var html = '';
                            for(var i=0;i<result.length;i++)
                            {
                                if(result[i].calendar_date == target.date.format("YYYY-MM-DD")){
                                    html = '<tr>\
                                                <td>'+result[i].name+'</td>\
                                                <td>'+result[i].mobile_number+'</td>\
                                                <td>'+result[i].no_of_person+'</td>\
                                                <td>'+result[i].arrive_time+'</td>\
                                                 <td>'; 
                                                if (result[i].is_assign == 0 && result[i].is_decline == 0) 
                                                {
                                                    html +='<button class="btn btn-primary btn-sm assign_cust" data-id="'+result[i].id+'" style="background-color:blue;">Assign</button> &nbsp;&nbsp;&nbsp;\
                                                            <button class="btn btn-primary btn-sm decline_cust" data-id="'+result[i].id+'" style="background-color:red;">Decline</button>';
                                                }

                                                if (result[i].is_assign == 1 && result[i].is_decline == 0) 
                                                {
                                                    html +='<button class="btn btn-primary btn-sm assign_cust" disabled style="background-color:#7685D1;">Assigned</button>'
                                                }

                                                if (result[i].is_assign == 0 && result[i].is_decline == 1) 
                                                {
                                                    html +='<button class="btn btn-primary btn-sm" disabled style="background-color:#FF524D;">Declined</button>'
                                                }

                                                 //if (result[i].is_assign == 0) { html +='<button class="btn btn-primary btn-sm assign_cust" data-id="'+result[i].id+'" style="background-color:blue;">Assign</button> &nbsp;&nbsp;&nbsp;';}
                                                // else { html +='<button class="btn btn-primary btn-sm assign_cust" disabled style="background-color:#7685D1;">Assigned</button> &nbsp;&nbsp;&nbsp;';}
                                                // if (result[i].is_decline == 0) { html += '<button class="btn btn-primary btn-sm decline_cust" data-id="'+result[i].id+'" style="background-color:red;">Decline</button>'; }
                                                // else { html += '<button class="btn btn-primary btn-sm" disabled style="background-color:#FF524D;">Declined</button>'; }
                                                    html +='</td></th>\
                                            </tr>';
                                     $('#show_table').append(html);
                                }
                            }
                            $('#modal-add-event1').modal('show');
                            $('#selected_calendar_date').val(target.date.format("YYYY-MM-DD"));
                            $('#selected-date-text').html(target.date.format("MMMM Do YYYY"));
                        },
                        today: function () {
                            console.log('Cal-1 today');
                        },
                        nextMonth: function () {
                            console.log('Cal-1 next month');
                        },
                        previousMonth: function () {
                            console.log('Cal-1 previous month');
                        },
                        onMonthChange: function () {
                            console.log('Cal-1 month changed');
                        },
                        nextYear: function () {
                            console.log('Cal-1 next year');
                        },
                        previousYear: function () {
                            console.log('Cal-1 previous year');
                        },
                        onYearChange: function () {
                            console.log('Cal-1 year changed');
                        },
                        nextInterval: function () {
                            console.log('Cal-1 next interval');
                        },
                        previousInterval: function () {
                            console.log('Cal-1 previous interval');
                        },
                        onIntervalChange: function () {
                            console.log('Cal-1 interval changed');
                        }
                    },
                    multiDayEvents: {
                        singleDay: 'date'
                    },
                    showAdjacentMonths: true,
                    adjacentDaysChangeMonth: false
                });
            }
        });
    }
    // The order of the click handlers is predictable. Direct click action
    // callbacks come first: click, nextMonth, previousMonth, nextYear,
    // previousYear, nextInterval, previousInterval, or today. Then
    // onMonthChange (if the month changed), inIntervalChange if the interval
    // has changed, and finally onYearChange (if the year changed).

    function displaysucess(msg)
    {
        swal("Success !",msg,"success");
    }

    function displaywarning(msg)
    {
        swal("Error !",msg,"error");
    }
})(jQuery);