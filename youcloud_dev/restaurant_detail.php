
<?php include 'header.php';


$vendor_id = $_REQUEST['vid'];


if($vendor_id != ''){

    $vendor_selectSQL = "SELECT * FROM user WHERE is_active = '1' AND usertype='Restaurant' AND id='$vendor_id'";

    $reseto_DataArr = mysqli_query($conn, $vendor_selectSQL);

}

if(isset($_REQUEST['restaurant_name'])){
    
    $restaurant_name = $_REQUEST['restaurant_name'];
    
    $reseto_selectSQL = "SELECT * FROM user WHERE is_active = '1' AND usertype='Restaurant' AND business_name='$restaurant_name'";
    
    $reseto_DataArr = mysqli_query($conn, $reseto_selectSQL);
    
}



/*search action*/

if(isset($_GET['searchKey'])){
    
    $searchKey = $_GET['searchKey'];
    $restaurant_name = $_REQUEST['restaurant_name'];
    
    $reseto_selectSQL = "SELECT * FROM liam WHERE Description LIKE '%".$term."%'";
    
    $reseto_DataArr = mysqli_query($conn, $reseto_selectSQL);
    

    
}


?>


    <!-- SPECIFIC CSS -->
    <link href="<?= $root_url; ?>/website_assets/webAssets/css/detail-page.css" rel="stylesheet">
	<link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" rel="stylesheet">
	<link href="https://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="stylesheet">
    <!-- YOUR CUSTOM CSS -->
    <link href="<?= $root_url; ?>/website_assets/webAssets/css/custom.css" rel="stylesheet">

	<main>
		<div class="hero_in detail_page background-image" data-background="url(<?= $root_url; ?>/website_assets/webAssets/img/hero_general.jpg)">
			<div class="wrapper opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.5)">
				
				<div class="container">
				    <input type="hidden" id="customer_id" value="<?=$_SESSION['user_id']?>">
				    
				    <?php if(count($reseto_DataArr)>0){ 
                    
                    while($vendor_Data = mysqli_fetch_assoc($reseto_DataArr))
                    {
                        
                        $vendor_id = $vendor_Data['id'];
                    ?>
				    
				    <input type="hidden" id="restaurant_id" value="<?=$vendor_id?>">
				    
				    <?php if($vendor_Data['currency_symbol']!=''){ ?>
				        <input type="hidden" id="currency_symbol" value="<?=$vendor_Data['currency_symbol']?>">
				    <?php }else{ ?>
				        <input type="hidden" id="currency_symbol" value="$">
				    <?php } ?>
				    
					<div class="main_info">
						<div class="row">
							<div class="col-xl-7 col-lg-5 col-md-6">
								<div class="head"><div class="score"><span>Superb<em>350 Reviews</em></span><strong>8.9</strong></div></div>
								<h1><?php echo $vendor_Data['name']; $cuisines=explode(',',$vendor_Data['cuisines']); ?></h1>
								<?php echo $vendor_Data['address']; ?> - <a href="https://www.google.com/maps?saddr&daddr=<?php echo $vendor_Data['address']; ?>" target="blank">Get directions</a>
								<ul class="cloudtags">
								    
								    <?php 
								    
								    $restaurant_id = $vendor_Data['id'];
								    for($i=0;$i<count($cuisines);$i++){
									$cuisine_id = $cuisines[$i];
                                    $menu_selectSQL = "SELECT * FROM cuisines WHERE id='$cuisine_id'";
                                    
                                    $menu_getDataArr = mysqli_query($conn, $menu_selectSQL);
                                    
                                    $menu_Data = mysqli_fetch_assoc($menu_getDataArr);?>

									<li>
										<a href="">
											<?php echo $menu_Data['cuisines']; ?>
										</a>
									</li>
								    
                                    <?php } ?>
								    

									
								</ul>
							</div>
							<div class="col-xl-5 col-lg-7 col-md-6">
								<div class="buttons clearfix">
									<span class="magnific-gallery">
										<a href="<?= $root_url; ?>/website_assets/webAssets/img/detail_1.jpg" class="btn_hero" title="Photo title" data-effect="mfp-zoom-in"><i class="icon_image"></i>View photos</a>
										<a href="<?= $root_url; ?>/website_assets/webAssets/img/detail_2.jpg" title="Photo title" data-effect="mfp-zoom-in"></a>
										<a href="<?= $root_url; ?>/website_assets/webAssets/img/detail_3.jpg" title="Photo title" data-effect="mfp-zoom-in"></a>
									</span>
									<a href="#0" class="btn_hero wishlist"><i class="icon_heart"></i>Bookmark</a>
								</div>
							</div>
						</div>
						<!-- /row -->
					</div>
					<!-- /main_info -->
					
					<?php } }else{
					
					echo "No Restaourant Detail's Found !!";
					
					} ?>
				</div>
			</div>
		</div>
		<!--/hero_in-->
		<!-- /secondary_nav -->
		<nav class="listingtabs container mt-4">
			<div class="nav nav-tabs" id="nav-tab" role="tablist">
			  <a class="nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Order Online</a>
			  <a class="nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Book A Table</a>
			  <a class="nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Reviews</a>
			</div>
		  </nav>
		  <div class="tab-content" id="nav-tabContent">
			<div class="tab-pane active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
				<nav class="secondary_nav sticky_horizontal">
					<div class="container-fluid">
					    <div id="menu-slide">
					       <ul class="center">
  <li style="margin-top: 20px;margin-bottom: 20px;"><a class="list-group-item list-group-item-action" href="#">Appetiser</a></li>
    <li style="margin-top: 20px;margin-bottom: 20px;"><a class="list-group-item list-group-item-action" href="#">Soups</a></li>
      <li style="margin-top: 20px;margin-bottom: 20px;"><a class="list-group-item list-group-item-action" href="#">Salad</a></li>
        <li style="margin-top: 20px;margin-bottom: 20px;"><a class="list-group-item list-group-item-action" href="#">Pasta's</a></li>
                <li style="margin-top: 20px;margin-bottom: 20px;"><a class="list-group-item list-group-item-action" href="#">Breakfast</a></li>
                  <li style="margin-top: 20px;margin-bottom: 20px;"><a class="list-group-item list-group-item-action" href="#">Breakfast</a></li>
                   <li style="margin-top: 20px;margin-bottom: 20px;"><a class="list-group-item list-group-item-action" href="#">Breakfast</a></li>
                    <li style="margin-top: 20px;margin-bottom: 20px;"><a class="list-group-item list-group-item-action" href="#">Breakfast</a></li>
                     <li style="margin-top: 20px;margin-bottom: 20px;"><a class="list-group-item list-group-item-action" href="#">Breakfast</a></li>
                      <li style="margin-top: 20px;margin-bottom: 20px;"><a class="list-group-item list-group-item-action" href="#">Breakfast</a></li>
                       <li style="margin-top: 20px;margin-bottom: 20px;"><a class="list-group-item list-group-item-action" href="#">Breakfast</a></li>
                        <li style="margin-top: 20px;margin-bottom: 20px;"><a class="list-group-item list-group-item-action" href="#">Breakfast</a></li>
                         <li style="margin-top: 20px;margin-bottom: 20px;"><a class="list-group-item list-group-item-action" href="#">Breakfast</a></li>
                          <li style="margin-top: 20px;margin-bottom: 20px;"><a class="list-group-item list-group-item-action" href="#">Breakfast</a></li>
                          <li style="margin-top: 20px;margin-bottom: 20px;"><a class="list-group-item list-group-item-action" href="#">Breakfast</a></li>
                          <li style="margin-top: 20px;margin-bottom: 20px;"><a class="list-group-item list-group-item-action" href="#">Breakfast</a></li>
                          <li style="margin-top: 20px;margin-bottom: 20px;"><a class="list-group-item list-group-item-action" href="#">Breakfast</a></li>
                          <li style="margin-top: 20px;margin-bottom: 20px;"><a class="list-group-item list-group-item-action" href="#">Breakfast</a></li>
                          <li style="margin-top: 20px;margin-bottom: 20px;"><a class="list-group-item list-group-item-action" href="#">Breakfast</a></li>
                          <li style="margin-top: 20px;margin-bottom: 20px;"><a class="list-group-item list-group-item-action" href="#">Breakfast</a></li>
                          <li style="margin-top: 20px;margin-bottom: 20px;"><a class="list-group-item list-group-item-action" href="#">Breakfast</a></li>
  
</ul>
					    
						<ul id="secondary_nav" style="display:none;">
                            <?php 
                            
                            if(!empty($_GET['searchKey']) && $_GET['searchKey']!==''){
                                
                                $searchKey = $_GET['searchKey'];
                                  
                                  
                                     $restaurant_name = $_REQUEST['restaurant_name'];
    
                                    $reseto_selectSQL = "SELECT * FROM liam WHERE Description LIKE '%".$term."%'"; 
                                  
                                  
                                  
                                $menuGroup_selectSQL = "SELECT * FROM menu_group WHERE main_menu_id='$main_menu_id'";
                                
                                $menuGroup_getDataArr = mysqli_query($conn, $menuGroup_selectSQL);
                                
                                while($menuGroup_Data = mysqli_fetch_array($menuGroup_getDataArr))
                                {
                                    
                            ?>
						    
							<li style="margin-top: 20px;margin-bottom: 20px;"><a class="list-group-item list-group-item-action" href="#<?php echo $menuGroup_Data['id']; ?>"><?php echo $menuGroup_Data['title']; ?></a></li>
							  
                                
                            <?php    
                                }
                                
                            }else{
                                
                                
                                
                            }
                            
                            $restaurant_id = $vendor_id;
                            
                            $menu_selectSQL = "SELECT * FROM menu_master WHERE restaurant_id='$restaurant_id'";
                            
                            $menu_getDataArr = mysqli_query($conn, $menu_selectSQL);
                            
                            while($menu_Data = mysqli_fetch_assoc($menu_getDataArr))
                            {
                            
                                $main_menu_id = $menu_Data['id'];
                            
                                $menuGroup_selectSQL = "SELECT * FROM menu_group WHERE main_menu_id='$main_menu_id'";
                                
                                $menuGroup_getDataArr = mysqli_query($conn, $menuGroup_selectSQL);
                                
                                while($menuGroup_Data = mysqli_fetch_array($menuGroup_getDataArr))
                                {
                                    
                            ?>
						    
							<li style="margin-top: 20px;margin-bottom: 20px;"><a class="list-group-item list-group-item-action" href="#<?php echo $menuGroup_Data['id']; ?>"><?php echo $menuGroup_Data['title']; ?></a></li>
							
							
							<?php } } ?>
							
							<li><a class="list-group-item list-group-item-action" href="#section-2">Starters</a></li>
							<li><a class="list-group-item list-group-item-action" href="#section-3">Main Courses
							</a></li>
							<li><a class="list-group-item list-group-item-action" href="#section-4">Desserts</a></li>
							<li><a class="list-group-item list-group-item-action" href="#section-5">Drinks</a></li>
						</ul>
					</div>
					<span></span>
				</nav>
			<div class="bg_gray">
				<div class="container margin_detail">
					<div class="row">
						<div class="col-lg-8 list_menu">
							<div class="col-lg-10 padd0" style="margin-top:100px">
								<form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
									<div class="row no-gutters custom-search-input">                              
										<div class="col-lg-10">
											<div class="form-group">
												<input class="form-control no_border_r" name='searchKey' type="text" id="autocomplete" placeholder="Find Dishes...">
											</div>
										</div>                                   
										<div class="col-lg-2">
											<button class="btn_1 gradient" type="submit">Search</button>
										</div>
									</div>
									<!-- /row -->
									<div class="search_trends">
										<h5>Trending:</h5>
										<ul>
											<li><a href="#0">Sushi</a></li>
											<li><a href="#0">Burgher</a></li>
											<li><a href="#0">Chinese</a></li>
											<li><a href="#0">Pizza</a></li>
										</ul>
									</div>
								</form>
							</div>
							<section id="section-1">
								
								<div class="row">
								
								<?php $restaurant_id = $vendor_id; 
								
                                $adminOffer_selectSQL = "SELECT * FROM admin_offer WHERE restaurant_id='$restaurant_id'";
                                
                                $adminOfferDataArr = mysqli_query($conn, $adminOffer_selectSQL);
                                
                                while($adminOffer_Data = mysqli_fetch_assoc($adminOfferDataArr))
                                {
								
								    $end_date = $adminOffer_Data['end_date'];
								    
								    $today = date("Y-m-d");
								    
								    if(!$today>$end_date){
								        
								       $recipe_id = $adminOffer_Data['recipe_id'];
								       
								       								
                                        $recipe_selectSQL = "SELECT * FROM recipes WHERE id='$recipe_id'";
                                        
                                        $recipeDataArr = mysqli_query($conn, $recipe_selectSQL);
                                        
                                        while($recipe_Data = mysqli_fetch_assoc($recipeDataArr))
                                        { ?>
                                        <h4>Limited-Time Offers</h4>
    									<div class="col-md-6">
    										<!--<a class="menu_item modal_dialog" href="#modal-dialog">-->
    										<a class="menu_item modal_dialog" href="#modal-dialog">
    											<figure><img src="<?php echo $recipe_Data['recipe_image']; ?>" data-src="<?php echo $recipe_Data['recipe_image']; ?>" alt="thumb" class="lazy"></figure>
    											<h3><?php echo $recipe_Data['name']; ?></h3>
    											<p><?php echo $recipe_Data['declaration_name']; ?></p>
    											<strong><?php echo $recipe_Data['price']; ?></strong>
    										</a>
    									</div>
								       
                                <?php } } } ?>

									<!--<div class="col-md-6">-->
									<!--	<a class="menu_item modal_dialog" href="#modal-dialog">-->
									<!--		<figure><img src="<?= $root_url; ?>/website_assets/webAssets/img/menu-thumb-placeholder.jpg" data-src="<?= $root_url; ?>/website_assets/webAssets/img/menu-thumb-2.jpg" alt="thumb" class="lazy"></figure>-->
									<!--		<h3>2. Fajitas</h3>-->
									<!--		<p>Fuisset mentitum deleniti sit ea.</p>-->
									<!--		<strong>$9.40</strong>-->
									<!--	</a>-->
									<!--</div>-->
									<!--<div class="col-md-6">-->
									<!--	<a class="menu_item modal_dialog" href="#modal-dialog">-->
									<!--		<figure><img src="<?= $root_url; ?>/website_assets/webAssets/img/menu-thumb-placeholder.jpg" data-src="<?= $root_url; ?>/website_assets/webAssets/img/menu-thumb-3.jpg" alt="thumb" class="lazy"></figure>-->
									<!--		<h3>3. Royal Fajitas</h3>-->
									<!--		<p>Fuisset mentitum deleniti sit ea.</p>-->
									<!--		<strong>$9.40</strong>-->
									<!--	</a>-->
									<!--</div>-->
									<!--<div class="col-md-6">-->
									<!--	<a class="menu_item modal_dialog" href="#modal-dialog">-->
									<!--		<figure><img src="<?= $root_url; ?>/website_assets/webAssets/img/menu-thumb-placeholder.jpg" data-src="<?= $root_url; ?>/website_assets/webAssets/img/menu-thumb-4.jpg" alt="thumb" class="lazy"></figure>-->
									<!--		<h3>4. Chicken Enchilada Wrap</h3>-->
									<!--		<p>Fuisset mentitum deleniti sit ea.</p>-->
									<!--		<strong>$9.40</strong>-->
									<!--	</a>-->
									<!--</div>-->
								</div>
								<!-- /row -->
							</section>
						   <div class="col-lg-10 padd0 list-rows">
						       
    		                <?php 
                            
                            $restaurant_id = $vendor_id;
                            
                            $menu_selectSQL = "SELECT * FROM menu_master WHERE restaurant_id='$restaurant_id'";
                            
                            $menu_getDataArr = mysqli_query($conn, $menu_selectSQL);
                            
                            while($menu_Data = mysqli_fetch_assoc($menu_getDataArr))
                            {
                            
                                $main_menu_id = $menu_Data['id'];
                            
                                $menuGroup_selectSQL = "SELECT * FROM menu_group WHERE main_menu_id='$main_menu_id'";
                                
                                $menuGroup_getDataArr = mysqli_query($conn, $menuGroup_selectSQL);
                                
                                while($menuGroup_Data = mysqli_fetch_array($menuGroup_getDataArr))
                                {
                                    
                            ?>
								 <!-- /section -->
								 <section id="<?php echo $menuGroup_Data['id']; ?>">
									<h4><?php echo $menuGroup_Data['title']; ?></h4>
									<div class="table_wrapper">
										<table class="table cart-list menu-gallery">
											<thead>
												<tr>
													<th>
														Item
													</th>
													<th>
														Price
													</th>
													<th>
														Order
													</th>
												</tr>
											</thead>
											<tbody>
											    <?php 
											    
                                                $menu_group_id = $menuGroup_Data['id'];
                                                
                                                $menuReciepie_selectSQL = "SELECT * FROM recipes WHERE group_id='$menu_group_id'";
                                                
                                                $menuReciepie_getDataArr = mysqli_query($conn, $menuReciepie_selectSQL);
                                                
                                                while($menuReciepie_data = mysqli_fetch_array($menuReciepie_getDataArr))
                                                {
											    
											    ?>
												<tr>
													<td class="d-md-flex align-items-center">
														<figure>
															<a href="<?= $root_url; ?>/website_assets/webAssets/img/menu_item_large_1.jpg" title="Photo title" data-effect="mfp-zoom-in"><img src="<?php echo $menuReciepie_data['recipe_image']; ?>" data-src="<?php echo $menuReciepie_data['recipe_image']; ?>" alt="thumb" class="lazy"></a>
														</figure>
														<div class="flex-md-column">
															<h4><?php echo $menuReciepie_data['name']; ?></h4>
															<p>
																<?php echo $menuReciepie_data['description']; ?>
															</p>
														</div>
													</td>
													<td>
														<strong>₹<?php echo $menuReciepie_data['price']; ?></strong>
													</td>
													<td class="options">
														<!--<a class="modal_dialog" href="#modal-dialog"><i class="icon_plus_alt2"></i></a>-->
														<a class="reciepie_id modal_dialog" href="#modal-dialog" data-reciepie_id=<?php echo $menuReciepie_data['id']; ?> ><i class="icon_plus_alt2"></i></a>
													</td>
												</tr>
												
												<?php } ?>
												
												<!--<tr>-->
												<!--	<td class="d-md-flex align-items-center">-->
												<!--		<figure>-->
												<!--			<a href="<?= $root_url; ?>/website_assets/webAssets/img/menu_item_large_2.jpg" title="Photo title" data-effect="mfp-zoom-in"><img src="<?= $root_url; ?>/website_assets/webAssets/img/menu-thumb-placeholder.jpg" data-src="<?= $root_url; ?>/website_assets/webAssets/img/menu-thumb-2.jpg" alt="thumb" class="lazy"></a>-->
												<!--			</figure>-->
												<!--		<div class="flex-md-column">-->
												<!--			<h4>2. Fajitas</h4>-->
												<!--			<p>-->
												<!--				Fuisset mentitum deleniti sit ea.-->
												<!--			</p>-->
												<!--		</div>-->
												<!--	</td>-->
												<!--	<td>-->
												<!--		<strong>$6.80</strong>-->
												<!--	</td>-->
												<!--	<td class="options">-->
												<!--		<a class="modal_dialog" href="#modal-dialog"><i class="icon_plus_alt2"></i></a>-->
												<!--	</td>-->
												<!--</tr>-->
												<!--<tr>-->
												<!--	<td class="d-md-flex align-items-center">-->
												<!--		<figure>-->
												<!--			<a href="<?= $root_url; ?>/website_assets/webAssets/img/menu_item_large_3.jpg" title="Photo title" data-effect="mfp-zoom-in"><img src="<?= $root_url; ?>/website_assets/webAssets/img/menu-thumb-placeholder.jpg" data-src="<?= $root_url; ?>/website_assets/webAssets/img/menu-thumb-3.jpg" alt="thumb" class="lazy"></a>-->
												<!--		</figure>-->
												<!--		<div class="flex-md-column">-->
												<!--			<h4>3. Royal Fajitas</h4>-->
												<!--			<p>-->
												<!--				Fuisset mentitum deleniti sit ea.-->
												<!--			</p>-->
												<!--		</div>-->
												<!--	</td>-->
												<!--	<td>-->
												<!--		<strong>$5.70</strong>-->
												<!--	</td>-->
												<!--	<td class="options">-->
												<!--		<a class="modal_dialog" href="#modal-dialog"><i class="icon_plus_alt2"></i></a>-->
												<!--	</td>-->
												<!--</tr>-->
												<!--<tr>-->
												<!--	<td class="d-md-flex align-items-center">-->
												<!--		<figure>-->
												<!--			<a href="<?= $root_url; ?>/website_assets/webAssets/img/menu_item_large_4.jpg" title="Photo title" data-effect="mfp-zoom-in"><img src="<?= $root_url; ?>/website_assets/webAssets/img/menu-thumb-placeholder.jpg" data-src="<?= $root_url; ?>/website_assets/webAssets/img/menu-thumb-4.jpg" alt="thumb" class="lazy"></a>-->
												<!--		</figure>-->
												<!--		<div class="flex-md-column">-->
												<!--			<h4>4. Chicken Enchilada Wrap</h4>-->
												<!--			<p>-->
												<!--				Fuisset mentitum deleniti sit ea.-->
												<!--			</p>-->
												<!--		</div>-->
												<!--	</td>-->
												<!--	<td>-->
												<!--		<strong>$5.20</strong>-->
												<!--	</td>-->
												<!--	<td class="options">-->
												<!--		<a class="modal_dialog" href="#modal-dialog"><i class="icon_plus_alt2"></i></a>-->
												<!--	</td>-->
												<!--</tr>-->
											</tbody>
										</table>
									</div>
								</section>
								
								<?php } } ?>
								
								<!--<section id="section-3">-->
								<!--	<h4>Main Courses-->
								<!--	</h4>-->
								<!--	<div class="table_wrapper">-->
								<!--		<table class="table cart-list menu-gallery">-->
								<!--			<thead>-->
								<!--				<tr>-->
								<!--					<th>-->
								<!--						Item-->
								<!--					</th>-->
								<!--					<th>-->
								<!--						Price-->
								<!--					</th>-->
								<!--					<th>-->
								<!--						Order-->
								<!--					</th>-->
								<!--				</tr>-->
								<!--			</thead>-->
								<!--			<tbody>-->
								<!--				<tr>-->
								<!--					<td class="d-md-flex align-items-center">-->
								<!--						<figure>-->
								<!--							<a href="<?= $root_url; ?>/website_assets/webAssets/img/menu_item_large_1.jpg" title="Photo title" data-effect="mfp-zoom-in"><img src="<?= $root_url; ?>/website_assets/webAssets/img/menu-thumb-placeholder.jpg" data-src="<?= $root_url; ?>/website_assets/webAssets/img/menu-thumb-1.jpg" alt="thumb" class="lazy"></a>-->
								<!--						</figure>-->
								<!--						<div class="flex-md-column">-->
								<!--							<h4>1. Mexican Enchiladas</h4>-->
								<!--							<p>-->
								<!--								Fuisset mentitum deleniti sit ea.-->
								<!--							</p>-->
								<!--						</div>-->
								<!--					</td>-->
								<!--					<td>-->
								<!--						<strong>$9.40</strong>-->
								<!--					</td>-->
								<!--					<td class="options">-->
								<!--						<a class="modal_dialog" href="#modal-dialog"><i class="icon_plus_alt2"></i></a>-->
								<!--					</td>-->
								<!--				</tr>-->
								<!--				<tr>-->
								<!--					<td class="d-md-flex align-items-center">-->
								<!--						<figure>-->
								<!--							<a href="<?= $root_url; ?>/website_assets/webAssets/img/menu_item_large_2.jpg" title="Photo title" data-effect="mfp-zoom-in"><img src="<?= $root_url; ?>/website_assets/webAssets/img/menu-thumb-placeholder.jpg" data-src="<?= $root_url; ?>/website_assets/webAssets/img/menu-thumb-2.jpg" alt="thumb" class="lazy"></a>-->
								<!--							</figure>-->
								<!--						<div class="flex-md-column">-->
								<!--							<h4>2. Fajitas</h4>-->
								<!--							<p>-->
								<!--								Fuisset mentitum deleniti sit ea.-->
								<!--							</p>-->
								<!--						</div>-->
								<!--					</td>-->
								<!--					<td>-->
								<!--						<strong>$6.80</strong>-->
								<!--					</td>-->
								<!--					<td class="options">-->
								<!--						<a class="modal_dialog" href="#modal-dialog"><i class="icon_plus_alt2"></i></a>-->
								<!--					</td>-->
								<!--				</tr>-->
								<!--				<tr>-->
								<!--					<td class="d-md-flex align-items-center">-->
								<!--						<figure>-->
								<!--							<a href="<?= $root_url; ?>/website_assets/webAssets/img/menu_item_large_3.jpg" title="Photo title" data-effect="mfp-zoom-in"><img src="<?= $root_url; ?>/website_assets/webAssets/img/menu-thumb-placeholder.jpg" data-src="<?= $root_url; ?>/website_assets/webAssets/img/menu-thumb-3.jpg" alt="thumb" class="lazy"></a>-->
								<!--						</figure>-->
								<!--						<div class="flex-md-column">-->
								<!--							<h4>3. Royal Fajitas</h4>-->
								<!--							<p>-->
								<!--								Fuisset mentitum deleniti sit ea.-->
								<!--							</p>-->
								<!--						</div>-->
								<!--					</td>-->
								<!--					<td>-->
								<!--						<strong>$5.70</strong>-->
								<!--					</td>-->
								<!--					<td class="options">-->
								<!--						<a class="modal_dialog" href="#modal-dialog"><i class="icon_plus_alt2"></i></a>-->
								<!--					</td>-->
								<!--				</tr>-->
								<!--				<tr>-->
								<!--					<td class="d-md-flex align-items-center">-->
								<!--						<figure>-->
								<!--							<a href="<?= $root_url; ?>/website_assets/webAssets/img/menu_item_large_4.jpg" title="Photo title" data-effect="mfp-zoom-in"><img src="<?= $root_url; ?>/website_assets/webAssets/img/menu-thumb-placeholder.jpg" data-src="<?= $root_url; ?>/website_assets/webAssets/img/menu-thumb-4.jpg" alt="thumb" class="lazy"></a>-->
								<!--						</figure>-->
								<!--						<div class="flex-md-column">-->
								<!--							<h4>4. Chicken Enchilada Wrap</h4>-->
								<!--							<p>-->
								<!--								Fuisset mentitum deleniti sit ea.-->
								<!--							</p>-->
								<!--						</div>-->
								<!--					</td>-->
								<!--					<td>-->
								<!--						<strong>$5.20</strong>-->
								<!--					</td>-->
								<!--					<td class="options">-->
								<!--						<a class="modal_dialog" href="#modal-dialog"><i class="icon_plus_alt2"></i></a>-->
								<!--					</td>-->
								<!--				</tr>-->
								<!--			</tbody>-->
								<!--		</table>-->
								<!--	</div>-->
								<!--</section>-->
								<!--<section id="section-4">-->
								<!--	<h4>Desserts</h4>-->
								<!--	<div class="table_wrapper">-->
								<!--		<table class="table cart-list menu-gallery">-->
								<!--			<thead>-->
								<!--				<tr>-->
								<!--					<th>-->
								<!--						Item-->
								<!--					</th>-->
								<!--					<th>-->
								<!--						Price-->
								<!--					</th>-->
								<!--					<th>-->
								<!--						Order-->
								<!--					</th>-->
								<!--				</tr>-->
								<!--			</thead>-->
								<!--			<tbody>-->
								<!--				<tr>-->
								<!--					<td class="d-md-flex align-items-center">-->
								<!--						<figure>-->
								<!--							<a href="<?= $root_url; ?>/website_assets/webAssets/img/menu_item_large_1.jpg" title="Photo title" data-effect="mfp-zoom-in"><img src="<?= $root_url; ?>/website_assets/webAssets/img/menu-thumb-placeholder.jpg" data-src="<?= $root_url; ?>/website_assets/webAssets/img/menu-thumb-1.jpg" alt="thumb" class="lazy"></a>-->
								<!--						</figure>-->
								<!--						<div class="flex-md-column">-->
								<!--							<h4>1. Mexican Enchiladas</h4>-->
								<!--							<p>-->
								<!--								Fuisset mentitum deleniti sit ea.-->
								<!--							</p>-->
								<!--						</div>-->
								<!--					</td>-->
								<!--					<td>-->
								<!--						<strong>$9.40</strong>-->
								<!--					</td>-->
								<!--					<td class="options">-->
								<!--						<a class="modal_dialog" href="#modal-dialog"><i class="icon_plus_alt2"></i></a>-->
								<!--					</td>-->
								<!--				</tr>-->
								<!--				<tr>-->
								<!--					<td class="d-md-flex align-items-center">-->
								<!--						<figure>-->
								<!--							<a href="<?= $root_url; ?>/website_assets/webAssets/img/menu_item_large_2.jpg" title="Photo title" data-effect="mfp-zoom-in"><img src="<?= $root_url; ?>/website_assets/webAssets/img/menu-thumb-placeholder.jpg" data-src="<?= $root_url; ?>/website_assets/webAssets/img/menu-thumb-2.jpg" alt="thumb" class="lazy"></a>-->
								<!--							</figure>-->
								<!--						<div class="flex-md-column">-->
								<!--							<h4>2. Fajitas</h4>-->
								<!--							<p>-->
								<!--								Fuisset mentitum deleniti sit ea.-->
								<!--							</p>-->
								<!--						</div>-->
								<!--					</td>-->
								<!--					<td>-->
								<!--						<strong>$6.80</strong>-->
								<!--					</td>-->
								<!--					<td class="options">-->
								<!--						<a href="#"><i class="icon_plus_alt2"></i></a>-->
								<!--					</td>-->
								<!--				</tr>-->
								<!--				<tr>-->
								<!--					<td class="d-md-flex align-items-center">-->
								<!--						<figure>-->
								<!--							<a href="<?= $root_url; ?>/website_assets/webAssets/img/menu_item_large_3.jpg" title="Photo title" data-effect="mfp-zoom-in"><img src="<?= $root_url; ?>/website_assets/webAssets/img/menu-thumb-placeholder.jpg" data-src="<?= $root_url; ?>/website_assets/webAssets/img/menu-thumb-3.jpg" alt="thumb" class="lazy"></a>-->
								<!--						</figure>-->
								<!--						<div class="flex-md-column">-->
								<!--							<h4>3. Royal Fajitas</h4>-->
								<!--							<p>-->
								<!--								Fuisset mentitum deleniti sit ea.-->
								<!--							</p>-->
								<!--						</div>-->
								<!--					</td>-->
								<!--					<td>-->
								<!--						<strong>$5.70</strong>-->
								<!--					</td>-->
								<!--					<td class="options">-->
								<!--						<a href="#"><i class="icon_plus_alt2"></i></a>-->
								<!--					</td>-->
								<!--				</tr>-->
								<!--				<tr>-->
								<!--					<td class="d-md-flex align-items-center">-->
								<!--						<figure>-->
								<!--							<a href="<?= $root_url; ?>/website_assets/webAssets/img/menu_item_large_4.jpg" title="Photo title" data-effect="mfp-zoom-in"><img src="<?= $root_url; ?>/website_assets/webAssets/img/menu-thumb-placeholder.jpg" data-src="<?= $root_url; ?>/website_assets/webAssets/img/menu-thumb-4.jpg" alt="thumb" class="lazy"></a>-->
								<!--						</figure>-->
								<!--						<div class="flex-md-column">-->
								<!--							<h4>4. Chicken Enchilada Wrap</h4>-->
								<!--							<p>-->
								<!--								Fuisset mentitum deleniti sit ea.-->
								<!--							</p>-->
								<!--						</div>-->
								<!--					</td>-->
								<!--					<td>-->
								<!--						<strong>$5.20</strong>-->
								<!--					</td>-->
								<!--					<td class="options">-->
								<!--						<a href="#"><i class="icon_plus_alt2"></i></a>-->
								<!--					</td>-->
								<!--				</tr>-->
								<!--			</tbody>-->
								<!--		</table>-->
								<!--	</div>-->
								<!--</section>-->
								<!--<section id="section-5">-->
								<!--	<h4>Drinks</h4>-->
								<!--	<div class="table_wrapper">-->
								<!--		<table class="table cart-list menu-gallery">-->
								<!--			<thead>-->
								<!--				<tr>-->
								<!--					<th>-->
								<!--						Item-->
								<!--					</th>-->
								<!--					<th>-->
								<!--						Price-->
								<!--					</th>-->
								<!--					<th>-->
								<!--						Order-->
								<!--					</th>-->
								<!--				</tr>-->
								<!--			</thead>-->
								<!--			<tbody>-->
								<!--				<tr>-->
								<!--					<td class="d-md-flex align-items-center">-->
								<!--						<figure>-->
								<!--							<a href="<?= $root_url; ?>/website_assets/webAssets/img/menu_item_large_1.jpg" title="Photo title" data-effect="mfp-zoom-in"><img src="<?= $root_url; ?>/website_assets/webAssets/img/menu-thumb-placeholder.jpg" data-src="<?= $root_url; ?>/website_assets/webAssets/img/menu-thumb-1.jpg" alt="thumb" class="lazy"></a>-->
								<!--						</figure>-->
								<!--						<div class="flex-md-column">-->
								<!--							<h4>1. Mexican Enchiladas</h4>-->
								<!--							<p>-->
								<!--								Fuisset mentitum deleniti sit ea.-->
								<!--							</p>-->
								<!--						</div>-->
								<!--					</td>-->
								<!--					<td>-->
								<!--						<strong>$9.40</strong>-->
								<!--					</td>-->
								<!--					<td class="options">-->
								<!--						<a href="#"><i class="icon_plus_alt2"></i></a>-->
								<!--					</td>-->
								<!--				</tr>-->
								<!--				<tr>-->
								<!--					<td class="d-md-flex align-items-center">-->
								<!--						<figure>-->
								<!--							<a href="<?= $root_url; ?>/website_assets/webAssets/img/menu_item_large_2.jpg" title="Photo title" data-effect="mfp-zoom-in"><img src="<?= $root_url; ?>/website_assets/webAssets/img/menu-thumb-placeholder.jpg" data-src="<?= $root_url; ?>/website_assets/webAssets/img/menu-thumb-2.jpg" alt="thumb" class="lazy"></a>-->
								<!--							</figure>-->
								<!--						<div class="flex-md-column">-->
								<!--							<h4>2. Fajitas</h4>-->
								<!--							<p>-->
								<!--								Fuisset mentitum deleniti sit ea.-->
								<!--							</p>-->
								<!--						</div>-->
								<!--					</td>-->
								<!--					<td>-->
								<!--						<strong>$6.80</strong>-->
								<!--					</td>-->
								<!--					<td class="options">-->
								<!--						<a href="#"><i class="icon_plus_alt2"></i></a>-->
								<!--					</td>-->
								<!--				</tr>-->
								<!--				<tr>-->
								<!--					<td class="d-md-flex align-items-center">-->
								<!--						<figure>-->
								<!--							<a href="<?= $root_url; ?>/website_assets/webAssets/img/menu_item_large_3.jpg" title="Photo title" data-effect="mfp-zoom-in"><img src="<?= $root_url; ?>/website_assets/webAssets/img/menu-thumb-placeholder.jpg" data-src="<?= $root_url; ?>/website_assets/webAssets/img/menu-thumb-3.jpg" alt="thumb" class="lazy"></a>-->
								<!--						</figure>-->
								<!--						<div class="flex-md-column">-->
								<!--							<h4>3. Royal Fajitas</h4>-->
								<!--							<p>-->
								<!--								Fuisset mentitum deleniti sit ea.-->
								<!--							</p>-->
								<!--						</div>-->
								<!--					</td>-->
								<!--					<td>-->
								<!--						<strong>$5.70</strong>-->
								<!--					</td>-->
								<!--					<td class="options">-->
								<!--						<a href="#"><i class="icon_plus_alt2"></i></a>-->
								<!--					</td>-->
								<!--				</tr>-->
								<!--				<tr>-->
								<!--					<td class="d-md-flex align-items-center">-->
								<!--						<figure>-->
								<!--							<a href="<?= $root_url; ?>/website_assets/webAssets/img/menu_item_large_4.jpg" title="Photo title" data-effect="mfp-zoom-in"><img src="<?= $root_url; ?>/website_assets/webAssets/img/menu-thumb-placeholder.jpg" data-src="<?= $root_url; ?>/website_assets/webAssets/img/menu-thumb-4.jpg" alt="thumb" class="lazy"></a>-->
								<!--						</figure>-->
								<!--						<div class="flex-md-column">-->
								<!--							<h4>4. Chicken Enchilada Wrap</h4>-->
								<!--							<p>-->
								<!--								Fuisset mentitum deleniti sit ea.-->
								<!--							</p>-->
								<!--						</div>-->
								<!--					</td>-->
								<!--					<td>-->
								<!--						<strong>$5.20</strong>-->
								<!--					</td>-->
								<!--					<td class="options">-->
								<!--						<a href="#"><i class="icon_plus_alt2"></i></a>-->
								<!--					</td>-->
								<!--				</tr>-->
								<!--			</tbody>-->
								<!--		</table>-->
								<!--	</div>-->
								<!--</section>-->
								<!-- /section -->
						   </div>
						</div>
						<!-- /col -->
						<div class="col-lg-4" id="sidebar_fixed">
							<div class="box_order mobile_fixed">
								<div class="head">
									<h3>Order Summary</h3>
									<a href="#0" class="close_panel_mobile"><i class="icon_close"></i></a>
								</div>
								<!-- /head -->
								<div class="main">
								    <div id="order_summary">
									<ul class="clearfix">
										<!--<li><a href="#0">1x Enchiladas</a><span>$11</span></li>-->
										<!--<li><a href="#0">2x Burrito</a><span>$14</span></li>-->
										<!--<li><a href="#0">1x Chicken</a><span>$18</span></li>-->
										<!--<li><a href="#0">2x Corona Beer</a><span>$9</span></li>-->
										<!--<li><a href="#0">2x Cheese Cake</a><span>$11</span></li>-->
									</ul>
									<ul class="clearfix">
										<!--<li>Subtotal<span>$56</span></li>-->
										<!--<li>Delivery fee<span>$10</span></li>-->
										<!--<li class="total">Total<span>$66</span></li>-->
									</ul>
									</div>
									<div class="row opt_order">
										<!--<div class="col-6">-->
										<!--	<label class="container_radio deliverynow">Delivery Now-->
										<!--		<input type="radio" value="option1" name="opt_order" checked>-->
										<!--		<span class="checkmark"></span>-->
										<!--	</label>-->
										<!--</div>-->
										<!--<div class="col-6">-->
										<!--	<label class="container_radio d deliverylater">Deliver Later-->
										<!--		<input type="radio" value="option1" name="opt_order">-->
										<!--		<span class="checkmark"></span>-->
										<!--	</label>-->
										<!--</div>-->
									</div>
									<div class="dropdown day dropdowndayandtime" style="display: none;">
										<a href="#" data-toggle="dropdown">Day <span id="selected_day"></span></a>
										<div class="dropdown-menu">
											<div class="dropdown-menu-content">
												<h4>Which day delivered?</h4>
												<div class="radio_select chose_day">
													<ul>
														<li>
															<input type="radio" id="day_1" name="day" value="Today">
															<label for="day_1">Today<em>-40%</em></label>
														</li>
														<li>
															<input type="radio" id="day_2" name="day" value="Tomorrow">
															<label for="day_2">Tomorrow<em>-40%</em></label>
														</li>
													</ul>
												</div>
												<!-- /people_select -->
											</div>
										</div>
									</div>
									<!-- /dropdown -->
									<div class="dropdown time dropdowndayandtime" style="display: none;">
										<a href="#" data-toggle="dropdown">Time <span id="selected_time"></span></a>
										<div class="dropdown-menu">
											<div class="dropdown-menu-content">
												<h4>Lunch</h4>
												<div class="radio_select add_bottom_15">
													<ul>
														<li>
															<input type="radio" id="time_1" name="time" value="12.00am">
															<label for="time_1">12.00<em>-40%</em></label>
														</li>
														<li>
															<input type="radio" id="time_2" name="time" value="08.30pm">
															<label for="time_2">12.30<em>-40%</em></label>
														</li>
														<li>
															<input type="radio" id="time_3" name="time" value="09.00pm">
															<label for="time_3">1.00<em>-40%</em></label>
														</li>
														<li>
															<input type="radio" id="time_4" name="time" value="09.30pm">
															<label for="time_4">1.30<em>-40%</em></label>
														</li>
													</ul>
												</div>
												<!-- /time_select -->
												<h4>Dinner</h4>
												<div class="radio_select">
													<ul>
														<li>
															<input type="radio" id="time_5" name="time" value="08.00pm">
															<label for="time_1">20.00<em>-40%</em></label>
														</li>
														<li>
															<input type="radio" id="time_6" name="time" value="08.30pm">
															<label for="time_2">20.30<em>-40%</em></label>
														</li>
														<li>
															<input type="radio" id="time_7" name="time" value="09.00pm">
															<label for="time_3">21.00<em>-40%</em></label>
														</li>
														<li>
															<input type="radio" id="time_8" name="time" value="09.30pm">
															<label for="time_4">21.30<em>-40%</em></label>
														</li>
													</ul>
												</div>
												<!-- /time_select -->
											</div>
										</div>
									</div>
									<!-- /dropdown -->
									<div class="btn_1_mobile">
										<span class="btn_1 gradient full-width mb_5" id="place_order" style="display:none;">Order Now</span>
										<div class="text-center"><small>No money charged on this steps</small></div>
									</div>
								</div>
							</div>
							<!-- /box_order -->
							<div class="btn_reserve_fixed"><a href="#0" class="btn_1 gradient full-width">View Basket</a></div>
						</div>
					</div>
					<!-- /row -->
				</div>
				<!-- /container -->
			</div></div>
			<div class="tab-pane" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
				<div class="container margin_detail">
					<div class="container">
						<div class="row">
							<div class="col-lg-8">
								<p>Mei at intellegat reprehendunt, te facilisis definiebas dissentiunt usu. Choro delicata voluptatum cu vix.Sea error splendide at.</p>
								<p> Te sed facilisi persequeris definitiones, ad per scriptorem instructior, vim latine adipiscing no. Cu tacimates salutandi his, mel te dicant quodsi aperiri. Unum timeam his eu.</p>
								<div class="pictures single_pagegallery magnific-gallery clearfix">
									<figure><a href="<?= $root_url; ?>/website_assets/webAssets/img/location_1.jpg" title="Photo title" data-effect="mfp-zoom-in"><img src="<?= $root_url; ?>/website_assets/webAssets/img/location_1.jpg" data-src="<?= $root_url; ?>/website_assets/webAssets/img/location_1.jpg" class="lazy loaded" alt="" data-was-processed="true"></a></figure>
									<figure><a href="<?= $root_url; ?>/website_assets/webAssets/img/location_2.jpg" title="Photo title" data-effect="mfp-zoom-in"><img src="<?= $root_url; ?>/website_assets/webAssets/img/location_2.jpg" data-src="<?= $root_url; ?>/website_assets/webAssets/img/location_2.jpg" class="lazy loaded" alt="" data-was-processed="true"></a></figure>
									<figure><a href="<?= $root_url; ?>/website_assets/webAssets/img/location_3.jpg" title="Photo title" data-effect="mfp-zoom-in"><img src="<?= $root_url; ?>/website_assets/webAssets/img/location_3.jpg" data-src="<?= $root_url; ?>/website_assets/webAssets/img/location_3.jpg" class="lazy loaded" alt="" data-was-processed="true"></a></figure>
									<figure><a href="<?= $root_url; ?>/website_assets/webAssets/img/location_4.jpg" title="Photo title" data-effect="mfp-zoom-in"><img src="<?= $root_url; ?>/website_assets/webAssets/img/location_4.jpg" data-src="<?= $root_url; ?>/website_assets/webAssets/img/location_4.jpg" class="lazy loaded" alt="" data-was-processed="true"></a></figure>
									<figure><a href="<?= $root_url; ?>/website_assets/webAssets/img/location_5.jpg" title="Photo title" data-effect="mfp-zoom-in"><span class="d-flex align-items-center justify-content-center">+10</span><img src="<?= $root_url; ?>/website_assets/webAssets/img/location_5.jpg" data-src="<?= $root_url; ?>/website_assets/webAssets/img/location_5.jpg" class="lazy loaded" alt="" data-was-processed="true"></a></figure>
								</div>
								<h4 class="mt-3 text-center">How to get to Pizzeria Alfredo</h4>
								<div class="row cloudwebaddress">
									<div class="col-lg-4 box_topic text-left">
										<h3>Address</h3>
										<p class="mb-0">27 Old Gloucester St, 4530</p>
										<a href=""><strong>Get Directions</strong></a>
										<h6 class="mt-3">Follow Us</h6>
										<ul class="d-flex listingsocialicons">
											<li>
												<a href="">
													<i class="social_facebook"></i>
												</a>
											</li>
											<li>
												<a href="">
													<i class="social_instagram"></i>
												</a>
											</li>
											<li>
												<a href="">
													<i class="social_twitter"></i>
												</a>
											</li>
										</ul>
									</div>
									<div class="col-lg-4 box_topic text-left">
										<h3>Open Time</h3>
										<h6>Lunch</h6>
										<p>Lunch : Mon. to Sat. 11.00am - 3.00pm</p>
										<h6>Dinner</h6>
										<p>Dinner : Mon. to Sat. 6.00pm - 1.00am										</p>
										<a href="" class="cloudwebaddress_btn">
											Sunday Closed
										</a>
									</div>
									<div class="col-lg-4 box_topic text-left">
										<h3>Services</h3>
										<h6>Credit Cards</h6>
										<p>Mastercard, Visa, Amex
										</p>
										<h6>Other</h6>
										<p>Wifi, Parking, Wheelchair Accessible</p>
									</div>
								</div>
							</div>
							<div class="col-lg-4 booking-table">
								<div class="box_order mobile_fixed">
									<div class="head">
										<h3>Book Your Table</h3>
										<!--<p>Up to-40% off</p>-->
									</div>
									<!-- /head -->
									<div class="main">
										<div class="calendar"></div>
										<div class="dropdown time">
											<a href="#" data-toggle="dropdown">Hours:8:30pm <span id="selected_day"></span></a>
											<div class="dropdown-menu">
												<div class="dropdown-menu-content">
													<h4>Which day delivered?</h4>
													<div class="radio_select chose_day">
														<ul>
															<li>
																<input type="radio" id="day_1" name="day" value="Today">
																<label for="day_1">Today<em>-40%</em></label>
															</li>
															<li>
																<input type="radio" id="day_2" name="day" value="Tomorrow">
																<label for="day_2">Tomorrow<em>-40%</em></label>
															</li>
														</ul>
													</div>
													<!-- /people_select -->
												</div>
											</div>
										</div>
										<!-- /dropdown -->
										<div class="dropdown time">
											<a href="#" data-toggle="dropdown">People 2 <span id="selected_time"></span></a>
											<div class="dropdown-menu">
												<div class="dropdown-menu-content">
													<h4>Lunch</h4>
													<div class="radio_select add_bottom_15">
														<ul>
															<li>
																<input type="radio" id="time_1" name="time" value="12.00am">
																<label for="time_1">12.00<em>-40%</em></label>
															</li>
															<li>
																<input type="radio" id="time_2" name="time" value="08.30pm">
																<label for="time_2">12.30<em>-40%</em></label>
															</li>
															<li>
																<input type="radio" id="time_3" name="time" value="09.00pm">
																<label for="time_3">1.00<em>-40%</em></label>
															</li>
															<li>
																<input type="radio" id="time_4" name="time" value="09.30pm">
																<label for="time_4">1.30<em>-40%</em></label>
															</li>
														</ul>
													</div>
													<!-- /time_select -->
													<h4>Dinner</h4>
													<div class="radio_select">
														<ul>
															<li>
																<input type="radio" id="time_5" name="time" value="08.00pm">
																<label for="time_1">20.00<em>-40%</em></label>
															</li>
															<li>
																<input type="radio" id="time_6" name="time" value="08.30pm">
																<label for="time_2">20.30<em>-40%</em></label>
															</li>
															<li>
																<input type="radio" id="time_7" name="time" value="09.00pm">
																<label for="time_3">21.00<em>-40%</em></label>
															</li>
															<li>
																<input type="radio" id="time_8" name="time" value="09.30pm">
																<label for="time_4">21.30<em>-40%</em></label>
															</li>
														</ul>
													</div>
													<!-- /time_select -->
												</div>
											</div>
										</div>
										<!-- /dropdown -->
										<div class="btn_1_mobile">
											<a href="success.html" class="btn_1 gradient full-width mb_5">Reserve Now</a>
											<div class="text-center"><small>No money charged on this steps</small></div>
										</div>
										
									</div>
								</div>
								<ul class="d-flex youcloud-social mt-4 justify-content-center">
									<li class="fb">
										<a href="">
											<i class="social_facebook"></i>Share
										</a>
									</li>
									<li class="twitt">
										<a href="">
											<i class="social_twitter"></i>
											Share
										</a>
									</li>
									<li class="gplus">
										<a href="">
											<i class="social_googleplus"></i>
											Share
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="tab-pane" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
				<div class="bg_gray">
					<div class="container margin_detail">
						<div class="container margin_30_20">
							<div class="row">
								<div class="col-lg-8 list_menu">
									<section id="section-5">
										<h4>Reviews</h4>
										<div class="row add_bottom_30 d-flex align-items-center reviews">
											<div class="col-md-3">
												<div id="review_summary">
													<strong>8.5</strong>
													<em>Superb</em>
													<small>Based on 4 reviews</small>
												</div>
											</div>
											<div class="col-md-9 reviews_sum_details">
												<div class="row">
													<div class="col-md-6">
														<h6>Food Quality</h6>
														<div class="row">
															<div class="col-xl-10 col-lg-9 col-9">
																<div class="progress">
																	<div class="progress-bar" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
																</div>
															</div>
															<div class="col-xl-2 col-lg-3 col-3"><strong>9.0</strong></div>
														</div>
														
														<h6>Service</h6>
														<div class="row">
															<div class="col-xl-10 col-lg-9 col-9">
																<div class="progress">
																	<div class="progress-bar" role="progressbar" style="width: 95%" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
																</div>
															</div>
															<div class="col-xl-2 col-lg-3 col-3"><strong>9.5</strong></div>
														</div>
													
													</div>
													<div class="col-md-6">
														<h6>Punctuality</h6>
														<div class="row">
															<div class="col-xl-10 col-lg-9 col-9">
																<div class="progress">
																	<div class="progress-bar" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
																</div>
															</div>
															<div class="col-xl-2 col-lg-3 col-3"><strong>6.0</strong></div>
														</div>
													
														<h6>Price</h6>
														<div class="row">
															<div class="col-xl-10 col-lg-9 col-9">
																<div class="progress">
																	<div class="progress-bar" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
																</div>
															</div>
															<div class="col-xl-2 col-lg-3 col-3"><strong>6.0</strong></div>
														</div>
														
													</div>
												</div>
												
											</div>
										</div>
										
										<div id="reviews">
											<div class="review_card">
												<div class="row">
													<div class="col-md-2 user_info">
														<figure><img src="<?= $root_url; ?>/website_assets/webAssets/img/avatar4.jpg" alt=""></figure>
														<h5>Lukas</h5>
													</div>
													<div class="col-md-10 review_content">
														<div class="clearfix add_bottom_15">
															<span class="rating">8.5<small>/10</small> <strong>Rating average</strong></span>
															<em>Published 54 minutes ago</em>
														</div>
														<h4>"Great Location!!"</h4>
														<p>Eos tollit ancillae ea, lorem consulatu qui ne, eu eros eirmod scaevola sea. Et nec tantas accusamus salutatus, sit commodo veritus te, erat legere fabulas has ut. Rebum laudem cum ea, ius essent fuisset ut. Viderer petentium cu his. Tollit molestie suscipiantur his et.</p>
														<ul>
															<li><a href="#0"><i class="icon_like"></i><span>Useful</span></a></li>
															<li><a href="#0"><i class="icon_dislike"></i><span>Not useful</span></a></li>
															<li><a href="#0"><i class="arrow_back"></i> <span>Reply</span></a></li>
														</ul>
													</div>
												</div>
											
											</div>
										
											<div class="review_card">
												<div class="row">
													<div class="col-md-2 user_info">
														<figure><img src="<?= $root_url; ?>/website_assets/webAssets/img/avatar1.jpg" alt=""></figure>
														<h5>Marika</h5>
													</div>
													<div class="col-md-10 review_content">
														<div class="clearfix add_bottom_15">
															<span class="rating">9.0<small>/10</small> <strong>Rating average</strong></span>
															<em>Published 11 Oct. 2019</em>
														</div>
														<h4>"Really great dinner!!"</h4>
														<p>Eos tollit ancillae ea, lorem consulatu qui ne, eu eros eirmod scaevola sea. Et nec tantas accusamus salutatus, sit commodo veritus te, erat legere fabulas has ut. Rebum laudem cum ea, ius essent fuisset ut. Viderer petentium cu his. Tollit molestie suscipiantur his et.</p>
														<ul>
															<li><a href="#0"><i class="icon_like"></i><span>Useful</span></a></li>
															<li><a href="#0"><i class="icon_dislike"></i><span>Not useful</span></a></li>
															<li><a href="#0"><i class="arrow_back"></i> <span>Reply</span></a></li>
														</ul>
													</div>
												</div>
												
												<div class="row reply">
													<div class="col-md-2 user_info">
														<figure><img src="<?= $root_url; ?>/website_assets/webAssets/img/avatar.jpg" alt=""></figure>
													</div>
													<div class="col-md-10">
														<div class="review_content">
															<strong>Reply from Foogra</strong>
															<em>Published 3 minutes ago</em>
															<p><br>Hi Monika,<br><br>Eos tollit ancillae ea, lorem consulatu qui ne, eu eros eirmod scaevola sea. Et nec tantas accusamus salutatus, sit commodo veritus te, erat legere fabulas has ut. Rebum laudem cum ea, ius essent fuisset ut. Viderer petentium cu his. Tollit molestie suscipiantur his et.<br><br>Thanks</p>
														</div>
													</div>
												</div> 
											</div>
										
										</div>
									
										<div class="text-right"><a href="reviewforrestro.html" class="btn_1 gradient">Leave a Review</a></div>
									</section>
									
								</div>
							</div>
					</div>
				</div>
		</div>
		<!-- /container -->
			</div>
		  </div>
		
		<!-- /bg_gray -->

		

	</main>
	<!-- /main -->

<!-- Modal item order -->
<div id="modal-dialog" class="zoom-anim-dialog mfp-hide">
    <div class="small-dialog-header">
        <h3 class='item_title'></h3>
    </div>
    <div class="content">
		<div id="show_recipe_id"></div>
        <h5>Quantity</h5>
        <!--<div class="numbers-row">-->
        <!--    <input type="text" value="1" id="qty_1" class="qty2 form-control" name="quantity">-->
        <!--</div>-->
        <input type="number" value="1" id="qty" class="form-control" name="quantity" min="1">
        <!--<h5>Size</h5>-->
        <!--<ul class="clearfix">-->
        <!--    <li>-->
        <!--        <label class="container_radio">Medium<span>+ $3.30</span>-->
        <!--            <input type="radio" value="option1" name="options_1">-->
        <!--            <span class="checkmark"></span>-->
        <!--        </label>-->
        <!--    </li>-->
        <!--    <li>-->
        <!--        <label class="container_radio">Large<span>+ $5.30</span>-->
        <!--            <input type="radio" value="option2" name="options_1">-->
        <!--            <span class="checkmark"></span>-->
        <!--        </label>-->
        <!--    </li>-->
        <!--    <li>-->
        <!--        <label class="container_radio">Extra Large<span>+ $8.30</span>-->
        <!--            <input type="radio" value="option3" name="options_1">-->
        <!--            <span class="checkmark"></span>-->
        <!--        </label>-->
        <!--    </li>-->
        <!--</ul>-->
        
        <div class='addons_div' style='display:none'>
        <h5>Extra Ingredients</h5>
        <ul class="clearfix extra_ingredients">
            
            
            
            <!--<li>-->
            <!--    <label class="container_check">Extra Peppers<span>+ $2.50</span>-->
            <!--        <input type="checkbox">-->
            <!--        <span class="checkmark"></span>-->
            <!--    </label>-->
            <!--</li>-->
            <!--<li>-->
            <!--    <label class="container_check">Extra Ham<span>+ $4.30</span>-->
            <!--        <input type="checkbox">-->
            <!--        <span class="checkmark"></span>-->
            <!--    </label>-->
            <!--</li>-->
        </ul>
        </div>
        
    </div>
    <div class="footer">
        <div class="row small-gutters">
            <div class="col-md-4">
                <button type="reset" class="btn_1 outline cancel_btn full-width mb-mobile">Cancel</button>
            </div>
            <div class="col-md-8">
                <button type="reset" class="btn_1 full-width greenolive" id="add_to_cart">Add to cart</button>
            </div>
        </div>
        <!-- /Row -->
    </div>
    </div>
    <!-- /Modal item order -->



<?php include 'footer.php'; ?>


    <!-- SPECIFIC SCRIPTS -->
    <script src="<?= $root_url; ?>/website_assets/webAssets/js/sticky_sidebar.min.js"></script>
    <script src="<?= $root_url; ?>/website_assets/webAssets/js/sticky-kit.min.js"></script>
    <script src="<?= $root_url; ?>/website_assets/webAssets/js/specific_detail.js"></script>
    
<script>
    
    $(function(){
        
        $(window).on("scroll",function(){
            if($('.secondary_nav').hasClass('is_stuck')==true){
                $('.bg_gray').addClass('nav-sticky');
            }else{
                $('.bg_gray').removeClass('nav-sticky');
            }
        })
    
        $('.reciepie_id').click(function(){
            
            var reciepie_id = $(this).data("reciepie_id");
            
            var fd = new FormData();
            fd.append('reciepie_id',reciepie_id);
                $.ajax({
                    url:"<?= $root_url; ?>/ajaxActions.php",
                    type: "POST",
                    data: fd,
                    contentType: false,
                    processData: false,
                    dataType: "JSON",
                    success: function(jsonStr) {
                      var res_data = JSON.stringify(jsonStr);
                      var responseArr = JSON.parse(res_data);
                      var reciepie_data = responseArr.reciepie_data;
                      var addons_data = responseArr.addons_data;
                      var addons_option_data = responseArr.addonMenuOptions_data;
                      
                      console.log(res_data);
                      
                    //   if(response!==''){
                          
                          $('.item_title').text(reciepie_data.name);
                          var html='';
                            html1='<input type="hidden" id="recipe_id_add_to_cart" value="'+reciepie_data.id+'">';
							$('#show_recipe_id').html(html1);
                          if(addons_data[0].addon_name!==''){
                              
                            $('.addons_div').show();
                            
                            // $.each(addons_data,function(key, value){
                             
                            //  console.log(value);
                            // $('.extra_ingredients').html('');
                            // $('.extra_ingredients').append('<h5>'+value.addon_name+'</h5><ul class="clearfix extra_ingredients"><li><label class="container_check">Extra Tomato<span>+ $4.30</span><input type="checkbox"><span class="checkmark"></span></label></li></ul>');
                                
                            // });
                            //alert(addons_option_data.length);
                            
                            for(var i=0;i<addons_data.length;i++){
                                //alert(addons_data[i].addon_name);
                                html+='<h5>'+addons_data[i].addon_name+'</h5>';
                                for(var j=0;j<addons_option_data.length;j++){
                                    if(addons_data[i].id ==addons_option_data[j].addon_menu_id){
                                        html+='<ul class="clearfix extra_ingredients"><li><label class="container_check">'+addons_option_data[j].option_name+'<span class="option_data_price">+ '+$('#currency_symbol').val()+addons_option_data[j].price+'</span><input class="options"  type="checkbox" name="option" data-option_price='+addons_option_data[j].price+' value="'+addons_option_data[j].id+'"><span class="checkmark"></span></label></li></ul>';
                                    }
                                }
                                
                            }
                            
                            $('.extra_ingredients').html(html);

                            
                            
                              
                          }
                          
                          
                    //   }
                      
                      
                    //   console.log(response.name);
                    //   return;
                      
                    },
                });
            
        });        
        
    });
    
    
    $('#add_to_cart').click(function(){
        
        if($('#customer_id').val() == ''){
            alert('Please Login First');
            return false;
        }
       
       var optionsArray = [];
       
       var total = 0;
       
        $("input:checkbox[name=option]:checked").each(function(){
            optionsArray.push($(this).val());
            
            total += parseInt($(this).data('option_price'));
        });
       $.ajax({
           
            url:"<?= $root_url; ?>/add_to_cart.php",
            type: "POST",
            data: {restaurant_id:$('#restaurant_id').val(),customer_id:$('#customer_id').val(),recipe_id:$('#recipe_id_add_to_cart').val(),qty:$('#qty').val(),optionsArray:optionsArray},
            dataType: "JSON",
            success: function(jsonStr) {
                
                if(jsonStr){
                    location.reload();
                }
            }
            
       });
       
    });
    
    $('#place_order').click(function(){
        if($('#customer_id').val() == ''){
            alert('Please Login First');
            return false;
        }
        
        if($('#sub_total').val() == ''){
            alert('Please add atleast one item in cart!');
            return false;
        }
        var options=[];
       /*$.ajax({
                    url:"<?= $root_url; ?>placeorder.php",
                    type: "POST",
                    data: {restaurant_id:$('#restaurant_id').val(),customer_id:$('#customer_id').val(),sub_total:$('#sub_total').val()},
                    dataType: "JSON",
                    success: function(jsonStr) {
                        
                        if(jsonStr){
                            alert('Order placed successfully');
                            location.reload();
                        }
                    }
       });*/
	   
	   window.location.href="<?= $root_url; ?>order.php?restaurant_id="+$('#restaurant_id').val()+"&customer_id="+$('#customer_id').val();
    });
    
    $(document).ready(function(){
        
       $.ajax({
           
            url:"<?= $root_url; ?>/get_cart_items.php",
            type: "POST",
            data: {restaurant_id:$('#restaurant_id').val(),customer_id:$('#customer_id').val()},
            dataType: "JSON",
            success: function(jsonStr) {
                var sub_total=0;
                var delovery_fee=0;
                html='<ul class="clearfix">';
                if(jsonStr.length>0){
                    $('#place_order').show();
                }else{
                   $('#place_order').hide(); 
                }
                for(var i=0;i<jsonStr.length;i++){
								html+='<li><a href="#0" data-id="'+jsonStr[i].cart_id+'" class="remove_cart_item"></a>'+jsonStr[i].name+'<span>'+$('#currency_symbol').val()+jsonStr[i].price+'</span></li>';
								html+='<input type="hidden" name="order_recipe_id[]" value="'+jsonStr[i].id+'"><input type="hidden" name="order_recipe_price[]" value="'+jsonStr[i].price+'"><input type="hidden" name="order_recipe_qty[]" value="'+jsonStr[i].qty+'">'
								sub_total = parseInt(sub_total)+(parseInt(jsonStr[i].price)*parseInt(jsonStr[i].qty));
                }
							html+='</ul>\
							<ul class="clearfix">\
								<li>Subtotal<span>'+$('#currency_symbol').val()+sub_total+'<input type="hidden" id="sub_total" value="'+sub_total+'"></span></li>\
								<li class="total">Total<span>'+$('#currency_symbol').val()+sub_total+'<input type="hidden" id="net_total" value="'+sub_total+'"></span></li>\
							</ul>';
					$('#order_summary').html(html);		
				
            }
       });
       
       
       $('body').on('click','.remove_cart_item',function(){
           $.ajax({
                    url:"<?= $root_url; ?>remove_cart_item.php",
                    type: "POST",
                    data: {cart_id:$(this).attr('data-id')},
                    dataType: "JSON",
                    success: function(jsonStr) {
                        
                        if(jsonStr){
                            alert('Cart Item Remove Successfully');
                            location.reload();
                        }
                    }
       });
       });
       

       <!--close model on click-->
       
        $('.cancel_btn').click(function(){
        
            $('.mfp-close').trigger('click');
        
        });
       
       
    });
    


//sticky slider for header menu items
// $('.carousel').on('init afterChange', function(event, slick, currentSlide){
//   let total = $('.carousel .item').length;
//   let start = $('.carousel .slick-active:first .item:first').html();
//   let end = $('.carousel .slick-active:last .item:last').html();
  
//   $('.results').html(`Showing ${start} to ${end} of ${total} results`)
// })

// $('.carousel').slick({
//   rows: 1,
//   slidesToShow: 8,
//   slidesToScroll: 2,
//   autoplay: false,
//   arrows: true,
//   infinite: false,
//   draggable: false,
//      responsive: [
//     {
//       breakpoint: 1024,
//       settings: {
//         slidesToShow: 5,
//         slidesToScroll: 2
//       }
//     },
//     {
//       breakpoint: 600,
//       settings: {
//         slidesToShow: 3,
//         slidesToScroll: 2
//       }
//     },
//     {
//       breakpoint: 480,
//       settings: {
//         slidesToShow: 2,
//         slidesToScroll: 1
//       }
//     }
//     ],
//   prevArrow: $('.prev'),
//   nextArrow: $('.next')

// })


$('.center').slick({
  slidesToShow: 10,
  slidesToScroll: 10,
  arrows: true,
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        arrows: false,
        centerPadding: '40px',
        slidesToShow: 6,
        slidesToScroll: 6,
        arrows: true
      }
    },
    {
      breakpoint: 768,
      settings: {
        arrows: true,
        centerPadding: '40px',
        slidesToShow: 3
      }
    },
    {
      breakpoint: 480,
      settings: {
        arrows: true,
        centerPadding: '40px',
        slidesToShow: 1
      }
    }
  ]
});
    
    
</script> 