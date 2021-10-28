<?php
define('DB_SERVER', 'youcloud-extvpc-mysqldb-1.cdnlleak9ukv.ap-south-1.rds.amazonaws.com');
define('DB_USERNAME', 'restoengine');
define('DB_PASSWORD', 'zY4pQ7tP!p@U7yK21J6fP');
define('DB_NAME', 'youcloud_restoengine'); 

/*define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'foodnai_dev'); */

 
/*connect to MySQL database   */
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
$base_url = 'https://www.youcloudresto.com/';
$root_url = 'https://'.$_SERVER['SERVER_NAME'];

// Check connection
if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>