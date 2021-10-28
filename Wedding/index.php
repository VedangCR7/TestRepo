<!DOCTYPE html>
<html lang="en">
    
<head>
        <title>School Admin</title><meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
        <link rel="stylesheet" href="css/matrix-login.css" />
        <link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>

    </head>
    <body>
        <div id="loginbox">           
            <form id="loginform" class="form-vertical" action="">
				 <div class="control-group normal_text"> <h3><img src="img/logoes1.png" alt="Logo" /></h3></div>
				 <div class="control-group normal_text" id="loginMsg"></div>
                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_lg"><i class="icon-user"> </i></span><input type="text" placeholder="Username" name="uname" id="uname" />
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_ly"><i class="icon-lock"></i></span><input type="password" placeholder="Password" name="pwd" id="pwd"/>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <span class="pull-left"><a href="#" class="flip-link btn btn-info" id="to-recover">Lost password?</a></span>
                    <span class="pull-right"><a class="btn btn-success" onclick="login()" > Login</a></span>
                </div>
            </form>
            <form id="recoverform" action="#" method="POST" class="form-vertical">
				<p class="normal_text">Enter your e-mail address below and we will send you instructions how to recover a password.</p>
				
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_lo"><i class="icon-envelope"></i></span><input type="text" placeholder="E-mail address" />
                        </div>
                    </div>
               
                <div class="form-actions">
                    <span class="pull-left"><a href="#" class="flip-link btn btn-success" id="to-login">&laquo; Back to login</a></span>
                    <span class="pull-right"><a class="btn btn-info"/>Reecover</a></span>
                </div>
            </form>
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
       
	<script src="js/jquery.min.js"></script>  
        <script src="js/matrix.login.js"></script> 
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
		
		<script>
		function login(){
			
			var data1=$("#loginform").serialize();
			console.log("data---"+data1);
			
			$.ajax({
					
						type : 'POST',
						url : 'login_process.php',
						data : data1,
						success : function(response)
						{
								//alert(response);
							
								if(response=="ok")
								{
									var msg="<h4 style='color:green;'>Login Successfully</h4>";
									$("#loginMsg").html(msg);
									window.location.href="add-school.php";
									
								}
								else
								{
									var msg="<h4 style='color:green;'>Invalid User Name or Password</h4>";
									$("#loginMsg").html(msg);
									
								}
						}
			});
		}
		</script>

    </body>

</html>
