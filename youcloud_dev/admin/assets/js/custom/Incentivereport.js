var Employeeincentive = {
    base_url: null,
    init: function() {
        this.bind_events();
        var data = {
                per_page: $('.btn-per-page').attr('selected-per-page'),
                page: 1
            }
            // this.listGroups(data);
        this.listCategory();
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
                master_category_id: $('#emp_category').val()
            }
            Employeeincentive.listGroups(data);
        });
        $('.btn-prev').on('click', function() {
            var data = {
                per_page: $('.dropdown-toggle').attr('selected-per-page'),
                page: $(this).attr('page-no'),
                master_category_id: $('#emp_category').val()
            }
            Employeeincentive.listGroups(data);
        });
        $('.btn-next').on('click', function() {
            var data = {
                per_page: $('.dropdown-toggle').attr('selected-per-page'),
                page: $(this).attr('page-no'),
                master_category_id: $('#emp_category').val()
            }
            Employeeincentive.listGroups(data);
        });
        $('#searchInput').on('keyup', function() {
            if ($(this).val() == "") {
                var data = {
                    per_page: $('.dropdown-toggle').attr('selected-per-page'),
                    page: 1,
                    master_category_id: $('#emp_category').val()
                }
                Employeeincentive.listGroups(data, 'fromsearch');
            } else {
                if ($(this).val().length >= 3) {
                    var data = {
                        per_page: 'all',
                        page: 1,
                        searchkey: $('#searchInput').val(),
                        master_category_id: $('#emp_category').val()
                    }
                    Employeeincentive.listGroups(data, 'fromsearch');
                }
            }
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
            Employeeincentive.onSaveSequence(data);
        });

        // After click on category dropdown
        $('#emp_category').on('change', function() {
            var master_category_id = $(this).val();
            var data = {
                per_page: $('.btn-per-page').attr('selected-per-page'),
                page: $('.btn-current-pageno').attr('curr-page'),
                master_category_id: master_category_id
            }
            Employeeincentive.listGroups(data);
        });

        // On table row click
        $(".tbody-group-list").on("click", "td", function() {
            var data_id = $(this).attr('data-id');
            $("#employe-table").hide();
        })

        // Date search 
        $('.searchdate').on('click', this.searchdate);

    },

    // list category in dropdown on page load 
    listCategory: function() {
        $.ajax({
            url: Employeeincentive.base_url + "Incentive_report_controller/show_category_details",
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

    // On date search
    searchdate: function() {
        var data = {
            per_page: $('.btn-per-page').attr('selected-per-page'),
            page: 1,
            from_date: $('#from_date').val(),
            to_date: $('#to_date').val(),
            master_category_id: $('#emp_category').val()
        }
        Employeeincentive.listGroups(data);
    },

    // Employee table listing
    listGroups: function(data, fromevent) {
        $('#image_loader').show();
        $.ajax({
            url: Employeeincentive.base_url + "Incentive_report_controller/get_employee",
            type: 'POST',
            dataType: 'json',
            data: data,
            success: function(response) {
                $('#image_loader').hide();
                var employees = response.employee;
                var html = "";
                var j = 1;
                for (i in employees) {

                    html += '<tr menu-id="' + employees[i].emp_id + '">\
                        <td>' + j + '</td>';
                    html += '<td data-id="' + employees[i].emp_id + '">' + employees[i].emp_name + '</td>'
                    html += '<td>' + 50 + '</td>'
                    '</tr>';
                    j = j + 1;
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
    }

};