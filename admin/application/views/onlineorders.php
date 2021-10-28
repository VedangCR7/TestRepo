<?php
require_once('header.php');
require_once('sidebar.php');
?>
<div class=" app-content">
	<div class="side-app">
		<!--Page Header-->
		<div class="page-header">
			<h3 class="page-title"><i class="fe fe-home mr-1"></i>New Order</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">New Order</li>
			</ol>
		</div>
		<div class="row">
			<div class="col-md-12">
			<div class="card">
				<div class="card-body" id="show_all_tables">
					
				</div>
			</div>
		</div>
	</div>

<?php
require_once('footer.php');
?>

<script src="<?=base_url();?>assets/js/custom/Neworders.js?v=18"></script>
<script type="text/javascript">
	Neworders.base_url="<?=base_url();?>";
	Neworders.init();
	/*$('.recipe-tabs').find('.receipes .card-body').addClass('active');*/
</script>
<script>
	setInterval(function() {
                $.ajax({
                    url: "<?=base_url();?>restaurant/set_authority_exist",
                    type:'POST',
                    dataType: 'json',
                    data: {name:'Order'},
                    success: function(result){
                        if(result.status){
                            window.location.href="<?=base_url();?>restaurant/dashboard";
                        }
                   	}
                });
            },5000);
</script>