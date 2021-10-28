<?php
require_once('header.php');
require_once('sidebar.php');
?>
<div class=" app-content">
	<div class="side-app">

		<!--Page Header-->
		<div class="page-header">
			<h3 class="page-title"><i class="fe fe-user mr-1"></i> Users</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?=base_url();?>admin">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Users</li>
			</ol>
		</div>
		<!--Page Header-->
		<div class="row">
			<div class="col-lg-12 col-md-12">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title text-center" >Users</h3>
					</div>
					<div class="card-body p-6">
						<div class="panel panel-primary">
							<div class=" tab-menu-heading">
								<div class="tabs-menu1 ">
									<!-- Tabs -->
									<ul class="nav panel-tabs">
										<li><a href="#tab-induser" data-toggle="tab" class="active">Individual Users</a></li>
										<li class=""><a href="#tab-indrest" data-toggle="tab">Restaurant</a></li>
										<li class=""><a href="#tab-burger" data-toggle="tab">Burger and Sandwich</a></li>
										<li><a href="#tab-foodcmp" data-toggle="tab">Restaurant chain</a></li>
										<li><a href="#tab-scool" data-toggle="tab">School</a></li>
									</ul>
								</div>
							</div>
							<div class="panel-body tabs-menu-body">
								<div class="tab-content">
									<div class="tab-pane active" id="tab-induser">
										<div class="row">
											<div class="col-md-12">
												<table id="table-induser" class="table table-striped table-bordered table-datable" section="individual">
													<thead>
														<tr>
															<th class="wd-15p border-bottom-0">Sr.No.</th>
															<th class="wd-15p border-bottom-0">Name</th>
															<th class="wd-25p border-bottom-0">Email</th>
															<th class="wd-15p border-bottom-0">Recipe (count) </th>
															<th class="wd-25p border-bottom-0">Status</th>
															<th class="wd-25p border-bottom-0">Payment Expiry Date</th>
															<th>Action</th>
														</tr>
													</thead>
													<tbody>
														<?php
														$i=1;
														foreach ($user_list['Individual User'] as $user) {
														?>
															<tr>
																<td><?=$i;?></td>
																<td><?=$user['name'];?></td>
																<td><?=$user['email'];?></td>
																<td><?=$user['recipes_count'];?></td>
																<td>
																	<?php
																	if($user['is_active']==1)
																		echo 'Active';
																	else 
																		echo 'Inactive';
																	?>
																</td>
																<td><?=$user['payment_end_date'];?></td>
																<td>
																	<label class="custom-switch pl-0">
																 	<?php
										                                if($user['is_active']==1){
																 	?>
										                                <input type="checkbox" name="custom-switch-checkbox" data-id="<?=$user['id'];?>" class="custom-switch-input input-switch-box input-change-status" checked>
										                            <?php
										                            	}
										                            	else{
										                            ?>
										                                <input type="checkbox" name="custom-switch-checkbox" data-id="<?=$user['id'];?>" class="custom-switch-input input-switch-box input-change-status">
										                            <?php
										                            	}
										                            ?>
									                                <span class="custom-switch-indicator"></span>
									                                </label>
																</td>
															</tr>
														<?php
															$i++;
														}
														?>
														
													</tbody>
												</table>
												
											</div>
										</div>
									</div>
									<div class="tab-pane" id="tab-indrest">
										<div class="row">
											<div class="col-md-12">
												<table id="table-induser" class="table table-striped table-bordered table-datable table-restaurants" section="restaurant">
													<thead>
														<tr>
															<th class="wd-15p border-bottom-0">Sr.No.</th>
															<th class="wd-15p border-bottom-0">Name</th>
															<th class="wd-25p border-bottom-0">Email</th>
															<th class="wd-15p border-bottom-0">Total User (Count)</th>
															<th class="wd-15p border-bottom-0">Daily User (Count)</th>
															<th class="wd-15p border-bottom-0">Recipe (Count) </th>
															<th class="wd-25p border-bottom-0">Status</th>
															<th class="wd-25p border-bottom-0">Payment Expiry Date</th>
															<th>Is Alacalc Recipe</th>
															<th>Is Category Price</th>
															<th>Action</th>
														</tr>
													</thead>
													<tbody>
														<?php
														$i=1;
														foreach ($user_list['Restaurant'] as $user) {
															/*print_r($user);*/
														?>
															<tr>
																<td><?=$i;?></td>
																<td><?=$user['name'];?></td>
																<td><?=$user['email'];?></td>
																<td>
																	<?php if($user['total_user_count'] == ''){echo '0';}else{ ?>
																	<?=$user['total_user_count'];?>
																	<?php } ?>
																</td>
																<td>
																	<?php if($user['daily_user_count'] == ''){echo '0';}else{ ?>
																	<?=$user['daily_user_count'];?>
																	<?php } ?>
																</td>
																<td><?=$user['recipes_count'];?></td>

																<td>
																	<?php
																	if($user['is_active']==1)
																		echo 'Active';
																	else 
																		echo 'Inactive';
																	?>
																</td>
																<td><?=$user['payment_end_date'];?></td>
																<td>
																	<label class="custom-switch pl-0">
																	<?php
																	if($user['is_alacalc_recipe']==1){
																	?>
																		<input type="checkbox" name="custom-switch-checkbox" data-id="<?=$user['id'];?>" class="custom-switch-input input-switch-box input-change-alacalc" checked>
																	<?php
																	}
																	else{
																	?>
																	  <input type="checkbox" name="custom-switch-checkbox" data-id="<?=$user['id'];?>" class="custom-switch-input input-switch-box input-change-alacalc">
																	<?php
																		}
																	?>
																	<span class="custom-switch-indicator"></span>
									                                </label>
																</td>
																<td>
																	<label class="custom-switch pl-0">
																	<?php
																	if($user['is_category_prices']==1){
																	?>
																		<input type="checkbox" name="custom-switch-checkbox" data-id="<?=$user['id'];?>" class="custom-switch-input input-switch-box input-change-category" checked>
																	<?php
																	}
																	else{
																	?>
																	  <input type="checkbox" name="custom-switch-checkbox" data-id="<?=$user['id'];?>" class="custom-switch-input input-switch-box input-change-category">
																	<?php
																		}
																	?>
																	<span class="custom-switch-indicator"></span>
									                                </label>
																</td>
																<td>
																	<label class="custom-switch pl-0">
																 	<?php
										                                if($user['is_active']==1){
																 	?>
										                                <input type="checkbox" name="custom-switch-checkbox" data-id="<?=$user['id'];?>" class="custom-switch-input input-switch-box input-change-status" checked>
										                            <?php
										                            	}
										                            	else{
										                            ?>
										                                <input type="checkbox" name="custom-switch-checkbox" data-id="<?=$user['id'];?>" class="custom-switch-input input-switch-box input-change-status">
										                            <?php
										                            	}
										                            ?>
									                                <span class="custom-switch-indicator"></span>
									                                </label>
									                                <span style="font-size:20px;margin-top:-5px;margin-left:10px;" data-id="<?=$user['id']?>" title="Set Authority" class="get_rest_id" data-toggle="modal" data-target="#showrestmenu"><i class="fas fa-bars text-danger"></i></span>
																</td>
															</tr>
														<?php
															$i++;
														}
														?>
														
													</tbody>
												</table>
												
											</div>
										</div>
									</div>
									<div class="tab-pane" id="tab-burger">
										<div class="row">
											<div class="col-md-12">
												<table id="table-induser" class="table table-striped table-bordered table-datable" section="burger">
													<thead>
														<tr>
															<th class="wd-15p border-bottom-0">Sr.No.</th>
															<th class="wd-15p border-bottom-0">Name</th>
															<th class="wd-25p border-bottom-0">Email</th>
															<th class="wd-15p border-bottom-0">Recipe (Count) </th>
															<th class="wd-25p border-bottom-0">Status</th>
															<th class="wd-25p border-bottom-0">Payment Expiry Date</th>
															<th>Action</th>
														</tr>
													</thead>
													<tbody>
														<?php
														$i=1;
														foreach ($user_list['Burger and Sandwich'] as $user) {
														?>
															<tr>
																<td><?=$i;?></td>
																<td><?=$user['name'];?></td>
																<td><?=$user['email'];?></td>
																<td><?=$user['recipes_count'];?></td>
																<td>
																	<?php
																	if($user['is_active']==1)
																		echo 'Active';
																	else 
																		echo 'Inactive';
																	?>
																</td>
																<td><?=$user['payment_end_date'];?></td>
																<td>
																	<label class="custom-switch pl-0">
																 	<?php
										                                if($user['is_active']==1){
																 	?>
										                                <input type="checkbox" name="custom-switch-checkbox" data-id="<?=$user['id'];?>" class="custom-switch-input input-switch-box input-change-status" checked>
										                            <?php
										                            	}
										                            	else{
										                            ?>
										                                <input type="checkbox" name="custom-switch-checkbox" data-id="<?=$user['id'];?>" class="custom-switch-input input-switch-box input-change-status">
										                            <?php
										                            	}
										                            ?>
									                                <span class="custom-switch-indicator"></span>
									                                </label>
																</td>
															</tr>
														<?php
															$i++;
														}
														?>
														
													</tbody>
												</table>
												
											</div>
										</div>
									</div>
									<div class="tab-pane" id="tab-foodcmp">
										<div class="row mb-3">
											<div class="col-md-1">
												<h5 class="text-right mt-1">Filter : </h5>
											</div>
											<div class="col-md-3">
												<select class="form-control" name="food_company" id="select-food-company">
													<option>Select Company</option>
													<option value="All" selected="">All</option>
													<?php
													foreach ($companies as $company) {
													?>
														<option value="<?=$company['id'];?>"><?=$company['name'];?></option>
													<?php
													}
													?>
												</select>
											</div>
											<div class="col-md-12">
												<hr>
											</div>
										</div>

										<div class="row">
											<div class="col-md-12">
												<table id="table-foodcompany" class="table table-striped table-bordered table-datable" section="company">
													<thead>
														<tr>
															<th class="wd-15p border-bottom-0">Sr.No.</th>
															<th class="wd-15p border-bottom-0">Name</th>
															<th class="wd-25p border-bottom-0">Email</th>
															<th class="wd-15p border-bottom-0">Recipe (Count) </th>
															<th class="wd-25p border-bottom-0">Status</th>
															<th class="wd-25p border-bottom-0">Payment Expiry Date</th>
															<th>Action</th>
														</tr>
													</thead>
													<tbody>
														<?php
														$i=1;
														foreach ($user_list['Restaurant chain'] as $user) {
														?>
															<tr>
																<td><?=$i;?></td>
																<td><?=$user['name'];?></td>
																<td><?=$user['email'];?></td>
																<td><?=$user['recipes_count'];?></td>
																<td>
																	<?php
																	if($user['is_active']==1)
																		echo 'Active';
																	else 
																		echo 'Inactive';
																	?>
																</td>
																<td><?=$user['payment_end_date'];?></td>
																<td>
																	<label class="custom-switch pl-0">
																 	<?php
										                                if($user['is_active']==1){
																 	?>
										                                <input type="checkbox" name="custom-switch-checkbox" data-id="<?=$user['id'];?>" class="custom-switch-input input-switch-box input-change-status" checked>
										                            <?php
										                            	}
										                            	else{
										                            ?>
										                                <input type="checkbox" name="custom-switch-checkbox" data-id="<?=$user['id'];?>" class="custom-switch-input input-switch-box input-change-status">
										                            <?php
										                            	}
										                            ?>
									                                <span class="custom-switch-indicator"></span>
									                                </label>
																</td>
															</tr>
														<?php
															$i++;
														}
														?>
														
													</tbody>
												</table>
												
											</div>
										</div>
									</div>
									<div class="tab-pane" id="tab-scool">
										<div class="row">
											<div class="col-md-12">
												<table id="table-induser" class="table table-striped table-bordered table-datable" section="school">
													<thead>
														<tr>
															<th class="wd-15p border-bottom-0">Sr.No.</th>
															<th class="wd-15p border-bottom-0">Name</th>
															<th class="wd-25p border-bottom-0">Email</th>
															<th class="wd-15p border-bottom-0">Recipe (Count) </th>
															<th class="wd-25p border-bottom-0">Status</th>
															<th class="wd-25p border-bottom-0">Payment Expiry Date</th>
															<th>Action</th>
														</tr>
													</thead>
													<tbody>
														<?php
														$i=1;
														foreach ($user_list['School'] as $user) {
														?>
															<tr>
																<td><?=$i;?></td>
																<td><?=$user['name'];?></td>
																<td><?=$user['email'];?></td>
																<td><?=$user['recipes_count'];?></td>
																<td>
																	<?php
																	if($user['is_active']==1)
																		echo 'Active';
																	else 
																		echo 'Inactive';
																	?>
																</td>
																<td><?=$user['payment_end_date'];?></td>
																<td>
																	<label class="custom-switch pl-0">
																 	<?php
										                                if($user['is_active']==1){
																 	?>
										                                <input type="checkbox" name="custom-switch-checkbox" data-id="<?=$user['id'];?>" class="custom-switch-input input-switch-box input-change-status" checked>
										                            <?php
										                            	}
										                            	else{
										                            ?>
										                                <input type="checkbox" name="custom-switch-checkbox" data-id="<?=$user['id'];?>" class="custom-switch-input input-switch-box input-change-status">
										                            <?php
										                            	}
										                            ?>
									                                <span class="custom-switch-indicator"></span>
									                                </label>
																</td>
															</tr>
														<?php
															$i++;
														}
														?>
														
													</tbody>
												</table>
												
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- The Modal -->
<div class="modal" id="showrestmenu">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Restaurant Menu Authority</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
      	<form action="#" method="post">
      		<div class="row">
      			<div class="col-lg-12 col-md-12 col-sm-12 col-12" id="showhiidenid"></div>
      			<div class="col-lg-12 col-md-12 col-sm-12 col-12">
      				<div class="row" id="showcheckbox">
      					<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">
      						<input type="checkbox" data-id="Profile" name="menu[]" value="Profile" class="menu"> Profile
      					</div>
      					<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">
      						<input type="checkbox" data-id="Dashboard" name="menu[]" value="Dashboard" class="menu"> Dashboard
      					</div>
      					<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">
      						<input type="checkbox" data-id="Menu" name="menu[]" value="Menu" class="menu"> Menu
      					</div>
      					<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">
      						<input type="checkbox" data-id="Order" name="menu[]" value="Order" class="menu"> Order
      					</div>
      					<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">
      						<input type="checkbox" data-id="Table Management" name="menu[]" value="Table Management" class="menu"> Table Management
      					</div>
      					<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">
      						<input type="checkbox" data-id="User Management" name="menu[]" value="User Management" class="menu"> User Management
      					</div>
      					<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">
      						<input type="checkbox" data-id="Waitinglist" name="menu[]" value="Waitinglist" class="menu"> Waitinglist
      					</div>
      					<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">
      						<input type="checkbox" data-id="Payment" name="menu[]" value="Payment" class="menu"> Payment
      					</div>
      					<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">
      						<input type="checkbox" data-id="Help" name="menu[]" value="Help" class="menu"> Help
      					</div>
      				</div>
      			</div>
      			<div class="col-lg-12 col-md-12 col-sm-12 col-12"><hr></div>
      			<div class="col-lg-12 col-md-12 col-sm-12 col-12 text-right">
      				<input type="button" name="" value="Save" class="btn btn-primary" id="save_menu_authority">
      			</div>
      		</div>
      	</form>
      </div>

    </div>
  </div>
</div>
		
	</div>

	
	<?php
require_once('footer.php');
?>
<script type="text/javascript">
	var show="<?php if(isset($_GET['show'])) echo $_GET['show']; else echo '';?>";
	var company_id="<?php if(isset($_GET['company_id'])) echo $_GET['company_id']; else echo '';?>";
	if(show=="individual")
		$('[href="#tab-induser"]').trigger('click');
	if(show=="restaurant")
		$('[href="#tab-indrest"]').trigger('click');
	if(show=="burger")
		$('[href="#tab-burger"]').trigger('click');
	if(show=="company"){
		if(company_id){
			$('#select-food-company').val(company_id);
			loadDatatable(company_id);
		}
		$('[href="#tab-foodcmp"]').trigger('click');
	}
	if(show=="school")
		$('[href="#tab-scool"]').trigger('click');

	$('.table-datable').on('click','.input-change-category',function(){
		var section=$(this).closest('.table-datable').attr('section');
		if($(this).is(':checked'))
            $(this).val("on");
        else
            $(this).val("off");

        var self=this;
        var data_id=$(this).attr('data-id');
        var formData={
            id : data_id,
            is_active:$(this).val()
        } 
        $.ajax({
            url: "<?=base_url();?>admin/change_iscategory_status",
            type:'POST',
            data:formData ,
            success: function(result){
               if (result.status) {
           			if(section=="individual")
               			window.location.href="<?=base_url()?>admin/users?show=individual";
					if(section=="restaurant")
               			window.location.href="<?=base_url()?>admin/users?show=restaurant";
					if(section=="burger")
               			window.location.href="<?=base_url()?>admin/users?show=burger";
					if(section=="company"){
               			window.location.href="<?=base_url()?>admin/users?show=company&company_id="+$('#select-food-company').val();
					}
					if(section=="school")
               			window.location.href="<?=base_url()?>admin/users?show=school";

               }
               else{
                    displaywarning("Something went wrong please try again");
               }
            }
        });
	});

	$('.table-datable').on('click','.input-change-alacalc',function(){
		var section=$(this).closest('.table-datable').attr('section');
		if($(this).is(':checked'))
            $(this).val("on");
        else
            $(this).val("off");

        var self=this;
        var data_id=$(this).attr('data-id');
        var formData={
            id : data_id,
            is_active:$(this).val()
        } 
        $.ajax({
            url: "<?=base_url();?>admin/change_alacalc_status",
            type:'POST',
            data:formData ,
            success: function(result){
               if (result.status) {
           			if(section=="individual")
               			window.location.href="<?=base_url()?>admin/users?show=individual";
					if(section=="restaurant")
               			window.location.href="<?=base_url()?>admin/users?show=restaurant";
					if(section=="burger")
               			window.location.href="<?=base_url()?>admin/users?show=burger";
					if(section=="company"){
               			window.location.href="<?=base_url()?>admin/users?show=company&company_id="+$('#select-food-company').val();
					}
					if(section=="school")
               			window.location.href="<?=base_url()?>admin/users?show=school";

               }
               else{
                    displaywarning("Something went wrong please try again");
               }
            }
        });
	});

	$('.table-datable').on('click','.input-change-status',function(){
		var section=$(this).closest('.table-datable').attr('section');
		if($(this).is(':checked'))
            $(this).val("on");
        else
            $(this).val("off");

        var self=this;
        var data_id=$(this).attr('data-id');
        var formData={
            id : data_id,
            is_active:$(this).val()
        } 
        $.ajax({
            url: "<?=base_url();?>admin/change_user_status",
            type:'POST',
            data:formData ,
            success: function(result){
               if (result.status) {
           			if(section=="individual")
               			window.location.href="<?=base_url()?>admin/users?show=individual";
					if(section=="restaurant")
               			window.location.href="<?=base_url()?>admin/users?show=restaurant";
					if(section=="burger")
               			window.location.href="<?=base_url()?>admin/users?show=burger";
					if(section=="company"){
               			window.location.href="<?=base_url()?>admin/users?show=company&company_id="+$('#select-food-company').val();
					}
					if(section=="school")
               			window.location.href="<?=base_url()?>admin/users?show=school";

               }
               else{
                    displaywarning("Something went wrong please try again");
               }
            }
        });
	});
	$('.table-datable').DataTable();
	$('#select-food-company').on('change',function(){
		/*$.ajax({
            url: User.base_url+"admin/company_users/"+$(this).val(),
            type:'POST',
            data:{} ,
            success: function(result){
              
            }
        });*/
        loadDatatable($('#select-food-company').val());
	});
	function loadDatatable(company_id){
		$('#table-foodcompany').dataTable().fnDestroy();
        data = {
                "action": "datatable"
            };
        Table = $( '#table-foodcompany' ).DataTable( {
            "processing": true,
            "language": {
                "processing": "Hang on. Waiting for response..." //add a loading image,simply putting <img src="loader.gif" /> tag.
            },
            "serverSide": false,
            "deferRender": true,
            "columnDefs": [ {
                "targets": [ -1 ],
                "orderable": false,
                "searchable": true,
            } ],
            "order": [
                [ 1, 'asc' ]
            ],
            "lengthMenu": [
                [ 10, 50, 100, 500 ],
                [ 10, 50, 100, 500 ]
            ],
            "ajax": {
                url: "<?=base_url();?>admin/company_users/"+company_id,
                dataType: 'json',
                type: "POST",
                // method  , by default get
                data: data,
                error: function( res ) {
                    //$( "#error-msg" ).html( res );
                    console.log( res.responseText );
                    //$( "#msg" ).html( res.responseText );
                    $( "#datatable").append( '<tbody class="datatable_error"><tr><th colspan="10">No data found in the server</th></tr></tbody>' );
                    $( "#datatable_processing" ).css( "display", "none" );
                }
            }
        });
        $( '.datatable_error' ).hide();
	}

	function displaysucess(msg)
    {
        swal("Success !",msg,"success");
    }

    function displaywarning(msg)
    {
        swal("Error !",msg,"error");
    }

    function displaysucessconfrim(msg)
    {
        swal({
            title:"Success !", 
            text:msg, 
            type:"success",
            confirmButtonClass: "btn-primary",
            confirmButtonText: "Ok",
            closeOnConfirm: false
        }).then(function(){
            window.location.href=Login.base_url+"users/dashboard";
        })
    }
    function displaywarningconfrim(msg)
    {
         swal({
                title:"Error !", 
                text:msg, 
                type:"error",
                confirmButtonClass: "btn-primary",
                confirmButtonText: "Ok",
                closeOnConfirm: false
            }).then(function(){
                window.location.href="";
        })  
    }

    $('.get_rest_id').click(function(){
    	$(".menu").removeAttr("checked");
    	var a = $(this).attr('data-id');
    	$('#showhiidenid').html('<input type="hidden" name="restaurant_id" value="'+a+'" id="rest_id">');
    	$.ajax({
            url: "<?=base_url();?>admin/show_authority_restaurant",
            type:'POST',
            data:{restaurant_id : $('#rest_id').val() },
            success: function(result){
            	if(result.length > 0){
            	var str = result[0].menu_name;
				var getmenu = str.split(',');
				//console.log(getmenu);
				for(i in getmenu)
				{
					$(':checkbox[data-id="'+getmenu[i]+'"]').attr( "checked","checked");
				}
			
            	}
            }
        });
    });

    $('#save_menu_authority').click(function(){
    	var section=$(this).closest('.table-datable').attr('section');
    	var myarray = [];
    	$('.menu:checked').each(function () { 
    		var menu = $(this).attr('value');
    		myarray.push(menu);
    	}); 
    	$.ajax({
            url: "<?=base_url();?>admin/menu_authority",
            type:'POST',
            data:{restaurant_id : $('#rest_id').val(),menu:myarray},
            success: function(result){
            	$('#showrestmenu').modal('hide');
            	displaysucess("Authority set successfully");
               if (result.status) {
           			if(section=="individual")
               			window.location.href="<?=base_url()?>admin/users?show=individual";
					if(section=="restaurant")
               			window.location.href="<?=base_url()?>admin/users?show=restaurant";
					if(section=="burger")
               			window.location.href="<?=base_url()?>admin/users?show=burger";
					if(section=="company"){
               			window.location.href="<?=base_url()?>admin/users?show=company&company_id="+$('#select-food-company').val();
					}
					if(section=="school")
               			window.location.href="<?=base_url()?>admin/users?show=school";
               }
               else{
                    displaywarning("Something went wrong please try again");
               }
            }
        });
    })
</script>