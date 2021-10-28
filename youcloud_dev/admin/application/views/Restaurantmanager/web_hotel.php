<?php
require_once('web_header.php');
?>
<div class="promo-area" style="background-image: url('<?=base_url();?>assets/web/images/mobile bg.png');background-repeat: no-repeat;background-size: cover;background-position: center;">
    <div class="container">
        <div class="row align-items-center h-100">
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
            <div class="col-lg-12 vh-100 div-select-menu" style="display: none;">
                <?php
                if(!$restid){
                ?>
                <div class="promo-wrap promo-2">
                    <div class="alert alert-danger">
                        <strong>Sorry !</strong> Restaurant not found
                    </div>
                </div>
                <?php
                }
                else if($user=="notactivated"){
                ?>
                <div class="promo-wrap promo-2">
                    <div class="alert alert-danger">
                        <strong>Sorry !</strong> Restaurant is inactive
                    </div>
                </div>
                <?php
                }else{

                ?>
                <div class="promo-wrap promo-2">
                    <div class="logo mt-5">
                      <h4 class="mt-2 mb-2">Welcome <?=$customer['name'];?></h4>
                      <?php
                        if(!empty($table)){
                      ?>
                        <h5 class="m-0 tblnm"><?php echo $table['title']; ?></h5>
                      <?php
                        }
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
                    <div class="promo-option">
                        <?php
                            if(count($menu_groups)>1){
                                 foreach ($menu_groups as $group) {
                                if($tableid!="")
                                    $url=base_url().'menus/'.$group['main_menu_id'].'/'.$restid.'/'.$tableid;
                                else
                                    $url=base_url().'menus/'.$group['main_menu_id'].'/'.$restid;
                        ?>
                            <a href="<?=$url;?>" alt='<?=$group['main_group']; ?>' class="custom-btn"><?=$group['main_group']; ?></a>
                        <?php
                                }
                            }else{
                                if($tableid!="")
                                    $url=base_url().'menus/1/'.$restid.'/'.$tableid;
                                else
                                    $url=base_url().'menus/1/'.$restid;

                        ?>  
                            <a href='<?=$url;?>' class="custom-btn" alt='<?=$menu_groups[0]['main_group']; ?>'>Restaurant Menu</span>
                            </a>
                        <?php
                            }
                      ?>
                       
                    </div>
                </div>
                <?php
                    }
                ?>
            </div>
        </div>
    </div>
</div>
<?php
require_once('web_footer.php');
?>
      <!-- Custom scripts for all pages-->
    <script type="text/javascript">
        /* Using setTimeout to execute a function after 2 seconds. */
        setTimeout(function () {
            $('.div-spinner-foodnai').remove();
            $('.div-select-menu').show();
           /* Redirect with JavaScript */
           /*window.location.href= '<?php echo $main_link; ?>select_menu.php?rid=<?php echo $resto_id; ?>';*/
        }, 2000);
       
    </script>
   </body>
</html>