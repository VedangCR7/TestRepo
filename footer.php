<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php 
if(isset($_POST['newsletter_submit'])){
$query1 = "SELECT * FROM `subscribe_newsletter` WHERE email = '".$_POST['email_id']."'";
$same_email = mysqli_query($conn,$query1);
$same_email_row1 = mysqli_fetch_assoc($same_email);
//print_r($same_email_row1);
if(empty($same_email_row1)){
$query = "INSERT INTO `subscribe_newsletter`(`email`) VALUES ('".$_POST['email_id']."')";
$newsletter=mysqli_query($conn,$query);
if($newsletter){
    echo '<script>
    swal("Successfully Submited")
    .then((value) => {
        window.location.href="";
    });</script>';

} } else{ echo '<script>
    swal("Email Already exist")
    .then((value) => {
        window.location.href="";
    });</script>'; } }?>
    
    
    
    <!-- /. Call to action -->
    <div class="footer bg-light">
        <!-- Footer -->
        <div class="container">
            <div class="row">
                <div class="col-md-5 ft-aboutus">
                    <h2 style="color:black;">YouCloud</h2>
                    <p>YouCloud is cloud-base solutions for the Restaurants, Bar, Cafe, QSR, Hotels, Resorts, lodging etc.
YouCloud helps all types of hospitality industry, from a single food outlet to a large food chain.</p>
                    <a href="restaurant_listing.php" class="btn btn-default">Find restaurants</a> </div>
                <div class="col-md-3 ft-link">
                    <h2 style="color:black;">Useful links</h2>
                    <ul>
                        <li><a href="about_us.php" target="_blank">About Us</a></li>
                        <li><a href="contact-us.php" target="_blank">Contact us</a></li>
                        <li><a href="privacy_policy.php" target="_blank">Privacy Policy</a></li>
                        <li><a href="terms_of_use.php" target="_blank">Terms of Use</a></li>
                    </ul>
                </div>
                <div class="col-md-4 newsletter">
                    <h2 style="color:black;">Subscribe for Newsletter</h2>
                    <form action="#" method="post">
                        <div class="input-group">
                            <input type="email" class="form-control" name="email_id" placeholder="Enter E-Mail Address" required>
                            <span class="input-group-btn">
                            <button class="btn btn-default" type="submit" value="submit" name="newsletter_submit">Submit</button>
                            </span> 
                        </div>
                        <!-- /input-group -->
                        <!-- /.col-lg-6 -->
                    </form>
                    <div class="social-icon">
                        <h2 style="color:black;">Be Social &amp; Stay Connected</h2>
                        <ul>
                            <li><a href="#" target="_blank"><img src="<?php echo $root_url;?>/website_assets/images/fb.png"></a></li>
                            <li><a href="#" target="_blank"><img src="<?php echo $root_url;?>/website_assets/images/yt.png"></a></li>
                            <li><a href="#" target="_blank"><img src="<?php echo $root_url;?>/website_assets/images/in.png"></a></li>
                            <li><a href="#" target="_blank"><img src="<?php echo $root_url;?>/website_assets/images/sk.png"></a></li>
                            <li><a href="#" target="_blank"><img src="<?php echo $root_url;?>/website_assets/images/ins.png"></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12 text-center">
                    <p>Powered by YouCloud: All in one solution for hospitality industry. © copyrights YouCloud 2021</p>
                </div>
            </div>
        </div>
    </div>
    <!-- /.Footer -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?php echo $root_url;?>/website_assets/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo $root_url;?>/website_assets/js/bootstrap.min.js"></script>
    <!-- Flex Nav Script -->
    <script src="<?php echo $root_url;?>/website_assets/js/jquery.flexnav.js" type="text/javascript"></script>
    <script src="<?php echo $root_url;?>/website_assets/js/navigation.js"></script>
    <!-- slider -->
    <script src="<?php echo $root_url;?>/website_assets/js/owl.carousel.min.js"></script>
    <script type="text/javascript" src="<?php echo $root_url;?>/website_assets/js/slider.js"></script>
    <!-- testimonial -->
    <script type="text/javascript" src="<?php echo $root_url;?>/website_assets/js/testimonial.js"></script>
    <!-- sticky header -->
    <script src="<?php echo $root_url;?>/website_assets/js/jquery.sticky.js"></script>
    <script src="<?php echo $root_url;?>/website_assets/js/header-sticky.js"></script>
    <!-- <script src="admin/assets/js/bootstrap3-typeahead.js"></script> -->
    <script src="admin/assets/js/boostraptypeahead.js"></script>

    
	<script type="text/javascript">
            function googleTranslateElementInit() {
                new google.translate.TranslateElement({ pageLanguage: 'en', includedLanguages: 'en,el', multilanguagePage: true}, 'google_translate_element');
                $(".goog-logo-link").empty();
                $('.goog-te-gadget').html($('.goog-te-gadget').children());
                $('.goog-close-link').click();
               /*  setTimeout(function(){
                    $('.goog-te-gadget .goog-te-combo').find('option:first-child').html('Translate');    
                }, 700); */
            }
        </script>
        <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script> 

        <script async src="https://www.googletagmanager.com/gtag/js?id=G-8ZJNB18KS2"></script>