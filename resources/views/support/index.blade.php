@extends('layouts.app')
@section('page-title')
    {{__('Support')}}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard')}}"><h1>{{__('Dashboard')}}</h1></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">{{__('Support')}}</a>
        </li>
    </ul>
@endsection
@section('card-action-btn')
    @if(Gate::check('create support') || \Auth::user()->type=='super admin')
        <a class="btn btn-primary btn-sm ml-20 customModal" href="#" data-size="md"
           data-url="{{ route('support.create') }}"
           data-title="{{__('Create Support')}}"> <i class="ti-plus mr-5"></i>{{__('Create Support')}}</a>
    @endif
@endsection
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="display dataTable cell-border datatbl-advance">
                        <thead>
                        <tr>
                            <th>{{__('Subject')}}</th>
                            <th>{{__('Attachment')}}</th>
                            <th>{{__('Created Date')}}</th>
                            <th>{{__('Created By')}}</th>
                            <th>{{__('Assign User')}}</th>
                            <th>{{__('Priority')}}</th>
                            <th>{{__('Status')}}</th>
                            @if(Gate::check('edit support') ||  Gate::check('delete support') || Gate::check('reply support') ||  \Auth::user()->type=='super admin')
                                <th class="text-right">{{__('Action')}}</th>
                            @endif

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($supports as $support)
                            <tr role="row">
                                <td>
                                    <a href="{{ route('support.show',\Crypt::encrypt($support->id)) }}"
                                       class="text-body">{{$support->subject}}</a>
                                </td>
                                <td>
                                    @if(!empty($support->attachment))
                                        <a href="{{asset('/storage/upload/support/'.$support->attachment)}}"
                                           download=""><i
                                                data-feather="download"></i></a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    {{\Auth::user()->dateFormat($support->created_at)}}
                                </td>
                                <td>
                                    {{ !empty($support->createdUser)?$support->createdUser->name:'-' }}
                                </td>
                                <td>
                                    {{ !empty($support->assignUser)?$support->assignUser->name:__('All') }}
                                </td>
                                <td>
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
                                </td>
                                <td>
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
                                </td>
                                @if(Gate::check('edit support') ||  Gate::check('delete support') || Gate::check('reply support') ||  \Auth::user()->type=='super admin')
                                    <td class="text-right">
                                        <div class="cart-action">
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['support.destroy', $support->id]]) !!}
                                            @if(Gate::check('reply support') ||  \Auth::user()->type=='super admin')
                                                <a class="text-secondary" data-bs-toggle="tooltip"
                                                   data-bs-original-title="{{__('Replay')}}"
                                                   href="{{ route('support.show',\Crypt::encrypt($support->id)) }}"> <i
                                                        data-feather="send"></i></a>
                                            @endcan

                                            @if($support->created_id == \Auth::user()->id)
                                                @if(Gate::check('edit support') ||  \Auth::user()->type=='super admin')
                                                    <a class="text-success customModal" data-bs-toggle="tooltip"
                                                       data-bs-original-title="{{__('Edit')}}" href="#"
                                                       data-url="{{ route('support.edit',$support->id) }}"
                                                       data-title="{{__('Edit Support')}}"> <i data-feather="edit"></i></a>
                                                @endcan
                                                    @if( Gate::check('delete support') ||  \Auth::user()->type=='super admin')
                                                    <a class=" text-danger confirm_dialog" data-bs-toggle="tooltip"
                                                       data-bs-original-title="{{__('Detete')}}" href="#"> <i
                                                            data-feather="trash-2"></i></a>
                                                @endcan
                                            @endif
                                            {!! Form::close() !!}
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

