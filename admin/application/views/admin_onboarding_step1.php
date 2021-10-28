<?php
require_once('header.php');
require_once('sidebar.php');
?>

<div class=" app-content">
	<div class="side-app">

		<!--Page Header-->
		<div class="page-header">
			<h3 class="page-title"><i class="fe fe-user mr-1"></i> Onboarding step 1</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?=base_url();?>admin">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Onboarding step 1</li>
			</ol>
		</div>
		<!--Page Header-->
		<div class="row">
			<div class="col-lg-12 col-md-12">
			
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
                   <input type="file" name="id_front[]" class="form-control">
               </div>
               <div class="col-md-3 col-lg-3 col-sm-3">
                    <label class="form-label">Capture/Upload ID Back</label>
                   <input type="file" name="id_back[]" class="form-control">
               </div>
               <div class="col-md-3 col-lg-3 col-sm-3">
                    <label class="form-label">Capture/Upload Image</label>
                   <input type="file" name="upload_image[]" class="form-control">
               </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
               </div>
           </div>

           <div class="row mt-4">
                 <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="authorized_person_name[]" placeholder="Full Name">
                    </div>
                    
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="authorized_person_id[]" placeholder="ID Number">
                    
                    </div>
                    
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="date" class="form-control" name="authorized_person_id_expiry_date[]" placeholder="ID Expiry Date">
                    </div>
                </div>

           </div>

           <div class="row">
                 <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="authorized_person_gender[]" placeholder="Gender">
                    </div>
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                       <input type="text" class="form-control" name="authorized_person_nationality[]" placeholder="Nationality">
                    </div>
                    
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="date" class="form-control" name="authorized_person_dob[]" placeholder="Date Of Birth">
                    </div>
                    
                </div>

           </div>

           <div class="row">
                 <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="authorized_person_mob[]" placeholder="Mobile Number">
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
                  
                   <input type="email" name="authorized_person_email[]" class="form-control" placeholder="Email Id">
               </div>
               <div class="col-md-3 col-lg-3 col-sm-3">
                    
                   <input type="text" name="authorized_person_designation[]" class="form-control" placeholder="Designation">
               </div>
               <div class="col-md-3 col-lg-3 col-sm-3">
                   <input type="text" name="authorized_person_country_of_birth[]" class="form-control" placeholder="Country_of_birth">
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
                   <input type="file" name="id_front[]" class="form-control">
               </div>
               <div class="col-md-3 col-lg-3 col-sm-3">
                    <label class="form-label">Capture/Upload ID Back</label>
                   <input type="file" name="id_back[]" class="form-control">
               </div>
               <div class="col-md-3 col-lg-3 col-sm-3">
                    <label class="form-label">Capture/Upload Image</label>
                   <input type="file" name="upload_image[]" class="form-control">
               </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
               </div>
           </div>

           <div class="row mt-4">
                 <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="authorized_person_name[]" placeholder="Full Name">
                    </div>
                    
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="authorized_person_id[]" placeholder="ID Number">
                    
                    </div>
                    
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="date" class="form-control" name="authorized_person_id_expiry_date[]" placeholder="ID Expiry Date">
                    </div>
                </div>

           </div>

           <div class="row">
                 <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="authorized_person_gender[]" placeholder="Gender">
                    </div>
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                       <input type="text" class="form-control" name="authorized_person_nationality[]" placeholder="Nationality">
                    </div>
                    
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="date" class="form-control" name="authorized_person_dob[]" placeholder="Date Of Birth">
                    </div>
                    
                </div>

           </div>

           <div class="row">
                 <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="authorized_person_mob[]" placeholder="Mobile Number">
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
                  
                   <input type="email" name="authorized_person_email[]" class="form-control" placeholder="Email Id">
               </div>
               <div class="col-md-3 col-lg-3 col-sm-3">
                    
                   <input type="text" name="authorized_person_designation[]" class="form-control" placeholder="Designation">
               </div>
               <div class="col-md-3 col-lg-3 col-sm-3">
                   <input type="text" name="authorized_person_country_of_birth[]" class="form-control" placeholder="Country_of_birth">
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
                   <input type="file" name="id_front[]" class="form-control">
				   <div id="show_edit_id_front_image"></div>
               </div>
               <div class="col-md-3 col-lg-3 col-sm-3">
                    <label class="form-label">Capture/Upload ID Back</label>
                   <input type="file" name="id_back[]" class="form-control">
				   <div id="show_edit_id_back_image"></div>
               </div>
               <div class="col-md-3 col-lg-3 col-sm-3">
                    <label class="form-label">Capture/Upload Image</label>
                   <input type="file" name="upload_image[]" class="form-control">
				   <div id="show_edit_upload_image"></div>
               </div>
           </div>

           <div class="row mt-4">
                 <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="authorized_person_name[]" placeholder="Full Name" id="edit_full_name">
                    </div>
                    
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="authorized_person_id[]" placeholder="ID Number" id="edit_id_number">
                    
                    </div>
                    
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="date" class="form-control" name="authorized_person_id_expiry_date[]" placeholder="ID Expiry Date" id="edit_id_expiry_date">
                    </div>
                    
                </div>

           </div>

           <div class="row">
                 <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="authorized_person_gender[]" placeholder="Gender" id="edit_gender">
                    </div>
                    
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                       <input type="text" class="form-control" name="authorized_person_nationality[]" placeholder="Nationality" id="edit_nationality">
                    </div>
                    
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="date" class="form-control" name="authorized_person_dob[]" placeholder="Date Of Birth" id="edit_dob">
                    </div>
                    
                </div>

           </div>

           <div class="row">
                 <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="authorized_person_mob[]" placeholder="Mobile Number" id="edit_mobile_number">
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
                  
                   <input type="email" name="authorized_person_email[]" class="form-control" placeholder="Email Id" id="edit_email">
               </div>
               <div class="col-md-3 col-lg-3 col-sm-3">
                    
                   <input type="text" name="authorized_person_designation[]" class="form-control" placeholder="Designation" id="edit_designation">
               </div>
               <div class="col-md-3 col-lg-3 col-sm-3">
                   <input type="text" name="authorized_person_country_of_birth[]" class="form-control" placeholder="Country_of_birth" id="edit_country_of_birth">
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
                   <input type="file" name="id_front[]" class="form-control">
				   <div id="show_proprietoredit_id_front_image"></div>
               </div>
               <div class="col-md-3 col-lg-3 col-sm-3">
                    <label class="form-label">Capture/Upload ID Back</label>
                   <input type="file" name="id_back[]" class="form-control">
				   <div id="show_proprietoredit_id_back_image"></div>
               </div>
               <div class="col-md-3 col-lg-3 col-sm-3">
                    <label class="form-label">Capture/Upload Image</label>
                   <input type="file" name="upload_image[]" class="form-control">
				   <div id="show_proprietoredit_upload_image"></div>
               </div>
           </div>

           <div class="row mt-4">
                 <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="authorized_person_name[]" placeholder="Full Name" id="proprietoredit_full_name">
                    </div>
                    
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="authorized_person_id[]" placeholder="ID Number" id="proprietoredit_id_number">
                    
                    </div>
                    
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="date" class="form-control" name="authorized_person_id_expiry_date[]" placeholder="ID Expiry Date" id="proprietoredit_id_expiry_date">
                    </div>
                    
                </div>

           </div>

           <div class="row">
                 <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="authorized_person_gender[]" placeholder="Gender" id="proprietoredit_gender">
                    </div>
                    
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                       <input type="text" class="form-control" name="authorized_person_nationality[]" placeholder="Nationality" id="proprietoredit_nationality">
                    </div>
                    
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="date" class="form-control" name="authorized_person_dob[]" placeholder="Date Of Birth" id="proprietoredit_dob">
                    </div>
                    
                </div>

           </div>

           <div class="row">
                 <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="authorized_person_mob[]" placeholder="Mobile Number" id="proprietoredit_mobile_number">
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
                  
                   <input type="email" name="authorized_person_email[]" class="form-control" placeholder="Email Id" id="proprietoredit_email">
               </div>
               <div class="col-md-3 col-lg-3 col-sm-3">
                    
                   <input type="text" name="authorized_person_designation[]" class="form-control" placeholder="Designation" id="proprietoredit_designation">
               </div>
               <div class="col-md-3 col-lg-3 col-sm-3">
                   <input type="text" name="authorized_person_country_of_birth[]" class="form-control" placeholder="Country_of_birth" id="proprietoredit_country_of_birth">
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
			
			
			
			
			
				<div class="card">
					<div class="card-body p-6">
						<form id="imageUploadForm" method="post">
           <div class="col-md-12 col-lg-12 col-sm-12">
            <div class="row mt-4">
                 <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
						<input type="hidden" name="id" value="<?=$this->uri->segment(3)?>" id="id">
                        <input type="text" class="form-control" name="business_name" placeholder="Company Name" id="business_name">
                    </div>
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
						<input type="text" class="form-control" name="trade_license_number" placeholder="Trade License Number" id="trade_license_number">
                       
                    </div>
                    
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="trade_license_place" placeholder="Trade License Place" id="trade_license_place">
                    </div>
                    
                </div>

                 <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="date" class="form-control" name="trade_licence_date" placeholder="Trade License Date" id="trade_license_date">
                    </div>
                    
                </div>
           </div>

           <div class="row">
                 <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                       <input type="text" class="form-control" name="type_of_establishment" placeholder="Type Of Establishment" id="type_of_establishment">
                    </div>
                    
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="registered_address" placeholder="Registered Address" id="registered_address">
                    </div>
                    
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="date" class="form-control" name="establishment_date" placeholder="Establishment Date" id="establishment_date">
                    </div>
                    
                </div>

                 <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                       <input type="text" class="form-control" name="mobile_number" placeholder="Mobile Number" id="mobile_number">
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
                        <input type="text" class="form-control" name="email" placeholder="Email" id="email">
                    </div>
                    
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="fax" placeholder="FAX" id="fax">
                    </div>
                    
                </div>

                 <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                       <input type="text" class="form-control" name="country" placeholder="Country" id="country">
                    </div>
                    
                </div>
           </div>

<div class="row">
                 <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="website" placeholder="Website" id="website">
                    </div>
                    
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="tax_no" placeholder="TAX NO" id="tax_no">
						
                     
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
								<td><input type="checkbox" name="apply_all_time">&nbsp;&nbsp;Apply All</td>
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
                <h4>Company Authorized</h4>
                <h4>Person Details</h4>
				<button type="button" class="btn btn-primary" id="open_add_authorize_model">
				  Add Another Person
				</button>
            </div>
          </div>
		  
		  <div id="show_autorise_person_details">
		  
		  </div>
		  
          

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
			   <div class="col-lg-12 col-md-12 col-sm-12 col-12" id="approve_or_reject"></div>
           </div>

         </div>
       </div>
         </div>
        </form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
require_once('footer.php');
?>

<script>
		$('document').ready(function(){
			get_user_details();
			get_company_details();
			get_rest_opening_closing_time();
			get_authorise_person_details();
			
			get_proprietor_details();
			
			step_two_status();
		});
		
		function step_two_status(){
			var id = $('#id').val();
			$.ajax({
				url:"<?=base_url()?>onboarding/get_step_one_status",
				type: "POST",
				data: {id:id},
				dataType:'json',
				success: function(data){
					var html ='';
					if(data[0].step_one_status == 'Approved'){
						html+='<button type="button" class="btn btn-primary" data-id="'+id+'" data-status="Approved" disabled>Approved</button>';
					}
					
					if(data[0].step_one_status == 'Rejected'){
						html+='<button type="button" class="btn btn-danger" data-id="'+id+'" data-status="Reject" disabled>Rejected</button>';
					}
					
					if(data[0].step_two_status == '' || data[0].step_one_status == null){
						html+='<button type="button" class="btn btn-primary change_status" data-id="'+id+'" data-status="Approved">Approve</button>\
			<button type="button" class="btn btn-danger change_status" data-id="'+id+'" data-status="Rejected">Reject</button>';
					}
					
					$('#approve_or_reject').html(html);
				}	        
			});
			
		}
		
		$('body').on('click','.change_status',function(){
			var id = $(this).attr('data-id');
			var status = $(this).attr('data-status');
			if(status == 'Approved'){
				var text = 'Approve step first';
			}else{
				var text = 'Reject step first';
			}
			swal({
            title: 'Are you sure ?',
            text: text,
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, '+status+'!',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false
			},function (isConfirm) {
				if(isConfirm){
				$.ajax({
					url: "<?=base_url()?>onboarding/change_status_step_one/",
					type:'POST',
					dataType: 'json',
					data: {id:id,status:status},
					success: function(response){
						location.reload();
					}
				});
				}
				 
			}, function (dismiss) {
				if (dismiss === 'cancel') {
					swal(
					  'Cancelled',
					  'Your record is safe :)',
					  'error'
					)
				}
			});
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
						swal({
            title: '',
            text: data.msg,
            type: 'success',
            showCancelButton: false,
            confirmButtonColor: '#05C76B',
            cancelButtonColor: '#d33',
            confirmButtonText: 'OK',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false
            },function (isconfirm) {
                if(isconfirm){
                    window.location.href="<?=base_url('admin/admin_onboarding_step2/')?>"+$('#id').val();
                }
                
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
						swal({
            title: '',
            text: data.msg,
            type: 'success',
            showCancelButton: false,
            confirmButtonColor: '#05C76B',
            cancelButtonColor: '#d33',
            confirmButtonText: 'OK',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false
            },function (isconfirm) {
                if(isconfirm){
					location.reload();
                }
                
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
						swal({
            title: '',
            text: data.msg,
            type: 'success',
            showCancelButton: false,
            confirmButtonColor: '#05C76B',
            cancelButtonColor: '#d33',
            confirmButtonText: 'OK',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false
            },function (isconfirm) {
                if(isconfirm){
                    location.reload();
                }
                
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
						swal({
            title: '',
            text: data.msg,
            type: 'success',
            showCancelButton: false,
            confirmButtonColor: '#05C76B',
            cancelButtonColor: '#d33',
            confirmButtonText: 'OK',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false
            },function (isconfirm) {
                if(isconfirm){
                   location.reload();
                }
                
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
						swal({
            title: '',
            text: data.msg,
            type: 'success',
            showCancelButton: false,
            confirmButtonColor: '#05C76B',
            cancelButtonColor: '#d33',
            confirmButtonText: 'OK',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false
            },function (isconfirm) {
                if(isconfirm){
                    location.reload()
                }
                
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
	
	<!--<script async
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBxKa2VpgIKupeiBVaoAFpi1wrUsP8__gM&libraries=places&callback=initMap">
</script>-->

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&key=AIzaSyBxKa2VpgIKupeiBVaoAFpi1wrUsP8__gM&libraries=places"></script>
<!--
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&key=AIzaSyDCA8TkShdYJDMaOjbIYyabFUMY3QzNWvQ&libraries=places"></script>
-->
<script>
google.maps.event.addDomListener(window, 'load', initialize);
function initialize() {
var input = document.getElementById('venue_address');
var autocomplete = new google.maps.places.Autocomplete(input);
autocomplete.addListener('place_changed', function () {
var place = autocomplete.getPlace();
// place variable will have all the information you are looking for.
 
  document.getElementById("latitude").value = place.geometry['location'].lat();
  document.getElementById("longitude").value = place.geometry['location'].lng();
  
});
}
</script>