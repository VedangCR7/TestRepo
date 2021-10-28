<?php
require_once('header.php');
require_once('sidebar.php');

?>
<div class=" app-content">
	<div class="side-app">

		<!--Page Header-->
		<div class="page-header">
			<h3 class="page-title"><i class="side-menu__icon fe fe-dollar-sign mr-1"></i>Create Payment</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Create Payment</li>
			</ol>
		</div>
		<!--Page Header-->
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12" style="margin-top:10px;">
                                    <label>Payment Date <sapn class="text-danger">*</span></label>
                                    <input type="date" value="<?=date('Y-m-d')?>" disabled class="form-control" placeholder="Payment Date" id="payment_date">
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12" style="margin-top:10px;">
                                    <label>Supplier <sapn class="text-danger">*</span></label>
                                    <select class="form-control" id="supplier_id">
                                        <option value="">Select Supplier</option>
                                        <?php foreach($supplier as $key=>$value){ ?>
                                        <option value="<?=$value['id']?>"><?=$value['company_name']?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12" style="margin-top:10px;">
                                    <label>Payment Type <sapn class="text-danger">*</span></label><br>
                                    <input type="radio" value="Hand Cash" name = "payment_type" class="payment_type" checked> Hand Cash
                                    <input type="radio" value="Cheque" name = "payment_type" class="payment_type"> Cheque
                                    <input type="radio" value="Bank Payment / UPI" name = "payment_type" class="payment_type"> Bank Payment / UPI
                                    <br>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12" style="margin-top:21px;">
                                    <label class="get_label_from_payment_type"> Person Name</label>
                                    <input type="text" class="form-control get_label_from_payment_type1" placeholder="Person Name" id="payment_details" style="text-transform: capitalize;">
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12" style="margin-top:10px;">
                                    <label>Cheque Date </label>
                                    <input type="date" value="<?=date('Y-m-d')?>" class="form-control" id="cheque_date">
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12" style="margin-top:10px;">
                                    <label>Remark </label>
                                    <textarea class="form-control" id="remark" rows="4" placeholder="Remark" style="text-transform: capitalize;"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12" style="margin-top:10px;">
                                    <label>Payable Amount <sapn class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Payable Amount" disabled id="payable_amount">
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12 col-12" style="margin-top:10px;">
                                    <label>Paid </label>
                                    <input type="text" class="form-control" placeholder="Paid Amount" id="paid">
                                </div>
                        
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12" style="margin-top:10px;">
                                    <label>Discount </label>
                                    <input type="text" class="form-control" placeholder="Discount" id="discount">
                                </div>
                        
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12" style="margin-top:10px;">
                                    <label>Total </label>
                                    <input type="text" disabled="" class="form-control" placeholder="Total" id="total">
                                </div>
                        
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12" style="margin-top:10px;">
                                    <label>Balance </label>
                                    <input type="text" disabled class="form-control" placeholder="Balance" id="balance">
                                </div>
                        
                            </div>
                        </div>
                        
                        
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12"><hr></div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12 text-right">
                            <button class="btn btn-primary btn-add-group">Submit</button>
                        </div>
                    </div>
				</div>
			</div>
		</div>
		
	</div>
	
<script src="<?=base_url();?>assets/js/custom/Inventorypaymentcreate.js?v=<?=uniqid()?>"></script>

<script type="text/javascript">
	Inventorypaymentcreate.base_url="<?=base_url();?>";
	Inventorypaymentcreate.init();
	/*$('.recipe-tabs').find('.receipes .card-body').addClass('active');*/
</script>
<script>
    $('input[name=payment_type]').change(function(){
        //alert($('input[name=payment_type]:checked').val());
        if($('input[name=payment_type]:checked').val() == 'Hand Cash'){
            $('.get_label_from_payment_type').html('Person Name');
            $('#payment_details').attr('placeholder',"Person Name");
        }

        if($('input[name=payment_type]:checked').val() == 'Cheque'){
            $('.get_label_from_payment_type').html('Cheque No');
            $('#payment_details').attr('placeholder',"Cheque Number");
        }

        if($('input[name=payment_type]:checked').val() == 'Bank Payment / UPI'){
            $('.get_label_from_payment_type').html('Reference ID/Transaction ID');
            $('#payment_details').attr('placeholder',"Reference ID/Transaction ID");
        }
    });
	setInterval(function() {
                $.ajax({
                    url: "<?=base_url();?>restaurant/set_authority_exist",
                    type:'POST',
                    dataType: 'json',
                    data: {name:'Inventory Management'},
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