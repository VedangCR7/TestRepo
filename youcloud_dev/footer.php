
    <footer>
        <div class="wave footer"></div>
        <div class="container margin_60_40 fix_mobile">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <h3 data-target="#collapse_1">Quick Links</h3>
                    <div class="collapse dont-collapse-sm links" id="collapse_1">
                        <ul>
                            <li><a href="#about.php">Who We Are</a></li>
                            <!--<li><a href="submit-restaurant.php">Add your restaurant</a></li>-->
                            <li><a href="blog.php">Blog</a></li>
                            <li><a href="#">News and Events</a></li>
                            <li><a href="#">FAQ</a></li>
                            <li><a href="help.php">Support</a></li> 
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h3 data-target="#collapse_2">Other Pages</h3>
                    <div class="collapse dont-collapse-sm links" id="collapse_2">
                        <ul>
                            <li><a href="#">Privacy & Policy</a></li>
                            <li><a href="#">Terms & Conditions
                            </a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                        <h3 data-target="#collapse_3">Contacts</h3>
                    <div class="collapse dont-collapse-sm contacts" id="collapse_3">
                        <ul>
                            <li><i class="icon_house_alt"></i>Office A&B 18th Floor, Gold Tower, Cluster I,Jumeirah Lake Towers, Dubai, UAE | P.O.115213 </li>
                            <li><i class="icon_mobile"></i>+971-4-442-1782</li>
                            <li><i class="icon_mail_alt"></i><a href="mailto:help@youcloudresto.com">help@youcloudresto.com</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                        <h3 data-target="#collapse_4">Keep in touch</h3>
                    <div class="collapse dont-collapse-sm" id="collapse_4">
                        <div id="newsletter">
                            <div id="message-newsletter"></div>
                            <!--<form method="post" action="assets/newsletter.php" name="newsletter_form" id="newsletter_form">-->
                                <div class="form-group">
                                    <input type="email" name="email_newsletter" id="email_newsletter" class="form-control" placeholder="Your email">
                                    <button type="submit" id="submit-newsletter"><i class="arrow_carrot-right"></i></button>
                                </div>
                            <!--</form>-->
                        </div>
                        <div class="follow_us">
                            <h5>Follow Us</h5>
                            <ul>
                                <li><a href="#0"><img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" data-src="<?= $root_url; ?>/website_assets/webAssets/img/twitter_icon.svg" alt="" class="lazy"></a></li>
                                <li><a href="#0"><img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" data-src="<?= $root_url; ?>/website_assets/webAssets/img/facebook_icon.svg" alt="" class="lazy"></a></li>
                                <li><a href="#0"><img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" data-src="<?= $root_url; ?>/website_assets/webAssets/img/instagram_icon.svg" alt="" class="lazy"></a></li>
                                <li><a href="#0"><img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" data-src="<?= $root_url; ?>/website_assets/webAssets/img/youtube_icon.svg" alt="" class="lazy"></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /row-->
            <hr>
            <div class="row add_bottom_25">
                <div class="col-lg-6">
                    <ul class="footer-selector clearfix">
                        <!--<li>-->
                        <!--    <div class="styled-select lang-selector">-->
                        <!--        <select>-->
                        <!--            <option value="English" selected>English</option>-->
                        <!--            <option value="French">French</option>-->
                        <!--            <option value="Spanish">Spanish</option>-->
                        <!--            <option value="Russian">Russian</option>-->
                        <!--        </select>-->
                        <!--    </div>-->
                        <!--</li>-->
                        <!--Remove<li>
                            <div class="styled-select currency-selector">
                                <select>
                                    <option value="US Dollars" selected>US Dollars</option>
                                    <option value="Euro">Euro</option>
                                </select>
                            </div>
                        </li>
                        <li><img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" data-src="<?= $root_url; ?>/website_assets/webAssets/img/cards_all.svg" alt="" width="230" height="35" class="lazy"></li>-->
                    </ul>
                </div>
                <div class="col-lg-6">
                    <ul class="additional_links">
                        <li><span>Copyright 2021 - YouCloud Payment. All Rights Reserved.
                        </span></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <!--/footer-->

    <div id="toTop"></div><!-- Back to top button -->
    
<!-- Sign In Modal -->
<div id="sign-in-dialog" class="zoom-anim-dialog mfp-hide">
    <div class="modal_header">
        <h3>Sign In</h3>
    </div>
    <form>
        <div class="sign-in-wrapper">
            <a href="loginasguest.php" class="social_bt google guestllogin">Continue as Guest</a>
            <div class="divider"><span>Or</span></div>
            <a href="#0" class="social_bt facebook">Login with Facebook</a>
            <a href="#0" class="social_bt google">Login with Google</a>
            <div class="divider"><span>Or</span></div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" name="email" id="email">
                <i class="icon_mail_alt"></i>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" name="password" id="password" value="">
                <i class="icon_lock_alt"></i>
            </div>
            <div class="clearfix add_bottom_15">
                <div class="checkboxes float-left">
                    <label class="container_check">Remember me
                        <input type="checkbox">
                        <span class="checkmark"></span>
                    </label>
                </div>
                <div class="float-right"><a id="forgot" href="resetpassword.php">Forgot Password?</a></div>
            </div>
            <div class="text-center">
                <input type="submit" value="Log In" class="btn_1 full-width mb_5 greenolive">
                Don’t have an account? <a href="register.php">Sign up</a>
            </div>
            <div id="forgot_pw">
                <div class="form-group">
                    <label>Please confirm login email below</label>
                    <input type="email" class="form-control" name="email_forgot" id="email_forgot">
                    <i class="icon_mail_alt"></i>
                </div>
                <p>You will receive an email containing a link allowing you to reset your password to a new preferred one.</p>
                <div class="text-center"><input type="submit" value="Reset Password" class="btn_1"></div>
            </div>
        </div>
    </form>
    <!--form -->
</div>
<!-- /Sign In Modal -->

<!-- COMMON SCRIPTS -->
<script src="<?= $root_url; ?>/website_assets/webAssets/js/common_scripts.min.js"></script>
<script src="<?= $root_url; ?>/website_assets/webAssets/js/common_func.js"></script>
<script src="<?= $root_url; ?>/website_assets/webAssets/js/validate.js"></script>

<!-- TYPE EFFECT -->
    <script src="<?= $root_url; ?>/website_assets/webAssets/js/typed.min.js"></script>
    <script>
        var typed = new Typed('.element', {
          strings: ["with best price", "with unique food", "with nice location"],
          startDelay: 10,
          loop: true,
          backDelay: 2000,
          typeSpeed: 50
        });
    </script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCxZhtbUnOHn9YA3iS7M6YNc2DU_eFGs5k&libraries=places&callback=initMap"
></script>
<!-- Autocomplete -->
<script>
    
function initMap() {
    var input = document.getElementById('autocomplete');
    var autocomplete = new google.maps.places.Autocomplete(input);

    autocomplete.addListener('place_changed', function() {
        var place = autocomplete.getPlace();
        if (!place.geometry) {
            window.alert("Autocomplete's returned place contains no geometry");
            return;
        }

        var address = '';
        if (place.address_components) {
            address = [
                (place.address_components[0] && place.address_components[0].short_name || ''),
                (place.address_components[1] && place.address_components[1].short_name || ''),
                (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
        }
    });
}
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.js"></script>

</body>
</html>