<!DOCTYPE html>
<html lang="en">
<head>
    <title> @yield('title') </title>
    <meta charset="utf-8"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge"/>
    <meta name="description" content=""/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta property="og:title" content=""/>
    <meta property="og:type" content=""/>
    <meta property="og:url" content=""/>
    <meta property="og:image" content=""/>
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('backend/assets/imgs/theme/favicon.svg')}}"/>
    <!-- Template CSS -->
    <link href="{{asset('backend/assets/css/main.css?v=1.1')}}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/sweetalert2.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/toastr/toastr.min.css') }}">

    @yield('addCss')

</head>

<body>
<div class="screen-overlay"></div>
@include('backend.partials.aside')
<main class="main-wrap">
    @include('backend.partials.header')
    <section class="content-main">
        @yield('content')
    </section>
    @include('backend.partials.footer')
</main>
<script src="{{asset('backend/assets/js/vendors/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('backend/assets/js/vendors/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('backend/assets/js/vendors/select2.min.js')}}"></script>
<script src="{{asset('backend/assets/js/vendors/perfect-scrollbar.js')}}"></script>
<script src="{{asset('backend/assets/js/vendors/jquery.fullscreen.min.js')}}"></script>
<!-- Main Script -->
<script src="{{asset('backend/assets/js/main.js?v=1.1" type="text/javascript')}}"></script>
<script type="module" src="{{ asset('backend/common/common.js') }}"></script>
<script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
<script src="{{ asset('vendor/toastr/toastr.min.js') }}"></script>
<script src="https://cdn.tiny.cloud/1/o9bdykr38uld5i7zkhn4eqt5oap4d75v9kp7uv58fvs3aijf/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>
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
