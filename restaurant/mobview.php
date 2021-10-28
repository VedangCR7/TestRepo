<?php 
	require('connection.php');
	$restName = $_GET['restName'];
	$qy = "SELECT * FROM `user` WHERE `name` like '$restName'";
	$rs = mysqli_query($con,$qy);
	$ct = mysqli_num_rows($rs);
	if($ct>0)
				{
					$wr = mysqli_fetch_assoc($rs);
					$resto_id = $wr['id'];
				}
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
		<style>
		.dish-loader{
			font-size: 24px;
    margin: 0px auto;
    text-align: center;
    width: 100%;
    vertical-align: middle;
		}
		</style>
	</head>
	<body>
		<div class="container reciepe-container">
		<div class="form-group">
		<label for="search">Search </label>
    <input type="text" class="form-control" id="search"  aria-describedby="emailHelp" placeholder="Search">
    <small id="emailHelp" class="form-text text-muted">Search reciepes.</small>
  </div>
			<div class="row resto_name">
				<center><h5><?php echo ucwords($restName);?></h5></center>
			</div>
			<hr>
			<div class="dish-loader">Loading reciepes...</div>
			<div id="reciepe-data">
			
			</div>
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
		<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<center><h5 class="modal-title" id="exampleModalCenterTitle">Select your Allergen</h5></center>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body" style="height:351px;overflow:scroll">
					<div class="allergens-chk">
					</div>
				
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-outline-success btn-sm" onclick="clearFilter()">Clear</button>
				<button type="button" class="btn btn-outline-success btn-sm" onclick="applyFilter()">Apply</button>
			  </div>
			</div>
		  </div>
		</div>
		<!-- End Modal for FoodNAI -->
		
		<script>
		$(document).ready(()=>{
			
			getCatAndDish();
		})
		function getCatAndDish(allergensFilter=''){
			
			let restId='<?php echo $resto_id;?>';
			$('.dish-loader').show();
			$('.reciepe-container #reciepe-data').html('');
			$.ajax({ 
					type : 'POST',
					url : 'https://foodnai.com/ws/get_category_and_dish_details.php',
					data : {'restaurant_id':restId,'allerganid':allergensFilter,'user_id':''},
					success : function(response)
					{
						$('.dish-loader').hide();
						let responseResult=JSON.parse(response);
						console.log("responseResult",responseResult);
						
						responseResult.menuGroup_details.forEach((menuGroup)=>{
							let newGroup='';
							newGroup="<div class='row main_cat'><div>Soups</div>"+menuGroup.category_name+"</div>";
							menuGroup.dish_details.forEach((dish)=>{
								let dishname=dish.dish_name;
								let dishTypeImg='images/Veg.png';
								if(dish.recipe_type=='nonveg'){
									dishTypeImg='images/NonVeg.png';
								}
								let dishPrice='&#8377; 0.00/-';
								if(dish.price=='Recipe Price' || dish.price==''){
									dishPrice='&#8377; 0.00/-';
								}else{
									dishPrice='&#8377;'+dish.price+'/-';
								}
								let allergens='';
								dish.allergens.forEach((allergenData)=>{
									allergens +="<img src='"+allergenData.allergen_image+"' alt='"+allergenData.allergen+"' height='45px' style='float:left;'>";
								});
								newGroup += "<div class='row recipe_details'><div class='col-12'><div class='menu_group'><div class='row'><div class='col-10 menu_name'><b>"+dishname+"</b></div><div class='col-2 menu_type'><img src='"+dishTypeImg+"' alt='"+dish.recipe_type+"' height='16px'></div></div><div class='row'><div class='col-8 menu_price'><b>"+dishPrice+"</b></div><div class='col-4 viewbtn'><a href='view_dish_details.php?catid="+menuGroup.category_id+"&amp;dishid="+dish.dish_id+"&amp;allergen="+allergensFilter+"'><button type='button' class='btn btn-outline-success btn-sm view_btn'>View</button></a></div></div><div class='row'><div class='col-12 menu_allergens'>"+allergens+"</div></div></div></div></div>";
							});
							$('.reciepe-container #reciepe-data').append(newGroup);

							})


						






					},error:function (error) {
						$('.dish-loader').hide();
						$('.reciepe-container #reciepe-data').html('No reciepes found');
					}
				});
		}
			function get_allergens()
			{
				//$('.allergens-chk').html('');
				$('#exampleModalCenter').modal();
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
								addCheckbox(allergen);
							})
						}
						//$('.allergens-info-li').html(response); 
					},error:function (error) {
						$('.allergens-info-li').html("<div class='row'><div class='col-md-12'><p><strong>Allergen-nutrition not found</strong></p></div></div>");
					}
				});
			}
			function addCheckbox(allergen) {
				console.log(allergen);
				let name=allergen.allergen;
				let id= allergen.id;
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
					return this.id;
				}).get();
				$('.modal').modal('hide');
				getCatAndDish(checkedVals.join(","));
				//alert(checkedVals.join(","));
				
				
			}
			function clearFilter(){
				$('.chk-filter:checkbox').prop('checked',false);
				$('.modal').modal('hide');
				getCatAndDish('');
			}
			function searchReciepes(strSearch){
				let checkedVals = $('.chk-filter:checkbox:checked').map(function() {
					return this.id;
				}).get();
				$('.dish-loader').show();
			
				let allergensFilter=checkedVals.join(",");
				if(strSearch.length>0){
					let restId='<?php echo $resto_id;?>';
				
			
			$.ajax({ 
					type : 'POST',
					url : 'https://foodnai.com/ws/get_search_results.php',
					data : {'flag':'dish','keyword':strSearch,'restaurant_id':restId,'allerganid':allergensFilter,"user_id":''},
					success : function(response)
					{
						console.log(responseResult);
						$('.dish-loader').hide();
						let responseResult=JSON.parse(response);
						if(responseResult.result=="success"){
						responseResult.menuGroup_details.forEach((menuGroup)=>{
							let newGroup='';
							newGroup="<div class='row main_cat'><div>Soups</div>"+menuGroup.category_name+"</div>";
							menuGroup.dish_details.forEach((dish)=>{
								let dishname=dish.dish_name;
								let dishTypeImg='images/Veg.png';
								if(dish.recipe_type=='nonveg'){
									dishTypeImg='images/NonVeg.png';
								}
								let dishPrice='&#8377; 0.00/-';
								if(dish.price=='Recipe Price' || dish.price==''){
									dishPrice='&#8377; 0.00/-';
								}else{
									dishPrice='&#8377;'+dish.price+'/-';
								}
								let allergens='';
								dish.allergens.forEach((allergenData)=>{
									allergens +="<img src='"+allergenData.allergen_image+"' alt='"+allergenData.allergen+"' height='45px' style='float:left;'>";
								});
								newGroup += "<div class='row recipe_details'><div class='col-12'><div class='menu_group'><div class='row'><div class='col-10 menu_name'><b>"+dishname+"</b></div><div class='col-2 menu_type'><img src='"+dishTypeImg+"' alt='"+dish.recipe_type+"' height='16px'></div></div><div class='row'><div class='col-8 menu_price'><b>"+dishPrice+"</b></div><div class='col-4 viewbtn'><a href='view_dish_details.php?catid="+menuGroup.category_id+"&amp;dishid="+dish.dish_id+"&amp;allergen="+allergensFilter+"'><button type='button' class='btn btn-outline-success btn-sm view_btn'>View</button></a></div></div><div class='row'><div class='col-12 menu_allergens'>"+allergens+"</div></div></div></div></div>";
							});
							$('.reciepe-container #reciepe-data').html('');
							$('.reciepe-container #reciepe-data').append(newGroup);

							})

						}else{
							$('.reciepe-container #reciepe-data').html('');
							$('.reciepe-container #reciepe-data').html(responseResult.msg);
						}
						






					},error:function (error) {
						$('.dish-loader').hide();
						$('.reciepe-container #reciepe-data').html('No reciepes found');
					}
				});
				}else{
					getCatAndDish(allergensFilter);
				}
			}
			$('#search').keyup(function(){
				searchReciepes(this.value);
				});
		</script>
	</body>
</html>
