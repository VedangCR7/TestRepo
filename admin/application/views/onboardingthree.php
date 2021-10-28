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
            <label>STEP 2</label>
        </div>
        <div class="col-md-12 col-lg-12 col-sm-12">
            <h4 style="color: #03014C;">Restaurant Details</h4>
            <h5 style="color: #03014C;">REFERENCE NUMBER/USER ID: <?=$this->uri->segment(3)?></h5>
        </div>
		<div class="col-md-12 col-lg-12 col-sm-12 mt-4">
                   <label class="form-label">If Same As Above Please tick the box</label>

               <div class="col-md-12 col-lg-12 col-sm-12 ">
         

              <div class="row">
               
                <div class="col-2 form-check">
                  <label class="checkbox">
                    <input class="form-check-input" id="myCheckbox" type="radio" name="same_as_above" value="Yes" checked>
                   </label>
                    <label class="form-check-label ml-2" for="defaultCheck1">
                      Yes
                    </label>

                  </div>
                  <div class="col-2 form-check">
                  <label class="checkbox">
                    <input class="form-check-input" id="myCheckbox" type="radio" name="same_as_above" value="No">
               
                   </label>
                    <label class="form-check-label ml-2" for="defaultCheck2">
                     No
                    </label>
                  </div>
              </div>

            </div>
             </div>
        <form id="imageUploadForm" method="post">
			<input type="hidden" value="<?=$this->uri->segment(3)?>" name="id" id="id">
           <div class="col-md-12 col-lg-12 col-sm-12">
            <div class="row mt-4 mb-4">
            <div class="col-md-12 col-lg-12 col-sm-12" style="color: #03014C;">
                <h4> Details Of Proprietor,</h4>
            <h5>Partners or Directors</h5>
            </div>
          </div>
		  <div id="set_proprietor_details_yes">
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
                        <input type="text" class="form-control" name="authorized_person_landline[]" placeholder="Landline Number" required minlength="8" maxlength="14">
                    </div>
                 </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="authorized_person_fax[]" placeholder="Fax Number" required>
                      
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
                   <input type="button" name="" class="btn btn-primary" value="Add Another Person" id="add_another_authorized_person">
               </div>
			</div>
			</div>
			
			
			<div id="set_proprietor_details_no">
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
                   <input type="file" name="upload_images[]" class="form-control" required>
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
                        <input type="text" class="form-control" name="authorized_person_mob[]" placeholder="Mobile Number" required maxlength="14" minlength="8">
                    </div>
                    
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="authorized_person_landline[]" placeholder="Landline Number" required maxlength="14" minlength="8">
                    </div>
                 </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="authorized_person_fax[]" placeholder="Fax Number" required>
                      
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
                   <input type="button" name="" class="btn btn-primary" value="Add Another Person" id="add_another_authorized_person">
               </div>
			</div>
			</div>
			
			
           <div class="row">
                 <div class="col-md-2 col-lg-2 col-sm-2">
					<input type="hidden" id="count" value="0">
                   <input type="submit" name="" class="form-control" value="Save & Continue">
               </div>
           </div>
         </div>
        </form>
    </main>
    
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
		$('body').on('click','#add_another_authorized_person',function(){
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
                   <input type="file" name="upload_images[]" class="form-control" required>\
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
                        <input type="text" class="form-control" name="authorized_person_mob[]" placeholder="Mobile Number" required>\
                    </div>\
                    \
                </div>\
                <div class="col-md-3 col-lg-3 col-sm-3">\
                    <div class="form-group">\
                        <input type="text" class="form-control" name="authorized_person_landline[]" placeholder="Landline Number" required>\
                    </div>\
                 </div>\
                <div class="col-md-3 col-lg-3 col-sm-3">\
                    <div class="form-group">\
                        <input type="text" class="form-control" name="authorized_person_fax[]" placeholder="Fax Number" required>\
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
		$('body').on('submit','#imageUploadForm',function(e){
			//alert('hi');
			
			e.preventDefault();
			
			var formData = new FormData(this);
			
			console.log(formData);
			$.ajax({
				url:"<?=base_url()?>onboarding/add_step_second",
				type: "POST",
				data:  formData,
				cache:false,
				contentType: false,
				processData: false,
				success: function(data){
					if(data.status){
						swal(data.msg)
						.then((value) => {
						  window.location.href="<?=base_url('onboarding/onboardingupdate/')?>"+$('#id').val();
						});
					}
					else{
						swal("Error!",data.msg, "error");
					}
				}	        
			});
		});
	</script>
	
	
	<script>
		$('document').ready(function(){
			var id = $('#id').val();
			//alert(id);
			$.ajax({
				url:"<?=base_url()?>onboarding/get_previous_details",
				type: "POST",
				data: {id:id},
				dataType:'json',
				success: function(data){
					var html='';
					for(i=0;i<data.length;i++){
						html+='<div class="row" style="margin-top:10px;">\
			<div class="col-lg-12 col-md-12 col-sm-12 col-12 added_extra">\
			<div class="row">\
               <div class="col-md-3 col-lg-3 col-sm-3">\
                   <label class="form-label">Capture/Upload ID Front</label>\
				   <input type="hidden" name="in_front[]" value="'+data[i].id_front+'">\
                   <input type="file" name="id_front[]" class="form-control" readonly disabled>\
               </div>\
               <div class="col-md-3 col-lg-3 col-sm-3">\
                    <label class="form-label">Capture/Upload ID Back</label>\
					<input type="hidden" name="in_back[]" value="'+data[i].id_back+'">\
                   <input type="file" name="id_back[]" class="form-control" readonly disabled>\
               </div>\
               <div class="col-md-3 col-lg-3 col-sm-3">\
                    <label class="form-label">Capture/Upload Image</label>\
					<input type="hidden" name="upload_image[]" value="'+data[i].upload_image+'">\
                   <input type="file" name="upload_images[]" class="form-control" readonly disabled>\
               </div>\
                <div class="col-md-3 col-lg-3 col-sm-3">\
               </div>\
           </div>\
\
           <div class="row mt-4">\
                 <div class="col-md-3 col-lg-3 col-sm-3">\
                    <div class="form-group">\
                        <input type="text" readonly class="form-control" name="authorized_person_name[]" value="'+data[i].full_name+'" placeholder="Full Name">\
                    </div>\
                    \
                </div>\
                <div class="col-md-3 col-lg-3 col-sm-3">\
                    <div class="form-group">\
                        <input type="text" readonly class="form-control" name="authorized_person_id[]" placeholder="ID Number" value="'+data[i].id_number+'">\
                    \
                    </div>\
                    \
                </div>\
                <div class="col-md-3 col-lg-3 col-sm-3">\
                    <div class="form-group">\
                        <input type="date" readonly class="form-control" name="authorized_person_id_expiry_date[]" placeholder="ID Expiry Date" value="'+data[i].id_expiry_date+'">\
                    </div>\
                    \
                </div>\
\
           </div>\
\
           <div class="row">\
                 <div class="col-md-3 col-lg-3 col-sm-3">\
                    <div class="form-group">\
                        <input type="text" readonly class="form-control" name="authorized_person_gender[]" placeholder="Gender" value="'+data[i].gender+'">\
                    </div>\
                    \
                </div>\
                <div class="col-md-3 col-lg-3 col-sm-3">\
                    <div class="form-group">\
                       <input type="text" readonly class="form-control" name="authorized_person_nationality[]" placeholder="Nationality" value="'+data[i].nationality+'">\
                    </div>\
                    \
                </div>\
                <div class="col-md-3 col-lg-3 col-sm-3">\
                    <div class="form-group">\
                        <input type="date" readonly class="form-control" name="authorized_person_dob[]" placeholder="Date Of Birth" value="'+data[i].dob+'">\
                    </div>\
                    \
                </div>\
\
           </div>\
\
           <div class="row">\
                 <div class="col-md-3 col-lg-3 col-sm-3">\
                    <div class="form-group">\
                        <input type="text" class="form-control" readonly name="authorized_person_mob[]" placeholder="Mobile Number" value="'+data[i].mobile_number+'">\
                    </div>\
                    \
                </div>\
                <div class="col-md-3 col-lg-3 col-sm-3">\
                    <div class="form-group">\
                        <input type="text" class="form-control" readonly name="authorized_person_landline[]" placeholder="Landline Number" value="'+data[i].landline_number+'">\
                    </div>\
                 </div>\
                <div class="col-md-3 col-lg-3 col-sm-3">\
                    <div class="form-group">\
                        <input type="text" class="form-control" readonly name="authorized_person_fax[]" placeholder="Fax Number" value="'+data[i].fax+'">\
                      \
                    </div>\
                </div>\
           </div>\
\
            <div class="row">\
               <div class="col-md-3 col-lg-3 col-sm-3">\
                  \
                   <input type="email" name="authorized_person_email[]" readonly class="form-control" placeholder="Email Id" value="'+data[i].email_id+'">\
               </div>\
               <div class="col-md-3 col-lg-3 col-sm-3">\
                    \
                   <input type="text" name="authorized_person_designation[]" readonly class="form-control" placeholder="Designation" value="'+data[i].designation+'">\
               </div>\
               <div class="col-md-3 col-lg-3 col-sm-3">\
                   <input type="text" name="authorized_person_country_of_birth[]" readonly class="form-control" placeholder="Country_of_birth" value="'+data[i].country_of_birth+'">\
               </div>\
           </div>\
			</div>\
			</div>';
					}
					$('#set_proprietor_details_yes').html(html);
					$('#set_proprietor_details_no').hide();
				}	        
			});
		});
		
		
		$('input[name=same_as_above]').change(function(){
			if($(this).val()=='Yes'){
				$('#set_proprietor_details_yes').show();
				$('#set_proprietor_details_no').hide();
			}else{
				$('#set_proprietor_details_yes').hide();
				$('#set_proprietor_details_no').show();
			}
		});
	</script>
</body>
</html>