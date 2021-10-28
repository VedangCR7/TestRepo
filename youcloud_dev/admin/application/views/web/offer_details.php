<?php
	$recName = ucwords(strtolower($recipe['name']));
    require_once('web_header.php');

    if($restaurant_type[0]['restauranttype'] == 'both')
    {
        $recipe_type = '';
    }
    if($restaurant_type[0]['restauranttype'] == 'veg')
    {
        $recipe_type = 'veg';
    }
    if($restaurant_type[0]['restauranttype'] == 'nonveg')
    {
        $recipe_type = 'nonveg';
    }
?>
        <?php
            if($recipe['offer_image']=="" || $recipe['offer_image']=="assets/images/users/menu.png")
                $recipe_image=base_url()."assets/images/users/menu.png";
            else
                 $recipe_image=$recipe['offer_image'];
        ?>
    <div class="menu-promo"  style="background-image:url('<?=$recipe_image;?>');background-repeat: no-repeat;background-size: cover;background-position: center;">
       <!--  <a href="<?=base_url()?>menus/<?=$group_details['main_menu_id'];?>/<?=$restid;?>" class="custom-btn">Back</a> -->
         <a href='<?=base_url()?>menus/<?=$group_details['main_menu_id'];?>/<?=$restid;?>/<?=$tableid;?>?recipetype=<?=$recipe_type?>&list_view=yes&is_website=<?=$_GET['is_website']?>' id="backLink" class="bckToMainPage custom-btn" style="color: #fff;padding: 5px 7px;">
            <img src="<?=base_url();?>assets/images/back-arrow.png" style="width: 30px;">
        </a>
        <!--  <div class="google_lang_menu menu_details_translate">
            <div id="google_translate_element"></div>
        </div> -->
      
    </div>
    <!-- Single menu Section Start -->
    <section class="single-menu section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="menu-inner">
                        <div class="menu-head mb-3">
                            <h1 class="menu-title"><?=$recipe['title'];?>
                               
                                <div class="footer-choose float-right">
                                    <?php 
                                        if($recipe['recipe_type']=="veg") {
                                    ?>
                                    <a href="#"><img src="<?=base_url();?>assets/web/images/vg.png" alt=""></a>

                                    <?php
                                        } 
                                        else if($recipe['recipe_type']=="nonveg"){
                                    ?>
                                    <a href="#"><img src="<?=base_url();?>assets/web/images/nv.png" alt=""></a>
                                    <?php

                                        }/*else{
                                    ?>
                                     <a href="#"><img src="<?=base_url();?>assets/web/images/vegnoveg.png" alt=""></a>
                                    <?php
                                        }*/
                                    ?>
                                </div>
                            </h1>
                            <?php
                            /* if($main_menu_id==2){
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
                                    else if($resto_id == 134){
                                        $currency = '$';
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
                                    <span class="price-meta">   
                                          <?=$bar_prices;?>
                                    </span><br>
                                <?php
                                    }
                                } else{*/
                                    if($recipe['price']=='Recipe Price' || $recipe['price']=='' || $recipe['price']=="MRP" || $recipe['price']=="dv.kjndvkjnd"){
                                        if($restid == 103){ $price1 = 'MZN 0.00/-'; }
                                        else if($restid == 134){ $price1 = '$ 0.00/-'; }
                                        else{ $price1='&#8377; 0.00/-'; }
                                    }else{
                                        if($restid == 103){ $price1='MZN '.$recipe['price'].'/-'; }
                                         else if($restid == 134){ $price1='$ '.$recipe['price'].'/-'; }
                                        else { $price1='&#8377; '.$recipe['price'].'/-'; }
                                    }
                                   
                                ?>
                                <?php 
                                    if($recipe['discount']=='Recipe Price' || $recipe['discount']=='' || $recipe['discount']=="MRP" || $recipe['discount']=="dv.kjndvkjnd"){
                                        if($restid == 103){ $price_discount = 'MZN 0.00/-'; }
                                         else if($restid == 134){ $price_discount = '$ 0.00/-'; }
                                        else{ $price_discount='&#8377; 0.00/-'; }
                                    }else{
                                        if($restid == 103){ $price_discount='MZN '.$recipe['discount'].'/-'; }
                                        else if($restid == 134){ $price_discount='$ '.$recipe['discount'].'/-'; }
                                        else { $price_discount='&#8377; '.$recipe['discount'].'/-'; }
                                    }
                                   
                                ?>
                                    <span class="price-meta" style="text-decoration: line-through;">
                                        <?php  echo $price1; ?>
                                    </span><span class="price-meta"><?php  echo $price_discount;?></span>
                                
                        </div>
                        <div class="menu-txt">
                            <ul class="menu-ingredients">
                               
                            </ul>
                            <?php
                            if($recipe['description']!=""){
                            ?>
                                <p><?=$recipe['description'];?></p>
                            <?php
                            }
                            ?>
                        </div>
						
						<?php if(($restid == '58') || ($restid == '86')){ ?>
							<div class="allergen">
								<h6>Allergens:</h6>
							</div>
							
							<div class="nutritions">
								<h6>Nutritional Information per 100g:</h6>
							</div>
							
							<div class='row'>
								<div class='col-md-4'></div>
								<div class='col-md-4 nutrition-info nutri-info'>
									<div class='card nutri-container container'>
										<div class='row' style='margin-top: 7px;'>
											<div class='col-4 nutri-btn btn-all activeN' onclick="toggleNutrition('all')">All</div>
											<div class='col-4 nutri-btn btn-big8' onclick="toggleNutrition('big8')">Big 8</div>
											<div class='col-4 nutri-btn btn-vitamis' onclick="toggleNutrition('vitamis')">Vitamis</div>
										</div>
									</div>
								</div>
								<div class='col-md-4'></div>
							</div>
						<?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Single menu Section End -->

    <footer class="footer section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="footer-inner text-center">
                        <div class="f-logo text-center">
                            <?php
                            if($user['profile_photo']=="assets/images/users/user.png" || $user['profile_photo']==""){
                              ?>
                                  <img src="<?php echo base_url().$user['profile_photo']; ?>" alt="">
                              <?php
                                }else{
                              ?>
                                 <img src="<?php echo $user['profile_photo']; ?>" alt="">
                              <?php
                                }
                                ?>
                           
                        </div>
                        <div class="footer-social">
                            <h3>Share On</h3>
                            <!--<ul>
                                <li><a href="#"><i class="feather-facebook"></i></a></li>
                                <li><a href="#"><i class="feather-twitter"></i></a></li>
                                <li><a href="#"><i class="feather-instagram"></i></a></li>
                            </ul>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--
    Javascript
    ========================================================-->
<?php
    require_once('web_footer.php');
?>
    <script type="text/javascript">
		function toggleNutrition(tag){
			$('.nutri-btn').removeClass('activeN');
			$('.nutri-btn.btn-'+tag).addClass('activeN');
			$('.nutition-info').hide();
			switch(tag){
				case 'big8':
					$('.nutition-info.big8_nutrition').css('display','flex');
					break;
				case 'vitamis':
				$('.nutition-info.vitamins_NutritionList').css('display','flex');
				break;
				case 'all':
					$('.nutition-info.all_nutrition').css('display','flex');
				break;
				case 'default':
				$('.nutition-info.all_nutrition').css('display','flex');
				break;
			}
		}
	
        function capitalize_Words(str)
        {
         return str.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
        }
       $(document).ready(function() {
            $.ajax({
                url: "<?=base_url();?>menus/list_recipe_ingredients",
                type:'POST',
                dataType: 'json',
                data: {recipe_id :'<?=$recipe_id;?>'},
                success: function(result){
                    if (result.status) { 
                        if(result.ingredients!=null){
                            var ingredients=result.ingredients;
                            var html='';
                            for(i in ingredients){
                              html+='<li><span>'+capitalize_Words(ingredients[i].declaration_name)+'</span> - '+capitalize_Words(ingredients[i].long_desc)+'</li>';
                            }
                            $('.menu-ingredients').html(html);
                        }
                    }
                }
            });
			
			var fresid = '<?=$restid;?>';
			if((fresid == '58') || (fresid == '86')){
				var dishid='<?=$recipe_id;?>';
				var allergen='<?php echo $allergen;?>';
				
				$.ajax({ 
						type : 'POST',
						url : 'https://testing.foodnai.com/ws/menuallergendetails.php',
						data : {'dish_id':dishid,'allerganid':allergen},
						success : function(response)
						{
							let responseResult=JSON.parse(response);
							console.log("responseResult",responseResult);
							responseResult.allergens.forEach((allergen)=>{
								let allergeninfo="";
								allergeninfo ="<img src='"+allergen.allergen_image+"'>"+allergen.allergen+"</br>";
								$('.allergen').append(allergeninfo);
							});
							responseResult.all_nutrition.forEach((all_nutrition)=>{
								let nutritioninfo="";
								nutritioninfo ="<div class='row nutition-info all_nutrition'><div class='col-7'>"+all_nutrition.name+"</div><div class='col-5'>"+all_nutrition.quantity+all_nutrition.unit+"</div></div>";
							   $('.nutri-info .nutri-container').append(nutritioninfo);
							});
							responseResult.big8_nutrition.forEach((big8_nutrition)=>{
								let nutritioninfo="";
								nutritioninfo ="<div class='row nutition-info big8_nutrition'><div class='col-7'>"+big8_nutrition.name+"</div><div class='col-5'>"+big8_nutrition.quantity+big8_nutrition.unit+"</div></div>";
							   $('.nutri-info .nutri-container').append(nutritioninfo);
							});
							responseResult.vitamins_NutritionList.forEach((vitamins_NutritionList)=>{
								let nutritioninfo="";
								nutritioninfo ="<div class='row nutition-info vitamins_NutritionList'><div class='col-7'>"+vitamins_NutritionList.name+"</div><div class='col-5'>"+vitamins_NutritionList.quantity+vitamins_NutritionList.unit+"</div></div>";
							   $('.nutri-info .nutri-container').append(nutritioninfo);
							});
						},error:function (error) {
							
						}
					});
			}
        });

    </script>
       <script type="text/javascript">
            function googleTranslateElementInit() {
                new google.translate.TranslateElement({ pageLanguage: 'en', includedLanguages: 'en,mr,hi', multilanguagePage: true}, 'google_translate_element');
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