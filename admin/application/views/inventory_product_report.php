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
			<h3 class="page-title"><i class="fe fe-home mr-1"></i> Product Report</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Product Report</li>
			</ol>
		</div>
		
	</div>
	<div class="row">
		<div class="col-md-12" style="min-height: 450px;">
			<div class="card">
				<div class="card-body">
					<form action="<?=base_url()?>inventory/product_report" method="post">
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
									<th>Product Name</th>
									<th>Pur. Qty</th>
									<th>Pur. Price</th>
									<th>Pur. total</th>
									<th>Ass.Kit.Qty</th>
                                    <th>Avl.Qty</th>
								</tr>
							</thead>
							<tbody class="tbody-order-list">
								<?php
								$i=1;
								foreach ($product as $order) {
								?>
								<tr>
									<td><?=$i?></td>
									<td><?=$order['product_name'];?></td>
									<td><?=$order['pur_qty'];?></td>
									<td>&#8377; <?=$order['pur_price'];?></td>
									<td>&#8377; <?=$order['pur_qty']*$order['pur_price'];?></td>
									<td><?=$order['assign_quantity'];?></td>
                                    <td><?=$order['remaining_quantity'];?></td>
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
	<script>
	setInterval(function() {
                $.ajax({
                    url: "<?=base_url();?>restaurant/set_authority_exist",
                    type:'POST',
                    dataType: 'json',
                    data: {name:'Inventory Report'},
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
		var count = '<?php echo count($product);?>';
		if(count <= 0){
			$('.btn-group').hide();
		}
	});
    var report_title='Product Report';
    Common.datatablewithButtons(report_title,' Product Report');
</script>

<?php
        if ($this->session->flashdata('success')) {
            echo "<script>swal('success','" . $this->session->flashdata('success') . "','success')</script>";
        }
        if ($this->session->flashdata('danger')) {
            echo "<script>swal('Error','" . $this->session->flashdata('danger') . "','error')</script>";
        }
        ?>