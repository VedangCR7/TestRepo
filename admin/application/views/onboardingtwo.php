<!DOCTYPE html>
<html>
<head>
        <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="Spaner - Simple light Bootstrap Nice Admin Panel Dashboard Design Responsive HTML5 Template" name="description">
        <meta content="Spruko Technologies Private Limited" name="author">
        <meta name="keywords" content="bootstrap panel, bootstrap admin template, dashboard template, bootstrap dashboard, dashboard design, best dashboard, html css admin template, html admin template, admin panel template, admin dashbaord template, bootstrap dashbaord template, it dashbaord, hr dashbaord, marketing dashbaord, sales dashbaord, dashboard ui, admin portal, bootstrap 4 admin template, bootstrap 4 admin"/>
    <title>test</title>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style type="text/css">
		input[type="text"] {
  text-transform: capitalize;
}
        *{
            padding: 0;
            margin: 0;
        }
        .container{
            max-width: 90%;
            margin: 0 auto;
        }
        .container-fluid{
             background: #FAFAFA;
        }
        nav{
        /*display: flex;
        align-items: center;
        justify-content: space-between*/
        padding: 1rem 0;
    }
    input[type=button] {
      background-color: #26a59a;
    }
     input[type=button]:hover{
      background-color: #26a59a;
    }
     input[type=button]:focus {
      background-color: #26a59a;
    }

    .checkbox {
    display: inline-flex;
    cursor: pointer;
    position: relative;
    margin-bottom: 1.5rem;
}

/*.checkbox > span {
    color: #34495E;
    padding: 0.5rem 0.25rem;
}*/

.checkbox > input {
    height: 20px;
    width: 20px;
    -webkit-appearance: none;
    -moz-appearance: none;
    -o-appearance: none;
    appearance: none;
    border: 1px solid #34495E;
   /* border-radius: 4px;*/
    outline: none;
    transition-duration: 0.3s;
   /* background-color: #41B883;*/
    cursor: pointer;
  }

.checkbox > input:checked {
    border: 1px solid #41B883;
    background-color: #26a59a;
}

/*.checkbox > input:checked + span::before {
    content: '\2713';
    display: block;
    text-align: center;
    color: #41B883;
    position: absolute;
    left: 0.7rem;
    top: 0.2rem;
}

.checkbox > input:active {
    border: 2px solid #34495E;
}*/
    </style>
</head>
<body>
  <div class="container-fluid">
    <nav class="container">
        <div class="logo-section">
            <a class="" href="/">
                   <img alt="logo" class="header-brand-img main-logo" src="<?=base_url('assets/images/brand/FoodNAILoginLogo.png')?>" style="height: 50px;width: 150px;">
             </a>
        </div>
    </nav>
    </div>
    <main class="container mt-4">
        <div class="col-md-12 col-lg-12 col-sm-12">
            <label>STEP 1</label>
        </div>
        <div class="col-md-12 col-lg-12 col-sm-12">
            <h4 style="color: #03014C;">Restaurant Details</h4>
            <h5 style="color: #03014C;">REFERENCE NUMBER/USER ID: <?=$this->uri->segment(3)?></h5>
        </div>
        <form id="imageUploadForm" method="post">
           <div class="col-md-12 col-lg-12 col-sm-12">
            <div class="row mt-4">
                 <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
						<input type="hidden" name="id" value="<?=$this->uri->segment(3)?>" id="id">
                        <input type="text" class="form-control" name="business_name" placeholder="Company Name" id="business_name" required>
                    </div>
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
						<input type="text" class="form-control" name="trade_license_number" placeholder="Trade License Number" id="trade_license_number" required>
                       
                    </div>
                    
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="trade_license_place" placeholder="Trade License Place" id="trade_license_place" required>
                    </div>
                    
                </div>

                 <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="text" onfocus="(this.type='date')" class="form-control" name="trade_licence_date" placeholder="Trade License Date" required>
                    </div>
                    
                </div>
           </div>

           <div class="row">
                 <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                       <input type="text" class="form-control" name="type_of_establishment" placeholder="Type Of Establishment" id="type_of_establishment" required>
                    </div>
                    
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="registered_address" placeholder="Registered Address" id="registered_address" required>
                    </div>
                    
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="text" onfocus="(this.type='date')" class="form-control" name="establishment_date" placeholder="Establishment Date" id="establishment_date" required>
                    </div>
                    
                </div>

                 <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                       <input type="text" class="form-control" name="mobile_number" placeholder="Mobile Number" id="mobile_number" minlength="8" maxlength="14" required >
                    </div>
                    
                </div>
           </div>
		   
		   <div class="row">
                 <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                       <input type="text" class="form-control" name="landline" placeholder="Landline" id="landline">
                    </div>
                    
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" placeholder="Email" id="email" required>
                    </div>
                    
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="fax" placeholder="FAX" id="fax">
                    </div>
                    
                </div>

                 <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                       <input type="text" class="form-control" name="country" placeholder="Country" id="country" required>
                    </div>
                    
                </div>
           </div>

           <div class="row">
                 <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="website" placeholder="Website" required>
                    </div>
                    
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="tax_no" placeholder="TAX NO">
                     
                    </div>
                    
                </div>

                 <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Google Map Location" id="venue_address">
						<input type="hidden" id="latitude" name="latitude">
                        <input type="hidden" id="longitude" name="longitude">
                    </div>
                    
                </div>
           </div>

           
           <div class="row">
               <div class="col-md-3 col-lg-3 col-sm-3">
                   <label class="form-label">Upload Trd Document</label>
                   <input type="file" class="form-control" id="trd_document" name="trd_document" required>
               </div>
               <div class="col-md-3 col-lg-3 col-sm-3">
                    <label class="form-label">Upload Restaurant Pictures</label>
                   <input type="file" class="form-control" id="restaurant_photo" name="restaurant_photo[]" multiple required>
               </div>
           </div>
         
           <div class="row mt-4">
            <div class="col-md-12 col-lg-12 col-sm-12">
                   <label class="form-label">Service Options</label>

               <div class="col-md-12 col-lg-12 col-sm-12 ">
              <div class="row">
               
                <div class="col-2 form-check">
                  <label class="checkbox">
                    <input class="form-check-input" name="service_option[]" id="myCheckbox" type="checkbox" value="Retail">
                   </label>
                    <label class="form-check-label ml-2" for="defaultCheck1">
                      Retail
                    </label>

                  </div>
                  <div class="col-2 form-check">
                  <label class="checkbox">
                    <input class="form-check-input" id="myCheckbox" name="service_option[]" type="checkbox" value="Payment">
               
                   </label>
                    <label class="form-check-label ml-2" for="defaultCheck2">
                     Payment
                    </label>
                  </div>
                  <div class="col-2 form-check">
                   <label class="checkbox">
                    <input class="form-check-input" id="myCheckbox" name="service_option[]" type="checkbox" value="Resto">
                   </label>
                    <label class="form-check-label ml-2" for="defaultCheck2">
                      Resto
                    </label>
                  </div>
              </div>
            </div>
             </div>
           </div>
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-12" style="margin-top:20px;"><h4>Business Days & Operating Hours</h4></div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-12 table-responsive" style="margin-top:10px;">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Day</th>
								<th>Opening Time</th>
								<th>Closing Time</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Monday <input type="hidden" name="days[]" value="Monday"></td>
								<td><input type="time" name="opening_time[]" class="form-control opening_time"></td>
								<td><input type="time" name="closing_time[]" class="form-control closing_time"></td>
								<td><input type="checkbox" name="apply_all_time">&nbsp;&nbsp;Apply All</td>
							</tr>
							<tr>
								<td>Tuesday <input type="hidden" name="days[]" value="Tuesday"></td>
								<td><input type="time" name="opening_time[]" class="form-control fill_automatic_opening_time"></td>
								<td><input type="time" name="closing_time[]" class="form-control fill_automatic_closing_time"></td>
								<td></td>
							</tr>
							<tr>
								<td>Wednesday <input type="hidden" name="days[]" value="Wednesday"></td>
								<td><input type="time" name="opening_time[]" class="form-control fill_automatic_opening_time"></td>
								<td><input type="time" name="closing_time[]" class="form-control fill_automatic_closing_time"></td>
								<td></td>
							</tr>
							<tr>
								<td>Thursday <input type="hidden" name="days[]" value="Thursday"></td>
								<td><input type="time" name="opening_time[]" class="form-control fill_automatic_opening_time"></td>
								<td><input type="time" name="closing_time[]" class="form-control fill_automatic_closing_time"></td>
								<td></td>
							</tr>
							<tr>
								<td>Friday <input type="hidden" name="days[]" value="Friday"></td>
								<td><input type="time" name="opening_time[]" class="form-control fill_automatic_opening_time"></td>
								<td><input type="time" name="closing_time[]" class="form-control fill_automatic_closing_time"></td>
								<td></td>
							</tr>
							<tr>
								<td>Saturday <input type="hidden" name="days[]" value="Saturday"></td>
								<td><input type="time" name="opening_time[]" class="form-control fill_automatic_opening_time"></td>
								<td><input type="time" name="closing_time[]" class="form-control fill_automatic_closing_time"></td>
								<td></td>
							</tr>
							<tr>
								<td>Sunday <input type="hidden" name="days[]" value="Sunday"></td>
								<td><input type="time" name="opening_time[]" class="form-control fill_automatic_opening_time"></td>
								<td><input type="time" name="closing_time[]" class="form-control fill_automatic_closing_time"></td>
								<td></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
            <div class="row mt-4 mb-4">
            <div class="col-md-12 col-lg-12 col-sm-12" style="color: #03014C;">
                <h4>Restaurant Authorized</h4>
                <h4>Person Details</h4>
            </div>
          </div>
            <div class="row">
               <div class="col-md-3 col-lg-3 col-sm-3">
                   <label class="form-label">Capture/Upload ID Front</label>
                   <input type="file" name="id_front[]" class="form-control" required>
               </div>
               <div class="col-md-3 col-lg-3 col-sm-3">
                    <label class="form-label">Capture/Upload ID Back</label>
                   <input type="file" name="id_back[]" class="form-control" required>
               </div>
               <div class="col-md-3 col-lg-3 col-sm-3">
                    <label class="form-label">Capture/Upload Image</label>
                   <input type="file" name="upload_image[]" class="form-control" required>
               </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
               </div>
           </div>

           <div class="row mt-4">
                 <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="authorized_person_name[]" placeholder="Full Name" required>
                    </div>
                    
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="authorized_person_id[]" placeholder="ID Number" required>
                    
                    </div>
                    
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="date" class="form-control" name="authorized_person_id_expiry_date[]" placeholder="ID Expiry Date" required>
                    </div>
                    
                </div>

           </div>

           <div class="row">
                 <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="authorized_person_gender[]" placeholder="Gender" required>
                    </div>
                    
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                       <input type="text" class="form-control" name="authorized_person_nationality[]" placeholder="Nationality" required>
                    </div>
                    
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="date" class="form-control" name="authorized_person_dob[]" placeholder="Date Of Birth" required>
                    </div>
                    
                </div>

           </div>

           <div class="row">
                 <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="authorized_person_mob[]" placeholder="Mobile Number" required minlength="8" maxlength="14">
                    </div>
                    
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="authorized_person_landline[]" placeholder="Landline Number">
                    </div>
                 </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="authorized_person_fax[]" placeholder="Fax Number">
                      
                    </div>
                </div>
           </div>

            <div class="row">
               <div class="col-md-3 col-lg-3 col-sm-3">
                  
                   <input type="email" name="authorized_person_email[]" class="form-control" placeholder="Email Id" required>
               </div>
               <div class="col-md-3 col-lg-3 col-sm-3">
                    
                   <input type="text" name="authorized_person_designation[]" class="form-control" placeholder="Designation" required>
               </div>
               <div class="col-md-3 col-lg-3 col-sm-3">
                   <input type="text" name="authorized_person_country_of_birth[]" class="form-control" placeholder="Country_of_birth" required>
               </div>
           </div>
		   
		   <div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-12" id="add_extra_fields"></div>
		   </div>
			<div class="row">
				<div class="col-md-12 col-lg-12 col-sm-12">
                   <input type="button" name="" class="btn btn-primary" value="Add Another Person" id="add_another_authorized_person" style="background-color:#1B949D;">
               </div>
			</div>
           <div class="row" style="margin-top:20px;">
                 <div class="col-md-2 col-lg-2 col-sm-2">
					<input type="hidden" id="count" value="0">
                   <input type="submit" name="" class="form-control btn btn-primary" value="Save & Continue" style="background-color:#1B949D;">
               </div>
           </div>
         </div>
        </form>
    </main>
     <footer class="page-footer">
      <div class="">
        <div class="container text-center text-md-left" style="margin-top: 90px;">
           <div class="col-md-12">
          <div class="row">
            <div class="col-md-3 mx-auto mb-4">
              <div style="display: flex;align-items: center;justify-content: space-around;">
                <img src="Group_22.png">
                <div>
                   <h6>Email Address</h6>
              <h6>support@youcloudpay.com</h6>
                </div>
              </div>
            </div>
             <div class="col-md-4 mx-auto mb-4">
               <div style="display: flex;align-items: center;">
                <img src="Group_21.png">
                <div class="ml-3">
                  <h6>Toll Free Number</h6>
                  <h6>1800 425 1809</h6>
                </div>
              </div>

            </div>
            <div class="col-md-5 mx-auto mb-4">
              <div>
              <h6>Copyright @ YouResto 2021. All rights reserved.</h6>
           <div>
                <ul style="display: flex;align-items: center;justify-content: space-between;list-style-type: none;color: #26a59a;">
                  <li>Data Protection Policy</li>
                  <li>Cookie Policy</li>
                  <li>Terms of Use</li>
                </ul>
           </div>
            </div>
            </div>
          </div>
        </div>
      </div>
      </div>
    </footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
      function check() 
      {
         if ($('#myCheckbox').is(':checked')==1) 
         {
            $('#myCheckbox').css("color", "yellow");
         }
      }
    </script>
	<script>
		$('#add_another_authorized_person').click(function(){
			var count = parseInt($('#count').val())+parseInt(1);
			$('#count').val(count);
			$('#add_extra_fields').append('<div class="row" style="margin-top:10px;" id="count'+count+'">\
			<div class="col-lg-12 col-md-12 col-sm-12 col-12 added_extra">\
			<div class="row">\
               <div class="col-md-3 col-lg-3 col-sm-3">\
                   <label class="form-label">Capture/Upload ID Front</label>\
                   <input type="file" name="id_front[]" class="form-control" required>\
               </div>\
               <div class="col-md-3 col-lg-3 col-sm-3">\
                    <label class="form-label">Capture/Upload ID Back</label>\
                   <input type="file" name="id_back[]" class="form-control" required>\
               </div>\
               <div class="col-md-3 col-lg-3 col-sm-3">\
                    <label class="form-label">Capture/Upload Image</label>\
                   <input type="file" name="upload_image[]" class="form-control" required>\
               </div>\
                <div class="col-md-3 col-lg-3 col-sm-3">\
               </div>\
           </div>\
\
           <div class="row mt-4">\
                 <div class="col-md-3 col-lg-3 col-sm-3">\
                    <div class="form-group">\
                        <input type="text" class="form-control" name="authorized_person_name[]" placeholder="Full Name" required>\
                    </div>\
                    \
                </div>\
                <div class="col-md-3 col-lg-3 col-sm-3">\
                    <div class="form-group">\
                        <input type="text" class="form-control" name="authorized_person_id[]" placeholder="ID Number" required>\
                    \
                    </div>\
                    \
                </div>\
                <div class="col-md-3 col-lg-3 col-sm-3">\
                    <div class="form-group">\
                        <input type="date" class="form-control" name="authorized_person_id_expiry_date[]" placeholder="ID Expiry Date" required>\
                    </div>\
                    \
                </div>\
\
           </div>\
\
           <div class="row">\
                 <div class="col-md-3 col-lg-3 col-sm-3">\
                    <div class="form-group">\
                        <input type="text" class="form-control" name="authorized_person_gender[]" placeholder="Gender" required>\
                    </div>\
                    \
                </div>\
                <div class="col-md-3 col-lg-3 col-sm-3">\
                    <div class="form-group">\
                       <input type="text" class="form-control" name="authorized_person_nationality[]" placeholder="Nationality" required>\
                    </div>\
                    \
                </div>\
                <div class="col-md-3 col-lg-3 col-sm-3">\
                    <div class="form-group">\
                        <input type="date" class="form-control" name="authorized_person_dob[]" placeholder="Date Of Birth" required>\
                    </div>\
                    \
                </div>\
\
           </div>\
\
           <div class="row">\
                 <div class="col-md-3 col-lg-3 col-sm-3">\
                    <div class="form-group">\
                        <input type="text" class="form-control" name="authorized_person_mob[]" placeholder="Mobile Number" required minlength="8" maxlength="14">\
                    </div>\
                    \
                </div>\
                <div class="col-md-3 col-lg-3 col-sm-3">\
                    <div class="form-group">\
                        <input type="text" class="form-control" name="authorized_person_landline[]" placeholder="Landline Number">\
                    </div>\
                 </div>\
                <div class="col-md-3 col-lg-3 col-sm-3">\
                    <div class="form-group">\
                        <input type="text" class="form-control" name="authorized_person_fax[]" placeholder="Fax Number">\
                      \
                    </div>\
                </div>\
           </div>\
\
            <div class="row">\
               <div class="col-md-3 col-lg-3 col-sm-3">\
                  \
                   <input type="email" name="authorized_person_email[]" class="form-control" placeholder="Email Id" required>\
               </div>\
               <div class="col-md-3 col-lg-3 col-sm-3">\
                    \
                   <input type="text" name="authorized_person_designation[]" class="form-control" placeholder="Designation" required>\
               </div>\
               <div class="col-md-3 col-lg-3 col-sm-3">\
                   <input type="text" name="authorized_person_country_of_birth[]" class="form-control" placeholder="Country_of_birth" required>\
               </div>\
			   <div class="col-md-3 col-lg-3 col-sm-3">\
					<button class="btn btn-danger removefields" data-id="'+count+'" type="button">Delete</button>\
				</div>\
           </div>\
			</div>\
			</div>');
			
		});
	</script>
	
	<script>
		$('body').on('click','.removefields',function(){
			
			$count=$(this).attr('data-id');
			
			$('#count'+$count).remove();
		});
	</script>
	
	<script>
		$('input[name=apply_all_time]').change(function(){
			//alert($('input[name=apply_all_time]:checked').val());
			if($('input[name=apply_all_time]:checked').val() =='on'){
				$('.fill_automatic_opening_time').val($('.opening_time').val());
				$('.fill_automatic_closing_time').val($('.closing_time').val());
			}else{
				$('.fill_automatic_opening_time').val('');
				$('.fill_automatic_closing_time').val('');
			}
		});
	</script>
	
	<script>
	function isNumber(e)
{
var keyCode = (e.which) ? e.which : e.keyCode;

if (keyCode > 31 && (keyCode < 48 || keyCode > 57))
{
   return false;
}
return true;
}
		$('body').on('submit','#imageUploadForm',function(e){
			//alert('hi');
			
			e.preventDefault();
			
			var formData = new FormData(this);
			
			console.log(formData);
			$.ajax({
				url:"<?=base_url()?>onboarding/add_step_one",
				type: "POST",
				data:  formData,
				cache:false,
				contentType: false,
				processData: false,
				success: function(data){
					if(data.status){
						swal(data.msg)
						.then((value) => {
						  window.location.href="<?=base_url('onboarding/onboardingstepthree/')?>"+$('#id').val();
						});
					}
					else{
						swal("Error!",result.msg, "error");
					}
				}	        
			});
		});
	</script>
</body>
</html>