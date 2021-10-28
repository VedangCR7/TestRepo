<?php
require_once('web_header.php');
$authority = explode(',',$restaurantsidebarshow[0]['menu_name']);
?>
<div class="promo-area" style="background-image: url('<?=base_url();?>assets/web/images/mobile bg.png');background-repeat: no-repeat;background-size: cover;background-position: center;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12">
                <div class="col-lg-12 div-spinner-foodnai">
                    <div class="d-flex align-items-center justify-content-center vh-100 index-page">
                        <div class="promo-wrap promo-2">
                            <div class="text-center">
                                <img src="https://foodnai.com/mob/images/Foodnai_logo.png" alt=""><br>
                                <div class="spinner"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="promo-wrap" style="display: none;">
                    <div class="logo mb-2">
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
                    </div>
                    <?php /* if(in_array('Order',$authority)){ */ ?>
                    <form class="form-singup" method="post" action="javascript:;">
                        <input type="hidden" name="id" class="input-id" value="">
                        <input type="hidden" name="restaurant_id" class="input-rest-id" value="<?=$restid;?>">
                        <input type="hidden" name="is_website" class="is_website" value="<?=$is_website;?>">
                        <div class="form-group mb-4">
                            <h4><?=$user['business_name'];?></h4>
                            <?php
                                /* if(!empty($table)){
                            ?>
                                <h5 class="m-0 tblnm "><?php echo $table['title']; ?></h5>
                            <?php
                                } */
                            ?>
                        </div>
                      <div class="form-group contact-div-part">
                        <input type="text" id="contact_no" name="contact_no" placeholder="Enter Your Phone *" required="" class="input-contact" minlength="8" maxlength="14">
                      </div>
                    <!--    <button type="button" class="custom-btn btn-check-contact contact-div-part">Submit</button> -->
                      <div class="form-group form-input-hide">
                        <input type="text" id="name" name="name" placeholder="Enter Your Name *" required=""  class="input-name" minlength="2" maxlength="25">
                      </div>
                      <div class="form-group form-input-hide">
                        <input type="email"  name="email" placeholder="Enter Your Email"  class="input-email">
                      </div>
                      <button type="submit" class="custom-btn form-input-hide">Submit</button>
                      <p class="mt-3">By clicking "Submit" I agree to <a href="<?php echo APP_POWEREDBY_LINK ?>/terms-conditions" target="_blank" class="terms-service-a">Terms of Service</a></p>
                      <p>Developed By <a href="<?php echo APP_POWEREDBY_LINK ?>" target="_blank"><?php echo APP_POWEREDBY_TITLE ?></a></p>
                    </form><?php /* } else{?>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                      <a href="<?=base_url()?>mainmenu/mainmenu/<?=$restid?>/<?=$tableid?>"><button class="btn btn-success" style="width:30%;height:50px;">Next</button></a>
                    </div>
                    <?php }  */?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require_once('web_footer.php');
?>
<script src="<?=base_url();?>assets/web/js/custom/Signup.js?v=<?php echo uniqid();?>"></script>
<script type="text/javascript">
    Signup.base_url="<?=base_url();?>";
    Signup.restid="<?=$restid;?>";
    Signup.tableid="<?=$tableid;?>";
    Signup.init();
    /*$('.recipe-tabs').find('.receipes .card-body').addClass('active');*/
</script>
<script type="text/javascript">
    setTimeout(function () {
        $('.div-spinner-foodnai').remove();
        $('.promo-wrap').show();
    }, 1000);
</script>
<script>
	$(document).ready(function()
	{
		$("#name").keypress(function(event)
		{
			var inputValue = event.charCode;
			
			if(!(inputValue >= 65 && inputValue <= 120) && (inputValue != 32 && inputValue != 0))
			{
				event.preventDefault();
			}
		});
	});
</script>
</body>
</html>  