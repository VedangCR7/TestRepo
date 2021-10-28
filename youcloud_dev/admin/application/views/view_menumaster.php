<?php
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
			<h3 class="page-title"><i class="side-menu__icon fas fa-utensils mr-1"></i> Menu Management</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">View Menu</li>
			</ol>
		</div>
		<!--Page Header-->
	</div>
	
	
	<div class="row">
		<div class="col-lg-12">
			<form  method="post" class="card" action="<?php echo base_url('Admin/AddMenuMaster'); ?>" >
			
				<div class="card-header">
					<h3 class="card-title">Create Master Menu</h3>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-3 col-lg-3">
							<div class="form-group">
								<label class="form-label">Restaurant Menu</label>
								<input type="text" class="form-control" name="restmenu" placeholder="Restaurant Menu" id="restmenu" autocomplete="off" required onChange="return validateTblName();">
							</div>
							<label id='email_message'></label>
						</div>
						<div class="col-md-3 col-lg-3">
							<div class="form-group">
								<label class="form-label">Long Description</label>
								<input type="text" class="form-control" name="longdesc" placeholder="Long Description" id="longdesc" autocomplete="off" required onChange="return validateTblName();">
							</div>
							<label id='email_message'></label>
						</div>
						<div class="col-md-3 col-lg-3">
							<div class="form-group">
								<label class="form-label">Declaration Name</label>
								<input type="text" class="form-control" name="declarationnm" placeholder="Declaration Name" id="declarationnm" autocomplete="off" required onChange="return validateTblName();">
							</div>
							<label id='email_message'></label>
						</div>
						<div class="col-md-3 col-lg-3">
							<div class="form-group">
								<label class="form-label">Menu Image</label>
								<input type="file" id="mastermenuimg" name="mastermenuimg">
							</div>
							<label id='email_message'></label>
						</div>
						<div class=" mt-2 mb-0">
							<button type="submit" class="btn btn-primary" onClick="onCompletion()">Submit</button>
							<button type="submit" class="btn btn-secondary">Cancel</button>
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
					<div class="card-title">Restaurant Menu</div>
				</div>
				<div class="card-body">
					<div class="table-responsive ">
						<table id="example-2" class="table table-striped table-bordered">
							<thead>
								<tr>
									<th class="wd-15p border-bottom-0">Image ID</th>
									<th class="wd-20p border-bottom-0">Image</th>
									<th class="wd-20p border-bottom-0">Menu</th>
									<th class="wd-20p border-bottom-0" style="width: 30%!important;">Long Description</th>
									<th class="wd-20p border-bottom-0">Declaration Name</th>
									<th class="wd-25p border-bottom-0" data-orderable="false"></th>
									<th class="wd-25p border-bottom-0" data-orderable="false"></th>
								</tr>
							</thead>
							<tbody class="tbody-group-list">
								<?php if($result ){ foreach($result as $r){?>
								<tr>
									<td><?php echo $r->id;?></td>
									<td>
										<input type="file" class="imgupload" accept="image/jpeg, image/png" style="display:none"/>
										<img src="<?php echo $r->recipe_image;?>" style="height:50px;width:50px;" class="img-upload">
									</td>
									<td><?php echo ucwords(strtolower($r->name));?></td>
									<td><?php echo ucwords($r->long_desc);?></td>
									<td><?php echo ucwords($r->declaration_name);?></td>
									<td>
										<!--<a href="<?php echo base_url("Admin/edit/".$r->id);?>" onclick="editCat()">-->
										<i class="fas fa-edit" style="cursor:pointer;" onclick="editCat(<?php echo $r->id; ?>);" onBlur="return updateRecord(<?php echo $r->id; ?>);"></i>
									</td>
									<td>	
										<i class="fas fa-trash" onclick="delete_confirm(<?php echo $r->id; ?>)" style="cursor:pointer; color:#f15e5e;"></i>
									</td>
								</tr>
								<?php }}?>
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
<script src="<?=base_url();?>assets/js/custom/Menumaster.js?v=3"></script>
<script>
	Menumaster.base_url="<?=base_url();?>";
	Menumaster.init();
</script>
<script>
	$('.form-disable').on('submit',function() {
		 var self=$(this),
		 button = self.find('input[type="submit"],button'),
		 subVal = button.data('submit-value');
		 button.attr('disabled','disabled').val((subVal) ? subVal : 'Please wait...')
        
       /* return false; */
     });
</script>
<script>
	/* $('.tbody-group-list').on('click','.img-upload',function(){
            $(this).closest('tr').find('.imgupload').trigger('click');
	});
	$('.tbody-group-list').on('change','.imgupload',this.onImageUpload);	 */
	
	function onCompletion(){
		var mytblnm = document.getElementById('new_tblNm').value;
		if(mytblnm != '')
		{
			if(mytblnm.length < 4 || mytblnm.length > 6)
			{
				document.getElementById('email_message').style.color = 'red';
				document.getElementById('email_message').innerHTML = 'Must enter proper table name';		
				document.getElementById('new_tblNm').style.border = '1px solid red';
				/* $('#new_tblNm').val(''); */validateTblName();
				return false;
			}
			else if(mytblnm.length == 3 )
			{
				document.getElementById('email_message').style.color = 'red';
				document.getElementById('email_message').innerHTML = 'Please enter proper table name';		
				document.getElementById('new_tblNm').style.border = '1px solid red';
				/* $('#new_tblNm').val(''); */validateTblName();
				return false;
			}
		}
	}		
		
	function validateTblName(){
		var mytblnm = document.getElementById('new_tblNm').value;
		if(mytblnm != '')
		{
			if(mytblnm.length < 4 || mytblnm.length > 6)
			{
				document.getElementById('email_message').style.color = 'red';
				document.getElementById('email_message').innerHTML = 'Must enter proper table name';		
				document.getElementById('new_tblNm').style.border = '1px solid red';
				$('#new_tblNm').val('');
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
							document.getElementById('email_message').innerHTML = 'Table name already used, please try another.';		
							document.getElementById('new_tblNm').style.border = '1px solid red';
							$('#new_tblNm').val('');
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
		document.getElementById('email_message').innerHTML = '';
		var nm = select_id.options[select_id.selectedIndex].innerHTML;
		var txt =  document.getElementById('new_tblNm');
		var newstr = nm.substring(0, 2)+'-';
		txt.value = newstr.toUpperCase();
	}	
		
	function mInactive(selected_id)
	{
		$.ajax({
			method:"POST",
			url:"<?php echo base_url('Table/make_tblInactive'); ?>",
			data:{"tId":selected_id},
			success:function(data){
				alert('Table is Inactive now');
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
				alert('Table category is Active now');
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
			  window.location = "<?php echo base_url();?>Admin/DeleteTable/"+a;
			},
			"No": function() {
			  $( this ).dialog( "close" );
			}
		  }
		});
	}
</script>