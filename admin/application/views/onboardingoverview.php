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
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <style>
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
  /*  border-radius: 4px;*/
    outline: none;
    transition-duration: 0.3s;
   /* background-color: #41B883;*/
    cursor: pointer;
  }

.checkbox > input:checked {
    border: 1px solid #41B883;
    background-color: #26a59a;
}
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
        <!-- <div class="col-md-12 col-lg-12 col-sm-12">
            <label>STEP 1</label>
        </div> -->
        <div class="col-md-12 col-lg-12 col-sm-12" style="color: #03014C;">
            <h4>Overview</h4>
            <h5>REFERENCE NUMBER/USER ID: <?=$this->uri->segment(3)?></h5>
        </div>
		<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add Authorized Person</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
	  <form id="imageUploadForm1" method="post">
      <div class="modal-body">
	  <div class="col-md-12 col-lg-12 col-sm-12">
        <div class="row">
               <div class="col-md-3 col-lg-3 col-sm-3">
                   <label class="form-label">Capture/Upload ID Front</label>
				   <input type="hidden" name="id" value="<?=$this->uri->segment(3)?>">
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
                        <input type="text" class="form-control" name="authorized_person_mob[]" placeholder="Mobile Number" required>
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
		   </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
		<input type="submit" class="btn btn-success">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
	</form>
    </div>
  </div>
</div>


<!-- The Modal -->
<div class="modal" id="myModal2">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add Proprietor</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
	  <form id="imageUploadForm3" method="post">
      <div class="modal-body">
	  <div class="col-md-12 col-lg-12 col-sm-12">
        <div class="row">
               <div class="col-md-3 col-lg-3 col-sm-3">
                   <label class="form-label">Capture/Upload ID Front</label>
				   <input type="hidden" name="id" value="<?=$this->uri->segment(3)?>">
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
                        <input type="text" class="form-control" name="authorized_person_mob[]" placeholder="Mobile Number" required>
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
		   </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
		<input type="submit" class="btn btn-success">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
	</form>
    </div>
  </div>
</div>


<div class="modal" id="myModal1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Edit Autorized Person</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
	  <form id="imageUploadForm2" method="post">
      <div class="modal-body">
	  <div class="col-md-12 col-lg-12 col-sm-12">
        <div class="row">
               <div class="col-md-3 col-lg-3 col-sm-3">
                   <label class="form-label">Capture/Upload ID Front</label>
				   <input type="hidden" id="edit_authorized_id" name="id">
                   <input type="file" name="id_front[]" class="form-control" required>
				   <div id="show_edit_id_front_image"></div>
               </div>
               <div class="col-md-3 col-lg-3 col-sm-3">
                    <label class="form-label">Capture/Upload ID Back</label>
                   <input type="file" name="id_back[]" class="form-control" required>
				   <div id="show_edit_id_back_image"></div>
               </div>
               <div class="col-md-3 col-lg-3 col-sm-3">
                    <label class="form-label">Capture/Upload Image</label>
                   <input type="file" name="upload_image[]" class="form-control" required>
				   <div id="show_edit_upload_image"></div>
               </div>
           </div>

           <div class="row mt-4">
                 <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="authorized_person_name[]" placeholder="Full Name" id="edit_full_name" required>
                    </div>
                    
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="authorized_person_id[]" placeholder="ID Number" id="edit_id_number" required>
                    
                    </div>
                    
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="date" class="form-control" name="authorized_person_id_expiry_date[]" required placeholder="ID Expiry Date" id="edit_id_expiry_date">
                    </div>
                    
                </div>

           </div>

           <div class="row">
                 <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="authorized_person_gender[]" placeholder="Gender" id="edit_gender" required>
                    </div>
                    
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                       <input type="text" class="form-control" name="authorized_person_nationality[]" placeholder="Nationality" id="edit_nationality" required>
                    </div>
                    
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="date" class="form-control" name="authorized_person_dob[]" placeholder="Date Of Birth" id="edit_dob" required>
                    </div>
                    
                </div>

           </div>

           <div class="row">
                 <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="authorized_person_mob[]" placeholder="Mobile Number" id="edit_mobile_number" required>
                    </div>
                    
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="authorized_person_landline[]" placeholder="Landline Number" id="edit_landline_number">
                    </div>
                 </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="authorized_person_fax[]" placeholder="Fax Number" id="edit_fax_number">
                      
                    </div>
                </div>
           </div>

            <div class="row">
               <div class="col-md-3 col-lg-3 col-sm-3">
                  
                   <input type="email" name="authorized_person_email[]" class="form-control" placeholder="Email Id" id="edit_email" required>
               </div>
               <div class="col-md-3 col-lg-3 col-sm-3">
                    
                   <input type="text" name="authorized_person_designation[]" class="form-control" placeholder="Designation" id="edit_designation" required>
               </div>
               <div class="col-md-3 col-lg-3 col-sm-3">
                   <input type="text" name="authorized_person_country_of_birth[]" class="form-control" placeholder="Country_of_birth" required id="edit_country_of_birth">
               </div>
           </div>
		   </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
		<input type="submit" class="btn btn-success">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
	</form>
    </div>
  </div>
</div>


<div class="modal" id="myModal4">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Edit Proprietor</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
	  <form id="imageUploadForm4" method="post">
      <div class="modal-body">
	  <div class="col-md-12 col-lg-12 col-sm-12">
        <div class="row">
               <div class="col-md-3 col-lg-3 col-sm-3">
                   <label class="form-label">Capture/Upload ID Front</label>
				   <input type="hidden" id="proprietoredit_authorized_id" name="id">
                   <input type="file" name="id_front[]" class="form-control" required>
				   <div id="show_proprietoredit_id_front_image"></div>
               </div>
               <div class="col-md-3 col-lg-3 col-sm-3">
                    <label class="form-label">Capture/Upload ID Back</label>
                   <input type="file" name="id_back[]" class="form-control" required>
				   <div id="show_proprietoredit_id_back_image"></div>
               </div>
               <div class="col-md-3 col-lg-3 col-sm-3">
                    <label class="form-label">Capture/Upload Image</label>
                   <input type="file" name="upload_image[]" class="form-control" required>
				   <div id="show_proprietoredit_upload_image"></div>
               </div>
           </div>

           <div class="row mt-4">
                 <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="authorized_person_name[]" placeholder="Full Name" required id="proprietoredit_full_name">
                    </div>
                    
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="authorized_person_id[]" placeholder="ID Number" required id="proprietoredit_id_number">
                    
                    </div>
                    
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="date" class="form-control" name="authorized_person_id_expiry_date[]" required placeholder="ID Expiry Date" id="proprietoredit_id_expiry_date">
                    </div>
                    
                </div>

           </div>

           <div class="row">
                 <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="authorized_person_gender[]" placeholder="Gender" required id="proprietoredit_gender">
                    </div>
                    
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                       <input type="text" class="form-control" name="authorized_person_nationality[]" placeholder="Nationality" required id="proprietoredit_nationality">
                    </div>
                    
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="date" class="form-control" name="authorized_person_dob[]" placeholder="Date Of Birth" required id="proprietoredit_dob">
                    </div>
                    
                </div>

           </div>

           <div class="row">
                 <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="authorized_person_mob[]" placeholder="Mobile Number" required id="proprietoredit_mobile_number">
                    </div>
                    
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="authorized_person_landline[]" placeholder="Landline Number" id="proprietoredit_landline_number">
                    </div>
                 </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="authorized_person_fax[]" placeholder="Fax Number" id="proprietoredit_fax_number">
                      
                    </div>
                </div>
           </div>

            <div class="row">
               <div class="col-md-3 col-lg-3 col-sm-3">
                  
                   <input type="email" name="authorized_person_email[]" class="form-control" placeholder="Email Id" id="proprietoredit_email" required>
               </div>
               <div class="col-md-3 col-lg-3 col-sm-3">
                    
                   <input type="text" name="authorized_person_designation[]" class="form-control" placeholder="Designation" required id="proprietoredit_designation">
               </div>
               <div class="col-md-3 col-lg-3 col-sm-3">
                   <input type="text" name="authorized_person_country_of_birth[]" class="form-control" required placeholder="Country_of_birth" id="proprietoredit_country_of_birth">
               </div>
           </div>
		   </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
		<input type="submit" class="btn btn-success">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
	</form>
    </div>
  </div>
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
						<input type="text" class="form-control" name="trade_license_number" placeholder="Trade License Number" required id="trade_license_number">
                       
                    </div>
                    
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="trade_license_place" placeholder="Trade License Place" required id="trade_license_place">
                    </div>
                    
                </div>

                 <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="date" class="form-control" name="trade_licence_date" placeholder="Trade License Date" required id="trade_license_date">
                    </div>
                    
                </div>
           </div>

           <div class="row">
                 <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                       <input type="text" class="form-control" name="type_of_establishment" placeholder="Type Of Establishment" required id="type_of_establishment">
                    </div>
                    
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="registered_address" placeholder="Registered Address" required id="registered_address">
                    </div>
                    
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="date" class="form-control" name="establishment_date" placeholder="Establishment Date" required id="establishment_date">
                    </div>
                    
                </div>

                 <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                       <input type="text" class="form-control" name="mobile_number" placeholder="Mobile Number" required id="mobile_number">
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
                        <input type="text" class="form-control" name="website" placeholder="Website" id="website" required>
                    </div>
                    
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="tax_no" placeholder="TAX NO" id="tax_no" required>
						
                     
                    </div>
                    
                </div>

                 <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <select class="form-control">
                        <option>Google Location Map</option>
                           
                       </select>
                    </div>
                    
                </div>
           </div>
		   
           <div class="row">
               <div class="col-md-3 col-lg-3 col-sm-3">
                   <label class="form-label">Upload Trd Document</label>
                   <input type="file" class="form-control" id="trd_document" name="trd_document">
				   <div id="show_trd_images"></div>
               </div>
               <div class="col-md-3 col-lg-3 col-sm-3">
                    <label class="form-label">Upload Restaurant Pictures</label>
                   <input type="file" class="form-control" id="restaurant_photo" name="restaurant_photo[]" multiple>
				   
				   <div id="show_restaurant_images"></div>
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
								<td><input type="time" name="opening_time[]" class="form-control" id="mon_open"></td>
								<td><input type="time" name="closing_time[]" class="form-control" id="mon_close"></td>
								<td></td>
							</tr>
							<tr>
								<td>Tuesday <input type="hidden" name="days[]" value="Tuesday"></td>
								<td><input type="time" name="opening_time[]" class="form-control" id="tue_open"></td>
								<td><input type="time" name="closing_time[]" class="form-control" id="tue_close"></td>
								<td></td>
							</tr>
							<tr>
								<td>Wednesday <input type="hidden" name="days[]" value="Wednesday"></td>
								<td><input type="time" name="opening_time[]" class="form-control" id="wed_open"></td>
								<td><input type="time" name="closing_time[]" class="form-control" id="wed_close"></td>
								<td></td>
							</tr>
							<tr>
								<td>Thursday <input type="hidden" name="days[]" value="Thursday"></td>
								<td><input type="time" name="opening_time[]" class="form-control" id="thu_open"></td>
								<td><input type="time" name="closing_time[]" class="form-control" id="thu_close"></td>
								<td></td>
							</tr>
							<tr>
								<td>Friday <input type="hidden" name="days[]" value="Friday"></td>
								<td><input type="time" name="opening_time[]" class="form-control" id="fri_open"></td>
								<td><input type="time" name="closing_time[]" class="form-control" id="fri_close"></td>
								<td></td>
							</tr>
							<tr>
								<td>Saturday <input type="hidden" name="days[]" value="Saturday"></td>
								<td><input type="time" name="opening_time[]" class="form-control" id="sat_open"></td>
								<td><input type="time" name="closing_time[]" class="form-control" id="sat_close"></td>
								<td></td>
							</tr>
							<tr>
								<td>Sunday <input type="hidden" name="days[]" value="Sunday"></td>
								<td><input type="time" name="opening_time[]" class="form-control" id="sun_open"></td>
								<td><input type="time" name="closing_time[]" class="form-control" id="sun_close"></td>
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
				<button type="button" class="btn btn-primary" id="open_add_authorize_model">
				  Add Another Person
				</button>
            </div>
          </div>
		  
		  <div id="show_autorise_person_details">
		  
		  </div>
		  
          <div class="row">
         <div class="col-md-12 col-lg-12 col-sm-12 mt-4" style="color: #03014C;">
            <h4> Details Of Proprietor,</h4>
            <h5>Partners or Directors</h5>
			<button type="button" id="add_proprietor_popup" class="btn btn-primary">Add Another Person</button>
        </div>
      </div>
	  <div id="show_proprietor_person_details"></div>

        <div class="row mt-4">
        <div class="col-md-12 col-lg-12 col-sm-12 form-check">
         
                   <div class="col-12 form-check">
                  <label class="checkbox">
                    <input class="form-check-input" id="myCheckbox" type="checkbox" name="terms_comditions">
                   </label>
                    <label class="form-check-label ml-2" for="defaultCheck1">
                      I Agree The <span style="color:  #26a59a;">Terms And Conditions..</span>
                    </label>

                  </div>
                  
            </div>
        </div>
    

      <div class="row">
          <div class="col-md-12 col-lg-12 col-sm-12">
           <div class="row mt-4">
                 <div class="col-md-2 col-lg-2 col-sm-2">
                   <input type="submit" name="" class="form-control" value="Submit Now">
               </div>
           </div>

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
	
	<script>
		$('document').ready(function(){
			get_user_details();
			get_company_details();
			get_rest_opening_closing_time();
			get_authorise_person_details();
			
			get_proprietor_details();
		});
		
		
		function get_proprietor_details(){
			var id = $('#id').val();
			//alert(id);
			$.ajax({
				url:"<?=base_url()?>onboarding/get_previous_proprietor_details",
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
			   <button type="button" class="btn btn-success edit_proprietor_person" data-id="'+data[i].id+'">Edit</button>&nbsp;&nbsp;';
			   if(i!=0){
		   html+='<button type="button" class="btn btn-danger delete_proprietor_person" data-id="'+data[i].id+'">Delete</button>';
			   }
           html+='</div>\
		   </div>\
			</div>';
					}
					$('#show_proprietor_person_details').html(html);
				}	        
			});
		}
		
		
		$('body').on('click','.edit_proprietor_person',function(){
			var id = $(this).attr('data-id');
			$.ajax({
				url:"<?=base_url()?>onboarding/get_perticular_proprietor_person",
				type: "POST",
				data: {id:id},
				dataType:'json',
				success: function(data){
					$('#show_proprietoredit_id_front_image').html('<img src="<?=base_url('uploads/trd_document/')?>'+data[0].id_front+'" height="50px" width="50px">');
					$('#show_proprietoredit_id_back_image').html('<img src="<?=base_url('uploads/trd_document/')?>'+data[0].id_back+'" height="50px" width="50px">');
					$('#show_proprietoredit_upload_image').html('<img src="<?=base_url('uploads/trd_document/')?>'+data[0].upload_img+'" height="50px" width="50px">');
					$('#proprietoredit_full_name').val(data[0].full_name);
					$('#proprietoredit_id_number').val(data[0].id_number);
					$('#proprietoredit_id_expiry_date').val(data[0].id_expiry_date);
					$('#proprietoredit_gender').val(data[0].gender);
					$('#proprietoredit_nationality').val(data[0].nationality);
					$('#proprietoredit_dob').val(data[0].dob);
					$('#proprietoredit_mobile_number').val(data[0].mobile_number);
					$('#proprietoredit_landline_number').val(data[0].landline_number);
					$('#proprietoredit_fax_number').val(data[0].fax);
					$('#proprietoredit_email').val(data[0].email_id);
					$('#proprietoredit_designation').val(data[0].designation);
					$('#proprietoredit_country_of_birth').val(data[0].country_of_birth);
					$('#proprietoredit_authorized_id').val(data[0].id);
					
					$('#myModal4').modal('show');
				}	        
			});
		});
		
		
		$('body').on('click','.delete_proprietor_person',function(){
			var id = $(this).attr('data-id');
			//alert(id);
			$.ajax({
				url:"<?=base_url()?>onboarding/delete_proprietor_person",
				type: "POST",
				data: {id:id},
				dataType:'json',
				success: function(data){
					location.reload();
				}	        
			});
		});
		
		
		
		function get_authorise_person_details(){
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
			   <button type="button" class="btn btn-success edit_authorized_person" data-id="'+data[i].id+'">Edit</button>&nbsp;&nbsp;';
			   if(i!=0){
		   html+='<button type="button" class="btn btn-danger delete_authorized_person" data-id="'+data[i].id+'">Delete</button>';
			   }
           html+='</div>\
		   </div>\
			</div>';
					}
					$('#show_autorise_person_details').html(html);
				}	        
			});
		}
		
		$('body').on('click','.edit_authorized_person',function(){
			var id = $(this).attr('data-id');
			$.ajax({
				url:"<?=base_url()?>onboarding/get_perticular_authorize_person",
				type: "POST",
				data: {id:id},
				dataType:'json',
				success: function(data){
					$('#show_edit_id_front_image').html('<img src="<?=base_url('uploads/trd_document/')?>'+data[0].id_front+'" height="50px" width="50px">');
					$('#show_edit_id_back_image').html('<img src="<?=base_url('uploads/trd_document/')?>'+data[0].id_back+'" height="50px" width="50px">');
					$('#show_edit_upload_image').html('<img src="<?=base_url('uploads/trd_document/')?>'+data[0].upload_img+'" height="50px" width="50px">');
					$('#edit_full_name').val(data[0].full_name);
					$('#edit_id_number').val(data[0].id_number);
					$('#edit_id_expiry_date').val(data[0].id_expiry_date);
					$('#edit_gender').val(data[0].gender);
					$('#edit_nationality').val(data[0].nationality);
					$('#edit_dob').val(data[0].dob);
					$('#edit_mobile_number').val(data[0].mobile_number);
					$('#edit_landline_number').val(data[0].landline_number);
					$('#edit_fax_number').val(data[0].fax);
					$('#edit_email').val(data[0].email_id);
					$('#edit_designation').val(data[0].designation);
					$('#edit_country_of_birth').val(data[0].country_of_birth);
					$('#edit_authorized_id').val(data[0].id);
					
					$('#myModal1').modal('show');
				}	        
			});
		});
		
		
		$('body').on('click','.delete_authorized_person',function(){
			var id = $(this).attr('data-id');
			alert(id);
			$.ajax({
				url:"<?=base_url()?>onboarding/delete_authorized_person",
				type: "POST",
				data: {id:id},
				dataType:'json',
				success: function(data){
					location.reload();
				}	        
			});
		});
		
		function get_user_details(){
			$.ajax({
				url:"<?=base_url()?>onboarding/get_company_name",
				type: "POST",
				data: {id:$('#id').val()},
				dataType:'json',
				success: function(data){
					$('#business_name').val(data[0].business_name);
				}	        
			});
		}
		
		function get_company_details(){
			$.ajax({
				url:"<?=base_url()?>onboarding/get_company_details",
				type: "POST",
				data: {id:$('#id').val()},
				dataType:'json',
				success: function(data){
					$('#trade_license_number').val(data[0].trade_license_number);
					$('#trade_license_place').val(data[0].trade_license_place);
					$('#trade_license_date').val(data[0].trade_license_date);
					$('#type_of_establishment').val(data[0].type_of_establishment);
					$('#registered_address').val(data[0].registered_address);
					$('#establishment_date').val(data[0].establishment_date);
					$('#mobile_number').val(data[0].mobile_number);
					$('#landline').val(data[0].landline_number);
					$('#email').val(data[0].email);
					$('#fax').val(data[0].fax);
					$('#country').val(data[0].country);
					$('#website').val(data[0].website);
					$('#tax_no').val(data[0].tax_no);
					var fields = data[0].service_option.split(',');
					for(i=0;i<fields.length;i++){
						$('input[value='+fields[i]+']').attr('checked','checked');
					}
					
					if(data[0].trd_document!=''){
						$('#show_trd_images').html('<img src="<?=base_url()?>'+data[0].trd_document+'" height="50px" width="50px">');
					}
					
					if(data[0].upload_restaurant_photo!=''){
						var fields1 = data[0].upload_restaurant_photo.split('&');
						var html='';
						for(i=0;i<fields1.length;i++){
							html+='<img src="<?=base_url("uploads/trd_document/")?>'+fields1[i]+'" height="50px" width="50px">&nbsp;&nbsp;';
						}
						
						$('#show_restaurant_images').html(html);
					}
				}	        
			});
		}
		
		function get_rest_opening_closing_time(){
			$.ajax({
				url:"<?=base_url()?>onboarding/get_company_open_close_time",
				type: "POST",
				data: {id:$('#id').val()},
				dataType:'json',
				success: function(data){
					for(i=0;i<data.length;i++){
						if(data[i].day=='Monday'){
							$('#mon_open').val(data[i].opening_time);
							$('#mon_close').val(data[i].closing_time);
						}
						if(data[i].day=='Tuesday'){
							$('#tue_open').val(data[i].opening_time);
							$('#tue_close').val(data[i].closing_time);
						}
						if(data[i].day=='Wednesday'){
							$('#wed_open').val(data[i].opening_time);
							$('#wed_close').val(data[i].closing_time);
						}
						if(data[i].day=='Thursday'){
							$('#thu_open').val(data[i].opening_time);
							$('#thu_close').val(data[i].closing_time);
						}
						if(data[i].day=='Friday'){
							$('#fri_open').val(data[i].opening_time);
							$('#fri_close').val(data[i].closing_time);
						}
						if(data[i].day=='Saturday'){
							$('#sat_open').val(data[i].opening_time);
							$('#sat_close').val(data[i].closing_time);
						}
						if(data[i].day=='Sunday'){
							$('#sun_open').val(data[i].opening_time);
							$('#sun_close').val(data[i].closing_time);
						}
					}
				}	        
			});
		}
		
		$('body').on('submit','#imageUploadForm',function(e){
			if($('input[name=terms_comditions]:checked').val()!='on'){
				
			}
			e.preventDefault();
			
			var formData = new FormData(this);
			
			console.log(formData);
			$.ajax({
				url:"<?=base_url()?>onboarding/update_final_step",
				type: "POST",
				data:  formData,
				cache:false,
				contentType: false,
				processData: false,
				success: function(data){
					if(data.status){
						swal("Information save successfully.")
						.then((value) => {
						  window.location.href="<?=base_url('onboarding/onboardingone/')?>"+$('#id').val();
						});
					}
					else{
						//swal("Error!",data.msg, "error");
					}
				}	        
			});
		});
		
		$('body').on('submit','#imageUploadForm1',function(e){
			
			e.preventDefault();
			
			var formData = new FormData(this);
			
			console.log(formData);
			$.ajax({
				url:"<?=base_url()?>onboarding/add_authorized_person",
				type: "POST",
				data:  formData,
				cache:false,
				contentType: false,
				processData: false,
				success: function(data){
					if(data.status){
						swal(data.msg)
						.then((value) => {
						  location.reload();
						});
					}
					else{
						//swal("Error!",data.msg, "error");
					}
				}	        
			});
		});
		
		$('body').on('submit','#imageUploadForm3',function(e){
			
			e.preventDefault();
			
			var formData = new FormData(this);
			
			console.log(formData);
			$.ajax({
				url:"<?=base_url()?>onboarding/add_proprietor_person",
				type: "POST",
				data:  formData,
				cache:false,
				contentType: false,
				processData: false,
				success: function(data){
					if(data.status){
						swal(data.msg)
						.then((value) => {
						  location.reload();
						});
					}
					else{
						//swal("Error!",data.msg, "error");
					}
				}	        
			});
		});
		
		$('body').on('submit','#imageUploadForm2',function(e){
			
			e.preventDefault();
			
			var formData = new FormData(this);
			
			console.log(formData);
			$.ajax({
				url:"<?=base_url()?>onboarding/edit_authorized_person_details",
				type: "POST",
				data:  formData,
				cache:false,
				contentType: false,
				processData: false,
				success: function(data){
					if(data.status){
						swal(data.msg)
						.then((value) => {
						  location.reload();
						});
					}
					else{
						//swal("Error!",data.msg, "error");
					}
				}	        
			});
		});
		
		
		$('body').on('submit','#imageUploadForm4',function(e){
			//alert('hi');
			e.preventDefault();
			
			var formData = new FormData(this);
			
			console.log(formData);
			$.ajax({
				url:"<?=base_url()?>onboarding/edit_proprietor_person_details",
				type: "POST",
				data:  formData,
				cache:false,
				contentType: false,
				processData: false,
				success: function(data){
					if(data.status){
						swal(data.msg)
						.then((value) => {
						  location.reload();
						});
					}
					else{
						//swal("Error!",data.msg, "error");
					}
				}	        
			});
		});
		
		
		$('#open_add_authorize_model').click(function(){
			$('#myModal').modal('show');
		});
		
		$('#add_proprietor_popup').click(function(){
			//alert('hii');
			$('#myModal2').modal('show');
		})
	</script>
    
</body>
</html>