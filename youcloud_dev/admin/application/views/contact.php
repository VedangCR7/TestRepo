<?php
require_once('header.php');
?>
 <!-- Inner Banner Section -->
    <section class="inner-banner alternate">
        <div class="image-layer" style="background-image: url(<?=base_url();?>assets/images/background/banner-bg-2.jpg);"></div>
		<div class="auto-container">
            <div class="inner">
    			<div class="title-box">
                    <h1>Contact</h1>
                    <div class="d-text">Building a relationship between IT Services</div>
                </div>
            </div>
		</div>
    </section>
    <!--End Banner Section -->

	<!--Contact Section-->
    <section class="contact-section-two">
        <div class="auto-container">
            <div class="upper-row">
                <div class="row clearfix">
                    <!--Text Column-->
                    <div class="text-column col-lg-6 col-md-12 col-sm-12">
                        <div class="inner">
                            <div class="sec-title">
                                <div class="upper-text">ZenTec - Send us a Message</div>
                                <h2>Do You Have Any Questions? We’ll Be Happy To Assist!</h2>
                                <div class="lower-text">Dolor sit amet, consectetur adipisicing elitm sed do eiusmod ut labore etsu dolore magna aliquatenim minim.</div>
                            </div>

                            <div class="social-links">
                                <ul class="clearfix">
                                    <li><a href="<?=base_url();?>#"><span class="fab fa-facebook-square"></span></a></li>
                                    <li><a href="<?=base_url();?>#"><span class="fab fa-twitter"></span></a></li>
                                    <li><a href="<?=base_url();?>#"><span class="fab fa-instagram"></span></a></li>
                                    <li><a href="<?=base_url();?>#"><span class="fab fa-youtube"></span></a></li>
                                    <li><a href="<?=base_url();?>#"><span class="fab fa-pinterest"></span></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!--Form Column-->
                    <div class="form-column col-lg-6 col-md-12 col-sm-12">
                        <div class="inner">
                            <!--Form Box-->
                            <div class="form-box">
                                <div class="default-form contact-form">
                                    <form method="post" action="http://t.commonsupport.xyz/zentec/sendemail.php" id="contact-form">
                                        <div class="row clearfix">                                    
                                            <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                                <input type="text" name="username" placeholder="Your Name" required="" value="">
                                            </div>
                                            
                                            <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                                <input type="email" name="email" placeholder="Email" required="" value="">
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                                <input type="text" name="phone" placeholder="Phone" required="" value="">
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                                <input type="text" name="subject" placeholder="Subject" required="" value="">
                                            </div>

                                            <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                                <textarea name="message" placeholder="Message" required=""></textarea>
                                            </div>
                    
                                            <div class="form-group col-md-12 col-sm-12">
                                                <button type="submit" class="theme-btn btn-style-one"><span class="btn-title">Make a Request</span></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="lower-row">
                <div class="row clearfix">
                    <!--Info Block-->
                    <div class="contact-info-block col-lg-4 col-md-6 col-sm-12">
                        <div class="inner wow fadeInUp" data-wow-delay="0ms" data-wow-duration="1500ms">
                            <div class="content-box">
                                <div class="title-box">
                                    <h4><a href="<?=base_url();?>case-studies">Asia Office</a></h4>
                                    <div class="sub-text">Singapore</div>
                                </div>
                                <div class="text-content">
                                    <div class="info">
                                        <ul>
                                            <li>47 Wood Circle, Pana City FL 32401</li>
                                            <li>Call us <a href="<?=base_url();?>tel:(+1)-500.369.2580"><strong>(+1) 500.369.2580</strong></a></li>
                                            <li><a href="<?=base_url();?>mailto:support@zentec.com">support@zentec.com</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!--Map Box-->
                            <div class="map-box">
                                <div class="map-canvas"
                                    data-zoom="12"
                                    data-lat="-37.817085"
                                    data-lng="144.955631"
                                    data-type="roadmap"
                                    data-hue="#ffc400"
                                    data-title="Singapore"
                                    data-icon-path="<?=base_url();?>assets/images/icons/map-marker.png"
                                    data-content="Singapore VIC 3000, USA<br><a href='mailto:info@youremail.com'>info@youremail.com</a>">
                                </div>
                            </div>

                        </div>
                    </div>
                    <!--Info Block-->
                    <div class="contact-info-block col-lg-4 col-md-6 col-sm-12">
                        <div class="inner wow fadeInUp" data-wow-delay="300ms" data-wow-duration="1500ms">
                            <div class="content-box">
                                <div class="title-box">
                                    <h4><a href="<?=base_url();?>case-studies">USA Office</a></h4>
                                    <div class="sub-text">California</div>
                                </div>
                                <div class="text-content">
                                    <div class="info">
                                        <ul>
                                            <li>47 Wood Circle, Pana City FL 32401</li>
                                            <li>Call us <a href="<?=base_url();?>tel:(+1)-500.369.2580"><strong>(+1) 500.369.2580</strong></a></li>
                                            <li><a href="<?=base_url();?>mailto:support@zentec.com">support@zentec.com</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!--Map Box-->
                            <div class="map-box">
                                <div class="map-canvas"
                                    data-zoom="12"
                                    data-lat="-37.817085"
                                    data-lng="144.955631"
                                    data-type="roadmap"
                                    data-hue="#ffc400"
                                    data-title="California"
                                    data-icon-path="<?=base_url();?>assets/images/icons/map-marker-2.png"
                                    data-content="California VIC 3000, USA<br><a href='mailto:info@youremail.com'>info@youremail.com</a>">
                                </div>
                            </div>

                        </div>
                    </div>
                    <!--Info Block-->
                    <div class="contact-info-block col-lg-4 col-md-6 col-sm-12">
                        <div class="inner wow fadeInUp" data-wow-delay="600ms" data-wow-duration="1500ms">
                            <div class="content-box">
                                <div class="title-box">
                                    <h4><a href="<?=base_url();?>case-studies">Europe office</a></h4>
                                    <div class="sub-text">Manchester, UK</div>
                                </div>
                                <div class="text-content">
                                    <div class="info">
                                        <ul>
                                            <li>47 Wood Circle, Pana City FL 32401</li>
                                            <li>Call us <a href="<?=base_url();?>tel:(+1)-500.369.2580"><strong>(+1) 500.369.2580</strong></a></li>
                                            <li><a href="<?=base_url();?>mailto:support@zentec.com">support@zentec.com</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!--Map Box-->
                            <div class="map-box">
                                <div class="map-canvas"
                                    data-zoom="12"
                                    data-lat="-37.817085"
                                    data-lng="144.955631"
                                    data-type="roadmap"
                                    data-hue="#ffc400"
                                    data-title="Europe"
                                    data-icon-path="<?=base_url();?>assets/images/icons/map-marker-3.png"
                                    data-content="Manchester VIC 3000, Europe<br><a href='mailto:info@youremail.com'>info@youremail.com</a>">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--Call To Action-->
    <section class="call-to-action">
        <div class="map-pattern-layer"></div>

        <div class="auto-container">
            <div class="row clearfix">
                <div class="title-column col-xl-7 col-lg-12 col-md-12 col-sm-12">
                    <div class="inner">
                        <h2>Do You Need Our IT Solutions? <br>Get Advice From Our Professionals.</h2>
                    </div>
                </div>
                <div class="links-column col-xl-5 col-lg-12 col-md-12 col-sm-12">
                    <div class="inner">
                        <div class="links-box">
                            <a href="<?=base_url();?>contact" class="theme-btn btn-style-two"><div class="btn-title">Make a Request</div></a>
                            <a href="<?=base_url();?>contact" class="theme-btn btn-style-one"><div class="btn-title">Talk With Expert</div></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php require_once('footer.php');?>
<script type="text/javascript">

</script>