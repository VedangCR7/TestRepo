<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="Foodnai" name="description">
        <meta content="foodnai.com" name="author">
        <!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="<?=base_url();?>assets/images/brand/FoodNAI_favicon.png" />

        <!-- Title -->
        <title>FoodNAI - food allergen nutrition information</title>
        <link rel="stylesheet" href="<?=base_url();?>assets/web/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?=base_url();?>assets/web/css/owl.carousel.min.css">
        <link rel="stylesheet" href="<?=base_url();?>assets/web/css/animate.css">
         <link href="<?=base_url();?>assets/web/css/feather.css" rel="stylesheet" type="text/css">
        <!-- Style css -->
        <link rel="stylesheet" href="<?=base_url();?>assets/web/css/style.css?v=4">
   </head>
   <body data-spy="scroll" data-target=".maks" data-offset="90">
        <!-- <div class="spinner1">
            <p class="loaderTxt"><b><?=$user['business_name'];?></b>
                <div class="spinner"></div>
            </p>
        </div> -->
        <div class="img-banner">
            <div class="row parallax-contennt">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="parallax <?php if($recipe['recipe_type']=="veg") echo 'veg-recipe'; else if($recipe['recipe_type']=="nonveg") echo 'nonveg-recipe';?>" id="dish_image" style="background-image:url('<?=$recipe['recipe_image']?>');background-repeat: no-repeat;background-size: cover;background-position: center;">
                     
                </div>
                <a href="<?=base_url()?>menus/<?=$group_details['main_menu_id'];?>/<?=$restid;?>" id="backLink">
                    <span class="chef-icon top-right"><i class="feather-arrow-left" aria-hidden="true"></i> </span>
                </a>
                <div class="row">
                    <div class="col-7" id="dishPrice">
                            <?php
                                if($group_details['main_menu_id']==1){
                                    if($recipe['price']=='Recipe Price' || $recipe['price']==''){
                                        if($restid == 103){ $price1 = 'MZN 0.00/-'; }
                                        else{ $price1='&#8377; 0.00/-'; }
                                    }else{
                                        if($restid == 103){ $price1='MZN '.$recipe['price'].'/-'; }
                                        else { $price1='&#8377; '.$recipe['price'].'/-'; }
                                    }
                                ?>
                                 <span class="badge badge-success"><?=$price1;?></span>
                                <?php
                                }
                                else{
                                ?>
                                <span class="bar-price badge badge-success">
                                <?php
                                    $multi_prices=array();
                                    if($recipe['price'] !='' && $recipe['quantity'] != ''){
                                        $multi_prices[$recipe['quantity']]= $recipe['price']; 
                                    }
                                    
                                    if($recipe['price1'] !='' && $recipe['quantity1'] !=''){
                                        $multi_prices[$recipe['quantity1']] = $recipe['price1'];
                                    }
                                        
                                    if($recipe['price2'] !='' && $recipe['quantity2'] !=''){
                                        $multi_prices[$recipe['quantity2']] = $recipe['price2'];
                                    }
                                        
                                    if($recipe['price3'] !='' && $recipe['quantity3'] !=''){
                                        $multi_prices[$recipe['quantity3']] = $recipe['price3'];
                                    }
                                       
                                    if($resto_id == 103){
                                        $currency = 'MZN';
                                    }
                                    else{ 
                                        $currency = '&#8377;'; 
                                    }
                                    $bar_prices="";
                                    foreach($multi_prices as $k => $v) { 
                                        if($bar_prices==""){
                                            $bar_prices = "<b>$k :</b> $currency $v/-"; 
                                        }
                                        else{
                                            $bar_prices = "<br><b>$k :</b> $currency $v/-"; 
                                        }
                                        echo $bar_prices;
                                    }
                                ?>
                                </span>
                            <?php               
                                }
                            ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4"></div>
            </div>
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4 ">
                    <div class="card vfirstcard">
                        <h6 class="dish_name pt-2"><?=$recipe['name'];?></h6>
                        <p id="ingredients">
                            <?php
                                if($ingredients!=""){
                                    $strings = implode(',', array_map('ucfirst', explode(',', $ingredients)));
                                    echo ucwords($strings);
                                }
                                else
                                    echo $recipe['description'];
                            ?>
                            
                        </p>
                    </div>
                </div>
                <div class="col-md-4"></div>
            </div>

            <div class="fixed-bottom1" id="footer">
                <div class="row">
                    <div class="col-6 pp">
                        <a href="https://www.foodnai.com/privacy.html" class="ptlink">Privacy Policy</a>
                    </div>
                    <div class="col-6 tac">
                        <a href="https://www.foodnai.com/terms-conditions.html" class="ptlink">Terms And Conditions</a>
                    </div>
                </div>
            </div>
        </div>
        <script src="<?=base_url();?>assets/web/js/jquery-3.5.1.min.js"></script>
        <script src="<?=base_url();?>assets/web/js/popper.min.js"></script>
        <script src="<?=base_url();?>assets/web/js/bootstrap.min.js"></script>
        <script src="<?=base_url();?>assets/web/js/owl.carousel.min.js"></script>
        <script src="<?=base_url();?>assets/web/js/jquery.easing.1.3.js"></script>
        <script src="<?=base_url();?>assets/web/js/custom.js"></script>
        <script>
            $(window).on('load', function(){ 
                $(".spinner1").fadeOut("fast");
            });
        </script>
   </body>
</html>