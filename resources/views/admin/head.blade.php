@php
    $admin_favicon=\App\Models\Custom::getValByName('company_favicon');
    $app_name=\App\Models\Custom::getValByName('app_name');

@endphp
<head>
    <!-- Required meta tags-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>{{!empty($app_name)?$app_name:env('APP_NAME')}} - @yield('page-title') </title>
    <!-- shortcut icon-->
    <link rel="icon" href="{{asset(Storage::url('upload/logo')).'/'.$admin_favicon}}" type="image/x-icon">
    <link rel="shortcut icon" href="{{asset(Storage::url('upload/logo')).'/'.$admin_favicon}}" type="image/x-icon">
    <!-- Fonts css-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    <!-- Font awesome -->
    <link href="{{ asset('assets/css/vendor/font-awesome.css') }}" rel="stylesheet">
    <!-- themify icon-->
    <link href="{{ asset('assets/css/vendor/themify-icons.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/css/vendor/datatable/jquery.dataTables.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/vendor/datatable/buttons.dataTables.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/vendor/datatable/custom-datatable.css') }}" rel="stylesheet">

    <!-- Slick slider-->
    <link href="{{ asset('assets/css/vendor/slider/slick-slider/slick.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/vendor/slider/slick-slider/slick-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/vendor/select2/select2.css') }}" rel="stylesheet">

    <!-- Scrollbar-->
    <link href="{{ asset('assets/css/vendor/simplebar.css') }}" rel="stylesheet">
    <!-- Bootstrap css-->
    <link href="{{ asset('assets/css/vendor/bootstrap.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/css/vendor/sweetalert/sweetalert2.css') }}" rel="stylesheet">

    <!-- WYSIWYG -->

    <!-- Custom css-->
    @php
        $style=$settings['theme_color']=='color1'?'style.css':$settings['theme_color'].'.css';
    @endphp
    <link href="{{ asset('assets/css/'.$style) }}" id="customstyle" rel="stylesheet">

    <link href="{{ asset('css/custom.css') }}"  rel="stylesheet">

    @stack('css-page')
</head>
