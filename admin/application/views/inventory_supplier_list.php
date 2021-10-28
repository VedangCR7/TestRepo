<?php
require_once('header.php');
require_once('sidebar.php');
date_default_timezone_set("Asia/Kolkata");
?>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<div class=" app-content">
	<div class="side-app">
		<!--Page Header-->
		<div class="page-header">
			<h3 class="page-title"><i class="fe fe-file-text mr-1"></i> Supplier List</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Supplier List</li>
			</ol>
		</div>
		
	</div>
    <div class="row" id="get_edit_pro">
    </div>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
                <div class="card-header">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12 text-right">
                        <a href="<?=base_url();?>inventory/create_supplier"><button class="btn btn-primary"><i class="fas fa-plus"></i> Add Supplier</button></a>
                    </div>
                </div>
				<div class="card-body">
					<div class="table-responsive mt-4 table-single-orders">
						<table class="datatable-withbuttons table table-striped dt-responsive nowrap" id="table-orders">
							<thead >
								<tr>
									<th>Sr No.</th>
									<th>Company Name</th>
                                    <th>Email</th>
                                    <th>Mobile NO</th>
									<th>GST No</th>
                                    <th>Paid Amount</th>
                                    <th>Due Amount</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody class="tbody-order-list">
								<?php
								$i=1;
								foreach ($supplier as $item) {
								?>
								<tr>
									<td><?=$i++?></td>
									<td><?php if($item['company_logo']!=''){ ?><img src="<?=$item['company_logo']?>" style="width:50px;height:50px;border-radius:50%"><?php }else{?> <img src="<?=base_url('assets/images/users/user.png')?>" style="width:50px;height:50px;border-radius:50%"><?php } ?> <?=$item['company_name'];?></td>
                                    <td><?=$item['email'];?></td>
                                    <td><?=$item['mobile'];?></td>
									<td><?=$item['gst_no'];?></td>
                                    <td><?=$item['total_paid'];?></td>
                                    <td><?=$item['due_amount'];?></td>
									<td><i class="fas fa-edit text-primary edit_supplier" data-id="<?=$item['id']?>"></i> &nbsp;&nbsp; <i class="fas fa-trash text-danger delete_supplier" data-id="<?=$item['id']?>"></i></td>
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
                    data: {name:'Inventory Management'},
                    success: function(result){
                        if(result.status){
                            window.location.href="<?=base_url();?>restaurant/dashboard";
                        }
                   	}
                });
            },5000);
</script>

<script>
    $('.edit_supplier').click(function(){
        // alert($(this).attr('data-id'));
        $.ajax({
            url: "<?=base_url()?>inventory/get_edit_supplier",
            type:'POST',
            dataType: 'json',
            data: {
                id : $(this).attr('data-id'),
            },
            success: function(result){
                $('#image-loader').hide();
                var html = '';
                html +='<div class="col-md-12"><div class="card"><div class="col-lg-12 col-md-12 col-sm-12 col-12"><form action="<?=base_url('inventory/edit_supplier_information')?>" method="post"><div class="row">\
                <div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:10px;">\
                            <label style="font-weight:bold">Company Name</label>\
                            <input type="text" name="company_name" value="'+result[0].company_name+'" class="form-control" placeholder="Company Name" id="company_name">\
                        </div>\
                        <div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:10px;">\
                            <label style="font-weight:bold">Address</label>\
                            <input type="text" name="company_address" value="'+result[0].company_address+'" class="form-control" placeholder="Address" id="company_address">\
                        </div>\
                        <div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:10px;">\
                            <label style="font-weight:bold">Email</label>\
                            <input type="text" name="email" value="'+result[0].email+'" class="form-control" placeholder="Email" id="email">\
                        </div>\
                        <div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:10px;">\
                            <label style="font-weight:bold">GST No</label>\
                            <input type="text" name="gst_no" value="'+result[0].gst_no+'" class="form-control" placeholder="GST Number" id="gst_no">\
                        </div>\
                        <div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:10px;">\
                            <label style="font-weight:bold">Contact Person Name</label>\
                            <input type="text" name="contact_person_name" value="'+result[0].contact_person_name+'" class="form-control" placeholder="Contact Person Name" id="contact_person_name">\
                        </div>\
                        <div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:10px;">\
                            <label style="font-weight:bold">Mobile</label>\
                            <input type="text" name="mobile" value="'+result[0].mobile+'" class="form-control" placeholder="Mobile" id="mobile">\
                        </div>\
                        <div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:10px;">\
                            <label style="font-weight:bold">Owner Name</label>\
                            <input type="text" name="owner_name" value="'+result[0].owner_name+'" class="form-control" placeholder="Owner Name" id="owner_name">\
                        </div>\
                        <div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:10px;">\
                            <div class="row">\
                                <div class="col-lg-6 col-md-6 col-sm-6 col-6">\
                                    <label style="font-weight:bold">Company Logo</label>\
                                </div>\
                                <div class="col-lg-6 col-md-6 col-sm-6 col-6 text-center imgtrigger">\
                                    <input type="file" class="imgupload" id="imgvalue" value="" accept="image/jpeg, image/png" style="display:none">';

                                    if(result[0].company_logo != ''){
                                        html +='<img class="img-upload1 rounded-circle" id="my_image" src="'+result[0].company_logo+'" style="height:50px;width:50px;text-align:right"><br>';
                                    }
                                    else{
                                    html +='<img class="img-upload1 rounded-circle" id="my_image" src="<?=base_url()?>assets/images/users/user.png" style="height:50px;width:50px;text-align:right"><br>';}
                                    html +='<button class="btn btn-secondary btn-sm img-upload1" type="button" style="background-color: #ED3573;border: 0px !important;margin-top:10px;">Browse</button>\
                                </div>\
                                <input type="hidden" name="id" value="'+result[0].id+'">\
                                <div id="is_image_upload"></div>\
                            </div>\
						</div>\
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12"><hr></div>\
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12 text-right">\
                            <button class="btn btn-primary btn-add-group">Submit</button>\
                        </div>\
                </div></form></div></div></div>';
                $('#get_edit_pro').html(html);
            }
        });
    });
</script>

<script>
    $('#get_edit_pro').on('click','.img-upload1',function(){
            $(this).closest('div').find('.imgupload').trigger('click');
        });

    $('#get_edit_pro').on('change','.imgupload',function(event){
        var bind_input=$(this);
        if($(this).val()==""){
              /*  displaywarning('please select file to upload.');*/
                return false;
            }
        var group_id=$(this).attr('group-id');
        var ext = $(this).val().split('.').pop().toLowerCase();
            if($.inArray(ext, ['jpg','jpeg','png']) == -1) {
                Inventorysupplier.displaywarning('invalid extension!');
                return false;
            }

            var self=this;
            var $form_data = new FormData();
            var inputFile = $(this);   
            if(inputFile){   
                var fileToUpload = inputFile[0].files[0];
                if (fileToUpload != 'undefined') {
                    $form_data.append('image', fileToUpload);
                }
            }
            const target = event.target
            if (target.files && target.files[0]) {
                //allow less than 1mb
                const maxAllowedSize = 1 * 1024 * 1024;
                if (target.files[0].size > maxAllowedSize) {
                // Here you can ask your users to load correct file
                    $('#image-loader').hide();
                    Waitingmanager.displaywarning("File size is too big. please select the file less than 1MB.");
                    return false;
                }
            }
           
            var defaults = {  
                maxWidth: Number.MAX_VALUE,  
                maxHeigt: Number.MAX_VALUE,  
                onImageResized: null  
            }  
            var options={
                maxWidth: 200,
                maxHeigt:121
            }
            var settings = $.extend({}, defaults, options); 
            
            if (window.File && window.FileList && window.FileReader) {
                var files = event.target.files;  
                var file = files[0];  
                /*if (!file.type.match('image')) continue;  */
                var picReader = new FileReader();  
                picReader.addEventListener("load", function (event) {

                    var picFile = event.target;  
                    var imageData = picFile.result;  
                    var img = new Image();  
                    img.src = imageData;  
                    img.onload = function () { 

                        swal({
                            title: 'File requirement :',
                            text: "JPG, PNG up to 1MB. Minimum pixels required: 200 for width, 200 for height.",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, upload it!',
                            cancelButtonText: 'No, cancel!',
                            confirmButtonClass: 'btn btn-success',
                            cancelButtonClass: 'btn btn-danger',
                            buttonsStyling: false
                        },function (swalstatus) { 
                            if(swalstatus){ 
                                $('#image-loader').show();
                                var canvas = $("<canvas/>").get(0);  
                                canvas.width = 200;  
                                canvas.height = 121;  
                                var context = canvas.getContext('2d');  
                                context.fillStyle = "transparent";
                                context.drawImage(img, 0, 0, 200, 121); 
                                imageData = canvas.toDataURL('image/jpeg',0.8);
                                console.log(imageData);
                                $('#my_image').attr('src',imageData);
                                $('#is_image_upload').html('<input type="hidden" name="company_logo" value="'+imageData+'" id="company_logo">');
                                $('#image-loader').hide();
                            }else{
                                bind_input.val('');
                            }

                        }, function (dismiss) {
                            if (dismiss === 'cancel') {
                               /* swal(
                                  'Cancelled',
                                  'Your record is safe :)',
                                  'error'
                                )*/
                            }
                        });
                    }  
                    img.onerror = function () {  
                         $("#cropbox").attr('src','');
                        $('#image-loader').hide();
                       
                    }  
                });  
                //Read the image  
                picReader.readAsDataURL(file);  
            } else {  
                Inventorysupplier.displaywarning("Your browser does not support File API");  
                $("#cropbox").attr('src','');
                $('#image-loader').hide();
            }

    });


</script>
<script>
$('.delete_supplier').click(function(){
    var data_id=$(this).attr('data-id');
        var title='Are you sure ?';
        var text="Delete Supplier";
        swal({
            title: title,
            text: text,
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33 !important',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false
        },function () {
            var formData={
                id : data_id
            } 
            $.ajax({
                url: "<?=base_url()?>inventory/delete_supplier",
                type:'POST',
                data:formData ,
                success: function(result){
                   if(result.status){
                       location.reload();
                   }
                }
            });
        }, function (dismiss) {
            if (dismiss === 'cancel') {
                swal(
                  'Cancelled',
                  'Your record is safe :)',
                  'error'
                )
            }
        });
       
})
</script>

<?php
        if ($this->session->flashdata('success')) {
            echo "<script>swal('success','" . $this->session->flashdata('success') . "','success')</script>";
        }
        if ($this->session->flashdata('danger')) {
            echo "<script>swal('danger','" . $this->session->flashdata('danger') . "','error')</script>";
        }
        ?>
<?php
require_once('footer.php');
?>
<script>
    var report_title='Supplier List';
    Common.datatablewithButtons(report_title,'Supplier List');
</script>