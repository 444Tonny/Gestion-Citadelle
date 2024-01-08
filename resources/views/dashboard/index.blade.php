@extends('layouts.app')
@section('page-title')
    {{__('Dashboard')}}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard')}}"><h1>{{__('Dashboard')}}</h1></a>
        </li>

    </ul>
@endsection

@push('script-page')
    <script>
        var options = {

            series: [{
                name: "{{__('Income')}}",
                type: 'column',
                data: {!! json_encode($data['incomeExpenseByMonth']['income']) !!},
            }, {
                name: " {{__('Expense')}}",
                type: 'area',
                data: {!! json_encode($data['incomeExpenseByMonth']['expense']) !!},
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
            colors: [Codexdmeki.themeprimary,Codexdmeki.themesecondary],
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
                tickAmount: 10 ,
                labels:{
                    formatter: function (y) {
                        return  "{{$data['settings']['company_currency_symbol']}}" + y.toFixed(0);
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
                categories: {!! json_encode($data['incomeExpenseByMonth']['label']) !!} ,
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
        var chart = new ApexCharts(document.querySelector("#incomeExpense"), options);
        chart.render();
    </script>
@endpush
@php
$settings=\App\Models\Custom::settings();
@endphp
@section('content')
    <div class="row">
        <div class="col-xxl-3 col-sm-6 cdx-xxl-50">
            <div class="card sale-revenue">
                <div class="card-header">
                    <h4>{{__('Total Property')}}</h4>
                </div>
                <div class="card-body progressCounter">
                    <h2>
                        <span class="count">{{$data['totalProperty']}}</span>
                    </h2>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-sm-6 cdx-xxl-50">
            <div class="card sale-revenue">
                <div class="card-header">
                    <h4>{{__('Total Unit')}}</h4>
                </div>
                <div class="card-body progressCounter">
                    <h2>
                        <span class="count">{{$data['totalUnit']}}</span>
                    </h2>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-sm-6 cdx-xxl-50">
            <div class="card sale-revenue">
                <div class="card-header">
                    <h4>{{__('Total Invoice')}}</h4>
                </div>
                <div class="card-body progressCounter">
                    <h2>{{$settings['company_currency_symbol']}}<span class="count">{{$data['totalIncome']}}</span> </h2>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-sm-6 cdx-xxl-50">
            <div class="card sale-revenue">
                <div class="card-header">
                    <h4>{{__('Total Expense')}}</h4>
                </div>
                <div class="card-body progressCounter">
                    <h2>{{$settings['company_currency_symbol']}}<span class="count">{{$data['totalExpense']}}</span> </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xxl-12 cdx-xxl-50">
            <div class="card overall-revenuetbl">
                <div class="card-header">
                    <h4>{{__('Income Vs Expense')}}</h4>

                </div>
                <div class="card-body">
                    <div id="incomeExpense"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
