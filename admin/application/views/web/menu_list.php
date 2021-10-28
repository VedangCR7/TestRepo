<?php
require_once('web_header.php');
$authority = explode(',',$restaurantsidebarshow[0]['menu_name']);

$autho = $restaurantsidebarshow[0]['menu_name'];
$is_website = $_REQUEST['is_website'];
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style type="text/css">
	.owl-carousel .owl-dots.disabled, .owl-carousel .owl-nav.disabled {
		display: block;
	}
	
	.pricecss {
		width:75%;
	}
	
	@media only screen and (max-width: 600px) 
	{
		.owl-carousel .owl-dots.disabled, .owl-carousel .owl-nav.disabled 
		{
			display: none;
		}
		
		.pricecss 
		{	
			width: 60%;
		}
	}
	
	.form-control:focus 
	{
		box-shadow: 0 0 0 0.2rem rgb(252 252 252 / 25%);
	}
	
	@media only screen and (max-width: 767px) 
	{
		.section-padding 
		{
			padding: 140px 0px 0px;
		}
		
		.cart_responsive
		{
			width: 20%!important;
			margin-left: calc(100% - 65%)!important;
		}
	}

    @media only screen and (max-width: 767px) 
	{
		.food-menu1 
		{
			padding: 2px 2px 0px !important; 
		}

		.food-menu1 
		{
			background: #FFFFFF;
			box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.15);
			border-radius: 10px;
			padding: 3px 0 3px 3px !important;
			margin-bottom:3px !important;
			min-height:20px !important;
		}
    }
	
    .food-menu1 .menu-txt ul li span 
	{
		margin-bottom: 0px !important;
		font-weight: 700;
		line-height: 1.3;
		color: #000;
		font-size: 16px;
		font-size: 13px;
	}

	.view-recipe
	{
		margin-right: 0px!important;
	}
	
	.show_addon_popup
	{
		margin-top: 10px!important;
	}
	
	/* .grid_btns
	{
		display:none;
	} */
</style>
<div class="spinner1"><p class="loaderTxt"><b><?php echo $user['business_name']; ?></b><div class="spinner"></div></p></div>
<div class="menu-navigation">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 mb-2">
                <div class="row">
                    <div class="col-1 p-0">
                        <input type="hidden" id="authority" value="<?=$autho?>">
                        <input type="hidden" id="is_website" value="<?=$is_website?>">
                        <?php
                        /* if($tableid!=""){
                        ?>
                            <a href='<?=base_url();?>mainmenu/mainmenu/<?=$restid;?>/<?=$tableid;?>' id="backLink" class="bckToMainPage">
                        <?php
                        }else{
                        ?>
                          <a href='<?=base_url();?>qrcode/<?=base64_encode($restid);?>/<?=base64_encode($tableid);?>' id="backLink" class="bckToMainPage">
                        <?php
                        } */
                        ?>
						<?php
                        if($tableid!="")
						{
							if($is_website!="")
							{
							?>
                            <a href='<?=base_url();?>mainmenu/mainmenu/<?=$restid;?>/<?=$tableid;?>/<?=$is_website;?>' id="backLink" class="bckToMainPage">
							<?php
							}
							else
							{
							?>
                            <a href='<?=base_url();?>mainmenu/mainmenu/<?=$restid;?>/<?=$tableid;?>' id="backLink" class="bckToMainPage">
							<?php
							}
						}
						else
						{
							if($is_website!="")
							{
							?>
                            <a href='<?=base_url();?>qrcode/<?=base64_encode($restid);?>/<?=base64_encode($tableid);?>/<?=$is_website;?>' id="backLink" class="bckToMainPage">
							<?php
							}
							else
							{
							?>
                            <a href='<?=base_url();?>qrcode/<?=base64_encode($restid);?>/<?=base64_encode($tableid);?>' id="backLink" class="bckToMainPage">
							<?php
							}
                        }
                        ?>
                        <img src="<?=base_url();?>assets/images/back-arrow.png" style="width: 30px;">

                        <!-- <i class=" feather-arrow-left"></i>  -->
                        </a>
                    </div>
                    <div class="col-8 pl-2">
                        <h4 class="resto-name ml-2"><b><?=$user['business_name']; ?></b></h4>
                    </div>
                    <!-- <div class="col-3 p-0">
                        <div class="google_lang_menu" style="display: none;">
                            <div id="google_translate_element"></div>
                        </div>
                    </div> -->
                    <div class="col-3 p-0">
                    <?php if($restaurant_type[0]['restauranttype'] == 'both'){ ?>
                        <select class="form-control" style="padding: 0px 0px!important;" id="choose_recipetype" main-menu-id="<?=$this->uri->segment(2)?>" rest-id="<?=$this->uri->segment(3)?>" table-id="<?=$this->uri->segment(4)?>">
                            <option value="" <?=($_GET['recipetype']=='')? 'selected':''?>>All</option>
                            <option value="veg" <?=($_GET['recipetype']=='veg')? 'selected':''?>>Veg</option>
                            <option value="nonveg" <?=($_GET['recipetype']=='nonveg')? 'selected':''?>>NonVeg</option>
                        </select><?php } else{ ?>
                            <input type="hidden" id="choose_recipetype" value="<?=$_GET['recipetype']?>" main-menu-id="<?=$this->uri->segment(2)?>" rest-id="<?=$this->uri->segment(3)?>" table-id="<?=$this->uri->segment(4)?>">
                        <?php } ?>
                    </div>
                </div>
               <!--  <div class="text-white">
                   <div class="title d-flex align-items-center">
                     
                   </div>
                </div> -->
                <div class="input-group mt-3 rounded shadow-sm overflow-hidden" style="margin-top: 0.5rem!important;">
                   <div class="input-group-prepend">
                      <button class="border-0 btn btn-outline-secondary text-dark bg-white btn-block"><i class="feather-search"></i></button>
                   </div>
                   <input type="text" class="shadow-none border-0 form-control" id="input-search" placeholder="Search for <?=$main_menu['name'];?>s" aria-label="" aria-describedby="basic-addon1">
                </div>
                <div class='searchBoxRes'>
                    <div id='basicsAccordion' style='display:none;'>
                        
                    </div>
                </div>
             </div> 
            <div class="col-lg-12 ">				
				<?php
				$menugroups_count = count($menu_groups);
				
				if($menugroups_count > 0)
				{
					$i=0;
					if($menugroups_count > 1)
					{
						echo '<div class="nav-carousel owl-carousel">';
					}
					else
					{
						echo '<div class="new" style="width: 141.429px;">';
						/* echo '<div class="nav-carousel owl-carousel">'; */
					}
					
                    foreach ($menu_groups as $group) 
					{
						if($i < $menugroups_count)
						{
						?>
                        <a href="#group-<?=$group['id'];?>" class="item a-group-item" group-id="<?=$group['id'];?>" restid="<?=$restid;?>">
                            <?php
                                if($group['image_path']!=""){
                            ?>
                            <img src="<?=$group['image_path'];?>" alt="menu">
                            <?php
                                }
                                else{
                            ?>
                            <img src="<?=base_url();?>assets/images/users/menugroup.png" alt="menu">
                            <?php
                                }
                            ?>
                            <p class="p-group-name"> <?=$group['title'];?></p>

                        </a>
						<?php
						$i++;
						}
                    }
					/* echo $menugroups_count;echo '<br>';
					echo $i;exit; */
                    ?>
                </div>
				<?php
				}
				else
				{?>
					<div class="row">
						<div class="col-lg-12">
							<div class="section-header">
								<h2 class="section-title" style="font-size:25px;">Menus are not available for applied filter</h2>
							</div>
						</div>
					</div>
				<?php
				}
				?>
            </div>
        </div>
    </div>
</div>
<!-- Menu Carousel Section End -->
<div class="space"></div>
<!-- Menu Section Start -->
<div class="menu-section section-search-padding" id="search-list-menu" style="display: none;padding: 140px 0 0;">
    <div class="container">
        <div class="col-lg-6 col-sm-12 col6-food-menu loader-div" style="display: none;">
            <div class="food-menu animated-background">
                <div class="row ">
                    <div class="col-3 pr-0">
                        <div class="col-12 p-0 justify-content-center">
                            <div class="menu-img background-masker" style="background-image:url('<?=base_url();?>assets/images/users/default.jpg');background-repeat: no-repeat;background-size: cover;background-position: center;">
                               
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-12 p-0 col-price-12 mt-2">
                            <p class="price-meta mb-0 background-masker" style="width: 90%;"></p>
                        </div>
                    </div>
                    <div class="col-9 pr-0">
                        <div class="menu-txt">
                            <h3 class="background-masker">
                                <a href="#" ></a>
                            </h3>
                             
                            <ul class="menu-ingredients mr-5">
                                <li class="background-masker mb-2"></li>
                                <li class="background-masker mb-2"></li> 
                                <li class="view-recipe">
                                    <span class="badge badge-success background-masker mb-0"><a href="#"></a></span>
                                </li>
                            </ul>
                             
                        </div> 
                    </div>
                </div>
            </div>
        </div>
        <div class="row div-search-list">
            
        </div>
    </div>
</div>
<div class="menu-section menu-section-recipes section-padding menu-details-div" style="padding-bottom:0px">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-right grid_btns">
                <?php if($_GET['list_view']=='yes'){?>
                <input type="hidden" id="show_view" value="yes">
                <button class="btn btn-success show_view" data-value="yes" main-menu-id="<?=$this->uri->segment(2)?>" rest-id="<?=$this->uri->segment(3)?>" table-id="<?=$this->uri->segment(4)?>"><i class="fa fa-bars"></i> List</button>
                <button class="btn btn-secondary show_view" data-value="no" main-menu-id="<?=$this->uri->segment(2)?>" rest-id="<?=$this->uri->segment(3)?>" table-id="<?=$this->uri->segment(4)?>"><i class="fa fa-th-large"></i> Grid</button>
                <!-- <input type="radio" class="show_view" value="no" name="show_view" style="width:auto" main-menu-id="<?=$this->uri->segment(2)?>" rest-id="<?=$this->uri->segment(3)?>" table-id="<?=$this->uri->segment(4)?>">&nbsp;Grid View&nbsp;&nbsp;
                <input type="radio" class="show_view" value="yes" name="show_view" style="width:auto" checked main-menu-id="<?=$this->uri->segment(2)?>" rest-id="<?=$this->uri->segment(3)?>" table-id="<?=$this->uri->segment(4)?>">&nbsp;List View--><?php } else{
                    ?>
                    <input type="hidden" id="show_view" value="no">
                <button class="btn btn-secondary show_view" data-value="yes" main-menu-id="<?=$this->uri->segment(2)?>" rest-id="<?=$this->uri->segment(3)?>" table-id="<?=$this->uri->segment(4)?>"><i class="fa fa-bars"></i> List</button>
                <button class="btn btn-success show_view" data-value="no" main-menu-id="<?=$this->uri->segment(2)?>" rest-id="<?=$this->uri->segment(3)?>" table-id="<?=$this->uri->segment(4)?>"><i class="fa fa-th-large"></i> Grid</button>
                <!-- <input type="radio" class="show_view" value="no" name="show_view" style="width:auto" checked main-menu-id="<?=$this->uri->segment(2)?>" rest-id="<?=$this->uri->segment(3)?>" table-id="<?=$this->uri->segment(4)?>">&nbsp;Grid View&nbsp;&nbsp;
                <input type="radio" class="show_view" value="yes" name="show_view" style="width:auto" main-menu-id="<?=$this->uri->segment(2)?>" rest-id="<?=$this->uri->segment(3)?>" table-id="<?=$this->uri->segment(4)?>">&nbsp;List View -->
                   <?php }?>
            </div>
        </div>
    </div>
</div>
<?php
    if(!empty($admin_offer) && count($admin_offer)>0){
?>
<div class="menu-section menu-section-recipes menu-details-div" id="todays-special" style="padding-bottom:0px">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-header">
                    <h2 class="section-title">Offers</h2>
					
                    <!-- <h4>2 Courses & 3 Courses</h4> -->
                </div>
            </div>
        </div>
        <div class="row">
            <?php
			foreach ($admin_offer as $recipe) 
			{
				if($_GET['list_view']=='yes')
				{
                    $class_name='food-menu1';
                }
                else
				{
                    $class_name='';
                }
            ?>
            <div class="list-card col-lg-6 col-sm-12 col6-food-menu offer-section">
                <div class="food-menu <?=$class_name?>" style="min-height:20px !important;">
                    <div class="row">
                        <?php if($_GET['list_view']!= 'yes'){ ?>
                        <div class="col-3 pr-0">
                            <div class="col-12 p-0 justify-content-center">
                                 <?php
                                if($recipe['offer_image']=="" || $recipe['offer_image']=="assets/images/users/menu.png")
                                    $offer_image=base_url()."assets/images/users/menu.png";
                                else
                                     $offer_image=$recipe['offer_image'];
                                ?>
                                <?php
                                        if($tableid!=""){
                                        ?>
                                            <a href="<?=base_url();?>menus/offerview/<?=$group['id'];?>/<?=$recipe['offer_id'];?>/<?=$recipe['id'];?>/<?=$restid;?>/<?=$tableid;?>?is_website=<?=$_GET['is_website']?>">
                                                <div class="menu-img <?php if($recipe['recipe_type']=="veg") echo 'veg-recipe'; else if($recipe['recipe_type']=="nonveg") echo 'nonveg-recipe';?>" style="background-image:url('<?=$offer_image;?>');background-repeat: no-repeat;background-size: cover;background-position: center;">
                                    <!-- <img src="<?=$recipe['offer_image']?>" alt=""> -->
                                </div>
                                            </a>
                                        <?php
                                        }else{
                                        ?>
                                            <a href="<?=base_url();?>menus/offerview/<?=$group['id'];?>/<?=$recipe['offer_id'];?>/<?=$recipe['id'];?>/<?=$restid;?>/0?is_website=<?=$_GET['is_website']?>">
                                                <div class="menu-img <?php if($recipe['recipe_type']=="veg") echo 'veg-recipe'; else if($recipe['recipe_type']=="nonveg") echo 'nonveg-recipe';?>" style="background-image:url('<?=$offer_image;?>');background-repeat: no-repeat;background-size: cover;background-position: center;">
                                    <!-- <img src="<?=$recipe['offer_image']?>" alt=""> -->
                                </div>
                                            </a>
                                        <?php
                                        }?>
                            </div>
                            <div class="clearfix"></div>
                            
                        </div>
                
                        <div class="col-9 pr-0">
                            <div class="menu-txt">
                                <h3>
                                    <?php
                                    if($tableid!=""){
                                    ?>
                                       
                                        <a href="<?=base_url();?>menus/view/<?=$group['id'];?>/<?=$recipe['id'];?>/<?=$restid;?>/<?=$tableid;?>?is_website=<?=$_GET['is_website']?>"><?php echo ucwords(strtolower($recipe['title']))." <br>".$recipe['name']; ?></a>
                                    <?php
                                    }else{
                                    ?>
                                       
                                        <a href="<?=base_url();?>menus/view/<?=$group['id'];?>/<?=$recipe['id'];?>/<?=$restid;?>/0?is_website=<?=$_GET['is_website']?>"><?php echo ucwords(strtolower($recipe['title']))." <br>".$recipe['name']; ?></a>
                                    <?php
                                    }
                                    ?>
                                </h3>
                                 
                                <ul class="menu-ingredients" recipe-id="<?=$recipe['id'];?>" style="min-height:50px !important;">
                                    <?php if($_GET['list_view']!= 'yes'){ ?>
                                    <li class="li-ingredients" style="width: 95%;">
                                        <?php
                                            echo $recipe['description'];
                                        ?>
                                    </li>
                                    <?php } ?>
                                      
                                    <!-- <li class="not-besttime-toeat" style="height: 50px;">
                                    </li> -->
                                      
                                    <li class="view-recipe float-right mb-2 <?php if($tableid==""){ echo 'mr-3';}?>" style="width:100%;margin-top:10px;">
                                        <span class="price-meta float-left pricecss" style="color:#C70039;width:80%">
                                    <?php
                                        if($recipe['price']=='Recipe Price' || $recipe['price']=='' || $recipe['price']=="MRP" || $recipe['price']=="dv.kjndvkjnd"){
                                            if($restid == 103){ $price1 = 'MZN 0.00/-'; }
                                             else if($restid == 134){ $price1 = '$ 0.00/-'; }
                                            else{ $price1=$restaurant_type[0]['currency_symbol'].' 0.00/-'; }
                                        }else{

                                            if($restid == 103){ $price1='MZN '.$recipe['price'].'/-'; }
                                            else if($restid == 134){ $price1='$ '.$recipe['price'].'/-'; }
                                            else { $price1=$restaurant_type[0]['currency_symbol'].' '.$recipe['price'].'/-'; }
                                        }
                                        echo '<span  style="text-decoration: line-through;">'.$price1.'</span>';

                                    ?>
                                    <span class="mb-0 mt-2" style="color:#C70039">
                                        <?php 
                                            if($recipe['discount']=='Recipe Price' || $recipe['discount']=='' || $recipe['discount']=="MRP" || $recipe['discount']=="dv.kjndvkjnd"){
                                                if($restid == 103){ $price_discount = 'MZN 0.00/-'; }
                                                 else if($restid == 134){ $price_discount = '$ 0.00/-'; }
                                                else{ $price_discount=$restaurant_type[0]['currency_symbol'].' 0.00/-'; }
                                            }else{
                                                if($recipe['discount']!= null){
													if($recipe['discount_type'] == 'Flat'){
														$discount_recipe_price = $recipe['price'] - $recipe['discount'];
													}else{
														$discount_recipe_price = $recipe['price']-(($recipe['price'] * $recipe['discount'])/100);
													}
													if($restid == 103){ $price_discount='MZN '.$discount_recipe_price.'/-'; }
													else if($restid == 134){ $price_discount='$ '.$discount_recipe_price.'/-'; }
													else { $price_discount=$restaurant_type[0]['currency_symbol'].' '.$discount_recipe_price.'/-'; }
                                                }
                                                else{
													
                                                    $discount_recipe_price = $recipe['price'];
                                                    if($restid == 103){ $price_discount='MZN '.$discount_recipe_price.'/-'; }
                                                    else if($restid == 134){ $price_discount='$ '.$discount_recipe_price.'/-'; }
                                                        else { $price_discount=$restaurant_type[0]['currency_symbol'].' '.$discount_recipe_price.'/-'; }
                                                }
                                            }
                                            echo $price_discount;
                                        ?>
                                    </span></span>
                                        <?php
                                        if($tableid!=""){
                                        ?>
                                            <!-- <a class="btn btn-sm btn-success" href="<?=base_url();?>menus/offerview/<?=$group['id'];?>/<?=$recipe['offer_id'];?>/<?=$recipe['id'];?>/<?=$restid;?>/<?=$tableid;?>">View</a> -->
                                        <?php
                                        }else{
                                        ?>
                                            <!-- <a class="btn btn-sm btn-success" href="<?=base_url();?>menus/offerview/<?=$group['id'];?>/<?=$recipe['offer_id'];?>/<?=$recipe['id'];?>/<?=$restid;?>">View</a> -->
                                        <?php
                                        }
                                        if($tableid!=""){
											
                                            if($_GET['is_website'] == ''){
                                                if($customer['is_block']==0 && in_array('Table Management',$authority) && in_array('Online order',$authority)){
                                                ?>
                                                    <!--  <span class="count-number mr-3 cart-items-number d-flex" data-id="<?=$recipe['id'];?>" price="<?=$discount_recipe_price;?>" name="<?=$recipe['name'];?>" recipe-type="<?=$recipe['recipe_type'];?>" offer-id="<?=$recipe['offer_id'];?>" discount="<?=$recipe['discount'];?>">
                                                        <input type='button' value='-' class='btn btn-success btn-sm btn-minus-qty' field='quantity' />
                                                        <input type='text' name='quantity' value='0' class='qty form-control count-number-input' readonly="" value="0" min="0" max="999999"/>
                                                        <input type='button' value='+' class='btn btn-success btn-sm btn-plus-qty' field='quantity' style="margin-left: 10px;" />
                                                    </span> -->
													<span class="btn btn-sm btn-success text-white show_addon_popup" style="margin-top:15px;" recipe-id="<?=$recipe['id'];?>" group-id="<?=$recipe['group_id'];?>">Add</span>
                                                    <!--<span class="text-dark mr-3">
                                                        <button class="btn btn-outline-success btn-sm btn-add-cart" data-id="<?=$recipe['id'];?>" price="<?=$recipe['price'];?>" name="<?=$recipe['name'];?>" recipe-type="<?=$recipe['recipe_type'];?>"> ADD</button>
                                                    </span>-->
                                                <?php
                                                }
                                            }
                                            else{
												
                                                if($customer['is_block']==0 && in_array('Table Management',$authority) && in_array('Online order',$authority)){
                                                ?>
                                                    <!--  <span class="count-number mr-3 cart-items-number d-flex" data-id="<?=$recipe['id'];?>" price="<?=$discount_recipe_price;?>" name="<?=$recipe['name'];?>" recipe-type="<?=$recipe['recipe_type'];?>" offer-id="<?=$recipe['offer_id'];?>" discount="<?=$recipe['discount'];?>">
                                                        <input type='button' value='-' class='btn btn-success btn-sm btn-minus-qty' field='quantity' />
                                                        <input type='text' name='quantity' value='0' class='qty form-control count-number-input' readonly="" value="0" min="0" max="999999"/>
                                                        <input type='button' value='+' class='btn btn-success btn-sm btn-plus-qty' field='quantity' style="margin-left: 10px;" />
                                                    </span> -->
													<span class="btn btn-sm btn-success text-white show_addon_popup" style="margin-top:15px;" recipe-id="<?=$recipe['id'];?>" group-id="<?=$recipe['group_id'];?>">Add</span>
                                                    <!--<span class="text-dark mr-3">
                                                        <button class="btn btn-outline-success btn-sm btn-add-cart" data-id="<?=$recipe['id'];?>" price="<?=$recipe['price'];?>" name="<?=$recipe['name'];?>" recipe-type="<?=$recipe['recipe_type'];?>"> ADD</button>
                                                    </span>-->
                                                <?php
                                                }
                                                    
                                            }
                                        }
                                        ?>
                                    </li>
                                </ul>

                                 
                            </div> 
                        </div><?php } else{?>
                        <div class="col-12 pr-0">
                            <div class="menu-txt">
                                <h3>
                                    <?php if($recipe['recipe_type']=="veg"){ ?>
                                        <img src="<?=base_url();?>assets/images/Veg.png" style="width:10px;height:10px;">&nbsp;
                                    <?php }
                                    if($recipe['recipe_type']=="nonveg"){ ?>
                                        <img src="<?=base_url();?>assets/images/NonVeg.png" style="width:10px;height:10px;">&nbsp;
                                    <?php } ?>
                                    <?php
                                    if($tableid!=""){
                                    ?>
                                       
                                        <a href="<?=base_url();?>menus/view/<?=$group['id'];?>/<?=$recipe['id'];?>/<?=$restid;?>/<?=$tableid;?>?is_website=<?=$_GET['is_website']?>"><?php echo ucwords(strtolower($recipe['title']))." <br>".$recipe['name']; ?></a>
                                    <?php
                                    }else{
                                    ?>
                                       
                                        <a href="<?=base_url();?>menus/view/<?=$group['id'];?>/<?=$recipe['id'];?>/<?=$restid;?>/0?is_website=<?=$_GET['is_website']?>"><?php echo ucwords(strtolower($recipe['title']))." <br>".$recipe['name']; ?></a>
                                    <?php
                                    }
                                    ?>
                                </h3>
                                 
                                <ul class="menu-ingredients" recipe-id="<?=$recipe['id'];?>" style="min-height:3px !important;padding:0px !important;margin-top:-10px!important;">
                                    <?php if($_GET['list_view']!= 'yes'){ ?>
                                    <!-- <li class="li-ingredients" style="width: 95%;">
                                        <?php
                                            echo $recipe['description'];
                                        ?>
                                    </li> -->
                                    <?php } ?>
                                      
                                    <!-- <li class="not-besttime-toeat" style="height: 50px;">
                                    </li> -->
                                      
                                    <li class="view-recipe float-right <?php if($tableid==""){ echo 'mr-3';}?>" style="width:100%;">
                                        <span class="price-meta float-left pricecss" style="color:#C70039;margin-top:15px;width:80%;">
                                    <?php
                                        if($recipe['price']=='Recipe Price' || $recipe['price']=='' || $recipe['price']=="MRP" || $recipe['price']=="dv.kjndvkjnd"){
                                            if($restid == 103){ $price1 = 'MZN 0.00/-'; }
                                             else if($restid == 134){ $price1 = '$ 0.00/-'; }
                                            else{ $price1=$restaurant_type[0]['currency_symbol'].' 0.00/-'; }
                                        }else{

                                            if($restid == 103){ $price1='MZN '.$recipe['price'].'/-'; }
                                            else if($restid == 134){ $price1='$ '.$recipe['price'].'/-'; }
                                            else { $price1=$restaurant_type[0]['currency_symbol'].' '.$recipe['price'].'/-'; }
                                        }
                                        echo '<span  style="text-decoration: line-through;">'.$price1.'</span>';

                                    ?>
                                    <span class="mb-0 mt-2" style="color:#C70039;width:80%">
                                        <?php 
                                            if($recipe['discount']=='Recipe Price' || $recipe['discount']=='' || $recipe['discount']=="MRP" || $recipe['discount']=="dv.kjndvkjnd"){
                                                if($restid == 103){ $price_discount = 'MZN 0.00/-'; }
                                                 else if($restid == 134){ $price_discount = '$ 0.00/-'; }
                                                else{ $price_discount=$restaurant_type[0]['currency_symbol'].' 0.00/-'; }
                                            }else{
                                                if($recipe['discount']!= null){
                                                    if($recipe['discount_type'] == 'Flat'){
														$discount_recipe_price = $recipe['price'] - $recipe['discount'];
													}else{
														$discount_recipe_price = $recipe['price']-(($recipe['price'] * $recipe['discount'])/100);
													}
                                                if($restid == 103){ $price_discount='MZN '.$discount_recipe_price.'/-'; }
                                                else if($restid == 134){ $price_discount='$ '.$discount_recipe_price.'/-'; }
                                                else { $price_discount=$restaurant_type[0]['currency_symbol'].' '.$discount_recipe_price.'/-'; }
                                                }
                                                else{
                                                    $discount_recipe_price = $recipe['price'];
                                                    if($restid == 103){ $price_discount='MZN '.$discount_recipe_price.'/-'; }
                                                    else if($restid == 134){ $price_discount='$ '.$discount_recipe_price.'/-'; }
                                                        else { $price_discount=$restaurant_type[0]['currency_symbol'].' '.$discount_recipe_price.'/-'; }
                                                }
                                            }
                                            echo $price_discount;
                                        ?>
                                    </span></span>
                                        <?php
                                        if($tableid!=""){
                                        ?>
                                            <!-- <a class="btn btn-sm btn-success" href="<?=base_url();?>menus/offerview/<?=$group['id'];?>/<?=$recipe['offer_id'];?>/<?=$recipe['id'];?>/<?=$restid;?>/<?=$tableid;?>">View</a> -->
                                        <?php
                                        }else{
                                        ?>
                                            <!-- <a class="btn btn-sm btn-success" href="<?=base_url();?>menus/offerview/<?=$group['id'];?>/<?=$recipe['offer_id'];?>/<?=$recipe['id'];?>/<?=$restid;?>">View</a> -->
                                        <?php
                                        }
                                        if($tableid!=""){
                                            if($_GET['is_website'] == ''){
                                                if($customer['is_block']==0 && in_array('Table Management',$authority) && in_array('Online order',$authority)){
                                                ?>
                                                    <!--<span class="count-number mr-3 cart-items-number d-flex" data-id="<?=$recipe['id'];?>" price="<?=$discount_recipe_price;?>" name="<?=$recipe['name'];?>" recipe-type="<?=$recipe['recipe_type'];?>" offer-id="<?=$recipe['offer_id'];?>" discount="<?=$recipe['discount'];?>">
                                                        <input type='button' value='-' class='btn btn-success btn-sm btn-minus-qty' field='quantity' />
                                                        <input type='text' name='quantity' value='0' class='qty form-control count-number-input' readonly="" value="0" min="0" max="999999"/>
                                                        <input type='button' value='+' class='btn btn-success btn-sm btn-plus-qty' field='quantity' style="margin-left: 10px;" />
                                                    </span>-->
													<span class="btn btn-sm btn-success text-white show_addon_popup" style="margin-top:15px;" recipe-id="<?=$recipe['id'];?>" group-id="<?=$recipe['group_id'];?>">Add</span>
                                                    <!--  <span class="text-dark mr-3">
                                                        <button class="btn btn-outline-success btn-sm btn-add-cart" data-id="<?=$recipe['id'];?>" price="<?=$recipe['price'];?>" name="<?=$recipe['name'];?>" recipe-type="<?=$recipe['recipe_type'];?>"> ADD</button>
                                                    </span> -->
                                                <?php
                                                }
                                            }
                                            else{
                                                if($customer['is_block']==0 && in_array('Table Management',$authority) && in_array('Online order',$authority)){
                                                ?>
                                                    <!--<span class="count-number mr-3 cart-items-number d-flex" data-id="<?=$recipe['id'];?>" price="<?=$discount_recipe_price;?>" name="<?=$recipe['name'];?>" recipe-type="<?=$recipe['recipe_type'];?>" offer-id="<?=$recipe['offer_id'];?>" discount="<?=$recipe['discount'];?>">
                                                        <input type='button' value='-' class='btn btn-success btn-sm btn-minus-qty' field='quantity' />
                                                        <input type='text' name='quantity' value='0' class='qty form-control count-number-input' readonly="" value="0" min="0" max="999999"/>
                                                        <input type='button' value='+' class='btn btn-success btn-sm btn-plus-qty' field='quantity' style="margin-left: 10px;" />
                                                    </span>-->
													<span class="btn btn-sm btn-success text-white show_addon_popup" style="margin-top:15px;" recipe-id="<?=$recipe['id'];?>" group-id="<?=$recipe['group_id'];?>">Add</span>
                                                    <!--<span class="text-dark mr-3">
                                                        <button class="btn btn-outline-success btn-sm btn-add-cart" data-id="<?=$recipe['id'];?>" price="<?=$recipe['price'];?>" name="<?=$recipe['name'];?>" recipe-type="<?=$recipe['recipe_type'];?>"> ADD</button>
                                                    </span>-->
                                                <?php
                                                }                                                    
                                            }
                                        }
                                        ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
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
}
//print_r($todays_special);
    if(count($todays_special)>0){
        // if(count($admin_offer)>0){
        //     $apply_style = 'style="padding-top:0px;"';
        // }else{
        //     $apply_style ='';
        // }
?>
<div class="menu-section menu-section-recipes section-todays-special" id="todays-special">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-header">
                    <h2 class="section-title">Today's Special</h2>
                    <!-- <h4>2 Courses & 3 Courses</h4> -->
                </div>
            </div>
        </div>
        <div class="row  all-menus">
            <?php
            foreach ($todays_special as $recipe) 
			{
				if($_GET['list_view']=='yes')
				{
					$class_name='food-menu1';
                }
                else
				{
					$class_name='';
                }
            ?>
            <div class="list-card col-lg-6 col-sm-12 col6-food-menu">
                <div class="food-menu <?=$class_name?>" style="min-height:20px !important;">
                    <div class="row">
                        <?php 
						if($_GET['list_view']!= 'yes')
						{ 
						?>
                        <div class="col-3 pr-0">
                            <div class="col-12 p-0 justify-content-center">
								<?php
                                if($recipe['recipe_image']=="" || $recipe['recipe_image']=="assets/images/users/menu.png")
                                    $recipe_image=base_url()."assets/images/users/menu.png";
                                else
                                     $recipe_image=$recipe['recipe_image'];
                            
								if($tableid!="")
								{
                                ?>
                                <a href="<?=base_url();?>menus/view/<?=$group['id'];?>/<?=$recipe['id'];?>/<?=$restid;?>/<?=$tableid;?>?is_website=<?=$_GET['is_website']?>">
									<div class="menu-img <?php if($recipe['recipe_type']=="veg") echo 'veg-recipe'; else if($recipe['recipe_type']=="nonveg") echo 'nonveg-recipe';?>" style="background-image:url('<?=$recipe_image;?>');background-repeat: no-repeat;background-size: cover;background-position: center;">
										<!-- <img src="<?=$recipe['recipe_image']?>" alt=""> -->
									</div>
								</a>
								<?php
								}
								else
								{
								?>
								<a href="<?=base_url();?>menus/view/<?=$group['id'];?>/<?=$recipe['id'];?>/<?=$restid;?>/0?is_website=<?=$_GET['is_website']?>">
									<div class="menu-img <?php if($recipe['recipe_type']=="veg") echo 'veg-recipe'; else if($recipe['recipe_type']=="nonveg") echo 'nonveg-recipe';?>" style="background-image:url('<?=$recipe_image;?>');background-repeat: no-repeat;background-size: cover;background-position: center;">
										<!-- <img src="<?=$recipe['recipe_image']?>" alt=""> -->
									</div>
								</a>
								<?php
								}
								?>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="col-9 pr-0">
                            <div class="menu-txt">
                                <h3>
                                <?php 
								if($recipe['recipe_type']=="veg")
								{
								?>
								<img src="<?=base_url();?>assets/images/Veg.png" style="width:10px;height:10px;">&nbsp;
								<?php 
								}
								
								if($recipe['recipe_type']=="nonveg")
								{
								?>
								<img src="<?=base_url();?>assets/images/NonVeg.png" style="width:10px;height:10px;">&nbsp;
								<?php 
								}
								
								if($tableid!="")
								{
								?>
								<a href="<?=base_url();?>menus/view/<?=$group['id'];?>/<?=$recipe['id'];?>/<?=$restid;?>/<?=$tableid;?>?is_website=<?=$_GET['is_website']?>"><?php echo ucwords(strtolower($recipe['name'])); ?></a>
								<?php
								}
								else
								{
								?>
								<a href="<?=base_url();?>menus/view/<?=$group['id'];?>/<?=$recipe['id'];?>/<?=$restid;?>?is_website=<?=$_GET['is_website']?>"><?php echo ucwords(strtolower($recipe['name'])); ?></a>
								<?php
								}
								?>
                                </h3>                                 
                                <ul class="menu-ingredients" recipe-id="<?=$recipe['id'];?>" style="min-height:50px !important;">
									<?php 
									if($_GET['list_view']!= 'yes')
									{
									?>
									<li class="li-ingredients" style="width: 95%;">
									<?php
									if($recipe['ingredients_name']!="")
										echo $recipe['ingredients_name'];
									else
										echo $recipe['description'];
									?>
                                    </li>
                                    <?php
									}

									$best_time_to_eat= $recipe['best_time_to_eat'];
									
									if($best_time_to_eat == 'none')
									{
										$best_time_to_eat = '';
									}
									else if($best_time_to_eat == null)
									{
										$best_time_to_eat = '';
									}
									else if($best_time_to_eat == 'null')
									{
										$best_time_to_eat = '';
									}
                                        
									$besttime_arr1 = explode(",",$best_time_to_eat);
                                    
									if(array_search('all', $besttime_arr1) == 'TRUE')
									{
										$pos1 = array_search('all', $besttime_arr1);
										unset($besttime_arr1[$pos1]);
									}
                                        
									$best_time_to_eat = implode(", ",$besttime_arr1); 
									
									if($best_time_to_eat != '')
									{										
									?>
										<!-- <li>   
											<span class="badge badge-danger" style="background-color:#C70039;">Best Time To Eat : </span> 
											<small><?php echo ucwords($best_time_to_eat); ?></small>
										</li> -->
								   <?php 
									}
									else
									{
									?>
										<!-- <li class="not-besttime-toeat" style="height: 50px;">
                                        </li>  -->
									<?php
									}
									?>
                                    <li class="view-recipe float-right mb-2 <?php if($tableid==""){ echo 'mr-3';}?>" style="width:100%;margin-top:10px;">
                                        <span class="price-meta float-left pricecss" style="color:#C70039;width:80%">
										<?php
                                        if($recipe['price']=='Recipe Price' || $recipe['price']=='' || $recipe['price']=="MRP" || $recipe['price']=="dv.kjndvkjnd")
										{
                                            if($restid == 103)
											{
												$price1 = 'MZN 0.00/-'; 
											}
											else if($restid == 134)
											{
												$price1 = '$ 0.00/-'; 
											}
                                            else
											{
												$price1=$restaurant_type[0]['currency_symbol'].' 0.00/-'; 
											}
                                        }
										else
										{
											if($recipe['discount'] != Null){
                                                if($recipe['discount_type'] == 'Flat'){
													$discount_recipe_price = $recipe['price'] - $recipe['discount'];
												}else{
													$discount_recipe_price = $recipe['price']-(($recipe['price'] * $recipe['discount'])/100);
												}
                                                if($restid == 103){ $price_discount='MZN '.$discount_recipe_price.'/-'; }
                                                else if($restid == 134){ $price_discount='$ '.$discount_recipe_price.'/-'; }
                                                else { $price_discount=$restaurant_type[0]['currency_symbol'].' '.$discount_recipe_price.'/-'; }
                                            }
                                            else{
                                                $discount_recipe_price = $recipe['price'];
                                                if($restid == 103){ $price_discount='MZN '.$discount_recipe_price.'/-'; }
                                                else if($restid == 134){ $price_discount='$ '.$discount_recipe_price.'/-'; }
                                                else { $price_discount=$restaurant_type[0]['currency_symbol'].' '.$discount_recipe_price.'/-'; }
                                            }
                                        }
                                        echo $price1 =$discount_recipe_price;
										?>
										</span>
                                        <?php
                                        if($tableid!="")
										{
                                        ?>
                                            <!-- <a class="btn btn-sm btn-success" href="<?=base_url();?>menus/view/<?=$group['id'];?>/<?=$recipe['id'];?>/<?=$restid;?>/<?=$tableid;?>">View</a> -->
                                        <?php
                                        }
										else
										{
                                        ?>
                                            <!-- <a class="btn btn-sm btn-success" href="<?=base_url();?>menus/view/<?=$group['id'];?>/<?=$recipe['id'];?>/<?=$restid;?>">View</a> -->
                                        <?php
                                        }
										
                                        if($tableid!="")
										{
                                            if($_GET['is_website'] == '')
											{
                                                if($customer['is_block']==0 && in_array('Table Management',$authority) && in_array('Online order',$authority))
												{
                                                ?>
												<!--<span class="count-number mr-3 cart-items-number d-flex" data-id="<?=$recipe['id'];?>" price="<?=$recipe["price"];?>" name="<?=$recipe['name'];?>" recipe-type="<?=$recipe['recipe_type'];?>" offer-id="<?=$recipe['offer_id'];?>" discount="<?=$recipe['discount'];?>">
													<input type='button' value='-' class='btn btn-success btn-sm btn-minus-qty' field='quantity' />
													<input type='text' name='quantity' value='0' class='qty form-control count-number-input' readonly="" value="0" min="0" max="999999"/>
													<input type='button' value='+' class='btn btn-success btn-sm btn-plus-qty' field='quantity' style="margin-left: 10px;" />
												</span>-->
												<span class="btn btn-sm btn-success text-white show_addon_popup" style="margin-top:15px;" recipe-id="<?=$recipe['id'];?>" group-id="<?=$recipe['group_id'];?>">Add</span>
												<!--<span class="text-dark mr-3">
													<button class="btn btn-outline-success btn-sm btn-add-cart" data-id="<?=$recipe['id'];?>" price="<?=$recipe['price'];?>" name="<?=$recipe['name'];?>" recipe-type="<?=$recipe['recipe_type'];?>"> ADD</button>
												</span>-->
                                                <?php
                                                }
                                            }
                                            else
											{
                                                if($customer['is_block']==0 && in_array('Table Management',$authority) && in_array('Online order',$authority))
												{
                                                ?>
												<!--<span class="count-number mr-3 cart-items-number d-flex" data-id="<?=$recipe['id'];?>" price="<?=$recipe["price"];?>" name="<?=$recipe['name'];?>" recipe-type="<?=$recipe['recipe_type'];?>" offer-id="<?=$recipe['offer_id'];?>" discount="<?=$recipe['discount'];?>">
													<input type='button' value='-' class='btn btn-success btn-sm btn-minus-qty' field='quantity' />
													<input type='text' name='quantity' value='0' class='qty form-control count-number-input' readonly="" value="0" min="0" max="999999"/>
													<input type='button' value='+' class='btn btn-success btn-sm btn-plus-qty' field='quantity' style="margin-left: 10px;" />
												</span>-->
												<span class="btn btn-sm btn-success text-white show_addon_popup" style="margin-top:15px;" recipe-id="<?=$recipe['id'];?>" group-id="<?=$recipe['group_id'];?>">Add</span>
												<!--<span class="text-dark mr-3">
													<button class="btn btn-outline-success btn-sm btn-add-cart" data-id="<?=$recipe['id'];?>" price="<?=$recipe['price'];?>" name="<?=$recipe['name'];?>" recipe-type="<?=$recipe['recipe_type'];?>"> ADD</button>
												</span>-->
                                                <?php
                                                }                                                    
                                            }
                                        }
                                        ?>
                                    </li>
                                </ul>                                 
                            </div> 
                        </div>
						<?php 
						} 
						else
						{
						?>
						<div class="col-12 pr-0">
                            <div class="menu-txt">
                                <h3>
                                    <?php
                                    if($tableid!=""){
                                    ?>
                                        <a href="<?=base_url();?>menus/view/<?=$group['id'];?>/<?=$recipe['id'];?>/<?=$restid;?>/<?=$tableid;?>?is_website=<?=$_GET['is_website']?>"><?php echo ucwords(strtolower($recipe['name'])); ?></a>
                                    <?php
                                    }
									else
									{
                                    ?>
                                        <a href="<?=base_url();?>menus/view/<?=$group['id'];?>/<?=$recipe['id'];?>/<?=$restid;?>/0?is_website=<?=$_GET['is_website']?>"><?php echo ucwords(strtolower($recipe['name'])); ?></a>
                                    <?php
                                    }
                                    ?>
                                </h3>
                                 
                                <ul class="menu-ingredients" recipe-id="<?=$recipe['id'];?>" style="min-height:3px !important;padding:0px !important;margin-top:-10px!important;">
									<?php 
									if($_GET['list_view']!= 'yes')
									{
									?>
                                    <li class="li-ingredients" style="width: 95%;">
									<?php
									if($recipe['ingredients_name']!="")
										echo $recipe['ingredients_name'];
									else
										echo $recipe['description'];
									?>
                                    </li>
                                    <?php
									}

									$best_time_to_eat= $recipe['best_time_to_eat'];
                                    
									if($best_time_to_eat == 'none')
									{
									   $best_time_to_eat = '';
									}
									else if($best_time_to_eat == null)
									{
										$best_time_to_eat = '';
									}
									else if($best_time_to_eat == 'null')
									{
										$best_time_to_eat = '';
									}
                                        
									$besttime_arr1 = explode(",",$best_time_to_eat);
									
									if(array_search('all', $besttime_arr1) == 'TRUE')
									{
										$pos1 = array_search('all', $besttime_arr1);
										unset($besttime_arr1[$pos1]);
									}
                                        
									$best_time_to_eat = implode(", ",$besttime_arr1); 
                                    
									if($best_time_to_eat != '')
									{ 
									?>
									<!-- <li>
										<span class="badge badge-danger" style="background-color:#C70039;">Best Time To Eat : </span> 
										<small><?php echo ucwords($best_time_to_eat); ?></small>
									</li> -->
								   <?php 
									}
									else
									{
									?>
									<!-- <li class="not-besttime-toeat" style="height: 50px;">
									</li>  -->
									<?php
									}
									?>
                                    <li class="view-recipe float-right <?php if($tableid==""){ echo 'mr-3';}?>" style="width:100%;">
                                        <span class="price-meta float-left pricecss" style="color:#C70039;margin-top:15px;width:80%;">
										<?php
                                        if($recipe['price']=='Recipe Price' || $recipe['price']=='' || $recipe['price']=="MRP" || $recipe['price']=="dv.kjndvkjnd")
										{
                                            if($restid == 103)
											{ 
												$price1 = 'MZN 0.00/-'; 
											}
                                            else if($restid == 134)
											{ 
												$price1 = '$ 0.00/-'; 
											}
                                            else
											{ 
												$price1=$restaurant_type[0]['currency_symbol'].' 0.00/-'; 
											}
                                        }
										else
										{
											if($recipe['discount'] != Null){
                                                if($recipe['discount_type'] == 'Flat'){
													$discount_recipe_price = $recipe['price'] - $recipe['discount'];
												}else{
													$discount_recipe_price = $recipe['price']-(($recipe['price'] * $recipe['discount'])/100);
												}
                                                if($restid == 103){ $price_discount='MZN '.$discount_recipe_price.'/-'; }
                                                else if($restid == 134){ $price_discount='$ '.$discount_recipe_price.'/-'; }
                                                else { $price_discount=$restaurant_type[0]['currency_symbol'].' '.$discount_recipe_price.'/-'; }
                                            }
                                            else{
                                                $discount_recipe_price = $recipe['price'];
                                                if($restid == 103){ $price_discount='MZN '.$discount_recipe_price.'/-'; }
                                                else if($restid == 134){ $price_discount='$ '.$discount_recipe_price.'/-'; }
                                                else { $price_discount=$restaurant_type[0]['currency_symbol'].' '.$discount_recipe_price.'/-'; }
                                            }
                                        }
                                        echo $price1 =$discount_recipe_price;
										?>
										</span>
                                        <?php
                                        if($tableid!="")
										{
                                        ?>
										<!-- <a class="btn btn-sm btn-success" href="<?=base_url();?>menus/view/<?=$group['id'];?>/<?=$recipe['id'];?>/<?=$restid;?>/<?=$tableid;?>">View</a> -->
                                        <?php
                                        }
										else
										{
                                        ?>
										<!-- <a class="btn btn-sm btn-success" href="<?=base_url();?>menus/view/<?=$group['id'];?>/<?=$recipe['id'];?>/<?=$restid;?>">View</a> -->
                                        <?php
                                        }
                                        
										if($tableid!="")
										{
                                            if($_GET['is_website'] == '')
											{
                                                if($customer['is_block']==0 && in_array('Table Management',$authority) && in_array('Online order',$authority))
												{
                                                ?>
												<!--<span class="count-number mr-3 cart-items-number d-flex" data-id="<?=$recipe['id'];?>" price="<?=$recipe["price"];?>" name="<?=$recipe['name'];?>" recipe-type="<?=$recipe['recipe_type'];?>" offer-id="<?=$recipe['offer_id'];?>" discount="<?=$recipe['discount'];?>">
													<input type='button' value='-' class='btn btn-success btn-sm btn-minus-qty' field='quantity' />
													<input type='text' name='quantity' value='0' class='qty form-control count-number-input' readonly="" value="0" min="0" max="999999"/>
													<input type='button' value='+' class='btn btn-success btn-sm btn-plus-qty' field='quantity' style="margin-left: 10px;" />
												</span>-->
												<span class="btn btn-sm btn-success text-white show_addon_popup" style="margin-top:15px;" recipe-id="<?=$recipe['id'];?>" group-id="<?=$recipe['group_id'];?>">Add</span>
												<!--<span class="text-dark mr-3">
													<button class="btn btn-outline-success btn-sm btn-add-cart" data-id="<?=$recipe['id'];?>" price="<?=$recipe['price'];?>" name="<?=$recipe['name'];?>" recipe-type="<?=$recipe['recipe_type'];?>"> ADD</button>
												</span>-->
                                                <?php
                                                }
                                            }
                                            else
											{
                                                if($customer['is_block']==0 && in_array('Table Management',$authority) && in_array('Online order',$authority))
												{
                                                ?>
												<!--<span class="count-number mr-3 cart-items-number d-flex" data-id="<?=$recipe['id'];?>" price="<?=$recipe["price"];?>" name="<?=$recipe['name'];?>" recipe-type="<?=$recipe['recipe_type'];?>" offer-id="<?=$recipe['offer_id'];?>" discount="<?=$recipe['discount'];?>">
													<input type='button' value='-' class='btn btn-success btn-sm btn-minus-qty' field='quantity' />
													<input type='text' name='quantity' value='0' class='qty form-control count-number-input' readonly="" value="0" min="0" max="999999"/>
													<input type='button' value='+' class='btn btn-success btn-sm btn-plus-qty' field='quantity' style="margin-left: 10px;" />
												</span>-->
												<span class="btn btn-sm btn-success text-white show_addon_popup" style="margin-top:15px;" recipe-id="<?=$recipe['id'];?>" group-id="<?=$recipe['group_id'];?>">Add</span>
												<!--<span class="text-dark mr-3">
													<button class="btn btn-outline-success btn-sm btn-add-cart" data-id="<?=$recipe['id'];?>" price="<?=$recipe['price'];?>" name="<?=$recipe['name'];?>" recipe-type="<?=$recipe['recipe_type'];?>"> ADD</button>
												</span>-->
                                                <?php
                                                }                                                    
                                            }
                                        }
                                        ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <?php 
						}
						?>
                    </div>
                </div>
            </div>
            <?php
			}
            ?>
        </div>
    </div>
</div>
<?php
}
$count=1;
foreach ($menu_groups as $group) 
{
	// if(count($todays_special)==0 && $count==1) {
	//     $pad_class="section-padding";
	//     $count++;
	// }
	// else
	//     $pad_class="";
?>
<div class="menu-section menu-section-onlyrecipes menu-section-recipes menu-details-div" id="group-<?=$group['id'];?>" group-id="<?=$group['id'];?>" restid="<?=$restid;?>" style="display: none;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-header">
                    <h2 class="section-title mb-0"> <?=$group['title'];?></h2>
                    <p class="mb-0"><?=$group['available_in'];?></p>
                    <!-- <h4>2 Courses & 3 Courses</h4> -->
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-12 col6-food-menu loader-div" style="display: none;">
            <div class="food-menu animated-background">
                <div class="row ">
                    <div class="col-3 pr-0">
                        <div class="col-12 p-0 justify-content-center">
                            <div class="menu-img background-masker" style="background-image:url('<?=base_url();?>assets/images/users/default.jpg');background-repeat: no-repeat;background-size: cover;background-position: center;">
                               
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-12 p-0 col-price-12 mt-2">
                            <p class="price-meta mb-0 background-masker" style="width: 90%;"></p>
                        </div>
                    </div>
                    <div class="col-9 pr-0">
                        <div class="menu-txt">
                            <h3 class="background-masker">
                                <a href="#" ></a>
                            </h3>
                             
                            <ul class="menu-ingredients mr-5">
                                <li class="background-masker mb-2"></li>
                                <li class="background-masker mb-2"></li> 
                                <li class="view-recipe">
                                    <span class="badge badge-success background-masker mb-0"><a href="#"></a></span>
                                </li>
                            </ul>
                             
                        </div> 
                    </div>
                </div>
            </div>
        </div>
        <div class="row append-group-recipes all-menus"></div>
    </div>
</div>
<?php
}

if($tableid!="")
{
    if($_GET['is_website'] == '')
	{
		if($customer['is_block']==0 && in_array('Table Management',$authority) && in_array('Online order',$authority))
		{
		?>
		<div class="osahan-menu-fotter fixed-bottom px-3 py-2 text-center cart_responsive" style="width: 20%;margin-left: calc(100% - 35%);">
			<div class="offset-md-8 col-3 rounded-circle mt-n4 px-3 py-1 float-right">
				<div class="bg-danger rounded-circle mt-n0 shadow btn-cart">
					<?php
					if($tableid!="")
					{
					?>
						<a href="<?=base_url();?>checkout/viewcart/<?=$restid?>/<?=$main_menu_id?>/<?=$tableid?>/<?=$is_website?>" class="text-white small font-weight-bold text-decoration-none" style="vertical-align: sub;">
							<i class="feather-shopping-cart"></i>
							<sub class="cart-total-count cart-count"></sub>
						</a>
					<?php                
					}
					else
					{
					?>
						<a href="<?=base_url();?>checkout/viewcart/<?=$restid?>/<?=$main_menu_id?>" class="text-white small font-weight-bold text-decoration-none" style="vertical-align: sub;">
							<i class="feather-shopping-cart"></i>
							<sub class="cart-total-count cart-count"></sub>
						</a>
					<?php
					}
					?>
			  </div>
		   </div>
		</div>
		<?php
        }
    }
    else
	{
        if($customer['is_block']==0 && in_array('Table Management',$authority) && in_array('Online order',$authority))
		{
        ?>
		<div class="osahan-menu-fotter fixed-bottom px-3 py-2 text-center cart_responsive" style="width: 20%;margin-left: calc(100% - 35%);">
			<div class="offset-md-8 col-3 rounded-circle mt-n4 px-3 py-1 float-right">
				<div class="bg-danger rounded-circle mt-n0 shadow btn-cart">
				<?php
				if($tableid!="")
				{
				?>
					<a href="<?=base_url();?>checkout/viewcart/<?=$restid?>/<?=$main_menu_id?>/<?=$tableid?>/<?=$is_website?>" class="text-white small font-weight-bold text-decoration-none" style="vertical-align: sub;">
						<i class="feather-shopping-cart"></i>
						<sub class="cart-total-count cart-count"></sub>
					</a>
				<?php                
				}
				else
				{
				?>
					<a href="<?=base_url();?>checkout/viewcart/<?=$restid?>/<?=$main_menu_id?>" class="text-white small font-weight-bold text-decoration-none" style="vertical-align: sub;">
						<i class="feather-shopping-cart"></i>
						<sub class="cart-total-count cart-count"></sub>
					</a>
				<?php
				}
				?>
				</div>
			</div>
		</div>
        <?php
        }
    }
}?>
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
<?php require_once('web_footer.php');
?>
	<script type="text/javascript">
		function googleTranslateElementInit() 
		{
			new google.translate.TranslateElement({ pageLanguage: 'en', includedLanguages: 'en,mr,hi', multilanguagePage: true}, 'google_translate_element');
			$(".goog-logo-link").empty();
			$('.goog-te-gadget').html($('.goog-te-gadget').children());
			$('.goog-close-link').click();
			setTimeout(function(){
				$('.goog-te-gadget .goog-te-combo').find('option:first-child').html('Translate');    
			}, 500);
		}
	</script>
	<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
	<?php 
	if($_GET['list_view'] != 'yes')
	{
		?>
		<script src="<?=base_url();?>assets/web/js/custom/Menulist.js?v=<?php echo uniqid(); ?>"></script>
		<script type="text/javascript">

			Menulist.base_url="<?=base_url();?>";
			Menulist.restid="<?=$restid;?>";
			Menulist.main_menu_id="<?=$main_menu_id;?>";
			Menulist.tablecategory_id="<?=$tablecategory_id;?>";
			Menulist.is_category_prices="<?=$user['is_category_prices'];?>";
			Menulist.todays_special_count="<?=count($todays_special);?>";
			Menulist.tableid="<?=$tableid;?>";
			Menulist.customer_id="<?=$customer['customer_id'];?>";
			Menulist.is_customer_block="<?=$customer['is_block'];?>";
			Menulist.is_table_available="<?=$table['is_available'];?>";
			Menulist.authority="<?=$authority;?>";
            Menulist.currency_symbol="<?=$restaurant_type[0]['currency_symbol'];?>";
			// Menulist.table_management_authority="<?=(in_array('Table Management',$authority) ? 'yes': 'no')?>";
			// Menulist.order_authority="<?=(in_array('Order',$authority) ? 'yes': 'no')?>";
			Menulist.init();
			/*$('.recipe-tabs').find('.receipes .card-body').addClass('active');*/
		</script>
		<?php 
	} 
	else
	{
		?>
		<script src="<?=base_url();?>assets/web/js/custom/Menulistview.js?v=<?php echo uniqid(); ?>"></script>
		<script type="text/javascript">
			Menulistview.base_url="<?=base_url();?>";
			Menulistview.restid="<?=$restid;?>";
			Menulistview.main_menu_id="<?=$main_menu_id;?>";
			Menulistview.tablecategory_id="<?=$tablecategory_id;?>";
			Menulistview.is_category_prices="<?=$user['is_category_prices'];?>";
			Menulistview.todays_special_count="<?=count($todays_special);?>";
			Menulistview.tableid="<?=$tableid;?>";
			Menulistview.customer_id="<?=$customer['customer_id'];?>";
			Menulistview.is_customer_block="<?=$customer['is_block'];?>";
			Menulistview.is_table_available="<?=$table['is_available'];?>";
			Menulistview.authority="<?=$authority;?>";
            Menulistview.currency_symbol="<?=$restaurant_type[0]['currency_symbol'];?>";
			// Menulist.table_management_authority="<?=(in_array('Table Management',$authority) ? 'yes': 'no')?>";
			// Menulist.order_authority="<?=(in_array('Order',$authority) ? 'yes': 'no')?>";
			Menulistview.init();
			/*$('.recipe-tabs').find('.receipes .card-body').addClass('active');*/
		</script>
		<?php 
	}
	?>
    
<script type="text/javascript">
            function googleTranslateElementInit() {
                new google.translate.TranslateElement({ pageLanguage: 'en', includedLanguages: 'en,el', multilanguagePage: true}, 'google_translate_element');
                $(".goog-logo-link").empty();
                $('.goog-te-gadget').html($('.goog-te-gadget').children());
                $('.goog-close-link').click();
                setTimeout(function(){
                    $('.goog-te-gadget .goog-te-combo').find('option:first-child').html('Translate');    
                }, 700);
            }
        </script>
        <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script> 
	</body>
</html>