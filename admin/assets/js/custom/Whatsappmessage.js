var Whatsappmessage ={
    base_url:null,
    init:function() {
        this.bind_events();
        this.showmsg();
    },

    bind_events :function() {
        var self=this;

        $('#savemessage').on('click',function(){
            if ($('#text_message').val() != '' && $('#whatsapp_message').val() != '') {
            $.ajax({
                url: Whatsappmessage.base_url+"Whatsapp_manager/add_restaurant_msg/",
                type:'POST',
                dataType: 'json',
                data : {text_message:$('#text_message').val(),whatsapp_message:$('#whatsapp_message').val(),id:$('#message_id').val() },
                success: function(result){
                    if(result.is_exist){
                        Whatsappmessage.displaywarning("This category message already exist.Please Edit");
                    }
                    if(result.status){
                        Whatsappmessage.displaysucess("Message Save Successfully");
                        Whatsappmessage.showmsg();
                    }
                    if (result.status == false){
                        Whatsappmessage.displaywarning("Something went wrong");
                    }
                }
            });
            }
            else{
                Whatsappmessage.displaywarning("All Fields are required");
            }
        });

    },


    showmsg:function(){
        $.ajax({
            url: Whatsappmessage.base_url+"Whatsapp_manager/restaurant_msg_details/",
            type:'POST',
            dataType: 'json',
            success: function(result){
                if (result.length>0) 
                {
                    $('#getid').html('<input type="hidden" id="message_id" value="'+result[0].id+'">');
                    $('#text_message').val(result[0].text_message);
                    $('#whatsapp_message').val(result[0].whatsapp_message);
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