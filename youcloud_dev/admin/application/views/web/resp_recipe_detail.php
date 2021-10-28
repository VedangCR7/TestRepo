 <!--    <?php
                     foreach ($group['recipes'] as $recipe) {
                    ?>
                    <div class="col-lg-6 col-sm-12 col6-food-menu">
                        <div class="food-menu">
                            <div class="row">
                                <div class="col-3 pr-0">
                                    <div class="col-12 p-0 justify-content-center">
                                        <?php
                                        if($recipe['recipe_image']=="" || $recipe['recipe_image']=="assets/images/users/menu.png")
                                            $recipe_image=base_url()."assets/images/users/menu.png";
                                        else
                                             $recipe_image=$recipe['recipe_image'];
                                        ?>
                                        <div class="menu-img <?php if($recipe['recipe_type']=="veg") echo 'veg-recipe'; else if($recipe['recipe_type']=="nonveg") echo 'nonveg-recipe';?>" style="background-image:url('<?=$recipe_image;?>');background-repeat: no-repeat;background-size: cover;background-position: center;">
                                           
                                        </div>
                                    </div>
                                    <?php
                                    if($main_menu_id==1){
                                    ?>
                                    <div class="clearfix"></div>
                                    <div class="col-12 p-0">
                                        <p class="price-meta mb-0">
                                            <?php
                                                if($recipe['price']=='Recipe Price' || $recipe['price']==''){
                                                    if($restid == 103){ $price1 = 'MZN 0.00/-'; }
                                                    else{ $price1='&#8377; 0.00/-'; }
                                                }else{
                                                    if($restid == 103){ $price1='MZN '.$recipe['price'].'/-'; }
                                                    else { $price1='&#8377; '.$recipe['price'].'/-'; }
                                                }
                                                echo $price1;
                                            ?>
                                        </p>
                                    </div>
                                    <?php
                                        }
                                    ?>
                                </div>
                                <div class="col-9 pr-0">
                                    <div class="menu-txt">
                                        <h3>
                                            <a href="<?=base_url();?>menus/view/<?=$group['id'];?>/<?=$recipe['id'];?>/<?=$restid;?>" class="food-recipe-name"><?php echo ucwords(strtolower($recipe['name'])); ?></a>
                                        </h3>
                                         
                                        <ul class="menu-ingredients" recipe-id="<?=$recipe['id'];?>">
                                            <li class="li-ingredients">
                                                 <?php
                                                if($recipe['ingredients_name']!="")
                                                    echo $recipe['ingredients_name'];
                                                else
                                                    echo $recipe['description'];
                                                ?>
                                            </li>
                                            <?php
                                            if($main_menu_id==2){
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
                                                    if($bar_prices=="")
                                                        $bar_prices = "<b>$k :</b> $currency $v/-"; 
                                                    else
                                                        $bar_prices = "<b>$k :</b> $currency $v/-"; 
                                                    ?>
                                                <li class="bar-price">   
                                                      <?=$bar_prices;?>
                                                </li>
                                                <?php
                                                } 
                                            ?>
                                            <?php
                                            }else{
                                            ?>
                                             <?php
                                                $best_time_to_eat= $recipe['best_time_to_eat'];
                                                if($best_time_to_eat == 'none'){
                                                    $best_time_to_eat = '';
                                                }
                                                
                                                $besttime_arr1 = explode(",",$best_time_to_eat);
                                                if(array_search('all', $besttime_arr1) == 'TRUE')
                                                {
                                                    $pos1 = array_search('all', $besttime_arr1);
                                                    unset($besttime_arr1[$pos1]);
                                                }
                                                
                                                $best_time_to_eat = implode(", ",$besttime_arr1); 
                                                if($best_time_to_eat != ''){ 
                                                    ?>
                                                    <li>   

                                                    <span class="badge badge-danger">Best Time To Eat : </span> 
                                                      <small><?php echo ucwords($best_time_to_eat); ?></small>
                                                  </li>
                                               <?php }
                                               else{
                                                ?>
                                                <li style="height: 33px;">
                                                </li> 
                                                <?php
                                               }
                                            }
                                                ?>
                                            <li class="view-recipe">
                                                <span class="badge badge-success mb-0"><a href="<?=base_url();?>menus/view/<?=$group['id'];?>/<?=$recipe['id'];?>/<?=$restid;?>">View</a></span>
                                            </li>
                                        </ul>
                                         
                                    </div> 
                                </div>
                            </div>
                           
                        </div>
                    </div>
                    <?php
                        }
                    ?> -->