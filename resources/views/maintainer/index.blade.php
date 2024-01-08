@extends('layouts.app')
@section('page-title')
    {{__('Maintainer')}}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard')}}"><h1>{{__('Dashboard')}}</h1></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">{{__('Maintainer')}}</a>
        </li>
    </ul>
@endsection
@section('card-action-btn')
    @can('create maintainer')
        <a class="btn btn-primary btn-sm ml-20 customModal" href="#" data-size="lg"
           data-url="{{ route('maintainer.create') }}"
           data-title="{{__('Create Maintainer')}}"> <i class="ti-plus mr-5"></i>{{__('Create Maintainer')}}</a>
    @endcan
@endsection
@section('content')
    <div class="row">
        @foreach($maintainers as $maintainer)
            <div class="col-xl-3 col-md-6 cdx-xxl-50 cdx-xl-50 ">
                <div class="card custom contact-card">
                    <div class="card-body">
                        <div class="media align-items-center">
                            <div class="user-imgwrapper">
                                <img class="img-fluid rounded-50"
                                     src="{{(!empty($maintainer->user) && !empty($maintainer->user->profile))? asset(Storage::url("upload/profile/".$maintainer->user->profile)): asset(Storage::url("upload/profile/avatar.png"))}}"
                                     alt="">
                            </div>
                            <div class="media-body">
                                <a class="customModal" href="#" data-size="md"
                                   data-url="{{ route('maintainer.edit',$maintainer->id) }}"  data-title="{{__('Edit Maintainer')}}">
                                    <h4>{{!empty($maintainer->user)?ucfirst($maintainer->user->first_name.' '.$maintainer->user->last_name):'-'}}</h4>
                                    <h6 class="text-light">{{!empty($maintainer->user)?$maintainer->user->email:'-'}}</h6>
                                </a>
                            </div>
                            @if(Gate::check('edit maintainer') || Gate::check('delete maintainer') || Gate::check('show maintainer'))
                                <div class="user-setting">
                                    <div class="action-menu">
                                        <div class="action-toggle"><i data-feather="more-vertical"></i></div>
                                        <ul class="action-dropdown">
                                            @can('edit maintainer')
                                                <li>
                                                    <a class="customModal" href="#" data-size="lg"
                                                       data-url="{{ route('maintainer.edit',$maintainer->id) }}"
                                                       data-title="{{__('Edit Maintainer')}}"> <i
                                                            data-feather="edit"> </i>{{__('Edit Maintainer')}}</a>
                                                </li>
                                            @endcan
                                            @can('delete maintainer')
                                                <li>
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['maintainer.destroy', $maintainer->id],'id'=>'tenant-'.$maintainer->id]) !!}
                                                    <a href="#" class="confirm_dialog"> <i
                                                            data-feather="trash"></i>{{__('Delete Maintainer')}}</a>
                                                    {!! Form::close() !!}
                                                </li>
                                            @endcan

                                        </ul>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="user-detail">
                            <h5 class="text-primary mb-10"><i class="fa fa-info-circle mr-10"></i>{{__('Infomation')}}
                            </h5>
                            <ul class="info-list">
                                <li><span>{{__('Phone')}} : </span>{{!empty($maintainer->phone_number)?$maintainer->user->phone_number:'-'}} </li>

                                <li>
                                    <span>{{__('Type')}} : </span>{{!empty($maintainer->types)?$maintainer->types->title:'-'}}
                                </li>
                                <li>
                                    <span>{{__('Created Date')}} : </span>{{\Auth::user()->dateFormat($maintainer->created_at)}}
                                </li>
                                <li>
                                    <span>{{__('Property')}} : </span><br>
                                    @foreach($maintainer->properties() as $property)
                                        {{$property->name}}<br>
                                    @endforeach

                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

