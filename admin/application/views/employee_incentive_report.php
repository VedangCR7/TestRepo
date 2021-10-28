<?php
require_once('header.php');
require_once('sidebar.php');

?>
<div class=" app-content">
	<div class="side-app">

		<!--Page Header-->
		<div class="page-header">	
		<h3 class="page-title"><i class="side-menu__icon fas fa-utensils mr-1"></i>Employee Incentives</h3>		
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Employee Incentives</li>
			</ol>
		</div>
		<!--Page Header-->
	</div>
	<!--  -->
	<!--<div class="row mb-3 row-filter">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-md-3">
							<label>From Date</label>
							<input type="date" name="" id="from_date" value="<?=date('Y-m-d')?>" class="form-control">
						</div>
						<div class="col-md-3">
							<label>To Date</label>
							<input type="date" name="" id="to_date" value="<?=date('Y-m-d')?>" class="form-control">
						</div>
						<div class="col-md-3">
							<button class="btn btn-primary searchdate" style="margin-top:25px;"><i class="fas fa-search"></i> Search</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>-->
	<div class="row mb-3 row-filter">
        <div class="col-md-2">
			<select class="form-control" id="usertype">
				<option value="Restaurant manager">Captain</option>
				<option value="Waiter">Waiter</option>
				<option value="Head Chef">Head Chef</option>
				<option value="Assistant Chef">Assistant Chef</option>
				<option value="Kitchen staff">Kitchen Staff</option>
				<option value="Helper">Helper</option>
				<option value="Utility">Utility</option>
			</select>
		</div>
	</div>
	<div class="row" id="employe-table">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<div class="table-responsive">
						<table class="datatable-withbuttons table table-striped dt-responsive nowrap" id="table-orders">
							<thead >
								<tr>
									<th>Sr.No</th>
									<th>Employee Name</th>
									<th>Total Incentives</th>								
								</tr>
							</thead>
							<tbody class="tbody-group-list">
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>		
	</div>
	<?php
require_once('footer.php');
?>	
<!--<script src="<?=base_url();?>assets/js/custom/Incentivereport.js?v=<?php echo uniqid();?>"></script>-->

<script type="text/javascript">
	//Employeeincentive.base_url="<?=base_url();?>";
	//Employeeincentive.init();
	/*$('.recipe-tabs').find('.receipes .card-body').addClass('active');*/
</script>
<script>
	setInterval(function() {
                $.ajax({
                    url: "<?=base_url();?>restaurant/set_authority_exist",
                    type:'POST',
                    dataType: 'json',
                    data: {name:'Incentive'},
                    success: function(result){
                        if(result.status){
                            window.location.href="<?=base_url();?>restaurant/dashboard";
                        }
                   	}
                });
            },5000);
</script>
<script>
	
$(document).ready(function(){
	$.ajax({
        url: "<?=base_url();?>calculate_incentive_report/calculate_report",
		type:'POST',
		data: {usertype:$('#usertype').val()},
        dataType: 'json',
        success: function(result){
			if ( $.fn.DataTable.isDataTable('.datatable-withbuttons') ) {
                    $('.datatable-withbuttons').DataTable().destroy();
                  }
                  
                  $('.datatable-withbuttons tbody').empty();
			html='';
			var j=1;
			for(var i=0;i<result.length;i++){
				html+='<tr><td>'+j+'</td>\
				<td>'+result[i].name+'</td>\
				<td>'+result[i].incentive+'</td>\
				</tr>';
				j=j+1;
			}
			$('.tbody-group-list').html(html);
			var report_title='Incentive Report';
    Common.datatablewithButtons(report_title,' Customer Report');
		}
    });
});

$('#usertype').change(function(){
	$.ajax({
        url: "<?=base_url();?>calculate_incentive_report/calculate_report",
		type:'POST',
		data: {usertype:$('#usertype').val()},
        dataType: 'json',
        success: function(result){
			if ( $.fn.DataTable.isDataTable('.datatable-withbuttons') ) {
                    $('.datatable-withbuttons').DataTable().destroy();
                  }
                  
                  $('.datatable-withbuttons tbody').empty();
			html='';
			var j=1;
			for(var i=0;i<result.length;i++){
				html+='<tr><td>'+j+'</td>\
				<td>'+result[i].name+'</td>\
				<td>'+result[i].incentive.toFixed(2)+'</td>\
				</tr>';
				j=j+1;
			}
			$('.tbody-group-list').html(html);
			var report_title='Incentive Report';
    Common.datatablewithButtons(report_title,' Customer Report');
		}
    });
});

$(document).ready(function(){
	var report_title='Incentive Report';
    Common.datatablewithButtons(report_title,' Customer Report');
});
</script>
