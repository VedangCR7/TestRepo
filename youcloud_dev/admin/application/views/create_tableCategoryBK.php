<?php
require_once('header.php');
require_once('sidebar.php');
$logged_restoId = $_SESSION['user_id'];
?>

<style>
	#dialog-confirm{display:none;}
	.catTtl{
		border: none;
		border-bottom: 1px solid grey;
		border-bottom-right-radius: 0px;
		border-bottom-left-radius: 0px;
		padding: 0px;
	}
	input.catTtl:focus {
		outline-width: 0!important;
	}
</style>

<div class=" app-content">
	<div class="side-app">

		<!--Page Header-->
		<div class="page-header">
			<h3 class="page-title"><i class="side-menu__icon fas fa-utensils mr-1"></i> Table Management</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Table Management</li>
			</ol>
		</div>
		<!--Page Header-->
	</div>
	
	
	<div class="row">
		<div class="col-lg-12">
			<form  method="post" class="card" id="myForm" action="<?php echo base_url('Table/AddCategory'); ?>" onsubmit="return(validate());">
			<!--<form  method="post" class="card" >-->
			
				<div class="card-header">
					<h3 class="card-title">Create Table Category</h3>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-12 col-lg-12">
							<div class="form-group">
								<label class="form-label">Table Category</label>
								<input type="text" class="form-control" name="tblCatTtl" placeholder="Table Category" id="tblCatTtl" autocomplete="off" required onChange="return validateTblName();" style="text-transform: capitalize;">
							</div>
							<label id='email_message'></label>
						</div>
						<div class="col-md-12 col-lg-12">
							<div class="form-group">
								<label class="form-label">Is Takeaway</label>
								<input type="checkbox" class="form-control" name="chkbox" id="chkbox" value='1' style="width: 50px;">
							</div>
						</div>
						<div class=" mt-2 mb-0">
							<button type="submit" class="btn btn-primary" id="send" name="submit" onClick="onCompletion()">Submit</button>
							<button type="button" class="btn btn-secondary">Cancel</button>
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
					<div class="card-title">Table Category Details</div>
				</div>
				<div class="card-body">
					<div class="table-responsive ">
						<table id="example-2" class="table table-striped table-bordered">
							<thead>
								<tr>
									<th class="wd-15p border-bottom-0">No.</th>
									<th class="wd-15p border-bottom-0">Table Category ID</th>
									<th class="wd-15p border-bottom-0">Table Category</th>
									<th class="wd-20p border-bottom-0">Date</th>
									<th class="wd-10p border-bottom-0" data-orderable="false">Active/Inactive</th>
									<th class="wd-25p border-bottom-0" data-orderable="false"></th>
									<!--<th class="wd-25p border-bottom-0" data-orderable="false"></th>-->
								</tr>
							</thead>
							<tbody>
								<?php if($result ){ $i =1; foreach($result as $r){?>
								<tr>
									<td><?php echo $i;?></td>
									<td><?php echo $r->id;?></td>
									<td>
										<span id="tblval<?php echo $r->id;?>"><?php echo $r->title;?></span>
										<input type="hidden" class="form-control catTtl" name="tblCatTtl" placeholder="Table Category" id="tblCatTitle<?php echo $r->id;?>" autocomplete="off" required value="<?php echo $r->title;?>" onBlur="hideField(<?php echo $r->id; ?>);">
										<input type="hidden" class="form-control tblCatTtlId" name="tblCatTtlId" id="tblCatTtlId<?php echo $r->id;?>" value="<?php echo $r->id;?>">
									</td>
									<td>
										<?php
											$originalDate = $r->datetime;
											echo $newDate = date("d F Y", strtotime($originalDate));
										?>
									</td>
									<td>
									<?php if($r->is_active == 1){?>
										<a href="<?php echo base_url("Table/make_inactive/".$r->id);?>">
											<label class="custom-switch pl-0">
												<input type="checkbox" checked onChange="mInactive(<?php echo $r->id; ?>)" name="custom-switch-checkbox" class="custom-switch-input">
												<span class="custom-switch-indicator"></span>
											</label>
										</a>
									<?php }else if($r->is_active == 0){?>
										<a href="<?php echo base_url("Table/make_active/".$r->id);?>">
											<label class="custom-switch pl-0">
												<input type="checkbox" onChange="mActive(<?php echo $r->id; ?>)" name="custom-switch-checkbox" class="custom-switch-input">
												<span class="custom-switch-indicator"></span>
											</label> 
										</a>
									<?php }?>
									</td>
									<td>
										<!--<a href="<?php echo base_url("Table/edit/".$r->id);?>" onclick="editCat()">-->
										<i class="fas fa-edit" style="cursor:pointer;" onclick="editCat(<?php echo $r->id; ?>);" onBlur="return updateRecord(<?php echo $r->id; ?>);"></i>
									</td>
									<!--<td>
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
      /* $(function () {

        $('form').on('submit', function (e) {

          e.preventDefault();

          $.ajax({
            type: 'POST',
            url: "<?php echo base_url('Table/AddCategory'); ?>",
            data: $('form').serialize(),
            success: function () {
              alert('form was submitted');
            }
          });

        });

      }); */
    </script>
<script>
	/* function validateTblName()
	{
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
					url: "<?php echo base_url('Table/CheckTblCatName'); ?>",
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
	} */
	
	function mInactive(selected_id)
	{
		$.ajax({
			method:"POST",
			url:"<?php echo base_url('Table/make_inactive'); ?>",
			data:{"tcatId":selected_id},
			success:function(data){
				alert('Table category is Inactive now');
				window.location.reload();
			}
		});
	}
	
	function mActive(selected_id)
	{
		$.ajax({
			method:"POST",
			url:"<?php echo base_url('Table/make_active'); ?>",
			data:{"tcatId":selected_id},
			success:function(data){
				alert('Table category is Active now');
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
			  window.location = "<?php echo base_url();?>Table/DeleteTblCat/"+a;
			},
			"No": function() {
			  $( this ).dialog( "close" );
			}
		  }
		});
	}
	
	var idforedit = 0;
	
	function hideField(selected_id){
		var y = document.getElementById("tblCatTitle"+selected_id);
		y.type= "hidden";
		var x = document.getElementById("tblval"+selected_id).style.display= 'block';
		validateTblName();
	}
	
	function editCat(selected_id){
		var x = document.getElementById("tblval"+selected_id).style.display= 'none';
		var y = document.getElementById("tblCatTitle"+selected_id);
		y.type= "text";
		document.getElementById("tblCatTitle"+selected_id).focus();
		idforedit = selected_id;
	}
	
	$(".catTtl").change(function()
	{
		var newvaltoedit = $(this).val();
	    	
		if(newvaltoedit.length > 3)
		{
			validateTblName();
			$.ajax({
				method:"POST",
				url:"<?php echo base_url('Table/editTblCat'); ?>",
				data:{"tcatId":idforedit,'title':newvaltoedit},
				success:function(data){
					alert('Table category is updated');
					window.location.reload();
				}
			});
			var y = document.getElementById("tblCatTitle"+idforedit);
			y.type= "hidden";
			var x = document.getElementById("tblval"+idforedit).style.display= 'block';
			/* $("#tblval"+idforedit).load("getTableCategoryName/"+idforedit+ " #tblval"+idforedit);
			$( "#tblval"+idforedit ).load( "getTableCategoryName/"+idforedit+" #tblval"+idforedit );  */
			$( "#tblval"+idforedit ).load( "getTableCategoryName/"+idforedit ); 
		}
		else
		{
			alert('Please enter valid Table category.');
			document.getElementById("tblCatTitle"+idforedit).focus();
		}
	});
	
	function onCompletion()
	{
		/ document.getElementById('send').disabled=true; /
		var mytblnm = document.getElementById('tblCatTtl').value;
		
		if(mytblnm != '')
		{
			if(mytblnm.length < 4 || mytblnm.length > 32)
			{
				document.getElementById('email_message').style.color = 'red';
				document.getElementById('email_message').innerHTML = 'Must enter proper table category.';		
				document.getElementById('tblCatTtl').style.border = '1px solid red';
				validateTblName();
				return false;
			}
			else if(mytblnm.length == 3 )
			{
				document.getElementById('email_message').style.color = 'red';
				document.getElementById('email_message').innerHTML = 'Please enter proper table category';		
				document.getElementById('tblCatTtl').style.border = '1px solid red';
				validateTblName();
				return false;
			}
		}
	}
	
	function validate()
	{
		document.getElementById('send').disabled=true;
	}
	
	function validateTblName()
	{
		var mytblnm = document.getElementById('tblCatTtl').value;
		if(mytblnm != '')
		{
			if(mytblnm.length < 4 || mytblnm.length > 32)
			{
				document.getElementById('email_message').style.color = 'red';
				document.getElementById('email_message').innerHTML = 'Must enter proper table category';		
				document.getElementById('tblCatTtl').style.border = '1px solid red';
				$('#tblCatTtl').val('');
				return false;
			} 
			else
			{
				document.getElementById('email_message').style.color = 'green';
				document.getElementById('email_message').innerHTML = '';		
				document.getElementById('tblCatTtl').style.border = '1px solid green';
				$.ajax({
					type: "POST",
					url: "<?php echo base_url('Table/CheckTblCategory'); ?>",
					async: false,
					data: {
						newtblcategory: mytblnm				
					},
					success: function (response)
					{
						if(response=="failed")
						{
							document.getElementById('email_message').style.color = 'red';
							document.getElementById('email_message').innerHTML = 'Table category already exist, please try another.';		
							document.getElementById('tblCatTtl').style.border = '1px solid red';
							$('#tblCatTtl').val('');
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
	
	/* 
	function updateRecord(selected_id){
		var xy = document.getElementById("tblCatTitle").value;
		$.ajax({
			method:"POST",
			url:"<?php echo base_url('Table/editTblCat'); ?>",
			data:{"tcatId":selected_id,'title':xy},
			success:function(data){
				alert('Table category is updated');
			}
		});
		var y = document.getElementById("tblCatTitle");
		y.type= "hidden";
		var x = document.getElementById("tblval").style.display= 'block';
	}
	
	$('input:checkbox').on('change', function() {
		let main_id='<?php echo $logged_restoId;?>';
		if (this.checked)
			$.ajax({
				method:"POST",
				url:"<?php echo base_url('Table/make_active'); ?>",
				data:{"tcatId":main_id},
				success:function(data){
					alert('Table category is Active now');
				}
			});
		else
			$.ajax({
				method:"POST",
				url:"<?php echo base_url('Table/make_inactive'); ?>",
				data:{"tcatId":main_id},
				success:function(data){
					alert('Table category is Inactive now');
				}
			});
	}); */
	
	$(document).ready(function() {
	  $('#example-2').DataTable();
	} );
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