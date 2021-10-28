<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $restDetails['name'];?> Menu</title>
	<!-- Stylesheets -->
	<link href='http://fonts.googleapis.com/css?family=Roboto+Slab:400,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="../assets/rest_assets/css/bootstrap.css">
	<link rel="stylesheet" href="../assets/rest_assets/css/font-awesome.min.css">
	<link rel="stylesheet" href="../assets/rest_assets/css/style.css">
	<link rel="stylesheet" href="../assets/rest_assets/css/responsive.css">
	<link rel="stylesheet" href="../assets/rest_assets/css/thumb-slide.css">
	<link rel="stylesheet" href="../assets/rest_assets/css/owl.carousel.css">
	<link rel="shortcut icon" href="../assets/rest_assets/img/FoodNAI_favicon.png">
	<!--[if IE 9]>
  <script src="js/media.match.min.js"></script>
  <![endif]-->
<style>
.review {
   color: #37A445;
   font-size: 22px;
}

.bigstar{ 
	font-size: 30px; 
	color: grey;
}

.wrapper {
    position:relative;
    margin:0 auto;
    overflow:hidden;
	padding:5px;
  	height:50px;
}

.list {
    position:absolute;
    left:0px;
    top:0px;
  	min-width:3000px;
  	margin-left:12px;
    margin-top:0px;
}

.list li{
	display:table-cell;
    position:relative;
    text-align:center;
    cursor:grab;
    cursor:-webkit-grab;
    color:#efefef;
    vertical-align:middle;
}

.scroller {
  text-align:center;
  cursor:pointer;
  display:none;
  padding:7px;
  padding-top:11px;
  white-space:no-wrap;
  vertical-align:middle;
  background-color:#fff;
}

.scroller-right{
  float:right;
}

.scroller-left {
  float:left;
}
#main-wrapper .all-menu-details .dropdown-option{
	display:none;
}
.bgm-blue {
    background-color: #2196f3 !important;
}
.btn-xs, .btn-group-xs > .btn {
    padding: 2px 5px;
    font-size: 13px;
    line-height: 1.5;
    border-radius: 2px;
}
</style>
</head>

<body>
	<div id="main-wrapper">
		<header id="header">
			<div class="header-nav-bar">
				<nav class="navbar navbar-default" role="navigation">
					<div class="container">
						<!-- Brand and toggle get grouped for better mobile display -->
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
							<a class="navbar-brand" href="http://foodnai.com/foodnai_restaurant_menu/">
								<img src="<?php echo base_url();?>assets/rest_assets/img/FoodNAI Logo.png" alt="">
							</a>
						</div>

						<!-- Collect the nav links, forms, and other content for toggling -->
						<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
							<ul class="nav navbar-nav navbar-right">
								<li class="dropdown">
									<center><a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $restDetails['name'];?></a></center>
								</li>
							</ul>
						</div>
						<!-- /.navbar-collapse -->
					</div>
					<!-- /.container-fluid -->
				</nav>
			</div>
			<!-- end .header-nav-bar -->
		</header>
		<!-- end #header -->
		<div id="page-content">
			<div class="container">
				<div class="row mt30">
					<div class="col-md-12">
						
						<div class="container">
							<div class="scroller scroller-left"><i class="glyphicon glyphicon-chevron-left"></i></div>
							<div class="scroller scroller-right"><i class="glyphicon glyphicon-chevron-right"></i></div>
							<div class="wrapper">
								<ul class="nav nav-tabs list" id="myTab">
									<?php 
									
									$count1 = count($menuGroups);
									if($count1 > 0)
									{
										$i=1;
										foreach($menuGroups as $menuGroup){
									?>
									<li class="mainmenu" id="li_<?php echo $menuGroup['id']; ?>"><a class="menuGrroup_li_<?php echo $i;?>" id="<?php echo $menuGroup['id']; ?>" href="javascript:get_recipes('<?php echo $menuGroup['id']; ?>')"><?php echo ucfirst($menuGroup['title']); ?></a></li><?php $i++;}} ?>
								</ul>
							</div>
						</div>

					

						<div class="tab-content">
							
							<div class="tab-pane fade in active menu-items-data" id="tab-1">
								
							</div>
							<!-- end .tab-pane -->
							
							
							
						</div>
						<!-- end .tab-content -->
					</div>
					<!--end main-grid layout-->
				</div>
				<!-- end .row -->
			</div>
			<!--end .container -->
			<!-- footer begin -->
			<footer id="footer">
				<div class="footer-copyright">
					<div class="container">
						<p>Copyright 2020 © <a href="https://rslsolution.com/" target="_blank">RSL Solution Pvt Ltd</a>. All rights reserved.</p>
					</div>
				</div>
			</footer>
			<!-- end #footer -->
			
		</div> <!-- end .page-content -->
	</div>
		<!-- end #main-wrapper -->
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<!-- Local jQuery -->
		<script>
		window.jQuery || document.write('<script src="js/jquery-1.11.0.min.js"><\/script>')
		</script>
		<script src="../assets/rest_assets/js/jquery-ui-1.10.4.custom.min.js" type="text/javascript"></script>
		<script src="../assets/rest_assets/js/jquery.magnific-popup.min.js"></script>
		<script src="../assets/rest_assets/js/owl.carousel.js"></script>
		<script src="../assets/rest_assets/js/bootstrap.js"></script>
		<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
		<script type="text/javascript" src="../assets/rest_assets/js/jquery.ui.map.js"></script>
		<script src="../assets/rest_assets/js/scripts.js"></script>
<script>
/*--- script for horizontal menu scroll ---*/
var hidWidth;
var scrollBarWidths = 40;
var selectedMenuGroup=0;
var widthOfList = function(){
  var itemsWidth = 0;
  $('.list li').each(function(){
    var itemWidth = $(this).outerWidth();
    itemsWidth+=itemWidth;
  });
  return itemsWidth;
};

var widthOfHidden = function(){
  return (($('.wrapper').outerWidth())-widthOfList()-getLeftPosi())-scrollBarWidths;
};

var getLeftPosi = function(){
  return $('.list').position().left;
};

var reAdjust = function(){
  if (($('.wrapper').outerWidth()) < widthOfList()) {
    $('.scroller-right').show();
  }
  else {
    $('.scroller-right').hide();
  }
  
  if (getLeftPosi()<0) {
    $('.scroller-left').show();
  }
  else {
    $('.item').animate({left:"-="+getLeftPosi()+"px"},'slow');
  	$('.scroller-left').hide();
  }
}

reAdjust();

$(window).on('resize',function(e){  
  	reAdjust();
});

$('.scroller-right').click(function() {
  
  $('.scroller-left').fadeIn('slow');
  $('.scroller-right').fadeOut('slow');
  
  $('.list').animate({left:"+="+widthOfHidden()+"px"},'slow',function(){

  });
});

$('.scroller-left').click(function() {
  
	$('.scroller-right').fadeIn('slow');
	$('.scroller-left').fadeOut('slow');
  
  	$('.list').animate({left:"-="+getLeftPosi()+"px"},'slow',function(){
  	
  	});
});    
</script>
<script>
var loadedRecieps=[];
	function toggleNutrition(e,rId,aRId)
	{
		loadAlacalcAllergenNutrtion(rId,aRId);
		$(e).toggleClass("active");
		$(e).parent().parent().next()
			.slideToggle(300);
		$(e).parent().parent()
			.toggleClass('red');
	}
	
	function get_recipes(a,page=1)
	{
		loadedRecieps=[];
		selectedMenuGroup=a;
		$('.mainmenu').removeClass('active');
		$('#li_'+a).addClass('active');
		$('.menu-items-data').html("<div class='row'><div class='col-md-12'><p><strong>Loading menu items...</strong></p></div></div>");
		$.ajax({ 
			type : 'POST',
			url : '<?php echo base_url();?>/restaurants/getmenuitems',
			data : {"mid":a,"page":page,'rid':'<?php echo $restDetails['id'];?>'},
			success : function(response)
			{
				console.log(response);
				$('.menu-items-data').html(response); 
				let all={"Energ_Kcal":"show", "Energ_Kcal_from_Fat":"show", "Energ_KJ":"show", "Protein":"show", "Lipid_Tot":"show", "FA_Sat":"show", "FA_Mono":"show", "FA_Poly":"show", "FA_Trans":"show", "Carbohydrt":"show", "Sugar_Tot":"show", "Star":"show", "Fiber_TD":"show", "Sodium":"show", "Salt":"show", "Water":"show", "Nitrogen":"show", "Cholestrl":"show", "Potassium":"show", "Calcium":"show", "Magnesium":"show", "Phosphorus":"show", "Iron":"show", "Copper":"show", "Zinc":"show", "Chloride":"show", "Manganese":"show", "Selenium":"show", "Iodine":"show", "Retinol":"show", "Carotene":"show", "Alpha_Carot":"show", "Beta_Carot":"show", "Vit_D_mcg":"show", "Vit_D_IU":"show", "Vit_E":"show", "Thiamin":"show", "Riboflavin":"show", "Niacin":"show", "Tryptophan60":"show", "Vit_B6":"show", "Vit_B12":"show", "Folate_Tot":"show", "Panto_Acid":"show", "Biotin":"show", "Vit_C":"show", "Ash":"show", "Folic_Acid":"show", "Food_Folate":"show", "Folate_DFE":"show", "Choline_Tot":"show", "Vit_A_IU":"show", "Vit_A_RAE":"show", "Beta_Crypt":"show", "Lycopene":"show", "Lut_Zea":"show", "Vit_K":"show", "nutritional_selections_nutrients":"hide","other_nutrient_header":"show","minerals_nutrient_header":"show","vitamins_nutrient_header":"show","common_nutrient_header":"show"};
				let big8={'Energ_Kcal':'show', 'Energ_Kcal_from_Fat':'hide', 'Energ_KJ':'show', 'Protein':'show', 'Lipid_Tot':'show', 'FA_Sat':'show', 'FA_Mono':'hide', 'FA_Poly':'hide', 'FA_Trans':'hide', 'Carbohydrt':'show', 'Sugar_Tot':'show', 'Star':'hide', 'Fiber_TD':'hide', 'Sodium':'hide', 'Salt':'show', 'Water':'hide', 'Nitrogen':'hide', 'Cholestrl':'hide', 'Potassium':'hide', 'Calcium':'hide', 'Magnesium':'hide', 'Phosphorus':'hide', 'Iron':'hide', 'Copper':'hide', 'Zinc':'hide', 'Chloride':'hide', 'Manganese':'hide', 'Selenium':'hide', 'Iodine':'hide', 'Retinol':'hide', 'Carotene':'hide', 'Alpha_Carot':'hide', 'Beta_Carot':'hide', 'Vit_D_mcg':'hide', 'Vit_D_IU':'hide', 'Vit_E':'hide', 'Thiamin':'hide', 'Riboflavin':'hide', 'Niacin':'hide', 'Tryptophan60':'hide', 'Vit_B6':'hide', 'Vit_B12':'hide', 'Folate_Tot':'hide', 'Panto_Acid':'hide', 'Biotin':'hide', 'Vit_C':'hide', 'Ash':'hide', 'Folic_Acid':'hide', 'Food_Folate':'hide', 'Folate_DFE':'hide', 'Choline_Tot':'hide', 'Vit_A_IU':'hide', 'Vit_A_RAE':'hide', 'Beta_Crypt':'hide', 'Lycopene':'hide', 'Lut_Zea':'hide', 'Vit_K':'hide', 'nutritional_selections_nutrients':'hide','other_nutrient_header':'hide','minerals_nutrient_header':'hide','vitamins_nutrient_header':'hide','common_nutrient_header':'show'};
				let vitamins={'Energ_Kcal':'hide', 'Energ_Kcal_from_Fat':'hide','Energ_KJ':'hide', 'Protein':'hide', 'Lipid_Tot':'hide', 'FA_Sat':'hide', 'FA_Mono':'hide', 'FA_Poly':'hide', 'FA_Trans':'hide', 'Carbohydrt':'hide', 'Sugar_Tot':'hide', 'Star':'hide', 'Fiber_TD':'hide', 'Sodium':'hide', 'Salt':'hide', 'Water':'hide', 'Nitrogen':'hide', 'Cholestrl':'hide', 'Potassium':'hide', 'Calcium':'hide', 'Magnesium':'hide', 'Phosphorus':'hide', 'Iron':'hide', 'Copper':'hide', 'Zinc':'hide', 'Chloride':'hide', 'Manganese':'hide', 'Selenium':'hide', 'Iodine':'hide', 'Retinol':'hide', 'Carotene':'hide', 'Alpha_Carot':'hide', 'Beta_Carot':'hide', 'Vit_D_mcg':'show', 'Vit_D_IU':'show', 'Vit_E':'show', 'Thiamin':'hide', 'Riboflavin':'hide', 'Niacin':'hide', 'Tryptophan60':'hide', 'Vit_B6':'show', 'Vit_B12':'show', 'Folate_Tot':'hide', 'Panto_Acid':'hide', 'Biotin':'hide', 'Vit_C':'show', 'Ash':'hide', 'Folic_Acid':'hide', 'Food_Folate':'hide', 'Folate_DFE':'hide', 'Choline_Tot':'hide', 'Vit_A_IU':'show', 'Vit_A_RAE':'show', 'Beta_Crypt':'hide', 'Lycopene':'hide', 'Lut_Zea':'hide', 'Vit_K':'show', 'nutritional_selections_nutrients':'hide','other_nutrient_header':'hide','minerals_nutrient_header':'hide','vitamins_nutrient_header':'show','common_nutrient_header':'show'};
				$('.show-all').attr('data-elements',JSON.stringify(all));
				$('.show-big8').attr('data-elements',JSON.stringify(big8));
				$('.show-vitamins').attr('data-elements',JSON.stringify(vitamins));
			},error:function (error) {
				$('.menu-items-data').html("<div class='row'><div class='col-md-12'><p><strong>Menu items not found</strong></p></div></div>");
			}
		});
	}
	function nextRecord(page){
		
		get_recipes(selectedMenuGroup,page);
	}
	$(document).ready(function(){
		let firstGroup=$('.menuGrroup_li_1').attr('id');
		selectedMenuGroup=firstGroup;
		if(selectedMenuGroup>0){
		get_recipes(firstGroup);
		}
	})
</script>
<script src="http://foodnai.com/assets/js/custom/Reciepe.js"></script>

<script type="text/javascript">
function loadAlacalcAllergenNutrtion(recipe_id,alacalc_recipe_id){
	
	let isLoaded=loadedRecieps.find((item)=>{
		return alacalc_recipe_id==item;
	});
	if(!isLoaded){
		loadedRecieps.push(alacalc_recipe_id);
		$('.gross-weight').hide();
		$('.gross-weight.'+alacalc_recipe_id).show();
		
		Reciepe.base_url="https://foodnai.com/";
		Reciepe.recipe_id=recipe_id;
		Reciepe.alacalc_recipe_id=alacalc_recipe_id;
		Reciepe.c_from='Front';
		Reciepe.is_nutrition=1;
		Reciepe.init();
		$('.foodnai-info-loader').html('');
	}else{
		return false;
	}
	
	//$('.recipe-tabs').find('.nutrition .card-body').addClass('active');
}
	
</script>			
</body>
</html>