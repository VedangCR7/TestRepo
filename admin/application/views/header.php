<!doctype html>
<html lang="en" dir="ltr">
    <head>
        <!-- Meta data -->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="Foodnai Admin panel" name="description">
        <meta content="https://hotelredngreen.co.in/" name="author">
        <!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo APP_shortcut_icon ?>" />

        <!-- Title -->
        <title><?php echo APP_NAME ?> - food allergen nutrition information</title>

        <!--Bootstrap.min css-->
        <link rel="stylesheet" href="<?=base_url();?>assets/plugins/bootstrap/css/bootstrap.min.css">
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
				<!--Font Awesome-->
        <link href="<?=base_url();?>assets/plugins/fontawesome-free/css/all.css" rel="stylesheet">

        <!-- Dashboard Css -->
        <link href="<?=base_url();?>assets/css/style.css?v=8" rel="stylesheet" />
        <link href="<?=base_url();?>assets/css/color-styles.css" rel="stylesheet" />
        <link href="<?=base_url();?>assets/css/skin-modes.css" rel="stylesheet" />

        <!-- vector-map -->
        <link href="<?=base_url();?>assets/plugins/jquery.vmap/jqvmap.min.css" rel="stylesheet">

        <!-- Custom scroll bar css-->
        <link href="<?=base_url();?>assets/plugins/jquery.mCustomScrollbar/jquery.mCustomScrollbar.css" rel="stylesheet" />

        <!-- Sidemenu Css -->
        <link href="<?=base_url();?>assets/plugins/sidemenu/css/sidemenu-closed.css?v=1" rel="stylesheet">

        <!-- morris Charts Plugin -->
        <link href="<?=base_url();?>assets/plugins/morris/morris.css" rel="stylesheet" />

        <!---Font icons-->
        <link href="<?=base_url();?>assets/plugins/iconfonts/plugin.css" rel="stylesheet" />

        <link href="<?=base_url();?>assets/plugins/datatables/dataTables.bootstrap4.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url();?>assets/plugins/datatables/responsive.bootstrap4.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url();?>assets/plugins/datatables/buttons.bootstrap4.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url();?>assets/plugins/datatables/select.bootstrap4.css" rel="stylesheet" type="text/css" />

        <link href="<?=base_url();?>assets/plugins/sweet-alert/sweetalert.css" rel="stylesheet" />

        <link href="<?=base_url();?>assets/plugins/select2/select2.min.css" rel="stylesheet" />

        <link rel="stylesheet" href="<?=base_url();?>assets/plugins/multipleselect/multiple-select.css">
        <!-- Sidebar css -->
        <link href="<?=base_url();?>assets/plugins/sidebar/sidebar.css" rel="stylesheet">
		<!-- <link href="<?=base_url();?>assets/plugins/tabs/tabs.css" rel="stylesheet">-->
         
		<!-- Custom Delete Alert box CSS-->
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		<!-- End Custom Delete -->
		 		 
        <!-- Image Crop plugin -->
        <!-- <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/croppie/croppie.css" /> -->
        <script src="<?=base_url();?>assets/js/vendors/jquery-3.2.1.min.js"></script>
        
        <script src="<?=base_url();?>assets/js/moment.js"></script>
        <!-- <script src="<?=base_url();?>assets/plugins/cropzee/cropzee.js" defer></script> -->
        <style>
            .goog-te-banner-frame.skiptranslate {
    display: none !important;
    } 
body {
    top: 0px !important; 
    }
            .header .nav-link .badge.new-order{
                height: 1.5rem!important;
                width: 1.5rem!important;
                padding: 5px 0px!important;
            }
            .noti-title-new-order{
                padding: 0px 8px;
                font-weight: bold;
            }
            .avatar.table-title{
                font-size:12px!important;
            }
            #new-order-count-inner{
                font-size: 16px;
                font-weight: bold;
            }
            #new-order-container{
                max-height: 300px;
                overflow: auto;
            }
		</style>
    </head>

    <body class="app sidebar-mini rtl">
        <!-- Global Loader-->
        <div id="global-loader"><img src="<?=base_url();?>assets/images/svgs/loader.svg" alt="loader"></div>
		<div id="image-loader"><img src="<?=base_url();?>assets/images/svgs/loader.svg" alt="loader"></div>
        <div class="page">
            <div class="page-main">
                <!-- Navbar-->
                <header class="app-header header">
                    <!-- Navbar Right Menu-->
                    <div class="container-fluid">
                        <div class="d-flex">
                            <?php
                                /* if($_SESSION['usertype']=="Admin")
                                    $url="admin";
                                if($_SESSION['usertype']=="Individual User")
                                    $url="recipes/overview";
                                if($_SESSION['usertype']=="Individual Restaurants")
                                    $url="restaurant";
                                if($_SESSION['usertype']=="Food Company")
                                    $url="company";
                                if($_SESSION['usertype']=="School")
                                    $url="school"; */
								/* changes done by Ashwini */
								if($_SESSION['usertype']=="Admin")
                                    $url="admin";
                                if($_SESSION['usertype']=="Individual User")
                                    $url="recipes/overview";
                                if(($_SESSION['usertype']=="Restaurant") || ($_SESSION['usertype']=="Burger and Sandwich"))
                                    $url="restaurant";
                                if($_SESSION['usertype']=="Restaurant chain")
                                    $url="company";
                                if($_SESSION['usertype']=="School")
                                    $url="school";
                                if($_SESSION['usertype']=="Whatsapp manager")
                                    $url="Whatsapp_manager/whatsapp_message";
                            ?>
                            <a class="header-brand" href="<?php echo base_url().$url;?>">
                                <img alt="logo" class="header-brand-img main-logo" src="<?php echo APP_HEADER_LOGO ?>">
                                <img alt="logo" class="header-brand-img mobile-logo" src="<?php echo APP_HEADER_LOGO ?>">
                            </a>
                            <!-- Sidebar toggle button-->
                            <a aria-label="Hide Sidebar" class="app-sidebar__toggle" data-toggle="sidebar" href="#"></a>
                           <!--  <div class="dropdown d-sm-flex d-none">
                                <a href="#" class="nav-link icon" data-toggle="dropdown">
                                    <i class="fe fe-search"></i>
                                </a>
                                <div class="dropdown-menu header-search dropdown-menu-left dropdown-menu-arrow">
                                    <div class="input-group w-100 p-2">
                                        <input type="text" class="form-control " placeholder="Search....">
                                        <div class="input-group-append ">
                                            <button type="button" class="btn btn-primary ">
                                                <i class="fas fa-search" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <!-- <div class="dropdown d-sm-flex d-none header-message">
                                <a class="nav-link icon" data-toggle="dropdown">
                                    <i class="fe fe-grid mr-2"></i><span class="lay-outstyle">Menus styles</span>
                                    <span class="pulse2 bg-warning" aria-hidden="true"></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item d-flex pb-3" href="left-menu.html">Icon Menu</a>
                                    <a class="dropdown-item d-flex pb-3" href="sidemenu.html">Icon Closed Menu</a>
                                    <a class="dropdown-item d-flex pb-3" href="overlay2.html">Icon Overlay Menu</a>
                                    <a class="dropdown-item d-flex pb-3" href="overlay.html">Closed Overlay Menu</a>
                                    <a class="dropdown-item d-flex pb-3" href="horizontal.html">Horizontal Menu</a>

                                </div>
                            </div> -->
                            <div class="d-flex order-lg-2 ml-auto">
                            <div class="dropdown d-sm-flex d-none header-message">
								<!--<audio id="newordersound" src="<?=base_url();?>assets/neworder.mp3" preload="auto" muted></audio>-->
								<audio tabindex="0" id="newordersound" controls preload="auto" style="display: none;">
									<source src="https://testing.foodnai.com/admin/assets/neworder.mp3">
								</audio>
                                    <a class="nav-link icon" data-toggle="dropdown">
                                        <span class="noti-title-new-order">New Orders </span>
                                        <i class="fe fe-bell"></i>
                                        <span class=" nav-unread badge badge-warning  badge-pill new-order new-order-count">0</span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                        <a class="dropdown-item text-center" href="#">New Orders (<span id="new-order-count-inner"></span>)</a>
                                        <div class="dropdown-divider"></div>
                                        <div id="new-order-container">
                                            Loading Orders...
                                        </div>
                                        <div class="dropdown-divider"></div>
                                        <!-- <div class="text-center dropdown-btn pb-3">
                                            <div class="btn-list">
                                                <a href="#" class="btn btn-primary btn-sm"><i class="fe fe-plus mr-1"></i>Add New</a>
                                                <a href="#" class=" btn btn-secondary btn-sm"><i class="fe fe-eye mr-1"></i>View All</a>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                                <div class="d-sm-flex">
                                <!-- <select class="form-control" id="select_languages">
                                    <?php if($_SESSION['language'] == ''){ ?>
                                    
                                    <option value="English">English</option>
                                    <option value="Greek">Greek</option><?php } else{?>
                                    <option value="English" <?=($_SESSION['language'] == 'English') ? 'Selected':''?>>English</option>
                                    <option value="Greek" <?=($_SESSION['language'] == 'Greek') ? 'Selected':''?>>Greek</option>
                                    <?php } ?>
                                </select> -->
                                    <div class="google_lang_menu menu_details_translate" style="display: none;margin-top:10px;">
                                        <div id="google_translate_element"></div>
                                    </div>
                                </div>
                                <div class="d-sm-flex d-none">
                                    <a href="#" class="nav-link icon full-screen-link">
                                        <i class="fe fe-minimize fullscreen-button"></i>
                                    </a>
                                </div>
                           <!--      <div class="dropdown d-none d-md-flex">
                                    <a href="#" class="d-flex nav-link pr-0 country-flag" data-toggle="dropdown">
                                        <span class="avatar country-Flag mr-3 align-self-center cover-image" data-image-src="<?=base_url();?>assets/images/svgs/flags/french_flag.jpg"></span>
                                        <div>
                                            <span class="text-white mr-3 mt-0">English</span>
                                        </div>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                        <a href="#" class="dropdown-item d-flex pb-3">
                                            <span class="avatar country-Flag mr-3 align-self-center cover-image" data-image-src="<?=base_url();?>assets/images/svgs/flags/french_flag.jpg"></span>
                                            <div class="d-flex">
                                                <span class="">French</span>
                                            </div>
                                        </a>
                                        <a href="#" class="dropdown-item d-flex pb-3">
                                            <span class="avatar country-Flag mr-3 align-self-center cover-image" data-image-src="<?=base_url();?>assets/images/svgs/flags/germany_flag.jpg"></span>
                                            <div class="d-flex">
                                                <span class="">Germany</span>
                                            </div>
                                        </a>
                                        <a href="#" class="dropdown-item d-flex pb-3">
                                            <span class="avatar country-Flag mr-3 align-self-center cover-image" data-image-src="<?=base_url();?>assets/images/svgs/flags/italy_flag.jpg"></span>
                                            <div class="d-flex">
                                                <span class="">Italy</span>
                                            </div>
                                        </a>
                                        <a href="#" class="dropdown-item d-flex pb-3">
                                            <span class="avatar country-Flag  mr-3 align-self-center cover-image" data-image-src="<?=base_url();?>assets/images/svgs/flags/russia_flag.jpg"></span>
                                            <div class="d-flex">
                                                <span class="">Russia</span>
                                            </div>
                                        </a>
                                        <a href="#" class="dropdown-item d-flex pb-3">
                                            <span class="avatar country-Flag mr-3 align-self-center cover-image" data-image-src="<?=base_url();?>assets/images/svgs/flags/spain_flag.jpg"></span>
                                            <div class="d-flex">
                                                <span class="">spain</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="dropdown d-sm-flex d-none header-message">
                                    <a class="nav-link icon" data-toggle="dropdown">
                                        <i class="fe fe-mail"></i>
                                        <span class=" nav-unread badge badge-danger badge-pill">4</span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                        <a class="dropdown-item text-center" href="#">2 New Messages</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item d-flex pb-3" href="#">
                                            <span class="avatar avatar-md brround mr-3 align-self-center cover-image" data-image-src="<?=base_url();?>assets/images/users/7.jpg"></span>
                                            <div>
                                                <strong>Madeleine</strong> Hey! there I' am available....
                                                <div class="small text-muted">
                                                    3 hours ago
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item d-flex pb-3" href="#"><span class="avatar avatar-md brround mr-3 align-self-center cover-image" data-image-src="<?=base_url();?>assets/images/users/3.jpg"></span>
                                            <div>
                                                <strong>Anthony</strong> New product Launching...
                                                <div class="small text-muted">
                                                    5 hour ago
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item d-flex pb-3" href="#"><span class="avatar avatar-md brround mr-3 align-self-center cover-image" data-image-src="<?=base_url();?>assets/images/users/8.jpg"></span>
                                            <div>
                                                <strong>Olivia</strong> New Schedule Realease......
                                                <div class="small text-muted">
                                                    45 mintues ago
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item d-flex pb-3" href="#"><span class="avatar avatar-md brround mr-3 align-self-center cover-image" data-image-src="<?=base_url();?>assets/images/users/9.jpg"></span>
                                            <div>
                                                <strong>Sanderson</strong> New Schedule Realease......
                                                <div class="small text-muted">
                                                    2 days ago
                                                </div>
                                            </div>
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <div class="text-center dropdown-btn pb-3">
                                            <div class="btn-list">
                                                <a href="#" class="btn btn-primary btn-sm"><i class="fe fe-plus mr-1"></i>Add New</a>
                                                <a href="#" class=" btn btn-secondary btn-sm"><i class="fe fe-eye mr-1"></i>View All</a>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                               <!--  <div class="dropdown d-sm-flex d-none header-message">
                                    <a class="nav-link icon" data-toggle="dropdown">
                                        <i class="fe fe-bell"></i>
                                        <span class=" nav-unread badge badge-warning  badge-pill">3</span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                        <a class="dropdown-item text-center" href="#">Notifications</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item d-flex pb-4" href="#">
                                            <span class="avatar brround mr-3 align-self-center avatar-md cover-image bg-primary"><i class="fe fe-mail fs-12"></i></span>
                                            <div>
                                                <span class="font-weight-bold"> commented on your post </span>
                                                <div class="small text-muted d-flex">
                                                    3 hours ago
                                                    <div class="ml-auto">
                                                    <span class="badge badge-primary">New</span>
                                                    </div>
                                                </div>
                                                <div class="progress progress-xs mt-1">
                                                    <div class="progress-bar bg-primary w-30"></div>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item d-flex pb-4" href="#">
                                            <span class="avatar avatar-md brround mr-3 align-self-center cover-image bg-secondary"><i class="fe fe-download"></i>
                                            </span>
                                            <div>
                                                <span class="font-weight-bold"> New file has been Uploaded </span>
                                                <div class="small text-muted d-flex">
                                                    5 hour ago
                                                    <div class="ml-auto">
                                                    <span class="badge badge-secondary">New</span>
                                                    </div>
                                                </div>
                                                <div class="progress progress-xs mt-1">
                                                    <div class="progress-bar bg-secondary w-50"></div>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item d-flex pb-4" href="#">
                                            <span class="avatar avatar-md brround mr-3 align-self-center cover-image bg-warning"><i class="fe fe-user"></i>
                                            </span>
                                            <div>
                                                <span class="font-weight-bold"> User account has Updated</span>
                                                <div class="small text-muted d-flex">
                                                    5 hour ago
                                                    <div class="ml-auto">
                                                    <span class="badge badge-warning">New</span>
                                                    </div>
                                                </div>
                                                <div class="progress progress-xs mt-1">
                                                    <div class="progress-bar bg-warning w-70"></div>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <div class="text-center dropdown-btn pb-3">
                                            <div class="btn-list">
                                                <a href="#" class="btn btn-primary btn-sm"><i class="fe fe-plus mr-1"></i>Add New</a>
                                                <a href="#" class=" btn btn-secondary btn-sm"><i class="fe fe-eye mr-1"></i>View All</a>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                                <!-- <button class="navbar-toggler navresponsive-toggler d-sm-none" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-4"
                                    aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="navbar-toggler-icon fe fe-more-vertical text-white"></span>
                                </button> -->
                                <!--Navbar -->
                                <div class="dropdown">
                                    <a class="nav-link pr-0 leading-none d-flex" data-toggle="dropdown" href="#">
                                        <?php
                                       if($_SESSION['profile_photo']=="" || $_SESSION['profile_photo']=="assets/images/users/rg_logo.png"){
                                       ?>
                                        <span class="avatar avatar-md brround cover-image span-header-image" data-image-src="<?=base_url();?>assets/images/users/rg_logo.png"></span>
                                        <?php
                                       }else if($_SESSION['profile_photo']=="" || $_SESSION['profile_photo']=="assets/images/users/user.png"){
                                        ?>
                                        <span class="avatar avatar-md brround cover-image span-header-image" data-image-src="<?=base_url();?>assets/images/users/user.png"></span>
                                    <?php }else{
                                        ?>
                                        <span class="avatar avatar-md brround cover-image span-header-image" data-image-src="<?=$_SESSION['profile_photo'];?>"></span>
                                        <?php
                                        }
                                        ?>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                        <div class="drop-heading">
                                            <div class="text-center">
                                                    <h5 class="text-dark mb-1"><?php if ($_SESSION['business_name']) {
                                                        echo $_SESSION['business_name'];
                                                    } else{
                                                        echo $_SESSION['name'];
                                                    }?></h5>
                                                <small class="text-muted"><?=$_SESSION['usertype'];?></small>
                                            </div>
                                        </div>
                                        <div class="dropdown-divider m-0"></div>
                                        <?php
                                        if($_SESSION['usertype']!="Admin"){
                                        ?>
                                        <a class="dropdown-item" href="<?=base_url();?>profile"><i class="dropdown-icon fe fe-user"></i>Profile</a>
                                        <?php
                                        }
                                        ?>
                                        <a class="dropdown-item" href="<?=base_url();?>profile/change_password"><i class="dropdown-icon fe fe-user"></i>Change Password</a>
                                       <!--  <a class="dropdown-item" href="#"><i class="dropdown-icon fe fe-edit"></i>Schedule</a>
                                        <a class="dropdown-item" href="#"><i class="dropdown-icon fe fe-mail"></i> Inbox</a>
                                        <a class="dropdown-item" href="#"><i class="dropdown-icon fe fe-unlock"></i> Look Screen</a> -->
                                        <a class="dropdown-item" href="<?=base_url();?>profile/faq"><i class="dropdown-icon fe fe-life-buoy"></i> FAQ</a>
                                        <a class="dropdown-item" href="<?=base_url();?>login/logout"><i class="dropdown-icon fe fe-power"></i> Log Out</a>
                                       <!--  <div class="dropdown-divider"></div>
                                        <div class="text-center dropdown-btn pb-3">
                                            <div class="btn-list">
                                                <a href="#" class="btn btn-icon btn-facebook btn-sm"><i class="si si-social-facebook"></i></a>
                                                <a href="#" class="btn btn-icon btn-twitter btn-sm"><i class="si si-social-twitter"></i></a>
                                                <a href="#" class="btn btn-icon btn-instagram btn-sm"><i class="si si-social-instagram"></i></a>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                               <!--  <div class="dropdown d-md-flex header-settings">
                                    <a href="#" class="nav-link icon" data-toggle="sidebar-right" data-target=".sidebar-right">
                                        <i class="fe fe-align-right"></i>
                                    </a>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </header>
                <div class="mb-1 navbar navbar-expand-lg  responsive-navbar navbar-dark d-sm-none bg-white">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                        <div class="d-flex order-lg-2 ml-auto">
                            <div class="dropdown d-md-flex">
                                <a href="#" class="nav-link icon" data-toggle="dropdown">
                                    <i class="fe fe-search"></i>
                                </a>
                                <div class="dropdown-menu  dropdown-menu-right dropdown-menu-arrow">
                                    <div class="input-group w-100 p-2">
                                        <input type="text" class="form-control " placeholder="Search....">
                                        <div class="input-group-append ">
                                            <button type="button" class="btn btn-primary ">
                                                <i class="fas fa-search" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-md-flex">
                                <a href="#" class="nav-link icon full-screen-link text-dark">
                                    <i class="fe fe-minimize fullscreen-button"></i>
                                </a>
                            </div>
                            <div class="dropdown  d-md-flex header-contact">
                                <a class="nav-link icon text-dark" data-toggle="dropdown">
                                    <i class="fe fe-flag"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a href="#" class="dropdown-item d-flex pb-3">
                                        <span class="avatar country-Flag mr-3 align-self-center cover-image" data-image-src="<?=base_url();?>assets/images/svgs/flags/french_flag.jpg"></span>
                                        <div class="d-flex">
                                            <span class="">French</span>
                                        </div>
                                    </a>
                                    <a href="#" class="dropdown-item d-flex pb-3">
                                        <span class="avatar country-Flag mr-3 align-self-center cover-image" data-image-src="<?=base_url();?>assets/images/svgs/flags/germany_flag.jpg"></span>
                                        <div class="d-flex">
                                            <span class="">Germany</span>
                                        </div>
                                    </a>
                                    <a href="#" class="dropdown-item d-flex pb-3">
                                        <span class="avatar country-Flag mr-3 align-self-center cover-image" data-image-src="<?=base_url();?>assets/images/svgs/flags/italy_flag.jpg"></span>
                                        <div class="d-flex">
                                            <span class="">Italy</span>
                                        </div>
                                    </a>
                                    <a href="#" class="dropdown-item d-flex pb-3">
                                        <span class="avatar country-Flag  mr-3 align-self-center cover-image" data-image-src="<?=base_url();?>assets/images/svgs/flags/russia_flag.jpg"></span>
                                        <div class="d-flex">
                                            <span class="">Russia</span>
                                        </div>
                                    </a>
                                    <a href="#" class="dropdown-item d-flex pb-3">
                                        <span class="avatar country-Flag mr-3 align-self-center cover-image" data-image-src="<?=base_url();?>assets/images/svgs/flags/spain_flag.jpg"></span>
                                        <div class="d-flex">
                                            <span class="">spain</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="dropdown  d-md-flex header-contact">
                                <a class="nav-link icon text-dark" data-toggle="dropdown">
                                    <i class="fe fe-mail"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item text-center" href="#">2 New Messages</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item d-flex pb-3" href="#">
                                        <span class="avatar avatar-md brround mr-3 align-self-center cover-image" data-image-src="<?=base_url();?>assets/images/users/7.jpg"></span>
                                        <div>
                                            <strong>Madeleine</strong> Hey! there I' am available....
                                            <div class="small text-muted">
                                                3 hours ago
                                            </div>
                                        </div>
                                    </a>
                                    <a class="dropdown-item d-flex pb-3" href="#"><span class="avatar avatar-md brround mr-3 align-self-center cover-image" data-image-src="<?=base_url();?>assets/images/users/3.jpg"></span>
                                        <div>
                                            <strong>Anthony</strong> New product Launching...
                                            <div class="small text-muted">
                                                5 hour ago
                                            </div>
                                        </div>
                                    </a>
                                    <a class="dropdown-item d-flex pb-3" href="#"><span class="avatar avatar-md brround mr-3 align-self-center cover-image" data-image-src="<?=base_url();?>assets/images/users/8.jpg"></span>
                                        <div>
                                            <strong>Olivia</strong> New Schedule Realease......
                                            <div class="small text-muted">
                                                45 mintues ago
                                            </div>
                                        </div>
                                    </a>
                                    <a class="dropdown-item d-flex pb-3" href="#"><span class="avatar avatar-md brround mr-3 align-self-center cover-image" data-image-src="<?=base_url();?>assets/images/users/9.jpg"></span>
                                        <div>
                                            <strong>Sanderson</strong> New Schedule Realease......
                                            <div class="small text-muted">
                                                2 days ago
                                            </div>
                                        </div>
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <div class="text-center dropdown-btn pb-3">
                                        <div class="btn-list">
                                            <a href="#" class="btn btn-primary btn-sm"><i class="fe fe-plus mr-1"></i>Add New</a>
                                            <a href="#" class=" btn btn-secondary btn-sm"><i class="fe fe-eye mr-1"></i>View All</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown d-md-flex header-message">
                                <a class="nav-link icon text-dark" data-toggle="dropdown">
                                    <i class="fe fe-bell"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item text-center" href="#">Notifications</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item d-flex pb-4" href="#">
                                        <span class="avatar brround mr-3 align-self-center avatar-md cover-image bg-primary"><i class="fe fe-mail fs-12"></i></span>
                                        <div>
                                            <span class="font-weight-bold"> commented on your post </span>
                                            <div class="small text-muted d-flex">
                                                3 hours ago
                                                <div class="ml-auto">
                                                <span class="badge badge-primary">New</span>
                                                </div>
                                            </div>
                                            <div class="progress progress-xs mt-1">
                                                <div class="progress-bar bg-primary w-30"></div>
                                            </div>
                                        </div>
                                    </a>
                                    <a class="dropdown-item d-flex pb-4" href="#">
                                        <span class="avatar avatar-md brround mr-3 align-self-center cover-image bg-secondary"><i class="fe fe-download"></i>
                                        </span>
                                        <div>
                                            <span class="font-weight-bold"> New file has been Uploaded </span>
                                            <div class="small text-muted d-flex">
                                                5 hour ago
                                                <div class="ml-auto">
                                                <span class="badge badge-secondary">New</span>
                                                </div>
                                            </div>
                                            <div class="progress progress-xs mt-1">
                                                <div class="progress-bar bg-secondary w-50"></div>
                                            </div>
                                        </div>
                                    </a>
                                    <a class="dropdown-item d-flex pb-4" href="#">
                                        <span class="avatar avatar-md brround mr-3 align-self-center cover-image bg-warning"><i class="fe fe-user"></i>
                                        </span>
                                        <div>
                                            <span class="font-weight-bold"> User account has Updated</span>
                                            <div class="small text-muted d-flex">
                                                5 hour ago
                                                <div class="ml-auto">
                                                <span class="badge badge-warning">New</span>
                                                </div>
                                            </div>
                                            <div class="progress progress-xs mt-1">
                                                <div class="progress-bar bg-warning w-70"></div>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <div class="text-center dropdown-btn pb-3">
                                        <div class="btn-list">
                                            <a href="#" class="btn btn-primary btn-sm"><i class="fe fe-plus mr-1"></i>Add New</a>
                                            <a href="#" class=" btn btn-secondary btn-sm"><i class="fe fe-eye mr-1"></i>View All</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown d-md-flex header-message">
                                <a class="nav-link icon" data-toggle="dropdown">
                                    <i class="fe fe-grid"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item d-flex pb-3" href="left-menu.html">Icon Menu</a>
                                    <a class="dropdown-item d-flex pb-3" href="sidemenu.html">Icon Closed Menu</a>
                                    <a class="dropdown-item d-flex pb-3" href="overlay2.html">Icon Overlay Menu</a>
                                    <a class="dropdown-item d-flex pb-3" href="overlay.html">Closed Overlay Menu</a>
                                    <a class="dropdown-item d-flex pb-3" href="horizontal.html">Horizontal Menu</a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    $(document).ready(function()
					{
                        getNewOrders();
                       setInterval(function(){getNewOrders();}, 10000);
                    })
					
                    function getNewOrders()
					{
                        console.log("call to getNewOrders");
                        $.ajax({
                            type:"GET",
                            url:"<?=base_url();?>restaurant/getneworder",
                            success:function(response)
                            {
                                let res = JSON.parse(response);
                                let orders='';
								var count_website = 0;
                                var count_table_order=0;
                                if(res && res.success && res.data.length>0)
								{
                                    console.log("res.data",res.data);
                                    let oldOrderCount = $('.new-order-count').html();
                                    let oldCount = parseInt(oldOrderCount)?oldOrderCount:0;
                                    
									if(res.data.length != oldCount && oldCount !=0)
									{
                                        $(".new-order-count").animate({zoom: '150%'}, "slow").animate({zoom: '100%'}, "slow");
                                        /* var media = new Audio('https://testing.foodnai.com/admin/assets/neworder.mp3');
										media.play(); */
										/* document.getElementById('newordersound').play();
										document.getElementById('newordersound').muted = false; */
										 var beepOne = $("#newordersound")[0];
										beepOne.play();
                                    }
									
                                    $('.new-order-count').html(res.data.length);
                                    $('#new-order-count-inner').html(res.data.length);
                                    
                                    res.data.forEach(function(order)
									{
                                        if(order.order_type == 'Website'){
                                            count_website = parseInt(count_website) + 1;
                                        }
                                        if(order.order_type=='Online'){
                                            count_table_order = parseInt(count_table_order) + 1;
                                        }
                                        
										if(order.order_type=='Online')
										{
                                            var orderType = 1;
                                        }
										else if(order.order_type=='Website')
										{
											var orderType = 1;
										}
										else
										{
											var orderType = 0;
										}
                                        /* let orderType = order.order_type=="Online"?1:0; */
                                        orders += '<a class="dropdown-item d-flex pb-4" href="javascript:gotoOrder('+order.id+','+order.table_id+','+order.table_orders_id+','+orderType+');"><span class="avatar brround mr-3 align-self-center avatar-md cover-image bg-primary table-title">'+order.title+'</span><div><span class="font-weight-bold"> '+order.order_no+' | '+order.name+' </span><div class="small text-muted d-flex">'+moment(order.created_at).fromNow()+'<div class="ml-auto"><span class="badge badge-warning">New</span></div></div><div class="progress progress-xs mt-1"><div class="progress-bar bg-primary w-100"></div></div></div></a>';
                                    })
                                    $('.new-order-count2').html(count_website);
                                    $('.new-order-count1').html(count_table_order);
                                    
                                }

                                if(orders!='')
								{
                                    $('#new-order-container').html(orders);
                                }
								else
								{
                                    $('#new-order-container').html("No new orders available");
                                } 
                            }
                        });
                    }
					
                    function gotoOrder(order_id,table_id,table_orders_id,order_type)
					{
						debugger;
                        $.ajax({
                            type:"POST",
                            url:"<?=base_url();?>restaurant/updatevieworder",
                            data:{'order_id':order_id},
                            success:function(response)
                            {
								let res = JSON.parse(response);
								
                                if(res && res.success)
								{
                                   //    getNewOrders();
                                   if(order_type && order_type=='1')
								   {
										window.location.href='<?=base_url();?>restaurant/onlineorder/'+table_id+'/'+table_orders_id;
                                   }
								   else
								   {
										window.location.href='<?=base_url();?>restaurant/tablerecipe/'+table_id+'/'+table_orders_id;
                                   }                                    
                                }                               
                            }
                        });                       
                    }
				</script>

                <script>
                $('#select_languages').change(function(){
                    $.ajax({
                        url: "<?=base_url()?>restaurant/language_session",
                        type:'POST',
                        data:{language:$('#select_languages').val()} ,
                        success: function(result){
                            location.reload();
                        }
                    });
                });
                </script>

<script type="text/javascript">
            function googleTranslateElementInit() {
                new google.translate.TranslateElement({ pageLanguage: 'en', includedLanguages: 'en,el', multilanguagePage: true}, 'google_translate_element');
                $(".goog-logo-link").empty();
                $('.goog-te-gadget').html($('.goog-te-gadget').children());
                $('.goog-close-link').click();
                setTimeout(function(){
                    $('.goog-te-gadget .goog-te-combo').find('option:first-child').html('Translate');    
                }, 700);
            }
        </script>
        <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script> 

        <script async src="https://www.googletagmanager.com/gtag/js?id=G-8ZJNB18KS2"></script>