<?php
require_once('header.php');
require_once('sidebar.php');
?>

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
					<div class="card-title">Revenue Details</div>
				</div>
				<div class="card-body">
					<div class="table-responsive ">
						<table id="example-2" class="table table-striped table-bordered">
							<thead>
								<tr>
									<th class="wd-15p border-bottom-0">No.</th>
									<th class="wd-15p border-bottom-0">Restaurant Name</th>
									<th class="wd-15p border-bottom-0" data-orderable="false">Email</th>
									<th class="wd-20p border-bottom-0">Today's Revenue</th>
									<th class="wd-10p border-bottom-0">Total Revenue</th>
								</tr>
							</thead>
							<tbody>
								<?php $i =1; foreach ($revenuedata as $user){?>
								<tr>
									<td><?php echo $i;?></td>
									<td><?php echo ucwords($user->name);?></td>
									<td><?php echo $user->email;?></td>
									<td><?php echo $user->tdcnt;?></td>
									<td><?php echo $user->earning;?></td>
								</tr>
								<?php $i=$i+1; }?>
							</tbody>
						</table>
						
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
</script>