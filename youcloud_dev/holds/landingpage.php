<?php //$conn = mysqli_connect('localhost','root','','foodnai_dev');
include "connection.php";
$q=mysqli_query($conn,"SELECT * from user where usertype='Restaurant' ORDER BY id DESC limit 8");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset='utf-8'>
  <meta http-equiv='X-UA-Compatible' content='IE=edge'>
  <title>FoodNAI</title>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  
<meta name="description" content="Zero Touch Menu
Zero Touch Menu Card– Digital QR Menu Card
Zero Touch Menu help Restaurants to ceate digital QR Menu card. Zero touch menu card useful for Restaurants,Hotels, Resorts,food outlets etc.
Try Zero touch menu card for 1 month free, with no fee!">
<link rel="canonical" href="https://www.foodnai.com/">
<meta property="og:title" content="Digital Menu | Zero Touch Menu Card | Restaurant Digital Menu Generator">
<meta property="og:type" content="website">
<meta property="og:description" content="Zero Touch Menu
Zero Touch Menu Card– Digital QR Menu Card
Zero Touch Menu help Restaurants to ceate digital QR Menu card. Zero touch menu card useful for Restaurants,Hotels, Resorts,food outlets etc.
Try Zero touch menu card for 1 month free, with no fee!">
<meta property="og:url" content="https://www.foodnai.com/">
<meta property="og:site_name" content="https://www.foodnai.com/">
<meta content="Zero Touch Menu Card, QR Code Menu Card For Restaurant, Get QR Code for Restaurant, Digital Menu Card for Restaurant, Contact Less Menu Card For Restaurant" name="keyword">


<meta property="og:image" content="https://www.foodnai.com/assets/img/foodnai_shareimg2.jpg" />
<meta property="og:image:secure_url" itemprop="image" content="https://www.foodnai.com/assets/img/foodnai_shareimg2.jpg" />

<meta property="og:image:type" content="image/jpg" />  
<meta property="og:image:alt" content="Foodnai" />
    <!-- Bootstrap -->
    <link href="website_assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Template style.css -->
    <link rel="stylesheet" type="text/css" href="website_assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="website_assets/css/owl.carousel.css">
    <link rel="stylesheet" type="text/css" href="website_assets/css/owl.theme.css">
    <link rel="stylesheet" type="text/css" href="website_assets/css/owl.transitions.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <!-- Font used in template -->
    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700|Roboto:400,400italic,500,500italic,700,700italic,300italic,300' rel='stylesheet' type='text/css'>
    <!--font awesome icon -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- favicon icon -->
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
      ul li .active .dropdown-item{
        background-color:#0FA683;
      }
      .active {
        background-color :#0FA683!important;
      }

      .active:hover {
        background-color :#0FA683!important;
      }

.dropdown-menu>.active>a, .dropdown-menu>.active>a:focus, .dropdown-menu>.active>a:hover {
    color: #fff;
    text-decoration: none;
    background-color:#0FA683;
    outline: 0;
}
/* a{
        background-color :green!important;
      } */




    </style>
</head>

<body style="background-color:white;">
    <div class="collapse" id="searcharea">
        <!-- top search -->
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Search for...">
            <span class="input-group-btn">
              <button class="btn btn-primary" type="button">Search</button>
          </span>
        </div>
    </div>
    <!-- /.top search -->
    <div class="top-bar" style="background-color:#0FA683;">
        <div class="container">
            <div class="row">
                <div class="col-md-6 top-message">
                </div>
                <div class="col-md-6 top-links">
                    <ul class="listnone">
                        <li><a href="about_us.php"> About </a></li>
                        <li><a href="contact-us.php">Contact us</a></li>
                        <!-- <li><a href="signup-couple.html" class=" ">Live Demo</a></li>
                        <li><a href="admin">Login</a></li> -->
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="slider-bg">
        <!-- slider start-->
        <div id="slider" class="owl-carousel owl-theme slider">
            <div class="item"><img src="website_assets/images/sliderimg.jfif" alt="Wedding couple just married"></div>
            <div class="item"><img src="website_assets/images/sliderimg.jfif" alt="Wedding couple just married"></div>
            <div class="item"><img src="website_assets/images/sliderimg.jfif" alt="Wedding couple just married"></div>
        </div>
        <div class="find-section">
            <!-- Find search section-->
            <div class="container">
                <div class="row">
                    <div class="col-md-offset-1 col-md-10 finder-block">
                        <div class="finder-caption">
                            <h1>Find your Restauant</h1>
                        </div>
                        <div class="finderform">
                                <div class="row">
                                    <div class="form-group col-md-4">
                                    <input type="hidden" id="send_post_code">
                                    <input type="hidden" id="send_restaurant_id">
                                        <input type="text" class="form-control pincode typehead"  placeholder="Search by address/pincode" id="pincode" autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <input type="text" name="restaurant_id" class="form-control restaurant_id typeahead" data-provide="typeahead" placeholder="Search by restaurant" autocomplete="off" id="restaurant_id">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <button class="submit_search btn btn-default btn-lg btn-block">Find Restaurant</button>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.Find search section-->
    </div>
    <!-- slider end-->
    <div class="section">
      <div class="main-container">
        <div class="container">
            <div class="row">
              <div class="col-md-12 col-sm-12 col-md-12 col-12">
                <h3 style="font-weight:bold;">Newly listed restaurants in India</h3>
              </div>
            </div>
            <div class="row">
              <?php while ($row=mysqli_fetch_assoc($q)){ ?>
                <div class="col-md-3 vendor-box">
                    <!-- venue box start-->
                    <div class="vendor-image">
                        <!-- venue pic -->
                        <?php 
                        if($row['profile_photo'] == 'assets/images/users/user.png'){
                        $image_src= 'https://d24h2kiavvgpl8.cloudfront.net/profile/default_restaurant.png';}
                        else{
                          $image_src= $row['profile_photo'];
                        }?>
                        <a href="restaurant_page.php?restaurant_id=<?=$row['id']?>"><img src="<?=$image_src?>" alt="wedding venue" class="img-responsive" style="height: 147px; width: 263px;"></a>
                        
                    </div>
                    <!-- /.venue pic -->
                    <div class="vendor-detail" style="min-height:160px;">
                        <!-- venue details -->
                        <div style="padding:5px;">
                            <!-- caption -->
                            <h2><a href="restaurant_page.php?restaurant_id=<?=$row['id']?>" class="title"><?=$row['business_name']?></a></h2>
                            <p class="location"><i class="fa fa-map-marker"></i> <?=$row['address']?><br><?=$row['city']?></p>
                            </div>
                    </div>
                    <!-- venue details -->
                </div><?php } ?>
                
      <!-- venue details -->
  </div>
                
            </div>
        </div>
    </div>
    </div>

    <!-- <div class="section-space80 bg-light">
      <div class="container">
          <div class="row">
            <div class="col-md-6">

            </div>
              <div class="col-md-6">
                  <div class="section-title mb60">
                      <h1 style="font-weight:bold;font-size:40px">Get the FoodNAI App</h1>
                      <p style="font-size:22px;">We will send you a link, Open it on your phone to download the app</p>
                  </div>
                  <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                      <input type="radio" checked>&nbsp;Email &nbsp;&nbsp;
                      <input type="radio">&nbsp;Phone
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                      <input type="text" placeholder="Email" class="form-control">
                    </div>
                    <div class="col-lg-5 col-md-5 col-sm-5 col-5">
                      <button class="form-control btn btn-default">Share APP Link</button>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12" style="margin-top:20px;">
                      <p>Download app from</p>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-4" style="margin-top:10px;">
                      <img src="website_assets/images/button-app-store.png" style="height:50px;width:100%;">
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-4" style="margin-top:10px;">
                      <img src="website_assets/images/button-google-play.png" style="height:50px;width:100%;">
                    </div>
                  </div>
              </div>
          </div>
      </div>
  </div> -->
    <!-- /.Real Weddings -->
    <section class="module parallax parallax-2">
      <div style="background-color:rgba(0,0,0,0.5);background-size:100% 100%;height:400px;">
      <div class="container">
          <div class="row">
              <div class="col-md-offset-2 col-md-8 parallax-caption">
                  <h4 style="color: white;">Grow your restaurant Business</h4>
                  <h2>Add your restaurant now! It's FREE!</h2>
                  <a href="#" class="btn btn-default" style="margin-top:20px;background-color:white;color:black;line-height:50px;">Get Started <i class="fas fa-play-circle"></i></a> </div>
          </div>
      </div>
      </div>
  </section>
    <!-- /.top location -->
    <div class="section-space80">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
              <div class="section-title mb60 text-center">
                <h1 style="font-weight:bold;">Why FOODNAI ?</h1>
              </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6" style="margin-top:10px;">
              <div class="row">
                <div class="col-lg-1 col-md-1 col-sm-4 col-4">
                <i class="fa fa-comments-o" aria-hidden="true" style="color: #0EC89C;font-size:25px;"></i>
                </div>
                <div class="col-lg-11 col-md-11 col-sm-8 col-8">
                  <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                      <h4 style="font-weight:bold;">Wordwide Support</h4>
                      <p>FoodChow support is available wordwide . Contact our support team and we will connect you to an expert to get your issues resolved within 24 Business hours.</p>
                    </div>
                  </div>
                </div>
              </div>
          </div>
          <div class="col-md-6" style="margin-top:10px;">
            <div class="row">
              <div class="col-lg-1 col-md-1 col-sm-4 col-4">
              <i class="fa fa-television" aria-hidden="true" style="color: #0EC89C;font-size:25px;"></i>
              </div>
              <div class="col-lg-11 col-md-11 col-sm-8 col-8">
                <div class="row">
                  <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <h4 style="font-weight:bold;">Complete Online Solution</h4>
                    <p>Our Online Ordering Solution allows you to take orders through Your Own Website , Your Own Mobile App ,And through FoodChow website and Mobile App.</p>
                  </div>
                </div>
              </div>
            </div>
        </div>
        <div class="col-md-6" style="margin-top:10px;">
          <div class="row">
            <div class="col-lg-1 col-md-1 col-sm-4 col-4">
            <i class="fa fa-map" aria-hidden="true" style="color: #0EC89C;font-size:25px;"></i>
            </div>
            <div class="col-lg-11 col-md-11 col-sm-8 col-8">
              <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                  <h4 style="font-weight:bold;">Single & Multiple Outlets</h4>
                  <p>Do you have your restaurant in multiple locations? FoodChow Multi-outlet food ordering solution will help you manage all these outlets with super admin functionality.</p>
                </div>
              </div>
            </div>
          </div>
      </div>
      <div class="col-md-6" style="margin-top:10px;">
        <div class="row">
          <div class="col-lg-1 col-md-1 col-sm-4 col-4">
          <i class="fa fa-trophy" aria-hidden="true" style="color: #0EC89C;font-size:25px;"></i>
          </div>
          <div class="col-lg-11 col-md-11 col-sm-8 col-8">
            <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <h4 style="font-weight:bold;">Win Win Business Model</h4>
                <p>From Quick setup to instant Order Notifications,Dynamic Pricing, Instant Payment and Social Media Marketing , We have u covered.</p>
              </div>
            </div>
          </div>
        </div>
    </div>
        </div>
    </div>
    </div><br>
    <?php include "footer.php"; ?>
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
          // var data = [{"id":"128","name":"seafood platter","price":"570.00"},{"id":"130","name":"SKIMPURI KEBAB","price":"500.55"},{"id":"132","name":"MAHI TIKKA KALIMIRCH","price":"275.00"},{"id":"134","name":"PATHREELE PANEER TIKKI","price":"449.00"},{"id":"135","name":"MAKHAI MOTIYA SEEKH","price":"224"},{"id":"136","name":"COCKTAIL COTTAGE CHEESE","price":"249.00"},{"id":"138","name":"Mezze Platte","price":"280"},{"id":"139","name":"BABRI ALOO","price":"250"},{"id":"140","name":"Waldorf Salad","price":"210"},{"id":"141","name":"mashroom blue water (adr) ","price":"350"},{"id":"142","name":"HORIATIKI Salad","price":"225"},{"id":"143","name":"DRY COOKED CHILLIES BABY CORN","price":"335"},{"id":"144","name":"BABRIKA MASHROOM ","price":"320"},{"id":"145","name":"Risotto  verdure","price":"380"},{"id":"146","name":"WOK TOSSED CHILLY WITH FISH","price":"749.50"},{"id":"147","name":"Risotto ai Fruitti di Mare","price":"260"},{"id":"148","name":"WOK TOSSED CHILLY WITH PRAWNS","price":"450"},{"id":"149","name":"WOK TOSSED CHILLY WITH CHICKEN","price":"599.75"},{"id":"150","name":"WOK TOSSED CHILLY WITH CHEESE","price":"320"},{"id":"151","name":"MASHROOM MOTI","price":"350"},{"id":"152","name":"PRAWNS ON TOAST","price":"450"},{"id":"153","name":"PRAWNS KURKURE","price":"430"},{"id":"156","name":"mutter nest","price":"280"},{"id":"157","name":"cheese corn balls","price":"220"},{"id":"159","name":"TILL TANDOORI JHEENGA","price":"550"},{"id":"160","name":"Pink Lady Pastas","price":"210"},{"id":"161","name":"Bolognese","price":"280"},{"id":"164","name":"Pasta Alferdo","price":"220"},{"id":"166","name":"cheesy jalapeno","price":"350"},{"id":"168","name":"Chicken Arrabbiata","price":"340"},{"id":"169","name":"macho nacho salsa","price":"320"},{"id":"173","name":"Phad Thai","price":"260"},{"id":"174","name":"macho nacho salsa with chicken","price":"350"},{"id":"175","name":"BEETROOT GALAVAT","price":"160.00"},{"id":"176","name":"Wok Fried Noodles","price":"265"},{"id":"177","name":"Bhune Murgh Ke Pasande","price":"250"},{"id":"178","name":"Wok Fried Rice ","price":"270"},{"id":"179","name":"Paneer Keshri Pukttan","price":"360"},{"id":"180","name":"THAI SPICE SOUPS CHICKEN","price":"480"},{"id":"181","name":"Kundan Methi","price":"230"},{"id":"183","name":"Makhmali Saag Panner","price":"310"},{"id":"184","name":"Kofta Makhanwala","price":"210"},{"id":"185","name":"THAI SPICE SOUPS WITH PRAWNS","price":"380"},{"id":"186","name":"Sabz Nizami Handi","price":"460"},{"id":"187","name":"Bhindi Masaledar","price":"210"},{"id":"188","name":"Mushroom Mutter Hara Pyaaz","price":"320"},{"id":"189","name":"THAI SPICE SOUPS VEGETABLES","price":"210"},{"id":"191","name":"DEKHSHINE MURG TIKKA","price":"240"},{"id":"193","name":"PESHWARI TANDOORI MURGH","price":"320"},{"id":"194","name":"PAYA SHORBA","price":"420"},{"id":"195","name":"chiken shish taouk","price":"390"},{"id":"196","name":"TOM YUM WITH VEGETABLES","price":"230"},{"id":"197","name":"TOM YUM CHIKEN SOUPS","price":"310"},{"id":"198","name":"TOM YUP PRAWNS SOUPS","price":"340"},{"id":"199","name":"murgh yakhani shorba","price":"260"},{"id":"200","name":"Mushroom Cappuccino","price":"210"},{"id":"204","name":"WOK FRIED SEASONAL GREENS","price":"280"},{"id":"205","name":"GRILLED PRAWNS TARATUR","price":"380"},{"id":"206","name":"DOUBANJIANG STYLE PRAWNS","price":"380"},{"id":"207","name":"CHIKEN GONG BAO","price":"380"},{"id":"208","name":"THAI CURRY GREEN ","price":"370"},{"id":"209","name":"THAI CURRY CHIKEN","price":"355"},{"id":"210","name":"THAI CURRY FISH","price":"340"},{"id":"213","name":"thai curry prawns","price":"350"},{"id":"215","name":"KACCHE GHOST KI DUM BIRYANI","price":"380"},{"id":"216","name":"DUM MURGH BIRYANI","price":"290"},{"id":"217","name":"PORTUGUES PILAF","price":"350"},{"id":"218","name":"Hyderabadi Subz Dum Biryani","price":"320"},{"id":"219","name":"steame basmati rice","price":"100.00"},{"id":"221","name":"Caramel custard","price":"250"},{"id":"222","name":"TIRAMUSU","price":"230"},{"id":"223","name":"PREMIUM ICECREAM VANILA","price":"195"},{"id":"224","name":"PREMIUM ICECREAM STRAWBERRY","price":"230"},{"id":"225","name":"PREMIUM ICECREAM CHOCOLATE","price":"220"},{"id":"227","name":"PREMIUM ICECREAM COFFE","price":"210"},{"id":"230","name":"PREMIUM ICECREAM BUTTERSCOTCH","price":"180"},{"id":"233","name":"BADEL JAMUN","price":"90"},{"id":"234","name":"KESARI RASMALAI","price":"190"},{"id":"236","name":"KHUBANI KAA MEETHA","price":"210"},{"id":"237","name":"MOONG DAL HALWA","price":"120"},{"id":"239","name":"TANDOORI ROTI","price":"60"},{"id":"240","name":"NAAN","price":"110"},{"id":"241","name":"LACHHA PARATHA","price":"110"},{"id":"242","name":"STUFFED PARATHA","price":"130"},{"id":"243","name":"KULCHA","price":"99"},{"id":"244","name":"RUMALI ROTI","price":"50"},{"id":"1805","name":"O.G. Pizza","price":"150.00"},{"id":"1900","name":"Sriracha & Maple Fried Cauliflower Bites","price":"230"},{"id":"1901","name":"Friend Chicken Tenders","price":"380"},{"id":"2157","name":"Veg burger","price":"120.00"},{"id":"2637","name":"mushroom & black bean patty","price":"200.00"},{"id":"19603","name":"Idali","price":"25.00"},{"id":"19604","name":"Medu Vada","price":"30.00"},{"id":"2642","name":"Veg kabab ","price":"200.50"},{"id":"2643","name":"mushroom&black bean patty","price":"175.00"},{"id":"19600","name":"Shabu vada","price":"30.00"},{"id":"19601","name":"Plain dosa","price":"100.00"},{"id":"19602","name":"Utappa","price":"45.00"},{"id":"3573","name":"Stuffed paratha mix veg","price":"159"},{"id":"3574","name":"Veg Manchurian","price":"100"},{"id":"3575","name":"Veg Crispy","price":"40.00"},{"id":"4439","name":"Caribica","price":"300"},{"id":"19596","name":"Toast","price":"100.00"},{"id":"19597","name":"cheese tomato sandwich","price":"60.00"},{"id":"19598","name":"Poha","price":"15.00"},{"id":"19595","name":"Omlet sandwich","price":"50.00"},{"id":"4499","name":"Tomato onion sandwitch","price":"200"},{"id":"12605","name":"CHEESE PIZZA","price":"195"},{"id":"12607","name":"MINERAL WATER","price":"35"},{"id":"12608","name":"SODA","price":"30.00"},{"id":"12609","name":"SOFT DRINKS","price":"55"},{"id":"19558","name":"Brandy 180ml","price":"300.00"},{"id":"19555","name":"8 pm whisky 180ml","price":"200"},{"id":"14623","name":"palak paneer","price":"200.00"},{"id":"19446","name":"Paneer crispy Kabab ","price":"100.00"},{"id":"19554","name":"crown royal 125ml","price":"100"},{"id":"19553","name":"crown royal 180ml","price":"150"},{"id":"19551","name":"OLD MONK 60ml","price":"125"},{"id":"19552","name":"OLD MONK 90ml","price":"185"},{"id":"19550","name":"OLD MONK 30ml","price":"95"},{"id":"19667","name":"ROMONOV VODKA 90ml","price":"235.00"},{"id":"19430","name":"PANNER DOSA","price":"200.00"},{"id":"19456","name":"Platter","price":"1699.00"},{"id":"19461","name":"methi masala","price":"50.00"},{"id":"19666","name":"ROMONOV VODKA 60ml","price":"135.00"},{"id":"19611","name":"Hakka Noodles","price":"100.00"},{"id":"19549","name":"BIRA Pint","price":"145"},{"id":"19613","name":"Paneer Momos ","price":"100.00"},{"id":"19612","name":"Veg momos","price":"100.00"},{"id":"19548","name":"BIRA Glass","price":"110"},{"id":"19547","name":"KINGFISHER MILD Pint","price":"125"},{"id":"19524","name":"Fried Rice","price":"95.55"},{"id":"19528","name":"Mushroom pizza","price":"12.00"},{"id":"19546","name":"NGFISHER MILD Glass","price":"90"},{"id":"19565","name":"vergin mojito","price":"250.00"},{"id":"19568","name":"cream roll","price":"100.00"},{"id":"19572","name":"Sweet Dish","price":"100.00"},{"id":"19573","name":"Salad","price":"100.00"},{"id":"19582","name":"Papad","price":"123.00"},{"id":"19665","name":"ROMONOV VODKA 30ml","price":"95.00"},{"id":"19614","name":"Veg. Marinated Momos ","price":"100.00"},{"id":"19615","name":"Paneer Marinated Momos ","price":"100.00"},{"id":"19618","name":"Veg. Wonton ","price":"90.00"},{"id":"19619","name":"Non veg momos","price":"90.00"},{"id":"19620","name":"Hot Dry Noodles","price":"100.00"},{"id":"19621","name":"Manchurian Noodles ","price":"90.00"},{"id":"19622","name":"Singapore Noodles ","price":"150.00"},{"id":"19623","name":"Hong Kong Noodles ","price":"100.00"},{"id":"19625","name":"Red Bull ","price":"300.00"},{"id":"19626","name":"Tuborg","price":"160.00"},{"id":"19627","name":"Carlsberg","price":"300.00"},{"id":"19628","name":"Budweiser","price":"500.00"},{"id":"19629","name":"Heineken","price":"123.00"},{"id":"19630","name":"Bira","price":"250.00"},{"id":"19631","name":"Ardbeg 10 Year Old","price":"350.00"},{"id":"19633","name":"Johnnie Walker Gold Label Reserve","price":"1650.00"},{"id":"19634","name":"Vegitable fried Rice","price":"150.00"},{"id":"19635","name":"Ballantine's Finest Blended Scotch Whisky","price":"1400.00"},{"id":"19636","name":"chicken fried rice","price":"200.00"},{"id":"19637","name":"The Macallan Sherry Oak 12 Years","price":"2000.00"},{"id":"19638","name":"Thai Fried Rice","price":"190.00"},{"id":"19639","name":"Basil Fried Rice","price":"180.00"},{"id":"19640","name":"Glenlivet 12 Year Single Malt Scotch Whisky","price":"1256.00"},{"id":"19641","name":"Facundo","price":"450.00"},{"id":"19642","name":"Diplomatico","price":"750.00"},{"id":"19643","name":"Richland","price":"540.00"},{"id":"19644","name":"Mount Gay ","price":"350.00"},{"id":"19645","name":"Goslings ","price":"258.00"},{"id":"19646","name":"Don Papa","price":"890.00"},{"id":"19647","name":"Honey Bee","price":"550.00"},{"id":"19648","name":"Old Admiral.","price":"450.00"},{"id":"19649","name":"Remy Martin","price":"650.00"},{"id":"19651","name":"Mansion House","price":"1800.00"},{"id":"19652","name":"Dreher","price":"990.00"},{"id":"19653","name":"Hennessy","price":"775.00"},{"id":"19654","name":"Remy Martin","price":"2200.00"},{"id":"19655","name":"Full-Bodied Red Wines","price":"550.00"},{"id":"19656","name":"Medium-Bodied Red Wines (Merlot, Barbera)","price":"850.00"},{"id":"19657","name":"White Wine","price":"750.00"},{"id":"19658","name":"Dessert or Sweet Wine","price":"440.00"},{"id":"19659","name":"Sparkling Wine","price":"450.00"},{"id":"19660","name":"Fratelli Sette","price":"120.00"},{"id":"19661","name":"Myra Vineyards Misfit","price":"340.00"},{"id":"19668","name":"ABSOLUT 30ml","price":"95.00"},{"id":"19669","name":"ABSOLUT 60ml","price":"195.00"},{"id":"19670","name":"ABSOLUT FLAVOURS 180ml","price":"340.00"},{"id":"19671","name":"ABSOLUT FLAVOURS 90ml","price":"185.00"},{"id":"19672","name":"MAGIC MOMENTS 60ml","price":"245.00"},{"id":"19760","name":"Chinese","price":"150.00"},{"id":"19762","name":"Veg Maratha","price":"0.00"}]
          // console.log('data',data);  
          // console.log('data1',data1);
          $inputaddress.typeahead({
                source:data,autoSelect: true,
                afterSelect:function(item){
                    console.log(item.id);
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
      })
      var $input = $(".restaurant_id");
        $.get("getrestaurants.php", function(data){
          // var data = [{"id":"128","name":"seafood platter","price":"570.00"},{"id":"130","name":"SKIMPURI KEBAB","price":"500.55"},{"id":"132","name":"MAHI TIKKA KALIMIRCH","price":"275.00"},{"id":"134","name":"PATHREELE PANEER TIKKI","price":"449.00"},{"id":"135","name":"MAKHAI MOTIYA SEEKH","price":"224"},{"id":"136","name":"COCKTAIL COTTAGE CHEESE","price":"249.00"},{"id":"138","name":"Mezze Platte","price":"280"},{"id":"139","name":"BABRI ALOO","price":"250"},{"id":"140","name":"Waldorf Salad","price":"210"},{"id":"141","name":"mashroom blue water (adr) ","price":"350"},{"id":"142","name":"HORIATIKI Salad","price":"225"},{"id":"143","name":"DRY COOKED CHILLIES BABY CORN","price":"335"},{"id":"144","name":"BABRIKA MASHROOM ","price":"320"},{"id":"145","name":"Risotto  verdure","price":"380"},{"id":"146","name":"WOK TOSSED CHILLY WITH FISH","price":"749.50"},{"id":"147","name":"Risotto ai Fruitti di Mare","price":"260"},{"id":"148","name":"WOK TOSSED CHILLY WITH PRAWNS","price":"450"},{"id":"149","name":"WOK TOSSED CHILLY WITH CHICKEN","price":"599.75"},{"id":"150","name":"WOK TOSSED CHILLY WITH CHEESE","price":"320"},{"id":"151","name":"MASHROOM MOTI","price":"350"},{"id":"152","name":"PRAWNS ON TOAST","price":"450"},{"id":"153","name":"PRAWNS KURKURE","price":"430"},{"id":"156","name":"mutter nest","price":"280"},{"id":"157","name":"cheese corn balls","price":"220"},{"id":"159","name":"TILL TANDOORI JHEENGA","price":"550"},{"id":"160","name":"Pink Lady Pastas","price":"210"},{"id":"161","name":"Bolognese","price":"280"},{"id":"164","name":"Pasta Alferdo","price":"220"},{"id":"166","name":"cheesy jalapeno","price":"350"},{"id":"168","name":"Chicken Arrabbiata","price":"340"},{"id":"169","name":"macho nacho salsa","price":"320"},{"id":"173","name":"Phad Thai","price":"260"},{"id":"174","name":"macho nacho salsa with chicken","price":"350"},{"id":"175","name":"BEETROOT GALAVAT","price":"160.00"},{"id":"176","name":"Wok Fried Noodles","price":"265"},{"id":"177","name":"Bhune Murgh Ke Pasande","price":"250"},{"id":"178","name":"Wok Fried Rice ","price":"270"},{"id":"179","name":"Paneer Keshri Pukttan","price":"360"},{"id":"180","name":"THAI SPICE SOUPS CHICKEN","price":"480"},{"id":"181","name":"Kundan Methi","price":"230"},{"id":"183","name":"Makhmali Saag Panner","price":"310"},{"id":"184","name":"Kofta Makhanwala","price":"210"},{"id":"185","name":"THAI SPICE SOUPS WITH PRAWNS","price":"380"},{"id":"186","name":"Sabz Nizami Handi","price":"460"},{"id":"187","name":"Bhindi Masaledar","price":"210"},{"id":"188","name":"Mushroom Mutter Hara Pyaaz","price":"320"},{"id":"189","name":"THAI SPICE SOUPS VEGETABLES","price":"210"},{"id":"191","name":"DEKHSHINE MURG TIKKA","price":"240"},{"id":"193","name":"PESHWARI TANDOORI MURGH","price":"320"},{"id":"194","name":"PAYA SHORBA","price":"420"},{"id":"195","name":"chiken shish taouk","price":"390"},{"id":"196","name":"TOM YUM WITH VEGETABLES","price":"230"},{"id":"197","name":"TOM YUM CHIKEN SOUPS","price":"310"},{"id":"198","name":"TOM YUP PRAWNS SOUPS","price":"340"},{"id":"199","name":"murgh yakhani shorba","price":"260"},{"id":"200","name":"Mushroom Cappuccino","price":"210"},{"id":"204","name":"WOK FRIED SEASONAL GREENS","price":"280"},{"id":"205","name":"GRILLED PRAWNS TARATUR","price":"380"},{"id":"206","name":"DOUBANJIANG STYLE PRAWNS","price":"380"},{"id":"207","name":"CHIKEN GONG BAO","price":"380"},{"id":"208","name":"THAI CURRY GREEN ","price":"370"},{"id":"209","name":"THAI CURRY CHIKEN","price":"355"},{"id":"210","name":"THAI CURRY FISH","price":"340"},{"id":"213","name":"thai curry prawns","price":"350"},{"id":"215","name":"KACCHE GHOST KI DUM BIRYANI","price":"380"},{"id":"216","name":"DUM MURGH BIRYANI","price":"290"},{"id":"217","name":"PORTUGUES PILAF","price":"350"},{"id":"218","name":"Hyderabadi Subz Dum Biryani","price":"320"},{"id":"219","name":"steame basmati rice","price":"100.00"},{"id":"221","name":"Caramel custard","price":"250"},{"id":"222","name":"TIRAMUSU","price":"230"},{"id":"223","name":"PREMIUM ICECREAM VANILA","price":"195"},{"id":"224","name":"PREMIUM ICECREAM STRAWBERRY","price":"230"},{"id":"225","name":"PREMIUM ICECREAM CHOCOLATE","price":"220"},{"id":"227","name":"PREMIUM ICECREAM COFFE","price":"210"},{"id":"230","name":"PREMIUM ICECREAM BUTTERSCOTCH","price":"180"},{"id":"233","name":"BADEL JAMUN","price":"90"},{"id":"234","name":"KESARI RASMALAI","price":"190"},{"id":"236","name":"KHUBANI KAA MEETHA","price":"210"},{"id":"237","name":"MOONG DAL HALWA","price":"120"},{"id":"239","name":"TANDOORI ROTI","price":"60"},{"id":"240","name":"NAAN","price":"110"},{"id":"241","name":"LACHHA PARATHA","price":"110"},{"id":"242","name":"STUFFED PARATHA","price":"130"},{"id":"243","name":"KULCHA","price":"99"},{"id":"244","name":"RUMALI ROTI","price":"50"},{"id":"1805","name":"O.G. Pizza","price":"150.00"},{"id":"1900","name":"Sriracha & Maple Fried Cauliflower Bites","price":"230"},{"id":"1901","name":"Friend Chicken Tenders","price":"380"},{"id":"2157","name":"Veg burger","price":"120.00"},{"id":"2637","name":"mushroom & black bean patty","price":"200.00"},{"id":"19603","name":"Idali","price":"25.00"},{"id":"19604","name":"Medu Vada","price":"30.00"},{"id":"2642","name":"Veg kabab ","price":"200.50"},{"id":"2643","name":"mushroom&black bean patty","price":"175.00"},{"id":"19600","name":"Shabu vada","price":"30.00"},{"id":"19601","name":"Plain dosa","price":"100.00"},{"id":"19602","name":"Utappa","price":"45.00"},{"id":"3573","name":"Stuffed paratha mix veg","price":"159"},{"id":"3574","name":"Veg Manchurian","price":"100"},{"id":"3575","name":"Veg Crispy","price":"40.00"},{"id":"4439","name":"Caribica","price":"300"},{"id":"19596","name":"Toast","price":"100.00"},{"id":"19597","name":"cheese tomato sandwich","price":"60.00"},{"id":"19598","name":"Poha","price":"15.00"},{"id":"19595","name":"Omlet sandwich","price":"50.00"},{"id":"4499","name":"Tomato onion sandwitch","price":"200"},{"id":"12605","name":"CHEESE PIZZA","price":"195"},{"id":"12607","name":"MINERAL WATER","price":"35"},{"id":"12608","name":"SODA","price":"30.00"},{"id":"12609","name":"SOFT DRINKS","price":"55"},{"id":"19558","name":"Brandy 180ml","price":"300.00"},{"id":"19555","name":"8 pm whisky 180ml","price":"200"},{"id":"14623","name":"palak paneer","price":"200.00"},{"id":"19446","name":"Paneer crispy Kabab ","price":"100.00"},{"id":"19554","name":"crown royal 125ml","price":"100"},{"id":"19553","name":"crown royal 180ml","price":"150"},{"id":"19551","name":"OLD MONK 60ml","price":"125"},{"id":"19552","name":"OLD MONK 90ml","price":"185"},{"id":"19550","name":"OLD MONK 30ml","price":"95"},{"id":"19667","name":"ROMONOV VODKA 90ml","price":"235.00"},{"id":"19430","name":"PANNER DOSA","price":"200.00"},{"id":"19456","name":"Platter","price":"1699.00"},{"id":"19461","name":"methi masala","price":"50.00"},{"id":"19666","name":"ROMONOV VODKA 60ml","price":"135.00"},{"id":"19611","name":"Hakka Noodles","price":"100.00"},{"id":"19549","name":"BIRA Pint","price":"145"},{"id":"19613","name":"Paneer Momos ","price":"100.00"},{"id":"19612","name":"Veg momos","price":"100.00"},{"id":"19548","name":"BIRA Glass","price":"110"},{"id":"19547","name":"KINGFISHER MILD Pint","price":"125"},{"id":"19524","name":"Fried Rice","price":"95.55"},{"id":"19528","name":"Mushroom pizza","price":"12.00"},{"id":"19546","name":"NGFISHER MILD Glass","price":"90"},{"id":"19565","name":"vergin mojito","price":"250.00"},{"id":"19568","name":"cream roll","price":"100.00"},{"id":"19572","name":"Sweet Dish","price":"100.00"},{"id":"19573","name":"Salad","price":"100.00"},{"id":"19582","name":"Papad","price":"123.00"},{"id":"19665","name":"ROMONOV VODKA 30ml","price":"95.00"},{"id":"19614","name":"Veg. Marinated Momos ","price":"100.00"},{"id":"19615","name":"Paneer Marinated Momos ","price":"100.00"},{"id":"19618","name":"Veg. Wonton ","price":"90.00"},{"id":"19619","name":"Non veg momos","price":"90.00"},{"id":"19620","name":"Hot Dry Noodles","price":"100.00"},{"id":"19621","name":"Manchurian Noodles ","price":"90.00"},{"id":"19622","name":"Singapore Noodles ","price":"150.00"},{"id":"19623","name":"Hong Kong Noodles ","price":"100.00"},{"id":"19625","name":"Red Bull ","price":"300.00"},{"id":"19626","name":"Tuborg","price":"160.00"},{"id":"19627","name":"Carlsberg","price":"300.00"},{"id":"19628","name":"Budweiser","price":"500.00"},{"id":"19629","name":"Heineken","price":"123.00"},{"id":"19630","name":"Bira","price":"250.00"},{"id":"19631","name":"Ardbeg 10 Year Old","price":"350.00"},{"id":"19633","name":"Johnnie Walker Gold Label Reserve","price":"1650.00"},{"id":"19634","name":"Vegitable fried Rice","price":"150.00"},{"id":"19635","name":"Ballantine's Finest Blended Scotch Whisky","price":"1400.00"},{"id":"19636","name":"chicken fried rice","price":"200.00"},{"id":"19637","name":"The Macallan Sherry Oak 12 Years","price":"2000.00"},{"id":"19638","name":"Thai Fried Rice","price":"190.00"},{"id":"19639","name":"Basil Fried Rice","price":"180.00"},{"id":"19640","name":"Glenlivet 12 Year Single Malt Scotch Whisky","price":"1256.00"},{"id":"19641","name":"Facundo","price":"450.00"},{"id":"19642","name":"Diplomatico","price":"750.00"},{"id":"19643","name":"Richland","price":"540.00"},{"id":"19644","name":"Mount Gay ","price":"350.00"},{"id":"19645","name":"Goslings ","price":"258.00"},{"id":"19646","name":"Don Papa","price":"890.00"},{"id":"19647","name":"Honey Bee","price":"550.00"},{"id":"19648","name":"Old Admiral.","price":"450.00"},{"id":"19649","name":"Remy Martin","price":"650.00"},{"id":"19651","name":"Mansion House","price":"1800.00"},{"id":"19652","name":"Dreher","price":"990.00"},{"id":"19653","name":"Hennessy","price":"775.00"},{"id":"19654","name":"Remy Martin","price":"2200.00"},{"id":"19655","name":"Full-Bodied Red Wines","price":"550.00"},{"id":"19656","name":"Medium-Bodied Red Wines (Merlot, Barbera)","price":"850.00"},{"id":"19657","name":"White Wine","price":"750.00"},{"id":"19658","name":"Dessert or Sweet Wine","price":"440.00"},{"id":"19659","name":"Sparkling Wine","price":"450.00"},{"id":"19660","name":"Fratelli Sette","price":"120.00"},{"id":"19661","name":"Myra Vineyards Misfit","price":"340.00"},{"id":"19668","name":"ABSOLUT 30ml","price":"95.00"},{"id":"19669","name":"ABSOLUT 60ml","price":"195.00"},{"id":"19670","name":"ABSOLUT FLAVOURS 180ml","price":"340.00"},{"id":"19671","name":"ABSOLUT FLAVOURS 90ml","price":"185.00"},{"id":"19672","name":"MAGIC MOMENTS 60ml","price":"245.00"},{"id":"19760","name":"Chinese","price":"150.00"},{"id":"19762","name":"Veg Maratha","price":"0.00"}]
          // console.log('data',data);  
          // console.log('data1',data1);
          $input.typeahead({
                source:data,autoSelect: true,
                afterSelect:function(item){
                    console.log(item.id);
                    $('#send_restaurant_id').val(item.id);
                    // $('.input-item-id').val(item.id);
                    // $('#input-price').val(item.price);
                    // $('#input-qty').val('1');
                    // $('#input-discount').val('0');
                }
            });
        },'json');
    });
    </script>
</body>

</html>
