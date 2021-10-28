<?php
require_once('Restaurantmanager/header.php');
//require_once('Restaurantmanager/web_header.php');
require_once('Restaurantmanager/sidebar.php');
?>
<style type="text/css">
	@media screen and (max-width: 1385px) and (min-width: 769px) 
	{
		.clockchoosebtn
		{
			padding: 0px;
			height:35px;
		}
	}
</style>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<style type="text/css">
	body
	{
		background-color: #F3F3F3;
		position:relative;
	}
	
	li
	{
		list-style-type:none;
	}
	
	.menuname
	{
		font-size:12px;
	}

	.sidenav 
	{
		height: 100%;
		width: 0;
		position: fixed;
		z-index: 999999999999999999;
		top: 0;
		left: 0;
		background-color:white;
		overflow-x: hidden;
		transition: 0.5s;
		padding-top: 60px;
	}

	.sidenav a 
	{
		padding: 8px 8px 8px 32px;
		text-decoration: none;
		font-size: 18px;
		color:black;
		display: block;
		transition: 0.3s;
	}

	.sidenav a:hover 
	{
		color: #f1f1f1;
	}

	.sidenav .closebtn 
	{
		position: absolute;
		top: 0;
		right: 25px;
		font-size: 36px;
		margin-left: 50px;
	}

	.resto-name {font-size:25px;}
	@media screen and (max-height: 450px) 
	{
		.sidenav {padding-top: 15px;}
		.sidenav a {font-size: 18px;}
	}
	
	@media screen and (max-width: 450px) 
	{
		.resto-name {font-size:17px;}
	}
	
	.ms-choice
	{
		width: 100!important;
		margin-left: 0px;
		margin-top: 0px;
	}
	
	@media screen and (max-width: 375px) 
	{
		.ms-choice
		{
			width: 100%!important;
			margin-left: 0px;
			margin-top: 0px;
		}
	}
	
	@media screen and (max-width: 320px) 
	{
		.ms-choice
		{
			width: 100%!important;
			margin-left: 0px;
			margin-top: 0px;
		}
	}
	
	@media screen and (max-width: 425px) 
	{
		.ms-choice
		{
			width: 100%!important;
			margin-left: 0px;
			margin-top: 0px;
		}
	}
	
	.ms-choice>span
	{
		overflow: inherit!important;
	}
</style>
<!-- Sidebar -->
<!-- <div class="w3-sidebar w3-bar-block" style="display:none;z-index:9999999" id="mySidebar">
  <button onclick="w3_close()" class="w3-bar-item w3-button w3-large" style="text-align:right;"><span style="background-color:red;color:white;padding:5px;">&times;</span></button>
  <a href="#" class="w3-bar-item w3-button">Take Order</a>
  <a href="#" class="w3-bar-item w3-button">New Order</a>
  <a href="#" class="w3-bar-item w3-button">Order History</a>
</div> -->
<div class="menu-navigation" style="background: linear-gradient( 89.1deg,rgb(8,158,96) 0.7%,rgb(19,150,204) 88.4% );">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 mb-2">
                <div class="row">
                    <div class="col-1 p-1 text-center" style="margin-top:10px;"><span style="font-size:25px;cursor:pointer;color:white;" onclick="openNav()">&#9776;</span>
                    </div>
                    <div class="col-9 pl-4">
						<h2 class="resto-name ml-2 text-white" style="margin-top:20px;"><b>Waitinglist Dashboard</b></h2>
                    </div>
                    <div class="col-1">
						<div class="google_lang_menu menu_details_translate">
							<div id="google_translate_element"></div>
						</div>
					</div>
                    <!-- <div class="col-2 p-1">
                      <?php if ($profile[0]['profile_photo'] != 'assets/images/users/user.png' && $profile[0]['profile_photo'] != null) {?>
                        <img src="<?=$profile[0]['profile_photo']?>" class="shadow-sm" style="height:50px;width:50px;border-radius:50%">
                      <?php } else{?>
                        <img src="<?=base_url();?>assets/images/users/user.png" class="shadow-sm" style="height:50px;width:50px;border-radius:50%"><?php } ?>
                    </div> -->
                </div>
               <!--  <div class="text-white">
                   <div class="title d-flex align-items-center">
                     
                   </div>
                </div> -->
             </div>
        </div>
    </div>
</div>
<!-- Calendar Plugin -->
<link href="<?=base_url();?>assets/plugins/waitingcalendar/finalcalendar.css" rel="stylesheet" />
<link href="<?=base_url();?>assets/plugins/waitingcalendar/stylesheet.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/plugins/timepickerplugin/tpicker.css">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-12">
			<div class="card">
				<div class="card-body">
					<div class="col-md-12">
						<div class="cal1"></div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row row-div-quantity addnewwaitinglist" style="display: none; height: max-content; margin-bottom: 50px;">
		<div class="col-md-12">
			<div class="card welcome-image">
				<div class="card-body">
					<div class="row">
						<div class="col-md-11">
							<form class="form-recipe-edit" method="post" action="javascript:;" id="waitinglistform">
								<div class="row">
									<div class="col-md-12 col-lg-12 col-sm-12 col-12 selected-value-text" style="font-weight:bold;font-size:20px;text-align:center;">
										<?=date('d-M-Y')?>
									</div>
									<div class="col-lg-12 col-md-12 col-sm-12 col-12" style="margin-top:10px;" id="waitinglist_id"><input type="hidden" name="calendar_date" id="calendar_date" value="<?=date('Y-m-d')?>"></div>
									<div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:10px;">
										<label style="font-weight:bold;">Name</label>
										<input type="text" name="name" id="name" class="form-control" placeholder="Enter Name" onfocus="setTime()" onChange="chkNameVal()" style="text-transform: capitalize;">
									</div>
									<div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:10px;">
										<label style="font-weight:bold;">Mobile Number</label>
										<input type="text" name="mobile_number" id="mobile_number" minlength="8" maxlength="14" class="form-control contact" placeholder="Enter Mobile Number" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
									</div>
									<div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:10px;">
										<label style="font-weight:bold;">No. Of Person</label>
										<input type="number" name="no_of_person" value="1" min="1" id="no_of_person" class="form-control" placeholder="Enter No. of persons">
									</div>
									<!--<div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:10px;">
										<label style="font-weight:bold;">In Time</label>
										<input type="time" name="arrive_time" id="arrive_time" value="<?=date('h:i');?>" class="form-control">
									</div>-->
									<div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:10px;">
									<label style="font-weight:bold;width:100%;float:left;">In Time</label>
										<input onChange="hidetimebox()" name="timepkr" id="timepkr" value="<?=date('h:i A');?>" style="width:80%;float:left;" class="form-control" placeholder="HH:MM" disabled oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
										<button type="button" class="btn btn-primary clockchoosebtn" onclick="showpickers('timepkr',12,<?=date('h');?>,<?=date('i');?>,'<?=date('A');?>')" style="width:20%;float:left;"><i class="far fa-clock"></i></button>
									</div>
									<div class="timepicker" style="z-index:999999999"></div>
									<div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:10px;">
										<label style="font-weight:bold;">Estimated Time</label>
										<select name="estimated_time" id="estimated_time" class="form-control">
											<option value="">Select Estimated Time</option>
											<option value="15 minute">15 min</option>
											<option value="20 minute">20 min</option>
											<option value="30 minute">30 min</option>
											<option value="45 minute">45 min</option>
											<option value="60 minute">60 min</option>
										</select>
									</div>
									<div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:10px;">
										<label style="font-weight:bold;">Venues</label>
										<select multiple="multiple" name="venues[]" id="venues" class="hide-select multi-select">
											<option value="Terrace">Terrace</option>
											<option value="PDR 1">PDR 1</option>
											<option value="PDR 2">PDR 2</option>
											<option value="PDR 3">PDR 3</option>
											<option value="A section">A section</option>
											<option value="B section">B section</option>
											<option value="C section">C section</option>
											<option value="D section">D section</option>
										</select>
									</div>
								</div>
								<div class="row"> 
									<div class="col-md-12 text-right">
										<button type="button" class="btn btn-default" id="closetoggle" style="background-color: #ede3e7;;border: 0px !important;float:right;margin-left:10px;margin-top: 1rem;">Cancel</button>
										<button type="submit" class="btn btn-secondary btn-save-details btn-add-group" type="button" style="background-color: #ED3573;border: 0px !important;float:right;margin-top:10px;margin-top: 1rem;">Save</button>
									</div>
								</div>								
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>

	<div class="row">
		<div class="col-md-12" style="min-height:220px">
			<div class="card">
				<div class="card-header">
					<div class="col-lg-9 col-md-9">
						<h4 class="font-weight-bold"><span class="selected-value-text"><?=date('d-M-Y')?></span></h4>
					</div>
					<div class="col-lg-3 col-md-3 text-right">
						<button class="btn btn-primary" id="addwaitinglist"><i class="fas fa-plus"></i> Add</button>
					</div>
				</div>
				<div class="card-body">
					<div class="col-lg-12 col-md-12 col-sm-12 col-12">
						<div class="row" id="tbody-waiting-list"></div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- The Modal -->
	<div class="modal fade" id="showwaitingdetails">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- Modal Header xyz-->
				<div class="modal-header">
					<h4 class="modal-title">Details for <span id="showname"></span></h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<!-- Modal body -->
				<div class="modal-body detailwaitingcust">
				</div>
			</div>
		</div>
	</div>
	<?php
	require_once('Restaurantmanager/footer.php');
	/* require_once('Restaurantmanager/web_footer.php'); */
	?>
	<!-- Default calendar -->
	<script src="<?=base_url();?>assets/plugins/waitingcalendar/underscore-min.js"></script>
	<script src="<?=base_url();?>assets/plugins/waitingcalendar/moment.js"></script>
	<script src="<?=base_url();?>assets/plugins/waitingcalendar/finalcalendar.js"></script>
	<!-- <script src="<?=base_url();?>assets/plugins/calendar/demo.js"></script> -->
	<script src="<?=base_url();?>assets/plugins/jquery.rating/jquery.rating-stars.js"></script>
	<script src='<?=base_url();?>assets/plugins/waitingcalendar/calendar.min.js'></script>

	<script src="<?=base_url();?>assets/plugins/timepickerplugin/tpicker.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	
	<script>
		function chkNameVal()
		{
			var nm = document.getElementById('name').value;
						
			if(nm != '')
			{
				if(nm.length < 2 || nm.length > 30)
				{
					swal("Error!","Customer name should be 2 to 30 characters", "error");
					/*alert('Customer name should be 2 to 30 characters');*/
					$('#name').val('');
					return false;
				}
				else if(!nm.match(/^[a-zA-Z]+(\s{0,1}[a-zA-Z])*$/))
				{
					swal("Error!","Please enter proper name", "error");
					/*alert('Please enter proper name');*/
					$('#name').val('');
					return false;
				}
			}
		}
		
		function setTime()
		{
			var date = new Date();
			var hours = date.getHours();
			var minutes = date.getMinutes();
			
			var newformat = hours >= 12 ? 'PM' : 'AM'; 
			
			hours = hours % 12; 
			
			hours = hours ? hours : 12; 
			minutes = minutes < 10 ? '0' + minutes : minutes;
			
			var t1 = hours + ':' + minutes + ' ' + newformat;

			/* var t1 = $("#timepkr").val(); */
			/* var t1 = '07:58 PM'; */
			var t2 = t1.split(" ");
			var t3 = t2[0].split(":");
			var t4 = parseInt(t3[1]) + 2;
			
			if(parseInt(t3[1])>57 && parseInt(t3[1])<59)
			{
				var minutes = parseInt(t3[0])+1;
				var second = parseInt(00);
				var time = minutes+':00 '+t2[1];
			}
			else
			{				
				var time = t3[0]+':'+t4+' '+t2[1];
			}
						
			$("#timepkr").val(time);			
		}
	</script>
	<script type="text/javascript">
		function hidetimebox()
		{
			$("div.tpicker").hide();
		}
  
		$(document).ready( function () 
		{
			var passedDate = (new Date()).toISOString().split('T')[0];
			//alert(passedDate);
			$.ajax({
				url: base_url+"Waiting_manager/list_waiting_details/",
				type:'POST',
				dataType: 'json',
				data: $(this).serialize(),
				success: function(result)
				{
					$('#waitinglist_id').html('<input type="hidden" name="calendar_date" id="calendar_date"  value="'+passedDate+'">')
					//$('#tbody-waiting-list').html('');
					var j = 0;
					var html = '';
					$('#tbody-waiting-list').html('');
					//$('#waitingdatatable').dataTable().fnClearTable();
					//$('#waitingdatatable').dataTable().fnDestroy();
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
										<a href="tel:'+result[i].mobile_number+'"><button style="margin-right: 3px;" class="btn btn-warning btn-sm text-right"><i class="si si-phone text-white" aria-hidden="true"></i></button></a>';
										/* html +='<button class="btn btn-info btn-sm view_cust" title="View" data-id="'+result[i].id+'" data-date="'+result[i].calendar_date+'"><i class="fas fa-eye" style="color:white"></i></button> '; */
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
					var getwaitingdt = convertDateStringToDate(passedDate);

					$('.selected-value-text').html(getwaitingdt);
					$('.calendar-day-'.passedDate).css("background-color","yellow");
					//$('#waitingdatatable').DataTable();
				}
		   });
		} );
	</script>
	<script>
		$(document).ready(function()
		{
			//  var d = new Date();
			// var n = d.getTime();
			// alert(n);
			$("#addwaitinglist").click(function(){
				$(".addnewwaitinglist").show();
				$("#addwaitinglist").hide();
				$(".addnewwaitinglist").fadeIn("slow");
			});

			$("#closetoggle").click(function(){
				$("#addwaitinglist").show();
				$(".addnewwaitinglist").hide();
			});
		});
	</script>
	<!--  -->
	<script type="text/javascript">
		var base_url="<?=base_url();?>";
	</script>
	<script src='<?=base_url();?>assets/js/custom/finalwaitinglistcalendar.js?v=<?php echo uniqid();?>'></script>
	<script type="text/javascript">
		function convertDateStringToDate(dateStr)
		{
			//  Convert a string like '2020-10-04T00:00:00' into '4/Oct/2020'
			let months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
			let date = new Date(dateStr);
			let str = date.getDate()
			+ ' ' + months[date.getMonth()]
			+ ' ' + date.getFullYear()
			return str;
		}

		function tConvert (time) 
		{
			// Check correct time format and split into components
			time = time.toString ().match (/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];

			if (time.length > 1) 
			{ // If time format correct
				time = time.slice (1);  // Remove full string match value
				time[5] = +time[0] < 12 ? 'AM' : 'PM'; // Set AM/PM
				time[0] = +time[0] % 12 || 12; // Adjust hours
			}
			return time.join (''); // return adjusted time or original string
		}
	</script>
	<script>
		$('.contact').on('keypress',function(e)
		{
            var regex = new RegExp("^[0-9]+$");
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
            
			if (regex.test(str)) 
			{
                return true;
            }
            e.preventDefault();
            return false;
        });
	</script>	
	<script type="text/javascript">		
		$(document).ready(function()
		{
			$(".placeholder").text("Your text here");
			$('.multi-select').multipleSelect({		
				/* nonSelectedText: 'Select Teams' */
				placeholder: "Select Venues",
				selectAll: false
			});
		});
		/* $('.multi-select').multipleSelect({
            selectAll: false
        }); */
	</script>