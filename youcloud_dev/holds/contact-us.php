<!DOCTYPE html>
<html lang="en">

<head>
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-8ZJNB18KS2"></script>
	<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());
	gtag('config', 'G-8ZJNB18KS2');
	</script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>YouCloud | Contact Us</title>
	<?php include "header.php"; ?>
    <div class="tp-page-head">
        <!-- page header -->
        <div class="container">
            <div class="row">
                <div class="col-md-offset-2 col-md-8">
                    <div class="page-header text-center">
                        <div class="icon-circle"> 
                        <i class="icon icon-size-60 icon-loving-home icon-white"></i> </div>
                        <h1>Contact YouCloud</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- /.page header -->
    <div class="tp-breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <ol class="breadcrumb">
                        <li><a href="#">Home</a></li>
                        <li class="active">Contact us</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="main-container">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="well-box">
                        <p>Please fill out the form below and we will get back to you as soon as possible.</p>
                        <form>
                            <!-- Text input-->
                            <div class="form-group">
                                <label class="control-label" for="first">First Name <span class="required">*</span></label>
                                <input id="fname" name="fname" type="text" placeholder="First Name" class="form-control input-md" required>
                            </div>
                            <!-- Text input-->
                            <div class="form-group">
                                <label class=" control-label" for="email">E-Mail <span class="required">*</span></label>
                                <input id="emailID" name="email" type="text" placeholder="E-Mail" class="form-control input-md" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="first">Company Name </label>
                                <input id="cname" name="companyname" type="text" placeholder="Company Name" class="form-control input-md" >
                            </div>
                            <div class="form-group">
                                <label class=" control-label" for="phone">Phone Number </label>
                                <input id="phone" name="phonenumber" type="text" placeholder="Phone Number" class="form-control input-md" >
                            </div>
                            <!-- Textarea -->
                            <div class="form-group">
                                <label class="  control-label" for="message">Subject</label>
                                <textarea class="form-control" rows="6" id="subject" name="subject">Write something</textarea>
                            </div>
                            <div class="form-group">
                                <label class="  control-label" for="message">Description</label>
                                <textarea class="form-control" rows="6" id="description" name="description">Write something</textarea>
                            </div>
                            <!-- Button -->
                            <div class="form-group">
                                <button id="submit" name="submit" class="btn btn-primary btn-lg" onclick="submit_form()">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-6 contact-info">
                    <div class="well-box">
                        <ul class="listnone">
                            <li class="address">
                                <h2><i class="fa fa-map-marker"></i>India office Location</h2>
                                <p>80/1 Chinchwad, Pune, 411035</p>
                            </li>
                            <!--<li class="email">
                                <h2><i class="fa fa-envelope"></i>E-Mail</h2>
                                <p>Info@weddingvendor.com</p>
                            </li>-->
                            <li class="call">
                                <h2><i class="fa fa-phone"></i>Contact</h2>
                                <p>9096041415/9941041415</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 contact-info">
                    <div class="well-box">
                        <ul class="listnone">
                            <li class="address">
                                <h2><i class="fa fa-map-marker"></i>Mozambique Office Location</h2>
                                <p>SS Solvency Services,Multi services</p>
                            </li>
                            <li class="call">
                                <h2><i class="fa fa-phone"></i>Contact</h2>
                                <p>+258 84 290 6347/+258 81 413 9318</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 contact-info">
                    <div class="well-box">
                        <ul class="listnone">
                            <li class="address">
                                <h2><i class="fa fa-map-marker"></i>Swaziland Location</h2>
                                <p>SS Solvency Services,Multi services</p>
                            </li>
                            <li class="call">
                                <h2><i class="fa fa-phone"></i>Contact</h2>
                                <p>+258 84 290 6347/+258 81 413 9318</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php include "footer.php"; ?>
    <script>
                function submit_form()
                {
                    var email=$("#emailID").val();
                    var name=$("#fname").val();
                    var company=$("#cname").val();
                    var phone=$("#phone").val();
                    var subject=$("#subject").val();
                    var description=$("#description").val();
                    $.ajax({
                        type: "POST",
                        url: "contact_us.php",
                        async: false,
                        data: {
                            email : email,
                            name:name,
                            company : company,
                            phone : phone,
                            subject : subject,
                            description : description
                        },
                        success: function (response) 
                        {
                            if (response == "success") 
                            {
                                alert("Thank you " + name);
                            }
                            else 
                            {
                                alert("System out of service, please try after some time.");
                            }
                        }
                    });
                }
                </script>
	<script>
    $(document).ready(function(){
      $('.pincode').click(function(){
        $('.pincode').val('');
        $('#send_post_code').val('');
      });
      $(".restaurant_id").click(function(){
        $('.restaurant_id').val('');
        $('#send_restaurant_id').val('');
      });
      $('.submit_search').click(function(){
        if($('#send_post_code').val() !='' && $('#send_restaurant_id').val() ==''){
          window.location.href ='restaurant_listing.php?pin_code='+$('#send_post_code').val();
        }
        if($('#send_post_code').val() =='' && $('#send_restaurant_id').val() !=''){
          window.location.href ='restaurant_page.php?restaurant_id='+$('#send_restaurant_id').val();
        }
        if($('#send_post_code').val() !='' && $('#send_restaurant_id').val() !=''){
          window.location.href ='restaurant_page.php?restaurant_id='+$('#send_restaurant_id').val()+'&pin_code='+$('#send_post_code').val();
        }
      });

      $('.pincode').keyup(function(){
        var $inputaddress = $(".pincode");
        var search_content = $inputaddress.val();
        if(search_content.length > 2){
          $.get("getaddress.php?search="+search_content, function(data){
          $inputaddress.typeahead({
                source:data,autoSelect: true,
                afterSelect:function(item){
                    console.log(item.id);
                    $('#send_post_code').val(item.id);
                }
            });
        },'json');
      }
      })
      var $input = $(".restaurant_id");
        $.get("getrestaurants.php", function(data){
          $input.typeahead({
                source:data,autoSelect: true,
                afterSelect:function(item){
                    console.log(item.id);
                    $('#send_restaurant_id').val(item.id);
                }
            });
        },'json');
    });
    </script>
</body>

</html>