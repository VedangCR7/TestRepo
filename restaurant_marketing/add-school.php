<?php
session_start();
    if(!isset($_SESSION["login"])) {
        header('LOCATION:index.php'); die();
    }

//ini_set("display_errors",1);
//ini_set(ERROR_REPORTING,E_ALL);
 require_once 'School.php';
 require_once 'Country.php';
  require_once 'includes/header.php';
  $highlight="";
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
$highlight="addschool";
 require_once 'includes/sidebar.php';
 ?>

<!--close-left-menu-stats-sidebar-->

<div id="content">
<div id="content-header">
  <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="tip-bottom">Form elements</a> <a href="#" class="current">Common elements</a> </div>
  <h1>Add Restaurant</h1>
</div>
<div class="container-fluid">
  <hr>
  <div class="row-fluid">
    <div class="span12">
      <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>Add Restaurant Form</h5>
        </div>
        <div class="widget-content nopadding">
       	<form action="add-school1.php" method="POST" class="form-horizontal" id="addschoolinfo" >
							<div class="span6">
								<div class="control-group">
									<label class="control-label">Restaurant Name :</label>
									<div class="controls">
										<input type="text" class="span11" placeholder="Restaurant Name" id="name" name="name"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Email Id :</label>
									<div class="controls">
										<input type="text" class="span11" placeholder="Email Id" id="email" name="email" />
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Website Name :</label>
									<div class="controls">
										<input type="text"  class="span11" placeholder="Website Name" id="webname" name="webname" />
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Country Name :</label>
									<select class="controls span11" id="coun" name="coun" onchange="get_city()">
									<option value="0">--Select country--</option>
									<?php 
										$c=new Country;
										$list1=array();
										$list1=$c->displayCountry();
										
										foreach($list1 as $key=>$row1)
										{
											
										?>	
										<option value="<?php echo $row1['c_id']; ?>"><?php echo $row1['c_name']; ?></option>
										<?php
										}
										?>	

									</select>
								</div>
							</div>
							<div class="span6">
								<div class="control-group">
									<label class="control-label">Contact No :</label>
									<div class="controls">
										<input type="text" class="span11" placeholder="Contact No" id="cntc" name="cntc" />
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Facebook Link :</label>
									<div class="controls">
										<input type="text" class="span11" placeholder="Facebook Link" id="fblink" name="fblink" />
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Restaurant Type :</label>
									<select class="controls span11" id="stype" name="stype">
										<option value="Restaurant" selected>Restaurant</option>
									</select>
								</div>
								
								<div class="control-group">
									<label class="control-label">City Name :</label>
									<div id="cityList">
										<select class="controls span11" id="city_id" name="city_id">
											<option value=0>--Select city--</option>
										</select>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Address :</label>
									<div class="controls">
										<textarea rows='2' cols='7' placeholder="Address" id="address" name="address" ></textarea>
									</div>
								</div>
							</div>
            <div class="form-actions">
             <button type="submit" class="btn btn-success"  onclick="validation();">Add Restaurant</button>
            </div>
          </form>
        </div>
      </div>
      
	          <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>All Restaurants</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
				  <th>Restaurant Name</th>
				  <th>Restaurant Email Id</th>
				  <th>Restaurant Contact No.</th>
                  
                  <th></th>
				  <th></th>
                </tr>
              </thead>
              <tbody>
			  <?php 
					$s=new School;
					$list=array();
					$list=$s->displaySchool();
					
					foreach($list as $key=>$row)
					{
						
					?>					
                <tr class="gradeX">
				  <td><?php
				 if($s->is_base64($row['s_name'])){
					 echo base64_decode($row['s_name']);
				 } else{
				  echo $row['s_name'];
				 } 
				  ?></td>
                  <td>
				  <?php 
				  $email=str_replace(",","\n",$row['email']);
				  echo nl2br($email."\n");
				  ?>
				  </td>
				 
				  <td><?php echo $row['contact'];?></td>
				 
				   <td><button type="button" class="btn btn-success" onclick="upSchool('<?php echo $row['s_id'];?>');">Update</button></td>
				  <td><button type="button" class="btn btn-success"  onclick="deleteSchool('<?php echo $row['s_id'];?>');">Delete</button></td>
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
<div class="row-fluid">
  <div id="footer" class="span12"> 2020 &copy; <a href="https://rslsolution.com/" target="_blank">RSL SOlution Pvt. Ltd.</a> </div>
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



		<div id="updateSchool" class="modal hide" style="width: 60%;overflow-x: hidden; overflow-y: scroll; height:93%;">
			<div class="modal-header">
				<button data-dismiss="modal" class="close" type="button">×</button>
				<h2>Update Restaurant Info</h2>
			</div>
			<div class="modal-body">
				<div class="span7">
					<div class="widget-box">
						<div class="widget-content nopadding" style="height:500px">
							<form action="" method="POST" class="form-horizontal" id="updatesch" >
								<div class="span6">
									<div class="control-group" style="margin-bottom:15px;">
										<label class="control-label">Restaurant Name :</label>
										<div class="controls">
											<input type="text" class="span11" placeholder="Restaurant Name" id="name" name="name"/>
										</div>
									</div>
									<div class="control-group" style="margin-bottom:15px;">
										<label class="control-label">Email Id :</label>
										<div class="controls">
											<input type="text" class="span11" placeholder="Email Id" id="email" name="email" />
										</div>
									</div>
									<div class="control-group" style="margin-bottom:15px;">
										<label class="control-label">Website Name :</label>
										<div class="controls">
											<input type="text"  class="span11" placeholder="Website Name" id="webname" name="webname" />
										</div>
									</div>
								</div>
								<div class="span6" >
									<datalist id="sstype" name="sstype">
									<?php 
										$c=new School;
										$list1=array();
										$list1=$c->displaySchoolType();
										
										foreach($list1 as $key=>$row1)
										{
											?>	
												<option value="<?php echo $row1['st_name']; ?>">
											<?php
										}
									?>	
									</datalist >
									<div class="control-group" style="margin-bottom:15px;">
										<label class="control-label">Restaurant Type :</label>
										<div class="controls">
											<input type="text" value="Restaurant" class="span11" placeholder="Type" id="s_type" name="s_type" />
										</div>
									</div>
								    <div class="control-group" style="margin-bottom:15px;">
										<label class="control-label">Contact No :</label>
										<div class="controls">
											<input type="text" class="span11" placeholder="Contact No" id="cntc" name="cntc" />
										</div>
									</div>
									<div class="control-group" style="margin-bottom:15px;">
										<label class="control-label">Facebook Link :</label>
										<div class="controls">
											<input type="text" class="span11" placeholder="Facebook Link" id="fblink" name="fblink" />
										</div>
									</div>
									<div class="control-group" style="margin-top:35px;">
										<label class="control-label">Country Name :</label>
										<div class="controls">
											<input type="text" class="span11" placeholder="Country Name" id="coun" name="coun" />
										</div>
									</div>
									<div class="control-group" style="margin-top:35px;">
										<label class="control-label">City Name :</label>
										<div class="controls">
											<input type="text" class="span11" placeholder="City Name" id="city_id" name="city_id" />
										</div>
									</div>
									<div class="control-group" style="margin-top:35px;">
										<label class="control-label">Address :</label>
										<div class="controls">
											<input type="text" class="span11" placeholder="Address" id="address" name="address" />
										</div>
									</div>
									<input type="hidden" placeholder="s id" id="idforupdate" name="idforupdate">
								</div>
								<div class="form-actions">
									<button type="button" class="btn btn-success" style="float:left;" onclick="updateSchool1();">Update</button>
									<div style="float:right;"><a data-dismiss="modal" class="btn btn-success btn-close">Cancel</a> </div>
								</div>
							</form>
						</div> 
					</div>
				</div>
			</div>
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
		function get_city()
		{
			var counid=$('#coun').val();
			/* alert(counid); */
			$.ajax({ 
				type : 'POST',
				url : 'City.php',
				data : {"cid":counid},
				success : function(response)
				{
					console.log(response);
					$('#cityList').html(response);
				}
			 });
		}
	</script>
	<script>
	
		
		var f=0;
	
		jQuery.validator.addMethod("laxEmail", function(value, element) 
		{
			//console.log("value--"+value);
			var result="";
			var i;
			var email={};
			email=(value).split(',');
			
			
			 /*$.each(email, function(index, value){
            console.log(index + ": " + value);
        });*/
		
		
			if((email.length)>1){
				//console.log("length"+email.length);
				for(i=0;i<(email.length);i++)
				{
					//console.log("i value"+i);
						// allow any non-whitespace characters as the host part
			result=this.optional( element ) || /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@(?:\S{1,63})$/.test( email[i] ); 
				}
				return result;
			}
			else if((email.length)==1){
					// allow any non-whitespace characters as the host part
			return this.optional( element ) || /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@(?:\S{1,63})$/.test( email[0] );
			}
				
		}, 'Please enter a valid email address.');

	
	
		function validation()
		{
		
		 	$("#addschoolinfo").validate({
				rules:{
					email:{
						laxEmail : true
					}
					
				},
				messages:{
					email : {
						laxEmail : "Please Enter Correct Email Id"
					}
					
				},
				submitHandler : submitForm

			});	 
			function submitForm(){
					
					var data = $("#addschoolinfo").serialize();
					
					console.log("add--"+data)
					$.ajax({
						type : 'POST',
						url : 'add-school1.php',
						data : data,
						success : function(response)
						{
							//alert(response);
								if(response.search("ok")>-1)
								{
									//alert(response);
									$("#modal-msg").find(".modal-body").html("<p class='text-center'>Restaurant Added Successfully</p>");
									$("#modal-msg").modal();
									$("#modal-msg").find(".btn-close").on('click' , function()
										{
											window.location.href="add-school.php";
										});
								}
						}
    });
}
		}
		
		function deleteSchool(id)
	{
		//console.log("hii");
		var sid=id;
		
		
		$.ajax({
						type : 'POST',
						url : 'delete-school.php',
						data : {"sid":sid},
						success : function(response)
						{
								//console.log("res"+response);
								if(response.search("ok")>-1)
								{
									$("#modal-msg").find(".modal-body").html("<p class='text-center'>Restaurant Deleted Successfully</p>");
									$("#modal-msg").modal();
									$("#modal-msg").find(".btn-close").on('click' , function()
										{
											window.location.href="add-school.php";
										});
									}
						}
    });
	}
	
	function upSchool(s_id)
	{
		
		$.ajax({
						type : 'POST',
						url : 'up-school.php',
						data : {s:s_id},
						accept:'application/json',
						success : function(response)
						{
							//response=JSON.stringify(response);
							
							response=JSON.parse(response);
							/* 
								//console.log("res"+typeof(response));
								console.log("res"+response);
								console.log("res"+response.success); */
								if(response.success=="success")
								{
									
									var decodedrestoname = atob(response.s_name);
								  //alert(decodedrestoname);
									$('#updateSchool #name').attr("value",decodedrestoname);
									$('#updateSchool #email').attr("value",response.email);
									$('#updateSchool #webname').attr("value",response.website);
									$('#updateSchool #cntc').attr("value",response.contact);
									$('#updateSchool #city_id').attr("value",response.city_name);
									$('#updateSchool #address').attr("value",response.address);
									$('#updateSchool #fblink').attr("value",response.fb_link);
									$('#updateSchool #coun').attr("value",response.c_name);
									$('#updateSchool #stype').attr("value",response.type);
									
									f=s_id;
									$("#updateSchool").modal();
								}
						}
    });
		
	}
	
	function updateSchool1()
	{
		var id=f;
		var d = $("#updatesch").serialize();
		$.ajax({
			type : 'POST',
			url : 'http://foodnai.com/restaurant/update-school.php',
			data : d+"&sid="+id,
			success : function(response)
			{
				console.log("y"+response);
					if(response.search("ok")>-1)
					{
						$("#updateSchool").modal('hide');
						$("#modal-msg").find(".modal-body").html("<p class='text-center'>Restaurant Info Updated Successfully</p>");
						$("#modal-msg").modal();
						
						$("#modal-msg").find(".btn-close").on('click' , function()
							{
								window.location.href="add-school.php";
							});
					}
			}
		});
	}
	</script>

</body>
</html>
