@extends('layouts.app')
@section('page-title')
    {{__('Contact')}}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard')}}"><h1>{{__('Dashboard')}}</h1></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">{{__('Contact')}}</a>
        </li>
    </ul>
@endsection
@section('card-action-btn')
    @if(Gate::check('manage contact') || \Auth::user()->type=='super admin')
        <a class="btn btn-primary btn-sm ml-20 customModal" href="#" data-size="md"
           data-url="{{ route('contact.create') }}"
           data-title="{{__('Create Contact')}}"> <i class="ti-plus mr-5"></i>{{__('Create Contact')}}</a>
    @endif
@endsection
@section('content')
    <div class="row">
        @foreach($contacts as $contact)
            <div class="col-xl-4 col-md-6 cdx-xxl-50 cdx-xl-50">
                <div class="card contact-card">
                    <div class="card-body">
                        <div class="media align-items-center">
                            <div class="media-body">
                                <h4>{{$contact->name}}  </h4>
                                <h6 class="text-light">{{$contact->email}}</h6>
                            </div>
                            @if(Gate::check('edit contact') || Gate::check('delete contact') || \Auth::user()->type=='super admin')
                                <div class="user-setting">
                                    <div class="action-menu">
                                        <div class="action-toggle"><i data-feather="more-vertical"></i></div>
                                        <ul class="action-dropdown">
                                            @if(Gate::check('edit contact') || \Auth::user()->type=='super admin')
                                                <li><a class="customModal"
                                                       data-url="{{ route('contact.edit',$contact->id) }}"
                                                       data-title="{{__('Edit Contact')}}"> <i
                                                            data-feather="edit"> </i>{{__('Edit Contact')}}</a></li>
                                            @endif
                                            @if(Gate::check('edit contact') || \Auth::user()->type=='super admin')
                                                <li>
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['contact.destroy', $contact->id],'id'=>'user-'.$contact->id]) !!}
                                                    <a href="#" class="confirm_dialog"> <i
                                                            data-feather="trash"></i>{{__('Delete Contact')}}</a>
                                                    {!! Form::close() !!}
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="user-detail">
                            <h5 class="text-primary mb-10">{{$contact->subject}}</h5>

                            <ul class="info-list">
                                <li><span>{{__('Contact Number')}}  :- </span>{{$contact->contact_number}} </li>
                                <li>
                                    <span>{{__('Created Date')}} :- </span>{{\Auth::user()->dateFormat($contact->created_at)}}
                                </li>

                            </ul>
                            <div class="user-action">
                                <p class="text-light"> {{$contact->message}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

