<html>
	<head>
	<meta content="Powerful FoodNAI platform provide users nutrition and allergen information of their favorite food. Restaurant will be able to provide a detailed analysis of each ingredient on the menu making and experience everyone can enjoy food safely" name="description">

<meta content="Nutrition analysis website, allergen analysis website, restaurant food nutrition analysis,  food nutrition analysis, nutrition food, recipe nutrition calculator, analyzed my food, nutrition tools, food analysis report." name="keyword">
		<style>
			.menu-height{
				height:171px;
			}
		</style>

	<link rel="stylesheet" href="css/responsive.css">
	</head>
</html>




<?php
	require_once('connection.php');
	
	$recordsPerPage=10;
	$groupid=$_POST['mid'];
	$restoid=$_POST['restid'];
	$page=$_POST['page'];
	if(isset($groupid) && $groupid!='')
	{
		$qAllRecords="SELECT * FROM `recipes` WHERE `group_id` = $groupid AND `logged_user_id`='$restoid'";
		$mAllRecords=mysqli_query($con,$qAllRecords);
		$totalRecords=mysqli_num_rows($mAllRecords);

		$q="SELECT * FROM `recipes` WHERE `group_id` = $groupid AND `logged_user_id`='$restoid' limit ".($page-1)*$recordsPerPage." , ".$recordsPerPage;
		$m=mysqli_query($con,$q);/* var_dump($m); */
		$r=mysqli_num_rows($m);
		if($r > 0)
		{
			?>
		
		<div class="all-menu-details menu-with-2grid thumb">
		<h5 id="menu-title"><?php echo ucfirst($rw1['title']); ?></h5>
		<div class="row" id="menu-content">
		<?php	
						
			$i=0;
			while($row = mysqli_fetch_assoc($m))
			{
			
				if($i==0){
					echo "<div class='col-md-6'>";
				}
				if($i==round($r/2)){
					echo "</div><div class='col-md-6'>";
				}
				if($i==$r){
					echo "</div>";
				}
				$recipe_id = $row['id'];
				$qry1 = "select im.*,i.long_desc,i.declaration_name,i.data_source from ingredient_items im inner JOIN ingredient i on i.alacalc_id=im.ingredient_id WHERE im.recipe_id='$recipe_id'";
				$res1 = mysqli_query($con,$qry1);
				if(mysqli_num_rows($res1) > 0)
				{
					$ingredients = array();
					while($rw1 = mysqli_fetch_assoc($res1))
					{
						$ingredients[] = ucfirst($rw1['declaration_name']);
					}
					$ingredientsList = implode(', ', $ingredients);
				}
				/* else{ $ingredientsList = 'Ingredients not found.'; } */
?>
		<div class="row">
		  <div class="col-lg-12">
			<div class="menus d-flex ftco-animate menu-height">
			  <div class="menu-img" style="background-image: url(<?php echo $image_path.$row['recipe_image']; ?>);"></div>
			  <div class="text d-flex">
				<div class="one-half">
				  <h3>
					<?php 
						$dishnm = strtolower($row['name']);
						echo ucwords($dishnm); 
					?>
				  </h3>
					<p><span><?php echo $ingredientsList; ?></span></p>
					<p><span>
						<?php 
							if($row['best_time_to_eat'] !='') { 
								$best_time_to_eat = $row['best_time_to_eat'];
								
								if($best_time_to_eat == 'none'){
									$best_time_to_eat = '';
								}
								
								$besttime_arr = explode(",",$best_time_to_eat);
								$pos = array_search('all', $besttime_arr);/* echo 'Linus Trovalds found at: ' . $pos; */
								unset($besttime_arr[$pos]);
								$best_time_to_eat = implode(", ",$besttime_arr);
								
								if($best_time_to_eat != ''){
						?>
						<b>Best Time To Eat : </b>
							<?php echo ucwords($best_time_to_eat); }}x ?>
					</span></p>
					<input type="hidden" id="gross_weight_<?php echo $row['alacal_recipe_id'];?>" value="<?php echo $row['total_weight']; ?>">
					
				</div>
				<div class="one-forth">
				  <span class="price">
					<?php 
						$menuPrice = $row['price'];
						if(($menuPrice == 'Recipe Price') || ($menuPrice == '')) 
						{ echo '0.00'; }
						else{ echo $menuPrice; }
					?>
				  </span>
				  <p>
				     <span>
						<?php 
							$menuType = $row['recipe_type'];
							if($menuType == '') { ?> 
						<img src="images/NonVeg.png" alt="">
						<?php	}else if($menuType == 'veg'){ ?>
						<img src="images/Veg.png" alt="Veg menu">
						<?php	}else if($menuType == 'nonveg'){ ?>
						<img src="images/NonVeg.png" alt="Nonveg menu">
						<?php }else if($menuType == 'none'){ ?>
						<img src="images/None.png" alt="None menu">
						<?php } ?>
				     </span>
				  </p>
				  <?php if($ingredientsList != '-'){ ?>
				  <div class="form-group">
                    <!--<input type="submit" value="Nutrition" class="open-homeEvents btn btn-primary" data-id=<?php echo $row['id'];?> onclick="menuclick('<?php echo $row['id'];?>','<?php echo $row['alacal_recipe_id'];?>')" >-->
                    <input type="button" value="Nutrition" class="open-homeEvents btn btn-primary" data-id=<?php echo $row['id'];?> onclick="get_allergen_nutrition_info('<?php echo $row['id'];?>','<?php echo $row['alacal_recipe_id'];?>','<?php echo $groupid;?>')" >
                  </div>
				  <?php } ?>
				  
				</div>
			  </div>
			</div>
			
		  </div> 
		</div>

	<?php $i++;}?>
	</div> 
	</div> 

	<!--end all-menu-details-->
	<div class="pagination" style="float: right;">
		<ul class="list-inline text-right" style="display: inline-flex;">
		<?php 
		 $totalPages=$totalRecords/$recordsPerPage;
		for($p=0;$p<$totalPages;$p++){?>
			<li class="<?php if($page==$p+1) echo 'activepage';?> "><a href="javascript:nextRecord('<?php echo $p+1;?>','<?php echo $restoid; ?>');"><?php echo $p+1;?></a>
			</li>
		<?php }?>
		</ul>
	</div>
	<!-- end .pagination -->
	<?php
	}else{?>
		<div class="col-md-12" id="tab-2">
			<p>
				<center><h4>Menu item not found</h4></center>
			</p>
		</div>
	<?php }
	}else{?>
		<div class="col-md-12" id="tab-2">
			<p>
				<strong>Menu item not found</strong>
				
			</p>
		</div>
	<?php
	}?>