@extends('layouts.app')
@section('page-title')
    {{__('Note')}}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard')}}"><h1>{{__('Dashboard')}}</h1></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">{{__('Note')}}</a>
        </li>
    </ul>
@endsection
@section('card-action-btn')
    @if(Gate::check('create note') || \Auth::user()->type=='super admin')
        <a class="btn btn-primary btn-sm ml-20 customModal" href="#" data-size="md"
           data-url="{{ route('note.create') }}"
           data-title="{{__('Create Note')}}"> <i class="ti-plus mr-5"></i>{{__('Create Note')}}</a>
    @endif
@endsection
@section('content')
    <div class="row">
        @foreach($notes as $note)
            <div class="col-xl-4 col-sm-6 cdx-xl-50">
                <div class="card blog-wrapper">
                    <div class="detailwrapper">
                        <a href="#">
                            <h4>{{$note->title}}</h4>
                        </a>
                        <ul class="blogsoc-list">
                            <li><a href="#"><i
                                        data-feather="calendar"></i>{{\Auth::user()->dateFormat($note->created_at)}}</a>
                            </li>
                            <li><a href="{{asset('/storage/upload/applicant/attachment/'.$note->attachment)}}"
                                   target="_blank"><i data-feather="download"></i>{{__('Attachment')}}</a></li>
                        </ul>
                        <p>{{$note->description}}</p>
                        @if(Gate::check('edit notes') || Gate::check('delete notes') || \Auth::user()->type=='super admin')
                            <div class="blog-footer">
                                {!! Form::open(['method' => 'DELETE', 'route' => ['note.destroy', $note->id]]) !!}
                                <div class="date-info">
                                    @if(Gate::check('edit note') || \Auth::user()->type=='super admin')
                                        <a class="text-success customModal" data-bs-toggle="tooltip"
                                           data-bs-original-title="{{__('Edit')}}" href="#"
                                           data-url="{{ route('note.edit',$note->id) }}"
                                           data-title="{{__('Edit Note')}}">
                                            <i data-feather="edit"></i></a>
                                    @endif
                                    @if(Gate::check('delete note') || \Auth::user()->type=='super admin')
                                        <a class=" text-danger confirm_dialog" data-bs-toggle="tooltip"
                                           data-bs-original-title="{{__('Detete')}}" href="#"> <i
                                                data-feather="trash-2"></i></a>
                                    @endif
                                </div>
                                {!! Form::close() !!}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

