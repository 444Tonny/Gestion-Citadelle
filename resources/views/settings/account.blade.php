@extends('layouts.app')
@section('page-title')
    {{__('Account Settings')}}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard')}}"><h1>{{__('Dashboard')}}</h1></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">{{__('Account Settings')}}</a>
        </li>
    </ul>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-3 cdx-xxl-30 cdx-xl-40">
            <div class="row">
                <div class="col-xl-12 col-md-6">
                    <div class="card user-card">
                        <div class="card-header">

                        </div>
                        <div class="card-body">
                            <div class="user-imgwrap">
                                <img class="img-fluid rounded-50" src="{{(!empty($loginUser->profile)? asset(Storage::url('upload/profile/')).'/'.$loginUser->profile : asset(Storage::url('upload/profile')).'/avatar.png')}}" alt="4.jpg">
                            </div>
                            <div class="user-detailwrap">
                                <h3>{{$loginUser->name}}</h3>
                                <h6>{{ucfirst($loginUser->type)}}</h6>
                                <h6 class="mt-5">{{$loginUser->email}}</h6>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-xl-9 cdx-xxl-70 cdx-xl-60">
            <div class="card">
                <div class="card-body">
                    <div class="info-group">
                        {{Form::model($loginUser, array('route' => array('setting.account'), 'method' => 'post', 'enctype' => "multipart/form-data")) }}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{Form::label('first_name',__('First Name'),array('class'=>'form-label'))}}
                                    {{Form::text('first_name',null,array('class'=>'form-control','placeholder'=>__('Enter your first name'),'required'=>'required'))}}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{Form::label('last_name',__('Last Name'),array('class'=>'form-label'))}}
                                    {{Form::text('last_name',null,array('class'=>'form-control','placeholder'=>__('Enter your last name')))}}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{Form::label('email',__('Email Address'),array('class'=>'form-label'))}}
                                    {{Form::text('email',null,array('class'=>'form-control','placeholder'=>__('Enter your email'),'required'=>'required'))}}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{Form::label('profile',__('Profile'),array('class'=>'form-label'))}}
                                    {{Form::file('profile',array('class'=>'form-control'))}}
                                </div>
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
    </div>
@endsection

