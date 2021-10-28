<?php
	$con=mysqli_connect("localhost","foodnaic","8ca1LnN7b#2;RR","foodnaic_restaurant");

	$countryid=$_POST['cid'];
	
	$q="select city_name,city_id,country_id from city WHERE country_id =$countryid";
	$m=mysqli_query($con,$q);
?>
	<select class="controls span11" id="city_id" name="city_id">
		<option value=0>--Select city--</option>							
		<?php
		if(mysqli_num_rows($m) > 0){
		while ($row = mysqli_fetch_assoc($m))
		{
		?> 
		<option value="<?php echo $row['city_id']; ?>"><?php echo $row['city_name']; ?></option>
		<?php
		}}
		else{
		?>
		<option value=0>City not found</option>
		<?php } ?>
	</select>