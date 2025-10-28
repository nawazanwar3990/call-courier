<x-dashboard-layout :page-title="$pageTitle">
    <x-breadcrumb :page-title="$pageTitle" :bread-crumbs="$breadCrumbs" />

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive-sm">
                        <table class="table table-bordered table-hover w-100" id="table">
                            <thead>
                            <tr>
                                <th class="w-15">{{ __('general.type') }}</th>
                                <th>{{ __('general.message') }}</th>
                                <th>{{ __('general.created_at') }}</th>
                                <th class="text-center w-10">{!! __('general.actions') !!}</th>
                            </tr>
                            </thead>
                            <tbody class="notification-parent">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-slot name="pageJs">
        <script>
            var datatable;
            var filters = {};

            $(function() {
                datatable = $('#table').DataTable({
                    order: [[2, 'asc']],
                    "serverSide": true,
                    "processing": true,
                    "paging": true,
                    "responsive": true,
                    "columnDefs": [
                        {
                            "orderable": false,
                            "targets": [0, 1, 3]
                        },
                        {
                            "defaultContent": "",
                            "targets": "_all"
                        }],
                    "lengthMenu": [
                        [10, 25, 50, 100, -1],
                        [10, 25, 50, 100, "{{ __('general.all') }}"]
                    ],
                    "pageLength":100,
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
                    ],
                    'ajax': {
                        'url': "{{ route('admin.notifications') }}",
                        'data': function (data) {
                        }
                    },
                    columns: [
                        {data: 'type'},
                        {data: 'message'},
                        {data: 'created_at'},
                        {data: 'action', className: "text-center col-1 align-middle no-export"},
                    ],
                    "fnDrawCallback": function(oSettings) {
                        initTooltip();
                    }
                });
            });
        </script>
    </x-slot>
</x-dashboard-layout>
