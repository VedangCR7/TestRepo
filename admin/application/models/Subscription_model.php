<?php
class Subscription_model extends My_Model {
    var $user_id;
    var $from_date;
    var $to_date;
    var $amount;
    var $payment_status;
    var $payment_id;
    var $payment_response;
    var $period;
    var $is_used;
    var $tablename="subscriptions";
    var $fields=array('user_id','from_date','to_date','amount','payment_status','payment_id','payment_response','period','is_used');
    public function __construct()
    {
    	$this->load->database();
        $this->load->library('upload');
        $this->load->library('image_lib');
    }
 
  
}
?>