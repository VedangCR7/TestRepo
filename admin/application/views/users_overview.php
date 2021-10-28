<?php
require_once('header.php');
require_once('sidebar.php');
?>
<style>
		.restaurantType {display:none;}
		</style>
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
						<div class="col-lg-6 col-md-6 col-sm-6 col-6"><h3 class="card-title" >Users</h3></div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-6 text-right"><button class="btn btn-primary" data-toggle="modal" data-target="#newusers"><i class="fas fa-plus"></i> Add New User</button></div>
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
															<th class="wd-15p border-bottom-0">Restaurant Name</th>
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
																<td><?=$user['business_name'];?></td>
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
											<div class="col-md-12 table-responsive">
												<table id="table-induser" class="table table-striped table-bordered table-datable table-restaurants" section="restaurant">
													<thead>
														<tr>
															<th class="wd-15p border-bottom-0">Sr.No.</th>
															<th class="wd-15p border-bottom-0">Restaurant Name</th>
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
																<td><?=$user['business_name'];?></td>
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
															<th class="wd-15p border-bottom-0">Restaurant Name</th>
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
																<td><?=$user['business_name'];?></td>
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
															<th class="wd-15p border-bottom-0">Restaurant Name</th>
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
																<td><?=$user['business_name'];?></td>
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
															<th class="wd-15p border-bottom-0">Restaurant Name</th>
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
																<td><?=$user['business_name'];?></td>
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



<!-- The Modal -->
<div class="modal" id="newusers">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add New Users</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form method="post" action="<?=base_url('admin/users')?>" id="register-form" name="registerform">
      <!-- Modal body -->
      <div class="modal-body">
        <div class="row">
													<div class="col-md-12">
														<div class="row">
														<div class="col-lg-6 col-md-6 form-group">
															<label class="form-label text-left" for="Regiter As">Register As <span >(*)</span></label>
															<select class="form-control" id="register_as" name="usertype" placeholder="Regiter As" required="" onchange="admSelectCheck(this);">
																<option value="">Select user type</option>
																<option id="admOption" value="Restaurant">Restaurant</option>
																<option id="admOption1" value="Burger and Sandwich">Burger and Sandwich</option>
																<option value="Restaurant chain">Restaurant chain</option>
																<option value="School">School and University</option>
																<option value="Individual User">Individual User (Family, Nutritionist, Gym, Recipe Website, etc.)</option>
															</select>
														</div>
														<div id="admDivCheck" class="col-lg-6 col-md-6 form-group restaurantType">
															<label class="form-label text-left" for="Restaurant Type">Restaurant Type <span >(*)</span></label>
															<select class="form-control" id="restaurant_type" name="restauranttype" placeholder="Restaurant Type" required="">
																<option value="">Select restaurant type</option>
																<option value="veg">Veg</option>
																<option value="nonveg">Non-veg</option>
																<option value="both">Veg / Non-veg</option>
															</select>
														</div>
														<div class="col-lg-6 col-md-6 form-group">
															<label class="form-label text-left" for="name">Contact Person <span >(*)</span></label>
															<input type="text" class="form-control" id="name" name="name" placeholder="Name"  required=""   maxlength="100" style="text-transform: capitalize;">
															<!-- <input type="text" class="form-control" id="Last_name" name="last_name" placeholder="Last Name" style="width: 49%;margin-right: 2px;" required=""> -->
														</div>
														<div class="col-lg-6 col-md-6 form-group">
															<label class="form-label text-left" for="business_name">Business Name <span >(*)</span></label>
															<input type="text" class="form-control" id="business_name" name="business_name" placeholder="Business Name"  required=""   maxlength="100" style="text-transform: capitalize;">
															<p style="text-align: left;margin-top: 5px;">If you are individual user you can enter your name</p>
															<!-- <input type="text" class="form-control" id="Last_name" name="last_name" placeholder="Last Name" style="width: 49%;margin-right: 2px;" required=""> -->
														</div>
														<div class="col-lg-6 col-md-6 form-group">
															<label class="form-label text-left" for="exampleInputEmail1">Email Address <span >(*)</span></label>
															<input type="email" class="form-control" id="exampleInputEmail1" name="email" placeholder="Enter email" required="">
														</div>
														<div class="col-lg-6 col-md-6 form-group">
															<label class="form-label text-left" for="password">Password <span >(*)</span></label>
															<input type="password" class="form-control password-input" id="password" name="password" placeholder="Password" required="" minlength="8" maxlength="30" >
															<span toggle="#password" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>
														</div>
														<div class="col-lg-6 col-md-6 form-group">
															<label class="form-label text-left" for="cpassword">Confirm Password <span >(*)</span></label>
															<input type="password" class="form-control password-input" id="cpassword" name="cpassword" placeholder="Confirm Password" required="" minlength="8" maxlength="30" >
															<span toggle="#cpassword" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>
														</div>
														</div>
													</div>
												</div>



      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <input type="submit" class="btn btn-primary" value="Add">
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

	$('.table-datable').on('click','.input-change-category',function()
	{
		var section=$(this).closest('.table-datable').attr('section');
		
		if($(this).is(':checked'))
            $(this).val("on");
        else
            $(this).val("off");

        var self=this;
        var data_id=$(this).attr('data-id');
		var formData=
		{
            id : data_id,
            is_active:$(this).val()
        } 
        
		$.ajax({
            url: "<?=base_url();?>admin/change_iscategory_status",
            type:'POST',
            data:formData ,
            success: function(result)
			{
               if (result.status) 
			   {
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
               else
			   {
                    displaywarning("Something went wrong please try again");
               }
            }
        });
	});

	$('.table-datable').on('click','.input-change-alacalc',function()
	{
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
            success: function(result)
			{
               if (result.status) 
			   {
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
               else
			   {
                    displaywarning("Something went wrong please try again");
               }
            }
        });
	});

	$('.table-datable').on('click','.input-change-status',function()
	{
		debugger;
		var section=$(this).closest('.table-datable').attr('section');
		var usertype='<?php $_SESSION['usertype']?>';
		
		if($(this).is(':checked'))
            $(this).val("on");
        else
            $(this).val("off");

        var self=this;
        var data_id=$(this).attr('data-id');
       
		var formData=
		{
            id : data_id,
            is_active:$(this).val(),
            section:section
        }
		
        $.ajax({
            url: "<?=base_url();?>admin/change_user_status",
            type:'POST',
            data:formData ,
            success: function(result)
			{
               if (result.status) 
			   {
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
					if(section=="Restaurant manager")
						window.location.href="<?=base_url();?>admin/users?show=restaurant";
               }
               else
			   {
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

    $('.table-datable').on('click','.get_rest_id',function(){
    	$(".menu").removeAttr("checked");
    	var a = $(this).attr('data-id');
    	$('#showhiidenid').html('<input type="hidden" name="restaurant_id" value="'+a+'" id="rest_id">');
    	$.ajax({
            url: "<?=base_url();?>admin/show_authority_restaurant",
            type:'POST',
            data:{restaurant_id : a },
            success: function(result){
            	if(result.length > 0){
            	var str = result[0].menu_name;
				var getmenu = str.split(',');
				
				var html = '<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">';
							if(getmenu.indexOf("Profile") !== -1) {
      						html +='<input type="checkbox" data-id="Profile" name="menu[]" checked disabled value="Profile" class="menu"> Profile';}
      						else{
      						html +='<input type="checkbox" data-id="Profile" name="menu[]" value="Profile" class="menu"> Profile';	
      						}
      					html +='</div>\
      					<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">';
      						if(getmenu.indexOf("Dashboard") !== -1) {
      						html+='<input type="checkbox" data-id="Dashboard" name="menu[]" checked disabled value="Dashboard" class="menu"> Dashboard';}
      						else {
      						html+='<input type="checkbox" data-id="Dashboard" name="menu[]" value="Dashboard" class="menu"> Dashboard';}
      					html +='</div>\
      					<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">';
      						if(getmenu.indexOf("Menu") !== -1) {
      						html+='<input type="checkbox" data-id="Menu" name="menu[]" checked value="Menu" class="menu"> Menu';}
      						else {
      						html+='<input type="checkbox" data-id="Menu" name="menu[]" value="Menu" class="menu"> Menu';}
      						
      					html +='</div>\
      					<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">';
      						if(getmenu.indexOf("Order") !== -1) {
      						html+='<input type="checkbox" data-id="Order" name="menu[]" value="Order" class="menu" checked> Order';}
      						else {
      						html+='<input type="checkbox" data-id="Order" name="menu[]" value="Order" class="menu"> Order';}
      					html +='</div>\
						<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">';
      						if(getmenu.indexOf("Online order") !== -1) {
      						html+='<input type="checkbox" data-id="Online order" name="menu[]" checked value="Online order" class="menu"> Online order';}
      						else {
      						html+='<input type="checkbox" data-id="Online order" name="menu[]" value="Online order" class="menu"> Online order';}
      					html +='</div>\
      					<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">';
      						if(getmenu.indexOf("Billing") !== -1) {
      						html+='<input type="checkbox" data-id="Billing" name="menu[]" value="Billing" class="menu" checked> Billing';}
      						else {
      						html+='<input type="checkbox" data-id="Billing" name="menu[]" value="Billing" class="menu"> Billing';}
      					html +='</div>\
      					<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">';
      						if(getmenu.indexOf("invoice") !== -1) {
      						html+='<input type="checkbox" data-id="invoice" name="menu[]" value="invoice" class="menu" checked> Invoice';}
      						else {
      						html+='<input type="checkbox" data-id="invoice" name="menu[]" value="invoice" class="menu"> Invoice';}
      					html +='</div>\
      					<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">';
      						if(getmenu.indexOf("Table Management") !== -1) {
      						html+='<input type="checkbox" data-id="Table Management" name="menu[]" checked value="Table Management" class="menu"> Table Management';}
      						else {
      						html+='<input type="checkbox" data-id="Table Management" name="menu[]" value="Table Management" class="menu"> Table Management';}
      					html +='</div>\
      					<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">';
      						if(getmenu.indexOf("User Management") !== -1) {
      						html+='<input type="checkbox" data-id="User Management" name="menu[]" checked value="User Management" class="menu"> User Management';}
      						else {
      						html+='<input type="checkbox" data-id="User Management" name="menu[]" value="User Management" class="menu"> User Management';}
      					html +='</div>\
      					<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">';
      						if(getmenu.indexOf("Waitinglist Manager") !== -1) {
      						html+='<input type="checkbox" data-id="Waitinglist Manager" name="menu[]" checked value="Waitinglist Manager" class="menu"> Waitinglist Manager';}
      						else {
      						html+='<input type="checkbox" data-id="Waitinglist Manager" name="menu[]" value="Waitinglist Manager" class="menu"> Waitinglist Manager';}
      					html +='</div>\
      					<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">';
      						if(getmenu.indexOf("Restaurant Manager") !== -1) {
      						html+='<input type="checkbox" data-id="Restaurant Manager" name="menu[]" checked value="Restaurant Manager" class="menu"> Restaurant Manager';}
      						else {
      						html+='<input type="checkbox" data-id="Restaurant Manager" name="menu[]" value="Restaurant Manager" class="menu"> Restaurant Manager';}
      					html +='</div>\
      					<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">';
      						if(getmenu.indexOf("Whatsapp Manager") !== -1) {
      						html+='<input type="checkbox" data-id="Whatsapp Manager" name="menu[]" checked value="Whatsapp Manager" class="menu"> Whatsapp Manager';}
      						else {
      						html+='<input type="checkbox" data-id="Whatsapp Manager" name="menu[]" value="Whatsapp Manager" class="menu"> Whatsapp Manager';}
      					html +='</div>\
      					<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">';
      						if(getmenu.indexOf("Customer") !== -1) {
      						html+='<input type="checkbox" data-id="Customer" name="menu[]" checked value="Customer" class="menu"> Customer';}
      						else {
      						html+='<input type="checkbox" data-id="Customer" name="menu[]" value="Customer" class="menu"> Customer';}
      					html +='</div>\
      					<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">';
      						if(getmenu.indexOf("Waitinglist") !== -1) {
      						html+='<input type="checkbox" data-id="Waitinglist" name="menu[]" checked value="Waitinglist" class="menu"> Waitinglist';}
      						else {
      						html+='<input type="checkbox" data-id="Waitinglist" name="menu[]" value="Waitinglist" class="menu"> Waitinglist';}
      					html +='</div>\
      					<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">';
      						if(getmenu.indexOf("Offers") !== -1) {
      						html+='<input type="checkbox" data-id="Offers" name="menu[]" value="Offers" class="menu" checked> Offers';}
      						else {
      						html+='<input type="checkbox" data-id="Offers" name="menu[]" value="Offers" class="menu"> Offers';}
      					html+='</div>\
      					<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">';
      						if(getmenu.indexOf("Reports") !== -1) {
      						html+='<input type="checkbox" data-id="Reports" name="menu[]" value="Reports" class="menu" checked> Reports';}
      						else {
      						html+='<input type="checkbox" data-id="Reports" name="menu[]" value="Reports" class="menu"> Reports';}
      					html+='</div>\
      					<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">';
      						if(getmenu.indexOf("Incentive") !== -1) {
      						html+='<input type="checkbox" data-id="Incentive" name="menu[]" checked value="Incentive" class="menu"> Incentive';}
      						else {
      						html+='<input type="checkbox" data-id="Incentive" name="menu[]" value="Incentive" class="menu"> Incentive';}
      					html +='</div>\
      					<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">';
      						if(getmenu.indexOf("Payment") !== -1) {
      						html+='<input type="checkbox" data-id="Payment" name="menu[]" checked value="Payment" class="menu"> Payment';}
      						else {
      						html+='<input type="checkbox" data-id="Payment" name="menu[]" value="Payment" class="menu"> Payment';}
      					html +='</div>\
						<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">';
      						if(getmenu.indexOf("Help") !== -1) {
      						html+='<input type="checkbox" data-id="Help" name="menu[]" value="Help" class="menu" checked> Help';}
      						else {
      						html+='<input type="checkbox" data-id="Help" name="menu[]" value="Help" class="menu"> Help';}
      					html+='</div>\
						<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">';
      						if(getmenu.indexOf("Inventory Management") !== -1) {
      						html+='<input type="checkbox" data-id="Inventory Management" name="menu[]" value="Inventory Management" class="menu" checked> Inventory Management';}
      						else {
      						html+='<input type="checkbox" data-id="Inventory Management" name="menu[]" value="Inventory Management" class="menu"> Inventory Management';}
      					html+='</div>\
						<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">';
      						if(getmenu.indexOf("Inventory Report") !== -1) {
      						html+='<input type="checkbox" data-id="Inventory Report" name="menu[]" value="Inventory Report" class="menu" checked> Inventory Report';}
      						else {
      						html+='<input type="checkbox" data-id="Inventory Report" name="menu[]" value="Inventory Report" class="menu"> Inventory Report';}
      					html+='</div>';
				$('#showcheckbox').html(html);
				// for(i in getmenu)
				// {
				// 	$(':checkbox[data-id="'+getmenu[i]+'"]').attr( "checked","checked");
				// }
    //         	else{
    //         		$('.menu').attr( "checked","checked");
    //         	}
			}
			else{
				$('#showcheckbox').html('<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">\
      						<input type="checkbox" data-id="Profile" name="menu[]" value="Profile" class="menu" checked disabled> Profile\
      					</div>\
      					<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">\
      						<input type="checkbox" data-id="Dashboard" name="menu[]" value="Dashboard" class="menu" checked disabled> Dashboard\
      					</div>\
      					<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">\
      						<input type="checkbox" data-id="Menu" name="menu[]" value="Menu" class="menu" checked> Menu\
      					</div>\
      					<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">\
      						<input type="checkbox" data-id="Order" name="menu[]" value="Order" class="menu" checked> Order\
      					</div>\
						<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">\
      						<input type="checkbox" data-id="Online order" name="menu[]" value="Online order" class="menu" checked> Online order\
      					</div>\
      					<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">\
      						<input type="checkbox" data-id="Billing" name="menu[]" value="Billing" class="menu" checked> Billing\
      					</div>\
      					<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">\
      						<input type="checkbox" data-id="invoice" name="menu[]" value="invoice" class="menu" checked> Invoice\
      					</div>\
      					<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">\
      						<input type="checkbox" data-id="Table Management" name="menu[]" value="Table Management" class="menu" checked> Table Management\
      					</div>\
      					<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">\
      						<input type="checkbox" data-id="User Management" name="menu[]" value="User Management" class="menu" checked> User Management\
      					</div>\
      					<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">\
      						<input type="checkbox" data-id="Waitinglist Manager" name="menu[]" value="Waitinglist Manager" class="menu" checked> Waitinglist Manager\
      					</div>\
      					<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">\
      						<input type="checkbox" data-id="Restaurant Manager" name="menu[]" value="Restaurant Manager" class="menu" checked> Restaurant Manager\
      					</div>\
      					<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">\
      						<input type="checkbox" data-id="Whatsapp Manager" name="menu[]" value="Whatsapp Manager" class="menu" checked> Whatsapp Manager\
      					</div>\
      					<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">\
      						<input type="checkbox" data-id="Customer" name="menu[]" value="Customer" class="menu" checked> Customer\
      					</div>\
      					<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">\
      						<input type="checkbox" data-id="Waitinglist" name="menu[]" value="Waitinglist" class="menu" checked> Waitinglist\
      					</div>\
      					<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">\
      						<input type="checkbox" data-id="Offers" name="menu[]" value="Offers" class="menu" checked> Offers\
      					</div>\
      					<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">\
      						<input type="checkbox" data-id="Payment" name="menu[]" value="Payment" class="menu"> Payment\
      					</div>\
      					<div class="col-lg-6 col-md-6 col-sm-12 col-12" style="margin-top:10px;">\
      						<input type="checkbox" data-id="Help" name="menu[]" value="Help" class="menu" checked> Help\
      					</div>');
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

    	if(myarray.length > 0){
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
    	}
    	else{
    		displaywarning("Please select at least one Authority");
    	}
    })
</script>

<script>
		function admSelectCheck(nameSelect)
		{
			if(nameSelect){
				admOptionValue = document.getElementById("admOption").value;
				admOptionValue1 = document.getElementById("admOption1").value;
				if((admOptionValue == nameSelect.value) || (admOptionValue1 == nameSelect.value)){
					document.getElementById("admDivCheck").style.display = "block";
				}
				else{
					document.getElementById("admDivCheck").style.display = "none";
				}
			}
			else{
				document.getElementById("admDivCheck").style.display = "none";
			}
		}
</script>
<script src="<?=base_url();?>assets/js/form-validation.js"></script>
<script type="text/javascript">
		    $(document).ready(function() 
			{		      	
		      	 $('.password-input').on('keypress',function(e){
		            if(e.which === 32) 
		        		return false;
		        });
		      	$('#name').on('keypress',function(e){
		      		var regex = new RegExp("^[a-zA-Z0-9 ]+$");
				    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
				    if (regex.test(str)) {
				        return true;
				    }
				    e.preventDefault();
				    return false;
		      	});
		      	$("#register-form").validate({
				    // Specify validation rules
				    rules: {
				      	usertype:"required",
				      	name: {
				      		required: true,
				        	maxlength: 100
				      	},
				      	business_name:{
				      		required: true,
				        	maxlength: 100
				      	},
				        email: {
					        required: true,
					        email: true
					    },
				      	password: {
					        required: true,
					        minlength: 8,
					        maxlength: 30
				      	},
				      	cpassword: {
					        required: true,
					        minlength: 8,
					        maxlength: 30
				      	}
				    },
				    // Specify validation error messages
				    messages: {
				    	usertype: "Please select usertype",
						name: "Please enter your name",
						business_name: "Please enter your business name",
						password: {
							required: "Please provide a password",
							minlength: "Passwords must be at least 8 and maximum 30 characters in length",
							maxlength:"Passwords must be at least 8 and maximum 30 characters in length"
						},
						cpassword: {
							required: "Please provide a password",
							minlength: "Passwords must be at least 8 and maximum 30 characters in length",
							maxlength:"Passwords must be at least 8 and maximum 30 characters in length"
						},
						email: "Please enter a valid email address"
				    },
				    // Make sure the form is submitted to the destination defined
				    // in the "action" attribute of the form when valid
				    submitHandler: function(form) {
				      form.submit();
				    }
				});
		    });

			$(".toggle-password").click(function() {
				$(this).toggleClass("fa-eye fa-eye-slash");
				var input = $($(this).attr("toggle"));
				if (input.attr("type") == "password") {
					input.attr("type", "text");
				} else {
					input.attr("type", "password");
				}
			});
		</script>

		<?php
        if ($this->session->flashdata('success')) {
            echo "<script>swal('success','" . $this->session->flashdata('success') . "','success')</script>";
        }
        if ($this->session->flashdata('danger')) {
            echo "<script>swal('danger','" . $this->session->flashdata('danger') . "','error')</script>";
        }
        ?>