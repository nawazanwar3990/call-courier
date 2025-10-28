@props([
    'table',
    'responsive' => false,
    'print' => false,
])

<script>
    $(document).ready(function () {
        var generalTable = $('#{{ $table }}').DataTable({
            language: {
                search: i18n.general.search,
                lengthMenu: `${i18n.general.show} _MENU_ ${i18n.general.entries}`,
                emptyTable: i18n.general.empty_table,
                zeroRecords: i18n.general.zero_record,
                info: `${i18n.general.showing}  _START_  ${i18n.general.to}  _END_  ${i18n.general.total}  _TOTAL_  ${i18n.general.entries}`,
                infoEmpty: `${i18n.general.showing} 0 ${i18n.general.to} 0 ${i18n.general.total} 0 ${i18n.general.entries}`,
                infoFiltered: `(${i18n.general.searched_from} _MAX_ ${i18n.general.total_entries})`,
                paginate: {
                    first: i18n.general.first,
                    previous: i18n.general.previous,
                    next: i18n.general.next,
                    last: i18n.general.last
                },
            },
            responsive: '{{ $responsive ? 'true' : 'false' }}',
            "pageLength": -1,
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, '{{ __('general.all') }}']],
            "order": [], //Initial no order.
            "aaSorting": [],
            dom: '<"dt-action-buttons text-end pt-3 pt-md-0"B><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>tr<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            "buttons": [
                {
                    extend: "collection",
                    className: "btn btn-label-primary dropdown-toggle me-2",
                    text: '<i class="far fa-file-export me-sm-1"></i> <span class="d-none d-sm-inline-block">{{ __('general.export') }}</span>',
                    buttons: [{
                        extend: "print",
                        text: '<i class="far fa-print me-1" ></i><span class="dt-dropdown-text-dark">{{ __('general.print') }}</span>',
                        className: "dropdown-item",
                        footer: true,
                        exportOptions: {
                            columns: ':not(.no-export)'
                        }
                    },{
                        extend: "csv",
                        text: '<i class="far fa-file-csv me-1"></i><span class="dt-dropdown-text-dark">{{ __('general.csv') }}</span>',
                        className: "dropdown-item",
                        footer: true,
                        exportOptions: {
                            columns: ':not(.no-export)'
                        }
                    },{
                        extend: "excel",
                        text: '<i class="far fa-file-excel me-1"></i><span class="dt-dropdown-text-dark">{{ __('general.excel') }}</span>',
                        className: "dropdown-item",
                        footer: true,
                        exportOptions: {
                            columns: ':not(.no-export)'
                        }
                    },{
                        extend: "pdf",
                        text: '<i class="far fa-file-pdf me-1"></i><span class="dt-dropdown-text-dark">{{ __('general.pdf') }}</span>',
                        className: "dropdown-item",
                        footer: true,
                        exportOptions: {
                            columns: ':not(.no-export)'
                        }
                    },
                    ],
                },
                @if($print)
                {
                    text: '<i class="far fa-print"></i> <span class="d-none d-sm-inline-block">{{ __('general.print') }}</span>',
                    className: 'btn btn-primary',
                    action: function (dt, node, config){
                        printDiv();
                    }
                },
                @endif
            ],
            "fnDrawCallback": function(oSettings) {
                initTooltip();
            }
        });

    });
</script>
