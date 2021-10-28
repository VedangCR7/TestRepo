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
			<h3 class="page-title"><i class="fe fe-home mr-1"></i> Product List</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Product List</li>
			</ol>
		</div>
		
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
                <div class="card-header">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12 text-right">
                        <a href="<?=base_url()?>inventory/add_product"><button class="btn btn-primary"><i class="fas fa-plus"></i> Add Product</button></a>
                        <a href="<?=base_url()?>inventory/add_product"><button class="btn btn-secondary"><i class="fas fa-file-csv"></i> Add Product With CSV</button></a>
                    </div>
                </div>
				<div class="card-body">
                    <div class="row" id="get_edit_pro">
                    </div>
					<div class="table-responsive mt-4 table-single-orders">
						<table class="datatable-withbuttons table table-striped dt-responsive nowrap" id="table-orders">
							<thead >
								<tr>
									<th>Sr No.</th>
									<th>Product Name</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody class="tbody-order-list">
								<?php
								$i=1;
								foreach ($product as $item) {
								?>
								<tr>
									<td><?=$i++?></td>
									<td><?=$item['product_name'];?></td>
									<td><i class="fas fa-edit text-primary edit_product" data-id="<?=$item['id']?>"></i> &nbsp;&nbsp; <i class="fas fa-trash text-danger delete_product" data-id="<?=$item['id']?>"></i></td>
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
    $('.edit_product').click(function(){
        // alert($(this).attr('data-id'));
        $.ajax({
            url: "<?=base_url()?>inventory/get_edit_product",
            type:'POST',
            dataType: 'json',
            data: {
                id : $(this).attr('data-id'),
            },
            success: function(result){
                $('#image-loader').hide();
                alert(result[0].product_name)
                var html = '';
                html +='<div class="col-lg-12 col-md-12 col-sm-12 col-12"><form action="<?=base_url('inventory/edit_product_information')?>" method="post"><div class="row"><div class="col-lg-3 col-md-3 col-sm-12 col-12">\
                            <input type="text" class="form-control" value="'+result[0].product_name+'" name="product_name" placeholder="Product Name">\
                            <input type="hidden" class="form-control" value="'+result[0].id+'" name="id">\
                        </div>\
                        <div class="col-lg-3 col-md-3 col-sm-12 col-12">\
                            <button class="btn btn-primary">Edit</button>\
                        </div></div></form></div>';
                $('#get_edit_pro').html(html);
            }
        });
    });
</script>

<script>
$('.delete_product').click(function(){
    var data_id=$(this).attr('data-id');
        var title='Are you sure ?';
        var text="Delete Product";
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
                url: "<?=base_url()?>inventory/delete_product",
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
    var report_title='Product List';
    Common.datatablewithButtons(report_title,'Product List');
</script>