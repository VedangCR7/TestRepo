var Neworders ={
	base_url:null,
    uncheck_ids:new Array(),
    order_type:null,
	init:function() {
		this.bind_events();
		this.gettable();
	},

	bind_events :function() {
		var self=this;
		$('#show_all_tables').on('click','.view_order',this.onvieworder);
		$('#show_other_tables').on('click','.view_order',this.onviewotherorder);
        /*$('#show_all_tables').on('click','.btn-view-onlineorder',this.onviewonlineorder);*/
		/*$('#show_all_tables').on('click','.print_bill_for_table',this.getorderinvoice);*/

	},

	getorderinvoice:function(){
		table_no = $(this).attr('data-id');
		$.ajax({
            url: Neworders.base_url+"restaurant/getorderinvoice",
            type:'POST',
            data:{table_no:table_no},
            success: function(result){
            	table_no = result[0].table_orders_id;
        		ids =[];
        		ids.push(result[0].id);
            	Neworders.printtablebill(table_no,ids);
            	window.open(Neworders.base_url+"restaurant/printbill/"+result.invoice_id,'_blank');
            	Neworders.gettable();
            }
        });
	},

	printtablebill:function(table_no,ids){
		// alert(ids);
		// alert(table_no);
		$.ajax({
            url: Neworders.base_url+"restaurant/create_invoice",
            type:'POST',
            data:{ids:ids,table_order_id:table_no},
            success: function(result){
            	window.open(Neworders.base_url+"restaurant/printbill/"+result.invoice_id,'_blank');
            	Neworders.gettable();
            }
        });
    },

	onvieworder:function(){
		var table_no = $(this).attr('data-id');
		//alert(table_no);
		$.ajax({
            url: Neworders.base_url+"restaurant/getorderdetails",
            type:'POST',
            data:{table_no:table_no},
            success: function(result){
            	window.location.href = Neworders.base_url+'restaurant/tablerecipe/'+table_no+'/'+result[0].id;
            }
        });
	},
	
	onviewotherorder:function(){
		var table_no = $(this).attr('data-id');
		//alert(table_no);
		$.ajax({
            url: Neworders.base_url+"restaurant/getorderdetails",
            type:'POST',
            data:{table_no:table_no},
            success: function(result){
            	window.location.href = Neworders.base_url+'restaurant/tablerecipe/'+table_no+'/'+result[0].id;
            }
        });
	},

	gettable:function(table)
	{
		debugger;
        $.ajax({
            url: Neworders.base_url+"restaurant/gettable",
            type:'POST',
            success: function(result)
			{
				console.log(result);
            	var html ='';
                for (var i = 0; i < result.table_category.length; i++) 
				{
                	html +='<div class="row">\
								<div class="col-lg-12 col-md-12 col-sm-12 col-12"><h5>'+result.table_category[i].title+'</h5></div>\
							</div>\
							<div class="row">';
							for (var j = 0; j < result.table_details.length; j++) 
							{
								if (result.table_details[j].table_category_id == result.table_category[i].id) 
								{
									if (result.table_details[j].is_available == 1) 
									{
                                        console.log(Neworders.order_type);
                                        if(Neworders.order_type=="online")
										{
                                            html+='<div class="col-lg-1 table-billing-div col-md-2 col-sm-4 text-center bg-primary m-1">\
                                                    <a href="javascript:;" class="table-title  mt-3 mb-3 p-3">'+result.table_details[j].title+'</a>\
                                                </div>';
                                        }
										else
										{
                                            html+='<div class="col-lg-1 table-billing-div col-md-2 col-sm-4 text-center bg-primary m-1">\
                                                    <a href="'+Neworders.base_url+'restaurant/tablerecipe/'+result.table_details[j].table_detail_id+'" class="table-title  mt-3 mb-3 p-3">'+result.table_details[j].title+'</a>\
                                                </div>';
                                        }
									}
									else
									{                                       
                                        if(result.table_details[j].table_order)
										{
                                            var table_order=result.table_details[j].table_order;
                                            var orders=table_order.order;
											
											var order_date = orders.created_at;
											var currentdate = new Date(); 
											var current_date = currentdate.getFullYear() + "-"
															+ (currentdate.getMonth()+1)  + "-" 
															+ currentdate.getDate() + " "  
															+ currentdate.getHours() + ":"  
															+ currentdate.getMinutes() + ":" 
															+ currentdate.getSeconds();
											
											var startDate = new Date(order_date);
											var endDate   = new Date(current_date);
											var seconds = (endDate.getTime() - startDate.getTime()) / 1000;
											
											var d = Number(seconds);
											
											if(seconds < 60)
											{
												var s = Math.floor(d % 3600 % 60);
												var time_ago = s > 0 ? s + (s == 1 ? " second" : " seconds ago") : "";
											}
											else if(seconds >= 60 && seconds < 3600)
											{
												var m = Math.floor(d % 3600 / 60);
												var time_ago = m > 0 ? m + (m == 1 ? " minute, " : " minutes ago, ") : "";											
											}
											else if(seconds >= 3600)
											{
												var h = Math.floor(d / 3600);
												var time_ago = h > 0 ? h + (h == 1 ? " hour, " : " hours ago, ") : "";
											}
											
											/* console.log(time_ago);*/
											
											var created_at_time = orders.created_at_time;
											var currenttime = orders.currenttime;
											
											console.log(orders);
											var timeelapsed = table_order.order.in_time;
											var timesplit = timeelapsed.split(':');
											// console.log(table_order.order.in_time);
											//alert(timesplit[0]+','+timesplit[1]+','+timesplit[2]);
											console.log(timesplit);
											
											/* if(timesplit[0] != 00)
											{
												time_ago = timesplit[0]+' hours ago';
											}
											else if(timesplit[0] == 00 && timesplit[1] != 00)
											{
												time_ago = timesplit[1]+' Minuites ago';
											}
											else if(timesplit[0] == 00 && timesplit[1] == 00)
											{
												time_ago = timesplit[2]+' Seconds ago';
											} */
											
                                            if(table_order.order_type=="Billing")
											{
												html+='<div class="col-lg-1 table-billing-div col-md-2 col-sm-4 text-center bg-gray m-1" >';
												html+='<a data-id="'+result.table_details[j].table_detail_id+'" class="table-title view_order mt-3 mb-3 p-3">'+result.table_details[j].title+'</a>';
												html+='</div>';
												/* console.log(table_order.order_type);
												console.log(result.table_details[j].title);
												html+='<div class="col-lg-1 table-billing-div col-md-2 col-sm-4 text-center bg-gray m-1" >';
                                                html+='<a data-id="'+result.table_details[j].table_detail_id+'" class="table-title view_order mt-1 mb-3">'+result.table_details[j].title+'<h6>'+Neworders.currency_symbol+' '+table_order.order.net_total+'</h6> <p>'+time_ago+'</p></a>';
                                                 */

												// if(table_order.order.invoice_id!="" && table_order.order.invoice_id!=null)
												// {
                                                //     html+='<a href="javascript:;" table-order-id="'+table_order.id+'" data-id="'+result.table_details[j].table_detail_id+'" class="btn btn-sm btn-outline-primary view_order btn-view-tableorder mr-1"  style="position:absolute;left:8px;bottom:0px;color:white;border-radius:50%;padding: 1px 4px;"><i class="fas fa-eye"></i></a>';
                                                //     html+='<a href="'+Neworders.base_url+'restaurant/printbill/'+table_order.order.invoice_id+'" table-order-id="'+table_order.id+'" data-id="'+result.table_details[j].table_detail_id+'" class="btn btn-sm btn-outline-info print_bill_for_table mr-1"  style="position:absolute;right:5px;bottom:0px;color:white;border-radius:50%;padding: 1px 5px;" target="_blank"><i class="fas fa-print"></i></a>';
                                                // }
                                                // else
												// {
                                                //     html+='<a href="javascript:;" table-order-id="'+table_order.id+'" data-id="'+result.table_details[j].table_detail_id+'" class="btn btn-sm btn-outline-primary view_order btn-view-tableorder mr-1"  style="position:absolute;left:35%;bottom:0px;color:white;border-radius:50%;padding: 1px 4px;"><i class="fas fa-eye"></i></a>';
                                                // }

                                                /* html+='</div>'; */

                                            }
											else
											{
												console.log(table_order.order_type);
												console.log(result.table_details[j].title);
												
												console.log(orders.cgst_per);
												
												var dis_total_percentage = orders.dis_total_percentage;
												var disc_percentage_total = orders.disc_percentage_total;
												
												if(disc_percentage_total >0)
												{
													var cgst_total = parseFloat((orders.sub_total*orders.cgst_per)/100).toFixed('2');
													var sgst_total = parseFloat((orders.sub_total*orders.sgst_per)/100).toFixed('2');
													var nettotal = parseFloat(orders.net_total).toFixed('2');
												}
												else
												{
													var cgst_total = parseFloat((orders.sub_total*orders.cgst_per)/100).toFixed('2');
													var sgst_total = parseFloat((orders.sub_total*orders.sgst_per)/100).toFixed('2');
													var nettotal = parseFloat(orders.sub_total)+parseFloat(cgst_total)+parseFloat(sgst_total);
												}	
												
												
                                                html+='<div class="col-lg-1 table-billing-div col-md-2 col-sm-4 text-center bg-orange m-1" >';
                                                html+='<a data-id="'+result.table_details[j].table_detail_id+'" class="table-title view_order mt-1 mb-3">'+result.table_details[j].title+'<h6>'+Neworders.currency_symbol+' '+parseFloat(nettotal).toFixed('2')+'</h6> <p>'+time_ago+'</p></a>';
                                                
												if(table_order.order.invoice_id!="" && table_order.order.invoice_id!=null)
												{
                                                    html+='<a href="'+Neworders.base_url+'restaurant/onlineorder/'+result.table_details[j].table_detail_id+'/'+table_order.id+'" table-order-id="'+table_order.id+'" data-id="'+result.table_details[j].table_detail_id+'" class="btn btn-sm btn-primary mr-1 btn-view-tableorder"  style="position:absolute;left:8px;bottom:0px;color:white;border-radius:50%;padding: 1px 4px;"><i class="fas fa-eye"></i></a>';
                                                    html+='<a href="'+Neworders.base_url+'restaurant/printbill/'+table_order.order.invoice_id+'" table-order-id="'+table_order.id+'" data-id="'+result.table_details[j].table_detail_id+'" class="btn btn-sm btn-info print_bill_for_table mr-1"  style="position:absolute;right:5px;bottom:0px;color:white;border-radius:50%;padding: 1px 5px;" target="_blank"><i class="fas fa-print"></i></a>';
                                                }
                                                else
												{
                                                    html+='<a href="'+Neworders.base_url+'restaurant/onlineorder/'+result.table_details[j].table_detail_id+'/'+table_order.id+'" table-order-id="'+table_order.id+'" data-id="'+result.table_details[j].table_detail_id+'" class="btn btn-sm btn-outline-primary btn-view-tableorder mr-1"  style="position:absolute;left:35%;bottom:0px;color:white;border-radius:50%;padding: 1px 4px;"><i class="fas fa-eye"></i></a>';
                                                }
                                                html+='</div>';
                                            }
                                        }
										else
										{
											console.log(result.table_details[j].title);
											html+='<div class="col-lg-1 table-billing-div col-md-2 col-sm-4 text-center bg-gray m-1" >';
                                            html+='<a data-id="'+result.table_details[j].table_detail_id+'" class="table-title view_order mt-3 mb-3 p-3">'+result.table_details[j].title+'</a>';
                                            html+='</div>';
                                        }
									}
								} 
                            }
							html+='</div>';
							html+='<div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-12"><hr style="margin-bottom: 1rem;margin-top: 1rem;"></div></div>'
                }
                $('#show_all_tables').html(html);
				
				var htmlNew ='';
				htmlNew +='<div class="row">';
                for (var i = 0; i < result.table_other_category.length; i++) 
				{
					for (var j = 0; j < result.table_other_details.length; j++)
					{
						if (result.table_other_details[j].table_category_id == result.table_other_category[i].id) 
						{
							if (result.table_other_details[j].is_available == 1)
							{
								console.log(Neworders.order_type);
								if(Neworders.order_type=="online")
								{
									htmlNew+='<div class="col-lg-2 table-billing-div col-md-2 col-sm-4 text-center bg-secondary m-1">\
											<a href="javascript:;" class="table-title  mt-3 mb-3 p-3">'+result.table_other_details[j].title+'</a>\
									<a href="'+Neworders.base_url+'restaurant/alltakeorders/'+result.table_other_details[j].table_detail_id+'" class="btn btn-sm btn-outline-primary view_order btn-view-tableorder mr-1"  style="position:absolute;left:45%;bottom:0px;color:white;border-radius:50%;padding: 1px 4px;"><i class="fas fa-eye"></i></a>';										
									htmlNew+='</div>';
								}
								else
								{
									htmlNew+='<div class="col-lg-2 table-billing-div col-md-2 col-sm-4 text-center bg-secondary m-1">\
											<a href="'+Neworders.base_url+'restaurant/tablerecipe/'+result.table_other_details[j].table_detail_id+'" class="table-title  mt-3 mb-3 p-3">'+result.table_other_details[j].title+'</a>\
									<a href="'+Neworders.base_url+'restaurant/alltakeorders/'+result.table_other_details[j].table_detail_id+'" class="btn btn-sm btn-outline-primary view_order btn-view-tableorder mr-1"  style="position:absolute;left:45%;bottom:0px;color:white;border-radius:50%;padding: 1px 4px;"><i class="fas fa-eye"></i></a>';
										htmlNew+='</div>';
								}
								
							}
							else
							{                                       
								if(result.table_other_details[j].table_order)
								{
									var table_order=result.table_other_details[j].table_order;
									
									if(table_order.order_type=="Billing")
									{
										htmlNew+='<div class="col-lg-1 table-billing-div col-md-2 col-sm-4 text-center bg-gray m-1" >';
										htmlNew+='<a data-id="'+result.table_other_details[j].table_detail_id+'" class="table-title view_order mt-1 mb-3">'+result.table_other_details[j].title+'<h6>&#8377; '+parseFloat(table_order.order.net_total).toFixed(2)+'</h6> <p>'+table_order.order.in_time+'</p></a>';
										
										if(table_order.order.invoice_id!="" && table_order.order.invoice_id!=null)
										{
											htmlNew+='<a href="javascript:;" table-order-id="'+table_order.id+'" data-id="'+result.table_other_details[j].table_detail_id+'" class="btn btn-sm btn-outline-primary view_order btn-view-tableorder mr-1"  style="position:absolute;left:8px;bottom:0px;color:white;border-radius:50%;padding: 1px 4px;"><i class="fas fa-eye"></i></a>';
											htmlNew+='<a href="'+Neworders.base_url+'restaurant/printbill/'+table_order.order.invoice_id+'" table-order-id="'+table_order.id+'" data-id="'+result.table_other_details[j].table_detail_id+'" class="btn btn-sm btn-outline-info print_bill_for_table mr-1"  style="position:absolute;right:5px;bottom:0px;color:white;border-radius:50%;padding: 1px 5px;" target="_blank"><i class="fas fa-print"></i></a>';
										}
										else
										{
											htmlNew+='<a href="javascript:;" table-order-id="'+table_order.id+'" data-id="'+result.table_other_details[j].table_detail_id+'" class="btn btn-sm btn-outline-primary view_order btn-view-tableorder mr-1"  style="position:absolute;left:35%;bottom:0px;color:white;border-radius:50%;padding: 1px 4px;"><i class="fas fa-eye"></i></a>';
										}
										htmlNew+='</div>';
									}
									else if(table_order.order_type=="Takeaway")
									{
										htmlNew+='<div class="col-lg-1 table-billing-div col-md-2 col-sm-4 text-center bg-gray m-1" >';
										htmlNew+='<a data-id="'+result.table_other_details[j].table_detail_id+'" class="table-title view_order mt-1 mb-3">'+result.table_other_details[j].title+'<h6>&#8377; '+parseFloat(table_order.order.net_total).toFixed(2)+'</h6> <p>'+table_order.order.in_time+'</p></a>';
										
										if(table_order.order.invoice_id!="" && table_order.order.invoice_id!=null)
										{
											htmlNew+='<a href="javascript:;" table-order-id="'+table_order.id+'" data-id="'+result.table_other_details[j].table_detail_id+'" class="btn btn-sm btn-outline-primary view_order btn-view-tableorder mr-1"  style="position:absolute;left:8px;bottom:0px;color:white;border-radius:50%;padding: 1px 4px;"><i class="fas fa-eye"></i></a>';
											htmlNew+='<a href="'+Neworders.base_url+'restaurant/printbill/'+table_order.order.invoice_id+'" table-order-id="'+table_order.id+'" data-id="'+result.table_other_details[j].table_detail_id+'" class="btn btn-sm btn-outline-info print_bill_for_table mr-1"  style="position:absolute;right:5px;bottom:0px;color:white;border-radius:50%;padding: 1px 5px;" target="_blank"><i class="fas fa-print"></i></a>';
										}
										else
										{
											htmlNew+='<a href="javascript:;" table-order-id="'+table_order.id+'" data-id="'+result.table_other_details[j].table_detail_id+'" class="btn btn-sm btn-outline-primary view_order btn-view-tableorder mr-1"  style="position:absolute;left:35%;bottom:0px;color:white;border-radius:50%;padding: 1px 4px;"><i class="fas fa-eye"></i></a>';
										}
										htmlNew+='</div>';
									}
									else
									{
										htmlNew+='<div class="col-lg-1 table-billing-div col-md-2 col-sm-4 text-center bg-orange m-1" >';
										htmlNew+='<a data-id="'+result.table_other_details[j].table_detail_id+'" class="table-title view_order mt-1 mb-3">'+result.table_other_details[j].title+'<h6>&#8377; '+parseFloat(table_order.order.net_total).toFixed(2)+'</h6> <p>'+table_order.order.in_time+'</p></a>';
										
										if(table_order.order.invoice_id!="" && table_order.order.invoice_id!=null)
										{
											htmlNew+='<a href="'+Neworders.base_url+'restaurant/onlineorder/'+result.table_other_details[j].table_detail_id+'/'+table_order.id+'" table-order-id="'+table_order.id+'" data-id="'+result.table_other_details[j].table_detail_id+'" class="btn btn-sm btn-primary mr-1 btn-view-tableorder"  style="position:absolute;left:8px;bottom:0px;color:white;border-radius:50%;padding: 1px 4px;"><i class="fas fa-eye"></i></a>';
											htmlNew+='<a href="'+Neworders.base_url+'restaurant/printbill/'+table_order.order.invoice_id+'" table-order-id="'+table_order.id+'" data-id="'+result.table_other_details[j].table_detail_id+'" class="btn btn-sm btn-info print_bill_for_table mr-1"  style="position:absolute;right:5px;bottom:0px;color:white;border-radius:50%;padding: 1px 5px;" target="_blank"><i class="fas fa-print"></i></a>';
										}
										else
										{
											htmlNew+='<a href="'+Neworders.base_url+'restaurant/onlineorder/'+result.table_other_details[j].table_detail_id+'/'+table_order.id+'" table-order-id="'+table_order.id+'" data-id="'+result.table_other_details[j].table_detail_id+'" class="btn btn-sm btn-outline-primary btn-view-tableorder mr-1"  style="position:absolute;left:35%;bottom:0px;color:white;border-radius:50%;padding: 1px 4px;"><i class="fas fa-eye"></i></a>';
										}
										htmlNew+='</div>';
									}
								}
								else
								{
									 htmlNew+='<div class="col-lg-2 table-billing-div col-md-2 col-sm-4 text-center bg-gray m-1" >';
									htmlNew+='<a data-id="'+result.table_other_details[j].table_detail_id+'" class="table-title view_order mt-3 mb-3 p-3">'+result.table_other_details[j].title+'</a>';
									htmlNew+='</div>';
								}
							}
						} 
					}
                }
				htmlNew+='</div>';
				htmlNew+='<div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-12"><hr style="margin-bottom: 1rem;margin-top: 1rem;"></div></div>'
				$('#show_other_tables').html(htmlNew);
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
    }
};
