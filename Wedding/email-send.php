<?php
//ini_set("display_errors",1);
//ini_set(ERROR_REPORTING,E_ALL);
session_start();
    if(!isset($_SESSION["login"])) {
        header('LOCATION:index.php'); die();
    }

require_once 'Country.php';
 require_once 'includes/header.php';
?>

<style>
.tempImage{
	border:2px solid #ccc;
	padding: 0px;
    margin: 15px;
    border-radius: 10px;
}
.selected{
		border:2px solid #7b7bd8!important;
}

.pointerShow:hover{
 cursor: pointer;
}
</style>

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
$highlight="email";
 require_once 'includes/sidebar.php';
 ?>

<!--close-left-menu-stats-sidebar-->

<div id="content">
<div id="content-header">
  <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="tip-bottom">Form elements</a> <a href="#" class="current">Common elements</a> </div>
  <h1>Send Email</h1>
</div>
<div class="container-fluid">
  <hr>
  <div class="row-fluid">
    <div class="span12">
      <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>Sending Email</h5>
        </div>
        <div class="widget-content nopadding">
          <form action="" method="POST" class="form-horizontal"  id="sendEmail">
            <div class="control-group">
              <label class="control-label">Select Country :</label>
              <select class="controls" name="country" id="country" onchange="schoollist()">
				<option value="0">-Select Country-</option>
			  <?php
			  $obj=new Country;
			  $list=$obj->displayCountry();
			  foreach($list as $key=>$row){
			  ?>
               <option value="<?php echo $row['c_id'];?>"><?php echo $row['c_name'];?></option>
              <?php
			  }
			  ?>
			  </select>
			  
            </div>
			
			<div class="control-group">
              <label class="control-label">Website :</label>
              <select class="controls" name="web" id="web" onchange="schoollist()">
				<option value="all">All</option>
				<option value="wb">With Website</option>
				<option value="wbn">Without Website</option>
					
			  </select>
			  
            </div>
			
			<div class="span10" id="dataschool" >
			
			</div>
			
			
			
			
			
              <div class="control-group">
              <label class="control-label">Select Template :</label>
            </div>
			<div class="span12">
			<?php
			$img=$obj->displayTemplate();
			foreach($img as $key=>$row1){
			?>
			<div class="span4 pointerShow" id="imgg_<?php echo $row1['t_id'];?>" >
			<img src="TemplateImages/<?php echo $row1['t_img']; ?>" onclick="selectTemplate('<?php echo $row1['t_id']; ?>');" id="<?php echo $row1['t_id']; ?>" class="tempImage" data-id="<?php echo $row1['t_id']; ?>" alt="" />
			</div>
			<?php 
			}
			?>
			</div>
            <div class="form-actions">
		
              <button type="button" class="btn btn-success" name="submit" onclick="sendemail()">Send</button>
            </div>
          </form>
        </div>
      </div>
	  
	  
	          

    </div>
  </div>
</div></div>
<!--Footer-part-->

<div id="singleSchool" class="modal hide">
              <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>Sending Mail</h3>
              </div>
              <div class="modal-body">
			   <div class="span4">
              <div class="widget-box">
			  <div class="widget-content nopadding">
                <form action="" method="POST" class="form-horizontal" id="schemail" >
								<div class="span6">
								<div class="control-group">
									<label class="control-label">Subject :</label>
									<div class="controls">
										<input type="text" class="span11" placeholder="Subject" id="sub" name="sub"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Message :</label>
									<div class="controls">
										<textarea class="span11" rows="5" id="msg" name="msg"></textarea>
									</div>
								</div>
								</div>
								
            <div class="form-actions">
			<input type="hidden" id="id" name="id" value="">
             <button type="button" class="btn btn-success" style="float:left;" onclick="send()">Send</button>
			 
			 <div style="float:right;"><a data-dismiss="modal" class="btn btn-success btn-close">Cancel</a> </div>
            </div>
          </form>
           </div> 
			</div>
			</div>
                
              </div>
              <div class="modal-footer"><a data-dismiss="modal" class="btn btn-inverse btn-close">Ok</a> </div>
            </div>

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


	function chkCheckbox(){
	$("#checkedAll").change(function() {
        if (this.checked) {
            $(".checkSingle").each(function() {
                this.checked=true;
            });
        } else {
            $(".checkSingle").each(function() {
                this.checked=false;
            });
        }
    });
	$(".checkSingle").click(function () {
        if ($(this).is(":checked")) {
            var isAllChecked = 0;

            $(".checkSingle").each(function() {
                if (!this.checked)
                    isAllChecked = 1;
            });

            if (isAllChecked == 0) {
                $("#checkedAll").prop("checked", true);
            }     
        }
        else {
            $("#checkedAll").prop("checked", false);
        }
    });
	}
	
	
	function schoollist()
	{
		//console.log("Hii");
		//var cid=document.getElementById("country").value;
		var cid=$("#country").val();
		//alert(cid);
		//console.log("cid--"+cid);
		var sel=$("#web").val();
		//console.log("selection val--"+sel);
		var html1="";
		if(cid!=0 && sel!=""){
		
		$.ajax({
			type : 'POST',
			url : 'get-slist.php',
			data : {"cid":cid, "sel":sel},
			success : function(data)
			{
				 //alert(data);  
				 var response=JSON.parse(data);
				 //alert(response.length);
			  /* for (index = 0; index < response.length; ++index)
					  {		
							alert(response[index]);
					  }*/
				 /* for(var k in response)
				 {	
					alert(k);
				} */
				if(response!=null){
				 html1+="<div class='widget-box'>";
				  html1+="<div class='widget-title'> <span class='icon'><i class='icon-th'></i></span>";
					html1+="<h5>School List</h5>";
				  html1+="</div>";
				  html1+="<div class='widget-content nopadding'>";
					html1+="<table class='table table-bordered data-table'>";
					  html1=html1+"<thead>";
						html1+="<tr>";
						  html1+="<th>School Name</th>";
						  html1+="<th><input type='checkbox' name='checkedAll' id='checkedAll' value='' onclick='chkCheckbox()'></th>";
						  html1+="<th></th>";
						  html1+="</tr>";
					  html1+="</thead>";
					  html1+="<tbody>";
					    for (index = 0; index < response.length; index++)
					  {		
							html1+="<tr class='gradeX'>";
							html1+="<td>"+response[index]['s_name']+"</td>";
							html1+="<td><input type='checkbox' name='checkAll' class='checkSingle' value='"+response[index]['s_id']+"'></td>";
							html1+="<td><button type='button' class='btn btn-secondary' onclick='emailSchoolSend("+response[index]['s_id']+")'>Send Mail</button></td>";
							html1+="</tr>";
						
					  } 
						
						 html1+="</tbody>";
					html1+="</table>";
				  html1+="</div>";
				html1+="</div>";
				$('#dataschool').html(html1);
				}
				else{
					alert("No Record Found");
					$('#dataschool').html('');
				}
				
				
								
			}
		});		
		}
		else{
			$('#dataschool').html('');
		}
	}
	
	
	
	function emailSchoolSend(id)
	{
			var d=id;
			//console.log("emailsid"+d);
			document.getElementById("id").value=d;
			//$("#id").val()=d;
				
			$("#singleSchool").modal();
	}
	
	function send()
	{
		
		//var d=$("#id").val();
		var data=$("#schemail").serialize();
		//console.log("data--"+data);
		$.ajax({
			type : 'POST',
			url : 'school-mail.php',
			data : data,
			success : function(data)
			{
				//alert(data);
				if(data=="ok")
				{
					$("#singleSchool").modal('hide');
					$("#modal-msg").find(".modal-body").html("<p class='text-center'>Mail Send Successfully</p>");
									$("#modal-msg").modal();
									$("#modal-msg").find(".btn-close").on('click' , function()
										{
											window.location.href="email-send.php";
										});
				}
				
				
			}
		});
	}
	
	function selectTemplate(selectedTem){
		$('.tempImage').removeClass('selected');
		$('#'+selectedTem).addClass('selected');
	}

	function sendemail()
	{
		//console.log("hii");
		var sch=[];
		$("input:checkbox[name=checkAll]:checked").each(function(){
    sch.push($(this).val());
    });
		//alert(sch);
		//return false;
		//var c_id=document.getElementById("country").value;
		//console.log("cid"+cid);
		var img_id=$(".selected").attr("data-id");
		//console.log("imgid"+img_id);
		//return false;
		$.ajax({
						type : 'POST',
						url : 'email-send1.php',
						data : {"sch":sch, "imgid":img_id},
						success : function(response)
						{
							//alert(response);
								//console.log("res"+response);
								
							if(response=="error2")
								{
									$("#modal-msg").find(".modal-body").html("<p class='text-center'>Template file not Found</p>");
									$("#modal-msg").modal();
									$("#modal-msg").find(".btn-close").on('click' , function()
										{
											window.location.href="email-send.php";
										});
									}
									else if(response=="error")
								{
									$("#modal-msg").find(".modal-body").html("<p class='text-center'>Template is already send</p>");
									$("#modal-msg").modal();
									$("#modal-msg").find(".btn-close").on('click' , function()
										{
											window.location.href="email-send.php";
										});
									}
									else if(response=="no")
								{
									$("#modal-msg").find(".modal-body").html("<p class='text-center'>No Mail Id available</p>");
									$("#modal-msg").modal();
									$("#modal-msg").find(".btn-close").on('click' , function()
										{
											window.location.href="email-send.php";
										});
									}
									else{
									$("#modal-msg").find(".modal-body").html("<p class='text-center'>Mail Send Successfully</p>");
									$("#modal-msg").modal();
									$("#modal-msg").find(".btn-close").on('click' , function()
										{
											window.location.href="email-send.php";
										});
									}
						}
    });
	}
	
	
    
	
	
	</script>

</body>
</html>
