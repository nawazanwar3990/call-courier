<div class="app-brand justify-content-center mb-4 mt-2">
    <span class="app-brand-logo demo">
        <a href="{{ route('website.index') }}" class="app-brand-link">
            <div>
                <img src="{{ asset('assets/img/logo.png') }}" alt="{{ config('app.name') }}" style="height: 30px;">
            </div>
            <span class="app-brand-text demo menu-text fw-bold mt-2">{{ config('app.name') }}</span>
        </a>
    </span>
</div>
@if($type==='login')
    <h4 class="mb-1 pt-2">{{ trans('general.login_logo_heading') }}</h4>
    <p class="mb-4">{{ trans('general.login_logo_description') }}</p>
@else
    <h4 class="mb-1 pt-2">{{ trans('general.register_logo_heading') }}</h4>
    <p class="mb-4">{{ trans('general.register_logo_description') }}</p>
@endif
