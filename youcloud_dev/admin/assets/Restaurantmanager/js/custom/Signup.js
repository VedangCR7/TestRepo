var Signup ={
    base_url:null,
    tableid:null,
    restid:null,
    init:function() {
        this.bind_events();
    },

    bind_events :function() {
        var self=this;
        $('.input-contact').on('keypress',function(e){
            var regex = new RegExp("^[0-9]+$");
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
            if (regex.test(str)) {
                return true;
            }
            e.preventDefault();
            return false;
        });
        $('.form-singup').on('submit',this.onSubmitCustomerform);
        $('.btn-check-contact').on('click',this.onCheckContact);
        
    },
    onCheckContact:function(){
        if($('.input-contact').val()==""){
            Signup.displaywarning("please enter contact no.");
            return false;
        }
        var contact_number=$('.input-contact').val();
        if(contact_number.length<8 || contact_number.length>14){
                Signup.displaywarning("Mobile number must be between 8 to 14 digits");
                return false;
        }
        var data={
            contact_no:$('.input-contact').val()
        }
        $('#image-loader').show();
        $.ajax({
            url: Signup.base_url+"webcustomer/check_contact",
            type:'POST',
            dataType: 'json',
            data: data,
            success: function(response){
                $('#image-loader').hide();
                if (response.status) { 
                    var result=response.result;
                    if(result=="notexist"){
                        $('.btn-check-contact').hide();
                        $('.form-input-hide').show();
                    }else{
                        $('.input-name').val(result.name);
                        $('.input-email').val(result.email);
                        $('.input-id').val(result.id);
                        $('.input-contact').attr('readonly','');
                        $('.btn-check-contact').hide();
                        $('.form-input-hide').show();
                    }
                } else {
                   Signup.displaywarning("Something went wrong please try again");
                }
                
            }
       });
    },
    onSubmitCustomerform:function(){
        var name=$('.input-name').val();
        if(name.length<2 || name.length>50){
                Signup.displaywarning("Name must be between 2 to 50 length charaters");
                return false;
        }
        $(this).find('button[type="submit"]').attr('disabled','');
        $('#image-loader').show();
        $.ajax({
            url: Signup.base_url+"webcustomer/customer_login",
            type:'POST',
            dataType: 'json',
            data: $('.form-singup').serialize(),
            success: function(result){
                $('#image-loader').hide();
                if (result.status) { 
                    if(Signup.tableid!="")
                        window.location.href=Signup.base_url+"mainmenu/mainmenu/"+Signup.restid+"/"+Signup.tableid;
                    else
                        window.location.href=Signup.base_url+"mainmenu/mainmenu/"+Signup.restid;
                } else {
                   Signup.displaywarning("Something went wrong please try again");
                }
                $('#reset-form button[type="submit"]').removeAttr('disabled');
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
            window.location.href=Signup.base_url+"users/dashboard";
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