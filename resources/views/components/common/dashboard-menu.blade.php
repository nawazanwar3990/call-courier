<aside id="layout-menu" class="layout-menu-horizontal menu-horizontal menu bg-menu-theme flex-grow-0">
    <div class="d-flex container-fluid">

        <div class="menu-horizontal-wrapper w-100">
            <ul class="menu-inner d-flex justify-content-center flex-wrap">
                @foreach(\App\Enums\MenuEnum::getTranslationKeys() as $key => $value)
                    @if($key == 'submissions')
                        <li class="menu-item single-item">
                            <a class="menu-link single-link" href="{{ \App\Enums\MenuEnum::getRoute($key) }}">
                                {!! \App\Enums\MenuEnum::getIcon($key) !!}
                                <div data-i18n="{{ $key }}">{{ $value }}</div>
                            </a>
                        </li>
                    @endif
                    @can('hasAccess', \App\Enums\MenuEnum::getPermissionName($key))
                        <li class="menu-item single-item">
                            <a class="menu-link single-link" href="{{ \App\Enums\MenuEnum::getRoute($key) }}">
                                {!! \App\Enums\MenuEnum::getIcon($key) !!}
                                <div data-i18n="{{ $key }}">{{ $value }}</div>
                            </a>
                        </li>
                    @endcan
                @endforeach
            </ul>
        </div>
    </div>
</aside>
