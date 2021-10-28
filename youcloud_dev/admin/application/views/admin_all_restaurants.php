<?php
require_once('header.php');
require_once('sidebar.php');
?>
<div class=" app-content">
	<div class="side-app">

		<!--Page Header-->
		<div class="page-header">
			<h3 class="page-title"><i class="fe fe-user mr-1"></i> Restaurants</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?=base_url();?>admin">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Restaurants</li>
			</ol>
		</div>
		<!--Page Header-->
		<div class="row">
			<div class="col-lg-12 col-md-12">
				<div class="card">
					<div class="card-body p-6">
						<div class="row">
							<div class="col-xl-4 col-md-12 col-lg-4">
								<div class="card overflow-hidden">
									<div class="card-body pb-0">
										<div class="dash-widget text-center">
											<h6 class="text-muted">Total Restaurants</h6>
											<h3 class="font-weight-extrabold num-font"> <?=$total_restaurants['total_restaurant']?></h3>
											<p class="mb-0 text-muted"><i class="fas fa-arrow-alt-circle-down text-red mr-1"></i><span class="font-weight-bold">2%</span> decrease last year</p>
										</div>
									</div>
									<div class="chart-wrapper chart-wraper-absolute">
										<canvas id="AreaChart2" class="chart-dropshadow"></canvas>
									</div>
								</div>
							</div>
							<div class="col-xl-4 col-md-12 col-lg-4">
								<div class="card overflow-hidden">
									<div class="card-body pb-0">
										<div class="dash-widget text-center">
											<h6 class="text-muted">Active Restaurants</h6>
											<h3 class="font-weight-extrabold num-font"> <?=$active_restaurants['active_restaurant']?></h3>
											<p class="mb-0 text-muted"><i class="fas fa-arrow-alt-circle-up text-green mr-1"></i><span class="font-weight-bold">5%</span> increase last year</p>
										</div>
									</div>
									<div class="chart-wrapper chart-wraper-absolute">
										<canvas id="AreaChart3" class="chart-dropshadow"></canvas>
									</div>
								</div>
							</div>
							<div class="col-xl-4 col-md-12 col-lg-4">
								<div class="card overflow-hidden">
									<div class="card-body pb-0">
										<div class="dash-widget text-center">
											<h6 class="text-muted">Inactive Restaurants</h6>
											<h3 class="font-weight-extrabold num-font"> <?=$inactive_restaurants['inactive_restaurant']?></h3>
											<p class="mb-0 text-muted"><i class="fas fa-arrow-alt-circle-up text-green mr-1"></i><span class="font-weight-bold">10%</span> increase last year</p>
										</div>
									</div>
									<div class="chart-wrapper chart-wraper-absolute">
										<canvas id="AreaChart4" class="chart-dropshadow"></canvas>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-12 text-right"><button class="btn btn-primary" data-toggle="modal" data-target="#newusers"><i class="fas fa-plus"></i> Add New User</button></div>
		</div>
		<div class="row mb-3 row-filter">
		<div class="col-md-2">
			<select class="form-control" id="restaurant_status">
				<option value="">Select Status</option>
				<option value="1">Active</option>
				<option value="0">Inactive</option>
			</select>
		</div>
		<div class="col-md-5">
			<div class="input-group">
				<input type="text" class="form-control" placeholder="Search Restaurant"  id="searchInput" style="font-size: 17px;">
				<span class="input-group-append">
					<button class="btn btn-primary" type="button" style="border-radius: 4px;border: 0px !important;"><i class="fas fa-search"></i></button>
				</span>
			</div>
		</div>
		<div class="col-md-2 p-l-5 p-r-5">
			<div class="btn-group per_page m-r-5">
				<button class="btn btn-default dropdown-toggle btn-per-page" data-toggle="dropdown" type="button" aria-expanded="false" selected-per-page="30">
					30 items per page
					<i class="md md-arrow-drop-down"></i>
				</button>
				<ul class="dropdown-menu pull-right" role="menu">
					<li class=""><a data-per="15" class="a-recipe-perpage" data-preferences='{"per_page":"15"}' href="javascript:;">15</a></li>
					<li class=""><a data-per="30" class="a-recipe-perpage" data-preferences='{"per_page":"30"}' href="javascript:;">30</a></li>
					<li class=""><a data-per="60" class="a-recipe-perpage" data-preferences='{"per_page":"60"}' href="javascript:;">60</a></li>
					<li class=""><a data-per="all" class="a-recipe-perpage" data-preferences='{"per_page":"all"}' href="javascript:;">All (<span class="span-all-groups"></span>)</a></li>
				</ul>
			</div>
		</div>
		<div class="col-md-3 p-l-10">
			<div class="btn-group page_links page-no" role="group">
				<button class="btn btn-default btn-prev disabled prev" data-page="prev" type="button">
					<span class="fas fa-angle-left"></span>
				</button>
				<button class="btn btn-default"><b class="span-page-html">0-0</b> of <b class="span-all-groups">0</b></button>
				<buton class="btn btn-default btn-next disabled next" data-page="next" type="button">
					<span class="fas fa-angle-right"></span>
				</buton>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<div class="table-responsive">
						<table class="table card-table table-vcenter text-nowrap table-head" id="table-recipes">
							<thead >
								<tr>
									<th>Sr.No</th>
									<th>Restaurant Name</th>
									<th>Address</th>
									<th>Contact</th>
									<th>Email</th>
									<th>Password</th>
									<!--<th>Account Expiry Date</th>-->
									<th>Active/Inactive</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody class="tbody-group-list">
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Restaurant</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body show_rest_details">
        
      </div>

    </div>
  </div>
</div>



<!-- The Modal -->
<div class="modal" id="newusers">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add New Users</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
     
      <!-- Modal body -->
      <div class="modal-body">
        <form method="post" action="javascript:;" id="register-form" name="registerform">
											<div class="card-body text-center">
												
												<!-- <h3>Register</h3> -->
												<div class="row">
													<div class="col-md-12">
														<input type="hidden" class="form-control" id="register_as" name="usertype" value="Restaurant">
														<div class="form-group">
															<label class="form-label text-left" for="business_name">Restaurant Name <span >(*)</span></label>
															<input type="text" class="form-control" id="business_name" name="business_name" placeholder="Business Name"  required=""   maxlength="100" style="text-transform: capitalize;">
															<span id="business_name_error" style="color:red;"></span>
														</div>
														<div class="form-group">
															<label class="form-label text-left" for="name">Contact Person <span >(*)</span></label>
															<input type="text" class="form-control" id="name" name="name" placeholder="Name"  required=""   maxlength="100" style="text-transform: capitalize;">
															<!-- <input type="text" class="form-control" id="Last_name" name="last_name" placeholder="Last Name" style="width: 49%;margin-right: 2px;" required=""> -->
														</div>
														<div class="form-group">
															<label class="form-label text-left" for="name">Contact Number <span >(*)</span></label>
															<div class="row">
																<div class="col-lg-4 col-md-4 col-sm-6 col-6">
																<select class="form-control select2-show-search" name="countrycode" id="" selected-value="<?=$user['countrycode'];?>">
																<option data-countryCode="IN" value="91">India (+91)</option>
														<option data-countryCode="GB" value="44" >UK (+44)</option>
														<option data-countryCode="US" value="1">USA (+1)</option>
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
																<div class="col-lg-8 col-md-8 col-sm-6 col-6">
																<input type="text" class="form-control" id="contact_number" name="contact_number" placeholder="Contact Number"  required="" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
																</div>
															</div>
															<!-- <input type="text" class="form-control" id="Last_name" name="last_name" placeholder="Last Name" style="width: 49%;margin-right: 2px;" required=""> -->
														</div>
														<div id="admDivCheck" class="form-group restaurantType">
															<label class="form-label text-left" for="Restaurant Type">Restaurant Type <span >(*)</span></label>
															<select class="form-control" id="restaurant_type" name="restauranttype" placeholder="Restaurant Type" required="">
																<option value="">Select restaurant type</option>
																<option value="veg">Veg</option>
																<option value="nonveg">Non-veg</option>
																<option value="both">Veg / Non-veg</option>
															</select>
														</div>
														<div class="form-group">
															<label class="form-label text-left" for="opening time">Opening Time <span >(*)</span></label>
															<input type="time" class="form-control" name="opening_time" placeholder="Opening Time" required="">
														</div>
														<div class="form-group">
															<label class="form-label text-left" for="closing time">Closing Time <span >(*)</span></label>
															<input type="time" class="form-control" name="close_time" placeholder="Closing Time" required="">
														</div>
														<div class="form-group">
															<label class="form-label text-left" for="exampleInputEmail1">Email Address <span >(*)</span></label>
															<input type="email" class="form-control" id="exampleInputEmail1" name="email" placeholder="Enter email" required="">
														</div>
														<div class="form-group">
															<label class="form-label text-left" for="exampleInputAddress">Address <span >(*)</span></label>
															<input type="text" class="form-control" id="exampleInputEmail1" name="address" placeholder="Enter address" required="">
														</div>
														<div class="form-group">
															<label class="form-label text-left" for="password">Password <span >(*)</span></label>
															<input type="password" class="form-control password-input" id="password" name="password" placeholder="Password" required="" minlength="8" maxlength="30" >
															<span toggle="#password" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>
														</div>
														<div class="form-group">
															<label class="form-label text-left" for="cpassword">Confirm Password <span >(*)</span></label>
															<input type="password" class="form-control password-input" id="cpassword" name="cpassword" placeholder="Confirm Password" required="" minlength="8" maxlength="30" >
															<span toggle="#cpassword" id="confirm_pass" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>
														</div>
														<!-- <div class="form-group">
															<label class="form-label text-left" for="ContactNumber">Contact Number</label>
															<input type="text" class="form-control" id="ContactNumber" name="contact_number" placeholder="Contact Number" required="">
														</div> -->
												
														
														
													</div>
													<!-- <div class="col-md-6">
														<div class="form-group">
															<label class="form-label text-left" for="businessname">Business Name</label>
															<input type="text" class="form-control" id="businessname" name="business_name" placeholder="Business Name" required="">
														</div>
														<div class="form-group">
															<label class="form-label text-left" for="Address">Address</label>
															<input type="text" name="address" class="form-control" required="">
														</div>
														<div class="form-group">
															<label for="city" class="text-left form-label">City</label>
															<input type="text" name="city" class="form-control" required="">
														</div>
														<div class="form-group">
															<label for="Country" class="text-left form-label">Country</label>
															<input type="text" name="country" class="form-control" required="">
														</div>
														<div class="form-group">
															<label for="Postal Code" class="text-left form-label">Postal Code</label>
															<input type="text" name="postcode" class="form-control" required="">
														</div>
													</div> -->
												</div>
												<div class="text-center">
													<button type="submit" class="btn btn-primary">Register</button>
												</div>
											</div>
										</form>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
      </div>

    </div>
  </div>
</div>

		
	</div>
	<script type="text/javascript">
	
	 $(".toggle-password").click(function() {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
        $('.password-input').on('keypress',function(e){
            if(e.which === 32) 
                return false;
        });
		    $(document).ready(function() {

				// $('#business_name').blur(function(){
				// 	var regex = /^[a-zA-Z ]*$/;
        		// var isValid = regex.test($('#business_name').val());
        		// if (!isValid) {
            	// 	swal("error!", "Please Enter valid Business name", "error");
				// 	$('#business_name').val('');
        		// }
				// });
				$('#business_name').on('keypress',function(e){
				var regex = new RegExp("^[a-zA-Z ]+$");
				    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
				    if (regex.test(str)) {
				        return true;
				    }
				    e.preventDefault();
				    return false;
				});

	// 			if($('#contact_number').val()){
	// 				swal("error!", "Please Enter Contact Number", "error");
    //             return false;
    //        }
    //        if($('#contact_number').val().length <5 || $('#contact_number').val().length >14){
    //         swal("error!", "Contact Number should be 5 to 14 digit in length", "error");
    //         return false;
    //    }
		      	
		      	 $('.password-input').on('keypress',function(e){
		            if(e.which === 32) 
		        		return false;
		        });

		      	$('#name').on('keypress',function(e){
		      		var regex = new RegExp("^[a-zA-Z ]+$");
				    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
				    if (regex.test(str)) {
				        return true;
				    }
				    e.preventDefault();
				    return false;
		      	});
		      	$("#register-form").validate({
				    // Specify validation rules
				    rules: {
				      	usertype:"required",
				      	name: {
				      		required: true,
				        	maxlength: 100
				      	},
				      	business_name:{
				      		required: true,
				        	maxlength: 100
				      	},
				        email: {
					        required: true,
					        email: true
					    },
				      	password: {
					        required: true,
					        minlength: 8,
					        maxlength: 30
				      	},
				      	cpassword: {
					        required: true,
					        minlength: 8,
					        maxlength: 30
				      	},
						contact_number: {
					        required: true,
					        minlength: 5,
					        maxlength: 14
				      	}
				    },
				    // Specify validation error messages
				    messages: {
				    	usertype: "Please select usertype",
						name: "Please enter your name",
						business_name: "Please enter your business name",
						password: {
							required: "Please provide a password",
							minlength: "Passwords must be at least 8 and maximum 30 characters in length",
							maxlength:"Passwords must be at least 8 and maximum 30 characters in length"
						},
						cpassword: {
							required: "Please provide a password",
							minlength: "Passwords must be at least 8 and maximum 30 characters in length",
							maxlength:"Passwords must be at least 8 and maximum 30 characters in length"
						},
						contact_number: {
							required: "Please provide a contact number",
							minlength: "contact number must be at least 5 and maximum 14 digit in length",
							maxlength:"contact number must be at least 5 and maximum 14 digit in length"
						},
						email: "Please enter a valid email address"
				    },
				    // Make sure the form is submitted to the destination defined
				    // in the "action" attribute of the form when valid
				    submitHandler: function(form) {
				      form.submit();
				    }
				});
		    });
		</script>
		
		<script>
		$('#register-form').on('submit',function(){
			if ($(this).valid()) 
		{
            if($('#password').val()!=$('#cpassword').val())
			{
				swal("Error !","Password and Confirm password not match please try again.","error");
                 return false;
            }
			
			//         if($('#contact_number').val()){
			//             Login.displaywarning("Contact Number is required.");
			//             return false;
			//        }
			//        if($('#contact_number').val().length <5 || $('#contact_number').val().length >14){
			//         Login.displaywarning("Contact number should be 5 to 14 digit in length.");
			//         return false;
			//    }
			
            
			
            $('#image-loader').show();
            var $form_data = new FormData();
			
            $('#register-form').serializeArray().forEach(function(field)
			{
                $form_data.append(field.name, field.value);
            });
			
            $.ajax({
                url: "<?=base_url()?>login/register_user",
                type:'POST',
                data: $form_data,
                processData:false,
                contentType:false,
                cache:false,
                success: function(result)
				{
                    $('#image-loader').hide();
					
                    if (result.status) 
					{ 
                        //Login.displaysucess(result.msg);
                        $('#register-form input').val('');
                        swal({
                            title:"Success !", 
                            text:'Account created successfully', 
                            type:"success",
                            confirmButtonClass: "btn-primary",
                            confirmButtonText: "Ok",
                            closeOnConfirm: false
                        },function(){
                            location.reload();
                        });
                       /* setTimeout(function(){
                            window.location.href=Login.base_url+"login";
                        }, 2000);*/
                        //window.location.href=Login.base_url+"login";
                       
                    }
					else 
					{
                        if(result.msg)
						{
                            swal("Error !",result.msg,"error");
                        }
                        else
						{
                            Login.displaywarning("Something went wrong please try again");
						}
                    }
                }
           });
		}
        });
		</script>
	
<script src="<?=base_url();?>assets/js/custom/Allrestaurants.js?v=2"></script>
		<script src="<?=base_url();?>assets/plugins/select2/select2.full.min.js"></script>
		
<script type="text/javascript">
	Allrestaurants.base_url="<?=base_url();?>";
	Allrestaurants.init();
	/*$('.recipe-tabs').find('.receipes .card-body').addClass('active');*/
</script>



	</div>
</div>
<!-- <script src="<?=base_url()?>assets/js/index4.js"></script> -->
<?php 
require_once('footer.php');
?>