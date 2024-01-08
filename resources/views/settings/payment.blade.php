@extends('layouts.app')
@section('page-title')
    {{__('Payment Settings')}}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard')}}"><h1>{{__('Dashboard')}}</h1></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">{{__('Payment Settings')}}</a>
        </li>
    </ul>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{Form::model($loginUser, array('route' => array('setting.payment'), 'method' => 'post')) }}
                    <div class="row">
                        <div class="form-group col-md-6">
                            {{Form::label('currency',__('Currency'),array('class'=>'form-label')) }}
                            {{Form::text('currency',env('CURRENCY'),array('class'=>'form-control font-style','placeholder'=>__('Enter currency'),'required'))}}
                        </div>
                        <div class="form-group col-md-6">
                            {{Form::label('currency_symbol',__('Currency Symbol'),array('class'=>'form-label')) }}
                            {{Form::text('currency_symbol',env('CURRENCY_SYMBOL'),array('class'=>'form-control','placeholder'=>__('Enter currency symbol'),'required'))}}
                        </div>

                    </div>

                    <div class="row mt-2">
                        <div class="col-auto">
                            {{Form::label('stripe_payment',__('Stripe Payment'),array('class'=>'form-label')) }}
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-check custom-chek">
                                    <input class="form-check-input" type="checkbox" name="stripe_payment" id="stripe_payment" {{ env('STRIPE_PAYMENT') == 'on' ? 'checked' : '' }}>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            {{Form::label('stripe_key',__('Stripe Key'),array('class'=>'form-label')) }}
                            {{Form::text('stripe_key',env('STRIPE_KEY'),['class'=>'form-control','placeholder'=>__('Enter stripe key')])}}
                        </div>
                        <div class="form-group col-md-6">
                            {{Form::label('stripe_secret',__('Stripe Secret'),array('class'=>'form-label')) }}
                            {{Form::text('stripe_secret',env('STRIPE_SECRET'),['class'=>'form-control ','placeholder'=>__('Enter stripe secret')])}}
                        </div>
                    </div>
                    <div class="text-right">
                        {{Form::submit(__('Save'),array('class'=>'btn btn-primary btn-rounded'))}}
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection

