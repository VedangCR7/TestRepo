<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" type="image/png" href="images/FoodNAI_favicon.png">
      <title>FoodNAI Menu</title>
<style>
/* Popup container - can be anything you want */
.popup {
  position: relative;
  display: inline-block;
  cursor: pointer;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* The actual popup */
.popup .popuptext {
  visibility: hidden;
  width: 160px;
  background-color:white;
  color:black;
  text-align: center;
  border-radius: 6px;
  padding: 8px 0;
  position: absolute;
  z-index: 1;
  bottom: 99%;
  margin-left: -119px;
}

/* Popup arrow */
.popup .popuptext::after {
  content: "";
  position: absolute;
  top: 90%;
  left: 50%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: #555 transparent transparent transparent;
}

/* Toggle this class - hide and show the popup */
.popup .show {
  visibility: visible;
  -webkit-animation: fadeIn 1s;
  animation: fadeIn 1s;
}

/* Add animation (fade in the popup) */
@-webkit-keyframes fadeIn {
  from {opacity: 0;} 
  to {opacity: 1;}
}

@keyframes fadeIn {
  from {opacity: 0;}
  to {opacity:1 ;}
}

.img-brand img{
margin-top: 90px;
height: 145px;
}

.tab-menu{
                border-bottom: 1px solid black;
                width: 200px;
                margin-left: -11px;
                 padding-bottom: 7px;
                 /* box-sizing: border-box; */
            }
.menu-button{
    margin-bottom: 120px;
    margin-top: 120px;
    width: 100px;
    height: 50px;
    /* border: 2px solid; 
    border-radius: 3px;
    padding: 3px;
    background:yellowgreen;*/
    color: white;
	font-size: 21px;
    /* text-align:center; */
    
}
.menu-txt{
	border-radius: 5px;
    padding: 11px;
    background: yellowgreen;
}


a {
    color: black;
} 

</style>
</head>
<body style="text-align:center; border: 2px solid">
<?php
	if($restid > 0)
	{
		require('connection.php');
		/* $q="SELECT * FROM `user` WHERE `id` = $restid AND `is_active`=1"; */
		$q="SELECT u.id as udid, u.profile_photo, u.business_name, u.is_active, t.* FROM `user` u, table_details t WHERE u.`id` = $restid AND u.`is_active`=1 AND u.id=t.logged_user_id AND t.is_active=1 AND t.is_delete=0 AND t.id=$tableid";
		$m=mysqli_query($con,$q);/* var_dump($m); */
		$r=mysqli_num_rows($m);
		if($r > 0)
		{
			$wr = mysqli_fetch_assoc($m);
			$r_image = $image_path.$wr['profile_photo'];
			$tbl_name = $wr['title'];
			
?>
        <div class="img-brand">
			<h5 class="m-0 tblnm"><?php echo $tbl_name; ?></h5>
			<img src="<?php echo $r_image; ?>">
        </div>
<?php
	$qr="SELECT DISTINCT(m.`main_menu_id`) FROM `menu_group` m WHERE m.`logged_user_id`=$restid AND `is_active`=1 ORDER BY main_menu_id ASC";
	$mr=mysqli_query($con,$qr);
	$rr=mysqli_num_rows($mr);
	if($rr == 2)
	{
	?>
	<div class="popup  menu-button" onclick="myFunction()"><span class='menu-txt'>MENU</span>
		<span class="popuptext" id="myPopup">
	<?php	
		while($wrr = mysqli_fetch_assoc($mr)){
		$main_menu_id = $wrr['main_menu_id'];
		
		$qr1="SELECT * FROM `menu_master` WHERE id=$main_menu_id AND `is_active`=1";
		$mr1=mysqli_query($con,$qr1);
		$rr1=mysqli_num_rows($mr1);
		if($rr1 > 0)
		{
			$wrr1 = mysqli_fetch_assoc($mr1);
			$main_menu = $wrr1['name'];
?>  			
			<h4 class="tab-menu"><a href='<?php echo $main_link; ?>menu_details.php?mid=<?php echo $main_menu_id; ?>&resid=<?php echo $restid; ?>&tblid=<?php echo $tableid; ?>' alt='<?php echo $main_menu; ?>'><?php echo $main_menu; ?></a></h4>
		<?php }} ?>
		
		  </span>
		</div> 
<?php 
		}else if(($rr == 1)){
			$wrr1 = mysqli_fetch_assoc($mr);
			$main_menu_id1 = $wrr1['main_menu_id'];
?>
		<div class="popup  menu-button">
			<a href='<?php echo $main_link; ?>menu_details.php?mid=<?php echo $main_menu_id1; ?>&resid=<?php echo $restid; ?>&tblid=<?php echo $tableid; ?>' alt='<?php echo $main_menu; ?>'>
				<span class='menu-txt' style="color:#ffffff; text-decoration:underline;">MENU</span>
			</a>
		</div> 
<?php			
		}
	  }
	  else{ echo "Restaurant is inactive"; }
	}
	else{ echo "Restaurant not found"; }
?>
</body>
<script>
// When the user clicks on div, open the popup
function myFunction() {
  var popup = document.getElementById("myPopup");
  popup.classList.toggle("show");
}
</script>
</html>