<div id="sidebar"> <a href="#" class="visible-phone"><i class="icon icon-list"></i>Forms</a>
  <ul>
  <?php
  if($highlight == "addschool"){
	  ?>
    <li class="active"> <a href="add-school.php"><i class="icon icon-signal"></i> <span>Add Restaurant</span></a> </li>
	<li><a href="email-send.php"><i class="icon icon-inbox"></i> <span>Scheduled Email</span></a> </li>
	<li><a href="add-template.php"><i class="icon icon-th"></i> <span>Add Template</span></a></li>
	<?php
  }
  else if($highlight == "email"){
	?>
    <li> <a href="add-school.php"><i class="icon icon-signal"></i> <span>Add Restaurant</span></a> </li>
	<li class="active"><a href="email-send.php"><i class="icon icon-inbox"></i> <span>Scheduled Email</span></a> </li>
	<li><a href="add-template.php"><i class="icon icon-th"></i> <span>Add Template</span></a></li>
	<?php
  }
  else{
	?>
    <li> <a href="add-school.php"><i class="icon icon-signal"></i> <span>Add Restaurant</span></a> </li>
	<li><a href="email-send.php"><i class="icon icon-inbox"></i> <span>Scheduled Email</span></a> </li>
	<li class="active"><a href="add-template.php"><i class="icon icon-th"></i> <span>Add Template</span></a></li>
	<?php
  }
	?>
  </ul>
</div>