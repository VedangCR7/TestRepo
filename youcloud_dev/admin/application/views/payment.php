<?php
require_once('header.php');
require_once('sidebar.php');

?>
<link rel="stylesheet" href="<?=base_url();?>client/css/normalize.css" />
<link rel="stylesheet" href="<?=base_url();?>client/css/global.css" />
<script src="https://js.stripe.com/v3/"></script>
<script src="<?=base_url();?>assets/js/stripe.js" defer></script>
<div class=" app-content">
	<div class="side-app">

		<!--Page Header-->
		<div class="page-header" base-url="<?=base_url();?>">
			<h3 class="page-title"><i class="side-menu__icon fe fe-dollar-sign mr-1"></i> Payment</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Payment</li>
			</ol>
		</div>
		<?php
			if(isset($_GET['redirect']) && ($_GET['redirect']=="userlist")){
			}else{
				if(!empty($is_subscribe)){
		?>
		<div class="page-header">
			<?php
						if(empty($sub_result)){
					?>
						<h3 class="page-title error"  style="color: red;text-align: center;width: 100%;">Your Subscription is expired please subscribe.</h3>
					<?php
						}else{
							if($sub_result['period']=="perrecipe"){
					?>
					<h3 class="page-title" style="color: green;text-align: center;width: 100%;">Your have subscribe for single recipe</h3>
					<?php
							}else{
					?>
						<h3 class="page-title" style="color: green;text-align: center;width: 100%;">Your subscription will end on <?=date('d M Y',strtotime($user['payment_end_date']))?></h3>
					<?php
						}
					}
			?>
		</div>
		<?php
				}
			}
		?>
		<!--Page Header-->
	</div>
	<div class="row justify-content-md-center div-row" style="min-height: 400px;">
		<input type="hidden" name="name" id="input-name">
		<input type="hidden" name="email" id="input-email">

		<?php
			if($_SESSION['usertype']=="Individual User"){
		?>
		<div class="col-lg-4 col-md-6">
			<div class="pricing-table">
				<div class="price-header">
					<div class="price" amount="19">
						<span class="dollar">$</span>19
					</div>
					<span class="permonth">12 Months</span>
				</div>
			<!-- 	<div class="price-body">
					<ul class="list-unstyled mb-4 mt-7">
						<li class="border-bottom-0 p-1">Sub-recipes</li>
						<li class="border-bottom-0 p-1">Custom ingredients</li>
						<li class="border-bottom-0 p-1">Nutrient calculations</li>
						<li class="border-bottom-0 p-1">Allergen information</li>
						<li class="border-bottom-0 p-1">Recipe costings</li>
						<li class="border-bottom-0 p-1">Downloadable results</li>
						<li class="border-bottom-0 p-1">Technical support</li>
						<li class="border-bottom-0 p-1">Image uploads</li>
						
					</ul>
				</div> -->
				<div class="price-footer">
					<a class="order-btn btn btn-secondary btn-subscribe" href="javascript:;" amount="19" period="12">Subscribe</a>
				</div>
			</div>
		</div>
		<div class="col-lg-4 col-md-6">
			<div class="pricing-table">
				<div class="price-header">
					<div class="price" >
						<span class="dollar">$</span>2
					</div>
					<span class="permonth">per recipe</span>
				</div>
				<!-- <div class="price-body">
					<ul class="list-unstyled mb-4 mt-7">
						<li class="border-bottom-0 p-1">Sub-recipes</li>
						<li class="border-bottom-0 p-1">Custom ingredients</li>
						<li class="border-bottom-0 p-1">Nutrient calculations</li>
						<li class="border-bottom-0 p-1">Allergen information</li>
						<li class="border-bottom-0 p-1">Recipe costings</li>
						<li class="border-bottom-0 p-1">Downloadable results</li>
						<li class="border-bottom-0 p-1">Technical support</li>
						<li class="border-bottom-0 p-1">Image uploads</li>
						
					</ul>
				</div> -->
				<div class="price-footer">
					<a class="order-btn btn btn-primary btn-subscribe" href="javascript:;" amount="2" period="perrecipe">Subscribe</a>
				</div>
			</div>
		</div>
		<?php
			}
			else{
		?>
		<div class="col-lg-4 col-md-6">
			<div class="pricing-table">
				<div class="price-header">
					<div class="price" amount="79">
						<span class="dollar">$</span>79
					</div>
					<span class="permonth">6 Months</span>
				</div>
				<div class="price-footer">
					<a class="order-btn btn btn-secondary btn-subscribe" href="javascript:;" amount="79" period="6">Subscribe</a>
				</div>
			</div>
		</div>
		<div class="col-lg-4 col-md-6">
			<div class="pricing-table">
				<div class="price-header">
					<div class="price" >
						<span class="dollar">$</span>149
					</div>
					<span class="permonth">12 Months</span>
				</div>
				<div class="price-footer">
					<a class="order-btn btn btn-primary btn-subscribe" href="javascript:;" amount="149" period="12">Subscribe</a>
				</div>
			</div>
		</div>
		<?php
			}
		?>
		<!-- <div class="col-lg-3 col-md-6">
			<div class="pricing-table active">
				<div class="price-header bg-primary">
					<div class="price text-white">
						<span class="dollar">£</span>34.50
					</div>
					<span class="permonth">1 YEAR UNLIMITED</span>
				</div>
				<div class="price-body">
					<ul class="list-unstyled mb-1 mt-7">
						<li class="border-bottom-0 p-1">Sub-recipes</li>
						<li class="border-bottom-0 p-1">Custom ingredients</li>
						<li class="border-bottom-0 p-1">Nutrient calculations</li>
						<li class="border-bottom-0 p-1">Allergen information</li>
						<li class="border-bottom-0 p-1">Recipe costings</li>
						<li class="border-bottom-0 p-1">Downloadable results</li>
						<li class="border-bottom-0 p-1">Technical support</li>
						<li class="border-bottom-0 p-1">Image uploads</li>
						<li class="border-bottom-0 p-1 font-weight-bold">Recipe optimisation</li>
						<li class="border-bottom-0 p-1 font-weight-bold">Label designer</li>
						<li class="border-bottom-0 p-1 font-weight-bold">API</li>
						<li class="border-bottom-0 p-1 font-weight-extrabold text-green"><h5>Best Value</h5></li>

					</ul>
				</div>
				<div class="price-footer mt-1">
					<a class="order-btn btn btn-secondary" href="">Sign up</a>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-md-6">
			<div class="pricing-table">
				<div class="price-header">
					<div class="price">
						<span class="dollar">£</span>549.50
					</div>
					<span class="permonth">7 YEAR UNLIMITED</span>
				</div>
				<div class="price-body">
					<ul class="list-unstyled mb-4 mt-7">
						<li class="border-bottom-0 p-1">Sub-recipes</li>
						<li class="border-bottom-0 p-1">Custom ingredients</li>
						<li class="border-bottom-0 p-1">Nutrient calculations</li>
						<li class="border-bottom-0 p-1">Allergen information</li>
						<li class="border-bottom-0 p-1">Recipe costings</li>
						<li class="border-bottom-0 p-1">Downloadable results</li>
						<li class="border-bottom-0 p-1">Technical support</li>
						<li class="border-bottom-0 p-1">Image uploads</li>
						<li class="border-bottom-0 p-1 font-weight-bold">Recipe optimisation</li>
						<li class="border-bottom-0 p-1 font-weight-bold">Label designer</li>
						<li class="border-bottom-0 p-1 font-weight-bold">API</li>
					</ul>
				</div>
				<div class="price-footer">
					<a class="order-btn btn btn-pink" href="">Sign up</a>
				</div>
			</div>
		</div> -->
	</div>
	<div class="row justify-content-md-center div-form-row" style="display: none;min-height: 400px;">
		<div class="card">
			<div class="card-body">
				<div class="row justify-content-md-center ">
					<div class="col-lg-6 col-md-6">
						<h3 for="card-element text-center mb-2" style="text-align: center;margin-bottom: 1rem !important;">
			              Address details
			            </h3>
						<form method="post" id="form-billing-details" action="javascript:;">
							<div class="">
								<div class="form-group">
									<label for="name">Name <span style="color: red;">*</span></label>
									<input type="text" class="form-control" placeholder="Name" name="name" value="<?=$_SESSION['name'];?>" required="">
								</div>
								<div class="form-group">
									<label for="name">Email <span style="color: red;">*</span></label>
									<input type="text" class="form-control" placeholder="Email" name="email" value="<?=$_SESSION['email'];?>" required="">
								</div>
								<div class="form-group">
									<label for="name">Address Line 1 <span style="color: red;">*</span></label>
									<input type="text" class="form-control" placeholder="Address Line 1" name="line1" required="" value="510 Townsend St" id="streetnumber" autocomplete="on">
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="name">Country <span style="color: red;">*</span></label>
											<input type="text" class="form-control" placeholder="Country" name="country" required="" value="US" id="country">
										</div>
									</div>
									
									<div class="col-md-6">
										<div class="form-group">
											<label for="name">State <span style="color: red;">*</span></label>
											<input type="text" class="form-control" placeholder="State" name="state" required="" value="CA"  id="administrative_area_level_1">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="name">City <span style="color: red;">*</span></label>
											<input type="text" class="form-control" placeholder="City" name="city" required="" value="San Francisco" id="locality">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="name">Postal Code <span style="color: red;">*</span></label>
											<input type="text" class="form-control" placeholder="Postal Code" name="postal" required="" value="98140" id="postal_code">
										</div>
									</div>
									
								</div>
							</div>
							<div class="text-center mt-5 mb-2">
								<button type="submit" class="btn btn-primary">Save</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row div-payment-row" style="display: none;min-height: 400px;">
		<div class="card">
			<div class="card-body">
				<div class="row justify-content-md-center ">
					<div class="col-lg-6 col-md-6">
						<div class="sr-payment-form payment-view">
				          <div class="sr-form-row">
				            <h3 for="card-element text-center mb-2" style="text-align: center;margin-bottom: 1rem !important;">
				              Payment details
				            </h3>
				            <div class="sr-combo-inputs">
				              <!-- <div class="sr-combo-inputs-row">
				                <input
				                  type="text"
				                  id="name"
				                  placeholder="Name"
				                  autocomplete="cardholder"
				                  class="sr-input"
				                />
				              </div> -->
				              <div class="sr-combo-inputs-row">
				                <div class="sr-input sr-card-element" id="card-element"></div>
				              </div>
				            </div>
				            <div class="sr-field-error" id="card-errors" role="alert"></div>
				            <div class="sr-form-row" style="display: none;">
				              <label class="sr-checkbox-label"><input type="checkbox" id="save-card"><span class="sr-checkbox-check"></span> Save card for future payments</label>
				            </div>
				          </div>
				          <button id="submit"><div class="spinner hidden" id="spinner"></div><span id="button-text">Pay</span></button>
				          <div class="sr-legal-text">
				            Your card will be charge <span class="span-charge"></span><span id="save-card-text"> and your card details will be saved to your account</span>.
				          </div>
				        </div>
				        <!-- <div class="sr-payment-summary hidden completed-view">
							<h1>Your payment <span class="status"></span></h1>
							<h4>View PaymentIntent response:
							</h4> 
				        </div> -->
				    </div>
				</div>
		    </div>
		</div>
	</div>
<form method="post" action="<?=base_url();?>company/register_companyuser" id="form-payment-redirect">
	<input type="hidden" name="redirect" id="input-redirect" value="<?php if(isset($_GET['redirect'])) echo $_GET['redirect'];?>">
	<input type="hidden" name="main_menu_id" id="input-main_menu_id" value="<?php if(isset($_GET['main_menu_id'])) echo $_GET['main_menu_id'];?>">
	<input type="hidden" name="user_data_id" id="input-userdataid" value="<?php if(isset($_GET['user_data_id'])) echo $_GET['user_data_id'];?>">
	<input type="hidden" name="register_user_id" id="input-registeruserid" value="<?php if(isset($_GET['register_user_id'])) echo $_GET['register_user_id'];?>">
	<input type="hidden" name="subscription_id" id="input-subscriptionid" >
	<input type="hidden" name="period" id="input-period">
</form>	
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places&key=AIzaSyCvxhZ2LCPGerzgsOMPDmrsX7GPUp023AU"></script>
  ...
<?php
/*require_once('autocomplete.php');*/
require_once('footer.php');

?>
<script type="text/javascript">
	var placeSearch, autocomplete;
    var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'short_name',
        postal_code: 'short_name'

    };

	function initialize() {
	   var input = document.getElementById('streetnumber');
	   autocomplete =new google.maps.places.Autocomplete(input);
	   autocomplete.addListener('place_changed', fillInStreetAddress);
	}

	function fillInStreetAddress() {

        var place = autocomplete.getPlace();

        var lat = place.geometry.location.lat();

        var lng = place.geometry.location.lng();

        $('#streetnumber').val("");

        $('#locality').val("");

        $('#administrative_area_level_1').val("");

        $('#postal_code').val("");

        $('#country').val("");

        

        for (var i = 0; i < place.address_components.length; i++) {

            var addressType = place.address_components[i].types[0];

            var val = place.address_components[i][componentForm[addressType]];

            $('#streetnumber').val(place.address_components[0][componentForm['street_number']]+" "+place.address_components[1][componentForm['route']]);

            if(addressType=="locality")

              $('#locality').val(val);

            if(addressType=="administrative_area_level_1")

              $('#administrative_area_level_1').val(val);

            if(addressType=="country")

              $('#country').val(val);

            if(addressType=="postal_code"){

              $('#postal_code').val(val);

            }

        }

      }
	google.maps.event.addDomListener(window, 'load', initialize);
	$('.btn-subscribe').on('click',function(){
		$('.div-form-row').toggle();
		$('.div-row').toggle();
	});
</script>