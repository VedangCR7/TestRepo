<?php
/* var_dump($data);exit; */
/* ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); */

require_once('web_header.php');
require_once('sidebar.php');
?>
<!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> -->
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<style type="text/css">
.goog-te-banner-frame.skiptranslate {
    display: none !important;
    } 
body {
    top: 0px !important; 
    }
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
                    <div class="col-9 pl-4">
                      <h2 class="resto-name ml-2 text-white" style="margin-top:20px;"><b>Cart</b></h2>
                    </div>
                    <div class="col-2 p-1">
                        <?php if ($profile[0]['profile_photo'] != 'assets/images/users/user.png' && $profile[0]['profile_photo'] != null) {?>
                        <img src="<?=$profile[0]['profile_photo']?>" class="shadow-sm" style="height:50px;width:50px;border-radius:50%">
                      <?php } else{?>
                        <img src="<?=base_url();?>assets/images/users/user.png" class="shadow-sm" style="height:50px;width:50px;border-radius:50%"><?php } ?>
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
<?php if ($this->uri->segment(3) != 'undefined') {?>
<div class="container-fluid" id="addmenuhide" style="margin-top:90px;">
  <div class="d-flex flex-column">
      <span class="mb-0 small text-muted"><a href="<?=base_url('restaurant_managerorder/take_order/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$this->uri->segment(5))?>"><button class="btn btn-success btn-sm">Add Menu</button></a></span>
  </div>
</div>
<input type="hidden" name="" id="customer_name" value="<?=str_replace("%20"," ",$this->uri->segment(3));?>">
<input type="hidden" name="" id="customer_contact" value="<?=$this->uri->segment(5)?>">
<input type="hidden" name="" id="tableid" value="<?=$this->uri->segment(4)?>">
<div class="osahan-checkout" style="display: none;">
         <!-- checkout -->
         <div class="p-3 osahan-cart-item">
            <div class="bg-white rounded shadow mb-3 py-2 cart-item-list">
               
            </div>
         </div>
         <div class="mb-3 shadow bg-white rounded p-3 py-3 mt-3 clearfix">
           <!-- <div class="input-group-sm mb-2 input-group">
              <input placeholder="Your Previous Points" type="text" class="form-control">
              <div class="input-group-append ">
                <button id="button-addon2" type="button" class="btn btn-info bg-pink"><i class="feather-percent"></i> Redeem</button>
              </div>
           </div> -->
			<div class="input-group-sm mb-2 input-group" style="padding-bottom: 20px;">
				<input placeholder="No of persons" type="text" class="form-control" id="no_of_person" name="no_of_person">
            </div>
           <div class="mb-0 input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="feather-message-square"></i>
                </span>
              </div>
              <textarea placeholder="Any suggestions? We will pass it on..." aria-label="With textarea" class="form-control input-suggestion" name="suggetion"></textarea>
           </div>
        </div>
        <div class="shadow bg-white rounded p-3 mb-5 clearfix">
           <p class="mb-1">Item Total <span class="float-right text-dark item-total">$0</span></p>
           <p class="mb-1">CGST(0.00%) <span class="float-right text-dark cgst">$0</span></p>
           <p class="mb-1">SGST(0.00%) <span class="float-right text-dark sgst">$0</span></p>
          <!--  <p class="mb-1">Restaurant Charges <span class="float-right text-dark restaurant-charges">$62.8</span></p> -->
           <p class="mb-1 text-success">Total Discount<span class="float-right text-success total-discount">$0</span></p>
           <hr>
           <h6 class="font-weight-bold mb-0">TO PAY  <span class="float-right net-amount">$0</span></h6>
        </div>
        <a class="btn btn-success btn-block btn-lg fixed-bottom btn-place-order" href="javascript:;">Order Assign To Kitchen<i class="icofont-long-arrow-right"></i></a>
</div>
<div class="promo-area div-order-success" style="background-image: url('<?=base_url();?>assets/web/images/mobile bg.png');background-repeat: no-repeat;background-size: cover;background-position: center;display: none;">
    <div class="container">
        <div class="row align-items-center h-100">
            <div class="col-lg-12 vh-100 div-select-menu">
                <div class="promo-wrap promo-2">
                    <div class="logo mt-5">
                       <h4 class="mt-4 mb-2 thank-you-text">
                            Order is assigned to kitchen.
                       </h4>
                    </div>
                    <div class="promo-option mt-5 pt-3">
                        <a href="<?=base_url();?>restaurant_managerorder/take_order"  class="btn btn-outline-success p-4 pl-5 pr-5 btn-lg" style="font-weight: 800;">Take New Order</a>
                    </div>
                     <!-- <a class="btn btn-success btn-block btn-lg fixed-bottom btn-place-order" href="javascript:;" style="height: 75px;border-radius: 0px;"></a> -->
                </div>
            </div>
        </div>
    </div>
</div>
<div class="promo-area div-no-item" style="background-image: url('<?=base_url();?>assets/web/images/mobile bg.png');background-repeat: no-repeat;background-size: cover;background-position: center;display:none;">
    <div class="container">
        <div class="row align-items-center h-100">
            <div class="col-lg-12 vh-100 div-select-menu">
                <div class="promo-wrap promo-2">
                    <div class="logo mt-5">
                       <h4 class="mt-2 mb-2 warning-text">
                            Sorry no menu available in cart
                       </h4>
                    </div>
                    <div class="promo-option mt-3 pt-3">
                        <a href="<?=base_url('restaurant_managerorder/take_order');?>"  class="btn btn-outline-success p-4 pl-5 pr-5 btn-lg" style="font-weight: 800;">Take New Order</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } else{?>
  <div class="promo-area div-no-item" style="background-image: url('<?=base_url();?>assets/web/images/mobile bg.png');background-repeat: no-repeat;background-size: cover;background-position: center;">
    <div class="container">
        <div class="row align-items-center h-100">
            <div class="col-lg-12 vh-100 div-select-menu">
                <div class="promo-wrap promo-2">
                    <div class="logo mt-5">
                       <h4 class="mt-2 mb-2 warning-text">
                            Sorry no menu available in cart
                       </h4>
                    </div>
                    <div class="promo-option mt-3 pt-3">
                        <a href="<?=base_url('restaurant_managerorder/take_order');?>"  class="btn btn-outline-success p-4 pl-5 pr-5 btn-lg" style="font-weight: 800;">Take Order</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php }
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
        <script src="<?=base_url();?>assets/Restaurantmanager/js/custom/Checkout.js?v=<?php echo uniqid();?>"></script>
        <script type="text/javascript">
          Checkout.base_url="<?=base_url();?>";
          Checkout.currency_symbol="<?=$currency_symbol[0]['currency_symbol']?>";
          //Checkout.restid="<?=$restid;?>";
          //Checkout.main_menu_id="<?=$main_menu_id;?>";
          Checkout.tableid="<?=$this->uri->segment(4)?>";
          //Checkout.customer_id="<?=$this->uri->segment(3)?>";
          Checkout.init();
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
		<script>
			$(document).ready(function () 
			{
				$("#no_of_person").keypress(function (e) 
				{
					if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) 
					{
						return false;
					}
				});
			});
		</script>
   </body>
</html>