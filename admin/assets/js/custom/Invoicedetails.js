var Invoicedetails ={
    base_url:null,
    init:function() {
        this.bind_events();
        var data={
            per_page : $('.btn-per-page').attr('selected-per-page'),
            page:1,
            from_date:$('#from_date').val(),
            to_date:$('#to_date').val()
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
                from_date:$('#from_date').val(),
                to_date:$('#to_date').val()
            }
            Invoicedetails.listinvoice(data);
        });
        $('.btn-prev').on('click',function(){
            var data={
                per_page:$('.dropdown-toggle').attr('selected-per-page'),
                page:$(this).attr('page-no'),
                from_date:$('#from_date').val(),
                to_date:$('#to_date').val()
            }
            Invoicedetails.listinvoice(data);
        });
        $('.btn-next').on('click',function(){
            var data={
                per_page:$('.dropdown-toggle').attr('selected-per-page'),
                page:$(this).attr('page-no'),
                from_date:$('#from_date').val(),
                to_date:$('#to_date').val()
            }
            Invoicedetails.listinvoice(data);
        });
        $('#searchInput').on('keyup',function(){
           
             if($(this).val()==""){
                var data={
                    per_page:$('.dropdown-toggle').attr('selected-per-page'),
                    page:1,
                    from_date:$('#from_date').val(),
                    to_date:$('#to_date').val()
                }
                Invoicedetails.listinvoice(data,'fromsearch');
            }else{
                if($(this).val().length>=3){
                    var data={
                        per_page:'all',
                        page:1,
                        searchkey:$('#searchInput').val(),
                        from_date:$('#from_date').val(),
                        to_date:$('#to_date').val()
                    }
                    Invoicedetails.listinvoice(data,'fromsearch');
                }
            }
        });


        $('.searchdate').on('click',this.searchdate);
        $('.tbody-group-list').on('click','.viewinvoices',this.onViewInvoice);
        $('.tbody-group-list').on('click','.printinvoices',this.onPrintInvoice);
        $('.tbody-group-list').on('click','.deleteinvoices',this.onDeleteInvoice);



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

    onPrintInvoice:function(){
        var invoice_id = $(this).attr('data-id');
        window.open(Invoicedetails.base_url+"restaurant/printbill/"+invoice_id,'_blank');
    },

    onViewInvoice:function(){
        var invoice_id = $(this).attr('data-id');
        $('#image_loader').show();
        $.ajax({
            url: Invoicedetails.base_url+"restaurant/get_invoice_items/",
            type:'POST',
            dataType: 'json',
            data: {invoice_id:invoice_id},
            success: function(response){
		console.log(response);
                $('#image_loader').hide();
                html='';
                $('#invoiceno').html('#'+response.invoice_no);
		$('#invoicedate').html(response.created_at);
                $('#tableno').html('Table No. : '+response.table_no);
		$('#redirect_page').attr('href',Invoicedetails.base_url+'restaurant/downloadpdfinvoice/'+response.id);
                $('.custname').html(response.customer_name);
		$('#invoicestatus').html(response.status);
                $('#custcontact').html(response.contact_no);
                for (var i = 0; i < response['items'].length; i++) {
                    html+='<tr>\
                    <td>'+response['items'][i].recipe_name+'</td>\
                    <td>'+response['items'][i].qty+'</td>\
                    <td class="text-right">'+Invoicedetails.currency_symbol +" "+response['items'][i].price+'</td>\
                    <td class="text-right">'+Invoicedetails.currency_symbol +" "+response['items'][i].sub_total+'</td>\
                    <tr>'
                }
                $('#showrecipes').html(html);
                $('#sub_total').html(Invoicedetails.currency_symbol +" "+response.sub_total);
                $('#dis_total').html(Invoicedetails.currency_symbol +" "+response.disc_total);
                $('#net_total').html(Invoicedetails.currency_symbol +" "+response.net_total);
                $('#showinvoicedetails').modal('show');
            }
        });
    },

    onDeleteInvoice:function(){
		var self=this;
        var invoice_id = $(this).attr('data-id');
        /* var recipe_count=$(this).attr('recipe-count');
        if(recipe_count>0){
        console.log(recipe_count); 
            var title='Delete Group';
            var text=" There are some recipes in this menu group. Are you sure ? you want to delete menu group and recipe";
        }else{*/
            var title='Are you sure ?';
            var text="Delete Invoice";
        /* } */
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
                id : invoice_id
            } 
            $('#image_loader').show();
			$.ajax({
				url: Invoicedetails.base_url+"restaurant/deleteinvoice/",
				type:'POST',
				dataType: 'json',
				data: {invoice_id:invoice_id},
				success: function(response){
					if (response.status) {
					Invoicedetails.displaysucess('Deleted Successfully');
					var data={
						per_page : $('.btn-per-page').attr('selected-per-page'),
						page:1,
						from_date:$('#from_date').val(),
						to_date:$('#to_date').val()
					}
					Invoicedetails.listinvoice(data);
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

    searchdate:function(){
        if($('#from_date').val() > $('#to_date').val()){
            Invoicedetails.displaywarning('from date is greater than to date');
            return false;
        }
        var data={
            per_page : $('.btn-per-page').attr('selected-per-page'),
            page:1,
            from_date:$('#from_date').val(),
            to_date:$('#to_date').val()
        }
        Invoicedetails.listinvoice(data);
    },
    
    listinvoice:function(data,fromevent)
	{
        $('#image_loader').show();
        $.ajax({
            url: Invoicedetails.base_url+"restaurant/get_invoice/",
            type:'POST',
            dataType: 'json',
            data: data,
            success: function(response)
			{
                $('#image_loader').hide();
                var managers=response.manager;
                var html="";
                var j=1;
				
                for (i in managers) 
				{
					html +='<tr>\
                        <td>'+j+'</td>\
                        <td>'+managers[i].invoice_no+'</td>\
                        <td>'+managers[i].name+'</td>\
                        <td>'+managers[i].title+'</td>\
                        <td>'+Invoicedetails.currency_symbol +" "+managers[i].net_total+'</td>\
                        <td class="text-danger">';
						if (managers[i].status == 'Unpaid') 
						{
							if(managers[i].order_type == 'Billing')
							{
								html+='<a href="'+Invoicedetails.base_url+'restaurant/tablerecipe/'+managers[i].table_id+'/'+managers[i].table_order_id+'/'+managers[i].id+'/invoice"><button class="btn btn-danger btn-sm">Unpaid</button></a>';
							}
							else
							{
								html+='<a href="'+Invoicedetails.base_url+'restaurant/onlineorder/'+managers[i].table_id+'/'+managers[i].table_order_id+'/'+managers[i].id+'/invoice"><button class="btn btn-danger btn-sm">Unpaid</button></a>';
							}                                
						}

						if (managers[i].status == 'Paid') 
						{
							html+='<button class="btn btn-success btn-sm">Paid</button>';
						}
						
						if (managers[i].status == '') 
						{
							html+=''
						}
                        html+='</td><td>\
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
                
				if(parseInt(response.page_no)>1)
				{
                    var prev_page=parseInt(response.page_no)-1;
                    $('.btn-prev').attr('page-no',prev_page);
                    $('.btn-prev').removeAttr('disabled');
                }
				else
				{
                    $('.btn-prev').attr('disabled',true);
                    $('.btn-prev').prop('disabled', true);                    
                }

                if(parseInt(response.page_no)<parseInt(response.total_pages))
				{
                    var next_page=parseInt(response.page_no)+1;
                    $('.btn-next').attr('page-no',next_page);
                    $('.btn-next').removeAttr('disabled');
                }
				else
				{
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