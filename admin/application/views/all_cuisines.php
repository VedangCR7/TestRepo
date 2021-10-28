<?php
require_once('header.php');
require_once('sidebar.php');
?>

<div class=" app-content">
	<div class="side-app">

		<!--Page Header-->
		<div class="page-header">
			<h3 class="page-title"><i class="fe fe-user mr-1"></i> Cuisines</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?=base_url();?>admin">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page"> Cuisines</li>
			</ol>
		</div>
		<!--Page Header-->
		<div class="row">
				<div class="card">
					<div class="card-header">
						<div class="col-lg-12 col-md-12 col-sm-12 col-12 text-right">
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-12 text-right"><button class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add Cusines</button></div>
						</div>
						</div>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-12 table-responsive">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th>Sr.no</th>
											<th>Cuisines</th>
											<th>Active/Inactive</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
									<?php $i=1; foreach($cuisines as $key=>$value){ ?>
										<tr>
											<td><?=$i?></td>
											<td><?=$value['cuisines']?></td>
											<td>
												<label class="custom-switch pl-0">';
													<?php if($value['is_active']==1){ ?>
														<input type="checkbox" name="custom-switch-checkbox" data-id="<?=$value['id']?>" class="custom-switch-input input-switch-box1" checked>
													<?php} else{ ?>
														<input type="checkbox" name="custom-switch-checkbox" data-id="<?=$value['id']?>" class="custom-switch-input input-switch-box1">
													<?php } ?>
														<span class="custom-switch-indicator"></span>
													</label>
											</td>
											<td><button class="btn btn-danger btn-sm deletecuisines" data-id="<?=$value['id']?>"><i class="fa fa-trash"></i></button></td>
										</tr>
									<?php $i++; } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
		</div>
	</div>
</div>

<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Cuisines</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-12">
				<input type="text" placeholder="Enter Cuisines" id="cuisines" class="form-control">
			</div>
		</div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
		<button type="button" class="btn btn-primary" id="add_cuisines">Save</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<?php
require_once('footer.php');
?>


<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
	$('#add_cuisines').click(function(){
		$.ajax({
				url:"<?=base_url()?>admin/add_cuisines",
				type: "POST",
				data: {cuisines:$('#cuisines').val()},
				dataType:'json',
				success: function(data){
					swal("Cuisines added successfully")
					.then((value) => {
					  location.reload();
					});
					
				}	        
			});
	});
	
	$('.deletecuisines').click(function(){
		var id = $(this).attr('data-id');
		$.ajax({
				url:"<?=base_url()?>admin/delete_cuisines",
				type: "POST",
				data: {id:id},
				dataType:'json',
				success: function(data){
					swal("Cuisines deleted successfully")
					.then((value) => {
					  location.reload();
					});
				}	        
			});
	});
	
	$('.input-switch-box1').change(function(){
		//alert('hii');
		if($(this).is(':checked')){
            $(this).val("on");
			swal("Success!", "Cuisines is active now!", "success");
		}
        else{
            $(this).val("off");
            swal("Success!", "Cuisines is inactive now!", "success");
        }

        var self=this;
        var data_id=$(this).attr('data-id');
        var formData={
            id : data_id,
            is_active:$(this).val()
        }
		
		console.log(formData);
        $.ajax({
            url: "<?=base_url()?>admin/cuisine_active_inactive",
            type:'POST',
            data:formData ,
            success: function(result){
               if (result.status) {
					  //location.reload();
               }
            }
        });
	})
</script>