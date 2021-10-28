<?php
	$dishid = $_GET['dishid'];
    $catid = $_GET['catid'];
    $allergen= $_GET['allergen'];
?>

<!DOCTYPE html>
<html>
	<head>
		<title>FoodNAI Menu</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

		<!-- jQuery library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

		<!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <script src='https://kit.fontawesome.com/a076d05399.js'></script>
        
        <style>
            .img-banner img{
                border-radius: 10px;
                width: 100%;
                height: 209px;
            }
            .img-banner .chef-icon i{
                padding-right: 10px; 
            }
            .main-img-holder{
                background-color: #c8cacce6;
            }
            .menu-name h4{
                padding: 10px 0 10px 0 !important;
                text-align: center;
            }
            .allergen{
                height: 300px;
                width: 100%;
                background-color: white;
                margin-top: 20px;
            }
            .allergen h5{
                /* text-align: left !important; */
                color: green;
                padding:10px;

            }
            .allergen img{
                width:25%;
                padding-right: 15px;
                padding-left: 15px;

            }
            .nutrition-info{
                height: 300px;
                width: 100%;
                background-color: white;
                margin-top: 20px;
            }
            .nutrition-info h5{
                /* text-align: left !important; */
                color: green;
                padding:10px;
            }
            .nutrition-content1{
                display: inline-block;
                padding-left: 15px !important;
                padding-right: 240px !important;
            }
            .nutrition-content2{
                display: inline-block;
                padding-left: 15px !important;
                padding-right: 220px !important;
            }
            .nutrition-content3{
                display: inline-block;
                padding-left: 15px !important;
                padding-right: 245px !important;
            }
            .nutrition-content4{
                display: inline-block;
                padding-left: 15px !important;
                padding-right: 260px !important;
            }
            .nutri-container{
                max-height: 240px;
               overflow: scroll;
            }
            .row.nutition-info{
                margin:0px;
            }
            
            
        </style>
	</head>
    <body>
        <div class="container main-img-holder">
            
            <div class="row img-banner">
                <div class="col-sm-4"></div>
                <div class="col-sm-4">
                    <span class="chef-icon"><i class='fas fa-arrow-left'></i><span id="category_name"></span></span>
                    <img id="dish_image" src="https://www.foodnai.com/assets/img/FoodNAI%20Logo.png">
                </div>
                <div class="col-sm-4"></div>
            </div>
            <div class="row ">
                <div class="col-md-4"></div>
                <div class="col-md-4 menu-name">
                <h4 id="dish_name"></h4>
                <div class="allergen">
                <h5>Allergens:</h5>
                
                </div>
                </div>
                <div class="col-md-4"></div>
                
            </div>

            <div class="row ">
                <div class="col-md-4"></div>
                <div class="col-md-4 menu-name">
                    <div class="nutrition-info nutri-info">
                    <h5>Nutritional Information per 100g:</h5>
                    <div class="nutri-container"></div>
                </div>
                
                <div class="col-md-4"></div>
                
            </div>

            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4 menu-name">
                    <div class="nutrition-info">
                    <h5>Ingredients:</h5>
                    <p id="ingredients" style="padding:16px;"></p>
                </div>
                
                <div class="col-md-4"></div>
                
            </div>
        </div>
        <script>
            $(document).ready(()=>{
                getDishDetails();
            });
            function getDishDetails(){
            let dishid='<?php echo $dishid;?>';
            let catid='<?php echo $catid;?>';
            let allergen='<?php echo $allergen;?>';
           
            $.ajax({ 
					type : 'POST',
					url : 'https://foodnai.com/ws/get_dish_details.php',
					data : {'dish_id':dishid,'category_id':catid,'allerganid':allergen},
					success : function(response)
					{
						
						let responseResult=JSON.parse(response);
                        console.log("responseResult",responseResult);
                        $('#category_name').html(responseResult.category_name);
                        $('#dish_name').html(responseResult.dish_name);
                        $('#dish_image').attr('src',responseResult.dish_image);
                        
                        responseResult.allergens.forEach((allergen)=>{
                            let allergeninfo="";
                            allergeninfo ="<img src='"+allergen.allergen_image+"'>"+allergen.allergen+"</br>";
                            $('.allergen').append(allergeninfo);
                        });
                        responseResult.nutrition.forEach((nutrition)=>{
                            let nutritioninfo="";
                            nutritioninfo ="<div class='row nutition-info'><div class='col-xs-8'>"+nutrition.name+"</div><div class='col-xs-4'>"+nutrition.quantity+nutrition.unit+"</div>";
                           $('.nutri-info .nutri-container').append(nutritioninfo);
                        });
                        $('#ingredients').html(responseResult.ingredients);
                        
                        //console.log("allergen",allergen);
                        
					},error:function (error) {
						//$('.dish-loader').hide();
						//$('.reciepe-container #reciepe-data').html('No reciepes found');
					}
				});
		}
        </script>
    </body>
</html>
