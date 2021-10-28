<?php
	require_once('connection.php');
	$recordsPerPage=10;
	$groupid=$_POST['mid'];
	$page=$_POST['page'];
	if(isset($groupid) && $groupid!='')
	{
		$qAllRecords="SELECT * FROM `recipes` WHERE `group_id` = $groupid AND `logged_user_id`='$resto_id'";
		$mAllRecords=mysqli_query($con,$qAllRecords);
		$totalRecords=mysqli_num_rows($mAllRecords);

		$q="SELECT * FROM `recipes` WHERE `group_id` = $groupid AND `logged_user_id`='$resto_id' limit ".($page-1)*$recordsPerPage." , ".$recordsPerPage;
		$m=mysqli_query($con,$q);
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
				if($i==$r/2){
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
						$ingredients[] = $rw1['declaration_name'];
					}
					$ingredientsList = implode(', ', $ingredients);
				}
				else{ $ingredientsList = 'Ingredients not found.'; }
?>
		<div class="row">
		  <div class="col-lg-12">
			<div class="menus d-flex ftco-animate" onclick="menuclick('<?php echo $row['id'];?>','<?php echo $row['alacal_recipe_id'];?>')" style="height: 155px;">
			  <div class="menu-img" style="background-image: url(<?php echo $image_path.$row['recipe_image']; ?>);"></div>
			  <div class="text d-flex">
				<div class="one-half">
				  <h3><?php echo $row['name']; ?></h3>
					<p><span><?php echo $ingredientsList; ?></span></p>
					
					
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
				  <p><span>
						<?php 
							$menuType = $row['recipe_type'];
							if($menuType == '') { ?> 
						<img src="images/NonVeg.png" alt="">
						<?php	}else if($menuType == 'veg'){ ?>
						<img src="images/Veg.png" alt="Veg menu">
						<?php	}else if($menuType == 'nonveg'){ ?>
						<img src="images/NonVeg.png" alt="Nonveg menu">
						<?php } ?>
				  </span></p>
				</div>
			  </div>
			</div>
			
		  </div> 
		</div>

	<?php $i++;}?>
	</div> 
	</div> 

	<!--end all-menu-details-->
	<div class="pagination">
		<ul class="list-inline  text-right">
		<?php 
		 $totalPages=$totalRecords/$recordsPerPage;
		for($p=0;$p<$totalPages;$p++){?>
			<li class="<?php if($page==$p+1) echo 'active';?> "><a href="javascript:nextRecord('<?php echo $p+1;?>');"><?php echo $p+1;?></a>
			</li>
		<?php }?>
			
		</ul>
	</div>
	<!-- end .pagination -->
	<?php
	}else{?>
		<div class="col-md-12" id="tab-2">
			<p>
				<strong>Menu item not found</strong>
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
	<script>
		function enterEmail()
		{
			
		}
	</script>
	