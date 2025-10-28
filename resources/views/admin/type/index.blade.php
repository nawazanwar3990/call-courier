<x-dashboard-layout :page-title="$pageTitle">
    <x-breadcrumb :page-title="$pageTitle" :bread-crumbs="$breadCrumbs"/>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table class="table table-bordered table-hover w-100" id="table">
                            <thead>
                            <tr>
                                <th>{{ __('general.name') }}</th>
                                <th>{{ __('general.status') }}</th>
                                <th>{{ __('general.created_at') }}</th>
                                <th>{{ __('general.last_modified') }}</th>
                                <th class="text-center">{!! __('general.actions') !!}</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-popup-modal/>
    <x-delete-form/>

    <x-slot name="pageJs">
        <script>
            var datatable;
            $(function () {
                datatable = $('#table').DataTable({
                    language: {
                        search: "{{ __('general.search') }}",
                        lengthMenu: "{{ __('general.show') }} _MENU_ {{ __('general.entries') }}",
                        emptyTable: "{{ __('general.empty_table') }}",
                        zeroRecords: "{{ __('general.zero_record') }}",
                        info: "{{ __('general.showing') }} _START_ {{ __('general.to') }} _END_ {{ __('general.total') }} _TOTAL_ {{ __('general.entries') }}",
                        infoEmpty: "{{ __('general.showing') }} 0 {{ __('general.to') }} 0 {{ __('general.total') }} 0 {{ __('general.entries') }}",
                        infoFiltered: "({{ __('general.searched_from') }} _MAX_ {{ __('general.total_entries') }})",
                        paginate: {
                            first: "{{ __('general.first') }}",
                            previous: "{{ __('general.previous') }}",
                            next: "{{ __('general.next') }}",
                            last: "{{ __('general.last') }}"
                        },
                    },
                    order: [[2, 'desc']],
                    "serverSide": true,
                    "processing": true,
                    "paging": true,
                    "responsive": true,
                    "columnDefs": [
                        {
                            "orderable": false,
                            "targets": [1, 2]
                        },
                        {
                            "defaultContent": "",
                            "targets": "_all"
                        }],
                    "lengthMenu": [
                        [10, 25, 50, 100, -1],
                        [10, 25, 50, 100, "{{ __('general.all') }}"]
                    ],
                    "pageLength": 100,
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
                            }, {
                                extend: "csv",
                                text: '<i class="far fa-file-csv me-1"></i><span class="dt-dropdown-text-dark">{{ __('general.csv') }}</span>',
                                className: "dropdown-item",
                                footer: true,
                                exportOptions: {
                                    columns: ':not(.no-export)'
                                }
                            }, {
                                extend: "excel",
                                text: '<i class="far fa-file-excel me-1"></i><span class="dt-dropdown-text-dark">{{ __('general.excel') }}</span>',
                                className: "dropdown-item",
                                footer: true,
                                exportOptions: {
                                    columns: ':not(.no-export)'
                                }
                            }, {
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
                            @can('hasAccess', (\App\Enums\AbilityEnum::CREATE . '_' . \App\Enums\KeywordEnum::TYPE))
                        {
                            text: '<i class="far fa-plus-circle"></i> <span class="d-none d-sm-inline-block">{{ __('general.create') }}</span>',
                            className: 'btn btn-primary modal-add-btn',
                            attr: {
                                'data-href': '{{ route('admin.types.create') }}',
                            }
                        },
                        @endcan
                    ],
                    'ajax': {
                        'url': "{{ route('admin.types.index') }}",
                        'data': function (data) {
                        }
                    },
                    columns: [
                        {data: 'name'},
                        {data: 'status', className: "text-center"},
                        {data: 'created_at'},
                        {data: 'last_modified'},
                        {data: 'action', className: "text-center col-1 align-middle no-export"},
                    ],
                    "fnDrawCallback": function (oSettings) {
                        initTooltip();
                    }
                });
            });
        </script>
    </x-slot>
</x-dashboard-layout>
