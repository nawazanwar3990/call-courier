<x-dashboard-layout :page-title="$pageTitle">
    <x-breadcrumb :page-title="$pageTitle" :bread-crumbs="$breadCrumbs"/>
    <div class="card">
        <div class="card-body">
            <div class="card-header text-center">
                <div class="btn-group mb-3" role="group" aria-label="Redeem Status Filter">
                    @foreach(\App\Enums\RedeemStatusEnum::getTranslationKeys() as $rKey => $rStatus)
                        @php
                            $icons = [
                                \App\Enums\RedeemStatusEnum::REQUESTED => 'fa-spinner',
                                \App\Enums\RedeemStatusEnum::APPROVED => 'fa-check-circle',
                            ];
                        @endphp
                        <a type="button" href="{{ route('admin.redeems.index',['status'=>$rKey]) }}"
                           class="btn btn-outline-primary filter-btn {{ $rKey === $status ? 'bg-primary text-white' : '' }}"
                           data-status="{{ Str::slug($rStatus) }}">
                            <i class="fas {{ $icons[$rKey] ?? 'fa-question-circle' }} me-2"></i>{{ ucfirst($rStatus) }}
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="table-responsive-sm">
                <table class="table table-bordered table-hover table-compact w-100" id="redeem-table">
                    <thead>
                        <tr>
                            <th>{{ __('general.id') }}</th>
                            <th>{{ __('general.user') }}</th>
                            <th>{{ __('general.gift_card') }}</th>
                            @if($status==\App\Enums\RedeemStatusEnum::APPROVED)
                                <th>{{ __('general.redeem_code') }}</th>
                            @endif
                            <th>{{ __('general.created_at') }}</th>
                            <th class="text-center">{{ __('general.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <x-popup-modal />
    <x-slot name="pageJs">
        <script>
            var datatable;
            $(function () {
                datatable = $('#redeem-table').DataTable({
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
                    order: [[0, 'desc']],
                    serverSide: true,
                    processing: true,
                    paging: true,
                    responsive: true,
                    lengthMenu: [
                        [10, 25, 50, 100, -1],
                        [10, 25, 50, 100, "{{ __('general.all') }}"]
                    ],
                    pageLength: 100,
                    dom: '<"dt-action-buttons text-end pt-3 pt-md-0"B><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>tr<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                    buttons: [
                        {
                            extend: "collection",
                            className: "btn btn-label-primary dropdown-toggle me-2",
                            text: '<i class="far fa-file-export me-sm-1"></i> <span class="d-none d-sm-inline-block">{{ __('general.export') }}</span>',
                            buttons: [
                                {
                                    extend: "print",
                                    text: '<i class="far fa-print me-1"></i><span class="dt-dropdown-text-dark">{{ __('general.print') }}</span>',
                                    className: "dropdown-item",
                                    footer: true,
                                    exportOptions: {
                                        columns: ':not(.no-export)'
                                    }
                                },
                                {
                                    extend: "csv",
                                    text: '<i class="far fa-file-csv me-1"></i><span class="dt-dropdown-text-dark">{{ __('general.csv') }}</span>',
                                    className: "dropdown-item",
                                    footer: true,
                                    exportOptions: {
                                        columns: ':not(.no-export)'
                                    }
                                },
                                {
                                    extend: "excel",
                                    text: '<i class="far fa-file-excel me-1"></i><span class="dt-dropdown-text-dark">{{ __('general.excel') }}</span>',
                                    className: "dropdown-item",
                                    footer: true,
                                    exportOptions: {
                                        columns: ':not(.no-export)'
                                    }
                                },
                                {
                                    extend: "pdf",
                                    text: '<i class="far fa-file-pdf me-1"></i><span class="dt-dropdown-text-dark">{{ __('general.pdf') }}</span>',
                                    className: "dropdown-item",
                                    footer: true,
                                    exportOptions: {
                                        columns: ':not(.no-export)'
                                    }
                                }
                            ],
                        }
                    ],
                    ajax: {
                        url: "{{ route('admin.redeems.index') }}",
                        data: function (data) {
                            data.status = "{{ $status }}";
                        }
                    },
                    columns: [
                        {data: 'id'},
                        {data: 'created_by'},
                        {data: 'gift_card_id'},
                            @if($status == \App\Enums\RedeemStatusEnum::APPROVED)
                        {data: 'inventory_id'},
                            @endif
                        {data: 'created_at', name: 'created_at'},
                        {data: 'action', className: "text-center col-1 align-middle no-export", orderable: false, searchable: false}
                    ],
                    fnDrawCallback: function (oSettings) {
                        initTooltip();
                    }
                });
            });
        </script>
    </x-slot>
</x-dashboard-layout>
