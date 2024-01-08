@extends('layouts.app')
@php
    $profile=asset(Storage::url('upload/profile/'));
@endphp
@section('page-title')
    @if(\Auth::user()->type=='super admin')
        {{__('Owners')}}
    @else
        {{__('Users')}}
    @endif

@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard')}}"><h1>{{__('Dashboard')}}</h1></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">
                @if(\Auth::user()->type=='super admin')
                    {{__('Owners')}}
                @else
                    {{__('Users')}}
                @endif

            </a>
        </li>
    </ul>
@endsection
@section('card-action-btn')
    @if(Gate::check('manage user') || \Auth::user()->type=='super admin')
        <a class="btn btn-primary btn-sm ml-20 customModal" href="#" data-size="md"
           data-url="{{ route('users.create') }}"
           data-title="{{(\Auth::user()->type=='super admin')?__('Create Owner'):__('Create User')}}"> <i
                class="ti-plus mr-5"></i>
            @if(\Auth::user()->type=='super admin')
                {{__('Create Owner')}}
            @else
                {{__('Create User')}}
            @endif
        </a>
    @endif
@endsection
@section('content')
    <div class="row">
        @if(\Auth::user()->type=='super admin')
            @foreach($users as $user)
                <div class="col-xl-3 col-lg-4 col-sm-6 cdx-xxl-33 cdx-xl-33">
                    <div class="card user-card">
                        <div class="card-header">
                            <div class="user-setting">
                                <div class="action-menu">
                                    <div class="action-toggle"><i data-feather="more-vertical"> </i></div>
                                    <ul class="action-dropdown">
                                        <li><a href="#" class="customModal"
                                               data-url="{{ route('users.edit',$user->id) }}"
                                               data-title="{{__('Edit User')}}"> <i
                                                    data-feather="edit"></i>{{__('Edit User')}}</a></li>
                                        <li>
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id]]) !!}
                                            <a href="#" class="confirm_dialog"> <i
                                                    data-feather="trash"></i>{{__('Delete User')}}</a>
                                            {!! Form::close() !!}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="user-imgwrap">
                                <img class="img-fluid rounded-50"
                                     src="{{(!empty($user->avatar))? asset(Storage::url("upload/profile/".$user->avatar)): asset(Storage::url("upload/profile/avatar.png"))}}"
                                     alt="{{$user->name}}"></div>
                            <div class="user-detailwrap">
                                <h3>{{$user->name}}</h3>
                                <h6>{{$user->type}}</h6>
                                <p> {{$user->email}}</p>
                                <p class="mt-5"> {{__('Subscription Expired : ') }} {{!empty($user->plan_expire_date) ? \Auth::user()->dateFormat($user->plan_expire_date): __('Unlimited')}}</p>
                                <div class="group-btn">
                                    <span
                                        class="btn btn-primary btn-md"> {{__('Users')}} : {{$user->totalUser()}}</span>
                                    <span
                                        class="btn btn-secondary btn-md"> {{__('Property')}} : {{$user->totalProperty()}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="display dataTable cell-border datatbl-advance">
                            <thead>
                            <tr>
                                <th>{{__('User')}}</th>
                                <th>{{__('Email')}}</th>
                                <th>{{__('Phone Number')}}</th>
                                <th>{{__('Role')}}</th>
                                <th>{{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td class="table-user">
                                        <img
                                            src="{{!empty($user->avatar)?asset(Storage::url('upload/profile')).'/'.$user->avatar:asset(Storage::url('upload/profile')).'/avatar.png'}}"
                                            alt="" class="mr-2 avatar-sm rounded-circle user-avatar">
                                        <a href="#"
                                           class="text-body font-weight-semibold">{{ $user->first_name.' '.$user->last_name }}</a>
                                    </td>
                                    <td>{{ $user->email }} </td>
                                    <td>{{ !empty($user->phone_number)?$user->phone_number:'-' }} </td>
                                    <td>{{ ucfirst($user->type) }} </td>
                                    <td>
                                        <div class="cart-action">
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id]]) !!}

                                            @can('edit user')
                                                <a class="text-success customModal" data-bs-toggle="tooltip"
                                                   data-bs-original-title="{{__('Edit')}}" href="#"
                                                   data-url="{{ route('users.edit',$user->id) }}"
                                                   data-title="{{__('Edit Support')}}"> <i data-feather="edit"></i></a>
                                            @endcan

                                            @can('delete user')
                                                <a class=" text-danger confirm_dialog" data-bs-toggle="tooltip"
                                                   data-bs-original-title="{{__('Detete')}}" href="#"> <i
                                                        data-feather="trash-2"></i></a>
                                            @endcan

                                            {!! Form::close() !!}
                                        </div>

                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
