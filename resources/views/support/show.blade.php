@extends('layouts.app')
@section('page-title')
    {{__('Support')}}
@endsection

@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard')}}"><h1>{{__('Dashboard')}}</h1></a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{route('support.index')}}">{{__('Support')}}</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">{{__('Details')}}</a>
        </li>
    </ul>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card blogdetail-wrrapper">

                <div class="detailwrapper">
                    <h4>{{$support->subject}}</h4>
                    <ul class="blogsoc-list">
                        <li><a href="#" data-bs-toggle="tooltip" data-bs-original-title="{{__('Created By')}}"><i data-feather="user"></i>{{ !empty($support->createdUser)?$support->createdUser->name:'-' }}</a></li>
                        <li><a href="#" data-bs-toggle="tooltip" data-bs-original-title="{{__('Assign User')}}"><i data-feather="user"></i>{{ !empty($support->assignUser)?$support->assignUser->name:__('All') }}</a></li>
                        <li><a href="#" data-bs-toggle="tooltip" data-bs-original-title="{{__('Created Date')}}" ><i data-feather="calendar"></i>{{\Auth::user()->dateFormat($support->created_at)}}</a></li>

                        <li>
                            <a href="#" data-bs-toggle="tooltip" data-bs-original-title="{{__('Priority')}}" >
                                @if($support->priority=='low')
                                    <span
                                        class="badge badge-primary">{{\App\Models\Support::$priority[$support->priority]}}</span>
                                @elseif($support->priority=='medium')
                                    <span
                                        class="badge badge-info">{{\App\Models\Support::$priority[$support->priority]}}</span>
                                @elseif($support->priority=='high')
                                    <span
                                        class="badge badge-warning">{{\App\Models\Support::$priority[$support->priority]}}</span>
                                @elseif($support->priority=='critical')
                                    <span
                                        class="badge badge-danger">{{\App\Models\Support::$priority[$support->priority]}}</span>
                                @endif
                            </a>
                        </li>
                        <li>
                            <a href="#" data-bs-toggle="tooltip" data-bs-original-title="{{__('Status')}}" >
                                @if($support->status=='pending')
                                    <span
                                        class="badge badge-primary">{{\App\Models\Support::$status[$support->status]}}</span>
                                @elseif($support->status=='open')
                                    <span
                                        class="badge badge-info">{{\App\Models\Support::$status[$support->status]}}</span>
                                @elseif($support->status=='close')
                                    <span
                                        class="badge badge-danger">{{\App\Models\Support::$status[$support->status]}}</span>
                                @elseif($support->status=='on_hold')
                                    <span
                                        class="badge badge-warning">{{\App\Models\Support::$status[$support->status]}}</span>
                                @endif
                            </a>
                        </li>
                        <li><a href="{{asset('/storage/upload/support/'.$support->attachment)}}" target="_blank" data-bs-toggle="tooltip" data-bs-original-title="{{__('Attachment')}}" ><i data-feather="download"></i></a></li>
                    </ul>
                    <p>{{$support->description}}</p>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fa fa-commenting mr-10"></i>{{__('Comments')}}</h4>
                </div>
                <div class="card-body">
                    <ul class="blgcomment-list">
                        @foreach($support->reply as $reply)
                            @if($reply->user_id!=\Auth::user()->id)
                        <li>
                            <div class="comment-item">
                                <div class="media">
                                    <img class="img-fluid " src="{{(!empty($reply->user) && !empty($reply->user->profile))?asset(Storage::url('upload/profile')).'/'.$reply->user->profile:asset(Storage::url('upload/profile')).'/avatar.png'}}" alt="">
                                    <div class="media-body">
                                        <a href="#">
                                            <h5>{{!empty($reply->user)?$reply->user->name:''}}<span class="comment-time">    <i class="fa fa-calendar"></i>{{\Auth::user()->dateFormat($reply->created_at)}}</span></h5>
                                        </a>

                                        <p>  {{$reply->description}}</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                            @else
                        <li class="reply-comment">
                            <div class="comment-item">
                                <div class="media">
                                    <img class="img-fluid" src="{{(!empty($reply->user) && !empty($reply->user->profile))?asset(Storage::url('upload/profile')).'/'.$reply->user->profile:asset(Storage::url('upload/profile')).'/avatar.png'}}" alt="">
                                    <div class="media-body">
                                        <a href="#">
                                            <h5> {{!empty($reply->user)?$reply->user->name:''}} <span class="comment-time">    <i class="fa fa-calendar"></i>{{\Auth::user()->dateFormat($reply->created_at)}}</span></h5>
                                        </a>

                                        <p>  {{$reply->description}}</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @if($support->status == 'open')
        <div class="col-md-12">
            <div class="card addblg-comment">
                <div class="card-header">
                    <h4> <i class="fa fa-plus-square mr-10"></i>{{__('Add comment')}}</h4>
                </div>
                <div class="card-body">
                    {{Form::open(array('route'=>array('support.reply',$support->id),'method'=>'post'))}}
                        <div class="form-group">
                            <textarea class="form-control" rows="5" name="comment" placeholder="{{__('write a comment...')}}"></textarea>
                        </div>
                        <div class="form-group mb-0"><button type="submit" class="btn btn-primary">{{__('Add Comment')}}</button></div>
                    {{Form::close()}}
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection

