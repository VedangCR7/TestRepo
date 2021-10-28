<?php
date_default_timezone_set($defaulttimezone);
require_once('header.php');
?>
<!-- Calendar Plugin -->
<link href="<?=base_url();?>assets/plugins/waitingcalendar/finalcalendar.css" rel="stylesheet" />
<link href="<?=base_url();?>assets/plugins/waitingcalendar/stylesheet.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/plugins/timepickerplugin/tpicker.css">
<?php
require_once('sidebar.php');

?>

<style type="text/css">
  @media screen and (max-width: 1385px) and (min-width: 769px) {
    .clockchoosebtn{
      padding: 0px;
      height:35px;
    }

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

<div class=" app-content">
  <div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-12 text-right">
    <button class="btn btn-primary btn-sm" title="Message Setting" data-toggle="modal" data-target="#messagemodel" style="background-color:green;margin-top:15px;" id="getmsgmodel"><i class="fas fa-cog"></i></button>
  </div>
</div>
  <div class="row" style="margin-top:10px;">
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

  <div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-12">
      <div class="row">
        <div class="col-lg-12 col-md-12col-sm-12 col-12">
          <span id="rest_waiting_cal"><input type="text" name="res_calendar_date" id="res_calendar_date" value="<?=date('Y-m-d')?>"></span>
          <select class="form-control" id="show_records_perticular_list">
            <option value="">Select Waitinglist manager</option>
            <option value="<?=$_SESSION['user_id']?>"><?=$_SESSION['business_name']?>(RESTAURANT)</option>
            <?php foreach ($waiting_manager as $key => $value) { ?>
              <option value="<?=$value['id']?>"><?=$value['name']?></option>
            <?php } ?>
          </select>
        </div>
      </div>
    </div>
  </div>

  <div class="row row-div-quantity addnewwaitinglist" style="display: none;">
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
                    <input type="text" name="name" id="name" onfocus="setTime()" class="form-control" placeholder="Enter Name" style="text-transform: capitalize;">
                  </div>
                  <div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:10px;">
                    <label style="font-weight:bold;">Mobile Number</label>
                    <input type="text" name="mobile_number" id="mobile_number" class="form-control contact" placeholder="Enter Mobile Number" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                  </div>
                  <div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:10px;">
                    <label style="font-weight:bold;">No. Of Person</label>
                    <input type="number" name="no_of_person" min="1" id="no_of_person" class="form-control" placeholder="Enter No. of persons">
                  </div>
                  <div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:10px;">
                    <label style="font-weight:bold;width:100%;float:left;">In Time</label>
                        <input onChange="hidetimebox()" id="timepkr" value="<?=date('h:i A');?>" style="width:80%;float:left;" class="form-control" placeholder="HH:MM" disabled oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
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
                  <!-- <div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:10px;">
                    <label style="font-weight:bold;">In Time</label>
                    <input type="time" name="arrive_time" id="arrive_time" class="form-control">
                  </div> -->
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

  <div class="row" style="margin-top:10px;">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="col-lg-9 col-md-9">
            <h4 class="font-weight-bold"><span class="selected-value-text"><?=date('d-M-Y')?></span></h4></div>
          <div class="col-lg-3 col-md-3 text-right">
          <button class="btn btn-primary" id="addwaitinglist"><i class="fas fa-plus"></i> Add</button></div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered card-table table-vcenter text-nowrap table-head" id="waitingdatatable">
              <thead>
                <tr>
                  <th id="widthname">Name</th>
                  <th id="widthmobile">Mobile Number</th>
                  <th id="widthperson">NOP</th>
                  <th id="intime">In Time</th>
                  <th id="intime">Estimated Time</th>
                  <th id="intime">Venues</th>
                  <th id="widthaction">Action</th>
                </tr>
              </thead>
              <tbody id="tbody-waiting-list">
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- The Modal -->
  <div class="modal fade" id="showwaitingdetails">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
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


  <!-- The Modal -->
<div class="modal" id="messagemodel">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Message Setting</h4>
        <button type="button" class="close" data-dismiss="modal" id="closemessagemodal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="row" id="showmessagefields">
          <div class="col-lg-6 col-md-6 col-sm-12 col-12">
            <label style="font-weight:bold;">Text Message</label>
            <span id="getid"><input type="hidden" id="message_id" name="id" value=""></span>
            <?php $messageplaceholder = 'Dear Customer
                      Thank you for visiting our restaurant. Please give us some time, we will assign the table for you and your waiting list number is {Waitinglis Number}' ?>
            <textarea name="text_message" id="text_message" placeholder="<?=$messageplaceholder?>" class="form-control" rows="6"></textarea>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12 col-12">
            <label style="font-weight:bold;">Whatsapp Message</label>
            <textarea name="whatsapp_message" id="whatsapp_message" placeholder="<?=$messageplaceholder?>" class="form-control" rows="6"></textarea>
          </div>
          <div class="col-lg-12 col-md-12 col-sm-12 col-12 text-center">
            <button class="btn btn-primary" id="savemessage" style="margin-top:25px;">Save</button>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<?php
require_once('footer.php');
?>
<!-- Default calendar -->
<script src="<?=base_url();?>assets/plugins/waitingcalendar/underscore-min.js"></script>
<script src="<?=base_url();?>assets/plugins/waitingcalendar/moment.js"></script>
<script src="<?=base_url();?>assets/plugins/waitingcalendar/finalcalendar.js"></script>
<!-- <script src="<?=base_url();?>assets/plugins/calendar/demo.js"></script> -->
<script src="<?=base_url();?>assets/plugins/jquery.rating/jquery.rating-stars.js"></script>
<script src='<?=base_url();?>assets/plugins/waitingcalendar/calendar.min.js'></script>

<script src="<?=base_url();?>assets/plugins/timepickerplugin/tpicker.js"></script>
<script type="text/javascript">
	
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
			if(t4<=9){
				var time = t3[0]+':0'+t4+' '+t2[1];
			}else{
				var time = t3[0]+':'+t4+' '+t2[1];
			}
		}
					
		$("#timepkr").val(time);			
	}
	
  function hidetimebox()
  {
    $("div.tpicker").hide();
  }

  $(document).ready( function () {
    /*$("body:not('.clockchoosebtn')").on('click',function() {
      if(showpicker){
        $('.tpicker').hide();
        showpicker=0;
      }
    })*/
    var passedDate = (new Date()).toISOString().split('T')[0];
    //alert(passedDate);
      $.ajax({
            url: base_url+"Waiting_manager/restaurant_waiting_list_details/",
            type:'POST',
            dataType: 'json',
            data: $(this).serialize(),
            success: function(result){
        $('#waitinglist_id').html('<input type="hidden" name="calendar_date" id="calendar_date"  value="'+passedDate+'">');
        $('#rest_waiting_cal').html('<input type="hidden" name="res_calendar_date" id="res_calendar_date"  value="'+passedDate+'">');
                            //$('#tbody-waiting-list').html('');
                            var j = 0;
                            var html = '';
                            $('#tbody-waiting-list').html('');
                              //$('#waitingdatatable').dataTable().fnClearTable();
                                //$('#waitingdatatable').dataTable().fnDestroy();
                            for(var i=0;i<result.length;i++)
                            {
                                if(result[i].calendar_date == passedDate){
                                    //alert(result[i].name);

                                    html = '<tr>\
                                                <td style="text-align:justify;">'+result[i].name+'</td>\
                                                <td><a href="tel:'+result[i].mobile_number+'" style="color:black;">'+result[i].mobile_number+'</a><a href="tel:'+result[i].mobile_number+'">&nbsp;<button class="btn btn-primary btn-sm text-right"><i class="si si-phone text-white" aria-hidden="true"></i></button></a></td>\
                                                <td>'+result[i].no_of_person+'</td>\
                                                <td>'+tConvert (result[i].arrive_time)+'</td>\
												<td>'+result[i].estimated_time+'</td>\
                                                <td>'+result[i].venues+'</td>\
                                                <td>';
                                                /* <button class="btn btn-info btn-sm view_cust" title="View" data-id="'+result[i].id+'" data-date="'+result[i].calendar_date+'"><i class="fas fa-eye" style="color:white"></i></button> ';  */
                                                if (result[i].is_assign == 0 && result[i].is_decline == 0) 
                                                {
                                                    html +='<button title="Assign" class="btn btn-primary btn-sm assign_cust" data-id="'+result[i].id+'" data-date="'+result[i].calendar_date+'"><i class="fas fa-check-square" style="color:white"></i></button> \
                                                            <button title="Decline" class="btn btn-primary btn-sm decline_cust" data-id="'+result[i].id+'" data-date="'+result[i].calendar_date+'" style="background-color:red;"><i class="fas fa-window-close" style="color:white"></i></button>';
                                                }

                                                if (result[i].is_assign == 1 && result[i].is_decline == 0) 
                                                {
                                                    html +='<button title="Assigned" class="btn btn-primary btn-sm assign_cust" disabled><i class="fas fa-check-square" style="color:white"></i></button>'
                                                }

                                                if (result[i].is_assign == 0 && result[i].is_decline == 1) 
                                                {
                                                    html +='<button title="Declined" class="btn btn-primary btn-sm" disabled style="background-color:red;"><i class="fas fa-window-close" style="color:white"></i></button>'
                                                }

                                                 //if (result[i].is_assign == 0) { html +='<button class="btn btn-primary btn-sm assign_cust" data-id="'+result[i].id+'" style="background-color:blue;">Assign</button> &nbsp;&nbsp;&nbsp;';}
                                                // else { html +='<button class="btn btn-primary btn-sm assign_cust" disabled style="background-color:#7685D1;">Assigned</button> &nbsp;&nbsp;&nbsp;';}
                                                // if (result[i].is_decline == 0) { html += '<button class="btn btn-primary btn-sm decline_cust" data-id="'+result[i].id+'" style="background-color:red;">Decline</button>'; }
                                                // else { html += '<button class="btn btn-primary btn-sm" disabled style="background-color:#FF524D;">Declined</button>'; }
                                                    html +='</td></th>\
                                            </tr>';
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
$(document).ready(function(){
//  var d = new Date();
// var n = d.getTime();
// alert(n);
  $("#addwaitinglist").click(function(){
    $(".addnewwaitinglist").show();
    $("#addwaitinglist").hide();
    $(".addnewwaitinglist").fadeIn("slow");
    $(".addnewwaitinglist").fadeIn("slow");
  });

  $("#closetoggle").click(function(){
    $(".addnewwaitinglist").hide();
    $("#addwaitinglist").show();
    $('#name').val('');
    $('#mobile_number').val('');
    $('#no_of_person').val('');
  });
});
</script>
<!--  -->
<script type="text/javascript">
  var base_url="<?=base_url();?>";
</script>
<script src='<?=base_url();?>assets/js/custom/restaurantwaitinglist.js?v=<?php echo uniqid();?>'></script>
<script type="text/javascript">
  function convertDateStringToDate(dateStr) {
        //  Convert a string like '2020-10-04T00:00:00' into '4/Oct/2020'
        let months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        let date = new Date(dateStr);
        let str = date.getDate()
        + ' ' + months[date.getMonth()]
        + ' ' + date.getFullYear()
        return str;
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
</script>

<script>
  $('.contact').on('keypress',function(e){
            var regex = new RegExp("^[0-9]+$");
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
            if (regex.test(str)) {
                return true;
            }
            e.preventDefault();
            return false;
        });
</script>
<script type="text/javascript">
  $('#showaddmessage').click(function(){
    $('#addmessagetab').show();
    //$('#showaddmessage').hide();
  });
  $('#cancelmessage').click(function(){
    //$('#showaddmessage').show();
    $('#addmessagetab').hide();
  });
</script>
<script type="text/javascript">
  $('#closemessagemodal').click(function(){
    $('#text_message').val('');
    $('#whatsapp_message').val('');
  });
</script>
<script>
	setInterval(function() {
                $.ajax({
                    url: "<?=base_url();?>restaurant/set_authority_exist",
                    type:'POST',
                    dataType: 'json',
                    data: {name:'Waitinglist'},
                    success: function(result){
                        if(result.status){
                            window.location.href="<?=base_url();?>restaurant/dashboard";
                        }
                   	}
                });
            },5000);
</script>

<script>
$('#name').keydown(function (e) {
  
  if (e.shiftKey || e.ctrlKey || e.altKey) {
  
    e.preventDefault();
    
  } else {
  
    var key = e.keyCode;
    
    if (!((key == 8) || (key == 32) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
    
      e.preventDefault();
      
    }

  }
  
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