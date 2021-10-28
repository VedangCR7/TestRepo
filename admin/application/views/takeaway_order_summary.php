<?php
require_once('header.php');
require_once('sidebar.php');
?>
<div class=" app-content">
	<div class="side-app">
		<!--Page Header-->
		<div class="page-header">
			<h3 class="page-title"><i class="fe fe-home mr-1"></i> Takeaway Order Summary</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Takeaway Order Summary</li>
			</ol>
		</div>
		
	</div>
	<div class="row">
		<div class="col-md-12" style="min-height: 450px;">
			<div class="card">
				<div class="card-body">
					<form action="<?=base_url()?>reports/takeaway_order_summary" method="post">
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
								<label>Takeaway Category</label>
								<!--<input type="text" name="takeaway_category" value="<?=($_POST['takeaway_category']) ? $_POST['takeaway_category'] : ''?>" class="form-control" placeholder="Takeaway Category">-->
								<select id="takeawaycategory" name="takeawaycategory" class="form-control">
									<option value="0">Select Takeaway Category</option>
									<?php
									for($i=0;$i<count($takeaway_category);$i++) 
									{
										if($_POST['takeawaycategory']==$takeaway_category[$i]['id'])
										{
										?>
										<option selected value="<?=$takeaway_category[$i]['id'];?>"><?=$takeaway_category[$i]['title'];?></option>
										<?php
										}
										else
										{
										?>
										<option value="<?=$takeaway_category[$i]['id'];?>"><?=$takeaway_category[$i]['title'];?></option>
										<?php
										}
									}
									?>
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
									<th>Cust. Name</th>
									<th>Order From</th>
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
    var report_title='Takeaway Order Summary Report';
    Common.datatablewithButtons(report_title,'Takeaway Order Summary Report');
</script>
<script>
$(document).ready(function(){
// 	$("input").on("change", function() {
//     this.setAttribute(
//         "data-date",
//         moment(this.value, "YYYY-MM-DD")
//         .format( this.getAttribute("data-date-format") )
//     )
// }).trigger("change")
// var fromdate = $('#from_date').val();
// var myDate = new Date(fromdate);
// alert(myDate);
// var d = myDate.getDate();
// var m =  myDate.getMonth();
// m += 1;  
// var y = myDate.getFullYear();

//     var newdate=(d+ "-" + m + "-" + y);
// 	alert(newdate);
// 	$('#from_date').val(newdate);
// 	alert($('#from_date').val());
//   return newdate;
// var month = format(todayTime . getMonth());
// var day = format(todayTime . getDate());
// var year = format(todayTime . getFullYear());
// return month + "/" + day + "/" + year;
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