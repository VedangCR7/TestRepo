<?php
require_once('header.php');
require_once('sidebar.php');
?>
<style>
/* .datetime-reset-button {
  color: inherit;
  fill: currentColor;
  opacity: 0 !important;
  background-color: transparent;
  border: none;
  flex: none;
  padding-inline : 2px;
  display:none !important;
} */

</style>
<div class=" app-content">
	<div class="side-app">
		<!--Page Header-->
		<div class="page-header">
			<h3 class="page-title"><i class="fe fe-home mr-1"></i> Orders</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Orders</li>
			</ol>
		</div>
		
	</div>
	<div class="row">
		<div class="col-md-12" style="min-height: 450px;">
			<div class="card">
				<div class="card-body">
					<form action="<?=base_url()?>reports/order_summary" method="post">
					<div class="row">
						<div class="col-lg-4 col-md-4 col-sm-6 col-6">
							
							<label>From Date</label>
							<input type="date" max="<?=date('Y-m-d')?>" name="from_date" value="<?=($_POST['from_date']) ? $_POST['from_date'] : date('Y-m-d')?>" class="form-control" required>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-6 col-6">
							<label>To Date</label>
							<input type="date" max="<?=date('Y-m-d')?>" name="to_date" required value="<?=($_POST['to_date']) ? $_POST['to_date'] : date('Y-m-d')?>" class="form-control">
						</div>
						<div class="col-lg-4 col-md-4 col-sm-6 col-6">
							<input type="submit" name="search" value="Search" class="btn btn-primary" style="margin-top:25px;">
						</div>
					</div>
					</form>
					<div class="table-responsive mt-4 table-single-orders" >
						<table class="datatable-withbuttons table table-striped dt-responsive nowrap" id="table-orders">
							<thead>
								<tr>
									<th>Sr.No</th>
									<th>Order No.</th>
									<th>Cust. Name</th>
									<th>Table No.</th>
									<th>Date</th>
									<th>Total</th>
								</tr>
							</thead>
							<tbody class="tbody-order-list">
								<?php
								$i=1;
								foreach ($order_summary as $order) {
								?>
								<tr>
									<td><?=$i?></td>
									<td><?=$order['order_no'];?></td>
									<td><?=$order['customer_name'];?></td>
									<td><?=$order['table_no'];?></td>
									<td><?=$order['order_date'];?></td>
									<td><?=$currency_symbol[0]['currency_symbol']?> <?=$order['net_total'];?></td>
								</tr>
								<?php
								$i++;
									# code...
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
                    data: {name:'Reports'},
                    success: function(result){
                        if(result.status){
                            window.location.href="<?=base_url();?>restaurant/dashboard";
                        }
                   	}
                });
            },5000);
</script>
<?php
require_once('footer.php');
?>

<script>
	$(document).ready(function(){
		var count = '<?php echo count($order_summary);?>';
		if(count <= 0){
			$('.btn-group').hide();
		}
	});
    var report_title='Order Summary Report';
    Common.datatablewithButtons(report_title,' Order Summary Report');
</script>

<?php
        if ($this->session->flashdata('success')) {
            echo "<script>swal('success','" . $this->session->flashdata('success') . "','success')</script>";
        }
        if ($this->session->flashdata('danger')) {
            echo "<script>swal('Error','" . $this->session->flashdata('danger') . "','error')</script>";
        }
        ?>