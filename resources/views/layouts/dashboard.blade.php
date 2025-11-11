<!DOCTYPE html>
<html
    data-theme="theme-default"
    data-assets-path="{{ config('app.url') }}/assets/"
    data-template="horizontal-menu-template"
    class="light-style layout-menu-fixed"
>
<head>
    <x-meta-tags/>

    <title>Call Courier</title>

    <link href="{{ asset('fonts/fa6-pro/css/all.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/tabler-icons.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/flag-icons.css') }}"/>
    <script src="{{ asset('js/theme-switch.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}"/>

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/node-waves/node-waves.css') }}"/>

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/jquery-ui/jquery-ui.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}"/>
    <link rel="stylesheet"
          href="{{ asset('assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css') }}"/>

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}"/>

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/dropify/dist/css/dropify.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}"/>
    <link rel="stylesheet" type="text/css"
          href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-profile.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/fullcalendar/fullcalendar.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/pace/flash.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/swiper/swiper.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/ui-carousel.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/lightbox/magnific-popup.css') }}"/>

    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}"/>
    <link rel="stylesheet" href="{{ asset('fonts/urdu/stylesheet.css') }}"/>

    <script src="{{ asset('assets/vendor/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/node-waves/node-waves.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/i18n/i18n.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/parsley-js/parsley.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/printArea/jquery.PrintArea.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/dropify/dist/js/dropify.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/pace/pace.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/fullcalendar/fullcalendar.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/swiper/swiper.js') }}"></script>
    <script src="{{ asset('fonts/urdu/urdu-keyboard.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/jquery-inputmask/jquery.inputmask.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/lightbox/jquery.magnific-popup.min.js') }}"></script>
    <x-global-fixed-scripts/>
</head>
<style>
    .card{
        background-color: #075a41;
        border: 4px solid #28c76f4d;
    }
    div.dataTables_wrapper div.dataTables_length label,
    div.dataTables_wrapper div.dataTables_filter label,
    .table td,.table th,
    .light-style div.dataTables_wrapper div.dataTables_info{
        color: white !important;
    }
</style>
<body style="background-image: url('{{ asset('assets/img/auth.jpg') }}');background-position: center;background-repeat: no-repeat;background-attachment: fixed;background-size: cover;background-color: #464646;">
<div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
    <div class="layout-container">
        <x-dashboard-header></x-dashboard-header>
        <div class="layout-page">
            <div class="content-wrapper">
                <div class="container-fluid flex-grow-1 container-p-y">
                    {{ $slot }}
                </div>
                <x-footer/>
                <div class="content-backdrop fade"></div>
            </div>
        </div>
    </div>
</div>

<div class="layout-overlay layout-menu-toggle"></div>
<button onclick="scrollToTop();" class="waves-effect scroll-to-top-btn">
    <i class="far fa-angle-up"></i>
</button>

<script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
<script src="{{ asset('assets/js/config.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>
<script>
    $(document).ready(function () {
        $('#mobile-menu-toggle').on('click', function () {
            console.log("click");
            $('#layout-menu').toggle();
        });
    });
</script>
<x-session-messages/>
{!! $pageJs ?? '' !!}
</body>
</html>
