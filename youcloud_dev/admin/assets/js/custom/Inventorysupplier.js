var Inventorysupplier ={
    base_url:null,
    init:function() {
        this.bind_events();
    },

    bind_events :function() {
        var self=this;

        $('.imgtrigger').on('click','.img-upload1',function(){
            $(this).closest('div').find('.imgupload').trigger('click');
        });

        $('.imgtrigger').on('change','.imgupload',this.onImageload);
        
        $('.btn-add-group').on('click',this.onSaveGroupname);

    },


    onImageload:function(event){
        var bind_input=$(this);
        if($(this).val()==""){
              /*  displaywarning('please select file to upload.');*/
                return false;
            }
        var group_id=$(this).attr('group-id');
        var ext = $(this).val().split('.').pop().toLowerCase();
            if($.inArray(ext, ['jpg','jpeg','png']) == -1) {
                Inventorysupplier.displaywarning('invalid extension!');
                return false;
            }

            var self=this;
            var $form_data = new FormData();
            var inputFile = $(this);   
            if(inputFile){   
                var fileToUpload = inputFile[0].files[0];
                if (fileToUpload != 'undefined') {
                    $form_data.append('image', fileToUpload);
                }
            }
            const target = event.target
            if (target.files && target.files[0]) {
                //allow less than 1mb
                const maxAllowedSize = 1 * 1024 * 1024;
                if (target.files[0].size > maxAllowedSize) {
                // Here you can ask your users to load correct file
                    $('#image-loader').hide();
                    Waitingmanager.displaywarning("File size is too big. please select the file less than 1MB.");
                    return false;
                }
            }
           
            var defaults = {  
                maxWidth: Number.MAX_VALUE,  
                maxHeigt: Number.MAX_VALUE,  
                onImageResized: null  
            }  
            var options={
                maxWidth: 200,
                maxHeigt:121
            }
            var settings = $.extend({}, defaults, options); 
            
            if (window.File && window.FileList && window.FileReader) {
                var files = event.target.files;  
                var file = files[0];  
                /*if (!file.type.match('image')) continue;  */
                var picReader = new FileReader();  
                picReader.addEventListener("load", function (event) {

                    var picFile = event.target;  
                    var imageData = picFile.result;  
                    var img = new Image();  
                    img.src = imageData;  
                    img.onload = function () { 

                        swal({
                            title: 'File requirement :',
                            text: "JPG, PNG up to 1MB. Minimum pixels required: 200 for width, 200 for height.",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, upload it!',
                            cancelButtonText: 'No, cancel!',
                            confirmButtonClass: 'btn btn-success',
                            cancelButtonClass: 'btn btn-danger',
                            buttonsStyling: false
                        },function (swalstatus) { 
                            if(swalstatus){ 
                                $('#image-loader').show();
                                var canvas = $("<canvas/>").get(0);  
                                canvas.width = 200;  
                                canvas.height = 121;  
                                var context = canvas.getContext('2d');  
                                context.fillStyle = "transparent";
                                context.drawImage(img, 0, 0, 200, 121); 
                                imageData = canvas.toDataURL('image/jpeg',0.8);
                                console.log(imageData);
                                $('#my_image').attr('src',imageData);
                                $('#is_image_upload').html('<input type="hidden" name="company_logo" value="'+imageData+'" id="company_logo">');
                                $('#image-loader').hide();
                            }else{
                                bind_input.val('');
                            }

                        }, function (dismiss) {
                            if (dismiss === 'cancel') {
                               /* swal(
                                  'Cancelled',
                                  'Your record is safe :)',
                                  'error'
                                )*/
                            }
                        });
                    }  
                    img.onerror = function () {  
                         $("#cropbox").attr('src','');
                        $('#image-loader').hide();
                       
                    }  
                });  
                //Read the image  
                picReader.readAsDataURL(file);  
            } else {  
                Inventorysupplier.displaywarning("Your browser does not support File API");  
                $("#cropbox").attr('src','');
                $('#image-loader').hide();
            }  
    },


    onSaveGroupname:function()
	{
        if($('#company_name').val() == ''){ Inventorysupplier.displaywarning("Company Name is required"); return false; }
        if($('#company_address').val() == ''){ Inventorysupplier.displaywarning("Company Address is required"); return false; }
        if($('#email').val() == ''){ Inventorysupplier.displaywarning("Email is required"); return false; }
        if($('#contact_person_name').val() == ''){ Inventorysupplier.displaywarning("contact person name is required"); return false; }
        if($('#mobile').val() == ''){ Inventorysupplier.displaywarning("Mobile Number is required"); return false; }
        if($('#owner_name').val() == ''){ Inventorysupplier.displaywarning("Owner Name is required"); return false; }
        if($('#company_logo').val() == ''){ Inventorysupplier.displaywarning("Company Logo is required"); return false; }
        if($('#gst_no').val() == ''){ Inventorysupplier.displaywarning("GST Number is required"); return false; }
        if($('#gst_no').val().length!=15){
		Inventorysupplier.displaywarning("GST No should be 15 digit in length"); return false;}
		if (/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test($('#email').val()))
        {
        
        }
		else
		{
            Inventorysupplier.displaywarning("Please Enter Valid Email");
            return false;
        }
		
        $('#image-loader').show();
        
		$.ajax({
            url: Inventorysupplier.base_url+"inventory/save_supplier",
            type:'POST',
            dataType: 'json',
            data: {
                company_name : $('#company_name').val(),
                company_address : $('#company_address').val(),
                email : $('#email').val(),
                gst_no : $('#gst_no').val(),
                contact_person_name : $('#contact_person_name').val(),
                mobile : $('#mobile').val(),
                owner_name : $('#owner_name').val(),
                company_logo : $('#company_logo').val()
            },
            success: function(result)
			{
				console.log(result);
                $('#image-loader').hide();
				
                if (result.status) 
				{
                    Inventorysupplier.displaysucess("Supplier created successfully");
                    $('#company_name').val(''),
                    $('#company_address').val(''),
                    $('#email').val(''),
                    $('#gst_no').val(''),
                    $('#contact_person_name').val(''),
                    $('#mobile').val(''),
                    $('#owner_name').val(''),
                    $('#company_logo').val('')
					$('#my_image').attr('src',Inventorysupplier.base_url+'assets/images/users/user.png')
                }
				else
				{
                    Inventorysupplier.displaywarning(result.msg);
                }
            }
        });
    },
	
    displaysucess:function(msg)
    {
        swal("Success !",msg,"success");
    },

    displaywarning:function(msg)
    {
        swal("Error !",msg,"error");
    },

};