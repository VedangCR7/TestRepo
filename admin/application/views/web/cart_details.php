<?php
require_once('web_header.php');
?>
<div class="osahan-checkout" style="display: none;">
    <div class="bg-success border-bottom px-2 pt-3 pb-5 d-flex align-items-center">
        <a href='<?=base_url();?>menus/<?=$main_menu_id;?>/<?=$restid;?>/<?=$tableid;?>' id="backLink" class="bckToMainPage" style="padding: 7px 7px;">
            <img src="<?=base_url();?>assets/images/back-arrow.png" style="width: 30px;">
        </a>
        <h4 class="font-weight-bold m-0 text-white pl-5">Order</h4>
        <a class="btn btn-outline-dark text-white ml-5 float-right" href="<?=base_url();?>menus/<?=$main_menu_id;?>/<?=$restid;?>/<?=$tableid;?>" style="position: absolute;right: 9px;"><i class="fas feather-plus"></i> Add Menu</a>
    </div>
     <!-- checkout -->
    <div class="p-2 osahan-cart-item">
        <div class="d-flex mb-3 osahan-cart-item-profile bg-white shadow rounded p-3 mt-n5">
        <!--     <div class="menu-img rounded-circle" style="background-image:url('<?=$user['profile_photo']; ?>');background-repeat: no-repeat;background-size: cover;background-position: center;width: 70px;height: 70px;">
             </div> -->
           <img alt="osahan" src="<?=$user['profile_photo']; ?>" class="mr-3 rounded-circle img-fluid" style="width: 70px;height: 70px;">
            <div class="d-flex flex-column">
              <h6 class="mb-1 font-weight-bold">Hello <?=$customer['name'];?>,</h6>
              <p class="mb-0 small text-muted ml-2">Your order</p>
             
            </div>
        </div>
        <div class="bg-white rounded shadow mb-3 py-2 cart-item-list">
          

        </div>
		<div class="bg-white rounded shadow mb-3 py-2 p-3" id="addon_details_show_cart">
          

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
        <a class="btn btn-success btn-block btn-lg fixed-bottom btn-place-order" href="javascript:;">Place Your order<i class="icofont-long-arrow-right"></i></a>
    </div>
</div>
<div class="promo-area div-order-success" style="background-image: url('<?=base_url();?>assets/web/images/mobile bg.png');background-repeat: no-repeat;background-size: cover;background-position: center;display: none;">
    <div class="container">
        <div class="row align-items-center h-100">
            <div class="col-lg-12 vh-100 div-select-menu">
                <div class="promo-wrap promo-2">
                    <div class="logo mt-5">
                      <?php
                        if($user['profile_photo']=="assets/images/users/user.png" || $user['profile_photo']==""){
                      ?>
                        <a href="#">
                          <img src="<?php echo base_url().$user['profile_photo']; ?>" alt="">
                        </a>
                        <?php
                            }else{
                        ?>
                        <a href="#">
                          <img src="<?php echo $user['profile_photo']; ?>" alt="">
                        </a>
                        <?php
                        }
                        ?>
                       <h4 class="mt-4 mb-2 thank-you-text">
                            <?=$customer['name'];?>,<br>
                            Thank you for ordering
                       </h4>
                    </div>
                    <div class="promo-option mt-5 pt-3">
                        <a href="<?=base_url();?>menus/<?=$main_menu_id;?>/<?=$restid;?>/<?=$tableid;?>"  class="btn btn-outline-success p-4 pl-5 pr-5 btn-lg" style="font-weight: 800;">Menu Card</a>
                    </div>
                     <a class="btn btn-success btn-block btn-lg fixed-bottom btn-place-order" href="javascript:;" style="height: 75px;border-radius: 0px;"></a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="promo-area div-no-item" style="background-image: url('<?=base_url();?>assets/web/images/mobile bg.png');background-repeat: no-repeat;background-size: cover;background-position: center;display: none;">
    <div class="container">
        <div class="row align-items-center h-100">
            <div class="col-lg-12 vh-100 div-select-menu">
                <div class="promo-wrap promo-2">
                    <div class="logo mt-5">
                      <?php
                        if($user['profile_photo']=="assets/images/users/user.png" || $user['profile_photo']==""){
                      ?>
                        <a href="#">
                          <img src="<?php echo base_url().$user['profile_photo']; ?>" alt="">
                        </a>
                        <?php
                            }else{
                        ?>
                        <a href="#">
                          <img src="<?php echo $user['profile_photo']; ?>" alt="">
                        </a>
                        <?php
                        }
                        ?>
                       <h4 class="mt-2 mb-2 warning-text">
                            <?=$customer['name'];?>,<br>
                            Sorry no menu available in cart
                       </h4>
                    </div>
                    <div class="promo-option mt-3 pt-3">
                        <a href="<?=base_url();?>menus/<?=$main_menu_id;?>/<?=$restid;?>/<?=$tableid;?>"  class="btn btn-outline-success p-4 pl-5 pr-5 btn-lg" style="font-weight: 800;">Menu Card</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    require_once('web_footer.php');
?>
<script src="<?=base_url();?>assets/web/js/custom/Checkout.js?v=<?php echo uniqid();?>"></script>
<script type="text/javascript">
    Checkout.base_url="<?=base_url();?>";
    Checkout.restid="<?=$restid;?>";
    Checkout.main_menu_id="<?=$main_menu_id;?>";
    Checkout.tableid="<?=$tableid;?>";
    Checkout.customer_id="<?=$customer['customer_id'];?>";
    Checkout.currency_symbol="<?=$restaurant_type[0]['currency_symbol'];?>";
    Checkout.init();
    /*$('.recipe-tabs').find('.receipes .card-body').addClass('active');*/
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