var storePath = [];
    function upolad_photo(id) {

        var imgwidth = 0;
        var imgheight = 0;
        var maxwidth = 600;
        var maxheight = 340;

        $('#photo1').css('border-color','#e5e1dc');

          var imagefile = document.getElementById("photo"+id); 

          var selectedFile = imagefile.files[0]; 
          var fileName = selectedFile.name;

          var Extension = fileName.substr((fileName.lastIndexOf('.') + 1));

          if (Extension == "png" || Extension == "jpeg" || Extension == "jpg" || Extension == "gif") 
          {

            var today = new Date();
            var date = today.getDate() + '-' + (today.getMonth() + 1) + '-' + today.getFullYear();
            var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
            var dateTime = date + ' ' + time;

            // if(selectedFile.size <= 500000) 
            // {
              var _URL = window.URL || window.webkitURL;
              img = new Image();

              img.src = _URL.createObjectURL(selectedFile);
              img.onload = function()
              {
                imgwidth = this.width;
                imgheight = this.height;

                $('#gif').css('display','block');
                $('#add_recipe').css('display','none');
              
                // if(imgwidth <= maxwidth && imgheight <= maxheight)
                // {
                  // make ref to your firebase storage and select images folder 
                  var storageRef = firebase.storage().ref('/recipe/' + date + '/' + dateTime + fileName); 
          
                  // put file to firebase  
                  var uploadTask = storageRef.put(selectedFile); 
          
                  uploadTask.on('state_changed',
                    function progress(snapshot) {
                        // var prog = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
                        // progressBar.value = prog;
                        // $("#progressBar").show();
                  }, function(error) { 
                    console.log(error);
                    toastr.error('Image storage quota has been exceeded');
                    $('#gif').css('display','none');
                    $('#add_recipe').css('display','block');
                    $("#photo"+id).val('');
                }, 
                  function() { 
                        // get the uploaded image url back 
                        uploadTask.snapshot.ref.getDownloadURL().then( 
                        function(downloadURL) { 
                        //console.log('File available at', downloadURL); 
                        storePath.push(downloadURL);
                        $('#recipe_photo').val(storePath); 
                        $('#gif').css('display','none');
                        $('#add_recipe').css('display','block');
                    }); 
                  }); 
                // } else {
                //   toastr.error("Image size must be "+maxwidth+" X "+maxheight, "Error");
                // }
              } 
          // } else {
          //       $('#photo'+id).val("");
          //       toastr.error('Image size needs be less than equal to 500kb.', 'Error');
          //   }
          } else {
                 $('#photo'+id).val("");
                 toastr.error('Image allows file types of  PNG, JPG, GIF and JPEG.', 'Error');
        }
    }

var Recipe = {
   base_url: null,
    init: function() {
         this.bind_events();
         this.load_categories();
        
    },
      bind_events: function() {

        var self = this;
        $("#add_recipe").on('click', function(event) {
            
            event.preventDefault();

            var recipe_name = $('#recipe_name').val();
            var preparation_time = $('#preparation_time').val();
            var serve = $('#serve').val();
            var recipe_type = $('#recipe_type').val();
            var category_id = $('#category_id').val();
            var description = $('#description').val();
            var youtube_url = $('#youtube_url').val();
            var chef_name = $('#chef_name').val();
            var ingredients1 = $('#ingredients1').val();
            var para = $('#parameter1').val();
            var qty1 = $('#qty1').val();
            var steps1 = $('#steps1').val();
            var inst = $('#instruction1').val();
            var photo = $('#photo1').val();

            if(recipe_name == '')
            {   
                $('#recipe_name').focus();
                $('#recipe_name').css('border-color','#ff0505');
                //toastr.error('Recipe Name is required.');   
            } else if(preparation_time == '')
            {
                $('#preparation_time').focus();
                $('#preparation_time').css('border-color','#ff0505');
                //toastr.error('Preparation Time is required.');   
            } else if(serve == '')
            {
                $('#serve').focus();
                $('#serve').css('border-color','#ff0505');
               // toastr.error('Number of People Served is required.');   
            } else if(recipe_type == '')
            {
                $('#recipe_type').focus();
                $('#recipe_type').css('border-color','#ff0505');
               // toastr.error('Recipe Type is required.');   
            } else if(category_id == '')
            {
                $('#category_id').focus();
                $('#category_id').css('border-color','#ff0505');
               // toastr.error('Please Select Category.');   
            } else if(description == '')
            {
                $('#description').focus();
                $('#description').css('border-color','#ff0505');
                //toastr.error('Add a description to the recipe');   
            }  else if(chef_name == '')
            {
                $('#chef_name').focus();
                $('#chef_name').css('border-color','#ff0505');
                //toastr.error('Chef name required.');  
            } 
            // else if(youtube_url == '')
            // {
            //     toastr.error('All field is required.');   
            // } 
             else if(ingredients1 == '')
            {
                $('#ingredients1').focus();
                $('#ingredients1').css('border-color','#ff0505');
                //toastr.error('Please add ingredients');   
            } else if(para == '' && qty1 != '')
            {
                $('#parameter1').focus();
                $('#parameter1').css('border-color','#ff0505');
                //toastr.error('Please select parameter'); 
            }
            else if(para != '' && qty1 == '')
            {
                $('#qty1').focus();
                $('#qty1').css('border-color','#ff0505');
               // toastr.error('Please enter quantity');   
            }
             else if(steps1 == '')
            {
                $('#steps1').focus();
                $('#steps1').css('border-color','#ff0505');
                //toastr.error('Please enter step number');   
            } else if(inst == '')
            {
                $('#instruction1').focus();
                $('#instruction1').css('border-color','#ff0505');
                //toastr.error('Please add instruction');   
            }
            else if(photo == '')
            {
                $('#photo1').focus();
                $('#photo1').css('border-color','#ff0505');
                // toastr.error('Please select recipe photo');   
            } 
            else {

                var count = $('#check_count').val();
                var step_count = $('#step_count').val();

                var check=0;var check2=0;var check3=0;var check4=0;var check5=0;
                for(var i=2;i<=count;i++)
                {
                    
                    var ingredients = $('#ingredients'+i).val();
                    var parameter = $('#parameter'+i).val();
                    var quantity = $('#qty'+i).val();

                    if(ingredients =='' && ingredients !=undefined)
                    {
                        if(check ==0){
                            check=i;
                        }
                    } 
                    if(parameter =='' && quantity !='' && parameter !=undefined && quantity !=undefined)
                    {
                        if(check2 ==0){
                            check2=i;
                        }
                    }
                    if(parameter !='' && quantity =='' && parameter !=undefined && quantity !=undefined)
                    {
                        if(check5 ==0){
                            check5=i;
                        }
                    }
                }
                for(var j=2;j<=step_count;j++)
                {
                    var steps = $('#steps'+j).val();
                    var instruction = $('#instruction'+j).val();

                    if(steps =='' && steps !=undefined)
                    {
                        if(check3 ==0){
                            check3=j;
                        }
                    } 
                    if(instruction =='' && instruction !=undefined)
                    {
                        if(check4 ==0){
                            check4=j;
                        }
                    }  
                }
                
                if(check !=0)
                {
                    $('#ingredients'+check).focus();
                    $('#ingredients'+check).css('border-color','#ff0505');
                }
                else if(check2 !=0)
                {
                    $('#parameter'+check2).focus();
                    $('#parameter'+check2).css('border-color','#ff0505');
                   // toastr.error('Please add parameter');
                }
                else if(check5 !=0)
                {
                    $('#qty'+check5).focus();
                    $('#qty'+check5).css('border-color','#ff0505');
                   // toastr.error('Please add parameter');
                } else if(check3 !=0)
                {
                    $('#steps'+check3).focus();
                    $('#steps'+check3).css('border-color','#ff0505');
                    //toastr.error('Please enter step number');
                } else if(check4 !=0)
                {
                    $('#instruction'+check4).focus();
                    $('#instruction'+check4).css('border-color','#ff0505');
                    //toastr.error('Please enter instruction');
                } else
                {
                    var name = $('#recipe_name').val();
                    name = name.replace(/ /g , "-");
                    name = name.toLowerCase();
                    $('#seo_name').val(name);
                    Recipe.check_recipe();
                }
            }

            // $('form[id="add_recipe_form"]').validate({
            //     rules: {
            //         recipe_name: { required: true },
            //         preparation_time: { required: true },
            //         serve: { required: true },
            //         recipe_type: { required: true },
            //         category_id: { required: true },
            //         description: { required: true },
            //         youtube_url: { required: true },
            //         chef_name: { required: true },
            //         ingredients1: { required: true },
            //         steps1: { required: true },
            //         instruction1: { required: true }
            //     },
            //     messages: {
            //         recipe_name: { required: "This field is required." },
            //         preparation_time: { required: "This field is required." },
            //         serve: { required: "This field is required." },
            //         recipe_type: { required: "This field is required." },
            //         category_id: { required: "This field is required." },
            //         description: { required: "This field is required." },
            //         youtube_url: { required: "This field is required." },
            //         chef_name: { required: "This field is required." },
            //         ingredients1: { required: "This field is required." },
            //         steps1: { required: "This field is required." },
            //         instruction1: { required: "This field is required." }
            //     },
            //     submitHandler: function() {
            //         Recipe.add_recipe();
            //     }
            // });
        });
    },

    check_recipe: function(){
        var self = this;

        var obj = new Object();
        obj.recipe_name=$('#recipe_name').val();
        obj._token= $('#csrf_token').val();

        //console.log(obj);
        $.ajax({
            type: 'post',
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            data: JSON.stringify(obj),
            url: self.base_url + "/check-recipe",
            success: function(data) { 
                //console.log(data);
                var status = data.status;
                if (status == "true") {
                    Recipe.add_recipe();
                }
                else{
                    toastr.info(data.msg);
                }
            }
        });
    },

    load_categories: function() {
        var self = this;
        var string="";
        $.ajax({
            type: 'get',
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            url: self.base_url + "/get-categories",
            success: function(data) {
                //console.log(data);
               string += "<option value=''>Select</option>";

               $.each(data, function(r, row){
                string += "<option value='"+row['id']+"'>"+row['name']+"</option>";
               });
               $('#category_id').html(string);
            }
        });
    },

    add_recipe :function(){

        var ingredients = $('input[name="ingredients[]"]').map(function () {
            return this.value;
        }).get();
        var qty = $('input[name="qty[]"]').map(function () {
            return this.value;
        }).get();

        var result =[];
        var final_result =[];
        var j=ingredients.length-1;
        for(var i=0;i<=j;i++){
            var obj = new Object();
            obj.long_desc=ingredients[i];
            obj.declaration_name=ingredients[i];
            obj.quantity= qty[i];
            result.push(obj);
        }
        
        var imagefile = document.getElementById("photo1"); 
        var selectedFile = imagefile.files[0]; 
        var reader = new FileReader();
        reader.readAsDataURL(selectedFile);
        reader.onload = function () {
        //console.log(reader.result);
        var url=reader.result;
        var imageurl=url.slice(23);

        var obje = new Object();
            obje.name=$('#recipe_name').val();
            obje.quantity_per_serving=$('#serve').val();
            obje.weight_loss= 0;
            obje.total_weight= 100;
            obje.recipe_type= $('#recipe_type').val();
            obje.user_id= 60;
            obje.image64= imageurl;
            obje.ingredients= result;
            final_result.push(obje);

         console.log(final_result);

            $.ajax({
                type: 'post',
                crossDomain: true,
                contentType: 'application/json; charset=utf-8',
                dataType: 'json',
                data: JSON.stringify(final_result),
                url: "http://foodnai.com/api/create_recipe",
                success: function(data) {
                    //console.log(data);
                     var id=0;
                    if(data.status==true){
                        id=data.recipe_id;
                        //console.log(id);
                        Recipe.add_recipe_web(id);
                    } else {
                        Recipe.add_recipe_web(id);
                    }

                }, error: function(err) {
                    console.log(err);
                    var id=0;
                    Recipe.add_recipe_web(id);
                }
            });
        };
        reader.onerror = function (error) {
            console.log('Error: ', error);
        };
    },

    add_recipe_web :function(id){   
        var count = $('#check_count').val();
        var count2 = $('#step_count').val();
        var count3 = $('#count3').val();

        var self = this;
        var token= $('#csrf_token').val();
        var data = new FormData();
        var form_data = $('#add_recipe_form').serializeArray();
        $.each(form_data, function (key, input) {
            data.append(input.name, input.value);
        });
        data.append('foodnai_recipe_id', id);
        console.log(id);

        $.ajax({
            headers: {'X-CSRF-TOKEN': token},
            url: self.base_url + "/add-recipe-web",
            method: "post",
            dataType: 'json',
            processData: false,
            contentType: false,
            data: data,
            success: function(data) {
                
                if(data.status == 'success')
                {
                    $('#recipe_name').val('');
                    $('#seo_name').val('');
                    $('#preparation_time').val('');
                    $('#serve').val('');
                    $('#recipe_type').val('');
                    $('#category_id').val('');
                    $('#description').val('');
                    $('#youtube_url').val('');
                    $('#chef_name').val('');
                    $('#ingredients1').val('');
                    $('#parameter1').val('');
                    $('#qty1').val('');
                    $('#steps1').val('1');
                    $('#instruction1').val('');
                    $('#photo1').val('');

                    for(var i=2;i<=count;i++)
                    {
                        $('#remove_row'+i).remove();
                    }
                    for(var j=2;j<=count2;j++)
                    {
                        $('#remove_step'+j).remove();
                    }
                    for(var k=2;k<=count3;k++)
                    {
                        $('#remove_photo'+k).remove();
                    }

                    $('#count').val('1');
                    $('#check_count').val('1');
                    $('#count2').val('1');
                    $('#step_count').val('1');
                    $('#count3').val('1');

                    $('#recipe_photo').val('');
                    storePath=[];

                    toastr.success(data.msg);
                } else {
                    toastr.error(data.msg);
                }
            }
        });
    },

    isName: function(event) {
        var inputValue = event.charCode;
        if (!(inputValue >= 65 && inputValue <= 120) && (inputValue != 32 && inputValue != 0)) {
            event.preventDefault();
        }
    }
};