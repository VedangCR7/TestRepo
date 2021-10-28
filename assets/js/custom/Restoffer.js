var Restoffer ={
    base_url:null,
    init:function() {
        this.bind_events();
        var data={
            per_page:'all',
            page:1
        }
        this.listoffer(data);
    },

    bind_events :function() {
        var self=this;
        $('#searchInput').on('keyup',function(){
           
             if($(this).val()==""){
                var data={
                    per_page:$('.dropdown-toggle').attr('selected-per-page'),
                    page:1
                }
                Restoffer.listoffer(data,'fromsearch');
            }else{
                if($(this).val().length>=3){
                    var data={
                        per_page:'all',
                        page:1,
                        searchkey:$('#searchInput').val()
                    }
                    Restoffer.listoffer(data,'fromsearch');
                }
            }
        });

        $('#offers').on('change',function(){
            if (this.checked) {
            $(".perticularoffers").each(function() {
                this.checked=true;
            });
        } else {
            $(".perticularoffers").each(function() {
                this.checked=false;
            });
        }

        });

        

        
        $('#applybulkaction').on('click',this.onbulkaction);

        $('.tbody-group-list').on('click','.input-switch-box',this.changeStatusManager);
        // $('.tbody-group-list').on('click','.a-delete-group',this.onDeleteManager);

        $('.tbody-group-list').on('click','.a-edit-group',this.onEditManager);
        $('.edit_manager').on('click','.closeedit',this.oncancelEditManager);
        $('.edit_manager').on('click','.editperticular_manager',this.onEditPerticularManager);
        $('.btn-add-group').on('click',this.onSaveoffer);

        // $('.edit_manager').on('click','.toggle-password',this.onshowpassword);

        $('.tbody-group-list').on('click','.img-upload',function(){
            $(this).closest('tr').find('.imgupload').trigger('click');
        });
        $('.tbody-group-list').on('change','.imgupload',this.onImageUpload);

        $('.addnewoffer').on('click','.img-upload1',function(){
            $(this).closest('div').find('.imgupload').trigger('click');
        });

        $('.addnewoffer').on('change','.imgupload',this.onImageload);



        $('#AddMenuGroup').on('keypress',function(e){
            //var string = string.replace(/\s\s+/g, ' ');
           /* var singleSpacesString=$(this).val().replace(/  +/g, ' ');
            $(this).val(singleSpacesString);*/
            var regex = new RegExp("^[a-zA-Z0-9_~!@#$%&*^()`~':.?,;{}|<> ]+$");
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
            if (regex.test(str)) {
                return true;
            }
            e.preventDefault();
            return false;
        });

        $('#status').on('change',this.onselectstatus);

    },

    onselectstatus:function(){
        var data={
            per_page:'all',
            page:1,
            status:$('#status').val()
        }
        Restoffer.listoffer(data);
    },

    onbulkaction:function(){
        var bulkaction = $('#bulkaction').val();
        if (bulkaction == '') {
            Restoffer.displaywarning("Choose Bulk Action"); 
            return false;
        }
        var offer_id = [];
        $('input[name="perticularoffers"]').each(function(){
            if($(this).is(':checked')){
                offer_id.push($(this).val());
            }
        });
        if (offer_id.length == 0) {
            Restoffer.displaywarning("Select Atleast one offer"); 
            return false;
        }
        $.ajax({
                    url: Restoffer.base_url+"restaurantoffer/bulkaction",
                    type:'POST',
                    dataType: 'json',
                    data: {
                        offer_id : offer_id,
                        bulkaction : bulkaction
                    },
                    success: function(result){
                        $('#image-loader').hide();
                        if (result.status) {
                                Restoffer.displaysucess(result.msg);
                                var data={
                                    per_page:'all',
                                    page:1
                                }
                                Restoffer.listoffer(data);
                        
                        }else{
                        Restoffer.displaywarning("Something Went Wrong");
                        }
                    }
                });
    },

    onImageload:function(event){
        var bind_input=$(this);
        if($(this).val()==""){
              /*  displaywarning('please select file to upload.');*/
                return false;
            }
        var ext = $(this).val().split('.').pop().toLowerCase();
            if($.inArray(ext, ['jpg','jpeg','png']) == -1) {
                Restoffer.displaywarning('invalid extension!');
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
                    Restoffer.displaywarning("File size is too big. please select the file less than 1MB.");
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
                                $('#is_image_upload').html('<input type="hidden" name="offer_photo" value="'+imageData+'" id="offer_photo">');
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
                Restoffer.displaywarning("Your browser does not support File API");  
                $("#cropbox").attr('src','');
                $('#image-loader').hide();
            }  
    },

    onImageUpload:function(event){
        var bind_input=$(this);
        if($(this).val()==""){
              /*  displaywarning('please select file to upload.');*/
                return false;
            }
        var group_id=$(this).attr('group-id');
        var ext = $(this).val().split('.').pop().toLowerCase();
            if($.inArray(ext, ['jpg','jpeg','png']) == -1) {
                Restoffer.displaywarning('invalid extension!');
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
                    Restoffer.displaywarning("File size is too big. please select the file less than 1MB.");
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
                               
                                $form_data.append('image', imageData);
                               /* self.closest('td').find('.img-upload').attr('data-image-src',imageData);
                                self.closest('td').find('.img-upload').css("background", "url(" + imageData + ")");*/
                                $form_data.append('id',group_id);
                                $.ajax({
                                    url: Restoffer.base_url+"restaurantoffer/update_offer_photo",
                                    type:'POST',
                                    data: $form_data,
                                    processData:false,
                                    contentType:false,
                                    cache:false,
                                    success: function(result){
                                        $('#image-loader').hide();
                                        if (result.status) { 
                                           /* self.closest('td').find('.img-upload').attr('data-image-src',Menugrouplist.base_url+result.path);
                                            self.closest('td').find('.img-upload').css("background", "url(" + Menugrouplist.base_url+result.path + ")");*/
                                        } 
                                        else{
                                            if(result.msg){
                                                Restoffer.displaywarning(result.msg);
                                            }
                                            else
                                                Restoffer.displaywarning("Something went wrong please try again");
                                        }
                                        $('#image-loader').hide();
                                        var data={
                                            per_page:'all',
                                            page:1
                                        }
                                        Restoffer.listoffer(data);
                                    }
                                });
                            }
                            else{

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
                Restoffer.displaywarning("Your browser does not support File API");  
                $("#cropbox").attr('src','');
                $('#image-loader').hide();
            }  
    },



    changeStatusManager:function(){
        if($(this).is(':checked')){
            $(this).val("on");
            Restoffer.displaysucess("Offer is Active now");}
        else{
            $(this).val("off");
            Restoffer.displaysucess("Offer is Inactive now");
        }
        var getsts = $('#status').val();
        console.log(getsts);
        var self=this;
        var data_id=$(this).attr('data-id');
        var formData={
            id : data_id,
            status:$(this).val()
        }

        $.ajax({
            url: Restoffer.base_url+"restaurantoffer/delete_offer",
            type:'POST',
            data:formData ,
            success: function(result){
               if (result.status) {
                //Restoffer.displaysucess("Status Changed successfully");
                    var data={
                        status:getsts,
                        per_page:'all',
                        page:1,
                        status:$('#status').val()
                    }
                   Restoffer.listoffer(data);
               }
               else{
                    Restoffer.displaywarning("Something went wrong please try again");
               }
            }
        });
    },

    oncancelEditManager:function(){
        $('.edit_manager').hide();
    },

    onEditManager:function(){
        $("html").animate({ scrollTop: 0 }, "slow");
        var self=this;
        var data_id=$(this).attr('data-id');
        var html = '';
        var formData={
                id : data_id
            } 
            $.ajax({
                url: Restoffer.base_url+"restaurantoffer/show_perticular_order",
                type:'POST',
                data:formData ,
                success: function(result){
                        var data={
                            per_page:'all',
                            page:1
                        }
                       Restoffer.listoffer(data);
                       var html='';
                       html +='<div class="col-md-12">\
            <div class="card welcome-image">\
                <div class="card-body">\
                    <div class="row">\
                        <div class="col-md-11">\
                            <form class="form-recipe-edit" method="post" action="javascript:;">\
                                <div class="row">\
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;">\
                                        <label style="font-weight:bold;">Title</label>\
                                        <input type="text" value="'+result['offer'].title+'" name="title" id="edittitle" class="form-control" placeholder="Offer Title">\
                                    </div>\
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;">\
                                        <label style="font-weight:bold;">Discount Price</label>\
                                        <input type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="'+result['offer'].discount+'" name="discount" id="editdiscount" class="form-control" placeholder="Enter Discount Price">\
                                    </div>\
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;">\
                                        <label style="font-weight:bold;">Add Product</label><br>\
                                        <select class="select2-show-search form-control" id="edititem" data-placeholder="Choose Product" style="width:100%;">';
                                            html +='<option value="">Select Product</option>';
                                            const items = result['items'];
                                            for(var i=0; i<items.length;i++){
                                                if (items[i].id == result['offer'].recipe_id) {
                                                    html+='<option value="'+items[i].id+'" selected>'+items[i].name+'</option>';
                                                }
                                                else{
                                                    html+='<option value="'+items[i].id+'">'+items[i].name+'</option>';
                                                }
                                            }
                                        html +='</select>\
                                    </div>\
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12" style="margin-top:10px;">\
                                        <label style="font-weight:bold;">Description</label>\
                                        <textarea class="form-control" id="editdescription" placeholder="Description">'+result['offer'].description+'</textarea>\
                                    </div>\
                                </div>\
				<div class="row">\
					<div class="col-lg-4 col-md-4 col-sm-12 col-12">\
						<label style="font-weight:bold;margin-top:10px;">Start Date</label>\
						<input type="date" id="edit_start_date" class="form-control" value="'+result['offer'].start_date+'">\
					</div>\
					<div class="col-lg-4 col-md-4 col-sm-12 col-12">\
						<label style="font-weight:bold;margin-top:10px;">End Date</label>\
						<input type="date" id="edit_end_date" class="form-control" value="'+result['offer'].end_date+'">\
					</div>\
				</div>\
                                <div class="row">\
                                    <div class="col-md-12 text-right">\
                                        <button type="button" class="btn btn-default closeedit" id="closeedit" style="background-color: #ede3e7;;border: 0px !important;float:right;margin-left:10px;margin-top: 1rem;">Cancel</button>\
                                        <button type="submit" data-id="'+result['offer'].id+'" class="btn btn-secondary btn-save-details editperticular_manager" type="button" style="background-color: #ED3573;border: 0px !important;float:right;margin-top:10px;margin-top: 1rem;">Save Changes</button>\
                                    </div>\
                                </div>\
                            </form>\
                        </div>\
                    </div>\
                </div>\
            </div>\
        </div>';
                       $('.edit_manager').html(html);
                       $('.edit_manager').show();
                       $(".addnewoffer").hide();
                }
            });
    },

    onEditPerticularManager:function(){
        if ($('#edittitle').val()=='') {Restoffer.displaywarning("Offer Title is Required");return false;}
        if ($('#editdiscount').val()=='') { Restoffer.displaywarning("Offer Discount is Required");return false;}
        if ($('#edititem').val()=='') { Restoffer.displaywarning("Offer Item is Required");return false;}
	if ($('#edit_start_date').val()=='') { Restoffer.displaywarning("Offer start date is Required");return false;}
	if ($('#edit_end_date').val()=='') { Restoffer.displaywarning("Offer end date is Required");return false;}

        var self=this;
        var data_id=$(this).attr('data-id');
                var formData={
                id : data_id,
                title : $('#edittitle').val(),
                discount : $('#editdiscount').val(),
                recipe_id : $('#edititem').val(),
                description : $('#editdescription').val(),
		start_date : $('#edit_start_date').val(),
		end_date : $('#edit_end_date').val()
            } 
            $.ajax({
                url: Restoffer.base_url+"restaurantoffer/edit_perticular_offer",
                type:'POST',
                data:formData ,
                success: function(result){
                   if (result.status) {
                        var data={
                            per_page:'all',
                            page:1
                        }
                        $('.edit_manager').hide();
                        Restoffer.displaysucess("Information Save successfully");
                       Restoffer.listoffer(data);
                   }
                   else{
                       if(result.msg){
                        Restoffer.displaywarning(result.msg);
                       }
                       else{
                        Restoffer.displaywarning("Something went wrong please try again");}
                   }
                }
            });
    },

    onDeleteManager:function(){
        var self=this;
        var data_id=$(this).attr('data-id');
        var title='Are you sure ?';
        var text="Delete Waitinglist Manager";
        swal({
            title: title,
            text: text,
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33 !important',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false
        },function () {
            var formData={
                id : data_id
            } 
            $.ajax({
                url: Waitingmanager.base_url+"Waiting_manager/delete_perticular_waitinglist_manager",
                type:'POST',
                data:formData ,
                success: function(result){
                   if (result.status) {
                        Waitingmanager.displaysucess("Delete successfully");
                        var data={
                            per_page:'all',
                            page:1
                        }
                       Waitingmanager.listmanager(data);
                   }
                   else{
                        Waitingmanager.displaywarning("Something went wrong please try again");
                   }
                }
            });
        }, function (dismiss) {
            if (dismiss === 'cancel') {
                swal(
                  'Cancelled',
                  'Your record is safe :)',
                  'error'
                )
            }
        });
       
    },

    onSaveoffer:function()
	{
		debugger;
		if ($('#title').val()=='') {Restoffer.displaywarning("Offer Title is Required");return false;}
		if ($('#discount').val()=='') { Restoffer.displaywarning("Offer Discount is Required");return false;}
		if ($('#item').val()=='') { Restoffer.displaywarning("Offer Item is Required");return false;}
		
		if ($('#start_date').val()=='') { Restoffer.displaywarning("Offer Start Date is Required");return false;}
		if ($('#end_date').val()=='') { Restoffer.displaywarning("Offer End Date is Required");return false;}
		
		if ($('#offer_photo').val() != '')
		{
			$('#image-loader').show();
			$.ajax({
				url: Restoffer.base_url+"restaurantoffer/add_offer_photo",
				type:'POST',
				dataType: 'json',
				data: {
					title : $('#title').val(),
					discount: $('#discount').val(),
					recipe_id : $('#item').val(),
					image: $('#offer_photo').val(),
					description : $('#description').val(),
					start_date:$('#start_date').val(),
					end_date:$('#end_date').val()
				},
				success: function(result)
				{
					$('#image-loader').hide();
					if (result.status) 
					{
						Restoffer.displaysucess("Offer created successfully");
						var data={
							per_page:'all',
							page:1
						}
						$('#title').val('');
						$('#description').val('');
						$('#discount').val('');
						$('#item').val('');
						$('#select2-item-container').text('Choose Product');
						$('#offer_photo').val('');
						$('#my_image').attr('src',Restoffer.base_url+'assets/images/offer.png');
						Restoffer.listoffer(data);
						$('.btn-add-group').html('Save');					
					}
					else
					{
						Restoffer.displaywarning(result.msg);
					}
				}
			});
		}
		else
		{
			$.ajax({
				url: Restoffer.base_url+"restaurantoffer/save_offer",
				type:'POST',
				dataType: 'json',
				data: {
					title : $('#title').val(),
					discount: $('#discount').val(),
					recipe_id : $('#item').val(),
					image: $('#offer_photo').val(),
					description : $('#description').val(),
					start_date:$('#start_date').val(),
					end_date:$('#end_date').val()
				},
				success: function(result)
				{
					console.log(result);
					$('#image-loader').hide();
					if (result.status) 
					{
							Restoffer.displaysucess("Offer created successfully");
							var data={
								per_page:'all',
								page:1
							}
							$('#title').val('');
							$('#description').val('');
							$('#discount').val('');
							$('#item').val('');
							$('#select2-item-container').text('Choose Product');
							
							Restoffer.listoffer(data);
						$('.btn-add-group').html('Save');
					
					}
					else
					{
						Restoffer.displaywarning(result.msg);
					}
				}
			});
		}
    },
    
    listoffer:function(data,fromevent){
        
        $.ajax({
            url: Restoffer.base_url+"restaurantoffer/list_offer/",
            type:'POST',
            dataType: 'json',
            data: data,
            success: function(response){
                var managers=response.offer;
                var html="";
                var j=1;
                for (i in managers) {

                    html+='<tr menu-id="'+managers[i].id+'">\
                            <td><input type="checkbox" value="'+managers[i].id+'" name="perticularoffers" class="perticularoffers"></td>\
                            <td>'+ j +'</td>';
                            if(managers[i].offer_image==null || managers[i].offer_image == ''){
                                html+='<td title="Browse">\
                                    <input type="file" group-id="'+managers[i].id+'" class="imgupload" accept="image/jpeg, image/png" style="display:none"/>\
                                    <img class="img-upload rounded-circle"  src="'+Restoffer.base_url+'assets/images/offer.png" style="height:50px;width:50px;">\
                                    </td>';
                            }
                            else{
                                 html+='<td title="Browse">\
                                     <input type="file" group-id="'+managers[i].id+'" class="imgupload" accept="image/jpeg, image/png" style="display:none"/>';
                                    if(managers[i].offer_image=="assets/images/users/user.png")
                                        html+='<img class="img-upload rounded-circle" src="'+Restoffer.base_url+managers[i].offer_image+'" style="height:50px;width:50px;"></td>';
                                    else
                                        html+='<img class="img-upload rounded-circle" src="'+managers[i].offer_image+'" style="height:50px;width:50px;"></td>';
                            }
                            html+='<td>'+managers[i].title+'</td>\
                            <td>'+managers[i].name+'</td>\
                            <td>'+managers[i].description+'</td>\
				<td>';
				if(managers[i].start_date !=null){
					html+=managers[i].start_date;
				}
			html+='</td>\
			<td>';
				if(managers[i].end_date !=null){
				html+=managers[i].end_date;
				}
			html+='</td>\
                            <td class="text-center">\
                                <label class="custom-switch pl-0">';
                                if(managers[i].status==1)
                                    html+='<input type="checkbox" name="custom-switch-checkbox" data-id="'+managers[i].id+'" class="custom-switch-input input-switch-box" checked>';
                                else
                                    html+='<input type="checkbox" name="custom-switch-checkbox" data-id="'+managers[i].id+'" class="custom-switch-input input-switch-box">';
                                    html+='<span class="custom-switch-indicator"></span>\
                                </label>\
                            </td>\
                            <td>\
                            <a class="a-edit-group" data-id="'+managers[i].id+'" style="color:green;cursor: pointer;"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\
                            </td>\
                        </tr>';
                        j=j+1;
                }
		Restoffer.inactiveoffers();
                $('.tbody-group-list').html(html);
                $('.span-all-groups').html(response.total_count);
                $('.span-page-html').html(response.page_total_text);
                if(parseInt(response.page_no)>1){
                    var prev_page=parseInt(response.page_no)-1;
                    $('.btn-prev').attr('page-no',prev_page);
                    $('.btn-prev').removeAttr('disabled');
                }else{
                    $('.btn-prev').attr('disabled',true);
                     $('.btn-prev').prop('disabled', true);
                    
                }
                

                if(parseInt(response.page_no)<parseInt(response.total_pages)){
                    var next_page=parseInt(response.page_no)+1;
                    $('.btn-next').attr('page-no',next_page);
                    $('.btn-next').removeAttr('disabled');
                }else{
                     $('.btn-next').attr('disabled',true);
                     $('.btn-next').prop('disabled', true);
                }

                $('#offers').prop('checked',false);

                $('.perticularoffers').on('change',function(){
                    var chkcount = 0;
                    var ttllength = $(".perticularoffers").length;
                    $(".perticularoffers").each(function() {
                        if(this.checked){
                            chkcount++;
                        }
                        
                    });
                                       
                    if(chkcount == ttllength){
                        $('#offers').prop('checked',true);
                    }else{
                        $('#offers').prop('checked',false);
                    }
                });
            }
        });
    },


	inactiveoffers:function(){

		$.ajax({
                    url: Restoffer.base_url+"restaurant/inactiveoffers",
                    type:'POST',
                    dataType: 'json',
                    success: function(result){
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