var Reportinvoicedetails ={
    base_url:null,
    init:function() {
        this.bind_events();
        var data={
            per_page : $('.btn-per-page').attr('selected-per-page'),
            page:1,
            customer_id:$('#customer_id').val(),
            status:$('#payment_status').val()
        }
        this.listinvoice(data);
    },

    bind_events :function() {
        var self=this;
        $('.a-recipe-perpage').on('click',function(){
            $(this).closest('.btn-group').find('button').attr('selected-per-page',$(this).attr('data-per'));
            if($(this).attr('data-per')=="all")
                $(this).closest('.btn-group').find('button').html($(this).html()+' items');
            else
                $(this).closest('.btn-group').find('button').html($(this).html()+' items per page');
            var data={
                per_page:$(this).attr('data-per'),
                page:1,
                customer_id:$('#customer_id').val(),
                status:$('#payment_status').val()
                
            }
            Reportinvoicedetails.listinvoice(data);
        });
        $('.btn-prev').on('click',function(){
            var data={
                per_page:$('.dropdown-toggle').attr('selected-per-page'),
                page:$(this).attr('page-no'),
                customer_id:$('#customer_id').val(),
                status:$('#payment_status').val()
                
            }
            Reportinvoicedetails.listinvoice(data);
        });
        $('.btn-next').on('click',function(){
            var data={
                per_page:$('.dropdown-toggle').attr('selected-per-page'),
                page:$(this).attr('page-no'),
                customer_id:$('#customer_id').val(),
                status:$('#payment_status').val()
                
            }
            Reportinvoicedetails.listinvoice(data);
        });
        $('#searchInput').on('keyup',function(){
           
             if($(this).val()==""){
                var data={
                    per_page:$('.dropdown-toggle').attr('selected-per-page'),
                    page:1,
                    customer_id:$('#customer_id').val(),
                    status:$('#payment_status').val()
                }
                Reportinvoicedetails.listinvoice(data,'fromsearch');
            }else{
                if($(this).val().length>=3){
                    var data={
                        per_page:'all',
                        page:1,
                        searchkey:$('#searchInput').val(),
                        customer_id:$('#customer_id').val(),
                        status:$('#payment_status').val()
                    }
                    Reportinvoicedetails.listinvoice(data,'fromsearch');
                }
            }
        });
        $('.tbody-group-list').on('click','.viewinvoices',this.onViewInvoice);
        $('.tbody-group-list').on('click','.printinvoices',this.onPrintInvoice);
        $('.tbody-group-list').on('click','.deleteinvoices',this.onDeleteInvoice);
        $('#payment_status').on('change',this.onChangeStatus);



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

    },


    onChangeStatus:function(){
        var data={
            per_page : $('.btn-per-page').attr('selected-per-page'),
            page:1,
            customer_id:$('#customer_id').val(),
            status:$('#payment_status').val()
        }
        Reportinvoicedetails.listinvoice(data);
    },

    onPrintInvoice:function(){
        var invoice_id = $(this).attr('data-id');
        window.open(Reportinvoicedetails.base_url+"restaurant/printbill/"+invoice_id,'_blank');
    },

    onViewInvoice:function(){
        var invoice_id = $(this).attr('data-id');
        $('#image_loader').show();
        $.ajax({
            url: Reportinvoicedetails.base_url+"reports/get_invoice_items/",
            type:'POST',
            dataType: 'json',
            data: {invoice_id:invoice_id},
            success: function(response){
                $('#image_loader').hide();
                html='';
                $('#invoiceno').html('Invoice No. : '+response.invoice_no);
                $('#tableno').html('Invoice No. : '+response.table_no);
                $('#custname').html('Customer Name : '+response.customer_name);
                $('#custcontact').html('Customer Contact : '+response.contact_no);
                for (var i = 0; i < response['items'].length; i++) {
                    html+='<tr>\
                    <td>'+response['items'][i].recipe_name+'</td>\
                    <td>'+response['items'][i].qty+'</td>\
                    <td class="text-right">&#8377; '+response['items'][i].price+'</td>\
                    <td class="text-right">&#8377; '+response['items'][i].sub_total+'</td>\
                    <tr>'
                }
                $('#showrecipes').html(html);
                $('#sub_total').html('&#8377; '+response.sub_total);
                $('#dis_total').html('&#8377; '+response.disc_total);
                $('#net_total').html('&#8377; '+response.net_total);
                $('#showinvoicedetails').modal('show');
            }
        });
    },

    onDeleteInvoice:function(){
       var invoice_id = $(this).attr('data-id');
        $('#image_loader').show();
        $.ajax({
            url: Reportinvoicedetails.base_url+"restaurant/deleteinvoice/",
            type:'POST',
            dataType: 'json',
            data: {invoice_id:invoice_id},
            success: function(response){
                Reportinvoicedetails.displaysucess('Delete Successfully');
                var data={
                    per_page : $('.btn-per-page').attr('selected-per-page'),
                    page:1,
                    customer_id:$('#customer_id').val(),
                    status:$('#payment_status').val()
                }
                Reportinvoicedetails.listinvoice(data);
            }
        }); 
    },
    
    listinvoice:function(data,fromevent){
        $('#image_loader').show();
        $.ajax({
            url: Reportinvoicedetails.base_url+"reports/get_invoice/",
            type:'POST',
            dataType: 'json',
            data: data,
            success: function(response){
                $('#image_loader').hide();
                var managers=response.manager;
                var html="";
                var j=1;
                for (i in managers) {
                        html +='<tr>\
                        <td>'+j+'</td>\
                        <td>'+managers[i].invoice_no+'</td>\
                        <td>'+managers[i].name+'</td>\
                        <td>'+managers[i].title+'</td>\
                        <td class="text-right">'+Reportinvoicedetails.currency_symbol+" "+managers[i].net_total+'</td>\
                        <td class="text-danger">';
                            if (managers[i].status == 'Unpaid') {
                                html+='<a href="'+Reportinvoicedetails.base_url+'restaurant/tablerecipe/'+managers[i].table_id+'/'+managers[i].table_order_id+'"><button class="btn btn-danger btn-sm">Unpaid</button></a>';
                            }

                            if (managers[i].status == 'Paid') {
                                html+='<button class="btn btn-success btn-sm">Paid</button>';
                            }
                            if (managers[i].status == '') {
                                html+=''
                            }
                        html+='</td>\
                        <td>\
                        <i class="fas fa-eye text-info viewinvoices" style="font-size:17px;" data-id="'+managers[i].id+'"></i>&nbsp;&nbsp;\
                        <i class="fas fa-print text-primary printinvoices" style="font-size:17px;" data-id="'+managers[i].id+'"></i>&nbsp;&nbsp;\
                        <i class="fas fa-trash text-danger deleteinvoices" style="font-size:17px;" data-id="'+managers[i].id+'"></i>\
                        </td>\
                        </tr>';
                        j=j+1;
                }
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