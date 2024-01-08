@extends('layouts.app')
@section('page-title')
    {{__('Tenant Details')}}
@endsection
@section('page-class')
    cdxuser-profile
@endsection
@push('script-page')
@endpush
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard')}}"><h1>{{__('Dashboard')}}</h1></a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{route('tenant.index')}}">{{__('Tenant')}}</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">{{__('Details')}}</a>
        </li>
    </ul>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-3 cdx-xxl-30 cdx-xl-40">
            <div class="row">
                <div class="col-xl-12 col-md-6">
                    <div class="card user-card">
                        <div class="card-header"></div>
                        <div class="card-body">
                            <div class="user-imgwrap">
                                <img class="img-fluid rounded-50"
                                     src="{{(!empty($tenant->user) && !empty($tenant->user->profile))? asset(Storage::url("upload/profile/".$tenant->user->profile)): asset(Storage::url("upload/profile/avatar.png"))}}"
                                     alt="">
                            </div>
                            <div class="user-detailwrap">
                                <h3>{{ucfirst(!empty($tenant->user)?$tenant->user->first_name:'').' '.ucfirst(!empty($tenant->user)?$tenant->user->last_name:'')}}</h3>
                                <h6>{{!empty($tenant->user)?$tenant->user->email:'-'}}</h6>
                                <h6>{{!empty($tenant->user)?$tenant->user->phone_number:'-'}} </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-9 cdx-xxl-70 cdx-xl-60">
            <div class="row">
                <div class="col-12">
                    <div class="card support-inboxtbl">
                        <div class="card-header">
                            <h4>{{__('Additional Information')}}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 col-lg-3 mb-20">
                                    <div class="media">
                                        <div class="media-body">
                                            <h6>{{__('Total Family Member')}}</h6>
                                            <p class="text-light">{{$tenant->family_member}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-lg-3 mb-20">
                                    <div class="media">
                                        <div class="media-body">
                                            <h6>{{__('Country')}}</h6>
                                            <p class="text-light">{{$tenant->country}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-lg-3 mb-20">
                                    <div class="media">
                                        <div class="media-body">
                                            <h6>{{__('State')}}</h6>
                                            <p class="text-light">{{$tenant->state}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-lg-3 mb-20">
                                    <div class="media">
                                        <div class="media-body">
                                            <h6>{{__('City')}}</h6>
                                            <p class="text-light">{{$tenant->city}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-lg-3 mb-20">
                                    <div class="media">
                                        <div class="media-body">
                                            <h6>{{__('Zip Code')}}</h6>
                                            <p class="text-light">{{$tenant->zip_code}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-lg-3 mb-20">
                                    <div class="media">
                                        <div class="media-body">
                                            <h6>{{__('Property')}}</h6>
                                            <p class="text-light">{{!empty($tenant->properties)?$tenant->properties->name:'-'}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-lg-3 mb-20">
                                    <div class="media">
                                        <div class="media-body">
                                            <h6>{{__('Unit')}}</h6>
                                            <p class="text-light">{{!empty($tenant->units)?$tenant->units->name:'-'}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-lg-3 mb-20">
                                    <div class="media">
                                        <div class="media-body">
                                            <h6>{{__('Lease Start Date')}}</h6>
                                            <p class="text-light">{{\Auth::user()->dateFormat($tenant->lease_start_date)}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-lg-3 mb-20">
                                    <div class="media">
                                        <div class="media-body">
                                            <h6>{{__('Lease Start Date')}}</h6>
                                            <p class="text-light">{{\Auth::user()->dateFormat($tenant->lease_end_date)}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-20">
                                    <div class="media">
                                        <div class="media-body">
                                            <h6>{{__('Address')}}</h6>
                                            <p class="text-light">{{$tenant->address}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

