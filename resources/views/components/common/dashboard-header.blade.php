<nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="container-fluid d-flex justify-content-between align-items-center">

        <!-- Brand -->
        <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
            <a href="{{ route('admin.dashboard') }}" class="app-brand-link gap-2">
                <x-application-logo />
            </a>
        </div>

        <!-- Centered Admin Menus -->
        <div class="d-flex justify-content-center flex-grow-1">
            <ul class="navbar-nav flex-row">
                @if(\App\Services\UserService::hasRole(\App\Enums\RoleEnum::ROLE_SUPER_ADMIN))
                    @foreach(\App\Enums\MenuEnum::getTranslationKeys() as $key => $value)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ \App\Enums\MenuEnum::getRoute($key) }}">
                                {!! \App\Enums\MenuEnum::getIcon($key) !!} {{ $value }}
                            </a>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>

        <!-- Right Side: Logout Only -->
        <div class="d-flex align-items-center">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-success">Logout</button>
            </form>
        </div>

    </div>
</nav>
