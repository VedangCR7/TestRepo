var Newregistration ={
    base_url:null,
    init:function() {
        this.bind_events();
        this.listmanager();
    },

    bind_events :function() {
        var self=this;
        $('.tbody-group-list').on('click','.a-delete-group',this.onDeleteManager);
        $('.tbody-group-list').on('click','.a-view-group',this.onViewuser);
        $('.tbody-group-list').on('click','.a-verify-group',this.onVerifyuser);


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

    onVerifyuser:function(){
        var self=this;
        var data_id=$(this).attr('data-id');
        var formData={
            data_id : data_id
        }
        $.ajax({
            url: Newregistration.base_url+"admin/verify_registration",
            type:'POST',
            data:formData,
            success: function(result){
                Newregistration.listmanager();
            }
        });
    },

    onViewuser:function(){
        var self=this;
        var data_id=$(this).attr('data-id');
        var formData={
            id : data_id
        }
        $.ajax({
            url: Newregistration.base_url+"admin/view_register_user",
            type:'POST',
            data:formData ,
            success: function(result){
                var html ='';
                html +='<div class="row">\
            <div class="col-lg-12 col-md-12 col-sm-12 col-12" style="margin-top:10px;">\
                <span>Business Name : ';
                        html+=result[0].business_name;
                html+='</span>\
            </div>\
            <div class="col-lg-12 col-md-12 col-sm-12 col-12" style="margin-top:10px;">\
                <span>Contact Person : ';
                        html+=result[0].name;
                html+='</span>\
            </div>\
            <div class="col-lg-12 col-md-12 col-sm-12 col-12" style="margin-top:10px;">\
                <span>Email : ';
                        html+=result[0].email;
                html+='</span>\
            </div>\
            <div class="col-lg-12 col-md-12 col-sm-12 col-12" style="margin-top:10px;">\
                <span>Restaurant Type : ';
                        html+=result[0].restauranttype;
                html+='</span>\
            </div>\
            <div class="col-lg-12 col-md-12 col-sm-12 col-12" style="margin-top:10px;">\
                <span>User Type : ';
                        html+=result[0].usertype;
                html+='</span>\
            </div>';
                $('.show_rest_details').html(html);
                $('#myModal').modal('show');
                Newregistration.listmanager();
            }
        });
    },

    onDeleteManager:function(){
        var self=this;
        var data_id=$(this).attr('data-id');
        var title='Are you sure ?';
        var text="Delete Registration";
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
                url: Newregistration.base_url+"admin/delete_perticular_registration",
                type:'POST',
                data:formData ,
                success: function(result){
                   if (result.status) {
                        Newregistration.displaysucess("Delete successfully");
                       Newregistration.listmanager();
                   }
                   else{
                        Newregistration.displaywarning("Something went wrong please try again");
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



    
    listmanager:function(){
        //console.log(data);
        $.ajax({
            url: Newregistration.base_url+"Admin/list_new_registrations/",
            type:'POST',
            dataType: 'json',
            success: function(response){
                html='';
                j=1;
                for (var i = 0; i < response.length; i++) {
                    html+='<tr>\
                    <td>'+j+'</td>\
                    <td>';
                        html+=response[i].business_name;
                    html+='</td>\
                    <td>';
                        html+=response[i].usertype;
                    html+='</td>\
                    <td>';
                        html+=response[i].name;
                    html +='</td>\
                    <td>';
                        html+=response[i].contact_number;
                    html +='</td>\
                    <td>';
                        html+=response[i].email;
                    html +='</td>\
                    <td>';
                        html+=Newregistration.convertDateStringToDate(response[i].date);
                    html +='</td>\
                    <td>\
                    <a class="a-view-group text-info" data-id="'+response[i].id+'" style="cursor: pointer;"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\
                    <a class="a-delete-group" data-id="'+response[i].id+'" style="color:#f19999;cursor: pointer;"><i class="fa fa-trash"></i></a>\
                    </td>\
                    </tr>';
                    j=j+1;
                    
                }
                $('.tbody-group-list').html(html);
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