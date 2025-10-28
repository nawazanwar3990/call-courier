<nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="container-fluid d-flex flex-row justify-content-between">
        <!-- Brand and Toggle -->
        <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
            <a href="{{ route('admin.dashboard') }}" class="app-brand-link gap-2">
                <x-application-logo />
            </a>
        </div>

        <!-- Mobile Menu Toggle Button -->
        <a id="mobile-menu-toggle" class="nav-item nav-link d-xl-none" href="javascript:void(0)">
            <img src="{{ asset('assets/img/menu.jpg') }}" alt="" style="width: 30px;height: 30px;"/>
        </a>

        <!-- Right Side -->
        <div class="d-flex align-items-center" id="navbar-collapse">
            <ul class="navbar-nav flex-row align-items-center">
                <x-header-user-menu />
            </ul>
        </div>
    </div>
</nav>
