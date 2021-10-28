<?php include 'header.php'; ?>

    <main id="searchbox">
        <div class="hero_single version_1">
            <div class="opacity-mask">
                <div class="overlay-body"></div>
                <div class="container">
                    <div class="row justify-content-lg-start">
                        <div class="col-xl-7 col-lg-8">
                            <h1>Hungry? We got food for you!</h1>
                            <p>Find restaurants
                                <span class="element" style="font-weight: 500"></span></p>
                            <!--<form method="post" action="grid-listing-filterscol.php">-->
                                <div class="row no-gutters custom-search-input">
                                   <div class="col-lg-4">
                                        <div class="form-group">
                                            
                                            <input type="hidden" id="send_post_code">
                                            <input type="hidden" id="send_restaurant_id">
                                            <input type="hidden" id="send_restaurant_city">
                                            
                                            <input class="form-control no_border_r pincode typehead" type="text" id="pincode" placeholder="Choose your location.."  autocomplete="off">
                                            <i class="icon_pin_alt"></i>
                                            <i class="icon_pin_alt"></i>
                                        </div>
                                    </div>                                
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <input class="form-control no_border_r restaurant_name restaurant_id typeahead" type="text" data-provide="typeahead" autocomplete="off" name="restaurant_id" id="restaurant_id" placeholder="Search for restaurent" >
                                            <i class="icon_search"></i>
                                            
                                        </div>
                                    </div>                                   
                                    <div class="col-lg-2">
                                        <button class="submit_search btn_1 gradient" type="submit">Search</button>
                                    </div>
                                </div>
                                <!-- /row -->
                                <div class="search_trends">
                                    <h5>Search for location:</h5>
                                    <ul>
                                        <li><a href="#0">cuisine</a></li>
                                        <li><a href="#0">restaurant</a></li>
                                        <li>and <a href="#0">dish</a></li>
                                    </ul>
                                </div>
                                <div id="livesearch"></div>
                            <!--</form>-->
                        </div>
                    </div>
                    <!-- /row -->
                </div>
            </div>
            <div class="wave hero"></div>
        </div>
        <!-- /hero_single -->

        <div class="container margin_30_60">
            <div class="owl-carousel owl-theme mockup_carousel">
               
              <?php 

               $sql = "SELECT * FROM admin_offer Where offer_image!=''  limit 10 ";
               $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                          // output data of each filepro_rowcount()
                  while($row = mysqli_fetch_assoc($result)) {
                            ?>
                <div class="mockup-slider">
                    <!--<a href="detail-restaurant.php?restaurant_id=<?php  echo  $row['restaurant_id'] ?>">-->
                        <img src="<?php  echo  $row['offer_image']?>" alt="<?php  echo  $row['offer_image']?>">
                    <!--</a>-->
                </div>

            <?php } } ?>
               
            </div>
        </div>

        <div class="container margin_30_60">
            <div class="main_title center">
                <span><em></em></span>
                <h2>Popular Options</h2>
                <p>There’s a lot of meals to choose from What do you fancy having?</p>
            </div>
            <!-- /main_title -->

            <div class="owl-carousel owl-theme categories_carousel">
               <?php 

               $sql = "SELECT * FROM cuisines";
               $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                          // output data of each filepro_rowcount()
                  while($row = mysqli_fetch_assoc($result)) {
                            ?>
                <div class="item_version_2">
                    <a href="javascript:void(0)">
                        <figure>
                            <!-- <span><?php echo $row['price']  ?></span> -->
                            
                            <!--src="<?php //echo $row['recipe_image'] ?>" data-src="<?php //echo $row['recipe_image'] ?>"-->
                            
                            <img src="https://d24h2kiavvgpl8.cloudfront.net/recipes/veg hakka noodles.JPG" alt="" class="owl-lazy" width="350" height="450" style="opacity: 1;height: 180px;">
                            <div class="info">
                                <h3><?php  echo $row['cuisines'] ?></h3>
                                <!--<small>Avg price $<?php echo $row['price']  ?></small>-->
                            </div>
                        </figure>
                    </a>
                </div>

            <?php }

             } ?>
                
            </div>
            <!-- /carousel -->
        </div>
        <!-- /container -->

        <!--<div class="bg_gray">
            <div class="container margin_60_40">
                <div class="main_title">
                    <span><em></em></span>
                    <h2>Top Rated Restaurants</h2>
                    <p>Cum doctus civibus efficiantur in imperdiet deterruisset.</p>
                    <a href="#0">View All &rarr;</a>
                </div>
                <div class="row add_bottom_25">
                    <div class="col-lg-6">
                        <div class="list_home">
                            <ul>
                                <li>
                                    <a href="detail-restaurant.php">
                                        <figure>
                                            <img src="<?= $root_url; ?>/website_assets/webAssets/img/location_list_placeholder.png" data-src="<?= $root_url; ?>/website_assets/webAssets/img/location_list_1.jpg" alt="" class="lazy" width="350" height="233">
                                        </figure>
                                        <div class="score"><strong>9.5</strong></div>
                                        <em>Italian</em>
                                        <h3>La Monnalisa</h3>
                                        <small>8 Patriot Square E2 9NF</small>
                                        <ul>
                                            <li><span class="ribbon off">-30%</span></li>
                                            <li>Average price $35</li>
                                        </ul>
                                    </a>
                                </li>
                                <li>
                                    <a href="detail-restaurant.php">
                                        <figure>
                                            <img src="<?= $root_url; ?>/website_assets/webAssets/img/location_list_placeholder.png" data-src="<?= $root_url; ?>/website_assets/webAssets/img/location_list_2.jpg" alt="" class="lazy" width="350" height="233">
                                        </figure>
                                        <div class="score"><strong>8.0</strong></div>
                                        <em>Mexican</em>
                                        <h3>Alliance</h3>
                                        <small>27 Old Gloucester St, 4563</small>
                                        <ul>
                                            <li><span class="ribbon off">-40%</span></li>
                                            <li>Average price $30</li>
                                        </ul>
                                    </a>
                                </li>
                                <li>
                                    <a href="detail-restaurant.php">
                                        <figure>
                                            <img src="<?= $root_url; ?>/website_assets/webAssets/img/location_list_placeholder.png" data-src="<?= $root_url; ?>/website_assets/webAssets/img/location_list_3.jpg" alt="" class="lazy" width="350" height="233">
                                        </figure>
                                        <div class="score"><strong>9.0</strong></div>
                                        <em>Sushi - Japanese</em>
                                        <h3>Sushi Gold</h3>
                                        <small>Old Shire Ln EN9 3RX</small>
                                        <ul>
                                            <li><span class="ribbon off">-25%</span></li>
                                            <li>Average price $20</li>
                                        </ul>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="list_home">
                            <ul>
                                <li>
                                    <a href="detail-restaurant.php">
                                        <figure>
                                            <img src="<?= $root_url; ?>/website_assets/webAssets/img/location_list_placeholder.png" data-src="<?= $root_url; ?>/website_assets/webAssets/img/location_list_4.jpg" alt="" class="lazy" width="350" height="233">
                                        </figure>
                                        <div class="score"><strong>9.5</strong></div>
                                        <em>Vegetarian</em>
                                        <h3>Mr. Pepper</h3>
                                        <small>27 Old Gloucester St, 4563</small>
                                        <ul>
                                            <li><span class="ribbon off">-30%</span></li>
                                            <li>Average price $20</li>
                                        </ul>
                                    </a>
                                </li>
                                <li>
                                    <a href="detail-restaurant.php">
                                        <figure>
                                            <img src="<?= $root_url; ?>/website_assets/webAssets/img/location_list_placeholder.png" data-src="<?= $root_url; ?>/website_assets/webAssets/img/location_list_5.jpg" alt="" class="lazy" width="350" height="233">
                                        </figure>
                                        <div class="score"><strong>8.0</strong></div>
                                        <em>Chinese</em>
                                        <h3>Dragon Tower</h3>
                                        <small>22 Hertsmere Rd E14 4ED</small>
                                        <ul>
                                            <li><span class="ribbon off">-50%</span></li>
                                            <li>Average price $35</li>
                                        </ul>
                                    </a>
                                </li>
                                <li>
                                    <a href="detail-restaurant.php">
                                        <figure>
                                            <img src="<?= $root_url; ?>/website_assets/webAssets/img/location_list_placeholder.png" data-src="<?= $root_url; ?>/website_assets/webAssets/img/location_list_6.jpg" alt="" class="lazy" width="350" height="233">
                                        </figure>
                                        <div class="score"><strong>8.5</strong></div>
                                        <em>Pizza - Italian</em>
                                        <h3>Bella Napoli</h3>
                                        <small>135 Newtownards Road BT4</small>
                                        <ul>
                                            <li><span class="ribbon off">-45%</span></li>
                                            <li>Average price $25</li>
                                        </ul>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>-->
                <!-- /row -->
                <!--<div class="banner lazy" data-bg="url(img/banner_bg_desktop.jpg)">
                    <div class="wrapper d-flex align-items-center opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.3)">
                        <div>
                            <small>FooYes Delivery</small>
                            <h3>We Deliver to your Office</h3>
                            <p>Enjoy a tasty food in minutes!</p>
                            <a href="grid-listing-filterscol.php" class="btn_1 gradient">Start Now!</a>
                        </div>
                    </div>
                     /wrapper -->
                </div>
                <!-- /banner -->
            </div>
        </div>
        <!-- /bg_gray -->

        <div class="shape_element_2">
            <div class="container margin_60_0">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="box_how">
                                    <figure><img src="<?= $root_url; ?>/website_assets/webAssets/img/lazy-placeholder-100-100-white.png" data-src="<?= $root_url; ?>/website_assets/webAssets/img/how_1.svg" alt="" width="150" height="167" class="lazy"></figure>
                                    <h3>Easly Order
                                    </h3>
                                    <p>Faucibus ante, in porttitor tellus blandit et. Phasellus tincidunt metus lectus sollicitudin.</p>
                                </div>
                                <div class="box_how">
                                    <figure><img src="<?= $root_url; ?>/website_assets/webAssets/img/lazy-placeholder-100-100-white.png" data-src="<?= $root_url; ?>/website_assets/webAssets/img/how_2.svg" alt="" width="130" height="145" class="lazy"></figure>
                                    <h3>Quick Delivery</h3>
                                    <p>Maecenas pulvinar, risus in facilisis dignissim, quam nisi hendrerit nulla, id vestibulum.</p>
                                </div>
                            </div>
                            <div class="col-lg-6 align-self-center">
                                <div class="box_how">
                                    <figure><img src="<?= $root_url; ?>/website_assets/webAssets/img/lazy-placeholder-100-100-white.png" data-src="<?= $root_url; ?>/website_assets/webAssets/img/how_3.svg" alt="" width="150" height="132" class="lazy"></figure>
                                    <h3>Enjoy Food</h3>
                                    <p>Morbi convallis bibendum urna ut viverra. Maecenas quis consequat libero, a feugiat eros.</p>
                                </div>
                            </div>
                        </div>
                        <p class="text-center mt-3 d-block d-lg-none"><a href="register.php" class="btn_1 medium gradient pulse_bt mt-2">Register Now!</a></p>
                    </div>
                    <div class="col-lg-5 offset-lg-1 align-self-center">
                        <div class="intro_txt">
                            <div class="main_title">
                                <span><em></em></span>
                                <h2>Are you a Restaurant Owner
                                </h2>
                            </div>
                            <p class="lead">Want to sell your food online and manage your orders from the same POS? Look no further, YouResto is that all-in-one solution.</p>
                            <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                            <p><a href="../admin/onboarding/onboardingone" class="btn_1 medium gradient pulse_bt mt-2">Register</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="#0" class="btn_1 medium gradient pulse_bt mt-2">Book a Demo</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /shape_element_2 -->

    </main>
<?php include 'footer.php'; ?>


<script src="admin/assets/js/boostraptypeahead.js"></script>


    <!-- /. Testimonial Section -->
    <script>
		// $('body').delegate('.restaurant_id','focus',function(){

		//         var $input = $('.restaurant_id');
		//         //console.log($input);
		//         $.get("getrestaurants.php", function(data){
		//             $input.typeahead({
		//                 source:data,autoSelect: true,
		//                 afterSelect:function(business_name){
		//                   consolde.log(business_name);
		//                 },
		//             });
		//         },'json');
		//     });
    </script>
    
	<script>
		$(document).ready(function(){
			
			// $(".pincode").click(function(){
			// 	$('.pincode').val('');
			// 	$('#send_post_code').val('');
			// });

			$(".pincode").click(function(){
				$('.pincode').val('');
				$('#send_post_code').val('');
			});

			$(".restaurant_id").click(function(){
				$('.restaurant_id').val('');
				$('#send_restaurant_id').val('');
				$('#send_restaurant_city').val('');
			});

			$('.submit_search').click(function(){
			    
				if($('#send_post_code').val() !='' && $('#send_restaurant_id').val() ==''){
				    
				window.location.href ='restaurant_listing.php?pin_code='+$('#send_post_code').val();
				
				}
				
				if($('#send_restaurant_id').val() !=''){
				    
				//window.location.href ='restaurant_page.php?restaurant_id='+$('#send_restaurant_id').val();
				
				let selectedrestcity = $('#send_restaurant_city').val()?$('#send_restaurant_city').val().split(' ').join('-'):'';
				
				let selectedrestid = $('#send_restaurant_id').val().split(' ').join('-');
				
				// window.location.href ='restaurants/'+selectedrestcity+'/'+selectedrestid;
				
				
				<?php if(isset($_SESSION['user_id'])&&isset($_SESSION['user_name'])){ ?>
				    
				 window.location.href ='restaurant_detail.php?restaurant_name='+$('.restaurant_id').val();
				    
                <?php }else{ ?>
                    
                    console.log("do login");
                    window.location.href ='login.php?restoname='+$('.restaurant_id').val();
                    
                <?php } ?>
				
				
				
				}
				// if($('#send_post_code').val() !='' && $('#send_restaurant_id').val() !=''){
				//   window.location.href ='restaurant_page.php?restaurant_id='+$('#send_restaurant_id').val()+'&pin_code='+$('#send_post_code').val();
				// }
			});

			$('.pincode').keyup(function(){
				var $inputaddress = $(".pincode");
				var search_content = $inputaddress.val();
				if(search_content.length > 2){
					$.get("getaddress.php?search="+search_content, function(data){
						$inputaddress.typeahead({
							source:data,autoSelect: true,
							afterSelect:function(item){
								console.log(item);
								$('#send_post_code').val(item.id);
								// $('.input-item-id').val(item.id);
								// $('#input-price').val(item.price);
								// $('#input-qty').val('1');
								// $('#input-discount').val('0');
							}
						});
					},'json');
				}
				//console.log($inputaddress.val());
			});

			var $input = $(".restaurant_id");
			
			//$('.restaurant_id').keyup(function(){
			//if(parseInt($(".restaurant_id").val().length) > parseInt(3)){
			$.get("getrestaurants.php", function(data){
				$input.typeahead({
					source:data,
					autoSelect: true,
					afterSelect:function(item){
					    
					    console.log("restaurant name selected");
					    
						$('#send_restaurant_id').val(item.name);
						$('#send_restaurant_city').val(item.city);
						// $('.input-item-id').val(item.id);
						// $('#input-price').val(item.price);
						// $('#input-qty').val('1');
						// $('#input-discount').val('0');
					}
				});
			},'json');
			//}
			//});
			
		});
    </script>

<!-- code by victor -->
    <script>
		$(document).ready(function(){
			$("#filter").val(localStorage.getItem("filter"))
			$('.owl-item img').click(function(){
 			$('.overlay-body').show();
 			$("html, body").css('overflow','hidden');
 			$("header.header_in").css('z-index','0');
 			
 			$("html, body").animate({ scrollTop: 0 }, "slow");
 			return false;
			});
			$('.overlay-body').click(function(){
			    $(this).hide();
 			$("html, body").css('overflow','auto');
 			$("header.header_in").css('z-index','auto');
			})
// 			    if(($(window).scrollTop() === 0)){
// 			$(window).scroll($('.overlay-body'),function(){
// 			   $('.overlay-body').hide();
// 			});
// 			    }
		})

    	$('#submit').on("click" ,function () {
    		var value = $("#filter").val();
			localStorage.setItem("filter", value);
    		if (value == "") {
    			window.location.href="index.php";
    		}
    		if (value == "all") {
    			window.location.href=`index.php?page=1`;
    		}
    		if (value == "veg") {
    			window.location.href=`index.php?veg=1`;
    		}
    		if (value == "nonveg") {
    			window.location.href=`index.php?nonveg=1`;
    		}
    	})
    </script>