<aside id="website-layout-menu" class="layout-menu menu-vertical menu bg-menu-theme d-none d-lg-block d-md-block d-xl-block d-xxl-block">
    <div class="app-brand demo">
        <a href="{{ route('website.index') }}" class="app-brand-link">
            <div>
                <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" style="height: 30px;">
            </div>
            <span class="app-brand-text demo menu-text fw-bold mt-2">
                {{ config('app.name') }}
            </span>
        </a>
    </div>
    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">

        <li class="menu-item {{ request()->routeIs('website.earning-points') ? 'active' : '' }}"
            data-target="{{ trans('general.earning_points') }}">
            <a href="{{ route('website.earning-points') }}" class="menu-link">
                <i class="menu-icon fa-solid fa-coins" style="font-size: 18px"></i>
                <div data-i18n="{{ trans('general.earning_points') }}">{{ trans('general.earning_points') }}</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('website.branches.list') || request()->routeIs('website.task.detail') ? 'active' : '' }}" data-target="{{ trans('general.daily_tasks') }}">

            <a href="{{ route('website.branches.list') }}" class="menu-link">
                <i class="menu-icon fa-solid fa-file" style="font-size: 18px"></i>
                <div data-i18n="{{ trans('general.daily_tasks') }}">{{ trans('general.daily_tasks') }}</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('website.gift-cards.list') ? 'active' : '' }}"
            data-target="{{ trans('general.gift_cards') }}">
            <a href="{{ route('website.gift-cards.list') }}" class="menu-link">
                <i class="menu-icon fa-solid fa-gift" style="font-size: 18px"></i>
                <div data-i18n="{{ trans('general.gift_cards') }}">{{ trans('general.gift_cards') }}</div>
            </a>
        </li>
    </ul>
</aside>
