<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="">
    <meta name="keywords"
          content="admin template,html 5 admin template , dmeki admin , dashboard template, bootstrap 5 admin template, responsive admin template">
    <title>{{env('APP_NAME')}}</title>
    <!-- shortcut icon-->
    <link rel="shortcut icon" href="{{asset(Storage::url('upload/logo')).'/favicon.png'}}" type="image/x-icon">
    <!-- Fonts css-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap"
        rel="stylesheet">
    <!-- Font awesome -->
    <link href="{{ asset('assets/css/vendor/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/vendor/icoicon/icoicon.css') }}" rel="stylesheet">
    <!-- animat css-->
    <link href="{{ asset('assets/css/vendor/animate.css') }}" rel="stylesheet">
    <!-- Bootstrap css-->
    <link href="{{ asset('assets/css/vendor/bootstrap.css') }}" rel="stylesheet">
    <!-- Custom css-->

    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>
<body>
<!-- header start-->
<header class="land-header fixed">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="header-contain position-relative">
                    <div class="codex-brand">
                        <a href="javascript:void(0);">
                            <img class="img-fluid dark-logo landing-logo" src="{{ asset('assets/images/logo/dark-logo.png') }}"
                                 alt="">
                        </a>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="menu-block">
                            <ul class="menu-list">
                                <li class="d-xl-none">
                                    <a class="close-menu" href="javascript:void(0);">
                                        <div class="menu-brand">
                                            <img class="img-fluid" src="{{ asset('assets/images/logo/logo.png') }}" alt=""><i data-feather="x"></i>
                                        </div>
                                    </a>
                                </li>
                                <li class="menu-item"><a href="#demos">{{__('Home')}}</a></li>
                                <li class="menu-item"><a href="#innderpages">{{__('Inner pages')}}</a></li>
                                <li class="menu-item"><a href="#features">{{__('Features')}}</a></li>
                                <li class="menu-item">
                                    <a class="btn btn-primary me-2" href="{{route('login')}}">{{__('Login')}} </a>
                                    <a class="btn btn-primary" href="{{route('register')}}">{{__('Register')}} </a>
                                </li>

                            </ul>
                            <a class="menu-action d-xl-none" href="javascript:void(0);"><i class="fa fa-bars"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- header end-->
<!-- intro start-->
<section class="intro">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-lg-7 col-lg-7">
                <div class="intro-contain">
                    <div>
                        <h1 class="wow fadeInLeft" data-wow-duration="1s">{{__('Smart Tenant - Property Management System')}}</h1>
                        <p class="wow fadeInLeft" data-wow-duration="1.5s">{{__('Property management refers to the administration, operation, and oversight of real estate properties on behalf of property owners. It involves various tasks such as marketing rental properties, finding tenants, collecting rent and ensuring legal compliance.')}}</p>
                        <a class="btn btn-primary" href="{{route('login')}}" data-wow-duration="1.8s"><i  class="fa fa-television" aria-hidden="true"></i>live demo </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- intro end-->
<!-- demo start-->
<section class="space-py-100" id="demos">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1">
                <div class="land-title">
                    <h2 class="wow fadeInLeft">{{__('Home')}}</h2>
                    <p class="wow fadeInRight">{{__('Property managers maintain accurate financial records, including income and expense tracking, budgeting, and providing owners with regular financial reports.')}}</p>
                </div>
            </div>
        </div>
        <div class="row cdx-row justify-content-center">
            <div class="col-md-6 wow fadeInUp" data-wow-duration="0.8s">
                <div class="demo-grid">
                    <div class="img-wrap">
                        <img class="img-fluid" src="{{ asset('assets/images/landing/1.png') }}" alt="">
                        <div class="group-link">
                            <a class="hover-link" href="javascript:void(0);">
                                <img class="img-fluid" src="{{ asset('assets/images/landing/feathure/bootstrap.png') }}"
                                     alt=""></a>
                            <a class="hover-link" href="javascript:void(0);">
                                <img class="img-fluid" src="{{ asset('assets/images/landing/feathure/tailwind.png') }}"
                                     alt=""></a></div>
                    </div>
                    <div class="demo-detail">
                        <h3>{{__('Home')}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-6 wow fadeInUp" data-wow-duration="1.5s">
                <div class="demo-grid">
                    <div class="img-wrap">
                        <img class="img-fluid" src="{{ asset('assets/images/landing/2.png') }}" alt="">
                        <div class="group-link">
                            <a class="hover-link"
                               href="javascript:void(0);"><img
                                    class="img-fluid"
                                    src="{{ asset('assets/images/landing/feathure/bootstrap.png') }}"
                                    alt=""></a><a class="hover-link"
                                                  href="javascript:void(0);"><img
                                    class="img-fluid"
                                    src="{{ asset('assets/images/landing/feathure/tailwind.png') }}"
                                    alt=""></a></div>
                    </div>
                    <div class="demo-detail">
                        <h3>{{__('Property')}}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- demo end-->
<!-- header otpion start-->
<section class="landheader-comp space-py-100 overflow-visible">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="header-detail">
                    <div>
                        <h2 class="wow fadeInUp" data-wow-duration="0.8s">500+ {{__('Properties')}}</h2>
                        <p class="wow fadeInUp" data-wow-duration="1.3s">{{__('Property managers maintain accurate financial records, including income and expense tracking, budgeting, and providing owners with regular financial reports.')}}</p><a
                            class="btn btn-primary btn-md wow fadeInUp" data-wow-duration="1.8s"
                            href="javascript:void(0);">{{__('Exploar now')}}</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="row cdx-row">

                    <div class="col-lg-12 col-md-6">
                        <div class="demo-grid">
                            <div class="img-wrap"><img class="img-fluid"
                                                       src="{{ asset('assets/images/landing/3.png') }}"
                                                       alt=""></div>
                            <div class="demo-detail">
                                <h3 class="text-white">{{__('Property Details')}}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-6">
                        <div class="demo-grid">
                            <div class="img-wrap"><img class="img-fluid"
                                                       src="{{ asset('assets/images/landing/4.png') }}"
                                                       alt=""></div>
                            <div class="demo-detail">
                                <h3 class="text-white">{{__('Tenant')}}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-6">
                        <div class="demo-grid">
                            <div class="img-wrap"><img class="img-fluid"
                                                       src="{{ asset('assets/images/landing/5.png') }}"
                                                       alt=""></div>
                            <div class="demo-detail">
                                <h3 class="text-white">{{__('Invoice')}}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-6">
                        <div class="demo-grid">
                            <div class="img-wrap"><img class="img-fluid"
                                                       src="{{ asset('assets/images/landing/6.png') }}"
                                                       alt=""></div>
                            <div class="demo-detail">
                                <h3 class="text-white">{{__('Roles & Permissions')}}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- header otpion End-->
<!-- innderpages start-->
<section class="space-py-100" id="innderpages">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1">
                <div class="land-title">
                    <h2 class="wow fadeInUp" data-wow-duration="1s">{{__('Dedicated Features')}} </h2>
                </div>
            </div>
        </div>
        <div class="row cdx-row">
            <div class="col-lg-4 col-md-6 wow fadeInUp">
                <div class="demo-grid">
                    <div class="img-wrap"><img class="img-fluid"
                                               src="{{ asset('assets/images/landing/1.png') }}"
                                               alt="">
                        <div class="group-link"><a class="hover-link"
                                                   href="javascript:void(0);"><img
                                    class="img-fluid"
                                    src="{{ asset('assets/images/landing/feathure/bootstrap.png') }}"
                                    alt=""></a><a class="hover-link"
                                                  href="javascript:void(0);"><img
                                    class="img-fluid"
                                    src="{{ asset('assets/images/landing/feathure/tailwind.png') }}"
                                    alt=""></a></div>
                    </div>
                    <div class="demo-detail">
                        <h3>{{__('Dashboard')}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp">
                <div class="demo-grid">
                    <div class="img-wrap"><img class="img-fluid"
                                               src="{{ asset('assets/images/landing/2.png') }}"
                                               alt="">
                        <div class="group-link"><a class="hover-link"
                                                   href="javascript:void(0);"><img
                                    class="img-fluid"
                                    src="{{ asset('assets/images/landing/feathure/bootstrap.png') }}"
                                    alt=""></a><a class="hover-link"
                                                  href="javascript:void(0);"><img
                                    class="img-fluid"
                                    src="{{ asset('assets/images/landing/feathure/tailwind.png') }}"
                                    alt=""></a></div>
                    </div>
                    <div class="demo-detail">
                        <h3>{{__('Property')}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp">
                <div class="demo-grid">
                    <div class="img-wrap"><img class="img-fluid"
                                               src="{{ asset('assets/images/landing/4.png') }}"
                                               alt="">
                        <div class="group-link"><a class="hover-link"
                                                   href="javascript:void(0);"><img
                                    class="img-fluid"
                                    src="{{ asset('assets/images/landing/feathure/bootstrap.png') }}"
                                    alt=""></a><a class="hover-link"
                                                  href="javascript:void(0);"><img
                                    class="img-fluid"
                                    src="{{ asset('assets/images/landing/feathure/tailwind.png') }}"
                                    alt=""></a></div>
                    </div>
                    <div class="demo-detail">
                        <h3>{{__('Tenant')}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp">
                <div class="demo-grid">
                    <div class="img-wrap"><img class="img-fluid"
                                               src="{{ asset('assets/images/landing/5.png') }}"
                                               alt="">
                        <div class="group-link"><a class="hover-link"
                                                   href="javascript:void(0);"><img
                                    class="img-fluid"
                                    src="{{ asset('assets/images/landing/feathure/bootstrap.png') }}"
                                    alt=""></a><a class="hover-link"
                                                  href="javascript:void(0);"><img
                                    class="img-fluid"
                                    src="{{ asset('assets/images/landing/feathure/tailwind.png') }}"
                                    alt=""></a></div>
                    </div>
                    <div class="demo-detail">
                        <h3>{{__('Invoice detail')}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp">
                <div class="demo-grid">
                    <div class="img-wrap"><img class="img-fluid"
                                               src="{{ asset('assets/images/landing/7.png') }}"
                                               alt="">
                        <div class="group-link"><a class="hover-link"
                                                   href="javascript:void(0);"><img
                                    class="img-fluid"
                                    src="{{ asset('assets/images/landing/feathure/bootstrap.png') }}"
                                    alt=""></a><a class="hover-link"
                                                  href="javascript:void(0);"><img
                                    class="img-fluid"
                                    src="{{ asset('assets/images/landing/feathure/tailwind.png') }}"
                                    alt=""></a></div>
                    </div>
                    <div class="demo-detail">
                        <h3>{{__('Expenses')}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp">
                <div class="demo-grid">
                    <div class="img-wrap"><img class="img-fluid"
                                               src="{{ asset('assets/images/landing/6.png') }}"
                                               alt="">
                        <div class="group-link"><a class="hover-link"
                                                   href="javascript:void(0);"><img
                                    class="img-fluid"
                                    src="{{ asset('assets/images/landing/feathure/bootstrap.png') }}"
                                    alt=""></a><a class="hover-link"
                                                  href="javascript:void(0);"><img
                                    class="img-fluid"
                                    src="{{ asset('assets/images/landing/feathure/tailwind.png') }}"
                                    alt=""></a></div>
                    </div>
                    <div class="demo-detail">
                        <h3>{{__('Uer Roles & Permissions')}}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- innderpages end-->
<!-- feathure start-->
<section class="feathure bg-white space-py-100" id="features">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="land-title">
                    <h2 class="wow fadeInUp" data-wow-duration="1s">{{__('Features')}}</h2>
                </div>
            </div>
        </div>
        <div class="row cdx-row justify-content-center">
            <div class="col-lg-3 col-6 wow fadeInUp">
                <div class="feathure-grid">
                    <div class="icon-wrap">
                        <img class="img-fluid" src="{{ asset('assets/images/landing/feathure/1.png') }}" alt=""></div>
                    <h5>{{__('html 5')}}</h5>
                </div>
            </div>
            <div class="col-lg-3 col-6 wow fadeInUp">
                <div class="feathure-grid">
                    <div class="icon-wrap"><img class="img-fluid"
                                                src="{{ asset('assets/images/landing/feathure/2.png') }}"
                                                alt=""></div>
                    <h5>{{__('CSS 3')}}</h5>
                </div>
            </div>
            <div class="col-lg-3 col-6 wow fadeInUp">
                <div class="feathure-grid">
                    <div class="icon-wrap"><img class="img-fluid"
                                                src="{{ asset('assets/images/landing/feathure/3.png') }}"
                                                alt=""></div>
                    <h5>{{__('SCSS')}}</h5>
                </div>
            </div>
            <div class="col-lg-3 col-6 wow fadeInUp">
                <div class="feathure-grid">
                    <div class="icon-wrap"><img class="img-fluid"
                                                src="{{ asset('assets/images/landing/feathure/4.png') }}"
                                                alt=""></div>
                    <h5>{{__('Bootstrap')}}</h5>
                </div>
            </div>
            <div class="col-lg-3 col-6 wow fadeInUp">
                <div class="feathure-grid">
                    <div class="icon-wrap"><img class="img-fluid"
                                                src="{{ asset('assets/images/landing/feathure/tailwind.png') }}"
                                                alt=""></div>
                    <h5>{{__('tailwind')}}</h5>
                </div>
            </div>
            <div class="col-lg-3 col-6 wow fadeInUp">
                <div class="feathure-grid">
                    <div class="icon-wrap"><img class="img-fluid"
                                                src="{{ asset('assets/images/landing/feathure/5.png') }}"
                                                alt=""></div>
                    <h5>{{__('Google Font')}}</h5>
                </div>
            </div>
            <div class="col-lg-3 col-6 wow fadeInUp">
                <div class="feathure-grid">
                    <div class="icon-wrap"><img class="img-fluid"
                                                src="{{ asset('assets/images/landing/feathure/6.png') }}"
                                                alt=""></div>
                    <h5>{{__('Dark Mode')}}</h5>
                </div>
            </div>
            <div class="col-lg-3 col-6 wow fadeInUp">
                <div class="feathure-grid">
                    <div class="icon-wrap"><img class="img-fluid"
                                                src="{{ asset('assets/images/landing/feathure/7.png') }}"
                                                alt=""></div>
                    <h5>{{__('Fully Responsive')}}</h5>
                </div>
            </div>
            <div class="col-lg-3 col-6 wow fadeInUp">
                <div class="feathure-grid">
                    <div class="icon-wrap"><img class="img-fluid"
                                                src="{{ asset('assets/images/landing/feathure/8.png') }}"
                                                alt=""></div>
                    <h5>{{__('Clean Code')}}</h5>
                </div>
            </div>
            <div class="col-lg-3 col-6 wow fadeInUp">
                <div class="feathure-grid">
                    <div class="icon-wrap"><img class="img-fluid"
                                                src="{{ asset('assets/images/landing/feathure/9.png') }}"
                                                alt=""></div>
                    <h5>{{__('Free Updates')}}</h5>
                </div>
            </div>
            <div class="col-lg-3 col-6 wow fadeInUp">
                <div class="feathure-grid">
                    <div class="icon-wrap"><img class="img-fluid"
                                                src="{{ asset('assets/images/landing/feathure/10.png') }}"
                                                alt=""></div>
                    <h5>{{__('Forms')}}</h5>
                </div>
            </div>
            <div class="col-lg-3 col-6 wow fadeInUp">
                <div class="feathure-grid">
                    <div class="icon-wrap"><img class="img-fluid"
                                                src="{{ asset('assets/images/landing/feathure/11.png') }}"
                                                alt=""></div>
                    <h5>{{__('Easy To Customize')}}</h5>
                </div>
            </div>
            <div class="col-lg-3 col-6 wow fadeInUp">
                <div class="feathure-grid">
                    <div class="icon-wrap"><img class="img-fluid"
                                                src="{{ asset('assets/images/landing/feathure/12.png') }}"
                                                alt=""></div>
                    <h5>{{__('Gulp')}}</h5>
                </div>
            </div>
            <div class="col-lg-3 col-6 wow fadeInUp">
                <div class="feathure-grid">
                    <div class="icon-wrap"><img class="img-fluid"
                                                src="{{ asset('assets/images/landing/feathure/13.png') }}"
                                                alt=""></div>
                    <h5>{{__('jQuery')}}</h5>
                </div>
            </div>
            <div class="col-lg-3 col-6 wow fadeInUp">
                <div class="feathure-grid">
                    <div class="icon-wrap"><img class="img-fluid"
                                                src="{{ asset('assets/images/landing/feathure/14.png') }}"
                                                alt=""></div>
                    <h5>{{__('Well Documented')}}</h5>
                </div>
            </div>
            <div class="col-lg-3 col-6 wow fadeInUp">
                <div class="feathure-grid">
                    <div class="icon-wrap"><img class="img-fluid"
                                                src="{{ asset('assets/images/landing/feathure/15.png') }}"
                                                alt=""></div>
                    <h5>{{__('W3 Validated')}}</h5>
                </div>
            </div>
            <div class="col-lg-3 col-6 wow fadeInUp">
                <div class="feathure-grid">
                    <div class="icon-wrap"><img class="img-fluid"
                                                src="{{ asset('assets/images/landing/feathure/16.png') }}"
                                                alt=""></div>
                    <h5>{{__('High Performance')}}</h5>
                </div>
            </div>
            <div class="col-lg-3 col-6 wow fadeInUp">
                <div class="feathure-grid">
                    <div class="icon-wrap"><img class="img-fluid"
                                                src="{{ asset('assets/images/landing/feathure/17.png') }}"
                                                alt=""></div>
                    <h5>{{__('Browser Compatibility')}}</h5>
                </div>
            </div>
            <div class="col-lg-3 col-6 wow fadeInUp">
                <div class="feathure-grid">
                    <div class="icon-wrap"><img class="img-fluid"
                                                src="{{ asset('assets/images/landing/feathure/18.png') }}"
                                                alt=""></div>
                    <h5>{{__('Great Support')}}</h5>
                </div>
            </div>
            <div class="col-lg-3 col-6 wow fadeInUp">
                <div class="feathure-grid">
                    <div class="icon-wrap"><img class="img-fluid"
                                                src="{{ asset('assets/images/landing/feathure/19.png') }}"
                                                alt=""></div>
                    <h5>{{__('Password Show/Hide')}}</h5>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- feathure end-->
<!-- footer start-->
<footer class="lan-footer space-py-10">
    <div class="container">
        <div class="row">
            <div class="col-auto">
                <div class="support-contain">
                    <div class="codex-brand">
                        <a href="javascript:void(0);">
                            <img class="img-fluid wow fadeInUp landing-logo"src="{{ asset('assets/images/logo/dark-logo.png') }}" alt="">
                        </a>
                    </div>
                </div>
            </div>
            <div class="col text-end">
                <div class="support-contain">
                    <div class="codex-brand">
                        <p class="mt-20">{{__('Copyright')}} {{date('Y')}} {{env('APP_NAME')}}</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</footer>
<!-- footer end-->
<!-- tap to top start-->
<div class="scroll-top"><i class="fa fa-angle-double-up"></i></div>
<!-- tap to top end-->
<!-- main jquery-->
<script src="{{ asset('assets/js/jquery.js') }}"></script>
<!-- Feather iocns js-->
<script src="{{ asset('assets/js/icons/feather-icon/feather.js') }}"></script>
<!-- Wow js-->
<script src="{{ asset('assets/js/vendors/wow.min.js') }}"></script>
<!-- Bootstrap js-->
<script src="{{ asset('assets/js/bootstrap.bundle.js') }}"></script>
<script>
    //*** Header Js ***//
    $(window).scroll(function () {
        if ($(window).scrollTop() > 100) {
            $('header').addClass('sticky');
        } else {
            $('header').removeClass('sticky');
        }
    });

    //*** Menu Js ***//
    $(document).on("click", '.menu-action', function () {
        $('.menu-list').toggleClass('open');
    });
    $(document).on("click", '.close-menu', function () {
        $('.menu-list').removeClass('open');
    });

    //*** BACK TO TOP START ***//
    $(window).scroll(function () {
        if ($(window).scrollTop() > 450) {
            $('.scroll-top').addClass('show');
        } else {
            $('.scroll-top').removeClass('show');
        }
    });
    $(document).ready(function () {
        $(document).on("click", '.scroll-top', function () {
            $('html, body').animate({scrollTop: 0}, '450');
        });
    });

    //*** WOW Js ***//
    new WOW().init();
</script>
</body>
</html>
