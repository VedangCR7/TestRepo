<?php
require_once('header.php');
require_once('sidebar.php');
?>
<div class=" app-content">
	<div class="side-app">

		<!--Page Header-->
		<div class="page-header">
			<h3 class="page-title"><i class="fe fe-home mr-1"></i> Dashboard </h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Dashboard </li>
			</ol>
		</div>
		<!--Page Header-->
		<div class="row">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-6  col-xl-3 features">
						<div class="card feature">
							<div class="card-body text-center pad-1rem" >
								<div class="col-md-7">
									<h5 class="mt-2 lh-one">Total number of Menus</h5>
								</div>
								<div class="col-md-5">
									<p class="gray">Count</p>
									<h2 class="counter num-font"><?=$recipes_count;?></h2>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6  col-xl-3 features">
						<div class="card feature">
							<div class="card-body text-center pad-1rem">
								<div class="col-md-7">
									<!--<h5 class="mt-2 lh-one">Visit to recipes by users</h5>-->
									<h5 class="mt-2 lh-one" style="margin-top: 0px!important;">Visited Users</h5>
								</div>
								<div class="col-md-5">
									<p class="gray">Count</p>
								</div>
								<div class="col-md-7">
									<h6 class="mt-2 lh-one" style="margin-top: 0px!important;">Total Users</h6>
								</div>
								<div class="col-md-5">
									<h3 class="counter num-font" style="margin-top: 0px!important;"><?=$ttlvisited_users_count;?></h3>
								</div>
								<div class="col-md-7">
									<h6 class="mt-2 lh-one" style="margin-top: 0px!important;">Daily Users</h6>
								</div>
								<div class="col-md-5">
									<h3 class="counter num-font" style="margin-top: 0px!important;"><?php if($visited_users_count == ''){echo '0';}else{echo $visited_users_count;};?></h3>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6  col-xl-3 features">
						<div class="card feature">
							<div class="card-body text-center pad-1rem">
								<div class="col-md-7">
									<!--<h5 class="mt-2 lh-one">Visit to recipes by users</h5>-->
									<h5 class="mt-2 lh-one" style="margin-top: 0px!important;">Visited Menus</h5>
								</div>
								<div class="col-md-5">
									<p class="gray">Count</p>
								</div>
								<div class="col-md-7">
									<h6 class="mt-2 lh-one" style="margin-top: 0px!important;">Total Menus</h6>
								</div>
								<div class="col-md-5">
									<h3 class="counter num-font" style="margin-top: 0px!important;"><?=$ttlvisited_recipes_count;?></h3>
								</div>
								<div class="col-md-7">
									<h6 class="mt-2 lh-one" style="margin-top: 0px!important;">Daily Menus</h6>
								</div>
								<div class="col-md-5">
									<h3 class="counter num-font" style="margin-top: 0px!important;"><?php if($visited_recipes_count == ''){echo '0';} else{echo $visited_recipes_count;} ?></h3>
								</div>
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
		<div class="row" style="min-height: 300px;">
			<div class="col-xl-6 col-lg-12">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title text-center width-100">Recently added Menus</h3>
					<!-- 	<div class="card-options ">
							<span class="dropdown-toggle fs-16" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"><i class="fe fe-more-vertical " ></i></span>
							<ul class="dropdown-menu dropdown-menu-right" role="menu">
								<li><a href="<?=base_url();?>recipes/create"><i class="si si-plus mr-2"></i>Add</a></li>
								<li><a href="<?=base_url();?>recipes/overview"><i class="si si-eye mr-2"></i>See More</a></li>
							
							</ul>
						</div> -->
					</div>
					<div class="">
						<?php
							$i=1;
						
							foreach ($recently_added as $added) {
						?>
							<div class="list d-flex align-items-center border-bottom p-3">
								<div class="wrapper w-100 ml-3">
									<p class="mb-0 d-flex">
										<a class="black" href="<?=base_url();?>recipes/create/<?=$added['id'];?>"><b><?=$added['name'];?></b></a>
										<small class="black ml-auto"><?=date('dS F Y',strtotime($added['recipe_date']));?></small>
									</p>
								</div>
							</div>
						<?php
								if($i>=5)
									break;
								$i++;
							}
							if(!empty($recently_added)){
						?>
						
						<div class="list d-flex align-items-center border-bottom p-3">
							<div class="wrapper w-100 ml-3 text-center">
								<?php if (!empty($restaurantsidebarshow[0]['menu_name'])) {
									$existmenu = explode(',' , $restaurantsidebarshow[0]['menu_name']);
									//print_r($existmenu);
									if (in_array('Menu', $existmenu)) { ?>
									<p class="mb-0 d-flex" style="justify-content: center;">
										<b><a class="btn btn-primary"  href="<?=base_url();?>recipes/overview" style="padding: 3px 23px;font-size: 12px;line-height: 1rem;">See More </a></b>
									</p>
								<?php } } else {?>
									<p class="mb-0 d-flex" style="justify-content: center;">
										<b><a class="btn btn-primary"  href="<?=base_url();?>recipes/overview" style="padding: 3px 23px;font-size: 12px;line-height: 1rem;">See More </a></b>
									</p>
								<?php } ?>
							</div>
						</div>
						<?php

							}else{
							?>
							<div class="list d-flex align-items-center border-bottom p-3">
								<div class="wrapper w-100 ml-3 text-center">
									<p class="mb-0 d-flex" style="justify-content: center;">
										Menu not available
									</p>
								</div>
							</div>
							<?php
							}
						?>
					</div>
				</div>
			</div>
			
			<div class="col-xl-6 col-lg-12">
				
				<div class="card">
					<div class="card-header">
						<h3 class="card-title text-center width-100">Top 5 Most Visited Menus</h3>
					</div>
					<div class="">
						<?php
							$i=1;
							foreach ($visited_recipes as $added) {
						?>
							<div class="list d-flex align-items-center border-bottom p-3">
								<div class="wrapper w-100 ml-3">
									<p class="mb-0 d-flex">
										<a class="black" href="<?=base_url();?>recipes/create/<?=$added['id'];?>"><b><?=$added['name'];?></b></a>
										<small class="black ml-auto"><?=date('dS F Y',strtotime($added['recipe_date']));?></small>
									</p>
								</div>
							</div>
						<?php
								if($i>=5)
									break;
								$i++;
							}
							if(empty($visited_recipes)){
						?>
						
						<div class="list d-flex align-items-center border-bottom p-3">
							<div class="wrapper w-100 ml-3 text-center">
								<p class="mb-0 d-flex" style="justify-content: center;">
									Menu not available
								</p>
							</div>
						</div>
						<?php

							}
						?>
						
					</div>
				</div>
			</div>
		</div>
		
	</div>

	
	<?php
require_once('footer.php');
?>