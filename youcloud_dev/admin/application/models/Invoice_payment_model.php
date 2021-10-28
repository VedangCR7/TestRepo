<?php
class Invoice_payment_model extends My_Model {
    var $invoice_id;
    var $payment_type;
    var $payment_amount;
    var $tablename="invoice_payment";
    var $fields=array('invoice_id','payment_type','payment_amount');
    public function __construct()
    {
    	$this->load->database();
    }
   
}
?>