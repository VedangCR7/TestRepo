var Inventorypaymentcreate ={
    base_url:null,
    init:function() {
        this.bind_events();
    },

    bind_events :function() {
        var self=this; 
        $('.btn-add-group').on('click',this.onSaveGroupname);
        $('#supplier_id').on('change',this.onChangesupplier);
        $('#paid').on('blur',this.onChangepaid);
        $('#discount').on('blur',this.onChangediscount);
        $('#discount').on('focus',this.onChangesupplier);
    },

    onChangesupplier:function(){
        $('#image-loader').show();
        if($('#supplier_id').val() !=''){
            $.ajax({
                url: Inventorypaymentcreate.base_url+"inventory/get_payable_amount",
                type:'POST',
                dataType: 'json',
                data: {
                    supplier_id : $('#supplier_id').val()
                },
                success: function(result){
                    $('#image-loader').hide();
                    $('#payable_amount').val(parseInt(result.payable_amount));
                    $('#total').val(parseInt(result.total_amount));
                }
            });
        }
    },

    onChangepaid:function(){
        $('#image-loader').show();
        if($('#supplier_id') == ''){
            $('#image-loader').hide();
            Inventorypaymentcreate.displaywarning("Please select supplier"); return false;
        }
        if(parseInt($('#payable_amount').val()) < parseInt($('#paid').val())){
            $('#image-loader').hide();
            Inventorypaymentcreate.displaywarning("Please enter paid amount is less than or equal to payable amount"); return false;
        }
        $('#balance').val(parseInt($('#payable_amount').val()) - parseInt($('#paid').val()));

        $('#image-loader').hide();
    },

    onChangediscount:function(){
        $('#image-loader').show();
        debugger;
        if(parseInt($('#discount').val()) <= 0){
            $('#image-loader').hide();
            Inventorypaymentcreate.displaywarning("Please enter discount amount is greater than 0"); return false;
        }
        if(parseInt($('#payable_amount').val()) < parseInt($('#discount').val())){
            $('#image-loader').hide();
            Inventorypaymentcreate.displaywarning("Please enter discount amount is less than or equal to payable amount"); return false;
        }
        if($('#discount').val() != ''){
        $('#payable_amount').val(parseInt($('#payable_amount').val()) - parseInt($('#discount').val()));
        $('#balance').val(parseInt($('#payable_amount').val()) - parseInt($('#paid').val()));
        if(parseInt($('#payable_amount').val()) < parseInt($('#paid').val())){
            $('#image-loader').hide();
            Inventorypaymentcreate.displaywarning("Please enter paid amount is less than or equal to payable amount"); return false;
        }
        }
        else{
            $('#balance').val(parseInt($('#payable_amount').val()) - parseInt($('#paid').val()));
        }

        $('#image-loader').hide();
    },

    onSaveGroupname:function(){
        if($('#payment_date').val() ==''){ Inventorypaymentcreate.displaywarning("Payment date is required"); return false; }
        if($('#supplier_id').val() ==''){ Inventorypaymentcreate.displaywarning("Please select supplier"); return false; }
        if($('#supplier_id').val() !='' && $('#payable_amount').val() == 0){ Inventorypaymentcreate.displaywarning("Please create purchase order for respective supplier"); return false; }
        if($('input[type=radio]:checked').val() ==''){ Inventorypaymentcreate.displaywarning("Please Select Payment type"); return false; }
        if($('#payment_details').val() == ''){ Inventorypaymentcreate.displaywarning("Please Enter payment details"); return false; }
        if($('#payable_amount').val() ==''){ Inventorypaymentcreate.displaywarning("Please enter payable amount"); return false; }
        if($('#paid').val() ==''){ Inventorypaymentcreate.displaywarning("Please enter paid amount"); return false; }
        if($('#total').val() ==''){ Inventorypaymentcreate.displaywarning("Please enter total amount"); return false; }
        if(parseInt($('#payable_amount').val()) < parseInt($('#paid').val())){
            $('#image-loader').hide();
            Inventorypaymentcreate.displaywarning("Please enter paid amount is less than or equal to payable amount"); return false;
        }
        if(parseInt($('#payable_amount').val()) < parseInt($('#discount').val())){
            $('#image-loader').hide();
            Inventorypaymentcreate.displaywarning("Please enter discount amount is less than or equal to payable amount"); return false;
        }
        $('#image-loader').show();
        $.ajax({
            url: Inventorypaymentcreate.base_url+"inventory/save_created_payment",
            type:'POST',
            dataType: 'json',
            data: {
                payment_date : $('#payment_date').val(),
                supplier_id : $('#supplier_id').val(),
                payment_type : $('input[type=radio]:checked').val(),
                payment_details : $('#payment_details').val(),
                cheque_date : $('#cheque_date').val(),
                remark : $('#remark').val(),
                payable_amount : $('#payable_amount').val(),
                paid : $('#paid').val(),
                discount : $('#discount').val(),
                total : $('#total').val(),
                balance : $('#balance').val(),
            },
            success: function(result){
                $('#image-loader').hide();
                if (result.status) {
                    Inventorypaymentcreate.displaysucess("Payment created successfully");
                    location.reload();
                }else{
                    Inventorypaymentcreate.displaywarning("Something went wrong");
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