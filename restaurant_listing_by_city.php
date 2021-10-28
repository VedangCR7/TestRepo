<?php
    error_reporting(0);	
	include "connection.php";
	$city = $_REQUEST['city'];
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
    <title>Foodnai | Find restaurants</title>
    <!-- Bootstrap -->
	<?php include "header.php"; ?>
    <div class="tp-page-head">
        <!-- page header -->
        <div class="container">
            <div class="row">
                <div class="col-md-offset-2 col-md-8">
                    <div class="page-header text-center">
                        <div class="icon-circle"> <i class="icon icon-size-60 icon-loving-home icon-white"></i> </div>
                        <h1>Foodnai Restaurants</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--<div class="tp-page-head">
        <div class="container">
            <div class="row">
                <div class="col-md-offset-2 col-md-8">
                    <div class="page-header text-center">
                        <div class="icon-circle">
                            <i class="icon icon-size-60 icon-menu icon-white"></i>
                        </div>
                        <h1>4 Column Listing</h1>
                        <p>Listing alos come with 4 column.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>-->
    <!--<div class="row">
		<div class="col-md-12">
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane fade in active" id="photo" style="background: black;">
					<div id="sync2" class="owl-carousel">
						<?php
							$offer = "SELECT * FROM `admin_offer` WHERE `status`= 1 AND `offer_image` != ''";
							$offerResult = mysqli_query($conn, $offer);
							$offerCnt = mysqli_num_rows($offerResult);
							if($offerCnt > 0) {
								while($offerRow = mysqli_fetch_assoc($offerResult))
								{
									$offerPhoto = $offerRow['offer_image'];
						?>
						<div class="item"> <img src="<?=$offerPhoto?>" alt="" class="img-responsive"> </div>
						
						<?php } } ?>
					</div>
				</div>
			</div>
		</div>
	</div>-->
	
	<?php
		$showRecordPerPage = 8;
		if(isset($_GET['page']) && !empty($_GET['page'])){
			$currentPage = $_GET['page'];
		}else{
			$currentPage = 1;
		}
		$startFrom = ($currentPage * $showRecordPerPage) - $showRecordPerPage;
		if($city != '') 
			$totalvenSQL = "SELECT * FROM user WHERE is_active = '1' AND usertype='Restaurant' AND city like '%$city%'";
		else
			$totalvenSQL = "SELECT * FROM user WHERE is_active = '1' AND usertype='Restaurant'";
		
            $allvenResult = mysqli_query($conn, $totalvenSQL);
		$totalvendor = mysqli_num_rows($allvenResult);
		$lastPage = ceil($totalvendor/$showRecordPerPage);
		$firstPage = 1;
		$nextPage = $currentPage + 1;
		$previousPage = $currentPage - 1; 
	?>
	
    <div class="main-container" style="padding-top: 7px;">
        <div class="container">
			<div class="row">
                <div class="col-md-3 logo">
                    <div class="navbar-brand">
                        <h4><b><?=$totalvendor?> Restaurants in <?=$city?> </b></h4>
                    </div>
                </div>
                <!--<div class="col-md-9">
                    <div class="navigation" id="navigation">
                        <ul>
                            <li class="active"><a href="login()" target="_blank">Distance</a></li>
                            <li class="active"><a href="index.html" target="_blank">Delivery Time</a></li>
                            <li class="active"><a href="index.html" target="_blank">Rating</a></li>
                            <li class="active"><a href="index.html" target="_blank">Filters</a></li>
                        </ul>
                    </div>
                </div>-->
            </div>
			<hr style="margin-top:0px!important;">
            <div class="row">
			
			
				<?php
					if($city != '')
						$sql = "SELECT * FROM user WHERE is_active = '1' AND usertype='Restaurant' AND city like '%$city%' AND id NOT IN(53,85,101,153,154) LIMIT $startFrom, $showRecordPerPage";
					else
						$sql = "SELECT * FROM user WHERE is_active = '1' AND usertype='Restaurant' AND id NOT IN(53,85,101,153,154) LIMIT $startFrom, $showRecordPerPage";
					
					$get_vendor_query=mysqli_query($conn,$sql);
					
                    $count_get_vendor_query=mysqli_num_rows($get_vendor_query);
                    if($count_get_vendor_query > 0)
                    {
						while($row_get_vendor_query = mysqli_fetch_assoc($get_vendor_query))
						{
							$vendorId = $row_get_vendor_query['id'];
							$vendorEmail = $row_get_vendor_query['email'];
							$vendorPhoto = $row_get_vendor_query['profile_photo'];
							$vendoraddress = stripslashes($row_get_vendor_query['address']);
							$businessName = stripslashes(ucwords($row_get_vendor_query['business_name']));
							$vendorName = $row_get_vendor_query['name'];
							$vendorCity = $row_get_vendor_query['city'];
                            if($vendorCity != '')
                                $fulladdress = $vendorCity ;
                            else
                                $fulladdress = '';
				?>
			
			
                <div class="col-md-3 vendor-box">
                    <div class="vendor-image" style="border: 1px solid #e9e6e0;">
                        <a href="restaurant_page.php?restaurant_id=<?=$vendorId?>">
							<?php if($vendorPhoto == 'assets/images/users/user.png'){ ?>
							<img src="<?='https://d24h2kiavvgpl8.cloudfront.net/profile/default_restaurant.png'?>" alt="wedding venue" class="img-responsive" style="height: 147px; width: 263px;">
							<?php }else { ?>
							<img src="<?=$vendorPhoto?>" alt="wedding venue" class="img-responsive" style="height: 147px; width: 263px;">
							<?php } ?>
						</a>
                    </div>
                    <div class="vendor-detail" style="min-height:160px!important;">
                        <div class="caption" style="padding: 11px;">
                            <h2><a href="restaurant_page.php?restaurant_id=<?=$vendorId?>" class="title"><?=$businessName?></a></h2>
                            <p class="location" style="margin-bottom: 0px!important;">
                                <?php if(($fulladdress != '') || ($vendoraddress !='')){ ?>
                                <i class="fa fa-map-marker"></i> 
                                <?php echo ucwords(strtolower($vendoraddress)); ?><br>
                                <?php echo ucwords(strtolower($fulladdress)); ?>
                                <?php } ?>
                            </p>
                        </div>
                    </div>
                </div>
				
				<?php } }else {echo "<h3 style='color:red;'><center>Restaurant not found.</center></h3>";} ?>
                
            </div>
            <div class="row">
                <div class="col-md-12 tp-pagination">
                <ul class="pagination">
                    <li>
                        <a href="#" aria-label="Previous"> <span aria-hidden="true">Previous</span> </a>
                    </li>
                    <?php if($currentPage != $firstPage) { ?>
					<li class="page-item">
					  <a class="page-link" href="?page=<?php echo $firstPage ?>" tabindex="-1" aria-label="Previous">
						<span aria-hidden="true">First</span>           
					  </a>
					</li>
					<?php } ?>
					<?php if($currentPage >= 2) { ?>
						<li class="page-item"><a class="page-link" href="?page=<?php echo $previousPage ?>"><?php echo $previousPage ?></a></li>
					<?php } ?>
					<li class="page-item active"><a class="page-link" href="?page=<?php echo $currentPage ?>"><?php echo $currentPage ?></a></li>
					<?php if($currentPage != $lastPage) { ?>
						<li class="page-item"><a class="page-link" href="?page=<?php echo $nextPage ?>"><?php echo $nextPage ?></a></li>
						<li class="page-item">
						  <a class="page-link" href="?page=<?php echo $lastPage ?>" aria-label="Next">
							<span aria-hidden="true">Last</span>
						  </a>
						</li>
					<?php } ?>
								
					</ul>
				</div>
            </div>
        </div>
    </div>
    
    <?php include "footer.php"; ?>

    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
    <script type="text/javascript" src="website_assets/js/price-slider.js"></script>
	
	
    <script type="text/javascript" src="website_assets/js/thumbnail-slider.js"></script>
    <script src="http://maps.googleapis.com/maps/api/js"></script>

    <script>
    $(document).ready(function(){
      $('.pincode').click(function(){
        $('.pincode').val('');
        $('#send_post_code').val('');
      });
      $(".restaurant_id").click(function(){
        $('.restaurant_id').val('');
        $('#send_restaurant_id').val('');
      });
      $('.submit_search').click(function(){
        if($('#send_post_code').val() !='' && $('#send_restaurant_id').val() ==''){
          window.location.href ='restaurant_listing.php?pin_code='+$('#send_post_code').val();
        }
        if($('#send_post_code').val() =='' && $('#send_restaurant_id').val() !=''){
          window.location.href ='restaurant_page.php?restaurant_id='+$('#send_restaurant_id').val();
        }
        if($('#send_post_code').val() !='' && $('#send_restaurant_id').val() !=''){
          window.location.href ='restaurant_page.php?restaurant_id='+$('#send_restaurant_id').val()+'&pin_code='+$('#send_post_code').val();
        }
      });

      $('.pincode').keyup(function(){
        var $inputaddress = $(".pincode");
        var search_content = $inputaddress.val();
        if(search_content.length > 2){
          $.get("getaddress.php?search="+search_content, function(data){
          $inputaddress.typeahead({
                source:data,autoSelect: true,
                afterSelect:function(item){
                    console.log(item.id);
                    $('#send_post_code').val(item.id);
                }
            });
        },'json');
      }
      })
      var $input = $(".restaurant_id");
        $.get("getrestaurants.php", function(data){
          $input.typeahead({
                source:data,autoSelect: true,
                afterSelect:function(item){
                    console.log(item.id);
                    $('#send_restaurant_id').val(item.id);
                }
            });
        },'json');
    });
    </script>
</body>

</html>