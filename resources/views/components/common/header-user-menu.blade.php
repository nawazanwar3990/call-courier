<li class="nav-item navbar-dropdown dropdown-user dropdown me-3">
    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
        <div class="avatar avatar-online">
            <img src="{{ auth()->user()->getFirstMediaUrl('picture') }}" onerror="this.src='{{ asset('assets/img/user-picture.jpg') }}'" alt class="h-auto rounded-circle"
                 style="width: 40px !important;height: 40px !important;"/>
            <i class="ti ti-chevron-down text-muted"></i>
        </div>
    </a>
    <ul class="dropdown-menu dropdown-menu-end">
        <li class=" d-lg-block">
            <a  class="dropdown-item" href="{{ route('admin.profile.index') }}">
                <i class="ti ti-user-check me-2 ti-sm"></i>
                <span class="align-middle">{{ __('general.my_profile') }}</span>
            </a>
        </li>
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
