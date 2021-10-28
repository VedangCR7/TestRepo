<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Whatsapp extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
	}

	public function validate_contact(){
		$url = 'https://www.alacalc.com/api/v1/sessions';
		$ckfile=APPPATH."alacalc_cookie.txt";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$this->post);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $ckfile);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$response = curl_exec($ch);
		if (curl_error($ch)) {
	        echo curl_error($ch);
	    }
		curl_close ($ch);
        return  json_decode($response,true);
	}

	
}
?>