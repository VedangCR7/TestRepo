<?php
	require_once('header.php');
	require_once('web_header.php');
	require_once('sidebar.php');
	/* print_r($table_number);exit; */
?>
	<!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> -->
	<script src="https://kit.fontawesome.com/a076d05399.js"></script>
	<!-- jQuery library -->
	<style type="text/css">
		.footer{
			display:none;
		}
		
		#back-to-top{
			display:none;
		}
		
		li{
			list-style-type:none;
		}
		
		.menuname{
			font-size:12px;
		}

		.sidenav {
			height: 100%;
			width: 0;
			position: fixed;
			z-index: 999999999999999999;
			top: 0;
			left: 0;
			background-color:white;
			overflow-x: hidden;
			transition: 0.5s;
			padding-top: 60px;
		}

		.sidenav a {
			padding: 8px 8px 8px 32px;
			text-decoration: none;
			font-size: 18px;
			color:black;
			display: block;
			transition: 0.3s;
		}

		.sidenav a:hover {
			color: #f1f1f1;
		}

		.sidenav .closebtn {
			position: absolute;
			top: 0;
			right: 25px;
			font-size: 36px;
			margin-left: 50px;
		}

		.resto-name {font-size:25px;}
		@media screen and (max-height: 450px) {
			.sidenav {padding-top: 15px;}
			.sidenav a {font-size: 18px;}
		}
		@media screen and (max-width: 450px) {
			.resto-name {font-size:17px;}
		}
	</style>
	<div class="menu-navigation" style="background: linear-gradient( 89.1deg,rgb(8,158,96) 0.7%,rgb(19,150,204) 88.4% );">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12 mb-2">
					<div class="row">
						<div class="col-1 p-1 text-center" style="margin-top:10px;"><span style="font-size:25px;cursor:pointer;color:white;" onclick="openNav()">&#9776;</span>
						</div>
						<div class="col-8 pl-4">
							<h2 class="resto-name ml-2 text-white" style="margin-top:20px;"><b>Take Order</b></h2>
						</div>
						<!--<div class="col-1">-->
						<!--<div class="google_lang_menu menu_details_translate">
            				<div id="google_translate_element"></div>
        				</div>-->
						<!--</div>-->
						<div class="col-3 p-1" style="text-align: right;color:white;margin-top:10px;">
						<?=$_SESSION['name']?>
							<!--<a href="<?=base_url()?>restaurant_managerorder/rest_manager_update_profile">
								<?php if ($profile[0]['profile_photo'] != 'assets/images/users/user.png' && $profile[0]['profile_photo'] != null) { ?>
								<img src="<?=$profile[0]['profile_photo']?>" class="shadow-sm" style="height:50px;width:50px;border-radius:50%">
								<?php } else{ ?>
								<img src="<?=base_url();?>assets/images/users/user.png" class="shadow-sm" style="height:50px;width:50px;border-radius:50%"><?php } ?>
							</a>-->
						</div>
					</div>
					<!--  <div class="text-white">
					<div class="title d-flex align-items-center">

					</div>
					</div> -->
				</div>
			</div>
		</div>
	</div>
	<div class="container-fluid" style="margin-top:90px !important;">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-12">

				<?php if ($this->uri->segment(4) =='')
				{
				?>
				<select class="form-control shadow-sm p-2 mb-2 bg-white" id="table_number" style="border:none">
					<option value="">Select Table Number</option>
					<?php 
					foreach ($table_number as $key => $value) 
					{ 
					?>
					<option value="<?=$value['table_detail_id']?>"><?=$value['title']?></option>
					<?php 
					}
					?>
				</select>
				<?php 
				}
				else
				{
				?>
				<span id="show_table_no">Table Number : <input type="text" name="" readonly="" id="table_number" class="shadow-sm p-2 mb-2 bg-white not_all_table" style="border:none"></span>
				<!-- <select class="form-control shadow-sm p-2 mb-2 bg-white not_all_table" id="table_number" style="border:none;">
				<?php foreach ($table_number as $key => $value) { 
				if($value['table_detail_id'] == $this->uri->segment(4))?>
				<option value="<?=$value['table_detail_id']?>" selected><?=$value['title']?></option>
				<?php } ?>
				</select> -->
				<?php 
				}
				?>
			</div>
		</div>
		<div class="row" style="margin-top:10px;">
			<div class="col-lg-6 col-md-6 col-sm-6 col-6">
				<!-- <div class="cust_id"><input type="hidden" class="customer_id" value="<?=$this->uri->segment(3)?>"></div> -->
				<input type="text" name="contact_no" value="<?=($this->uri->segment(5)!='') ? $this->uri->segment(5) : ''?>" id="contact_no" class="form-control shadow-sm p-2 mb-2 bg-white contact_no" placeholder="Mobile Number" style="border:none" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-6" id="cust_name">
				<input type="text" name="name" id="name" value="<?=($this->uri->segment(3)!='') ? str_replace('%20', ' ',$this->uri->segment(3)) : ''?>"readonly="" class="form-control shadow-sm p-2 mb-2 bg-white name" placeholder="Customer Name" style="border:none">
			</div>
		</div>
	</div>
	<div class="container-fluid showsearch" style="margin-top:10px;display: none;">
		<div class="input-group mt-3 rounded shadow-sm overflow-hidden">
			<div class="input-group-prepend">
				<button class="border-0 btn btn-outline-secondary text-dark bg-white btn-block"><i class="feather-search"></i></button>
			</div>
			<input type="text" class="shadow-none border-0 form-control" id="input-search" placeholder="Search for menu" aria-label="" aria-describedby="basic-addon1">
		</div>
	</div>
	<div class="osahan-checkout menu-section-onlyrecipes" style="display: none;">
		<!-- checkout -->
		<div class="p-3 osahan-cart-item">
			<div class="bg-white rounded shadow mb-3 py-2 append-group-recipes" id="show_all_recipes">

			</div>
			<div id="load-msg"></div>
		</div>
	</div>
	<div class="osahan-menu-fotter fixed-bottom px-3 py-2 text-center" style="z-index:999999">
		<div class="offset-md-8 col-3 rounded-circle mt-n4 px-3 py-2 float-right">
			<div class="rounded-circle mt-n0 shadow btn-cart" style="background-color:#DF2B5C;">
				<a href="#" id="changelink" class="text-white small font-weight-bold text-decoration-none" style="vertical-align: sub;">
					<i class="feather-shopping-cart"></i>
					<sub class="cart-total-count cart-count"></sub>
				</a>
			</div>
		</div>
	</div>
	
	
	<!-- The Modal -->
<div class="modal" id="addonmodel">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title" id="receipe_name">Recipe Name</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body" id="addon_menu_items">
        
      </div>

      <!-- Modal footer -->
      <div class="modal-footer" style="justify-content: flex-start;">
        <input type="hidden" id="customer_id" value="<?=$customer['customer_id'];?>">
        <div id="show_addcart_button" style="width:100%">
        </div>
        <!-- <button type="button" class="btn btn-success" id="addon_cart">Add</button> -->

        <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> -->
      </div>

    </div>
  </div>
</div>

	<?php
	require_once('web_footer.php');
	require_once('footer.php');
	?>
	<!-- <script type="text/javascript">
	function googleTranslateElementInit() {
	new google.translate.TranslateElement({ pageLanguage: 'en', includedLanguages: 'en,mr,hi', multilanguagePage: true}, 'google_translate_element');
	$(".goog-logo-link").empty();
	$('.goog-te-gadget').html($('.goog-te-gadget').children());
	$('.goog-close-link').click();
	setTimeout(function(){
	$('.goog-te-gadget .goog-te-combo').find('option:first-child').html('Translate');    
	}, 500);
	}
	</script>
	<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>   -->      
	
	<script src="<?=base_url();?>assets/Restaurantmanager/js/custom/Menulist.js?v=<?php echo uniqid(); ?>"></script>
	<script type="text/javascript">
		Menulist.base_url="<?=base_url();?>";
		Menulist.currency_symbol="<?=$currency_symbol[0]['currency_symbol']?>";
		
		//Menulist.restid="<?=$restid;?>";
		//Menulist.main_menu_id="<?=$main_menu_id;?>";
		//Menulist.tablecategory_id="<?=$tablecategory_id;?>";
		//Menulist.is_category_prices="<?=$user['is_category_prices'];?>";
		//Menulist.tableid="<?=$tableid;?>";
		//Menulist.customer_id="<?=$customer['customer_id'];?>";
		Menulist.init();
		/*$('.recipe-tabs').find('.receipes .card-body').addClass('active');*/
	</script>
	<script>
		function openNav() 
		{
			document.getElementById("mySidenav").style.width = "250px";
		}

		function closeNav() 
		{
			document.getElementById("mySidenav").style.width = "0";
		}
		
		$("#contact_no").on("keypress keyup",function(){
			if($(this).val() == '0'){
			  $(this).val('');  
			}
		});
	</script>
	<!-- <script>
	setInterval(function() {
	$.ajax({
	url: "<?=base_url();?>restaurant/deleteuser",
	type:'POST',
	dataType: 'json',
	data: {},
	success: function(result){
	if(result.status){
	window.location.href="<?=base_url();?>login/logout?status=delete";
	}

	}
	}, 6000);
	});
	</script> -->
</body>
</html>