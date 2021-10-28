<?php
require_once('header.php');
require_once('sidebar.php');
date_default_timezone_set("Asia/Kolkata");
?>
<div class=" app-content">
	<div class="side-app">
		<!--Page Header-->
		<div class="page-header">
			<h3 class="page-title"><i class="fe fe-home mr-1"></i>Price Chage reports</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Price Chage reports</li>
			</ol>
		</div>
		
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<form action="javascript;" method="post" id ="get-date-purchase-qty">
						<div class="row">
							<div class="col-lg-4 col-md-6 col-sm-12 form-group-sm">
								<label>Select Menu</label>
								<select class="form-control form-control-md" id="id">
									<option value=""></option>
									<?php
										foreach ($recipes_all as $key => $value) {
										?>
											<option value="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></option>
										<?php
										}
									?>
								</select>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-6 col-6">
								<label>From Date</label>
								<input type="date" max="<?=date('Y-m-d')?>" required name="from_date" value="" class="form-control"  id="from">
							</div>
							<div class="col-lg-4 col-md-4 col-sm-6 col-6">
								<label>To Date</label>
								<input type="date" max="<?=date('Y-m-d')?>" required name="to_date" value="" class="form-control"  id="to">
							</div>
							<div class="col-lg-4 col-md-4 col-sm-6 col-6">
								<input type="submit" name="search" value="Search" class="btn btn-primary" style="margin-top:25px;">
							</div>
						</div>
					</form>
					<div class="table-responsive mt-4 table-single-orders" id="result">
						<table class="datatable-withbuttons table table-striped dt-responsive nowrap">
							<!-- <thead >
								<tr>
									<th>Sr No.</th>
									<th>Menu Name</th>
									<th>Price</th>
									<th>Date CHnaged</th>
									<th>Date</th>
								</tr>
							</thead>
							<tbody class="tbody-order-list"> -->
								<!-- <tr>
									<th scope="row">1</th>
									<td>Mark</td>
									<td>Otto</td>
									<td>@mdo</td>
								</tr> -->
								<!-- <tr>
									<th scope="row">2</th>
									<td>Jacob</td>
									<td>Thornton</td>
									<td>@fat</td>
								</tr>
									<tr>
									<th scope="row">3</th>
									<td>Larry the Bird</td>
									<td>@twitter</td>
									<td>@twitter</td>
								</tr> -->
							<!-- </tbody>
						</table> -->
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
<script type="text/javascript">
	$(document).ready(function(){
		var count = '<?php echo count($items);?>';
		if(count <= 0){
			$('.btn-group').hide();
		}
	});
    var report_title='Most Selling Menu Items Report';
    Common.datatablewithButtons(report_title,' Most Selling Menu Items Report');
</script>

<script>
	$('#get-date-purchase-qty').on('submit',function(e){
		e.preventDefault();
		
		var from = $("#from").val();
		var to = $("#to").val();
		var id = $("#id").val();
		if (id == "") {
			$("#result").html("Pick a menu to veiw price change history");
			return;
		}
		var html = `
			<table class="table table-responsive mt-4 table-bordered datatable-withbuttons table table-striped dt-responsive nowrap">
				<thead>
					<tr>
					<th scope="col">Sr.No</th>
					<th scope="col">Price</th>
					<th scope="col">Changed datetime</th>
					<th scope="col">Total Sales</th>
					</tr>
				</thead>
				<tbody>
		`;

		// console.log("working", from, to);
		$.ajax({
			type: "GET",
			url: `<?=base_url();?>recipes/get_price_purchase_count/${from}/${to}/${id}`,
			success: function(data){
				console.log(data["data"]);
				var results = data["data"]
				if(results !== null){
					results.forEach((result, index) => {
						html+= `
						<tr>
							<th scope="row">${index+1}</th>
							<td>${result.price}</td>
							<td>${result.date_created}</td>
							<td>${result.totalPurchase}</td>
						</tr>
						`;
					});
					html+= `
							</tbody>
						</table>
					`
					$('#result').html(html);
				}else{
					$('#result').html("no result found");
				}
				console.log(this.url);
			},
			error: function(err){
				console.log(err);
			}
		})
	});
</script>


<?php
        if ($this->session->flashdata('success')) {
            echo "<script>swal('success','" . $this->session->flashdata('success') . "','success')</script>";
        }
        if ($this->session->flashdata('danger')) {
            echo "<script>swal('Error','" . $this->session->flashdata('danger') . "','error')</script>";
        }
        ?>