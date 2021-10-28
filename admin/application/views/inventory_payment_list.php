<?php
require_once('header.php');
require_once('sidebar.php');
date_default_timezone_set("Asia/Kolkata");
?>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<div class=" app-content">
	<div class="side-app">
		<!--Page Header-->
		<div class="page-header">
			<h3 class="page-title"><i class="fe fe-home mr-1"></i> Payment List</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Payment List</li>
			</ol>
		</div>
		
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
                <div class="card-header">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12 text-right">
                        <a href="<?=base_url()?>inventory/payment_create"><button class="btn btn-primary"><i class="fas fa-plus"></i> Create Payment</button></a>
                    </div>
                </div>
				<div class="card-body">
					<div class="table-responsive mt-4 table-single-orders">
						<table class="datatable-withbuttons table table-striped dt-responsive nowrap" id="table-orders">
							<thead >
								<tr>
									<th>Sr No.</th>
									<th>Date</th>
                                    <th>Supplier</th>
                                    <th>Cheque no , cheque date</th>
                                    <th>Type</th>
                                    <th>Payable Amount</th>
                                    <th>Paid Amount</th>
                                    <th>Discount Amount</th>
                                    <th>Total Amount</th>
								</tr>
							</thead>
							<tbody class="tbody-order-list">
								<?php
								$i=1;
								foreach ($payment_details as $item) {
								?>
								<tr>
									<td><?=$i++?></td>
									<td><?=$item['payment_date'];?></td>
                                    <td><?=$item['company_name'];?></td>
                                    <td><?=$item['payment_details'] .','.$item['cheque_date'];?></td>
                                    <td><?=$item['payment_type'];?></td>
                                    <td><?=$item['payable_amount'];?></td>
                                    <td><?=$item['paid'];?></td>
                                    <td><?=$item['discount'];?></td>
                                    <td><?=$item['total'];?></td>
								</tr>
								<?php
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
	setInterval(function() {
                $.ajax({
                    url: "<?=base_url();?>restaurant/set_authority_exist",
                    type:'POST',
                    dataType: 'json',
                    data: {name:'Inventory Management'},
                    success: function(result){
                        if(result.status){
                            window.location.href="<?=base_url();?>restaurant/dashboard";
                        }
                   	}
                });
            },5000);
</script>

<?php
        if ($this->session->flashdata('success')) {
            echo "<script>swal('success','" . $this->session->flashdata('success') . "','success')</script>";
        }
        if ($this->session->flashdata('danger')) {
            echo "<script>swal('danger','" . $this->session->flashdata('danger') . "','error')</script>";
        }
        ?>
<?php
require_once('footer.php');
?>
<script>
    var report_title='Payment List';
    Common.datatablewithButtons(report_title,'Payment List');
</script>