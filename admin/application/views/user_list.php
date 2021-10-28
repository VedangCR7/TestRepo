<?php
require_once('header.php');
require_once('sidebar.php');

?>
<style type="text/css">
	
	
</style>
<div class=" app-content">
	<div class="side-app">

		<!--Page Header-->
		<div class="page-header">
			<h3 class="page-title"><i class="side-menu__icon fas fa-utensils mr-1"></i> Users</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Users</li>
			</ol>
		</div>
		<!--Page Header-->
	</div>
	<div class="row mb-3 row-filter">
		<div class="col-md-2">
			<a href="javascript:;" class="btn btn-secondary btn-add-user" style="float: right;width: 100%;"><i class="fa fa-plus"></i> New User</a>
		</div>
		<div class="col-md-5">
			<div class="input-group">
				<input type="text" class="form-control" placeholder="Search user"  id="searchUserInput" style="">
				<span class="input-group-append">
					<button class="btn btn-primary" type="button" style="border-radius: 0px;"><i class="fas fa-search"></i></button>
				</span>
			</div>
		</div>
		<div class="col-md-2 p-l-5 p-r-5">
			<div class="btn-group per_page m-r-5">
				<button class="btn btn-default dropdown-toggle" data-toggle="dropdown" type="button" aria-expanded="false" selected-per-page="30">
					30 items per page
					<i class="md md-arrow-drop-down"></i>
				</button>
				<ul class="dropdown-menu pull-right" role="menu">
					<li class=""><a data-per="15" class="a-user-perpage" data-preferences='{"per_page":"15"}' href="javascript:;">15</a></li>
					<li class=""><a data-per="30" class="a-user-perpage" data-preferences='{"per_page":"30"}' href="javascript:;">30</a></li>
					<li class=""><a data-per="60" class="a-user-perpage" data-preferences='{"per_page":"60"}' href="javascript:;">60</a></li>
					<li class=""><a data-per="all" class="a-user-perpage" data-preferences='{"per_page":"all"}' href="javascript:;">All (<span class="span-all-users"></span>)</a></li>
				</ul>
			</div>
		</div>
		<div class="col-md-3 p-l-15">
			<div class="btn-group page_links page-no" role="group" style="width: 100%;">
				<button class="btn btn-default btn-prev disabled prev" data-page="prev" type="button">
					<span class="fas fa-angle-left"></span>
				</button>
				<button class="btn btn-default" style="width: 55%;"><b class="span-page-html">0-0</b> of <b class="span-all-users">0</b></button>
				<buton class="btn btn-default btn-next disabled next" data-page="next" type="button">
					<span class="fas fa-angle-right"></span>
				</buton>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<div class="table-responsive">
						<table class="table card-table table-vcenter text-nowrap table-head" id="table-users">
							<thead >
								<tr>
									<th>Name</th>
									<th>Email</th>
									<th>Date</th>
									<th></th>
									<th></th>
								</tr>
							</thead>
							<tbody class="tbody-user-list">
								<!-- <?php
									foreach ($users as $user) {
								?>
									<tr style="<?php if($user['is_reg_payment']==1) echo 'background-color: lightpink;'; else '';?>">
										<td><?=$user['name'];?></td>
										<td><?=$user['email'];?></td>
										<td><?=$user['register_date'];?></td>
										<?php
											if($user['is_reg_payment']==1){
										?>
										<td><a href="javascript:;" class="btn btn-outline-primary">Payment</a></td>
										<?php
											}else{
										?>
										<td></td>
										<?php
											}
										?>
										<td><i class="fas fa-trash"></i></td>
									</tr>
								<?php
									}
								?> -->
								
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		
	</div>
<div class="modal fade" id="modal-new-user" tabindex="-1" role="dialog"  aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="example-Modal3">New User</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="post" id="form-user" action="javascript:;">
				<div class="modal-body">
						<div class="form-group">
							<label for="name" class="form-control-label">Contact Pearson Name</label>
							<input type="text" class="form-control" id="name" name="name" required="" placeholder="Enter restaurant name">
							<!-- <div class="invalid-feedback">Invalid feedback</div> -->
						</div>
						<div class="form-group">
							<label for="name" class="form-control-label">Restaurant  Name</label>
							<input type="text" class="form-control" id="business_name" name="business_name" required="" placeholder="Enter restaurant name">
							<!-- <div class="invalid-feedback">Invalid feedback</div> -->
						</div>
						<div class="form-group">
							<label for="email" class="form-control-label">Email Id </label>
							<input type="email" class="form-control" id="email" name="email" required="" placeholder="Enter email id">
						</div>
						<div class="form-group">
							<label for="password" class="form-control-label">Password </label>
							<input type="password" class="form-control" id="password" name="password" minlength="8" maxlength="30" required="" placeholder="Enter password">
							<span toggle="#password" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>
						</div>
						<div class="form-group">
							<label for="cpassword" class="form-control-label">Confirm Password </label>
							<input type="password" class="form-control" id="cpassword" name="cpassword" required="" minlength="8" maxlength="30" placeholder="Enter password to confirm">
							<span toggle="#cpassword" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>
						</div>
				</div>
				<div class="modal-footer">
					<div class="col-md-12">
						<div class="col-md-3 mr-2">
						</div>
						<div class="col-md-6">
							<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
							<button type="submit" class="btn btn-secondary">Create</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<?php
require_once('footer.php');
?>
<script type="text/javascript" src="<?=base_url();?>assets/js/custom/User.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        User.base_url="<?=base_url();?>";
        User.user_status="<?php if(isset($_GET['status'])) echo $_GET['status']; else echo '';?>";
        User.init();
        $("#form-user").validate({
		    rules: {
		    	name: {
			        required: true
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
		    messages: {
				name: "Please enter restaurant name",
				email: "Please enter a valid email address",
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
		    },
		    submitHandler: function(form) {
		      form.submit();
		    }
		});
    });
</script>
<script type="text/javascript">
	
	function searchFunction() {
	  var input, filter, table, tr, td, i, txtValue;
	  input = document.getElementById("searchInput");
	  filter = input.value.toUpperCase();
	  table = document.getElementById("table-users");
	  tr = table.getElementsByTagName("tr");
	  for (i = 0; i < tr.length; i++) {
	    td = tr[i].getElementsByTagName("td")[0];
	    if (td) {
	      txtValue = td.textContent || td.innerText;
	      if (txtValue.toUpperCase().indexOf(filter) > -1) {
	        tr[i].style.display = "";
	      } else {
	        tr[i].style.display = "none";
	      }
	    }       
	  }
	}
</script>