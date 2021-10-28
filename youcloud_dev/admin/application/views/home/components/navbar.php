<?php 

$this->load->model('Comman_model');

$courseArr = $this->Comman_model->getdata_array('course',['status'=>1]);

?>



<!-- Header Section Start -->
<div class="header-section header-shadow sticky-header section">
    <div class="header-inner">
        <div class="container position-relative">
            <div class="row justify-content-between align-items-center">

                <!-- Header Logo Start -->
                <div class="col-xl-2 col-4">
                    <div class="header-logo">
                        <a href="<?php echo base_url(); ?>">
                            <img class="dark-logo" src="<?php echo base_url('assets/front_assets2/') ?>img/logo/logo.svg" alt="iqroots" />
                        </a>
                    </div>
                </div>
                <!-- Header Logo End -->

                <!-- Header Main Menu Start -->
                <div class="col d-none d-xl-block position-static">
                    <nav class="site-main-menu menu-hover-1">
                        <ul>
                            <li class="has-children position-static">
                                <a href="<?php echo base_url('home/aboutUs'); ?>"> About</a>
                            </li>
                            <li class="has-children position-static">
                                <a href="#"> Test Prep <i class="fas fa-angle-down"></i></a>
								<ul class="iqroots-submenus ">

								<?php if(isset($courseArr)){ 
                                    $count = 1;
									foreach ($courseArr as $eachCourse) {
                                        if($count==1){ ?>

                                    <li>
                                        <a href="<?php echo base_url('home/course/').$eachCourse['id']; ?>"><?= $eachCourse['title'];  ?></a>
                                    </li>

                                    <?php }else{ ?>

									<li class="course-disabled">
										<a href="#"><?= $eachCourse['title'];  ?> <span>Comming Soon</span></a>
									</li>

                                     <?php } ?>


								<?php $count++; } } ?>										

								<!-- 	<li>
										<a href="">IELTS 2 <i class="fas fa-angle-right"></i></a>
										<ul class="iqroots-secondlevel-submenus">
											<li>
												<a href="">IELTS 1</a>
											</li>
											<li>
												<a href="">IELTS 2</a>
											</li>
											<li>
												<a href="">IELTS 3</a>
											</li>
										</ul>
									</li>
									<li>
										<a href="">IELTS 3 <i class="fas fa-angle-right"></i></a>
										<ul class="iqroots-secondlevel-submenus">
											<li>
												<a href="">IELTS 1</a>
											</li>
											<li>
												<a href="">IELTS 2</a>
											</li>
											<li>
												<a href="">IELTS 3</a>
											</li>
										</ul>
									</li> -->
								</ul>
                            </li>
                         </ul>
                    </nav>
                </div>
                <!-- Header Main Menu End -->

                <!-- Header Right Start -->
                <div class="col-xl-2 col-8">
                    <div class="header-right">
                        <div class="inner">
                            <div class="btn-nav-links">
                                <a href="#registerModal" data-toggle="modal" class="btn btn-text btn-hover-transparent pl-0 pr-2 loginBtn"  onclick="openCity(event, 'log-in')">Log in</a>
                                <a href="#myModal" data-toggle="modal" class="btn bg-btn lnk" onclick="openCity(event, 'sing-up')">Sign up <span class="circle"></span></a>
                            </div>
                            <!-- Header Mobile Menu Toggle Start -->
                            <div class="header-mobile-menu-toggle d-xl-none ml-sm-2">
                                <button class="toggle">
                                    <i class="icon-top"></i>
                                    <i class="icon-middle"></i>
                                    <i class="icon-bottom"></i>
                                </button>
                            </div>
                            <!-- Header Mobile Menu Toggle End -->
                        </div>
                    </div>
                </div>
                <!-- Header Right End -->
                
            </div>
        </div>
    </div>
</div>
<!-- Header Section End -->


<div class="clearfix"></div>