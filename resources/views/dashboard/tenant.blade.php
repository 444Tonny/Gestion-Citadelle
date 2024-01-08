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

@endpush
@php
$settings=\App\Models\Custom::settings();
@endphp
@section('content')
    <div class="row">
        <div class="col-xxl-3 col-sm-6 cdx-xxl-50">
            <div class="card sale-revenue">
                <div class="card-header">
                    <h4>{{__('Property')}}</h4>
                </div>
                <div class="card-body progressCounter">
                    <h2>
                        <span class="">{{!empty($tenant->properties)?$tenant->properties->name:'-'}}</span>
                    </h2>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-sm-6 cdx-xxl-50">
            <div class="card sale-revenue">
                <div class="card-header">
                    <h4>{{__('Unit')}}</h4>
                </div>
                <div class="card-body progressCounter">
                    <h2>
                        <span class="">{{!empty($tenant->units)?$tenant->units->name:'-'}}</span>
                    </h2>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-sm-6 cdx-xxl-50">
            <div class="card sale-revenue">
                <div class="card-header">
                    <h4>{{__('Rent')}}</h4>
                </div>
                <div class="card-body progressCounter">
                    <h2>
                        <span class="">{{$settings['company_currency_symbol']}}{{!empty($data['unit'])?$data['unit']->rent:'-'}}</span>
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
                    <h2>
                        <span class="count">{{$data['totalInvoice']}}</span>
                    </h2>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-sm-6 cdx-xxl-50">
            <div class="card sale-revenue">
                <div class="card-header">
                    <h4>{{__('Total Contact')}}</h4>
                </div>
                <div class="card-body progressCounter">
                    <h2>
                        <span class="count">{{$data['totalContact']}}</span>
                    </h2>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-sm-6 cdx-xxl-50">
            <div class="card sale-revenue">
                <div class="card-header">
                    <h4>{{__('Total Support')}}</h4>
                </div>
                <div class="card-body progressCounter">
                    <h2><span class="count">{{$data['totalSupport']}}</span> </h2>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-sm-6 cdx-xxl-50">
            <div class="card sale-revenue">
                <div class="card-header">
                    <h4>{{__('Today Support')}}</h4>
                </div>
                <div class="card-body progressCounter">
                    <h2><span class="count">{{$data['todaySupport']}}</span> </h2>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-sm-6 cdx-xxl-50">
            <div class="card sale-revenue">
                <div class="card-header">
                    <h4>{{__('Total Notes')}}</h4>
                </div>
                <div class="card-body progressCounter">
                    <h2><span class="count">{{$data['totalNote']}}</span> </h2>
                </div>
            </div>
        </div>
    </div>

@endsection
