@props([
    'expanded' => false,
    'route' => '',
    'defaultValues' => true,
])
<div class="accordion mb-3" id="accordionWithIcon">
    <div class="card accordion-item border border-primary {{ $expanded ? 'active' : '' }}">
        <h2 class="accordion-header d-flex align-items-center">
            <button type="button" class="accordion-button text-primary {{ $expanded ? '' : 'collapsed' }}"
                    data-bs-toggle="collapse" data-bs-target="#filters" aria-expanded="true">
                <i class="fa-regular fa-filters me-2"></i>
                {{ __('general.filters') }}
            </button>
        </h2>

        <div id="filters" class="accordion-collapse collapse {{ $expanded ? 'show' : '' }}">
            <div class="accordion-body">
                {{ html()->form('GET', $route)->acceptsFiles()->id('ledger_form')->open() }}
                <div class="row">
                    <div class="col-md-3 mb-2">
                        {{ html()->label(__('general.supplier'), 'supplier-id')->class('form-label') }}
                        {{ html()->select('supplier-id', \App\Services\SupplierService::getSuppliersForDropdown())->id('supplier-id')->value(request()->query('supplier-id'))
                            ->class(['form-control', 'select2'])->placeholder(__('general.ph_supplier'))->style('width:100%') }}
                    </div>
                    <div class="col-md-3 mb-2">
                        {{ html()->label(__('general.from_date'), 'from-date')->class('form-label') }}
                        <div class="input-group input-group-merge">
                            {{ html()->text('from-date')->id('from-date')->class(['form-control', 'date-picker'])->attributes([
                                'autocomplete'=>'off',
                            ])->value(request()->has('from-date') ? request()->query('from-date') : ($defaultValues ? formatDate(today()->toDateString()) : null) ) }}
                            <span class="input-group-text"><i class="far fa-calendar-alt fa-sm"></i></span>
                        </div>
                    </div>
                    <div class="col-md-3 mb-2">
                        {{ html()->label(__('general.to_date'), 'to-date')->class('form-label') }}
                        <div class="input-group input-group-merge">
                            {{ html()->text('to-date')->id('to-date')->class(['form-control', 'date-picker'])->attributes([
                                'autocomplete'=>'off',
                            ])->value(request()->has('to-date') ? request()->query('to-date') : ($defaultValues ? formatDate(today()->toDateString()) : null) ) }}
                            <span class="input-group-text"><i class="far fa-calendar-alt fa-sm"></i></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-end">
                        <div class="btn-group">
                            <button type="submit" class="btn btn-outline-primary waves-effect">
                                <i class="fa-regular fa-search fa-lg"></i><span
                                    class="d-none d-md-block">&nbsp;{{ __('general.search') }}</span>
                            </button>
                            <a  href="{{ $route }}"
                               class="btn btn-outline-danger waves-effect">
                                <i class="fa-regular fa-times fa-lg"></i><span
                                    class="d-none d-md-block">&nbsp;{{ __('general.clear') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
                {{ html()->form()->close() }}
            </div>
        </div>
    </div>
</div>
