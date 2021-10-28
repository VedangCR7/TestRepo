<?php
	require_once('connection.php');
	
	$recipe_id=$_POST['recipeid'];
	$group_id=$_POST['groupid'];
	
	$today = date("Y-m-d");
	
	$q="SELECT a.id as aid, a.title, ra.* FROM `recipe_allergens` ra, allergens a WHERE ra.allergens_id=a.id AND ra.`recipe_id` = $recipe_id";
	$m=mysqli_query($con,$q);
	$r=mysqli_num_rows($m);
	if($r > 0)
	{
		$allergens_title = array();
		echo "<ul>";
		while($row1 = mysqli_fetch_assoc($m))
		{
?>
			<li><b style="font-weight: 700;">
<?php
			echo $allergens_title = $row1['title'];
?>
</b></li>
<?php
		}
		echo "</ul>";
	}else{
		echo "---";
	}
	
	/* $qry = "SELECT * FROM `recipe_nutritient` WHERE recipe_id=$recipe_id";
	$res = mysqli_query($con,$qry);
	$cnt = mysqli_num_rows($res);
	if($cnt > 0)
	{
		while($rw = mysqli_fetch_assoc($res))
		{
			
			?><div class="nutrient_selection_header" id="common_nutrient_header" style="display: block;">Main</div>
            <div class="common row" data-energ_kj="true" data-category="common" id="Energ_KJ" style="display:block">
                <div class="col-md-5 nutrient_name"><?php echo $nutri_name = $rw['name']; ?></div>
                <div class="col-md-3 trace per_100">
                    <div class="col-md-6 p-0 text-right nutrient_value per_100"><?php echo $value = $rw['value']; ?></div>
                    <div class="col-md-6 p-0 nutrient_measure"><?php echo $unit = $rw['unit']; ?></div>
                </div>
                <div class="col-md-4 trace per_portion">
                    <div class="col-md-6 p-0 text-right nutrient_value per_portion"><?php $v = $rw['value'];echo round($v *4); ?></div>
                    <div class="col-md-6 p-0 nutrient_measure"><?php echo $unit = $rw['unit']; ?></div>
                </div>
            </div>
            <?php
			
		}
	}else{
		echo "---";
	} */
?>

<?php
	$qry="SELECT * FROM `get_recipe_count` WHERE `recipe_id` = $recipe_id AND `group_id` = $group_id AND `visited_at`='$today'";
	$mres=mysqli_query($con,$qry);
	$rcnt=mysqli_num_rows($mres);
	if($rcnt > 0)
	{
		$wrrow = mysqli_fetch_assoc($mres);
		$no_of_visits = $wrrow['no_of_visits'];
		
		$newVisitCnt = $no_of_visits +1;
		
		$updateQry = "UPDATE `get_recipe_count` SET `no_of_visits`= $newVisitCnt WHERE `recipe_id` = $recipe_id AND `group_id` = $group_id AND `visited_at`='$today'";
		$updateRes = mysqli_query($con, $updateQry);
	}else{
		$insertQry = "INSERT INTO `get_recipe_count`(`no_of_visits`, `recipe_id`, `group_id`, `visited_at`) VALUES ('1','$recipe_id','$group_id','$today')";
		$insertRes = mysqli_query($con, $insertQry);
	}
?>