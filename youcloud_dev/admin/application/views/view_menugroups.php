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
			<h3 class="page-title"><i class="side-menu__icon fas fa-utensils mr-1"></i> Restaurant Details</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Restaurant Details</li>
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
				
				<div class="container">
					<div class="form-group">
						<label class="form-label">Restaurants</label>
						<select name="country" id="select-countries" class="form-control select2 custom-select">
							<option value="br">Brazil</option>
							<option value="cz">Czech Republic</option>
							<option value="de">Germany</option>
							<option value="pl"selected>Poland</option>
						</select>
					</div>
				</div>
				
				<div class="card-body">
					<div class="table-responsive ">
						<table id="example-2" class="table table-striped table-bordered">
							<thead>
								<tr>
									<th class="wd-15p border-bottom-0">Menu Group ID</th>
									<th class="wd-15p border-bottom-0">Menu Group</th>
									<th class="wd-20p border-bottom-0">Main Menu Group</th>
									<th class="wd-10p border-bottom-0" data-orderable="false">Active/Inactive</th>
									<th class="wd-25p border-bottom-0" data-orderable="false"></th>
									<th class="wd-25p border-bottom-0" data-orderable="false"></th>
								</tr>
							</thead>
							<tbody>
								<?php if($result ){ $i =1; foreach($result as $r){?>
								<tr>
									<td><?php echo $r->id;?></td>
									<td>
										<span id="tblval<?php echo $r->id;?>"><?php echo $r->title;?></span>
										<input type="hidden" class="form-control catTtl" name="tblCatTtl" placeholder="Table Category" id="tblCatTitle<?php echo $r->id;?>" autocomplete="off" required value="<?php echo $r->title;?>">
										<input type="hidden" class="form-control tblCatTtlId" name="tblCatTtlId" id="tblCatTtlId<?php echo $r->id;?>" value="<?php echo $r->id;?>">
									</td>
									<td><?php echo $r->mmname; ?></td>
									<td>
									<?php if($r->is_active == 1){?>
										<a href="<?php echo base_url("Menugroup/make_inactive/".$r->id);?>">
											<label class="custom-switch pl-0">
												<input type="checkbox" checked onChange="mInactive(<?php echo $r->id; ?>)" name="custom-switch-checkbox" class="custom-switch-input">
												<span class="custom-switch-indicator"></span>
											</label>
										</a>
									<?php }else if($r->is_active == 0){?>
										<a href="<?php echo base_url("Menugroup/make_active/".$r->id);?>">
											<label class="custom-switch pl-0">
												<input type="checkbox" onChange="mActive(<?php echo $r->id; ?>)" name="custom-switch-checkbox" class="custom-switch-input">
												<span class="custom-switch-indicator"></span>
											</label> 
										</a>
									<?php }?>
									</td>
									<td>
										<!--<a href="<?php echo base_url("Menugroup/edit/".$r->id);?>" onclick="editCat()">-->
										<i class="fas fa-edit" style="cursor:pointer;" onclick="editCat(<?php echo $r->id; ?>);" onBlur="return updateRecord(<?php echo $r->id; ?>);"></i>
									</td>
									<td>	
										<i class="fas fa-trash" onclick="delete_confirm(<?php echo $r->id; ?>)" style="cursor:pointer; color:#f15e5e;"></i>
									</td>
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

	function mInactive(selected_id)
	{
		$.ajax({
			method:"POST",
			url:"<?php echo base_url('Menugroup/make_inactive'); ?>",
			data:{"tcatId":selected_id},
			success:function(data){
				alert('Table category is Inactive now');
			}
		});
	}
	
	function mActive(selected_id)
	{
		$.ajax({
			method:"POST",
			url:"<?php echo base_url('Menugroup/make_active'); ?>",
			data:{"tcatId":selected_id},
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
			  window.location = "<?php echo base_url();?>Menugroup/DeleteTblCat/"+a;
			},
			"No": function() {
			  $( this ).dialog( "close" );
			}
		  }
		});
	}
	
	var idforedit = 0;
	
	function editCat(selected_id){
		var x = document.getElementById("tblval"+selected_id).style.display= 'none';
		var y = document.getElementById("tblCatTitle"+selected_id);
		y.type= "text";
		document.getElementById("tblCatTitle"+selected_id).focus();
		idforedit = selected_id;
	}
	
	$(".catTtl").change(function(){
		var newvaltoedit = $(this).val();
	    	
		if(newvaltoedit.length > 3){
			$.ajax({
				method:"POST",
				url:"<?php echo base_url('Menugroup/editTblCat'); ?>",
				data:{"tcatId":idforedit,'title':newvaltoedit},
				success:function(data){
					alert('Table category is updated');
				}
			});
			var y = document.getElementById("tblCatTitle"+idforedit);
			y.type= "hidden";
			var x = document.getElementById("tblval"+idforedit).style.display= 'block';
			/* $("#tblval"+idforedit).load("getTableCategoryName/"+idforedit+ " #tblval"+idforedit);
			$( "#tblval"+idforedit ).load( "getTableCategoryName/"+idforedit+" #tblval"+idforedit );  */
			$( "#tblval"+idforedit ).load( "getTableCategoryName/"+idforedit ); 
		}
		else{
			alert('Please enter valid Table category.');
			document.getElementById("tblCatTitle"+idforedit).focus();
		}
	});
	
	function onCompletion(){
		var mytblnm = document.getElementById('tblCatTtl').value;
		if(mytblnm != '')
		{
			if(mytblnm.length < 4 || mytblnm.length > 32)
			{
				document.getElementById('email_message').style.color = 'red';
				document.getElementById('email_message').innerHTML = 'Must enter proper table category';		
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
	
	function validateTblName(){
		var mytblnm = document.getElementById('tblCatTtl').value;
		if(mytblnm != '')
		{
			if(mytblnm.length < 4 || mytblnm.length > 6)
			{
				document.getElementById('email_message').style.color = 'red';
				document.getElementById('email_message').innerHTML = 'Must enter proper table category';		
				document.getElementById('tblCatTtl').style.border = '1px solid red';
				$('#tblCatTtl').val('');
				return false;
			} 
			else
			{
				$.ajax({
					type: "POST",
					url: "<?php echo base_url('Menugroup/CheckTblCategory'); ?>",
					async: false,
					data: {
						newtblcategory: mytblnm				
					},
					success: function (response)
					{
						if(response=="failed")
						{
							document.getElementById('email_message').style.color = 'red';
							document.getElementById('email_message').innerHTML = 'Table category already used, please try another.';		
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
	
</script>