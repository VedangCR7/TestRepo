<?php
	error_reporting(0);
	
	include "connection.php";
	$restaurant_id = $_REQUEST['restaurant_id'];
	if($restaurant_id!=''){
		$restaurant_id = str_replace("-"," ",$restaurant_id);
	}
	
	// $request_restaurant_id = $_REQUEST['restaurant_id'];
	// $sqlRName = "SELECT * FROM user WHERE business_name = '$request_restaurant_id'";
	// $get_rname_query=mysqli_query($conn,$sqlRName);
	// $count_get_rname_query=mysqli_num_rows($get_rname_query);
	// if($count_get_rname_query > 0){
    // 	$row_get_rname_query = mysqli_fetch_assoc($get_rname_query);	
	// 	$restaurant_id = $_REQUEST['restaurant_id'];
	// }
    $pincode = $_REQUEST['pin_code'];
?>
  
<!DOCTYPE html>
<html lang="en">
	<head>
		<script async src="https://www.googletagmanager.com/gtag/js?id=G-8ZJNB18KS2"></script>
		<script>
			window.dataLayer = window.dataLayer || [];
			function gtag(){dataLayer.push(arguments);}
			gtag('js', new Date());
			gtag('config', 'G-8ZJNB18KS2');
		</script>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<title>YouCloud | Find restaurants</title>
		<!-- Bootstrap -->
		<link rel="canonical" href="https://www.foodnai.com/">

		<style>
			.inactiveLink {
			pointer-events: none!important;
			cursor: not-allowed!important;
			}
		</style>
		<style>
			@media only screen and (max-width: 320px) 
			{
				.pad2 
				{
					padding-left: 15px!important;
					padding-top: 15px!important;
				}
				
				.pad3 
				{
					padding-left: 15px!important;
					padding-top: 15px!important;
				}
				
				.pad4 
				{
					padding-left: 15px!important;
				}
				
				.pad5 
				{
					padding-left: 15px!important;
				}				
			}
			
			@media only screen and (max-width: 375px) 
			{
				.pad2 
				{
					padding-left: 15px!important;
					padding-top: 15px!important;
				}
				
				.pad3 
				{
					padding-left: 15px!important;
					padding-top: 15px!important;
				}
				
				.pad4 
				{
					padding-left: 15px!important;
				}
				
				.pad5 
				{
					padding-left: 15px!important;
				}				
			}
		</style>
		<?php include "header.php"; ?>
		<?php
        $sql1 = "SELECT * FROM user WHERE business_name like '%$restaurant_id'";
		$get_vendor_query1=mysqli_query($conn,$sql1);
        $count_get_vendor_query1=mysqli_num_rows($get_vendor_query1);
        
		if($count_get_vendor_query1 > 0)
        {
            $row_get_vendor_query1 = mysqli_fetch_assoc($get_vendor_query1);
            $img1 = $row_get_vendor_query1['rest_img_1'];
			$img2 = $row_get_vendor_query1['rest_img_2'];
			$img3 = $row_get_vendor_query1['rest_img_3'];
			$img4 = $row_get_vendor_query1['rest_img_4'];
			$img5 = $row_get_vendor_query1['rest_img_5'];
			$restaurantId = $row_get_vendor_query1['id'];			
			$retoencodestr = base64_encode($restaurantId);
			
			if($img1 !='' || $img2 !='' || $img3 !='' || $img4 !='' || $img5 !='')
			{
			?>			
			<div class="row" style="padding:10px;box-shadow: 3px 3px 3px 3px gray;">
				<div class="col-md-8">
					<?php 
					if($img1 !='')
					{
					?>
					<img src="<?=$img1?>" alt="" class="img-responsive" style="width: 100%;height: 300px;" onclick='view_image(this.src);'>
					<?php 
					}
					else
					{
					?>
					<img src="<?php echo $root_url;?>/assets/images/users/white-gray.jpg" alt="" class="img-responsive" style="width: 100%;height: 300px;" onclick='view_image(this.src);'>
					<?php 
					}
					?>					
				</div>
				<div class="col-md-4">
					<div class="row">
						<div class="col-md-12" style="padding: 0px;">
							<div class="col-md-6 pad2" style="padding-left: 0px;">
								<?php 
								if($img2 !='')
								{
								?>
								<img src="<?=$img2?>" alt="" class="img-responsive" style="width: 100%;height: 140px;" onclick='view_image(this.src);'>
								<?php 
								}
								else
								{
								?>
								<img src="<?php echo $root_url;?>/assets/images/users/white-gray.jpg" alt="" class="img-responsive" style="width: 100%;height: 140px;" onclick='view_image(this.src);'>
								<?php 
								}
								?>
							</div>	
							<div class="col-md-6 pad3" style="padding-left: 0px;">
								<?php 
								if($img3 !='')
								{
								?>
								<img src="<?=$img3?>" alt="" class="img-responsive" style="width: 100%;height: 140px;" onclick='view_image(this.src);'>
								<?php 
								}
								else
								{
								?>
								<img src="<?php echo $root_url;?>/assets/images/users/white-gray.jpg" alt="" class="img-responsive" style="width: 100%;height: 140px;" onclick='view_image(this.src);'>
								<?php 
								}
								?>								
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12" style="padding: 0px;">
							<div class="col-md-6 pad4" style="padding-top: 15px;padding-left: 0px;">
								<?php 
								if($img4 !='')
								{
								?>
								<img src="<?=$img4?>" alt="" class="img-responsive" style="width: 100%;height: 145px;" onclick='view_image(this.src);'>
								<?php 
								}
								else
								{
								?>
								<img src="<?php echo $root_url;?>/assets/images/users/white-gray.jpg" alt="" class="img-responsive" style="width: 100%;height: 145px;" onclick='view_image(this.src);'>
								<?php 
								}
								?>								
							</div>	
							<div class="col-md-6 pad5" style="padding-top: 15px;padding-left: 0px;">
								<?php 
								if($img5 !='')
								{
								?>
								<img src="<?=$img5?>" alt="" class="img-responsive" style="width: 100%;height: 145px;" onclick='view_image(this.src);'>
								<?php 
								}
								else
								{
								?>
								<img src="<?php echo $root_url;?>/assets/images/users/white-gray.jpg" alt="" class="img-responsive" style="width: 100%;height: 145px;" onclick='view_image(this.src);'>
								<?php 
								}
								?>								
							</div>	
						</div>	
					</div>	
				</div>	
			</div>	
			<?php
			/* else if($img1 !='')
			{
			?>
			<div class="tp-page-head" style="background:url(<?=$img1?>); background-repeat: no-repeat; background-size: 100%;">
				<div class="container">
					<div class="row">
						<div class="col-md-offset-2 col-md-8">
							<div class="page-header text-center">
								
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php  
			} 
			else if($img2 !='') 
			{
			?>
			<div class="tp-page-head" style="background:url(<?=$img2?>); background-repeat: no-repeat; background-size: 100%;">
				<div class="container">
					<div class="row">
						<div class="col-md-offset-2 col-md-8">
							<div class="page-header text-center">
								
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php  
			} 
			else if($img3 !='') 
			{	?>
			<div class="tp-page-head" style="background:url(<?=$img3?>); height: 300px; background-repeat: no-repeat; background-size: 100% 300px;">
				<div class="container">
					<div class="row">
						<div class="col-md-offset-2 col-md-8">
							<div class="page-header text-center">
								
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php  
			} 
			else if($img4 !='') 
			{
			?>
			<div class="tp-page-head" style="background:url(<?=$img4?>); height: 300px; background-repeat: no-repeat; background-size: 100% 300px;">
				<div class="container">
					<div class="row">
						<div class="col-md-offset-2 col-md-8">
							<div class="page-header text-center">
								
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php  
			}
			else if($img5 !='') 
			{
			?>
			<div class="tp-page-head" style="background:url(<?=$img5?>); height: 300px; background-repeat: no-repeat; background-size: 100% 300px;">
				<div class="container">
					<div class="row">
						<div class="col-md-offset-2 col-md-8">
							<div class="page-header text-center">
								
							</div>
						</div>
					</div>
				</div>
			</div>*/
			}
			else 
			{
			?>
			<div class="tp-page-head" style="background:url(<?php echo $root_url;?>/website_assets/images/masala_dosa.jpg); height: 300px; background-repeat: no-repeat; background-size: 100% 300px;">
				<div class="container">
					<div class="row">
						<div class="col-md-offset-2 col-md-8">
							<div class="page-header text-center">
								
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php 
			}
		}
		else
		{
		?>
        <!-- page header -->
		<div class="tp-page-head" style="background:url(<?php echo $root_url;?>/website_assets/images/masala_dosa.jpg); height: 300px; background-repeat: no-repeat; background-size: 100% 300px;">
			<div class="container">
				<div class="row">
					<div class="col-md-offset-2 col-md-8">
						<div class="page-header text-center">
							
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
		}
		?>
    <div class="main-container">
        <div class="container tabbed-page st-tabs">
            <div class="row tab-page-header">
				<?php
					if(($pincode !='') && ($restaurant_id != ''))
					{
						$sql = "SELECT * FROM user WHERE business_name like '%$restaurant_id' AND postcode='$pincode'";
					}
					else if(($pincode =='') && ($restaurant_id != ''))
					{
						$sql = "SELECT * FROM user WHERE business_name  like '%$restaurant_id'";
					}
					
					$get_vendor_query=mysqli_query($conn,$sql);					
                    $count_get_vendor_query=mysqli_num_rows($get_vendor_query);
                    
					if($count_get_vendor_query > 0)
                    {
						$row_get_vendor_query = mysqli_fetch_assoc($get_vendor_query);
						
						$vendorId = $row_get_vendor_query['id'];
						$vendorEmail = $row_get_vendor_query['email'];
						$vendorPhoto = $row_get_vendor_query['profile_photo'];
						$vendoraddress = $row_get_vendor_query['address'];
                        $contact_number = $row_get_vendor_query['contact_number'];
						$businessName = stripslashes($row_get_vendor_query['business_name']);
						$about_restaurant = stripslashes($row_get_vendor_query['about_restaurant']);
						$vendorName = $row_get_vendor_query['name'];
						$vendorCity = $row_get_vendor_query['city'];
						$postcode = $row_get_vendor_query['postcode'];
						$rest_img_1 = $row_get_vendor_query['rest_img_1'];
						$rest_img_2 = $row_get_vendor_query['rest_img_2'];
						$rest_img_3 = $row_get_vendor_query['rest_img_3'];
						$rest_img_4 = $row_get_vendor_query['rest_img_4'];
						$rest_img_5 = $row_get_vendor_query['rest_img_5'];
                 ?>
                <div class="col-md-8 title"> 
                    <h1><?=$businessName?></h1>
                    <?php if(($vendoraddress != '') || ($vendorCity != '') || ($postcode != '')){ ?>
                        <p class="location"><i class="fa fa-map-marker"></i>
                            <?php if(($vendoraddress != '') && ($vendorCity != '') && ($postcode != '')){ 
                                    $fulladdrs = $vendoraddress.", ".$vendorCity.", ".$postcode;
                                    echo ucwords(strtolower($fulladdrs));
                                }
                                else if(($vendoraddress == '') && ($vendorCity != '') && ($postcode != '')){
                                    $fulladdrs = $vendorCity.", ".$postcode;
                                    echo ucwords(strtolower($fulladdrs));
                                }
                                else if(($vendoraddress == '') && ($vendorCity == '') && ($postcode != '')){
                                    echo $fulladdrs = $postcode;}
                                else if(($vendoraddress == '') && ($vendorCity != '') && ($postcode == '')){
                                    $fulladdrs = $vendorCity;
                                    echo ucwords(strtolower($fulladdrs));
                                }
                                else if(($vendoraddress != '') && ($vendorCity == '') && ($postcode != '')){
                                    $fulladdrs = $vendoraddress.", ".$postcode;
                                    echo ucwords(strtolower($fulladdrs));
                                }
                                else if(($vendoraddress != '') && ($vendorCity != '') && ($postcode == '')){
                                    $fulladdrs = $vendoraddress.", ".$vendorCity;
                                    echo ucwords(strtolower($fulladdrs));
                                }
                            ?>
                        </p>
                    <?php } ?>
					<a href="#" class="label-danger" disabled><i class="fa fa-star"></i> Add Review</a>
					<a target="_blank" href="https://www.google.co.in/maps/search/<?php echo urlencode($vendoraddress.", ".$vendorCity.", ".$postcode); ?>" class="label-default"><i class="fa fa-reply"></i> Direction</a>
					<!--<a href="#" class="label-default">Bookmark</a>
					<a href="#" class="label-default">Share</a>-->
					<?php
					$check_website_table = mysqli_query($conn,"SELECT id FROM table_details WHERE logged_user_id=".$restaurantId." AND title='Website'");
					$row1 = mysqli_fetch_assoc($check_website_table);
					if(empty($row1)){
						$sql10 = "INSERT INTO table_category (title,logged_user_id,flag) VALUES ('Website',$restaurantId,1)";
						mysqli_query($conn, $sql10);
						$last_id = mysqli_insert_id($conn);
						$sql11 = "INSERT INTO table_details (title,logged_user_id,table_category_id) VALUES ('Website',$restaurantId,$last_id)";
						mysqli_query($conn, $sql11);
					}
						
					$website_tableid = mysqli_query($conn,"SELECT id FROM table_details WHERE logged_user_id=".$restaurantId." AND title='Website'");
					$row = mysqli_fetch_assoc($website_tableid);
					if(!empty($row)){
						$website_tableid= base64_encode($_SESSION['user_id'])."/".base64_encode($row['id']);}
					else{
						$website_tableid= '';
					}
					$menuexist = mysqli_query($conn,"SELECT * FROM menu_master WHERE restaurant_id=$restaurantId");
					$countsum = mysqli_num_rows($menuexist);
					
					if($countsum > 0)
					{
					?>
					<a href="<?=$base_url.'qrcode/'.$retoencodestr.'/'.$website_tableid.'/yes'?>" class="label-danger" target="_blank"><i class="fa fa-shopping-cart"></i> Order Now</a>
					<?php 
					}
					else
					{
					?>
					<a href="<?=$base_url.'qrcode/'.$retoencodestr?>" class="label-danger inactiveLink" target="_blank"><i class="fa fa-shopping-cart"></i> Order Now</a>
					<?php
					}
					?>
                    <hr>
					<h2>About this place</h2>
					<?php if(($about_restaurant == '') || ($about_restaurant == NULL)){ ?>
					Welcome to <?=$businessName.'...<br>'?>
					Our restaurant celebrates the finest cuisine, you will find the ambiance relaxed.Expect the best seasonal and local ingredients, handled with passion and creativity. Vegetables, herbs, fruits and flowers grown on finest Farm take center stage, along with the finest produce from the surrounding countryside. As we only use the freshest seasonal ingredients, menus are subject to change. Please mention any dietary requests when making the reservation so advance notice can be given to the kitchen. The food is delivered in a relaxed, comfortable and welcoming style, perfect for all year round and every occasion. We look forward to welcoming you soon.
					<?php } else { ?>
					<p><?=$about_restaurant?></p>
					<?php } ?>
					<?php
						if(($rest_img_1 != '') || ($rest_img_2 != '') || ($rest_img_3 != '') || ($rest_img_4 != '') || ($rest_img_5 != '')) {
					?>
					<div class="row">
						<div class="col-md-12">
							<!-- Nav tabs -->
							<div class="tab-content">
								<!-- tab content start-->
								<div role="tabpanel" class="tab-pane fade in active" id="photo">
                                    <?php 
                                        if(($rest_img_1 != '') && ($rest_img_2 != '') && ($rest_img_3 != '') && ($rest_img_4 != '') && ($rest_img_5 != '')){
                                    ?>
									<div id="sync2" class="owl-carousel">
                                    <?php }else{  ?>
                                    <div id="sync21" class="owl-carousel1">
                                    <?php } ?>
										<?php if($rest_img_1 != '') ?>
										<div class="item"> <img src="<?=$rest_img_1?>" alt="" class="img-responsive"> </div>
										<?php if($rest_img_2 != '') ?>
										<div class="item"> <img src="<?=$rest_img_2?>" alt="" class="img-responsive"> </div>
										<?php if($rest_img_3 != '') ?>
										<div class="item"> <img src="<?=$rest_img_3?>" alt="" class="img-responsive"> </div>
										<?php if($rest_img_4 != '') ?>
										<div class="item"> <img src="<?=$rest_img_4?>" alt="" class="img-responsive"> </div>
										<?php if($rest_img_5 != '') ?>
										<div class="item"> <img src="<?=$rest_img_5?>" alt="" class="img-responsive"> </div>
									</div>
								</div>
							</div>
							<!-- /.tab content start-->
						</div>
					</div>
					<?php } ?>
                </div>
                <div class="col-md-4 venue-data">
                    <div class="venue-info">
                        <!-- venue-info-->
                        <div class="capacity">
                            <div>
								<i class="fa fa-star" aria-hidden="true"></i>
								<i class="fa fa-star" aria-hidden="true"></i>
								<i class="fa fa-star" aria-hidden="true"></i>
								<i class="fa fa-star" aria-hidden="true"></i>
								<i class="fa fa-star-half-o" aria-hidden="true"></i>&nbsp;4.5<br>
								<small>824 Dining Reviews</small><br>
							</div>
						</div>
                        <div class="pricebox">
                            <div>
								<i class="fa fa-star" aria-hidden="true"></i>
								<i class="fa fa-star" aria-hidden="true"></i>
								<i class="fa fa-star" aria-hidden="true"></i>
								<i class="fa fa-star" aria-hidden="true"></i>
								<i class="fa fa-star" aria-hidden="true"></i>&nbsp;5<br>
								<small>67 Delivery Reviews</small><br> 
							</div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            Call<br><?=$contact_number?><br>
                            Direction<br>
                            <div id="map" class="map" height="45px" width="55px"></div>
                            <!--<br>-->
							<marquee><input type="text" id="copyTarget" value="<?php echo ($vendoraddress.", ".$vendorCity.", ".$postcode); ?>" style="border:none; width: 100%;"></marquee><br><br>
                            <button id="copyButton"><i class="fa fa-copy"></i> Copy</button> 
                            <a target="_blank" href="https://www.google.co.in/maps/search/<?php echo urlencode($vendoraddress.", ".$vendorCity.", ".$postcode); ?>" class="label-default"><i class="fa fa-reply"></i> Direction</a>
                        </div>
						<input type="hidden" id="lat" name="lat">
						<input type="hidden" id="lang" name="lang">
                    </div>
                     
				</div>
					<?php } else {echo "<h3 style='color:red;'><center>Restaurant not found.</center></h3>";} ?>
            </div>
        </div>
    </div>
    </div>
	<div id="anilightboxid" class="anilightbox" style="z-index: 99999;">
		<span class="close" id="close" onclick="close1();">&times;</span>
		<img class="anilightbox-content" id="img01">
	</div>    
    <?php include "footer.php"; ?>
	<!--<script src="http://maps.googleapis.com/maps/api/js"></script>-->
    
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
    <script type="text/javascript" src="<?php echo $root_url?>/website_assets/js/price-slider.js"></script>
    <script type="text/javascript" src="<?php echo $root_url?>/website_assets/js/thumbnail-slider.js"></script>
	<script>
		document.getElementById("copyButton").addEventListener("click", function() {
			copyToClipboard(document.getElementById("copyTarget"));
		});

		function copyToClipboard(elem) 
		{
			// create hidden text element, if it doesn't already exist
			var targetId = "_hiddenCopyText_";
			/* var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA"; */
			var isInput = document.getElementById("copyTarget");
			var origSelectionStart, origSelectionEnd;
			
			if (isInput) 
			{
				// can just use the original source element for the selection and copy
				target = elem;
				origSelectionStart = elem.selectionStart;
				origSelectionEnd = elem.selectionEnd;
			} 
			else 
			{
				// must use a temporary form element for the selection and copy
				target = document.getElementById(targetId);
				
				if (!target) 
				{
					var target = document.createElement("textarea");
					target.style.position = "absolute";
					target.style.left = "-9999px";
					target.style.top = "0";
					target.id = targetId;
					document.body.appendChild(target);
				}
				target.textContent = elem.textContent;
			}
			
			// select the content
			var currentFocus = document.activeElement;
			target.focus();
			target.setSelectionRange(0, target.value.length);

			// copy the selection
			var succeed;
			
			try 
			{
				succeed = document.execCommand("copy");
			} 
			catch(e) 
			{
				succeed = false;
			}
			
			// restore original focus
			
			if (currentFocus && typeof currentFocus.focus === "function") 
			{
				currentFocus.focus();
			}

			if (isInput) 
			{
				// restore prior selection
				elem.setSelectionRange(origSelectionStart, origSelectionEnd);
			} 
			else 
			{
				// clear temporary content
				target.textContent = "";
			}
			return succeed;
		}
	</script>
    <script>
		var geocoder = new google.maps.Geocoder();
		var address = '<?php echo $fulladdrs?>';
		var latitude;
		var longitude;

		geocoder.geocode( { 'address': address}, function(results, status) 
		{
			if (status == google.maps.GeocoderStatus.OK) 
			{
				latitude = results[0].geometry.location.lat();
				longitude = results[0].geometry.location.lng();
				console.log(latitude);
				
				$('#lat').val(latitude);
				$('#lang').val(longitude);				
			} 
		}); 
		
		var title='<?php echo $fulladdrs?>';		
		
		function initialize() 
		{
			latitude=$('#lat').val();
			longitude=$('#lang').val();
			console.log(latitude);
			
			var myCenter = new google.maps.LatLng(latitude, longitude);
		
			var mapProp = {
				center: myCenter,
				zoom: 11,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};
			
			
			
			var map = new google.maps.Map(document.getElementById("map"), mapProp);
									
			var marker = new google.maps.Marker({
				position: myCenter,
				title:title
			});
			marker.setMap(map);
		   /* marker.setMap(map);
			var infowindow = new google.maps.InfoWindow({
				content: "Hello Address"
			});*/
		}		
		google.maps.event.addDomListener(window, 'load', initialize);
    </script>
    <script>
		$(function() {
			$("#weddingdate").datepicker();
		});
    </script>
    <script>
		$(document).ready(function()
		{
			$('.pincode').click(function(){
				$('.pincode').val('');
				$('#send_post_code').val('');
			});
			
			$(".restaurant_id").click(function(){
				$('.restaurant_id').val('');
				$('#send_restaurant_id').val('');
			});
			
			$('.submit_search').click(function()
			{
				if($('#send_post_code').val() !='' && $('#send_restaurant_id').val() =='')
				{
					window.location.href ='restaurant_listing.php?pin_code='+$('#send_post_code').val();
				}
				
				if($('#send_post_code').val() =='' && $('#send_restaurant_id').val() !='')
				{
					window.location.href ='restaurant_page.php?restaurant_id='+$('#send_restaurant_id').val();
				}
				
				if($('#send_post_code').val() !='' && $('#send_restaurant_id').val() !='')
				{
					window.location.href ='restaurant_page.php?restaurant_id='+$('#send_restaurant_id').val()+'&pin_code='+$('#send_post_code').val();
				}
			});

			$('.pincode').keyup(function()
			{
				var $inputaddress = $(".pincode");
				var search_content = $inputaddress.val();
				
				if(search_content.length > 2)
				{
					$.get("getaddress.php?search="+search_content, function(data)
					{
						$inputaddress.typeahead({
							source:data,autoSelect: true,
							afterSelect:function(item)
							{
								console.log(item.id);
								$('#send_post_code').val(item.id);
							}
						});
					},'json');
				}
			})
			
			var $input = $(".restaurant_id");
			
			$.get("getrestaurants.php", function(data)
			{
				$input.typeahead({
					source:data,autoSelect: true,
					afterSelect:function(item)
					{
						console.log(item.id);
						$('#send_restaurant_id').val(item.id);
					}
				});
			},'json');
		});
    </script>
	<script>		
		function view_image(_src)
		{
			/* Get the modal */
			var modal = document.getElementById('anilightboxid');

			/* Get the image and insert it inside the modal - use its "alt" text as a caption */
			
			var modalImg = document.getElementById("img01");
			/* var captionText = document.getElementById("caption"); */

			
				modal.style.display = "block";
				modalImg.src = _src;
				/* captionText.innerHTML = this.alt; */
			
		}

		function close1()
		{
			$('#anilightboxid').hide();
			var modal = document.getElementById('anilightboxid');
			var span = document.getElementsById("close");
			document.getElementById('anilightboxid').style.display = "none";
		}
	</script>
</body>
</html>