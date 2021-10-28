<?php include('header.php'); include('sidebar.php'); ?>
<div class=" app-content">
	<div class="side-app">

		<!--Page Header-->
		<div class="page-header">
			<h3 class="page-title"><i class="fe fe-user mr-1"></i> Takeaway Order</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?=base_url();?>admin">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Takeaway Order</li>
			</ol>
		</div>
		<!--Page Header-->
		<div class="row">
			<div class="col-lg-12 col-md-12">
				<div class="card">
					<div class="card-header">
						<div class="col-lg-6 col-md-6 col-sm-6 col-6"><h3 class="card-title" >Takeaway Order</h3></div>
					</div>

					<div class="card-body">
						<div class="row">
							<div class="col-md-12">
								<table id="example" class="table table-striped table-bordered table-datable" section="individual">
									<thead>
										<tr>
											<th class="wd-15p border-bottom-0">Sr.No.</th>
											<th class="wd-15p border-bottom-0">Order No.</th>
											<th class="wd-15p border-bottom-0">Status</th>
											<th class="wd-15p border-bottom-0">Amount</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
									<?php
									$i=1;
									foreach ($all_orders as $user) {
									?>
										<tr>
											<td><?=$i;?></td>
											<td><?=$user['order_no']?></td>
											<td><?=$user['status']?></td>
											<td><?=$user['net_total']?></td>
											<td>
											<?php if($user['is_invoiced']=='1') {?>
												<a href="<?=base_url()?>restaurant/onlineorder/<?=$user['id']?>/<?=$user['table_orders_id']?>/<?=$user['invoice_id']?>/tableorders"><i class="fas fa-eye text-primary"></i></a></td>
											<?php } else{?>
												<a href="<?=base_url()?>restaurant/onlineorder/<?=$user['id']?>/<?=$user['table_orders_id']?>"><i class="fas fa-eye text-primary"></i></a></td>
											<?php } ?>
											</tr>
									
									<?php $i=$i+1; } ?>					
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

<script>
	
$(document).ready(function() {
    $('#example').DataTable();
} );
</script>
<?php include('footer.php'); ?>