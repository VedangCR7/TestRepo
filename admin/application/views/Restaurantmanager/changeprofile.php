<?php
require_once('web_header.php');
require_once('sidebar.php');
?>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<style type="text/css">
  .footer{
    display:none;
  }
  #back-to-top{
    display:none;
  }
	body{
		background-color: #F3F3F3;
	}
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

.d-block{margin-left: 10px;}
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
<div class="menu-navigation" style="background: linear-gradient( 89.1deg,rgb(8,158,96) 0.7%,rgb(19,150,204) 88.4% );">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 mb-2">
                <div class="row">
                    <div class="col-1 p-1 text-center" style="margin-top:10px;"><span style="font-size:25px;cursor:pointer;color:white;" onclick="openNav()">&#9776;</span>
                    </div>
                    <div class="col-7 pl-4">
                      <h2 class="resto-name ml-2 text-white" style="margin-top:20px;"><b>Profile</b></h2>
                    </div>
					<div class="col-3 p-1" style="text-align: right;color:white;margin-top:10px;">
						<?=$_SESSION['name']?>
						<!-- <a href="<?=base_url()?>restaurant_managerorder/rest_manager_update_profile">
						  <?php if ($profile[0]['profile_photo'] != 'assets/images/users/user.png' && $profile[0]['profile_photo'] != null) {?>
							<img src="<?=$profile[0]['profile_photo']?>" class="shadow-sm" style="height:50px;width:50px;border-radius:50%">
						  <?php } else{?>
							<img src="<?=base_url();?>assets/images/users/user.png" class="shadow-sm" style="height:50px;width:50px;border-radius:50%"><?php } ?>
						</a>-->
                    </div>
                    <!--<div class="col-1">-->
						         <!--  <div class="google_lang_menu menu_details_translate">
            				    <div id=>"google_translate_element"></div>
        				      </div>-->
						        <!--</div>-->
                    <!--<div class="col-2 p-1">
						<!-- <a href="<?=base_url()?>restaurant_managerorder/take_order">
						  <?php if ($profile[0]['profile_photo'] != 'assets/images/users/user.png' && $profile[0]['profile_photo'] != null) {?>
							<img src="<?=$profile[0]['profile_photo']?>" class="shadow-sm span-profile-photo" style="height:50px;width:50px;border-radius:50%">
						  <?php } else{?>
							<img src="<?=base_url();?>assets/images/users/user.png" class="shadow-sm span-profile-photo" style="height:50px;width:50px;border-radius:50%"><?php } ?>
						</a> -->
                    <!--</div>-->
                </div>
               <!--  <div class="text-white">
                   <div class="title d-flex align-items-center">
                     
                   </div>
                </div> -->
             </div>
        </div>
    </div>
</div>

<?php
require_once('header.php');
//require_once('sidebar.php');

?>
<link rel="stylesheet" href="<?=base_url();?>assets/plugins/resize/jquery.Jcrop.min.css" type="text/css" />
<script src="<?=base_url();?>assets/plugins/resize/jquery.min.js"></script>
<script src="<?=base_url();?>assets/plugins/resize/jquery.Jcrop.min.js"></script>
<style>
hr{
  margin-top: 1rem!important;
  margin-bottom: 1rem!important;
}

#OpenImgUpload, #printBtn{
  margin-top: 3px!important;
}

.print-section{
  display:none;
}
.widget-user .widget-user-image>img{
  height:121.49px;
}
 @media print {
  .print-section {display:block}
  .btn-print {display:none;}
  .side-app {display:none;}
  .noPrint-section {display:none;}
  .app-content {display:none;}
  
}
.widget-user-image canvas{
  max-width: 100%;
  height: 200px;
  border: 3px solid #fff;
  border-radius: 50% !important;
  background: #fff;
}
.jcrop-holder{
  max-width: 100% !important;
}

.jcrop-holder img:last-child{
  max-width: 100% !important;
}
/* @media print {  
  @page {
    size: 297mm 210mm; 
  }
} */
</style>
<div class="print-section"><br><br><center>
  <h1 style="color:#34a543!important;font-size:3.5rem;">Zero Touch Menu</h1>
  <h2 style="font-size:3.3rem;" class="span-business_name"><?=$user['business_name'];?></h2>
  <div class="media mt-1 pb-2" style="justify-content: center;">
    <img src="<?=base_url().$user['img_url'];?>" style="width: 416px;height: 421px;">
  </div>
  <h5 style="font-size:39px!important; font-weight: normal;">Point your camera here <br>to access our menu instantly</h5>
  <div class="widget-user-image"><img alt="FoodNAI Restaurant" class="span-profile-photo" src="<?=base_url().'assets/images/brand/FoodNAILoginLogo.png';?>" width="325px"></div><br>
  <h6 style="color:#34a543d9!important; font-size:39px!important;font-weight: normal;">www.foodnai.com</h6></center>
</div>
<div class="container">
  <div class="row" style="margin-top:100px;">
    <div class="col-xl-3  col-md-6">
      <div class="card box-widget widget-user">
        <div class="widget-user-header bg-gradient-primary"></div>
        <div class="widget-user-image">
          <?php
            if($user['profile_photo']=="assets/images/users/user.png"){
          ?>
            <img id="cropped_img" for="input" alt="User Avatar" class="rounded-circle span-profile-photo" src="<?=base_url().$user['profile_photo'];?>">
          <?php
            }
            else{
          ?>
            <img id="cropped_img" for="input" alt="User Avatar" class="rounded-circle span-profile-photo" src="<?=$user['profile_photo'];?>">
          <?php
            }
          ?>
        </div>
        <div class="card-body text-center">
          <div class="pro-user">
            <h3 class="pro-user-username text-dark span-name">
              <?=$user['name'];?></h3>

            <!--<h6 class="pro-user-desc text-muted input-editname span-business_name" ><?=$user['business_name'];?></h6>-->
            <input type="text" name="designation" class="form-control text-center input-edit-designation input-editname" value="Web Developer" style="display: none;">
            <input type="file" id="imgupload" accept="image/png, image/jpeg" style="display: none;"/> 
            <a href="javascript:;" class="btn btn-primary btn-sm a-edit-name input-editname" id="OpenImgUpload" ><i class="si si-picture mr-1"></i>Browse</a>
            <span class="error"></span>
          </div>

        </div>
        <div class="card-footer p-0">
          <!-- <div class="row">
            <div class="col-sm-12 text-center pro-user mb-5">
              <div class="pro-user-icons">
              <a href="#" class="facebook-bg mt-0"><i class="fab fa-facebook"></i></a>
              <a href="#" class="twitter-bg"><i class="fab fa-twitter"></i></a>
              <a href="#" class="linkedin-bg"><i class="fab fa-linkedin"></i></a>
            </div>
            </div>
            
          </div> -->
        </div>
      </div>
    </div>
    <div class="col-xl-9  col-md-6 noPrint-section">
      <div class="card">
        <div class="pri-header">
          <h3 class="mr-1 mb-0">Personal Info
            <a href="javascript:;" class="btn btn-primary btn-sm a-edit-profile" style="float: right;">
              <span class="a-text"><i class="si si-pencil mr-1"></i>Edit</span>
            </a>
            <a href="javascript:;" class="btn btn-primary btn-sm a-save-profile" style="float: right;display: none;">
              <span class="a-text" ></i>Save</span>
            </a>
          </h3>
          
        </div>
        <div class="card-body">
          <div class="row mt-6 mb-6 row-view-profile">
            <div class="col-md-6 pr-5">
              <div class="media-list">
                
                <div class="media mt-1 pb-2">
                  <div class="mediaicon">
                    <i class="si si-user" aria-hidden="true"></i>
                  </div>
                  <div class="media-body ml-5 mt-1">
                    <h6 class="mediafont text-dark mb-1">Full Name
                      
                    </h6><span class="d-block span-name"><?=$user['name'];?></span>

                  </div>
                </div>
                <div class="media mt-1 pb-2">
                  <div class="mediaicon">
                    <i class="si si-envelope" aria-hidden="true"></i>
                  </div>
                  <div class="media-body ml-5 mt-1">
                    <h6 class="mediafont text-dark mb-1">Email Address
                      
                    </h6><span class="d-block span-email"><?=$user['email'];?></span>
                  </div>
                </div>
                <?php if ($_SESSION['usertype'] != 'Restaurant manager' && $_SESSION['usertype'] != 'Waitinglist manager') { ?>
                <div class="media mt-1 pb-2">
                  <div class="mediaicon">
                    <i class="si si-location-pin" aria-hidden="true"></i>
                  </div>
                  <div class="media-body ml-5 mt-1">
                    <h6 class="mediafont text-dark mb-1">Business Name
                      
                    </h6><span class="d-block span-business_name"><?=$user['business_name'];?></span>
                  </div>
                </div><?php } ?>
                <div class="media mt-1 pb-2">
                  <div class="mediaicon">
                    <i class="si si-phone" aria-hidden="true"></i>
                  </div>
                  <div class="media-body ml-5 mt-1">
                    <h6 class="mediafont text-dark mb-1">Contact Number
                    
                  </h6><?php if ($_SESSION['usertype'] != 'Restaurant manager' && $_SESSION['usertype'] != 'Waitinglist manager') { ?><span class="d-block span-countrycode" style="float: left;margin-right: 3px;">+<?=$user['countrycode'];?></span><?php } ?><span class="d-block span-contact_number"><?=$user['contact_number'];?></span>
                  </div>
                </div>
                <?php if ($_SESSION['usertype'] != 'Restaurant manager' && $_SESSION['usertype'] != 'Waitinglist manager') { ?>
                <div class="media mt-1 pb-2">
                  <div class="mediaicon">
                    <i class="si si-link" aria-hidden="true"></i>
                  </div>
                  <div class="media-body ml-5 mt-1">
                    <h6 class="mediafont text-dark mb-1">Link To Menu Details</h6>
                    <span class="d-block span-profile-link"><a href="https://foodnai.com/restaurant/<?=$user['name'];?>" target="_blank" style="color:#000;">https://foodnai.com/restaurant/<?=$user['name'];?></a></span>

                  </div>
                </div><?php } ?>
              </div>
            </div>
            <div class="col-md-6 pl-3">
              <div class="media-list">
                
                <div class="media mt-1 pb-2">
                  <div class="mediaicon">
                    <i class="si si-book-open" aria-hidden="true"></i>
                  </div>
                  <div class="media-body ml-5 mt-1">
                    <h6 class="mediafont text-dark mb-1">Address
                    
                  </h6><span class="d-block span-address"><?=$user['address'];?></span>
                  </div>
                </div>
                <div class="media mt-1 pb-2">
                  <div class="mediaicon">
                    <i class="si si-book-open" aria-hidden="true"></i>
                  </div>
                  <div class="media-body ml-5 mt-1">
                    <h6 class="mediafont text-dark mb-1">City
                    
                  </h6><span class="d-block span-city"><?=$user['city'];?></span>
                  </div>
                </div>
                <div class="media mt-1 pb-2">
                  <div class="mediaicon">
                    <i class="si si-book-open" aria-hidden="true"></i>
                  </div>
                  <div class="media-body ml-5 mt-1">
                    <h6 class="mediafont text-dark mb-1">Country
                    
                  </h6><span class="d-block span-country"><?=$user['country'];?></span>
                  </div>
                </div>
                <div class="media mt-1 pb-2">
                  <div class="mediaicon">
                    <i class="si si-graduation" aria-hidden="true"></i>
                  </div>
                  <div class="media-body ml-5 mt-1">
                    <h6 class="mediafont text-dark mb-1">Postal Code
                    
                  </h6><span class="d-block span-postcode"><?=$user['postcode'];?></span>
                  </div>
                </div>
                <div class="admSelectCheck media mt-1 pb-2">
                  <div class="mediaicon">
                    <i class="si si-graduation" aria-hidden="true"></i>
                  </div>
                  <div class="media-body ml-5 mt-1">
                    <h6 class="mediafont text-dark mb-1">Restaurant Type
                    
                  </h6><span class="d-block span-restauranttype">
                    <?php
                      $restaurant_type=$user['restauranttype'];
                      if($restaurant_type=="veg")
                        echo "Veg";
                      else if($restaurant_type=="nonveg")
                        echo "Non-veg";
                      else if($restaurant_type=="both")
                        echo "Veg / Non-veg";
                    ?>
                      
                    </span>
                  </div>
                </div>
              </div>
            </div>
            
          </div>
          
          <form id="form-user" method="post" action="javascript:;">
            <input type="hidden" name="id" value="<?=$user['id'];?>">
            <div class="row mt-6 mb-6 row-edit-profile" style="display: none;">
              <div class="col-md-6 pr-5">
                <div class="media-list">
                  <div class="media mt-1 pb-2">
                    <div class="mediaicon">
                      <i class="si si-user" aria-hidden="true"></i>
                    </div>
                    <div class="media-body ml-5 mt-1">
                      <h6 class="mediafont text-dark mb-1">Full Name <span >(*)</span>
                      </h6>
                      <input type="text" name="name" class="form-control"  value="<?=$user['name'];?>" placeholder=" Name" maxlength="100">
                      <!-- <input type="text" name="last_name" class="form-control"value="<?=$user['last_name'];?>" style="width: 50%;" placeholder="Last Name"> -->
                    </div>
                  </div>
                  <div class="media mt-1 pb-2">
                    <div class="mediaicon">
                      <i class="si si-envelope" aria-hidden="true"></i>
                    </div>
                    <div class="media-body ml-5 mt-1">
                      <h6 class="mediafont text-dark mb-1">Email Address <span >(*)</span>
                        
                      </h6>
                      <input type="text" name="email" class="form-control" value="<?=$user['email'];?>" maxlength="50" disabled="">
                    </div>
                  </div>
                  <?php if ($_SESSION['usertype'] != 'Restaurant manager' && $_SESSION['usertype'] != 'Waitinglist manager') { ?>
                  <div class="media mt-1 pb-2">
                    <div class="mediaicon">
                      <i class="si si-location-pin" aria-hidden="true"></i>
                    </div>
                    <div class="media-body ml-5 mt-1">
                      <h6 class="mediafont text-dark mb-1">Business Name <span >(*)</span>
                      </h6>
                      <input type="text" name="business_name" class="form-control" value="<?=$user['business_name'];?>">
                    </div>
                  </div><?php } ?>
                  <div class="media mt-1 pb-2">
                    <div class="mediaicon">
                      <i class="si si-phone" aria-hidden="true"></i>
                    </div>
                    <div class="media-body ml-5 mt-1">
                      <h6 class="mediafont text-dark mb-1">Contact Number <span >(*)</span></h6>
                      <div class="row">
                        <?php if ($_SESSION['usertype'] != 'Restaurant manager' && $_SESSION['usertype'] != 'Waitinglist manager') {?>
                        <div class="col-md-4">
                          <select class="form-control select2-show-search" name="countrycode" id="" selected-value="<?=$user['countrycode'];?>">
                            <option data-countryCode="GB" value="44" >UK (+44)</option>
                            <option data-countryCode="US" value="1">USA (+1)</option>
                            <option data-countryCode="IN" value="91">India (+91)</option>
                            <optgroup label="Other countries">
                              <option data-countryCode="DZ" value="213">Algeria (+213)</option>
                              <option data-countryCode="AD" value="376">Andorra (+376)</option>
                              <option data-countryCode="AO" value="244">Angola (+244)</option>
                              <option data-countryCode="AI" value="1264">Anguilla (+1264)</option>
                              <option data-countryCode="AG" value="1268">Antigua &amp; Barbuda (+1268)</option>
                              <option data-countryCode="AR" value="54">Argentina (+54)</option>
                              <option data-countryCode="AM" value="374">Armenia (+374)</option>
                              <option data-countryCode="AW" value="297">Aruba (+297)</option>
                              <option data-countryCode="AU" value="61">Australia (+61)</option>
                              <option data-countryCode="AT" value="43">Austria (+43)</option>
                              <option data-countryCode="AZ" value="994">Azerbaijan (+994)</option>
                              <option data-countryCode="BS" value="1242">Bahamas (+1242)</option>
                              <option data-countryCode="BH" value="973">Bahrain (+973)</option>
                              <option data-countryCode="BD" value="880">Bangladesh (+880)</option>
                              <option data-countryCode="BB" value="1246">Barbados (+1246)</option>
                              <option data-countryCode="BY" value="375">Belarus (+375)</option>
                              <option data-countryCode="BE" value="32">Belgium (+32)</option>
                              <option data-countryCode="BZ" value="501">Belize (+501)</option>
                              <option data-countryCode="BJ" value="229">Benin (+229)</option>
                              <option data-countryCode="BM" value="1441">Bermuda (+1441)</option>
                              <option data-countryCode="BT" value="975">Bhutan (+975)</option>
                              <option data-countryCode="BO" value="591">Bolivia (+591)</option>
                              <option data-countryCode="BA" value="387">Bosnia Herzegovina (+387)</option>
                              <option data-countryCode="BW" value="267">Botswana (+267)</option>
                              <option data-countryCode="BR" value="55">Brazil (+55)</option>
                              <option data-countryCode="BN" value="673">Brunei (+673)</option>
                              <option data-countryCode="BG" value="359">Bulgaria (+359)</option>
                              <option data-countryCode="BF" value="226">Burkina Faso (+226)</option>
                              <option data-countryCode="BI" value="257">Burundi (+257)</option>
                              <option data-countryCode="KH" value="855">Cambodia (+855)</option>
                              <option data-countryCode="CM" value="237">Cameroon (+237)</option>
                              <option data-countryCode="CA" value="1">Canada (+1)</option>
                              <option data-countryCode="CV" value="238">Cape Verde Islands (+238)</option>
                              <option data-countryCode="KY" value="1345">Cayman Islands (+1345)</option>
                              <option data-countryCode="CF" value="236">Central African Republic (+236)</option>
                              <option data-countryCode="CL" value="56">Chile (+56)</option>
                              <option data-countryCode="CN" value="86">China (+86)</option>
                              <option data-countryCode="CO" value="57">Colombia (+57)</option>
                              <option data-countryCode="KM" value="269">Comoros (+269)</option>
                              <option data-countryCode="CG" value="242">Congo (+242)</option>
                              <option data-countryCode="CK" value="682">Cook Islands (+682)</option>
                              <option data-countryCode="CR" value="506">Costa Rica (+506)</option>
                              <option data-countryCode="HR" value="385">Croatia (+385)</option>
                              <option data-countryCode="CU" value="53">Cuba (+53)</option>
                              <option data-countryCode="CY" value="90392">Cyprus North (+90392)</option>
                              <option data-countryCode="CY" value="357">Cyprus South (+357)</option>
                              <option data-countryCode="CZ" value="42">Czech Republic (+42)</option>
                              <option data-countryCode="DK" value="45">Denmark (+45)</option>
                              <option data-countryCode="DJ" value="253">Djibouti (+253)</option>
                              <option data-countryCode="DM" value="1809">Dominica (+1809)</option>
                              <option data-countryCode="DO" value="1809">Dominican Republic (+1809)</option>
                              <option data-countryCode="EC" value="593">Ecuador (+593)</option>
                              <option data-countryCode="EG" value="20">Egypt (+20)</option>
                              <option data-countryCode="SV" value="503">El Salvador (+503)</option>
                              <option data-countryCode="GQ" value="240">Equatorial Guinea (+240)</option>
                              <option data-countryCode="ER" value="291">Eritrea (+291)</option>
                              <option data-countryCode="EE" value="372">Estonia (+372)</option>
                              <option data-countryCode="ET" value="251">Ethiopia (+251)</option>
                              <option data-countryCode="FK" value="500">Falkland Islands (+500)</option>
                              <option data-countryCode="FO" value="298">Faroe Islands (+298)</option>
                              <option data-countryCode="FJ" value="679">Fiji (+679)</option>
                              <option data-countryCode="FI" value="358">Finland (+358)</option>
                              <option data-countryCode="FR" value="33">France (+33)</option>
                              <option data-countryCode="GF" value="594">French Guiana (+594)</option>
                              <option data-countryCode="PF" value="689">French Polynesia (+689)</option>
                              <option data-countryCode="GA" value="241">Gabon (+241)</option>
                              <option data-countryCode="GM" value="220">Gambia (+220)</option>
                              <option data-countryCode="GE" value="7880">Georgia (+7880)</option>
                              <option data-countryCode="DE" value="49">Germany (+49)</option>
                              <option data-countryCode="GH" value="233">Ghana (+233)</option>
                              <option data-countryCode="GI" value="350">Gibraltar (+350)</option>
                              <option data-countryCode="GR" value="30">Greece (+30)</option>
                              <option data-countryCode="GL" value="299">Greenland (+299)</option>
                              <option data-countryCode="GD" value="1473">Grenada (+1473)</option>
                              <option data-countryCode="GP" value="590">Guadeloupe (+590)</option>
                              <option data-countryCode="GU" value="671">Guam (+671)</option>
                              <option data-countryCode="GT" value="502">Guatemala (+502)</option>
                              <option data-countryCode="GN" value="224">Guinea (+224)</option>
                              <option data-countryCode="GW" value="245">Guinea - Bissau (+245)</option>
                              <option data-countryCode="GY" value="592">Guyana (+592)</option>
                              <option data-countryCode="HT" value="509">Haiti (+509)</option>
                              <option data-countryCode="HN" value="504">Honduras (+504)</option>
                              <option data-countryCode="HK" value="852">Hong Kong (+852)</option>
                              <option data-countryCode="HU" value="36">Hungary (+36)</option>
                              <option data-countryCode="IS" value="354">Iceland (+354)</option>
                              
                              <option data-countryCode="ID" value="62">Indonesia (+62)</option>
                              <option data-countryCode="IR" value="98">Iran (+98)</option>
                              <option data-countryCode="IQ" value="964">Iraq (+964)</option>
                              <option data-countryCode="IE" value="353">Ireland (+353)</option>
                              <option data-countryCode="IL" value="972">Israel (+972)</option>
                              <option data-countryCode="IT" value="39">Italy (+39)</option>
                              <option data-countryCode="JM" value="1876">Jamaica (+1876)</option>
                              <option data-countryCode="JP" value="81">Japan (+81)</option>
                              <option data-countryCode="JO" value="962">Jordan (+962)</option>
                              <option data-countryCode="KZ" value="7">Kazakhstan (+7)</option>
                              <option data-countryCode="KE" value="254">Kenya (+254)</option>
                              <option data-countryCode="KI" value="686">Kiribati (+686)</option>
                              <option data-countryCode="KP" value="850">Korea North (+850)</option>
                              <option data-countryCode="KR" value="82">Korea South (+82)</option>
                              <option data-countryCode="KW" value="965">Kuwait (+965)</option>
                              <option data-countryCode="KG" value="996">Kyrgyzstan (+996)</option>
                              <option data-countryCode="LA" value="856">Laos (+856)</option>
                              <option data-countryCode="LV" value="371">Latvia (+371)</option>
                              <option data-countryCode="LB" value="961">Lebanon (+961)</option>
                              <option data-countryCode="LS" value="266">Lesotho (+266)</option>
                              <option data-countryCode="LR" value="231">Liberia (+231)</option>
                              <option data-countryCode="LY" value="218">Libya (+218)</option>
                              <option data-countryCode="LI" value="417">Liechtenstein (+417)</option>
                              <option data-countryCode="LT" value="370">Lithuania (+370)</option>
                              <option data-countryCode="LU" value="352">Luxembourg (+352)</option>
                              <option data-countryCode="MO" value="853">Macao (+853)</option>
                              <option data-countryCode="MK" value="389">Macedonia (+389)</option>
                              <option data-countryCode="MG" value="261">Madagascar (+261)</option>
                              <option data-countryCode="MW" value="265">Malawi (+265)</option>
                              <option data-countryCode="MY" value="60">Malaysia (+60)</option>
                              <option data-countryCode="MV" value="960">Maldives (+960)</option>
                              <option data-countryCode="ML" value="223">Mali (+223)</option>
                              <option data-countryCode="MT" value="356">Malta (+356)</option>
                              <option data-countryCode="MH" value="692">Marshall Islands (+692)</option>
                              <option data-countryCode="MQ" value="596">Martinique (+596)</option>
                              <option data-countryCode="MR" value="222">Mauritania (+222)</option>
                              <option data-countryCode="YT" value="269">Mayotte (+269)</option>
                              <option data-countryCode="MX" value="52">Mexico (+52)</option>
                              <option data-countryCode="FM" value="691">Micronesia (+691)</option>
                              <option data-countryCode="MD" value="373">Moldova (+373)</option>
                              <option data-countryCode="MC" value="377">Monaco (+377)</option>
                              <option data-countryCode="MN" value="976">Mongolia (+976)</option>
                              <option data-countryCode="MS" value="1664">Montserrat (+1664)</option>
                              <option data-countryCode="MA" value="212">Morocco (+212)</option>
                              <option data-countryCode="MZ" value="258">Mozambique (+258)</option>
                              <option data-countryCode="MN" value="95">Myanmar (+95)</option>
                              <option data-countryCode="NA" value="264">Namibia (+264)</option>
                              <option data-countryCode="NR" value="674">Nauru (+674)</option>
                              <option data-countryCode="NP" value="977">Nepal (+977)</option>
                              <option data-countryCode="NL" value="31">Netherlands (+31)</option>
                              <option data-countryCode="NC" value="687">New Caledonia (+687)</option>
                              <option data-countryCode="NZ" value="64">New Zealand (+64)</option>
                              <option data-countryCode="NI" value="505">Nicaragua (+505)</option>
                              <option data-countryCode="NE" value="227">Niger (+227)</option>
                              <option data-countryCode="NG" value="234">Nigeria (+234)</option>
                              <option data-countryCode="NU" value="683">Niue (+683)</option>
                              <option data-countryCode="NF" value="672">Norfolk Islands (+672)</option>
                              <option data-countryCode="NP" value="670">Northern Marianas (+670)</option>
                              <option data-countryCode="NO" value="47">Norway (+47)</option>
                              <option data-countryCode="OM" value="968">Oman (+968)</option>
                              <option data-countryCode="PW" value="680">Palau (+680)</option>
                              <option data-countryCode="PA" value="507">Panama (+507)</option>
                              <option data-countryCode="PG" value="675">Papua New Guinea (+675)</option>
                              <option data-countryCode="PY" value="595">Paraguay (+595)</option>
                              <option data-countryCode="PE" value="51">Peru (+51)</option>
                              <option data-countryCode="PH" value="63">Philippines (+63)</option>
                              <option data-countryCode="PL" value="48">Poland (+48)</option>
                              <option data-countryCode="PT" value="351">Portugal (+351)</option>
                              <option data-countryCode="PR" value="1787">Puerto Rico (+1787)</option>
                              <option data-countryCode="QA" value="974">Qatar (+974)</option>
                              <option data-countryCode="RE" value="262">Reunion (+262)</option>
                              <option data-countryCode="RO" value="40">Romania (+40)</option>
                              <option data-countryCode="RU" value="7">Russia (+7)</option>
                              <option data-countryCode="RW" value="250">Rwanda (+250)</option>
                              <option data-countryCode="SM" value="378">San Marino (+378)</option>
                              <option data-countryCode="ST" value="239">Sao Tome &amp; Principe (+239)</option>
                              <option data-countryCode="SA" value="966">Saudi Arabia (+966)</option>
                              <option data-countryCode="SN" value="221">Senegal (+221)</option>
                              <option data-countryCode="CS" value="381">Serbia (+381)</option>
                              <option data-countryCode="SC" value="248">Seychelles (+248)</option>
                              <option data-countryCode="SL" value="232">Sierra Leone (+232)</option>
                              <option data-countryCode="SG" value="65">Singapore (+65)</option>
                              <option data-countryCode="SK" value="421">Slovak Republic (+421)</option>
                              <option data-countryCode="SI" value="386">Slovenia (+386)</option>
                              <option data-countryCode="SB" value="677">Solomon Islands (+677)</option>
                              <option data-countryCode="SO" value="252">Somalia (+252)</option>
                              <option data-countryCode="ZA" value="27">South Africa (+27)</option>
                              <option data-countryCode="ES" value="34">Spain (+34)</option>
                              <option data-countryCode="LK" value="94">Sri Lanka (+94)</option>
                              <option data-countryCode="SH" value="290">St. Helena (+290)</option>
                              <option data-countryCode="KN" value="1869">St. Kitts (+1869)</option>
                              <option data-countryCode="SC" value="1758">St. Lucia (+1758)</option>
                              <option data-countryCode="SD" value="249">Sudan (+249)</option>
                              <option data-countryCode="SR" value="597">Suriname (+597)</option>
                              <option data-countryCode="SZ" value="268">Swaziland (+268)</option>
                              <option data-countryCode="SE" value="46">Sweden (+46)</option>
                              <option data-countryCode="CH" value="41">Switzerland (+41)</option>
                              <option data-countryCode="SI" value="963">Syria (+963)</option>
                              <option data-countryCode="TW" value="886">Taiwan (+886)</option>
                              <option data-countryCode="TJ" value="7">Tajikstan (+7)</option>
                              <option data-countryCode="TH" value="66">Thailand (+66)</option>
                              <option data-countryCode="TG" value="228">Togo (+228)</option>
                              <option data-countryCode="TO" value="676">Tonga (+676)</option>
                              <option data-countryCode="TT" value="1868">Trinidad &amp; Tobago (+1868)</option>
                              <option data-countryCode="TN" value="216">Tunisia (+216)</option>
                              <option data-countryCode="TR" value="90">Turkey (+90)</option>
                              <option data-countryCode="TM" value="7">Turkmenistan (+7)</option>
                              <option data-countryCode="TM" value="993">Turkmenistan (+993)</option>
                              <option data-countryCode="TC" value="1649">Turks &amp; Caicos Islands (+1649)</option>
                              <option data-countryCode="TV" value="688">Tuvalu (+688)</option>
                              <option data-countryCode="UG" value="256">Uganda (+256)</option>
                              <!-- <option data-countryCode="GB" value="44">UK (+44)</option> -->
                              <option data-countryCode="UA" value="380">Ukraine (+380)</option>
                              <option data-countryCode="AE" value="971">United Arab Emirates (+971)</option>
                              <option data-countryCode="UY" value="598">Uruguay (+598)</option>
                              <!-- <option data-countryCode="US" value="1">USA (+1)</option> -->
                              <option data-countryCode="UZ" value="7">Uzbekistan (+7)</option>
                              <option data-countryCode="VU" value="678">Vanuatu (+678)</option>
                              <option data-countryCode="VA" value="379">Vatican City (+379)</option>
                              <option data-countryCode="VE" value="58">Venezuela (+58)</option>
                              <option data-countryCode="VN" value="84">Vietnam (+84)</option>
                              <option data-countryCode="VG" value="84">Virgin Islands - British (+1284)</option>
                              <option data-countryCode="VI" value="84">Virgin Islands - US (+1340)</option>
                              <option data-countryCode="WF" value="681">Wallis &amp; Futuna (+681)</option>
                              <option data-countryCode="YE" value="969">Yemen (North)(+969)</option>
                              <option data-countryCode="YE" value="967">Yemen (South)(+967)</option>
                              <option data-countryCode="ZM" value="260">Zambia (+260)</option>
                              <option data-countryCode="ZW" value="263">Zimbabwe (+263)</option>
                            </optgroup>
                          </select>
                        </div>
                        <div class="col-md-8">
                          <input type="text" name="contact_number" class="form-control contact" value="<?=$user['contact_number'];?>" minlength="8" maxlength="14" id="input-contact-number" style="height: 38px;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                        </div><?php } else {?>
                        <div class="col-md-12">
                          <input type="text" name="contact_number" class="form-control contact" value="<?=$user['contact_number'];?>" minlength="8" maxlength="14" id="input-contact-number" style="height: 38px;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                          <input type="hidden" name="" id="get_user_type" value="<?=$_SESSION['usertype']?>">
                        </div><?php } ?>
                      </div>
                    </div>
                  </div>
                  <?php if ($_SESSION['usertype'] != 'Restaurant manager' && $_SESSION['usertype'] != 'Waitinglist manager') { ?>
                  <div class="media-list">
                    <div class="media mt-1 pb-2">
                      <div class="mediaicon">
                        <i class="si si-link" aria-hidden="true"></i>
                      </div>
                      <div class="media-body ml-5 mt-1">
                        <h6 class="mediafont text-dark mb-1">Link To Menu Details <span ></span>
                        </h6>
                        <input type="text" name="menu_details" class="form-control" value="https://foodnai.com/restaurant/<?=$user['name'];?>" disabled="">
                      </div>
                    </div>
                  </div>
                  <?php } ?>
                </div>
              </div>
              <div class="col-md-6 pl-3">
                <div class="media-list">
                  <div class="media mt-1 pb-2">
                    <div class="mediaicon">
                      <i class="si si-book-open" aria-hidden="true"></i>
                    </div>
                    <div class="media-body ml-5 mt-1">
                      <h6 class="mediafont text-dark mb-1">Address
                      
                    </h6>
                    <input type="text" name="address" class="form-control" value="<?=$user['address'];?>">
                    </div>
                  </div>
                  <div class="media mt-1 pb-2">
                    <div class="mediaicon">
                      <i class="si si-book-open" aria-hidden="true"></i>
                    </div>
                    <div class="media-body ml-5 mt-1">
                      <h6 class="mediafont text-dark mb-1">City
                      
                    </h6>
                    <input type="text" name="city" class="form-control" value="<?=$user['city'];?>">
                    </div>
                  </div>
                  <div class="media mt-1 pb-2">
                    <div class="mediaicon">
                      <i class="si si-book-open" aria-hidden="true"></i>
                    </div>
                    <div class="media-body ml-5 mt-1">
                      <h6 class="mediafont text-dark mb-1">Country
                      
                    </h6>
                    <input type="text" name="country" class="form-control" value="<?=$user['country'];?>">
                    </div>
                  </div>
                  <div class="media mt-1 pb-2">
                    <div class="mediaicon">
                      <i class="si si-graduation" aria-hidden="true"></i>
                    </div>
                    <div class="media-body ml-5 mt-1">
                      <h6 class="mediafont text-dark mb-1">Postal Code
                      
                    </h6>
                    <input type="text" name="postcode" class="form-control" value="<?=$user['postcode'];?>">

                    </div>
                  </div>
                  <?php if ($_SESSION['usertype'] != 'Restaurant manager' && $_SESSION['usertype'] != 'Waitinglist manager') { ?>
                  <div class="admSelectCheck media mt-1 pb-2">
                    <div class="mediaicon">
                      <i class="si si-graduation" aria-hidden="true"></i>
                    </div>
                    <div class="media-body ml-5 mt-1">
                      <h6 class="mediafont text-dark mb-1">Restaurant Type
                      
                    </h6>
                    <select class="form-control" id="restauranttype" name="restauranttype" placeholder="Restaurant Type" required="" selected-value="<?=$user['restauranttype'];?>">
                      <option value="">Select restaurant type</option>
                      <option value="veg" <?php ($user['restauranttype']=="veg") ? 'selected' : ''; ?>>Veg</option>
                      <option value="nonveg" <?php ($user['restauranttype']=="nonveg") ? 'selected' : ''; ?>>Non-veg</option>
                      <option value="both" <?php ($user['restauranttype']=="both") ? 'selected' : ''; ?>>Veg / Non-veg</option>
                    </select>
                    <script type="text/javascript">
                      
                    </script>
                    </div>
                  </div><?php } ?>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
<div class="modal fade" id="modal-imagepreview" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="post" action="javascript:;">
        <img src="<?=base_url();?>assets/plugins/resize/original-image.jpeg" id="cropbox" class="img" style="width: 100% !important;"/><br />
        <button type="button" class="btn btn-success" id="crop" value='CROP' style="float: right;margin-bottom: 10px;margin-right: 10px;">Crop</button>
      </form>
    </div>
  </div>
</div>
<?php
require_once('footer.php');
?>

<script type="text/javascript">
  
  var usertype="<?=$usertype;?>";
  var restauranttype="<?=$user['restauranttype']?>";
  if(restauranttype){
    $('#restauranttype').val(restauranttype);
  }
  if(usertype=="Restaurant" || usertype=="Burger and Sandwich"){
    $('.admSelectCheck').show();
  }
  else{
    $('.admSelectCheck').hide();
  }
    $('.select2-show-search').select2({
      minimumResultsForSearch: ''
    });
  $('.select2-show-search').val($(".select2-show-search").attr('selected-value')).trigger('change');
  //$(".select2-show-search").select2("val", $(".select2-show-search").attr('selected-value'));
  $('.contact').on('keypress',function(e){
            var regex = new RegExp("^[0-9]+$");
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
            if (regex.test(str)) {
                return true;
            }
            e.preventDefault();
            return false;
        });
  $(".a-edit-profile").click(function(){
    $(this).toggle();
    $('.a-save-profile').toggle();

    $(".row-edit-profile").toggle();
    $(".row-view-profile").toggle();
  });
  $('#OpenImgUpload').click(function(){ $('#imgupload').trigger('click'); });
  var size;
  function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#cropbox').attr('src', e.target.result);
                $('#cropbox').Jcrop({
                aspectRatio: 1,
                show: true,
            minSize: [100, 100], 
              maxSize: [300, 300],  
          /*minSize: [90, 90],   
              maxSize: [90, 90], */
            keyboard: false,
            backdrop: 'static',
              onSelect: function(c){
                 size = {x:c.x,y:c.y,w:c.w,h:c.h};   
                 $("#crop").css("visibility", "visible");  
              }
            });
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#crop").click(function(){
      $('#modal-imagepreview').modal('hide');
        var img = $("#cropbox").attr('src');
        $("#cropped_img").show();
        /*$("#cropped_img").attr('src','image-crop.php?x='+size.x+'&y='+size.y+'&w='+size.w+'&h='+size.h+'&img='+img);*/

        var $form_data = new FormData();
        $('#form-user').serializeArray().forEach(function(field){
            $form_data.append(field.name, field.value);
        });

        var inputFile = $('#imgupload');   
        if(inputFile){   
            var fileToUpload = inputFile[0].files[0];
            if (fileToUpload != 'undefined') {
              $form_data.append('image', fileToUpload);
            }
        }

        $form_data.append('x', size.x);
        $form_data.append('y', size.y);
        $form_data.append('w', size.w);
        $form_data.append('h', size.h);
        $form_data.append('img', img);

        $('#image-loader').show();

        $.ajax({
            url: "<?=base_url();?>profile/update_profile_photo",
            type:'POST',
            data: $form_data,
            processData:false,
            contentType:false,
            cache:false,
            success: function(result){
              $('#image-loader').hide();
                if (result.status) { 
                    $('.span-profile-photo').attr('src',result.path);
                    $('.span-header-image').css('background','url("'+result.path+'") center center');
                } 
                else{
                    if(result.msg){
                        displaywarning(result.msg);
                    }
                    else
                        displaywarning("Something went wrong please try again");
                }
            }
        });
    });
      $('#imgupload').on('change',function(event){
       /* displaywarning('File requirement: JPG, PNG up to 1MB. Minimum pixels required: 500 for width, 300 for height.');*/
        if( $('#imgupload').val()==""){
          /*displaywarning('please select file to upload.');*/
            return false;
        }
        var ext = $('#imgupload').val().split('.').pop().toLowerCase();
        if($.inArray(ext, ['jpg','jpeg','png']) == -1) {
            displaywarning('invalid extension!');
            return false;
        }

        var self=this;
        var $form_data = new FormData();
        $('#form-user').serializeArray().forEach(function(field){
            $form_data.append(field.name, field.value);
        });

        var inputFile = $('#imgupload');   
        if(inputFile){   
            var fileToUpload = inputFile[0].files[0];
            if (fileToUpload != 'undefined') {
                $form_data.append('image', fileToUpload);
            }
        }

        $('#OpenImgUpload').attr('disabled','');
        $('#OpenImgUpload').css('pointer-events','none');
        $('#OpenImgUpload').css('cursor','no-drop');
        const target = event.target
        if (target.files && target.files[0]) {
            //allow less than 1mb
            const maxAllowedSize = 1 * 200 * 200;
            if (target.files[0].size > maxAllowedSize) {
            // Here you can ask your users to load correct file
                $('#image-loader').hide();
                $('#OpenImgUpload').removeAttr('disabled');
                $('#OpenImgUpload').css('pointer-events','all');
                $('#OpenImgUpload').css('cursor','pointer');
                displaywarning("File size is too big. please select the file less than 1MB.");
                return false;
            }
        }


        var defaults = {  
            maxWidth: Number.MAX_VALUE,  
            maxHeigt: Number.MAX_VALUE,  
            onImageResized: null  
        }  
        var options={
            maxWidth: 200,
            maxHeigt:200
        }
        var settings = $.extend({}, defaults, options); 
        
        if (window.File && window.FileList && window.FileReader) { 
            var files = event.target.files;  
            var file = files[0];  
            /*if (!file.type.match('image')) continue;  */
            var picReader = new FileReader();  
            picReader.addEventListener("load", function (event) {

                var picFile = event.target;  
                var imageData = picFile.result;  
                var img = new Image();  
                img.src = imageData;  
                img.onload = function () {
                    swal({
                        title: 'File requirement :',
                        text: "JPG, PNG up to 1MB. Minimum pixels required: 200 for width, 200 for height.",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, upload it!',
                        cancelButtonText: 'No, cancel!',
                        confirmButtonClass: 'btn btn-success',
                        cancelButtonClass: 'btn btn-danger',
                        buttonsStyling: false
                    },function (confirm) {
                      if(confirm){
                          $('#image-loader').show();
              var canvas = $("<canvas/>").get(0);  
              canvas.width = 200;  
              canvas.height = 200;  
              var context = canvas.getContext('2d');  
              context.fillStyle = "transparent";
              context.drawImage(img, 0, 0, 200, 200); 
                          imageData = canvas.toDataURL('image/jpeg',0.8); 
                           
                          $form_data.append('image', imageData);
                          $('.recipe-image-upload').attr('data-image-src',imageData);
                          $(".recipe-image-upload").css("background", "url(" + imageData + ")");
                          $.ajax({
                      url: "<?=base_url();?>profile/update_profile_photo",
                      type:'POST',
                      data: $form_data,
                      processData:false,
                      contentType:false,
                      cache:false,
                      success: function(result){
                        $('#image-loader').hide();
                          if (result.status) { 
                              $('.span-profile-photo').attr('src',result.path);
                              $('.span-header-image').css('background','url("'+result.path+'") center center');
                          } 
                          else{
                              if(result.msg){
                                  displaywarning(result.msg);
                              }
                              else
                                  displaywarning("Something went wrong please try again");
                          }

                                  $('#OpenImgUpload').removeAttr('disabled');
                                  $('#OpenImgUpload').css('pointer-events','all');
                                  $('#OpenImgUpload').css('cursor','pointer');
                      }
                  });
                       }
                       else{
                          $('#OpenImgUpload').removeAttr('disabled');
                          $('#OpenImgUpload').css('pointer-events','all');
                          $('#OpenImgUpload').css('cursor','pointer');
                          $('#imgupload').val('');
                       }
                    }, function (dismiss) {
                      console.log('here');
                        $('#OpenImgUpload').removeAttr('disabled');
                        $('#OpenImgUpload').css('pointer-events','all');
                        $('#OpenImgUpload').css('cursor','pointer');
                        if (dismiss === 'cancel') {
                            /*swal(
                              'Cancelled',
                              'Your record is safe :)',
                              'error'
                            )*/
                        }
                    });
                   
                }  
                img.onerror = function () {  
                     $("#cropbox").attr('src','');
                    $('#image-loader').hide();
                    $('#OpenImgUpload').removeAttr('disabled');
                    $('#OpenImgUpload').css('pointer-events','all');
                    $('#OpenImgUpload').css('cursor','pointer');
                }  
            });  
            //Read the image  
            picReader.readAsDataURL(file);  
        } else {  
            displaywarning("Your browser does not support File API");  
            $("#cropbox").attr('src','');
            $('#image-loader').hide();
            $('#OpenImgUpload').removeAttr('disabled');
            $('#OpenImgUpload').css('pointer-events','all');
            $('#OpenImgUpload').css('cursor','pointer');
        }    
    });
  /*$('#imgupload').on('change',function(e){
    $('#OpenImgUpload').attr('disabled','');
    var self=this;
        var $form_data = new FormData();
        $('#form-user').serializeArray().forEach(function(field){
            $form_data.append(field.name, field.value);
        });
        var inputFile = $('#imgupload');   
        if(inputFile){   
            var fileToUpload = inputFile[0].files[0];
            if (fileToUpload != 'undefined') {
              $form_data.append('image', fileToUpload);
            }
        }
        const target = e.target
    if (target.files && target.files[0]) {
      //allow less than 1mb
      const maxAllowedSize = 1 * 1024 * 1024;
      if (target.files[0].size > maxAllowedSize) {
      // Here you can ask your users to load correct file
        $('#OpenImgUpload').removeAttr('disabled');
        displaywarning("File size is too big. please select the file less than 1MB.");
        return false;
      }
    }

    readURL(this);
    $('#modal-imagepreview').modal({
        show: true,
        keyboard: false,
        backdrop: 'static'
    });
        
  });*/
  $(".a-save-profile").click(function(){
    if($('#form-user [name=email]').val()==""){
      displaywarning("Email can not be blank");
      return false;
    }
    if($('#form-user [name=name]').val()==""){
      displaywarning("Name can not be blank");
      return false;

    }
    if($('#form-user [name=business_name]').val()==""){
      displaywarning("Business Name can not be blank");
      return false;
    }
    if($('#form-user [name=restauranttype]').val()==""){
      displaywarning("Restaurant type can not be blank");
      return false;

    }
    var contact_number=$('#input-contact-number').val();
    if(contact_number!=""){
      if(contact_number.length<8 || contact_number.length>14){
        displaywarning("Mobile number must be between 8 to 14 digits");
        return false;
      }
      if ($('#get_user_type').val() != 'Restaurant manager' && $('#get_user_type').val() != 'Waitinglist manager') {
      //console.log($('.select2-show-search').val());
      if($('.select2-show-search').val()=="" || $('.select2-show-search').val()==null){
        displaywarning("Please select country code.");
        return false;
      }}
    }
    else{
      displaywarning("Mobile number can not be blank");
      return false; 
    }
    $(this).toggle();
    $('.a-edit-profile').toggle();
      $(".row-edit-profile").toggle();
      $(".row-view-profile").toggle();
      var $form_data = new FormData();
        $('#form-user').serializeArray().forEach(function(field){
            $form_data.append(field.name, field.value);
        });
        $.ajax({
            url: "<?=base_url();?>profile/update_profile",
            type:'POST',
            data: $form_data,
            processData:false,
            contentType:false,
            cache:false,
            success: function(result){
                if (result.status) { 
                    var data=result.data;
                    for (i in data) {
                      $('.span-'+i).html(data[i]);
                    }
                    $('.span-name').html(data['name']);
                    $('.span-countrycode').html('+'+data['countrycode']);
                    $('.span-profile-link a').html("https://foodnai.com/restaurant/"+data['name']);
                    $('.span-profile-link a').attr("href","http://foodnai.com/restaurant/"+data['name']);
                    $('.span-profile-link a').attr("href","http://foodnai.com/restaurant/"+data['name']);
                    $('input[name="menu_details"]').val("https://foodnai.com/restaurant/"+data['name']);

                    console.log(data['restauranttype']);
                    if(data['restauranttype']=="veg")
                      $('.span-restauranttype').html("Veg");
          else if(data['restauranttype']=="nonveg")
            $('.span-restauranttype').html("Non-veg");
          else if(data['restauranttype']=="both")
            $('.span-restauranttype').html("Veg / Non-veg");
          displaysucess("Profile Save successfully");
                   /* http://foodnai.com/restaurants/<?=$user['name'];?>*/
                } 
                else{
                    if(result.msg){
                        displaywarning(result.msg);
                    }
                    else
                        displaywarning("Something went wrong please try again");
                }
            }
        });
  });

  /*$('.a-edit-name').click(function(){
      $(".input-editname").toggle();
  });

  $('.input-edit-designation').on("change",function(){
    $(".input-editname").toggle();
  });*/

  function displaysucess(msg)
    {
        swal("Success !",msg,"success");
    }

    function displaywarning(msg)
    {
        swal("Error !",msg,"error");
    }

</script>

<?php
require_once('web_footer.php');
require_once('footer.php');
?>
<script>
function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}
</script>