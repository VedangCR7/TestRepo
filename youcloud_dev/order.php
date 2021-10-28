<?php include 'header.php'; require_once "admin/application/views/web/stripe/config.php"; date_default_timezone_set('Asia/Kolkata') ?>

<!-- SPECIFIC CSS -->
<link href="<?= $root_url; ?>/website_assets/webAssets/css/order-sign_up.css" rel="stylesheet">
<link href="<?= $root_url; ?>/website_assets/webAssets/css/detail-page.css" rel="stylesheet">
<?php $vendor_id=$_REQUEST['restaurant_id'];
$vendor_selectSQL = "SELECT * FROM user WHERE is_active = '1' AND usertype='Restaurant' AND id='$vendor_id'";

    $reseto_DataArr = mysqli_query($conn, $vendor_selectSQL);
    
    $restaurants=mysqli_fetch_assoc($reseto_DataArr);?>
	<main class="bg_gray">
		
		<div class="container margin_60_20">
		    <div class="row justify-content-center">
		        <div class="col-xl-6 col-lg-8">
					<input type="hidden" id="restaurant_id" value="<?=$_REQUEST['restaurant_id']?>">
					<?php if($restaurants['delivery_fee']!=''){ ?>
					<input type="hidden" id="delivery_fee_get" value="<?=$restaurants['delivery_fee']?>">
					<?php }else{ ?>
					<input type="hidden" id="delivery_fee_get" value="0">
					<?php } ?>
					
					<?php if($restaurants['currency_symbol']!=''){ ?>
					<input type="hidden" id="currency_symbol" value="<?=$restaurants['currency_symbol']?>">
					<?php }else{ ?>
					<input type="hidden" id="currency_symbol" value="$">
					<?php } ?>
					<input type="hidden" id="customer_id" value="<?=$_REQUEST['customer_id']?>">
					
					<div class="pb-2">
                        <b><input type="radio" value="Delivery" name="order_type" checked>&nbsp;Delivery
                        <input type="radio" value="Collection" name="order_type">&nbsp;Collection</b>
					</div>
					<!--<div class="box_order_form orderaddress">
					    <div class="head">
					        <div class="title">
					            <h3>Addres</h3>
					        </div>
					    </div>
					    <div class="main">
					        <div class="row">
					            <div class="col-md-6">
					                <div class="address-bar">
					                    <h6>Muhammad Ali</h6>
										<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
										<a href="">Edit</a>
					                </div>
					            </div>
					            <div class="col-md-6">
					                <div class="address-bar">
					                    <h6>Muhammad Ali</h6>
										<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
										<a href="">Edit</a>
					                </div>
					            </div>
					        </div>
							<button type="reset" class="mt-4 btn_1 outline mb-mobile">Add Address</button>
					    </div>
					</div>-->
		        	<div class="box_order_form">
					    <div class="head">
					        <div class="title">
					            <h3>Personal Details</h3>
					        </div>
					    </div>
					    
					    <?php 
					    
					    $customerId = $_SESSION['user_id'];
                        		    
                        $query = "SELECT * FROM customer_address
                        WHERE customer_id='$customerId' AND marked_as_default=1";
                        $addressDataArr=mysqli_query($conn,$query);
                        
                        $address=mysqli_fetch_assoc($addressDataArr);
					    
					    ?>
					    
					    
					    
					    <!-- /head -->
					    <div class="main">
					        <div class="form-group">
					            <label>First and Last Name</label>
					            <input class="form-control" placeholder="First and Last Name" value="<?=$address['name'];?>" id="full_name">
					        </div>
					        <div class="row">
					            <div class="col-md-6">
					                <div class="form-group">
					                    <label>Email Address</label>
					                    <input class="form-control" placeholder="Email Address" id="email" value="<?=$address['email'];?>">
					                </div>
					            </div>
					            <div class="col-md-6">
					                <div class="form-group">
					                    <label>Phone</label>
					                    <input class="form-control" placeholder="Phone" value="<?=$address['contact_number'];?>" id="contact_number">
					                </div>
					            </div>
					        </div>
					        <div class="form-group">
					            <label>Landmark</label>
					            <input class="form-control" placeholder="Landmark" value="<?=$address['landmark'];?>" id="complete_address">
					        </div>
					        <div class="row">
					            <div class="col-md-6">
					                <div class="form-group">
					                    <label>City</label>
					                    <input class="form-control" placeholder="City" value="<?=$address['city'];?>" id="delivery_area">
					                </div>
					            </div>
					            <div class="col-md-6">
					                <div class="form-group">
					                    <label>Postal Code</label>
					                    <input class="form-control" placeholder="0123" value="<?=$address['postal_code'];?>" id="post_code">
					                </div>
					            </div>
					        </div>
					    </div>
					</div>
					<!-- /box_order_form -->
		            <div class="box_order_form">
					    <div class="head">
					        <div class="title">
					            <h3>Payment Method</h3>
					        </div>
					    </div>
					    <!-- /head -->
					    <div class="main">
					        <div class="payment_select">
					            <label class="container_radio">Credit Card
					                <input type="radio" value="payment_method" checked name="payment_method">
					                <span class="checkmark"></span>
					            </label>
					            <i class="icon_creditcard"></i>
					        </div>
					        <div class="form-group">
								<input type="hidden" id="PUBLISHABLE_KEY" name="PUBLISHABLE_KEY" value="<?php echo STRIPE_PUBLISHABLE_KEY; ?>">
                                <input type="hidden" id="SECRET_KEY" name="SECRET_KEY" value="<?php echo STRIPE_SECRET_KEY; ?>">
								<input type="hidden" id="stripeToken" name="stripeToken">
                                                
					            <label>Name on card</label>
					            <input type="text" class="form-control" id="name_on_card" name="name_card_order" placeholder="First and last name">
					        </div>
					        <div class="form-group">
					            <label>Card number</label>
					            <input type="text" id="card_number" name="card_number" class="form-control" placeholder="Card number" id="card_number">
					        </div>
					        <div class="row">
					            <div class="col-md-6">
					                <label>Expiration date</label>
					                <div class="row">
					                    <div class="col-md-12 col-12">
					                        <div class="form-group">
					                            <input type="text" name="expire_month" class="form-control" placeholder="mm/yyyy" id="valid_through">
					                        </div>
					                    </div>
					                </div>
					            </div>
					            <div class="col-md-6 col-sm-12">
					                <div class="form-group">
					                    <label>Security code</label>
					                    <div class="row">
					                        <div class="col-md-4 col-6">
					                            <div class="form-group">
					                                <input type="text" id="cvv" name="ccv" class="form-control" placeholder="CCV">
					                            </div>
					                        </div>
					                        <div class="col-md-8 col-6">
					                            <img src="<?= $root_url; ?>/website_assets/webAssets/img/icon_ccv.gif" width="50" height="29" alt="ccv"><small>Last 3 digits</small>
					                        </div>
					                    </div>
					                </div>
					            </div>
					        </div>
					        <!--End row -->
					       <!-- <div class="payment_select" id="paypal">
					            <label class="container_radio">Pay with Paypal
					                <input type="radio" value="paypal" name="payment_method">
					                <span class="checkmark"></span>
					            </label>
					        </div>-->
					        <div class="payment_select" id="pay_with_cash">
					            <label class="container_radio paywithcash">Pay with Cash
					                <input type="radio" value="cod" name="payment_method">
					                <span class="checkmark"></span>
					            </label>
					            <i class="icon_wallet"></i>
					        </div>
					    </div>
					</div>
					<!-- /box_order_form -->
		        </div>
		        <!-- /col -->
		        <div class="col-xl-4 col-lg-4" id="sidebar_fixed">
		            <div class="box_order">
		                <div class="head">
		                    <h3>Order Summary</h3>
		                    <?php 
		                    $vendor_selectSQL = "SELECT * FROM user WHERE is_active = '1' AND usertype='Restaurant' AND id=".$_REQUEST['restaurant_id'];

    $reseto_DataArr = mysqli_query($conn, $vendor_selectSQL);
    
    $restaurants=mysqli_fetch_assoc($reseto_DataArr);
		                    
		                    ?>
		                    <div id="show_restaurant_name"><?=$restaurants['name']?></div>
		                </div>
		                <!-- /head -->
		                <div class="main">
		                	<ul>
		                		<li>Date<span>Today <?=date('Y-m-d')?></span></li>
		                		<li>Hour<span><?=date('h:i A')?></span></li>
		                		<li>Type<span id="type_show">Delivery</span></li>
		                	</ul>
		                	<hr>
							<div id="order_summary">
		                	
							</div>
		                    <span class="btn_1 gradient full-width mb_5 greenolive" id="order_now">Order Now</span>
		                    <div class="text-center"><small>Or Call Us at <strong>+971-4-442-1782</strong></small></div>
		                </div>
		            </div>
		            <!-- /box_booking -->
		        </div>

		    </div>
		    <!-- /row -->
		</div>
		<!-- /container -->
		
	</main>

<?php include 'footer.php'; ?>



<!-- SPECIFIC SCRIPTS -->
<script src="<?= $root_url; ?>/website_assets/webAssets/js/sticky_sidebar.min.js"></script>
<script>
	$('#sidebar_fixed').theiaStickySidebar({
	    minWidth: 991,
	    updateSidebarHeight: false,
	    additionalMarginTop: 30
	});
</script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script>
	
	$('#order_now').click(function(){
	       
       var payment_method = $("input[type='radio'][name='payment_method']:checked").val();
       
        if($('#full_name').val()=='' || $('#email').val()==''  || $('#contact_number').val()=='' || $('#complete_address').val()=='' || $('#delivery_area').val()=='' || $('#post_code').val()==''){
		    alert("Please enter all personal details");return false;
		}
    /*if method is bot COD*/
       if(payment_method=="payment_method"){
	    
	    
	    
	    
		if($('#card_number').val()=='' || $('#valid_through').val()=='' || $('#cvv').val() == '' || $('#name_on_card').val() == '')
			{
				
				alert("Please enter payment details");
				$('#collapsefour').collapse('show');
				return false;
			}

			if($('#card_number').val().length < 16 || $('#card_number').val().length > 16){
				alert("Please enter valid Card number.card number should be 16 digit in length");return false;
			}

			if($('#cvv').val().length < 3 || $('#cvv').val().length > 3)
			{
				alert("Please enter valid CVV");return false;
			}

			re = /^(0[1-9]|1[0-2])\/?([0-9]{4}|[0-9]{2})$/;
			
			if (!($('#valid_through').val().match(re))) 
			{
				alert('Please enter card Valid through details in mm/yyyy format');
				return false;
			}
			
			var valid_through = $('#valid_through').val().split("/");
			var month = valid_through[0];
			var year = valid_through[1];
			
			var PUBLISHABLE_KEY = $('#PUBLISHABLE_KEY').val();
			var SECRET_KEY = $('#SECRET_KEY').val();
					
			Stripe.setPublishableKey(PUBLISHABLE_KEY);
			
			Stripe.createToken({
				number: $('#card_number').val(),
				cvc: $('#cvv').val(),
				exp_month: month,
				exp_year: year
				}, stripeResponseHandler);
			
			function stripeResponseHandler(status, response) 
			{
				if (response.error) 
				{
					/* $('.error')
						.removeClass('hide')
						.find('.alert')
						.text(response.error.message); */
					alert(response.error.message);
					return false;
				} 
				else 
				{
					var token = response['id'];
					
					var data={
						customer_id:$('#customer_id').val(),
						restaurant_id:$('#restaurant_id').val(),
						sub_total:$('#sub_total').val(),
						net_total:$('#net_total').val(),
						card_number : $('#card_number').val(),
						valid_through : $('#valid_through').val(),
						cvv : $('#cvv').val(),
						name_on_card : $('#name_on_card').val(),
						PUBLISHABLE_KEY : $('#PUBLISHABLE_KEY').val(),
						SECRET_KEY : $('#SECRET_KEY').val(),
						token : token,
						full_name:$('#full_name').val(),
						email:$('#email').val(),
						contact_number:$('#contact_number').val(),
						complete_address:$('#complete_address').val(),
						delivery_area:$('#delivery_area').val(),
						post_code:$('#post_code').val(),
						supply_option:$('input[name=order_type]:checked').val()
					};
					console.log(data);
					//$('#image-loader').show();
					
					$.ajax({
						url:"<?= $root_url; ?>placeorder.php",
						type:'POST',
						data:data,
						dataType:'JSON',
						success: function(result)
						{
							//$('#image-loader').hide();
							console.log(result.status);
							if(result.status)
							{
								window.location.href="<?= $root_url; ?>confirm.php?order_no="+result.order_no+"&restaurant_id="+$('#restaurant_id').val();
								
							}
							else
							{
								alert(result.status);
							}
						}
					});
				}
			}
			
	    }else if(payment_method=="cod"){
	        /*if COD*/   
	    
	        var data={
					customer_id:$('#customer_id').val(),
					restaurant_id:$('#restaurant_id').val(),
					sub_total:$('#sub_total').val(),
					net_total:$('#net_total').val(),
				// 	card_number : $('#card_number').val(),
				// 	valid_through : $('#valid_through').val(),
				// 	cvv : $('#cvv').val(),
				// 	name_on_card : $('#name_on_card').val(),
				// 	PUBLISHABLE_KEY : $('#PUBLISHABLE_KEY').val(),
				// 	SECRET_KEY : $('#SECRET_KEY').val(),
				// 	token : token,
					full_name:$('#full_name').val(),
					email:$('#email').val(),
					contact_number:$('#contact_number').val(),
					complete_address:$('#complete_address').val(),
					delivery_area:$('#delivery_area').val(),
					post_code:$('#post_code').val(),
					supply_option:$('input[name=order_type]:checked').val()
					};
				// 	console.log(data);
					//$('#image-loader').show();
					
					$.ajax({
						url:"<?= $root_url; ?>placeorder.php",
						type:'POST',
						data:data,
						dataType:'JSON',
						success: function(result)
						{
							//$('#image-loader').hide();
							console.log(result.status);
							if(result.status)
							{
								window.location.href="<?= $root_url; ?>confirm.php?order_no="+result.order_no+"&restaurant_id="+$('#restaurant_id').val();
								
							}
							else
							{
								alert(result.status);
							}
						}
					});
       
	    }
			
	});
	
	
	
	$(document).ready(function(){
       $.ajax({
                    url:"<?= $root_url; ?>/get_cart_items.php",
                    type: "POST",
                    data: {restaurant_id:$('#restaurant_id').val(),customer_id:$('#customer_id').val()},
                    dataType: "JSON",
                    success: function(jsonStr) {
                        var sub_total=0;
                        var delovery_fee=0;
                        html='<ul class="clearfix">';
                        for(var i=0;i<jsonStr.length;i++){
										html+='<li><a href="#0" data-id="'+jsonStr[i].cart_id+'" class="remove_cart_item"></a>'+jsonStr[i].name+'<span>'+$('#currency_symbol').val()+jsonStr[i].price+'</span></li>';
										html+='<input type="hidden" name="order_recipe_id[]" value="'+jsonStr[i].id+'"><input type="hidden" name="order_recipe_price[]" value="'+jsonStr[i].price+'"><input type="hidden" name="order_recipe_qty[]" value="'+jsonStr[i].qty+'">'
										sub_total = parseInt(sub_total)+(parseInt(jsonStr[i].price)*parseInt(jsonStr[i].qty));
                        }
									html+='</ul>\
									<ul class="clearfix">\
										<li>Subtotal<span>'+$('#currency_symbol').val()+sub_total+'<input type="hidden" id="sub_total" value="'+sub_total+'"></span></li>\
										<li id="show_delivery_fee">Delivery fee<span>'+$('#currency_symbol').val()+$('#delivery_fee_get').val()+'</span></li>';
										if($('#delivery_fee_get').val() !=''){
										    html+='<li class="total">Total<span>'+$('#currency_symbol').val()+(parseInt(sub_total)+parseInt($('#delivery_fee_get').val()))+'<input type="hidden" id="net_total" value="'+(parseInt(sub_total)+parseInt($('#delivery_fee_get').val()))+'"></span></li>';
										}else{
										    html+='<li class="total">Total<span>'+$('#currency_symbol').val()+(parseInt(sub_total))+'<input type="hidden" id="net_total" value="'+(parseInt(sub_total))+'"></span></li>';
										
										}
									html+='</ul>';
							$('#order_summary').html(html);		
						
                    }
       });
       
       
       $('body').on('click','.remove_cart_item',function(){
           $.ajax({
                    url:"<?= $root_url; ?>remove_cart_item.php",
                    type: "POST",
                    data: {cart_id:$(this).attr('data-id'),restaurant_id:$('#restaurant_id').val(),customer_id:$('#customer_id').val()},
                    dataType: "JSON",
                    success: function(jsonStr) {
                        
                        if(jsonStr){
                            alert('Cart Item Remove Successfully');
                            location.reload();
                        }
                    }
       });
       });
       
       $('input[name=order_type]').change(function(){
		   debugger;
		   
           if($(this).val() == 'Collection'){
               $('#pay_with_cash').hide();
               $('#type_show').html($(this).val());
               $('#show_delivery_fee').hide();
			   
			   $.ajax({
                    url:"<?= $root_url; ?>/get_cart_items.php",
                    type: "POST",
                    data: {restaurant_id:$('#restaurant_id').val(),customer_id:$('#customer_id').val()},
                    dataType: "JSON",
                    success: function(jsonStr) {
                        var sub_total=0;
                        var delovery_fee=0;
                        html='<ul class="clearfix">';
                        for(var i=0;i<jsonStr.length;i++){
										html+='<li><a href="#0" data-id="'+jsonStr[i].cart_id+'" class="remove_cart_item"></a>'+jsonStr[i].name+'<span>'+$('#currency_symbol').val()+jsonStr[i].price+'</span></li>';
										html+='<input type="hidden" name="order_recipe_id[]" value="'+jsonStr[i].id+'"><input type="hidden" name="order_recipe_price[]" value="'+jsonStr[i].price+'"><input type="hidden" name="order_recipe_qty[]" value="'+jsonStr[i].qty+'">'
										sub_total = parseInt(sub_total)+(parseInt(jsonStr[i].price)*parseInt(jsonStr[i].qty));
                        }
									html+='</ul>\
									<ul class="clearfix">\
										<li>Subtotal<span>'+$('#currency_symbol').val()+sub_total+'<input type="hidden" id="sub_total" value="'+sub_total+'"></span></li>\
										<li class="total">Total<span>'+$('#currency_symbol').val()+(parseInt(sub_total))+'<input type="hidden" id="net_total" value="'+(parseInt(sub_total))+'"></span></li>\
										</ul>';
							$('#order_summary').html(html);		
						
                    }
       });
           }else{
               $('#pay_with_cash').show();
               $('#type_show').html($(this).val());
               $('#show_delivery_fee').show();
			   $.ajax({
                    url:"<?= $root_url; ?>/get_cart_items.php",
                    type: "POST",
                    data: {restaurant_id:$('#restaurant_id').val(),customer_id:$('#customer_id').val()},
                    dataType: "JSON",
                    success: function(jsonStr) {
                        var sub_total=0;
                        var delovery_fee=0;
                        html='<ul class="clearfix">';
                        for(var i=0;i<jsonStr.length;i++){
										html+='<li><a href="#0" data-id="'+jsonStr[i].cart_id+'" class="remove_cart_item"></a>'+jsonStr[i].name+'<span>'+$('#currency_symbol').val()+jsonStr[i].price+'</span></li>';
										html+='<input type="hidden" name="order_recipe_id[]" value="'+jsonStr[i].id+'"><input type="hidden" name="order_recipe_price[]" value="'+jsonStr[i].price+'"><input type="hidden" name="order_recipe_qty[]" value="'+jsonStr[i].qty+'">'
										sub_total = parseInt(sub_total)+(parseInt(jsonStr[i].price)*parseInt(jsonStr[i].qty));
                        }
									html+='</ul>\
									<ul class="clearfix">\
										<li>Subtotal<span>'+$('#currency_symbol').val()+sub_total+'<input type="hidden" id="sub_total" value="'+sub_total+'"></span></li>\
										<li id="show_delivery_fee">Delivery fee<span>'+$('#currency_symbol').val()+$('#delivery_fee_get').val()+'</span></li>\
										<li class="total">Total<span>'+$('#currency_symbol').val()+(parseInt(sub_total)+parseInt($('#delivery_fee_get').val()))+'<input type="hidden" id="net_total" value="'+(parseInt(sub_total)+parseInt($('#delivery_fee_get').val()))+'"></span></li>\
										</ul>';
							$('#order_summary').html(html);		
						
                    }
       });
           }
       })
    });
    
</script>
