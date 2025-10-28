<li class="nav-item navbar-dropdown me-1 me-xl-1">
    @if(count(auth()->user()->unreadNotifications) > 0)
        @php
            $route = \App\Services\UserService::hasRole(\App\Enums\RoleEnum::ROLE_USER)
                ? route('website.notifications')
                : route('admin.notifications');
        @endphp
        <a class="nav-link hide-arrow" href="{{ $route }}">
            <span class="position-relative">
                <i class="ti ti-ticket ti-md" style="transform: rotate(125deg); display: inline-block;"></i>
                <span class="position-absolute top-0 start-50 badge rounded-pill bg-danger badge-dot border border-2 p-1 fa-fade"
                      id="notification_badge"
                      style="{{ auth()->user()->unreadNotifications->count() > 0 ? '' : 'display:none;' }}">
                </span>
            </span>
        </a>
    @endif
</li>
