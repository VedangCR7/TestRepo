var EmployeeDetails = {
    base_url: null,
    init: function() {
        this.bind_events();
        var data = {
            per_page: $('.btn-per-page').attr('selected-per-page'),
            page: 1
        }
        this.listGroups(data);
        this.listCategory();
        $('.clssubCategory').hide();
    },

    // Bind data to popup model
    bind_events: function() {
        var self = this;
        // Search Filter & Pagination
        $('.a-recipe-perpage').on('click', function() {
            $(this).closest('.btn-group').find('button').attr('selected-per-page', $(this).attr('data-per'));
            if ($(this).attr('data-per') == "all")
                $(this).closest('.btn-group').find('button').html($(this).html() + ' items');
            else
                $(this).closest('.btn-group').find('button').html($(this).html() + ' items per page');
            var data = {
                per_page: $(this).attr('data-per'),
                page: 1
            }
            EmployeeDetails.listGroups(data);
        });
        $('.btn-prev').on('click', function() {
            var data = {
                per_page: $('.dropdown-toggle').attr('selected-per-page'),
                page: $(this).attr('page-no')
            }
            EmployeeDetails.listGroups(data);
        });
        $('.btn-next').on('click', function() {
            var data = {
                per_page: $('.dropdown-toggle').attr('selected-per-page'),
                page: $(this).attr('page-no')
            }
            EmployeeDetails.listGroups(data);
        });
        $('#searchInput').on('keyup', function() {
            if ($(this).val() == "") {
                var data = {
                    per_page: $('.dropdown-toggle').attr('selected-per-page'),
                    page: 1
                }
                EmployeeDetails.listGroups(data, 'fromsearch');
            } else {
                if ($(this).val().length >= 3) {
                    var data = {
                        per_page: 'all',
                        page: 1,
                        searchkey: $('#searchInput').val()
                    }
                    EmployeeDetails.listGroups(data, 'fromsearch');
                }
            }
        });
        $('.tbody-group-list').on('click', '.input-switch-box', this.deleteGroup);
        $('.tbody-group-list').on('click', '.a-delete-group', this.onDeleteGroup);
        $('.tbody-group-list').on('click', '.a-edit-group', this.onEditManager);
        $('.edit_manager').on('click', '.editperticular_manager', this.onEditPerticularManager);
        $('.btn-save-details').on('click', this.onSaveEmployee);
        $('.edit_manager').on('click', '.closeedit', this.oncancelEditManager);
        $('#AddMenuGroup').on('keypress', function(e) {
            var regex = new RegExp("^[a-zA-Z0-9_~!@#$%&*^()`~':.?,;{}|<> ]+$");
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
            if (regex.test(str)) {
                return true;
            }
            e.preventDefault();
            return false;
        });
        $('.tbody-group-list').on('click', '.up,.down', function() {
            var row = $(this).parents('tr:first'),
                $reindex_start;
            //   console.log($reindex_start);
            if ($(this).is('.up')) {
                row.insertBefore(row.prev());
                $reindex_start = row;
            } else {
                $reindex_start = row.next()
                row.insertAfter($reindex_start);
            }
            row.focus();
            var data = [];
            var seq = 1;
            $('.tbody-group-list tr').each(function() {
                var row = {
                    id: $(this).attr('menu-id'),
                    seq: seq
                }
                data.push(row);
                seq++;
            });
            //   console.log(data);
            EmployeeDetails.onSaveSequence(data);
        });

        // After click on category dropdown
        $('#emp_category').on('change', function() {
            $('.clssubCategory').show();
            var master_category_id = $(this).val();
            $.ajax({
                url: EmployeeDetails.base_url + "Employee_master_controller/get_sub_category",
                type: 'POST',
                dataType: 'json',
                data: {
                    master_category_id: master_category_id
                },
                success: function(result) {
                    // console.log("Result is " + JSON.stringify(result));
                    var html = '';
                    html += '<option value="0" selected disabled>Select</option>';
                    for (i = 0; i < result.length; i++) {
                        html += '<option value="' + result[i].kitchen_staff_id + '">' + result[i].kitchen_staff_name + '</option>';
                    }
                    $('#emp_sub_category').html(html);
                }
            });
        });

        // On change of category dropdown get sub-category list
        $('.edit_manager').on('change', '#upd_emp_category', function() {
            // alert("Hi");
            var master_category_id = $(this).val();
            // alert(master_category_id);
            $.ajax({
                url: EmployeeDetails.base_url + "Employee_master_controller/get_sub_category",
                type: 'POST',
                dataType: 'json',
                data: {
                    master_category_id: master_category_id
                },
                success: function(result) {
                    var sub_cat_details = JSON.stringify(result);
                    // console.log("Result is " + sub_cat_details);
                    var html = '';
                    html += '<option value="0" selected disabled>Select</option>';
                    for (i = 0; i < result.length; i++) {
                        if (result[i].kitchen_staff_id == $('#upd_emp_category').val()) {

                            html += '<option value="' + result[i].kitchen_staff_id + '" selected>' + result[i].kitchen_staff_name + '</option>';
                        } else {
                            html += '<option value="' + result[i].kitchen_staff_id + '">' + result[i].kitchen_staff_name + '</option>';
                        }
                    }
                    $('#upd_sub_category').html(html);
                }
            });
        });
    },

    onChangeCategory: function(categoryid, subcategoryid) {
        var master_category_id = categoryid;
        $.ajax({
            url: EmployeeDetails.base_url + "Employee_master_controller/get_sub_category",
            type: 'POST',
            dataType: 'json',
            data: {
                master_category_id: master_category_id
            },
            success: function(result) {
                var sub_cat_details = JSON.stringify(result);
                // console.log("new response is : " + sub_cat_details);              
                var html = '';
                html += '<option value="0" selected disabled>Select *</option>';
                for (i = 0; i < result.length; i++) {
                    html += '<option value="' + result[i].kitchen_staff_id + '">' + result[i].kitchen_staff_name + '</option>';
                }
                $('#upd_sub_category').html(html);
                $("#upd_sub_category").val(subcategoryid);

            }
        });

    },

    // cancel edit box
    oncancelEditManager: function() {
        $('.edit_manager').hide();
    },

    // list category in dropdown on page load 
    listCategory: function() {
        $.ajax({
            url: EmployeeDetails.base_url + "Employee_master_controller/show_category_details",
            success: function(result) {
                // console.log(result);
                var html = '';
                html += '<option value="0" selected disabled>Select *</option>';
                for (i = 0; i < result.length; i++) {
                    html += '<option value="' + result[i].id + '">' + result[i].category_name + '</option>';
                }
                $('#emp_category').html(html);
            }
        });
    },

    // update html design code
    onEditManager: function() {
        $("html").animate({ scrollTop: 0 }, "slow");
        var self = this;
        var data_id = $(this).attr('data-id');
        var html = '';
        var formData = {
            id: data_id
        }
        $.ajax({
            url: EmployeeDetails.base_url + "Employee_master_controller/show_individual_details",
            type: 'POST',
            data: formData,
            success: function(result) {
                // console.log("Individeual response is " + JSON.stringify(result));
                var data = {
                    per_page: $('.btn-per-page').attr('selected-per-page'),
                    page: 1
                }
                EmployeeDetails.listGroups(data);
                var html = '';
                var categoryid = result.individual_emp.category;
                var subcategoryid = result.individual_emp.emp_sub_category;
                // alert("before html tag: " + categoryid);
                html += '<div class="col-md-12">\
                       <div class="card welcome-image">\
                           <div class="card-body">\
                               <div class="row">\
                                   <div class="col-md-11">\
                                       <form class="form-recipe-edit" method="post" action="javascript:;">\
                                           <div class="row" style="justify-content: center;">\
                                               <div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:10px;">\
                                                   <label style="font-weight:bold;">Category</label>\
                                                   <select class="form-control" id="upd_emp_category">';
                for (var i = 0; i < result.category.length; i++) {
                    if (result.category[i].id == result.individual_emp.category) {
                        html += '<option value="' + result.category[i].id + '" selected="selected">' + result.category[i].category_name + '</option>'
                    } else {
                        html += '<option value="' + result.category[i].id + '">' + result.category[i].category_name + '</option>'
                    }
                }
                html += '</select>\
                                               </div>\
                                               <div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:10px;">\
                                               <label style="font-weight:bold;">Sub-Category</label>\
                                               <select class="form-control" id="upd_sub_category"></select>\
                                                </div>\
                                               <div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:10px;">\
                                                   <label style="font-weight:bold;">Name *</label>\
                                                   <input type="text" name="emp_name" id="upd_emp_name" value="' + result.individual_emp.emp_name + '" required class="form-control" placeholder="Enter Name">\
                                               </div>\
                                               \
                                               <div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:10px;">\
                                                   <label style="font-weight:bold;">Contact Number *</label>\
                                                   <input type="text" name="employeecontact_number" minlength="10" maxlength="14" required onkeypress="return onlyNumberKey(event)" id="upd_emp_contact" value="' + result.individual_emp.emp_contact + '" class="form-control" placeholder="Enter Contact Number">\
                                               </div>\
                                           </div>\
                                           <div class="row" style="justify-content: center;">\
                                                <div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:10px;">\
                                                   <label style="font-weight:bold;">Email</label>\
                                                   <input type="email" name="emp_email" id="upd_emp_email" value="' + result.individual_emp.emp_email + '" class="form-control" placeholder="Enter Email">\
                                               </div>\
                                               <div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:10px;">\
                                                   <label style="font-weight:bold;">Address</label>\
                                                   <input type="text" name="emp_address" id="upd_emp_address" value="' + result.individual_emp.emp_address + '" class="form-control" placeholder="Enter Address">\
                                               </div>\
                                               <div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:10px;">\
                                                   <label style="font-weight:bold;">Aadhaar Card *</label>\
                                                   <input type="text" name="emp_aadhaar_no" minlength="4" maxlength="12" required id="upd_emp_aadhaar_no" onkeypress="return onlyNumberKey(event)" value="' + result.individual_emp.emp_aadhaar_no + '" class="form-control" placeholder="Enter Aadhaar no" readonly>\
                                               </div>\
                                              \
                                           </div>\
                                           <div class="row m-5" style="justify-content: center;">\
                                               <button type="submit" data-id="' + result.individual_emp.emp_id + '" class="btn btn-secondary btn-save-details editperticular_manager" type="button" style="background-color: #ED3573;border: 0px !important;float:right;margin-top:10px;margin-top: 1rem;">Save Changes</button>\
                                                   <button type="button" class="btn btn-default closeedit" id="closeedit" style="background-color: #ede3e7;;border: 0px !important;float:right;margin-left:10px;margin-top: 1rem;">Cancel</button>\
                                           </div>\
                                       </form>\
                                   </div>\
                               </div>\
                           </div>\
                       </div>\
                   </div>';
                $('.edit_manager').html(html);
                $('.edit_manager').show();
                $(".addEmployeeDetails").hide();
                EmployeeDetails.onChangeCategory(categoryid, subcategoryid);
            }

        });
    },

    // Update employee details
    onEditPerticularManager: function() {
        // alert($('#upd_emp_category').val());
        if ($('#upd_emp_name').val() != '') {
            if ($('#upd_emp_contact').val().length < 10 || $('#upd_emp_contact').val().length > 14) {
                EmployeeDetails.displaywarning("Contact Number Should be 10 to 14 digit");
                $('.edit_manager').show();
            } else {
                if ($('#upd_emp_aadhaar_no').val().length < 12 || $('#upd_emp_aadhaar_no').val().length > 12) {
                    EmployeeDetails.displaywarning("Aadhaar Number Should be 12 digit");
                    $('.edit_manager').show();
                } else {
                    var self = this;
                    var data_id = $(this).attr('data-id');
                    var formData = {
                        id: data_id,
                        emp_category: $('#upd_emp_category').val(),
                        emp_sub_category: $('#upd_sub_category').val(),
                        emp_name: $('#upd_emp_name').val(),
                        emp_contact: $('#upd_emp_contact').val(),
                        emp_email: $('#upd_emp_email').val(),
                        emp_address: $('#upd_emp_address').val(),
                        emp_aadhaar_no: $('#upd_emp_aadhaar_no').val(),
                    }
                    $.ajax({
                        url: EmployeeDetails.base_url + "Employee_master_controller/editEmployee",
                        type: 'POST',
                        data: formData,
                        success: function(result) {
                            if (result.status) {
                                EmployeeDetails.displaysucess(result.msg);
                                var data = {
                                    per_page: $('.btn-per-page').attr('selected-per-page'),
                                    page: 1
                                }
                                EmployeeDetails.listGroups(data);
                            } else {
                                EmployeeDetails.displaywarning(result.msg);
                                var data = {
                                    per_page: $('.btn-per-page').attr('selected-per-page'),
                                    page: 1
                                }
                                EmployeeDetails.listGroups(data);
                            }
                        }
                    });
                }
            }

        } else {
            EmployeeDetails.displaywarning("Please Fill all the fields");
        }
    },

    //Save Employee details 
    onSaveEmployee: function() {
        // var category = $('#emp_category').val();
        // alert(category);
        if ($('#emp_category').val() == "0") {
            EmployeeDetails.displaywarning("Please select category");
            $('.edit_manager').show();
        }
        if ($('#emp_name').val() != '') {
            if ($('#emp_contact').val().length < 10 || $('#emp_contact').val().length > 14) {
                EmployeeDetails.displaywarning("Contact Number Should be 10 to 14 digit");
                $('.edit_manager').show();
            } else {
                if ($('#emp_aadhaar_no').val().length < 12 || $('#emp_aadhaar_no').val().length > 12) {
                    EmployeeDetails.displaywarning("Aadhaar Number Should be 12 digit");
                    $('.edit_manager').show();
                } else {
                    $.ajax({
                        url: EmployeeDetails.base_url + "Employee_master_controller/addEmployee",
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            emp_category: $('#emp_category').val(),
                            emp_sub_category: $('#emp_sub_category').val(),
                            emp_name: $('#emp_name').val(),
                            emp_email: $('#emp_email').val(),
                            emp_contact: $('#emp_contact').val(),
                            emp_address: $('#emp_address').val(),
                            emp_aadhaar_no: $('#emp_aadhaar_no').val()
                        },
                        success: function(result) {
                            // console.log(result);
                            if (result.status) {
                                EmployeeDetails.displaysucess(result.msg);
                                $('#emp_category').val('');
                                $('#emp_name').val('');
                                $('#emp_email').val('');
                                $('#emp_contact').val('');
                                $('#emp_address').val('');
                                $('#emp_aadhaar_no').val('');

                                var data = {
                                    per_page: $('.btn-per-page').attr('selected-per-page'),
                                    page: 1
                                }
                                EmployeeDetails.listGroups(data);
                                EmployeeDetails.listCategory();
                            } else {
                                EmployeeDetails.displaywarning(result.msg);
                                $('#emp_category').val('');
                                $('#emp_name').val('');
                                $('#emp_email').val('');
                                $('#emp_contact').val('');
                                $('#emp_address').val('');
                                $('#emp_aadhaar_no').val('');
                                var data = {
                                    per_page: $('.btn-per-page').attr('selected-per-page'),
                                    page: 1
                                }
                                EmployeeDetails.listGroups(data);
                                EmployeeDetails.listCategory();
                            }

                        }
                    });
                }
            }
        } else {
            EmployeeDetails.displaywarning("Please enter Employee name");
        }

    },

    //Active - Inactive status code
    deleteGroup: function() {
        if ($(this).is(':checked'))
            $(this).val("on");
        else
            $(this).val("off");

        var self = this;
        var data_id = $(this).attr('data-id');
        var formData = {
            id: data_id,
            is_active: $(this).val()
        }
        $('#image-loader').show();
        $.ajax({
            url: EmployeeDetails.base_url + "Employee_master_controller/make_active_inactive",
            type: 'POST',
            data: formData,
            success: function(result) {
                // console.log(result);
                $('#image-loader').hide();
                if (result.status) {
                    var data = {
                        per_page: $('.btn-per-page').attr('selected-per-page'),
                        page: 1
                    }
                    EmployeeDetails.listGroups(data);
                } else {
                    EmployeeDetails.displaywarning("Something went wrong please try again");
                }
            }
        });
    },

    // Delete Employee
    onDeleteGroup: function() {
        var self = this;
        var data_id = $(this).attr('data-id');
        var title = 'Are you sure ?';
        var text = "Delete Employee";

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
        }, function() {
            var formData = {
                id: data_id
            }
            $('#image-loader').show();
            $.ajax({
                url: EmployeeDetails.base_url + "Employee_master_controller/delete_employee",
                type: 'POST',
                data: formData,
                success: function(result) {
                    $('#image-loader').hide();
                    if (result.status) {
                        var data = {
                            per_page: $('.btn-per-page').attr('selected-per-page'),
                            page: 1
                        }
                        EmployeeDetails.listGroups(data);
                        $('.edit_manager').hide();
                    } else {
                        EmployeeDetails.displaywarning("Something went wrong please try again");
                        $('.edit_manager').hide();
                    }
                }
            });
        }, function(dismiss) {
            if (dismiss === 'cancel') {
                swal(
                    'Cancelled',
                    'Your record is safe :)',
                    'error'
                )
            }
        });

    },

    // listing function --new changes
    listGroups: function(data, fromevent) {
        $('#image-loader').show();
        $.ajax({
            url: EmployeeDetails.base_url + "Employee_master_controller/list_Employee",
            type: 'POST',
            dataType: 'json',
            data: data,
            success: function(response) {

                $('#image-loader').hide();
                var groups = response.manager;
                // console.log("Response data is " + JSON.stringify(groups));
                var html = "";
                var j = 1;
                for (i in groups) {

                    var available_in = groups[i].available_in;
                    if (available_in == null)
                        available_in = '';
                    html += '<tr menu-id="' + groups[i].emp_id + '" curr-seq="' + groups[i].sequence + '">\
                          <td>' + groups[i].emp_name + '</td>\
                          <td>' + groups[i].category_name + '</td>\
                          <td>' + groups[i].kitchen_staff_name + '</td>\
                          <td>' + groups[i].kitchen_staff_incentives + '</td>\
                           <td>' + groups[i].emp_email + '</td>\
                           <td>' + groups[i].emp_contact + '</td>\
                           <td>' + groups[i].emp_address + '</td>\
                           <td>' + groups[i].emp_aadhaar_no + '</td>\
                            <td class="text-center">\
                                <label class="custom-switch pl-0">';
                    if (groups[i].is_active == 1)
                        html += '<input type="checkbox" name="custom-switch-checkbox" data-id="' + groups[i].emp_id + '" class="custom-switch-input input-switch-box" checked>';
                    else {
                        html += '<input type="checkbox" name="custom-switch-checkbox" data-id="' + groups[i].emp_id + '" class="custom-switch-input input-switch-box">';
                    }
                    html += '<span class="custom-switch-indicator"></span></label>\
                            </td>\
                            <td>\
                            <a class="a-edit-group" data-id="' + groups[i].emp_id + '" style="color:green;cursor: pointer;"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\
                            <a class="a-delete-group" data-id="' + groups[i].emp_id + '" style="color:#f19999;cursor: pointer;"><i class="fa fa-trash"></i></a>\
                            </td>\
                        </tr>';
                    j++;
                }
                $('.tbody-group-list').html(html);
                $('.span-all-groups').html(response.total_count);
                $('.span-page-html').html(response.page_total_text);
                if (parseInt(response.page_no) > 1) {
                    var prev_page = parseInt(response.page_no) - 1;
                    $('.btn-prev').attr('page-no', prev_page);
                    $('.btn-prev').removeAttr('disabled');
                } else {
                    $('.btn-prev').attr('disabled', true);
                    $('.btn-prev').prop('disabled', true);

                }

                if (parseInt(response.page_no) < parseInt(response.total_pages)) {
                    var next_page = parseInt(response.page_no) + 1;
                    $('.btn-next').attr('page-no', next_page);
                    $('.btn-next').removeAttr('disabled');
                } else {
                    $('.btn-next').attr('disabled', true);
                    $('.btn-next').prop('disabled', true);
                }
            }
        });
    },

    displaysucess: function(msg) {
        swal("Success !", msg, "success");
    },

    displaywarning: function(msg) {
        swal("Error !", msg, "error");
    },

    onlyNumberKey: function(evt) {
        // Only ASCII charactar in that range allowed 
        var ASCIICode = (evt.which) ? evt.which : evt.keyCode
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
            return false;
        return true;
    }

};