var Allrestaurants ={
    base_url:null,
    init:function() {
        this.bind_events();
        var data={
            per_page : $('.btn-per-page').attr('selected-per-page'),
            page:1,
            restaurant_status:$('#restaurant_status').val()
        }
        this.listmanager(data);
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
                restaurant_status:$('#restaurant_status').val()
            }
            Allrestaurants.listmanager(data);
        });
        $('.btn-prev').on('click',function(){
            var data={
                per_page:$('.dropdown-toggle').attr('selected-per-page'),
                page:$(this).attr('page-no'),
                restaurant_status:$('#restaurant_status').val()
            }
            Allrestaurants.listmanager(data);
        });
        $('.btn-next').on('click',function(){
            var data={
                per_page:$('.dropdown-toggle').attr('selected-per-page'),
                page:$(this).attr('page-no'),
                restaurant_status:$('#restaurant_status').val()
            }
            Allrestaurants.listmanager(data);
        });
        $('#searchInput').on('keyup',function(){
           
             if($(this).val()==""){
                var data={
                    per_page:$('.dropdown-toggle').attr('selected-per-page'),
                    page:1,
                    restaurant_status:$('#restaurant_status').val()
                }
                Allrestaurants.listmanager(data,'fromsearch');
            }else{
                if($(this).val().length>=3){
                    var data={
                        per_page:'all',
                        page:1,
                        searchkey:$('#searchInput').val(),
                        restaurant_status:$('#restaurant_status').val()
                    }
                    Allrestaurants.listmanager(data,'fromsearch');
                }
            }
        });

        $('.tbody-group-list').on('click','.input-switch-box',this.changeStatusManager);
        $('.tbody-group-list').on('click','.a-delete-group',this.onDeleteManager);
        $('.tbody-group-list').on('click','.a-view-group',this.onViewRestaurant);
        $('#restaurant_status').on('change',this.onChangeactive);


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

    onChangeactive:function(){
        var data={
            per_page : $('.btn-per-page').attr('selected-per-page'),
            page:1,
            restaurant_status:$('#restaurant_status').val()
        }
        Allrestaurants.listmanager(data);
    },

    onViewRestaurant:function(){
        var self=this;
        var data_id=$(this).attr('data-id');
        var formData={
            id : data_id
        }
        $.ajax({
            url: Allrestaurants.base_url+"admin/view_restaurant",
            type:'POST',
            data:formData ,
            success: function(result){
                var html ='';
                html +='<div class="row">\
            <div class="col-lg-12 col-md-12 col-sm-12 col-12"><h6>Restaurant Details</h6></div>\
            <div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;">\
                <span>Business Name : '+result[0].business_name+'</span>\
            </div>';
            if (result[0].contact_number != null) {
            html +='<div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;">\
                <span>Contact Number : '+result[0].contact_number+'</span>\
            </div>';
            }
            if (result[0].address != null) {
            html +='<div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;">\
                <span>Address : '+result[0].address+'</span>\
            </div>';
            }
            if (result[0].postcode != null) {
            html+='<div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;">\
                <span>Postal code : '+result[0].postcode+'</span>\
            </div>';
            }
            if (result[0].city != null) {
            html+='<div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;">\
                <span>City : '+result[0].city+'</span>\
            </div>';
            }
            if (result[0].country != null) {
            html +='<div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;">\
                <span>Country : '+result[0].country+'</span>\
            </div>';
            }
            if (result[0].currency != null) {
            html +='<div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;">\
                <span>Currency : '+result[0].currency+'</span>\
            </div>';
            }
            if (result[0].restauranttype != null) {
            html+='<div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;">\
                <span>Restaurant Type : '+result[0].restauranttype+'</span>\
            </div>';
            }
            if (result[0].opening_time != null) {
            html+='<div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;">\
                <span>Opening Time : '+result[0].opening_time+'</span>\
            </div>';
            }
            if (result[0].close_time != null) {
            html+='<div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;">\
                <span>Closing Time : '+result[0].close_time+'</span>\
            </div>';
            }
            html +='<div class="col-lg-12 col-md-12 col-sm-12 col-12"><hr></div>';
            if (result[0].name != null) {
            html+='<div class="col-lg-12 col-md-12 col-sm-12 col-12"><h6>Owner Details</h6></div>\
            <div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;">\
                <span>Name : '+result[0].name+'</span>\
            </div>';
            }
            if (result[0].email != null) {
            html+='<div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;">\
                <span>Email : '+result[0].email+'</span>\
            </div>';
            }
            if (result[0].owner_contact_no != null) {
            html+='<div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;">\
                <span>Phone Number : '+result[0].owner_contact_no+'</span>\
            </div>';
            }
            if (result[0].owner_address != null) {
            html+='<div class="col-lg-4 col-md-4 col-sm-12 col-12" style="margin-top:10px;">\
                <span>Address : '+result[0].owner_address+'</span>\
            </div>';
            }
        html +='</div>';
                $('.show_rest_details').html(html);
                $('#myModal').modal('show');
                var data={
                    per_page:$('.btn-per-page').attr('selected-per-page'),
                    page:1,
                    restaurant_status:$('#restaurant_status').val()
                }
                Allrestaurants.listmanager(data);
            }
        });
    },


    changeStatusManager:function(){
        if($(this).is(':checked')){
            $(this).val("on");
            Allrestaurants.displaysucess("Restaurant is Active now");}
        else{
            $(this).val("off");
            Allrestaurants.displaysucess("Restaurant is Inactive now");
        }

        var self=this;
        var data_id=$(this).attr('data-id');
        var formData={
            id : data_id,
            is_active:$(this).val()
        }
        $.ajax({
            url: Allrestaurants.base_url+"admin/delete_restaurant",
            type:'POST',
            data:formData ,
            success: function(result){
               if (result.status) {
                //Waitingmanager.displaysucess("Status Changed successfully");
                    var data={
                        per_page:$('.btn-per-page').attr('selected-per-page'),
                        page:1,
                        restaurant_status:$('#restaurant_status').val()
                    }
                   Allrestaurants.listmanager(data);
               }
               else{
                    Allrestaurants.displaywarning("Something went wrong please try again");
               }
            }
        });
    },


    onDeleteManager:function(){
        var self=this;
        var data_id=$(this).attr('data-id');
        var title='Are you sure ?';
        var text="Delete Restaurant";
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
                id : data_id
            } 
            $.ajax({
                url: Allrestaurants.base_url+"admin/delete_perticular_restaurant",
                type:'POST',
                data:formData ,
                success: function(result){
                   if (result.status) {
                        Allrestaurants.displaysucess("Delete successfully");
                        var data={
                            per_page:$('.btn-per-page').attr('selected-per-page'),
                            page:1,
                            restaurant_status:$('#restaurant_status').val()
                        }
                       Allrestaurants.listmanager(data);
                   }
                   else{
                        Allrestaurants.displaywarning("Something went wrong please try again");
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



    
    listmanager:function(data,fromevent){
        console.log(data);
        $.ajax({
            url: Allrestaurants.base_url+"Admin/list_restaurants/",
            type:'POST',
            dataType: 'json',
            data: data,
            success: function(response){
                var managers=response.manager;
                var html="";
                var j=1;
                for (i in managers) {
					var pass = managers[i].password;
                    html+='<tr menu-id="'+managers[i].id+'"><td>'+j+'</td>';
                            html+='<td>'+managers[i].business_name+'</td>\
                            <td>';
                            if (managers[i].address != null) {
                                html += managers[i].address
                            } 
                            else{
                                html+='';
                            }
                            html +='</td>\
                            <td>';
                            if (managers[i].contact_number != null) {
                                html += managers[i].contact_number
                            } 
                            else{
                                html+='';
                            }
                            html+='</td>\
                            <td>'+managers[i].email+'</td>\
							<td>'+pass+'</td>';
                            //if (managers[i].payment_end_date != null) {
                              //  html += '<td>'+Allrestaurants.convertDateStringToDate(managers[i].payment_end_date)+'</td>';
                            //}
                            //else{
                              //  html+='<td></td>';
                            //}
                            html +='<td class="text-center">\
                                <label class="custom-switch pl-0">';
                                if(managers[i].is_active==1)
                                    html+='<input type="checkbox" name="custom-switch-checkbox" data-id="'+managers[i].id+'" class="custom-switch-input input-switch-box" checked>';
                                else
                                    html+='<input type="checkbox" name="custom-switch-checkbox" data-id="'+managers[i].id+'" class="custom-switch-input input-switch-box">';
                                    html+='<span class="custom-switch-indicator"></span>\
                                </label>\
                            </td>\
                            <td>\
                            <a class="a-view-group" data-id="'+managers[i].id+'" style="color:green;cursor: pointer;"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\
                             <a class="a-delete-group" data-id="'+managers[i].id+'" style="color:#f19999;cursor: pointer;"><i class="fa fa-trash"></i></a>\
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

    convertDateStringToDate:function(dateStr) {
        //  Convert a string like '2020-10-04T00:00:00' into '4/Oct/2020'
        let months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        let date = new Date(dateStr);
        let str = date.getDate()
        + ' ' + months[date.getMonth()]
        + ' ' + date.getFullYear()
        return str;
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