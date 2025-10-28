<div>
    <nav class="layout-navbar navbar navbar-expand-lg navbar-dark bg-navbar-theme px-4 d-lg-flex"
         style="position: fixed; width: 100%; top: 0; left: 0; z-index: 1030;" id="layout-navbar">
        <ul class="navbar-nav flex-row align-items-center ms-auto">
            @auth
                <x-header-notification/>
                <x-header-user-menu/>
            @else
                <li class="nav-link me-2">
                    <a class="nav-item btn btn-primary text-white" href="{{ route('login') }}">
                        <i class="fas fa-sign-in-alt me-1"></i> {{ trans('general.login') }}
                    </a>
                </li>
                <li class="nav-link">
                    <a class="nav-item btn btn-primary text-white" href="{{ route('register') }}">
                        <i class="fas fa-user-plus me-1"></i> {{ trans('general.register') }}
                    </a>
                </li>
            @endauth
        </ul>
    </nav>
    <nav class="d-lg-none navbar navbar-light bg-white border-top fixed-bottom px-0 shadow" style="overflow: visible;">
        <div class="container-fluid d-flex justify-content-around text-center py-3">
            <!-- Home -->
            <a href="{{ route('website.index') }}"
               class="nav-link mobile-nav-item {{ request()->routeIs('website.index') ? 'active-mobile-home-link' : '' }}">
            <span class="circle-icon">
                <i class="fa-solid fa-house fs-4 d-block"></i>
            </span>
            </a>
            <!-- Gift Cards -->
            <a href="{{ route('website.gift-cards.list') }}"
               class="nav-link mobile-nav-item {{ request()->routeIs('website.gift-cards.list') ? 'active-mobile-home-link' : '' }}">
            <span class="circle-icon">
                <i class="fa-solid fa-gift fs-4 d-block"></i>
            </span>
            </a>

            <!-- Profile -->
            <a href="{{ route('website.user.profile') }}"
               class="nav-link mobile-nav-item {{ request()->routeIs('website.user.profile') ? 'active-mobile-home-link' : '' }}">
            <span class="circle-icon">
                <i class="fa-solid fa-user fs-4 d-block"></i>
            </span>
            </a>

        </div>
    </nav>


</div>
