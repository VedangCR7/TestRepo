<?php
require_once('header.php');
require_once('sidebar.php');
?>

<style>
	#dialog-confirm{display:none;}
</style>

<div class=" app-content">
	<div class="side-app">

		<!--Page Header-->
		<div class="page-header">
			<h3 class="page-title"><i class="side-menu__icon fas fa-utensils mr-1"></i> Dashboard</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Dashboard</li>
			</ol>
		</div>
		<!--Page Header-->
	</div>
	
	<div class="row">
		<div class="col-md-12 col-lg-12">
			<div class="card">
				<div class="card-header">
					<div class="card-title">Restaurant Details</div>
				</div>
				<div class="card-body">
					<div class="table-responsive ">
						<table id="example-2" class="table table-striped table-bordered">
							<thead>
								<tr>
									<th class="wd-15p border-bottom-0">No.</th>
									<th class="wd-15p border-bottom-0">Restaurant Name</th>
									<th class="wd-15p border-bottom-0" data-orderable="false">Email</th>
									<th class="wd-20p border-bottom-0">Today's Order</th>
									<th class="wd-15p border-bottom-0">Total Orders</th>
									<th class="wd-10p border-bottom-0">Revenue</th>
									<th class="wd-25p border-bottom-0" data-orderable="false"></th>
								</tr>
							</thead>
							<tbody>
								<?php $i =1; foreach ($user_list as $user){?>
								<tr>
									<td><?php echo $i;?></td>
									<td><?php echo ucwords($user->name);?></td>
									<td><?php echo $user->email;?></td>
									<td><?php echo $user->tdcnt;?></td>
									<td><?php echo $user->tlcnt;?></td>
									<td><?php echo $user->earning;?></td>
									<td>	
										<button class="btn btn-sm btn-success mr-1 view_restaurant" data-id="<?=$user->id?>"><i class="fas fa-eye"></i></button>
									</td>
								</tr>
								<?php $i=$i+1; }?>
							</tbody>
						</table>
						
						<!-- Custom Delete Code-->
						<div id="dialog-confirm" title="FoodNAI">
							<p>
								<span style="float:left; margin:12px 12px 20px 0;"></span>
								Are you sure you want to Delete?
							</p>
						</div>
						<!-- End Custom Delete Code-->
						
					</div>
				</div>
				<!-- table-wrapper -->
			</div>
			<!-- section-wrapper -->
		</div>
	</div>

<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Restaurant Details</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="row" style="margin-top:10px;">
			<div class="col-lg-4 col-md-4 col-sm-6 col-6">Restaurant Name :</div>
			<div class="col-lg-8 col-md-8 col-sm-6 col-6 restaurant_name"></div>
		</div>
		<div class="row" style="margin-top:10px;">
			<div class="col-lg-4 col-md-4 col-sm-6 col-6">Contact Person :</div>
			<div class="col-lg-8 col-md-8 col-sm-6 col-6 contact_person"></div>
		</div>
		<div class="row" style="margin-top:10px;">
			<div class="col-lg-4 col-md-4 col-sm-6 col-6">Contact Number :</div>
			<div class="col-lg-8 col-md-8 col-sm-6 col-6 contact_number"></div>
		</div>
		<div class="row" style="margin-top:10px;">
			<div class="col-lg-4 col-md-4 col-sm-6 col-6">Restaurant Type :</div>
			<div class="col-lg-8 col-md-8 col-sm-6 col-6 restaurant_type"></div>
		</div>
		<div class="row" style="margin-top:10px;">
			<div class="col-lg-4 col-md-4 col-sm-6 col-6">Email :</div>
			<div class="col-lg-8 col-md-8 col-sm-6 col-6 email"></div>
		</div>
		<div class="row" style="margin-top:10px;">
			<div class="col-lg-4 col-md-4 col-sm-6 col-6">Opening Time :</div>
			<div class="col-lg-8 col-md-8 col-sm-6 col-6 opening_time"></div>
		</div>
		<div class="row" style="margin-top:10px;">
			<div class="col-lg-4 col-md-4 col-sm-6 col-6">Closing Time :</div>
			<div class="col-lg-8 col-md-8 col-sm-6 col-6 closing_time"></div>
		</div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<?php
require_once('footer.php');
?>

<script>
$(document).ready(function() {
          $('#example-2').DataTable();
        } );
	$('.form-disable').on('submit',function() {
		 var self=$(this),
		 button = self.find('input[type="submit"],button'),
		 subVal = button.data('submit-value');
		 button.attr('disabled','disabled').val((subVal) ? subVal : 'Please wait...')
        
       /* return false; */
     });
</script>
<script>
	/* function getCat(select_id,main_id)
	{
		var nm = select_id.options[select_id.selectedIndex].innerHTML;
		
		$.ajax({
			method:"POST",
			url:"<?php echo base_url('Table/getTblCnt'); ?>",
			data:{"tblCatId":main_id},
			success:function(data){
				if(data!='0'){
					let initialStr1 = nm.substring(0, 2);
					let initialStr = initialStr1.toUpperCase();
					$('#new_tblNm').val(initialStr+'-'+data);
				}else{
					alert('Table category not available');
				}
			}
		});
	} */
		
	function onCompletion(){
		var mytblnm1 = document.getElementById('new_tblNm').value;
		var mytblnm2 = document.getElementById('new_tblNm1').value;
		var mytblnm = mytblnm1+mytblnm2;
		if(mytblnm != '')
		{
			if(mytblnm.length < 4 || mytblnm.length > 8)
			{
				document.getElementById('email_message').style.color = 'red';
				document.getElementById('email_message').innerHTML = 'Must enter proper table name.';		
				document.getElementById('new_tblNm1').style.border = '1px solid red';
				/* $('#new_tblNm').val(''); */validateTblName();
				return false;
			}
			else if(mytblnm.length == 3 )
			{
				document.getElementById('email_message').style.color = 'red';
				document.getElementById('email_message').innerHTML = 'Please enter proper table name';		
				document.getElementById('new_tblNm1').style.border = '1px solid red';
				/* $('#new_tblNm').val(''); */validateTblName();
				return false;
			}
		}
	}		
	
	function validate()
	{
		document.getElementById('send').disabled=true;
	}
	
	function validateTblName(){
		var mytblnm1 = document.getElementById('new_tblNm').value;
		var mytblnm2 = document.getElementById('new_tblNm1').value;
		var mytblnm = mytblnm1+mytblnm2;
		if(mytblnm != '')
		{
			if(mytblnm.length < 4 || mytblnm.length > 8)
			{
				document.getElementById('email_message').style.color = 'red';
				document.getElementById('email_message').innerHTML = 'Must enter proper table name';		
				document.getElementById('new_tblNm').style.border = '1px solid red';
				document.getElementById('new_tblNm1').style.border = '1px solid red';
				$('#new_tblNm1').val('');
				return false;
			} 
			else
			{
				$.ajax({
					type: "POST",
					url: "<?php echo base_url('Table/CheckTblName'); ?>",
					async: false,
					data: {
						newtblname: mytblnm				
					},
					success: function (response)
					{
						if(response=="failed")
						{
							document.getElementById('email_message').style.color = 'red';
							document.getElementById('email_message').innerHTML = 'Table name already exist, please try another.';		
							document.getElementById('new_tblNm').style.border = '1px solid red';
							document.getElementById('new_tblNm1').style.border = '1px solid red';
							$('#new_tblNm1').val('');
							return false;
						}
					},
					error: function (xhr, ajaxOptions, thrownError)
					{
						alert(xhr.status);
						alert(thrownError);
					}
				});
			}
		}
	}	
		
	function getCat(select_id,main_id)
	{
		document.getElementById('new_tblNm').style.border = '1px solid green';
		document.getElementById('new_tblNm1').style.border = '1px solid green';
		document.getElementById('email_message').innerHTML = '';
		var nm = select_id.options[select_id.selectedIndex].innerHTML;
		var txt =  document.getElementById('new_tblNm');
		var newstr = nm.substring(0, 2)+'-';
		txt.value = newstr.toUpperCase();
	}	
	
	/* $('#new_tblNm').on('keypress, keydown', function(event) {
	  var $field = $(this);
	  if ((event.which != 37 && (event.which != 39)) &&
		((this.selectionStart < readOnlyLength) ||
		  ((this.selectionStart == readOnlyLength) && (event.which == 8)))) {
		return false;
	  }
	}); */
		
	function mInactive(selected_id)
	{
		$.ajax({
			method:"POST",
			url:"<?php echo base_url('Table/make_tblInactive'); ?>",
			data:{"tId":selected_id},
			success:function(data){
				alert('Table is Inactive now');
				window.location.reload();
			}
		});
	}
	
	function mActive(selected_id)
	{
		$.ajax({
			method:"POST",
			url:"<?php echo base_url('Table/make_tblActive'); ?>",
			data:{"tId":selected_id},
			success:function(data){
				alert('Table is Active now');
				window.location.reload();
			}
		});
	}
	
	function delete_confirm(a)
	{
		$( "#dialog-confirm" ).dialog({
		  resizable: false,
		  height: "auto",
		  width: 400,
		  modal: true,
		  buttons: {
			"Yes": function() {
			  $( this ).dialog( "close" );
			  window.location = "<?php echo base_url();?>Table/DeleteTable/"+a;
			},
			"No": function() {
			  $( this ).dialog( "close" );
			}
		  }
		});
	}
	
	function view_resto(restid)
	{
		$.ajax({
			method:"POST",
			url:"<?php echo base_url('admin/open_resto_dashboard'); ?>",
			data:{"restid":restid},
			success:function(data)
			{
				/* window.location.href("<?php echo base_url();?>restaurant/dashboard/"); */
				window.open("<?php echo base_url();?>restaurant/dashboard/", "_blank");
			}
		});
		/* window.location = "<?php echo base_url();?>Admin/open_resto_dashboard/"+restid; */
	}
</script>

<script>
	$('.view_restaurant').click(function(){
		var id = $(this).attr('data-id');
		//alert(id);
		$.ajax({
			method:"POST",
			url:"<?php echo base_url('admin/view_restaurant_details'); ?>",
			data:{id:id},
			dataType:'JSON',
			success:function(data)
			{
				
				$('.restaurant_name').html(data[0].business_name);
				if(data[0].restauranttype == 'both'){
					$('.restaurant_type').html('Veg-Non Veg');
				}else{
					$('.restaurant_type').html(data[0].restauranttype);
				}
				$('.contact_person').html(data[0].name);
				$('.contact_number').html(data[0].contact_number);
				$('.email').html(data[0].email);
				$('.opening_time').html(data[0].opening_time);
				$('.closing_time').html(data[0].close_time);
				$('#myModal').modal('show');
			}
		});
		
	})
</script>