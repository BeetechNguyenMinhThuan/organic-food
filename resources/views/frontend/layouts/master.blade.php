<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8"/>
    <title>@yield('title')</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge"/>
    <meta name="description" content=""/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta property="og:title" content=""/>
    <meta property="og:type" content=""/>
    <meta property="og:url" content=""/>
    <meta property="og:image" content=""/>
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('frontend/assets/imgs/theme/favicon.svg')}}"/>
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{asset('frontend/assets/css/plugins/animate.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('frontend/assets/css/plugins/slider-range.css')}}"/>
    <link rel="stylesheet" href="{{asset('frontend/assets/css/main.css?v=5.3')}}"/>
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/sweetalert2.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{asset('frontend/assets/css/common.css')}}"/>
    @php
        $nameRoute = Route::currentRouteName();
    @endphp
    @yield('addCss')

</head>

<body>
@yield('modal')
@include('frontend.partials.header')
<!--End header-->
<main class="main">
    @yield('content')
</main>
@include('frontend.partials.footer')
<!-- Preloader Start -->
{{--@include('frontend.partials.preloader')--}}
<!-- Vendor JS-->
<script src="{{asset('frontend/assets/js/vendor/modernizr-3.6.0.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/vendor/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/vendor/jquery-migrate-3.3.0.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/vendor/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/plugins/slick.js')}}"></script>
<script src="{{asset('frontend/assets/js/plugins/jquery.syotimer.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/plugins/waypoints.js')}}"></script>
<script src="{{asset('frontend/assets/js/plugins/wow.js')}}"></script>
<script src="{{asset('frontend/assets/js/plugins/slider-range.js')}}"></script>
<script src="{{asset('frontend/assets/js/plugins/perfect-scrollbar.js')}}"></script>
<script src="{{asset('frontend/assets/js/plugins/magnific-popup.js')}}"></script>
<script src="{{asset('frontend/assets/js/plugins/select2.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/plugins/counterup.js')}}"></script>
<script src="{{asset('frontend/assets/js/plugins/jquery.countdown.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/plugins/images-loaded.js')}}"></script>
<script src="{{asset('frontend/assets/js/plugins/isotope.js')}}"></script>
<script src="{{asset('frontend/assets/js/plugins/scrollup.js')}}"></script>
<script src="{{asset('frontend/assets/js/plugins/jquery.vticker-min.js')}}"></script>
<script src="{{asset('frontend/assets/js/plugins/jquery.theia.sticky.js')}}"></script>
<script src="{{asset('frontend/assets/js/plugins/jquery.elevatezoom.js')}}"></script>
<script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('vendor/toastr/toastr.min.js') }}"></script>
<!-- Template  JS -->
<script src="{{asset('frontend/assets/js/main.js?v=5.3')}}"></script>
<script src="{{asset('frontend/assets/js/shop.js?v=5.3')}}"></script>
<script src="{{asset('frontend/common/js/common.js')}}"></script>
<script type="module">
    // Show alert
    @if(session('status_succeed'))
    toastr.success('{{session('status_succeed')}}', {timeOut: 5000})
    @elseif(session('status_failed'))
    toastr.error('{{session('status_failed')}}', {timeOut: 5000})
    @endif
</script>
@yield('addJs')
</body>

</html>
