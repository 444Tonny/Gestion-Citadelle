
<!-- footer start-->
<footer class="codex-footer">
    <p>{{__('Copyright')}} {{date('Y')}} © {{env('APP_NAME')}} {{__('All rights reserved')}}.</p>
</footer>
<!-- footer end-->
<!-- back to top start //-->
<div class="scroll-top"><i class="fa fa-angle-double-up"></i></div>
<!-- back to top end //-->
<!-- main jquery-->
<script src="{{ asset('assets/js/jquery.js') }}"></script>
<!-- Theme Customizer-->
<script src="{{ asset('assets/js/layout-storage.js') }}"></script>
@if(\Auth::user()->type=='admin' || \Auth::user()->type=='super admin')
<script>
$(".customizer-modal").append('' +
'<form method="post" action="{{route("theme.settings")}}">{{csrf_field()}}<div class="customizer-layer"></div>' +
    '<div class="customizer-action bg-primary"><i data-feather="settings"></i>' +
        '</div><div class="theme-cutomizer"> ' +
        '<div class="customizer-header"> <h4>{{__('Theme Setting')}}</h4> ' +
            '<div class="close-customizer"><i data-feather="x"></i></div>' +
            '</div>' +
            '<input type="hidden" name="theme_color" id="theme_color" value="{{$settings['theme_color']}}">'+
            '<input type="hidden" name="sidebar_mode" id="sidebar_mode" value="{{$settings['sidebar_mode']}}">'+
            '<input type="hidden" name="layout_direction" id="layout_direction" value="{{$settings['layout_direction']}}">'+
            '<input type="hidden" name="layout_mode" id="layout_mode" value="{{$settings['layout_mode']}}">'+
        '<div class="customizer-body"> ' +
            '<div class="cutomize-group"> ' +
                '<h6 class="customizer-title">{{__('Theme Color')}}</h6> ' +
                '<ul class="customizeoption-list themecolor-list" > ' +
                    '<li class="color1 {{$settings['theme_color']=='color1'?'active-mode':''}}"></li>' +
                    '</ul> ' +
                '</div>' +
            '<div class="cutomize-group"> ' +
                '<h6 class="customizer-title">{{__('Sidebar Mode')}}</h6> ' +
                '<ul class="customizeoption-list sidebaroption-list"> ' +
                    '<li class="sidebarlight-action {{$settings['sidebar_mode']=='light'?'active-mode':''}}">{{__('Light')}}</li>' +
                    '<li class="sidebardark-action {{$settings['sidebar_mode']=='dark'?'active-mode':''}}">{{__('Dark')}}</li>' +
                    '</ul> ' +
                '</div>' +
            '<div class="cutomize-group"> ' +
                '<h6 class="customizer-title">{{__('Layout Direction')}}</h6> ' +
                '<ul class="customizeoption-list"> ' +
                    '<li class="ltr-action {{$settings['layout_direction']=='ltrmode'?'active-mode':''}}">{{__('LTR')}}</li>' +
                    '<li class="rtl-action {{$settings['layout_direction']=='rtlmode'?'active-mode':''}}">{{__('RTL')}}</li>' +
                    '</ul> ' +
                '</div>' +
            '<div class="cutomize-group mb-0"> ' +
                '<h6 class="customizer-title">{{__('Layout mode')}}</h6> ' +
                '<ul class="customizeoption-list"> ' +
                    '<li class="light-action {{$settings['layout_mode']=='lightmode'?'active-mode':''}}">{{__('Light')}}</li>' +
                    '<li class="dark-action {{$settings['layout_mode']=='darkmode'?'active-mode':''}}">{{__('Dark')}}</li>' +
                    '</ul> ' +
                '<button type="submit" class="btn btn-primary mt-20">{{__('Save')}}</button>'+
                '</div>' +
            '</div>' +
        '</div></form>' +
'');
</script>
@endif
<script src="{{ asset('assets/js/customizer.js') }}"></script>
<!-- Feather icons js-->
<script src="{{ asset('assets/js/icons/feather-icon/feather.js') }}"></script>
<!-- Bootstrap js-->
<script src="{{ asset('assets/js/bootstrap.bundle.js') }}"></script>
<!-- Scrollbar-->
<script src="{{ asset('assets/js/vendors/simplebar.js') }}"></script>
<!-- apex chart-->
<script src="{{ asset('assets/js/vendors/chart/apexcharts.js') }}"></script>


<script src="{{ asset('assets/js/vendors/select2/select2.js') }}"></script>

<script src="{{ asset('assets/js/vendors/sweetalert/sweetalert2.js') }}"></script>
<script src="{{ asset('assets/js/vendors/sweetalert/custom-sweetalert2.js') }}"></script>

<script src="{{ asset('assets/js/vendors/slider/slick-sldier/slick.js') }}"></script>
<script src="{{ asset('assets/js/vendors/slider/slick-sldier/slick-custom.js') }}"></script>
<!-- Datatable-->
<script src="{{ asset('assets/js/vendors/datatable/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/js/vendors/datatable/dataTables.buttons.js') }}"></script>
<script src="{{ asset('assets/js/vendors/datatable/buttons.print.js') }}"></script>
<script src="{{ asset('assets/js/vendors/datatable/jszip.js') }}"></script>
<script src="{{ asset('assets/js/vendors/datatable/pdfmake.js') }}"></script>
<script src="{{ asset('assets/js/vendors/datatable/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/js/vendors/datatable/buttons.html5.js') }}"></script>

<!-- Custom script-->

<script src="{{ asset('assets/js/vendors/notify/bootstrap-notify.js') }}"></script>

<script src="{{ asset('assets/js/custom-script.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
@if ($message = Session::get('success'))
    <script>
        toastrs('Success', '{!! $message !!}', 'success')
    </script>
@endif

@if ($message = Session::get('error'))
    <script>toastrs('Error', '{!! $message !!}', 'error')</script>
@endif

@if ($message = Session::get('info'))
    <script>toastrs('Info', '{!! $message !!}', 'info')</script>
@endif

@stack('script-page')
