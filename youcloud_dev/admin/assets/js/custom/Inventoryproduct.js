var Inventoryproduct ={
    base_url:null,
    init:function() {
        this.bind_events();
    },

    bind_events :function() {
        var self=this;

        $('.addcsv').on('click',function(){
            $(this).closest('div').find('.uploadfile').trigger('click');
        });

        $('.uploadfile').on('change',this.uploadexlfile);
        
        $('.btn-add-group').on('click',this.onSaveGroupname);

    },

    uploadexlfile:function(){
        //alert("change");
        var $form_data = new FormData();
        $form_data.append('uploadFile',$('.uploadfile')[0].files[0]);
        //console.log($form_data);
        $.ajax({
            url: Inventoryproduct.base_url+"inventory/uploadData",
            type:'POST',
            data: $form_data,
            processData:false,
            contentType:false,
            cache:false,
            success: function(result){
                //console.log(result);
                $('#image-loader').show();
                if (result.status) {
                    Inventoryproduct.displaysucess("upload successfully");
                } 
                else{
                    Inventoryproduct.displaywarning(result.msg);
                }
                $('#image-loader').hide();
                // var data={
                //     per_page:$('.btn-per-page').attr('selected-per-page'),
                //     page:1
                // }
                // Inventoryproduct.listCustomers(data);
            }
        });
    },


    onSaveGroupname:function(){
        $('#image-loader').show();
        $.ajax({
            url: Inventoryproduct.base_url+"inventory/save_product_name",
            type:'POST',
            dataType: 'json',
            data: {
                product_name : $('#product_name').val()
            },
            success: function(result){
                $('#image-loader').hide();
                if (result.status) {
                    Inventoryproduct.displaysucess("Product created successfully");
                    $('#product_name').val('');
                }else{
                    Inventoryproduct.displaywarning(result.msg);
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