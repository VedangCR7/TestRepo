<?php
require_once('header.php');
require_once('sidebar.php');
require_once('recipe_header.php');

?>

	<div class="row recipe-overview">
		<div class="col-md-12">
			<div class="card">
				<div class="pri-header">
					<h3 class="mr-1 mb-0">Welcome to recipe optimisation
					</h3>
				</div>
				<div class="card-body">
					<ul class="list-unstyled mt-3 mb-4">
					  	<li class="border-bottom-0 p-1"><label>This page gives you a detailed breakdown of how ingredients contribute to the total nutritional values. Furthermore you can define nutritional targets, and a la calc will tell you how you achieve them by adjusting the recipe.</label></li>
					</ul>
				</div>
			</div>
		</div>

		<div class="col-md-12">
			<div class="card">
				<div class="pri-header">
					<h3 class="mr-1 mb-0">Preview ?
					</h3>
				</div>
				<div class="card-body">
					<div class="card-body card-padding">
						<p class="hidden">Chart style:</p>
						<div class="hidden">
						<input type="hidden" name="locale" id="locale" value="en">
						<select name="plot_style" id="plot_style"><option value="targets">Bar chart with targets</option>
						<option value="traffic-lights-combined">Traffic light</option>
						<option value="pies">Pie chart</option>
						<option selected="selected" value="traffic-light-pies">Traffic light and pie chart</option>
						<option value="fda-svg">FDA SVG</option>
						<option value="eu-svg">EU SVG</option></select>
						</div>
						<div id="graphs">
						<div id="graph-background" style="position:absolute;height:103%;z-index:0;">
						<svg height="100%" width="660">
						<rect class="outer" fill="#58585a" height="100%" width="100%"></rect>
						<rect class="inner" fill="#bebdc0" height="368" rx="15" ry="15" width="640" x="10" y="10"></rect>
						</svg>
						</div>
						<div class="viz-content" id="viz_top" style="padding: 20px 20px 0px 135px; width: 660px;">
						<div class="graph-section-label" style="position: absolute; display: inline-block; left: 20px; top: 40px; width: 100px; font-weight: bold; font-size: 18px;">Nutrients</div>
						<div style="display: inline" class="traffic-light-chart"><svg width="100" height="100" text-anchor="middle"><rect x="5" y="5" rx="10" ry="10" r="0" width="90" height="90" fill="#939598"></rect><text x="50" y="25" style="font-size: 13px; font-weight: bold;">Energy</text><text x="50" y="45" style="font-size: 16px;">29kcal</text></svg></div><div style="display: inline" class="traffic-light-chart"><svg width="100" height="100" text-anchor="middle"><rect x="5" y="5" rx="10" ry="10" r="0" width="90" height="90" fill="green"></rect><text x="50" y="25" style="font-size: 13px; font-weight: bold;">Fat</text><text x="50" y="45" style="font-size: 16px;">0.3g</text><rect x="10" y="50" rx="2" ry="2" width="80" height="20" fill="white"></rect><text x="50" y="65" style="font-size: 13px; font-weight: bold;">LOW</text></svg></div><div style="display: inline" class="traffic-light-chart"><svg width="100" height="100" text-anchor="middle"><rect x="5" y="5" rx="10" ry="10" r="0" width="90" height="90" fill="green"></rect><text x="50" y="25" style="font-size: 13px; font-weight: bold;">Saturates</text><text x="50" y="45" style="font-size: 16px;">0g</text><rect x="10" y="50" rx="2" ry="2" width="80" height="20" fill="white"></rect><text x="50" y="65" style="font-size: 13px; font-weight: bold;">LOW</text></svg></div><div style="display: inline" class="traffic-light-chart"><svg width="100" height="100" text-anchor="middle"><rect x="5" y="5" rx="10" ry="10" r="0" width="90" height="90" fill="green"></rect><text x="50" y="25" style="font-size: 13px; font-weight: bold;">Sugar</text><text x="50" y="45" style="font-size: 16px;">4.4g</text><rect x="10" y="50" rx="2" ry="2" width="80" height="20" fill="white"></rect><text x="50" y="65" style="font-size: 13px; font-weight: bold;">LOW</text></svg></div><div style="display: inline" class="traffic-light-chart"><svg width="100" height="100" text-anchor="middle"><rect x="5" y="5" rx="10" ry="10" r="0" width="90" height="90" fill="green"></rect><text x="50" y="25" style="font-size: 13px; font-weight: bold;">Salt</text><text x="50" y="45" style="font-size: 16px;">0g</text><rect x="10" y="50" rx="2" ry="2" width="80" height="20" fill="white"></rect><text x="50" y="65" style="font-size: 13px; font-weight: bold;">LOW</text></svg></div></div>
						<div class="separator"></div>
						<div class="viz-content" id="viz_middle" style="padding: 0px 20px 0px 135px; width: 660px;">
						<div class="graph-section-label" style="position: absolute; display: inline-block; left: 20px; top: 20px; width: 100px; font-weight: bold; font-size: 18px;">Colour Thresholds</div>
						<div style="display: inline" class="traffic-light-bar-chart"><svg width="100" height="100"></svg></div><div style="display: inline" class="traffic-light-bar-chart"><svg width="100" height="100"><rect x="38" y="0" width="42" height="33.333333333333336" fill="#ef4044"><g></g></rect><rect x="38" y="33.333333333333336" width="42" height="33.333333333333336" fill="#faa61c"><g></g></rect><rect x="38" y="66.66666666666667" width="42" height="33.333333333333336" fill="#82c55b"><g></g></rect><text text-anchor="end" x="37" y="38.333333333333336" style="font-size: 10px;">17.5g</text><text text-anchor="end" x="37" y="71.66666666666667" style="font-size: 10px;">3g</text><polygon opacity="0.7" fill="black" points="38,96.29629629629629 90,96.29629629629629 100,90.29629629629629 100,102.29629629629629 90,96.29629629629629" style="stroke-width: 1; stroke: black; padding-top: 0px;"></polygon></svg></div><div style="display: inline" class="traffic-light-bar-chart"><svg width="100" height="100"><rect x="38" y="0" width="42" height="33.333333333333336" fill="#ef4044"><g></g></rect><rect x="38" y="33.333333333333336" width="42" height="33.333333333333336" fill="#faa61c"><g></g></rect><rect x="38" y="66.66666666666667" width="42" height="33.333333333333336" fill="#82c55b"><g></g></rect><text text-anchor="end" x="37" y="38.333333333333336" style="font-size: 10px;">5g</text><text text-anchor="end" x="37" y="71.66666666666667" style="font-size: 10px;">1.5g</text><polygon opacity="0.7" fill="black" points="38,99.99999999753086 90,99.99999999753086 100,93.99999999753086 100,105.99999999753086 90,99.99999999753086" style="stroke-width: 1; stroke: black; padding-top: 0px;"></polygon></svg></div><div style="display: inline" class="traffic-light-bar-chart"><svg width="100" height="100"><rect x="38" y="0" width="42" height="33.333333333333336" fill="#ef4044"><g></g></rect><rect x="38" y="33.333333333333336" width="42" height="33.333333333333336" fill="#faa61c"><g></g></rect><rect x="38" y="66.66666666666667" width="42" height="33.333333333333336" fill="#82c55b"><g></g></rect><text text-anchor="end" x="37" y="38.333333333333336" style="font-size: 10px;">22.5g</text><text text-anchor="end" x="37" y="71.66666666666667" style="font-size: 10px;">5g</text><polygon opacity="0.7" fill="black" points="38,70.37037037037037 90,70.37037037037037 100,64.37037037037037 100,76.37037037037037 90,70.37037037037037" style="stroke-width: 1; stroke: black; padding-top: 0px;"></polygon></svg></div><div style="display: inline" class="traffic-light-bar-chart"><svg width="100" height="100"><rect x="38" y="0" width="42" height="33.333333333333336" fill="#ef4044"><g></g></rect><rect x="38" y="33.333333333333336" width="42" height="33.333333333333336" fill="#faa61c"><g></g></rect><rect x="38" y="66.66666666666667" width="42" height="33.333333333333336" fill="#82c55b"><g></g></rect><text text-anchor="end" x="37" y="38.333333333333336" style="font-size: 10px;">1.5g</text><text text-anchor="end" x="37" y="71.66666666666667" style="font-size: 10px;">0.3g</text><polygon opacity="0.7" fill="black" points="38,96.23188405797102 90,96.23188405797102 100,90.23188405797102 100,102.23188405797102 90,96.23188405797102" style="stroke-width: 1; stroke: black; padding-top: 0px;"></polygon></svg></div></div>
						<div class="separator"></div>
						<div class="viz-content" id="viz" style="padding: 0px 20px 20px 135px; width: 660px;">
						<div class="graph-section-label" style="position: absolute; display: inline-block; left: 20px; top: 20px; width: 100px; font-weight: bold; font-size: 18px;">Ingredient Contribution</div>
						<div style="display: inline" class="pie-chart"><svg width="100" height="100"><g transform="translate(50,50)"><g class="arc ing_1792624" fill-opacity="1"><path d="M0,35A35,35 0 1,1 0,-35A35,35 0 1,1 0,35Z" fill="#393b79"></path></g></g></svg></div><div style="display: inline" class="pie-chart"><svg width="100" height="100"><g transform="translate(50,50)"><g class="arc ing_1792624" fill-opacity="1"><path d="M0,35A35,35 0 1,1 0,-35A35,35 0 1,1 0,35Z" fill="#393b79"></path></g></g></svg></div><div style="display: inline" class="pie-chart"><svg width="100" height="100"><g transform="translate(50,50)"><g class="arc ing_1792624" fill-opacity="1"><path d="M0,35A35,35 0 1,1 0,-35A35,35 0 1,1 0,35Z" fill="#393b79"></path></g></g></svg></div><div style="display: inline" class="pie-chart"><svg width="100" height="100"><g transform="translate(50,50)"><g class="arc ing_1792624" fill-opacity="1"><path d="M0,35A35,35 0 1,1 0,-35A35,35 0 1,1 0,35Z" fill="#393b79"></path></g></g></svg></div><div style="display: inline" class="pie-chart"><svg width="100" height="100"><g transform="translate(50,50)"><g class="arc ing_1792624" fill-opacity="1"><path d="M0,35A35,35 0 1,1 0,-35A35,35 0 1,1 0,35Z" fill="#393b79"></path></g></g></svg></div></div>
						</div>
						</div>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="card">
				<div class="pri-header">
					<h3 class="mr-1 mb-0">Ingredients ?
					</h3>
				</div>
				<div class="card-body">
					<ul class="list-unstyled mt-3 mb-4">
						<li class="border-bottom-0 p-1"><label>Change the values below and immediately see the impact on your nutritional values.</label></li>
						<li class="border-bottom-0 curr-ingredient-list">
							<div class="row">
								<div class="col-md-1 p-r-0">
								</div>
								<div class="col-md-3 p-t-10">
									<i class="c-inge fas fa-square-full"></i>
									Peppers, capsicum, chilli, red, raw
								</div>
								<div class="col-md-2 p-r-0 p-t-5">
									<div class="form-group">
										<input type="number" class="form-control" name="example-text-input" placeholder="0.00">
									</div>
								</div>
								
							</div>
						</li>
						<li class="border-bottom-0 curr-ingredient-list">
							<div class="row">
								<div class="col-md-1 p-r-0">
								</div>
								<div class="col-md-3 p-t-10">
									<i class="c-inge fas fa-square-full"></i>
									Peppers, capsicum, chilli, red, raw
								</div>
								<div class="col-md-2 p-r-0 p-t-5">
									<div class="form-group">
										<input type="number" class="form-control" name="example-text-input" placeholder="0.00">
									</div>
								</div>
								
							</div>
						</li>
						<li class="border-bottom-0 curr-ingredient-list">
							<div class="row">
								<div class="col-md-1 p-r-0">
								</div>
								<div class="col-md-3 p-t-10">
									<i class="c-inge fas fa-square-full"></i>
									Peppers, capsicum, chilli, red, raw
								</div>
								<div class="col-md-2 p-r-0 p-t-5">
									<div class="form-group">
										<input type="number" class="form-control" name="example-text-input" placeholder="0.00">
									</div>
								</div>
								
							</div>
						</li>
					  	
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="card">
				<div class="pri-header">
					<h3 class="mr-1 mb-0">Goals ?
					</h3>
				</div>
				<div class="card-body">
					<ul class="list-unstyled mt-3 mb-4">
						<li class="border-bottom-0 p-1"><label>Define a new target and our optimisation algorithm will help you to achieve it.</label></li>
						<li class="border-bottom-0 curr-ingredient-list">
							<div class="row">
								<div class="col-md-3 fg-line p-t-4">
									<select id="new_target_form_nutrient" class="form-control input-sm"><option value="Energ_Kcal">Energy in kcal</option><option value="Lipid_Tot">Fat in g</option><option value="FA_Sat">Saturates in g</option><option value="Sugar_Tot">Sugar in g</option><option value="Salt">Salt in g</option></select>
								</div>
								<div class="col-md-3 fg-line p-t-4">
									<select id="new_target_form_op" class="form-control input-sm"><option value="less than">less than</option><option value="more than">more than</option><option value="equal to">equal to</option></select>
								</div>
								<div class="col-lg-3 fg-line p-t-10"><input id="new_target_form_val" min="0" class="form-control input-sm"></div>
								<div class="col-lg-3 fg-line p-t-10"><input type="submit" value="Add goal" class="btn btn-sm btn-default"></div>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
		
	</div>
	<div class="row">
		
		
	</div>
</div>

	
<?php
require_once('footer.php');
?>
<script src="<?=base_url();?>assets/js/custom/Reciepe.js"></script>

<script type="text/javascript">
	Reciepe.init();
	$('.recipe-tabs').find('.optimization .card-body').addClass('active');
</script>