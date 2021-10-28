<?php
class Connection{
 protected $con;
 
 public function __construct(){
  $this->con=mysqli_connect("localhost","foodnai_live","Agriezmann","Wedding");
  
 }

}	
?>