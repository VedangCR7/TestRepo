var WebOrders ={
	base_url:null,
    uncheck_ids:new Array(),
    order_status:null,
	init:function() {
		this.bind_events();
		var data={
			per_page : 15,
			page:$('.btn-current-pageno').attr('curr-page'),
            order_date:$('.search-order-date').val(),
			status:$('#status').val()
		}
		this.listTableOrders(data);
		//this.loadMenus();not show
	},

	bind_events :function() 
	{
		var self=this;
        
		$('.tbody-tablewiseorder-list').on('click','.btn-view-tableorder',function(e)
		{
			var table_order_id=$(this).attr('data-id');
            WebOrders.onViewTableOrder(table_order_id);
        });
		
        $('.search-order-date').on('change',function()
		{
                var data={
                    per_page:$('.dropdown-toggle').attr('selected-per-page'),
                    page:$('.btn-current-pageno').attr('curr-page'),
                    order_date:$('.search-order-date').val()
                }
            WebOrders.listTableOrders(data);
        });
		
		$('#status').on('change',function()
		{
                var data={
                    per_page:$('.dropdown-toggle').attr('selected-per-page'),
                    page:$('.btn-current-pageno').attr('curr-page'),
                    order_date:$('.search-order-date').val(),
					status:$('#status').val()
                }
            WebOrders.listTableOrders(data);
        });
		
		$('#searchRecipeInput').on('keyup',function()
		{
			if($(this).val()=="")
			{
    				var data={
    					per_page:$('.dropdown-toggle').attr('selected-per-page'),
    					page:$('.btn-current-pageno').attr('curr-page'),
                        order_date:$('.search-order-date').val()
    				}
    				/*Orders.listOrders(data,'fromsearch');*/
                    WebOrders.listTableOrders(data,'fromsearch');
			}
			else
			{
				if($(this).val().length>=3)
				{
					//var dt = $('.search-order-date').val();
                    var data={
    					per_page:$('.dropdown-toggle').attr('selected-per-page'),
    					page:$('.btn-current-pageno').attr('curr-page'),
                        order_date:$('.search-order-date').val(),
                        searchkey:$('#searchRecipeInput').val(),
    				}
    					/*Orders.listOrders(data,'fromsearch');*/
                        WebOrders.listTableOrders(data,'fromsearch');
				}
			}
		});
		
		$('.a-recipe-perpage').on('click',function(){
			$(this).closest('.btn-group').find('button').attr('selected-per-page',$(this).attr('data-per'));
			if($(this).attr('data-per')=="all")
				$(this).closest('.btn-group').find('button').html($(this).html()+' items');
			else
				$(this).closest('.btn-group').find('button').html($(this).html()+' items per page');
			var data={
				per_page:$(this).attr('data-per'),
				page:$('.btn-current-pageno').attr('curr-page'),
                order_date:$('.search-order-date').val()
			}
			WebOrders.listTableOrders(data);
		});
		$('.btn-prev').on('click',function(){
			var data={
				per_page:$('.dropdown-toggle').attr('selected-per-page'),
				page:$(this).attr('page-no'),
                order_date:$('.search-order-date').val()
			}
			WebOrders.listTableOrders(data);
		});
		
		$('.btn-next').on('click',function(){
			var data={
				per_page:$('.dropdown-toggle').attr('selected-per-page'),
				page:$(this).attr('page-no'),
                order_date:$('.search-order-date').val()
			}
			/* Orders.listOrders(data); */
			WebOrders.listTableOrders(data);
		});
		
		$('table').on('click','.btn-view-order',function()
		{
			//$('#order-modal').modal('show');
			var order_id=$(this).attr('data-id');
            var table_order_id=$(this).attr('table-order-id');
            window.location.href = WebOrders.base_url+"restaurant/onlineorder/"+order_id+"/"+table_order_id;
			//Orders.onViewOrder(order_id,table_order_id);
		});	
		
		$('table').on('click','.btn_view_order',function()
		{
			//$('#order-modal').modal('show');
			var order_id=$(this).attr('data-id');
            var table_order_id=$(this).attr('table-order-id');
            var is_invoiced=$(this).attr('is-invoiced');
            var invoice_id=$(this).attr('invoice-id');
            var order_type=$(this).attr('order-type');
			
			if(is_invoiced=='1')
			{
				window.location.href = WebOrders.base_url+"restaurant/onlineorder/"+order_id+"/"+table_order_id+"/"+invoice_id+'/tableorders';
			}
			else
			{
				window.location.href = WebOrders.base_url+"restaurant/onlineorder/"+order_id+"/"+table_order_id;
			}        
		});

        $('.input-checkall-orders').on('click',function(){
            if($(this).is(':checked')){
                $('.input-checksingle-orders:not(:disabled)').prop('checked',true);
            }else{
                $('.input-checksingle-orders:not(:disabled)').prop('checked',false);
                $('.input-checksingle-orders:not(:disabled)').each(function(){
                    if(!$(this).is(':checked')){
                        var id=$(this).val();
                        Orders.uncheck_ids.push(id);
                    }
                });
            }

        });
        $('.tbody-tableorder-list').on('click','.input-checksingle-orders',this.onClickInput);
	    $('.btn-create-invoice').on('click',this.onCreateInvoice);
    },
    listTableOrders:function(data,fromevent)
	{
		debugger;
        $('#image-loader').show();
        $.ajax({
            url: WebOrders.base_url+"restaurant/list_tablwise_orders_website/",
            type:'POST',
            dataType: 'json',
            data: data,
            success: function(response)
			{
                var orders=response.orders;
                let html="";
				
                for (i in orders) 
				{
					var status_color="";
					
					if(orders[i].status=="New")
					{
						status_color="badge-warning";
					}
					else if(orders[i].status=="Confirmed")
					{
						status_color="badge-black";						
					}
                    else if(orders[i].status=="Blocked")
					{
                        status_color="badge-orange";
                    }
                    else if(orders[i].status=="Food Served"){
                        status_color="badge-indigo";
                    }
					else if(orders[i].status=="Assigned To Kitchen")
					{
						status_color="badge-info";
					}
					else if(orders[i].status=="Canceled")
					{
						status_color="badge-danger";
					}
					else if(orders[i].status=="Completed")
					{
						status_color="badge-success";
					}
					
					var order_date = orders[i].created_at;
					var completed_date = orders[i].completed_at;
					
					if(completed_date!="")
					{
						var startDate = new Date(order_date);
						var endDate   = new Date(completed_date);
						var seconds = (endDate.getTime() - startDate.getTime()) / 1000;
						
						var d = Number(seconds);
						
						if(seconds < 60)
						{
							var s = Math.floor(d % 3600 % 60);
							var time_ago = s > 0 ? s + (s == 1 ? " second" : " seconds") : "";
						}
						else if(seconds >= 60 && seconds < 3600)
						{
							var m = Math.floor(d % 3600 / 60);
							var time_ago = m > 0 ? m + (m == 1 ? " minute " : " minutes ") : "";											
						}
						else if(seconds >= 3600)
						{
							var h = Math.floor(d / 3600);
							var time_ago = h > 0 ? h + (h == 1 ? " hour " : " hours ") : "";
						}
					}
					else
					{
						var time_ago = '';
					}
					
                    html+='<tr>\
                        <td>'+orders[i].order_no+'</td>\
                        <td>'+orders[i].supply_option+'</td>';
						if(orders[i].supply_option=="Delivery")
						{
                        html+='<td>\
							<span style="word-break: break-word;">'+orders[i].name+'</span><br>\
							<span style="word-break: break-word;">'+orders[i].complete_address+'</span><br>\
							<span style="word-break: break-word;">'+orders[i].contact_number+'</span>\
						</td>';						
                        }
						else
						{
							html+='<td></td>';	
						}
						html+='<td>\
							<span style="float: left;">'+orders[i].order_date+'</span><br>\
							<span style="float: left;">'+orders[i].insert_time+'</span>\
						</td>\
                        <td>'+time_ago+'</td>\
                        <td><span class="badge '+status_color+'">'+orders[i].status+'</span></td>\
						<td>';
                        /* html+='<a href="javascript:;" data-id="'+orders[i].id+'" table-order-id="'+orders[i].ordID+'" class="btn btn-sm btn-success btn-view-tableorder mr-1 btn_view_order1"><i class="fas fa-eye"></i></a>'; */
						html+='<a href="javascript:;" order-type="'+orders[i].order_type+'" is-invoiced="'+orders[i].is_invoiced+'" invoice-id="'+orders[i].invoice_id+'" table-order-id="'+orders[i].id+'" data-id="'+orders[i].table_id+'" class="btn btn-sm btn-success btn-view-tableorder1 mr-1 btn_view_order"><i class="fas fa-eye"></i></a>';
                        
						if(orders[i].invoice_ids!="" && orders[i].invoice_ids!=null && orders[i].invoice_ids!='null')
						{
                            var invoice_arr=orders[i].invoice_ids.split(",");
                            
							for(k in invoice_arr)
							{
                                html+='<a target="_blank" href="'+WebOrders.base_url+'restaurant/printbill/'+invoice_arr[k]+'" class="btn btn-sm mr-1 btn-info" style="color:#fff;"><i class="fa fa-print"></i></a>';
                            }
                        }
                        html+='</td>';
                    html+='</tr>';
                }
				console.log(html);
                $('.tbody-tablewiseorder-list').html(html);
                $('.span-all-orders').html(response.total_count);
                $('.span-page-html').html(response.page_total_text);
                $('.btn-current-pageno').attr('curr-page',response.page_no);
                
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