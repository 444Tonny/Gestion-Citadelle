@extends('layouts.app')
@section('page-title')
    {{__('Maintenance Request')}}
@endsection
@push('script-page')

@endpush
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard')}}"><h1>{{__('Dashboard')}}</h1></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">{{__('Maintenance Request')}}</a>
        </li>
    </ul>
@endsection
@section('card-action-btn')
    @can('create maintenance request')
        <a class="btn btn-primary btn-sm ml-20 customModal" href="#" data-size="lg"
           data-url="{{ route('maintenance-request.create') }}"
           data-title="{{__('Create Maintenance Request')}}"> <i
                class="ti-plus mr-5"></i>{{__('Create Maintenance Request')}}</a>
    @endcan
@endsection
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="display dataTable cell-border datatbl-advance">
                        <thead>
                        <tr>
                            <th>{{__('Property')}}</th>
                            <th>{{__('Unit')}}</th>
                            <th>{{__('Issue')}}</th>
                            <th>{{__('Maintainer')}}</th>
                            <th>{{__('Request Date')}}</th>
                            <th>{{__('Status')}}</th>
                            <th>{{__('Attachment')}}</th>
                            @if(Gate::check('edit maintenance request') || Gate::check('delete maintenance request') || Gate::check('show maintenance request'))
                                <th class="text-right">{{__('Action')}}</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($maintenanceRequests as $request)
                            <tr role="row">
                                <td> {{!empty($request->properties)?$request->properties->name:'-'}} </td>
                                <td> {{!empty($request->units)?$request->units->name:'-'}} </td>
                                <td> {{!empty($request->types)?$request->types->title:'-'}} </td>
                                <td> {{!empty($request->maintainers)?$request->maintainers->name:'-'}} </td>
                                <td> {{\Auth::user()->dateFormat($request->request_date)}} </td>
                                <td>
                                    @if($request->status=='pending')
                                        <span
                                            class="badge badge-warning"> {{\App\Models\MaintenanceRequest::$status[$request->status]}}</span>
                                    @elseif($request->status=='in_progress')
                                        <span
                                            class="badge badge-info"> {{\App\Models\MaintenanceRequest::$status[$request->status]}}</span>
                                    @else
                                        <span
                                            class="badge badge-primary"> {{\App\Models\MaintenanceRequest::$status[$request->status]}}</span>
                                    @endif
                                </td>
                                <td>
                                    @if(!empty($request->issue_attachment))
                                        <a href="{{asset(Storage::url('upload/issue_attachment')).'/'.$request->issue_attachment}}"
                                           download="download"><i data-feather="download"></i></a>
                                    @else
                                        -
                                    @endif
                                </td>
                                @if(Gate::check('edit maintenance request') || Gate::check('delete maintenance request') || Gate::check('show maintenance request'))
                                    <td class="text-right">
                                        <div class="cart-action">
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['maintenance-request.destroy', $request->id]]) !!}
                                            @can('show maintenance request')
                                                <a class="text-warning customModal" data-size="lg"
                                                   data-bs-toggle="tooltip"
                                                   data-bs-original-title="{{__('View')}}" href="#"
                                                   data-url="{{ route('maintenance-request.show',$request->id) }}"
                                                   data-title="{{__('Maintenance Request Details')}}"> <i
                                                        data-feather="eye"></i></a>
                                            @endcan
                                            @can('edit maintenance request')
                                                <a class="text-success customModal" data-size="lg"
                                                   data-bs-toggle="tooltip"
                                                   data-bs-original-title="{{__('Edit')}}" href="#"
                                                   data-url="{{ route('maintenance-request.edit',$request->id) }}"
                                                   data-title="{{__('Maintenance Request Expense')}}"> <i
                                                        data-feather="edit"></i></a>
                                            @endcan
                                            @can('delete maintenance request')
                                                <a class=" text-danger confirm_dialog" data-bs-toggle="tooltip"
                                                   data-bs-original-title="{{__('Detete')}}" href="#"> <i
                                                        data-feather="trash-2"></i></a>
                                            @endcan
                                            @if(\Auth::user()->type=='maintainer')
                                                <a class="text-success customModal" data-size="lg"
                                                   data-bs-toggle="tooltip"
                                                   data-bs-original-title="{{__('Status Update')}}" href="#"
                                                   data-url="{{ route('maintenance-request.action',$request->id) }}"
                                                   data-title="{{__('Maintenance Request Status')}}"> <i data-feather="check-square"></i></a>
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

