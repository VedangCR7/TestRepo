var Common = {
    base_url: null,
    init: function() {
        this.datatable();
        this.bind_events();
    },
    bind_events:function(){
      
    },
    datatable: function() {
        $(".datatable-pagination").DataTable({
            language:{
                paginate:{
                    previous:"<i class='mdi mdi-chevron-left'>",
                    next:"<i class='mdi mdi-chevron-right'>"
                }
            },
            drawCallback:function(){
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
            },
            
        });
    },
    datatablewithButtons: function(title,filename,hide_columns) {
        var a=$(".datatable-withbuttons").DataTable({
            /* lengthChange:!1, */
            dom: '<"row"<"col-sm-6"B><"col-sm-6 float-right"f>>rt<"row"<"col-sm-4"l><"col-sm-3"i><"col-sm-5"p>>',
            buttons: [
               {
                    extend: 'pdfHtml5',
                    download: 'download',
                    orientation: 'portrait',
                    pageSize: 'A4',
                    title:title,
                    className:'btn btn-outline-success  mr-1',
                    text:'<i class="fas fa-file-pdf"></i> pdf',
                    filename: filename,
                }, 
                /*{
                    extend: 'csvHtml5',
                    autoFilter: true,
                    title: title,
                    text:'<i class="fas fa-file-excel"></i> csv',
                    className:'btn btn-outline-success  mr-1',
                     sheetName: title
                },*/
                {
                    extend: 'print',
                    title: title,
                    text:'<i class="fas fa-print"></i> print',
                    className:'btn btn-outline-success mr-1',
                },
                {
                    extend: 'excelHtml5',
                    autoFilter: true,
                    title: title,
                    className:'btn btn-outline-success  mr-1',
                    text:'<i class="fas fa-file-excel"></i> excel',
                    sheetName: title
                }
            ],
            language:{
                paginate:{
                    previous:"<i class='mdi mdi-chevron-left'>",
                    next:"<i class='mdi mdi-chevron-right'>"
                }
            },
            drawCallback:function(){
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
            },
            
        });
        a.buttons().container().appendTo($('.col-md-6:eq(0)', a.table().container() ));
        $(".dataTables_wrapper button").removeClass("btn-secondary")
        if(hide_columns)
            a.columns(hide_columns).visible( false );
        
    }
 };