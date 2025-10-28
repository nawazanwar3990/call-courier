<li class="d-inline-flex align-items-center py-2 rounded text-white gap-0 me-2">
    @if(auth()->user() and \App\Services\UserService::hasRole(\App\Enums\RoleEnum::ROLE_USER))
        <a href="{{route('website.wallet')}}">
            @include('components.coin-icon')
            <span class="fw-bold fs-6 text-dark">{{ auth()->user()->total_coins }}</span>
        </a>
    @endif
</li>
<li class="nav-item navbar-dropdown dropdown-user dropdown me-3">
    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
        <div class="avatar avatar-online">
            <img src="{{ auth()->user()->getFirstMediaUrl('picture') }}" onerror="this.src='{{ asset('assets/img/user-picture.jpg') }}'" alt class="h-auto rounded-circle"
                 style="width: 40px !important;height: 40px !important;"/>
            <i class="ti ti-chevron-down text-muted"></i>
        </div>
    </a>
    <ul class="dropdown-menu dropdown-menu-end">
        @if(\App\Services\UserService::hasRole(\App\Enums\RoleEnum::ROLE_SUPER_ADMIN))
            <li class=" d-lg-block">
                <a  class="dropdown-item" href="{{ route('admin.profile.index') }}">
                    <i class="ti ti-user-check me-2 ti-sm"></i>
                    <span class="align-middle">{{ __('general.my_profile') }}</span>
                </a>
            </li>
        @else
            <li class=" d-lg-block">
                <a  class="dropdown-item" href="{{ route('website.user.profile') }}">
                    <i class="ti ti-user-check me-2 ti-sm"></i>
                    <span class="align-middle">{{ __('general.my_profile') }}</span>
                </a>
            </li>
        @endif
        <li>
            <div class="dropdown-divider"></div>
        </li>
        <li>
            <a class="dropdown-item" href="javascript:void(0);" onclick="askForLogout();">
                <i class="ti ti-logout me-2 ti-sm"></i>
                <span class="align-middle">{{ __('general.logout') }}</span>
            </a>
            <form method="POST" action="{{ route('logout') }}" id="logoutForm" class="">
                @csrf
            </form>
        </li>
    </ul>
</li>
