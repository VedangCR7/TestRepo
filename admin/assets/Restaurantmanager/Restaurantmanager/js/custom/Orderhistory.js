var Orderhistory ={
    base_url:null,
    uncheck_ids:new Array(),
    init:function() {
        this.bind_events();
        this.listTableOrders();
        //this.orderhistory($('#date').val());
        //this.table_number();
    },

    bind_events :function() {
        var self=this; 
        $('.btn-change-status').on('click',this.OnChangeStatus);
        $('#date').on('change',this.onchangedate);
        $('.allorders').on('click','.btn-view-tableorder',function(e){
             var table_order_id=$(this).attr('data-id');
            Orderhistory.onViewTableOrder(table_order_id);
        });

        // $('.input-checkall-orders').on('click',function(){
        //     if($(this).is(':checked')){
        //         $('.input-checksingle-orders:not(:disabled)').prop('checked',true);
        //     }else{
        //         $('.input-checksingle-orders:not(:disabled)').prop('checked',false);
        //         $('.input-checksingle-orders:not(:disabled)').each(function(){
        //             if(!$(this).is(':checked')){
        //                 var id=$(this).val();
        //                 Orderhistory.uncheck_ids.push(id);
        //             }
        //         });
        //     }

        // });

        $('table').on('click','.btn-view-order',function(){
            $('#order-modal').modal('show');
            var order_id=$(this).attr('data-id');
            var table_order_id=$(this).attr('table-order-id');
            Orderhistory.onViewOrder(order_id,table_order_id);
        });
        $('#search_contents').on('keyup',this.onchangesearch);

        $('.tbody-tableorder-list').on('click','.input-checksingle-orders',this.onClickInput);
        $('.btn-create-invoice').on('click',this.onCreateInvoice);


        // $('#table_number').on('change',this.onchangetablenumber);
        // $('#order_status').on('change',this.onchangeorderstatus);   
        // $('.tbody-tableorder-list').on('click','.view-order',function(){
        //     $('#order-modal').modal('show');
        //     var order_id=$(this).attr('data-id');
        //     var table_order_id=$(this).attr('table-order-id');
        //     Orderhistory.vieworderdetail(order_id,table_order_id);
        // });
        // $('#footer_status_button').on('click','.btn-change-status',this.OnChangeStatus);
    },

    onCreateInvoice:function(){
        var self=this;
        var ids=new Array();
        $('.input-checksingle-orders').each(function(){
            if($(this).is(':checked')){
                var id=$(this).val();
                ids.push(id);
            }
        });
        if(ids.length==0 && Orderhistory.uncheck_ids.length==0){
            Orderhistory.displaywarning("Please select at least one item.");
            return false;
        }
        if(ids.length==0){
            var not_all_ids="";
        }else{
            var not_all_ids="yes";
        }
        var table_order_id=$('.input-tableorder-id').val();
        swal({
            title: 'Are you sure ?',
            text: " you want create invoice",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, create it!',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false
        },function () {
             $('#image-loader').show();
            var formData = {
                ids:ids,
                uncheck_ids:Orderhistory.uncheck_ids,
                not_all_ids:not_all_ids,
                table_order_id:table_order_id
            };
            $.ajax({
                url: Orderhistory.base_url+"restaurant/create_invoice",
                type:'POST',
                data:formData ,
                success: function(result){
                    $('#image-loader').hide();
                   if (result.status) {
                        Orderhistory.onViewTableOrder(table_order_id);
                        var data={
                            per_page : $('.dropdown-toggle').attr('selected-per-page'),
                            page:$('.btn-current-pageno').attr('curr-page'),
                            status:$('.select-order-status').val()
                        }
                        Orderhistory.listTableOrders(data);
                        var invoice_id=result.invoice_id;
                       
                        swal({
                            title: 'Are you sure ?',
                            text: " you want print invoice",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, print it!',
                            cancelButtonText: 'No, cancel!',
                            confirmButtonClass: 'btn btn-success',
                            cancelButtonClass: 'btn btn-danger',
                            buttonsStyling: false
                        },function (isconfirm) {
                            if(isconfirm){
                                window.open(Orderhistory.base_url+"restaurant/printbill/"+invoice_id,'_blank');
                                /*window.location.href=Orders.base_url+"restaurant/printbill/"+invoice_id;*/
                            }
                        });
                         $('.input-checkall-orders').prop('checked',false);
                       /* Orders.displaysucess("Successfully Saved.");*/
                   }
                   else{
                        Orderhistory.displaywarning("Something went wrong please try again");
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

    onClickInput:function(){
        if(!$(this).is(':checked')){
            var id=$(this).val();
            Orderhistory.uncheck_ids.push(id);
        }
    },

    onViewTableOrder:function(table_order_id){
        $('#table-order-modal').modal('show');
        $('.input-checkall-orders').prop('checked',false);
        $('.input-checksingle-orders').prop('checked',false);
       /* var table_order_id=$(this).attr('data-id');*/
        var data={
            table_order_id:table_order_id
        }
        $('#image-loader').show();
        $('.input-tableorder-id').val(table_order_id);
        $.ajax({
            url: Orderhistory.base_url+"restaurant_managerorder/get_tableorder_details/",
            type:'POST',
            dataType: 'json',
            data: data,
            success: function(response){
                $('#table-order-modal').find('.span_tableorder_no').html(response.table_orderno);
                $('#table-order-modal').find('.span_table_orderdate').html(response.order_date);
                $('#table-order-modal').find('.span_tableno').html(response.table_no);
                var orders=response.orders;
                var html="";
                for (i in orders) {
                    var status_color="";
                    if(orders[i].status=="New"){
                        status_color="badge-warning";
                    }
                    else if(orders[i].status=="Confirmed"){
                        status_color="badge-black";
                        
                    }
                    else if(orders[i].status=="Blocked"){
                        status_color="badge-orange";
                    }
                    else if(orders[i].status=="Food Served"){
                        status_color="badge-indigo";
                    }
                    else if(orders[i].status=="Assigned To Kitchen"){
                        status_color="badge-info";
                    }
                    else if(orders[i].status=="Canceled"){
                        status_color="badge-danger";
                    }
                    else if(orders[i].status=="Completed"){
                        status_color="badge-success";
                    }
                    html+='<tr>';
                        // if(orders[i].status=="Food Served" && orders[i].is_invoiced==0){
                        //     html+='<input type="checkbox" class="input-checksingle-orders" name="is_order_check'+i+'" value="'+orders[i].id+'"></td>';
                        // }else{
                        //     html+='<input type="checkbox" class="input-checksingle-orders" name="is_order_check'+i+'" value="'+orders[i].id+'" disabled=""></td>';
                        // }
                        html+='<td>'+orders[i].order_no+'</td>\
                        <td>'+orders[i].customer_name+'</td>\
                        <td><span class="badge '+status_color+'">'+orders[i].status+'</span></td>';
                        html +='<td>'+orders[i].order_by_name+'</td>\
                        <td>'+orders[i].net_total+'</td>';
                        if(orders[i].is_invoiced==1)
                            html+='<td>Yes</td>';
                        else
                            html+='<td>No</td>';
                        html+='<td>';
                            html+='<a href="javascript:;" data-id="'+orders[i].id+'" table-order-id="'+table_order_id+'" class="btn btn-sm btn-success btn-view-order mr-1"><i class="fas fa-eye"></i></a>';
                            if(orders[i].status=="New" || orders[i].status=="Confirmed"){
                                html+='<a href="'+Orderhistory.base_url+'restaurant_managerorder/edit_order/'+orders[i].id+'"><button data-id="'+orders[i].id+'" table-order-id="'+table_order_id+'" class="btn btn-sm btn-info btn-edit-order"><i class="fas fa-edit"></i></button></a>';
                            }
                        html+='</td>';
                    html+='</tr>';
                }
                $('.tbody-tableorder-list').html(html);
                $('#image-loader').hide();
            }
        });
    },

    OnChangeStatus:function(){
        var self=this;
        var status=$(this).attr('order-status');
        var order_id=$('.input-order-id').val();
        var data={
            order_id:order_id,
            status:status
        }
        var table_order_id=$(this).attr('table-order-id');
        if(status=="Completed")
            display_text="Complete";
        else if(status=="Food Served")
            display_text="Served";
        else
            display_text=status.replace("ed", "");


        if(status=="Assigned To Kitchen"){
            var textmsg="You want to Assign this order To Kitchen";
        }
        if(status=="Food Served"){
            var textmsg="You want to Serve the Food for this order";
        }
        else if(status=="Blocked"){
            var textmsg="You want to Block this order";
        }
        else{
            var textmsg='You want to '+display_text+' this Order';
        }
        swal({
            title: 'Are you sure ?',
            text: textmsg,
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, '+display_text+' it!',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false
        },function () {
            $('#image-loader').show();
            $.ajax({
                url: Orderhistory.base_url+"restaurant/change_order_status",
                type:'POST',
                data:data,
                success: function(result){
                   if (result.status) {
                        Orderhistory.onViewOrder(order_id);
                        var data={
                            per_page:$('.dropdown-toggle').attr('selected-per-page'),
                            page:$('.btn-current-pageno').attr('curr-page'),
                            status:$('.select-order-status').val()
                        }
                        //Orderhistory.listOrders(data);
                        if(table_order_id!="")
                            Orderhistory.onViewTableOrder(table_order_id);
                   }
                   else{
                        Orderhistory.displaywarning("Something went wrong please try again");
                   }
                   $('#image-loader').hide();
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

    // onSearchmenu:function(){
    //     var table_no =$('#table_number').val();
    //     var search=$('#input-search').val();
    //     if (search != '') {
    //     Orderhistory.load_menu(table_no,search);}
    //     else{
    //        $('#show_all_recipes').html(''); 
    //     }
    // },

    // load_menu:function(table_no = '',search = ''){
    //     var table_no =$('#table_no').val();
    //     if (table_no != '' || search!='') {
    //     $('#image-loader').show();
    //     $.ajax({
    //         url: Orderhistory.base_url+"restaurant_managerorder/all_recipes",
    //         type:'POST',
    //         dataType: 'json',
    //         data :{tablecat_id : table_no,search_recipe : search},
    //         success: function(response){
    //             $('#image-loader').hide();
    //             var html = '';
    //             for (var i = 0; i < response.length; i++) {
    //                 html += '<div class="gold-members d-flex align-items-center justify-content-between px-3 py-2 border-bottom">\
    //               <div class="media align-items-center" style="width:50%">\
    //                  <div class="mr-2 text-danger">';
    //                  if (response[i].recipe_type == 'nonveg') {
    //                 html +='<img src="'+Orderhistory.base_url+'assets/web/images/nv.png" height="10px" width="10px">';
    //                 }
    //                 else{
    //                 html +='<img src="'+Orderhistory.base_url+'assets/web/images/vg.png" height="10px" width="10px">';
    //                 }
    //                 html +='</div>\
    //                  <div class="media-body">\
    //                     <p class="m-0 menuname">'+Orderhistory.capitalize_Words(response[i].name)+' (&#8377; '+response[i].price+')</p>\
    //                  </div>\
    //               </div>\
    //               <div class="d-flex align-items-center">\
    //               <input type="number" class="form-control" id="input-qty" name="qty" min="0" max="999"/>\
    //               <span><button class="btn btn-primary btn-sm"><i class="feather-plus"></i></button</span>\
    //               </div>\
    //            </div>';
    //             }

    //             $('#show_all_recipes').html(html);
    //             $('.osahan-checkout').css('display','block');
    //             $('.showsearch').css('display','block');
                
    //         }
    //     });
    // }
    // },


    // capitalize_Words:function(str)
    // {
    //     return str.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
    // },

    onViewOrder:function(order_id,table_order_id){
        var data={
            order_id:order_id
        }
        if(table_order_id!=""){
            $('.btn-change-status').attr('table-order-id',table_order_id);
        }
        $('.btn-change-status').hide();
        $('#image-loader').show();
        $.ajax({
            url: Orderhistory.base_url+"restaurant/get_order_details/",
            type:'POST',
            dataType: 'json',
            data: data,
            success: function(response){
                for(i in response){
                    $('.row-order-details .span_'+i).html(response[i]);
                }
                $('.btn-change-status').hide();
                $('.span_status').removeClass('badge-black');
                $('.span_status').removeClass('badge-info');
                $('.span_status').removeClass('badge-danger');
                $('.span_status').removeClass('badge-warning');
                $('.span_status').removeClass('badge-success');
                $('.span_status').removeClass('badge-orange');
                $('.span_status').removeClass('badge-indigo');
                if(response['status']=="New"){
                    status_color="badge-warning";

                    $('.btn-accept').show();
                    $('.btn-cancel').show();
                    $('.btn-block-customer').show();
                }
                else if(response['status']=="Confirmed"){
                    status_color="badge-black";
                    $('.btn-assign').show();
                }
                else if(response['status']=="Blocked"){
                    status_color="badge-orange";
                }
                else if(response['status']=="Assigned To Kitchen"){
                    status_color="badge-info";
                    $('.btn-served').show();
                }
                else if(response['status']=="Food Served"){
                    status_color="badge-indigo";
                    $('.btn-complete').show();
                }
                else if(response['status']=="Canceled"){
                    status_color="badge-danger";
                }
                else if(response['status']=="Completed"){
                    status_color="badge-success";
                }
                $('.input-order-id').val(response['id']);
                $('.span_status').addClass(status_color);
                var items=response['items'];
                var html="";
                var j=1;
                for (i in items) {
                    html+='<tr>\
                        <td>'+j+'</td>\
                        <td>'+items[i].recipe_name+'</td>\
                        <td class="text-right">'+items[i].qty+'</td>\
                        <td class="text-right">'+items[i].price+'</td>';
                    html+='</tr>';
                    j=j+1;
                }
                $('.tbody-order-items').html(html);
                $('#image-loader').hide();
            }
        });
    },

    onchangedate:function(){
        Orderhistory.listTableOrders($('#date').val());
    },

    onchangesearch:function(){
        Orderhistory.listTableOrders($('#date').val(),$('#search_contents').val());
    },


    listTableOrders:function(date,search=''){
        $('#image-loader').show();
        $('.allorders').html('');
        $.ajax({
            url: Orderhistory.base_url+"restaurant_managerorder/list_tablwise_orders/",
            type:'POST',
            dataType: 'json',
            data:{date : $('#date').val(),searchkey:search},
            success: function(response){
                var orders=response.orders;
                for (i in orders) {
                   
                    var html ='<div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:20px;">\
      <div class="row" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);padding:2px;background-color:white;">\
        <div class="col-lg-6 col-md-6 col-sm-6 col-6">\
          <span>ORDER NO</span><br>\
          <span class="font-weight-bold" style="font-weight:bold">'+orders[i].table_orderno+'</span>\
        </div>\
        <div class="col-lg-6 col-md-6 col-sm-6 col-6">\
          <span>TABLE NO</span><br>\
          <span class="font-weight-bold" style="font-weight:bold">'+orders[i].table_no+'</span>\
        </div>\
        <div class="col-lg-6 col-md-6 col-sm-6 col-6" style="margin-top:10px;">\
          <span style="">DATE</span><br>\
          <span class="font-weight-bold" style="font-weight:bold">'+orders[i].order_date+'</span>\
        </div>\
        <div class="col-lg-6 col-md-6 col-sm-6 col-6" style="margin-top:10px;">\
          <span style="">TIME</span><br>\
          <span class="font-weight-bold" style="font-weight:bold">'+orders[i].insert_time+'</span>\
        </div>\
        <div class="col-lg-12 col-md-12 col-sm-12 col-12" style="margin-top:-20px;">\
          <hr>\
        </div>\
        <div class="col-lg-12 col-md-12 col-sm-12 col-12 text-right" style="margin-top:-20px;">';
            html+='<a href="javascript:;" data-id="'+orders[i].id+'" class="btn btn-sm btn-success btn-view-tableorder mr-1"><i class="fas fa-eye"></i></a>';
                        if(orders[i].invoice_ids!="" && orders[i].invoice_ids!=null && orders[i].invoice_ids!='null'){
                            var invoice_arr=orders[i].invoice_ids.split(",");
                            for(k in invoice_arr){
                                html+='<a target="_blank" href="'+Orderhistory.base_url+'restaurant/printbill/'+invoice_arr[k]+'" class="btn btn-sm mr-1 btn-info" style="color:#fff;"><i class="fa fa-print"></i></a>';
                            }
                        }
        html +='</div>\
      </div>\
    </div>';
    $('.allorders').append(html);
                }
                $('#image-loader').hide();
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