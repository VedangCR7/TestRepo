<?php include "connection.php";

 session_start();

 ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="YouCloudResto - Quality delivery or takeaway food">
    <meta name="author" content="Ansonika">
    <title>YouCloudResto - Quality delivery or takeaway food</title>

    <!-- Favicons-->
    <link rel="shortcut icon" href="<?= $root_url; ?>/website_assets/webAssets/img/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" type="image/x-icon" href="<?= $root_url; ?>/website_assets/webAssets/img/apple-touch-icon-57x57-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="<?= $root_url; ?>/website_assets/webAssets/img/apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="<?= $root_url; ?>/website_assets/webAssets/img/apple-touch-icon-114x114-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="<?= $root_url; ?>/website_assets/webAssets/img/apple-touch-icon-144x144-precomposed.png">

    <!-- GOOGLE WEB FONT -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- BASE CSS -->
    <link href="<?= $root_url; ?>/website_assets/webAssets/css/bootstrap_customized.min.css" rel="stylesheet">
    <link href="<?= $root_url; ?>/website_assets/webAssets/css/style.css" rel="stylesheet">

    <!-- SPECIFIC CSS -->
    <link href="<?= $root_url; ?>/website_assets/webAssets/css/home.css" rel="stylesheet">

    <!-- YOUR CUSTOM CSS -->
    <link href="<?= $root_url; ?>/website_assets/webAssets/css/custom.css" rel="stylesheet">
</head>

<body>
     
    <?php 

    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    ?>           
                    
    <header class="header_in clearfix <?php if(isset($actual_link) && $actual_link==$root_url."/index.php" || $actual_link==$root_url."/" ){  echo "position-absolute"; } ?>">
        <div class="container">
            <div id="logo">
                <a href="index.php">
                    <img src="<?= $root_url; ?>/website_assets/webAssets/img/logo_sticky.png" width="140" height="35" alt="">
                </a>
            </div>
            <div class="layer"></div> 
            <?php if(!empty($_SESSION['user_id'])){ ?>
             <ul id="top_menu" class="drop_user">
                <li>
                    <div class="dropdown user clearfix">
                        <a href="#" data-toggle="dropdown">
                            <figure><img src="<?php if($_SESSION['userr_profile_image']!==''){ echo $_SESSION['userr_profile_image'];  }else{ echo "website_assets/img/placeholder.jpg"; } ?>" alt=""></figure><span><?php echo $_SESSION['user_name'] ?></span>
                        </a>
                        <div class="dropdown-menu">
                            <div class="dropdown-menu-content">
                                <ul>
                                    <li><a href="account.php"><i class="icon_cog"></i>Dashboard</a></li>
                                    <li><a href="order.php"><i class="icon_document"></i>Bookings</a></li>
                                    <li><a href="favourite.php"><i class="icon_heart"></i>Wish List</a></li>
                                    <li><a href="logout.php"><i class="icon_key"></i>Log out</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- /dropdown -->
                </li>
            </ul>
        <?php } ?>
            <a href="#0" class="open_close">
                <i class="icon_menu"></i><span>Menu</span>
            </a>
            <nav class="main-menu">
                <div id="header_menu">
                    <a href="#0" class="open_close">
                        <i class="icon_close"></i><span>Menu</span>
                    </a>
                    <a href="index.php"><img src="<?= $root_url; ?>/website_assets/webAssets/img/logo.svg" width="162" height="35" alt=""></a>
                </div>
                <ul>
                    <li class="submenu">
                        <a href="index.php" class="show-submenu">Home</a>
                    </li>
                    <li><a href="help.php">Support</a></li>
                    <li><a href="blog.php">Blog</a></li>

                    <?php if(empty($_SESSION['user_id'])){ ?>

                   <li><a href="login.php">Account</a></li>
                <?php }else{ ?>
                    
                  <?php } ?>
                </ul>
               
            </nav>
        </div>
    </header>
    <!-- /header -->


    