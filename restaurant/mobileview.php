<?php 
	require('connection.php');
	$restName = $_GET['restName'];
	$qy = "SELECT * FROM `user` WHERE `name` like '$restName'";
	$rs = mysqli_query($con,$qy);
	$ct = mysqli_num_rows($rs);
?>

<!DOCTYPE html>
<html>
	<head>
		<title>FoodNAI Menu :: <?php echo $restName;?></title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		
		<!-- jQuery library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
		<!--<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>-->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		
		<!-- Latest compiled JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
		
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.css">
		<style>
			
		</style>
		<link rel="stylesheet" href="mobileviewstyle.css">
	</head>
	<body>
		<div class="container">
			<div class="row resto_name">
				<center><h5><?php echo ucwords($restName);?></h5></center>
			</div>
			<hr>
			<?php 
				if($ct>0)
				{
					$wr = mysqli_fetch_assoc($rs);
					$resto_id = $wr['id'];
					$resto_name = $wr['name'];
					$user_type = $wr['usertype'];
					$resto_type = $wr['restauranttype'];
					if($resto_id > 0){
						$query1 = "SELECT * FROM `menu_group` WHERE `is_active`= 1 AND `logged_user_id`='$resto_id'";
						$result1 = mysqli_query($con, $query1);
						$count1 = mysqli_num_rows($result1);
						if($count1 > 0)
						{
							$i=1;
							while($row1 = mysqli_fetch_assoc($result1))
							{
								$groupid = $row1['id'];
			?>
			<div class="row main_cat">
				<div class="">
					<?php echo ucfirst($row1['title']); ?>
				</div>
			</div>
			<?php
				$qAllRecords="SELECT * FROM `recipes` WHERE `group_id` = $groupid AND `logged_user_id`='$resto_id'";
				$mAllRecords=mysqli_query($con,$qAllRecords);
				$totalRecords=mysqli_num_rows($mAllRecords);
				if($totalRecords > 0){
					while($recipesRow = mysqli_fetch_assoc($mAllRecords)){
						$recipe_id = $recipesRow['id'];
			?>
			<div class="row recipe_details">
				<div class="col-12">
					<div class="menu_group">
						<div class="row">
							<div class="col-10 menu_name"><b>
								<?php 
									$recipeName = strtoupper($recipesRow['name']);
									if(strlen($recipeName) > 25 )
										echo substr($recipeName,0,25)."..."; 
									else
										echo $recipeName;
									
								?>
							</b></div>
							<div class="col-2 menu_type">
								<?php 
									$menuType = $recipesRow['recipe_type'];
									if($menuType == '') { ?> 
								<img src="images/NonVeg.png" alt="menu type" height="16px">
								<?php	}else if($menuType == 'veg'){ ?>
								<img src="images/Veg.png" alt="Veg menu" height="16px">
								<?php	}else if($menuType == 'nonveg'){ ?>
								<img src="images/NonVeg.png" alt="Nonveg menu" height="16px">
								<?php } ?>
							</div>
						</div>
						<div class="row">
							<div class="col-8 menu_price"><b>
								<?php 
									$menuPrice = $recipesRow['price']; 
									if(($menuPrice == 'Recipe Price') || ($menuPrice == '')) 
									{ ?>&#8377; 0.00/-<?php }
									else{ ?>&#8377; <?php echo $menuPrice."/-"; }
								?></b>
							</div>
							<div class="col-4 viewbtn">
								<button type="button" class="btn btn-outline-success btn-sm view_btn">View</button>
							</div>
						</div>
						<div class="row">
							<div class="col-12 menu_allergens">
								<?php 
									$q="SELECT a.id as aid, a.title, a.image_url, a.images_red, ra.* FROM `recipe_allergens` ra, allergens a WHERE ra.allergens_id=a.id AND ra.`recipe_id` = $recipe_id";
									$m=mysqli_query($con,$q);
									$r=mysqli_num_rows($m);
									if($r > 0)
									{
										while($row1 = mysqli_fetch_assoc($m))
										{
											$attl = $row1['title'];
											$aimg = $row1['image_url'];
								?>
								<img src="<?php echo $image_path.$aimg; ?>" alt="<?php echo $attl; ?>" height="45px" style="float:left;">
									<?php } }?>
							</div>
						</div>
					</div>
				</div>
				
				
				
			</div>
			
				<?php }}}}}} ?>
			<div id="mybutton">
				<!--<button class="filterbtn">
					<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-filter" fill="currentColor" xmlns="http://www.w3.org/2000/svg" style="color:#fff;">
						<path fill-rule="evenodd" d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"/>
					</svg> Filter
				</button>-->
				<button class="filterbtn" onclick="get_allergens()"><i class="fa fa-filter" aria-hidden="true"></i> Filter</button>
			</div>
		</div>
		
		<!-- Modal for FoodNAI -->
		<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true" style="width:80%; margin: 10%;">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<center><h5 class="modal-title" id="exampleModalLongTitle">Select your Allergen</h5></center>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body" style="height:250px;overflow:scroll">
					<div class="allergens-chk">
					</div>
				
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-outline-success btn-sm" data-dismiss="modal">Clear</button>
				<button type="button" class="btn btn-outline-success btn-sm" onclick="applyFilter()">Apply</button>
			  </div>
			</div>
		  </div>
		</div>
		<!-- End Modal for FoodNAI -->
		
		<script>
			function get_allergens()
			{
				$('.allergens-chk').html('');
				$('#exampleModalLong').modal();
				$.ajax({ 
					type : 'POST',
					url : 'https://foodnai.com/ws/get_allergens.php',
					data : {},
					success : function(response)
					{
						let responseResult=JSON.parse(response);
						if(responseResult && responseResult.result=="success"){
							let allergens= responseResult.allergens;
							console.log(allergens);
							allergens.forEach((allergen)=>{
								addCheckbox(allergen.allergen,allergen.id);
							})
						}
						//$('.allergens-info-li').html(response); 
					},error:function (error) {
						$('.allergens-info-li').html("<div class='row'><div class='col-md-12'><p><strong>Allergen-nutrition not found</strong></p></div></div>");
					}
				});
			}
			function addCheckbox(name,id) {
				
			var container = $('.allergens-chk');
			// var inputs = container.find('input');
			// var id = inputs.length+1;
			// $('<div>').appendTo(container);
			// $('<input />', { type: 'checkbox', id: 'cb'+id, value: name }).appendTo(container);
			// $('<label />', { 'for': 'cb'+id, text: name }).appendTo(container);
			// $('</div>').appendTo(container);
			container.append("<div class='custom-control custom-checkbox mb-3'><input type='checkbox' class='custom-control-input form-check-input-reverse chk-filter' id='"+id+"'  name='"+name+"' value='"+name+"'><label class='custom-control-label allergens-info-li' for='"+id+"'>"+name+"</label></div>");

			}
			function applyFilter(){
				let checkedVals = $('.chk-filter:checkbox:checked').map(function() {
					console.log("filter",this.id);
					return this.id+'_'+this.value;
				}).get();
				alert(checkedVals.join(","));
				
				
			}
		</script>
	</body>
</html>
