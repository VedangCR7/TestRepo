var CategoryDetails = {
    base_url: null,
    init: function() {
        this.bind_events();
        var data = {
            per_page: $('.btn-per-page').attr('selected-per-page'),
            page: 1
        }
        this.listGroups(data);
        //  this.listMainGroup();
        this.listMainCategory();
    },

    // Bind data to popup model
    bind_events: function() {
        var self = this;
        $('.tbody-group-list').on('click', '.a-edit-group', function() {
            // $("#Categoryname").attr("readonly","readonly");
            var category_id = $(this).attr("data-id");
            var category_name = $(this).attr("category-name");
            var maincategory_id = $(this).attr("maincategory-name");
            $('#Categoryname').val(category_name);
            $('#main_category').val(maincategory_id);
            $('.btn-add-category').hide();
            $('.updclass').html('<button class="btn btn-secondary btn-edit-category" data-id="' + category_id + '" type="button" style="border-radius: 4px;border: 0px !important;">UPDATE</button>')

        });
        // Update category
        $('.updclass').on('click', '.btn-edit-category', function() {

            var category_id = $(this).attr("data-id");
            var category_name = $('#Categoryname').val();
            var main_category = $('#main_category').val();

            if (category_name == "" || category_name == undefined || category_name == null) {
                CategoryDetails.displaywarning("please enter category");
                return false;
            }
            if (main_category == "" || main_category == undefined || main_category == null) {
                CategoryDetails.displaywarning("please select main-category");
                return false;
            }

            $.ajax({
                url: CategoryDetails.base_url + "Emp_category_master/editCategory",
                type: 'POST',
                dataType: 'json',
                data: {
                    category_id: category_id,
                    category_name: category_name,
                    main_category: main_category
                },
                success: function(result) {
                    //  console.log(result);
                    if (result.status) {
                        CategoryDetails.displaysucess(result.msg);
                        $('#Categoryname').val('');
                        $('#main_category').val('9');
                        var data = {
                            per_page: $('.btn-per-page').attr('selected-per-page'),
                            page: 1
                        }
                        CategoryDetails.listGroups(data);
                        CategoryDetails.listMainCategory();

                    } else {
                        CategoryDetails.displaywarning(result.msg);
                        $('#Categoryname').val('');
                        $('#main_category').val('9');
                        var data = {
                            per_page: $('.btn-per-page').attr('selected-per-page'),
                            page: 1
                        }
                        CategoryDetails.listGroups(data);
                        CategoryDetails.listMainCategory();

                    }

                }
            });
        })

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
            CategoryDetails.listGroups(data);
        });
        $('.btn-prev').on('click', function() {
            var data = {
                per_page: $('.dropdown-toggle').attr('selected-per-page'),
                page: $(this).attr('page-no')
            }
            CategoryDetails.listGroups(data);
        });
        $('.btn-next').on('click', function() {
            var data = {
                per_page: $('.dropdown-toggle').attr('selected-per-page'),
                page: $(this).attr('page-no')
            }
            CategoryDetails.listGroups(data);
        });
        $('#searchInput').on('keyup', function() {

            if ($(this).val() == "") {
                var data = {
                    per_page: $('.dropdown-toggle').attr('selected-per-page'),
                    page: 1
                }
                CategoryDetails.listGroups(data, 'fromsearch');
            } else {
                if ($(this).val().length >= 3) {
                    var data = {
                        per_page: 'all',
                        page: 1,
                        searchkey: $('#searchInput').val()
                    }
                    CategoryDetails.listGroups(data, 'fromsearch');
                }
            }
        });
        $('.tbody-group-list').on('click', '.input-switch-box', this.deleteGroup);
        $('.tbody-group-list').on('click', '.a-delete-group', this.onDeleteGroup);
        $('.btn-add-category').on('click', this.onSaveCategory);
        $('#AddMenuGroup').on('keypress', function(e) {
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
            CategoryDetails.onSaveSequence(data);
        });
    },

    // Category Dropdown list 
    listMainCategory: function() {
        $.ajax({
            url: CategoryDetails.base_url + "Emp_category_master/show_category_list",
            success: function(result) {
                // console.log("Dropdown list " + JSON.stringify(result));
                var html = '';
                html += '<option value="0" selected disabled>Select *</option>';
                for (i = 0; i < result.length; i++) {
                    html += '<option value="' + result[i].cat_id + '">' + result[i].user_category_name + '</option>';
                }
                $('#main_category').html(html);
            }
        });
    },

    //Save category details 
    onSaveCategory: function() {
        if ($('#Categoryname').val() != "") {
            if ($('.catname').val() == "" || $('.catname').val() == undefined || $('.catname').val() == null) {
                CategoryDetails.displaywarning("please enter subcategory");
                return false;
            }
            if ($('#main_category').val() == "") {
                CategoryDetails.displaywarning("please select main category");
                return false;
            }
            $.ajax({
                url: CategoryDetails.base_url + "Emp_category_master/addCategory",
                type: 'POST',
                dataType: 'json',
                data: {
                    MainCategoryid: $('#main_category').val(),
                    Categoryname: $('#Categoryname').val()
                },
                success: function(result) {
                    // console.log(result);
                    if (result.status) {
                        CategoryDetails.displaysucess(result.msg);
                        $('#Categoryname').val('');
                        var data = {
                            per_page: $('.btn-per-page').attr('selected-per-page'),
                            page: 1
                        }
                        CategoryDetails.listGroups(data);
                    } else {
                        CategoryDetails.displaywarning(result.msg);
                        $('#Categoryname').val('');
                        var data = {
                            per_page: $('.btn-per-page').attr('selected-per-page'),
                            page: 1
                        }
                        CategoryDetails.listGroups(data);
                    }

                }
            });
        } else {
            CategoryDetails.displaywarning("Please enter category name");
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
            url: CategoryDetails.base_url + "Emp_category_master/make_active_inactive",
            type: 'POST',
            data: formData,
            success: function(result) {
                $('#image-loader').hide();
                if (result.status) {
                    var data = {
                        per_page: $('.btn-per-page').attr('selected-per-page'),
                        page: 1
                    }
                    CategoryDetails.listGroups(data);
                } else {
                    CategoryDetails.displaywarning("Something went wrong please try again");
                }
            }
        });
    },

    // Delete category
    onDeleteGroup: function() {
        var self = this;
        var data_id = $(this).attr('data-id');
        var title = 'Are you sure ?';
        var text = "Delete Group";

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
                url: CategoryDetails.base_url + "Emp_category_master/delete_category",
                type: 'POST',
                data: formData,
                success: function(result) {
                    $('#image-loader').hide();
                    if (result.status) {
                        var data = {
                            per_page: $('.btn-per-page').attr('selected-per-page'),
                            page: 1
                        }
                        CategoryDetails.listGroups(data);

                    } else {
                        CategoryDetails.displaywarning("Something went wrong please try again");
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

    // listing function
    listGroups: function(data, fromevent) {
        $('#image-loader').show();
        $.ajax({
            url: CategoryDetails.base_url + "Emp_category_master/list_Category",
            type: 'POST',
            dataType: 'json',
            data: data,
            success: function(response) {
                // console.log("Response is " + JSON.stringify(response.manager));
                $('#image-loader').hide();
                var groups = response.manager;
                // console.log("table records ", groups);
                var html = "";
                var j = 1;

                for (i in groups) {

                    var available_in = groups[i].available_in;
                    if (available_in == null)
                        available_in = '';
                    html += '<tr menu-id="' + groups[i].id + '" curr-seq="' + groups[i].sequence + '">\
                    <td>' + groups[i].user_category_name + '</td>\
                    <td>' + groups[i].category_name + '</td>\
                    <td>' + groups[i].upd_date + '</td>\
                            <td>\
                                <label class="custom-switch pl-0">';
                    if (groups[i].is_active == 1)
                        html += '<input type="checkbox" name="custom-switch-checkbox" data-id="' + groups[i].id + '" class="custom-switch-input input-switch-box" checked>';
                    else {
                        html += '<input type="checkbox" name="custom-switch-checkbox" data-id="' + groups[i].id + '" class="custom-switch-input input-switch-box">';
                    }
                    html += '<span class="custom-switch-indicator"></span></label>\
                            </td>\
                            <td>\
                             <a class="a-edit-group" category-name="' + groups[i].category_name + '" maincategory-name="' + groups[i].maincategory_id + '" data-id="' + groups[i].id + '" style="color:#089e60;margin-right:10px;cursor: pointer;"><i class="fa fa-edit"></i></a>\
                            <a class="a-delete-group" data-id="' + groups[i].id + '" style="color:#f19999;cursor: pointer;"><i class="fa fa-trash"></i></a>\
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

};