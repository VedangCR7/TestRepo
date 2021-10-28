<?php
class Connection{
 protected $con;
 
 public function __construct(){
  /* $this->con=mysqli_connect("localhost","mywedreb_resto","restaurant@123","mywedreb_restaurant"); */
  $this->con = mysqli_connect('localhost','foodnai_test','leomessi10@argentina','FOODNAI_TEST_RESTAURANT');
  
 }

}	
?>