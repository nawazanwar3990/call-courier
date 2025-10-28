<!DOCTYPE html>
<html
    data-theme="theme-default"
    data-assets-path="{{ config('app.url') }}/assets/"
    data-template="horizontal-menu-template"
    class="light-style layout-menu-fixed"
>
<head>
    <x-meta-tags/>

    <title>{{ isset($pageTitle) ? ($pageTitle . ' : ') : '' }}RIO REWARDS</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
        rel="stylesheet"/>

    <script src="{{ asset('assets/vendor/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/node-waves/node-waves.js') }}"></script>

    <!-- Icons -->
    <link rel="stylesheet" href="{{asset('assets/vendor/fonts/fontawesome.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/vendor/fonts/tabler-icons.css')}}"/>

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{asset('assets/vendor/css/rtl/core.css')}}" class="template-customizer-core-css"/>
    <link rel="stylesheet" href="{{asset('assets/vendor/css/rtl/theme-default.css')}}"
          class="template-customizer-theme-css"/>

    <link rel="stylesheet" href="{{asset('assets/vendor/libs/nouislider/nouislider.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/swiper/swiper.css')}}"/>

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}"/>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}"/>
    <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>


    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/dropify/dist/css/dropify.min.css') }}"/>
    <script src="{{ asset('assets/vendor/libs/dropify/dist/js/dropify.min.js') }}"></script>

    <link rel="stylesheet" href="{{asset('assets/css/demo.css')}}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}"/>

    <x-global-fixed-scripts/>
    <style>
        .bg-menu-theme.menu-vertical .menu-item.active > .menu-link:not(.menu-toggle) {
            background: linear-gradient(72.47deg, #cb2027 22.16%, #cb2027 76.47%);
        }

        .object-fit-cover {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .text-truncate-2 {
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2; /* number of lines to show */
            -webkit-box-orient: vertical;
        }
    </style>
</head>
<body>
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <x-website-menu/>
        <div class="layout-page">
            <x-website-header/>
            {{ $slot }}
        </div>
    </div>
    <div class="layout-overlay layout-menu-toggle"></div>
</div>
<script src="{{asset('assets/vendor/libs/nouislider/nouislider.js')}}"></script>
<script src="{{asset('assets/vendor/libs/swiper/swiper.js')}}"></script>

<script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
<script src="{{ asset('assets/js/config.js') }}"></script>
<script src="{{asset('assets/js/front-main.js')}}"></script>
<script src="{{asset('assets/js/front-page-landing.js')}}"></script>

<script>
    $(document).ready(function () {
        $('.menu-item[data-target="earn-points"]').addClass('active');
        $('#mobile-menu-toggle').on('click', function () {
            console.log("click");

            const $menu = $('#website-layout-menu');

            if ($menu.hasClass('d-none')) {
                $menu.removeClass('d-none').addClass('d-block');
            } else {
                $menu.removeClass('d-block').addClass('d-none');
            }
        });

    });
</script>
</body>
</html>
