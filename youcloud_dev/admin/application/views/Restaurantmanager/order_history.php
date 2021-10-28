<?php
//require_once('web_header.php');
require_once('header.php');
require_once('sidebar.php');
?>
<!-- <link rel="stylesheet" href="<?=base_url()?>assets/plugins/fuzzycomplete/dist/css/fuzzycomplete.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700">

<script src="https://code.jquery.com/jquery-2.2.3.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/plugins/fuzzycomplete/fuse.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/plugins/fuzzycomplete/dist/js/fuzzycomplete.min.js" type="text/javascript"></script> -->
<!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> -->
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<!-- jQuery library -->
<style type="text/css">
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
<!-- Sidebar -->
<!-- <div class="w3-sidebar w3-bar-block" style="display:none;z-index:9999999" id="mySidebar">
  <button onclick="w3_close()" class="w3-bar-item w3-button w3-large" style="text-align:right;"><span style="background-color:red;color:white;padding:5px;">&times;</span></button>
  <a href="#" class="w3-bar-item w3-button">Take Order</a>
  <a href="#" class="w3-bar-item w3-button">New Order</a>
  <a href="#" class="w3-bar-item w3-button">Order History</a>
</div> -->
<div class="menu-navigation" style="background: linear-gradient( 89.1deg,rgb(8,158,96) 0.7%,rgb(19,150,204) 88.4% );">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 mb-2">
                <div class="row">
                    <div class="col-1 p-1 text-center" style="margin-top:10px;"><span style="font-size:25px;cursor:pointer;color:white;" onclick="openNav()">&#9776;</span>
                    </div>
                    <div class="col-8 pl-4">
                      <h2 class="resto-name ml-2 text-white" style="margin-top:20px;"><b>Order History</b></h2>
                    </div>
                     <!--<div class="col-1">-->
						     <!--     <div class="google_lang_menu menu_details_translate">
            				    <div id="google_translate_element"></div>
        				      </div>-->
						       <!-- </div>-->
                    <div class="col-3 p-1" style="text-align: right;color:white;margin-top:10px;">
						<?=$_SESSION['name']?>
						<!-- <a href="<?=base_url()?>restaurant_managerorder/rest_manager_update_profile">
						  <?php if ($profile[0]['profile_photo'] != 'assets/images/users/user.png' && $profile[0]['profile_photo'] != null) {?>
							<img src="<?=$profile[0]['profile_photo']?>" class="shadow-sm" style="height:50px;width:50px;border-radius:50%">
						  <?php } else{?>
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
<div class="container-fluid" style="margin-top:10px !important;margin-bottom:30px;">
  <div class="row">
    <!-- <div class="col-lg-4 col-md-4 col-sm-5 col-5">
      <select class="form-control shadow-sm p-2 mb-2 bg-white" id="table_number" style="border:none">
          <option>Table No</option>
      </select>
    </div> -->
    <div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;">
      <input type="text" name="order_id" id="search_contents" class="form-control" placeholder="Search By Order Number/Table Number">
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;">
      <?php if ($this->uri->segment(3) == '') {?>
      <input type="date" name="" value="<?=date('Y-m-d')?>" id="date" max="<?=date('Y-m-d')?>" class="form-control shadow-sm p-2 mb-2 bg-white" style="border:none">
    <?php } else { ?>
      <input type="date" name="" value="<?=$this->uri->segment(3)?>" id="date" max="<?=date('Y-m-d')?>" class="form-control shadow-sm p-2 mb-2 bg-white" style="border:none">
      <?php } ?>
    </div>
  </div>
</div>
<div class="container-fluid" style="min-height:500px">
  <div class="row allorders" style="margin:2px;" id="allorders">
    
  </div>
</div>
<div class="osahan-menu-fotter fixed-bottom px-1 py-2 text-center">
    <div class="offset-md-8 col-3 rounded-circle mt-n4 px-3 py-2 float-right">
        <div class="bg-success rounded-circle mt-n0 shadow btn-cart">
          <a href="<?=base_url('restaurant_managerorder/take_order')?>" class="text-white small font-weight-bold text-decoration-none" style="vertical-align: sub;">
            <i class="feather-plus"></i>
          </a>
      </div>
    </div>
 </div>
 <!-- The Modal -->
<div class="modal" id="view_order_details">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title" id="order_no_title" style="font-size:16px"></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body" style="font-weight:normal">
        <table class="table table-bordered" style="font-size:14px;">
          <thead class="bg-success text-white">
            <tr>
              <th>Menu Item</th>
              <th>Qty</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody id="order_body_view">
            
          </tbody>
          <tfoot>
            <tr>
              <td colspan="2" class="text-right" style="padding:2px;">Sub Total</td>
              <td id="sub_total" class="text-right" style="padding:2px;"></td>
            </tr>
            <tr>
              <td colspan="2" class="text-right" style="padding:2px;">Disc. Total</td>
              <td id="dis_total" class="text-right" style="padding:2px;"></td>
            </tr>
            <tr>
              <td colspan="2" class="text-right" style="padding:2px;">Net Total</td>
              <td id="net_total" class="text-right" style="padding:2px;"></td>
            </tr>
          </tfoot>
        </table>
      </div>
      <input type="hidden" name="" class="input-order-id">

      <!-- Modal footer -->
      <div class="modal-footer" id="footer_status_button">
        
      </div>
    </div>
  </div>
</div>


<div id="table-order-modal" class="modal fade">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content ">
      <div class="modal-header pd-x-20">
        <h4 class="modal-title">Table Order Details</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body pd-20 row-tableorder-details">
        <input type="hidden" name="table_order_id" class="input-tableorder-id">
        <div class="row">
                  <div class="col-md-4 col-sm-6 col-6 mb-3">
                <div class="order-details" style="margin-top: 0px;">
                  Order Id: <br><span class="span_tableorder_no"></span>
                </div>
              </div>
                <!-- <div class="col-md-4 mb-3">
                  <div class="order-details">
                     Date : <span class="span_table_orderdate"></span>
                  </div>
                </div> -->
                <div class="col-md-4 col-sm-6 col-6 mb-3">
                  <div class="order-details">
                     Table No : <br><span class="span_tableno">IN-04</span>
                  </div>
                </div>
              </div>
              <div class="row" style="border-top: 1px solid #ddd;">
                <div class="clearfix">
                </div>
              </div>
              <div class="row mt-3 mb-3">
                <!-- <button type="button" class="btn mr-2 btn-primary btn-create-invoice">Create Invoice</button> -->
              </div>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive mt-2">
              <table class="table card-table table-vcenter text-nowrap table-head" id="table-modalorders">
                <thead >
                  <tr>
                    <!-- <th><input type="checkbox" class="input-checkall-orders" name="is_order_checkall" ></th> -->
                    <th>Order No</th>
                    <th>Cust. Name</th>
                    <th>Order Status</th>
                    <th>Order By</th>
                    <th>Total</th>
                    <th>Is Invoiced</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody class="tbody-tableorder-list">
                
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div><!-- modal-body -->
    </div>
  </div><!-- modal-dialog -->
</div><!-- modal -->


<div id="order-modal" class="modal fade">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content ">
      <div class="modal-header pd-x-20">
        <h4 class="modal-title">Order Details</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body pd-20 row-order-details">
        <input type="hidden" name="order_id" class="input-order-id">
        <input type="hidden" name="table_order_id" class="tableinput-order-id">
        <div class="row">
                  <div class="col-md-6 col-sm-6 col-6 mb-3">
                <div class="order-details" style="margin-top: 0px;">
                  Order No:<br> <span class="span_order_no"></span>
                </div>
              </div>
                <!-- <div class="col-md-6 mb-3">
                  <div class="order-details">
                     Date : <span class="span_order_date"></span>
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="order-details">
                     Cust Name : <span class="span_customer_name"></span>
                  </div>
                </div>

                <div class="col-md-6 mb-3">
                  <div class="order-details">
                     Cust Mob. : <span class="span_contact_no"></span>
                  </div>
                </div> -->
                <div class="col-md-6 col-sm-6 col-6 mb-3">
                  <div class="order-details">
                     Table No : <br><span class="span_table_no"></span>
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="order-details">
                     Orders Status : <span class="span_status badge"></span>
                  </div>
                </div>
              </div>
              <div class="row" style="border-top: 1px solid #ddd;">
                <div class="clearfix">
                </div>
              </div>
              <div class="row mt-2">
                <div class="col-md-12 table-responsive">
					<table id="table1" class="table table-border">
						<thead class="bg-success">
							<tr>
								<th width="10">No</th>
								<th>Item</th>
								<th class="text-right">Qty</th>
								<th class="text-right">Price</th>
							</tr>
						</thead>
						<tbody class="tbody-order-items">
						</tbody>
						<tfoot>
							<tr class="order-details">
								<td colspan="3" class="text-right">Sub Total</td>
								<td class="text-right span_sub_total"></td>
							</tr>
							<tr class="order-details">
								<td colspan="3" class="text-right">Disc. Total</td>
								<td class="text-right span_disc_total"></td>
							</tr>
							<tr class="order-details">
								<td colspan="3" class="text-right">Disc.(%)</td>
								<td class="text-right span_dis_total_percentage"></td>
							</tr>
							<tr class="order-details">
								<td colspan="3" class="text-right">CGST.(%)</td>
								<td class="text-right span_cgst_per"></td>
							</tr>
							<tr class="order-details">
								<td colspan="3" class="text-right">SGST.(%)</td>
								<td class="text-right span_sgst_per"></td>
							</tr>
							<tr class="order-details">
								<td colspan="3" class="text-right">Net Total</td>
								<td class="text-right span_net_total"></td>
							</tr>
						</tfoot>
					</table>
                </div>
		   </div><!-- /.col-->
		</div><!-- modal-body -->
		<div class="modal-footer">
			<button type="button" class="btn btn-orange btn-block-customer btn-change-status" order-status="Blocked">Block</button>
			<button type="button" class="btn btn-success btn-accept btn-change-status" order-status="Confirmed">Confirm</button>
			<button type="button" class="btn btn-success btn-assign btn-info btn-change-status" order-status="Assigned To Kitchen">Assign To Kitchen</button>
			<!-- <button type="button" class="btn btn-indigo btn-served  btn-change-status" order-status="Food Served">Food Serve</button> -->
			<!-- <button type="button" class="btn btn-success btn-complete btn-change-status" order-status="Completed">Complete</button> -->
			<button type="button" class="btn btn-danger btn-cancel btn-change-status" data-dismiss="modal" order-status="Canceled">Cancel</button>
		</div>
	</div>
  </div><!-- modal-dialog -->
</div><!-- modal -->

<?php
    require_once('footer.php');
?>
<script src="<?=base_url();?>assets/Restaurantmanager/js/custom/Orderhistory.js?v=<?php echo uniqid();?>"></script>

<script type="text/javascript">
  Orderhistory.base_url="<?=base_url();?>";
  Orderhistory.currency_symbol="<?=$currency_symbol[0]['currency_symbol']?>";
  Orderhistory.init();
  /*$('.recipe-tabs').find('.receipes .card-body').addClass('active');*/
</script>
<script>
function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}
</script>
   </body>
</html>