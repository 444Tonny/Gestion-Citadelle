@extends('layouts.app')
@section('page-title')
    {{__('Dashboard')}}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard')}}"> <h1>{{__('Dashboard')}}</h1></a>
        </li>

    </ul>
@endsection
@push('script-page')
    <script>
        var options = {
            series: [{
                name: "{{__('Total Users')}}",
                type: 'column',
                data: {!! json_encode($data['organizationByMonth']['data']) !!},
            }],
            chart: {
                height: 452,
                type: 'line',
                toolbar:{
                    show: false
                },
                zoom: {
                    enabled: false
                }
            },
            legend:{
                show:false
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                width: [0,0],
                curve: 'smooth',
            },
            plotOptions: {
                bar: {
                    columnWidth:"20%",
                    startingShape:"rounded",
                    endingShape: "rounded",
                }
            },
            fill:{
                opacity:[1, 0.08],
                gradient:{
                    type:"horizontal",
                    opacityFrom:0.5,
                    opacityTo:0.1,
                    stops: [100, 100, 100]
                }
            },
            colors: [Codexdmeki.themeprimary],
            states: {
                normal: {
                    filter: {
                        type: 'darken',
                        value: 1,
                    }
                },
                hover: {
                    filter: {
                        type: 'darken',
                        value: 1,
                    }
                },
                active: {
                    allowMultipleDataPointsSelection: false,
                    filter: {
                        type: 'darken',
                        value: 1,
                    }
                },
            },
            grid:{
                strokeDashArray: 2,
            },

            yaxis:{

                labels:{
                    formatter: function (y) {
                        return   y.toFixed(0);
                    },
                    style: {
                        colors: '#262626',
                        fontSize: '14px',
                        fontWeight: 500,
                        fontFamily: 'Roboto, sans-serif'
                    }
                },
            },
            xaxis: {
                categories: {!! json_encode($data['organizationByMonth']['label']) !!},
                axisTicks: {
                    show:false
                },
                axisBorder:{
                    show:false
                },
                labels:{
                    style: {
                        colors: '#262626',
                        fontSize: '14px',
                        fontWeight: 500,
                        fontFamily: 'Roboto, sans-serif'
                    },
                },
            },
            responsive:[
                {
                    breakpoint: 1441,
                    options:{
                        chart:{
                            height: 445
                        }
                    },
                },
                {
                    breakpoint: 1366,
                    options:{
                        chart:{
                            height: 320
                        }
                    },
                },
            ]
        };
        var chart = new ApexCharts(document.querySelector("#organization_by_month"), options);
        chart.render();


        var options = {
            series: [{
                name: "{{__('Total Payment')}}",
                type: 'line',
                data: {!! json_encode($data['paymentByMonth']['data']) !!},
            }],
            chart: {
                height: 452,
                type: 'line',
                toolbar:{
                    show: false
                },
                zoom: {
                    enabled: false
                }
            },
            legend:{
                show:false
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                width: [0,0],
                curve: 'smooth',
            },
            plotOptions: {
                bar: {
                    columnWidth:"20%",
                    startingShape:"rounded",
                    endingShape: "rounded",
                }
            },
            fill:{
                opacity:[1, 0.08],
                gradient:{
                    type:"horizontal",
                    opacityFrom:0.5,
                    opacityTo:0.1,
                    stops: [100, 100, 100]
                }
            },
            colors: [Codexdmeki.themeprimary],
            states: {
                normal: {
                    filter: {
                        type: 'darken',
                        value: 1,
                    }
                },
                hover: {
                    filter: {
                        type: 'darken',
                        value: 1,
                    }
                },
                active: {
                    allowMultipleDataPointsSelection: false,
                    filter: {
                        type: 'darken',
                        value: 1,
                    }
                },
            },
            grid:{
                strokeDashArray: 2,
            },

            yaxis:{

                labels:{
                    formatter: function (y) {
                        return   y.toFixed(0);
                    },
                    style: {
                        colors: '#262626',
                        fontSize: '14px',
                        fontWeight: 500,
                        fontFamily: 'Roboto, sans-serif'
                    }
                },
            },
            xaxis: {
                categories: {!! json_encode($data['paymentByMonth']['label']) !!},
                axisTicks: {
                    show:false
                },
                axisBorder:{
                    show:false
                },
                labels:{
                    style: {
                        colors: '#262626',
                        fontSize: '14px',
                        fontWeight: 500,
                        fontFamily: 'Roboto, sans-serif'
                    },
                },
            },
            responsive:[
                {
                    breakpoint: 1441,
                    options:{
                        chart:{
                            height: 445
                        }
                    },
                },
                {
                    breakpoint: 1366,
                    options:{
                        chart:{
                            height: 320
                        }
                    },
                },
            ]
        };
        var chart = new ApexCharts(document.querySelector("#payments_by_month"), options);
        chart.render();


    </script>
@endpush
@section('content')
    <div class="row">
        <div class="col-xxl-3 col-sm-6 cdx-xxl-50">
            <div class="card sale-revenue">
                <div class="card-header">
                    <h4>{{__('Total Organization')}}</h4>
                </div>
                <div class="card-body progressCounter">
                    <h2>{{$data['totalOrganization']}}</h2>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-sm-6 cdx-xxl-50">
            <div class="card sale-revenue">
                <div class="card-header">
                    <h4>{{__('Total Subscription')}}</h4>
                </div>
                <div class="card-body progressCounter">
                    <h2>{{$data['totalSubscription']}}</h2>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-sm-6 cdx-xxl-50">
            <div class="card sale-revenue">
                <div class="card-header">
                    <h4>{{__('Total Transaction')}}</h4>
                </div>
                <div class="card-body progressCounter">
                    <h2>{{$data['totalTransaction']}}</h2>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-sm-6 cdx-xxl-50">
            <div class="card sale-revenue">
                <div class="card-header">
                    <h4>{{__('Total Income')}}</h4>
                </div>
                <div class="card-body progressCounter">
                    <h2>{{env('CURRENCY_SYMBOL').$data['totalIncome']}}</h2>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-sm-6 cdx-xxl-50">
            <div class="card sale-revenue">
                <div class="card-header">
                    <h4>{{__('Total Notes')}}</h4>
                </div>
                <div class="card-body progressCounter">
                    <h2>{{$data['totalNote']}}</h2>
                </div>
            </div>
        </div>

        <div class="col-xxl-3 col-sm-6 cdx-xxl-50">
            <div class="card sale-revenue">
                <div class="card-header">
                    <h4>{{__('Total Contact')}}</h4>
                </div>
                <div class="card-body progressCounter">
                    <h2>{{$data['totalContact']}}</h2>
                </div>
            </div>
        </div>

        <div class="col-xxl-3 col-sm-6 cdx-xxl-50">
            <div class="card sale-revenue">
                <div class="card-header">
                    <h4>{{__('Total Support')}}</h4>
                </div>
                <div class="card-body progressCounter">
                    <h2>{{$data['totalSupport']}}</h2>
                </div>
            </div>
        </div>

        <div class="col-xxl-3 col-sm-6 cdx-xxl-50">
            <div class="card sale-revenue">
                <div class="card-header">
                    <h4>{{__('Today Support')}}</h4>
                </div>
                <div class="card-body progressCounter">
                    <h2>{{$data['todaySupport']}}</h2>
                </div>
            </div>
        </div>

        <div class="col-xxl-12 cdx-xxl-50">
            <div class="card overall-revenuetbl">
                <div class="card-header">
                    <h4>{{__('Users By Month')}}</h4>
                </div>
                <div class="card-body">
                    <div id="organization_by_month"></div>
                </div>
            </div>
        </div>
        <div class="col-xxl-12 cdx-xxl-50">
            <div class="card overall-revenuetbl">
                <div class="card-header">
                    <h4>{{__('Payments By Month')}}</h4>
                </div>
                <div class="card-body">
                    <div id="payments_by_month"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
