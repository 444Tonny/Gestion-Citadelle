@php
    $admin_favicon=\App\Models\Custom::getValByName('company_favicon');
    $app_name=\App\Models\Custom::getValByName('app_name');
@endphp
    <!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <title>{{env('APP_NAME')}} - @yield('tab-title')</title>
    <!-- shortcut icon-->
    <link rel="icon" href="{{asset(Storage::url('upload/logo')).'/'.$admin_favicon}}" type="image/x-icon">
    <link rel="shortcut icon" href="{{asset(Storage::url('upload/logo')).'/'.$admin_favicon}}" type="image/x-icon">
    <!-- Fonts css-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap"
        rel="stylesheet">
    <!-- Font awesome -->
    <link href="{{ asset('assets/css/vendor/font-awesome.css')}}" rel="stylesheet">
    <!-- themify icon-->
    <link href="{{ asset('assets/css/vendor/themify-icons.css')}}" rel="stylesheet">
    <!-- Scrollbar-->
    <link href="{{ asset('assets/css/vendor/simplebar.css')}}" rel="stylesheet">
    <!-- Bootstrap css-->
    <link href="{{ asset('assets/css/vendor/bootstrap.css')}} " rel="stylesheet">
    <!-- Custom css-->
    <link href="{{ asset('assets/css/style.css')}} " id="customstyle" rel="stylesheet">

</head>
<body>
<!-- Login Start-->
<div class="auth-main">
    @yield('content')
</div>
<!-- Login End-->
<!-- main jquery-->
<script src="{{ asset('assets/js/jquery.js')}}"></script>
<!-- Theme Customizer-->
<script src="{{ asset('assets/js/layout-storage.js')}}"></script>
<script src="{{ asset('assets/js/customizer.js')}}"></script>
<!-- Feather icons js-->
<script src="{{ asset('assets/js/icons/feather-icon/feather.js')}}"></script>
<!-- Bootstrap js-->
<script src="{{ asset('assets/js/bootstrap.bundle.js')}}"></script>
<!-- Scrollbar-->
<script src="{{ asset('assets/js/vendors/simplebar.js')}}"></script>
<!-- Custom script-->
<script src="{{ asset('assets/js/custom-script.js')}}"></script>
</body>
</html>
