var IncentiveList = {
    base_url: null,
    init: function() {
        this.bind_events();
        var data = {
                per_page: $('.btn-per-page').attr('selected-per-page'),
                page: 1
            }
            //    Category list
        this.listCategory();
        $('.updclass').hide();
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
                page: 1,
                category_id: $('#master_menu').val()
            }
            IncentiveList.listRecipes(data);
        });

        $('.btn-prev').on('click', function() {
            var data = {
                per_page: $('.dropdown-toggle').attr('selected-per-page'),
                page: $(this).attr('page-no'),
                category_id: $('#master_menu').val()
            }
            IncentiveList.listRecipes(data);
        });

        $('.btn-next').on('click', function() {
            var data = {
                per_page: $('.dropdown-toggle').attr('selected-per-page'),
                page: $(this).attr('page-no'),
                category_id: $('#master_menu').val()
            }
            IncentiveList.listRecipes(data);
        });

        // Search record for captain & waiters
        $('#searchRecipeInput').on('keyup', function() {
            // debugger
            if ($(this).val() == "") {
                var data = {
                    per_page: $('.dropdown-toggle').attr('selected-per-page'),
                    page: 1,
                    category_id: $('#master_menu').val()
                }
                IncentiveList.listRecipes(data, 'fromsearch');
            } else {
                // alert($(this).val());
                if ($(this).val().length >= 3) {
                    var data = {
                        per_page: 'all',
                        page: 1,
                        searchkey: $('#searchRecipeInput').val(),
                        category_id: $('#master_menu').val()
                    }
                    IncentiveList.listRecipes(data, 'fromsearch');
                }
            }
        });

        // After click on category dropdown
        $('#master_menu').on('change', function() {
            $('.updclass').show();
            var data = {
                per_page: $('.dropdown-toggle').attr('selected-per-page'),
                page: $('.btn-current-pageno').attr('curr-page'),
                category_id: $(this).val()
            }
            var cat_id = $(this).val();
            //    if 2 - Captain and 8 - waiter and 1 - kitchen Staff
            IncentiveList.listRecipes(data);
        });

        // On cllick of Save button Captain
        $('.btn-save-details').on('click', this.onSaveIncentive);

        // On cllick of Save button waiter
        $('.btn-waiter-save-details').on('click', this.onSaveWaiter);

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
            IncentiveList.onSaveSequence(data);
        });

        // Bind data to update waiter module
        $('.tbody-waiters-list').on('click', '.a-edit-group', function() {
            $("#from_range").attr("readonly", "readonly");
            $("#to_range").attr("readonly", "readonly");
            var incentive_id = $(this).attr("data-id");
            var from_range = $(this).attr("from-range");
            var to_range = $(this).attr("to-range");
            var incentive_price = $(this).attr("incentive-price");

            $('#from_range').val(from_range);
            $('#to_range').val(to_range);
            $('#waiter_incentives').val(incentive_price);
            $('.btn-save-details').hide();
            $('.updclass').html('<button class="btn btn-secondary btn-edit-incentive" data-id="' + incentive_id + '" type="button" style="border-radius: 4px;border: 0px !important;">UPDATE</button>');

        });

        // Bind data to update Kitchen Staff module
        $('.tbody-kitchen-staff-list').on('click', '.a-edit-kitchenStaff', function() {
            $("#staff_mode").attr("readonly", "readonly");
            var incentive_id = $(this).attr("data-id");
            var kitchen_staff_name = $(this).attr("kitchen-staff-name");
            var kitchen_percentage = $(this).attr("kitchen-percentage");

            $('#staff_mode').val(kitchen_staff_name);
            $('#staff_percentage').val(kitchen_percentage);
            $('.btn-save-details').hide();
            $('.updclass').html('<button class="btn btn-secondary btn-edit-kitchen-staff-incentive" data-id="' + incentive_id + '" type="button" style="border-radius: 4px;border: 0px !important;">UPDATE</button>');

        });

        // Update waiter category
        $('.updclass').on('click', '.btn-edit-incentive', function() {
            // alert();
            var incentive_id = $(this).attr("data-id");
            var from_range = $('#from_range').val();
            var to_range = $('#to_range').val();
            var incentive_price = $('#waiter_incentives').val();

            if (from_range == "" || from_range == undefined || from_range == null) {
                IncentiveList.displaywarning("Please enter From range");
                return false;
            }
            if (to_range == "" || to_range == undefined || to_range == null) {
                IncentiveList.displaywarning("Please select To range");
                return false;
            }
            if (incentive_price == "" || incentive_price == undefined || incentive_price == null) {
                IncentiveList.displaywarning("Please enter Incentive");
                return false;
            }
            // alert(incentive_price);
            $.ajax({
                url: IncentiveList.base_url + "Manage_Incentive_master_controller/editIncentives",
                type: 'POST',
                dataType: 'json',
                data: {
                    incentive_id: incentive_id,
                    from_range: from_range,
                    to_range: to_range,
                    incentive_price: incentive_price
                },
                success: function(result) {
                    //  console.log(result);
                    if (result.status) {
                        IncentiveList.displaysucess(result.msg);
                        $('#from_range').val('');
                        $('#to_range').val('');
                        $('#waiter_incentives').val('');
                        $('.updclass').html('<a href="javascript:;" class="btn btn-secondary pl-1 pr-1 text-center new-recipe-a btn-save-details" style="width: 100%;" id="add_incentive">Save</a>');
                        $('.btn-edit-incentive').hide();
                        $('#add_incentive').show();
                        $("#from_range").attr("readonly", false);
                        $("#to_range").attr("readonly", false);

                        var data = {
                            per_page: $('.btn-per-page').attr('selected-per-page'),
                            page: 1,
                            category_id: $('#master_menu').val()
                        }

                        IncentiveList.listRecipes(data);
                        IncentiveList.listCategory();

                    } else {
                        IncentiveList.displaywarning(result.msg);
                        $('#from_range').val('');
                        $('#to_range').val('');
                        $('#waiter_incentives').val('');
                        $('.updclass').html('<a href="javascript:;" class="btn btn-secondary pl-1 pr-1 text-center new-recipe-a btn-save-details" style="width: 100%;" id="add_incentive">Save</a>');
                        $('.btn-edit-incentive').hide();
                        $('#add_incentive').show();
                        $("#from_range").attr("readonly", false);
                        $("#to_range").attr("readonly", false);
                        var data = {
                            per_page: $('.btn-per-page').attr('selected-per-page'),
                            page: 1,
                            category_id: $('#master_menu').val()
                        }

                        IncentiveList.listRecipes(data);
                        IncentiveList.listCategory();
                    }

                }
            });
        });

        // Update Kitchen Staff category
        $('.updclass').on('click', '.btn-edit-kitchen-staff-incentive', function() {
            // alert();
            var incentive_id = $(this).attr("data-id");
            var staff_mode = $('#staff_mode').val();
            var staff_percentage = $('#staff_percentage').val();

            if (staff_mode == "" || staff_mode == undefined || staff_mode == null) {
                IncentiveList.displaywarning("Please enter Kitchen staff category");
                return false;
            }
            if (staff_percentage == "" || staff_percentage == undefined || staff_percentage == null) {
                IncentiveList.displaywarning("Please enter Kitchen staff percentage");
                return false;
            }

            // alert(incentive_price);
            $.ajax({
                url: IncentiveList.base_url + "Manage_Incentive_master_controller/editKitchenStafIncentives",
                type: 'POST',
                dataType: 'json',
                data: {
                    incentive_id: incentive_id,
                    staff_mode: staff_mode,
                    staff_percentage: staff_percentage
                },
                success: function(result) {
                    //  console.log(result);
                    if (result.status) {
                        IncentiveList.displaysucess(result.msg);
                        $('#staff_mode').val('');
                        $('#staff_percentage').val('');
                        $('.updclass').html('<a href="javascript:;" class="btn btn-secondary pl-1 pr-1 text-center new-recipe-a btn-save-details" style="width: 100%;" id="add_incentive">Save</a>');
                        $('.a-edit-kitchenStaff').hide();
                        $('#add_incentive').show();
                        $("#staff_mode").attr("readonly", false);
                        var data = {
                            per_page: $('.btn-per-page').attr('selected-per-page'),
                            page: 1,
                            category_id: $('#master_menu').val()
                        }

                        IncentiveList.listRecipes(data);
                        // IncentiveList.listCategory();

                    } else {
                        IncentiveList.displaywarning(result.msg);
                        $('#from_range').val('');
                        $('#staff_percentage').val('');
                        $('.updclass').html('<a href="javascript:;" class="btn btn-secondary pl-1 pr-1 text-center new-recipe-a btn-save-details" style="width: 100%;" id="add_incentive">Save</a>');
                        $('.a-edit-kitchenStaff').hide();
                        $('#add_incentive').show();
                        $("#from_range").attr("readonly", false);
                        var data = {
                            per_page: $('.btn-per-page').attr('selected-per-page'),
                            page: 1,
                            category_id: $('#master_menu').val()
                        }
                        IncentiveList.listRecipes(data);
                        // IncentiveList.listCategory();
                    }
                }
            });
        });

        $('.tbody-kitchen-staff-list').on('click', '.a-delete-kitchen-staff', this.onDeleteKitchenIncentives);
        $('.tbody-waiters-list').on('click', '.a-delete-waiter', this.onDeleteIncentives);
    },

    // Display category in dropdown
    listCategory: function() {
        $.ajax({
            url: IncentiveList.base_url + "Manage_Incentive_master_controller/show_category_list",
            success: function(result) {
                // console.log(result);
                var html = '';
                html += '<option value="0" selected disabled>Select</option>';
                for (i = 0; i < result.length; i++) {
                    html += '<option value="' + result[i].id + '">' + result[i].category_name + '</option>';
                }
                $('#master_menu').html(html);
            }
        });
    },

    // Captain, Waiter, Kitchen Cheff Table design
    listRecipes: function(data, fromevent) {
        $('#image-loader').show();
        $.ajax({
            url: IncentiveList.base_url + "Manage_Incentive_master_controller/list_menu/",
            type: 'POST',
            dataType: 'json',
            data: data,
            success: function(response) {
                // console.log("Captain response " + JSON.stringify(response.manager));
                // console.log("waiter response " + JSON.stringify(response.waiter));
                // console.log("Kitchen Staff response " + JSON.stringify(response.kitchen_staff));
                $('#image-loader').hide();
                var recipe = response.manager;
                var waiter = response.waiter;
                var kitchen_staff = response.kitchen_staff;
                var master_category_name = response.master_category_name;
                var html = "";

                if (master_category_name == 'Captain') {
                    $("#waiter").hide();
                    $("#kitchenStaff").hide();
                    $("#captain").show();
                    $(".wtr_incentive").hide();
                    $(".kitchenStaff_incentive").hide();

                    for (i in recipe) {
                        if (recipe[i].title == null) {
                            var title = "-";
                        } else {
                            var title = recipe[i].title;
                        }
                        html += '<tr>';
                        html += '<td>' + recipe[i].name + '</td>';
                        html += '<td>' + title + '</td>';
                        html += '<td>' + recipe[i].price + '</td>';
                        html += '<td>';
                        if (recipe[i].incentives_price != null) {
                            html += '<input type="text" name="incentive_price[]" value="' + recipe[i].incentives_price + '" class="mt-2 mb-2 form-control input-recipe-price classIncentive" id="incentive_price" onkeypress="return onlyNumberKey(event)">'
                        } else {
                            html += '<input type="text" name="incentive_price[]" value="0.00" class="mt-2 mb-2 form-control input-recipe-price classIncentive" id="incentive_price" onkeypress="return onlyNumberKey(event)">'
                        }
                        html += '<input type="hidden" name="menu_id[]" value="' + recipe[i].id + '">\
                            <input type="hidden" class="incentiveid" name="incentive_id[]" value="' + recipe[i].incentive_id + '">\
                            </td>';

                        html += '</tr>';
                    }
                    $('.tbody-recipes-list').html(html);
                } else if (master_category_name == 'Waiters') {
                    $("#captain").hide();
                    $("#kitchenStaff").hide();
                    $("#waiter").show();
                    $(".wtr_incentive").show();
                    $(".kitchenStaff_incentive").hide();

                    for (i in waiter) {
                        html += '<tr>';
                        html += '<td>' + waiter[i].from_range_value + '</td>';
                        html += '<td>' + waiter[i].to_range_value + '</td>';
                        html += '<td>' + waiter[i].incentives_price + '</td>';
                        html += '<td><a class="a-edit-group" from-range="' + waiter[i].from_range_value + '" to-range="' + waiter[i].to_range_value + '" incentive-price ="' + waiter[i].incentives_price + '" data-id="' + waiter[i].incentive_id + '" style="color:#089e60;margin-right:10px;cursor: pointer;"><i class="fa fa-edit"></i></a>\
                        <a class="a-delete-waiter" data-id="' + waiter[i].incentive_id + '" style="color:#f19999;cursor: pointer;"><i class="fa fa-trash"></i></a>\</td>'
                        html += '</tr>';
                    }
                    $('.tbody-waiters-list').html(html);
                } else if (master_category_name == 'Kitchen Staff') {
                    $("#captain").hide();
                    $("#waiter").hide();
                    $("#kitchenStaff").show();
                    $(".wtr_incentive").hide();
                    $(".kitchenStaff_incentive").show();

                    for (i in kitchen_staff) {
                        html += '<tr>';
                        html += '<td>' + kitchen_staff[i].kitchen_staff_name + '</td>';
                        html += '<td>' + kitchen_staff[i].kitchen_staff_incentives + '</td>';
                        html += '<td><a class="a-edit-kitchenStaff" kitchen-staff-name="' + kitchen_staff[i].kitchen_staff_name + '" kitchen-percentage="' + kitchen_staff[i].kitchen_staff_incentives + '" data-id="' + kitchen_staff[i].kitchen_staff_id + '" style="color:#089e60;margin-right:10px;cursor: pointer;"><i class="fa fa-edit"></i></a>\
                        <a class="a-delete-kitchen-staff" data-id="' + kitchen_staff[i].kitchen_staff_id + '" style="color:#f19999;cursor: pointer;"><i class="fa fa-trash"></i></a>\</td>'
                        html += '</tr>';
                    }
                    $('.tbody-kitchen-staff-list').html(html);
                }

                $('.span-all-recipes').html(response.total_count);
                $('.span-page-html').html(response.page_total_text);
                // console.log(response.page_no);
                $('.btn-current-pageno').attr('curr-page', response.page_no);

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

    // Save and Update captain and Add waiter, Kitchen staff Incentives
    onSaveIncentive: function() {
        // Category ID       
        var master_category_id = $('#master_menu').val();
        $.ajax({
            url: IncentiveList.base_url + "Manage_Incentive_master_controller/get_category_id",
            type: 'POST',
            dataType: 'json',
            data: {
                master_category_id: master_category_id
            },
            success: function(result) {
                var cat_id = result;

                if (cat_id == '2') {
                    IncentiveList.saveCaptainMasater();

                } else if (cat_id == '8') {
                    // Waiter
                    var from_range = $('#from_range').val();
                    var to_range = $('#to_range').val();
                    var waiter_incentives = $('#waiter_incentives').val();

                    if (from_range == "" || from_range == undefined || from_range == null) {
                        IncentiveList.displaywarning("Please enter From range");
                        return false;
                    } else
                    if (to_range == "" || to_range == undefined || to_range == null) {
                        IncentiveList.displaywarning("Please select To range");
                        return false;
                    } else
                    if (waiter_incentives == "" || waiter_incentives == undefined || waiter_incentives == null) {
                        IncentiveList.displaywarning("Please enter Incentive");
                        return false;
                    } else {
                        IncentiveList.saveWaiterMasater();
                    }


                } else if (cat_id == '6') {
                    // Kitchen Staff
                    var staff_mode = $('#staff_mode').val();
                    var staff_percentage = $('#staff_percentage').val();

                    if (staff_mode == "" || staff_mode == undefined || staff_mode == null) {
                        IncentiveList.displaywarning("Please enter Kitchen staff category");
                        return false;
                    } else
                    if (staff_percentage == "" || staff_percentage == undefined || staff_percentage == null) {
                        IncentiveList.displaywarning("Please enter Kitchen staff percentage");
                        return false;
                    } else {
                        IncentiveList.saveKitchenMasater();
                    }

                }

            }
        });
    },

    // Save captain details
    saveCaptainMasater: function() {
        var incentive_array_value = $("input[name='incentive_price[]']")
            .map(function() { return $(this).val(); }).get();

        var menu_id_array_value = $("input[name='menu_id[]']")
            .map(function() { return $(this).val(); }).get();

        var incentive_id = $("input[name='incentive_id[]']")
            .map(function() { return $(this).val(); }).get();

        var master_category_id = $('#master_menu').val();

        $.ajax({
            url: IncentiveList.base_url + "Manage_Incentive_master_controller/addIncentive",
            type: 'POST',
            dataType: 'json',
            data: {
                incentive_array_value: incentive_array_value,
                menu_id_array_value: menu_id_array_value,
                master_category_id: master_category_id,
                incentive_id: incentive_id
            },
            success: function(result) {
                if (result.status) {
                    IncentiveList.displaysucess(result.msg);
                    var data = {
                            per_page: $('.btn-per-page').attr('selected-per-page'),
                            page: 1,
                            category_id: $('#master_menu').val()
                        }
                        // IncentiveList.listCategory();
                    IncentiveList.listRecipes(data);

                } else {
                    IncentiveList.displaywarning(result.msg);
                    var data = {
                        per_page: $('.btn-per-page').attr('selected-per-page'),
                        page: 1,
                        category_id: $('#master_menu').val()
                    }
                    IncentiveList.listRecipes(data);
                    // IncentiveList.listCategory();
                }
            }
        });
    },

    // Save Kitchen Staff details
    saveKitchenMasater: function() {
        var staff_mode = $('#staff_mode').val();
        var staff_percentage = $('#staff_percentage').val();
        var master_category_id = $('#master_menu').val();
        $.ajax({
            url: IncentiveList.base_url + "Manage_Incentive_master_controller/addIncentive",
            type: 'POST',
            dataType: 'json',
            data: {
                master_category_id: master_category_id,
                kitchen_staff_name: staff_mode,
                staff_percentage: staff_percentage
            },
            success: function(result) {
                if (result.status) {
                    IncentiveList.displaysucess(result.msg);
                    $('#staff_mode').val('');
                    $('#staff_percentage').val('');

                    var data = {
                            per_page: $('.btn-per-page').attr('selected-per-page'),
                            page: 1,
                            category_id: $('#master_menu').val()
                        }
                        // IncentiveList.listCategory();
                    IncentiveList.listRecipes(data);

                } else {
                    IncentiveList.displaywarning(result.msg);
                    $('#staff_mode').val('');
                    $('#staff_percentage').val('');
                    var data = {
                        per_page: $('.btn-per-page').attr('selected-per-page'),
                        page: 1,
                        category_id: $('#master_menu').val()
                    }
                    IncentiveList.listRecipes(data);
                    // IncentiveList.listCategory();
                }
            }
        });
    },

    // Save waiters details
    saveWaiterMasater: function() {
        var from_range = $('#from_range').val();
        var to_range = $('#to_range').val();
        var waiter_incentives = $('#waiter_incentives').val();
        var master_category_id = $('#master_menu').val();

        $.ajax({
            url: IncentiveList.base_url + "Manage_Incentive_master_controller/addIncentive",
            type: 'POST',
            dataType: 'json',
            data: {
                from_range: from_range,
                to_range: to_range,
                waiter_incentives: waiter_incentives,
                master_category_id: master_category_id,
            },
            success: function(result) {
                // console.log(result);
                // debugger
                if (result.status) {
                    IncentiveList.displaysucess(result.msg);
                    $('#from_range').val('');
                    $('#to_range').val('');
                    $('#waiter_incentives').val('');
                    var data = {
                            per_page: $('.btn-per-page').attr('selected-per-page'),
                            page: 1,
                            category_id: $('#master_menu').val()
                        }
                        // IncentiveList.listCategory();
                    IncentiveList.listRecipes(data);

                } else {
                    IncentiveList.displaywarning(result.msg);
                    $('#from_range').val('');
                    $('#to_range').val('');
                    $('#waiter_incentives').val('');
                    var data = {
                        per_page: $('.btn-per-page').attr('selected-per-page'),
                        page: 1,
                        category_id: $('#master_menu').val()
                    }
                    IncentiveList.listRecipes(data);
                    // IncentiveList.listCategory();
                }
            }
        });
    },

    // Delete Incentives
    onDeleteIncentives: function() {
        var self = this;
        var data_id = $(this).attr('data-id');
        var title = 'Are you sure ?';
        var text = "Delete Incentives";

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
                url: IncentiveList.base_url + "Manage_Incentive_master_controller/delete_incentives",
                type: 'POST',
                data: formData,
                success: function(result) {
                    $('#image-loader').hide();
                    if (result.status) {
                        var data = {
                            per_page: $('.btn-per-page').attr('selected-per-page'),
                            page: 1,
                            category_id: $('#master_menu').val()
                        }
                        IncentiveList.listRecipes(data);
                        $('.edit_manager').hide();
                    } else {
                        IncentiveList.displaywarning("Something went wrong please try again");
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

    // Delete Incentives--new change
    onDeleteKitchenIncentives: function() {
        var self = this;
        var data_id = $(this).attr('data-id');
        var title = 'Are you sure ?';
        var text = "Delete Incentives";

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
                url: IncentiveList.base_url + "Manage_Incentive_master_controller/delete_kitchen_staff_incentives",
                type: 'POST',
                data: formData,
                success: function(result) {
                    $('#image-loader').hide();
                    if (result.status) {
                        var data = {
                            per_page: $('.btn-per-page').attr('selected-per-page'),
                            page: 1,
                            category_id: $('#master_menu').val()
                        }
                        IncentiveList.listRecipes(data);
                        $('.edit_manager').hide();
                    } else {
                        IncentiveList.displaywarning("Something went wrong please try again");
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

    // cancel edit box
    oncancelEditManager: function() {
        $('.edit_manager').hide();
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