<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Hyper - Responsive Bootstrap 4 Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description"/>
    <meta content="Coderthemes" name="author"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('backend/assets/images/favicon.ico')}}">

    <!-- third party css -->
    <link href="{{asset('backend/assets/css/vendor/jquery-jvectormap-1.2.2.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('backend/assets/css/vendor/dataTables.bootstrap4.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('backend/assets/css/vendor/responsive.bootstrap4.css')}}" rel="stylesheet" type="text/css"/>


    <!-- third party css end -->

    <!-- App css -->
    <link href="{{asset('backend/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('backend/assets/css/app-modern.min.css')}}" rel="stylesheet" type="text/css" id="light-style"/>
    <link href="{{asset('backend/assets/css/app-modern-dark.min.css')}}" rel="stylesheet" type="text/css"
          id="dark-style"/>

    <link rel="stylesheet" href="{{ asset('backend/common/css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">

    @yield('addCss')

</head>

<body class="loading"
      data-layout-config='{"leftSideBarTheme":"default","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>
<!-- Begin page -->
<div class="wrapper">
    <!-- ========== Left Sidebar Start ========== -->
    @include('backend.partials.aside')

    <!-- Left Sidebar End -->

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content-page">
        <div class="content">
            <!-- Topbar Start -->
            @include('backend.partials.header')
            <!-- end Topbar -->

            <!-- Start Content-->
            <div class="container-fluid">
                @yield('content')
            </div>
            <!-- container -->
        </div>
        <!-- content -->

        <!-- Footer Start -->
        @include('backend.partials.footer')
        <!-- end Footer -->

    </div>

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->


</div>
<!-- END wrapper -->

<!-- Right Sidebar -->
<div class="right-bar">

    <div class="rightbar-title">
        <a href="javascript:void(0);" class="right-bar-toggle float-right">
            <i class="dripicons-cross noti-icon"></i>
        </a>
        <h5 class="m-0">Settings</h5>
    </div>

    <div class="rightbar-content h-100" data-simplebar>

        <div class="p-3">
            <div class="alert alert-warning" role="alert">
                <strong>Customize </strong> the overall color scheme, sidebar menu, etc.
            </div>

            <!-- Settings -->
            <h5 class="mt-3">Color Scheme</h5>
            <hr class="mt-1"/>

            <div class="custom-control custom-switch mb-1">
                <input type="radio" class="custom-control-input" name="color-scheme-mode" value="light"
                       id="light-mode-check" checked/>
                <label class="custom-control-label" for="light-mode-check">Light Mode</label>
            </div>

            <div class="custom-control custom-switch mb-1">
                <input type="radio" class="custom-control-input" name="color-scheme-mode" value="dark"
                       id="dark-mode-check"/>
                <label class="custom-control-label" for="dark-mode-check">Dark Mode</label>
            </div>

            <!-- Left Sidebar-->
            <h5 class="mt-4">Left Sidebar</h5>
            <hr class="mt-1"/>

            <div class="custom-control custom-switch mb-1">
                <input type="radio" class="custom-control-input" name="compact" value="fixed" id="fixed-check"
                       checked/>
                <label class="custom-control-label" for="fixed-check">Scrollable</label>
            </div>

            <div class="custom-control custom-switch mb-1">
                <input type="radio" class="custom-control-input" name="compact" value="condensed"
                       id="condensed-check"/>
                <label class="custom-control-label" for="condensed-check">Condensed</label>
            </div>

            <button class="btn btn-primary btn-block mt-4" id="resetBtn">Reset to Default</button>

            <a href="https://themes.getbootstrap.com/product/hyper-responsive-admin-dashboard-template/"
               class="btn btn-danger btn-block mt-3" target="_blank"><i class="mdi mdi-basket mr-1"></i> Purchase
                Now</a>
        </div> <!-- end padding-->

    </div>
</div>

<div class="rightbar-overlay"></div>
<!-- /Right-bar -->

<!-- bundle -->
<script src="{{asset('backend/assets/js/vendor.min.js')}}"></script>
<script src="{{asset('backend/assets/js/app.min.js')}}"></script>

<!-- third party js -->
<script src="{{asset('backend/assets/js/vendor/apexcharts.min.js')}}"></script>
<script src="{{asset('backend/assets/js/vendor/jquery-jvectormap-1.2.2.min.js')}}"></script>
<script src="{{asset('backend/assets/js/vendor/jquery-jvectormap-world-mill-en.js')}}"></script>
<script src="{{asset('backend/assets/js/vendor/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('backend/assets/js/vendor/dataTables.bootstrap4.js')}}"></script>
<script src="{{asset('backend/assets/js/vendor/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('backend/assets/js/vendor/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('backend/assets/js/vendor/dataTables.checkboxes.min.js')}}"></script>
<script src="{{asset('backend/assets/js/vendor/dropzone.min.js')}}"></script>
<script src="{{asset('backend/assets/js/ui/component.fileupload.js')}}"></script>
<!-- third party js ends -->
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
<!-- demo app -->
<!-- end demo js-->
<script type="module" src="{{ asset('backend/common/js/common.js') }}"></script>
@include('backend.common.common')
{{--<script src="{{ asset('vendor/select2/select2.min.js') }}"></script>--}}
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
