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
			<h3 class="page-title"><i class="fe fe-home mr-1"></i> Supplier Report</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Supplier Report</li>
			</ol>
		</div>
		
	</div>
	<div class="row">
		<div class="col-md-12" style="min-height: 450px;">
			<div class="card">
				<div class="card-body">
					<form action="<?=base_url()?>inventory/supplier_report" method="post">
					<div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-6 col-6">
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
									<th>Supplier Name</th>
									<th>Organiation Name</th>
									<th>Total Purchase</th>
									<th>Total Paid</th>
                                    <th>Discount</th>
									<th>Balance</th>
								</tr>
							</thead>
							<tbody class="tbody-order-list">
								<?php
								$i=1;
								foreach ($supplier_details as $order) {
								?>
								<tr>
									<td><?=$i?></td>
									<td><?=$order['supplier_name'];?></td>
									<td><?=$order['organization_name'];?></td>
									<td><?=$order['total_purchase'];?></td>
									<td><?=$order['payment'];?></td>
									<td><?=$order['discount'];?></td>
                                    <td><?=$order['balance'];?></td>
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
		var count = '<?php echo count($supplier_details);?>';
		if(count <= 0){
			$('.btn-group').hide();
		}
	});
    var report_title='Supplier Report';
    Common.datatablewithButtons(report_title,' Supplier Report');
</script>

<?php
        if ($this->session->flashdata('success')) {
            echo "<script>swal('success','" . $this->session->flashdata('success') . "','success')</script>";
        }
        if ($this->session->flashdata('danger')) {
            echo "<script>swal('Error','" . $this->session->flashdata('danger') . "','error')</script>";
        }
        ?>