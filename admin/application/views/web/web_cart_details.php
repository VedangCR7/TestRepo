<?php
require_once('web_header.php');
require_once "stripe/config.php";

if($restaurant_type[0]['restauranttype'] == 'both')
{
	$recipe_type = '';
}
if($restaurant_type[0]['restauranttype'] == 'veg')
{
	$recipe_type = 'veg';
}
if($restaurant_type[0]['restauranttype'] == 'nonveg')
{
	$recipe_type = 'nonveg';
}
?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/web/cartcss/vendor/slick/slick.min.css"/>
      <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/web/cartcss/vendor/slick/slick-theme.min.css"/>
      <!-- Icofont Icon-->
      <link href="<?=base_url()?>assets/web/cartcss/vendor/icons/icofont.min.css" rel="stylesheet" type="text/css">
      <!-- Bootstrap core CSS -->
      <link href="<?=base_url()?>assets/web/cartcss/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <!-- Custom styles for this template -->
      <link href="<?=base_url()?>assets/web/cartcss/css/style.css" rel="stylesheet">
      <!-- Sidebar CSS -->
      <link href="<?=base_url()?>assets/web/cartcss/vendor/sidebar/demo.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<style>

.osahan-accor {
    border-bottom: 2px solid #28a745 !important;
}
.pt-3, .py-3 {
    padding-top: 0rem!important;
}
.pb-5, .py-5 {
    padding-bottom: 0rem!important;
}
.schedule .nav-link.active, .schedule .nav-link:focus {
    color: #28a744 !important;
}
span.c-number {
    width: 32px;
    border: 1px solid #28a744;
    color: #28a744;
    height: 32px;
    border-radius: 50px;
    display: flex;
    align-items: center;
    font-size: 16px;
    justify-content: center;
    margin: 0 14px 0 0px;
}
</style>
   <body class="fixed-bottom-padding">
      <!-- Nav bar -->
      <!-- bread_cum -->
      <div class="osahan-checkout" style="display: none;">
        <div class="bg-success border-bottom px-2 pt-3 pb-5 d-flex align-items-center">
            <a href='<?=base_url();?>menus/<?=$main_menu_id;?>/<?=$restid;?>/<?=$tableid;?>?recipetype=<?=$recipe_type?>&list_view=yes&is_website=yes' id="backLink" class="bckToMainPage" style="padding: 7px 7px;">
                <img src="<?=base_url();?>assets/images/back-arrow.png" style="width: 30px;">
            </a>
            <h4 class="font-weight-bold m-0 text-white pl-5">Order</h4>
            <!-- <a class="btn btn-outline-dark text-white ml-5 float-right" href="<?=base_url();?>menus/<?=$main_menu_id;?>/<?=$restid;?>/<?=$tableid;?>?recipetype=<?=$recipe_type?>&list_view=yes&is_website=yes" style="position: absolute;right: 9px;"><i class="fas feather-plus"></i> Add Menu</a> -->
        </div>
        </div>
      <!-- <nav aria-label="breadcrumb" class="breadcrumb mb-0">
         <div class="container">
            <ol class="d-flex align-items-center mb-0 p-0">
               <li class="breadcrumb-item"><a href="#" class="text-success">Home</a></li>
               <li class="breadcrumb-item active" aria-current="page">Cart</li>
            </ol>
         </div>
      </nav> -->
      <section class="py-4 osahan-main-body osahan-checkout" style="display: none;">
         <div class="container">
            <div class="row">
               <div class="col-lg-8">
                <input type="radio" name="supply_option" class="supply_option" value="Collection" checked style="width:auto;">&nbsp;Collection&nbsp;&nbsp;
                <input type="radio" name="supply_option" class="supply_option" value="Delivery" style="width:auto;">&nbsp;Delivery
                  <div class="accordion" id="accordionExample" style="margin-top:20px;">
                     <!-- cart items -->
                     <div class="card border-0 osahan-accor rounded shadow-sm overflow-hidden">
                        <!-- cart header -->
                        <div class="card-header bg-white border-0 p-0" id="headingOne">
                           <h2 class="mb-0">
                              <button class="btn d-flex align-items-center bg-white btn-block text-left btn-lg h5 px-3 py-4 m-0" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                              <span class="c-number">1</span> Cart Items <a class="btn btn-outline-success text-dark ml-5 float-right" href="<?=base_url();?>menus/<?=$main_menu_id;?>/<?=$restid;?>/<?=$tableid;?>?recipetype=<?=$recipe_type?>&list_view=yes&is_website=yes" style="position: absolute;right: 9px;"><i class="fas feather-plus"></i> Add Menu</a>
                              </button>
                           </h2>
                        </div>
                        <!-- body cart items -->
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                           <div class="card-body p-0 border-top">
                            <div class="bg-white rounded cart-item-list">

                            </div>
                           </div>
                        </div>
                     </div>
                     <!-- cart address -->
                     <div class="card border-0 osahan-accor rounded shadow-sm overflow-hidden mt-3" style="display:none;" id="show_address_box">
                        <!-- address header -->
                        <div class="card-header bg-white border-0 p-0" id="headingtwo">
                           <h2 class="mb-0">
                              <button class="btn d-flex align-items-center bg-white btn-block text-left btn-lg h5 px-3 py-4 m-0" type="button" data-toggle="collapse" data-target="#collapsetwo" aria-expanded="true" aria-controls="collapsetwo">
                              <span class="c-number">2</span> Order Address <a href="#"  data-toggle="modal" data-target="#exampleModal" class="text-decoration-none text-success ml-auto" id="new_address"> <i class="icofont-plus-circle mr-1"></i>Add New Delivery Address</a>
                              </button>
                           </h2>
                        </div>
                        <div id="collapsetwo" class="collapse" aria-labelledby="headingtwo" data-parent="#accordionExample">
                           <div class="card-body p-0 border-top">
                              <div class="osahan-order_address">
                                 <div class="p-3 row show_address">
                                    <a href="#" class="btn btn-success btn-lg btn-block mt-3" type="button" data-toggle="collapse" data-target="#collapsethree" aria-expanded="true" aria-controls="collapsethree">Continue</a>
                                 </div>
                              </div>
                           </div>
                        </div>
                        
                        <!-- body address -->
                        <!-- <div id="collapsetwo" class="collapse" aria-labelledby="headingtwo" data-parent="#accordionExample">
                           <div class="card-body p-0 border-top">
                              <div class="osahan-order_address">
                                 <div class="p-3 row" style="margin:3px;">
                                 <textarea placeholder="Delivery Address" rows="5" aria-label="With textarea" class="form-control input-delivery" name="delivery_address"></textarea>
                                 </div>
                              </div>
                           </div>
                        </div> -->
                     </div>
                     <!-- cart delivery -->
                     <!-- <div class="card border-0 osahan-accor rounded shadow-sm overflow-hidden mt-3">
                        delivery header
                            <div class="card-header bg-white border-0 p-0" id="headingthree">
                           <h2 class="mb-0">
                              <button class="btn d-flex align-items-center bg-white btn-block text-left btn-lg h5 px-3 py-4 m-0" type="button" data-toggle="collapse" data-target="#collapsethree" aria-expanded="true" aria-controls="collapsethree">
                              <span class="c-number">3</span> Delivery Time
                              </button>
                           </h2>
                        </div>body delivery
                            <div id="collapsethree" class="collapse" aria-labelledby="headingthree" data-parent="#accordionExample">
                           <div class="card-body p-0 border-top">
                              <div class="osahan-order_address">
                                 <div class="text-center mb-4 py-4">
                                    <p class="display-2"><i class="icofont-ui-calendar text-success"></i></p>
                                    <p class="mb-1">Your Current Slot:</p>
                                    <h6 class="font-weight-bold text-dark">Tommorow, 6AM - 10AM</h6>
                                 </div>
                                 <div class="schedule">
                                    <ul class="nav nav-tabs justify-content-center nav-fill" id="myTab" role="tablist">
                                       <li class="nav-item" role="presentation">
                                          <a class="nav-link active text-dark" id="mon-tab" data-toggle="tab" href="#mon" role="tab" aria-controls="mon"
                                             aria-selected="true">
                                             <p class="mb-0 font-weight-bold">MON</p>
                                             <p class="mb-0">7 Sep</p>
                                          </a>
                                       </li>
                                       <li class="nav-item" role="presentation">
                                          <a class="nav-link text-dark" id="tue-tab" data-toggle="tab" href="#tue" role="tab" aria-controls="tue"
                                             aria-selected="false">
                                             <p class="mb-0 font-weight-bold">TUE</p>
                                             <p class="mb-0">8 Sep</p>
                                          </a>
                                       </li>
                                       <li class="nav-item" role="presentation">
                                          <a class="nav-link text-dark" id="wed-tab" data-toggle="tab" href="#wed" role="tab" aria-controls="wed"
                                             aria-selected="false">
                                             <p class="mb-0 font-weight-bold">WED</p>
                                             <p class="mb-0">9 Sep</p>
                                          </a>
                                       </li>
                                       <li class="nav-item" role="presentation">
                                          <a class="nav-link text-dark" id="thu-tab" data-toggle="tab" href="#thu" role="tab" aria-controls="thu"
                                             aria-selected="false">
                                             <p class="mb-0 font-weight-bold">THU</p>
                                             <p class="mb-0">10 Sep</p>
                                          </a>
                                       </li>
                                       <li class="nav-item" role="presentation">
                                          <a class="nav-link text-dark" id="fri-tab" data-toggle="tab" href="#fri" role="tab" aria-controls="fri"
                                             aria-selected="false">
                                             <p class="mb-0 font-weight-bold">FRI</p>
                                             <p class="mb-0">11 Sep</p>
                                          </a>
                                       </li>
                                       <li class="nav-item" role="presentation">
                                          <a class="nav-link text-dark" id="sat-tab" data-toggle="tab" href="#sat" role="tab" aria-controls="sat"
                                             aria-selected="false">
                                             <p class="mb-0 font-weight-bold">SAT</p>
                                             <p class="mb-0">12 Sep</p>
                                          </a>
                                       </li>
                                    </ul>
                                    <div class="tab-content filter bg-white" id="myTabContent">
                                       <div class="tab-pane fade show active" id="mon" role="tabpanel" aria-labelledby="mon-tab">
                                          <div class="custom-control border-bottom px-0 custom-radio">
                                             <input class="custom-control-input" type="radio" name="exampleRadios" id="mon1" value="mon1" checked>
                                             <label class="custom-control-label py-3 w-100 px-3" for="mon1">
                                             <i class="icofont-clock-time mr-2"></i> 6AM - 10AM
                                             </label>
                                          </div>
                                          <div class="custom-control border-bottom px-0 custom-radio">
                                             <input class="custom-control-input" type="radio" name="exampleRadios" id="mon2" value="mon2">
                                             <label class="custom-control-label py-3 w-100 px-3" for="mon2">
                                             <i class="icofont-clock-time mr-2"></i> 4PM - 6AM
                                             </label>
                                          </div>
                                          <div class="custom-control border-bottom px-0 custom-radio">
                                             <input class="custom-control-input" type="radio" name="exampleRadios" id="mon3" value="mon3">
                                             <label class="custom-control-label py-3 w-100 px-3" for="mon3">
                                             <i class="icofont-clock-time mr-2"></i> 6PM - 9PM
                                             </label>
                                          </div>
                                          <div class="custom-control border-bottom px-0 custom-radio">
                                             <input class="custom-control-input" type="radio" name="exampleRadios" id="mon4" value="mon4">
                                             <label class="custom-control-label py-3 w-100 px-3" for="mon4">
                                             <i class="icofont-clock-time mr-2"></i> 10AM - 1PM
                                             </label>
                                          </div>
                                       </div>
                                       <div class="tab-pane fade" id="tue" role="tabpanel" aria-labelledby="tue-tab">
                                          <div class="custom-control border-bottom px-0 custom-radio">
                                             <input class="custom-control-input" type="radio" name="exampleRadios" id="tue1" value="tue1" checked>
                                             <label class="custom-control-label py-3 w-100 px-3" for="tue1">
                                             <i class="icofont-clock-time mr-2"></i> 6AM - 10AM
                                             </label>
                                          </div>
                                          <div class="custom-control border-bottom px-0 custom-radio">
                                             <input class="custom-control-input" type="radio" name="exampleRadios" id="tue2" value="tue2">
                                             <label class="custom-control-label py-3 w-100 px-3" for="tue2">
                                             <i class="icofont-clock-time mr-2"></i> 4PM - 6AM
                                             </label>
                                          </div>
                                          <div class="custom-control border-bottom px-0 custom-radio">
                                             <input class="custom-control-input" type="radio" name="exampleRadios" id="tue3" value="tue3">
                                             <label class="custom-control-label py-3 w-100 px-3" for="tue3">
                                             <i class="icofont-clock-time mr-2"></i> 6PM - 9PM
                                             </label>
                                          </div>
                                          <div class="custom-control border-bottom px-0 custom-radio">
                                             <input class="custom-control-input" type="radio" name="exampleRadios" id="tue4" value="tue4">
                                             <label class="custom-control-label py-3 w-100 px-3" for="tue4">
                                             <i class="icofont-clock-time mr-2"></i> 10AM - 1PM
                                             </label>
                                          </div>
                                       </div>
                                       <div class="tab-pane fade" id="wed" role="tabpanel" aria-labelledby="wed-tab">
                                          <div class="custom-control border-bottom px-0 custom-radio">
                                             <input class="custom-control-input" type="radio" name="exampleRadios" id="wed1" value="wed1" checked>
                                             <label class="custom-control-label py-3 w-100 px-3" for="wed1">
                                             <i class="icofont-clock-time mr-2"></i> 6AM - 10AM
                                             </label>
                                          </div>
                                          <div class="custom-control border-bottom px-0 custom-radio">
                                             <input class="custom-control-input" type="radio" name="exampleRadios" id="wed2" value="wed2">
                                             <label class="custom-control-label py-3 w-100 px-3" for="wed2">
                                             <i class="icofont-clock-time mr-2"></i> 4PM - 6AM
                                             </label>
                                          </div>
                                          <div class="custom-control border-bottom px-0 custom-radio">
                                             <input class="custom-control-input" type="radio" name="exampleRadios" id="wed3" value="wed3">
                                             <label class="custom-control-label py-3 w-100 px-3" for="wed3">
                                             <i class="icofont-clock-time mr-2"></i> 6PM - 9PM
                                             </label>
                                          </div>
                                          <div class="custom-control border-bottom px-0 custom-radio">
                                             <input class="custom-control-input" type="radio" name="exampleRadios" id="wed4" value="wed4">
                                             <label class="custom-control-label py-3 w-100 px-3" for="wed4">
                                             <i class="icofont-clock-time mr-2"></i> 10AM - 1PM
                                             </label>
                                          </div>
                                       </div>
                                       <div class="tab-pane fade" id="thu" role="tabpanel" aria-labelledby="thu-tab">
                                          <div class="custom-control border-bottom px-0 custom-radio">
                                             <input class="custom-control-input" type="radio" name="exampleRadios" id="thu1" value="thu1" checked>
                                             <label class="custom-control-label py-3 w-100 px-3" for="thu1">
                                             <i class="icofont-clock-time mr-2"></i> 6AM - 10AM
                                             </label>
                                          </div>
                                          <div class="custom-control border-bottom px-0 custom-radio">
                                             <input class="custom-control-input" type="radio" name="exampleRadios" id="thu2" value="thu2">
                                             <label class="custom-control-label py-3 w-100 px-3" for="thu2">
                                             <i class="icofont-clock-time mr-2"></i> 4PM - 6AM
                                             </label>
                                          </div>
                                          <div class="custom-control border-bottom px-0 custom-radio">
                                             <input class="custom-control-input" type="radio" name="exampleRadios" id="thu3" value="thu3">
                                             <label class="custom-control-label py-3 w-100 px-3" for="thu3">
                                             <i class="icofont-clock-time mr-2"></i> 6PM - 9PM
                                             </label>
                                          </div>
                                          <div class="custom-control border-bottom px-0 custom-radio">
                                             <input class="custom-control-input" type="radio" name="exampleRadios" id="thu4" value="thu4">
                                             <label class="custom-control-label py-3 w-100 px-3" for="thu4">
                                             <i class="icofont-clock-time mr-2"></i> 10AM - 1PM
                                             </label>
                                          </div>
                                       </div>
                                       <div class="tab-pane fade" id="fre" role="tabpanel" aria-labelledby="fre-tab">
                                          <div class="custom-control border-bottom px-0 custom-radio">
                                             <input class="custom-control-input" type="radio" name="exampleRadios" id="fri1" value="fri1" checked>
                                             <label class="custom-control-label py-3 w-100 px-3" for="fri1">
                                             <i class="icofont-clock-time mr-2"></i> 6AM - 10AM
                                             </label>
                                          </div>
                                          <div class="custom-control border-bottom px-0 custom-radio">
                                             <input class="custom-control-input" type="radio" name="exampleRadios" id="fri2" value="fri2">
                                             <label class="custom-control-label py-3 w-100 px-3" for="fri2">
                                             <i class="icofont-clock-time mr-2"></i> 4PM - 6AM
                                             </label>
                                          </div>
                                          <div class="custom-control border-bottom px-0 custom-radio">
                                             <input class="custom-control-input" type="radio" name="exampleRadios" id="fri3" value="fri3">
                                             <label class="custom-control-label py-3 w-100 px-3" for="fri3">
                                             <i class="icofont-clock-time mr-2"></i> 6PM - 9PM
                                             </label>
                                          </div>
                                          <div class="custom-control border-bottom px-0 custom-radio">
                                             <input class="custom-control-input" type="radio" name="exampleRadios" id="fri4" value="fri4">
                                             <label class="custom-control-label py-3 w-100 px-3" for="fri4">
                                             <i class="icofont-clock-time mr-2"></i> 10AM - 1PM
                                             </label>
                                          </div>
                                       </div>
                                       <div class="tab-pane fade" id="sat" role="tabpanel" aria-labelledby="sat-tab">
                                          <div class="custom-control border-bottom px-0 custom-radio">
                                             <input class="custom-control-input" type="radio" name="exampleRadios" id="sat1" value="sat1" checked>
                                             <label class="custom-control-label py-3 w-100 px-3" for="sat1">
                                             <i class="icofont-clock-time mr-2"></i> 6AM - 10AM
                                             </label>
                                          </div>
                                          <div class="custom-control border-bottom px-0 custom-radio">
                                             <input class="custom-control-input" type="radio" name="exampleRadios" id="sat2" value="sat2">
                                             <label class="custom-control-label py-3 w-100 px-3" for="sat2">
                                             <i class="icofont-clock-time mr-2"></i> 4PM - 6AM
                                             </label>
                                          </div>
                                          <div class="custom-control border-bottom px-0 custom-radio">
                                             <input class="custom-control-input" type="radio" name="exampleRadios" id="sat3" value="sat3">
                                             <label class="custom-control-label py-3 w-100 px-3" for="sat3">
                                             <i class="icofont-clock-time mr-2"></i> 6PM - 9PM
                                             </label>
                                          </div>
                                          <div class="custom-control border-bottom px-0 custom-radio">
                                             <input class="custom-control-input" type="radio" name="exampleRadios" id="sat4" value="sat4">
                                             <label class="custom-control-label py-3 w-100 px-3" for="sat4">
                                             <i class="icofont-clock-time mr-2"></i> 10AM - 1PM
                                             </label>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="p-3">
                                 <a href="#" class="btn btn-success btn-lg btn-block" type="button" data-toggle="collapse" data-target="#collapsefour" aria-expanded="true" aria-controls="collapsefour">Schedule Order</a>
                              </div>
                           </div>
                        </div>
                     </div> -->
                     <!-- cart payment -->
					<span style="margin-top:20px;display:none;"  id="show_or_not_cod_option">
						<input type="radio" name="delivery_payment" class="delivery_payment" value="COD" checked style="width:auto;margin-top:20px;">&nbsp;Cash on delivery&nbsp;&nbsp;
						<input type="radio" name="delivery_payment" class="delivery_payment" value="payment" style="width:auto;margin-top:20px;">&nbsp;Payment
					</span>
                     <div class="card border-0 osahan-accor rounded shadow-sm overflow-hidden mt-3" id="show_payment_tab">
                        <!-- payment header -->
                        <div class="card-header bg-white border-0 p-0" id="headingfour">
                           <h2 class="mb-0">
                              <button class="btn d-flex align-items-center bg-white btn-block text-left btn-lg h5 px-3 py-4 m-0" type="button" data-toggle="collapse" data-target="#collapsefour" aria-expanded="true" aria-controls="collapsefour">
                              <span class="c-number"><span class="payment_count_change">2</span></span> Payment
                              </button>
                           </h2>
                        </div>
                        <!-- body payment -->
                        <div id="collapsefour" class="collapse" aria-labelledby="headingfour" data-parent="#accordionExample">
                           <div class="card-body px-3 pb-3 pt-1 border-top">
                              <div class="schedule">
                                 <ul class="nav nav-tabs justify-content-center nav-fill" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                       <a class="nav-link active text-dark" id="credit-tab" data-toggle="tab" href="#credit" role="tab" aria-controls="credit"
                                          aria-selected="true">
                                          <p class="mb-0 font-weight-bold"><i class="feather-credit-card mr-2"></i> Credit/Debit Card</p>
                                       </a>
                                    </li>
                                    <!-- <li class="nav-item" role="presentation">
                                       <a class="nav-link text-dark" id="banking-tab" data-toggle="tab" href="#banking" role="tab" aria-controls="banking"
                                          aria-selected="false">
                                          <p class="mb-0 font-weight-bold"><i class="icofont-globe mr-2"></i> Net Banking</p>
                                       </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                       <a class="nav-link text-dark" id="cash-tab" data-toggle="tab" href="#cash" role="tab" aria-controls="cash"
                                          aria-selected="false">
                                          <p class="mb-0 font-weight-bold"><i class="icofont-dollar mr-2"></i> Cash on Delivery</p>
                                       </a>
                                    </li> -->
                                 </ul>
                                 <div class="tab-content bg-white" id="myTabContent">
                                    <div class="tab-pane fade show active" id="credit" role="tabpanel" aria-labelledby="credit-tab">
                                       <div class="osahan-card-body pt-3">
                                          <p class="small">WE ACCEPT <span class="osahan-card ml-2 font-weight-bold">( Master Card / Visa Card / Rupay )</span></p>
                                          <form>
                                             <div class="form-row">
                                                <div class="col-md-12 form-group">
                                                   <label class="form-label font-weight-bold small">Card number</label>
                                                   <div class="input-group">
                                                      <input placeholder="Card number" type="number" class="form-control" id="card_number">
                                                      <div class="input-group-append"><button id="button-addon2" type="button" class="btn btn-outline-secondary"><i class="feather-credit-card"></i></button></div>
                                                   </div>
                                                </div>
                                                <div class="col-md-8 form-group"><label class="form-label font-weight-bold small">Valid through(MM/YYYY)</label><input placeholder="Enter Valid through(MM/YYYY)" type="text" class="form-control" id="valid_through"></div>
                                                <div class="col-md-4 form-group"><label class="form-label font-weight-bold small">CVV</label><input placeholder="Enter CVV Number" type="number" class="form-control" id="cvv"></div>
                                                <div class="col-md-12 form-group">
                                                   <label class="form-label font-weight-bold small">Name on card</label>
                                                   <input placeholder="Enter Name" type="text" class="form-control" id="name_on_card">
                                                   
                                                </div>
                                                <input type="hidden" id="PUBLISHABLE_KEY" name="PUBLISHABLE_KEY" value="<?php echo STRIPE_PUBLISHABLE_KEY; ?>">
                                                   <input type="hidden" id="SECRET_KEY" name="SECRET_KEY" value="<?php echo STRIPE_SECRET_KEY; ?>">
												               <input type="hidden" id="stripeToken" name="stripeToken">
                                                
                                                <!-- <div class="col-md-12 form-group">
                                                <div class="col-md-12 form-group"><label class="form-label font-weight-bold small">Name on card</label><input placeholder="Enter Card number" type="text" class="form-control" id="name_on_card"></div>
                                                <input type="hidden" id="PUBLISHABLE_KEY" name="PUBLISHABLE_KEY" value="<?php echo STRIPE_PUBLISHABLE_KEY; ?>">
                                                <input type="hidden" id="SECRET_KEY" name="SECRET_KEY" value="<?php echo STRIPE_SECRET_KEY; ?>">
												<input type="hidden" id="stripeToken" name="stripeToken"/>
												<!-- <div class="col-md-12 form-group">
                                                   <div class="custom-control custom-checkbox"> -->
                                                      <!-- <input type="checkbox" id="custom-checkbox1" class="custom-control-input"> -->
                                                      <!-- <label title="" type="checkbox" for="custom-checkbox1" class="custom-control-label small pt-1">Securely save this card for a faster checkout next time.</label> -->
                                                   <!-- </div>
                                                </div> -->
                                             </div>
                                          </form>
                                       </div>
                                    </div>
                                    <div class="tab-pane fade" id="banking" role="tabpanel" aria-labelledby="banking-tab">
                                       <div class="osahan-card-body pt-3">
                                          <form>
                                             <div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
                                                <label class="btn btn-outline-secondary active">
                                                <input type="radio" name="options" id="option1" checked=""> HDFC
                                                </label>
                                                <label class="btn btn-outline-secondary">
                                                <input type="radio" name="options" id="option2"> ICICI
                                                </label>
                                                <label class="btn btn-outline-secondary">
                                                <input type="radio" name="options" id="option3"> AXIS
                                                </label>
                                             </div>
                                             <div class="form-row pt-3">
                                                <div class="col-md-12 form-group">
                                                   <label class="form-label small font-weight-bold">Select Bank</label><br>
                                                   <select class="custom-select form-control">
                                                      <option>Bank</option>
                                                      <option>KOTAK</option>
                                                      <option>SBI</option>
                                                      <option>UCO</option>
                                                   </select>
                                                </div>
                                             </div>
                                          </form>
                                       </div>
                                    </div>
                                    <div class="tab-pane fade" id="cash" role="tabpanel" aria-labelledby="cash-tab">
                                       <div class="custom-control custom-checkbox pt-3">
                                          <input type="checkbox" class="custom-control-input" id="customControlAutosizing">
                                          <label class="custom-control-label" for="customControlAutosizing">
                                             <b>Cash</b><br>
                                             <p class="small text-muted m-0">Please keep exact change handy to help us serve you better</p>
                                          </label>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <!-- <a href="checkout.html" class="btn btn-success btn-lg btn-block mt-3 btn-place-order" type="button">Continue</a> -->
                           </div>
                        </div>
                     </div>
                     <!-- <a class="btn btn-success btn-block btn-lg btn-place-order" href="javascript:;" style="margin-top:20px;">Place Your order<i class="icofont-long-arrow-right"></i></a> -->
                  </div>
               </div>
               <div class="col-lg-4">
                  <div class="sticky_sidebar">
						
					<div class="bg-white rounded overflow-hidden shadow-sm mb-3 checkout-sidebar" style="margin-top:39px;">
                        <div class="d-flex align-items-center osahan-cart-item-profile border-bottom bg-white p-3">
                           <img alt="osahan" src="<?=$user['profile_photo']; ?>" class="mr-3 rounded-circle img-fluid">
                           <div class="d-flex flex-column">
                              <h6 class="mb-1 font-weight-bold">Hello <?=$customer['name'];?>,</h6>
                              <p class="mb-0 small text-muted"><i class="feather-map-pin"></i> Your Order</p>
                           </div>
                        </div>
                        <div>
                           <div class="bg-white p-3 clearfix" id="addon_details_show_cart">
								
                           </div>
                        </div>
                     </div>
					 
                     <div class="bg-white rounded overflow-hidden shadow-sm mb-3 checkout-sidebar">
                        <div>
                           <div class="bg-white p-3 clearfix">
								<p class="font-weight-bold small mb-2">Bill Details</p>
								<p class="mb-1">Item Total <span class="small text-muted"></span> <span class="float-right text-dark item-total">$0</span></p>
								<p class="mb-1">CGST(0.00%) <span class="small text-muted"></span> <span class="float-right text-dark cgst">$0</span></p>
								
                        <p class="mb-1">SGST(0.00%) <span class="small text-muted"></span> <span class="float-right text-dark sgst">$0</span></p>
								
                     <!-- delivery fee addex by victor -->
                     
                        <p class="mb-1" id="deliver">Delivery Fee <span class="small text-muted"></span> <span class="float-right text-dark del-fee">$0</span></p>
                
                        <p hidden class='delivery_fee'> <?=$user['delivery_fee']?> </p>

                      <!-- delivery fee here  -->
								<h6 class="mb-0 text-success" style="margin-left:-2px;">Total Discount<span class="float-right text-success total-discount">$0</span></h6>
								<div class="mb-3" style="margin-top: 1rem!important;">
								   <div class="mb-0 input-group">
									  <div class="input-group-prepend">
										<span class="input-group-text">
										  <i class="feather-message-square"></i>
										</span>
									  </div>
									  <textarea placeholder="Any suggestions? We will pass it on..." aria-label="With textarea" class="form-control input-suggestion" name="suggetion"></textarea>
								   </div>
								</div>
                           </div>
                           <div class="p-3 border-top">
                              <h5 class="mb-0">TO PAY  <input type="hidden" class="total_net_amount" value="0"><span class="float-right text-danger net-amount">$0</span></h5>
                           </div>
                        </div>
                     </div>
                     <a class="btn btn-success btn-block btn-lg btn-place-order1" href="javascript:;" style="margin-top:20px;height: 50px;padding: 13px;font-size: 15px;">Place Your order<i class="icofont-long-arrow-right"></i></a>
                  </div>
               </div>
            </div>
         </div> 
      </section>


   <div class="promo-area div-order-success" style="background-image: url('<?=base_url();?>assets/web/images/mobile bg.png');background-repeat: no-repeat;background-size: cover;background-position: center;display: none;">
    <div class="container">
        <div class="row align-items-center h-100">
            <div class="col-lg-12 vh-100 div-select-menu">
                <div class="promo-wrap promo-2">
                    <div class="logo mt-5">
                      <?php
                        if($user['profile_photo']=="assets/images/users/user.png" || $user['profile_photo']==""){
                      ?>
                        <a href="#">
                          <img src="<?php echo base_url().$user['profile_photo']; ?>" alt="">
                        </a>
                        <?php
                            }else{
                        ?>
                        <a href="#">
                          <img src="<?php echo $user['profile_photo']; ?>" alt="">
                        </a>
                        <?php
                        }
                        ?>
                       <h4 class="mt-4 mb-2 thank-you-text">
                            <?=$customer['name'];?>,<br>
                            Thank you for ordering
                       </h4>
                    </div>
                    <div class="promo-option mt-5 pt-3">
                        <a href="<?=base_url();?>menus/<?=$main_menu_id;?>/<?=$restid;?>/<?=$tableid;?>?recipetype=<?=$recipe_type?>&list_view=yes&is_website=yes"  class="btn btn-outline-success p-4 pl-5 pr-5 btn-lg" style="font-weight: 800;">Menu Card</a>
                    </div>
                    <a class="btn btn-success btn-block btn-lg fixed-bottom" href="javascript:;" style="cursor:default;height: 75px;border-radius: 0px;"></a>
                     <!-- <a class="btn btn-success btn-block btn-lg fixed-bottom btn-place-order1" href="javascript:;" style="height: 75px;border-radius: 0px;"></a> -->
                </div>
            </div>
        </div>
    </div>
</div>
<div class="promo-area div-no-item" style="background-image: url('<?=base_url();?>assets/web/images/mobile bg.png');background-repeat: no-repeat;background-size: cover;background-position: center;display: none;">
    <div class="container">
        <div class="row align-items-center h-100">
            <div class="col-lg-12 vh-100 div-select-menu">
                <div class="promo-wrap promo-2">
                    <div class="logo mt-5">
                      <?php
                        if($user['profile_photo']=="assets/images/users/user.png" || $user['profile_photo']==""){
                      ?>
                        <a href="#">
                          <img src="<?php echo base_url().$user['profile_photo']; ?>" alt="">
                        </a>
                        <?php
                            }else{
                        ?>
                        <a href="#">
                          <img src="<?php echo $user['profile_photo']; ?>" alt="">
                        </a>
                        <?php
                        }
                        ?>
                       <h4 class="mt-2 mb-2 warning-text">
                            <?=$customer['name'];?>,<br>
                            Sorry no menu available in cart
                       </h4>
                    </div>
                    <div class="promo-option mt-3 pt-3">
                        <a href="<?=base_url();?>menus/<?=$main_menu_id;?>/<?=$restid;?>/<?=$tableid;?>?recipetype=<?=$recipe_type?>&list_view=yes&is_website=yes"  class="btn btn-outline-success p-4 pl-5 pr-5 btn-lg" style="font-weight: 800;">Menu Card</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title changename" id="exampleModalLabel">Delivery Address</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <form class="">
                     <div class="form-row">
                        <div class="col-md-12 form-group">
                           <label class="form-label">Name</label>
                           <div class="input-group">
                              <input placeholder="Customer Name" name="name" type="text" maxlength="50" class="form-control name" autocomplete="off">
                           </div>
                        </div>
						<div class="col-md-12 form-group">
                           <label class="form-label">Delivery Area</label>
                           <div class="input-group">
                              <input placeholder="Delivery Area" type="text" class="form-control delivery_area">
                              <div class="input-group-append"><button id="button-addon2" type="button" class="btn btn-outline-secondary"><i class="icofont-pin"></i></button></div>
                           </div>
                        </div>
                        <div class="col-md-12 form-group"><label class="form-label">Complete Address</label><input placeholder="Complete Address e.g. house number, street name, landmark" type="text" class="form-control complete_address"></div>
                        <div class="col-md-12 form-group"><label class="form-label">Delivery Instructions</label><input placeholder="Delivery Instructions e.g. Opposite Gold Souk Mall" type="text" class="form-control delivery_instruction"></div>
						<div class="col-md-12 form-group">
                           <label class="form-label">Contact Number</label>
                           <div class="input-group">
                              <input placeholder="Contact Number" type="text" name="number" maxlength="10" class="form-control number" autocomplete="off">
                           </div>
                        </div>
                        <div class="mb-0 col-md-12 form-group">
                           <!-- <label class="form-label">Nickname</label> -->
                           <div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
                              <label class="btn btn-outline-secondary active">
                              <input type="radio" value="Home" name="nickname" id="option1" checked> Home
                              </label>
                              <label class="btn btn-outline-secondary">
                              <input type="radio" value="Work" name="nickname" id="option2"> Work
                              </label>
                              <label class="btn btn-outline-secondary">
                              <input type="radio" value="Other" name="nickname" id="option3"> Other
                              </label>
                           </div>
                        </div>
                     </div>
                  </form>
               </div>
               <div class="modal-footer p-0 border-0">
                  <div class="col-6 m-0 p-0">                 
                     <button type="button" class="btn border-top btn-lg btn-block" data-dismiss="modal">Close</button>
                  </div>
                  <div class="col-6 m-0 p-0">     
                     <button type="button" class="btn btn-success btn-lg btn-block" id="save_delivery_address">Save changes</button>
                  </div>
               </div>
            </div>
         </div>
      </div>
<script type="text/javascript">
$("#name_on_card").keydown(function(event){
        var inputValue = event.which;
        // allow letters and whitespaces only.
        if(!(inputValue >= 65 && inputValue <= 120) && (inputValue != 32 && inputValue != 0) && inputValue!= 8) { 
            event.preventDefault(); 
        }
    });
</script>
      <?php
    require_once('web_footer.php');
?>
<script src="<?=base_url();?>assets/web/js/custom/Checkout.js?v=<?=uniqid()?>"></script>
<script type="text/javascript">
    Checkout.base_url="<?=base_url();?>";
    Checkout.restid="<?=$restid;?>";
    Checkout.main_menu_id="<?=$main_menu_id;?>";
    Checkout.tableid="<?=$tableid;?>";
    Checkout.customer_id="<?=$customer['customer_id'];?>";
    Checkout.currency_symbol="<?=$restaurant_type[0]['currency_symbol'];?>";
    Checkout.init();
    /*$('.recipe-tabs').find('.receipes .card-body').addClass('active');*/
</script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script>
	$(document).ready(function()
	{
		$(".name").keypress(function(event)
		{
			var inputValue = event.charCode;
			
			if(!(inputValue >= 65 && inputValue <= 120) && (inputValue != 32 && inputValue != 0))
			{
				event.preventDefault();
			}
		});
	});
</script>