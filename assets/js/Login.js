var Login ={
    base_url:null,

    init:function() {
        this.bind_events();
    },

    bind_events :function() {
        var self=this;
        $("#login-form").on('submit',this.onSubmitLoginForm);
        $('#register-form').on('submit',this.onSubmitRegisterForm);
        $('#reset-form').on('submit',this.onSubmitResetForm);
        $('#forgot-form').on('submit',this.onSubmitForgotForm);
        $(".toggle-password").click(function() {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
        
    },
    onSubmitResetForm:function(){
        if($('#password').val()!=$('#cpassword').val()){
             Login.displaywarning("Password and Confirm password not match please try again.");
             return false;
        }
        var $form_data = new FormData();
        $('#reset-form').serializeArray().forEach(function(field){
            $form_data.append(field.name, field.value);
        });
        $.ajax({
            url: Login.base_url+"forgot/reset_user_password",
            type:'POST',
            data: $form_data,
            processData:false,
            contentType:false,
            cache:false,
            success: function(result){
                if (result.status) { 
                    Login.displaysucess('Password updated successfully.');
                    setTimeout(function(){
                        window.location.href=Login.base_url+"login";
                    }, 3000);
                   
                } else {
                    if(result.msg){
                        Login.displaywarning(result.msg);
                    }
                    else
                        Login.displaywarning("Something went wrong please try again");
                }
            }
       });
    },
    onSubmitForgotForm:function(){
        if($('#input-email').val()==""){
             Login.displaywarning("Please enter email address");
             return false;
        }
        var $form_data = new FormData();
        $('#forgot-form').serializeArray().forEach(function(field){
            $form_data.append(field.name, field.value);
        });
        $.ajax({
            url: Login.base_url+"forgot/forgot_password",
            type:'POST',
            data: $form_data,
            processData:false,
            contentType:false,
            cache:false,
            success: function(result){
                if (result.status) { 
                    Login.displaysucess(result.msg);
                    $('#forgot-form [name="email"]').val('');
                     setTimeout(function(){
                        window.location.href=Login.base_url+"login";
                        //window.location.href="";
                    }, 4000);
                    //sleep(2000);
                   
                } else {
                    if(result.msg){
                        Login.displaywarning(result.msg);
                    }
                    else
                        Login.displaywarning("Something went wrong please try again");
                }
            }
       });
    },
    onSubmitRegisterForm :function(){
        if($('#password').val()!=$('#cpassword').val()){
             Login.displaywarning("Password and Confirm password not match please try again.");
             return false;
        }
        if(!$('#checkbox-2').is(':checked')){
             Login.displaywarning("please check terms and conditions");
             return false;
        }
        var $form_data = new FormData();
        $('#register-form').serializeArray().forEach(function(field){
            $form_data.append(field.name, field.value);
        });
        $.ajax({
            url: Login.base_url+"login/register_user",
            type:'POST',
            data: $form_data,
            processData:false,
            contentType:false,
            cache:false,
            success: function(result){
                if (result.status) { 
                    Login.displaysucess(result.msg);
                    setTimeout(function(){
                        window.location.href=Login.base_url+"login";
                    }, 4000);
                    //window.location.href=Login.base_url+"login";
                   
                } else {
                    if(result.msg){
                        Login.displaywarning(result.msg);
                    }
                    else
                        Login.displaywarning("Something went wrong please try again");
                }
            }
       });
    },
    onSubmitLoginForm:function(){
        var $form_data = new FormData();
        $('#login-form').serializeArray().forEach(function(field){
            $form_data.append(field.name, field.value);
        });
        $.ajax({
            url: Login.base_url+"login/checklogin",
            type:'POST',
            data: $form_data,
            processData:false,
            contentType:false,
            cache:false,
            success: function(result){
                if (result.status) { 
                    //Login.displaysucessconfrim(result.msg);
                    console.log(result.usertype);
                    if(result.usertype=="Admin")
                        window.location.href=Login.base_url+"admin";
                    if(result.usertype=="Individual User")
                        window.location.href=Login.base_url+"recipes/overview";
                    if(result.usertype=="Individual Restaurants")
                        window.location.href=Login.base_url+"restaurant";
                    if(result.usertype=="Food Company")
                        window.location.href=Login.base_url+"company";
                     if(result.usertype=="School")
                        window.location.href=Login.base_url+"school";
                } else {
                    if(result.msg){
                        Login.displaywarning(result.msg);
                    }
                    else
                        Login.displaywarning("Something went wrong please try again");
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

    displaysucessconfrim:function(msg)
    {
        swal({
            title:"Success !", 
            text:msg, 
            type:"success",
            confirmButtonClass: "btn-primary",
            confirmButtonText: "Ok",
            closeOnConfirm: false
        }).then(function(){
            window.location.href=Login.base_url+"users/dashboard";
        })
    },
    displaywarningconfrim:function(msg)
    {
         swal({
                title:"Error !", 
                text:msg, 
                type:"error",
                confirmButtonClass: "btn-primary",
                confirmButtonText: "Ok",
                closeOnConfirm: false
            }).then(function(){
                window.location.href="";
        })  
    }
};