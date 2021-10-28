<?php
require_once('header.php');
require_once('sidebar.php');
date_default_timezone_set("Asia/Kolkata");
?>
<div class=" app-content">
	<div class="side-app">
		<!--Page Header-->
		<div class="page-header">
			<h3 class="page-title"><i class="fe fe-home mr-1"></i> Most Selling Menu Items</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Most Selling Menu Items</li>
			</ol>
		</div>
		
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<form action="<?=base_url()?>reports/selling_item_report" method="post">
					<div class="row">
						<div class="col-lg-4 col-md-4 col-sm-6 col-6">
							<label>From Date</label>
							<input type="date" max="<?=date('Y-m-d')?>" required name="from_date" value="<?=($_POST['from_date']) ? $_POST['from_date'] : date('Y-m-d')?>" class="form-control">
						</div>
						<div class="col-lg-4 col-md-4 col-sm-6 col-6">
							<label>To Date</label>
							<input type="date" max="<?=date('Y-m-d')?>" required name="to_date" value="<?=($_POST['to_date']) ? $_POST['to_date'] : date('Y-m-d')?>" class="form-control">
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
									<th>Menu Name</th>
									<th>Price</th>
									<th>Total Orders</th>
									<th>Income</th>
									<th>Menu Type</th>
									<!--<th>Date</th>-->
								</tr>
							</thead>
							<tbody class="tbody-order-list">
								<?php
								$i=1;
								foreach ($items as $item) {
								?>
								<tr>
									<td><?=$i++?></td>
									<td><?=$item['name'];?></td>
									<td><?=$currency_symbol[0]['currency_symbol']?> <?=$item['price'];?></td>
									<td><?=$item['recipe_count'];?></td>
									<td><?=$currency_symbol[0]['currency_symbol']?> <?=$item['income'];?></td>
									<td><?=$item['recipe_type'];?></td>
									<!--<td><?=date('d M Y h:i a',strtotime($item['created_at']))?></td>-->
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
		var count = '<?php echo count($items);?>';
		if(count <= 0){
			$('.btn-group').hide();
		}
	});
    var report_title='Most Selling Menu Items Report';
    Common.datatablewithButtons(report_title,' Most Selling Menu Items Report');
</script>

<?php
        if ($this->session->flashdata('success')) {
            echo "<script>swal('success','" . $this->session->flashdata('success') . "','success')</script>";
        }
        if ($this->session->flashdata('danger')) {
            echo "<script>swal('Error','" . $this->session->flashdata('danger') . "','error')</script>";
        }
        ?>