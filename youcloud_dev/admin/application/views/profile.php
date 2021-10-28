<?php
if($user['upline_id'] == ''){
	$retoencodestr = base64_encode($user['id']);}
else{
	$retoencodestr = base64_encode($user['upline_id']);
}
require_once('header.php');
require_once('sidebar.php');
?>




<link rel="stylesheet" href="<?=base_url();?>assets/plugins/resize/jquery.Jcrop.min.css" type="text/css" />
<script src="<?=base_url();?>assets/plugins/resize/jquery.min.js"></script>
<script src="<?=base_url();?>assets/plugins/resize/jquery.Jcrop.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/plugins/timepickerplugin/tpicker.css">
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
	height: 100px;
    width: 100px;
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
	<div class="widget-user-image"><img alt="FoodNAI Restaurant" class="span-profile-photo" src="<?php echo APP_LOGO ?>" width="80%"></div><br>
	<h6 style="color:#34a543d9!important; font-size:39px!important;font-weight: normal;"><?php echo APP_POWEREDBY_LINK ?></h6></center>
</div>
<div class=" app-content">
	<div class="side-app">

		<!--Page Header-->
		<div class="page-header">
			<h3 class="page-title"><i class="side-menu__icon fas fa-utensils mr-1"></i> Profile</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Profile</li>
			</ol>
		</div>
		<!--Page Header-->
	</div>
	<div class="row">
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
						<?php if ($_SESSION['usertype'] != 'Whatsapp manager') { ?>
						<hr>
						<h3 class="pro-user-username text-dark span-name">Zero Touch Menu</h3>
						<div class="media mt-1 pb-2" style="justify-content: center;">
							<img src="<?=base_url().$user['img_url'];?>" style="width: 115px;height: 115px;">
						</div>
						<h3 class="pro-user-desc text-muted input-editname span-business_name" style="margin-bottom:3px;"><?=$user['business_name'];?></h3>
						<h6 class="pro-user-username text-dark span-name">By <?php echo APP_NAME ?></h6>
						<button  onclick="javascript:window.print()" class="btn-print btn btn-primary btn-sm a-edit-name input-editname" id="printBtn">Print </button><?php } ?>
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
			<div class="card box-widget widget-user">
				<div class="card-body text-center">
					<h4>Menu Details Link</h4>
					<a href="<?=base_url();?>qrcode/<?=$retoencodestr;?>" target="_blank"><p><?=base_url();?>qrcode/<?=$retoencodestr;?></p></a>
				</div>
			</div>
		</div>
		<div class="col-xl-9  col-md-6 noPrint-section">
			<div class="card">
				<div class="pri-header">
					<h3 class="mr-1 mb-0">Personal Info
						<a href="javascript:;" class="btn btn-primary btn-sm a-edit-profile" style="float: right;display: none;">
							<span class="a-text"><i class="si si-pencil mr-1"></i>Edit</span>
						</a>
						<a href="javascript:;" class="btn btn-primary btn-sm a-save-profile" style="float: right;">
							<span class="a-text" ></i>Save</span>
						</a>
					</h3>
					
				</div>
				<div class="card-body">
					<form id="form-user" method="post" action="javascript:;">
						<input type="hidden" name="id" value="<?=$user['id'];?>">
						<div class="row mt-6 mb-6 row-edit-profile" style="display:block;">
							<div class="col-md-6 pr-5">
								<div class="media-list">
									<?php if ($_SESSION['usertype'] != 'Whatsapp manager') { ?>
									<div class="media mt-1 pb-2">
										<div class="mediaicon">
											<i class="si si-location-pin" aria-hidden="true"></i>
										</div>
										<div class="media-body ml-5 mt-1">
											<h6 class="mediafont text-dark mb-1">Restaurant Name <span >(*)</span>
											</h6>
											<input type="text" name="business_name" class="form-control" value="<?=$user['business_name'];?>" style="text-transform: capitalize;">
										</div>
									</div><?php } ?>

									<div class="media mt-1 pb-2">
										<div class="mediaicon">
											<i class="si si-phone" aria-hidden="true"></i>
										</div>
										<div class="media-body ml-5 mt-1">
											<h6 class="mediafont text-dark mb-1">Contact Number</h6>
											<div class="row">
												<?php if ($_SESSION['usertype'] != 'Whatsapp manager') {?>
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
											<i class="si si-graduation" aria-hidden="true"></i>
										</div>
										<div class="media-body ml-5 mt-1">
										<div class="col-lg-6 col-md-6 col-sm-12 col-12">
										<h6 class="mediafont text-dark mb-1">Postal Code
											
										</h6>
										<input type="text" name="postcode" class="form-control" value="<?=$user['postcode'];?>">

										</div>
										<div class="col-lg-6 col-md-6 col-sm-12 col-12">
										<h6 class="mediafont text-dark mb-1">City
											
										</h6>
										<input type="text" name="city" class="form-control" value="<?=$user['city'];?>" style="text-transform: capitalize;">
										</div>
										</div>
									</div>

									<div class="media mt-1 pb-2">
										<div class="mediaicon">
											<i class="si si-book-open" aria-hidden="true"></i>
										</div>
										<div class="media-body ml-5 mt-1">
											<h6 class="mediafont text-dark mb-1">Country
											
										</h6>
										<div class="col-lg-4 col-md-4 col-sm-4 col-4">
											<select class="form-control select2-show-search1 forcountry" name="forcountry_countrycode" selected-value="<?=$user['forcountry_countrycode']."&#x2c;".$user['country'];?>">
														<option data-countryCode="IN" value="91,India">India (+91)</option>
														<option data-countryCode="GB" value="44,UK">UK (+44)</option>
														<option data-countryCode="US" value="1,USA">USA (+1)</option>
														<optgroup label="Other countries">
															<option data-countryCode="DZ" value="213,Algeria">Algeria (+213)</option>
															<option data-countryCode="AD" value="376,Andorra">Andorra (+376)</option>
															<option data-countryCode="AO" value="244,Angola">Angola (+244)</option>
															<option data-countryCode="AI" value="1264,Anguilla">Anguilla (+1264)</option>
															<option data-countryCode="AG" value="1268,Antigua & Barbuda">Antigua &amp; Barbuda (+1268)</option>
															<option data-countryCode="AR" value="54,Argentina">Argentina (+54)</option>
															<option data-countryCode="AM" value="374,Armenia">Armenia (+374)</option>
															<option data-countryCode="AW" value="297,Aruba">Aruba (+297)</option>
															<option data-countryCode="AU" value="61,Australia">Australia (+61)</option>
															<option data-countryCode="AT" value="43,Austria">Austria (+43)</option>
															<option data-countryCode="AZ" value="994,Azerbaijan">Azerbaijan (+994)</option>
															<option data-countryCode="BS" value="1242,Bahamas">Bahamas (+1242)</option>
															<option data-countryCode="BH" value="973,Bahrain">Bahrain (+973)</option>
															<option data-countryCode="BD" value="880,Bangladesh">Bangladesh (+880)</option>
															<option data-countryCode="BB" value="1246,Barbados">Barbados (+1246)</option>
															<option data-countryCode="BY" value="375,Belarus">Belarus (+375)</option>
															<option data-countryCode="BE" value="32,Belgium">Belgium (+32)</option>
															<option data-countryCode="BZ" value="501,Belize">Belize (+501)</option>
															<option data-countryCode="BJ" value="229,Benin">Benin (+229)</option>
															<option data-countryCode="BM" value="1441,Bermuda">Bermuda (+1441)</option>
															<option data-countryCode="BT" value="975,Bhutan">Bhutan (+975)</option>
															<option data-countryCode="BO" value="591,Bolivia">Bolivia (+591)</option>
															<option data-countryCode="BA" value="387,Bosnia Herzegovina">Bosnia Herzegovina (+387)</option>
															<option data-countryCode="BW" value="267,Botswana">Botswana (+267)</option>
															<option data-countryCode="BR" value="55,Brazil">Brazil (+55)</option>
															<option data-countryCode="BN" value="673,Brunei">Brunei (+673)</option>
															<option data-countryCode="BG" value="359,Bulgaria">Bulgaria (+359)</option>
															<option data-countryCode="BF" value="226,Burkina Faso">Burkina Faso (+226)</option>
															<option data-countryCode="BI" value="257,Burundi">Burundi (+257)</option>
															<option data-countryCode="KH" value="855,Cambodia">Cambodia (+855)</option>
															<option data-countryCode="CM" value="237,Cameroon">Cameroon (+237)</option>
															<option data-countryCode="CA" value="1,Canada">Canada (+1)</option>
															<option data-countryCode="CV" value="238,Cape Verde Islands">Cape Verde Islands (+238)</option>
															<option data-countryCode="KY" value="1345,Cayman Islands">Cayman Islands (+1345)</option>
															<option data-countryCode="CF" value="236,Central African Republic">Central African Republic (+236)</option>
															<option data-countryCode="CL" value="56,Chile">Chile (+56)</option>
															<option data-countryCode="CN" value="86,China">China (+86)</option>
															<option data-countryCode="CO" value="57,Colombia">Colombia (+57)</option>
															<option data-countryCode="KM" value="269,Comoros">Comoros (+269)</option>
															<option data-countryCode="CG" value="242,Congo">Congo (+242)</option>
															<option data-countryCode="CK" value="682,Cook Islands">Cook Islands (+682)</option>
															<option data-countryCode="CR" value="506,Costa Rica">Costa Rica (+506)</option>
															<option data-countryCode="HR" value="385,Croatia">Croatia (+385)</option>
															<option data-countryCode="CU" value="53,Cuba">Cuba (+53)</option>
															<option data-countryCode="CY" value="90392,Cyprus North">Cyprus North (+90392)</option>
															<option data-countryCode="CY" value="357,Cyprus South">Cyprus South (+357)</option>
															<option data-countryCode="CZ" value="42,Czech Republic">Czech Republic (+42)</option>
															<option data-countryCode="DK" value="45,Denmark">Denmark (+45)</option>
															<option data-countryCode="DJ" value="253,Djibouti">Djibouti (+253)</option>
															<option data-countryCode="DM" value="1809,Dominica">Dominica (+1809)</option>
															<option data-countryCode="DO" value="1809,Dominican Republic">Dominican Republic (+1809)</option>
															<option data-countryCode="EC" value="593,Ecuador">Ecuador (+593)</option>
															<option data-countryCode="EG" value="20,Egypt">Egypt (+20)</option>
															<option data-countryCode="SV" value="503,El Salvador">El Salvador (+503)</option>
															<option data-countryCode="GQ" value="240,Equatorial Guinea">Equatorial Guinea (+240)</option>
															<option data-countryCode="ER" value="291,Eritrea">Eritrea (+291)</option>
															<option data-countryCode="EE" value="372,Estonia">Estonia (+372)</option>
															<option data-countryCode="ET" value="251,Ethiopia">Ethiopia (+251)</option>
															<option data-countryCode="FK" value="500,Falkland Islands">Falkland Islands (+500)</option>
															<option data-countryCode="FO" value="298,Faroe Islands">Faroe Islands (+298)</option>
															<option data-countryCode="FJ" value="679,Fiji">Fiji (+679)</option>
															<option data-countryCode="FI" value="358,Finland">Finland (+358)</option>
															<option data-countryCode="FR" value="33,France">France (+33)</option>
															<option data-countryCode="GF" value="594,French Guiana">French Guiana (+594)</option>
															<option data-countryCode="PF" value="689,French Polynesia">French Polynesia (+689)</option>
															<option data-countryCode="GA" value="241,Gabon">Gabon (+241)</option>
															<option data-countryCode="GM" value="220,Gambia">Gambia (+220)</option>
															<option data-countryCode="GE" value="7880,Georgia">Georgia (+7880)</option>
															<option data-countryCode="DE" value="49,Germany">Germany (+49)</option>
															<option data-countryCode="GH" value="233,Ghana">Ghana (+233)</option>
															<option data-countryCode="GI" value="350,Gibraltar">Gibraltar (+350)</option>
															<option data-countryCode="GR" value="30,Greece">Greece (+30)</option>
															<option data-countryCode="GL" value="299,Greenland">Greenland (+299)</option>
															<option data-countryCode="GD" value="1473,Grenada">Grenada (+1473)</option>
															<option data-countryCode="GP" value="590,Guadeloupe">Guadeloupe (+590)</option>
															<option data-countryCode="GU" value="671,Guam">Guam (+671)</option>
															<option data-countryCode="GT" value="502,Guatemala">Guatemala (+502)</option>
															<option data-countryCode="GN" value="224,Guinea">Guinea (+224)</option>
															<option data-countryCode="GW" value="245,Guinea - Bissau">Guinea - Bissau (+245)</option>
															<option data-countryCode="GY" value="592,Guyana">Guyana (+592)</option>
															<option data-countryCode="HT" value="509,Haiti">Haiti (+509)</option>
															<option data-countryCode="HN" value="504,Honduras">Honduras (+504)</option>
															<option data-countryCode="HK" value="852,Hong Kong">Hong Kong (+852)</option>
															<option data-countryCode="HU" value="36,Hungary">Hungary (+36)</option>
															<option data-countryCode="IS" value="354,Iceland">Iceland (+354)</option>
															
															<option data-countryCode="ID" value="62,Indonesia">Indonesia (+62)</option>
															<option data-countryCode="IR" value="98,Iran">Iran (+98)</option>
															<option data-countryCode="IQ" value="964,Iraq">Iraq (+964)</option>
															<option data-countryCode="IE" value="353,Ireland">Ireland (+353)</option>
															<option data-countryCode="IL" value="972,Israel">Israel (+972)</option>
															<option data-countryCode="IT" value="39,Italy">Italy (+39)</option>
															<option data-countryCode="JM" value="1876,Jamaica">Jamaica (+1876)</option>
															<option data-countryCode="JP" value="81,Japan">Japan (+81)</option>
															<option data-countryCode="JO" value="962,Jordan">Jordan (+962)</option>
															<option data-countryCode="KZ" value="7,Kazakhstan">Kazakhstan (+7)</option>
															<option data-countryCode="KE" value="254,Kenya">Kenya (+254)</option>
															<option data-countryCode="KI" value="686,Kiribati">Kiribati (+686)</option>
															<option data-countryCode="KP" value="850,Korea North">Korea North (+850)</option>
															<option data-countryCode="KR" value="82,Korea South">Korea South (+82)</option>
															<option data-countryCode="KW" value="965,Kuwait">Kuwait (+965)</option>
															<option data-countryCode="KG" value="996,Kyrgyzstan">Kyrgyzstan (+996)</option>
															<option data-countryCode="LA" value="856,Laos">Laos (+856)</option>
															<option data-countryCode="LV" value="371,Latvia">Latvia (+371)</option>
															<option data-countryCode="LB" value="961,Lebanon">Lebanon (+961)</option>
															<option data-countryCode="LS" value="266,Lesotho">Lesotho (+266)</option>
															<option data-countryCode="LR" value="231,Liberia">Liberia (+231)</option>
															<option data-countryCode="LY" value="218,Libya">Libya (+218)</option>
															<option data-countryCode="LI" value="417,Liechtenstein">Liechtenstein (+417)</option>
															<option data-countryCode="LT" value="370,Lithuania">Lithuania (+370)</option>
															<option data-countryCode="LU" value="352,Luxembourg">Luxembourg (+352)</option>
															<option data-countryCode="MO" value="853,Macao">Macao (+853)</option>
															<option data-countryCode="MK" value="389,Macedonia">Macedonia (+389)</option>
															<option data-countryCode="MG" value="261,Madagascar">Madagascar (+261)</option>
															<option data-countryCode="MW" value="265,Malawi">Malawi (+265)</option>
															<option data-countryCode="MY" value="60,Malaysia">Malaysia (+60)</option>
															<option data-countryCode="MV" value="960,Maldives">Maldives (+960)</option>
															<option data-countryCode="ML" value="223,Mali">Mali (+223)</option>
															<option data-countryCode="MT" value="356,Malta">Malta (+356)</option>
															<option data-countryCode="MH" value="692,Marshall Islands">Marshall Islands (+692)</option>
															<option data-countryCode="MQ" value="596,Martinique">Martinique (+596)</option>
															<option data-countryCode="MR" value="222,Mauritania">Mauritania (+222)</option>
															<option data-countryCode="YT" value="269,Mayotte">Mayotte (+269)</option>
															<option data-countryCode="MX" value="52,Mexico">Mexico (+52)</option>
															<option data-countryCode="FM" value="691,Micronesia">Micronesia (+691)</option>
															<option data-countryCode="MD" value="373,Moldova">Moldova (+373)</option>
															<option data-countryCode="MC" value="377,Monaco">Monaco (+377)</option>
															<option data-countryCode="MN" value="976,Mongolia">Mongolia (+976)</option>
															<option data-countryCode="MS" value="1664,Montserrat">Montserrat (+1664)</option>
															<option data-countryCode="MA" value="212,Morocco">Morocco (+212)</option>
															<option data-countryCode="MZ" value="258,Mozambique">Mozambique (+258)</option>
															<option data-countryCode="MN" value="95,Myanmar">Myanmar (+95)</option>
															<option data-countryCode="NA" value="264,Namibia">Namibia (+264)</option>
															<option data-countryCode="NR" value="674,Nauru">Nauru (+674)</option>
															<option data-countryCode="NP" value="977,Nepal">Nepal (+977)</option>
															<option data-countryCode="NL" value="31,Netherlands">Netherlands (+31)</option>
															<option data-countryCode="NC" value="687,New Caledonia">New Caledonia (+687)</option>
															<option data-countryCode="NZ" value="64,New Zealand">New Zealand (+64)</option>
															<option data-countryCode="NI" value="505,Nicaragua">Nicaragua (+505)</option>
															<option data-countryCode="NE" value="227,Niger">Niger (+227)</option>
															<option data-countryCode="NG" value="234,Nigeria">Nigeria (+234)</option>
															<option data-countryCode="NU" value="683,Niue">Niue (+683)</option>
															<option data-countryCode="NF" value="672,Norfolk Islands">Norfolk Islands (+672)</option>
															<option data-countryCode="NP" value="670,Northern Marianas">Northern Marianas (+670)</option>
															<option data-countryCode="NO" value="47,Norway">Norway (+47)</option>
															<option data-countryCode="OM" value="968,Oman">Oman (+968)</option>
															<option data-countryCode="PW" value="680,Palau">Palau (+680)</option>
															<option data-countryCode="PA" value="507,Panama">Panama (+507)</option>
															<option data-countryCode="PG" value="675,Papua New Guinea">Papua New Guinea (+675)</option>
															<option data-countryCode="PY" value="595,Paraguay">Paraguay (+595)</option>
															<option data-countryCode="PE" value="51,Peru">Peru (+51)</option>
															<option data-countryCode="PH" value="63,Philippines">Philippines (+63)</option>
															<option data-countryCode="PL" value="48,Poland">Poland (+48)</option>
															<option data-countryCode="PT" value="351,Portugal">Portugal (+351)</option>
															<option data-countryCode="PR" value="1787,Puerto Rico">Puerto Rico (+1787)</option>
															<option data-countryCode="QA" value="974,Qatar">Qatar (+974)</option>
															<option data-countryCode="RE" value="262,Reunion">Reunion (+262)</option>
															<option data-countryCode="RO" value="40,Romania">Romania (+40)</option>
															<option data-countryCode="RU" value="7,Russia">Russia (+7)</option>
															<option data-countryCode="RW" value="250,Rwanda">Rwanda (+250)</option>
															<option data-countryCode="SM" value="378,San Marino">San Marino (+378)</option>
															<option data-countryCode="ST" value="239,Sao Tome & Principe">Sao Tome &amp; Principe (+239)</option>
															<option data-countryCode="SA" value="966,Saudi Arabia">Saudi Arabia (+966)</option>
															<option data-countryCode="SN" value="221,Senegal">Senegal (+221)</option>
															<option data-countryCode="CS" value="381,Serbia">Serbia (+381)</option>
															<option data-countryCode="SC" value="248,Seychelles">Seychelles (+248)</option>
															<option data-countryCode="SL" value="232,Sierra Leone">Sierra Leone (+232)</option>
															<option data-countryCode="SG" value="65,Singapore">Singapore (+65)</option>
															<option data-countryCode="SK" value="421,Slovak Republic">Slovak Republic (+421)</option>
															<option data-countryCode="SI" value="386,Slovenia">Slovenia (+386)</option>
															<option data-countryCode="SB" value="677,Solomon Islands">Solomon Islands (+677)</option>
															<option data-countryCode="SO" value="252,Somalia">Somalia (+252)</option>
															<option data-countryCode="ZA" value="27,South Africa">South Africa (+27)</option>
															<option data-countryCode="ES" value="34,Spain">Spain (+34)</option>
															<option data-countryCode="LK" value="94,Sri Lanka">Sri Lanka (+94)</option>
															<option data-countryCode="SH" value="290,St. Helena">St. Helena (+290)</option>
															<option data-countryCode="KN" value="1869,St. Kitts">St. Kitts (+1869)</option>
															<option data-countryCode="SC" value="1758,St. Lucia">St. Lucia (+1758)</option>
															<option data-countryCode="SD" value="249,Sudan">Sudan (+249)</option>
															<option data-countryCode="SR" value="597,Suriname">Suriname (+597)</option>
															<option data-countryCode="SZ" value="268,Swaziland">Swaziland (+268)</option>
															<option data-countryCode="SE" value="46,Sweden">Sweden (+46)</option>
															<option data-countryCode="CH" value="41,Switzerland">Switzerland (+41)</option>
															<option data-countryCode="SI" value="963,Syria">Syria (+963)</option>
															<option data-countryCode="TW" value="886,Taiwan">Taiwan (+886)</option>
															<option data-countryCode="TJ" value="7,Tajikstan">Tajikstan (+7)</option>
															<option data-countryCode="TH" value="66,Thailand">Thailand (+66)</option>
															<option data-countryCode="TG" value="228,Togo">Togo (+228)</option>
															<option data-countryCode="TO" value="676,Tonga">Tonga (+676)</option>
															<option data-countryCode="TT" value="1868,Trinidad & Tobago">Trinidad &amp; Tobago (+1868)</option>
															<option data-countryCode="TN" value="216,Tunisia">Tunisia (+216)</option>
															<option data-countryCode="TR" value="90,Turkey">Turkey (+90)</option>
															<option data-countryCode="TM" value="7,Turkmenistan">Turkmenistan (+7)</option>
															<option data-countryCode="TM" value="993,Turkmenistan">Turkmenistan (+993)</option>
															<option data-countryCode="TC" value="1649,Turks & Caicos Islands">Turks &amp; Caicos Islands (+1649)</option>
															<option data-countryCode="TV" value="688,Tuvalu">Tuvalu (+688)</option>
															<option data-countryCode="UG" value="256,Uganda">Uganda (+256)</option>
															<!-- <option data-countryCode="GB" value="44">UK (+44)</option> -->
															<option data-countryCode="UA" value="380,Ukraine">Ukraine (+380)</option>
															<option data-countryCode="AE" value="971,United Arab Emirates">United Arab Emirates (+971)</option>
															<option data-countryCode="UY" value="598,Uruguay">Uruguay (+598)</option>
															<!-- <option data-countryCode="US" value="1">USA (+1)</option> -->
															<option data-countryCode="UZ" value="7,Uzbekistan">Uzbekistan (+7)</option>
															<option data-countryCode="VU" value="678,Vanuatu">Vanuatu (+678)</option>
															<option data-countryCode="VA" value="379,Vatican City">Vatican City (+379)</option>
															<option data-countryCode="VE" value="58,Venezuela">Venezuela (+58)</option>
															<option data-countryCode="VN" value="84,Vietnam">Vietnam (+84)</option>
															<option data-countryCode="VG" value="84,Virgin Islands - British">Virgin Islands - British (+1284)</option>
															<option data-countryCode="VI" value="84,Virgin Islands - US">Virgin Islands - US (+1340)</option>
															<option data-countryCode="WF" value="681,Wallis & Futuna">Wallis &amp; Futuna (+681)</option>
															<option data-countryCode="YE" value="969,Yemen (North)">Yemen (North)(+969)</option>
															<option data-countryCode="YE" value="967,Yemen (South)">Yemen (South)(+967)</option>
															<option data-countryCode="ZM" value="260,Zambia">Zambia (+260)</option>
															<option data-countryCode="ZW" value="263,Zimbabwe">Zimbabwe (+263)</option>
														</optgroup>
													</select>
										</div>
										<div class="col-lg-5 col-md-5 col-sm-5 col-5">
											<!--<input type="text" id="for_country_code_country_name" name="country" class="form-control" value="<?=$user['country'];?>" readonly>-->
											<input type="text" id="for_country_code_country_name" name="country" class="form-control" value="<?=($user['country'] == null || $user['country']==''?'India': $user['country']);?>" readonly>
										</div>
										<div class="col-lg-3 col-md-3 col-sm-3 col-3">
											<select class="form-control select2-show-search2" name="currency" id="" selected-value="<?=$user['currency'];?>">
												<option value="INR">INR</option>
    <option value="GBP">GBP</option>
    <option value="EUR">EUR</option>
    <option value="USD">USD</option>
											</select>
										</div>
										</div>
									</div>
									
									<?php if ($_SESSION['usertype'] != 'Whatsapp manager') { ?>
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

									
									<!-- 
										delivery input added by Victor
										third task
									-->
									<div class="media mt-1 pb-2">
										<div class="mediaicon">
											<i class="si si-clock" aria-hidden="true"></i>
										</div>
										<div class="media-body ml-5 mt-1">
											<p class="mediafont text-dark mb-1"> Delivery Fee</p>
	
											<input type="number" class="form-control" id="deliveryfee" value="<?php echo $user['delivery_fee'] ? $user['delivery_fee']: 0; ?>" name="delivery_fee"></input>
										</div>
									</div>
									<!-- victor edit here -->
									<input type="hidden" name="menu_details" class="form-control" value="https://foodnai.com/admin/qrcode/<?=$retoencodestr;?>" disabled="">
<!-- 									
									<?php if ($_SESSION['usertype'] != 'Whatsapp manager') { ?>
									<div class="media-list">
										<div class="media mt-1 pb-2">
											<div class="mediaicon">
												<i class="si si-link" aria-hidden="true"></i>
											</div>
											<div class="media-body ml-5 mt-1">
												<h6 class="mediafont text-dark mb-1">Link To Menu Details <span ></span>
												</h6>
												
											</div>
										</div>
									</div>
									<?php } ?> -->
								</div>
							</div>
							<div class="col-md-6 pl-3">
								<div class="media-list">
								<?php if ($_SESSION['usertype'] != 'Whatsapp manager') { ?>		
									<div class="media mt-1 pb-2">
										<div class="mediaicon">
											<i class="si si-clock" aria-hidden="true"></i>
										</div>
										<div class="media-body ml-5 mt-1">
											<h6 class="mediafont text-dark mb-1">Opening Time <span >(*)</span>
												
											</h6>
											<!--<input type="time" name="opening_time" class="form-control" value="<?=$user['opening_time'];?>" maxlength="50">-->
											<input onChange="hidetimebox()" name="opening_time" id="opening_time" value="<?=$user['opening_time'];?>" style="width:80%;float:left;" class="form-control" placeholder="HH:MM" readonly oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
											<button type="button" class="btn btn-primary clockchoosebtn" onclick="showpickers('opening_time',12,<?=date('h');?>,<?=date('i');?>,'<?=date('A');?>')" style="width:20%;float:left;"><i class="far fa-clock"></i></button>
											<div class="timepicker" style="z-index:999999999"></div>
										</div>
										<!--<div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:10px;">
											<label style="font-weight:bold;width:100%;float:left;">Opening Time</label>
												<input onChange="hidetimebox()" name="timepkr" id="timepkr" value="<?=date('h:i A');?>" style="width:80%;float:left;" class="form-control" placeholder="HH:MM" disabled oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
												<button type="button" class="btn btn-primary clockchoosebtn" onclick="showpickers('timepkr',12,<?=date('h');?>,<?=date('i');?>,'<?=date('A');?>')" style="width:20%;float:left;"><i class="far fa-clock"></i></button>
											</div>
											<div class="timepicker" style="z-index:999999999"></div>
										</div>-->
									</div>
									<div class="media mt-1 pb-2">
										<div class="mediaicon">
											<i class="si si-clock" aria-hidden="true"></i>
										</div>
										<div class="media-body ml-5 mt-1">
											<h6 class="mediafont text-dark mb-1">Close Time <span >(*)</span>
												
											</h6>
											<!--<input type="time" name="close_time" class="form-control" value="<?=$user['close_time'];?>">-->
											<input onChange="hidetimebox()" name="close_time" id="close_time" value="<?=$user['close_time'];?>" style="width:80%;float:left;" class="form-control" placeholder="HH:MM" readonly oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
											<button type="button" class="btn btn-primary clockchoosebtn" onclick="showpickers('close_time',12,<?=date('h');?>,<?=date('i');?>,'<?=date('A');?>')" style="width:20%;float:left;"><i class="far fa-clock"></i></button>
											<div class="timepicker" style="z-index:999999999"></div>
										</div>
									</div><?php } ?>
									<!-- <div class="media mt-1 pb-2">
										<div class="media-body ml-5 mt-1">
											<h6 class="mediafont text-dark mb-1">Owner</h6>
										</div>
									</div> -->
									<div class="media mt-1 pb-2">
										<div class="mediaicon">
											<i class="si si-user" aria-hidden="true"></i>
										</div>
										<div class="media-body ml-5 mt-1">
											<h6 class="mediafont text-dark mb-1">Owner Full Name <span >(*)</span>
											</h6>
											<input type="text" name="name" class="form-control"  value="<?=$user['name'];?>" placeholder=" Name" maxlength="100" style="text-transform: capitalize;">
											<!-- <input type="text" name="last_name" class="form-control"value="<?=$user['last_name'];?>" style="width: 50%;" placeholder="Last Name"> -->
										</div>
									</div>
									<div class="media mt-1 pb-2">
										<div class="mediaicon">
											<i class="si si-envelope" aria-hidden="true"></i>
										</div>
										<div class="media-body ml-5 mt-1">
											<h6 class="mediafont text-dark mb-1">Owner Email Address <span >(*)</span>
												
											</h6>
											<input type="text" name="email" class="form-control" value="<?=$user['email'];?>" maxlength="50" disabled="">
										</div>
									</div>

									<div class="media mt-1 pb-2">
										<div class="mediaicon">
											<i class="si si-phone" aria-hidden="true"></i>
										</div>
										<div class="media-body ml-5 mt-1">
											<h6 class="mediafont text-dark mb-1">Owner Phone Number <span >(*)</span>
												
											</h6>
											<input type="text" name="owner_contact_no" class="form-control" value="<?=$user['owner_contact_no'];?>">
										</div>
									</div>

									<div class="media mt-1 pb-2">
										<div class="mediaicon">
											<i class="si si-envelope" aria-hidden="true"></i>
										</div>
										<div class="media-body ml-5 mt-1">
											<h6 class="mediafont text-dark mb-1">Owner Adderss <span >(*)</span>
												
											</h6>
											<input type="text" class="form-control" name="owner_address" value="<?=$user['owner_address'];?>">
										</div>
									</div>
									
								</div>
							</div>
						</div>
						<?php if ($_SESSION['usertype'] != 'Whatsapp manager') { ?>
						<div class="col-lg-12 col-md-12 col-sm-12 col-12">
						<div class="media mt-1 pb-2">
										<div class="mediaicon">
											<i class="si si-info" aria-hidden="true"></i>
										</div>
										<div class="media-body ml-5 mt-1">
											<h6 class="mediafont text-dark mb-1">About Restaurant <span >(*)</span></h6>
											<?php 
												$rname = $user['business_name'];
												$aboutrestotext = "Welcome to $rname...	Our restaurant celebrates the finest cuisine, you will find the ambiance relaxed.Expect the best seasonal and local ingredients, handled with passion and creativity. Vegetables, herbs, fruits and flowers grown on finest Farm take center stage, along with the finest produce from the surrounding countryside. As we only use the freshest seasonal ingredients, menus are subject to change. Please mention any dietary requests when making the reservation so advance notice can be given to the kitchen. The food is delivered in a relaxed, comfortable and welcoming style, perfect for all year round and every occasion. We look forward to welcoming you soon.";
											?>
											<?php if($user['about_restaurant'] != ''){ ?>
											<textarea class="form-control" placeholder="About Restaurant" name="about_restaurant" rows="5"><?=$user['about_restaurant'];?></textarea>
											<?php } else { ?>
											<textarea class="form-control" placeholder="About Restaurant" name="about_restaurant" rows="5"><?=trim($aboutrestotext)?></textarea>
											<?php }  ?>
										</div>
									</div>
						</div><?php } ?>
					</form>
						<div class="col-lg-12 col-md-12 col-sm-12 col-12">
							<hr>
						</div>
						<?php if ($_SESSION['usertype'] != 'Whatsapp manager') { ?>
						<div class="col-lg-12 col-md-12 col-sm-12 col-12">
						<h4>Restaurant Images</h4>
					</div>
					<div style="width:100%">
								<div style="width: 20%;float:left;text-align:center;padding:5px;">
									<?php if($user['rest_img_1']==''){ ?>
									<img src="<?=base_url('assets/images/users/uploadimg.jpg')?>" class="img1" width="50%" height="100px"><?php } else{?>
									<img src="<?=$user['rest_img_1']?>" class="img1" width="100%" height="100px">
									<?php } ?>
									<input type="file" name="" id="file1" style="display:none;">
								</div>
								<div style="width: 20%;float:left;text-align:center;padding:5px;" class="showimg2">
									<?php if($user['rest_img_2']==''){ ?>
									<img src="<?=base_url('assets/images/users/uploadimg.jpg')?>" class="img2" width="50%" height="100px"><?php } else{?>
									<img src="<?=$user['rest_img_2']?>" class="img2" width="100%" height="100px">
									<?php } ?>
									<input type="file" name="" id="file2" style="display:none;">
								</div>
								<div style="width: 20%;float:left;text-align:center;padding:5px;" class="showimg3">
									<?php if($user['rest_img_3']==''){ ?>
									<img src="<?=base_url('assets/images/users/uploadimg.jpg')?>" class="img3" width="50%" height="100px"><?php } else{?>
									<img src="<?=$user['rest_img_3']?>" class="img3" width="100%" height="100px">
									<?php } ?>
									<input type="file" name="" id="file3" style="display:none;">
								</div>
								<div style="width: 20%;float:left;text-align:center;padding:5px;" class="showimg4">
									<?php if($user['rest_img_4']==''){ ?>
									<img src="<?=base_url('assets/images/users/uploadimg.jpg')?>" class="img4" width="50%" height="100px"><?php } else{?>
									<img src="<?=$user['rest_img_4']?>" class="img3" width="100%" height="100px">
									<?php } ?>
									<input type="file" name="" id="file4" style="display:none;">
								</div>
								<div style="width: 20%;float:left;text-align:center;padding:5px;" class="showimg5">
									<?php if($user['rest_img_5']==''){ ?>
									<img src="<?=base_url('assets/images/users/uploadimg.jpg')?>" class="img5" width="50%" height="100px"><?php } else{?>
									<img src="<?=$user['rest_img_5']?>" class="img3" width="100%" height="100px">
									<?php } ?>
									<input type="file" name="" id="file5" style="display:none;">
								</div>
						</div><?php } ?>
						
					</div>
					
					
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
<script src="<?=base_url();?>assets/plugins/timepickerplugin/tpicker.js"></script>
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

	$('.select2-show-search1').select2({
	  	minimumResultsForSearch: ''
    });
	$('.select2-show-search1').val($(".select2-show-search1").attr('selected-value')).trigger('change');

	$('.select2-show-search2').select2({
	  	minimumResultsForSearch: ''
    });
	$('.select2-show-search2').val($(".select2-show-search2").attr('selected-value')).trigger('change');
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
            const maxAllowedSize = 1 * 1024 * 1024;
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

		if($('#form-user [name=owner_address]').val()==""){
			displaywarning("Owner Adderss can not be blank");
			return false;
		}
		if($('#form-user [name=owner_contact_no]').val()==""){
			displaywarning("Owner Contact Number can not be blank");
			return false;
		}

		if($('#form-user [name=opening_time]').val()==""){
			displaywarning("Restaurant Opening Time can not be blank");
			return false;
		}
		if($('#form-user [name=close_time]').val()==""){
			displaywarning("Restaurant close Time can not be blank");
			return false;
		}
		if($('#form-user [name=currency]').val()==""){
			displaywarning("Currency can not be blank");
			return false;
		}
		if($('#form-user [name=currency]').val()==""){
			displaywarning("Currency can not be blank");
			return false;
		}
		if($('#form-user [name=forcountry_countrycode]').val()==""){
			displaywarning("Country can not be blank");
			return false;
		}
		if($('#form-user [name=about_restaurant]').val()==""){
			displaywarning("About Restaurant can not be blank");
			return false;
		}
		var contact_number=$('#input-contact-number').val();
		if(contact_number!=""){
			if(contact_number.length<8 || contact_number.length>14){
				displaywarning("Mobile number must be between 8 to 14 digits");
				return false;
			}
			if ($('#get_user_type').val() != 'Whatsapp manager') {
			//console.log($('.select2-show-search').val());
			if($('.select2-show-search').val()=="" || $('.select2-show-search').val()==null){
				displaywarning("Please select mobile country code.");
				return false;
			}}
		}
		else{
			displaywarning("Mobile number can not be blank");
			return false;	
		}
		// $(this).toggle();
		// $('.a-edit-profile').toggle();
	  	// $(".row-edit-profile").toggle();
	  	// $(".row-view-profile").toggle();
	  	var $form_data = new FormData();
        $('#form-user').serializeArray().forEach(function(field){
            $form_data.append(field.name, field.value);
        });
		//console.log($form_data);
        $.ajax({
            url: "<?=base_url();?>profile/update_profile",
            type:'POST',
            data: $form_data,
            processData:false,
            contentType:false,
            cache:false,
            success: function(result){
            	console.log(result);
                if (result.status) { 
					swal({
            title: '',
            text: "Profile Save Successfully",
            type: 'success',
            showCancelButton: false,
            confirmButtonColor: '#05C76B',
            cancelButtonColor: '#d33',
            confirmButtonText: 'OK',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false
            },function (isconfirm) {
                if(isconfirm){
                    location.reload();
                    /*window.location.href=Orders.base_url+"restaurant/printbill/"+invoice_id;*/
                }
            });
					// location.reload();
                    // var data=result.data;
                    // for (i in data) {
                   	// 	$('.span-'+i).html(data[i]);
                    // }
					// var encodestr = btoa(data['id']);
                   	// $('.span-name').html(data['name']);
                   	// $('.span-countrycode').html('+'+data['countrycode']);
                   	// $('.span-country').html('+'+data['forcountry_countrycode']+" "+data['country']+ "<br>"+data['currency']);
                   	
					// $('.span-profile-link a').html("<?=base_url();?>qrcode/"+encodestr);
                   	// $('.span-profile-link a').attr("href","<?=base_url();?>qrcode/"+encodestr);
                   	// $('.span-profile-link a').attr("href","<?=base_url();?>qrcode/"+encodestr);
                   	// $('input[name="menu_details"]').val("<?=base_url();?>qrcode/"+encodestr);
                   	// if(data['restauranttype']=="veg")
                   	// 	$('.span-restauranttype').html("Veg");
					// else if(data['restauranttype']=="nonveg")
					// 	$('.span-restauranttype').html("Non-veg");
					// else if(data['restauranttype']=="both")
					// 	$('.span-restauranttype').html("Veg / Non-veg");
                   /*	http://foodnai.com/restaurants/<?=$user['name'];?>*/
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
<script type="text/javascript">
	$('.forcountry').change(function(){
		a=$('.forcountry').val();
		var fruits = a;
		var ar = fruits.split(','); // split string on comma space
		console.log( ar[1]);
		$('#for_country_code_country_name').val(ar[1]);
	})
</script>
<script type="text/javascript">
	$('.img1').click(function(){
        $('#file1').trigger('click');
	});

	$('.img2').click(function(){
        $('#file2').trigger('click');
	});

	$('.img3').click(function(){
        $('#file3').trigger('click');
	});

	$('.img4').click(function(){
        $('#file4').trigger('click');
	});

	$('.img5').click(function(){
        $('#file5').trigger('click');
	});

	$('#file1').change(function(){
        var bind_input=$(this);
        if($(this).val()==""){
              /*  displaywarning('please select file to upload.');*/
                return false;
            }
        var ext = $(this).val().split('.').pop().toLowerCase();
            if($.inArray(ext, ['jpg','jpeg','png']) == -1) {
                displaywarning('invalid extension!');
                return false;
            }

            var self=this;
            var $form_data = new FormData();
            var inputFile = $(this);   
            if(inputFile){   
                var fileToUpload = inputFile[0].files[0];
                if (fileToUpload != 'undefined') {
                    $form_data.append('image', fileToUpload);
                }
            }
            const target = event.target
            if (target.files && target.files[0]) {
                //allow less than 1mb
                const maxAllowedSize = 1 * 1024 * 1024;
                if (target.files[0].size > maxAllowedSize) {
                // Here you can ask your users to load correct file
                    $('#image-loader').hide();
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
                maxHeigt:121
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
                        },function (swalstatus) { 
                            if(swalstatus){
                                $('#image-loader').show();
                                var canvas = $("<canvas/>").get(0);  
                                canvas.width = 200;  
                                canvas.height = 121;  
                                var context = canvas.getContext('2d');  
                                context.fillStyle = "transparent";
                                context.drawImage(img, 0, 0, 200, 121); 
                                imageData = canvas.toDataURL('image/jpeg',0.8); 
                               
                                $form_data.append('image', imageData);
                               /* self.closest('td').find('.img-upload').attr('data-image-src',imageData);
                                self.closest('td').find('.img-upload').css("background", "url(" + imageData + ")");*/
                                $.ajax({
                                    url: "<?=base_url()?>profile/update_restaurant_photo1",
                                    type:'POST',
                                    data: $form_data,
                                    processData:false,
                                    contentType:false,
                                    cache:false,
                                    success: function(result){
                                        $('#image-loader').hide();
                                        if (result.status) {
                                        	location.reload();
                                           /* self.closest('td').find('.img-upload').attr('data-image-src',Menugrouplist.base_url+result.path);
                                            self.closest('td').find('.img-upload').css("background", "url(" + Menugrouplist.base_url+result.path + ")");*/
                                        } 
                                        else{
                                            if(result.msg){
                                                displaywarning(result.msg);
                                            }
                                            else
                                                displaywarning("Something went wrong please try again");
                                        }
                                        $('#image-loader').hide();
                                    }
                                });
                            }
                            else{

                                bind_input.val('');
                            }
                        }, function (dismiss) {
                            if (dismiss === 'cancel') {
                               /* swal(
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
                       
                    }  
                });  
                //Read the image  
                picReader.readAsDataURL(file);  
            } else {  
                displaywarning("Your browser does not support File API");  
                $("#cropbox").attr('src','');
                $('#image-loader').hide();
            }
	});


	$('#file2').change(function(){
        var bind_input=$(this);
        if($(this).val()==""){
              /*  displaywarning('please select file to upload.');*/
                return false;
            }
        var ext = $(this).val().split('.').pop().toLowerCase();
            if($.inArray(ext, ['jpg','jpeg','png']) == -1) {
                displaywarning('invalid extension!');
                return false;
            }

            var self=this;
            var $form_data = new FormData();
            var inputFile = $(this);   
            if(inputFile){   
                var fileToUpload = inputFile[0].files[0];
                if (fileToUpload != 'undefined') {
                    $form_data.append('image', fileToUpload);
                }
            }
            const target = event.target
            if (target.files && target.files[0]) {
                //allow less than 1mb
                const maxAllowedSize = 1 * 1024 * 1024;
                if (target.files[0].size > maxAllowedSize) {
                // Here you can ask your users to load correct file
                    $('#image-loader').hide();
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
                maxHeigt:121
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
                        },function (swalstatus) { 
                            if(swalstatus){
                                $('#image-loader').show();
                                var canvas = $("<canvas/>").get(0);  
                                canvas.width = 200;  
                                canvas.height = 121;  
                                var context = canvas.getContext('2d');  
                                context.fillStyle = "transparent";
                                context.drawImage(img, 0, 0, 200, 121); 
                                imageData = canvas.toDataURL('image/jpeg',0.8); 
                               
                                $form_data.append('image', imageData);
                               /* self.closest('td').find('.img-upload').attr('data-image-src',imageData);
                                self.closest('td').find('.img-upload').css("background", "url(" + imageData + ")");*/
                                $.ajax({
                                    url: "<?=base_url()?>profile/update_restaurant_photo2",
                                    type:'POST',
                                    data: $form_data,
                                    processData:false,
                                    contentType:false,
                                    cache:false,
                                    success: function(result){
                                        $('#image-loader').hide();
                                        if (result.status) {
                                        	location.reload();
                                           /* self.closest('td').find('.img-upload').attr('data-image-src',Menugrouplist.base_url+result.path);
                                            self.closest('td').find('.img-upload').css("background", "url(" + Menugrouplist.base_url+result.path + ")");*/
                                        } 
                                        else{
                                            if(result.msg){
                                                displaywarning(result.msg);
                                            }
                                            else
                                                displaywarning("Something went wrong please try again");
                                        }
                                        $('#image-loader').hide();
                                    }
                                });
                            }
                            else{

                                bind_input.val('');
                            }
                        }, function (dismiss) {
                            if (dismiss === 'cancel') {
                               /* swal(
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
                       
                    }  
                });  
                //Read the image  
                picReader.readAsDataURL(file);  
            } else {  
                displaywarning("Your browser does not support File API");  
                $("#cropbox").attr('src','');
                $('#image-loader').hide();
            }
	});

	$('#file3').change(function(){
        var bind_input=$(this);
        if($(this).val()==""){
              /*  displaywarning('please select file to upload.');*/
                return false;
            }
        var ext = $(this).val().split('.').pop().toLowerCase();
            if($.inArray(ext, ['jpg','jpeg','png']) == -1) {
                displaywarning('invalid extension!');
                return false;
            }

            var self=this;
            var $form_data = new FormData();
            var inputFile = $(this);   
            if(inputFile){   
                var fileToUpload = inputFile[0].files[0];
                if (fileToUpload != 'undefined') {
                    $form_data.append('image', fileToUpload);
                }
            }
            const target = event.target
            if (target.files && target.files[0]) {
                //allow less than 1mb
                const maxAllowedSize = 1 * 1024 * 1024;
                if (target.files[0].size > maxAllowedSize) {
                // Here you can ask your users to load correct file
                    $('#image-loader').hide();
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
                maxHeigt:121
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
                        },function (swalstatus) { 
                            if(swalstatus){
                                $('#image-loader').show();
                                var canvas = $("<canvas/>").get(0);  
                                canvas.width = 200;  
                                canvas.height = 121;  
                                var context = canvas.getContext('2d');  
                                context.fillStyle = "transparent";
                                context.drawImage(img, 0, 0, 200, 121); 
                                imageData = canvas.toDataURL('image/jpeg',0.8); 
                               
                                $form_data.append('image', imageData);
                               /* self.closest('td').find('.img-upload').attr('data-image-src',imageData);
                                self.closest('td').find('.img-upload').css("background", "url(" + imageData + ")");*/
                                $.ajax({
                                    url: "<?=base_url()?>profile/update_restaurant_photo3",
                                    type:'POST',
                                    data: $form_data,
                                    processData:false,
                                    contentType:false,
                                    cache:false,
                                    success: function(result){
                                        $('#image-loader').hide();
                                        if (result.status) { 
                                        	location.reload();
                                           /* self.closest('td').find('.img-upload').attr('data-image-src',Menugrouplist.base_url+result.path);
                                            self.closest('td').find('.img-upload').css("background", "url(" + Menugrouplist.base_url+result.path + ")");*/
                                        } 
                                        else{
                                            if(result.msg){
                                                displaywarning(result.msg);
                                            }
                                            else
                                                displaywarning("Something went wrong please try again");
                                        }
                                        $('#image-loader').hide();
                                    }
                                });
                            }
                            else{

                                bind_input.val('');
                            }
                        }, function (dismiss) {
                            if (dismiss === 'cancel') {
                               /* swal(
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
                       
                    }  
                });  
                //Read the image  
                picReader.readAsDataURL(file);  
            } else {  
                displaywarning("Your browser does not support File API");  
                $("#cropbox").attr('src','');
                $('#image-loader').hide();
            }
	});

	$('#file4').change(function(){
        var bind_input=$(this);
        if($(this).val()==""){
              /*  displaywarning('please select file to upload.');*/
                return false;
            }
        var ext = $(this).val().split('.').pop().toLowerCase();
            if($.inArray(ext, ['jpg','jpeg','png']) == -1) {
                displaywarning('invalid extension!');
                return false;
            }

            var self=this;
            var $form_data = new FormData();
            var inputFile = $(this);   
            if(inputFile){   
                var fileToUpload = inputFile[0].files[0];
                if (fileToUpload != 'undefined') {
                    $form_data.append('image', fileToUpload);
                }
            }
            const target = event.target
            if (target.files && target.files[0]) {
                //allow less than 1mb
                const maxAllowedSize = 1 * 1024 * 1024;
                if (target.files[0].size > maxAllowedSize) {
                // Here you can ask your users to load correct file
                    $('#image-loader').hide();
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
                maxHeigt:121
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
                        },function (swalstatus) { 
                            if(swalstatus){
                                $('#image-loader').show();
                                var canvas = $("<canvas/>").get(0);  
                                canvas.width = 200;  
                                canvas.height = 121;  
                                var context = canvas.getContext('2d');  
                                context.fillStyle = "transparent";
                                context.drawImage(img, 0, 0, 200, 121); 
                                imageData = canvas.toDataURL('image/jpeg',0.8); 
                               
                                $form_data.append('image', imageData);
                               /* self.closest('td').find('.img-upload').attr('data-image-src',imageData);
                                self.closest('td').find('.img-upload').css("background", "url(" + imageData + ")");*/
                                $.ajax({
                                    url: "<?=base_url()?>profile/update_restaurant_photo4",
                                    type:'POST',
                                    data: $form_data,
                                    processData:false,
                                    contentType:false,
                                    cache:false,
                                    success: function(result){
                                        $('#image-loader').hide();
                                        if (result.status) { 
                                        	location.reload();
                                           /* self.closest('td').find('.img-upload').attr('data-image-src',Menugrouplist.base_url+result.path);
                                            self.closest('td').find('.img-upload').css("background", "url(" + Menugrouplist.base_url+result.path + ")");*/
                                        } 
                                        else{
                                            if(result.msg){
                                                displaywarning(result.msg);
                                            }
                                            else
                                                displaywarning("Something went wrong please try again");
                                        }
                                        $('#image-loader').hide();
                                    }
                                });
                            }
                            else{

                                bind_input.val('');
                            }
                        }, function (dismiss) {
                            if (dismiss === 'cancel') {
                               /* swal(
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
                       
                    }  
                });  
                //Read the image  
                picReader.readAsDataURL(file);  
            } else {  
                displaywarning("Your browser does not support File API");  
                $("#cropbox").attr('src','');
                $('#image-loader').hide();
            }
	});

	$('#file5').change(function(){
        var bind_input=$(this);
        if($(this).val()==""){
              /*  displaywarning('please select file to upload.');*/
                return false;
            }
        var ext = $(this).val().split('.').pop().toLowerCase();
            if($.inArray(ext, ['jpg','jpeg','png']) == -1) {
                displaywarning('invalid extension!');
                return false;
            }

            var self=this;
            var $form_data = new FormData();
            var inputFile = $(this);   
            if(inputFile){   
                var fileToUpload = inputFile[0].files[0];
                if (fileToUpload != 'undefined') {
                    $form_data.append('image', fileToUpload);
                }
            }
            const target = event.target
            if (target.files && target.files[0]) {
                //allow less than 1mb
                const maxAllowedSize = 1 * 1024 * 1024;
                if (target.files[0].size > maxAllowedSize) {
                // Here you can ask your users to load correct file
                    $('#image-loader').hide();
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
                maxHeigt:121
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
                        },function (swalstatus) { 
                            if(swalstatus){
                                $('#image-loader').show();
                                var canvas = $("<canvas/>").get(0);  
                                canvas.width = 200;  
                                canvas.height = 121;  
                                var context = canvas.getContext('2d');  
                                context.fillStyle = "transparent";
                                context.drawImage(img, 0, 0, 200, 121); 
                                imageData = canvas.toDataURL('image/jpeg',0.8); 
                               
                                $form_data.append('image', imageData);
                               /* self.closest('td').find('.img-upload').attr('data-image-src',imageData);
                                self.closest('td').find('.img-upload').css("background", "url(" + imageData + ")");*/
                                $.ajax({
                                    url: "<?=base_url()?>profile/update_restaurant_photo5",
                                    type:'POST',
                                    data: $form_data,
                                    processData:false,
                                    contentType:false,
                                    cache:false,
                                    success: function(result){
                                        $('#image-loader').hide();
                                        if (result.status) { 
                                        	location.reload();
                                           /* self.closest('td').find('.img-upload').attr('data-image-src',Menugrouplist.base_url+result.path);
                                            self.closest('td').find('.img-upload').css("background", "url(" + Menugrouplist.base_url+result.path + ")");*/
                                        } 
                                        else{
                                            if(result.msg){
                                                displaywarning(result.msg);
                                            }
                                            else
                                                displaywarning("Something went wrong please try again");
                                        }
                                        $('#image-loader').hide();
                                    }
                                });
                            }
                            else{

                                bind_input.val('');
                            }
                        }, function (dismiss) {
                            if (dismiss === 'cancel') {
                               /* swal(
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
                       
                    }  
                });  
                //Read the image  
                picReader.readAsDataURL(file);  
            } else {  
                displaywarning("Your browser does not support File API");  
                $("#cropbox").attr('src','');
                $('#image-loader').hide();
            }
	});
</script>