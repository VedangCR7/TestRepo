<?php
require_once('header.php');
require_once('sidebar.php');
?>
<div class=" app-content">
	<div class="side-app">
		<!--Page Header-->
		<div class="page-header">
			<h3 class="page-title"><i class="fe fe-home mr-1"></i> Customers</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Customers</li>
			</ol>
		</div>
		
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<form action="<?=base_url()?>reports/customer_report" method="post">
					<div class="row">
						<div class="col-lg-2 col-md-2 col-sm-6 col-6">
							<label>From Date</label>
							<input type="date" required name="from_date" value="<?=($_POST['from_date']) ? $_POST['from_date'] : date('Y-m-d')?>" max="<?=date('Y-m-d')?>" class="form-control">
						</div>
						<div class="col-lg-2 col-md-2 col-sm-6 col-6">
							<label>To Date</label>
							<input type="date" required name="to_date" value="<?=($_POST['to_date']) ? $_POST['to_date'] : date('Y-m-d')?>" max="<?=date('Y-m-d')?>" class="form-control">
						</div>
						<div class="col-lg-3 col-md-3 col-sm-6 col-6">
							<label>Customer Name</label>
							<input type="text" name="customer_name" value="<?=($_POST['customer_name']) ? $_POST['customer_name'] : ''?>" class="form-control" placeholder="Customer Name">
						</div>
						<div class="col-lg-3 col-md-3 col-sm-6 col-6">
							<label>Customer Contact</label>
							<input type="text" name="customer_contact" value="<?=($_POST['customer_contact']) ? $_POST['customer_contact'] : ''?>" class="form-control" placeholder="Customer Contact Number" onkeypress="return isNumber(event)">
						</div>
						<div class="col-lg-2 col-md-2 col-sm-6 col-6">
							<input type="submit" name="search" value="Search" class="btn btn-primary" style="margin-top:25px;">
						</div>
					</div>
					</form>
					<div class="table-responsive mt-4 table-single-orders">
						<table class="datatable-withbuttons table table-striped dt-responsive nowrap" id="table-orders">
							<thead >
								<tr>
									<th>Sr No.</th>
									<th>Cust. Name</th>
									<th>Contact No.</th>
									<th>Email</th>
									<th>Total Order</th>
									<th>Order Amount</th>
								</tr>
							</thead>
							<tbody class="tbody-order-list">
								<?php
								$i=1;
								foreach ($customer as $cust) {
								?>
								<tr>
									<td><?=$i++?></td>
									<td><a href="<?=base_url('reports/invoice_details/'.$cust['customer_id'])?>"><?=$cust['name'];?></a></td>
									<td><?=$cust['contact_no'];?></td>
									<td><?=$cust['email'];?></td>
									<td><?=$cust['customer_id_count']?></td>
									<td><?=$currency_symbol[0]['currency_symbol']?> <?=$cust['order_amount']?></td>
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
		<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Invoices</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="row">
        	<div class="col-lg-12 col-md-12 col-sm-12 col-12 table-responsive">
        		<table class="table table-bordered">
        			<thead>
        				<tr>
        					<th>Invoice No</th>
        					<th>Table No</th>
        					<th>Net total</th>
        					<th>Date</th>
        				</tr>
        			</thead>
        			<tbody id="showinvoice">
        			</tbody>
        		</table>
        	</div>
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>
	</div>
<?php
require_once('footer.php');
?>
<script>
	$(document).ready(function(){
		var count = '<?php echo count($customer);?>';
		if(count <= 0){
			$('.btn-group').hide();
		}
	});
    var report_title='Customer Report';
    Common.datatablewithButtons(report_title,' Customer Report');


    $('.showinvoicemodal').click(function(){
    	var customer_id =$(this).attr('data-id');
    	alert(customer_id);
    	$.ajax({
            url: "<?=base_url()?>reports/invoice",
            type:'POST',
            dataType: 'json',
            data: {customer_id:customer_id},
            success: function(response){
                $('#image-loader').hide();
                $('#myModal').modal('show');
                $('#showinvoice').html('');
                html = '';
                for (var i = 0; i < response.length; i++) {
                	html+='<tr>\
                	<td>'+response[i].invoice_no+'</td>\
                	<td>'+response[i].title+'</td>\
                	<td>'+response[i].net_total+'</td>\
                	<td>'+response[i].created_at+'</td>\
                	</tr>\
                	';
                }
                $('#showinvoice').html(html);
            }
        });
    });
</script>
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
<script>
	function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
</script>
<?php
        if ($this->session->flashdata('success')) {
            echo "<script>swal('success','" . $this->session->flashdata('success') . "','success')</script>";
        }
        if ($this->session->flashdata('danger')) {
            echo "<script>swal('Error','" . $this->session->flashdata('danger') . "','error')</script>";
        }
        ?>