<?php
require_once('header.php');
require_once('sidebar.php');
if($create_type=="barmenu")
	require_once('bar_menu.php'); 
else
	require_once('masterrecipe_header.php');

?>
<link rel="stylesheet" href="<?=base_url();?>assets/plugins/resize/jquery.Jcrop.min.css" type="text/css" />
<script src="<?=base_url();?>assets/plugins/resize/jquery.min.js"></script>
<script src="<?=base_url();?>assets/plugins/resize/jquery.Jcrop.min.js"></script>
<style type="text/css">
.widget-user-image canvas{
	max-width: 100%;
	border: 3px solid #fff;
	border-radius: 50% !important;
	background: #fff;
}
.jcrop-holder{
	max-width: 100% !important;
}

.jcrop-holder img:last-child{
	max-width: 100% !important;
}
</style>
		
</div>
<div class="modal fade" id="modal-imagepreview" tabindex="-1" role="dialog"  aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="float: right;position: absolute;right: 3px;font-size: 22px;top: -7px;">
				<span aria-hidden="true">&times;</span>
			</button>
			<form method="post" action="javascript:;">
				<img id="cropbox" class="img" style="width: 100% !important;"/><br />
				<button type="button" class="btn btn-success" id="crop" value='CROP' style="float: right;margin-bottom: 10px;margin-right: 10px;">Crop</button>
			</form>
		</div>
	</div>
</div>
<?php
require_once('footer.php');
?>
<script src="<?=base_url();?>assets/js/custom/Masterreciepe.js?v=2"></script>
<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/8.0.1/firebase-app.js"></script>
<!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->
<script src="https://www.gstatic.com/firebasejs/8.0.1/firebase-analytics.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.0.1/firebase-firestore.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.0.1/firebase-storage.js"></script>
<script>
  var firebaseConfig = {
    apiKey: "AIzaSyBaiMvyHa8pPoc579ZWknlbhUT98V2UpGs",
    authDomain: "foodnai-cda81.firebaseapp.com",
    databaseURL: "https://foodnai-cda81.firebaseio.com",
    projectId: "foodnai-cda81",
    storageBucket: "foodnai-cda81.appspot.com",
    messagingSenderId: "1081243293714",
    appId: "1:1081243293714:web:b1f5f2f00fe7c085dd60cb",
    measurementId: "G-NFD06ZFEDF"
  };
  firebase.initializeApp(firebaseConfig);
  firebase.analytics();
</script>
<script type="text/javascript">
	 $(document).ready(function($) {
	 	
		function randomStr(len, arr) { 
            var ans = ''; 
            for (var i = len; i > 0; i--) { 
                ans +=  
                  arr[Math.floor(Math.random() * arr.length)]; 
            } 
            return ans; 
        } 
	});

</script>
<script type="text/javascript">
	
	Masterreciepe.base_url="<?=base_url();?>";
	Masterreciepe.recipe_id="<?=$recipe_id;?>";
	Masterreciepe.alacalc_recipe_id="<?=$recipe['alacal_recipe_id'];?>";
	Masterreciepe.is_alacalc_recipe="<?=$_SESSION['is_alacalc_recipe'];?>";
	Masterreciepe.is_category_prices="<?=$_SESSION['is_category_prices'];?>";
	Masterreciepe.create_type="<?=$create_type;?>";
	Masterreciepe.is_nutrition=0;
	Masterreciepe.init();
	$('.recipe-tabs').find('.receipes .card-body').addClass('active');
	var from_page="<?php if(isset($_GET['from'])) echo $_GET['from']; else echo '';?>";
	if(from_page=="addrecipe"){
		$('#in-recipe-name').trigger('click');
	}

</script>
