<?php
require_once('web_header.php');
//require_once('header.php');
require_once('sidebar.php');
?>
<link href="<?=base_url();?>assets/plugins/sweet-alert/sweetalert.css" rel="stylesheet" />
<!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
<!-- <script src="https://kit.fontawesome.com/a076d05399.js"></script> -->
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
                      <h2 class="resto-name ml-2 text-white" style="margin-top:20px;"><b>Edit Order</b></h2>
                    </div>
                    <div class="col-1">
						<!--         <div class="google_lang_menu menu_details_translate">
            				  <div id="google_translate_element"></div>
        				    </div>
						        </div>-->
                    <div class="col-1 p-1">
					<!--
                      <?php if ($profile[0]['profile_photo'] != 'assets/images/users/user.png' && $profile[0]['profile_photo'] != null) {?>
                        <img src="<?=$profile[0]['profile_photo']?>" class="shadow-sm" style="height:50px;width:50px;border-radius:50%">
                      <?php } else{?>
                        <img src="<?=base_url();?>assets/images/users/user.png" class="shadow-sm" style="height:50px;width:50px;border-radius:50%"><?php } ?>
                    >-->
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
<div class="container-fluid" style="margin-top:90px;">
  <div class="row">
    <div class="col-lg-11 col-md-11 col-sm-10 col-10">
      <input type="text" name="recipe_name" data-provide="typeahead"  class="form-control input-item-name typeahead" placeholder="Enter Item Name" autocomplete="off" id="input-item-name">
      <input type="hidden" name="recipe_id" class="input-item-id" id="input-item-id">
      <input type='hidden' class="form-control" id="input-qty" name="qty"/>
      <input type='hidden' class="form-control" id="input-price" name="price" readonly="" />
      <input type='hidden' class="form-control" id="input-discount" name="discount_per"/>
    </div>
    <div class="col-lg-1 col-md-1 col-sm-2 col-2">
      <button type="button" class="btn btn-success" id="btn-add-item"><i class="feather-plus"></i></button>
    </div>
  </div>
</div>
<div class="osahan-checkout">
        <input type="hidden" name="" id="order_id" value="<?=$this->uri->segment(3)?>">
         <!-- checkout -->
         <div class="p-3 osahan-cart-item">
            <div class="bg-white rounded shadow mb-3 py-2 cart-item-list" style="display:none;">
              
            </div>
         </div>
         <div class="mb-3 shadow bg-white rounded p-1 py-2 clearfix" style="margin-top:-20px;">
           <!-- <div class="input-group-sm mb-2 input-group">
              <input placeholder="Your Previous Points" type="text" class="form-control">
              <div class="input-group-append ">
                <button id="button-addon2" type="button" class="btn btn-info bg-pink"><i class="feather-percent"></i> Redeem</button>
              </div>
           </div> -->
           <div class="mb-0 input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="feather-message-square"></i>
                </span>
              </div>
              <textarea placeholder="Any suggestions? We will pass it on..." aria-label="With textarea" class="form-control input-suggestion" id="suggetion" name="suggetion"></textarea>
           </div>
        </div>
        <div class="mb-3 shadow bg-white rounded p-3 py-3 mt-3 clearfix" style="font-weight:bold;margin-bottom:20px">
                  <div class="col-md-12 mb-1" style="text-align: right;">
                    <div class="order-details">
                      Gross Amount: <span class="span_gross_amount">0</span>
                      <input type="hidden" class="input_gross_amount" name="sub_total">
                    </div>
                  </div>
                  <div class="col-md-12 mb-1" style="text-align: right;">
                    <div class="order-details">
                      Discount Amount : <span class="span_discount_amount">0</span>
                      <input type="hidden" class="input_discount_amount" name="disc_total">
                    </div>
                  </div>
                  <div class="col-md-12 mb-1" style="text-align: right;">
                    <div class="order-details">
                      Net Bill Amount : <span class="span_net_amount">0</span>
                      <input type="hidden" class="input_net_amount" name="net_total">
                    </div>
                  </div>
              </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-12 text-center">
          <button class="btn btn-success save_product" style="width:50%">Save</button>
        </div>
</div>

<?php
    require_once('web_footer.php');
    require_once('footer.php');
?>
<script src="<?=base_url();?>assets/js/boostraptypeahead.js"></script>
<script src="<?=base_url();?>assets/Restaurantmanager/js/custom/Orderedit.js"></script>
<script src="<?=base_url();?>assets/plugins/sweet-alert/sweetalert.min.js"></script>
        <script src="<?=base_url();?>assets/js/sweet-alert.js"></script>

<script type="text/javascript">
  Orderedit.base_url="<?=base_url();?>";
  Orderedit.init();
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