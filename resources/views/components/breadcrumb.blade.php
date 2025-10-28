<div class="row py-3">
    <div class="col-md-6">
        <h4 class="mb-0">{{ $pageTitle ?? '' }}</h4>
    </div>
    @if (isset($breadCrumbs))
        <div class="col-md-6 d-none d-md-flex justify-content-end">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">

                    @foreach ($breadCrumbs as $key => $value)
                        @if ($loop->last)
                            <li class="breadcrumb-item active">
                                {{ $key }}
                            </li>
                        @else
                            <li class="breadcrumb-item">
                                <a {{ empty($value) ? '' : '' }} href="{!! empty($value) ? 'javascript:void(0);' : $value !!}">{{ $key }}</a>
                            </li>
                        @endif
                    @endforeach

                </ol>
            </nav>
        </div>
    @endif
</div>
