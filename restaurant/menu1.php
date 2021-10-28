<?php 
	$con = mysqli_connect('localhost','foodnaic_foodnai','HzVzy6SD!uaN','foodnaic_foodnai');
	$restName=$_GET['restName'];
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>FoodNAI Menu</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
	<link rel="shortcut icon" href="images/FoodNAI_favicon.png">
	
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Indie+Flower" rel="stylesheet">

    <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">
    
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">

    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/ionicons.min.css">

    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/jquery.timepicker.css">

    
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/style.css">
  
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
    background-color: #6c757d !important;
}
.btn-xs, .btn-group-xs > .btn {
    padding: 7px 16px;
    font-size: 13px;
    line-height: 1.5;
    border-radius: 5px;
}
.ftco-animate {
    opacity: 1;
    visibility: visible;
}
.div-nutrition .nutrient_value,.div-nutrition .nutrient_measure{
	display:inline;
}
.div-nutrition .trace.per_100,.div-nutrition .trace.per_portion,.div-nutrition #header_row .trace.text-center{
	text-align:right!important;
}
.thumbnailgallery {
    margin-bottom:40px;
    width:100%;
    height:90px;
    overflow:hidden;
}
.showrooms a.logo {
    display:inline-block;
    float: left;
	margin: 20px 16px;
	min-width:245px; 
	padding:16px;
	background:#fff;
	text-align:center;
	text-decoration:none;
	color: #a5a5ab;
    font-weight: 700;
  /*float: left; Remove this*/
  display: inline-block; /*Add this*/
}
a.logo.active{
	background: #8ec63d;
    color: #404044;
}

.showrooms img {
    border-radius: 5px;
    padding: 3px;
    display:block;
    border: 1px solid green;
}
.arrowleft, .arrowright {
    font-size:30px;
    cursor:pointer;
    display:inline-block;
    padding:20px;
	background-color:#ccc;
	color:#000;
	position:absolute;
}
.arrowleft.active,.arrowright.active{
	background-color:#8ec63d;
	color:#fff;
}
.arrowleft{
	left:-60px;
	

}
.arrowright{
	right:-60px;
}

</style>
  
  </head>
  <body>
    
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
      <div class="container">
        <a class="navbar-brand" href="index.html"><?php echo $restName;?></a>
        <!--<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="oi oi-menu"></span> Menu
        </button>

        <div class="collapse navbar-collapse" id="ftco-nav">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a href="index.html" class="nav-link">Home</a></li>
            <li class="nav-item active"><a href="menu.html" class="nav-link">Menu</a></li>
            <li class="nav-item"><a href="specialties.html" class="nav-link">Specialties</a></li>
            <li class="nav-item"><a href="reservation.html" class="nav-link">Reservation</a></li>
            <li class="nav-item"><a href="blog.html" class="nav-link">Blog</a></li>
            <li class="nav-item"><a href="about.html" class="nav-link">About</a></li>
            <li class="nav-item"><a href="contact.html" class="nav-link">Contact</a></li>
          </ul>
        </div>-->
      </div>
    </nav>
    <!-- END nav -->
    
    <section class="home-slider owl-carousel">
      <div class="slider-item" style="background-image: url('images/menubackground.jpg');" data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
          <div class="row slider-text align-items-center justify-content-center">
            <div class="col-md-10 col-sm-12 ftco-animate text-center">
              <h1 class="mb-3">Discover Our Menus</h1>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section bg-light">
      <div class="container">
        <div class="row justify-content-center mb-5 pb-5">
          <div class="col-md-7 text-center heading-section ftco-animate">
            <h2>Exclusive Menu</h2>
          </div>
        </div>
        <div class="row">
			
          <div class="col-md-12 dish-menu">

            <div class="nav nav-pills justify-content-center ftco-animate" id="v-pills-tab" role="tablist" aria-orientation="horizontal">
			<div class="thumbnailgallery"> 
    <div class="showrooms clearfix">
			  <?php 
				$query1 = "SELECT * FROM `menu_group` WHERE `is_active`= 1 AND `logged_user_id`='53'";
				$result1 = mysqli_query($con, $query1);
				$count1 = mysqli_num_rows($result1);
				if($count1 > 0)
				{
					$i=1;
					while($row1 = mysqli_fetch_assoc($result1))
					{
						
			  ?>
				
				<a class="menu-tab mainmenu logo" data-id="<?php echo $row1['id'];?>" id="li_<?php echo $row1['id']; ?> v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">
				<input type="hidden" id="<?php echo $row1['id']; ?>" class="menuGroup_li_<?php echo $i;?>">
				<?php echo ucfirst($row1['title']); ?></a>
			  <?php $i++;}} ?>
			  </div>
			  </div>
			  <span class="arrowleft" id="prev"><i class="icon-chevron-left"></i></span>
 <span class="arrowright active" id="next"><i class="icon-chevron-right"></i></span>
            </div>

            
             <div class="tab-content py-5" id="v-pills-tabContent">
             
              <div class="tab-pane fade menu-items-data" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                <div class="row">
                  
                </div>
              </div><!-- END -->

              <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                <div class="row">
                  
                </div>
              </div>
            </div>
			
            
			
			
          </div>
        </div>
      </div>
	  
<!-- End items --> 
    </section>
    <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLongTitle">Allergens and Nutrition Information</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<ul class="list-unstyled mt-3 mb-4 ul-allgerens">
				<li><h5 style="color:#37A445;">Allergens</h5></li>
				<li class="border-bottom-0 p-2 p-allergens-li" style="text-transform:capitalize;">
					<span class="foodnai-info-loader">"Loading Information...</span>
				
				</li>
			</ul>
			<span class="foodnai-info-loader">"Loading Information...</span>
			
			<div class="hidden-pdf" id="nutritional_selections_recommended">
				<div class="row">
					<div class="col-md-6 " ><h5 style="color:#37A445;">Nutrition Information</h5></div>
						<div class="col-md-6">
							<div class="col-xs-10">
								<a class="btn btn-xs select-recommendation selector waves-effect waves-button waves-float btn-secondary bgm-blue" data-elements='{"Energ_Kcal":"show", "Energ_Kcal_from_Fat":"show", "Energ_KJ":"show", "Protein":"show", "Lipid_Tot":"show", "FA_Sat":"show", "FA_Mono":"show", "FA_Poly":"show", "FA_Trans":"show", "Carbohydrt":"show", "Sugar_Tot":"show", "Star":"show", "Fiber_TD":"show", "Sodium":"show", "Salt":"show", "Water":"show", "Nitrogen":"show", "Cholestrl":"show", "Potassium":"show", "Calcium":"show", "Magnesium":"show", "Phosphorus":"show", "Iron":"show", "Copper":"show", "Zinc":"show", "Chloride":"show", "Manganese":"show", "Selenium":"show", "Iodine":"show", "Retinol":"show", "Carotene":"show", "Alpha_Carot":"show", "Beta_Carot":"show", "Vit_D_mcg":"show", "Vit_D_IU":"show", "Vit_E":"show", "Thiamin":"show", "Riboflavin":"show", "Niacin":"show", "Tryptophan60":"show", "Vit_B6":"show", "Vit_B12":"show", "Folate_Tot":"show", "Panto_Acid":"show", "Biotin":"show", "Vit_C":"show", "Ash":"show", "Folic_Acid":"show", "Food_Folate":"show", "Folate_DFE":"show", "Choline_Tot":"show", "Vit_A_IU":"show", "Vit_A_RAE":"show", "Beta_Crypt":"show", "Lycopene":"show", "Lut_Zea":"show", "Vit_K":"show", "nutritional_selections_nutrients":"hide","other_nutrient_header":"show","minerals_nutrient_header":"show","vitamins_nutrient_header":"show","common_nutrient_header":"show"}' data-set="groups" id="allr-recommendation" style="position:relative;float:left;color: #fff;">All</a>
								<a class="btn btn-xs select-recommendation selector waves-effect waves-button waves-float btn-secondary" data-elements='{"Energ_Kcal":"show", "Energ_Kcal_from_Fat":"hide", "Energ_KJ":"show", "Protein":"show", "Lipid_Tot":"show", "FA_Sat":"show", "FA_Mono":"hide", "FA_Poly":"hide", "FA_Trans":"hide", "Carbohydrt":"show", "Sugar_Tot":"show", "Star":"hide", "Fiber_TD":"hide", "Sodium":"hide", "Salt":"show", "Water":"hide", "Nitrogen":"hide", "Cholestrl":"hide", "Potassium":"hide", "Calcium":"hide", "Magnesium":"hide", "Phosphorus":"hide", "Iron":"hide", "Copper":"hide", "Zinc":"hide", "Chloride":"hide", "Manganese":"hide", "Selenium":"hide", "Iodine":"hide", "Retinol":"hide", "Carotene":"hide", "Alpha_Carot":"hide", "Beta_Carot":"hide", "Vit_D_mcg":"hide", "Vit_D_IU":"hide", "Vit_E":"hide", "Thiamin":"hide", "Riboflavin":"hide", "Niacin":"hide", "Tryptophan60":"hide", "Vit_B6":"hide", "Vit_B12":"hide", "Folate_Tot":"hide", "Panto_Acid":"hide", "Biotin":"hide", "Vit_C":"hide", "Ash":"hide", "Folic_Acid":"hide", "Food_Folate":"hide", "Folate_DFE":"hide", "Choline_Tot":"hide", "Vit_A_IU":"hide", "Vit_A_RAE":"hide", "Beta_Crypt":"hide", "Lycopene":"hide", "Lut_Zea":"hide", "Vit_K":"hide", "nutritional_selections_nutrients":"hide","other_nutrient_header":"hide","minerals_nutrient_header":"hide","vitamins_nutrient_header":"hide","common_nutrient_header":"show"}' data-set="groups" id="big8-recommendation" style="position:relative;float:left;color: #fff;">"Big 8"</a>
								<a class="btn btn-xs select-recommendation selector waves-effect waves-button waves-float btn-secondary" data-elements='{"Energ_Kcal":"hide", "Energ_Kcal_from_Fat":"hide","Energ_KJ":"hide", "Protein":"hide", "Lipid_Tot":"hide", "FA_Sat":"hide", "FA_Mono":"hide", "FA_Poly":"hide", "FA_Trans":"hide", "Carbohydrt":"hide", "Sugar_Tot":"hide", "Star":"hide", "Fiber_TD":"hide", "Sodium":"hide", "Salt":"hide", "Water":"hide", "Nitrogen":"hide", "Cholestrl":"hide", "Potassium":"hide", "Calcium":"hide", "Magnesium":"hide", "Phosphorus":"hide", "Iron":"hide", "Copper":"hide", "Zinc":"hide", "Chloride":"hide", "Manganese":"hide", "Selenium":"hide", "Iodine":"hide", "Retinol":"hide", "Carotene":"hide", "Alpha_Carot":"hide", "Beta_Carot":"hide", "Vit_D_mcg":"show", "Vit_D_IU":"show", "Vit_E":"show", "Thiamin":"hide", "Riboflavin":"hide", "Niacin":"hide", "Tryptophan60":"hide", "Vit_B6":"show", "Vit_B12":"show", "Folate_Tot":"hide", "Panto_Acid":"hide", "Biotin":"hide", "Vit_C":"show", "Ash":"hide", "Folic_Acid":"hide", "Food_Folate":"hide", "Folate_DFE":"hide", "Choline_Tot":"hide", "Vit_A_IU":"show", "Vit_A_RAE":"show", "Beta_Crypt":"hide", "Lycopene":"hide", "Lut_Zea":"hide", "Vit_K":"show", "nutritional_selections_nutrients":"hide","other_nutrient_header":"hide","minerals_nutrient_header":"hide","vitamins_nutrient_header":"show","common_nutrient_header":"show"}' data-set="groups" id="vitamins-recommendation" style="position:relative;float:left;color: #fff;">Vitamins</a>
								<!-- <a class="btn btn-xs select-recommendation selector waves-effect waves-button waves-float btn-default btn-select-custom" data-elements='{"nutritional_selections_nutrients":"toggle"}' data-set="groups" id="custom-recommendation">Custom</a> -->
							</div>
						</div>
					</div>
					<hr>
					<span class="foodnai-info-loader">"Loading Information...</span>
          <div class="div-nutrition"></div>
					<div id="nutritional_selections_nutrients" style="display:none;">
						<div class="row">
							<div class="col-md-2">
								<div class="nutrient-selector-header" id="common-selector">
									<b>Main</b>
								</div>
							</div>
							<div class="col-md-10">
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Energ_KJ":"toggle"}' id="Energ_KJ-selector">Energy</div>
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Energ_Kcal":"toggle"}' id="Energ_Kcal-selector">Energy</div>
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Lipid_Tot":"toggle"}' id="Lipid_Tot-selector">Fat</div>
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"FA_Sat":"toggle"}' id="FA_Sat-selector">  of which saturates</div>
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"FA_Mono":"toggle"}' id="FA_Mono-selector">Fatty Acids Monounsaturated</div>
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"FA_Poly":"toggle"}' id="FA_Poly-selector">Fatty Acids Polyunsaturated</div>
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"FA_Trans":"toggle"}' id="FA_Trans-selector">Trans Fatty Acids</div>
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Carbohydrt":"toggle"}' id="Carbohydrt-selector">Carbohydrate</div>
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Sugar_Tot":"toggle"}' id="Sugar_Tot-selector">of which sugars</div>
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Sugar_Added":"toggle"}' id="Sugar_Added-selector">Added Sugar</div>
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Fiber_TD":"toggle"}' id="Fiber_TD-selector">Fibre</div>
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Protein":"toggle"}' id="Protein-selector">Protein</div>
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Salt":"toggle"}' id="Salt-selector">Salt</div>
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Sodium":"toggle"}' id="Sodium-selector">Sodium</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2">
								<div class="nutrient-selector-header" id="vitamins-selector">
									Vitamins
								</div>
							</div>
							<div class="col-md-10">
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Vit_A_IU":"toggle"}' id="Vit_A_IU-selector">Vitamin A IU</div>
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Vit_A_RAE":"toggle"}' id="Vit_A_RAE-selector">Vitamin A RAE</div>
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Carotene":"toggle"}' id="Carotene-selector">Carotene</div>
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Alpha_Carot":"toggle"}' id="Alpha_Carot-selector">Alpha Carotene</div>
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Beta_Carot":"toggle"}' id="Beta_Carot-selector">Beta Carotene</div>
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Retinol":"toggle"}' id="Retinol-selector">Retinol</div>
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Beta_Crypt":"toggle"}' id="Beta_Crypt-selector">Beta Cryptoxanthin</div>
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Thiamin":"toggle"}' id="Thiamin-selector">Thiamin</div>
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Riboflavin":"toggle"}' id="Riboflavin-selector">Riboflavin</div>
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Niacin":"toggle"}' id="Niacin-selector">Niacin</div>
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Panto_Acid":"toggle"}' id="Panto_Acid-selector">Pantothenic Acid</div>
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Vit_B6":"toggle"}' id="Vit_B6-selector">Vitamin B6</div>
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Folic_Acid":"toggle"}' id="Folic_Acid-selector">Folic Acid</div>
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Folate_DFE":"toggle"}' id="Folate_DFE-selector">Dietary Folate Equivalents</div>
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Food_Folate":"toggle"}' id="Food_Folate-selector">Food Folate</div>
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Folate_Tot":"toggle"}' id="Folate_Tot-selector">Folate</div>
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Vit_B12":"toggle"}' id="Vit_B12-selector">Vitamin B12</div>
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Vit_C":"toggle"}' id="Vit_C-selector">Vitamin C</div>
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Vit_D_IU":"toggle"}' id="Vit_D_IU-selector">Vitamin D IU</div>
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Vit_D_mcg":"toggle"}' id="Vit_D_mcg-selector">Vitamin D MCG</div>
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Vit_E":"toggle"}' id="Vit_E-selector">Vitamin E</div>
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Biotin":"toggle"}' id="Biotin-selector">Biotin</div>
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Vit_K":"toggle"}' id="Vit_K-selector">Vitamin K</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2">
								<div class="nutrient-selector-header" id="minerals-selector">
									Minerals
								</div>
							</div>
							<div class="col-md-10">
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Calcium":"toggle"}' id="Calcium-selector">Calcium</div>
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Chloride":"toggle"}' id="Chloride-selector">Chloride</div>
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Choline_Tot":"toggle"}' id="Choline_Tot-selector">Choline</div>
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Copper":"toggle"}' id="Copper-selector">Copper</div>
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Iodine":"toggle"}' id="Iodine-selector">Iodine</div>
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Iron":"toggle"}' id="Iron-selector">Iron</div>
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Magnesium":"toggle"}' id="Magnesium-selector">Magnesium</div>
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Manganese":"toggle"}' id="Manganese-selector">Manganese</div>
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Nitrogen":"toggle"}' id="Nitrogen-selector">Nitrogen</div>
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Phosphorus":"toggle"}' id="Phosphorus-selector">Phosphorus</div>
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Potassium":"toggle"}' id="Potassium-selector">Potassium</div>
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Selenium":"toggle"}' id="Selenium-selector">Selenium</div>
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Tryptophan60":"toggle"}' id="Tryptophan60-selector">Tryptophan/60</div>
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Zinc":"toggle"}' id="Zinc-selector">Zinc</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2">
								<div class="nutrient-selector-header" id="other-selector">
									Other
								</div>
							</div>
							<div class="col-md-10">
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Ash":"toggle"}' id="Ash-selector">Ash</div>
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Cholestrl":"toggle"}' id="Cholestrl-selector">Cholesterol</div>
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Lut_Zea":"toggle"}' id="Lut_Zea-selector">Lutein Zeaxanthin</div>
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Lycopene":"toggle"}' id="Lycopene-selector">Lycopene</div>
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Star":"toggle"}' id="Star-selector">Starch</div>
								<div class="nutrient-selector btn bgm-blue btn-xs selector m-b-5 waves-effect waves-button waves-float" data-elements='{"Water":"toggle"}' id="Water-selector">Water</div>
							</div>
						</div>
						<hr class="hidden-pdf">
					</div>
				</div>
			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		  </div>
		</div>
	  </div>
	</div>
	<!-- End Modal for NAI -->
   
   
   <footer class="ftco-footer ftco-bg-dark ftco-section" style="padding: 11px 0;">
      <div class="container">
        <div class="row">
          <div class="col-md-12 text-center">

            <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
			Powered by <a href="https://www.foodnai.com/" target="_blank">FoodNAI</a>: the leading provider of digital menu and food nutrition technology. © <script>document.write(new Date().getFullYear());</script> <a href="https://www.foodnai.com/" target="_blank">FoodNAI</a>
			<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
          </div>
        </div>
      </div>
    </footer>
   
 
  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>


  <script src="js/jquery.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.easing.1.3.js"></script>
  <script src="js/jquery.waypoints.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/jquery.animateNumber.min.js"></script>
  <script src="js/bootstrap-datepicker.js"></script>
  <script src="js/jquery.timepicker.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="js/google-map.js"></script>
  <script src="js/main.js"></script>
    
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
			url : 'get_menuitems_new.php',
			data : {"mid":a,"page":page},
			success : function(response)
			{
       			$('.menu-items-data').html(response); 
			},error:function (error) {
				$('.menu-items-data').html("<div class='row'><div class='col-md-12'><p><strong>Menu items not found</strong></p></div></div>");
			}
		});
	}
	function nextRecord(page){
		
		get_recipes(selectedMenuGroup,page);
	}
	$(document).ready(function(){
		let firstGroup=$('.menuGroup_li_1').attr('id');
		selectedMenuGroup=firstGroup;
		if(selectedMenuGroup>0){
		//get_recipes(firstGroup,1);
		$('[data-id="'+selectedMenuGroup+'"]').click();
		}
	})
</script>
<script src="https://foodnai.com/admin/assets/js/custom/Reciepe.js"></script>

<script type="text/javascript">
function loadAlacalcAllergenNutrtion(recipe_id,alacalc_recipe_id){
	
	let isLoaded=loadedRecieps.find((item)=>{
		return alacalc_recipe_id==item;
	});
	if(!isLoaded){
		loadedRecieps.push(alacalc_recipe_id);
		$('.gross-weight').hide();
		$('.gross-weight.'+alacalc_recipe_id).show();
		
		Reciepe.base_url="https://foodnai.com/admin/";
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
	$('.menu-tab').on("click", function(e){
       let menuid=$(e.target).attr('data-id');
       get_recipes(menuid);
  })
function menuclick(rId,aRId){
	
	$('.div-nutrition').attr('id','div-nutrition_'+aRId);
  $('.p-allergens-li').attr('id','p-allergens-li_'+aRId);
  $('.ul-allgerens').attr('id','ul-allgerens_'+aRId);
  $('.div-nutrition').html('');
	$('#p-allergens-li_'+aRId+' ul').remove();

  loadAlacalcAllergenNutrtion(rId,aRId);
  
  

  $('#exampleModalLong').modal();
}
var prevClick = false;
var nextClick = false;
$('#prev').on('click', function () {
	if(prevClick)
	return false;
	prevClick=true;
	let totalItem=$('.showrooms a').length;
	let pos=$('.showrooms').css('margin-left');
	let posnum=pos.split('px');
	let nextpos= parseFloat(posnum)+parseFloat(4*208);
	if(pos=='0px')
	{
		$('#prev').removeClass('active');
		prevClick=false;
		return false;
	}
	nextpos = nextpos+'px';
	$('.showrooms').animate({marginLeft: nextpos},1000,"linear",function(){
		prevClick=false;
	});
	$('#next').addClass('active');
	
	
});
$('#next').on('click', function () {
	if(nextClick)
	return false;
	nextClick=true;
	let totalItem=$('.showrooms a').length;
	let pos=$('.showrooms').css('margin-left');
	let posnum=pos.split('px');
	let nextpos= parseFloat(posnum)-parseFloat(4*208);

	if(parseFloat(nextpos)< parseFloat(-totalItem*208))
	{
		$('#next').removeClass('active');
		nextClick=false;
		return false;
	}
	nextpos = nextpos+'px';
	$('.showrooms').animate({marginLeft: nextpos},1000,"linear",function(){
		nextClick=false;
	});
	$('#prev').addClass('active');
});
</script>	
	
  </body>
</html>