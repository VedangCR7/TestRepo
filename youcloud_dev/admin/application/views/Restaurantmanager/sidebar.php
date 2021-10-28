<?php
//require_once('web_header.php');
?>
<!-- <link rel="stylesheet" href="<?=base_url()?>assets/plugins/fuzzycomplete/dist/css/fuzzycomplete.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700">

<script src="https://code.jquery.com/jquery-2.2.3.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/plugins/fuzzycomplete/fuse.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/plugins/fuzzycomplete/dist/js/fuzzycomplete.min.js" type="text/javascript"></script> -->
<!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> -->
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<!-- jQuery library -->
<style type="text/css">
  li{
    list-style-type:none;
  }
  .menuname{
    font-size:12px;
  }

  .sidenav {
  height: 100%;
  width: 0;
  position: fixed;
  z-index: 999999999999999999;
  top: 0;
  left: 0;
  background-color:white;
  overflow-x: hidden;
  transition: 0.5s;
  padding-top: 60px;
}

.sidenav a {
  padding: 8px 8px 8px 32px;
  text-decoration: none;
  font-size: 18px;
  color:black;
  display: block;
  transition: 0.3s;
}

.sidenav a:hover {
  color: #f1f1f1;
}

.sidenav .closebtn {
  position: absolute;
  top: 0;
  right: 25px;
  font-size: 36px;
  margin-left: 50px;
}

.resto-name {font-size:25px;}
@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}
@media screen and (max-width: 450px) {
  .resto-name {font-size:17px;}
}
</style>
<!-- Sidebar -->
<!-- <div class="w3-sidebar w3-bar-block" style="display:none;z-index:9999999" id="mySidebar">
  <button onclick="w3_close()" class="w3-bar-item w3-button w3-large" style="text-align:right;"><span style="background-color:red;color:white;padding:5px;">&times;</span></button>
  <a href="#" class="w3-bar-item w3-button">Take Order</a>
  <a href="#" class="w3-bar-item w3-button">New Order</a>
  <a href="#" class="w3-bar-item w3-button">Order History</a>
</div> -->
<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <a href="javascript:void(0)">
    <?php if ($profile[0]['profile_photo'] != 'assets/images/users/user.png' && $profile[0]['profile_photo'] != null) {?>
      <img src="<?=$profile[0]['profile_photo']?>" class="shadow-sm p-2 mb-2 span-profile-photo" style="height:80px;width:80px;border-radius:50%">
                      <?php } else{?>
    <img src="<?=base_url();?>assets/images/users/user.png" class="shadow-sm p-2 mb-2 span-profile-photo" style="height:80px;width:80px;border-radius:50%"><?php } ?>
  </a>
  <a href="<?=base_url('restaurant_managerorder/rest_manager_update_profile/')?>"><i class="fas fa-user"></i> Profile</a>
  <?php if ($_SESSION['usertype'] == 'Restaurant manager') {?>
  <a href="<?=base_url('restaurant_managerorder/take_order')?>"><i class="fas fa-pen-square"></i> Take Order</a>
  <a href="<?=base_url('restaurant_managerorder/order_history')?>"><i class="fas fa-utensils"></i> Order History</a><?php } ?>
  <?php if ($_SESSION['usertype'] == 'Waitinglist manager') {?>
  <a href="<?=base_url('waiting_manager/dashboard')?>"><i class="fas fa-tachometer-alt"></i> Dashboard</a><?php } ?>
  <a href="<?=base_url();?>restaurant_managerorder/rest_manager_change_password"><i class="fas fa-lock"></i> Change Password</a>
  <a href="<?=base_url();?>login/logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>


<script>
function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}
</script>