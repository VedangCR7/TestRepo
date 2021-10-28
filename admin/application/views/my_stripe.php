<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Stripe Sample</title>
    <meta name="description" content="A demo of Stripe Payment Intents" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="<?=base_url();?>client/css/normalize.css" />
    <link rel="stylesheet" href="<?=base_url();?>client/css/global.css" />
    <script src="https://js.stripe.com/v3/"></script>
    <script src="<?=base_url();?>assets/js/script.js" defer></script>
  </head>

  <body>
    <div class="sr-root">
      <div class="sr-main">
        <input type="hidden" value="<?=base_url();?>" id="base_url">
        <header class="sr-header">
          <div class="sr-header__logo"></div>
        </header>
        <div class="sr-payment-summary payment-view">
          <h1 class="order-amount">$14.00</h1>
          <h4>Purchase a Pasha photo</h4>
        </div>        
        <div class="sr-payment-form payment-view">
          <div class="sr-form-row">
            <label for="card-element">
              Payment details
            </label>
            <div class="sr-combo-inputs">
              <div class="sr-combo-inputs-row">
                <input
                  type="text"
                  id="name"
                  placeholder="Name"
                  autocomplete="cardholder"
                  class="sr-input"
                />
              </div>
              <div class="sr-combo-inputs-row">
                <div class="sr-input sr-card-element" id="card-element"></div>
              </div>
            </div>
            <div class="sr-field-error" id="card-errors" role="alert"></div>
            <div class="sr-form-row">
              <label class="sr-checkbox-label"><input type="checkbox" id="save-card"><span class="sr-checkbox-check"></span> Save card for future payments</label>
            </div>
          </div>
          <button id="submit"><div class="spinner hidden" id="spinner"></div><span id="button-text">Pay</span></button>
          <div class="sr-legal-text">
            Your card will be charge $14.00<span id="save-card-text"> and your card details will be saved to your account</span>.
          </div>
        </div>
        <div class="sr-payment-summary hidden completed-view">
          <h1>Your payment <span class="status"></span></h1>
          <h4>
            View PaymentIntent response:</a>
          </h4>
        </div>
        <div class="sr-section hidden completed-view">
          <div class="sr-callout">
            <pre>
  
            </pre>
          </div>
          <button onclick="window.location.href = '/';">Restart demo</button>
        </div>  
      </div>
      <div class="sr-content">
        <div class="pasha-image-stack">
          <img
            src="https://picsum.photos/280/320?random=1"
            width="140"
            height="160"
          />
          <img
            src="https://picsum.photos/280/320?random=2"
            width="140"
            height="160"
          />
          <img
            src="https://picsum.photos/280/320?random=3"
            width="140"
            height="160"
          />
          <img
            src="https://picsum.photos/280/320?random=4"
            width="140"
            height="160"
          />
        </div>
      </div>
    </div>
  </body>
</html>
<!-- <!DOCTYPE html>

<html>

<head>

    <title>Codeigniter Stripe Payment Integration Example - ItSolutionStuff.com</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <style type="text/css">

        .panel-title {

        display: inline;

        font-weight: bold;

        }

        .display-table {

            display: table;

        }

        .display-tr {

            display: table-row;

        }

        .display-td {

            display: table-cell;

            vertical-align: middle;

            width: 61%;

        }

    </style>

</head>

<body>

     

<div class="container">

     

    <h1>Codeigniter Stripe Payment Integration Example <br/> ItSolutionStuff.com</h1>

     

    <div class="row">

        <div class="col-md-6 col-md-offset-3">

            <div class="panel panel-default credit-card-box">

                <div class="panel-heading display-table" >

                    <div class="row display-tr" >

                        <h3 class="panel-title display-td" >Payment Details</h3>

                        <div class="display-td" >                            

                            <img class="img-responsive pull-right" src="http://i76.imgup.net/accepted_c22e0.png">

                        </div>

                    </div>                    

                </div>

                <div class="panel-body">

    

                    <?php if($this->session->flashdata('success')){ ?>

                    <div class="alert alert-success text-center">

                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>

                            <p><?php echo $this->session->flashdata('success'); ?></p>

                        </div>

                    <?php } ?>

     

                    <form role="form" action="<?=base_url();?>StripeController/stripePost" method="post" class="require-validation"

                                                     data-cc-on-file="false"

                                                    data-stripe-publishable-key="<?php echo $this->config->item('stripe_key') ?>"

                                                    id="payment-form">

     

                        <div class='form-row row'>

                            <div class='col-xs-12 form-group required'>

                                <label class='control-label'>Name on Card</label> <input

                                    class='form-control' size='4' type='text'>

                            </div>

                        </div>

     

                        <div class='form-row row'>

                            <div class='col-xs-12 form-group card required'>

                                <label class='control-label'>Card Number</label> <input

                                    autocomplete='off' class='form-control card-number' size='20'

                                    type='text'>

                            </div>

                        </div>

      

                        <div class='form-row row'>

                            <div class='col-xs-12 col-md-4 form-group cvc required'>

                                <label class='control-label'>CVC</label> <input autocomplete='off'

                                    class='form-control card-cvc' placeholder='ex. 311' size='4'

                                    type='text'>

                            </div>

                            <div class='col-xs-12 col-md-4 form-group expiration required'>

                                <label class='control-label'>Expiration Month</label> <input

                                    class='form-control card-expiry-month' placeholder='MM' size='2'

                                    type='text'>

                            </div>

                            <div class='col-xs-12 col-md-4 form-group expiration required'>

                                <label class='control-label'>Expiration Year</label> <input

                                    class='form-control card-expiry-year' placeholder='YYYY' size='4'

                                    type='text'>

                            </div>

                        </div>

      

                        <div class='form-row row'>

                            <div class='col-md-12 error form-group hide'>

                                <div class='alert-danger alert'>Please correct the errors and try

                                    again.</div>

                            </div>

                        </div>

      

                        <div class="row">

                            <div class="col-xs-12">

                                <button class="btn btn-primary btn-lg btn-block" type="submit">Pay Now ($100)</button>

                            </div>

                        </div>

                             

                    </form>

                </div>

            </div>        

        </div>

    </div>

         

</div>

     

</body>  

     

<script type="text/javascript" src="https://js.stripe.com/v3/"></script>

     

<script type="text/javascript">

$(function() {

    var $form         = $(".require-validation");

  $('form.require-validation').bind('submit', function(e) {

    var $form         = $(".require-validation"),

        inputSelector = ['input[type=email]', 'input[type=password]',

                         'input[type=text]', 'input[type=file]',

                         'textarea'].join(', '),

        $inputs       = $form.find('.required').find(inputSelector),

        $errorMessage = $form.find('div.error'),

        valid         = true;

        $errorMessage.addClass('hide');

 

        $('.has-error').removeClass('has-error');

    $inputs.each(function(i, el) {

      var $input = $(el);

      if ($input.val() === '') {

        $input.parent().addClass('has-error');

        $errorMessage.removeClass('hide');

        e.preventDefault();

      }

    });

     

    if (!$form.data('cc-on-file')) {

      e.preventDefault();

      Stripe.setPublishableKey($form.data('stripe-publishable-key'));

      Stripe.createToken({

        number: $('.card-number').val(),

        cvc: $('.card-cvc').val(),

        exp_month: $('.card-expiry-month').val(),

        exp_year: $('.card-expiry-year').val()

      }, stripeResponseHandler);

    }

    

  });

      

  function stripeResponseHandler(status, response) {

        if (response.error) {

            $('.error')

                .removeClass('hide')

                .find('.alert')

                .text(response.error.message);

        } else {

            var token = response['id'];

            $form.find('input[type=text]').empty();

            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");

            $form.get(0).submit();

        }

    }

     

});

</script>

</html> -->