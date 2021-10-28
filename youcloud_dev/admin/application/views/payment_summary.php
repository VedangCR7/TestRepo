<?php
require_once('header.php');
require_once('sidebar.php');
?>
<div class=" app-content">
	<div class="side-app">
		<!--Page Header-->
		<div class="page-header">
			<h3 class="page-title"><i class="fe fe-home mr-1"></i> Payment Summary</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Payment Summary</li>
			</ol>
		</div>
		
	</div>
	<div class="row">
		<div class="col-md-12" style="min-height: 450px;">
			<div class="card">
				<div class="card-body">
					<form action="<?=base_url()?>reports/payment_summary" method="post">
						<div class="row">
							<div class="col-lg-3 col-md-3 col-sm-6 col-6">
								<label>From Date</label>
								<input type="date" required max="<?=date('Y-m-d')?>" name="from_date" value="<?=($_POST['from_date']) ? $_POST['from_date'] : date('Y-m-d')?>" class="form-control">
							</div>
							<div class="col-lg-3 col-md-3 col-sm-6 col-6">
								<label>To Date</label>
								<input type="date" required max="<?=date('Y-m-d')?>" name="to_date" value="<?=($_POST['to_date']) ? $_POST['to_date'] : date('Y-m-d')?>" class="form-control">
							</div>
							<div class="col-lg-3 col-md-3 col-sm-6 col-6">
								<label>Payment Type</label>
								<!--<input type="text" name="takeaway_category" value="<?=($_POST['takeaway_category']) ? $_POST['takeaway_category'] : ''?>" class="form-control" placeholder="Takeaway Category">-->
								<select id="paymentType" name="paymentType" class="form-control">
									<option value="">Select Payment Type</option>
									<option value="CASH">CASH</option>
									<option value="CARD">CARD</option>
									<option value="UPI">UPI</option>									
									<option value="NET BANKING">NET BANKING</option>
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
									<th>Order No.</th>
									<th>Payment Type</th>
									<th>payment Amount</th>
									<th>Date</th>
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
									<td><?=$order['payment_type'];?></td>
									<td><?=$order['payment_amount'];?></td>
									<td><?=$order['updated_at'];?></td>
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
    var report_title='Payment Summary';
    Common.datatablewithButtons(report_title,'Payment Summary');
</script>

<?php
        if ($this->session->flashdata('success')) {
            echo "<script>swal('success','" . $this->session->flashdata('success') . "','success')</script>";
        }
        if ($this->session->flashdata('danger')) {
            echo "<script>swal('Error','" . $this->session->flashdata('danger') . "','error')</script>";
        }
        ?>