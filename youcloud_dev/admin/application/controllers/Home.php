<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// include('MyController');

class Home extends MY_Controller {

    public function __construct(){
        
        parent::__construct();
        date_default_timezone_set('Asia/Kolkata');
        
    }
    /*Counstrucor End's */


    /*landing page show*/
    public function index()
    {
        $this->load->view('home/index');
    }
  

    /*Support page show*/
    public function support()
    {
        $this->load->view('home/support');
    }
  

    /*Blog page show*/
    public function blog()
    {
        $this->load->view('home/blog');
    }
  

    /*Account page show*/
    public function account()
    {
        $this->load->view('home/account');
    }
  

}
