<?php
	require_once('connection.php');
	
	$recipe_id=$_POST['recipeid'];
	$qry = "SELECT * FROM `recipe_nutritient` WHERE recipe_id=$recipe_id";
	$res = mysqli_query($con,$qry);
	$cnt = mysqli_num_rows($res);
	if($cnt > 0)
	{
		while($rw = mysqli_fetch_assoc($res))
		{
			/* echo $nutri_name = $rw['name']."</t></t>";
			echo $value = $rw['value'];
			echo $unit = $rw['unit']."<br>"; */
			
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
	}

?>