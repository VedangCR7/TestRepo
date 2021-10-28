<?php
require_once('header.php');
require_once('sidebar.php');

?>
<div class=" app-content">
	<div class="side-app">

		<!--Page Header-->
		<div class="page-header">
			<h3 class="page-title"><i class="side-menu__icon fe fe-user mr-1"></i>Create Supplier</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Create Supplier</li>
			</ol>
		</div>
		<!--Page Header XYZ-->
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
                <div class="card-header">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12 text-right">
                        <a href="<?=base_url('inventory/supplier_list')?>"><button class="btn btn-secondary"><i class="fas fa-list-ol"></i> Supplier List</button></a>
                    </div>
                </div>
				<div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:10px;">
                            <label style="font-weight:bold">Company Name</label>
                            <input type="text" class="form-control" placeholder="Company Name" id="company_name" style="text-transform: capitalize;">
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:10px;">
                            <label style="font-weight:bold">Address</label>
                            <input type="text" class="form-control" placeholder="Address" id="company_address" style="text-transform: capitalize;">
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:10px;">
                            <label style="font-weight:bold">Email</label>
                            <input type="text" class="form-control" placeholder="Email" id="email">
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:10px;">
                            <label style="font-weight:bold">GST No</label>
                            <input type="text" class="form-control" placeholder="GST Number" id="gst_no" style="text-transform:uppercase;">
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:10px;">
                            <label style="font-weight:bold">Contact Person Name</label>
                            <input type="text" class="form-control" placeholder="Contact Person Name" id="contact_person_name" style="text-transform: capitalize;">
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:10px;">
                            <label style="font-weight:bold">Mobile</label>
                            <input type="text" class="form-control" placeholder="Mobile" id="mobile">
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:10px;">
                            <label style="font-weight:bold">Owner Name</label>
                            <input type="text" class="form-control" placeholder="Owner Name" id="owner_name" style="text-transform: capitalize;">
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:10px;">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                    <label style="font-weight:bold">Company Logo</label>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-6 text-center imgtrigger">
                                    <input type="file" class="imgupload" id="imgvalue" value="" accept="image/jpeg, image/png" style="display:none">
                                    <img class="img-upload1 rounded-circle" id="my_image" src="<?=base_url()?>assets/images/users/user.png" style="height:50px;width:50px;text-align:right"><br>
                                    <button class="btn btn-secondary btn-sm img-upload1" type="button" style="background-color: #ED3573;border: 0px !important;margin-top:10px;">Browse</button>
                                    
                                </div>
                                <div id="is_image_upload"></div>
                            </div>
						</div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12"><hr></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12 text-right" style="margin-top:20px;">
                            <button class="btn btn-primary btn-add-group">Submit</button>
                        </div>
                    </div>
				</div>
			</div>
		</div>
		
	</div>
	
<script src="<?=base_url();?>assets/js/custom/Inventorysupplier.js?v=10"></script>

<script type="text/javascript">
	Inventorysupplier.base_url="<?=base_url();?>";
	Inventorysupplier.init();
	/*$('.recipe-tabs').find('.receipes .card-body').addClass('active');*/
</script>
<script>
    $('#company_name').on('keypress',function(e){
				var regex = new RegExp("^[a-zA-Z ]+$");
				    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
				    if (regex.test(str)) {
				        return true;
				    }
				    e.preventDefault();
				    return false;
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