<?php
require_once('header.php');
require_once('sidebar.php');
?>
<div class=" app-content">
	<div class="side-app">
		<!--Page Header-->
		<div class="page-header">
			<h3 class="page-title"><i class="fe fe-home mr-1"></i> Revenue</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Revenue</li>
			</ol>
		</div>
		
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<form action="<?=base_url()?>reports/revenue_report" method="post">
					<div class="row">
						<div class="col-lg-4 col-md-4 col-sm-6 col-6">
							<label>From Date</label>
							<input type="date" required max="<?=date('Y-m-d')?>" name="from_date" value="<?=($_POST['from_date']) ? $_POST['from_date'] : date('Y-m-d')?>" class="form-control">
						</div>
						<div class="col-lg-4 col-md-4 col-sm-6 col-6">
							<label>To Date</label>
							<input type="date" required max="<?=date('Y-m-d')?>" name="to_date" value="<?=($_POST['to_date']) ? $_POST['to_date'] : date('Y-m-d')?>" class="form-control">
						</div>
						<div class="col-lg-4 col-md-4 col-sm-6 col-6">
							<input type="submit" name="search" value="Search" class="btn btn-primary" style="margin-top:25px;">
						</div>
					</div>
					</form>
					<div class="table-responsive mt-4 table-single-orders">
						<table class="datatable-withbuttons table table-striped dt-responsive nowrap" id="table-orders">
							<thead >
								<tr>
									<th>Sr No.</th>
									<th>Order No</th>
									<th>Customer</th>
									<th>Date</th>
									<th>Order Amount</th>
								</tr>
							</thead>
							<tbody class="tbody-order-list">
								<?php
								$revenue_amt=0;
								foreach ($revenue as $rev) {
									$revenue_amt=$revenue_amt+$rev['net_total'];
								}?>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td style="font-weight:bold;text-align:right;">Total Revenue : <?=$currency_symbol[0]['currency_symbol']?> <?=$revenue_amt?></td>
								</tr>
								<?php
								$i=1;
								foreach ($revenue as $rev) {
								?>
								<tr>
									<td><?=$i++?></td>
									<td><?=$rev['order_no'];?></td>
									<td><?=$rev['name'];?></td>
									<td><?=date('d M Y H:i A',strtotime($rev['created_at']))?></td>
									<td class="text-right"><?=$currency_symbol[0]['currency_symbol']?> <?=$rev['net_total'];?></td>
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
		var count = '<?php echo count($revenue);?>';
		if(count <= 0){
			$('.btn-group').hide();
		}
	});
    var report_title='Customer Report';
    Common.datatablewithButtons(report_title,' Customer Report');
</script>
<?php
        if ($this->session->flashdata('success')) {
            echo "<script>swal('success','" . $this->session->flashdata('success') . "','success')</script>";
        }
        if ($this->session->flashdata('danger')) {
            echo "<script>swal('Error','" . $this->session->flashdata('danger') . "','error')</script>";
        }
        ?>