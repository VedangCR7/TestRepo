<?php
//ini_set("display_errors",1);
//ini_set(ERROR_REPORTING,E_ALL);
session_start();
    if(!isset($_SESSION["login"])) {
        header('LOCATION:index.php'); die();
    }

require 'Template.php';
 require_once 'includes/header.php';
?>
<body>

<!--Header-part-->
<div id="header">
  <h1><a href="dashboard.html">Rsl Admin</a></h1>
</div>
<!--close-Header-part--> 

<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse">
  <ul class="nav">
    <li class=""><a title="" href="logout.php"><i class="icon icon-share-alt"></i> <span class="text">Logout</span></a></li>
  </ul>
</div>

<!--start-top-serch-->
<!--div id="search">
  <input type="text" placeholder="Search here..."/>
  <button type="submit" class="tip-bottom" title="Search"><i class="icon-search icon-white"></i></button>
</div-->
<!--close-top-serch--> 

<!--sidebar-menu-->

<?php
$highlight="addtemplate";
 require_once 'includes/sidebar.php';
 ?>

<!--close-left-menu-stats-sidebar-->

<div id="content">
<div id="content-header">
  <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="tip-bottom">Form elements</a> <a href="#" class="current">Common elements</a> </div>
  <h1>Add Template</h1>
</div>
<div class="container-fluid">
  <hr>
  <div class="row-fluid">
    <div class="span12">
      <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>Add Template Form</h5>
        </div>
        <div class="widget-content nopadding">
          <form action="" method="POST" class="form-horizontal" enctype="multipart/form-data" id="addTemplate">
            <div class="control-group">
              <label class="control-label">Template Name :</label>
              <div class="controls">
                <input type="text" class="span11" placeholder="Template name" id="tname" name="tname"/>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Template Image :</label>
              <div class="controls">
                <input type="file" class="span11" name="fileToUpload" id="fileToUpload" />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Template File Name</label>
              <div class="controls">
                <input type="text"  class="span11" placeholder="Template File Name"  id="tfile" name="tfile" />
              </div>
            </div>
            <div class="form-actions">
		
              <button type="submit" class="btn btn-success" name="submit" onclick="validation();">Add</button>
            </div>
          </form>
        </div>
      </div>
	  
	  
	          <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>All Templates</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>Template Name</th>
				  <th>Template Image</th>
                  <th>Template File Name</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
			  <?php 
					$c=new Template;
					$list=array();
					$list=$c->displayTemplate();
					
					foreach($list as $key=>$row)
					{
						
					?>					
                <tr class="gradeX">
                  <td><?php echo $row['t_name'];?></td>
                  <td><img src="TemplateImages/<?php echo $row['t_img'];?>"  /></td>
                  <td><?php echo $row['t_file'];?></td>
				  <td><button type="button" class="btn btn-success"  onclick="deleteTemp('<?php echo $row['t_id'];?>');">Delete</button></td>
                </tr>
				<?php
					}
				?>
                             </tbody>
            </table>
          </div>
        </div>

    </div>
  </div>
</div></div>
<!--Footer-part-->

<div id="modal-msg" class="modal hide">
              <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>Alert modal</h3>
              </div>
              <div class="modal-body">
                
              </div>
              <div class="modal-footer"><a data-dismiss="modal" class="btn btn-inverse btn-close">Ok</a> </div>
            </div>
<!--end-Footer-part--> 


<script src="js/jquery.min.js"></script> 
<script src="js/jquery.ui.custom.js"></script> 
<script src="js/bootstrap.min.js"></script> 
<script src="js/bootstrap-colorpicker.js"></script> 
<script src="js/bootstrap-datepicker.js"></script> 
<script src="js/jquery.toggle.buttons.js"></script> 
<script src="js/masked.js"></script> 
<script src="js/jquery.uniform.js"></script> 
<script src="js/select2.min.js"></script> 
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/matrix.tables.js"></script>
<script src="js/matrix.js"></script> 
<script src="js/matrix.form_common.js"></script> 
<script src="js/wysihtml5-0.3.0.js"></script> 
<script src="js/jquery.peity.min.js"></script> 
<script src="js/bootstrap-wysihtml5.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script>
	$('.textarea_editor').wysihtml5();
</script>
<script>
		
		function validation()
		{
			console.log("hiii");
		 	$("#addTemplate").validate({
				rules:{
					tname : "required",
					fileToUpload : "required",
					tfile : "required"	
				},
				messages:{
						tname : "Please Enter Template Name",
						fileToUpload : "Please Select Template Image",
						tfile : "Please Enter Template File Name"
						
				},
				submitHandler : submitForm

			});	 
			function submitForm(){
					//var formdata = $("#addTemplate").serialize();
					  // formdata.append('file', $('#fileToUpload')[0].files[0]);
					    var formData = new FormData($('#addTemplate')[0]);
                    console.log("data "+formData );
 
					$.ajax({
						type : 'POST',
						url : 'add-template1.php',
						processData: false,
						enctype: 'multipart/form-data',
						contentType: false,
						data : formData,
						success : function(response)
						{
								console.log("res"+response);
								if(response.search("ok")>-1)
								{
									$("#modal-msg").find(".modal-body").html("<p class='text-center'>Template Added Successfully</p>");
									$("#modal-msg").modal();
									$("#modal-msg").find(".btn-close").on('click' , function()
										{
											window.location.href="add-template.php";
										});
									}
						}
    });
}
		}
			
		
	function deleteTemp(id)
	{
		//console.log("hii");
		var tid=id;
		
		
		$.ajax({
						type : 'POST',
						url : 'delete-template.php',
						data : {"tid":tid},
						success : function(response)
						{
								//console.log("res"+response);
								if(response.search("ok")>-1)
								{
									$("#modal-msg").find(".modal-body").html("<p class='text-center'>Template Deleted Successfully</p>");
									$("#modal-msg").modal();
									$("#modal-msg").find(".btn-close").on('click' , function()
										{
											window.location.href="add-template.php";
										});
									}
						}
    });
	}
	</script>

</body>
</html>
