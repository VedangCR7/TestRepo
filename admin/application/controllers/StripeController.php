<?php

defined('BASEPATH') OR exit('No direct script access allowed');

   

class StripeController extends CI_Controller {

    

    /**

     * Get All Data from this method.

     *

     * @return Response

    */

    public function __construct() {

       parent::__construct();

       $this->load->library("session");

       $this->load->helper('url');

    }

    

    /**

     * Get All Data from this method.

     *

     * @return Response

    */

    public function index()
    {

        $this->load->view('my_stripe');

    }

    public function subscribe()
    {

        $this->load->view('subscribe');

    }

    public function create_payment_intent(){
        require_once('application/libraries/stripe-php/init.php');

        \Stripe\Stripe::setApiKey($this->config->item('stripe_secret'));

        $pub_key = $this->config->item('stripe_key');

        // Create or use a preexisting Customer to associate with the payment
        $customer = \Stripe\Customer::create([
          'name' => 'Jenny Rosen',
          'address' => [
            'line1' => 'Savedi',
            'postal_code' => '414003',
            'city' => 'Ahmednagar',
            'state' => 'MH',
            'country' => 'IN'
          ],
        ]);

        // Create a PaymentIntent with the order amount and currency and the customer id
        $payment_intent = \Stripe\PaymentIntent::create([
          'description' => 'Software development services',
          "amount" => 7900,
          "currency" => 'usd',
          "customer" => $customer->id,
        /*  'shipping' => [
            'name' => 'Jenny Rosen',
            'address' => [
              'line1' => 'Savedi',
              'postal_code' => '414003',
              'city' => 'Ahmednagar',
              'state' => 'MH',
              'country' => 'IN'
            ],
          ],*/
          'payment_method_types' => ['card'],
        ]);
        
        // Send publishable key and PaymentIntent details to client
        echo json_encode(array('publicKey' => $pub_key, 'clientSecret' => $payment_intent->client_secret, 'id' => $payment_intent->id));
    }
       

    public function get_public_key(){
        echo json_encode(array('publicKey' => $this->config->item('stripe_key')));
    }
    /**

     * Get All Data from this method.

     *

     * @return Response

    */

    public function stripePost()

    {

        require_once('application/libraries/stripe-php/init.php');

    

        \Stripe\Stripe::setApiKey($this->config->item('stripe_secret'));

        $customer = \Stripe\Customer::create();


        \Stripe\Charge::create ([

                "amount" => 1099,
                "currency" => "inr",
                'customer' => $customer->id
                /*"source" => $this->input->post('stripeToken'),
                "description" => "Test payment from itsolutionstuff.com." 

*/
        ]);

            

        $this->session->set_flashdata('success', 'Payment made successfully.');

             

        redirect('/my-stripe', 'refresh');

    }

}
?>