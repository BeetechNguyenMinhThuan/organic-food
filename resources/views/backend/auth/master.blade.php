<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Log In | Hyper - Responsive Bootstrap 4 Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- App css -->
    <link href="{{asset('backend/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('backend/assets/css/app-modern.min.css')}}" rel="stylesheet" type="text/css" id="light-style"/>
    <link href="{{asset('backend/assets/css/app-modern-dark.min.css')}}" rel="stylesheet" type="text/css"/>

</head>

<body class="loading authentication-bg" data-layout-config='{"darkMode":false}'>
<div class="account-pages mt-5 mb-5">
    <div class="container">
        @yield('content')
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
<!-- end page -->

<footer class="footer footer-alt">
    2018 - 2020 © Hyper - Coderthemes.com
</footer>

<!-- bundle -->
<script src="{{asset('backend/assets/js/vendor.min.js')}}"></script>
<script src="{{asset('backend/assets/js/app.min.js')}}"></script>

</body>
</html>
