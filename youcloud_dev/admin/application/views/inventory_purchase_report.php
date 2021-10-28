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
	@page { margin: 0mm; }
</style>
<div class=" app-content">
	<div class="side-app">
		<!--Page Header-->
		<div class="page-header">
			<h3 class="page-title"><i class="fe fe-home mr-1"></i> Purchase Report</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Purchase Report</li>
			</ol>
		</div>
		
	</div>
	<div class="row">
		<div class="col-md-12" style="min-height: 450px;">
			<div class="card">
				<div class="card-body">
					<form action="<?=base_url()?>inventory/purchase_report" method="post">
					<div class="row">
						<div class="col-lg-3 col-md-3 col-sm-6 col-6">
							
							<label>From Date</label>
							<input type="date" max="<?=date('Y-m-d')?>" name="from_date" value="<?=($_POST['from_date']) ? $_POST['from_date'] : date('Y-m-d')?>" class="form-control" required>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-6 col-6">
							<label>To Date</label>
							<input type="date" max="<?=date('Y-m-d')?>" name="to_date" required value="<?=($_POST['to_date']) ? $_POST['to_date'] : date('Y-m-d')?>" class="form-control">
						</div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-6">
							<label>Supplier</label>
                            <select class="form-control" name="supplier_id">
                                <option value="">Select Supplier</option>
                                <?php foreach($supplier as $key => $value){ ?>
                                    <option value="<?=$value['id']?>"><?=$value['company_name']?></option>
                                <?php } ?>
                            </select>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-6 col-6">
							<input type="submit" name="search" value="Search" class="btn btn-primary" style="margin-top:25px;">
						</div>
					</div>
					</form>
					<div class="table-responsive mt-4 table-single-orders" >
						<table class="datatable-withbuttons table table-striped dt-responsive nowrap" id="table-orders">
							<thead>
								<tr>
									<th>Sr.No</th>
									<th>Purchase No</th>
									<th>Supplier</th>
									<th>No of product</th>
									<th>Quantity</th>
									<th>Grand Total</th>
								</tr>
							</thead>
							<tbody class="tbody-order-list">
								<?php
								$i=1;
								foreach ($purchase_details as $order) {
								?>
								<tr>
									<td><?=$i?></td>
									<td><?=$order['purchase_order_no'];?></td>
									<td><?=$order['company_name'];?></td>
									<td><?=$order['no_of_product'];?></td>
									<td><?=$order['no_of_quantity'];?></td>
									<td>&#8377; <?=$order['grand_total'];?></td>
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
		var count = '<?php echo count($purchase_details);?>';
		if(count <= 0){
			$('.btn-group').hide();
		}
	});
    var report_title='Purchase Report';
    Common.datatablewithButtons(report_title,' Purchase Report');
</script>

<?php
        if ($this->session->flashdata('success')) {
            echo "<script>swal('success','" . $this->session->flashdata('success') . "','success')</script>";
        }
        if ($this->session->flashdata('danger')) {
            echo "<script>swal('Error','" . $this->session->flashdata('danger') . "','error')</script>";
        }
        ?>