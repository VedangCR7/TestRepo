// A reference to Stripe.js
var stripe;
var orderData={};

// Information about the order
// Used on the server to calculate order total
$('#form-billing-details').on('submit',function(){
    var data=$(this).serializeArray();
    for (i in data) {
       orderData[data[i].name]=data[i].value;
    }
    $('.div-form-row').toggle();
    $('.div-payment-row').toggle();
    fetch($('.page-header').attr('base-url')+"recipes/create_payment_intent", {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify(orderData)
    })
    .then(function(result) {
        $('#name').val($('#input-name').val());
        return result.json();
    })
    .then(function(data) {
        $('#name').val($('#input-name').val());
        return setupElements(data);
    })
    .then(function(stripeData) {
      document.querySelector("#submit").addEventListener("click", function(evt) {
        evt.preventDefault();
        // Initiate payment
        pay(stripeData.stripe, stripeData.card, stripeData.clientSecret);
      });
    });
});
$('.btn-subscribe').on('click',function(){
    var amount=$(this).attr('amount');
    var period=$(this).attr('period');
    if(period=="perrecipe"){
        $msg="Per Recipe";
    }
    else
        $msg=period+" Months";
    $('.span-charge').html('$'+amount);
    orderData = {
        items: [{ id: $msg+" Subscription" }],
        currency: "usd",
        period:period,
        amount:amount,
        msg:$msg+" Subscription"
    };    

   /* fetch($('.page-header').attr('base-url')+"recipes/create_payment_intent", {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify(orderData)
    })
    .then(function(result) {
         $('#name').val($('#input-name').val());
      return result.json();
    })
    .then(function(data) {
        $('#name').val($('#input-name').val());
      return setupElements(data);
    })
    .then(function(stripeData) {
      document.querySelector("#submit").addEventListener("click", function(evt) {
        evt.preventDefault();
        // Initiate payment
        pay(stripeData.stripe, stripeData.card, stripeData.clientSecret);
      });
    });*/
});

// Set up Stripe.js and Elements to use in checkout form
var setupElements = function(data) {
    stripe = Stripe(data.publicKey);
    var elements = stripe.elements();
    var style = {
        base: {
            color: "#32325d",
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: "antialiased",
            fontSize: "16px",
            "::placeholder": {
                color: "#aab7c4"
            }
        },
        invalid: {
          color: "#fa755a",
          iconColor: "#fa755a"
        }
    };

    var card = elements.create("card", {hidePostalCode: true,style: style });
    card.mount("#card-element");

    return {
        stripe: stripe,
        card: card,
        clientSecret: data.clientSecret,
        id: data.id
    };
};

/*
 * Calls stripe.confirmCardPayment which creates a pop-up modal to
 * prompt the user to enter  extra authentication details without leaving your page
 */
var pay = function(stripe, card, clientSecret) {
    //var cardholderName = document.querySelector("#name").value;
    var isSavingCard = document.querySelector("#save-card").checked;

    var data = {
        card: card,
        billing_details: {
            name:orderData['name'],
            address:{
                city:orderData['city'],
                country:orderData['country'],
                line1:orderData['line1'],
                postal_code: orderData['postal'],
                state:orderData['state']
            }
        }
    };

   /* if (cardholderName) {
        data["billing_details"]["name"] = cardholderName;
        data["billing_details"]["address"] = [];
        data["billing_details"]["address"]['city'] = orderData['city'];
        data["billing_details"]["address"]['country'] = orderData['country'];
        data["billing_details"]["address"]['line1'] = orderData['line1'];
        data["billing_details"]["address"]['postal_code'] = orderData['postal'];
        data["billing_details"]["address"]['state'] = orderData['state'];
        /*"billing_details": {
        "address": {
          "city": null,
          "country": null,
          "line1": null,
          "line2": null,
          "postal_code": null,
          "state": null
        },
    }*/
    console.log(data);
   changeLoadingState(true);

  // Initiate the payment.
  // If authentication is required, confirmCardPayment will automatically display a modal

  // Use setup_future_usage to save the card and tell Stripe how you plan to charge it in the future
  stripe
    .confirmCardPayment(clientSecret, {
      payment_method: data,
      setup_future_usage: isSavingCard ? "off_session" : ""
    })
    .then(function(result) {
      if (result.error) {
        changeLoadingState(false);
        var errorMsg = document.querySelector(".sr-field-error");
        errorMsg.textContent = result.error.message;
        setTimeout(function() {
          errorMsg.textContent = "";
        }, 4000);
      } else {
        orderComplete(clientSecret);
        // There's a risk the customer will close the browser window before the callback executes
        // Fulfill any business critical processes async using a 
        // In this sample we use a webhook to listen to payment_intent.succeeded 
        // and add the PaymentMethod to a Customer
      }
    });
};

/* ------- Post-payment helpers ------- */

// Shows a success / error message when the payment is complete
var orderComplete = function(clientSecret) {
  stripe.retrievePaymentIntent(clientSecret).then(function(result) {
    var paymentIntent = result.paymentIntent;
    paymentIntent['period']=orderData['period'];
    if($('#input-redirect').val()=="userlist")
        paymentIntent['is_new_user']=1;
    else
        paymentIntent['is_new_user']=0;


    paymentIntent['msg']=orderData['msg'];

    var paymentIntentJson = JSON.stringify(paymentIntent, null, 2);
    document.querySelectorAll(".payment-view").forEach(function(view) {
      view.classList.add("hidden");
    });

    /*document.querySelectorAll(".completed-view").forEach(function(view) {
      view.classList.remove("hidden");
    });*/    
    var pay_status=paymentIntent.status === "succeeded" ? "succeeded" : "did not complete";
    fetch($('.page-header').attr('base-url')+"recipes/save_payment_object", {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: paymentIntentJson
    })
    .then(function(result) {
        return result.json();
    })
    .then(function(data) {
        swal("Success !","Your payment "+pay_status,"success");
        if($('#input-redirect').val()=="userlist"){
          $('#input-subscriptionid').val(data.id);
          $('#input-period').val(data.period);
          $('#form-payment-redirect').submit();
          //window.location.href=$('.page-header').attr('base-url')+"recipes/addrecipe?subscription_id="+data.id+'&period='+data.period+'user_data_id='+$('#user_data_id').val();
        }
        else if($('#input-redirect').val()=="createrecipe")
            window.location.href=$('.page-header').attr('base-url')+"recipes/addrecipe/"+$('#input-main_menu_id').val()+"?subscription_id="+data.id+'&period='+data.period;
        else
            window.location.href="";
        return data;
    });
    //document.querySelector("pre").textContent = paymentIntentJson;
  });
};

// Show a spinner on payment submission
var changeLoadingState = function(isLoading) {
  if (isLoading) {
    document.querySelector("button").disabled = true;
    document.querySelector("#spinner").classList.remove("hidden");
    document.querySelector("#button-text").classList.add("hidden");
  } else {
    document.querySelector("button").disabled = false;
    document.querySelector("#spinner").classList.add("hidden");
    document.querySelector("#button-text").classList.remove("hidden");
  }
};