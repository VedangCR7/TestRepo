<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'foodnai_test');
define('DB_PASSWORD', 'leomessi10@argentina');
define('DB_NAME', 'FOODNAI_DEV'); 

/*define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'foodnai_test');
define('DB_PASSWORD', 'leomessi10@argentina');
define('DB_NAME', 'FOODNAI_DEV'); */

 
/*connect to MySQL database   */
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
$base_url = 'https://development.foodnai.com/admin/';
$root_url = 'https://'.$_SERVER['SERVER_NAME'];
// Check connection
if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>