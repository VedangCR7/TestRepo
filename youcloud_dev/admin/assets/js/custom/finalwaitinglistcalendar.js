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

    function setEventListener() 
	{
        $('.btn-add-group').click(function()
		{
			debugger;
			var time = $("#timepkr").val();
			var hours = Number(time.match(/^(\d+)/)[1]);
			var minutes = Number(time.match(/:(\d+)/)[1]);
			var AMPM = time.match(/\s(.*)$/)[1];
			if(AMPM == "PM" && hours<12) hours = hours+12;
			if(AMPM == "AM" && hours==12) hours = hours-12;
			var sHours = hours.toString();
			var sMinutes = minutes.toString();
			if(hours<10) sHours = "0" + sHours;
			if(minutes<10) sMinutes = "0" + sMinutes;
			var timepkr = sHours + ":" + sMinutes;
			//alert(timepkr);
			var today = new Date();
			var dd = String(today.getDate()).padStart(2, '0');
			var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
			var yyyy = today.getFullYear();
			today = yyyy + '-' + mm + '-' + dd;
			var hour = new Date().getHours();
			var minuites = new Date().getMinutes();
			/* var string = $('#arrive_time').val(); */
			var string = timepkr;
			var timearray= string.split(":");
			var estimated_time = $("#estimated_time").val();
			var venues = $("#venues").val();
			//console.log(timearray);
            
			if($('#name').val()!="" && $('#mobile_number').val()!="" && $('#no_of_person').val()!="" && $('#timepkr').val()!="")
			{
                if(today == $('#calendar_date').val())
				{
					if ((hour < timearray[0]) || (hour == timearray[0] && minuites <= timearray[1])) 
					{
						if ($('#mobile_number').val().length < 8 || $('#mobile_number').val().length > 14) 
						{
							displaywarning("Mobile Number should be 8 to 14 digit"); 
						}
						else
						{
							if ($('#name').val().length < 2 || $('#name').val().length > 50) 
							{ 
								displaywarning("Name field should accept 2 to 50 characters."); 
							}
							else
							{
								$('#image-loader').show();
								$.ajax({
									url: base_url+"Waiting_manager/add_waiting_cust",
									type:'POST',
									dataType: 'json',
									data: {
										name : $('#name').val(),
										mobile_number :$('#mobile_number').val(),
										no_of_person :$('#no_of_person').val(),
										arrive_time :$('#timepkr').val(),
										calendar_date : $('#calendar_date').val(),
										estimated_time : $('#estimated_time').val(),
										venues : $('#venues').val().join(),
									},
									success: function(result)
									{
										$('#image-loader').hide();
										
										if (result.status) 
										{
											if(result.is_exist)
											{
												displaywarning("This date and time already exist.");
												displayTable($('#calendar_date').val());
											}
											else
											{
												displaysucess("Customer added successfully");
												displayTable($('#calendar_date').val());
												//Todaywaitinglist.listmanager(data);
											}
											
											var date = new Date();
											var hours = date.getHours() > 12 ? date.getHours() - 12 : date.getHours();
											var am_pm = date.getHours() >= 12 ? "PM" : "AM";
											hours = hours < 10 ? "0" + hours : hours;
											var minutes = date.getMinutes() < 10 ? "0" + date.getMinutes() : date.getMinutes();
											var seconds = date.getSeconds() < 10 ? "0" + date.getSeconds() : date.getSeconds();
											time = hours + ":" + minutes + " " + am_pm;
											$('#name').val('');
											$('#mobile_number').val('');
											$('#no_of_person').val('');
											$('#timepkr').val(time);
											$('#estimated_time').val('');
											/* $('#venues').removeAttr('unchecked'); */
											$('.btn-add-group').html('Save');
											location.reload();											
										}
										else
										{
											displaywarning(result.msg);
										}
									}
								});
							}
						}
					}	
					else
					{
						displaywarning("Please select valid time");
					}
				}
				else
				{
					//alert("not date");
					if ($('#name').val().length < 2 || $('#name').val().length > 50) 
					{ 
						displaywarning("Name field should accept 2 to 50 characters."); 
					}
					else
					{
						if ($('#mobile_number').val().length < 8 || $('#mobile_number').val().length > 14)
						{ 
							displaywarning("Mobile Number should be 8 to 14 digit"); 
						}
                        else
						{
                            $('#image-loader').show();
							 
                            $.ajax({
								url: base_url+"Waiting_manager/add_waiting_cust",
								type:'POST',
								dataType: 'json',
								data: {
									name : $('#name').val(),
									mobile_number :$('#mobile_number').val(),
									no_of_person :$('#no_of_person').val(),
									arrive_time :timepkr,
									calendar_date : $('#calendar_date').val(),
									estimated_time : $('#estimated_time').val(),
									venues : $('#venues').val().join(),
								},
								success: function(result)
								{
									$('#image-loader').hide();
									if (result.status) 
									{
										if(result.is_exist)
										{
											displaywarning("This date and time already exist.");
											displayTable($('#calendar_date').val());

										}
										else
										{
											displaysucess("Customer added successfully");
											displayTable($('#calendar_date').val());
											//Todaywaitinglist.listmanager(data);
										}
									
										var date = new Date();
										var hours = date.getHours() > 12 ? date.getHours() - 12 : date.getHours();
										var am_pm = date.getHours() >= 12 ? "PM" : "AM";
										hours = hours < 10 ? "0" + hours : hours;
										var minutes = date.getMinutes() < 10 ? "0" + date.getMinutes() : date.getMinutes();
										var seconds = date.getSeconds() < 10 ? "0" + date.getSeconds() : date.getSeconds();
										time = hours + ":" + minutes + " " + am_pm;
										$('#name').val('');
										$('#mobile_number').val('');
										$('#no_of_person').val('');
										$('#timepkr').val(time);
										$('#estimated_time').val('');
										/* $('#venues').removeAttr('unchecked'); */
										$('.btn-add-group').html('Save');
										location.reload();
									}
									else
									{
										displaywarning(result.msg);
									}
								}
							});
						}
					}
				}
			}
			else
			{
				displaywarning("Please Fill all the fields");
			}
        });

        $('#tbody-waiting-list').on('click','.view_cust',function(){
            var id = $(this).attr('data-id');
            var date = $(this).attr('data-date');
            var formData={
                id : id
            } 
            $.ajax({
                url:base_url+"Waiting_manager/show_perticular_waitinglist_cust",
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
                    <p>'+tConvert (result.arrive_time)+'</p>\
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
                    <p>'+convertDateStringToDate(result.calendar_date)+'</p>\
                    </div>\
                </div>\
            </div>')
                       $('#showwaitingdetails').modal('show');
                       displayTable(date);
                   }
                   else{
                    displaywarning("Something Went Wrong");
                   }
                }
            });
        });

        $('#tbody-waiting-list').on('click','.assign_cust',function()
		{
			debugger;
            var id = $(this).attr('data-id');
            var date = $(this).attr('data-date');
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
			})
			.then((willDelete) => 
			{
				if (willDelete) 
				{
					var formData={
						id : id
					} 
					$.ajax({
						url:base_url+"Waiting_manager/assign_waiting_manager",
						type:'POST',
						data:formData ,
						success: function(result){
						   if (result.status) {
								displaysucess("Assigned");
								displayTable(date);
								//$('#showsuccessalert').show();
						   }
						   else{
							displaywarning("Something Went Wrong");
							//('#showwarningalert').show();
						   }
						}
					});
				} 
				else 
				{
					swal(
					  'Cancelled',
					  'Your record is safe :)',
					  'error'
					)
				}
			});
			/* ,
			function () 
			{
				var formData={
					id : id
				} 
				$.ajax({
					url:base_url+"Waiting_manager/assign_waiting_manager",
					type:'POST',
					data:formData ,
					success: function(result){
					   if (result.status) {
							displaysucess("Assigned");
							displayTable(date);
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
			}); */
        });


        $('#tbody-waiting-list').on('click','.decline_cust',function()
		{
			debugger;
            var id = $(this).attr('data-id');
            var date = $(this).attr('data-date');
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
			})
			.then((willDelete) => 
			{
				if (willDelete) 
				{
					var formData={
						id : id
					} 
					$.ajax({
						url:base_url+"Waiting_manager/decline_waiting_manager",
						type:'POST',
						data:formData ,
						success: function(result){
						   if (result.status) {
							   //window.location.reload();
							   displaysucess("Declined");
							   displayTable(date);
							   //$('#showsuccessdeclinealert').show();
						   }
						   else{
							displaywarning("Something Went Wrong");
						   }
						}
					});
				} 
				else 
				{
					swal(
					  'Cancelled',
					  'Your record is safe :)',
					  'error'
					)
				}
			});
			/* ,function () 
			{
				var formData={
					id : id
				} 
				$.ajax({
					url:base_url+"Waiting_manager/decline_waiting_manager",
					type:'POST',
					data:formData ,
					success: function(result){
					   if (result.status) {
						   //window.location.reload();
						   displaysucess("Declined");
						   displayTable(date);
						   //$('#showsuccessdeclinealert').show();
					   }
					   else{
						displaywarning("Something Went Wrong");
					   }
					}
				});
			}, 
			function (dismiss) 
			{
				if (dismiss === 'cancel') 
				{
					swal(
					  'Cancelled',
					  'Your record is safe :)',
					  'error'
					)
				}
			}); */
        });
    }

    function initializeCalendar()
	{
		debugger;
        var thisMonth = moment().format('YYYY-MM');
       
		/*if(calendars.clndr1)
		calendars.clndr1.render();*/
	
		calendars.clndr1 = $('.cal1').clndr({
			clickEvents: 
			{
				click: function (target) 
				{
					debugger;
					console.log('Cal-1 clicked: ', target);
					  
					$('.day').css("background-color","");
					$(target.element).removeClass( "past" );
					$(target.element).css("background-color","#00884B");
					$('#selected-value-text').html(target.date.format("MMMM Do YYYY"));
				},
				onAddDayEvent: function (target) 
				{
					debugger;
					var curr_date=moment().format("YYYY-MM-DD");
					var selected_date=target.date.format("YYYY-MM-DD");
					
					if(curr_date>selected_date)
					{
						/* displaywarning("Please select valid date");
						return false; */
						$('.card-header').hide();
						$(".addnewwaitinglist").hide();
					}
					else
					{
						$('.card-header').show();
						$('#addwaitinglist').show();
						$(".addnewwaitinglist").hide();
					}
					displayTable(target.date.format("YYYY-MM-DD"));
					/* alert(target.date.format("YYYY-MM-DD")); */
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
			multiDayEvents: 
			{
				singleDay: 'date'
			},
			showAdjacentMonths: true,
			adjacentDaysChangeMonth: false
		});            
    }
    // The order of the click handlers is predictable. Direct click action
    // callbacks come first: click, nextMonth, previousMonth, nextYear,
    // previousYear, nextInterval, previousInterval, or today. Then
    // onMonthChange (if the month changed), inIntervalChange if the interval
    // has changed, and finally onYearChange (if the year changed).
    function displayTable(passedDate)
    {
		debugger;
		$('#image-loader').show();
		$.ajax({
            url: base_url+"Waiting_manager/list_waiting_details/",
            type:'POST',
            dataType: 'json',
            data: $(this).serialize(),
            success: function(result)
			{
				$('#waitinglist_id').html('<input type="hidden" name="calendar_date" id="calendar_date"  value="'+passedDate+'">')
				$('#tbody-waiting-list').html('');
				var j = 0;
				var html = '';
				
				//$('#waitingdatatable').dataTable().fnClearTable();
				//$('#waitingdatatable').dataTable().fnDestroy();
				// $('#tbody-waiting-list').html('');
				
				for(var i=0;i<result.length;i++)
				{
                    if(result[i].calendar_date == passedDate)
					{
						//alert(result[i].name);
						html = '<div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;">\
							<div class="row" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);padding:2px;">\
								<div class="col-lg-6 col-md-6 col-sm-6 col-6">\
									<span style="font-size:15px;">Name</span><br>\
									<span style="color:black;font-size:15px;">'+result[i].name+'</span>\
								</div>\
								<div class="col-lg-6 col-md-6 col-sm-6 col-6">\
									<span style="font-size:15px;">Mobile No</span><br>\
									<span style="color:black;font-size:15px;margin-top:-10px;">'+result[i].mobile_number+'</span>\
								</div>\
								<div class="col-lg-6 col-md-6 col-sm-6 col-6" style="margin-top:10px">\
									<span style="font-size:15px;">NOP : </span>\
									<span style="color:black;font-size:15px;">'+result[i].no_of_person+'</span>\
								</div>\
								<div class="col-lg-6 col-md-6 col-sm-6 col-6" style="margin-top:10px">\
									<span style="font-size:15px;">In time :</span>\
									<span style="color:black;font-size:15px;">'+tConvert(result[i].arrive_time)+'</span>\
								</div>\
								<div class="col-lg-6 col-md-6 col-sm-6 col-6" style="margin-top:10px">\
									<span style="font-size:15px;">Estimated Time :</span>\
									<span style="color:black;font-size:15px;">'+result[i].estimated_time+'</span>\
								</div>\
								<div class="col-lg-6 col-md-6 col-sm-6 col-6" style="margin-top:10px">\
									<span style="font-size:15px;">Venues :</span>\
									<span style="color:black;font-size:15px;">'+result[i].venues+'</span>\
								</div>\
								<div class="col-lg-12 col-md-12 col-sm-12 col-12" style="margin-top:-20px"><hr></div>\
								<div class="col-lg-8 col-md-8 col-sm-8 col-8" style="margin-top:-25px;">\
							</div>\
							<div class="col-lg-12 col-md-12 col-sm-12 col-12 text-right" style="margin-top:-25px;">\
								<a href="tel:'+result[i].mobile_number+'"><button style="    margin-right: 3px; "class="btn btn-warning btn-sm text-right"><i class="si si-phone text-white" aria-hidden="true"></i></button></a>';
								/* html +='<button class="btn btn-info btn-sm view_cust" title="View" data-id="'+result[i].id+'" data-date="'+result[i].calendar_date+'"><i class="fas fa-eye" style="color:white"></i></button>'; */
								  if (result[i].is_assign == 0 && result[i].is_decline == 0){
								  html +='<button title="Assign" class="btn btn-primary btn-sm assign_cust" data-id="'+result[i].id+'" data-date="'+result[i].calendar_date+'"><i class="fas fa-check-square" style="color:white"></i></button> \
									<button title="Decline" class="btn btn-primary btn-sm decline_cust" data-id="'+result[i].id+'" data-date="'+result[i].calendar_date+'" style="background-color:red;"><i class="fas fa-window-close" style="color:white"></i></button>'; }

								  if (result[i].is_assign == 1 && result[i].is_decline == 0) {
								  html +='<button title="Assigned" class="btn btn-primary btn-sm assign_cust" disabled><i class="fas fa-check-square" style="color:white"></i></button>'}

								  if (result[i].is_assign == 0 && result[i].is_decline == 1) {
								  html +='<button title="Declined" class="btn btn-primary btn-sm" disabled style="background-color:red;"><i class="fas fa-window-close" style="color:white"></i></button>'}
							  html +='</div>\
							</div>\
						</div>';
						 $('#tbody-waiting-list').append(html);                                        
					}
				}
				
				var curr_date=moment().format("YYYY-MM-DD");
				
				if(curr_date>passedDate)
				{
					$('.text-right').hide();
					$('#addwaitinglist').show();
				}
				else
				{
					$('.text-right').show();
				}
				$('#image-loader').hide();
				var getwaitingdt = convertDateStringToDate(passedDate);
				$('.selected-value-text').html(getwaitingdt);
		   }
	   });
    }

    function convertDateStringToDate(dateStr) {
        //  Convert a string like '2020-10-04T00:00:00' into '4/Oct/2020'
        let months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        let date = new Date(dateStr);
        let str = date.getDate()
        + ' ' + months[date.getMonth()]
        + ' ' + date.getFullYear()
        return str;
    }
    function displaysucess(msg)
    {
        swal("Success !",msg,"success");
    }

    function displaywarning(msg)
    {
        swal("Error !",msg,"error");
    }

    function tConvert (time) {
  // Check correct time format and split into components
  time = time.toString ().match (/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];

  if (time.length > 1) { // If time format correct
    time = time.slice (1);  // Remove full string match value
    time[5] = +time[0] < 12 ? 'AM' : 'PM'; // Set AM/PM
    time[0] = +time[0] % 12 || 12; // Adjust hours
  }
  return time.join (''); // return adjusted time or original string
}

    
})(jQuery);