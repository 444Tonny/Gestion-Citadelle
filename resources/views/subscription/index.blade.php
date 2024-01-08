@extends('layouts.app')
@section('page-title')
    {{__('Packages')}}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard')}}"><h1>{{__('Dashboard')}}</h1></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">{{__('Packages')}}</a>
        </li>
    </ul>
@endsection
@section('card-action-btn')
    @if(\Auth::user()->type=='super admin' &&  (env('STRIPE_PAYMENT') == 'on' ))
        <a class="btn btn-primary btn-sm ml-20 customModal" href="#" data-size="md"
           data-url="{{ route('subscriptions.create') }}"
           data-title="{{__('Create Package')}}"> <i class="ti-plus mr-5"></i>{{__('Create Package')}}</a>
    @endif
@endsection
@section('content')
    <div class="row pricing-grid">
        @foreach($subscriptions as $subscription)
            <div class="col-xxl-3 cdx-xl-50 col-sm-6">
                <div class="codex-pricingtbl">
                    <div class="price-header">
                        <h2>{{$subscription->name}}</h2>
                        <div class="price-value">{{env('CURRENCY_SYMBOL').$subscription->price}}
                            <span>/ {{$subscription->duration}}</span></div>
                    </div>
                    <ul class="cdxprice-list">
                        <li><span>{{$subscription->total_user}}</span>{{__('Users Limit')}}</li>
                        <li><span>{{$subscription->total_property}}</span>{{__('Property Limit')}}</li>
                        <li><span>{{$subscription->total_tenant}}</span>{{__('Tenant Limit')}}</li>
                        @if(\Auth::user()->type!='super admin' && \Auth::user()->subscription == $subscription->id)
                        <li>
                            <span>{{\Auth::user()->subscription_expire_date ? \Auth::user()->dateFormat(\Auth::user()->subscription_expire_date):__('Unlimited')}}</span>{{__('Expiry Date') }}
                        </li>
                            @endif
                    </ul>
                    @if(\Auth::user()->type=='admin' && \Auth::user()->subscription == $subscription->id)
                        <a href="#" class="badge badge-success">{{__('Active')}}</a>
                    @endif
                    @if(\Auth::user()->type=='admin' && \Auth::user()->subscription != $subscription->id)
                        <a class="text-success" data-bs-toggle="tooltip" data-bs-original-title="{{__('Detail')}}"
                           href="{{route('subscriptions.show',\Illuminate\Support\Facades\Crypt::encrypt($subscription->id))}}"><i data-feather="shopping-cart"></i></a>
                    @endif
                    @if(\Auth::user()->type=='super admin')
                        {!! Form::open(['method' => 'DELETE', 'route' => ['subscriptions.destroy', $subscription->id]]) !!}
                        <div class="date-info">
                            <a class="text-success customModal" data-bs-toggle="tooltip"
                               data-bs-original-title="{{__('Edit')}}" href="#"
                               data-url="{{ route('subscriptions.edit',$subscription->id) }}"
                               data-title="{{__('Edit Package')}}"> <i data-feather="edit"></i></a>
                            <a class=" text-danger confirm_dialog" data-bs-toggle="tooltip"
                               data-bs-original-title="{{__('Detete')}}" href="#"> <i data-feather="trash-2"></i></a>
                        </div>
                        {!! Form::close() !!}
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endsection

