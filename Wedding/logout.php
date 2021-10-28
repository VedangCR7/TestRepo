<?php
//ini_set("display_errors",1);
//ini_set(ERROR_REPORTING,E_ALL);
session_start();
//echo $_SESSION["login"];
//exit;
//session_start();
if(isset($_SESSION["login"])){
	$_SESSION["login"] = false;
        unset($_SESSION["login"]);
                
        session_destroy();
    }
	header('Location: index.php'); 
	die();
//echo '<script>window.location.href = "index.php"</script>';
?>