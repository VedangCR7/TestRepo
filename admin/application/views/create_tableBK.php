<?php
/* echo phpinfo();exit; */
require_once('header.php');
require_once('sidebar.php');
 $logged_restoId = $_SESSION['user_id'];
?>

<style>
	#dialog-confirm{display:none;}
</style>

<div class=" app-content">
	<div class="side-app">

		<!--Page Header-->
		<div class="page-header">
			<h3 class="page-title"><i class="side-menu__icon fe fe-cpu mr-1"></i> Table Management</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Create Table</li>
			</ol>
		</div>
		<!--Page Header-->
	</div>
	
	
	<div class="row">
		<div class="col-lg-12">
			<form  method="post" class="card form-disable" action="<?php echo base_url('Table/Add'); ?>" onsubmit="return(validate());">
			
				<div class="card-header">
					<h3 class="card-title">Create Table</h3>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label class="form-label">Table Category</label>
								<select name="select_id" id="select_id" onChange="return getCat(this,this.value);" class="form-control select2 custom-select" required>
									<option value="0" selected disabled>Select Table Category</option>
									<?php if($allTblCat)
									{
										foreach($allTblCat as $rc)
										{
									?>
										<option value = "<?php echo $rc->id; ?>" id="opt_<?php echo $rc->title; ?>"><?php echo $rc->title; ?></option>
									<?php 	
										} 
									} ?>
								</select>
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label class="form-label">Table Name</label>
								
								<div class="row">
									<div class="col-md-6 col-lg-6" style="margin-right: -205px;">
										<input type="text" class="form-control" name="new_tblNm" placeholder="TA-" value="" id="new_tblNm" readonly required>
									</div>
									<div class="col-md-6 col-lg-6">	
										<input type="text" class="form-control" name="new_tblNm1" onChange="validateNum()" placeholder="Table Name" value="" id="new_tblNm1" required style="border-left:none;text-transform: capitalize;">
									</div>
								</div>
								<input type="hidden" class="form-control" name="tblcatId" value="" id="tblcatId">
							</div>
							<label id='email_message'></label>
						</div>
						<div class=" mt-2 mb-0">
							<button type="submit" class="btn btn-primary" id="send" onClick="onCompletion(); validateTblName();">Submit</button>
							<button type="reset" class="btn btn-secondary">Reset</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	
	
	
	<div class="row">
		<div class="col-md-12 col-lg-12">
			<div class="card">
				<div class="card-header">
					<div class="card-title">Table Details</div>
				</div>
				<div class="card-body">
					<div class="table-responsive ">
						<table id="example-2" class="table table-striped table-bordered">
							<thead>
								<tr>
									<th class="wd-15p border-bottom-0">No.</th>
									<th class="wd-15p border-bottom-0">Table Category</th>
									<th class="wd-15p border-bottom-0">Table Name</th>
									<th class="wd-20p border-bottom-0" data-orderable="false">Date</th>
									<th class="wd-15p border-bottom-0" data-orderable="false">QR Code</th>
									<th class="wd-10p border-bottom-0" data-orderable="false">Active/Inactive</th>
									<!--<th class="wd-25p border-bottom-0" data-orderable="false"></th>-->
								</tr>
							</thead>
							<tbody>
								<?php if($result ){ $i =1; foreach($result as $r){?>
								<tr>
									<td><?php echo $i;?></td>
									<td><?php echo ucwords($r->ttl);?></td>
									<td><?php echo $r->title;?></td>
									<td>
										<?php
											$originalDate = $r->datetime;
											echo $newDate = date("d F Y", strtotime($originalDate));
										?>
									</td>
									<td>
										<?php if($r->is_active == 1){?>
										<img src="<?php echo base_url($r->qrcode);?>" height="105px;">
										<?php } ?>
									</td>
									<td>
									<?php if($r->is_active == 1){?>
										<a href="<?php echo base_url("Table/make_tblInactive/".$r->id);?>">
										<label class="custom-switch pl-0">
											<input type="checkbox" checked onChange="mInactive(<?php echo $r->id; ?>)" name="custom-switch-checkbox" class="custom-switch-input">
											<span class="custom-switch-indicator"></span>
										</label></a>
										
										<?php }else if($r->is_active == 0){?>
										<a href="<?php echo base_url("Table/make_tblActive/".$r->id);?>">
											<label class="custom-switch pl-0">
												<input type="checkbox" onChange="mActive(<?php echo $r->id; ?>)" name="custom-switch-checkbox" class="custom-switch-input">
												<span class="custom-switch-indicator"></span>
											</label>
										</a>
										<?php }?>
									</td>
									<!--<td>
										<a href="<?php echo base_url("Table/edit/".$r->id);?>">
											<i class="fas fa-edit"></i>
										</a>
									</td>
									<td>	
										<i class="fas fa-trash" onclick="delete_confirm(<?php echo $r->id; ?>)" style="cursor:pointer; color:#f15e5e;"></i>
									</td>-->
								</tr>
								<?php $i=$i+1; }}?>
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
			}else{
				var n = document.getElementById('new_tblNm1').value;
				if(isNaN(n)){
					ument.getElementById('email_message').style.color = 'red';
					document.getElementById('email_message').innerHTML = 'Please enter only numbers';		
					document.getElementById('new_tblNm1').style.border = '1px solid red';
				}else{
					document.getElementById('email_message').innerHTML = '';		
					document.getElementById('new_tblNm1').style.border = '1px solid green';
				}
			}
		}
	}
	
	function validateNum(){
		var mytblnm = document.getElementById('new_tblNm1').value;
		if(mytblnm != '')
		{
			if(isNaN(mytblnm))
			{
				document.getElementById('email_message').style.color = 'red';
				document.getElementById('email_message').innerHTML = 'Accepts only numbers.';		
				document.getElementById('new_tblNm1').style.border = '1px solid red';
				$('#new_tblNm1').val('');
				return false;
			}
			else
			{
				document.getElementById('email_message').style.color = 'red';
				document.getElementById('email_message').innerHTML = '';		
				document.getElementById('new_tblNm1').style.border = '1px solid green';
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
</script>

<script>
	setInterval(function() {
                $.ajax({
                    url: "<?=base_url();?>restaurant/set_authority_exist",
                    type:'POST',
                    dataType: 'json',
                    data: {name:'Table Management'},
                    success: function(result){
                        if(result.status){
                            window.location.href="<?=base_url();?>restaurant/dashboard";
                        }
                   	}
                });
            },5000);
</script>